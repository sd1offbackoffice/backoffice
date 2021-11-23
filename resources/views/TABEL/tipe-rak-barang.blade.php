@extends('navbar')
@section('title','Tipe Rak Barang')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Tipe Rak Barang</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label text-right">Tipe Rak : </label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="tipeRak" maxlength="1">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label text-right">Nama Rak : </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="namaRak" maxlength="20">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <label class="col-sm-12 col-form-label text-left">Pg Up - Isian sebelumnya</label>
                                </div>
                                <div class="row">
                                    <label class="col-sm-12 col-form-label text-left">Pg Dn - Isian sesudahnya</label>
                                </div>
                            </div>
                            <div class="col-sm-8 ">
                                <br>
                                <div class="row d-flex justify-content-end">
                                    <button class="btn btn-primary col-sm-3" type="button" onclick="GantiTipe()">GANTI TIPE</button>
                                    <button class="btn btn-danger col-sm-3" type="button" onclick="Hapus()">HAPUS</button>
                                    <button class="btn btn-primary col-sm-3" type="button" onclick="Save()">SAVE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>



    <script>
        let cursor = 0;
        let kode = [];
        let nama = [];
        $(document).ready(function () {
            LoadData();
        });
        $(window).bind('keydown', function(event) {
            if(event.key == 'PageUp'){
                event.preventDefault();
                if(cursor !== 0){
                    cursor--;
                    $('#tipeRak').val(kode[cursor]);
                    $('#namaRak').val(nama[cursor]);
                }else {
                    swal({
                        title: 'Sudah pada data pertama !',
                        icon: 'warning'
                    });
                }
            }else if(event.key == 'PageDown'){
                event.preventDefault();
                if(cursor < (kode.length)-1){
                    cursor++;
                    $('#tipeRak').val(kode[cursor]);
                    $('#namaRak').val(nama[cursor]);
                }else {
                    swal({
                        title: 'Sudah pada data terakhir !',
                        icon: 'warning'
                    });
                }
            }
        });


        $('#tipeRak').on('change', function () {
            let tidakada = true;
            if($('#tipeRak').val() != ''){
                for(i=0;i<kode.length;i++){
                    if($('#tipeRak').val() === kode[i]){
                        cursor = i;
                        $('#namaRak').val(nama[i]);
                        tidakada = false;
                        break;
                    }
                }
            }
            if(tidakada){
                cursor = (kode.length);
                $('#namaRak').val('');
            }
        });

        function LoadData(){
            cursor = 0;
            kode = [];
            nama = [];
            $.ajax({
                url: '{{ url()->current() }}/load-data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    for(i=0;i<response.length;i++){
                        kode.push(response[i].trak_kodetiperak);
                        nama.push(response[i].trak_namatiperak);
                    }
                    if(kode.length !== 0){
                        $('#tipeRak').val(kode[0]);
                        $('#namaRak').val(nama[0]);
                    }
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }

        function GantiTipe(){
            cursor = (kode.length);
            $('#tipeRak').val('');
            $('#namaRak').val('');
        }

        function Hapus(){
            swal({
                title: 'DATA akan dihapus ?',
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                if (confirm){
                    let ada = false;
                    for(i=0;i<kode.length;i++){
                        if($('#tipeRak').val() === kode[i]){
                            ada = true;
                            break;
                        }
                    }
                    if(ada){
                        $.ajax({
                            url: '{{ url()->current() }}/hapus',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                kode:$('#tipeRak').val()
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function () {
                                LoadData();
                                swal({
                                    title: 'Dihapus!',
                                    icon: 'info'
                                });
                            },
                            complete: function () {
                                $('#modal-loader').modal('hide');
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: error.responseJSON.title,
                                    text: error.responseJSON.message,
                                    icon: 'error',
                                });
                                return false;
                            }
                        });
                    }else{
                        swal({
                            title: 'Tidak Ada Data Yg Dihapus',
                            icon: 'info'
                        });
                    }
                }
                //pakai 3 baris ini atau panggil fungsi GantiTipe, sama saja
                cursor = (kode.length);
                $('#tipeRak').val('');
                $('#namaRak').val('');
            });
        }
        function Save(){
            if($('#tipeRak').val() == ''){
                swal({
                    title: 'Kode Rak Harus Diisi',
                    icon: 'warning'
                });
                return false;
            }
            swal({
                title: 'DATA sudah benar ?',
                icon: 'warning',
                buttons: true,
            }).then(function (confirm) {
                if (confirm){
                    let status = 'insert';
                    for(i=0;i<kode.length;i++){
                        if($('#tipeRak').val() === kode[i]){
                            status = 'update';
                            break;
                        }
                    }
                    if($('#tipeRak').val().length > 1){
                        swal({
                            title: 'Tipe Rak tidak boleh lebih dari 1 character',
                            icon: 'warning'
                        });
                        return false;
                    }
                    if($('#namaRak').val().length > 20){
                        swal({
                            title: 'Nama Rak tidak boleh lebih dari 20 character',
                            icon: 'warning'
                        });
                        return false;
                    }
                    $.ajax({
                        url: '{{ url()->current() }}/save',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            kode:$('#tipeRak').val(),
                            nama:$('#namaRak').val(),
                            status:status
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            LoadData();
                            if(response.status == 'error'){
                                swal({
                                    title: response.message,
                                    icon: 'warning'
                                });
                            }else if(status == 'insert'){
                                swal({
                                    title: 'INSERT',
                                    icon: 'info'
                                });
                            }else{
                                swal({
                                    title: 'UPDATE',
                                    icon: 'info'
                                });
                            }
                        },
                        complete: function () {
                            $('#modal-loader').modal('hide');
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                            return false;
                        }
                    });
                }
                //pakai 3 baris ini atau panggil fungsi GantiTipe, sama saja
                cursor = (kode.length);
                $('#tipeRak').val('');
                $('#namaRak').val('');
            });
        }
    </script>
@endsection
