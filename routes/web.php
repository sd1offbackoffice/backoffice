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
Route::get('/logout', 'Auth\loginController@logout')->middleware('CheckLogin');



/******** Template ********/
Route::get('/template/index',   'TemplateController@index')->middleware('CheckLogin');
Route::get('/template/datamodal',   'TemplateController@dataModal')->middleware('CheckLogin');


/******** Arie ********/
// BACK OFFICE / PENGELUARAN /INPUT
Route::get('/bo/transaksi/pengeluaran/input/index', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\inputController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/pengeluaran/input/getDataRetur', 'BACKOFFICE\TRANSAKSI\PENGELUARAN\inputController@getDataRetur')->middleware('CheckLogin');

Route::get('/mst/test', 'MASTER\barcodeController@testdenni')->middleware('CheckLogin');

/******** Denni ********/
//MST_PERUSAHAAN
Route::get('/mstperusahaan/index', 'MASTER\perusahaanController@index')->middleware('CheckLogin');
//MST_BARCODE
Route::get('/mstbarcode/index', 'MASTER\barcodeController@index')->middleware('CheckLogin');
//MST_KATEGORITOKO
Route::get('/mstkategoritoko/index', 'MASTER\kategoritokoController@index')->middleware('CheckLogin');
//MST_APPROVAL
Route::get('/mstapproval/index', 'MASTER\approvalController@index')->middleware('CheckLogin');
//MST_JENISITEM
Route::get('/mstjenisitem/index', 'MASTER\jenisItemController@index')->middleware('CheckLogin');
//MST_KUBIKASIPLANO
Route::get('/mstkubikasiplano/index', 'MASTER\kubikasiPlanoController@index')->middleware('CheckLogin');
//IGR_BO_INQUERY (INFORMASI DAN HISTORY PRODUK)
Route::get('/mstinformasihistoryproduct/index', 'MASTER\informasiHistoryProductController@index')->middleware('CheckLogin');
//ADMINISTRATION (USER)
Route::get('/admuser/index', 'ADMINISTRATION\userController@index')->middleware('CheckLogin');
//PB MANUAL
Route::get('/bopbmanual/index', 'BACKOFFICE\PBManualController@index')->middleware('CheckLogin');
//Pengeluaran
Route::middleware(['CheckLogin'])->group(function () {
    Route::prefix('/bo')->group(function () {
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
        });
    });

});
/******** Leo ********/
/*MASTER SUPPLIER*/
Route::get('/mstsupplier/index', 'MASTER\supplierController@index')->middleware('CheckLogin');
Route::get('/mstsupplier/lov', 'MASTER\supplierController@lov')->middleware('CheckLogin');
Route::get('/mstsupplier/lov_select', 'MASTER\supplierController@lov_select')->middleware('CheckLogin');
Route::get('/mstsupplier/lov_search', 'MASTER\supplierController@lov_search')->middleware('CheckLogin');

/*MASTER DEPARTEMENT*/
Route::get('/mstdepartement/index', 'MASTER\departementController@index')->middleware('CheckLogin');
Route::get('/mstdepartement/divisi_select', 'MASTER\departementController@divisi_select')->middleware('CheckLogin');

/*MASTER DIVISI*/
Route::get('/mstdivisi/index', 'MASTER\divisiController@index')->middleware('CheckLogin');

/*MASTER KATEGORI BARANG*/
Route::get('/mstkategoribarang/index', 'MASTER\kategoriBarangController@index')->middleware('CheckLogin');
Route::get('/mstkategoribarang/departement_select', 'MASTER\kategoriBarangController@departement_select')->middleware('CheckLogin');

/*MASTER HARGA BELI*/
Route::get('/msthargabeli/index', 'MASTER\hargaBeliController@index')->middleware('CheckLogin');
Route::get('/msthargabeli/lov_search', 'MASTER\hargaBeliController@lov_search')->middleware('CheckLogin');
Route::get('/msthargabeli/lov_select', 'MASTER\hargaBeliController@lov_select')->middleware('CheckLogin');

/*MASTER MEMBER*/
Route::get('/mstmember/index', 'MASTER\memberController@index')->middleware('CheckLogin')->middleware('CheckLogin');
Route::get('/mstmember/lov_member_search', 'MASTER\memberController@lov_member_search')->middleware('CheckLogin');
Route::get('/mstmember/lov_kodepos_search', 'MASTER\memberController@lov_kodepos_search')->middleware('CheckLogin');
Route::get('/mstmember/lov_member_select', 'MASTER\memberController@lov_member_select')->middleware('CheckLogin');
Route::get('/mstmember/lov_kodepos_select', 'MASTER\memberController@lov_kodepos_select')->middleware('CheckLogin');
Route::get('/mstmember/set_status_member', 'MASTER\memberController@set_status_member')->middleware('CheckLogin');
Route::post('/mstmember/check_password', 'MASTER\memberController@check_password')->middleware('CheckLogin');
Route::post('/mstmember/update_member', 'MASTER\memberController@update_member')->middleware('CheckLogin');

