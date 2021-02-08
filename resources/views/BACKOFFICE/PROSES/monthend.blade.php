@extends('navbar')
@section('title','Month End')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <form class="form">
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Periode</label>
                                        <div class="col-sm-3 offset-1">
                                            <input type="text" class="form-control daterange-periode" id="periode1">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control daterange-periode" id="periode2">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-3 mt-4 justify-content-center">
                                        <div class="row-sm-12">
                                            <button type="button" class="btn btn-primary"
                                                    id="btn-proses">PROSES
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1 mt-4">
                                        <div class="col-sm-12">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: 0%"></div>
                                            </div>
                                        </div>
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
    <div class="modal fade" id="m_lov1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>
                        Nomor NPB
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov1">
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

    {{--MODAL plu1--}}
    <div class="modal fade" id="m_lov2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>
                        Nomor NPB
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov2">
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

        $(document).ready(function () {
            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            $('#periode1').val((month < 10 ? '0' : '') + month);
            $('#periode2').val(d.getFullYear());
        });

        $('.daterange-periode').datepicker({
            dateFormat: 'MM yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,

            onClose: function (dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).val($.datepicker.formatDate('MM yy', new Date(year, month, 1)));
                $('#periode1').val($.datepicker.formatDate('mm', new Date(year, month, 1)));
                $('#periode2').val($.datepicker.formatDate('yy', new Date(year, month, 1)));
            }
        });
        $('.daterange-periode').focus(function () {
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });

        function reset() {
            $('.progress-bar').animate({
                width: 0+'%'
            }, 1000 );
            $('.progress-bar').text( 0+'%' );
            $('#btn-proses').attr('disabled',false);
            $('#btn-proses').empty().append('PROSES');

        }

        $(document).on('click', '#btn-proses', function () {
            var currentButton = $(this);
            var periode1 = $('#periode1').val();
            var periode2 = $('#periode2').val();
            var long = 8;
            if (periode1 == '' || periode2 == '') {
                swal('Info', 'Mohon isi Periode', 'info');
                return false;
            }
            ajaxSetup();
            $.ajax({
                url: "{{ url('/bo/proses/monthend/proses') }}",
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#btn-proses').attr('disabled',true);
                    $('#btn-proses').append('<i class="fas fa-spinner fa-spin"></i>');

                    $('#periode1').attr('disabled',true);
                    $('#periode2').attr('disabled',true);
                },
                success: function (response) {
                    $('.progress-bar').animate({
                        width: 1/long*100+'%'
                    }, 1000 );
                    $('.progress-bar').text( 1/long*100+'%' );

                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text:response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                    reset();
                                }
                            });
                    }
                    else {
                        ajaxSetup();
                        $.ajax({
                            url: "{{ url('/bo/proses/monthend/proses-hitung-stok') }}",
                            type: 'post',
                            data: {
                                bulan: periode1,
                                tahun: periode2
                            },
                            beforeSend: function () {
                            },
                            success: function (response) {
                                if (response.status == 'error') {
                                    swal(response.status, response.message, response.status);
                                }
                                else {
                                    $('.progress-bar').animate({
                                        width: 2/long*100+'%'
                                    }, 1000 );
                                    $('.progress-bar').text( 2/long*100+'%' );
                                    ajaxSetup();
                                    $.ajax({
                                        url: "{{ url('/bo/proses/monthend/proses-hitung-stok-cmo') }}",
                                        type: 'post',
                                        data: {
                                            bulan: periode1,
                                            tahun: periode2
                                        },
                                        beforeSend: function () {
                                        },
                                        success: function (response) {
                                            if (response.status == 'error') {
                                                swal(response.status, response.message, response.status);
                                            }
                                            else {
                                                $('.progress-bar').animate({
                                                    width: 3/long*100+'%'
                                                }, 1000 );
                                                $('.progress-bar').text( 3/long*100+'%' );
                                                ajaxSetup();
                                                $.ajax({
                                                    url: "{{ url('/bo/proses/monthend/proses-sales-rekap') }}",
                                                    type: 'post',
                                                    data: {
                                                        bulan: periode1,
                                                        tahun: periode2
                                                    },
                                                    beforeSend: function () {
                                                    },
                                                    success: function (response) {
                                                        if (response.status == 'error') {
                                                            swal(response.status, response.message, response.status);
                                                        }
                                                        else {
                                                            $('.progress-bar').animate({
                                                                width: 4/long*100+'%'
                                                            }, 1000 );
                                                            $('.progress-bar').text( 4/long*100+'%' );
                                                            ajaxSetup();
                                                            $.ajax({
                                                                url: "{{ url('/bo/proses/monthend/proses-sales-lpp') }}",
                                                                type: 'post',
                                                                data: {
                                                                    bulan: periode1,
                                                                    tahun: periode2
                                                                },
                                                                beforeSend: function () {
                                                                },
                                                                success: function (response) {
                                                                    if (response.status == 'error') {
                                                                        swal(response.status, response.message, response.status);
                                                                    }
                                                                    else {
                                                                        $('.progress-bar').animate({
                                                                            width: 5/long*100+'%'
                                                                        }, 1000 );
                                                                        $('.progress-bar').text( 5/long*100+'%' );
                                                                        ajaxSetup();
                                                                        $.ajax({
                                                                            url: "{{ url('/bo/proses/monthend/delete-data') }}",
                                                                            type: 'post',
                                                                            data: {
                                                                                bulan: periode1,
                                                                                tahun: periode2
                                                                            },
                                                                            beforeSend: function () {
                                                                            },
                                                                            success: function (response) {
                                                                                if (response.status == 'error') {
                                                                                    swal(response.status, response.message, response.status);
                                                                                }
                                                                                else {
                                                                                    $('.progress-bar').animate({
                                                                                        width: 6/long*100+'%'
                                                                                    }, 1000 );
                                                                                    $('.progress-bar').text( 6/long*100+'%' );
                                                                                    ajaxSetup();
                                                                                    $.ajax({
                                                                                        url: "{{ url('/bo/proses/monthend/proses-copystock') }}",
                                                                                        type: 'post',
                                                                                        data: {
                                                                                            bulan: periode1,
                                                                                            tahun: periode2
                                                                                        },
                                                                                        beforeSend: function () {
                                                                                        },
                                                                                        success: function (response) {
                                                                                            if (response.status == 'error') {
                                                                                                swal(response.status, response.message, response.status);
                                                                                            }
                                                                                            else {
                                                                                                $('.progress-bar').animate({
                                                                                                    width: 7/long*100+'%'
                                                                                                }, 1000 );
                                                                                                $('.progress-bar').text( 7/long*100+'%' );
                                                                                                ajaxSetup();
                                                                                                $.ajax({
                                                                                                    url: "{{ url('/bo/proses/monthend/proses-hitung-stok2') }}",
                                                                                                    type: 'post',
                                                                                                    data: {
                                                                                                        bulan: periode1,
                                                                                                        tahun: periode2
                                                                                                    },
                                                                                                    beforeSend: function () {
                                                                                                    },
                                                                                                    success: function (response) {
                                                                                                        $('.progress-bar').animate({
                                                                                                            width: 8/long*100+'%'
                                                                                                        }, 1000 );
                                                                                                        $('.progress-bar').text( 8/long*100+'%' );
                                                                                                        reset();
                                                                                                        swal(response.status, response.message, response.status);
                                                                                                    },
                                                                                                    error: function (error) {
                                                                                                        reset();
                                                                                                        alertError('Error Proses Hitung Stok Tahap 2',error.responseJSON.message,'error')
                                                                                                        console.log(error);
                                                                                                    }
                                                                                                });
                                                                                            }
                                                                                        }, error: function (error) {
                                                                                            reset();
                                                                                            alertError('Error Proses Copy Stock',error.responseJSON.message,'error')
                                                                                            console.log(error);
                                                                                        }
                                                                                    });
                                                                                }
                                                                            }, error: function (error) {
                                                                                reset();
                                                                                alertError('Error Proses Delete',error.responseJSON.message,'error')
                                                                                console.log(error);
                                                                            }
                                                                        });
                                                                    }
                                                                }, error: function (error) {
                                                                    reset();
                                                                    alertError('Error Proses Sales LPP',error.responseJSON.message,'error')
                                                                    console.log(error);
                                                                }
                                                            });
                                                        }
                                                    }, error: function (error) {
                                                        reset();
                                                        alertError('Error Proses Sales Rekap',error.responseJSON.message,'error')
                                                        console.log(error);
                                                    }
                                                });
                                            }
                                        }, error: function (error) {
                                            reset();
                                            alertError('Error Proses Hitung Stok CMO',error.responseJSON.message,'error')
                                            console.log(error);
                                        }
                                    });
                                }
                            }, error: function (error) {
                                reset();
                                alertError('Error Proses Hitung Stok',error.responseJSON.message,'error')
                                console.log(error);
                            }
                        });
                    }
                }, error: function (error) {
                    reset();
                    alertError('Error Proses',error.responseJSON.message,'error')
                    console.log(error);
                }
            });
        });

    </script>


@endsection