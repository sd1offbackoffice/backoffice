<?php

namespace App\Http\Controllers\BACKOFFICE\NAIKTURUNSTATUS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class StatusController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.NAIKTURUNSTATUS.status');
    }

    public function showNaik()
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT pkm_pkmt, st_saldoakhir, st_prdcd, prd_deskripsipanjang, lks_koderak || '' || lks_kodesubrak || '' || lks_tiperak || '' || lks_shelvingrak rak
        FROM TBMASTER_KKPKM, TBMASTER_STOCK, TBMASTER_LOKASI, TBMASTER_PRODMAST
        WHERE st_prdcd = pkm_prdcd
        AND st_prdcd = prd_prdcd
        AND st_saldoakhir >= pkm_pkmt
        AND st_saldoakhir > 0
        AND pkm_pkmt > 0
        AND st_prdcd = lks_prdcd
        ORDER BY st_saldoakhir ASC");

        return DataTables::of($data)->make(true);
    }

    public function showTurun()
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT pkm_pkmt, st_saldoakhir, st_prdcd, lks_koderak || '' || lks_kodesubrak || '' || lks_tiperak || '' || lks_shelvingrak rak, prd_deskripsipanjang
        FROM TBMASTER_KKPKM, TBMASTER_STOCK, TBMASTER_LOKASI, TBMASTER_PRODMAST
        WHERE st_prdcd = pkm_prdcd
        AND st_prdcd = prd_prdcd
        AND st_saldoakhir <= pkm_pkmt
        AND st_prdcd = lks_prdcd
        AND st_saldoakhir > 0
        AND pkm_pkmt > 0
        ORDER BY st_saldoakhir ASC");

        return DataTables::of($data)->make(true);
    }

    public function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    public function sendEmail()
    {
        $msg = '';
        $mail = new PHPMailer(true);
        try {
            $recipients = DB::connection(Session::get('connection'))->select(
                "SELECT eml_email, eml_user
                FROM tbmaster_email
                WHERE eml_user = 'EDP'"
            );
            //Server settings
            $mail->SMTPDebug  = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = config('credentials.mail_host');
            $mail->SMTPAuth   = true;
            $mail->Username   = config('credentials.mail_username');
            $mail->Password   = config('credentials.mail_password');
            $mail->SMTPSecure = 'ssh';
            $mail->Port       = 25;
            $mail->addAddress('kingsleyanand@indomaret.co.id', 'Kingsley Anand');

            //Recipients
            $mail->setFrom('noreply.sd1@indogrosir.co.id', 'noreply.sd1@indogrosir');
            // foreach ($recipients as $r) {
            //     $mail->addAddress($r->eml_email, $r->eml_user);
            // }

            //Attachments
            $files = Storage::disk('batal')->allFiles();
            foreach ($files as $f) {
                $mail->addAttachment('../storage/batal/' . $f);
                $p_nodks = $this->get_string_between($f, '_', '_');
                $vol = DB::connection(Session::get('connection'))->select(
                    "SELECT SUM (
                        dks_qtypb
                      * prd_dimensipanjang
                      * prd_dimensilebar
                      * prd_dimensitinggi)
                        AS v_totalvol
                        FROM TBTR_PB_DKS,
                            (SELECT SUBSTR (prd_prdcd, 1, 6) || '0' plu_0,
                                    prd_dimensipanjang,
                                    prd_dimensilebar,
                                    prd_dimensitinggi
                                FROM (SELECT DENSE_RANK ()
                                            OVER (PARTITION BY SUBSTR (prd_prdcd, 1, 6)
                                                    ORDER BY prd_prdcd ASC)
                                                AS plu_1,
                                            prd_prdcd,
                                            prd_dimensipanjang,
                                            prd_dimensilebar,
                                            prd_dimensitinggi
                                        FROM tbmaster_prodmast
                                        WHERE prd_prdcd NOT LIKE '%0')
                                WHERE plu_1 = 1)
                        WHERE dks_prdcd = plu_0 AND dks_nodks = '$p_nodks'"
                );

                $van = DB::connection(Session::get('connection'))->select(
                    "SELECT van_tipe, van_volume, van_allowance
                        FROM tbmaster_van
                        WHERE ROWNUM = '1'"
                );

                $volume = round($vol[0]->v_totalvol / $van[0]->van_volume * 100);
                $van_allowance = $van[0]->van_allowance;
                $msg .= ('<br>' . $p_nodks . ' - ' . 'Persentase Volume (' . $volume . '%)' . ' - ' . 'Persentase Allowance (' . $van_allowance . '%),' . '<br>');
            }
            $mail->smtpConnect(
                array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true
                    )
                )
            );
            //Content
            $mail->Subject = 'Laporan DKS batal terbentuk';
            $mail->Body    = 'Laporan DKS batal terbentuk, dikarenakan adanya persentase yang invalid pada DKS berikut: <br>' . $msg . '<br>Terlampir laporan terkait pembatalan pembentukan DKS di bawah';
            $mail->isHTML(true);
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            File::deleteDirectory('../storage/batal/');
            return response()->json(['kode' => 0, 'message' => 'Prosedur Sukses', 'p_keterangan' => 'Message has been sent']);
        } catch (Exception $e) {
            return response()->json(['kode' => 1, 'message' => 'Prosedur Gagal', 'p_keterangan' => $mail->ErrorInfo]);
        }
    }
}
