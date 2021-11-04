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

Route::get('/testnewnav', function () {
    return view('welcome');
});

Route::get('/login', 'Auth\loginController@index');
Route::get('/logout', 'Auth\loginController@logout');
Route::get('/logout-access', 'Auth\loginController@logoutAccess');
Route::get('/unauthorized', 'Auth\loginController@unauthorized');

Route::post('/login/','Auth\loginController@login');
Route::post('/login/insertip','Auth\loginController@insertip');

/******** Template ********/
Route::get('/template/testing', 'TemplateController@testing');
Route::get('/template/index', 'TemplateController@index');
Route::get('/template/datamodal', 'TemplateController@dataModal');
Route::get('/template/searchdatamodal', 'TemplateController@searchDataModal');

/******** Arie ********/
// BACK OFFICE / PENGELUARAN /INPUT
Route::get('/bo/transaksi/pengeluaran/input/index', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\inputController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/pengeluaran/input/getDataRetur', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\inputController@getDataRetur')->middleware('CheckLogin');

Route::get('/mst/test', 'MASTER\barcodeController@testdenni')->middleware('CheckLogin');


/******** Jefri ********/
// MASTER_CABANG
//Route::get('/mstcabang', 'MASTER\cabangController@index')->middleware('CheckLogin');
//Route::post('/mstcabang/getdetailcabang', 'MASTER\cabangController@getDetailCabang')->middleware('CheckLogin');
//Route::post('/mstcabang/editdatacabang', 'MASTER\cabangController@editDataCabang')->middleware('CheckLogin');
//Route::post('/mstcabang/trfdataanakcab', 'MASTER\cabangController@transDataAnakCab')->middleware('CheckLogin');

// MASTER_OUTLET
//Route::get('/mstoutlet', 'MASTER\outletController@index')->middleware('CheckLogin');

// MASTER_SUB_OUTLET
//Route::get('/mstsuboutlet', 'MASTER\subOutletController@index')->middleware('CheckLogin');
//Route::post('/mstsuboutlet/getsuboutlet', 'MASTER\subOutletController@getSubOutlet')->middleware('CheckLogin');

// MASTER_OMI
//Route::get('/mstomi', 'MASTER\omiController@index')->middleware('CheckLogin');
//Route::get('/mstomi/gettokoomi', 'MASTER\omiController@getTokoOmi')->middleware('CheckLogin');
////Route::POST('/mstomi/gettokoomi', 'MASTER\omiController@getTokoOmi')->middleware('CheckLogin');
//Route::POST('/mstomi/detailtokoomi', 'MASTER\omiController@detailTokoOmi')->middleware('CheckLogin');
//Route::POST('/mstomi/getbranchname', 'MASTER\omiController@getBranchName')->middleware('CheckLogin');
//Route::POST('/mstomi/getcustomername', 'MASTER\omiController@getCustomerName')->middleware('CheckLogin');
//Route::POST('/mstomi/updatetokoomi', 'MASTER\omiController@updateTokoOmi')->middleware('CheckLogin');
//Route::POST('/mstomi/tambahtokoomi', 'MASTER\omiController@tambahTokoOmi')->middleware('CheckLogin');
//Route::POST('/mstomi/confirmedit', 'MASTER\omiController@confirmEdit')->middleware('CheckLogin');

// MASTER_AKTIF_HARGA_JUAL
//Route::get('/mstaktifhrgjual', 'MASTER\aktifHargaJualController@index')->middleware('CheckLogin');
//Route::get('/mstaktifhrgjual/getprodmast', 'MASTER\aktifHargaJualController@getProdmast')->middleware('CheckLogin');
//Route::post('/mstaktifhrgjual/getdetailplu', 'MASTER\aktifHargaJualController@getDetailPlu')->middleware('CheckLogin');
//Route::post('/mstaktifhrgjual/aktifkanhrg', 'MASTER\aktifHargaJualController@aktifkanHarga')->middleware('CheckLogin');

// MASTER_AKTIF_ALL_HARGA_JUAL
//Route::get('/mstaktifallhrgjual', 'MASTER\aktifAllHargaJualController@index')->middleware('CheckLogin');
//Route::get('/mstaktifallhrgjual/getdata', 'MASTER\aktifAllHargaJualController@getData')->middleware('CheckLogin');
//Route::post('mstaktifallhrgjual/aktifallitem', 'MASTER\aktifAllHargaJualController@aktifkanAllItem')->middleware('CheckLogin');

//MASTER_HARILIBUR
//Route::get('/mstharilibur', 'MASTER\hariLiburController@index')->middleware('CheckLogin');
//Route::get('/mstharilibur/getharilibur', 'MASTER\hariLiburController@getHariLibur')->middleware('CheckLogin');
//Route::post('/mstharilibur/insert', 'MASTER\hariLiburController@insert')->middleware('CheckLogin');
//Route::post('/mstharilibur/delete', 'MASTER\hariLiburController@delete')->middleware('CheckLogin');

//BACKOFFICE_PB_ITEM_MAXPALET_UNTUK_PB
Route::get('/bomaxpalet', 'BACKOFFICE\maxpaletUntukPBController@index')->middleware('CheckLogin');
Route::post('/bomaxpalet/loaddata', 'BACKOFFICE\maxpaletUntukPBController@loadData')->middleware('CheckLogin');
Route::post('/bomaxpalet/getmaxpalet', 'BACKOFFICE\maxpaletUntukPBController@getMaxPalet')->middleware('CheckLogin');
Route::post('/bomaxpalet/savedata', 'BACKOFFICE\maxpaletUntukPBController@saveData')->middleware('CheckLogin');
Route::post('/bomaxpalet/deletedata', 'BACKOFFICE\maxpaletUntukPBController@deleteData')->middleware('CheckLogin');

//BACKOFFICE_UTILITY_PB_IGR
Route::get('/boutilitypbigr', 'BACKOFFICE\utilityPBIGRController@index')->middleware('CheckLogin');
Route::post('/boutilitypbigr/callproc1', 'BACKOFFICE\utilityPBIGRController@callProc1')->middleware('CheckLogin');
Route::post('/boutilitypbigr/callproc2', 'BACKOFFICE\utilityPBIGRController@callProc2')->middleware('CheckLogin');
Route::post('/boutilitypbigr/callproc3', 'BACKOFFICE\utilityPBIGRController@callProc3')->middleware('CheckLogin');
Route::post('/boutilitypbigr/chekproc4', 'BACKOFFICE\utilityPBIGRController@checkProc4')->middleware('CheckLogin');
Route::get('/boutilitypbigr/callproc4/{date}', 'BACKOFFICE\utilityPBIGRController@callProc4')->middleware('CheckLogin');
Route::get('/boutilitypbigr/test', function () {
    return view('BACKOFFICE.utilityPBIGR-laporan');
});

//BACKOFFICE_PB_OTOMATIS
//Route::get('/bopbotomatis/index',                                             'BACKOFFICE\PBOtomatisController@cetakReport')->middleware('CheckLogin');
Route::get('/bopbotomatis/index', 'BACKOFFICE\PBOtomatisController@index')->middleware('CheckLogin');
Route::get('/bopbotomatis/getdatamodalsupplier', 'BACKOFFICE\PBOtomatisController@getDataModalSupplier')->middleware('CheckLogin');
Route::get('/bopbotomatis/getkategori', 'BACKOFFICE\PBOtomatisController@getKategori')->middleware('CheckLogin');
Route::post('/bopbotomatis/prosesdata', 'BACKOFFICE\PBOtomatisController@prosesData')->middleware('CheckLogin');
Route::get('/bopbotomatis/cetakreport/{kodeigr}/{date1}/{date2}/{sup1}/{sup2}', 'BACKOFFICE\PBOtomatisController@cetakReport');


//BACKOFFICE_CETAK_PB
Route::get('/bocetakpb/index', 'BACKOFFICE\cetakPBController@index')->middleware('CheckLogin');
Route::get('/bocetakpb/getdocument', 'BACKOFFICE\cetakPBController@getDocument')->middleware('CheckLogin');
//Route::post('/bocetakpb/getdocument', 'BACKOFFICE\cetakPBController@getDocument')->middleware('CheckLogin');
Route::post('/bocetakpb/searchdocument', 'BACKOFFICE\cetakPBController@searchDocument')->middleware('CheckLogin');
Route::post('/bocetakpb/getdivisi', 'BACKOFFICE\cetakPBController@getDivisi')->middleware('CheckLogin');
Route::post('/bocetakpb/searchdivisi', 'BACKOFFICE\cetakPBController@searchDivisi')->middleware('CheckLogin');
Route::get('/bocetakpb/getdepartement', 'BACKOFFICE\cetakPBController@getDepartement')->middleware('CheckLogin');
//Route::post('/bocetakpb/getdepartement', 'BACKOFFICE\cetakPBController@getDepartement')->middleware('CheckLogin');
Route::post('/bocetakpb/searchdepartement', 'BACKOFFICE\cetakPBController@searchDepartement')->middleware('CheckLogin');
Route::get('/bocetakpb/getkategori', 'BACKOFFICE\cetakPBController@getKategori')->middleware('CheckLogin');
//Route::post('/bocetakpb/getkategori', 'BACKOFFICE\cetakPBController@getKategori')->middleware('CheckLogin');
Route::post('/bocetakpb/searchkategori', 'BACKOFFICE\cetakPBController@searchKategori')->middleware('CheckLogin');
Route::get('/bocetakpb/cetakreport/{tgl1}/{tgl2}/{doc1}/{doc2}/{div1}/{div2}/{dept1}/{dept2}/{kat1}/{kat2}/{tipePB}', 'BACKOFFICE\cetakPBController@cetakReport')->middleware('CheckLogin');


//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-BARANGRUSAK
Route::get('/bo/transaksi/pemusnahan/brgrusak/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@index')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/brgrusak/getnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNmrTrn')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/brgrusak/getnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNmrTrn')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/brgrusak/getplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getPlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/choosetrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@chooseTrn')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/getnewnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNewNmrTrn')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/chooseplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@choosePlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/savedata', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@saveData')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/deletedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@deleteDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/showall', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@showAll')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/brgrusak/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@printDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-BERITA_ACARA_PEMUSNAHAN
Route::get('/bo/transaksi/pemusnahan/bapemusnahan/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@index')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/bapemusnahan/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNoDocument')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/bapemusnahan/getnopbbr', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNoPBBR')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/choosedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@chooseNoDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/choosepbbr', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@choosePBBR')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/getnewnmrdoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNewNmrDoc')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/savedata', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@saveData')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/bapemusnahan/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@printDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-PEMBATALAN_BA_PEMUSNAHAN
Route::get('/bo/transaksi/pemusnahan/bapbatal/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@index')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/bapbatal/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@getDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapbatal/getdetaildoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@getDetailDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapbatal/deletedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@deleteDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-INQUERY_BA_PEMUSNAHAN
Route::get('/bo/transaksi/pemusnahan/inquerybapb/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@index')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/inquerybapb/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@getDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/inquerybapb/getdetaildoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@getDetailDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/inquerybapb/detailplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@detailPlu')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PENERIMAAN-INPUT
Route::get('/bo/transaksi/penerimaan/input/',                   'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@index')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/input/showbtb/{tipetrn}', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showBTB')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/choosebtb',         'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@chooseBTB')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/getnewnobtb', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@getNewNoBTB')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/input/showpo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showPO')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/choosepo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@choosePO')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/input/showsupplier', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showSupplier')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/showplu', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showPlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/chooseplu', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@choosePlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/changehargabeli', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeHargaBeli')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/changeqty', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeQty')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/changebonus1', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeBonus1')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/changerphdisc', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeRphDisc')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/rekamdata', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@rekamData')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/transferpo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@transferPO')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/savedata', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@saveData')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PENERIMAAN-INQUERY BPB
Route::get('/bo/transaksi/penerimaan/inquery/index', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inqueryController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/inquery/viewbtp', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inqueryController@viewBTB')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/inquery/viewdata', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inqueryController@viewData')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/inquery/viewdetailplu', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inqueryController@viewDetailPlu')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PENERIMAAN-PEMBATALAN BPB
Route::get('/bo/transaksi/penerimaan/pembatalan/index', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\pembatalanController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/pembatalan/viewbtp', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\pembatalanController@viewBTB')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/pembatalan/viewdata', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\pembatalanController@viewData')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/pembatalan/batalbpb', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\pembatalanController@batalBPB')->middleware('CheckLogin');


//BACKOFFICE-TRANSAKSI-PENERIMAAN-CETAK BPB
Route::get('/bo/transaksi/penerimaan/printbpb/index', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/printbpb/viewdata', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@viewData')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/printbpb/cetakdata', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@cetakData')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/printbpb/viewreport/{reprint}/{report}/{noDoc}', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@viewReport')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/printbpb/viewreport/cetakLokasi', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@viewReport')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PENERIMAAN-CETAK LAPORAN BPB
Route::get('/bo/transaksi/penerimaan/cetakbpb/index', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/cetakbpb/cetaklaporan', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@cetakLaporan')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/cetakbpb/showpo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@showPO')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/cetakbpb/searchpo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@searchPO')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/cetakbpb/viewreport/', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@viewReport')->middleware('CheckLogin');

