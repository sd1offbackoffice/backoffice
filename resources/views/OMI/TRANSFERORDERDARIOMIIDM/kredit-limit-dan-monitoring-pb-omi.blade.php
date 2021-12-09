@extends('navbar')
@section('title','Kredit Limit Dan Monitoring PB OMI')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-5">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">Input Kredit Limit OMI</legend>
                    <div class="card-body pt-0">
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Kode OMI</label>
                            <div class="col-sm-3 buttonInside">
                                <input type="text" class="form-control text-left" id="kodeomi" autocomplete="off">
                                <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                        data-target="#m_lov_kode_omi">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="namatokoomi" readonly>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Kode Customer</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="kodecustomer" readonly>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Kode Proxy</label>
                            <div class="form-check mt-2 ml-3">
                                <input class="form-check-input" type="radio" name="kodeproxy" id="proxyregular"
                                       value="1">
                                <label class="form-check-label" for="proxyregular">
                                    1 - Regular
                                </label>
                            </div>
                            <div class="form-check mt-2 ml-4">
                                <input class="form-check-input" type="radio" name="kodeproxy" id="proxyalokasi"
                                       value="2">
                                <label class="form-check-label" for="proxyalokasi">
                                    2 - Alokasi
                                </label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">OMI Tertentu</label>
                            <div class="col-sm-2 m-2">
                                <input class="input-checkbox" id="omitertentu" type="checkbox" value="Y">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Nilai Kredit Limit</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="nilaikreditlimit">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Top</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="top">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Tgl Top</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="tgltop">
                            </div>
                            <button id="btn_save" class="offset-1 col-sm-3 btn btn-success" onclick="simpan()">
                                Simpan
                            </button>
                        </div>
                        <div class="row">
                            <label class="col-sm-12 text-left col-form-label pl-0"><i> ** Credit Limit = [ SPD * ( TOP +
                                    1 ) ] + growth</i></label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-7">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">Master Kredit Limit OMI</legend>
                    <div class="card-body pt-0">
                        <table class="table table bordered table-sm mt-3" id="table-master-kredit-limit-omi">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th>Kode OMI</th>
                                <th>Nama OMI</th>
                                <th>Member</th>
                                <th>OMI Tertentu</th>
                                <th>Proxy</th>
                                <th>Nilai Kredit Limit</th>
                                <th>TOP</th>
                                <th>TGL TOP</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">Monitoring Data PB Tolakan
                    </legend>
                    <div class="card-body pt-0">

                        <table class="table bordered table-sm mt-3" id="table-monitoring-data-pb-tolakan">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th>Kode OMI</th>
                                <th>Nomor PB</th>
                                <th>Tgl PB</th>
                                <th>Nilai PB</th>
                                <th>Nilai Kredit Limit</th>
                                <th>Nilai Sisa Kredit Limit</th>
                                <th>Nilai Over Kredit Limit</th>
                                <th>Nilai Overdue</th>
                                <th>Tgl JT Overdue</th>
                                <th>Keterangan</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="row">
                            <label class="col-sm-1 text-right col-form-label pl-0">Nama OMI</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="namaomi" readonly>
                            </div>
                            <div class="col-sm-1">
                                <input type="text" class="form-control text-left" id="kodeomi2" readonly>
                            </div>

                            <label class="col-sm-2 text-right col-form-label pl-0">Jenis PB</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="jenispb" readonly>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_kode_omi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_kode_omi">
                                    <thead>
                                    <tr>
                                        <th>Kode OMI</th>
                                        <th>Nama Omi</th>
                                        <th>Customer</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_log_nontop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1">
                            <label class="offset-2 col-sm-3 text-right col-form-label pl-0">Kode Pemakai</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="username-log-non-top"
                                       style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="offset-2 col-sm-3 text-right col-form-label pl-0">Password</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control text-left" id="password-log-non-top">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <button class="offset-3 col-sm-2 btn btn-primary" data-dismiss="modal">
                                Back
                            </button>
                            <button class="offset-1 col-sm-3 btn btn-success" onclick="submitLogNonTop()">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_log" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1">
                            <label class="offset-2 col-sm-3 text-right col-form-label pl-0">Kode Pemakai</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="username-log"
                                       style="text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="offset-2 col-sm-3 text-right col-form-label pl-0">Password</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control text-left" id="password-log">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <button class="offset-3 col-sm-2 btn btn-primary" data-dismiss="modal">
                                Back
                            </button>
                            <button class="offset-1 col-sm-3 btn btn-success" onclick="submitLog()">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_proses_tolakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-5 justify-content-center">
                            <button class="col-sm-3 btn btn-primary" onclick="prosesTolakan(1)">
                                Ditolak Semua
                            </button>
                            <button class="offset-1 col-sm-3 btn btn-primary" onclick="prosesTolakan(2)">
                                Dipenuhi Sebagian
                            </button>
                            <button class="offset-1 col-sm-3 btn btn-primary" onclick="prosesTolakan(3)">
                                Dipenuhi Semua
                            </button>
                        </div>
                        <div class="row float-right">
                            <button class="btn btn-secondary" data-dismiss="modal">
                                BACK
                            </button>
                        </div>
                    </div>
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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover {
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang {
            position: absolute;
            bottom: 10px;
            right: 3vh;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active {
            box-shadow: none !important;
            outline: 0px !important;
        }

        .btn-lov-plu {
            position: absolute;
            bottom: 10px;
            right: 2vh;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active {
            box-shadow: none !important;
            outline: 0px !important;
        }

        .modal thead tr th {
            vertical-align: middle;
        }

        .selected {
            background-color: lightgrey !important;
        }
    </style>

    <script>
        var cla_kodeomi;
        var cla_nopb;
        var cla_tglpb;
        var cla_sisacl;
        var cla_nilaipb;
        $(document).ready(function () {
            $('#tgltop').datepicker({
                "dateFormat": "dd/mm/yy",
            });
            getLovKodeOMI('');
            getDataMasterKreditLimitOMI();
            getMonitoringDataPBTolakan();
        });

        function reset() {
            getDataMasterKreditLimitOMI();
            $('#kodeomi').val('');
            $('#namatokoomi').val('');
            $('#kodecustomer').val('');
            $('#proxyregular').prop('checked', false);
            $('#proxyalokasi').prop('checked', false);
            $('#omitertentu').prop('checked', false);
            $('#nilaikreditlimit').val('');
            $('#top').val('');
            $('#tgltop').val('');
            $('#username-log-non-top').val('');
            $('#password-log-non-top').val('');
        }

        $("#kodeomi").on('keypress', function (e) {
            if (e.which == 13) {
                if ($('#kodeomi').val() != '') {
                    getDataOMI();
                }
            }
        })

        $("input[name='kodeproxy']").on('change', function () {
            $("#tgltop").prop('disabled', false);
            $("#top").prop('disabled', false);
            if ($("input[name='kodeproxy']:checked").val() == '1') {
                $("#tgltop").prop('disabled', true);
                $("#tgltop").val('');
            } else if ($("input[name='kodeproxy']:checked").val() == '2') {
                $("#top").prop('disabled', true);
                $("#top").val('');
            }
            if ($('#kodeomi').val() != '' && $('#namatokoomi').val() != '' && $('#kodecustomer').val() != '') {
                getDataTop();
            }
        })

        function getLovKodeOMI() {
            if ($.fn.DataTable.isDataTable('#table_lov_kode_omi')) {
                $('#table_lov_kode_omi').DataTable().destroy();
            }
            table_lov_kode_omi = $('#table_lov_kode_omi').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-lov-kode-omi',
                },
                "columns": [
                    {data: 'tko_kodeomi'},
                    {data: 'tko_namaomi'},
                    {data: 'tko_kodecustomer'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-kode-omi').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    // $('.btn-lov-kode-omi').prop('disabled', false).html('').append('<i class="fas fa-question"></i>');

                    $(document).on('click', '.row-lov-kode-omi', function (e) {
                        reset();
                        $('#kodeomi').val($(this).find('td:eq(0)').html());
                        $('#namatokoomi').val($(this).find('td:eq(1)').html());
                        $('#kodecustomer').val($(this).find('td:eq(2)').html());
                        getDataOMI();
                        $('#m_lov_kode_omi').modal('hide');
                    });
                }
            });

            // $('#table_lov_nodoc_filter input').val().focus();

            // $('#table_lov_nodoc_filter input').off().on('keypress', function (e) {
            //     if (e.which == 13) {
            //         tableLovNodoc.destroy();
            //         getLovNodoc($(this).val().toUpperCase());
            //     }
            // });
        }

        function getDataMasterKreditLimitOMI() {
            if ($.fn.DataTable.isDataTable('#table-master-kredit-limit-omi')) {
                $('#table-master-kredit-limit-omi').DataTable().destroy();
            }
            table_data_master_kredit_limit_omi = $('#table-master-kredit-limit-omi').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-data-master-kredit-limit-omi',
                    data: {}
                },
                "columns": [
                    {data: 'mcl_kodeomi'},
                    {data: 'tko_namaomi'},
                    {data: 'mcl_kodemember'},
                    {data: 'mcl_nontop'},
                    {data: 'mcl_kodeproxy'},
                    {data: 'mcl_maxnilaicl'},
                    {data: 'mcl_top'},
                    {data: 'mcl_tgltop'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                },
                "columnDefs": [
                    {
                        targets: [5,6],
                        className: 'text-right',
                        render: function (data, type, row) {
                            return convertToRupiah2(data)
                        }
                    },
                    {
                        targets: [7],
                        render: function (data, type, row) {
                            return formatDate(data)
                        }
                    }
                ],
                "order": [],
                "initComplete": function () {
                }
            });
        }

        function getDataOMI() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current().'/get-data-omi' }}',
                type: 'post',
                data: {
                    kodeomi: $('#kodeomi').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {

                    $('#modal-loader').modal('hide');
                    $('#namatokoomi').val(result.data.tko_namaomi);
                    $('#kodecustomer').val(result.data.tko_kodecustomer);
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

        function getDataTop() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current().'/get-data-top' }}',
                type: 'post',
                data: {
                    kodeomi: $('#kodeomi').val(),
                    kodeproxy: $("input[name='kodeproxy']:checked").val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    if (result != 'no data') {
                        $('#nilaikreditlimit').val(result.data.mcl_maxnilaicl);
                        $('#tgltop').datepicker('setDate', new Date(result.data.mcl_tgltop.substring(0, 10).replace('-', '/')));

                    }
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

        $("#top").on('keypress', function (e) {
            if (e.which == 13) {
                if ($("input[name='kodeproxy']:checked").val() == '1') {
                    if ($("#top").val() != '') {
                        if ($("#top").val() < 1 || $("#top").val() > 999) {
                            swal('Info', 'Untuk Proxy Regular, tidak boleh <= 0 !!', 'info');
                            $("#top").val('');
                            $("#top").select();
                        }
                    }

                    if ($("#top").val() == '') {
                        $("#top").val(7);
                        swal('Info', 'Untuk Proxy Regular, default TOP 7 hari', 'info');
                    }
                } else {
                    $("#top").val('');
                }
            }
        })

        $("#tgltop").on('keypress', function (e) {
            if (e.which == 13) {
                if ($("input[name='kodeproxy']:checked").val() == '2') {
                    if ($("#tgltop").val() == '') {
                        swal('Warning', 'Untuk Proxy Alokasi, Tgl TOP harus diinput !!', 'warning');
                    }
                } else {
                    $("#tgltop").val('');
                }
            }
        })


        function simpan() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current().'/simpan' }}',
                type: 'post',
                data: {
                    kodeomi: $('#kodeomi').val(),
                    kodeproxy: $("input[name='kodeproxy']:checked").val(),
                    nilaikreditlimit: $('#nilaikreditlimit').val(),
                    top: $('#top').val(),
                    nontop: $('#omitertentu:checked').val(),
                    tgltop: $('#tgltop').val(),
                    kodecustomer: $('#kodecustomer').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    if (result.status == 'action') {
                        $('#m_log_nontop').modal('show');
                    } else if (result.status == 'success') {
                        reset();
                        swal(result.status, result.message, result.status);
                    } else {
                        swal(result.status, result.message, result.status);
                    }


                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

        function submitLogNonTop() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current().'/submit-log-non-top' }}',
                type: 'post',
                data: {
                    kodeomi: $('#kodeomi').val(),
                    kodeproxy: $("input[name='kodeproxy']:checked").val(),
                    nilaikreditlimit: $('#nilaikreditlimit').val(),
                    top: $('#top').val(),
                    nontop: $('#omitertentu:checked').val(),
                    tgltop: $('#tgltop').val(),
                    kodecustomer: $('#kodecustomer').val(),
                    username: $('#username-log-non-top').val().toUpperCase(),
                    password: $('#password-log-non-top').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    if (result.message) {
                        reset();
                        $('#m_log_nontop').modal('hide');

                        swal(result.status, result.message, result.status);
                    }

                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

        function getMonitoringDataPBTolakan() {
            if ($.fn.DataTable.isDataTable('#table-monitoring-data-pb-tolakan')) {
                $('#table-monitoring-data-pb-tolakan').DataTable().destroy();
            }
            table_monitoring_data_pb_tolakan = $('#table-monitoring-data-pb-tolakan').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-monitoring-data-pb-tolakan',
                    data: {}
                },
                "columns": [
                    {data: 'cla_kodeomi'},
                    {data: 'cla_nopb'},
                    {data: 'cla_tglpb'},
                    {data: 'cla_nilaipb'},
                    {data: 'cla_nilaicl'},
                    {data: 'cla_sisacl'},
                    {data: 'cla_nilaiovercl'},
                    {data: 'cla_nilaioverdue'},
                    {data: 'cla_tgljtoverdue'},
                    {data: 'cla_keterangan'},
                    {data: ''}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "columnDefs": [
                    {
                        targets: [2, 8],
                        render: function (data, type, row) {
                            return formatDate(data)
                        }
                    }, {
                        targets: [10],
                        render: function (data, type, row, meta) {
                            return `<button class="offset-1 btn btn-primary btn-proses" cla_kodeomi=` + row.cla_kodeomi + ` cla_nopb=` + row.cla_nopb + ` cla_tglpb=` + row.cla_tglpb + ` cla_sisacl=` + row.cla_sisacl + ` cla_nilaipb=` + row.cla_nilaipb + `>
                                    Proses
                                </button>`;
                        }
                    }],
                "createdRow": function (row, data, dataIndex) {
                    $(row).attr('cla_kodeomi', data.cla_kodeomi);
                    $(row).attr('cla_namaomi', data.cla_namaomi);

                    if (data.cla_jenispb == 1) {
                        $(row).attr('cla_jenispb', 'EDP Cabang');
                    } else if (data.cla_jenispb == 2) {
                        $(row).attr('cla_jenispb', 'Alokasi');
                    } else if (data.cla_jenispb == 3) {
                        $(row).attr('cla_jenispb', 'Khusus');
                    } else {
                        $(row).attr('cla_jenispb', 'Regular Toko');
                    }

                    $(row).addClass('modalRow row-tolakan');
                },
                "order": [],
                "initComplete": function () {
                }
            });
        }

        function submitLog() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current().'/submit-log' }}',
                type: 'post',
                data: {
                    username: $('#username-log').val().toUpperCase(),
                    password: $('#password-log').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    if (result.status != 'error') {
                        $('#m_log').modal('hide');
                        $('#m_proses_tolakan').modal('show');
                    } else {
                        $('#username-log').val('');
                        $('#password-log').val('');
                        swal(result.status, result.message, result.status);
                    }

                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

        $(document).on('click', '.btn-proses', function (e) {
            cla_kodeomi = $(this).attr('cla_kodeomi');
            cla_nopb = $(this).attr('cla_nopb');
            cla_tglpb = $(this).attr('cla_tglpb');
            cla_sisacl = $(this).attr('cla_sisacl');
            cla_nilaipb = $(this).attr('cla_nilaipb');
            $('#m_log').modal('show');

        })

        function prosesTolakan(val) {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current().'/proses-tolakan' }}',
                type: 'post',
                data: {
                    value: val,
                    cla_kodeomi: cla_kodeomi,
                    cla_nopb: cla_nopb,
                    cla_tglpb: cla_tglpb,
                    cla_sisacl: cla_sisacl,
                    cla_nilaipb: cla_nilaipb,
                },
                beforeSend: function () {
                    $('#m_proses_tolakan').modal('hide');
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    getMonitoringDataPBTolakan();
                    swal(result.status, result.message, result.status);
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

        $(document).on('click', '.row-tolakan', function (e) {
            kodeOMI = $(this).attr('cla_kodeomi');
            namaOMI = $(this).attr('cla_namaomi');
            jenisPB = $(this).attr('cla_jenispb');

            $('#kodeomi2').val(kodeOMI);
            $('#namaomi').val(namaOMI);
            $('#jenispb').val(jenisPB);
        });
    </script>

@endsection
