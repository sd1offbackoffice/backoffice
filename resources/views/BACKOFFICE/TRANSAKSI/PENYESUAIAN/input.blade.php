@extends('navbar')
@section('content')
    {{--<head>--}}
    {{--<script src="{{asset('/js/bootstrap-select.min.js')}}"></script>--}}
    {{--</head>--}}


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">PENYESUAIAN - INPUT</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="no_penyesuaian" class="col-sm-2 col-form-label">No. Penyesuaian</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control" id="no_penyesuaian">
                                            <button id="btn-no-doc" type="button" class="btn btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_penyesuaian">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label for="tgl_penyesuaian" class="col-sm-2 col-form-label">Tgl. Penyesuaian</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="tgl_penyesuaian" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="no_referensi" class="col-sm-2 col-form-label">No. Referensi</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="no_referensi">
                                            <button id="btn-no-reff" type="button" class="btn btn-lov p-0" data-toggle="modal" data-target="#m_lov_penyesuaian">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        {{--<button type="button" class="btn p-0" data-toggle="modal" data-target="#m_kodesupplierHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
                                        <label for="tgl_referensi" class="col-sm-2 col-form-label">Tgl. Referensi</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="tgl_referensi" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="tipe_mpp" class="col-sm-2 col-form-label">Tipe MPP</label>
                                        <div class="col-sm-3">
                                            <select class="browser-default custom-select diisi" id="tipe_mpp">
                                                <option selected value="1">SELISIH SO</option>
                                                <option value="2">TERTUKAR JENIS</option>
                                                <option value="3">GANTI PLU</option>
                                            </select>
                                        </div>
                                        {{--<button type="button" class="btn p-0" data-toggle="modal" data-target="#m_kodesupplierHelp"><img src="{{asset('image/icon/help.png')}}" width="30px"></button>--}}
                                        <label for="tipe_barang" class="col-sm-2 col-form-label">Tipe Barang</label>
                                        <div class="col-sm-3">
                                            <select class="browser-default custom-select diisi" id="tipe_barang">
                                                <option selected value="01">BARANG BAIK</option>
                                                <option value="02">BARANG RETUR</option>
                                                <option value="03">BARANG RUSAK</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr>
                                    <fieldset class="card border-secondary">
                                        <div class="card-body shadow-lg cardForm">
                                            <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        <h5 class="text-center"><strong>TEKAN ALT + L UNTUK MELIHAT DAFTAR</strong></h5>
                                                        <hr color="black">
                                                        <div class="form-group row mb-0">
                                                            <label for="plu" class="col-sm-2 col-form-label">PLU</label>
                                                            <div class="col-sm-3 buttonInside">
                                                                <input maxlength="10" type="text" class="form-control" id="plu">
                                                                <button type="button" class="btn btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_plu">
                                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                                </button>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="deskripsi" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="kemasan" class="col-sm-2 col-form-label">Kemasan</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" id="kemasan" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="tag" class="col-sm-2 col-form-label">Tag</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="tag" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="bandrol" class="col-sm-2 col-form-label">Flag Bandrol</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="bandrol" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="bkp" class="col-sm-2 col-form-label">BKP</label>
                                                            <div class="col-sm-1">
                                                                <input type="text" class="form-control" id="bkp" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="lastcost" class="col-sm-2 col-form-label">Last Cost</label>
                                                            <label for="lastcost" class="col-sm-1 col-form-label"><strong>Rp.</strong></label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control text-right" id="lastcost" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="avgcost" class="col-sm-2 col-form-label">Average Cost</label>
                                                            <label for="avgcost" class="col-sm-1 col-form-label"><strong>Rp.</strong></label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control text-right" id="avgcost" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="persediaan" class="col-sm-2 col-form-label">Persediaan</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control text-right" id="persediaan" disabled>
                                                            </div>
                                                            <label for="persediaan2" class="col-sm-1 col-form-label text-left pl-0"><span id="pcs">PCS</span> +</label>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control text-right" id="persediaan2" disabled>
                                                            </div>
                                                            <label for="i_kodesupplier" class="col-sm-1 col-form-label text-left pl-0">PCS</label>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="hrgsatuan" class="col-sm-2 col-form-label">Hrg. Satuan</label>
                                                            <label for="hrgsatuan" class="col-sm-1 col-form-label"><strong>Rp.</strong></label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control text-right" id="hrgsatuan">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="qty" class="col-sm-2 col-form-label">Kuantum</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="qty">
                                                            </div>
                                                            <label for="qtyk" class="col-form-label text-left pl-0">PCS</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="qtyk">
                                                            </div>
                                                            <label for="subtotal" class="col-sm-2 col-form-label text-left pl-0 pr-0">PCS ------------> <strong> Rp.</strong></label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control text-right" id="subtotal" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" class="form-control" id="keterangan">
                                                            </div>
                                                        </div>
                                                        <hr color="black">
                                                        <div class="form-group row mb-0">
                                                            <label for="totalitem" class="col-sm-2 col-form-label">TOTAL ITEM</label>
                                                            <div class="col-sm-2">
                                                                <input type="text" class="form-control text-right" id="totalitem" disabled>
                                                            </div>
                                                            <label for="i_kodesupplier" class="col-form-label text-left pl-0" style="color: white !important;">PCS</label>
                                                            <div class="col-sm-2">

                                                            </div>
                                                            <label for="total" class="col-sm-2 col-form-label text-left pl-0 pr-0">TOTAL ---------> <strong> Rp.</strong></label>
                                                            <div class="col-sm-3 pl-0">
                                                                <input type="text" class="form-control text-right" id="total" disabled>
                                                            </div>
                                                        </div>
                                                        <hr color="black">
                                                        <div class="col-sm-5 mb-1 text-right">
                                                            <button id="btn-save" class="col-sm-3 btn btn-success" onclick="simpan()">REKAM</button>
                                                            <button id="btn-print" class="col-sm-3 btn btn-danger" onclick="hapus()">HAPUS</button>
                                                        </div>
                                                        <hr color="black">
                                                        <div class="text-left">
                                                            <strong>Tekan "CTRL + S" Untuk Menyimpan Dan Membuat Nomor Baru</strong>
                                                        </div>
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
    <div class="modal fade" id="m_lov_penyesuaian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov" class="form-control search_lov" type="text" placeholder="Inputkan No. Penyesuaian" aria-label="Search">
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

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="i_lov_plu" class="form-control search_lov" type="text" placeholder="Inputkan Deskripsi / PLU Produk" aria-label="Search">
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
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        input{
            text-transform: uppercase;
        }


    </style>

    <script>
        trlov = $('#table_lov_plu tbody').html();
        no = 'doc';
        jenisdoc = '';

        $('#tgl_penyesuaian').datepicker({
            "dateFormat" : "dd/mm/yy"
        });

        $('#no_penyesuaian').select();

        $('#btn-no-doc').on('click',function(){
            no = 'doc';
        });

        $('#btn-no-reff').on('click',function(){
            no = 'reff';
        });

        $('#tgl_penyesuaian').on('change',function(){
            if(!checkDate($(this).val())){
                swal({
                    title: 'Format tanggal salah!',
                    icon: 'error'
                }).then(function(){
                    $('#tgl_penyesuaian').val('');
                    $('#tgl_penyesuaian').select();
                })
            }
            else{
                $('#no_referensi').select();
            }
        });

        $('#m_lov_plu').on('shown.bs.modal',function(){
            $('#i_lov_plu').val('');
            $('#i_lov_plu').select();
        });

        $('#i_lov_plu').on('keypress',function(e){
            if(e.which == 13){
                if($(this).val() == ''){
                    $('#table_lov_plu .row_lov').remove();
                    $('#table_lov_plu').append(trlov);
                }
                else{
                    if($.isNumeric($(this).val())){
                        search = convertPlu($(this).val());
                    }
                    else{
                        search = $(this).val().toUpperCase();
                    }
                    $.ajax({
                        url: '{{url('/bo/transaksi/penyesuaian/input/lov_plu_search')}}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {plu: search, lokasi: $('#tipe_barang').val()},
                        beforeSend: function(){
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#table_lov_plu .row_lov').remove();
                            html = "";

                            for (i = 0; i < response.length; i++) {
                                html =  '<tr class="row_lov" onclick=lov_select("' + response[i].prd_prdcd + '")>' +
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

        $('#plu').on('keypress',function(e){
            if(e.which == 13){
                plu_select($(this).val());
            }
        });

        function plu_select(plu){
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
                    totalitem: nvl($('#totalitem').val(),'0'),
                    nodoc: $('#no_penyesuaian').val()
                },
                beforeSend: function(){
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

        $('#no_penyesuaian').on('keypress',function(e){
            if(e.which == 13){
                doc_select($(this).val());
            }
        });

        function doc_select(nodoc){
            if(no == 'doc'){
                if(nodoc == ''){
                    swal({
                        title: 'Apakah Ingin Membuat Nomor Baru?',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    }).then(function(ok){
                        if(ok){
                            $('#tgl_penyesuaian').attr('disabled',false);

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
                else{
                    $.ajax({
                        url: '{{url('/bo/transaksi/penyesuaian/input/doc_select')}}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nodoc: nodoc
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');

                            if(response != null){
                                jenisdoc = 'lama';

                                $('#tgl_penyesuaian').attr('disabled',true);

                                $('#no_penyesuaian').val(response['trbo_nodoc']);
                                $('#tgl_penyesuaian').val(formatDate(response['trbo_tgldoc']));
                                $('#no_referensi').val(response['trbo_noreff']);
                                $('#tgl_referensi').val(response['trbo_tglreff']);
                                $('#tipe_mpp').val(response['trbo_flagdisc1']);

                                if(response['trbo_flagdisc2'].length == 1)
                                    tipebarang = '0' + response['trbo_flagdisc2'];
                                else tipebarang = response['trbo_flagdisc2'];
                                $('#tipe_barang').val('0'+response['trbo_flagdisc2']);
                                $('#total').val(convertToRupiah(response['total']));
                                $('#totalitem').val(response['totalitem']);
                            }
                            else{
                                jenisdoc = 'xxx';

                                swal({
                                    title: 'Nomor Penyesuaian tidak ditemukan!',
                                    icon: 'error',
                                }).then(function(){
                                    $('input').val('');
                                    $('#no_penyesuaian').val(nodoc);
                                    $('#no_penyesuaian').select();
                                });
                            }

                            if($('#m_lov_penyesuaian').is(':visible')){
                                $('#m_lov_penyesuaian').modal('toggle');
                                $('#plu').select();
                            }
                        }
                    });
                }
            }
            else if(no == 'reff'){
                if($('#no_penyesuaian').val() == '' || $('#tgl_penyesuaian').val() == ''){
                    if($('#m_lov_penyesuaian').is(':visible')){
                        $('#m_lov_penyesuaian').modal('toggle');
                    }

                    swal({
                        title: 'Inputkan No. Penyesuaian terlebih dahulu!',
                        icon: 'error'
                    }).then(function(){
                        $('#no_penyesuaian').select();
                    })
                }
                else{
                    $.ajax({
                        url: '{{url('/bo/transaksi/penyesuaian/input/doc_select')}}',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nodoc: nodoc
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('toggle');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('toggle');

                            if(response != null){
                                $('#no_referensi').val(response['trbo_nodoc']);
                                $('#tgl_referensi').val(formatDate(response['trbo_tgldoc']));
                            }

                            if($('#m_lov_penyesuaian').is(':visible')){
                                $('#m_lov_penyesuaian').modal('toggle');
                                $('#plu').select();
                            }
                        }
                    });
                }
            }
        }

        $('#qty').on('keypress',function(e){
            if(e.which == 13){
                hitung();

                $('#qtyk').select();
            }
        });

        $('#qty').on('change',function(){
            hitung();
        });

        function hitung(){
            qty = parseFloat($('#qty').val());
            qtyk = parseFloat($('#qtyk').val());
            harga = parseFloat(unconvertToRupiah($('#hrgsatuan').val()));
            frac = parseFloat($('#kemasan').val().split('/').pop());

            console.log(qty * frac + qtyk);

            subtotal = harga * (qty * frac + qtyk) / frac;

            $('#subtotal').val(convertToRupiah(subtotal));
        }

        function simpan(){
            if(jenisdoc == 'xxx'){
                swal({
                    title: 'Nomor Penyesuaian tidak sesuai!',
                    icon: 'error'
                }).then(function(){
                    $('#no_penyesuaian').select();
                });
            }
            else{
                swal({
                    title: 'Yakin ingin menyimpan data?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function(ok){
                    if(ok){
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

                                if(typeof response.message === 'undefined'){
                                    swal({
                                        title: response.title,
                                        icon: response.status
                                    })
                                }
                                else{
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

        function hapus(){
            swal({
                title: 'Yakin ingin menyimpan data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(ok){
                if(ok){
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

                            if(typeof response.message === 'undefined'){
                                swal({
                                    title: response.title,
                                    icon: response.status
                                })
                            }
                            else{
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
