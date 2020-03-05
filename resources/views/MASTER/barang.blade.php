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
                                    <button type="button" class="btn p-0" data-toggle="modal" data-target="#modal_supp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                    <label for="b_tgldaftar" class="col-sm-1 col-form-label">Tgl Daftar</label>
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
                                    <label for="b_barcode2" class="col-sm-1 col-form-label"></label>
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
                                    <ul class="nav nav-tabs custom-color" role="tablist">
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

                                    <div class="tab-content">
                                        <div id="b_deskripsi" class="container tab-pane active pl-0 pr-0 fix-height">
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="d_divisi" class="col-sm-2 col-form-label">Divisi</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_divisi" disabled>
                                                            </div>
                                                            <label for="d_namadiv">-</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="d_namadiv" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_departemen" class="col-sm-2 col-form-label">Departemen</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_departemen" disabled>
                                                            </div>
                                                            <label for="d_namadepartemen">-</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="d_namadepartemen" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_kategori" class="col-sm-2 col-form-label">Kategori</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kategori" disabled>
                                                            </div>
                                                            <label for="d_namakategori">-</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="d_namakategori" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_kategoritoko" class="col-sm-2 col-form-label">Kategori Toko</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_kategoritoko" disabled>
                                                            </div>
                                                            <label for="d_flagcbg" class="col-sm-5 col-form-label">Flag Cabang</label>
                                                                <div class="col-sm-1">
                                                                    <input type="text" class="form-control" id="d_flagcbg" disabled>
                                                                </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_statustag" class="col-sm-2 col-form-label">Status Tag</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="d_statustag" disabled>
                                                            </div>
                                                            <label for="d_statustag2">-</label>
                                                            <div class="col-sm-5">
                                                                <input type="text" class="form-control" id="d_statustag2" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_bkp" class="col-sm-2 col-form-label">BKP</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_bkp" disabled>
                                                            </div>
                                                            <label>/</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_bkp2" disabled>
                                                            </div>
                                                            <label for="d_kodedivpo" class="col-sm-2 col-form-label">Kode Divisi PO</label>
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
                                                            <input type="text" class="form-control" id="d_satju2" disabled>
                                                        </div>
                                                            <label for="d_satbe" class="col-sm-2 col-form-label">Satuan Beli</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_satbe" disabled>
                                                            </div>
                                                        <div class="col-sm-1">
                                                            <input type="text" class="form-control" id="d_satbe2" disabled>
                                                        </div>
                                                            <label for="d_satstok" class="col-sm-2 col-form-label">Satuan Stok</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_satstok" disabled>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_satstok2" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_qtymin" class="col-sm-2 col-form-label">Qty Min Order</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_qtymin" disabled>
                                                            </div>
                                                            <label >(PCS)</label>
                                                            <label for="d_kondisi" class="col-sm-3 col-form-label">Kondisi</label>
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
                                                            <label>(Y/ )</label>
                                                            <label for="d_labelhrg" class="col-sm-3 col-form-label">Label Harga</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_labelhrg" disabled>
                                                            </div>
                                                            <label>(Y/ )</label>
                                                            <label for="d_ordertoko" class="col-sm-2 col-form-label">Order Toko</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_ordertoko" disabled>
                                                            </div>
                                                            <label>(Y/ )</label>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="d_tdkdiskon" class="col-sm-2 col-form-label">Tidak Diskon</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_tdkdiskon" disabled>
                                                            </div>
                                                            <label>(Y/ )</label>
                                                            <label for="d_openprice" class="col-sm-3 col-form-label">Open Price</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_openprice" disabled>
                                                            </div>
                                                            <label>(Y/ )</label>
                                                            <label for="d_minimjual" class="col-sm-2 col-form-label">Minimum Jual</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="d_minimjual" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="b_harga" class="container tab-pane fade pl-0 pr-0 fix-height">
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hppterakhir" class="col-sm-3 col-form-label">HPP Terakhir</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="h_hppterakhir" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hpprata" class="col-sm-3 col-form-label">HPP Rata2</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="h_hpprata" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="h_stdmrg" class="col-sm-3 col-form-label">STD Margin</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="h_stdmrg" disabled>
                                                            </div>
                                                            <label>(%)</label>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hrgjual" class="col-sm-3 col-form-label">Harga Jual</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="h_hrgjual" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="h_marginaktual" class="col-sm-3 col-form-label">Margin Aktual</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="h_marginaktual" disabled>
                                                            </div>
                                                            <label>(%)</label>
                                                            <label for="h_tglaktif" class="col-sm-3 col-form-label">Tgl Aktif</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="h_tglaktif" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_hrgjualbaru" class="col-sm-3 col-form-label">Harga Jual Baru</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="h_hrgjualbaru" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_marginaktual2" class="col-sm-3 col-form-label">Margin Aktual</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control" id="h_marginaktual2" disabled>
                                                            </div>
                                                            <label>(%)</label>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="h_tglberlaku" class="col-sm-3 col-form-label">Tgl Berlaku</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="h_tglberlakau" disabled>
                                                            </div>
                                                            <label for="h_flagnondistfee" class="col-sm-3 col-form-label">Flag Non Dist Fee</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="h_flagnondistfee" disabled>
                                                            </div>
                                                            <label>(Y/ )</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="b_dimensi" class="container tab-pane fade pl-0 pr-0 fix-height">
                                            <div class="card-body">
                                                <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <div class="form-group row mb-0">
                                                            <label for="di_lebarprod" class="col-sm-7 col-form-label">Dimensi Lebar Produk</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="di_lebarprod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_panjangprod" class="col-sm-7 col-form-label">Dimensi Panjang Produk</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="di_panjangprod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="di_tinggiprod" class="col-sm-7 col-form-label">Dimensi Tinggi Produk</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="di_tinggiprod" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="di_flagexpr" class="col-sm-7 col-form-label">Flag Export</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="di_flagexpr" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_lebarkemasan" class="col-sm-7 col-form-label">Dimensi Lebar Kemasan Produk</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="di_lebarkemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_panjangkemasan" class="col-sm-7 col-form-label">Dimensi Panjang Kemasan Produk</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="di_panjangkemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-3">
                                                            <label for="di_tinggikemasan" class="col-sm-7 col-form-label">Dimensi Tinggi Kemasan Produk</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="di_tinggikemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_beratpcs" class="col-sm-7 col-form-label">Berat Kotor PCS</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="di_beratpcs" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_beratctn" class="col-sm-7 col-form-label">Berat Kotor CTN</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" id="di_beratctn" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="di_beratbox" class="col-sm-7 col-form-label">Berat Kotor BOX</label>
                                                            <div class="col-sm-4">
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
                                                        <div class="form-group row">
                                                            <label for="b_updateakhir" class="col-sm-2 col-form-label">Update Akhir</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="b_updateakhir" disabled>
                                                            </div>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="b_updateakhir2" disabled="">
                                                            </div>
                                                            <label for="b_tglpromo" class="col-sm-3 col-form-label">Tanggal Promo</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="b_tglpromo" disabled>
                                                            </div>
                                                            {{--<label for="i_harusdiisi" class="col-sm-3 text-right"><span class="wajib">*Harus diisi</span></label>--}}
                                                        </div>
                                                    <div class="form-group row">
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

    <script>

        $(document).on('keypress', '#b_kodeplu', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                let kodeplu = $('#b_kodeplu').val();

                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/mstbarang/barang',
                    type: 'post',
                    data: {kodeplu: kodeplu},
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (result) {
                        $('#modal-loader').modal('hide');

                            $('#b_kodeplu').val(result.data[i].prd_prdcd);
                            $('#b_pluho').val(result.data[i].prd_plumcg);
                            $('#b_plusupp').val(result.data[i].prd_plusupplier);
                            $('#b_nmbrg').val(result.data[i].prd_deskripsipendek);
                            $('#b_nmbrg2').val(result.data[i].prd_deskripsipanjang);
                            $('#b_tgldaftar').val(result.data[i].prd_tgldaftar);
                            $('#b_tgldisc').val(result.data[i].prd_tgldiscontinue);
                            $('#b_barcode').val(result.data[i].prd_barcode1);
                            $('#b_barcode2').val(result.data[i].prd_barcode2);
                            $('#b_statbarcode').val(result.data[i].prd_flagbarcode1);
                            $('#b_tglaktif').val(result.data[i].prd_tglaktif);

                            $('#d_divisi').val(result.data[i].prd_kodedivisi);
                            $('#d_namadivisi').val(result.data[i].prd_namadivisi);
                            $('#d_departemen').val(result.data[i].prd_kodedepartement);
                            $('#d_namadepartemen').val(result.data[i].prd_namadepartement);
                            $('#d_kategori').val(result.data[i].prd_kodekategoribarang);
                            $('#d_namakategori').val(result.data[i].prd_namakat);
                            $('#d_kategoritoko').val(result.data[i].prd_kategoritoko);
                            $('#d_flagcbg').val(result.data[i].prd_kodecabang);
                            $('#d_statustag').val(result.data[i].prd_kodetag);
                            $('#d_statustag2').val(result.data[i].prd_kettag);
                            $('#d_bkp').val(result.data[i].prd_flagbkp1);
                            $('#d_bkp2').val(result.data[i].prd_flagbkp2);
                            $('#d_kodedivpo').val(result.data[i].prd_kodedivisipo);
                            $('#d_kelipatan').val(result.data[i].prd_flagkelipatanorder);
                            $('#d_satju').val(result.data[i].prd_unit);
                            $('#d_satju2').val(result.data[i].prd_frac);
                            $('#d_satbe').val(result.data[i].prd_satuanbeli);
                            $('#d_satbe2').val(result.data[i].prd_isibeli);
                            $('#d_satstok').val(result.data[i].prd_frackonversi);
                            $('#d_satstok2').val(result.data[i].prd_satuankonversi);
                            $('#d_qtymin').val(result.data[i].prd_minimumorder);
                            $('#d_kondisi').val(result.data[i].prd_perlakuanbarang);
                            $('#d_flaggdg').val(result.data[i].prd_flaggudang);
                            $('#d_grupbrg').val(result.data[i].prd_grouppb);
                            $('#d_grupjual').val(result.data[i].prd_group);
                            $('#d_minor').val(result.data[i].prd_minory);
                            $('#d_hargabdr').val(result.data[i].prd_flagbandrol);
                            $('#d_labelhrg').val(result.data[i].prd_flagcetaklabelharga);
                            $('#d_ordertoko').val(result.data[i].prd_flagbarangordertoko);
                            $('#d_tdkdiskon').val(result.data[i].prd_brgnondiscount);
                            $('#d_openprice').val(result.data[i].prd_openprice);
                            $('#d_minimjual').val(result.data[i].prd_minimumjual);

                            $('#h_hppterakhir').val(result.data[i].prd_lastcost);
                            $('#h_hpprata').val(result.data[i].prd_averagecost);
                            $('#h_stdmrg').val(result.data[i].prd_markupstandard);
                            $('#h_hrgjual').val(result.data[i].prd_hrgjual);
                            $('#h_marginaktual').val(result.data[i].prd_margin_n);
                            $('#h_tglaktif').val(result.data[i].prd_tglhrgjual);
                            $('#h_hrgjualbaru').val(result.data[i].prd_hrgjual3);
                            $('#h_marginaktual2').val(result.data[i].prd_margin_a);
                            $('#h_tglberlaku').val(result.data[i].prd_tglhrgjual3);
                            $('#h_flagnondistfee').val(result.data[i].prd_flagnondistfee);

                            $('#di_lebarprod').val(result.data[i].prd_dimensilebar);
                            $('#di_panjangprod').val(result.data[i].prd_dimensipanjang);
                            $('#di_tinggiprod').val(result.data[i].prd_dimensitinggi);
                            $('#di_flagexpr').val(result.data[i].prd_flagexport);
                            $('#di_lebarkemasan').val(result.data[i].prd_lebar_ex);
                            $('#di_panjangkemasan').val(result.data[i].prd_panjang_ex);
                            $('#di_tinggikemasan').val(result.data[i].prd_tinggi_ex);
                            $('#di_beratpcs').val(result.data[i].prd_berat_pcs);
                            $('#di_beratctn').val(result.data[i].prd_berat_ctn);
                            $('#di_beratbox').val(result.data[i].prd_berat_box);

                            $('#b_updateakhir').val(result.data[i].prd_tanggal_upd);
                            $('#b_updateakhir2').val(result.data[i].prd_user_upd);
                            $('#b_tglpromo').val(result.data[i].prd_tgl_promo);
                            $('#b_jampromo').val(result.data[i].prd_jam_promo);
                            $('#b_hrgpromo').val(result.data[i].prd_harga_promo);




                        }
                    }
                })
            }
        })


    </script>

@endsection
