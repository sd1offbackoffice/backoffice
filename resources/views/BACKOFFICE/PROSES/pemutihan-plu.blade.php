@extends('navbar')
@section('title','PROSES | PEMUTIHAN PLU')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <form class="form">
                                    <div class="form-group row mb-3 mt-4 justify-content-center">
                                        <div class="row-sm-12">
                                            <button type="button" class="btn btn-primary"
                                                    id="btn-proses">PROSES FILE
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3 mt-4 justify-content-center">
                                        <div class="row-sm-12">
                                            <button type="button" class="btn btn-success"
                                                    id="btn-print">RE/PRINT TRF FILE
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3 mt-4 justify-content-center">
                                        <div class="row-sm-6">
                                            <button type="button" class="btn btn-primary"
                                                    id="btn-pemutih-plu">PROSES PEMUTIHAN PLU
                                            </button>
                                        </div>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <div class="row-sm-6">
                                            <button type="button" class="btn btn-primary"
                                                    id="btn-pemutih-barcode">PROSES PEMUTIHAN BARCODE
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


<script>
    let lastProses = '';
    $(document).ready(function () {
        $.ajax({
            url: '{{ url()->current() }}/startup',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            },
            success: function (result) {
                $('#modal-loader').modal('hide');
                lastProses = result.substr(0,10);
                // lastProses = new Date(lastProses);
                // console.log(lastProses);
            }, error: function () {
                swal({
                    title: "Gagal retrieve tanggal proses terbaru",
                    icon: 'error'
                }).then(function(){
                    location.replace("{{ url()->to('/') }}");
                });
            }
        })
    });

    $('#btn-proses').on('click', function () {
        let system_date = moment().format('YYYY-MM-DD');
        if(lastProses == system_date){
            swal({
                title: "Alert",
                text: "Proses Ulang",
                icon: "info",
                buttons: true
            }).then((confirm) => {
                if (confirm) {
                    processData("samedate");
                }
            });
        }else{
            processData('');
        }
    });

    $('#btn-print').on('click', function () {
        //--cetak IGR ada , MD gak ada
        // cetak_lap1('0','N'); -->Stock 0 & tidak ada mutasi
        window.open(`{{ url()->current() }}/print-lap1?lastproses=${lastProses}&qty=0&mutasi=N`, '_blank');
        // cetak_lap1('0','Y'); -->Stock 0 & ada mutasi
        window.open(`{{ url()->current() }}/print-lap1?lastproses=${lastProses}&qty=0&mutasi=Y`, '_blank');
        // cetak_lap1('1','Y'); -->Stock >0
        window.open(`{{ url()->current() }}/print-lap1?lastproses=${lastProses}&qty=1&mutasi=Y`, '_blank');

        // --cetak IGR gak ada , MD ada
        // cetak_lap2;
        window.open(`{{ url()->current() }}/print-lap2?lastproses=${lastProses}`, '_blank');

        // --cetak_perubahan data plu
        // cetak_lap3( n_req_id);
        window.open(`{{ url()->current() }}/print-lap3?lastproses=${lastProses}`, '_blank');

        // --cetak barcode IGR ada, MD gak ada
        // cetak_lap4( n_req_id);
        window.open(`{{ url()->current() }}/print-lap4?lastproses=${lastProses}`, '_blank');

        // --cetak barcode IGR gak ada, MD ada
        // cetak_lap5( n_req_id);
        window.open(`{{ url()->current() }}/print-lap5?lastproses=${lastProses}`, '_blank');


        // --cetak compare barcode ALL
        // cetak_lap6('1');
        window.open(`{{ url()->current() }}/print-lap6?lastproses=${lastProses}&flag=1`, '_blank');

        // --cetak compare barcode BEDA
        // cetak_lap6('2');
        window.open(`{{ url()->current() }}/print-lap6?lastproses=${lastProses}&flag=2`, '_blank');


    });

    $('#btn-pemutih-plu').on('click', function () {
        swal({
            title: "Proses Pemutihan",
            text: "Proses Pemutihan PLU",
            icon: "info",
            buttons: true,
            dangerMode: true
        }).then((confirm) => {
            if (confirm) {
                $.ajax({
                    url: '{{ url()->current() }}/pemutihan-plu',
                    type: 'post',
                    data: {
                        'lastproses': lastProses
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});

                    },
                    success: function (result) {
                        $('#modal-loader').modal('hide');
                        if(result.status == "nodata"){
                            swal({
                                title: result.message,
                                icon: 'info'
                            })
                        }else{
                            swal({
                                title: result.message,
                                icon: 'info'
                            })
                        }
                        lastProses = moment().format('YYYY-MM-DD');
                    }, error: function (e) {
                        swal({
                            title: e.message,
                            icon: 'error'
                        })
                    }
                })
            }
        });
    });
    $('#btn-pemutih-barcode').on('click', function () {
        swal({
            title: "Proses Pemutihan",
            text: "Proses Pemutihan PLU",
            icon: "info",
            buttons: true,
            dangerMode: true
        }).then((confirm) => {
            if (confirm) {
                $.ajax({
                    url: '{{ url()->current() }}/pemutihan-barcode',
                    type: 'post',
                    data: {
                        'lastproses': lastProses
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});

                    },
                    success: function (result) {
                        $('#modal-loader').modal('hide');
                        if(result.status == "nodata"){
                            swal({
                                title: result.message,
                                icon: 'info'
                            })
                        }else{
                            swal({
                                title: result.message,
                                icon: 'info'
                            })
                        }
                        lastProses = moment().format('YYYY-MM-DD');
                    }, error: function (e) {
                        swal({
                            title: e.message,
                            icon: 'error'
                        })
                    }
                })
            }
        });
    });

    function processData(status){
        $.ajax({
            url: '{{ url()->current() }}/proses',
            type: 'post',
            data: {
                lastproses: lastProses,
                status: status,
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
            },
            success: function (result) {
                $('#modal-loader').modal('hide');
                if(result.status == "berhasil"){
                    swal({
                        title: result.message,
                        icon: 'info'
                    })
                }else{
                    swal({
                        title: result.message,
                        icon: 'error'
                    })
                }
                lastProses = moment().format('YYYY-MM-DD');
            }, error: function (e) {
                swal({
                    title: e.message,
                    icon: 'error'
                })
            }
        })

    }
</script>


@endsection
