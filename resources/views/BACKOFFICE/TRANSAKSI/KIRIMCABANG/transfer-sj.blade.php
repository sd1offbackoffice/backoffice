@extends('navbar')

@section('title','PENGIRIMAN KE CABANG | TRANSFER SJ')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <fieldset class="card border-secondary">
                <legend class="w-auto ml-3">Transfer Surat Jalan</legend>
                <div class="m-4">
                    <fieldset class="card border-secondary mb-2">
                        <div class="card-body">
                            <div class="row form-group">
                                <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal :</label>
                                <div class="col-sm-2">
                                    <input maxlength="10" type="text" class="form-control tanggal" id="tanggal" onchange="getData()" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary">
                        <div class="card-body">
                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden" style="position: sticky">
                                <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                    <thead class="thColor">
                                        <tr>
                                            <th width="50%">Cabang</th>
                                            <th width="35%">Nomor Dokumen</th>
                                            <th width="15%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="row form-group mt-3 mb-0">--}}
                            {{-- <div class="custom-control custom-checkbox col-sm-2 ml-3">--}}
                            {{-- <input type="checkbox" class="custom-control-input" id="cb_checkall" onchange="checkAll(event)">--}}
                            {{-- <label for="cb_checkall" class="custom-control-label">Check All</label>--}}
                            {{-- </div>--}}
                            {{-- </div>--}}
                        </div>
                    </fieldset>
                    {{--<div class="row form-group mt-2">--}}
                    {{--<div class="col">--}}
                    {{--<select class="form-control">--}}
                    {{--<option>1. Transfer Data via e-mail</option>--}}
                    {{--<option>2. Transfer Data via FTP</option>--}}
                    {{--</select>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{-- <div class="row form-group mt-2">--}}
                    {{-- <div class="col-sm-6">--}}
                    {{-- <button class="col btn btn-primary" onclick="transfer()">Transfer Surat Jalan</button>--}}
                    {{-- </div>--}}
                    {{-- <div class="col-sm-6">--}}
                    {{-- <button class="col btn btn-danger">Batal</button>--}}
                    {{-- </div>--}}
                    {{-- </div>--}}
                </div>
            </fieldset>
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
</style>

<script>
    var listNomor = [];
    var selected = [];
    var reprint, last = false;
    let currurl = '{{ url()->current() }}';

    $(document).ready(function() {
        $('.tanggal').datepicker({
            "dateFormat": "dd/mm/yy",
        });

        $('.tanggal').datepicker('setDate', new Date());

        getData();

        // $('.tanggal').datepicker('setDate', new Date());

        // $('#tanggal1').val('01/04/2020');
    });

    function getData() {
        if ($('#tanggal').val() != '') {
            $.ajax({
                url: currurl + '/get-data',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    tgl: $('#tanggal').val(),
                },
                beforeSend: function() {
                    $('#modal-loader').modal('show');
                },
                success: function(response) {
                    $('#modal-loader').modal('hide');

                    if (response.length == 0) {
                        swal({
                            title: 'Data tidak ditemukan!',
                            icon: 'warning'
                        })
                    } else {
                        $('#table_daftar tbody tr').remove();
                        listNomor = [];
                        for (i = 0; i < response.length; i++) {
                            listNomor.push(response[i].no);

                            tr = `<tr><td>${response[i].cabang}</td>` +
                                `<td>${response[i].nodoc}</td>` +
                                `<td>` +
                                `<button class="btn btn-primary" onclick="transfer('${response[i].cabang}','${response[i].nodoc}')">TRANSFER</button>` +
                                `</td></tr>`;
                            $('#table_daftar tbody').append(tr);
                        }
                    }
                },
                error: function(error) {
                    $('#modal-loader').modal('hide');
                }
            });
        }
    }

    function selectDaftar(e, nodoc) {
        if ($(e.target).is(':checked')) {
            selected.push(nodoc);
        } else {
            selected = $.grep(selected, function(value) {
                return value != nodoc;
            });
        }
    }

    function checkAll(e) {
        if ($(e.target).is(':checked')) {
            $('.cb-no').prop('checked', true);
            selected = listNomor;
        } else {
            $('.cb-no').prop('checked', false);
            selected = [];
        }
    }

    function transfer(cabang, nodoc) {
        swal({
            title: 'Yakin ingin transfer Surat Jalan untuk cabang ' + cabang + ' ?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((ok) => {
            if (ok) {
                $.ajax({
                    url: currurl + '/transfer',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        nodoc: nodoc,
                    },
                    beforeSend: function() {
                        $('#modal-loader').modal('show');
                    },
                    success: function(response) {
                        $('#modal-loader').modal('hide');

                        if (response == 'success') {
                            swal({
                                title: 'Silahkan file dikirim ke cabang yang bersangkutan!',
                                icon: 'success'
                            }).then(() => {
                                window.open(`{{ url()->current() }}/download`, '_blank');
                                $('#tanggal').val('');
                                $('#table_daftar tbody tr').remove();
                            });
                        } else {
                            swal({
                                title: 'Terjadi kesalahan!',
                                text: 'Mohon coba kembali!',
                                icon: 'error',
                            })
                        }
                    },
                    error: function(error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: 'Terjadi kesalahan!',
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                    }
                });
            }
        })
    }


    function transferByBranch(index) {
        $.ajax({
            url: currurl + '/transfer',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                nodoc: selected[index],
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
            },
            success: function(response) {
                $('#modal-loader').modal('hide');

                if (index < selected.length) {
                    window.open('{{ url()->current() }}/download', '_blank');
                    transferByBranch(++index);
                } else {
                    if (response == 'success') {
                        window.location.replace(currurl + '/download');
                        swal({
                            title: 'Silahkan file dikirim ke cabang yang bersangkutan!',
                            icon: 'success'
                        }).then(() => {
                            $('#tanggal').val('');
                            $('#table_daftar tbody tr').remove();
                        });
                    } else {
                        swal({
                            title: 'Terjadi kesalahan!',
                            text: 'Mohon coba kembali!',
                            icon: 'error',
                        })
                    }
                }
            },
            error: function(error) {
                $('#modal-loader').modal('hide');
                swal({
                    title: 'Terjadi kesalahan!',
                    text: error.responseJSON.message,
                    icon: 'error',
                });
            }
        });
    }
</script>

@endsection