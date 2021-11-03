@extends('navbar')

@section('title','TABEL | Monitoring Produk')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">Tabel Monitoring Produk</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode Monitoring</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left text-uppercase" id="mon_kode">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_monitoring">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-left" id="mon_nama" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">Jumlah Item</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="mon_qty" disabled>
                                    </div>
                                    <div class="col-sm"></div>
                                    <div class="col-sm-2">
                                        <button class="col-sm btn btn-primary" id="btn_print">PRINT</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table table bordered table-sm mt-3" id="table_data">
                                    <thead class="theadDataTables">
                                    <tr class="text-center align-middle">
                                        <th class="align-middle" width="10%"></th>
                                        <th class="align-middle" width="15%">PLU</th>
                                        <th class="align-middle" width="60%">Deskripsi</th>
                                        <th class="align-middle" width="15%">Satuan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">PLU Monitoring</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">PLU</label>
{{--                                    <div class="col-sm-2">--}}
{{--                                        <input type="text" class="form-control text-left" id="plu">--}}
{{--                                    </div>--}}
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="plu" disabled>
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_plu">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-left" id="deskripsi" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Satuan</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-left" id="satuan" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="col-sm btn btn-danger" id="btn-delete" onclick="deleteData()" disabled>DELETE</button>
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="col-sm btn btn-success" id="btn-add" onclick="add()" disabled>TAMBAH</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_monitoring" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Monitoring</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_monitoring">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Monitoring</th>
                                        <th>Nama Monitoring</th>
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

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
            /*overflow-y: hidden;*/
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
        var dataPLUMonitoring = [];

        $(document).ready(function(){
            getLovMonitoring();

            $('#table_data').DataTable({
                "scrollY" : '30vh',
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            getModalData('');

            $('#mon_kode').focus();
        });

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
                        $('#plu').val($(this).find('td:eq(1)').html());
                        $('#deskripsi').val($(this).find('td:eq(0)').html());
                        $('#satuan').val($(this).find('td:eq(2)').html());

                        found = false;
                        for(i=0;i<dataPLUMonitoring.length;i++){
                            if(dataPLUMonitoring[i].plu == $('#plu').val()){
                                found = true;
                                break;
                            }
                        }

                        if(found){
                            $('#btn-delete').prop('disabled',false);
                            $('#btn-add').prop('disabled',true);
                        }
                        else{
                            $('#btn-delete').prop('disabled',true);
                            $('#btn-add').prop('disabled',false);
                        }

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

        function getLovMonitoring(){
            if ($.fn.DataTable.isDataTable('#table_lov_monitoring')) {
                $('#table_lov_monitoring').DataTable().destroy();
                $("#table_lov_monitoring tbody [role='row']").remove();
            }

            $('#table_lov_monitoring').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-lov-monitoring',
                    "data" : {

                    },
                },
                "columns": [
                    {data: 'kode', name: 'kode'},
                    {data: 'nama', name: 'nama'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-monitoring');
                },
                "initComplete" : function(){
                    $(".row-monitoring").prop("onclick", null).off("click");

                    $(document).on('click', '.row-monitoring', function (e) {
                        $('#mon_kode').val($(this).find('td:eq(0)').html());
                        $('#mon_nama').val($(this).find('td:eq(1)').html());

                        getData();

                        $('#m_lov_monitoring').modal('hide');
                    });
                }
            });
        }

        $('#mon_kode').on('keypress',function(e){
            if(e.which == 13){
                getMonitoring('get');
            }
        });

        function getMonitoring(type){
            if($('#mon_kode').val() == ''){
                swal({
                    title: 'Kode monitoring tidak boleh kosong!',
                    icon: 'error'
                }).then(() => {
                    $('#mon_kode').select();
                });
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/get-monitoring',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        kode: $('#mon_kode').val().toUpperCase()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                        $('#mon_nama').val('');
                        $('#mon_qty').val('');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        $('#mon_nama').val(response.nama);

                        if(type == 'get')
                            getData();
                        else print();
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');

                        swal({
                            title: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {
                            $('#mon_nama').val('');
                            $('#mon_kode').select();
                        });
                    }
                });
            }
        }

        function getData(){
            if($('#mon_kode').val() == ''){
                swal({
                    title: 'Kode monitoring tidak boleh kosong!',
                    icon: 'error'
                }).then(() => {
                    $('#mon_kode').select();
                });
            }
            else{
                if($.fn.DataTable.isDataTable('#table_data')){
                    $('#table_data').DataTable().destroy();
                }

                dataPLUMonitoring = [];

                $('#table_data').DataTable({
                    "ajax": {
                        'url' : '{{ url()->current().'/get-data' }}',
                        'data' : {
                            'kode' : $('#mon_kode').val().toUpperCase()
                        }
                    },
                    "columns": [
                        {data: null, render: function(data, type, full, meta){
                                return `<td width="10%" class="align-middle"><button class="btn btn-danger btn-delete" onclick=""><i class="fas fa-times"></i></button></td>`;
                            }
                        },
                        {data: 'plu'},
                        {data: 'deskripsi'},
                        {data: 'satuan'},
                    ],
                    "scrollY" : '30vh',
                    "paging": false,
                    "lengthChange": false,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).find('td:eq(0)').addClass('text-center align-middle');
                        $(row).find('td:eq(1)').addClass('text-center align-middle prdcd');
                        $(row).find('td:eq(2)').addClass('text-left align-middle');
                        $(row).find('td:eq(3)').addClass('text-center align-middle');
                        $(row).find('td:eq(4)').addClass('text-right align-middle');
                        $(row).find('td:eq(5)').addClass('text-right align-middle');

                        dataPLUMonitoring.push(data);
                    },
                    "order": [],
                    "initComplete": function () {
                        // lastData = dataPLUMonitoring[dataPLUMonitoring.length - 1];
                        //
                        // $('#plu').val(lastData.plu);
                        // $('#deskripsi').val(lastData.deskripsi);
                        // $('#satuan').val(lastData.satuan);

                        // $('#table_data tbody tr:eq(-1) button').focus().blur();

                        $('#mon_qty').val(dataPLUMonitoring.length);

                        $('#plu').select();
                    }
                });
            }
        }

        function deleteData(plu){
            {{--if(plu == '' && $('#plu').val() == ''){--}}
            {{--    swal({--}}
            {{--        title: 'Inputan PLU tidak boleh kosong!',--}}
            {{--        icon: 'error'--}}
            {{--    }).then(() => {--}}
            {{--        $('#plu').select();--}}
            {{--    });--}}
            {{--}--}}
            {{--else{--}}
            {{--    if(plu == ''){--}}
            {{--        plu = $('#plu').val();--}}
            {{--    }--}}

            {{--    swal({--}}
            {{--        title: 'Yakin ingin menghapus PLU '+plu+'?',--}}
            {{--        icon: 'warning',--}}
            {{--        buttons: true,--}}
            {{--        dangerMode: true--}}
            {{--    }).then((ok) => {--}}
            {{--        if(ok){--}}
            {{--            $.ajax({--}}
            {{--                url: '{{ url()->current() }}/delete-data',--}}
            {{--                type: 'POST',--}}
            {{--                headers: {--}}
            {{--                    'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
            {{--                },--}}
            {{--                data: {--}}
            {{--                    plu: plu--}}
            {{--                },--}}
            {{--                beforeSend: function () {--}}
            {{--                    $('#modal-loader').modal('show');--}}
            {{--                },--}}
            {{--                success: function (response) {--}}
            {{--                    $('#modal-loader').modal('hide');--}}

            {{--                    swal({--}}
            {{--                        title: response.message,--}}
            {{--                        icon: 'success'--}}
            {{--                    }).then(() => {--}}
            {{--                        $('#top_field input').val('');--}}
            {{--                        getData();--}}
            {{--                        $('#plu').select();--}}
            {{--                    });--}}
            {{--                },--}}
            {{--                error: function (error) {--}}
            {{--                    $('#modal-loader').modal('hide');--}}

            {{--                    swal({--}}
            {{--                        title: error.responseJSON.message,--}}
            {{--                        icon: 'error',--}}
            {{--                    }).then(() => {--}}

            {{--                    });--}}
            {{--                }--}}
            {{--            });--}}
            {{--        }--}}
            {{--    });--}}
            {{--}--}}
        }

        $('#btn_print').on('click',function(){
            getMonitoring('print');
        });

        function print(){
            swal({
                title: 'Cetak by PLU / Deskripsi?',
                icon: 'warning',
                buttons: {
                    plu: 'PLU',
                    desk: 'Deskripsi'
                }
            }).then((val) => {
                if(val){
                    window.open(`{{ url()->current() }}/print?mon=${$('#mon_kode').val().toUpperCase()}&orderBy=${val}`,'_blank');
                }
            });
        }

        function add(){

        }
    </script>
@endsection
