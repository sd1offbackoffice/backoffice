@extends('navbar')

@section('title','TABEL | PLU MRO')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">PLU</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">PLU</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="plu">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_plu">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label  text-right pl-0 pr-0">Kode Divisi</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="div_kode" disabled>
                                        <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovDivisi()" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-left" id="div_nama" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label  text-right pl-0 pr-0">Kode Departement</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="dep_kode" disabled>
                                        <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovDepartement()" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-left" id="dep_nama" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label  text-right pl-0 pr-0">Kode Kategori Barang</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="kat_kode" disabled>
                                        <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovKategori()" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-left" id="kat_nama" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-left" id="deskripsi" disabled>
                                    </div>
                                </div><div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Satuan</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-left" id="satuan" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="col-sm btn btn-danger" id="" onclick="deleteData('')">DELETE</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="col-sm btn btn-primary" id="" onclick="print()">PRINT</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">PLU MRO</legend>
                            <div class="card-body pt-0">
                                <table class="table table bordered table-sm mt-3" id="table_data">
                                    <thead class="theadDataTables">
                                    <tr class="text-center align-middle">
                                        <th width="10%"></th>
                                        <th width="20%">PLU</th>
                                        <th width="50%">Deskripsi</th>
                                        <th width="20%">Satuan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PLU</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_plu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_divisi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_divisi">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Divisi</th>
                                        <th>Singkatan</th>
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
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_departement">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Departement</th>
                                        <th>Singkatan</th>
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
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_kategori">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Kategori</th>
                                        <th>Singkatan</th>
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
            /*overflow-y: hidden;*/
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
            max-height: 230px;
            overflow-y: scroll;
            overflow-x: hidden;
        }

        .nowrap{
            white-space: nowrap;
        }
    </style>

    <script>
        var dataVoucher = [];
        var dataPLU = [];
        var supplierPLU = [];
        var tempPLU = [];

        $(document).ready(function(){
            getData();

            getModalData('');
        });

        $(document).on('click', '.row-plu', function (e) {
            $('#plu').val($(this).find('td:eq(1)').html());

            getDetailAndInsert($(this).find('td:eq(1)').html());

            $('#m_lov_plu').modal('hide');
        });

        $('#m_lov_plu').on('shown.bs.modal',function(){
            $('#table_lov_plu_filter input').val('');
            $('#table_lov_plu_filter input').select();
        });

        function getModalData(value){
            if ($.fn.DataTable.isDataTable('#table_lov_plu')) {
                $('#table_lov_plu').DataTable().destroy();
                $("#table_lov_plu tbody [role='row']").remove();
            }

            if(!$.isNumeric(value)){
                search = value.toUpperCase();
            }
            else search = value;

            $('#table_lov_plu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-lov-plu',
                    "data" : {
                        'plu' : search
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-plu');
                },
                "initComplete" : function(){
                    $('#table_lov_plu_filter input').val(value).select();

                    // $(".row-plu").prop("onclick", null).off("click");

                    // $(document).on('click', '.row-plu', function (e) {
                    //     $('#plu').val($(this).find('td:eq(1)').html());
                    //
                    //     getDetailAndInsert($(this).find('td:eq(1)').html());
                    //
                    //     $('#m_lov_plu').modal('hide');
                    // });
                }
            });

            $('#table_lov_plu_filter input').val(value);

            $('#table_lov_plu_filter input').off().on('keypress', function (e){
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getModalData(val);
                }
            });
        }

        function getData(){
            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().destroy();
            }

            $('#table_data').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-data' }}',
                },
                "columns": [
                    {data: null, render: function(data, type, full, meta){
                            return `<td width="10%" class="align-middle"><button class="btn btn-danger btn-delete" onclick="deleteData('${data.plu}')"><i class="fas fa-times"></i></button></td>`;
                        }
                    },
                    {data: 'plu'},
                    {data: 'deskripsi'},
                    {data: 'satuan'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find('td:eq(0)').addClass('text-center align-middle');
                    $(row).find('td:eq(1)').addClass('text-center align-middle');
                    $(row).find('td:eq(2)').addClass('text-left align-middle');
                    $(row).find('td:eq(3)').addClass('text-center align-middle');
                },
                "order": [],
                "initComplete": function () {

                }
            });
        }

        function getDetailAndInsert(plu){
            $.ajax({
                url: '{{ url()->current() }}/get-detail-and-insert',
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

                    $('#dep_kode').val(response.data.prd_kodedepartement);
                    $('#dep_nama').val(response.data.dep_namadepartement);
                    $('#div_kode').val(response.data.prd_kodedivisi);
                    $('#div_nama').val(response.data.div_namadivisi);
                    $('#kat_kode').val(response.data.prd_kodekategoribarang);
                    $('#kat_nama').val(response.data.kat_namakategori);

                    $('#deskripsi').val(response.data.deskripsi);
                    $('#satuan').val(response.data.satuan);

                    swal({
                        title: response.message,
                        icon: 'success'
                    }).then(() => {
                        getData();
                    });
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#plu').select();
                    });
                }
            });
        }

        function deleteData(plu){
            if(plu == '' && $('#plu').val() == ''){
                swal({
                    title: 'Inputan PLU tidak boleh kosong!',
                    icon: 'error'
                }).then(() => {
                    $('#plu').select();
                });
            }
            else{
                if(plu == ''){
                    plu = $('#plu').val();
                }

                swal({
                    title: 'Yakin ingin menghapus PLU '+plu+'?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/delete-data',
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
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('#top_field input').val('');
                                    getData();
                                    $('#plu').select();
                                });
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error',
                                }).then(() => {

                                });
                            }
                        });
                    }
                });
            }
        }

        function print(){
            swal({
                title: 'Cetak by PLU / Deskripsi?',
                icon: 'warning',
                buttons: {
                    plu: 'PLU',
                    desk: 'Deskripsi'
                }
            }).then((val) => {
                if(val){
                    window.open(`{{ url()->current() }}/print?orderBy=${val}`,'_blank');
                }
            });
        }

        function showLovDivisi(){
            $('#m_divisi').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_divisi')){
                getLovDivisi();
            }
        }

        function getLovDivisi(){
            $('#table_divisi').DataTable({
                "ajax": '{{ url()->current().'/get-lov-divisi' }}',
                "columns": [
                    {data: 'kode'},
                    {data: 'nama'},
                    {data: 'singkatan'}
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
                    $(row).find(':eq(2)').addClass('text-left');
                    $(row).addClass('row-div').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(".row-div").prop("onclick", null).off("click");
                    $(document).on('click', '.row-div', function (e) {
                        $('#div_kode').val($(this).find('td:eq(0)').html());
                        $('#div_nama').val($(this).find('td:eq(1)').html());

                        $('#dep_kode').val('');
                        $('#dep_nama').val('');
                        $('#kat_kode').val('');
                        $('#kat_nama').val('');

                        if($.fn.DataTable.isDataTable('#table_departement')){
                            $('#table_departement').DataTable().destroy();
                        }

                        // getLovDepartement();

                        $('#m_divisi').modal('hide');
                    });
                }
            });
        }

        function showLovDepartement(){
            $('#m_departement').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_departement')){
                getLovDepartement();
            }
        }

        function getLovDepartement(){
            $('#table_departement').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-lov-departement' }}',
                    data: {
                        div: $('#div_kode').val()
                    }
                },
                "columns": [
                    {data: 'kode'},
                    {data: 'nama'},
                    {data: 'singkatan'}
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
                    $(row).find(':eq(2)').addClass('text-left');
                    $(row).addClass('row-dep').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(".row-dep").prop("onclick", null).off("click");
                    $(document).on('click', '.row-dep', function (e) {
                        $('#dep_kode').val($(this).find('td:eq(0)').html());
                        $('#dep_nama').val($(this).find('td:eq(1)').html());

                        $('#kat_kode').val('');
                        $('#kat_nama').val('');

                        if($.fn.DataTable.isDataTable('#table_kategori')){
                            $('#table_kategori').DataTable().destroy();
                        }
                        // getLovKategori();

                        $('#m_departement').modal('hide');
                    });
                }
            });
        }

        function showLovKategori(){
            $('#m_kategori').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_kategori')){
                getLovKategori();
            }
        }

        function getLovKategori(){
            $('#table_kategori').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-lov-kategori' }}',
                    data: {
                        dep: $('#dep_kode').val()
                    }
                },
                "columns": [
                    {data: 'kode'},
                    {data: 'nama'},
                    {data: 'singkatan'}
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
                    $(row).find(':eq(2)').addClass('text-left');
                    $(row).addClass('row-kat').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(".row-kat").prop("onclick", null).off("click");
                    $(document).on('click', '.row-kat', function (e) {
                        $('#kat_kode').val($(this).find('td:eq(0)').html());
                        $('#kat_nama').val($(this).find('td:eq(1)').html());

                        $('#m_kategori').modal('hide');
                    });
                }
            });
        }
    </script>
@endsection
