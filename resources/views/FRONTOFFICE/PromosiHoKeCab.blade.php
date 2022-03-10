@extends('navbar')
@section('title','PROMOSI HO KE CAB')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Proses Tarik Data Promosi HO</legend>
                    <div class="card-body shadow-lg cardForm">

                        <br>
                        <div class="col-sm-12">
                            <button class="btn btn-primary col-sm-12" type="button" onclick="DownBaru()">DOWNLOAD DATA BARU PROMOSI HO</button>
                        </div>
                        <br>
                        <div class="col-sm-12">
                            <button class="btn btn-primary col-sm-12" type="button" onclick="DownEdit()">DOWNLOAD DATA EDITAN PROMOSI HO</button>
                        </div>
                        <br><br>
                        <div class="col-sm-12">
                            <button class="btn btn-primary col-sm-12" type="button" onclick="Status()">CEK STATUS DOWNLOAD</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--STATUS DOWNLOAD--}}
    <div class="modal fade" id="statusDown" tabindex="-1" role="dialog" aria-labelledby="statusDown" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header" style="justify-content: center">
                    <h4 class="modal-title">Status Download</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div>
                                    <h5>DATA BARU</h5>
                                    <p>Waktu Mulai : <span id="newStart"></span></p>
                                    <p>Waktu Selesai : <span id="newEnd"></span></p>
                                    <p>Status : <span id="newStatus"></span></p>
                                    <p>Message : <span id="newMessage"></span></p>
                                </div>
                            </div>
                        </div>
                        <BR>
                        <div class="row">
                            <div class="col">
                                <div>
                                    <h5>DATA EDIT</h5>
                                    <p>Waktu Mulai : <span id="editStart"></span></p>
                                    <p>Waktu Selesai : <span id="editEnd"></span></p>
                                    <p>Status : <span id="editStatus"></span></p>
                                    <p>Message : <span id="editMessage"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <script>
        function DownBaru() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/downbaru',
                type: 'post',
                beforeSend: function () {
                    swal('Data akan di proses', "Silahkan periksa progress sesekali dengan menekan tombol paling bawah", 'info');
                    // $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    // $('#modal-loader').modal('hide');
                    if(result !== 'TRUE'){
                        swal('', result, 'info');
                    }


                }, error: function (e) {
                    // console.log(e);
                    // alert('error');
                }
            })
        }
        function DownEdit() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/downedit',
                type: 'post',
                beforeSend: function () {
                    swal('Data akan di proses', "Silahkan periksa progress sesekali dengan menekan tombol paling bawah", 'info');
                    // $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    // $('#modal-loader').modal('hide');
                    if(result !== 'TRUE'){
                        swal('', result, 'info');
                    }
                }, error: function (e) {
                    // console.log(e);
                    // alert('error');
                }
            })
        }

        function Status(){
            $.ajax({
                url: '{{ url()->current() }}/status',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    if(result.new){
                        $('#newStart').text(result.new.start_time);
                        $('#newEnd').text(result.new.end_time);
                        $('#newStatus').text(result.new.status);
                        $('#newMessage').text(result.new.message);
                    }else{
                        $('#newStart').text("");
                        $('#newEnd').text("");
                        $('#newStatus').text("");
                        $('#newMessage').text("");
                    }
                    if(result.edit){
                        $('#editStart').text(result.edit.start_time);
                        $('#editEnd').text(result.edit.end_time);
                        $('#editStatus').text(result.edit.status);
                        $('#editMessage').text(result.edit.message);
                    }else{
                        $('#editStart').text("");
                        $('#editEnd').text("");
                        $('#editStatus').text("");
                        $('#editMessage').text("");
                    }
                    $('#statusDown').modal('toggle');
                }, error: function (e) {
                    swal('ERROR', "Gagal retrieve Status", 'error');
                }
            })
        }

    </script>
@endsection
