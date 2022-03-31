@extends('navbar')
@section('title','Input Pengeluaran')
@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form">

                                    <div class="form-group row mb-0 ">
                                        <label for="no-trn" class="col-sm-1 col-form-label text-sm-right">NOMOR TRN</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" class="form-control" id="no-trn">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov_trn" data-toggle="modal" id="btn-lov-trn">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px"></button>
                                        </div>
                                        <div class="col-sm-2"> <button class="btn btn-danger btn-sm float-left" id="btn-hapus" onclick="deleteDoc(event)">HAPUS DOKUMEN</button></div>

                                        <div class="col-sm-3">
                                            <input type="text" id="txtModel" class="text-center form-control" disabled></div>
                                        <div class="offset-2 col-sm-2"><button type="button" class="btn btn-primary" id="btn-save"><i class="icon fas fa-save"></i>Simpan</button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="tgl-doc" class="col-sm-1 col-form-label text-sm-right">TANGGAL</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="tgl-doc">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="supp-doc" class="col-sm-1 col-form-label text-sm-right">SUPPLIER</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" class="form-control" id="txtKodeSupplier">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov_supplier" data-toggle="modal" id="btn-lov-trn">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <div class=" col-sm-4">
                                            <input type="text" id="txtNamaSupplier" class="form-control" disabled>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-right">PKP</label>
                                        <div class="col-sm-1">
                                            <input type="text" id="txtPKP" class="form-control text-center" disabled>
                                        </div>
                                        <div class="offset-1 col-sm-2">
                                            <button type="button" id="btnUsulanRetur" data-target="#m_usulan_retur" data-toggle="modal" class="btn btn-info"><i class="icon fas fa-upload"></i> Usulan Retur</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-secondary card-hdr cardForm">
                    <legend class="ml-5">Header</legend>

                    <div class="card-body">
                        <div class="card-body p-0 tableFixedHeader" style="height: 250px;">
                            <table class="table table-sm table-striped table-bordered" id="table-header">
                                <thead class="theadDataTables">
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small">X</th>
                                    <th width="10%" class="text-center small">PLU</th>
                                    <th width="20%" class="text-center small">DESKRIPSI</th>
                                    <th width="5%" class="text-center small">SATUAN</th>
                                    <th width="7%" class="text-center small">BKP</th>
                                    <th width="7%" class="text-center small">STOCK</th>
                                    <th width="7%" class="text-center small">CTN</th>
                                    <th width="7%" class="text-center small">PCS</th>
                                    <th width="25%" class="text-center small">KETERANGAN</th>
                                </tr>
                                </thead>
                                <tbody id="tBodyHeader">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-dark card-dtl">
                    <legend class="w-auto ml-5">Detail</legend>
                    <div class="card-body cardForm">
                        <div class="card-body p-0 tableFixedHeader">
                            <table class="table table-sm table-striped table-bordered" id="table-detail">
                                <thead class="theadDataTables">
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
                                <tbody id="tBodyDetail">
                                </tbody>
                            </table>
                        </div>

                        <br>
                        <input type="text" id="label-deskripsi" class="text-center form-control col-sm-6 font-weight-bold" disabled>
                    </div>
                </fieldset>

                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Total</legend>
                    <div class="card-body cardForm">
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right">TOTAL ITEM</label>
                            <input type="text" id="total-item" class="text-center form-control col-sm-2" disabled>

                            <label class="col-sm-1 col-form-label text-sm-right offset-3">GROSS</label>
                            <input type="text" id="gross" class="text-center form-control col-sm-2" disabled>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6">POTONGAN</label>
                            <input type="text" id="potongan" class="text-center form-control col-sm-2" disabled>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6">PPN</label>
                            <input type="text" id="ppn" class="text-center form-control  col-sm-2" disabled>
                        </div>

                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-6">TOTAL</label>
                            <input type="text" id="total" class="text-center form-control col-sm-2" disabled>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--MODAL NOMOR DOKUMEN RETUR--}}
    <div class="modal fade" id="m_lov_trn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                </div>
            </div>
        </div>
    </div>


    {{--MODAL KODE SUPPLIER--}}
    <div class="modal fade" id="m_lov_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                </div>
            </div>
        </div>
    </div>

    {{--MODAL PLU--}}
    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_usulan_retur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <label class="col-sm-2 col-form-label text-sm-right" style="font-size: 12px">Supplier</label>
                            <div class="col-sm-2">
                                <input type="text" id="txt-usl-kode-supplier" class="text-center form-control" disabled>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" id="txt-usl-nama-supplier" class="text-center form-control" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px;text-align: right">PKP</label>
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
                                            <th class="text-center small">QTY YANG BISA RETUR</th>
                                            <th class="text-center small">*QTY USULAN</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tBodyUsulan">
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icon fas fa-times"></i>CANCEL</button>
                        </div>

                        <label class="col-sm-2 col-form-label text-sm-right" style="font-size: 12px;text-align: right">One Time Password</label>
                        <div class="col-sm-3">
                            <input type="text" id="txt-usl-otp" class="text-center form-control">
                        </div>
                        <div class="col-sm-5">
                            <button type="button" class="btn btn-primary" id="btnKirimUsulan" data-dismiss="modal"><i class="icon fas fa-upload"></i>KIRIM USULAN KE FINANCE</button>
                        </div>

                    </div>
                    <div class="row">
                        <label class="col-sm col-form-label text-danger text-left" style="font-size: 12px">*Qty usulan adalah qty yang diinput oleh user dengan batasan qty maksimal dari semua nomor referensi BPB yang ada</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .row-lov-trn:hover {
            cursor: pointer;
            background-color: #0079C2;
            color: white;
        }
        .row-lov-supplier:hover {
            cursor: pointer;
            background-color: #0079C2;
            color: white;
        }
        .buttonInside {
            position: relative;
        }
        .btn-lov-plu {
            position: absolute;
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
        var rowheader;
        var row = 1;
        var kdsup = '';
        let arrDeletedPlu = [];
        let arrNewData = [];
        let index = 1;

        $(document).ready(function () {
            reset();
            $('#tgl-doc').datepicker({
                "dateFormat": "mm/dd/yy",
                "setDate": new Date()
            });
        });

        $('#no-trn').keypress(function (e) {
            if (e.keyCode == 13) {
                var nodoc = $(this).val();
                getDataTrn(nodoc);
            }
        });

        $('#txtKodeSupplier').keypress(function (e) {
            if (e.keyCode == 13) {
                kdsup = $('#txtKodeSupplier').val();
                getDataSupplier(kdsup);
            }
        });

        $(document).on('click', '.card-hdr,.card-dtl', function () {
            if ($('#txtKodeSupplier').val() == '' && $('#no-trn').val() != '' && $('#tgl-doc').val() != '') {
                $('#txtKodeSupplier').focus();
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
            var currentButton = $(this);
            nodoc = currentButton.children().first().text();
            $('#no-trn').val(nodoc);
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
            var currentButton = $(this);
            kdsup = currentButton.children().first().next().text();
            getDataSupplier(kdsup);

            $('#m_lov_supplier').modal('hide');
        });

        $('#table_lov_plu').DataTable({
            "ajax": '{{ url('/bo/transaksi/pengeluaran/input/get-data-lov-plu') }}',
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

        $(document).on('click', '.btn-lov-plu, .plu-header', function () {
            rowheader = $(this).attr("rowheader");
        });

        $(document).on('keypress', '.plu-header', function (e) {
            if (e.keyCode == 13) {
                var temp = '';
                for (var i = 0; i < 7 - $(this).val().length; i++) {
                    temp = '0' + temp;
                }
                temp = temp + $(this).val();
                $(this).val(temp);
                getDataPLU(temp);
            }
        });

        $(document).on('click', '.row-lov-plu', function () {
            var currentButton = $(this);

            var plu = currentButton.children().first().text();

            getDataPLU(plu);
            $('#m_lov_plu').modal('hide');
        });




        function deleteDoc(event) {
            event.preventDefault();
            let nodoc = $('#no-trn').val();

            swal({
                title: 'Nomor Dokumen Akan dihapus?',
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function(confirm){
                if(confirm){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/delete',
                        type: 'post',
                        data: {nodoc: nodoc},

                        success: function (result){
                            clearField();
                            swal({
                                title: result.msg,
                                icon: 'success'
                            });
                        }, error: function () {
                            alert('error');
                        }
                    })
                } else {
                    console.log('Tidak dihapus');
                }
            })
        }
                function getDataPLU(plu) {
            if (kdsup == '' || kdsup == null) {
                swal({
                    title: 'Info',
                    text: 'Tentukan Supplier Terlebih dahulu',
                    icon: 'warning'
                }).then(() => {
                    $('#txtKodeSupplier').focus();
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
                    if (response.result) {
                        $(".plu-header-" + rowheader).val(response.result.st_F);
                        $(".plu-header-" + rowheader).attr('max_qty', response.result.qtypb);
                        $(".deskripsi-header-" + rowheader).val(response.result.prd_deskripsipendek);
                        $(".satuan-header-" + rowheader).val(response.result.satuan);
                        $(".bkp-header-" + rowheader).val(response.result.prd_flagbkp1);
                        $(".stock-header-" + rowheader).val(response.result.st_saldoakhir);
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
            $('#txtKodeSupplier').val(kdsup);
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

                    if (response.message) {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status
                        }).then(() => {
                        });
                    }
                    else {
                        namasupplier = response.result.sup_namasupplier;
                        pkp = response.result.sup_pkp;

                        $('#txtKodeSupplier').val(kdsup);
                        $('#txtNamaSupplier').val(namasupplier);
                        $('#txtPKP').val(pkp);
                    }

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
            $('#tBodyHeader').empty();
            $('#tBodyDetail').empty();
            $('#tBodyUsulan').empty();
            $('#btn-hapus').attr('disabled', true);
            $('#btnUsulanRetur').attr('disabled', false);
            $('#btn-save').attr('disabled', false);
            $('#txtKodeSupplier').attr('disabled', false);

            $('#txtKodeSupplier').val('');
            $('#txtNamaSupplier').val('');
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
            // if (notrn == '') {
            //     swal({
            //         title: "Buat Nomor Pengeluaran Baru?",
            //         text: "Tekan tombol Ya untuk melanjutkan!",
            //         icon: "info",
            //         buttons: true,
            //     }).then((yes) => {
            //         if (yes) {
            //             $('#btn-save').attr('id', 'btn-save-new');

            //             $('#tBodyDetail tr').each(function(){
            //                 $(this).find('td .plu').each(function(){
            //                     if ($(this).val() === plu) {
            //                         $(this).parents('tr').remove();
            //                         arrDeletedPlu.push(plu);
            //                         console.log(arrDeletedPlu);
            //                     }
            //                 })
            //             })

            //             ajaxSetup();
            //             $.ajax({
            //                 type: "post",
            //                 url: "{{ url()->current() }}/save-new-data-trn",
            //                 data: {
            //                     notrn: notrn
            //                 },
            //                 beforeSend: function () {
            //                     $('#modal-loader').modal('show');
            //                     reset();
            //                 },
            //                 success: function (response) {

            //                 },
            //                 error: function (error) {
            //                     $('#modal-loader').modal('hide');
            //                     // error
            //                     swal({
            //                         title: error.responseJSON.exception,
            //                         text: error.responseJSON.message,
            //                         icon: 'error'
            //                     }).then(() => {
            //                     });
            //                 }
            //             });
            //         } else {
            //             return false;
            //         }
            //     });
            // }
            if (notrn == '') {
                swal({
                    title: "Buat Nomor Pengeluaran Baru?",
                    text: "Tekan tombol Ya untuk melanjutkan!",
                    icon: "info",
                    buttons: true,
                }).then((yes) => {
                    if (yes) {
                        $('#btn-save').attr('id', 'btn-save-new');
                        $('#btn-save-new').attr('onclick', 'saveNewData()');

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
                                $('#no-trn').prop('disabled', true);
                                $('#tgl-doc').prop('disabled', true);
                                $('#btn-lov-trn').prop('disabled', true);
                                $('#btn-save').attr('disabled', false);
                                $('#btnUsulanRetur').attr('disabled', false);

                                $('#modal-loader').modal('hide');
                                if (response.status == 'error') {
                                    swal({
                                        title: response.status,
                                        text: response.message,
                                        icon: 'error'
                                    }).then(() => {
                                        no
                                    });
                                }
                                else {
                                    $('#no-trn').val(response.no);
                                    $("#tgl-doc").datepicker().datepicker("setDate", new Date());
                                    $('#txtModel').val(response.model);
                                    $('#txtKodeSupplier').focus();

                                    $('#tBodyHeader').append(
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
                                        '<td><input class="form-control ctn-header ctn-header-1" rowheader=1 type="text"></td>' +
                                        '<td><input class="form-control pcs-header pcs-header-1" rowheader=1 type="text"></td>' +
                                        '<td><input class="form-control keterangan-header keterangan-header-1" rowheader=1 type="text"></td>' +
                                        '</tr>' +
                                        '<tr>' +
                                        '<td>' +
                                        '<button class="btn btn-primary" id="btnAddRow" onclick="addNewRow()">+</button>' +
                                        '</td>' +
                                        '</tr>');

                                }

                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                // error
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
            // if (notrn == '') {
            //     swal({
            //         title: "Buat Nomor Pengeluaran Baru?",
            //         text: "Tekan tombol Ya untuk melanjutkan!",
            //         icon: "info",
            //         buttons: true,
            //     }).then((yes) => {
            //         if (yes) {
            //             $.ajax({
            //                 type: "GET",
            //                 url: "{{ url('/bo/transaksi/pengeluaran/input/get-new-no-trn') }}",
            //                 headers: {
            //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //                 },
            //                 beforeSend: function () {
            //                     $('#modal-loader').modal('show');
            //                     reset();
            //                 },
            //                 success: function (response) {
            //                     $('#no-trn').prop('disabled', true);
            //                     $('#tgl-doc').prop('disabled', true);
            //                     $('#btn-lov-trn').prop('disabled', true);
            //                     $('#btn-save').attr('disabled', false);
            //                     $('#btnUsulanRetur').attr('disabled', false);

            //                     $('#modal-loader').modal('hide');
            //                     if (response.status == 'error') {
            //                         swal({
            //                             title: response.status,
            //                             text: response.message,
            //                             icon: 'error'
            //                         }).then(() => {
            //                             no
            //                         });
            //                     }
            //                     else {
            //                         $('#no-trn').val(response.no);
            //                         $("#tgl-doc").datepicker().datepicker("setDate", new Date());
            //                         $('#txtModel').val(response.model);
            //                         $('#txtKodeSupplier').focus();

            //                         $('#tBodyHeader').append(
            //                             '<tr class="row-header-1">' +
            //                             '<td><button class="btn btn-block btn-danger btn-delete-row-header" rowheader="1"><i class="icon fas fa-times"></i></button></td>' +
            //                             '<td class="buttonInside" style="width: 8%">' +
            //                             '<input type="text" class="form-control plu-header-1 plu-header" rowheader="1">' +
            //                             '<button type="button" class="btn btn-lov-plu btn-lov ml-3" rowheader="1" data-target="#m_lov_plu" data-toggle="modal">' +
            //                             '<img src="../../../../public/image/icon/help.png" width="30px">' +
            //                             '</button>' +
            //                             '</td>' +
            //                             '<td><input disabled class="form-control deskripsi-header-1" type="text"></td>' +
            //                             '<td><input disabled class="form-control satuan-header satuan-header-1" type="text"></td>' +
            //                             '<td><input disabled class="form-control bkp-header-1" type="text"></td>' +
            //                             '<td><input disabled class="form-control stock-header-1" type="text"></td>' +
            //                             '<td><input class="form-control ctn-header ctn-header-1" rowheader=1 type="text"></td>' +
            //                             '<td><input class="form-control pcs-header pcs-header-1" rowheader=1 type="text"></td>' +
            //                             '<td><input class="form-control keterangan-header keterangan-header-1" rowheader=1 type="text"></td>' +
            //                             '</tr>');

            //                     }

            //                 },
            //                 error: function (error) {
            //                     $('#modal-loader').modal('hide');
            //                     // error
            //                     swal({
            //                         title: error.responseJSON.exception,
            //                         text: error.responseJSON.message,
            //                         icon: 'error'
            //                     }).then(() => {
            //                     });
            //                 }
            //             });
            //         } else {
            //             return false;
            //         }
            //     });
            // }
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
                            if (response.model == '* NOTA SUDAH DICETAK *') {
                                $('#btn-hapus').attr('disabled', true);
                            }
                            else {
                                $('#btn-hapus').attr('disabled', false);
                            }

                            $('#txtModel').val(response.model);

                            $('#tgl-doc').val(response.tgldoc);
                            $('#txtKodeSupplier').val(response.supplier);
                            $('#txtNamaSupplier').val(response.nmsupplier);
                            $('#txtPKP').val(response.pkp);

                            $('#txt-usl-nodok').val(notrn);
                            $('#txt-usl-kode-supplier').val(response.supplier);
                            $('#txt-usl-nama-supplier').val(response.nmsupplier);
                            $('#txt-usl-pkp').val(response.pkp);

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

                                $('#tBodyHeader').append('<tr id="row' + plu + '">' +
                                    '<td><button class="btn btn-block btn-danger btn-delete-row-header" onclick=deleteRow("'+ plu +'")><i class="icon fas fa-times"></i></button></td>' +
                                    '<td><input class="form-control " type="text" value="' + plu + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + deskripsi + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + satuan + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + bkp + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + stock + '"></td>' +
                                    '<td><input class="form-control " type="text" value="' + ctn + '"></td>' +
                                    '<td><input class="form-control " type="text" value="' + pcs + '"></td>' +
                                    '<td><input class="form-control " type="text" value="' + ket + '"></td>' +
                                    '</tr>');
                                $('#tBodyHeader').find('tr:last').append(
                                    '<tr>' +
                                    '<td>' +
                                    '<button class="btn btn-primary" id="btnAddRow" onclick="addNewRow()">+</button>' +
                                    '</td>' +
                                    '</tr>'
                                );
                                // $('#tBodyHeader #row:last').append(
                                //     '<tr>' +
                                //     '<td>' +
                                //     '<button class="btn btn-primary" id="btnAddRow" onclick="addNewRow()">+</button>' +
                                //     '</td>' +
                                //     '</tr>'
                                // );
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

                                $('#tBodyDetail').append('<tr style="cursor:pointer;" class="row-detail row-detail-' + i + '" deskripsi="' + deskripsi + '">' +
                                    '<td><input disabled class="form-control plu" type="text" value="' + plu + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + desk + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + satuan + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + bkp + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + stock + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(hrgsatuan) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(ctn) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(pcs) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(gross) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + discper + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(discrp) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(ppn) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + faktur + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + pajakno + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + tglfp + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + noreffbtb + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + keterangan + '"></td>' +
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
                            // $('.btn-delete-row-header').attr('disabled', true); //edit disini

                            if (response.model == '* NOTA SUDAH DICETAK *') {
                                $('.card-hdr input').attr('disabled', true);
                                $('.card-dtl input').attr('disabled', true);
                                $('#txtKodeSupplier').attr('disabled', true);
                                $('#tgl-doc').attr('disabled', true);
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
                        // error
                        console.log(error);
                    }
                });
            }
        }

        function addNewRow() {
            console.log('clicked');
            $('#tBodyHeader').find('#row').remove();
            $('#tBodyHeader').find('#btnAddRow').remove();
            $('#tBodyHeader').append(

                `<tr class="row-header-${index + 1}">` +
                `<td><button class="btn btn-block btn-danger btn-delete-row-header" rowheader="${index + 1}"><i class="icon fas fa-times"></i></button></td>` +
                `<td class="buttonInside" style="width: 8%">` +
                `<input type="text" class="form-control plu-header-${index + 1} plu-header" rowheader="${index + 1}">` +

                `<button type="button" class="btn btn-lov-plu btn-lov ml-3" rowheader="${index + 1}" data-target="#m_lov_plu" data-toggle="modal">` +
                `<img src="../../../../public/image/icon/help.png" width="30px">` +
                `</button>` +
                `</td>` +
                `<td><input disabled class="form-control deskripsi-header-${index + 1}" type="text"></td>` +
                `<td><input disabled class="form-control satuan-header satuan-header-${index + 1}" type="text"></td>` +
                `<td><input disabled class="form-control bkp-header-${index + 1}" type="text"></td>` +
                `<td><input disabled class="form-control stock-header-${index + 1}" type="text"></td>` +
                `<td><input class="form-control ctn-header ctn-header-${index + 1}" rowheader="${index + 1}" type="text"></td>` +
                `<td><input class="form-control pcs-header pcs-header-${index + 1}" rowheader="${index + 1}" type="text"></td>` +
                `<td><input class="form-control keterangan-header keterangan-header-${index + 1}" rowheader="${index + 1}" type="text"></td>` +
                `</tr>`  +
                `<tr>` +
                `<td>` +
                `<button class="btn btn-primary" id="btnAddRow" onclick="addNewRow()">+</button>` +
                `</td>` +
                `</tr>`);

            index++;
        }
        function deleteRow(plu) {
            $('#row' + plu).remove();
            console.log(plu);
            //gunakan plu disini

            $('#tBodyDetail tr').each(function(){
                $(this).find('td .plu').each(function(){
                    if ($(this).val() === plu) {
                        $(this).parents('tr').remove();
                        arrDeletedPlu.push(plu);
                        console.log(arrDeletedPlu);
                    }
                })
            })
        }
        $(document).on('click', '.btn-delete-row-header', function (e) {
            var current = $(this);
            var rh = current.attr('rowheader');
            $('.row-header-' + rh).empty();
            $('.row-detail-' + rh).empty();
        });

        $(document).on('keypress', '.ctn-header', function (e) {
            if (e.keyCode == 13) {
                var nodoc = $(this).val();
                var current = $(this);
                var rh = current.attr('rowheader');
                var ctn = current.val();
                var pcs = $('.pcs-header-' + rh).val();
                var stock = $('.pcs-stock-' + rh).val();
                var satuan = $('.satuan-header-' + rh).val();
                var tempFrac = satuan.split('/');
                var frac = tempFrac[1];
                var max_qty = $('.plu-header-' + rh).attr('max_qty');

                if (ctn < 0 || ctn == '') {
                    current.val(0);
                    swal({
                        title: 'Info',
                        text: 'Quantity Carton < 0',
                        icon: 'info'
                    });
                    return false;
                }

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
                var current = $(this);
                var rh = current.attr('rowheader');
                var model = $('#txtModel').val();
                var nodoc = $('#no-trn').val();
                var tgldoc = $('#tgl-doc').val();
                var kdsup = $('#txtKodeSupplier').val();
                var plu = $('.plu-header-' + rh).val();
                var ctn = parseInt($('.ctn-header-' + rh).val());
                var fracTemp = $('.satuan-header-' + rh).val().split('/');
                var frac = parseInt(fracTemp[1]);
                var pcs = parseInt($('.pcs-header-' + rh).val());
                var stock = parseInt($('.stock-header-' + rh).val());
                var bkp = $('.bkp-header-' + rh).val();

                var message = '';
                var status = '';
                var inputan = '';
                var qtypb = '';
                var qtyretur = '';
                var qtysisa = '';

                if (model == 'KOREKSI') {
                    return false;
                }
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

                    ajaxSetup();
                    $.ajax({
                        type: "POST",
                        url: "{{ url('/bo/transaksi/pengeluaran/input/cek-pcs-1') }}",
                        data: {
                            plu: plu,
                            kdsup: kdsup
                        },
                        beforeSend: function () {
                        },
                        success: function (response) {
                            qtypb = response.qtypb;
                            qtyretur = response.qtyretur;
                            qtysisa = response.qtysisa;
                            console.log(qtyretur);

                            inputan = ((ctn * frac) + pcs);
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
                                    + ', untuk sisanya silahkan untuk membuat Struk Penjualan atau minta otorisasi Finance.'
                                    + 'Proses untuk otorisasi Finance?';
                                status = 'info';
                                swal({
                                    title: "Mohon untuk dijawab.",
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
                                            data: {
                                                nodoc: nodoc,
                                                plu: plu,
                                                kdsup: kdsup,
                                                tgldoc: tgldoc,
                                                bkp: bkp,
                                                inputan: inputan,
                                                qtyretur: qtyretur
                                            },
                                            success: function (response) {
                                            }, error: function (error) {
                                                console.log(error);
                                            }
                                        });

                                        ctn = 0;
                                        pcs = qtyretur;
                                        $('.ctn-header-' + rh).val(ctn);
                                        $('.pcs-header-' + rh).val(pcs);
                                    } else {
                                        ctn = 0;
                                        pcs = 0;
                                        $('.ctn-header-' + rh).val(ctn);
                                        $('.pcs-header-' + rh).val(pcs);
                                    }
                                });
                            }
                            else {
                                ajaxSetup();
                                $.ajax({
                                    url: "{{ url('/bo/transaksi/pengeluaran/input/cek-pcs-3') }}",
                                    type: 'POST',
                                    data: {
                                        nodoc: nodoc,
                                        plu: plu
                                    },
                                    success: function (response) {
                                        if (response.status == 'question') {
                                            swal({
                                                title: "Mohon untuk dijawab.",
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
                                                        data: {
                                                            nodoc: nodoc,
                                                            plu: plu
                                                        },
                                                        success: function (response) {
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
                            }

                            if (inputan > qtyretur && qtysisa == qtyretur) {
                                ctn = 0;
                                pcs = qtyretur;
                                $('.ctn-header-' + rh).val(ctn);
                                $('.pcs-header-' + rh).val(pcs);
                                console.log(qtyretur);
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
                            if (model == '*TAMBAH*' || model == '*KOREKSI*') {
                                proses(plu, (ctn * frac) + pcs, rh);
                            }

                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            // error
                            console.log(error);
                        }
                    });
                }
                $('#modal-loader').modal('hide');
            }
        });

        function proses(plu, qtyretur, rh) {
            var nodoc = $('#no-trn').val();
            var pkp = $('#txtPKP').val();
            var keterangan = $('.keterangan-header-' + rh).val();

            ajaxSetup();
            $.ajax({
                url: "{{ url('/bo/transaksi/pengeluaran/input/proses') }}",
                type: 'POST',
                data: {
                    qtyretur: qtyretur,
                    p_prdcd: plu,
                    nodoc: nodoc,
                    pkp: pkp
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    datas_detail = response.datas;
                    console.log(response);
                    if (datas_detail.length > 0) {
                        console.log(response);
                        $('.row-detail-' + rh).remove();
                        datas_detail.forEach(function (dd) {
                            $('#tBodyDetail').append('<tr style="cursor:pointer;" class="row-detail row-detail-' + rowheader + '" deskripsi="' + dd.deskripsi + '">' +
                                '<td><input disabled class="form-control plu" type="text" value="' + dd.trbo_prdcd + '"></td>' +
                                '<td><input disabled class="form-control " type="text" value="' + dd.desk + '"></td>' +
                                '<td><input disabled class="form-control satuan" type="text" value="' + dd.satuan + '"></td>' +
                                '<td><input disabled class="form-control bkp" type="text" value="' + dd.bkp + '"></td>' +
                                '<td><input disabled class="form-control posqty" type="text" value="' + dd.trbo_posqty + '"></td>' +
                                '<td><input disabled class="form-control hargasatuan" type="text" value="' + dd.trbo_hrgsatuan + '"></td>' +
                                '<td><input disabled class="form-control qtyctn" type="text" value="' + dd.qtyctn + '"></td>' +
                                '<td><input disabled class="form-control qtypcs" type="text" value="' + dd.qtypcs + '"></td>' +
                                '<td><input disabled class="form-control gross" type="text" value="' + dd.trbo_gross + '"></td>' +
                                '<td><input disabled class="form-control persendisc" type="text" value="' + dd.discper + '"></td>' +
                                '<td><input disabled class="form-control discrph" type="text" value="' + dd.trbo_discrph + '"></td>' +
                                '<td><input disabled class="form-control ppn" type="text" value="' + dd.trbo_ppnrph + '"></td>' +
                                '<td><input disabled class="form-control istype" type="text" value="' + dd.trbo_istype + '"></td>' +
                                '<td><input disabled class="form-control invno" type="text" value="' + dd.trbo_inv + '"></td>' +
                                '<td><input disabled class="form-control tglinv" type="text" value="' + dd.trbo_tgl + '"></td>' +
                                '<td><input disabled class="form-control noreff" type="text" value="' + dd.trbo_noreff + '"></td>' +
                                '<td><input disabled class="form-control keterangan" type="text" value="' + keterangan + '"></td>' +
                                '</tr>');
                        });

                        row++;
                        $('#tBodyHeader').append(
                            '<tr class="row-header-' + row + '">' +
                            '<td><button class="btn btn-block btn-danger btn-delete-row-header" rowheader="' + row + '"><i class="icon fas fa-times"></i></button></td>' +
                            '<td class="buttonInside" style="width: 8%">' +
                            '<input type="text" class="form-control plu-header-' + row + ' plu-header" rowheader="' + row + '">' +
                            '<button type="button" class="btn btn-lov-plu btn-lov ml-3" rowheader="' + row + '" data-target="#m_lov_plu" data-toggle="modal">' +
                            '<img src="../../../../public/image/icon/help.png" width="30px">' +
                            '</button>' +
                            '</td>' +
                            '<td><input disabled class="form-control deskripsi-header-' + row + '" type="text"></td>' +
                            '<td><input disabled class="form-control satuan-header satuan-header-' + row + '" type="text"></td>' +
                            '<td><input disabled class="form-control bkp-header-' + row + '" type="text"></td>' +
                            '<td><input disabled class="form-control stock-header-' + row + '" type="text"></td>' +
                            '<td><input class="form-control ctn-header ctn-header-' + row + '" rowheader=' + row + ' type="text"></td>' +
                            '<td><input class="form-control pcs-header pcs-header-' + row + '" rowheader=' + row + ' type="text"></td>' +
                            '<td><input class="form-control keterangan-header keterangan-header-' + row + '" rowheader=' + row + ' type="text"></td>' +
                            '</tr>');

                        var tot_gross = 0;
                        var tot_potongan = 0;
                        var tot_ppn = 0;
                        var tot_total = 0;
                        var i = 0;
                        $('#tBodyDetail tr').each(function () {
                            var gross = parseFloat($(this).find(".gross").val());
                            var potongan = parseFloat($(this).find(".discrph").val());
                            var ppn = parseFloat($(this).find(".ppn").val());

                            tot_gross += gross;
                            tot_potongan += potongan;
                            tot_ppn += ppn;
                            i++;
                        });
                        tot_total = tot_gross - tot_potongan + tot_ppn;
                        $('#gross').val(convertToRupiah2(tot_gross));
                        $('#potongan').val(convertToRupiah2(tot_potongan));
                        $('#ppn').val(convertToRupiah2(tot_ppn));
                        $('#total').val(convertToRupiah2(tot_total));
                        $('#total-item').val(convertToRupiah2(i));
                    }
                }, error: function (error) {
                    console.log(error);
                }
            });
        }

        $(document).on('click', '.row-detail', function () {
            var currentElement = $(this);
            $('.row-detail').css('background-color', '');
            currentElement.css('background-color', 'lightgray');

            var deskripsi = currentElement.attr('deskripsi');
            $('#label-deskripsi').val(deskripsi);
        });

        $(document).on('keyup', '#txt-usl-otp', function (e) {
            var currentElement = $(this);
            if (e.keyCode == 13) {
                var nodoc = $('#no-trn').val();
                var otp = currentElement.val();
                var tgldoc = $('#tgl-doc').val();
                var kdsup = $('#txtKodeSupplier').val();
                var pkp = $('#txtPKP').val();
                var datas = [];

                $('#tBodyUsulan tr').each(function () {
                    var data = {};
                    data.prdcd = $(this).find(".usl-prdcd").val();
                    data.qty = $(this).find(".usl-qty").val();
                    datas.push(data);
                });

                var datah = [];
                $('#tBodyHeader tr').each(function () {
                    var data = {};

                    data.plu = $(this).find(".plu-header").val();
                    data.ctn = $(this).find(".ctn-header").val();
                    data.qty = $(this).find(".pcs-header").val();
                    satuan = $(this).find(".satuan-header").val();
                    split_satuan = satuan.split('/');
                    data.frac = split_satuan[1];
                    datah.push(data);
                });

                var datad = [];
                $('#tBodyDetail tr').each(function () {
                    var data = {};

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
                    data: {
                        nodoc: nodoc,
                        datas: datas,
                        datah: datah,
                        datad: datad,
                        otp: otp,
                        kdsup: kdsup,
                        tgldoc: tgldoc,
                        pkp: pkp
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
                            var datas_header = response.datah;
                            datas_header.forEach(function (dh) {
                                var plu = dh.h_plu == null ? '' : dh.h_plu;
                                var deskripsi = dh.h_deskripsi == null ? '' : dh.h_deskripsi;
                                var satuan = dh.h_satuan == null ? '' : dh.h_satuan;
                                var bkp = dh.h_bkp == null ? '' : dh.h_bkp;
                                var stock = dh.h_stock == null ? '' : dh.h_stock;
                                var ctn = dh.h_ctn == null ? '' : dh.h_ctn;
                                var pcs = dh.h_pcs == null ? '' : dh.h_pcs;
                                var ket = dh.h_ket == null ? '' : dh.h_ket;

                                $('#tBodyHeader').append('<tr>' +
                                    '<td><button class="btn btn-block btn-danger btn-delete-row-header"><i class="icon fas fa-times"></i></button></td>' +
                                    '<td><input class="form-control " type="text" value="' + plu + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + deskripsi + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + satuan + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + bkp + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + stock + '"></td>' +
                                    '<td><input class="form-control " type="text" value="' + ctn + '"></td>' +
                                    '<td><input class="form-control " type="text" value="' + pcs + '"></td>' +
                                    '<td><input class="form-control " type="text" value="' + ket + '"></td>' +
                                    '</tr>');
                            });

                            var datas_detail = response.datad;
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

                                $('#tBodyDetail').append('<tr style="cursor:pointer;" class="row-detail row-detail-' + i + '" deskripsi="' + deskripsi + '">' +
                                    '<td><input disabled class="form-control " type="text" value="' + plu + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + desk + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + satuan + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + bkp + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + stock + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(hrgsatuan) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(ctn) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(pcs) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(gross) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + discper + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(discrp) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + convertToRupiah2(ppn) + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + faktur + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + pajakno + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + tglfp + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + noreffbtb + '"></td>' +
                                    '<td><input disabled class="form-control " type="text" value="' + keterangan + '"></td>' +
                                    '</tr>');
                                i++;
                                tot_gross += parseFloat(gross);
                                tot_potongan += parseFloat(discrp);
                                tot_ppn += parseFloat(ppn);
                            });
                            tot_total = tot_gross - tot_potongan + tot_ppn;
                        }
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status
                        }).then(() => {
                            getDataUsulan();
                        });
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
        });

        $(document).on('click', '#btn-save', function () {
                let nodoc = $('#no-trn').val();
                ajaxSetup();
                swal({
                    title: "Simpan Data?",
                    text: "Tekan tombol Ya untuk melanjutkan!",
                    icon: "info",
                    buttons: true,
                }).then((yes) => {
                    if (yes) {
                        $.ajax({
                            type: "post",
                            url: "{{ url()->current() }}/save",
                            data: {
                                arrDeletedPlu: arrDeletedPlu,
                                nodoc: nodoc
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
                                }).then(() => {
                                    window.location.reload();
                                });

                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                // error
                                swal({
                                    title: 'Gagal!',
                                    text: 'Data tidak berhasil disimpan!',
                                    icon: 'error'
                                }).then(() => {
                                });
                            }
                        });
                    } else {
                        return false;
                    }
                });

            // else {
            //     swal({
            //         title: "Error",
            //         text: 'Tidak ada data yang dapat disimpan!',
            //         icon: 'error'
            //     }).then(() => {
            //     });
            // }
        });
        // $(document).on('click', '#btn-save', function () {
        //     var currentButton = $(this);
        //     var count = 0;
        //     $('#tBodyDetail tr').each(function () {
        //         count++;
        //     });
        //     if (count > 0) {
        //         swal({
        //             title: "Simpan Data?",
        //             text: "Tekan tombol Ya untuk melanjutkan!",
        //             icon: "info",
        //             buttons: true,
        //         }).then((yes) => {
        //             if (yes) {
        //                 var nodoc = $('#no-trn').val();
        //                 var tgldoc = $('#tgl-doc').val();
        //                 var kdsup = $('#txtKodeSupplier').val();

        //                 datas = [];
        //                 $('#tBodyDetail tr').each(function () {
        //                     var data = {};

        //                     data.nodoc = nodoc;
        //                     data.tgldoc = tgldoc;
        //                     data.noreff = $(this).find(".noreff").val();
        //                     data.istype = $(this).find(".istype").val();
        //                     data.invno = $(this).find(".invno").val();
        //                     data.tglinv = $(this).find(".tglinv").val();
        //                     data.kdsup = kdsup;
        //                     data.plu = $(this).find(".plu").val();
        //                     data.ctn = $(this).find(".qtyctn").val();
        //                     data.qty = $(this).find(".qtypcs").val();
        //                     data.hargasatuan = $(this).find(".hargasatuan").val();
        //                     data.persendisc = $(this).find(".persendisc").val();
        //                     data.gross = parseFloat($(this).find(".gross").val());
        //                     data.discrph = parseFloat($(this).find(".discrph").val());
        //                     data.ppnrph = parseFloat($(this).find(".ppn").val());
        //                     data.posqty = parseFloat($(this).find(".posqty").val());
        //                     data.keterangan = $(this).find(".keterangan").val();
        //                     datas.push(data);
        //                 });

        //                 ajaxSetup();
        //                 $.ajax({
        //                     type: "post",
        //                     url: "{{ url()->current() }}/save",
        //                     data: {
        //                         datas: datas
        //                     },
        //                     beforeSend: function () {
        //                         $('#modal-loader').modal('show');
        //                     },
        //                     success: function (response) {
        //                         $('#modal-loader').modal('hide');
        //                         swal({
        //                             title: response.status,
        //                             text: response.message,
        //                             icon: response.status
        //                         }).then(() => {
        //                             window.location.reload();
        //                         });

        //                     },
        //                     error: function (error) {
        //                         $('#modal-loader').modal('hide');
        //                         // error
        //                         swal({
        //                             title: 'Gagal!',
        //                             text: 'Data tidak berhasil disimpan!',
        //                             icon: 'error'
        //                         }).then(() => {
        //                         });
        //                     }
        //                 });
        //             } else {
        //                 return false;
        //             }
        //         });
        //     }
        //     else {
        //         swal({
        //             title: "Error",
        //             text: 'Tidak ada data yang dapat disimpan!',
        //             icon: 'error'
        //         }).then(() => {
        //         });
        //     }
        // });

        function getDataUsulan() {
            var nodoc = $('#no-trn').val();
            var kdsup = $('#txtKodeSupplier').val();
            var pkp = $('#txtPKP').val();
            var namasup = $('#txtNamaSupplier').val();
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
                        $('#tBodyUsulan').empty();
                        $('#txt-usl-pkp').val(pkp);
                        $('#txt-usl-nama-supplier').val(namasup);
                        $('#txt-usl-kode-supplier').val(kdsup);
                        $('#txt-usl-status').val(response.dataUsulan[0].usl_status);
                        $('#txt-usl-nodok').val(nodoc);

                        for (var i = 0; i < response.dataUsulan.length; i++) {
                            $('#tBodyUsulan').append('<tr class="table-sm">\n' +
                                '<td class="small usl-prdcd">' + response.dataUsulan[i].usl_prdcd + '</td>\n' +
                                '<td class="small usl-desk">' + response.dataUsulan[i].prd_deskripsipanjang + '</td>\n' +
                                '<td class="small usl-qty">' + response.dataUsulan[i].usl_qty_sisaretur + '</td>\n' +
                                '<td class="small usl-status">' + response.dataUsulan[i].usl_status + '</td>\n' +
                                '</tr>')
                        }
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // error
                    swal({
                        title: 'Gagal!',
                        text: 'Data tidak berhasil diambil!',
                        icon: 'error'
                    }).then(() => {
                    });
                }
            });
        }

        $(document).on('click', '#btnUsulanRetur', function () {
            var currentButton = $(this);
            getDataUsulan();
        });

        $(document).on('click', '#btnKirimUsulan', function () {
            var currentButton = $(this);
            var nodoc = $('#txt-usl-nodok').val();
            var kdsup = $('#txt-usl-kode-supplier').val();
            var pkp = $('#txt-usl-pkp').val();
            var status = $('#txt-usl-status').val();
            var tgldoc = $('#tgl-doc').val();

            if (status != 'USULAN') {
                swal({
                    title: 'Info',
                    text: 'Usulan sudah diretur!',
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
                    swal({
                        title: 'Gagal!',
                        text: 'Data gagal diambil!',
                        icon: 'error'
                    }).then(() => {
                    });
                }
            });
        });

        function saveNewData(){
            let supplier = $('#txtKodeSupplier').val();
            let nodoc = $('#no-trn').val();
            let tgldoc = $('#tgl-doc').val();

            $('#tBodyDetail tr').each(function () {
                var data = {};

                data.nodoc = nodoc;
                data.tgldoc = tgldoc;
                data.noreff = $(this).find(".noreff").val();
                data.istype = $(this).find(".istype").val();
                data.invno = $(this).find(".invno").val();
                data.tglinv = $(this).find(".tglinv").val();
                data.kdsup = kdsup;
                data.plu = $(this).find(".plu-header").val();
                data.ctn = $(this).find(".qtyctn").val();
                data.qty = $(this).find(".qtypcs").val();
                data.hargasatuan = $(this).find(".hargasatuan").val();
                data.persendisc = $(this).find(".persendisc").val();
                data.gross = parseFloat($(this).find(".gross").val());
                data.discrph = parseFloat($(this).find(".discrph").val());
                data.ppnrph = parseFloat($(this).find(".ppn").val());
                data.posqty = parseFloat($(this).find(".posqty").val());
                data.keterangan = $(this).find(".keterangan").val();
                arrNewData.push(data);
            });

            console.log(supplier);
            console.log(nodoc);
            console.log(arrNewData);
        }


    </script>


@endsection
