@extends('navbar')
@section('title','PENERIMAAN | INPUT')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <div class="card" id="left_col">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-2">
                            <label for="btb_number" class="col-form-label">No. BTB</label>
                        </div>
                        <div class="col-4">
                            <div class="input-group mb">
                                <input autocomplete="off" type="text" id="btb_number" class="form-control" aria-describedby="btbNumber" onfocus="generateBTB()">
                                <button class="btn btn-outline-secondary" type="button" id="btb_more_btn" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showBTB()">&#x1F50E;</button>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="btb_date" class="col-form-label">Tgl. BTB</label>
                        </div>
                        <div class="col-4">
                            <input autocomplete="off" type="date" id="btb_date" class="form-control" aria-describedby="btbDate">
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
                                <input autocomplete="off" type="text" id="po_number" class="form-control" aria-describedby="poNumber">
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showPO()">&#x1F50E;</button>
                            </div>
                        </div>
                        <div class="col-2">
                            <label for="po_date" class="col-form-label">Tgl. PO</label>
                        </div>
                        <div class="col-4">
                            <input autocomplete="off" type="text" id="po_date" class="form-control" aria-describedby="poDate" disabled>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-2">
                            <label for="supplier_name" class="col-form-label">Supplier</label>
                        </div>
                        <div class="col-4">
                            <div class="input-group mb">
                                <input autocomplete="off" type="text" id="supplier_name" class="form-control" aria-describedby="supplierName">
                                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showSupplier()">&#x1F50E;</button>
                            </div>
                        </div>
                        <div class="col-6">
                            <input type="text" id="supplier_value" class="form-control" aria-describedby="supplierValue" disabled>
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
                            <input autocomplete="off" type="date" id="fracture_date" class="form-control" aria-describedby="factureDateAmt">
                        </div>
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
            <div class="card">
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
    </div>
    <div class="card" id="input_new_trn">
        <h4>Input Transaksi Pembelian/ Penerimaan Barang</h4>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-1">
                    <label for="i_plu" class="col-form-label">PLU</label>
                </div>
                <div class="col-2">
                    <div class="input-group mb">
                        <input autocomplete="off" type="text" id="i_plu" class="form-control" aria-describedby="pluAmt">
                        <button id="showPLUBtn" class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#pluModal" onclick="showPLU()" disabled>&#x1F50E;</button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="pluModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            </div>
                            <div class="modal-body">
                                <div class="sticky-table sticky-headers sticky-ltr-cells">
                                    <table class="table table-sm table-bordered table-striped" id="tableModalHelpPLU">
                                        <thead class="theadDataTables">
                                            <tr>
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
            <hr>
            <h5>Potongan</h5>
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
                <div class="col-1">
                    <label for="i_keterangan" class="col-form-label">Keterangan</label>
                </div>
                <div class="col-7">
                    <input autocomplete="off" type="text" id="i_keterangan" class="form-control" aria-i_keteranganribedby="i_keterangan">
                </div>
                <div class="col-1">
                    <label for="i_ppn" class="col-form-label">PPN</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="i_ppn" class="form-control" aria-describedby="ppnTotalAmt" disabled>
                </div>
            </div>
            <hr>
            <div class="row align-items-center">
                <div class="col-8"></div>
                <div class="col-1">
                    <label for="i_botol" class="col-form-label">Botol</label>
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
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-2">
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
                <div class="col-1"></div>
                <div class="col-1">
                    <label for="grand_total" class="col-form-label">Total</label>
                </div>
                <div class="col-2">
                    <input autocomplete="off" type="text" id="grand_total" class="form-control" aria-describedby="grandTotal" disabled>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <button type="button" class="btn btn-primary btn-lg btn-block" onclick="rekamData()">Rekam Record</button>
                </div>
                <div class="col-sm">
                    <button type="button" class="btn btn-info btn-lg btn-block" onclick="transferPO()">Transfer PO</button>
                </div>
                <div class="col-sm">
                    <button type="button" class="btn btn-warning btn-lg btn-block" onclick="viewList()">List/Hapus Record</button>
                </div>
                <div class="col-sm">
                    <button type="button" class="btn btn-success btn-lg btn-block" onclick="saveData()">Simpan Data</button>
                </div>
            </div>
        </div>

    </div>
    <div class="card" hidden id="card_display_data">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="sticky-table sticky-headers sticky-ltr-cells">
                        <table id="display_data" class="table table-sm table-bordered table-striped">
                        </table>
                    </div>
                    <button class="btn btn-primary" onclick="closeTab()">Tutup Daftar</button>
                    <caption>* Klik Plu untuk koreksi atau hapus</caption>
                </div>
            </div>
        </div>
    </div>

    <style>
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

        h4,
        h5 {
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
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        let typeTrn;
        let flagRecordId = 'N';
        let flagNewBTB = 'N';
        let tempPlu = [];
        let tempDataBTB = [];
        let tempDataPLU = [];
        let tempDataSave = '';
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
        let ponumber = $('#po_number');
        let podate = $('#po_date');
        let supplier_name = $('#supplier_name');
        let supplier_value = $('#supplier_value');
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
        var today = new Date();
        $(document).ready(function() {
            typeTrn = 'B'
            console.log(today.toISOString().substr(0, 10))
            btb_number.focus();
        });

        function startAlert() {
            Swal.fire({
                title: 'Jenis Penerimaan?',
                icon: 'question',
                showDenyButton: 'true',
                confirmButtonText: 'Lain-Lain',
                denyButtonText: 'Lainnya'
            }).then((result) => {
                if (result.isConfirmed) {
                    typeTrn = 'B';
                    console.log(typeTrn)
                } else if (result.isDenied) {
                    typeTrn = 'L';
                    console.log(typeTrn)
                } else {
                    typeTrn = 'N';
                    console.log(typeTrn)
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
                    }
                    Swal.fire({
                        title: 'Transaksi Baru',
                        text: 'Buat Nomor Pesanan Baru?',
                        icon: 'question',
                        showDenyButton: 'true',
                        confirmButtonText: 'Ya',
                        denyButtonText: 'Tidak'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            ajaxSetup();
                            $.ajax({
                                url: 'http://172.20.28.17/BackOffice/public/bo/transaksi/penerimaan/input/getnewnobtb',
                                type: 'post',
                                data: {
                                    typeTrn: typeTrn
                                },
                                beforeSend: function() {
                                    Swal.showLoading();
                                    flagRecordId = 'N';
                                },
                                success: function(result) {
                                    Swal.close();
                                    if (result.length > 0) {
                                        btb_number.val(result);
                                    }
                                    btb_date.value = today.toISOString().substr(0, 10)
                                    btb_date.focus();
                                },
                                error: function(err) {
                                    console.log(err.responseJSON.message.substr(0, 100));
                                    alertError(err.statusText, err.responseJSON.message)
                                }
                            });
                        } else {
                            console.log('Cancel!')
                        }
                    })
                } else {
                    return false;
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
                Swal.fire(
                    'Data Kosong',
                    'Data Tidak Ditemukan',
                    'info'
                )
            }

            tableModalHelp.clear().destroy();

            tableModalHelp = $('#tableModalHelp').DataTable({
                ajax: 'http://172.20.28.17/BackOffice/public/bo/transaksi/penerimaan/input/showbtb/B',
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

        function closeTab() {
            card_display_data.hide();
            input_new_trn.show();
        }

        function openTab() {
            card_display_data.show();
            input_new_trn.hide();
        }

        // belum
        function editDeletePlu(data) {
            console.log(data)
        }

        function chooseBTB(noDoc, noPo) {
            ajaxSetup();
            $.ajax({
                url: 'http://172.20.28.17/BackOffice/public/bo/transaksi/penerimaan/input/choosebtb',
                type: "post",
                data: {
                    noDoc: noDoc,
                    noPO: noPo,
                    typeTrn: typeTrn
                },
                beforeSend: function() {
                    Swal.showLoading();
                    tempDataBTB = [];
                    flagRecordId = 'N';
                },
                success: function(result) {
                    if (result.kode == 0) {
                        Swal.fire("", result.msg, 'warning');
                    } else {
                        Swal.close();
                        $(document).trigger("stickyTable");
                        tempDataBTB = result.data;
                        console.log(result.data);
                        openTab();
                        modalHelp.modal('hide');
                        card_display_data.removeAttr('hidden');

                        // Populate
                        btb_number.val(result.data[0].trbo_nodoc);
                        ponumber.val(result.data[0].trbo_nopo);
                        supplier_name.val(result.data[0].trbo_kodesupplier);
                        supplier_value.val(result.data[0].sup_namasupplier);
                        fracture.val(result.data[0].trbo_nofaktur);
                        try {
                            fracture_date.val(result.data[0].trbo_tglfaktur.substr(0, 10));
                            btb_date.val((result.data[0].trbo_tgldoc.substr(0, 10)));
                            podate.val(formatDate((result.data[0].trbo_tglpo).substr(0, 10)));
                        } catch {
                            fracture_date.val('');
                            btb_date.val('');
                            podate.val('');
                        }

                        pkp_amt.val(result.data[0].sup_pkp);
                        // Right Table
                        setValueTableDetail(result.data);
                        showPLUBtn.removeAttr('disabled')
                        display_data.empty();

                        let table_head = `
                    <thead class="text-center">
                        <tr class="sticky-header">
                            <th class="sticky-cell" scope="col" style="min-width: 100px;">PLU</th>
                            <th class="sticky-cell" scope="col" style="min-width: 500px !important;">Deskripsi</th>
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
                            <th scope="col" class="text-center" style="min-width: 100px">$Disc 4</th>
                            <th scope="col" class="text-center" style="min-width: 100px">Disc 4</th>
                            <th scope="col" class="text-center" style="min-width: 150px">Gross</th>
                            <th scope="col" class="text-center" style="min-width: 70px">PPN</th>
                            <th scope="col" class="text-center" style="min-width: 150px">Average Cost</th>
                            <th scope="col" class="text-center" style="min-width: 150px">Last Cost</th>
                            </tr>
                        </thead>
                                    `;
                        display_data.append(table_head);
                        console.log(tempDataBTB.length)
                        for (var i = 0; i < tempDataBTB.length; i++) {
                            let value = tempDataBTB[i];
                            display_data.append(
                                `
                            <tr class="rowTbodyTableDetail" onclick="editDeletePlu('` + value.trbo_prdcd + `')">
                                <td class="sticky-cell">` + value.trbo_prdcd + `</td>
                                <td class="sticky-cell">` + value.barang + `</td>
                                <td class="text-right">` + parseInt(parseFloat(value.qty)) + `</td>
                                <td class="text-right">` + (value.trbo_qty - (parseInt(parseFloat(value.qty))) * value.trbo_frac) + `</td>
                                <td class="text-right"` + convertToRupiah(value.trbo_hrgsatuan) + `</td>
                                <td class="text-center">` + value.trbo_frac + `</td>
                                <td class="text-right">` + nvl(value.trbo_kodetag, ' ') + `</td>
                                <td class="text-right">` + nvl(value.trbo_bkp, ' ') + `</td>
                                <td class="text-right">` + value.trbo_qtybonus1 + `</td>
                                <td class="text-right">` + value.trbo_qtybonus2 + `</td>
                                <td class="text-right">` + convertToRupiah(value.trbo_persendisc1) + `</td>
                                <td class="text-right">` + convertToRupiah(value.trbo_rphdisc1) + `</td>
                                <td class="text-right">` + value.trbo_persendisc2 + `</td>
                                <td class="text-right">` + convertToRupiah(value.trbo_rphdisc2) + `</td>
                                <td class="text-right">` + value.trbo_persendisc2ii + `</td>
                                <td class="text-right">` + convertToRupiah(value.trbo_rphdisc2ii) + `</td>
                                <td class="text-right">` + value.trbo_persendisc2iii + `</td>
                                <td class="text-right">` + convertToRupiah(value.trbo_rphdisc2iii) + `</td>
                                <td class="text-right">` + value.trbo_persendisc3 + `</td>
                                <td class="text-right">` + convertToRupiah(value.trbo_rphdisc3) + `</td>
                                <td class="text-right">` + value.trbo_persendisc4 + `</td>
                                <td class="text-right">` + convertToRupiah2(value.trbo_rphdisc4) + `</td>
                                <td class="text-right">` + convertToRupiah2(value.trbo_gross) + `</td>
                                <td class="text-right">` + convertToRupiah2(value.trbo_ppnrph) + `</td>
                                <td class="text-right">` + convertToRupiah(value.trbo_averagecost) + `</td>
                                <td class="text-right">` + convertToRupiah(value.trbo_oldcost) + `</td>
                            </tr>
                            `);
                        }
                    }
                },
                error: function(err) {
                    Swal.close();
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message)
                }
            })
        }

        function setValue(data) {
            i_plu.val(data.i_prdcd);
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
                Swal.fire(
                    'Data Kosong',
                    'Data Tidak Ditemukan',
                    'info'
                )
            }
            tableModalHelp.clear().destroy();

            tableModalHelp = $('#tableModalHelp').DataTable({
                ajax: 'http://172.20.28.17/BackOffice/public/bo/transaksi/penerimaan/input/showpo/',
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

        function choosePO(noPo) {
            ajaxSetup();
            $.ajax({
                url: 'http://172.20.28.17/BackOffice/public/bo/transaksi/penerimaan/input/choosepo',
                type: 'post',
                data: {
                    typeTrn: typeTrn,
                    noPo: noPo
                },
                beforeSend: function() {
                    Swal.showLoading();
                    modalHelp.modal('hide');
                },
                success: function(result) {
                    Swal.close();
                    if (result.kode == 0) {
                        Swal.fire("", result.msg, 'warning');
                        ponumber.focus()
                    } else if (result.kode == 2) {
                        Swal.fire({
                            icon: 'warning',
                            text: result.msg,
                            buttons: false,
                            timer: 2000,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });
                    } else {
                        let data = result['data'][0];

                        ponumber.val(data.tpoh_nopo);
                        podate.val(formatDate(data.tpoh_tglpo.substr(0, 10)));
                        supplier_name.val(data.tpoh_kodesupplier);
                        supplier_value.val(data.sup_namasupplier);
                        pkp_amt.val(data.sup_pkp);
                        top_amt.val(data.tpoh_top);
                        showPLUBtn.removeAttr('disabled')
                        supplier_name.attr('disabled', true);
                        $('.btnLOVSupplier').attr('disabled', true);
                        fracture.focus();
                    }
                },
                error: function(err) {
                    Swal.close();
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                }
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
                ajax: 'http://172.20.28.17/BackOffice/public/bo/transaksi/penerimaan/input/showsupplier',
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
            console.log('test')
            if (typeTrn == 'L') {
                Swal.fire('', 'Kode Supplier Tidak Boleh Diisi!', 'warning')
                supplier_name.val('');
                supplier_value.val('');
            } else {
                supplier_name.val(kode);
                supplier_value.val(nama);
                pkp_amt.val(val_pkp);
                top_amt.val(top);
                showPLUBtn.removeAttr('disabled')
            }
            fracture.focus();
            modalHelp.modal('hide');
        }

        function showPLU(value) {
            let supplier = supplier_name.val();
            let noPo = ponumber.val();
            let typeLov = '';

            if (typeTrn == 'B') {
                if (btb_number == '') {
                    if (supplier == '') {
                        Swal.fire({
                            icon: 'info',
                            title: "Mohon isi Supplier",
                            buttons: false,
                            timer: 2000,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });

                        supplier_name.focus();
                    } else {
                        typeLov = 'PLU';
                    }
                } else {
                    if (supplier != '') {
                        typeLov = 'PLU_PO';
                    } else {
                        supplier_name.focus();
                    }
                }
            } else {
                typeLov = 'LOV155';
            }

            console.log(typeLov);
            ajaxSetup();
            $.ajax({
                url: 'http://172.20.28.17/BackOffice/public/bo/transaksi/penerimaan/input/showplu',
                type: 'post',
                data: {
                    typeTrn: typeTrn,
                    value: value,
                    supplier: supplier,
                    noPo: noPo,
                    typeLov: typeLov
                },
                beforeSend: () => {
                    Swal.showLoading();
                    tbodyModalHelpPLU.empty();
                },
                success: function(result) {
                    Swal.close();
                    console.log(result)
                    for (var i = 0; i < result.length; i++) {
                        let value = result[i];
                        tbodyModalHelpPLU.append(`
                            <tr class="modalRowPLU" onclick="choosePLU(` + value.tpod_prdcd + `)">
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
                    Swal.close();
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function choosePLU(plu) {
            let prdcd = plu;
            let noDoc = btb_number.val();
            let noPo = ponumber.val();
            let supplier = supplier_name.val();

            let tempData = (tempDataBTB.length < 1) ? tempDataSave : tempDataBTB;

            ajaxSetup();
            $.ajax({
                url: 'http://172.20.28.17/BackOffice/public/bo/transaksi/penerimaan/input/chooseplu',
                type: 'post',
                data: {
                    typeTrn: typeTrn,
                    prdcd: prdcd,
                    noDoc: noDoc,
                    noPo: noPo,
                    supplier: supplier,
                    tempData: tempData
                },
                beforeSend: function() {
                    Swal.showLoading();
                    i_rphdisc1.attr('disabled', false)
                    i_rphdisc2.attr('disabled', false)
                    i_rphdisc2a.attr('disabled', false)
                    i_rphdisc2b.attr('disabled', false)
                    i_rphdisc3.attr('disabled', false)
                    i_rphdisc4.attr('disabled', false)
                },
                success: function(result) {
                    Swal.close()
                    closePLUBtn.click();
                    $('.modal-backdrop').remove()
                    console.log(result)

                    if (result.kode == '0') {
                        let data = result.data;
                        tempDataPLU = data;
                        setValue(data);
                        i_hrgbeli.focus();

                    } else if (result.kode == '2') {
                        Swal.fire({
                            icon: 'warning',
                            text: result.msg,
                            buttons: false,
                            timer: 2000,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });

                        setTimeout(function() {
                            i_plu.val(prdcd);
                            i_plu.focus();
                        }, 2000);
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

            console.log(noDoc);
            console.log(noPo);

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
                grantTotal = parseInt(grantTotal) + (gross + ppn + ppbbm + ppnbotol - discount);

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
            ponumber.val('');
            btb_date.val('');
            podate.val('');
            supplier_name.val('');
            supplier_value.val('');
            fracture.val('');
            fracture_date.val('');
            pkp_amt.val('');
            top_amt.val('');
        }

        function rekamData() {
            if (!i_plu.val()) {
                Swal.fire({
                    text: 'Mohon isi PLU!',
                    icon: 'warning',
                    timer: 1500,
                    buttons: {
                        confirm: false,
                    },
                });
                i_plu.focus();
                return false;
            }
            ajaxSetup();
            $.ajax({
                url: 'http://172.20.28.17/BackOffice/public/bo/transaksi/penerimaan/input/rekamdata',
                type: 'post',
                data: {
                    prdcd: i_plu.val(),
                    noBTB: btb_number.val(),
                    noPo: ponumber.val(),
                    tempDataPLU: tempDataPLU,
                    tempDataSave: tempDataSave
                },
                beforeSend: () => {
                    Swal.showLoading();
                },
                success: (result) => {
                    Swal.close();
                    console.log((result))

                    if (result.kode == 0) {
                        Swal.fire('', result.msg, 'warning');
                        window.location.reload(); // Di refresh akrna di ias keluar dari menu input penerimaan
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
                            grantTotal = parseInt(grantTotal) + parseInt(tempDataSave[i].total_rph);
                        }

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
                    Swal.close();
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

        // belum
        function transferPO() {

        }

        // belum
        function viewList() {

        }

        // belum
        function saveData() {

        }
    </script>
    @endsection