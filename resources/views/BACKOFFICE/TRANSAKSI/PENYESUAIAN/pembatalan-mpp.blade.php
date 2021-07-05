@extends('navbar')

@section('title','PENYESUAIAN | PEMBATALAN MPP')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <fieldset class="card border-secondary m-2">
                        <div class="card-body">
                            <div class="row form-group">
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">No MPP :</label>
                                <div class="col-sm-3 buttonInside">
                                    <input type="text" class="form-control text-left" id="nompp" disabled>
                                    <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov" disabled>
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="col btn btn-danger" onclick="batalMPP()">Batal MPP</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary m-2">
                        <div class="card-body">
                            <table id="table_data" class="table table-sm table-striped table-bordered mb-3 text-left">
                                <thead class="text-center">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Barang</th>
                                    <th>Kemasan</th>
                                    <th>Kuantum</th>
                                    <th>HPP</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm table-bordered mb-0" id="table_lov">
                                    <thead class="theadDataTables">
                                    <tr class="text-center">
                                        <th>No MPP</th>
                                        <th>Tanggal</th>
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

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
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
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov{
            position:absolute;
            right: 20px;
            top: 4px;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .row-lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 430px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        #table_data td{
            vertical-align: middle;
            white-space: nowrap;
        }

    </style>

    <script>
        var nompp;
        var lov;

        $(document).ready(function(){
            $('#table_data').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                },
                "order": []
            });

            lov = $('#table_lov').DataTable({
                "ajax": '{{ url('/bo/transaksi/penyesuaian/pembatalanmpp/get-data-lov') }}',
                "columns": [
                    {data: 'msth_nodoc', name: 'msth_nodoc'},
                    {data: 'msth_tgldoc', name: 'msth_tgldoc'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov text-center').css({'cursor': 'pointer'});
                    $('#btn_lov').prop('disabled', false);
                },
                "order" : []
            });
        });

        $(document).on('click', '.row-lov', function (e) {
            nompp = $(e.target).parent().find('td').html();
            tglmpp = $(e.target).parent().find('td').next().html();
            $('#nompp').val(nompp);
            $('#tglmpp').val(tglmpp);
            $('#m_lov').modal('hide');

            getData(nompp);
        });

        function getData(nompp){
            $.ajax({
                type: "GET",
                url: "{{ url('/bo/transaksi/penyesuaian/pembatalanmpp/get-data') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {nompp: nompp},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if ($.fn.DataTable.isDataTable('#table_data')) {
                        $('#table_data').DataTable().destroy();
                        $("#table_data tbody [role='row']").remove();
                    }

                    total = 0;

                    for(i=0;i<response.length;i++){
                        html = `<tr>
                                    <td>${response[i].mstd_prdcd}</td>
                                    <td>${response[i].prd_deskripsipanjang.length > 55 ? response[i].prd_deskripsipanjang.substr(0,55) +  '...' : response[i].prd_deskripsipanjang}</td>
                                    <td>${response[i].prd_unit}</td>
                                    <td class="text-right">${response[i].mstd_qty}</td>
                                    <td class="text-right">${convertToRupiah(response[i].mstd_hrgsatuan)}</td>
                                    <td class="text-right">${convertToRupiah2(response[i].mstd_gross)}</td>
                                </tr>`;

                        $('#table_data tbody').append(html);
                    }

                    $('#table_data').DataTable({
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                        "createdRow": function (row, data, dataIndex) {
                        },
                        "order": []
                    });
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: error.responseJSON.exception,
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {
                        $('#table_data tbody tr').remove();
                    });
                }
            });
        }

        function batalMPP(){
            swal({
                title: 'Apakah anda yakin ingin membatalkan MPP ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/bo/transaksi/penyesuaian/pembatalanmpp/batal') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {nompp: nompp},
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            $('#table_data tbody tr').remove();
                            $('#nompp').val('');
                            lov.ajax.reload();

                            swal({
                                title: response.title,
                                text: response.message,
                                icon: response.status
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            // handle error
                            swal({
                                title: error.responseJSON.exception,
                                text: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {
                                $('#table_data tbody tr').remove();
                            });
                        }
                    });
                }
            });
        }
    </script>

@endsection
