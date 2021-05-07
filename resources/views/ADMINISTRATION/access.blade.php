@extends('navbar')

@section('title','ADMINISTRATION | ACCESS')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">Access Menu</legend>
                            <div class="card-body pt-0 pb-0">
                                <div class="row form-group">
                                    <table class="table table-sm mb-0 text-center" id="table_data">
                                        <thead class="thColor">
                                        <tr>
                                            <th>GROUP</th>
                                            <th>SUBGROUP 1</th>
                                            <th>SUBGROUP 2</th>
                                            <th>SUBGROUP 3</th>
                                            <th>NAME</th>
                                            <th>LEVEL</th>
                                            <th>URL</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody id="">
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
{{--                                <div class="row form-group mb-0 ml-1 mr-3">--}}
{{--                                    <label for="prdcd" class="col-sm-2 text-center pl-0 pr-0 col-form-label">GROUP</label>--}}
{{--                                    <label for="prdcd" class="col-sm-5 text-center pl-0 pr-0 col-form-label">NAME</label>--}}
{{--                                    <label for="prdcd" class="col-sm-1 text-center pl-0 pr-0 col-form-label">LEVEL</label>--}}
{{--                                    <label for="prdcd" class="col-sm-3 text-center pl-0 pr-0 col-form-label">URL</label>--}}
{{--                                    <label for="prdcd" class="col-sm-1 text-center col-form-label pr-1 pl-0"></label>--}}
{{--                                </div>--}}
{{--                                <div class="scrollable-field mb-2" id="detail">--}}
{{--                                    @for($i=0;$i<14;$i++)--}}
{{--                                        <div class="row form-group m-1 mb-2">--}}
{{--                                            <div class="col-sm-2 pr-1 pl-1">--}}
{{--                                                <input type="text" class="form-control text-center" disabled>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-5 pr-1 pl-1">--}}
{{--                                                <input type="text" class="form-control text-center" disabled>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-1 pr-1 pl-1">--}}
{{--                                                <input type="text" class="form-control text-center" disabled>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-3 pr-1 pl-1">--}}
{{--                                                <input type="text" class="form-control text-center" disabled>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-1 pr-1 pl-1 text-center">--}}
{{--                                                <button class="btn btn-primary">--}}
{{--                                                    <i class="fas fa-pen"></i>--}}
{{--                                                </button>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endfor--}}
{{--                                </div>--}}
                                <div class="row form-group">
                                    <div class="col-sm"></div>
                                    <button class="col-sm-2 btn btn-primary mr-3" id="" onclick="showModalAdd()">TAMBAH</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal" id="m_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Data</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">GROUP</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="add_group" maxlength="50">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">SUBGROUP 1</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="add_subgroup1" maxlength="50">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">SUBGROUP 2</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="add_subgroup2" maxlength="50">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">SUBGROUP 3</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="add_subgroup3" maxlength="50">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">NAME</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="add_name" maxlength="75">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">LEVEL</label>
                            <div class="col-sm-7">
                                <select id="add_level" class="form-control">
                                    <option value="" disabled selected>Pilih Level</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">URL</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="add_url" maxlength="255">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="col-sm-2 btn btn-success" onclick="add()">TAMBAH</button>
                            <div class="col-sm"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="m_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Data</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">GROUP</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="edit_group" maxlength="50">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">SUBGROUP 1</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="edit_subgroup1" maxlength="50">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">SUBGROUP 2</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="edit_subgroup2" maxlength="50">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">SUBGROUP 3</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="edit_subgroup3" maxlength="50">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">NAME</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="edit_name" maxlength="75">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">LEVEL</label>
                            <div class="col-sm-7">
                                <select id="edit_level" class="form-control">
                                    <option value="" disabled selected>Pilih Level</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">URL</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="edit_url" maxlength="255">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="col-sm-2 btn btn-success mr-1" onclick="edit()">SIMPAN</button>
                            <button class="col-sm-2 btn btn-danger ml-1" onclick="del()">HAPUS</button>
                            <div class="col-sm"></div>
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
    </style>

    <script>
        var tableData;
        var dataAccess = [];
        var dataRow;

        $(document).ready(function(){
            getData();
        });

        function getData(){
            tableData = $('#table_data').DataTable({
                "ajax": '{{ url()->current().'/get-data' }}',
                "columns": [
                    {data: 'acc_group'},
                    {data: 'acc_subgroup1'},
                    {data: 'acc_subgroup2'},
                    {data: 'acc_subgroup3'},
                    {data: 'acc_name'},
                    {data: 'acc_level'},
                    {data: 'acc_url'},
                    {data: null, render: function(data, type, full, meta){
                            return `<button class="btn btn-sm btn-primary" onclick="showModalEdit('${meta.row}')">
                                <i class="fas fa-pen">
                            </button>`;
                        }
                    },
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left align-middle');
                    $(row).find(':eq(1)').addClass('text-left align-middle');
                    $(row).find(':eq(2)').addClass('text-center align-middle');
                    $(row).find(':eq(3)').addClass('text-left align-middle');
                    $(row).addClass('row-data').css({'cursor': 'pointer'});

                    dataAccess.push(data);
                },
                "order": [],
                "initComplete": function () {

                }
            });

            $('#table_data_wrapper').css('width','100%');
        }

        function showModalAdd(){
            $('#m_add .form-control').val('');

            $('#m_add').modal('show');
        }

        function add(){
            $.ajax({
                url: '{{ url()->current() }}/add',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    group: $('#add_group').val(),
                    subgroup1: $('#add_subgroup1').val(),
                    subgroup2: $('#add_subgroup2').val(),
                    subgroup3: $('#add_subgroup3').val(),
                    name: $('#add_name').val(),
                    level: $('#add_level').val(),
                    url: $('#add_url').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.title,
                        icon: 'success'
                    }).then(function(){
                        dataAccess = [];
                        tableData.ajax.reload();

                        $('#m_add').modal('hide');
                    });
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        function showModalEdit(row){
            dataRow = row;
            data = dataAccess[row];

            $('#edit_group').val(data.acc_group.replace('&amp;','&'));
            $('#edit_subgroup1').val(data.acc_subgroup1 == null ? '' : data.acc_subgroup1.replace('&amp;','&'));
            $('#edit_subgroup2').val(data.acc_subgroup2 == null ? '' : data.acc_subgroup2.replace('&amp;','&'));
            $('#edit_subgroup3').val(data.acc_subgroup3 == null ? '' : data.acc_subgroup3.replace('&amp;','&'));
            $('#edit_name').val(data.acc_name.replace('&amp;','&'));
            $('#edit_level').val(data.acc_level);
            $('#edit_url').val(data.acc_url);

            $('#m_edit').modal('show');
        }

        function edit(){
            $.ajax({
                url: '{{ url()->current() }}/edit',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    group: $('#edit_group').val(),
                    subgroup1: $('#edit_subgroup1').val(),
                    subgroup2: $('#edit_subgroup2').val(),
                    subgroup3: $('#edit_subgroup3').val(),
                    name: $('#edit_name').val(),
                    level: $('#edit_level').val(),
                    url: $('#edit_url').val(),
                    oldgroup: dataAccess[dataRow].acc_group.replace('&amp;','&'),
                    oldsubgroup1: dataAccess[dataRow].acc_subgroup1 == null ? '' : dataAccess[dataRow].acc_subgroup1.replace('&amp;','&'),
                    oldsubgroup2: dataAccess[dataRow].acc_subgroup2 == null ? '' : dataAccess[dataRow].acc_subgroup2.replace('&amp;','&'),
                    oldsubgroup3: dataAccess[dataRow].acc_subgroup3 == null ? '' : dataAccess[dataRow].acc_subgroup3.replace('&amp;','&'),
                    oldname: dataAccess[dataRow].acc_name.replace('&amp;','&')
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.title,
                        icon: 'success'
                    }).then(function(){
                        dataAccess = [];
                        tableData.ajax.reload();

                        $('#m_edit').modal('hide');
                    });
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        function del(){
            swal({
                title: 'Yakin ingin menghapus data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    $.ajax({
                        url: '{{ url()->current() }}/delete',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            group: dataAccess[dataRow].acc_group.replace('&amp;','&'),
                            subgroup1: dataAccess[dataRow].acc_subgroup1 == null ? '' : dataAccess[dataRow].acc_subgroup1.replace('&amp;','&'),
                            subgroup2: dataAccess[dataRow].acc_subgroup2 == null ? '' : dataAccess[dataRow].acc_subgroup2.replace('&amp;','&'),
                            subgroup3: dataAccess[dataRow].acc_subgroup3 == null ? '' : dataAccess[dataRow].acc_subgroup3.replace('&amp;','&'),
                            name: dataAccess[dataRow].acc_name.replace('&amp;','&')
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.title,
                                icon: 'success'
                            }).then(function(){
                                dataAccess = [];
                                tableData.ajax.reload();

                                $('#m_edit').modal('hide');
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {

                            });
                        }
                    });
                }
            })
        }

        function deleteByPLU(){
            if(!$('#plu').val()){
                swal({
                    title: 'Pilih PLU terlebih dahulu!',
                    icon: 'error'
                });
            }
            else{
                deletePLU($('#plu').val());
            }
        }

        function deletePLU(plu){
            $.ajax({
                url: '{{ url()->current() }}/delete-plu',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    plu: plu
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.title,
                        icon: 'success'
                    }).then(getData());
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        function addBatch(){
            $.ajax({
                url: '{{ url()->current() }}/add-batch',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    div: $('#div_kode').val(),
                    dep: $('#dep_kode').val(),
                    kat: $('#kat_kode').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.title,
                        icon: 'success'
                    }).then(getData());
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        function deleteBatch(){
            $.ajax({
                url: '{{ url()->current() }}/delete-batch',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    div: $('#div_kode').val(),
                    dep: $('#dep_kode').val(),
                    kat: $('#kat_kode').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: response.title,
                        icon: 'success'
                    }).then(getData());
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        function print(){
            swal({
                title: 'Cetak data PLU yang tidak ikut promo?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    window.open(`{{ url()->current() }}/print`,'_blank');
                }
            });
        }
    </script>
@endsection
