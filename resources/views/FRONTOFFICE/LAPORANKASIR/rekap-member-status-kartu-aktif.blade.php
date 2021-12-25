@extends('navbar')
@section('title','LAPORAN KASIR | REKAP MEMBER STATUS KARTU AKTIF')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Rekap Member Status Kartu Aktif</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Sampai dengan periode :</label>
                            <input type="text" class="col-sm-7 form-control text-center datepicker" id="tanggal" placeholder="DD/MM/YYYY" readonly>
                            <div class="col-sm-2">
                                <button class="btn btn-primary" onclick="cetak()">Cetak</button>
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
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang{
            position:absolute;
            bottom: 10px;
            right: 3vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .btn-lov-plu{
            position:absolute;
            bottom: 10px;
            right: 2vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .modal thead tr th{
            vertical-align: middle;
        }
    </style>

    <script>


        $(document).ready(function(){
            $(".datepicker").datepicker( {
                dateFormat: 'dd/mm/yy',
            });
            $('#tanggal').datepicker('setDate', new Date());
        });

        function cetak(){
            periode = $("#tanggal").val()

                window.open(`{{ url()->current() }}/cetak?periode=${periode}`,'_blank');
        }
    </script>

@endsection
