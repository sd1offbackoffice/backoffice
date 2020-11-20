@extends('navbar')
@section('title','Pembatalan BA Pemusnahan')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card">
                    <legend  class="w-auto ml-5">IGR BO BAPBBATAL</legend>
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-2 col-form-label text-md-right">Nomor BAPB</label>
                                        <input type="text" id="noDoc" class="form-control col-sm-2 mx-sm-1">
                                        <button class="btn ml-2" type="button" data-toggle="modal" data-target="#m_noDoc"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <button class="btn btn-danger col-sm-2 offset-sm-9" onclick="deleteDoc()" type="button">Hapus BAPB</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <hr>
                                <table class="table table-striped table-bordered" id="tableDetail" style="width:100%">
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
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal -->
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

    <style>
        tbody td {
            padding: 3px !important;
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

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let search = $('#searchModal').val();

                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/transaksi/pemusnahan/bapbatal/searchdoc',
                    type: 'post',
                    data: {search:search},
                    // beforeSend: function () {
                    //     $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    // },
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

        function chooseDoc(noDoc) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/pemusnahan/bapbatal/getdetaildoc',
                type: 'post',
                data: {noDoc:noDoc},
                beforeSend: function (){
                    $('#m_noDoc').modal('hide');
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    tableDetail.clear().draw();
                    $('#modal-loader').modal('hide');

                    if (result.kode === 1){
                        $('#noDoc').val(noDoc);
                        console.log(result.data[0])

                        for (i = 0; i< result.data.length; i++){
                            tableDetail.row.add(
                                [result.data[i]['mstd_prdcd'], result.data[i]['prd_deskripsipanjang'].toUpperCase(), result.data[i]['mstd_unit'] + '/' + result.data[i]['mstd_frac'], '0',
                                    result.data[i]['mstd_qty'], convertToRupiah(result.data[i]['mstd_ocost']), convertToRupiah(result.data[i]['mstd_gross'])]
                            ).draw();
                        }
                    } else {
                        swal(result.data, '', 'warning');
                        $('#noDoc').val('');
                    }
                }, error: function (error) {
                    swal('Error', '', 'error');
                    console.log(error)
                }
            })
        }

        function deleteDoc() {
            let nonbh = $('#no-nbh').val();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/brghilang/input/deleteDoc',
                type: 'post',
                data: {"_token": "{{ csrf_token() }}", nodoc: nodoc},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    console.log(result)
                    swal({
                        title: 'Nomor Dokumen Dihapus?',
                        icon: 'warning'
                    }).then((confirm) => {
                        $('#no-trn').val('');
                        $('.baris').remove();
                        clearField();
                    });
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });
        }

        // function deleteDoc() {
        //     let doc = $('#noDoc').val();
        //
        //     if (!doc){
        //         swal('Pilih Nomor!', '', 'warning');
        //         return false;
        //     }
        //
        //     swal({
        //         title: 'Nomor Dokumen Akan dihapus?',
        //         icon: 'warning',
        //         dangerMode: true,
        //         buttons: true,
        //     }).then(function (confirm) {
        //         if (confirm){
        //             ajaxSetup();
        //             $.ajax({
        //                 url: '/BackOffice/public/bo/transaksi/pemusnahan/bapbatal/deletedoc',
        //                 type: 'post',
        //                 data: {doc: doc},
        //                 beforeSend: function () {
        //                     $('#modal-loader').modal({backdrop: 'static', keyboard: false});
        //                 },
        //                 success: function (result) {
        //                     console.log(result)
        //                     $('#modal-loader').modal('hide');
        //                     if (result.kode === 1) {
        //                         swal(result.msg, '', 'success');
        //                         $('#noDoc').val('');
        //                         tableDetail.clear().draw();
        //                     } else {
        //                         swal(result.msg, '', 'warning');
        //                     }
        //
        //                 }, error: function (error) {
        //                     swal('Error', '', 'error');
        //                     console.log(error)
        //                 }
        //             });
        //         } else {
        //             console.log('Tidak dihapus');
        //         }
        //     });
        // }


    </script>

@endsection
