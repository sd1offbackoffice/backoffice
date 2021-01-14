@extends('navbar')

@section('title','TRANSFER | PB KE MD')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3"></legend>

                        <div class="card-body">
                            <div class="row form-group">
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">Periode PB :</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control tanggal" id="tanggal1" onchange="check()">
                                </div>
                                <label class="pt-1">s/d</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control tanggal" id="tanggal2" onchange="check()">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 mr-3">
                            <div class="row">
                                <div class="col"></div>
                                <button class="col-sm-4 btn btn-success mr-2" onclick="transfer()">PROSES TRANSFER DATA PB</button>
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
        label {
            color: #232443;
            font-weight: bold;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

    </style>

    <script>
        var listNomor = [];
        var selected = [];
        var dataNodoc = [];
        var dataVNew = [];

        $(document).ready(function(){
            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            $('.tanggal').datepicker('setDate', new Date());
        });

        function check(){
            if(checkDate($('#tanggal1').val()) && checkDate($('#tanggal2').val())){
                if(!($('#tanggal1').datepicker('getDate') <= $('#tanggal2').datepicker('getDate'))){
                    swal({
                        title: 'Inputan tanggal tidak sesuai!',
                        icon: 'error'
                    });
                    return false;
                }
                return true;
            }
        }

        function transfer(){
            if(check()){
                swal({
                    title: 'Yakin ingin melakukan proses transfer?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/proses-transfer',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                tgl1: $('#tanggal1').val(),
                                tgl2: $('#tanggal2').val()
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: response.title,
                                    text: response.message,
                                    icon: response.status,
                                });
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: error.responseJSON.message,
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            }
        }


    </script>

@endsection
