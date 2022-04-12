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

                                    <div class="form-group row mt-4 pt-2">
                                        <table class="table table-sm mb-0 text-center">
                                            <thead class="thColor">
                                            <tr>
                                                <th>Status</th>
                                                <th>Start</th>
                                                <th>Finish</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbody-status">
                                            <tr>
                                                <td id="status"></td>
                                                <td id="start"></td>
                                                <td id="finish"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="form-group row mb-1 mt-5 justify-content-center">
                                        <button type="button" class="btn btn-primary col-sm-5"
                                                id="btn-cek">PROSES
                                        </button>
                                        <button type="button" class="btn btn-primary" id="btn-proses-ulang"
                                                onclick="prosesUlang()" style="display: none">Proses Ulang
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
        var intv;
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

        $(document).on('click', '.btn-proses', function (e) {
            clearInterval(intv);
            doIntervalProses();
            periode1 = $('#periode1').val();
            periode2 = $('#periode2').val();

            if (periode1 == "" || periode2 == "") {
                clearInterval(intv);
                swal('Mohon isi periode dengan benar !!', '', 'warning');
            } else {
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/proses',
                    type: 'post',
                    data: {
                        periode1: periode1,
                        periode2: periode2
                    },
                    beforeSend: function () {
                        $('#status').empty().html('<i class="fas fa-spinner fa-spin"></i>');
                    },
                    success: function (response) {
                        if (response.status=='info'){
                            $('#tbody-status').empty();
                            $('#periode1').attr('disabled', false);
                            $('#periode2').attr('disabled', false);
                            $('#btn-cek').attr('disabled', false);
                            swal({
                                title: response.status,
                                text: response.message,
                                icon: response.status
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    }, error: function (error) {
                        // swal(response.status, response.message, response.status);
                    },timeout: 20000
                });
            }
            e.preventDefault();
        });

        $(document).on('click', '#btn-cek', function () {
            cekProses();
            doIntervalProses();
        });

        function doIntervalProses() {
            intv = setInterval(function () {
                cekProses();
            }, 10000);
        }

        function cekProses() {
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
                url: '{{ url()->current() }}/get-status',
                type: 'get',
                data: {
                    periode1: periode1,
                    periode2: periode2
                },
                beforeSend: function () {
                    $('#btn-cek').attr('disabled', true);

                    $('#periode1').attr('disabled', true);
                    $('#periode2').attr('disabled', true);
                },
                success: function (response) {
                    var selesai = true;
                    if (response.status == 'error') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {

                                }
                            });
                    } else {
                        if (response.data.status != 'DONE') {
                            selesai = false;
                        }
                        $('#status').html(`
                                ${response.data.status == 'LOADING' ? '<i class="fas fa-spinner fa-spin"></i>' : response.data.status == 'DONE' ? '<i class="fas fa-check-circle text-success"></i>' : response.data.status == 'EXEC' ? '<button class="btn btn-primary btn-proses">Proses</button>' : response.data.status == 'ERROR' ? '<i class="fas fa-ban text-danger"></i><button class="btn btn-primary btn-proses" >Proses</button>' : response.data.status}
                            `);
                        $('#start').html(response.data.start_time);
                        $('#finish').html(response.data.end_time);
                        if (selesai) {
                            clearInterval(intv);
                            $('#btn-proses-ulang').show();
                            $('#btn-cek').hide();
                        }
                        $('.btn-proses').click();
                    }
                }, error: function (error) {
                    alertError('Error Get Status Proses', error.responseJSON.message, 'error')
                    console.log(error);
                }
            });
        }

        function prosesUlang() {
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
                url: '{{ url()->current() }}/proses-ulang',
                type: 'post',
                data: {
                    periode1: periode1,
                    periode2: periode2
                },
                beforeSend: function () {
                },
                success: function (response) {
                    $('#btn-cek').show().attr('disabled', true);
                    $('#btn-proses-ulang').hide();
                    cekProses();
                    $('.btn-proses').click();
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }
    </script>


@endsection
