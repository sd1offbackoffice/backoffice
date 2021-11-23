@extends('navbar')

@section('title','OMI | CETAK FAKTUR PAJAK')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="offset-1 col-sm-10">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-3">CETAK FAKTUR PAJAK</legend>
                            <div class="card-body">
                                <div class="row form-group">
                                    <label class="col-sm-2 text-right col-form-label">Tanggal</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control tanggal" id="tanggal" maxlength="10" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 text-right col-form-label">Nama</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="nama" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 text-right col-form-label">Jabatan</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="jabatan" autocomplete="off">
                                    </div>
                                </div>
                                <fieldset class="card border-secondary">
                                    <legend class="w-auto ml-3">Status Cetak Faktur Pajak</legend>
                                    <div class="tableFixedHeader col-sm-12 text-center">
                                        <table class="table table-sm" id="tableData">
                                            <thead>
                                            <tr>
                                                <th>Kode OMI</th>
                                                <th>Member</th>
                                                <th>Nama OMI</th>
                                                <th>Kasir</th>
                                                <th>Status</th>
                                                <th><i class="fas fa-print"></i></th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbodyModalHelp"></tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div class="modal fade" id="m_result" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container" id="pdf">

                    </div>
                </div>
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

        .clicked, .row-detail:hover {
            background-color: grey !important;
            color: white;
        }

    </style>

    <script>
        arrData = [];
        checked = [];

        $(document).ready(function () {
            $('#tanggal').datepicker({
                "dateFormat": "dd/mm/yy",
                changeMonth: true,
                changeYear: true,
            });

            $('#tanggal').datepicker('setDate', new Date());

            getData();

            swal({
                title: 'Info',
                text: 'Terdapat beberapa penyesuaian pada menu ini, sehingga tidak 100% sama dengan menu di program lama. Terima kasih',
                icon: 'info'
            }).then(() => {
                $('#tanggal').select();
            });
        });

        $('#tanggal').on('keypress',function(e){
            if(e.which == 13){
                $('#nama').select();
            }
        });

        $('#nama').on('keypress',function(e){
            if(e.which == 13){
                $('#jabatan').select();
            }
        });

        $('#jabatan').on('keypress',function(e){
            if(e.which == 13){
                getData();
            }
        });

        function getData() {
            if(!checkDate($('#tanggal').val())){
                swal({
                    title: 'Tanggal tidak sesuai format!',
                    icon: 'error'
                }).then(function(){
                    $('#tanggal').select();
                });
            }
            else{
                arrData = [];
                checked = [];
                $('#tableData').DataTable().destroy();
                $('#tableData').DataTable({
                    "ajax": {
                        'url': '{{ url()->current() }}/get-data',
                        "data": {
                            'tanggal': $('#tanggal').val()
                        },
                    },
                    "columns": [
                        {data: 'tko_kodeomi'},
                        {data: 'fkt_kodemember'},
                        {data: 'tko_namaomi'},
                        {data: 'kasir'},
                        {data: null, render: function(data){
                                if(data.status == null){
                                    return '-';
                                }
                                else if(data.status.substr(-1) == ';' || data.status.substr(-1) == '*'){
                                    return '-';
                                }
                                else return 'Sudah';
                            }
                        },
                        {data: null, render: function(data, type, full, meta){
                                // return '<input type="checkbox" class="checkbox">';
                                return `<button class="btn btn-primary" onclick="print('${meta.row}')">CETAK</button>`
                            }
                        },
                    ],
                    "paging": false,
                    "lengthChange": true,
                    "searching": false,
                    "ordering": false,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "scrollY": "400px",
                    "createdRow": function (row, data, dataIndex) {
                        $(row).addClass('row-data');
                        $(row).find('td').addClass('align-middle');
                        arrData.push(data);
                    },
                    columnDefs: [

                    ],
                    "order": []
                });
            }
        }

        function getChecked(){
            checked = [];
            $('.row-data').each(function(){
                if($(this).find('.checkbox').is(':checked')){
                    checked.push(arrData[$(this).index()]);
                }
            });
        }

        function print(index) {
            tanggal = $('#tanggal').val();
            nama = $('#nama').val();
            jabatan = $('#jabatan').val();
            kodemember = arrData[index].fkt_kodemember;
            kasir = arrData[index].kasir;

            if(!checkDate(tanggal) || !nama || !jabatan){
                swal({
                    title: 'Data belum lengkap!',
                    icon: 'warning'
                });
            }
            else window.open(`{{ url()->current() }}/print?tanggal=${tanggal}&nama=${nama}&jabatan=${jabatan}&kodemember=${kodemember}&kasir=${kasir}`, '_blank');
        }

        function cetakOld() {
            // getChecked();

            if(checked.length === 0){
                swal({
                    title: 'Belum ada data yang dipilih!',
                    icon: 'error'
                });
            }
            else{
                tanggal = $('#tanggal').val();
                nama = $('#nama').val();
                jabatan = $('#jabatan').val();
                data = '';

                $.each(checked, function(key, value){
                    if(data.length > 0)
                        data += '*';
                    data += value.fkt_kodemember + '-' + value.kasir;
                });

                window.open(`{{ url()->current() }}/print?tanggal=${tanggal}&nama=${nama}&jabatan=${jabatan}&data=${data}`, '_blank');
            }
        }
    </script>

@endsection
