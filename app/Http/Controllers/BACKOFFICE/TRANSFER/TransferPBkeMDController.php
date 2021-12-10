<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSFER;

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use PDF;
use Yajra\DataTables\DataTables;
use ZipArchive;
use File;

class TransferPBkeMDController extends Controller
{
    public function index(){
        return view('BACKOFFICE.TRANSFER.transfer-pb-ke-md');
    }

    public function prosesTransfer(Request $request){
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $temp = DB::connection(Session::get('connection'))->table('tbkirim_status')
            ->whereRaw("TRIM(STS_KODE) = 'PB'")
            ->count();

        if($temp == 0){
            DB::connection(Session::get('connection'))->table('tbkirim_status')
                ->insert([
                    'sts_kode' => 'PB',
                    'sts_status' => 'Y'
                ]);
        }

        $status = DB::connection(Session::get('connection'))->table('tbkirim_status')
            ->whereRaw("TRIM(sts_kode) = 'PB'")
            ->first()->sts_status;

        if($status == 'N'){
            $temp = DB::connection(Session::get('connection'))->select("SELECT *
                  FROM (SELECT   PBH_NOPB, PBH_TGLPB, PBD_PRDCD, SUM (ITEM) ITEM
                            FROM (SELECT PBH_NOPB, TRUNC (PBH_TGLPB) PBH_TGLPB, PBD_PRDCD, 1 ITEM
                                    FROM TBTR_PB_H, TBTR_PB_D
                                   WHERE PBH_KODEIGR = '".Session::get('kdigr')."'
                                     AND TRUNC (PBH_TGLPB) BETWEEN TO_DATE('".$tgl1."','DD/MM/YYYY') AND TO_DATE('".$tgl2."','DD/MM/YYYY')
                                     AND PBD_KODEIGR = '".Session::get('kdigr')."'
                                     AND PBD_NOPB = PBH_NOPB) A
                        GROUP BY PBH_NOPB, PBH_TGLPB, PBD_PRDCD) B
                 WHERE NVL (ITEM, 0) > 1");

            if(count($temp) == 0){
                $temp = DB::connection(Session::get('connection'))->select("SELECT *
              FROM TBTR_PB_H, TBTR_PB_D, TBMASTER_PRODMAST
              WHERE TRUNC (PBH_TGLPB) BETWEEN TO_DATE('".$tgl1."','DD/MM/YYYY') AND TO_DATE('".$tgl2."','DD/MM/YYYY')
               AND PBH_TGLTRANSFER IS NULL
               AND PBH_KODEIGR = '".Session::get('kdigr')."'
               AND PBD_NOPB = PBH_NOPB
               AND PBD_KODEIGR = PBH_KODEIGR
               AND PRD_KODEIGR(+) = PBD_KODEIGR
               AND PRD_PRDCD(+) = PBD_PRDCD");

                if(count($temp) == 0){
                    return [
                        'alert' => 'error',
                        'title' => 'Data tidak ada!'
                    ];
                }
                else{
                    DB::connection(Session::get('connection'))->insert("INSERT INTO TBKIRIM_PB
                            (FDRCID, FDKCAB, FDNOUO, FDURGN, FDTGUO, FDNOUR, FDKKLP, FDDEPT,
                             FDKPLU, FDQTYB, FDQBBP, FDKSUP, FDHSAT, FDDIS1, FDDIR1, FDFDI1,
                             FDDIS2, FDDISR, FDFDIS, FDTHRG, FDTPPN, FDTPPM, FDTBTL, FDBNSB,
                             FDBNSK, FDBBBP, FDBKBP, FDNOPO, FDTGPO, FDFPJK, FDJTOP, FDTGUP,
                             FDDVPO, FDXREV)
                    (SELECT NULL, '".Session::get('kdigr')."', PBH_NOPB, PBH_JENISPB, PBH_TGLPB, PBD_NOURUT,
                            PRD_KODEKATEGORIBARANG, PRD_KODEDEPARTEMENT, PBD_PRDCD, PBD_QTYPB,
                            NULL, PBD_KODESUPPLIER, PBD_HRGSATUAN, PBD_PERSENDISC1, PBD_RPHDISC1,
                            PBD_FLAGDISC1, PBD_PERSENDISC2, PBD_RPHDISC2, PBD_FLAGDISC2, PBD_GROSS,
                            PBD_PPN, PBD_PPNBM, PBD_PPNBOTOL, PBD_BONUSPO1, PBD_BONUSPO2, NULL,
                            NULL, NULL, NULL, NULL, NULL, SYSDATE, PBD_KODEDIVISIPO, PBD_FDXREV
                       FROM TBTR_PB_H, TBTR_PB_D, TBMASTER_PRODMAST
                        WHERE TRUNC (PBH_TGLPB) BETWEEN TO_DATE('".$tgl1."','DD/MM/YYYY') AND TO_DATE('".$tgl2."','DD/MM/YYYY')
                        AND PBH_TGLTRANSFER IS NULL
                        AND PBH_KODEIGR = '".Session::get('kdigr')."'
                        AND PBD_NOPB = PBH_NOPB
                        AND PBD_KODEIGR = PBH_KODEIGR
                        AND PRD_KODEIGR(+) = PBD_KODEIGR
                        AND PRD_PRDCD(+) = PBD_PRDCD)");

                    DB::connection(Session::get('connection'))->insert("INSERT INTO TBKIRIM_PB_FULL
                            (FDRCID, FDKCAB, FDNOUO, FDURGN, FDTGUO, FDNOUR, FDKKLP, FDDEPT, FDKPLU,
                             FDQTYB, FDQBBP, FDKSUP, FDHSAT, FDDIS1, FDDIR1, FDFDI1, FDDIS2, FDDISR,
                             FDFDIS, FDTHRG, FDTPPN, FDTPPM, FDTBTL, FDBNSB, FDBNSK, FDBBBP, FDBKBP,
                             FDNOPO, FDTGPO, FDFPJK, FDJTOP, FDTGUP, FDDVPO, FDXREV)
                    (SELECT NULL, '".Session::get('kdigr')."', PBH_NOPB, PBH_JENISPB, PBH_TGLPB, PBD_NOURUT,
                            PRD_KODEKATEGORIBARANG, PRD_KODEDEPARTEMENT, PBD_PRDCD, PBD_QTYPB, NULL,
                            PBD_KODESUPPLIER, PBD_HRGSATUAN, PBD_PERSENDISC1, PBD_RPHDISC1,
                            PBD_FLAGDISC1, PBD_PERSENDISC2, PBD_RPHDISC2, PBD_FLAGDISC2, PBD_GROSS,
                            PBD_PPN, PBD_PPNBM, PBD_PPNBOTOL, PBD_BONUSPO1, PBD_BONUSPO2, NULL,
                            NULL, NULL, NULL, NULL, NULL, SYSDATE, PBD_KODEDIVISIPO, PBD_FDXREV
                       FROM TBTR_PB_H, TBTR_PB_D, TBMASTER_PRODMAST
                        WHERE TRUNC (PBH_TGLPB) BETWEEN TO_DATE('".$tgl1."','DD/MM/YYYY') AND TO_DATE('".$tgl2."','DD/MM/YYYY')
                        AND PBH_TGLTRANSFER IS NULL
                        AND PBH_KODEIGR = '".Session::get('kdigr')."'
                        AND PBD_NOPB = PBH_NOPB
                        AND PBD_KODEIGR = PBH_KODEIGR
                        AND PRD_KODEIGR(+) = PBD_KODEIGR
                        AND PRD_PRDCD(+) = PBD_PRDCD)");

                    DB::connection(Session::get('connection'))->update("UPDATE TBTR_PB_H
                        SET PBH_TGLTRANSFER = SYSDATE
                        WHERE TRUNC (PBH_TGLPB) BETWEEN TO_DATE('".$tgl1."','DD/MM/YYYY') AND TO_DATE('".$tgl2."','DD/MM/YYYY')
                        AND PBH_TGLTRANSFER IS NULL
                        AND PBH_KODEIGR = '".Session::get('kdigr')."'");

                    DB::connection(Session::get('connection'))->table('tbkirim_status')
                        ->whereRaw("TRIM(sts_kode) = 'PB'")
                        ->update([
                            'sts_status' => 'Y'
                        ]);

                    return [
                        'status' => 'success',
                        'title' => 'Data Selesai Ditransfer!'
                    ];
                }
            }
            else{
                $tolakan = '';

                $recs = DB::connection(Session::get('connection'))->select("SELECT *
                          FROM (SELECT   PBH_NOPB, PBH_TGLPB, PBD_PRDCD, SUM (ITEM) ITEM
                                    FROM (SELECT PBH_NOPB, TRUNC (PBH_TGLPB) PBH_TGLPB, PBD_PRDCD,
                                                 1 ITEM
                                            FROM TBTR_PB_H, TBTR_PB_D
                                           WHERE PBH_KODEIGR = '".Session::get('kdigr')."'
                                             AND TRUNC (PBH_TGLPB) BETWEEN TO_DATE('".$tgl1."','DD/MM/YYYY') AND TO_DATE('".$tgl2."','DD/MM/YYYY')
                                             AND PBD_KODEIGR = '".Session::get('kdigr')."'
                                             AND PBD_NOPB = PBH_NOPB) A
                                GROUP BY PBH_NOPB, PBH_TGLPB, PBD_PRDCD) B
                         WHERE NVL (ITEM, 0) > 1");

                foreach($recs as $rec){
                    $tolakan += $tolakan.' Nomor PB:'.$rec->pbh_nopb.' - '.$rec->pbd_prdcd.','."\n";
                }

                return [
                    'status' => 'error',
                    'title' => 'Ada data PB yang PLU nya double, silahkan data dicek kembali!',
                    'message' => $tolakan
                ];
            }
        }
        else{
            return [
                'status' => 'error',
                'title' => 'Sedang Proses Transfer Data PB ke MD!'
            ];
        }
    }
}
