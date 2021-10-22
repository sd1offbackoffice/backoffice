@extends('navbar')
@section('title','HADIAH PER ITEM BARANG')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Pendaftaran Voucher Belanja IGR</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row justify-content-center">
                            <label class="col-sm-2 col-form-label text-right">Singkatan Supplier</label>
                            <div class="col-sm-1 buttonInside">
                                <input type="text" class="form-control" id="supplier"
                                       style="text-transform: uppercase;">
                                <button id="trans" type="button" class="btn btn-lov p-0" data-target="#m_supplier"
                                        data-toggle="modal">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <button class="btn btn-primary offset-2 col-sm-1 mb-1" type="button" onclick="simpan()">
                                SAVE
                            </button>&nbsp;
                        </div>
                        <div class="row justify-content-center">
                            <label class="col-sm-2 col-form-label text-right">Nilai Voucher</label>
                            <div class="col-sm-1">
                                <input type="number" class="form-control" id="nilai-voucher" min="0" val="0">
                            </div>
                            <button class="btn btn-primary offset-2 col-sm-1 mb-1" type="button" onclick="hapus()">
                                DELETE
                            </button>&nbsp;
                        </div>
                        <div class="row justify-content-center">
                            <label class="col-sm-2 col-form-label text-right">Masa Berlaku</label>
                            <div class="col-sm-1">
                                <input type="input" class="form-control tanggal" id="masaberlaku1" readonly>
                            </div>
                            <label class="col-sm-1 col-form-label text-center">s/d</label>
                            <div class="col-sm-1">
                                <input type="input" class="form-control tanggal" id="masaberlaku2" readonly>
                            </div>
                            <button class="btn btn-primary col-sm-1 mb-1" type="button" onclick="cetak()">PRINT</button>
                        </div>
                        <br>
                        <div class="row">
                            <label class="offset-3 col-sm-2 col-form-label text-right"><b>Penggunaan Per Transaksi :</b></label>
                        </div>
                        <div class="row justify-content-center">
                            <label class="col-sm-2 col-form-label text-right">Maximum Voucher</label>
                            <div class="col-sm-1">
                                <input type="number" class="form-control" id="max-voucher" min="0" val="0">
                            </div>
                            <label class="col-sm-3 col-form-label">lbr.</label>
                        </div>
                        <div class="row justify-content-center">
                            <label class="col-sm-2 col-form-label text-right">Minimum Struk</label>
                            <div class="col-sm-1">
                                <input type="number" class="form-control" id="min-struk" min="0" val="0">
                            </div>
                            <label class="col-sm-3 col-form-label">Exclude Produk Non-Promo</label>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <label class="col-sm-2 col-form-label text-right">Voucher Join Promo</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="voucher-join-promo" maxlength="1"
                                       style="text-transform: uppercase;">
                            </div>
                            <label class="col-sm-3 col-form-label">[ Y / T ]</label>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <label class="col-sm-2 col-form-label text-right">Keterangan</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="keterangan"
                                       style="text-transform: uppercase;">
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Detail Pendaftaran Voucher Belanja IGR</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row justify-content-center">
                            <table class="table table-striped table-bordered col-sm-12" id="tableData">
                                <thead class="theadDataTables">
                                <tr>
                                    <th>Supplier</th>
                                    <th>Nilai Voucher</th>
                                    <th>Tgl Mulai</th>
                                    <th>Tgl Akhir</th>
                                    <th>Max Voucher</th>
                                    <th>Join Promo</th>
                                    <th>Min Struk</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <label class="col-sm-1 text-right">Deskripsi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="deskripsi" readonly>
                            </div>
                        </div>
                    </div>

                </fieldset>
            </div>
        </div>
    </div>
    <!--MODAL supp-->
    <div class="modal fade" id="m_supplier" tabindex="-1" role="dialog" aria-labelledby="m_supplier" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableSupplier">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Supplier</th>
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
    <!-- END OF MODAL supp-->

    <script>
        $('.tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.tanggal').on('apply.daterangepicker', function (ev, picker) {
            $('#masaberlaku1').val(picker.startDate.format('YYYY-MM-DD'));
            $('#masaberlaku2').val(picker.endDate.format('YYYY-MM-DD'));
        });

        $(document).ready(function () {
            SupplierModal('');
            getDataTable('');
        });

        function SupplierModal(value) {
            tableSupplier = $('#tableSupplier').DataTable({
                "ajax": {
                    'url': '{{ url()->current().'/modal-supplier' }}',
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'vcs_namasupplier', name: 'vcs_namasupplier'},
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
                    $(row).addClass('modalSupplier');
                },
                columnDefs: [],
                "order": []
            });

            $('#tableSupplier_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val();

                    tableSupplier.destroy();
                    SupplierModal(val);
                }
            })
        }

        $(document).on('click', '.modalSupplier', function () {
            let currentButton = $(this);
            let supp = currentButton.children().first().text();

            $('#supplier').val(supp);
            getDataSupplier(supp);
            $('#m_supplier').modal('toggle');
        });

        function getDataTable(value) {
            if ($.fn.DataTable.isDataTable('#tableData')) {
                $('#tableData').DataTable().destroy();
            }
            tableData = $('#tableData').DataTable({
                "ajax": {
                    'url': '{{ url()->current().'/get-data-table' }}',
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'vcs_namasupplier'},
                    {data: 'vcs_nilaivoucher'},
                    {data: 'vcs_tglmulai'},
                    {data: 'vcs_tglakhir'},
                    {data: 'vcs_maxvoucher'},
                    {data: 'vcs_joinpromo'},
                    {data: 'vcs_minstruk'}
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
                    $(row).addClass('modalData');
                },
                "columnDefs": [
                    {
                        targets: [1],
                        render: function (data, type, row) {
                            return convertToRupiah2(data)
                        }
                    },
                    {
                        targets: [2],
                        render: function (data, type, row) {
                            return formatDate(data)
                        }
                    },
                    {
                        targets: [3],
                        render: function (data, type, row) {
                            return formatDate(data)
                        }
                    },
                    {
                        targets: [4],
                        render: function (data, type, row) {
                            return convertToRupiah2(data)
                        }
                    },
                    {
                        targets: [6],
                        render: function (data, type, row) {
                            return convertToRupiah2(data)
                        }
                    },
                ],
                "order": []
            });

            $('#tableData_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val();

                    tableData.destroy();
                    getDataTable(val);
                }
            })
        }

        $(document).on('click', '.modalData', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().text();
            console.log($(this));
            getDataDeskripsi(kode);
            getDataSupplier(kode);
        });

        function getDataDeskripsi(val) {
            $.ajax({
                url: '{{ url()->current() }}/get-deskripsi',
                type: 'GET',
                data: {
                    supp: val,
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    $('#deskripsi').val(response);
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    errorHandlingforAjax(error);
                }
            });
        }

        $(document).on('keypress', '#supplier', function (e) {
            if (e.which == 13) {
                getDataSupplier($(this).val());
            }
        });

        $(document).on('change', '#voucher-join-promo', function (e) {
            val = $(this).val().toUpperCase();
            console.log(val)
            if (val != 'Y' && val != 'T') {
                $(this).val('');
                $(this).select();
                swal('Error', "Isi 'Y' / 'T' saja", 'error');
                return false;
            }
        });

        function getDataSupplier(value) {
            $.ajax({
                url: '{{ url()->current() }}/get-data-supplier',
                type: 'GET',
                data: {
                    supp: value,
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    console.log(response)
                    $('#supplier').val(value);
                    if (response.data.vcs_nilaivoucher != undefined) {
                        $('#nilai-voucher').val(response.data.vcs_nilaivoucher != undefined ? response.data.vcs_nilaivoucher : 0);
                        $('#masaberlaku1').val(response.data.vcs_tglmulai != undefined ? response.data.vcs_tglmulai.substr(0, 10) : '');
                        $('#masaberlaku2').val(response.data.vcs_tglakhir != undefined ? response.data.vcs_tglakhir.substr(0, 10) : '');
                        $('#max-voucher').val(response.data.vcs_maxvoucher != undefined ? response.data.vcs_maxvoucher : '');
                        $('#min-struk').val(response.data.vcs_minstruk != undefined ? response.data.vcs_minstruk : '');
                        $('#voucher-join-promo').val(response.data.vcs_joinpromo != undefined ? response.data.vcs_joinpromo : '');
                        $('#keterangan').val(response.data.vcs_keterangan != undefined ? response.data.vcs_keterangan : '');
                    }

                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    errorHandlingforAjax(error);
                }
            });
        }

        function simpan() {
            if ($('#supplier').val() == '') {
                swal('Error', 'Mohon isi supp terlebih dahulu', 'error')
                return false;
            }
            swal({
                title: 'Yakin ingin menyimpan data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function (ok) {
                if (ok) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/simpan',
                        type: 'POST',
                        data: {
                            supp: $('#supplier').val().toUpperCase(),
                            vcs_nilaivoucher: $('#nilai-voucher').val(),
                            vcs_tglmulai: $('#masaberlaku1').val(),
                            vcs_tglakhir: $('#masaberlaku2').val(),
                            vcs_maxvoucher: $('#max-voucher').val(),
                            vcs_joinpromo: $('#voucher-join-promo').val().toUpperCase(),
                            vcs_keterangan: $('#keterangan').val().toUpperCase(),
                            vcs_minstruk: $('#min-struk').val(),
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            clearInput();
                            getDataTable('');
                            swal('Behasil!', response.message, response.status);
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            errorHandlingforAjax(error);
                        }
                    });
                }
            })

        }


        function hapus() {
            if ($('#supplier').val() == '') {
                swal('Error', 'Mohon isi supp terlebih dahulu', 'error')
                return false;
            }
            swal({
                title: 'Yakin ingin hapus data ' + $('#supplier').val() + ' ?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function (ok) {
                if (ok) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/hapus',
                        type: 'POST',
                        data: {
                            supp: $('#supplier').val(),
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            clearInput();
                            getDataTable('');
                            swal('Behasil!', response.message, response.status);
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            errorHandlingforAjax(error);
                        }
                    });
                }
            })

        }

        function clearInput() {
            $('input').each(function () {
                $(this).val('');
            });
        }

        function cetak() {
            window.open(`{{ url()->current() }}/cetak`);
        }
    </script>
@endsection
