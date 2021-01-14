@extends('navbar')

@section('title','TRANSFER | PO')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3"></legend>
                    <fieldset class="card border-secondary m-4">
                        <div class="card-body">
                            <div class="row form-group">
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal :</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control tanggal" id="tanggal1" onchange="getData()">
                                </div>
                                <label class="pt-1">s/d</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control tanggal" id="tanggal2" onchange="getData()">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary m-4">
                        <legend class="w-auto ml-3">Daftar PO</legend>
                        <div class="card-body">
                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden tableFixedHeader" style="position: sticky">
                                <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center table-striped">
                                    <thead>
                                    <tr>
                                        <th width="40%">Nomor PO</th>
                                        <th width="25%">Tanggal</th>
                                        <th width="25%"></th>
                                        <th width="10%"></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row form-group mt-3 mb-0">
                                <div class="custom-control custom-checkbox col-sm-2 ml-3">
                                    <input type="checkbox" class="custom-control-input" id="cb_checkall" onchange="checkAll(event)">
                                    <label for="cb_checkall" class="custom-control-label">Check All</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="card-body pt-0 mr-3">
                        <div class="row">
                            <div class="col"></div>
                            <button class="col-sm-3 btn btn-success mr-2" onclick="transfer()">TRANSFER</button>
                        </div>
                    </div>
                </fieldset>
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

    </style>

    <script>
        var listNomor = [];
        var selected = [];
        var dataNodoc = [];
        var dataVNew = [];

        $(document).ready(function(){
            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            $('.tanggal').datepicker('setDate', new Date());


            $('#table_daftar').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "fixedHeader": true,
                "createdRow": function (row, data, dataIndex) {
                },
                "order" : [],
                "initComplete": function(){

                }
            });
            // $('#tanggal1').val('01/04/2020');
        });

        function getData(){
            if(checkDate($('#tanggal1').val()) && checkDate($('#tanggal2').val())){
                $.ajax({
                    url: '{{ url()->current().'/get-data' }}',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        tgl1: $('#tanggal1').val(),
                        tgl2: $('#tanggal2').val(),
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if($.fn.DataTable.isDataTable('#table_daftar')){
                            $('#table_daftar').DataTable().destroy();
                            $("#table_daftar tbody [role='row']").remove();
                        }

                        listNomor = [];
                        for(i=0;i<response.length;i++){
                            listNomor.push(response[i].fhnopo);

                            tr = `<tr><td>${response[i].fhnopo}</td><td>${response[i].fhtgpo}</td>` +
                                    `<td>${response[i].tpoh_nopo}</td>` +
                                `<td>` +
                                `<div class="custom-control custom-checkbox text-center">` +
                                `<input type="checkbox" class="custom-control-input cb-no" id="cb_${i}" onchange="selectDaftar()">` +
                                `<label for="cb_${i}" class="custom-control-label"></label>` +
                                `</div>` +
                                `</td></tr>`;

                            $('#table_daftar tbody').append(tr);

                            if(response[i].tpoh_nopo === 'BELUM DIPROSES'){
                                $('#cb_'+i).prop('checked',true);
                                selected.push(response[i].fhnopo);
                            }
                        }

                        selectDaftar();

                        $('#table_daftar').DataTable({
                            "paging": false,
                            "searching": false,
                            "ordering": true,
                            "info": true,
                            "fixedHeader": true,
                            "scrollY": true,
                            "createdRow": function (row, data, dataIndex) {
                                $(row).find(':eq(0)').addClass('text-left');
                                $(row).addClass('row-lov-kat-2').css({'cursor': 'pointer'});
                            },
                            "order" : [],
                            "initComplete": function(){

                            }
                        });
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                    }
                });
            }
        }

        function selectDaftar(){
            selected = [];
            $('#table_daftar tbody tr').each(function(){
                if($(this).find(':eq(3) input').is(':checked')){
                    temp = [];
                    temp['nomor'] = $(this).find(':eq(0)').html();
                    if($(this).find(':eq(2)').html() === 'BELUM DIPROSES')
                        temp['v_new'] = 'true';
                    else temp['v_new'] = 'false';

                    dataNodoc.push(temp['nomor']);
                    dataVNew.push(temp['v_new']);
                }
            });
        }

        function checkAll(e){
            if($(e.target).is(':checked')){
                $('#table_daftar tbody tr').each(function(){
                    $(this).find(':eq(3) input').prop('checked',true);
                });
                selectDaftar();
            }
            else{
                selected = [];
                dataNodoc = [];
                dataVNew = [];
                $('#table_daftar tbody tr').each(function(){
                    $(this).find(':eq(3) input').prop('checked',false);
                });
            }
        }

        function transfer(){
            if(dataNodoc.length == 0){
                swal({
                    title: 'Tidak ada data yang dipilih!',
                    icon: 'error'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin melakukan proses transfer?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/proses-transfer',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                nodoc: dataNodoc,
                                vnew: dataVNew
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                swal({
                                    title: response.title,
                                    icon: response.status,
                                });

                                if(response.status === 'success')
                                    getData();
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: error.responseJSON.message,
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            }
        }


    </script>

@endsection
