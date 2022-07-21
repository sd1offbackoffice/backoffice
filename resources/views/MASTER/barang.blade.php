@extends('navbar')
@section('title',(__('MASTER | MASTER BARANG')))
@section('content')

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-11">
                                <div class="form-group row mb-3">
{{--                                    semua button nya ku hide saja ya, mau nya pakai shorcut keyboard saja kan? tenang buttonnya masih kepakai kok--}}
                                    <div class="col-sm-3 text-center offset-sm-2">
                                        <span class="font-weight-bold">@lang('ALT + 1 : HELP MASTER BARANG')</span>
                                        <button hidden id="plunormal" type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_plu">@lang('MASTER BARANG')</button>
                                    </div>
                                    <div class="col-sm-3 text-center">
                                        <span class="font-weight-bold">@lang('ALT + 2 : HELP MASTER BARANG IDM')</span>
                                        <button hidden id="pluidm" type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_idm">@lang('MASTER BARANG IDM')</button>
                                    </div>
                                    <div class="col-sm-3 text-center">
                                        <span class="font-weight-bold">@lang('ALT + 3 : HELP MASTER BARANG OMI')</span>
                                        <button hidden id="pluomi" type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal_omi">@lang('MASTER BARANG OMI')</button>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="b_kodeplu" class="col-sm-2 col-form-label">@lang('PLU')</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_kodeplu">
                                    </div>
                                    <label for="b_tgldaftar" class="col-sm-2 col-form-label">@lang('Tgl Daftar')</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_tgldaftar" disabled>
                                    </div>
                                    <label for="b_barcode" class="col-sm-2 col-form-label">@lang('Barcode (E.A.N.)')</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_barcode" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="b_pluho" class="col-sm-2 col-form-label">@lang('PLU H.O')</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_pluho" disabled>
                                    </div>
                                    <label for="b_tgldisc" class="col-sm-2 col-form-label">@lang('Tgl DISC')</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_tgldisc" disabled>
                                    </div>
                                    <label for="b_barcode2" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="b_barcode2" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="b_plusupp" class="col-sm-2 col-form-label">@lang('PLU Supplier')</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="b_plusupp" disabled>
                                    </div>
                                    <label for="b_statbarcode" class="col-sm-5 col-form-label">@lang('Status Barcode')</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="b_statbarcode" disabled>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-2 col-form-label" style="margin-left: -25px; margin-bottom: -50px">@lang('Nama Barang')</label>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="b_nmbrg" class="col-sm-2 col-form-label">1.</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="b_nmbrg" disabled>
                                    </div>
                                    <label for="b_tglaktif" class="col-sm-3 col-form-label">@lang('Tgl Aktif Kembali')</label>
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
                                <div class="row">
                                    <div class="col-sm-1">
{{--                                        filler saja--}}
                                    </div>
                                    <div class="col-sm-8">
                                        <ul class="nav nav-tabs custom-color mt-3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="btn-b_deskripsi" data-toggle="tab" href="#b_deskripsi">@lang('Deskripsi')</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="btn-b_harga" data-toggle="tab" href="#b_harga">@lang('Harga')</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="btn-b_dimensi" data-toggle="tab" href="#b_dimensi">@lang('Dimensi')</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>


                                    <div class="tab-content overflow-auto" style="border-bottom: 1px solid black; height: 500px;">
                                        <div id="b_deskripsi" class="container tab-pane active pl-0 pr-0">
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="d_divisi" class="col-sm-2 col-form-label">@lang('Divisi')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_divisi"  disabled>
                                                            </div>
                                                            {{--<label for="d_namadiv">-</label>--}}
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="d_namadiv" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_departemen" class="col-sm-2 col-form-label">@lang('Departemen')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_departemen" disabled>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="d_namadepartemen" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_kategori" class="col-sm-2 col-form-label">@lang('Kategori')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kategori" disabled>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="d_namakategori" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_kategoritoko" class="col-sm-2 col-form-label">@lang('Kategori Toko')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kategoritoko" disabled>
                                                            </div>
                                                            <label for="d_flagcbg" class="col-sm-3 col-form-label">@lang('Flag Cabang')</label>
                                                                <div class="col-sm-1">
                                                                    <input type="text" class="form-control" id="d_flagcbg" disabled>
                                                                </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_statustag" class="col-sm-2 col-form-label">@lang('Status Tag')</label>
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
                                                            <label for="d_kelipatan" class="col-sm-3 col-form-label">@lang('Kelipatan Order')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kelipatan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_satju" class="col-sm-2 col-form-label">@lang('Satuan Jual')</label>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" id="d_satju" disabled>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" id="d_satju2" disabled>
                                                        </div>
                                                            <label for="d_satbe" class="col-sm-2 col-form-label">@lang('Satuan Beli')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_satbe" disabled>
                                                            </div>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" id="d_satbe2" disabled>
                                                        </div>
                                                            <label for="d_satstok" class="col-sm-2 col-form-label">@lang('Satuan Stok')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_satstok" disabled>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_satstok2" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_qtymin" class="col-sm-2 col-form-label">@lang('Qty Min Order')</label>
                                                            <div class="col-sm-2" style="margin-left: 15px;margin-right: -16px">
                                                                <div class="row">
                                                                    <input type="text" class="form-control col-sm-7" id="d_qtymin" disabled  style="width: 80px">
                                                                    <label class="col-sm-5 col-form-label">@lang('(PCS)')</label>
                                                                </div>
                                                            </div>

                                                            <label for="d_kondisi" class="col-sm-2 col-form-label">@lang('Kondisi')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kondisi" disabled>
                                                            </div>
                                                            <div class="col-sm-1">
{{--                                                                filler doang--}}
                                                            </div>
                                                            <label for="d_flaggdg" class="col-sm-2 col-form-label">@lang('Flag Gudang Pusat')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_flaggdg" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_grupbrg" class="col-sm-2 col-form-label">@lang('Group Barang')</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="d_grupbrg" disabled>
                                                            </div>
                                                            <label for="d_grupjual" class="col-sm-2 col-form-label">@lang('Group Jual')</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="d_grupjual" disabled>
                                                            </div>
                                                            <label for="d_minor" class="col-sm-2 col-form-label">@lang('MINOR Y')</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="d_minor" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_hargabdr" class="col-sm-2 col-form-label">@lang('Harga Bandrol')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_hargabdr" disabled>
                                                            </div>
                                                            <label for="d_labelhrg" class="col-sm-3 col-form-label" >@lang('Label Harga')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_labelhrg" disabled>
                                                            </div>
                                                            <label for="d_ordertoko" class="col-sm-3 col-form-label">@lang('Order Toko')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_ordertoko" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_tdkdiskon" class="col-sm-2 col-form-label">@lang('Tidak Diskon')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_tdkdiskon" disabled>
                                                            </div>
                                                            <label for="d_openprice" class="col-sm-3 col-form-label">@lang('Open Price')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_openprice" disabled>
                                                            </div>
                                                            <label for="d_minimjual" class="col-sm-3 col-form-label">@lang('Minimum Jual')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_minimjual" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="b_harga" class="container tab-pane fade pl-0 pr-0">
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hppterakhir" class="col-sm-3 col-form-label">@lang('HPP Terakhir')</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="h_hppterakhir" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hpprata" class="col-sm-3 col-form-label">@lang('HPP Rata2')</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="h_hpprata" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="h_stdmrg" class="col-sm-3 col-form-label">@lang('STD Margin')</label>
                                                            <div class="col-sm-2" style="margin-left: 15px;">
                                                                <div class="row">
                                                                    <input type="text" class="col-sm-7 form-control text-right" id="h_stdmrg" disabled>
                                                                    <label class="col-sm-5 col-form-label">(%)</label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hrgjual" class="col-sm-3 col-form-label">@lang('Harga Jual')</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="h_hrgjual" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="h_marginaktual" class="col-sm-3 col-form-label">@lang('Margin Aktual')</label>
                                                            <div class="col-sm-2" style="margin-left: 15px; margin-right: -64px">
                                                                <div class="row">
                                                                    <input type="text" class="col-sm-7 form-control text-right" id="h_marginaktual" disabled>
                                                                    <label class="col-sm-5 col-form-label">(%)</label>
                                                                </div>
                                                            </div>
                                                            <label for="h_tglaktif" class="col-sm-3 col-form-label" style="margin-left: 47px">@lang('Tgl Aktif')</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="h_tglaktif" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hrgjualbaru" class="col-sm-3 col-form-label">@lang('Harga Jual Baru')</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="h_hrgjualbaru" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_marginaktual2" class="col-sm-3 col-form-label">@lang('Margin Aktual')</label>
                                                            <div class="col-sm-2" style="margin-left: 15px;">
                                                                <div class="row">
                                                                    <input type="text" class="col-sm-7 form-control text-right" id="h_marginaktual2" disabled>
                                                                    <label class="col-sm-5 col-form-label">(%)</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_tglberlaku" class="col-sm-3 col-form-label">@lang('Tgl Berlaku')</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="h_tglberlaku" disabled>
                                                            </div>
                                                            <label for="h_flagnondistfee" class="col-sm-2 col-form-label">@lang('Flag Non Dist Fee')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="h_flagnondistfee" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="b_dimensi" class="container tab-pane fade pl-0 pr-0">
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="di_lebarprod" class="col-sm-4 col-form-label">@lang('Dimensi Lebar Produk')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_lebarprod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_panjangprod" class="col-sm-4 col-form-label">@lang('Dimensi Panjang Produk')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_panjangprod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="di_tinggiprod" class="col-sm-4 col-form-label">@lang('Dimensi Tinggi Produk')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_tinggiprod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="di_flagexpr" class="col-sm-4 col-form-label">@lang('Flag Export')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_flagexpr" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_lebarkemasan" class="col-sm-4 col-form-label">@lang('Dimensi Lebar Kemasan Karton')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_lebarkemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_panjangkemasan" class="col-sm-4 col-form-label">@lang('Dimensi Panjang Kemasan Karton')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_panjangkemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="di_tinggikemasan" class="col-sm-4 col-form-label">@lang('Dimensi Tinggi Kemasan Karton')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_tinggikemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_beratpcs" class="col-sm-4 col-form-label">@lang('Berat Kotor PCS')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_beratpcs" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_beratctn" class="col-sm-4 col-form-label">@lang('Berat Kotor CTN')</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_beratctn" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_beratbox" class="col-sm-4 col-form-label">@lang('Berat Kotor BOX')</label>
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
                                                <label for="b_updateakhir" class="col-sm-2 col-form-label">@lang('Update Akhir')</label>
                                                <input type="text" class="form-control col-sm-3 mr-2" id="b_updateakhir" disabled>
                                                <input type="text" class="form-control col-sm-1" id="b_updateakhir2" disabled>
                                                {{--<div class="col-sm-1 ml-0">--}}
                                                    {{--<input type="text" class="form-control" id="b_updateakhir2" disabled="" style="width: 70px">--}}
                                                {{--</div>--}}
                                                <label for="b_tglpromo" class="col-sm-3 col-form-label" style="margin-left: -8px">@lang('Tanggal Promo')</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="b_tglpromo" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label for="b_jampromo" class="col-sm-9 col-form-label">@lang('Jam Promo')</label>
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control" id="b_jampromo" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="b_hrgpromo" class="col-sm-9 col-form-label">@lang('Harga Promo')</label>
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
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="modal_plu" tabindex="-1" role="dialog" aria-labelledby="modal_plu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Master Barang')</h5>
                    <button id="closeNormal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                    <table class="table  table table-striped table-bordered" id="table_master_barang">
                                        <thead class="theadDataTables">
                                        <tr class="font">
                                            <th>@lang('Nama Produk')</th>
                                            <th>@lang('PLU')</th>
                                            <th>@lang('PLU Supplier')</th>
                                            <th>@lang('Singkatan')</th>
                                        </tr>
                                        </thead>
                                        <tbody class="tbodyTableSearch">
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_idm" tabindex="-1" role="dialog" aria-labelledby="modal_pluIdm" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Master Barang IDM')</h5>
                    <button id="closeIdm" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table  table table-striped table-bordered" id="table_master_barang_idm">
                                    <thead class="theadDataTables">
                                    <tr class="font" >
                                        <th>@lang('Deskripsi')</th>
                                        <th>@lang('PLU IGR')</th>
                                        <th>@lang('PLU IDM')</th>
                                        <th>@lang('Tag')</th>
                                        <th>@lang('Harga')</th>
                                        <th>@lang('Renceng')</th>
                                        <th>@lang('Minor')</th>
                                        <th>@lang('Min')</th>
                                        <th>@lang('Max')</th>
                                        <th>@lang('Tgl Promo')</th>
                                        <th>@lang('Hrg Promo')</th>
                                    </tr>
                                    </thead>
                                    <tbody class="tbodyTableSearch">
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

    <div class="modal fade" id="modal_omi" tabindex="-1" role="dialog" aria-labelledby="modal_pluOmi" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Master Barang OMI')</h5>
                    <button id="closeOmi" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="table_master_barang_omi">
                                    <thead class="theadDataTables">
                                    <tr class="font">
                                        <td>@lang('Deskripsi')</td>
                                        <td>@lang('PLU IGR')</td>
                                        <td>@lang('PLU OMI')</td>
                                        <td>@lang('Tag')</th>
                                        <td>@lang('Renceng')</td>
                                        <td>@lang('Minor')</td>
                                        <td>@lang('Min')</td>
                                        <td>@lang('Max')</td>
                                        <td>@lang('Tgl Promo')</td>
                                        <td>@lang('Hrg Promo')</td>
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
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>


    <script>
        let tableModalBarang;
        let startPage = true;

        $(document).ready(function(){
            getDataMasterBarang('');
            getDataMasterBarangIdm('');
            getDataMasterBarangOmi('');
        });

        function getDataMasterBarang(value){
            tableModalBarang = $('#table_master_barang').DataTable({
                "ajax": {
                    'url' : '{{ url('master/barang/getmasterbarang') }}',
                    'async':false, // menambah async false agar bisa sinkron dan menggunakan if untuk menampilkan data row pertama, sebaiknya async, kalau bukan karena untuk nampilin data pertama, hapus aja async nya
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang',  width: "50%" },
                    {data: 'prd_prdcd',  width: "10%" },
                    {data: 'prd_plusupplier',  width: "10%" },
                    {data: 'prd_deskripsipendek',  width: "30%" },
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row_lov');
                },
                "order": [],
            });

            $('#table_master_barang_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalBarang.destroy();
                    getDataMasterBarang(val);
                }
            })

            if(startPage){
                let hold = tableModalBarang.row( 0 ).data()['prd_prdcd'];
                show(hold);
                setTimeout(function() {
                    $('#b_kodeplu').select();
                }, 3000);
                startPage = false;
            }
        }

        function getDataMasterBarangIdm(value){
            let tableModalBarangIdm = $('#table_master_barang_idm').DataTable({
                "ajax": {
                    'url' : '{{ url('master/barang/getmasterbarangidm') }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang'},
                    {data: 'prc_pluigr'},
                    {data: 'prc_pluidm'},
                    {data: 'prc_kodetag'},
                    {data: 'prc_hrgjual'},
                    {data: 'prc_satuanrenceng'},
                    {data: 'prc_minorder'},
                    {data: 'prc_minorderomi'},
                    {data: 'prc_maxorderomi'},
                    {data: 'prc_datek'},
                    {data: 'prc_pricek'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row_lov');
                },
                "order": [],
            });

            $('#table_master_barang_idm_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalBarangIdm.destroy();
                    getDataMasterBarangIdm(val);
                }
            })
        }

        function getDataMasterBarangOmi(value){
            let tableModalBarangOmi =  $('#table_master_barang_omi').DataTable({
                "ajax": {
                    'url' : '{{ url('master/barang/getmasterbarangomi') }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang'},
                    {data: 'prc_pluigr'},
                    {data: 'prc_pluomi'},
                    {data: 'prc_kodetag'},
                    {data: 'prc_satuanrenceng'},
                    {data: 'prc_minorder'},
                    {data: 'prc_minorderomi'},
                    {data: 'prc_maxorderomi'},
                    {data: 'prc_datek'},
                    {data: 'prc_pricek'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row_lov');
                },
                "order": [],
            });

            $('#table_master_barang_omi_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalBarangOmi.destroy();
                    getDataMasterBarangOmi(val);
                }
            })
        }

        $(document).on('click', '.row_lov', function () {
            let plu = $(this).find('td')[1]['innerHTML']
            show(plu)
        } );

        $(document).on('keypress', '#b_kodeplu', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                let kodeplu = $('#b_kodeplu').val();
                show(convertPlu(kodeplu));
            }
        });

        function show(kodeplu){
            $('#modal_plu').modal('hide');
            $('#modal_pluIdm').modal('hide');
            $('#modal_pluOmi').modal('hide');
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/showBarang',
                type: 'post',
                data: {kodeplu: kodeplu},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                    $('#modal_plu').modal('hide');
                    $('#modal_idm').modal('hide');
                    $('#modal_omi').modal('hide');
                    $(':input').val('');

                },
                success: function (result) {

                    $('#modal-loader').modal('hide');
                    let data = result.datas[0];

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
                    console.log(err.responseJSON.message.substr(0,100));
                    swal(err.responseJSON.message,'','error');
                }
            })
        }

        function convertBlanktoN(val) {
            if(val != 'Y'){
                return ''
            } else {
                return val
            }
        }
        //fungsi tombol shorcut alt
        $(window).bind('keydown', function(event) {
            //alert(event.keyCode);//49=tombol 1, 50=tombol 2, 51 = tombol 3
            if(event.altKey || event.metaKey){
                if(event.which === 49){
                    $('#closeIdm').click();
                    $('#closeOmi').click();
                    $('#plunormal').click();
                }else if(event.which === 50){
                    $('#closeNormal').click();
                    $('#closeOmi').click();
                    $('#pluidm').click();
                }else if(event.which === 51){
                    $('#closeNormal').click();
                    $('#closeIdm').click();
                    $('#pluomi').click();
                }
            }
        });
    </script>

@endsection
