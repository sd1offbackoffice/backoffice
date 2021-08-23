<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 1/12/2021
 * Time: 3:25 PM
 */

namespace App\Http\Controllers\FRONTOFFICE;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PDF;
use DateTime;
use Yajra\DataTables\DataTables;

class spbmanualController extends Controller
{

    public function index()
    {
        return view('FRONTOFFICE.spbmanual');
    }

    public function getPlu(Request $request){
        $search = $request->value;
        $datas = DB::table("tbmaster_prodmast")
            ->selectRaw("prd_deskripsipanjang, prd_unit||'/'||prd_frac satuan, prd_prdcd")
            ->whereRaw("SUBSTR(prd_prdcd,-1)='0'")
            ->where("prd_deskripsipanjang",'LIKE','%'.$search.'%')

            ->orWhereRaw("SUBSTR(prd_prdcd,-1)='0'")
            ->where("prd_unit",'LIKE','%'.$search.'%')

            ->orWhereRaw("SUBSTR(prd_prdcd,-1)='0'")
            ->where("prd_frac",'LIKE','%'.$search.'%')

            ->orWhereRaw("SUBSTR(prd_prdcd,-1)='0'")
            ->where("prd_prdcd",'LIKE','%'.$search.'%')

            ->orderBy('prd_deskripsipanjang')
            ->limit(100)
            ->get();

        return Datatables::of($datas)->make(true);
    }

    public function translate(string $a, string $b, string $c){
        $result = '';
        $sentence = str_split($a);
        $target = str_split($b);


        if(strlen($c)>1){
            $change = str_split($c);
            if(strlen($b) == strlen($c)){
                for($i=0;$i<sizeof($sentence);$i++){
                    for($j=0;$j<sizeof($target);$j++){
                        if($sentence[$i] == $target[$j]){
                            $sentence[$i] = $change[$j];
                        }
                    }
                }
            }else{
                return false;
            }
        }else{
            $change = $c;
            for($i=0;$i<sizeof($sentence);$i++){
                for($j=0;$j<sizeof($target);$j++){
                    if($sentence[$i] == $target[$j]){
                        $sentence[$i] = $change;
                    }
                }
            }
        }

        foreach ($sentence as $char){
            $result = $result.$char;
        }

        return $result;
    }

