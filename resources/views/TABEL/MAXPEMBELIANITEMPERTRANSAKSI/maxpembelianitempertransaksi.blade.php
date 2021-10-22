@extends('navbar')
@section('title','HADIAH PER ITEM BARANG')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Maximum Pembelian Item Per Transaksi</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">PLU</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="plu">
                                <button id="trans" type="button" class="btn btn-lov p-0" data-target="#m_plu"
                                        data-toggle="modal">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-2 col-sm-4">
                                <input type="text" class="form-control" id="info" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Qty Reguler Biru</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="qtyregbiru" min="0" val="0">
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Qty Retailer</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="qtyretailer" min="0" val="0">
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Qty Gold 1</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="qtygold1" min="0" val="0">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Qty Reguler Biru Plus</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="qtyregbiruplus" min="0" val="0">
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Qty Silver</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="qtysilver" min="0" val="0">
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Qty Gold 2</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="qtygold2" min="0" val="0">
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Qty FreePass</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="qtyfreepass" min="0" val="0">
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Qty Platinum</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="qtyplatinum" min="0" val="0">
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Qty Gold 3</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="qtygold3" min="0" val="0">
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary col-sm-1" type="button" onclick="simpan()">SAVE</button>&nbsp;
                            <button class="btn btn-primary col-sm-1" type="button" onclick="hapus()">DELETE</button>&nbsp;
                            <button class="btn btn-primary col-sm-1" type="button" onclick="cetak()">PRINT</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">ALL DATA Maximum Pembelian Item</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row justify-content-center">
                            <table class="table table-striped table-bordered col-sm-12" id="tableData">
                                <thead class="theadDataTables">
                                <tr>
                                    <th>PLU</th>
                                    <th>Reg Biru</th>
                                    <th>Reg Biru Plus</th>
                                    <th>FreePass</th>
                                    <th>Retailer Merah</th>
                                    <th>Silver</th>
                                    <th>Gold 1</th>
                                    <th>Gold 2</th>
                                    <th>Gold 3</th>
                                    <th>Platinum</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyPlu"></tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <label class="col-sm-1 text-right">Deskripsi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="deskripsi" readonly>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </div>
        </div>
    </div>
    <!--MODAL Plu-->
    <div class="modal fade" id="m_plu" tabindex="-1" role="dialog" aria-labelledby="m_plu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tablePlu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>PLU</th>
                                        <th>DESKRIPSI</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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
    <!-- END OF MODAL Plu-->

    <script>
        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $(document).ready(function () {
            PluModal('');
            getDataTable('');
        });

        function PluModal(value) {
            tablePlu = $('#tablePlu').DataTable({
                "ajax": {
                    'url': '{{ url()->current().'/modal-plu' }}',
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalPlu');
                },
                columnDefs: [],
                "order": []
            });

            $('#tablePlu_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val();

                    tablePlu.destroy();
                    PluModal(val);
                }
            })
        }

        $(document).on('click', '.modalPlu', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().text();
            let desk = currentButton.children().first().next().text();

            $('#plu').val(kode);
            getDataPLU(kode);
            $('#m_plu').modal('toggle');
        });

        function getDataTable(value) {
            if($.fn.DataTable.isDataTable('#tableData')){
                $('#tableData').DataTable().destroy();
            }
            tableData = $('#tableData').DataTable({
                "ajax": {
                    'url': '{{ url()->current().'/get-data-table' }}',
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'mtr_prdcd', name: 'mtr_prdcd'},
                    {data: 'mtr_qtyregulerbiru', name: 'mtr_qtyregulerbiru'},
                    {data: 'mtr_qtyregulerbiruplus', name: 'mtr_qtyregulerbiruplus'},
                    {data: 'mtr_qtyfreepass', name: 'mtr_qtyfreepass'},
                    {data: 'mtr_qtyretailermerah', name: 'mtr_qtyretailermerah'},
                    {data: 'mtr_qtysilver', name: 'mtr_qtysilver'},
                    {data: 'mtr_qtygold1', name: 'mtr_qtygold1'},
                    {data: 'mtr_qtygold2', name: 'mtr_qtygold2'},
                    {data: 'mtr_qtygold3', name: 'mtr_qtygold3'},
                    {data: 'mtr_qtyplatinum', name: 'mtr_qtyplatinum'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalData');
                },
                columnDefs: [],
                "order": []
            });

            $('#tableData_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val();

                    tableData.destroy();
                    getDataTable(val);
                }
            })
        }

        $(document).on('click', '.modalData', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().text();

            getDataDeskripsi(kode);
        });

        function getDataDeskripsi(val) {
            $.ajax({
                url: '{{ url()->current() }}/get-deskripsi',
                type: 'GET',
                data: {
                    plu: val,
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    $('#deskripsi').val(response);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    errorHandlingforAjax(error);
                }
            });
        }

        $(document).on('keypress', '#plu', function (e) {
            if (e.which == 13) {
                $(this).val(convertPlu($(this).val()));
                getDataPLU($(this).val());
            }
        });

        function getDataPLU(value) {
            $.ajax({
                url: '{{ url()->current() }}/get-data-plu',
                type: 'GET',
                data: {
                    plu: $('#plu').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    $('#info').val(response.info);

                    $('#qtyregbiru').val(response.data.mtr_qtyregulerbiru != undefined ? response.data.mtr_qtyregulerbiru : 0);
                    $('#qtyregbiruplus').val(response.data.mtr_qtyregulerbiruplus != undefined ? response.data.mtr_qtyregulerbiruplus : 0);
                    $('#qtyfreepass').val(response.data.mtr_qtyfreepass != undefined ? response.data.mtr_qtyfreepass : 0);
                    $('#qtyretailer').val(response.data.mtr_qtyretailermerah != undefined ? response.data.mtr_qtyretailermerah : 0);
                    $('#qtysilver').val(response.data.mtr_qtysilver != undefined ? response.data.mtr_qtysilver : 0);
                    $('#qtygold1').val(response.data.mtr_qtygold1 != undefined ? response.data.mtr_qtygold1 : 0);
                    $('#qtygold2').val(response.data.mtr_qtygold2 != undefined ? response.data.mtr_qtygold2 : 0);
                    $('#qtygold3').val(response.data.mtr_qtygold3 != undefined ? response.data.mtr_qtygold3 : 0);
                    $('#qtyplatinum').val(response.data.mtr_qtyplatinum != undefined ? response.data.mtr_qtyplatinum : 0);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    errorHandlingforAjax(error);
                }
            });
        }

        function simpan() {
            if($('#plu').val() == ''){
                swal('Error','Mohon isi plu terlebih dahulu','error')
                return false;
            }
            swal({
                title: 'Yakin ingin menyimpan data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(ok){
                if(ok){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/simpan',
                        type: 'POST',
                        data: {
                            plu: $('#plu').val(),
                            mtr_qtyregulerbiru: $('#qtyregbiru').val(),
                            mtr_qtyregulerbiruplus: $('#qtyregbiruplus').val(),
                            mtr_qtyfreepass: $('#qtyfreepass').val(),
                            mtr_qtyretailermerah: $('#qtyretailer').val(),
                            mtr_qtysilver: $('#qtysilver').val(),
                            mtr_qtygold1: $('#qtygold1').val(),
                            mtr_qtygold2: $('#qtygold2').val(),
                            mtr_qtygold3: $('#qtygold3').val(),
                            mtr_qtyplatinum: $('#qtyplatinum').val(),
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            clearInput();
                            getDataTable('');
                            swal('Behasil!', response.message, response.status);
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            errorHandlingforAjax(error);
                        }
                    });
                }
            })

        }
        function hapus() {
            if($('#plu').val() == ''){
                swal('Error','Mohon isi plu terlebih dahulu','error')
                return false;
            }
            swal({
                title: 'Yakin ingin hapus data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(ok){
                if(ok){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/hapus',
                        type: 'POST',
                        data: {
                            plu: $('#plu').val(),
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            clearInput();

                            getDataTable('');
                            swal('Behasil!', response.message, response.status);
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            errorHandlingforAjax(error);
                        }
                    });
                }
            })

        }

        function clearInput(){
            $('input').each(function () {
                $(this).val('');
            });
        }

        function cetak() {
            window.open(`{{ url()->current() }}/cetak`);
        }
    </script>
@endsection
