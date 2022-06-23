@extends('navbar')

@section('title','PKM | ENTRY & INQUERY KERTAS KERJA PKM')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">ENTRY & INQUERY KERTAS KERJA PKM</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">PLU</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="prdcd">
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_prdcd">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="desk" class="col-sm-3 text-right col-form-label">DESKRIPSI</label>
                            <div class="col-sm-7 pr-0">
                                <input type="text" class="form-control" id="desk" disabled>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="unit" disabled>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">DIVISI</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="div_kode" disabled>
                                {{-- value="1" --}}
                                <button id="btn_divisi" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_divisi">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-5 pl-0 pr-0">
                                <input maxlength="10" type="text" class="form-control" id="div_nama" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">DEPARTEMENT</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="dep_kode" disabled>
                                {{-- value="01" --}}
                                <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_departement">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-5 pl-0 pr-0">
                                <input maxlength="10" type="text" class="form-control" id="dep_nama" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">KATEGORI BARANG</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="kat_kode" disabled>
                                {{-- value="01" --}}
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_kategori">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-5 pl-0 pr-0">
                                <input maxlength="10" type="text" class="form-control" id="kat_nama" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="sales3" class="col-sm-3 text-right col-form-label">ITEM</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="item" onchange="cekItem()">
                                    <option value="-" selected disabled>Pilih item</option>
                                    <option value="1">1 - NASIONAL</option>
                                    <option value="2">2 - OMI / IDM</option>
                                </select>
                            </div>
                            <div class="col-sm-2 pl-0 pr-0">
                                <button type="button" class="btn btn-md btn btn-primary" id="btnItem" onclick="itemDetail()">CEK DETAIL</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">KODE MONITORING PLU</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="mon_kode" disabled>
                                <button id="btn_monitoring" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_monitoring">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-5 pl-0 pr-0">
                                <input maxlength="10" type="text" class="form-control" id="mon_nama" disabled>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="detail_view" style="display: none">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">ENTRY & INQUERY KERTAS KERJA PKM</legend>
                    <div class="card-body">
                        <div class="row">
                            <button class="ml-4 col-sm-1 btn btn-primary" onclick="showMainView()">BACK</button>
                            <label for="desk" class="mon col-sm-2 text-right col-form-label">MONITORING</label>
                            <div class="col-sm-3">
                                <input type="text" class="mon form-control" id="mon" disabled>
                            </div>
                            <div class="col"></div>
                            <label for="desk" class="dsikat col-sm-3 text-right col-form-label">DSI KAT</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="dsikat" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label for="desk" class="div col-sm-2 text-right col-form-label">DIVISI</label>
                            <div class="col-sm-3">
                                <input type="text" class="div form-control" id="div" disabled>
                            </div>
                            <div class="col"></div>
                            <label for="desk" class="col-sm-3 text-right col-form-label">TOP KAT</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="topkat" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label for="desk" class="dep col-sm-2 text-right col-form-label">DEPARTEMENT</label>
                            <div class="col-sm-3">
                                <input type="text" class="dep form-control" id="dep" disabled>
                            </div>
                            <div class="col"></div>
                            <label for="desk" class="col-sm-3 text-right col-form-label">MIN DISPLAY</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="mindis" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="desk" class="kat col-sm-2 text-right col-form-label">KATEGORI</label>
                            <div class="col-sm-3">
                                <input type="text" class="kat form-control" id="kat" disabled>
                            </div>
                            <div class="col"></div>
                            <label for="desk" class="col-sm-3 text-right col-form-label">MINOR</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="minor" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="" class="d_prdcd col-sm-2 text-right col-form-label">PLU</label>
                            <div class="col-sm-1">
                                <input type="text" class="d_prdcd form-control" id="d_prdcd" disabled>
                            </div>
                            <label for="desk" class="col-sm-4 text-right col-form-label">USER</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="d_user" value="{{ Session::get('usertype') != 'XXX' ? Session::get('usertype') : ''}} " disabled>
                            </div>
                            <label for="desk" class="col-sm-2 text-right col-form-label">KETERANGAN</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="ketnewplu" disabled>
                            </div>
                        </div>
                        <div class="row form-group d-flex justify-content-end">
                            <label for="desk" class="ndsi1 text-right col-form-label">NDSI 1</label>
                            <div class="col-sm-1">
                                <input type="text" class="ndsi1 form-control" id="ndsi1" disabled>
                            </div>
                            {{-- <label for="" class="dividen col-form-label" style="margin-right: 15px;"><center>/</center></label> --}}
                            <label for="desk" class="ndsi2 text-right col-form-label">NDSI 2</label>
                            <div class="col-sm-1">
                                <input type="text" class="ndsi2 form-control" id="ndsi2" disabled>
                            </div>
                            <label for="desk" class="ntop text-right col-form-label">NTOP</label>
                            <div class="col-sm-1">
                                <input type="text" class="ntop form-control" id="ntop" disabled>
                            </div>
                            {{-- <label for="desk" class="nrph1 text-right col-form-label">NRPH1</label>
                            <div class="col-sm-1">
                                <input type="text" class="nrph1 form-control" id="nrph1" disabled>
                            </div> --}}
                            <label for="desk" class="nrph1 text-right col-form-label">NRPH1</label>
                            <div class="col-sm-1">
                                <input type="text" class="nrph1 form-control" id="nrph1" disabled>
                            </div>
                            <label for="desk" class="nmid_rp text-right col-form-label">NMID RP</label>
                            <div class="col-sm-1">
                                <input type="text" class="nmid_rp form-control" id="nmid_rp" disabled>
                            </div>
                            <label for="desk" class="nmin_rp text-right col-form-label">NMIN RP</label>
                            <div class="col-sm-1">
                                <input type="text" class="nmin_rp form-control" id="nmin_rp" disabled>
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <table class="table table-sm mb-0 text-right" id="table_detail">
                                <thead class="text-center thColor">
                                <tr>
                                    <th>PLU</th>
                                    <th>MDIS</th>
                                    <th>MAX D</th>
                                    <th>A_SLS</th>
                                    <th>LT</th>
                                    <th>KOEF</th>
                                    <th>HARI_SALES</th>
                                    <th>PKM</th>
                                    <th>MPKM</th>
                                    <th>PKMT</th>
                                    <th>N+</th>
                                    <th>PKMX</th>
                                    <th>SLP</th>
                                    <th>STS</th>
                                    <th>% SL</th>
                                </tr>
                                </thead>
                                <tbody id="">
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                        <hr>
                        <div class="row mt-1">
                            <label for="desk" class="col-sm-1 text-right col-form-label">Deskripsi</label>
                            <div class="col-sm-5">
                                <input maxlength="10" type="text" class="form-control" id="d_desk" disabled>
                            </div>
                            <div class="col-sm-1 pl-0">
                                <input maxlength="10" type="text" class="form-control text-center" id="d_unit" disabled>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="desk" class="col-sm-1 text-right col-form-label">TAG</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="tag" disabled>
                            </div>
                            <label for="desk" class="ml-3 text-right col-form-label">MIN</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="min" disabled>
                            </div>
                            <label for="desk" class="ml-3 text-right col-form-label">DSI</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="dsi" disabled>
                            </div>
                            <label for="desk" class="ml-3 text-right col-form-label">TOP</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="top" disabled>
                            </div>
                            <label for="desk" class="ml-3 text-right col-form-label">MAX PALET</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="maxpalet" disabled>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="desk" class="col-sm-1 text-right col-form-label">Supplier</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="sup_kode" disabled>
                            </div>
                            <div class="col-sm-5 pl-0">
                                <input maxlength="10" type="text" class="form-control" id="sup_nama" disabled>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col">
                                MPKM = nilai PKM hasil perhitungan
                            </div>
                        </div>
                        <div class="row mt-1">
                            <label for="desk" class="col-sm-1 text-right col-form-label">Qty M+</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="mplus" disabled>
                            </div>
                            <label for="desk" class="col-sm-1 text-right col-form-label">OMI</label>
                            <div class="col-sm-1 pl-0">
                                <input maxlength="10" type="text" class="form-control text-center" id="omi" disabled>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-1 pl-0">
                                <input maxlength="10" type="text" class="form-control text-right" id="bln3" disabled>
                            </div>
                            <div class="col-sm-1 pl-0">
                                <input maxlength="10" type="text" class="form-control text-right" id="bln2" disabled>
                            </div>
                            <div class="col-sm-1 pl-0">
                                <input maxlength="10" type="text" class="form-control text-right" id="bln1" disabled>
                            </div>
                            <div class="col">
                                PKM = nilai PKM hasil perhitungan / adjust
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-3">
                                <input maxlength="10" type="text" class="form-control" id="kettag" disabled>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col-sm-1 pl-0">
                                <input maxlength="10" type="text" class="form-control text-right" id="qty3" disabled>
                            </div>
                            <div class="col-sm-1 pl-0">
                                <input maxlength="10" type="text" class="form-control text-right" id="qty2" disabled>
                            </div>
                            <div class="col-sm-1 pl-0">
                                <input maxlength="10" type="text" class="form-control text-right" id="qty1" disabled>
                            </div>
                            <div class="col">
                                PKMT = PKM + Mplus
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="editplubaru" disabled>
                            </div>
                            <div class="col-sm-2"></div>
                            <div class="col">
                                PKMX = PKMT + Nplus
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
        var dataDetail = [];
        var dataPrdcd = [];

        $(document).ready(function(){
            $('.tanggal').MonthPicker({
                Button: false
            });

            // getDivisi();
            // getPRDCD();
            // getMonitoring();
        });

        $('#prdcd').keypress(function (e) {
            if (e.keyCode == 13) {
                plu = $(this).val();
                if (plu.length < 7) {
                    plu = convertPlu($(this).val());
                }
                $(this).val(plu);
                $('#prdcd').val(plu);
                getDetail('prdcd');
            }
        });

        $('#m_prdcd').on('shown.bs.modal',function(){
            if(!$.fn.DataTable.isDataTable('#table_prdcd')){
                getPRDCD();
            }
        });

        function getPRDCD(){
            $('#table_prdcd').DataTable({
                "ajax": '{{ url()->current().'/get-lov-prdcd' }}',
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
                        $('#prdcd').val($(this).find('td:eq(1)').html());
                        $('#desk').val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));
                        $('#unit').val($(this).find('td:eq(2)').html());

                        $('#m_prdcd').modal('hide');

                        // getDetail('prdcd');
                    });
                }
            });
        }

        $('#m_divisi').on('shown.bs.modal',function(){
            if(!$.fn.DataTable.isDataTable('#table_divisi')){
                getDivisi();
            }
        });

        function getDivisi(){
            if($.fn.DataTable.isDataTable('#table_divisi')){
                $('#table_divisi').DataTable().destroy();
            }

            $("#table_divisi tbody [role='row']").remove();

            lovutuh = $('#table_divisi').DataTable({
                "ajax": '{{ url()->current().'/get-lov-divisi' }}',
                "columns": [
                    {data: 'div_namadivisi'},
                    {data: 'div_kodedivisi'},
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
                    $(row).addClass('row-divisi').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    // $('#btn_divisi').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-divisi', function (e) {
                        $('#div_kode').val($(this).find('td:eq(1)').html());
                        $('#div_nama').val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));

                        getDepartement();

                        $('#m_divisi').modal('hide');
                    });
                }
            });
        }

        function getDepartement(){
            if(!$('#div_kode').val()){
                swal({
                    title: 'Pilih Divisi terlebih dahulu!',
                    icon: 'warning'
                });
            }
            else{
                if($.fn.DataTable.isDataTable('#table_departement')){
                    $('#table_departement').DataTable().destroy();
                }

                $("#table_departement tbody [role='row']").remove();

                lovutuh = $('#table_departement').DataTable({
                    "ajax": {
                        url: '{{ url()->current().'/get-lov-departement' }}',
                        data: {
                            kodedivisi: $('#div_kode').val()
                        }
                    },
                    "columns": [
                        {data: 'dep_namadepartement'},
                        {data: 'dep_kodedepartement'},
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
                            $('#dep_kode').val($(this).find('td:eq(1)').html());
                            $('#dep_nama').val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));

                            getKategori();

                            $('#m_departement').modal('hide');
                        });
                    }
                });
            }
        }

        function getKategori(){
            if(!$('#dep_kode').val()){
                swal({
                    title: 'Pilih Departement terlebih dahulu!',
                    icon: 'warning'
                });
            }
            else{
                if($.fn.DataTable.isDataTable('#table_kategori')){
                    $('#table_kategori').DataTable().destroy();
                }

                $("#table_kategori tbody [role='row']").remove();

                lovutuh = $('#table_kategori').DataTable({
                    "ajax": {
                        url: '{{ url()->current().'/get-lov-kategori' }}',
                        data: {
                            kodedepartement: $('#dep_kode').val()
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
                            $('#kat_kode').val($(this).find('td:eq(1)').html());
                            $('#kat_nama').val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));

                            $('#m_kategori').modal('hide');
                        });
                    }
                });
            }
        }

        $('#m_monitoring').on('shown.bs.modal',function(){
            if(!$.fn.DataTable.isDataTable('#table_monitoring')){
                getMonitoring();
            }
        });

        function getMonitoring(){
            if($.fn.DataTable.isDataTable('#table_monitoring')){
                $('#table_monitoring').DataTable().destroy();
            }

            $("#table_monitoring tbody [role='row']").remove();

            lovutuh = $('#table_monitoring').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-lov-monitoring' }}',
                    data: {

                    }
                },
                "columns": [
                    {data: 'mpl_namamonitoring'},
                    {data: 'mpl_kodemonitoring'},
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
                    $(row).addClass('row-monitoring').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $(document).on('click', '.row-monitoring', function (e) {
                        $('#mon_kode').val($(this).find('td:eq(1)').html());
                        $('#mon_nama').val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));

                        $('#m_monitoring').modal('hide');

                        getDetail('monitoring');
                    });
                }
            });
        }

        function cekItem(){
            if(!$('#kat_kode').val()){
                swal({
                    title: 'Pilih Kategori terlebih dahulu!',
                    icon: 'warning'
                });
                $('#item').val('-');
            }
            // else{
            //     getDetail('divdepkat');
            // }
        }

        function itemDetail()
        {
            console.log($('#div_kode').val() == '' || $('#dept_kode').val() == '' || $('#kat_kode').val() == '' || $('#kat_kode').val() == '');
            if($('#div_kode').val() == '' || $('#dept_kode').val() == '' || $('#kat_kode').val() == '' || $('#kat_kode').val() == '' )
            {
                swal({
                    title : 'Kolom input divisi/departement/kategori/item tidak boleh kosong !',
                    icon : 'warning'
                });
            }
            else{
                getDetail('divdepkat');
            }
        }

        function showMainView(){
            $('#main_view input').val('');
            $('#item').val('-');

            $('#main_view').show();
            $('#detail_view').hide();
        }

        function getDetail(type){
            $('#detail_view input').val('');
            $('#d_user').val('{{ Session::get('usertype') != 'XXX' ? Session::get('usertype') : '' }}');

            $('.d_prdcd').hide();

            if(type == 'prdcd'){
                data = {
                    prdcd: $('#prdcd').val()
                };

                $('.d_prdcd').show();
                $('.dep').hide();
                $('.kat').hide();
                $('.div').hide();
                $('.mon').hide();
                // $('.ndsi1').hide();
                // $('.ndsi2').hide();
                // $('.ntop').hide();
                // $('.nrph1').hide();
                // $('.nmid_rp').hide();
                // $('.nmin_rp').hide();
            }
            else if(type == 'divdepkat'){
                $('#div').val($('#div_kode').val() + ' - ' + $('#div_nama').val());
                $('#dep').val($('#dep_kode').val() + ' - ' + $('#dep_nama').val());
                $('#kat').val($('#kat_kode').val() + ' - ' + $('#kat_nama').val());

                data = {
                    item: $('#item').val(),
                    div: $('#div_kode').val(),
                    dep: $('#dep_kode').val(),
                    kat: $('#kat_kode').val()
                };

                $('.dep').show();
                $('.kat').show();
                $('.div').show();
                $('.mon').hide();
            }
            else{
                $('#mon').val($('#mon_kode').val() + ' - ' + $('#mon_nama').val());

                data = {
                    mon: $('#mon_kode').val()
                };

                $('.dep').hide();
                $('.kat').hide();
                $('.div').hide();
                $('.mon').show();
                // $('.ndsi1').hide();
                // $('.ndsi2').hide();
                // $('.dividen').hide();
                // $('.ntop').hide();
                // $('.nrph1').hide();
                // $('.nmid_rp').hide();
                // $('.nmin_rp').hide();
            }

            dataDetail = [];
            dataPrdcd = [];
            $('#main_view').hide();
            $('#detail_view').show();

            if($.fn.DataTable.isDataTable('#table_detail')){
                $('#table_detail').DataTable().destroy();
            }

            $("#table_detail tbody [role='row']").remove();

            $('#table_detail').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-detail' }}',
                    data: data,
                    beforeSend: function(){
                        $('#modal-loader').modal('show');
                    }
                },
                "columns": [
                    {data: 'pkm_prdcd'},
                    {data: null, render: function(data){
                            return convertToRupiah2(data.pkm_mindisplay);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.maxd);
                        }
                    },
                    {data: null, render: function(data){
                            return data.pkm_qtyaverage;
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.pkm_leadtime);
                        }
                    },
                    {data: null, render: function(data){
                            return parseFloat(data.pkm_koefisien).toFixed(1);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.hari);
                        }
                    },
                    {data: 'pkm_pkm', render: function(data, type, full, meta){
                            return `<input class="text-right row-pkm" onkeypress="changePKM(event, ${meta.row})" style="width: 5vw" value="${convertToRupiah2(data)}">`;
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.pkm_mpkm);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.pkm_pkmt);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.nplus);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.pkmx);
                        }
                    },
                    {data: 'slp'},
                    {data: 'hgb_statusbarang'},
                    {data: 'slv_servicelevel_qty'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    data.txt_acost = data.prd_avgcost;
                    data.txt_unit3 = data.prd_unit;
                    data.txt_frac = data.prd_frac;
                    data.txt_ndsi1 = 0;
                    data.txt_ndsi2 = 0;
                    data.txt_ntop = 0;
                    data.txt_nmin_rp = 0;
                    data.txt_nmid_rp = 0;
                    data.txt_nrph1 = 0;
                    dataDetail.push(data);
                    dataPrdcd.push(data.pkm_prdcd);

                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-detail').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    // {{--if('{{ Session::get('usertype') }}' == 'XXX'){--}}
                    //     {{--$('.row-pkm').prop('disabled',true);--}}
                    // {{--}--}}
                    // {{--else $('.row-pkm').prop('disabled',false);--}}

                    $('.row-pkm').prop('disabled',false);

                    $('#modal-loader').modal('hide');

                    $(document).on('click', '.row-detail', function (e) {
                        $('.clicked').removeClass('clicked');
                        $(this).addClass('clicked');
                        showDesc($(this).find('td:eq(0)').html());
                    });

                    setTopRight();

                    // $(document).on('keypress', '.row-pkm', function (e) {
                    //     changePKM(e);
                    // });

                    showDesc(dataDetail[0].pkm_prdcd);
                }
            });

            $('#table_detail_wrapper').css('width','100%');
        }

        function showDesc(prdcd){
            i = $.inArray(prdcd,dataPrdcd);

            $('#d_prdcd').val(dataDetail[i].pkm_prdcd);
            $('#d_desk').val(decodeHtml(dataDetail[i].prd_deskripsipanjang));
            $('#d_unit').val(dataDetail[i].unit);
            $('#tag').val(dataDetail[i].prd_kodetag);
            $('#min').val(convertToRupiah2(dataDetail[i].min));
            $('#dsi').val(convertToRupiah2(dataDetail[i].dsi));
            $('#top').val(convertToRupiah2(dataDetail[i].jtopa));
            $('#maxpalet').val(convertToRupiah2(dataDetail[i].maxpalet));
            $('#sup_kode').val(dataDetail[i].sup_kodesupplier);
            $('#sup_nama').val(decodeHtml(dataDetail[i].sup_namasupplier));
            $('#mplus').val(convertToRupiah2(dataDetail[i].mplus));
            $('#omi').val(dataDetail[i].omi);
            $('#bln1').val(dataDetail[i].bln1);
            $('#bln2').val(dataDetail[i].bln2);
            $('#bln3').val(dataDetail[i].bln3);
            $('#qty1').val(convertToRupiah2(dataDetail[i].pkm_qty1));
            $('#qty2').val(convertToRupiah2(dataDetail[i].pkm_qty2));
            $('#qty3').val(convertToRupiah2(dataDetail[i].pkm_qty3));
            $('#kettag').val(dataDetail[i].kettag);
            $('#ketnewplu').val(dataDetail[i].ketnewplu);
            if(dataDetail[i].ketnewplu != ''){
                $('.row-pkm').prop('disabled',true);
                $('#editplubaru').val('PLU Terdaftar Sbg Produk Baru, Update Via Menu Inquiry Monitoring Produk Baru');
            }
            else{
                $('#editplubaru').val('');
            }
        }

        function changePKM(e, index){
            if(e.which == 13){
                updateOK = true;
                oldPkm = dataDetail[index].pkm_pkm;
                pkm = $(e.target).val();
                pkmt = parseInt(pkm ) + parseInt(dataDetail[index].mplus);
                mpkm = Math.round(dataDetail[index].pkm_mpkm);
                prdcd = dataDetail[index].pkm_prdcd;

                $.ajax({
                    url: '{{ url()->current() }}/change-pkm',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        prdcd: prdcd,
                        pkm: pkm,
                        pkmt: pkmt,
                        mpkm: mpkm
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        swal({
                            title: response.title,
                            icon: response.status,
                        });

                        if(response.status === 'error')
                            $(e.target).val(oldPkm);
                        else{
                            dataDetail[index].pkm_pkmt = pkmt;
                            dataDetail[index].pkmx = pkmt + parseInt(dataDetail[index].nplus);

                            $(e.target).parent().parent().find('td:eq(9)').html(pkmt);
                            $(e.target).parent().parent().find('td:eq(11)').html(dataDetail[index].pkmx);

                            dsi = Math.round((pkmt + parseInt(dataDetail[index].nplus)) / parseFloat(dataDetail[index].pkm_qtyaverage));
                            $('#dsi').val(dsi);
                            dataDetail[index].dsi = dsi;

                            setTopRight();
                        }
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

        function setTopRight(){
            ndsi1 = 0;
            ntop = 0;
            nmin_rp = 0;
            nmid_rp = 0;
            ndsi2 = 0;
            nrph1 = 0;
            acost = 0;

            tag = ['N','H','O','X','A','G'];

            for(i=0;i<dataDetail.length;i++){
              
                if($.inArray(dataDetail[i].prd_kodetag, tag) == -1){
                    acost = parseInt(parseFloat(dataDetail[i].prd_avgcost) / (dataDetail[i].prd_unit == 'KG' ? 1 : parseInt(dataDetail[i].prd_frac)));

                    ndsi1 += parseFloat((dataDetail[i].pkmx) * acost);
                    ntop += (parseFloat(dataDetail[i].jtopa) * acost);
                    nmin_rp += (parseFloat(dataDetail[i].min) * acost);
                    nmid_rp += (parseFloat(dataDetail[i].pkm_mindisplay) * acost);
                }

                ndsi2 += parseFloat(dataDetail[i].pkm_qtyaverage) * acost;
                nrph1 += parseFloat(dataDetail[i].pkm_qtyaverage) * acost;

            }

            // console.log('ndsi1 : ' + ndsi1);
            // console.log('ndsi2 : ' + ndsi2);
            // console.log(Math.floor(ndsi1/ndsi2));
            // console.log(ntop/nrph1);
            // console.log(nmid_rp/ndsi2);
            // console.log(nmin_rp/ndsi2);

            $('#ndsi1').val((ndsi1));
            $('#ndsi2').val((ndsi2));
            $('#ntop').val((ntop));
            $('#nrph1').val((nrph1));
            $('#nmid_rp').val((nmid_rp));
            $('#nmin_rp').val((nmin_rp));
            $('#dsikat').val(ndsi2 === 0 ? 0 : Math.round(ndsi1/ndsi2));
            $('#topkat').val(nrph1 === 0 ? 0 : Math.round(ntop/nrph1));
            $('#mindis').val(ndsi2 === 0 ? 0 : Math.round(nmid_rp/ndsi2));
            $('#minor').val(ndsi2 === 0 ? 0 : Math.round(nmin_rp/ndsi2));
        }

    </script>

@endsection
