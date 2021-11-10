@extends('navbar')

@section('title','TABEL | Monitoring Supplier')

@section('content')

    <div class="container" id="first-view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend class="w-auto ml-3">Monitoring Supplier</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode
                                        Monitoring</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left text-uppercase"
                                               autocomplete="off" maxlength="1" id="first-mon-kode">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_monitoring">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">Nama
                                        Monitoring</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" autocomplete="off"
                                               id="first-mon-nama">
                                    </div>
                                    <div class="col-sm"></div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" onclick="pilih()">PILIH
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="container" id="second-view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend class="w-auto ml-3">Tabel Monitoring Supplier</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode
                                        Monitoring</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left text-uppercase"
                                               autocomplete="off" id="second-mon-kode" disabled>
                                    </div>
                                    <div class="col-sm"></div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-danger" onclick="resetAll()">GANTI KODE
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">Nama
                                        Monitoring</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" id="second-mon-nama" disabled>
                                    </div>
                                    <div class="col-sm"></div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" id="btn-print" onclick="print()">PRINT
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table bordered table-sm mt-3" id="table_data">
                                    <thead class="theadDataTables">
                                    <tr class="text-center align-middle">
                                        <th class="align-middle" width="10%"></th>
                                        <th class="align-middle" width="15%">Supplier</th>
                                        <th class="align-middle" width="60%"></th>
                                        <th class="align-middle" width="15%">PKP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0" id="supp_field">
                            <legend class="w-auto ml-3">Input Kode Supplier</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="supplier" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode
                                        Supplier</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="kode-supplier">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_supplier">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Nama
                                        Supplier</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-left" id="nama-supplier" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">PKP</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-left" id="pkp" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="col-sm btn btn-danger" id="btn-delete"
                                                onclick="hapusRow($('#kode-supplier').val())" disabled>HAPUS
                                        </button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="col-sm btn btn-success" id="btn-add" onclick="tambah()" disabled>
                                            TAMBAH
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_lov_monitoring" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Monitoring</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_monitoring">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Monitoring</th>
                                        <th>Nama Monitoring</th>
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

    <div class="modal fade" id="m_lov_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Supplier</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_supplier">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Supplier</th>
                                        <th></th>
                                        <th>PKP</th>
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
        let dataSupplierMonitoring = [];
        $(document).ready(function () {
            getLovMonitoring();

            getModalData('');

            makeDataTable();

            $('#first-view').show();
            $('#second-view').hide();
            $('#first-mon-kode').focus();
        });

        function makeDataTable() {
            $('#table_data').DataTable({
                "scrollY": '30vh',
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        }

        $('#m_lov_supplier').on('shown.bs.modal', function () {
            $('#table_lov_supplier_filter input').val('');
            $('#table_lov_supplier_filter input').select();
        });

        function getModalData(value) {
            if ($.fn.DataTable.isDataTable('#table_lov_supplier')) {
                $('#table_lov_supplier').DataTable().destroy();
                $("#table_lov_supplier tbody [role='row']").remove();
            }


            $('#table_lov_supplier').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/get-lov-supplier',
                    "data": {
                        'supplier': value
                    },
                },
                "columns": [
                    {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},
                    {data: 'sup_namasupplier', name: 'sup_namasupplier'},
                    {data: 'sup_pkp', name: 'sup_pkp'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-supplier modalRow');
                },
                "initComplete": function () {
                    $('#table_lov_supplier_filter input').val(value).select();

                    $(document).on('click', '.row-supplier', function (e) {
                        $('#kode-supplier').val($(this).find('td:eq(0)').html());
                        $('#nama-supplier').val($(this).find('td:eq(1)').html());
                        $('#pkp').val($(this).find('td:eq(2)').html());

                        found = false;
                        console.log(dataSupplierMonitoring);
                        for (i = 0; i < dataSupplierMonitoring.length; i++) {
                            if (dataSupplierMonitoring[i].msu_kodesupplier == $('#kode-supplier').val()) {
                                found = true;
                                break;
                            }
                        }

                        if (found) {
                            $('#btn-delete').prop('disabled', false);
                            $('#btn-add').prop('disabled', true);
                        } else {
                            $('#btn-delete').prop('disabled', true);
                            $('#btn-add').prop('disabled', false);
                        }

                        $('#m_lov_supplier').modal('hide');
                    });
                }
            });

            $('#table_lov_supplier_filter input').val(value);

            $('#table_lov_supplier_filter input').off().on('keypress', function (e) {
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();
                    getModalData(val);
                }
            });
        }


        function getLovMonitoring() {
            if ($.fn.DataTable.isDataTable('#table_lov_monitoring')) {
                $('#table_lov_monitoring').DataTable().destroy();
                $("#table_lov_monitoring tbody [role='row']").remove();
            }

            $('#table_lov_monitoring').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/get-lov-monitoring',
                    "data": {},
                },
                "columns": [
                    {data: 'kode', name: 'kode'},
                    {data: 'nama', name: 'nama'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-monitoring modalRow');
                },
                "initComplete": function () {
                    $(".row-monitoring").prop("onclick", null).off("click");

                    $(document).on('click', '.row-monitoring', function (e) {
                        $('#first-mon-kode').val($(this).find('td:eq(0)').html());
                        $('#first-mon-nama').val($(this).find('td:eq(1)').html());
                        $('#second-mon-kode').val($(this).find('td:eq(0)').html());
                        $('#second-mon-nama').val($(this).find('td:eq(1)').html());

                        $('#first-view').hide();
                        $('#second-view').show();

                        getData();

                        $('#m_lov_monitoring').modal('hide');
                    });
                }
            });
        }

        $('#first-mon-kode,#first-mon-nama').on('keypress', function (e) {
            if (e.which == 13) {
                pilih();
            }
        });

        function pilih() {
            $('#first-mon-kode').val($('#first-mon-kode').val().toUpperCase());
            getData();
        }

        function getData() {
            if ($('#first-mon-kode').val() == '') {
                swal({
                    title: 'Kode monitoring tidak boleh kosong!',
                    icon: 'error'
                }).then(() => {
                    $('#first-mon-kode').select();
                });
            } else {
                $.ajax({
                    url: '{{ url()->current() }}/cek-data',
                    type: 'get',
                    data: {
                        kodemonitoring: $('#first-mon-kode').val(),
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if (response.data != null) { //kalau ada data monitoring
                            $('#btn-print').prop('disabled', false);
                            $('#second-mon-kode').val(response.data.msu_kodemonitoring)
                            $('#second-mon-nama').val(response.data.msu_namamonitoring)
                            if ($.fn.DataTable.isDataTable('#table_data')) {
                                $('#table_data').DataTable().destroy();
                                $("#table_data tbody [role='row']").remove();
                            }
                            dataSupplierMonitoring = [];
                            $('#table_data').DataTable({
                                "ajax": {
                                    'url': '{{ url()->current() }}/get-monitoring',
                                    "data": {
                                        "supplier": $('#first-mon-kode').val()
                                    },
                                },
                                "columns": [
                                    {data: 'msu_kodesupplier', name: 'msu_kodesupplier'},
                                    {data: 'msu_kodesupplier', name: 'msu_kodesupplier'},
                                    {data: 'sup_namasupplier', name: 'sup_namasupplier'},
                                    {data: 'sup_pkp', name: 'sup_pkp'},
                                ],
                                "paging": true,
                                "lengthChange": true,
                                "searching": true,
                                "ordering": true,
                                "info": true,
                                "autoWidth": false,
                                "responsive": true,
                                "createdRow": function (row, data, dataIndex) {
                                    dataSupplierMonitoring.push(data);
                                },
                                "columnDefs": [
                                    {
                                        "targets": [3],
                                        "className": 'text-center'
                                    },
                                    {
                                        "targets": [0],
                                        "render": function (data, type, row, meta) {
                                            return `<button class="btn btn-danger btn-delete-row" onclick="hapusRow('` + data + `')">
                                X
                                    </button>`;
                                        }
                                    }
                                ]
                            });
                            $('#first-view').hide();
                            $('#second-view').show();
                        } else {
                            $('#btn-print').prop('disabled', true);
                            if ($('#first-mon-nama').val().trim() == '') {
                                swal({
                                    title: "Mohon Nama monitoring diisi!",
                                    icon: 'error',
                                }).then(() => {
                                    $('#first-mon-nama').focus();
                                });
                            } else {
                                $('#second-mon-kode').val($('#first-mon-kode').val());
                                $('#second-mon-nama').val($('#first-mon-nama').val());
                                $('#first-view').hide();
                                $('#second-view').show();
                            }
                        }

                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {

                        });
                    }
                });


            }
        }


        function print() {
            window.open(`{{ url()->current() }}/print?mon=${$('#first-mon-kode').val().toUpperCase()}`, '_blank');
        }


        function hapusRow(value) {
            swal({
                title: 'Yakin ingin menghapus supplier ' + value + ' ?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((confirm) => {
                if (confirm) {
                    $.ajax({
                        url: '{{ url()->current() }}/hapus',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            kodemonitoring: $('#first-mon-kode').val(),
                            kodesupplier: value
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: response.message,
                                icon: 'success'
                            }).then(function () {
                                $('#kode-supplier').val('');
                                $('#nama-supplier').val('');
                                $('#pkp').val('');
                                $('#btn-delete').prop('disabled', true);
                                getData();
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {

                            });
                        }
                    });
                }
            })

        }

        function tambah() {
            swal({
                title: 'Yakin ingin menambahkan supplier ' + $('#kode-supplier').val() + ' ?',
                icon: 'info',
                buttons: true,
                dangerMode: true
            }).then((value) => {
                if (value) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/tambah',
                        type: 'POST',
                        data: {
                            kodemonitoring: $('#first-mon-kode').val(),
                            namamonitoring: $('#first-mon-nama').val(),
                            kodesupplier: $('#kode-supplier').val()
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: response.message,
                                icon: response.status
                            }).then(() => {
                                $('#kode-supplier').val('');
                                $('#nama-supplier').val('');
                                $('#pkp').val('');
                                $('#btn-add').prop('disabled', true);
                                getData();
                            });

                        }, error: function (err) {
                            console.log(err.responseJSON.message.substr(0, 150));
                            alertError(err.statusText, err.responseJSON.message);
                        }
                    });
                }
            })

        }

        function resetAll() {
            dataSupplierMonitoring = [];
            $('input').val('');
            if ($.fn.DataTable.isDataTable('#table_data')) {
                $('#table_data').DataTable().destroy();
                $("#table_data tbody [role='row']").remove();
            }
            $('#btn-print').prop('disabled', false);
            $('#table_data').DataTable();
            $('#first-view').show();
            $('#second-view').hide();
            $('#first-mon-kode').focus();

        }
    </script>
@endsection
