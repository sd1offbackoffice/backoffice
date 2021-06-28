@extends('navbar')

@section('title','PENGIRIMAN KE CABANG | BATAL SJ')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">Batal Surat Jalan</legend>
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
                                    <button class="btn btn-success" onclick="batal()">Pembatalan Surat Jalan</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary m-4">
                        <legend class="w-auto ml-3">Daftar Surat Jalan</legend>
                        <div class="card-body">
                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden tableFixedHeader" style="position: sticky">
                                <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                    <thead>
                                    <tr>
                                        <th width="50%">Nomor Surat Jalan</th>
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

        .row_lov:hover{
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
        var listNomor = [];
        var selected = [];
        var reprint;
        $(document).ready(function(){
            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            $('.tanggal').datepicker('setDate', new Date());
        });

        function isMonthEnd(){
            currDate = new Date();
            currYear = currDate.getFullYear();
            currMonth = currDate.getMonth() + 1;

            result = false;

            $('.tanggal').each(function(){
                month = $(this).datepicker('getDate').getMonth() + 1;
                year = $(this).datepicker('getDate').getFullYear();

                if(month != currMonth || year != currYear)
                    result = true;
            });
            return result;
        }

        function getData(){
            if(isMonthEnd()){
                swal({
                    title: 'Transaksi tidak bisa dibatalkan karena sudah Closing / Month End!',
                    icon: 'error'
                }).then(() => {
                    $('#table_daftar tbody tr').remove();
                    listNomor = [];
                    $('.tanggal').datepicker('setDate', new Date());
                });
            }
            else if(checkDate($('#tanggal1').val()) && checkDate($('#tanggal2').val())){
                if($('#cb_reprint').is(':checked')){
                    reprint = 1;
                }
                else reprint = 0;

                $.ajax({
                    url: '{{ url('/bo/transaksi/kirimcabang/batal/get-data') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
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

        function batal(){
            if(selected.length == 0){
                swal({
                    title: 'Tidak ada data yang dipilih!',
                    icon: 'error'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin membatalkan surat jalan?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    $.ajax({
                        url: '{{ url('/bo/transaksi/kirimcabang/batal/execute') }}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            nodoc: selected,
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.title,
                                text: response.message,
                                icon: response.status,
                            }).then(getData());
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
                });
            }
        }


    </script>

@endsection
