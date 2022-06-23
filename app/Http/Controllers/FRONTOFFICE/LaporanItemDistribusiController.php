<?php

namespace App\Http\Controllers\FRONTOFFICE;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;

class LaporanItemDistribusiController extends Controller
{
    public function index(){

        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.laporan-item-distribusi');
    }

    public function cetak(Request $request)
    {
        $perusahaan = DB::connection(Session::get('connection'))->table('tbmaster_perusahaan')
            ->select('prs_namaperusahaan', 'prs_namacabang')
            ->first();
        $jenis = $request->jenis;
        if(in_array($jenis, ["1","4"])) {
            $bulan = $request->bulan;
            switch ($jenis) {
                case "1":
                    return Self::laporanPembelianPerdanaItemDistribusiTertentu($perusahaan,$jenis,$bulan);
                break;
                case "4":
                    return Self::laporanFrekuensiPenukaranBarangDagangan($perusahaan,$jenis,$bulan);
                break;
            }
        }
        else if(in_array($jenis, ["5","2"])){
            $tgl1 = $request->tgl1;

            switch ($jenis) {
                case "2":
                    return Self::listingReturItemDistribusiTertentu($perusahaan,$jenis,$tgl1);
                    break;
                case "5":
                    return Self::laporanPenyerahanBarangDaganganYangDitukar($perusahaan,$jenis,$tgl1);
                break;
            }
        }
        else{
            $tgl1 = $request->tgl1;
            $tgl2 = $request->tgl2;

            switch ($jenis) {

                case "3":
                    return Self::laporanTransaksiPenukaranBarang($perusahaan,$jenis,$tgl1,$tgl2);
                break;
                // case "5":
                //     return Self::laporanPenyerahanBarangDaganganYangDitukar($perusahaan,$jenis,$tgl1,$tgl2);
                // break;

            }
        }
    }
    //laporan 1
    public function laporanPembelianPerdanaItemDistribusiTertentu($perusahaan,$jenis,$bulan)
    {
        //ambil data transaksi pertama di range penawaran yang ada berdasarkan bulan transaksi

        $data = DB::connection(Session::get('connection'))->select(
            "select t.*
                    from (select t.*,
                                 row_number() over (partition by cus_kodemember,trjd_prdcd order by cus_kodemember asc) as seqnum
                                 from(select  cus_kodemember,jh_cashierid||'/'||jh_cashierstation||'/'||jh_transactionno struk_penjualan,TRUNC(jh_transactiondate) transaction_date,trjd_prdcd,prd_deskripsipendek,prd_unit,trjd_quantity,trjd_nominalamt/trjd_quantity trjd_unitprice,trjd_nominalamt total
                     FROM tbtr_brgdistribusi_hdr
                    JOIN tbtr_brgdistribusi_dtl ON BDH_KODEPROMOSI = BDD_KODEPROMOSI and BDH_FLAGRETUR = 'Y'
                    JOIN (SELECT SUBSTR(trjd_prdcd,1,6)||0 trjd_prdcd,
                        SUM(CASE WHEN prd_unit = 'KG' THEN trjd_quantity ELSE trjd_quantity*prd_frac END) trjd_quantity,trjd_nominalamt,trjd_unitprice,TRJD_TRANSACTIONNO,TRJD_TRANSACTIONDATE ,TRJD_CREATE_BY,TRJD_CASHIERSTATION,trjd_cus_kodemember
                        FROM tbtr_jualdetail JOIN tbmaster_prodmast ON trjd_prdcd = prd_prdcd
                        GROUP BY SUBSTR(trjd_prdcd,1,6)||0,trjd_nominalamt,trjd_unitprice,TRJD_TRANSACTIONNO,TRJD_TRANSACTIONDATE ,TRJD_CREATE_BY,TRJD_CASHIERSTATION,trjd_cus_kodemember) ON trjd_prdcd = bdd_prdcd
                    JOIN tbtr_jualheader ON TRJD_TRANSACTIONNO = JH_TRANSACTIONNO
                        AND TRUNC (TRJD_TRANSACTIONDATE) = TRUNC (JH_TRANSACTIONDATE)
                        AND TRJD_CREATE_BY = JH_CASHIERID
                        AND TRJD_CASHIERSTATION = JH_CASHIERSTATION
                    JOIN (SELECT p.* ,SUBSTR(prd_prdcd,1,6)||'0' plugabung
                    FROM (
                        SELECT ROW_NUMBER ()
                                  OVER (PARTITION BY SUBSTR (prd_prdcd, 1, 6) ORDER BY prd_prdcd ASC)
                                  AS seqnum,
                               prd_prdcd,
                               prd_deskripsipendek,
                               prd_unit
                          FROM tbmaster_prodmast
                         WHERE prd_prdcd NOT LIKE '%0'
                    ) p
                    where seqnum = 1) on trjd_prdcd = plugabung
                    join tbmaster_customer on cus_kodemember = trjd_cus_kodemember
                    where to_char(TRJD_TRANSACTIONDATE,'mm/yyyy') = '".$bulan."'
                    and trunc(TRJD_TRANSACTIONDATE) between trunc(BDH_TGLAWAL_PENAWARAN) and trunc(BDH_TGLakhir_PENAWARAN)
                    and jh_transactiontype = 'S'
                    and COALESCE(cus_flagmemberkhusus,'T') = 'Y'
                    and trjd_quantity !=0
                    order by cus_kodemember,jh_cashierid,jh_cashierstation,jh_transactionno,jh_transactiondate,prd_prdcd) t
                         ) t
                    where seqnum = 1"
        );
        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.laporan-pembelian-perdana-item-distribusi-tertentu-pdf', compact(['perusahaan', 'data', 'bulan']));
    }