Route::post('/mstmember/export_crm', 'MASTER\memberController@export_crm')->middleware('CheckLogin');
Route::post('/mstmember/save_quisioner', 'MASTER\memberController@save_quisioner')->middleware('CheckLogin');
Route::post('/mstmember/hapus_member', 'MASTER\memberController@hapus_member')->middleware('CheckLogin');

/*BACK OFFICE - UPLOAD DAN MONITORING KKEI TOKO IGR*/
Route::get('/bokirimkkei/index', 'BACKOFFICE\KirimKKEIController@index')->middleware('CheckLogin');
Route::post('/bokirimkkei/upload', 'BACKOFFICE\KirimKKEIController@upload')->middleware('CheckLogin');
Route::post('/bokirimkkei/refresh', 'BACKOFFICE\KirimKKEIController@refresh')->middleware('CheckLogin');

/*BACK OFFICE - KERTAS KERJA KEBUTUHAN TOKO IGR*/
Route::get('/bokkei/index', 'BACKOFFICE\KKEIController@index')->middleware('CheckLogin');
Route::post('/bokkei/get_detail_produk', 'BACKOFFICE\KKEIController@get_detail_produk')->middleware('CheckLogin');
Route::post('/bokkei/get_detail_kkei', 'BACKOFFICE\KKEIController@get_detail_kkei')->middleware('CheckLogin');
Route::post('/bokkei/save', 'BACKOFFICE\KKEIController@save')->middleware('CheckLogin');
Route::post('/bokkei/laporan', 'BACKOFFICE\KKEIController@laporan')->middleware('CheckLogin');
Route::get('/bokkei/laporan', 'BACKOFFICE\KKEIController@laporan_view')->middleware('CheckLogin');

Route::get('/bokkei/test', 'BACKOFFICE\KKEIController@test');





