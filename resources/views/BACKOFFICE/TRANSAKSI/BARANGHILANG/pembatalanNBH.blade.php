@extends ('navbar')
@section ('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Pembatalan NBH</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="no-nbh" class="col-sm-2 col-form-label text-right">NOMOR NBH</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="no-nbh">
                                        </div>
                                        <button type="button" class="btn p-0" data-toggle="modal" data-target="#modal-NBH">
                                            <img src="{{asset('image/icon/help.png')}}" width="30px">
                                        </button>
                                        <button type="button" class="btn btn-danger col-sm-2 offset-sm-1" id="btn-hapus">
                                            HAPUS NBH
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Detail</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="col-sm-12">
                            <div class="tableFixedHeader">
                                <table class="table table-striped table-bordered" id="table-detail">
                                    <thead class="thead-dark">
                                    <tr class="d-flex text-center">
                                        <th style="width: 150px">PLU</th>
                                        <th style="width: 400px">NAMA BARANG</th>
                                        <th style="width: 130px">KEMASAN</th>
                                        <th style="width: 160px">KUANTUM</th>
                                        <th style="width: 120px">H.P.P</th>
                                        <th style="width: 150px">TOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    </tbody>
                                </table>
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

    <div class="modal fade" id="modal-NBH" tabindex="-1" role="dialog" aria-labelledby="modal-NBH" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov" type="text" placeholder="..." aria-label="Search">
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
                                    {{--<p class="text-hide" id="idModal"></p>--}}
                                    {{--<p class="text-hide" id="idRow"></p>--}}
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

    <script>

        $(document).on('keypress', '#no-nbh', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let nonbh = $('#no-nbh').val();
                showDoc(nonbh);
            }
        });

        function showDoc(nonbh){
            $('#modal-NBH').modal('hide');
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/brghilang/pembatalannbh/showDoc',
                type: 'post',
                data: {nonbh: nonbh},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    // $('#tabledetail .rowdetail').remove();
                    if (result) {
                        for (i = 0; i < result.length; i++) {
                            var html = "";
                            var i = "";
                            qty = result[i].mstd_qty / result[i].mstd_frac;
                            qtyk = result[i].mstd_qty % result[i].mstd_frac;

                            html = `<tr class="d-flex baris">
                                        <td style="width: 150px"><input disabled type="text" class="form-control plu" value="` + nvl(result[i].mstd_prdcd, '') + `"></td>
                                        <td style="width: 400px"><input disabled type="text" class="form-control nama-barang" value="` + nvl(result[i].prd_deskripsipanjang, '') + `"></td>
                                        <td style="width: 130px"><input disabled type="text" class="form-control kemasan" value="` + nvl(result[i].mstd_unit, '') + ` / ` + nvl(result[i].mstd_frac, '') + `"></td>
                                        <td style="width: 80px"><input disabled type="text" class="form-control kuantum1" value="` + qty + `"></td>
                                        <td style="width: 80px"><input disabled type="text" class="form-control kuantum2" value="` + Math.floor(qtyk) + `"></td>
                                        <td style="width: 120px"><input disabled type="text" class="form-control hpp" value="` + nvl(result[i].mstd_hrgsatuan, '') + `"></td>
                                        <td style="width: 150px"><input disabled type="text" class="form-control total" value="` + nvl(result[i].mstd_gross, '') + `"></td>
                                    </tr>`;

                            $('#tbody').append(html);
                        }
                    }
                }, error: function () {
                    alert('error');
                }
            })
        }


    </script>



@endsection