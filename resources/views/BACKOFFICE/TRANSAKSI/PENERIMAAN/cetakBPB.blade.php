@extends('navbar')
@section('title','PENERIMAAN | CETAK LAPORAN BPB')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <form>
                            <div class="form-group row mb-1">
                                <label class="col-sm-2 col-form-label text-right">Jenis Laporan</label>
                                <div class="col-sm-3">
                                    <select class="form-control" id="typeLaporan">
                                        <option value="B1">1. DAFTAR TRANSAKSI YANG BELUM TRANSAKSI BPB</option>
                                        <option value="B2">2. MONITORING BUKTI PENERIMAAN BARANG</option>
                                        <option value="P1">3. LIST DRAFT PO/RINCIAN PO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-1" id="formDate">
                                <label class="col-sm-2 col-form-label text-right">Tanggal</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" id="startDate">
                                </div>
                                <label class="col-form-label text-center">sd</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" id="endDate" >
                                </div>
                            </div>

                            <div class="form-group row mb-1" id="formNoPO">
                                <label class="col-sm-2 col-form-label text-right">No PO</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control nullPermission" id="noPO" value="">
                                    <button id="btn-no-doc" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#modalPO">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group row mb-1" id="formSupplier">
                                <label class="col-sm-2 col-form-label text-right">Supplier</label>
                                <div class="col-sm-3 buttonInside">
                                    <input type="text" class="form-control" id="supplier" disabled>
                                </div>
                            </div>

                            <div class="form-group row mb-1" id="formDetailP1">
                                <label class="col-sm-2 col-form-label text-right">Format Cetak</label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="formatLaporan">
                                        <option value="1">Draf Dok PO</option>
                                        <option value="2">Rincian Tanpa Qty</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-1" id="formUkuranP1">
                                <label class="col-sm-2 col-form-label text-right">Ukuran Kertas</label>
                                <div class="col-sm-2">
                                    <select class="form-control" id="ukuranLaporan">
                                        <option value="K">Kecil</option>
                                        <option value="B">Biasa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <button class="btn btn-primary offset-sm-9 col-sm-1 mr-3" type="button" onclick="cetakLaporan()" id="btnCetak">Cetak BPB</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal PO-->
    <div class="modal fade" id="modalPO" tabindex="-1" role="dialog" aria-labelledby="m_lov" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar PO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="tableModalPO">
                                    <thead>
                                    <tr>
                                        <th>No PO</th>
                                        <th>Supplier</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalPO"></tbody>
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
        .modalRowPO:hover{
            cursor: pointer;
            background-color: #e9ecef;
        }
    </style>

    <script>
        let typeTrn;
        let formDate    = $('#formDate');
        let formNoPO    = $('#formNoPO');
        let formSupplier = $('#formSupplier');
        let formDetailP1 = $('#formDetailP1');
        let formUkuranP1 = $('#formUkuranP1');


        $(document).ready(function () {
            // startAlert();
            typeTrn = 'B'
            formatDate();
            formNoPO.hide();
            formSupplier.hide();
            formDetailP1.hide();
            formUkuranP1.hide();
            getNoPO();
        });

        function formatDate(){
            $('#startDate').datepicker({
                dateFormat: 'dd-mm-yy'
            });
            $('#endDate').datepicker({
                dateFormat: 'dd-mm-yy'
            })
        }

        function startAlert() {
            swal({
                title: 'Jenis Penerimaan?',
                icon: 'info',
                buttons: {
                    confirm: "Penerimaan",
                    roll: {
                        text: "Lain-lain",
                        value: "lain",
                    },
                }
            }).then(function (confirm) {
                switch (confirm) {
                    case true:
                        typeTrn = 'B';
                        break;

                    case "lain":
                        typeTrn = 'L';
                        break;

                    default:
                        typeTrn = 'N';
                }
                $('#startDate').focus();
            })
        }

        function getNoPO(){
            $('#tableModalPO').DataTable({
                "ajax": '{{ url()->current() }}/showpo/',
                "columns": [
                    {data: 'tpoh_nopo', name: 'No PO'},
                    {data: 'supplier', name: 'Supplier'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRowPO');
                },
                "order": []
            });
        }

        function cetakLaporan(){
            let startDate   = $('#startDate').val();
            let endDate     = $('#endDate').val();
            let typeLaporan = $('#typeLaporan').val();
            let noPO        = $('#noPO').val();
            let formatLaporan = $('#formatLaporan').val();
            let ukuranLaporan = $('#ukuranLaporan').val();

            if (typeLaporan != 'P1'){
                if (!startDate || !endDate){
                    swal('Tanggal Harus Terisi', '', 'warning');
                    return false;
                }
            }

            if (startDate > endDate){
                swal('Range Tanggal Terbalik', '', 'warning');
                return false;
            }

            if (typeLaporan == 'P1'){
                if (!noPO){
                    swal('No PO Tidak Boleh Kosong', '', 'warning');
                    return false;
                }
            }

            ajaxSetup();
            $.ajax({
                method : 'POST',
                url: '{{ url()->current() }}/cetaklaporan',
                data: {
                    startDate:startDate,
                    endDate :endDate,
                    typeLaporan:typeLaporan,
                    formatLaporan:formatLaporan,
                    ukuranLaporan:ukuranLaporan,
                    noPO:noPO,
                    typeTrn:typeTrn,
                }, success: function (result) {
                    console.log(result);

                    if (result.kode == '0'){
                        swal(result.msg, '', 'info');
                    } else {
                        window.open('{{ url()->current() }}/viewreport/');
                    }


                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message)
                }
            })
        }

        $('#typeLaporan').on('change', function (){
            let typeLaporan = $('#typeLaporan').val();

            if (typeLaporan == 'P1'){
                formNoPO.show();
                formSupplier.show();
                formDetailP1.show();
                formDate.hide();
            } else {
                formNoPO.hide();
                formSupplier.hide();
                formDetailP1.hide();
                formUkuranP1.hide();
                formDate.show();
            }

            console.log();
        })

        $('#formatLaporan').on('change', function (){
            let formatLaporan = $('#formatLaporan').val();

            if (formatLaporan == '2'){
                formUkuranP1.show();
            } else {
                formUkuranP1.hide();
            }

            console.log();
        })

        $(document).on('click', '.modalRowPO', function () {
            let currentButton = $(this);
            let noPo     = currentButton.children().first().text();
            let supplier = currentButton.children().first().next().text();

            $('#noPO').val(noPo)
            $('#supplier').val(supplier)
            $('#modalPO').modal('hide')
        });

        $('#noPO').keypress(function (e) {
            if (e.which === 13) {
                let value = $(this).val();

                ajaxSetup();
                $.ajax({
                    method : 'POST',
                    url: '{{ url()->current() }}/searchpo',
                    data: {value },
                    beforeSend : () => {
                        // $('#modal-loader').modal('show');
                    },
                    success: function (result) {
                        if (result.length > 0){
                            $('#noPO').val(result[0].tpoh_nopo)
                            $('#supplier').val(result[0].supplier)
                        } else {
                            swal('No PO Tidak ada', '', 'info');
                            $('#noPO').val('')
                            $('#supplier').val('')
                        }
                    }, error: function (err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0,100));
                        alertError(err.statusText, err.responseJSON.message)
                    }
                })
            }
        });


    </script>


@endsection
