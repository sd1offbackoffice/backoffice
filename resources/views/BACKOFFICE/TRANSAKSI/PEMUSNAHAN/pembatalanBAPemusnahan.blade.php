@extends('navbar')
@section('title','PEMUSNAHAN | PEMBATALAN BA PEMUSNAHAN')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-2 col-form-label text-md-right">Nomor BAPB</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="noDoc" class="form-control">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" data-target="#modalHelpDocument" >
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <button class="btn btn-danger col-sm-2 " onclick="deleteDoc()" type="button">Hapus BAPB</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <hr>
                                <table class="table table-striped table-bordered" id="tableDetail" style="width:100%">
                                    <thead class="theadDataTables">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalHelpDocument" tabindex="-1" role="dialog" aria-labelledby="m_noDoc" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pembatalan BAPB</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="tableModalDocument">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No Dokumen</th>
                                        <th>Tanggal</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp">
                                    </tbody>
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
            getDataModalDocument('');
        });

        function  getDataModalDocument(val) {
            let tableModalDocument = $('#tableModalDocument').DataTable({
                "ajax": {
                    'url' : '{{ url('bo/transaksi/pemusnahan/bapbatal/getnodoc') }}',
                    "data" : {
                        'value': val
                    },
                },
                "columns": [
                    {data: 'mstd_nodoc', name: 'mstd_nodoc'},
                    {data: 'mstd_tgldoc', name: 'mstd_tgldoc'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row_lov row_lov_document');
                },
                columnDefs : [
                    { targets : [1],
                        render : function (data, type, row) {
                            return formatDate(data)
                        }
                    }
                ],
                "order": []
            });

            $('#tableModalDocument_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalDocument.destroy();
                    getDataModalDocument(val);
                }
            })
        }

        $(document).on('click', '.row_lov_document', function () {
            var currentButton = $(this);
            let document = currentButton.children().first().text();

            chooseDoc(document)
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
                url: '{{ url()->current() }}/getdetaildoc',
                type: 'post',
                data: {noDoc:noDoc},
                beforeSend: function (){
                    $('#modalHelpDocument').modal('hide');
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    tableDetail.clear().draw();
                    $('#modal-loader').modal('hide');

                    if (result.kode === 1){
                        $('#noDoc').val(noDoc);

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
            let doc = $('#noDoc').val();

            if (!doc){
                swal('Pilih Nomor!', '', 'warning');
                return false;
            }

            swal({
                title: 'Nomor Dokumen Akan dihapus?',
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                if (confirm){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/deletedoc',
                        type: 'post',
                        data: {doc: doc},
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (result) {
                            console.log(result)
                            $('#modal-loader').modal('hide');
                            if (result.kode === 1) {
                                swal(result.msg, '', 'success');
                                $('#noDoc').val('');
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
