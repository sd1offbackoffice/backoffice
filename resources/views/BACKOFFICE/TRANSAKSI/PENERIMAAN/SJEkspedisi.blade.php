@extends('navbar')
@section('title','PENERIMAAN | INPUT')
@section('content')

<div class="container" style="min-width: 50%;">
    <div class="card border-dark">
        <div class="card-body cardForm">
            <fieldset class="card border-dark">
                <legend class="w-auto ml-5">HEADER</legend>
                <div class="container p-4" style="min-width: 100%;">
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="nodoc" style="width: 100px;">NO TRN</span>
                                </div>
                                <input type="text" class="form-control" id="nodoc_val" aria-describedby="nodoc">
                                <button class="btn btn btn-light" type="button" id="btnShow" data-toggle="modal" data-target="#m_lov_trn">&#x1F50E;</button>
                            </div>
                            <div class=" input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="noreff" style="width: 100px;">NO. REFF</span>
                                </div>
                                <input type="text" class="form-control" id="noreff_val" aria-describedby="noreff">
                                <button class="btn btn btn-light" type="button" id="btnShow" data-toggle="modal" data-target="#m_lov_ipb">&#x1F50E;</button>
                            </div>
                            <span style="display: block; height: 25px;"></span>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="tgltrn" style="width: 100px;">TGL. TRN</span>
                                </div>
                                <input type="text" id="tgltrn_val" class="form-control" aria-describedby="tgltrn">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="tglreff" style="width: 100px;">TGL. REFF</span>
                                </div>
                                <input type="text" id="tglreff_val" class="form-control" aria-describedby="tglreff">
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="tujuan" style="width: 100px;">UTK CAB</span>
                                </div>
                                <input type="text" id="tujuan_val" class="form-control" aria-describedby="tujuan">
                                <button class="btn btn btn-light" type="button" id="btnShow" data-toggle="modal" data-target="#m_lov_cabang">&#x1F50E;</button>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="gudang" style="width: 100px;">GUDANG</span>
                                </div>
                                <input type="text" id="gudang_val" class="form-control" aria-describedby="gudang">
                            </div>
                            <button class="btn btn-danger btn-block" id="btnDelete" onclick="deleteDoc()">HAPUS DOKUMEN</button>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="ipb" style="width: 100px;">IPB</span>
                                </div>
                                <input type="text" id="ipb_val" class="form-control" aria-describedby="ipb">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="model" style="width: 100px;">MODEL</span>
                                </div>
                                <input type="text" id="model_val" class="form-control" aria-describedby="model">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="card border-dark">
                <legend class="w-auto ml-5">DETAIL</legend>
                <div class="container p-4">
                    <div class="row">
                        <table class="table table-borderless" id="tableModalHelp">
                            <thead class="theadDataTables">
                                <tr>
                                    <th rowspan="2" id="table_plu" style="text-align: center"></th>
                                    <th rowspan="2" id="table_plu" style="text-align: center">PLU</th>
                                    <th rowspan="2" id="table_deskripsi" style="text-align: center">DESKRIPSI</th>
                                    <th rowspan="2" id="table_satuan" style="text-align: center">SATUAN</th>
                                    <th rowspan="2" id="table_tag" style="text-align: center">TAG</th>
                                    <th colspan="2" id="table_stock" style="text-align: center">STOCK</th>
                                    <th colspan="2" id="table_satuan" style="text-align: center">HRG SATUAN</th>
                                    <th colspan="1" id="table_kuantum" style="text-align: center">KUANTUM</th>
                                    <th rowspan="2" id="table_gross" style="text-align: center">GROSS</th>
                                    <th rowspan="2" id="table_ppn" style="text-align: center">PPN</th>
                                    <th rowspan="2" id="table_keterangan" style="text-align: center">KETERANGAN</th>
                                </tr>
                                <tr>
                                    <th style="width: 50px; text-align: center">CTN</th>
                                    <th style="width: 50px; text-align: center">PCs</th>
                                    <th style="width: 50px; text-align: center">CTN</th>
                                    <th style="width: 50px; text-align: center">PCs</th>
                                    <th style="width: 50px; text-align: center">(IN CTN)</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyModalHelp"></tbody>
                            <tr>
                                <td style="text-align: center"><button class="btn btn-danger" id="btnDelete" onclick="deleteDoc()"><i class="fa fa-close" style="font-size:24px;color:white"></i></button></td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName2">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName3">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName4">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName5">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName6">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName2">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName3">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName4">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName5">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName5">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName5">TEST</td>
                                <td style="text-align: center; vertical-align: middle;" id="modalThName5">TEST</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </fieldset>
            <fieldset class="card border-dark">
                <legend class="w-auto ml-5">DETAIL</legend>
                <div class="container p-4" style="min-width: 100%;">
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="tot_item" style="width: 115px;">TOTAL ITEM</span>
                                </div>
                                <input type="text" id="tot_item_val" class="form-control" aria-describedby="tot_item">
                            </div>
                            <h4><span class="badge badge-primary">ALT + S - Simpan Data</span></h4>
                        </div>
                        <span style="display: inline-block; width: 25%;"></span>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="tot_gross" style="width: 100px;">GROSS</span>
                                </div>
                                <input type="text" id="tot_gross_val" class="form-control" aria-describedby="tot_gross">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="tot_ppn" style="width: 100px;">PPN</span>
                                </div>
                                <input type="text" id="tot_ppn_val" class="form-control" aria-describedby="tot_ppn">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="total" style="width: 100px;">TOTAL</span>
                                </div>
                                <input type="text" id="total_val" class="form-control" aria-describedby="total">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

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
                                        <th id="modalThName5"></th>
                                        <th id="modalThName6"></th>
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

<style>
    .modalRowBPB {
        cursor: pointer;
    }

    .modalRowBPB:hover {
        background-color: #e9ecef;
    }
</style>

<script>
    function showData() {

    }
</script>
@endsection