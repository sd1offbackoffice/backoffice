@extends('navbar')
@section('title','HADIAH GABUNGAN')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">HADIAH UNTUK GABUNGAN ITEM</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Kode Gabungan</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="kodeGab">
                                <button id="gab" type="button" class="btn btn-lov p-0" onclick="ToggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Deskripsi Event</label>
                            <div class="col-sm-8">
                                <input class="text-left form-control" type="text" id="deskripsiEvent">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Tanggal</label>
                            <div class="col-sm-4">
                                <input class="text-center form-control" type="text" id="daterangepicker">
                            </div>
                        </div>
                        <br>

                        {{--SYARAT BELANJA & HADIAH--}}
                        <div class="row">
                            {{--SYARAT BELANJA--}}
                            <div class="col-sm-6">
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-12 text-center font-weight-bold">SYARAT BELANJA :</span>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 col-form-label text-right">Minim Struk</label>
                                    <div class="col-sm-4">
                                        <input class="text-right form-control" type="number" id="minStruk" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 col-form-label text-right">Minim Sponsor</label>
                                    <div class="col-sm-4">
                                        <input class="text-right form-control" type="number" id="minSponsor" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 col-form-label text-right">Maxim Sponsor</label>
                                    <div class="col-sm-4">
                                        <input class="text-right form-control" type="number" id="maxSponsor" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                {{--HADIAH--}}
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-4 text-right font-weight-bold">HADIAH :</span>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">PLU Hadiah</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input type="text" class="form-control" id="pluHadiah">
                                        <button id="hadiah" type="button" class="btn btn-lov p-0" onclick="ToggleData(this)">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <input class="col-sm-6 text-left form-control" type="text" id="ketHadiah" disabled>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Jumlah</label>
                                    <div class="col-sm-2">
                                        <input class="text-right form-control" type="number" id="jumlah" min="0" value="1" onkeypress="return isNumberKey(event)">
                                    </div>
                                    <label class="col-sm-1 col-form-label text-left">PCS</label>
                                    <label class="col-sm-2 col-form-label text-right">Kelipatan</label>
                                    <div class="col-sm-2">
                                        <input class="text-center form-control" type="text" id="kelipatan" onkeypress="return isYT(event)" maxlength="1">
                                    </div>
                                    <label class="col-sm-2 col-form-label text-center">[ Y / T ]</label>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Alokasi</label>
                                    <div class="col-sm-2">
                                        <input class="text-right form-control" type="number" id="alokasi" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    </div>
                                    <label class="col-sm-2 col-form-label text-right">Terpakai</label>
                                    <div class="col-sm-2">
                                        <input class="text-right form-control" type="number" id="pakai" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label text-right">Sisa</label>
                                    <div class="col-sm-2">
                                        <input class="text-right form-control" type="number" id="sisa" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        {{--HADIAH PER HARI & JENIS MEMBER--}}
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-12 text-center font-weight-bold">HADIAH PER HARI :</span>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 col-form-label text-right">Qty Max Per Member</label>
                                    <div class="col-sm-4">
                                        <input class="text-right form-control" type="number" id="maxjmlhari" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    </div>
                                    <label class="col-sm-2 col-form-label text-left">PCS</label>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 col-form-label text-right">Qty Max Pengeluaran</label>
                                    <div class="col-sm-4">
                                        <input class="text-right form-control" type="number" id="maxouthari" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    </div>
                                    <label class="col-sm-2 col-form-label text-left">PCS</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-12">JENIS MEMBER :</span>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="RB" class="checktype" onkeydown="check(this)" checked>&nbsp;REGULER BIRU</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="RBP" class="checktype" onkeydown="check(this)" checked>&nbsp;REGULER BIRU PLUS</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="F" class="checktype" onkeydown="check(this)" checked>&nbsp;FREEPASS</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="RM" class="checktype" onkeydown="check(this)" checked>&nbsp;RETAILER MERAH</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="S" class="checktype" onkeydown="check(this)" checked>&nbsp;SILVER</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="P" class="checktype" onkeydown="check(this)" checked>&nbsp;PLATINUM</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="G1" class="checktype" onkeydown="check(this)" checked>&nbsp;GOLD 1</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="G2" class="checktype" onkeydown="check(this)" checked>&nbsp;GOLD 2</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="G3" class="checktype" onkeydown="check(this)" checked>&nbsp;GOLD 3</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <label class="col-sm-4 col-form-label text-right">Max Frek Per Event</label>
                                    <div class="col-sm-3">
                                        <input class="text-right form-control" type="number" id="maxFrekEvent" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    </div>
                                    <label class="col-sm-2 col-form-label text-left">x</label>
                                </div>
                            </div>
                            {{--BUTTONS--}}
                            <div class="col-sm-6 d-flex justify-content-end">
                                <button class="btn btn-primary col-sm-3" type="button" onclick="PromptNew()">NEW</button>&nbsp;
                                <button class="btn btn-primary col-sm-3" type="button" onclick="EditButton()">EDIT</button>&nbsp;
                                <button class="btn btn-primary col-sm-3" type="button" onclick="SaveButton()">SAVE</button>&nbsp;
                            </div>
                        </div>
                        <br>
                    <fieldset class="card border-dark">
                        <legend class="w-auto ml-5 text-left">Item Produk Sponsor</legend>
                        <div class="p-0 tableFixedHeader" style="height: 250px;">
                            <table class="table table-sm table-striped table-bordered"
                                   id="tableProdukSponsor">
                                <thead>
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small"></th>
                                    <th width="27%" class="text-center small">PLU</th>
                                    <th width="70%" class="text-center small">DESKRIPSI</th>
                                </tr>
                                </thead>
                                <tbody id="bodyProdukSponsor" style="height: 250px;">
                                @for($i = 0 ; $i< 10 ; $i++)
                                    <tr class="baris">
                                        <td class="text-center">
                                            <button onclick="deleteRow(this)" class="btn btn-block btn-sm btn-danger btn-delete-row-header" class="icon fas fa-times" onclick="deleteRow(this)">X</button>
                                        </td>
                                        <td class="buttonInside" style="width: 150px;">
                                            <input type="text" class="form-control plu" value="">
                                            <button id="btnPlu" type="button" class="btn btn-lov ml-3 btnPlu" onclick="ToggleData(this)">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </td>
                                        <td>
                                            <input disabled class="form-control deskripsi" value=""
                                                   type="text">
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <input class="col-sm-10 text-center form-control" id="infoall" readonly value="ITEM PRODUK SPONSOR" style="color: red">
                                </div>
                            </div>
                            {{--BUTTONS--}}
                            <div class="col-sm-8 d-flex justify-content-end">
                                <button class="btn btn-primary col-sm-2 add-btn" type="button" onclick="addRow()">ADD ROW</button>&nbsp;
                                <button class="btn btn-primary col-sm-2 add-btn" type="button" id="merk" onclick="ToggleData(this)">ADD BY MERK</button>&nbsp;
                                <button class="btn btn-primary col-sm-2 add-btn" type="button" id="supplier" onclick="ToggleData(this)">ADD BY SUPPLIER</button>&nbsp;
                            </div>
                        </div>

                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!--MODAL GABUNGAN-->
    <div class="modal fade" id="m_gabungan" tabindex="-1" role="dialog" aria-labelledby="m_gabungan" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">History Event Hadiah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableGabungan">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi Event</th>
                                        <th>Kode Promosi</th>
                                        <th>Berlaku</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyGabungan"></tbody>
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
    <!-- END OF MODAL GABUNGAN-->

    <!--MODAL Hadiah-->
    <div class="modal fade" id="m_hadiah" tabindex="-1" role="dialog" aria-labelledby="m_hadiah" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Barang Hadiah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableHadiah">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyHadiah"></tbody>
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
    <!-- END OF MODAL Hadiah-->

    <!--MODAL PLU-->
    <div class="modal fade" id="m_plu" tabindex="-1" role="dialog" aria-labelledby="m_plu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tablePlu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Frac</th>
                                        <th>Harga</th>
                                        <th>Tag</th>
                                        <th>Min Jual</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyPlu"></tbody>
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
    <!-- END OF MODAL PLU-->

    <!--MODAL SUPP-->
    <div class="modal fade" id="m_supp" tabindex="-1" role="dialog" aria-labelledby="m_supp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableSupp">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>Kode Supplier</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodySupp"></tbody>
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
    <!-- END OF MODAL SUPP-->


    <!--MODAL ADD MERK-->
{{--ambil value dari modal plu--}}
    <div class="modal fade" id="m_merk" tabindex="-1" role="dialog" aria-labelledby="m_merk" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Item Produk per MERK</h5>

                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-8 buttonInside">
                        <input type="text" class="form-control" id="merkSearch">
                        <button id="btnMerk" type="button" class="btn btn-lov p-0" onclick="ToggleData(this)">
                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                        </button>
                    </div>
                </div>
                <br>
                <div class="row d-flex justify-content-end">
                    <button class="btn btn-primary col-sm-2 add-btn" type="button" onclick="ViewPlu()">VIEW PLU</button>
                    <button class="btn btn-primary col-sm-2 add-btn" type="button" onclick="SavePlu()">SAVE PLU</button>
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-primary col-sm-2 add-btn" type="button" style="padding-right: 10px" >CANCEL</button>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title">Item Sponsor per MERK</h5>
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableMerk">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyMerk"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <button id="checkMerk" class="btn btn-primary" type="button" onclick="CheckChange(this)">ALL PLU</button>&nbsp;
                </div>
            </div>
        </div>
    </div>
    <!-- END OF MODAL ADD MERK-->

    <!--MODAL ADD SUPPLIER-->
    {{--ambil value dari modal supp--}}
    <div class="modal fade" id="m_supplier" tabindex="-1" role="dialog" aria-labelledby="m_supplier" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Item Produk per Supplier</h5>

                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-3 buttonInside">
                        <input type="text" class="form-control" id="suppSearch">
                        <button id="btnSupplier" type="button" class="btn btn-lov p-0" onclick="ToggleData(this)">
                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                        </button>
                    </div>
                    <input type="text" readonly class="form-control col-sm-6 text-left" id="suppDesk">
                </div>
                <br>
                <div class="row d-flex justify-content-end">
                    <button class="btn btn-primary col-sm-2 add-btn" type="button" onclick="ViewPluSupp()">VIEW PLU</button>
                    <button class="btn btn-primary col-sm-2 add-btn" type="button" onclick="SavePluSupp()">SAVE PLU</button>
                    <button data-dismiss="modal" aria-label="Close" class="btn btn-primary col-sm-2 add-btn" type="button" style="padding-right: 10px" >CANCEL</button>
                    <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title">Item Sponsor per Supplier</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableSupplier">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodySupplier"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                    <button id="checkSupplier" class="btn btn-primary" type="button" onclick="CheckChange(this)">ALL PLU</button>&nbsp;
                </div>
            </div>
        </div>
    </div>
    <!-- END OF MODAL ADD SUPPLIER-->

    <script>
        let tableGabungan;
        let tableHadiah;
        let tablePlu;
        let tableMerk;
        let tableSupp;
        let tableSupplier;
        let cursor;

        let statusForm;

        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $(document).ready(function () {
            GabunganModal();
            HadiahModal();
            PluModal('');
            SuppModal();
            PromptNew();
        });

        $('#kodeGab').on('keydown', function() {
            if(event.key == 'Tab'){
                if(isEmpty($('#kodeGab').val())){
                    swal({
                        title:'Alert',
                        text: 'Kode Barang Tidak Boleh Kosong !!',
                        icon:'warning',
                    }).then(() => {
                        $('#kodeGab').focus();
                    });
                }else{
                    $('#kodeGab').change();
                }
            }
        });
        $('#kodeGab').on('change', function() {
            let crop = $('#kodeGab').val().toUpperCase();
            if(crop == ''){
                return false;
            }else{
                let result = checkKodeGabunganExist(crop);
                if(result){
                    $.ajax({
                        url: '{{ url()->current() }}/get-detail',
                        type: 'GET',
                        data: {
                            kode:crop
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            $('#infoall').val(response.infoall);

                            //header
                            $('#kodeGab').val(response.datas[0].ish_kodepromosi).prop("disabled",true);
                            $('#gab').prop("hidden",true)
                            $('#deskripsiEvent').val(response.datas[0].ish_namapromosi).prop("disabled",true);
                            $('#daterangepicker').data('daterangepicker').setStartDate(response.datas[0].ish_tglawal);
                            $('#daterangepicker').data('daterangepicker').setEndDate(response.datas[0].ish_tglakhir);
                            $('#daterangepicker').prop("disabled",true)

                            $('#minStruk').val(response.datas[0].ish_minstruk).prop("disabled",true);
                            $('#minSponsor').val(response.datas[0].ish_minsponsor).prop("disabled",true);
                            $('#maxSponsor').val(response.datas[0].ish_maxsponsor).prop("disabled",true);

                            $('#pluHadiah').val(response.datas[0].ish_prdcdhadiah).prop("disabled",true);
                            $('#hadiah').prop("hidden",true);
                            let indexHadiah = checkHadiahExist(response.datas[0].ish_prdcdhadiah)-1;
                            $('#ketHadiah').val(tableHadiah.row(indexHadiah).data()['bprp_ketpanjang']).prop("disabled",true);
                            $('#jumlah').val(response.datas[0].ish_jmlhadiah).prop("disabled",true);
                            $('#kelipatan').val(response.datas[0].ish_kelipatanhadiah).prop("disabled",true);
                            $('#alokasi').val(response.datas[0].ish_qtyalokasi).prop("disabled",true);
                            $('#pakai').val(response.datas[0].ish_qtyalokasiout).prop("disabled",true);
                            $('#sisa').val(response.datas[0].ish_qtyalokasi - response.datas[0].ish_qtyalokasiout).prop("disabled",true);
                            $('#maxjmlhari').val(response.datas[0].ish_qtyalokasiout).prop("disabled",true);
                            $('#maxouthari').val(response.datas[0].ish_qtyalokasiout).prop("disabled",true);
                            $('#maxFrekEvent').val(response.datas[0].ish_qtyalokasiout).prop("disabled",true);

                            if(response.datas[0].ish_reguler == '1'){
                                $('#RB').prop("checked",true).prop("disabled",true);
                            }else{
                                $('#RB').prop("checked",false).prop("disabled",true);
                            }
                            if(response.datas[0].ish_regulerbiruplus == '1'){
                                $('#RBP').prop("checked",true).prop("disabled",true);
                            }else{
                                $('#RBP').prop("checked",false).prop("disabled",true);
                            }
                            if(response.datas[0].ish_freepass == '1'){
                                $('#F').prop("checked",true).prop("disabled",true);
                            }else{
                                $('#F').prop("checked",false).prop("disabled",true);
                            }
                            if(response.datas[0].ish_retailer == '1'){
                                $('#RM').prop("checked",true).prop("disabled",true);
                            }else{
                                $('#RM').prop("checked",false).prop("disabled",true);
                            }
                            if(response.datas[0].ish_silver == '1'){
                                $('#S').prop("checked",true).prop("disabled",true);
                            }else{
                                $('#S').prop("checked",false).prop("disabled",true);
                            }
                            if(response.datas[0].ish_platinum == '1'){
                                $('#P').prop("checked",true).prop("disabled",true);
                            }else{
                                $('#P').prop("checked",false).prop("disabled",true);
                            }
                            if(response.datas[0].ish_gold1 == '1'){
                                $('#G1').prop("checked",true).prop("disabled",true);
                            }else{
                                $('#G1').prop("checked",false).prop("disabled",true);
                            }
                            if(response.datas[0].ish_gold2 == '1'){
                                $('#G2').prop("checked",true).prop("disabled",true);
                            }else{
                                $('#G2').prop("checked",false).prop("disabled",true);
                            }
                            if(response.datas[0].ish_gold3 == '1'){
                                $('#G3').prop("checked",true).prop("disabled",true);
                            }else{
                                $('#G3').prop("checked",false).prop("disabled",true);
                            }
                            //header

                            //detail
                            $('.baris').remove();
                            for(i=0;i<response.plu.length;i++){
                                $('#bodyProdukSponsor').append(tempTable());
                                $('.plu')[i].value = (response.plu[i].isd_prdcd);
                                $('.deskripsi')[i].value = (response.plu[i].prd_deskripsipanjang);
                            }
                            $('.plu').prop("disabled",true);
                            $('.btn-delete-row-header').prop("hidden",true);
                            $('.btnPlu').prop("hidden",true);
                            //detail
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                            return false;
                        }
                    });
                }else{
                    swal({
                        title:'Alert',
                        text: 'Data Promosi '+crop+'  Tidak Ada !!',
                        icon:'warning',
                    }).then(() => {
                        $('#kodeGab').val('').focus();
                    });
                }
            }

        });

        $('#pluHadiah').on('keydown', function() {
            if(event.key == 'Tab'){
                if(isEmpty($('#pluHadiah').val())){
                    swal({
                        title:'Alert',
                        text: 'Kode Barang Hadiah Tidak Boleh Kosong !!',
                        icon:'warning',
                    }).then(() => {
                        $('#pluHadiah').focus();
                    });
                }
            }
        });
        $('#pluHadiah').on('change', function() {
            let crop = $('#pluHadiah').val().toUpperCase();
            if(crop != ''){
                if(crop.substr(0,1) == '#'){
                    crop = crop.substr(1,(crop.length)-1);
                }
            }
            if(crop.length < 7){
                crop = crop.padStart(7,'0');
            }
            if(index = checkHadiahExist(crop)){
                index = index-1;
                $('#pluHadiah').val(tableHadiah.row(index).data()['bprp_prdcd']);
                $('#ketHadiah').val(tableHadiah.row(index).data()['bprp_ketpanjang'] + ' - ' + tableHadiah.row(index).data()['satuan']);
            }else{
                swal({
                    title:'Alert',
                    text: 'PLU Hadiah Tidak Terdaftar !!',
                    icon:'warning',
                }).then(() => {
                    $('#pluHadiah').select();
                });
            }
        });

        $('#minStruk').on('change', function() {
            if($('#minStruk').val() == '0' && $('#minSponsor').val() == '0'){
                swal({
                    title:'Alert',
                    text: 'Tidak Ada Batas Minimal Sponsor, Maka Minimal Struk Harus Diisi !!',
                    icon:'warning',
                }).then(() => {
                    $('#minStruk').val('1');
                    $('#infoall').val("ALL ITEM PRODUK SPONSOR");
                    $('.add-btn').prop("disabled",true);
                    $('.plu').prop("disabled",true);
                    $('.btn-delete-row-header').prop("hidden",true);
                    $('.btnPlu').prop("hidden",true);
                });
            }else{
                if($('#minStruk').val() > 0 && $('#minSponsor').val() == '0'){
                    $('#infoall').val("ALL ITEM PRODUK SPONSOR");
                    $('.add-btn').prop("disabled",true);
                    $('.plu').prop("disabled",true);
                    $('.btn-delete-row-header').prop("hidden",true);
                    $('.btnPlu').prop("hidden",true);
                }else{
                    $('#infoall').val("ITEM PRODUK SPONSOR");
                    $('.add-btn').prop("disabled",false);
                    $('.plu').prop("disabled",false);
                    $('.btn-delete-row-header').prop("hidden",false);
                    $('.btnPlu').prop("hidden",false);
                }
            }
        });

        $('#minSponsor').on('change', function() {
            if($('#minStruk').val() == '0' && $('#minSponsor').val() == '0'){
                swal({
                    title:'Alert',
                    text: 'Tidak Ada Batas Minimal Sponsor, Maka Minimal Struk Harus Diisi !!',
                    icon:'warning',
                }).then(() => {
                    $('#minStruk').val('1');
                    $('#infoall').val("ALL ITEM PRODUK SPONSOR");
                    $('.add-btn').prop("disabled",true);
                    $('.plu').prop("disabled",true);
                    $('.btn-delete-row-header').prop("hidden",true);
                    $('.btnPlu').prop("hidden",true);
                });
            }else{
                if($('#minStruk').val() > 0 && $('#minSponsor').val() == '0'){
                    $('#infoall').val("ALL ITEM PRODUK SPONSOR");
                    $('.add-btn').prop("disabled",true);
                    $('.plu').prop("disabled",true);
                    $('.btn-delete-row-header').prop("hidden",true);
                    $('.btnPlu').prop("hidden",true);
                }else{
                    $('#infoall').val("ITEM PRODUK SPONSOR");
                    $('.add-btn').prop("disabled",false);
                    $('.plu').prop("disabled",false);
                    $('.btn-delete-row-header').prop("hidden",false);
                    $('.btnPlu').prop("hidden",false);
                }
            }
        });

        $('#jumlah').on('change', function() {
            if($('#jumlah').val() < 1){
                swal({
                    title:'Alert',
                    text: 'Jml Hadiah Yang Diperoleh Tidak Boleh Dikosongkan !!',
                    icon:'warning',
                }).then(() => {
                    $('#jumlah').val(1).select();
                });
            }
        });
        $('#alokasi').on('change', function() {
            if($('#pakai').val() != ''){
                $('#sisa').val($('#alokasi').val() - $('#pakai').val());
            }else{
                $('#pakai').val('0');
                $('#sisa').val($('#alokasi').val() - $('#pakai').val());
            }
        });

        function PluClick(w){
            cursor = w.parentNode.parentNode.rowIndex-1;
        }

        function PluChange(w){
            let row = w.parentNode.parentNode.rowIndex-1;
            if(row != 0){

                if($('.plu')[row-1].value == ''){
                    swal({
                        title:'Alert',
                        text: 'Row atas belum terisi',
                        icon:'warning',
                    }).then(() => {
                        $('.plu')[cursor].value = '';
                    });
                    return false;
                }
            }
            if($('.plu')[cursor].value == ''){
                deleteRow(w);
                return false;
            }

            let crop = w.value.toUpperCase();
            if(crop != ''){
                if(crop.substr(0,1) == '#'){
                    crop = crop.substr(1,(crop.length)-1);
                }
            }
            if(crop.length < 7){
                crop = crop.padStart(7,'0');
            }
            $.ajax({
                url: '{{ url()->current() }}/check-plu',
                type: 'GET',
                data: {
                    kode:crop
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response.length > 0){
                        $('.plu')[cursor].value = response[0].prd_prdcd;
                        $('.deskripsi')[cursor].value = response[0].deskripsi;
                    }else{
                        swal({
                            title:'Alert',
                            text: 'Kode PLU '+crop+' - '+{{Session::get('kdigr')}} +' Tidak Terdaftar di Master Barang  !!',
                            icon:'warning',
                        }).then(() => {
                            $('.plu')[cursor].value = '';
                        });
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }

        function NewForm(){
            $('#kodeGab').prop("disabled",true);
            $('#gab').prop("hidden",true);
            $('.checktype').prop('checked',false);
            $.ajax({
                url: '{{ url()->current() }}/get-new',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    $('#kodeGab').val(response);
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }



        //Untuk periksa apakah kode gabungan ada
        function checkKodeGabunganExist(val){
            for(i=0;i<tableGabungan.data().length;i++){
                if(tableGabungan.row(i).data()['ish_kodepromosi'] == val){
                    return i+1;
                }
            }
            return false;
        }

        //Untuk periksa apakah plu hadiah ada
        function checkHadiahExist(val){
            for(i=0;i<tableHadiah.data().length;i++){
                if(tableHadiah.row(i).data()['bprp_prdcd'] == val){
                    return i+1;
                }
            }
            return false;
        }


        function ViewPlu(){
            let val = $('#merkSearch').val();//.toUpperCase(); //jangan di uppercasem ada yang huruf kecil contolnya mL plu: 0288320
            if(tableMerk != null){
                tableMerk.destroy();
            }
            //$('#merkSearch').val(val);
            MerkModal(val);
        }
        function ViewPluSupp(){
            let val = $('#suppSearch').val();//.toUpperCase(); //jangan di uppercasem ada yang huruf kecil contolnya mL plu: 0288320
            if(tableSupplier != null){
                tableSupplier.destroy();
            }
            //$('#merkSearch').val(val);
            SupplierModal(val);
        }

        function SavePlu(){
            let limiter = $('.baris').length;
            if(tableMerk != null){
                for(i=0;i<$('.baris').length;i++){
                    if($('.plu')[i].value == ''){
                        limiter = i;
                        break;
                    }
                }
                let slotKosong = $('.baris').length-limiter;
                let needSlot = slotKosong-tableMerk.rows('.selected').data().length;
                if(needSlot<0){
                    for(i=0;i>needSlot;i--){
                        addRow();
                    }
                }
                for(i=0;i<tableMerk.rows('.selected').data().length;i++){
                    $('.plu')[limiter].value = tableMerk.rows('.selected').data()[i].prd_prdcd;
                    $('.deskripsi')[limiter].value = tableMerk.rows('.selected').data()[i].prd_deskripsipanjang;
                    limiter++;

                }
                $('#m_merk').modal('toggle');
            }
        }
        function SavePluSupp(){
            let limiter = $('.baris').length;
            if(tableSupplier != null){
                for(i=0;i<$('.baris').length;i++){
                    if($('.plu')[i].value == ''){
                        limiter = i;
                        break;
                    }
                }
                let slotKosong = $('.baris').length-limiter;
                let needSlot = slotKosong-tableSupplier.rows('.selected').data().length;
                if(needSlot<0){
                    for(i=0;i>needSlot;i--){
                        addRow();
                    }
                }
                for(i=0;i<tableSupplier.rows('.selected').data().length;i++){
                    $('.plu')[limiter].value = tableSupplier.rows('.selected').data()[i].prd_prdcd;
                    $('.deskripsi')[limiter].value = tableSupplier.rows('.selected').data()[i].prd_deskripsipanjang;
                    limiter++;

                }
                $('#m_supplier').modal('toggle');
            }
        }

        function check(val){
            if(event.which == 13){
                if($('#'+val.id).is(":checked")){
                    $('#'+val.id).prop('checked', false);
                }else{
                    $('#'+val.id).prop('checked', true);
                }
            }
        }

        function GabunganModal(){
            tableGabungan =  $('#tableGabungan').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modal-gabungan' }}',
                },
                "columns": [
                    {data: 'ish_namapromosi', name: 'ish_namapromosi'},
                    {data: 'ish_kodepromosi', name: 'ish_kodepromosi'},
                    {data: 'berlaku', name: 'berlaku'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalGabungan');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        function HadiahModal(){
            tableHadiah =  $('#tableHadiah').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modal-hadiah' }}',
                },
                "columns": [
                    {data: 'bprp_ketpanjang', name: 'bprp_ketpanjang'},
                    {data: 'bprp_prdcd', name: 'bprp_prdcd'},
                    {data: 'satuan', name: 'satuan', visible: false},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalHadiah');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        function PluModal(value){
            tablePlu =  $('#tablePlu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modal-plu' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'frac', name: 'frac'},
                    {data: 'hrgjual', name: 'hrgjual'},
                    {data: 'prd_kodetag', name: 'prd_kodetag'},
                    {data: 'jual', name: 'jual'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},

                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalPlu');
                },
                columnDefs : [
                ],
                "order": []
            });

            $('#tablePlu_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tablePlu.destroy();
                    PluModal(val);
                }
            })
        }

        function SuppModal(){
            tablePlu =  $('#tableSupp').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modal-supplier' }}',
                },
                "columns": [
                    {data: 'sup_namasupplier', name: 'sup_namasupplier'},
                    {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},

                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalSupp');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        function MerkModal(value){
            tableMerk =  $('#tableMerk').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/choose-merk' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},

                ],
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalMerk');
                },
                columnDefs : [
                ],
                "order": []
            });

        }

        function SupplierModal(value){
            tableSupplier =  $('#tableSupplier').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/choose-supplier' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},

                ],
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalSupplier');
                },
                columnDefs : [
                ],
                "order": []
            });

        }
        //    Function untuk onclick pada data modal merk
        $(document).on('click', '.modalMerk', function () {
            $(this).toggleClass('selected');
        });
        //    Function untuk onclick pada data modal supplier
        $(document).on('click', '.modalSupplier', function () {
            $(this).toggleClass('selected');
        });

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalGabungan', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().next().text();

            $('#kodeGab').val(kode);
            $('#kodeGab').change();

            $('#m_gabungan').modal('toggle');
        });

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalHadiah', function () {
            let currentButton = $(this);
            let nama = currentButton.children().first().text();
            let kode = currentButton.children().first().next().text();

            $('#pluHadiah').val(kode);
            $('#ketHadiah').val(nama);
            $('#pluHadiah').change();

            $('#m_hadiah').modal('toggle');
        });

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalPlu', function () {
            let currentButton = $(this);
            let deskripsi = currentButton.children().first().text();
            let frac = currentButton.children().first().next().text();
            let kode = currentButton.children().first().next().next().next().next().next().text();

            if(cursor == "merk"){
                $('#merkSearch').val(deskripsi);
                $('#m_merk').modal('toggle');
            }else{
                $('.plu')[cursor].value = (kode);
                $('.deskripsi')[cursor].value = deskripsi+' - '+frac;
                if(cursor!=0){
                    if($('.plu')[cursor-1].value == ''){
                        swal({
                            title:'Alert',
                            text: 'Row atas belum terisi',
                            icon:'warning',
                        }).then(() => {
                            $('.plu')[cursor].value = '';
                            $('.deskripsi')[cursor].value = '';
                        });
                    }
                }
            }

            $('#m_plu').modal('toggle');
        });

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalSupp', function () {
            let currentButton = $(this);
            let deskripsi = currentButton.children().first().text();
            let kode = currentButton.children().first().next().text();

            $('#suppSearch').val(kode);
            $('#suppDesk').val(deskripsi);
            $('#m_supplier').modal('toggle');

            $('#m_supp').modal('toggle');
        });

        function PromptNew(){
            swal({
                title: 'Input Promosi Untuk Data',
                icon: 'warning',
                buttons: {
                    baru: {
                        text: 'Promosi Baru',
                        value: 'B'
                    },
                    lama: {
                        text: 'View / Edit Data Promosi',
                        value: 'L'
                    }
                },
                dangerMode: true
            }).then(function(input){
                ClearForm();
                if(input == 'B'){
                    statusForm = "new";
                    NewForm();
                }else if(input == 'L'){
                    statusForm = "old";
                    $('#kodeGab').focus();
                }else{
                    location.replace('{{ url('/') }}');
                }
            });
        }

        function ToggleData(val){
            if(val.id == 'gab'){
                $('#m_gabungan').modal('toggle');
            }else if(val.id == 'hadiah'){
                $('#m_hadiah').modal('toggle');
            }else if(val.id == 'btnPlu'){
                $('#m_plu').modal('toggle');
                cursor = val.parentNode.parentNode.rowIndex-1;
            }else if(val.id == 'merk'){
                if(tableMerk != null){
                    tableMerk.destroy();
                    $('.modalMerk').remove();
                    $('#merkSearch').val('');
                    tableMerk = null;
                }
                $('#m_merk').modal('toggle');
            }else if(val.id == 'btnMerk'){
                $('#m_merk').modal('toggle');
                cursor = "merk";
                $('#m_plu').modal('toggle');
            }else if(val.id == 'supplier'){
                if(tableSupplier != null){
                    tableSupplier.destroy();
                    $('.modalSupplier').remove();
                    $('#suppSearch').val('');
                    $('#suppDesk').val('');
                    tableSupplier = null;
                }
                $('#m_supplier').modal('toggle');
            }else if(val.id == 'btnSupplier'){
                $('#m_supplier').modal('toggle');
                // cursor = "supp";
                $('#m_supp').modal('toggle');
            }
        }

        function CheckChange(w){
            if(w.id == "checkMerk"){
                if(tableMerk != null){
                    tableMerk.rows().every(function() {
                        this.nodes().to$().toggleClass('selected')
                    })
                }
            }else if(w.id == "checkSupplier"){
                if(tableSupplier != null){
                    tableSupplier.rows().every(function() {
                        this.nodes().to$().toggleClass('selected')
                    })
                }
            }
        }

        function isYT(evt){ //membatasi input untuk hanya boleh Y dan T, serta mendeteksi bila menekan tombol enter
            $('#kelipatan').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 121) // y kecil
                return 89; // Y besar

            if (charCode == 116) // t kecil
                return 84; //t besar

            if (charCode == 89 || charCode == 84)
                return true

            return false;
        }

        function isNumberKey(evt){
            let charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function isEmpty(input){
            if(input.length == 0){
                return true;
            }
            return false;
        }

        function DisableAll(){
            $(' input').prop('disabled', true);
            $('#gab').prop('hidden',true);
            $('#hadiah').prop('hidden',true);
        }

        function ClearForm(){

            $(' button').prop('disabled', false);
            $(' button').prop('hidden', false)
            $(' input').val('');
            $(' input').prop('disabled', false);



            $('#daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
            $('#minStruk').val('0');
            $('#minSponsor').val('0');
            $('#maxSponsor').val('0');


            $('#ketHadiah').prop('disabled', true);
            $('#jumlah').val('1');
            $('#alokasi').val('0');
            $('#pakai').prop('disabled', true);
            $('#sisa').prop('disabled', true);

            $('#maxjmlhari').val('0');
            $('#maxouthari').val('0');
            $('.checktype').prop('checked',true);

            $('#maxFrekEvent').val('0');

            $('.baris').remove();
            for(i=0;i<10;i++){
                addRow();
            }
            // $('.plu').prop('disabled',false);
            // $('.deskripsi').prop('disabled', true);

            $('#infoall').val("ITEM PRODUK SPONSOR");
        }

        function EditButton(){
            if($('#kodeGab').val() != ''){
                statusForm = 'old';
                $(' input').prop('disabled', false);
                $('#kodeGab').prop('disabled', true);
                $('#ketHadiah').prop('disabled', true);
                $('#hadiah').prop('hidden', false);
                $('#pakai').prop('disabled', true);
                $('#sisa').prop('disabled', true);
                $('#infoall').prop('disabled', true);
                $('.btn-delete-row-header').prop('hidden', false);
                $('.btnPlu').prop('hidden', false);
                $('.deskripsi').prop('disabled', true);
            }

        }

        function addRow() {
            $('#bodyProdukSponsor').append(tempTable());
        }

        function deleteRow(e) {
            $(e).parents("tr").remove();
        }

        function tempTable() {
            var temptbl =  ` <tr class="baris"">
                                                <td class="text-center">
                                                    <button onclick="deleteRow(this)" class="btn btn-block btn-sm btn-danger btn-delete-row-header" class="icon fas fa-times" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 150px;">
                                                    <input onclick="PluClick(this)" onchange="PluChange(this)" type="text" class="form-control plu" value="">
                                                    <button id="btnPlu" type="button" class="btn btn-lov ml-3 btnPlu" onclick="ToggleData(this)">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </td>
                                                <td>
                                                    <input disabled class="form-control deskripsi" value=""
                                                           type="text">
                                                </td>
                                            </tr>`

            return temptbl;
        }

        function SaveButton(){
            if($('#kodeGab').val() == ''){
                swal({
                    title:'Alert',
                    text: 'Kode Gabungan Tidak Boleh Kosong !!',
                    icon:'warning',
                }).then(() => {
                    $('#kodeGab').focus();
                });
                return false;
            }
            if($('#deskripsiEvent').val() == ''){
                swal({
                    title:'Alert',
                    text: 'Deskripsi Event Hadiah Harus Diisi !!',
                    icon:'warning',
                }).then(() => {
                    $('#deskripsiEvent').focus();
                });
                return false;
            }
            if($('#pluHadiah').val() == ''){
                swal({
                    title:'Alert',
                    text: 'Kode Barang Hadiah Tidak Boleh Kosong !!',
                    icon:'warning',
                }).then(() => {
                    $('#pluHadiah').focus();
                });
                return false;
            }else if(!checkHadiahExist($('#pluHadiah').val())){
                swal({
                    title:'Alert',
                    text: 'PLU Hadiah Tidak Terdaftar !!',
                    icon:'warning',
                }).then(() => {
                    $('#pluHadiah').select();
                });
                return false;
            }
            if($('#jumlah').val() == '' || $('#jumlah').val() == '0'){
                swal({
                    title:'Alert',
                    text: 'Jml Hadiah Yang Diperoleh Tidak Boleh Dikosongkan !!',
                    icon:'warning',
                }).then(() => {
                    $('#jumlah').focus();
                });
                return false;
            }
            if($('#kelipatan').val() == '' || ($('#kelipatan').val() != 'Y' && $('#kelipatan').val() != 'T')){
                swal({
                    title:'Alert',
                    text: 'Flag Kelipatan Harus Diisi !!',
                    icon:'warning',
                }).then(() => {
                    $('#kelipatan').focus();
                });
                return false;
            }
            if($(".checktype:checked").length === 0){
                swal({
                    title:'Alert',
                    text: 'Jenis Member Harus Dipilih !!',
                    icon:'warning',
                }).then(() => {
                    $('#RB').select();
                });
                return false;
            }
            if($('#minStruk').val() == ''){
                $('#minStruk').val('0');
            }
            if($('#minSponsor').val() == ''){
                $('#minSponsor').val('0');
            }
            if($('#minStruk').val() == '0' && $('#minSponsor').val() == '0'){
                swal({
                    title:'Alert',
                    text: 'Tidak Ada Batas Minimal Sponsor, Maka Minimal Struk Harus Diisi !!',
                    icon:'warning',
                }).then(() => {
                    $('#RB').select();
                });
                return false;
            }
            //SAVE AFTER ALL VALIDATION
            //Variable to send
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal('Periode tidak boleh kosong','','warning');
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            //checkbox
            let allchecktype = $('.checktype:checkbox');
            let theCheckbox = [];
            for(i=0;i<$('.checktype:checkbox').length;i++){
                if($('#'+allchecktype[i].id).prop('checked')){
                    theCheckbox[allchecktype[i].id] = 1;
                }else{
                    theCheckbox[allchecktype[i].id] = 0;
                }
            }
            let datas   = [];
            for(i = 0; i < $('.plu').length; i++) {
                if ($('.deskripsi')[i].value != '') {
                    datas.push($('.plu')[i].value);
                }
            }

            //Saving
            $.ajax({
                url: '{{ url()->current() }}/save',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    statusform:statusForm,
                    kodegab:$('#kodeGab').val(),
                    deskripsievent:$('#deskripsiEvent').val(),
                    date1:dateA,
                    date2:dateB,
                    minstruk:$('#minStruk').val(),
                    minsponsor:$('#minSponsor').val(),
                    maxsponsor:$('#maxSponsor').val(),
                    hadiah:$('#pluHadiah').val(),
                    jumlahhadiah:$('#jumlah').val(),
                    kelipatan:$('#kelipatan').val(),
                    alokasi:$('#alokasi').val(),
                    maxjmlhari:$('#maxjmlhari').val(),
                    maxouthari:$('#maxouthari').val(),
                    maxfrekevent:$('#maxFrekEvent').val(),
                    reguler:theCheckbox['RB'],
                    freepass:theCheckbox['F'],
                    retailer:theCheckbox['RM'],
                    regulerbiruplus:theCheckbox['RBP'],
                    silver:theCheckbox['S'],
                    gold1:theCheckbox['G1'],
                    gold2:theCheckbox['G2'],
                    gold3:theCheckbox['G3'],
                    platinum:theCheckbox['P'],
                    produksponsor:datas,
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    swal({
                        title: response.title,
                        icon: 'success'
                    }).then(() => {
                        ClearForm();
                        tableGabungan.destroy();
                        GabunganModal();
                        $('#kodeGab').focus();
                    })
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }
    </script>
@endsection
