<?php

namespace App\Http\Controllers\BACKOFFICE\NAIKTURUNSTATUS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PDF;

require '../vendor/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';

class StatusController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.NAIKTURUNSTATUS.status');
    }

    public function showNaik()
    {
        $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT pkm_pkmt, st_saldoakhir, st_prdcd, prd_deskripsipanjang, lks_koderak || '' || lks_kodesubrak || '' || lks_tiperak || '' || lks_shelvingrak rak, lks_maxdisplay || ',' || lks_maxplano AS status_barang
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
        $data = DB::connection(Session::get('connection'))->select("SELECT DISTINCT pkm_pkmt, st_saldoakhir, st_prdcd, lks_koderak || '' || lks_kodesubrak || '' || lks_tiperak || '' || lks_shelvingrak rak, prd_deskripsipanjang
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

    public function sendEmailNaik(Request $request)
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
            $mail->addAddress('adriel.felix@indomaret.co.id', 'Adriel Felix');

            //Recipients
            $mail->setFrom('noreply.sd1@indogrosir.co.id', 'noreply.sd1@indogrosir');
            foreach ($recipients as $r) {
                $mail->addAddress($r->eml_email, $r->eml_user);
            }

            //Attachments
            // $files = Storage::disk('status')->allFiles();
            // foreach ($files as $f) {
            //     $mail->addAttachment('../storage/status/' . $f);
            // }
            $mail->smtpConnect(
                array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true
                    )
                )
            );
            $list = $request->list;
            rtrim($list, ',');
            ltrim($list, ',');
            $list = explode(',', $list);
            $list = array_unique($list);
            foreach (array_slice($list, 1) as $str) {
                $msg .= "<li>" . $str . "</li>";
            };

            //Content
            $mail->Subject = 'Laporan Barang Naik Status';
            $mail->Body    = 'Berikut List PLU barang yang perlu diubah statusnya: <br>' . $msg;



            $mail->isHTML(true);
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            // File::deleteDirectory('../storage/status/');
            return response()->json(['kode' => 0, 'message' => 'Prosedur Sukses', 'p_keterangan' => 'Message has been sent']);
        } catch (Exception $e) {
            return response()->json(['kode' => 1, 'message' => 'Prosedur Gagal', 'p_keterangan' => $mail->ErrorInfo]);
        }
    }

    public function sendEmailTurun(Request $request)
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
            $mail->addAddress('adriel.felix@indomaret.co.id', 'Adriel Felix');

            //Recipients
            $mail->setFrom('noreply.sd1@indogrosir.co.id', 'noreply.sd1@indogrosir');
            foreach ($recipients as $r) {
                $mail->addAddress($r->eml_email, $r->eml_user);
            }

            //Attachments
            // $files = Storage::disk('status')->allFiles();
            // foreach ($files as $f) {
            //     $mail->addAttachment('../storage/status/' . $f);
            // }
            $mail->smtpConnect(
                array(
                    "ssl" => array(
                        "verify_peer" => false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true
                    )
                )
            );
            $list = $request->list;
            rtrim($list, ',');
            ltrim($list, ',');
            $list = explode(',', $list);
            $list = array_unique($list);
            foreach (array_slice($list, 1) as $str) {
                $msg .= "<li>" . $str . "</li>";
            };

            //Content
            $mail->Subject = 'Laporan Barang Turun Status';
            $mail->Body    = 'Berikut List PLU barang yang perlu diubah statusnya: <br>' . $msg;



            $mail->isHTML(true);
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            // File::deleteDirectory('../storage/status/');
            return response()->json(['kode' => 0, 'message' => 'Prosedur Sukses', 'p_keterangan' => 'Message has been sent']);
        } catch (Exception $e) {
            return response()->json(['kode' => 1, 'message' => 'Prosedur Gagal', 'p_keterangan' => $mail->ErrorInfo]);
        }
    }
}
