<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\KIRIMCABANG;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class InputController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.KIRIMCABANG.input');
    }

    public function getDataLovTrn()
    {
        $lov = DB::connection(Session::get('connection'))->table('tbtr_backoffice')
            ->selectRaw("TRBO_NODOC,TO_CHAR(TRBO_TGLDOC, 'DD/MM/YYYY') TRBO_TGLDOC,
                    CASE
                        WHEN TRBO_FLAGDOC='*' THEN TRBO_NONOTA
                        ELSE 'Belum Cetak Nota'
                    END NOTA")
            ->where('trbo_typetrn', 'O')
            ->orderBy('trbo_nodoc', 'desc')
            ->distinct()
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function getDataLovCabang()
    {
        $lov = DB::connection(Session::get('connection'))->table('tbmaster_cabang')
            ->select('cab_kodecabang', 'cab_namacabang', 'cab_kodewilayah')
            ->where('cab_kodeigr', Session::get('kdigr'))
            ->orderBy('cab_kodecabang')
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function getDataLovPlu()
    {
        $lov = DB::connection(Session::get('connection'))->table('tbmaster_prodmast')
            ->selectRaw("PRD_PRDCD, PRD_UNIT||'/'||TO_CHAR(PRD_FRAC) SATUAN, PRD_DESKRIPSIPANJANG")
            ->where('prd_kodeigr', Session::get('kdigr'))
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1)='0'")
            ->whereRaw("nvl(prd_recordid,9)<>1")
            ->orderBy('prd_prdcd')
            ->limit(200)
            ->get();

        return DataTables::of($lov)->make(true);
    }

    public function getDataLovIpb()
    {
        $kodeigr = Session::get('kdigr');
        $lov = DB::connection(Session::get('connection'))->select("SELECT DISTINCT
                IPB_NOIPB,IPB_TGLIPB,IPB_KODECABANG2,CAB_NAMACABANG
                FROM TBTR_IPB,TBMASTER_CABANG
                WHERE IPB_KODECABANG2=CAB_KODECABANG AND
                    CAB_KODEIGR = '$kodeigr' AND
                    IPB_KODEIGR = '$kodeigr' AND
                    IPB_KODECABANG1 = '$kodeigr' AND
                    (NVL(IPB_RECORDID,' ') = ' ' OR IPB_RECORDID IS NULL)
                ORDER BY IPB_NOIPB");

        return DataTables::of($lov)->make(true);
    }

    public function getNewNoTrn()
    {
        $ip = Session::get('ip');

        $arrip = explode('.', $ip);

        $c = loginController::getConnectionProcedure();
        $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('" . Session::get('kdigr') . "','SJK','Nomor Surat Jalan'," . $arrip[3] . "||'3',6,FALSE); END;");
        oci_bind_by_name($s, ':ret', $no, 32);
        oci_execute($s);

        DB::connection(Session::get('connection'))->table('tbtr_tac')
            ->where('tac_kodeigr', Session::get('kdigr'))
            ->where('tac_nodoc', $no)
            ->delete();

        return $no;
    }

    public function getDataTrn(Request $request)
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT TRBO_NODOC, TO_CHAR(TRBO_TGLDOC, 'DD/MM/YYYY') TRBO_TGLDOC, TRBO_PRDCD,
                    TRBO_QTY, TRBO_HRGSATUAN, TRBO_PPNRPH, TRBO_LOC, TRBO_GROSS, TRBO_GDG, TRBO_FLAGDOC,
                    TRBO_KETERANGAN, PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT, PRD_AVGCOST,
	                PRD_KODETAG,ST_SALDOAKHIR,PRD_FLAGBKP1, CAB_NAMACABANG
                    FROM TBTR_BACKOFFICE TRBO,TBMASTER_PRODMAST,TBMASTER_STOCK, TBMASTER_CABANG
                    WHERE TRBO_PRDCD = PRD_PRDCD AND
                        TRBO_KODEIGR = PRD_KODEIGR AND
                        PRD_PRDCD = ST_PRDCD(+) AND
                        PRD_KODEIGR = ST_KODEIGR(+) AND
                        ST_LOKASI(+)='01' AND
                        CAB_KODECABANG = TRBO_LOC AND
                        TRBO_KODEIGR = '" . Session::get('kdigr') . "' AND
                        TRBO_NODOC = '" . $request->notrn . "' AND
                        TRBO_TYPETRN='O'
                    ORDER BY TRBO_PRDCD");

        return $data;
    }

    public function deleteTrn(Request $request)
    {
        try {
            DB::connection(Session::get('connection'))->beginTransaction();

            DB::connection(Session::get('connection'))->table('tbtr_tac')
                ->where('tac_kodeigr', Session::get('kdigr'))
                ->where('tac_nodoc', $request->notrn)
                ->delete();

            DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                ->where('trbo_typetrn', 'O')
                ->where('trbo_nodoc', $request->notrn)
                ->delete();

            DB::connection(Session::get('connection'))->commit();

            $status = 'success';
            $title = 'Berhasil menghapus data ' . $request->notrn;
            $message = '';
        } catch (QueryException $e) {
            DB::connection(Session::get('connection'))->rollBack();

            $status = 'error';
            $title = 'Gagal menghapus data ' . $request->notrn;
            $message = $e->getMessage();
        }

        return compact(['status', 'title', 'message']);
    }

    public function getDataPlu(Request $request)
    {
        $data = DB::connection(Session::get('connection'))->selectOne("SELECT PRD_DESKRIPSIPENDEK,PRD_DESKRIPSIPANJANG,PRD_FRAC,PRD_UNIT,PRD_KODETAG,
                                    PRD_AVGCOST,ST_AVGCOST,PRD_FLAGBKP1,ST_SALDOAKHIR
                                  FROM TBMASTER_PRODMAST,TBMASTER_STOCK
                                  WHERE PRD_KODEIGR = ST_KODEIGR(+) AND
                                      PRD_PRDCD = ST_PRDCD(+) AND
                                      PRD_KODEIGR = '" . Session::get('kdigr') . "' AND
                                      ST_LOKASI(+)='01' AND PRD_PRDCD='" . $request->prdcd . "'");

        return response()->json($data);
    }

    public function getDataLKS(Request $request)
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT   LKS_KODEIGR KODEIGR, LKS_PRDCD PRDCD,
            LKS_KODERAK
         || '.'
         || LKS_KODESUBRAK
         || '.'
         || LKS_TIPERAK
         || '.'
         || LKS_SHELVINGRAK
         || '.'
         || LKS_NOURUT LOKASI,
         LKS_QTY - NVL (SPB_MINUS, 0) QTY, PRD_FRAC FRAC,
         TRUNC ((LKS_QTY - NVL (SPB_MINUS, 0)) / PRD_FRAC) QTY_CTN,
         MOD ((LKS_QTY - NVL (SPB_MINUS, 0)), PRD_FRAC) QTY_PCS, TO_CHAR(LKS_EXPDATE,'DD/MM/YYYY') LKS_EXPDATE, LKS_MAXPLANO
    FROM TBMASTER_LOKASI,
         (SELECT   SPB_LOKASIASAL, SPB_PRDCD, SUM (SPB_MINUS) SPB_MINUS
              FROM TBTEMP_ANTRIANSPB
             WHERE SPB_RECORDID IS NULL
          GROUP BY SPB_LOKASIASAL, SPB_PRDCD),
         TBMASTER_PRODMAST A
   WHERE LKS_KODEIGR = PRD_KODEIGR
     AND LKS_PRDCD = PRD_PRDCD
     AND LKS_PRDCD = SPB_PRDCD(+)
     AND    LKS_KODERAK
         || '.'
         || LKS_KODESUBRAK
         || '.'
         || LKS_TIPERAK
         || '.'
         || LKS_SHELVINGRAK
         || '.'
         || LKS_NOURUT = SPB_LOKASIASAL(+)
     AND LKS_QTY > 0
     AND LKS_PRDCD = '" . $request->prdcd . "'
ORDER BY PRDCD,
         LKS_TIPERAK,
         TRANSLATE (LKS_KODERAK, 'GS', '12'),
         LKS_KODESUBRAK,
         LKS_SHELVINGRAK,
         LKS_NOURUT DESC,
         LOKASI ");

        return $data;
    }

    public function saveDataLKS(Request $request)
    {
        $lokasi = $request->lokasi;
        $ctn = $request->ctn;
        $pcs = $request->pcs;

        $prdcd = $request->prdcd;
        $frac = $request->frac;
        $nodoc = $request->nodoc;

        $insert = [];

        for ($i = 0; $i < count($lokasi); $i++) {
            $ins = [];
            $ins['tac_kodeigr'] = Session::get('kdigr');
            $ins['tac_nodoc'] = $nodoc;
            $ins['tac_prdcd'] = $prdcd;
            $ins['tac_lokasi'] = $lokasi[$i];
            $ins['tac_qty'] = ($frac * $ctn[$i]) + $pcs[$i];
            $ins['tac_create_by'] = Session::get('usid');
            $ins['tac_create_dt'] = Carbon::now();

            if ($ins['tac_qty'] > 0)
                $insert[] = $ins;
        }

        try {
            DB::connection(Session::get('connection'))->beginTransaction();

            DB::connection(Session::get('connection'))->table('tbtr_tac')
                ->where('tac_kodeigr', Session::get('kdigr'))
                ->where('tac_nodoc', $nodoc)
                ->where('tac_prdcd', $prdcd)
                ->delete();

            DB::connection(Session::get('connection'))->table('tbtr_tac')
                ->insert($insert);

            DB::connection(Session::get('connection'))->commit();
        } catch (QueryException $e) {
            DB::connection(Session::get('connection'))->rollBack();

            $status = 'error';
            $message = $e->getMessage();

            return compact(['status', 'message']);
        }
    }

    public function deleteDataLKS(Request $request)
    {
        $prdcd = $request->prdcd;
        $nodoc = $request->nodoc;

        try {
            DB::connection(Session::get('connection'))->beginTransaction();

            DB::connection(Session::get('connection'))->table('tbtr_tac')
                ->where('tac_kodeigr', Session::get('kdigr'))
                ->where('tac_nodoc', $nodoc)
                ->where('tac_prdcd', $prdcd)
                ->delete();

            DB::connection(Session::get('connection'))->commit();

            $status = 'success';
            $message = '';
        } catch (QueryException $e) {
            DB::connection(Session::get('connection'))->rollBack();

            $status = 'error';
            $message = $e->getMessage();
        }

        return compact(['status', 'message']);
    }

    public function saveDataTrn(Request $request)
    {
        // INPUT
        $nodoc = $request->nodoc;
        $tgldoc = $request->tgldoc;
        $loc = $request->loc;
        $trbo_prdcd = $request->trbo_prdcd;
        $trbo_qty = $request->trbo_qty;
        $trbo_hrgsatuan = $request->trbo_hrgsatuan;
        $trbo_gross = $request->trbo_gross;
        $trbo_ppnrph = $request->trbo_ppnrph;
        $trbo_averagecost = $request->trbo_averagecost;
        $trbo_stokqty = $request->trbo_stokqty;
        $trbo_keterangan = $request->trbo_keterangan;
        // TITIP
        $nosj = $request->nosj;
        $tgleta = $request->tgleta;
        $tgletd = $request->tgletd;
        $kodecabangtitip = $request->kodecabangtitip;
        $namacabangtitip = $request->namacabangtitip;
        $ekspedisi = $request->ekspedisi;
        $seal = $request->seal;
        $nomobil = $request->nomobil;
        $durasi = $request->durasi;
        $tarif = $request->tarif;
        $alamat = $request->alamat;
        $container = $request->container;
        $kapal = $request->kapal;
        $titip_nama_barang = $request->titip_nama_barang;
        $titip_kode = $request->titip_kode;
        $titip_frac = $request->titip_frac;
        $titip_qty = $request->titip_qty;
        $titip_m3 = $request->titip_m3;
        $titip_ton = $request->titip_ton;
        $titip_keterangan_titipan = $request->titip_keterangan_titipan;
        $koli = $request->koli;
        $kodeeks = $request->kodeeks;
        try {
            DB::connection(Session::get('connection'))->beginTransaction();

            $cek = DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                ->where('trbo_nodoc', $nodoc)
                ->where('trbo_typetrn', 'O')
                ->where('trbo_kodeigr', Session::get('kdigr'))
                ->count();

            if ($cek == 0) {
                $ip = Session::get('ip');

                $arrip = explode('.', $ip);

                $c = loginController::getConnectionProcedure();
                $s = oci_parse($c, "BEGIN :ret := F_IGR_GET_NOMORSTADOC('" . Session::get('kdigr') . "','SJK','Nomor Surat Jalan'," . $arrip[3] . "||'3',6,TRUE); END;");
                oci_bind_by_name($s, ':ret', $no, 32);
                oci_execute($s);

                $nodoc = $no;
            } else {
                DB::connection(Session::get('connection'))->table('tbtr_backoffice')
                    ->where('trbo_nodoc', $nodoc)
                    ->where('trbo_typetrn', 'O')
                    ->where('trbo_kodeigr', Session::get('kdigr'))
                    ->delete();

                $tac = DB::connection(Session::get('connection'))->table('tbtr_tac')
                    ->select('tac_prdcd')
                    ->where('tac_kodeigr', Session::get('kdigr'))
                    ->where('tac_nodoc', $nodoc)
                    ->get();

                foreach ($tac as $t) {
                    if (!in_array($t->tac_prdcd, $trbo_prdcd)) {
                        DB::connection(Session::get('connection'))->table('tbtr_tac')
                            ->select('tac_prdcd')
                            ->where('tac_kodeigr', Session::get('kdigr'))
                            ->where('tac_nodoc', $nodoc)
                            ->where('tac_prdcd', $t->tac_prdcd)
                            ->delete();
                    }
                }
            }

            $records = DB::connection(Session::get('connection'))->select("SELECT TAC_NODOC, TAC_PRDCD, TAC_LOKASI, TAC_QTY, LKS_QTY, PRD_DESKRIPSIPANJANG
                FROM TBTR_TAC, TBMASTER_LOKASI, TBMASTER_PRODMAST
                WHERE TAC_LOKASI = LKS_KODERAK || '.' || LKS_KODESUBRAK || '.' || LKS_TIPERAK || '.' || LKS_SHELVINGRAK || '.' || LKS_NOURUT
                AND TAC_PRDCD = LKS_PRDCD
                AND TAC_PRDCD = PRD_PRDCD
                AND TAC_KODEIGR = '" . Session::get('kdigr') . "'
                AND TAC_NODOC = '" . $nodoc . "'");

            foreach ($records as $rec) {
                $temp = DB::connection(Session::get('connection'))->select("SELECT spb_jenis
                FROM TBTR_ANTRIANSPB
                WHERE SPB_JENIS = 'TAC ' || '" . $nodoc . "'
                AND SPB_PRDCD = '" . $rec->tac_prdcd . "'
                AND SPB_LOKASIASAL = '" . $rec->tac_lokasi . "'");

                if (count($temp) == 0) {
                    $seq = DB::connection(Session::get('connection'))->select("SELECT SEQ_SPB.NEXTVAL seq FROM DUAL")[0]->seq;
                    DB::connection(Session::get('connection'))->insert("INSERT INTO TBTR_ANTRIANSPB
                        (SPB_PRDCD, SPB_LOKASIASAL, SPB_LOKASITUJUAN, SPB_JENIS,
                        SPB_CREATE_BY, SPB_CREATE_DT, SPB_QTY, SPB_MINUS,
                        SPB_DESKRIPSI, SPB_ID
                        )
                VALUES ('" . $rec->tac_prdcd . "', '" . $rec->tac_lokasi . "', 'S.T.A.C.'||'" . Session::get('kdigr') . "', 'TAC ' || '" . $rec->tac_nodoc . "',
                        '" . Session::get('usid') . "', SYSDATE, '" . $rec->lks_qty . "', '" . $rec->tac_qty . "',
                        '" . $rec->prd_deskripsipanjang . "', '" . $seq . "' )");

                    DB::connection(Session::get('connection'))->insert("INSERT INTO TBTEMP_ANTRIANSPB
                        (SPB_PRDCD, SPB_LOKASIASAL, SPB_LOKASITUJUAN, SPB_JENIS,
                        SPB_CREATE_BY, SPB_CREATE_DT, SPB_QTY, SPB_MINUS,
                        SPB_DESKRIPSI, SPB_ID
                        )
                VALUES ('" . $rec->tac_prdcd . "', '" . $rec->tac_lokasi . "', 'S.T.A.C.'||'" . Session::get('kdigr') . "', 'TAC ' || '" . $rec->tac_nodoc . "',
                        '" . Session::get('usid') . "', SYSDATE, '" . $rec->lks_qty . "', '" . $rec->tac_qty . "',
                        '" . $rec->prd_deskripsipanjang . "', '" . $seq . "' )");
                } else {
                    DB::connection(Session::get('connection'))->table('tbtr_antrianspb')
                        ->where('spb_jenis', 'TAC ' . $rec->tac_nodoc)
                        ->where('spb_prdcd', $rec->tac_prdcd)
                        ->where('spb_lokasiasal', $rec->tac_lokasi)
                        ->update([
                            'spb_minus' => $rec->tac_qty
                        ]);

                    DB::connection(Session::get('connection'))->table('tbtemp_antrianspb')
                        ->where('spb_jenis', 'TAC ' . $rec->tac_nodoc)
                        ->where('spb_prdcd', $rec->tac_prdcd)
                        ->where('spb_lokasiasal', $rec->tac_lokasi)
                        ->update([
                            'spb_minus' => $rec->tac_qty
                        ]);
                }
            }

            DB::connection(Session::get('connection'))->update("UPDATE TBTR_ANTRIANSPB
                        SET SPB_RECORDID = '2'
                        WHERE SPB_JENIS = 'TAC ' || '" . $nodoc . "'
                        AND NOT EXISTS (
                        SELECT 1
                        FROM TBTR_TAC
                        WHERE TAC_NODOC = '" . $nodoc . "' AND SPB_PRDCD = TAC_PRDCD
                        AND SPB_LOKASIASAL = TAC_LOKASI)");

            DB::connection(Session::get('connection'))->update("UPDATE TBTEMP_ANTRIANSPB
                        SET SPB_RECORDID = '2'
                        WHERE SPB_JENIS = 'TAC ' || '" . $nodoc . "'
                        AND NOT EXISTS (
                        SELECT 1
                        FROM TBTR_TAC
                        WHERE TAC_NODOC = '" . $nodoc . "' AND SPB_PRDCD = TAC_PRDCD
                        AND SPB_LOKASIASAL = TAC_LOKASI)");

            $inserts = [];
            for ($i = 0; $i < count($trbo_prdcd); $i++) {
                $ins = [];
                $ins['trbo_prdcd'] = $trbo_prdcd[$i];
                $ins['trbo_qty'] = $trbo_qty[$i];
                $ins['trbo_hrgsatuan'] = $trbo_hrgsatuan[$i];
                $ins['trbo_gross'] = $trbo_gross[$i];
                $ins['trbo_ppnrph'] = $trbo_ppnrph[$i];
                $ins['trbo_averagecost'] = $trbo_averagecost[$i];
                $ins['trbo_stokqty'] = $trbo_stokqty[$i];
                $ins['trbo_keterangan'] = $trbo_keterangan[$i];

                $ins['trbo_kodeigr'] = Session::get('kdigr');
                $ins['trbo_typetrn'] = 'O';
                $ins['trbo_nodoc'] = $nodoc;
                $ins['trbo_tgldoc'] = DB::connection(Session::get('connection'))->raw("TO_DATE('" . $tgldoc . "','DD/MM/YYYY')");
                $ins['trbo_loc'] = $loc;
                $ins['trbo_create_by'] = Session::get('usid');
                $ins['trbo_create_dt'] = Carbon::now();

                $inserts[] = $ins;
            }

            //            dd($inserts);

            foreach ($inserts as $insert) {
                DB::connection(Session::get('connection'))
                    ->table('tbtr_backoffice')
                    ->insert($insert);
            }

            $inserts_titip = [];
            for ($i = 0; $i < count($titip_kode); $i++) {
                $ins_titip = [];
                $ins_titip['titip_kode'] = $titip_kode[$i];
                $ins_titip['titip_nama_barang'] = $titip_nama_barang[$i];
                $ins_titip['titip_frac'] = $titip_frac[$i];
                $ins_titip['titip_qty'] = $titip_qty[$i];
                $ins_titip['titip_m3'] = $titip_m3[$i];
                $ins_titip['titip_ton'] = $titip_ton[$i];
                $ins_titip['titip_keterangan_titipan'] = $titip_keterangan_titipan[$i];
                $ins_titip['titip_nodoc'] = $nodoc;
                $ins_titip['titip_nosj'] = $nosj;
                $ins_titip['titip_tgletd'] = DB::connection(Session::get('connection'))->raw("TO_DATE('" . $tgletd . "','DD/MM/YYYY')");
                $ins_titip['titip_tgleta'] = DB::connection(Session::get('connection'))->raw("TO_DATE('" . $tgleta . "','DD/MM/YYYY')");
                $ins_titip['titip_kodecabangtitip'] = $kodecabangtitip;
                $ins_titip['titip_namacabangtitip'] = $namacabangtitip;
                $ins_titip['titip_ekspedisi'] = $ekspedisi;
                $ins_titip['titip_seal'] = $seal;
                $ins_titip['titip_nomobil'] = $nomobil;
                $ins_titip['titip_durasi'] = intval($durasi);
                $ins_titip['titip_tarif'] = intval($tarif);
                $ins_titip['titip_alamat'] = $alamat;
                $ins_titip['titip_container'] = $container;
                $ins_titip['titip_kapal'] = $kapal;
                $ins_titip['titip_create_dt'] = Carbon::now()->format('Ymd');
                $ins_titip['titip_modify_dt'] = Carbon::now()->format('Ymd');
                $ins_titip['titip_created_by'] = Session::get('usid');
                $ins_titip['titip_koli'] = $koli;
                $ins_titip['titip_kode_ekspedisi'] = $kodeeks;

                $inserts_titip[] = $ins_titip;
            }

            foreach ($inserts_titip as $insert) {
                DB::connection(Session::get('connection'))
                    ->table('tbtr_titip')
                    ->insert($insert);
            }

            DB::connection(Session::get('connection'))->commit();

            $status = 'success';
            $title = 'Berhasil menyimpan data nomor ' . $nodoc;
            $message = '';
        } catch (QueryException $e) {
            DB::connection(Session::get('connection'))->rollBack();

            $status = 'error';
            $title = 'Gagal menyimpan data nomor ' . $nodoc;
            $message = $e->getMessage();
        }

        return compact(['status', 'title', 'message']);
    }

    public function test()
    {
        DB::connection(Session::get('connection'))->table('tbtr_backoffice')
            ->where('trbo_nodoc', '2343000001')
            ->where('trbo_typetrn', 'O')
            ->where('trbo_kodeigr', Session::get('kdigr'))
            ->delete();
    }

    // Ekspedisi
    public function getDataEks(Request $request)
    {
        $area = $request->area;
        $eks = DB::connection(Session::get('connection'))->table('tbmaster_ekspedisi')
            ->select('xpd_jeniskontainer', 'xpd_kodeekspedisi', 'xpd_namaekspedisi', 'axp_biaya', 'axp_igrtujuan', 'axp_lamakirim')
            ->leftJoin('tbmaster_ekspedisi_area', 'xpd_kodeekspedisi', '=', 'axp_kodeekspedisi')
            ->where('axp_igrtujuan', $area)
            ->orderBy('axp_biaya')
            ->get();

        return compact(['eks']);
    }

    public function getDataCabang(Request $request)
    {
        $area = $request->area;
        $data = DB::connection(Session::get('connection'))->table('tbmaster_cabang')
            ->select('cab_namacabang', 'cab_kodecabang')
            ->where('cab_kodewilayah', $area)
            ->distinct()
            ->orderBy('cab_kodecabang')
            ->get();

        return response()->json(['data' => $data]);
    }
}
