@extends('navbar')
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Master Barang</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="b_kodeplu" class="col-sm-2 col-form-label">PLU</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_kodeplu">
                                    </div>
                                    <label for="b_tgldaftar" class="col-sm-2 col-form-label">Tgl Daftar</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="i_deskripsi" disabled>
                                    </div>
                                    <label for="b_barcode" class="col-sm-2 col-form-label">Barcode (E.A.N.)</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_barcode" disabled>
                                    </div>
                                    <label for="b_pluho" class="col-sm-2 col-form-label">PLU H.O</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_pluho" disabled>
                                    </div>
                                    <label for="b_tgldisc" class="col-sm-2 col-form-label">Tgl Disc</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_tgldsc" disabled>
                                    </div>
                                    <label for="b_barcode" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_barcode" disabled>
                                    </div>
                                    <label for="b_plusupp" class="col-sm-2 col-form-label">PLU Supplier</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="b_plusupp" disabled>
                                    </div>
                                    <label for="b_statsup" class="col-sm-5 col-form-label">Status Barcode</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="b_statsup" disabled>
                                    </div>
                                    <label for="b_nmbrg" class="col-sm-2 col-form-label">Nama Barang 1.</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="b_nmbrg" disabled>
                                    </div>
                                    <label for="b_tglaktif" class="col-sm-3 col-form-label">Tgl Aktif Kembali</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_tglaktif" disabled>
                                    </div>
                                    <label for="b_nmbrg2" class="col-sm-2 col-form-label">2.</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="b_nmbrg2" disabled>
                                    </div>

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs custom-color" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="btn-b_deskripsi" data-toggle="tab" href="#b_deskripsi">Deskripsi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="btn-b_harga" data-toggle="tab" href="#p_identitas2">Harga</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="btn-b_dimensi" data-toggle="tab" href="#b_dimensi">Dimensi</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div id="b_deskripsi" class="container tab-pane active pl-0 pr-0 fix-height">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-right">
                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <label for="b_divisi" class="col-sm-2 col-form-label">Divisi</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="b_divisi">
                                                    </div>
                                                    <label for="b_namadiv">-</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" id="b_divisi">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <label for="b_departemen" class="col-sm-2 col-form-label">Departemen</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="b_departemen">
                                                    </div>
                                                    <label for="b_namadepartemen">-</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" id="b_namadepartemen">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <label for="b_kategori" class="col-sm-2 col-form-label">Kategori</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="b_kategori">
                                                    </div>
                                                    <label for="b_namakategori">-</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="b_namakategori">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <label for="b_kategoritoko" class="col-sm-2 col-form-label">Kategori Toko</label>
                                                    <div class="col-sm-1">
                                                        <input type="text" class="form-control" id="b_kategoritoko">
                                                    </div>
                                                    <label for="b_flag" class="col-sm-5 col-form-label">Flag Cabang</label>
                                                    <div class="col-sm-1">
                                                        <input type="text" class="form-control" id="b_flag">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <label for="b_statustag" class="col-sm-2 col-form-label">Status Tag</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="b_statustag">
                                                    </div>
                                                    <label for="b_statustag2">-</label>
                                                    <div class="col-sm-5">
                                                        <input type="text" class="form-control" id="b_statustag2">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <label for="b_bkp" class="col-sm-2 col-form-label">BKP</label>
                                                    <div class="col-sm-1">
                                                        <input type="text" class="form-control" id="b_bkp">
                                                    </div>
                                                    <label for="b_kodedivpo" class="col-sm-3 col-form-label">Kode Divisi PO</label>
                                                    <div class="col-sm-1">
                                                        <input type="text" class="form-control" id="b_kodedivpo">
                                                    </div>
                                                    <label for="b_kelipatan" class="col-sm-3 col-form-label">Kelipatan Order</label>
                                                    <div class="col-sm-1">
                                                        <input type="text" class="form-control" id="b_kelipatan">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    {{--<label for="b_satju" class="col-sm-2 col-form-label">Satuan Jual</label>--}}
                                                    {{--<div class="col-sm-1">--}}
                                                        {{--<input type="text" class="form-control" id="b_satju>--}}
                                                    {{--</div>--}}
                                                </div>
                                            </div>
                                        </div>

                                    </div>





                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

    </div>