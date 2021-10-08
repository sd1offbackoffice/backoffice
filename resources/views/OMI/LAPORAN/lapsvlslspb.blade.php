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
                            <input class="col-sm-2 text-center form-control" type="text" id="pilihan" onkeypress="return isDT(event)" maxlength="1">
                            <label class="col-sm-2 col-form-label text-center">[D]etil</label>
                            <label class="col-sm-2 col-form-label text-left">[T]otal</label>
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
                    <input type="text" hidden id="date1">
                    <input type="text" hidden id="date2">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tablePb">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Tag Kodetag</th>
                                        <th>Tag Keterangan</th>
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
        }, function(start, end, label) { //untuk mendeteksi perubahan
            //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            $('#date1').val(start.format('YYYY-MM-DD'));
            $('#date1').change();
            $('#date2').val(end.format('YYYY-MM-DD'));
            $('#date2').change();
            // console.log(start.format('YYYY-MM-DD') + ' to ' + end.format('DD-MM-YYYY'));
        });

        $('#date1, #date2').change( function() {
            tablePb.draw();
        } );

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {

                let min = Date.parse($('#date1').val());
                let max = Date.parse($('#date2').val());
                let val = Date.parse(data[2].substr(0,10)); // use data for the val column, [2] maksudnya kolom ke 2, yaitu pbo_create_dt
                if ( ( isNaN( min ) && isNaN( max ) ) ||
                    ( isNaN( min ) && val <= max ) ||
                    ( min <= val   && isNaN( max ) ) ||
                    ( min <= val   && val <= max ) )
                {
                    return true;
                }

                return false;
            }
        );

        $(document).on({
            ajaxStart: function() { $('#modal-loader').modal('show');   },
            ajaxStop: function() { $('#modal-loader').modal('hide'); }
        });

        $(document).ready(function () {
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;

            getPb();
            $('#date1').val(today);
            $('#date2').val(today);
            $('#date2').change();
        })

        function getPb(){
            tablePb =  $('#tablePb').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/getpb' }}',
                },
                "columns": [
                    {data: 'pbo_nopb', name: 'pbo_nopb'},
                    {data: 'pbo_kodeomi', name: 'pbo_kodeomi'},
                    {data: 'pbo_create_dt', name: 'pbo_create_dt', visible: false},
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

        function isDT(evt){ //membatasi input untuk hanya boleh Y dan T, serta mendeteksi bila menekan tombol enter
            $('#pilihan').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 100) // d kecil
                return 68; // D besar

            if (charCode == 116) // t kecil
                return 84; //T besar

            if (charCode == 68 || charCode == 84)
                return true
            // if (charCode == 13){
            //     $('#pilihan').val('T');
            //     return 84;
            // }
            return false;
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

            if($('#cab1').val() == '' && $('#cab2').val() != '' && $('#cab1').val() != '' && $('#cab2').val() == ''){
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
            if($('#pb1').val() == '' && $('#pb2').val() != '' && $('#pb1').val() != '' && $('#pb2').val() == ''){
                swal({
                    title:'Alert',
                    text: 'No. PB Harus Terisi Semua atau Tidak Terisi Sama Sekali',
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
            if($('#pb1').val() > $('#pb2').val()){
                swal({
                    title:'Alert',
                    text: 'No. PB 1 Harus Lebih Kecil dari No. PB 2',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#pb1').focus();
                });
                return false;
            }
            window.open(`{{ url()->current() }}/cetak?date1=${dateA}&date2=${dateB}&cab1=${$('#cab1').val()}&cab2=${$('#cab2').val()}&pb1=${$('#pb1').val()}&pb2=${$('#pb2').val()}&pilihan=${$('#pilihan').val()}`, '_blank');
        }

        function clear(){
            $(' input').val('');
            $('#daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));

            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            let yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;

            $('#date1').val(today);
            $('#date2').val(today);
            $('#date2').change();
        }
    </script>
@endsection
