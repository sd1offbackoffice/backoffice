@extends('navbar')
@section('title','Month End')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-7">
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
                                                    id="btn-hitung-ulang-stock">PROSES
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1 mt-4">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="keterangan">
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

        });

        $('.daterange-periode').datepicker({
            dateFormat: 'MM yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,

            onClose: function(dateText, inst) {
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



        $(document).on('click', '#btn-hitung-ulang-stock', function () {
            var currentButton = $(this);
            var periode1 = $('#periode1').val();
            var periode2 = $('#periode2').val();
            var plu1 = $('#plu1').val();
            var plu2 = $('#plu2').val();

            if (periode1 == '' || periode2 ==''){
                swal('Info','Mohon isi Periode','info');
                return false;
            }
            ajaxSetup();
            $.ajax({
                url: "{{ url('/bo/proses/hitungulangstock/hitung-ulang-stock') }}",
                type: 'post',
                data: {
                    periode1: periode1,
                    periode2: periode2
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
                        swal(response.status, response.err_txt, response.status);
                    }
                    else {
                        alertError(response.status, response.message, response.status)
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        });

    </script>


@endsection