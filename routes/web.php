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

Route::get('/test', 'TestController@menu');

Route::get('/testnewnav', function () {
    //    $pub = public_path('\DBF\BLMN02E1.DBF');
    //    dd($pub);


    $files = \Illuminate\Support\Facades\File::files(public_path() . '\DBF');

    // If you would like to retrieve a list of
    // all files within a given directory including all sub-directories
    $files = \Illuminate\Support\Facades\File::allFiles(public_path() . '\DBF');
    dd($files);

    return view('welcome');
});

Route::get('/login', 'Auth\loginController@index');
Route::get('/logout', 'Auth\loginController@logout');
Route::get('/logout-access', 'Auth\loginController@logoutAccess');
Route::get('/unauthorized', 'Auth\loginController@unauthorized');

Route::post('/login/', 'Auth\loginController@login');
Route::post('/login/insertip', 'Auth\loginController@insertip');

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
//Route::get('/bomaxpalet', 'BACKOFFICE\maxpaletUntukPBController@index')->middleware('CheckLogin');
//Route::post('/bomaxpalet/loaddata', 'BACKOFFICE\maxpaletUntukPBController@loadData')->middleware('CheckLogin');
//Route::post('/bomaxpalet/getmaxpalet', 'BACKOFFICE\maxpaletUntukPBController@getMaxPalet')->middleware('CheckLogin');
//Route::post('/bomaxpalet/savedata', 'BACKOFFICE\maxpaletUntukPBController@saveData')->middleware('CheckLogin');
//Route::post('/bomaxpalet/deletedata', 'BACKOFFICE\maxpaletUntukPBController@deleteData')->middleware('CheckLogin');

//BACKOFFICE_UTILITY_PB_IGR
//Route::get('/boutilitypbigr', 'BACKOFFICE\utilityPBIGRController@index')->middleware('CheckLogin');
//Route::post('/boutilitypbigr/callproc1', 'BACKOFFICE\utilityPBIGRController@callProc1')->middleware('CheckLogin');
//Route::post('/boutilitypbigr/callproc2', 'BACKOFFICE\utilityPBIGRController@callProc2')->middleware('CheckLogin');
//Route::post('/boutilitypbigr/callproc3', 'BACKOFFICE\utilityPBIGRController@callProc3')->middleware('CheckLogin');
//Route::post('/boutilitypbigr/chekproc4', 'BACKOFFICE\utilityPBIGRController@checkProc4')->middleware('CheckLogin');
//Route::get('/boutilitypbigr/callproc4/{date}', 'BACKOFFICE\utilityPBIGRController@callProc4')->middleware('CheckLogin');
//Route::get('/boutilitypbigr/test', function () {
//    return view('BACKOFFICE.utilityPBIGR-laporan');
//});

//BACKOFFICE_PB_OTOMATIS
//Route::get('/bopbotomatis/index',                                             'BACKOFFICE\PBOtomatisController@cetakReport')->middleware('CheckLogin');
//Route::get('/bopbotomatis/index', 'BACKOFFICE\PBOtomatisController@index')->middleware('CheckLogin');
//Route::get('/bopbotomatis/getdatamodalsupplier', 'BACKOFFICE\PBOtomatisController@getDataModalSupplier')->middleware('CheckLogin');
//Route::get('/bopbotomatis/getkategori', 'BACKOFFICE\PBOtomatisController@getKategori')->middleware('CheckLogin');
//Route::post('/bopbotomatis/prosesdata', 'BACKOFFICE\PBOtomatisController@prosesData')->middleware('CheckLogin');
//Route::get('/bopbotomatis/cetakreport/{kodeigr}/{date1}/{date2}/{sup1}/{sup2}', 'BACKOFFICE\PBOtomatisController@cetakReport');


//BACKOFFICE_CETAK_PB
//Route::get('/bocetakpb/index', 'BACKOFFICE\cetakPBController@index')->middleware('CheckLogin');
//Route::get('/bocetakpb/getdocument', 'BACKOFFICE\cetakPBController@getDocument')->middleware('CheckLogin');
////Route::post('/bocetakpb/getdocument', 'BACKOFFICE\cetakPBController@getDocument')->middleware('CheckLogin');
//Route::post('/bocetakpb/searchdocument', 'BACKOFFICE\cetakPBController@searchDocument')->middleware('CheckLogin');
//Route::post('/bocetakpb/getdivisi', 'BACKOFFICE\cetakPBController@getDivisi')->middleware('CheckLogin');
//Route::post('/bocetakpb/searchdivisi', 'BACKOFFICE\cetakPBController@searchDivisi')->middleware('CheckLogin');
//Route::get('/bocetakpb/getdepartement', 'BACKOFFICE\cetakPBController@getDepartement')->middleware('CheckLogin');
////Route::post('/bocetakpb/getdepartement', 'BACKOFFICE\cetakPBController@getDepartement')->middleware('CheckLogin');
//Route::post('/bocetakpb/searchdepartement', 'BACKOFFICE\cetakPBController@searchDepartement')->middleware('CheckLogin');
//Route::get('/bocetakpb/getkategori', 'BACKOFFICE\cetakPBController@getKategori')->middleware('CheckLogin');
////Route::post('/bocetakpb/getkategori', 'BACKOFFICE\cetakPBController@getKategori')->middleware('CheckLogin');
//Route::post('/bocetakpb/searchkategori', 'BACKOFFICE\cetakPBController@searchKategori')->middleware('CheckLogin');
//Route::get('/bocetakpb/cetakreport/{tgl1}/{tgl2}/{doc1}/{doc2}/{div1}/{div2}/{dept1}/{dept2}/{kat1}/{kat2}/{tipePB}', 'BACKOFFICE\cetakPBController@cetakReport')->middleware('CheckLogin');


