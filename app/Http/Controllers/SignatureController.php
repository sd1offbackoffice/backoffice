<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SignatureController extends Controller
{
    public function index()
    {

        return view('signature');
    }

    public function save(Request $request)
    {
        $message = "";
        $status = "";
        try {

            $path = "signature/";
            if (!File::exists(storage_path($path))) {
                File::makeDirectory(storage_path($path), 0755, true, true);
            }
            $img = $this->dataURLtoImage($request->signed);
            $file = storage_path($path . uniqid() . '.' . $img['image_type']);
            file_put_contents($file, $img['image_base64']);

            $message = "Signature Saved!";
            $status = "success";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $status = "error";
        }

        // return compact(['message', 'status']);
        return response()->json(['message' => $message, 'status' => $status, 'data' => $file]);

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
}
