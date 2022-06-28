@extends('navbar')
@section('title','PENERIMAAN | INPUT')
@section('content')

<div class="container" style="width: 100%;">
    <div class="card border-dark">
        <div class="card-body cardForm">
            <fieldset class="card border-dark">
                <legend class="w-auto ml-5">Proses Data NRB Krat atas BPB Toko IGR</legend>
                <div class="container p-4">
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="nodraft" style="width: 100px;">No. Draft</span>
                                </div>
                                <input type="text" class="form-control" id="nodraftval" aria-describedby="nodraft">
                                <button class="btn btn btn-light" type="button" id="showbtn" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="show()">&#x1F50E;</button>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="tgldraft" style="width: 100px;">Tgl. Draft</span>
                                </div>
                                <input type="text" class="form-control" id="tgldraftval" aria-describedby="tgldraft">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="qtydraft" style="width: 100px;">Qty. Draft</span>
                                </div>
                                <input type="text" class="form-control" id="qty_draft" aria-describedby="qtydraft">
                            </div>
                            <span style="display: block; height: 25px;"></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="plu" style="width: 100px;">PLU</span>
                                </div>
                                <input type="text" id="plu_val" class="form-control" aria-describedby="plu">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="qtynrb" style="width: 100px;">Qty. NRB</span>
                                </div>
                                <input type="text" class="form-control" id="qty_nrb" aria-describedby="qtynrb">
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="nobpb" style="width: 100px;">No. BPB</span>
                                </div>
                                <input type="text" id="nobpb_val" class="form-control" aria-describedby="nobpb">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="qtybpb" style="width: 100px;">Qty. BPB</span>
                                </div>
                                <input type="text" id="qty_bpb" class="form-control" aria-describedby="qtybpb">
                            </div>
                            <span style="display: block; height: 80px;"></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="qtysaldo" style="width: 100px;">Qty. Saldo</span>
                                </div>
                                <input type="text" id="qty_saldo" class="form-control" aria-describedby="qtysaldo">
                            </div>
                        </div>
                        <div class="col-sm">
                            <button class="btn btn-primary btn-block" id="btnNRB" onclick="process()">Proses NRB</button>
                            <span style="display: block; height: 15px;"></span>
                            <button class="btn btn-primary btn-block" onclick="cetak()">Cetak NRB</button>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="card border-dark">
                <legend class="w-auto ml-5">Upload Data IRPC</legend>
                <div class="container p-4">
                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="tgldata" style="width: 100px;">Tgl. Data</span>
                                </div>
                                <input type="date" id="tglval" class="form-control" aria-describedby="tgldata">
                            </div>
                        </div>
                        <div class="col-sm">
                            <button class="btn btn-primary btn-block" onclick="upload()">Upload IRPC</button>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

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
                                        <th id="modalThName5"></th>
                                        <th id="modalThName6"></th>
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

<style>
    .modalRowBPB {
        cursor: pointer;
    }

    .modalRowBPB:hover {
        background-color: #e9ecef;
    }
</style>

