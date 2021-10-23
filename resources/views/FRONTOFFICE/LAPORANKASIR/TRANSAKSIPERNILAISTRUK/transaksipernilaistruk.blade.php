@extends('navbar')
@section('title','LAPORAN KASIR | TRANSASKI PER NILAI STRUK')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary" id="data-field">
                    <legend class="w-auto ml-5"> Laporan Sales Transaksi Per Nilai Struk</legend>
                    <div class="card-body">
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 1 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-1" placeholder="..." value="0">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 1 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-1" value="10000">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 2 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-2" placeholder="..." value="10001">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 2 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-2" value="25000">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 3 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-3" placeholder="..." value="25001">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 3 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-3" value="50000">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 4 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-4" placeholder="..." value="50001">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 4 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-4" value="100000">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 5 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-5" placeholder="..." value="100001">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 5 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-5" value="200000">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 6 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-6" placeholder="..." value="200001">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 6 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-6" value="300000">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 7 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-7" placeholder="..." value="300001">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 7 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-7" value="400000">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 8 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-8" placeholder="..." value="400001">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 8 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-8" value="500000">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 9 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-9" placeholder="..." value="500001">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 9 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-9" value="600000">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Bawah Kolom 10 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control bb" id="bb-10" placeholder="..."
                                       value="600001">
                            </div>
                            <label class="col-sm-3 col-form-label text-sm-right">Batas Atas Kolom 10 :</label>
                            <div class="col-sm-3">
                                <input type="number" class="form-control ba" id="ba-10" value="10000000">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Mulai Tanggal :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control tanggal" id="startDate" placeholder="..."
                                       value="">
                            </div>
                            <label class="col-sm-1 col-form-label text-center">s/d</label>
                            <div class="col-sm- 2">
                                <input type="text" class="form-control tanggal" id="endDate" value="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-sm-right">Member :</label>
                            <div class="form-check col-sm-1">
                                <input class="form-check-input" type="radio" name="member" id="member-all" value="ALL" checked>
                                <label class="form-check-label" for="member-all">
                                    All
                                </label>
                            </div>
                            <div class="form-check col-sm-1">
                                <input class="form-check-input" type="radio" name="member" id="member-biru" value="BIRU">
                                <label class="form-check-label" for="member-biru">
                                    Biru
                                </label>
                            </div>
                            <div class="form-check col-sm-1">
                                <input class="form-check-input" type="radio" name="member" id="member-merah" value="MERAH">
                                <label class="form-check-label" for="member-merah">
                                    Merah
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-10 col-sm-2">
                                <button class="btn btn-primary" onclick="cetak()">CETAK</button>
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
            $('.tanggal').datepicker({
                "dateFormat": "dd/mm/yy",
            });
            $('.tanggal').datepicker('setDate', new Date());

        });

        function cekTanggal() {
            tgl1 = $.datepicker.parseDate('dd/mm/yy', $('#tgl1').val());
            tgl2 = $.datepicker.parseDate('dd/mm/yy', $('#tgl2').val());
            if (tgl1 == '' || tgl2 == '') {
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
            }
            if (new Date(tgl1) > new Date(tgl2)) {
                swal({
                    title: 'Tanggal Tidak Benar!',
                    icon: 'warning'
                });
            }
        }

        $('.tanggal').on('change', function () {
            cekTanggal();
        });

        $('.ba').on('keypress', function (e) {
            if (e.which == '13') {
                id = parseInt(this.id.split('-')[1]);
                nextId = id + 1;
                valueCurrent = parseInt($(this).val());
                valueBefore = parseInt($('#bb-' + id).val());
                if (valueBefore < valueCurrent) {
                    $('#bb-' + nextId).val(valueCurrent + 1).select();
                } else {
                    $('#ba-' + id).val(parseInt($('#bb-' + id).val()) + 1);
                }
            }
        });

        $('.bb').on('keypress', function (e) {
            if (e.which == '13') {
                id = parseInt(this.id.split('-')[1]);
                nextId = id + 1;
                valueCurrent = parseInt($(this).val());
                if (id == 1) {
                    valueBefore = valueCurrent - 1;
                } else {
                    valueBefore = parseInt($('#ba-' + (id - 1)).val());
                }

                if (valueBefore < valueCurrent) {
                    $('#ba-' + id).select();
                } else {
                    $('#bb-' + id).val(parseInt($('#ba-' + (id - 1)).val()) + 1);
                }
            }
        });

        function cetak() {

            for (i = 1; i <= 10; i++) {
                bbVal = parseInt($('#bb-' + i).val());
                baVal = parseInt($('#ba-' + i).val());
                bbNextVal = parseInt($('#ba-' + i + 1).val());
                if (bbVal > baVal) {
                    console.log('a')
                    $('#ba-' + i).select();
                    break;
                }
                if (baVal > bbNextVal) {
                    console.log('b')
                    $('#bb-' + i).select();
                    break;
                }
            }
            window.open(`{{ url()->current() }}/cetak?tanggal1=${$('#startDate').val()}&tanggal2=${$('#endDate').val()}&bb1=${$('#bb-1').val()}&ba1=${$('#ba-1').val()}
            &bb2=${$('#bb-2').val()}&ba2=${$('#ba-2').val()}&bb3=${$('#bb-3').val()}&ba3=${$('#ba-3').val()}&bb4=${$('#bb-4').val()}&ba4=${$('#ba-4').val()}&bb5=${$('#bb-5').val()}&ba5=${$('#ba-5').val()}
            &bb6=${$('#bb-6').val()}&ba6=${$('#ba-6').val()}&bb7=${$('#bb-7').val()}&ba7=${$('#ba-7').val()}&bb8=${$('#bb-8').val()}&ba8=${$('#ba-8').val()}&bb9=${$('#bb-9').val()}&ba9=${$('#ba-9').val()}
            &bb10=${$('#bb-10').val()}&ba10=${$('#ba-10').val()}&member=${$("input[name='member']:checked").val()}`, '_blank');
        }
    </script>

@endsection
