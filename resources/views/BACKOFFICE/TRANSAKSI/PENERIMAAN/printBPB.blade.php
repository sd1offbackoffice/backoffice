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
                            <button class="btn btn-primary offset-sm-8 col-sm-1 btn-block mr-3" type="button" onclick="viewData()">View Data</button>
                            <button class="btn btn-primary col-sm-1 mr-3" type="button" onclick="cetakData()" id="btnCetak">Cetak BPB</button>
                            <button class="btn btn-danger col-sm-1" type="button" onclick="batalCetak()">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sign Here : </h5>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div id="jabatan">
                                <p><b>Jabatan: </b>Logistic Adm.Clerk</p>
                                <input type="text" class="form-control" id="nama_personil" placeholder="">
                            </div>
                            <div id="sig"></div>
                            <br />
                            <button id="clear" class="btn btn-danger">Clear</button>
                            <button id="save" class="btn btn-success">Save</button>
                            <textarea id="signature64" name="signed" style="display: none"></textarea>
                        </div>
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
        width: 400px;
        height: 400px;
    }

    #sig canvas {
        width: 100%;
        height: 100%;
    }
</style>

<script>
    let typeTrn;
    let tablePrintBPB;
    let btnCetak = $('#btnCetak');
    let documentTemp;
    var currUrl = '{{ url()->current() }}';
    currUrl = currUrl.replace("index", "");
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
                    break;

                case "lain":
                    typeTrn = 'L';
                    break;

                default:
                    typeTrn = 'N';
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
                document: document
            },
            beforeSend: () => {
                $('#modal-loader').modal('show');
            },
            success: function(result) {
                $('#modal-loader').modal('hide');
                console.log(result);
                if (result.kode == 1) {
                    documentTemp = document;
                    if (result.list == 1) {
                        window.open(currUrl + 'viewreport/' + checked + '/' + result.data + '/' + documentTemp + '/' + result.list);
                    } else {
                        if (result.nota != null || result.nota != '') {
                            showModal();
                            var sig = $('#sig').signature({
                                syncField: '#signature64',
                                syncFormat: 'PNG'
                            });
                            $('#save').click(function(e) {
                                var dataURL = $('#sig').signature('toDataURL', 'image/jpeg', 0.8);
                                ajaxSetup();
                                $.ajax({
                                    type: "POST",
                                    url: currUrl + 'save',
                                    data: {
                                        sign: dataURL,
                                        signed: $('#signature64').val()
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
                                            window.open(currUrl + 'viewreport/' + checked + '/' + split_nota[0] + '/' + result.nota + '/' + response.data);
                                            window.open(currUrl + 'viewreport/' + checked + '/' + split_nota[1] + '/' + result.nota + '/' + response.data);
                                            if (result.lokasi == 1 && checked == 0) {
                                                window.open(currUrl + 'viewreport/' + checked + '/' + 'lokasi' + '/' + documentTemp + '/' + result.lokasi);
                                            }
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

    $("#selectAll").click(function() {
        $(".data-checkbox").prop('checked', $(this).prop('checked'));
        // $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        // $(".data-checkbox").prop('checked', true);
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

    $('#size').keypress(function(e) {
        if (e.which === 13) {
            viewData();
        }
    })
</script>



@endsection