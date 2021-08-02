@extends('navbar')
@section('title','Rekap Struk Per Kasir')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Laporan Struk Per Kasir</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <br>
                            <div class="card-body shadow-lg cardForm">
                                <fieldset class="card border-dark">
                                    <legend class="w-auto ml-5">Rekap Struk Per Kasir</legend>
                                    <div class="row">
                                        <label class="col-sm-4 text-right col-form-label">Tanggal :</label>
                                        <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker">
                                    </div>
                                    <div class="row">
                                        <label class="col-sm-4 text-right col-form-label">Type Transaksi :</label>
                                        <input class="col-sm-2 text-center form-control" type="text" id="menuSR" onkeypress="return isSR(event)" maxlength="1"> {{--kalau mau tanpa perlu klik enter tambahkan aja onchange="khususElektronik()"--}}
                                        <label class="col-sm-2 text-left col-form-label">[S- Sales / R - Refund]</label>
                                    </div>
                                    <br>
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-success col-sm-3" type="button" onclick="cetak()">CETAK</button>
                                    </div>
                                    <br>
                                </fieldset>
                            </div>
                            <br>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <script>
        //fungsi date
        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end, label) { //untuk mendeteksi bila perubahan tidak dibulan yang sama ketika melakukan perubahan
            if(start.format('YYYY') !== end.format('YYYY') || start.format('MM') !== end.format('MM')){
                swal({
                    title:'Periode Bulan',
                    text: 'Bulan Periode Tanggal harus sama.',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker').data('daterangepicker').setEndDate(start.format('DD/MM/YYYY'));
                    $('#daterangepicker').select();
                });
            }else{
                $('#menuSR').focus(); //focus ke kolom berikutnya
            }
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        function isSR(evt){ //membatasi input untuk hanya boleh S dan R, serta mendeteksi bila menekan tombol enter
            $('#menuSR').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 115) // s kecil
                return 83; // s besar

            if (charCode == 114) // r kecil
                return 82; //r besar

            if (charCode == 83 || charCode == 82)
                return true

            return false;
        }

        function cetak(){
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal('Periode tidak boleh kosong','','warning'); //ga bisa kosong pun, hahahahaha
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            if($('#menuSR').val() == ''){
                swal({
                    title:'Kesalahan data',
                    text: 'Type Transaksi [S -Sales / R -Refund]',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $("#menuSR").focus();
                });
                return false;
            }

            //cetak_rkp_struk
            window.open(`{{ url()->current() }}/printstruk?date1=${dateA}&date2=${dateB}&type=${$('#menuSR').val()}`, '_blank');
            //cetak_waktu
            if($('#menuSR').val() == 'S'){
                window.open(`{{ url()->current() }}/printwaktu?date1=${dateA}&date2=${dateB}`, '_blank');
            }
        }
    </script>
@endsection
