@extends('navbar')

@section('title','PKM | ENTRY & INQUERY MONITORING PLU BARU')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-3">ENTRY & INQUERY MONITORING PLU BARU</legend>
                            <div class="card-body">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label">KODE PLU</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="prdcd1" disabled>
                                        <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" onclick="showLOVPrdcd('prdcd1')">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <label for="prdcd" class="col-sm-1 text-right col-form-label">s/d</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="prdcd2" disabled>
                                        <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" onclick="showLOVPrdcd('prdcd2')">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-2">
                                        <button class="col btn btn-primary" onclick="getData()">PILIH</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-3">MASTER BARANG BARU</legend>
                            <div class="card-body pt-0">
                                <div class="row form-group">
                                    <table class="table table-sm mb-0 text-center" id="table_data">
                                        <thead class="text-center thColor">
                                        <tr>
                                            <th width="6%"></th>
                                            <th>PLU</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Tanggal BPB</th>
                                            <th>PKMT</th>
                                            <th>TAG</th>
                                            <th>MINOR</th>
                                            <th>FLAG</th>
                                            <th>OMI</th>
                                        </tr>
                                        </thead>
                                        <tbody id="">
                                        </tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                                <div class="row">
                                    <label for="desk" class="pl-0 pr-0 text-right col-form-label">Deskripsi</label>
                                    <div class="col-sm-5">
                                        <input maxlength="10" type="text" class="form-control" id="desk" disabled>
                                    </div>
                                    <div class="col-sm-2 pl-0">
                                        <input maxlength="10" type="text" class="form-control text-center" id="unit" disabled>
                                    </div>
                                    <button class="col-sm-2 mr-3 btn btn-success" onclick="getData()">TAMBAH</button>
                                    <button class="col-sm-2 btn btn-primary" onclick="getData()">CETAK</button>
                                </div>
                            </div>
                        </fieldset>
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
        let dataPRDCD = [];
        let dataMonitoring = [];

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

            getData();
        });

        function showLOVPrdcd(field){
            currField = field;
            if(!$.fn.DataTable.isDataTable('#table_prdcd')){
                getPRDCD();
            }

            $('#m_prdcd').modal('show');
        }

        function getPRDCD(){
            $('#table_prdcd').DataTable({
                "ajax": '{{ url()->current().'/get-lov-prdcd' }}',
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
                    $(row).addClass('row-prdcd').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    // $('#btn_prdcd').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-prdcd', function (e) {
                        $('#'+currField).val($(this).find('td:eq(1)').html());

                        $('#m_prdcd').modal('hide');

                        cekPrdcd(currField);
                    });
                }
            });
        }

        function cekPrdcd(field){
            if($('#prdcd1').val() && $('#prdcd2').val() && $('#prdcd1').val() > $('#prdcd2').val()){
                $('#' + field).val('');
                swal({
                    title: field === 'prdcd1' ? 'PLU pertama lebih besar dari PLU kedua!' : 'PLU kedua lebih kecil dari PLU pertama!',
                    icon: 'warning'
                }).then(() => {
                    showLOVPrdcd(field);
                });
            }
        }

        function getData(){
            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().destroy();
                $("#table_data tbody [role='row']").remove();
            }

            $('#prdcd1').val('1162710');
            $('#prdcd2').val('1196760');

            $('#table_data').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-data',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        // prdcd1: $('#prdcd1').val(),
                        // prdcd2: $('#prdcd2').val(),
                        prdcd1: '1162710',
                        prdcd2: '1196760'
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

                    dataPRDCD.push(data.fmkplu);
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

            $('#table_data_wrapper').css('width','100%');
        }

        function showDesc(prdcd){
            i = $.inArray(prdcd,dataPRDCD);

            $('#desk').val(dataMonitoring[i].prd_deskripsipanjang);
            $('#unit').val(dataMonitoring[i].prd_satuan);
        }

        function deleteData(i){
            swal({
                title: 'Yakin ingin menghapus data PLU ' + dataPRDCD[i] + '?',
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
                            plu: dataPRDCD[i]
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');

                            swal({
                                title: response.title,
                                icon: response.status
                            }).then(() => {
                                if(response.status === 'success'){
                                    $('#table_data tbody tr').each(function(){
                                        if($(this).find('td:eq(1)').html() == dataPRDCD[i]){
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

    </script>

@endsection
