@extends('navbar')
@section('title','PROSES | HITUNG ULANG STOCK')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <form class="form">
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Periode </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control daterange-periode" id="periode1">
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-center">s/d</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control daterange-periode" id="periode2">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">PLU</label>
                                        <div class="col-sm-4 buttonInside">
                                            <input type="text" class="form-control" id="plu1">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov"
                                                    data-toggle="modal" id="btn-lov1" >
{{--                                                <i class="fas fa-spinner fa-spin"></i>--}}
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-center">s/d</label>
                                        <div class="col-sm-4 buttonInside">
                                            <input type="text" class="form-control" id="plu2">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov"
                                                    data-toggle="modal" id="btn-lov2" >
{{--                                                <i class="fas fa-spinner fa-spin"></i>--}}
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Waktu</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control daterange-waktu" id="mulai" disabled>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-center">s/d</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control daterange-waktu" id="akhir" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1 mt-5 justify-content-center">
                                        <div class="row-sm-12">
                                            <button type="button" class="btn btn-primary"
                                                    id="btn-hitung-ulang-stock">Proses Hitung Ulang Stock
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1 justify-content-center">
                                        <div class="row-sm-6 mr-2">
                                            <button type="button" class="btn btn-primary"
                                                    id="btn-hitung-ulang-point">Proses Hitung Ulang Point
                                            </button>
                                        </div>
                                        <div class="row-sm-6">
                                            <button type="button" class="btn btn-primary"
                                                    id="btn-hapus-point">Proses Hapus Point - Star Tahunan
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-1">
                                        <label class="col-sm-12 col-form-label text-danger text-sm-center">* Untuk Hitung
                                            Ulang Point dan Hapus Tahunan tidak diperlukan Paramater Inputan *</label>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--MODAL plu1--}}
    <div class="modal fade" id="m_lov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>
                        LOV PLU
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>PLU</td>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>


    <style>
        .row-lov1:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .row-lov2:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov-plu {
            position: absolute;
            /*right: 4px;*/
            /*top: 1px;*/
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;

        }

        .input-group-text {
            background-color: white;
        }
    </style>


    <script>
        object_plu = '#plu1';
        $(document).ready(function () {
            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output1 = '0' + (day - day + 1) + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            var output2 = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            $('#periode1').val(output1);
            $('#periode2').val(output2);

            getLovPLU('');
        });

        $('.daterange-periode').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.daterange-periode').on('apply.daterangepicker', function (ev, picker) {
            $('#periode1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#periode2').val(picker.endDate.format('DD/MM/YYYY'));
        });

        $('.daterange-periode').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        $('#btn-lov1').on('click', function () {
            object_plu = '#plu1';
            console.log(object_plu);
        });
        $('#btn-lov2').on('click', function () {
            object_plu = '#plu2';
            console.log(object_plu);
        });

        $('#plu1').on('keypress', function (e) {
            if (e.keyCode == 13) {
                var plu = $('#plu1').val();
                for (var i = plu.length; i < 7; i++) {
                    plu = '0' + plu;
                }
                $('#plu1').val(plu);
                $('#plu2').focus();
            }
        });
        $('#plu2').on('keypress', function (e) {
            if (e.keyCode == 13) {
                var plu = $('#plu2').val();
                for (var i = plu.length; i < 7; i++) {
                    plu = '0' + plu;
                }
                $('#plu2').val(plu);
            }
        });
        function getLovPLU(val) {
            if ($.fn.DataTable.isDataTable('#table_lov')) {
                $('#table_lov').DataTable().destroy();
            }
            table_lov = $('#table_lov').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-data-lov',
                    data: {
                        search: val,
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('row-lov');
                },
                "order": [],
                "columnDefs": [
                    {
                        targets: [1],
                        className: 'text-left'
                    },
                ],
                "initComplete": function () {
                    $(document).on('click', '.modalRowMember', function (e) {
                        $('#' + obj).val($(this).find('td:eq(0)').html());
                        $('#' + obj + '-nama').val($(this).find('td:eq(1)').html());
                        $('#m_lov_member').modal('hide');
                    });
                }
            });

            $('#table_lov_filter input').val().focus();

            $('#table_lov_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    table_lov.destroy();
                    getLovPLU($(this).val().toUpperCase());
                }
            });
        }

        $(document).on('click', '.row-lov', function () {
            var currentButton = $(this);
            var plu = currentButton.children().last().text();
            $(object_plu).val(plu);
            $('#m_lov').modal('hide');
        });

        $(document).on('click', '#btn-hitung-ulang-stock', function () {
            var currentButton = $(this);
            var periode1 = $('#periode1').val();
            var periode2 = $('#periode2').val();
            var plu1 = $('#plu1').val();
            var plu2 = $('#plu2').val();

            if (periode1 == '' || periode2 == '') {
                swal('Info', 'Mohon isi Periode', 'info');
                return false;
            }
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/hitung-ulang-stock',
                type: 'post',
                data: {
                    periode1: periode1,
                    periode2: periode2,
                    plu1: plu1,
                    plu2: plu2
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response.status = 'success') {
                        $('#modal-loader').modal('show');
                        console.log(response);
                        $('#mulai').val(response.mulai);
                        $('#akhir').val(response.akhir);
                        swal(response.status, response.err_txt, response.status)
                            .then((ok) => {
                                if (ok) {
                                    $('#modal-loader').modal('hide');
                                }
                            });
                    }
                    else {
                        alertError(response.status, response.message, response.status)
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        });
        $(document).on('click', '#btn-hitung-ulang-point', function () {
            var currentButton = $(this);

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/hitung-ulang-point',
                type: 'post',
                data: {},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response.status = 'success') {
                        $('#modal-loader').modal('show');
                        console.log(response);
                        $('#mulai').val(response.mulai);
                        $('#akhir').val(response.akhir);
                        swal(response.status, response.err_txt, response.status)
                            .then((ok) => {
                                if (ok) {
                                    $('#modal-loader').modal('hide');
                                }
                            });
                    }
                    else {
                        alertError(response.status, response.message, response.status)
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '#btn-hapus-point', function () {
            var currentButton = $(this);
            swal({
                title: 'Peringatan NBH Akan Dibatalkan?',
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                console.log(confirm);
                if (confirm) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/hapus-point',
                        type: 'post',
                        data: {
                            // periode1: periode1,
                            // periode2: periode2,
                            // plu1: plu1,
                            // plu2: plu2
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            if (response.status == 'success') {
                                $('#modal-loader').modal('show');
                                console.log(response);
                                $('#mulai').val(response.mulai);
                                $('#akhir').val(response.akhir);
                                window.open('{{ url()->current() }}/cetak');
                                swal(response.status, response.err_txt, response.status)
                                    .then((ok) => {
                                        if (ok) {
                                            $('#modal-loader').modal('hide');
                                        }
                                    });
                            }
                            else {
                                alertError(response.status, response.err_txt, response.status)
                            }
                        }, error: function (error) {
                            console.log(error);
                        }
                    });
                }
                else {
                    console.log('Tidak dihapus');
                }
            });

        });

    </script>


@endsection
