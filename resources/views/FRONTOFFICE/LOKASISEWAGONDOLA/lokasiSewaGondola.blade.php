@extends('navbar')
@section('title','LOKASI SEWA GONDOLA')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <ul class="nav nav-tabs" id="myTabDetailTokoOmi" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="detailOmi-tab" data-toggle="tab" href="#tabnopjsewa"
                               role="tab"
                               aria-controls="detail" aria-selected="false">No. Perjanjian Sewa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="identityOmi-tab" data-toggle="tab" href="#tablokasi" role="tab"
                               aria-controls="identity" aria-selected="true">Lokasi</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContentDetailTokoOmi">
                        <div class="tab-pane fade show active" id="tabnopjsewa" role="tabpanel"
                             aria-labelledby="detailOmi-tab">
                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-md-12 p-0">
                                        <fieldset class="card border-dark cardForm">
                                            <legend class="w-auto ml-5">No. Perjanjian</legend>
                                            <div class="card-body shadow-lg cardForm">
                                                <div class="row justify-content-center form-group">
                                                    <label class="col-sm-3 col-form-label text-sm-right">No. Perjanjian
                                                        Sewa :</label>
                                                    <div class="col-sm-3 buttonInside">
                                                        <input type="text" class="form-control text" autocomplete="off"
                                                               id="nopjsewa">
                                                        <button id="btn-no-doc" type="button" class="btn btn-lov p-0"
                                                                data-toggle="modal" data-target="#m_nopjsewa">
                                                            <img src="{{ (asset('image/icon/help.png')) }}"
                                                                 width="30px">
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <button class="btn btn-primary" onclick="getDataPerjanjian()">
                                                            PILIH
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-primary" onclick="clearPage()">CLEAR
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="offset-9 col-sm-3">
                                                        <input type="text" class="form-control text" id="model"
                                                               readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid mt-2  p-0">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <fieldset class="card border-dark cardForm">
                                            <legend class="w-auto ml-5">Detail</legend>
                                            <div class="card-body shadow-lg cardForm">
                                                <div class="row float-right">
                                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                        <button class="btn btn-danger" id="btnRemoveRow" disabled>-
                                                        </button>
                                                        <button class="btn btn-success" id="btnAddRow" disabled>+
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <div class="tableFixedHeader col-md-11" style="height: 250px;">
                                                        <table class="table table-sm table-striped table-bordered">
                                                            <thead>
                                                            <tr class="table-sm text-center">
                                                                <th class="text-center small"
                                                                    style="text-align: center; vertical-align: middle">
                                                                    PLU
                                                                </th>
                                                                <th class="text-center small"
                                                                    style="text-align: center; vertical-align: middle">
                                                                    Kode Display
                                                                </th>
                                                                <th class="text-center small"
                                                                    style="text-align: center; vertical-align: middle">
                                                                    Qty
                                                                </th>
                                                                <th class="text-center small"
                                                                    style="text-align: center; vertical-align: middle">
                                                                    Kode Principal
                                                                </th>
                                                                <th class="text-center small"
                                                                    style="text-align: center; vertical-align: middle">
                                                                    Tgl
                                                                    Awal
                                                                </th>
                                                                <th class="text-center small"
                                                                    style="text-align: center; vertical-align: middle">
                                                                    Tgl
                                                                    Akhir
                                                                </th>
                                                                <th class="text-center small"
                                                                    style="text-align: center; vertical-align: middle">
                                                                    Lokasi
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="body-table-detail">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-sm-1" style="height: 125px;margin-top: 50px">
                                                        <button class="btn btn-primary"
                                                                onclick="simpanPerjanjianSewa()">
                                                            S<br>i<br>m<br>p<br>a<br>n
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid mt-2 p-0">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <fieldset class="card border-dark cardForm">
                                            <legend class="w-auto ml-5">Lokasi</legend>
                                            <div class="card-body shadow-lg cardForm">
                                                <div class="p-0 tableFixedHeader col-md-12" style="height: 250px;">
                                                    <table class="table table-sm table-striped table-bordered"
                                                           id="table-header">
                                                        <thead>
                                                        <tr class="table-sm text-center">
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">
                                                                Rak
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">Sub
                                                                Rak
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">
                                                                Tipe Rak
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">
                                                                Shelv
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">No.
                                                                Urut
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">
                                                                Qty
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">Max
                                                                Plano
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="body-table-lokasi">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div> {{--Close for class "tab-detailomi"--}}

                        <div class="tab-pane fade" id="tablokasi" role="tabpanel" aria-labelledby="identityOmi-tab">

                            <div class="container-fluid">
                                <div class="row justify-content-center">
                                    <div class="col-md-12 p-0">
                                        <fieldset class="card border-dark cardForm">
                                            <div class="card-body shadow-lg cardForm">
                                                <div class="row form-group">
                                                    <label for="lks_koderak" class="col-sm-2 col-form-label text-right">KODE
                                                        RAK :</label>
                                                    <div class="col-sm-2 buttonInside">
                                                        <input maxlength="10" type="text" class="form-control"
                                                               id="koderak">
                                                        <button id="btn-lov" type="button"
                                                                class="btn btn-lov btn-primary p-0" data-toggle="modal"
                                                                data-target="#m_koderak">
                                                            <i class="fas fa-question"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-primary" onclick="getDataLokasi()">
                                                            PILIH
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <button class="btn btn-primary" onclick="clear()">CLEAR</button>
                                                    </div>
                                                </div>
                                                <div class="row form-group">
                                                    <label for="lks_kodesubrak"
                                                           class="col-sm-2 col-form-label text-right">SUB
                                                        RAK :</label>
                                                    <div class="col-sm-2 buttonInside">
                                                        <input maxlength="10" type="text" class="form-control"
                                                               id="subrak">
                                                        <button id="btn-lov" type="button"
                                                                class="btn btn-lov btn-primary p-0" data-toggle="modal"
                                                                data-target="#m_koderak">
                                                            <i class="fas fa-question"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <label for="lks_tiperak" class="col-sm-2 col-form-label text-right">TIPE
                                                        RAK :</label>
                                                    <div class="col-sm-2 buttonInside">
                                                        <input maxlength="10" type="text" class="form-control"
                                                               id="tiperak">
                                                        <button id="btn-lov" type="button"
                                                                class="btn btn-lov btn-primary p-0" data-toggle="modal"
                                                                data-target="#m_koderak">
                                                            <i class="fas fa-question"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid mt-2 p-0">
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <fieldset class="card border-dark cardForm">
                                            <legend class="w-auto ml-5">Detail</legend>
                                            <div class="card-body shadow-lg cardForm">
                                                <div class="p-0 tableFixedHeader col-md-12" style="height: 250px;">
                                                    <table class="table table-sm table-striped table-bordered"
                                                           id="table-header">
                                                        <thead>
                                                        <tr class="table-sm text-center">
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">
                                                                Shelv
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">No.
                                                                Urut
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">
                                                                PLU
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">
                                                                No. Perjanjian Sewa
                                                            </th>
                                                            <th class="text-center small"
                                                                style="text-align: center; vertical-align: middle">
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="body-table-lokasi2" style="">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                        </div> {{--Close for class "tab-detailomi"--}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_nopjsewa" tabindex="-1" role="dialog" aria-labelledby="m_data_nopjsewa"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV No. Perjanjian Sewa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalnopjsewa">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No. Perjanjian</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <div class="modal fade" id="m_koderak" tabindex="-1" role="dialog" aria-labelledby="m_data_dep" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Kode Rak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalKodeRak">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Rak</th>
                                        <th>Sub Rak</th>
                                        <th>Tipe Rak</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <div class="modal fade" id="m_lokasi" tabindex="-1" role="dialog" aria-labelledby="m_lokasi" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Lokasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalLokasi">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Lokasi</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <div class="modal fade" id="m_plu" tabindex="-1" role="dialog" aria-labelledby="m_lokasi" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PLU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalPLU">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>PLU</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <div class="modal fade" id="m_kodedisplay" tabindex="-1" role="dialog" aria-labelledby="m_kodedisplay"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV KODE DISPLAY</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalKodeDisplay">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Display</th>
                                        <th>Nama Display</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <div class="modal fade" id="m_pluprjsewa" tabindex="-1" role="dialog" aria-labelledby="m_pluprjsewa"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PLU dan Perjanjian Sewa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalPLUPrjSewa">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>PLU</th>
                                        <th>No. Perjanjian Sewa</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <script>
        row = '';
        maxrow = 0;
        $('.tanggal').datepicker({
            "dateFormat": "dd/mm/yy",
        });
        $(document).ready(function () {
            $('.lap-qty-minus').show();
            $('.lap-spb-manual').hide();
            // $('.tanggal').datepicker({
            //     "dateFormat": "dd/mm/yy",
            // });
            // $('.tanggal').datepicker('setDate', new Date());
            getModalNoPerjSewa('');
            getModalLokasi('');
            getModalPLU('');

            getModalKodeRak('');
            getModalPLUPrjSewa('');
        });

        function clearPage() {
            location.reload();
        }

        function cekTanggal(event) {
            tgl1 = $.datepicker.parseDate('dd/mm/yy', $('#startDate').val());
            tgl2 = $.datepicker.parseDate('dd/mm/yy', $('#endDate').val());
            if (tgl1 == '' || tgl2 == '') {
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
                return false;
            }
            if (new Date(tgl1) > new Date(tgl2)) {
                swal({
                    title: 'Tanggal Tidak Benar!',
                    icon: 'warning'
                });
                return false;
            }
            return true;
        }

        $('.daterange-periode').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        function gantiMenu() {
            menu = $('#menu').val();
            if (menu == '1') {
                $('.lap-qty-minus').show();
                $('.lap-spb-manual').hide();
            } else {
                $('.lap-qty-minus').hide();
                $('.lap-spb-manual').show();
            }
        }


        function getModalNoPerjSewa(value) {
            let tableModal = $('#tableModalnopjsewa').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/lovnopjsewa',
                    "data": {
                        'value': value
                    }
                },
                "columns": [
                    {data: 'gdl_noperjanjiansewa', name: 'gdl_noperjanjiansewa'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow  modalRownopjsewa');
                },
                "order": [],
                columnDefs: []
            });

            $('#tableModalnopjsewa_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalNoPerjSewa(val);
                }
            })
        }

        $(document).on('click', '.modalRownopjsewa', function () {
            var currentButton = $(this);
            let val = currentButton.children().first().text();

            $('#nopjsewa').val(val);
            getDataPerjanjian();
            $('#m_nopjsewa').modal('hide');
        });

        function getModalLokasi(value) {
            let tableModal = $('#tableModalLokasi').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/lovlokasi',
                    "data": {
                        'value': value
                    }
                },
                "columns": [
                    {data: 'lokasi', name: 'lokasi'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow  modalRowLokasi');
                },
                "order": [],
                columnDefs: []
            });

            $('#tableModalLokasi_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalLokasi(val);
                }
            })
        }

        $(document).on('click', '.modalRowLokasi', function () {
            var currentButton = $(this);
            let val = currentButton.children().first().text();

            $('#lokasi-' + row).val(val);
            $('#m_lokasi').modal('hide');
        });

        $(document).on('keypress', '#nopjsewa', function (e) {
            if (e.which == 13) {
                getDataPerjanjian()
            }
        });

        function changeRow(value) {
            this.row = value;
        }

        function getDataPerjanjian() {
            let nopjsewa = $('#nopjsewa').val();
            $.ajax({
                url: '{{ url()->current().'/getdatanopjsewa' }}',
                type: 'GET',
                data: {
                    nopjsewa: nopjsewa
                },
                beforeSend: function () {
                    $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    $('#model').val(response.model);
                    $('#body-table-detail').empty();
                    $('#body-table-lokasi').empty();
                    if (response.data) {
                        maxrow = response.data.length;
                        for (i = 0; i < response.data.length; i++) {
                            row = i;
                            $('#body-table-detail').append(`
                                    <tr class="rowDetail modalRow row-` + row + `" row="` + row + `">
                                        <td><input type="text" class="form-control text" readonly value="` + response.data[i].gdl_prdcd + `"></td>
                                        <td><input type="text" class="form-control text" readonly value="` + response.data[i].gdl_kodedisplay + `"></td>
                                        <td><input type="text" class="form-control text" readonly value="` + response.data[i].gdl_qty + `"></td>
                                        <td><input type="text" class="form-control text" readonly value="` + response.data[i].gdl_kodeprincipal + `"></td>
                                        <td><input type="text" class="form-control text" readonly value="` + response.data[i].gdl_tglawal.substring(0, 10) + `"></td>
                                        <td><input type="text" class="form-control text" readonly value="` + response.data[i].gdl_tglakhir.substring(0, 10) + `"></td>
                                        <td>
                                            <div class="col-sm-12 buttonInside">
                                                <input id="lokasi-` + row + `" type="text" class="form-control text">
                                                <button type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_lokasi" onclick="changeRow('` + row + `')">
                                                    <img src="{{ (asset('image/icon/help.png')) }}"
                                                         width="30px">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                            `);
                        }
                    }

                    if (response.model == 'TAMBAH') {
                        addRow();
                        $('#btnAddRow').prop('disabled', false);
                        $('#btnRemoveRow').prop('disabled', false);
                    }
                    $('#modal-loader').modal('toggle');
                }
            });
        }

        function addRow() {
            maxrow = $('#body-table-detail tr').length;
            $('#body-table-detail').append(`
                                    <tr class="rowDetail modalRow row-` + maxrow + `">
                                        <td>
                                            <div class="col-sm-12 buttonInside">
                                                <input id="plu-` + maxrow + `" type="text" class="form-control text">
                                                <button type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_plu" onclick="changeRow('` + maxrow + `')">
                                                    <img src="{{ (asset('image/icon/help.png')) }}"
                                                         width="30px">
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-sm-12 buttonInside">
                                                <input id="kodedisplay-` + maxrow + `" type="text" class="form-control text">
                                                <button type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_kodedisplay" onclick="changeRow('` + maxrow + `')">
                                                    <img src="{{ (asset('image/icon/help.png')) }}"
                                                         width="30px">
                                                </button>
                                            </div>
                                        </td>
                                        <td><input type="text" class="form-control text"></td>
                                        <td><input type="text" class="form-control text"></td>
                                        <td><input type="text" class="form-control text tanggal"></td>
                                        <td><input type="text" class="form-control text tanggal"></td>
                                        <td>
                                            <div class="col-sm-12 buttonInside">
                                                <input id="lokasi-` + maxrow + `" type="text" class="form-control text">
                                                <button type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_lokasi" onclick="changeRow('` + maxrow + `')">
                                                    <img src="{{ (asset('image/icon/help.png')) }}"
                                                         width="30px">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                            `);
            $('.tanggal').datepicker({
                "dateFormat": "dd/mm/yy",
            });
        }

        $(document).on('click', '.rowDetail', function () {
            let plu = $(this).children().first().find('input').val();
            if (plu != '') {
                $.ajax({
                    url: '{{ url()->current().'/getdatalokasi' }}',
                    type: 'GET',
                    data: {
                        plu: plu
                    },
                    beforeSend: function () {
                        // $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        // $('#modal-loader').modal('toggle');
                        $('#body-table-lokasi').empty();
                        console.log(response);
                        if (response) {
                            for (i = 0; i < response.length; i++) {
                                $('#body-table-lokasi').append(`
                                    <tr>
                                        <td><input type="text" class="form-control text" disabled value="` + response[i].lks_koderak + `"></td>
                                        <td><input type="text" class="form-control text" disabled value="` + response[i].lks_kodesubrak + `"></td>
                                        <td><input type="text" class="form-control text" disabled value="` + response[i].lks_tiperak + `"></td>
                                        <td><input type="text" class="form-control text" disabled value="` + response[i].lks_shelvingrak + `"></td>
                                        <td><input type="text" class="form-control text" disabled value="` + response[i].lks_nourut + `"></td>
                                        <td><input type="text" class="form-control text" disabled value="` + response[i].lks_qty + `"></td>
                                        <td><input type="text" class="form-control text" disabled value="` + response[i].lks_maxplano + `"></td>
                                    </tr>
                            `);
                            }
                        }
                    }
                });
            }
        });

        function getModalPLU(value) {
            let tableModal = $('#tableModalPLU').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/lovplu',
                    "data": {
                        'value': value
                    }
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow modalRowPLU');
                },
                "order": [],
                columnDefs: []
            });

            $('#tableModalPLU_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalPLU(val);
                }
            })
        }

        $(document).on('click', '.modalRowPLU', function () {
            var currentButton = $(this);
            let val = currentButton.children().first().text();
            $('.row-' + row).children().first().find('input').val(val);

            $('#m_plu').modal('hide');
        });

        function getModalKodeDisplay(value) {
            let tableModal = $('#tableModalPLU').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/lovkodedisplay',
                    "data": {
                        'value': value
                    }
                },
                "columns": [
                    {data: 'dis_kodedisplay', name: 'dis_kodedisplay'},
                    {data: 'dis_namadisplay', name: 'dis_namadisplay'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow modalRowKodeDisplay');
                },
                "order": [],
                columnDefs: []
            });

            $('#tableModalKodeDisplay_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalKodeDisplay(val);
                }
            })
        }

        $(document).on('click', '.modalRowKodeDisplay', function () {
            var currentButton = $(this);
            let val = currentButton.children().first().text();
            $('.row-' + row).children().first().next().find('input').val(val);

            $('#m_kodedisplay').modal('hide');
        });
        $(document).on('click', '#btnAddRow', function (e) {
            addRow();
        });
        $(document).on('click', '#btnRemoveRow', function (e) {
            $('.row-' + maxrow).remove();
            maxrow--;
        });

        function simpanPerjanjianSewa() {
            data = [];

            for (i = 0; i < maxrow + 1; i++) {
                obj = {};
                obj.plu = $('.row-' + i).children().first().find('input').val();
                obj.kodedisplay = $('.row-' + i).children().first().next().find('input').val();
                obj.qty = $('.row-' + i).children().first().next().next().find('input').val();
                obj.kodeprincipal = $('.row-' + i).children().first().next().next().next().find('input').val();
                obj.tglawal = $('.row-' + i).children().first().next().next().next().next().find('input').val();
                obj.tglakhir = $('.row-' + i).children().first().next().next().next().next().next().find('input').val();
                obj.lokasi = $('.row-' + i).children().last().find('input').val();

                if (obj.plu != '' && obj.kodedisplay != '' && obj.qty != '' && obj.kodeprincipal != '' && obj.tglawal != '' && obj.tglakhir != '' && obj.lokasi != '') {
                    data.push(obj);
                } else {
                    swal('Error', 'Data Masih Ada yang Kosong!', 'error');
                    return false;
                }
            }
            model = $('#model').val();
            nopjsewa = $('#nopjsewa').val();
            if (nopjsewa != '' && data.length > 0) {
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current().'/simpanperjanjiansewa' }}',
                    type: 'post',
                    data: {
                        data: data,
                        model: model,
                        nopjsewa: nopjsewa
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('toggle');
                        swal(response.status, response.message, response.status);
                    },
                    error: function (response) {
                        $('#modal-loader').modal('toggle');
                        alertError(response);
                    }
                });
            } else {
                swal('Error', 'Isi No Perjanjian Sewa!', 'error');
                return false;
            }
        }

        //====================================================TAB LOKASI===============================================================
        function getModalKodeRak(value) {
            let tableModal = $('#tableModalKodeRak').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/lovkoderak',
                    "data": {
                        'value': value
                    }
                },
                "columns": [
                    {data: 'lks_koderak', name: 'lks_koderak'},
                    {data: 'lks_kodesubrak', name: 'lks_kodesubrak'},
                    {data: 'lks_tiperak', name: 'lks_tiperak'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow modalRowKodeRak');
                },
                "order": [],
                columnDefs: []
            });

            $('#tableModalKodeRak_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalKodeRak(val);
                }
            })
        }

        $(document).on('click', '.modalRowKodeRak', function () {
            var currentButton = $(this);
            let koderak = currentButton.children().first().text();
            let subrak = currentButton.children().first().next().text();
            let tiperak = currentButton.children().first().next().next().text();

            $('#koderak').val(koderak);
            $('#subrak').val(subrak);
            $('#tiperak').val(tiperak);
            $('#m_koderak').modal('hide');
        });

        function getDataLokasi() {
            let rak = $('#koderak').val();
            let subrak = $('#subrak').val();
            let tiperak = $('#tiperak').val();
            $.ajax({
                url: '{{ url()->current().'/getdatalokasi2' }}',
                type: 'GET',
                data: {
                    rak: rak,
                    subrak: subrak,
                    tiperak: tiperak,
                },
                beforeSend: function () {
                    $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    $('#modal-loader').modal('toggle');
                    console.log(response);
                    $('#body-table-lokasi2').empty();
                    if (response) {
                        for (i = 0; i < response.length; i++) {
                            $('#body-table-lokasi2').append(`
                                    <tr>
                                        <td><input type="text" class="form-control text" disabled id="shelving-` + i + `" value="` + response[i].lks_shelvingrak + `"></td>
                                        <td><input type="text" class="form-control text" disabled id="nourut-` + i + `" value="` + response[i].lks_nourut + `"></td>
                                        <td>
                                            <div class="col-sm-12 buttonInside">
                                                <input id="plu2-` + i + `" type="text" class="form-control text">
                                                <button type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_pluprjsewa" onclick="changeRow2('` + i + `')">
                                                    <img src="{{ (asset('image/icon/help.png')) }}"
                                                         width="30px">
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="col-sm-12 buttonInside">
                                                <input id="noprjsewa-` + i + `" type="text" class="form-control text">
                                                <button type="button" class="btn btn-lov p-0"
                                                        data-toggle="modal" data-target="#m_pluprjsewa" onclick="changeRow2('` + i + `')">
                                                    <img src="{{ (asset('image/icon/help.png')) }}"
                                                         width="30px">
                                                </button>
                                            </div>
                                        </td>
                                        <td><button class="btn btn-primary" onclick="simpan2(` + i + `)">Simpan</button></td>
                                    </tr>
                            `);
                        }
                    }
                }
            });
        }

        row2 = 0;

        function getModalPLUPrjSewa(value) {
            let tableModal = $('#tableModalPLUPrjSewa').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/lovpluprjsewa',
                    "data": {
                        'value': value
                    }
                },
                "columns": [
                    {data: 'gdl_prdcd', name: 'gdl_prdcd'},
                    {data: 'gdl_noperjanjiansewa', name: 'gdl_noperjanjiansewa'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow modalRowPLUPrjSewa');
                },
                "order": [],
                columnDefs: []
            });

            $('#tableModalPLUPrjSewa_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalPLUPrjSewa(val);
                }
            })
        }

        $(document).on('click', '.modalRowPLUPrjSewa', function () {
            var currentButton = $(this);
            let plu = currentButton.children().first().text();
            let noprj = currentButton.children().first().next().text();

            $('#plu2-' + row2).val(plu);
            $('#noprjsewa-' + row2).val(noprj);
            $('#m_pluprjsewa').modal('hide');
        });

        function changeRow2(value) {
            this.row2 = value;
        }

        function simpan2(i) {
            shelving = $('#shelving-' + i).val();
            nourut = $('#nourut-' + i).val();
            plu = $('#plu2-' + i).val();
            noprjsewa = $('#noprjsewa-' + i).val();

            if (plu == '' || noprjsewa == '') {
                swal('Error', 'Data Masih Ada yang Kosong!', 'error');
                return false;
            }

            rak = $('#koderak').val();
            subrak = $('#subrak').val();
            tiperak = $('#tiperak').val();

            if (rak != '' && subrak != '' && tiperak != '') {
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current().'/simpan2' }}',
                    type: 'post',
                    data: {
                        rak: rak,
                        subrak: subrak,
                        tiperak: tiperak,
                        shelving: shelving,
                        nourut: nourut,
                        plu: plu,
                        noprjsewa: noprjsewa
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('toggle');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('toggle');
                        swal(response.status.toUpperCase(), response.message, response.status);
                    },
                    error: function (response) {
                        $('#modal-loader').modal('toggle');
                        alertError('Error',response.responseJSON.message);
                    }
                });
            } else {
                swal('Error', 'Rak, Sub Rak, Tipe Rak Masih Kosong!', 'error');
                return false;
            }
        }
    </script>
@endsection
