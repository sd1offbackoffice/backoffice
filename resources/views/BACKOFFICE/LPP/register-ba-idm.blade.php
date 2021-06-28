@extends('navbar')
@section('title','Register BA IDM')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <fieldset class="card border-dark">
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-sm-right">PILIHAN CETAKAN</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="pilihan-cetakan">
                                                <option value="detail">DETAIL
                                                </option>
                                                <option value="rekap">REKAP
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-sm-right">PERIODE</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control daterange-periode" id="periode1">
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-center">s/d</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control daterange-periode" id="periode2">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-1 mt-5 justify-content-center cetak-1-bagian">
                                        <button type="button" class="btn btn-primary col-sm-5"
                                                id="btn-cetak">CETAK
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade" id="m_data_plu" tabindex="-1" role="dialog" aria-labelledby="m_data_plu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PRDCD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataPLU">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>PLU</th>
                                        <th>Nama Produk</th>
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

    <div class="modal fade" id="m_data_dep" tabindex="-1" role="dialog" aria-labelledby="m_data_dep" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Departemen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataDep">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Div</th>
                                        <th>Nama Div</th>
                                        <th>Kode Dep</th>
                                        <th>Nama Dep</th>
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

    <div class="modal fade" id="m_data_kat" tabindex="-1" role="dialog" aria-labelledby="m_data_kat" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataKat">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Dep</th>
                                        <th>Nama Dep</th>
                                        <th>Kode Kat</th>
                                        <th>Nama Kat</th>
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

    <div class="modal fade" id="m_data_mtr" tabindex="-1" role="dialog" aria-labelledby="m_data_mtr" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Monitoring</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataKat">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Mtr</th>
                                        <th>Nama Mtr</th>
                                        <th>PLU</th>
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

    <div class="modal fade" id="m_data_sup" tabindex="-1" role="dialog" aria-labelledby="m_data_sup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDataSup">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
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
        .buttonInside {
            position: relative;
        }

        .btn-lov-plu {
            position: absolute;
            /*right: 4px;*/
            /*top: 1px;*/
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;

        }

        .input-group-text {
            background-color: white;
        }
    </style>


    <script>
        object = 'plu1';
        $(document).ready(function () {
            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output1 = '0' + (day - day + 1) + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            var output2 = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            $('#periode1').val(output1);
            $('#periode2').val(output2);


        });

        $('.daterange-periode').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.daterange-periode').on('apply.daterangepicker', function (ev, picker) {
            $('#periode1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#periode2').val(picker.endDate.format('DD/MM/YYYY'));
        });

        $('.daterange-periode').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        $(document).on('click', '#btn-cetak', function () {
            var currentButton = $(this);
            window.open(`{{ url()->current() }}/cetak?menu=${$('#pilihan-cetakan').val()}&periode1=${$('#periode1').val()}&periode2=${$('#periode2').val()}`, '_blank');
        });

    </script>


@endsection

