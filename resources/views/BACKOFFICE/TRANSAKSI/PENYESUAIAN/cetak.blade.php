@extends('navbar')

@section('title','Cetak Penyesuaian')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">Cetak Penyesuaian</legend>
                    <fieldset class="card border-secondary m-4">
                        <div class="card-body">
                            <div class="row form-group">
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal :</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control tanggal" id="tanggal1" onchange="getData()">
                                </div>
                                <label class="pt-1">s/d</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control tanggal" id="tanggal2" onchange="getData()">
                                </div>
                                <div class="col-sm-3"></div>
                                <div class="col-sm">
                                    <button class="btn btn-success" onclick="cetak()">Cetak Penyesuaian</button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="" class="col-sm-2 text-right col-form-label">Jenis Laporan :</label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="jenis" onchange="getData()">
                                        <option value="1">LIST</option>
                                        <option value="0">NOTA</option>
                                    </select>
                                </div>
                                <div class="custom-control custom-checkbox col-sm-2 mt-2">
                                    <input type="checkbox" class="custom-control-input" id="cb_reprint" onchange="getData()">
                                    <label for="cb_reprint" class="custom-control-label">Re-Print</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary m-4">
                        <legend class="w-auto ml-3">Daftar Penyesuaian</legend>
                        <div class="card-body">
                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden" style="position: sticky">
                                <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                    <thead>
                                        <tr>
                                            <th width="50%">Nomor Penyesuaian</th>
                                            <th width="35%">Tanggal</th>
                                            <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row form-group mt-3 mb-0">
                                <div class="custom-control custom-checkbox col-sm-2 ml-3">
                                    <input type="checkbox" class="custom-control-input" id="cb_checkall" onchange="checkAll(event)">
                                    <label for="cb_checkall" class="custom-control-label">Check All</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
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
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov{
            position:absolute;
            right: 20px;
            top: 4px;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 430px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

    </style>

    <script>
        var listNomor = [];
        var selected = [];
        var updateLokasi;
        var updatePkmt;
        $(document).ready(function(){
            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            $('#tanggal1').val('01/04/2020');
        });

        function getData(){
            if(checkDate($('#tanggal1').val()) && checkDate($('#tanggal2').val())){
                if($('#cb_reprint').is(':checked')){
                    reprint = 1;
                }
                else reprint = 0;

                $.ajax({
                    url: '{{ url('/bo/transaksi/penyesuaian/cetak/get-data') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        reprint: reprint,
                        jenis: $('#jenis').val(),
                        tgl1: $('#tanggal1').val(),
                        tgl2: $('#tanggal2').val(),
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        $('#table_daftar tbody tr').remove();
                        listNomor = [];
                        for(i=0;i<response.length;i++){
                            listNomor.push(response[i].no);

                            tr = `<tr><td>${response[i].no}</td><td>${formatDate(response[i].tgl)}</td>` +
                                `<td>` +
                                    `<div class="custom-control custom-checkbox text-center">` +
                                        `<input type="checkbox" class="custom-control-input cb-no" id="cb_${i}" onchange="selectDaftar(event)">` +
                                        `<label for="cb_${i}" class="custom-control-label"></label>` +
                                    `</div>` +
                                `</td></tr>`;
                            $('#table_daftar tbody').append(tr);
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                    }
                });
            }
        }

        function selectDaftar(e){
            nomor = listNomor[$(e.target).attr('id').substr(-1)];
            if($(e.target).is(':checked')){
                selected.push(nomor);
            }
            else{
                selected = $.grep(selected, function(value) {
                    return value != nomor;
                });
            }
        }

        function checkAll(e){
            if($(e.target).is(':checked')){
                $('.cb-no').prop('checked',true);
                selected = listNomor;
            }
            else{
                $('.cb-no').prop('checked',false);
                selected = [];
            }
        }

        function cetak(){
            if(selected.length == 0){
                swal({
                    title: 'Tidak ada data yang dipilih!',
                    icon: 'error'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin mencetak laporan?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    swal({
                        title: 'Update master lokasi dengan PLU baru?',
                        icon: 'warning',
                        buttons: {
                            cancel: 'Cancel',
                            no: {
                                text: 'Tidak',
                                value: 'no'
                            },
                            yes: {
                                text: 'Ya',
                                value: 'yes'
                            },
                        },
                        dangerMode: true
                    }).then((ok) => {
                        if(ok){
                            if(ok == 'yes')
                                updateLokasi = true;
                            else updateLokasi = false;

                            swal({
                                title: 'Update tabel PKMT dengan PLU baru?',
                                icon: 'warning', buttons: {
                                    cancel: 'Cancel',
                                    no: {
                                        text: 'Tidak',
                                        value: 'no'
                                    },
                                    yes: {
                                        text: 'Ya',
                                        value: 'yes'
                                    },
                                },
                                dangerMode: true
                            }).then((ok) => {
                                if(ok){
                                    if(ok == 'yes')
                                        updatePkmt = true;
                                    else updatePkmt = false;

                                    swal({
                                        title: 'Pilih ukuran laporan',
                                        icon: 'warning',
                                        buttons: {
                                            cancel: 'Cancel',
                                            catch: {
                                                text: 'Kecil',
                                                value: 'kecil'
                                            },
                                            defeat: {
                                                text: 'Besar',
                                                value: 'besar'
                                            },
                                        },
                                        dangerMode: true
                                    }).then((ok) => {
                                        console.log(ok);
                                        if(ok){
                                            ukuran = ok;

                                            $.ajax({
                                                url: '{{ url('/bo/transaksi/penyesuaian/cetak/store-data') }}',
                                                type: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                data: {
                                                    nodoc: selected,
                                                    reprint: reprint,
                                                    jenis: $('#jenis').val(),
                                                    ukuran: ukuran,
                                                    updateLokasi: updateLokasi,
                                                    updatePkmt: updatePkmt
                                                },
                                                beforeSend: function () {
                                                    $('#modal-loader').modal('show');
                                                },
                                                success: function (response) {
                                                    $('#modal-loader').modal('hide');

                                                    if(response == 'true'){
                                                        window.open('{{ url('/bo/transaksi/penyesuaian/cetak/laporan') }}','_blank');
                                                    }
                                                    else{
                                                        swal({
                                                            title: 'Terjadi kesalahan!',
                                                            text: 'Mohon coba kembali',
                                                            icon: 'error',
                                                        })
                                                    }
                                                },
                                                error: function (error) {
                                                    $('#modal-loader').modal('hide');
                                                    swal({
                                                        title: 'Terjadi kesalahan!',
                                                        text: error.responseJSON.message,
                                                        icon: 'error',
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                            })
                        }
                    });
                });
            }
        }


    </script>

@endsection
