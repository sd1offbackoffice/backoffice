@extends('navbar')
@section('title','PROSES | COPY AVERAGE COST')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">COPY AVERAGE COST</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <label class="col-sm-1 text-left col-form-label">Periode</label>
                            <input type="text" class="col-sm-1 form-control text-center" id="periode" value="{{ $data->periode }}" disabled>
                            <div class="col-sm"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="col-sm-2  btn btn-primary" onclick="copyData()">COPY DATA</button>
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
        copyAcost = '{{ $data->copyacost }}';

        $(document).ready(function(){

        });

        function copyData(){
            if(copyAcost == 'Y'){
                swal({
                    title: 'Copy Average Cost untuk Month End sudah dilakukan!',
                    icon: 'error'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin copy data untuk periode '+$('#periode').val()+' ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function(ok){
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/copy-data',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {

                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                    location.reload();
                                });
                            },
                            error: function (error) {
                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error',
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                });
                            }
                        });
                    }
                });
            }
        }
    </script>

@endsection
