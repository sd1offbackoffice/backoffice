@extends('navbar')
@section('title','LAPORAN KASIR | LAPORAN TRANSAKSI BKP/BTKP')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-secondary">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-center" id="tanggal" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm"></div>
                                    <div class="col-sm-3">
                                        <button class="col btn btn-primary" id="btn-print" onclick="print()">CETAK LAPORAN</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {

        });

        $('#tanggal').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        function print(){
            swal({
                title: 'Yakin ingin mencetak laporan?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    tanggal = $('#tanggal').val().split(' - ');

                    tgl1 = tanggal[0];
                    tgl2 = tanggal[1];

                    window.open(`{{ url()->current() }}/print?tgl1=${tgl1}&tgl2=${tgl2}`,'_blank');
                }
            });
        }
    </script>

@endsection
