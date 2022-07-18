@extends('navbar')

@section('title','Master | Ekspedisi')

@section('content')
    <div class="col">
        <fieldset class="card border-secondary">
            <legend class="w-auto ml-3">MASTER EKSPEDISI</legend>
            <div class="row">
                <div class="col">
                    <div class="card-body" id="detailField">
                        <table class="table table bordered table-sm mt-3" id="table_expedition">
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
                                <tr onclick="getExpeditionDetail(this,'{{ $e->xpd_kodeekspedisi }}')">
                                    <td>{{ $e->xpd_kodeekspedisi }}</td>
                                    <td>{{ $e->xpd_namaekspedisi }}</td>
                                    <td>{{ $e->xpd_jeniskontainer }}</td>
                                    <td>{{ $e->xpd_tonase }}</td>
                                    <td>{{ $e->xpd_kubikase }}</td>
                                    <td></td>
                                    <td>{{ $e->xpd_alamat }}</td>
                                    <td>{{ $e->xpd_email }}</td>
                                    <td>{{ $e->xpd_telp }}</td>
                                    <td>{{ $e->xpd_fax }}</td>
                                    <td>{{ $e->xpd_hp1 }}</td>
                                    <td>{{ $e->xpd_pic1 }}</td>
                                    <td>{{ $e->xpd_hp2 }}</td>
                                    <td>{{ $e->xpd_pic2 }}</td>
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
                        <table class="table table bordered table-sm mt-3" id="table_expeditionDetail">
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
                        <button class="mt-3 btn btn-primary" onclick="updateFromIGRCRM()">UPDATE</button>
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

        #table_expedition tbody tr:hover {
            cursor: pointer;
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

            $('#table_expedition tbody tr:eq(0)').click();
        });

        function getExpeditionDetail(event,code) {
            $('#table_expedition tbody tr').css('background-color','white').css('color','black');

            $(event).css('background-color','gray');
            $(event).css('color','white');



            if ($.fn.DataTable.isDataTable('#table_expeditionDetail')) {
                $('#table_expeditionDetail').DataTable().clear().destroy();
            }

            $('#table_expeditionDetail').DataTable({
                "ajax": {
                    url: '{{ route('expedition-get-expedition-detail') }}',
                    data: {
                        "code": code
                    }
                },
                "columns": [
                    {data: 'tujuan'},
                    {data: 'biaya'},
                    {data: 'lamakirim'}

                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    // $(row).addClass('row-dtl row-lov text-right').css({'cursor': 'pointer'});
                    // $(row).find('td:eq(0)').addClass('text-center');
                },
                "order": [],
                "initComplete": function (data) {
                    // koderak = $('#tbody-data-detail').find('tr:eq(0)').find('td:eq(0)').text();
                    // subrak = $('#tbody-data-detail').find('tr:eq(0)').find('td:eq(1)').text();
                    // $('#kgr-2').val(grouprak);
                    // $('#kr-2').val(koderak);
                    // $('#sr-2').val(subrak);
                }
            });
        }

        function updateFromIGRCRM(){
            swal({
                title: 'Update data dari IGRCRM?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((ok) => {
                if(ok){
                    $.ajax({
                        url: '{{ route('expedition-update-from-igrcrm') }}',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {

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
                                location.reload();
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: error.responseJSON.message,
                                text: error.responseJSON.error,
                                icon: 'error',
                            }).then(() => {

                            });
                        }
                    });
                }
            });
        }
    </script>

@endsection
