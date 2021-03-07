@extends('navbar')
@section('title','PENERIMAAN | PEMBATALAN BPB')
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
                            </div>

                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label text-right">Supplier</label>
                                <div class="col-sm-5 buttonInside">
                                    <input type="text" class="form-control" id="namaSupplier" disabled>
                                </div>
                            </div>

                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label text-right">Total Rp.</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control text-right" id="grantTotal" disabled>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <button class="btn btn-primary col-sm-2 offset-sm-9 btn-block" type="button" onclick="batalBPB()">Pembatalan BPB</button>
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
                        <table  class="table table-sm table-striped table-bordered " id="tableInquery">
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

    <style>
        .modalRowBTB:hover, .tbodyTableInqueryRow:hover{
            background-color: #e9ecef;
            cursor: pointer;
        }


    </style>

    <script>
        let tableInquery;
        let tableModalHelp;
        let typeTrn;

        $(document).ready(function () {
            // startAlert();
            typeTrn = 'B'
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
            }).then(function (confirm) {
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
            if(!typeTrn || typeTrn === 'N'){
                startAlert();

                return false;
            }

            if (tableModalHelp){
                tableModalHelp.clear().destroy();
            }


            ajaxSetup();
            tableModalHelp = $('#tableModalHelp').DataTable({
                "ajax": {
                    'url' : '/BackOffice/public/bo/transaksi/penerimaan/pembatalan/viewbtp',
                    'data' : {typeTrn:typeTrn},
                    'method' : 'post'
                },
                "columns": [
                    {data: 'msth_nodoc'},
                    {
                        data: 'msth_tgldoc',
                        render: function (d) {
                            return moment(d).format("DD/MM/YYYY");
                        }},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRowBTB');
                },
                "order": []
            });

            $('#modalHelp').modal('show');
        }

        function viewData(noDoc) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/pembatalan/viewdata',
                type: 'post',
                data: {
                    noDoc:noDoc,
                    typeTrn:typeTrn
                }, beforeSend : () => {
                    $('#modalHelp').modal('hide');
                    $('#modal-loader').modal('show');
                    tableInquery.clear();
                },
                success: function (result) {
                    console.log(result);
                    let grantTotal = 0;
                    $('#modal-loader').modal('hide');

                    if (result.length > 0){
                        $('#noBTB').val(result[0].mstd_nodoc);
                        $('#namaSupplier').val(result[0].supplier);

                        for (let i = 0; i < result.length; i++) {
                            let tempQty = result[i]['qty'] / result[i]['prd_frac'];
                            let qty = (!tempQty) ? 1 : tempQty;

                            tableInquery.row.add(
                                [result[i]['mstd_prdcd'], result[i]['barang'], result[i]['satuan'], qty, convertToRupiah(result[i]['hpp']), convertToRupiah(result[i]['ppntot'])]
                            ).draw();

                            grantTotal = parseInt(grantTotal) + parseInt(result[i]['ppntot']);
                        }

                        $('#grantTotal').val(convertToRupiah(grantTotal));
                    } else {
                        $('#modal-loader').modal('hide');
                        alertError('Data Tidak Ada!', '');
                        $('#noBTB').val('');
                        $('#jmlItem').val('');
                        $('#grantTotal').val('');
                        tableInquery.row.add(
                            ['--','--','--','--','--','--']
                        ).draw();
                    }
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message)
                }
            });
        }

        $(document).on('click', '.modalRowBTB', function () {
            let currentButton = $(this);
            let noDoc   = currentButton.children().first().text();

            viewData(noDoc);
        });

        $('#noBTB').keypress(function (e) {
            if(e.which === 13){
                let noDoc = $(this).val().toUpperCase();

                viewData(noDoc)
            }
        });

        function batalBPB() {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/penerimaan/pembatalan/batalbpb',
                type: 'post',
                data: {
                    noDoc:$('#noBTB').val(),
                    typeTrn:typeTrn,
                    supplier : $('#namaSupplier').val()
                }, beforeSend : () => {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    tableInquery.clear().draw();
                    $('#noBTB').val('');
                    $('#namaSupplier').val('');
                    $('#grantTotal').val('');

                    if (result.kode == 1){
                        swal('Success', result.msg, 'success');
                    } else {
                        swal('Warning', result.msg, 'warning');
                    }

                    $.getJSON("https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=3671", function (result) {
                        console.log(result)
                    })

                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message)
                }
            });
        }

    </script>

@endsection
