@extends('navbar')
@section('title','Pembatalan NPB')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Nomor NPB</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="txtNoDoc">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov_npb"
                                                    data-toggle="modal" id="btn-lov-npb">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" id="btnDelete" class="btn btn-danger"><i
                                                        class="icon fas fa-trash"></i> Hapus NPB
                                            </button>
                                        </div>
                                    </div>
                                </form>
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
                                    <th width="7%" class="text-center" rowspan="2">PLU</th>
                                    <th width="15%" class="text-center" rowspan="2">Nama Barang</th>
                                    <th width="5%" class="text-center" rowspan="2">Kemasan</th>
                                    <th width="14%" class="text-center" colspan="2">Kuantum</th>
                                    <th width="7%" class="text-center" rowspan="2">H.P.P</th>
                                    <th width="7%" class="text-center" rowspan="2">Total</th>
                                </tr>
                                <tr class="table-sm text-center">

                                    <th width="7%" class="text-center small"></th>
                                    <th width="7%" class="text-center small"></th>
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

    {{--MODAL NO NPB--}}
    <div class="modal fade" id="m_lov_npb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                <table class="table" id="table_lov_nonpb">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>No. Doc</td>
                                        <td>Tanggal</td>
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
        .row-lov-npb:hover {
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

        $('#txtNoDoc').keypress(function (e) {
            if (e.keyCode == 13) {
                var no_npb = $(this).val();
                getData(no_npb);
            }
        });

        $('#table_lov_nonpb').DataTable({
            "ajax": '{{ url('/bo/transaksi/pengeluaran/pembatalan/get-data-lov-npb') }}',
            "columns": [
                {data: 'msth_nodoc', name: 'msth_nodoc'},
                {data: 'msth_tgldoc', name: 'msth_tgldoc'},
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
                $(row).addClass('row-lov-npb').css({'cursor': 'pointer'});
            },
            "order": []
        });

        $(document).on('click', '.row-lov-npb', function () {
            var currentButton = $(this);
            var no_npb = currentButton.children().first().text();
            $('#txtNoDoc').val(no_npb);
            $('#m_lov_npb').modal('hide');
            getData(no_npb);
        });

        function getData(no_npb) {
            $('#modal-loader').modal('show');
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
                    "url": "{{ url('/bo/transaksi/pengeluaran/pembatalan/get-data') }}",
                    "data": {
                        'no_npb': no_npb,
                    }
                },
                "columns": [
                    {
                        data: 'mstd_prdcd',
                        name: 'mstd_prdcd'
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
                        data: 'mstd_qty',
                        name: 'mstd_qty'
                    },
                    {
                        data: 'mstd_qtyk',
                        name: 'mstd_qtyk'
                    },
                    {
                        data: 'mstd_hrgsatuan',
                        name: 'mstd_hrgsatuan'
                    },
                    {
                        data: 'mstd_gross',
                        name: 'mstd_gross'
                    }
                ],
                "createdRow": function (row, data, dataIndex) {
                    $(row).children().first().next().next().next().css({
                        'vertical-align': 'middle',
                        'text-align': 'right'
                    });
                    $(row).children().first().next().next().next().next().css({
                        'vertical-align': 'middle',
                        'text-align': 'right'
                    });
                    $(row).children().first().next().next().next().next().next().css({
                        'vertical-align': 'middle',
                        'text-align': 'right'
                    });
                    $(row).children().first().next().next().next().next().next().next().css({
                        'vertical-align': 'middle',
                        'text-align': 'right'
                    });

                    $(row).children().first().next().next().next().next().next().text(convertToRupiah2($(row).children().first().next().next().next().next().next().text()));
                    $(row).children().first().next().next().next().next().next().next().text(convertToRupiah2($(row).children().first().next().next().next().next().next().next().text()));
                    $('#modal-loader').modal('hide');

                }
            });
        }

        $(document).on('click', '#btnDelete', function () {
            var currentButton = $(this);
            var no_npb = $('#txtNoDoc').val();
            if (no_npb == '') {
                swal('Info', 'Pilih No. NPB terlebih dahulu!', 'info');
            }
            else {
                swal({
                    title: "NPB " + no_npb + " akan dibatalkan ?",
                    text: "Tekan Tombol Ya untuk Melanjutkan!",
                    icon: "info",
                    buttons: true,
                }).then((yes) => {
                    if (yes) {
                        ajaxSetup();
                        $.ajax({
                            url: "{{ url('/bo/transaksi/pengeluaran/pembatalan/delete') }}",
                            type: 'POST',
                            data: {
                                no_npb: no_npb,
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');
                                console.log(response);
                                if (response.message) {
                                    swal(response.status, response.message, response.status);
                                }
                            }, error: function (error) {
                                console.log(error);
                            }
                        });
                    } else {
                        return false;
                    }
                });
            }
        });
    </script>


@endsection