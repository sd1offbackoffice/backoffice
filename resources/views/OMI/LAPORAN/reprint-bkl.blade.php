@extends('navbar')
@section('title','OMI | LAPORAN | Reprint BKL')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <form enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label text-right">Kode Toko OMI</label>
                                <div class="col-sm-3 buttonInside">
                                    <input type="text" class="form-control text-uppercase" id="kodeomi">
                                </div>
                            </div>
                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label text-right">No Bukti</label>
                                <div class="col-sm-3 buttonInside">
                                    <input type="text" id="noBukti" class="form-control">
                                    <button id="btn-no-doc" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_help">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                            </div>
                        </form>

                        <p class="text-danger">Info : Apabila klik tombol 'Re print' tidak muncul 2 laporan (BPB dan Struk), mohon di setting dari browsernya (Mungkin kena block dari browsernya)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden" style="position: sticky;height:250px;overflow-y: scroll">
                            <table id="table_tsj" class="table table-sm table-bordered mb-3 text-center">
                                <thead class="thColor">
                                <tr>
                                    <th>No Doc</th>
                                    <th>No Bukti</th>
                                    <th>Kode Supplier</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyTableViewFile">
                                </tbody>
                            </table>
                        </div>
                        <div class="row form-group mt-3 mb-0">
                            <div class="custom-control custom-checkbox col-sm-2 ml-3">
                            </div>
                            <div class="col-sm-7"></div>
                            <button class="col btn btn-primary" id="btnReprint" onclick="printLaporan()">Re print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_help" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nomor Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModal">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No Bukti</th>
                                        <th>Nama File</th>
                                        <th>No Doc</th>
                                        <th>Supplier</th>
                                        <th>Tgl Struk</th>
                                    </tr>
                                    </thead>
                                    <tbody> </tbody>
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



    <script>
        let tableModal = $('#tableModal').DataTable();

        $(document).ready(function () {
            $('#kodeomi').focus()
        })

        $('#kodeomi').on('change', function () {
            let kodeomi = $('#kodeomi').val();
            cekKodeOmi(kodeomi)
        })

        $('#noBukti').on('keypress', function (e){
            if (e.which == 13) {
                let val = $(this).val();

                cekNoBukti(val)
            }
        })

        function cekKodeOmi(kodeomi){
            ajaxSetup();
            $.ajax({
                url: '{{url()->current()}}/cek-omi',
                type: 'POST',
                data: {kodeomi},
                beforeSend : function (){
                },
                success: function (result) {
                    console.log(result)

                    if (result.kode == 0){
                        swal(result.msg, '', 'warning')
                        $('#kodeomi').focus()
                    } else {
                        getDataLov(result.data, '')
                        $('#noBukti').focus()
                    }
                }, error: function (error) {
                    errorHandlingforAjax(error)
                }
            })
        }

        function cekNoBukti(noBukti){
            let kodeomi = $('#kodeomi').val();

            ajaxSetup();
            $.ajax({
                url: '{{url()->current()}}/cek-nomor',
                type: 'POST',
                data: {noBukti, kodeomi},
                beforeSend : function (){
                },
                success: function (result) {
                    if (result.kode == 0){
                        swal(result.msg, '', 'warning')
                        $('#tbodyTableViewFile').children().remove();
                        $('#noBukti').focus()
                    } else {
                        $('#btnReprint').focus()

                        $('#tbodyTableViewFile').children().remove();
                        $('#tbodyTableViewFile').append(` <tr>
                                    <td>${result.data[0].bkl_nodoc}</td>
                                    <td>${result.data[0].bkl_nobukti}</td>
                                    <td>${result.data[0].bkl_kodesupplier}</td>
                                </tr>`);
                    }
                }, error: function (error) {
                    errorHandlingforAjax(error)
                }
            })
        }

        function getDataLov(kodeomi, noBukti){
            tableModal.destroy();
            tableModal =  $('#tableModal').DataTable({
                "ajax": {
                    'url' : '{{url()->current()}}/get-lov',
                    "data" : {kodeomi, noBukti},
                },
                "columns": [
                    {data: 'bkl_nobukti'},
                    {data: 'bkl_idfile'},
                    {data: 'bkl_nodoc'},
                    {data: 'bkl_kodesupplier'},
                    {data: 'bkl_tglstruk'},

                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow modalLov');
                },
                columnDefs : [
                    { targets : [4],
                        render : function (data, type, row) {
                            return formatDate(data, 'dd-mm-yy');
                        }
                    }
                ],
                "order": []
            });

            $('#tableModal_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    getDataLov(kodeomi,val);
                }
            })
        }

        $(document).on('click', '.modalLov', function () {
            let noBukti    = $(this).find('td')[0]['innerHTML']
            let noDoc    = $(this).find('td')[2]['innerHTML']
            let supplier    = $(this).find('td')[3]['innerHTML']

            $('#m_help').modal('hide');
            $('#noBukti').val(noBukti);

            $('#tbodyTableViewFile').children().remove();
            $('#tbodyTableViewFile').append(` <tr>
                                    <td>${noDoc}</td>
                                    <td>${noBukti}</td>
                                    <td>${supplier}</td>
                                </tr>`);

            $('#btnReprint').focus()
        });

        function printLaporan(){
            let kodeomi = $('#kodeomi').val().toUpperCase();
            let noBukti = $('#noBukti').val();
            let tbody   = $('#tbodyTableViewFile').children()

            if (tbody.length < 1){
                swal('Pilih No Dokumen', "", "info")
                return false
            }

            window.open(`{{ url()->current() }}/cetak-laporan?report_id=1&kodeomi=${kodeomi}&nobukti=${noBukti}`);
            window.open(`{{ url()->current() }}/cetak-laporan?report_id=2&kodeomi=${kodeomi}&nobukti=${noBukti}`);
        }

    </script>

@endsection
