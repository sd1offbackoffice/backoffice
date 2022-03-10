@extends('navbar')
@section('title','PROSES | MONTH END')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Month End</legend>
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Periode</label>
                                        <div class="col-sm-3 offset-1">
                                            <input type="text" class="form-control daterange-periode" id="periode1">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control daterange-periode" id="periode2">
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-primary" id="btn-cek">Cek Proses
                                            </button>
                                            <button type="button" class="btn btn-primary" id="btn-proses-ulang"
                                                    onclick="prosesUlang()" style="display: none">Proses Ulang
                                            </button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row mb-1">
                                        <table class="table table-sm mb-0 text-center">
                                            <thead class="thColor">
                                            <tr>
                                                <th>No.</th>
                                                <th class="text-left">Nama Proses</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tabel-urutan-proses">
                                            <tr>
                                                <td>1</td>
                                                <td class="text-left">Cek Proses Awal</td>
                                                <td id="status-1"></td>
                                            </tr>

                                            <tr>
                                                <td>2</td>
                                                <td class="text-left">Proses Hitung Stock</td>
                                                <td id="status-2"></td>
                                            </tr>

                                            <tr>
                                                <td>3</td>
                                                <td class="text-left">Proses Hitung Stock CMO</td>
                                                <td id="status-3"></td>
                                            </tr>

                                            <tr>
                                                <td>4</td>
                                                <td class="text-left">Proses Sales Rekap</td>
                                                <td id="status-4"></td>
                                            </tr>

                                            <tr>
                                                <td>5</td>
                                                <td class="text-left">Proses Sales LPP</td>
                                                <td id="status-5"></td>
                                            </tr>

                                            <tr>
                                                <td>6</td>
                                                <td class="text-left">Delete Data BackOffice</td>
                                                <td id="status-6"></td>
                                            </tr>

                                            <tr>
                                                <td>7</td>
                                                <td class="text-left">Proses Copy Stock</td>
                                                <td id="status-7"></td>
                                            </tr>

                                            <tr>
                                                <td>8</td>
                                                <td class="text-left">Proses Copy Stock CMO</td>
                                                <td id="status-8"></td>
                                            </tr>

                                            <tr>
                                                <td>9</td>
                                                <td class="text-left">Proses Hitung Stock Tahap 2</td>
                                                <td id="status-9"></td>
                                            </tr>

                                            <tr>
                                                <td>10</td>
                                                <td class="text-left">Proses Hitung Stock CMO Tahap 2</td>
                                                <td id="status-10"></td>
                                            </tr>

                                            <tr>
                                                <td>11</td>
                                                <td class="text-left">Proses LPP Point</td>
                                                <td id="status-11"></td>
                                            </tr>
                                            <tr>
                                                <td>12</td>
                                                <td class="text-left">Cek Proses Akhir</td>
                                                <td id="status-12"></td>
                                            </tr>
                                            <tr>
                                            </tbody>
                                            <tfoot></tfoot>
                                        </table>
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
        var intv;
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
                width: 0 + '%'
            }, 1000);
            $('.progress-bar').text(0 + '%');
            $('#btn-proses').attr('disabled', false);
            $('#btn-proses').empty().append('PROSES');

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
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#btn-cek').attr('disabled', true);
                    // $('#btn-cek').empty().append('<i class="fas fa-spinner fa-spin"></i>');

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
                        for (i = 0; i < response.data.length; i++) {
                            if (response.data[i].status == 'WAITING') {
                                selesai = false;
                            }
                            id = response.data[i].submenu.split('_')[0];
                            $('#status-' + id).html(`
                                ${response.data[i].status == 'LOADING' ? '<i class="fas fa-spinner fa-spin"></i>' : response.data[i].status == 'DONE' ? '<i class="fas fa-check-circle text-success"></i>' : response.data[i].status == 'EXEC' ? '<button data="' + response.data[i].submenu.split('_')[0] + '" class="btn btn-primary btn-proses">Proses</button>' : response.data[i].status == 'ERROR' ? '<i class="fas fa-ban text-danger"></i><button data="' + response.data[i].submenu.split('_')[0] + '" class="btn btn-primary btn-proses">Proses</button>' : response.data[i].status}
                            `);
                        }
                        if (selesai) {
                            $('#btn-proses-ulang').show();
                            $('#btn-cek').hide();
                        }
                        $(document).find('.btn-proses').each(function () {
                            $(this).click();
                            console.log($(this).attr('data'));
                        })
                    }
                }, error: function (error) {
                    alertError('Error Get Status Proses', error.responseJSON.message, 'error')
                    console.log(error);
                }
            });
        }

        $(document).on('click', '#btn-cek', function () {
            cekProses();
            doIntervalProses();
        });

        function doIntervalProses() {
            intv = setInterval(function () {
                cekProses();
            }, 10000);
        }

        $(document).on('click', '.btn-proses', function () {
            var currentButton = $(this);
            clearInterval(intv);
            doIntervalProses();
            var proses = $(this).attr('data');
            switch (proses) {
                case '1' :
                    cekProsesAwal(proses);
                    break;
                case '2' :
                    prosesHitungStock(proses);
                    break;
                case '3' :
                    prosesHitungStockCMO(proses);
                    break;
                case '4' :
                    prosesSalesRekap(proses);
                    break;
                case '5' :
                    prosesSalesLPP(proses);
                    break;
                case '6' :
                    deleteDataBackkoffice(proses);
                    break;
                case '7' :
                    prosesCopyStock(proses);
                    break;
                case '8' :
                    prosesCopyStockCMO(proses);
                    break;
                case '9' :
                    prosesHitungStock2(proses);
                    break;
                case '10' :
                    prosesHitungStockCMO2(proses);
                    break;
                case '11' :
                    prosesLPPPoint(proses);
                    break;
                case '12' :
                    cekProsesAkhir(proses);
                    break;
            }
        });

        function cekProsesAwal(val) {
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
                url: '{{ url()->current() }}/proses',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                    location.reload();
                                }
                            });
                    }
                }, error: function (error) {

                    alertError('Error Proses Cek Awal', error.responseJSON.message, 'error')
                    console.log(error);
                }
            });
        }

        function prosesHitungStock(val) {
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
                url: '{{ url()->current() }}/proses-hitung-stok',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function prosesHitungStockCMO(val) {
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
                url: '{{ url()->current() }}/proses-hitung-stok-cmo',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function prosesHitungStockCMO2(val) {
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
                url: '{{ url()->current() }}/proses-hitung-stok-cmo2',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function prosesSalesRekap(val) {
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
                url: '{{ url()->current() }}/proses-sales-rekap',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function prosesSalesLPP(val) {
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
                url: '{{ url()->current() }}/proses-sales-lpp',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function deleteDataBackkoffice(val) {
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
                url: '{{ url()->current() }}/delete-data',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function prosesCopyStock(val) {
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
                url: '{{ url()->current() }}/proses-copystock',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function prosesCopyStockCMO(val) {
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
                url: '{{ url()->current() }}/proses-copystock-cmo',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function prosesHitungStock2(val) {
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
                url: '{{ url()->current() }}/proses-hitung-stok2',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function prosesLPPPoint(val) {
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
                url: '{{ url()->current() }}/proses-lpp-point',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
            });
        }

        function cekProsesAkhir(val) {
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
                url: '{{ url()->current() }}/proses-akhir',
                type: 'post',
                data: {
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                    $('#status-' + val).empty().html('<i class="fas fa-spinner fa-spin"></i>');
                },
                success: function (response) {
                    // doIntervalProses();
                    if (response.status == 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status,
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                }
                            });
                    }
                }, error: function (error) {
                    console.log(error);
                    if(error.statusText != 'timeout'){
                        alertError('Error Proses Hitung Stock', error.responseJSON.message, 'error')
                    }
                    console.log(error);
                },timeout: 20000
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
                    bulan: periode1,
                    tahun: periode2
                },
                beforeSend: function () {
                },
                success: function (response) {
                    $('#btn-cek').show().attr('disabled', true);
                    $('#btn-proses-ulang').hide();
                    // doIntervalProses();
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
