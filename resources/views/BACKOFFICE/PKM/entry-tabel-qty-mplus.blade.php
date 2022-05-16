@extends('navbar')
@section('title','PKM | ENTRY TABEL QTY M+')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary mt-0" id="data-field">
                    <legend  class="w-auto ml-3">Tabel PLU PKMT untuk QTY M+</legend>
                    <div class="card-body pt-0" id="inputField">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Mulai PLU</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="plu">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0" onclick="showModalLovPLU()">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="deskripsi" class="col-sm-2 col-form-label text-right pl-0 pr-0">Deskripsi</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="deskripsi" disabled>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="unit" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="avgsales" class="col-sm-2 col-form-label text-right pl-0 pr-0">Average Sales</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="avgsales" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="omi" class="col-sm-2 col-form-label text-right pl-0 pr-0">OMI</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="omi" disabled>
                                    </div>
                                    <div class="col pl-0"></div>
                                    <button class="col-sm-7 btn btn-primary" id="btnPrintTag" onclick="printTag()">PRINT Tag ARNOHX, tdk ada di PRODCRM</button>
                                </div>
                                <div class="row form-group">
                                    <label for="qtymplus" class="col-sm-2 col-form-label text-right pl-0 pr-0">QTY M+</label>
                                    <div class="col-sm">
                                        <input type="number" class="form-control" id="qtymplus" disabled>
                                    </div>
                                    <label for="pkmt" class="col-sm-1 col-form-label text-right pl-0 pr-0">PKMT</label>
                                    <div class="col-sm">
                                        <input type="text" class="form-control" id="pkmt" disabled>
                                    </div>
                                    <button class="col-sm-2 mr-1 btn btn-primary" id="btnPrintAll" onclick="printAll()">PRINT ALL</button>
                                    <button class="col-sm-2 mr-1 btn btn-secondary" id="btnUploadCSV" onclick="">UPLOAD CSV</button>
                                    <button class="col-sm-1 mr-1 btn btn-success" id="btnSave" onclick="save()">SAVE</button>
                                    <button class="col btn btn-danger" id="btnDelete" onclick="deleteData()">DELETE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary mt-0" id="data-field">
                    <legend  class="w-auto ml-3">All Data PLU PKMT untuk QTY M+</legend>
                    <div class="card-body pt-0">
                        <table class="table table bordered table-sm mt-3" id="table_data">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th class="align-middle">PLU</th>
                                <th class="align-middle">Average Sales</th>
                                <th class="align-middle">OMI</th>
                                <th class="align-middle">QTY M+</th>
                                <th class="align-middle">PKMT</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="row form-group">
                            <label for="deskripsi" class="col-sm-1 col-form-label text-right pl-0 pr-0">Deskripsi</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="all_deskripsi" disabled>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="all_unit" disabled>
                            </div>
                        </div>
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
                                        <th>Satuan</th>
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

    <div class="modal fade" id="m_otorisasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row text-center">
                            <label for="i_username" class="col-sm-12 text-center col-form-label">Masukkan username dan password untuk melanjutkan</label>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-sm-2"></div>
                            <label for="i_username" class="col-sm-2 pl-0 col-form-label">Username</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control text-uppercase" id="i_username">
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-sm-2"></div>
                            <label for="i_password" class="col-sm-2 pl-0 col-form-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control text-uppercase" id="i_password">
                            </div>
                            <div class="col-sm-2"></div>
                        </div>
                        <div class="form-group row text-center">
                            <div class="col-sm"></div>
                            <button id="btnCancel" class="btn col-sm-4 mr-1 btn-secondary" onclick="$('#m_otorisasi').modal('hide')">CANCEL</button>
                            <button id="btnLogin" class="btn col-sm-4 ml-1 btn-danger" onclick="uploadCSV()">OK</button>
                            <div class="col-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .row-all-data{
            cursor: pointer;
        }
    </style>

    <script>
        var index = -1;
        var arrData = [];
        var currField = null;
        var tableData;
        var baru, qtyminor;

        $(document).ready(function () {
            getModalData('');
            getTableData();
            $('#plu').focus();
        });

        $('#tanggal').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        function showModalLovPLU(){
            $('#m_lov_plu').modal('show');
        }

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
                    {data: 'satuan', name: 'satuan'},
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

                    $(".row-plu").prop("onclick", null).off("click");

                    $(document).on('click', '.row-plu', function (e) {
                        getDataPLU($(this).find('td:eq(1)').html());

                        $('#m_lov_plu').modal('hide');
                    });
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

        $('#plu').on('keypress',function(e){
            if(e.which == 13) {
                getDataPLU($(this).val());
            }
        });

        function getDataPLU(plu){
            if(plu.substr(-1) != '0'){
                swal({
                    title: 'PLU harus satuan jual 0!',
                    icon: 'error'
                }).then(() => {
                    $('#plu').select();
                });
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/get-data-plu',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        plu: convertPlu(plu)
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        $('#plu').val(response.prd_prdcd);
                        $('#deskripsi').val(response.prd_deskripsipanjang);
                        $('#unit').val(response.prd_unit);
                        $('#avgsales').val(response.pkm_qtyaverage);
                        $('#omi').val(response.omi);
                        $('#qtymplus').prop('disabled',false).val(response.qtym).select();
                        $('#pkmt').val(response.pkm_pkmt);
                        baru = response.baru;
                        qtyminor = response.qtyminor;
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        // handle error
                        swal({
                            title: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {
                            $('#plu').select();
                            $('#deskripsi').val('');
                        });
                    }
                });
            }
        }

        function getTableData(){
            tableData = $('#table_data').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-table-data',
                },
                "columns": [
                    {data: 'pkmp_prdcd'},
                    {data: null, render: function(data){
                            return convertToRupiah(data.pkm_qtyaverage);
                        }
                    },
                    {data: 'omi'},
                    {data: 'pkmp_qtyminor'},
                    {data: 'pkm_pkmt'},
                ],
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "scrollY" : "230px",
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-center');
                    $(row).find(':eq(1)').addClass('text-right');
                    $(row).find(':eq(2)').addClass('text-center');
                    $(row).find(':eq(3)').addClass('text-right');
                    $(row).find(':eq(4)').addClass('text-right');
                    $(row).addClass('row-all-data');
                    $(row).on('click',function(){
                        $('.row-all-data').removeClass('selected');
                        $(this).addClass('selected');
                        $('#all_deskripsi').val(data.prd_deskripsipanjang);
                        $('#all_unit').val(data.unit);
                    });
                },
                "initComplete" : function(){

                }
            });
        }

        $('#qtymplus').on('keypress',function(e){
            if(e.which == 13){
                $('#btnSave').focus();
            }
        });

        function save(){
            swal({
                title: 'Yakin ingin menyimpan data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((ok) => {
                if(!ok){
                    $('#btnSave').focus();
                }
                else{
                    $.ajax({
                        url: '{{ url()->current() }}/save',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            plu: convertPlu($('#plu').val()),
                            qtymplus: $('#qtymplus').val(),
                            baru: baru,
                            qtyminor: qtyminor
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.title,
                                icon: 'success'
                            }).then(() => {
                                $('#inputField input').val('');
                                tableData.ajax.reload();
                                $('#plu').focus();
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            // handle error
                            swal({
                                title: 'Terjadi kesalahan!',
                                text: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {

                            });
                        }
                    });
                }
            })
        }

        function deleteData(){
            swal({
                title: 'Yakin ingin menghapus data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((ok) => {
                if(!ok){
                    $('#btnDelete').focus();
                }
                else{
                    $.ajax({
                        url: '{{ url()->current() }}/delete',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            plu: convertPlu($('#plu').val())
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.title,
                                icon: 'success'
                            }).then(() => {
                                $('#inputField input').val('');
                                tableData.ajax.reload();
                                $('#plu').focus();
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            // handle error
                            swal({
                                title: 'Terjadi kesalahan!',
                                text: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {

                            });
                        }
                    });
                }
            })
        }

        $('#btnUploadCSV').on('click',function(){
            swal({
                title: 'Yakin upload nilai M Plus?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((ok) => {
                if(ok){
                    $('#m_otorisasi').modal({backdrop: 'static', keyboard: false});
                    $('#m_otorisasi input').val('');

                    $('#i_username').focus();
                }
            });
        });

        $('#m_otorisasi').on('shown.bs.modal',function(){
            $('#i_username').focus();
        });

        $('#i_username').on('keypress',function(e){
            if(e.which == 13){
                $('#i_password').select();
            }
        });

        $('#i_password').on('keypress',function(e){
            if(e.which == 13){
                uploadCSV();
            }
        });

        function uploadCSV(){
            $.ajax({
                url: '{{ url()->current() }}/upload-csv',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    user: $('#i_username').val().toUpperCase(),
                    pass: $('#i_password').val().toUpperCase()
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
                        window.location.reload();
                    });
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: 'Terjadi kesalahan!',
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {
                        $('#i_password').val('').focus();
                    });
                }
            });
        }

        function printTag(){
            window.open(`{{ url()->current() }}/print-tag`);
        }

        function printAll(){
            window.open(`{{ url()->current() }}/print-all`);
        }
    </script>

@endsection
