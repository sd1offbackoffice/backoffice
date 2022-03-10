@extends('navbar')
@section('title','LAPORAN | LAPORAN DISCOUNT 4')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Discount 4</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Tanggal
                                        BPB</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control tanggal" id="tanggal-1"
                                               autocomplete="off">
                                    </div>
                                    <label for="">s/d</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control tanggal" id="tanggal-2"
                                               autocomplete="off">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-2 col-form-label text-right pl-0 pr-0">Kode
                                        Supplier</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input type="text" class="form-control text-left" id="supp1">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_supplier"
                                                onclick="changeObj('supp1')">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <label for="">s/d</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input type="text" class="form-control text-left" id="supp2">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_supplier"
                                                onclick="changeObj('supp2')">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button class="col-sm-2 btn btn-primary pl-0" id="btn-cetak"
                                                onclick="cetak()">CETAK
                                        </button>
                                    </div>
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


    <script>
        var objSup = 'supp1';
        $(document).ready(function () {
            getModalData('');
        })
        getModalData('');
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
            $('#table_lov_supplier_supplier_filter input').val('');
            $('#table_lov_supplier_supplier_filter input').select();
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

        function cetak() {
            if (($('#tanggal-1').val() == '' || $('#tanggal-1').val() == '')) {
                swal('Error', "Inputan Tanggal tidak benar!", 'error');
            }
            else if (($('#supp1').val() == '' && $('#supp2').val() != '') || ($('#supp1').val() != '' && $('#supp2').val() == '')) {
                swal('Error', "Inputan Supplier tidak benar!", 'error');
            }else {
                window.open(`{{ url()->current() }}/cetak?tanggal1=${$('#tanggal-1').val()}&tanggal2=${$('#tanggal-2').val()}&supp1=${$('#supp1').val()}&supp2=${$('#supp2').val()}`, '_blank');
            }
        }

    </script>

@endsection
