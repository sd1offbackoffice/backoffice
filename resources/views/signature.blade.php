@extends('navbar')
@section('title','Signature')
@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="row justify-content-center">
                            <button class="btn btn-primary row-sm-12 d-block" onclick="showModal()">Sign Here</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Your Signature </legend>
                    <div class="card-body cardForm">
                        <div class="row" id="img-data">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_signature" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign Here : </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div id="sig"></div>
                                <br/>
                                <button id="clear" class="btn btn-danger">Clear</button>
                                <button id="save" class="btn btn-success">Save</button>
                                <textarea id="signature64" name="signed" style="display: none"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <label for="">Save -> Enter</label>
                    <label for="">/</label>
                    <label for="">Clear -> Space</label>
                </div>
            </div>
        </div>
    </div>

    <style>
        .kbw-signature {
            width: 400px;
            height: 350px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
        }
    </style>
    <script>
        $(document).ready(function () {
            getAllData();
        })
        $(document).keypress(function (e) {
            if (e.keyCode == 32) {
                $('#clear').click();
            } else if (e.keyCode == 13) {
                $('#save').click();
            }
        });
        var sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
        $('#save').click(function (e) {
            var dataURL = $('#sig').signature('toDataURL', 'image/jpeg', 0.8);
            ajaxSetup();
            $.ajax({
                type: "POST",
                url: '{{ url()->current() }}/save',
                data: {
                    sign: dataURL,
                    signed: $('#signature64').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    swal({
                        title: response.message,
                        icon: 'success'
                    }).then(function (ok) {
                        $('#clear').click();
                        $('#modal-loader').modal('hide');
                        $('#m_signature').modal('hide');
                        getAllData();
                    });
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.message,
                        icon: 'error',
                    }).then(() => {
                        $('#modal-loader').modal('hide');
                    });
                },
            })
        });
        $('#clear').click(function (e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });

        function showModal(){
             $('#m_signature').modal({backdrop: 'static', keyboard: false});
        }

        function getAllData(){
            $.ajax({
                type: "GET",
                url: '{{ url()->current() }}/get',
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    console.log(response);
                    $('#modal-loader').modal('hide');
                    $('#img-data').empty();
                    for(i=0;i<response.data.length;i++){
                        $('#img-data').append(`<img class="col-sm-3" src="../storage/signature/`+response.data[i]+`">`);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.message,
                        icon: 'error',
                    }).then(() => {
                        $('#modal-loader').modal('hide');
                    });
                },
            })
        }
    </script>

@endsection
