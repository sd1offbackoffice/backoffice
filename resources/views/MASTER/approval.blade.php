@extends('navbar')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-sm-10">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Approval</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row justify-content-md-center">
                            <label for="i_storemanager" class="col-sm-3 col-form-label text-right">Store Manager</label>
                            <input type="text" class="col-sm-5 form-control" id="i_storemanager" value="@if(!is_null($result)){{$result->rap_store_manager}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_storeadm" class="col-sm-3 col-form-label text-right">Store Adm</label>
                            <input type="text" class="col-sm-5 form-control" id="i_storeadm" value="@if(!is_null($result)){{$result->rap_store_adm}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_logisticsupervisor" class="col-sm-3 col-form-label text-right">Logistic Supervisor</label>
                            <input type="text" class="col-sm-5 form-control" id="i_logisticsupervisor" value="@if(!is_null($result)){{$result->rap_logistic_supervisor}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_stockkeeper" class="col-sm-3 col-form-label text-right">Stockkeeper II</label>
                            <input type="text" class="col-sm-5 form-control" id="i_stockkeeper" value="@if(!is_null($result)){{$result->rap_stockkeeper_ii}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_administrasi" class="col-sm-3 col-form-label text-right">Administrasi</label>
                            <input type="text" class="col-sm-5 form-control" id="i_administrasi" value="@if(!is_null($result)){{$result->rap_administrasi}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_kepalagudang" class="col-sm-3 col-form-label text-right">Kepala Gudang</label>
                            <input type="text" class="col-sm-5 form-control" id="i_kepalagudang" value="@if(!is_null($result)){{$result->rap_kepalagudang}}@endif">
                        </div>
                        <br>
                        <div class="row text-right justify-content-md-center">
                            <div class="col-sm-7"></div>
                            <button class="btn btn-primary col-sm-1" id="btn-save" onclick="saveData()">SAVE</button>
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
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

    </style>

    <script>
        function saveData() {
            var storemanager = $('#i_storemanager').val();
            var storeadm = $('#i_storeadm').val();
            var logisticsupervisor = $('#i_logisticsupervisor').val();
            var stockkeeper = $('#i_stockkeeper').val();
            var administrasi = $('#i_administrasi').val();
            var kepalagudang = $('#i_kepalagudang').val();

            $.ajax({
                url: '/BackOffice/public/mstapproval/saveData',
                type:'POST',
                data:{"_token":"{{ csrf_token() }}", storemanager:storemanager, storeadm:storeadm, logisticsupervisor:logisticsupervisor, stockkeeper:stockkeeper, administrasi:administrasi, kepalagudang:kepalagudang},
                success: function(response){
                    console.log(response);
                    if (response=='save'){
                        swal({
                            title: "Data Berhasil Tersimpan!",
                            icon: "success"
                        });
                    }
                    else if (response=='update'){
                        swal({
                            title: "Data Berhasil Terupdate!",
                            icon: "success"
                        });
                    }
                    else {
                        swal({
                            title: "Data Gagal Tersimpan!",
                            icon: "warning"
                        });
                    }
                }
            });
        }
    </script>

@endsection

