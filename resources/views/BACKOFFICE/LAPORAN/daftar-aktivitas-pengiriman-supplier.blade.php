@extends('navbar')
@section('title','Daftar Aktivitas Pengiriman Supplier')
@section('content')


        <div class="container" id="main_view">
            <div class="row">
                <div class="col-sm-12">
                    <fieldset class="card border-secondary">
                        <legend class="w-auto ml-3">Daftar Aktivitas Pengiriman Supplier</legend>

                        <div class="card-body">
                            <div class="row form-group">
                                <label for="periode" class="col-sm-3 text-right col-form-label pl-0 pr-0">Periode</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control tanggal" id="periode">
                                </div>
                                <label class="col-form-label">[ MM/YYYY ]</label>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-3 col-form-label text-right pl-0 pr-0">Supplier</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control text-left" id="supp1">
                                    <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                            data-toggle="modal" data-target="#m_lov_supplier"
                                            onclick="changeObj('supp1')">
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                                <label for="">s/d</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control text-left" id="supp2">
                                    <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                            data-toggle="modal" data-target="#m_lov_supplier"
                                            onclick="changeObj('supp2')">
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-3 col-form-label text-right pl-0 pr-0">Tipe Monitoring</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control text-left" id="monitoring">
                                    <button type="button" class="btn btn-primary btn-lov p-0"
                                            data-toggle="modal" data-target="#m_lov_monitoring">
                                        <i class="fas fa-question"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row right">
                                <div class="col-sm-12">
                                    <button class="offset-10 col-sm-2 btn btn-primary pl-0" id="btn-cetak"
                                            onclick="cetak()">CETAK
                                    </button>
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
                        <h5 class="modal-title">LOV Monitoring</h5>
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

            .clicked, .row-history:hover {
                background-color: grey !important;
                color: white;
            }

        </style>

        <script>
            var objSup = 'supp1';
            $(document).ready(function () {
                $('.tanggal').MonthPicker({
                    Button: false,
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'MM yy',
                });
                getModalDataSupplier('');
                getModalDataMonitoring('');
            })

            $('#m_lov_supplier').on('shown.bs.modal', function () {
                $('#table_lov_supplier_supplier_filter input').val('');
                $('#table_lov_supplier_supplier_filter input').select();
            });

            function getModalDataSupplier(value) {
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

                        $(".row-sup").prop("onclick", null).off("click");

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

            function changeObj(val) {
                objSup = val;
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
                            $("#monitoring").val($(this).find('td:eq(0)').html());
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
            function cetak() {
                if (($('#periode').val() == '')) {
                    swal('Error', "Inputan Tanggal tidak benar!", 'error');
                } else if (($('#supp1').val() == '' && $('#supp2').val() != '') || ($('#supp1').val() != '' && $('#supp2').val() == '')) {
                    swal('Error', "Inputan Supplier tidak benar!", 'error');
                } else {
                    swal({
                        title: 'Urut By',
                        icon: 'warning',
                        buttons: {
                            kode: {
                                text: 'Kode Supplier',
                                value: '1'
                            },
                            nama: {
                                text: 'Nama Supplier',
                                value: '2'
                            }
                        },
                        dangerMode: true
                    }).then((menu) => {
                        if(menu){
                            window.open(`{{ url()->current() }}/cetak?periode=${$('#periode').val()}&supp1=${$('#supp1').val()}&supp2=${$('#supp2').val()}&sort=${menu}`, '_blank');
                        }
                    });
                }
            }


        </script>

@endsection
