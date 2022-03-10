@extends('navbar')
@section('title','LAPORAN | LAPORAN MONITORING FAKTUR PAJAK SJ/NRB')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">LAPORAN MONITORING FAKTUR PAJAK SJ/NRB</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Tanggal</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control tanggal" id="tanggal-1"
                                               autocomplete="off">
                                    </div>
                                    <label class="col-sm-1" for="">s/d</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control tanggal" id="tanggal-2"
                                               autocomplete="off">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right pl-0 pr-0">Kat. Laporan</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" id="kategori">
                                            <option value="O">Sudah Cetak
                                            </option>
                                            <option value="K">Belum Cetak
                                            </option>
                                            <option value="A">Semua
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right pl-0 pr-0">Cetak</label>
                                    <label class="radio-inline col-sm-1 mt-1">
                                        <input class="radio rVal" type="radio" name="optradio" value="S" checked> SJ
                                    </label>
                                    <label class="radio-inline  col-sm-1 mt-1">
                                        <input class="radio pVal" type="radio" name="optradio" value="N"> NRB
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button class="col-sm-2 btn btn-primary pl-0" id="btn-cetak"
                                                onclick="cetak()">CETAK
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
        })
        $('.tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('.tanggal').on('apply.daterangepicker', function (ev, picker) {
            $('#tanggal-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#tanggal-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggal').on('cancel.daterangepicker', function (ev, picker) {
            $('#tanggal-1').val('');
            $('#tanggal-2').val('');
        });

        function cetak() {
            if (($('#tanggal-1').val() == '' || $('#tanggal-2').val() == '')) {
                swal('Error', "Inputan Tanggal tidak benar!", 'error');
            }else {
                window.open(`{{ url()->current() }}/cetak?tanggal1=${$('#tanggal-1').val()}&tanggal2=${$('#tanggal-2').val()}&kategori=${$('#kategori').val()}&cetak=${$("input[name='optradio']:checked").val()}`, '_blank');
            }
        }

    </script>

@endsection