<script>
    let tgl = $('#tglval');
    let nodraft = $('#nodraftval');
    let qty_nrb = $('#qty_nrb');
    let qty_draft = $('#qty_draft');
    let tgldraft = $('#tgldraftval');
    let plu = $('#plu_val');
    let nobpb = $('#nobpb_val');
    let btnNRB = $('#btnNRB');
    let qty_bpb = $('#qty_bpb');
    let qty_saldo = $('#qty_saldo');
    let modalHelpTitle = $('#modalHelpTitle')
    let modalThName1 = $('#modalThName1');
    let modalThName2 = $('#modalThName2');
    let modalThName3 = $('#modalThName3');
    let modalThName4 = $('#modalThName4');
    let modalThName5 = $('#modalThName5');
    let modalThName6 = $('#modalThName6');
    let modalHelp = $('#modalHelp');
    let tableModalHelp = $('#tableModalHelp').DataTable();

    $(document).on('click', '.modalRowBPB', function() {
        let currentButton = $(this);
        let noDraft = currentButton.children().first().text();
        let noBPB = currentButton.children().first().next().text();
        let tglDraft = currentButton.children().first().next().next().text();
        let qtyBPB = currentButton.children().first().next().next().next().text();
        let tglNRB = currentButton.children().first().next().next().next().next().text();
        let qtyNRB = currentButton.children().first().next().next().next().next().next().text();

        nodraft.val(noDraft)
        qty_nrb.val(qtyNRB);
        tgldraft.val(tglDraft);
        nobpb.val(noBPB);
        qty_bpb.val(qtyBPB);

        modalHelp.modal('hide');
        nodraft.focus();
    });

    nodraft.keypress(function(e) {
        if (e.which === 13) {
            console.log(nodraft.text());
            if (nodraft.val() == null || nodraft.val() == '' ||
                tgldraft.val() == null || tgldraft.val() == '') {
                swal({
                    icon: 'info',
                    title: 'No Draft/ Tanggal Draft Kosong',
                    text: 'Harap Isi Data yang Kurang!',
                    timer: 2000
                });
            } else {
                check(nodraft.val(), tgldraft.val());
            }
        }
    });

    function show() {
        try {
            modalHelp.modal('show');
            modalHelpTitle.text("Daftar BPB");
            modalThName1.text('No Draft');
            modalThName2.text('No BPB');
            modalThName3.text('Tgl BPB');
            modalThName4.text('Qty BPB');
            modalThName5.text('Tgl NRB');
            modalThName6.text('Qty NRB');
        } catch (e) {
            console.log(e)
            swal({
                icon: 'info',
                title: 'Data Kosong',
                text: 'Data Tidak Ditemukan!',
                timer: 2000
            });
        }

        tableModalHelp.clear().destroy();
        tableModalHelp = $('#tableModalHelp').DataTable({
            ajax: '{{ url()->current() }}/show',
            responsive: true,
            paging: true,
            ordering: true,
            paging: true,
            autoWidth: false,
            columns: [{
                    data: 'krt_nodraft',
                    name: 'No Draft'
                },
                {
                    data: 'krt_nobpb',
                    name: 'No BPB'
                },
                {
                    data: 'krt_tglbpb',
                    name: 'Tgl BPB'
                },
                {
                    data: 'krt_qty_bpb',
                    name: 'Qty BPB'
                },
                {
                    data: 'krt_tglnrb',
                    name: 'Tgl NRB'
                },
                {
                    data: 'krt_qty_nrb',
                    name: 'Qty NRB'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('modalRowBPB');
            },
            "order": []
        });
    }

    function check(draft, tgl) {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/check',
            data: {
                nodraft: draft,
                tglDraft: tgl
            },
            type: 'get',
            success: function(result) {
                console.log(result)
                modalHelp.modal('hide')
                if (result.pointer == '1') {
                    nodraft.val('')
                } else if (result.pointer == '2') {
                    qty_nrb.disabled = true;
                    btnNRB.prop('disabled', true);
                }
                if (result.kode == 1) {
                    swal('', result.message, 'warning')
                }
                if (result.kode == 0) {
                    swal('', result.message, 'info')
                    nodraft.val(result.draft)
                    nodraft.focus()
                }
                if (result.kode == 2) {
                    qty_nrb.val(result.qty_saldo)
                    qty_nrb.focus()
                }
                plu.val(result.prdcd);
                qty_nrb.val(result.qty_nrb);
                qty_saldo.val(result.qty_saldo);
            },
            error: function(err) {
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message)
            }
        })
    }

    function upload() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/upload',
            data: {
                tgl: tgl.val(),
            },
            type: 'get',
            success: function(result) {
                console.log(result)
                if (result.kode == '0') {
                    swal('', result.message, 'info')
                } else if (result.kode == '1') {
                    swal('', result.message, 'warning')
                }
            },
            error: function(err) {
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message)
            }
        })
    }

    function cetak(no) {
        var currUrl = '{{ url()->current() }}';
        if (no == null || no == '') {
            no = nodraft.val()
        }
        console.log(no)
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/cetak/' + no,
            type: 'get',
            success: function(result) {
                if (result.kode == '1') {
                    swal('', result.message, 'warning')
                    nodraft.focus();
                } else {
                    window.open('{{ url()->current() }}/cetak/' + no);
                    swal('', result.message, 'info')
                    nodraft.val('')
                    qty_nrb.val('');
                    tgldraft.val('');
                    nobpb.val('');
                    qty_bpb.val('');
                }
            },
            error: function(err) {
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message)
            }
        })
    }

    function process() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/process',
            data: {
                qty_nrb: qty_nrb.val(),
                qty_draft: qty_draft.val(),
                nodraft: nodraft.val(),
                tgldraft: tgldraft.val()
            },
            type: 'get',
            success: function(result) {
                console.log(result)
                if (result.kode == '0') {
                    swal('', result.message, 'info')
                    cetak(result.nodraft);
                } else if (result.kode == '1') {
                    swal('', result.message, 'warning')
                    qty_nrb.val('');
                    qty_nrb.focus();
                }
            },
            error: function(err) {
                console.log(err.responseJSON.message.substr(0, 100));
                alertError(err.statusText, err.responseJSON.message)
            }
        })
    }
</script>
@endsection