@extends('navbar')

@section('title','LAPORAN | SERVICE LEVEL PO THD BPB / DIV / DEPT / KATB')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">Service Level PO Thd BPB / DIV / DEPT / KATB</legend>
                    <fieldset class="card border-secondary m-4">
                        <div class="card-body">
                            <div class="row form-group">
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control text-center" id="tanggal" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MULAI DIV</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="div1">
                                    <button id="btn_lov_div_1" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_div_1" disabled>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </button>
                                </div>
                                <label class="col-sm-1 pt-1 text-center">s/d</label>
                                <div class="col-sm-2 buttonInside div1">
                                    <input type="text" class="form-control" id="div2">
                                    <button id="btn_lov_div_2" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_div_2" disabled>
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row div1 div2">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MULAI DEPT</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="dep1">
                                    <button id="btn_lov_dep_1" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_dep_1" disabled>
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                                <label class="col-sm-1 pt-1 text-center">s/d</label>
                                <div class="col-sm-2 buttonInside div1 div2 dep1">
                                    <input type="text" class="form-control" id="dep2">
                                    <button id="btn_lov_dep_2" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_dep_2" disabled>
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row div1 div2 dep1 dep2">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MULAI KAT</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="kat1">
                                    <button id="btn_lov_kat_1" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_kat_1" disabled>
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                                <label class="col-sm-1 pt-1 text-center">s/d</label>
                                <div class="col-sm-2 buttonInside div1 div2 dep1 dep2 kat1">
                                    <input type="text" class="form-control" id="kat2">
                                    <button id="btn_lov_kat_2" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_kat_2" disabled>
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm"></div>
                                <button id="btnPrint" class="col-sm-2 btn btn-primary" onclick="print()">CETAK LAPORAN</button>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary mx-4 mt-0 mb-4">
                        <legend class="w-auto ml-3">Master TAG</legend>
                        <div class="card-body">
                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden tableFixedHeader" style="position: sticky">
                                <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center table-striped">
                                    <thead>
                                    <tr>
                                        <th width="15%"></th>
                                        <th width="50%">TAG</th>
                                        <th width="35%">NAMA TAG</th>
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
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_div_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_div_1">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Divisi</th>
                                        <th>Kode Divisi</th>
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

    <div class="modal fade" id="m_lov_div_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_div_2">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Divisi</th>
                                        <th>Kode Divisi</th>
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

    <div class="modal fade" id="m_lov_dep_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_dep_1">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Departement</th>
                                        <th>Kode Departement</th>
                                        <th>Kode Divisi</th>
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

    <div class="modal fade" id="m_lov_dep_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_dep_2">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Departement</th>
                                        <th>Kode Departement</th>
                                        <th>Kode Divisi</th>
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

    <div class="modal fade" id="m_lov_kat_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_kat_1">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <th>Kode Kategori</th>
                                        <th>Kode Departement</th>
                                        <th>Kode Divisi</th>
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

    <div class="modal fade" id="m_lov_kat_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_kat_2">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <th>Kode Kategori</th>
                                        <th>Kode Departement</th>
                                        <th>Kode Divisi</th>
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
        var listTag = [];
        var selected = [];

        $(document).ready(function(){
            $('#tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                dateLimit: {
                    'months': 1,
                    'days': -1
                }
            });

            getLovDivisi1();
            getDataTag();
        });

        function getDataTag(){
            $.ajax({
                url: '{{ url()->current() }}/get-data-tag',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {

                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                    selected = [];
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('#table_daftar tbody tr').remove();
                    listTag = [];
                    for(i=0;i<response.length;i++){
                        listTag.push(response[i].tag_kodetag);

                        tr = `<tr>` +
                            `<td>` +
                            `<div class="custom-control custom-checkbox text-center">` +
                            `<input type="checkbox" class="custom-control-input cb-no cb-tag" id="cb_${i}" onchange="selectTag()">` +
                            `<label for="cb_${i}" class="custom-control-label"></label>` +
                            `</div>` +
                            `<td>${response[i].tag_kodetag}</td><td>${response[i].tag_keterangan}</td>` +
                            `</td>` +
                            `</tr>`;
                        $('#table_daftar tbody').append(tr);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            });
        }

        function selectTag(){
            i = 0;
            selected = [];
            $('.cb-tag').each(function(){
                if($(this).is(':checked')){
                    selected.push(listTag[i]);
                }
                i++;
            });
        }

        function checkAll(e){
            if($(e.target).is(':checked')){
                $('.cb-no').prop('checked',true);
                selected = listTag;
            }
            else{
                $('.cb-no').prop('checked',false);
                selected = [];
            }
        }

        function getLovDivisi1(){
            if($.fn.DataTable.isDataTable('#table_lov_div_1')){
                $('#table_lov_div_1').DataTable().destroy();
                $("#table_lov_div_1 tbody [role='row']").remove();
            }

            lovdiv1 = $('#table_lov_div_1').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/get-data-lov-div' }}',
                    data: {
                        div: $('#div1').val()
                    }
                },
                "columns": [
                    {data: 'div_namadivisi', name: 'div_namadivisi'},
                    {data: 'div_kodedivisi', name: 'div_kodedivisi'},
                ],
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-lov-div-1').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_div_1').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-div-1', function (e) {
                        $('#div1').val($(this).find(':eq(1)').html());

                        $('.div1 input').val('');
                        $('.div1 button').prop('disabled',true);

                        getLovDivisi2();

                        $('#m_lov_div_1').modal('hide');
                    });
                }
            });
        }

        function getLovDivisi2(){
            if($.fn.DataTable.isDataTable('#table_lov_div_2')){
                $('#table_lov_div_2').DataTable().destroy();
                $("#table_lov_div_2 tbody [role='row']").remove();
            }

            lovdiv2 = $('#table_lov_div_2').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/get-data-lov-div' }}',
                    data: {
                        div: $('#div1').val()
                    },
                    beforeSend: function(){
                        $('#btn_lov_div_2').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                    }
                },
                "columns": [
                    {data: 'div_namadivisi', name: 'div_namadivisi'},
                    {data: 'div_kodedivisi', name: 'div_kodedivisi'},
                ],
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-lov-div-2').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_div_2').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-div-2', function (e) {
                        $('#div2').val($(this).find(':eq(1)').html());

                        $('.div2 input').val('');
                        $('.div2 button').prop('disabled',true);

                        getLovDep1();

                        $('#m_lov_div_2').modal('hide');
                    });
                }
            });
        }

        function getLovDep1(){
            if($.fn.DataTable.isDataTable('#table_lov_dep_1')){
                $('#table_lov_dep_1').DataTable().destroy();
                $("#table_lov_dep_1 tbody [role='row']").remove();
            }

            lovdep1 = $('#table_lov_dep_1').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/get-data-lov-dep' }}',
                    data: {
                        div: $('#div1').val()
                    },
                    beforeSend: function(){
                        $('#btn_lov_dep_1').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                    }
                },
                "columns": [
                    {data: 'dep_namadepartement', name: 'dep_namadepartement'},
                    {data: 'dep_kodedepartement', name: 'dep_kodedepartement'},
                    {data: 'dep_kodedivisi', name: 'dep_kodedivisi'},
                ],
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-lov-dep-1').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_dep_1').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-dep-1', function (e) {
                        $('#dep1').val($(this).find(':eq(1)').html());

                        $('.dep1 input').val('');
                        $('.dep1 button').prop('disabled',true);

                        getLovDep2();

                        $('#m_lov_dep_1').modal('hide');
                    });
                }
            });
        }

        function getLovDep2(){
            if($.fn.DataTable.isDataTable('#table_lov_dep_2')){
                $('#table_lov_dep_2').DataTable().destroy();
                $("#table_lov_dep_2 tbody [role='row']").remove();
            }

            lovdep1 = $('#table_lov_dep_2').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/get-data-lov-dep' }}',
                    data: {
                        div: $('#div2').val()
                    },
                    beforeSend: function(){
                        $('#btn_lov_dep_2').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                    }
                },
                "columns": [
                    {data: 'dep_namadepartement', name: 'dep_namadepartement'},
                    {data: 'dep_kodedepartement', name: 'dep_kodedepartement'},
                    {data: 'dep_kodedivisi', name: 'dep_kodedivisi'},
                ],
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-lov-dep-2').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_dep_2').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-dep-2', function (e) {
                        $('#dep2').val($(this).find(':eq(1)').html());

                        $('.dep2 input').val('');
                        $('.dep2 button').prop('disabled',true);

                        getLovKat1();

                        $('#m_lov_dep_2').modal('hide');
                    });
                }
            });
        }

        function getLovKat1(){
            if($.fn.DataTable.isDataTable('#table_lov_kat_1')){
                $('#table_lov_kat_1').DataTable().destroy();
                $("#table_lov_kat_1 tbody [role='row']").remove();
            }

            lovdep1 = $('#table_lov_kat_1').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/get-data-lov-kat' }}',
                    data: {
                        div: $('#div1').val(),
                        dep: $('#dep1').val()
                    },
                    beforeSend: function(){
                        $('#btn_lov_kat_1').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                    }
                },
                "columns": [
                    {data: 'kat_namakategori', name: 'kat_namakategori'},
                    {data: 'kat_kodekategori', name: 'kat_kodekategori'},
                    {data: 'kat_kodedepartement', name: 'dep_kodedepartement'},
                    {data: 'dep_kodedivisi', name: 'dep_kodedivisi'},
                ],
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-lov-kat-1').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_kat_1').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-kat-1', function (e) {
                        $('#kat1').val($(this).find(':eq(1)').html());

                        $('.kat1 input').val('');
                        $('.kat1 button').prop('disabled',true);

                        getLovKat2();

                        $('#m_lov_kat_1').modal('hide');
                    });
                }
            });
        }

        function getLovKat2(){
            if($.fn.DataTable.isDataTable('#table_lov_kat_2')){
                $('#table_lov_kat_2').DataTable().destroy();
                $("#table_lov_kat_2 tbody [role='row']").remove();
            }

            lovdep1 = $('#table_lov_kat_2').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/get-data-lov-kat' }}',
                    data: {
                        div: $('#div2').val(),
                        dep: $('#dep2').val()
                    },
                    beforeSend: function(){
                        $('#btn_lov_kat_2').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
                    }
                },
                "columns": [
                    {data: 'kat_namakategori', name: 'kat_namakategori'},
                    {data: 'kat_kodekategori', name: 'kat_kodekategori'},
                    {data: 'kat_kodedepartement', name: 'dep_kodedepartement'},
                    {data: 'dep_kodedivisi', name: 'dep_kodedivisi'},
                ],
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-lov-kat-2').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_kat_2').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-kat-2', function (e) {
                        $('#kat2').val($(this).find(':eq(1)').html());

                        $('.kat2 input').val('');
                        $('.kat2 button').prop('disabled',true);

                        $('#m_lov_kat_2').modal('hide');
                    });
                }
            });
        }

        $('#div1').on('keypress',function(event){
            if(event.which == 13){
                $('#div1').val(nvl($('#div1').val(), '0'));
                $('#div2').select();
            }
        });

        $('#div2').on('keypress',function(event){
            if(event.which == 13){
                $('#div2').val(nvl($('#div2').val(), '9'));
                $('#dep1').select();
            }
        });

        $('#dep1').on('keypress',function(event){
            if(event.which == 13){
                $('#dep1').val(nvl($('#dep1').val(), '01'));
                $('#dep2').select();
            }
        });

        $('#dep2').on('keypress',function(event){
            if(event.which == 13){
                $('#dep2').val(nvl($('#dep2').val(), '99'));
                $('#kat1').select();
            }
        });

        $('#kat1').on('keypress',function(event){
            if(event.which == 13){
                $('#kat1').val(nvl($('#kat1').val(), '01'));
                $('#kat2').select();
            }
        });

        $('#kat2').on('keypress',function(event){
            if(event.which == 13){
                $('#kat2').val(nvl($('#kat2').val(), '99'));
                $('#btnPrint').focus();
            }
        });



        function print(){
            // if(!$('#div1').val() || !$('#div2').val() || !$('#dep1').val() || !$('#dep2').val() || !$('#kat1').val() || !$('#kat2').val()){
            //     swal({
            //         title: 'Inputan belum lengkap!',
            //         icon: 'warning'
            //     });
            // }
            if($('#div1').val() > $('#div2').val()){
                swal({
                    title: 'Kode divisi 1 lebih besar dari kode divisi 2!',
                    icon: 'warning'
                });
            }
            else if($('#dep1').val() > $('#dep2').val()){
                swal({
                    title: 'Kode departement 1 lebih besar dari kode departement 2!',
                    icon: 'warning'
                });
            }
            else if($('#kat1').val() > $('#kat2').val()){
                swal({
                    title: 'Kode kategori 1 lebih besar dari kode kategori 2!',
                    icon: 'warning'
                });
            }
            else{
                tanggal = $('#tanggal').val().split(' - ');

                tgl1 = tanggal[0];
                tgl2 = tanggal[1];

                $('#div1').val(nvl($('#div1').val(), '0'));
                $('#div2').val(nvl($('#div2').val(), '9'));
                $('#dep1').val(nvl($('#dep1').val(), '00'));
                $('#dep2').val(nvl($('#dep2').val(), '99'));
                $('#kat1').val(nvl($('#kat1').val(), '00'));
                $('#kat2').val(nvl($('#kat2').val(), '99'));

                swal({
                    title: 'Yakin ingin mencetak laporan?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        tag = '';
                        $.each(selected, function(index, value){
                            tag += value +'*';
                        });
                        tag = tag.substr(0,tag.length-1);

                        window.open(`{{ url()->current() }}/print?tgl1=${tgl1}&tgl2=${tgl2}&div1=${$('#div1').val()}&div2=${$('#div2').val()}&dep1=${$('#dep1').val()}&dep2=${$('#dep2').val()}&kat1=${$('#kat1').val()}&kat2=${$('#kat2').val()}&tag=${tag}`,'_blank');
                    }
                });
            }
        }

    </script>
@endsection
