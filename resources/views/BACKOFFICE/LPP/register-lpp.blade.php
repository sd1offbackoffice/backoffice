@extends('navbar')
@section('title','Cetak Register LPP')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <fieldset class="card border-dark">
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-sm-right">PILIHAN LPP</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="pilihan-lpp">
                                                <option value="LPP01">1. LPP BAIK RINGKASAN DIVISI
                                                </option>
                                                <option value="LPP02">2. LPP BAIK RINCIAN PRODUK / DIVISI
                                                </option>
                                                <option value="LPP03">3. LPP BAIK RINCIAN PRODUK TANPA RINCIAN GUDANG X
                                                </option>
                                                <option value="LPP04">4. LPP BAIK RINCIAN YANG TERDAPAT PENYESUAIAN
                                                </option>
                                                <option value="LPP05">5. LPP BAIK RINCIAN YANG TERDAPAT KOREKSI
                                                </option>
                                                <option value="LPP06">6. LPP BAIK REKONSILIASI SALDO AWAL DAN SALDO
                                                    AKHIR
                                                </option>
                                                <option value="LPP07">7. LPP BAIK MONITORING PRODUK / DIVISI
                                                </option>
                                                <option value="LPP08">8. LPP RETUR RINGKASAN DIVISI
                                                </option>
                                                <option value="LPP09">9. LPP RETUR RINCIAN PRODUK / DIVISI
                                                </option>
                                                <option value="LPP10">10. LPP RUSAK RINGKASAN DIVISI
                                                </option>
                                                <option value="LPP11">11. LPP RUSAK RINCIAN PRODUK / DIVISI
                                                </option>
                                                <option value="LPP12">12. LPP GABUNGAN RINGKASAN DIVISI
                                                </option>
                                                <option value="LPP13">13. LPP PER SUPPLIER BARANG BAIK
                                                </option>
                                                <option value="LPP14">14. LPP PER SUPPLIER BARANG RETUR
                                                </option>
                                                <option value="LPP15">15. LPP PER SUPPLIER BARANG RUSAK
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-sm-right">TANGGAL</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control daterange-periode" id="periode1">
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-center">s/d</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control daterange-periode" id="periode2">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="prdcd" class="col-sm-2 text-right col-form-label">PLU</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="prdcd1" disabled>
                                            <button id="btn-prdcd1" type="button" data-toggle="modal"
                                                    data-target="#m_data_plu" class="btn btn-primary btn-lov p-0"
                                                    onclick="setSelectedObject('prdcd1')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label for="prdcd" class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="prdcd2" disabled>
                                            <button id="btn-prdcd2" onclick="setSelectedObject('prdcd2')"
                                                    data-toggle="modal"
                                                    data-target="#m_data_plu" type="button"
                                                    class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="dep"
                                               class="col-sm-2 text-right col-form-label">DEPARTEMENT</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="dep1" disabled>
                                            <button id="btn-dep1" onclick="setSelectedObject('dep1')" type="button"
                                                    class="btn btn-primary btn-lov p-0" data-toggle="modal"
                                                    data-target="#m_data_dep">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label for="dep" class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="dep2" disabled>
                                            <button id="btn-dep2" type="button" class="btn btn-primary btn-lov p-0"
                                                    data-toggle="modal"
                                                    data-target="#m_data_dep" onclick="setSelectedObject('dep2')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2 text-right col-form-label">KATEGORI</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="kat1" disabled>
                                            <button id="btn-kat1" type="button" class="btn btn-primary btn-lov p-0"
                                                    data-toggle="modal"
                                                    data-target="#m_data_kat" onclick="setSelectedObject('kat1')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="kat2" disabled>
                                            <button id="btn-kat2" type="button" class="btn btn-primary btn-lov p-0"
                                                    data-toggle="modal"
                                                    data-target="#m_data_kat" onclick="setSelectedObject('kat2')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2 text-right col-form-label">MONITORING</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="mtr1" disabled>
                                            <button id="btn-mtr1" type="button" class="btn btn-primary btn-lov p-0"
                                                    data-toggle="modal"
                                                    data-target="#m_data_kat" onclick="setSelectedObject('mtr1')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="mtr2" disabled>
                                            <button id="btn-mtr2" type="button" class="btn btn-primary btn-lov p-0"
                                                    data-toggle="modal"
                                                    data-target="#m_data_kat" onclick="setSelectedObject('mtr2')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2 text-right col-form-label">KODE SUPPLIER</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="sup1" disabled>
                                            <button id="btn-sup1" type="button" class="btn btn-primary btn-lov p-0"
                                                    data-toggle="modal"
                                                    data-target="#m_data_sup" onclick="setSelectedObject('sup1')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="sup2" disabled>
                                            <button id="btn-sup2" type="button" class="btn btn-primary btn-lov p-0"
                                                    data-toggle="modal"
                                                    data-target="#m_data_sup" onclick="setSelectedObject('sup2')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2 text-right col-form-label">TYPE</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="tipe">
                                                <option value="3">3. SEMUA
                                                </option>
                                                <option value="1">1. MINUS
                                                </option>
                                                <option value="2">2. TIDAK
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-sm-right">BANYAK ITEM</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="banyakitem" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1 mt-5 justify-content-center cetak-1-bagian">
                                        <button type="button" class="btn btn-primary col-sm-5"
                                                id="btn-cetak">CETAK
                                        </button>
                                    </div>
                                    <div class="cetak-2-bagian">
                                        <div class="form-group row mb-1 mt-5 justify-content-center">
                                            <button type="button" class="btn btn-primary col-sm-5"
                                                    id="btn-cetak-1">CETAK LAPORAN (BAGIAN 1)
                                            </button>
                                        </div>
                                        <div class="form-group row mb-1 mt-5 justify-content-center">
                                            <button type="button" class="btn btn-primary col-sm-5"
                                                    id="btn-cetak-2">CETAK LAPORAN (BAGIAN 2)
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade" id="m_data_plu" tabindex="-1" role="dialog" aria-labelledby="m_data_plu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PRDCD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataPLU">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>PLU</th>
                                        <th>Nama Produk</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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

    <div class="modal fade" id="m_data_dep" tabindex="-1" role="dialog" aria-labelledby="m_data_dep" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Departemen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataDep">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Div</th>
                                        <th>Nama Div</th>
                                        <th>Kode Dep</th>
                                        <th>Nama Dep</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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

    <div class="modal fade" id="m_data_kat" tabindex="-1" role="dialog" aria-labelledby="m_data_kat" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataKat">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Dep</th>
                                        <th>Nama Dep</th>
                                        <th>Kode Kat</th>
                                        <th>Nama Kat</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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

    <div class="modal fade" id="m_data_mtr" tabindex="-1" role="dialog" aria-labelledby="m_data_mtr" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Monitoring</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataKat">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Mtr</th>
                                        <th>Nama Mtr</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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

    <div class="modal fade" id="m_data_sup" tabindex="-1" role="dialog" aria-labelledby="m_data_sup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataSup">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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
    <style>
        .buttonInside {
            position: relative;
        }

        .btn-lov-plu {
            position: absolute;
            /*right: 4px;*/
            /*top: 1px;*/
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;

        }

        .input-group-text {
            background-color: white;
        }
    </style>


    <script>
        object = 'plu1';
        $(document).ready(function () {
            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output1 = '0' + (day - day + 1) + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            var output2 = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            $('#periode1').val(output1);
            $('#periode2').val(output2);

            $('#prdcd1,#prdcd2,#dep1,#dep2,#kat1,#kat2,#mtr1,#mtr2,#sup1,#sup2,#tipe,#banyakitem').attr('disabled', true);
            $('#btn-prdcd1,#btn-prdcd2,#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-mtr1,#btn-mtr2,#btn-sup1,#btn-sup2,#btn-tipe,#btn-banyakitem').attr('disabled', true);

            getModalDataPLU('');
            getModalDataDep('');
            getModalDataKat('');
            getModalDataMtr('');
            getModalDataSup('');

            $('.cetak-2-bagian').show();
            $('.cetak-1-bagian').hide();
        });

        $('.daterange-periode').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.daterange-periode').on('apply.daterangepicker', function (ev, picker) {
            $('#periode1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#periode2').val(picker.endDate.format('DD/MM/YYYY'));
        });

        $('.daterange-periode').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        $('#pilihan-lpp').on('change', function () {
            pil = $(this).val();
            $('#prdcd1,#prdcd2,#dep1,#dep2,#kat1,#kat2,#mtr1,#mtr2,#sup1,#sup2,#tipe,#banyakitem').attr('disabled', true);
            $('#btn-prdcd1,#btn-prdcd2,#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-mtr1,#btn-mtr2,#btn-sup1,#btn-sup2,#btn-tipe,#btn-banyakitem').attr('disabled', true);

            switch (pil) {
                case 'LPP02':
                    $('#prdcd1,#prdcd2,#dep1,#dep2,#kat1,#kat2,#tipe').attr('disabled', false);
                    $('#btn-prdcd1,#btn-prdcd2,#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-tipe').attr('disabled', false);
                    break;
                case 'LPP03':
                    $('#prdcd1,#prdcd2,#dep1,#dep2,#kat1,#kat2,#tipe').attr('disabled', false);
                    $('#btn-prdcd1,#btn-prdcd2,#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-tipe').attr('disabled', false);
                    break;
                case 'LPP04':
                    $('#dep1,#dep2,#kat1,#kat2,#tipe').attr('disabled', false);
                    $('#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-tipe').attr('disabled', false);
                    break;
                case 'LPP05':
                    $('#dep1,#dep2,#kat1,#kat2,#tipe,#banyakitem').attr('disabled', false);
                    $('#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-tipe,#btn-banyakitem').attr('disabled', false);
                    break;
                case 'LPP07':
                    $('#dep1,#dep2,#kat1,#kat2,#tipe').attr('disabled', false);
                    $('#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-tipe').attr('disabled', false);
                    break;
                case 'LPP09':
                    $('#prdcd1,#prdcd2,#dep1,#dep2,#kat1,#kat2,#tipe').attr('disabled', false);
                    $('#btn-prdcd1,#btn-prdcd2,#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-tipe').attr('disabled', false);
                    break;
                case 'LPP11':
                    $('#prdcd1,#prdcd2,#dep1,#dep2,#kat1,#kat2,#tipe').attr('disabled', false);
                    $('#btn-prdcd1,#btn-prdcd2,#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-tipe').attr('disabled', false);
                    break;
                case 'LPP13':
                    $('#sup1,#sup2').attr('disabled', false);
                    $('#btn-sup1,#btn-sup2').attr('disabled', false);
                    break;
                case 'LPP14':
                    $('#sup1,#sup2').attr('disabled', false);
                    $('#btn-sup1,#btn-sup2').attr('disabled', false);
                    break;
                case 'LPP15':
                    $('#sup1,#sup2').attr('disabled', false);
                    $('#btn-sup1,#btn-sup2').attr('disabled', false);
                    break;
                default:
                    $('#prdcd1,#prdcd2,#dep1,#dep2,#kat1,#kat2,#mtr1,#mtr2,#sup1,#sup2,#tipe,#banyakitem').attr('disabled', true);
                    $('#btn-prdcd1,#btn-prdcd2,#btn-dep1,#btn-dep2,#btn-kat1,#btn-kat2,#btn-mtr1,#btn-mtr2,#btn-sup1,#btn-sup2,#btn-tipe,#btn-banyakitem').attr('disabled', true);
            }
        });

        function setSelectedObject(obj) {
            this.object = obj;
            console.log(object);
        }

        function getModalDataPLU(value) {
            let tableModal = $('#tableModalDataPLU').DataTable({
                "ajax": {
                    "url": "{{ url('/bo/lpp/register-lpp/getPLU') }}",
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowPLU');
                },
                "order": []
            });

            $('#tableModalDataPLU_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalDataPLU(val);
                }
            });

            $(document).on('click', '.modalRowPLU', function () {
                var currentButton = $(this);
                var plu = currentButton.children().first().text();
                $('#' + object).val(plu);
                $('#m_data_plu').modal('hide');
            });
        }

        function getModalDataDep(value) {
            let tableModalDep = $('#tableModalDataDep').DataTable({
                "ajax": {
                    "url": "{{ url('/bo/lpp/register-lpp/getDep') }}",
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'div_kodedivisi', name: 'div_kodedivisi'},
                    {data: 'div_namadivisi', name: 'div_namadivisi'},
                    {data: 'dep_kodedepartement', name: 'dep_kodedepartement'},
                    {data: 'dep_namadepartement', name: 'dep_namadepartement'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowDep');
                },
                "order": []
            });

            $('#tableModalDataDep_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalDep.destroy();
                    getModalDataDep(val);
                }
            });

            $(document).on('click', '.modalRowDep', function () {
                var currentButton = $(this);
                var dep = currentButton.children().first().next().next().text();
                $('#' + object).val(dep);
                $('#m_data_dep').modal('hide');
            });
        }

        function getModalDataKat(value) {
            let tableModalKat = $('#tableModalDataKat').DataTable({
                "ajax": {
                    "url": "{{ url('/bo/lpp/register-lpp/getKat') }}",
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'dep_kodedepartement', name: 'dep_kodedepartement'},
                    {data: 'dep_namadepartement', name: 'dep_namadepartement'},
                    {data: 'kat_kodekategori', name: 'kat_kodekategori'},
                    {data: 'kat_namakategori', name: 'kat_namakategori'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowKat');
                },
                "order": []
            });

            $('#tableModalDataKat_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalKat.destroy();
                    getModalDataKat(val);
                }
            });

            $(document).on('click', '.modalRowKat', function () {
                var currentButton = $(this);
                var kat = currentButton.children().first().next().next().text();
                $('#' + object).val(kat);
                $('#m_data_kat').modal('hide');
            });
        }

        function getModalDataMtr(value) {
            let tableModalMtr = $('#tableModalDataMtr').DataTable({
                "ajax": {
                    "url": "{{ url('/bo/lpp/register-lpp/getMtr') }}",
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'mpl_kodemonitoring', name: 'mpl_kodemonitoring'},
                    {data: 'mpl_namamonitoring', name: 'mpl_namamonitoring'},
                    {data: 'mpl_prdcd', name: 'mpl_prdcd'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowMtr');
                },
                "order": []
            });

            $('#tableModalDataMtr_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalMtr.destroy();
                    getModalDataMtr(val);
                }
            });

            $(document).on('click', '.modalRowMtr', function () {
                var currentButton = $(this);
                var mtr = currentButton.children().first().text();
                $('#' + object).val(mtr);
                $('#m_data_mtr').modal('hide');
            });
        }

        function getModalDataSup(value) {
            let tableModalSup = $('#tableModalDataSup').DataTable({
                "ajax": {
                    "url": "{{ url('/bo/lpp/register-lpp/getSup') }}",
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},
                    {data: 'sup_namasupplier', name: 'sup_namasupplier'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowSup');
                },
                "order": []
            });

            $('#tableModalDataSup_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalSup.destroy();
                    getModalDataSup(val);
                }
            });

            $(document).on('click', '.modalRowSup', function () {
                var currentButton = $(this);
                var sup = currentButton.children().first().text();
                $('#' + object).val(sup);
                $('#m_data_sup').modal('hide');
            });
        }

        $(document).on('click', '#btn-cetak,#btn-cetak-1', function () {
            var currentButton = $(this);
            cetak1();
        });

        $(document).on('click', '#btn-cetak-2', function () {
            var currentButton = $(this);
            cetak2();
        });

        $(document).on('change', '#pilihan-lpp', function () {
            var currentButton = $(this);
            var menu = currentButton.val();
            if (menu == 'LPP01' || menu == 'LPP02') {
                $('.cetak-2-bagian').show();
                $('.cetak-1-bagian').hide();
            }
            else{
                $('.cetak-2-bagian').hide();
                $('.cetak-1-bagian').show();
            }
        });

        function cetak1() {
            window.open(`{{ url()->current() }}/cetak?menu=${$('#pilihan-lpp').val()}&periode1=${$('#periode1').val()}&periode2=${$('#periode2').val()}&prdcd1=${$('#prdcd1').val()}&prdcd2=${$('#prdcd2').val()}&dep1=${$('#dep1').val()}&dep2=${$('#dep2').val()}&mtr1=${$('#mtr1').val()}&mtr2=${$('#mtr2').val()}&kat1=${$('#kat1').val()}&kat2=${$('#kat2').val()}&sup1=${$('#sup1').val()}&sup2=${$('#sup2').val()}&tipe=${$('#tipe').val()}&banyakitem=${$('#banyakitem').val()}`, '_blank');
        }

        function cetak2() {
            window.open(`{{ url()->current() }}/cetak-bagian-2?menu=${$('#pilihan-lpp').val()}&periode1=${$('#periode1').val()}&periode2=${$('#periode2').val()}&prdcd1=${$('#prdcd1').val()}&prdcd2=${$('#prdcd2').val()}&dep1=${$('#dep1').val()}&dep2=${$('#dep2').val()}&mtr1=${$('#mtr1').val()}&mtr2=${$('#mtr2').val()}&kat1=${$('#kat1').val()}&kat2=${$('#kat2').val()}&sup1=${$('#sup1').val()}&sup2=${$('#sup2').val()}&tipe=${$('#tipe').val()}&banyakitem=${$('#banyakitem').val()}`, '_blank');
        }
    </script>


@endsection

