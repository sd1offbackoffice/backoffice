@extends('navbar')

@section('title','BO | CETAK LAPORAN PROMOSI')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="offset-1 col-sm-10">

                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">CETAK LAPORAN PROMOSI</legend>
                    <div class="card-body ">
                        <div class="row form-group">
                            <label class="col-sm-2 col-form-label text-md-right">Kode Rak</label>
                            <div class="col-sm-4 buttonInside">
                                <input type="text" id="koderak" class="form-control field field3" field="3">
                                <button class="btn btn-lov p-0" type="button" data-toggle="modal"
                                        data-target="#m_lov_koderak">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 col-form-label text-md-right">Kode Promosi</label>
                            <div class="col-sm-4 buttonInside">
                                <input type="text" id="kodepromosi" class="form-control field field3" field="3">
                                <button class="btn btn-lov p-0" type="button" data-toggle="modal"
                                        data-target="#m_lov_kodepromosi">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 col-form-label text-md-right">Cetak</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="cetakby">
                                    <option value="ALL">By All</option>
                                    <option value="RAK">By Rak</option>
                                    <option value="PROMO">By Promosi</option>
                                    <option value="RAKPROMO">By Rak & Promosi</option>
                                    <option value="GFPRINT">Promosi Gift Berjalan</option>
                                    <option value="CBPRINT">Promosi Cashback Berjalan</option>
                                    <option value="PRINTBESOK">Promosi yang akan Berakhir</option>
                                </select>
                            </div>
                            <div class="offset-2 col-sm-2">
                                <button class="col btn btn-success" onclick="cetak()">Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_koderak" tabindex="-1" role="dialog" aria-labelledby="m_lov_koderak"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV KODE RAK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalLOVKodeRak">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Rak</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <div class="modal fade" id="m_lov_kodepromosi" tabindex="-1" role="dialog" aria-labelledby="m_lov_kodepromosi"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV KODE RAK</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalLOVKodePromosi">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Promo</th>
                                        <th>Nama Promo</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }

        label {
            color: #232443;
            font-weight: bold;
        }

        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover {
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .clicked, .row-detail:hover {
            background-color: grey !important;
            color: white;
        }

    </style>

    <script>

        $(document).ready(function () {
            getLovKodeRak('');
            getLovKodePromosi('');
        });

        function getLovKodeRak(val) {
            lovkoderak = $('#tableModalLOVKodeRak').DataTable({
                "ajax": '{{ url()->current().'/lovkoderak' }}',
                "columns": [
                    {data: 'lks_koderak', name: 'LKS_KODERAK'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-koderak').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $('.btn_lov').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-koderak', function (e) {
                        koderak = $(this).find('td:eq(0)').html();
                        $("#koderak").val(koderak);

                        $('#m_lov_koderak').modal('hide');
                    });
                }
            });
            $('#tableModalLOVKodeRak input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    lovkoderak.destroy();
                    getLovKodeRak(val);
                }
            })
        }

        function getLovKodePromosi(val) {
            lovkodepromosi = $('#tableModalLOVKodePromosi').DataTable({
                "ajax": '{{ url()->current().'/lovkodepromosi' }}',
                "columns": [
                    {data: 'kode', name: 'kode'},
                    {data: 'namapromosi', name: 'namapromosi'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-kodepromosi').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $('.btn_lov').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-kodepromosi', function (e) {
                        kodepromosi = $(this).find('td:eq(0)').html();
                        $("#kodepromosi").val(kodepromosi);

                        $('#m_lov_kodepromosi').modal('hide');
                    });
                }
            });
            $('#tableModalLOVKodePromosi input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    lovkodepromosi.destroy();
                    getLovKodePromosi(val);
                }
            })
        }

        function cetak() {
            if ($('#cetakby').val() == 'RAKPROMO') {
                if ($('#koderak').val() == '' && $('#kodepromosi').val() == '') {
                    $('#koderak').select();
                    swal({
                        title: 'Rak dan Promosi harus dipilih!',
                        icon: 'error'
                    });
                    return false;
                }
                if ($('#koderak').val() == '') {
                    $('#koderak').select();
                    swal({
                        title: 'Rak harus dipilih!',
                        icon: 'error'
                    });
                    return false;
                }
                if ($('#kodepromosi').val() == '') {
                    $('#kodepromosi').select();
                    swal({
                        title: 'Promosi harus dipilih!',
                        icon: 'error'
                    });
                    return false;
                }
            } else if ($('#cetakby').val() == 'RAK') {
                if ($('#koderak').val() == '') {
                    $('#koderak').select();
                    swal({
                        title: 'Rak harus dipilih!',
                        icon: 'error'
                    });
                    return false;
                }
            } else if ($('#cetakby').val() == 'PROMO') {
                if ($('#kodepromosi').val() == '') {
                    $('#kodepromosi').select();
                    swal({
                        title: 'Promosi harus dipilih!',
                        icon: 'error'
                    });
                    return false;
                }
            }
            window.open(`{{ url()->current() }}/cetak?koderak=${$('#koderak').val()}&kodepromosi=${$('#kodepromosi').val()}&cetakby=${$('#cetakby').val()}`, '_blank');
        }
    </script>

@endsection
