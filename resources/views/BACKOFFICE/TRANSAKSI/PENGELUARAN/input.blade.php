@extends('navbar')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mb-0 ">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">NOMOR
                                            TRN</label>
                                        <input type="text" id="txtNoDoc"
                                               class="text-center form-control form-control-sm col-sm-2">
                                        <div class="col-sm-3">
                                            <button class="btn float-left pl-0 btn-sm" type="button"
                                                    data-target="#m_lov_trn" data-toggle="modal" id="btn-lov-trn"
                                                    onclick=""><img
                                                        src="{{asset('image/icon/help.png')}}" height="20px"
                                                        width="20px">
                                            </button>
                                            <button type="button" id="btnHapusDokumen"
                                                    class="btn btn-danger btn-sm float-left "><i
                                                        class="icon fas fa-trash"></i> Hapus Dokumen
                                            </button>
                                        </div>
                                        <input type="text" id="txtModel"
                                               class="text-center form-control form-control-sm col-sm-3" disabled>
                                    </div>
                                    <div class="form-group row mb-0 ">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">TANGGAL</label>
                                        <input type="text" id="dtTglDoc"
                                               class="text-center form-control form-control-sm col-sm-2">
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">SUPPLIER</label>
                                        <input type="text" id="txtKdSupplier"
                                               class="text-center form-control form-control-sm col-sm-1">
                                        <div class="col-sm-5">
                                            <button class="btn float-left pl-0 btn-sm" type="button"
                                                    data-target="#m_lov_supplier" data-toggle="modal"
                                                    onclick=""><img src="{{asset('image/icon/help.png')}}" height="20px"
                                                                    width="20px">
                                            </button>

                                            <div class="row">
                                                <input type="text" id="txtNmSupplier"
                                                       class="form-control form-control-sm col-sm-8" disabled>
                                                <label class="col-form-label text-sm-right col-sm-2"
                                                       style="font-size: 12px">PKP</label>
                                                <input type="text" id="txtPKP"
                                                       class="form-control form-control-sm text-center col-sm-1"
                                                       disabled>
                                            </div>
                                        </div>
                                        <button type="button" id="btnUsulanRetur"
                                                class="btn btn-info btn-sm float-left offset-3 col-sm-2"><i
                                                    class="icon fas fa-upload"></i> Usulan Retur
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"> Header</legend>

                    <div class="card-body cardForm">
                        <div class="card-body p-0 tableFixedHeader" style="height: 250px; width: 1200px;">
                            <table class="table table-striped table-bordered"
                                   id="table-header">
                                <thead class="thead-dark">
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small"></th>
                                    <th width="7%" class="text-left small">PLU</th>
                                    <th width="20%" class="text-left small">DESKRIPSI</th>
                                    <th width="10%" class="text-center small">SATUAN</th>
                                    <th width="5%" class="text-center small">BKP</th>
                                    <th width="5%" class="text-center small">STOCK</th>
                                    <th width="5%" class="text-center small">CTN</th>
                                    <th width="5%" class="text-center small">PCS</th>
                                    <th width="40%" class="text-left small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-detail">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Detail</legend>

                    <div class="card-body cardForm">
                        <div class="card-body p-0 tableFixedHeader">
                            <table class="table table-striped table-bordered"
                                   id="table-detail">
                                <thead class="thead-dark">
                                <tr class="table-sm text-center">
                                    <th class="text-center small"></th>
                                    <th width="5%" class="text-center small">PLU</th>
                                    <th width="18%" class="text-center small">DESKRIPSI</th>
                                    <th width="5%" class="text-center small">SATUAN</th>
                                    <th width="1%" class="text-center small">BKP</th>
                                    <th width="2%" class="text-center small">STOCK</th>
                                    <th width="5%" class="text-center small">HRG.SATUAN (IN CTN)</th>
                                    <th width="3%" class="text-center small">CTN</th>
                                    <th width="3%" class="text-center small">PCS</th>
                                    <th width="5%" class="text-center small">GROSS</th>
                                    <th width="5%" class="text-center small">DISC %</th>
                                    <th width="5%" class="text-center small">DISC Rp</th>
                                    <th width="5%" class="text-center small">PPN</th>
                                    <th width="5%" class="text-center small">FAKTUR</th>
                                    <th width="5%" class="text-center small">PAJAK No.</th>
                                    <th width="5%" class="text-center small">TGL FP</th>
                                    <th width="5%" class="text-center small">NoReff BTB</th>
                                    <th width="18%" class="text-center small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-detail">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Total</legend>
                    <div class="card-body cardForm">
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">TOTAL
                                ITEM</label>
                            <input type="text" id="total-item"
                                   class="text-center form-control form-control-sm col-sm-2">
                            <label class="col-sm-1 col-form-label text-sm-right offset-3"
                                   style="font-size: 12px">GROSS</label>
                            <input type="text" id="gross"
                                   class="text-center form-control form-control-sm col-sm-2">
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6" style="font-size: 12px">POTONGAN</label>
                            <input type="text" id="potongan"
                                   class="text-center form-control form-control-sm col-sm-2">
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6"
                                   style="font-size: 12px">PPN</label>
                            <input type="text" id="ppn"
                                   class="text-center form-control form-control-sm col-sm-2">
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6"
                                   style="font-size: 12px">TOTAL</label>
                            <input type="text" id="total"
                                   class="text-center form-control form-control-sm col-sm-2">
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--MODAL NODOK RETUR--}}
    <div class="modal fade" id="m_lov_trn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>
                        Nomor Trn
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov_notrn">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>No. Doc</td>
                                        <td>Tgl. Doc</td>
                                        <td>Nota</td>
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


    {{--MODAL KODE SUPPLIER--}}
    <div class="modal fade" id="m_lov_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Supplier</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov_supplier">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>Supplier</td>
                                        <td>Kode</td>
                                        <td>PKP</td>
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
        .row-lov-trn:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .row-lov-supplier:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov-plu {
            position: absolute;
            right: 4px;
            top: 1px;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;

        }
    </style>


    <script>

        $(document).ready(function () {
            $('#dtTglDoc').datepicker({
                "dateFormat": "dd/mm/yy",
                "setDate": new Date()
            });
        });


        $('#txtNoDoc').keypress(function (e) {
            if (e.keyCode == 13) {
                var nodoc = $(this).val();
                getDataTrn(nodoc);
            }
        });

        $('#table_lov_notrn').DataTable({
            "ajax": '{{ url('/bo/transaksi/pengeluaran/input/get-data-lov-trn') }}',
            "columns": [
                {data: 'trbo_nodoc', name: 'trbo_nodoc'},
                {data: 'trbo_tgldoc', name: 'trbo_tgldoc'},
                {data: 'nota', name: 'nota'},
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('row-lov-trn').css({'cursor': 'pointer'});
            },
            "order": []
        });

        $(document).on('click', '.row-lov-trn', function () {
            var currentButton = $(this);
            nodoc = currentButton.children().first().text();
            $('#txtNoDoc').val(nodoc);
            getDataTrn(nodoc);
            $('#m_lov_trn').modal('hide');
        });

        $('#table_lov_supplier').DataTable({
            "ajax": '{{ url('/bo/transaksi/pengeluaran/input/get-data-lov-supplier') }}',
            "columns": [
                {data: 'sup_namasupplier', name: 'sup_namasupplier'},
                {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},
                {data: 'sup_pkp', name: 'sup_pkp'},
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('row-lov-supplier').css({'cursor': 'pointer'});
            },
            "order": []
        });

        $(document).on('click', '.row-lov-supplier', function () {
            var currentButton = $(this);
            kdsup = currentButton.children().first().next().text();
            namasupplier = currentButton.children().first().text();
            pkp = currentButton.children().first().next().next().text();

            $('#txtKdSupplier').val(kdsup);
            $('#txtNmSupplier').val(namasupplier);
            $('#txtPKP').val(pkp);

            $('#m_lov_supplier').modal('hide');
        });

        function getDataTrn(notrn) {
            if (notrn == '') {
                swal({
                    title: "Buat Nomor Pengeluaran Baru?",
                    text: "Tekan Tombol Ya untuk Melanjutkan!",
                    icon: "info",
                    buttons: true,
                }).then((yes) => {
                    if (yes) {
                        $.ajax({
                            type: "GET",
                            url: "{{ url('/bo/transaksi/pengeluaran/input/get-new-no-trn') }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#txtNoDoc').prop('disabled', true);
                                $('#dtTglDoc').prop('disabled', true);
                                $('#btn-lov-trn').prop('disabled', true);

                                $('#modal-loader').modal('hide');
                                if (response.status == 'error') {
                                    swal({
                                        title: response.status,
                                        text: response.message,
                                        icon: 'error'
                                    }).then(() => {
                                    });
                                }
                                else {
                                    $('#txtNoDoc').val(response.no);
                                    $("#dtTglDoc").datepicker().datepicker("setDate", new Date());
                                    $('#txtModel').val(response.model);
                                    $('#txtKdSupplier').focus();
                                }

                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                // handle error
                                swal({
                                    title: error.responseJSON.exception,
                                    text: error.responseJSON.message,
                                    icon: 'error'
                                }).then(() => {

                                });
                            }
                        });
                    } else {
                        return false;
                    }
                });
            }
            else {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/bo/transaksi/pengeluaran/input/get-data-pengeluaran') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        notrn: notrn
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        console.log(response);
                        var datas = response.datas;

                        datas.forEach(function (data) {
                            var plu = data.h_plu == null ? '' : data.h_plu;
                            var deskripsi = data.h_deskripsi == null ? '' : data.h_deskripsi;
                            var satuan = data.h_satuan == null ? '' : data.h_satuan;
                            var bkp = data.h_bkp == null ? '' : data.h_bkp;
                            var stock = data.h_stock == null ? '' : data.h_stock;
                            var ctn = data.h_ctn == null ? '' : data.h_ctn;
                            var pcs = data.h_pcs == null ? '' : data.h_pcs;
                            var ket = data.h_ket == null ? '' : data.h_ket;

                            $('#body-table-detail').empty();
                            $('#body-table-detail').append('<tr><td></td><td>' + plu + '</td><td>' + deskripsi + '</td><td>' + satuan + '</td><td>' + bkp + '</td><td>' + stock + '</td><td>' + ctn + '</td><td>' + pcs + '</td><td>' + ket + '</td></tr>');
                        });

                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        // handle error
                        swal({
                            title: error.responseJSON.exception,
                            text: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {

                        });
                    }
                });
            }

        }
    </script>


@endsection