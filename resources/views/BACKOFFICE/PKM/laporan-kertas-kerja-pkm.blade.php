@extends('navbar')

@section('title','PKM | LAPORAN KERTAS KERJA PKM')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">LAPORAN KERTAS KERJA PKM</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">DIVISI</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="div1" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                        data-target="#m_divisi" onclick="changeObjDiv('div1')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 text-center col-form-label">s/d</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="div2" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                        data-target="#m_divisi" onclick="changeObjDiv('div2')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">DEPARTEMENT</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="dep1" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                        data-target="#m_departement" onclick="changeObjDep('dep1')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 text-center col-form-label">s/d</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="dep2" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                        data-target="#m_departement" onclick="changeObjDep('dep2')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">KATEGORI</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="kat1" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                        data-target="#m_kategori" onclick="changeObjKat('kat1')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 text-center col-form-label">s/d</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="kat2" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                        data-target="#m_kategori" onclick="changeObjKat('kat2')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">PLU</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="plu1" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_prdcd" onclick="changeObjPlu('plu1')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 text-center col-form-label">s/d</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="plu2" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_prdcd" onclick="changeObjPlu('plu2')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">KODE MONITORING PLU</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="mtr" disabled>
                                <button id="btn_monitoring" type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_monitoring">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <input maxlength="10" type="text" class="form-control" id="nmmtr" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">Supplier</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="sup1" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_supplier" onclick="changeObjSup('sup1')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 text-center col-form-label">s/d</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="sup2" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_supplier" onclick="changeObjSup('sup2')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">Tag</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="tag">
                                    <option value="A">Semua</option>
                                    <option value="P">Pilih</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group tag-pilih" style="display: none">
                            <div class="offset-3 col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="tag1" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_tag" onclick="changeObjTag('tag1')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="tag2" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_tag" onclick="changeObjTag('tag2')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="tag3" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_tag" onclick="changeObjTag('tag3')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="tag4" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_tag" onclick="changeObjTag('tag4')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group tag-pilih" style="display: none">
                            <div class="offset-3 col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="tag5" disabled>
                                <button type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal" data-target="#m_tag" onclick="changeObjTag('tag5')">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">Urut</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="urut">
                                    <option value="1">Divisi</option>
                                    <option value="2">PLU</option>
                                    <option value="3">Supplier</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">Item PLU</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="item">
                                    <option value="1">OMI/IDM</option>
                                    <option value="2">Nasional</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="button" class="btn btn-primary offset-9 col-sm-2"
                                    id="btn-cetak" onclick="cetak()">CETAK
                            </button>
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
                                        <th>PLU</th>
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
                                        <th>Kode Divisi</th>
                                        <th>Nama Divisi</th>
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
                                        <th>Kode Departement</th>
                                        <th>Nama Departement</th>
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
                                        <th>Kode Kategori</th>
                                        <th>Nama Kategori</th>
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
                                        <th>Kode Monitoring</th>
                                        <th>Nama Monitoring</th>
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

    <div class="modal fade" id="m_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_supplier">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
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

    <div class="modal fade" id="m_tag" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_tag">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Tag</th>
                                        <th>Keterangan</th>
                                        <th>Tidak Order</th>
                                        <th>Tidak Jual</th>
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
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover {
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

        .clicked, .row-detail:hover {
            background-color: grey !important;
            color: white;
        }

    </style>

    <script>
        var div;
        var dep;
        var kat;
        var plu;
        var mtr;
        var sup;
        var tag;

        $(document).ready(function () {
            $('.tanggal').MonthPicker({
                Button: false
            });

            getDivisi('');
            // getDepartement('');
            // getKategori();
            // getPRDCD();
            getMonitoring();
            // getSupplier();
            getTag();
        });

        $('#tag').on('change', function () {
            if ($(this).val() == 'P') {
                $('.tag-pilih').show();
            } else {
                $('.tag-pilih').hide();
            }
        });

        function getPRDCD() {
            if ($.fn.DataTable.isDataTable('#table_prdcd')) {
                $('#table_prdcd').DataTable().destroy();
            }

            $("#table_prdcd tbody [role='row']").remove();
            $('#table_prdcd').DataTable({
                "ajax": '{{ url()->current().'/get-lov-plu' }}',
                "columns": [
                    {data: 'plu', name: 'plu'},
                    {data: 'desk', name: 'desk'},
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
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).addClass('row-prdcd').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    // $('#btn_prdcd').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-prdcd', function (e) {
                        plu.val($(this).find('td:eq(0)').html());

                        $('#m_prdcd').modal('hide');

                    });
                }
            });
        }

        function getDivisi(value) {
            if ($.fn.DataTable.isDataTable('#table_divisi')) {
                $('#table_divisi').DataTable().destroy();
            }

            $("#table_divisi tbody [role='row']").remove();

            lovutuh = $('#table_divisi').DataTable({
                "ajax": {
                    "url": '{{ url()->current().'/get-lov-divisi' }}',
                    "data": {
                        div: value
                    },
                },
                "columns": [
                    {data: 'div_kodedivisi'},
                    {data: 'div_namadivisi'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).addClass('row-divisi').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    // $('#btn_divisi').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-divisi', function (e) {
                        div.val($(this).find('td:eq(0)').html());

                        $('#m_divisi').modal('hide');
                    });
                }
            });
        }

        function getDepartement(value) {
            if ($.fn.DataTable.isDataTable('#table_departement')) {
                $('#table_departement').DataTable().destroy();
            }

            $("#table_departement tbody [role='row']").remove();

            lovutuh = $('#table_departement').DataTable({
                "ajax": {
                    "url": '{{ url()->current().'/get-lov-departement' }}',
                    "data": {
                        dep: value,
                        div1: $('#div1').val(),
                        div2: $('#div2').val(),
                    },
                },
                "columns": [
                    {data: 'dep_kodedepartement'},
                    {data: 'dep_namadepartement'},
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
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).addClass('row-departement').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    // $('#btn_departement').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-departement', function (e) {
                        dep.val($(this).find('td:eq(0)').html());
                        $('#m_departement').modal('hide');
                    });
                }
            });
        }

        function getKategori(value) {
            if ($.fn.DataTable.isDataTable('#table_kategori')) {
                $('#table_kategori').DataTable().destroy();
            }

            $("#table_kategori tbody [role='row']").remove();

            lovutuh = $('#table_kategori').DataTable({
                "ajax": {
                    "url": '{{ url()->current().'/get-lov-kategori' }}',
                    "data": {
                        kat: value,
                        dep1: $('#dep1').val(),
                        dep2: $('#dep2').val(),
                    },
                },
                "columns": [
                    {data: 'kat_kodekategori'},
                    {data: 'kat_namakategori'},
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
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).addClass('row-kategori').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(document).on('click', '.row-kategori', function (e) {
                        kat.val($(this).find('td:eq(0)').html());

                        $('#m_kategori').modal('hide');
                    });
                }
            });
        }

        function getMonitoring() {
            if ($.fn.DataTable.isDataTable('#table_monitoring')) {
                $('#table_monitoring').DataTable().destroy();
            }

            $("#table_monitoring tbody [role='row']").remove();

            lovutuh = $('#table_monitoring').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-lov-monitoring' }}',
                    data: {}
                },
                "columns": [
                    {data: 'mpl_kodemonitoring'},
                    {data: 'mpl_namamonitoring'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).addClass('row-monitoring').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(document).on('click', '.row-monitoring', function (e) {
                        $('#mtr').val($(this).find('td:eq(0)').html());
                        $('#nmmtr').val($(this).find('td:eq(1)').html());

                        $('#m_monitoring').modal('hide');

                    });
                }
            });
        }

        function getSupplier(value) {
            if ($.fn.DataTable.isDataTable('#table_supplier')) {
                $('#table_supplier').DataTable().destroy();
            }

            $("#table_supplier tbody [role='row']").remove();

            lovutuh = $('#table_supplier').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-lov-supplier' }}',
                    "data": {
                        sup: value,
                    },
                },
                "columns": [
                    {data: 'kode'},
                    {data: 'sup_namasupplier'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).addClass('row-supplier').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(document).on('click', '.row-supplier', function (e) {
                        sup.val($(this).find('td:eq(0)').html());

                        $('#m_supplier').modal('hide');

                    });
                }
            });
        }

        function getTag() {
            if ($.fn.DataTable.isDataTable('#table_tag')) {
                $('#table_tag').DataTable().destroy();
            }

            $("#table_tag tbody [role='row']").remove();

            lovutuh = $('#table_tag').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-lov-tag' }}',
                    data: {}
                },
                "columns": [
                    {data: 'tag'},
                    {data: 'keterangan'},
                    {data: 'tidak_order'},
                    {data: 'tidak_jual'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).addClass('row-tag').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(document).on('click', '.row-tag', function (e) {
                        tag.val($(this).find('td:eq(0)').html());

                        $('#m_tag').modal('hide');

                    });
                }
            });
        }

        function changeObjDiv(val) {
            div = $('#' + val);
            if(val == 'div2'){
                getDivisi($('#div1').val());
            }
        }

        function changeObjDep(val) {
            dep = $('#' + val);
            if(val == 'dep1'){
                getDepartement('');
            }
            else if(val == 'dep2'){
                getDepartement($('#dep1').val());
            }
        }

        function changeObjKat(val) {
            kat = $('#' + val);
            if(val == 'kat1'){
                getKategori('');
            }
            else if(val == 'kat2'){
                getKategori($('#kat1').val());
            }
        }

        function changeObjPlu(val) {
            plu = $('#' + val);
            if(val == 'plu1'){
                getPRDCD('');
            }
            else if(val == 'plu2'){
                getPRDCD($('#plu1').val());
            }
        }

        function changeObjSup(val) {
            sup = $('#' + val);
            if(val == 'sup1'){
                getSupplier('');
            }
            else if(val == 'sup2'){
                getSupplier($('#sup1').val());
            }
        }

        function changeObjTag(val) {
            tag = $('#' + val);
        }

        function cetak() {
            if ($('#tag').val() == 'P' && $('#tag1').val() == '' && $('#tag2').val() == '' && $('#tag3').val() == '' && $('#tag4').val() == '' && $('#tag5').val() == '') {
                swal({
                    title: 'Kolom Tag tidak boleh kosong !',
                    icon: 'warning'
                });
            } else {
                window.open(`{{ url()->current() }}/cetak?div1=${$('#div1').val()}&div2=${$('#div2').val()}&dep1=${$('#dep1').val()}&dep2=${$('#dep2').val()}&kat1=${$('#kat1').val()}&kat2=${$('#kat2').val()}&plu1=${$('#plu1').val()}&plu2=${$('#plu2').val()}&mtr=${$('#mtr').val()}&nmmtr=${$('#nmmtr').val()}&sup1=${$('#sup1').val()}&sup2=${$('#sup2').val()}&tag=${$('#tag').val()}&tag1=${$('#tag1').val()}&tag2=${$('#tag2').val()}&tag3=${$('#tag3').val()}&tag4=${$('#tag4').val()}&urut=${$('#urut').val()}&item=${$('#item').val()}`, '_blank');
            }
        }
    </script>

@endsection
