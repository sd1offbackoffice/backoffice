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

/******** Denni ********/
//MST_BARCODE
Route::post('/mstbarcode/search_barcode','MASTER\barcodeController@search_barcode');

//MST_KATEGORITOKO
Route::post('/mstkategoritoko/getDataKtk','MASTER\kategoritokoController@getDataKtk');
Route::post('/mstkategoritoko/saveDataKtk','MASTER\kategoritokoController@saveDataKtk');

//MST_APPROVAL
Route::post('/mstapproval/saveData','MASTER\approvalController@saveData');

//MST_JENISITEM
Route::post('/mstjenisitem/lov_search','MASTER\jenisItemController@lov_search');
Route::post('/mstjenisitem/lov_select','MASTER\jenisItemController@lov_select');
Route::post('/mstjenisitem/savedata','MASTER\jenisItemController@savedata');

//MST_KUBIKASIPLANO
Route::post('/mstkubikasiplano/lov_subrak','MASTER\kubikasiPlanoController@lov_subrak');
Route::post('/mstkubikasiplano/lov_shelving','MASTER\kubikasiPlanoController@lov_shelving');
Route::post('/mstkubikasiplano/dataRakKecil','MASTER\kubikasiPlanoController@dataRakKecil');
Route::post('/mstkubikasiplano/dataRakKecilParam','MASTER\kubikasiPlanoController@dataRakKecilParam');
Route::post('/mstkubikasiplano/lov_search','MASTER\kubikasiPlanoController@lov_search');
Route::post('/mstkubikasiplano/save_kubikasi','MASTER\kubikasiPlanoController@save_kubikasi');

//IGR_BO_INQUERY (INFORMASI DAN HISTORY PRODUK)
Route::post('/mstinformasihistoryproduct/lov_search','MASTER\informasiHistoryProductController@lov_search');
Route::post('/mstinformasihistoryproduct/lov_select','MASTER\informasiHistoryProductController@lov_select');
//Route::post('/mstinformasihistoryproduct/cetak','MASTER\informasiHistoryProductController@cetak');
Route::get('/mstinformasihistoryproduct/cetak','MASTER\informasiHistoryProductController@cetak');




Route::get('/mst/e','MASTER\InqueryProdSuppController@prodSupp');