//OMI-PROSES BKL
Route::get('/OMI/proses-bkl', 'OMI\ProsesBKLDalamKotaController@index')->middleware('CheckLogin');
Route::post('/OMI/proses-bkl/proses-file', 'OMI\ProsesBKLDalamKotaController@prosesFile')->middleware('CheckLogin');
Route::get('/OMI/proses-bkl/cetak-laporan', 'OMI\ProsesBKLDalamKotaController@cetakLaporan')->middleware('CheckLogin');

//FRONT OFFICE - LAPORAN KASIR - LAPORAN PARETO SALES BY MEMBER
//Route::get('/frontoffice/LAPORANKASIR/laporan-pareto-sales-by-member', 'FRONTOFFICE\LAPORANKASIR\paretoSalesMemberController@index')->middleware('CheckLogin');
//Route::get('/frontoffice/LAPORANKASIR/laporan-pareto-sales-by-member/get-lov-member', 'FRONTOFFICE\LAPORANKASIR\paretoSalesMemberController@getLovMember')->middleware('CheckLogin');
//Route::get('/frontoffice/LAPORANKASIR/laporan-pareto-sales-by-member/cetak-laporan', 'FRONTOFFICE\LAPORANKASIR\paretoSalesMemberController@cetakLaporan')->middleware('CheckLogin');

//OMI-LAPORAN - REPRINT BKL
Route::get('/OMI/laporan/reprint-bkl', 'OMI\LAPORAN\ReprintBKLController@index')->middleware('CheckLogin');
Route::post('/OMI/laporan/reprint-bkl/cek-omi', 'OMI\LAPORAN\ReprintBKLController@checkKodeOmi')->middleware('CheckLogin');
Route::post('/OMI/laporan/reprint-bkl/cek-nomor', 'OMI\LAPORAN\ReprintBKLController@cekNomorBukti')->middleware('CheckLogin');
Route::get('/OMI/laporan/reprint-bkl/get-lov', 'OMI\LAPORAN\ReprintBKLController@getDataLov')->middleware('CheckLogin');
Route::get('/OMI/laporan/reprint-bkl/cetak-laporan', 'OMI\LAPORAN\ReprintBKLController@cetakLaporan')->middleware('CheckLogin');


//New Mode

