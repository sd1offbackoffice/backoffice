@extends('navbar')

@section('title','TABEL | Jenis Rak Barang')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-body pt-0">
                    <fieldset class="card border-secondary mt-0">
                        <legend class="w-auto ml-3">Jenis Rak Barang</legend>
                        <div class="card-body py-0" id="top_field">
                            <div class="row form-group">
                                <label for="kode-rak" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode
                                    Rak</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control text-left" maxlength="1" id="kode-rak">
                                    <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                            data-target="#m_lov">
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="nama-rak" class="col-sm-2 col-form-label text-right pl-0 pr-0">Nama
                                    Rak</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text-left" id="nama-rak" maxlength="20">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="minimal-display" class="col-sm-2 col-form-label text-right pl-0 pr-0">Minimal
                                    Display</label>
                                <div class="col-sm-1">
                                    <input type="text" maxlength="1" class="form-control text-left"
                                           id="minimal-display">
                                </div>
                                <label for="minimal-display" class="col-sm-2 col-form-label pl-0 pr-0">['Y' / ]</label>
                            </div>
                            <br>
                            <div class="row form-group">
                                <label class="col-sm-3 col-form-label text-right pl-0 pr-0">Pg Up
                                    - Isian sebelumnya <br>Pg Dn - Isian sesudahnya</label>
                                <div class="offset-3 col-sm-2">
                                    <button class="col-sm btn btn-primary" id="" onclick="gantiTipe('')">Ganti Tipe
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="col-sm btn btn-danger" id="" onclick="hapus()">Hapus</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="col-sm btn btn-primary" id="" onclick="simpan()">Save</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Kode Rak</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Rak</th>
                                        <th>Nama Rak</th>
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
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
            /*overflow-y: hidden;*/
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
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover {
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .clicked, .row-detail:hover {
            background-color: grey !important;
            color: white;
        }

        .scrollable-field {
            max-height: 230px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .nowrap {
            white-space: nowrap;
        }
    </style>

    <script>
        var dataVoucher = [];
        var dataPLU = [];
        var supplierPLU = [];
        var tempPLU = [];

        $(document).ready(function () {
            getData('');
            getModalData('');
        });

        $('#m_lov').on('shown.bs.modal', function () {
            $('#table_lov_filter input').val('');
            $('#table_lov_filter input').select();
        });

        function getModalData(value) {
            if ($.fn.DataTable.isDataTable('#table_lov')) {
                $('#table_lov').DataTable().destroy();
                $("#table_lov tbody [role='row']").remove();
            }

            search = value.toUpperCase();

            $('#table_lov').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/get-lov',
                    "data": {
                        'koderak': search
                    },
                },
                "columns": [
                    {data: 'jrak_kodejenisrak', name: 'jrak_kodejenisrak'},
                    {data: 'jrak_namajenisrak', name: 'jrak_namajenisrak'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-kode-rak');
                },
                "initComplete": function () {
                    $('#table_lov_filter input').val(value).select();

                    $(".row-kode-rak").prop("onclick", null).off("click");

                    $(document).on('click', '.row-kode-rak', function (e) {
                        $("#kode-rak").val($(this).find('td:eq(0)').html());
                        getData($("#kode-rak").val());
                        $('#m_lov').modal('hide');
                    });
                }
            });

            $('#table_lov_filter input').val(value);

            $('#table_lov_filter input').off().on('keypress', function (e) {
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getModalData(val);
                }
            });
        }

        function hapus() {
            if ($('#kode-rak').val() == '') {
                swal({
                    title: 'Inputan Kode Rak tidak boleh kosong!',
                    icon: 'error'
                }).then(() => {
                    $('#kode-rak').select();
                });
            } else {
                swal({
                    title: 'Yakin ingin menghapus Kode Rak ' + $('#kode-rak').val() + '?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if (ok) {
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/hapus',
                            type: 'POST',
                            data: {
                                koderak: $('#kode-rak').val()
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    // $('#top_field input').val('');
                                    getData('');
                                    // $('#plu').select();
                                });
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error',
                                }).then(() => {

                                });
                            }
                        });
                    }
                });
            }
        }

        $('#minimal-display').bind('keyup', function (event) {
            $(this).val($(this).val().toUpperCase());
            let val = $(this).val();
            if (val != 'Y') {
                $(this).val('');
            }
        });

        function gantiTipe() {
            $('input').val('');
            swal({
                title: 'Masukan Kode Rak barang !',
                icon: 'info',
            }).then(() => {

            });
        }

        function getData(value) {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/get-data',
                type: 'GET',
                data: {
                    koderak: value
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    response = response.data;
                    $('#kode-rak').val(response.jrak_kodejenisrak);
                    $('#nama-rak').val(response.jrak_namajenisrak);
                    $('#minimal-display').val(response.jrak_mindisplay);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        function getNextKodeRak(value) {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/get-next-kode-rak',
                type: 'GET',
                data: {
                    koderak: value
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    response = response.data;
                    $('#kode-rak').val(response.jrak_kodejenisrak);
                    $('#nama-rak').val(response.jrak_namajenisrak);
                    $('#minimal-display').val(response.jrak_mindisplay);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        function getPrevKodeRak(value) {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/get-prev-kode-rak',
                type: 'GET',
                data: {
                    koderak: value
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    response = response.data;
                    $('#kode-rak').val(response.jrak_kodejenisrak);
                    $('#nama-rak').val(response.jrak_namajenisrak);
                    $('#minimal-display').val(response.jrak_mindisplay);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        $('#kode-rak').on('keypress', function (e) {
            if (e.which == 13) {
                let val = $(this).val();
                getData(val);
            }
        })

        $('#kode-rak').on('keyup', function (e) {
            $(this).val($(this).val().toUpperCase());
        })

        function simpan() {
            swal({
                title: 'Anda Yakin Simpan Data?',
                icon: 'info',
                buttons: true,
            }).then(function (confirm) {
                if (confirm) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/simpan',
                        type: 'post',
                        data: {
                            koderak: $('#kode-rak').val(),
                            namarak: $('#nama-rak').val(),
                            mindisplay: $('#minimal-display').val()
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            swal({
                                title: response.message,
                                icon: 'success'
                            }).then(() => {
                                getData($('#kode-rak').val());
                                getModalData('');
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {

                            });
                        }
                    });
                }
            })

        }

        $(window).bind('keydown', function (event) {
            if (event.which == 34) { // Page Down
                getNextKodeRak($('#kode-rak').val());
                event.preventDefault();
            } else if (event.which == 33) { // Page Up
                getPrevKodeRak($('#kode-rak').val());
                event.preventDefault();
            }
        });
    </script>
@endsection