Route::middleware(['CheckLogin'])->group(function () {
    Route::prefix('/master')->group(function(){
        /*MASTER LOKASI*/
        Route::prefix('/lokasi')->group(function(){
            Route::get('/', 'MASTER\lokasiController@index');
            Route::post('/lov_rak_search', 'MASTER\lokasiController@lov_rak_search');
            Route::post('/lov_rak_select', 'MASTER\lokasiController@lov_rak_select');
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
    });

    Route::prefix('/bo')->group(function () {
        Route::prefix('/pb')->group(function(){
            /*BACK OFFICE - REORDER PB GO*/
            Route::prefix('reorder-pb-go')->group(function(){
                Route::get('/', 'BACKOFFICE\ReorderPBGOController@index');
                Route::post('/proses_go', 'BACKOFFICE\ReorderPBGOController@proses_go');
                Route::get('/cetak_tolakan', 'BACKOFFICE\ReorderPBGOController@cetak_tolakan');
            });

            /*BACK OFFICE - CETAK TOLAKAN PB*/
            Route::prefix('/cetak-tolakan-pb')->group(function(){
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

        Route::prefix('/transaksi')->group(function () {
            Route::prefix('/penyesuaian')->group(function () {
                Route::prefix('/input')->group(function(){
                    Route::get('/','BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@index');
                    Route::post('/lov_plu_search', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@lov_plu_search');
                    Route::post('/plu_select', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@plu_select');
                    Route::post('/doc_select', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_select');
                    Route::post('/doc_new', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_new');
                    Route::post('/doc_save', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_save');
                    Route::post('/doc_delete', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InputPenyesuaianController@doc_delete');
                });

                Route::prefix('cetak')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@index');
                    Route::post('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@getData');
                    Route::post('/store-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@storeData');
                    Route::get('/laporan', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@laporan');
                    Route::get('/tes', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\CetakPenyesuaianController@tes');
                });

                Route::prefix('inquerympp')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InqueryMPPController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InqueryMPPController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InqueryMPPController@getData');
                    Route::get('/get-detail', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\InqueryMPPController@getDetail');
                });

                Route::prefix('pembatalanmpp')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PembatalanMPPController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PembatalanMPPController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PembatalanMPPController@getData');
                    Route::post('/batal', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PembatalanMPPController@batal');
                });

                Route::prefix('perubahanplu')->group(function () {
                    Route::get('/', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@index');
                    Route::get('/get-data-lov', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@getDataLov');
                    Route::get('/get-data', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@getData');
                    Route::post('/proses', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@proses');
                    Route::get('/laporan', 'BACKOFFICE\TRANSAKSI\PENYESUAIAN\PerubahanPLUController@laporan');
                });
            });

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
                    Route::get('/cetak','BACKOFFICE\TRANSAKSI\KIRIMCABANG\SJPacklistController@cetak');
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
        });
        Route::prefix('/proses')->group(function() {
            Route::prefix('/konversi')->group(function(){
                Route::get('/','BACKOFFICE\PROSES\KonversiController@index');
                Route::get('/get-data-lov-plu-utuh','BACKOFFICE\PROSES\KonversiController@getDataLovPluUtuh');
                Route::get('/get-data-lov-plu-mix','BACKOFFICE\PROSES\KonversiController@getDataLovPluMix');
                Route::get('/get-data-lov-nodoc','BACKOFFICE\PROSES\KonversiController@getDataLovNodoc');
                Route::get('/get-data-plu-olahan','BACKOFFICE\PROSES\KonversiController@getDataPluOlahan');
                Route::post('/konversi-utuh-olahan','BACKOFFICE\PROSES\KonversiController@konversiUtuhOlahan');
                Route::post('/konversi-olahan-mix','BACKOFFICE\PROSES\KonversiController@konversiOlahanMix');
                Route::get('/print-bukti','BACKOFFICE\PROSES\KonversiController@printBukti');
                Route::get('/print-laporan-rekap','BACKOFFICE\PROSES\KonversiController@printLaporanRekap');
                Route::get('/print-laporan-detail','BACKOFFICE\PROSES\KonversiController@printLaporanDetail');
            });
            Route::prefix('/hitungulangstock')->group(function(){
                Route::get('/','BACKOFFICE\PROSES\HitungUlangStockController@index');
                Route::get('/get-data-lov','BACKOFFICE\PROSES\HitungUlangStockController@getDataLov');
                Route::post('/hitung-ulang-stock','BACKOFFICE\PROSES\HitungUlangStockController@ProsesHitungUlangStock');
                Route::post('/hitung-ulang-point','BACKOFFICE\PROSES\HitungUlangStockController@ProsesHitungUlangPoint');
                Route::post('/hapus-point','BACKOFFICE\PROSES\HitungUlangStockController@ProsesHapusPoint');
                Route::get('/cetak','BACKOFFICE\PROSES\HitungUlangStockController@PrintHapus');
            });
            Route::prefix('/monthend')->group(function(){
                Route::get('/','BACKOFFICE\PROSES\MonthEndController@index');
                Route::post('/proses','BACKOFFICE\PROSES\MonthEndController@proses');
                Route::post('/proses-hitung-stok','BACKOFFICE\PROSES\MonthEndController@prosesHitungStock');
                Route::post('/proses-hitung-stok-cmo','BACKOFFICE\PROSES\MonthEndController@prosesHitungStockCMO');
                Route::post('/proses-sales-rekap','BACKOFFICE\PROSES\MonthEndController@prosesSalesRekap');
                Route::post('/proses-sales-lpp','BACKOFFICE\PROSES\MonthEndController@prosesLPP');
                Route::post('/delete-data','BACKOFFICE\PROSES\MonthEndController@deleteData');
                Route::post('/proses-copystock','BACKOFFICE\PROSES\MonthEndController@prosesCopyStock');
                Route::post('/proses-hitung-stok2','BACKOFFICE\PROSES\MonthEndController@prosesHitungStock2');
            });
        });

        Route::prefix('/laporan')->group(function(){
            Route::prefix('/daftar-pembelian')->group(function(){
                Route::get('/','BACKOFFICE\LAPORAN\DaftarPembelianController@index');
                Route::get('/get-data-lov-div','BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovDiv');
                Route::get('/get-data-lov-dep','BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovDep');
                Route::get('/get-data-lov-kat','BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovKat');
                Route::get('/get-data-lov-mtr','BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovMtr');
                Route::get('/get-data-lov-sup','BACKOFFICE\LAPORAN\DaftarPembelianController@getDataLovSup');
                Route::get('/cetak','BACKOFFICE\LAPORAN\DaftarPembelianController@cetak');
            });


            Route::prefix('/penyesuaian')->group(function(){
                Route::get('/','BACKOFFICE\LAPORAN\PenyesuaianController@index');
                Route::get('/get-data-lov-div','BACKOFFICE\LAPORAN\PenyesuaianController@getDataLovDiv');
                Route::get('/get-data-lov-dep','BACKOFFICE\LAPORAN\PenyesuaianController@getDataLovDep');
                Route::get('/get-data-lov-kat','BACKOFFICE\LAPORAN\PenyesuaianController@getDataLovKat');
                Route::get('/cetak','BACKOFFICE\LAPORAN\PenyesuaianController@cetak');
            });

            Route::prefix('/pengiriman')->group(function(){
                Route::get('/','BACKOFFICE\LAPORAN\PengirimanController@index');
                Route::get('/get-data-lov-div','BACKOFFICE\LAPORAN\PengirimanController@getDataLovDiv');
                Route::get('/get-data-lov-dep','BACKOFFICE\LAPORAN\PengirimanController@getDataLovDep');
                Route::get('/get-data-lov-kat','BACKOFFICE\LAPORAN\PengirimanController@getDataLovKat');
                Route::get('/cetak','BACKOFFICE\LAPORAN\PengirimanController@cetak');
            });

            Route::prefix('/penerimaan')->group(function(){
                Route::get('/','BACKOFFICE\LAPORAN\PenerimaanController@index');
                Route::get('/get-data-lov-div','BACKOFFICE\LAPORAN\PenerimaanController@getDataLovDiv');
                Route::get('/get-data-lov-dep','BACKOFFICE\LAPORAN\PenerimaanController@getDataLovDep');
                Route::get('/get-data-lov-kat','BACKOFFICE\LAPORAN\PenerimaanController@getDataLovKat');
                Route::get('/cetak','BACKOFFICE\LAPORAN\PenerimaanController@cetak');
            });
        });

        Route::prefix('/transfer')->group(function(){
            Route::prefix('/po')->group(function(){
               Route::get('/','BACKOFFICE\TRANSFER\TransferPOController@index');
               Route::get('/get-data','BACKOFFICE\TRANSFER\TransferPOController@getData');
               Route::post('/proses-transfer','BACKOFFICE\TRANSFER\TransferPOController@prosesTransfer');
            });

            Route::prefix('/pb-ke-md')->group(function(){
                Route::get('/','BACKOFFICE\TRANSFER\TransferPBkeMDController@index');
                Route::post('/proses-transfer','BACKOFFICE\TRANSFER\TransferPBkeMDController@prosesTransfer');
            });
        });

        Route::prefix('/pkm')->group(function(){
            Route::prefix('/kertas-kerja')->group(function(){
                Route::get('/','BACKOFFICE\PKM\ProsesKertasKerjaPKMController@index');
                Route::get('/get-data-lov-prdcd','BACKOFFICE\PKM\ProsesKertasKerjaPKMController@getLovPrdcd');
                Route::get('/get-data-history','BACKOFFICE\PKM\ProsesKertasKerjaPKMController@getHistory');
                Route::post('/change-pkm','BACKOFFICE\PKM\ProsesKertasKerjaPKMController@changePKM');
                Route::get('/cetak-status-storage','BACKOFFICE\PKM\ProsesKertasKerjaPKMController@cetakStatusStorage');
            });

            Route::prefix('/entry-inquery')->group(function(){
                Route::get('/','BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@index');
                Route::get('/get-lov-prdcd','BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovPrdcd');
                Route::get('/get-lov-divisi','BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovDivisi');
                Route::get('/get-lov-departement','BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovDepartement');
                Route::get('/get-lov-kategori','BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovKategori');
                Route::get('/get-lov-monitoring','BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getLovMonitoring');
                Route::get('/get-detail','BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@getDetail');
                Route::post('/change-pkm','BACKOFFICE\PKM\EntryInqueryKertasKerjaPKMController@changePKM');
            });

            Route::prefix('/monitoring')->group(function(){
                Route::get('/','BACKOFFICE\PKM\MonitoringController@index');
                Route::get('/get-lov-prdcd','BACKOFFICE\PKM\MonitoringController@getLovPrdcd');
                Route::get('/get-lov-prdcd-new','BACKOFFICE\PKM\MonitoringController@getLovPrdcdNew');
                Route::get('/get-data','BACKOFFICE\PKM\MonitoringController@getData');
                Route::get('/get-data-added','BACKOFFICE\PKM\MonitoringController@getDataAdded');
                Route::post('/add-data','BACKOFFICE\PKM\MonitoringController@addData');
                Route::post('/change-pkm','BACKOFFICE\PKM\MonitoringController@changePKM');
                Route::post('/delete-data','BACKOFFICE\PKM\MonitoringController@deleteData');
                Route::get('/print','BACKOFFICE\PKM\MonitoringController@print');
            });
        });

        Route::prefix('/cetak-register')->group(function(){
            Route::get('/','BACKOFFICE\CETAKREGISTER\CetakRegisterController@index');
            Route::get('/print','BACKOFFICE\CETAKREGISTER\CetakRegisterController@print');
        });
    });
});

/******** Michelle ********/
// INQUIRY SUPPLIER PER PRODUK
Route::get('/inqsupprod/index', 'MASTER\inquerySuppProdController@index')->middleware('CheckLogin');
Route::post('/inqsupprod/suppProd', 'MASTER\inquerySuppProdController@suppProd')->middleware('CheckLogin');
Route::get('/inqsupprod/helpSelect', 'MASTER\inquerySuppProdController@helpSelect')->middleware('CheckLogin');

// INQUIRY PRODUK PER SUPPLIER
Route::get('/inqprodsupp/index', 'MASTER\inqueryProdSuppController@index')->middleware('CheckLogin');
Route::post('/inqprodsupp/prodSupp', 'MASTER\inqueryProdSuppController@prodSupp')->middleware('CheckLogin');
Route::get('/inqprodsupp/helpSelect', 'MASTER\inqueryProdSuppController@helpSelect')->middleware('CheckLogin');

// MASTER BARANG
Route::get('/mstbarang/index', 'MASTER\barangController@index')->middleware('CheckLogin');
Route::post('/mstbarang/showBarang', 'MASTER\barangController@showBarang')->middleware('CheckLogin');
Route::get('/mstbarang/helpSelect', 'MASTER\barangController@helpSelect')->middleware('CheckLogin');
Route::post('/mstbarang/searchhelp', 'MASTER\barangController@searchHelp')->middleware('CheckLogin');

// BACK OFFICE / TRANSAKSI / BARANG HILANG / INPUT
Route::get('/bo/transaksi/brghilang/input/index', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/input/lov_trn', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@lov_trn')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/input/lov_plu', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@lov_plu')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/input/showTrn', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@showTrn')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/input/showPlu', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@showPlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/input/nmrBaruTrn', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@nmrBaruTrn')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/input/saveDoc', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@saveDoc')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/input/deleteDoc', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\BarangHilangInputController@saveDoc')->middleware('CheckLogin');

// BACK OFFICE / TRANSAKSI / BARANG HILANG / PEMBATALAN NBH
Route::get('/bo/transaksi/brghilang/pembatalannbh/index', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\pembatalanNBHController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/pembatalannbh/lovNBH', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\pembatalanNBHController@lovNBH')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/pembatalannbh/showData', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\pembatalanNBHController@showData')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/pembatalannbh/deleteData', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\pembatalanNBHController@deleteData')->middleware('CheckLogin');

// BACK OFFICE / TRANSAKSI / BARANG HILANG / INQUERY NBH
Route::get('/bo/transaksi/brghilang/inquerynbh/index', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\inqueryNBHController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/inquerynbh/lov_NBH', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\inqueryNBHController@lov_NBH')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/inquerynbh/showDoc', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\inqueryNBHController@showDoc')->middleware('CheckLogin');
Route::post('/bo/transaksi/brghilang/inquerynbh/detail_Plu', 'BACKOFFICE\TRANSAKSI\BARANGHILANG\inqueryNBHController@detail_Plu')->middleware('CheckLogin');

// PROSES / SETTING PAGI HARI
Route::get('/bo/proses/settingpagihari/index', 'BACKOFFICE\PROSES\settingPagiHariController@index')->middleware('CheckLogin');
Route::get('/bo/proses/settingpagihari/cetak_perubahan_harga_jual', 'BACKOFFICE\PROSES\settingPagiHariController@cetak_perubahan_harga_jual')->middleware('CheckLogin');
Route::get('/bo/proses/settingpagihari/cetak_daftar_plu_tag', 'BACKOFFICE\PROSES\settingPagiHariController@cetak_daftar_plu_tag')->middleware('CheckLogin');

// LAPORAN / LAPORAN SERVICE LEVEL PO THD BPB
Route::get('/bo/laporan/laporanservicelevel/index', 'BACKOFFICE\LAPORAN\LaporanServiceLevelController@index')->middleware('CheckLogin');
Route::post('/bo/laporan/laporanservicelevel/lov_supplier', 'BACKOFFICE\LAPORAN\LaporanServiceLevelController@lov_supplier')->middleware('CheckLogin');
Route::post('/bo/laporan/laporanservicelevel/lov_monitoring', 'BACKOFFICE\LAPORAN\LaporanServiceLevelController@lov_monitoring')->middleware('CheckLogin');
Route::post('/bo/laporan/laporanservicelevel/cetak_laporan', 'BACKOFFICE\LAPORAN\LaporanServiceLevelController@cetak_laporan')->middleware('CheckLogin');

/******** Jefri ********/
// MASTER_CABANG
Route::get('/mstcabang/index', 'MASTER\cabangController@index')->middleware('CheckLogin');
Route::post('/mstcabang/getdetailcabang', 'MASTER\cabangController@getDetailCabang')->middleware('CheckLogin');
Route::post('/mstcabang/editdatacabang', 'MASTER\cabangController@editDataCabang')->middleware('CheckLogin');
Route::post('/mstcabang/trfdataanakcab', 'MASTER\cabangController@transDataAnakCab')->middleware('CheckLogin');

// MASTER_OUTLET
Route::get('/mstoutlet/index', 'MASTER\outletController@index')->middleware('CheckLogin');

// MASTER_SUB_OUTLET
Route::get('/mstsuboutlet/index', 'MASTER\subOutletController@index')->middleware('CheckLogin');
Route::post('/mstsuboutlet/getsuboutlet', 'MASTER\subOutletController@getSubOutlet')->middleware('CheckLogin');

// MASTER_OMI
Route::get('/mstomi/index', 'MASTER\omiController@index')->middleware('CheckLogin');
Route::POST('/mstomi/gettokoomi', 'MASTER\omiController@getTokoOmi')->middleware('CheckLogin');
Route::POST('/mstomi/edittokoomi', 'MASTER\omiController@editTokoOmi')->middleware('CheckLogin');
Route::POST('/mstomi/getbranchname', 'MASTER\omiController@getBranchName')->middleware('CheckLogin');
Route::POST('/mstomi/getcustomername', 'MASTER\omiController@getCustomerName')->middleware('CheckLogin');
Route::POST('/mstomi/updatetokoomi', 'MASTER\omiController@updateTokoOmi')->middleware('CheckLogin');

// MASTER_AKTIF_HARGA_JUAL
Route::get('/mstaktifhrgjual/index', 'MASTER\aktifHargaJualController@index')->middleware('CheckLogin');
Route::post('/mstaktifhrgjual/getdetailplu', 'MASTER\aktifHargaJualController@getDetailPlu')->middleware('CheckLogin');
Route::post('/mstaktifhrgjual/getprodmast', 'MASTER\aktifHargaJualController@getProdmast')->middleware('CheckLogin');
Route::post('/mstaktifhrgjual/aktifkanhrg', 'MASTER\aktifHargaJualController@aktifkanHarga')->middleware('CheckLogin');

// MASTER_AKTIF_ALL_HARGA_JUAL
Route::get('/mstaktifallhrgjual/index', 'MASTER\aktifAllHargaJualController@index')->middleware('CheckLogin');
Route::post('mstaktifallhrgjual/aktifallitem', 'MASTER\aktifAllHargaJualController@aktifkanAllItem')->middleware('CheckLogin');

//MASTER_HARILIBUR
Route::get('/mstharilibur/index', 'MASTER\hariLiburController@index')->middleware('CheckLogin');
Route::post('/mstharilibur/insert', 'MASTER\hariLiburController@insert')->middleware('CheckLogin');
Route::post('/mstharilibur/delete', 'MASTER\hariLiburController@delete')->middleware('CheckLogin');

//BACKOFFICE_PB_ITEM_MAXPALET_UNTUK_PB
Route::get('/bomaxpalet/index', 'BACKOFFICE\maxpaletUntukPBController@index')->middleware('CheckLogin');
Route::post('/bomaxpalet/loaddata', 'BACKOFFICE\maxpaletUntukPBController@loadData')->middleware('CheckLogin');
Route::post('/bomaxpalet/getmaxpalet', 'BACKOFFICE\maxpaletUntukPBController@getMaxPalet')->middleware('CheckLogin');
Route::post('/bomaxpalet/savedata', 'BACKOFFICE\maxpaletUntukPBController@saveData')->middleware('CheckLogin');
Route::post('/bomaxpalet/deletedata', 'BACKOFFICE\maxpaletUntukPBController@deleteData')->middleware('CheckLogin');

//BACKOFFICE_UTILITY_PB_IGR
Route::get('/boutilitypbigr/index', 'BACKOFFICE\utilityPBIGRController@index')->middleware('CheckLogin');
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
Route::post('/bopbotomatis/getdatamodal', 'BACKOFFICE\PBOtomatisController@getDataModal')->middleware('CheckLogin');
Route::post('/bopbotomatis/getsupplier', 'BACKOFFICE\PBOtomatisController@getSupplier')->middleware('CheckLogin');
Route::post('/bopbotomatis/getmtrsup', 'BACKOFFICE\PBOtomatisController@getMtrSupplier')->middleware('CheckLogin');
Route::post('/bopbotomatis/getdepartemen', 'BACKOFFICE\PBOtomatisController@getDepartemen')->middleware('CheckLogin');
Route::post('/bopbotomatis/getkategori', 'BACKOFFICE\PBOtomatisController@getKategori')->middleware('CheckLogin');
Route::post('/bopbotomatis/searchkategori', 'BACKOFFICE\PBOtomatisController@searchKategori')->middleware('CheckLogin');
Route::post('/bopbotomatis/prosesdata', 'BACKOFFICE\PBOtomatisController@prosesData')->middleware('CheckLogin');
Route::get('/bopbotomatis/cetakreport/{kodeigr}/{date1}/{date2}/{sup1}/{sup2}', 'BACKOFFICE\PBOtomatisController@cetakReport');
//Route::get('/bopbotomatis/cetakreport/{kodeigr}/{date1}/{date2}/{sup1}',      'BACKOFFICE\PBOtomatisController@cetakReport');

//BACKOFFICE_CETAK_PB
Route::get('/bocetakpb/index', 'BACKOFFICE\cetakPBController@index')->middleware('CheckLogin');
Route::post('/bocetakpb/getdocument', 'BACKOFFICE\cetakPBController@getDocument')->middleware('CheckLogin');
Route::post('/bocetakpb/searchdocument', 'BACKOFFICE\cetakPBController@searchDocument')->middleware('CheckLogin');
Route::post('/bocetakpb/getdivisi', 'BACKOFFICE\cetakPBController@getDivisi')->middleware('CheckLogin');
Route::post('/bocetakpb/searchdivisi', 'BACKOFFICE\cetakPBController@searchDivisi')->middleware('CheckLogin');
Route::post('/bocetakpb/getdepartement', 'BACKOFFICE\cetakPBController@getDepartement')->middleware('CheckLogin');
Route::post('/bocetakpb/searchdepartement', 'BACKOFFICE\cetakPBController@searchDepartement')->middleware('CheckLogin');
Route::post('/bocetakpb/getkategori', 'BACKOFFICE\cetakPBController@getKategori')->middleware('CheckLogin');
Route::post('/bocetakpb/searchkategori', 'BACKOFFICE\cetakPBController@searchKategori')->middleware('CheckLogin');
Route::get('/bocetakpb/cetakreport/{tgl1}/{tgl2}/{doc1}/{doc2}/{div1}/{div2}/{dept1}/{dept2}/{kat1}/{kat2}/{tipePB}', 'BACKOFFICE\cetakPBController@cetakReport')->middleware('CheckLogin');


//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-BARANGRUSAK
Route::get('/bo/transaksi/pemusnahan/brgrusak/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/getnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNmrTrn')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/getplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getPlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/choosetrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@chooseTrn')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/getnewnmrtrn', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@getNewNmrTrn')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/chooseplu', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@choosePlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/savedata', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@saveData')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/deletedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@deleteDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/brgrusak/showall', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@showAll')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/brgrusak/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\barangRusakController@printDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-BERITA_ACARA_PEMUSNAHAN
Route::get('/bo/transaksi/pemusnahan/bapemusnahan/index', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/getnodoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNoDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/getnopbbr', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNoPBBR')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/choosedoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@chooseNoDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/choosepbbr', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@choosePBBR')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/getnewnmrdoc', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@getNewNmrDoc')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapemusnahan/savedata', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@saveData')->middleware('CheckLogin');
Route::get('/bo/transaksi/pemusnahan/bapemusnahan/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\beritaAcaraPemusnahanController@printDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-PEMBATALAN_BA_PEMUSNAHAN
Route::get('/bo/transaksi/pemusnahan/bapbatal/index',                       'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapbatal/searchdoc',                  'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@searchDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapbatal/getdetaildoc',               'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@getDetailDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/bapbatal/deletedoc',                  'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\pembatalanBAPemusnahanController@deleteDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PEMUSNAHAN-INQUERY_BA_PEMUSNAHAN
Route::get('/bo/transaksi/pemusnahan/inquerybapb/index',                    'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/inquerybapb/getdetaildoc',            'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@getDetailDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/inquerybapb/searchdoc',               'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@searchDocument')->middleware('CheckLogin');
Route::post('/bo/transaksi/pemusnahan/inquerybapb/detailplu',               'BACKOFFICE\TRANSAKSI\PEMUSNAHAN\inqueryBAPBController@detailPlu')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PENERIMAAN-INPUT
Route::get('/bo/transaksi/penerimaan/input/index',                          'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@index')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/input/showbtb/{tipetrn}',             'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showBTB')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/choosebtb',                     'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@chooseBTB')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/getnewnobtb',                   'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@getNewNoBTB')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/input/showpo',                        'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showPO')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/choosepo',                      'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@choosePO')->middleware('CheckLogin');
Route::get('/bo/transaksi/penerimaan/input/showsupplier',                  'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showSupplier')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/showplu',                       'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@showPlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/chooseplu',                     'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@choosePlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/changehargabeli',               'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeHargaBeli')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/changeqty',                     'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeQty')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/changebonus1',                  'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeBonus1')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/changerphdisc',                 'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@changeRphDisc')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/rekamdata',                     'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@rekamData')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/transferpo',                    'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@transferPO')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/input/savedata',                      'BACKOFFICE\TRANSAKSI\PENERIMAAN\inputController@saveData')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PENERIMAAN-INQUERY BPB
Route::get('/bo/transaksi/penerimaan/inquery/index',                        'BACKOFFICE\TRANSAKSI\PENERIMAAN\inqueryController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/inquery/viewbtp',                     'BACKOFFICE\TRANSAKSI\PENERIMAAN\inqueryController@viewBTB')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/inquery/viewdata',                    'BACKOFFICE\TRANSAKSI\PENERIMAAN\inqueryController@viewData')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/inquery/viewdetailplu',               'BACKOFFICE\TRANSAKSI\PENERIMAAN\inqueryController@viewDetailPlu')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PENERIMAAN-PEMBATALAN BPB
Route::get('/bo/transaksi/penerimaan/pembatalan/index',                     'BACKOFFICE\TRANSAKSI\PENERIMAAN\pembatalanController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/pembatalan/viewbtp',                  'BACKOFFICE\TRANSAKSI\PENERIMAAN\pembatalanController@viewBTB')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/pembatalan/viewdata',                 'BACKOFFICE\TRANSAKSI\PENERIMAAN\pembatalanController@viewData')->middleware('CheckLogin');
Route::post('/bo/transaksi/penerimaan/pembatalan/batalbpb',                 'BACKOFFICE\TRANSAKSI\PENERIMAAN\pembatalanController@batalBPB')->middleware('CheckLogin');


