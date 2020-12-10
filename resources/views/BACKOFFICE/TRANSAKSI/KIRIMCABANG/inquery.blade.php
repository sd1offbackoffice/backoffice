@extends('navbar')

@section('title','KIRIM CABANG | INQUERY SJ')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <div class="row">
                            <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">NOMOR SJ</label>
                            <div class="col-sm-1 buttonInside">
                                <input type="text" class="form-control" id="notrn" disabled>
                                <button id="btn_lov_trn" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_trn" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">TANGGAL</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="tgltrn" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">UNTUK CABANG</label>
                            <div class="col-sm-1" style="position: relative">
                                <input maxlength="2" type="text" class="form-control" id="kodecabang" disabled>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="namacabang" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">NOMOR REFF</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="noreff" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">TANGGAL</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="tglreff" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">GUDANG</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="kodegudang" disabled>
                            </div>
                        </div>
                    </div>
                    <fieldset class="card border-secondary ml-2 mr-2 mt-0 mb-2">
                        <div class="card-body">
                            <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                <thead class="thColor">
                                    <tr>
                                        <th width="2%" class="align-middle" rowspan="2"><i class="fas fa-info"></i> </th>
                                        <th width="5%" class="align-middle" rowspan="2">PLU</th>
                                        <th width="25%" class="align-middle" rowspan="2">DESKRIPSI</th>
                                        <th width="6%" class="align-middle" rowspan="2">SATUAN</th>
                                        <th width="16%" class="align-middle" colspan="2">KUANTUM</th>
                                        <th width="8%" class="align-middle" rowspan="2">H.P.P</th>
                                        <th width="6%" class="align-middle" rowspan="2">TOTAL</th>
                                    </tr>
                                    <tr>
                                        <th width="">CTN</th>
                                        <th width="">PCS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="row mt-1">
                                <label class="col-sm-1 pr-0 text-right col-form-label">TOTAL ITEM</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" id="totalitem" disabled>
                                </div>
                                <div class="col-sm-7"></div>
                                <label class="col-sm-1 pr-0 text-right col-form-label">TOTAL</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control text-right" id="total" disabled>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_trn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_trn">
                                    <thead>
                                    <tr>
                                        <th>Nomor Dokumen</th>
                                        <th>Tanggal</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <label class="col-sm-2 pr-0 text-right col-form-label">PLU</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="d_plu" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pr-0 text-right col-form-label">KEMASAN</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="d_kemasan" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">TAG</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="d_tag" disabled>
                            </div>
                            <label class="col-sm-2 pr-0 text-right col-form-label">BANDROL</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="d_bandrol" disabled>
                            </div>
                            <label class="col-sm-2 pr-0 text-right col-form-label">BKP</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="d_bkp" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pr-0 text-right col-form-label">LCOST</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-right" id="d_lcost" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-right col-form-label">ACOST</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-right" id="d_acost" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pr-0 text-right col-form-label">PERSEDIAAN</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="d_persediaan" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-center col-form-label"><i class="fas fa-plus"></i></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="d_pcs" disabled>
                            </div>
                            <label class="col pl-0 text-left col-form-label">PCS</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pr-0 text-right col-form-label">HARGA SATUAN</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-right" id="d_hrgsatuan" disabled>
                            </div>
                            <div class="col-sm-2"></div>
                            <label class="col-sm-2 pr-0 text-right col-form-label">DPP</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-right" id="d_drp3" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pr-0 text-right col-form-label">KUANTUM</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="d_kqty" disabled>
                            </div>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="d_kunit" disabled>
                            </div>
                            <label class="col-sm-1 pr-0 text-center col-form-label"><i class="fas fa-plus"></i></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="d_kqtyk" disabled>
                            </div>
                            <label class="col pl-0 text-left col-form-label">PCS</label>
                            <label class="col-sm-1 pr-0 text-right col-form-label">GROSS</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-right" id="d_drp1" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pr-0 text-right col-form-label">POTONGAN</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-right" id="d_prs1" disabled>
                            </div>
                            <div class="col-sm-3"></div>
                            <label class="col-sm-2 pr-0 text-right col-form-label">POTONGAN</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-right" id="d_drp2" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pr-0 text-right col-form-label">PPN</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-right" id="d_prs2" disabled>
                            </div>
                            <div class="col-sm-3"></div>
                            <label class="col-sm-2 pr-0 text-right col-form-label">PPN</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-right" id="d_drp4" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-7"></div>
                            <label class="col-sm-2 pr-0 text-right col-form-label">TOTAL</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-right" id="d_drp5" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pr-0 text-right col-form-label">KETERANGAN</label>
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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang{
            position:absolute;
            bottom: 10px;
            right: 3vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .btn-lov-plu{
            position:absolute;
            bottom: 10px;
            right: 2vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .modal thead tr th{
            vertical-align: middle;
        }
    </style>

    <script>
        var nosj;
        var data = [];

        $(document).ready(function(){
            tgltrn = $('#tgltrn').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            tabel = $('#table_daftar').DataTable({
                "scrollY": "50vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });

            getLov();
        });

        function getLov(){
            lovtrn = $('#table_lov_trn').DataTable({
                "ajax": '{{ url('/bo/transaksi/kirimcabang/inquery/get-data-lov') }}',
                "columns": [
                    {data: 'no', name: 'no'},
                    {data: 'tgl', name: 'tgl'},
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
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_trn').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-trn', function (e) {
                        nosj = $(this).find('td:eq(0)').html();

                        $('#m_lov_trn').modal('hide');
                        getData(nosj);
                    });
                }
            });
        }

        function getData(nosj){
            $.ajax({
                type: "GET",
                url: "{{ url('/bo/transaksi/kirimcabang/inquery/get-data') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {no: nosj},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if($.fn.DataTable.isDataTable('#table_daftar')){
                        $('#table_daftar').DataTable().destroy();
                        $("#table_daftar tbody [role='row']").remove();
                    }

                    $('#notrn').val(response[0].msth_nodoc);
                    $('#tgltrn').val(response[0].msth_tgldoc);
                    $('#noreff').val(response[0].msth_noref3);
                    $('#tglreff').val(response[0].msth_tgref3);
                    $('#kodecabang').val(response[0].msth_loc);
                    $('#namacabang').val(response[0].cab_namacabang);
                    $('#kodegudang').val(response[0].msth_loc2);

                    $('#totalitem').val(response.length);

                    data = response;

                    total = 0;

                    for(i=0;i<response.length;i++){
                        html = `<tr class="row${i})">
                                <td><button class="btn btn-sm btn-primary" onclick="detailItem(${i})"><i class="fas fa-info"></i></button></td>
                                <td>${response[i].mstd_prdcd}</td>
                                <td class="text-left">${response[i].prd_deskripsipanjang}</td>
                                <td>${response[i].satuan}</td>
                                <td>${response[i].mstd_qtyk}</td>
                                <td>${response[i].mstd_qty}</td>
                                <td class="text-right">${convertToRupiah(response[i].nprice)}</td>
                                <td class="text-right">${convertToRupiah(response[i].namt)}</td>
                            </tr>`;

                        $('#table_daftar tbody').append(html);

                        total += parseFloat(response[i].namt);
                    }

                    $('#total').val(convertToRupiah(total));

                    tabel = $('#table_daftar').DataTable({
                        "scrollY": "50vh",
                        "paging" : false,
                        "sort": false,
                        "bInfo": false,
                        "searching": false
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

                    });
                }
            });
        }

        function detailItem(i){
            d = data[i];

            $('#d_plu').val(d.mstd_prdcd + ' - ' + d.prd_deskripsipanjang);
            $('#d_kemasan').val(d.satuan);
            $('#d_tag').val(d.tag);
            $('#d_bandrol').val(d.bandrol);
            $('#d_bkp').val(d.bkp);
            $('#d_lcost').val('Rp ' + convertToRupiah(d.lastcost));
            $('#d_acost').val('Rp ' + convertToRupiah(d.avgcost));
            $('#d_hrgsatuan').val('Rp ' + convertToRupiah(d.hrgsat));
            $('#d_kqty').val(d.qty);
            $('#d_kunit').val(d.unit);
            $('#d_kqtyk').val(d.qtyk);
            $('#d_prs1').val( parseFloat(d.discrph * 100 / d.gross).toFixed(2));
            $('#d_prs2').val( parseFloat(d.ppnrph * 100 / (d.gross - d.discrph)).toFixed(2));
            $('#d_drp1').val('Rp ' + convertToRupiah(d.gross));
            $('#d_drp2').val('Rp ' + convertToRupiah(d.discrph));
            $('#d_drp3').val('Rp ' + convertToRupiah(d.gross - d.discrph));
            $('#d_drp4').val('Rp ' + convertToRupiah(d.ppnrph));
            $('#d_drp5').val('Rp ' + convertToRupiah(parseFloat(d.gross - d.discrph + parseFloat(d.ppnrph))));
            $('#d_keterangan').val(d.ket);

            $('#m_detail').modal('show');
        }

    </script>

@endsection
