@extends('navbar')
@section('title','MASTER | MASTER APPROVAL')
@section('content')


    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row justify-content-md-center">
                            <label for="i_storemanager" class="col-sm-3 col-form-label text-right">Store Manager</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control" id="i_storemanager" value="@if(!is_null($result)){{$result->rap_store_manager}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_storeadm" class="col-sm-3 col-form-label text-right">Store Adm</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control" id="i_storeadm" value="@if(!is_null($result)){{$result->rap_store_adm}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_logisticsupervisor" class="col-sm-3 col-form-label text-right">Logistic Supervisor</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control" id="i_logisticsupervisor" value="@if(!is_null($result)){{$result->rap_logistic_supervisor}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_stockkeeper" class="col-sm-3 col-form-label text-right">Stockkeeper II</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control" id="i_stockkeeper" value="@if(!is_null($result)){{$result->rap_stockkeeper_ii}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_administrasi" class="col-sm-3 col-form-label text-right">Administrasi</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control" id="i_administrasi" value="@if(!is_null($result)){{$result->rap_administrasi}}@endif">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_kepalagudang" class="col-sm-3 col-form-label text-right">Kepala Gudang</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control" id="i_kepalagudang" value="@if(!is_null($result)){{$result->rap_kepalagudang}}@endif">
                        </div>
                        <br>
                        <div class="row text-right justify-content-md-center">
                            <div class="col-sm-6"></div>
                            <button class="btn btn-primary col-sm-2" id="btn-save" onclick="saveData()">SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function saveData() {
            var storemanager = $('#i_storemanager').val().toUpperCase();
            var storeadm = $('#i_storeadm').val().toUpperCase();
            var logisticsupervisor = $('#i_logisticsupervisor').val().toUpperCase();
            var stockkeeper = $('#i_stockkeeper').val().toUpperCase();
            var administrasi = $('#i_administrasi').val().toUpperCase();
            var kepalagudang = $('#i_kepalagudang').val().toUpperCase();

            $.ajax({
                url: '/BackOffice/public/api/mstapproval/saveData',
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
                }, error: function (err) {
                    console.log(err.responseJSON.message.substr(0,150));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }
    </script>

@endsection

