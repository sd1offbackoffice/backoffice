@extends('navbar')
@section('title','LAPORAN KASIR | KK PER NAMA')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Laporan Transaksi Kartu Kredit Per Nama Kartu</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <label class="col-sm-1 text-right col-form-label pl-0">TANGGAL</label>
                            <input type="text" class="col-sm-4 form-control text-center" id="tanggal" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                            <div class="col-sm"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="col-sm-2 btn btn-primary" onclick="cetak()">CETAK LAPORAN</button>
                            <div class="col-sm"></div>
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
            $('#tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        });

        $('#tanggal').on('change',function(){
            // if(!checkDate(this.value)){
            //     swal({
            //         title: 'Tanggal tidak sesuai format',
            //         icon: 'warning'
            //     }).then(()=>{
            //         $(this).select();
            //     });
            // }
        });

        // function showModal(){
        //     if(!$('#tanggal').val() || !checkDate($('#tanggal').val())){
        //         swal({
        //             title: 'Tanggal tidak sesuai format',
        //             icon: 'warning'
        //         }).then(()=>{
        //             $(this).select();
        //         });
        //     }
        //     else $('#m_result').modal('show')
        // }

        function cetak(){
            tgl1 = $("#tanggal").data('daterangepicker').startDate.format('DD/MM/YYYY');
            tgl2 = $("#tanggal").data('daterangepicker').endDate.format('DD/MM/YYYY');

            window.open(`{{ url()->current() }}/cetak?tgl1=${tgl1}&tgl2=${tgl2}`, '_blank');
        }
    </script>

@endsection
