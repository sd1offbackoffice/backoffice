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
                        <div class="card-body p-0 tableFixedHeader" style="height: 250px;">
                            <table class="table table-sm table-striped table-bordered "
                                   id="table-header">
                                <thead class="thead-dark">
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small"></th>
                                    <th width="10%" class="text-left small">PLU</th>
                                    <th width="20%" class="text-left small">DESKRIPSI</th>
                                    <th width="10%" class="text-center small">SATUAN</th>
                                    <th width="7%" class="text-center small">BKP</th>
                                    <th width="7%" class="text-center small">STOCK</th>
                                    <th width="7%" class="text-center small">CTN</th>
                                    <th width="7%" class="text-center small">PCS</th>
                                    <th width="29%" class="text-left small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-header">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Detail</legend>
                    <div class="card-body cardForm">
                        <div class="card-body p-0 tableFixedHeader">
                            <table class="table table-sm table-striped table-bordered"
                                   id="table-detail">
                                <thead class="thead-dark">
                                <tr class="table-sm text-center">
                                    <th class="text-center small">PLU</th>
                                    <th class="text-center small">DESKRIPSI</th>
                                    <th class="text-center small">SATUAN</th>
                                    <th width="3%" class="text-center small">BKP</th>
                                    <th width="5%" class="text-center small">STOCK</th>
                                    <th class="text-center small">HRG.SATUAN (IN CTN)</th>
                                    <th width="4%" class="text-center small">CTN</th>
                                    <th width="4%" class="text-center small">PCS</th>
                                    <th class="text-center small">GROSS</th>
                                    <th width="3%" class="text-center small">DISC %</th>
                                    <th class="text-center small">DISC Rp</th>
                                    <th width="4%" class="text-center small">PPN</th>
                                    <th class="text-center small">FAKTUR</th>
                                    <th class="text-center small">PAJAK No.</th>
                                    <th class="text-center small">TGL FP</th>
                                    <th class="text-center small">NoReff BTB</th>
                                    <th class="text-center small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-detail">
                                </tbody>
                            </table>
                        </div>

                        <br>
                        <input type="text" id="label-deskripsi"
                               class="text-center form-control col-sm-6 font-weight-bold" disabled>
                    </div>
                </fieldset>

                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Total</legend>
                    <div class="card-body cardForm">
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">TOTAL
                                ITEM</label>
                            <input type="text" id="total-item"
                                   class="text-center form-control form-control-sm col-sm-2" disabled>
                            <label class="col-sm-1 col-form-label text-sm-right offset-3"
                                   style="font-size: 12px">GROSS</label>
                            <input type="text" id="gross"
                                   class="text-center form-control form-control-sm col-sm-2" disabled>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6" style="font-size: 12px">POTONGAN</label>
                            <input type="text" id="potongan"
                                   class="text-center form-control form-control-sm col-sm-2" disabled>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6"
                                   style="font-size: 12px">PPN</label>
                            <input type="text" id="ppn"
                                   class="text-center form-control form-control-sm col-sm-2" disabled>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6"
                                   style="font-size: 12px">TOTAL</label>
                            <input type="text" id="total"
                                   class="text-center form-control form-control-sm col-sm-2" disabled>
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
        .input-group-text{
            background-color: white;
        }
    </style>


    <script>

        $(document).ready(function () {
            reset();
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

        function reset() {
            $('#body-table-header').empty();
            $('#body-table-detail').empty();
            $('#btnHapusDokumen').attr('disabled', true);
            $('#btnUsulanRetur').attr('disabled', true);

            $('#txtKdSupplier').val('');
            $('#txtNmSupplier').val('');
            $('#txtPKP').val('');
            $('#txtModel').val('');
        }

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
                                reset();
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

                                    $('#body-table-header').append('<tr>' +
                                        '<td><button class="btn btn-block btn-sm btn-danger btn-delete-row-header"><i class="icon fas fa-times"></i></button></td>' +
                                        '<td><div class="input-group input-group-sm">\n' +
                                        '    <input type="text" class="form-control" placeholder="PLU" aria-describedby="btnGroupAddon2">\n' +
                                        '    <div class="input-group-prepend">\n' +
                                        '      <div class="input-group-text p-0" ><button class="btn btn-sm btn-primary m-0">?</button></div>\n' +
                                        '    </div>\n' +
                                        '  </div></td>' +
                                        '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                        '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                        '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                        '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                        '<td><input class="form-control form-control-sm" type="text"></td>' +
                                        '<td><input class="form-control form-control-sm" type="text"></td>' +
                                        '<td><input class="form-control form-control-sm" type="text"></td>' +
                                        '</tr>');

                                    // $('#body-table-detail').append('<tr style="cursor:pointer;" class="row-detail">' +
                                    //     '<td><input class="form-control form-control-sm" type="text" value="' + plu + '"></td>' +
                                    //     '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input disabled class="form-control form-control-sm" type="text"></td>' +
                                    //     '<td><input class="form-control form-control-sm" type="text"></td>' +
                                    //     '</tr>');
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
                        reset();
                    },
                    success: function (response) {
                        $('#btnHapusDokumen').attr('disabled', false);
                        $('#btnUsulanRetur').attr('disabled', false);


                        console.log(response);
                        $('#modal-loader').modal('hide');
                        $('#txtModel').val(response.model);

                        var datas = response.datas;
                        $('#dtTglDoc').val(response.tgldoc);
                        $('#txtKdSupplier').val(response.supplier);
                        $('#txtNmSupplier').val(response.nmsupplier);
                        $('#txtPKP').val(response.pkp);

                        var datas_header = response.datas_header;
                        datas_header.forEach(function (dh) {
                            var plu = dh.h_plu == null ? '' : dh.h_plu;
                            var deskripsi = dh.h_deskripsi == null ? '' : dh.h_deskripsi;
                            var satuan = dh.h_satuan == null ? '' : dh.h_satuan;
                            var bkp = dh.h_bkp == null ? '' : dh.h_bkp;
                            var stock = dh.h_stock == null ? '' : dh.h_stock;
                            var ctn = dh.h_ctn == null ? '' : dh.h_ctn;
                            var pcs = dh.h_pcs == null ? '' : dh.h_pcs;
                            var ket = dh.h_ket == null ? '' : dh.h_ket;

                            $('#body-table-header').append('<tr>' +
                                '<td><button class="btn btn-block btn-sm btn-danger btn-delete-row-header"><i class="icon fas fa-times"></i></button></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + plu + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + deskripsi + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + satuan + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + bkp + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + stock + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + ctn + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + pcs + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + ket + '"></td>' +
                                '</tr>');
                        });

                        var datas_detail = response.datas_detail;
                        var i = 1;
                        var tot_gross = 0;
                        var tot_potongan = 0;
                        var tot_ppn = 0;
                        var tot_total = 0;
                        datas_detail.forEach(function (dd) {
                            var plu = dd.plu == null ? '' : dd.plu;
                            var desk = dd.desk == null ? '' : dd.desk;
                            var deskripsi = dd.deskripsi == null ? '' : dd.deskripsi;
                            var satuan = dd.satuan == null ? '' : dd.satuan;
                            var bkp = dd.bkp == null ? '' : dd.bkp;
                            var stock = dd.stok == null ? '' : dd.stok;
                            var hrgsatuan = dd.hrgsatuan == null ? '' : dd.hrgsatuan;
                            var ctn = dd.ctn == null ? '' : dd.ctn;
                            var pcs = dd.pcs == null ? '' : dd.pcs;
                            var gross = dd.gross == null ? '' : dd.gross;
                            var discper = dd.discper == null ? '' : dd.discper;
                            var discrp = dd.discrp == null ? '' : dd.discrp;
                            var ppn = dd.ppn == null ? '' : dd.ppn;
                            var faktur = dd.faktur == null ? '' : dd.faktur;
                            var pajakno = dd.pajakno == null ? '' : dd.pajakno;
                            var tglfp = dd.tglfp == null ? '' : dd.tglfp;
                            var noreffbtb = dd.noreffbtb == null ? '' : dd.noreffbtb;
                            var keterangan = dd.keterangan == null ? '' : dd.keterangan;
                            var pkp = dd.pkp == null ? '' : dd.pkp;
                            var frac = dd.frac == null ? '' : dd.frac;
                            var unit = dd.unit == null ? '' : dd.unit;

                            $('#body-table-detail').append('<tr style="cursor:pointer;" class="row-detail row-detail-' + i + '" deskripsi="' + deskripsi + '">' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + plu + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + desk + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + satuan + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + bkp + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + stock + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + hrgsatuan + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + ctn + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + pcs + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + gross + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + discper + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + discrp + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + ppn + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + faktur + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + pajakno + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + tglfp + '"></td>' +
                                '<td><input disabled class="form-control form-control-sm" type="text" value="' + noreffbtb + '"></td>' +
                                '<td><input class="form-control form-control-sm" type="text" value="' + keterangan + '"></td>' +
                                '</tr>');
                            i++;
                            tot_gross += parseFloat(gross);
                            tot_potongan += parseFloat(discrp);
                            tot_ppn += parseFloat(ppn);
                        });
                        tot_total = tot_gross - tot_potongan + tot_ppn;

                        $('#gross').val(convertToRupiah2(tot_gross));
                        $('#potongan').val(convertToRupiah2(tot_potongan));
                        $('#ppn').val(convertToRupiah2(tot_ppn));
                        $('#total').val(convertToRupiah2(tot_total));
                        $('#total-item').val(convertToRupiah2(i - 1));

                        // if
                        $('.btn-delete-row-header').attr('disabled', true);

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

        $(document).on('click', '.row-detail', function () {
            var currentElement = $(this);
            $('.row-detail').css('background-color', '');
            currentElement.css('background-color', 'lightgray');

            var deskripsi = currentElement.attr('deskripsi');
            $('#label-deskripsi').val(deskripsi);
        });
    </script>


@endsection