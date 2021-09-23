@extends('navbar')

@section('title','BO | LAPORAN PERCETAKAN FAKTUR PAJAK STANDAR')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="offset-1 col-sm-10">

                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">LAPORAN FAKTUR PAJAK PKP</legend>
                    <div class="card-body ">
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">TANGGAL</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggalPKP" id="pkp-1">
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggalPKP" id="pkp-2">
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-success" onclick="cetakPKP()">Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">LAPORAN FAKTUR PAJAK MM NON PKP</legend>
                    <div class="card-body ">
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">PERIODE</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggalNonPKP" id="mm-non-pkp">
                            </div>
                            <div class="offset-4 col-sm-2">
                                <button class="col btn btn-success" onclick="cetakMMNonPKP()">Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">LAPORAN FAKTUR PAJAK TMI NON PKP</legend>
                    <div class="card-body ">
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">TANGGAL</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggalTMINonPKP" id="tmi-non-pkp-1">
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggalTMINonPKP" id="tmi-non-pkp-2">
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-success" onclick="cetakTMINonPKP()">Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">LAPORAN FAKTUR PAJAK OMI NON PKP</legend>
                    <div class="card-body ">
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">TANGGAL</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggalOMINonPKP" id="omi-non-pkp-1">
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggalOMINonPKP" id="omi-non-pkp-2">
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-success" onclick="cetakOMINonPKP()">Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">LAPORAN FAKTUR PAJAK FREEPASS KLIK IGR</legend>
                    <div class="card-body ">
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">TANGGAL</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggalFreepassKlikIGR" id="freepass-klik-igr-1">
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggalFreepassKlikIGR" id="freepass-klik-igr-2">
                            </div>
                            <div class="col-sm-2">
                                <button class="col btn btn-success" onclick="cetakFreepassKlikIgr()">Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>
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
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover {
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

        .clicked, .row-detail:hover {
            background-color: grey !important;
            color: white;
        }

        .ui-datepicker-calendar {
            display: none;
        }
    </style>

    <script>

        $(document).ready(function () {
            getLovKodeRak('');
            getLovKodePromosi('');
        });

        //PKP
        $('.tanggalPKP').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.tanggalPKP').on('apply.daterangepicker', function (ev, picker) {
            $('#pkp-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#pkp-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggalPKP').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        //NON PKP
        $(function () {
            $('.tanggalNonPKP').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'mm/yy',
                onClose: function (dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            });
        });

        //TMI NON PKP
        $('.tanggalTMINonPKP').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.tanggalTMINonPKP').on('apply.daterangepicker', function (ev, picker) {
            $('#tmi-non-pkp-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#tmi-non-pkp-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggalTMINonPKP').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        //NON PKP
        $('.tanggalOMINonPKP').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.tanggalOMINonPKP').on('apply.daterangepicker', function (ev, picker) {
            $('#omi-non-pkp-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#omi-non-pkp-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggalOMINonPKP').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        //Freepass KLIK IGR
        $('.tanggalFreepassKlikIGR').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.tanggalFreepassKlikIGR').on('apply.daterangepicker', function (ev, picker) {
            $('#freepass-klik-igr-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#freepass-klik-igr-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggalFreepassKlikIGR').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        function cetakPKP() {
            if ($('#pkp-1').val() == '' || $('#pkp-2').val() == '') {
                $('#pkp-1').select();
                swal({
                    title: 'Tanggal harus dipilih!',
                    icon: 'error'
                });
                return false;
            }
            window.open(`{{ url()->current() }}/cetak-pkp?tgl1=${$('#pkp-1').val()}&tgl2=${$('#pkp-2').val()}`, '_blank');
        }

        function cetakMMNonPKP() {
            if ($('#mm-non-pkp').val() == '') {
                $('#mm-non-pkp').select();
                swal({
                    title: 'Tanggal harus dipilih!',
                    icon: 'error'
                });
                return false;
            }
            window.open(`{{ url()->current() }}/cetak-mm-non-pkp?tgl=${$('#mm-non-pkp').val()}`, '_blank');
        }

        function cetakTMINonPKP() {
            if ($('#tmi-non-pkp-1').val() == '' || $('#tmi-non-pkp-2').val() == '') {
                $('#tmi-non-pkp-1').select();
                swal({
                    title: 'Tanggal harus dipilih!',
                    icon: 'error'
                });
                return false;
            }
            window.open(`{{ url()->current() }}/cetak-tmi-non-pkp?tgl1=${$('#tmi-non-pkp-1').val()}&tgl2=${$('#tmi-non-pkp-2').val()}`, '_blank');
        }

        function cetakOMINonPKP() {
            if ($('#omi-non-pkp-1').val() == '' || $('#omi-non-pkp-2').val() == '') {
                $('#omi-non-pkp-1').select();
                swal({
                    title: 'Tanggal harus dipilih!',
                    icon: 'error'
                });
                return false;
            }
            window.open(`{{ url()->current() }}/cetak-omi-non-pkp?tgl1=${$('#omi-non-pkp-1').val()}&tgl2=${$('#omi-non-pkp-2').val()}`, '_blank');
        }

        function cetakFreepassKlikIgr() {
            if ($('#freepass-klik-igr-1').val() == '' || $('#freepass-klik-igr-2').val() == '') {
                $('#freepass-klik-igr-1').select();
                swal({
                    title: 'Tanggal harus dipilih!',
                    icon: 'error'
                });
                return false;
            }
            window.open(`{{ url()->current() }}/cetak-freepass-klik-igr?tgl1=${$('#freepass-klik-igr-1').val()}&tgl2=${$('#freepass-klik-igr-2').val()}`, '_blank');
        }
    </script>

@endsection
