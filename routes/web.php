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
})->middleware('CheckLogin');

Route::get('/test', function () {
    return view('test');
});

Route::get('/login','Auth\loginController@index');
Route::get('/logout','Auth\loginController@logout')->middleware('CheckLogin');

/******** Arie ********/
//Route::get('/mstharilibur/index','MASTER\harilibur');
Route::get('/mstharilibur/index','MASTER\hariliburController@index')->middleware('CheckLogin');

/******** Denni ********/
//MST_PERUSAHAAN
Route::get('/mstperusahaan/index','MASTER\perusahaanController@index')->middleware('CheckLogin');

//MST_BARCODE
Route::get('/mstbarcode/index','MASTER\barcodeController@index')->middleware('CheckLogin');

//MST_KATEGORITOKO
Route::get('/mstkategoritoko/index','MASTER\kategoritokoController@index')->middleware('CheckLogin');

//MST_APPROVAL
Route::get('/mstapproval/index','MASTER\approvalController@index')->middleware('CheckLogin');

//MST_JENISITEM
Route::get('/mstjenisitem/index','MASTER\jenisItemController@index')->middleware('CheckLogin');

//MST_KUBIKASIPLANO
Route::get('/mstkubikasiplano/index','MASTER\kubikasiPlanoController@index')->middleware('CheckLogin');

//IGR_BO_INQUERY (INFORMASI DAN HISTORY PRODUK)
Route::get('/mstinformasihistoryproduct/index','MASTER\informasiHistoryProductController@index')->middleware('CheckLogin');

//ADMINISTRATION (USER)
Route::get('/admuser/index','ADMINISTRATION\userController@index')->middleware('CheckLogin');

/******** Leo ********/
/*MASTER SUPPLIER*/
Route::get('/mstsupplier/index','MASTER\supplierController@index')->middleware('CheckLogin');
Route::get('/mstsupplier/lov','MASTER\supplierController@lov');
Route::get('/mstsupplier/lov_select','MASTER\supplierController@lov_select');
Route::get('/mstsupplier/lov_search','MASTER\supplierController@lov_search');

/*MASTER DEPARTEMENT*/
Route::get('/mstdepartement/index','MASTER\departementController@index')->middleware('CheckLogin');
Route::get('/mstdepartement/divisi_select','MASTER\departementController@divisi_select');

/*MASTER DIVISI*/
Route::get('/mstdivisi/index','MASTER\divisiController@index')->middleware('CheckLogin');

/*MASTER KATEGORI BARANG*/
Route::get('/mstkategoribarang/index','MASTER\kategoriBarangController@index')->middleware('CheckLogin');
Route::get('/mstkategoribarang/departement_select','MASTER\kategoriBarangController@departement_select');

/*MASTER HARGA BELI*/
Route::get('/msthargabeli/index','MASTER\hargaBeliController@index')->middleware('CheckLogin');
Route::get('/msthargabeli/lov_search','MASTER\hargaBeliController@lov_search');
Route::get('/msthargabeli/lov_select','MASTER\hargaBeliController@lov_select');

/*MASTER MEMBER*/
Route::get('/mstmember/index','MASTER\memberController@index')->middleware('CheckLogin');
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
Route::get('/bokirimkkei/index','BACKOFFICE\KirimKKEIController@index')->middleware('CheckLogin');
Route::post('/bokirimkkei/upload','BACKOFFICE\KirimKKEIController@upload');
Route::post('/bokirimkkei/refresh','BACKOFFICE\KirimKKEIController@refresh');

/*BACK OFFICE - KERTAS KERJA KEBUTUHAN TOKO IGR*/
Route::get('/bokkei/index','BACKOFFICE\KKEIController@index')->middleware('CheckLogin');
Route::post('/bokkei/get_detail_produk','BACKOFFICE\KKEIController@get_detail_produk');
Route::post('/bokkei/get_detail_kkei','BACKOFFICE\KKEIController@get_detail_kkei');
Route::post('/bokkei/save','BACKOFFICE\KKEIController@save');
Route::post('/bokkei/laporan','BACKOFFICE\KKEIController@laporan');
Route::get('/bokkei/laporan','BACKOFFICE\KKEIController@laporan_view');

Route::get('/bokkei/test','BACKOFFICE\KKEIController@test');

/*MASTER LOKASI*/
Route::get('/mstlokasi/index','MASTER\lokasiController@index')->middleware('CheckLogin');
Route::post('/mstlokasi/lov_rak_search','MASTER\lokasiController@lov_rak_search')->middleware('CheckLogin');
Route::post('/mstlokasi/lov_rak_select','MASTER\lokasiController@lov_rak_select')->middleware('CheckLogin');
Route::post('/mstlokasi/lov_plu_search','MASTER\lokasiController@lov_plu_search')->middleware('CheckLogin');
Route::post('/mstlokasi/lov_plu_select','MASTER\lokasiController@lov_plu_select')->middleware('CheckLogin');





