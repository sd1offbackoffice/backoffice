@extends('navbar')
@section('title','LAPORAN KASIR | REKAP & EVALUASI PER MEMBER')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm"></div>
            <div class="col-sm-5">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">Retur OMI</legend>
                    <div class="card-body">
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Nomor Dokumen</label>
                            <div class="col-sm-5 buttonInside">
                                <input type="text" class="form-control text-left" id="nodoc">
                                <button id="" type="button" class="btn btn-primary btn-lov btn-lov-nodoc p-0" onclick="showLovNodoc()" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <button class="col-sm-4 btn btn-success">New Dokumen</button>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Tgl Dokumen</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="tgldoc" disabled>
                            </div>
                            <button class="col-sm-4 btn btn-danger">Delete Dokumen</button>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Kode Member</label>
                            <div class="col-sm-3 buttonInside">
                                <input type="text" class="form-control text-left" id="kodemember" onchange="checkLanggananValid('langganan2')">
                                <button id="" type="button" class="btn btn-primary btn-lov btn-lov-langganan p-0" onclick="showLovLangganan('langganan2')" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="kodetoko" onchange="checkLanggananValid('langganan2')">
                            </div>
                            <button class="col-sm-4 btn btn-primary">Print Dokumen</button>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Nomor NRB</label>
                            <div class="col-sm-5 buttonInside">
                                <input type="text" class="form-control text-left" id="nomornrb" onchange="checkLanggananValid('langganan2')">
                                <button id="" type="button" class="btn btn-primary btn-lov btn-lov-langganan p-0" onclick="showLovLangganan('langganan2')" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <button class="col-sm-4 btn btn-secondary">CSV eFaktur</button>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Tgl NRB</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="tglnrb" onchange="checkLanggananValid('langganan2')">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">Nama File</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="namafile" onchange="checkLanggananValid('langganan2')">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <label class="col-sm-3 text-right col-form-label pl-0">All Dokumen Retur</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="alldoc" onchange="checkLanggananValid('langganan2')">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-5">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">Referensi Harga Struk OMI</legend>
                    <div class="card-body">
                        <div class="row mb-1">
                            <label class="col-sm-4 text-center col-form-label pl-0">Tgl Transaksi</label>
                            <label class="col-sm-8 text-center col-form-label pl-0">Qty</label>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4"></div>
                            <label class="col-sm-4 text-center col-form-label pl-0">Sales</label>
                            <label class="col-sm-4 text-center col-form-label pl-0">Pemenuhan ( Include PPN )</label>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <fieldset class="card border-secondary" id="data-field">
                    <div class="card-body">
                        <table class="table table bordered table-sm mt-3" id="table_data">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th>PLU</th>
                                <th>Harga Satuan<br>( Include PPN )</th>
                                <th>Total</th>
                                <th>Qty ( In PCS )</th>
                                <th>Qty<br>Realisasi</th>
                                <th>Qty<br>Selisih</th>
                                <th>Qty<br>Layak Jual</th>
                                <th>Qty Tidak<br>Layak Jual</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i=0;$i<60;$i++)
                                <tr>
                                    <td>AAA</td>
                                    <td>BBB</td>
                                    <td>CCC</td>
                                    <td>DDD</td>
                                    <td>EEE</td>
                                    <td>FFF</td>
                                    <td>GGG</td>
                                    <td>HHH</td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="col-sm"></div>
    </div>

    <div class="modal fade" id="m_lov_nodoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_nodoc">
                                    <thead>
                                    <tr>
                                        <th>No Dokumen</th>
                                        <th>Tgl Dokumen</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_outlet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_outlet">
                                    <thead>
                                    <tr>
                                        <th>Kode Outlet</th>
                                        <th>Nama Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_suboutlet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_suboutlet">
                                    <thead>
                                    <tr>
                                        <th>Kode Outlet</th>
                                        <th>Kode Sub Outlet</th>
                                        <th>Nama Sub Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
    </style>

    <script>
        var arrData = [];

        $(document).ready(function(){
            $('#tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            $('#table_data').dataTable();

            getLovNodoc('');
            // getLovOutlet();
            // getLovSubOutlet();
        });

        function getLovNodoc(value){
            tableLovNodoc = $('#table_lov_nodoc').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-lov-nodoc',
                    data: {
                        "search": value
                    }
                },
                "columns": [
                    {data: 'nodoc'},
                    {data: 'tgl'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-nodoc').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#table_lov_nodoc_filter input').addClass('text-uppercase').val(value);

                    $('.btn-lov-nodoc').prop('disabled', false).html('').append('<i class="fas fa-question"></i>');

                    $(document).on('click', '.row-lov-nodoc', function (e) {
                        $('#nodoc').val($(this).find('td:eq(0)').html());
                        $('#tgldoc').val($(this).find('td:eq(1)').html());

                        getData($('#nodoc').val());

                        $('#m_lov_nodoc').modal('hide');
                    });
                }
            });

            $('#table_lov_nodoc_filter input').val(value);

            $('#table_lov_nodoc_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    tableLovNodoc.destroy();
                    getLovNodoc($(this).val().toUpperCase());
                }
            });
        }

        $('#m_lov_nodoc').on('shown.bs.modal',function(){
            $('#table_lov_nodoc_filter input').select();
        });

        function showLovNodoc(){
            $('#m_lov_nodoc').modal('show');
        }

        function getData(nodokumen){
            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().clear().destroy();
            }

            arrData = [];

            $('#table_data').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-data',
                    data: {
                        "nodokumen" : nodokumen
                    }
                },
                "columns": [
                    {data: 'rom_prdcd'},
                    {data: 'rom_hrg', render:function(data){
                            return convertToRupiah2(data);
                        }
                    },
                    {data: 'rom_ttl', render:function(data){
                            return convertToRupiah2(data);
                        }
                    },
                    {data: 'rom_qty'},
                    {data: 'rom_qtyrealisasi'},
                    {data: 'rom_qtyselisih'},
                    {data: 'rom_qtymlj'},
                    {data: 'rom_qtytlj'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-data text-right').css({'cursor': 'pointer'});
                    $(row).find('td:eq(0)').addClass('text-center');

                    arrData.push(data);
                },
                "order" : [],
                "initComplete": function(data){
                    d = arrData[0];

                    $('#kodemember').val(d.rom_member);
                    $('#kodetoko').val(d.rom_kodetoko);
                    $('#nomornrb').val(d.rom_noreferensi);
                    $('#tglnrb').val(d.rom_tglreferensi);
                }
            });
        }
    </script>

@endsection
