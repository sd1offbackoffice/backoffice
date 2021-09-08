@extends('navbar')
@section('title','Free PLU OMI Kepala 9')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="offset-1 col-sm-10">
                <fieldset class="card border-secondary" id="data-field">
                    <legend class="w-auto ml-5">PLU OMI Kepala 9</legend>
                    <div class="card-body">
                        <table class="table table bordered table-sm mt-3" id="table_data">
                            <thead class="theadDataTables">
                            <tr class="text-center align-middle">
                                <th>PLU IGR</th>
                                <th>PLU OMI</th>
                                <th>Merk</th>
                                <th>Flavor</th>
                                <th>Barang</th>
                                <th>Kemasan</th>
                                <th>Size</th>
                                <th colspan="2">Divisi</th>
                                <th>Dept</th>
                                <th colspan="2">Kategori</th>
                                <th>Barcode</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
            <div class="offset-1 col-sm-10">
                <fieldset class="card border-secondary" id="data-field">
                    <legend class="w-auto ml-5">Input</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-sm-1 col-form-label text-sm-right">PLU IGR :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="pluigr" placeholder="..." value="">
                                <button type="button" class="btn btn-lov p-0" data-toggle="modal"
                                        data-target="#m_lov_plu">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">Merk :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="merk" value="" readonly>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">Divisi :</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="divisi" value="" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="offset-3 col-sm-1 col-form-label text-sm-right">Flavor :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="flavor" value="" readonly>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">Departemen:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="departemen" value="" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="offset-3 col-sm-1 col-form-label text-sm-right">Barang :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="barang" value="" readonly>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">Kategori:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="kategori" value="" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-1 col-form-label text-sm-right">PLU OMI :</label>
                            <div class="col-sm-2">
                                <input type="number" class="form-control" id="pluomi" value="">
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">Kemasan :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="kemasan" value="" readonly>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">Barcode :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="barcode" value="" readonly>
                            </div>
                            <button type="button" id="btn-simpan" class="btn btn-primary offset-2">SIMPAN</button>

                        </div>
                        <div class="row form-group">
                            <label class="offset-3 col-sm-1 col-form-label text-sm-right">Size :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="size" value="" readonly>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">Status :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="status" value="" readonly>
                            </div>
                            <button type="button" id="btn-hapus" class="btn btn-danger offset-2">HAPUS</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_plu">
                                    <thead>
                                    <tr>
                                        <th>PLU</th>
                                        <th>DESKRIPSI</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover {
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang {
            position: absolute;
            bottom: 10px;
            right: 3vh;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active {
            box-shadow: none !important;
            outline: 0px !important;
        }

        .btn-lov-plu {
            position: absolute;
            bottom: 10px;
            right: 2vh;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active {
            box-shadow: none !important;
            outline: 0px !important;
        }

        .modal thead tr th {
            vertical-align: middle;
        }
    </style>

    <script>
        var arrData = [];

        $(document).ready(function () {
            $('#tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            getDatatable();
            getLovPLU();
        });

        function getLovPLU(value) {
            tableLovPLU = $('#table_lov_plu').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-lov-plu',
                    data: {
                        "search": value
                    }
                },
                "columns": [
                    {data: 'plu'},
                    {data: 'deskripsi'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-plu').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $('#table_lov_plu_filter input').off().on('keypress', function (e) {
                        if (e.which == 13) {
                            let val = $(this).val().toUpperCase();

                            tableLovPLU.destroy();
                            getLovPLU(val);
                        }
                    })
                }
            });

        }

        $(document).on('click', '.row-lov-plu', function () {
            var currentButton = $(this);
            let plu = currentButton.children().first().text();

            $('#pluigr').val(plu);
            getDataInput(plu);
            $('#m_lov_plu').modal('hide');
        });

        function getDatatable() {
            if($.fn.DataTable.isDataTable('#table_data')){
                $('#table_data').DataTable().clear().destroy();
            }
            $('#table_data').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-datatable',
                },
                "columns": [
                    {data: 'fpl_pluigr'},
                    {data: 'fpl_freepluomi'},
                    {data: 'brg_merk'},
                    {data: 'brg_flavor'},
                    {data: 'brg_nama'},
                    {data: 'brg_kemasan'},
                    {data: 'brg_ukuran'},
                    {data: 'prd_kodedivisi'},
                    {data: 'div_namadivisi'},
                    {data: 'prd_kodedepartement'},
                    {data: 'prd_kodekategoribarang'},
                    {data: 'kat_namakategori'},
                    {data: 'prd_barcode'},
                    {data: 'stat_brg'}
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
                },
                "order": [],
                "initComplete": function (data) {
                }
            });
        }
        $(document).on('keypress', '#pluigr', function (e) {
            if(e.which == 13) {
                val = convertPlu($(this).val());
                $(this).val(val);
                getDataInput(val);
            }
        });
        function getDataInput(plu) {
            $.ajax({
                url: '{{ url()->current() }}/get-data-input',
                data: {
                    plu: plu,
                }, beforeSend: () => {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    console.log(result);
                    result = result[0];
                    $('#pluomi').val(result.fpl_freepluomi);
                    $('#merk').val(result.brg_merk);
                    $('#barang').val(result.brg_nama);
                    $('#flavor').val(result.brg_flavor);
                    $('#kemasan').val(result.brg_kemasan);
                    $('#size').val(result.brg_ukuran);
                    $('#divisi').val(result.divisi);
                    $('#departemen').val(result.departemen);
                    $('#kategori').val(result.kategori);
                    $('#barcode').val(result.barcode);
                    $('#status').val(result.stat_brg);

                    $('#modal-loader').modal('hide');

                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message)
                }
            })

        }
        $(document).on('click', '#btn-simpan', function (e) {
            data = {
                pluigr:$('#pluigr').val(),
                pluomi:$('#pluomi').val(),
                merk:$('#merk').val(),
                barang:$('#barang').val(),
                flavor:$('#flavor').val(),
                kemasan:$('#kemasan').val(),
                size:$('#size').val(),
                divisi:$('#divisi').val(),
                departemen:$('#departemen').val(),
                kategori:$('#kategori').val(),
                barcode:$('#barcode').val(),
                status:$('#status').val()
            }
            swal({
                title: 'Simpan?',
                icon: 'info',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                if (confirm){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/simpan',
                        type: 'post',
                        data: {
                            data: data,
                        }, beforeSend: () => {
                            $('#modal-loader').modal('show');
                        },
                        success: function (result) {
                            console.log(result);
                            $('#modal-loader').modal('hide');
                            getDatatable();
                            $(document).find('input').val('');
                            swal({
                                title: result.message,
                                icon: result.status
                            });

                        }, error: function (err) {
                            $('#modal-loader').modal('hide');
                            console.log(err.responseJSON.message.substr(0, 100));
                            alertError(err.statusText, err.responseJSON.message)
                        }
                    })
                }
            });

        });

        $(document).on('click', '#btn-hapus', function (e) {
            data = {
                pluigr:$('#pluigr').val(),
                pluomi:$('#pluomi').val(),
                merk:$('#merk').val(),
                barang:$('#barang').val(),
                flavor:$('#flavor').val(),
                kemasan:$('#kemasan').val(),
                size:$('#size').val(),
                divisi:$('#divisi').val(),
                departemen:$('#departemen').val(),
                kategori:$('#kategori').val(),
                barcode:$('#barcode').val(),
                status:$('#status').val()
            }
            swal({
                title: 'Hapus Data?',
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                if (confirm){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/hapus',
                        type: 'post',
                        data: {
                            data: data,
                        }, beforeSend: () => {
                            $('#modal-loader').modal('show');
                        },
                        success: function (result) {
                            console.log(result);
                            $('#modal-loader').modal('hide');
                            getDatatable();
                            $(document).find('input').val('');
                            swal({
                                title: result.message,
                                icon: result.status
                            });

                        }, error: function (err) {
                            $('#modal-loader').modal('hide');
                            console.log(err.responseJSON.message.substr(0, 100));
                            alertError(err.statusText, err.responseJSON.message)
                        }
                    })
                }
            });

        });

    </script>

@endsection
