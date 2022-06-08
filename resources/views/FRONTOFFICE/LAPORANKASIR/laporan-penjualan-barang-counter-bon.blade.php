@extends('navbar')
@section('title','LAPORAN KASIR | LAPORAN PENJUALAN BARANG COUNTER BON')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-secondary">
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <label for="tanggal" class="col-sm-3 text-right col-form-label">Tanggal</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-center tanggal" id="tanggal-1"
                                               placeholder="DD/MM/YYYY" readonly>
                                    </div>
                                    <label for="tanggal" class="col-sm-1 text-right col-form-label">s / d</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-center tanggal" id="tanggal-2"
                                               placeholder="DD/MM/YYYY" readonly>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <label for="plu" class="col-sm-3 text-right col-form-label">Kode PLU Counter
                                        Bon</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input type="text" class="form-control text-left" id="plu">
                                        <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0"
                                                data-toggle="modal" data-target="#m_lov_plu">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <label for="plu" class="col-sm-4 text-left col-form-label">[ Kosongkan Utk Semua
                                        Counter ]</label>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm"></div>
                                    <div class="col-sm-3">
                                        <button class="col btn btn-primary" id="btn-print" onclick="print()">Cetak
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_plu">
                                    <thead class="thColor">
                                    <tr>
                                        <th>PLU</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            getModalDataPLU('');
            swal('Info','Data yang digunakan masih data IGRYGY!','info')
        });

        $('.tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('#plu').on('keyup', function (e) {
            if(e.which == 13){
                let val = convertPlu($(this).val());
                $(this).val(val);
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
        function getModalDataPLU(value) {
            if ($.fn.DataTable.isDataTable('#table_lov_plu')) {
                $('#table_lov_plu').DataTable().destroy();
                $("#table_lov_plu tbody [role='row']").remove();
            }

            search = value.toUpperCase();

            $('#table_lov_plu').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/get-lov-plu',
                    "data": {
                        'plu': search
                    },
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow row-plu');
                },
                "initComplete": function () {
                    $('#table_lov_plu_filter input').val(value).select();

                    $(".row-plu").prop("onclick", null).off("click");

                    $(document).on('click', '.row-plu', function (e) {
                        $("#plu").val($(this).find('td:eq(0)').html());
                        $('#m_lov_plu').modal('hide');
                    });
                }
            });

            $('#table_lov_plu_filter input').val(value);

            $('#table_lov_plu_filter input').off().on('keypress', function (e) {
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getModalDataPLU(val);
                }
            });
        }
        function print() {
            var tgl1 = $('#tanggal-1').val();
            var tgl2 = $('#tanggal-2').val();
            var plu = $('#plu').val();
            if(tgl1 == '' || tgl2 == ''){
                swal({
                    title: 'Tanggal Harus diisi!',
                    icon: 'warning'
                });
                return false;
            }
            swal({
                title: 'Yakin ingin menprint laporan?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if (ok) {
                    window.open(`{{ url()->current() }}/print?tgl1=${tgl1}&tgl2=${tgl2}&plu=${plu}`, '_blank');
                }
            });
        }
    </script>

@endsection
