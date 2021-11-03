@extends ('navbar')
@section('title','BARANG HILANG | INQUERY NBH')
@section ('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card">
                    <legend  class="w-auto ml-5">INQUERY NBH</legend>
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">NO NBH</label>
                                        <div class="col-sm-6 buttonInside">
                                            <input type="text" id="no-nbh" class="form-control">
                                            <button id="btn-no-nbh" class="btn btn-lov p-0" type="button" data-toggle="modal" data-target="#modal-nonbh">
                                                <img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">NO REF</label>
                                        <div class="col-sm-6">
                                            <input type="text" id="no-ref" class="form-control" disabled>
                                        </div>

                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">TANGGAL</label>
                                        <input type="text" id="tgl-nbh" class="form-control col-sm-5 mx-sm-1" disabled>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">TANGGAL</label>
                                        <input type="text" id="tgl-ref" class="form-control col-sm-5 mx-sm-1" disabled>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12">
                                <hr>
                                <table class="table table-striped table-bordered hover" id="tableDetail" style="width:100%">
                                    <thead class="header-table" style="color: white">
                                    <tr class="text-center">
                                        <th rowspan="2" style="width: 50px">PLU</th>
                                        <th rowspan="2" style="width: 800px">NAMA BARANG</th>
                                        <th rowspan="2" style="width: 60px">KEMASAN</th>
                                        <th colspan="2" style="width: 30px">KUANTUM</th>
                                        <th rowspan="2" style="width: 80px">H.P.P</th>
                                        <th rowspan="2" style="width: 80px">TOTAL</th>
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
                                        <label class="col-sm-0 ml-5 col-form-label">TOTAL ITEM</label>
                                        <div class="col-sm-1">
                                            <input type="text" class="form-control text-right" id="total-item" disabled>
                                        </div>
                                        <label class="col-sm-0 offset-sm-6 col-form-label">TOTAL Rp.</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-right" id="total-rp" disabled>
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

    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12 text-center">
                                <label for="">LOADING...</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-nonbh" tabindex="-1" role="dialog" aria-labelledby="modal-nonbh" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov" type="text" placeholder="..." aria-label="Search">
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th>No. NBH</th>
                                            <th>Tanggal</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp">
                                        @foreach($result as $data)
                                            <tr class="modalRow" onclick="showDoc({{$data->msth_nodoc}})">
                                                <td>{{$data->msth_nodoc}}</td>
                                                <td>{{date('d-M-y', strtotime($data->msth_tgldoc))}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
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
        .header-table{
            background: #0079C2;
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

        $(document).on('keypress', '#no-nbh', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let nonbh = $('#no-nbh').val();
                showDoc(nonbh);
            }
        });

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let search = $('#searchModal').val();
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/lov_NBH',
                    type: 'post',
                    data: {search:search},
                    success: function (result) {
                        $('.modalRow').remove();
                        for (i = 0; i < result.length; i++){
                            let temp = `<tr class="modalRow" onclick=showDoc('`+ result[i].msth_nodoc+`')>
                                        <td>`+ result[i].msth_nodoc +`</td>
                                        <td>`+ formatDateCustom(result[i].msth_tgldoc, 'd-M-y') +`</td>
                                     </tr>`;
                            $('#tbodyModalHelp').append(temp);
                        }
                    }, error: function () {
                        alert('error');
                    }
                });
            }
        })

        function showDoc(nonbh){
            $('#modal-nonbh').modal('hide');
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/showDoc',
                type: 'post',
                data: {nonbh: nonbh},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    tableDetail.clear().draw();
                    $('#modal-loader').modal('hide');

                    let temp = 0;

                    if (result) {
                        console.log(result)
                        var i;
                        for (i = 0; i < result.length; i++) {
                            qty = result[i].mstd_qty / result[i].mstd_frac;
                            qtyk = result[i].mstd_qty % result[i].mstd_frac;

                            tableDetail.row.add(
                                [result[i]['mstd_prdcd'], result[i]['prd_deskripsipanjang'].toUpperCase(), result[i]['mstd_unit'] + '/' + result[i]['mstd_frac'], Math.floor(qty),
                                    Math.floor(qtyk), convertToRupiah(result[i]['mstd_hrgsatuan']), convertToRupiah(result[i]['mstd_gross'])]
                            ).draw();

                            temp = temp + parseFloat(result[i]['mstd_gross']);

                            $('#no-nbh').val(result[i].mstd_nodoc);
                            $('#tgl-nbh').val(formatDateCustom(result[i].mstd_tgldoc, 'd-M-y'));
                            $('#no-ref').val(result[i].mstd_nopo);
                            $('#tgl-ref').val(formatDate(result[i].mstd_tglpo));
                            $('#total-item').val(result.length);
                            $('#total-rp').val(convertToRupiah(temp));
                        }
                    } else {
                        swal()
                        $('#no-nbh').val('');
                        $('#tgl-nbh').val('');
                        $('#no-ref').val('');
                        $('#tgl-ref').val('');
                        $('#total-item').val('');
                        $('#total-rp').val('');
                    }
                }, error: function () {
                    alert('error');
                }
            })
        }

        $('#tableDetail tbody').on('click', 'tr', function () {
            let plu = tableDetail.row(this).data();
            let nonbh = $('#no-nbh').val();

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/detail_Plu',
                type: 'post',
                data: {plu:plu[0], nonbh:nonbh},
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
                    $('#keterangan').val(data.keter);
                }, error: function (error) {
                    swal('Error', '', 'error');
                    console.log(error)
                }
            })
        } );


    </script>

@endsection
