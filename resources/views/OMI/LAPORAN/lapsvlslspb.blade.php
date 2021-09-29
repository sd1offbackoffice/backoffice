@extends('navbar')
@section('title','LAPORAN REKAP SERVICE LEVEL SALES THD PB')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Laporan Rekap Service Level Sales Thd PB</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Periode PB</label>
                            <input class="col-sm-8 text-center form-control" type="text" id="daterangepicker">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Kode Cabang</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="cab1">
                            <label class="col-sm-2 col-form-label text-center">s/d</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="cab2">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">No. PB</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="pb1">
                                <button id="butt1" type="button" class="btn btn-lov p-0" onclick="toggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <label class="col-sm-2 col-form-label text-center">s/d</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="pb2">
                                <button id="butt2" type="button" class="btn btn-lov p-0" onclick="toggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Pilihan</label>
                            <input class="col-sm-2 text-center form-control" type="text" id="pilihan">
                            <label class="col-sm-2 col-form-label text-center">[D]etil</label>
                            <label class="col-sm-2 col-form-label text-left">[T]otal</label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Kategori</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="kat1">
                            <label class="col-sm-2 col-form-label text-center">s/d</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="kat2">
                        </div>

                        <br>
                        <div class="row">
                            <label class="col-sm-2 text-right">Kosong :</label>
                            <span class="col-sm-2 text-center" style="margin-top: 3px">S E M U A</span>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success col-sm-3" type="button" id="cetak" onclick="cetak()">CETAK</button>
                        </div>
                        <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!--MODAL PB-->
    <div class="modal fade" id="m_pb" tabindex="-1" role="dialog" aria-labelledby="m_pb" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tabel Pb</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tablePb">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Tag_Kodetag</th>
                                        <th>Tag_Keterangan</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyTag"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- END OF MODAL PB-->

    <script>
        let tablePb;
        let cursor;

        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        $(document).ready(function () {
            getPb();
        })

        function getPb(){
            tablePb =  $('#tablePb').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/getpb' }}',
                },
                "columns": [
                    {data: 'pbo_nopb', name: 'pbo_nopb'},
                    {data: 'pbo_kodeomi', name: 'pbo_kodeomi'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowPb');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalRowPb', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().text();
            switch (cursor){
                case 'butt1':
                    $('#pb1').val(kode);
                    break;
                case 'butt2':
                    $('#pb2').val(kode);
                    break;
            }
            $('#m_pb').modal('toggle');
        });

        function toggleData(val){
            cursor = val.id;
            $('#m_pb').modal('toggle');
        }

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

            if(($('#cab1').val() == '' && $('#cab2').val() != '')||($('#cab1').val() != '' && $('#cab2').val() == '')){
                swal({
                    title:'Alert',
                    text: 'Kode Cabang Harus Terisi Semua Atau Tidak Terisi Sama Sekali ',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#cab1').focus();
                });
                return false;
            }
            if($('#cab1').val() > $('#cab2').val()){
                swal({
                    title:'Alert',
                    text: 'Kode Cabang 1 Harus Lebih Kecil dari Kode Cabang 2',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#cab1').focus();
                });
                return false;
            }
            if(($('#div1').val() == '' && $('#div2').val() != '')||($('#div1').val() != '' && $('#div2').val() == '')){
                swal({
                    title:'Alert',
                    text: 'Kode Divisi Harus Terisi Semua Atau Tidak Terisi Sama Sekali ',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#div1').focus();
                });
                return false;
            }
            if($('#div1').val() > $('#div2').val()){
                swal({
                    title:'Alert',
                    text: 'Kode Divisi 1 Harus Lebih Kecil dari Kode Divisi 2',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#div1').focus();
                });
                return false;
            }
            if(($('#dep1').val() == '' && $('#dep2').val() != '')||($('#dep1').val() != '' && $('#dep2').val() == '')){
                swal({
                    title:'Alert',
                    text: 'Kode Departemen Harus Terisi Semua Atau Tidak Terisi Sama Sekali ',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#dep1').focus();
                });
                return false;
            }
            if($('#dep1').val() > $('#dep2').val()){
                swal({
                    title:'Alert',
                    text: 'Kode Departemen 1 Harus Lebih Kecil dari Kode Departemen 2',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#dep1').focus();
                });
                return false;
            }
            if(($('#kat1').val() == '' && $('#kat2').val() != '')||($('#kat1').val() != '' && $('#kat2').val() == '')){
                swal({
                    title:'Alert',
                    text: 'Kode Kategori Barang Harus Terisi Semua Atau Tidak Terisi Sama Sekali ',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#kat1').focus();
                });
                return false;
            }
            if($('#kat1').val() > $('#kat2').val()){
                swal({
                    title:'Alert',
                    text: 'Kode Kategori Barang 1 Harus Lebih Kecil dari Kode Kategori Barang 2',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#kat1').focus();
                });
                return false;
            }
            if($('#rel1').val() == ''){
                $('#rel1').val('-999');
            }
            if($('#rel2').val() == ''){
                $('#rel2').val('999999');
            }
            window.open(`{{ url()->current() }}/cetak?date1=${dateA}&date2=${dateB}&cab1=${$('#cab1').val()}&cab2=${$('#cab2').val()}&div1=${$('#div1').val()}&div2=${$('#div2').val()}&dep1=${$('#dep1').val()}&dep2=${$('#dep2').val()}&kat1=${$('#kat1').val()}&kat2=${$('#kat2').val()}&rel1=${$('#rel1').val()}&rel2=${$('#rel2').val()}&tag1=${$('#inputTag1').val()}&tag2=${$('#inputTag2').val()}&tag3=${$('#inputTag3').val()}&tag4=${$('#inputTag4').val()}&tag5=${$('#inputTag5').val()}`, '_blank');
        }
    </script>
@endsection
