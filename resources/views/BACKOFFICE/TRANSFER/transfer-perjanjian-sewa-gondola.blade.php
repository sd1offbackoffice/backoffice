@extends('navbar')
@section('title','TRANSFER | TRANSFER PERJANJIAN SEWA GONDOLA')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">Transfer Perjanjian Sewa Gondola</legend>
                    <div class="card-body pt-0">
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pl-0">PATH FILE GDL</label>
                            <div class="col-sm-7 pr-0">
                                <input type="text" class="form-control text-left" id="fileDBFInfo" disabled>
                            </div>
                            <input type="file" class="d-none" id="fileDBF">
                            <button id="btn_file" class="col-sm btn btn-secondary ml-0 mr-2" onclick="choosefileDBF()">...</button>
                            <button id="btn_transfer" class="col-sm-2 btn btn-primary" onclick="transferfileDBF()">TRANSFER</button>
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
            /*overflow-y: hidden;*/
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang{
            position:absolute;
            bottom: 10px;
            right: 3vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .btn-lov-plu{
            position:absolute;
            bottom: 10px;
            right: 2vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .modal thead tr th{
            vertical-align: middle;
        }

        .selected{
            background-color: lightgrey !important;
        }
    </style>

    <script>
        var Upload = function (file) {
            this.file = file;
        };

        Upload.prototype.getType = function() {
            return this.file.type;
        };
        Upload.prototype.getSize = function() {
            return this.file.size;
        };
        Upload.prototype.getName = function() {
            return this.file.name;
        };

        function choosefileDBF(){
            $('#fileDBF').click();
        }

        $('#fileDBF').on('change',function(e){
            if($('#fileDBF').val()){
                var filename = e.target.files[0].name;
                var directory = $(this).val();

                var file = $(this)[0].files[0];

                $('#fileDBFInfo').val(filename);

                fileDBF = new Upload(file);
            }
        });

        function transferfileDBF(){
            swal({
                title: 'Transfer file ' + fileDBF.getName() + ' ?',
                text: 'Proses mungkin membutuhkan waktu beberapa saat',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(result){
                if(result){
                    var formData = new FormData();

                    // add assoc key values, this will be posts values
                    formData.append("fileDBF", fileDBF.file, fileDBF.getName());
                    // formData.append("kodespi", $('#kodespi').val());

                    $.ajax({
                        type: "POST",
                        url: "{{ url()->current() }}/transfer-file-dbf",
                        timeout: 0,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            swal({
                                title: response.message,
                                icon: 'success'
                            }).then(function(ok){
                                $('#modal-loader').modal('hide');
                                $('#fileDBFInfo').val('');

                                window.open(`{{ url()->current() }}/print`,'_blank');
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {
                                $('#modal-loader').modal('hide');
                                $('#fileDBFInfo').val('');
                            });
                        },
                        async: true,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    });
                }
            });
        }
    </script>

@endsection
