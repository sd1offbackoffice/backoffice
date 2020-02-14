@extends('navbar')
@section('content')
    <head>
        <script src="{{asset('/js/bootstrap-select.min.js')}}"></script>
    </head>


    <div class="container-fluid mt-3 pr-5 pl-5">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Harga Beli</legend>
                    <div class="card-body shadow-lg cardForm pt-0">
                        <form>
                            <div class="row text-right">
                                <div class="col-sm-12">
                                    <fieldset class="card border-secondary col-sm-8">
                                        <legend  class="w-auto ml-5 text-left"><small>Header Harga Beli</small></legend>
                                        <div class="form-group row mb-0">
                                            <label for="i_plu" class="col-sm-2 col-form-label">PLU</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_plu">
                                            </div>
                                            <button type="button" class="btn p-0" data-toggle="modal" data-target="#m_pluHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                            <div class="col-sm-7 pr-0">
                                                <input type="text" class="form-control" id="i_deskripsipanjang">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_statustag" class="col-sm-2 col-form-label">Status Tag</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_statustag1">
                                            </div>
                                            <div class="col-sm-2 pl-0">
                                                <input type="text" class="form-control" id="i_statustag2">
                                            </div>

                                            <label for="i_satuanbeli" class="col-sm-1 pr-0 pl-0 col-form-label mr-3">Satuan Beli</label>
                                            <div class="col-sm-1 p-0">
                                                <input type="text" class="form-control" id="i_satuanbeli1">
                                            </div>
                                            <div class="col-sm-1 p-0">
                                                <input type="text" class="form-control" id="i_satuanbeli2">
                                            </div>

                                            <label for="i_top" class="col-sm-2 col-form-label ml-3 mr-3">TOP</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_top">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="i_bkp1">
                                            </div>

                                            <label for="i_kondisi" class="col-sm-1 col-form-label mr-3">Kondisi</label>
                                            <div class="col-sm-2 p-0">
                                                <input type="text" class="form-control" id="i_kondisi">
                                            </div>

                                            <label for="i_flagbandrol" class="col-sm-2 col-form-label ml-3 mr-3">Flag Bandrol</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_flagbandrol">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="card border-secondary">
                                        <legend  class="w-auto ml-5 text-left"><small>Detail Harga Beli</small></legend>
                                        <div class="form-group row mb-0">
                                            <label for="i_supplier" class="col-sm-1 col-form-label">Supplier</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_kodesupplier">
                                            </div>
                                            <label for="i_pkp" class="col-sm-1 col-form-label">PKP</label>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_pkp">
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="i_lastsupplier">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_jenisharga" class="col-sm-1 col-form-label">Jenis Harga</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_jenisharga">
                                            </div>
                                            <label for="i_tglupdate" class="col-sm-1 pr-0 pl-0 col-form-label">Tgl. Update</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglupdate">
                                            </div>
                                            <label for="i_tglberlaku" class="col-sm-2 col-form-label">Tgl. Berlaku</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlaku">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_hgbhargabeli" class="col-sm-1 col-form-label">HGB Harga Beli</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_hgbhargabeli">
                                            </div>
                                            <label for="i_ppn" class="col-sm-1 pr-0 pl-0 col-form-label">PPN</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_ppn">
                                            </div>
                                            <label for="i_hargaomi" class="col-sm-2 col-form-label">Harga OMI</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_hargaomi">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_botol" class="col-sm-1 col-form-label">Botol</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_botol">
                                            </div>
                                            <label for="i_ppnbm" class="col-sm-1 pr-0 pl-0 col-form-label">PPN BM</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_ppnbm">
                                            </div>
                                            <label for="i_hargaomibaru" class="col-sm-2 col-form-label">Harga OMI Baru</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_hargaomibaru">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_hgbhargabeli" class="col-sm-1 col-form-label">Hrg. Beli + PPN</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_hgbhargabelippn">
                                            </div>
                                            <label for="i_ppn" class="col-sm-3 pr-0 pl-0 col-form-label text-center">B - K - 0 - 4</label>
                                            <label for="i_tglberlakubaru" class="col-sm-2 col-form-label">Tgl. Berlaku Baru</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakubaru">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_disc1" class="col-sm-1 col-form-label">DISC 1</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_disc1">
                                            </div>
                                            <label for="i_disc1" class="col-form-label text-right">%</label>
                                            <label for="i_disc1rp" class="ml-3 pr-0 col-form-label">Rp.</label>
                                            <div class="col-sm-1 pl-0 pr-0">
                                                <input type="text" class="form-control" id="i_disc1rp">
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_bk1">
                                            </div>
                                            <div class="col-sm-1 pl-0">

                                            </div>
                                            <label for="i_tglberlakudisc1" class="col-sm-1 col-form-label">Tgl. Berlaku</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc1a">
                                            </div>
                                            <div class="mt-1">s/d</div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc1b">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_disc2" class="col-sm-1 col-form-label">DISC 2</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_disc2">
                                            </div>
                                            <label for="i_disc2" class="col-form-label text-right">%</label>
                                            <label for="i_disc2rp" class="ml-3 pr-0 col-form-label">Rp.</label>
                                            <div class="col-sm-1 pl-0 pr-0">
                                                <input type="text" class="form-control" id="i_disc2rp">
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_bk2">
                                            </div>
                                            <div class="col-sm-1 pl-0">
                                                <input type="text" class="form-control" id="i_flagdisc2">
                                            </div>
                                            <label for="i_tglberlakudisc2" class="col-sm-1 col-form-label">Tgl. Berlaku</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc2a">
                                            </div>
                                            <div class="mt-1">s/d</div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc2b">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_disc2A" class="col-sm-1 col-form-label">DISC 2 A</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_disc2A">
                                            </div>
                                            <label for="i_disc2A" class="col-form-label text-right">%</label>
                                            <label for="i_disc2Arp" class="ml-3 pr-0 col-form-label">Rp.</label>
                                            <div class="col-sm-1 pl-0 pr-0">
                                                <input type="text" class="form-control" id="i_disc2Arp">
                                            </div>
                                            <div class="col-sm-1">

                                            </div>
                                            <div class="col-sm-1 pl-0">
                                                <input type="text" class="form-control" id="i_flagdisc2A">
                                            </div>
                                            <label for="i_tglberlakudisc2A" class="col-sm-1 col-form-label">Tgl. Berlaku</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc2Aa">
                                            </div>
                                            <div class="mt-1">s/d</div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc2Ab">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_disc2B" class="col-sm-1 col-form-label">DISC 2 B</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_disc2B">
                                            </div>
                                            <label for="i_disc2B" class="col-form-label text-right">%</label>
                                            <label for="i_disc2Brp" class="ml-3 pr-0 col-form-label">Rp.</label>
                                            <div class="col-sm-1 pl-0 pr-0">
                                                <input type="text" class="form-control" id="i_disc2Brp">
                                            </div>
                                            <div class="col-sm-1">

                                            </div>
                                            <div class="col-sm-1 pl-0">
                                                <input type="text" class="form-control" id="i_flagdisc2B">
                                            </div>
                                            <label for="i_tglberlakudisc2B" class="col-sm-1 col-form-label">Tgl. Berlaku</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc2Ba">
                                            </div>
                                            <div class="mt-1">s/d</div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc2Bb">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_disc3" class="col-sm-1 col-form-label">DISC 3</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_disc3">
                                            </div>
                                            <label for="i_disc3" class="col-form-label text-right">%</label>
                                            <label for="i_disc3rp" class="ml-3 pr-0 col-form-label">Rp.</label>
                                            <div class="col-sm-1 pl-0 pr-0">
                                                <input type="text" class="form-control" id="i_disc3rp">
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" id="i_bk3">
                                            </div>
                                            <div class="col-sm-1 pl-0">

                                            </div>
                                            <label for="i_tglberlakudisc3" class="col-sm-1 col-form-label">Tgl. Berlaku</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc3a">
                                            </div>
                                            <div class="mt-1">s/d</div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc3b">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_disc4" class="col-sm-1 col-form-label">DISC 4</label>
                                            <label for="i_disc4" class="col-form-label pl-3 text-right">DIST. FEE</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_disc4">
                                            </div>
                                            <label for="i_disc4" class="col-form-label text-right">%</label>
                                            <label for="i_disc4rp" class="ml-3 pr-0 col-form-label">Rp.</label>
                                            <div class="col-sm-1 pl-0 pr-0">
                                                <input type="text" class="form-control" id="i_disc4rp">
                                            </div>
                                            <div class="col-sm-1 pl-0">
                                                <input type="text" class="form-control" id="i_bk4">
                                            </div>
                                            <label for="i_tglberlakudisc4" class="col-sm-1 col-form-label" style="margin-left:66px">Tgl. Berlaku</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc4a">
                                            </div>
                                            <div class="mt-1">s/d</div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc4b">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_disc3" class="col-sm-1 col-form-label"></label>
                                            <label for="i_disc3" class="col-form-label pl-0 text-right">CASH DISC</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_disc5">
                                            </div>
                                            <label for="i_disc5" class="col-form-label text-right">%</label>
                                            <label for="i_disc5rp" class="ml-3 pr-0 col-form-label">Rp.</label>
                                            <div class="col-sm-1 pl-0 pr-0">
                                                <input type="text" class="form-control" id="i_disc5rp">
                                            </div>
                                            <div class="col-sm-1 pl-0">
                                                <input type="text" class="form-control" id="i_bk5">
                                            </div>
                                            <label for="i_tglberlakudisc5" class="col-sm-1 col-form-label" style="margin-left:66px">Tgl. Berlaku</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc5a">
                                            </div>
                                            <div class="mt-1">s/d</div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc5b">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="i_disc3" class="col-sm-1 col-form-label pl-0 pr-0 text-right" style="margin-left: 83px;">NO RETURN</label>
                                            <div class="col-sm-1 pr-0">
                                                <input type="text" class="form-control" id="i_disc6">
                                            </div>
                                            <label for="i_disc6" class="col-form-label text-right">%</label>
                                            <label for="i_disc6rp" class="ml-3 pr-0 col-form-label">Rp.</label>
                                            <div class="col-sm-1 pl-0 pr-0">
                                                <input type="text" class="form-control" id="i_disc6rp">
                                            </div>
                                            <div class="col-sm-1 pl-0">
                                                <input type="text" class="form-control" id="i_bk6">
                                            </div>
                                            <label for="i_tglberlakudisc6" class="col-sm-1 col-form-label" style="margin-left:66px">Tgl. Berlaku</label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc6a">
                                            </div>
                                            <div class="mt-1">s/d</div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="i_tglberlakudisc6b">
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-1 col-form-label pl-0 pr-0 text-right" style="margin-left: 83px;"></label>
                                            <label for="i_totaldiscount" class="col-form-label col-sm-1 ml-3 text-right">Total Discount</label>
                                            <label for="i_totaldiscountrp" class="ml-3 pr-0 col-form-label">Rp.</label>
                                            <div class="col-sm-1 pl-0 pr-0">
                                                <input type="text" class="form-control" id="i_totaldiscount">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4 pr-5 ml-5">
                                                <input type="text" class="form-control" id="i_namasupplier">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="card border-secondary col-sm-11">
                                        <legend  class="w-auto ml-5 text-left"><small>Bonus</small></legend>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-sm-6 border-right">
                                                    <div class="form-group row mb-0">
                                                        <label for="i_bonus1" class="col-sm-1 pr-0 pl-0 col-form-label">Bonus 1</label>
                                                        <label for="i_bonus1" class="col-sm-2 pr-0 pl-0 col-form-label">: Masa Berlaku</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="i_bonus1a">
                                                        </div>
                                                        <div class="mt-1">s/d</div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="i_bonus1b">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label for="i_kel1" class="col-sm-1 pr-0 pl-0 col-form-label mr-2"></label>
                                                        <div class="col-sm-10 pr-0">
                                                            <input type="text" class="form-control" id="i_kel1">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0 text-center">
                                                        <label for="i_flagbonus" class="col-sm-2 pr-0 pl-0 col-form-label">Flag Bonus</label>
                                                        <label for="i_ketentuan" class="col-sm-2 pr-0 pl-0 col-form-label">Ketentuan</label>
                                                        <label for="i_qtypembelian" class="col-sm-3 pr-0 pl-0 col-form-label">Qty Pembelian</label>
                                                        <label for="i_qtybonus" class="col-sm-3 pr-0 pl-0 col-form-label">Qty Bonus</label>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="i_flagbonus1-1">
                                                        </div>
                                                        <label for="i_ketentuan1-1" class="col-sm-2 pr-0 pl-0 col-form-label text-center">Ke - 1</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtypembelian1-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtybonus1-1">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="i_flagbonus1-2">
                                                        </div>
                                                        <label for="i_ketentuan1-2" class="col-sm-2 pr-0 pl-0 col-form-label text-center">Ke - 2</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtypembelian1-2">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtybonus1-2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="i_flagbonus1-3">
                                                        </div>
                                                        <label for="i_ketentuan1-3" class="col-sm-2 pr-0 pl-0 col-form-label text-center">Ke - 3</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtypembelian1-3">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtybonus1-3">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="i_flagbonus1-4">
                                                        </div>
                                                        <label for="i_ketentuan1-4" class="col-sm-2 pr-0 pl-0 col-form-label text-center">Ke - 4</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtypembelian1-4">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtybonus1-4">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="i_flagbonus1-5">
                                                        </div>
                                                        <label for="i_ketentuan1-5" class="col-sm-2 pr-0 pl-0 col-form-label text-center">Ke - 5</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtypembelian1-5">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtybonus1-5">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="i_flagbonus1-6">
                                                        </div>
                                                        <label for="i_ketentuan1-6" class="col-sm-2 pr-0 pl-0 col-form-label text-center">Ke - 6</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtypembelian1-6">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtybonus1-6">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 border-left">
                                                    <div class="form-group row mb-0">
                                                        <label for="i_bonus2" class="col-sm-1 pr-0 pl-0 col-form-label">Bonus 2</label>
                                                        <label for="i_bonus2" class="col-sm-2 pr-0 pl-0 col-form-label">: Masa Berlaku</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="i_bonus2a">
                                                        </div>
                                                        <div class="mt-1">s/d</div>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="i_bonus2b">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label for="i_kel2" class="col-sm-1 pr-0 pl-0 col-form-label mr-2"></label>
                                                        <div class="col-sm-10 pr-0">
                                                            <input type="text" class="form-control" id="i_kel2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0 text-center">
                                                        <label for="i_flagbonus2" class="col-sm-2 pr-0 pl-0 col-form-label">Flag Bonus</label>
                                                        <label for="i_ketentuan2" class="col-sm-2 pr-0 pl-0 col-form-label">Ketentuan</label>
                                                        <label for="i_qtypembelian2" class="col-sm-3 pr-0 pl-0 col-form-label">Qty Pembelian</label>
                                                        <label for="i_qtybonus2" class="col-sm-3 pr-0 pl-0 col-form-label">Qty Bonus</label>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="i_flagbonus2-1">
                                                        </div>
                                                        <label for="i_ketentuan2-1" class="col-sm-2 pr-0 pl-0 col-form-label text-center">Ke - 1</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtypembelian2-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtybonus2-1">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="i_flagbonus2-2">
                                                        </div>
                                                        <label for="i_ketentuan2-2" class="col-sm-2 pr-0 pl-0 col-form-label text-center">Ke - 2</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtypembelian2-2">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtybonus2-2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="i_flagbonus2-3">
                                                        </div>
                                                        <label for="i_ketentuan2-3" class="col-sm-2 pr-0 pl-0 col-form-label text-center">Ke - 3</label>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtypembelian2-3">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <input type="text" class="form-control" id="i_qtybonus2-3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="m_pluHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov" class="form-control search_lov" type="text" placeholder="Inputkan Deskripsi / PLU Produk" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov">
                                    <thead>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>PLU</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($produk as $p)
                                        <tr onclick="lov_select('{{ $p->prd_prdcd }}')" class="row_lov">
                                            <td>{{ $p->prd_deskripsipanjang }}</td>
                                            <td>{{ $p->prd_prdcd }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
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
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }
        label {
            color: #232443;
            font-weight: bold;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: grey;
        }

        .search_lov{
            /*text-transform: uppercase;*/
        }


    </style>

    <script>

        var trlov = $('#table_lov tbody').html();

        $('#select').selectpicker();

        $(':input').prop('readonly',true);
        $('.custom-select').prop('disabled',true);
        $('#i_plu').prop('readonly',false);
        $('#search_lov').prop('readonly',false);

        // lov_select('0060610');

        month = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'];

        $(document).ready(function () {

        })

        $('#i_plu').on('keypress',function (event) {
            if(event.which == 13){
                lov_select(this.value);
            }
        });

        $('#m_pluHelp').on('shown.bs.modal', function () {
            $('#search_lov').focus();
        });

        function lov_select(value){
            $.ajax({
                url: '/BackOffice/public/msthargabeli/lov_select',
                type:'GET',
                data:{"_token":"{{ csrf_token() }}",value: value},
                success: function(response){
                    $(':input').val('');
                    prd = response['produk'];
                    sup = response['supplier'];
                    tag = response['tag'];
                    hgb = response['hargabeli'];
                    hgn = response['hargabelibaru'];


                    $('#i_plu').val(prd.prd_prdcd);
                    $('#i_deskripsipanjang').val(prd.prd_deskripsipanjang);
                    if(tag != null){
                        $('#i_statustag1').val(tag.tag_kodetag);
                        $('#i_statustag2').val(tag.tag_keterangan);
                    }

                    $('#i_satuanbeli1').val(prd.prd_satuanbeli);
                    $('#i_satuanbeli2').val(prd.prd_isibeli);
                    $('#i_top').val(hgb.hgb_top)
                    $('#i_flagbandrol').val(prd.prd_flagbandrol);
                    $('#i_kondisi').val(prd.prd_perlakuanbarang);
                    if(prd.prd_flagbkp1 == 'Y')
                        $('#i_bkp1').val('Kena Pajak');
                    else $('#i_bkp1').val('Tidak Kena Pajak');

                    if(sup != null) {
                        $('#i_kodesupplier').val(sup.sup_kodesupplier);
                        $('#i_pkp').val(sup.sup_pkp);
                        if(hgb.hgb_tipe == '2')
                            $('#i_lastsupplier').val(sup.sup_kodesupplier + ' ADALAH SUPPLIER TERAKHIR')
                        $('#i_namasupplier').val(sup.sup_namasupplier + ' / ' + null_check(sup.sup_singkatansupplier));
                    }

                    if(hgb != null){
                        $('#i_tglberlaku').val(toDate(hgb.hgb_tglberlaku01));
                        $('#i_hargaomi').val(Math.round(hgb.hgb_nilaidpp));
                        $('#i_jenisharga').val(hgb.hgb_jenishrgbeli);
                        $('#i_tglupdate').val(hgb.hgb_modify_dt.substr(0,10));

                        hgbhargabeli = parseFloat(hgb.hgb_hrgbeli * prd.prd_isibeli);
                        $('#i_hgbhargabeli').val(toFixed(hgbhargabeli));
                        ppn = parseFloat(hgb.hgb_ppn * prd.prd_isibeli);
                        $('#i_ppn').val(toFixed(ppn));
                        ppnbotol = parseFloat(hgb.hgb_ppnbotol)
                        $('#i_botol').val(toFixed(ppnbotol));
                        ppnbm = parseFloat(hgb.hgb_ppnbm);
                        $('#i_ppnbm').val(toFixed(ppnbm));
                        $('#i_hgbhargabelippn').val(toFixed(hgbhargabeli + ppn + ppnbm));

                        hargaomi = parseFloat((hgbhargabeli + ppnbm + ppnbotol) / prd.prd_isibeli);
                        $('#i_hargaomi').val(hargaomi);

                        $('#i_totaldiscount').val(parseFloat(hgb.hgb_rphdisc04 + hgb.hgb_rphdisc05 + hgb.hgb_rphdisc06));

                        if(hgb.hgb_tglmulaibonus01 != null){
                            if(hgb.hgb_flagkelipatanbonus01 == 'Y')
                                $('#i_kel1').val('BERLAKU KELIPATAN');
                            else if(hgb.hgb_flagkelipatanbonus01 == 'N')
                                $('#i_kel1').val('TIDAK BERLAKU KELIPATAN');
                        }
                        if(hgb.hgb_tglmulaibonus02 != null){
                            if(hgb.hgb_flagkelipatanbonus02 == 'Y')
                                $('#i_kel1').val('BERLAKU KELIPATAN');
                            else if(hgb.hgb_flagkelipatanbonus02 == 'N')
                                $('#i_kel1').val('TIDAK BERLAKU KELIPATAN');
                        }

                        if(hgb.hgb_persendisc01 != 0 || hgb.hgb_rphdisc01 != 0){
                            $('#i_disc1').val(toFixed(hgb.hgb_persendisc01));
                            $('#i_disc1rp').val(toFixed(hgb.hgb_rphdisc01));
                            $('#i_bk1').val(hgb.hgb_flagdisc01);
                            $('#i_tglberlakudisc1a').val(toDate(hgb.hgb_tglmulaidisc01));
                            $('#i_tglberlakudisc1b').val(toDate(hgb.hgb_tglakhirdisc01));
                        }

                        if(hgb.hgb_persendisc02 != 0 || hgb.hgb_rphdisc02 != 0){
                            $('#i_disc2').val(toFixed(hgb.hgb_persendisc02));
                            $('#i_disc2rp').val(toFixed(hgb.hgb_rphdisc02));
                            $('#i_bk2').val(hgb.hgb_flagdisc02);
                            $('#i_tglberlakudisc2a').val(toDate(hgb.hgb_tglmulaidisc02));
                            $('#i_tglberlakudisc2b').val(toDate(hgb.hgb_tglakhirdisc02));
                        }
                        if(hgb.hgb_persendisc02ii != 0 || hgb.hgb_rphdisc02ii != 0){
                            $('#i_disc2A').val(toFixed(hgb.hgb_rphdisc02));
                            $('#i_disc2Arp').val(toFixed(hgb.hgb_rphdisc02));
                            $('#i_tglberlakudisc2Aa').val(toDate(hgb.hgb_tglmulaidisc02ii));
                            $('#i_tglberlakudisc2Ab').val(toDate(hgb.hgb_tglakhirdisc02ii));
                        }
                        if(hgb.hgb_persendisc02iii != 0 || hgb.hgb_rphdisc02iii != 0){
                            $('#i_disc2B').val(toFixed(hgb.hgb_persendisc02iii));
                            $('#i_disc2Brp').val(toFixed(hgb.hgb_rphdisc02iii));
                            $('#i_tglberlakudisc2Ba').val(toDate(hgb.hgb_tglmulaidisc02iii));
                            $('#i_tglberlakudisc2Bb').val(toDate(hgb.hgb_tglakhirdisc02iii));
                        }
                        if(hgb.hgb_persendisc03 != 0 || hgb.hgb_rphdisc03 != 0){
                            $('#i_disc3').val(hgb.hgb_persendisc03);
                            $('#i_disc3rp').val(hgb.hgb_rphdisc03);
                            $('#i_bk3').val(hgb.hgb_flagdisc03);
                            $('#i_tglberlakudisc3a').val(toDate(hgb.hgb_tglmulaidisc03));
                            $('#i_tglberlakudisc3b').val(toDate(hgb.hgb_tglakhirdisc03));
                        }
                        if(hgb.hgb_persendisc04 != 0 || hgb.hgb_rphdisc04 != 0){
                            $('#i_disc4').val(toFixed(hgb.hgb_persendisc04));
                            $('#i_disc4rp').val(toFixed(hgb.hgb_rphdisc04));
                            $('#i_bk4').val(hgb.hgb_flagdisc04);
                            $('#i_tglberlakudisc4a').val(toDate(hgb.hgb_tglmulaidisc04));
                            $('#i_tglberlakudisc4b').val(toDate(hgb.hgb_tglakhirdisc04));
                        }
                        if(hgb.hgb_persendisc05 != 0 || hgb.hgb_rphdisc05 != 0){
                            $('#i_disc5').val(toFixed(hgb.hgb_persendisc05));
                            $('#i_disc5rp').val(toFixed(hgb.hgb_persendisc05));
                            $('#i_bk5').val(hgb.hgb_flagdisc05);
                            $('#i_tglberlakudisc5a').val(toDate(hgb.hgb_tglmulaidisc05));
                            $('#i_tglberlakudisc5b').val(toDate(hgb.hgb_tglakhirdisc05));
                        }
                        if(hgb.hgb_persendisc06 != 0 || hgb.hgb_rphdisc06 != 0){
                            $('#i_disc6').val(toFixed(hgb.hgb_persendisc06));
                            $('#i_disc6rp').val(toFixed(hgb.hgb_persendisc06));
                            $('#i_bk6').val(hgb.hgb_flagdisc06);
                            $('#i_tglberlakudisc6a').val(toDate(hgb.hgb_tglmulaidisc06));
                            $('#i_tglberlakudisc6b').val(toDate(hgb.hgb_tglakhirdisc06));
                        }

                        if(hgb.hgb_qtymulai1bonus01 != 0 && hgb.hgb_qtymulai1bonus01 != null)
                            $('#i_flagbonus1-1').val(hgb.hgb_jenisbonus);
                        if(hgb.hgb_qtymulai2bonus01 != 0 && hgb.hgb_qtymulai2bonus01 != null)
                            $('#i_flagbonus1-2').val(hgb.hgb_jenisbonus);
                        if(hgb.hgb_qtymulai3bonus01 != 0 && hgb.hgb_qtymulai3bonus01 != null)
                            $('#i_flagbonus1-3').val(hgb.hgb_jenisbonus);
                        if(hgb.hgb_qtymulai4bonus01 != 0 && hgb.hgb_qtymulai4bonus01 != null)
                            $('#i_flagbonus1-4').val(hgb.hgb_jenisbonus);
                        if(hgb.hgb_qtymulai5bonus01 != 0 && hgb.hgb_qtymulai5bonus01 != null)
                            $('#i_flagbonus1-5').val(hgb.hgb_jenisbonus);
                        if(hgb.hgb_qtymulai6bonus01 != 0 && hgb.hgb_qtymulai6bonus01 != null)
                            $('#i_flagbonus1-6').val(hgb.hgb_jenisbonus);
                        if(hgb.hgb_qtymulai1bonus02 != 0 && hgb.hgb_qtymulai1bonus02 != null)
                            $('#i_flagbonus2-1').val(hgb.hgb_jenisbonus);
                        if(hgb.hgb_qtymulai2bonus02 != 0 && hgb.hgb_qtymulai2bonus02 != null)
                            $('#i_flagbonus2-2').val(hgb.hgb_jenisbonus);
                        if(hgb.hgb_qtymulai3bonus02 != 0 && hgb.hgb_qtymulai3bonus02 != null)
                            $('#i_flagbonus2-3').val(hgb.hgb_jenisbonus);

                        now = new Date();

                        if(new Date(hgb.hgb_tglmulaidisc01) <= now && now <= new Date(hgb.hgb_tglakhirdisc01)){
                            if(hgb.hgb_flagdisc01 == 'K')
                                $('#i_hargaomi').val(parseFloat($('#i_hargaomi').val() - hgb.hgb_rphdisc01));
                            else $('#i_hargaomi').val(parseFloat($('#i_hargaomi').val() - (hgb.hgb_rphdisc01 / prd.prd_isibeli)));
                        }
                        if(new Date(hgb.hgb_tglmulaidisc02) <= now && now <= new Date(hgb.hgb_tglakhirdisc02)){
                            if(hgb.hgb_flagdisc01 == 'K')
                                $('#i_hargaomi').val(parseFloat($('#i_hargaomi').val() - hgb.hgb_rphdisc02));
                            else $('#i_hargaomi').val(parseFloat($('#i_hargaomi').val() - (hgb.hgb_rphdisc02 / prd.prd_isibeli)));
                        }
                        if(new Date(hgb.hgb_tglmulaidisc02ii) <= now && now <= new Date(hgb.hgb_tglakhirdisc02ii)){
                            if(hgb.hgb_flagdisc02ii == 'K')
                                $('#i_hargaomi').val(parseFloat($('#i_hargaomi').val() - hgb.hgb_rphdisc02ii));
                            else $('#i_hargaomi').val(parseFloat($('#i_hargaomi').val() - (hgb.hgb_rphdisc02ii / prd.prd_isibeli)));
                        }
                        if(new Date(hgb.hgb_tglmulaidisc02iii) <= now && now <= new Date(hgb.hgb_tglakhirdisc02iii)){
                            if(hgb.hgb_flagdisc02iii == 'K')
                                $('#i_hargaomi').val(parseFloat($('#i_hargaomi').val() - hgb.hgb_rphdisc02iii));
                            else $('#i_hargaomi').val(parseFloat($('#i_hargaomi').val() - (hgb.hgb_rphdisc02iii / prd.prd_isibeli)));
                        }

                        $('#i_hargaomi').val(Math.round($('#i_hargaomi').val()));

                        if(new Date(hgb.hgb_tglmulaibonus01) <= now && now <= hgb.hgb_tglakhirbonus01){
                            if(hgb.hgb_flagdisc01 == 'K'){
                                if(prd.prd_unit == 'KG')
                                    $('#i_hargaomi').val(parseFloat((($('#i_hargaomi').val() * hgb.hgb_qtymulai1bonus01) / (hgb.hgb_qty1bonus01 + hgb.hgb_qtymulai1bonus01)) * 100));
                                else $('#i_hargaomi').val(parseFloat((($('#i_hargaomi').val() * hgb.hgb_qtymulai1bonus01) / (hgb.hgb_qty1bonus01 + hgb.hgb_qtymulai1bonus01)) * 1));
                            }
                            else{
                                if(prd.prd_unit == 'KG')
                                    $('#i_hargaomi').val(parseFloat( (($('#i_hargaomi').val() * (hgb.hgb_qtymulai1bonus01 * prd.prd_isibeli)) / ((hgb.hgb_qty1bonus01 * prd.prd_isibeli) + (hgb.hgb_qtymulai1bonus01 * prd.prd_isibeli)) )  * 1000 ));
                                else $('#i_hargaomi').val(parseFloat( (($('#i_hargaomi').val() * (hgb.hgb_qtymulai1bonus01 * prd.prd_isibeli)) / ((hgb.hgb_qty1bonus01 * prd.prd_isibeli) + (hgb.hgb_qtymulai1bonus01 * prd.prd_isibeli)) )  * 1 ));
                            }
                        }

                        $('#i_hargaomibaru').val(parseFloat( hgbhargabeli + ppnbm + ppnbotol ));

                        if(new Date(hgn.hgn_tglmulaidisc01) <= new Date(hgn.hgn_tglberlaku01) && new Date(hgn.hgn_tglberlaku01) <= hgn.hgn_tglakhirdisc01){
                            if($('#i_flagdisc1').val() == 'K')
                                $('#i_hargaomibaru').val( parseFloat( $('#i_hargaomibaru').val() - $('#i_disc1rp').val() ));
                            else $('#i_hargaomibaru').val( parseFloat( $('#i_hargaomibaru').val() - ( $('#i_disc1rp').val() / prd.prd_isibeli) ));
                        }

                        if(new Date(hgn.hgn_tglmulaidisc02) <= new Date(hgn.hgn_tglberlaku01) && new Date(hgn.hgn_tglberlaku01) <= hgn.hgn_tglakhirdisc02){
                            if($('#i_flagdisc1').val() == 'K')
                                $('#i_hargaomibaru').val( parseFloat( $('#i_hargaomibaru').val() - $('#i_disc2rp').val() ));
                            else $('#i_hargaomibaru').val( parseFloat( $('#i_hargaomibaru').val() - ( $('#i_disc2rp').val() / prd.prd_isibeli) ));
                        }

                        if(new Date(hgn.hgn_tglmulaidisc02ii) <= new Date(hgn.hgn_tglberlaku01) && new Date(hgn.hgn_tglberlaku01) <= hgn.hgn_tglakhirdisc02ii){
                            if($('#i_flagdisc1').val() == 'K')
                                $('#i_hargaomibaru').val( parseFloat( $('#i_hargaomibaru').val() - $('#i_disc2Arp').val() ));
                            else $('#i_hargaomibaru').val( parseFloat( $('#i_hargaomibaru').val() - ( $('#i_disc2Arp').val() / prd.prd_isibeli) ));
                        }

                        if(new Date(hgn.hgn_tglmulaidisc02iii) <= new Date(hgn.hgn_tglberlaku01) && new Date(hgn.hgn_tglberlaku01) <= hgn.hgn_tglakhirdisc02iii){
                            if($('#i_flagdisc1').val() == 'K')
                                $('#i_hargaomibaru').val( parseFloat( $('#i_hargaomibaru').val() - $('#i_disc2Brp').val() ));
                            else $('#i_hargaomibaru').val( parseFloat( $('#i_hargaomibaru').val() - ( $('#i_disc2Brp').val() / prd.prd_isibeli) ));
                        }

                        if(new Date(hgn.hgn_tglmulaibonus01) <= new Date(hgn.hgn_tglberlaku01) && new Date(hgn.hgn_tglberlaku01) <= hgn.tglakhirbonus01 && hgn.hgn_tglakhirbonus01 != null && (hgn.hgn_qty1bonus01 + hgn.hgn_qtymulai1bonus01 ) != 0){
                            if(hgb.hgb_flagdisc01 == 'K'){
                                if(prd.prd_unit == 'KG')
                                    $('#i_hargaomibaru').val( parseFloat( (($('#i_hargaomibaru').val() * hgn.hgn_qtymulai1bonus01) / (hgn.hgn_qty1bonus01 + hgn.hgn_qtymulai1bonus01)) * 1000 ) );
                                else $('#i_hargaomibaru').val( parseFloat( (($('#i_hargaomibaru').val() * hgn.hgn_qtymulai1bonus01) / (hgn.hgn_qty1bonus01 + hgn.hgn_qtymulai1bonus01)) * 1 ) );
                            }
                            else{
                                if(prd.prd_unit == 'KG')
                                    $('#i_hargaomibaru').val( parseFloat( (($('#i_hargaomibaru').val() * (hgn.hgn_qtymulai1bonus01 * prd.prd_isibeli)) / ((hgn.hgn_qty1bonus01 * prd.prd_isibeli) + (hgn.hgn_qtymulai1bonus01 * prd.prd_isibeli))) * 1000 ) );
                                else $('#i_hargaomibaru').val( parseFloat( (($('#i_hargaomibaru').val() * (hgn.hgn_qtymulai1bonus01 * prd.prd_isibeli)) / ((hgn.hgn_qty1bonus01 * prd.prd_isibeli) + (hgn.hgn_qtymulai1bonus01 * prd.prd_isibeli))) * 1 ) );
                            }
                        }

                    }

                    if(hgn != null){
                        $('#i_tglberlakubaru').val(toDate(hgn.hgn_tglberlaku01));
                    }
                },
                complete: function(){
                    if($('#m_pluHelp').is(':visible')){
                        $('.modal').modal('toggle');
                        $('#search_lov').val('');
                        $('#table_lov .row_lov').remove();
                        $('#table_lov').append(trlov);
                    }
                }
            });
        }

        $('#search_lov').keypress(function (e) {
            if (e.which == 13) {
                if(this.value.length == 0) {
                    $('#table_lov .row_lov').remove();
                    $('#table_lov').append(trlov);
                    $('.invalid-feedback').hide();
                }
                else if(this.value.length >= 3) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '/BackOffice/public/msthargabeli/lov_search',
                        type: 'GET',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        success: function (response) {
                            $('#table_lov .row_lov').remove();
                            html = "";
                            console.log(response.length);
                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov" onclick=lov_select("' + response[i].prd_prdcd + '")><td>' + response[i].prd_deskripsipanjang + '</td><td>' + response[i].prd_prdcd + '</td></tr>';
                                $('#table_lov').append(html);
                            }
                        }
                    });
                }
                else{
                    $('.invalid-feedback').show();
                }
            }
        });

        function null_check(value){
            if(value == null)
                return '';
            else return value;
        }

        function toFixed(value){
            return parseFloat(value).toFixed(2);
        }

        function toDate(value) {
            date = new Date(value);

            return date.getDate() + '-' + month[date.getMonth()] + '-' + date.getFullYear();
        }
    </script>

@endsection
