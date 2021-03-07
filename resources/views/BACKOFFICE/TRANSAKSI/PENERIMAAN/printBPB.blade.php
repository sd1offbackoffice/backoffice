@extends('navbar')
@section('title','PENERIMAAN | PEMBATALAN BPB')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <form>
                            <div class="form-group row mb-1 pt-4">
                                <label class="col-sm-2 col-form-label text-right">Nomor BPB</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control text-uppercase" id="noBTB">
                                    <button id="btn-no-doc" type="button" class="btn btn-lov p-0" onclick="showBTB()">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label text-right">Supplier</label>
                                <div class="col-sm-5 buttonInside">
                                    <input type="text" class="form-control" id="namaSupplier" disabled>
                                </div>
                            </div>

                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label text-right">Total Rp.</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control text-right" id="grantTotal" disabled>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <button class="btn btn-primary col-sm-2 offset-sm-9 btn-block" type="button" onclick="batalBPB()">Pembatalan BPB</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <table  class="table table-sm table-striped table-bordered " id="tableInquery">
                            <thead class="theadDataTables">
                            <tr>
                                <th>PLU</th>
                                <th>Nama Barang</th>
                                <th>Kemasan</th>
                                <th>Kuantum</th>
                                <th>H.P.P</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody class="tbodyTableInquery"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal LOV-->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="m_lov" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar BTB</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="tableModalHelp">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th> No BPB </th>
                                        <th>Tanggal</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <style>
        .modalRowBTB:hover, .tbodyTableInqueryRow:hover{
            background-color: #e9ecef;
            cursor: pointer;
        }


    </style>



@endsection
