@extends('navbar')

@section('title','BO | ADJUSTMENT STOCK CMO')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <fieldset class="card border-secondary m-1">
                        <legend class="w-auto ml-3">Berita Acara Adjustment untuk item Commit Order</legend>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">Nomor BA</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="noBA" autocomplete="off">
                                    <button id="btn_lov_ba" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_ba" disabled>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-1 pr-0 text-right col-form-label">Tgl BA</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tglBA" disabled>
                                </div>
                                <div class="col"></div>
                                <label class="col-sm-1 pr-0 text-right col-form-label">Tanggal</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tgl1" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-1 pr-0 text-right col-form-label">Tgl Adj</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tglAdj" disabled>
                                </div>
                                <label class="col-sm-1 pr-0 text-right col-form-label">User Adj</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="userAdj" disabled>
                                </div>
                                <div class="col"></div>
                                <label class="col-sm-1 pr-0 text-right col-form-label">s/d</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tgl2" disabled>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col"></div>
                                <div class="col-sm-2">
                                    <button class="col btn btn-primary form-control">PROSES BA</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="col btn btn-primary form-control">BATAL BA</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="col btn btn-primary form-control">PROSES ADJ</button>
                                </div>
                                <div class="col-sm-2">
                                    <button class="col btn btn-primary form-control">LISTING ADJ</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary ml-2 mr-2 mt-0">
                        <legend class="w-auto ml-3">Item Commit Order</legend>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                        <thead class="thColor">
                                        <tr>
                                            <th width=""></th>
                                            <th width="">PLU IGR</th>
                                            <th width="">PLU IDM</th>
                                            <th width="">Qty Stock Virtual</th>
                                            <th width="">Qty BA</th>
                                            <th width="">Qty Adj</th>
                                            <th width="">Keterangan</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="card-body">
                        <div class="row">
                            <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">Deskripsi</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="u_deskripsi" disabled>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-right" id="u_qty1" disabled>
                            </div>
                            <div class="col"></div>
                            <div class="col-sm-2">
                                <button class="col btn btn-primary form-control" onclick="addRow()">TAMBAH</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_ba" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_ba">
                                    <thead>
                                    <tr>
                                        <th>Nomor BA</th>
                                        <th>Tanggal BA</th>
                                        <th>Tanggal Adj</th>
                                        <th>User Adj</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_plu">
                                    <thead>
                                    <tr>
                                        <th>PLU IGR</th>
                                        <th>PLU IDM</th>
                                        <th>Deskripsi</th>
                                        <th>Unit</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang{
            position:absolute;
            bottom: 10px;
            right: 3vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .btn-lov-plu{
            position:absolute;
            bottom: 10px;
            right: 2vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .modal thead tr th{
            vertical-align: middle;
        }
    </style>

    <script>
        var currIndex = 0;
        var index = 0;

        $(document).ready(function(){
            tgltrn = $('#tgltrn').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            tabel = $('#table_daftar').DataTable({
                "scrollY": "40vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });

            getLovBA();
            getLovPLU();
        });

        function getLovBA(){
            lovtrn = $('#table_lov_ba').DataTable({
                "ajax": '{{ url()->current() }}/get-data-lov-ba',
                "columns": [
                    {data: 'noba'},
                    {data: 'tglba'},
                    {data: 'tgladj'},
                    {data: 'useradj'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-ba').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_ba').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-ba', function (e) {
                        $('#noBA').val($(this).find('td:eq(0)').html());
                        $('#tglBA').val($(this).find('td:eq(1)').html());
                        $('#tglAdj').val($(this).find('td:eq(2)').html());
                        $('#userAdj').val($(this).find('td:eq(3)').html());

                        $('#m_lov_ba').modal('hide');

                        getDataBA($(this).find('td:eq(0)').html());
                    });
                }
            });
        }

        function getLovPLU(){
            lovtrn = $('#table_lov_plu').DataTable({
                "ajax": '{{ url()->current() }}/get-data-lov-plu',
                "columns": [
                    {data: 'icm_pluigr'},
                    {data: 'prc_pluidm'},
                    {data: 'prd_deskripsipanjang'},
                    {data: 'unit'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-plu').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $(document).on('click', '.row-lov-plu', function (e) {
                        $('#row-'+currIndex).find('.pluigr').val($(this).find('td:eq(0)').html());

                        $('#m_lov_plu').modal('hide');
                    });
                }
            });
        }

        function getDataBA(noBA){
            if(noBA){
                $.ajax({
                    url: '{{ url()->current() }}/get-data-ba',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        noba: noBA
                    },
                    beforeSend: function(){
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                    },
                    error: function(error){
                        swal({
                            title: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {

                        });
                    }
                });
            }
            else{

            }
        }

        function addRow(){
            if ($.fn.DataTable.isDataTable('#table_daftar')) {
                $('#table_daftar').DataTable().destroy();
            }

            $('#table_daftar tbody').append(`
                <tr id="row-${index}">
                    <td>
                        <button onclick="deleteRow(${index})" class="col-sm btn btn-danger btn-delete">X</button>
                    </td>
                    <td>
                        <div class="buttonInside">
                            <input type="text" class="form-control pluigr" autocomplete="off" onkeypress="checkPLU(event, ${index})">
                            <button type="button" class="btn btn-primary btn-lov p-0" onclick="showLovPLU(${index})">
                                <i class="fas fa-question"></i>
                            </button>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control pluidm" autocomplete="off" disabled>
                    </td>
                    <td>
                        <input type="text" class="form-control qtysv" autocomplete="off" disabled>
                    </td>
                    <td>
                        <input type="text" class="form-control qtyba" autocomplete="off">
                    </td>
                    <td>
                        <input type="text" class="form-control qtyadj" autocomplete="off">
                    </td>
                    <td>
                        <input type="text" class="form-control keterangan" autocomplete="off">
                    </td>
                </tr>`);

            index++;

            $('#table_daftar').DataTable({
                "scrollY": "40vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });
        }

        function showLovPLU(i){
            currIndex = i;
            $('#m_lov_plu').modal('show');
        }

        function checkPLU(event, i){
            if(event.which == 13){
                $.ajax({
                    url: '{{ url()->current() }}/check-plu',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        plu: $('#row-'+i).find('.pluigr').val()
                    },
                    beforeSend: function(){
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        $('#row-'+i).find('.qtyba').select();
                    },
                    error: function(error){
                        swal({
                            title: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {

                        });
                    }
                });
            }
        }
    </script>

@endsection
