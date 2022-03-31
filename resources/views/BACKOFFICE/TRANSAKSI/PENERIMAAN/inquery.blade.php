@extends('navbar')
@section('title','PENERIMAAN | INQUERY BPB')
@section('content')


<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card border-dark">
                <div class="card-body cardForm">
                    <form>
                        <div class="form-group row mb-1 pt-4">
                            <label class="col-sm-2 col-form-label text-right">Nomor BPB</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control text-uppercase" id="noBTB">
                                <button id="btn-no-doc" type="button" class="btn btn-lov p-0" onclick="showBTB()">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <label class="col-sm-1 col-form-label text-right">Tanggal</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="tglBTB" disabled>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-sm-2 col-form-label text-right">Nomor PO</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="noPO" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-right">Tanggal</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="tglPO" disabled>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-sm-2 col-form-label text-right">Supplier</label>
                            <div class="col-sm-5 buttonInside">
                                <input type="text" class="form-control" id="namaSupplier" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-right">PKP</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="pkp" disabled>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-sm-2 col-form-label text-right">Nomor Faktur</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="noFaktur" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-right">Tanggal</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="tglFaktur" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-right">TOP</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="top" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-left">Hari</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card border-dark">
                <div class="card-body cardForm">
                    <table class="table table-sm table-striped table-bordered " id="tableInquery">
                        <thead class="theadDataTables">
                            <tr>
                                <th>PLU</th>
                                <th>Nama Barang</th>
                                <th>Kemasan</th>
                                <th>Kuantum</th>
                                <th>H.P.P</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="tbodyTableInquery"></tbody>
                    </table>
                    <form action="">
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-right">Jumlah Item</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control text-right" id="jmlItem" disabled>
                            </div>

                            <label class="col-sm-2 col-form-label text-right">Grant Total</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control text-right" id="grantTotal" disabled>
                            </div>

                            <label class="col-sm-2 offset-sm-5 col-form-label text-right text-secondary">* Klik Plu untuk detail</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal LOV-->
<div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="m_lov" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Daftar BTB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm" id="tableModalHelp">
                                <thead class="theadDataTables">
                                    <tr>
                                        <th> No BPB </th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyModalHelp"></tbody>
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

<!-- Modal Detail-->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="m_lov" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Plu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <form>
                                <div class="form-group row mb-1">
                                    <label class="col-sm-2 col-form-label text-right">PLU</label>
                                    <div class="col-sm-10 buttonInside">
                                        <input type="text" class="form-control" id="splu" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-2 col-form-label text-right">Kemasan</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="skemasan" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label text-right">Status</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="sstatus" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">BKP</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="sbkp" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label text-right">Bandrol</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="sbandrol" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-2 col-form-label text-right">Hrg Beli</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="shrgbeli" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label text-right">Lcost</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="slcost" disabled>
                                    </div>
                                    <label class="col-sm-2 col-form-label text-right">Acost</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="sacost" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-2 col-form-label text-right">Kuantum</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="sqty" disabled>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="sunit" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-center">+</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="sqtyk" disabled>
                                    </div>
                                    <label class="col-form-label text-left">Pcs</label>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-2 col-form-label text-right">Bonus : 1</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="sbns1" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-left">Pcs</label>
                                    <label class="col-sm-1 col-form-label text-center">2</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="sbns2" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-left">Pcs</label>
                                    <label class="col-sm-3 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rpbns" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-2 col-form-label text-right">Potongan : </label>
                                    <label class="col-sm-1 col-form-label text-right">1.% </label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="persendisc1" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rphdisc1" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">SAT</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-right" id="satdics1" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rpdisc1" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">4.% </label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="persendisc4" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rphdisc4" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">SAT</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-right" id="satdics4" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rpdisc4" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">2.% </label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="persendisc2" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rphdisc2" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">SAT</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-right" id="satdics2" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rpdisc2" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">2.% </label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="persendisc2II" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rphdisc2II" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">SAT</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-right" id="satdics2II" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rpdisc2II" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">2.% </label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="persendisc2III" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rphdisc2III" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">SAT</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-right" id="satdics2III" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rpdisc2III" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-3 col-form-label text-right">3.% </label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="persendisc3" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rphdisc3" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">SAT</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-right" id="satdics3" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="rpdisc3" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="offset-sm-8 col-sm-1 col-form-label text-right">PPN</label>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="ppn" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-2 col-form-label text-right">Keterangan</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="ket" disabled>
                                    </div>
                                    <label class="offset-sm-2 col-sm-1 col-form-label text-right">BM</label>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="bm" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="offset-sm-8 col-sm-1 col-form-label text-right">Botol</label>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="btl" disabled>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="offset-sm-8 col-sm-1 col-form-label text-right">Total</label>
                                    <label class="col-sm-1 col-form-label text-right">=Rp.</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-right" id="stotal" disabled>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<style>
    .modalRowBTB:hover,
    .tbodyTableInqueryRow:hover {
        background-color: #e9ecef;
        cursor: pointer;
    }
