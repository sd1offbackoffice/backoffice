@extends('navbar')
@section('title','Input Pengeluaran')
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
                                    {{--<div class="form-group row mb-0 ">--}}
                                    {{--<label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">I0519</label>--}}
                                    {{--<label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">000390</label>--}}
                                    {{--</div>--}}
                                    <div class="form-group row mb-0 ">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">NOMOR
                                            TRN</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" class="form-control" id="txtNoDoc">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov_trn"
                                                    data-toggle="modal" id="btn-lov-trn">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="col-sm-2 col-form-label text-sm-right" style="font-size: 12px">
                                            Reff NRB Batal
                                        </label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" class="form-control" id="txtNrb">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov_nrb"
                                                    data-toggle="modal" id="btn-lov-trn">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" id="btnHapusDokumen"
                                                    class="btn btn-danger float-left" disabled><i
                                                    class="icon fas fa-trash"></i> Hapus Dokumen
                                            </button>
                                        </div>
                                        <div class=" col-sm-2">
                                            <button type="button" id="btnSimpan" class="btn btn-primary"><i
                                                    class="icon fas fa-save"></i> Simpan
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0 ">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">TANGGAL</label>
                                        <div class="col-sm-2">
                                            <input type="text" id="dtTglDoc"
                                                   class="form-control">
                                        </div>

                                        <div class="col-sm-3">
                                            <input type="text" id="txtModel"
                                                   class="text-center form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">SUPPLIER</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" class="form-control" id="txtKdSupplier">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov_supplier"
                                                    data-toggle="modal" id="btn-lov-trn">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <div class=" col-sm-4">
                                            <input type="text" id="txtNmSupplier"
                                                   class="form-control" disabled>
                                        </div>
                                        <label class="col-form-label text-sm-right col-sm-1"
                                               style="font-size: 12px">PKP</label>
                                        <div class="col-sm-1">
                                            <input type="text" id="txtPKP"
                                                   class="form-control text-center" disabled>
                                        </div>
                                        <div class="offset-1 col-sm-2">
                                            <button type="button" id="btnUsulanRetur" data-target="#m_usulan_retur"
                                                    data-toggle="modal" class="btn btn-info"><i
                                                    class="icon fas fa-upload"></i> Usulan Retur
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-dark card-hdr cardForm">
                    <legend class="w-auto ml-5"> Header</legend>

                    <div class="card-body">
                        <div class="card-body p-0 tableFixedHeader" style="height: 250px;">
                            <table class="table table-sm table-striped table-bordered "
                                   id="table-header">
                                <thead class="theadDataTables">
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small"></th>
                                    <th width="9%" class="text-center small">PLU</th>
                                    <th width="29%" class="text-center small">DESKRIPSI</th>
                                    <th width="7%" class="text-center small">SATUAN</th>
                                    <th width="7%" class="text-center small">BKP</th>
                                    <th width="7%" class="text-center small">STOCK</th>
                                    <th width="7%" class="text-center small">CTN</th>
                                    <th width="7%" class="text-center small">PCS</th>
                                    <th width="20%" class="text-center small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-header">
                                </tbody>
                            </table>
                        </div>

                        <button type="button" class="col-12 btn btn-primary" id="btnAddRow">+ Tambah Row</button>
                    </div>
                </fieldset>

                <fieldset class="card border-dark  card-dtl">
                    <legend class="w-auto ml-5">Detail</legend>
                    <div class="card-body cardForm">
                        <div class="card-body p-0 tableFixedHeader">
                            <table class="table table-sm table-striped table-bordered"
                                   id="table-detail">
                                <thead class="theadDataTables">
                                <tr class="table-sm text-center">
                                    <th width="7%" class="text-center small">PLU</th>
                                    <th width="16%" class="text-center small">DESKRIPSI</th>
                                    <th width="6%" class="text-center small">SATUAN</th>
                                    <th width="3%" class="text-center small">BKP</th>
                                    <th width="4%" class="text-center small">STOCK</th>
                                    <th width="7%" class="text-center small">HRG.SATUAN (IN CTN)</th>
                                    <th width="3%" class="text-center small">CTN</th>
                                    <th width="3%" class="text-center small">PCS</th>
                                    <th width="7%" class="text-center small">GROSS</th>
                                    <th width="4%" class="text-center small">DISC %</th>
                                    <th width="7%" class="text-center small">DISC Rp</th>
                                    <th width="4%" class="text-center small">PPN %</th>
                                    <th width="4%" class="text-center small">PPN</th>
                                    <th width="6%" class="text-center small">FAKTUR</th>
                                    <th width="7%" class="text-center small">PAJAK No.</th>
                                    <th width="6%" class="text-center small">TGL FP</th>
                                    <th width="6%" class="text-center small">NoReff BTB</th>
                                    <th width="5%" class="text-center small">KETERANGAN</th>
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
                                   class="text-center form-control  col-sm-2" disabled>
                            <label class="col-sm-1 col-form-label text-sm-right offset-3"
                                   style="font-size: 12px">GROSS</label>
                            <input type="text" id="gross"
                                   class="text-center form-control  col-sm-2" disabled>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6" style="font-size: 12px">POTONGAN</label>
                            <input type="text" id="potongan"
                                   class="text-center form-control  col-sm-2" disabled>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6"
                                   style="font-size: 12px">PPN</label>
                            <input type="text" id="ppn"
                                   class="text-center form-control  col-sm-2" disabled>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6"
                                   style="font-size: 12px">TOTAL</label>
                            <input type="text" id="total"
                                   class="text-center form-control  col-sm-2" disabled>
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

    {{--MODAL PLU--}}
    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                                <table class="table" id="table_lov_plu">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>PLU</td>
                                        <td>Deskripsi</td>
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

    <div class="modal fade" id="m_usulan_retur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Usulan Retur Melebihi Batas Retur</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row mb-0 ">
                            <label class="col-sm-2 col-form-label text-sm-right" style="font-size: 12px">No. Dok</label>
                            <div class="col-sm-3">
                                <input type="text" id="txt-usl-nodok" class="text-center form-control" disabled>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" id="txt-usl-status" class="text-center form-control" disabled>
                            </div>
                        </div>
                        <div class="form-group row mb-0 ">
                            <label class="col-sm-2 col-form-label text-sm-right"
                                   style="font-size: 12px">Supplier</label>
                            <div class="col-sm-2">
                                <input type="text" id="txt-usl-kode-supplier" class="text-center form-control" disabled>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" id="txt-usl-nama-supplier" class="text-center form-control" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right"
                                   style="font-size: 12px;text-align: right">PKP</label>
                            <div class="col-sm-2">
                                <input type="text" id="txt-usl-pkp" class="text-center form-control" disabled>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col lov">
                                <div class="card-body p-0 tableFixedHeader">
                                    <table class="table table-striped table-bordered"
                                           id="table-detail">
                                        <thead class="theadDataTables">
                                        <tr class="table-sm text-center">
                                            <th class="text-center small">PRDCD</th>
                                            <th class="text-center small">DESKRIPSI</th>
                                            <th class="text-center small">QTY YG BISA RETUR</th>
                                            <th class="text-center small">*QTY USULAN</th>
                                        </tr>
                                        </thead>
                                        <tbody id="body-table-usulan">
                                        <div class="col-sm-5">
                                            <input type="text" id="txt_prdcd" class="text-center form-control" disabled>
                                        </div>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center row">
                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                    class="icon fas fa-times"></i> CANCEL
                            </button>
                        </div>

                        <label class="col-sm-2 col-form-label text-sm-right"
                               style="font-size: 12px;text-align: right">One Time Password</label>
                        <div class="col-sm-3">
                            <input type="text" id="txt-usl-otp" class="text-center form-control">
                        </div>
                        <div class="col-sm-5">
                            <button type="button" class="btn btn-primary" id="btnKirimUsulan" data-dismiss="modal"><i
                                    class="icon fas fa-upload"></i> KIRIM USULAN KE FINANCE
                            </button>
                        </div>

                    </div>
                    <div class="row">
                        <label class="col-sm col-form-label text-danger text-left"
                               style="font-size: 12px">*Qty usulan adalah qty yang diinput oleh user
                            dengan batasan qty maksimal dari semua nomor referensi BPB yang ada</label>
                    </div>
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
        let rowheader;
        let row = 1;
        let kdsup = '';
        let arrDeletedPlu = []
        let datas_detail = []
        let datas_header = []

        $(document).ready(function () {
            reset();
            $('#dtTglDoc').datepicker({
                "dateFormat": "dd/mm/yy",
                "setDate": new Date()
            });
            $('#btnAddRow').hide();

            if ($('.txt-usl-status').val() === 'USULAN DISETUJUI') {
                $('#btnKirimUsulan').attr('disabled', true);
            }
        });

        function convertRupiah(value) {
            let numString = value.toString()
            let splitVal = numString.split('.')
            let mainVal = splitVal[0]

            let sisa = mainVal.length % 3
            let rupiah = mainVal.substr(0, sisa)
            let ribuan = mainVal.substr(sisa).match(/\d{3}/g)

            if(ribuan){
                separator = sisa ? ',' : '';
                rupiah += separator + ribuan.join(',');
            }

            if (splitVal.length > 1) {
                let koma = splitVal[1]
                let fixedKoma = koma.substr(0, 2)

                let fixedRupiah = rupiah + '.' + fixedKoma
                return fixedRupiah
            } else {
                return rupiah
            }
        }

        $('#txtNoDoc').keypress(function (e) {
            if (e.keyCode == 13) {
                let nodoc = $(this).val();
                getDataTrn(nodoc);
            }
        });

        $('#txtKdSupplier').keypress(function (e) {
            if (e.keyCode == 13) {
                kdsup = $('#txtKdSupplier').val();
                getDataSupplier(kdsup);
            }
        });

        $(document).on('click', '.card-hdr,.card-dtl', function () {
            if ($('#txtKdSupplier').val() == '' && $('#txtNoDoc').val() != '' && $('#dtTglDoc').val() != '') {
                $('#txtKdSupplier').focus();
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
            "processing": true,
            "serverSide": true,
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('row-lov-trn').css({'cursor': 'pointer'});
            },
            "order": []
        });

        $(document).on('click', '.row-lov-trn', function () {
            let currentButton = $(this);
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
            "processing": true,
            "serverSide": true,
            "createdRow": function (row, data, dataIndex) {
                $(row).addClass('row-lov-supplier').css({'cursor': 'pointer'});
            },
            "order": []
        });

        $(document).on('click', '.row-lov-supplier', function () {
            let currentButton = $(this);
            kdsup = currentButton.children().first().next().text();
            getDataSupplier(kdsup);

            $('#m_lov_supplier').modal('hide');
        });

        function getDataLovPlu(kdsup) {
            $('#table_lov_plu').DataTable().destroy()
            $('#table_lov_plu').DataTable({
                "ajax": '{{ url('/bo/transaksi/pengeluaran/input/get-data-lov-plu') }}',
                // "ajax": {
                //     "type": "GET",
                //     "url": "{{ url('/bo/transaksi/pengeluaran/input/get-data-lov-plu') }}",
                //     "data": {
                //         "kdsup": kdsup
                //     },
                // },
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
                "processing": true,
                "serverSide": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-plu').css({'cursor': 'pointer'});
                },
                "order": []
            });
        }

        $(document).on('click', '.btn-lov-plu, .plu-header', function () {
            rowheader = $(this).attr("rowheader");
        });

        $(document).on('keypress', '.plu-header', function (e) {
            if (e.keyCode == 13) {
                let temp = '';
                for (let i = 0; i < 7 - $(this).val().length; i++) {
                    temp = '0' + temp;
                }
                temp = temp + $(this).val();
                $(this).val(temp);
                let currRowHeader = $(this).attr('rowheader');
                getDataPLU(temp, currRowHeader);
            }
        });

        $(document).on('click', '.row-lov-plu', function () {
            let currentButton = $(this);
            // let currRowHeader = $(this).attr('rowheader');
            console.log(currentButton.children());
            let plu = currentButton.children().first().text();
            $(`.plu-header-${rowheader}`).val(plu);
            getDataPLU(plu, rowheader);
            $('#m_lov_plu').modal('hide');
        });

        $(document).on('click', '#btnHapusDokumen', function () {
            let nodoc = $('#txtNoDoc').val();
            swal({
                title: 'Hapus No Doc ' + nodoc + ' ?',
                text: 'Tekan Tombol OK untuk Melanjutkan!',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((yes) => {
                if (yes) {
                    ajaxSetup();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/bo/transaksi/pengeluaran/input/delete') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {nodoc: $('#txtNoDoc').val()},
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: response.title,
                                text: response.message,
                                icon: response.status
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            // handle error
                            swal({
                                title: 'Terjadi kesalahan!',
                                text: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    });
                } else {
                    return false;
                }
            });
        });





        function getDataPLU(plu, rowheader) {
            if (kdsup == '' || kdsup == null) {
                swal({
                    title: 'Info',
                    text: 'Tentukan Supplier Terlebih dahulu',
                    icon: 'warning'
                }).then(() => {
                    $('#txtKdSupplier').focus();
                });
                return false;
            }
            $.ajax({
                type: "GET",
                url: "{{ url('/bo/transaksi/pengeluaran/input/get-data-plu') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    plu: plu,
                    kdsup: kdsup
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response.message) {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status
                        }).then(() => {
                        });
                    }
                    if (response.data) {
                        $(".plu-header-" + rowheader).val(response.data.st_prdcd);
                        $(".plu-header-" + rowheader).attr('max_qty', response.data.qtypb);
                        $(".deskripsi-header-" + rowheader).val(response.data.prd_deskripsipendek);
                        $(".satuan-header-" + rowheader).val(response.data.satuan);
                        $(".bkp-header-" + rowheader).val(response.data.prd_flagbkp1);
                        $(".stock-header-" + rowheader).val(response.data.st_saldoakhir);
                        $(".ctn-header-" + rowheader).focus();
                    }

                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.exception,
                        text: error.responseJSON.message,
                        icon: 'error'
                    });
                }
            });
        }

        function getDataSupplier(k) {
            kdsup = k.toUpperCase();
            $('#txtKdSupplier').val(kdsup);
            $.ajax({
                type: "GET",
                url: "{{ url('/bo/transaksi/pengeluaran/input/get-data-supplier') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    kdsup: kdsup
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    $('.plu-header-1').focus();
                    getDataLovPlu(kdsup);

                    if (response.status != 'error') {
                        namasupplier = response.result.sup_namasupplier;
                        pkp = response.result.sup_pkp;

                        $('#txtKdSupplier').val(kdsup);
                        $('#txtNmSupplier').val(namasupplier);
                        $('#txtPKP').val(pkp);
                    }                    

                    if (response.message) {                        
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status
                        }).then(() => {
                        });
                    }
                    // else {
                    //     namasupplier = response.result.sup_namasupplier;
                    //     pkp = response.result.sup_pkp;

                    //     $('#txtKdSupplier').val(kdsup);
                    //     $('#txtNmSupplier').val(namasupplier);
                    //     $('#txtPKP').val(pkp);                        
                    // }

                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.exception,
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {

                    });
                }
            });
        }

        function reset() {
            $('#body-table-header').empty();
            $('#body-table-detail').empty();
            $('#body-table-usulan').empty();
            $('#btnHapusDokumen').attr('disabled', false);
            $('#btnUsulanRetur').attr('disabled', true);
            $('#btnSimpan').attr('disabled', true);
            $('#txtKdSupplier').attr('disabled', false);

            $('#txtKdSupplier').val('');
            $('#txtNmSupplier').val('');
            $('#txtPKP').val('');
            $('#txtModel').val('');

            $('#txt-usl-pkp').val('');
            $('#txt-usl-nama-supplier').val('');
            $('#txt-usl-kode-supplier').val('');
            $('#txt-usl-status').val('');
            $('#txt-usl-nodok').val('');
            $('#txt-usl-otp').val('');

            $('#gross').val('');
            $('#total-item').val('');
            $('#potongan').val('');
            $('#ppn').val('');
            $('#total').val('');
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
                                $('#btnSimpan').attr('disabled', false);
                                $('#btnUsulanRetur').attr('disabled', false);

                                // $('#btnAddRow').modal('show');
                                $('#modal-loader').modal('hide');

                                if (response.status == 'error') {
                                    swal({
                                        title: response.status,
                                        text: response.message,
                                        icon: 'error'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                }
                                else {
                                    $('#txtNoDoc').val(response.data.no);
                                    $("#dtTglDoc").datepicker().datepicker("setDate", new Date());
                                    // $('#dtTglDoc').datepicker({
                                    //     "dateFormat": "mm/dd/yyyy",
                                    //     "setDate": new Date()
                                    // });
                                    $('#txtModel').val(response.data.model);
                                    $('#txtKdSupplier').focus();
                                    // getDataSupplier('I0519');
                                    // 0000390
                                    $('#btnAddRow').show();

                                    $('#body-table-header').append(
                                        '<tr class="row-header-1">' +
                                        '<td><button class="btn btn-block btn-danger btn-delete-row-header" rowheader="1"><i class="icon fas fa-times"></i></button></td>' +
                                        '<td class="buttonInside" style="width: 8%">' +
                                        '<input type="text" class="form-control plu-header-1 plu-header" rowheader="1">' +
                                        '<button type="button" class="btn btn-lov-plu btn-lov ml-3" rowheader="1" data-target="#m_lov_plu" data-toggle="modal">' +
                                        '<img src="../../../../public/image/icon/help.png" width="30px">' +
                                        '</button>' +
                                        '</td>' +
                                        '<td><input disabled class="form-control deskripsi-header-1" type="text"></td>' +
                                        '<td><input disabled class="form-control satuan-header satuan-header-1" type="text"></td>' +
                                        '<td><input disabled class="form-control bkp-header-1" type="text"></td>' +
                                        '<td><input disabled class="form-control stock-header-1" type="text"></td>' +
                                        '<td><input class="form-control ctn-header ctn-header-1" rowheader=1 type="text" value="0"></td>' +
                                        '<td><input class="form-control pcs-header pcs-header-1" rowheader=1 type="text" value="0"></td>' +
                                        '<td><input class="form-control keterangan-header keterangan-header-1" rowheader=1 type="text"></td>' +
                                        '</tr>');

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
                        console.log(response);
                        $('#modal-loader').modal('hide');
                        $('#btnUsulanRetur').attr('disabled', false);

                        if (response.status == 'error') {
                            swal({
                                title: response.status,
                                text: response.message,
                                icon: response.status
                            }).then(() => {
                            });
                        }
                        else {
                            if (response.model === '* NOTA SUDAH DICETAK *') {
                                $('#btnHapusDokumen').attr('disabled', true);

                            }
                            else {
                                $('#btnHapusDokumen').attr('disabled', false);

                                $('#btnSimpan').attr('disabled', false);
                                $('#btnAddRow').show();
                                getDataSupplier(response.supplier)
                            }

                            $('#txtModel').val(response.model);

                            $('#dtTglDoc').val(response.tgldoc);
                            $('#txtKdSupplier').val(response.supplier);
                            $('#txtNmSupplier').val(response.nmsupplier);
                            $('#txtPKP').val(response.pkp);

                            $('#txt-usl-nodok').val(notrn);
                            $('#txt-usl-kode-supplier').val(response.supplier);
                            $('#txt-usl-nama-supplier').val(response.nmsupplier);
                            $('#txt-usl-pkp').val(response.pkp);

                            datas_header = response.datas_header;
                            // let tempDataHeader = []
                            datas_header.forEach(function (dh, index) {
                                let plu = dh.h_plu == null ? '' : dh.h_plu;
                                let deskripsi = dh.h_deskripsi == null ? '' : dh.h_deskripsi;
                                let satuan = dh.h_satuan == null ? '' : dh.h_satuan;
                                let bkp = dh.h_bkp == null ? '' : dh.h_bkp;
                                let stock = dh.h_stock == null ? '' : dh.h_stock;
                                let ctn = dh.h_ctn == null ? '' : dh.h_ctn;
                                let pcs = dh.h_pcs == null ? '' : dh.h_pcs;
                                let ket = dh.h_ket == null ? '' : dh.h_ket;
                                let frac = dh.h_frac == null ? '' : dh.h_frac;

                                // if (index != 0) {
                                //     ctn += ctn[index-1]
                                //     pcs += pcs[index-1]
                                // }
                                // let data = {}
                                // data.trbo_prdcd

                                    $('#body-table-header').append(
                                        `<tr class="row-header-${index+1}">` +
                                            `<td><button class="btn btn-block btn-danger btn-delete-row-header" rowheader="${index+1}"><i class="icon fas fa-times"></i></button></td>` +
                                            `<td class="buttonInside" style="width: 8%">` +
                                                `<input type="text" class="form-control plu-header-${index+1} plu-header" rowheader="${index+1}" value="${plu}">` +
                                                `<button type="button" class="btn btn-lov-plu btn-lov ml-3" rowheader="${index+1}" data-target="#m_lov_plu" data-toggle="modal">` +
                                                `<img src="../../../../public/image/icon/help.png" width="30px">` +
                                                `</button>` +
                                            `</td>` +
                                            `<td><input disabled class="form-control deskripsi-header-${index+1}" type="text" value="${deskripsi}"></td>` +
                                            `<td><input disabled class="form-control satuan-header satuan-header-${index+1}" type="text" value="${satuan}"></td>` +
                                            `<td><input disabled class="form-control bkp-header-${index+1}" type="text" value="${bkp }"></td>` +
                                            `<td><input disabled class="form-control stock-header-${index+1}" type="text" value="${stock}"></td>` +
                                            `<td><input class="form-control ctn-header ctn-header-${index+1}" rowheader="${index+1}" type="text" value="${ctn}"></td>` +
                                            `<td><input class="form-control pcs-header pcs-header-${index+1}" rowheader="${index+1}" type="text" value="${pcs}"></td>` +
                                            `<td><input class="form-control keterangan-header keterangan-header-${index+1}" rowheader="${index+1}" type="text" value="${ket}"></td>` +
                                        `</tr>`);
                            });

                            // console.log(`total ctn: ` + ctn);
                            // console.log(`total pcs: ` + pcs);

                            // if (datas_detail !== null) {
                            //     datas_detail.push(response.datas_detail)
                            // } else {
                            //     datas_detail = response.datas_detail;
                            // }
                            datas_detail = response.datas_detail;
                            console.log(datas_detail);

                            let i = 1;
                            let tot_gross = 0;
                            let tot_potongan = 0;
                            let tot_ppn = 0;
                            let tot_total = 0;
                            datas_detail.forEach(function (dd, index) {
                                let plu = dd.trbo_prdcd == null ? '' : dd.trbo_prdcd;
                                let desk = dd.desk == null ? '' : dd.desk;
                                let deskripsi = dd.deskripsi == null ? '' : dd.deskripsi;
                                let satuan = dd.satuan == null ? '' : dd.satuan;
                                let bkp = dd.bkp == null ? '' : dd.bkp;
                                let stock = dd.trbo_posqty == null ? '' : dd.trbo_posqty;
                                let hrgsatuan = dd.trbo_hrgsatuan == null ? '' : dd.trbo_hrgsatuan;
                                let ctn = dd.qtyctn == null ? '' : dd.qtyctn;
                                let pcs = dd.qtypcs == null ? '' : dd.qtypcs;
                                let gross = dd.trbo_gross == null ? '' : dd.trbo_gross;
                                let discper = dd.discper == null ? '' : dd.discper;
                                let discrp = dd.trbo_discrph == null ? '' : dd.trbo_discrph;
                                let persen_ppn = dd.trbo_persenppn == null ? '' : dd.trbo_persenppn;
                                let ppn = dd.trbo_ppnrph == null ? '' : dd.trbo_ppnrph;
                                let faktur = dd.trbo_istype == null ? '' : dd.trbo_istype;
                                let pajakno = dd.trbo_inv == null ? '' : dd.trbo_inv;
                                let tglfp = dd.trbo_tgl == null ? '' : dd.trbo_tgl;
                                let noreffbtb = dd.trbo_noreff == null ? '' : dd.trbo_noreff;
                                let keterangan = dd.keterangan == null ? '' : dd.keterangan;
                                let pkp = dd.pkp == null ? '' : dd.pkp;
                                let frac = dd.frac == null ? '' : dd.frac;
                                let unit = dd.unit == null ? '' : dd.unit;

                                $('#body-table-detail').append('<tr style="cursor:pointer;" class="row-detail row-detail-' + (index+1) + '" deskripsi="' + deskripsi + '">' +
                                '<td><input disabled class="form-control plu" type="text" value="' + plu + '"></td>' +
                                '<td><input disabled class="form-control " type="text" value="' + desk + '"></td>' +
                                '<td><input disabled class="form-control satuan" type="text" value="' + satuan + '"></td>' +
                                '<td><input disabled class="form-control bkp" type="text" value="' + bkp + '"></td>' +
                                '<td><input disabled class="form-control posqty" type="text" value="' + stock + '"></td>' +
                                '<td><input disabled class="form-control hargasatuan" type="text" value="' + convertRupiah(hrgsatuan) + '"></td>' +
                                '<td><input disabled class="form-control qtyctn" type="text" value="' + convertRupiah(ctn) + '"></td>' +
                                '<td><input disabled class="form-control qtypcs" type="text" value="' + convertRupiah(pcs) + '"></td>' +
                                '<td><input disabled class="form-control gross" type="text" value="' + convertRupiah(gross) + '"></td>' +
                                '<td><input disabled class="form-control persendisc" type="text" value="' + discper + '"></td>' +
                                '<td><input disabled class="form-control discrph" type="text" value="' + convertRupiah(discrp) + '"></td>' +
                                '<td><input disabled class="form-control persen_ppn" type="text" value="' + persen_ppn + '"></td>' +
                                '<td><input disabled class="form-control ppn" type="text" value="' + convertRupiah(ppn) + '"></td>' +
                                '<td><input disabled class="form-control istype" type="text" value="' + faktur + '"></td>' +
                                '<td><input disabled class="form-control invno" type="text" value="' + pajakno + '"></td>' +
                                '<td><input disabled class="form-control tglinv" type="text" value="' + tglfp + '"></td>' +
                                '<td><input disabled class="form-control noreff" type="text" value="' + noreffbtb + '"></td>' +
                                '<td><input disabled class="form-control keterangan" type="text" value="' + keterangan + '"></td>' +
                                '</tr>');

                                index++;
                                tot_gross += parseFloat(gross);
                                tot_potongan += parseFloat(discrp);
                                tot_ppn += parseFloat(ppn);
                            });
                            tot_total = parseFloat(tot_gross) - parseFloat(tot_potongan) + parseFloat(tot_ppn);

                            $('#gross').val(convertRupiah(tot_gross));
                            $('#potongan').val(convertRupiah(tot_potongan));
                            $('#ppn').val(convertRupiah(tot_ppn));
                            $('#total').val(convertRupiah(tot_total));
                            $('#total-item').val(datas_detail.length);

                            // if
                            // $('.btn-delete-row-header').attr('disabled', true);
                            if (response.model === '* NOTA SUDAH DICETAK *') {
                                $('.btn-delete-row-header').attr('disabled', true);
                            } else {
                                $('.btn-delete-row-header').attr('disabled', false);
                            }

                            if (response.model == '* NOTA SUDAH DICETAK *') {
                                $('.card-hdr input').attr('disabled', true);
                                $('.card-dtl input').attr('disabled', true);
                                $('#txtKdSupplier').attr('disabled', true);
                                $('#dtTglDoc').attr('disabled', true);
                            }
                            if (response.status == 'info') {
                                swal({
                                    title: response.status,
                                    text: response.message,
                                    icon: response.status
                                }).then(() => {
                                });
                            }
                        }

                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        // handle error
                        console.log(error);
                    }
                });
            }

        }

        $(document).on('click', '.btn-delete-row-header', function (e) {
            let current = $(this);
            let rh = current.attr('rowheader');
            let nodoc = $('#txtNoDoc').val();
            let headerPlu = $(this).parents('tr').find('.plu-header').val()
            // let model = $('#txtModel').val();
            // console.log('headerPlu: ' + headerPlu);
            ajaxSetup();
            $.ajax({
                type: "GET",
                url: "{{ url('/bo/transaksi/pengeluaran/input/check-usul-lebih') }}",
                data: {
                    plu: headerPlu,
                    nodoc: nodoc
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },          
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response.status == 'SUCCESS') {
                        
                    }
                }
            });

            datas_detail = datas_detail.filter(dd => dd.trbo_prdcd !== `${headerPlu}`)
            console.log(datas_detail);

            // if (model == '* KOREKSI *') {
            //     arrDeletedPlu.push(headerPlu)
            // }

            $('#body-table-header tr').each(function () {
                let plu = $(this).find('.plu-header').val();

                if (plu == headerPlu) {
                    $(this).remove();
                }
            });

            // $('.row-header-' + rh).empty();
            // $('.row-detail-' + rh).empty();
            // $(this).find('.plu-header');

            $('#body-table-detail tr').each(function () {
                let detailPlu = $(this).find('.plu').val();
                if (detailPlu == headerPlu) {
                    $(this).remove();
                }
            });
        });

        $(document).on('keypress', '.ctn-header', function (e) {
            if (e.keyCode == 13) {
                let nodoc = $(this).val();
                let current = $(this);
                let rh = current.attr('rowheader');
                let ctn = current.val();
                let pcs = $('.pcs-header-' + rh).val();
                let stock = $('.pcs-stock-' + rh).val();
                let satuan = $('.satuan-header-' + rh).val();
                let tempFrac = satuan.split('/');
                let frac = tempFrac[1];
                let max_qty = $('.plu-header-' + rh).attr('max_qty');

                if (ctn < 0 || ctn == '') {
                    current.val(0);
                    swal({
                        title: 'Info',
                        text: 'Quantity Carton < 0',
                        icon: 'info'
                    });
                    return false;
                }
                // ????
                if ((ctn * frac) + pcs > stock) {
                    ctn = 0;
                    current.val(ctn);
                    swal({
                        title: 'Info',
                        text: 'Quantity[' + ((ctn * frac) + pcs) + '] > Stock Retur[' + max_qty + ']',
                        icon: 'info'
                    });
                    return false;
                }
                $('.pcs-header-' + rh).focus();
            }

        });

        $(document).on('keypress', '.pcs-header, .keterangan-header', function (e) {
            if (e.keyCode == 13) {

                $('#modal-loader').modal('show');
                let current = $(this);
                let rh = current.attr('rowheader');
                let model = $('#txtModel').val();
                let nodoc = $('#txtNoDoc').val();
                let tgldoc = $('#dtTglDoc').val();
                let kdsup = $('#txtKdSupplier').val();
                let plu = $('.plu-header-' + rh).val();
                // let keteranganHeader = $('.keterangan-header-' + rh).val();
                // if (keteranganHeader == null || keteranganHeader == '') {
                //     $('.keterangan-header-' + rh).focus();
                //     return;
                // }

                let ctn = parseInt($('.ctn-header-' + rh).val());
                // check if ctn is NaN
                if (ctn !== ctn) {
                    ctn = 0;
                    $('.ctn-header-' + rh).val(ctn);
                }

                let fracTemp = $('.satuan-header-' + rh).val().split('/');
                let frac = parseInt(fracTemp[1]);
                let pcs = parseInt($('.pcs-header-' + rh).val());
                let stock = parseInt($('.stock-header-' + rh).val());
                let bkp = $('.bkp-header-' + rh).val();
                // let keterangan = $('.keterangan-header-' + rh).val();

                let message = '';
                let status = '';
                let inputan = '';
                let qtypb = '';
                let qtyretur = '';
                let qtysisa = '';

                // if (model == 'KOREKSI') {
                //     return false;
                // }
                if ($('.pcs-header-' + rh).val() < 0 || $('.pcs-header-' + rh).val() == '') {
                    $('.pcs-header-' + rh).val(0);
                    pcs = 0;
                }
                if ((ctn * frac) + pcs <= 0) {
                    message = 'QTYB + QTYK <= 0';
                    status = 'error';
                    swal({
                        title: status,
                        text: message,
                        icon: status
                    }).then(() => {
                        $('#modal-loader').modal('hide');
                    });
                    return false;
                }
                else {
                    if (stock < (ctn * frac) + pcs) {
                        inputan = (ctn * frac) + pcs;
                        message = 'Stock Barang Retur (' + stock + ') < INPUTAN (' + inputan + ') [set ctn pcs 0]';
                        status = 'error';
                        $('.ctn-header-' + rh).val(0);
                        $('.pcs-header-' + rh).val(0);
                        $('.ctn-header-' + rh).focus();
                        $('#modal-loader').modal('hide');
                        swal({
                            title: status,
                            text: message,
                            icon: status
                        }).then(() => {
                            $('#modal-loader').modal('hide');
                        });

                        return false;
                    }
                    //step 1
                    ajaxSetup();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/bo/transaksi/pengeluaran/input/cek-pcs-1') }}",
                        async: false,
                        data: {
                            plu: plu,
                            kdsup: kdsup
                        },
                        beforeSend: function () {
                        },
                        success: function (response) {
                            // console.log(response);
                            qtypb = response.data.qtypb;
                            qtyretur = response.data.qtyretur;
                            qtysisa = response.data.qtysisa;
                            // console.log(qtyretur);

                            inputan = ((ctn * frac) + pcs);

                            if (inputan > qtyretur && qtysisa == qtyretur) {
                                ctn = 0;
                                pcs = qtyretur;
                                $('.ctn-header-' + rh).val(ctn);
                                $('.pcs-header-' + rh).val(pcs);
                                // console.log(qtyretur);
                                message = 'qty plu yang bisa diretur hanya ' + qtyretur;
                                status = 'info';
                                swal({
                                    title: status,
                                    text: message,
                                    icon: status
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                });
                            }

                            if (inputan > qtyretur && qtysisa > qtyretur) {
                                if (inputan > qtysisa) {
                                    message = 'qty PLU yang bisa diretur hanya ' + qtysisa + ' [set ctn pcs 0]';
                                    status = 'info';
                                    swal({
                                        title: status,
                                        text: message,
                                        icon: status
                                    }).then(() => {
                                        $('#modal-loader').modal('hide');
                                    });
                                    return false;
                                }

                                message = 'Qty yang diretur ('
                                    + inputan
                                    + ') tidak boleh lebih dari '
                                    + qtyretur
                                    + ', untuk sisanya silahkan buat Struk Penjualan atau minta otorisasi Finance.'
                                    + 'Proses untuk otorisasi Finance?';
                                status = 'info';
                                swal({
                                    title: "Mohon dijawab.",
                                    text: message,
                                    icon: status,
                                    buttons: true,
                                    dangerMode: true,
                                }).then((confirm) => {
                                    if (confirm) {
                                        $('#modal-loader').modal('hide');
                                        if (inputan > qtysisa) {
                                            inputan = qtysisa;
                                            message = 'Qty yang bisa diretur hanya ' + qtysisa;
                                            status = 'warning';
                                            swal({
                                                title: status,
                                                text: message,
                                                icon: status
                                            }).then(() => {
                                                $('#modal-loader').modal('hide');
                                            });
                                        }

                                        ajaxSetup();
                                        $.ajax({
                                            url: "{{ url('/bo/transaksi/pengeluaran/input/cek-pcs-2') }}",
                                            type: 'Post',
                                            async: false,
                                            data: {
                                                nodoc: nodoc,
                                                plu: plu,
                                                kdsup: kdsup,
                                                tgldoc: tgldoc,
                                                bkp: bkp,
                                                inputan: inputan,
                                                qtyretur: qtyretur
                                            },
                                            beforeSend: function () {
                                                $('#modal-loader').modal('show');
                                            },
                                            success: function (response) {
                                                // console.log(response);

                                                $('#modal-loader').modal('hide');
                                            },
                                            error: function (error) {
                                                console.log(error);

                                            }
                                        });

                                        ctn = 0;
                                        pcs = qtyretur;
                                        $('.ctn-header-' + rh).val(ctn);
                                        $('.pcs-header-' + rh).val(pcs);

                                        if (model == '*TAMBAH*' || model == '* KOREKSI *') {
                                            proses(plu, ctn, frac, pcs, rh);
                                            // proses(plu, ((ctn * frac) + pcs), rh);
                                        }
                                    } else {
                                        $('#modal-loader').modal('hide');

                                        ctn = 0;
                                        pcs = 0;
                                        $('.ctn-header-' + rh).val(ctn);
                                        $('.pcs-header-' + rh).val(pcs);
                                    }
                                    
                                    // if (model == '*TAMBAH*' || model == '* KOREKSI *') {
                                    //     proses(plu, ctn, frac, pcs, rh);
                                    //     // proses(plu, ((ctn * frac) + pcs), rh);
                                    // }
                                });
                            } else {
                                ajaxSetup();
                                $.ajax({
                                    url: "{{ url('/bo/transaksi/pengeluaran/input/cek-pcs-3') }}",
                                    type: 'POST',
                                    async: false,
                                    data: {
                                        nodoc: nodoc,
                                        plu: plu
                                    },
                                    beforeSend: function () {
                                        $('#modal-loader').modal('show');
                                    },
                                    success: function (response) {
                                        $('#modal-loader').modal('hide');

                                        if (response.status == 'question') {
                                            swal({
                                                title: "Mohon dijawab.",
                                                text: response.message,
                                                icon: response.status,
                                                buttons: true,
                                                dangerMode: true,
                                            }).then((confirm) => {
                                                if (confirm) {
                                                    ajaxSetup();
                                                    $.ajax({
                                                        url: "{{ url('/bo/transaksi/pengeluaran/input/cek-pcs-4') }}",
                                                        type: 'Post',
                                                        async: false,
                                                        data: {
                                                            nodoc: nodoc,
                                                            plu: plu
                                                        },
                                                        beforeSend: function () {
                                                            $('#modal-loader').modal('show');
                                                        },
                                                        success: function (response) {
                                                            $('#modal-loader').modal('hide');
                                                            swal({
                                                                title: response.status,
                                                                text: response.message,
                                                                icon: response.status
                                                            });
                                                        }, error: function (error) {
                                                            console.log(error);
                                                        }
                                                    });

                                                }
                                            });
                                        }
                                    }, error: function (error) {
                                        console.log(error);
                                    }
                                });

                                if(model == '*TAMBAH*' || model == '* KOREKSI *') {
                                    proses(plu, ctn, frac, pcs, rh);
                                    // proses(plu, ((ctn * frac) + pcs), rh);
                                }
                            }

                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            // handle error
                            console.log(error);

                        }
                    });


                }
                // $('#modal-loader').modal('hide');
            }
        });

        function proses(plu, ctn, frac, pcs, rh) {
            let nodoc = $('#txtNoDoc').val();
            let pkp = $('#txtPKP').val();
            let keterangan = $('.keterangan-header-' + rh).val();
            let qtyretur = (ctn * frac) + pcs

            $('#body-table-detail tr').each(function () {
                let detailPlu = $(this).find('.plu').val();
                if (detailPlu == plu) {
                    datas_detail = datas_detail.filter(dd => dd.trbo_prdcd !== `${plu}`)
                    $(this).remove();
                }
            });

            ajaxSetup();
            $.ajax({
                url: "{{ url('/bo/transaksi/pengeluaran/input/proses') }}",
                type: 'POST',
                data: {
                    qtyretur: qtyretur,
                    p_prdcd: plu,
                    nodoc: nodoc,
                    pkp: pkp,
                    keterangan: keterangan
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    let detail = response.datas;
                    detail.forEach(i => {
                        datas_detail.push(i)
                    });
                    console.log(datas_detail);
                    let ctn = Math.floor(qtyretur / frac)
                    let qtypcs = qtyretur % frac
                    $(`.ctn-header-${rh}`).val(ctn);
                    $(`.pcs-header-${rh}`).val(qtypcs);



                    if (datas_detail.length > 0) {
                        // console.log(response);
                        $('#body-table-detail tr').each(function () {
                            $(this).remove()
                        });

                        let tot_gross = 0;
                        let tot_potongan = 0;
                        let tot_ppn = 0;
                        datas_detail.forEach(function (dd) {
                            $('#body-table-detail').append('<tr style="cursor:pointer;" class="row-detail row-detail-' + rowheader + '" deskripsi="' + dd.deskripsi + '">' +
                                '<td><input disabled class="form-control plu" type="text" value="' + dd.trbo_prdcd + '"></td>' +
                                '<td><input disabled class="form-control " type="text" value="' + dd.desk + '"></td>' +
                                '<td><input disabled class="form-control satuan" type="text" value="' + dd.satuan + '"></td>' +
                                '<td><input disabled class="form-control bkp" type="text" value="' + dd.bkp + '"></td>' +
                                '<td><input disabled class="form-control posqty" type="text" value="' + dd.trbo_posqty + '"></td>' +
                                '<td><input disabled class="form-control hargasatuan" type="text" value="' + convertRupiah(dd.trbo_hrgsatuan) + '"></td>' +
                                '<td><input disabled class="form-control qtyctn" type="text" value="' + dd.qtyctn + '"></td>' +
                                '<td><input disabled class="form-control qtypcs" type="text" value="' + dd.qtypcs + '"></td>' +
                                '<td><input disabled class="form-control gross" type="text" value="' + convertRupiah(dd.trbo_gross) + '"></td>' +
                                '<td><input disabled class="form-control persendisc" type="text" value="' + dd.discper + '"></td>' +
                                '<td><input disabled class="form-control discrph" type="text" value="' + convertRupiah(dd.trbo_discrph) + '"></td>' +
                                '<td><input disabled class="form-control persen_ppn" type="text" value="' + dd.persen_ppn + '"></td>' +
                                '<td><input disabled class="form-control ppn" type="text" value="' + convertRupiah(dd.trbo_ppnrph) + '"></td>' +
                                '<td><input disabled class="form-control istype" type="text" value="' + dd.trbo_istype + '"></td>' +
                                '<td><input disabled class="form-control invno" type="text" value="' + dd.trbo_inv + '"></td>' +
                                '<td><input disabled class="form-control tglinv" type="text" value="' + dd.trbo_tgl + '"></td>' +
                                '<td><input disabled class="form-control noreff" type="text" value="' + dd.trbo_noreff + '"></td>' +
                                '<td><input disabled class="form-control keterangan" type="text" value="' + dd.trbo_keterangan + '"></td>' +
                                '</tr>');

                            tot_gross += parseFloat(dd.trbo_gross);
                            tot_potongan += parseFloat(dd.trbo_discrph);
                            tot_ppn += parseFloat(dd.trbo_ppnrph);
                        });

                        row++;                        
                        
                        tot_total = parseFloat(tot_gross) - parseFloat(tot_potongan) + parseFloat(tot_ppn);
                        $('#gross').val(convertRupiah(tot_gross));
                        $('#potongan').val(convertRupiah(tot_potongan));
                        $('#ppn').val(convertRupiah(tot_ppn));
                        $('#total').val(convertRupiah(tot_total));
                        $('#total-item').val(datas_detail.length);
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        }

        $(document).on('click', '.row-detail', function () {
            let currentElement = $(this);
            $('.row-detail').css('background-color', '');
            currentElement.css('background-color', 'lightgray');

            let deskripsi = currentElement.attr('deskripsi');
            $('#label-deskripsi').val(deskripsi);
        });

        $(document).on('keyup', '#txt-usl-otp', function (e) {
            let currentElement = $(this);
            if (e.keyCode == 13) {
                let nodoc = $('#txtNoDoc').val();
                let otp = currentElement.val();
                let tgldoc = $('#dtTglDoc').val();
                let kdsup = $('#txtKdSupplier').val();
                let pkp = $('#txtPKP').val();
                let datas = [];

                $('#body-table-usulan tr').each(function () {
                    let data = {};
                    data.prdcd = $(this).find(".usl-prdcd").val();
                    data.qty = $(this).find(".usl-qty").val();
                    datas.push(data);
                });

                let datah = [];
                $('#body-table-header tr').each(function () {
                    let data = {};

                    data.plu = $(this).find(".plu-header").val();
                    data.ctn = $(this).find(".ctn-header").val();
                    data.qty = $(this).find(".pcs-header").val();
                    satuan = $(this).find(".satuan-header").val();
                    split_satuan = satuan.split('/');
                    data.frac = split_satuan[1];
                    datah.push(data);
                });

                let datad = [];
                $('#body-table-detail tr').each(function () {
                    let data = {};

                    data.plu = $(this).find(".plu").val();
                    data.ctn = $(this).find(".qtyctn").val();
                    data.qty = $(this).find(".qtypcs").val();

                    data.noreff = $(this).find(".noreff").val();
                    data.istype = $(this).find(".istype").val();
                    data.invno = $(this).find(".invno").val();
                    data.tglinv = $(this).find(".tglinv").val();
                    data.kdsup = kdsup;
                    data.plu = $(this).find(".plu").val();
                    data.ctn = $(this).find(".qtyctn").val();
                    data.qty = $(this).find(".qtypcs").val();
                    data.hargasatuan = $(this).find(".hargasatuan").val();
                    data.persendisc = $(this).find(".persendisc").val();
                    data.gross = parseFloat($(this).find(".gross").val());
                    data.discrph = parseFloat($(this).find(".discrph").val());
                    data.ppnrph = parseFloat($(this).find(".ppn").val());
                    data.posqty = parseFloat($(this).find(".posqty").val());
                    data.keterangan = $(this).find(".keterangan").val();
                    datad.push(data);
                });

                ajaxSetup();
                $.ajax({
                    url: "{{ url('/bo/transaksi/pengeluaran/input/cek-OTP') }}",
                    type: 'POST',
                    async: false,
                    data: {
                        nodoc: nodoc,
                        datas: datas,
                        datah: datah,
                        datad: datad,
                        otp: otp,
                        kdsup: kdsup,
                        tgldoc: tgldoc,
                        pkp: pkp,
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if (response.status == 'error') {
                            $('#txt-usl-otp').val('');
                        }
                        else {
                            // let datas_header = response.datah;
                            // datas_header.forEach(function (dh) {
                            //     let plu = dh.h_plu == null ? '' : dh.h_plu;
                            //     let deskripsi = dh.h_deskripsi == null ? '' : dh.h_deskripsi;
                            //     let satuan = dh.h_satuan == null ? '' : dh.h_satuan;
                            //     let bkp = dh.h_bkp == null ? '' : dh.h_bkp;
                            //     let stock = dh.h_stock == null ? '' : dh.h_stock;
                            //     let ctn = dh.h_ctn == null ? '' : dh.h_ctn;
                            //     let pcs = dh.h_pcs == null ? '' : dh.h_pcs;
                            //     let ket = dh.h_ket == null ? '' : dh.h_ket;

                            //     $('#body-table-header').append('<tr>' +
                            //         '<td><button class="btn btn-block btn-danger btn-delete-row-header"><i class="icon fas fa-times"></i></button></td>' +
                            //         '<td><input class="form-control " type="text" value="' + plu + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + deskripsi + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + satuan + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + bkp + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + stock + '"></td>' +
                            //         '<td><input class="form-control " type="text" value="' + ctn + '"></td>' +
                            //         '<td><input class="form-control " type="text" value="' + pcs + '"></td>' +
                            //         '<td><input class="form-control " type="text" value="' + ket + '"></td>' +
                            //         '</tr>');
                            // });

                            // let datas_detail = response.datad;
                            // let i = 1;
                            // let tot_gross = 0;
                            // let tot_potongan = 0;
                            // let tot_ppn = 0;
                            // let tot_total = 0;
                            // datas_detail.forEach(function (dd) {
                            //     let plu = dd.plu == null ? '' : dd.plu;
                            //     let desk = dd.desk == null ? '' : dd.desk;
                            //     let deskripsi = dd.deskripsi == null ? '' : dd.deskripsi;
                            //     let satuan = dd.satuan == null ? '' : dd.satuan;
                            //     let bkp = dd.bkp == null ? '' : dd.bkp;
                            //     let stock = dd.stok == null ? '' : dd.stok;
                            //     let hrgsatuan = dd.hrgsatuan == null ? '' : dd.hrgsatuan;
                            //     let ctn = dd.ctn == null ? '' : dd.ctn;
                            //     let pcs = dd.pcs == null ? '' : dd.pcs;
                            //     let gross = dd.gross == null ? '' : dd.gross;
                            //     let discper = dd.discper == null ? '' : dd.discper;
                            //     let discrp = dd.discrp == null ? '' : dd.discrp;
                            //     let ppn = dd.ppn == null ? '' : dd.ppn;
                            //     let faktur = dd.faktur == null ? '' : dd.faktur;
                            //     let pajakno = dd.pajakno == null ? '' : dd.pajakno;
                            //     let tglfp = dd.tglfp == null ? '' : dd.tglfp;
                            //     let noreffbtb = dd.noreffbtb == null ? '' : dd.noreffbtb;
                            //     let keterangan = dd.keterangan == null ? '' : dd.keterangan;
                            //     let pkp = dd.pkp == null ? '' : dd.pkp;
                            //     let frac = dd.frac == null ? '' : dd.frac;
                            //     let unit = dd.unit == null ? '' : dd.unit;

                            //     $('#body-table-detail').append('<tr style="cursor:pointer;" class="row-detail row-detail-' + i + '" deskripsi="' + deskripsi + '">' +
                            //         '<td><input disabled class="form-control " type="text" value="' + plu + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + desk + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + satuan + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + bkp + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + stock + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + convertRupiah(hrgsatuan) + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + convertRupiah(ctn) + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + convertRupiah(pcs) + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + convertRupiah(gross) + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + discper + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + convertRupiah(discrp) + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + convertRupiah(ppn) + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + faktur + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + pajakno + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + tglfp + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + noreffbtb + '"></td>' +
                            //         '<td><input disabled class="form-control " type="text" value="' + keterangan + '"></td>' +
                            //         '</tr>');
                            //     i++;
                            //     tot_gross += parseFloat(gross);
                            //     tot_potongan += parseFloat(discrp);
                            //     tot_ppn += parseFloat(ppn);
                            // });
                            // tot_total = tot_gross - tot_potongan + tot_ppn;
                        }
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status
                        }).then(() => {
                            getDataUsulan();
                        });

                        // let model = $('#txtModel').val();
                        // $.ajax({
                        //         type: "POST",
                        //         url: "{{ url('/bo/transaksi/pengeluaran/input/save') }}",
                        //         async: false,
                        //         data: {
                        //             // datas: datas,
                        //             nodoc: nodoc,
                        //             tgldoc: tgldoc,
                        //             model: model,
                        //             kdsup: kdsup,
                        //             datas_detail: datas_detail
                        //         },
                        //         beforeSend: function () {
                        //             $('#modal-loader').modal('show');
                        //         },
                        //         success: function (response) {
                        //             console.log(response);
                        //             $('#modal-loader').modal('hide');
                        //             swal({
                        //                 title: response.status,
                        //                 text: response.message,
                        //                 icon: response.status
                        //             }).then(() => {
                        //                 window.location.reload();
                        //             });

                        //         },
                        //         error: function (error) {
                        //             $('#modal-loader').modal('hide');
                        //             // handle error
                        //             swal({
                        //                 title: 'Gagal!',
                        //                 text: 'Data gagal disimpan!',
                        //                 icon: 'error'
                        //             }).then(() => {
                        //             });
                        //         }
                        //     });
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
        });

        $(document).on('click', '#btnSimpan', function () {
            let currentButton = $(this);
            let count = 0;
            $('#body-table-detail tr').each(function () {
                count++;
            });
            // console.log(count);
            if (count > 0) {
                swal({
                    title: "Simpan Data?",
                    text: "Tekan Tombol Ya untuk Melanjutkan!",
                    icon: "info",
                    buttons: true,
                }).then((yes) => {
                    if (yes) {
                        let nodoc = $('#txtNoDoc').val();
                        let tgldoc = $('#dtTglDoc').val();
                        console.log(tgldoc);
                        let kdsup = $('#txtKdSupplier').val();
                        let model = $('#txtModel').val();

                        // datas = [];
                        // let index = 1;
                        // $('#body-table-detail tr.row-detail').each(function () {
                        //     let data = {};

                        //     let satuan = $(this).find('.satuan').val();
                        //     let tempFrac = satuan.split('/');
                        //     let frac = tempFrac[1];

                        //     data.seqno = index;
                        //     data.nodoc = nodoc;
                        //     data.tgldoc = tgldoc;
                        //     data.noreff = $(this).find(".noreff").val();
                        //     data.istype = $(this).find(".istype").val();
                        //     data.invno = $(this).find(".invno").val();
                        //     data.tglinv = $(this).find(".tglinv").val();
                        //     data.kdsup = kdsup;
                        //     data.plu = $(this).find(".plu").val();
                        //     data.ctn = $(this).find(".qtyctn").val();
                        //     data.frac = frac;
                        //     data.qty = $(this).find(".qtypcs").val();
                        //     data.hargasatuan = $(this).find(".hargasatuan").val();
                        //     data.persendisc = $(this).find(".persendisc").val();
                        //     // if (model == '* KOREKSI *') {
                        //     //     data.gross = $(this).find(".gross").val();
                        //     //     data.discrph = $(this).find(".discrph").val();
                        //     //     data.ppnrph = $(this).find(".ppn").val();
                        //     //     data.posqty = $(this).find(".posqty").val();
                        //     //     // if (data.gross.includes(',') == true) {
                        //     //     //     data.gross = parseFloat($(this).find(".gross").val());
                        //     //     // }
                        //     //     // if (data.discrph.includes(',') == true) {
                        //     //     //     data.discrph = parseFloat($(this).find(".discrph").val());
                        //     //     // }
                        //     //     // if (data.ppnrph.includes(',') == true) {
                        //     //     //     data.ppnrph = parseFloat($(this).find(".ppn").val());
                        //     //     // }
                        //     // } else {
                        //     //     data.gross = parseFloat($(this).find(".gross").val());
                        //     //     data.discrph = parseFloat($(this).find(".discrph").val());
                        //     //     data.ppnrph = parseFloat($(this).find(".ppn").val());
                        //     //     data.posqty = parseFloat($(this).find(".posqty").val());
                        //     // }

                        //     data.gross = parseFloat($(this).find(".gross").val());
                        //     data.discrph = parseFloat($(this).find(".discrph").val());
                        //     data.ppnrph = parseFloat($(this).find(".ppn").val());
                        //     data.posqty = parseFloat($(this).find(".posqty").val());
                        //     data.keterangan = $(this).find(".keterangan").val();
                        //     datas.push(data);

                        //     index++;
                        // });

                        ajaxSetup();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/bo/transaksi/pengeluaran/input/save') }}",
                            data: {
                                // datas: datas,
                                arrDeletedPlu: arrDeletedPlu,
                                nodoc: nodoc,
                                tgldoc: tgldoc,
                                model: model,
                                kdsup: kdsup,
                                datas_detail: datas_detail
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                console.log(response);
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: response.status,
                                    text: response.message,
                                    icon: response.status
                                }).then(() => {
                                    window.location.reload();
                                });

                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                // handle error
                                swal({
                                    title: 'Gagal!',
                                    text: 'Data gagal disimpan!',
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
                swal({
                    title: "Error",
                    text: 'Tidak ada data yang bisa disimpan!',
                    icon: 'error'
                }).then(() => {
                });
            }
        });

        function getDataUsulan() {
            let nodoc = $('#txtNoDoc').val();
            let kdsup = $('#txtKdSupplier').val();
            let pkp = $('#txtPKP').val();
            let namasup = $('#txtNmSupplier').val();
            ajaxSetup();
            $.ajax({
                type: "POST",
                url: "{{ url('/bo/transaksi/pengeluaran/input/get-data-usulan') }}",
                data: {
                    nodoc: nodoc,
                    kdsup: kdsup
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response.message) {

                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status
                        }).then(() => {
                        });
                    }
                    else {
                        $('#body-table-usulan').empty();
                        $('#txt-usl-pkp').val(pkp);
                        $('#txt-usl-nama-supplier').val(namasup);
                        $('#txt-usl-kode-supplier').val(kdsup);
                        $('#txt-usl-status').val(response.dataUsulan[0].usl_status);
                        $('#txt-usl-nodok').val(nodoc);

                        for (let i = 0; i < response.dataUsulan.length; i++) {
                            $('#body-table-usulan').append('<tr class="table-sm">\n' +
                                '                               <td class="small usl-prdcd">' + response.dataUsulan[i].usl_prdcd + '</td>\n' +
                                '                               <td class="small usl-desk">' + response.dataUsulan[i].prd_deskripsipanjang + '</td>\n' +
                                '                               <td class="small usl-qty">' + response.dataUsulan[i].usl_qty_sisaretur + '</td>\n' +
                                '                               <td class="small usl-status">' + response.dataUsulan[i].usl_qty_retur + '</td>\n' +
                                '                            </tr>')
                        }
                    }

                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: 'Gagal!',
                        text: 'Data gagal diambil!',
                        icon: 'error'
                    }).then(() => {
                    });
                }
            });
        }

        $(document).on('click', '#btnUsulanRetur', function () {
            let currentButton = $(this);
            getDataUsulan();
        });

        $(document).on('click', '#btnKirimUsulan', function () {
            let currentButton = $(this);
            let nodoc = $('#txt-usl-nodok').val();
            let kdsup = $('#txt-usl-kode-supplier').val();
            let pkp = $('#txt-usl-pkp').val();
            let status = $('#txt-usl-status').val();
            let tgldoc = $('#dtTglDoc').val();

            if (status != 'USULAN') {
                swal({
                    title: 'Info',
                    text: 'Usulan Sudah Diretur!',
                    icon: 'info'
                }).then(() => {
                });
            }

            ajaxSetup();
            $.ajax({
                type: "POST",
                url: "{{ url('/bo/transaksi/pengeluaran/input/send-usulan') }}",
                data: {
                    nodoc: nodoc,
                    kdsup: kdsup,
                    tgldoc: tgldoc
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response.message) {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status
                        }).then(() => {
                        });
                    }
                    if (response.status_usul) {
                        $('#txt-usl-status').val(response.status_usul);
                    }

                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: 'Gagal!',
                        text: 'Data gagal dikirim!',
                        icon: 'error'
                    }).then(() => {
                    });
                }
            });
        });



        $('#btnAddRow').click(function () {
            let totalHeaderRow = $('#body-table-header tr').length;
            // console.log(totalHeaderRow);
            $('#body-table-header').append(
                `<tr class="row-header-${totalHeaderRow + 1}">` +
                `<td><button class="btn btn-block btn-danger btn-delete-row-header" rowheader="${totalHeaderRow + 1}"><i class="icon fas fa-times"></i></button></td>` +
                `<td class="buttonInside" style="width: 8%">` +
                `<input type="text" class="form-control plu-header-${totalHeaderRow + 1} plu-header" rowheader="${totalHeaderRow + 1}">` +
                `<button type="button" class="btn btn-lov-plu btn-lov ml-3" rowheader="${totalHeaderRow + 1}" data-target="#m_lov_plu" data-toggle="modal">` +
                `<img src="../../../../public/image/icon/help.png" width="30px">` +
                `</button>` +
                `</td>` +
                `<td><input disabled class="form-control deskripsi-header-${totalHeaderRow + 1}" type="text"></td>` +
                `<td><input disabled class="form-control satuan-header satuan-header-${totalHeaderRow + 1}" type="text"></td>` +
                `<td><input disabled class="form-control bkp-header-${totalHeaderRow + 1}" type="text"></td>` +
                `<td><input disabled class="form-control stock-header-${totalHeaderRow + 1}" type="text"></td>` +
                `<td><input class="form-control ctn-header ctn-header-${totalHeaderRow + 1}" rowheader="${totalHeaderRow + 1}" type="text" value="0"></td>` +
                `<td><input class="form-control pcs-header pcs-header-${totalHeaderRow + 1}" rowheader="${totalHeaderRow + 1}" type="text" value="0"></td>` +
                `<td><input class="form-control keterangan-header keterangan-header-${totalHeaderRow + 1}" rowheader="${totalHeaderRow + 1}" type="text"></td>` +
                `</tr>`
            );
        });
    </script>


@endsection
