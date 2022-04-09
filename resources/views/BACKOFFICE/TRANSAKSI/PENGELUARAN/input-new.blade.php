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
                        <button type="button" class="col-12 btn btn-primary" id="btnAddRow">+ Tambah Row</button>
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
                                            <th>No. Doc</th>
                                            <th>Tgl. Doc</th>
                                            <th>Nota</th>
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
                        <div class="form-group row mb-0">
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
        let rowLength = $('#table-header #tBodyHeader tr').length;

        $(document).ready(function () {
            getTrnLov('');
            getSupplierLov('');
            getPluLov('');
            $('#btnAddRow').hide();
        });


        function getDataTrn(noTrn) {
            ajaxSetup();
            if (noTrn == '') {
                swal({
                title: "Buat Nomor Pengeluaran Baru?",
                text: "Tekan tombol Ya untuk melanjutkan!",
                icon: "info",
                buttons: true,
            })
            .then((yes) => {
                if (yes) {
                    $.ajax({
                        type: "get",
                        url: "{{ url()->current() }}/get-new-no-trn",
                        // data: "data",
                        // dataType: "dataType",
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#no-trn').prop('disabled', true);
                            $('#tgl-doc').prop('disabled', true);
                            $('#btn-lov-trn').prop('disabled', true);
                            $('#btn-save').attr('disabled', false);
                            $('#btnUsulanRetur').attr('disabled', false);
                            // console.log(response);
                            $('#no-trn').val(response.data.no);
                            $('#txtModel').val(response.data.model);
                            $("#tgl-doc").datepicker().datepicker("setDate", new Date());
                            $('#txtKodeSupplier').focus();

                            $('#table-header #tBodyHeader').append(
                                '<tr class="row-header-1">' +
                                '<td><button class="btn btn-block btn-danger btn-delete-row-header" onclick="deleteRow(this)" rowheader="1"><i class="icon fas fa-times"></i></button></td>' +
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
                                '<td><input class="form-control ctn-header ctn-header-1" rowheader="1" type="text"></td>' +
                                '<td><input class="form-control pcs-header pcs-header-1" rowheader="1" type="text"></td>' +
                                '<td><input class="form-control keterangan-header keterangan-header-1" rowheader="1" type="text"></td>' +
                                '</tr>'
                            );
                            $('#btnAddRow').show();
                            $('#modal-loader').modal('hide');
                        }
                    });
                } else {
                    return false;
                }
            });
            } else {
                // console.log(noTrn);

                ajaxSetup();
                $.ajax({
                    type: "get",
                    url: "{{ url()->current() }}/get-data-pengeluaran",
                    data: {
                        noTrn:noTrn
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        console.log(response);
                        $('#modal-loader').modal('hide');
                    }
                });
            }
        }

        function getTrnLov(value) {
            ajaxSetup();
            let tableTrn = $('#table_lov_notrn').DataTable({
                "ajax": {
                    'type': "get",
                    'url': '{{ url()->current() }}/get-data-lov-trn',
                },
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
            })
        }

        function getSupplierLov(value){
            ajaxSetup();
            let tableSupp = $('#table_lov_supplier').DataTable({
                "ajax": {
                    'type': "get",
                    'url': '{{ url()->current() }}/get-data-lov-supplier',
                },
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
            })
        }

        function getPluLov(value){
            ajaxSetup();
            let tablePlu = $('#table_lov_plu').DataTable({
                "ajax": '{{ url()->current() }}/get-data-lov-plu',
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


        function getDataSupplier(value){
            kdsup = value.toUpperCase();
            $('#txtKodeSupplier').val(kdsup);


            ajaxSetup();
            $.ajax({
                type: "get",
                url: "{{ url()->current() }}/get-data-supplier",
                data: {
                    kdsup: kdsup
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    // console.log(response);
                    $('#modal-loader').modal('hide');
                    $('.plu-header-1').focus();

                    if (response.status === 'error' || response.status === 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status
                        }).then(() => {
                            $('#txtKodeSupplier').val(response.data.sup_kodesupplier);
                            $('#txtNamaSupplier').val(response.data.sup_namasupplier);
                            $('#txtPKP').val(response.data.sup_pkp);
                        });
                    }
                    else {
                        // console.log(response.data.result);
                        // console.log(pkp);
                        $('#txtKodeSupplier').val(response.data.sup_kodesupplier);
                        $('#txtNamaSupplier').val(response.data.sup_namasupplier);
                        $('#txtPKP').val(response.data.sup_pkp);
                    }


                }
            });
        }

        function getDataPLU(plu){
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

            ajaxSetup();
            $.ajax({
                type: "get",
                url: "{{ url()->current()}}/get-data-plu",
                data: {
                    plu: plu,
                    kdsup: kdsup
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (response.status === 'error' || response.status === 'info') {
                        swal({
                            title: response.status,
                            text: response.message,
                            icon: response.status
                        }).then(() => {});
                    } else {
                        // console.log(response);
                        let rowLength = $('#table-header #tBodyHeader tr').length;

                        $(`.plu-header-${rowLength}`).val(response.data.st_prdcd);
                        $(`.plu-header-${rowLength}`).attr('max_qty', response.data.qtypb);
                        $(`.deskripsi-header-${rowLength}`).val(response.data.prd_deskripsipendek);
                        $(`.satuan-header-${rowLength}`).val(response.data.satuan);
                        $(`.bkp-header-${rowLength}`).val(response.data.prd_flagbkp1);
                        $(`.stock-header-${rowLength}`).val(response.data.st_saldoakhir);
                        $(`.ctn-header-${rowLength}`).focus();
                    }

                }
            });
        }
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

        // KEYPRESS
        $('#no-trn').keypress(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                let noTrn = $(this).val();
                getDataTrn(noTrn);
            }
        });
        $('#txtKodeSupplier').keypress(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                let kdsup = $('#txtKodeSupplier').val();
                getDataSupplier(kdsup);
            }
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
        $(document).on('keypress', '.ctn-header', function (e) {

            // console.log($(this).attr('rowheader'));
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


        // SELECT DATATABLE
        $('#table_lov_notrn tbody').on('click', '.row-lov-trn', function () {
            $('#no-trn').val('');

            let trnTable = $('#table_lov_notrn').DataTable();
            let selectedTrn = trnTable.row(this).data().trbo_nodoc;
            // console.log(trnTable.row(this).data());
            $('#no-trn').val(selectedTrn);
            getDataTrn(selectedTrn);
            $('#m_lov_trn').modal('hide');
        });

        $('#table_lov_supplier tbody').on('click', '.row-lov-supplier', function () {
            $('#txtKodeSupplier').val('');

            let suppTable = $('#table_lov_supplier').DataTable();
            let selectedSupp = suppTable.row(this).data();
            // console.log(suppTable.row(this).data());
            // $('#txtKodeSupplier').val(selectedSupp.sup_kodesupplier);
            // $('#txtNamaSupplier').val(selectedSupp.sup_namasupplier);
            // $('#txtPKP').val(selectedSupp.sup_pkp);
            getDataSupplier(selectedSupp.sup_kodesupplier);
            $('#m_lov_supplier').modal('hide');
        });

        $('#table_lov_plu tbody').on('click', '.row-lov-plu', function () {
            // let rowLength = $('#table-header #tBodyHeader tr').length;
            let pluTable = $('#table_lov_plu').DataTable();
            let selectedPlu = pluTable.row(this).data();

            getDataPLU(selectedPlu.prd_prdcd);

            $('#m_lov_plu').modal('hide');
        });

        // CLICK
        $('#btnAddRow').click(function () {
            let totalHeaderRow = $('#table-header #tBodyHeader tr').length;
            $('#table-header #tBodyHeader').append(
                `<tr class="row-header-${totalHeaderRow + 1}">` +
                `<td><button class="btn btn-block btn-danger btn-delete-row-header" onclick="deleteRow()" rowheader="${totalHeaderRow + 1}"><i class="icon fas fa-times"></i></button></td>` +
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
                `<td><input class="form-control ctn-header ctn-header-${totalHeaderRow + 1}" rowheader="${totalHeaderRow + 1}" type="text"></td>` +
                `<td><input class="form-control pcs-header pcs-header-${totalHeaderRow + 1}" rowheader="${totalHeaderRow + 1}" type="text"></td>` +
                `<td><input class="form-control keterangan-header keterangan-header-${totalHeaderRow + 1}" rowheader="${totalHeaderRow + 1}" type="text"></td>` +
                `</tr>`
            );
        });

        function deleteRow(i){

            let rows= 0;

            $(this).parents('td tr').remove();
            $('#label-deskripsi').val('')

            console.log($(this));
        }

        // $('#table-header #tBodyHeader tr td btn-delete-row-header').click(function (e) {
        //     e.preventDefault();
        //     let row = $(this).closest('tr');
        //     console.log(row.index());
        // });
    </script>


@endsection
