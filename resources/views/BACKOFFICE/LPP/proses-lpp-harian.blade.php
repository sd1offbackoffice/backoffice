@extends('navbar')
@section('title','Proses LPP Harian')
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
                                        <label class="col-sm-3 col-form-label text-sm-right">Periode </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control daterange-periode" id="periode1">
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-center">s/d</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control daterange-periode" id="periode2">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-3 col-form-label text-sm-right">Tanggal SO </label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control date" id="tanggal-so">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row mb-1">
                                        <div class="custom-control custom-checkbox offset-2 col-sm-4">
                                            <input type="checkbox" class="custom-control-input" id="audit">
                                            <label for="audit" class="custom-control-label">Khusus PLU Audit</label>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-1 mt-5 justify-content-center">
                                        <button type="button" class="btn btn-primary col-sm-5"
                                                id="btn-proses">PROSES LAPORAN
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
            $('.date').datepicker({
                "dateFormat" : "dd/mm/yy",
            });
            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output1 = '0' + (day - day + 1) + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            var output2 = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            $('#periode1').val(output1);
            $('#periode2').val(output2);
            $('#tanggal-so').val(output2);
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
            tglso = $('#tanggal-so').val();
            checkplu = $('#audit').is(":checked");
            if (periode1 == "" || periode2 == "") {
                swal('Mohon isi periode dengan benar !!', '', 'warning');
            } else {
                ajaxSetup();
                $.ajax({
                    url: "{{ url('/bo/lpp/proses-lpp-harian/proses') }}",
                    type: 'post',
                    data: {
                        periode1: periode1,
                        periode2: periode2,
                        tglso: tglso,
                        checkplu: checkplu,
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if (response.status == 'success') {
                            window.open(`{{ url()->current() }}/cetak?periode1=${periode1}&periode2=${periode2}&tglso=${tglso}&checkplu=${checkplu}`,'_blank');
                            swal(response.status, response.message, response.status);
                        } else {
                            alertError(response.status, response.message, response.status)
                        }
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>


@endsection