/******** Michelle ********/
// Inquiry Supplier Produk
Route::get('/inqsupprod/index','MASTER\inquerySuppProdController@index')->middleware('CheckLogin');
Route::post('/inqsupprod/suppProd','MASTER\inquerySuppProdController@suppProd');
Route::get('inqsupprod/helpSelect','MASTER\inquerySuppProdController@helpSelect');

// Inquiry Produk Supplier
Route::get('/inqprodsupp/index','MASTER\inqueryProdSuppController@index')->middleware('CheckLogin');
Route::post('/inqprodsupp/prodSupp','MASTER\inqueryProdSuppController@prodSupp');
Route::get('inqprodsupp/helpSelect','MASTER\inqueryProdSuppController@helpSelect');

// Master Barang
Route::get('mstbarang/index','MASTER\barangController@index')->middleware('CheckLogin');
Route::post('/mstbarang/showBarang','MASTER\barangController@showBarang');
Route::get('/mstbarang/helpSelect','MASTER\barangController@helpSelect');




/******** Jefri ********/
// MASTER_CABANG
Route::get('/mstcabang/index',              'MASTER\cabangController@index')->middleware('CheckLogin');
Route::post('/mstcabang/getdetailcabang',   'MASTER\cabangController@getDetailCabang');
Route::post('/mstcabang/editdatacabang',    'MASTER\cabangController@editDataCabang');
Route::post('/mstcabang/trfdataanakcab',    'MASTER\cabangController@transDataAnakCab');

// MASTER_OUTLET
Route::get('/mstoutlet/index',              'MASTER\outletController@index')->middleware('CheckLogin');

// MASTER_SUB_OUTLET
Route::get('/mstsuboutlet/index',           'MASTER\subOutletController@index')->middleware('CheckLogin');
Route::post('/mstsuboutlet/getsuboutlet',   'MASTER\subOutletController@getSubOutlet');

// MASTER_OMI
Route::get('/mstomi/index',                 'MASTER\omiController@index')->middleware('CheckLogin');
Route::POST('/mstomi/gettokoomi',           'MASTER\omiController@getTokoOmi');
Route::POST('/mstomi/edittokoomi',          'MASTER\omiController@editTokoOmi');
Route::POST('/mstomi/getbranchname',        'MASTER\omiController@getBranchName');
Route::POST('/mstomi/getcustomername',      'MASTER\omiController@getCustomerName');
Route::POST('/mstomi/updatetokoomi',        'MASTER\omiController@updateTokoOmi');

// MASTER_AKTIF_HARGA_JUAL
Route::get('/mstaktifhrgjual/index',        'MASTER\aktifHargaJualController@index')->middleware('CheckLogin');
Route::post('/mstaktifhrgjual/getdetailplu','MASTER\aktifHargaJualController@getDetailPlu');
Route::post('/mstaktifhrgjual/getprodmast', 'MASTER\aktifHargaJualController@getProdmast');
Route::post('/mstaktifhrgjual/aktifkanhrg', 'MASTER\aktifHargaJualController@aktifkanHarga');

// MASTER_AKTIF_ALL_HARGA_JUAL
Route::get('/mstaktifallhrgjual/index',     'MASTER\aktifAllHargaJualController@index')->middleware('CheckLogin');
Route::post('mstaktifallhrgjual/aktifallitem', 'MASTER\aktifAllHargaJualController@aktifkanAllItem');

//BACKOFFICE_PB_ITEM_MAXPALET_UNTUK_PB
Route::get('/bomaxpalet/index',             'BACKOFFICE\maxpaletUntukPBController@index')->middleware('CheckLogin');
Route::post('/bomaxpalet/loaddata',         'BACKOFFICE\maxpaletUntukPBController@loadData');
Route::post('/bomaxpalet/getmaxpalet',      'BACKOFFICE\maxpaletUntukPBController@getMaxPalet');
Route::post('/bomaxpalet/savedata',         'BACKOFFICE\maxpaletUntukPBController@saveData');
Route::post('/bomaxpalet/deletedata',       'BACKOFFICE\maxpaletUntukPBController@deleteData');


//UTILITY_PB_IGR
Route::get('/utilitypbigr/index',           'BACKOFFICE\utilityPBIGRController@index')->middleware('CheckLogin');
Route::post('/utilitypbigr/callproc1',      'BACKOFFICE\utilityPBIGRController@callProc1');
Route::post('/utilitypbigr/callproc2',      'BACKOFFICE\utilityPBIGRController@callProc2');
Route::post('/utilitypbigr/callproc3',      'BACKOFFICE\utilityPBIGRController@callProc3');
Route::post('/utilitypbigr/callproc4',      'BACKOFFICE\utilityPBIGRController@callProc4');
