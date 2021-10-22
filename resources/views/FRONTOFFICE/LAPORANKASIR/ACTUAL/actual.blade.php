@extends('navbar')
@section('title','LAPORAN KASIR | ACTUAL')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Laporan Sales Harian Kasir / Actual</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <label class="col-sm-2 text-right col-form-label">TANGGAL</label>
                            <input type="text" class="col-sm-2 form-control" id="tanggal" maxlength="10" placeholder="DD/MM/YYYY" autocomplete="off">
                            <label class="col-sm-2 pl-0 pr-0 text-center col-form-label">[DD/MM/YYYY]</label>
                            <div class="col-sm"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="col-sm-2 btn btn-primary" onclick="showModal()">CETAK LAPORAN</button>
                            <div class="col-sm"></div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_result" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" onclick="cetak('sales')">ACTUAL / SALES</button>
                            <button class="ml-1 col-sm btn btn-primary" onclick="cetak('isaku')">I-SAKU</button>
                        </div>
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" onclick="cetak('virtual')">VIRTUAL</button>
                            <button class="ml-1 col-sm btn btn-primary" onclick="cetak('cb-nk')">CB_NK</button>
                        </div>
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" onclick="cetak('transfer')">TUNAI TRANSFER</button>
                            <button class="ml-1 col-sm btn btn-primary" onclick="cetak('plastik')">PLASTIK</button>
                        </div>
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" onclick="cetak('merchant')">MERCHANT</button>
                            <button class="ml-1 col-sm btn btn-primary" onclick="cetak('kredit')">KREDIT</button>
                        </div>
                        <div class="row form-group">
                            <button class="mr-1 col-sm btn btn-primary" onclick="cetak('omi')">OMI</button>
                            <button class="ml-1 col-sm btn btn-primary" onclick="cetak('struk')">STRUK</button>
                        </div>
                    </div>
                </div>
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
            $('#tanggal').datepicker({
                "dateFormat" : "dd/mm/yy",
            });
        });

        $('#tanggal').on('change',function(){
            if(!checkDate(this.value)){
                swal({
                    title: 'Tanggal tidak sesuai format',
                    icon: 'warning'
                }).then(()=>{
                    $(this).select();
                });
            }
        });

        function showModal(){
            if(!$('#tanggal').val() || !checkDate($('#tanggal').val())){
                swal({
                    title: 'Tanggal tidak sesuai format',
                    icon: 'warning'
                }).then(()=>{
                    $(this).select();
                });
            }
            else $('#m_result').modal('show')
        }

        function cetak(url){
            window.open(`{{ url()->current() }}/cetak-${url}?tanggal=${$('#tanggal').val()}`, '_blank');
        }
    </script>

@endsection
