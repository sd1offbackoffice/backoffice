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
Route::post('/mstharilibur/insert','MASTER\hariliburController@insert');
Route::get('/mstharilibur/delete','MASTER\hariliburController@delete');

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

//PB MANUAL
Route::get('/bopbmanual/index','BACKOFFICE\PBManualController@index')->middleware('CheckLogin');

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
Route::post('/mstlokasi/noid_enter','MASTER\lokasiController@noid_enter')->middleware('CheckLogin');
Route::post('/mstlokasi/delete_plu','MASTER\lokasiController@delete_plu')->middleware('CheckLogin');
Route::post('/mstlokasi/delete_lokasi','MASTER\lokasiController@delete_lokasi')->middleware('CheckLogin');
Route::post('/mstlokasi/cek_plu','MASTER\lokasiController@cek_plu')->middleware('CheckLogin');
Route::post('/mstlokasi/tambah','MASTER\lokasiController@tambah')->middleware('CheckLogin');

/*BACK OFFICE - REORDER PB GO*/
Route::get('/boreorderpbgo/index','BACKOFFICE\ReorderPBGOController@index')->middleware('CheckLogin');





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
Route::post('/mstcabang/getdetailcabang',   'MASTER\cabangController@getDetailCabang')->middleware('CheckLogin');
Route::post('/mstcabang/editdatacabang',    'MASTER\cabangController@editDataCabang')->middleware('CheckLogin');
Route::post('/mstcabang/trfdataanakcab',    'MASTER\cabangController@transDataAnakCab')->middleware('CheckLogin');

// MASTER_OUTLET
Route::get('/mstoutlet/index',              'MASTER\outletController@index')->middleware('CheckLogin');

// MASTER_SUB_OUTLET
Route::get('/mstsuboutlet/index',           'MASTER\subOutletController@index')->middleware('CheckLogin');
Route::post('/mstsuboutlet/getsuboutlet',   'MASTER\subOutletController@getSubOutlet')->middleware('CheckLogin');

// MASTER_OMI
Route::get('/mstomi/index',                 'MASTER\omiController@index')->middleware('CheckLogin');
Route::POST('/mstomi/gettokoomi',           'MASTER\omiController@getTokoOmi')->middleware('CheckLogin');
Route::POST('/mstomi/edittokoomi',          'MASTER\omiController@editTokoOmi')->middleware('CheckLogin');
Route::POST('/mstomi/getbranchname',        'MASTER\omiController@getBranchName')->middleware('CheckLogin');
Route::POST('/mstomi/getcustomername',      'MASTER\omiController@getCustomerName')->middleware('CheckLogin');
Route::POST('/mstomi/updatetokoomi',        'MASTER\omiController@updateTokoOmi')->middleware('CheckLogin');

// MASTER_AKTIF_HARGA_JUAL
Route::get('/mstaktifhrgjual/index',        'MASTER\aktifHargaJualController@index')->middleware('CheckLogin');
Route::post('/mstaktifhrgjual/getdetailplu','MASTER\aktifHargaJualController@getDetailPlu')->middleware('CheckLogin');
Route::post('/mstaktifhrgjual/getprodmast', 'MASTER\aktifHargaJualController@getProdmast')->middleware('CheckLogin');
Route::post('/mstaktifhrgjual/aktifkanhrg', 'MASTER\aktifHargaJualController@aktifkanHarga')->middleware('CheckLogin');

// MASTER_AKTIF_ALL_HARGA_JUAL
Route::get('/mstaktifallhrgjual/index',     'MASTER\aktifAllHargaJualController@index')->middleware('CheckLogin');
Route::post('mstaktifallhrgjual/aktifallitem', 'MASTER\aktifAllHargaJualController@aktifkanAllItem')->middleware('CheckLogin');

//BACKOFFICE_PB_ITEM_MAXPALET_UNTUK_PB
Route::get('/bomaxpalet/index',             'BACKOFFICE\maxpaletUntukPBController@index')->middleware('CheckLogin');
Route::post('/bomaxpalet/loaddata',         'BACKOFFICE\maxpaletUntukPBController@loadData')->middleware('CheckLogin');
Route::post('/bomaxpalet/getmaxpalet',      'BACKOFFICE\maxpaletUntukPBController@getMaxPalet')->middleware('CheckLogin');
Route::post('/bomaxpalet/savedata',         'BACKOFFICE\maxpaletUntukPBController@saveData')->middleware('CheckLogin');
Route::post('/bomaxpalet/deletedata',       'BACKOFFICE\maxpaletUntukPBController@deleteData')->middleware('CheckLogin');


//BACKOFFICEUTILITY_PB_IGR
Route::get('/boutilitypbigr/index',           'BACKOFFICE\utilityPBIGRController@index')->middleware('CheckLogin');
Route::post('/boutilitypbigr/callproc1',      'BACKOFFICE\utilityPBIGRController@callProc1')->middleware('CheckLogin');
Route::post('/boutilitypbigr/callproc2',      'BACKOFFICE\utilityPBIGRController@callProc2')->middleware('CheckLogin');
Route::post('/boutilitypbigr/callproc3',      'BACKOFFICE\utilityPBIGRController@callProc3')->middleware('CheckLogin');
Route::get('/boutilitypbigr/callproc4/{date}',      'BACKOFFICE\utilityPBIGRController@callProc4')->middleware('CheckLogin');
Route::get('/boutilitypbigr/test',      function (){
    return view('BACKOFFICE.utilityPBIGR-laporan');
});


//UTILITY_PB_IGR
Route::get('/bopbotomatis/index',               'BACKOFFICE\PBOtomatisController@index')->middleware('CheckLogin');
Route::post('/bopbotomatis/getsupplier',        'BACKOFFICE\PBOtomatisController@getSupplier')->middleware('CheckLogin');
Route::post('/bopbotomatis/getmtrsup',          'BACKOFFICE\PBOtomatisController@getMtrSupplier')->middleware('CheckLogin');
Route::post('/bopbotomatis/getdepartemen',      'BACKOFFICE\PBOtomatisController@getDepartemen')->middleware('CheckLogin');
Route::post('/bopbotomatis/getkategori',        'BACKOFFICE\PBOtomatisController@getKategori')->middleware('CheckLogin');
Route::post('/bopbotomatis/searchkategori',     'BACKOFFICE\PBOtomatisController@searchKategori')->middleware('CheckLogin');
Route::post('/bopbotomatis/prosesdata',         'BACKOFFICE\PBOtomatisController@prosesData')->middleware('CheckLogin');

Route::post('/bopbotomatis/getdatamodal',         'BACKOFFICE\PBOtomatisController@getDataModal')->middleware('CheckLogin');
