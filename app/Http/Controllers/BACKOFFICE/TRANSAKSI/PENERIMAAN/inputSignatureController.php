<?php

namespace App\Http\Controllers\BACKOFFICE\TRANSAKSI\PENERIMAAN;

use App\AllModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use OCILob;
use Yajra\DataTables\DataTables;
use ZipArchive;

class inputSignatureController extends Controller
{
    public function index()
    {
        return view('BACKOFFICE.TRANSAKSI.PENERIMAAN.inputSignature');
    }

    public function save(Request $request)
    {
        $message = "";
        $status = "";
        $user = Session::get('usid');
        $kodeigr = Session::get('kdigr');
        $sysdate = Carbon::now()->format('Y-m-d');
        try {
            $path = "signature/";
            File::deleteDirectory(storage_path($path), 0755, true, true);
            if (!File::exists(storage_path($path))) {
                File::makeDirectory(storage_path($path), 0755, true, true);
            }
            $img2 = $this->dataURLtoImage($request->signed2);
            $file2 = storage_path($path . 'srclerk.' . $img2['image_type']);
            file_put_contents($file2, $img2['image_base64']);

            $img3 = $this->dataURLtoImage($request->signed3);
            $file3 = storage_path($path . 'clerk.' . $img3['image_type']);
            file_put_contents($file3, $img3['image_base64']);

            $img4 = $this->dataURLtoImage($request->signed4);
            $file4 = storage_path($path . 'ljm.' . $img4['image_type']);
            file_put_contents($file4, $img4['image_base64']);

            $root = "names/";
            File::deleteDirectory(storage_path($root), 0755, true, true);
            if (!File::exists(storage_path($root))) {
                File::makeDirectory(storage_path($root), 0755, true, true);
            }
            $filesrclerk = storage_path($root . 'srclerk.txt');
            file_put_contents($filesrclerk, $request->signsrclerk);

            $fileclerk = storage_path($root . 'clerk.txt');
            file_put_contents($fileclerk, $request->signclerk);

            $fileljm = storage_path($root . 'ljm.txt');
            file_put_contents($fileljm, $request->signljm);

            $kodeigr = Session::get('kdigr');
            $result = DB::connection(Session::get('connection'))->select(
                "SELECT CAB_KODEWILAYAH
                FROM TBMASTER_CABANG
                WHERE CAB_KODECABANG = '$kodeigr'"
            );
            $area = $result[0]->cab_kodewilayah;

            $status = Session::get('connection');
            $cabang = strtolower($area);
            $message = '';

            if (strtolower(substr($status, 0, 3)) == 'sim') {
                $ftp_server = config('database.connections.sim' . $cabang . '.host');
            } else if (strtolower(substr($status, 0, 3)) == 'igr') {
                $ftp_server = config('database.connections.igr' . $cabang . '.host');
            }
            $ftp_user_name = 'ftpigr';
            $ftp_user_pass = 'ftpigr';
            //Kirim file ttd
            try {
                $conn_id = ftp_connect($ftp_server);
                ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                $sigfiles = Storage::disk('signature')->allFiles();
                if (count($sigfiles) > 0) {
                    foreach ($sigfiles as $file => $value) {
                        $filePath = '../storage/signature/' . $value;
                        ftp_put($conn_id, '/u01/lhost/bpb_signature/' . $value, $filePath);
                    }
                    $message = 'File terkirim ke Cabang';
                } else {
                    $message = 'Empty Record, nothing to transfer';
                    return response()->json(['kode' => 2, 'message' => $message]);
                }
            } catch (Exception $e) {
                $message = 'Proses kirim file gagal (error sig)';
                return response()->json(['kode' => 0, 'message' => $message . $e]);
            }

            //Kirim file nama ttd
            try {
                $conn_id = ftp_connect($ftp_server);
                ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
                $namefiles = Storage::disk('names')->allFiles();
                if (count($namefiles) > 0) {
                    foreach ($namefiles as $file => $value) {
                        $filePath = '../storage/names/' . $value;
                        ftp_put($conn_id, '/u01/lhost/bpb_signature/' . $value, $filePath);
                    }
                    $message = 'File terkirim ke Cabang';
                } else {
                    $message = 'Empty Record, nothing to transfer';
                    return response()->json(['kode' => 2, 'message' => $message]);
                }
            } catch (Exception $e) {
                $message = 'Proses kirim file gagal (error name)';
                return response()->json(['kode' => 0, 'message' => $message . $e]);
            }

            $message = "Signature Saved!";
            $status = "success";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $status = "error";
        }
        return response()->json(['message' => $message, 'status' => $status]);
    }

    public function dataURLtoImage($value)
    {
        $image_parts = explode(";base64,", $value);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        return compact(['image_base64', 'image_type']);
    }

    public function getAllData()
    {
        $path = storage_path('signature/');
        $datas = File::files($path);
        $data = [];
        foreach ($datas as $d) {
            $data[] = basename($d);
        }

        return compact(['data']);
    }

    public function getName()
    {
        $root = storage_path('names/');
        $names = File::files($root);
        $name = [];

        foreach ($names as $n) {
            $name[] = file_get_contents($root . basename($n));
        }
        return compact(['name']);
    }

    public function otorisasi(Request $request)
    {
        $otoUser = strtoupper($request->otoUser);
        $otoPass = strtoupper($request->otoPass);

        $user = DB::connection(Session::get('connection'))->select("SELECT USERID
        FROM  TBMASTER_USER
        WHERE USERID = '$otoUser'");
        if (!isset($user)) {
            return response()->json(['kode' => 0, 'msg' => 'User tidak ditemukan']);
        } else {
            $username = $user[0]->userid;
            $pass = DB::connection(Session::get('connection'))->select("SELECT USERID, USERPASSWORD
            FROM  TBMASTER_USER
            WHERE USERID = '$username'
            AND   USERPASSWORD = '$otoPass'");
            if (!isset($pass)) {
                return response()->json(['kode' => 0, 'msg' => 'User tidak ditemukan']);
            } else {
                $result = DB::connection(Session::get('connection'))->select("SELECT USERLEVEL
                FROM  TBMASTER_USER
                WHERE USERID = '$otoUser'
                AND   USERPASSWORD = '$otoPass'");

                if ($result != null) {
                    if ($result[0]->userlevel == 1) {
                        return response()->json(['kode' => 0, 'msg' => 'Sukses']);
                    } else {
                        return response()->json(['kode' => 1, 'msg' => 'Kode Otorisasi MGR Tidak Terdaftar !!']);
                    }
                } else {
                    return response()->json(['kode' => 1, 'msg' => 'Username/ Password salah']);
                }
            }
        }
    }

    public function showUser()
    {
        $records =  DB::connection(Session::get('connection'))->select("SELECT DISTINCT USERNAME, USERLEVEL, USERID
                        FROM TBMASTER_USER");
        return DataTables::of($records)->make(true);
    }
}
