@extends('navbar')
@section('title','PB | REORDER PB GO')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">PB GO</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <div class="col-sm-3"></div>
                                    <button id="btn-reorder" class="btn btn-info col-sm-6">Proses Re-order PB GO</button>
                                    <div class="col-sm-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-tolakan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov text-center">
                                <h3>Terdapat barang yang ditolak</h3>
                                <br>
                                <div class="col-sm">
                                    <a id="btn-order" href="" target="_blank">
                                        <button class="btn col-sm btn-success">Tolakan P.B. yang dibawah minimum order</button>
                                    </a>
                                </div>
                                <br>
                                <div class="col-sm">
                                    <a id="btn-rupiah" href="" target="_blank">
                                        <button class="btn col-sm btn-success">Tolakan P.B. yang dibawah minimum rupiah / carton</button>
                                    </a>
                                </div>
                                <br>
                                <div class="col-sm">
                                    <button class="btn btn-info col-sm-4" onclick="$('#modal-tolakan').modal('hide')">Tutup</button>
                                </div>
                            </div>
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

        .row_divisi:hover{
            cursor: pointer;
            background-color: grey;
        }


    </style>

    <script>
        var initial = true;
        var totalData = 0;
        var totalProcessed = 0;

        $('#btn-reorder').on('click',function(){
            swal({
                icon: 'warning',
                title: 'Proses akan dilakukan?',
                buttons: true,
                dangerMode: true
            }).then(function(ok){
                if (ok) {
                    $('#btn-reorder').html(' Processing ').append('<i class="fas fa-spin fa-spinner"></i>').prop('disabled',true);
                    processGO('',false);
                }
                else {
                    console.log(ok);
                }
            });
        });

        function processGO(nopb, final){
            $.ajax({
                url: '{{ url()->current().'/proses_go' }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    nopb : nopb,
                    final : final
                },
                beforeSend: function () {
                    // $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    // $('#modal-loader').modal('toggle');

                    totalProcessed += 100;

                    // console.clear();
                    // console.log(totalProcessed+' of '+totalData);


                    if(totalData > 0){
                        $('#btn-reorder').html(convertToRupiah2(totalProcessed/totalData * 100)+'% ').append('<i class="fas fa-spin fa-spinner"></i>');
                    }

                    if(initial){
                        totalData = response.count;
                        initial = false;
                        noPB = response.nopb;
                        $('#btn-reorder').html(convertToRupiah2(totalProcessed/totalData * 100)+'% ').append('<i class="fas fa-spin fa-spinner"></i>').prop('disabled',true);
                        processGO(noPB,false);
                    }
                    else if(totalProcessed <= totalData){
                        if(totalProcessed == totalData)
                            processGO(noPB,true);
                        else processGO(noPB,false);
                    }
                    else{
                        swal({
                            icon: response.status,
                            title: response.title,
                            text: response.message
                        }).then(function(){
                            if(response.tolak2 || response.tolak3) {
                                if(response.tolak2) {
                                    $('#btn-order').show();
                                    $('#btn-order').attr('href','cetak_tolakan?recid=2&nopb='+response.NOPB);
                                }
                                else $('#btn-order').hide();

                                if(response.tolak3){
                                    $('#btn-rupiah').show();
                                    $('#btn-rupiah').attr('href','cetak_tolakan?recid=3&nopb='+response.NOPB);
                                }
                                else $('#btn-rupiah').hide();

                                swal({
                                    icon: 'warning',
                                    title: 'Terdapat barang tolakan!',
                                }).then(function(){
                                    $('#modal-tolakan').modal('show');
                                });
                            }
                        });
                    }
                }
            });
        }
    </script>

@endsection