Route::middleware(['CheckLogin'])->group(function () {
    Route::prefix('/master')->group(function () {
        /*  Jefri */
        Route::prefix('/mstcabang')->group(function () {
            Route::get('/',                 'MASTER\cabangController@index');
            Route::post('/getdetailcabang', 'MASTER\cabangController@getDetailCabang');
            Route::post('/editdatacabang',  'MASTER\cabangController@editDataCabang');
            Route::post('/trfdataanakcab',  'MASTER\cabangController@transDataAnakCab');
        });

        /*  Jefri */
        Route::prefix('/mstoutlet')->group(function () {
            Route::get('/',                 'MASTER\outletController@index');
        });

        /*  Jefri */
        Route::prefix('/mstsuboutlet')->group(function () {
            Route::get('/',                 'MASTER\subOutletController@index');
            Route::post('/getsuboutlet',    'MASTER\subOutletController@getSubOutlet');
        });

        Route::prefix('/mstomi')->group(function () {
            Route::get('/',                 'MASTER\omiController@index');
            Route::get('/gettokoomi',       'MASTER\omiController@getTokoOmi');
            Route::POST('/detailtokoomi',   'MASTER\omiController@detailTokoOmi');
            Route::POST('/getbranchname',   'MASTER\omiController@getBranchName');
            Route::POST('/getcustomername', 'MASTER\omiController@getCustomerName');
            Route::POST('/updatetokoomi',   'MASTER\omiController@updateTokoOmi');
            Route::POST('/tambahtokoomi',   'MASTER\omiController@tambahTokoOmi');
            Route::POST('/confirmedit',     'MASTER\omiController@confirmEdit');
        });

        /*  Jefri */
        Route::prefix('/mstaktifhrgjual')->group(function () {
            Route::get('/',                 'MASTER\aktifHargaJualController@index');
            Route::get('/getprodmast',      'MASTER\aktifHargaJualController@getProdmast');
            Route::post('/getdetailplu',    'MASTER\aktifHargaJualController@getDetailPlu');
            Route::post('/aktifkanhrg',     'MASTER\aktifHargaJualController@aktifkanHarga');
        });

        /*  Jefri */
        Route::prefix('/mstaktifallhrgjual')->group(function () {
            Route::get('/',                 'MASTER\aktifAllHargaJualController@index');
            Route::get('/getdata',          'MASTER\aktifAllHargaJualController@getData');
            Route::post('/aktifallitem',    'MASTER\aktifAllHargaJualController@aktifkanAllItem');
        });

        /*  Jefri */
        Route::prefix('/mstharilibur')->group(function () {
            Route::get('/',                 'MASTER\hariLiburController@index');
            Route::get('/getharilibur',     'MASTER\hariLiburController@getHariLibur');
            Route::post('/insert',          'MASTER\hariLiburController@insert');
            Route::post('/delete',          'MASTER\hariLiburController@delete');
        });



        /*Michelle*/
        // MASTER BARANG
        Route::prefix('/barang')->group(function () {
            Route::get('/', 'MASTER\barangController@index');
            Route::post('/showBarang', 'MASTER\barangController@showBarang');
            Route::get('/getmasterbarang', 'MASTER\barangController@getMasterBarang'); //Add by JR
            Route::get('/getmasterbarangidm', 'MASTER\barangController@getMasterBarangIDM'); //Add by JR
            Route::get('/getmasterbarangomi', 'MASTER\barangController@getMasterBarangOmi'); //Add by JR
        });

        /*Leo*/
        Route::prefix('/member')->group(function () {
            Route::get('/', 'MASTER\memberController@index');
            Route::get('/getlovmember', 'MASTER\memberController@getLovMember'); //add by JR
            Route::get('/getlovkodepos', 'MASTER\memberController@getLovKodepos'); //add by JR
            Route::get('/lov_member_search', 'MASTER\memberController@lov_member_search');
            Route::get('/lov_kodepos_search', 'MASTER\memberController@lov_kodepos_search');
            Route::get('/lov_member_select', 'MASTER\memberController@lov_member_select');
            Route::get('/lov_kodepos_select', 'MASTER\memberController@lov_kodepos_select');
            Route::get('/set_status_member', 'MASTER\memberController@set_status_member');
            Route::post('/check_password', 'MASTER\memberController@check_password');
            Route::post('/update_member', 'MASTER\memberController@update_member');
            Route::post('/download_mktho', 'MASTER\memberController@download_mktho');
            Route::post('/check_registrasi', 'MASTER\memberController@check_registrasi');
            Route::post('/lov_sub_outlet', 'MASTER\memberController@lov_suboutlet');
            Route::post('/export_crm', 'MASTER\memberController@export_crm');
            Route::post('/save_quisioner', 'MASTER\memberController@save_quisioner');
            Route::post('/hapus_member', 'MASTER\memberController@hapus_member');
        });

        /*Leo*/
        Route::prefix('/perusahaan')->group(function () {
            Route::get('/', 'MASTER\perusahaanController@index');
            Route::post('/update', 'MASTER\perusahaanController@update');
        });

        /*Leo*/
        Route::prefix('/barcode')->group(function () {
            Route::get('/', 'MASTER\barcodeController@index');
            Route::get('/getbarcode', 'MASTER\barcodeController@getBarcode');
        });

        /*Leo*/
        Route::prefix('/kategoritoko')->group(function () {
            Route::get('/', 'MASTER\kategoritokoController@index');
            Route::post('/getDataKtk', 'MASTER\kategoritokoController@getDataKtk');
            Route::post('/saveDataKtk', 'MASTER\kategoritokoController@saveDataKtk');
        });

        /*Leo*/
        Route::prefix('/approval')->group(function () {
            Route::get('/', 'MASTER\approvalController@index');
            Route::post('/saveData', 'MASTER\approvalController@saveData');
        });

        /*Leo*/
        Route::prefix('/jenisitem')->group(function () {
            Route::get('/', 'MASTER\jenisItemController@index');
            Route::get('/getprodmast', 'MASTER\jenisItemController@getProdmast');
            Route::post('/lov_search', 'MASTER\jenisItemController@lov_search');
            Route::post('/lov_select', 'MASTER\jenisItemController@lov_select');
            Route::post('/savedata', 'MASTER\jenisItemController@savedata');
        });

        /*Leo*/
        Route::prefix('/kubikasiplano')->group(function () {
            Route::get('/', 'MASTER\kubikasiPlanoController@index');
            Route::post('/lov_subrak', 'MASTER\kubikasiPlanoController@lov_subrak');
            Route::post('/lov_shelving', 'MASTER\kubikasiPlanoController@lov_shelving');
            Route::post('/dataRakKecil', 'MASTER\kubikasiPlanoController@dataRakKecil');
            Route::post('/dataRakKecilParam', 'MASTER\kubikasiPlanoController@dataRakKecilParam');
            Route::post('/lov_search', 'MASTER\kubikasiPlanoController@lov_search');
            Route::post('/save_kubikasi', 'MASTER\kubikasiPlanoController@save_kubikasi');

        });

        /*Leo*/
        Route::prefix('/informasihistoryproduct')->group(function () {
            Route::get('/', 'MASTER\informasiHistoryProductController@index');
            Route::get('/lov_search', 'MASTER\informasiHistoryProductController@lov_search');
            Route::get('/getNextPLU', 'MASTER\informasiHistoryProductController@getNextPLU');
            Route::get('/getPrevPLU', 'MASTER\informasiHistoryProductController@getPrevPLU');
            Route::post('/lov_search', 'MASTER\informasiHistoryProductController@lov_search');
            Route::post('/lov_select', 'MASTER\informasiHistoryProductController@lov_select');
            Route::post('/cetak_so', 'MASTER\informasiHistoryProductController@cetak_so');
            Route::post('/cetak', 'MASTER\informasiHistoryProductController@cetak');
        });


        /*MASTER LOKASI*/ //(nama file sebelum direvisi diubah menjadi lokasiBackUpController.php dan lokasiBackUp.blade.php
//        Route::prefix('/lokasi')->group(function(){
//            Route::get('/', 'MASTER\lokasiController@index');
//            Route::get('/getlokasi', 'MASTER\lokasiController@getLokasi');
//            Route::get('/getlokasi2', 'MASTER\lokasiController@getLokasi2'); //datatables rak versi 2
//            Route::get('/getprodmast', 'MASTER\lokasiController@getProdmast');
//            Route::post('/lov_rak_search', 'MASTER\lokasiController@lov_rak_search');
//            Route::post('/lov_rak_select', 'MASTER\lokasiController@lov_rak_select');
//            Route::post('/lov_plu_search', 'MASTER\lokasiController@lov_plu_search');
//            Route::post('/lov_plu_select', 'MASTER\lokasiController@lov_plu_select');
//            Route::post('/noid_enter', 'MASTER\lokasiController@noid_enter');
//            Route::post('/delete_plu', 'MASTER\lokasiController@delete_plu');
//            Route::post('/delete_lokasi', 'MASTER\lokasiController@delete_lokasi');
//            Route::post('/cek_plu', 'MASTER\lokasiController@cek_plu');
//            Route::post('/tambah', 'MASTER\lokasiController@tambah');
//            Route::post('/cek_dpd', 'MASTER\lokasiController@cek_dpd');
//            Route::post('/delete_dpd', 'MASTER\lokasiController@delete_dpd');
//            Route::post('/save_dpd', 'MASTER\lokasiController@save_dpd');
//        });

        /*MASTER LOKASI*/ //REVISED (kalau leo bingung pakai file lama sebelum revisi saja = lokasiBackUpController.php dan lokasiBackUp.blade.php)

        /*Leo*/
        Route::prefix('/lokasi')->group(function () {
            Route::get('/', 'MASTER\lokasiController@index');
            Route::get('/getlokasi', 'MASTER\lokasiController@getLokasi');
            Route::get('/getplu', 'MASTER\lokasiController@getPlu');
            Route::post('/lov_rak_select', 'MASTER\lokasiController@lov_rak_select');


            Route::get('/getlokasi2', 'MASTER\lokasiController@getLokasi2'); //datatables rak versi 2
            Route::get('/getprodmast', 'MASTER\lokasiController@getProdmast');
            Route::post('/lov_rak_search', 'MASTER\lokasiController@lov_rak_search');

            Route::post('/lov_plu_search', 'MASTER\lokasiController@lov_plu_search');
            Route::post('/lov_plu_select', 'MASTER\lokasiController@lov_plu_select');
            Route::post('/noid_enter', 'MASTER\lokasiController@noid_enter');
            Route::post('/delete_plu', 'MASTER\lokasiController@delete_plu');
            Route::post('/delete_lokasi', 'MASTER\lokasiController@delete_lokasi');
            Route::post('/cek_plu', 'MASTER\lokasiController@cek_plu');
            Route::post('/tambah', 'MASTER\lokasiController@tambah');
            Route::post('/cek_dpd', 'MASTER\lokasiController@cek_dpd');
            Route::post('/delete_dpd', 'MASTER\lokasiController@delete_dpd');
            Route::post('/save_dpd', 'MASTER\lokasiController@save_dpd');
        });

        /*Leo*/
        /*MASTER SUPPLIER*/
        Route::prefix('/supplier')->group(function () {
            Route::get('/', 'MASTER\supplierController@index');
            Route::get('/lov', 'MASTER\supplierController@lov');
            Route::get('/lov_select', 'MASTER\supplierController@lov_select');
            Route::get('/lov_search', 'MASTER\supplierController@lov_search');
        });

        /*Leo*/
        /*MASTER DEPARTEMENT*/
        Route::prefix('/departement')->group(function () {
            Route::get('/', 'MASTER\departementController@index');
            Route::get('/divisi_select', 'MASTER\departementController@divisi_select');
        });

        /*Leo*/
        /*MASTER DIVISI*/
        Route::prefix('/divisi')->group(function () {
            Route::get('/', 'MASTER\divisiController@index');
        });

        /*Leo*/
        /*MASTER KATEGORI BARANG*/
        Route::prefix('/kategoribarang')->group(function () {
            Route::get('/', 'MASTER\kategoriBarangController@index');
            Route::get('/departement_select', 'MASTER\kategoriBarangController@departement_select');
        });

        /*Leo*/
        /*MASTER HARGA BELI*/
        Route::prefix('/hargabeli')->group(function () {
            Route::get('/', 'MASTER\hargaBeliController@index');
            Route::get('/getprodmast', 'MASTER\hargaBeliController@getProdmast');
            Route::get('/lov_search', 'MASTER\hargaBeliController@lov_search');
            Route::get('/lov_select', 'MASTER\hargaBeliController@lov_select');
        });
    });

    Route::prefix('/bo')->group(function () {
        /*Leo*/
        Route::prefix('/pb')->group(function () {
            /*BACK OFFICE - KERTAS KERJA KEBUTUHAN TOKO IGR*/
            Route::prefix('/kkei')->group(function () {
                Route::get('/', 'BACKOFFICE\KKEIController@index');
                Route::post('/get_detail_produk', 'BACKOFFICE\KKEIController@get_detail_produk');
                Route::post('/get_detail_kkei', 'BACKOFFICE\KKEIController@get_detail_kkei');
                Route::post('/save', 'BACKOFFICE\KKEIController@save');
                Route::post('/laporan', 'BACKOFFICE\KKEIController@laporan');
                Route::get('/laporan', 'BACKOFFICE\KKEIController@laporan_view');

                Route::get('/test', 'BACKOFFICE\KKEIController@test');
            });


            /*Leo*/
            /*BACK OFFICE - UPLOAD DAN MONITORING KKEI TOKO IGR*/
            Route::prefix('/kirimkkei')->group(function () {
                Route::get('/', 'BACKOFFICE\KirimKKEIController@index');
                Route::post('/upload', 'BACKOFFICE\KirimKKEIController@upload');
                Route::post('/refresh', 'BACKOFFICE\KirimKKEIController@refresh');
            });

            /*Leo*/
            /*BACK OFFICE - REORDER PB GO*/
            Route::prefix('reorder-pb-go')->group(function () {
                Route::get('/', 'BACKOFFICE\ReorderPBGOController@index');
                Route::post('/proses_go', 'BACKOFFICE\ReorderPBGOController@proses_go');
                Route::get('/cetak_tolakan', 'BACKOFFICE\ReorderPBGOController@cetak_tolakan');
            });

            /*Leo*/
            /*BACK OFFICE - CETAK TOLAKAN PB*/
            Route::prefix('/cetak-tolakan-pb')->group(function () {
                Route::get('/', 'BACKOFFICE\CetakTolakanPBController@index');
                Route::post('/cek_divisi', 'BACKOFFICE\CetakTolakanPBController@cek_divisi');
                Route::post('/cek_departement', 'BACKOFFICE\CetakTolakanPBController@cek_departement');
                Route::post('/cek_kategori', 'BACKOFFICE\CetakTolakanPBController@cek_kategori');
                Route::post('/div_cek_plu', 'BACKOFFICE\CetakTolakanPBController@div_cek_plu');
                Route::get('/print_by_div', 'BACKOFFICE\CetakTolakanPBController@print_by_div');
                Route::post('/search_supplier', 'BACKOFFICE\CetakTolakanPBController@search_supplier');
                Route::post('/sup_search_plu', 'BACKOFFICE\CetakTolakanPBController@sup_search_plu');
                Route::post('/cek_supplier', 'BACKOFFICE\CetakTolakanPBController@cek_supplier');
                Route::post('/sup_cek_plu', 'BACKOFFICE\CetakTolakanPBController@sup_cek_plu');
                Route::get('/print_by_sup', 'BACKOFFICE\CetakTolakanPBController@print_by_sup');
            });
        });

        Route::prefix('/lpp')->group(function () {
            Route::prefix('/proses-lpp')->group(function () {
                Route::get('/', 'BACKOFFICE\LPP\ProsesLPPController@index');
                Route::post('/proses', 'BACKOFFICE\LPP\ProsesLPPController@proses');
            });
            Route::prefix('/register-lpp')->group(function () {
                Route::get('/', 'BACKOFFICE\LPP\RegisterLPPController@index');
                Route::get('/getPLU', 'BACKOFFICE\LPP\RegisterLPPController@getPLU');
                Route::get('/getDep', 'BACKOFFICE\LPP\RegisterLPPController@getDep');
                Route::get('/getKat', 'BACKOFFICE\LPP\RegisterLPPController@getKat');
                Route::get('/getMtr', 'BACKOFFICE\LPP\RegisterLPPController@getMtr');
                Route::get('/getSup', 'BACKOFFICE\LPP\RegisterLPPController@getSup');
                Route::get('/cetak', 'BACKOFFICE\LPP\RegisterLPPController@cetak');
                Route::get('/cetak-bagian-2', 'BACKOFFICE\LPP\RegisterLPPController@cetak_bagian_2');
            });
            Route::prefix('/register-ba-idm')->group(function () {
                Route::get('/', 'BACKOFFICE\LPP\RegisterBAIDMController@index');
                Route::get('/cetak', 'BACKOFFICE\LPP\RegisterBAIDMController@cetak');
            });
        });

        Route::prefix('/bopbmanual')->group(function () {
            Route::get('/', 'BACKOFFICE\PBManualController@index');
            Route::post('/lov_search', 'BACKOFFICE\PBManualController@lov_search');
            Route::post('/getDataPB', 'BACKOFFICE\PBManualController@getDataPB');
            Route::post('/hapusDokumen', 'BACKOFFICE\PBManualController@hapusDokumen');
            Route::post('/lov_search_plu', 'BACKOFFICE\PBManualController@lov_search_plu');
            Route::post('/cek_plu', 'BACKOFFICE\PBManualController@cek_plu');
            Route::post('/cek_bonus', 'BACKOFFICE\PBManualController@cek_bonus');
            Route::post('/save_data', 'BACKOFFICE\PBManualController@save_data');
        });

        Route::prefix('/transaksi')->group(function () {
            Route::prefix('/pengeluaran')->group(function () {
                Route::prefix('/input')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@index');
                    Route::get('/get-data-lov-trn', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@getDataLovTrn');
                    Route::get('/get-data-lov-supplier', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@getDataLovSupplier');
                    Route::get('/get-data-lov-plu', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@getDataLovPLU');
                    Route::get('/get-data-pengeluaran', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@getDataPengeluaran');
                    Route::get('/get-new-no-trn', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@getNewNoTrn');
                    Route::post('/delete-trn', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@deleteTrn');
                    Route::get('/get-data-plu', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@getDataPlu');
                    Route::get('/get-data-supplier', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@getDataSupplier');
                    Route::get('/get-data-lks', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@getDataLKS');
                    Route::post('/save-data-lks', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@saveDataLKS');
                    Route::post('/delete', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@delete');
                    Route::post('/save-data-trn', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@saveDataTrn');
                    Route::post('/cek-pcs-1', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@cekPCS1');
                    Route::post('/cek-pcs-2', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@cekPCS2');
                    Route::post('/cek-pcs-3', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@cekPCS3');
                    Route::post('/cek-pcs-4', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@cekPCS4');
                    Route::post('/proses', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@proses');
                    Route::post('/save', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@save');
                    Route::post('/get-data-usulan', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@getDataUsulan');
                    Route::post('/send-usulan', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@sendUsulan');
                    Route::post('/cek-OTP', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@cekOTP');
                });
                Route::prefix('/inquery')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InqueryController@index');
                    Route::get('/get-data-lov-npb', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InqueryController@getDataLovNPB');
                    Route::get('/get-data-npb', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InqueryController@getDataNPB');
                    Route::get('/get-data-detail', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InqueryController@getDataDetail');
                });
                Route::prefix('/pembatalan')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\PembatalanController@index');
                    Route::get('/get-data-lov-npb', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\PembatalanController@getDataLovNPB');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\PembatalanController@getData');
                    Route::post('/delete', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\PembatalanController@delete');
                });

                Route::prefix('/inqueryrtrsup')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InqueryRtrSupController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InqueryRtrSupController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InqueryRtrSupController@getData');
                    Route::get('/get-data-detail', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InqueryRtrSupController@getDataDetail');
                    Route::get('/cetak', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InqueryRtrSupController@report');
                });

            });

            /*Leo*/
            Route::prefix('/penyesuaian')->group(function () {
                Route::prefix('/input')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@index');
                    Route::get('/lov_plu_search', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@lov_plu_search');
                    Route::post('/plu_select', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@plu_select');
                    Route::post('/doc_select', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_select');
                    Route::post('/doc_new', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_new');
                    Route::post('/doc_save', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_save');
                    Route::post('/doc_delete', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_delete');
                });

                Route::prefix('/cetak')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@index');
                    Route::post('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@getData');
                    Route::post('/store-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@storeData');
                    Route::get('/laporan', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@laporan');
                    Route::get('/tes', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@tes');
                });

                Route::prefix('/inquerympp')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InqueryMPPController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InqueryMPPController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InqueryMPPController@getData');
                    Route::get('/get-detail', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InqueryMPPController@getDetail');
                });

                Route::prefix('/pembatalanmpp')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PembatalanMPPController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PembatalanMPPController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PembatalanMPPController@getData');
                    Route::post('/batal', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PembatalanMPPController@batal');
                });

                Route::prefix('/perubahanplu')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@getData');
                    Route::post('/proses', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@proses');
                    Route::get('/laporan', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@laporan');
                });
            });

            /*Leo*/
            Route::prefix('/kirimcabang')->group(function () {
                Route::prefix('/input')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@index');
                    Route::get('/get-data-lov-trn', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@getDataLovTrn');
                    Route::get('/get-data-lov-plu', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@getDataLovPlu');
                    Route::get('/get-data-lov-cabang', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@getDataLovCabang');
                    Route::get('/get-data-lov-ipb', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@getDataLovIpb');
                    Route::get('/get-data-trn', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@getDataTrn');
                    Route::get('/get-new-no-trn', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@getNewNoTrn');
                    Route::post('/delete-trn', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@deleteTrn');
                    Route::get('/get-data-plu', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@getDataPlu');
                    Route::get('/get-data-lks', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@getDataLKS');
                    Route::post('/save-data-lks', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@saveDataLKS');
                    Route::post('/delete-data-lks', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@deleteDataLKS');
                    Route::post('/save-data-trn', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InputController@saveDataTrn');
                });

                Route::prefix('/cetak')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\CetakController@index');
                    Route::post('/get-data', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\CetakController@getData');
                    Route::post('/store-data', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\CetakController@storeData');
                    Route::get('/laporan', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\CetakController@laporan');
                });

                Route::prefix('/batal')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\BatalController@index');
                    Route::post('/get-data', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\BatalController@getData');
                    Route::post('/execute', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\BatalController@execute');
                });

                Route::prefix('/inquery')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InqueryController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InqueryController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\InqueryController@getData');
                });

                Route::prefix('/sj-packlist')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\SJPacklistController@index');
                    Route::get('/proses', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\SJPacklistController@execute');
                    Route::get('/cetak', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\SJPacklistController@cetak');
                });

                Route::prefix('/cetak-sj-packlist')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\CetakSJPacklistController@index');
                    Route::get('/cetak', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\CetakSJPacklistController@cetak');
                    Route::get('/get-pdf', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\CetakSJPacklistController@getPDF');
                });

                Route::prefix('/transfer-sj')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\TransferSJController@index');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\TransferSJController@getData');
                    Route::post('/transfer', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\TransferSJController@transfer');
                    Route::get('/download', 'BACKOFFICE\TRANSAKSI\KIRIMCABANG\TransferSJController@download');
                });
            });

            /*Leo*/
            Route::prefix('/penerimaandaricabang')->group(function () {
                Route::prefix('/penerimaan-transfer')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\PenerimaanTransferController@index');
                    Route::get('/get-data-tsj', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\PenerimaanTransferController@getDataTSJ');
                    Route::get('/get-detail-tsj', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\PenerimaanTransferController@getDetailTSJ');
                    Route::post('/proses-alfdoc', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\PenerimaanTransferController@prosesAlfdoc');
                    Route::post('/upload-to', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\PenerimaanTransferController@uploadTO');
                    Route::get('/get-data-to', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\PenerimaanTransferController@getDataTO');
                    Route::get('/get-detail-to', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\PenerimaanTransferController@getDetailTO');
                    Route::post('/proses-to', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\PenerimaanTransferController@prosesTO');
                });

                Route::prefix('/cetak-transfer')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\CetakTransferController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\CetakTransferController@getDataLov');
                    Route::get('/cetak', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\CetakTransferController@cetak');
                    Route::get('/test', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\CetakTransferController@test');
                });

                Route::prefix('/inquery-transfer')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\InqueryTransferController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\InqueryTransferController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\InqueryTransferController@getData');
                });

                Route::prefix('/batal-transfer')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\BatalTransferController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\BatalTransferController@getDataLov');
                    Route::post('/batal', 'BACKOFFICE\TRANSAKSI\PENERIMAANDARICABANG\BatalTransferController@batal');
                });
            });

            /*Michelle*/
            Route::prefix('/barang-hilang')->group(function () {
                // BACK OFFICE / TRANSAKSI / BARANG HILANG / INPUT
                Route::prefix('/input')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@index');
                    Route::post('/lov_trn', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@lov_trn');
                    Route::post('/lov_plu', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@lov_plu');
                    Route::post('/showTrn', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@showTrn');
                    Route::post('/showPlu', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@showPlu');
                    Route::post('/nmrBaruTrn', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@nmrBaruTrn');
                    Route::post('/saveDoc', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@saveDoc');
                    Route::post('/deleteDoc', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@saveDoc');
                });

                // BACK OFFICE / TRANSAKSI / BARANG HILANG / PEMBATALAN NBH
                Route::prefix('/pembatalan-nbh')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\pembatalanNBHController@index');
                    Route::post('/lovNBH', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\pembatalanNBHController@lovNBH');
                    Route::post('/showData', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\pembatalanNBHController@showData');
                    Route::post('/deleteData', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\pembatalanNBHController@deleteData');
                });

                // BACK OFFICE / TRANSAKSI / BARANG HILANG / INQUERY NBH
                Route::prefix('inquery-nbh')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\inqueryNBHController@index');
                    Route::post('/lov_NBH', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\inqueryNBHController@lov_NBH');
                    Route::post('/showDoc', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\inqueryNBHController@showDoc');
                    Route::post('/detail_Plu', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\inqueryNBHController@detail_Plu');
                });
            });

            /*Ryan*/
            Route::prefix('/perubahanstatus')->group(function () {
                Route::prefix('/entrySortirBarang')->group(function () {
                    //BACKOFFICE-TRANSAKSI-PERUBAHAN STATUS-ENTRY SORTIR BARANG (ryanOrder = 1)
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@index');
                    Route::post('/getnewnmrsrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@getNewNmrSrt');
                    Route::post('/getnmrsrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@getNmrSrt');
                    Route::post('/choosesrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@chooseSrt');
                    Route::post('/getplu', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@getPlu');
                    Route::post('/chooseplu', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@choosePlu');
                    Route::post('/savedata', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@saveData');
                    Route::get('/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@printDocument');

                    Route::get('/modalsrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@ModalSrt');
                    Route::get('/modalplu', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@ModalPlu');
                });

                Route::prefix('/rubahStatus')->group(function () {
                    //BACKOFFICE-TRANSAKSI-PERUBAHAN STATUS-RUBAH STATUS (ryanOrder = 2)
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@index');
                    Route::post('/getnewnmrrsn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@getNewNmrRsn');
                    Route::post('/getnmrrsn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@getNmrRsn');
                    Route::post('/getnmrsrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@getNmrSrt');
                    Route::post('/choosersn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@chooseRsn');
                    Route::post('/choosesrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@chooseSrt');
                    Route::post('/savedata', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@saveData');
                    Route::post('/checkrak', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@checkRak');
                    Route::get('/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@printDocument');
                    Route::get('/printdocrak/{doc}', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@printDocumentRak');

                    Route::get('/modalrsn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@ModalRsn');
                    Route::get('/modalsrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@Modalsrt');
                });
            });

            /*Ryan*/
            Route::prefix('/repacking')->group(function () {
                Route::prefix('/repacking')->group(function () {
                    //BACKOFFICE-REPACKING-REPACKING (ryanOrder = 3)
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@index');
                    Route::post('/getNewNmrTrn', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@getNewNmrTrn');
                    Route::post('/chooseTrn', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@chooseTrn');
                    Route::post('/getNmrTrn', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@getNmrTrn');
                    Route::post('/deleteTrn', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@deleteTrn');
                    Route::post('/getPlu', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@getPlu');
                    Route::post('/choosePlu', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@choosePlu');
                    Route::post('/saveData', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@saveData');
                    Route::post('/print', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@print');
                    Route::get('/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@printDocument');
                    Route::get('/printdockecil/{doc}', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@printDocumentKecil');

                    Route::get('/modalnmrtrn', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@ModalNmrTrn');
                    Route::get('/modalplu', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@ModalPlu');
                });

                Route::prefix('/laprepacking')->group(function () {
                    //BACKOFFICE-REPACKING-LAPREPACKING (ryanOrder = 4)
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\REPACKING\LapRepackController@index');
                    Route::post('/checkdata', 'BACKOFFICE\TRANSAKSI\REPACKING\LapRepackController@CheckData');
                    Route::get('/printdoc/{date1}/{date2}', 'BACKOFFICE\TRANSAKSI\REPACKING\LapRepackController@printDocument');
                });
            });
        });

        /*Ryan*/
        Route::prefix('/list-master')->group(function () {
            Route::get('/', 'BACKOFFICE\listmasterController@index');
        });

        Route::prefix('/proses')->group(function () {
            Route::prefix('/konversi')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\KonversiController@index');
                Route::get('/get-data-lov-plu-utuh', 'BACKOFFICE\PROSES\KonversiController@getDataLovPluUtuh');
                Route::get('/get-data-lov-plu-mix', 'BACKOFFICE\PROSES\KonversiController@getDataLovPluMix');
                Route::get('/get-data-lov-nodoc', 'BACKOFFICE\PROSES\KonversiController@getDataLovNodoc');
                Route::get('/get-data-plu-olahan', 'BACKOFFICE\PROSES\KonversiController@getDataPluOlahan');
                Route::post('/konversi-utuh-olahan', 'BACKOFFICE\PROSES\KonversiController@konversiUtuhOlahan');
                Route::post('/konversi-olahan-mix', 'BACKOFFICE\PROSES\KonversiController@konversiOlahanMix');
                Route::get('/print-bukti', 'BACKOFFICE\PROSES\KonversiController@printBukti');
                Route::get('/print-laporan-rekap', 'BACKOFFICE\PROSES\KonversiController@printLaporanRekap');
                Route::get('/print-laporan-detail', 'BACKOFFICE\PROSES\KonversiController@printLaporanDetail');
            });
            Route::prefix('/hitungulangstock')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\HitungUlangStockController@index');
                Route::get('/get-data-lov', 'BACKOFFICE\PROSES\HitungUlangStockController@getDataLov');
                Route::post('/hitung-ulang-stock', 'BACKOFFICE\PROSES\HitungUlangStockController@ProsesHitungUlangStock');
                Route::post('/hitung-ulang-point', 'BACKOFFICE\PROSES\HitungUlangStockController@ProsesHitungUlangPoint');
                Route::post('/hapus-point', 'BACKOFFICE\PROSES\HitungUlangStockController@ProsesHapusPoint');
                Route::get('/cetak', 'BACKOFFICE\PROSES\HitungUlangStockController@PrintHapus');
            });
            Route::prefix('/monthend')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\MonthEndController@index');
                Route::post('/proses', 'BACKOFFICE\PROSES\MonthEndController@proses');
                Route::post('/proses-hitung-stok', 'BACKOFFICE\PROSES\MonthEndController@prosesHitungStock');
                Route::post('/proses-hitung-stok-cmo', 'BACKOFFICE\PROSES\MonthEndController@prosesHitungStockCMO');
                Route::post('/proses-sales-rekap', 'BACKOFFICE\PROSES\MonthEndController@prosesSalesRekap');
                Route::post('/proses-sales-lpp', 'BACKOFFICE\PROSES\MonthEndController@prosesLPP');
                Route::post('/delete-data', 'BACKOFFICE\PROSES\MonthEndController@deleteData');
                Route::post('/proses-copystock', 'BACKOFFICE\PROSES\MonthEndController@prosesCopyStock');
                Route::post('/proses-hitung-stok2', 'BACKOFFICE\PROSES\MonthEndController@prosesHitungStock2');
            });

            /*Michele*/
            Route::prefix('/setting-pagi-hari')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\settingPagiHariController@index');
                Route::get('/cetak_perubahan_harga_jual', 'BACKOFFICE\PROSES\settingPagiHariController@cetak_perubahan_harga_jual');
                Route::get('/cetak_daftar_plu_tag', 'BACKOFFICE\PROSES\settingPagiHariController@cetak_daftar_plu_tag');
            });
        });

        Route::prefix('/laporan')->group(function () {
            /*Ryan*/
            Route::prefix('/outsscan')->group(function () {
                //BACKOFFICE-LAPORAN-OUTSTANDING SCANNING IDM / OMI (ryanOrder = 6)
                Route::get('/', 'BACKOFFICE\LAPORAN\OutsScanController@index');
                Route::post('/checkdata', 'BACKOFFICE\LAPORAN\OutsScanController@CheckData');
                Route::get('/printdoc/{date}', 'BACKOFFICE\LAPORAN\OutsScanController@printDocument');
            });

            /*Ryan*/
            Route::prefix('/kunjunganbkl')->group(function () {
                //BACKOFFICE-LAPORAN-LAPORAN BULANAN KEDATANGAN SUPPLIER BKL (ryanOrder = 7)
                Route::get('/', 'BACKOFFICE\LAPORAN\KunjunganBKLController@index');
                Route::post('/checkdata', 'BACKOFFICE\LAPORAN\KunjunganBKLController@CheckData');
                Route::get('/printdoc/{date}', 'BACKOFFICE\LAPORAN\KunjunganBKLController@printDocument');
            });

            /*Ryan*/
            Route::prefix('/saleshbv')->group(function () {
                //BACKOFFICE-LAPORAN-PERHITUNGAN TRANSFER SATUAN PRODUK (IGR_BO_SALES_HBV) (ryanOrder = 8)
                Route::get('/', 'BACKOFFICE\LAPORAN\SalesHBVController@index');
                Route::post('/checkdata', 'BACKOFFICE\LAPORAN\SalesHBVController@CheckData');
                Route::get('/printdoc/{date1}/{date2}', 'BACKOFFICE\LAPORAN\SalesHBVController@printDocument');
            });

            /*Ryan*/
            Route::prefix('/servicelevelitempareto')->group(function () {
                //BACKOFFICE-LAPORAN-SERVICE LEVEL ITEM PARETO (IGR_BO_SRVCLVLPARETO) (ryanOrder = 9)
                Route::get('/', 'BACKOFFICE\LAPORAN\ServiceLevelItemParetoController@index');
                Route::post('/getnmr', 'BACKOFFICE\LAPORAN\ServiceLevelItemParetoController@getNmr');
                Route::post('/checkdata', 'BACKOFFICE\LAPORAN\ServiceLevelItemParetoController@CheckData');
                Route::get('/printdocddk/{kodemon}/{date1}/{date2}', 'BACKOFFICE\LAPORAN\ServiceLevelItemParetoController@printDocumentddk');
                Route::get('/printdocsupplier/{kodemon}/{date1}/{date2}', 'BACKOFFICE\LAPORAN\ServiceLevelItemParetoController@printDocumentSupplier');

                Route::get('/modalnmr', 'BACKOFFICE\LAPORAN\ServiceLevelItemParetoController@ModalNmr');
            });

            /*Michelle*/
            // LAPORAN / LAPORAN SERVICE LEVEL PO THD BPB
            Route::prefix('/laporan-service-level')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\LaporanServiceLevelController@index');
                Route::post('/lov_supplier', 'BACKOFFICE\LAPORAN\LaporanServiceLevelController@lov_supplier');
                Route::post('/lov_monitoring', 'BACKOFFICE\LAPORAN\LaporanServiceLevelController@lov_monitoring');
                Route::post('/cetak_laporan', 'BACKOFFICE\LAPORAN\LaporanServiceLevelController@cetak_laporan');
            });
            Route::prefix('/daftar-pembelian')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\DaftarPembelianController@index');
                Route::get('/get-data-lov-div', 'BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovDiv');
                Route::get('/get-data-lov-dep', 'BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovDep');
                Route::get('/get-data-lov-kat', 'BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovKat');
                Route::get('/get-data-lov-mtr', 'BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovMtr');
                Route::get('/get-data-lov-sup', 'BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovSup');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\DaftarPembelianController@cetak');
            });

            Route::prefix('/daftar-retur-pembelian')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\DaftarReturPembelianController@index');
                Route::get('/get-data-lov-div', 'BACKOFFICE\LAPORAN\DaftarReturPembelianController@getDataLovDiv');
                Route::get('/get-data-lov-dep', 'BACKOFFICE\LAPORAN\DaftarReturPembelianController@getDataLovDep');
                Route::get('/get-data-lov-kat', 'BACKOFFICE\LAPORAN\DaftarReturPembelianController@getDataLovKat');
                Route::get('/get-data-lov-mtr', 'BACKOFFICE\LAPORAN\DaftarReturPembelianController@getDataLovMtr');
                Route::get('/get-data-lov-sup', 'BACKOFFICE\LAPORAN\DaftarReturPembelianController@getDataLovSup');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\DaftarReturPembelianController@cetak');
            });

            Route::prefix('/daftar-pemusnahan-barang')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\DaftarPemusnahanBarangController@index');
                Route::get('/get-data-lov-div', 'BACKOFFICE\LAPORAN\DaftarPemusnahanBarangController@getDataLovDiv');
                Route::get('/get-data-lov-dep', 'BACKOFFICE\LAPORAN\DaftarPemusnahanBarangController@getDataLovDep');
                Route::get('/get-data-lov-kat', 'BACKOFFICE\LAPORAN\DaftarPemusnahanBarangController@getDataLovKat');
                Route::get('/get-data-lov-mtr', 'BACKOFFICE\LAPORAN\DaftarPemusnahanBarangController@getDataLovMtr');
                Route::get('/get-data-lov-sup', 'BACKOFFICE\LAPORAN\DaftarPemusnahanBarangController@getDataLovSup');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\DaftarPemusnahanBarangController@cetak');
            });

            Route::prefix('/penyesuaian')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\PenyesuaianController@index');
                Route::get('/get-data-lov-div', 'BACKOFFICE\LAPORAN\PenyesuaianController@getDataLovDiv');
                Route::get('/get-data-lov-dep', 'BACKOFFICE\LAPORAN\PenyesuaianController@getDataLovDep');
                Route::get('/get-data-lov-kat', 'BACKOFFICE\LAPORAN\PenyesuaianController@getDataLovKat');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\PenyesuaianController@cetak');
            });

            Route::prefix('/pengiriman')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\PengirimanController@index');
                Route::get('/get-data-lov-div', 'BACKOFFICE\LAPORAN\PengirimanController@getDataLovDiv');
                Route::get('/get-data-lov-dep', 'BACKOFFICE\LAPORAN\PengirimanController@getDataLovDep');
                Route::get('/get-data-lov-kat', 'BACKOFFICE\LAPORAN\PengirimanController@getDataLovKat');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\PengirimanController@cetak');
            });

            Route::prefix('/penerimaan')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\PenerimaanController@index');
                Route::get('/get-data-lov-div', 'BACKOFFICE\LAPORAN\PenerimaanController@getDataLovDiv');
                Route::get('/get-data-lov-dep', 'BACKOFFICE\LAPORAN\PenerimaanController@getDataLovDep');
                Route::get('/get-data-lov-kat', 'BACKOFFICE\LAPORAN\PenerimaanController@getDataLovKat');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\PenerimaanController@cetak');
            });
        });

        /*Leo*/
        Route::prefix('/transfer')->group(function () {
            Route::prefix('/plu')->group(function () {
                Route::get('/', 'BACKOFFICE\TRANSFER\TransferPLUController@index');
                Route::post('/download-dta', 'BACKOFFICE\TRANSFER\TransferPLUController@downloadDTA');
                Route::post('/transfer-dta4', 'BACKOFFICE\TRANSFER\TransferPLUController@transferDTA4');
                Route::post('/req-proses-dta4', 'BACKOFFICE\TRANSFER\TransferPLUController@reqProsesDTA4');
            });

            Route::prefix('/po')->group(function () {
                Route::get('/', 'BACKOFFICE\TRANSFER\TransferPOController@index');
                Route::get('/get-data', 'BACKOFFICE\TRANSFER\TransferPOController@getData');
                Route::post('/proses-transfer', 'BACKOFFICE\TRANSFER\TransferPOController@prosesTransfer');
            });

            Route::prefix('/pb-ke-md')->group(function () {
                Route::get('/', 'BACKOFFICE\TRANSFER\TransferPBkeMDController@index');
                Route::post('/proses-transfer', 'BACKOFFICE\TRANSFER\TransferPBkeMDController@prosesTransfer');
            });
        });

        /*Leo*/
        Route::prefix('/pkm')->group(function () {
            Route::prefix('/kertas-kerja')->group(function () {
                Route::get('/', 'BACKOFFICE\PKM\ProsesKertasKerjaPKMController@index');
                Route::get('/get-data-lov-prdcd', 'BACKOFFICE\PKM\ProsesKertasKerjaPKMController@getLovPrdcd');
                Route::get('/get-data-history', 'BACKOFFICE\PKM\ProsesKertasKerjaPKMController@getHistory');
                Route::post('/change-pkm', 'BACKOFFICE\PKM\ProsesKertasKerjaPKMController@changePKM');
                Route::get('/cetak-status-storage', 'BACKOFFICE\PKM\ProsesKertasKerjaPKMController@cetakStatusStorage');
            });

            Route::prefix('/entry-inquery')->group(function () {
                Route::get('/', 'BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@index');
                Route::get('/get-lov-prdcd', 'BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovPrdcd');
                Route::get('/get-lov-divisi', 'BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovDivisi');
                Route::get('/get-lov-departement', 'BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovDepartement');
                Route::get('/get-lov-kategori', 'BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovKategori');
                Route::get('/get-lov-monitoring', 'BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovMonitoring');
                Route::get('/get-detail', 'BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getDetail');
                Route::post('/change-pkm', 'BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@changePKM');
            });

            Route::prefix('/monitoring')->group(function () {
                Route::get('/', 'BACKOFFICE\PKM\MonitoringController@index');
                Route::get('/get-lov-prdcd', 'BACKOFFICE\PKM\MonitoringController@getLovPrdcd');
                Route::get('/get-lov-prdcd-new', 'BACKOFFICE\PKM\MonitoringController@getLovPrdcdNew');
                Route::get('/get-data', 'BACKOFFICE\PKM\MonitoringController@getData');
                Route::get('/get-data-added', 'BACKOFFICE\PKM\MonitoringController@getDataAdded');
                Route::post('/add-data', 'BACKOFFICE\PKM\MonitoringController@addData');
                Route::post('/change-pkm', 'BACKOFFICE\PKM\MonitoringController@changePKM');
                Route::post('/delete-data', 'BACKOFFICE\PKM\MonitoringController@deleteData');
                Route::get('/print', 'BACKOFFICE\PKM\MonitoringController@print');
            });
        });

        /*Leo*/
        Route::prefix('/cetak-register')->group(function () {
            Route::get('/', 'BACKOFFICE\CETAKREGISTER\CetakRegisterController@index');
            Route::get('/print', 'BACKOFFICE\CETAKREGISTER\CetakRegisterController@print');
        });

        /*Leo*/
        Route::prefix('/cetak-dokumen')->group(function () {
            Route::get('/', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@index');
            Route::get('/showData', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@showData');
            Route::post('/CSVeFaktur', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@CSVeFaktur');
            Route::post('/cetak', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@cetak');
            Route::get('/print-doc', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@PRINT_DOC');
        });

        /*Leo*/
        Route::prefix('/pb-gudang-pusat')->group(function () {
            Route::get('/', 'BACKOFFICE\PBGudangPusatController@index');
            Route::get('/get-lov-prdcd', 'BACKOFFICE\PBGudangPusatController@getLovPrdcd');
            Route::get('/get-lov-divisi', 'BACKOFFICE\PBGudangPusatController@getLovDivisi');
            Route::get('/get-lov-departement', 'BACKOFFICE\PBGudangPusatController@getLovDepartement');
            Route::get('/get-lov-kategori', 'BACKOFFICE\PBGudangPusatController@getLovKategori');
            Route::post('/proses', 'BACKOFFICE\PBGudangPusatController@proses');
        });

        /*Leo*/
        Route::prefix('/scan-barcode-igr')->group(function () {
            Route::get('/', 'BACKOFFICE\ScanBarcodeIgrController@index');
            Route::get('/detail', 'BACKOFFICE\ScanBarcodeIgrController@detail');
        });

        /*Leo*/
        Route::prefix('/input-pertemanan')->group(function () {
            Route::get('/', 'BACKOFFICE\InputPertemananController@index');
            Route::get('/get-lov-prdcd', 'BACKOFFICE\InputPertemananController@getLovPrdcd');
            Route::get('/get-data', 'BACKOFFICE\InputPertemananController@getData');
            Route::post('/delete-plano', 'BACKOFFICE\InputPertemananController@deletePlano');
            Route::get('/get-last-number', 'BACKOFFICE\InputPertemananController@getLastNumber');
            Route::get('/get-lov-kode-rak', 'BACKOFFICE\InputPertemananController@getLovKodeRak');
            Route::post('/add-plano', 'BACKOFFICE\InputPertemananController@addPlano');
            Route::post('/swap-plano', 'BACKOFFICE\InputPertemananController@swapPlano');
        });

        /*Leo*/
        Route::prefix('/kertas-kerja-status')->group(function () {
            Route::get('/', 'BACKOFFICE\KertasKerjaStatusController@index');
            Route::get('/get-lov-kode-rak', 'BACKOFFICE\KertasKerjaStatusController@getLovKodeRak');
            Route::get('/print', 'BACKOFFICE\KertasKerjaStatusController@print');
        });

        /*Leo*/
        Route::prefix('/monitoring-stok-pareto')->group(function () {
            Route::get('/', 'BACKOFFICE\MonitoringStokParetoController@index');
            Route::get('/get-lov-monitoring', 'BACKOFFICE\MonitoringStokParetoController@getLovMonitoring');
            Route::get('/print-kkh', 'BACKOFFICE\MonitoringStokParetoController@printKKH');
            Route::get('/print-montok', 'BACKOFFICE\MonitoringStokParetoController@printMontok');
        });

        /*Ryan*/
        Route::prefix('/kerjasamaigridm')->group(function () {
            Route::prefix('/lapbedatag')->group(function () {
                //BACKOFFICE-KERJASAMAIGRIDM-LAPORAN BEDA TAG (IGR_BO_BEDATAG) (ryanOrder = 10)
                Route::get('/', 'BACKOFFICE\KERJASAMAIGRIDM\LapBedaTagController@index');
                Route::post('/checkdata', 'BACKOFFICE\KERJASAMAIGRIDM\LapBedaTagController@CheckData');
                Route::get('/printdoc/{tag}', 'BACKOFFICE\KERJASAMAIGRIDM\LapBedaTagController@printDocument');
            });
            Route::prefix('/stout')->group(function () {
                //BACKOFFICE-KERJASAMAIGRIDM-LAPORAN STOCK OUT (IGR_BO_STOUT) (ryanOrder = 11)
                Route::get('/', 'BACKOFFICE\KERJASAMAIGRIDM\StoutController@index');
                Route::post('/getdiv', 'BACKOFFICE\KERJASAMAIGRIDM\StoutController@GetDiv');
                Route::post('/getdept', 'BACKOFFICE\KERJASAMAIGRIDM\StoutController@GetDept');
                Route::post('/getkat', 'BACKOFFICE\KERJASAMAIGRIDM\StoutController@GetKat');
                Route::post('/checkdata', 'BACKOFFICE\KERJASAMAIGRIDM\StoutController@CheckData');
                Route::get('/printdoc/{choice}/{div1}-{div2}/{dept1}-{dept2}/{kat1}-{kat2}', 'BACKOFFICE\KERJASAMAIGRIDM\StoutController@printDocument');

                Route::get('kerjasamaigridm/stout/modaldiv', 'BACKOFFICE\KERJASAMAIGRIDM\StoutController@ModalDiv');
                Route::get('kerjasamaigridm/stout/modaldept/{div1}/{div2}', 'BACKOFFICE\KERJASAMAIGRIDM\StoutController@ModalDept');
            });
        });

    });

    Route::prefix('/btas')->group(function () {
        /*Ryan*/
        Route::prefix('/monitoring')->group(function () {
            Route::prefix('/percus')->group(function () {
                //BARANG TITIPAN ATAS STRUK(BTAS)-MONITORING-PER CUSTOMER (IGR_SJAS_MON_CUST) (ryanOrder = 12)
                Route::get('/', 'BTAS\MONITORING\PerCusController@index');
                Route::post('/getdata', 'BTAS\MONITORING\PerCusController@GetData');
                Route::post('/sortcust', 'BTAS\MONITORING\PerCusController@SortCust');
                Route::post('/sorttgl', 'BTAS\MONITORING\PerCusController@SortTgl');
                Route::post('/getdetail', 'BTAS\MONITORING\PerCusController@GetDetail');
                Route::post('/checkdata', 'BTAS\MONITORING\PerCusController@CheckData');
                Route::get('/printdoc/{all}/{kodeMem}/{struk}', 'BTAS\MONITORING\PerCusController@printDocument');
            });

            Route::prefix('/peritem')->group(function () {
                //BARANG TITIPAN ATAS STRUK(BTAS)-MONITORING-PER ITEM (IGR_SJAS_MON_ITEM) (ryanOrder = 13)
                Route::get('/', 'BTAS\MONITORING\PerItemController@index');
                Route::post('/getdata', 'BTAS\MONITORING\PerItemController@GetData');
                Route::post('/sortdesc', 'BTAS\MONITORING\PerItemController@SortDesc');
                Route::post('/getdetail', 'BTAS\MONITORING\PerItemController@GetDetail');
                Route::post('/checkdata', 'BTAS\MONITORING\PerItemController@CheckData');
                Route::get('/printdoc', 'BTAS\MONITORING\PerItemController@printDocument');
            });
        });

        Route::prefix('/sjas')->group(function () {
            Route::get('/', 'BTAS\SJASController@index');
            Route::get('/get-lov-customer', 'BTAS\SJASController@getLovCustomer');
            Route::get('/get-data', 'BTAS\SJASController@getData');
            Route::get('/auth-user', 'BTAS\SJASController@authUser');
            Route::get('/check-print', 'BTAS\SJASController@checkPrint');
            Route::get('/print', 'BTAS\SJASController@print');
            Route::post('/save', 'BTAS\SJASController@save');
        });

        Route::prefix('/titip')->group(function () {
            Route::get('/', 'BTAS\TitipController@index');
            Route::get('/get-data', 'BTAS\TitipController@getData');
            Route::get('/process', 'BTAS\TitipController@process');
        });
    });

    Route::prefix('/tabel')->group(function () {

        /*Ryan*/
        Route::prefix('/hrgpromo')->group(function () {
            //Harga Promosi (IGR_TAB_HRGPROMO) (ryanOrder = 33)
            Route::get('/', 'TABEL\hrgpromoController@index');
            Route::get('/tabelmain', 'TABEL\hrgpromoController@ModalMain');
            Route::get('/modalplu', 'TABEL\hrgpromoController@ModalPlu');
            Route::get('/checkplu', 'TABEL\hrgpromoController@CheckPlu');
            Route::get('/print', 'TABEL\hrgpromoController@print');
        });
        /*Ryan*/
        Route::prefix('/superpromo')->group(function () {
            //SUPER Promosi (IGR_TAB_SUPERPROMO) (ryanOrder = 34)
            Route::get('/', 'TABEL\superpromoController@index');
            Route::get('/checkplu', 'TABEL\superpromoController@CheckPlu');
            Route::post('/save', 'TABEL\superpromoController@save');
        });
        /*Ryan*/
        Route::prefix('/byrvch')->group(function () {
            //Total Pembayaran Voucher (IGR_TAB_BYRVCH) (ryanOrder = 35)
            Route::get('/', 'TABEL\byrvchController@index');
            Route::get('/getsupp', 'TABEL\byrvchController@GetSupp');
            Route::get('/getsingkatan', 'TABEL\byrvchController@GetSingkatan');
            Route::get('/checkvoucher', 'TABEL\byrvchController@CheckVoucher');
        });

        /*Ryan*/
        Route::prefix('/hadiahtransaksi')->group(function () {
            Route::prefix('/hdhitem')->group(function () {
                //hadiah per item (IGR_TAB_HDHITEM) (ryanOrder = 31)
                Route::get('/', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhitemController@index');
                Route::get('/modalplu', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhitemController@ModalPlu');
                Route::get('/modalhadiah', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhitemController@ModalHadiah');
                Route::get('/modalhistory', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhitemController@ModalHistory');
                Route::get('/gethistory', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhitemController@GetHistory');
                Route::get('/checkplu', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhitemController@CheckPlu');
                Route::post('/save', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhitemController@SaveData');
            });

            Route::prefix('/hdhgab')->group(function () {
                //hadiah untuk gabungan item (IGR_TAB_HDHGAB) (ryanOrder = 32)
                Route::get('/', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@index');
                Route::get('/modalgabungan', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@ModalGabungan');
                Route::get('/modalhadiah', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@ModalHadiah');
                Route::get('/getdetail', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@GetDetail');
                Route::post('/getnew', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@GetNew');
                Route::get('/modalplu', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@ModalPlu');
                Route::get('/modalsupp', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@ModalSupp');
                Route::get('/checkplu', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@CheckPlu');
                Route::get('/choosemerk', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@ChooseMerk');
                Route::get('/choosesupplier', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@ChooseSupplier');
                Route::post('/save', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\hdhgabController@SaveData');
            });
        });

        /*Ryan*/
        //TABLE - Table Plu Timbangan (IGR_TAB_PLU_TMBNGN) (ryanOrder = 19)
        Route::prefix('/plutimbangan')->group(function () {
            Route::get('/', 'TABEL\PluTimbanganController@index');
            Route::get('/start', 'TABEL\PluTimbanganController@StartNew');
            Route::get('/plumodal', 'TABEL\PluTimbanganController@LovPlu');
            Route::get('/getplu', 'TABEL\PluTimbanganController@GetPlu');
            Route::get('/save', 'TABEL\PluTimbanganController@Save');
            //Route::get('/prehapus','TABEL\PluTimbanganController@preHapus');
            Route::get('/hapus', 'TABEL\PluTimbanganController@Hapus');
            Route::get('/kodemodal', 'TABEL\PluTimbanganController@LovKode');
            Route::get('/getkode', 'TABEL\PluTimbanganController@GetKode');
            Route::get('/checkS', 'TABEL\PluTimbanganController@ShareDir');
            Route::get('/checkdir', 'TABEL\PluTimbanganController@CheckDir');
            Route::get('/transfer', 'TABEL\PluTimbanganController@Transfer');
            Route::get('/print', 'TABEL\PluTimbanganController@Print');
            Route::get('/debug', 'TABEL\PluTimbanganController@Debug');
        });

        /*Leo*/
        Route::prefix('/plunoncharge')->group(function () {
            Route::get('/', 'TABEL\PLUNonChargeController@index');
            Route::get('/get-data', 'TABEL\PLUNonChargeController@getData');
            Route::get('/get-lov-plu', 'TABEL\PLUNonChargeController@getLovPLU');
            Route::get('/get-plu-detail', 'TABEL\PLUNonChargeController@getPLUDetail');
            Route::post('/add-plu', 'TABEL\PLUNonChargeController@addPLU');
            Route::post('/delete-plu', 'TABEL\PLUNonChargeController@deletePLU');
        });

        /*Leo*/
        Route::prefix('/plunonrefund')->group(function () {
            Route::get('/', 'TABEL\PLUNonRefundController@index');
            Route::get('/get-data', 'TABEL\PLUNonRefundController@getData');
            Route::get('/get-lov-plu', 'TABEL\PLUNonRefundController@getLovPLU');
            Route::get('/get-lov-divisi', 'TABEL\PLUNonRefundController@getLovDivisi');
            Route::get('/get-lov-departement', 'TABEL\PLUNonRefundController@getLovDepartement');
            Route::get('/get-lov-kategori', 'TABEL\PLUNonRefundController@getLovKategori');
            Route::get('/get-plu-detail', 'TABEL\PLUNonRefundController@getPLUDetail');
            Route::post('/add-plu', 'TABEL\PLUNonRefundController@addPLU');
            Route::post('/delete-plu', 'TABEL\PLUNonRefundController@deletePLU');
            Route::post('/add-batch', 'TABEL\PLUNonRefundController@addBatch');
            Route::post('/delete-batch', 'TABEL\PLUNonRefundController@deleteBatch');
        });

        /*Leo*/
        Route::prefix('/plunonpromo')->group(function () {
            Route::get('/', 'TABEL\PLUNonPromoController@index');
            Route::get('/get-data', 'TABEL\PLUNonPromoController@getData');
            Route::get('/get-lov-plu', 'TABEL\PLUNonPromoController@getLovPLU');
            Route::get('/get-lov-divisi', 'TABEL\PLUNonPromoController@getLovDivisi');
            Route::get('/get-lov-departement', 'TABEL\PLUNonPromoController@getLovDepartement');
            Route::get('/get-lov-kategori', 'TABEL\PLUNonPromoController@getLovKategori');
            Route::get('/get-plu-detail', 'TABEL\PLUNonPromoController@getPLUDetail');
            Route::post('/add-plu', 'TABEL\PLUNonPromoController@addPLU');
            Route::post('/delete-plu', 'TABEL\PLUNonPromoController@deletePLU');
            Route::post('/add-batch', 'TABEL\PLUNonPromoController@addBatch');
            Route::post('/delete-batch', 'TABEL\PLUNonPromoController@deleteBatch');
            Route::get('/print', 'TABEL\PLUNonPromoController@print');
        });

        /*Leo*/
        Route::prefix('/plu-voucher')->group(function () {
            Route::get('/', 'TABEL\PLUVoucherController@index');
            Route::get('/get-lov-voucher', 'TABEL\PLUVoucherController@getLovVoucher');
            Route::get('/get-lov-supplier', 'TABEL\PLUVoucherController@getLovSupplier');
            Route::get('/get-data', 'TABEL\PLUVoucherController@getData');
            Route::get('/get-data-plu-supplier', 'TABEL\PLUVoucherController@getDataPLUSupplier');
            Route::get('/get-supplier', 'TABEL\PLUVoucherController@getSupplier');
            Route::get('/get-plu', 'TABEL\PLUVoucherController@getPLU');
            Route::post('/save-data', 'TABEL\PLUVoucherController@saveData');
            Route::get('/get-list-supplier', 'TABEL\PLUVoucherController@getListSupplier');
        });

        /*Leo*/
        Route::prefix('/plu-mro')->group(function () {
            Route::get('/', 'TABEL\PLUMROController@index');
            Route::get('/get-data', 'TABEL\PLUMROController@getData');
            Route::get('/get-lov-divisi', 'TABEL\PLUMROController@getLovDivisi');
            Route::get('/get-lov-departement', 'TABEL\PLUMROController@getLovDepartement');
            Route::get('/get-lov-kategori', 'TABEL\PLUMROController@getLovKategori');
            Route::get('/get-lov-plu', 'TABEL\PLUMROController@getLovPLU');
            Route::get('/get-detail-and-insert', 'TABEL\PLUMROController@getDetailAndInsert');
            Route::post('/delete-data', 'TABEL\PLUMROController@deleteData');
            Route::get('/print', 'TABEL\PLUMROController@print');
        });

        /*Leo*/
        Route::prefix('/plu-mro-monitoring')->group(function () {
            Route::get('/', 'TABEL\PLUMROMonitoringController@index');
            Route::get('/get-lov-monitoring', 'TABEL\PLUMROMonitoringController@getLovMonitoring');
            Route::get('/get-monitoring', 'TABEL\PLUMROMonitoringController@getMonitoring');
            Route::get('/get-data', 'TABEL\PLUMROMonitoringController@getData');
            Route::get('/print', 'TABEL\PLUMROMonitoringController@print');
            Route::post('/delete-data', 'TABEL\PLUMROMonitoringController@deleteData');
        });

        /*Leo*/
        Route::prefix('/monitoring-produk')->group(function () {
            Route::get('/', 'TABEL\MonitoringProdukController@index');
            Route::get('/get-lov-monitoring', 'TABEL\MonitoringProdukController@getLovMonitoring');
            Route::get('/get-monitoring', 'TABEL\MonitoringProdukController@getMonitoring');
            Route::get('/get-lov-plu', 'TABEL\MonitoringProdukController@getLovPLU');
            Route::get('/get-data', 'TABEL\MonitoringProdukController@getData');
            Route::get('/print', 'TABEL\MonitoringProdukController@print');
        });

        //Denni
        Route::prefix('/max-pembelian-item-per-transaksi')->group(function () {
            Route::get('/', 'TABEL\MaxPembelianItemPerTransaksiController@index');
            Route::get('/modal-plu', 'TABEL\MaxPembelianItemPerTransaksiController@modalPlu');
            Route::get('/get-data-plu', 'TABEL\MaxPembelianItemPerTransaksiController@getDataPLU');
            Route::get('/get-data-table', 'TABEL\MaxPembelianItemPerTransaksiController@getDataTable');
            Route::get('/get-deskripsi', 'TABEL\MaxPembelianItemPerTransaksiController@getDeskripsi');
            Route::get('/cetak', 'TABEL\MaxPembelianItemPerTransaksiController@cetak');
            Route::post('/simpan', 'TABEL\MaxPembelianItemPerTransaksiController@simpan');
            Route::post('/hapus', 'TABEL\MaxPembelianItemPerTransaksiController@hapus');
        });

        //Denni
        Route::prefix('/pendaftaran-voucher-belanja')->group(function () {
            Route::get('/', 'TABEL\PendaftaranVoucherBelanjaController@index');
            Route::get('/modal-supplier', 'TABEL\PendaftaranVoucherBelanjaController@modalSupplier');
            Route::get('/get-data-supplier', 'TABEL\PendaftaranVoucherBelanjaController@getDataSupplier');
            Route::get('/get-data-table', 'TABEL\PendaftaranVoucherBelanjaController@getDataTable');
            Route::get('/get-deskripsi', 'TABEL\PendaftaranVoucherBelanjaController@getDeskripsi');
            Route::get('/cetak', 'TABEL\PendaftaranVoucherBelanjaController@cetak');
            Route::post('/simpan', 'TABEL\PendaftaranVoucherBelanjaController@simpan');
            Route::post('/hapus', 'TABEL\PendaftaranVoucherBelanjaController@hapus');
        });
    });

    Route::prefix('/administration')->group(function () {
        Route::prefix('/menu')->group(function () {
            Route::get('/', 'ADMINISTRATION\MenuController@index');
            Route::get('/get-data', 'ADMINISTRATION\MenuController@getData');
            Route::post('/add', 'ADMINISTRATION\MenuController@add');
            Route::post('/edit', 'ADMINISTRATION\MenuController@edit');
            Route::post('/delete', 'ADMINISTRATION\MenuController@delete');
        });

        Route::prefix('/access')->group(function () {
            Route::get('/', 'ADMINISTRATION\AccessController@index');
            Route::get('/get-lov-user', 'ADMINISTRATION\AccessController@getLovUser');
            Route::get('/get-data', 'ADMINISTRATION\AccessController@getData');
            Route::get('/save', 'ADMINISTRATION\AccessController@save');
            Route::get('/clone', 'ADMINISTRATION\AccessController@clone');
        });

        Route::prefix('/user')->group(function () {
            Route::get('/', 'ADMINISTRATION\userController@index');
            Route::post('/searchUser', 'ADMINISTRATION\userController@searchUser');
            Route::post('/searchIp', 'ADMINISTRATION\userController@searchIp');
            Route::post('/saveUser', 'ADMINISTRATION\userController@saveUser');
            Route::post('/updateUser', 'ADMINISTRATION\userController@updateUser');
            Route::post('/userAccess', 'ADMINISTRATION\userController@userAccess');
            Route::post('/saveAccess', 'ADMINISTRATION\userController@saveAccess');
            Route::post('/saveIp', 'ADMINISTRATION\userController@saveIp');
            Route::post('/updateIp', 'ADMINISTRATION\userController@updateIp');
        });

        Route::prefix('/dev')->group(function () {
            Route::get('/', 'ADMINISTRATION\DevController@index');
            Route::get('/get-data', 'ADMINISTRATION\DevController@getData');
            Route::get('/save', 'ADMINISTRATION\DevController@save');
        });
    });

    Route::prefix('/fo')->group(function () {
        Route::prefix('/laporan-kasir')->group(function () {
            /*  Jefri */
            Route::prefix('/laporan-pareto-sales-by-member')->group(function () {
                Route::get('/',                 'FRONTOFFICE\LAPORANKASIR\paretoSalesMemberController@index')->middleware('CheckLogin');
                Route::get('/get-lov-member',   'FRONTOFFICE\LAPORANKASIR\paretoSalesMemberController@getLovMember')->middleware('CheckLogin');
                Route::get('/cetak-laporan',    'FRONTOFFICE\LAPORANKASIR\paretoSalesMemberController@cetakLaporan')->middleware('CheckLogin');
            });

            Route::prefix('/actual')->group(function () {
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\ActualController@index');
                Route::get('/cetak', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetak');
                Route::get('/cetak-sales', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakSales');
                Route::get('/cetak-isaku', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakIsaku');
                Route::get('/cetak-virtual', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakVirtual');
                Route::get('/cetak-cb-nk', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakCbNk');
                Route::get('/cetak-transfer', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakTransfer');
                Route::get('/cetak-plastik', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakPlastik');
                Route::get('/cetak-merchant', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakMerchant');
                Route::get('/cetak-kredit', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakKredit');
                Route::get('/cetak-omi', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakOmi');
                Route::get('/cetak-struk', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakStruk');
            });

            Route::prefix('/kartu-kredit')->group(function () {
                Route::prefix('/per-nama')->group(function () {
                    Route::get('/', 'FRONTOFFICE\LAPORANKASIR\KARTUKREDIT\KKPerNamaController@index');
                    Route::get('/cetak', 'FRONTOFFICE\LAPORANKASIR\KARTUKREDIT\KKPerNamaController@cetak');
                });

                Route::prefix('/per-kasir')->group(function () {
                    Route::get('/', 'FRONTOFFICE\LAPORANKASIR\KARTUKREDIT\KKPerKasirController@index');
                    Route::get('/get-lov', 'FRONTOFFICE\LAPORANKASIR\KARTUKREDIT\KKPerKasirController@getLov');
                    Route::get('/cetak', 'FRONTOFFICE\LAPORANKASIR\KARTUKREDIT\KKPerKasirController@cetak');
                });

                Route::prefix('/per-debit-ukm')->group(function () {
                    Route::get('/', 'FRONTOFFICE\LAPORANKASIR\KARTUKREDIT\KKPerDebitUKMController@index');
                    Route::get('/get-lov', 'FRONTOFFICE\LAPORANKASIR\KARTUKREDIT\KKPerDebitUKMController@getLov');
                    Route::get('/cetak', 'FRONTOFFICE\LAPORANKASIR\KARTUKREDIT\KKPerDebitUKMController@cetak');
                });
            });

            Route::prefix('/rekap-evaluasi')->group(function () {
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@index');
                Route::get('/get-lov-langganan', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@getLovLangganan');
                Route::get('/check-langganan', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@checkLangganan');
                Route::get('/get-lov-outlet', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@getLovOutlet');
                Route::get('/check-outlet', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@checkOutlet');
                Route::get('/get-lov-suboutlet', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@getLovSubOutlet');
                Route::get('/check-suboutlet', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@checkSubOutlet');
                Route::get('/get-lov-monitoring', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@getLovSubOutlet');
                Route::get('/print-detail', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@printDetail');
                Route::get('/print-rekap', 'FRONTOFFICE\LAPORANKASIR\RekapEvaluasiController@printRekap');
            });

            Route::prefix('/transaksi-per-nilai-struk')->group(function () {
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\TransaksiPerNilaiStrukController@index');
                Route::get('/cetak', 'FRONTOFFICE\LAPORANKASIR\TransaksiPerNilaiStrukController@cetak');
            });

            /*Ryan*/
            Route::prefix('/cei')->group(function () {
                //FRONTOFFICE - LAPORANKASIR - LAPORAN CASH BACK / EVENT / ITEM (ryanOrder = 16)
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\ceiController@index');
                Route::post('/checkdata', 'FRONTOFFICE\LAPORANKASIR\ceiController@CheckData');
                Route::get('/printdoc/{date1}/{date2}/{event1}/{event2}', 'FRONTOFFICE\LAPORANKASIR\ceiController@printDocument');
            });
            /*Ryan*/
            Route::prefix('/csi')->group(function () {
                //FRONTOFFICE - LAPORANKASIR - LAPORAN CASH BACK / SUPPLIER / ITEM (ryanOrder = 15)
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\csiController@index');
                Route::post('/getnmr', 'FRONTOFFICE\LAPORANKASIR\csiController@getNmr');
                Route::post('/checkdata', 'FRONTOFFICE\LAPORANKASIR\csiController@CheckData');
                Route::get('/printdoc/{date1}/{date2}/{p_tipe}/{sup1}/{sup2}', 'FRONTOFFICE\LAPORANKASIR\csiController@printDocument');

                Route::post('/checkdatak', 'FRONTOFFICE\LAPORANKASIR\csiController@CheckDataK');
                Route::get('/printdock/{date1}/{date2}/{p_tipe}/{sup1}/{sup2}', 'FRONTOFFICE\LAPORANKASIR\csiController@printDocumentK');

                Route::post('/checkdatar', 'FRONTOFFICE\LAPORANKASIR\csiController@CheckDataR');
                Route::get('/printdocr/{date1}/{date2}/{p_tipe}/{sup1}/{sup2}', 'FRONTOFFICE\LAPORANKASIR\csiController@printDocumentR');

                Route::get('/getmodal', 'FRONTOFFICE\LAPORANKASIR\csiController@getModal');
            });
            /*Ryan*/
            Route::prefix('/rkprefundksr')->group(function () {
                //FRONTOFFICE - LAPORAN KASIR - REKAP REFUND KASIR (ryanOrder = 23)
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\rkprefundksrController@index');
                Route::get('/print', 'FRONTOFFICE\LAPORANKASIR\rkprefundksrController@print');
            });
            /*Ryan*/
            Route::prefix('/strukperkasir')->group(function () {
                //FRONTOFFICE - LAPORAN KASIR - LAPORAN STRUK PER KASIR (ryanOrder = 21)
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\strukperkasirController@index');
                Route::get('/printstruk', 'FRONTOFFICE\LAPORANKASIR\strukperkasirController@printstruk');
                Route::get('/printwaktu', 'FRONTOFFICE\LAPORANKASIR\strukperkasirController@printwaktu');
            });
            /*Ryan*/
            Route::prefix('/transaksivoucher')->group(function () {
                //FRONTOFFICE - LAPORAN KASIR - TRANSAKSI VOUCHER (ryanOrder = 22)
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\transaksivoucherController@index');
                Route::get('/print', 'FRONTOFFICE\LAPORANKASIR\transaksivoucherController@print');
            });
            /*Ryan*/
            Route::prefix('/penjualan')->group(function () {
                //FRONTOFFICE - LAPORAN KASIR - LAPORAN PENJUALAN (ryanOrder = 20)
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\penjualanController@index');
                Route::get('/getdiv', 'FRONTOFFICE\LAPORANKASIR\penjualanController@getDiv');
                Route::get('/getdept', 'FRONTOFFICE\LAPORANKASIR\penjualanController@getDept');
                Route::get('/gettoko', 'FRONTOFFICE\LAPORANKASIR\penjualanController@getToko');
                Route::get('/getkat', 'FRONTOFFICE\LAPORANKASIR\penjualanController@getKat');
                Route::get('/getmon', 'FRONTOFFICE\LAPORANKASIR\penjualanController@getMon');
                Route::get('/printdocumentmenu1', 'FRONTOFFICE\LAPORANKASIR\penjualanController@printDocumentMenu1');
                Route::get('/printdocumentmenu2', 'FRONTOFFICE\LAPORANKASIR\penjualanController@printDocumentMenu2');
                Route::get('/printdocumentdmenu2', 'FRONTOFFICE\LAPORANKASIR\penjualanController@printDocumentDMenu2');
                Route::get('/printdocumentcmenu2', 'FRONTOFFICE\LAPORANKASIR\penjualanController@printDocumentCMenu2');
                Route::get('/printdocumentmenu3', 'FRONTOFFICE\LAPORANKASIR\penjualanController@printDocumentMenu3');
                Route::get('/printdocumentmenu4', 'FRONTOFFICE\LAPORANKASIR\penjualanController@printDocumentMenu4');
                Route::get('/printdocumentmenu5', 'FRONTOFFICE\LAPORANKASIR\penjualanController@printDocumentMenu5');
            });
        });

        Route::prefix('/laporan-planogram')->group(function () {
            Route::get('/', 'FRONTOFFICE\LaporanPlanogramController@index');
            Route::get('/cetak', 'FRONTOFFICE\LaporanPlanogramController@cetak');
            Route::get('/lovkoderak', 'FRONTOFFICE\LaporanPlanogramController@lovKodeRak');
        });
        Route::prefix('/lokasi-sewa-gondola')->group(function () {
            Route::get('/', 'FRONTOFFICE\LokasiSewaGondolaController@index');
            Route::get('/lovnopjsewa', 'FRONTOFFICE\LokasiSewaGondolaController@lovNoPjSewa');
            Route::get('/lovkoderak', 'FRONTOFFICE\LokasiSewaGondolaController@lovKodeRak');
            Route::get('/lovlokasi', 'FRONTOFFICE\LokasiSewaGondolaController@lovLokasi');
            Route::get('/lovplu', 'FRONTOFFICE\LokasiSewaGondolaController@lovPLU');
            Route::get('/getdatanopjsewa', 'FRONTOFFICE\LokasiSewaGondolaController@getDataNoPjSewa');
            Route::get('/getdatalokasi', 'FRONTOFFICE\LokasiSewaGondolaController@getDataLokasi');
            Route::post('/simpanperjanjiansewa', 'FRONTOFFICE\LokasiSewaGondolaController@simpanNoPerjanjianSewa');
            Route::get('/getdatalokasi', 'FRONTOFFICE\LokasiSewaGondolaController@getDataLokasi');
            Route::get('/getdatalokasi2', 'FRONTOFFICE\LokasiSewaGondolaController@getDataLokasi2');
            Route::get('/lovpluprjsewa', 'FRONTOFFICE\LokasiSewaGondolaController@lovPLUPrjSewa');
            Route::post('/simpan2', 'FRONTOFFICE\LokasiSewaGondolaController@simpan2');
        });
        Route::prefix('/point-reward-member-merah')->group(function () {
            Route::prefix('/perolehan-point-reward-per-tanggal')->group(function () {
                Route::get('/', 'FRONTOFFICE\POINTREWARDMEMBERMERAH\PerolehanPointRewardPerTanggal@index');
                Route::get('/cetak', 'FRONTOFFICE\POINTREWARDMEMBERMERAH\PerolehanPointRewardPerTanggal@cetak');
            });
            Route::prefix('/penggunaan-point-reward-per-tanggal')->group(function () {
                Route::get('/', 'FRONTOFFICE\POINTREWARDMEMBERMERAH\PenggunaanPointRewardPerTanggal@index');
                Route::get('/cetak', 'FRONTOFFICE\POINTREWARDMEMBERMERAH\PenggunaanPointRewardPerTanggal@cetak');
            });
            Route::prefix('/rekapitulasi-mutasi-point-reward')->group(function () {
                Route::get('/', 'FRONTOFFICE\POINTREWARDMEMBERMERAH\RekapitulasiMutasiPointReward@index');
                Route::get('/urutkan', 'FRONTOFFICE\POINTREWARDMEMBERMERAH\RekapitulasiMutasiPointReward@urutkan');
                Route::get('/lovmember', 'FRONTOFFICE\POINTREWARDMEMBERMERAH\RekapitulasiMutasiPointReward@lovMember');
                Route::get('/cetak', 'FRONTOFFICE\POINTREWARDMEMBERMERAH\RekapitulasiMutasiPointReward@cetak');
            });
        });
        Route::prefix('/cetak-laporan-promosi')->group(function () {
            Route::get('/', 'FRONTOFFICE\CetakLaporanPromosiController@index');
            Route::get('/cetak', 'FRONTOFFICE\CetakLaporanPromosiController@cetak');
            Route::get('/lovkoderak', 'FRONTOFFICE\CetakLaporanPromosiController@lovKodeRak');
            Route::get('/lovkodepromosi', 'FRONTOFFICE\CetakLaporanPromosiController@lovKodePromosi');
        });
        Route::prefix('/laporan-percetakan-faktur-pajak-standar')->group(function () {
            Route::get('/', 'FRONTOFFICE\LaporanPercetakanFakturPajakStandarController@index');
            Route::get('/cetak-pkp', 'FRONTOFFICE\LaporanPercetakanFakturPajakStandarController@cetakPKP');
            Route::get('/cetak-mm-non-pkp', 'FRONTOFFICE\LaporanPercetakanFakturPajakStandarController@cetakMMNonPKP');
            Route::get('/cetak-omi-non-pkp', 'FRONTOFFICE\LaporanPercetakanFakturPajakStandarController@cetakOMINonPKP');
            Route::get('/cetak-tmi-non-pkp', 'FRONTOFFICE\LaporanPercetakanFakturPajakStandarController@cetakTMINonPKP');
            Route::get('/cetak-freepass-klik-igr', 'FRONTOFFICE\LaporanPercetakanFakturPajakStandarController@cetakFreepassKlikIgr');
        });

        /*Ryan*/
        Route::prefix('/promosihokecab')->group(function () {
            //FRONTOFFICE - PROMOSI HO KE CABANG (IGR_FO_PROMOSIHOKECAB) (ryanOrder = 14)
            Route::get('/', 'FRONTOFFICE\PromosiHoKeCabController@index');
            Route::post('/downbaru', 'FRONTOFFICE\PromosiHoKeCabController@DownBaru');
            Route::post('/downedit', 'FRONTOFFICE\PromosiHoKeCabController@DownEdit');
        });
        /*Ryan*/
        Route::prefix('/formHJK')->group(function () {
            //FRONTOFFICE - FORM HARGA JUAL KHUSUS (ryanOrder = 17)
            Route::get('/', 'FRONTOFFICE\formHJKController@index');
            Route::post('/getplu', 'FRONTOFFICE\formHJKController@GetPlu');
            Route::post('/chooseplu', 'FRONTOFFICE\formHJKController@ChoosePlu');
            Route::post('/calculatemargin', 'FRONTOFFICE\formHJKController@CalculateMargin');
            Route::get('/printdocument', 'FRONTOFFICE\formHJKController@printDocument');

            Route::get('/datamodal', 'FRONTOFFICE\formHJKController@dataModal');
        });
        /*Ryan*/
        Route::prefix('/amp')->group(function () {
            //FRONTOFFICE - Approval Member Platinum (IGR_FO_SEGMENTASIAPPR) (ryanOrder = 18)
            Route::get('/', 'FRONTOFFICE\ampController@index');
            Route::post('/getdata', 'FRONTOFFICE\ampController@GetData');
            Route::post('/updatedata', 'FRONTOFFICE\ampController@UpdateData');
            Route::post('/updatedata2', 'FRONTOFFICE\ampController@UpdateData2');
            Route::post('/updatedata3', 'FRONTOFFICE\ampController@UpdateData3');
            Route::post('/updatedata4', 'FRONTOFFICE\ampController@UpdateData4');
        });
        /*Ryan*/
        Route::prefix('/uniquecode')->group(function () {
            //IGR_FO_UNIQUECODE (ryanOrder = 25)
            Route::get('/', 'FRONTOFFICE\uniquecodeController@index');
            Route::get('/getcashback', 'FRONTOFFICE\uniquecodeController@getCashBack');
            Route::get('/getgift', 'FRONTOFFICE\uniquecodeController@getGift');
            Route::get('/getpembanding', 'FRONTOFFICE\uniquecodeController@getPembanding');
            Route::get('/cetak', 'FRONTOFFICE\uniquecodeController@cetak');
        });
        /*Ryan*/
        Route::prefix('/spbmanual')->group(function () {
            //FRONTOFFICE - LAPORAN KASIR - SPB MANUAL (ryanOrder = 24)
            Route::get('/', 'FRONTOFFICE\spbmanualController@index');
            Route::get('/getplu', 'FRONTOFFICE\spbmanualController@getPlu');
            Route::get('/chooseplu', 'FRONTOFFICE\spbmanualController@choosePlu');
            Route::get('/checkrak', 'FRONTOFFICE\spbmanualController@checkRak');
            Route::get('/getrak', 'FRONTOFFICE\spbmanualController@getRak');
            Route::get('/getrak2', 'FRONTOFFICE\spbmanualController@getRak2');
            Route::get('/getrakantrian', 'FRONTOFFICE\spbmanualController@getRakAntrian');
            Route::get('/save', 'FRONTOFFICE\spbmanualController@save');
        });
    });

    Route::prefix('/omi')->group(function () {
        Route::prefix('/transfer-order-dari-omi-idm')->group(function () {
            Route::prefix('/kredit-limit-dan-monitoring-pb-omi')->group(function () {
                Route::get('/', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@index');
                Route::get('/get-lov-kode-omi', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getLovKodeOMI');
                Route::post('/get-data-omi', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getDataOMI');
                Route::get('/get-data-master-kredit-limit-omi', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getDataMasterKreditLimitOMI');
                Route::get('/get-monitoring-data-pb-tolakan', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getMonitoringDataPBTolakan');
                Route::post('/get-data-top', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getDataTop');
                Route::post('/simpan', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@simpan');
            });
        });

        Route::prefix('/retur')->group(function () {
            Route::get('/', 'OMI\ReturController@index');
            Route::get('/get-lov-nodoc', 'OMI\ReturController@getLovNodoc');
            Route::get('/get-lov-member', 'OMI\ReturController@getLovMember');
            Route::get('/get-data', 'OMI\ReturController@getData');
            Route::get('/get-new-nodoc', 'OMI\ReturController@getNewNodoc');
            Route::get('/check-member', 'OMI\ReturController@checkMember');
            Route::get('/check-pkp', 'OMI\ReturController@checkPKP');
            Route::get('/check-nrb', 'OMI\ReturController@checkNRB');
            Route::post('/delete-data', 'OMI\ReturController@deleteData');
            Route::get('/get-prdcd', 'OMI\ReturController@getPRDCD');
            Route::post('/save-data', 'OMI\ReturController@saveData');
            Route::get('/print', 'OMI\ReturController@print');
            Route::get('/print-bpb', 'OMI\ReturController@printBPB');
            Route::get('/print-nota-barang-retur', 'OMI\ReturController@printNotaBarangRetur');
            Route::get('/print-nota-barang-rusak', 'OMI\ReturController@printNotaBarangRusak');
            Route::get('/print-listing', 'OMI\ReturController@printListing');
            Route::get('/print-listing-manual', 'OMI\ReturController@printListingManual');
            Route::get('/print-bpb-manual', 'OMI\ReturController@printBPBManual');
            Route::get('/print-selisih', 'OMI\ReturController@printSelisih');
            Route::get('/print-struk', 'OMI\ReturController@printStruk');
            Route::get('/print-reset', 'OMI\ReturController@printReset');
            Route::get('/create-faktur-check', 'OMI\ReturController@createFakturCheck');
            Route::get('/create-faktur', 'OMI\ReturController@createFaktur');
            Route::post('/transfer-file-r', 'OMI\ReturController@transferFileR');
        });

        Route::prefix('/free-plu-omi-kepala-9')->group(function () {
            Route::get('/', 'OMI\FreePLUOMIKepala9Controller@index');
            Route::get('/get-lov-plu', 'OMI\FreePLUOMIKepala9Controller@getLovPLU');
            Route::get('/get-data-input', 'OMI\FreePLUOMIKepala9Controller@getDataInput');
            Route::get('/get-datatable', 'OMI\FreePLUOMIKepala9Controller@getDatatable');
            Route::post('/simpan', 'OMI\FreePLUOMIKepala9Controller@simpan');
            Route::post('/hapus', 'OMI\FreePLUOMIKepala9Controller@hapus');
        });

        Route::prefix('/entry-group-rak')->group(function () {
            Route::get('/', 'OMI\EntryGroupRakController@index');
            Route::get('/get-data-header', 'OMI\EntryGroupRakController@getDataHeader');
            Route::get('/get-data-detail', 'OMI\EntryGroupRakController@getDataDetail');
            Route::post('/simpan-header', 'OMI\EntryGroupRakController@simpanHeader');
            Route::post('/simpan-detail', 'OMI\EntryGroupRakController@simpanDetail');
            Route::post('/hapus-detail', 'OMI\EntryGroupRakController@hapusDetail');
        });

        Route::prefix('/laporan')->group(function () {
            Route::prefix('/register-ppr')->group(function () {
                Route::get('/', 'OMI\Laporan\LaporanRegisterPPRController@index');
                Route::get('/lov-nodoc', 'OMI\Laporan\LaporanRegisterPPRController@lovNodoc');
                Route::get('/cetak', 'OMI\Laporan\LaporanRegisterPPRController@cetak');
            });
            Route::prefix('/rekapitulasi-register-ppr')->group(function () {
                Route::get('/', 'OMI\Laporan\LaporanRekapitulasiRegisterPPRController@index');
                Route::get('/lov-nodoc', 'OMI\Laporan\LaporanRekapitulasiRegisterPPRController@lovNodoc');
                Route::get('/lov-member', 'OMI\Laporan\LaporanRekapitulasiRegisterPPRController@lovMember');
                Route::get('/cetak', 'OMI\Laporan\LaporanRekapitulasiRegisterPPRController@cetak');
            });

            /*Ryan*/
            Route::prefix('/laplvlpb')->group(function () {
                //IGR_OMI_LAPLVLPB (ryanOrder = 27)
                Route::get('/', 'OMI\LAPORAN\laplvlpbController@index');
                Route::get('/getpb', 'OMI\LAPORAN\laplvlpbController@pbModal');
                Route::get('/cetak', 'OMI\LAPORAN\laplvlpbController@cetak');
            });
            /*Ryan*/
            Route::prefix('/monitem_tdk_supply')->group(function () {
                //MONITORING ITEM TIDAK TERSUPPLY (ryanOrder = 28)
                Route::get('/', 'OMI\LAPORAN\monitem_tdk_supplyController@index');
                Route::get('/getmon', 'OMI\LAPORAN\monitem_tdk_supplyController@monModal');
                Route::get('/prosesdata', 'OMI\LAPORAN\monitem_tdk_supplyController@fillTable');
                Route::get('/showdata', 'OMI\LAPORAN\monitem_tdk_supplyController@getTable');
                Route::get('/checkdata', 'OMI\LAPORAN\monitem_tdk_supplyController@checkData');
                Route::get('/cetak', 'OMI\LAPORAN\monitem_tdk_supplyController@cetak');
            });
            /*Ryan*/
            Route::prefix('/lapregbrgrtr')->group(function () {
                //LAPORAN REGISTER BARANG RETUR (ryanOrder = 28)
                Route::get('/', 'OMI\LAPORAN\lapregbrgrtrController@index');
                Route::get('/cetak', 'OMI\LAPORAN\lapregbrgrtrController@cetak');
            });
            /*Ryan*/
            Route::prefix('/laprincislvpb')->group(function () {
                //LAPORAN RINCI SLV PB (ryanOrder = 29)
                Route::get('/', 'OMI\LAPORAN\laprincislvpbController@index');
                Route::get('/gettag', 'OMI\LAPORAN\laprincislvpbController@tagModal');
                Route::get('/cetak', 'OMI\LAPORAN\laprincislvpbController@cetak');
            });
            /*Ryan*/
            Route::prefix('/lapsvlslspb')->group(function () {
                //LAPORAN SVL SLS PB (ryanOrder = 30)
                Route::get('/', 'OMI\LAPORAN\lapsvlslspbController@index');
                Route::get('/getpb', 'OMI\LAPORAN\lapsvlslspbController@pbModal');
                Route::get('/cetak', 'OMI\LAPORAN\lapsvlslspbController@cetak');
            });
        });
        /*Ryan*/
        Route::prefix('/rubahstatusomi')->group(function () {
            //IGR_BO_RUBAHSTATUSOMI (ryanOrder = 26)
            Route::get('/', 'OMI\rubahstatusomiController@index');
            Route::get('/newforminstance', 'OMI\rubahstatusomiController@newFormInstance');
            Route::get('/modalptkp', 'OMI\rubahstatusomiController@modalPTKP');
            Route::get('/chooseptkp', 'OMI\rubahstatusomiController@choosePTKP');
            Route::get('/modalpkp', 'OMI\rubahstatusomiController@modalPKP');
            Route::get('/choosepkp', 'OMI\rubahstatusomiController@choosePKP');
            Route::get('/prosesdata', 'OMI\rubahstatusomiController@prosesData');
            Route::get('/cetak', 'OMI\rubahstatusomiController@cetak');
        });
    });

    /*Ryan*/
    //BACKOFFICE-RESTORE (BELUM DINAVBAR) (Sepertinya Restore Data Month End Sudah ada) (ryanOrder = 5)
    Route::get('restore/index', 'BACKOFFICE\restoreController@index');
    Route::post('restore/restorenow', 'BACKOFFICE\restoreController@restoreNow');
});