//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-BARANGRUSAK
//Route::get('/bo/transaksi/pemusnahan/brgrusak/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@index')->middleware('CheckLogin');
//Route::get('/bo/transaksi/pemusnahan/brgrusak/getnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNmrTrn')->middleware('CheckLogin');
////Route::post('/bo/transaksi/pemusnahan/brgrusak/getnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNmrTrn')->middleware('CheckLogin');
//Route::get('/bo/transaksi/pemusnahan/brgrusak/getplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getPlu')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/brgrusak/choosetrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@chooseTrn')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/brgrusak/getnewnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNewNmrTrn')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/brgrusak/chooseplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@choosePlu')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/brgrusak/savedata', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@saveData')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/brgrusak/deletedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@deleteDocument')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/brgrusak/showall', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@showAll')->middleware('CheckLogin');
//Route::get('/bo/transaksi/pemusnahan/brgrusak/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@printDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-BERITA_ACARA_PEMUSNAHAN
//Route::get('/bo/transaksi/pemusnahan/bapemusnahan/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@index')->middleware('CheckLogin');
//Route::get('/bo/transaksi/pemusnahan/bapemusnahan/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNoDocument')->middleware('CheckLogin');
//Route::get('/bo/transaksi/pemusnahan/bapemusnahan/getnopbbr', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNoPBBR')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/bapemusnahan/choosedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@chooseNoDocument')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/bapemusnahan/choosepbbr', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@choosePBBR')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/bapemusnahan/getnewnmrdoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNewNmrDoc')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/bapemusnahan/savedata', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@saveData')->middleware('CheckLogin');
//Route::get('/bo/transaksi/pemusnahan/bapemusnahan/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@printDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-PEMBATALAN_BA_PEMUSNAHAN
//Route::get('/bo/transaksi/pemusnahan/bapbatal/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@index')->middleware('CheckLogin');
//Route::get('/bo/transaksi/pemusnahan/bapbatal/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@getDocument')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/bapbatal/getdetaildoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@getDetailDocument')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/bapbatal/deletedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@deleteDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-INQUERY_BA_PEMUSNAHAN
//Route::get('/bo/transaksi/pemusnahan/inquerybapb/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@index')->middleware('CheckLogin');
//Route::get('/bo/transaksi/pemusnahan/inquerybapb/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@getDocument')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/inquerybapb/getdetaildoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@getDetailDocument')->middleware('CheckLogin');
//Route::post('/bo/transaksi/pemusnahan/inquerybapb/detailplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@detailPlu')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PENERIMAAN-INPUT
//Route::get('/bo/transaksi/penerimaan/input/', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@index')->middleware('CheckLogin');
//Route::get('/bo/transaksi/penerimaan/input/showbtb/{tipetrn}', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showBTB')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/choosebtb', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@chooseBTB')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/getnewnobtb', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@getNewNoBTB')->middleware('CheckLogin');
//Route::get('/bo/transaksi/penerimaan/input/showpo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showPO')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/choosepo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@choosePO')->middleware('CheckLogin');
//Route::get('/bo/transaksi/penerimaan/input/showsupplier', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showSupplier')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/showplu', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showPlu')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/chooseplu', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@choosePlu')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/changehargabeli', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeHargaBeli')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/changeqty', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeQty')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/changebonus1', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeBonus1')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/changerphdisc', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeRphDisc')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/rekamdata', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@rekamData')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/transferpo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@transferPO')->middleware('CheckLogin');
//Route::post('/bo/transaksi/penerimaan/input/savedata', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@saveData')->middleware('CheckLogin');

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
Route::get('/bo/transaksi/penerimaan/printbpb/viewreport/{reprint}/{report}/{noDoc}/{ttd}', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@viewReport')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/printbpb/viewreport/cetakLokasi', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@viewReport')->middleware('CheckLogin');

//SIGNATURE
Route::prefix('/bo/transaksi/penerimaan/printbpb')->group(function () {
    Route::post('/save', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@save')->middleware('CheckLogin');
    Route::get('/get', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@getAllData')->middleware('CheckLogin');
});
//

//BACKOFFICE-TRANSAKSI-PENERIMAAN-CETAK LAPORAN BPB
Route::get('/bo/transaksi/penerimaan/cetakbpb/index', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/cetakbpb/cetaklaporan', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@cetakLaporan')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/cetakbpb/showpo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@showPO')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/cetakbpb/searchpo', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@searchPO')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/cetakbpb/viewreport/', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\cetakBPBController@viewReport')->middleware('CheckLogin');

//OMI-PROSES BKL
//Route::get('/OMI/proses-bkl', 'OMI\ProsesBKLDalamKotaController@index')->middleware('CheckLogin');
//Route::post('/OMI/proses-bkl/proses-file', 'OMI\ProsesBKLDalamKotaController@prosesFile')->middleware('CheckLogin');
//Route::get('/OMI/proses-bkl/cetak-laporan', 'OMI\ProsesBKLDalamKotaController@cetakLaporan')->middleware('CheckLogin');

//FRONT OFFICE - LAPORAN KASIR - LAPORAN PARETO SALES BY MEMBER
//Route::get('/frontoffice/LAPORANKASIR/laporan-pareto-sales-by-member', 'FRONTOFFICE\LAPORANKASIR\paretoSalesMemberController@index')->middleware('CheckLogin');
//Route::get('/frontoffice/LAPORANKASIR/laporan-pareto-sales-by-member/get-lov-member', 'FRONTOFFICE\LAPORANKASIR\paretoSalesMemberController@getLovMember')->middleware('CheckLogin');
//Route::get('/frontoffice/LAPORANKASIR/laporan-pareto-sales-by-member/cetak-laporan', 'FRONTOFFICE\LAPORANKASIR\paretoSalesMemberController@cetakLaporan')->middleware('CheckLogin');

//OMI-LAPORAN - REPRINT BKL
//Route::get('/OMI/laporan/reprint-bkl', 'OMI\LAPORAN\ReprintBKLController@index')->middleware('CheckLogin');
//Route::post('/OMI/laporan/reprint-bkl/cek-omi', 'OMI\LAPORAN\ReprintBKLController@checkKodeOmi')->middleware('CheckLogin');
//Route::post('/OMI/laporan/reprint-bkl/cek-nomor', 'OMI\LAPORAN\ReprintBKLController@cekNomorBukti')->middleware('CheckLogin');
//Route::get('/OMI/laporan/reprint-bkl/get-lov', 'OMI\LAPORAN\ReprintBKLController@getDataLov')->middleware('CheckLogin');
//Route::get('/OMI/laporan/reprint-bkl/cetak-laporan', 'OMI\LAPORAN\ReprintBKLController@cetakLaporan')->middleware('CheckLogin');


//New Mode

Route::middleware(['CheckLogin'])->group(function () {
    Route::prefix('/signature')->group(function () {
        Route::get('/', 'SignatureController@index');
        Route::post('/save', 'SignatureController@save');
        Route::get('/get', 'SignatureController@getAllData');
    });
    Route::prefix('/inquery')->group(function () {
        /*  Michele */
        Route::prefix('/prod-supp')->group(function () {
            Route::get('/', 'INQUERY\inqueryProdSuppController@index');
            Route::post('/prodSupp', 'INQUERY\inqueryProdSuppController@prodSupp');
            Route::post('/suppLOV', 'INQUERY\inqueryProdSuppController@suppLOV');
        });
        Route::prefix('/supp-prod')->group(function () {
            Route::get('/', 'INQUERY\inquerySuppProdController@index');
            Route::post('/suppProd', 'INQUERY\inquerySuppProdController@suppProd');
            Route::post('/showLOV', 'INQUERY\inquerySuppProdController@showLOV');
        });
    });
    Route::prefix('/master')->group(function () {
        /*  Jefri */
        Route::prefix('/mstcabang')->group(function () {
            Route::get('/', 'MASTER\CabangController@index');
            Route::post('/getdetailcabang', 'MASTER\CabangController@getDetailCabang');
            Route::post('/editdatacabang', 'MASTER\CabangController@editDataCabang');
            Route::post('/trfdataanakcab', 'MASTER\CabangController@transDataAnakCab');
        });

        /*  Jefri */
        Route::prefix('/mstoutlet')->group(function () {
            Route::get('/', 'MASTER\OutletController@index');
        });

        /*  Jefri */
        Route::prefix('/mstsuboutlet')->group(function () {
            Route::get('/', 'MASTER\SubOutletController@index');
            Route::post('/getsuboutlet', 'MASTER\SubOutletController@getSubOutlet');
        });

        /*  Jefri */
        Route::prefix('/mstomi')->group(function () {
            Route::get('/', 'MASTER\OmiController@index');
            Route::get('/gettokoomi', 'MASTER\OmiController@getTokoOmi');
            Route::POST('/detailtokoomi', 'MASTER\OmiController@detailTokoOmi');
            Route::POST('/getbranchname', 'MASTER\OmiController@getBranchName');
            Route::POST('/getcustomername', 'MASTER\OmiController@getCustomerName');
            Route::POST('/updatetokoomi', 'MASTER\OmiController@updateTokoOmi');
            Route::POST('/tambahtokoomi', 'MASTER\OmiController@tambahTokoOmi');
            Route::POST('/confirmedit', 'MASTER\OmiController@confirmEdit');
        });

        /*  Jefri */
        Route::prefix('/mstaktifhrgjual')->group(function () {
            Route::get('/', 'MASTER\AktifkanHargaJualController@index');
            Route::get('/getprodmast', 'MASTER\AktifkanHargaJualController@getProdmast');
            Route::post('/getdetailplu', 'MASTER\AktifkanHargaJualController@getDetailPlu');
            Route::post('/aktifkanhrg', 'MASTER\AktifkanHargaJualController@aktifkanHarga');
        });

        /*  Jefri */
        Route::prefix('/mstaktifallhrgjual')->group(function () {
            Route::get('/', 'MASTER\AktifkanAllHargaJualController@index');
            Route::get('/getdata', 'MASTER\AktifkanAllHargaJualController@getData');
            Route::post('/aktifallitem', 'MASTER\AktifkanAllHargaJualController@aktifkanAllItem');
        });

        /*  Jefri */
        Route::prefix('/mstharilibur')->group(function () {
            Route::get('/', 'MASTER\HariLiburController@index');
            Route::get('/getharilibur', 'MASTER\HariLiburController@getHariLibur');
            Route::post('/insert', 'MASTER\HariLiburController@insert');
            Route::post('/delete', 'MASTER\HariLiburController@delete');
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
            Route::get('/', 'MASTER\MemberController@index');
            Route::get('/get-lov-member', 'MASTER\MemberController@getLovMember'); //add by JR
            Route::get('/get-lov-kodepos', 'MASTER\MemberController@getLovKodepos'); //add by JR
            Route::get('/lov-member-search', 'MASTER\MemberController@lovMemberSearch');
            Route::get('/lov-kodepos-search', 'MASTER\MemberController@lovKodeposSearch');
            Route::get('/lov-member-select', 'MASTER\MemberController@lovMemberSelect');
            Route::get('/lov-kodepos-select', 'MASTER\MemberController@lovKodeposSelect');
            Route::get('/set-status-member', 'MASTER\MemberController@setStatusMember');
            Route::post('/check-password', 'MASTER\MemberController@checkPassword');
            Route::post('/update-member', 'MASTER\MemberController@updateMember');
            Route::post('/download-mktho', 'MASTER\MemberController@downloadMktho');
            Route::post('/check-registrasi', 'MASTER\MemberController@checkRegistrasi');
            Route::post('/lov-sub-outlet', 'MASTER\MemberController@lovSuboutlet');
            Route::post('/export-crm', 'MASTER\MemberController@exportCRM');
            Route::post('/save-quisioner', 'MASTER\MemberController@saveQuisioner');
            Route::post('/delete-member', 'MASTER\MemberController@deleteMember');
        });

        /*Leo*/
        Route::prefix('/perusahaan')->group(function () {
            Route::get('/', 'MASTER\PerusahaanController@index');
            Route::post('/update', 'MASTER\PerusahaanController@update');
        });

        /*Leo*/
        Route::prefix('/barcode')->group(function () {
            Route::get('/', 'MASTER\BarcodeController@index');
            Route::get('/get-barcode', 'MASTER\BarcodeController@getBarcode');
        });

        /*Leo*/
        Route::prefix('/kategori-toko')->group(function () {
            Route::get('/', 'MASTER\KategoriTokoController@index');
            Route::post('/getDataKtk', 'MASTER\KategoriTokoController@getDataKtk');
            Route::post('/saveDataKtk', 'MASTER\KategoriTokoController@saveDataKtk');
        });

        /*Leo*/
        Route::prefix('/approval')->group(function () {
            Route::get('/', 'MASTER\ApprovalController@index');
            Route::post('/save-data', 'MASTER\ApprovalController@saveData');
        });

        /*Leo*/
        Route::prefix('/jenis-item')->group(function () {
            Route::get('/', 'MASTER\JenisItemController@index');
            Route::get('/get-prodmast', 'MASTER\JenisItemController@getProdmast');
            Route::post('/lov-search', 'MASTER\JenisItemController@lovSearch');
            Route::post('/lov-select', 'MASTER\JenisItemController@lovSelect');
            Route::post('/save-data', 'MASTER\JenisItemController@saveData');
        });

        /*Leo*/
        Route::prefix('/kubikasi-plano')->group(function () {
            Route::get('/', 'MASTER\KubikasiPlanoController@index');
            Route::post('/lov-subrak', 'MASTER\KubikasiPlanoController@lovSubrak');
            Route::post('/lov_shelving', 'MASTER\KubikasiPlanoController@lovShelving');
            Route::post('/data-rak-kecil', 'MASTER\KubikasiPlanoController@dataRakKecil');
            Route::post('/data-rak-kecil-param', 'MASTER\KubikasiPlanoController@dataRakKecilParam');
            Route::post('/lov-search', 'MASTER\KubikasiPlanoController@lovSearch');
            Route::post('/save-kubikasi', 'MASTER\KubikasiPlanoController@saveKubikasi');
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
            Route::get('/', 'MASTER\LokasiController@index');
            Route::get('/get-lokasi', 'MASTER\LokasiController@getLokasi');
            Route::get('/get-plu', 'MASTER\LokasiController@getPlu');
            Route::post('/lov-rak-select', 'MASTER\LokasiController@lovrakSelect');
            Route::post('/lov-rak-search', 'MASTER\LokasiController@lovRakSearch');

            Route::post('/lov-plu-search', 'MASTER\LokasiController@lovPluSearch');
            Route::post('/lov-plu-select', 'MASTER\LokasiController@lovPluSelect');
            Route::post('/noid-enter', 'MASTER\LokasiController@noidEnter');
            Route::post('/delete-plu', 'MASTER\LokasiController@deletePlu');
            Route::post('/delete-lokasi', 'MASTER\LokasiController@deleteLokasi');
            Route::post('/cek-plu', 'MASTER\LokasiController@cekPlu');
            Route::post('/tambah', 'MASTER\LokasiController@tambah');
            Route::post('/cek-dpd', 'MASTER\LokasiController@cekDpd');
            Route::post('/delete-dpd', 'MASTER\LokasiController@deleteDpd');
            Route::post('/save-dpd', 'MASTER\LokasiController@saveDpd');
        });

        /*Leo*/
        /*MASTER SUPPLIER*/
        Route::prefix('/supplier')->group(function () {
            Route::get('/', 'MASTER\SupplierController@index');
            Route::get('/lov', 'MASTER\SupplierController@lov');
            Route::get('/lov-select', 'MASTER\SupplierController@lovSelect');
            Route::get('/lov-search', 'MASTER\SupplierController@lovSearch');
        });

        /*Leo*/
        /*MASTER DEPARTEMENT*/
        Route::prefix('/departement')->group(function () {
            Route::get('/', 'MASTER\DepartementController@index');
            Route::get('/divisi-select', 'MASTER\DepartementController@divisiSelect');
        });

        /*Leo*/
        /*MASTER DIVISI*/
        Route::prefix('/divisi')->group(function () {
            Route::get('/', 'MASTER\DivisiController@index');
        });

        /*Leo*/
        /*MASTER KATEGORI BARANG*/
        Route::prefix('/kategori-barang')->group(function () {
            Route::get('/', 'MASTER\KategoriBarangController@index');
            Route::get('/departement-select', 'MASTER\KategoriBarangController@departementSelect');
        });

        /*Leo*/
        /*MASTER HARGA BELI*/
        Route::prefix('/hargabeli')->group(function () {
            Route::get('/', 'MASTER\iController@index');
            Route::get('/get-prodmast', 'HargaBelMASTER\HargaBeliController@getProdmast');
            Route::get('/lov-search', 'MASTER\HargaBeliController@lovSearch');
            Route::get('/lov-select', 'MASTER\HargaBeliController@lovSelect');
        });
    });

    Route::prefix('/bo')->group(function () {
        /*Denni*/
        Route::prefix('/informasi-history-product')->group(function () {
            Route::get('/', 'BACKOFFICE\InformasiHistoryProductController@index');
            Route::get('/lov-search', 'BACKOFFICE\InformasiHistoryProductController@lovSearch');
            Route::get('/get-next-plu', 'BACKOFFICE\InformasiHistoryProductController@getNextPLU');
            Route::get('/get-prev-plu', 'BACKOFFICE\InformasiHistoryProductController@getPrevPLU');
            Route::post('/lov-search', 'BACKOFFICE\InformasiHistoryProductController@lovSearch');
            Route::post('/lov-select', 'BACKOFFICE\InformasiHistoryProductController@lovSelect');
            Route::post('/cetak-so', 'BACKOFFICE\InformasiHistoryProductController@cetakSo');
            Route::post('/cetak', 'BACKOFFICE\InformasiHistoryProductController@cetak');
            Route::get('/get-data-detail-sales', 'BACKOFFICE\InformasiHistoryProductController@getDetailSales');
            Route::get('/get-data-penerimaan', 'BACKOFFICE\InformasiHistoryProductController@getPenerimaan');
            Route::get('/get-data-pb', 'BACKOFFICE\InformasiHistoryProductController@getPB');
            Route::get('/get-data-so', 'BACKOFFICE\InformasiHistoryProductController@getSO');
            Route::get('/get-data-harga-beli', 'BACKOFFICE\InformasiHistoryProductController@getHargaBeli');
            Route::get('/get-data-stock-carton', 'BACKOFFICE\InformasiHistoryProductController@getStockCarton');
        });

        /*Leo*/
        Route::prefix('/pb')->group(function () {

            /*Denni*/
            Route::prefix('/manual')->group(function () {
                Route::get('/', 'BACKOFFICE\PBManualController@index');
                Route::get('/lov_nopb', 'BACKOFFICE\PBManualController@lov_nopb');
                Route::get('/lov_search_plu', 'BACKOFFICE\PBManualController@lov_search_plu');
                Route::get('/lov_search_plu_pb', 'BACKOFFICE\PBManualController@lov_search_plu_pb');
                Route::get('/get-data-pb', 'BACKOFFICE\PBManualController@getDataPB');
                Route::post('/hapus-dokumen', 'BACKOFFICE\PBManualController@hapusDokumen');
                Route::post('/cek_plu', 'BACKOFFICE\PBManualController@cek_plu');
                Route::post('/cek_bonus', 'BACKOFFICE\PBManualController@cek_bonus');
                Route::post('/save_data', 'BACKOFFICE\PBManualController@save_data');
            });

            /*JEFRI*/
            Route::prefix('/max-palet')->group(function () {
                Route::get('/', 'BACKOFFICE\maxpaletUntukPBController@index');
                Route::post('/loaddata', 'BACKOFFICE\maxpaletUntukPBController@loadData');
                Route::post('/getmaxpalet', 'BACKOFFICE\maxpaletUntukPBController@getMaxPalet');
                Route::post('/savedata', 'BACKOFFICE\maxpaletUntukPBController@saveData');
                Route::post('/deletedata', 'BACKOFFICE\maxpaletUntukPBController@deleteData');
            });

            /*JEFRI*/
            Route::prefix('/utility-pb-igr')->group(function () {
                Route::get('/', 'BACKOFFICE\utilityPBIGRController@index');
                Route::post('/callproc1', 'BACKOFFICE\utilityPBIGRController@callProc1');
                Route::post('/callproc2', 'BACKOFFICE\utilityPBIGRController@callProc2');
                Route::post('/callproc3', 'BACKOFFICE\utilityPBIGRController@callProc3');
                Route::post('/chekproc4', 'BACKOFFICE\utilityPBIGRController@checkProc4');
                Route::get('/callproc4/{date}', 'BACKOFFICE\utilityPBIGRController@callProc4');
                Route::get('/test', function () {
                    return view('BACKOFFICE.utilityPBIGR-laporan');
                });
            });

            /*JEFRI*/
            Route::prefix('/pb-otomatis')->group(function () {
                Route::get('/', 'BACKOFFICE\PBOtomatisController@index');
                Route::get('/getdatamodalsupplier', 'BACKOFFICE\PBOtomatisController@getDataModalSupplier');
                Route::get('/getkategori', 'BACKOFFICE\PBOtomatisController@getKategori');
                Route::post('/prosesdata', 'BACKOFFICE\PBOtomatisController@prosesData');
                Route::get('/cetakreport', 'BACKOFFICE\PBOtomatisController@cetakReport');
                //                Route::get('/cetakreport/{kodeigr}/{date1}/{date2}/{sup1}/{sup2}', 'BACKOFFICE\PBOtomatisController@cetakReport');
            });

            /*JEFRI*/
            Route::prefix('/cetak-pb')->group(function () {
                Route::get('/', 'BACKOFFICE\cetakPBController@index');
                Route::get('/getdocument', 'BACKOFFICE\cetakPBController@getDocument');
                Route::post('/searchdocument', 'BACKOFFICE\cetakPBController@searchDocument');
                Route::post('/getdivisi', 'BACKOFFICE\cetakPBController@getDivisi');
                Route::post('/searchdivisi', 'BACKOFFICE\cetakPBController@searchDivisi');
                Route::get('/getdepartement', 'BACKOFFICE\cetakPBController@getDepartement');
                Route::post('/searchdepartement', 'BACKOFFICE\cetakPBController@searchDepartement');
                Route::get('/getkategori', 'BACKOFFICE\cetakPBController@getKategori');
                Route::post('/searchkategori', 'BACKOFFICE\cetakPBController@searchKategori');
                Route::get('/cetakreport', 'BACKOFFICE\cetakPBController@cetakReport');
                //                Route::get('/cetakreport/{tgl1}/{tgl2}/{doc1}/{doc2}/{div1}/{div2}/{dept1}/{dept2}/{kat1}/{kat2}/{tipePB}', 'BACKOFFICE\cetakPBController@cetakReport');
            });

            //hen
            //PB Perishable


            Route::prefix('/pbperishable')->group(function () {
                Route::get('/', 'BACKOFFICE\PBPerishableController@index');
                Route::post('/lov_trn', 'BACKOFFICE\PBPerishableController@lov_trn');
                Route::post('/lov_plu', 'BACKOFFICE\PBPerishableController@lov_plu');
                Route::post('/showSup', 'BACKOFFICE\PBPerishableController@showSup');
                Route::post('/showTrn', 'BACKOFFICE\PBPerishableController@showTrn');
                Route::post('/showPlu', 'BACKOFFICE\PBPerishableController@showPlu');
                Route::post('/nmrBaruPb', 'BACKOFFICE\PBPerishableController@nmrBaruPb');
                Route::post('/qtyPb', 'BACKOFFICE\PBPerishableController@qtyPb');
                Route::post('/saveDoc', 'BACKOFFICE\PBPerishableController@saveDoc');
                Route::post('/saveDoc2', 'BACKOFFICE\PBPerishableController@saveDoc2');
                Route::post('/saveDoc3', 'BACKOFFICE\PBPerishableController@saveDoc3');
                Route::post('/deleteDoc', 'BACKOFFICE\PBPerishableController@deleteDoc');
                Route::post('/prosesDoc', 'BACKOFFICE\PBPerishableController@prosesDoc');
            });

            /*BACK OFFICE - KERTAS KERJA KEBUTUHAN TOKO IGR*/
            Route::prefix('/kkei')->group(function () {
                Route::get('/', 'BACKOFFICE\KKEIController@index');
                Route::post('/get_detail_produk', 'BACKOFFICE\KKEIController@get_detail_produk');
                Route::post('/get_detail_kkei', 'BACKOFFICE\KKEIController@get_detail_kkei');
                Route::post('/save', 'BACKOFFICE\KKEIController@save');
                Route::get('/laporan', 'BACKOFFICE\KKEIController@laporan');

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
                Route::post('/proses_go', 'BACKOFFICE\ReorderPBGOController@proses_goOld');
                Route::get('/proses_go', 'BACKOFFICE\ReorderPBGOController@proses_go');
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
                Route::get('/get-status', 'BACKOFFICE\LPP\ProsesLPPController@getStatus');
                Route::post('/proses', 'BACKOFFICE\LPP\ProsesLPPController@proses');
                Route::post('/proses-ulang', 'BACKOFFICE\LPP\ProsesLPPController@prosesUlang');
            });
            Route::prefix('/proses-lpp-harian')->group(function () {
                Route::get('/', 'BACKOFFICE\LPP\ProsesLPPHarianController@index');
                Route::post('/proses', 'BACKOFFICE\LPP\ProsesLPPHarianController@proses');
                Route::get('/cetak', 'BACKOFFICE\LPP\ProsesLPPHarianController@cetak');
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



        Route::prefix('/transaksi')->group(function () {

            /*  Jefri */
            Route::prefix('/pemusnahan')->group(function () {
                Route::prefix('/barang-rusak')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@index');
                    Route::get('/getnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNmrTrn');
                    Route::get('/getplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getPlu');
                    Route::post('/choosetrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@chooseTrn');
                    Route::post('/getnewnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNewNmrTrn');
                    Route::post('/chooseplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@choosePlu');
                    Route::post('/savedata', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@saveData');
                    Route::post('/deletedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@deleteDocument');
                    Route::post('/showall', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@showAll');
                    Route::get('/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@printDocument');
                });
                Route::prefix('/bapemusnahan')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@index');
                    Route::get('/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNoDocument');
                    Route::get('/getnopbbr', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNoPBBR');
                    Route::post('/choosedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@chooseNoDocument');
                    Route::post('/choosepbbr', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@choosePBBR');
                    Route::post('/getnewnmrdoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNewNmrDoc');
                    Route::post('/savedata', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@saveData');
                    Route::get('/printdoc/{doc}/{ukuran}', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@printDocument');
                });
                Route::prefix('/inquerybapb')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@index');
                    Route::get('/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@getDocument');
                    Route::post('/getdetaildoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@getDetailDocument');
                    Route::post('/detailplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@detailPlu');
                });
                Route::prefix('/bapbatal')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@index');
                    Route::get('/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@getDocument');
                    Route::post('/getdetaildoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@getDetailDocument');
                    Route::post('/deletedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@deleteDocument');
                });
            });

            Route::prefix('/penerimaan')->group(function () {
                Route::prefix('/input')->group(function () {
                    Route::get('/',                     'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@index');
                    Route::get('/showbtb/{tipetrn}',    'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showBTB');
                    Route::post('/choosebtb',           'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@chooseBTB');
                    Route::post('/getnewnobtb',         'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@getNewNoBTB');
                    Route::get('/showpo',               'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showPO');
                    Route::post('/choosepo',            'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@choosePO');
                    Route::get('/showsupplier',         'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showSupplier');
                    Route::post('/showplu',             'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showPlu');
                    Route::post('/chooseplu',           'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@choosePlu');
                    Route::post('/changehargabeli',     'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeHargaBeli');
                    Route::post('/changeqty',           'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeQty');
                    Route::post('/changebonus1',        'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeBonus1');
                    Route::post('/changerphdisc',       'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeRphDisc');
                    Route::post('/rekamdata',           'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@rekamData');
                    Route::post('/transferpo',          'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@transferPO');
                    Route::post('/savedata',            'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@saveData');
                    Route::post('/check-kode-supplier', 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@checkKodeSupplier'); //test
                });
            });

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

                    // Cesar
                    Route::post('/save-new-data-trn', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\InputController@saveNewData');
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

                // Cesar
                // Cetak Ulang Faktur Pajak
                Route::prefix('/cetak-ulang-faktur-pajak')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\CetakUlangFakturPajakController@index');
                    Route::post('/lov-search1', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\CetakUlangFakturPajakController@lovSearchNPB1');
                    Route::post('/lov-search2', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\CetakUlangFakturPajakController@lovSearchNPB2');
                    Route::post('/check-data', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\CetakUlangFakturPajakController@checkData');
                });
            });

            /*Leo*/
            Route::prefix('/penyesuaian')->group(function () {
                Route::prefix('/input')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@index');
                    Route::get('/lov_plu_search', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@lov_plu_search');
                    Route::post('/plu_select', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@plu_select');
                    Route::get('/doc_select', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_select');
                    Route::post('/doc_new', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_new');
                    Route::post('/doc_save', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_save');
                    Route::post('/doc_delete', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_delete');
                    Route::post('/validate-mpp', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@validateMPP');
                    Route::post('/hitung-qtyk', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@hitungQTYK');
                });

                Route::prefix('/cetak')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@index');
                    Route::post('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@getData');
                    Route::post('/store-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@storeData');
                    Route::get('/laporan', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@laporan');
                    Route::get('/tes', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@tes');
                    Route::post('/check-update-lokasi', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@checkUpdateLokasi');
                    Route::post('/check-update-pkmt', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@checkUpdatePKMT');
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

                Route::prefix('/proses-pergantian-plu')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\ProsesPergantianPLUController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\ProsesPergantianPLUController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\ProsesPergantianPLUController@getData');
                    Route::post('/proses', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\ProsesPergantianPLUController@proses');
                    Route::get('/laporan', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\ProsesPergantianPLUController@laporan');
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
                    Route::post('/deleteDoc', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@deleteDoc');
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
            Route::prefix('/perubahan-status')->group(function () {
                Route::prefix('/entry-sortir-barang')->group(function () {
                    //BACKOFFICE-TRANSAKSI-PERUBAHAN STATUS-ENTRY SORTIR BARANG (ryanOrder = 1)
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@index');
                    Route::post('/get-new-nomor-sortir', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@getNewNmrSrt');
                    Route::post('/get-nomor-sortir', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@getNmrSrt');
                    Route::post('/choose-sortir', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@chooseSrt');
                    //                    Route::post('/getplu', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@getPlu');
                    Route::post('/choose-plu', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@choosePlu');
                    Route::post('/save-data', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@saveData');
                    Route::get('/print-document/{doc}', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@printDocument');

                    Route::get('/modal-sortir', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@ModalSrt');
                    Route::get('/modal-plu', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\EntrySortirBarangController@ModalPlu');
                });

                Route::prefix('/rubah-status')->group(function () {
                    //BACKOFFICE-TRANSAKSI-PERUBAHAN STATUS-RUBAH STATUS (ryanOrder = 2)
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@index');
                    Route::post('/getnewnmrrsn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@getNewNmrRsn');
                    Route::post('/getnmrrsn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@getNmrRsn');
                    Route::post('/getnmrsrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@getNmrSrt');
                    Route::post('/choosersn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@chooseRsn');
                    Route::post('/choosesrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@chooseSrt');
                    Route::post('/savedata', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@saveData');
                    Route::post('/check-document', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@checkDocument');
                    Route::post('/checkrak', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@checkRak');
                    Route::get('/printdoc', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@printDocument');
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
                    Route::get('/printdoc', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@printDocument');
                    Route::get('/printdockecil', 'BACKOFFICE\TRANSAKSI\REPACKING\repackController@printDocumentKecil');

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
            //BACKOFFICE-LIST MASTER (ryanOrder = 37)
            Route::get('/', 'BACKOFFICE\ListMasterController@index');
            Route::get('/get-lov-divisi', 'BACKOFFICE\ListMasterController@getLovDivisi');
            Route::get('/get-lov-departemen', 'BACKOFFICE\ListMasterController@getLovDepartemen');
            Route::get('/get-lov-kategori', 'BACKOFFICE\ListMasterController@getLovKategori');
            Route::get('/get-lov-supplier', 'BACKOFFICE\ListMasterController@getLovSupplier');
            Route::get('/get-lov-member', 'BACKOFFICE\ListMasterController@getLovMember');
            Route::get('/check-member', 'BACKOFFICE\ListMasterController@checkMember');
            Route::get('/get-lov-member-with-date', 'BACKOFFICE\ListMasterController@getLovMemberWithDate');
            Route::get('/get-lov-outlet', 'BACKOFFICE\ListMasterController@getLovOutlet');
            Route::get('/get-lov-sub-outlet', 'BACKOFFICE\ListMasterController@getLovSubOutlet');
            Route::get('/get-lov-plu', 'BACKOFFICE\ListMasterController@getLovPlu');
            Route::get('/get-lov-plu-custom', 'BACKOFFICE\ListMasterController@getLovPluCustom');
            Route::get('/check-plu', 'BACKOFFICE\ListMasterController@checkPlu');
            Route::get('/get-lov-rak', 'BACKOFFICE\ListMasterController@getLovRak');
            //PATH PRINT
            Route::get('/print-daftar-produk', 'BACKOFFICE\ListMasterController@printDaftarProduk');
            Route::get('/print-daftar-perubahan-harga-jual', 'BACKOFFICE\ListMasterController@printDaftarPerubahanHargaJual');
            Route::get('/print-daftar-margin-negatif', 'BACKOFFICE\ListMasterController@printDaftarMarginNegatif');
            Route::get('/print-daftar-supplier', 'BACKOFFICE\ListMasterController@printDaftarSupplier');
            Route::get('/print-daftar-anggota-or-member', 'BACKOFFICE\ListMasterController@printDaftarMember');
            Route::get('/print-daftar-anggota-or-type-outlet', 'BACKOFFICE\ListMasterController@printDaftarMemberTypeOutlet');
            Route::get('/print-daftar-anggota-or-member-baru', 'BACKOFFICE\ListMasterController@printDaftarMemberBaru');
            Route::get('/print-daftar-anggota-or-member-jatuh-tempo', 'BACKOFFICE\ListMasterController@printDaftarMemberJatuhTempo');
            Route::get('/print-daftar-anggota-or-member-expired', 'BACKOFFICE\ListMasterController@printDaftarMemberExpired');
            Route::get('/print-daftar-harga-jual-baru', 'BACKOFFICE\ListMasterController@printDaftarHargaJualBaru');
            Route::get('/print-daftar-perpanjangan-anggota-or-member', 'BACKOFFICE\ListMasterController@printDaftarPerpanjanganMember');
            Route::get('/print-daftar-status-tag-bar', 'BACKOFFICE\ListMasterController@printDaftarStatusTagBar');
            Route::get('/print-master-display', 'BACKOFFICE\ListMasterController@printMasterDisplay');
            Route::get('/print-master-display-div-dep-kat', 'BACKOFFICE\ListMasterController@printMasterDisplayDDK');
            Route::get('/print-daftar-margin-negatif-vs-mcg', 'BACKOFFICE\ListMasterController@printDaftarMarginNegatifvsMCG');
            Route::get('/print-daftar-supplier-by-hari-kunjungan', 'BACKOFFICE\ListMasterController@printDaftarSupplierByHari');
        });

        Route::prefix('/proses')->group(function () {
            Route::prefix('/konversi')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\KonversiController@index');
                Route::get('/get-data-lov-plu-utuh', 'BACKOFFICE\PROSES\KonversiController@getDataLovPluUtuh');
                Route::get('/get-data-plu-utuh', 'BACKOFFICE\PROSES\KonversiController@getDataPluUtuh');
                Route::get('/get-data-lov-plu-mix', 'BACKOFFICE\PROSES\KonversiController@getDataLovPluMix');
                Route::get('/get-data-plu-mix', 'BACKOFFICE\PROSES\KonversiController@getDataPluMix');
                Route::get('/get-data-lov-nodoc', 'BACKOFFICE\PROSES\KonversiController@getDataLovNodoc');
                Route::get('/get-data-plu-olahan', 'BACKOFFICE\PROSES\KonversiController@getDataPluOlahan');
                Route::post('/konversi-utuh-olahan', 'BACKOFFICE\PROSES\KonversiController@konversiUtuhOlahan');
                Route::post('/konversi-olahan-mix', 'BACKOFFICE\PROSES\KonversiController@konversiOlahanMix');
                Route::get('/print-bukti', 'BACKOFFICE\PROSES\KonversiController@printBukti');
                Route::get('/print-laporan-rekap', 'BACKOFFICE\PROSES\KonversiController@printLaporanRekap');
                Route::get('/print-laporan-detail', 'BACKOFFICE\PROSES\KonversiController@printLaporanDetail');
                Route::get('/check-qty-olahan-mix', 'BACKOFFICE\PROSES\KonversiController@checkQtyOlahanMix');
            });

            Route::prefix('/hitungulangstock')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\HitungUlangStockController@index');
                Route::get('/get-data-lov', 'BACKOFFICE\PROSES\HitungUlangStockController@getDataLov');
                Route::get('/get-status', 'BACKOFFICE\PROSES\HitungUlangStockController@cekStatusHitungUlangStock');
                Route::post('/hitung-ulang-stock', 'BACKOFFICE\PROSES\HitungUlangStockController@ProsesHitungUlangStock');
                Route::post('/hitung-ulang-stock-cmo', 'BACKOFFICE\PROSES\HitungUlangStockController@ProsesHitungUlangStockCMO');
                Route::post('/hitung-ulang-point', 'BACKOFFICE\PROSES\HitungUlangStockController@ProsesHitungUlangPoint');
                Route::post('/proses-ulang', 'BACKOFFICE\PROSES\HitungUlangStockController@prosesUlang');
                Route::post('/hapus-point', 'BACKOFFICE\PROSES\HitungUlangStockController@ProsesHapusPoint');
                Route::get('/cetak', 'BACKOFFICE\PROSES\HitungUlangStockController@PrintHapus');
            });
            Route::prefix('/monthend')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\MonthEndController@index');
                Route::get('/get-status', 'BACKOFFICE\PROSES\MonthEndController@getStatus');
                Route::post('/proses', 'BACKOFFICE\PROSES\MonthEndController@proses');
                Route::post('/proses-hitung-stok', 'BACKOFFICE\PROSES\MonthEndController@prosesHitungStock');
                Route::post('/proses-hitung-stok-cmo', 'BACKOFFICE\PROSES\MonthEndController@prosesHitungStockCMO');
                Route::post('/proses-sales-rekap', 'BACKOFFICE\PROSES\MonthEndController@prosesSalesRekap');
                Route::post('/proses-sales-lpp', 'BACKOFFICE\PROSES\MonthEndController@prosesLPP');
                Route::post('/delete-data', 'BACKOFFICE\PROSES\MonthEndController@deleteData');
                Route::post('/proses-copystock', 'BACKOFFICE\PROSES\MonthEndController@prosesCopyStock');
                Route::post('/proses-copystock-cmo', 'BACKOFFICE\PROSES\MonthEndController@prosesCopyStockCMO');
                Route::post('/proses-hitung-stok2', 'BACKOFFICE\PROSES\MonthEndController@prosesHitungStock2');
                Route::post('/proses-hitung-stok-cmo2', 'BACKOFFICE\PROSES\MonthEndController@prosesHitungStockCMO2');
                Route::post('/proses-lpp-point', 'BACKOFFICE\PROSES\MonthEndController@prosesLPPPoint');
                Route::post('/proses-akhir', 'BACKOFFICE\PROSES\MonthEndController@prosesAkhir');
                Route::post('/proses-ulang', 'BACKOFFICE\PROSES\MonthEndController@prosesUlang');
            });

            /*Michele*/
            Route::prefix('/setting-pagi-hari')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\settingPagiHariController@index');
                Route::get('/cetak_perubahan_harga_jual', 'BACKOFFICE\PROSES\settingPagiHariController@cetak_perubahan_harga_jual');
                Route::get('/cetak_daftar_plu_tag', 'BACKOFFICE\PROSES\settingPagiHariController@cetak_daftar_plu_tag');
            });

            /*Leo*/
            Route::prefix('/copy-avg-cost')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\CopyAvgCostController@index');
                Route::post('/copy-data', 'BACKOFFICE\PROSES\CopyAvgCostController@copyData');
            });

            /*Leo*/
            Route::prefix('/kartu-gudang')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\KartuGudangController@index');
                Route::post('/check-divisi', 'BACKOFFICE\PROSES\KartuGudangController@checkDivisi');
                Route::post('/check-departement', 'BACKOFFICE\PROSES\KartuGudangController@checkDepartement');
                Route::post('/check-kategori', 'BACKOFFICE\PROSES\KartuGudangController@checkKategori');
                Route::post('/check-plu', 'BACKOFFICE\PROSES\KartuGudangController@checkPLU');
                Route::get('/get-lov-plu', 'BACKOFFICE\PROSES\KartuGudangController@getLovPLU');
                Route::post('/process', 'BACKOFFICE\PROSES\KartuGudangController@process');
                Route::get('/print-rekap', 'BACKOFFICE\PROSES\KartuGudangController@printRekap');
                Route::get('/print-detail', 'BACKOFFICE\PROSES\KartuGudangController@printDetail');
            });

            /*Ryan*/
            Route::prefix('/restore-data-month-end')->group(function () {
                //BACKOFFICE-RESTORE (ryanOrder = 5)
                Route::get('/', 'BACKOFFICE\PROSES\RestoreDataMonthEndController@index');
                Route::post('/restorenow', 'BACKOFFICE\PROSES\RestoreDataMonthEndController@restoreNow');
            });

            /*Ryan*/
            Route::prefix('/pemutihan-plu')->group(function () {
                Route::get('/', 'BACKOFFICE\PROSES\PemutihanPluController@index');
                Route::post('/startup', 'BACKOFFICE\PROSES\PemutihanPluController@startup');
                Route::post('/proses', 'BACKOFFICE\PROSES\PemutihanPluController@proses');
                Route::post('/pemutihan-plu', 'BACKOFFICE\PROSES\PemutihanPluController@pemutihanPlu');
                Route::post('/pemutihan-barcode', 'BACKOFFICE\PROSES\PemutihanPluController@pemutihanBarcode');
                Route::get('/print-lap1', 'BACKOFFICE\PROSES\PemutihanPluController@printLap1');
                Route::get('/print-lap2', 'BACKOFFICE\PROSES\PemutihanPluController@printLap2');
                Route::get('/print-lap3', 'BACKOFFICE\PROSES\PemutihanPluController@printLap3');
                Route::get('/print-lap4', 'BACKOFFICE\PROSES\PemutihanPluController@printLap4');
                Route::get('/print-lap5', 'BACKOFFICE\PROSES\PemutihanPluController@printLap5');
                Route::get('/print-lap6', 'BACKOFFICE\PROSES\PemutihanPluController@printLap6');
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
                Route::get('/printdocddk', 'BACKOFFICE\LAPORAN\ServiceLevelItemParetoController@printDocumentddk');
                Route::get('/printdocsupplier', 'BACKOFFICE\LAPORAN\ServiceLevelItemParetoController@printDocumentSupplier');

                Route::get('/modalnmr', 'BACKOFFICE\LAPORAN\ServiceLevelItemParetoController@ModalNmr');
            });
            /*Denni*/
            Route::prefix('/daftar-pb-yang-tidak-terbentuk-po')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\DaftarPBYangTidakTerbentukPOController@index');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\DaftarPBYangTidakTerbentukPOController@cetak');
            });
            Route::prefix('/monitoring-faktur-pajak-sj-nrb')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\LaporanMonitoringFakturPajakSJNRBController@index');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\LaporanMonitoringFakturPajakSJNRBController@cetak');
            });
            Route::prefix('/discount-4')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\LaporanDiscount4Controller@index');
                Route::get('/get-lov-supplier', 'BACKOFFICE\LAPORAN\LaporanDiscount4Controller@getLovSupplier');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\LaporanDiscount4Controller@cetak');
            });
            Route::prefix('/daftar-aktivitas-pengiriman-supplier')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\DaftarAktivitasPengirimanSupplierController@index');
                Route::get('/get-lov-supplier', 'BACKOFFICE\LAPORAN\DaftarAktivitasPengirimanSupplierController@getLovSupplier');
                Route::get('/get-lov-monitoring', 'BACKOFFICE\LAPORAN\DaftarAktivitasPengirimanSupplierController@getLovMonitoring');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\DaftarAktivitasPengirimanSupplierController@cetak');
            });
            Route::prefix('/service-level-po-btb')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOBTBController@index');
                Route::get('/get-lov-supplier', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOBTBController@getLovSupplier');
                Route::get('/get-lov-monitoring', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOBTBController@getLovMonitoring');
                Route::get('/cetak', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOBTBController@cetak');
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

            Route::prefix('/laporan-history-harga')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\LaporanHistoryHargaController@index');
                Route::get('/get-lov-plu', 'BACKOFFICE\LAPORAN\LaporanHistoryHargaController@getLovPLU');
                Route::get('/get-data-plu', 'BACKOFFICE\LAPORAN\LaporanHistoryHargaController@getDataPLU');
                Route::get('/print', 'BACKOFFICE\LAPORAN\LaporanHistoryHargaController@print');
            });

            Route::prefix('/laporan-service-level-po-thd-bpb-div-dept-katb')->group(function () {
                Route::get('/', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOThdBPBDIVDEPTKATBController@index');
                Route::get('/get-data-lov-div', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOThdBPBDIVDEPTKATBController@getDataLovDiv');
                Route::get('/get-data-lov-dep', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOThdBPBDIVDEPTKATBController@getDataLovDep');
                Route::get('/get-data-lov-kat', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOThdBPBDIVDEPTKATBController@getDataLovKat');
                Route::get('/get-data-tag', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOThdBPBDIVDEPTKATBController@getDataTag');
                Route::get('/print', 'BACKOFFICE\LAPORAN\LaporanServiceLevelPOThdBPBDIVDEPTKATBController@print');
            });
        });

        /*Leo*/
        Route::prefix('/transfer')->group(function () {
            Route::prefix('/plu')->group(function () {
                Route::get('/', 'BACKOFFICE\TRANSFER\TransferPLUController@index');
                Route::post('/download-dta', 'BACKOFFICE\TRANSFER\TransferPLUController@downloadDTA');
                Route::post('/transfer-dta4', 'BACKOFFICE\TRANSFER\TransferPLUController@transferDTA4');
                Route::post('/req-proses-dta4', 'BACKOFFICE\TRANSFER\TransferPLUController@reqProsesDTA4');
                Route::post('/transfer-plu-commit-order', 'BACKOFFICE\TRANSFER\TransferPLUController@transferPLUCOmmitOrder');
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

            Route::prefix('/transfer-perjanjian-sewa-gondola')->group(function () {
                Route::get('/', 'BACKOFFICE\TRANSFER\TransferPerjanjianSewaGondolaController@index');
                Route::post('/transfer-file-dbf', 'BACKOFFICE\TRANSFER\TransferPerjanjianSewaGondolaController@transferFileDBF');
                Route::get('/print', 'BACKOFFICE\TRANSFER\TransferPerjanjianSewaGondolaController@print');
            });

            Route::prefix('/plu')->group(function () {
                Route::get('/', 'BACKOFFICE\TRANSFER\TransferPLUController@index');
                Route::post('/download-dta', 'BACKOFFICE\TRANSFER\TransferPLUController@downloadDTA');
                Route::post('/transfer-dta4', 'BACKOFFICE\TRANSFER\TransferPLUController@transferDTA4');
                Route::post('/req-proses-dta4', 'BACKOFFICE\TRANSFER\TransferPLUController@reqProsesDTA4');
                Route::get('/download-txt', 'BACKOFFICE\TRANSFER\TransferPLUController@downloadTxt');
            });

            //denni
            Route::prefix('/lokasi')->group(function () {
                Route::get('/', 'BACKOFFICE\TRANSFER\TransferLokasiController@index');
                Route::get('/get-data', 'BACKOFFICE\TRANSFER\TransferLokasiController@getData');
                Route::post('/proses-transfer', 'BACKOFFICE\TRANSFER\TransferLokasiController@prosesTransfer');
                Route::get('/cetak', 'BACKOFFICE\TRANSFER\TransferLokasiController@CETAK_WPLU_FILE');
                Route::get('/download-wplu-file', 'BACKOFFICE\TRANSFER\TransferLokasiController@DOWNLOAD_WPLU_FILE');
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

            Route::prefix('/inquery-tabel-gondola')->group(function () {
                Route::get('/', 'BACKOFFICE\PKM\InqueryTabelGondolaController@index');
                Route::get('/get-lov-plu', 'BACKOFFICE\PKM\InqueryTabelGondolaController@getLovPLU');
                Route::get('/get-data', 'BACKOFFICE\PKM\InqueryTabelGondolaController@getData');
                Route::get('/get-data-plu', 'BACKOFFICE\PKM\InqueryTabelGondolaController@getDataPLU');
            });

            Route::prefix('/entry-tabel-qty-mplus')->group(function () {
                Route::get('/', 'BACKOFFICE\PKM\EntryTabelQTYMPlusController@index');
                Route::get('/get-lov-plu', 'BACKOFFICE\PKM\EntryTabelQTYMPlusController@getLovPLU');
                Route::get('/get-data-plu', 'BACKOFFICE\PKM\EntryTabelQTYMPlusController@getDataPLU');
                Route::get('/get-table-data', 'BACKOFFICE\PKM\EntryTabelQTYMPlusController@getTableData');
                Route::post('/save', 'BACKOFFICE\PKM\EntryTabelQTYMPlusController@save');
                Route::post('/delete', 'BACKOFFICE\PKM\EntryTabelQTYMPlusController@delete');
                Route::get('/print-tag', 'BACKOFFICE\PKM\EntryTabelQTYMPlusController@printTag');
                Route::get('/print-all', 'BACKOFFICE\PKM\EntryTabelQTYMPlusController@printAll');
                Route::post('/upload-csv', 'BACKOFFICE\PKM\EntryTabelQTYMPlusController@uploadCSV');
            });

            Route::prefix('/edit-pkm')->group(function () {
                Route::get('/', 'BACKOFFICE\PKM\EditPKMController@index');
                Route::get('/get-data-lov-usulan', 'BACKOFFICE\PKM\EditPKMController@getDataLovUsulan');
                Route::get('/get-data-lov-plu', 'BACKOFFICE\PKM\EditPKMController@getDataLovPlu');
                Route::get('/get-data-usulan', 'BACKOFFICE\PKM\EditPKMController@getDataUsulan');
                Route::get('/check-usulan', 'BACKOFFICE\PKM\EditPKMController@checkUsulan');
                Route::get('/get-new-no-usulan', 'BACKOFFICE\PKM\EditPKMController@getNewNoUsulan');
                Route::get('/get-data-plu', 'BACKOFFICE\PKM\EditPKMController@getDataPlu');
                Route::get('/send-usulan', 'BACKOFFICE\PKM\EditPKMController@sendUsulan');
                Route::post('/save-usulan', 'BACKOFFICE\PKM\EditPKMController@saveUsulan');
                Route::get('/download-format-usulan', 'BACKOFFICE\PKM\EditPKMController@downloadFormatUsulan');
                Route::post('/upload-file-usulan', 'BACKOFFICE\PKM\EditPKMController@uploadFileUsulan');
                Route::get('/check-print-usulan', 'BACKOFFICE\PKM\EditPKMController@checkPrintUsulan');
                Route::get('/print-usulan', 'BACKOFFICE\PKM\EditPKMController@printUsulan');
                Route::post('/upload-file-approval', 'BACKOFFICE\PKM\EditPKMController@uploadFileApproval');
                Route::get('/get-data-approval', 'BACKOFFICE\PKM\EditPKMController@getDataApproval');
                Route::get('/get-data-lov-pkm-baru', 'BACKOFFICE\PKM\EditPKMController@getDataLovPKMBaru');
                Route::get('/get-data-pkm-baru', 'BACKOFFICE\PKM\EditPKMController@getDataPKMBaru');
                Route::post('/upload-file-pkm-baru', 'BACKOFFICE\PKM\EditPKMController@uploadFilePKMBaru');
            });

            //Denni
            Route::prefix('/laporan-kertas-kerja-pkm')->group(function () {
                Route::get('/', 'BACKOFFICE\PKM\LaporanKertasKerjaPKMController@index');
                Route::get('/get-lov-divisi', 'BACKOFFICE\PKM\LaporanKertasKerjaPKMController@getLovDivisi');
                Route::get('/get-lov-departement', 'BACKOFFICE\PKM\LaporanKertasKerjaPKMController@getLovDepartement');
                Route::get('/get-lov-kategori', 'BACKOFFICE\PKM\LaporanKertasKerjaPKMController@getLovKategori');
                Route::get('/get-lov-plu', 'BACKOFFICE\PKM\LaporanKertasKerjaPKMController@getLovPLU');
                Route::get('/get-lov-monitoring', 'BACKOFFICE\PKM\LaporanKertasKerjaPKMController@getLovMonitoring');
                Route::get('/get-lov-supplier', 'BACKOFFICE\PKM\LaporanKertasKerjaPKMController@getLovSupplier');
                Route::get('/get-lov-tag', 'BACKOFFICE\PKM\LaporanKertasKerjaPKMController@getLovTag');
                Route::get('/cetak', 'BACKOFFICE\PKM\LaporanKertasKerjaPKMController@cetak');
            });

            // Cesar & Steven
            Route::prefix('/faktor-pkm-toko')->group(function () {
                Route::get('/', 'BACKOFFICE\PKM\FaktorPKMTokoController@index');
                Route::get('/get-data-table-m', 'BACKOFFICE\PKM\FaktorPKMTokoController@getDataTableM')->name('get-data-table-m');
                Route::get('/get-data-detail', 'BACKOFFICE\PKM\FaktorPKMTokoController@getDataDetail')->name('get-data-detail');
                Route::post('/insert-plu', 'BACKOFFICE\PKM\FaktorPKMTokoController@insertPLU');
            });
        });

        Route::prefix('/adjustment-stock-cmo')->group(function () {
            Route::get('/', 'BACKOFFICE\AdjustmentStockCMOController@index');
            Route::get('/get-data-lov-ba', 'BACKOFFICE\AdjustmentStockCMOController@getDataLovBA');
            Route::get('/get-data-lov-plu', 'BACKOFFICE\AdjustmentStockCMOController@getDataLovPLU');
            Route::get('/check-plu', 'BACKOFFICE\AdjustmentStockCMOController@checkPLU');
            Route::get('/get-data-ba', 'BACKOFFICE\AdjustmentStockCMOController@getDataBA');
            Route::get('/get-new-no-ba', 'BACKOFFICE\AdjustmentStockCMOController@getNewNoBA');
            Route::get('/check-qty-ba', 'BACKOFFICE\AdjustmentStockCMOController@checkQtyBA');
            Route::post('/process-ba', 'BACKOFFICE\AdjustmentStockCMOController@processBA');
            Route::get('/print-ba', 'BACKOFFICE\AdjustmentStockCMOController@printBA');
            Route::post('/cancel-ba', 'BACKOFFICE\AdjustmentStockCMOController@cancelBA');
            Route::post('/process-adjust', 'BACKOFFICE\AdjustmentStockCMOController@processAdjust');
            Route::get('/print-list', 'BACKOFFICE\AdjustmentStockCMOController@printList');
        });

        /*Leo*/
        Route::prefix('/cetak-register')->group(function () {
            Route::get('/', 'BACKOFFICE\CETAKREGISTER\CetakRegisterController@index');
            Route::get('/print', 'BACKOFFICE\CETAKREGISTER\CetakRegisterController@print');
        });

        /*Denni*/
        Route::prefix('/cetak-dokumen')->group(function () {
            Route::get('/', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@index');
            Route::get('/showData', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@showData');
            Route::post('/CSVeFaktur', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@CSVeFaktur');
            Route::post('/cetak', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@cetak');
            Route::get('/print-doc', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@PRINT_DOC');
            Route::get('/download', 'BACKOFFICE\CETAKDOKUMEN\CetakDokumenController@downloadFile');
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

        /* Steven Leo */
        Route::prefix('virtual-stock-cmo')->group(function () {
            Route::get('/', 'BACKOFFICE\VirtualStockCmoController@index');
            Route::post('/getdiv', 'BACKOFFICE\VirtualStockCmoController@GetDiv');
            Route::post('/getdept', 'BACKOFFICE\VirtualStockCmoController@GetDept');
            Route::post('/getkat', 'BACKOFFICE\VirtualStockCmoController@GetKat');
            Route::post('/getsupp', 'BACKOFFICE\VirtualStockCmoController@getSupp');
            Route::get('/get-supplier', 'BACKOFFICE\VirtualStockCmoController@getSupplier');
            Route::post('/get-data-supplier', 'BACKOFFICE\VirtualStockCmoController@getDataSupplier');
            Route::get('/printPDF', 'BACKOFFICE\VirtualStockCmoController@printPDF');
            Route::get('/printCSV', 'BACKOFFICE\VirtualStockCmoController@printCSV');
        });
    });

    /*Steven Leo*/
    Route::prefix('/bh')->group(function () {
        Route::prefix('/master-barang-hadiah')->group(function () {
            Route::prefix('/barang-hadiah')->group(function () {
                Route::get('/', 'BARANGHADIAH\MASTER\BarangHadiahController@index');
                Route::get('/get-produk', 'BARANGHADIAH\MASTER\BarangHadiahController@getProduk');
                Route::post('/get-data-produk', 'BARANGHADIAH\MASTER\BarangHadiahController@getDataProduk');
                Route::get('/get-card-produk', 'BARANGHADIAH\MASTER\BarangHadiahController@getCardProduk');
                Route::post('/convert-barang-dagangan', 'BARANGHADIAH\MASTER\BarangHadiahController@convertBarangDagangan');
            });
        });
        Route::prefix('/laporan-barang-promosi')->group(function () {
            Route::get('/', 'BARANGHADIAH\LaporanBarangPromosiController@index');
            Route::get('/check-date', 'BARANGHADIAH\LaporanBarangPromosiController@checkDate');
            Route::get('/print-early', 'BARANGHADIAH\LaporanBarangPromosiController@printEarlyData');
            Route::get('/print-now', 'BARANGHADIAH\LaporanBarangPromosiController@printNowData');
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
        Route::prefix('/harga-promosi')->group(function () {
            //Harga Promosi (IGR_TAB_HRGPROMO) (ryanOrder = 33)
            Route::get('/', 'TABEL\HargaPromosiController@index');
            Route::get('/tabel-main', 'TABEL\HargaPromosiController@ModalMain');
            Route::get('/modal-plu', 'TABEL\HargaPromosiController@ModalPlu');
            Route::get('/check-plu', 'TABEL\HargaPromosiController@CheckPlu');
            Route::get('/print', 'TABEL\HargaPromosiController@print');
        });
        /*Ryan*/
        //Standarized Path (RYAN)
        Route::prefix('/super-promo')->group(function () {
            //SUPER Promosi (IGR_TAB_SUPERPROMO) (ryanOrder = 34)
            Route::get('/', 'TABEL\SuperPromoController@index');
            Route::get('/check-plu', 'TABEL\SuperPromoController@checkPlu');
            Route::post('/save', 'TABEL\SuperPromoController@save');
            Route::get('/get-table', 'TABEL\SuperPromoController@getTable');
        });
        /*Ryan*/
        Route::prefix('/total-pembayaran-voucher')->group(function () {
            //Total Pembayaran Voucher (IGR_TAB_BYRVCH) (ryanOrder = 35)
            Route::get('/', 'TABEL\TabelPembayaranVoucherController@index');
            Route::get('/get-supplier', 'TABEL\TabelPembayaranVoucherController@GetSupp');
            Route::get('/get-singkatan', 'TABEL\TabelPembayaranVoucherController@GetSingkatan');
            Route::get('/check-voucher', 'TABEL\TabelPembayaranVoucherController@CheckVoucher');
            Route::get('/check-db-table', 'TABEL\TabelPembayaranVoucherController@CheckDBTable');
            Route::post('/save', 'TABEL\TabelPembayaranVoucherController@Save');
            Route::post('/hapus', 'TABEL\TabelPembayaranVoucherController@Delete');
        });
        /*Ryan*/
        Route::prefix('/tipe-rak-barang')->group(function () {
            //Tipe Rak Barang (ryanOrder = 36)
            Route::get('/', 'TABEL\TipeRakBarangController@index');
            Route::post('/load-data', 'TABEL\TipeRakBarangController@loadData');
            Route::post('/hapus', 'TABEL\TipeRakBarangController@hapus');
            Route::post('/save', 'TABEL\TipeRakBarangController@save');
        });

        /*Ryan*/
        //Standarized Path (RYAN)
        Route::prefix('/hadiah-transaksi')->group(function () {
            Route::prefix('/hadiah-per-item-barang')->group(function () {
                //hadiah per item (IGR_TAB_HDHITEM) (ryanOrder = 31)
                Route::get('/', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahPerItemBarangController@index');
                Route::get('/modal-plu', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahPerItemBarangController@ModalPlu');
                Route::get('/modal-hadiah', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahPerItemBarangController@ModalHadiah');
                Route::get('/modal-history', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahPerItemBarangController@ModalHistory');
                Route::get('/get-history', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahPerItemBarangController@GetHistory');
                Route::get('/check-plu', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahPerItemBarangController@CheckPlu');
                Route::post('/save', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahPerItemBarangController@SaveData');
            });

            Route::prefix('/hadiah-untuk-gabungan-item')->group(function () {
                //hadiah untuk gabungan item (IGR_TAB_HDHGAB) (ryanOrder = 32)
                Route::get('/', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@index');
                Route::get('/modal-gabungan', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@ModalGabungan');
                Route::get('/modal-hadiah', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@ModalHadiah');
                Route::get('/get-detail', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@GetDetail');
                Route::post('/get-new', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@GetNew');
                Route::get('/modal-plu', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@ModalPlu');
                Route::get('/modal-supplier', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@ModalSupp');
                Route::get('/check-plu', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@CheckPlu');
                Route::get('/choose-merk', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@ChooseMerk');
                Route::get('/choose-supplier', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@ChooseSupplier');
                Route::post('/save', 'TABEL\SETTINGHADIAHPADATRANSAKSIKASIR\HadiahUntukGabunganItemController@SaveData');
            });
        });

        /*Ryan*/
        //Standarized Path (RYAN)
        Route::prefix('/plu-timbangan')->group(function () {
            //TABLE - Table Plu Timbangan (IGR_TAB_PLU_TMBNGN) (ryanOrder = 19)
            Route::get('/', 'TABEL\PluTimbanganController@index');
            Route::get('/start', 'TABEL\PluTimbanganController@StartNew');
            Route::get('/plu-modal', 'TABEL\PluTimbanganController@LovPlu');
            Route::get('/get-plu', 'TABEL\PluTimbanganController@GetPlu');
            Route::get('/save', 'TABEL\PluTimbanganController@Save');
            //Route::get('/prehapus','TABEL\PluTimbanganController@preHapus');

            Route::get('/hapus', 'TABEL\PluTimbanganController@Hapus2');
            Route::get('/hapusDir1Txt', 'TABEL\PluTimbanganController@HapusDir1Txt');
            Route::get('/hapusDir2Txt', 'TABEL\PluTimbanganController@HapusDir2Txt');
            Route::get('/hapusDir3Txt', 'TABEL\PluTimbanganController@HapusDir3Txt');

            Route::get('/kode-modal', 'TABEL\PluTimbanganController@LovKode');
            Route::get('/get-kode', 'TABEL\PluTimbanganController@GetKode');
            Route::get('/check-share-directory', 'TABEL\PluTimbanganController@ShareDir');
            Route::get('/check-directory', 'TABEL\PluTimbanganController@CheckDir');
            Route::get('/transfer', 'TABEL\PluTimbanganController@Transfer');
            Route::get('/print', 'TABEL\PluTimbanganController@Print');
            Route::get('/debug', 'TABEL\PluTimbanganController@Debug');

            Route::get('/transferDir1', 'TABEL\PluTimbanganController@TransferDir1');
            Route::get('/transferDir1Txt', 'TABEL\PluTimbanganController@TransferDir1Txt');
            Route::get('/transferDir1Csv', 'TABEL\PluTimbanganController@TransferDir1Csv');

            Route::get('/transferDir2', 'TABEL\PluTimbanganController@TransferDir2');
            Route::get('/transferDir2Txt', 'TABEL\PluTimbanganController@TransferDir2Txt');
            Route::get('/transferDir2Csv', 'TABEL\PluTimbanganController@TransferDir2Csv');

            Route::get('/transferDir3', 'TABEL\PluTimbanganController@TransferDir3');
            Route::get('/transferDir3Txt', 'TABEL\PluTimbanganController@TransferDir3Txt');
            Route::get('/transferDir3Csv', 'TABEL\PluTimbanganController@TransferDir3Csv');
        });

        /*Leo*/
        Route::prefix('/plunoncharge')->group(function () {
            Route::get('/', 'TABEL\PLUNonChargeController@index');
            Route::get('/get-data', 'TABEL\PLUNonChargeController@getData');
            Route::get('/get-lov-plu', 'TABEL\PLUNonChargeController@getLovPLU');
            Route::get('/get-plu-detail', 'TABEL\PLUNonChargeController@getPLUDetail');
            Route::post('/add-plu', 'TABEL\PLUNonChargeController@addPLU');
            Route::post('/delete-plu', 'TABEL\PLUNonChargeController@deletePLU');
            Route::get('/print', 'TABEL\PLUNonChargeController@print');
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
            Route::get('/print', 'TABEL\PLUNonRefundController@print');
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
            Route::post('/add-data', 'TABEL\MonitoringProdukController@addData');
            Route::post('/delete-data', 'TABEL\MonitoringProdukController@deleteData');
        });

        /*Leo*/
        Route::prefix('/monitoring-member')->group(function () {
            Route::get('/', 'TABEL\MonitoringMemberController@index');
            Route::get('/get-lov-monitoring', 'TABEL\MonitoringMemberController@getLovMonitoring');
            Route::get('/get-monitoring', 'TABEL\MonitoringMemberController@getMonitoring');
            Route::get('/get-lov-member', 'TABEL\MonitoringMemberController@getLOVMember');
            Route::get('/get-member', 'TABEL\MonitoringMemberController@getMember');
            Route::get('/get-data', 'TABEL\MonitoringMemberController@getData');
            Route::get('/print', 'TABEL\MonitoringMemberController@print');
            Route::post('/add-data', 'TABEL\MonitoringMemberController@addData');
            Route::post('/delete-data', 'TABEL\MonitoringMemberController@deleteData');
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
        Route::prefix('/monitoring-supplier')->group(function () {
            Route::get('/', 'TABEL\MonitoringSupplierController@index');
            Route::get('/cek-data', 'TABEL\MonitoringSupplierController@cekData');
            Route::get('/get-lov-monitoring', 'TABEL\MonitoringSupplierController@getLovMonitoring');
            Route::get('/get-monitoring', 'TABEL\MonitoringSupplierController@getMonitoring');
            Route::get('/get-lov-supplier', 'TABEL\MonitoringSupplierController@getLovSupplier');
            Route::get('/get-data', 'TABEL\MonitoringSupplierController@getData');
            Route::get('/print', 'TABEL\MonitoringSupplierController@print');
            Route::post('/tambah', 'TABEL\MonitoringSupplierController@tambah');
            Route::post('/hapus', 'TABEL\MonitoringSupplierController@hapus');
        });
        //Denni
        Route::prefix('/monitoring-sales-dan-stock')->group(function () {
            Route::get('/', 'TABEL\MonitoringSalesDanStockController@index');
            Route::get('/get-data', 'TABEL\MonitoringSalesDanStockController@getData');
            Route::get('/get-lov-monitoring', 'TABEL\MonitoringSalesDanStockController@getLovMonitoring');
            Route::get('/get-lov-plu', 'TABEL\MonitoringSalesDanStockController@getLovPLU');
            Route::get('/get-data-deskripsi', 'TABEL\MonitoringSalesDanStockController@getDataDeskripsi');
            Route::get('/print', 'TABEL\MonitoringSalesDanStockController@print');
        });
        /*Denni*/
        Route::prefix('/jenis-rak-barang')->group(function () {
            Route::get('/', 'TABEL\JenisRakBarangController@index');
            Route::get('/get-data', 'TABEL\JenisRakBarangController@getData');
            Route::get('/get-lov', 'TABEL\JenisRakBarangController@getLov');
            Route::get('/get-next-kode-rak', 'TABEL\JenisRakBarangController@getNextKodeRak');
            Route::get('/get-prev-kode-rak', 'TABEL\JenisRakBarangController@getPrevKodeRak');
            Route::get('/get-lov', 'TABEL\JenisRakBarangController@getLov');
            Route::post('/hapus', 'TABEL\JenisRakBarangController@hapus');
            Route::post('/simpan', 'TABEL\JenisRakBarangController@simpan');
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
            Route::get('/clone-menu', 'ADMINISTRATION\AccessController@cloneMenu');
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
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\ParetoSalesMemberController@index')->middleware('CheckLogin');
                Route::get('/get-lov-member', 'FRONTOFFICE\LAPORANKASIR\ParetoSalesMemberController@getLovMember')->middleware('CheckLogin');
                Route::get('/cetak-laporan', 'FRONTOFFICE\LAPORANKASIR\ParetoSalesMemberController@cetakLaporan')->middleware('CheckLogin');
            });

            /*  Denni */
            Route::prefix('/rekap-member-status-kartu-aktif')->group(function () {
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\RekapMemberStatusKartuAktifController@index');
                Route::get('/cetak', 'FRONTOFFICE\LAPORANKASIR\RekapMemberStatusKartuAktifController@cetak');
            });
            /*  Denni */
            Route::prefix('/daftar-member-tidak-aktif')->group(function () {
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\DaftarMemberTidakAktifController@index');
                Route::get('/get-lov-member', 'FRONTOFFICE\LAPORANKASIR\DaftarMemberTidakAktifController@lovMember');
                Route::get('/cetak', 'FRONTOFFICE\LAPORANKASIR\DaftarMemberTidakAktifController@cetak');
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
                Route::get('/cetak-shopeepay', 'FRONTOFFICE\LAPORANKASIR\ActualController@cetakShopeepay');
                Route::get('/process-cashback', 'FRONTOFFICE\LAPORANKASIR\ActualController@cashback');
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
                Route::get('/downloadcsv/{date1}/{date2}/{event1}/{event2}', 'FRONTOFFICE\LAPORANKASIR\ceiController@downloadCsv');
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
                Route::get('/printdocumentmenu6', 'FRONTOFFICE\LAPORANKASIR\penjualanController@printDocumentMenu6');
            });

            Route::prefix('/laporan-transaksi-bkp-btkp')->group(function () {
                Route::get('/', 'FRONTOFFICE\LAPORANKASIR\LaporanTransaksiBKPBTKPController@index');
                Route::get('/print', 'FRONTOFFICE\LAPORANKASIR\LaporanTransaksiBKPBTKPController@print');
            });
        });

        Route::prefix('/laporan-sales-per-divisi-departemen')->group(function () {
            Route::get('/', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerDivDepController@index');
            Route::get('/get-data', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerDivDepController@getData');
            Route::get('/get-data-sub-outlet', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerDivDepController@getDataSubOutlet');
            Route::get('/cetak', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerDivDepController@cetak');
        });

        Route::prefix('/laporan-sales-per-departemen-kategori')->group(function () {
            Route::get('/', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerDepKatController@index');
            Route::get('/get-data', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerDepKatController@getData');
            Route::get('/get-data-sub-outlet', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerDepKatController@getDataSubOutlet');
            Route::get('/get-data-departement', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerDepKatController@getDataDepartement');
            Route::get('/cetak', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerDepKatController@cetak');
        });

        Route::prefix('/laporan-sales-per-kategori-produk')->group(function () {
            Route::get('/', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerKatProdController@index');
            Route::get('/get-data', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerKatProdController@getData');
            Route::get('/get-data-sub-outlet', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerKatProdController@getDataSubOutlet');
            Route::get('/get-data-departement', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerKatProdController@getDataDepartement');
            Route::get('/get-data-kategori', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerKatProdController@getDataKategori');
            Route::get('/cetak', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerKatProdController@cetak');
        });

        Route::prefix('/laporan-sales-per-produk-member')->group(function () {
            Route::get('/', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerProdMemController@index');
            Route::get('/lov-plu', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerProdMemController@lovPLU');
            Route::get('/get-data', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerProdMemController@getData');
            Route::get('/get-data-sub-outlet', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerProdMemController@getDataSubOutlet');
            Route::get('/get-data-departement', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerProdMemController@getDataDepartement');
            Route::get('/get-data-kategori', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerProdMemController@getDataKategori');
            Route::get('/cetak', 'FRONTOFFICE\LAPORANSALESPERDIVDEPKAT\LaporanSalesPerProdMemController@cetak');
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
            Route::post('/status', 'FRONTOFFICE\PromosiHoKeCabController@Status');
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

        Route::prefix('/faktur-pajak-standard')->group(function () {
            Route::get('/', 'FRONTOFFICE\FakturPajakStandardController@index');
            Route::post('/create-csv', 'FRONTOFFICE\FakturPajakStandardController@createCSV');
            Route::get('/get-csv', 'FRONTOFFICE\FakturPajakStandardController@getCSV');
        });

        /*Leo*/
        Route::prefix('/laporan-evaluasi-sales-member')->group(function () {
            Route::get('/', 'FRONTOFFICE\LaporanEvaluasiSalesMemberController@index');
            Route::get('/view-report', 'FRONTOFFICE\LaporanEvaluasiSalesMemberController@viewReport');
            Route::get('/print', 'FRONTOFFICE\LaporanEvaluasiSalesMemberController@print');
            Route::get('/get-csv', 'FRONTOFFICE\LaporanEvaluasiSalesMemberController@getCSV');
        });

        /*Leo*/
        Route::prefix('/stock-barang-kosong-per-periode-dsi')->group(function () {
            Route::get('/', 'FRONTOFFICE\StockBarangKosongPerPeriodeDSIController@index');
            Route::get('/view-report', 'FRONTOFFICE\StockBarangKosongPerPeriodeDSIController@viewReport');
            Route::get('/export-pdf', 'FRONTOFFICE\StockBarangKosongPerPeriodeDSIController@exportPDF');
            Route::get('/export-csv', 'FRONTOFFICE\StockBarangKosongPerPeriodeDSIController@exportCSV');
        });
    });

    Route::prefix('/monitoring')->group(function () {
        /*Denni*/
        Route::prefix('/monitoring-plu-eis')->group(function () {
            Route::get('/', 'MONITORING\MonitoringPLUEISController@index')->name('mtrpluigr');
            Route::get('/view-mtr', 'MONITORING\MonitoringPLUEISController@viewListMtrPlu');
            Route::get('/view-detail', 'MONITORING\MonitoringPLUEISController@viewListDetail');
            Route::post('/search-plu', 'MONITORING\MonitoringPLUEISController@searchPlu');
            Route::post('/save', 'MONITORING\MonitoringPLUEISController@saveNewMtr');
            Route::post('/delete', 'MONITORING\MonitoringPLUEISController@deleteListMonitoring');
            Route::post('/edit', 'MONITORING\MonitoringPLUEISController@editDataMonitoring');
            Route::post('/update', 'MONITORING\MonitoringPLUEISController@updateDataMonitoring');
            Route::post('/prosesexcelplu', 'MONITORING\MonitoringPLUEISController@prosesExcelPlu');
        });
    });

    Route::prefix('/omi')->group(function () {
        /*  Jefri */
        Route::prefix('/proses-bkl')->group(function () {
            Route::get('/', 'OMI\ProsesBKLDalamKotaController@index');
            Route::post('/proses-file', 'OMI\ProsesBKLDalamKotaController@prosesFile');
            Route::get('/cetak-laporan', 'OMI\ProsesBKLDalamKotaController@cetakLaporan');
        });

        Route::prefix('/transfer-order-dari-omi-idm')->group(function () {
            Route::prefix('/kredit-limit-dan-monitoring-pb-omi')->group(function () {
                Route::get('/', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@index');
                Route::get('/get-lov-kode-omi', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getLovKodeOMI');
                Route::post('/get-data-omi', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getDataOMI');
                Route::get('/get-data-master-kredit-limit-omi', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getDataMasterKreditLimitOMI');
                Route::get('/get-monitoring-data-pb-tolakan', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getMonitoringDataPBTolakan');
                Route::post('/get-data-top', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@getDataTop');
                Route::post('/simpan', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@simpan');
                Route::post('/submit-log-non-top', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@submitLogNonTop');
                Route::post('/submit-log', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@submitLog');
                Route::post('/proses-tolakan', 'OMI\TRANSFERORDERDARIOMIIDM\KreditLimitDanMonitoringPBOMIController@prosesTolakan');
            });

            Route::prefix('/proses-tolakan-clo-pb-omi')->group(function () {
                Route::get('/', 'OMI\TRANSFERORDERDARIOMIIDM\ProsesTolakanCLOPBOMIController@index');
                Route::get('/get-data', 'OMI\TRANSFERORDERDARIOMIIDM\ProsesTolakanCLOPBOMIController@getData');
                Route::post('/save-data', 'OMI\TRANSFERORDERDARIOMIIDM\ProsesTolakanCLOPBOMIController@saveData');
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

            /*  Jefri */
            Route::prefix('/reprint-bkl')->group(function () {
                Route::get('/', 'OMI\LAPORAN\ReprintBKLController@index');
                Route::post('/cek-omi', 'OMI\LAPORAN\ReprintBKLController@checkKodeOmi');
                Route::post('/cek-nomor', 'OMI\LAPORAN\ReprintBKLController@cekNomorBukti');
                Route::get('/get-lov-tokoomi', 'OMI\LAPORAN\ReprintBKLController@getDataLovTokoOMI');
                Route::get('/get-lov', 'OMI\LAPORAN\ReprintBKLController@getDataLov');
                Route::get('/cetak-laporan', 'OMI\LAPORAN\ReprintBKLController@cetakLaporan');
            });


            Route::prefix('/register-ppr')->group(function () {
                Route::get('/', 'OMI\LAPORAN\LaporanRegisterPPRController@index');
                Route::get('/lov-nodoc', 'OMI\LAPORAN\LaporanRegisterPPRController@lovNodoc');
                Route::get('/cetak', 'OMI\LAPORAN\LaporanRegisterPPRController@cetak');
            });
            Route::prefix('/rekapitulasi-register-ppr')->group(function () {
                Route::get('/', 'OMI\LAPORAN\LaporanRekapitulasiRegisterPPRController@index');
                Route::get('/lov-nodoc', 'OMI\LAPORAN\LaporanRekapitulasiRegisterPPRController@lovNodoc');
                Route::get('/lov-member', 'OMI\LAPORAN\LaporanRekapitulasiRegisterPPRController@lovMember');
                Route::get('/cetak', 'OMI\LAPORAN\LaporanRekapitulasiRegisterPPRController@cetak');
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
            Route::prefix('/laporan-register-barang-retur')->group(function () {
                //LAPORAN REGISTER BARANG RETUR (ryanOrder = 28)
                Route::get('/', 'OMI\LAPORAN\LaporanRegisterBarangReturController@index');
                Route::get('/cetak', 'OMI\LAPORAN\LaporanRegisterBarangReturController@cetak');
            });
            /*Ryan*/
            Route::prefix('/laprincislvpb')->group(function () {
                //LAPORAN RINCI SLV PB (ryanOrder = 29)
                Route::get('/', 'OMI\LAPORAN\laprincislvpbController@index');
                Route::get('/gettag', 'OMI\LAPORAN\laprincislvpbController@tagModal');
                Route::get('/cetak', 'OMI\LAPORAN\laprincislvpbController@cetak');
            });
            /*Ryan*/
            Route::prefix('/laporan-rekap-service-level-sales-thd-pb')->group(function () {
                //LAPORAN SVL SLS PB (ryanOrder = 30)
                Route::get('/', 'OMI\LAPORAN\LaporanRekapServiceLevelSalesThdPBController@index');
                Route::get('/get-pb', 'OMI\LAPORAN\LaporanRekapServiceLevelSalesThdPBController@pbModal');
                Route::get('/cetak', 'OMI\LAPORAN\LaporanRekapServiceLevelSalesThdPBController@cetak');
            });

            /*Leo*/
            Route::prefix('/cetak-faktur-pajak')->group(function () {
                Route::get('/', 'OMI\LAPORAN\CetakFakturPajakController@index');
                Route::get('/get-data', 'OMI\LAPORAN\CetakFakturPajakController@getData');
                Route::get('/print', 'OMI\LAPORAN\CetakFakturPajakController@print');
            });
        });
        /*Ryan*/
        Route::prefix('/perubahan-status-omi-ptkp-to-pkp')->group(function () {
            //IGR_BO_RUBAHSTATUSOMI (ryanOrder = 26)
            Route::get('/', 'OMI\PerubahanStatusOmiPtkpToPkpController@index');
            Route::get('/new-form-instance', 'OMI\PerubahanStatusOmiPtkpToPkpController@newFormInstance');
            Route::get('/modal-ptkp', 'OMI\PerubahanStatusOmiPtkpToPkpController@modalPTKP');
            Route::get('/choose-ptkp', 'OMI\PerubahanStatusOmiPtkpToPkpController@choosePTKP');
            Route::get('/modal-pkp', 'OMI\PerubahanStatusOmiPtkpToPkpController@modalPKP');
            Route::get('/choose-pkp', 'OMI\PerubahanStatusOmiPtkpToPkpController@choosePKP');
            Route::get('/proses-data', 'OMI\PerubahanStatusOmiPtkpToPkpController@prosesData');
            Route::get('/cetak', 'OMI\PerubahanStatusOmiPtkpToPkpController@cetak');
        });
    });
});
