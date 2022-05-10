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
use Yajra\DataTables\DataTables;

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

            $root = "names/";
            File::deleteDirectory(storage_path($root), 0755, true, true);
            if (!File::exists(storage_path($root))) {
                File::makeDirectory(storage_path($root), 0755, true, true);
            }
            $filesrclerk = storage_path($root . 'srclerk.txt');
            file_put_contents($filesrclerk, $request->signsrclerk);

            $fileclerk = storage_path($root . 'clerk.txt');
            file_put_contents($fileclerk, $request->signclerk);

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

    public function showUser()
    {
        $records =  DB::connection(Session::get('connection'))->select("SELECT DISTINCT USERNAME, USERLEVEL, USERID
                        FROM TBMASTER_USER");
        return DataTables::of($records)->make(true);
    }
}
