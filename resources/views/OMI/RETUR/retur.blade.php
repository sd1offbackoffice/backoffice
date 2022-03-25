@extends('navbar')
@section('title','RETUR | OMI')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm"></div>
            <div class="col-sm-5">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">Retur OMI</legend>
                    <div class="card-body pt-0">
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Nomor Dokumen</label>
                            <div class="col-sm-5 buttonInside">
                                <input type="text" class="form-control text-left" id="nodoc">
                                <button id="" type="button" class="btn btn-primary btn-lov btn-lov-nodoc p-0" onclick="showLovNodoc()" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <button id="btn_new" class="col-sm-4 btn btn-primary" onclick="newDoc()">New Dokumen</button>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Tgl Dokumen</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="tgldoc" disabled>
                            </div>
                            <button id="btn_save" class="col-sm-4 btn btn-success" onclick="saveData()">Save Dokumen</button>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Kode Member</label>
                            <div class="col-sm-3 buttonInside">
                                <input type="text" class="form-control text-left" id="kodemember">
                                <button id="btn_lov_member" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_member" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="kodetoko" disabled>
                            </div>
                            <button id="btn_delete" class="col-sm-4 btn btn-danger" onclick="deleteData()">Delete Dokumen</button>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Nomor NRB</label>
                            <div class="col-sm-5 buttonInside">
                                <input type="text" class="form-control text-left" id="nomornrb">
{{--                                <button id="" type="button" class="btn btn-primary btn-lov btn-lov-langganan p-0" onclick="showLovLangganan('langganan2')" disabled>--}}
{{--                                    <i class="fas fa-spinner fa-spin"></i>--}}
{{--                                </button>--}}
                            </div>
                            <button id="btn_print" onclick="print()" class="col-sm-4 btn btn-success">Print Dokumen</button>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Tgl NRB</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="tglnrb" autocomplete="off">
                            </div>
                            <button id="btn_csv" onclick="csvEfaktur()" class="col-sm-4 btn btn-primary">CSV eFaktur</button>
                        </div>
                        <div class="row mb-1" id="div_namafile" style="display: none">
                            <label class="col-sm-3 text-right col-form-label pl-0">Nama File</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="namafile">
                            </div>
                        </div>
                        <div class="row mb-1" id="div_alldoc" style="display: none">
                            <label class="col-sm-3 text-right col-form-label pl-0">All Dokumen Retur</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="alldoc">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-5">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">Referensi Harga Struk OMI</legend>
                    <div class="card-body pt-0">
                        <div class="row mb-1">
                            <label class="col-sm-4 text-center col-form-label pl-0">Tgl Transaksi</label>
                            <label class="col-sm-8 text-center col-form-label pl-0">Qty</label>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4"></div>
                            <label class="col-sm-4 text-center col-form-label pl-0">Sales</label>
                            <label class="col-sm-4 text-center col-form-label pl-0">Pemenuhan ( Include PPN )</label>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="hso_tgl1" disabled>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="hso_qty1" disabled>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="hso_hrgsatuan1" disabled>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="hso_tgl2" disabled>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="hso_qty2" disabled>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="hso_hrgsatuan2" disabled>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="hso_tgl3" disabled>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="hso_qty3" disabled>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="hso_hrgsatuan3" disabled>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <fieldset class="card border-secondary" id="data-field">
                    <div class="card-body pt-0">
                        <table class="table table bordered table-sm mt-3" id="table_data">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th></th>
                                <th>PLU</th>
                                <th>Harga Satuan<br>( Include PPN )</th>
                                <th>Total</th>
                                <th>Qty ( In PCS )</th>
                                <th>Qty<br>Realisasi</th>
                                <th>Qty<br>Selisih</th>
                                <th>Qty<br>Layak Jual</th>
                                <th>Qty Tidak<br>Layak Jual</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="deskripsi" disabled>
                            </div>
                            <label class="col-sm-1 text-right col-form-label pl-0">Nama Driver</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-left" id="namadriver" disabled>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="col-sm"></div>
    </div>

    <div class="modal fade" id="m_lov_nodoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_nodoc">
                                    <thead>
                                    <tr>
                                        <th>No Dokumen</th>
                                        <th>Tgl Dokumen</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_member" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_member">
                                    <thead>
                                    <tr>
                                        <th>Kode OMI</th>
                                        <th>Kode Member</th>
                                        <th>Nama Member</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_print" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container" id="button_field">
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" id="btn_listing-manual" onclick="printDoc('listing-manual')">Listing Manual</button>
                            <button class="ml-1 col-sm btn btn-primary" id="btn_bpb-manual" onclick="printDoc('bpb-manual')">BPB Manual</button>
                        </div>
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" id="btn_listing" onclick="printDoc('listing')">Listing</button>
                            <button class="ml-1 col-sm btn btn-primary" id="btn_bpb" onclick="printDoc('bpb')">BPB</button>
                        </div>
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" id="btn_nota-barang-retur" onclick="printDoc('nota-barang-retur')">Nota Barang Retur</button>
                            <button class="ml-1 col-sm btn btn-primary" id="btn_nota-barang-rusak" onclick="printDoc('nota-barang-rusak')">Nota Barang Rusak</button>
                        </div>
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" id="btn_selisih" onclick="printDoc('selisih')">Selisih</button>
                            <button class="ml-1 col-sm btn btn-primary" id="btn_struk" onclick="printDoc('struk')">Struk</button>
                            <button class="ml-1 col-sm btn btn-primary" id="btn_reset" onclick="printDoc('reset')">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_transfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container" id="button_field">
                        <div class="row form-group">
                            <label class="col-sm-1 text-right col-form-label pl-0">File</label>
                            <div class="col-sm-8 pr-0">
                                <input type="text" class="form-control text-left" id="fileRInfo" disabled>
                            </div>
                            <input type="file" class="d-none" id="fileR">
                            <button id="btn_file" class="col-sm btn btn-secondary ml-0 mr-2" onclick="chooseFileR()">...</button>
                            <button id="btn_transfer" class="col-sm-2 btn btn-primary" onclick="transferFileR()">Transfer File</button>
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

        .selected{
            background-color: lightgrey !important;
        }
    </style>

    <script>
        var arrData = [];
        var arrCurrData = [];
        var arrAdtData = [];
        var paramTypeRetur;
        var pkp;
        var paramVB;
        var paramStatusBaru;
        var tableRow;
        var noreset;
        var fileR;

        $(document).ready(function(){
            $('#tglnrb').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            makeDataTable();

            getLovNodoc('');
            getLovMember();

            popUpEdit();
        });

        function makeDataTable(){
            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().destroy();
            }

            $('#table_data').dataTable({
                ordering: false,
                searching: false,
                lengthChange: false,
                paging: false,
                scrollY: "350px",
            });
        }

        function getLovNodoc(value){
            tableLovNodoc = $('#table_lov_nodoc').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-lov-nodoc',
                    data: {
                        "search": value
                    }
                },
                "columns": [
                    {data: 'nodoc'},
                    {data: 'tgl'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-nodoc').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#table_lov_nodoc_filter input').addClass('text-uppercase').val(value);

                    $('.btn-lov-nodoc').prop('disabled', false).html('').append('<i class="fas fa-question"></i>');

                    $(document).on('click', '.row-lov-nodoc', function (e) {
                        $('#nodoc').val($(this).find('td:eq(0)').html());
                        $('#tgldoc').val($(this).find('td:eq(1)').html());

                        getData($('#nodoc').val());

                        $('#m_lov_nodoc').modal('hide');
                    });
                }
            });

            $('#table_lov_nodoc_filter input').val(value).focus();

            $('#table_lov_nodoc_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    tableLovNodoc.destroy();
                    getLovNodoc($(this).val().toUpperCase());
                }
            });
        }

        function getLovMember(){
            tableLovMember = $('#table_lov_member').DataTable({
                "ajax": '{{ url()->current() }}/get-lov-member',
                "columns": [
                    {data: 'tko_kodeomi'},
                    {data: 'cus_kodemember'},
                    {data: 'cus_namamember'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-member').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    // $('#table_lov_member_filter input').addClass('text-uppercase').val(value);
                    //
                    $('#btn_lov_member').prop('disabled', false).html('').append('<i class="fas fa-question"></i>');
                    //
                    $(document).on('click', '.row-lov-member', function (e) {
                        $('#kodetoko').val($(this).find('td:eq(0)').html());
                        $('#kodemember').val($(this).find('td:eq(1)').html());

                        $('#m_lov_member').modal('hide');
                    });
                }
            });
        }

        $('#m_lov_member').on('close.bs.modal', function(){
            $('#nomornb').select();
        });

        $('#m_lov_nodoc').on('shown.bs.modal',function(){
            $('#table_lov_nodoc_filter input').select();
        });

        function showLovNodoc(){
            $('#m_lov_nodoc').modal('show');
        }

        function popUpEdit(){
            @if($nomorEdit != '')
                swal({
                    title: '{{ $nomorEdit }}',
                    icon: 'warning'
                }).then(function(){
                    popUpCek()
                });
            @else
                popUpCek();
            @endif
        }

        function popUpCek(){
            @if($nomorCek != '')
                swal({
                    title: '{{ $nomorCek }}',
                    icon: 'warning'
                }).then(function(){
                    popUpRetur()
                });
            @else
                popUpRetur();
            @endif
        }

        function popUpRetur(){
            swal({
                title: 'Input Retur?',
                icon: 'warning',
                buttons: {
                    M: "Manual",
                    T: "Otomatis dari file"
                },
                closeOnClickOutside: false
            }).then(function(result){
                paramTypeRetur = result;

                initial();

                if(paramTypeRetur == 'M'){
                    $('#nodoc').select();
                }
                else{
                    $('#m_transfer').modal('show');
                }
            });
        }

        function initial(){
            lok = true;

            if(paramTypeRetur === 'M'){
                $('#div_namafile').hide();
                $('#div_alldoc').hide();
                $('#alldoc').val('');
            }
            else{
                $('#div_namafile').show();
                $('#div_alldoc').show();
            }

            if(lok){
                $('#btn_delete').prop('disabled',true);
                $('#btn_print').prop('disabled',true);
                $('#btn_csv').prop('disabled',true);
                $('#namadriver').prop('disabled',true);
            }
        }

        function newDoc(){
            popUpRetur();

            clearData();
        }

        $('#nodoc').on('keypress',function(event){
            if(event.which == 13){
                lok = true;

                if(paramTypeRetur == 'M'){
                    $('#alldoc').val('');
                }
                else{
                    if(!$(this).val()){
                        swal({
                            title: 'Nomor dokumen yang diisi harus berasal dari nomor dokumen hasil transferan!',
                            icon: 'error'
                        }).then(() => {
                            $(this).select();
                            lok = false;
                            clearData();
                        });
                        return false;
                    }
                }

                if(lok){
                    $('#btn_delete').prop('disabled',true);
                    $('#btn_print').prop('disabled',true);
                    $('#btn_csv').prop('disabled',true);
                    $('#namadriver').prop('disabled',true);

                    if(!$(this).val()){
                        if(paramTypeRetur == 'M'){
                            //field qty
                        }
                        else{
                            //field qty
                        }

                        swal({
                            title: 'Buat Nomor Retur OMI baru?',
                            icon: 'warning',
                            buttons: true,
                            dangerMode: true
                        }).then((result)=>{
                            if(result){
                                getNewNodoc();
                            }
                            else $('#nodoc').select();
                        });
                    }
                    else{
                        getData($(this).val());
                    }
                }
            }
        });

        function getNewNodoc(){
            $.ajax({
                url: '{{ url()->current() }}/get-new-nodoc',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    clearData();

                    $('#nodoc').val(response.nodoc);
                    $('#tgldoc').val(formatDate('now'));

                    $('#kodemember').select();
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

        $('#kodemember').on('keypress',function(event){
            if(event.which === 13 && $(this).val()){
                checkMember();
            }
        });

        function checkMember(){
            $.ajax({
                url: '{{ url()->current() }}/check-member',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    kodemember: $('#kodemember').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    pkp = response.pkp;
                    $('#kodetoko').val(response.kodetoko);

                    $('#nomornrb').select();
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#kodemember').select();
                    });
                }
            });
        }

        $('#nomornrb').on('keypress',function(event){
            if(event.which === 13){
                if(!$(this).val()){
                    swal({
                        title: 'Nomor NRP tidak boleh kosong!',
                        icon: 'warning'
                    }).then(() => {
                        $(this).select();
                    });
                }
                else{
                    if(!$('#tglnrb').val()){
                        $('#tglnrb').val(formatDate('now')).select();
                    }
                    else checkNRB();
                }
            }
        });

        $('#tglnrb').on('keypress',function(event){
            if(event.which == 13){
                if(!$(this).val()){
                    swal({
                        title: 'Tanggal NRB tidak boleh kosong!',
                        icon: 'warning'
                    }).then(() => {
                        $(this).select();
                    });
                }
                else{
                    checkNRB();
                }
            }
        });

        function checkNRB(){
            if(!$('#kodetoko').val()){
                swal({
                    title: 'Kode toko belum diisi!',
                    icon: 'warning'
                }).then(() => {
                    $('#kodetoko').select();
                });
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/check-nrb',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        kodetoko: $('#kodetoko').val(),
                        nonrb: $('#nonrb').val(),
                        tglnrb: $('#tglnrb').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        addRow();
                        paramStatusBaru = 'Y';
                        $('#btn_save').prop('disabled',false);

                        $('#table_data tbody tr').find('.prdcd').select();
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {
                            $('#nomornrb').select();
                        });
                    }
                });
            }
        }

        function getData(nodokumen){
            $.ajax({
                url: '{{ url()->current() }}/get-data',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    nodokumen: nodokumen
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    paramStatusBaru = 'N';
                    arrAdtData = [];
                    arrData = [];
                    arrCurrData = [];

                    if($.fn.DataTable.isDataTable('#table_data')){
                        $('#table_data').DataTable().clear().destroy();
                    }

                    tableRow = response.length;

                    arrAdtData = response;

                    for(i=0;i<response.length;i++){
                        $('#table_data tbody').append(`
                            <tr id="row-data-${i}" onmouseover="showDesc(${i})">
                                <td class="align-middle"><button class="btn btn-danger btn-delete" onclick="deleteRow(${i})"><i class="fas fa-times"></i></button></td>
                                <td class="align-middle"><input type="text" maxlength="7" onkeypress="getPRDCD(${i}, event)" class="form-control prdcd" value="${response[i].rom_prdcd}"></td>
                                <td class="align-middle"><input disabled class="form-control text-right harga" value="${convertToRupiah2(response[i].rom_hrg)}"></td>
                                <td class="align-middle"><input disabled class="form-control text-right total" value="${convertToRupiah2(response[i].rom_ttl)}"></td>
                                <td class="align-middle"><input type="number" onchange="fnQTY(${i}, event, true)" onkeypress="fnQTY(${i}, event, false)" class="form-control text-right qty" value="${response[i].rom_qty}"></td>
                                <td class="align-middle"><input disabled class="form-control text-right realisasi" value="${response[i].rom_qtyrealisasi}" onkeyup="checkQty(this.value, ${i})"></td>
                                <td class="align-middle"><input disabled class="form-control text-right selisih" value="${response[i].rom_qtyselisih}"></td>
                                <td class="align-middle"><input disabled class="form-control text-right jual" value="${response[i].rom_qtymlj}" onkeyup="checkQtyJual(this.value, ${i})"></td>
                                <td class="align-middle"><input disabled class="form-control text-right nonjual" value="${response[i].rom_qtytlj}" onkeyup="checkQtyNonJual(this.value, ${i})"></td>
                            </tr>
                        `);
                    }

                    makeDataTable();

                    $('#deskripsi').val('');
                    arrData = response;

                    d = arrData[0];

                    $('#tgldoc').val(d.rom_tgldokumen);
                    $('#kodemember').val(d.rom_member);
                    $('#kodetoko').val(d.rom_kodetoko);
                    $('#nomornrb').val(d.rom_noreferensi);
                    $('#tglnrb').val(d.rom_tglreferensi);
                    $('#namadriver').val(d.rom_namadrive);

                    if(d.rom_referensistruk == 'VB')
                        paramVB = 'Y';
                    else paramVB = 'N';

                    paramStatusBaru = 'N';

                    $('#btn_delete').prop('disabled',false);
                    $('#btn_new').prop('disabled',false);
                    $('#btn_print').prop('disabled',true);

                    if(d.rom_statusdata == '1'){
                        paramTypeRetur = 'M';
                        $('.qty').prop('disabled',false);
                        $('.realisasi').prop('disabled',true);
                        $('.selisih').prop('disabled',true);
                        $('.jual').prop('disabled',true);
                        $('.nonjual').prop('disabled',true);
                    }
                    else{
                        paramTypeRetur = 'T';
                        $('.btn-delete').prop('disabled',true);
                        $('.prdcd').prop('disabled',true);
                        $('.qty').prop('disabled',true);
                        $('.realisasi').prop('disabled',false);
                        $('.selisih').prop('disabled',true);
                        $('.jual').prop('disabled',true);
                        $('.nonjual').prop('disabled',false);
                    }

                    if(d.rom_recordid == '2'){
                        $('.btn-delete').prop('disabled',true);
                        $('.qty').prop('disabled',true);
                        $('.realisasi').prop('disabled',true);
                        $('.selisih').prop('disabled',true);
                        $('.jual').prop('disabled',true);
                        $('.nonjual').prop('disabled',true);

                        $('.prdcd').prop('disabled',true);
                        $('#btn_csv').prop('disabled',false);
                    }

                    showDesc(0);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#modal-loader').modal('hide');

                        $('#nodoc').select();
                    });
                }
            });
        }

        function checkQty(qtyRealisasi, row){
            curr = $('#row-data-'+row);

            qtyRealisasi = nvl(qtyRealisasi, 0);

            qtyRetur = curr.find('.qty').val();

            if(parseInt(qtyRealisasi) == 0 && paramTypeRetur == 'M'){
                swal({
                    title: 'Qty realisasi Retur OMI tidak boleh 0!',
                    icon: 'error'
                }).then(() => {
                    curr.find('.realisasi').select();
                });
            }
            else{
                if(parseInt(qtyRealisasi) < 0){
                    swal({
                        title: 'Qty realisasi tidak boleh lebih kecil dari 0!',
                        icon: 'error'
                    }).then(() => {
                        curr.find('.realisasi').val(0).select();
                    });
                }
                else{
                    if(parseInt(qtyRealisasi) > parseInt(qtyRetur)){
                        swal({
                            title: 'Qty realisasi tidak boleh lebih besar dari qty retur!',
                            icon: 'error'
                        }).then(() => {
                            curr.find('.realisasi').val(0).select();
                        });
                    }
                    else{
                        selisih = parseInt(qtyRetur) - parseInt(qtyRealisasi);
                        curr.find('.selisih').val(selisih);

                        if(selisih > 0){
                            $('#namadriver').prop('disabled',false);
                        }

                        curr.find('.jual').val(parseInt(qtyRealisasi));
                        curr.find('.nonjual').val(0);
                    }
                }
            }
        }

        function checkQtyJual(qtyJual, row){
            curr = $('#row-data-'+row);

            if(parseInt(qtyJual) == 0){
                swal({
                    title: 'Qty masih layak jual Retur OMI tidak boleh 0!',
                    icon: 'error'
                }).then(() => {
                    curr.find('.jual').select();
                });
            }
            else{
                curr.find('.nonjual').val(parseInt(curr.find('.realisasi').val()) - parseInt(qtyJual)).focus();
            }
        }

        function checkQtyNonJual(qtyNonJual, row){
            curr = $('#row-data-'+row);

            if(parseInt(qtyNonJual) < 0){
                swal({
                    title: 'Qty tidak layak jual Retur OMI tidak boleh kurang dari 0!',
                    icon: 'error'
                }).then(() => {
                    curr.find('.nonjual').select();
                });
            }
            else{
                if(parseInt(curr.find('.realisasi').val()) == 0 && parseInt(qtyNonJual) > 0){
                    swal({
                        title: 'Qty tidak layak jual tidak boleh diisi karena Qty Realisasi 0!',
                        icon: 'error'
                    }).then(() => {
                        curr.find('.nonjual').val(0).select();
                    });
                }
                else{
                    if(parseInt(qtyNonJual) > parseInt(curr.find('.realisasi').val())){
                        swal({
                            title: 'Qty tidak layak jual tidak boleh lebih besar dari Qty Realisasi!',
                            icon: 'error'
                        }).then(() => {
                            curr.find('.nonjual').val(0).select();
                        });
                    }
                    else{
                        curr.find('.jual').val(parseInt(curr.find('.realisasi').val()) - parseInt(qtyNonJual));
                        // $('#row-data-'+(row+1)).find('.realisasi').select();
                    }
                }
            }
        }

        function showDesc(index){
            if(typeof arrAdtData[index] != 'undefined'){
                $('#deskripsi').val(arrAdtData[index].prd_deskripsipanjang);

                $('#hso_tgl1').val(arrAdtData[index].hso_tgldokumen1);
                $('#hso_tgl2').val(arrAdtData[index].hso_tgldokumen2);
                $('#hso_tgl3').val(arrAdtData[index].hso_tgldokumen3);

                $('#hso_qty1').val(arrAdtData[index].hso_qty1);
                $('#hso_qty2').val(arrAdtData[index].hso_qty2);
                $('#hso_qty3').val(arrAdtData[index].hso_qty3);

                $('#hso_hrgsatuan1').val(convertToRupiah2(arrAdtData[index].hso_hrgsatuan1));
                $('#hso_hrgsatuan2').val(convertToRupiah2(arrAdtData[index].hso_hrgsatuan2));
                $('#hso_hrgsatuan3').val(convertToRupiah2(arrAdtData[index].hso_hrgsatuan3));
            }
            else{
                $('#deskripsi').val('');
                $('#hso_tgl1').val('');
                $('#hso_tgl2').val('');
                $('#hso_tgl3').val('');
                $('#hso_qty1').val('');
                $('#hso_qty2').val('');
                $('#hso_qty3').val('');
                $('#hso_hrgsatuan1').val('');
                $('#hso_hrgsatuan2').val('');
                $('#hso_hrgsatuan3').val('');
            }

            $('.selected').removeClass('selected');
            $('#row-data-'+index).addClass('selected');
        }

        function deleteData(){
            if(arrData[0].rom_statusdata == '2'){
                swal({
                    title: 'Data Retur OMI via DCP tidak dapat dibatalkan!',
                    icon: 'error'
                })
            }
            else{
                swal({
                    title: 'Yakin ingin menghapus data dengan nomor dokumen '+$('#nodoc').val()+' ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((result) => {
                    if(result){
                        $.ajax({
                            url: '{{ url()->current() }}/delete-data',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                nodoc: $('#nodoc').val(),
                                tgldoc: $('#tgldoc').val(),
                                kodemember: $('#kodemember').val()
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(function(){
                                    clearData();

                                    tableLovNodoc.destroy();
                                    getLovNodoc('');

                                    $('#btn_delete').prop('disabled',true);
                                    $('#btn_print').prop('disabled',true);
                                    $('#btn_csv').prop('disabled',true);
                                    $('#namadriver').prop('disabled',true);

                                    $('#nodoc').select();
                                })
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
                });
            }
        }

        function clearData(){
            $('#btn_new').prop('disabled',false);
            $('#btn_save').prop('disabled',true);
            $('#btn_delete').prop('disabled',true);
            $('#btn_print').prop('disabled',true);
            $('#btn_csv').prop('disabled',true);

            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().clear().destroy();
            }

            makeDataTable();

            arrData = [];
            arrAdtData = [];
            arrCurrData = [];
            tableRow = 0;

            $('input').val('');
        }

        function deleteRow(index){
            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().destroy();
            }

            $('#deskripsi').val('');

            $('#row-data-'+index).remove();

            arrData[index] = null;
            arrAdtData[index] = null;
            arrCurrData[index] = null;

            makeDataTable();
        }

        function addRow(){
            if(
                typeof $('#table_data tbody tr:last').find('.prdcd').val() == 'undefined' ||
                (typeof $('#table_data tbody tr:last').find('.prdcd').val() != 'undefined' &&
                $('#table_data tbody tr:last').find('.prdcd').val() != '')
            ){
                if($.fn.DataTable.isDataTable('#table_data')){
                    $('#table_data').DataTable().destroy();
                }

                row = tableRow++;

                $('#table_data tbody').append(`
                <tr id="row-data-${row}" onmouseover="showDesc(${row})">
                    <td class="align-middle"><button class="btn btn-danger btn-delete" onclick="deleteRow(${row})"><i class="fas fa-times"></i></button></td>
                    <td class="align-middle"><input type="text" maxlength="7" onkeypress="getPRDCD(${row}, event)" class="form-control prdcd"></td>
                    <td class="align-middle"><input disabled class="form-control text-right harga"></td>
                    <td class="align-middle"><input disabled class="form-control text-right total"></td>
                    <td class="align-middle"><input type="number" onchange="fnQTY(${row}, event, true)" onkeypress="fnQTY(${row}, event, false)" class="form-control text-right qty"></td>
                    <td class="align-middle"><input disabled class="form-control text-right realisasi"></td>
                    <td class="align-middle"><input disabled class="form-control text-right selisih"></td>
                    <td class="align-middle"><input disabled class="form-control text-right jual" onkeyup="checkQtyJual(this.value, ${row})"></td>
                    <td class="align-middle"><input disabled class="form-control text-right nonjual" onkeyup="checkQtyNonJual(this.value, ${row})"></td>
                </tr>
            `);

                makeDataTable();
            }

            $('#table_data tbody tr:last').find('.prdcd').select();
        }

        function getPRDCD(row, event){
            if(event.which == 13){
                found = 0;
                plu = convertPlu($('#row-data-'+row).find('.prdcd').val());

                $('.prdcd').each(function(){
                    if($(this).val() == plu){
                        found++;
                    }
                });

                if(found > 1){
                    $('#table_data tbody tr:eq('+row+')').find('.prdcd').val(plu);

                    swal({
                        title: 'PLU '+plu+' sudah ada!',
                        icon: 'error'
                    }).then(() => {
                        $('#table_data tbody tr:eq('+row+')').find('.prdcd').select();
                    });
                }
                else{
                    $.ajax({
                        url: '{{ url()->current() }}/get-prdcd',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            prdcd: $('#row-data-'+row).find('.prdcd').val(),
                            nodoc: $('#nodoc').val(),
                            tgldoc: $('#tgldoc').val(),
                            kodemember: $('#kodemember').val()
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            currRow = $('#row-data-'+row);

                            currRow.find('.prdcd').val(response.prd_prdcd)

                            arrAdtData[row] = {
                                'rom_avgcost' : response.st_avgcost,
                                'rom_flagbkp' : response.prd_flagbkp1,
                                'rom_flagbkp2' : response.prd_flagbkp2,
                                'prd_deskripsipanjang' : response.prd_deskripsipanjang,
                                'rom_prdcd' : response.prd_prdcd,
                                'hso_tgldokumen1' : response.hso_tgldokumen1,
                                'hso_qty1' : response.hso_qty1,
                                'hso_hrgsatuan1' : response.hso_hrgsatuan1,
                                'hso_tgldokumen2' : response.hso_tgldokumen2,
                                'hso_qty2' : response.hso_qty2,
                                'hso_hrgsatuan2' : response.hso_hrgsatuan2,
                                'hso_tgldokumen3' : response.hso_tgldokumen3,
                                'hso_qty3' : response.hso_qty3,
                                'hso_hrgsatuan3' : response.hso_hrgsatuan3,
                            };

                            if(paramTypeRetur == 'T')
                                currRow.find('.realisasi').select();
                            else currRow.find('.qty').select();

                            // arrData[row] = {
                            //     'prd_deskripsipanjang' : response.prd_deskripsipanjang,
                            //     'rom_prdcd' : response.prd_prdcd,
                            // };

                            showDesc(row);
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: 'Terjadi kesalahan!',
                                text: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {
                                $('#table_data tbody tr:eq('+row+')').find('.prdcd').select();
                            });
                        }
                    });
                }
            }
        }

        function fnQTY(row, event, status){
            curr = $('#row-data-'+row);
            if(event.which == 13 || status){
                if(nvl(curr.find('.qty').val(),0) == 0){
                    swal({
                        title: 'Qty Retur OMI tidak boleh 0!',
                        icon: 'warning'
                    }).then(() => {
                        curr.find('.qty').select();
                    });
                }
                else{
                    if(paramTypeRetur == 'T'){
                        curr.find('.total').val(curr.find('.qty').val() * curr.find('.harga').val());
                        curr.find('.selisih').val(nvl(curr.find('.qty'), 0) - nvl(curr.find('.realisasi'), 0));
                        curr.find('.jual').val(curr.find('.realisasi').val());
                        curr.find('.nonjual').val(nvl(curr.find('.realisasi'), 0) - nvl(curr.find('.jual'), 0));

                        //txt_ada

                        curr.find('.realisasi').select();
                    }
                    else{
                        curr.find('.total').val(curr.find('.harga').val());
                        curr.find('.realisasi').val(curr.find('.qty').val());
                        curr.find('.selisih').val(0);
                        curr.find('.jual').val(0);
                        curr.find('.nonjual').val(0);

                        //txt_ada

                        addRow();
                    }

                    // arrData[row].rom_hrg = curr.find('.harga').val();
                    // arrData[row].rom_ttl = curr.find('.total').val();
                    // arrData[row].rom_qty = curr.find('.qty').val();
                    // arrData[row].rom_qtyrealisasi = curr.find('.realisasi').val();
                    // arrData[row].rom_qtyselisih = curr.find('.selisih').val();
                    // arrData[row].rom_qtymlj = curr.find('.jual').val();
                    // arrData[row].rom_qtytlj = curr.find('.nonjual').val();
                }
            }
        }

        function isDataChanged(){
            arrCurrData = [];

            $('#table_data tbody tr').each(function(){
                if($(this).find('.prdcd').val() != ''){
                    d = {
                        'rom_prdcd' : $(this).find('.prdcd').val(),
                        'rom_hrg' : unconvertToRupiah($(this).find('.harga').val()),
                        'rom_ttl' : unconvertToRupiah($(this).find('.total').val()),
                        'rom_qty' : unconvertToRupiah($(this).find('.qty').val()),
                        'rom_qtyrealisasi' : unconvertToRupiah($(this).find('.realisasi').val()),
                        'rom_qtyselisih' : unconvertToRupiah($(this).find('.selisih').val()),
                        'rom_qtymlj' : unconvertToRupiah($(this).find('.jual').val()),
                        'rom_qtytlj' : unconvertToRupiah($(this).find('.nonjual').val()),
                        'rom_avgcost' : arrAdtData[$(this).index()].rom_avgcost,
                        'rom_flagbkp' : arrAdtData[$(this).index()].rom_flagbkp,
                        'rom_flagbkp2' : arrAdtData[$(this).index()].rom_flagbkp2,
                    };

                    arrCurrData.push(d);
                }
            });

            isChanged = false;

            if(arrCurrData.length == arrData.length){
                for(i=0;i<arrCurrData.length;i++){
                    for(j=0;j<arrCurrData.length;j++){
                        if(arrCurrData[i].rom_prdcd == arrData[j].rom_prdcd){
                            if(
                                arrCurrData[i].rom_prdcd != arrData[j].rom_prdcd ||
                                arrCurrData[i].rom_hrg != arrData[j].rom_hrg ||
                                arrCurrData[i].rom_ttl != arrData[j].rom_ttl ||
                                arrCurrData[i].rom_qty != arrData[j].rom_qty ||
                                arrCurrData[i].rom_qtyrealisasi != arrData[j].rom_qtyrealisasi ||
                                arrCurrData[i].rom_qtyselisih != arrData[j].rom_qtyselisih ||
                                arrCurrData[i].rom_qtymlj != arrData[j].rom_qtymlj ||
                                arrCurrData[i].rom_qtytlj != arrData[j].rom_qtytlj
                            ){
                                isChanged = true;
                                break;
                                break;
                            }
                        }
                        else isChanged = true;
                    }
                }
            }
            else isChanged = true;

            if(
                $('#kodemember').val() != nvl(arrData[0].rom_member, '') ||
                $('#kodetoko').val() != nvl(arrData[0].rom_kodetoko, '') ||
                $('#nomornrb').val() != nvl(arrData[0].rom_noreferensi, '') ||
                $('#tglnrb').val() != nvl(arrData[0].rom_tglreferensi, '') ||
                $('#namadriver').val() != nvl(arrData[0].rom_namadrive, '')
            ){
                isChanged = true;
            }
            else isChanged = false;

            return isChanged;
        }

        function saveData(){
            // if(!isDataChanged()){
            //     swal({
            //         title: 'Tidak ada perubahan!',
            //         icon: 'warning'
            //     }).then(() => {
            //         $('#btn_print').prop('disabled',false);
            //     });
            // }
            // else{
            //
            // }

            arrCurrData = [];

            qty = 0;

            $('#table_data tbody tr').each(function(){
                if($(this).find('.prdcd').val() != ''){
                    d = {
                        'rom_prdcd' : $(this).find('.prdcd').val(),
                        'rom_hrg' : unconvertToRupiah($(this).find('.harga').val()),
                        'rom_ttl' : unconvertToRupiah($(this).find('.total').val()),
                        'rom_qty' : unconvertToRupiah($(this).find('.qty').val()),
                        'rom_qtyrealisasi' : unconvertToRupiah($(this).find('.realisasi').val()),
                        'rom_qtyselisih' : unconvertToRupiah($(this).find('.selisih').val()),
                        'rom_qtymlj' : unconvertToRupiah($(this).find('.jual').val()),
                        'rom_qtytlj' : unconvertToRupiah($(this).find('.nonjual').val()),
                        'rom_avgcost' : arrAdtData[$(this).index()].rom_avgcost,
                        'rom_flagbkp' : arrAdtData[$(this).index()].rom_flagbkp,
                        'rom_flagbkp2' : arrAdtData[$(this).index()].rom_flagbkp2,
                    };

                    arrCurrData.push(d);

                    qty += parseInt(unconvertToRupiah($(this).find('.qty').val()));
                }
            });

            hitungSelisih = 0;

            $('.selisih').each(function(){
                hitungSelisih += parseInt($(this).val());
            });

            swal({
                title: 'Yakin ingin menyimpan data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((result) => {
                if(result){
                    $.ajax({
                        url: '{{ url()->current() }}/save-data',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            newData: arrCurrData,
                            typeRetur: paramTypeRetur,
                            statusBaru: paramStatusBaru,
                            kodemember: $('#kodemember').val(),
                            kodetoko: $('#kodetoko').val(),
                            nodokumen: $('#nodoc').val(),
                            tgldokumen: $('#tgldoc').val(),
                            noreferensi: $('#nomornrb').val(),
                            tglreferensi: $('#tglnrb').val(),
                            namadrive: $('#namadriver').val(),
                            hitungSelisih: hitungSelisih,
                            qty: qty
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            $('#btn_print').prop('disabled',false);
                            $('#btn_delete').prop('disabled',false);

                            swal({
                                title: response.message,
                                icon: 'success'
                            }).then(() => {
                                // getData($('#nodoc').val());
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title ? error.responseJSON.title : 'Terjadi kesalahan!',
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                        }
                    });
                }
            });
        }

        function print(){
            swal({
                title: 'Yakin ingin print data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((result) => {
                if(result){
                    hitungSelisih = 0;

                    $('.selisih').each(function(){
                        hitungSelisih += parseInt($(this).val());
                    });

                    $.ajax({
                        url: '{{ url()->current() }}/print',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            nodoc: $('#nodoc').val(),
                            tgldoc: $('#tgldoc').val(),
                            nonrb: $('#nomornrb').val(),
                            tglnrb: $('#tglnrb').val(),
                            kodemember: $('#kodemember').val(),
                            hitungSelisih: hitungSelisih,
                            driver: $('#namadriver').val(),
                            paramTypeRetur: paramTypeRetur
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
                                $('#btn_csv').prop('disabled',false);

                                $('#button_field button').prop('disabled',true);

                                for(i=0;i<response.print.length;i++){
                                    $('#btn_'+response.print[i]).prop('disabled',false);
                                }

                                noreset = response.noreset;

                                $('#m_print').modal('show');
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');

                            errorData = error.responseJSON;

                            if(errorData.type == 'TAGX'){
                                swal({
                                    title: errorData.message,
                                    icon: 'error',
                                }).then(() => {
                                    swal({
                                        title: 'Silahkan edit file R terlebih dahulu!',
                                        icon: 'warning',
                                    }).then(() => {
                                        deleteData();
                                    });
                                });
                            }
                            else if(errorData.type == 'DRIVER'){
                                swal({
                                    title: errorData.title,
                                    text: errorData.message,
                                    icon: 'error'
                                });
                            }
                            else{
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: errorData.message,
                                    icon: 'error',
                                });
                            }
                        }
                    });
                }
            });
        }

        function printDoc(type){
            if(type == 'reset')
                window.open(`{{ url()->current() }}/print-${type}?noreset=${noreset}&tgldoc=${$('#tgldoc').val()}`, '_blank');
            else window.open(`{{ url()->current() }}/print-${type}?nodoc=${$('#nodoc').val()}&tgldoc=${$('#tgldoc').val()}`, '_blank');
        }

        function csvEfaktur(){
            $.ajax({
                url: '{{ url()->current() }}/create-faktur-check',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    paramVB: paramVB,
                    kodemember: $('#kodemember').val(),
                    kodetoko: $('#kodetoko').val(),
                    nodoc: $('#nodoc').val(),
                    tgldoc: $('#tgldoc').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if(response.message == 'OK')
                        window.location.href = `{{ url()->current() }}/create-faktur?nodoc=${$('#nodoc').val()}&tgldoc=${$('#tgldoc').val()}&kodetoko=${$('#kodetoko').val()}&kodemember=${$('#kodemember').val()}`;
                },
                error: function (error) {
                    swal({
                        title: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#modal-loader').modal('hide');
                    });
                }
            });
        }

        var Upload = function (file) {
            this.file = file;
        };

        Upload.prototype.getType = function() {
            return this.file.type;
        };
        Upload.prototype.getSize = function() {
            return this.file.size;
        };
        Upload.prototype.getName = function() {
            return this.file.name;
        };

        function chooseFileR(){
            $('#fileR').click();
        }

        $('#fileR').on('change',function(e){
            if($('#fileR').val()){
                var filename = e.target.files[0].name;
                var directory = $(this).val();

                var file = $(this)[0].files[0];

                $('#fileRInfo').val(filename);

                fileR = new Upload(file);
            }
        });

        function transferFileR(){
            swal({
                title: 'Transfer file ' + fileR.getName() + ' ?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(result){
                if(result){
                    var formData = new FormData();

                    // add assoc key values, this will be posts values
                    formData.append("fileR", fileR.file, fileR.getName());
                    // formData.append("kodespi", $('#kodespi').val());

                    $.ajax({
                        type: "POST",
                        url: "{{ url()->current() }}/transfer-file-r",
                        timeout: 0,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.message,
                                icon: response.status
                            }).then(function(ok){
                                $('#m_transfer').modal('hide');
                                $('#modal-loader').modal('hide');
                                $('#fileRInfo').val('');
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {
                                $('#modal-loader').modal('hide');
                                $('#fileRInfo').val('');
                            });
                        },
                        async: true,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    });
                }
            });
        }
    </script>

@endsection
