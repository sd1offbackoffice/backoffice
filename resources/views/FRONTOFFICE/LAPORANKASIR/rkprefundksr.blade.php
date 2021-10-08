@extends('navbar')
@section('title','Laporan Rekap Refund Kasir')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Laporan Rekap Refund Kasir</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-4 text-right col-form-label">Tanggal :</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker">
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success col-sm-3" type="button" onclick="cetak()">CETAK</button>
                        </div>
                        <br>
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
        });

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

            //cetak_trn_vcr
            window.open(`{{ url()->current() }}/print?date1=${dateA}&date2=${dateB}`, '_blank');

        }
    </script>
@endsection