//BACKOFFICE-TRANSAKSI-PENERIMAAN-CETAK BPB
Route::get('/bo/transaksi/penerimaan/printBPB/index',                       'BACKOFFICE\TRANSAKSI\PENERIMAAN\printBPBController@index')->middleware('CheckLogin');



/******** Ryan ********/
//BACKOFFICE-TRANSAKSI-PERUBAHAN STATUS-ENTRY SORTIR BARANG
Route::get('/bo/transaksi/perubahanstatus/entrySortirBarang/index', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/entrySortirBarang/getnewnmrsrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@getNewNmrSrt')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/entrySortirBarang/getnmrsrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@getNmrSrt')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/entrySortirBarang/choosesrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@chooseSrt')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/entrySortirBarang/getplu', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@getPlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/entrySortirBarang/chooseplu', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@choosePlu')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/entrySortirBarang/savedata', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@saveData')->middleware('CheckLogin');
Route::get('/bo/transaksi/perubahanstatus/entrySortirBarang/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\entrySortirBarangController@printDocument')->middleware('CheckLogin');

//BACKOFFICE-TRANSAKSI-PERUBAHAN STATUS-RUBAH STATUS
Route::get('/bo/transaksi/perubahanstatus/rubahStatus/index', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@index')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/rubahStatus/getnewnmrrsn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@getNewNmrRsn')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/rubahStatus/getnmrrsn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@getNmrRsn')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/rubahStatus/getnmrsrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@getNmrSrt')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/rubahStatus/choosersn', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@chooseRsn')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/rubahStatus/choosesrt', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@chooseSrt')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/rubahStatus/savedata', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@saveData')->middleware('CheckLogin');
Route::post('/bo/transaksi/perubahanstatus/rubahStatus/checkrak', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@checkRak')->middleware('CheckLogin');
Route::get('/bo/transaksi/perubahanstatus/rubahStatus/printdoc/{doc}', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@printDocument')->middleware('CheckLogin');
Route::get('/bo/transaksi/perubahanstatus/rubahStatus/printdocrak/{doc}', 'BACKOFFICE\TRANSAKSI\PERUBAHANSTATUS\rubahStatusController@printDocumentRak')->middleware('CheckLogin');

//BACKOFFICE-RESTORE
Route::get('restore/index', 'BACKOFFICE\restoreController@index')->middleware('CheckLogin');
Route::post('restore/restorenow', 'BACKOFFICE\restoreController@restoreNow')->middleware('CheckLogin');

//BACKOFFICE-REPACKING-REPACKING
Route::get('transaksi/repacking/index',             'BACKOFFICE\TRANSAKSI\REPACKING\repackController@index')->middleware('CheckLogin');
Route::post('transaksi/repacking/getNewNmrTrn',     'BACKOFFICE\TRANSAKSI\REPACKING\repackController@getNewNmrTrn')->middleware('CheckLogin');
Route::post('transaksi/repacking/chooseTrn',        'BACKOFFICE\TRANSAKSI\REPACKING\repackController@chooseTrn')->middleware('CheckLogin');
Route::post('transaksi/repacking/getNmrTrn',        'BACKOFFICE\TRANSAKSI\REPACKING\repackController@getNmrTrn')->middleware('CheckLogin');
Route::post('transaksi/repacking/deleteTrn',        'BACKOFFICE\TRANSAKSI\REPACKING\repackController@deleteTrn')->middleware('CheckLogin');
Route::post('transaksi/repacking/getPlu',           'BACKOFFICE\TRANSAKSI\REPACKING\repackController@getPlu')->middleware('CheckLogin');
Route::post('transaksi/repacking/choosePlu',        'BACKOFFICE\TRANSAKSI\REPACKING\repackController@choosePlu')->middleware('CheckLogin');
Route::post('transaksi/repacking/saveData',         'BACKOFFICE\TRANSAKSI\REPACKING\repackController@saveData')->middleware('CheckLogin');
Route::post('transaksi/repacking/print',            'BACKOFFICE\TRANSAKSI\REPACKING\repackController@print')->middleware('CheckLogin');
Route::get('transaksi/repacking/printdoc/{doc}',    'BACKOFFICE\TRANSAKSI\REPACKING\repackController@printDocument')->middleware('CheckLogin');