    public function choosePlu(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $plu = $request->plu;
        //------->>>>>>> Baca Barcode <<<<<<<------- 1
        if(substr($plu,1,1) == '#'){
            $barcode = substr($plu,2);
            if(strlen(trim($this->translate($barcode,' +-.0123456789',' '))) > 0){
                //Kode Barcode Salah, kode 1
                return response()->json(1);
            }
            $temp_brc = DB::table("TBMASTER_BARCODE")
                ->selectRaw("NVL (COUNT (*), 0) as a")
                ->where("BRC_BARCODE",'=',$barcode)
                ->first();
            if((int)$temp_brc->a == 0){
                //Kode Barcode Tidak Terdaftar, kode 2
                return response()->json(2);
            }elseif((int)$temp_brc->a > 1){
                //BARCODE DOUBLE, kode 3
                return response()->json(3);
            }else{
                $pluTemp = DB::table("TBMASTER_BARCODE")
                    ->selectRaw("BRC_PRDCD")
                    ->where("BRC_BARCODE",'=',$barcode)
                    ->first();
                $plu = $pluTemp->brc_prdcd;
            }
        }
        //------->>>>>>> Baca Barcode <<<<<<<------- 2
        if(strlen($plu) < 7){
            $plu = str_pad($plu,7,"0",STR_PAD_LEFT);
        }
        if(strlen(trim($this->translate($plu,'0123456789',' '))) > 0){
            //PLU Salah, kode 4
            return response()->json(4);
        }
        //tak perlu periksa bila $plu == 0 atau tidak, $plu telah dibuat tidak bisa kosong di javaascript, langsung masuk ke bagian else
        $temp = DB::select("SELECT distinct PRD_DESKRIPSIPANJANG, PRD_UNIT || '/' || PRD_FRAC satuan, PRD_FRAC, SUBSTR (PRDCD, 1, 6) || '0' plu, PRD_BARCODE
          FROM TBMASTER_PRODMAST,
               (SELECT PRD_PRDCD PRDCD, BRC_BARCODE
                  FROM TBMASTER_PRODMAST, TBMASTER_BARCODE
                 WHERE PRD_PRDCD = BRC_PRDCD(+)
                   AND PRD_KODEIGR = '$kodeigr'
                   AND (PRD_PRDCD = Trim ('$plu') OR BRC_BARCODE = Trim ('$plu')))
         WHERE PRD_PRDCD = SUBSTR (PRDCD, 1, 6) || '0'");
        $prd_deskripsipanjang = $temp[0]->prd_deskripsipanjang;
        $satuan = $temp[0]->satuan;
        $frac = $temp[0]->prd_frac;
        $plu = $temp[0]->plu;
        $barcode = $temp[0]->prd_barcode;

        $temp = DB::table("TBMASTER_MAXPALET")
            ->selectRaw("MPT_MAXQTY")
            ->where("MPT_PRDCD",'=',$plu)
            ->whereRaw("ROWNUM = 1")
            ->first();

        //diberi if agar menghindari error
        if($temp == null){
            $maxplt = 0;
        }else{
            $maxplt = (int)$temp->mpt_maxqty;
        }

        //--++parameter tipe++--
        $temp = DB::select("SELECT COUNT (1) as a
				  FROM TBMASTER_LOKASI
				 WHERE LKS_PRDCD IN (
				           SELECT LKS_PRDCD
				             FROM TBMASTER_LOKASI A
				            WHERE LKS_TIPERAK like 'N%'
				              AND NOT EXISTS (SELECT 1
				                                FROM TBMASTER_LOKASI B
				                               WHERE LKS_TIPERAK = 'S' AND A.LKS_PRDCD = B.LKS_PRDCD))
				   AND LKS_PRDCD = '$plu'");

        if((int)$temp[0]->a > 0){
            $jenis = 'N'; //--dari nonstrage gudang
        }elseif ((int)$temp[0]->a == 0){
            $jenis = 'S'; //--dari storage gudang
        }
        //----parameter tipe----
        $temp = DB::table("TBMASTER_LOKASI")
            ->selectRaw("NVL (SUM (LKS_QTY), 0) as rs")
            ->where("LKS_KODERAK",'LIKE','R%')
            ->where("LKS_TIPERAK",'LIKE','S%')
            ->where("LKS_PRDCD",'=',$plu)
            ->first();

        $rsctn = floor($temp->rs / $frac);
        $rspcs = $temp->rs % $frac;

        $temp = DB::table("TBMASTER_LOKASI")
            ->selectRaw("NVL (SUM (LKS_QTY), 0) as gs")
            ->where("LKS_KODERAK",'NOT LIKE','R%')
            ->where("LKS_TIPERAK",'LIKE','S%')
            ->where("LKS_PRDCD",'=',$plu)
            ->first();

        $gsctn = floor($temp->gs / $frac);
        $gspcs = $temp->gs % $frac;

        $temp = DB::table("TBMASTER_LOKASI")
            ->selectRaw("NVL (SUM (LKS_QTY), 0) as nsg")
            ->where("LKS_TIPERAK",'=','N')
            ->where("LKS_PRDCD",'=',$plu)
            ->first();

        $nsgpcs = (int)$temp->nsg;
        ///* Formatted on 2014/03/20 16:44 (Formatter Plus v4.8.6) */
        // di program lama ada pembatas ini trus deklarasi ulang variable

        // Bagian baca barcode di setelah deklarasi ulang variable sama, jadi skip

        //------->>>>>>> Baca Barcode <<<<<<<-------

        //------->>>>>>> Baca Barcode <<<<<<<-------

        //--++parameter tipe++-- ,bagian ini sama seperti ++parameter tipe++ sebelumnya, skip

        //----parameter tipe---- , bagian rs, gs, nsg nya sama, jadi skip bagian itu

        $temp = DB::table("TBTEMP_ANTRIANSPB")
            ->selectRaw("COUNT (1) as a")
            ->where("SPB_PRDCD",'=',$plu)
            ->where("SPB_JENIS",'=','MANUAL')
            ->whereRaw("NVL (SPB_RECORDID, 'ZZZ') = 'ZZZ'")
            ->first();

        if((int)$temp->a > 0){
            //('Ada Antrian SPB Manual untuk PLU ' || :PLU, 'ALERT'), kode 5
            return response()->json(['result' => 5, 'plu' => $plu, 'deskripsi' => $prd_deskripsipanjang, 'satuan' => $satuan, 'barcode' => $barcode, 'jenis' => $jenis,
                'rsctn' => $rsctn, 'rspcs' => $rspcs, 'gsctn' => $gsctn, 'gspcs' => $gspcs, 'nsgpcs' => $nsgpcs, 'maxplt' => $maxplt]);
        }
        //:QTYCTN := 0;
        //:QTYPCS := 0;
        //dua variable ini ga perlu disend
        //go_item ('TIPErak');

        //kode kelanjutan di program lama sama, hanya mengulang pengecekan apakah ada antrian spb manual, skip
        return response()->json(['plu' => $plu, 'deskripsi' => $prd_deskripsipanjang, 'satuan' => $satuan, 'barcode' => $barcode, 'jenis' => $jenis,
            'rsctn' => $rsctn, 'rspcs' => $rspcs, 'gsctn' => $gsctn, 'gspcs' => $gspcs, 'nsgpcs' => $nsgpcs, 'maxplt' => $maxplt]);
    }

    public function checkRak(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $plu = $request->plu;

        $temp = DB::table("TBMASTER_LOKASI")
            ->selectRaw("COUNT (1) as result")
            ->where("LKS_KODEIGR",'=',$kodeigr)
            ->where("LKS_PRDCD",'=',$plu)
            ->where("LKS_KODERAK",'NOT LIKE','D%')
            ->where("LKS_KODERAK",'NOT LIKE','G%')
            ->where("LKS_TIPERAK",'NOT LIKE','S%')
            ->first();
        if($temp->result == 0){
            return response()->json(0);
        }else{
            return response()->json(1);
        }
    }

    public function getRak(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $plu = $request->plu;

        $temp = DB::table("TBMASTER_LOKASI")
            ->selectRaw("LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK, LKS_NOURUT")
            ->where("LKS_KODEIGR",'=',$kodeigr)
            ->where("LKS_PRDCD",'=',$plu)
            ->whereRaw("(LKS_KODERAK LIKE 'R%' OR LKS_KODERAK LIKE 'O%')")
            ->where('LKS_TIPERAK','NOT LIKE','S%')
            ->orderByRaw("LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK, LKS_NOURUT")
            ->get();

        return response()->json($temp);
    }

    public function getRak2(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $plu = $request->plu;

        $temp = DB::select("SELECT   LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK, LKS_NOURUT,
                             LKS_PRDCD
                        FROM TBMASTER_LOKASI
                       WHERE LKS_KODEIGR = '$kodeigr'
                         AND LKS_KODERAK NOT LIKE 'D%'
                         AND LKS_KODERAK NOT LIKE 'G%'
                         AND LKS_TIPERAK like 'S%'
                         AND LKS_PRDCD = '$plu'
                    UNION
                    SELECT   LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK, LKS_NOURUT,
                             LKS_PRDCD
                        FROM TBMASTER_LOKASI
                       WHERE LKS_KODEIGR = '$kodeigr'
                         AND LKS_KODERAK NOT LIKE 'D%'
                         AND LKS_KODERAK NOT LIKE 'G%'
                         AND LKS_TIPERAK like 'S%'
                         AND LKS_QTY = 0
                         AND LKS_PRDCD IS NULL
                    ORDER BY LKS_PRDCD,
                             LKS_KODERAK,
                             LKS_KODESUBRAK,
                             LKS_TIPERAK,
                             LKS_SHELVINGRAK,
                             LKS_NOURUT");

        return response()->json($temp);
    }

    public function getRak3(Request $request)
    {
        $kodeigr = $_SESSION['kdigr'];
        $plu = $request->plu;

        $temp = DB::table("TBMASTER_LOKASI")
            ->selectRaw("LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK, LKS_NOURUT")
            ->where("LKS_KODEIGR",'=',$kodeigr)
            ->where("LKS_PRDCD",'=',$plu)
            ->whereRaw("LKS_KODERAK NOT LIKE 'D%' AND LKS_KODERAK NOT LIKE 'G%'")
            ->where('LKS_TIPERAK','NOT LIKE','S%')
            ->orderByRaw("LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK, LKS_NOURUT")
            ->get();

        return response()->json($temp);
    }

    public function getRakAntrian(Request $request){
        $kodeigr = $_SESSION['kdigr'];
        $plu = $request->plu;

        $temp = DB::table("TBTEMP_ANTRIANSPB")
            ->selectRaw("SPB_PRDCD, SPB_LOKASIASAL, SPB_LOKASITUJUAN, SPB_CREATE_BY, SPB_CREATE_DT, SPB_MINUS, SPB_ID")
            ->where("SPB_PRDCD",'=',$plu)
            ->where("SPB_JENIS",'=','MANUAL')
            ->whereRaw("NVL(SPB_RECORDID,'ZZZ') = 'ZZZ'")
            ->orderBy("SPB_ID")
            ->get();

        return response()->json($temp);
    }

    public function save(Request $request)
    {
        //note : fungsi dalam loopnya banyak sama, hanya mengikuti program sebelumnya, supaya ga bingung
        $kodeigr = $_SESSION['kdigr'];
        $usid = $_SESSION['usid'];
        $plu = $request->plu;
        $jenis = $request->jenis;
        $tiperak = $request->tiperak;
        $lks_to = $request->lks_to;
        $qty = (int)$request->qty;


        $temp = DB::table("TBMASTER_LOKASI")
            ->selectRaw("LKS_QTY")
            ->whereRaw("LKS_KODERAK
           || '.'
           || LKS_KODESUBRAK
           || '.'
           || LKS_TIPERAK
           || '.'
           || LKS_SHELVINGRAK
           || '.'
           || LKS_NOURUT = '$lks_to'")
            ->first();
        $qty_to = (int)$temp->lks_qty;
        DB::beginTransaction();
        if($jenis == 'S'){
            $temp = DB::select("SELECT NVL (SUM (QTYS), 0) as result
          FROM (SELECT   LKS_PRDCD, LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK, LKS_SHELVINGRAK,
                         LKS_NOURUT, LKS_QTY QTYS, SPB_LOKASIASAL, NVL (ANTRIAN, 0) ANTRIAN,
                         PRD_FRAC, PRD_DESKRIPSIPANJANG
                    FROM TBMASTER_LOKASI,
                         TBMASTER_PRODMAST,
                         (SELECT   SPB_PRDCD, SPB_LOKASIASAL, SUM (SPB_MINUS) ANTRIAN
                              FROM TBTEMP_ANTRIANSPB
                             WHERE NVL (SPB_RECORDID, 'zz') = 'zz' AND SPB_JENIS = 'MANUAL'
                          GROUP BY SPB_PRDCD, SPB_LOKASIASAL)
                   WHERE LKS_KODEIGR = '$kodeigr'
                     AND LKS_PRDCD = '$plu'
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
                     AND LKS_TIPERAK like 'S%'
                     AND LKS_KODERAK NOT LIKE 'D%'
                     AND LKS_KODERAK NOT LIKE 'G%'
                     AND LKS_QTY > NVL (ANTRIAN, 0)
                ORDER BY NVL (LKS_EXPDATE, SYSDATE),
                            LKS_KODERAK
                         || '.'
                         || LKS_KODESUBRAK
                         || '.'
                         || LKS_TIPERAK
                         || '.'
                         || LKS_SHELVINGRAK
                         || '.'
                         || LKS_NOURUT)");
        }
        if(((int)$temp[0]->result > 0) && $tiperak == 'display'){

            $rec = DB::select("SELECT   LKS_PRDCD, LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK,
                                 LKS_SHELVINGRAK, LKS_NOURUT, LKS_QTY QTYS, SPB_LOKASIASAL,
                                 NVL (ANTRIAN, 0) ANTRIAN, PRD_FRAC, PRD_DESKRIPSIPANJANG
                            FROM TBMASTER_LOKASI,
                                 TBMASTER_PRODMAST,
                                 (SELECT   SPB_PRDCD, SPB_LOKASIASAL, SUM (SPB_MINUS) ANTRIAN
                                      FROM TBTEMP_ANTRIANSPB
                                     WHERE NVL (SPB_RECORDID, 'zz') = 'zz' AND SPB_JENIS = 'MANUAL'
                                  GROUP BY SPB_PRDCD, SPB_LOKASIASAL)
                           WHERE LKS_KODEIGR = '$kodeigr'
                             AND LKS_PRDCD = '$plu'
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
                             AND LKS_TIPERAK like 'S%'
                             AND LKS_KODERAK NOT LIKE 'D%'
                             AND LKS_KODERAK NOT LIKE 'G%'
                             AND LKS_QTY > NVL (ANTRIAN, 0)
                        ORDER BY NVL (LKS_EXPDATE, SYSDATE),
                                    LKS_KODERAK
                                 || '.'
                                 || LKS_KODESUBRAK
                                 || '.'
                                 || LKS_TIPERAK
                                 || '.'
                                 || LKS_SHELVINGRAK
                                 || '.'
                                 || LKS_NOURUT");
            for($i=0;$i<sizeof($rec);$i++){
                $lks_from = $rec[$i]->lks_koderak.'.'.$rec[$i]->lks_kodesubrak.'.'.$rec[$i]->lks_tiperak.'.'.$rec[$i]->lks_shelvingrak.'.'.$rec[$i]->lks_nourut;

                if($rec[$i]->spb_lokasiasal == null){
                    $seq = DB::select("SELECT SEQ_SPB.NEXTVAL
                      FROM dual");
                    if($qty > (int)$rec[$i]->qtys){
                        $qtyCase = (int)$rec[$i]->qtys;
                    }else{
                        $qtyCase = $qty;
                    }
                    DB::table("TBTEMP_ANTRIANSPB")
                        ->insert(['SPB_PRDCD' => $plu,
                            'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                            'SPB_LOKASIASAL' => $lks_from,
                            'SPB_LOKASITUJUAN' => $lks_to,
                            'SPB_JENIS' => 'MANUAL',
                            'SPB_QTY' => $qty_to,
                            'SPB_MINUS' => $qtyCase,
                            'SPB_ID' => $seq[0]->nextval,
                            'SPB_CREATE_BY' => $usid,
                            'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);
                    DB::table("TBTR_ANTRIANSPB")
                        ->insert(['SPB_PRDCD' => $plu,
                            'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                            'SPB_LOKASIASAL' => $lks_from,
                            'SPB_LOKASITUJUAN' => $lks_to,
                            'SPB_JENIS' => 'MANUAL',
                            'SPB_QTY' => $qty_to,
                            'SPB_MINUS' => $qtyCase,
                            'SPB_ID' => $seq[0]->nextval,
                            'SPB_CREATE_BY' => $usid,
                            'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);
                    $qty = $qty - (int)$rec[$i]->qtys;
                }else{
                    if((int)$rec[$i]->qtys > (int)$rec[$i]->antrian){
                        $temp = DB::table("TBTEMP_ANTRIANSPB")
                            ->selectRaw("COUNT (1) as result")
                            ->whereRaw("NVL (SPB_RECORDID, 'zz') = 'zz'")
                            ->where('SPB_PRDCD','=',$rec[$i]->lks_prdcd)
                            ->where('SPB_LOKASIASAL','=',$lks_from)
                            ->where('SPB_LOKASITUJUAN','=',$lks_to)
                            ->where('spb_jenis','=','MANUAL')
                            ->first();
                        if((int)$temp->result > 0){
                            if((int)$rec[$i]->antrian + $qty > (int)$rec[$i]->qtys){
                                $qtyCase = (int)$rec[$i]->qtys;
                            }else{
                                $qtyCase = (int)$rec[$i]->antrian + $qty;
                            }
                            DB::table("TBTEMP_ANTRIANSPB")
                                ->whereRaw("NVL (SPB_RECORDID, 'zz') = 'zz'")
                                ->where('SPB_PRDCD','=',$rec[$i]->lks_prdcd)
                                ->where('SPB_LOKASIASAL','=',$lks_from)
                                ->where('SPB_LOKASITUJUAN','=',$lks_to)
                                ->where('spb_jenis','=','MANUAL')
                                ->update(['SPB_MINUS' => $qtyCase]);
                            DB::table("TBTR_ANTRIANSPB")
                                ->whereRaw("NVL (SPB_RECORDID, 'zz') = 'zz'")
                                ->where('SPB_PRDCD','=',$rec[$i]->lks_prdcd)
                                ->where('SPB_LOKASIASAL','=',$lks_from)
                                ->where('SPB_LOKASITUJUAN','=',$lks_to)
                                ->where('spb_jenis','=','MANUAL')
                                ->update(['SPB_MINUS' => $qtyCase]);
                        }else{
                            $seq = DB::select("SELECT SEQ_SPB.NEXTVAL
                      FROM dual");
                            if($qty > (int)$rec[$i]->qtys - (int)$rec[$i]->antrian){
                                $qtyCase = (int)$rec[$i]->qtys - (int)$rec[$i]->antrian;
                            }else{
                                $qtyCase = $qty;
                            }

                            DB::table("TBTEMP_ANTRIANSPB")
                                ->insert(['SPB_PRDCD' => $plu,
                                    'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                                    'SPB_LOKASIASAL' => $lks_from,
                                    'SPB_LOKASITUJUAN' => $lks_to,
                                    'SPB_JENIS' => 'MANUAL',
                                    'SPB_QTY' => $qty_to,
                                    'SPB_MINUS' => $qtyCase,
                                    'SPB_ID' => $seq[0]->nextval,
                                    'SPB_CREATE_BY' => $usid,
                                    'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);


                            DB::table("TBTR_ANTRIANSPB")
                                ->insert(['SPB_PRDCD' => $plu,
                                    'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                                    'SPB_LOKASIASAL' => $lks_from,
                                    'SPB_LOKASITUJUAN' => $lks_to,
                                    'SPB_JENIS' => 'MANUAL',
                                    'SPB_QTY' => $qty_to,
                                    'SPB_MINUS' => $qtyCase,
                                    'SPB_ID' => $seq[0]->nextval,
                                    'SPB_CREATE_BY' => $usid,
                                    'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);

                        }
                        $qty = $qty - (int)$rec[$i]->qtys;
                    }
                }
                if($qty <= 0){
                    break;
                }
            }
        }
        //-----<<<<<<< Ambil dari Rak Storage Gudang >>>>>>>-----
        if($qty > 0){
            $rec = DB::select("SELECT LKS_PRDCD, LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK,
                                 LKS_SHELVINGRAK, LKS_NOURUT, LKS_QTY QTYS, SPB_LOKASIASAL,
                                 NVL (ANTRIAN, 0) ANTRIAN, PRD_FRAC, PRD_DESKRIPSIPANJANG
                            FROM TBMASTER_LOKASI,
                                 TBMASTER_PRODMAST,
                                 (SELECT   SPB_PRDCD, SPB_LOKASIASAL, SUM (SPB_MINUS) ANTRIAN
                                      FROM TBTEMP_ANTRIANSPB
                                     WHERE NVL (SPB_RECORDID, 'zz') = 'zz' AND SPB_JENIS = 'MANUAL'
                                  GROUP BY SPB_PRDCD, SPB_LOKASIASAL)
                           WHERE LKS_KODEIGR = '$kodeigr'
                             AND LKS_PRDCD = '$plu'
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
                             AND LKS_TIPERAK like 'S%'
                             AND (LKS_KODERAK LIKE 'D%' OR LKS_KODERAK LIKE 'G%')
                             AND LKS_QTY > NVL (ANTRIAN, 0)
                        ORDER BY NVL (LKS_EXPDATE, SYSDATE),
                                    LKS_KODERAK
                                 || '.'
                                 || LKS_KODESUBRAK
                                 || '.'
                                 || LKS_TIPERAK
                                 || '.'
                                 || LKS_SHELVINGRAK
                                 || '.'
                                 || LKS_NOURUT");

            for($i=0;$i<sizeof($rec);$i++){
                $lks_from = $rec[$i]->lks_koderak.'.'.$rec[$i]->lks_kodesubrak.'.'.$rec[$i]->lks_tiperak.'.'.$rec[$i]->lks_shelvingrak.'.'.$rec[$i]->lks_nourut;

                if($rec[$i]->spb_lokasiasal == null){
                    $seq = DB::select("SELECT SEQ_SPB.NEXTVAL
                      FROM dual");
                    if($qty > (int)$rec[$i]->qtys){
                        $qtyCase = (int)$rec[$i]->qtys;
                    }else{
                        $qtyCase = $qty;
                    }
                    DB::table("TBTEMP_ANTRIANSPB")
                        ->insert(['SPB_PRDCD' => $plu,
                            'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                            'SPB_LOKASIASAL' => $lks_from,
                            'SPB_LOKASITUJUAN' => $lks_to,
                            'SPB_JENIS' => 'MANUAL',
                            'SPB_QTY' => $qty_to,
                            'SPB_MINUS' => $qtyCase,
                            'SPB_ID' => $seq[0]->nextval,
                            'SPB_CREATE_BY' => $usid,
                            'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);
                    DB::table("TBTR_ANTRIANSPB")
                        ->insert(['SPB_PRDCD' => $plu,
                            'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                            'SPB_LOKASIASAL' => $lks_from,
                            'SPB_LOKASITUJUAN' => $lks_to,
                            'SPB_JENIS' => 'MANUAL',
                            'SPB_QTY' => $qty_to,
                            'SPB_MINUS' => $qtyCase,
                            'SPB_ID' => $seq[0]->nextval,
                            'SPB_CREATE_BY' => $usid,
                            'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);
                    $qty = $qty - (int)$rec[$i]->qtys;
                }else{
                    if((int)$rec[$i]->qtys > (int)$rec[$i]->antrian){
                        $temp = DB::table("TBTEMP_ANTRIANSPB")
                            ->selectRaw("COUNT (1) as result")
                            ->whereRaw("NVL (SPB_RECORDID, 'zz') = 'zz'")
                            ->where('SPB_PRDCD','=',$rec[$i]->lks_prdcd)
                            ->where('SPB_LOKASIASAL','=',$lks_from)
                            ->where('SPB_LOKASITUJUAN','=',$lks_to)
                            ->where('spb_jenis','=','MANUAL')
                            ->first();
                        if((int)$temp->result > 0){
                            if((int)$rec[$i]->antrian + $qty > (int)$rec[$i]->qtys){
                                $qtyCase = (int)$rec[$i]->qtys;
                            }else{
                                $qtyCase = (int)$rec[$i]->antrian + $qty;
                            }
                            DB::table("TBTEMP_ANTRIANSPB")
                                ->whereRaw("NVL (SPB_RECORDID, 'zz') = 'zz'")
                                ->where('SPB_PRDCD','=',$rec[$i]->lks_prdcd)
                                ->where('SPB_LOKASIASAL','=',$lks_from)
                                ->where('SPB_LOKASITUJUAN','=',$lks_to)
                                ->where('spb_jenis','=','MANUAL')
                                ->update(['SPB_MINUS' => $qtyCase]);
                            DB::table("TBTR_ANTRIANSPB")
                                ->whereRaw("NVL (SPB_RECORDID, 'zz') = 'zz'")
                                ->where('SPB_PRDCD','=',$rec[$i]->lks_prdcd)
                                ->where('SPB_LOKASIASAL','=',$lks_from)
                                ->where('SPB_LOKASITUJUAN','=',$lks_to)
                                ->where('spb_jenis','=','MANUAL')
                                ->update(['SPB_MINUS' => $qtyCase]);
                        }else{
                            $seq = DB::select("SELECT SEQ_SPB.NEXTVAL
                      FROM dual");
                            if($qty > (int)$rec[$i]->qtys - (int)$rec[$i]->antrian){
                                $qtyCase = (int)$rec[$i]->qtys - (int)$rec[$i]->antrian;
                            }else{
                                $qtyCase = $qty;
                            }

                            DB::table("TBTEMP_ANTRIANSPB")
                                ->insert(['SPB_PRDCD' => $plu,
                                    'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                                    'SPB_LOKASIASAL' => $lks_from,
                                    'SPB_LOKASITUJUAN' => $lks_to,
                                    'SPB_JENIS' => 'MANUAL',
                                    'SPB_QTY' => $qty_to,
                                    'SPB_MINUS' => $qtyCase,
                                    'SPB_ID' => $seq[0]->nextval,
                                    'SPB_CREATE_BY' => $usid,
                                    'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);


                            DB::table("TBTR_ANTRIANSPB")
                                ->insert(['SPB_PRDCD' => $plu,
                                    'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                                    'SPB_LOKASIASAL' => $lks_from,
                                    'SPB_LOKASITUJUAN' => $lks_to,
                                    'SPB_JENIS' => 'MANUAL',
                                    'SPB_QTY' => $qty_to,
                                    'SPB_MINUS' => $qtyCase,
                                    'SPB_ID' => $seq[0]->nextval,
                                    'SPB_CREATE_BY' => $usid,
                                    'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);

                        }
                        $qty = $qty - (int)$rec[$i]->qtys;
                    }
                }
                if($qty <= 0){
                    break;
                }
            }
        }elseif($jenis == 'N'){
            if($qty > 0){
                $rec = DB::select("SELECT   LKS_PRDCD, LKS_KODERAK, LKS_KODESUBRAK, LKS_TIPERAK,
                                 LKS_SHELVINGRAK, LKS_NOURUT, LKS_QTY QTYS, SPB_LOKASIASAL,
                                 NVL (ANTRIAN, 0) ANTRIAN, PRD_DESKRIPSIPANJANG
                            FROM TBMASTER_LOKASI,
                                 TBMASTER_PRODMAST,
                                 (SELECT   SPB_PRDCD, SPB_LOKASIASAL, SUM (SPB_MINUS) ANTRIAN
                                      FROM TBTEMP_ANTRIANSPB
                                     WHERE NVL (SPB_RECORDID, 'zz') = 'zz'
                                       AND SPB_JENIS = 'MANUAL'
                                  GROUP BY SPB_PRDCD, SPB_LOKASIASAL)
                           WHERE LKS_KODEIGR = '$kodeigr'
                             AND LKS_PRDCD = '$plu'
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
                             AND LKS_TIPERAK like 'N%'
                             AND (LKS_KODERAK LIKE 'D%' OR LKS_KODERAK LIKE 'G%')
                             AND LKS_QTY > NVL (ANTRIAN, 0)
                        ORDER BY NVL (LKS_EXPDATE, SYSDATE),
                                    LKS_KODERAK
                                 || '.'
                                 || LKS_KODESUBRAK
                                 || '.'
                                 || LKS_TIPERAK
                                 || '.'
                                 || LKS_SHELVINGRAK
                                 || '.'
                                 || LKS_NOURUT");

                for($i=0;$i<sizeof($rec);$i++){
                    $lks_from = $rec[$i]->lks_koderak.'.'.$rec[$i]->lks_kodesubrak.'.'.$rec[$i]->lks_tiperak.'.'.$rec[$i]->lks_shelvingrak.'.'.$rec[$i]->lks_nourut;

                    if($rec[$i]->spb_lokasiasal == null){
                        $seq = DB::select("SELECT SEQ_SPB.NEXTVAL
                      FROM dual");
                        if($qty > (int)$rec[$i]->qtys){
                            $qtyCase = (int)$rec[$i]->qtys;
                        }else{
                            $qtyCase = $qty;
                        }
                        DB::table("TBTEMP_ANTRIANSPB")
                            ->insert(['SPB_PRDCD' => $plu,
                                'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                                'SPB_LOKASIASAL' => $lks_from,
                                'SPB_LOKASITUJUAN' => $lks_to,
                                'SPB_JENIS' => 'MANUAL',
                                'SPB_QTY' => $qty_to,
                                'SPB_MINUS' => $qtyCase,
                                'SPB_ID' => $seq[0]->nextval,
                                'SPB_CREATE_BY' => $usid,
                                'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);
                        DB::table("TBTR_ANTRIANSPB")
                            ->insert(['SPB_PRDCD' => $plu,
                                'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                                'SPB_LOKASIASAL' => $lks_from,
                                'SPB_LOKASITUJUAN' => $lks_to,
                                'SPB_JENIS' => 'MANUAL',
                                'SPB_QTY' => $qty_to,
                                'SPB_MINUS' => $qtyCase,
                                'SPB_ID' => $seq[0]->nextval,
                                'SPB_CREATE_BY' => $usid,
                                'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);
                        $qty = $qty - (int)$rec[$i]->qtys;
                    }else{
                        if((int)$rec[$i]->qtys > (int)$rec[$i]->antrian){
                            $temp = DB::table("TBTEMP_ANTRIANSPB")
                                ->selectRaw("COUNT (1) as result")
                                ->whereRaw("NVL (SPB_RECORDID, 'zz') = 'zz'")
                                ->where('SPB_PRDCD','=',$rec[$i]->lks_prdcd)
                                ->where('SPB_LOKASIASAL','=',$lks_from)
                                ->where('SPB_LOKASITUJUAN','=',$lks_to)
                                ->where('spb_jenis','=','MANUAL')
                                ->first();
                            if((int)$temp->result > 0){
                                if((int)$rec[$i]->antrian + $qty > (int)$rec[$i]->qtys){
                                    $qtyCase = (int)$rec[$i]->qtys;
                                }else{
                                    $qtyCase = (int)$rec[$i]->antrian + $qty;
                                }
                                DB::table("TBTEMP_ANTRIANSPB")
                                    ->whereRaw("NVL (SPB_RECORDID, 'zz') = 'zz'")
                                    ->where('SPB_PRDCD','=',$rec[$i]->lks_prdcd)
                                    ->where('SPB_LOKASIASAL','=',$lks_from)
                                    ->where('SPB_LOKASITUJUAN','=',$lks_to)
                                    ->where('spb_jenis','=','MANUAL')
                                    ->update(['SPB_MINUS' => $qtyCase]);
                                DB::table("TBTR_ANTRIANSPB")
                                    ->whereRaw("NVL (SPB_RECORDID, 'zz') = 'zz'")
                                    ->where('SPB_PRDCD','=',$rec[$i]->lks_prdcd)
                                    ->where('SPB_LOKASIASAL','=',$lks_from)
                                    ->where('SPB_LOKASITUJUAN','=',$lks_to)
                                    ->where('spb_jenis','=','MANUAL')
                                    ->update(['SPB_MINUS' => $qtyCase]);
                            }else{
                                $seq = DB::select("SELECT SEQ_SPB.NEXTVAL
                      FROM dual");
                                if($qty > (int)$rec[$i]->qtys - (int)$rec[$i]->antrian){
                                    $qtyCase = (int)$rec[$i]->qtys - (int)$rec[$i]->antrian;
                                }else{
                                    $qtyCase = $qty;
                                }

                                DB::table("TBTEMP_ANTRIANSPB")
                                    ->insert(['SPB_PRDCD' => $plu,
                                        'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                                        'SPB_LOKASIASAL' => $lks_from,
                                        'SPB_LOKASITUJUAN' => $lks_to,
                                        'SPB_JENIS' => 'MANUAL',
                                        'SPB_QTY' => $qty_to,
                                        'SPB_MINUS' => $qtyCase,
                                        'SPB_ID' => $seq[0]->nextval,
                                        'SPB_CREATE_BY' => $usid,
                                        'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);


                                DB::table("TBTR_ANTRIANSPB")
                                    ->insert(['SPB_PRDCD' => $plu,
                                        'SPB_DESKRIPSI' => $rec[$i]->prd_deskripsipanjang,
                                        'SPB_LOKASIASAL' => $lks_from,
                                        'SPB_LOKASITUJUAN' => $lks_to,
                                        'SPB_JENIS' => 'MANUAL',
                                        'SPB_QTY' => $qty_to,
                                        'SPB_MINUS' => $qtyCase,
                                        'SPB_ID' => $seq[0]->nextval,
                                        'SPB_CREATE_BY' => $usid,
                                        'SPB_CREATE_DT' => DB::RAW("SYSDATE")]);

                            }
                            $qty = $qty - (int)$rec[$i]->qtys;
                        }
                    }
                    if($qty <= 0){
                        break;
                    }
                }
            }
        }
        DB::commit();

    }
}
