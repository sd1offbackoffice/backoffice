@extends('navbar')
@section('title','Inquery Retur Supplier')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-7">
                                <form class="form">
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Supplier</label>
                                        <div class="col-sm-4 buttonInside">
                                            <input type="text" class="form-control" id="txtSup">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov"
                                                    data-toggle="modal" id="btn-lov">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="txtNamaSup" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Alamat</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="txtAlamat" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Telpon</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="txtTelpon" disabled>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-right">CP</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="txtCP" disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" id="btnCetak" class="btn btn-lg btn-success"
                                        style="height: 120px;"><i
                                            class="icon fas fa-print"></i> Cetak
                                </button>

                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>
                <fieldset class="card border-dark card-hdr cardForm">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body">
                        <div class="card-body p-0 tableFixedHeader" style="height: 600px;">
                            <table class="table table-sm table-striped table-bordered "
                                   id="table">
                                <thead class="theadDataTables">
                                <tr class="table-sm text-center">
                                    <th class="text-center">PLU</th>
                                    <th class="text-center">Nama Barang</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Tag</th>
                                    <th class="text-center">Qty Retur</th>
                                </tr>
                                </thead>
                                <tbody id="body-table">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--MODAL Supplier--}}
    <div class="modal fade" id="m_lov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>
                        Nomor NPB
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>Nama Supplier</td>
                                        <td>Kode</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    <style>
        .row-lov:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov-plu {
            position: absolute;
            /*right: 4px;*/
            /*top: 1px;*/
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;

        }

        .input-group-text {
            background-color: white;
        }
    </style>


    <script>
        var gross = 0;
        var ppn = 0;
        var potongan = 0;
        var total = 0;
        $(document).ready(function () {
            $('#table').DataTable();
        });

        $('#txtSup').keypress(function (e) {
            if (e.keyCode == 13) {
                var kdsup = $(this).val();
                getData(kdsup);
            }
        });

        $('#table_lov').DataTable({
            "ajax": '{{ url('/bo/transaksi/pengeluaran/inqueryrtrsup/get-data-lov') }}',
            "columns": [
                {data: 'sup_namasupplier', name: 'sup_namasupplier'},
                {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('row-lov').css({'cursor': 'pointer'});
            },
            "order": []
        });

        $(document).on('click', '.row-lov', function () {
            var currentButton = $(this);
            var kdsup = currentButton.children().last().text();
            $('#txtSup').val(kdsup);
            $('#m_lov').modal('hide');
            getData(kdsup);
        });

        function getData(kdsup) {
            $('#modal-loader').modal('show');
            ajaxSetup();
            $.ajax({
                url: "{{ url('/bo/transaksi/pengeluaran/inqueryrtrsup/get-data') }}",
                type: 'GET',
                data: {
                    kdsup: kdsup,
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response.status = 'success') {
                        $('#modal-loader').modal('show');
                        console.log(response);
                        $('#txtNamaSup').val(response.supplier.supplier);
                        $('#txtAlamat').val(response.supplier.alamat);
                        $('#txtTelpon').val(response.supplier.telp);
                        $('#txtCP').val(response.supplier.cp);

                        ajaxSetup();
                        $('#table').DataTable().destroy();
                        $('#table').DataTable({
                            "paging": true,
                            "lengthChange": true,
                            "searching": true,
                            "ordering": true,
                            "info": true,
                            "autoWidth": false,
                            "responsive": true,
                            "ajax": {
                                "type": 'GET',
                                "url": "{{ url('/bo/transaksi/pengeluaran/inqueryrtrsup/get-data-detail') }}",
                                "data": {
                                    'kdsup': kdsup,
                                }
                            },
                            "columns": [
                                {
                                    data: 'plu',
                                    name: 'plu'
                                },
                                {
                                    data: 'barang',
                                    name: 'barang'
                                },
                                {
                                    data: 'satuan',
                                    name: 'satuan'
                                },
                                {
                                    data: 'tag',
                                    name: 'tag'
                                },
                                {
                                    data: 'qty',
                                    name: 'qty'
                                }
                            ],
                            "createdRow": function (row, data, dataIndex) {
                                $(row).children().first().next().next().next().next().css({
                                    'vertical-align': 'middle',
                                    'text-align': 'right'
                                });
                                $(row).children().first().next().next().next().next().text(convertToRupiah2($(row).children().first().next().next().next().next().text()));

                                $('#modal-loader').modal('hide');

                            }
                        });
                    }
                    else {
                        alertError(response.status,response.message,response.status)
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });

        }

        $(document).on('click', '#btnCetak', function () {
            var currentButton = $(this);
            var kdsup = $('#txtSup').val();
            if (kdsup == '') {
                swal('Info', 'Pilih Kode Supplier terlebih dahulu!', 'info');
            }
            else {
                window.open('{{ url()->current() }}/cetak?kdsup='+kdsup);
            }
        });
    </script>


@endsection
