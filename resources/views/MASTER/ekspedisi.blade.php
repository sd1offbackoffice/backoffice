@extends('navbar')
@section('title','MASTER | MASTER EKSPEDISI')
@section('content')
    <div class="col">
        <fieldset class="card border-secondary">
            <legend class="w-auto ml-3">MASTER EKSPEDISI</legend>
            <div class="row">
                <div class="col">
                    <div class="card-body" id="detailField">
                        <table class="table table bordered table-sm mt-3" id="table_data_header">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th>Kode Ekspedisi</th>
                                <th>Nama Ekspedisi</th>
                                <th>Jenis Kontainer</th>
                                <th>Tonase</th>
                                <th>Kubikase</th>
                                <th>>></th>
                                <th>Alamat</th>
                                <th>Email</th>
                                <th>Telp</th>
                                <th>Fax</th>
                                <th>HP1</th>
                                <th>PIC1</th>
                                <th>HP2</th>
                                <th>PIC2</th>
                            </tr>
                            </thead>
                            <tbody id="tbody-data-header">
                            @foreach($ekspedisi as $e)
                                <tr>
                                    <td>{{ $e->eks_nama }}</td>
                                    <td>{{ $e->eks_nama }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="card-body" id="detailField">
                        <table class="table table bordered table-sm mt-3" id="table_data_header">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th>Cabang Tujuan</th>
                                <th>Biaya</th>
                                <th>Lama Pengiriman</th>
                            </tr>
                            </thead>
                            <tbody id="tbody-data-header">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card-body text-center" id="detailField">
                        <button class="mt-3 btn btn-primary">UPLOAD</button>
                    </div>
                </div>
            </div>
        </fieldset>
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

        @if(\Illuminate\Support\Facades\Session::get('usid') != 'DVX')
            swal({
                title: 'Under Development',
                icon: 'warning',
            }).then((ok) => {
                window.location.href = '/BackOffice/public/';
            });
        @endif

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
            $('#table_data_header').DataTable();
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
