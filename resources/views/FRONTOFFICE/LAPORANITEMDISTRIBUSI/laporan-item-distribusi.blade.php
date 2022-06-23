@extends('navbar')


@section('title','FO | LAPORAN ITEM DISTRIBUSI')
@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="offset-1 col-sm-10">

                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">LAPORAN ITEM DISTRIBUSI</legend>
                    <div class="card-body ">
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label text-sm-right pl-0 pr-0 ">Pilih Cetakan</label>
                            <div class="col-sm-7">
                                <select class="form-control" id="jenis-cetakan">
                                    <option value="1">Laporan Pembelian Perdana Item(s) Distribusi Tertentu
                                    </option>
                                    <option value="2">Listing Retur Item(s) Distribusi Tertentu
                                    </option>
                                    <option value="3">Laporan Transaksi Penukaran Barang
                                    </option>
                                    <option value="4">Laporan Frekuensi Penukaran Barang Dagangan (Per Member Merah)
                                    </option>
                                    <option value="5">Laporan Penyerahan Barang Dagangan Yang Ditukar
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group opt-tanggal">
                            <label class="col-sm-3 pl-0 pr-0 text-right col-form-label">Tanggal</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="periode-1" placeholder="dd/mm/yyyy" autocomplete="off">
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="periode-2" placeholder="dd/mm/yyyy" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group opt-tanggal-1">
                            <label class="col-sm-3 pl-0 pr-0 text-right col-form-label">Tanggal</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal-solo" id="tanggal-solo" placeholder="dd/mm/yyyy" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group opt-bulan">
                            <label class="col-sm-3 pl-0 pr-0 text-right col-form-label">Bulan</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control bulan" id="bulan" placeholder="mm/yyyy" autocomplete="off">
                            </div>
                        </div>
                        <div class="row form-group justify-content-center">
                            <button class="col-sm-3 btn btn-success" onclick="cetak()">CETAK LAPORAN</button>
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
        $(document).ready(function() {
            $('.opt-tanggal').hide();
            $('.opt-tanggal-1').hide();
        });

        // $('.opt-tanggal-1').val(today);
        $('.bulan').datepicker( {
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'mm/yy',
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });
        $('.tanggal-solo').daterangepicker( {
            locale: {
                format: 'DD/MM/YYYY',
            },
            singleDatePicker: true,
            showDropdowns: true
        });
        $('.tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.tanggal').on('apply.daterangepicker', function (ev, picker) {
            $('#periode-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#periode-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggal').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
        $('#jenis-cetakan').on('change', function () {
            var jenisCetakan = $(this).val();
            if($.inArray(jenisCetakan, ["1","4"] ) > -1){
                $('.opt-bulan').show();
                $('.opt-tanggal').hide();
                $('.opt-tanggal-1').hide();
            }
            else if($.inArray(jenisCetakan, ["5","2"] ) > -1){
                $('.opt-bulan').hide();
                $('.opt-tanggal').hide();
                $('.opt-tanggal-1').show();
            }
            else{
                $('.opt-tanggal').show();
                $('.opt-bulan').hide();
                $('.opt-tanggal-1').hide();
            }
        });
        function cetak() {

            if($.inArray($('#jenis-cetakan').val(), ["1","4"] ) > -1){
                if ($('#bulan').val() == '') {
                    swal({
                        title: 'Bulan harus dipilih!',
                        icon: 'error'
                    });
                    return false;
                }
                window.open(`{{ url()->current() }}/cetak?bulan=${$('#bulan').val()}&jenis=${$('#jenis-cetakan').val()}`, '_blank');
            }
            else if($.inArray($('#jenis-cetakan').val(), ["5","2"] ) > -1){
                if ($('#tanggal-solo').val() == '' ){
                    swal({
                        title: 'Tanggal harus dipilih!',
                        icon: 'error'
                    });
                    return false;
                }
                window.open(`{{ url()->current() }}/cetak?tgl1=${$('#tanggal-solo').val()}&jenis=${$('#jenis-cetakan').val()}`, '_blank');
            }
            else{
                if ($('#periode-1').val() == '' || $('#periode-2').val() == '') {
                    $('#periode-1').select();
                    swal({
                        title: 'Periode harus dipilih!',
                        icon: 'error'
                    });
                    return false;
                }
                window.open(`{{ url()->current() }}/cetak?tgl1=${$('#periode-1').val()}&tgl2=${$('#periode-2').val()}&jenis=${$('#jenis-cetakan').val()}`, '_blank');
            }
        }
    </script>

@endsection
