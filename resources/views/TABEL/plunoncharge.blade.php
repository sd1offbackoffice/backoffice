@extends('navbar')

@section('title','TABEL | PLU TIDAK KENA CHARGE CREDIT CARD')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">Tabel PLU Yang Tidak Kena Charge Credit Card</legend>
                            <div class="card-body py-0">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">PLU</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input type="text" class="form-control text-left" id="plu">
                                        <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovPLU()">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label  text-right pl-0 pr-0">Deskirpsi</label>
                                    <div class="col-sm-8 pr-0">
                                        <input type="text" class="form-control text-left" id="desk" disabled>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="satuan" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm"></div>
                                    <button class="col-sm-2 btn btn-primary mr-1" id="btn_proses" onclick="addPLU()">ADD PLU</button>
                                    <button class="col-sm-2 btn btn-primary" id="btn_proses" onclick="print()">PRINT</button>
                                    <div class="col-sm-2"></div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <div class="card-body pt-0 pb-0">
                                <div class="row form-group mb-0 ml-1 mr-3">
                                    <label for="prdcd" class="col-sm-1 text-center col-form-label pr-1 pl-0"></label>
                                    <label for="prdcd" class="col-sm-2 text-center pl-0 pr-0 col-form-label">PLU</label>
                                    <label for="prdcd" class="col-sm-7 text-center pl-0 pr-0 col-form-label">Deskripsi</label>
                                    <label for="prdcd" class="col-sm-2 text-center pl-0 pr-0 col-form-label">Satuan</label>
                                </div>
                                <div class="scrollable-field mb-2" id="detail">
                                    @for($i=0;$i<10;$i++)
                                        <div class="row form-group m-1 mb-2">
                                            <div class="col-sm-1 pr-1 pl-1 text-center">
                                                <button class="btn btn-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="col-sm-2 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm-7 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm-2 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_plu">
                                    <thead class="thColor">
                                    <tr>
                                        <th>PLU</th>
                                        <th>Deskripsi</th>
                                        <th>Satuan</th>
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
            overflow-y: hidden;
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

        .row_lov:hover{
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

        .clicked, .row-detail:hover{
            background-color: grey !important;
            color: white;
        }

        .scrollable-field{
            max-height: 460px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>

    <script>
        $(document).ready(function(){
            getData();
        });

        function getData(){
            $.ajax({
                url: '{{ url()->current() }}/get-data',
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

                    $('#detail').html('');
                    for(i=0;i<response.length;i++){
                        fillDetail(response[i],i);
                    }
                    for(i=response.length;i<10;i++){
                        generateDetailDummy();
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

        function fillDetail(data, row){
            $('#detail').append(
                `<div id="row-${row}" class="row form-group m-1 mb-2">
                    <div class="col-sm-1 pr-1 pl-1 text-center">
                        <button class="btn btn-danger" onclick="deletePLU('${data.plu}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled value="${ data.plu }">
                    </div>
                    <div class="col-sm-7 pr-1 pl-1">
                        <input type="text" class="form-control text-left" disabled value="${ data.desk }">
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled value="${ data.satuan }">
                    </div>
                </div>`
            );
        }

        function generateDetailDummy(){
            $('#detail').append(
                `<div class="row form-group m-1 mb-2">
                    <div class="col-sm-1 pr-1 pl-1 text-center">
                        <button class="btn btn-danger" disabled>
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm-7 pr-1 pl-1">
                        <input type="text" class="form-control text-right" disabled>
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-right" disabled>
                    </div>
                </div>`
            );
        }

        function showLovPLU(){
            $('#m_plu').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_plu')){
                getLovPLU();
            }
        }

        function getLovPLU() {
            $('#table_plu').DataTable({
                "ajax": '{{ url()->current().'/get-lov-plu' }}',
                "columns": [
                    {data: 'plu'},
                    {data: 'desk'},
                    {data: 'satuan'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-center');
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).find(':eq(2)').addClass('text-center');
                    $(row).addClass('row-plu').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(document).on('click', '.row-plu', function (e) {
                        $('#plu').val($(this).find('td:eq(0)').html());
                        $('#desk').val($(this).find('td:eq(1)').html());
                        $('#satuan').val($(this).find('td:eq(2)').html());

                        $('#m_plu').modal('hide');

                        $('#btn_add').focus();
                    });
                }
            });
        }

        $('#plu').on('keypress',function(event){
            if(event.which == 13){
                if($('#plu').val().substr(0,1) == '#'){
                    plu = $('#plu').val().substr(1);
                }
                else{
                    plu = ('0000000' + $('#plu').val()).substr(-7);
                    $('#plu').val(plu);
                }

                getPLUDetail(plu);
            }
        });

        function getPLUDetail(plu){
            $.ajax({
                url: '{{ url()->current() }}/get-plu-detail',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    plu: plu
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('#desk').val(response.desk);
                    $('#satuan').val(response.satuan);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#plu').select();
                    });
                }
            });
        }

        function addPLU(){
            $.ajax({
                url: '{{ url()->current() }}/add-plu',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    plu: $('#plu').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.title,
                        icon: 'success'
                    }).then(getData());
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

        function deletePLU(plu){
            $.ajax({
                url: '{{ url()->current() }}/delete-plu',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    plu: plu
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.title,
                        icon: 'success'
                    }).then(getData());
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

        function print(){
            swal({
                title: 'Unable to run report!',
                icon: 'error'
            });
        }
    </script>
@endsection
