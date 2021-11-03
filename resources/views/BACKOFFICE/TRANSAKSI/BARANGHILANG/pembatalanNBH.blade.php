@extends ('navbar')
@section('title','BARANG HILANG | PEMBATALAN NBH')
@section ('content')

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card">
                    <legend class="w-auto ml-5">PEMBATALAN NBH</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="no-nbh" class="col-sm-2 col-form-label text-right">NOMOR NBH</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="no-nbh">
                                            <button id="btn-no-nbh" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#modal-NBH">
                                                <img src="{{asset('image/icon/help.png')}}" width="30px">
                                            </button>
                                        </div>
                                        <button type="button" class="btn btn-danger col-sm-2 offset-sm-1" id="btn-hapus" onclick="deleteDoc()">
                                            HAPUS NBH
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <hr>
                                    <table class="table table-striped table-bordered" id="table-detail" style="width: 100%">
                                        <thead class="header-table" style="color: white;">
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
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
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

    <style>
        .header-table{
            background: #0079C2;
        }

    </style>

    <script>

        let tableDetail;

        $(document).ready(function () {
            tableDetail = $('#table-detail').DataTable({
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

        function showDoc(nonbh){
            $('#modal-NBH').modal('hide');
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/showData',
                type: 'post',
                data: {nonbh: nonbh},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    tableDetail.clear().draw();
                    $('#modal-loader').modal('hide');
                    // $('.baris').remove();
                    if (result) {
                        console.log(result)
                        var html = "";
                        var i;
                        for (i = 0; i < result.length; i++) {
                            qty = result[i].mstd_qty / result[i].mstd_frac;
                            qtyk = result[i].mstd_qty % result[i].mstd_frac;

                            tableDetail.row.add(
                                [result[i]['mstd_prdcd'], result[i]['prd_deskripsipanjang'].toUpperCase(), result[i]['mstd_unit'] + '/' + result[i]['mstd_frac'], Math.floor(qty),
                                    Math.floor(qtyk), convertToRupiah(result[i]['mstd_hrgsatuan']), convertToRupiah(result[i]['mstd_gross'])]
                            ).draw();

                            $('#no-nbh').val(result[i].mstd_nodoc);
                        }
                    } else {
                        alert('Data Tidak Ada');
                        $('#no-nbh').val('');
                    }
                }, error: function () {
                    alert('error');
                }
            })
        }

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let search = $('#searchModal').val();
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/lovNBH',
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

        function deleteDoc(){
            let nonbh = $('#no-nbh').val();

            if (!nonbh){
                swal('Pilih Nomor!', '', 'warning');
                return false;
            }

            swal({
                title: 'Peringatan NBH Akan Dibatalkan?',
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                if (confirm){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/deleteData',
                        type: 'post',
                        data: {"_token": "{{ csrf_token() }}", nonbh: nonbh},
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (result) {
                            console.log(result)
                            $('#modal-loader').modal('hide');
                            if (result.kode === 1) {
                                swal(result.msg, '', 'success');
                                tableDetail.clear().draw();
                            } else {
                                swal(result.msg, '', 'warning');
                            }
                        }, error: function (error) {
                            swal('Error', '', 'error');
                            console.log(error)
                        }
                    });
                } else {
                    console.log('Tidak dihapus');
                }
            });
        }

    </script>



@endsection
