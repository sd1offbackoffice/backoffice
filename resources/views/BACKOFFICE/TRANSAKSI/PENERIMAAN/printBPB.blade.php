@extends('navbar')
@section('title','PENERIMAAN | CETAK BPB')
@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card border-dark">
                <div class="card-body cardForm">
                    <form>
                        <div class="form-group row mb-1 pt-4">
                            <label class="col-sm-2 col-form-label text-right">Tanggal</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="startDate" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                            </div>
                            <label class="col-form-label text-center">sd</label>
                            <div class="col-sm-2">
                                <input type="date" class="form-control" id="endDate" value="{{\Carbon\Carbon::today()->format('Y-m-d')}}">
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-sm-2 col-form-label text-right">Jenis Laporan</label>
                            <div class="col-sm-1">
                                <select class="form-control" id="type">
                                    <option value="1">List</option>
                                    <option value="2">Nota</option>
                                </select>
                            </div>
                            <div class="col-sm-1 mt-3">
                                <input type="checkbox" class="form-check-input" id="re-print" name="re-print" value="1">
                                <label class="form-check-label" id="re-print" for="re-print">Re-Print</label>
                            </div>
                        </div>

                        <div class="form-group row mb-1">
                            <label class="col-sm-2 col-form-label text-right">Ukuran Kertas</label>
                            <div class="col-sm-1">
                                <select class="form-control" id="size">
                                    <option value="1">Kecil</option>
                                    <option value="2">Biasa</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <button class="btn btn-primary offset-sm-7 col-sm-1 btn-block mr-3" type="button" onclick="viewData()">View Data</button>
                            <button class="btn btn-primary col-sm-1 mr-3" type="button" onclick="cetakData()" id="btnCetak">Cetak BPB</button>
                            <button class="btn btn-danger col-sm-1 mr-3" type="button" onclick="batalCetak()">Batal</button>
                            <button class="btn btn-info col-sm-1 mr-3" type="button" onclick="showFtp()" data-target="#ftpModal" data-toggle="modal">Kirim Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FTP Modal -->
