@extends('navbar')
@section('title','PEROLEHAN POINT REWARD PER TANGGAL')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="ml-3"> Perolehan Point Reward Per Tanggal</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row justify-content-center">
                            <label class="col-sm-2 col-form-label text-sm-right">Tanggal Transaksi :</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="tgl1"
                                       value="">
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">s/d</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="tgl2"
                                       value="">
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-primary" onclick="cetak()">CETAK LAPORAN</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <script>
        idrak = 1;
        $(document).ready(function () {
            $('.tanggal').datepicker({
                "dateFormat": "dd/mm/yy",
            });
            $('.tanggal').datepicker('setDate', new Date());
        });

        function cekTanggal(event) {
            tgl1 = $.datepicker.parseDate('dd/mm/yy', $('#tgl1').val());
            tgl2 = $.datepicker.parseDate('dd/mm/yy', $('#tgl2').val());
            if (tgl1 == '' || tgl2 == '') {
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
                return false;
            }
            if (new Date(tgl1) > new Date(tgl2)) {
                swal({
                    title: 'Tanggal Tidak Benar!',
                    icon: 'warning'
                });
                return false;
            }
            if (new Date(tgl1).getMonth() != new Date(tgl2).getMonth()) {
                swal({
                    title: 'Tanggal Harus dalam bulan yang sama!',
                    icon: 'error'
                });
                return false;
            }
            return true;
        }

        $('.daterange-periode').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        function cetak() {
            menu = $('#menu').val();
            valid = true;
            if (menu == '1') {
                if ($('#rak1').val() == '' || $('#rak2').val() == '') {
                    valid = false;
                }
            } else {
                valid = cekTanggal();
            }
            if (valid) {
                swal({
                    title: 'Pilih Tipe Laporan',
                    icon: 'warning',
                    buttons: {
                        rekap: {
                            text: 'Rekap',
                            value: 'rekap'
                        },
                        detail: {
                            text: 'Detail',
                            value: 'detail'
                        }
                    },
                    dangerMode: true
                }).then((menu) => {
                    if(menu){
                        window.open(`{{ url()->current() }}/cetak?menu=${menu}&tgl1=${$('#tgl1').val()}&tgl2=${$('#tgl2').val()}`,'_blank');
                    }
                });
            }
        }
    </script>
@endsection
