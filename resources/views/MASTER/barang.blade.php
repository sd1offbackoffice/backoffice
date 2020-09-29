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
                                <div class="form-group item text-center">
                                    <label class="mstbarang">HELP MASTER BARANG</label>
                                    <button type="button" class="btn p-0 showModal" data-toggle="modal" data-target="#modal_plu"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                    <label>HELP MASTER BARANG IDM</label>
                                    <button type="button" class="btn p-0 showModal" data-toggle="modal" data-target="#modal_idm"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                    <label>HELP MASTER BARANG OMI</label>
                                    <button type="button" class="btn p-0 showModal" data-toggle="modal" data-target="#modal_omi"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="b_kodeplu" class="col-sm-2 col-form-label">PLU</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_kodeplu">
                                    </div>
                                    <label for="b_tgldaftar" class="col-sm-2 col-form-label">Tgl Daftar</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_tgldaftar" disabled>
                                    </div>
                                    <label for="b_barcode" class="col-sm-2 col-form-label">Barcode (E.A.N.)</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_barcode" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="b_pluho" class="col-sm-2 col-form-label">PLU H.O</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_pluho" disabled>
                                    </div>
                                    <label for="b_tgldisc" class="col-sm-2 col-form-label">Tgl DISC</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_tgldisc" disabled>
                                    </div>
                                    <label for="b_barcode2" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_barcode2" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="b_plusupp" class="col-sm-2 col-form-label">PLU Supplier</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="b_plusupp" disabled>
                                    </div>
                                    <label for="b_statbarcode" class="col-sm-5 col-form-label">Status Barcode</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="b_statbarcode" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="b_nmbrg" class="col-sm-2 col-form-label">Nama Barang 1.</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="b_nmbrg" disabled>
                                    </div>
                                    <label for="b_tglaktif" class="col-sm-3 col-form-label">Tgl Aktif Kembali</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_tglaktif" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="b_nmbrg2" class="col-sm-2 col-form-label">2.</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="b_nmbrg2" disabled>
                                    </div>
                                </div>

                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs custom-color mt-1" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="btn-b_deskripsi" data-toggle="tab" href="#b_deskripsi">Deskripsi</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="btn-b_harga" data-toggle="tab" href="#b_harga">Harga</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="btn-b_dimensi" data-toggle="tab" href="#b_dimensi">Dimensi</a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" style="border-bottom: 1px solid black">
                                        <div id="b_deskripsi" class="container tab-pane active pl-0 pr-0 fix-height" style="height: 480px">
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="d_divisi" class="col-sm-2 col-form-label">Divisi</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_divisi"  disabled>
                                                            </div>
                                                            {{--<label for="d_namadiv">-</label>--}}
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="d_namadiv" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_departemen" class="col-sm-2 col-form-label">Departemen</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_departemen" disabled>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="d_namadepartemen" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_kategori" class="col-sm-2 col-form-label">Kategori</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kategori" disabled>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="d_namakategori" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_kategoritoko" class="col-sm-2 col-form-label">Kategori Toko</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kategoritoko" disabled>
                                                            </div>
                                                            <label for="d_flagcbg" class="col-sm-3 col-form-label">Flag Cabang</label>
                                                                <div class="col-sm-1">
                                                                    <input type="text" class="form-control" id="d_flagcbg" disabled>
                                                                </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_statustag" class="col-sm-2 col-form-label">Status Tag</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_statustag" disabled>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="d_statustag2" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_bkp" class="col-sm-2 col-form-label">BKP</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_bkp" disabled>
                                                            </div>
                                                            <label for="d_kodedivpo" class="col-sm-3 col-form-label">Kode Divisi PO</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kodedivpo" disabled>
                                                            </div>
                                                            <label for="d_kelipatan" class="col-sm-3 col-form-label">Kelipatan Order</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kelipatan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_satju" class="col-sm-2 col-form-label">Satuan Jual</label>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" id="d_satju" disabled>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" id="d_satju2" disabled  style="width: 80px">
                                                        </div>
                                                            <label for="d_satbe" class="col-sm-2 col-form-label">Satuan Beli</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_satbe" disabled>
                                                            </div>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" id="d_satbe2" disabled  style="width: 80px">
                                                        </div>
                                                            <label for="d_satstok" class="col-sm-2 col-form-label">Satuan Stok</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_satstok" disabled>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_satstok2" disabled  style="width: 80px">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_qtymin" class="col-sm-2 col-form-label">Qty Min Order</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_qtymin" disabled  style="width: 80px">
                                                            </div>
                                                            <label class="ml-3 mt-1 mb-0" style="margin-right: -16px">(PCS)</label>
                                                            <label for="d_kondisi" class="col-sm-3 col-form-label" style="margin-left: -40px">Kondisi</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kondisi" disabled>
                                                            </div>
                                                            <label for="d_flaggdg" class="col-sm-3 col-form-label">Flag Gudang Pusat</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_flaggdg" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_grupbrg" class="col-sm-2 col-form-label">Group Barang</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="d_grupbrg" disabled>
                                                            </div>
                                                            <label for="d_grupjual" class="col-sm-2 col-form-label">Group Jual</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="d_grupjual" disabled>
                                                            </div>
                                                            <label for="d_minor" class="col-sm-2 col-form-label">MINOR Y</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="d_minor" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_hargabdr" class="col-sm-2 col-form-label">Harga Bandrol</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_hargabdr" disabled>
                                                            </div>
                                                            <label for="d_labelhrg" class="col-sm-3 col-form-label" >Label Harga</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_labelhrg" disabled>
                                                            </div>
                                                            <label for="d_ordertoko" class="col-sm-3 col-form-label">Order Toko</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_ordertoko" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_tdkdiskon" class="col-sm-2 col-form-label">Tidak Diskon</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_tdkdiskon" disabled>
                                                            </div>
                                                            <label for="d_openprice" class="col-sm-3 col-form-label">Open Price</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_openprice" disabled>
                                                            </div>
                                                            <label for="d_minimjual" class="col-sm-3 col-form-label">Minimum Jual</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_minimjual" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="b_harga" class="container tab-pane fade pl-0 pr-0 fix-height" style="height: 480px">
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hppterakhir" class="col-sm-3 col-form-label">HPP Terakhir</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="h_hppterakhir" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hpprata" class="col-sm-3 col-form-label">HPP Rata2</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="h_hpprata" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="h_stdmrg" class="col-sm-3 col-form-label">STD Margin</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control text-right" id="h_stdmrg" disabled style="width: 80px">
                                                            </div>
                                                            <label class="ml-3 mt-2">(%)</label>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hrgjual" class="col-sm-3 col-form-label">Harga Jual</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="h_hrgjual" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="h_marginaktual" class="col-sm-3 col-form-label">Margin Aktual</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control text-right" id="h_marginaktual" disabled style="width: 80px">
                                                            </div>
                                                            <label class="ml-3 mt-2">(%)</label>
                                                            <label for="h_tglaktif" class="col-sm-3 col-form-label" style="margin-left: 47px">Tgl Aktif</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="h_tglaktif" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hrgjualbaru" class="col-sm-3 col-form-label">Harga Jual Baru</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="h_hrgjualbaru" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_marginaktual2" class="col-sm-3 col-form-label">Margin Aktual</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control text-right" id="h_marginaktual2" disabled style="width: 80px">
                                                            </div>
                                                            <label class="ml-3 mt-2 mb-0">(%)</label>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_tglberlaku" class="col-sm-3 col-form-label">Tgl Berlaku</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="h_tglberlaku" disabled>
                                                            </div>
                                                            <label for="h_flagnondistfee" class="col-sm-2 col-form-label">Flag Non Dist Fee</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="h_flagnondistfee" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="b_dimensi" class="container tab-pane fade pl-0 pr-0 fix-height" style="height: 480px">
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="di_lebarprod" class="col-sm-4 col-form-label">Dimensi Lebar Produk</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_lebarprod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_panjangprod" class="col-sm-4 col-form-label">Dimensi Panjang Produk</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_panjangprod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="di_tinggiprod" class="col-sm-4 col-form-label">Dimensi Tinggi Produk</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_tinggiprod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="di_flagexpr" class="col-sm-4 col-form-label">Flag Export</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_flagexpr" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_lebarkemasan" class="col-sm-4 col-form-label">Dimensi Lebar Kemasan Produk</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_lebarkemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_panjangkemasan" class="col-sm-4 col-form-label">Dimensi Panjang Kemasan Produk</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_panjangkemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="di_tinggikemasan" class="col-sm-4 col-form-label">Dimensi Tinggi Kemasan Produk</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_tinggikemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_beratpcs" class="col-sm-4 col-form-label">Berat Kotor PCS</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_beratpcs" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_beratctn" class="col-sm-4 col-form-label">Berat Kotor CTN</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_beratctn" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_beratbox" class="col-sm-4 col-form-label">Berat Kotor BOX</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_beratbox" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="card-body">
                                    <div class="row text-right">
                                        <div class="col-sm-12">
                                            <div class="form-group row mb-0">
                                                <label for="b_updateakhir" class="col-sm-2 col-form-label">Update Akhir</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="b_updateakhir" disabled>
                                                </div>
                                                <input type="text" class="form-control mr-3" id="b_updateakhir2" disabled="" style="width: 70px">
                                                {{--<div class="col-sm-1 ml-0">--}}
                                                    {{--<input type="text" class="form-control" id="b_updateakhir2" disabled="" style="width: 70px">--}}
                                                {{--</div>--}}
                                                <label for="b_tglpromo" class="col-sm-3 col-form-label" style="margin-right: 2px">Tanggal Promo</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="b_tglpromo" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label for="b_jampromo" class="col-sm-9 col-form-label">Jam Promo</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="b_jampromo" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="b_hrgpromo" class="col-sm-9 col-form-label">Harga Promo</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="b_hrgpromo" disabled>
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

    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12 text-center">
                                <label for="">LOADING...</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_plu" tabindex="-1" role="dialog" aria-labelledby="modal_plu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="helpSearch" class="form-control helpSearch" type="text" placeholder="Inputkan Nama / Kode Barang" aria-label="Search" search="plu">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter</div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm" id="table_lov">
                                        <thead class="header_lov">
                                        <tr class="font">
                                            <td>Nama Produk</td>
                                            <td>PLU</td>
                                            <td>PLU Supplier</td>
                                            <td>Singkatan</td>
                                        </tr>
                                        </thead>
                                        <tbody class="tbodyTableSearch">
                                        {{--@foreach($plu as $s)--}}
                                            {{--<tr onclick="show('{{ $s->prd_prdcd }}')" class="row_lov">--}}
                                                {{--<td>{{ $s->prd_deskripsipanjang }}</td>--}}
                                                {{--<td>{{ $s->prd_prdcd }}</td>--}}
                                                {{--<td>{{ $s->prd_plusupplier }}</td>--}}
                                                {{--<td>{{ $s->prd_deskripsipendek }}</td>--}}
                                            {{--</tr>--}}
                                        {{--@endforeach--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_pluIdm" tabindex="-1" role="dialog" aria-labelledby="modal_pluIdm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="helpSearch" class="form-control helpSearch" type="text" placeholder="Inputkan Nama / Kode Barang IDM" aria-label="Search" search="idm">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter</div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                <table class="table table-lg" id="table_lov">
                                    <thead class="header_lov">
                                    <tr class="font" >
                                        <td>Deskripsi</td>
                                        <td>PLU IGR</td>
                                        <td>PLU IDM</td>
                                        <td>Tag</td>
                                        <td>Harga</td>
                                        <td>Renceng</td>
                                        <td>Minor</td>
                                        <td>Min</td>
                                        <td>Max</td>
                                        <td>Tgl Promo</td>
                                        <td>Hrg Promo</td>
                                    </tr>
                                    </thead>
                                    <tbody class="tbodyTableSearch">
                                    {{--@foreach($pluIdm as $p)--}}
                                        {{--<tr onclick="show('{{ $p->prd_prdcd}}')" class="row_lov">--}}
                                            {{--<td>{{ $p->prd_deskripsipanjang }}</td>--}}
                                            {{--<td>{{ $p->prc_pluigr }}</td>--}}
                                            {{--<td>{{ $p->prc_pluidm }}</td>--}}
                                            {{--<td>{{ $p->prc_kodetag }}</td>--}}
                                            {{--<td>{{ $p->prc_hrgjual }}</td>--}}
                                            {{--<td>{{ $p->prc_satuanrenceng}}</td>--}}
                                            {{--<td>{{ $p->prc_minorder}}</td>--}}
                                            {{--<td>{{ $p->prc_minorderomi}}</td>--}}
                                            {{--<td>{{ $p->prc_maxorderomi}}</td>--}}
                                            {{--<td>{{ $p->prc_datek}}</td>--}}
                                            {{--<td>{{ $p->prc_pricek}}</td>--}}
                                        {{--</tr>--}}
                                    {{--@endforeach--}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="modal_pluOmi" tabindex="-1" role="dialog" aria-labelledby="modal_pluOmi" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="helpSearch" class="form-control helpSearch" type="text" placeholder="Inputkan Nama / Kode Barang OMI" aria-label="Search" search="omi">
                        <div class="invalid-feedback"> Inputkan minimal 3 karakter</div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm" id="table_lov">
                                        <thead class="header_lov">
                                        <tr class="font">
                                            <td>Deskripsi</td>
                                            <td>PLU IGR</td>
                                            <td>PLU IDM</td>
                                            <td>Tag</td>
                                            <td>Renceng</td>
                                            <td>Minor</td>
                                            <td>Min</td>
                                            <td>Max</td>
                                            <td>Tgl Promo</td>
                                            <td>Hrg Promo</td>
                                        </tr>
                                        </thead>
                                        <tbody class="tbodyTableSearch">
                                        {{--@foreach($pluOmi as $o)--}}
                                            {{--<tr onclick="show('{{ $o->prd_prdcd }}')" class="row_lov">--}}
                                                {{--<td>{{ $o->prd_deskripsipanjang }}</td>--}}
                                                {{--<td>{{ $o->prc_pluigr }}</td>--}}
                                                {{--<td>{{ $o->prc_pluidm }}</td>--}}
                                                {{--<td>{{ $o->prc_kodetag }}</td>--}}
                                                {{--<td>{{ $o->prc_satuanrenceng}}</td>--}}
                                                {{--<td>{{ $o->prc_minorder}}</td>--}}
                                                {{--<td>{{ $o->prc_minorderomi}}</td>--}}
                                                {{--<td>{{ $o->prc_maxorderomi}}</td>--}}
                                                {{--<td>{{ $o->prc_datek}}</td>--}}
                                                {{--<td>{{ $o->prc_pricek }}</td>--}}
                                            {{--</tr>--}}
                                        {{--@endforeach--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>


    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }
        label {
            color: #232443;
            /*color: #8A8A8A;*/
            font-weight: bold;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .header_lov{
            background-color: #000000;
            position: sticky; top: 0;
        }
        .font{
            color: #ffffff;
            font-weight: bold;
        }
        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
        }
        .item{
            /*padding: 15px;*/
            /*border: 1px solid black;*/
            /*margin-left: -20px;*/
            /**zoom: 1;*/
            margin-bottom: 20px;
        }
        </style>

    <script>

        $(document).ready(function(){
            show('1');
        });

        $(document).on('keypress', '.helpSearch', function (e) {
            if (e.which == 13) {
                let type = this['attributes'][5]['nodeValue']
                let search = $(this).val()

                if (search.length < 3) {
                    $('.invalid-feedback').show();
                } else {
                    $('.invalid-feedback').hide();
                    ajaxSetup();
                    $.ajax({
                        url: '/BackOffice/public/mstbarang/searchhelp',
                        type: 'post',
                        data:({
                            type:type,
                            search:search
                        }),
                        success: function (result) {
                            console.log(result)

                            $('.row_lov').remove();
                            if (type === 'plu') {
                                for (i = 0; i< result.length; i++){
                                    $('.tbodyTableSearch').append("<tr onclick=show('"+ result[i].prd_prdcd+"') class='row_lov'><td>"+ result[i].prd_deskripsipanjang +"</td><td>"+ result[i].prd_prdcd +"</td> <td>"+ result[i].prd_plusupplier +"</td> <td>"+ result[i].prd_deskripsipendek +"</td></tr>")
                                }
                            } else if (type === 'idm'){
                                for(i = 0; i < result.length; i++){
                                    $('.tbodyTableSearch').append("<tr onclick=show('"+ result[i].prd_prdcd+"') class='row_lov'><td>"+ result[i].prd_deskripsipanjang +"</td><td>"+ result[i].prc_pluigr +"</td> " +
                                        "<td>"+ result[i].prc_pluigm +"</td> <td>"+ result[i].prc_kodetag +"</td> <td>"+ result[i].prc_hrgjual+"</td> <td>"+ result[i].prc_satuanrenceng +"</td> <td>" + result[i].prc_minorder + "</td>" +
                                        "<td>"+ result[i].prc_minorderomi +"</td> <td>"+ result[i].prc_maxorderomi +"</td> <td>"+ result[i].prc_datek +"</td> <td>"+ result[i].prc_pricek +"</td> </tr>")
                                }
                            } else if (type === 'omi'){
                                for(i = 0; i < result.length; i++){
                                    $('.tbodyTableSearch').append("<tr onclick=show('"+ result[i].prd_prdcd+"') class='row_lov'><td>"+ result[i].prd_deskripsipanjang +"</td><td>"+ result[i].prc_pluigr +"</td> " +
                                        "<td>"+ result[i].prc_pluigm +"</td> <td>"+ result[i].prc_kodetag +"</td> <td>"+ result[i].prc_satuanrenceng +"</td> <td>" + result[i].prc_minorder + "</td>" +
                                        "<td>"+ result[i].prc_minorderomi +"</td> <td>"+ result[i].prc_maxorderomi +"</td> <td>"+ result[i].prc_datek +"</td> <td>"+ result[i].prc_pricek +"</td> </tr>")
                                }
                            }
                        }, error : function (error) {
                            console.log(error)
                            swal("Error",'','error');
                        }
                    })
                }
            }
        });

        $(document).on('keypress', '#b_kodeplu', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                let kodeplu = $('#b_kodeplu').val();
                show(convertPlu(kodeplu));
            }
        });

        $(document).on('click', '.showModal', function (e) {
            let type = this['attributes'][3]['nodeValue']
            let search = ' '
            $('.helpSearch').val('');
            $('.row_lov').remove();

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstbarang/searchhelp',
                type: 'post',
                data:({
                    type:type.substr(7),
                    search:search
                }),
                success: function (result) {
                    if (type.substr(7) === 'plu') {
                        for (i = 0; i< result.length; i++){
                            $('.tbodyTableSearch').append("<tr onclick=show('"+ result[i].prd_prdcd+"') class='row_lov'><td>"+ result[i].prd_deskripsipanjang +"</td><td>"+ result[i].prd_prdcd +"</td> <td>"+ result[i].prd_plusupplier +"</td> <td>"+ result[i].prd_deskripsipendek +"</td></tr>")
                        }
                        $('#modal_plu').modal('show');
                    } else if (type.substr(7) === 'idm'){
                        for(i = 0; i < result.length; i++){
                            $('.tbodyTableSearch').append("<tr onclick=show('"+ result[i].prd_prdcd+"') class='row_lov'><td>"+ result[i].prd_deskripsipanjang +"</td><td>"+ result[i].prc_pluigr +"</td> " +
                                "<td>"+ result[i].prc_pluidm +"</td> <td>"+ result[i].prc_kodetag +"</td> <td>"+ result[i].prc_hrgjual+"</td> <td>"+ result[i].prc_satuanrenceng +"</td> <td>" + result[i].prc_minorder + "</td>" +
                                "<td>"+ result[i].prc_minorderomi +"</td> <td>"+ result[i].prc_maxorderomi +"</td> <td>"+ result[i].prc_datek +"</td> <td>"+ result[i].prc_pricek +"</td> </tr>")
                        }
                        $('#modal_pluIdm').modal('show');
                    } else if (type.substr(7) === 'omi'){
                        for(i = 0; i < result.length; i++){
                            $('.tbodyTableSearch').append("<tr onclick=show('"+ result[i].prd_prdcd+"') class='row_lov'><td>"+ result[i].prd_deskripsipanjang +"</td><td>"+ result[i].prc_pluigr +"</td> " +
                                "<td>"+ result[i].prc_pluomi +"</td> <td>"+ result[i].prc_kodetag +"</td> <td>"+ result[i].prc_satuanrenceng +"</td> <td>" + result[i].prc_minorder + "</td>" +
                                "<td>"+ result[i].prc_minorderomi +"</td> <td>"+ result[i].prc_maxorderomi +"</td> <td>"+ result[i].prc_datek +"</td> <td>"+ result[i].prc_pricek +"</td> </tr>")
                        }
                        $('#modal_pluOmi').modal('show');
                    }
                }, error : function (error) {
                    console.log(error)
                    swal("Error",'','error');
                }
            })
        })

        function show(kodeplu){
            $('#modal_plu').modal('hide');
            $('#modal_pluIdm').modal('hide');
            $('#modal_pluOmi').modal('hide');
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstbarang/showBarang',
                type: 'post',
                data: {kodeplu: kodeplu},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    let data = result.datas[0];
                    console.log(result);

                    $('#b_kodeplu').val(data.prd_prdcd);
                    $('#b_pluho').val(data.prd_plumcg);
                    $('#b_plusupp').val(data.prd_plusupplier);
                    $('#b_nmbrg').val(data.prd_deskripsipendek);
                    $('#b_nmbrg2').val(data.prd_deskripsipanjang);
                    $('#b_tgldaftar').val(formatDate(data.prd_tgldaftar));
                    $('#b_tgldisc').val(formatDate(data.prd_tgldiscontinue));
                    $('#b_barcode').val(result.brc1);
                    $('#b_barcode2').val(result.brc2);
                    $('#b_statbarcode').val(data.prd_flagbarcode1);
                    $('#b_tglaktif').val(formatDate(data.prd_tglaktif));

                    $('#d_divisi').val(data.prd_kodedivisi);
                    $('#d_namadiv').val(data.div_namadivisi);
                    $('#d_departemen').val(data.prd_kodedepartement);
                    $('#d_namadepartemen').val(data.dep_namadepartement);
                    $('#d_kategori').val(data.prd_kodekategoribarang);
                    $('#d_namakategori').val(data.kat_namakategori);
                    $('#d_kategoritoko').val(data.prd_kategoritoko);
                    $('#d_flagcbg').val(data.prd_kodecabang);
                    $('#d_statustag').val(data.prd_kodetag);
                    $('#d_statustag2').val(data.tag_keterangan);
                    $('#d_bkp').val(data.prd_flagbkp1);
                    // $('#d_bkp2').val(data.prd_flagbkp2);
                    $('#d_kodedivpo').val(data.prd_kodedivisipo);
                    $('#d_kelipatan').val(data.prd_flagkelipatanorder);
                    $('#d_satju').val(data.prd_unit);
                    $('#d_satju2').val(data.prd_frac);
                    $('#d_satbe').val(data.prd_satuanbeli);
                    $('#d_satbe2').val(data.prd_isibeli);
                    $('#d_satstok').val(data.prd_frackonversi);
                    $('#d_satstok2').val(data.prd_satuankonversi);
                    $('#d_qtymin').val(data.prd_minorder);
                    $('#d_kondisi').val(data.prd_perlakuanbarang);
                    $('#d_flaggdg').val(data.prd_flaggudang);
                    $('#d_grupbrg').val(data.prd_grouppb);
                    $('#d_grupjual').val(data.prd_group);
                    $('#d_minor').val(data.prd_minory);
                    $('#d_hargabdr').val(convertBlanktoN(data.prd_flagbandrol));
                    $('#d_labelhrg').val(convertBlanktoN(data.prd_flagcetaklabelharga));
                    $('#d_ordertoko').val(convertBlanktoN(data.prd_flagbarangordertoko));
                    $('#d_tdkdiskon').val(convertBlanktoN(data.prd_brgnondisc));
                    $('#d_openprice').val(convertBlanktoN(data.prd_openprice));
                    $('#d_minimjual').val(data.prd_minjual);

                    $('#h_hppterakhir').val(convertToRupiah(data.prd_lastcost));
                    $('#h_hpprata').val(convertToRupiah(data.prd_avgcost));
                    $('#h_stdmrg').val(convertToRupiah(data.prd_markupstandard));
                    $('#h_hrgjual').val(convertToRupiah(data.prd_hrgjual));
                    $('#h_marginaktual').val(convertToRupiah(result.margin_n));
                    $('#h_tglaktif').val(formatDate(data.prd_tglhrgjual));
                    $('#h_hrgjualbaru').val(convertToRupiah(data.prd_hrgjual3));
                    $('#h_marginaktual2').val(convertToRupiah(result.margin_a));
                    $('#h_tglberlaku').val(formatDate(data.prd_tglhrgjual3));
                    $('#h_flagnondistfee').val(convertBlanktoN(data.prd_flagnondistfee));

                    $('#di_lebarprod').val(data.prd_dimensilebar);
                    $('#di_panjangprod').val(data.prd_dimensipanjang);
                    $('#di_tinggiprod').val(data.prd_dimensitinggi);
                    $('#di_flagexpr').val(data.prd_flagexport);
                    $('#di_lebarkemasan').val(data.prd_lebar_ex);
                    $('#di_panjangkemasan').val(data.prd_panjang_ex);
                    $('#di_tinggikemasan').val(data.prd_tinggi_ex);
                    $('#di_beratpcs').val(data.prd_berat_pcs);
                    $('#di_beratctn').val(data.prd_berat_ctn);
                    $('#di_beratbox').val(data.prd_berat_box);

                    $('#b_updateakhir').val(formatDate(result.tglupd) + ' ' + (result.tglupd).substr(11));
                    $('#b_updateakhir2').val(result.userupd);
                    $('#b_tglpromo').val(result.tglpromo);
                    $('#b_jampromo').val(result.jampromo);
                    $('#b_hrgpromo').val(convertToRupiah(result.hrgpromo));

                }, error: function(err){
                    $('#modal-loader').modal('hide');
                    swal("Error",'', "error");

                    console.log(err);
                }
            })
        }

        function convertBlanktoN(val) {
            if(val != 'Y'){
                return 'N'
            } else {
                return val
            }
        }
    </script>

@endsection
