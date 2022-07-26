@extends('navbar')
@section('title','PENERIMAAN | INPUT')
@section('content')

<div class="container" style="max-width: max-content;">
    <button onclick="topFunction()" id="myBtn" title="Go to top">&#9650;</button>
    <h4><span class="badge badge-dark" id="statusJenisPenerimaan"></span></h4>
    <div class="row">
        <div class="col-md-6">
            <div class="card border-dark cardForm" id="left_col">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <label for="btb_number" class="col-form-label">No. BTB</label>
                        </div>
                        <div class="col-4">
                            <div class="input-group mb">
                                <input autocomplete="off" type="text" id="btb_number" class="form-control" aria-describedby="btbNumber" onfocus="generateBTB()">
                                <button class="btn btn btn-light" type="button" id="btb_more_btn" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showBTB()">&#x1F50E;</button>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="btb_date" class="col-form-label">Tgl. BTB</label>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control nullPermission" id="btb_date" placeholder="dd/mm/yyyy">
                        </div>
                    </div>

                    <!-- BTB Modal -->
                    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="modalHelpTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <table class="table table-borderless" id="tableModalHelp">
                                                    <thead class="theadDataTables">
                                                        <tr>
                                                            <th id="modalThName1"></th>
                                                            <th id="modalThName2"></th>
                                                            <th id="modalThName3"></th>
                                                            <th id="modalThName4"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyModalHelp"></tbody>
                                                </table>
                                                <p class="text-hide" id="idModal"></p>
                                                <p class="text-hide" id="idRow"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- BTB Modal -->

                    <div class="row align-items-center">
                        <div class="col-2">
                            <label for="po_number" class="col-form-label">No. PO</label>
                        </div>
                        <div class="col-4">
                            <div class="input-group mb">
                                <input autocomplete="off" type="text" id="po_number" class="form-control" aria-describedby="po_number">
                                <button id="showPoBtn" class="btn btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="checkPO()">&#x1F50E;</button>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="po_date" class="col-form-label">Tgl. PO</label>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control nullPermission" id="po_date" placeholder="dd/mm/yyyy" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-2">
                            <label for="supplier_code" class="col-form-label">Supplier</label>
                        </div>
                        <div class="col-4">
                            <div class="input-group mb">
                                <input autocomplete="off" type="text" id="supplier_code" class="form-control" aria-describedby="supplierName">
                                <button id="showSupplierBtn" class="btn btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="checkSupplier()">&#x1F50E;</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <input type="text" id="supplier_name" class="form-control" aria-describedby="supplierValue" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-2">
                            <label for="fracture" class="col-form-label">No Faktur</label>
                        </div>
                        <div class="col-4">
                            <input autocomplete="off" type="text" id="fracture" class="form-control" aria-describedby="factureAmt">
                        </div>
                        <div class="col-2">
                            <label for="fracture_date" class="col-form-label">Tgl Faktur</label>
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control nullPermission" id="fracture_date" placeholder="dd/mm/yyyy">
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-2">
                            <label for="top_amt" class="col-form-label">TOP</label>
                        </div>
                        <div class="col-2">
                            <input autocomplete="off" type="text" id="top_amt" class="form-control" aria-describedby="topAmt">
                        </div>
                        <div class="col-2"></div>
                        <div class="col-2">
                            <label for="pkp_amt" class="col-form-label">PKP</label>
                        </div>
                        <div class="col-2">
                            <input autocomplete="off" type="text" id="pkp_amt" class="form-control" aria-describedby="pkpAmt" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card border-dark cardForm">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-4" id="right_col">
                            <label for="gross_amt" class="col-form-label">Gross</label>
                        </div>
                        <div class="col-8">
                            <input autocomplete="off" type="text" id="gross_amt" class="form-control" aria-describedby="grossAmt" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-4" id="right_col">
                            <label for="disc_amt" class="col-form-label">Discount</label>
                        </div>
                        <div class="col-8">
                            <input autocomplete="off" type="text" id="disc_amt" class="form-control" aria-describedby="discAmt" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-4" id="right_col">
                            <label for="ppn_amt" class="col-form-label">PPN</label>
                        </div>
                        <div class="col-8">
                            <input autocomplete="off" type="text" id="ppn_amt" class="form-control" aria-describedby="ppnAmt" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-4" id="right_col">
                            <label for="ppn_bm_amt" class="col-form-label">PPN BM</label>
                        </div>
                        <div class="col-8">
                            <input autocomplete="off" type="text" id="ppn_bm_amt" class="form-control" aria-describedby="ppnBMAmt" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-4" id="right_col">
                            <label for="ppn_botol_amt" class="col-form-label">PPN Botol</label>
                        </div>
                        <div class="col-8">
                            <input autocomplete="off" type="text" id="ppn_botol_amt" class="form-control" aria-describedby="ppnBotolAmt" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-4" id="right_col">
                            <label for="total_amt" class="col-form-label">Grant Total</label>
                        </div>
                        <div class="col-8">
                            <input autocomplete="off" type="text" id="total_amt" class="form-control" aria-describedby="totalAmt" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="card border-dark cardForm">
                <span style="display: block; height: 95px;"></span>
                <button class="btn btn-primary" id="downloadNPDBtn" onclick="downloadNPD()" disabled>Download NPD</button>
                <span style="display: block; height: 20px;"></span>
                <button class="btn btn-info" id="scanQRBtn" data-toggle="modal" data-target="#qrModal" disabled>Scan QR Code</button>
                <span style="display: block; height: 95px;"></span>
            </div>
        </div>

        <!-- QR Modal -->
        <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="qrModalLongTitle">Scan QR Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="header" style="padding-right: 15px;">Header</span>
                            </div>
                            <input type="text" id="qrHeader" class="form-control" aria-describedby="header">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="detail" style="padding-right: 25px;">Detail</span>
                            </div>
                            <input type="text" id="qrDetail" class="form-control" aria-describedby="detail">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" onclick="scanQR()">Proses</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- QR Modal -->
    </div>
    <div class="card border-dark cardForm" id="input_new_trn">
        <span class="space"></span>
        <h4><span class="badge badge-dark">Input Transaksi Pembelian/ Penerimaan Barang</span></h4>
        <span class="space"></span>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_plu" class="col-form-label">PLU</label>
                </div>
                <div class="col-2">
                    <div class="input-group mb">
                        <input autocomplete="off" type="text" id="i_plu" class="form-control" aria-describedby="pluAmt">
                        <button id="showPLUBtn" class="btn btn-light" type="button" data-toggle="modal" data-target="#pluModal" onclick="showPLU()" disabled>&#x1F50E;</button>
                    </div>
                </div>

                <!-- PLU Modal -->
                <div class="modal fade" id="pluModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <input autocomplete="off" type="text" id="pluSearch" onkeyup="searchPLU()" placeholder="&#x1F50E;">
                            </div>
                            <div class="modal-body">
                                <div class="sticky-table sticky-headers sticky-ltr-cells">
                                    <table class="table table-sm table-bordered" id="tableModalHelpPLU">
                                        <thead class="theadDataTables">
                                            <tr id="headRowPLU">
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelpPLU"></tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button id="closePLUBtn" type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PLU Modal -->

                <div class="col-9">
                    <input type="text" id="i_deskripsi" class="form-control" aria-describedby="pluDesc" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_kemasan" class="col-form-label">Kemasan</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_kemasan" class="form-control" aria-describedby="packagingAmt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_tag" class="col-form-label">Status</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_tag" class="form-control" aria-describedby="statusAmt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_bkp" class="col-form-label">BKP</label>
                </div>
                <div class="col-1">
                    <input autocomplete="off" type="text" id="i_bkp" class="form-control" aria-describedby="bkpAmt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_bandrol" class="col-form-label">Bandrol</label>
                </div>
                <div class="col-1">
                    <input autocomplete="off" type="text" id="i_bandrol" class="form-control" aria-describedby="bulkAmt" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_hrgbeli" class="col-form-label">Harga Beli</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_hrgbeli" class="form-control" aria-describedby="buyPriceAmt">
                </div>
                <div class="col-1">
                    <label for="i_lcost" class="col-form-label">Lcost</label>
                </div>
                <div class="col-2">
                    <input type="text" id="i_lcost" class="form-control" aria-describedby="LcostAmt" disabled>
                </div>
                <div class="col-2"></div>
                <div class="col-1">
                    <label for="i_acost" class="col-form-label">ACost</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_acost" class="form-control" aria-describedby="AcostAmt" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_qty" class="col-form-label">Kuantum</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_qty" class="form-control" aria-describedby="quantumAmt">
                </div>
                <div class="col-1">
                    <label for="i_qtyk" class="col-form-label">Qtyk</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_qtyk" class="form-control" aria-describedby="qtyAmt">
                </div>
                <div class="col-1" hidden>
                    <label for="i_isibeli" class="col-form-label">Isi Beli</label>
                </div>
                <div class="col-2" hidden>
                    <input autocomplete="off" type="text" id="i_isibeli" class="form-control" aria-describedby="i_isibeli">
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_bonus1" class="col-form-label">Bonus I</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_bonus1" class="form-control" aria-describedby="bonus1Amt">
                </div>
                <div class="col-1">
                    <label for="i_bonus2" class="col-form-label">Bonus II</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_bonus2" class="form-control" aria-describedby="bonus2Amt" disabled>
                </div>
                <div class="col-2"></div>
                <div class="col-1">
                    <label for="i_gross" class="col-form-label">= Rp. </label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_gross" class="form-control" aria-describedby="bonusAmt" disabled>
                </div>
            </div>
            <span class="space"></span>
            <h4><span class="badge badge-dark">Potongan</span></h4>
            <span class="space"></span>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_persendis1" class="col-form-label">I %</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_persendis1" class="form-control" aria-describedby="cut1Amt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_rphdisc1" class="col-form-label">Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_rphdisc1" class="form-control" aria-describedby="cut1Val">
                </div>
                <div class="col-1">
                    <label for="i_flagdisc1" class="col-form-label">SAT</label>
                </div>
                <div class="col-1">
                    <input autocomplete="off" type="text" id="i_flagdisc1" class="form-control" aria-describedby="sat1Amt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_disc1" class="col-form-label">= Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_disc1" class="form-control" aria-describedby="cut1Final" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_persendis4" class="col-form-label">IV %</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_persendis4" class="form-control" aria-describedby="cut4Amt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_rphdisc4" class="col-form-label">Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_rphdisc4" class="form-control" aria-describedby="cut4Val">
                </div>
                <div class="col-1">
                    <label for="i_flagdisc4" class="col-form-label">SAT</label>
                </div>
                <div class="col-1">
                    <input autocomplete="off" type="text" id="i_flagdisc4" class="form-control" aria-describedby="sat4Amt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_disc4" class="col-form-label">= Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_disc4" class="form-control" aria-describedby="cut4Final" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_persendis2" class="col-form-label">II %</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_persendis2" class="form-control" aria-describedby="cut2Amt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_rphdisc2" class="col-form-label">Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_rphdisc2" class="form-control" aria-describedby="cut2Val">
                </div>
                <div class="col-1">
                    <label for="i_flagdisc2" class="col-form-label">SAT</label>
                </div>
                <div class="col-1">
                    <input autocomplete="off" type="text" id="i_flagdisc2" class="form-control" aria-describedby="sat2Amt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_disc2" class="col-form-label">= Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_disc2" class="form-control" aria-describedby="cut2Final" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_persendis2a" class="col-form-label">II A %</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_persendis2a" class="form-control" aria-describedby="cut2AAmt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_rphdisc2" class="col-form-label">Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_rphdisc2a" class="form-control" aria-describedby="cut2AVal">
                </div>
                <div class="col-2">
                    <label for="sat_2_a_amt" class="col-form-label"></label>
                </div>
                <div class="col-1">
                    <label autocomplete="off" for="i_disc2a" class="col-form-label">= Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_disc2a" class="form-control" aria-describedby="cut2AFinal" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_persendis2b" class="col-form-label">II B %</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_persendis2b" class="form-control" aria-describedby="cut2BAmt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_rphdisc2b" class="col-form-label">Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_rphdisc2b" class="form-control" aria-describedby="cut2BVal">
                </div>
                <div class="col-2">
                    <label for="sat_2_b_amt" class="col-form-label"></label>
                </div>
                <div class="col-1">
                    <label for="i_disc2b" class="col-form-label">= Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_disc2b" class="form-control" aria-describedby="cut2BFinal" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_persendis3" class="col-form-label">III %</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_persendis3" class="form-control" aria-describedby="cut3Amt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_rphdisc3" class="col-form-label">Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_rphdisc3" class="form-control" aria-describedby="cut3Val">
                </div>
                <div class="col-1">
                    <label for="i_flagdisc3" class="col-form-label">SAT</label>
                </div>
                <div class="col-1">
                    <input autocomplete="off" type="text" id="i_flagdisc3" class="form-control" aria-describedby="sat3Amt" disabled>
                </div>
                <div class="col-1">
                    <label for="i_disc3" class="col-form-label">= Rp.</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_disc3" class="form-control" aria-describedby="cut3Final" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-6"></div>
                <div class="col-1">
                    <label for="i_ppn_persen" class="col-form-label">%PPN</label>
                </div>
                <div class="col-1">
                    <input autocomplete="off" type="text" id="i_ppn_persen" class="form-control" disabled>
                </div>
                <div class="col-1">
                    <label for="i_ppn" class="col-form-label">PPN</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_ppn" class="form-control" aria-describedby="ppnTotalAmt" disabled>
                </div>
            </div>
            <span class="space"></span>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_keterangan" class="col-form-label">Keterangan</label>
                </div>
                <div class="col-7">
                    <input autocomplete="off" type="text" id="i_keterangan" class="form-control" placeholder="TEKAN ENTER UNTUK REKAM">
                </div>
                <div class="col-1">
                    <label class="col-form-label">Botol</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_botol" class="form-control" aria-describedby="botolTotalAmt" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-8"></div>
                <div class="col-1">
                    <label for="i_bm" class="col-form-label">BM</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_bm" class="form-control" aria-describedby="bmTotalAmt" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="sum_item" class="col-form-label">Jumlah Item</label>
                </div>
                <div class="col-1">
                    <input autocomplete="off" type="text" id="sum_item" class="form-control" aria-describedby="itemTotalAmt" disabled>
                </div>
                <div class="col-1"></div>
                <div class="col-1">
                    <label for="po_total_amt" class="col-form-label">Total PO</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="po_total_amt" class="form-control" aria-describedby="poTotalAmt" disabled>
                </div>
                <div class="col-1">
                    <label for="grand_total" class="col-form-label">Total</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="grand_total" class="form-control" aria-describedby="grandTotal" disabled>
                </div>
            </div>
        </div>
        <span class="space"></span>
        <span class="space"></span>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <button id="rekamRecBtn" type="button" class="btn btn-primary btn-lg btn-block" onclick="checkFlag()"><b>Rekam Record</b></button>
                </div>
                <div class="col-sm">
                    <button id="trfPOBtn" type="button" class="btn btn-info btn-lg btn-block" onclick="transferPO()"><b>Transfer PO</b></button>
                </div>
                <div class="col-sm">
                    <button id="viewListBtn" type="button" class="btn btn-warning btn-lg btn-block" onclick="viewList()"><b>List/Hapus Record</b></button>
                </div>
                <div class="col-sm">
                    <button id="saveRecBtn" type="button" class="btn btn-success btn-lg btn-block" onclick="saveData()"><b>Simpan Data</b></button>
                </div>
            </div>
            <br><br>
        </div>
        <div id="badgeContainer" class="container">
            <div class="row">
                <div class="col-sm">
                    <h4><span class="badge badge-primary">ALT + R - Rekam Record</span></h4>
                </div>
                <div class="col-sm">
                    <h4><span class="badge badge-info">ALT + T - Transfer PO</span></h4>
                </div>
                <div class="col-sm">
                    <h4><span class="badge badge-warning">ALT + L - Buka List</span></h4>
                </div>
                <div class="col-sm">
                    <h4><span class="badge badge-success">ALT + S - Simpan Data</span></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm">
                    <h4><span class="badge badge-secondary">ALT + C - Tutup List</span></h4>
                </div>
                <div class="col-sm">
                    <h4><span class="badge badge-danger">ALT + H - Hapus Data</span></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-dark cardForm" hidden id="card_display_data">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="sticky-table sticky-headers sticky-ltr-cells">
                    <table id="pluDataTable" class="table table-striped table-striped">
                        <thead class="text-center">
                            <tr class="sticky-header">
                                <!-- <th class="sticky-cell" scope="col" style="min-width: 100px;">Actions</th> -->
                                <th class="sticky-cell" scope="col" style="min-width: 100px;">PLU</th>
                                <th scope="col" style="min-width: 500px;">Deskripsi</th>
                                <th scope="col" style="min-width: 70px">Qty</th>
                                <th scope="col" style="min-width: 70px">QtyK</th>
                                <th scope="col" style="min-width: 150px">Hrg Satuan</th>
                                <th scope="col" style="min-width: 70px">Kemasan</th>
                                <th scope="col" class="text-center" style="min-width: 70px">Tag</th>
                                <th scope="col" class="text-center" style="min-width: 70px">BKP</th>
                                <th scope="col" class="text-center" style="min-width: 100px">Bonus 1</th>
                                <th scope="col" class="text-center" style="min-width: 100px">Bonus 2</th>
                                <th scope="col" class="text-center" style="min-width: 100px">%Disc 1</th>
                                <th scope="col" class="text-center" style="min-width: 100px">Disc 1</th>
                                <th scope="col" class="text-center" style="min-width: 100px">%Disc 2</th>
                                <th scope="col" class="text-center" style="min-width: 100px">Disc 2</th>
                                <th scope="col" class="text-center" style="min-width: 100px">%Disc 2II</th>
                                <th scope="col" class="text-center" style="min-width: 100px">Disc 2II</th>
                                <th scope="col" class="text-center" style="min-width: 100px">%Disc 2III</th>
                                <th scope="col" class="text-center" style="min-width: 100px">Disc 2III</th>
                                <th scope="col" class="text-center" style="min-width: 100px">%Disc 3</th>
                                <th scope="col" class="text-center" style="min-width: 100px">Disc 3</th>
                                <th scope="col" class="text-center" style="min-width: 100px">%Disc 4</th>
                                <th scope="col" class="text-center" style="min-width: 100px">Disc 4</th>
                                <th scope="col" class="text-center" style="min-width: 150px">Gross</th>
                                <th scope="col" class="text-center" style="min-width: 70px">PPN</th>
                                <th scope="col" class="text-center" style="min-width: 150px">Average Cost</th>
                                <th scope="col" class="text-center" style="min-width: 150px">Last Cost</th>
                            </tr>
                        <tbody id="display_data">
                        </tbody>
                        </thead>
                    </table>
                </div>
            </div>
            <span class="space"></span>
            <div class="row align-items-center">
                <div class="col">
                    <button class="btn btn-danger btn-lg" onclick="closeTab()">Tutup Daftar</button>
                </div>
                <div class="col">
                    <input autocomplete="off" type="text" id="inPluTable" class="form-control" placeholder="ALT+C - Tutup List | Klik Baris Tabel yang ingin di koreksi/hapus">
                </div>
                <div class="col-2">
                    <caption>* Klik Plu untuk koreksi atau hapus</caption>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Choose Jenis -->
