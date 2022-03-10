@extends('navbar')
@section('title','Input Pengeluaran')
@section('content')

    <div class="container-fluid mt-4" xmlns="http://www.w3.org/1999/html">
        <div class="row-justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form">
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="...">NOMOR TRN</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" class="form-control" id="txtNoDoc">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov_trn" data-toggle="modal" id="btn-lov-trn">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="btnHapusDocument" class="btn btn-danger float-left" disabled>
                                                <i class="icon fas fa-trash"></i>Hapus Dokumen</button>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" id="txtModel" class="text-center form-control" disabled>
                                        </div>
                                        <div class="offset-2 col-sm-2">
                                            <button type="button" id="btnSimpan" class="btn btn-primary">
                                                <i class="icon fas fa-save"></i>Simpan</button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="...">TANGGAL</label>
                                        <div class="col-sm-2">
                                            <input type="text" id="dtTglDoc" class="text-center form-control">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="...">SUPPLIER</label>
                                        <div class="col-sm-2">
                                            <input type="text" id="dtTglDoc" class="text-center form-control">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov_supplier" data-toggle="modal" id="btn-lov-trb"></button>
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <input type="text" id="txtNmSupplier" class="form-control" disabled>
                                    </div>
                                    <label class="col-form-label text-sm-right col-sm-1" style="...">PKP</label>
                                    <div class="col-sm-1">
                                        <input type="text" id="txtPKP" class="form-control text-center" disabled>
                                    </div>
                                    <div class="offset-1 col-sm-2">
                                        <button type="button" class="btn btn-info" data-target="#m_usulan_return" data-toggle="modal" id="btnUsulanRetur">
                                            <i class="icon fas fa-upload"></i>Usulan Retur</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card-border-dark card-hdr cardForm">
                    <legend class="w-auto ml-5">Header</legend>
                    <div class="card-body">
                        <div class="card-body p-0 tableFixedHeader">
                            <table class="table table-sm table-bordered table-striped" id="table-header">
                                <thead class="theadDataTables">
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small"></th>
                                    <th width="10%" class="text-center small">PLU</th>
                                    <th width="20%" class="text-center small">DESKRIPSI</th>
                                    <th width="10%" class="text-center small">SATUAN</th>
                                    <th width="7%" class="text-center small">BKP</th>
                                    <th width="7%" class="text-center small">STOCK</th>
                                    <th width="7%" class="text-center small">CTN</th>
                                    <th width="7%" class="text-center small">PCS</th>
                                    <th width="29%" class="text-center small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-header"></tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>



                <fieldset class="card-border-dark card-dtl">
                    <legend class="w-auto ml-5">Detail</legend>
                    <div class="card-body card-form">
                        <div class="card-body p-0 tableFixedHeader" style="...">
                            <table class="table table-sm table-bordered table-striped" id="table-detail">
                                <thead class="theadDataTables">
                                <tr class="table-sm text-center">
                                    <th class="text-center small">PLU</th>
                                    <th class="text-center small">DESKRIPSI</th>
                                    <th class="text-center small">SATUAN</th>
                                    <th width="3%" class="text-center small">BKP</th>
                                    <th width="5%" class="text-center small">STOCK</th>
                                    <th class="text-center small">HRG.SATUAN (IN CTN)</th>
                                    <th width="4%" class="text-center small">CTN</th>
                                    <th width="4%" class="text-center small">PCS</th>
                                    <th class="text-center small">GROSS</th>
                                    <th width="3%" class="text-center small">DISC %</th>
                                    <th class="text-center small">DISC Rp</th>
                                    <th width="4%" class="text-center small">PPN</th>
                                    <th class="text-center small">FAKTUR</th>
                                    <th class="text-center small">PAJAK No.</th>
                                    <th class="text-center small">TGL FP</th>
                                    <th class="text-center small">NoReff BTB</th>
                                    <th class="text-center small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-header"></tbody>
                            </table>
                        </div>

                        <input type="text" id="label-deskripsi" class="text-center form-control col-sm-6 font-weight-bold" disabled>
                    </div>
                </fieldset>

                <fieldset class="card-border-dark">
                    <legend class="w-auto ml-5">Total</legend>
                    <div class="card-body cardForm">
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right" style="...">TOTAL ITEM</label>
                            <input type="text" id="total-item" class="text-center form-control col-sm-2" disabled>
                            <label class="col-sm-1 col-form-label text-sm-right offset-3" style="...">GROSS</label>
                            <input type="text" id="gross" class="text-center form-control col-sm-2" disabled>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6" style="..."></label>
                            <input type="text" id="potongan" class="text-center form-control col-sm-2" disabled>
                        </div>

                        </div>
                </fieldset>

            </div>


        </div>
    </div>


    {{--Modal NODOK RETUR--}}
    <div class="modal fade" id="m_lov_trn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>
                        Nomor Trn
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov_notrn">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>No. Doc</td>
                                        <td>Tgl. Doc</td>
                                        <td>Nota</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    {{--MODAL KODE SUPPLIER--}}
    <div class="modal fade" id="m_lov_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Supplier</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov_supplier">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>Supplier</td>
                                        <td>Kode</td>
                                        <td>PKP</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    {{--MODAL PLU--}}
    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Supplier</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov_plu">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>PLU</td>
                                        <td>Deskripsi</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>


<div class="modal fade" id="m_usulan_retur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Usulan Retur Melebihi Batas Retur</h5>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="form-group row mb-0">
                        <label class="col-sm-2 col-form-label text-sm-right" style="...">No. Dok</label>
                        <div class="col-sm-3">
                            <input type="text" id="text-usl-nodok" class="text-center form-control" disabled>
                        </div>
                        <div class="col-sm-5">
                            <input type="text" id="text-usl-status" class="text-center form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <label class="col-sm-2 col-form-label text-sm-right" style="...">Supplier</label>
                        <div class="com-sm-2">
                            <input type="text" id="txt-usl-kode-supplier" class="text-center form-control" disabled>
                        </div>
                        <div class="col-sm-5">
                            <input type="text" id="text-usl-status" class="text-center form-control" disabled>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
