@extends('navbar')
@section('title','LAPORAN PLANOGRAM')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="ml-3"> Pilih Laporan</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row justify-content-center">
                            <label class="col-sm-3 col-form-label text-sm-right">LAPORAN :</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="menu">
                                    <option value="1">QTY MINUS</option>
                                    <option value="2">SPB MANUAL</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-primary" onclick="gantiMenu()">PILIH</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4 lap-qty-minus">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="ml-3"> Laporan QTY Minus</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row form-group">
                            <label class="col-sm-2 col-form-label text-sm-right">RAK :</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="rak1" placeholder="..."
                                       value="">
                                <button id="btn-no-doc" type="button" class="btn btn-lov p-0"
                                        data-toggle="modal" data-target="#m_koderak" onclick="selectObjectRak(1)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">s/d</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="rak2" placeholder="..."
                                       value="">
                                <button id="btn-no-doc" type="button" class="btn btn-lov p-0"
                                        data-toggle="modal" data-target="#m_koderak" onclick="selectObjectRak(2)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 col-form-label text-sm-right">Order By :</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="orderby">
                                    <option value="PLU">PLU</option>
                                    <option value="RAK">Kode Rak</option>
                                    <option value="QTY">QTY</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-11 text-right">
                                <button class="btn btn-primary" onclick="cetak()">PRINT</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-4 lap-spb-manual">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="ml-3"> Laporan SPB Manual</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label text-sm-right">Tgl Antrian :</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control tanggal" id="startDate"
                                       value="">
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">s/d</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control tanggal" id="endDate"
                                       value="">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label text-sm-right">Realisasi :</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="realisasi">
                                    <option value="Y"> Y : sudah</option>
                                    <option value="N"> N : belum</option>
                                    <option value=""> kosong : semua</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label text-sm-right">Order By :</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="orderby">
                                    <option value="PLU">PLU</option>
                                    <option value="RAK">LOKASI TUJUAN</option>
                                    <option value="TGL">Tanggal Antrian</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-11 text-right">
                                <button class="btn btn-primary" onclick="cetak()">PRINT</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_koderak" tabindex="-1" role="dialog" aria-labelledby="m_data_dep" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Kode Rak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalPlu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Rak</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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
        idrak = 1;
        $(document).ready(function () {
            $('.lap-qty-minus').show();
            $('.lap-spb-manual').hide();
            $('.tanggal').datepicker({
                "dateFormat": "dd/mm/yy",
            });
            $('.tanggal').datepicker('setDate', new Date());
            getModalData('');
        });

        function cekTanggal(event) {
            tgl1 = $.datepicker.parseDate('dd/mm/yy', $('#startDate').val());
            tgl2 = $.datepicker.parseDate('dd/mm/yy', $('#endDate').val());
            if (tgl1 == '' || tgl2 == '') {
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
                return false;
            }
            if (new Date(tgl1) > new Date(tgl2)) {
                swal({
                    title: 'Tanggal Tidak Benar!',
                    icon: 'warning'
                });
                return false;
            }
            return true;
        }

        $('.daterange-periode').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        function gantiMenu() {
            menu = $('#menu').val();
            if (menu == '1') {
                $('.lap-qty-minus').show();
                $('.lap-spb-manual').hide();
            } else {
                $('.lap-qty-minus').hide();
                $('.lap-spb-manual').show();
            }
        }
        function getModalData(value){
            let tableModal = $('#tableModalPlu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/lovkoderak',
                    "data" : {
                        'value' : value
                    }
                },
                "columns": [
                    {data: 'lks_koderak', name: 'lks_koderak'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                },
                "order": [],
                columnDefs : [
                ]
            });

            $('#tableModalPlu_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalData(val);
                }
            })
        }

        function selectObjectRak(val) {
            this.idrak = val;
        }
        $(document).on('click', '.modalRow', function () {
            var currentButton = $(this);
            let koderak = currentButton.children().first().text();

            $('#rak'+idrak).val(koderak);
            $('#m_koderak').modal('hide');
        });
        function cetak() {
            menu = $('#menu').val();
            valid = true;
            if (menu == '1') {
                if ($('#rak1').val() == '' || $('#rak2').val() == '') {
                    valid = false;
                }
            } else {
                valid = cekTanggal();
            }
            if (valid) {
                window.open(`{{ url()->current() }}/cetak?menu=${$('#menu').val()}&rak1=${$('#rak1').val()}&rak2=${$('#rak2').val()}&tgl1=${$('#startDate').val()}&tgl2=${$('#endDate').val()}&realisasi=${$('#realisasi').val()}&orderby=${$('#orderby').val()}`, '_blank');
            }
        }
    </script>
@endsection
