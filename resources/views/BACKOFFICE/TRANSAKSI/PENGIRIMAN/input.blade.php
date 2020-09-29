@extends('navbar')
@section('content')
    {{--<head>--}}
    {{--<script src="{{asset('/js/bootstrap-select.min.js')}}"></script>--}}
    {{--</head>--}}


    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">PENGIRIMAN KE CABANG - INPUT</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                            <div class="col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="no_penyesuaian" class="col-sm-1 col-form-label pr-1">NOMOR TRN</label>
                                    <div class="col-sm-1 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                        <button id="btn-no-doc" type="button" class="btn btn-lov2 p-0"
                                                data-toggle="modal" data-target="#m_lov_penyesuaian">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <label for="tgl_penyesuaian" class="col-sm-1 col-form-label pr-1">TGL TRN</label>
                                    <div class="col-sm-1 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                        <button id="btn-no-doc" type="button" class="btn btn-lov2 p-0"
                                                data-toggle="modal" data-target="#m_lov_penyesuaian">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <label for="tgl_penyesuaian" class="col-sm-1 col-form-label pr-1">UTK CAB</label>
                                    <div class="col-sm-1 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                        <button id="btn-no-doc" type="button" class="btn btn-lov2 p-0"
                                                data-toggle="modal" data-target="#m_lov_penyesuaian">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <div class="col-sm-2 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                    </div>
                                    <div class="col-sm-2 buttonInside p-0">
                                    </div>
                                    <div class="col-sm-2 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label for="no_penyesuaian" class="col-sm-1 col-form-label pr-1">NO.REFF</label>
                                    <div class="col-sm-1 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                        <button id="btn-no-doc" type="button" class="btn btn-lov2 p-0"
                                                data-toggle="modal" data-target="#m_lov_penyesuaian">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <label for="tgl_penyesuaian" class="col-sm-1 col-form-label pr-1">TGL REFF</label>
                                    <div class="col-sm-1 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                        <button id="btn-no-doc" type="button" class="btn btn-lov2 p-0"
                                                data-toggle="modal" data-target="#m_lov_penyesuaian">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <label for="tgl_penyesuaian" class="col-sm-1 col-form-label pr-1">GUDANG</label>
                                    <div class="col-sm-1 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                    </div>
                                    <div class="col-sm-2 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                    </div>
                                    <button id="btn-no-doc" type="button" class="btn btn-danger col-sm-2"
                                            data-toggle="modal" data-target="#m_lov_penyesuaian">
                                        HAPUS DOKUMEN
                                    </button>
                                    <div class="col-sm-2 buttonInside p-0">
                                        <input type="text" class="form-control" id="no_penyesuaian">
                                    </div>
                                </div>
                                <hr>
                                <fieldset class="card border-secondary">
                                    <div class="card-body shadow-lg cardForm">
                                        <div class="row text-right">
                                            <div class="col-sm-12">
                                                <div class="tableFixedHeader" style="height: 300px !important;">
                                                    <table class="table table-hover" style="height: 250px">
                                                        <thead style="background-color: rgb(42, 133, 190); color: whitesmoke;">
                                                        <tr class="table-sm text-center">
                                                            <th class="text-center" colspan="5"></th>
                                                            <th class="text-center" colspan="2">STOCK</th>
                                                            <th class="text-center" colspan="2">KUANTUM</th>
                                                            <th class="text-center" colspan="4"></th>
                                                        </tr>
                                                        <tr>
                                                            <th scope="col" class="text-center"></th>
                                                            <th class="text-center">PLU</th>
                                                            <th class="text-center">DESKRIPSI</th>
                                                            <th class="text-center">SATUAN</th>
                                                            <th class="text-center">TAG</th>
                                                            <th class="text-center">CTN</th>
                                                            <th class="text-center">PCs</th>
                                                            <th class="text-center">CTN</th>
                                                            <th class="text-center">PCs</th>
                                                            <th class="text-center">HRG.SATUAN ( IN CTN )</th>
                                                            <th class="text-center">GROSS</th>
                                                            <th class="text-center">PPN</th>
                                                            <th class="text-center">KETERANGAN</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @for($i =0 ; $i< 50; $i++)
                                                            <tr>
                                                                <td scope="row">{{$i}}</td>
                                                                <td>Mark</td>
                                                                <td>Otto</td>
                                                                <td>Otto</td>
                                                                <td>Otto</td>
                                                                <td>Otto</td>
                                                                <td>Otto</td>
                                                                <td>Otto</td>
                                                                <td>@mdo</td>
                                                                <td>@mdo</td>
                                                                <td>@mdo</td>
                                                                <td>@mdo</td>
                                                                <td>@mdo</td>
                                                            </tr>
                                                        @endfor
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-sm-1">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" id="no_penyesuaian">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="card border-secondary mt-2">
                                    <div class="card-body shadow-lg cardForm">
                                        <div class="row text-right">
                                            <div class="col-sm-1">
                                                <label for="tgl_penyesuaian" class="col-form-label pr-1">TOTAL
                                                    ITEM</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="no_penyesuaian">
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="tgl_penyesuaian"
                                                       class="col-form-label pr-1">GROSS</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="no_penyesuaian">
                                            </div>
                                        </div>
                                        <div class="row text-right">
                                            <div class="col-sm-3">
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="tgl_penyesuaian"
                                                       class="col-form-label pr-1">PPN</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="no_penyesuaian">
                                            </div>
                                        </div>
                                        <div class="row text-right">
                                            <div class="col-sm-3">
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="tgl_penyesuaian"
                                                       class="col-form-label pr-1">TOTAL</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="no_penyesuaian">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="m_lov_penyesuaian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov" class="form-control search_lov" type="text"
                               placeholder="Inputkan No. Penyesuaian" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov">
                                    <thead>
                                    <tr>
                                        <td>No. Penyesuaian</td>
                                        <td>Tanggal</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($penyesuaian as $p)
                                        <tr onclick="doc_select('{{ $p->trbo_nodoc }}')" class="row_lov">
                                            <td>{{ $p->trbo_nodoc }}</td>
                                            <td>{{ $p->trbo_tgldoc }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="i_lov_plu" class="form-control search_lov" type="text"
                               placeholder="Inputkan Deskripsi / PLU Produk" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm" id="table_lov_plu">
                                    <thead>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>PLU</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($produk as $p)
                                        <tr onclick="plu_select('{{ $p->prd_prdcd }}')" class="row_lov">
                                            <td>{{ $p->prd_deskripsipanjang }}</td>
                                            <td>{{ $p->prd_prdcd }}</td>
                                        </tr>
                                    @endforeach
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
            background-color: grey;
            color: white;
        }

        input {
            text-transform: uppercase;
        }


    </style>

    <script>
        trlov = $('#table_lov_plu tbody').html();
        no = 'doc';
        jenisdoc = '';

        $('#tgl_penyesuaian').datepicker({
            "dateFormat": "dd/mm/yy"
        });

        $('#no_penyesuaian').select();

        $('#btn-no-doc').on('click', function () {
            no = 'doc';
        });

        $('#btn-no-reff').on('click', function () {
            no = 'reff';
        });

        $('#tgl_penyesuaian').on('change', function () {
            if (!checkDate($(this).val())) {
                swal({
                    title: 'Format tanggal salah!',
                    icon: 'error'
                }).then(function () {
                    $('#tgl_penyesuaian').val('');
                    $('#tgl_penyesuaian').select();
                })
            }
            else {
                $('#no_referensi').select();
            }
        });

        $('#m_lov_plu').on('shown.bs.modal', function () {
            $('#i_lov_plu').val('');
            $('#i_lov_plu').select();
        });

        $('#i_lov_plu').on('keypress', function (e) {
            if (e.which == 13) {
                if ($(this).val() == '') {
                    $('#table_lov_plu .row_lov').remove();
                    $('#table_lov_plu').append(trlov);
                }
                else {
                    if ($.isNumeric($(this).val())) {
                        search = convertPlu($(this).val());
                    }
                    else {
                        search = $(this).val().toUpperCase();
                    }
                    $.ajax({
                        url: '{{url('/bo/transaksi/penyesuaian/input/lov_plu_search')}}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {plu: search, lokasi: $('#tipe_barang').val()},
                        beforeSend: function () {
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#table_lov_plu .row_lov').remove();
                            html = "";

                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov" onclick=lov_select("' + response[i].prd_prdcd + '")>' +
                                    '<td>' + response[i].prd_deskripsipanjang + '</td>' +
                                    '<td>' + response[i].prd_prdcd + '</td></tr>';

                                $('#table_lov_plu').append(html);
                            }
                            $('#modal-loader').modal('toggle');

                            $('#i_lov_plu').select();
                        }
                    });
                }
            }
        });

        $('#plu').on('keypress', function (e) {
            if (e.which == 13) {
                plu_select($(this).val());
            }
        });

        function plu_select(plu) {
            $.ajax({
                url: '{{url('/bo/transaksi/penyesuaian/input/plu_select')}}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    tipempp: $('#tipe_mpp').val(),
                    tipebarang: $('#tipe_barang').val(),
                    plu: convertPlu(plu),
                    totalitem: nvl($('#totalitem').val(), '0'),
                    nodoc: $('#no_penyesuaian').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    $('#modal-loader').modal('toggle');

                    console.log(response);

                    $('#plu').val(convertPlu(plu));

                    $('#pcs').html(response.unit);

                    $('#deskripsi').val(response.barang);
                    $('#kemasan').val(response.kemasan);
                    $('#tag').val(response.tag);
                    $('#bandrol').val(response.bandrol);
                    $('#bkp').val(response.bkp);
                    $('#lastcost').val(convertToRupiah(response.lastcost));
                    $('#avgcost').val(convertToRupiah(response.avgcost));
                    $('#persediaan').val(response.persediaan);
                    $('#persediaan2').val(response.persediaan2);
                    $('#hrgsatuan').val(convertToRupiah(response.hrgsatuan));
                    $('#qty').val(parseInt(response.qty) % parseInt(response.kemasan.split('/').pop()));
                    $('#qtyk').val(response.qtyk);
                    $('#subtotal').val(convertToRupiah(response.subtotal));
                    $('#keterangan').val(response.keterangan);
                }
            });
        }

        $('#no_penyesuaian').on('keypress', function (e) {
            if (e.which == 13) {
                doc_select($(this).val());
            }
        });

        function doc_select(nodoc) {
            if (no == 'doc') {
                if (nodoc == '') {
                    swal({
                        title: 'Apakah Ingin Membuat Nomor Baru?',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then(function (ok) {
                        if (ok) {
                            $('#tgl_penyesuaian').attr('disabled', false);

                            $.ajax({
                                url: '{{url('/bo/transaksi/penyesuaian/input/doc_new')}}',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                beforeSend: function () {
                                    $('#modal-loader').modal('toggle');
                                },
                                success: function (response) {
                                    jenisdoc = 'baru';

                                    $('#modal-loader').modal('toggle');

                                    $('#no_penyesuaian').val(response);
                                    $('#tgl_penyesuaian').select();
                                }
                            });
                        }
                    });
                }
                else {
                    $.ajax({
                        url: '{{url('/bo/transaksi/penyesuaian/input/doc_select')}}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nodoc: nodoc
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');

                            if (response != null) {
                                jenisdoc = 'lama';

                                $('#tgl_penyesuaian').attr('disabled', true);

                                $('#no_penyesuaian').val(response['trbo_nodoc']);
                                $('#tgl_penyesuaian').val(formatDate(response['trbo_tgldoc']));
                                $('#no_referensi').val(response['trbo_noreff']);
                                $('#tgl_referensi').val(response['trbo_tglreff']);
                                $('#tipe_mpp').val(response['trbo_flagdisc1']);

                                if (response['trbo_flagdisc2'].length == 1)
                                    tipebarang = '0' + response['trbo_flagdisc2'];
                                else tipebarang = response['trbo_flagdisc2'];
                                $('#tipe_barang').val('0' + response['trbo_flagdisc2']);
                                $('#total').val(convertToRupiah(response['total']));
                                $('#totalitem').val(response['totalitem']);
                            }
                            else {
                                jenisdoc = 'xxx';

                                swal({
                                    title: 'Nomor Penyesuaian tidak ditemukan!',
                                    icon: 'error',
                                }).then(function () {
                                    $('input').val('');
                                    $('#no_penyesuaian').val(nodoc);
                                    $('#no_penyesuaian').select();
                                });
                            }

                            if ($('#m_lov_penyesuaian').is(':visible')) {
                                $('#m_lov_penyesuaian').modal('toggle');
                                $('#plu').select();
                            }
                        }
                    });
                }
            }
            else if (no == 'reff') {
                if ($('#no_penyesuaian').val() == '' || $('#tgl_penyesuaian').val() == '') {
                    if ($('#m_lov_penyesuaian').is(':visible')) {
                        $('#m_lov_penyesuaian').modal('toggle');
                    }

                    swal({
                        title: 'Inputkan No. Penyesuaian terlebih dahulu!',
                        icon: 'error'
                    }).then(function () {
                        $('#no_penyesuaian').select();
                    })
                }
                else {
                    $.ajax({
                        url: '{{url('/bo/transaksi/penyesuaian/input/doc_select')}}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nodoc: nodoc
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');

                            if (response != null) {
                                $('#no_referensi').val(response['trbo_nodoc']);
                                $('#tgl_referensi').val(formatDate(response['trbo_tgldoc']));
                            }

                            if ($('#m_lov_penyesuaian').is(':visible')) {
                                $('#m_lov_penyesuaian').modal('toggle');
                                $('#plu').select();
                            }
                        }
                    });
                }
            }
        }

        $('#qty').on('keypress', function (e) {
            if (e.which == 13) {
                hitung();

                $('#qtyk').select();
            }
        });

        $('#qty').on('change', function () {
            hitung();
        });

        function hitung() {
            qty = parseFloat($('#qty').val());
            qtyk = parseFloat($('#qtyk').val());
            harga = parseFloat(unconvertToRupiah($('#hrgsatuan').val()));
            frac = parseFloat($('#kemasan').val().split('/').pop());

            console.log(qty * frac + qtyk);

            subtotal = harga * (qty * frac + qtyk) / frac;

            $('#subtotal').val(convertToRupiah(subtotal));
        }

        function simpan() {
            if (jenisdoc == 'xxx') {
                swal({
                    title: 'Nomor Penyesuaian tidak sesuai!',
                    icon: 'error'
                }).then(function () {
                    $('#no_penyesuaian').select();
                });
            }
            else {
                swal({
                    title: 'Yakin ingin menyimpan data?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function (ok) {
                    if (ok) {
                        $.ajax({
                            url: '{{url('/bo/transaksi/penyesuaian/input/doc_save')}}',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                tipempp: $('#tipe_mpp').val(),
                                tipebarang: $('#tipe_barang').val(),
                                totalitem: $('#totalitem').val(),
                                prdcd: $('#plu').val(),
                                qty: $('#qty').val(),
                                qtyk: $('#qtyk').val(),
                                nodoc: $('#no_penyesuaian').val(),
                                tgldoc: $('#tgl_penyesuaian').val(),
                                hrgsatuan: unconvertToRupiah($('#hrgsatuan').val()),
                                avgcost: unconvertToRupiah($('#avgcost').val()),
                                subtotal: unconvertToRupiah($('#subtotal').val()),
                                noreff: $('#no_referensi').val(),
                                tglreff: $('#tgl_referensi').val(),
                                keterangan: $('#keterangan').val(),
                                jenisdoc: jenisdoc
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('toggle');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('toggle');

                                if (typeof response.message === 'undefined') {
                                    swal({
                                        title: response.title,
                                        icon: response.status
                                    })
                                }
                                else {
                                    swal({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.status
                                    })
                                }
                            }
                        });
                    }
                });
            }
        }

        function hapus() {
            swal({
                title: 'Yakin ingin menyimpan data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function (ok) {
                if (ok) {
                    $.ajax({
                        url: '{{url('/bo/transaksi/penyesuaian/input/doc_delete')}}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nodoc: $('#no_penyesuaian').val(),
                            prdcd: $('#plu').val()
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');

                            if (typeof response.message === 'undefined') {
                                swal({
                                    title: response.title,
                                    icon: response.status
                                })
                            }
                            else {
                                swal({
                                    title: response.title,
                                    text: response.message,
                                    icon: response.status
                                })
                            }
                        }
                    });
                }
            });
        }

    </script>

@endsection
