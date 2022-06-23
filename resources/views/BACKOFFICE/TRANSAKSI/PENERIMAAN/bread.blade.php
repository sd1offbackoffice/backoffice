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
                                <input type="text" class="form-control" aria-describedby="plu">
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
                                <input type="text" class="form-control" aria-describedby="nobpb">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="qtybpb" style="width: 100px;">Qty. BPB</span>
                                </div>
                                <input type="text" class="form-control" aria-describedby="qtybpb">
                            </div>
                            <span style="display: block; height: 80px;"></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="qtysaldo" style="width: 100px;">Qty. Saldo</span>
                                </div>
                                <input type="text" class="form-control" aria-describedby="qtysaldo">
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

<script>
    let tgl = $('#tglval');
    let nodraft = $('#nodraftval');
    let qty_nrb = $('#qty_nrb');
    let qty_draft = $('#qty_draft');
    let tgldraft = $('#tgldraftval');
    let btnNRB = $('#btnNRB');

    nodraft.keypress(function(e) {
        if (e.which === 13) {
            check();
        }
    });

    function check() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/check',
            data: {
                nodraft: nodraft.val(),
            },
            type: 'get',
            success: function(result) {
                console.log(result)
                if (result.pointer == '1') {
                    nodraft.val('')
                } else if (result.pointer == '2') {
                    qty_nrb.addClass('disabled')
                    btnNRB.addClass('disabled')
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

    function cetak() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/cetak',
            data: {
                nodraft: nodraft.val(),
            },
            type: 'get',
            success: function(result) {
                console.log(result)
                if (result.kode == '0') {
                    swal('', result.message, 'info')
                } else if (result.kode == '1') {
                    swal('', result.message, 'warning')
                    nodraft.focus();
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