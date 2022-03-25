@extends('navbar')
@section('title','Proses LPP')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-8">
                                <form class="form">
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Periode</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control daterange-periode" id="periode1">
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-center">s/d</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control daterange-periode" id="periode2">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-1 mt-5 justify-content-center">
                                        <button type="button" class="btn btn-primary col-sm-5"
                                                id="btn-proses">PROSES
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <style>
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

        $('#btn-proses').on('click', function () {
            periode1 = $('#periode1').val();
            periode2 = $('#periode2').val();
            if (periode1 == "" || periode2 == "") {
                swal('Mohon isi periode dengan benar !!', '', 'warning');
            } else {
                ajaxSetup();
                $.ajax({
                    url: "{{ url('/bo/lpp/proses-lpp/proses') }}",
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
                        swal(response.status, response.message, response.status);
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>


@endsection
