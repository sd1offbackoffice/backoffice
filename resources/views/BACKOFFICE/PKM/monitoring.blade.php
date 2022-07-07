@extends('navbar')

@section('title','PKM | ENTRY & INQUERY MONITORING PLU BARU')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-3">@lang('ENTRY & INQUERY MONITORING PLU BARU')</legend>
                            <div class="card-body">
                                <div class="row form-group mb-0">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label">{{ strtoupper(__('Kode PLU')) }}</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="prdcd1" disabled>
                                        <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" onclick="showLOVPrdcdNew('prdcd1')">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <label for="prdcd" class="col-sm-1 text-right col-form-label">@lang('s/d')</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="prdcd2" disabled>
                                        <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" onclick="showLOVPrdcdNew('prdcd2')">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
                                        <button class="col btn btn-primary" onclick="getData()">{{ strtoupper(__('Pilih')) }}</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-3">@lang('MASTER BARANG BARU')</legend>
                            <div class="card-body pt-0">
                                <div class="row form-group">
                                    <table class="table table-sm mb-0 text-center" id="table_data">
                                        <thead class="text-center thColor">
                                        <tr>
                                            <th width="6%"></th>
                                            <th>@lang('PLU')</th>
                                            <th>@lang('Tanggal Daftar')</th>
                                            <th>@lang('Tanggal BPB')</th>
                                            <th>@lang('PKMT')</th>
                                            <th>@lang('TAG')</th>
                                            <th>@lang('MINOR')</th>
                                            <th>@lang('FLAG')</th>
                                            <th>@lang('OMI')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="">
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                                <div class="row">
                                    <label for="desk" class="pl-0 pr-0 text-right col-form-label">@lang('Deskripsi')</label>
                                    <div class="col-sm">
                                        <input maxlength="10" type="text" class="form-control" id="desk" disabled>
                                    </div>
                                    <div class="col-sm-2 pl-0 pr-0">
                                        <input maxlength="10" type="text" class="form-control text-center" id="unit" disabled>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col"></div>
                                    <button id="btn_tambah" class="col-sm-2 mr-3 btn btn-success" data-toggle="modal" data-target="#m_add" disabled>{{ strtoupper(__('Tambah')) }}</button>
                                    <button id="btn_cetak" class="col-sm-2 btn btn-primary" onclick="print()" disabled>{{ strtoupper(__('Cetak')) }}</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Tambah Data')</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">{{ strtoupper(__('Kode PLU')) }}</label>
                            <div class="col-sm-4 buttonInside">
                                <input type="text" class="form-control" id="add_prdcd" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" onclick="showLOVPrdcd()">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">{{ strtoupper(__('Deskripsi')) }}</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="add_deskripsi" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">{{ strtoupper(__('Satuan')) }}</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="add_satuan" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">{{ strtoupper(__('Tanggal Daftar')) }}</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="add_tgldaftar" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">{{ strtoupper(__('Tanggal BPB')) }}</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="add_tglbpb" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">@lang('PKMT')</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="add_pkmt" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">@lang('TAG')</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="add_tag" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">@lang('MINOR')</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="add_minor" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">@lang('FLAG')</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="add_flag" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label">@lang('OMI')</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="add_omi" disabled>
                            </div>
                            <div class="col"></div>
                            <div class="col-sm-2">
                                <button class="col btn btn-success" onclick="addData()">{{ strtoupper(__('Tambah')) }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_prdcd_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_prdcd_new">
                                    <thead class="thColor">
                                    <tr>
                                        <th>@lang('Deskripsi')</th>
                                        <th>@lang('PLU')</th>
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
                                        <th>@lang('PLU')</th>
                                        <th>@lang('Deskripsi')</th>
                                        <th>@lang('Satuan')</th>
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
        let currField;
        let dataPRDCDNew = [];
        let dataMonitoring = [];
        // let needRefresh = false;
        // let needRefreshNew = false;
        let lovPrdcd, lovPrdcdNew, tableData;

        $(document).ready(function(){
            $('#table_data').DataTable({
                // "scrollY": "40vh",
                // "paging": false,
                // "lengthChange": true,
                // "searching": true,
                // "ordering": true,
                // "info": true,
                // "autoWidth": false,
                // "responsive": true,
            });
            $('#table_data_wrapper').css('width','100%');

            // getData();
            // $('#m_add').modal('show');
        });

        $('#m_add').on('shown.bs.modal',function(){
            $('#m_add input').val('');
        });

        function showLOVPrdcd(){
            // if(needRefreshNew){
            //     $('#table_prdcd').DataTable().destroy();
            //     $("#table_prdcd tbody [role='row']").remove();
            //     needRefresh = false;
            // }

            if(!$.fn.DataTable.isDataTable('#table_prdcd')){
                getPRDCD();
            }

            $('#m_prdcd').modal('show');
        }

        function showLOVPrdcdNew(field){
            currField = field;

            // if(needRefreshNew){
            //     $('#table_prdcd_new').DataTable().destroy();
            //     $("#table_prdcd_new tbody [role='row']").remove();
            //     needRefreshNew = false;
            // }

            if(!$.fn.DataTable.isDataTable('#table_prdcd_new')){
                getPRDCDNew();
            }

            $('#m_prdcd_new').modal('show');
        }

        function getPRDCD(){
            lovPrdcd = $('#table_prdcd').DataTable({
                "ajax": '{{ url()->current().'/get-lov-prdcd' }}',
                "columns": [
                    {data: 'plu', name: 'plu'},
                    {data: 'deskripsi', name: 'deskripsi'},
                    {data: 'satuan'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).addClass('row-prdcd').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    // $('#btn_prdcd').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-prdcd', function (e) {
                        $('#add_prdcd').val($(this).find('td:eq(0)').html());
                        $('#add_deskripsi').val($(this).find('td:eq(1)').html());
                        $('#add_satuan').val($(this).find('td:eq(2)').html());

                        getDataAdded($(this).find('td:eq(0)').html());

                        $('#m_prdcd').modal('hide');
                    });
                }
            });
        }

        function getPRDCDNew(){
            lovPrdcdNew = $('#table_prdcd_new').DataTable({
                "ajax": '{{ url()->current().'/get-lov-prdcd-new' }}',
                "columns": [
                    {data: 'deskripsi', name: 'deskripsi'},
                    {data: 'plu', name: 'plu'},
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
                    $(row).addClass('row-prdcd-new').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    // $('#btn_prdcd').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-prdcd-new', function (e) {
                        prdcd = $(this).find('td:eq(1)').html();

                        $('#m_prdcd_new').modal('hide');

                        $('#'+currField).val(prdcd);

                        cekPrdcd(currField);
                    });
                }
            });
        }

        function cekPrdcd(field){
            if($('#prdcd1').val() && $('#prdcd2').val() && $('#prdcd1').val() > $('#prdcd2').val()){
                $('#' + field).val('');
                swal({
                    title: field === 'prdcd1' ? `{{ __('PLU pertama lebih besar dari PLU kedua') }}!` : `{{ __('PLU kedua lebih kecil dari PLU pertama') }}!`,
                    icon: 'warning'
                }).then(() => {
                    showLOVPrdcdNew(field);
                });
            }
        }

        function getData(){
            if(!($('#prdcd1').val() && $('#prdcd2').val())){
                swal({
                    title: `{{ __('Inputan PLU belum lengkap') }}!`,
                    icon: 'warning'
                });
            }
            else{
                if($.fn.DataTable.isDataTable('#table_data')){
                    $('#table_data').DataTable().destroy();
                    $("#table_data tbody [role='row']").remove();
                }

                dataPRDCDNew = [];
                dataMonitoring = [];

                $('#table_data').DataTable({
                    "ajax": {
                        url: '{{ url()->current() }}/get-data',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            prdcd1: $('#prdcd1').val(),
                            prdcd2: $('#prdcd2').val(),
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        // success: function (response) {
                        //     $('#modal-loader').modal('hide');
                        //
                        //     if(response.status === 'error'){
                        //         swal({
                        //             title: response.title,
                        //             icon: 'error',
                        //         });
                        //     }
                        // },
                        // error: function (error) {
                        //     $('#modal-loader').modal('hide');
                        //
                        //     swal({
                        //         title: 'Terjadi kesalahan!',
                        //         text: error.responseJSON.message,
                        //         icon: 'error',
                        //     });
                        // }
                    },
                    "columns": [
                        {data: null, render: function (data,type,full,meta) {
                                return  '<button class="btn btn-danger" onclick="deleteData('+meta.row+')">' +
                                    '<i class="fas fa-trash"></i>' +
                                    '</button>';
                            }
                        },
                        {data: 'fmkplu'},
                        {data: 'fmtgld'},
                        {data: 'tglbpb'},
                        {data: 'pkm_pkmt', render: function(data, type, full, meta){
                                if(data == null)
                                    data = 0;
                                return '<input class="text-right row-pkm" onkeypress="changePKM(event, '+meta.row+')" style="width: 5vw" value="' + data + '">';
                            }
                        },
                        {data: 'prd_kodetag'},
                        {data: 'minor'},
                        {data: 'flag'},
                        {data: 'fomi'},
                    ],
                    "scrollY": "40vh",
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).find(':eq(0)').addClass('text-left');
                        $(row).addClass('row-detail').css({'cursor': 'pointer'});

                        dataPRDCDNew.push(data.fmkplu);
                        dataMonitoring.push(data);
                    },
                    "order" : [],
                    "columnDefs": [
                        {
                            "targets": 0,
                            "orderable": false
                        }
                    ],
                    "initComplete": function(){
                        $('#modal-loader').modal('hide');

                        // $(document).on('click', '.row-detail', function (e) {
                        //     $('.clicked').removeClass('clicked');
                        //     $(this).addClass('clicked');
                        //     showDesc($(this).find('td:eq(1)').html());
                        // });

                        $(document).on('mouseover', '.row-detail', function (e) {
                            $('.clicked').removeClass('clicked');
                            $(this).addClass('clicked');
                            showDesc($(this).find('td:eq(1)').html());
                        });
                    }
                });

                $('#btn_tambah').prop('disabled',false);
                $('#btn_cetak').prop('disabled',false);
                $('#table_data_wrapper').css('width','100%');
            }
        }

        function showDesc(prdcd){
            i = $.inArray(prdcd,dataPRDCDNew);

            $('#desk').val(decodeHtml(dataMonitoring[i].prd_deskripsipanjang));
            $('#unit').val(dataMonitoring[i].prd_satuan);
        }

        function deleteData(i){
            swal({
                title: `{{ __('Yakin ingin menghapus data PLU') }} ` + dataPRDCDNew[i] + '?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    $.ajax({
                        url: '{{ url()->current() }}/delete-data',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            plu: dataPRDCDNew[i]
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.title,
                                icon: response.status
                            }).then(() => {
                                if(response.status === 'success'){
                                    $('#table_data tbody tr').each(function(){
                                        if($(this).find('td:eq(1)').html() == dataPRDCDNew[i]){
                                            $(this).remove();
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        }

        function changePKM(event, i){
            if(event.which == 13){
                swal({
                    title: `{{ __('Yakin ingin mengubah nilai PKMT') }}?`,
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/change-pkm',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                plu: dataPRDCDNew[i],
                                pkmt: $(event.target).val()
                            },
                            beforeSend: function(){
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.title,
                                    icon: response.status
                                });
                            },
                            error: function () {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: 'Terjadi kesahalahn!',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            }
        }

        function addData(){
            swal({
                title: 'Yakin ingin menambah data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    $.ajax({
                        url: '{{ url()->current() }}/add-data',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            plu: $('#add_prdcd').val(),
                            pkmt: $('#add_pkmt').val(),
                            tag: $('#add_tag').val(),
                            tglbpb: $('#add_tglbpb').val(),
                            tgldaftar: $('#add_tgldaftar').val(),
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.title,
                                icon: response.status
                            });

                            if(response.status === 'success'){
                                // $('#table_data tbody').append(
                                //     `<tr>` +
                                //     '<td><button class="btn btn-danger" onclick="deleteData('+$('#add_prdcd').val()+')">' +
                                //     '<i class="fas fa-trash"></i>' +
                                //     '</button></td>' +
                                //     `<td>${$('#add_prdcd').val()}</td>` +
                                //     `<td>${$('#add_tgldaftar').val()}</td>` +
                                //     `<td>${$('#add_tglbpb').val()}</td>` +
                                //     `<td>${$('#add_pkmt').val()}</td>` +
                                //     `<td>${$('#add_tag').val()}</td>` +
                                //     `<td>${$('#add_minor').val()}</td>` +
                                //     `<td>${$('#add_flag').val()}</td>` +
                                //     `<td>${$('#add_omi').val()}</td>` +
                                //     `</tr>`
                                // );
                                getData();

                                $('#m_add').modal('hide');

                                // needRefresh = true;
                                // needRefreshNew = true;
                            }
                        },
                        error: function () {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: 'Terjadi kesahalahn!',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        function getDataAdded(plu){
            $.ajax({
                url: '{{ url()->current() }}/get-data-added',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    plu: plu
                },
                beforeSend: function(){
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('#add_tgldaftar').val(response.tgldaftar);
                    $('#add_tglbpb').val(response.tglbpb);
                    $('#add_pkmt').val(response.pkmt).prop('disabled',false);
                    $('#add_tag').val(response.tag);
                    $('#add_minor').val(response.minor);
                    $('#add_flag').val(response.flag);
                    $('#add_omi').val(response.omi);
                },
                error: function () {
                    $('#modal-loader').modal('hide');

                    swal({
                        title: 'Terjadi kesahalahn!',
                        icon: 'error'
                    });
                }
            });
        }

        function print(){
            swal({
                title: 'Ingin mencetak data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then((ok) => {
                if(ok){
                    window.open(`{{ url()->current() }}/print?prdcd1=${$('#prdcd1').val()}&prdcd2=${$('#prdcd2').val()}`,'_blank');
                }
            });
        }

    </script>

@endsection
