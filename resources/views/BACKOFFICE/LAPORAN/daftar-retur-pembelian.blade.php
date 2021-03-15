@extends('navbar')

@section('title','LAPORAN | DAFTAR RETUR PEMBELIAN')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <fieldset class="card border-secondary m-2 inputan">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">KATEGORI LAPORAN</label>
                                <div class="col">
                                    <select class="form-control" id="tipe">
                                        <option value="1">1. DAFTAR RETUR PEMBELIAN RINGKASAN DIVISI/DEPARTEMEN/KATEGORI
                                        </option>
                                        <option value="2">2. DAFTAR RETUR PEMBELIAN RINCIAN PRODUK PER
                                            DIVISI/DEPARTEMEN/KATEGORI
                                        </option>
                                        <option value="3">3. DAFTAR RETUR PEMBELIAN RINCIAN PRODUK PER
                                            SUPPLIER
                                        </option>
                                        <option value="4">4. DAFTAR RETUR PEMBELIAN RINCIAN PRODUK PER SUPPLIER /
                                            DOKUMEN
                                        </option>
                                        <option value="5">5. DAFTAR RETUR PEMBELIAN RINCIAN DOKUMEN PER SUPPLIER
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="menu-default">
                                <div class="row">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">TANGGAL</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="tgl1" onchange="cekTanggal('tgl1')">
                                    </div>
                                    <label class="col-sm-1 pt-1 text-center">s/d</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="tgl2" onchange="cekTanggal('tgl2')">
                                    </div>
                                </div>
                            </div>

                            <div class="menu-divdepkat">
                                <div class="row">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MULAI DIV</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="div1" disabled>
                                        <button id="btn_lov_div_1" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_div_1" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="div1_nama" disabled>
                                    </div>
                                </div>
                                <div class="row div1">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">SAMPAI DIV</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="div2" disabled>
                                        <button id="btn_lov_div_2" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_div_2" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="div2_nama" disabled>
                                    </div>
                                </div>
                                <div class="row div1 div2">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MULAI DEPT</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="dep1" disabled>
                                        <button id="btn_lov_dep_1" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_dep_1" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="dep1_nama" disabled>
                                    </div>
                                </div>
                                <div class="row div1 div2 dep1">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">SAMPAI DEPT</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="dep2" disabled>
                                        <button id="btn_lov_dep_2" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_dep_2" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="dep2_nama" disabled>
                                    </div>
                                </div>
                                <div class="row div1 div2 dep1 dep2">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MULAI KAT</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="kat1" disabled>
                                        <button id="btn_lov_kat_1" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_kat_1" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="kat1_nama" disabled>
                                    </div>
                                </div>
                                <div class="row div1 div2 dep1 dep2 kat1">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">SAMPAI KAT</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="kat2" disabled>
                                        <button id="btn_lov_kat_2" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_kat_2" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="kat2_nama" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="menu-supplier">
                                <div class="row">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MULAI SUPPLIER</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="sup1" disabled>
                                        <button id="btn_lov_sup_1" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_sup_1" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="sup1_nama" disabled>
                                    </div>
                                </div>
                                <div class="row div1">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">SAMPAI SUPPLIER</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="sup2" disabled>
                                        <button id="btn_lov_sup_2" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_sup_2" disabled>
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="sup2_nama" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="menu-kodemtr">
                                <div class="row">
                                    <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">Monitoring</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="mtr" disabled>
                                        <button id="btn_lov_mtr" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_mtr">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="mtr_nama" disabled>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <button class="col-sm-6 btn btn-primary" onclick="cetak()">CETAK LAPORAN</button>
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

    <div class="modal fade" id="m_lov_mtr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_mtr">
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

    <div class="modal fade" id="m_lov_sup_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_sup_1">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
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

    <div class="modal fade" id="m_lov_sup_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_sup_2">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
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
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover {
            cursor: pointer;
            background-color: #acacac;
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
        $(document).ready(function () {
            $('.menu-kodemtr').hide();
            $('.menu-supplier').hide();
            getLovDivisi1();

            // swal("PILIHAN DAFTAR PEMBELIAN BERDASARKAN ?", '', 'info', {
            //     buttons: {
            //         divdepkat: "Divisi/Departement/Kategori!",
            //         kodemtr: "KODE MONITORING"
            //     },
            //
            // })
            //     .then((value) => {
            //         switch (value) {
            //             case "divdepkat":
            //                 $('.menu-divdepkat').show();
            //                 $('.menu-kodemtr').hide();
            //                 getLovDivisi1();
            //                 break;
            //
            //             case "kodemtr":
            //                 $('.menu-kodemtr').show();
            //                 $('.menu-divdepkat').hide();
            //                 getLovMtr();
            //                 break;
            //             default:
            //                 $('.menu-divdepkat').show();
            //                 $('.menu-kodemtr').hide();
            //                 getLovDivisi1();
            //                 break;
            //         }
            //     });

            $('#tgl1').datepicker({
                "dateFormat": "dd/mm/yy",
            });

            $('#tgl2').datepicker({
                "dateFormat": "dd/mm/yy",
            });

            tabel = $('#table_daftar').DataTable({
                "scrollY": "30vh",
                "paging": false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });


        });

        function cekTanggal(periode) {
            if ($('#tgl1').datepicker('getDate') > $('#tgl2').datepicker('getDate') && ($('#tgl1').val() != '' && $('#tgl2').val() != '')) {
                if (periode === 'tgl1') {
                    swal({
                        title: 'Tanggal Pertama lebih besar dari Tanggal Kedua!',
                        icon: 'warning'
                    }).then(() => {
                        $('#tgl1').val('').select();
                    });
                } else {
                    swal({
                        title: 'Tanggal Kedua lebih kecil dari Tanggal Pertama!',
                        icon: 'warning'
                    }).then(() => {
                        $('#tgl2').val('').select();
                    });
                }
            }
        }

        function getLovDivisi1() {
            $('#btn_lov_div_1').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
            if ($.fn.DataTable.isDataTable('#table_lov_div_1')) {
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
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_div_1').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-div-1', function (e) {
                        $('#div1').val($(this).find(':eq(1)').html());
                        $('#div1_nama').val($(this).find(':eq(0)').html().replace('&amp;', '&'));

                        $('.div1 input').val('');
                        $('.div1 button').prop('disabled', true);

                        getLovDivisi2();

                        $('#m_lov_div_1').modal('hide');
                    });
                }
            });
        }

        function getLovDivisi2() {
            if ($.fn.DataTable.isDataTable('#table_lov_div_2')) {
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
                    beforeSend: function () {
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
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_div_2').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-div-2', function (e) {
                        $('#div2').val($(this).find(':eq(1)').html());
                        $('#div2_nama').val($(this).find(':eq(0)').html().replace('&amp;', '&'));

                        $('.div2 input').val('');
                        $('.div2 button').prop('disabled', true);

                        getLovDep1();

                        $('#m_lov_div_2').modal('hide');
                    });
                }
            });
        }

        function getLovDep1() {
            if ($.fn.DataTable.isDataTable('#table_lov_dep_1')) {
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
                    beforeSend: function () {
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
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_dep_1').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-dep-1', function (e) {
                        $('#dep1').val($(this).find(':eq(1)').html());
                        $('#dep1_nama').val($(this).find(':eq(0)').html().replace('&amp;', '&'));

                        $('.dep1 input').val('');
                        $('.dep1 button').prop('disabled', true);

                        getLovDep2();

                        $('#m_lov_dep_1').modal('hide');
                    });
                }
            });
        }

        function getLovDep2() {
            if ($.fn.DataTable.isDataTable('#table_lov_dep_2')) {
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
                    beforeSend: function () {
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
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_dep_2').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-dep-2', function (e) {
                        $('#dep2').val($(this).find(':eq(1)').html());
                        $('#dep2_nama').val($(this).find(':eq(0)').html().replace('&amp;', '&'));

                        $('.dep2 input').val('');
                        $('.dep2 button').prop('disabled', true);

                        getLovKat1();

                        $('#m_lov_dep_2').modal('hide');
                    });
                }
            });
        }

        function getLovKat1() {
            if ($.fn.DataTable.isDataTable('#table_lov_kat_1')) {
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
                    beforeSend: function () {
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
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_kat_1').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-kat-1', function (e) {
                        $('#kat1').val($(this).find(':eq(1)').html());
                        $('#kat1_nama').val($(this).find(':eq(0)').html().replace('&amp;', '&'));

                        $('.kat1 input').val('');
                        $('.kat1 button').prop('disabled', true);

                        getLovKat2();

                        $('#m_lov_kat_1').modal('hide');
                    });
                }
            });
        }

        function getLovKat2() {
            if ($.fn.DataTable.isDataTable('#table_lov_kat_2')) {
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
                    beforeSend: function () {
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
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_kat_2').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-kat-2', function (e) {
                        $('#kat2').val($(this).find(':eq(1)').html());
                        $('#kat2_nama').val($(this).find(':eq(0)').html().replace('&amp;', '&'));

                        $('.kat2 input').val('');
                        $('.kat2 button').prop('disabled', true);

                        $('#m_lov_kat_2').modal('hide');
                    });
                }
            });
        }

        function getLovMtr() {
            $('#btn_lov_mtr').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            if ($.fn.DataTable.isDataTable('#table_lov_mtr')) {
                $('#table_lov_mtr').DataTable().destroy();
                $("#table_lov_mtr tbody [role='row']").remove();
            }

            lovdiv1 = $('#table_lov_mtr').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/get-data-lov-mtr' }}',
                    data: {
                        div: $('#mtr').val()
                    }
                },
                "columns": [
                    {data: 'mpl_kodemonitoring', name: 'mpl_kodemonitoring'},
                    {data: 'mpl_namamonitoring', name: 'mpl_namamonitoring'},
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
                    $(row).addClass('row-lov-mtr').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_mtr').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-mtr', function (e) {
                        $('#mtr_nama').val($(this).find(':eq(1)').html());
                        $('#mtr').val($(this).find(':eq(0)').html().replace('&amp;', '&'));

                        $('.mtr input').val('');
                        $('.mtr button').prop('disabled', true);

                        // getLovDivisi2();

                        $('#m_lov_mtr').modal('hide');
                    });
                }
            });
        }

        function getLovSup1() {
            $('#btn_lov_sup_1').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            if ($.fn.DataTable.isDataTable('#table_lov_sup_1')) {
                $('#table_lov_sup_1').DataTable().destroy();
                $("#table_lov_sup_1 tbody [role='row']").remove();
            }

            lovdiv1 = $('#table_lov_sup_1').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/get-data-lov-sup' }}',
                    data: {
                        div: $('#mtr').val()
                    }
                },
                "columns": [
                    {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},
                    {data: 'sup_namasupplier', name: 'sup_namasupplier'}
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
                    $(row).addClass('row-lov-sup-1').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_sup_1').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-sup-1', function (e) {
                        $('#sup1_nama').val($(this).find(':eq(1)').html());
                        $('#sup1').val($(this).find(':eq(0)').html().replace('&amp;', '&'));

                        $('.sup1 input').val('');
                        $('.sup1 button').prop('disabled', true);

                        getLovSup2();

                        $('#m_lov_sup_1').modal('hide');
                    });
                }
            });
        }

        function getLovSup2() {
            $('#btn_lov_sup_2').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);

            if ($.fn.DataTable.isDataTable('#table_lov_sup_2')) {
                $('#table_lov_sup_2').DataTable().destroy();
                $("#table_lov_sup_2 tbody [role='row']").remove();
            }

            lovdiv1 = $('#table_lov_sup_2').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/get-data-lov-sup' }}',
                    data: {
                        sup: $('#sup1').val()
                    }
                },
                "columns": [
                    {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},
                    {data: 'sup_namasupplier', name: 'sup_namasupplier'},
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
                    $(row).addClass('row-lov-sup-2').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_sup_2').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-sup-2', function (e) {
                        $('#sup2_nama').val($(this).find(':eq(1)').html());
                        $('#sup2').val($(this).find(':eq(0)').html().replace('&amp;', '&'));

                        $('.sup2 input').val('');
                        $('.sup2 button').prop('disabled', true);

                        // getLovDivisi2();

                        $('#m_lov_sup_2').modal('hide');
                    });
                }
            });
        }

        $('#tipe').on('change', function () {
            if ($(this).val() == 1 || $(this).val() == 2) {
                $('.menu-divdepkat').show();
                $('.menu-kodemtr').hide();
                $('.menu-supplier').hide();
                getLovDivisi1();
            } else if ($(this).val() == 3 || $(this).val() == 4 || $(this).val() == 5) {
                $('.menu-supplier').show();
                $('.menu-divdepkat').hide();
                $('.menu-kodemtr').hide();
                getLovSup1();

            }
        });

        function cetak() {
            valid_default = true;
            valid_divdepkat = true;
            valid_kodemtr = true;
            valid_supplier = true;

            $('.menu-default input').each(function () {
                if (!$(this).val())
                    valid_default = false;
            });
            $('.menu-divdepkat input').each(function () {
                if (!$(this).val())
                    valid_divdepkat = false;
            });
            $('.menu-kodemtr input').each(function () {
                if (!$(this).val())
                    valid_kodemtr = false;
            });
            $('.menu-supplier input').each(function () {
                if (!$(this).val())
                    valid_supplier = false;
            });
            if (!valid_default) {
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
                $('#tgl1').focus();
                return false;
            }

            if (!valid_divdepkat && !valid_kodemtr && !valid_supplier) {
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
            } else {
                window.open(`{{ url()->current() }}/cetak?tipe=${$('#tipe').val()}&tgl1=${$('#tgl1').val()}&tgl2=${$('#tgl2').val()}&div1=${$('#div1').val()}&div2=${$('#div2').val()}&dep1=${$('#dep1').val()}&dep2=${$('#dep2').val()}&kat1=${$('#kat1').val()}&kat2=${$('#kat2').val()}&sup1=${$('#sup1').val()}&sup2=${$('#sup2').val()}`, '_blank');
            }
        }
    </script>

@endsection