    //laporan 2
    public function listingReturItemDistribusiTertentu($perusahaan,$jenis,$tgl1)
    {
//        $data = DB::connection(Session::get('connection'))->select("select * from tbtr_vch_retur
//join tbtr_pembayaranvoucher
//on vcr_kodevoucher = 'IGR RETUR-'||TO_CHAR(vcrt_transactiondate,'yyyymmdd')||vcrt_cashierid||vcrt_station||vcrt_transactionno
//join tbtr_jualheader
//on trunc(jh_transactiondate) = trunc(vcrt_transactiondate)
//and jh_cashierid = vcrt_cashierid
//and jh_cashierstation = vcrt_station
//and jh_transactionno = vcr_notransaksi");

        $data = DB::connection(Session::get('connection'))
            ->table('tbtr_vch_retur')
            ->leftJoin('tbtr_pembayaranvoucher','vcr_kodevoucher','=',DB::connection(Session::get('connection'))->raw("'IGR RETUR-'||TO_CHAR(vcrt_transactiondate,'yyyymmdd')||vcrt_cashierid||vcrt_station||vcrt_transactionno"))
            ->leftJoin('tbtr_jualheader',function($join){
                $join->on('jh_cashierid','=','vcrt_cashierid');
                $join->on('jh_cashierstation','=','vcrt_station');
                $join->on('jh_transactionno','=','vcr_notransaksi');
            })
            ->join('tbmaster_cabang','cab_kodecabang','=','vcrt_kodeigr')
            ->selectRaw("
                vcrt_kodemember,
                'SPBD/'||substr(cab_singkatancabang,-3)||'/'|| TO_CHAR(jh_transactiondate,'yyyymmdd')||jh_cashierid||jh_cashierstation||jh_transactionno no_spbd,
                jh_voucheramt,
                'SP'||TO_CHAR(vcrt_transactiondate,'yyyymmdd')||vcrt_cashierid||vcrt_station||vcrt_transactionno no_sp,
                vcrt_nominal,
                nvl(vcrt_nominal,0) - nvl(jh_voucheramt,0) selisih
                ")
            ->whereDate('vcrt_transactiondate','=',Carbon::createFromFormat('d/m/Y',$tgl1))
//            ->orderBy('no_sp')
            ->get();

//        dd($data);

        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.listing-retur-item-distribusi-tertentu-pdf', compact(['perusahaan', 'data', 'tgl1']));
    }

    //laporan 3
    public function laporanTransaksiPenukaranBarang($perusahaan,$jenis,$tgl1,$tgl2)
    {
        // Cesar

        if ($tgl1 == $tgl2) {
            $data_retur = DB::connection('simkmy')->select("SELECT ROM_NODOKUMEN, ROM_TGLDOKUMEN, ROM_PRDCD, ROM_QTY, ROM_KODEKASIR, ROM_STATION, PRD_DESKRIPSIPENDEK FROM TBTR_RETUROMI
            JOIN TBMASTER_PRODMAST
            ON ROM_PRDCD = PRD_PRDCD
            join TBTR_VCH_RETUR
            ON VCRT_TRANSACTIONNO = ROM_NODOKUMEN
            --JOIN TBTR_PEMBAYARANVOUCHER
            --on 'IGR RETUR-'||TO_CHAR(vcrt_transactiondate,'yyyymmdd')||vcrt_cashierid||vcrt_station||vcrt_transactionno = VCR_KODEVOUCHER
            WHERE TRUNC(ROM_TGLDOKUMEN) = TO_DATE('".$tgl1."', 'DD/MM/YYYY')
            ORDER BY ROM_NODOKUMEN");

            $data_pengganti = DB::connection('simkmy')->select("SELECT TRJD_PRDCD, TRJD_PRD_DESKRIPSIPENDEK, TRJD_QUANTITY, TRJD_TRANSACTIONDATE, TRJD_CREATE_BY, TRJD_CASHIERSTATION, TRJD_TRANSACTIONNO,
            CAB_SINGKATANCABANG, JH_TRANSACTIONDATE, JH_CASHIERID, JH_CASHIERSTATION, JH_TRANSACTIONNO, JH_CREATE_BY, VCRT_KETERANGAN FROM TBTR_VCH_RETUR
            JOIN TBMASTER_CABANG
            ON CAB_KODECABANG = VCRT_KODEIGR
            JOIN TBTR_PEMBAYARANVOUCHER
            on 'IGR RETUR-'||TO_CHAR(vcrt_transactiondate,'yyyymmdd')||vcrt_cashierid||vcrt_station||vcrt_transactionno = VCR_KODEVOUCHER
            JOIN TBTR_JUALHEADER
            ON VCR_NOTRANSAKSI = JH_TRANSACTIONNO
            AND VCR_KASIR = JH_CASHIERID
            AND VCR_STATION = JH_CASHIERSTATION
            AND TRUNC(VCR_TGLTRANSAKSI) = TRUNC(JH_TRANSACTIONDATE)
            JOIN TBTR_JUALDETAIL
            ON JH_TRANSACTIONNO = TRJD_TRANSACTIONNO
            AND JH_CASHIERID = TRJD_CREATE_BY
            AND JH_CASHIERSTATION = TRJD_CASHIERSTATION
            AND TRUNC(JH_TRANSACTIONDATE) = TRUNC(TRJD_TRANSACTIONDATE)
            WHERE TRUNC(TRJD_TRANSACTIONDATE) = TO_DATE('".$tgl1."', 'DD/MM/YYYY')
            ORDER BY VCRT_TRANSACTIONNO");
        } else {
            $data_retur = DB::connection(Session::get('connection'))->select("SELECT ROM_NODOKUMEN, ROM_TGLDOKUMEN, ROM_PRDCD, ROM_QTY, ROM_KODEKASIR, ROM_STATION, PRD_DESKRIPSIPENDEK FROM TBTR_RETUROMI
            JOIN TBMASTER_PRODMAST
            ON ROM_PRDCD = PRD_PRDCD
            join TBTR_VCH_RETUR
            ON VCRT_TRANSACTIONNO = ROM_NODOKUMEN
            --JOIN TBTR_PEMBAYARANVOUCHER
            --on 'IGR RETUR-'||TO_CHAR(vcrt_transactiondate,'yyyymmdd')||vcrt_cashierid||vcrt_station||vcrt_transactionno = VCR_KODEVOUCHER
            WHERE TRUNC(ROM_TGLDOKUMEN) BETWEEN TO_DATE('".$tgl1."', 'DD/MM/YYYY') AND TO_DATE('".$tgl2."', 'DD/MM/YYYY')
            ORDER BY ROM_NODOKUMEN");

            $data_pengganti = DB::connection(Session::get('connection'))->select("SELECT TRJD_PRDCD, TRJD_PRD_DESKRIPSIPENDEK, TRJD_QUANTITY, TRJD_TRANSACTIONDATE, TRJD_CREATE_BY, TRJD_CASHIERSTATION, TRJD_TRANSACTIONNO,
            CAB_SINGKATANCABANG, JH_TRANSACTIONDATE, JH_CASHIERID, JH_CASHIERSTATION, JH_TRANSACTIONNO, JH_CREATE_BY, VCRT_KETERANGAN, VCRT_TRANSACTIONNO FROM TBTR_VCH_RETUR
            JOIN TBMASTER_CABANG
            ON CAB_KODECABANG = VCRT_KODEIGR
            JOIN TBTR_PEMBAYARANVOUCHER
            on 'IGR RETUR-'||TO_CHAR(vcrt_transactiondate,'yyyymmdd')||vcrt_cashierid||vcrt_station||vcrt_transactionno = VCR_KODEVOUCHER
            JOIN TBTR_JUALHEADER
            ON VCR_NOTRANSAKSI = JH_TRANSACTIONNO
            AND VCR_KASIR = JH_CASHIERID
            AND VCR_STATION = JH_CASHIERSTATION
            AND TRUNC(VCR_TGLTRANSAKSI) = TRUNC(JH_TRANSACTIONDATE)
            JOIN TBTR_JUALDETAIL
            ON JH_TRANSACTIONNO = TRJD_TRANSACTIONNO
            AND JH_CASHIERID = TRJD_CREATE_BY
            AND JH_CASHIERSTATION = TRJD_CASHIERSTATION
            AND TRUNC(JH_TRANSACTIONDATE) = TRUNC(TRJD_TRANSACTIONDATE)
            WHERE TRUNC(TRJD_TRANSACTIONDATE) BETWEEN TO_DATE('".$tgl1."', 'DD/MM/YYYY') AND TO_DATE('".$tgl2."', 'DD/MM/YYYY')
            ORDER BY VCRT_TRANSACTIONNO");
        }
        $data = [];
        $temp_nodokumen = '';
        if (isset($data_pengganti) && sizeof($data_pengganti) >= sizeof($data_retur)) {
            for ($i=0; $i < sizeof($data_pengganti); $i++) {
                $d = (object)'';

                // if (isset($data_retur[$i]) && $data_retur[$i]->rom_nodokumen != $temp_nodokumen) {
                //     $temp_nodokumen = $data_retur[$i]->rom_nodokumen;

                //     $d->rom_nodokumen = isset($data_retur[$i]->rom_nodokumen) ? $data_retur[$i]->rom_nodokumen:'';
                //     $d->rom_tgldokumen = isset($data_retur[$i]->rom_tgldokumen) ? $data_retur[$i]->rom_tgldokumen:'';
                //     $d->rom_prdcd = isset($data_retur[$i]->rom_prdcd) ? $data_retur[$i]->rom_prdcd:'';
                //     $d->rom_qty = isset($data_retur[$i]->rom_qty) ? $data_retur[$i]->rom_qty:'';
                //     $d->rom_station = isset($data_retur[$i]->rom_station) ? $data_retur[$i]->rom_station:'';
                //     $d->rom_kodekasir = isset($data_retur[$i]->rom_kodekasir) ? $data_retur[$i]->rom_kodekasir:'';
                //     $d->rom_station = isset($data_retur[$i]->rom_station) ? $data_retur[$i]->rom_station:'';
                //     $d->prd_deskripsipendek = isset($data_retur[$i]->prd_deskripsipendek) ? $data_retur[$i]->prd_deskripsipendek:'';
                // } else {
                //     $temp_nodokumen = '';

                //     $d->rom_nodokumen = '';
                //     $d->rom_tgldokumen = '';
                //     $d->rom_prdcd = '';
                //     $d->rom_qty = '';
                //     $d->rom_station = '';
                //     $d->rom_kodekasir = '';
                //     $d->rom_station = '';
                //     $d->prd_deskripsipendek = '';
                // }

                $d->rom_nodokumen = isset($data_retur[$i]->rom_nodokumen) ? $data_retur[$i]->rom_nodokumen:'';
                $d->rom_tgldokumen = isset($data_retur[$i]->rom_tgldokumen) ? $data_retur[$i]->rom_tgldokumen:'';
                $d->rom_prdcd = isset($data_retur[$i]->rom_prdcd) ? $data_retur[$i]->rom_prdcd:'';
                $d->rom_qty = isset($data_retur[$i]->rom_qty) ? $data_retur[$i]->rom_qty:'';
                $d->rom_station = isset($data_retur[$i]->rom_station) ? $data_retur[$i]->rom_station:'';
                $d->rom_kodekasir = isset($data_retur[$i]->rom_kodekasir) ? $data_retur[$i]->rom_kodekasir:'';
                $d->rom_station = isset($data_retur[$i]->rom_station) ? $data_retur[$i]->rom_station:'';
                $d->prd_deskripsipendek = isset($data_retur[$i]->prd_deskripsipendek) ? $data_retur[$i]->prd_deskripsipendek:'';


                $d->trjd_prdcd = isset($data_pengganti[$i]->trjd_prdcd) ? $data_pengganti[$i]->trjd_prdcd:'';
                $d->trjd_prd_deskripsipendek = isset($data_pengganti[$i]->trjd_prd_deskripsipendek) ? $data_pengganti[$i]->trjd_prd_deskripsipendek:'';
                $d->trjd_quantity = isset($data_pengganti[$i]->trjd_quantity) ? $data_pengganti[$i]->trjd_quantity:'';
                $d->trjd_transactiondate = isset($data_pengganti[$i]->trjd_transactiondate) ? $data_pengganti[$i]->trjd_transactiondate:'';
                $d->trjd_create_by = isset($data_pengganti[$i]->trjd_create_by) ? $data_pengganti[$i]->trjd_create_by:'';
                $d->trjd_cashierstation = isset($data_pengganti[$i]->trjd_cashierstation) ? $data_pengganti[$i]->trjd_cashierstation:'';
                $d->trjd_transactionno = isset($data_pengganti[$i]->trjd_transactionno) ? $data_pengganti[$i]->trjd_transactionno:'';
                $d->cab_singkatancabang = isset($data_pengganti[$i]->cab_singkatancabang) ? $data_pengganti[$i]->cab_singkatancabang:'';
                $d->jh_transactiondate = isset($data_pengganti[$i]->jh_transactiondate) ? $data_pengganti[$i]->jh_transactiondate:'';
                $d->jh_cashierid = isset($data_pengganti[$i]->jh_cashierid) ? $data_pengganti[$i]->jh_cashierid:'';
                $d->jh_cashierstation = isset($data_pengganti[$i]->jh_cashierstation) ? $data_pengganti[$i]->jh_cashierstation:'';
                $d->jh_transactionno = isset($data_pengganti[$i]->jh_transactionno) ? $data_pengganti[$i]->jh_transactionno:'';
                $d->jh_create_by = isset($data_pengganti[$i]->jh_create_by) ? $data_pengganti[$i]->jh_create_by:'';
                $d->vcrt_keterangan = isset($data_pengganti[$i]->vcrt_keterangan) ? $data_pengganti[$i]->vcrt_keterangan:'';
                $d->vcrt_transactionno = isset($data_pengganti[$i]->vcrt_transactionno) ? $data_pengganti[$i]->vcrt_transactionno:'';

                array_push($data, $d);
            }
        } else {
            for ($i=0; $i < sizeof($data_retur); $i++) {
                $d = (object)'';

                // if (isset($data_retur[$i]) && $data_retur[$i]->rom_nodokumen != $temp_nodokumen) {
                //     $temp_nodokumen = $data_retur[$i]->rom_nodokumen;

                //     $d->rom_nodokumen = isset($data_retur[$i]->rom_nodokumen) ? $data_retur[$i]->rom_nodokumen:'';
                //     $d->rom_tgldokumen = isset($data_retur[$i]->rom_tgldokumen) ? $data_retur[$i]->rom_tgldokumen:'';
                //     $d->rom_prdcd = isset($data_retur[$i]->rom_prdcd) ? $data_retur[$i]->rom_prdcd:'';
                //     $d->rom_qty = isset($data_retur[$i]->rom_qty) ? $data_retur[$i]->rom_qty:'';
                //     $d->rom_station = isset($data_retur[$i]->rom_station) ? $data_retur[$i]->rom_station:'';
                //     $d->rom_kodekasir = isset($data_retur[$i]->rom_kodekasir) ? $data_retur[$i]->rom_kodekasir:'';
                //     $d->rom_station = isset($data_retur[$i]->rom_station) ? $data_retur[$i]->rom_station:'';
                //     $d->prd_deskripsipendek = isset($data_retur[$i]->prd_deskripsipendek) ? $data_retur[$i]->prd_deskripsipendek:'';
                // } else {
                //     $temp_nodokumen = '';

                //     $d->rom_nodokumen = '';
                //     $d->rom_tgldokumen = '';
                //     $d->rom_prdcd = '';
                //     $d->rom_qty = '';
                //     $d->rom_station = '';
                //     $d->rom_kodekasir = '';
                //     $d->rom_station = '';
                //     $d->prd_deskripsipendek = '';
                // }

                $d->rom_nodokumen = isset($data_retur[$i]->rom_nodokumen) ? $data_retur[$i]->rom_nodokumen:'';
                $d->rom_tgldokumen = isset($data_retur[$i]->rom_tgldokumen) ? $data_retur[$i]->rom_tgldokumen:'';
                $d->rom_prdcd = isset($data_retur[$i]->rom_prdcd) ? $data_retur[$i]->rom_prdcd:'';
                $d->rom_qty = isset($data_retur[$i]->rom_qty) ? $data_retur[$i]->rom_qty:'';
                $d->rom_station = isset($data_retur[$i]->rom_station) ? $data_retur[$i]->rom_station:'';
                $d->rom_kodekasir = isset($data_retur[$i]->rom_kodekasir) ? $data_retur[$i]->rom_kodekasir:'';
                $d->rom_station = isset($data_retur[$i]->rom_station) ? $data_retur[$i]->rom_station:'';
                $d->prd_deskripsipendek = isset($data_retur[$i]->prd_deskripsipendek) ? $data_retur[$i]->prd_deskripsipendek:'';


                $d->trjd_prdcd = isset($data_pengganti[$i]->trjd_prdcd) ? $data_pengganti[$i]->trjd_prdcd:'';
                $d->trjd_prd_deskripsipendek = isset($data_pengganti[$i]->trjd_prd_deskripsipendek) ? $data_pengganti[$i]->trjd_prd_deskripsipendek:'';
                $d->trjd_quantity = isset($data_pengganti[$i]->trjd_quantity) ? $data_pengganti[$i]->trjd_quantity:'';
                $d->trjd_transactiondate = isset($data_pengganti[$i]->trjd_transactiondate) ? $data_pengganti[$i]->trjd_transactiondate:'';
                $d->trjd_create_by = isset($data_pengganti[$i]->trjd_create_by) ? $data_pengganti[$i]->trjd_create_by:'';
                $d->trjd_cashierstation = isset($data_pengganti[$i]->trjd_cashierstation) ? $data_pengganti[$i]->trjd_cashierstation:'';
                $d->trjd_transactionno = isset($data_pengganti[$i]->trjd_transactionno) ? $data_pengganti[$i]->trjd_transactionno:'';
                $d->cab_singkatancabang = isset($data_pengganti[$i]->cab_singkatancabang) ? $data_pengganti[$i]->cab_singkatancabang:'';
                $d->jh_transactiondate = isset($data_pengganti[$i]->jh_transactiondate) ? $data_pengganti[$i]->jh_transactiondate:'';
                $d->jh_cashierid = isset($data_pengganti[$i]->jh_cashierid) ? $data_pengganti[$i]->jh_cashierid:'';
                $d->jh_cashierstation = isset($data_pengganti[$i]->jh_cashierstation) ? $data_pengganti[$i]->jh_cashierstation:'';
                $d->jh_transactionno = isset($data_pengganti[$i]->jh_transactionno) ? $data_pengganti[$i]->jh_transactionno:'';
                $d->jh_create_by = isset($data_pengganti[$i]->jh_create_by) ? $data_pengganti[$i]->jh_create_by:'';
                $d->vcrt_keterangan = isset($data_pengganti[$i]->vcrt_keterangan) ? $data_pengganti[$i]->vcrt_keterangan:'';
                $d->vcrt_transactionno = isset($data_pengganti[$i]->vcrt_transactionno) ? $data_pengganti[$i]->vcrt_transactionno:'';

                array_push($data, $d);
            }
        }

        // dd($data);
        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.laporan-transaksi-penukaran-barang-pdf', compact(['perusahaan', 'data', 'tgl1', 'tgl2']));
    }

    //laporan 4
    public function laporanFrekuensiPenukaranBarangDagangan($perusahaan,$jenis,$bulan)
    {
        $data = DB::connection(Session::get('connection'))->select("select rom_member, cus_kodemember, cus_namamember, rom_prdcd, prd_prdcd, prd_deskripsipanjang, rom_nodokumen, COUNT(vcrt_transactionno) as qty
        from tbtr_returomi
        join tbmaster_prodmast on prd_prdcd = rom_prdcd
        join tbmaster_customer on cus_kodemember = rom_member
        join tbtr_vch_retur on vcrt_transactionno = rom_nodokumen
        where to_char(rom_tgldokumen,'mm/yyyy') = '".$bulan."'
        group by rom_member, cus_kodemember, cus_namamember, rom_prdcd, prd_prdcd, prd_deskripsipanjang,rom_nodokumen");
//dd($data);
//$data = ['1'];
        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.laporan-frekuensi-penukaran-barang-dagangan-pdf', compact(['perusahaan', 'data', 'bulan']));
    }

    //laporan 5
    public function laporanPenyerahanBarangDaganganYangDitukar($perusahaan,$jenis,$tgl1)
    {
        //hen
        // $data = DB::connection(Session::get('connection'))
        //     ->table('tbtr_returomi')
        //     ->join('tbmaster_prodmast', 'prd_prdcd', '=', 'rom_prdcd')
        //     ->select('rom_nodokumen', 'rom_tgldokumen', 'rom_prdcd', 'prd_deskripsipanjang', 'rom_qty')
        //     ->whereBetween('rom_tgldokumen',$tgl1, $tgl2)
        //     ->get();

        $data = DB::connection(Session::get('connection'))
        ->select("SELECT rom_nodokumen, rom_tgldokumen, rom_prdcd, prd_deskripsipanjang, rom_qty
        FROM tbtr_returomi, tbmaster_prodmast, tbtr_vch_retur
        WHERE prd_prdcd = rom_prdcd
        AND vcrt_transactionno = rom_nodokumen
        AND TRUNC(rom_tgldokumen) = TO_DATE('" . $tgl1 . "','dd/mm/yyyy')
        ORDER BY rom_nodokumen");
        // dd($data);
        // $data = ['1'];
        return view('FRONTOFFICE.LAPORANITEMDISTRIBUSI.laporan-penyerahan-barang-dagangan-yang-ditukar-pdf', compact(['perusahaan', 'data', 'tgl1']));
    }
}
