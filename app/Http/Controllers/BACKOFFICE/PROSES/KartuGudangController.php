<?php

namespace App\Http\Controllers\BACKOFFICE\PROSES;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class KartuGudangController extends Controller
{
    public function index(){
        $temp = DB::connection($_SESSION['connection'])
            ->table('tbmaster_perusahaan')
            ->select('prs_bulanberjalan','prs_tahunberjalan')
            ->first();

        if($temp->prs_bulanberjalan == null && $temp->prs_tahunberjalan == null){
            $isValid = false;
            $message = 'Tanggal awal periode tidak terdefinisi!';

            return view('BACKOFFICE.PROSES.kartu-gudang')->with(compact(['isValid','message']));
        }
        else{
            $isValid = true;
            $tglPer = '01/'.$temp->prs_bulanberjalan.'/'.$temp->prs_tahunberjalan;

            $divisi = DB::connection($_SESSION['connection'])->table('tbmaster_divisi')
                ->select('div_kodedivisi','div_namadivisi')
                ->where('div_kodeigr',$_SESSION['kdigr'])
                ->get();

            $departement = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
                ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->orderBy('dep_kodedepartement')
                ->get();

            $kategori = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
                ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                ->where('kat_kodeigr',$_SESSION['kdigr'])
                ->orderBy('kat_kodedepartement')
                ->orderBy('kat_kodekategori')
                ->get();

            $plu = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->join('tbmaster_hargabeli','hgb_prdcd','=','prd_prdcd')
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->orderBy('prd_deskripsipanjang')
                ->limit('100')
                ->get();

            $supplier = DB::connection($_SESSION['connection'])->table('tbmaster_supplier')
                ->select('sup_kodesupplier','sup_namasupplier')
                ->orderBy('sup_kodesupplier')
                ->limit(100)
                ->get();

            return view('BACKOFFICE.PROSES.kartu-gudang')->with(compact(['divisi','departement','kategori','plu','supplier','isValid','tglPer']));
        }
    }

    public function checkDivisi(Request $request){
        $cek = DB::connection($_SESSION['connection'])->table('tbmaster_divisi')
            ->select('div_kodedivisi')
            ->where('div_kodeigr',$_SESSION['kdigr'])
            ->where('div_kodedivisi',$request->div)
            ->get();

        if(count($cek) == 0)
            return 'false';
        else{
            $div1 = $request->div1;
            $div2 = $request->div2;

            if($div1 == null && $div2 == null){
                $departement = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
                    ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                    ->where('dep_kodeigr',$_SESSION['kdigr'])
                    ->orderBy('dep_kodedepartement')
                    ->get();
            }
            else if($div1 == null && $div2 != null){
                $departement = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
                    ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                    ->where('dep_kodeigr',$_SESSION['kdigr'])
                    ->where('dep_kodedivisi','<=',$div2)
                    ->orderBy('dep_kodedepartement')
                    ->get();
            }
            else if($div1 != null && $div2 == null){
                $departement = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
                    ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                    ->where('dep_kodeigr',$_SESSION['kdigr'])
                    ->where('dep_kodedivisi','>=',$div1)
                    ->orderBy('dep_kodedepartement')
                    ->get();
            }
            else{
                $departement = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
                    ->select('dep_kodedepartement','dep_namadepartement','dep_kodedivisi')
                    ->where('dep_kodeigr',$_SESSION['kdigr'])
                    ->whereBetween('dep_kodedivisi',[$div1,$div2])
                    ->orderBy('dep_kodedepartement')
                    ->get();
            }

            return $departement;
        }
    }

