<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login','Auth\loginController@login');
Route::post('/insertip','Auth\loginController@insertip');

/******** Denni ********/
//MST_BARCODE
Route::post('/mstbarcode/search_barcode','MASTER\barcodeController@search_barcode')->middleware('CheckLogin');

//MST_KATEGORITOKO
Route::post('/mstkategoritoko/getDataKtk','MASTER\kategoritokoController@getDataKtk')->middleware('CheckLogin');
Route::post('/mstkategoritoko/saveDataKtk','MASTER\kategoritokoController@saveDataKtk')->middleware('CheckLogin');

//MST_APPROVAL
Route::post('/mstapproval/saveData','MASTER\approvalController@saveData')->middleware('CheckLogin');

//MST_JENISITEM
Route::post('/mstjenisitem/lov_search','MASTER\jenisItemController@lov_search')->middleware('CheckLogin');
Route::post('/mstjenisitem/lov_select','MASTER\jenisItemController@lov_select')->middleware('CheckLogin');
Route::post('/mstjenisitem/savedata','MASTER\jenisItemController@savedata')->middleware('CheckLogin');

//MST_KUBIKASIPLANO
Route::post('/mstkubikasiplano/lov_subrak','MASTER\kubikasiPlanoController@lov_subrak')->middleware('CheckLogin');
Route::post('/mstkubikasiplano/lov_shelving','MASTER\kubikasiPlanoController@lov_shelving')->middleware('CheckLogin');
Route::post('/mstkubikasiplano/dataRakKecil','MASTER\kubikasiPlanoController@dataRakKecil')->middleware('CheckLogin');
Route::post('/mstkubikasiplano/dataRakKecilParam','MASTER\kubikasiPlanoController@dataRakKecilParam')->middleware('CheckLogin');
Route::post('/mstkubikasiplano/lov_search','MASTER\kubikasiPlanoController@lov_search')->middleware('CheckLogin');
Route::post('/mstkubikasiplano/save_kubikasi','MASTER\kubikasiPlanoController@save_kubikasi')->middleware('CheckLogin');

//IGR_BO_INQUERY (INFORMASI DAN HISTORY PRODUK)
Route::post('/mstinformasihistoryproduct/lov_search','MASTER\informasiHistoryProductController@lov_search')->middleware('CheckLogin');
Route::post('/mstinformasihistoryproduct/lov_select','MASTER\informasiHistoryProductController@lov_select')->middleware('CheckLogin');
Route::post('/mstinformasihistoryproduct/cetak_so','MASTER\informasiHistoryProductController@cetak_so')->middleware('CheckLogin');
Route::post('/mstinformasihistoryproduct/cetak','MASTER\informasiHistoryProductController@cetak')->middleware('CheckLogin');

//ADMINISTRATION (USER)
Route::post('/admuser/searchUser','ADMINISTRATION\userController@searchUser')->middleware('CheckLogin');
Route::post('/admuser/searchIp','ADMINISTRATION\userController@searchIp')->middleware('CheckLogin');
Route::post('/admuser/saveUser','ADMINISTRATION\userController@saveUser')->middleware('CheckLogin');
Route::post('/admuser/updateUser','ADMINISTRATION\userController@updateUser')->middleware('CheckLogin');
Route::post('/admuser/userAccess','ADMINISTRATION\userController@userAccess')->middleware('CheckLogin');
Route::post('/admuser/saveAccess','ADMINISTRATION\userController@saveAccess')->middleware('CheckLogin');
Route::post('/admuser/saveIp','ADMINISTRATION\userController@saveIp')->middleware('CheckLogin');
Route::post('/admuser/updateIp','ADMINISTRATION\userController@updateIp')->middleware('CheckLogin');

//PB MANUAL
Route::post('/bopbmanual/lov_search','BACKOFFICE\PBManualController@lov_search')->middleware('CheckLogin');
Route::post('/bopbmanual/getDataPB','BACKOFFICE\PBManualController@getDataPB')->middleware('CheckLogin');
Route::post('/bopbmanual/hapusDokumen','BACKOFFICE\PBManualController@hapusDokumen')->middleware('CheckLogin');
Route::post('/bopbmanual/lov_search_plu','BACKOFFICE\PBManualController@lov_search_plu')->middleware('CheckLogin');
Route::post('/bopbmanual/cek_plu','BACKOFFICE\PBManualController@cek_plu')->middleware('CheckLogin');
Route::post('/bopbmanual/cek_bonus','BACKOFFICE\PBManualController@cek_bonus')->middleware('CheckLogin');
Route::post('/bopbmanual/save_data','BACKOFFICE\PBManualController@save_data')->middleware('CheckLogin');


Route::get('/mst/e','MASTER\InqueryProdSuppController@prodSupp');
