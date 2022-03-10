@extends('navbar')
@section('title','TRANSFER | Lokasi')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3"></legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pl-0">DIREKTORI FILE RAK</label>
                            <div class="col-sm-7 pr-0">
                                <input type="text" class="form-control text-left" id="fileDBFInfo" disabled>
                            </div>
                            <input type="file" class="d-none" id="fileDBF">
                            <button id="btn_file" class="col-sm btn btn-secondary ml-0 mr-2" onclick="choosefile()">...</button>
                            <button id="btn_transfer" class="col-sm-2 btn btn-primary" onclick="prosesTransfer()">TRANSFER LOKASI</button>
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
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover {
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

    </style>

    <script>
        var Upload = function (file) {
            this.file = file;
        };
        Upload.prototype.getType = function () {
            return this.file.type;
        };
        Upload.prototype.getSize = function () {
            return this.file.size;
        };
        Upload.prototype.getName = function () {
            return this.file.name;
        };

        function choosefile() {
            $('#fileDBF').click();
        }

        $('#fileDBF').on('change', function (e) {
            if ($('#fileDBF').val()) {
                var filename = e.target.files[0].name;
                var directory = $(this).val();

                var file = $(this)[0].files[0];

                $('#fileDBFInfo').val(filename);

                fileDBF = new Upload(file);
            }
        });

        function prosesTransfer() {
            swal({
                title: 'Transfer file ' + fileDBF.getName() + ' ?',
                text: 'Proses mungkin membutuhkan waktu beberapa saat',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function (result) {
                if (result) {
                    var formData = new FormData();

                    // add assoc key values, this will be posts values
                    formData.append("fileDBF", fileDBF.file, fileDBF.getName());
                    // formData.append("kodespi", $('#kodespi').val());

                    $.ajax({
                        type: "POST",
                        url: "{{ url()->current() }}/proses-transfer",
                        timeout: 0,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            if(response.status == 'error') {
                                swal({
                                    title: response.message,
                                    icon: response.status
                                }).then(function (ok) {
                                    $('#modal-loader').modal('hide');
                                    $('#fileDBFInfo').val('');
                                });
                            }
                            else if(response.status == 'success'){
                                window.open(`{{ url()->current() }}/download-wplu-file`, '_blank');
                                swal({
                                    title: response.message,
                                    icon: response.status
                                }).then(function (ok) {
                                    $('#modal-loader').modal('hide');
                                    $('#fileDBFInfo').val('');
                                });
                            }
                            else{
                                window.open(`{{ url()->current() }}/cetak`, '_blank');
                            }
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