<div class="modal fade" id="ftpModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-sm">
                    <label for="chosenDate">Tanggal</label>
                    <div class="input-group mb-3">
                        <input type="date" class="form-control" id="chosenDate">
                    </div>
                    <div class="row justify-content-center">
                        <button class="btn btn-info btn-lg" type="button" onclick="kirimFtp()">Kirim Report</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FTP Modal -->

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card border-dark">
                <div class="card-body cardForm">
                    <div class="table-wrapper">
                        <table class="table table-sm table-striped table-bordered " id="tablePrintBPB">
                            <thead class="theadDataTables">
                                <tr>
                                    <th id="changeTheadName">No Referensi</th>
                                    <th>Tanggal</th>
                                    <th>
                                        <div class="text-center">
                                            <input type="checkbox" class="form-check-input text-right" id="selectAll" name="selectAll" value="1">
                                            <label class="form-check-label text-white text-right" for="selectAll"> Check All</label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="tbodyTableBTB"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
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
                            <button id="save" class="btn btn-success btn-lg">Save</button>
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


    <!-- BTB Modal -->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="modalHelpTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-borderless" id="tableModalHelp">
                                    <thead class="theadDataTables">
                                        <tr>
                                            <th id="modalThName1"></th>
                                            <th id="modalThName2"></th>
                                            <th id="modalThName3"></th>
                                            <th id="modalThName4"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                                <p class="text-hide" id="idModal"></p>
                                <p class="text-hide" id="idRow"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BTB Modal -->

    <style>
        .table-wrapper {
            overflow-y: scroll;
            height: 500px;
        }

        .table-wrapper th {
            position: sticky;
            top: 0;
        }

        .table-wrapper table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-wrapper th {
            background: #5AA4DD;
        }

        .table-wrapper td,
        th {
            padding: 10px;
            text-align: center;
        }

        .kbw-signature {
            width: 800px;
            height: 750px;
        }

        #sig canvas,
        #sig2 canvas,
        #sig3 canvas {
            width: 100%;
            height: 100%;
        }

        td {
            text-align: center;
        }

        .modalRowNames {
            cursor: pointer;
        }

        .modalRowNames:hover {
            background-color: #e9ecef;
        }
    </style>

    <script>
        let typeTrn;
        let tablePrintBPB;
        let btnCetak = $('#btnCetak');
        let documentTemp;
        var currUrl = '{{ url()->current() }}';
        currUrl = currUrl.replace("index", "");
        let modalHelpTitle = $('#modalHelpTitle')
        let modalThName1 = $('#modalThName1');
        let modalThName2 = $('#modalThName2');
        let modalThName3 = $('#modalThName3');
        let modalThName4 = $('#modalThName4');
        let modalHelp = $('#modalHelp');
        let tableModalHelp = $('#tableModalHelp').DataTable();
        let nama_personil = $('#nama_personil');
        let ftpModal = $('#ftpModal');
        let chosenDate = $('#chosenDate');
        $(document).ready(function() {
            startAlert();
            // typeTrn = 'B'
            btnCetak.attr('disabled', true);
            // tablePrintBPB = $('#tablePrintBPB').DataTable()
        });

        function startAlert() {
            swal({
                title: 'Jenis Penerimaan?',
                icon: 'info',
                buttons: {
                    confirm: "Penerimaan",
                    roll: {
                        text: "Lain-lain",
                        value: "lain",
                    },
                }
            }).then(function(confirm) {
                switch (confirm) {
                    case true:
                        typeTrn = 'B';
                        viewData();
                        break;

                    case "lain":
                        typeTrn = 'L';
                        viewData();
                        break;

                    default:
                        typeTrn = 'N';
                        viewData();
                }
                $('#startDate').focus();
            })
        }

        function viewData() {
            if (!typeTrn || typeTrn === 'N') {
                startAlert();

                return false;
            }

            let startDate = $('#startDate').val();
            let endDate = $('#endDate').val();
            let type = $('#type').val();
            let size = $('#size').val();
            let checked = ($("input:checked").val()) ? $("input:checked").val() : '0';

            ajaxSetup();
            $.ajax({
                method: 'POST',
                url: currUrl + 'viewdata',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    type: type,
                    size: size,
                    checked: checked,
                    typeTrn: typeTrn
                },
                beforeSend: () => {
                    $('#modal-loader').modal('show');
                    // tablePrintBPB.row().remove();
                    $('.rowTbodyTableBTB').remove();
                },
                success: function(result) {
                    $("#selectAll").prop("checked", false);
                    console.log(result);
                    $('#modal-loader').modal('hide');
                    if (type == 2) {
                        $('#changeTheadName').text('No Dokumen');
                    } else {
                        $('#changeTheadName').text('No Referensi');
                    }

                    if (result.length > 0) {
                        $('.rowTbodyTableBTB').remove();
                        for (let i = 0; i < result.length; i++) {
                            // tablePrintBPB.row.add([result[i].msth_nodoc, formatDate(result[i].msth_tgldoc), `<input type="checkbox" class="form-control"  value="1">`]).draw()
                            $('#tbodyTableBTB').append(`<tr class="rowTbodyTableBTB">
                                                            <td>${result[i].nodoc}</td>
                                                            <td>${formatDate(result[i].tgldoc)}</td>
                                                            <td><input type="checkbox" class="form-control data-checkbox" name="type"  value="${result[i].nodoc}"></td>
                                                        </tr>`)
                        }
                        btnCetak.attr('disabled', false);
                    } else {
                        $('.rowTbodyTableBTB').remove();
                        $('#tbodyTableBTB').append(`<tr class="rowTbodyTableBTB"> <td colspan="3" class="text-center">No data available in table</td> </tr>`)
                        // tablePrintBPB.row.add(['--', '--', '--']).draw()
                        btnCetak.attr('disabled', true);
                    }
                },
                error: function(err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message)
                }
            })
        }

        function batalCetak() {
            location.reload();
        }

        function showUser() {
            try {
                modalHelp.modal('show');
                modalHelpTitle.text("Daftar Nama");
                modalThName1.text('Id');
                modalThName2.text('Level');
                modalThName3.text('Nama');
                modalThName3.show();
                modalThName4.hide();
            } catch (e) {
                swal({
                    icon: 'info',
                    title: 'Data Sama',
                    text: 'Data Tidak Ditemukan!',
                    timer: 2000
                });
            }

            tableModalHelp.clear().destroy();
            tableModalHelp = $('#tableModalHelp').DataTable({
                ajax: currUrl + 'users',
                responsive: true,
                paging: true,
                ordering: true,
                paging: true,
                autoWidth: false,
                columns: [{
                        data: 'userid',
                        name: 'Id'
                    },
                    {
                        data: 'userlevel',
                        name: 'Level'
                    },
                    {
                        data: 'username',
                        name: 'Nama'
                    },
                ],
                createdRow: function(row, data, dataIndex) {
                    $(row).addClass('modalRowNames');
                },
                "order": []
            });
        }

        $(document).on('click', '.modalRowNames', function() {
            let currentButton = $(this);
            let userid = currentButton.children().first().text();
            let userlevel = currentButton.children().first().next().text();
            let username = currentButton.children().first().next().next().text();
            nama_personil.val(username);
            modalHelp.modal('hide');
        });

        function showModal() {
            $('#m_signature').modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        $(document).keypress(function(e) {
            if (e.keyCode == 32) {
                $('#clear').click();
            } else if (e.keyCode == 13) {
                $('#save').click();
            }
        });

        function kirimFtp() {
            if (chosenDate.val() == null || chosenDate.val() == '') {
                swal({
                    icon: 'warning',
                    title: 'Tanggal Kosong',
                    text: 'Mohon isi tanggal!',
                    timer: 2000
                });
            } else {
                var currUrl = '{{ url()->current() }}';
                currUrl = currUrl.replace("index", "");
                swal("Kirim File dari server ke SD6?", {
                    icon: "info",
                    buttons: {
                        cancel: {
                            text: "Tutup",
                            value: 'tutup',
                            visible: true
                        },
                        confirm: {
                            text: "Kirim",
                            value: 'kirim',
                            visible: true
                        },
                    },
                }).then((result) => {
                    if (result == 'kirim') {
                        $.ajax({
                            method: 'GET',
                            data: {
                                chosenDate: chosenDate.val()
                            },
                            url: currUrl + 'kirimftp',
                            beforeSend: () => {
                                $('#modal-loader').modal('show');
                            },
                            success: (response) => {
                                console.log(response)
                                $('#modal-loader').modal('hide');
                                if (response['kode'] == 0) {
                                    swal('', response['message'], 'error');
                                } else if (response['kode'] == 1) {
                                    swal('', response['message'], 'success');
                                } else {
                                    swal('', response['message'], 'info');
                                }
                            },
                            error: (error) => {
                                $('#modal-loader').modal('hide');
                                console.log(error)
                            }
                        });
                    }
                });
            }
        }

        function showFtp() {
            ftpModal.modal();
        }

        function fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, flag) {
            $.ajax({
                method: 'POST',
                url: currUrl + 'cetakdata',
                data: {
                    startDate: startDate,
                    endDate: endDate,
                    type: type,
                    size: size,
                    checked: checked,
                    typeTrn: typeTrn,
                    document: document,
                    flag: flag
                },
                beforeSend: () => {
                    $('#modal-loader').modal('show');
                    var signedBy = $('#nama_personil').val('');
                },
                success: function(result) {
                    $('#modal-loader').modal('hide');
                    console.log(result);
                    if (result.kode == 1) {
                        documentTemp = document;
                        if (result.list == 1) {
                            window.open(currUrl + 'viewreport/' + checked + '/' + result.data + '/' + documentTemp + '/' + result.list);
                            // setTimeout(window.location.reload(), 500);
                        } else {
                            if (result.nota != null || result.nota != '') {
                                showModal();
                                var sig = $('#sig').signature({
                                    syncField: '#signature64',
                                    syncFormat: 'PNG'
                                });
                                $('#save').click(function(e) {
                                    if ($('#nama_personil').val() == null || $('#nama_personil').val() == '') {
                                        swal({
                                            icon: 'info',
                                            title: 'Nama Kosong',
                                            text: 'Harap mengisi nama personil expedisi!',
                                            timer: 2000
                                        });
                                    } else {
                                        var dataURL = $('#sig').signature('toDataURL', 'image/jpeg', 0.8);
                                        signedBy = $('#nama_personil').val();
                                        ajaxSetup();
                                        $.ajax({
                                            type: "POST",
                                            url: currUrl + 'save',
                                            data: {
                                                sign: dataURL,
                                                signed: $('#signature64').val(),
                                                signedby: signedBy
                                            },
                                            beforeSend: function() {
                                                $('#modal-loader').modal('show');
                                            },
                                            success: function(response) {
                                                console.log(response);
                                                swal({
                                                    title: response.message,
                                                    icon: 'success'
                                                }).then(function(ok) {
                                                    $('#clear').click();
                                                    $('#modal-loader').modal('hide');
                                                    $('#m_signature').modal('hide');
                                                    data_nota = result.data;
                                                    split_nota = data_nota.split(",");
                                                    // window.open(currUrl + 'viewreport/' + checked + '/' + split_nota[0] + '/' + result.nota + '/' + response.data); //NOTA HARGA
                                                    window.open(currUrl + 'viewreport/' + checked + '/' + split_nota[1] + '/' + result.nota + '/' + response.data);
                                                    if (result.lokasi == 1 && checked == 0) {
                                                        window.open(currUrl + 'viewreport/' + checked + '/' + 'lokasi' + '/' + documentTemp + '/' + result.lokasi);
                                                    }
                                                    // setTimeout(window.location.reload(), 500);
                                                });
                                            },
                                            error: function(error) {
                                                $('#modal-loader').modal('hide');
                                                swal({
                                                    title: error.message,
                                                    icon: 'error',
                                                }).then(() => {
                                                    $('#modal-loader').modal('hide');
                                                });
                                            },
                                        })
                                    }
                                });
                                $('#clear').click(function(e) {
                                    e.preventDefault();
                                    sig.signature('clear');
                                    $("#signature64").val('');
                                });
                            }
                        }
                    } else {
                        swal('Data tidak terbaca', 'Mohon muat ulang dan coba lagi/ uncheck check all sebelum view data', 'error');
                    }
                },
                error: function(err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0, 100));
                    alertError(err.statusText, err.responseJSON.message)
                }
            })
        }

        function cetakData() {
            let startDate = $('#startDate').val();
            let endDate = $('#endDate').val();
            let type = $('#type').val();
            let size = $('#size').val();
            let checked = ($("#re-print").prop('checked')) ? '1' : '0';
            let document = [];
            var currUrl = '{{ url()->current() }}';
            currUrl = currUrl.replace("index", "");
            if (!startDate || !endDate) {
                swal('Tanggal harus diisi !!', '', 'warning');
                return false;
            }

            $("input:checkbox[name=type]:checked").each(function() {
                document.push($(this).val());
                console.log($(this).val());
            });
            if (document.length > 1) {
                if (type == 2) {
                    swal({
                        title: 'Peringatan',
                        text: 'Anda akan mencetak beberapa dokumen dengan tanda tangan supplier yang sama, apakah anda yakin?',
                        icon: 'warning',
                        buttons: {
                            cancel: {
                                text: "Batal",
                                value: 'batal',
                                visible: true
                            },
                            confirm: {
                                text: "Oke",
                                value: 'oke',
                                visible: true
                            },
                        },
                    }).then((result) => {
                        if (result == 'oke') {
                            fxcetakData(startDate, endDate, type, size, checked, typeTrn, document);
                        }
                    });
                    if (checked == 0) {
                        swal({
                            title: 'Peringatan',
                            text: 'Anda akan mencetak beberapa dokumen dengan tanda tangan supplier yang sama, apakah anda yakin?',
                            icon: 'warning',
                            buttons: {
                                cancel: {
                                    text: "Batal",
                                    value: 'batal',
                                    visible: true
                                },
                                confirm: {
                                    text: "Oke",
                                    value: 'oke',
                                    visible: true
                                },
                            },
                        }).then((result) => {
                            if (result == 'oke') {
                                ajaxSetup();
                                $.ajax({
                                    type: "GET",
                                    url: currUrl + 'check-flag',
                                    data: {
                                        document: document
                                    },
                                    beforeSend: function() {
                                        $('#modal-loader').modal('show');
                                    },
                                    success: function(response) {
                                        var lastcost = [];
                                        var avgcost = [];
                                        var plu = [];
                                        for (j = 0; j <= response.length; j++) {
                                            for (i = 0; i <= response[0].length; i++) {
                                                try {
                                                    if (response[j][i]) {
                                                        if (response[j][i].prd_lastcost == 0) {
                                                            plu.push(response[j][i].prd_prdcd);
                                                            lastcost.push(response[j][i].prd_lastcost)
                                                        }
                                                        if (response[j][i].prd_avgcost != 0) {
                                                            avgcost.push(response[j][i].prd_avgcost)
                                                        }
                                                    }
                                                } catch (error) {
                                                    console.log('skip')
                                                }
                                            }
                                        }
                                        if (lastcost.length > 0) {
                                            if (avgcost.length > 0) {
                                                swal({
                                                    title: 'Peringatan',
                                                    text: 'PLU ' + plu.toString() + ' Avg Cost <> 0, Lakukan Update PKM ?',
                                                    icon: 'warning',
                                                    buttons: {
                                                        cancel: {
                                                            text: "Batal",
                                                            value: 'batal',
                                                            visible: true
                                                        },
                                                        confirm: {
                                                            text: "Oke",
                                                            value: 'oke',
                                                            visible: true
                                                        },
                                                    },
                                                }).then((result) => {
                                                    if (result == 'oke') {
                                                        var flag = 1;
                                                        $.ajax({
                                                            type: "GET",
                                                            url: currUrl + 'update-flag',
                                                            data: {
                                                                flag: flag
                                                            },
                                                            beforeSend: function() {
                                                                $('#modal-loader').modal('show');
                                                            },
                                                            success: function(response) {
                                                                fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, flag);
                                                            },
                                                            error: function(error) {
                                                                $('#modal-loader').modal('hide');
                                                                swal({
                                                                    title: error.message,
                                                                    icon: 'error',
                                                                }).then(() => {
                                                                    $('#modal-loader').modal('hide');
                                                                });
                                                            },
                                                        });
                                                    }
                                                    fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, 0);
                                                });
                                            } else {
                                                var flag = 1;
                                                $.ajax({
                                                    type: "GET",
                                                    url: currUrl + 'update-flag',
                                                    data: {
                                                        flag: flag
                                                    },
                                                    beforeSend: function() {
                                                        $('#modal-loader').modal('show');
                                                    },
                                                    success: function(response) {
                                                        fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, flag);
                                                    },
                                                    error: function(error) {
                                                        $('#modal-loader').modal('hide');
                                                        swal({
                                                            title: error.message,
                                                            icon: 'error',
                                                        }).then(() => {
                                                            $('#modal-loader').modal('hide');
                                                        });
                                                    },
                                                });
                                            }
                                        } else {
                                            var flag = 0;
                                            $.ajax({
                                                type: "GET",
                                                url: currUrl + 'update-flag',
                                                data: {
                                                    flag: flag
                                                },
                                                beforeSend: function() {
                                                    $('#modal-loader').modal('show');
                                                },
                                                success: function(response) {
                                                    fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, flag);
                                                },
                                                error: function(error) {
                                                    $('#modal-loader').modal('hide');
                                                    swal({
                                                        title: error.message,
                                                        icon: 'error',
                                                    }).then(() => {
                                                        $('#modal-loader').modal('hide');
                                                    });
                                                },
                                            });
                                        }
                                    },
                                    error: function(error) {
                                        $('#modal-loader').modal('hide');
                                        swal({
                                            title: error.message,
                                            icon: 'error',
                                        }).then(() => {
                                            $('#modal-loader').modal('hide');
                                        });
                                    },
                                })
                            }
                        });
                    }
                } else {
                    fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, 0);
                }
            } else {
                if (type == 2) {
                    if (checked == 0) {
                        ajaxSetup();
                        $.ajax({
                            type: "GET",
                            url: currUrl + 'check-flag',
                            data: {
                                document: document
                            },
                            beforeSend: function() {
                                $('#modal-loader').modal('show');
                            },
                            success: function(response) {
                                var lastcost = [];
                                var avgcost = [];
                                for (i = 0; i < response[0].length; i++) {
                                    if (response[0][i].prd_lastcost == 0) {
                                        lastcost.push(response[0][i].prd_lastcost)
                                    }
                                    if (response[0][i].prd_avgcost != 0) {
                                        avgcost.push(response[0][i].prd_avgcost)
                                    }
                                    console.log(response[0][i])
                                }
                                console.log(lastcost.length, avgcost.length)
                                if (lastcost.length > 0) {
                                    if (avgcost.length > 0) {
                                        swal({
                                            title: 'Peringatan',
                                            text: 'PLU ' + response[0][0].prd_prdcd + ' Avg Cost <> 0, Lakukan Update PKM ?',
                                            icon: 'warning',
                                            buttons: {
                                                cancel: {
                                                    text: "Batal",
                                                    value: 'batal',
                                                    visible: true
                                                },
                                                confirm: {
                                                    text: "Oke",
                                                    value: 'oke',
                                                    visible: true
                                                },
                                            },
                                        }).then((result) => {
                                            if (result == 'oke') {
                                                var flag = 1;
                                                $.ajax({
                                                    type: "GET",
                                                    url: currUrl + 'update-flag',
                                                    data: {
                                                        flag: flag
                                                    },
                                                    beforeSend: function() {
                                                        $('#modal-loader').modal('show');
                                                    },
                                                    success: function(response) {
                                                        fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, flag);
                                                    },
                                                    error: function(error) {
                                                        $('#modal-loader').modal('hide');
                                                        swal({
                                                            title: error.message,
                                                            icon: 'error',
                                                        }).then(() => {
                                                            $('#modal-loader').modal('hide');
                                                        });
                                                    },
                                                });
                                            } else {
                                                fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, 0);
                                            }
                                        });
                                    } else {
                                        var flag = 1;
                                        $.ajax({
                                            type: "GET",
                                            url: currUrl + 'update-flag',
                                            data: {
                                                flag: flag
                                            },
                                            beforeSend: function() {
                                                $('#modal-loader').modal('show');
                                            },
                                            success: function(response) {
                                                fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, flag);
                                            },
                                            error: function(error) {
                                                $('#modal-loader').modal('hide');
                                                swal({
                                                    title: error.message,
                                                    icon: 'error',
                                                }).then(() => {
                                                    $('#modal-loader').modal('hide');
                                                });
                                            },
                                        });
                                    }
                                } else {
                                    fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, 0);
                                }
                            },
                            error: function(error) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: error.message,
                                    icon: 'error',
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                });
                            },
                        })
                    } else {
                        fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, 0);
                    }
                } else {
                    fxcetakData(startDate, endDate, type, size, checked, typeTrn, document, 0);
                }
            }
        }

        $("#selectAll").click(function() {
            $(".data-checkbox").prop('checked', $(this).prop('checked'));
        });

        $('#startDate').on('change', function(e) {
            if ($('#endDate').val() < $('#startDate').val()) {
                swal("Tanggal Tidak Benar", "", "warning");
                $('#startDate').focus();
                $('#startDate').val('');
                return false
            } else {
                $('#endDate').focus();
            }
        })

        $('#endDate').on('change', function(e) {
            if ($('#endDate').val() < $('#startDate').val()) {
                swal("Tanggal Tidak Benar", "", "warning");
                $('#endDate').focus();
                $('#endDate').val('');
                return false
            } else {
                $('#type').focus();
            }
        })

        $('#type').on('change', function(e) {
            $('#modal-loader').modal('show');
            setTimeout(viewData, 500);
            setTimeout(viewData, 500);
            $('#modal-loader').modal('hide');
        })
        $('#size').keypress(function(e) {
            if (e.which === 13) {
                viewData();
            }
        })
    </script>



    @endsection