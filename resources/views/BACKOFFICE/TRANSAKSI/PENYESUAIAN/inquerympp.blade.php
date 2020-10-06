@extends('navbar')

@section('title','Inquery MPP')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">Inquery MPP</legend>
                    <fieldset class="card border-secondary m-2">
                        <div class="card-body">
                            <div class="row form-group">
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">No MPP :</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control" id="nompp" disabled>
                                </div>
                                <div class="col-sm-1">
                                    <button class="btn btn-primary rounded-circle" id="btn_lov" data-toggle="modal" data-target="#m_lov" disabled>
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal MPP :</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control" id="tglmpp" disabled>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">No Referensi :</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control" id="noref" disabled>
                                </div>
                                <div class="col-sm-1"></div>
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal Referensi :</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control" id="tglref" disabled>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary m-2">
                        <div class="card-body">
                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden" style="position: sticky">
                                <table id="table_data" class="table table-sm table-bordered mb-3 text-center">
                                    <thead>
                                    <tr>
                                        <th><i class="fas fa-info"></i> </th>
                                        <th>Kode</th>
                                        <th>Nama Barang</th>
                                        <th>Kemasan</th>
                                        <th>Kuantum</th>
                                        <th>HPP</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row form-group mt-3 mb-0">
                                <label for="" class="col-sm-2 text-right col-form-label">Total Item</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control" id="totalitem" disabled>
                                </div>
                                <label for="" class="col-sm-6 text-right col-form-label pr-0">Total Rp</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control" id="total" disabled>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov">
                                    <thead>
                                        <tr>
                                            <th>No MPP</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pr-0">PLU</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="d_prdcd" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pr-0">KEMASAN</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="d_kemasan" disabled>
                            </div>
                            <label class="col-sm-1 text-right col-form-label">TAG</label>
                            <div class="col-sm-1 pr-0 pl-0">
                                <input type="text" class="form-control" id="d_tag" disabled>
                            </div>
                            <label class="col-sm-2 text-right col-form-label">BANDROL</label>
                            <div class="col-sm-1 pr-0 pl-0">
                                <input type="text" class="form-control" id="d_bandrol" disabled>
                            </div>
                            <label class="col-sm-1 text-right col-form-label">BKP</label>
                            <div class="col-sm-1 pl-0">
                                <input type="text" class="form-control" id="d_bkp" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pr-0">LCOST</label>
                            <div class="col-sm-4 pr-0">
                                <input type="text" class="form-control text-right" id="d_lcost" disabled>
                            </div>
                            <label class="col-sm-2 text-right col-form-label pr-0">ACOST. RP</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-right" id="d_acost" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pr-0">PERSEDIAAN</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-right" id="d_persediaan1" disabled>
                            </div>
                            <label class="text-right col-form-label">+</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-right" id="d_persediaan2" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pr-0 pl-0">HARGA SATUAN</label>
                            <div class="col-sm-4 pr-0">
                                <input type="text" class="form-control text-right" id="d_hargasatuan" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pr-0">KUANTUM</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-right" id="d_kuantum1" disabled>
                            </div>
                            <div class="col-sm-1 pl-0 pr-0">
                                <input type="text" class="form-control" id="d_kuantum2" disabled>
                            </div>
                            <label class="text-right col-form-label pl-2">+</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-right" id="d_kuantum3" disabled>
                            </div>
                            <label class="text-right col-form-label pl-2 pr-3"><i class="fas fa-arrow-right"></i></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-right" id="d_kuantum4" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label pr-0">KETERANGAN</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="d_keterangan" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }
        label {
            color: #232443;
            font-weight: bold;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov{
            position:absolute;
            right: 20px;
            top: 4px;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .row-lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 430px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        #table_data td{
            vertical-align: middle;
        }

    </style>

    <script>
        var nompp;

        $(document).ready(function(){
            $('#table_lov').DataTable({
                "ajax": '{{ url('/bo/transaksi/penyesuaian/inquerympp/get-data-lov') }}',
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
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov').css({'cursor': 'pointer'});
                    $('#btn_lov').prop('disabled', false);
                }
            });
        });

        $(document).on('click', '.row-lov', function (e) {
            nompp = $(e.target).parent().find('td').html();
            tglmpp = $(e.target).parent().find('td').next().html();
            $('#nompp').val(nompp);
            $('#tglmpp').val(tglmpp);
            $('#m_lov').modal('hide');

            getData(nompp);
        });

        function getData(nompp){
            $.ajax({
                type: "GET",
                url: "{{ url('/bo/transaksi/penyesuaian/inquerympp/get-data') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {nompp: nompp},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('#table_data tbody tr').remove();
                    total = 0;

                    $('#noref').val(response[0].msth_noref3);
                    $('#tglref').val(response[0].msth_tgref3);

                    for(i=0;i<response.length;i++){
                        html = `<tr>
                                    <td><button class="btn btn-primary" onclick="getDetail('${response[i].mstd_prdcd}')"><i class="fas fa-info"></i></button></td>
                                    <td>${response[i].mstd_prdcd}</td>
                                    <td>${response[i].prd_deskripsipanjang}</td>
                                    <td>${response[i].prd_unit}</td>
                                    <td>${response[i].mstd_qty}</td>
                                    <td>${convertToRupiah(response[i].mstd_hrgsatuan)}</td>
                                    <td>${convertToRupiah2(response[i].mstd_gross)}</td>
                                </tr>`;

                        total += parseFloat(response[i].mstd_gross);

                        $('#table_data tbody').append(html);
                    }

                    $('#totalitem').val(response.length);
                    $('#total').val(convertToRupiah2(total));
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: error.responseJSON.exception,
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {
                        $('#noref').val('');
                        $('#tglref').val('');
                        $('#table_data tbody tr').remove();
                        $('#totalitem').val('');
                        $('#total').val('');
                    });
                }
            });
        }

        function getDetail(prdcd){
            $.ajax({
                type: "GET",
                url: "{{ url('/bo/transaksi/penyesuaian/inquerympp/get-detail') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    nompp: nompp,
                    prdcd: prdcd
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    data = response[0];

                    $('#d_prdcd').val(data.barang);
                    $('#d_kemasan').val(data.kemasan);
                    $('#d_tag').val(data.tag);
                    $('#d_bandrol').val(data.bandrol);
                    $('#d_bkp').val(data.bkp);
                    $('#d_lcost').val(convertToRupiah(data.lastcost));
                    $('#d_acost').val(convertToRupiah(data.avgcost));
                    $('#d_persediaan1').val(data.persediaan);
                    $('#d_persediaan2').val(data.persediaan2);
                    $('#d_hargasatuan').val(convertToRupiah(data.hrgsat));
                    $('#d_kuantum1').val(data.qty);
                    $('#d_kuantum2').val(data.unit);
                    $('#d_kuantum3').val(data.qtyk);
                    $('#d_kuantum4').val('Rp ' + convertToRupiah(data.gross));
                    $('#d_keterangan').val(data.ket);

                    $('#m_detail').modal('show');
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: error.responseJSON.exception,
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {
                        $('#m_detail input').val('');
                    });
                }
            });
        }
    </script>

@endsection
