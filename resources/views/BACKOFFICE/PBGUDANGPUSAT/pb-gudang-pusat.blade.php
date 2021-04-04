@extends('navbar')

@section('title','BO | PB GUDANG PUSAT')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">PB GUDANG PUSAT</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">DEPARTEMENT</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="dep_kode1" disabled>
                                <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovDep(1)">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-6 pl-0 pr-0">
                                <input maxlength="10" type="text" class="form-control" id="dep_nama1" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label"></label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="dep_kode2" disabled>
                                <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovDep(2)">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-6 pl-0 pr-0">
                                <input maxlength="10" type="text" class="form-control" id="dep_nama2" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">KATEGORI BARANG</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="kat_kode1" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovKat(1)">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-6 pl-0 pr-0">
                                <input maxlength="10" type="text" class="form-control" id="kat_nama1" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label"></label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="kat_kode2" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovKat(2)">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-6 pl-0 pr-0">
                                <input maxlength="10" type="text" class="form-control" id="kat_nama2" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">PLU</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="prdcd1" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovPrdcd(1)">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label for="prdcd" class="text-center col-form-label">S/D</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="prdcd2" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovPrdcd(2)">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-9"></div>
                            <button class="col-sm-2 btn btn-primary" onclick="proses()">PROSES PB</button>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="mon_kode" disabled>
                            </div>
                            <div class="col-sm-7 pl-0 pr-0">
                                <input maxlength="10" type="text" class="form-control" id="mon_nama" disabled>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_prdcd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_prdcd">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
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

    <div class="modal fade" id="m_divisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_divisi">
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

    <div class="modal fade" id="m_departement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_departement">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Departement</th>
                                        <th>Kode Departement</th>
                                        <th>Singkatan Departement</th>
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

    <div class="modal fade" id="m_kategori" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_kategori">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <th>Kode Kategori</th>
                                        <th>Kode Departement</th>
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

    <div class="modal fade" id="m_monitoring" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_monitoring">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Monitoring</th>
                                        <th>Kode Monitoring</th>
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

    <div class="modal fade" id="m_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">

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

        .clicked, .row-detail:hover{
            background-color: grey !important;
            color: white;
        }

    </style>

    <script>
        var fieldDep = 1;
        var fieldKat = 1;
        var fieldPrdcd = 1;

        $(document).ready(function(){
            // $('.tanggal').MonthPicker({
            //     Button: false
            // });

            // getDivisi();
            // getPRDCD();
            // getMonitoring();
        });

        function showLovDep(field){
            fieldDep = field;

            $('#m_departement').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_departement')){
                getDepartement();
            }
        }

        function getDepartement(){
            if($.fn.DataTable.isDataTable('#table_departement')){
                $('#table_departement').DataTable().destroy();
            }

            $("#table_departement tbody [role='row']").remove();

            lovutuh = $('#table_departement').DataTable({
                "ajax": '{{ url()->current().'/get-lov-departement' }}',
                "columns": [
                    {data: 'dep_namadepartement'},
                    {data: 'dep_kodedepartement'},
                    {data: 'dep_singkatandepartement'},
                    {data: 'dep_kodedivisi'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-departement').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    // $('#btn_departement').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-departement', function (e) {
                        $('#dep_kode'+fieldDep).val($(this).find('td:eq(1)').html());
                        $('#dep_nama'+fieldDep).val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));

                        $('#m_departement').modal('hide');
                    });
                }
            });
        }

        function showLovKat(field){
            fieldKat = field;

            if(!$('#dep_kode1').val() || !$('#dep_kode2').val()){
                swal('Field departement belum lengkap!','','warning');
            }
            else $('#m_kategori').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_kategori')){
                getKategori();
            }
        }

        function getKategori(){
            if($.fn.DataTable.isDataTable('#table_kategori')){
                $('#table_kategori').DataTable().destroy();
            }

            $("#table_kategori tbody [role='row']").remove();

            lovutuh = $('#table_kategori').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-lov-kategori' }}',
                    data: {
                        dep1: $('#dep_kode1').val(),
                        dep2: $('#dep_kode2').val()
                    }
                },
                "columns": [
                    {data: 'kat_namakategori'},
                    {data: 'kat_kodekategori'},
                    {data: 'kat_kodedepartement'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-kategori').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $(document).on('click', '.row-kategori', function (e) {
                        $('#kat_kode'+fieldKat).val($(this).find('td:eq(1)').html());
                        $('#kat_nama'+fieldKat).val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));

                        $('#m_kategori').modal('hide');
                    });
                }
            });
        }

        function showLovPrdcd(field){
            fieldPrdcd = field;

            if(!$('#dep_kode1').val() || !$('#dep_kode2').val()){
                swal('Field departement belum lengkap!','','warning');
            }
            else if(!$('#kat_kode1').val() || !$('#kat_kode2').val()){
                swal('Field kategori belum lengkap!','','warning');
            }
            else{
                $('#m_prdcd').modal('show');

                if(!$.fn.DataTable.isDataTable('#table_prdcd')){
                    getPRDCD();
                }
            }
        }

        function getPRDCD(){
            $('#table_prdcd').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-lov-prdcd' }}',
                    data: {
                        dep1: $('#dep_kode1').val(),
                        dep2: $('#dep_kode2').val(),
                        kat1: $('#kat_kode1').val(),
                        kat2: $('#kat_kode2').val()
                    }
                },
                "columns": [
                    {data: 'desk', name: 'desk'},
                    {data: 'plu', name: 'plu'},
                    {data: 'konversi', name: 'konversi'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-prdcd').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    // $('#btn_prdcd').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-prdcd', function (e) {
                        $('#prdcd'+fieldPrdcd).val($(this).find('td:eq(1)').html());
                        // $('#desk').val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));
                        // $('#unit').val($(this).find('td:eq(2)').html());

                        $('#m_prdcd').modal('hide');

                        // getDetail('prdcd');
                    });
                }
            });
        }

        function proses(){
            if(!$('#dep_kode1').val() || !$('#dep_kode2').val() || !$('#kat_kode1').val() || !$('#kat_kode2').val() || !$('#prdcd1').val() || !$('#prdcd2').val()){
                swal('Inputan belum lengkap!','','warning');
            }
            else if($('#dep_kode1').val() > $('#dep_kode2').val()){
                swal('Kode Departement 1 lebih besar dari Kode Departement 2!','','warning');
            }
            else if($('#kat_kode1').val() > $('#kat_kode2').val()){
                swal('Kode Kategori 1 lebih besar dari Kode Kategori 2!','','warning');
            }
            else if($('#prdcd1').val() > $('#prdcd2').val()){
                swal('Kode PLU 1 lebih besar dari Kode PLU 2!','','warning');
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/proses',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        dep1: $('#dep_kode1').val(),
                        dep2: $('#dep_kode2').val(),
                        kat1: $('#kat_kode1').val(),
                        kat2: $('#kat_kode2').val(),
                        prdcd1: $('#prdcd1').val(),
                        prdcd2: $('#prdcd2').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');


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
        }
    </script>

@endsection
