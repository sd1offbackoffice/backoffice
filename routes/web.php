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

Route::get('/test', function () {
    return view('test');
});

/******** Arie ********/
//Route::get('/mstharilibur/index','MASTER\harilibur');
Route::get('/mstharilibur/index','MASTER\hariliburController@index');

/******** Denni ********/
//MST_PERUSAHAAN
Route::get('/mstperusahaan/index','MASTER\perusahaanController@index');

//MST_BARCODE
Route::get('/mstbarcode/index','MASTER\barcodeController@index');

//MST_KATEGORITOKO
Route::get('/mstkategoritoko/index','MASTER\kategoritokoController@index');

//MST_APPROVAL
Route::get('/mstapproval/index','MASTER\approvalController@index');

//MST_JENISITEM
Route::get('/mstjenisitem/index','MASTER\jenisItemController@index');

//MST_KUBIKASIPLANO
Route::get('/mstkubikasiplano/index','MASTER\kubikasiPlanoController@index');

//IGR_BO_INQUERY (INFORMASI DAN HISTORY PRODUK)
Route::get('/mstinformasihistoryproduct/index','MASTER\informasiHistoryProductController@index');

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
Route::get('/mstmember/lov_member_select','MASTER\memberController@lov_member_select');
Route::get('/mstmember/lov_kodepos_select','MASTER\memberController@lov_kodepos_select');
Route::get('/mstmember/set_status_member','MASTER\memberController@set_status_member');
Route::post('/mstmember/check_password','MASTER\memberController@check_password');
Route::post('/mstmember/update_member','MASTER\memberController@update_member');
Route::post('/mstmember/export_crm','MASTER\memberController@export_crm');
Route::post('/mstmember/save_quisioner','MASTER\memberController@save_quisioner');
Route::post('/mstmember/hapus_member','MASTER\memberController@hapus_member');

/*BACK OFFICE - UPLOAD DAN MONITORING KKEI TOKO IGR*/
Route::get('/bokirimkkei/index','BACKOFFICE\KirimKKEIController@index');

/*BACK OFFICE - KERTAS KERJA KEBUTUHAN TOKO IGR*/
Route::get('/bokkei/index','BACKOFFICE\KKEIController@index');
Route::post('/bokkei/get_detail_produk','BACKOFFICE\KKEIController@get_detail_produk');
Route::post('/bokkei/get_detail_kkei','BACKOFFICE\KKEIController@get_detail_kkei');


/******** Michelle ********/
// Inquiry Supplier Produk
Route::get('/inqsupprod/index','MASTER\inquerySuppProdController@index');
Route::get('/inqsupprod/suppProd','MASTER\inquerySuppProdController@suppProd');

// Inquiry Produk Supplier
Route::get('/inqprodsupp/index','MASTER\inqueryProdSuppController@index');
Route::post('/inqprodsupp/prodSupp','MASTER\inqueryProdSuppController@prodSupp');
Route::get('inqprodsupp/helpSelect','MASTER\inqueryProdSuppController@helpSelect');





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
Route::post('/mstaktifhrgjual/aktifkanhrg', 'MASTER\aktifHargaJualController@aktifkanHarga');

// MASTER_AKTIF_ALL_HARGA_JUAL
Route::get('/mstaktifallhrgjual/index',     'MASTER\aktifAllHargaJualController@index');
Route::post('mstaktifallhrgjual/aktifallitem', 'MASTER\aktifAllHargaJualController@aktifkanAllItem');
