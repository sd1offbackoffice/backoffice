<?php

namespace App\Http\Controllers\BARANGHADIAH;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LaporanBarangPromosiController extends Controller
{
    public function index() {
        return view('BARANGHADIAH.laporanbarangpromosi');
    }

    public function checkDate(Request $request) {
        $date = $request->date;
        $nowDate = date('m-Y');

        if (!$date) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'Data input tanggal tidak ada',
            ]);
        }

        if ($date == $nowDate) {
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Print data NOW',
                'data' => 'now'
            ]);
        }

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Print data Early',
            'data' => 'early'
        ]);
        // return dd($date);
        // return dd($nowDate);
    }

    public function printEarlyData(Request $request) {
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        $kodeigr = Session::get('kdigr');
        $dataType = 'early';
        $date = $request->date;

        $data = DB::connection(Session::get('connection'))
                ->select("SELECT bom, eom, prdcd, gfh_kodepromosi, gfh_namapromosi, gfh_tglawal, gfh_tglakhir, bprp_ketpanjang,
                kemasan, bprp_frackonversi, prs_namaperusahaan, prs_namacabang, prs_namawilayah,
                sum(qtyawal01) qtyawal01, sum(qtykawal01) qtykawal01, sum(qtybpb01) qtybpb01, sum(qtykbpb01) qtykbpb01,
                sum(qtydrcab01) qtydrcab01, sum(qtykdrcab01) qtykdrcab01, sum(qtysales01) qtysales01, sum(qtyksales01) qtyksales01,
                sum(qtykecab01) qtykecab01, sum(qtykkecab01) qtykkecab01, sum(qtympp01) qtympp01, sum(qtykmpp01) qtykmpp01,
                sum(qtyakhir01) qtyakhir01, sum(qtykakhir01) qtykakhir01,
                sum(qtyawal02) qtyawal02, sum(qtykawal02) qtykawal02, sum(qtybpb02) qtybpb02, sum(qtykbpb02) qtykbpb02,
                sum(qtydrcab02) qtydrcab02, sum(qtykdrcab02) qtykdrcab02, sum(qtysales02) qtysales02, sum(qtyksales02) qtyksales02,
                sum(qtykecab02) qtykecab02, sum(qtykkecab02) qtykkecab02, sum(qtympp02) qtympp02, sum(qtykmpp02) qtykmpp02,
                sum(qtyakhir02) qtyakhir02, sum(qtykakhir02) qtykakhir02,
                sum(qtyawal03) qtyawal03, sum(qtykawal03) qtykawal03, sum(qtybpb03) qtybpb03, sum(qtykbpb03) qtykbpb03,
                sum(qtydrcab03) qtydrcab03, sum(qtykdrcab03) qtykdrcab03, sum(qtysales03) qtysales03, sum(qtyksales03) qtyksales03,
                sum(qtykecab03) qtykecab03, sum(qtykkecab03) qtykkecab03, sum(qtympp03) qtympp03, sum(qtykmpp03) qtykmpp03,
                sum(qtyakhir03) qtyakhir03, sum(qtykakhir03) qtykakhir03,
                sum(qtyawal04) qtyawal04, sum(qtykawal04) qtykawal04, sum(qtybpb04) qtybpb04, sum(qtykbpb04) qtykbpb04,
                sum(qtydrcab04) qtydrcab04, sum(qtykdrcab04) qtykdrcab04, sum(qtysales04) qtysales04, sum(qtyksales04) qtyksales04,
                sum(qtykecab04) qtykecab04, sum(qtykkecab04) qtykkecab04, sum(qtympp04) qtympp04, sum(qtykmpp04) qtykmpp04,
                sum(qtyakhir04) qtyakhir04, sum(qtykakhir04) qtykakhir04,
                sum(qtyawal05) qtyawal05, sum(qtykawal05) qtykawal05, sum(qtybpb05) qtybpb05, sum(qtykbpb05) qtykbpb05,
                sum(qtydrcab05) qtydrcab05, sum(qtykdrcab05) qtykdrcab05, sum(qtysales05) qtysales05, sum(qtyksales05) qtyksales05,
                sum(qtykecab05) qtykecab05, sum(qtykkecab05) qtykkecab05, sum(qtympp05) qtympp05, sum(qtykmpp05) qtykmpp05,
                sum(qtyakhir05) qtyakhir05, sum(qtykakhir05) qtykakhir05,
                sum(qtyawal06) qtyawal06, sum(qtykawal06) qtykawal06, sum(qtybpb06) qtybpb06, sum(qtykbpb06) qtykbpb06,
                sum(qtydrcab06) qtydrcab06, sum(qtykdrcab06) qtykdrcab06, sum(qtysales06) qtysales06, sum(qtyksales06) qtyksales06,
                sum(qtykecab06) qtykecab06, sum(qtykkecab06) qtykkecab06, sum(qtympp06) qtympp06, sum(qtykmpp06) qtykmpp06,
                sum(qtyakhir06) qtyakhir06, sum(qtykakhir06) qtykakhir06,
                sum(qtyawal07) qtyawal07, sum(qtykawal07) qtykawal07, sum(qtybpb07) qtybpb07, sum(qtykbpb07) qtykbpb07,
                sum(qtydrcab07) qtydrcab07, sum(qtykdrcab07) qtykdrcab07, sum(qtysales07) qtysales07, sum(qtyksales07) qtyksales07,
                sum(qtykecab07) qtykecab07, sum(qtykkecab07) qtykkecab07, sum(qtympp07) qtympp07, sum(qtykmpp07) qtykmpp07,
                sum(qtyakhir07) qtyakhir07, sum(qtykakhir07) qtykakhir07,
                sum(qtyawal08) qtyawal08, sum(qtykawal08) qtykawal08, sum(qtybpb08) qtybpb08, sum(qtykbpb08) qtykbpb08,
                sum(qtydrcab08) qtydrcab08, sum(qtykdrcab08) qtykdrcab08, sum(qtysales08) qtysales08, sum(qtyksales08) qtyksales08,
                sum(qtykecab08) qtykecab08, sum(qtykkecab08) qtykkecab08, sum(qtympp08) qtympp08, sum(qtykmpp08) qtykmpp08,
                sum(qtyakhir08) qtyakhir08, sum(qtykakhir08) qtykakhir08,
                sum(qtyawal09) qtyawal09, sum(qtykawal09) qtykawal09, sum(qtybpb09) qtybpb09, sum(qtykbpb09) qtykbpb09,
                sum(qtydrcab09) qtydrcab09, sum(qtykdrcab09) qtykdrcab09, sum(qtysales09) qtysales09, sum(qtyksales09) qtyksales09,
                sum(qtykecab09) qtykecab09, sum(qtykkecab09) qtykkecab09, sum(qtympp09) qtympp09, sum(qtykmpp09) qtykmpp09,
                sum(qtyakhir09) qtyakhir09, sum(qtykakhir09) qtykakhir09,
                sum(qtyawal10) qtyawal10, sum(qtykawal10) qtykawal10, sum(qtybpb10) qtybpb10, sum(qtykbpb10) qtykbpb10,
                sum(qtydrcab10) qtydrcab10, sum(qtykdrcab10) qtykdrcab10, sum(qtysales10) qtysales10, sum(qtyksales10) qtyksales10,
                sum(qtykecab10) qtykecab10, sum(qtykkecab10) qtykkecab10, sum(qtympp10) qtympp10, sum(qtykmpp10) qtykmpp10,
                sum(qtyakhir10) qtyakhir10, sum(qtykakhir10) qtykakhir10,
                sum(qtyawal11) qtyawal11, sum(qtykawal11) qtykawal11, sum(qtybpb11) qtybpb11, sum(qtykbpb11) qtykbpb11,
                sum(qtydrcab11) qtydrcab11, sum(qtykdrcab11) qtykdrcab11, sum(qtysales11) qtysales11, sum(qtyksales11) qtyksales11,
                sum(qtykecab11) qtykecab11, sum(qtykkecab11) qtykkecab11, sum(qtympp11) qtympp11, sum(qtykmpp11) qtykmpp11,
                sum(qtyakhir11) qtyakhir11, sum(qtykakhir11) qtykakhir11,
                sum(qtyawal12) qtyawal12, sum(qtykawal12) qtykawal12, sum(qtybpb12) qtybpb12, sum(qtykbpb12) qtykbpb12,
                sum(qtydrcab12) qtydrcab12, sum(qtykdrcab12) qtykdrcab12, sum(qtysales12) qtysales12, sum(qtyksales12) qtyksales12,
                sum(qtykecab12) qtykecab12, sum(qtykkecab12) qtykkecab12, sum(qtympp12) qtympp12, sum(qtykmpp12) qtykmpp12,
                sum(qtyakhir12) qtyakhir12, sum(qtykakhir12) qtykakhir12, sum(qtyksr) qtyksr, sum(qtykksr) qtykksr
         FROM (SELECT a.*, bprp_ketpanjang, bprp_unit||'/'||bprp_frackonversi kemasan, bprp_frackonversi, 
                    FLOOR(hprs_qtyawal01/bprp_frackonversi) qtyawal01, MOD(hprs_qtyawal01, bprp_frackonversi) qtykawal01, 
                    FLOOR(hprs_qtybpb01/bprp_frackonversi) qtybpb01, MOD(hprs_qtybpb01, bprp_frackonversi) qtykbpb01,
                    FLOOR(hprs_qtydaricabang01/bprp_frackonversi) qtydrcab01, MOD(hprs_qtydaricabang01, bprp_frackonversi) qtykdrcab01,
                    FLOOR(hprs_qtysales01/bprp_frackonversi) qtysales01, MOD(hprs_qtysales01, bprp_frackonversi) qtyksales01,
                    FLOOR(hprs_qtykecabang01/bprp_frackonversi) qtykecab01, MOD(hprs_qtykecabang01, bprp_frackonversi) qtykkecab01,
                    FLOOR(hprs_qtyadjustment01/bprp_frackonversi) qtympp01, MOD(hprs_qtyadjustment01, bprp_frackonversi) qtykmpp01,
                    FLOOR(hprs_qtyakhir01/bprp_frackonversi) qtyakhir01, MOD(hprs_qtyakhir01, bprp_frackonversi) qtykakhir01,
                    FLOOR(hprs_qtyawal02/bprp_frackonversi) qtyawal02, MOD(hprs_qtyawal02, bprp_frackonversi) qtykawal02, 
                    FLOOR(hprs_qtybpb02/bprp_frackonversi) qtybpb02, MOD(hprs_qtybpb02, bprp_frackonversi) qtykbpb02,
                    FLOOR(hprs_qtydaricabang02/bprp_frackonversi) qtydrcab02, MOD(hprs_qtydaricabang02, bprp_frackonversi) qtykdrcab02,
                    FLOOR(hprs_qtysales02/bprp_frackonversi) qtysales02, MOD(hprs_qtysales02, bprp_frackonversi) qtyksales02,
                    FLOOR(hprs_qtykecabang02/bprp_frackonversi) qtykecab02, MOD(hprs_qtykecabang02, bprp_frackonversi) qtykkecab02,
                    FLOOR(hprs_qtyadjustment02/bprp_frackonversi) qtympp02, MOD(hprs_qtyadjustment02, bprp_frackonversi) qtykmpp02,
                    FLOOR(hprs_qtyakhir02/bprp_frackonversi) qtyakhir02, MOD(hprs_qtyakhir02, bprp_frackonversi) qtykakhir02,
                    FLOOR(hprs_qtyawal03/bprp_frackonversi) qtyawal03, MOD(hprs_qtyawal03, bprp_frackonversi) qtykawal03, 
                    FLOOR(hprs_qtybpb03/bprp_frackonversi) qtybpb03, MOD(hprs_qtybpb03, bprp_frackonversi) qtykbpb03,
                    FLOOR(hprs_qtydaricabang03/bprp_frackonversi) qtydrcab03, MOD(hprs_qtydaricabang03, bprp_frackonversi) qtykdrcab03,
                    FLOOR(hprs_qtysales03/bprp_frackonversi) qtysales03, MOD(hprs_qtysales03, bprp_frackonversi) qtyksales03,
                    FLOOR(hprs_qtykecabang03/bprp_frackonversi) qtykecab03, MOD(hprs_qtykecabang03, bprp_frackonversi) qtykkecab03,
                    FLOOR(hprs_qtyadjustment03/bprp_frackonversi) qtympp03, MOD(hprs_qtyadjustment03, bprp_frackonversi) qtykmpp03,
                    FLOOR(hprs_qtyakhir03/bprp_frackonversi) qtyakhir03, MOD(hprs_qtyakhir03, bprp_frackonversi) qtykakhir03,
                    FLOOR(hprs_qtyawal04/bprp_frackonversi) qtyawal04, MOD(hprs_qtyawal04, bprp_frackonversi) qtykawal04, 
                    FLOOR(hprs_qtybpb04/bprp_frackonversi) qtybpb04, MOD(hprs_qtybpb04, bprp_frackonversi) qtykbpb04,
                    FLOOR(hprs_qtydaricabang04/bprp_frackonversi) qtydrcab04, MOD(hprs_qtydaricabang04, bprp_frackonversi) qtykdrcab04,
                    FLOOR(hprs_qtysales04/bprp_frackonversi) qtysales04, MOD(hprs_qtysales04, bprp_frackonversi) qtyksales04,
                    FLOOR(hprs_qtykecabang04/bprp_frackonversi) qtykecab04, MOD(hprs_qtykecabang04, bprp_frackonversi) qtykkecab04,
                    FLOOR(hprs_qtyadjustment04/bprp_frackonversi) qtympp04, MOD(hprs_qtyadjustment04, bprp_frackonversi) qtykmpp04,
                    FLOOR(hprs_qtyakhir04/bprp_frackonversi) qtyakhir04, MOD(hprs_qtyakhir04, bprp_frackonversi) qtykakhir04,
                    FLOOR(hprs_qtyawal05/bprp_frackonversi) qtyawal05, MOD(hprs_qtyawal05, bprp_frackonversi) qtykawal05, 
                    FLOOR(hprs_qtybpb05/bprp_frackonversi) qtybpb05, MOD(hprs_qtybpb05, bprp_frackonversi) qtykbpb05,
                    FLOOR(hprs_qtydaricabang05/bprp_frackonversi) qtydrcab05, MOD(hprs_qtydaricabang05, bprp_frackonversi) qtykdrcab05,
                    FLOOR(hprs_qtysales05/bprp_frackonversi) qtysales05, MOD(hprs_qtysales05, bprp_frackonversi) qtyksales05,
                    FLOOR(hprs_qtykecabang05/bprp_frackonversi) qtykecab05, MOD(hprs_qtykecabang05, bprp_frackonversi) qtykkecab05,
                    FLOOR(hprs_qtyadjustment05/bprp_frackonversi) qtympp05, MOD(hprs_qtyadjustment05, bprp_frackonversi) qtykmpp05,
                    FLOOR(hprs_qtyakhir05/bprp_frackonversi) qtyakhir05, MOD(hprs_qtyakhir05, bprp_frackonversi) qtykakhir05,
                    FLOOR(hprs_qtyawal06/bprp_frackonversi) qtyawal06, MOD(hprs_qtyawal06, bprp_frackonversi) qtykawal06, 
                    FLOOR(hprs_qtybpb06/bprp_frackonversi) qtybpb06, MOD(hprs_qtybpb06, bprp_frackonversi) qtykbpb06,
                    FLOOR(hprs_qtydaricabang06/bprp_frackonversi) qtydrcab06, MOD(hprs_qtydaricabang06, bprp_frackonversi) qtykdrcab06,
                    FLOOR(hprs_qtysales06/bprp_frackonversi) qtysales06, MOD(hprs_qtysales06, bprp_frackonversi) qtyksales06,
                    FLOOR(hprs_qtykecabang06/bprp_frackonversi) qtykecab06, MOD(hprs_qtykecabang06, bprp_frackonversi) qtykkecab06,
                    FLOOR(hprs_qtyadjustment06/bprp_frackonversi) qtympp06, MOD(hprs_qtyadjustment06, bprp_frackonversi) qtykmpp06,
                    FLOOR(hprs_qtyakhir06/bprp_frackonversi) qtyakhir06, MOD(hprs_qtyakhir06, bprp_frackonversi) qtykakhir06,
                    FLOOR(hprs_qtyawal07/bprp_frackonversi) qtyawal07, MOD(hprs_qtyawal07, bprp_frackonversi) qtykawal07, 
                    FLOOR(hprs_qtybpb07/bprp_frackonversi) qtybpb07, MOD(hprs_qtybpb07, bprp_frackonversi) qtykbpb07,
                    FLOOR(hprs_qtydaricabang07/bprp_frackonversi) qtydrcab07, MOD(hprs_qtydaricabang07, bprp_frackonversi) qtykdrcab07,
                    FLOOR(hprs_qtysales07/bprp_frackonversi) qtysales07, MOD(hprs_qtysales07, bprp_frackonversi) qtyksales07,
                    FLOOR(hprs_qtykecabang07/bprp_frackonversi) qtykecab07, MOD(hprs_qtykecabang07, bprp_frackonversi) qtykkecab07,
                    FLOOR(hprs_qtyadjustment07/bprp_frackonversi) qtympp07, MOD(hprs_qtyadjustment07, bprp_frackonversi) qtykmpp07,
                    FLOOR(hprs_qtyakhir07/bprp_frackonversi) qtyakhir07, MOD(hprs_qtyakhir07, bprp_frackonversi) qtykakhir07,
                    FLOOR(hprs_qtyawal08/bprp_frackonversi) qtyawal08, MOD(hprs_qtyawal08, bprp_frackonversi) qtykawal08, 
                    FLOOR(hprs_qtybpb08/bprp_frackonversi) qtybpb08, MOD(hprs_qtybpb08, bprp_frackonversi) qtykbpb08,
                    FLOOR(hprs_qtydaricabang08/bprp_frackonversi) qtydrcab08, MOD(hprs_qtydaricabang08, bprp_frackonversi) qtykdrcab08,
                    FLOOR(hprs_qtysales08/bprp_frackonversi) qtysales08, MOD(hprs_qtysales08, bprp_frackonversi) qtyksales08,
                    FLOOR(hprs_qtykecabang08/bprp_frackonversi) qtykecab08, MOD(hprs_qtykecabang08, bprp_frackonversi) qtykkecab08,
                    FLOOR(hprs_qtyadjustment08/bprp_frackonversi) qtympp08, MOD(hprs_qtyadjustment08, bprp_frackonversi) qtykmpp08,
                    FLOOR(hprs_qtyakhir08/bprp_frackonversi) qtyakhir08, MOD(hprs_qtyakhir08, bprp_frackonversi) qtykakhir08,
                    FLOOR(hprs_qtyawal09/bprp_frackonversi) qtyawal09, MOD(hprs_qtyawal09, bprp_frackonversi) qtykawal09, 
                    FLOOR(hprs_qtybpb09/bprp_frackonversi) qtybpb09, MOD(hprs_qtybpb09, bprp_frackonversi) qtykbpb09,
                    FLOOR(hprs_qtydaricabang09/bprp_frackonversi) qtydrcab09, MOD(hprs_qtydaricabang09, bprp_frackonversi) qtykdrcab09,
                    FLOOR(hprs_qtysales09/bprp_frackonversi) qtysales09, MOD(hprs_qtysales09, bprp_frackonversi) qtyksales09,
                    FLOOR(hprs_qtykecabang09/bprp_frackonversi) qtykecab09, MOD(hprs_qtykecabang09, bprp_frackonversi) qtykkecab09,
                    FLOOR(hprs_qtyadjustment09/bprp_frackonversi) qtympp09, MOD(hprs_qtyadjustment09, bprp_frackonversi) qtykmpp09,
                    FLOOR(hprs_qtyakhir09/bprp_frackonversi) qtyakhir09, MOD(hprs_qtyakhir09, bprp_frackonversi) qtykakhir09,
                    FLOOR(hprs_qtyawal10/bprp_frackonversi) qtyawal10, MOD(hprs_qtyawal10, bprp_frackonversi) qtykawal10, 
                    FLOOR(hprs_qtybpb10/bprp_frackonversi) qtybpb10, MOD(hprs_qtybpb10, bprp_frackonversi) qtykbpb10,
                    FLOOR(hprs_qtydaricabang10/bprp_frackonversi) qtydrcab10, MOD(hprs_qtydaricabang10, bprp_frackonversi) qtykdrcab10,
                    FLOOR(hprs_qtysales10/bprp_frackonversi) qtysales10, MOD(hprs_qtysales10, bprp_frackonversi) qtyksales10,
                    FLOOR(hprs_qtykecabang10/bprp_frackonversi) qtykecab10, MOD(hprs_qtykecabang10, bprp_frackonversi) qtykkecab10,
                    FLOOR(hprs_qtyadjustment10/bprp_frackonversi) qtympp10, MOD(hprs_qtyadjustment10, bprp_frackonversi) qtykmpp10,
                    FLOOR(hprs_qtyakhir10/bprp_frackonversi) qtyakhir10, MOD(hprs_qtyakhir10, bprp_frackonversi) qtykakhir10,
                    FLOOR(hprs_qtyawal11/bprp_frackonversi) qtyawal11, MOD(hprs_qtyawal11, bprp_frackonversi) qtykawal11, 
                    FLOOR(hprs_qtybpb11/bprp_frackonversi) qtybpb11, MOD(hprs_qtybpb11, bprp_frackonversi) qtykbpb11,
                    FLOOR(hprs_qtydaricabang11/bprp_frackonversi) qtydrcab11, MOD(hprs_qtydaricabang11, bprp_frackonversi) qtykdrcab11,
                    FLOOR(hprs_qtysales11/bprp_frackonversi) qtysales11, MOD(hprs_qtysales11, bprp_frackonversi) qtyksales11,
                    FLOOR(hprs_qtykecabang11/bprp_frackonversi) qtykecab11, MOD(hprs_qtykecabang11, bprp_frackonversi) qtykkecab11,
                    FLOOR(hprs_qtyadjustment11/bprp_frackonversi) qtympp11, MOD(hprs_qtyadjustment11, bprp_frackonversi) qtykmpp11,
                    FLOOR(hprs_qtyakhir11/bprp_frackonversi) qtyakhir11, MOD(hprs_qtyakhir11, bprp_frackonversi) qtykakhir11,
                    FLOOR(hprs_qtyawal12/bprp_frackonversi) qtyawal12, MOD(hprs_qtyawal12, bprp_frackonversi) qtykawal12, 
                    FLOOR(hprs_qtybpb12/bprp_frackonversi) qtybpb12, MOD(hprs_qtybpb12, bprp_frackonversi) qtykbpb12,
                    FLOOR(hprs_qtydaricabang12/bprp_frackonversi) qtydrcab12, MOD(hprs_qtydaricabang12, bprp_frackonversi) qtykdrcab12,
                    FLOOR(hprs_qtysales12/bprp_frackonversi) qtysales12, MOD(hprs_qtysales12, bprp_frackonversi) qtyksales12,
                    FLOOR(hprs_qtykecabang12/bprp_frackonversi) qtykecab12, MOD(hprs_qtykecabang12, bprp_frackonversi) qtykkecab12,
                    FLOOR(hprs_qtyadjustment12/bprp_frackonversi) qtympp12, MOD(hprs_qtyadjustment12, bprp_frackonversi) qtykmpp12,
                    FLOOR(hprs_qtyakhir12/bprp_frackonversi) qtyakhir12, MOD(hprs_qtyakhir12, bprp_frackonversi) qtykakhir12,
                    FLOOR(NVL(qty,0)/bprp_frackonversi) qtyksr, MOD(NVL(qty,0), bprp_frackonversi) qtykksr, 
                    prs_namaperusahaan, prs_namacabang, prs_namawilayah
         FROM (SELECT DISTINCT '01'||TO_CHAR(bprd_tgldokumen,'-MM-YYYY') bom, TRUNC(LAST_DAY(bprd_tgldokumen)) eom,
                           bprd_prdcd prdcd, 0 qty, gfh_kodepromosi, gfh_namapromosi, gfh_tglawal, gfh_tglakhir 
                     FROM TBTR_BRGPROMOSI_D, TBTR_BRGPROMOSI_H, TBTR_GIFT_HDR
                     WHERE bprd_kodeigr = $kodeigr
                          AND TO_CHAR(bprd_tgldokumen,'MM-YYYY') = TO_CHAR(TO_DATE('$date', 'MM-YYYY'),'MM-YYYY')
                          AND bprh_nodokumen = bprd_nodokumen
                          AND bprh_tgldokumen = bprd_tgldokumen
              AND gfh_kodeigr(+) = bprh_kodeigr
                          AND gfh_kodepromosi(+) = bprh_kodepromosi        
               UNION
                     SELECT '01'||TO_CHAR(bprk_tgltransaksi,'-MM-YYYY') bom, TRUNC(LAST_DAY(bprk_tgltransaksi)) eom,
              bprk_prdcd_hadiah prdcd, bprk_qtypengambilan qty, gfh_kodepromosi, gfh_namapromosi, gfh_tglawal, gfh_tglakhir 
                     FROM TBTR_BRGPROMOSI_KASIR, TBTR_GIFT_HDR
                     WHERE bprk_kodeigr = $kodeigr
              AND TO_CHAR(bprk_tgltransaksi, 'MM-YYYY') = TO_CHAR(TO_DATE('$date', 'MM-YYYY'),'MM-YYYY')
                          AND gfh_kodeigr(+) = bprk_kodeigr
                          AND gfh_kodepromosi(+) = bprk_kodepromosi ) a,TBHISTORY_BRGPROMOSI_STOK, TBMASTER_BRGPROMOSI, TBMASTER_PERUSAHAAN
         WHERE hprs_kodeigr(+) = $kodeigr
               AND hprs_prdcd(+) LIKE SUBSTR(prdcd,1,6)||'%'
               --AND bprp_kodeigr(+) = :p_kodeigr
               AND bprp_prdcd(+) LIKE SUBSTR(prdcd,1,6)||'%'
               AND prs_kodeigr = $kodeigr)
         GROUP BY bom, eom, prdcd, gfh_kodepromosi, gfh_namapromosi, gfh_tglawal, gfh_tglakhir, bprp_ketpanjang,
                kemasan, bprp_frackonversi, prs_namaperusahaan, prs_namacabang, prs_namawilayah
         ORDER BY gfh_kodepromosi, prdcd");

        //  return dd($data);
        return view('BARANGHADIAH.laporanbarangpromosi-pdf', compact('data', 'perusahaan', 'date', 'dataType'));
    }

    public function printNowData(Request $request) {
        $perusahaan = DB::connection(Session::get('connection'))->table("tbmaster_perusahaan")->first();
        $kodeigr = Session::get('kdigr');
        $dataType = 'now';
        $date = $request->date;
        
        $data = DB::connection(Session::get('connection'))
                ->select("SELECT DISTINCT '01' || TO_CHAR (TO_DATE('$date', 'MM-YYYY'), '-MM-YYYY') BOM, BPRS_PRDCD PRDCD, BPRS_KODEPERJANJIAN, 
                                GFH_KODEPROMOSI, GFH_NAMAPROMOSI, GFH_TGLAWAL, GFH_TGLAKHIR,
                                BPRP_KETPANJANG, BPRP_UNIT || '/' || BPRP_FRACKONVERSI KEMASAN,
                                BPRP_FRACKONVERSI, NVL (BPRS_QTYAWAL, 0) QTYAWAL,
                            NVL (BPRS_QTYBPB, 0) QTYBPB, NVL (BPRS_QTYDARICABANG, 0) QTYDRCAB,
                            NVL (BPRS_QTYSALES, 0) QTYSALES, NVL (BPRS_QTYKECABANG, 0) QTYKECAB,
                            NVL (BPRS_QTYADJUSTMENT, 0) QTYMPP, NVL (BPRS_QTYAKHIR, 0) QTYAKHIR,
                            PRS_NAMAPERUSAHAAN, PRS_NAMACABANG, PRS_NAMAWILAYAH
                        FROM TBTR_BRGPROMOSI_STOK, TBTR_GIFT_HDR, TBMASTER_BRGPROMOSI, TBMASTER_PERUSAHAAN
                        WHERE BPRS_KODEIGR(+) = $kodeigr
                            AND GFH_KODEIGR(+) = BPRS_KODEIGR
                            AND GFH_KODEPROMOSI(+) = BPRS_KODEPROMOSI
                            AND BPRP_PRDCD(+) LIKE SUBSTR (BPRS_PRDCD, 1, 6) || '%'");
        
        return view('BARANGHADIAH.laporanbarangpromosi-pdf', compact('data', 'perusahaan', 'date', 'dataType'));
    }
}
