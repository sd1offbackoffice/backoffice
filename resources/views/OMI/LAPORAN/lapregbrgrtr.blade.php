@extends('navbar')
@section('title','LAPORAN REGISTER BARANG RETUR')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">LAPORAN REGISTER BARANG RETUR</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Tanggal</label>
                            <input class="col-sm-8 text-center form-control" type="text" id="daterangepicker">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">No. dokumen</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="noDoc1">
                            <label class="col-sm-2 col-form-label text-center">s/d</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="noDoc2">
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success col-sm-3" type="button" onclick="cetak()">CETAK LAPORAN</button>
                        </div>
                        <br>
                    </div>
                </fieldset>

    <script>
        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        function cetak(){
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal({
                    title:'Alert',
                    text: 'Tanggal Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker').focus();
                });
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            if(($('#noDoc1').val() == '' && $('#noDoc2').val() != '') || ($('#noDoc2').val() == '' && $('#noDoc1').val() != '')){
                swal({
                    title:'Alert',
                    text: 'Nomor Dokumen Harus Terisi Semua Atau Tidak Terisi Sama Sekali ',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#noDoc1').focus();
                });
                return false;
            }
            if($('#noDoc1').val() > $('#noDoc2').val()){
                swal({
                    title:'Alert',
                    text: 'No. Dokumen 1 Harus Lebih Kecil dari No. Dokumen 2',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#noDoc1').focus();
                });
                return false;
            }
            window.open(`{{ url()->current() }}/cetak?date1=${dateA}&date2=${dateB}&nodoc1=${$('#noDoc1').val()}&nodoc2=${$('#noDoc2').val()}`, '_blank');
            clear();
        }

        function clear(){
            $('#noDoc1').val('');
            $('#noDoc2').val('');

            $('#daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
        }
    </script>
@endsection
