@extends('navbar')
@section('title','TRANSFER | TRASNFER PLU')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-4">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row mb-5">
                            <div class="col-sm-12 text-center">
                                <button type="button" id="btn-download-dta" class="btn btn-primary btn-block">DOWNLOAD
                                    DTA
                                </button>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-sm-12 text-center">
                                <button type="button" id="btn-transfer-dta4" class="btn btn-primary btn-block">TRANSFER
                                    DTA4
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="button" id="btn-transfer-plu-commit-order" class="btn btn-primary btn-block">TRANSFER
                                    PLU COMMIT ORDER
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <script>
        $('#btn-download-dta').on('click', function () {
            $.ajax({
                url: '{{ url()->current() }}/download-dta',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    swal({
                        title: response['message'],
                        icon: response['status']
                    }).then((createData) => {
                    });
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });
        });


        $('#btn-transfer-dta4').on('click', function () {
            $.ajax({
                url: '{{ url()->current() }}/transfer-dta4',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    console.log(response['ADADTA']);
                    if (response['status'] == 'info') {
                        swal({
                            text: response['message'],
                            icon: response['status'],
                            buttons: true,
                        }).then((ok) => {
                            if (ok) {
                                response['PROSES'] = true;
                            } else {
                                response['PROSES'] = false;
                            }
                            $.ajax({
                                url: '{{ url()->current() }}/req-proses-dta4',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: {
                                    proses: response['PROSES'],
                                    adadta: response['ADADTA'],
                                    n_req_id: response['N_REQ_ID']
                                },
                                beforeSend: function () {
                                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                },
                                success: function (response) {
                                    console.log(response);
                                    if(response['data']) {
                                        window.open(`{{ url()->current() }}/download-txt?txt=${response['data']}`, '_blank');
                                    }
                                    swal({
                                        title: response['message'],
                                        icon: response['status']
                                    }).then((createData) => {

                                    });
                                },
                                complete: function () {
                                    $('#modal-loader').modal('hide');
                                }
                            });
                        });
                    } else {
                        swal({
                            title: response['message'],
                            icon: response['status']
                        });
                    }
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });
        });

        $('#btn-transfer-plu-commit-order').on('click', function () {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/transfer-plu-commit-order',
                type: 'POST',
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    swal({
                        title: response['message'],
                        icon: response['status']
                    }).then((createData) => {
                    });
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });
        });
    </script>
@endsection

