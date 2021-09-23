@extends('navbar')
@section('title','LAPORAN MONITORING ITEM YANG TIDAK TERSUPPLY')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5 text-center">LAPORAN MONITORING ITEM YANG TIDAK TERSUPPLY</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label text-right">Tanggal</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker">
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label text-right">Kode Monitoring</label>
                            <div class="col-sm-2 buttonInside" style="margin-left: -15px; margin-right: 30px">
                                <input type="text" class="form-control" id="kodeMonitoring">
                                <button type="button" class="btn btn-lov p-0" onclick="toggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <br>
                    </div>
                </fieldset>

                <fieldset class="card border-dark">
                    {{--                    <legend class="w-auto ml-5 text-center">LAPORAN MONITORING ITEM YANG TIDAK TERSUPPLY</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <table  class="table table-sm table-striped table-bordered " id="tableMain">
                            <thead class="theadDataTables">
                            <tr>
                                <th>PLU IGR</th>
                                <th>PB OMI</th>
                                <th>ACTUAL</th>
                                <th>SELISIH</th>
                                <th>STOK</th>
                                <th>TGL PB</th>
                                <th>QTY PB</th>
                                <th>BPB</th>
                                <th>TGL BPB</th>
                                <th>PKMT</th>
                                <th>M+</th>
                            </tr>
                            </thead>
                        </table>
                        <br>
                        <span>Ctrl + Shift + F2 - CETAK MONITORING</span>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade" id="m_mon" tabindex="-1" role="dialog" aria-labelledby="m_mon" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kode Monitoring</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableMonitor">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Monitoring</th>
                                        <th>Nama Monitoring</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyMonitor"></tbody>
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

    <script>
        let tableMon;

        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        $(document).ready(function () {
            getMon();
        })

        function getMon(){
            tableMon =  $('#tableMonitor').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/getmon' }}'
                },
                "columns": [
                    {data: 'mpl_kodemonitoring', name: 'mpl_kodemonitoring'},
                    {data: 'mpl_namamonitoring', name: 'mpl_namamonitoring'}
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
                    $(row).addClass('modalRowMon');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        function getTable(){
            let table =  $('#tableMain').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/showdata' }}'
                },
                "columns": [
                    {data: 'ftkode', name: 'ftkode'},
                    {data: 'ftqtyo', name: 'ftqtyo'},
                    {data: 'ftqtyr', name: 'ftqtyr'},
                    {data: 'ftqtyl', name: 'ftqtyl'},
                    {data: 'ftqtys', name: 'ftqtys'},
                    {data: 'fttgpb', name: 'fttgpb'},
                    {data: 'ftqtyp', name: 'ftqtyp'},
                    {data: 'fttbpb', name: 'fttbpb'},
                    {data: 'fttgbp', name: 'fttgbp'},
                    {data: 'ftpkmt', name: 'ftpkmt'},
                    {data: 'ftmpls', name: 'ftmpls'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalRowMon', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().text();

            $('#kodeMonitoring').val(kode).change();
            $('#m_mon').modal('toggle');
        });

        function toggleData(val){
            $('#m_mon').modal('toggle');
        }

        $('#kodeMonitoring').on('change', function() {
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

            $.ajax({
                url: '{{ url()->current() }}/prosesdata',
                type: 'GET',
                data: {
                    date1: dateA,
                    date2: dateB,
                    kdmon: $('#kodeMonitoring').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    getTable();
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
        });

        $(window).bind('keydown', function(event) {
            if (event.ctrlKey && event.shiftKey && event.key === 'F2') {
                cetak();
                // event.preventDefault();
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

            $.ajax({
                url: '{{ url()->current() }}/checkdata',
                type: 'GET',
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response){
                        window.open(`{{ url()->current() }}/cetak?date1=${dateA}&date2=${dateB}`, '_blank');
                    }else{
                        swal({
                            title: 'MONITORING ITEM YANG TIDAK TERSSUPPLY',
                            text: "TIDAK ADA Data Yang Dapat Dicetak !",
                            icon: 'error',
                        });
                    }
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
    </script>
@endsection
