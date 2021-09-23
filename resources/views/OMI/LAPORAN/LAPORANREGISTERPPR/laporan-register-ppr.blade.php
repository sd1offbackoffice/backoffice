@extends('navbar')


@section('title','OMI | LAPORAN REGISTER PPR')
@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="offset-1 col-sm-10">

                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3">REGISTER PPR</legend>
                    <div class="card-body ">
                        <div class="row form-group justify-content-center">
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="radio" name="tipe" id="omi" value="OMI" checked>
                                <label class="form-check-label" for="omi">
                                    Data OMI
                                </label>
                            </div>
                            <div class="form-check col-sm-2">
                                <input class="form-check-input" type="radio" name="tipe" id="idm" value="IDM">
                                <label class="form-check-label" for="idm">
                                    Data IDM
                                </label>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 pl-0 pr-0 text-right col-form-label">Periode</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="periode-1">
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control tanggal" id="periode-2">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 pl-0 pr-0 text-right col-form-label">Nomor Dokumen</label>
                            <div class="col-sm-3 buttonInside">
                                <input type="text" class="form-control text-uppercase" id="nodoc1">
                                <button type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_nodoc"
                                        onclick="selectObjectNodoc(1)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-3 buttonInside">
                                <input type="text" class="form-control text-uppercase" id="nodoc2">
                                <button type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_nodoc"
                                        onclick="selectObjectNodoc(2)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                        </div>
                        <div class="row form-group justify-content-center">
                            <button class="col-sm-4 btn btn-success" onclick="cetak()">CETAK LAPORAN</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_nodoc" tabindex="-1" role="dialog" aria-labelledby="m_nodoc" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV No Doc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalNodoc">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No. Dokumen</th>
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

        .ui-datepicker-calendar {
            display: none;
        }
    </style>

    <script>
        // tbtr_piutang,
        idnodoc = 1;
        $(document).ready(function () {
            getLovNodoc('');
        });

        function getLovNodoc(value) {
            if($.fn.DataTable.isDataTable('#tableModalNodoc')){
                $('#tableModalNodoc').DataTable().destroy();
            }
            let tableModal = $('#tableModalNodoc').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/lov-nodoc',
                    "data": {
                        'value': value,
                        'tipe': $('input[name="tipe"]:checked').val()
                    }
                },
                "columns": [
                    {data: 'nodoc', name: 'nodoc'},
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
                columnDefs: []
            });

            $('#tableModalNodoc_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getLovNodoc(val);
                }
            })
        }

        function selectObjectNodoc(val) {
            this.idnodoc = val;
            getLovNodoc('');
        }

        $(document).on('click', '.modalRow', function () {
            var currentButton = $(this);
            let nodoc = currentButton.children().first().text();

            $('#nodoc' + idnodoc).val(nodoc);
            $('#m_nodoc').modal('hide');
        });

        $('.tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.tanggal').on('apply.daterangepicker', function (ev, picker) {
            $('#periode-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#periode-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggal').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        function cetak() {
            if ($('#periode-1').val() == '' || $('#periode-2').val() == '') {
                $('#periode-1').select();
                swal({
                    title: 'Tanggal harus dipilih!',
                    icon: 'error'
                });
                return false;
            }
            window.open(`{{ url()->current() }}/cetak?tgl1=${$('#periode-1').val()}&tgl2=${$('#periode-2').val()}&nodoc1=${$('#nodoc1').val()}&nodoc2=${$('#nodoc2').val()}&tipe=${$('input[name="tipe"]:checked').val()}`, '_blank');
        }
    </script>

@endsection