<button hidden id="chooseTypeBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
</button>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row align-items-center">
                    <h4><span class="badge badge-success"> Jenis Penerimaan?</span></h4>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <button type="button" id="pembelianBtn" class="btn btn-primary btn-lg btn-block" onclick=setJenisPenerimaan(0) data-dismiss="modal">Pembelian</button>
                    </div>
                    <div class="col-sm">
                        <button type="button" id="lainlainBtn" class="btn btn-info btn-lg btn-block" onclick=setJenisPenerimaan(1) data-dismiss="modal">Lain-lain</button>
                    </div>
                    <div class="col-sm">
                        <button type="button" id="rteBtn" class="btn btn-warning btn-lg btn-block" onclick=setJenisPenerimaan(2) data-dismiss="modal">RTE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal lotorisasi -->
<button hidden id="lotorisasiBtn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#lotorisasiModal">
</button>

<div class="modal fade" id="lotorisasiModal" tabindex="-1" role="dialog" aria-labelledby="lotorisasiModalTitle" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Otorisasi Penolakan PO</legend>
                    <div class="form-group">
                        <label for="otoUser">User</label>
                        <input type="email" class="form-control" id="otoUser" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="otoPass">Password</label>
                        <input type="password" class="form-control" id="otoPass">
                    </div>
                    <button type="button" onclick="otorisasi()" class="btn btn-primary">Submit</button>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<style>
    #myBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        border: none;
        outline: none;
        background-color: red;
        color: white;
        cursor: pointer;
        padding: 15px 20px 15px 20px;
        border-radius: 10px;
        font-size: 18px;
    }

    #myBtn:hover {
        background-color: #f75f54;
    }

    .space {
        margin: 10px;
    }

    .col-2,
    #right_col {
        padding: 5px;
    }

    #left_col {
        padding-top: 39px;
        padding-bottom: 39px;
    }

    .card {
        padding: 15px;
        max-width: 100%;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    h4 {
        text-align: center;
        padding: 10px;
    }

    .rowTbodyTableDetail,
    .modalRowBTB,
    .modalRowPO,
    .modalRowPLU,
    .modalRowSupplier {
        cursor: pointer;
    }

    .rowTbodyTableDetail:hover,
    .modalRowBTB:hover,
    .modalRowPO:hover,
    .modalRowPLU:hover,
    .modalRowSupplier:hover {
        background-color: #e9ecef;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }

    #pluSearch {
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }
</style>
<script>
    let jenisPenerimaan = 0;
    let inPluTable = $('#inPluTable');
    let typeTrn;
    let flagRecordId = 'N';
    let flagNewBTB = 'N';
    let tempPlu = [];
    let tempDataBTB = [];
    let tempDataPLU = [];
    let tempDataSave = '';
    let tempDataTable = [];
    let modalHelpTitle = $('#modalHelpTitle')
    let modalThName1 = $('#modalThName1');
    let modalThName2 = $('#modalThName2');
    let modalThName3 = $('#modalThName3');
    let modalThName4 = $('#modalThName4');
    let modalHelp = $('#modalHelp');
    let input_new_trn = $('#input_new_trn');
    let display_data = $('#display_data');
    let card_display_data = $('#card_display_data');
    let tableModalHelp = $('#tableModalHelp').DataTable();
    let btb_number = $('#btb_number');
    let btb_date = $('#btb_date');
    let po_number = $('#po_number');
    let po_date = $('#po_date');
    let supplier_code = $('#supplier_code');
    let supplier_name = $('#supplier_name');
    let fracture = $('#fracture');
    let fracture_date = $('#fracture_date');
    let pkp_amt = $('#pkp_amt');
    let top_amt = $('#top_amt');
    let i_total = $('#grand_total');
    let po_total_amt = $('#po_total_amt');
    let gross_amt = $('#gross_amt');
    let disc_amt = $('#disc_amt');
    let ppn_amt = $('#ppn_amt');
    let ppn_bm_amt = $('#ppn_bm_amt');
    let ppn_botol_amt = $('#ppn_botol_amt');
    let total_amt = $('#total_amt');
    let tbodyModalHelpPLU = $('#tbodyModalHelpPLU');
    let headRowPLU = $('#headRowPLU');
    let i_hrgbeli = $('#i_hrgbeli');
    let pluModal = $('#pluModal');
    let i_isibeli = $('#i_isibeli');
    let i_plu = $('#i_plu');
    let i_deskripsi = $('#i_deskripsi');
    let i_kemasan = $('#i_kemasan');
    let i_tag = $('#i_tag');
    let i_bkp = $('#i_bkp');
    let i_bandrol = $('#i_bandrol');
    let i_lcost = $('#i_lcost');
    let i_acost = $('#i_acost');
    let i_qty = $('#i_qty');
    let i_qtyk = $('#i_qtyk');
    let i_bonus1 = $('#i_bonus1');
    let i_bonus2 = $('#i_bonus2');
    let i_gross = $('#i_gross');
    let i_persendis1 = $('#i_persendis1');
    let i_rphdisc1 = $('#i_rphdisc1');
    let i_flagdisc1 = $('#i_flagdisc1');
    let i_disc1 = $('#i_disc1');
    let i_persendis2 = $('#i_persendis2');
    let i_rphdisc2 = $('#i_rphdisc2');
    let i_flagdisc2 = $('#i_flagdisc2');
    let i_disc2 = $('#i_disc2');
    let i_persendis2a = $('#i_persendis2a');
    let i_rphdisc2a = $('#i_rphdisc2a');
    let i_disc2a = $('#i_disc2a');
    let i_persendis2b = $('#i_persendis2b');
    let i_rphdisc2b = $('#i_rphdisc2b');
    let i_disc2b = $('#i_disc2b');
    let i_persendis3 = $('#i_persendis3');
    let i_rphdisc3 = $('#i_rphdisc3');
    let i_flagdisc3 = $('#i_flagdisc3');
    let i_disc3 = $('#i_disc3');
    let i_persendis4 = $('#i_persendis4');
    let i_rphdisc4 = $('#i_rphdisc4');
    let i_flagdisc4 = $('#i_flagdisc4');
    let i_disc4 = $('#i_disc4');
    let i_keterangan = $('#i_keterangan');
    let i_ppn = $('#i_ppn');
    let i_botol = $('#i_botol');
    let i_bm = $('#i_bm');
    let sum_item = $('#sum_item');
    let closePLUBtn = $('#closePLUBtn');
    let showPLUBtn = $('#showPLUBtn');
    let mybutton = document.getElementById("myBtn");
    let theadDataTables = $('#theadDataTables');
    let rekamRecBtn = $('#rekamRecBtn');
    let trfPOBtn = $('#trfPOBtn');
    let viewListBtn = $('#viewListBtn');
    let saveRecBtn = $('#saveRecBtn');
    let i_ppn_persen = $('#i_ppn_persen');
    let otoUser = $('#otoUser');
    let otoPass = $('#otoPass');
    let lotorisasiModal = $('#lotorisasiModal');
    let downloadNPDBtn = $('#downloadNPDBtn');
    let scanQRBtn = $('#scanQRBtn');
    let rte = 'N';
    let qrDetail = $('#qrDetail');
    let qrHeader = $('#qrHeader');
    let currurl = '{{ url()->current() }}';

    $(document).ready(function() {
        typeTrn = 'B'
        chooseTypeBtn.click();
        btb_number.focus();

        btb_date.datepicker({
            "dateFormat": "dd/mm/yy",
        });
        po_date.datepicker({
            "dateFormat": "dd/mm/yy",
        });
        fracture_date.datepicker({
            "dateFormat": "dd/mm/yy",
        });
    });

    function otorisasi() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/otorisasi',
            type: 'get',
            data: {
                otoUser: otoUser.val(),
                otoPass: otoPass.val(),
                noPO: po_number.val(),
            },
            success: function(result) {
                if (result.kode == 0) {
                    lotorisasiModal.modal('hide')
                    swal({
                        icon: 'success',
                        title: 'Otorisasi Sukses',
                        text: result.msg,
                        timer: 2000
                    });
                } else {
                    lotorisasiModal.modal('hide')
                    swal({
                        icon: 'warning',
                        title: 'Otorisasi Gagal',
                        text: result.msg,
                        timer: 2000
                    });
                }
            },
            error: function(error) {
                lotorisasiModal.modal('hide')
                swal({
                    icon: 'warning',
                    title: 'Otorisasi Gagal',
                    text: error,
                    timer: 2000
                });
                console.log(error)
            }
        });
    }

    function setJenisPenerimaan(flag) {
        if (flag == 1) {
            jenisPenerimaan = 1;
            po_number.attr('disabled', true);
            trfPOBtn.attr('disabled', true);
            viewListBtn.attr('disabled', true);
            $('#showPoBtn').attr('disabled', true);
            supplier_code.attr('disabled', true);
            $('#showSupplierBtn').attr('disabled', true);
            showPLUBtn.attr('disabled', false);
            i_hrgbeli.attr('disabled', true);
            i_qty.attr('disabled', true);
            i_qtyk.attr('disabled', true);
            $('#statusJenisPenerimaan').text('Lain-lain');
            typeTrn = 'L';
            btb_number.focus();
        } else if (flag == 0) {
            jenisPenerimaan = 0;
            $('#statusJenisPenerimaan').text('Pembelian');
            btb_number.focus();
        } else {
            jenisPenerimaan = 2;
            rte = 'Y';
            console.log(rte)
            downloadNPDBtn.removeAttr('disabled');
            scanQRBtn.removeAttr('disabled');
            $('#statusJenisPenerimaan').text('RTE');
            btb_number.focus();
        }

    }

    function startAlert() {
        swal({
            title: 'Jenis Penerimaan?',
            icon: 'info',
            buttons: {
                confirm: "Penerimaan",
                roll: {
                    text: "Lain-lain",
                    value: "lain",
                },
            }
        }).then((confirm) => {
            switch (confirm) {
                case true:
                    typeTrn = 'B';
                    break;
                case "lain":
                    typeTrn = 'L';
                    break;
                default:
                    typeTrn = 'N';
            }
            btb_number.focus();
        })
    }

    function generateBTB() {
        btb_number.keypress(function(e) {
            if (e.which === 13) {
                if (!typeTrn || typeTrn === 'N') {
                    startAlert();
                    return false;
                } else if (!(btb_number.val() == '' || btb_number.val() == null)) {
                    openTab();
                } else {
                    swal({
                        title: 'Buat Nomor Penerimaan Baru?',
                        icon: 'info',
                        buttons: true,
                    }).then((confirm) => {
                        if (confirm) {
                            ajaxSetup();
                            $.ajax({
                                url: '{{ url()->current() }}/getnewnobtb',
                                type: 'post',
                                data: {
                                    typeTrn: typeTrn
                                },
                                beforeSend: function() {
                                    $('#modal-loader').modal('show');
                                    clearLeftFirstField();
                                    clearRightFirstField();
                                    clearSecondField();
                                    flagRecordId = 'N';
                                },
                                success: function(result) {
                                    console.log(result);
                                    if (result.length > 0) {
                                        btb_number.val(result);
                                        btb_date.focus();
                                        tempDataBTB = [];
                                        clearSecondField();
                                        $('#modal-loader').modal('hide');
                                    }
                                },
                                error: function(err) {
                                    console.log(err.responseJSON.message.substr(0, 100));
                                    alertError(err.statusText, err.responseJSON.message)
                                }
                            });
                        } else {
                            console.log('Cancelled')
                        }
                    });
                }
            }
        });
    }

    function showBTB() {
        if (!typeTrn || typeTrn === 'N') {
            startAlert();
            return false;
        }

        try {
            modalHelp.modal('show');
            modalHelpTitle.text("Daftar BTB");
            modalThName1.text('No Dokumen');
            modalThName2.text('No PO');
            modalThName3.text('Tgl BTB');
            modalThName3.show();
            modalThName4.hide();
        } catch (e) {
            swal({
                icon: 'info',
                title: 'Data Sama',
                text: 'Data Tidak Ditemukan!',
                timer: 2000
            });
        }

        tableModalHelp.clear().destroy();
        tableModalHelp = $('#tableModalHelp').DataTable({
            ajax: '{{ url()->current() }}/showbtb/B',
            responsive: true,
            paging: true,
            ordering: true,
            paging: true,
            autoWidth: false,
            columns: [{
                    data: 'trbo_nodoc',
                    name: 'No Dokumen'
                },
                {
                    data: 'trbo_nopo',
                    name: 'No Po'
                },
                {
                    data: 'trbo_tglreff',
                    name: 'Tgl BTB'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('modalRowBTB');
            },
            "order": []
        });
    }

    function checkFlag() {
        if ($('#display_data tr').length == 0 || tempDataSave == '' || tempDataSave == null) {
            rekamData(0)
        } else {
            rekamData(1)
        }
    }

    function downloadNPD() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/download-npd',
            type: 'get',
            beforeSend: () => {
                $('#modal-loader').modal('show');
            },
            success: (result) => {
                $('#modal-loader').modal('hide');
                console.log(result);
                if (result.kode == 0) {
                    swal({
                        icon: 'info',
                        text: result.message,
                        timer: 2000
                    });
                }
            },
            error: (err) => {
                $('#modal-loader').modal('hide');
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message);
            }
        });
    }

    function generateDataTable(data) {
        display_data.empty();
        for (var i = 0; i < data.length; i++) {
            let value = data[i];
            display_data.append(
                `
                <tr class="rowTbodyTableDetail" id="row` + value.trbo_prdcd + `" onclick=koreksiPlu('` + value.trbo_prdcd + `');>
                <td class="sticky-cell" id="plu` + value.trbo_prdcd + `">` + value.trbo_prdcd + `</td>
                <td id="desk` + value.trbo_prdcd + `">` + value.barang + `</td>
                <td class="text-right" id="qty` + value.trbo_prdcd + `">` + parseInt(parseFloat(value.qty)) + `</td>
                <td class="text-right" id="qtyk` + value.trbo_prdcd + `">` + (value.trbo_qty - (parseInt(parseFloat(value.qty))) * value.trbo_frac) + `</td>
                <td class="text-right" id="hrgs` + value.trbo_prdcd + `">` + convertToRupiah(value.trbo_hrgsatuan) + `</td>
                <td class="text-center" id="kemas` + value.trbo_prdcd + `">` + value.trbo_frac + `</td>
                <td class="text-right" id="tag` + value.trbo_prdcd + `">` + nvl(value.trbo_kodetag, ' ') + `</td>
                <td class="text-right" id="bkp` + value.trbo_prdcd + `">` + nvl(value.trbo_bkp, ' ') + `</td>
                <td class="text-right" id="bns1` + value.trbo_prdcd + `">` + value.trbo_qtybonus1 + `</td>
                <td class="text-right" id="bns2` + value.trbo_prdcd + `">` + value.trbo_qtybonus2 + `</td>
                <td class="text-right" id="pd1` + value.trbo_prdcd + `">` + convertToRupiah(value.trbo_persendisc1) + `</td>
                <td class="text-right" id="d1` + value.trbo_prdcd + `">` + convertToRupiah(value.trbo_rphdisc1) + `</td>
                <td class="text-right" id="pd2` + value.trbo_prdcd + `">` + value.trbo_persendisc2 + `</td>
                <td class="text-right" id="d2` + value.trbo_prdcd + `">` + convertToRupiah(value.trbo_rphdisc2) + `</td>
                <td class="text-right" id="pd22` + value.trbo_prdcd + `">` + value.trbo_persendisc2ii + `</td>
                <td class="text-right" id="d22` + value.trbo_prdcd + `">` + convertToRupiah(value.trbo_rphdisc2ii) + `</td>
                <td class="text-right" id="pd23` + value.trbo_prdcd + `">` + value.trbo_persendisc2iii + `</td>
                <td class="text-right" id="d23` + value.trbo_prdcd + `">` + convertToRupiah(value.trbo_rphdisc2iii) + `</td>
                <td class="text-right" id="pd3` + value.trbo_prdcd + `">` + value.trbo_persendisc3 + `</td>
                <td class="text-right" id="d3` + value.trbo_prdcd + `">` + convertToRupiah(value.trbo_rphdisc3) + `</td>
                <td class="text-right" id="pd4` + value.trbo_prdcd + `">` + value.trbo_persendisc4 + `</td>
                <td class="text-right" id="d4` + value.trbo_prdcd + `">` + convertToRupiah2(value.trbo_rphdisc4) + `</td>
                <td class="text-right" id="gross` + value.trbo_prdcd + `">` + convertToRupiah2(value.trbo_gross) + `</td>
                <td class="text-right" id="ppn` + value.trbo_prdcd + `">` + convertToRupiah2(value.trbo_ppnrph) + `</td>
                <td class="text-right" id="avg` + value.trbo_prdcd + `">` + convertToRupiah(value.trbo_averagecost) + `</td>
                <td class="text-right" id="lcst` + value.trbo_prdcd + `">` + convertToRupiah(value.trbo_oldcost) + `</td>
                </tr>
                `);
        }
    }

    function closeTab() {
        card_display_data.hide();
        input_new_trn.show();
        i_keterangan.focus();
    }

    function openTab() {
        card_display_data.removeAttr('hidden');
        card_display_data.show();
        input_new_trn.hide();
        inPluTable.focus();
    }

    function editDeletePlu(data) {
        if (flagRecordId == 'Y') {
            swal({
                icon: 'warning',
                title: 'Data terdaftar',
                text: 'Nomor Transaksi Ini sudah Dibuatkan Nota',
                timer: 2000
            });
            return false;
        }
        swal("Koreksi atau Hapus Plu " + plu + " ?", {
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Close",
                    value: 'close',
                    visible: true,
                    className: ""
                },
                confirm: {
                    text: "Koreksi",
                    value: 'koreksi',
                    visible: true
                },
                delete: {
                    text: "Hapus",
                    value: 'delete',
                    visible: true,
                    className: ""
                },
            },
        }).then((result) => {
            if (result == 'koreksi') {
                koreksiPlu(data);
            } else if (value === 'delete') {
                swal({
                    title: "Hapus No Transaksi ini ?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ['Tidak', 'Ya']
                }).then((willDelete) => {
                    if (willDelete) {
                        deletePlu(data)
                    }
                });
            }
            btb_number.focus();
        });
    }

    function savePlu(plu) {
        var plu_data = $('#plu' + plu);
        var desk_data = $('#desk' + plu);
        var qty_data = $('#qty' + plu);
        var qtyk_data = $('#qtyk' + plu);
        var hrgs_data = $('#hrgs' + plu);
        var bns1_data = $('#bns1' + plu);
        var d1_data = $('#d1' + plu);
        var d2_data = $('#d2' + plu);
        var d22_data = $('#d22' + plu);
        var d23_data = $('#d23' + plu);
        var d3_data = $('#d3' + plu);
        var d4_data = $('#d4' + plu);
        plu_data.html(i_plu.val());
        qty_data.html(parseInt(parseFloat(i_qty.val())));
        qtyk_data.html(parseInt(parseFloat(i_qtyk.val())));
        hrgs_data.html(parseInt(i_hrgbeli.val()));
        bns1_data.html(i_bonus1.val());
        d1_data.html(convertToRupiah(parseInt(i_rphdisc1.val())));
        d2_data.html(convertToRupiah(parseInt(i_rphdisc2.val())));
        d22_data.html(convertToRupiah(parseInt(i_rphdisc2a.val())));
        d23_data.html(convertToRupiah(parseInt(i_rphdisc2b.val())));
        d3_data.html(convertToRupiah(parseInt(i_rphdisc3.val())));
        d4_data.html(convertToRupiah(parseInt(i_rphdisc4.val())));
        var test1 = display_data.find("tr");
        tempDataTable = [];
        test1.each(function() {
            var temp = [];
            $(this).find('td').each(function() {
                var td = ($(this).text()).replace(/(\r\n|\n|\r)/gm, "");
                temp.push(td);
            })
            tempDataTable.push(temp);
        })

        for (var i = 0; i < tempDataSave.length; i++) {
            if (tempDataSave[i].trbo_prdcd == plu) {
                tempDataSave[i].qty = parseInt(parseFloat(i_qty.val()));
                tempDataSave[i].qtyk = parseInt(parseFloat(i_qtyk.val()));
                tempDataSave[i].nprice = parseInt(i_hrgbeli.val());
                tempDataSave[i].trbo_qtybonus1 = parseInt(i_bonus1.val());
                tempDataSave[i].trbo_rphdisc1 = parseInt(i_rphdisc1.val());
                tempDataSave[i].trbo_rphdisc2 = parseInt(i_rphdisc2.val());
                tempDataSave[i].trbo_rphdisc2ii = parseInt(i_rphdisc2a.val());
                tempDataSave[i].trbo_rphdisc2iii = parseInt(i_rphdisc2b.val());
                tempDataSave[i].trbo_rphdisc3 = parseInt(i_rphdisc3.val());
                tempDataSave[i].trbo_rphdisc4 = parseInt(i_rphdisc4.val());
            }
        }
        console.log(tempDataSave);
        openTab();
    }

    function deletePlu(flagPlu) {
        $('#row' + flagPlu).remove();
        for (var i = 0; i < tempDataSave.length; i++) {
            if (tempDataSave[i].trbo_prdcd == flagPlu) {
                tempDataSave.splice(i, 1);
            }
        }
        console.log(tempDataSave);
    }

    function koreksiPlu(plu) {
        var edit = $('#editBtn' + plu);
        var del = $('#deleteBtn' + plu);
        var save = $('#submitBtn' + plu);
        var plu_data = $('#plu' + plu);
        var desk_data = $('#desk' + plu);
        var qty_data = $('#qty' + plu);
        var qtyk_data = $('#qtyk' + plu);
        var hrgs_data = $('#hrgs' + plu);
        var kemas_data = $('#kemas' + plu);
        var tag_data = $('#tag' + plu);
        var bkp_data = $('#bkp' + plu);
        var bns1_data = $('#bns1' + plu);
        var bns2_data = $('#bns2' + plu);
        var pd1_data = $('#pd1' + plu);
        var d1_data = $('#d1' + plu);
        var pd2_data = $('#pd2' + plu);
        var d2_data = $('#d2' + plu);
        var pd22_data = $('#pd22' + plu);
        var d22_data = $('#d22' + plu);
        var pd23_data = $('#pd23' + plu);
        var d23_data = $('#d23' + plu);
        var pd3_data = $('#pd3' + plu);
        var d3_data = $('#d3' + plu);
        var pd4_data = $('#pd4' + plu);
        var d4_data = $('#d4' + plu);
        var gross_data = $('#gross' + plu);
        var ppn_data = $('#ppn' + plu);
        var avg_data = $('#avg' + plu);
        var lcst_data = $('#lcst' + plu);

        edit.hide();
        del.hide();
        save.removeAttr('hidden');
        save.show();
        closeTab();

        //editable
        i_plu.val(plu_data.text());
        i_qty.val(qty_data.text());
        i_qtyk.val(qtyk_data.text());
        i_hrgbeli.val(hrgs_data.text());
        i_bonus1.val(bns1_data.text());
        i_rphdisc1.val(d1_data.text());
        i_rphdisc2.val(d2_data.text());
        i_rphdisc2a.val(d22_data.text());
        i_rphdisc2b.val(d23_data.text());
        i_rphdisc3.val(d3_data.text());
        i_rphdisc4.val(d4_data.text());

        //non editable
        i_deskripsi.val(desk_data.text());
        i_kemasan.val(kemas_data.text());
        i_tag.val(tag_data.text());
        i_bkp.val(bkp_data.text());
        i_bonus2.val(bns2_data.text());
        i_persendis1.val(pd1_data.text());
        i_persendis2.val(pd2_data.text());
        i_persendis2a.val(pd22_data.text());
        i_persendis2b.val(pd23_data.text());
        i_persendis3.val(pd3_data.text());
        i_persendis4.val(pd4_data.text());
        i_gross.val(gross_data.text());
        i_ppn.val(ppn_data.text());
        i_acost.val(avg_data.text());
        i_lcost.val(lcst_data.text());
        i_ppn_persen.val(i_ppn_persen.text());
    }

    function changeHargaBeli(hrgBeli, qty, qtyk) {
        if (!po_number.val() && !supplier_code.val()) {
            swal({
                icon: 'warning',
                text: 'Nilai Harga Beli Untuk Penerimaan Lain Lain Harus 0 !',
                timer: 2000
            });
            i_hrgbeli.val('0');
            i_hrgbeli.focus();
            return false;
        } else if (hrgBeli <= 0) {
            swal({
                icon: 'warning',
                text: 'Nilai Harga Beli Tidak Boleh <= 0 !',
                timer: 2000
            });
            i_hrgbeli.val('0');
            i_hrgbeli.focus();
            return false;
        }

        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/changehargabeli',
            type: 'post',
            data: {
                hargaBeli: unconvertToRupiah(hrgBeli),
                qty: qty,
                qtyk: qtyk,
                prdcd: i_plu.val(),
                supplier: supplier_code.val(),
                noPo: po_number.val(),
                tempDataPLU: tempDataPLU
            },
            beforeSend: () => {
                $('#modal-loader').modal('show');
            },
            success: (result) => {
                $('#modal-loader').modal('hide');
                console.log(result);

                if (result.kode == 0) {
                    swal({
                        icon: 'warning',
                        text: result.msg,
                        timer: 2000
                    });
                } else {
                    tempDataPLU = result.data;
                    setValue(result.data);
                    i_qty.focus();
                    console.log(result.data)
                }

            },
            error: (err) => {
                $('#modal-loader').modal('hide');
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message);
            }
        });
    }

    function changeQty(qty, qtyk, hrgbeli, next) {

        if (!btb_number.val() && !supplier_code.val() && qty != 0) {
            swal({
                text: 'Untuk BPB Lain Lain, Kolom Qty tidak boleh 0',
                icon: 'info',
                timer: 2000
            })
            i_qty.val(0);
        } else {
            if (jenisPenerimaan == 2 && (qty == '' || qty == null)) {
                i_qty.val(0);
                qty = i_qty.val(0);
            }
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/changeqty',
                type: 'post',
                data: {
                    hargaBeli: hrgbeli,
                    prdcd: i_plu.val(),
                    supplier: supplier_code.val(),
                    noPo: po_number.val(),
                    qty: qty,
                    qtyk: qtyk,
                    tempDataPLU: tempDataPLU
                },
                beforeSend: () => {
                    $('#modal-loader').modal('show');
                },
                success: (result) => {
                    console.log(result);
                    $('#modal-loader').modal('hide');
                    next();
                    if (result.kode == 1) {
                        tempDataPLU = result.data;
                        setValue(result.data);
                    } else {
                        swal({
                            icon: 'warning',
                            title: '',
                            text: result.msg,
                            timer: 2000
                        });
                    }
                },
                error: (err) => {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

    }

    function changeBonus1(bonus1) {
        if ((bonus1 == 0 || !bonus1) && !po_number.val() && !supplier_code.val()) {
            swal({
                text: 'Pada Transaksi Bonus, Qty Bonus Harus Diisi !!',
                icon: 'warning',
                timer: 2000,
            });
            i_bonus1.focus();
            return false;
        }

        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/changebonus1',
            type: 'post',
            data: {
                bonus1: bonus1,
                prdcd: i_plu.val(),
                supplier: supplier_code.val(),
                noPo: po_number.val(),
                tempDataPLU: tempDataPLU
            },
            beforeSend: () => {
                $('#modal-loader').modal('show');
            },
            success: (result) => {
                $('#modal-loader').modal('hide');

                if (result.kode == 0) {
                    swal({
                        icon: 'warning',
                        text: result.msg,
                        timer: 2000
                    });
                } else {
                    tempDataPLU = result.data;
                    console.log(tempDataPLU)
                    setValue(result.data);
                    checkRphDisc();
                }

            },
            error: (err) => {
                $('#modal-loader').modal('hide');
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message);
            }
        });
    }

    function checkRphDisc() {
        if (i_rphdisc1.val() == "0.00") {
            i_rphdisc1.focus();
        } else if (i_rphdisc4.val() == "0.00") {
            i_rphdisc4.focus();
        } else if (i_rphdisc2.val() == "0.00") {
            i_rphdisc2.focus();
        } else if (i_rphdisc2a.val() == "0.00") {
            i_rphdisc2a.focus();
        } else if (i_rphdisc2b.val() == "0.00") {
            i_rphdisc2b.focus();
        } else if (i_rphdisc3.val() == "0.00") {
            i_rphdisc3.focus();
        }
    }


    function changeRphDisc(next) {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/changerphdisc',
            type: 'post',
            data: {
                prdcd: i_plu.val(),
                supplier: supplier_code.val(),
                noPo: po_number.val(),
                tempDataPLU: tempDataPLU
            },
            beforeSend: () => {
                $('#modal-loader').modal('show');
            },
            success: (result) => {
                $('#modal-loader').modal('hide');
                next();

                if (result.kode == 0) {
                    swal({
                        icon: 'warning',
                        text: result.msg,
                        timer: 2000
                    });
                } else {
                    tempDataPLU = result.data;
                    setValue(result.data);
                }
            },
            error: (err) => {
                $('#modal-loader').modal('hide');
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message);
            }
        });
    }

    function chooseBTB(noDoc, noPo) {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/choosebtb',
            type: "post",
            data: {
                noDoc: noDoc,
                noPO: noPo,
                typeTrn: typeTrn
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
                tempDataBTB = [];
                flagRecordId = 'N';
            },
            success: function(result) {
                if (result.kode == 0) {
                    swal({
                        icon: 'warning',
                        text: result.msg,
                        timer: 2000
                    });
                } else {
                    $('#modal-loader').modal('hide');
                    tempDataBTB = result.data;
                    console.log(result.data);
                    openTab();
                    modalHelp.modal('hide');

                    // Populate
                    btb_number.val(result.data[0].trbo_nodoc);
                    po_number.val(result.data[0].trbo_nopo);
                    supplier_code.val(result.data[0].trbo_kodesupplier);
                    supplier_name.val(result.data[0].sup_namasupplier);
                    fracture.val(result.data[0].trbo_nofaktur);
                    try {
                        fracture_date.val(formatDate((result.data[0].trbo_tgldoc.substr(0, 10))));
                        btb_date.val(formatDate((result.data[0].trbo_tgldoc.substr(0, 10))));
                        po_date.val(formatDate((result.data[0].trbo_tgldoc.substr(0, 10))));
                    } catch {
                        fracture_date.val('');
                        btb_date.val('');
                        po_date.val('');
                    }
                    console.log('dates');
                    console.log(btb_date.val());
                    console.log(po_date.val());
                    console.log(fracture_date.val());
                    pkp_amt.val(result.data[0].sup_pkp);
                    // Right Table
                    setValueTableDetail(result.data);
                    showPLUBtn.removeAttr('disabled')
                    generateDataTable(tempDataBTB);
                }
            },
            error: function(err) {
                $('#modal-loader').modal('hide');
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message)
            }
        })

    }

    $(window).keydown(function(e) {
        if ((e.altKey && e.key == 'l') || (e.altKey && e.key == 'L')) {
            openTab();
        } else if ((e.altKey && e.key == 'h') || (e.altKey && e.key == 'H')) {
            if ($('#display_data tr').length == 0 || tempDataSave == '' || tempDataSave == null) {
                swal({
                    icon: 'info',
                    title: 'Data Kosong',
                    text: 'Data Tidak Ditemukan!',
                    timer: 2000
                });
            } else {
                deletePlu(i_plu.val());
                openTab();
            }
        } else if ((e.altKey && e.key == 't') || (e.altKey && e.key == 'T')) {
            transferPO();
        } else if ((e.altKey && e.key == 's') || (e.altKey && e.key == 'S')) {
            saveData();
        } else if ((e.altKey && e.key == 'c') || (e.altKey && e.key == 'C')) {
            closeTab();
        } else if ((e.altKey && e.key == 'r') || (e.altKey && e.key == 'R')) {
            checkFlag();
        }
    })

    i_keterangan.keypress(function(e) {
        if (e.key == 'Enter') {
            $('#modal-loader').modal('show');
            let keterangan = $(this).val().toUpperCase();
            tempDataPLU.i_keterangan = keterangan;
            $('#modal-loader').modal('hide');
            checkFlag();
        }
    })

    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    function topFunction() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }

    function setValue(data) {
        if (jenisPenerimaan == 2) {
            console.log(data.i_prdcd)
            i_plu.val(data.i_prdcd);
            i_deskripsi.val(data.nama);
            i_kemasan.val('PCS');
            i_tag.val('');
            i_bkp.val('');
            i_bandrol.val('');
            i_hrgbeli.val(convertToRupiah(data.price));
            i_lcost.val(convertToRupiah(data.price));
            i_acost.val(convertToRupiah(data.price));
            i_qty.val(data.i_qty);
            i_qtyk.val(data.i_qtyk);
            i_isibeli.val(0);
            i_bonus1.val(0);
            i_bonus2.val(0);
            i_gross.val(convertToRupiah(data.gross));
            i_persendis1.val(convertToRupiah(0));
            i_rphdisc1.val(convertToRupiah(0));
            i_flagdisc1.val('');
            i_disc1.val(convertToRupiah(0));
            i_persendis2.val(convertToRupiah(0));
            i_rphdisc2.val(convertToRupiah(0));
            i_flagdisc2.val(0);
            i_disc2.val(convertToRupiah(0));
            i_persendis2a.val(convertToRupiah(0));
            i_rphdisc2a.val(convertToRupiah(0));
            i_disc2a.val(convertToRupiah(0));
            i_persendis2b.val(convertToRupiah(0));
            i_rphdisc2b.val(convertToRupiah(0));
            i_disc2b.val(convertToRupiah(0));
            i_persendis3.val(convertToRupiah(0));
            i_rphdisc3.val(convertToRupiah(0));
            i_flagdisc3.val('');
            i_disc3.val(convertToRupiah(0));
            i_persendis4.val(convertToRupiah((0)));
            i_rphdisc4.val(convertToRupiah((0)));
            i_flagdisc4.val('');
            i_disc4.val(convertToRupiah((0)));
            i_keterangan.val(data.nama_file);
            i_ppn.val(convertToRupiah(data.ppnrp));
            i_botol.val(convertToRupiah(0));
            i_bm.val(convertToRupiah(0));
            i_total.val(convertToRupiah(0));
            i_ppn_persen.val(0);
            return;
        }
        if (data.i_prdcd != '' || data.i_prdcd != null) {
            i_plu.val(data.i_prdcd);
        } else {
            i_plu.val(data.st_prdcd);
        }
        i_deskripsi.val(data.i_barang);
        i_kemasan.val(data.i_kemasan);
        i_tag.val(data.i_tag);
        i_bkp.val(data.i_bkp);
        i_bandrol.val(data.i_bandrol);
        i_hrgbeli.val(convertToRupiah(data.i_hrgbeli));
        i_lcost.val(convertToRupiah(data.i_lcost));
        i_acost.val(convertToRupiah(data.i_acost));
        i_qty.val(data.i_qty);
        i_qtyk.val(data.i_qtyk);
        i_isibeli.val(convertToRupiah(data.i_isibeli));
        i_bonus1.val(data.i_bonus1);
        i_bonus2.val(data.i_bonus2);
        i_gross.val(convertToRupiah(data.i_gross));
        i_persendis1.val(convertToRupiah(data.i_persendis1));
        i_rphdisc1.val(convertToRupiah(data.i_rphdisc1));
        i_flagdisc1.val(data.i_flagdisc1);
        i_disc1.val(convertToRupiah(data.i_disc1));
        i_persendis2.val(convertToRupiah(data.i_persendis2));
        i_rphdisc2.val(convertToRupiah(data.i_rphdisc2));
        i_flagdisc2.val(data.i_flagdisc2);
        i_disc2.val(convertToRupiah(data.i_disc2));
        i_persendis2a.val(convertToRupiah(data.i_persendis2a));
        i_rphdisc2a.val(convertToRupiah(data.i_rphdisc2a));
        i_disc2a.val(convertToRupiah(data.i_disc2a));
        i_persendis2b.val(convertToRupiah(data.i_persendis2b));
        i_rphdisc2b.val(convertToRupiah(data.i_rphdisc2b));
        i_disc2b.val(convertToRupiah(data.i_disc2b));
        i_persendis3.val(convertToRupiah(data.i_persendis3));
        i_rphdisc3.val(convertToRupiah(data.i_rphdisc3));
        i_flagdisc3.val(data.i_flagdisc3);
        i_disc3.val(convertToRupiah(data.i_disc3));
        i_persendis4.val(convertToRupiah((data.i_persendis4)));
        i_rphdisc4.val(convertToRupiah((data.i_rphdisc4)));
        i_flagdisc4.val(data.i_flagdisc4);
        i_disc4.val(convertToRupiah((data.i_disc4)));
        i_keterangan.val(data.i_keterangan);
        i_ppn.val(convertToRupiah(data.i_ppn));
        i_botol.val(convertToRupiah(data.i_botol));
        i_bm.val(convertToRupiah(data.i_bm));
        i_total.val(convertToRupiah(data.i_total));
        i_ppn_persen.val(data.i_ppn_persen);
        if (jenisPenerimaan == 1) {
            if (!i_keterangan.val()) {
                data.i_keterangan = '';
            }
            i_plu.val(data.st_prdcd);
            i_qty.val(0);
            i_qtyk.val(0);
            data.qty_po = 0;
            data.i_bonus2 = 0;
            data.i_qty = 0;
            data.i_qtyk = 0;
            data.i_total = 0;
            data.i_totaldisc = 0;
            data.i_gross = 0;
            data.i_ppn = 0;
            data.i_bm = 0;
            data.i_botol = 0;
            data.tpod_kodedivisi = 0;
            data.tpod_kodedepartemen = 0;
            data.tpod_kategoribarang = '';
            data.i_unit = 'PCS';
            data.i_frac = 0;
            data.i_flagdisc1 = 0;
            data.i_flagdisc2 = 0;
            data.i_flagdisc3 = 0;
            data.i_flagdisc4 = 0;
            data.i_disc1 = 0;
            data.i_disc2 = 0;
            data.i_disc2a = 0;
            data.i_disc2b = 0;
            data.i_disc3 = 0;
            data.i_disc4 = 0;
            data.i_dis4cp = 0;
            data.i_dis4cr = 0;
            data.i_dis4rp = 0;
            data.i_dis4rr = 0;
            data.i_dis4jp = 0;
            data.i_dis4jr = 0;
            data.i_jenispb = '';
            data.i_lcost = 0;
        }

        if (parseInt(i_rphdisc1.val()) > 0) {
            i_rphdisc1.attr('disabled', true)
        }
        if (parseInt(i_rphdisc2.val()) > 0) {
            i_rphdisc2.attr('disabled', true)
        }
        if (parseInt(i_rphdisc2a.val()) > 0) {
            i_rphdisc2a.attr('disabled', true)
        }
        if (parseInt(i_rphdisc2b.val()) > 0) {
            i_rphdisc2b.attr('disabled', true)
        }
        if (parseInt(i_rphdisc3.val()) > 0) {
            i_rphdisc3.attr('disabled', true)
        }
        if (parseInt(i_rphdisc4.val()) > 0) {
            i_rphdisc4.attr('disabled', true)
        }
    }

    function setValueFromTempDataSave(data) {
        console.log(data);

        try {
            i_plu.val(data.trbo_prdcd);
        } catch (e) {
            i_plu.val(data.trbo_prdcd);
        };
        i_deskripsi.val(data.barang);
        i_kemasan.val(data.kemasan ?? '/' + data.trbo_frac);
        i_tag.val(data.trbo_kodetag);
        i_bkp.val(data.trbo_bkp);
        i_bandrol.val(data.i_bandrol);
        i_hrgbeli.val(convertToRupiah(data.trbo_hrgsatuan));
        i_lcost.val(convertToRupiah(data.trbo_lcost));
        i_acost.val(convertToRupiah((data.trbo_unit == 'KG') ? data.trbo_averagecost / 1 : data.trbo_averagecost / data.trbo_frac));
        i_qty.val(parseInt(parseFloat(data.qty)));
        i_qtyk.val(data.trbo_qty - (parseInt(parseFloat(data.qty)) * data.trbo_frac));
        i_isibeli.val(convertToRupiah(data.isibeli));
        i_bonus1.val(data.trbo_qtybonus1);
        i_bonus2.val(data.trbo_qtybonus2);
        i_gross.val(convertToRupiah(data.trbo_gross));
        i_persendis1.val(convertToRupiah(data.trbo_persendisc1));
        i_rphdisc1.val(convertToRupiah(data.trbo_rphdisc1));
        i_flagdisc1.val(data.trbo_flagdisc1);
        i_disc1.val(convertToRupiah(data.trbo_disc1));
        i_persendis2.val(convertToRupiah(data.trbo_persendisc2));
        i_rphdisc2.val(convertToRupiah(data.i_rphdisc2));
        i_flagdisc2.val(data.trbo_flagdisc2);
        i_disc2.val(convertToRupiah(data.trbo_disc2));
        i_persendis2a.val(convertToRupiah(data.trbo_persendisc2i));
        i_rphdisc2a.val(convertToRupiah(data.trbo_rphdisc2i));
        i_disc2a.val(convertToRupiah(data.trbo_disc2i));
        i_persendis2b.val(convertToRupiah(data.trbo_persendisc2ii));
        i_rphdisc2b.val(convertToRupiah(data.trbo_rphdisc2ii));
        i_disc2b.val(convertToRupiah(data.trbo_disc2ii));
        i_persendis3.val(convertToRupiah(data.trbo_persendisc3));
        i_rphdisc3.val(convertToRupiah(data.trbo_rphdisc3));
        i_flagdisc3.val(data.trbo_flagdisc3);
        i_disc3.val(convertToRupiah(data.trbo_disc3));
        i_persendis4.val(convertToRupiah((data.trbo_persendisc4)));
        i_rphdisc4.val(convertToRupiah((data.trbo_rphdisc4)));
        i_flagdisc4.val(data.trbo_flagdisc4);
        i_disc4.val(convertToRupiah((data.trbo_disc4)));

        i_keterangan.val(data.trbo_keterangan);
        i_ppn.val(convertToRupiah(data.i_ppnrph));
        i_botol.val(convertToRupiah(data.trbo_ppnbtlrph));
        i_bm.val(convertToRupiah(data.trbo_ppnbmrph));
        i_ppn_persen.val(data.i_ppn_persen);
        // sum_item.val(data.sum_item);
        // i_totalpo.val(data.i_totalpo);
        i_total.val(convertToRupiah(data.i_total));

        if (parseInt(i_rphdisc1.val()) > 0) {
            i_rphdisc1.attr('disabled', true)
        }
        if (parseInt(i_rphdisc2.val()) > 0) {
            i_rphdisc2.attr('disabled', true)
        }
        if (parseInt(i_rphdisc2a.val()) > 0) {
            i_rphdisc2a.attr('disabled', true)
        }
        if (parseInt(i_rphdisc2b.val()) > 0) {
            i_rphdisc2b.attr('disabled', true)
        }
        if (parseInt(i_rphdisc3.val()) > 0) {
            i_rphdisc3.attr('disabled', true)
        }
        if (parseInt(i_rphdisc4.val()) > 0) {
            i_rphdisc4.attr('disabled', true)
        }
    }

    function checkPO() {
        if (rte == 'Y') {
            showNPD();
        } else {
            showPO();
        }
    }

    function showPO() {
        if (!typeTrn || typeTrn === 'N') {
            startAlert();

            return false;
        }

        try {
            modalHelp.modal('show');
            modalHelpTitle.text("Daftar PO");
            modalThName1.text('No PO');
            modalThName2.text('Tgl PO');
            modalThName3.text('Kode Supplier');
            modalThName4.text('Nama Supplier');
            modalThName3.show();
            modalThName4.show();
        } catch (e) {
            console.log(e)
            swal({
                icon: 'info',
                title: 'Data Kosong',
                text: 'Data Tidak Ditemukan!',
                timer: 2000
            });
        }
        tableModalHelp.clear().destroy();

        tableModalHelp = $('#tableModalHelp').DataTable({
            ajax: currurl + '/showpo/',
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            columns: [{
                    data: 'tpoh_nopo',
                    name: 'No PO'
                },
                {
                    data: 'tpoh_tglpo',
                    name: 'Tgl PO'
                },
                {
                    data: 'tpoh_kodesupplier',
                    name: 'Kode Supplier'
                },
                {
                    data: 'sup_namasupplier',
                    name: 'Nama Supplier'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('modalRowPO');
            },
            "order": []
        });
    }

    function showNPD() {
        if (!typeTrn || typeTrn === 'N') {
            startAlert();

            return false;
        }

        try {
            modalHelp.modal('show');
            modalHelpTitle.text("Dokumen NPD");
            modalThName1.text('No Dokumen');
            modalThName2.text('Tgl NPD');
            modalThName3.text('Kode Supplier');
            modalThName4.text('Nama Supplier');
            modalThName3.show();
            modalThName4.show();
        } catch (e) {
            console.log(e)
            swal({
                icon: 'info',
                title: 'Data Kosong',
                text: 'Data Tidak Ditemukan!',
                timer: 2000
            });
        }
        tableModalHelp.clear().destroy();

        tableModalHelp = $('#tableModalHelp').DataTable({
            ajax: currurl + '/shownpd',
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            columns: [{
                    data: 'docno',
                    name: 'No Dokumen'
                },
                {
                    data: 'pictgl',
                    name: 'Tgl NPD'
                },
                {
                    data: 'kirim',
                    name: 'Kode Supplier'
                },
                {
                    data: 'sup_namasupplier',
                    name: 'Nama Supplier'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('modalRowPO');
            },
            "order": []
        });
    }


    function choosePO(noPo) {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/choosepo',
            type: 'post',
            dataType: 'json',
            data: {
                typeTrn: typeTrn,
                noPo: noPo,
                rte: rte
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
                modalHelp.modal('hide');
            },
            success: function(result) {
                $('#modal-loader').modal('hide');
                var lotorisasi = result.data;
                if (result.kode == 0) {
                    modalHelp.modal('hide');
                    swal({
                        icon: 'warning',
                        text: result.msg,
                        buttons: {
                            confirm: {
                                text: "Oke",
                                value: 'oke',
                                visible: true
                            }
                        }
                    }).then((result) => {
                        if (lotorisasi == 'Lotorisasi') {
                            //lotorisasi
                            $('#lotorisasiBtn').click();
                        }
                    });
                    po_number.focus()
                } else if (result.kode == 2) {
                    modalHelp.modal('hide');
                    swal({
                        icon: 'warning',
                        text: result.msg,
                        timer: 2000
                    });
                } else if (result.kode == 3) {
                    var btbno = '';
                    if (btb_number.val() != null || btb_number.val() != '') {
                        btbno = btb_number.val();
                    }
                    var currUrl = '{{ url()->current() }}';
                    window.open(currUrl + '/print-gagal-bpb/' + result.url + '/' + result.nopo + '/' + btbno);
                } else {
                    let data = result.data;
                    if (rte == 'Y') {
                        console.log(data)
                        po_number.val(data.docno);
                        po_date.val((data.tanggal1).substr(0, 10));
                        po_date.val(po_date.val().split('-').reverse().join('/'));
                        supplier_code.val(data.kirim);
                        supplier_name.val(data.sup_namasupplier);
                        // pkp_amt.val(data.sup_pkp);
                        // top_amt.val(data.tpoh_top);
                        showPLUBtn.removeAttr('disabled')
                        supplier_code.attr('disabled', true);
                        $('.btnLOVSupplier').attr('disabled', true);
                        fracture.focus();
                    } else {
                        po_number.val(data.tpoh_nopo);
                        po_date.val(data.tpoh_tglpo.substr(0, 10));
                        po_date.val(po_date.val().split('-').reverse().join('/'));
                        supplier_code.val(data.tpoh_kodesupplier);
                        supplier_name.val(data.sup_namasupplier);
                        pkp_amt.val(data.sup_pkp);
                        top_amt.val(data.tpoh_top);
                        showPLUBtn.removeAttr('disabled')
                        supplier_code.attr('disabled', true);
                        $('.btnLOVSupplier').attr('disabled', true);
                        fracture.focus();
                    }
                }
            },
            error: function(err) {
                $('#modal-loader').modal('hide');
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message);
            }
        });


    }

    function checkSupplier() {
        if (rte == 'Y') {
            showSupplierRTE();
        } else {
            showSupplier();
        }
    }

    function showSupplierRTE() {
        modalHelp.modal('show');
        modalHelpTitle.text("Daftar Supplier");
        modalThName1.text('Nama Supplier');
        modalThName2.text('Kode Supplier');
        modalThName3.text('PKP');
        modalThName4.text('TOP');
        modalThName3.show();
        modalThName4.show();
        tableModalHelp.clear().destroy();
        tableModalHelp = $('#tableModalHelp').DataTable({
            ajax: currurl + '/showsupplierrte',
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            columns: [{
                    data: 'sup_namasupplier',
                    name: 'Nama Supplier'
                },
                {
                    data: 'sup_kodesupplier',
                    name: 'Kode Supplier'
                },
                {
                    data: 'sup_pkp',
                    name: 'PKP'
                },
                {
                    data: 'sup_top',
                    name: 'TOP'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('modalRowSupplier');
            },
            "order": []
        });
    }

    function showSupplier() {
        modalHelp.modal('show');
        modalHelpTitle.text("Daftar Supplier");
        modalThName1.text('Nama Supplier');
        modalThName2.text('Kode Supplier');
        modalThName3.text('PKP');
        modalThName4.text('TOP');
        modalThName3.show();
        modalThName4.show();
        tableModalHelp.clear().destroy();
        tableModalHelp = $('#tableModalHelp').DataTable({
            ajax: currurl + '/showsupplier',
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            columns: [{
                    data: 'sup_namasupplier',
                    name: 'Nama Supplier'
                },
                {
                    data: 'sup_kodesupplier',
                    name: 'Kode Supplier'
                },
                {
                    data: 'sup_pkp',
                    name: 'PKP'
                },
                {
                    data: 'sup_top',
                    name: 'TOP'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('modalRowSupplier');
            },
            "order": []
        });
    }

    function chooseSupplier(kode, nama, val_pkp, top) {
        if (typeTrn == 'L') {
            swal({
                icon: 'warning',
                text: 'Kode Supplier Tidak Boleh Diisi!',
                timer: 2000
            });
            supplier_code.val('');
            supplier_name.val('');
        } else {
            supplier_code.val(kode);
            supplier_name.val(nama);
            pkp_amt.val(val_pkp);
            top_amt.val(top);
            showPLUBtn.removeAttr('disabled')
        }
        fracture.focus();
        modalHelp.modal('hide');
    }

    function showPLU() {
        if (jenisPenerimaan == 1) {
            let supplier = supplier_code.val();
            let noPo = po_number.val();
            let typeLov = 'PLU';
            headRowPLU.empty();
            headRowPLU.append(`
                <th>PLU</th>
                <th style="min-width: 300px !important;">Barang</th>
            `)
            if ($('#tbodyModalHelpPLU').contents().length == 0) {
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/showplu',
                    type: 'post',
                    data: {
                        typeTrn: typeTrn,
                        supplier: supplier,
                        noPo: noPo,
                        typeLov: typeLov
                    },
                    beforeSend: () => {
                        $('#modal-loader').modal('show');
                    },
                    success: function(result) {
                        $('#modal-loader').modal('hide');
                        tbodyModalHelpPLU.empty();
                        theadDataTables.empty();
                        console.log(result)
                        for (var i = 0; i < result.length; i++) {
                            let value = result[i];
                            tbodyModalHelpPLU.append(`
                            <tr class="modalRowPLU" onclick="choosePLU('` + value.prd_prdcd + `')">
                                <td>` + value.prd_prdcd + `</td>
                                <td>` + value.prd_deskripsipanjang + `</td>
                            </tr>
                        `)
                        }
                        i_qty.val(0);
                        i_qty.val(0);
                    },
                    error: function(err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0, 100));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                })
            }
        } else if (jenisPenerimaan == 2) {
            let supplier = supplier_code.val();
            let noPo = po_number.val();
            let typeLov = 'RTE';
            headRowPLU.empty();
            headRowPLU.append(`
                <th>No Dokumen</th>
                <th>PLU</th>
                <th style="min-width: 300px !important;">Barang</th>
            `)
            if ($('#tbodyModalHelpPLU').contents().length == 0) {
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/showplu',
                    type: 'post',
                    data: {
                        typeTrn: typeTrn,
                        supplier: supplier,
                        noPo: noPo,
                        typeLov: typeLov
                    },
                    beforeSend: () => {
                        $('#modal-loader').modal('show');
                    },
                    success: function(result) {
                        $('#modal-loader').modal('hide');
                        console.log(result)
                        tbodyModalHelpPLU.empty();
                        theadDataTables.empty();
                        for (var i = 0; i < result.length; i++) {
                            let value = result[i];
                            tbodyModalHelpPLU.append(`
                            <tr class="modalRowPLU" onclick="choosePLU('` + value.prdcd + `')">
                                <td>` + value.docno + `</td>
                                <td>` + value.prd_prdcd + `</td>
                                <td>` + value.prd_deskripsipanjang + `</td>
                            </tr>
                        `)
                        }
                    },
                    error: function(err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0, 100));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                })
            }
        } else {
            let supplier = supplier_code.val();
            let noPo = po_number.val();
            let typeLov = '';
            headRowPLU.empty();
            headRowPLU.append(`
            <th style="min-width: 300px !important;">Barang</th>
                <th>PLU</th>
                <th>Kemasan</th>
                <th>Qty Ctn</th>
                <th>QtyK</th>
                <th>Bonus1</th>
                <th>Bonus2</th>
                <th>Persen disc1</th>
                <th>Disc Rph1</th>
                <th>Persen disc2</th>
                <th>Disc Rph2</th>
                <th>Persen disc3</th>
                <th>Disc Rph3</th>
                <th>Disc Rph4</th>
                <th>No PO</th>
            `)
            if (typeTrn == 'B') {
                if (btb_number == '') {
                    if (supplier == '') {
                        swal({
                            icon: 'info',
                            title: "Mohon isi Supplier",
                            timer: 2000
                        });

                        supplier_code.focus();
                    } else {
                        typeLov = 'PLU';
                    }
                } else {
                    if (supplier != '') {
                        typeLov = 'PLU_PO';
                    } else {
                        supplier_code.focus();
                    }
                }
            } else {
                typeLov = 'LOV155';
            }

            console.log(typeLov);
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/showplu',
                type: 'post',
                data: {
                    typeTrn: typeTrn,
                    supplier: supplier,
                    noPo: noPo,
                    typeLov: typeLov
                },
                beforeSend: () => {
                    $('#modal-loader').modal('show');
                    tbodyModalHelpPLU.empty();
                    theadDataTables.empty();
                },
                success: function(result) {
                    $('#modal-loader').modal('hide');
                    console.log(result)
                    tbodyModalHelpPLU.empty();
                    theadDataTables.empty();
                    for (var i = 0; i < result.length; i++) {
                        let value = result[i];
                        tbodyModalHelpPLU.append(`
                            <tr class="modalRowPLU" onclick="choosePLU('` + value.tpod_prdcd + `')">
                                <td>` + value.prd_deskripsipanjang + `</td>
                                <td>` + value.tpod_prdcd + `</td>
                                <td>` + value.kemasan + `</td>
                                <td>` + value.qty + `</td>
                                <td>` + value.qtyk + `</td>
                                <td>` + value.bonus1 + `</td>
                                <td>` + value.bonus2 + `</td>
                                <td>` + value.tpod_persentasedisc1 + `</td>
                                <td>` + value.tpod_rphdisc1 + `</td>
                                <td>` + value.tpod_persentasedisc2 + `</td>
                                <td>` + value.tpod_rphdisc2 + `</td>
                                <td>` + value.tpod_persentasedisc3 + `</td>
                                <td>` + value.tpod_rphdisc3 + `</td>
                                <td>` + value.tpod_rphdisc4 + `</td>
                                <td>` + value.tpod_nopo + `</td>
                            </tr>
                        `)
                    }
                },
                error: function(err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }
    }

    function choosePLU(plu) {
        let prdcd = plu;
        let noDoc = btb_number.val();
        let noPo = po_number.val();
        let supplier = supplier_code.val();
        let tempData = (tempDataBTB.length < 1) ? tempDataSave : tempDataBTB;

        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/chooseplu',
            type: 'post',
            data: {
                typeTrn: typeTrn,
                prdcd: prdcd,
                noDoc: noDoc,
                noPo: noPo,
                supplier: supplier,
                tempData: tempData,
                rte: rte
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
                i_rphdisc1.attr('disabled', false)
                i_rphdisc2.attr('disabled', false)
                i_rphdisc2a.attr('disabled', false)
                i_rphdisc2b.attr('disabled', false)
                i_rphdisc3.attr('disabled', false)
                i_rphdisc4.attr('disabled', false)
            },
            success: function(result) {
                $('#modal-loader').modal('hide');
                closePLUBtn.click();
                $('.modal-backdrop').remove();
                console.log(result);
                if (result.kode == '0') {
                    if (jenisPenerimaan == 2) {
                        let data = result.data;
                        console.log(data);
                        tempDataPLU = data;
                        setValue(data);
                        setTimeout(function() {
                            i_hrgbeli.focus();
                        }, 500);
                    } else {
                        let data = result.data;
                        console.log(data);
                        tempDataPLU = data;
                        setValue(data);
                        setTimeout(function() {
                            i_hrgbeli.focus();
                            if (jenisPenerimaan == 1) {
                                i_bonus1.focus();
                            }
                        }, 500);
                    }
                } else if (result.kode == '2') {
                    swal({
                        icon: 'warning',
                        text: result.msg,
                        timer: 2000
                    });
                } else {
                    let data = result.data;
                    console.log(data);
                    tempDataPLU = data;
                    setValue(data, prdcd);
                    setTimeout(function() {
                        i_hrgbeli.focus();
                        if (jenisPenerimaan == 1) {
                            i_bonus1.focus();
                        }
                    }, 500);
                    swal({
                        icon: 'warning',
                        text: result.msg,
                        timer: 1000
                    });
                }
            },
            error: function(err) {
                $('#modal-loader').modal('hide');
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message);
            }
        })

    }

    $(document).on('click', '.modalRowBTB', function() {
        let currentButton = $(this);
        let noDoc = currentButton.children().first().text();
        let noPo = currentButton.children().first().next().text();

        chooseBTB(noDoc, noPo);
    });

    $(document).on('click', '.modalRowPO', function() {
        let currentButton = $(this);
        let noPo = currentButton.children().first().text();

        choosePO(noPo);
    });

    $(document).on('click', '.modalRowSupplier', function() {
        let currentButton = $(this);
        let nama = currentButton.children().first().text();
        let kode = currentButton.children().first().next().text();
        let pkp = currentButton.children().first().next().next().text();
        let top = currentButton.children().first().next().next().next().text();

        chooseSupplier(kode, nama, pkp, top);
    });

    function setValueTableDetail(data) {
        if (data[0].trbo_recordid == 2) {
            flagRecordId = 'Y';
        }

        let gross = 0;
        let discount = 0;
        let ppn = 0;
        let ppbbm = 0;
        let ppnbotol = 0;
        let grantTotal = 0;

        for (let i = 0; i < data.length; i++) {
            let value = data[i];

            gross = parseInt(gross) + parseInt(value.trbo_gross);
            discount = parseInt(discount) + parseInt(unconvertToRupiah(value.total_disc));
            ppn = parseInt(ppn) + parseInt(value.trbo_ppnrph);
            ppbbm = parseInt(ppbbm) + parseInt(value.trbo_ppnbmrph);
            ppnbotol = parseInt(ppnbotol) + parseInt(value.trbo_ppnbtlrph);
            // grantTotal = parseInt(grantTotal) + parseInt(value.total_rph);
            if (jenisPenerimaan == 2) {
                grantTotal = parseInt(grantTotal) + parseInt(gross);
            } else {
                grantTotal = parseInt(grantTotal) + (gross + ppn + ppbbm + ppnbotol - discount);
            }


            console.log(gross, discount, ppn, ppbbm, ppnbotol)
        }

        sum_item.val(data.length);
        po_total_amt.val(convertToRupiah(grantTotal));
        gross_amt.val(convertToRupiah(gross));
        disc_amt.val(convertToRupiah(discount));
        ppn_amt.val(convertToRupiah(ppn));
        ppn_bm_amt.val(convertToRupiah(ppbbm));
        ppn_botol_amt.val(convertToRupiah(ppnbotol));
        total_amt.val(convertToRupiah(grantTotal));
    }

    function clearSecondField() {
        setValue(0);
        sum_item.val('');
        po_total_amt.val('');
        i_rphdisc1.attr('disabled', false)
        i_rphdisc2.attr('disabled', false)
        i_rphdisc2a.attr('disabled', false)
        i_rphdisc2b.attr('disabled', false)
        i_rphdisc3.attr('disabled', false)
        i_rphdisc4.attr('disabled', false)
    }

    function clearRightFirstField() {
        gross_amt.val('');
        disc_amt.val('');
        ppn_amt.val('');
        ppn_bm_amt.val('');
        ppn_botol_amt.val('');
        total_amt.val('');
    }

    function clearLeftFirstField() {
        btb_number.val('');
        po_number.val('');
        btb_date.val('');
        po_date.val('');
        supplier_code.val('');
        supplier_name.val('');
        fracture.val('');
        fracture_date.val('');
        pkp_amt.val('');
        top_amt.val('');
    }

    function rekamData(flag) {
        if (!i_plu.val()) {
            swal({
                text: 'Mohon isi PLU!',
                icon: 'warning',
                timer: 2000,
            });
            i_plu.focus();
            return false;
        }
        if (jenisPenerimaan == 1) {
            if (!i_bonus1.val()) {
                swal({
                    text: 'Mohon isi Bonus 1!',
                    icon: 'warning',
                    timer: 2000,
                });
                i_bonus1.focus();
                return false;
            }
        }
        if (flag == 1) {
            savePlu(i_plu.val());
        } else {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/rekamdata',
                type: 'post',
                data: {
                    prdcd: i_plu.val(),
                    noBTB: btb_number.val(),
                    noPo: po_number.val(),
                    tempDataPLU: tempDataPLU,
                    tempDataSave: tempDataSave,
                    rte: rte
                },
                beforeSend: () => {
                    $('#modal-loader').modal('show');
                },
                success: (result) => {
                    $('#modal-loader').modal('hide');
                    console.log(tempDataPLU);
                    console.log(tempDataSave);
                    if (result.kode == 0) {
                        swal({
                            icon: 'warning',
                            text: result.msg
                        }).then((confirm) => {
                            if (confirm) {
                                window.location.reload();
                            }
                        });
                    } else {
                        tempDataSave = result.data;
                        let gross = 0;
                        let discount = 0;
                        let ppn = 0;
                        let ppbbm = 0;
                        let ppnbotol = 0;
                        let grantTotal = 0;
                        for (let i = 0; i < tempDataSave.length; i++) {
                            gross = parseInt(gross) + parseInt(tempDataSave[i].trbo_gross);
                            discount = parseInt(discount) + parseInt(unconvertToRupiah(tempDataSave[i].total_disc));
                            ppn = parseInt(ppn) + parseInt(tempDataSave[i].trbo_ppnrph);
                            ppbbm = parseInt(ppbbm) + parseInt(tempDataSave[i].trbo_ppnbmrph);
                            ppnbotol = parseInt(ppnbotol) + parseInt(tempDataSave[i].trbo_ppnbtlrph);
                            if (jenisPenerimaan == 2) {
                                grantTotal = parseInt(grantTotal) + (gross + ppn + ppbbm + ppnbotol - discount);
                            } else {
                                grantTotal = parseInt(grantTotal) + parseInt(tempDataSave[i].total_rph);
                            }
                        }

                        console.log(tempDataSave)
                        sum_item.val(tempDataSave.length);
                        po_total_amt.val(convertToRupiah(grantTotal));
                        gross_amt.val(convertToRupiah(gross));
                        disc_amt.val(convertToRupiah(discount));
                        ppn_amt.val(convertToRupiah(ppn));
                        ppn_bm_amt.val(convertToRupiah(ppbbm));
                        ppn_botol_amt.val(convertToRupiah(ppnbotol));
                        total_amt.val(convertToRupiah(grantTotal));
                        clearSecondField();
                    }

                },
                error: (err) => {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }
    }

    function transferPO() {
        if (tempDataSave == '' || tempDataSave == null) {
            swal({
                icon: 'info',
                title: 'Data Kosong',
                text: 'Data Tidak Ditemukan!',
                timer: 2000
            });
        } else {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/transferpo',
                type: 'post',
                data: {
                    noPo: po_number.val(),
                    supplier: supplier_code.val(),
                    tempDataPLU: tempDataPLU,
                    tempDataSave: tempDataSave
                },
                beforeSend: () => {
                    $('#modal-loader').modal('show');
                    clearRightFirstField();
                },
                success: (result) => {
                    console.log(result.data);
                    $('#modal-loader').modal('hide');
                    if (!($('#display_data tr').length > 0)) {
                        generateDataTable(result.data);
                    }

                    tempDataSave = [];
                    tempDataSave = result.data;
                    let grantTotal = 0;
                    for (let i = 0; i < tempDataSave.length; i++) {
                        grantTotal = parseInt(grantTotal) + parseInt(tempDataSave[i].total_rph);
                    }

                    viewList();
                    sum_item.val(tempDataSave.length);
                    po_total_amt.val(convertToRupiah(grantTotal));

                },
                error: (err) => {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message);
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }
    }

    function viewList() {
        openTab();
        if (tempDataBTB.length > 0) {
            setValueTableDetail(tempDataBTB)
        } else if (tempDataSave.length > 0) {
            setValueTableDetail(tempDataSave)
        } else {
            console.log('Kosong')
        }
    }

    function saveData() {
        if (tempDataSave == '' || tempDataSave == null) {
            swal({
                icon: 'info',
                title: 'Data Sama',
                text: 'Tidak ada Perubahan data!',
                timer: 2000
            });
        } else {
            console.log(tempDataSave)
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/savedata',
                type: 'post',
                data: {
                    noBTB: btb_number.val(),
                    tglBTB: btb_date.val().split('/').reverse().join('-'),
                    noPO: po_number.val(),
                    tglPO: po_date.val().split('/').reverse().join('-'),
                    supplier: supplier_code.val(),
                    noFaktur: fracture.val(),
                    tglFaktur: fracture_date.val().split('/').reverse().join('-'),
                    tempDataSave: tempDataSave,
                    typeTrn: typeTrn
                },
                beforeSend: () => {
                    $('#modal-loader').modal('show');
                },
                success: (result) => {
                    $('#modal-loader').modal('hide');
                    if (result.kode == 1) {
                        swal({
                            icon: 'success',
                            title: 'Sukses',
                            text: result.msg,
                            timer: 2000
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000)
                    } else {
                        swal({
                            icon: 'warning',
                            text: result.msg,
                            timer: 2000
                        });
                    }

                },
                error: (err) => {
                    $('#modal-loader').modal('hide');
                    alertError(err.statusText, err.responseJSON.message);
                    console.log(err.responseJSON.message.substr(0, 100));
                }
            });
        }
    }

    function searchPLU() {
        var filter = event.target.value.toUpperCase();
        var rows = document.querySelector("#tableModalHelpPLU tbody").rows;

        for (var i = 0; i < rows.length; i++) {
            var barang = rows[i].cells[0].textContent.toUpperCase();
            var plu = rows[i].cells[1].textContent.toUpperCase();
            if (barang.indexOf(filter) > -1 || plu.indexOf(filter) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }

    function scanQR() {
        var header = qrHeader.val();
        var detail = qrDetail.val();
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/readQR',
            type: 'get',
            data: {
                header: header,
                detail: detail
            },
            beforeSend: () => {
                $('#modal-loader').modal('show');
            },
            success: (result) => {
                $('#modal-loader').modal('hide');
                if (result.kode == 1) {
                    swal(
                        result.header,
                        result.detail,
                        'warning'
                    )
                } else if (result.kode == 2) {
                    swal(
                        'Gagal Membaca',
                        result.msg,
                        'warning'
                    )
                } else {
                    swal(
                        'Proses Berhasil',
                        result.msg,
                        'info'
                    )
                }
                $('.modal-backdrop').remove();
                $('#qrModal').hide();
                console.log(result);
            },
            error: (err) => {
                $('#modal-loader').modal('hide');
                alertError(err.statusText, err.responseJSON.message);
                console.log(err.responseJSON.message.substr(0, 100));
            }
        });
    }

    btb_date.keypress(function(e) {
        if (e.which === 13) {
            po_number.focus();
        }
    });

    po_number.keypress(function(e) {
        if (e.which === 13) {
            let val = $(this).val();
            if (!val) {
                supplier_code.attr('disabled', false)
                supplier_code.focus();
            } else {
                choosePO(val)
            }
        }
    });

    supplier_code.keypress(function(e) {
        if (e.which === 13) {
            if (typeTrn == 'L') {
                if (supplier_code.val().length > 0) {
                    swal(
                        '',
                        'Kode Supplier Tidak Boleh Diisi!',
                        'warning'
                    )
                    supplier_code.val('');
                    supplier_name.val('');
                    fracture.focus();
                    return false;
                }
            }

            if (typeTrn == 'B') {
                let kodeSupplier = supplier_code.val()

                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/check-kode-supplier',
                    type: 'post',
                    data: {
                        kodeSupplier
                    },
                    beforeSend: () => {
                        $('#modal-loader').modal('show');
                    },
                    success: function(result) {
                        $('#modal-loader').modal('hide');

                        if (result.kode == 1) {
                            supplier_name.val(result.data.supplier);
                            top_amt.val(result.data.sup_top);
                            pkp_amt.val(result.data.sup_pkp);
                            i_plu.attr('disabled', false);

                            noFaktur.focus()
                        } else {
                            i_plu.attr('disabled', true);
                            supplier_name.val('');
                            top_amt.val('');
                            pkp_amt.val('');
                            swal(
                                '',
                                result.message,
                                'warning'
                            )
                            supplier_code.focus()
                        }
                    },
                    error: function(err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0, 100));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                })
            }
        }
    });

    fracture.keypress(function(e) {
        if (e.which === 13) {
            fracture_date.focus();
        }
    });

    fracture_date.keypress(function(e) {
        if (e.which === 13) {
            i_plu.focus();
        }
    });

    i_plu.keypress(function(e) {
        if (e.which === 13) {
            choosePLU(i_plu.val());
        }
    });

    i_hrgbeli.keypress(function(e) {
        if (e.which === 13) {
            let hrgBeli = $(this).val();
            let qty = i_qty.val();
            let qtyk = i_qtyk.val();

            changeHargaBeli(hrgBeli, qty, qtyk);
        }
    });

    i_qty.keypress(async function(e) {
        if (e.which === 13) {
            let qty = $(this).val();
            let qtyk = i_qtyk.val();
            let hrgbli = unconvertToRupiah(i_hrgbeli.val());

            let changeqty = await new Promise(next => {
                changeQty(qty, qtyk, hrgbli, next);
            });

            i_qtyk.focus()
        }
    });

    i_qtyk.keypress(async function(e) {
        if (e.which === 13) {
            let qtyk = $(this).val();
            let qty = i_qty.val();
            let hrgbli = unconvertToRupiah(i_hrgbeli.val());

            let changeqty = await new Promise(next => {
                changeQty(qty, qtyk, hrgbli, next);
            });
            i_bonus1.focus()

        }
    });

    i_bonus1.keypress(function(e) {
        if (e.which === 13) {
            let bonus1 = $(this).val();

            changeBonus1(bonus1)
        }
    });

    i_rphdisc1.keypress(async function(e) {
        if (e.which === 13) {
            let persendisc = i_persendis1.val();
            let rphdisc = $(this).val();

            if (persendisc == 0) {
                tempDataPLU.i_rphdisc1 = rphdisc;
            }

            await new Promise(next => {
                changeRphDisc(next)
            });
            i_rphdisc1.attr('disabled', false);

            if (i_rphdisc4[0]['disabled'] == false) {
                i_rphdisc4.focus();
            } else if (i_rphdisc2[0]['disabled'] == false) {
                i_rphdisc2.focus();
            } else if (i_rphdisc2a[0]['disabled'] == false) {
                i_rphdisc2a.focus();
            } else if (i_rphdisc2b[0]['disabled'] == false) {
                i_rphdisc2b.focus();
            } else if (i_rphdisc3[0]['disabled'] == false) {
                i_rphdisc3.focus();
            }
        }
    });

    i_rphdisc4.keypress(async function(e) {
        if (e.which === 13) {
            let persendisc = i_persendis4.val();
            let rphdisc = $(this).val();

            if (persendisc == 0) {
                tempDataPLU.i_rphdisc4 = rphdisc;
            }

            await new Promise(next => {
                changeRphDisc(next);
            });
            i_rphdisc4.attr('disabled', false);

            if (i_rphdisc2[0]['disabled'] == false) {
                i_rphdisc2.focus();
            } else if (i_rphdisc2a[0]['disabled'] == false) {
                i_rphdisc2a.focus();
            } else if (i_rphdisc2b[0]['disabled'] == false) {
                i_rphdisc2b.focus();
            } else if (i_rphdisc3[0]['disabled'] == false) {
                i_rphdisc3.focus();
            }
        }
    });

    i_rphdisc2.keypress(async function(e) {
        if (e.which === 13) {
            let persendisc = i_persendis2.val();
            let rphdisc = $(this).val();

            if (persendisc == 0) {
                tempDataPLU.i_rphdisc2 = rphdisc;
            }

            await new Promise(next => {
                changeRphDisc(next);
            });
            i_rphdisc2.attr('disabled', false);

            if (i_rphdisc2a[0]['disabled'] == false) {
                i_rphdisc2a.focus();
            } else if (i_rphdisc2b[0]['disabled'] == false) {
                i_rphdisc2b.focus();
            } else if (i_rphdisc3[0]['disabled'] == false) {
                i_rphdisc3.focus();
            }
        }
    });

    i_rphdisc2a.keypress(async function(e) {
        if (e.which === 13) {
            let persendisc = i_persendis2a.val();
            let rphdisc = $(this).val();

            if (persendisc == 0) {
                tempDataPLU.i_rphdisc2a = rphdisc;
            }

            await new Promise(next => {
                changeRphDisc(next);
            });
            i_rphdisc2a.attr('disabled', false);

            if (i_rphdisc2b[0]['disabled'] == false) {
                i_rphdisc2b.focus();
            } else if (i_rphdisc3[0]['disabled'] == false) {
                i_rphdisc3.focus();
            }
        }
    });

    i_rphdisc2b.keypress(async function(e) {
        if (e.which === 13) {
            let persendisc = i_persendis2b.val();
            let rphdisc = $(this).val();

            if (persendisc == 0) {
                tempDataPLU.i_rphdisc2b = rphdisc;
            }

            await new Promise(next => {
                changeRphDisc(next);
            });
            i_rphdisc2b.attr('disabled', false);

            if (i_rphdisc3[0]['disabled'] == false) {
                i_rphdisc3.focus();
            }
        }
    });

    i_rphdisc3.keypress(async function(e) {
        if (e.which === 13) {
            let persendisc = i_persendis3.val();
            let rphdisc = $(this).val();

            if (persendisc == 0) {
                tempDataPLU.i_rphdisc3 = rphdisc;
            }

            await new Promise(next => {
                changeRphDisc(next);
            });
            i_rphdisc3.attr('disabled', false);
            i_keterangan.focus();
        }
    });
</script>
@endsection