    public function checkDepartement(Request $request){
        if($request->div1 == ''){
            $cek = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->where('dep_kodedivisi','<=',$request->div2)
                ->where('dep_kodedepartement',$request->dep)
                ->get();
        }
        else if($request->div2 == ''){
            $cek = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->where('dep_kodedivisi','>=',$request->div1)
                ->where('dep_kodedepartement',$request->dep)
                ->get();
        }
        else{
            $cek = DB::connection($_SESSION['connection'])->table('tbmaster_departement')
                ->select('dep_kodedepartement')
                ->where('dep_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('dep_kodedivisi',[$request->div1,$request->div2])
                ->where('dep_kodedepartement',$request->dep)
                ->get();
        }


        if(count($cek) == 0)
            return 'false';
        else{
            $dep1 = $request->dep1;
            $dep2 = $request->dep2;

            if($dep1 == null && $dep2 == null){
                $kategori = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
                    ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                    ->where('kat_kodeigr',$_SESSION['kdigr'])
                    ->orderBy('kat_kodedepartement')
                    ->orderBy('kat_kodekategori')
                    ->get();
            }
            else if($dep1 == null && $dep2 != null){
                $kategori = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
                    ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                    ->where('kat_kodeigr',$_SESSION['kdigr'])
                    ->where('kat_kodedepartement','<=',$dep2)
                    ->orderBy('kat_kodedepartement')
                    ->orderBy('kat_kodekategori')
                    ->get();
            }
            else if($dep1 != null && $dep2 == null){
                $kategori = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
                    ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                    ->where('kat_kodeigr',$_SESSION['kdigr'])
                    ->where('kat_kodedepartement','>=',$dep1)
                    ->orderBy('kat_kodedepartement')
                    ->orderBy('kat_kodekategori')
                    ->get();
            }
            else{
                $kategori = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
                    ->select('kat_kodedepartement','kat_kodekategori','kat_namakategori')
                    ->where('kat_kodeigr',$_SESSION['kdigr'])
                    ->whereBetween('kat_kodedepartement',[$dep1,$dep2])
                    ->orderBy('kat_kodedepartement')
                    ->orderBy('kat_kodekategori')
                    ->get();
            }

            return $kategori;
        }
    }

    public function checkKategori(Request $request){
        $kat = $request->kat;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;

        $cek = DB::connection($_SESSION['connection'])->table('tbmaster_kategori')
            ->select('kat_kodekategori')
            ->where('kat_kodeigr',$_SESSION['kdigr'])
            ->whereBetween('kat_kodedepartement',[$dep1,$dep2])
            ->where('kat_kodekategori',$kat)
            ->get();

        if(count($cek) == 0)
            return 'false';
        else{
            $plu = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
                ->select('prd_prdcd','prd_deskripsipanjang','prd_unit','prd_frac')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereBetween('prd_kodedivisi',[$div1,$div2])
                ->whereBetween('prd_kodedepartement',[$dep1,$dep2])
                ->whereBetween('prd_kodekategoribarang',[$kat1,$kat2])
                ->orderBy('prd_deskripsipanjang')
                ->limit('100')
                ->get();

            return $plu;
        }
    }

    public function getLovPLU(Request $request){
        $search = $request->plu;

        if($search == ''){
            $produk = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_prodmast"))
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->orderBy('prd_prdcd')
                ->limit(100)
                ->get();
        }
        else if(is_numeric($search)){
            $produk = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_prodmast"))
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_prdcd','like',DB::RAW("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->get();
        }
        else{
            $produk = DB::connection($_SESSION['connection'])->table(DB::RAW("tbmaster_prodmast"))
                ->select('prd_deskripsipanjang','prd_prdcd')
                ->where('prd_kodeigr',$_SESSION['kdigr'])
                ->whereRaw("substr(prd_prdcd,7,1) = '0'")
                ->where('prd_deskripsipanjang','like',DB::RAW("'%".$search."%'"))
                ->orderBy('prd_prdcd')
                ->get();
        }

        return DataTables::of($produk)->make(true);
    }

    public function checkPLU(Request $request){
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $plu = $request->plu;

        $plu = DB::connection($_SESSION['connection'])->table('tbmaster_prodmast')
            ->select('prd_prdcd')
            ->where('prd_kodeigr',$_SESSION['kdigr'])
            ->whereBetween('prd_kodedivisi',[$div1,$div2])
            ->whereBetween('prd_kodedepartement',[$dep1,$dep2])
            ->whereBetween('prd_kodekategoribarang',[$kat1,$kat2])
            ->where('prd_prdcd','=',$plu)
            ->orderBy('prd_deskripsipanjang')
            ->first();

        if($plu){
            return response()->json([
                'found' => true,
                'plu' => $plu->prd_prdcd
            ], 200);
        }
        else{
            return response()->json([
                'found' => false,
                'message' => 'PLU tidak ditemukan!'
            ], 500);
        }
    }

    public function process(Request $request){
        try{
            DB::connection($_SESSION['connection'])->beginTransaction();

            $periode1 = $request->periode1;
            $periode2 = $request->periode2;
            $div1 = $request->div1;
            $div2 = $request->div2;
            $dep1 = $request->dep1;
            $dep2 = $request->dep2;
            $kat1 = $request->kat1;
            $kat2 = $request->kat2;
            $plu1 = $request->plu1;
            $plu2 = $request->plu2;
            $tglPer = $request->tglPer;

            $data = DB::connection($_SESSION['connection'])
                ->selectOne("SELECT count(*)
                FROM TBMASTER_STOCK, TBMASTER_PRODMAST
                WHERE ST_KODEIGR = '".$_SESSION['kdigr']."'
                AND ST_PRDCD BETWEEN '".$plu1."' AND '".$plu2."'
                AND NVL(ST_RECORDID,'9') <> '1' AND ST_LOKASI = '01'
                AND PRD_KODEIGR = ST_KODEIGR AND PRD_PRDCD = ST_PRDCD
                AND PRD_KODEDIVISI BETWEEN '".$div1."' AND '".$div2."'
                AND PRD_KODEDEPARTEMENT BETWEEN '".$dep1."' AND '".$dep2."'
                AND PRD_KODEKATEGORIBARANG BETWEEN '".$kat1."' AND '".$kat2."'
                AND ROWNUM <= 1");

            if(!$data){
                return response()->json([
                    'message' => 'Tidak ada data yang bisa diproses!',
                    'detail' => ''
                ], 500);
            }
            else{
                DB::connection($_SESSION['connection'])
                    ->table('tbtemp_kartugudang')
                    ->truncate();

                DB::connection($_SESSION['connection'])->commit();

                $c = loginController::getConnectionProcedure();
                $s = oci_parse($c, "BEGIN
                                            SP_KARTU_GUDANG_MIGRASI(
                                            '".$_SESSION['kdigr']."',
                                            to_date('".$periode1."','dd/mm/yyyy'),
                                            to_date('".$periode2."','dd/mm/yyyy'),
                                            to_date('".$tglPer."','dd/mm/yyyy'),
                                            '".$plu1."',
                                            '".$plu2."',
                                            '".$div1."',
                                            '".$div2."',
                                            '".$dep1."',
                                            '".$dep2."',
                                            '".$kat1."',
                                            '".$kat2."',
                                            :p_sukses,
                                            :err_txt
                                            );
                                            END;");
                oci_bind_by_name($s, ':p_sukses', $p_sukses, 10);
                oci_bind_by_name($s, ':err_txt', $err, 1000);
                oci_execute($s);

                if($p_sukses == 'TRUE'){
                    return response()->json([
                        'message' => 'Proses kartu gudang berhasil!',
                        'detail' => ''
                    ], 200);
                }
                else{
                    return response()->json([
                        'message' => 'Proses kartu gudang gagal!',
                        'detail' => $err
                    ], 500);
                }
            }
        }
        catch (\Exception $e){
            DB::connection($_SESSION['connection'])->rollBack();

            return response()->json([
                'message' => 'Terjadi kesalahan!',
                'detail' => $e->getMessage()
            ], 500);
        }
    }

    public function printRekap(Request $request){
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $plu1 = $request->plu1;
        $plu2 = $request->plu2;
        $tglPer = $request->tglPer;

        $perusahaan = DB::connection($_SESSION['connection'])
            ->table("tbmaster_perusahaan")
            ->first();

        $data = DB::connection($_SESSION['connection'])
            ->select("select to_char(tgl,'dd/mm/yyyy') tgl, ktg_prdcd, prd_deskripsipanjang, frac1, kemasan,
    frac, ktg_qtyawal, saq1, saf1, sum(qintr) qintr, sum(gintr) gintr, sum(item) item,
    sum(ktg_qty) qty, sum(saqty) saqty, SUM(asaqty) asaqty, SUM(bsaqty) bsaqty,
    SUM(csaqty) csaqty, SUM(dsaqty) dsaqty, SUM(fsaqty) fsaqty, SUM(gsaqty) gsaqty,
    SUM(hsaqty) hsaqty, SUM(isaqty) isaqty
from (
    select ktg_nodokumen, TRUNC(ktg_tgl) tgl, ktg_prdcd,
        prd_deskripsipanjang, prd_frac frac, prd_frac frac1, 1 item,
        prd_unit||'/'||prd_frac kemasan, ktg_qty, ktg_qtyawal,
        trunc(ktg_qtyawal / prd_frac) saq1, mod(ktg_qtyawal, prd_frac) saf1,
                 CASE  WHEN ktg_typetrn = 'N'
                 THEN ktg_qty
                 ELSE 0
                 END qintr,
                 CASE  WHEN ktg_typetrn = 'N'
                 THEN ktg_qty
                 ELSE 0
                 END gintr,
                 CASE  WHEN ktg_typetrn = 'N' OR ktg_typetrn = 'S'
                     OR ((ktg_typetrn = 'T' AND ktg_lokasi = '77') OR ktg_typetrn = 'O')
                     OR (ktg_typetrn = 'P' AND ktg_flagdisc1 = 'P')
                     OR (ktg_typetrn = 'Z' AND ktg_flagdisc1 = 'B')
                     OR (ktg_typetrn = 'H' AND ktg_flagdisc1 = '1')
                    THEN ktg_qty * (-1)
                 ELSE CASE  WHEN (ktg_typetrn = 'B' AND ktg_supplier IS NOT NULL)
                     OR (   (ktg_typetrn = 'B' AND ktg_supplier IS NULL)
                          OR (ktg_typetrn = 'L' OR ktg_typetrn = 'I'))
                     OR (ktg_typetrn = 'D')
                     OR (ktg_typetrn = 'T' AND ktg_lokasi <> '77')
                     OR (ktg_typetrn = 'P' AND ktg_flagdisc1 = 'R')
                     OR (ktg_typetrn = 'X')
                     OR (ktg_typetrn = 'Z' AND ktg_flagdisc2 = 'B')
                         THEN ktg_qty
                     ELSE 0
                 END
                 END saqty,
                 CASE  WHEN ktg_typetrn = 'B' AND ktg_supplier IS NOT NULL
                     THEN ktg_qty
                 ELSE 0
                 END asaqty,
                 CASE  WHEN (ktg_typetrn = 'B' AND ktg_supplier IS NULL)
                        OR   (ktg_typetrn = 'L' OR ktg_typetrn = 'I')
                         OR (ktg_typetrn = 'Z' AND ktg_flagdisc2 = 'B')
                     THEN ktg_qty
                 ELSE 0
                 END bsaqty,
                 CASE  WHEN ktg_typetrn = 'D'
                     THEN ktg_qty
                 ELSE 0
                 END csaqty,
                 CASE  WHEN ktg_typetrn = 'S'
                     THEN ktg_qty
                 ELSE 0
                 END dsaqty,
                 CASE   WHEN (ktg_typetrn = 'T' AND ktg_lokasi = '77')
                         OR   ktg_typetrn = 'O'
                         OR (ktg_typetrn = 'P' AND ktg_flagdisc1 = 'P')
                         OR (ktg_typetrn = 'Z' AND ktg_flagdisc1 = 'B')
                         OR (ktg_typetrn = 'H' AND ktg_flagdisc1 = '1')
                     THEN ktg_qty
                 ELSE 0
                 END fsaqty,
                 CASE   WHEN (ktg_typetrn = 'T' AND ktg_lokasi <> '77')
                     OR (ktg_typetrn = 'P' AND ktg_flagdisc1 = 'R')
                    THEN ktg_qty
                 ELSE 0
                 END gsaqty,
                 CASE  WHEN ktg_typetrn = 'P' AND ktg_flagdisc1 = 'P'
                     THEN ktg_qty
                  ELSE 0
                 END hsaqty,
                 CASE  WHEN ktg_typetrn = 'X'
                     THEN ktg_qty
                 ELSE 0
                 END isaqty,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
    from tbtemp_kartugudang, tbmaster_prodmast, tbmaster_perusahaan
    where ktg_kodeigr = '".$_SESSION['kdigr']."'
        and TRUNC(ktg_tgl) BETWEEN TRUNC(to_date('".$periode1."','dd/mm/yyyy')) and TRUNC(to_date('".$periode2."','dd/mm/yyyy'))
        and ktg_prdcd BETWEEN '".$plu1."' and '".$plu2."'
        and prd_prdcd(+)=ktg_prdcd
        and prd_kodeigr(+)=ktg_kodeigr
        and prs_kodeigr=ktg_kodeigr
        and (ktg_divisi||ktg_departement||ktg_kategori between '".$div1.$dep1.$kat1."' and '".$div2.$dep2.$kat2."')
       )
group by tgl, ktg_prdcd, prd_deskripsipanjang, frac1,
    kemasan, frac, prs_namaperusahaan, prs_namacabang,
    prs_namawilayah, ktg_qtyawal, saq1, saf1
order by ktg_prdcd, tgl");

//        dd($data);

        return view('BACKOFFICE.PROSES.kartu-gudang-rekap-pdf',compact(['perusahaan','data','periode1','periode2']));
    }

    public function printDetail(Request $request){
        $periode1 = $request->periode1;
        $periode2 = $request->periode2;
        $div1 = $request->div1;
        $div2 = $request->div2;
        $dep1 = $request->dep1;
        $dep2 = $request->dep2;
        $kat1 = $request->kat1;
        $kat2 = $request->kat2;
        $plu1 = $request->plu1;
        $plu2 = $request->plu2;
        $tglPer = $request->tglPer;

        $perusahaan = DB::connection($_SESSION['connection'])
            ->table("tbmaster_perusahaan")
            ->first();

        $data = DB::connection($_SESSION['connection'])
            ->select("select ktg_nodokumen, ktg_tgl, to_char(ktg_tgl,'dd/mm/yyyy') tgl, ktg_kasir,
    ktg_station, ktg_prdcd, prd_deskripsipanjang,
    kemasan, prs_namaperusahaan,
    prs_namacabang, prs_namawilayah, frac, ktg_qtyawal,
    saq1, saf1, sum(qintr) qintr, sum(item) item, sum(ktg_qty) qty, frac1,
    sum(saqty) saqty, SUM(inq1) inq1, SUM(inq2) inq2, SUM(inq3) inq3,
    SUM(inq4) inq4, SUM(outq1) outq1, SUM(outq3) outq3
from (
    select ktg_nodokumen, ktg_tgl, ktg_prdcd, ktg_kasir,
        ktg_station, prd_deskripsipanjang, prd_frac frac, prd_frac frac1,
        prd_unit||'/'||prd_frac kemasan, ktg_qty, ktg_qtyawal,  1 item,
        trunc(ktg_qtyawal / prd_frac) saq1, mod(ktg_qtyawal, prd_frac) saf1,
                 CASE  WHEN ktg_typetrn = 'N'
                 THEN ktg_qty
                 ELSE 0
                 END qintr,
                 CASE  WHEN ktg_typetrn = 'N' OR ktg_typetrn = 'S'
                     OR ((ktg_typetrn = 'T' AND ktg_lokasi = '77') OR ktg_typetrn = 'O')
                     OR (ktg_typetrn = 'P' AND ktg_flagdisc1 = 'P')
                     OR (ktg_typetrn = 'Z' AND ktg_flagdisc1 = 'B')
                     OR (ktg_typetrn = 'H' AND ktg_flagdisc1 = '1')
                    THEN ktg_qty * (-1)
                 ELSE CASE
                     WHEN (ktg_typetrn = 'B' AND ktg_supplier IS NOT NULL)
                     OR (   (ktg_typetrn = 'B' AND ktg_supplier IS NULL)
                          OR (ktg_typetrn = 'L' OR ktg_typetrn = 'I'))
                     OR (ktg_typetrn = 'D')
                     OR (ktg_typetrn = 'T' AND ktg_lokasi <> '77')
                     OR (ktg_typetrn = 'P' AND ktg_flagdisc1 = 'R')
                     OR (ktg_typetrn = 'X')
                     OR (ktg_typetrn = 'Z' AND ktg_flagdisc2 = 'B')
                         THEN ktg_qty
                     ELSE 0
                 END
                 END saqty,
                 CASE  WHEN ktg_typetrn = 'B' AND ktg_supplier IS NOT NULL
                     THEN ktg_qty
                 ELSE 0
                 END inq1,
                 CASE  WHEN (ktg_typetrn = 'B' AND ktg_supplier IS NULL)
                         OR   (ktg_typetrn = 'L' OR ktg_typetrn = 'I')
                         OR (ktg_typetrn = 'T' AND ktg_lokasi <> '77')
                         OR (ktg_typetrn = 'P' AND ktg_flagdisc1 = 'R')
                         OR (ktg_typetrn = 'Z' AND ktg_flagdisc2 = 'B')
                     THEN ktg_qty
                 ELSE 0
                 END inq3,
                 CASE  WHEN ktg_typetrn = 'D'
                     THEN ktg_qty
                 ELSE 0
                 END inq2,
                 CASE  WHEN ktg_typetrn = 'S'
                     THEN ktg_qty
                 ELSE 0
                 END outq1,
                 CASE   WHEN (ktg_typetrn = 'T' AND ktg_lokasi = '77')
                         OR   ktg_typetrn = 'O'
                         OR (ktg_typetrn = 'P' AND ktg_flagdisc1 = 'P')
                         OR (ktg_typetrn = 'Z' AND ktg_flagdisc1 = 'B')
                         OR (ktg_typetrn = 'H' AND ktg_flagdisc1 = '1')
                     THEN ktg_qty
                 ELSE 0
                 END outq3,
                 CASE  WHEN ktg_typetrn = 'X'
                     THEN ktg_qty
                 ELSE 0
                 END inq4,
        prs_namaperusahaan, prs_namacabang, prs_namawilayah
    from tbtemp_kartugudang, tbmaster_prodmast, tbmaster_perusahaan
    where ktg_kodeigr = '".$_SESSION['kdigr']."'
        and TRUNC(ktg_tgl) BETWEEN TRUNC(to_date('".$periode1."','dd/mm/yyyy')) and TRUNC(to_date('".$periode2."','dd/mm/yyyy'))
        and ktg_prdcd BETWEEN '".$plu1."' and '".$plu2."'
        and prd_prdcd(+)=ktg_prdcd
        and prd_kodeigr(+)=ktg_kodeigr
        and prs_kodeigr=ktg_kodeigr
       and (ktg_divisi||ktg_departement||ktg_kategori between '".$div1.$dep1.$kat1."' and '".$div2.$dep2.$kat2."')
       )
group by ktg_nodokumen, ktg_tgl, ktg_kasir,
    ktg_station, ktg_prdcd, prd_deskripsipanjang,
    kemasan, frac, frac1, prs_namaperusahaan,
    prs_namacabang, prs_namawilayah, ktg_qtyawal, saq1, saf1
order by ktg_prdcd, ktg_tgl, ktg_nodokumen, ktg_kasir, ktg_station");

//        dd($data);

        return view('BACKOFFICE.PROSES.kartu-gudang-detail-pdf',compact(['perusahaan','data','periode1','periode2']));
    }
}
