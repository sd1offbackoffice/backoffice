@extends('navbar')

@section('title','BO | CETAK DOKUMEN')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="offset-1 col-sm-10">
                <fieldset class="card border-secondary">
                    <div class="card-body">
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-3">CETAK DOKUMEN
                                {{--                                <span class="text-danger">[ Jenis Dokumen : Pengeluaran dibuat oleh Pak Slamet]</span>--}}
                            </legend>
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
                                        <input type="checkbox" class="form-check-input" id="cetaknotareturfp"
                                               onchange="popupModalTTD()">
                                        <label for="cetaknotareturfp"> CETAK NOTA RETUR FP</label><br>
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
                                                <th><i class="fas fa-check"></i></th>
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
                                        <button class="col btn btn-success" onclick="cetakEFaktur()">CSV eFaktur
                                        </button>
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="col btn btn-success printBtn" onclick="printWithSignature()">CETAK</button>
                                        {{-- <button class="col btn btn-success printBtn" onclick="cetak()">CETAK</button> --}}
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

    <div class="modal fade" id="m_signature" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sign Here : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-2"></div>
                            <div class="col-3">
                                <label for="nama_personil">Supplier/Expedisi</label>
                            </div>
                            <div class="col-5">
                                <div class="input-group mb">
                                    <input autocomplete="off" type="text" id="nama_personil" class="form-control">
                                    <!-- <button id="showUserBtn" class="btn btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showUser()" placeholder="Mohon isi nama personil">&#x1F50E;</button> -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col">
                                <div class="containersig" style="text-align:center;">
                                    <div id="sig"></div>
                                    <div id="sig2" hidden></div>
                                    <div id="sig3" hidden></div>
                                </div>
                                <br />
                                <textarea id="signature64" name="signed" style="display: none"></textarea>
                                <textarea id="signature64_2" name="signed" style="display: none" hidden></textarea>
                                <textarea id="signature64_3" name="signed" style="display: none" hidden></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5"></div>
                            <div class="col">
                                <button id="clear" class="btn btn-danger btn-lg">Clear</button>
                                <span class="space"></span>
                                <button id="finalPrintBtn" class="btn btn-success btn-lg">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <label for="">Save -> Enter</label>
                        <label for="">/</label>
                        <label for="">Clear -> Space</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_result" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container" id="pdf">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_ttd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog-centered modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">TTD</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row form-group">
                        <label class="col-sm-5 col-form-label">Nama Penandatangan</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="nama-penandatangan">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-sm-5 col-form-label">Jabatan</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="jabatan1">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-sm-5 col-form-label">Jabatan 2</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="jabatan2">
                        </div>
                    </div>
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

        #sig canvas,
        #sig2 canvas,
        #sig3 canvas {
            width: 100%;
            height: 100%;
        }
    </style>

    <script>
        nomor = '';
        checked = [];
        $(document).ready(function () {
            $('.tanggal').datepicker({
                "dateFormat": "dd/mm/yy",
            });
            $('.tanggal').datepicker('setDate', new Date());
            $('.notareturfp').hide();
            cekTanggal();
            cekMenu();
            showData();
        });
        $('#tableDocument').DataTable();
        $('#dokumen,#laporan,#jenisKertas,#reprint,#tgl1,#tgl2').on('change', function () {
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
            tgl2 = $.datepicker.parseDate('dd/mm/yy', $('#tgl2').val());
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
            checked = [];
            $('#tableDocument').DataTable().destroy();
            $('#tableDocument').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/showData',
                    "data": {
                        'doc': $('#dokumen').val(),
                        'lap': $('#laporan').val(),
                        'reprint': $('#reprint:checked').val(),// on/off
                        'tgl1': $('#tgl1').val(),
                        'tgl2': $('#tgl2').val()
                    },
                },
                "columns": [
                    {data: 'nodoc', name: 'nodoc'},
                    {data: 'tgldoc', name: 'tgldoc'},
                    {data: 'cekbox', name: 'cekbox'},
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
                        targets: [1],
                        render: function (data, type, row) {
                            return formatDate(data)
                        }
                    }
                ],
                "order": []
            });
        }

        $('#check10lbl').on('change', function () {
            var bool = true;
            if ($(this).prop('checked') == true) {
                bool = true;
            } else {
                bool = false;
            }
            $("#tableDocument").find(".cekbox").each(function (index) {
                if (index < 10) {
                    $(this).prop('checked', bool);
                    val = $(this).val();
                    const index = checked.indexOf(val);
                    if (bool) {
                        if (index > -1) {
                        } else {
                            checked.push(val);
                        }
                    } else {
                        if (index > -1) {
                            checked.splice(index, 1);
                        }
                    }
                }
            });
        });
        $(document).on('change', '.cekbox', function () {
            val = $(this).val();
            if ($(this).prop('checked') == true) {
                checked.push(val);
            } else {
                const index = checked.indexOf(val);
                if (index > -1) {
                    checked.splice(index, 1);
                }
            }
        });

        function printWithSignature(){
            $('#m_signature').modal({
                backdrop: 'static',
                keyboard: false
            });

            let sig = $('#sig').signature({
                syncField: '#signature64',
                syncFormat: 'PNG'
            });            
            
            $('#finalPrintBtn').click(function (e) { 
                
                if ($('#nama_personil').val() == null || $('#nama_personil').val() == '') {
                    swal({
                        icon: 'info',
                        title: 'Nama Kosong',
                        text: 'Harap mengisi nama personil expedisi!',
                        timer: 2000
                    });
                } else {
                    let dataUrl = $('#sig').signature('toDataURL', 'image/jpeg', 0.8)
                    ajaxSetup()
                    $.ajax({
                        type: "POST",
                        url: "{{ url()->current() }}/save-signature",
                        data: {
                            sign: dataUrl,
                            signed: $('#signature64').val(),
                            signedBy: $('#nama_personil').val()
                        },
                        beforeSend: function() {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            $('#m_signature').modal('hide');
                            
                            console.log(response);

                            let signatureId = response.data.signatureId
                            let signedBy = response.data.signedBy

                            cetak(signatureId, signedBy)                            
                        }
                    });
                }
                
            });
        }

        function cetakEFaktur() {
            if ($('#dokumen').val() != 'K' && $('#laporan').val() != 'N') {
                swal({
                    title: 'Button Create CSV Faktur hanya untuk Dokumen Keluaran yang sudah cetak List.',
                    icon: 'info'
                });
            } else if (checked.length != 0) {
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/CSVeFaktur',
                    type: 'post',
                    data: {
                        doc: $('#dokumen').val(),
                        lap: $('#laporan').val(),
                        reprint: $('#reprint:checked').val(),
                        tgl1: $('#tgl1').val(),
                        tgl2: $('#tgl2').val(),
                        data: checked,
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (result) {
                        $('#modal-loader').modal('hide');
                        console.log(result);
                        if (result.status) {
                            swal({
                                title: result.message,
                                icon: result.status
                            });
                        } else {
                            window.open('../' + result, '_blank');
                        }
                    }, error: function (err) {
                        $('#modal-loader').modal('hide');
                        errorHandlingforAjax(err)
                    }
                })
            } else {
                swal({
                    title: 'Dokumen belum dipilih!',
                    icon: 'error'
                });
            }
        }

        function popupModalTTD() {
            if ($('#cetaknotareturfp:checked').val() == 'on') {
                $('#nama-penandatangan').val('');
                $('#jabatan').val('');
                $('#jabatan2').val('');
                $('#m_ttd').modal('show');
            }
        }

        function cetak(signatureId, signedBy) {
            if (checked.length != 0) {
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/cetak',
                    type: 'post',
                    data: {
                        nrfp: $('#cetaknotareturfp:checked').val(),
                        namattd: $('#nama-penandatangan').val(),
                        jbt1: $('#jabatan1').val(),
                        jbt2: $('#jabatan2').val(),
                        doc: $('#dokumen').val(),
                        lap: $('#laporan').val(),
                        reprint: $('#reprint:checked').val(),
                        tgl1: $('#tgl1').val(),
                        tgl2: $('#tgl2').val(),
                        kertas: $('#kertas').val(),
                        data: checked,
                        signatureId: signatureId,
                        signedBy: signedBy
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (result) {
                        $('#modal-loader').modal('hide');
                        $('#pdf').empty();
                        console.log(result);
                        buttons = '';
                        if (result) {

                            for (i = 0; i < result.length; i++) {
                                window.open(`{{ url()->current() }}/download?file=${result[i]}`, '_blank');
                            }

                        }
                        showData();
                        if (result.message) {
                            swal({
                                title: result.message,
                                icon: result.status
                            });
                        }                    }, error: function (err) {
                        $('#modal-loader').modal('hide');
                        errorHandlingforAjax(err);
                    }
                });
            } else {
                swal({
                    title: 'Dokumen belum dipilih!',
                    icon: 'error'
                });
            }
        }
    </script>

@endsection
