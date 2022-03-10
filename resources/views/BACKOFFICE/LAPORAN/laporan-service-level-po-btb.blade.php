@extends('navbar')
@section('title','LAPORAN | LAPORAN SERVICE LEVEL PO vs BTB')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Service Level PO vs BTB</legend>
                        <div class="card-body shadow-lg cardForm">
                            <div class="row text-right">
                                <div class="col-sm-12">
                                    <div class="row form-group">
                                        <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Tanggal</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control tanggal" id="tanggal-1"
                                                   autocomplete="off">
                                        </div>
                                        <label class="col-sm-1 text-center" for="">s/d</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control tanggal" id="tanggal-2"
                                                   autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-2 col-form-label text-right pl-0 pr-0">Supplier</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control text-left" id="supp1" readonly>
                                            <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                                    data-toggle="modal" data-target="#m_lov_supplier" onclick="changeObj('supp1')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label class="col-sm-1 text-center" for="">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control text-left" id="supp2" readonly>
                                            <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                                    data-toggle="modal" data-target="#m_lov_supplier" onclick="changeObj('supp2')">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>
{{--                                    <div class="row form-group">--}}
{{--                                        <label class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode Monitoring Supplier</label>--}}
{{--                                        <div class="col-sm-2 buttonInside">--}}
{{--                                            <input type="text" class="form-control text-left" id="kode-monitoring" readonly>--}}
{{--                                            <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"--}}
{{--                                                    data-toggle="modal" data-target="#m_lov_monitoring">--}}
{{--                                                <i class="fas fa-question"></i>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-5">--}}
{{--                                            <input type="text" class="form-control text-left" id="nama-monitoring" readonly>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <div class="row form-group">
                                        <label class="col-sm-2 col-form-label text-right pl-0 pr-0">Ranking</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="number" class="form-control text-left" id="ranking">
                                        </div>
                                        <label class="col-sm-5 text-left">% SL ( A - Z ) :  1 - Item /  2 - Kuantum  /  3 - Nilai</label>
                                    </div>
                                    <div class="row form-group">
                                        <label class="offset-4 col-sm-5 text-left">% SL ( Z - A ) :  4 - Item /  5 - Kuantum  /  6 - Nilai </label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <button class="col-sm-2 btn btn-primary pl-0" id="btn-cetak"
                                                    onclick="cetak()">CETAK
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <label class="col-sm-12 text-small text-left">** Untuk Laporan Detail Per PO Kolom Rangking Tidak Usah Diisi</label>
                                        <label class="col-sm-12 text-small text-danger">** Kode monitoring supplier di hide karena fitur di ias lama tidak berfungsi</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_supplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV SUPPLIER</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_supplier">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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

    <div class="modal fade" id="m_lov_monitoring" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV MONITORING</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_monitoring">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
    <script>
        var objSup = 'supp1';
        $(document).ready(function () {
            getModalData('');
            getModalDataMonitoring('');
        })

        $('.tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('.tanggal').on('apply.daterangepicker', function (ev, picker) {
            $('#tanggal-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#tanggal-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggal').on('cancel.daterangepicker', function (ev, picker) {
            $('#tanggal-1').val('');
            $('#tanggal-2').val('');
        });

        $('#m_lov_supplier').on('shown.bs.modal', function () {
            $('#table_lov_supplier_filter input').val('');
            $('#table_lov_supplier_filter input').select();
        });
        function getModalData(value) {
            if ($.fn.DataTable.isDataTable('#table_lov_supplier')) {
                $('#table_lov_supplier').DataTable().destroy();
                $("#table_lov_supplier tbody [role='row']").remove();
            }

            search = value.toUpperCase();

            $('#table_lov_supplier').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/get-lov-supplier',
                    "data": {
                        'search': search
                    },
                },
                "columns": [
                    {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},
                    {data: 'sup_namasupplier', name: 'sup_namasupplier'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow row-sup');
                },
                "initComplete": function () {
                    $('#table_lov_supplier_filter input').val(value).select();

                    $(".row-kode-rak").prop("onclick", null).off("click");

                    $(document).on('click', '.row-sup', function (e) {
                        $("#" + objSup).val($(this).find('td:eq(0)').html());
                        $('#m_lov_supplier').modal('hide');
                    });
                }
            });

            $('#table_lov_supplier_filter input').val(value);

            $('#table_lov_supplier_filter input').off().on('keypress', function (e) {
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getModalData(val);
                }
            });
        }

        $('#m_lov_monitoring').on('shown.bs.modal', function () {
            $('#table_lov_monitoring_filter input').val('');
            $('#table_lov_monitoring_filter input').select();
        });

        function getModalDataMonitoring(value) {
            if ($.fn.DataTable.isDataTable('#table_lov_monitoring')) {
                $('#table_lov_monitoring').DataTable().destroy();
                $("#table_lov_monitoring tbody [role='row']").remove();
            }

            search = value.toUpperCase();

            $('#table_lov_monitoring').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/get-lov-monitoring',
                    "data": {
                        'search': search
                    },
                },
                "columns": [
                    {data: 'msu_kodemonitoring', name: 'msu_kodemonitoring'},
                    {data: 'msu_namamonitoring', name: 'msu_namamonitoring'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow row-mtr');
                },
                "initComplete": function () {
                    $('#table_lov_monitoring_filter input').val(value).select();

                    $(".row-mtr").prop("onclick", null).off("click");

                    $(document).on('click', '.row-mtr', function (e) {
                        $("#kode-monitoring").val($(this).find('td:eq(0)').html());
                        $("#nama-monitoring").val($(this).find('td:eq(1)').html());
                        $('#m_lov_monitoring').modal('hide');
                    });
                }
            });

            $('#table_lov_monitoring_filter input').val(value);

            $('#table_lov_monitoring_filter input').off().on('keypress', function (e) {
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getModalDataMonitoring(val);
                }
            });
        }
        function changeObj(val) {
            objSup = val;
        }

        function cetak() {
            if (($('#tanggal-1').val() == '' || $('#tanggal-1').val() == '')) {
                swal('Error', "Inputan Tanggal tidak benar!", 'error');
            }
            else if (($('#supp1').val() == '' && $('#supp2').val() != '') || ($('#supp1').val() != '' && $('#supp2').val() == '')) {
                swal('Error', "Inputan Supplier tidak benar!", 'error');
            }
            else if ( ($('#ranking').val() < 1 || $('#ranking').val() > 6 ) && $('#ranking').val() != '') {
                swal('Error', "Inputan Ranking tidak benar! [ 1 - 6 ]", 'error');
            }
            else if ( $('#ranking').val() == '') {
                swal('Error', "Order harus diisi!", 'error');
            }else {
                swal({
                    title: 'Pilih Tipe Laporan',
                    icon: 'warning',
                    buttons: {
                        rekap: {
                            text: 'Rekap',
                            value: 'rekap'
                        },
                        detail: {
                            text: 'Detail',
                            value: 'detail'
                        }
                    },
                    dangerMode: true
                }).then((menu) => {
                    if(menu){
                        {{--window.open(`{{ url()->current() }}/cetak?tanggal1=${$('#tanggal-1').val()}&tanggal2=${$('#tanggal-2').val()}&supp1=${$('#supp1').val()}&supp2=${$('#supp2').val()}&mtr=${$('#kode-monitoring').val()}&namamtr=${$('#nama-monitoring').val()}&rank=${$('#ranking').val()}&menu=${menu}`, '_blank');--}}
                        window.open(`{{ url()->current() }}/cetak?tanggal1=${$('#tanggal-1').val()}&tanggal2=${$('#tanggal-2').val()}&supp1=${$('#supp1').val()}&supp2=${$('#supp2').val()}&rank=${$('#ranking').val()}&menu=${menu}`, '_blank');
                    }
                });
            }        }

    </script>

@endsection
