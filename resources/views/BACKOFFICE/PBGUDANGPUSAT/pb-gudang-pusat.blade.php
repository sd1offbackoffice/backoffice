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
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_prdcd">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <label for="prdcd" class="text-center col-form-label">S/D</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="prdcd2" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_prdcd">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-9"></div>
                            <button class="col-sm-2 btn btn-primary">PROSES PB</button>
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
        var dataDetail = [];
        var dataPrdcd = [];

        var fieldDep = 1;
        var fieldKat = 1;

        $(document).ready(function(){
            $('.tanggal').MonthPicker({
                Button: false
            });

            // getDivisi();
            // getPRDCD();
            // getMonitoring();
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

                        getDetail('prdcd');
                    });
                }
            });
        }

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
            $('#d_user').val('{{ $_SESSION['usertype'] }}');

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
                    {data: 'pkm_mindisplay'},
                    {data: 'maxd'},
                    {data: 'pkm_qtyaverage'},
                    {data: 'pkm_leadtime'},
                    {data: 'pkm_koefisien'},
                    {data: 'hari'},
                    {data: 'pkm_pkm', render: function(data, type, full, meta){
                            return '<input class="text-right row-pkm" onkeypress="changePKM(event, '+meta.row+')" style="width: 5vw" value="' + data + '">';
                        }
                    },
                    {data: 'pkm_mpkm'},
                    {data: 'pkm_pkmt'},
                    {data: 'nplus'},
                    {data: 'pkmx'},
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
                    {{--if('{{ $_SESSION['usertype'] }}' == 'XXX'){--}}
                    {{--$('.row-pkm').prop('disabled',true);--}}
                    {{--}--}}
                    {{--else $('.row-pkm').prop('disabled',false);--}}

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
            $('#min').val(dataDetail[i].min);
            $('#dsi').val(dataDetail[i].dsi);
            $('#top').val(dataDetail[i].jtopa);
            $('#maxpalet').val(dataDetail[i].maxpalet);
            $('#sup_kode').val(dataDetail[i].sup_kodesupplier);
            $('#sup_nama').val(decodeHtml(dataDetail[i].sup_namasupplier));
            $('#mplus').val(dataDetail[i].mplus);
            $('#omi').val(dataDetail[i].omi);
            $('#bln1').val(dataDetail[i].bln1);
            $('#bln2').val(dataDetail[i].bln2);
            $('#bln3').val(dataDetail[i].bln3);
            $('#qty1').val(dataDetail[i].pkm_qty1);
            $('#qty2').val(dataDetail[i].pkm_qty2);
            $('#qty3').val(dataDetail[i].pkm_qty3);
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



            tag = ['N','H','O','X','A','G'];

            for(i=0;i<dataDetail.length;i++){
                // console.log($.inArray(dataDetail[i].prd_kodetag, tag));
                if($.inArray(dataDetail[i].prd_kodetag, tag) == -1){
                    ndsi1 += parseFloat(dataDetail[i].pkmx);
                    ntop += parseFloat(dataDetail[i].jtopa);
                    nmin_rp += parseFloat(dataDetail[i].min);
                    nmid_rp += parseFloat(dataDetail[i].pkm_mindisplay);
                }

                ndsi2 += parseFloat(dataDetail[i].pkm_qtyaverage);
                nrph1 += parseFloat(dataDetail[i].pkm_qtyaverage);

            }

            console.log('ndsi1 : ' + ndsi1);
            console.log('ndsi2 : ' + ndsi2);

            $('#dsikat').val(ndsi2 === 0 ? 0 : Math.round(ndsi1/ndsi2));
            $('#topkat').val(nrph1 === 0 ? 0 : Math.round(ntop/nrph1));
            $('#mindis').val(ndsi2 === 0 ? 0 : Math.round(nmid_rp/ndsi2));
            $('#minor').val(ndsi2 === 0 ? 0 : Math.round(nmin_rp/ndsi2));
        }

    </script>

@endsection
