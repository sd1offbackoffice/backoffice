@extends('navbar')

@section('title','TABEL | PLU Voucher')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">External Voucher Promo</legend>
                            <div class="card-body py-0">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode Voucher</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="kodevoucher">
                                        <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovVoucher()">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-left" id="nilaivoucher" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label text-right pl-0 pr-0">Keterangan</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-left" id="keterangan" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label text-right pl-0 pr-0">Tanggal Berlaku</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" id="tgl1" disabled>
                                    </div>
                                    <label class="col-sm-1 pt-1 text-center">s/d</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" id="tgl2" disabled>
                                    </div>
                                    <button class="col-sm-2 btn btn-primary mr-1" id="" onclick="saveData()">SAVE</button>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">Detail External Voucher Promo</legend>
                            <div class="card-body pt-0">
                                <table class="table table bordered table-sm mt-3" id="table_data">
                                    <thead class="theadDataTables">
                                        <tr class="text-center align-middle">
                                            <th width="5%"></th>
                                            <th width="10%">No Urut</th>
                                            <th width="15%">PLU</th>
                                            <th width="10%">Kode</th>
                                            <th width="60%">Nama Supplier</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="row form-group">
                                    <label for="deskripsi" class="col-sm-1 pr-0 text-left col-form-label">Deskripsi</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control text-left pr-0" id="deskripsi" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-2 pr-0">
                                        <input type="number" class="form-control text-left pr-0" id="find_plu" placeholder="Cari PLU . . .">
                                    </div>
                                    <div class="col-sm-2 pl-0">
                                        <button class="col-sm btn btn-primary" id="" onclick="findPLU()">Find PLU</button>
                                    </div>
                                    <div class="col-sm"></div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" id="" onclick="$('#m_add').modal('show')">Add by Supplier</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" id="" onclick="$('#m_list_supplier').modal('show')">View Supplier</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_voucher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_voucher">
                                    <thead class="thColor">
                                    <tr>
                                        <th class="text-left">Kode Voucher</th>
                                        <th class="text-left">Nilai</th>
                                        <th class="text-left">Keterangan</th>
                                        <th class="text-left">Tanggal Mulai</th>
                                        <th class="text-left">Tanggal Akhir</th>
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

    <div class="modal" id="m_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
{{--                <div class="modal-header">--}}
{{--                    <h4 class="modal-title">Tambah Data</h4>--}}
{{--                </div>--}}
                <div class="modal-body">
                    <div class="container">
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">Add PLU by Supplier</legend>
                            <div class="card-body py-0">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode Supplier</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input type="text" class="form-control text-left" id="add_kodesupplier" onkeypress="getSupplier(event)">
                                        <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovSupplier()">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control text-left" id="add_namasupplier" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm"></div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" id="" onclick="viewPLU()">View PLU</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" id="" onclick="savePLU()">Save PLU</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" id="" onclick="$('#m_add').modal('hide')">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">Detail PLU by Supplier</legend>
                            <div class="card-body pt-0">
                                <table class="table table bordered table-sm mt-3" id="table_supplier_plu">
                                    <thead class="theadDataTables">
                                        <tr class="text-center align-middle">
                                            <th class="text-left">PLU</th>
                                            <th class="text-left">Deskripsi</th>
                                            <th class="text-center">Tag</th>
                                            <th class="text-center">Pilih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_supplier">
                                    <thead class="thColor">
                                    <tr>
                                        <th class="text-left">Nama Supplier</th>
                                        <th class="text-left">Kode Supplier</th>
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

    <div class="modal fade" id="m_list_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Promo ini disponsori oleh (data yang sudah disimpan)</h4>
                </div>
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_list_supplier">
                                    <thead class="thColor">
                                    <tr>
                                        <th class="text-left">Nama Supplier</th>
                                        <th class="text-left">Kode Supplier</th>
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
            $('#kodevoucher').select();

            makeDataTable();

            $('#table_list_supplier').dataTable();
        });

        function makeDataTable(){
            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().destroy();
            }

            $('#table_data').dataTable({
                ordering: false,
                searching: false,
                // lengthChange: false,
                paging: false,
                scrollY: "300px",
                initComplete: function(){
                    $('#table_data tbody tr:eq(-1)').find('.prdcd').select();
                }
            });
        }

        function showLovVoucher(){
            $('#m_voucher').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_voucher')){
                $('#table_voucher').DataTable({
                    "ajax": '{{ url()->current().'/get-lov-voucher' }}',
                    "columns": [
                        {data: 'vcs_namasupplier'},
                        {data: 'nilai'},
                        {data: 'vcs_keterangan'},
                        {data: 'vcs_tglmulai'},
                        {data: 'vcs_tglakhir'},
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).find('td').addClass('text-left');
                        $(row).addClass('row-voucher').css({'cursor': 'pointer'});
                    },
                    "order": [],
                    "initComplete": function () {
                        $(document).on('click', '.row-voucher', function (e) {
                            $('#kodevoucher').val($(this).find('td:eq(0)').html());
                            $('#nilaivoucher').val($(this).find('td:eq(1)').html());
                            $('#keterangan').val($(this).find('td:eq(2)').html());
                            $('#tgl1').val($(this).find('td:eq(3)').html());
                            $('#tgl2').val($(this).find('td:eq(4)').html());

                            $('#m_voucher').modal('hide');

                            getData($('#kodevoucher').val());
                        });
                    }
                });
            }
        }

        function showLovSupplier(){
            $('#m_supplier').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_supplier')){
                $('#table_supplier').DataTable({
                    "ajax": '{{ url()->current().'/get-lov-supplier' }}',
                    "columns": [
                        {data: 'nama'},
                        {data: 'kode'},
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).find('td').addClass('text-left');
                        $(row).addClass('row-supplier').css({'cursor': 'pointer'});
                    },
                    "order": [],
                    "initComplete": function () {
                        $(document).on('click', '.row-supplier', function (e) {
                            $('#add_namasupplier').val($(this).find('td:eq(0)').html());
                            $('#add_kodesupplier').val($(this).find('td:eq(1)').html());

                            $('#m_supplier').modal('hide');

                            // getData($('#kodevoucher').val());
                        });
                    }
                });
            }
        }

        $('#kodevoucher').on('keypress',function(event){
            if(event.which == 13){
                getData($(this).val());
            }
        })

        function getData(kode){
            $.ajax({
                url: '{{ url()->current() }}/get-data',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    kode: kode
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('#kodevoucher').val(response.header.vcs_namasupplier);
                    $('#nilaivoucher').val(response.header.nilai);
                    $('#keterangan').val(response.header.vcs_keterangan);
                    $('#tgl1').val(response.header.vcs_tglmulai);
                    $('#tgl2').val(response.header.vcs_tglakhir);

                    dataPLU = response.detail;

                    getListSupplier();

                    if(dataPLU.length == 0){
                        dataPLU[0] = {
                            'prdcd' : '',
                            'desk' : '',
                            'kodesupplier' : '',
                            'namasupplier' : ''
                        };
                    }

                    fillDetail(dataPLU);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        fillDetail([]);
                        $('#kodevoucher').select();
                    });
                }
            });
        }

        $('#m_add').on('shown.bs.modal',function(){
            if($.fn.DataTable.isDataTable('#table_supplier_plu')){
                $('#table_supplier_plu').DataTable().destroy();
            }

            $('#table_supplier_plu').dataTable({
                ordering: false,
                searching: false,
                lengthChange: false,
                scrollY: "350px",
            });

            $('.cb').prop('checked',false);

            tempPLU = [];
        });

        function viewPLU(){
            supplierPLU = [];

            if($.fn.DataTable.isDataTable('#table_supplier_plu')){
                $('#table_supplier_plu').DataTable().destroy();
            }

            $('#table_supplier_plu').DataTable({
                "ajax": {
                    url: '{{ url()->current().'/get-data-plu-supplier' }}',
                    data: {
                        supplier: $('#add_kodesupplier').val()
                    }
                },
                "columns": [
                    {data: 'prdcd'},
                    {data: 'desk'},
                    {data: 'tag'},
                    {data: null, render: function(data, type, full, meta){
                            return `<div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input cb-plu-supplier cb" id="cb_${data.prdcd}" onclick="checkPLU(event, '${data.prdcd}')">
                                        <label for="cb_${data.prdcd}" class="custom-control-label"></label>
                                    </div>`;
                        }
                    }
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find('td:eq(0)').addClass('text-left');
                    $(row).find('td:eq(1)').addClass('text-left');
                    $(row).find('td:eq(2)').addClass('text-center');
                    $(row).find('td:eq(3)').addClass('text-center');
                    $(row).addClass('nowrap row-plu-supplier');

                    supplierPLU[data.prdcd] = data;
                },
                "order": [],
                "initComplete": function () {
                    $(document).on('change', '.cb-plu-supplier', function (e) {

                    });
                }
            });
        }

        function savePLU(){
            exist = false;

            for(i=0;i<tempPLU.length;i++){
                for(j=0;j<dataPLU.length;j++){
                    if(dataPLU[j].prdcd == tempPLU[i]){
                        exist = true;
                    }
                }

                if(!exist){
                    dataPLU.push({
                        'prdcd' : supplierPLU[tempPLU[i]].prdcd,
                        'desk' : supplierPLU[tempPLU[i]].desk,
                        'kodesupplier' : $('#add_kodesupplier').val(),
                        'namasupplier' : $('#add_namasupplier').val()
                    });
                }
            }

            $('#m_add').modal('hide');

            fillDetail(dataPLU);
        }

        function addRow(){
            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().destroy();
            }

            i = $('#table_data tbody tr').length;

            $('#table_data tbody').append(`
                <tr id="row-data-${i}" onmouseover="showDesc(${i})">
                    <td width="5%" class="align-middle"><button class="btn btn-danger btn-delete" onclick="deleteRow(${i})"><i class="fas fa-times"></i></button></td>
                    <td width="10%" class="align-middle"><input disabled type="text" class="form-control" value="${i+1}"></td>
                    <td width="15%" class="align-middle"><input type="text" maxlength="7" onkeypress="getPLU(${i}, event)" class="form-control prdcd"></td>
                    <td width="10%" class="align-middle"><input disabled class="form-control text-left kodesupplier"></td>
                    <td width="60%" class="align-middle"><input disabled class="form-control text-left namasupplier"></td>
                </tr>
            `);

            dataPLU[i] = {
                'prdcd' : '',
                'desk' : '',
                'kodesupplier' : '',
                'namasupplier' : ''
            };

            $('#table_data').dataTable({
                ordering: false,
                searching: false,
                // lengthChange: false,
                paging: false,
                scrollY: "300px",
                initComplete : function(){
                    $(`#row-data-${i} .prdcd`).select()
                }
            });
        }

        function deleteRow(index){
            dataPLU.splice(index,1);

            if(dataPLU.length == 0){
                dataPLU[0] = {
                    'prdcd' : '',
                    'desk' : '',
                    'kodesupplier' : '',
                    'namasupplier' : ''
                };
            }

            fillDetail(dataPLU);
        }

        function fillDetail(data){
            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().destroy();
            }

            $('#table_data tbody tr').remove()

            if(data){
                for(i=0;i<data.length;i++){
                    $('#table_data tbody').append(`
                        <tr id="row-data-${i}" onmouseover="showDesc(${i})">
                            <td width="5%" class="align-middle"><button class="btn btn-danger btn-delete" onclick="deleteRow(${i})"><i class="fas fa-times"></i></button></td>
                            <td width="10%" class="align-middle"><input disabled type="text" class="form-control" value="${i+1}"></td>
                            <td width="15%" class="align-middle"><input type="text" maxlength="7" onkeypress="getPLU(${i}, event)" class="form-control prdcd" value="${data[i].prdcd}"></td>
                            <td width="10%" class="align-middle"><input disabled class="form-control text-left kodesupplier" value="${data[i].kodesupplier}"></td>
                            <td width="60%" class="align-middle"><input disabled class="form-control text-left namasupplier" value="${data[i].namasupplier}"></td>
                        </tr>
                    `);
                }

                if(data[data.length - 1].prdcd != '')
                    addRow();

                makeDataTable();

                showDesc(data.length-1);
            }
            else{
                dataPLU = [];
            }
        }

        function getPLU(index, event){
            if(event.which == 13){
                found = false;
                plu = convertPlu($('#row-data-'+index).find('.prdcd').val());

                $('#row-data-'+index).find('.prdcd').val(plu);

                for(i=0;i<dataPLU.length;i++){
                    if(dataPLU[i].prdcd == plu && i != index){
                        found = true;
                    }
                }

                if(found){
                    swal({
                        title: 'PLU '+plu+' sudah ada!',
                        icon: 'error'
                    }).then(() => {
                        $(`#row-data-${index} .prdcd`).val(plu).select();
                    });
                }
                else{
                    $.ajax({
                        url: '{{ url()->current() }}/get-plu',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            plu: $('#row-data-'+index).find('.prdcd').val()
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            dataPLU[index] = {
                                'prdcd' : response.prdcd,
                                'desk': response.desk,
                                'kodesupplier' : response.kodesupplier,
                                'namasupplier' : response.namasupplier
                            }

                            $('#row-data-'+index).find('.prdcd').val(dataPLU[index].prdcd);
                            $('#row-data-'+index).find('.kodesupplier').val(dataPLU[index].kodesupplier);
                            $('#row-data-'+index).find('.namasupplier').val(dataPLU[index].namasupplier);

                            if($('#table_data tbody tr:eq(-1)').find('.prdcd').val() != ''){
                                addRow();
                            }
                            else $('#table_data tbody tr:eq(-1)').find('.prdcd').select();
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {
                                $('#row-data-'+index).find('.prdcd').select();
                            });
                        }
                    });
                }
            }
        }

        $('#find_plu').on('keypress',function(event){
            if(event.which == 13){
                findPLU();
            }
        });

        function findPLU(){
            plu = convertPlu($('#find_plu').val());
            $('#find_plu').val(plu).select();

            i = 0;

            $('#table_data tbody tr').each(function(){
                if($(this).find('.prdcd').val() == plu){
                    $(this).find('.prdcd').focus().select();
                    showDesc(i);
                }
                i++;
            });
        }

        function checkPLU(event, prdcd){
            if($(event.target).is(':checked')){
                tempPLU.push(prdcd);
            }
            else tempPLU.splice(tempPLU.indexOf(prdcd),1);
        }

        function getSupplier(event){
            if(event.which == 13){
                $.ajax({
                    url: '{{ url()->current() }}/get-supplier',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        kodesupplier: $('#add_kodesupplier').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        $('#add_kodesupplier').val(response.kode);
                        $('#add_namasupplier').val(response.nama);
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');

                        swal({
                            title: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {
                            $('#add_namasupplier').val('');
                            $('#add_kodesupplier').select();
                        });
                    }
                });
            }
        }

        function showDesc(index){
            $('#deskripsi').val(decodeHtml(nvl(dataPLU[index].desk, '')));
        }

        function saveData(){
            swal({
                title: 'Yakin ingin menyimpan data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    $.ajax({
                        url: '{{ url()->current() }}/save-data',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            kodevoucher : $('#kodevoucher').val(),
                            dataPLU : dataPLU
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.message,
                                icon: 'success',
                            }).then(() => {
                                getListSupplier();
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.message,
                                text: error.responseJSON.detail,
                                icon: 'error',
                            }).then(() => {

                            });
                        }
                    });
                }
            })
        }

        function getListSupplier(){
            if($.fn.DataTable.isDataTable('#table_list_supplier')){
                $('#table_list_supplier').DataTable().destroy();
            }

            $('#table_list_supplier').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-list-supplier' }}',
                    'data' : {
                        kodevoucher: $('#kodevoucher').val()
                    }
                },
                "columns": [
                    {data: 'namasupplier'},
                    {data: 'kodesupplier'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find('td').addClass('text-left');
                },
                "order": [],
                "initComplete": function () {

                }
            });
        }
    </script>
@endsection
