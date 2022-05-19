@extends('navbar')
@section('title','PB | MASTER ITEM PB MANUAL')
@section('content')

    <div id="master" class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Item PB Manual</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-sm-2"></div>
                            <label class="col-sm-1 text-right col-form-label pl-0">Periode</label>
                            <input type="text" class="col-sm-7 form-control text-center" id="tanggal" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                            <div class="col-sm"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <table class="table table-sm mb-0 text-center" id="pbProductTable">
                                    <thead class="thColor">
                                    <tr>
                                        <th width="15%">PLU</th>
                                        <th width="65%">Deskripsi</th>
                                        <th width="20%">Unit / Frac</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <div class="col-sm-2">
                                <button class="col btn btn-success" onclick="savePBData()">SIMPAN PLU</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-secondary" onclick="showField('draft')">DRAFT PB</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-primary" id="btnPrintItem" onclick="printItem()">CETAK ITEM</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-primary" id="btnPrintPB" onclick="printPB()">CETAK PB</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div id="draft" class="container-fluid" style="display: none">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Inputan Draft PB Manual</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pl-0">Nomor Draft PB</label>
                            <div class="buttonInside">
                                <input type="text" class="form-control" autocomplete="off" maxlength="" id="draftNo">
                                <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_pbDraftList">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm"></div>
                            <input type="text" class="col-sm-3 form-control text-right" id="info" disabled>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pl-0">Tgl Draft PB</label>
                            <input type="text" class="col-sm-1 form-control text-right" id="draftDate" disabled>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pl-0">Keterangan</label>
                            <input type="text" class="col-sm-3 form-control text-left" id="draftInfo">
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pl-0">Autorisasi Tertinggi</label>
                            <input type="text" class="col-sm-2 form-control text-left" id="draftHighestAuth" disabled>
                            <div class="col-sm"></div>
                            <div class="col-sm-2">
                                <button class="col btn btn-danger" onclick="deletePBDraft()">DELETE DRAFT PB</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-success" onclick="checkProcessDraft()">PROSES PB</button>
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-primary" onclick="showField('master')">BACK</button>
                            </div>
                        </div>
                        <fieldset class="card border-secondary">
                            <legend  class="w-auto ml-5">Detail Draft PB Manual</legend>
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col">
                                        <table class="table table-sm mb-0 text-center" id="pbDraftTable">
                                            <thead class="thColor">
                                            <tr>
                                                <th rowspan="2">PRDCD</th>
                                                <th rowspan="2">MINOR QTY<br>in PCS</th>
                                                <th rowspan="2">MINOR QTY<br>in CTN</th>
                                                <th rowspan="2">MINOR RPH<br>PER SUPP</th>
                                                <th rowspan="2">MAX<br>PALET</th>
                                                <th rowspan="2">CTN</th>
                                                <th rowspan="2">PCS</th>
                                                <th rowspan="2">Hrg. Satuan</th>
                                                <th colspan="2">DICS. I</th>
                                                <th colspan="2">DICS. II</th>
                                                <th rowspan="2">BNS 1</th>
                                                <th rowspan="2">BNS 2</th>
                                                <th rowspan="2">NILAI</th>
                                                <th rowspan="2">PPN</th>
                                                <th rowspan="2">PPNBM</th>
                                                <th rowspan="2">BOTOL</th>
                                                <th rowspan="2">TOTAL</th>
                                            </tr>
                                            <tr>
                                                <th>RPH</th>
                                                <th>%</th>
                                                <th>RPH</th>
                                                <th>%</th>
                                            </tr>
                                            </thead>
                                            <tbody id="">
                                            </tbody>
                                            <tfoot></tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div id="draftDetail">
                            <div class="row form-group mt-3">
                                <label class="col-sm-1 text-right col-form-label pl-0">DESKRIPSI</label>
                                <input type="text" class="col-sm-3 form-control text-left" id="draftDesc" disabled>
                                <input type="text" class="col-sm-1 form-control text-left" id="draftUnit" disabled>
                                <div class="col-sm"></div>
                                <label class="col-sm-1 text-center col-form-label pl-0">OMI</label>
                                <label class="col-sm-1 text-center col-form-label pl-0">IDM</label>
                                <label class="col-sm-1 text-center col-form-label pl-0">HARGA JUAL</label>
                                <label class="col-sm-1 text-center col-form-label pl-0">PKMT (PCS)</label>
                                <label class="col-sm-1 text-center col-form-label pl-0">STOCK (PCS)</label>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-1 text-right col-form-label pl-0">SUPPLIER</label>
                                <input type="text" class="col-sm-1 form-control text-left" id="draftSupplierCode" disabled>
                                <input type="text" class="col-sm-3 form-control text-left" id="draftSupplierName" disabled>
                                <div class="col-sm"></div>
                                <input type="text" class="col-sm-1 form-control text-center" id="omi" disabled>
                                <input type="text" class="col-sm-1 form-control text-center" id="idm" disabled>
                                <input type="text" class="col-sm-1 form-control text-right" id="hargajual" disabled>
                                <input type="text" class="col-sm-1 form-control text-right" id="pkmt" disabled>
                                <input type="text" class="col-sm-1 form-control text-right" id="stock" disabled>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-4">
                                    <div class="col-sm-6">
                                        <button id="btnSaveDraft" class="col btn btn-success" onclick="saveDraft()">SIMPAN DATA</button>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row form-group">
                                        <label class="col-sm-3 text-right col-form-label pl-0">BONUS 1 :</label>
                                        <label class="col-sm-2 text-left col-form-label pl-0">Masa berlaku</label>
                                        <input type="text" class="col-sm-3 form-control text-center" id="bonus1date1" disabled>
                                        <label class="col-sm-1 text-center col-form-label pl-0">s/d</label>
                                        <input type="text" class="col-sm-3 form-control text-center" id="bonus1date2" disabled>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-3 text-right col-form-label pl-0"></label>
                                        <input type="text" class="col-sm form-control text-center" id="bonus1info" disabled>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-3 text-center col-form-label pl-0">Flag Bonus</label>
                                        <label class="col-sm-3 text-center col-form-label pl-0">Ketentuan</label>
                                        <label class="col-sm-3 text-center col-form-label pl-0">Qty Pembelian</label>
                                        <label class="col-sm-3 text-center col-form-label pl-0">Qty Bonus</label>
                                    </div>
                                    @for($i=0;$i<6;$i++)
                                        <div class="row form-group">
                                            <div class="col-sm-1"></div>
                                            <input type="text" class="col-sm-1 form-control text-center" id="bonus1flag{{ $i+1 }}" disabled>
                                            <div class="col-sm-1"></div>
                                            <label class="col-sm-3 text-center col-form-label pl-0">Ke - {{ $i+1 }}</label>
                                            <input type="text" class="col-sm-3 form-control text-right" id="bonus1qtybeli{{ $i+1 }}" disabled>
                                            <input type="text" class="col-sm-3 form-control text-right" id="bonus1qtybonus{{ $i+1 }}" disabled>
                                        </div>
                                    @endfor
                                </div>
                                <div class="col-sm-4">
                                    <div class="row form-group">
                                        <label class="col-sm-3 text-right col-form-label pl-0">BONUS 2 :</label>
                                        <label class="col-sm-2 text-left col-form-label pl-0">Masa berlaku</label>
                                        <input type="text" class="col-sm-3 form-control text-center" id="bonus2date1" disabled>
                                        <label class="col-sm-1 text-center col-form-label pl-0">s/d</label>
                                        <input type="text" class="col-sm-3 form-control text-center" id="bonus2date2" disabled>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-3 text-right col-form-label pl-0"></label>
                                        <input type="text" class="col-sm form-control text-center" id="bonus2info" disabled>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-3 text-center col-form-label pl-0">Flag Bonus</label>
                                        <label class="col-sm-3 text-center col-form-label pl-0">Ketentuan</label>
                                        <label class="col-sm-3 text-center col-form-label pl-0">Qty Pembelian</label>
                                        <label class="col-sm-3 text-center col-form-label pl-0">Qty Bonus</label>
                                    </div>
                                    @for($i=0;$i<3;$i++)
                                        <div class="row form-group">
                                            <div class="col-sm-1"></div>
                                            <input type="text" class="col-sm-1 form-control text-center" id="bonus2flag{{ $i+1 }}" disabled>
                                            <div class="col-sm-1"></div>
                                            <label class="col-sm-3 text-center col-form-label pl-0">Ke - {{ $i+1 }}</label>
                                            <input type="text" class="col-sm-3 form-control text-right" id="bonus2qtybeli{{ $i+1 }}" disabled>
                                            <input type="text" class="col-sm-3 form-control text-right" id="bonus2qtybonus{{ $i+1 }}" disabled>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_productList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PLU</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="productListTable">
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

    <div class="modal fade" id="m_pbDraftList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="pbDraftListTable">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No Draft</th>
                                        <th>Tgl Draft</th>
                                        <th>Keterangan</th>
                                        <th>No PB</th>
                                        <th>Tgl PB</th>
                                        <th>Approval</th>
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

    <div class="modal fade" id="m_approval" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row text-center">
                            <label for="i_username" class="col-sm-12 text-center col-form-label">APPROVAL PB SESUAI PKM - OTP</label>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control text-left" id="appInfo" disabled>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control text-left" id="appInfoDetail" disabled>
                            </div>
                            <div class="col-sm-1"></div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-4">
                                <button id="btnSendOTP" class="col btn btn-primary" onclick="sendOTP()">KIRIM OTP</button>
                            </div>
                            <div class="col-sm-4">
                                <input type="password" class="form-control text-center" id="appOTP" placeholder="OTP">
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="container">
                            <div class="form-group row text-center">
                                <div class="col-sm"></div>
                                <div class="col-sm-4">
                                    <button id="btnProcessDraft()" class="btn btn-danger col" onclick="processDraft()">OK</button>
                                </div>
                                <div class="col-sm-4">
                                    <button id="btn-hapus-ok" class="btn btn-secondary col" data-dismiss="modal">BACK</button>
                                </div>
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
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang{
            position:absolute;
            bottom: 10px;
            right: 3vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .btn-lov-plu{
            position:absolute;
            bottom: 10px;
            right: 2vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .modal thead tr th{
            vertical-align: middle;
        }
    </style>

    <script>
        var currentRow;
        var draftDetail = [];
        var paramCekPKM = 0;
        var currentField = 'draft';
        var f_pkm;
        var isNewDraft;

        $(document).ready(function(){
            $('#tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }).on('change', function(e) {
                getPBProduct();
            });

            getPBProduct();
            initPBDraftTable();

            getProductList('');
            getPBDraftList();

            $("#draftDate").val(formatDate('now'));
        });

        function getProductList(value){
            if ($.fn.DataTable.isDataTable('#productListTable')) {
                $('#productListTable').DataTable().destroy();
                $("#productListTable tbody [role='row']").remove();
            }

            if(!$.isNumeric(value)){
                search = value.toUpperCase();
            }
            else search = value;

            $('#productListTable').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-product-list',
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
                    $('#productListTable_filter input').val(value).select();

                    $(".row-plu").off();

                    $('.row-plu').on('click', function (e) {
                        if(currentField == 'master'){
                            $('#pb-product-row-'+currentRow+' .plu').val($(this).find('td:eq(1)').html());

                            key = jQuery.Event("keypress");
                            key.which = 13;

                            getProductDetail(key, currentRow);
                        }
                        else{
                            $('#pb-draft-row-'+currentRow+' .plu').val($(this).find('td:eq(1)').html());

                            key = jQuery.Event("keypress");
                            key.which = 13;

                            getDraftProductDetail(key, currentRow);
                        }

                        $('#m_productList').modal('hide');
                    });
                }
            });

            $('#productListTable_filter input').val(value);

            $('#productListTable_filter input').off().on('keypress', function (e){
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getProductList(val);
                }
            });
        }

        function getPBDraftList(){
            if ($.fn.DataTable.isDataTable('#pbDraftListTable')) {
                $('#pbDraftListTable').DataTable().destroy();
                $("#pbDraftListTable tbody [role='row']").remove();
            }

            $('#pbDraftListTable').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-pb-draft-list',
                },
                "columns": [
                    {data: 'phm_nodraft'},
                    {data: 'tgldraft'},
                    {data: 'phm_keteranganpb'},
                    {data: 'phm_nopb'},
                    {data: 'phm_tglpb'},
                    {data: 'phm_approval'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-pb-draft');
                },
                "initComplete" : function(){
                    $(".row-pb-draft").off();

                    $('.row-pb-draft').on('click', function (e) {
                        $('#draftNo').val($(this).find('td:eq(0)').html());

                        getPBDraftDetail($(this).find('td:eq(0)').html());

                        $('#m_pbDraftList').modal('hide');
                    });
                }
            });
        }

        function initPBProductTable(){
            $('#pbProductTable').DataTable({
                "scrollY": "55vh",
                "scrollX" : false,
                "sort": false,
                "bInfo": false,
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order" : [],
                "initComplete": function(){

                }
            });
        }

        function destroyPBProductTable(){
            if($.fn.DataTable.isDataTable('#pbProductTable')){
                $('#pbProductTable').DataTable().destroy();
            }
        }

        function getPBProduct(){
            tanggal = $('#tanggal').val().split(' - ');

            tgl1 = tanggal[0];
            tgl2 = tanggal[1];

            $.ajax({
                url: '{{ url()->current() }}/get-pb-product',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    tgl1: tgl1,
                    tgl2: tgl2
                },
                beforeSend: function(){
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    destroyPBProductTable();
                    $("#pbProductTable tbody tr").remove();

                    for(i=0;i<response.length;i++){
                        addProductRow(response[i].plu,response[i].deskripsi,response[i].satuan, i);
                    }

                    addProductRow('','','',response.length);

                    if(response.length > 0){
                        $('#btnPrintItem').prop('disabled',false);
                        $('#btnPrintPB').prop('disabled',false);
                    }
                    else{
                        $('#btnPrintItem').prop('disabled',true);
                        $('#btnPrintPB').prop('disabled',true);
                    }

                    $('.pb-product-row .plu').select();
                },
                error: function(error){
                    $('#modal-loader').modal('hide');

                    swal({
                        title: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {

                    });
                }
            });
        }

        function addProductRow(plu, deskripsi, satuan, row){
            destroyPBProductTable();

            $('#pbProductTable tbody').append(
                `<tr class="pb-product-row" id="pb-product-row-${row}">
                    <td>
                        <div class="buttonInside">
                            <input type="text" class="form-control plu" value="${plu}" autocomplete="off" onkeypress="getProductDetail(event, ${row})" maxlength="8">
                            <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_divisi" onclick="showListProduct(${row})">
                                <i class="fas fa-question"></i>
                            </button>
                        </div>
                    </td>
                    <td class="text-left deskripsi">${deskripsi}</td>
                    <td class="satuan">${satuan}</td>
                </tr>`
            );

            initPBProductTable();
        }

        function showListProduct(row){
            currentRow = row;
            $('#m_productList').modal('show');
            $('#productListTable_filter input').val('').select();
        }

        function getProductDetail(e, row){
            if(e.which == 13){
                count = 0;

                $('.pb-product-row .plu').each(function(){
                    if(convertPlu($(this).val()) == convertPlu($('#pb-product-row-'+row).find('.plu').val())){
                        count++;
                    }
                });

                if(count == 2){
                    swal({
                        title: 'PLU '+convertPlu($('#pb-product-row-'+row).find('.plu').val())+' sudah ada!',
                        icon: 'warning'
                    }).then(() => {
                        $('#pb-product-row-'+row).find('.plu').select();
                    });
                }
                else{
                    tanggal = $('#tanggal').val().split(' - ');

                    tgl1 = tanggal[0];
                    tgl2 = tanggal[1];

                    $.ajax({
                        url: '{{ url()->current() }}/get-product-detail',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            tgl1: tgl1,
                            tgl2: tgl2,
                            plu: convertPlu($('#pb-product-row-'+row).find('.plu').val())
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            tr = $('#pb-product-row-'+row);
                            tr.find('.plu').val(response.plu);
                            tr.find('.deskripsi').html(response.deskripsi);
                            tr.find('.satuan').html(response.satuan);

                            if($('#pbProductTable tbody .plu:eq(-1)').val() != '')
                                addProductRow('','','',$('.pb-product-row').length);
                            $('#pbProductTable tbody .plu:eq(-1)').select();
                        },
                        error: function(error){
                            $('#modal-loader').modal('hide');

                            swal({
                                title: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {
                                $('#pb-product-row-'+row).find('.plu').select();
                            });
                        }
                    });
                }
            }
        }

        function savePBData(){
            swal({
                title: 'Yakin ingin menyimpan data?',
                icon: 'warning',
                dangerMode: true,
                buttons: true
            }).then((ok) => {
                if(ok){
                    arrPLU = [];

                    $('.pb-product-row .plu').each(function(){
                        if($(this).val())
                            arrPLU.push(convertPlu($(this).val()));
                    });

                    tanggal = $('#tanggal').val().split(' - ');

                    tgl1 = tanggal[0];
                    tgl2 = tanggal[1];

                    $.ajax({
                        url: '{{ url()->current() }}/save-pb-data',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            tgl1: tgl1,
                            tgl2: tgl2,
                            plu: arrPLU
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.message,
                                icon: 'success'
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function(error){
                            $('#modal-loader').modal('hide');

                            swal({
                                title: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {

                            });
                        }
                    });
                }
            });
        }

        function printItem(){
            tanggal = $('#tanggal').val().split(' - ');

            tgl1 = tanggal[0];
            tgl2 = tanggal[1];

            window.open(`{{ url()->current() }}/print-item?tgl1=${tgl1}&tgl2=${tgl2}`, '_blank');
        }

        function printPB(){
            tanggal = $('#tanggal').val().split(' - ');

            tgl1 = tanggal[0];
            tgl2 = tanggal[1];

            window.open(`{{ url()->current() }}/print-proses?tgl1=${tgl1}&tgl2=${tgl2}`, '_blank');
        }

        function showField(field){
            currentField = field;

            if(field == 'draft'){
                $('#draft').show();
                $('#master').hide();

                destroyPBDraftTable();
                $('#pbDraftTable tbody tr').remove();
                initPBDraftTable();

                $('#draft input').val('');

                $("#draftDate").val(formatDate('now'));
                $('#draftNo').select();
            }
            else{
                $('#draft').hide();
                $('#master').show();
            }
        }

        function initPBDraftTable(){
            destroyPBDraftTable();

            $('#pbDraftTable').DataTable({
                "scrollY": "25vh",
                "scrollX" : false,
                "sort": false,
                "bInfo": false,
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order" : [],
                "initComplete": function(){

                }
            });
        }

        function destroyPBDraftTable(){
            if($.fn.DataTable.isDataTable('#pbDraftTable')){
                $('#pbDraftTable').DataTable().destroy();
            }
        }

        function addDraftRow(data,row){
            destroyPBDraftTable();

            if(data == null){
                $('#pbDraftTable tbody').append(
                    `<tr class="pb-draft-row" id="pb-draft-row-${row}" onclick="showDetail(${row})" style="cursor:pointer;">
                    <td>
                        <div class="buttonInside">
                            <input type="text" class="form-control plu" value="" autocomplete="off" onkeypress="getDraftProductDetail(event, ${row})" maxlength="8">
                            <button type="button" class="btn btn-primary btn-lov p-0" onclick="showListProduct(${row})">
                                <i class="fas fa-question"></i>
                            </button>
                        </div>
                    </td>
                    <td class="text-right minorpcs"></td>
                    <td class="text-right minorctn"></td>
                    <td class="text-right minorrph"></td>
                    <td class="text-right maxpalet"></td>
                    <td>
                        <input type="number" class="form-control text-right qtyctn" value="" autocomplete="off" onchange="checkQty(${row},'qtyctn')" onkeypress="checkQtyKey(event,${row},'qtyctn')">
                    </td>
                    <td>
                        <input type="number" class="form-control text-right qtypcs" value="" autocomplete="off" onchange="checkQty(${row},'qtypcs')"  onkeypress="checkQtyKey(event,${row},'qtypcs')">
                    </td>
                    <td class="text-right hrgsatuan"></td>
                    <td class="text-right rphdisc1"></td>
                    <td class="text-right persendisc1"></td>
                    <td class="text-right rphdisc2"></td>
                    <td class="text-right persendisc2"></td>
                    <td class="text-right bonuspo1"></td>
                    <td class="text-right bonuspo2"></td>
                    <td class="text-right gross"></td>
                    <td class="text-right ppn"></td>
                    <td class="text-right ppnbm"></td>
                    <td class="text-right ppnbotol"></td>
                    <td class="text-right total"></td>
                </tr>`
                );
            }
            else{
                $('#pbDraftTable tbody').append(
                    `<tr class="pb-draft-row" id="pb-draft-row-${row}" onclick="showDetail(${row})" style="cursor:pointer;">
                    <td>
                        <div class="buttonInside">
                            <input type="text" class="form-control plu" value="${data.pdm_prdcd}" autocomplete="off" onkeypress="getDraftProductDetail(event, ${row})" maxlength="8">
                            <button type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_divisi" onclick="showListProduct(${row})">
                                <i class="fas fa-question"></i>
                            </button>
                        </div>
                    </td>
                    <td class="text-right minorpcs">${nvl(nvl(data.prd_minorder,0),nvl(data.prd_isibeli,1))}</td>
                    <td class="text-right minorctn">${parseInt(nvl(nvl(data.prd_minorder,0),nvl(data.prd_isibeli,1)) / data.prd_frac)}</td>
                    <td class="text-right minorrph">${data.sup_minrph}</td>
                    <td class="text-right maxpalet">${nvl(data.mpt_maxqty,'')}</td>
                    <td>
                        <input type="number" class="form-control text-right qtyctn" value="${parseInt(data.pdm_qtypb / data.prd_frac)}" autocomplete="off" onchange="checkQty(${row},'qtyctn')" onkeypress="checkQtyKey(event,${row},'qtyctn')">
                    </td>
                    <td>
                        <input type="number" class="form-control text-right qtypcs" value="${data.pdm_qtypb % data.prd_frac}" autocomplete="off" onchange="checkQty(${row},'qtypcs')"  onkeypress="checkQtyKey(event,${row},'qtypcs')">
                    </td>
                    <td class="text-right hrgsatuan">${convertToRupiah2(Math.round(data.pdm_hrgsatuan))}</td>
                    <td class="text-right rphdisc1">${convertToRupiah2(Math.round(data.pdm_rphdisc1))}</td>
                    <td class="text-right persendisc1">${convertToRupiah2(Math.round(data.pdm_persendisc1))}</td>
                    <td class="text-right rphdisc2">${convertToRupiah2(Math.round(data.pdm_rphdisc2))}</td>
                    <td class="text-right persendisc2">${convertToRupiah2(Math.round(data.pdm_persendisc2))}</td>
                    <td class="text-right bonuspo1">${convertToRupiah2(Math.round(data.pdm_bonuspo1))}</td>
                    <td class="text-right bonuspo2">${convertToRupiah2(Math.round(data.pdm_bonuspo2))}</td>
                    <td class="text-right gross">${convertToRupiah2(Math.round(data.pdm_gross))}</td>
                    <td class="text-right ppn">${convertToRupiah2(Math.round(data.pdm_ppn))}</td>
                    <td class="text-right ppnbm">${convertToRupiah2(Math.round(data.pdm_ppnbm))}</td>
                    <td class="text-right ppnbotol">${convertToRupiah2(Math.round(data.pdm_ppnbotol))}</td>
                    <td class="text-right total">${convertToRupiah2(parseInt(data.pdm_gross) + parseInt(data.pdm_ppn) + parseInt(data.pdm_ppnbm) + parseInt(data.pdm_ppnbotol))}</td>
                </tr>`
                );
            }

            initPBDraftTable();
        }

        $('#draftNo').on('keypress',function(event){
            if(event.which == 13){
                if($(this).val())
                    getPBDraftDetail($(this).val());
                else{
                    $('#info').val('DRAFT PB MANUAL');

                    $.ajax({
                        url: '{{ url()->current() }}/new-pb-draft',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {

                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            isNewDraft = true;

                            $('input').val('');
                            $('#draftNo').val(response.draftNo);
                            $('#draftDate').val(response.draftDate);
                            $('#draftInfo').select();

                            destroyPBDraftTable();
                            $('#pbDraftTable tbody tr').remove();
                            initPBDraftTable();

                            addDraftRow(null,0);

                            $('#draftInfo').prop('disabled',false);
                            $('#pbDraftTable input').prop('disabled',false);
                            $('#pbDraftTable button').prop('disabled',false);
                            $('#btnSaveDraft').prop('disabled',false);
                        },
                        error: function(error){
                            $('#modal-loader').modal('hide');

                            swal({
                                title: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {

                            });
                        }
                    });
                }
            }
        });

        $('#draftInfo').on('keypress',function(event){
            if(event.which == 13){
                if(!$(this).val()){
                    swal({
                        title: 'Kolom keterangan tidak boleh kosong!',
                        icon: 'warning',
                    }).then(() => {
                        $('#draftInfo').select();
                    });
                }
                else $('.pb-draft-row .plu').select();
            }
        });

        function getPBDraftDetail(draftNo){
            $.ajax({
                url: '{{ url()->current() }}/get-pb-draft-detail',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    no : draftNo
                },
                beforeSend: function(){
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    isNewDraft = false;

                    header = response.header;
                    $('#draftDate').val(header.phm_tgldraft);
                    $('#draftInfo').val(header.phm_keteranganpb);
                    $('#draftHighestAuth').val(header.phm_approval);

                    if(nvl(header.phm_recordid,0) == '2'){
                        $('#info').val('PB MANUAL NOMOR '+header.phm_nopb+' - APPROVAL '+header.phm_approval);

                        $('#pbDraftTable input').prop('disabled',true);
                    }

                    draftDetail = response.detail;

                    destroyPBDraftTable();
                    $('#pbDraftTable tbody tr').remove();
                    initPBDraftTable();

                    for(i=0;i<draftDetail.length;i++){
                        addDraftRow(draftDetail[i],i);
                        showDetail(i);
                    }

                    if(header.phm_recordid == '2'){
                        $('#draftInfo').prop('disabled',true);
                        $('#pbDraftTable input').prop('disabled',true);
                        $('#pbDraftTable button').prop('disabled',true);
                        $('#btnSaveDraft').prop('disabled',true);
                    }
                    else{
                        $('#draftInfo').prop('disabled',false);
                        $('#pbDraftTable input').prop('disabled',false);
                        $('#pbDraftTable button').prop('disabled',false);
                        $('#btnSaveDraft').prop('disabled',false);
                        addDraftRow(null,draftDetail.length);
                    }

                    showDetail(0);
                },
                error: function(error){
                    $('#modal-loader').modal('hide');

                    swal({
                        title: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {

                    });
                }
            });
        }

        function showDetail(row){
            $('.selected').removeClass('selected');
            $('#pb-draft-row-'+row).addClass('selected');

            d = draftDetail[row];

            if(typeof d === 'undefined'){
                $('#draftDetail input').val('');
            }
            else{
                $('#draftDesc').val(d.prd_deskripsipanjang);
                $('#draftUnit').val(d.prd_unit+'/'+d.prd_frac);
                $('#draftSupplierCode').val(d.sup_kodesupplier);
                $('#draftSupplierName').val(d.sup_namasupplier);
                $('#omi').val(d.omi);
                $('#idm').val(d.idm);
                $('#hargajual').val(convertToRupiah2(d.prd_hrgjual));
                $('#pkmt').val(d.pdm_pkmt);
                $('#stock').val(d.pdm_saldoakhir);

                if(d.hgb_tglmulaibonus01){
                    if(d.hgb_flagkelipatanbonus01 == 'Y')
                        $('#bonus1info').val('BERLAKU KELIPATAN');
                    else $('#bonus1info').val('TIDAK BERLAKU KELIPATAN');
                }

                if(d.hgb_tglmulaibonus02){
                    if(d.hgb_flagkelipatanbonus02 == 'Y')
                        $('#bonus2info').val('BERLAKU KELIPATAN');
                    else $('#bonus2info').val('TIDAK BERLAKU KELIPATAN');
                }

                $('#bonus1date1').val(d.hgb_tglmulaibonus01);
                $('#bonus1date2').val(d.hgb_tglakhirbonus01);
                $('#bonus2date1').val(d.hgb_tglmulaibonus02);
                $('#bonus2date2').val(d.hgb_tglakhirbonus01);

                $('#bonus1qtybeli1').val(nvl(d.hgb_qtymulai1bonus01,0));
                $('#bonus1qtybeli2').val(nvl(d.hgb_qtymulai2bonus01,0));
                $('#bonus1qtybeli3').val(nvl(d.hgb_qtymulai3bonus01,0));
                $('#bonus1qtybeli4').val(nvl(d.hgb_qtymulai4bonus01,0));
                $('#bonus1qtybeli5').val(nvl(d.hgb_qtymulai5bonus01,0));
                $('#bonus1qtybeli6').val(nvl(d.hgb_qtymulai6bonus01,0));
                $('#bonus2qtybeli1').val(nvl(d.hgb_qtymulai1bonus02,0));
                $('#bonus2qtybeli2').val(nvl(d.hgb_qtymulai2bonus02,0));
                $('#bonus2qtybeli3').val(nvl(d.hgb_qtymulai3bonus02,0));

                $('#bonus1qtybonus1').val(nvl(d.hgb_qty1bonus01,0));
                $('#bonus1qtybonus2').val(nvl(d.hgb_qty2bonus01,0));
                $('#bonus1qtybonus3').val(nvl(d.hgb_qty3bonus01,0));
                $('#bonus1qtybonus4').val(nvl(d.hgb_qty4bonus01,0));
                $('#bonus1qtybonus5').val(nvl(d.hgb_qty5bonus01,0));
                $('#bonus1qtybonus6').val(nvl(d.hgb_qty6bonus01,0));
                $('#bonus2qtybonus1').val(nvl(d.hgb_qty1bonus02,0));
                $('#bonus2qtybonus2').val(nvl(d.hgb_qty2bonus02,0));
                $('#bonus2qtybonus3').val(nvl(d.hgb_qty3bonus02,0));

                if(nvl(d.hgb_qtymulai1bonus01, 0) != 0)
                    $('#bonus1flag1').val(d.hgb_jenisbonus);
                if(nvl(d.hgb_qtymulai2bonus01, 0) != 0)
                    $('#bonus1flag2').val(d.hgb_jenisbonus);
                if(nvl(d.hgb_qtymulai3bonus01, 0) != 0)
                    $('#bonus1flag3').val(d.hgb_jenisbonus);
                if(nvl(d.hgb_qtymulai4bonus01, 0) != 0)
                    $('#bonus1flag4').val(d.hgb_jenisbonus);
                if(nvl(d.hgb_qtymulai5bonus01, 0) != 0)
                    $('#bonus1flag5').val(d.hgb_jenisbonus);
                if(nvl(d.hgb_qtymulai6bonus01, 0) != 0)
                    $('#bonus1flag6').val(d.hgb_jenisbonus);

                if(nvl(d.hgb_qtymulai1bonus02, 0) != 0)
                    $('#bonus2flag1').val(d.hgb_jenisbonus);
                if(nvl(d.hgb_qtymulai2bonus02, 0) != 0)
                    $('#bonus2flag2').val(d.hgb_jenisbonus);
                if(nvl(d.hgb_qtymulai3bonus02, 0) != 0)
                    $('#bonus2flag3').val(d.hgb_jenisbonus);

                if(d.pdm_qtypb > (d.pdm_pkmt * 10))
                    d.f_pkm = 1;
                else if(d.pdm_qtypb > (d.pdm_pkmt * 5) && d.pdm_qtypb <= (d.pdm_pkmt * 10))
                    d.f_pkm = 2;
                else if(d.pdm_qtypb > (d.pdm_pkmt * 2) && d.pdm_qtypb <= (d.pdm_pkmt * 5))
                    d.f_pkm = 3;
                else if(d.pdm_qtypb <= (d.pdm_pkmt * 2))
                    d.f_pkm = 4;

                if(paramCekPKM > d.f_pkm)
                    paramCekPKM = d.f_pkm;

                switch(paramCekPKM){
                    case 1 : $('#draftHighestAuth').val('Senior Manager');break;
                    case 2 : $('#draftHighestAuth').val('Store Manager');break;
                    case 3 : $('#draftHighestAuth').val('Store Operation Jr. Mgr / Mgr');break;
                    default : $('#draftHighestAuth').val('Store Operation Jr. Spv / Spv');break;
                }
            }
        }

        function deletePBDraft(){
            if(!$('#draftNo').val()){
                swal({
                    title: 'Nomor Draft PB tidak boleh kosong!',
                    icon: 'warning'
                }).then(() => {
                    $('#draftNo').select();
                });
            }
            else{
                swal({
                    title: 'Yakin ingin menghapus data?',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/delete-pb-draft',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                no : $('#draftNo').val()
                            },
                            beforeSend: function(){
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(error){
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error'
                                }).then(() => {

                                });
                            }
                        });
                    }
                });
            }
        }

        function getDraftProductDetail(e, row){
            if(e.which == 13){
                count = 0;

                $('.pb-draft-row .plu').each(function(){
                    if(convertPlu($(this).val()) == convertPlu($('#pb-draft-row-'+row).find('.plu').val())){
                        count++;
                    }
                });

                if(count == 2){
                    swal({
                        title: 'PLU '+convertPlu($('#pb-draft-row-'+row).find('.plu').val())+' sudah ada!',
                        icon: 'warning'
                    }).then(() => {
                        $('#pb-draft-row-'+row).find('.plu').select();
                    });
                }
                else{
                    $.ajax({
                        url: '{{ url()->current() }}/get-draft-product-detail',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            plu: convertPlu($('#pb-draft-row-'+row).find('.plu').val())
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            f_pkm = 5;

                            draftDetail[row] = response;

                            fillDetail(row);

                            showDetail(row);

                            $('#pb-draft-row-'+row).find('.qtyctn').select();
                        },
                        error: function(error){
                            $('#modal-loader').modal('hide');

                            swal({
                                title: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {
                                $('#pb-draft-row-'+row).find('.plu').select();
                            });
                        }
                    });
                }
            }
        }

        function fillDetail(row){
            tr = $('#pb-draft-row-'+row);
            data = draftDetail[row];

            tr.find('.plu').val(data.pdm_prdcd);
            tr.find('.minorpcs').html(data.prd_minorder);
            tr.find('.minorctn').html(parseInt(data.prd_minorder / data.prd_frac));
            tr.find('.minorrph').html(Math.round(data.sup_minrph));
            tr.find('.maxpalet').html(nvl(data.mpt_maxqty,''));
            tr.find('.hrgsatuan').html(convertToRupiah2(Math.round(data.pdm_hrgsatuan)));
            tr.find('.rphdisc1').html(convertToRupiah2(Math.round(data.pdm_rphdisc1)));
            tr.find('.persendisc1').html(convertToRupiah2(Math.round(data.pdm_persendisc1)));
            tr.find('.rphdisc2').html(convertToRupiah2(Math.round(data.pdm_rphdisc2)));
            tr.find('.persendisc2').html(convertToRupiah2(Math.round(data.pdm_persendisc2)));
            tr.find('.bonuspo1').html(convertToRupiah2(Math.round(data.pdm_bonuspo1)));
            tr.find('.bonuspo2').html(convertToRupiah2(Math.round(data.pdm_bonuspo2)));
            tr.find('.gross').html(convertToRupiah2(Math.round(data.pdm_gross)));
            tr.find('.ppn').html(convertToRupiah2(Math.round(data.pdm_ppn)));
            tr.find('.ppnbm').html(convertToRupiah2(Math.round(data.pdm_ppnbm)));
            tr.find('.ppnbotol').html(convertToRupiah2(Math.round(data.pdm_ppnbotol)));
            tr.find('.total').html(convertToRupiah2(parseInt(data.pdm_gross) + parseInt(data.pdm_ppn) + parseInt(data.pdm_ppnbm) + parseInt(data.pdm_ppnbotol)));
        }

        function checkQtyKey(event, row, field){
            if(event.which == 13){
                checkQty(row,field);
            }
        }

        function checkQty(row,field){
            data = draftDetail[row];

            tr = $('#pb-draft-row-'+row);

            if(
                (tr.find('.qtypcs').val() && tr.find('.qtypcs').val() < parseInt(tr.find('.minorpcs').html())) &&
                tr.find('.qtyctn').val() && tr.find('.qtyctn').val() < parseInt(tr.find('.minorctn').html())
            ){
            // if(false){
                swal({
                    title: 'QTYB + QTYK < MINOR!',
                    icon: 'warning'
                }).then(() => {
                    tr.find('.'+field).select();
                });
            }
            else{
                qtypcs = parseInt(nvl(tr.find('.qtypcs').val(),0));
                qtyctn = parseInt(nvl(tr.find('.qtyctn').val(),0));

                qtyctn = qtyctn + parseInt(qtypcs / data.prd_frac);
                qtypcs = qtypcs % data.prd_frac;

                tr.find('.qtyctn').val(qtyctn);
                tr.find('.qtypcs').val(qtypcs);

                if(nvl(data.pdm_recordid,9) != 2){
                    if(tr.find('.qtyctn').val() < 0){
                        console.log('b');
                        swal({
                            title: 'Quantity Carton < 0',
                            icon: 'warning'
                        }).then(() => {
                            tr.find('.qtyctn').select();
                        });
                    }
                    else if(((qtyctn * parseInt(data.prd_frac)) + qtypcs) < 0 && (qtyctn + qtypcs) !== 0){
                        tr.find('.qtypcs').val(0);
                        tr.find('.qtyctn').val(0);
                    }
                    else{
                        data.pdm_qtypb = qtyctn * parseInt(data.prd_frac) + qtypcs;

                        data.pdm_gross = ((qtyctn * parseFloat(data.pdm_hrgsatuan)) + ((parseFloat(data.pdm_hrgsatuan) / parseInt(data.prd_frac)) * qtypcs));
                        tr.find('.gross').val(convertToRupiah2(Math.round(data.pdm_gross)));

                        console.log(data.pdm_gross);

                        if(nvl(parseInt(data.pdm_persendisc1),0) > 0){
                            // data.pdm_gross -= ((((data.pdm_gross * parseFloat(data.pdm_persendisc1)) / 100)));
                            data.pdm_gross *= (100 - parseInt(data.pdm_persendisc1)) / 100;
                            tr.find('.gross').html(convertToRupiah2(Math.round(data.pdm_gross)));
                        }

                        console.log(data.pdm_gross);

                        if(nvl(parseInt(data.pdm_persendisc2),0) > 0){
                            //data.pdm_gross -= ((((data.pdm_gross * parseFloat(data.pdm_persendisc2)) / 100)));
                            data.pdm_gross *= (100 - parseInt(data.pdm_persendisc2)) / 100;
                            tr.find('.gross').html(convertToRupiah2(Math.round(data.pdm_gross)));
                        }

                        console.log(data.pdm_gross);

                        if(data.bkp === 'Y'){
                            data.pdm_ppn = (parseFloat(data.pdm_gross) * parseInt(nvl(data.prd_ppn,11))) / 100;
                            tr.find('.ppn').html(convertToRupiah2(Math.round(data.pdm_ppn)));
                        }
                        else{
                            data.pdm_ppn = 0;
                            tr.find('.ppn').html(convertToRupiah2(Math.round(data.pdm_ppn)));
                        }

                        tr.find('.total').html(convertToRupiah2(parseInt(data.pdm_gross) + parseInt(data.pdm_ppn) + parseInt(data.pdm_ppnbm) + parseInt(data.pdm_ppnbotol)));

                        if(data.pdm_qtypb > (data.pdm_pkmt * 10))
                            f_pkm = 1;
                        else if(data.pdm_qtypb > (data.pdm_pkmt * 5) && data.pdm_qtypb <= (data.pdm_pkmt * 10))
                            f_pkm = 2;
                        else if(data.pdm_qtypb > (data.pdm_pkmt * 2) && data.pdm_qtypb <= (data.pdm_pkmt * 5))
                            f_pkm = 3;
                        else if(data.pdm_qtypb <= (data.pdm_pkmt * 2))
                            f_pkm = 4;

                        if(paramCekPKM > f_pkm)
                            paramCekPKM = f_pkm;

                        switch(paramCekPKM){
                            case 1 : $('#draftHighestAuth').val('Senior Manager');break;
                            case 2 : $('#draftHighestAuth').val('Store Manager');break;
                            case 3 : $('#draftHighestAuth').val('Store Operation Jr. Mgr / Mgr');break;
                            default : $('#draftHighestAuth').val('Store Operation Jr. Mgr / Mgr');break;
                        }

                        if(field == 'qtyctn'){
                            showDetail(row);
                            tr.find('.qtypcs').select();
                        }
                        else{
                            if(tr.find('.plu').val() == $('.pb-draft-row:eq(-1) .plu').val()){
                                r = $('.pb-draft-row').length;
                                addDraftRow(null,r);
                                showDetail(r);
                                $('#pb-draft-row-'+r).find('.plu').select();
                            }
                            else{
                                r = row+1;
                                $('#pb-draft-row-'+r).find('.plu').select();
                                showDetail(r);
                            }
                        }
                    }
                }
            }
        }

        function saveDraft(){
            if(draftDetail.length == 0){
                swal({
                    title: 'Tidak ada data yang akan disimpan!',
                    icon: 'error'
                }).then(() => {
                    $('#draftNo').select();
                });
            }
            else{
                swal({
                    title: 'Yakin ingin menyimpan data draft?',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/save-draft',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                isNewDraft : isNewDraft,
                                draftNo : $('#draftNo').val(),
                                draftDate : $('#draftDate').val(),
                                draftInfo : $('#draftInfo').val(),
                                draftDetail: draftDetail
                            },
                            beforeSend: function(){
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    isNewDraft = false;
                                });
                            },
                            error: function(error){
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error'
                                }).then(() => {

                                });
                            }
                        });
                    }
                });
            }
        }

        function checkProcessDraft(){
            if(!$('#draftNo').val()){
                swal({
                    title: 'Nomor Draft PB tidak boleh kosong!',
                    icon: 'warning',
                }).then(() => {
                    $('#draftNo').select();
                });
            }
            else{
                swal({
                    title: 'Yakin ingin proses Draft PB menjadi PB Manual?',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/check-process-draft',
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                draftNo : $('#draftNo').val(),
                            },
                            beforeSend: function(){
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                if(response.message == 'OK'){
                                    showApproval();
                                }
                            },
                            error: function(error){
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error'
                                }).then(() => {

                                });
                            }
                        });
                    }
                });

            }
        }

        function showApproval(){
            paramCekPKM = 5;
            for(i=0;i<draftDetail.length;i++){
                if(paramCekPKM > draftDetail[i].f_pkm)
                    paramCekPKM = draftDetail[i].f_pkm;
            }

            switch (paramCekPKM){
                case 1 : {
                    limit = '> 10x';
                    auth = 'Senior Manager';
                    break;
                }
                case 2 : {
                    limit = '10x';
                    auth = 'Store Manager';
                    break;
                }
                case 3 : {
                    limit = '5x';
                    auth = 'Store Operation Jr. Mgr / Mgr';
                    break;
                }
                default : {
                    limit = '2x';
                    auth = 'Store Operation Jr. Spv / Spv';
                    break;
                }
            }

            limit = 'Batasan s/d '+limit+' PKM';
            auth = 'Otorisasi : '+auth;

            $('#appInfo').val(limit);
            $('#appInfoDetail').val(auth);
            $('#m_approval').modal({backdrop: 'static', keyboard: false});
        }

        function sendOTP(){
            $.ajax({
                url: '{{ url()->current() }}/send-otp',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    draftNo: $('#draftNo').val(),
                    draftDate: $('#draftDate').val(),
                    auth: $('#appInfoDetail').val(),
                    paramCekPKM: paramCekPKM
                },
                beforeSend: function(){
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.message,
                        icon: 'success'
                    }).then(() => {
                        $('#appOTP').val('').select();
                    });
                },
                error: function(error){
                    $('#modal-loader').modal('hide');

                    swal({
                        title: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {

                    });
                }
            });
        }

        function processDraft(){
            if(!$('#appOTP').val()){
                swal({
                    title: 'Harap isi OTP!',
                    icon: 'warning'
                }).then(() => {
                    $('#appOTP').select();
                });
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/process-draft',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        draftNo: $('#draftNo').val(),
                        draftDate: $('#draftDate').val(),
                        otp: $('#appOTP').val(),
                        paramCekPKM: paramCekPKM,
                    },
                    beforeSend: function(){
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        swal({
                            title: response[0].message,
                            icon: response[0].status
                        }).then(() => {
                            swal({
                                title: response[1].message,
                                icon: response[1].status
                            }).then(() => {
                                window.location.reload();
                            });
                        });
                    },
                    error: function(error){
                        $('#modal-loader').modal('hide');

                        swal({
                            title: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {

                        });
                    }
                });
            }
        }
    </script>

@endsection
