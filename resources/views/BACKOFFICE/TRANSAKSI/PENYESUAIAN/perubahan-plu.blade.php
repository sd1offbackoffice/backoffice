@extends('navbar')

@section('title','Perubahan PLU')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">Perubahan PLU</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label">PLU LAMA</label>
                            <div class="col-sm-2">
                                <input maxlength="10" type="text" class="form-control" id="plulama" disabled>
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-primary rounded-circle btn_lov" data-toggle="modal" data-target="#m_lov" onclick="tipe = 'lama'" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label"></label>
                            <div class="col-sm-8">
                                <input maxlength="10" type="text" class="form-control" id="deskripsilama" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label"></label>
                            <div class="col-sm-5">
                                <input maxlength="10" type="text" class="form-control" id="satuanlama" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label">PLU BARU</label>
                            <div class="col-sm-2">
                                <input maxlength="10" type="text" class="form-control" id="plubaru" disabled>
                            </div>
                            <div class="col-sm-1">
                                <button class="btn btn-primary rounded-circle btn_lov" data-toggle="modal" data-target="#m_lov" onclick="tipe = 'baru'" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label"></label>
                            <div class="col-sm-8">
                                <input maxlength="10" type="text" class="form-control" id="deskripsibaru" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label"></label>
                            <div class="col-sm-5">
                                <input maxlength="10" type="text" class="form-control" id="satuanbaru" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label"></label>
                            <div class="col-sm-2">
                                <button class="col btn btn-success" onclick="proses()">PROSES</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov">
                                    <thead>
                                    <tr>
                                        <th>No MPP</th>
                                        <th>Tanggal</th>
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

        .buttonInside {
            position: relative;
        }

        .row-lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 430px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        #table_data td{
            vertical-align: middle;
        }

    </style>

    <script>
        var prdcd;
        var lov;

        var tipe;

        $(document).ready(function(){
            lov = $('#table_lov').DataTable({
                "ajax": '{{ url('/bo/transaksi/penyesuaian/perubahanplu/get-data-lov') }}',
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov').css({'cursor': 'pointer'});
                    $('.btn_lov').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                },
                "order" : []
            });
        });

        $(document).on('click', '.row-lov', function (e) {
            prdcd = $(e.target).parent().find('td').html();
            if(tipe == 'lama')
                $('#plulama').val(prdcd);
            else $('#plubaru').val(prdcd);

            $('#m_lov').modal('hide');

            getData(prdcd);
        });

        function getData(prdcd){
            $.ajax({
                type: "GET",
                url: "{{ url('/bo/transaksi/penyesuaian/perubahanplu/get-data') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {prdcd: prdcd},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if(tipe == 'lama'){
                        $('#deskripsilama').val(response.desk);
                        $('#satuanlama').val(response.satuan);
                    }
                    else{
                        $('#deskripsibaru').val(response.desk);
                        $('#satuanbaru').val(response.satuan);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: error.responseJSON.exception,
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {

                    });
                }
            });
        }

        function proses(){
            plulama = $('#plulama').val();
            plubaru = $('#plubaru').val();

            swal({
                title: 'Yakin ingin memproses perubahan PLU '+plulama+' menjadi '+plubaru+' ?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    swal({
                        title: 'Pilih ukuran Cetakan!',
                        icon: 'warning',
                        buttons: {
                            cancel: 'Cancel',
                            besar: {
                                text: 'Besar',
                                value: 'besar'
                            },
                            kecil: {
                                text: 'Kecil',
                                value: 'kecil'
                            }
                        }
                    }).then((ukuran) => {
                        if(ukuran){
                            $.ajax({
                                type: "POST",
                                url: "{{ url('/bo/transaksi/penyesuaian/perubahanplu/proses') }}",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    prdcdlama: $('#plulama').val(),
                                    prdcdbaru: $('#plubaru').val(),
                                    ukuran: ukuran
                                },
                                beforeSend: function () {
                                    $('#modal-loader').modal('show');
                                },
                                success: function (response) {
                                    $('#modal-loader').modal('hide');

                                    swal({
                                        title: response.title,
                                        icon: response.status,
                                    });
                                },
                                error: function (error) {
                                    $('#modal-loader').modal('hide');
                                    // handle error
                                    swal({
                                        title: error.responseJSON.exception,
                                        text: error.responseJSON.message,
                                        icon: 'error'
                                    }).then(() => {

                                    });
                                }
                            });
                        }
                    })
                }
            })
        }
    </script>

@endsection
