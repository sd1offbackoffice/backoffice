<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});


/******** Arie ********/
//Route::get('/mstharilibur/index','MASTER\harilibur');
Route::get('/mstharilibur/index','MASTER\hariliburController@index');

/******** Denny ********/
//MST_PERUSAHAAN
Route::get('/mstperusahaan/index','MASTER\perusahaanController@index');

//MST_BARCODE
Route::get('/mstbarcode/index','MASTER\barcodeController@index');
Route::post('/mstbarcode/search_barcode','MASTER\barcodeController@search_barcode');

//MST_KATEGORITOKO
Route::get('/mstkategoritoko/index','MASTER\kategoritokoController@index');
Route::post('/mstkategoritoko/getDataKtk','MASTER\kategoritokoController@getDataKtk');
Route::post('/mstkategoritoko/saveDataKtk','MASTER\kategoritokoController@saveDataKtk');

//MST_APPROVAL
Route::get('/mstapproval/index','MASTER\approvalController@index');
Route::post('/mstapproval/saveData','MASTER\approvalController@saveData');

//MST_JENISITEM
Route::get('/mstjenisitem/index','MASTER\jenisitemController@index');
Route::post('/mstjenisitem/lov_search','MASTER\jenisitemController@lov_search');
Route::post('/mstjenisitem/lov_select','MASTER\jenisitemController@lov_select');
Route::post('/mstjenisitem/savedata','MASTER\jenisitemController@savedata');

//MST_KUBIKASIPLANO
Route::get('/mstkubikasiplano/index','MASTER\kubikasiPlanoController@index');
Route::post('/mstkubikasiplano/lov_subrak','MASTER\kubikasiPlanoController@lov_subrak');
Route::post('/mstkubikasiplano/lov_shelving','MASTER\kubikasiPlanoController@lov_shelving');
Route::post('/mstkubikasiplano/dataRakKecil','MASTER\kubikasiPlanoController@dataRakKecil');

/******** Leo ********/
/*MASTER SUPPLIER*/
Route::get('/mstsupplier/index','MASTER\supplierController@index');
Route::get('/mstsupplier/lov','MASTER\supplierController@lov');
Route::get('/mstsupplier/lov_select','MASTER\supplierController@lov_select');
Route::get('/mstsupplier/lov_search','MASTER\supplierController@lov_search');

/*MASTER DEPARTEMENT*/
Route::get('/mstdepartement/index','MASTER\departementController@index');
Route::get('/mstdepartement/divisi_select','MASTER\departementController@divisi_select');

/*MASTER DIVISI*/
Route::get('/mstdivisi/index','MASTER\divisiController@index');

/*MASTER KATEGORI BARANG*/
Route::get('/mstkategoribarang/index','MASTER\kategoriBarangController@index');
Route::get('/mstkategoribarang/departement_select','MASTER\kategoriBarangController@departement_select');

/*MASTER HARGA BELI*/
Route::get('/msthargabeli/index','MASTER\hargaBeliController@index');
Route::get('/msthargabeli/lov_search','MASTER\hargaBeliController@lov_search');
Route::get('/msthargabeli/lov_select','MASTER\hargaBeliController@lov_select');

/*MASTER MEMBER*/
Route::get('/mstmember/index','MASTER\memberController@index');
Route::get('/mstmember/lov_member_search','MASTER\memberController@lov_member_search');
Route::get('/mstmember/lov_kodepos_search','MASTER\memberController@lov_kodepos_search');
Route::get('/mstmember/lov_select','MASTER\memberController@lov_member_select');
Route::get('/mstmember/lov_select','MASTER\memberController@lov_kodepos_select');

/******** Jefri ********/
// MASTER_CABANG
Route::get('/mstcabang/index',              'MASTER\cabangController@index');
Route::post('/mstcabang/getdetailcabang',   'MASTER\cabangController@getDetailCabang');
Route::post('/mstcabang/editdatacabang',    'MASTER\cabangController@editDataCabang');
Route::post('/mstcabang/trfdataanakcab',    'MASTER\cabangController@transDataAnakCab');

// MASTER_OUTLET
Route::get('/mstoutlet/index',              'MASTER\outletController@index');

// MASTER_SUB_OUTLET
Route::get('/mstsuboutlet/index',           'MASTER\subOutletController@index');
Route::post('/mstsuboutlet/getsuboutlet',   'MASTER\subOutletController@getSubOutlet');

// MASTER_OMI
Route::get('/mstomi/index',                 'MASTER\omiController@index');
Route::POST('/mstomi/gettokoomi',           'MASTER\omiController@getTokoOmi');
Route::POST('/mstomi/edittokoomi',          'MASTER\omiController@editTokoOmi');
Route::POST('/mstomi/getbranchname',        'MASTER\omiController@getBranchName');
Route::POST('/mstomi/getcustomername',      'MASTER\omiController@getCustomerName');
Route::POST('/mstomi/updatetokoomi',        'MASTER\omiController@updateTokoOmi');

// MASTER_AKTIF_HARGA_JUAL
Route::get('/mstaktifhrgjual/index',        'MASTER\aktifHargaJualController@index');
Route::post('/mstaktifhrgjual/getdetailplu','MASTER\aktifHargaJualController@getDetailPlu');
Route::post('/mstaktifhrgjual/getprodmast', 'MASTER\aktifHargaJualController@getProdmast');
