<?php

namespace App\Http\Controllers\BACKOFFICE\LPP;

use App\Http\Controllers\Auth\loginController;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\DataTables\DataTables;
use File;

class ProsesLPPHarianController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.LPP.proses-lpp-harian');
    }

    public function proses(Request $request)
    {

        $txt_tgl1 = $request->periode1;
        $txt_tgl2 = $request->periode2;
        $txt_tglso = $request->tglso;
        $checkplu = $request->checkplu;
        $temp = 0;
        $err_txt = '';
        $p_sukses = 'true';

        $connection = loginController::getConnectionProcedure();
        $exec = oci_parse($connection, "BEGIN  SP_PROSES_LPP_SO_migrasi ('" . Session::get('kdigr') . "', to_date('" . $txt_tgl1 . "','dd/mm/yyyy'), to_date('" . $txt_tgl2 . "','dd/mm/yyyy'), :p_sukses, :err_txt); END;");
        oci_bind_by_name($exec, ':p_sukses', $p_sukses, 100);
        oci_bind_by_name($exec, ':err_txt', $err_txt, 100);
        oci_execute($exec);


        if ($p_sukses == 'false') {
            $status = 'error';
            $message = 'LPP - ' . $err_txt;
            return compact(['status', 'message']);
        } else {
            $exec = oci_parse($connection, "BEGIN  sp_lppso_csv (to_char(to_date('" . $txt_tgl1 . "','dd/mm/yyyy'),'dd-MM-yyyy'), to_char(to_date('" . $txt_tgl2 . "','dd/mm/yyyy'),'dd-MM-yyyy'),to_char(to_date('" . $txt_tglso . "','dd/mm/yyyy'),'dd-MM-yyyy') ); END;");
            oci_execute($exec);
            $status = 'success';
            $message = 'Proses LPP Harian Berhasil!';
            return compact(['status', 'message']);
        }


    }

    public function cetak(Request $request)
    {

        $txt_tgl1 = $request->periode1;
        $txt_tgl2 = $request->periode2;
        $txt_tglso = $request->tglso;
        $checkplu = $request->checkplu;

        $periode = "to_char(to_date('" . $txt_tgl2 . "','dd/mm/yyyy'), 'MM-yyyy')";

        if ($checkplu == 'true') {
            $p_and = " and lpp_prdcd in ( select distinct lsi_prdcd from tbtr_lokasi_so_ey where to_char(lsi_tglso, 'MM-yyyy') = ".$periode." ) ";
        } else {
            $p_and = " ";
        }

        $data = DB::connection(Session::get('connection'))
            ->select("SELECT lpp_kodedivisi, div_namadivisi,
                                    lpp_kodedepartemen, dep_namadepartement,
                                    lpp_kategoribrg, kat_namakategori, lpp_prdcd, prd_deskripsipanjang, kemasan,
                                    judul, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                                    SUM(lpp_qtybegbal) sawalqty, SUM(lpp_rphbegbal) sawalrph, SUM(lpp_qtybeli) beliqty,
                                    SUM(lpp_rphbeli) belirph, SUM(lpp_qtybonus) bonusqty, SUM(lpp_rphbonus) bonusrph,
                                    SUM(lpp_qtytrmcb) trmcbqty, SUM(lpp_rphtrmcb) trmcbrph, SUM(lpp_qtyretursales) retursalesqty,
                                    SUM(lpp_rphretursales) retursalesrph, SUM(lpp_rphrafak) rafakrph, SUM(lpp_qtyrepack) repackqty,
                                    SUM(lpp_rphrepack) repackrph, SUM(lpp_qtylainin) laininqty, SUM(lpp_rphlainin) laininrph,
                                    SUM(lpp_qtysales) salesqty, SUM(lpp_rphsales) salesrph, SUM(lpp_qtykirim) kirimqty, SUM(lpp_rphkirim) kirimrph,
                                    SUM(lpp_qtyprepacking) prepackqty, SUM(lpp_rphprepacking) prepackrph, SUM(lpp_qtyhilang) hilangqty,
                                    SUM(lpp_qty_selisih_so) sel_so, SUM(lpp_rph_selisih_so) rph_sel_so,
                                    SUM(lpp_rphhilang) hilangrph, SUM(lpp_qtylainout) lainoutqty, SUM(lpp_rphlainout) lainoutrph, SUM(lpp_qtyintransit) intrstqty,
                                    SUM(lpp_rphintransit) intrstrph, SUM(lpp_qtyadj) adjqty, SUM(lpp_rphadj) adjrph, SUM(adj) adj, SUM(sadj) sadj,
                                    SUM(lpp_qtyakhir) akhirqty, SUM(lpp_rphakhir) akhirrph, SUM(lpp_supplierservq) servqsup, SUM(lpp_tokoservq) servqtok, SUM(saldotoko) saldotoko
                            FROM (SELECT lpp_kodedivisi, div_namadivisi, lpp_kodedepartemen, dep_namadepartement,
                                    lpp_kategoribrg, kat_namakategori, lpp_prdcd, prd_deskripsipanjang, prd_unit||'/'||prd_frac kemasan,
                                    ' POSISI & MUTASI PERSEDIAAN BARANG BAIK' judul,
                                    lpp_qtybegbal, lpp_rphbegbal, lpp_qtybeli, lpp_rphbeli, lpp_qtybonus, lpp_rphbonus,
                                    lpp_qtytrmcb, lpp_rphtrmcb, lpp_qtyretursales, lpp_rphretursales, lpp_rphrafak, lpp_qtyrepack, lpp_rphrepack,
                                    lpp_qtylainin, lpp_rphlainin, lpp_qtysales, lpp_rphsales, lpp_qtykirim, lpp_rphkirim, lpp_qtyprepacking, lpp_rphprepacking,
                                    lpp_qtyhilang, lpp_rphhilang, lpp_qtylainout, lpp_rphlainout, lpp_qtyintransit, lpp_rphintransit, lpp_qtyadj, lpp_rphadj, lpp_soadj,
                                    (NVL(lpp_rphadj,0) + NVL(lpp_soadj,0)) adj, NVL(lpp_qtyakhir,0) lpp_qtyakhir, NVL(lpp_rphakhir,0) lpp_rphakhir,  NVL(lpp_qty_selisih_so, 0) lpp_qty_selisih_so, NVL(lpp_rph_selisih_so, 0) lpp_rph_selisih_so,
                                    NVL(lpp_rphakhir,0) - (NVL(lpp_rphbegbal,0) + NVL(lpp_rphbeli,0) + NVL(lpp_rphbonus,0) + NVL(lpp_rphtrmcb,0) + NVL(lpp_rphretursales,0) + NVL(lpp_rph_selisih_so, 0) +
                                    NVL(lpp_rphrepack,0) + NVL(lpp_rphlainin,0) - NVL(lpp_rphrafak,0) - NVL(lpp_rphsales,0) - NVL(lpp_rphkirim,0) - NVL(lpp_rphprepacking,0) -
                                    NVL(lpp_rphhilang,0) - NVL(lpp_rphlainout,0) + NVL(lpp_rphintransit,0) + NVL(lpp_rphadj, 0) + NVL(lpp_soadj, 0)) sadj,
                                    lpp_supplierservq, lpp_tokoservq, lpp_avgcost1, lpp_avgcost, NVL(lpp_qtyakhir,0)-NVL(lpp_supplierservq,0)-NVL(lpp_tokoservq,0) saldotoko,
                                    prs_namaperusahaan, prs_namacabang, prs_namawilayah
                            FROM tbtr_lpp_so, tbmaster_prodmast, tbmaster_divisi,
                                    tbmaster_departement,tbmaster_kategori, tbmaster_perusahaan
                            WHERE lpp_kodeigr = '" . Session::get('kdigr') . "'
                                    AND lpp_tgl1 = to_date('" . $txt_tgl1 . "','dd/mm/yyyy')
                                    AND lpp_tgl2 = to_date('" . $txt_tgl2 . "','dd/mm/yyyy')
                                    AND prd_kodeigr(+) = lpp_kodeigr
                                    AND prd_prdcd(+) = lpp_prdcd
                                    AND div_kodeigr(+) = lpp_kodeigr
                                    AND div_kodedivisi(+) = lpp_kodedivisi
                                    AND dep_kodeigr(+) = lpp_kodeigr
                                    AND dep_kodedivisi(+) = lpp_kodedivisi
                                    AND dep_kodedepartement(+) = lpp_kodedepartemen
                                    AND kat_kodeigr(+) = lpp_kodeigr
                                    AND kat_kodedepartement(+) = lpp_kodedepartemen
                                    AND kat_kodekategori(+) = lpp_kategoribrg
                                    AND prs_kodeigr = lpp_kodeigr
                                    ".$p_and."
                            )
                            GROUP BY lpp_kodedivisi, div_namadivisi,
                                    lpp_kodedepartemen, dep_namadepartement,
                                    lpp_kategoribrg, kat_namakategori,
                                    lpp_prdcd, prd_deskripsipanjang, kemasan, judul,
                                    prs_namaperusahaan, prs_namacabang, prs_namawilayah
                            ORDER BY lpp_kodedivisi, lpp_kodedepartemen, lpp_kategoribrg, lpp_prdcd");
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        return view('BACKOFFICE.LPP.proses-lpp-harian-pdf', compact(['perusahaan', 'data','txt_tgl1','txt_tgl2']));


    }
}
