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
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control"
                                   id="i_storemanager"
                                   value="">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_storeadm" class="col-sm-3 col-form-label text-right">Store Adm</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control"
                                   id="i_storeadm" value="">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_logisticsupervisor" class="col-sm-3 col-form-label text-right">Logistic
                                Supervisor</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control"
                                   id="i_logisticsupervisor"
                                   value="">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_stockkeeper" class="col-sm-3 col-form-label text-right">Stockkeeper II</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control"
                                   id="i_stockkeeper"
                                   value="">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_administrasi" class="col-sm-3 col-form-label text-right">Administrasi</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control"
                                   id="i_administrasi"
                                   value="">
                        </div>
                        <div class="row justify-content-md-center">
                            <label for="i_kepalagudang" class="col-sm-3 col-form-label text-right">@lang("Kepala Gudang")</label>
                            <input style="text-transform: uppercase;" type="text" class="col-sm-5 form-control"
                                   id="i_kepalagudang"
                                   value="">
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
        $('#i_storemanager').focus();

        function saveData() {
            var storemanager = $('#i_storemanager').val().toUpperCase();
            var storeadm = $('#i_storeadm').val().toUpperCase();
            var logisticsupervisor = $('#i_logisticsupervisor').val().toUpperCase();
            var stockkeeper = $('#i_stockkeeper').val().toUpperCase();
            var administrasi = $('#i_administrasi').val().toUpperCase();
            var kepalagudang = $('#i_kepalagudang').val().toUpperCase();
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/save-data',
                type: 'POST',
                data: {
                    storemanager: storemanager,
                    storeadm: storeadm,
                    logisticsupervisor: logisticsupervisor,
                    stockkeeper: stockkeeper,
                    administrasi: administrasi,
                    kepalagudang: kepalagudang
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response == 'save') {
                        swal({
                            title: "{{__('Data Berhasil Tersimpan!')}}",
                            icon: "success"
                        });
                    }
                    // else if (response == 'update') {
                    //     swal({
                    //         title: "Data Berhasil Terupdate!",
                    //         icon: "success"
                    //     });
                    // } else {
                    //     swal({
                    //         title: "Data Gagal Tersimpan!",
                    //         icon: "warning"
                    //     });
                    // }
                }, error: function (err) {
                    console.log(err.responseJSON.message.substr(0, 150));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        }

        $(window).bind('keydown', function (event) {
            if (event.ctrlKey || event.metaKey) {
                if (String.fromCharCode(event.which).toLowerCase() === 's') {
                    saveData();
                    event.preventDefault();
                }
            }
        });

        arrayElement = ["i_storemanager", "i_storeadm", "i_logisticsupervisor", "i_stockkeeper", "i_administrasi", "i_kepalagudang"];
        $('input').bind('keydown', function (event) {
            if (event.keyCode === 13) {
                var i = 0;
                for (i = 0; i < arrayElement.length; i++) {
                    if (arrayElement[i] == $(this)[0].id) {
                        if (i + 1 == arrayElement.length) {
                            $('#' + arrayElement[0]).focus();
                        } else {
                            $('#' + arrayElement[i + 1]).focus();
                        }
                    }
                }
            }
        });


    </script>

@endsection

