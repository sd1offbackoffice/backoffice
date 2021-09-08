@extends('navbar')
@section('title','Entry Group Rak')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="offset-1 col-sm-11 row">
                <fieldset class="card border-secondary col-sm-4" id="data-field">
                    <legend class="w-auto ml-5">Header Group rak</legend>
                    <div class="card-body">
                        <table class="table table bordered table-sm mt-3" id="table_data_header">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th>Group</th>
                                <th>Nama Group</th>
                                <th>Flag</th>
                            </tr>
                            </thead>
                            <tbody id="tbody-data-header">
                            </tbody>
                        </table>
                    </div>
                </fieldset>
                <fieldset class="card border-secondary col-sm-3" id="data-field">
                    <legend class="w-auto ml-5">Detail Group</legend>
                    <div class="card-body">
                        <table class="table table bordered table-sm mt-3" id="table_data_detail">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th>Kode Rak</th>
                                <th>Sub Rak</th>
                            </tr>
                            </thead>
                            <tbody id="tbody-data-detail">
                            </tbody>
                        </table>
                    </div>
                </fieldset>
                <div class="col-sm-5">
                    <fieldset class="card border-secondary" id="data-field">
                        <legend class="w-auto ml-5"></legend>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-4 col-form-label text-sm-right">Kode Group Rak :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="kgr-1" placeholder="..." value="" maxlength="5">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label text-sm-right">Nama Group Rak:</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ngr-1" value="">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 col-form-label text-sm-right">Flag Cetak Ke Printer:</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="fcp-1" value="" maxlength="1">
                                </div>
                                <label class="col-sm-6 col-form-label text-sm-left">H - HELD/ D - DPD/ Y -
                                    PRINTER</label>
                            </div>
                            <div class="row">
                                <div class="offset-4 col-sm-4">
                                    <button class="btn btn-primary" onclick="simpan1()">SAVE</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <br>
                    <fieldset class="card border-secondary" id="data-field">
                        <legend class="w-auto ml-5"></legend>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-4 col-form-label text-sm-right">Kode Group Rak :</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="kgr-2" placeholder="..." value=""
                                           readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 col-form-label text-sm-right">Kode Rak:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="kr-2" value="">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 col-form-label text-sm-right">Sub Rak:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" id="sr-2" value="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="offset-4 col-sm-2">
                                    <button class="btn btn-primary" onclick="simpan2()">SAVE</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-danger" onclick="hapus2()">Delete</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>

        </div>
    </div>

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        table.dataTable tbody tr:hover {
            cursor: pointer;
            background-color: gray;
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
    </style>

    <script>
        var arrData = [];

        $(document).ready(function () {
            $('#tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
            getDataHeader();
        });

        function getDataHeader() {
            if ($.fn.DataTable.isDataTable('#table_data_header')) {
                $('#table_data_header').DataTable().clear().destroy();
            }
            $('#table_data_header').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-data-header',
                },
                "columns": [
                    {data: 'grr_grouprak'},
                    {data: 'grr_namagroup'},
                    {data: 'grr_flagcetakan'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-hdr row-lov text-right').css({'cursor': 'pointer'});
                    $(row).find('td:eq(0)').addClass('text-center');
                },
                "order": [],
                "initComplete": function (data) {
                    grouprak = $('#tbody-data-header').find('tr:eq(0)').find('td:eq(0)').text();
                    let namagrouprak = $('#tbody-data-header').find('tr:eq(0)').find('td:eq(1)').text();
                    let flag = $('#tbody-data-header').find('tr:eq(0)').find('td:eq(2)').text();

                    $('#kgr-1').val(grouprak);
                    $('#ngr-1').val(namagrouprak);
                    $('#fcp-1').val(flag);
                    getDataDetail(grouprak);
                }
            });
        }

        $(document).on('click', '.row-hdr', function () {
            var currentButton = $(this);
            let grouprak = currentButton.children().first().text();
            let namagrouprak = currentButton.find('td:eq(1)').text();
            let flag = currentButton.find('td:eq(2)').text();

            $('#kgr-1').val(grouprak);
            $('#ngr-1').val(namagrouprak);
            $('#fcp-1').val(flag);
            getDataDetail(grouprak);
        });

        function getDataDetail(grouprak) {
            console.log(grouprak)
            if ($.fn.DataTable.isDataTable('#table_data_detail')) {
                $('#table_data_detail').DataTable().clear().destroy();
            }
            $('#table_data_detail').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-data-detail',
                    data: {
                        "search": grouprak
                    }
                },
                "columns": [
                    {data: 'grr_koderak'},
                    {data: 'grr_subrak'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-dtl row-lov text-right').css({'cursor': 'pointer'});
                    $(row).find('td:eq(0)').addClass('text-center');
                },
                "order": [],
                "initComplete": function (data) {
                    koderak = $('#tbody-data-detail').find('tr:eq(0)').find('td:eq(0)').text();
                    subrak = $('#tbody-data-detail').find('tr:eq(0)').find('td:eq(1)').text();
                    $('#kgr-2').val(grouprak);
                    $('#kr-2').val(koderak);
                    $('#sr-2').val(subrak);
                }
            });
        }
        $(document).on('click', '.row-dtl', function () {
            var currentButton = $(this);
            let koderak = currentButton.find('td:eq(0)').text();
            let subrak = currentButton.find('td:eq(1)').text();

            $('#kr-2').val(koderak);
            $('#sr-2').val(subrak);
        });

        function simpan1() {
            data = null;
            data = {
                grouprak: $('#kgr-1').val(),
                namarak: $('#ngr-1').val(),
                flag: $('#fcp-1').val(),
                koderak: $('#kr-2').val(),
                subrak: $('#sr-2').val()
            }
            console.log(data.grouprak);
            if(data.grouprak == '' ||data.namarak == '' ||data.flag == '' ||data.koderak == '' ||data.subrak == '' ){
                swal('Error','Data tidak Lengkap!','error');
                return false;
            }
            if(data.flag != 'H' && data.flag != 'D' && data.flag != 'Y' ){
                swal('Error','Data Flag Salah! [ H / D / Y ]','error');
                return false;
            }
            swal({
                title: 'Simpan?',
                icon: 'info',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                if (confirm) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/simpan-header',
                        type: 'post',
                        data: {
                            data: data,
                        }, beforeSend: () => {
                            $('#modal-loader').modal('show');
                        },
                        success: function (result) {
                            console.log(result);
                            $('#modal-loader').modal('hide');
                            getDataHeader();
                            getDataDetail(grouprak);
                            $('#header').find('tr:eq(0)').each(function( index ) {
                               if($(this).find('td:eq(0)').text() == data.grouprak ){
                                   $(this).click();
                                }
                            });
                            swal({
                                title: result.message,
                                icon: result.status
                            });

                        }, error: function (err) {
                            $('#modal-loader').modal('hide');
                            console.log(err.responseJSON.message.substr(0, 100));
                            alertError(err.statusText, err.responseJSON.message)
                        }
                    })
                }
            });
        }
        function simpan2() {
            data = {
                grouprak: $('#kgr-2').val(),
                namarak: $('#ngr-1').val(),
                flag: $('#fcp-1').val(),
                koderak: $('#kr-2').val(),
                subrak: $('#sr-2').val()
            }

            if(data.grouprak == '' ||data.namarak == '' ||data.flag == '' ||data.koderak == '' ||data.subrak == '' ){
                swal('Error','Data tidak Lengkap!','error');
                return false;
            }
            swal({
                title: 'Simpan Data Detail?',
                icon: 'info',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                if (confirm) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/simpan-detail',
                        type: 'post',
                        data: {
                            data: data,
                        }, beforeSend: () => {
                            $('#modal-loader').modal('show');
                        },
                        success: function (result) {
                            console.log(result);
                            $('#modal-loader').modal('hide');
                            getDataHeader();
                            getDataDetail($('#kgr-2').val());
                            swal({
                                title: result.message,
                                icon: result.status
                            });

                        }, error: function (err) {
                            $('#modal-loader').modal('hide');
                            console.log(err.responseJSON.message.substr(0, 100));
                            alertError(err.statusText, err.responseJSON.message)
                        }
                    })
                }
            });
        }
        function hapus2() {
            data = {
                grouprak: $('#kgr-2').val(),
                koderak: $('#kr-2').val(),
                subrak: $('#sr-2').val()
            }
            if(data.grouprak == '' ||data.koderak == '' ||data.subrak == '' ){
                swal('Error','Data tidak Lengkap!','error');
                return false;
            }
            swal({
                title: 'Hapus Data Detail?',
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                if (confirm) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/hapus-detail',
                        type: 'post',
                        data: {
                            data: data,
                        }, beforeSend: () => {
                            $('#modal-loader').modal('show');
                        },
                        success: function (result) {
                            console.log(result);
                            $('#modal-loader').modal('hide');
                            getDataDetail($('#kgr-2').val());
                            swal({
                                title: result.message,
                                icon: result.status
                            });

                        }, error: function (err) {
                            $('#modal-loader').modal('hide');
                            console.log(err.responseJSON.message.substr(0, 100));
                            alertError(err.statusText, err.responseJSON.message)
                        }
                    })
                }
            });

        }
    </script>

@endsection
