@extends('navbar')
@section('title','Input | pembatalan BA Pemusnahan')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card">
                    <legend  class="w-auto ml-5">IGR BO INQUERY BAPB</legend>
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">No BAPB</label>
                                        <input type="text" id="noDoc" class="form-control col-sm-5 mx-sm-1">
                                        <button class="btn ml-2" type="button" data-toggle="modal" data-target="#m_noDoc"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">No REF</label>
                                        <input type="text" id="noRef" class="form-control col-sm-5 mx-sm-1" disabled>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Tanggal</label>
                                        <input type="text" id="tglBAPB" class="form-control col-sm-5 mx-sm-1" disabled>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Tanggal</label>
                                        <input type="text" id="tglRef" class="form-control col-sm-5 mx-sm-1" disabled>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                                <table class="table table-striped table-bordered hover" id="tableDetail" style="width:100%">
                                    <thead class="">
                                    <tr class="text-center">
                                        <th rowspan="2" style="width: 50px">PLU</th>
                                        <th rowspan="2" style="width: 800px">Nama Barang</th>
                                        <th rowspan="2" style="width: 60px">Kemasan</th>
                                        <th colspan="2" style="width: 30px">Kuantum</th>
                                        <th rowspan="2" style="width: 80px">H.P.P</th>
                                        <th rowspan="2" style="width: 80px">Total</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 10px">QTYK</th>
                                        <th style="width: 10px">QTY</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyTableDetail">
                                    </tbody>
                                </table>
                                <p class="text-secondary text-right text-danger">* Klik Plu Untuk Detail</p>
                                <div class="mt-2">
                                    <div class="row">
                                        <label class="col-sm-0 ml-3 col-form-label">Total Item</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control text-right" id="totalItem" disabled>
                                        </div>
                                        <label class="col-sm-0 offset-sm-7 col-form-label">Total Rp.</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-right" id="totalGross" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal LOV-->
    <div class="modal fade" id="m_noDoc" tabindex="-1" role="dialog" aria-labelledby="m_noDoc" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov" type="text" placeholder="Find No Doc" aria-label="Search">
                    </div>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th>No Dokumen</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp">
                                        @foreach($noDoc as $data)
                                            <tr class="modalRow" onclick="chooseDoc({{$data->mstd_nodoc}})">
                                                <td>{{$data->mstd_nodoc}}</td>
                                                <td>{{date('d-M-y', strtotime($data->mstd_tgldoc))}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <p class="text-hide" id="idModal"></p>
                                    <p class="text-hide" id="idRow"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail PLU--}}
    <div class="modal fade" id="m_detail" tabindex="-1" role="dialog" aria-labelledby="m_detail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <form>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">PLU</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="prdcd" disabled>
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="deskripsi" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kemasan</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="kemasan" disabled>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-right">Tag</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="tag" disabled>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-right">BKP</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="bkp" disabled>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-right">Bandrol</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control" id="bandrol" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Last Cost Rp.</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-right" id="lastCost" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Avg Cost Rp.</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-right" id="avgCost" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Persediaan</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control text-right" id="qty" disabled>
                                        </div>
                                        <label class="col-sm-0 col-form-label text-center">+</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control text-right" id="qtyk" disabled>
                                        </div>
                                        <label class="col-sm-1 col-form-label text-left">Pcs</label>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Hrg Satuan Rp.</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-right" id="hrgSatuan" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Kuantum</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-right" id="kuantum" disabled>
                                        </div>
                                        <label class="col-sm-0 offset-sm-5 col-form-label text-center">Rp.</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-right" id="gross" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Keterangan</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control" id="keterangan" disabled>
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
        .row:hover{
            cursor: pointer;
        }
    </style>

    <script>
        let tableDetail;

        $(document).ready(function () {
            tableDetail = $('#tableDetail').DataTable({
                "columns": [
                    null,
                    null,
                    null,
                    {className: "text-right"},
                    {className: "text-right"},
                    {className: "text-right"},
                    {className: "text-right"},
                ],
            });
        });

        function chooseDoc(noDoc) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/pemusnahan/inquerybapb/getdetaildoc',
                type: 'post',
                data: {noDoc:noDoc},
                beforeSend: function (){
                    $('#m_noDoc').modal('hide');
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    tableDetail.clear().draw();
                    $('#modal-loader').modal('hide');
                    let temp = 0;

                    if (result.kode === 1){
                        $('#noDoc').val(noDoc);

                        $('#noRef').val(result.data[0]['mstd_noref3']);
                        $('#tglBAPB').val(formatDate(result.data[0]['mstd_tgldoc']));
                        $('#tglRef').val(formatDate(result.data[0]['mstd_tgref3']));

                        for (i = 0; i< result.data.length; i++){
                            tableDetail.row.add(
                                [result.data[i]['mstd_prdcd'], result.data[i]['prd_deskripsipanjang'].toUpperCase(), result.data[i]['mstd_unit'] + '/' + result.data[i]['mstd_frac'], '0',
                                    result.data[i]['mstd_qty'], convertToRupiah(result.data[i]['mstd_ocost']), convertToRupiah(result.data[i]['mstd_gross'])]
                            ).draw();

                            temp = temp + parseFloat(result.data[i]['mstd_gross']);
                        }

                        $('#totalItem').val(result.data.length);
                        $('#totalGross').val(convertToRupiah(temp));
                    } else {
                        swal(result.data, '', 'warning');
                        $('#noDoc').val('');
                        $('#noRef').val('');
                        $('#tglBAPB').val('');
                        $('#tglRef').val('');
                        $('#totalItem').val('');
                        $('#totalGross').val('');
                    }
                }, error: function (error) {
                    swal('Error', '', 'error');
                    console.log(error)
                }
            })
        }

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let search = $('#searchModal').val();

                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/transaksi/pemusnahan/inquerybapb/searchdoc',
                    type: 'post',
                    data: {search:search},
                    success: function (result) {
                        console.log(result)
                        $('.modalRow').remove();
                        if (result){
                            for (i = 0; i< result.length; i++){
                                $('#tbodyModalHelp').append("<tr onclick=chooseDoc('"+ result[i].mstd_nodoc +"') class='modalRow'><td>"+ result[i].mstd_nodoc +"</td> <td>"+ formatDateCustom(result[i].mstd_tgldoc, 'd-M-y') +"</td></tr>")
                            }
                        }
                    }, error: function (error) {
                        swal('Error', '', 'error');
                        console.log(error)
                    }
                })
            }
        });

        $('#noDoc').keypress(function (e) {
            if (e.which === 13) {
                let search = $('#noDoc').val();

                chooseDoc(search)
                return false;
            }
        });

        $('#tableDetail tbody').on( 'click', 'tr', function () {
            let plu = tableDetail.row( this ).data();
            let doc = $('#noDoc').val();

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/pemusnahan/inquerybapb/detailplu',
                type: 'post',
                data: {plu:plu[0], doc:doc},
                success: function (result) {
                    let data = result[0];
                    $('#m_detail').modal('show');

                    $('#prdcd').val(data.plu);
                    $('#deskripsi').val(data.barang);
                    $('#kemasan').val(data.unit + '/' + data.frac);
                    $('#tag').val(data.tag);
                    $('#bkp').val(data.bkp);
                    $('#bandrol').val(data.bandrol);
                    $('#lastCost').val(convertToRupiah(data.lcost));
                    $('#avgCost').val(convertToRupiah(data.tempAcost));
                    $('#qty').val(data.tempQty);
                    $('#qtyk').val(data.tempQtyk);
                    $('#hrgSatuan').val(convertToRupiah(data.hrgsatuan));
                    $('#kuantum').val(data.qty);
                    $('#gross').val(convertToRupiah(data.gross));
                    $('#keterangan').val(data.keterangan);
                }, error: function (error) {
                    swal('Error', '', 'error');
                    console.log(error)
                }
            })
        } );

    </script>
@endsection
