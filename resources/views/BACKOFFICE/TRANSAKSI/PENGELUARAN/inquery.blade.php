@extends('navbar')
@section('title','INQUERY NPB')
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
                                    <div class="form-group row mb-1">

                                        <label class="col-sm-2 col-form-label text-sm-right">Nomor
                                            NPB</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" class="form-control" id="txtNoDoc">
                                            <button type="button" class="btn btn-lov p-0" data-target="#m_lov_npb"
                                                    data-toggle="modal" id="btn-lov-npb">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-right">Tanggal</label>
                                        <div class="col-sm-2">
                                            <input type="text" id="txtTanggalNPB"
                                                   class="text-center form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1">
                                        <label class="col-sm-2 col-form-label text-sm-right">Supplier</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="txtSupplier"
                                                   class="text-center form-control" disabled>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-right"
                                        >PKP</label>
                                        <div class="col-sm-1">
                                            <input type="text" id="txtPKP"
                                                   class="text-center form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">

                                        <label class="col-sm-2 col-form-label text-sm-right">Faktur
                                            Pajak : No</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="txtFakturPajak" disabled>
                                        </div>
                                        <label class="col-form-label text-sm-right col-sm-1"
                                        >Tanggal</label>
                                        <div class="col-sm-2">
                                            <input type="text" id="txtTglFaktur"
                                                   class="form-control text-center" disabled>
                                            <input type="hidden" id="txtNoRef3"
                                                   class="form-control text-center" disabled>
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
                        <div class="card-body p-0 tableFixedHeader" style="height: 350px;">
                            <table class="table table-sm table-striped table-bordered "
                                   id="table">
                                <thead class="theadDataTables">
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small"></th>
                                    <th width="10%" class="text-center small">PLU</th>
                                    <th width="20%" class="text-center small">Nama Barang</th>
                                    <th width="10%" class="text-center small">Satuan</th>
                                    <th width="7%" class="text-center small">Qty</th>
                                    <th width="7%" class="text-center small">Qtyk</th>
                                    <th width="7%" class="text-center small">H.P.P</th>
                                    <th width="7%" class="text-center small">Total</th>
                                </tr>
                                </thead>
                                <tbody id="body-table">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Total</legend>
                    <div class="card-body cardForm">
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right">TOTAL
                                ITEM</label>
                            <input type="text" id="total-item"
                                   class="text-center form-control  col-sm-2" disabled>
                            <label class="col-sm-1 col-form-label text-sm-right offset-5"
                            >GROSS</label>
                            <input type="text" id="gross"
                                   class="text-center form-control  col-sm-2" disabled>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-8">POTONGAN</label>
                            <input type="text" id="potongan"
                                   class="text-center form-control  col-sm-2" disabled>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-8"
                            >PPN</label>
                            <input type="text" id="ppn"
                                   class="text-center form-control  col-sm-2" disabled>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-sm-1 col-form-label text-sm-right offset-8"
                            >TOTAL</label>
                            <input type="text" id="total"
                                   class="text-center form-control  col-sm-2" disabled>
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

    {{--MODAL DETAIL--}}
    <div class="modal fade" id="m_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label text-sm-left">PLU</label>
                            <label class="col-sm-1 col-form-label text-sm-right">:</label>
                            <input type="text" id="dplu" class="text-left form-control col-sm-8" disabled>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-sm-left">KEMASAN</label>
                            <div class="col-sm-2 m-0 p-0 row">
                                <label class="col-sm-2 col-form-label text-sm-left">:</label>
                                <input type="text" id="dsatuan" class="text-center form-control col-sm-10" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-left ">TAG :</label>
                            <input type="text" id="dtag"
                                   class="text-center form-control col-sm-1" disabled>
                            <label class="col-sm-1 col-form-label text-sm-left">BANDROL</label>
                            <input type="text" id="dbandrol" class="text-center form-control col-sm-1" disabled>
                            <label class="col-sm-1 col-form-label text-sm-left ">BKP :</label>
                            <input type="text" id="bkp" class="text-center form-control col-sm-1" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-sm-left ">LCOST</label>
                            <div class="col-sm-2 m-0 p-0 row">
                                <label class="col-sm-3 col-form-label text-sm-left p-0">: Rp.</label>
                                <input type="text" id="lcost" class="text-center form-control col-sm-9" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-left ">ACOST</label>
                            <div class="col-sm-3 m-0 p-0 row">
                                <label class="col-sm-3 col-form-label text-sm-left ">: Rp.</label>
                                <input type="text" id="acost" class="text-center form-control col-sm-9" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-sm-left">PERSEDIAAN</label>
                            <div class="col-sm-2 m-0 p-0 row">
                                <label class="col-sm-2 col-form-label text-sm-left">:</label>
                                <input type="text" id="dstok" class="text-center form-control col-sm-10" disabled>
                            </div>
                            <div class="col-sm-2 m-0 p-0 row">
                                <label class="col-sm-2 col-form-label text-sm-left">+</label>
                                <input type="text" id="dstok2" class="text-center form-control col-sm-10" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-left">PCS</label>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-sm-left">HRG SATUAN</label>
                            <div class="col-sm-2 m-0 p-0 row">
                                <label class="col-sm-3 col-form-label text-sm-left p-0">: Rp.</label>
                                <input type="text" id="dhrgsat" class="text-center form-control col-sm-9" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-sm-left">KUANTUM</label>
                            <div class="col-sm-2 m-0 p-0 row">
                                <label class="col-sm-2 col-form-label text-sm-left">:</label>
                                <input type="text" id="dqty" class="text-center form-control col-sm-10" disabled>
                            </div>
                            <input type="text" id="dunit" class="text-center form-control col-sm-1" disabled>
                            <div class="col-sm-2 m-0 p-0 row">
                                <label class="col-sm-2 col-form-label text-sm-left">+</label>
                                <input type="text" id="dqtyk" class="text-center form-control col-sm-8" disabled>
                                <label class="col-sm-2 col-form-label text-sm-left">PCS</label>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">Rp.</label>
                            <input type="text" id="drp1"
                                   class="text-center form-control col-sm-2" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-sm-left">POTONGAN</label>
                            <div class="col-sm-1 m-0 p-0 row">
                                <label class="col-sm-1 col-form-label text-sm-left">:</label>
                                <input type="text" id="persen1" class="text-center form-control col-sm-8" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">= Rp. </label>
                            <div class="col-sm-2 m-0 p-0 row">
                                <input type="text" id="drp2" class="text-center form-control col-sm-10" disabled>
                                <label class="col-sm-1 col-form-label text-sm-left">PCS</label>
                            </div>
                            <label class="col-sm-2 col-form-label text-sm-right">Rp.</label>
                            <input type="text" id="drp3"
                                   class="text-center form-control col-sm-2" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-sm-left">PPN :</label>
                            <div class="col-sm-1 m-0 p-0 row">
                                <label class="col-sm-1 col-form-label text-sm-left">:</label>
                                <input type="text" id="persen2" class="text-center form-control col-sm-8" disabled>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">= Rp. </label>
                            <div class="col-sm-2 m-0 p-0 row">
                                <input type="text" id="drp4"
                                       class="text-center form-control col-sm-10" disabled>
                                <label class="col-sm-1 col-form-label text-sm-left">PCS</label>
                            </div>
                            <label class="col-sm-2 col-form-label text-sm-right">Rp.</label>
                            <input type="text" id="drp5"
                                   class="text-center form-control col-sm-2" disabled>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label text-sm-left">KETERANGAN</label>
                            <label class="col-sm-1 col-form-label text-sm-right"> :</label>
                            <input type="text" id="dket" class="text-left form-control col-sm-8" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="icon fas fa-times"></i> CANCEL
                    </button>
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
                getDataNPB(no_npb);
            }
        });

        $('#table_lov_nonpb').DataTable({
            "ajax": '{{ url('/bo/transaksi/pengeluaran/inquery/get-data-lov-npb') }}',
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
            getDataNPB(no_npb);
        });

        function getDataNPB(no_npb) {
            gross = 0;
            ppn = 0;
            potongan = 0;
            total = 0;
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
                    "url": "{{ url('/bo/transaksi/pengeluaran/inquery/get-data-npb') }}",
                    "data": {
                        'no_npb': no_npb,
                    }
                },
                "columns": [
                    {
                    data: 'detail',
                    name: 'detail'
                    },
                    {
                        data: 'mstd_prdcd',
                        name: 'mstd_prdcd'
                    },
                    {
                        data: 'prd_deskripsipanjang',
                        name: 'prd_deskripsipanjang'
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
                        data: 'nprice',
                        name: 'nprice'
                    },
                    {
                        data: 'namt',
                        name: 'namt'
                    }
                ],
                "createdRow": function (row, data, dataIndex) {
                    $(row).children().first().next().css({
                        'vertical-align': 'middle'
                    });
                    $(row).children().first().next().next().css({
                        'vertical-align': 'middle'
                    });
                    $(row).children().first().next().next().next().css({
                        'vertical-align': 'middle',
                        'text-align': 'center'
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
                    $(row).children().first().next().next().next().next().next().next().next().css({
                        'vertical-align': 'middle',
                        'text-align': 'right'
                    });
                    $(row).children().last().css({
                        'vertical-align': 'middle',
                        'text-align': 'right'
                    });
                    // console.log(data);
                    // console.log(dataIndex);
                    $(row).children().first().next().next().next().next().text(convertToRupiah($(row).children().first().next().next().next().next().text()));
                    $(row).children().first().next().next().next().next().next().text(convertToRupiah($(row).children().first().next().next().next().next().next().text()));
                    $(row).children().first().next().next().next().next().next().next().text(convertToRupiah($(row).children().first().next().next().next().next().next().next().text()));
                    $(row).children().first().next().next().next().next().next().next().next().text(convertToRupiah($(row).children().first().next().next().next().next().next().next().next().text()));

                    $('#total-item').val(dataIndex + 1);

                    gross += parseFloat(data.mstd_gross);
                    potongan += parseFloat(data.mstd_discrph);
                    ppn += parseFloat(data.mstd_ppnrph);
                    total += parseFloat(data.totalall);



                   // $('#gross').val(convertToRupiah2(gross));
                   // $('#potongan').val(convertToRupiah2(potongan));
                   // $('#ppn').val(convertToRupiah2(ppn));
                   // $('#total').val(convertToRupiah2(total));

                    $('#gross').val(convertToRupiah2(Math.round(gross)));
                    $('#potongan').val(convertToRupiah2(Math.round(potongan)));
                    $('#ppn').val(convertToRupiah2(Math.round(ppn)));
                    $('#total').val(convertToRupiah2(Math.round(total)));


                    $('#txtTanggalNPB').val(data.msth_tgldoc);
                    $('#txtSupplier').val(data.supp);
                    $('#txtPKP').val(data.sup_pkp);
                    $('#txtFakturPajak').val(nvl(data.msth_istype, '') + '-' + nvl(data.msth_invno, ''));
                    $('#txtTglFaktur').val(data.msth_tglinv);
                    $('#txtNoRef3').val(data.mstd_noref3);

                    $('#modal-loader').modal('hide');

                }
            });
        }

        $(document).on('click', '.btn-detail', function () {
            var currentButton = $(this);
            var plu = currentButton.attr('plu');
            var noref3 = $('#txtNoRef3').val();
            var no_npb = $('#txtNoDoc').val();
            ajaxSetup();
            $.ajax({
                url: "{{ url('/bo/transaksi/pengeluaran/inquery/get-data-detail') }}",
                type: 'GET',
                data: {
                    no_npb: no_npb,
                    plu: plu,
                    noref3: noref3,
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    response = response.data;
                    console.log(response);
                    $('#modal-loader').modal('hide');
                    $('#m_detail').modal('show');

                    $('#dplu').val(response.dplu);
                    $('#dsatuan').val(response.dsatuan);
                    $('#dtag').val(response.dtag);
                    $('#dbandrol').val(response.dbandrol);
                    $('#bkp').val(response.bkp);
                    $('#lcost').val(convertToRupiah(response.dlcost));
                    $('#acost').val(convertToRupiah(response.dacost));
                    $('#dhrgsat').val(convertToRupiah(response.dhrgsat));
                    $('#dqty').val(response.dqty);
                    $('#dunit').val(response.dunit);
                    $('#dqtyk').val(response.dqtyk);
                    $('#drp1').val(convertToRupiah(response.drp1));
                    $('#persen1').val(Math.round(response.dpersen1));
                    $('#drp2').val(convertToRupiah(response.drp2));
                    $('#drp3').val(convertToRupiah(response.drp3));
                    $('#persen2').val(Math.round(response.dpersen2));
                    $('#drp4').val(convertToRupiah(response.drp4));
                    $('#drp5').val(convertToRupiah(response.drp5));
                    $('#dket').val(response.dket);
                    $('#dstok').val(Math.floor(response.dstok));
                    $('#dstok2').val(response.dstok2);
                }, error: function (error) {
                    console.log(error);
                }
            });
        });
    </script>


@endsection
