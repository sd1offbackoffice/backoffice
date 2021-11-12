@extends('navbar')

@section('title','TABEL | Monitoring Supplier')

@section('content')

    <div class="container" id="first-view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend class="w-auto ml-3">Monitoring Sales & Stok Super Fast Moving Product</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">Avg Sls s/d
                                        Bulan</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="number" min="1" max="12"
                                               class="form-control text-left text-uppercase"
                                               autocomplete="off" id="bulan">
                                    </div>
                                    <label for="" class="col-sm-1 col-form-label text-right pl-0 pr-0">[ 1 - 12
                                        ]</label>
                                </div>
                                <div class="row form-group">
                                    <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">Periode
                                        Margin</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left tanggal"
                                               autocomplete="off" id="periode-1">
                                    </div>
                                    <label for="" class="col-sm-1 col-form-label text-center pl-0 pr-0">s / d</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left tanggal"
                                               autocomplete="off" id="periode-2">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode
                                        Monitoring</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left text-uppercase"
                                               autocomplete="off" id="kode-monitoring" readonly>
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_monitoring">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left"
                                               autocomplete="off" id="nama-monitoring" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">PLU</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left text-uppercase"
                                               autocomplete="off" id="plu-1">
                                        <button type="button" class="btn btn-primary btn-lov p-0"
                                                onclick="changeObjectPLU('#plu-1'),getLovPLU()" readonly>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <label for="" class="col-sm-1 col-form-label text-center pl-0 pr-0">s / d</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left text-uppercase"
                                               autocomplete="off" id="plu-2">
                                        <button type="button" class="btn btn-primary btn-lov p-0"
                                                onclick="changeObjectPLU('#plu-2'),getLovPLU()" readonly>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">Ranking
                                        By</label>
                                    <div class="col-sm-1">
                                        <input type="number" class="form-control text-left"
                                               autocomplete="off" id="rank-by">
                                    </div>
                                    <label for="" class="col-sm-2 col-form-label text-center pl-0 pr-0">[ 1 - AVG
                                        SALES]</label>
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

    <div class="container-fluid" id="second-view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend class="w-auto ml-3">Monitoring Sales & Stock</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode
                                        Monitoring</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left text-uppercase"
                                               autocomplete="off" id="kode-monitoring-2" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left text-uppercase"
                                               autocomplete="off" id="nama-monitoring-2" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table bordered table-sm mt-3" id="table_data">
                                    <thead class="theadDataTables">
                                    <tr class="text-center align-middle">
                                        <th class="align-middle">PLU</th>
                                        <th class="align-middle">AVG SALES</th>
                                        <th class="align-middle">AVG SALES QTY</th>
                                        <th class="align-middle">SALES QTY</th>
                                        <th class="align-middle">MARGIN Rp.</th>
                                        <th class="align-middle">MARGIN %</th>
                                        <th class="align-middle">SALDO AKHIR</th>
                                        <th class="align-middle">PKMT</th>
                                        <th class="align-middle">PO OUTS</th>
                                        <th class="align-middle">PB OUTS</th>
                                        <th class="align-middle">JADWAL PB</th>
                                        <th class="align-middle">KETERANGAN</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="" class="col-sm-1 col-form-label text-right pl-0 pr-0">DESC</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control text-left text-uppercase"
                                               autocomplete="off" id="deskripsi" disabled>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" onclick="resetAll()">BACK
                                        </button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" onclick="print()">PRINT
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
    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PLU</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_plu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>PLU</th>
                                        <th>Deskripsi</th>
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
        let objPLU;
        $(document).ready(function () {
            $('#table_data').DataTable();
            $('.tanggal').datepicker({
                "dateFormat": "dd/mm/yy",
            });
            $('.tanggal').datepicker('setDate', new Date());
            getLovMonitoring();

            $('#first-view').show();
            $('#second-view').hide();

            $('#bulan').focus();
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

        $('#m_lov_monitoring').on('shown.bs.modal', function () {
            $('#table_lov_monitoring_filter input').val('');
            $('#table_lov_monitoring_filter input').select();
        });

        $('#m_lov_plu').on('shown.bs.modal', function () {
            $('#table_lov_plu_filter input').val('');
            $('#table_lov_plu_filter input').select();
        });

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
                        $('#kode-monitoring').val($(this).find('td:eq(0)').html());
                        $('#nama-monitoring').val($(this).find('td:eq(1)').html());

                        $('#m_lov_monitoring').modal('hide');
                    });
                }
            });
        }

        function getLovPLU() {
            if ($('#kode-monitoring').val().trim() == '') {
                swal({
                    title: 'Pilih Kode monitoring terlebih dahulu!',
                    icon: 'info'
                }).then(() => {
                    $('#kode-monitoring').select();
                    return false;
                });
            } else {
                $('#m_lov_plu').modal('show');

                if ($.fn.DataTable.isDataTable('#table_lov_plu')) {
                    $('#table_lov_plu').DataTable().destroy();
                    $("#table_lov_plu tbody [role='row']").remove();
                }

                $('#table_lov_plu').DataTable({
                    "ajax": {
                        'url': '{{ url()->current() }}/get-lov-plu',
                        "data": {
                            "kode": $('#kode-monitoring').val(),
                            "nama": $('#nama-monitoring').val(),
                        },
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
                        $(row).addClass('row-plu modalRow');
                    },
                    "initComplete": function () {
                        $(".row-plu").prop("onclick", null).off("click");

                        $(document).on('click', '.row-plu', function (e) {
                            $(objPLU).val($(this).find('td:eq(0)').html());

                            $('#m_lov_plu').modal('hide');
                        });
                    }
                });
            }
        }

        function changeObjectPLU(value) {
            objPLU = value;
        }

        $('#bulan').on('keyup', function (e) {
            $('#bulan').removeClass('is-invalid');
            if ($(this).val() == new Date().getMonth() + 1) {
                swal({
                    title: 'Bulan tidak boleh pada bulan yang aktif!',
                    icon: 'info'
                }).then(() => {
                    $(this).val($(this).val() - 1);
                });
            }
            if ($(this).val() < 1 || $(this).val() > 12) {
                swal({
                    title: 'Isi dengan 1-12 saja!',
                    icon: 'info'
                }).then(() => {
                    $(this).val(1);
                });
            }
        });

        $('#rank-by').on('keyup', function (e) {
            if ($(this).val() != 1 && $(this).val().trim() != '') {
                swal({
                    title: 'Isi dengan 1 / [kosong] saja!',
                    icon: 'info'
                }).then(() => {
                    $(this).val(1);
                });
            }
        });

        function pilih() {
            $('#first-view input').removeClass('is-invalid');
            getData();
        }

        function validation() {
            if ($('#bulan').val().trim() == '') {
                $('#bulan').addClass('is-invalid');
            }
            if ($('#kode-monitoring').val().trim() == '') {
                $('#kode-monitoring').addClass('is-invalid');
            }
            if ($('#periode-1').val().trim() == '') {
                $('#periode-1').addClass('is-invalid');
            }
            if ($('#periode-2').val().trim() == '') {
                $('#periode-2').addClass('is-invalid');
            }
            if ($('#plu-1').val().trim() > $('#plu-2').val().trim()) {
                swal({
                    title: 'P.L.U I tidak boleh > P.L.U II',
                    icon: 'info'
                }).then(() => {
                    $('#plu-2').val('');
                    $('#plu-2').focus();
                });
            }
            if ($('#periode-1').datepicker('getDate') > $('#periode-2').datepicker('getDate')) {
                swal({
                    title: 'Tanggal Margin I tidak boleh > Tanggal Margin II',
                    icon: 'info'
                }).then(() => {
                    $('#periode-2').val('');
                    $('#periode-2').focus();
                });
            }
        }

        function getData() {
            if ($('#bulan').val().trim() == '' || $('#kode-monitoring').val().trim() == ''
                || $('#periode-1').val().trim() == '' || $('#periode-2').val().trim() == '') {
                validation();
                return false;
            } else {
                $('#modal-loader').modal('show');
                $('#kode-monitoring-2').val($('#kode-monitoring').val());
                $('#nama-monitoring-2').val($('#nama-monitoring').val());
                if ($.fn.DataTable.isDataTable('#table_data')) {
                    $('#table_data').DataTable().destroy();
                    $("#table_data tbody [role='row']").remove();
                }
                $('#table_data').DataTable({
                    "ajax": {
                        'url': '{{ url()->current() }}/get-data',
                        "data": {
                            bulan: $('#bulan').val(),
                            kodemonitoring: $('#kode-monitoring').val(),
                            periode1: $('#periode-1').val(),
                            periode2: $('#periode-2').val(),
                            plu1: $('#plu-1').val() == '' ? '0000000' : $('#plu-1').val(),
                            plu2: $('#plu-2').val() == '' ? '9999999' : $('#plu-2').val(),
                            rankby: $('#rank-by').val(),
                        },
                    },
                    "columns": [
                        {data: 'mpl_prdcd', name: 'mpl_prdcd'},
                        {data: 'avgsales', name: 'avgsales'},
                        {data: 'avgqty', name: 'avgqty'},
                        {data: 'sales', name: 'sales'},
                        {data: 'margin', name: 'margin'},
                        {data: 'margin2', name: 'margin2'},
                        {data: 'saldo', name: 'saldo'},
                        {data: 'ftpkmt', name: 'ftpkmt'},
                        {data: 'po', name: 'po'},
                        {data: 'pb', name: 'pb'},
                        {data: 'tglpb', name: 'tglpb'},
                        {data: 'keterangan', name: 'keterangan'},
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).addClass('modalRow row-data');
                        $(row).attr('data', data.deskripsi);
                    },
                    "columnDefs": [
                        {
                            "targets": [1],
                            "className": 'text-right',
                            "render": function (data, type, row) {
                                return convertToRupiah2(data);
                            }
                        },
                        {
                            "targets": [2],
                            "className": 'text-right',
                            "render": function (data, type, row) {
                                return convertToRupiah2(data);
                            }
                        },
                        {
                            "targets": [3],
                            "className": 'text-right',
                            "render": function (data, type, row) {
                                return convertToRupiah2(data);
                            }
                        },
                        {
                            "targets": [4],
                            "className": 'text-right',
                            "render": function (data, type, row) {
                                return convertToRupiah2(data);
                            }
                        },
                        {
                            "targets": [5],
                            "className": 'text-right',
                            "render": function (data, type, row) {
                                return convertToRupiah(data);
                            }
                        },
                        {
                            "targets": [6],
                            "className": 'text-right',
                            "render": function (data, type, row) {
                                return convertToRupiah2(data);
                            }
                        },
                        {
                            "targets": [7],
                            "className": 'text-right',
                            "render": function (data, type, row) {
                                return convertToRupiah2(data);
                            }
                        },
                        {
                            "targets": [8],
                            "className": 'text-right',
                            "render": function (data, type, row) {
                                return convertToRupiah2(data);
                            }
                        },
                        {
                            "targets": [9],
                            "className": 'text-right',
                            "render": function (data, type, row) {
                                return convertToRupiah2(data);
                            }
                        },
                        {
                            "targets": [10],
                            "render": function (data, type, row) {
                                return formatDate(data)
                            }
                        }
                    ],
                    "initComplete": function () {
                        $('#modal-loader').modal('hide');

                        $(document).on('click', '.row-data', function (e) {
                            $('#deskripsi').val($(this).attr('data'));
                        });
                    }
                });
                $('#first-view').hide();
                $('#second-view').show();
            }
        }


        function print() {
            swal({
                title: 'Apakah NILAI MARGIN ingin di cetak? ',
                showDenyButton: true,
                buttons: ["Tidak", "Ya"],
                icon: 'info'
            }).then((result) => {
                    margin = 'N';
                    if (result) {
                        margin = 'Y';
                    }
                    window.open(`{{ url()->current() }}/print?bulan=${$('#bulan').val()}&kodemonitoring=${$('#kode-monitoring').val()}&namamonitoring=${$('#nama-monitoring').val()}&periode1=${$('#periode-1').val()}&periode2=${$('#periode-2').val()}&plu1=${$('#plu-1').val()}&plu2=${$('#plu-2').val()}&rank=${$('#rank-by').val()}&margin=${margin}`, '_blank');
            })
        }

        function resetAll() {
            $('input').val('');
            $('.tanggal').datepicker('setDate', new Date());
            if ($.fn.DataTable.isDataTable('#table_data')) {
                $('#table_data').DataTable().destroy();
                $("#table_data tbody [role='row']").remove();
            }
            $('#table_data').DataTable();
            $('#first-view').show();
            $('#second-view').hide();
            $('#bulan').focus();

        }
    </script>
@endsection
