@extends('navbar')
@section('title','LAPORAN PLANOGRAM')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row justify-content-center">
                            <label class="col-sm-3 col-form-label text-sm-right">LAPORAN :</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="type">
                                    <option value="1">QTY MINUS</option>
                                    <option value="2">SPB MANUAL</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-primary">PILIH</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <script src={{asset('/js/sweetalert2.js')}}></script>
    <script>
        $(document).ready(function () {
        });

        function cetak() {
            window.open(`{{ url()->current() }}/cetak?tipe=${$('#tipe').val()}`, '_blank');
        }
    </script>
@endsection
