@extends('navbar')

@section('title','LAPORAN | DAFTAR PB YANG TIDAK TERBENTUK PO')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">DAFTAR PB YANG TIDAK TERBENTUK PO</legend>
                    <br>
                    <div class="menu-default">
                        <div class="row">
                            <label class="offset-1 col-sm-2 pl-0 pr-0 text-right col-form-label">TANGGAL</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="tanggal1">
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="tanggal2">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row p-2 justify-content-center">
                        <button class="col-sm-3 btn btn-primary" onclick="cetak()">CETAK LAPORAN</button>
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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover {
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang {
            position: absolute;
            bottom: 10px;
            right: 3vh;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active {
            box-shadow: none !important;
            outline: 0px !important;
        }

        .btn-lov-plu {
            position: absolute;
            bottom: 10px;
            right: 2vh;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active {
            box-shadow: none !important;
            outline: 0px !important;
        }

        .modal thead tr th {
            vertical-align: middle;
        }
    </style>

    <script>
        $(document).ready(function () {
        });
        $('.tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.tanggal').on('apply.daterangepicker', function (ev, picker) {
            $('#tanggal1').val(picker.startDate.format('DD-MM-YYYY'));
            $('#tanggal2').val(picker.endDate.format('DD-MM-YYYY'));
        });

        $('.tanggal').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
        function cetak() {
            if ($('#tanggal1').val()=='' || $('#tanggal2').val()=='') {
                swal({
                    title: 'Inputan tanggal belum lengkap!',
                    icon: 'warning'
                });
            } else {
                window.open(`{{ url()->current() }}/cetak?tanggal1=${$('#tanggal1').val()}&tanggal2=${$('#tanggal2').val()}`, '_blank');
            }
        }
    </script>

@endsection
