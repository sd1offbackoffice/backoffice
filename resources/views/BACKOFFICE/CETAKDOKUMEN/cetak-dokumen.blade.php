@extends('navbar')

@section('title','BO | CETAK DOKUMEN')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="offset-1 col-sm-10">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-3">CETAK DOKUMEN</legend>
                            <div class="card-body">
                                <div class="row form-group">
                                    <label class="col-sm text-right col-form-label">Tanggal</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control tanggal" id="tgl1">
                                    </div>
                                    <label class="col-sm-1 text-right col-form-label">s/d</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control tanggal" id="tgl2">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-3 text-right col-form-label">Jenis Dokumen</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="dokumen">
                                            <option value="K">PENGELUARAN</option>
                                            <option value="H">BARANG HILANG</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4 form-check notareturfp">
                                        <input type="checkbox" class="form-check-input" id="cetaknotareturfp">
                                        <label for="reprint"> CETAK NOTA RETUR FP</label><br>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-3 text-right col-form-label">Jenis Laporan</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="laporan">
                                            <option value="L">LIST</option>
                                            <option value="N">NOTA</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="reprint">
                                        <label for="reprint"> RE-PRINT</label><br>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label class="col-sm-3 text-right col-form-label">Jenis Kertas</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="kertas">
                                            <option value="B">BIASA</option>
                                            <option value="K">KECIL</option>
                                        </select>
                                    </div>
                                </div>
                                <fieldset class="card border-secondary">
                                    <legend class="w-auto ml-3">[ DAFTAR DOKUMEN ]</legend>
                                    <div class="tableFixedHeader col-sm-12 text-center">
                                        <table class="table table-sm" id="tableDocument">
                                            <thead>
                                            <tr>
                                                <th id="nomor">NOMOR DOKUMEN</th>
                                                <th>TANGGAL</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbodyModalHelp"></tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-12 form-check ml-3">
                                        <input type="checkbox" class="form-check-input" id="check10lbl">
                                        <label for="check10lbl"> Check 10 Dokumen Pertama</label><br>
                                    </div>
                                </fieldset>

                                <div class="row form-group mt-3 mb-0">
                                    <div class="col-sm-4">
                                        <button class="col btn btn-success" onclick="print()">CSV eFaktur</button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="col btn btn-success" onclick="print()">CETAK</button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="col btn btn-primary" onclick="print()">BATAL</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-2"></div>
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
        nomor = '';
        $(document).ready(function () {
            $('.tanggal').datepicker({
                "dateFormat": "dd/mm/yy",
            });
            $('.tanggal').datepicker('setDate', new Date());
            $('.notareturfp').hide();
        });
        $('#tableDocument').DataTable();
        $('#dokumen').on('change', function () {
            cekTanggal();
            cekMenu();
            showData();
        });

        $('#dokumen,#laporan,#jenisKertas,#reprint').on('change', function () {
            cekTanggal();
            cekMenu();
            showData();
        });

        function cekMenu() {
            if ($('#dokumen').val() == 'K' && $('#laporan').val() == 'N') {
                nomor = 'NOMOR REFERENSI'
                $('.notareturfp').show();
            } else {
                nomor = 'NOMOR DOKUMEN';
                $('.notareturfp').hide();
            }
            $('#nomor').html(nomor);
        }

        function cekTanggal() {
            tgl1 = $.datepicker.parseDate('dd/mm/yy', $('#tgl1').val());
            ;
            tgl2 = $.datepicker.parseDate('dd/mm/yy', $('#tgl2').val());
            ;
            if ($('#reprint:checked').val() == 'on') {
                if (tgl1 == '' || tgl2 == '') {
                    swal({
                        title: 'Inputan belum lengkap!',
                        icon: 'warning'
                    });
                }
                if (new Date(tgl1) > new Date(tgl2)) {
                    swal({
                        title: 'Tanggal Tidak Benar!',
                        icon: 'warning'
                    });
                }
            }
        }

        function showData() {
            $('#tableDocument').DataTable().destroy();
            $('#tableDocument').DataTable({
                "ajax": {
                    'url': '{{ url('bo/cetak-dokumen/showData') }}',
                    "data": {
                        'doc': $('#dokumen').val(),
                        'tipe': $('#laporan').val(),
                        'reprint': $('#reprint:checked').val(),// on/off
                        'tgl1': $('#tgl1').val(),
                        'tgl2': $('#tgl2').val()
                    },
                },
                "columns": [
                    {data: 'nodoc', name: 'nodoc'},
                    {data: 'tgldoc', name: 'tgldoc'},
                    {data: 'checkbox', name: 'checkbox'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    // $(row).addClass('row_lov row_lov_document');
                },
                columnDefs: [
                    {
                        targets: [2],
                        render: function (data, type, row) {
                            return formatDate(data)
                        }
                    }
                ],
                "order": []
            });
            // ajaxSetup();
            // $.ajax({
            //     url: '/BackOffice/public/bo/cetak-dokumen/showData',
            //     type: 'post',
            //     data: {
            //         doc  : $('#dokumen').val(),
            //         tipe    : $('#laporan').val(),
            //         reprint    : $('#reprint:checked').val() ,// on/off
            //         tgl1    : $('#tgl1').val(),
            //         tgl2    : $('#tgl2').val()
            //     },
            //     beforeSend: function () {
            //         $('#modal-loader').modal('show');
            //     },
            //     success: function (result) {
            //         // for (i = 0; i< result.length; i++){
            //         //     $('#tableBody').append("<tr><td>"+ result[i].nodoc +"</td><td>"+ result[i].tgldoc.substring(0,10) +"</td><td><div class='form-check'><input class='form-check-input' type='checkbox' value='' id='check"+i+"'></div></td></tr>");
            //         // }
            //
            //         $('#modal-loader').modal('hide');
            //     }, error: function () {
            //         alert('error');
            //     }
            // })
        }
    </script>

@endsection
