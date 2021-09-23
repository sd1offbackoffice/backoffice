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
                                <input type="text" class="form-control text-left" id="kodeomi">
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
                                <input class="form-check-input" type="radio" name="kodeproxy" id="proxyregular" value="1">
                                <label class="form-check-label" for="proxyregular">
                                    1 - Regular
                                </label>
                            </div>
                            <div class="form-check mt-2 ml-4">
                                <input class="form-check-input" type="radio" name="kodeproxy" id="proxyalokasi" value="2">
                                <label class="form-check-label" for="proxyalokasi">
                                    2 - Alokasi
                                </label>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">OMI Tertentu</label>
                            <div class="col-sm-2 m-2">
                                <input class="input-checkbox" id="omitertentu" type="checkbox">
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
                    <legend class="w-auto ml-3">Monitoring Data PB Tolakan</legend>
                    <div class="card-body pt-0">
                        <div class="row mb-1">

                            <table class="table table bordered table-sm mt-3" id="table-monitoring-data-pb-tolakan">
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
                        </div>
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

    <div class="modal fade" id="m_log" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Kode Pemakai</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="username">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Password</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="password">
                            </div>
                            <button class="offset-1 col-sm-3 btn btn-success" onclick="submitData()">
                                OK
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
            overflow-y: hidden;
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
        $(document).ready(function () {
            $('#tgltop').datepicker({
                "dateFormat": "dd/mm/yy",
            });
            getLovKodeOMI('');
            getDataMasterKreditLimitOMI();


        });
        $("#kodeomi").on('keypress',function (e) {
            if(e.which == 13) {
                if($('#kodeomi').val() != '' && $('#namatokoomi').val() != '' && $('#kodecustomer').val() != '') {
                    getDataOMI();
                }
            }
        })
        $("input[name='kodeproxy']").on('change',function () {
            $("#tgltop").prop('disabled',false);
            $("#top").prop('disabled',false);
            if($("input[name='kodeproxy']:checked").val() == '1'){
                $("#tgltop").prop('disabled',true);
                $("#tgltop").val('');
            }else if($("input[name='kodeproxy']:checked").val() == '2'){
                $("#top").prop('disabled',true);
                $("#top").val('');
            }
            if($('#kodeomi').val() != '' && $('#namatokoomi').val() != '' && $('#kodecustomer').val() != '') {
                getDataTop();
            }
        })
        function getLovKodeOMI(value) {
            if ($.fn.DataTable.isDataTable('#table_lov_kode_omi')) {
                $('#table_lov_kode_omi').DataTable().destroy();
            }
            table_lov_kode_omi = $('#table_lov_kode_omi').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-lov-kode-omi',
                    data: {
                        "search": value
                    }
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
                        $('#kodeomi').val($(this).find('td:eq(0)').html());
                        $('#namatokoomi').val($(this).find('td:eq(1)').html());
                        $('#kodecustomer').val($(this).find('td:eq(2)').html());

                        // getData($('#kodeomi').val());

                        $('#m_lov_kode_omi').modal('hide');
                    });
                }
            });

            $('#table_lov_nodoc_filter input').val(value).focus();

            $('#table_lov_nodoc_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    tableLovNodoc.destroy();
                    getLovNodoc($(this).val().toUpperCase());
                }
            });
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
                    console.log(result);
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
                    $('#nilaikreditlimit').val(result.data.mcl_maxnilaicl);
                    $('#top').val(result.data.mcl_tgltop);
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }




        function simpan() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current().'/simpan' }}',
                type: 'post',
                data: {
                    kodeomi: $('#kodeomi').val(),
                    kodeproxy: $('#kodeproxy').val(),
                    nilaikreditlimit: $('#nilaikreditlimit').val(),
                    top: $('#top').val(),
                    tgltop: $('#tgltop').val(),
                    kodecustomer: $('#kodecustomer').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    if(result.message){
                        swal(result.status, result.message, result.status);
                    }


                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }
    </script>

@endsection
