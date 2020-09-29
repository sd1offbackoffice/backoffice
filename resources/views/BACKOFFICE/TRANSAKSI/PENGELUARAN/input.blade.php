@extends('navbar')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mb-0 ">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">NOMOR TRN_1</label>
                                        <input type="text" id="txtNoDoc" class="text-center form-control form-control-sm col-sm-2">
                                        <div class="col-sm-3">
                                            <button class="btn float-left pl-0 btn-sm" type="button"
                                                    data-target="#m_noDokReturHelp" data-toggle="modal"
                                                    onclick=""><img
                                                        src="{{asset('image/icon/help.png')}}" height="20px"
                                                        width="20px">
                                            </button>
                                            <button type="button" id="btnHapusDokumen"
                                                    class="btn btn-danger btn-sm float-left ">Hapus Dokumen
                                            </button>
                                        </div>
                                        <input type="text" id="txtModel" class="text-center form-control form-control-sm col-sm-3" disabled>
                                    </div>
                                    <div class="form-group row mb-0 ">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">TANGGAL</label>
                                        <input type="text" id="dtTglDoc" class="text-center form-control form-control-sm col-sm-2">
                                    </div>
                                    <div class="form-group row mb-0 ">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">SUPPLIER</label>
                                        <input type="text" id="txtKdSupplier" class="text-center form-control form-control-sm col-sm-1">
                                        <div class="col-sm-5">
                                            <button class="btn float-left pl-0 btn-sm" type="button"
                                                    data-target="#m_kodeSupplierHelp" data-toggle="modal"
                                                    onclick=""><img
                                                        src="{{asset('image/icon/help.png')}}" height="20px"
                                                        width="20px">
                                            </button>

                                            <div class="row">
                                                <input type="text" id="txtNmSupplier" class="form-control form-control-sm col-sm-8" disabled>
                                                <label class="col-form-label text-sm-right col-sm-2"
                                                       style="font-size: 12px">PKP</label>
                                                <input type="text" id="txtPKP"
                                                       class="form-control form-control-sm text-center col-sm-1" disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-4"></div>
                                        <button type="button" id="btnUsulanRetur"
                                                class="btn btn-info btn-sm float-left ">Usulan Retur
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"> Header </legend>

                    <div class="card-body cardForm">
                        <div class="card-body p-0 tableFixedHeader" style="height: 150px; width: 1200px;" >
                            <table class="table table-striped table-bordered"
                                   id="table-header">
                                <thead class="thead-dark">
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small"></th>
                                    <th width="7%" class="text-left small">PLU</th>
                                    <th width="20%" class="text-left small">DESKRIPSI</th>
                                    <th width="10%" class="text-center small">SATUAN</th>
                                    <th width="5%" class="text-center small">BKP</th>
                                    <th width="5%" class="text-center small">STOCK</th>
                                    <th width="5%" class="text-center small">CTN</th>
                                    <th width="5%" class="text-center small">PCS</th>
                                    <th width="40%" class="text-left small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-detail">
                                </tbody>
                            </table>
                        </div>

                    </div>

                </fieldset>

                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Detail</legend>

                    <div class="card-body cardForm">
                        <div class="card-body p-0 tableFixedHeader" >
                            <table class="table table-striped table-bordered"
                                   id="table-detail">
                                <thead class="thead-dark">
                                <tr class="table-sm text-center">
                                    <th class="text-center small"></th>
                                    <th width="5%" class="text-center small">PLU</th>
                                    <th width="18%" class="text-center small">DESKRIPSI</th>
                                    <th width="5%" class="text-center small">SATUAN</th>
                                    <th width="1%" class="text-center small">BKP</th>
                                    <th width="2%" class="text-center small">STOCK</th>
                                    <th width="5%" class="text-center small">HRG.SATUAN (IN CTN)</th>
                                    <th width="3%" class="text-center small">CTN</th>
                                    <th width="3%" class="text-center small">PCS</th>
                                    <th width="5%" class="text-center small">GROSS</th>
                                    <th width="5%" class="text-center small">DISC %</th>
                                    <th width="5%" class="text-center small">DISC Rp</th>
                                    <th width="5%" class="text-center small">PPN</th>
                                    <th width="5%" class="text-center small">FAKTUR</th>
                                    <th width="5%" class="text-center small">PAJAK No.</th>
                                    <th width="5%" class="text-center small">TGL FP</th>
                                    <th width="5%" class="text-center small">NoReff BTB</th>
                                    <th width="18%" class="text-center small">KETERANGAN</th>

                                </tr>
                                </thead>
                                <tbody id="body-table-detail">
                                </tbody>
                            </table>
                        </div>

                    </div>

                </fieldset>


            </div>
        </div>
    </div>

    {{--MODAL NODOK RETUR--}}
    <div class="modal fade" id="m_noDokReturHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov" class="form-control search_lov" type="text" placeholder="Input No Dokumen Retur"
                               aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>No. Doc</td>
                                        <td>Tgl. Doc</td>
                                        <td>Nota</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($nodoc as $p)
                                        <tr onclick="get_data_retur('{{ $p->trbo_nodoc }}')" class="row_lov">
                                            <td>{{ $p->trbo_nodoc }}</td>
                                            <td>{{ date('d-M-y',strtotime($p->trbo_tgldoc)) }}</td>
                                            <td>{{ $p->nota }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    {{--MODAL KODE SUPPLIER--}}
    <div class="modal fade" id="m_kodeSupplierHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov" class="form-control search_lov" type="text" placeholder="Input Nama Supplier"
                               aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>Supplier</td>
                                        <td>Kode</td>
                                        <td>PKP</td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($kdSup as $p)
                                        <tr onclick="get_data_supp('{{ $p->sup_kodesupplier }}')" class="row_lov">
                                            <td>{{ $p->sup_namasupplier }}</td>
                                            <td>{{ $p->sup_kodesupplier }}</td>
                                            <td>{{ $p->sup_pkp }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .row_lov:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .row_lov_plu:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov-plu {
            position: absolute;
            right: 4px;
            top: 1px;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;

        }
    </style>


    <script>

        $(document).ready(function () {
            $('#dtTglDoc').datepicker({"dateFormat": "dd/mm/yy"});
        });

        rowIterator = -1;
        onrow = 0;
        detail = [];
        $('#txtNoDoc').keypress(function (e) {
            if (e.keyCode == 13) {
                var nodoc = $(this).val();
                get_data_retur(nodoc);
            }
        });

        function clear_field() {
            rowIterator = -1;
            onrow = 0;
            detail = [];

            $('#txtNoDoc').val("");
            $('#txtModel').val("");
            $('#dtTglDoc').val("");
            $('#txtKdSupplier').val("");
            $('#txtNmSupplier').val("");
            $('#txtPKP').val("");
            $('#model').val("");

            $('#btnHapusDokumen').prop("disabled", false);
            $('#btnUsulanRetur').prop("disabled", false);

            // $('.btn-delete').show();
            // $('.btn-lov-plu').prop("disabled", false);
            // $('.input-plu').prop("disabled", false);
            // $('.input-ctn').prop("disabled", false);
            // $('.input-pcs').prop("disabled", false);
            // $('#tgl-pb').prop("disabled", false);
            // $('#flag').prop("disabled", false);
            // $('#flag option[value="0"]').attr('selected', 'selected');
            //
            // $('#keterangan').prop("disabled", false);
            // $("input[name=typePB]").prop("disabled", false);
        }

        function get_data_retur(noDoc) {

            clear_field();
            $('.baris').remove();
            if (noDoc == '') {
                swal({
                    title: "Buat Nomor Pengeluaran Baru?",
                    icon: 'info',
                    buttons: true,
                }).then((createData) => {
                    if (createData) {
                        $.ajax({
                            url: '/BackOffice/public/bo/transaksi/pengeluaran/input/getDataRetur',
                            type: 'POST',
                            data: {"_token": "{{ csrf_token() }}", value: noDoc},
                            beforeSend: function () {
                                $('#m_noDokReturHelp').modal('hide');
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (response) {
                                $('#txtNoDoc').val(response['retur'].nodoc);
                                $('#dtTglDoc').val(formatDate(response['retur'].tgldoc));
                                $('#txtModel').val(response['MODEL']);
                                //tambah_row();
                            },
                            complete: function () {
                                if ($('#m_noDokReturHelp').is(':visible')) {
                                    $('#search_lov').val('');
                                    $('#table_lov .row_lov').remove();
                                    $('#table_lov').append(trlov);
                                }
                                $('#modal-loader').modal('hide');
                                $('#txtKdSupplier').focus();
                            }
                        });
                    }
                });
            }

            else {

                $.ajax({

                    url: '/BackOffice/public/bo/transaksi/pengeluaran/input/getDataRetur',
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}", value: noDoc},
                    beforeSend: function () {
                        $('#m_noDokReturHelp').modal('hide');
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (response) {
                        if (response['status'] != "") {
                            swal({
                                title: response['message'],
                                icon: response['status']
                                }).then((createData) => {
                            });
                        }

                        $('#txtModel').val(response['status']);

                    },
                    complete: function () {
                        if ($('#m_noDokReturHelp').is(':visible')) {
                            $('#search_lov').val('');
                            $('#table_lov .row_lov').remove();
                            $('#table_lov').append(trlov);
                        }
                        $('#modal-loader').modal('hide');
                        $('#dtTglDoc').focus();
                    }

                });

            }

                {{--$.ajax({--}}
                    {{--url: '/BackOffice/public/bo/transaksi/pengeluaran/input/getDataRetur',--}}
                    {{--type: 'POST',--}}
                    {{--data: {"_token": "{{ csrf_token() }}", value: noDoc},--}}
                    {{--beforeSend: function () {--}}
                        {{--$('#m_noDokReturHelp').modal('hide');--}}
                        {{--$('#modal-loader').modal({backdrop: 'static', keyboard: false});--}}
                    {{--},--}}
                    {{--success: function (response) {--}}
                        {{--if (response['status'] != "") {--}}
                            {{--swal({--}}
                                {{--title: response['message'],--}}
                                {{--icon: response['status']--}}
                            {{--}).then((createData) => {--}}
                            {{--});--}}
                        {{--}--}}
                        {{--else {--}}
                            {{--$('#no-pb').val(response['pb'].pbh_nopb);--}}
                            {{--$('#tgl-pb').val(formatDate(response['pb'].pbh_tglpb));--}}
                            {{--$('#model').val(response['MODEL']);--}}
                            {{--$("input[name=typePB][value='" + response['pb'].pbh_tipepb + "']").prop("checked", true);--}}
                            {{--$('#flag option[value=' + nvl(response['pb'].pbh_jenispb, 0) + ']').attr('selected', 'selected');--}}
                            {{--$('#keterangan').val(response['pb'].pbh_keteranganpb);--}}
                            {{--$('#tgltrf').val(response['pb'].pbh_tgltransfer);--}}

                            {{--detail = response['pbd'];--}}
                            {{--for (i = 0; i < response['pbd'].length; i++) {--}}
                                {{--rowIterator++;--}}
                                {{--$('#table-detail').append(--}}
                                    {{--"<tr id='row-" + rowIterator + "' class='baris " + response["pbd"][i].pbd_prdcd + "' onclick='setDataPLU(\"" + rowIterator + "\",\"" + response["pbd"][i].pbd_prdcd + "\",\"" + response["pbd"][i].prd_deskripsipanjang.replace(/\'/g, ' ') + "\",\"" + response["pbd"][i].pbd_kodesupplier + "\",\"" + response["pbd"][i].sup_namasupplier + "\",\"" + response["pbd"][i].prd_hrgjual + "\",\"" + nvl(response["pbd"][i].pbd_pkmt, 0) + "\",\"" + nvl(response["pbd"][i].st_saldoakhir, 0) + "\",\"" + response["pbd"][i].minor + "\")'>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <button class='btn btn-sm btn-danger btn-delete' onclick='hapusBaris(\"" + rowIterator + "\")'>X</button>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--'<div class="inside">' +--}}
                                    {{--'<input type="text" class="form-control form-control-sm text-small input-plu" maxlength="7" value="' + nvl(response["pbd"][i].pbd_prdcd, '') + '" onkeypress="cek_plu(\'' + rowIterator + '\', this.value, event)">' +--}}
                                    {{--'<button type="button" style="display: none" class="btn btn-sm btn-lov-plu p-0" data-toggle="modal" data-target="#m_pluHelp" onclick="pluhelp(\'' + rowIterator + '\')"><img src="{{asset('image/icon/help.png')}}" width="25px"></button>' +--}}
                                    {{--'</div>' +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm input-satuan' value='" + response["pbd"][i].satuan + "' >\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input class='form-control form-control-sm text-right input-ctn' value='" + response["pbd"][i].qtyctn + "' onkeypress='cek_ctn(\"" + rowIterator + "\", this.value, event)'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input class='form-control form-control-sm text-right input-pcs' value='" + response["pbd"][i].qtypcs + "' onkeypress='cek_pcs(\"" + rowIterator + "\", this.value, event)'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm' value='" + response["pbd"][i].f_omi + "'\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm' value='" + response["pbd"][i].f_idm + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm' value='" + nvl(response["pbd"][i].pbd_fdxrev, '') + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right input-harga-satuan'\n" +--}}
                                    {{--"               value='" + convertToRupiah2(response["pbd"][i].pbd_hrgsatuan) + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right' value='" + response["pbd"][i].pbd_rphdisc1 + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right persendisc1' value='" + convertToRupiah(response["pbd"][i].pbd_persendisc1) + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right' value='" + convertToRupiah2(response["pbd"][i].pbd_rphdisc2) + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right persendisc2' value='" + convertToRupiah(response["pbd"][i].pbd_persendisc2) + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right bonus1' value='" + response["pbd"][i].pbd_bonuspo1 + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right bonus2' value='" + nvl(response["pbd"][i].pbd_bonuspo2, '') + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right gross'\n" +--}}
                                    {{--"               value='" + convertToRupiah(response["pbd"][i].pbd_gross) + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right ppn'\n" +--}}
                                    {{--"               value='" + convertToRupiah(response["pbd"][i].pbd_ppn) + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right ppnbm' value='" + convertToRupiah(response["pbd"][i].pbd_ppnbm) + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right ppnbotol' value='" + convertToRupiah(response["pbd"][i].pbd_ppnbotol) + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"    <td class='p-0'>\n" +--}}
                                    {{--"        <input disabled class='form-control form-control-sm text-right total'\n" +--}}
                                    {{--"               value='" + convertToRupiah2(response["pbd"][i].total) + "'>\n" +--}}
                                    {{--"    </td>\n" +--}}
                                    {{--"</tr>"--}}
                                {{--);--}}
                            {{--}--}}

                            {{--if (response['MODEL'] == 'KOREKSI') {--}}
                                {{--swal({--}}
                                    {{--title: "KOREKSI",--}}
                                    {{--icon: 'error'--}}
                                {{--}).then((createData) => {--}}
                                {{--});--}}
                            {{--}--}}
                            {{--else if (response['MODEL'] == 'PB SUDAH DICETAK / TRANSFER') {--}}
                                {{--$('.btn-delete').hide();--}}
                                {{--$('#btn-hapus-dokumen').prop("disabled", "disabled");--}}
                                {{--$('.input-plu').prop("disabled", "disabled");--}}
                                {{--$('.input-ctn').prop("disabled", "disabled");--}}
                                {{--$('.input-pcs').prop("disabled", "disabled");--}}
                                {{--$('.btn-lov-plu').prop("disabled", "disabled");--}}
                            {{--}--}}

                            {{--$('#tgl-pb').prop("disabled", "disabled");--}}
                            {{--$('#flag').prop("disabled", "disabled");--}}
                            {{--$('#keterangan').prop("disabled", "disabled");--}}
                            {{--$("input[name=typePB]").prop("disabled", "disabled");--}}

                            {{--height = $('#table-detail tr:last').innerHeight();--}}
                            {{--$('#table-detail tr:last .input-plu').focus();--}}
                            {{--$('.tableFixedHeader').animate({scrollTop: height * response['pbd'].length}, 100);--}}

                            {{--if (response['MODEL'] != 'PB SUDAH DICETAK / TRANSFER') {--}}
                                {{--tambah_row();--}}
                            {{--}--}}
                        {{--}--}}
                    {{--},--}}
                    {{--complete: function () {--}}
                        {{--if ($('#m_pbHelp').is(':visible')) {--}}
                            {{--$('#search_lov').val('');--}}
                            {{--$('#table_lov .row_lov').remove();--}}
                            {{--$('#table_lov').append(trlov);--}}
                        {{--}--}}
                        {{--$('#modal-loader').modal('hide');--}}
                    {{--}--}}
                {{--});--}}

        }

        function tambah_row() {
            rowIterator++;
            $('#table-header').append(
                '<tr id="row-' + rowIterator + '" class="baris" onclick="setDataPLU(\'' + rowIterator + '\',\'\',\'\',\'\',\'\',\'\',\'\',\'\',\'\')">\n' +
                '    <td class="p-0">\n' +
                '        <button class="btn btn-sm btn-danger btn-delete" onclick="hapusBaris(\'' + rowIterator + '\')">X</button>\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '       <div class="inside">' +
                '           <input type="text" class="form-control form-control-sm text-small input-plu" maxlength="7" onkeypress="cek_plu(\'' + rowIterator + '\', this.value, event)">' +
                '           <button type="button" style="display: none" class="btn btn-sm btn-lov-plu p-0" data-toggle="modal" data-target="#m_pluHelp" onclick="pluhelp(\'' + rowIterator + '\')"><img src="{{asset('image/icon/help.png')}}" width="25px"></button>' +
                '       </div>' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm input-satuan" value="">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input class="form-control form-control-sm text-right input-ctn" value="0" onkeypress="cek_ctn(' + rowIterator + ', this.value, event)">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input class="form-control form-control-sm text-right input-pcs" value="0" onkeypress="cek_pcs(' + rowIterator + ', this.value, event)">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm" value="">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm" value="">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm" value="">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right input-harga-satuan"\n' +
                '               value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right persendisc1" value="0.00">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right persendisc2" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right bonus1" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right bonus2" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right gross" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right ppn"\n' +
                '               value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right ppnbm" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right ppnbotol" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right total"\n' +
                '               value="0">\n' +
                '    </td>\n' +
                '</tr>'
            );
            $('#deskripsi').val("");
            $('#kode-supplier').val("");
            $('#nama-supplier').val("");
            $('#harga-jual').val("");
            $('#pkm').val("");
            $('#stock').val("");
            $('#minor').val("");

            $(".baris").children('td').each(function () {
                $(this).find("input").removeAttr('style');
                $(this).find("select").removeAttr('style');
                $(this).find(".btn-lov-plu").hide();
                $(this).find(".inside").removeClass('buttonInside');
            });
            $("#row-" + rowIterator).children('td').each(function () {
                $(this).find("input").css("background-color", "grey");
                $(this).find("select").css("background-color", "grey");
                $(this).find("input").css("color", "white");
                $(this).find("select").css("color", "white");
                $(this).find(".btn-lov-plu").show();
                $(this).find(".inside").addClass('buttonInside');
                $(this).find('.input-plu').focus();
            });

        }


    </script>


@endsection