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

                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <script>
        function DownBaru() {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/frontoffice/promosihokecab/downbaru',
                type: 'post',
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    swal('', result, 'info');
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }
        function DownEdit() {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/frontoffice/promosihokecab/downedit',
                type: 'post',
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    swal('', result, 'info');
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

    </script>
@endsection
