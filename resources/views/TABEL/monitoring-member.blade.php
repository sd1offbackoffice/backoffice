@extends('navbar')

@section('title','TABEL | Monitoring Member')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">Tabel Monitoring Member</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode Monitoring</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left text-uppercase" id="mon_kode">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_monitoring">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Nama Monitoring</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-left" id="mon_nama" disabled>
                                    </div>
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
                                        <th class="align-middle" width="10%">Member</th>
                                        <th class="align-middle" width="30%"></th>
                                        <th class="align-middle" width="15%">Outlet</th>
                                        <th class="align-middle" width="20%"></th>
                                        <th class="align-middle" width="15%">PKP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0" id="plu_field">
                            <legend  class="w-auto ml-3">Input Kode Member</legend>
                            <div class="card-body py-0" id="top_field">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode Member</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control text-left" id="memberKode">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#modalLOVMember">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Nama Member</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-left" id="memberNama" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Outlet</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-left" id="outletKode" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" id="outletNama" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">PKP</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-left" id="pkp" disabled>
                                    </div>
                                    <div class="col-sm"></div>
                                    <div class="col-sm-3">
                                        <button class="col-sm btn btn-danger" id="btn-delete" onclick="deleteData($('#memberKode').val())" disabled>DELETE</button>
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

    <div class="modal fade" id="modalLOVMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Member</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="tableLOVMember">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Member</th>
                                        <th>Nama Member</th>
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
        var dataMemberMonitoring = [];

        $(document).ready(function(){
            getLovMonitoring();

            makeDataTable();

            getModalData('');

            $('#mon_kode').focus();
        });

        function makeDataTable(){
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
        }

        $('#modalLOVMember').on('shown.bs.modal',function(){
            $('#tableLOVMember_filter input').val('');
            $('#tableLOVMember_filter input').select();
        });

        function getModalData(value){
            if ($.fn.DataTable.isDataTable('#tableLOVMember')) {
                $('#tableLOVMember').DataTable().destroy();
                $("#tableLOVMember tbody [role='row']").remove();
            }

            if(!$.isNumeric(value)){
                search = value.toUpperCase();
            }
            else search = value;

            $('#tableLOVMember').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-lov-member',
                    "data" : {
                        'plu' : search
                    },
                },
                "columns": [
                    {data: 'cus_kodemember', name: 'cus_kodemember'},
                    {data: 'cus_namamember', name: 'cus_namamember'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-member');
                },
                "initComplete" : function(){
                    $('#tableLOVMember_filter input').val(value).select();

                    $(".row-member").prop("onclick", null).off("click");

                    $(document).on('click', '.row-member', function (e) {
                        getMember($(this).find('td:eq(0)').html());

                        // found = false;
                        // for(i=0;i<dataMemberMonitoring.length;i++){
                        //     if(dataMemberMonitoring[i].plu == $('#plu').val()){
                        //         found = true;
                        //         break;
                        //     }
                        // }
                        //
                        // if(found){
                        //     $('#btn-delete').prop('disabled',false);
                        //     $('#btn-add').prop('disabled',true);
                        // }
                        // else{
                        //     $('#btn-delete').prop('disabled',true);
                        //     $('#btn-add').prop('disabled',false);
                        // }

                        $('#m_lov_plu').modal('hide');
                    });
                }
            });

            $('#tableLOVMember_filter input').val(value);

            $('#tableLOVMember_filter input').off().on('keypress', function (e){
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getModalData(val);
                }
            });
        }

        $('#memberKode').on('keypress',function(e){
            if(e.which == 13){
                getMember($(this).val());
            }
        });

        function getMember(kodemember){
            if(kodemember == ''){
                swal({
                    title: 'Kode member tidak boleh kosong!',
                    icon: 'error'
                }).then(() => {
                    $('#memberKode').select();
                })
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/get-member',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        kodemonitoring: $('#mon_kode').val(),
                        kodemember: kodemember
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');

                        $('#memberKode').val('');
                        $('#memberNama').val('');
                        $('#outletKode').val('');
                        $('#outletNama').val('');
                        $('#pkp').val('');

                        $('#btn-delete').prop('disabled',true);
                        $('#btn-add').prop('disabled',true);
                    },
                    success: function (response) {
                        $('#modalLOVMember').modal('hide');
                        $('#modal-loader').modal('hide');

                        found = false;
                        for(i=0;i<dataMemberMonitoring.length;i++){
                            if(dataMemberMonitoring[i].mem_kodemember === kodemember){
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

                        $('#memberKode').val(kodemember);
                        $('#memberNama').val(response.cus_namamember);
                        $('#outletKode').val(response.cus_kodeoutlet);
                        $('#outletNama').val(response.out_namaoutlet);
                        $('#pkp').val(response.cus_flagpkp);


                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');

                        swal({
                            title: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {
                            $('#memberKode').select();
                        });
                    }
                });
            }
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
                getMonitoring();
            }
        });

        function getMonitoring(){
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
                    },
                    success: function (response) {
                        $('#mon_nama').val(response.nama);

                        getData();
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

                $('#plu_field input').val('');
                $('#btn-delete').prop('disabled',true);
                $('#btn-add').prop('disabled',true);

                dataMemberMonitoring = [];

                $('#table_data').DataTable({
                    "ajax": {
                        'url' : '{{ url()->current().'/get-data' }}',
                        'data' : {
                            'kode' : $('#mon_kode').val().toUpperCase()
                        },
                        error: function(error){
                            $('#table_data').DataTable().destroy();
                            makeDataTable();

                            swal({
                                title: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {
                                $('#mon_kode').select();
                            });
                        }
                    },
                    "columns": [
                        {data: null, render: function(data, type, full, meta){
                                return `<td width="10%" class="align-middle">
                                            <button class="btn btn-danger btn-delete" onclick="deleteData('${data.mem_kodemember}')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>`;
                            }
                        },
                        {data: 'mem_kodemember'},
                        {data: 'cus_namamember'},
                        {data: 'cus_kodeoutlet'},
                        {data: 'out_namaoutlet'},
                        {data: 'cus_flagpkp'}
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
                        $(row).find('td:eq(1)').addClass('text-center align-middle member');
                        $(row).find('td:eq(2)').addClass('text-left align-middle');
                        $(row).find('td:eq(3)').addClass('text-center align-middle');
                        $(row).find('td:eq(4)').addClass('text-left align-middle');
                        $(row).find('td:eq(5)').addClass('text-center align-middle');

                        dataMemberMonitoring.push(data);
                    },
                    "order": [],
                    "initComplete": function () {
                        // lastData = dataMemberMonitoring[dataMemberMonitoring.length - 1];
                        //
                        // $('#plu').val(lastData.plu);
                        // $('#deskripsi').val(lastData.deskripsi);
                        // $('#satuan').val(lastData.satuan);

                        // $('#table_data tbody tr:eq(-1) button').focus().blur();

                        $('#modal-loader').modal('hide');

                        $('#memberKode').select();
                    }
                });
            }
        }

        $('#btn_print').on('click',function(){
            window.open(`{{ url()->current() }}/print?mon=${$('#mon_kode').val().toUpperCase()}`,'_blank');
            // getMonitoring('print');
        });

        function print(){
            window.open(`{{ url()->current() }}/print?mon=${$('#mon_kode').val().toUpperCase()}`,'_blank');
            {{--swal({--}}
            {{--    title: 'Cetak by PLU / Deskripsi?',--}}
            {{--    icon: 'warning',--}}
            {{--    buttons: {--}}
            {{--        plu: 'PLU',--}}
            {{--        desk: 'Deskripsi'--}}
            {{--    }--}}
            {{--}).then((val) => {--}}
            {{--    if(val){--}}
            {{--        window.open(`{{ url()->current() }}/print?mon=${$('#mon_kode').val().toUpperCase()}&orderBy=${val}`,'_blank');--}}
            {{--    }--}}
            {{--});--}}
        }

        function add(){
            swal({
                title: 'Yakin ingin menambahkan kode member '+$('#memberKode').val()+' ?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((value) => {
                if(value){
                    $.ajax({
                        url: '{{ url()->current() }}/add-data',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            kodemonitoring: $('#mon_kode').val().toUpperCase(),
                            namamonitoring: $('#mon_nama').val(),
                            kodemember: $('#memberKode').val()
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            swal({
                                title: response.message,
                                icon: 'success'
                            }).then(() => {
                                $('#modal-loader').modal('hide');
                                getData();
                            });
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
            });
        }

        function deleteData(member){
            if(member == '' && $('#member').val() == ''){
                swal({
                    title: 'Kode member tidak boleh kosong!',
                    icon: 'error'
                }).then(() => {
                    $('#member').select();
                });
            }
            else{
                swal({
                    title: 'Yakin ingin menghapus kode member '+member+'?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/delete-data',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                kodemonitoring: $('#mon_kode').val().toUpperCase(),
                                namamonitoring: $('#mon_nama').val(),
                                kodemember: member
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                    getData();
                                });
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
                });
            }
        }
    </script>
@endsection
