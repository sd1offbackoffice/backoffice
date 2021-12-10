<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 14/10/2021
 * Time: 10:45 AM
 */

namespace App\Http\Controllers\TABEL\SETTINGHADIAHPADATRANSAKSIKASIR;

use App\Http\Controllers\Auth\loginController;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class HadiahUntukGabunganItemController extends Controller
{

    public function index()
    {
        return view('TABEL.SETTINGHADIAHPADATRANSAKSIKASIR.hadiah-untuk-gabungan-item');
    }

    public function ModalGabungan(){
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table("TBTR_INSTORE_HDR")
            ->selectRaw("ISH_NAMAPROMOSI")
            ->selectRaw("ISH_KODEPROMOSI")
            ->selectRaw("TO_CHAR(ISH_TGLAWAL, 'dd-MM-yyyy') || ' s/d ' || TO_CHAR(ISH_TGLAKHIR, 'dd-MM-yyyy') BERLAKU")
            ->where('ISH_KODEIGR','=',$kodeigr)
            ->where('ISH_JENISPROMOSI','=','H')
            ->orderByDesc("ISH_KODEPROMOSI")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function ModalHadiah(){
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table("TBMASTER_BRGPROMOSI")
            ->selectRaw("BPRP_KETPANJANG")
            ->selectRaw("BPRP_PRDCD")
            ->selectRaw("BPRP_UNIT || '/' || BPRP_FRACKONVERSI as satuan")

            ->where('BPRP_KODEIGR','=',$kodeigr)
            ->orderBy("BPRP_KETPANJANG")

            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function ModalPlu(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table("TBMASTER_PRODMAST")
            ->selectRaw("PRD_DESKRIPSIPANJANG")
            ->selectRaw("PRD_UNIT || '/' || PRD_FRAC FRAC")
            ->selectRaw("TO_CHAR(PRD_HRGJUAL, '999g999g999') HRGJUAL")
            ->selectRaw("PRD_KODETAG")
            ->selectRaw("PRD_MINJUAL JUAL")
            ->selectRaw("PRD_PRDCD")

            ->where('PRD_DESKRIPSIPANJANG','LIKE','%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_UNIT','LIKE','%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_FRAC','LIKE','%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_HRGJUAL','LIKE','%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_KODETAG','LIKE','%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_MINJUAL','LIKE','%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_PRDCD','LIKE','%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

//            ->where('PRD_KODEIGR','=',$kodeigr)
//            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function ModalSupp(){
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->table("tbmaster_supplier")
            ->selectRaw("sup_namasupplier")
            ->selectRaw("sup_kodesupplier")

            ->where('sup_kodeigr','=',$kodeigr)
            ->orderBy("sup_kodesupplier")

            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function CheckPlu(Request $request){
        $kodeigr = Session::get('kdigr');
        $kode = $request->kode;

        $datas = DB::connection(Session::get('connection'))->select("SELECT prd_prdcd, PRD_DESKRIPSIPANJANG || '-' || PRD_UNIT || '/' || PRD_FRAC as deskripsi
          FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
         WHERE prd_kodeigr = '$kodeigr'
           AND prd_prdcd = brc_prdcd(+)
           AND (prd_prdcd = TRIM ('$kode') OR brc_barcode = TRIM ('$kode'))");

        return response()->json($datas);
    }

    public function ChooseMerk(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table("TBMASTER_PRODMAST")
            ->selectRaw("PRD_DESKRIPSIPANJANG")
            ->selectRaw("PRD_PRDCD")
            ->where('PRD_DESKRIPSIPANJANG','LIKE','%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function chooseSupplier(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table("tbmaster_hargabeli")
            ->selectRaw("PRD_DESKRIPSIPANJANG")
            ->selectRaw("PRD_PRDCD")
            ->leftJoin('TBMASTER_PRODMAST', 'HGB_PRDCD', 'PRD_PRDCD')
            ->where('HGB_KODESUPPLIER','=',$search)
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->get();

        return Datatables::of($datas)->make(true);
    }


    public function GetDetail(Request $request){
        $kodeigr = Session::get('kdigr');
        $kode = $request->kode;

        $datas = DB::connection(Session::get('connection'))->table("TBTR_INSTORE_DTL")
            ->selectRaw("ISD_PRDCD")
            ->selectRaw("ISD_KODEIGR")
            ->selectRaw("ISD_RECORDID")
            ->selectRaw("ISd_KODEPROMOSI")

            ->selectRaw("ISH_NAMAPROMOSI")
            ->selectRaw("TO_CHAR(ISH_TGLAWAL, 'dd-MM-yyyy') as ish_tglawal")
            ->selectRaw("TO_CHAR(ISH_TGLAKHIR, 'dd-MM-yyyy') as ish_tglakhir")
            ->selectRaw("ish_minstruk")
            ->selectRaw("ish_minsponsor")
            ->selectRaw("ish_maxsponsor")
            ->selectRaw("ish_prdcdhadiah")
            ->selectRaw("ish_jmlhadiah")
            ->selectRaw("ish_kelipatanhadiah")
            ->selectRaw("ish_qtyalokasi")
            ->selectRaw("ish_qtyalokasiout")

            ->selectRaw("ish_reguler")
            ->selectRaw("ish_regulerbiruplus")
            ->selectRaw("ish_freepass")
            ->selectRaw("ish_retailer")
            ->selectRaw("ish_silver")
            ->selectRaw("ish_platinum")
            ->selectRaw("ish_gold1")
            ->selectRaw("ish_gold2")
            ->selectRaw("ish_gold3")

            ->selectRaw("PRD_DESKRIPSIPANJANG")

//            ->selectRaw("ISD_JENISPROMOSI")
//            ->selectRaw("trunc(ISD_TGLAWAL) as tglawal")
//            ->selectRaw("trunc(ISD_TGLAKHIR) as tglakhir")
//            ->selectRaw("ISD_MINPCS")
//            ->selectRaw("ISD_MINRPH")
//            ->selectRaw("ISD_MAXPCS")
//            ->selectRaw("ISD_MAXRPH")
//            ->selectRaw("ISD_CREATE_BY")
//            ->selectRaw("trunc(ISD_CREATE_DT) as create_dt")
//            ->selectRaw("ISD_MODIFY_BY")
//            ->selectRaw("trunc(ISD_MODIFY_DT) as modify_dt")
            ->leftJoin('TBTR_INSTORE_HDR', 'isd_kodepromosi', 'ish_kodepromosi')
            ->leftJoin('TBMASTER_PRODMAST', 'ISD_PRDCD', 'PRD_PRDCD')
            ->where("ISD_KODEIGR",'=',$kodeigr)
            ->where("ISD_KODEPROMOSI",'=',$kode)
            ->where("ISD_JENISPROMOSI",'=','H')
            ->get();
        if(trim($datas[0]->isd_prdcd) == "ALLITEM"){
            $infoall = "ALL ITEM PRODUK SPONSOR";
        }else{
            $infoall = "";
        }

        return response()->json(['datas' => $datas, 'infoall' => $infoall]);
    }

    public function GetNew(){
        $kodeigr = Session::get('kdigr');
        $result = '';

        $connect = loginController::getConnectionProcedure();

        $query = oci_parse($connect, "BEGIN :ret := F_IGR_GET_NOMOR ('$kodeigr',
                               'I' || TO_CHAR(SYSDATE, 'yy'),
                               'Nomor Promo InStore',
                               'H' || CHR (TO_CHAR (SYSDATE, 'yy') + 48), --'H',  tgl 3Jan17 minta ditambahin tahun agar tidak bentrok dengan kode tahun sebelumnya
                               3, --4,
                               FALSE
                               ); END;");
        oci_bind_by_name($query, ':ret', $result, 32);
        oci_execute($query);

        return response()->json($result);
    }

    public function GetHistory(Request $request){
        $kodeigr = Session::get('kdigr');
        $prdcd = $request->prdcd;
        $kode = $request->kode;

        $datas = DB::connection(Session::get('connection'))->select("SELECT ISH_TGLAWAL, ISH_TGLAKHIR, ISD_MINPCS, ISD_MINRPH, ISD_MAXPCS, ISD_MAXRPH,
	  	ISH_PRDCDHADIAH, ISH_JMLHADIAH, ISH_KELIPATANHADIAH, ISH_MAXJMLHARI, ISH_MAXFREKHARI, ISH_MAXOUTHARI,
	  	ISH_QTYALOKASI, NVL(ISH_QTYALOKASIOUT,0) as pakai, ISH_REGULER, ISH_REGULERBIRUPLUS, ISH_FREEPASS, ISH_RETAILER, ISH_SILVER,
	  	ISH_GOLD1, ISH_GOLD2, ISH_GOLD3, ISH_PLATINUM, ISH_KETERANGAN, ISH_MAXFREKEVENT, ISH_MAXJMLEVENT
			FROM TBTR_INSTORE_DTL, TBTR_INSTORE_HDR
			WHERE ISD_KODEIGR = '$kodeigr' AND ISD_PRDCD = '$prdcd' AND ISD_JENISPROMOSI = 'I' AND ISD_KODEPROMOSI = '$kode'
			AND ISH_KODEIGR = ISD_KODEIGR AND ISH_KODEPROMOSI = ISD_KODEPROMOSI AND ISH_JENISPROMOSI = 'I'");

        return response()->json($datas[0]);
    }

    public function SaveData(Request $request){
        try{
            DB::connection(Session::get('connection'))->beginTransaction();
            $kodeigr = Session::get('kdigr');
            $usid = Session::get('usid');

            $status = $request->statusform;
            $kodegab = $request->kodegab;
            $deskripsievent = $request->deskripsievent;
            $dateA = $request->date1;
            $dateB = $request->date2;
            $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
            $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');

            $minstruk = $request->minstruk;
            $minsponsor = $request->minsponsor;
            if($minstruk != '0' && $minsponsor == '0'){
                $info = "ALLITEM";
            }else{
                $info = "";
            }
            $maxsponsor = $request->maxsponsor;
            $hadiah = $request->hadiah;
            $jumlahhadiah = $request->jumlahhadiah;
            $kelipatan = $request->kelipatan;
            $alokasi = $request->alokasi;
            $maxjmlhari = $request->maxjmlhari;
            $maxouthari = $request->maxouthari;
            $maxfrekevent = $request->maxfrekevent;

            $reguler = $request->reguler;
            $freepass = $request->freepass;
            $retailer = $request->retailer;
            $regulerbiruplus = $request->regulerbiruplus;
            $silver = $request->silver;
            $gold1 = $request->gold1;
            $gold2 = $request->gold2;
            $gold3 = $request->gold3;
            $platinum = $request->platinum;

            $produk = $request->produksponsor;
            if($produk == null){
                $produk = [];
            }

            if($status == 'new'){
                $nomor = '';
                $connect = loginController::getConnectionProcedure();

                $query = oci_parse($connect, "BEGIN :cREG := F_IGR_GET_NOMOR ('$kodeigr',
                             'I' || TO_CHAR (SYSDATE, 'yy'),
                             'Nomor Promo InStore',
                             'H' || CHR (TO_CHAR (SYSDATE, 'yy') + 48), --'H',  tgl 3Jan17 minta ditambahin tahun agar tidak bentrok dengan kode tahun sebelumnya
                             3, --4,
                             TRUE
                            ); END;");
                oci_bind_by_name($query, ':cREG', $nomor, 32);
                oci_execute($query);
                $kodegab = $nomor;

                DB::connection(Session::get('connection'))->table("TBTR_INSTORE_HDR")
                    ->insert([
                        "ISH_KODEIGR" => $kodeigr,
                        "ISH_KODEPROMOSI" => $kodegab,
                        "ISH_NAMAPROMOSI" => $deskripsievent,
                        "ISH_JENISPROMOSI" => 'H',
                        "ISH_TGLAWAL" => DB::RAW("TO_DATE('$sDate','DD-MM-YYYY')"),
                        "ISH_TGLAKHIR" => DB::RAW("TO_DATE('$eDate','DD-MM-YYYY')"),
                        "ISH_PRDCDHADIAH" => $hadiah,
                        "ISH_JMLHADIAH" => $jumlahhadiah,
                        "ISH_KELIPATANHADIAH" => $kelipatan,
                        "ISH_FLAGKESEMPATAN" => '',
                        "ISH_MAXJMLHARI" => $maxjmlhari,
                        "ISH_MAXFREKHARI" => '0',
                        "ISH_MAXOUTHARI" => $maxouthari,
                        "ISH_QTYALOKASI" => $alokasi,
                        "ISH_QTYALOKASIOUT" => 0,
                        "ISH_KETERANGAN" => '',
                        "ISH_MAXJMLEVENT" => 0,
                        "ISH_MAXFREKEVENT" => $maxfrekevent,
                        "ISH_MINSTRUK" => $minstruk,
                        "ISH_MINSPONSOR" => $minsponsor,
                        "ISH_MAXSPONSOR" => $maxsponsor,
                        "ISH_REGULER" => $reguler,
                        "ISH_FREEPASS" => $freepass,
                        "ISH_RETAILER" => $retailer,
                        "ISH_CREATE_BY" => $usid,
                        "ISH_CREATE_DT" => DB::Raw('SYSDATE'),
                        "ISH_REGULERBIRUPLUS" => $regulerbiruplus,
                        "ISH_SILVER" => $silver,
                        "ISH_GOLD1" => $gold1,
                        "ISH_GOLD2" => $gold2,
                        "ISH_GOLD3" => $gold3,
                        "ISH_PLATINUM" => $platinum
                    ]);
                if($info == "ALLITEM"){
                    DB::connection(Session::get('connection'))->table("TBTR_INSTORE_DTL")
                        ->insert([
                            "ISD_KODEIGR" => $kodeigr,
                            "ISD_KODEPROMOSI" => $kodegab,
                            "ISD_JENISPROMOSI" => 'H',
                            "ISD_TGLAWAL" => DB::RAW("TO_DATE('$sDate','DD-MM-YYYY')"),
                            "ISD_TGLAKHIR" => DB::RAW("TO_DATE('$eDate','DD-MM-YYYY')"),
                            "ISD_PRDCD" => 'ALLITEM',
                            "ISD_MINPCS" => 0,
                            "ISD_MINRPH" => 0,
                            "ISD_MAXPCS" => 0,
                            "ISD_MAXRPH" => 0,
                            "ISD_CREATE_BY" => $usid,
                            "ISD_CREATE_DT" => DB::Raw('SYSDATE')
                        ]);
                }else{
                    for($i=0;$i<sizeof($produk);$i++){
                        DB::connection(Session::get('connection'))->table("TBTR_INSTORE_DTL")
                            ->insert([
                                "ISD_KODEIGR" => $kodeigr,
                                "ISD_KODEPROMOSI" => $kodegab,
                                "ISD_JENISPROMOSI" => 'H',
                                "ISD_TGLAWAL" => DB::RAW("TO_DATE('$sDate','DD-MM-YYYY')"),
                                "ISD_TGLAKHIR" => DB::RAW("TO_DATE('$eDate','DD-MM-YYYY')"),
                                "ISD_PRDCD" => $produk[$i],
                                "ISD_MINPCS" => 0,
                                "ISD_MINRPH" => 0,
                                "ISD_MAXPCS" => 0,
                                "ISD_MAXRPH" => 0,
                                "ISD_CREATE_BY" => $usid,
                                "ISD_CREATE_DT" => DB::Raw('SYSDATE')
                            ]);
                    }
                }

            }else{
                $temp = DB::connection(Session::get('connection'))->table("TBTR_INSTORE_HDR")
                    ->selectRaw("ISH_CREATE_BY")
                    ->selectRaw("ISH_CREATE_DT")
                    ->where("ISH_KODEPROMOSI",'=',$kodegab)
                    ->first();
                $creator = $temp->ish_create_by;
                $create_dt = $temp->ish_create_dt;

                DB::connection(Session::get('connection'))->table("TBTR_INSTORE_HDR")
                    ->insert([
                        "ISH_KODEIGR" => $kodeigr,
                        "ISH_KODEPROMOSI" => $kodegab,
                        "ISH_NAMAPROMOSI" => $deskripsievent,
                        "ISH_JENISPROMOSI" => 'H',
                        "ISH_TGLAWAL" => DB::RAW("TO_DATE('$sDate','DD-MM-YYYY')"),
                        "ISH_TGLAKHIR" => DB::RAW("TO_DATE('$eDate','DD-MM-YYYY')"),
                        "ISH_PRDCDHADIAH" => $hadiah,
                        "ISH_JMLHADIAH" => $jumlahhadiah,
                        "ISH_KELIPATANHADIAH" => $kelipatan,
                        "ISH_FLAGKESEMPATAN" => '',
                        "ISH_MAXJMLHARI" => $maxjmlhari,
                        "ISH_MAXFREKHARI" => '0',
                        "ISH_MAXOUTHARI" => $maxouthari,
                        "ISH_QTYALOKASI" => $alokasi,
                        "ISH_QTYALOKASIOUT" => 0,
                        "ISH_KETERANGAN" => '',
                        "ISH_MAXJMLEVENT" => 0,
                        "ISH_MAXFREKEVENT" => $maxfrekevent,
                        "ISH_MINSTRUK" => $minstruk,
                        "ISH_MINSPONSOR" => $minsponsor,
                        "ISH_MAXSPONSOR" => $maxsponsor,
                        "ISH_REGULER" => $reguler,
                        "ISH_FREEPASS" => $freepass,
                        "ISH_RETAILER" => $retailer,
                        "ISH_CREATE_BY" => $creator,
                        "ISH_CREATE_DT" => $create_dt,
                        "ISH_MODIFY_BY" => $usid,
                        "ISH_MODIFY_DT" => DB::Raw('SYSDATE'),
                        "ISH_REGULERBIRUPLUS" => $regulerbiruplus,
                        "ISH_SILVER" => $silver,
                        "ISH_GOLD1" => $gold1,
                        "ISH_GOLD2" => $gold2,
                        "ISH_GOLD3" => $gold3,
                        "ISH_PLATINUM" => $platinum
                    ]);
                if($info == "ALLITEM"){
                    DB::connection(Session::get('connection'))->table("TBTR_INSTORE_DTL")
                        ->insert([
                            "ISD_KODEIGR" => $kodeigr,
                            "ISD_KODEPROMOSI" => $kodegab,
                            "ISD_JENISPROMOSI" => 'H',
                            "ISD_TGLAWAL" => DB::RAW("TO_DATE('$sDate','DD-MM-YYYY')"),
                            "ISD_TGLAKHIR" => DB::RAW("TO_DATE('$eDate','DD-MM-YYYY')"),
                            "ISD_PRDCD" => 'ALLITEM',
                            "ISD_MINPCS" => 0,
                            "ISD_MINRPH" => 0,
                            "ISD_MAXPCS" => 0,
                            "ISD_MAXRPH" => 0,
                            "ISD_CREATE_BY" => $creator,
                            "ISD_CREATE_DT" => $create_dt,
                            "ISD_MODIFY_BY" => $usid,
                            "ISD_MODIFY_DT" => DB::Raw('SYSDATE')
                        ]);
                }else{
                    for($i=0;$i<sizeof($produk);$i++){
                        DB::connection(Session::get('connection'))->table("TBTR_INSTORE_DTL")
                            ->insert([
                                "ISD_KODEIGR" => $kodeigr,
                                "ISD_KODEPROMOSI" => $kodegab,
                                "ISD_JENISPROMOSI" => 'H',
                                "ISD_TGLAWAL" => DB::RAW("TO_DATE('$sDate','DD-MM-YYYY')"),
                                "ISD_TGLAKHIR" => DB::RAW("TO_DATE('$eDate','DD-MM-YYYY')"),
                                "ISD_PRDCD" => $produk[$i],
                                "ISD_MINPCS" => 0,
                                "ISD_MINRPH" => 0,
                                "ISD_MAXPCS" => 0,
                                "ISD_MAXRPH" => 0,
                                "ISD_CREATE_BY" => $creator,
                                "ISD_CREATE_DT" => $create_dt,
                                "ISD_MODIFY_BY" => $usid,
                                "ISD_MODIFY_DT" => DB::Raw('SYSDATE')
                            ]);
                    }
                }
            }
            DB::connection(Session::get('connection'))->commit();
            return response()->json(['title' => 'Data Sudah Disimpan !!'],200);
        }catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
//                'title' => $e->getMessage()
                'title' => 'Gagal menyimpan data!'
            ],500);
        }

    }
}