</style>

<script>
    let tableInquery;
    let tableModalHelp;
    let typeTrn;
    var currUrl = '{{ url()->current() }}';
    currUrl = currUrl.replace("index", "");
    $(document).ready(function() {
        startAlert();
        // typeTrn = 'B'
        tableInquery = $('#tableInquery').DataTable();
    });

    function startAlert() {
        swal({
            title: 'Jenis Penerimaan?',
            icon: 'info',
            buttons: {
                confirm: "Penerimaan",
                roll: {
                    text: "Lain-lain",
                    value: "lain",
                },
            }
        }).then(function(confirm) {
            switch (confirm) {
                case true:
                    typeTrn = 'B';
                    break;

                case "lain":
                    typeTrn = 'L';
                    break;

                default:
                    typeTrn = 'N';
            }
            noBTB.focus();
        })
    }

    function showBTB() {
        if (!typeTrn || typeTrn === 'N') {
            startAlert();

            return false;
        }

        if (tableModalHelp) {
            tableModalHelp.clear().destroy();
        }


        ajaxSetup();
        tableModalHelp = $('#tableModalHelp').DataTable({
            "ajax": {
                'url': currUrl + 'viewbtp',
                'data': {
                    typeTrn: typeTrn
                },
                'method': 'post'
            },
            "columns": [{
                    data: 'msth_nodoc'
                },
                {
                    data: 'msth_tgldoc',
                    render: function(d) {
                        return moment(d).format("DD/MM/YYYY");
                    }
                },
            ],
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "createdRow": function(row, data, dataIndex) {
                $(row).addClass('modalRowBTB');
            },
            "order": []
        });

        $('#modalHelp').modal('show');
    }

    function viewData(noDoc) {
        ajaxSetup();
        $.ajax({
            url: currUrl + 'viewdata',
            type: 'post',
            data: {
                noDoc: noDoc,
                typeTrn: typeTrn
            },
            beforeSend: () => {
                $('#modalHelp').modal('hide');
                $('#modal-loader').modal('show');
                tableInquery.clear();
            },
            success: function(result) {
                console.log(result);
                let grantTotal = 0;
                $('#modal-loader').modal('hide');

                if (result.length > 0) {
                    $('#noBTB').val(result[0].mstd_nodoc);
                    $('#tglBTB').val(formatDate(result[0].mstd_tgldoc));
                    $('#noPO').val(result[0].mstd_nopo);
                    $('#tglPO').val(formatDate(result[0].mstd_tglpo));
                    $('#namaSupplier').val(result[0].supplier);
                    $('#pkp').val(result[0].sup_pkp);
                    $('#noFaktur').val(result[0].mstd_nofaktur);
                    $('#tglFaktur').val(formatDate(result[0].mstd_tglfaktur));
                    $('#top').val(result[0].sup_top);

                    for (let i = 0; i < result.length; i++) {
                        let tempQty = result[i]['qty'] / result[i]['prd_frac'];
                        let qty = (!tempQty) ? 1 : tempQty;

                        tableInquery.row.add(
                            [result[i]['mstd_prdcd'], result[i]['barang'], result[i]['satuan'], qty, convertToRupiah(result[i]['hpp']), convertToRupiah(result[i]['mstd_gross'])]
                        ).draw();

                        grantTotal = parseInt(grantTotal) + parseInt(result[i]['ppntot']);
                    }

                    $('#jmlItem').val(result.length);
                    $('#grantTotal').val(convertToRupiah(grantTotal));
                    $('.tbodyTableInquery tr').addClass('tbodyTableInqueryRow')
                } else {
                    $('#modal-loader').modal('hide');
                    alertError('Data Tidak Ada!', '');
                    $('#noBTB').val('');
                    $('#jmlItem').val('');
                    $('#grantTotal').val('');
                    tableInquery.row.add(
                        ['--', '--', '--', '--', '--', '--']
                    ).draw();
                }
            },
            error: function(err) {
                $('#modal-loader').modal('hide');
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message)
            }
        });
    }

    $(document).on('click', '.modalRowBTB', function() {
        let currentButton = $(this);
        let noDoc = currentButton.children().first().text();

        viewData(noDoc);
    });

    $('#noBTB').keypress(function(e) {
        if (e.which === 13) {
            let noDoc = $(this).val().toUpperCase();

            viewData(noDoc)
        }
    });

    $(document).on('click', '.tbodyTableInqueryRow', function() {
        let currentButton = $(this);
        let prdcd = currentButton.children().first().text();
        let noDoc = $('#noBTB').val();

        ajaxSetup();
        $.ajax({
            url: currUrl + 'viewdetailplu',
            type: 'post',
            data: {
                noDoc: noDoc,
                typeTrn: typeTrn,
                prdcd: prdcd
            },
            beforeSend: () => {
                $('#modal-loader').modal('show');
            },
            success: function(result) {
                $('#modal-loader').modal('hide');
                console.log(result);

                if (result) {
                    $('#splu').val(result[0].splu);
                    $('#skemasan').val(result[0].skemasan);
                    $('#sstatus').val(result[0].stag);
                    $('#sbkp').val(result[0].sbkp);
                    $('#shrgbeli').val(convertToRupiah(result[0].shrgbeli));
                    $('#slcost').val(convertToRupiah(result[0].slcost));
                    $('#sacost').val(convertToRupiah(result[0].sacost));
                    $('#sqty').val(result[0].sqty);
                    $('#sunit').val(result[0].sunit);
                    $('#sqtyk').val(result[0].sqtyk);
                    $('#sbns1').val(result[0].sbns1);
                    $('#sbns2').val(result[0].sbns2);
                    $('#rpbns').val(convertToRupiah(result[0].rpbns));
                    $('#persendisc1').val(result[0].persendisc1);
                    $('#rphdisc1').val(convertToRupiah(result[0].rphdisc1));
                    $('#satdisc1').val(result[0].satdisc1);
                    $('#persendisc4').val(result[0].persendisc4);
                    $('#rphdisc4').val(convertToRupiah(result[0].rphdisc4));
                    $('#satdisc4').val(result[0].satdisc4);
                    $('#persendisc2').val(result[0].persendisc2);
                    $('#rphdisc2').val(convertToRupiah(result[0].rphdisc2));
                    $('#persendisc2ii').val(result[0].persendisc2ii);
                    $('#rphdisc2ii').val(convertToRupiah(result[0].rphdisc2ii));
                    $('#persendisc2iii').val(result[0].persendisc2iii);
                    $('#rphdisc2iii').val(convertToRupiah(result[0].rphdisc2iii));
                    $('#satdisc2').val(result[0].satdisc2);
                    $('#persendisc3').val(result[0].persendisc3);
                    $('#rphdisc3').val(convertToRupiah(result[0].rphdisc3));
                    $('#satdisc3').val(result[0].satdisc3);
                    $('#ppn').val(convertToRupiah(result[0].ppn));
                    $('#bm').val(convertToRupiah(result[0].bm));
                    $('#btl').val(convertToRupiah(result[0].btl));
                    $('#ket').val(result[0].ket);
                    $('#rpdisc1').val(convertToRupiah(result[0].ndisc1));
                    $('#rpdisc4').val(convertToRupiah(result[0].ndisc4));
                    $('#rpdisc2').val(convertToRupiah(result[0].ndisc2));
                    $('#rpdisc2ii').val(convertToRupiah(result[0].ndisc2a));
                    $('#rpdisc2iii').val(convertToRupiah(result[0].ndisc2b));
                    $('#rpdisc3').val(convertToRupiah(result[0].ndisc3));
                    $('#sbandrol').val(result[0].sbandrol);
                    $('#stotal').val(convertToRupiah(result[0].namt));
                }

                $('#modalDetail').modal('show');

            },
            error: function(err) {
                $('#modal-loader').modal('hide');
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message)
            }
        });
    });
</script>

@endsection