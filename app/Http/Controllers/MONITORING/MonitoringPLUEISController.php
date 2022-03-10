<?php

namespace App\Http\Controllers\MONITORING;

use App\Imports\PluImport;
use App\MonitoringPLUModel;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Excel;
use Yajra\DataTables\DataTables;

class MonitoringPLUEISController extends Controller
{
    public function index(){
        return view('MONITORING.monitoring-plu-eis');
    }

    public  function viewListMtrPlu(){
        $model  = new MonitoringPLUModel();
        $search = $model->viewListMtrPlu();

        return Datatables::of($search)->make(true);
    }

    public function viewListDetail(Request $request){
        $kodeMtr    = $request->kodeMtr;
        $model      = new MonitoringPLUModel();;
        $detail     = $model->viewListDetail($kodeMtr);

        return Datatables::of($detail)->make(true);
//        return response()->json($detail);
    }

    public function searchPlu(Request $request){
        $plu    = $request->plu;
        $model  = new MonitoringPLUModel();
        $search = $model->searchPlu($plu);

        if ($search == null){
            return 0;
        }

        return response()->json($search[0]);
    }

    public function saveNewMtr(Request $request){
        $tempPlu    = $request->tempPlu;
        $mtrName    = $request->mtrName;
        $model      = new MonitoringPLUModel();
        $insert     = $model->saveNewMtr($tempPlu,$mtrName);

        if ($insert['kode'] == 1){
            return response()->json(['kode' => 1, 'message' => "Data Monitoring telah di simpan", 'data' => $insert['kodeMtr']]);
        } else {
            return response()->json(['kode' => 0, 'message' => "Data Monitoring Gagal di simpan", 'data' => '']);
        }
    }

    public function deleteListMonitoring(Request $request){
        $kodeMtr    = $request->kodeMtr;
        $model      = new MonitoringPLUModel();
        $delete     = $model->deleteListMonitoring($kodeMtr);

        if ($delete['kode'] == 1){
            return response()->json(['kode' => 1, 'message' => "Monitoring sukses di hapus", 'data' => '']);
        } else {
            return response()->json(['kode' => 0, 'message' => "Monitoring gagal di hapus", 'data' => '']);
        }
    }

    public function editDataMonitoring(Request $request){
        $kodeMtr    = $request->kodeMtr;
        $model      = new MonitoringPLUModel();
        $mtrName    = $model->searchMtrName($kodeMtr)->mtr_namamtr ?? '...';
        $detail     = $model->viewListDetail($kodeMtr);

        return response()->json(['kode' => 1, 'message' => "Data Ditemukan", 'data' => [$mtrName, $detail]]);
    }

    public function updateDataMonitoring(Request $request){
        $tempPlu    = $request->tempPlu;
        $mtrName    = $request->mtrName;
        $kodeMtr    = $request->kodeMtr;
        $model      = new MonitoringPLUModel();
        $update     = $model->updateDataMonitoring($tempPlu,$mtrName,$kodeMtr);

        if ($update['kode'] == 1){
            return response()->json(['kode' => 1, 'message' => "Data Monitoring telah di ubah", 'data' => '']);
        } else {
            return response()->json(['kode' => 0, 'message' => "Data Monitoring Gagal di ubah", 'data' => '']);
        }
    }

    public function prosesExcelPlu(Request $request){
        $excel  = $request->file('file');
        $date   = date('dmY');
        $ext    = $excel->getClientOriginalExtension();
        $name   = $excel->getClientOriginalName();
        $name   = $date.$name;
//        $data[] = '';

        if ($ext !='xlsx' && $ext !='csv' && $ext !='xls'){
            return response()->json(['kode' => 0, 'message' => "Format file salah", 'data' => '']);
        }

        $excel->move(storage_path('/file'),$name);
//        $getData = file(storage_path('file/'.$name));

        $getData    = \Maatwebsite\Excel\Facades\Excel::toArray(new PluImport(), storage_path('/file/'.$name));
        $getData    = $getData[0];
        unset($getData[0]);

        for ($j =1; $j<sizeof($getData)+1;$j++){
            $kode   = $getData[$j][0];
            $max    = strlen($kode);
            $plu    = null;
//            $value  = $getData[$j];
//            $kode   = explode(("\r"??"\n"),$value);

            for ($i =0; $i<(7-$max); $i++){
                $plu = '0'.$plu;
            }

            $plu    = $plu.$kode;
            $model  = new MonitoringPLUModel();
            $search = $model->searchPlu($plu);

            if ($search){
                $data[] = $search[0];
            }
        }

        File::delete(['file/'.$name]);

        return response()->json(['kode' => 1, 'message' => "Proses excel selesai", 'data' => $data ?? '...']);
    }




}
