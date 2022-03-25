@extends('navbar')

@section('title','BO | ADJUSTMENT STOCK CMO')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <fieldset class="card border-secondary m-1">
                        <legend class="w-auto ml-3">Berita Acara Adjustment untuk item Commit Order</legend>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">Nomor BA</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="noBA" autocomplete="off">
                                    <button id="btn_lov_ba" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_ba" disabled>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-1 pr-0 text-right col-form-label">Tgl BA</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tglBA" disabled>
                                </div>
                                <div class="col"></div>
                                <label class="col-sm-1 pr-0 text-right col-form-label">Tanggal</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control tgl" id="tgl1" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-1 pr-0 text-right col-form-label">Tgl Adj</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tglAdj" disabled>
                                </div>
                                <label class="col-sm-1 pr-0 text-right col-form-label">User Adj</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="userAdj" disabled>
                                </div>
                                <div class="col"></div>
                                <label class="col-sm-1 pr-0 text-right col-form-label">s/d</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control tgl" id="tgl2" disabled>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col"></div>
                                <div class="col-sm-2">
                                    <button id="btnProsesBA" onclick="processBA()" class="col btn btn-primary form-control" disabled>PROSES BA</button>
                                </div>
                                <div class="col-sm-2">
                                    <button id="btnBatalBA" onclick="cancelBA()" class="col btn btn-primary form-control" disabled>BATAL BA</button>
                                </div>
                                <div class="col-sm-2">
                                    <button id="btnProsesAdj" onclick="processAdjust()" class="col btn btn-primary form-control" disabled>PROSES ADJ</button>
                                </div>
                                <div class="col-sm-2">
                                    <button id="btnListingAdj" onclick="listingAdjust()" class="col btn btn-primary form-control" disabled>LISTING ADJ</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary ml-2 mr-2 mt-0">
                        <legend class="w-auto ml-3">Item Commit Order</legend>
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                        <thead class="thColor">
                                        <tr>
                                            <th width=""></th>
                                            <th width="">PLU IGR</th>
                                            <th width="">PLU IDM</th>
                                            <th width="">Qty Stock Virtual</th>
                                            <th width="">Qty BA</th>
                                            <th width="">Qty Adj</th>
                                            <th width="">Keterangan</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="card-body">
                        <div class="row">
                            <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">Deskripsi</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="deskripsi" disabled>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-right" id="unit" disabled>
                            </div>
                            <div class="col"></div>
                            <div class="col-sm-2">
                                <button class="col btn btn-primary form-control" onclick="addRow()">TAMBAH</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_ba" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_ba">
                                    <thead>
                                    <tr>
                                        <th>Nomor BA</th>
                                        <th>Tanggal BA</th>
                                        <th>Tanggal Adj</th>
                                        <th>User Adj</th>
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

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_plu">
                                    <thead>
                                    <tr>
                                        <th>PLU IGR</th>
                                        <th>PLU IDM</th>
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
        var currIndex = 0;
        var index = 0;
        var arrDataBA = [];

        $(document).ready(function(){
            $('.tgl').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            $('#table_daftar').DataTable({
                "scrollY": "40vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });

            getLovBA();
            getLovPLU();

            $('#noBA').focus();
        });

        function getLovBA(){
            lovtrn = $('#table_lov_ba').DataTable({
                "ajax": '{{ url()->current() }}/get-data-lov-ba',
                "columns": [
                    {data: 'noba'},
                    {data: 'tglba'},
                    {data: 'tgladj'},
                    {data: 'useradj'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-ba').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_ba').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-ba', function (e) {
                        $('#noBA').val($(this).find('td:eq(0)').html());
                        $('#tglBA').val($(this).find('td:eq(1)').html());
                        $('#tglAdj').val($(this).find('td:eq(2)').html());
                        $('#userAdj').val($(this).find('td:eq(3)').html());

                        $('#m_lov_ba').modal('hide');

                        getDataBA($(this).find('td:eq(0)').html());
                    });
                }
            });
        }

        function getLovPLU(){
            lovtrn = $('#table_lov_plu').DataTable({
                "ajax": '{{ url()->current() }}/get-data-lov-plu',
                "columns": [
                    {data: 'icm_pluigr'},
                    {data: 'prc_pluidm'},
                    {data: 'prd_deskripsipanjang'},
                    {data: 'unit'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-plu').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $(document).on('click', '.row-lov-plu', function (e) {
                        $('#row-'+currIndex).find('.pluigr').val($(this).find('td:eq(0)').html());

                        doCheckPLU(currIndex);

                        $('#m_lov_plu').modal('hide');
                    });
                }
            });
        }

        function getDataBA(noBA){
            if(noBA){
                $.ajax({
                    url: '{{ url()->current() }}/get-data-ba',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        noba: noBA
                    },
                    beforeSend: function(){
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        header = response.header;

                        $('#noBA').val(header.noba);
                        $('#tglBA').val(header.tglba);

                        arrDataBA = response.detail;

                        index = 0;
                        currIndex = 0;

                        if($.fn.DataTable.isDataTable('#table_daftar')) {
                            $('#table_daftar').DataTable().destroy();
                        }

                        $('#table_daftar tbody tr').remove();

                        $('#table_daftar').DataTable({
                            "scrollY": "40vh",
                            "paging" : false,
                            "sort": false,
                            "bInfo": false,
                            "searching": false
                        });

                        for(i=0;i<response.detail.length;i++){
                            addRow();

                            row = $('#row-'+i);
                            data = response.detail[i];

                            row.find('.pluigr').val(data.bac_prdcd);
                            row.find('.pluidm').val(data.prc_pluidm);
                            row.find('.qtysv').val(data.bac_qty_stock);
                            row.find('.qtyba').val(data.bac_qty_ba);

                            if(data.bac_recordid == '2')
                                row.find('.qtyadj').val(data.bac_qty_adj);
                            else row.find('.qtyadj').val(0);

                            row.find('.keterangan').val(data.bac_keterangan);
                        }

                        $('#table_daftar .pluigr').prop('disabled',true);
                        $('#table_daftar .btn-lov').prop('disabled',true);
                        $('#table_daftar .qtyba').prop('disabled',true);
                        $('#table_daftar .keterangan').prop('disabled',true);
                        $('#table_daftar .btn-delete').prop('disabled',true);

                        $('#btnProsesBA').prop('disabled',true);
                        $('#btnListingAdj').prop('disabled',false);

                        if(header.status == '2'){
                            $('#tglAdj').val(header.tgladj);
                            $('#userAdj').val(header.useradj);

                            $('#table_daftar .qtyadj').prop('disabled',true);
                            $('#btnProsesBA').prop('disabled',true);
                            $('#btnBatalBA').prop('disabled',true);
                            $('#btnProsesAdj').prop('disabled',true);
                        }
                        else{
                            $('#table_daftar .qtyadj').prop('disabled',false);
                            $('#btnBatalBA').prop('disabled',false);
                            $('#btnProsesAdj').prop('disabled',false);
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
            else{

            }
        }

        function addRow(){
            if($.fn.DataTable.isDataTable('#table_daftar')) {
                $('#table_daftar').DataTable().destroy();
            }

            $('#table_daftar tbody').append(`
                <tr id="row-${index}" class="row-data" onmouseover="showDetail(${index})">
                    <td>
                        <button onclick="deleteRow(${index})" class="col-sm btn btn-danger btn-delete">X</button>
                    </td>
                    <td>
                        <div class="buttonInside">
                            <input type="text" class="form-control pluigr" autocomplete="off" onkeypress="checkPLU(event, ${index})">
                            <button type="button" class="btn btn-primary btn-lov p-0" onclick="showLovPLU(${index})">
                                <i class="fas fa-question"></i>
                            </button>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control pluidm text-center" autocomplete="off" disabled>
                    </td>
                    <td>
                        <input type="text" class="form-control qtysv text-right" autocomplete="off" disabled>
                    </td>
                    <td>
                        <input type="text" class="form-control qtyba text-right" autocomplete="off">
                    </td>
                    <td>
                        <input type="text" class="form-control qtyadj text-right" autocomplete="off">
                    </td>
                    <td>
                        <input type="text" class="form-control keterangan text-left" autocomplete="off">
                    </td>
                </tr>`);

            index++;

            $('#table_daftar').DataTable({
                "scrollY": "40vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });

            defaultAction();
        }

        function deleteRow(i){
            if($.fn.DataTable.isDataTable('#table_daftar')) {
                $('#table_daftar').DataTable().destroy();
            }

            $('#row-'+i).remove();

            $('#table_daftar').DataTable({
                "scrollY": "40vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });
        }

        function showLovPLU(i){
            currIndex = i;
            $('#m_lov_plu').modal('show');
        }

        function checkPLU(event, i){
            if(event.which == 13){
                if($('#row-'+i).find('.pluigr').val()){
                    found = 0;

                    $('.pluigr').each(function(){
                        if(convertPlu(this.value) == convertPlu($('#row-'+i).find('.pluigr').val())){
                            found++;
                        }
                    });

                    if(found < 2)
                        doCheckPLU(i);
                    else{
                        swal({
                            title: 'PLU '+ convertPlu($('#row-'+i).find('.pluigr').val()) + ' sudah ada!',
                            icon: 'warning'
                        }).then(() => {
                            $('#row-'+i).find('.pluigr').select();
                        });
                    }
                }
            }
        }

        function doCheckPLU(i){
            $.ajax({
                url: '{{ url()->current() }}/check-plu',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    plu: $('#row-'+i).find('.pluigr').val()
                },
                beforeSend: function(){
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('#row-'+i).find('.pluigr').val(response.plu);
                    $('#row-'+i).find('.pluidm').val(response.pluidm);
                    $('#row-'+i).find('.qtysv').val(response.qty);
                    $('#row-'+i).find('.qtyba').select();

                    arrDataBA[i] = response;

                    showDetail(i);
                },
                error: function(error){
                    $('#modal-loader').modal('hide');

                    swal({
                        title: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {
                        $('#row-'+i).find('.pluigr').select();
                    });
                }
            });
        }

        $('#noBA').on('keypress',function(event){
            if(event.which == 13){
                if(this.value){
                   getDataBA(this.value);
                }
                else{
                    $.ajax({
                        url: '{{ url()->current() }}/get-new-no-ba',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            arrDataBA = [];
                            index = 0;
                            currIndex = 0;

                            if($.fn.DataTable.isDataTable('#table_daftar')) {
                                $('#table_daftar').DataTable().destroy();
                            }

                            $('#table_daftar tbody tr').remove();

                            $('#table_daftar').DataTable({
                                "scrollY": "40vh",
                                "paging" : false,
                                "sort": false,
                                "bInfo": false,
                                "searching": false
                            });

                            $('#noBA').val(response.noba);
                            $('#tglBA').val(response.tglba);
                            $('#tglAdj').val('');
                            $('#userAdj').val('');
                            $('#deskripsi3').val('');
                            $('#unit').val('');

                            $('#btnProsesBA').prop('disabled',false);
                            $('#btnBatalBA').prop('disabled',true);
                            $('#btnProsesAdj').prop('disabled',true);
                            $('#btnListingAdj').prop('disabled',false);

                            $('#tgl1').prop('disabled',true);
                            $('#tgl2').prop('disabled',true);

                            addRow();

                            $('#table_daftar .pluigr:eq(0)').focus();
                        },
                        error: function(error){
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

        function defaultAction(){
            $('.qtyba')
                .off()
                .on('keypress',function(e){
                    if(e.which == 13){
                        $(this).blur();
                    }
                })
                .on('blur',function(){
                    checkQtyBA($(this).closest('tr'));
                    $('.qtyba').closest('tr').find('.keterangan').select();
                });

            $('.keterangan')
                .off()
                .on('keypress',function(e){
                    if(e.which == 13){
                        if($(this).closest('tr').is(':last-child')){
                            addRow();
                            $('.pluigr:eq(-1)').focus();
                        }
                        else{
                            $(this).closest('tr').next().find('.pluigr').select();
                        }
                    }
                });
        }

        function checkQtyBA(row){
            if(row.find('.pluigr').val()){
                $.ajax({
                    url: '{{ url()->current() }}/check-qty-ba',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        noba: $('#noBA').val(),
                        plu: row.find('.pluigr').val(),
                        qty: row.find('.qtyba').val(),
                        qtysv: row.find('.qtysv').val()
                    },
                    beforeSend: function(){
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if(response.temp == 0)
                            row.find('.keterangan').focus();
                        else row.find('.qtyadj').focus();
                    },
                    error: function(error){
                        $('#modal-loader').modal('hide');

                        swal({
                            title: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {
                            row.find('.qtyba').select();
                        });
                    }
                });
            }
        }

        function showDetail(i){
            if(arrDataBA[i]){
                $('.row-data').removeClass('selected');
                $('#row-'+i).addClass('selected');
                $('#deskripsi').val(arrDataBA[i].prd_deskripsipanjang);
                $('#unit').val(arrDataBA[i].unit);
            }
        }

        function processBA(){
            swal({
                title: 'Yakin akan proses data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    dataBA = [];

                    $('.row-data').each(function(){
                        if($(this).find('.pluidm').val()){
                            d = {
                                'pluigr' : $(this).find('.pluigr').val(),
                                'qtyst' : $(this).find('.qtysv').val(),
                                'qtyba' : $(this).find('.qtyba').val(),
                                'keterangan' : $(this).find('.keterangan').val()
                            };

                            dataBA.push(d);
                        }
                    });

                    $.ajax({
                        url: '{{ url()->current() }}/process-ba',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            noba: $('#noBA').val(),
                            tglba: $('#tglBA').val(),
                            dataBA: dataBA
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
                                getDataBA($('#noBA').val());
                                window.open(`{{ url()->current() }}/print-ba?noba=${response.noba}`,'_blank');
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

        function cancelBA(){
            swal({
                title: 'Yakin ingin membatalkan?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    $.ajax({
                        url: '{{ url()->current() }}/cancel-ba',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            noba: $('#noBA').val(),
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

        function processAdjust(){
            swal({
                title: 'Yakin akan proses data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    dataBA = [];

                    $('.row-data').each(function(){
                        if($(this).find('.pluidm').val()){
                            d = {
                                'pluigr' : $(this).find('.pluigr').val(),
                                'qtyst' : $(this).find('.qtysv').val(),
                                'qtyadj' : $(this).find('.qtyadj').val(),
                            };

                            dataBA.push(d);
                        }
                    });

                    $.ajax({
                        url: '{{ url()->current() }}/process-adjust',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            noba: $('#noBA').val(),
                            dataBA: dataBA
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
                                getDataBA($('#noBA').val());
                                $('#userAdj').val(response.useradj);
                                $('#tglAdj').val(response.tgladj);
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

        function listingAdjust(){
            $('.tgl').prop('disabled',false);
            $('#tgl1').val(formatDate('now')).select();
            $('#tgl2').val(formatDate('now'));
        }

        $('.tgl').on('change',function(){
            if(!this.value){
                swal({
                    title: 'Tanggal '+ ($(this).attr('id') == 'tgl1' ? '1' : '2') + ' tidak boleh null!',
                    icon: 'warning'
                }).then(() => {
                    $(this).select();
                });
            }
            else if($('#tgl1').val() > $('#tgl2').val()){
                swal({
                    title: 'Salah inputan periode tanggal proses!',
                    icon: 'warning'
                }).then(() => {
                    $(this).select();
                });
            }
        });

        $('#tgl1').on('keypress',function(event){
            if(event.which == 13){
                if(!this.value){
                    swal({
                        title: 'Tanggal 1 tidak boleh null!',
                        icon: 'warning'
                    }).then(() => {
                        $(this).select();
                    });
                }
                else if($('#tgl1').val() > $('#tgl2').val()){
                    swal({
                        title: 'Salah inputan periode tanggal proses!',
                        icon: 'warning'
                    }).then(() => {
                        $(this).select();
                    });
                }
            }
        });

        $('#tgl2').on('keypress',function(event){
            if(event.which == 13){
                if(!this.value){
                    swal({
                        title: 'Tanggal 2 tidak boleh null!',
                        icon: 'warning'
                    }).then(() => {
                        $(this).select();
                    });
                }
                else if($('#tgl1').val() > $('#tgl2').val()){
                    swal({
                        title: 'Salah inputan periode tanggal proses!',
                        icon: 'warning'
                    }).then(() => {
                        $(this).select();
                    });
                }
                else{
                    window.open(`{{ url()->current() }}/print-list?tgl1=${$('#tgl1').val()}&tgl2=${$('#tgl2').val()}`,'_blank');
                    $('#noBA').select();
                }
            }
        });
    </script>

@endsection
