<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 04/10/2021
 * Time: 15:02 PM
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

class HadiahPerItemBarangController extends Controller
{

    public function index()
    {
        return view('TABEL.SETTINGHADIAHPADATRANSAKSIKASIR.hadiah-per-item-barang');
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
            ->selectRaw("NULL REG")

            ->where('PRD_DESKRIPSIPANJANG','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_UNIT','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_FRAC','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_HRGJUAL','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_KODETAG','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_MINJUAL','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->orWhere('PRD_PRDCD','LIKE', '%'.$search.'%')
            ->where('PRD_KODEIGR','=',$kodeigr)
            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")

            ->limit(1000)
            ->get();

//        $datas = DB::connection(Session::get('connection'))->table("TBMASTER_PRODMAST")
//            ->selectRaw("PRD_DESKRIPSIPANJANG")
//            ->selectRaw("PRD_UNIT || '/' || PRD_FRAC FRAC")
//            ->selectRaw("TO_CHAR(PRD_HRGJUAL, '999g999g999') HRGJUAL")
//            ->selectRaw("PRD_KODETAG")
//            ->selectRaw("PRD_MINJUAL JUAL")
//            ->selectRaw("PRD_PRDCD")
//            ->selectRaw("NULL REG")
//            ->where('PRD_KODEIGR','=',$kodeigr)
//            ->whereRaw("SUBSTR(PRD_PRDCD,7,1) = '0'")
//            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function ModalHadiah(Request $request){
        $kodeigr = Session::get('kdigr');
        $search = $request->value;

        $datas = DB::connection(Session::get('connection'))->table("TBMASTER_BRGPROMOSI")
            ->selectRaw("BPRP_KETPANJANG")
            ->selectRaw("BPRP_PRDCD")
            ->selectRaw("BPRP_UNIT || '/' || BPRP_FRACKONVERSI as satuan")

            ->where('BPRP_KODEIGR','=',$kodeigr)
            ->orderBy("BPRP_KETPANJANG")

            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function ModalHistory(Request $request){
        $kodeigr = Session::get('kdigr');

        $datas = DB::connection(Session::get('connection'))->select("SELECT ISD_PRDCD, TO_CHAR(ISD_TGLAWAL, 'dd-MM-yyyy') || ' s/d ' || TO_CHAR(ISD_TGLAKHIR,'dd-MM-yyyy') BERLAKU,
ISH_KETERANGAN, ISD_KODEPROMOSI, PRD_DESKRIPSIPANJANG, PRD_UNIT || '/' || PRD_FRAC as satuan FROM TBTR_INSTORE_DTL, TBTR_INSTORE_HDR, TBMASTER_PRODMAST
WHERE ISD_KODEIGR = '$kodeigr' AND ISD_JENISPROMOSI = 'I' AND ISH_KODEIGR = ISD_KODEIGR
AND ISH_JENISPROMOSI = ISD_JENISPROMOSI AND ISH_KODEPROMOSI = ISD_KODEPROMOSI AND TRUNC(ISH_TGLAWAL) = TRUNC(ISD_TGLAWAL)
AND TRUNC(ISH_TGLAKHIR) = TRUNC(ISD_TGLAKHIR) AND PRD_KODEIGR = '$kodeigr' AND PRD_PRDCD = ISD_PRDCD
ORDER BY BERLAKU, ISD_PRDCD");

        return Datatables::of($datas)->make(true);
    }

    public function CheckPlu(Request $request){
        $kodeigr = Session::get('kdigr');
        $prd = $request->prd;

        $datas = DB::connection(Session::get('connection'))->select("SELECT prd_prdcd, PRD_DESKRIPSIPANJANG || '-' || PRD_UNIT || '/' || PRD_FRAC as deskripsi
          FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
         WHERE prd_kodeigr = '22'
           AND prd_prdcd = brc_prdcd(+)
           AND (prd_prdcd = TRIM ('$prd') OR brc_barcode = TRIM ('$prd'))");

        if(sizeof($datas) != 0){
            //#NOTE# :TXT_KODE di program lama nilainya di program lama untuk menampung kode plu yang dipilih untuk dilihat history nya
            $temp = DB::connection(Session::get('connection'))->table("TBTR_INSTORE_DTL")
                ->selectRaw("NVL(COUNT(1),0) as result")
                ->where("ISD_KODEIGR",'=',$kodeigr)
                ->where("ISD_JENISPROMOSI",'=','I')
                ->where("ISD_PRDCD",'=',$datas[0]->prd_prdcd)
                ->first();
            if((int)$temp->result == 0){
                $status = 'baru';
            }else{
                $status = 'tidak baru';
            }

            return response()->json(['prdcd' => $datas[0]->prd_prdcd, 'deskripsi' =>$datas[0]->deskripsi, 'status' => $status]);
        }else{
            return response()->json('0');
        }
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

            $status = $request->status;
            $plu = $request->plu;
            $dateA = $request->date1;
            $dateB = $request->date2;
            $sDate = DateTime::createFromFormat('d-m-Y', $dateA)->format('d-m-Y');
            $eDate = DateTime::createFromFormat('d-m-Y', $dateB)->format('d-m-Y');
            $minjmlstruk = $request->minjmlstruk;
            $maxjmlstruk = $request->maxjmlstruk;
            $minrphstruk = $request->minrphstruk;
            $maxrphstruk = $request->maxrphstruk;
            $pluhdh = $request->pluhdh;
            $jmlhadiah = $request->jmlhadiah;
            $kelipatan = $request->kelipatan;
            $maxjmlperhari = $request->maxjmlperhari;
            $maxfrekperhari = $request->maxfrekperhari;
            $maxkeluar = $request->maxkeluar;
            $alokasi = $request->alokasi;
            $sisa = $request->sisa;
            $pakai = $request->pakai;
            $keterangan = $request->keterangan;
            $maxfrekprevent = $request->maxfrekprevent;
            $maxjmlprevent = $request->maxjmlprevent;
            $reguler = $request->reguler;
            $freepass = $request->freepass;
            $retailer = $request->retailer;
            $regulerbiruplus = $request->regulerbiruplus;
            $silver = $request->silver;
            $gold1 = $request->gold1;
            $gold2 = $request->gold2;
            $gold3 = $request->gold3;
            $platinum = $request->platinum;


            if($status == 'baru'){
                $nomor = '';
                $connect = loginController::getConnectionProcedure();

                $query = oci_parse($connect, "BEGIN :cREG := F_IGR_GET_NOMOR('" . Session::get('kdigr') . "','I' || TO_CHAR(SYSDATE, 'yy'),
                               'Nomor Promo InStore',
                               'H' || CHR (TO_CHAR (SYSDATE, 'yy') + 48), --'H',  tgl 3Jan17 minta ditambahin tahun agar tidak bentrok dengan kode tahun sebelumnya
                               3, --4,
                               TRUE
                               ); END;");
                oci_bind_by_name($query, ':cREG', $nomor, 32);
                oci_execute($query);

                DB::connection(Session::get('connection'))->table("TBTR_INSTORE_HDR")
                    ->insert([
                        "ISH_KODEIGR" => $kodeigr,
                        "ISH_KODEPROMOSI" => $nomor,
                        "ISH_NAMAPROMOSI" => 'Promosi InStore per Item',
                        "ISH_JENISPROMOSI" => 'I',
                        "ISH_TGLAWAL" => DB::connection(Session::get('connection'))->raw("TO_DATE('$sDate','DD-MM-YYYY')"),
                        "ISH_TGLAKHIR" => DB::connection(Session::get('connection'))->raw("TO_DATE('$eDate','DD-MM-YYYY')"),
                        "ISH_PRDCDHADIAH" => $pluhdh,
                        "ISH_JMLHADIAH" => $jmlhadiah,
                        "ISH_KELIPATANHADIAH" => $kelipatan,
                        "ISH_FLAGKESEMPATAN" => 'T',
                        "ISH_MAXJMLHARI" => $maxjmlperhari,
                        "ISH_MAXFREKHARI" => $maxfrekperhari,
                        "ISH_MAXOUTHARI" => $maxkeluar,
                        "ISH_QTYALOKASI" => $alokasi,
                        "ISH_REGULER" => $reguler,
                        "ISH_FREEPASS" => $freepass,
                        "ISH_RETAILER" => $retailer,
                        "ISH_KETERANGAN" => $keterangan,
                        "ISH_MAXJMLEVENT" => $maxjmlprevent,
                        "ISH_MAXFREKEVENT" => $maxfrekprevent,
                        "ISH_CREATE_BY" => $usid,
                        "ISH_CREATE_DT" => Carbon::now(),
                        "ISH_QTYALOKASIOUT" => 0,
                        "ISH_MINSTRUK" => 0,
                        "ISH_MINSPONSOR" => 0,
                        "ISH_MAXSPONSOR" => 0,
                        "ISH_REGULERBIRUPLUS" => $regulerbiruplus,
                        "ISH_SILVER" => $silver,
                        "ISH_GOLD1" => $gold1,
                        "ISH_GOLD2" => $gold2,
                        "ISH_GOLD3" => $gold3,
                        "ISH_PLATINUM" => $platinum
                    ]);
                DB::connection(Session::get('connection'))->table("TBTR_INSTORE_DTL")
                    ->insert([
                        "ISD_KODEIGR" => $kodeigr,
                        "ISD_KODEPROMOSI" => $nomor,
                        "ISD_JENISPROMOSI" => 'I',
                        "ISD_TGLAWAL" => DB::connection(Session::get('connection'))->raw("TO_DATE('$sDate','DD-MM-YYYY')"),
                        "ISD_TGLAKHIR" => DB::connection(Session::get('connection'))->raw("TO_DATE('$eDate','DD-MM-YYYY')"),
                        "ISD_PRDCD" => $plu,
                        "ISD_MINPCS" => $minjmlstruk,
                        "ISD_MINRPH" => $minrphstruk,
                        "ISD_MAXPCS" => $maxjmlstruk,
                        "ISD_MAXRPH" => $maxrphstruk,
                        "ISD_CREATE_BY" => $usid,
                        "ISD_CREATE_DT" => Carbon::now()
                    ]);
            }else{
                DB::connection(Session::get('connection'))->table("TBTR_INSTORE_HDR")
                    ->where("ISH_KODEIGR",'=',$kodeigr)
                    ->where("ISH_JENISPROMOSI",'=','I')
                    ->where("ISH_KODEPROMOSI",'=',$status)
                    ->update([
                        "ISH_TGLAWAL" => DB::connection(Session::get('connection'))->raw("TO_DATE('$sDate','DD-MM-YYYY')"),
                        "ISH_TGLAKHIR" => DB::connection(Session::get('connection'))->raw("TO_DATE('$eDate','DD-MM-YYYY')"),
                        "ISH_PRDCDHADIAH" => $pluhdh,
                        "ISH_JMLHADIAH" => $jmlhadiah,
                        "ISH_KELIPATANHADIAH" => $kelipatan,
                        "ISH_MAXJMLHARI" => $maxjmlperhari,
                        "ISH_MAXFREKHARI" => $maxfrekperhari,
                        "ISH_MAXOUTHARI" => $maxkeluar,
                        "ISH_QTYALOKASI" => $alokasi,
                        "ISH_REGULER" => $reguler,
                        "ISH_FREEPASS" => $freepass,
                        "ISH_RETAILER" => $retailer,
                        "ISH_REGULERBIRUPLUS" => $regulerbiruplus,
                        "ISH_SILVER" => $silver,
                        "ISH_GOLD1" => $gold1,
                        "ISH_GOLD2" => $gold2,
                        "ISH_GOLD3" => $gold3,
                        "ISH_PLATINUM" => $platinum,
                        "ISH_KETERANGAN" => $keterangan,
                        "ISH_MAXJMLEVENT" => $maxjmlprevent,
                        "ISH_MAXFREKEVENT" => $maxfrekprevent,
                        "ISH_MODIFY_BY" => $usid,
                        "ISH_MODIFY_DT" => Carbon::now()
                    ]);

                DB::connection(Session::get('connection'))->table("TBTR_INSTORE_DTL")
                    ->where("ISD_KODEIGR",'=',$kodeigr)
                    ->where("ISD_JENISPROMOSI",'=','I')
                    ->where("ISD_KODEPROMOSI",'=',$status)
                    ->where("ISD_PRDCD",'=',$plu)
                    ->update([
                        "ISD_TGLAWAL" => DB::connection(Session::get('connection'))->raw("TO_DATE('$sDate','DD-MM-YYYY')"),
                        "ISD_TGLAKHIR" => DB::connection(Session::get('connection'))->raw("TO_DATE('$eDate','DD-MM-YYYY')"),
                        "ISD_MINPCS" => $minjmlstruk,
                        "ISD_MINRPH" => $minrphstruk,
                        "ISD_MAXPCS" => $maxjmlstruk,
                        "ISD_MAXRPH" => $maxrphstruk,
                        "ISD_MODIFY_BY" => $usid,
                        "ISD_MODIFY_DT" => Carbon::now()
                    ]);
            }
            DB::connection(Session::get('connection'))->commit();
            return response()->json(['title' => 'Data Sudah Disimpan !!'],200);
        }catch (QueryException $e){
            DB::connection(Session::get('connection'))->rollBack();

            return response()->json([
                'title' => 'Gagal menyimpan data!'
            ],500);
        }

    }
}
