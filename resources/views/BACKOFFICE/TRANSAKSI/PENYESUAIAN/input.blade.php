@extends('navbar')

@section('title','PENYESUAIAN | INPUT')

@section('content')
    {{--<head>--}}
    {{--<script src="{{asset('/js/bootstrap-select.min.js')}}"></script>--}}
    {{--</head>--}}


    <div class="container mt-0">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
{{--                    <legend  class="w-auto ml-5">PENYESUAIAN - INPUT</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <div class="row text-right">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="no_penyesuaian" class="col-sm-2 col-form-label">No. Penyesuaian</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input maxlength="10" type="text" class="form-control" id="no_penyesuaian">
                                            <button id="btn-no-doc" type="button" class="btn btn-primary btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_penyesuaian">
                                                <i class="fas fa-question"></i>
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
                                            <button id="btn-no-reff" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_penyesuaian">
                                                <i class="fas fa-question"></i>
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
                                    <fieldset class="card border-secondary mt-3">
                                        <div class="card-body shadow-lg cardForm">
                                            <div class="row text-right">
                                                    <div class="col-sm-12">
                                                        {{--<h5 class="text-center"><strong>TEKAN ALT + L UNTUK MELIHAT DAFTAR</strong></h5>--}}
                                                        {{--<hr color="black">--}}
                                                        <div class="form-group row mb-0">
                                                            <label for="plu" class="col-sm-2 col-form-label">PLU</label>
                                                            <div class="col-sm-3 buttonInside">
                                                                <input maxlength="10" type="text" class="form-control" id="plu">
                                                                <button id="btn_lov" type="button" class="btn btn-primary btn-lov p-0 divisi1" data-toggle="modal" data-target="#m_lov_plu">
                                                                    <i class="fas fa-question"></i>
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
                                                                <input type="text" class="form-control text-right" id="hrgsatuan" disabled>
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
                                                        <div class="form-group row">
                                                            <button id="btn-save" class="col-sm-3 btn btn-primary ml-3" onclick="lihatDaftar()">LIHAT DAFTAR</button>
                                                            <div class="col-sm"></div>
                                                            <button id="btn-save" class="col-sm-3 btn btn-success ml-3" onclick="simpan()">REKAM</button>
                                                            <button id="btn-print" class="col-sm-3 btn btn-danger ml-2" onclick="hapus()">HAPUS</button>
                                                        </div>
                                                        <div class="col-sm-5 mb-1 text-right">

                                                        </div>
                                                        {{--<hr color="black">--}}
                                                        {{--<div class="text-left">--}}
                                                            {{--<strong>Tekan "CTRL + S" Untuk Menyimpan Dan Membuat Nomor Baru</strong>--}}
                                                        {{--</div>--}}
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
{{--                <div class="modal-header">--}}
{{--                    <div class="form-row col-sm">--}}
{{--                        <input id="search_lov" class="form-control search_lov" type="text" placeholder="Inputkan No. Penyesuaian" aria-label="Search">--}}
{{--                        <div class="invalid-feedback">--}}
{{--                            Inputkan minimal 3 karakter--}}
{{--                        </div>--}}
{{--                </div>--}}
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No. Penyesuaian</th>
                                        <th>Tanggal</th>
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
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV PLU</h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_lov_plu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
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

    <div class="modal fade" id="m_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-striped table-bordered" id="table_list">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th class="text-center">PLU</th>
                                        <th class="text-center">DESKRIPSI</th>
                                        <th class="text-center">KEMASAN</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">QTYK</th>
                                        <th class="text-center">H.P.P</th>
                                        <th class="text-center">GROSS</th>
                                    </tr>
                                    </thead>
                                    <tbody>

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

        .dataTables_scrollBody{
            overflow-x: hidden !important;
        }
    </style>

    <script>
        trlov = $('#table_lov_plu tbody').html();
        no = 'doc';
        jenisdoc = '';
        var list;
        var dataPLU;
        var listPLU = [];

        $(document).ready(function(){
            $('#table_lov_plu').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                },
                "order": []
            });

            $('#table_lov_plu_filter input').off().on('keypress', function (e){
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getModalData(val);
                }
            });

            $('#table_lov').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                },
                "order": []
            });
        });

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
            $('#table_lov_plu_filter input').val('');
            $('#table_lov_plu_filter input').select();
        });

        function getModalData(value){
            if ($.fn.DataTable.isDataTable('#table_lov_plu')) {
                $('#table_lov_plu').DataTable().destroy();
                $("#table_lov_plu tbody [role='row']").remove();
            }

            if($.isNumeric(value)){
                search = convertPlu(value);
            }
            else{
                search = value.toUpperCase();
            }

            $('#table_lov_plu').DataTable({
                "ajax": {
                    'url' : '{{url('/bo/transaksi/penyesuaian/input/lov_plu_search')}}',
                    'headers': {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "data" : {
                        'plu' : search,
                        'lokasi': $('#tipe_barang').val()
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow prd_prdcd');
                },
                "initComplete" : function(){
                    $('#table_lov_plu_filter input').val(value);

                    $(document).on('click', '.prd_prdcd', function (e) {
                        plu_select($(this).find('td:eq(1)').html());
                        $('#m_lov_plu').modal('hide');
                    });
                }
            });

            $('#table_lov_plu_filter input').val(value);

            $('#table_lov_plu_filter input').off().on('keypress', function (e){
                if (e.which === 13) {
                    let val = $(this).val().toUpperCase();

                    getModalData(val);
                }
            });
        }

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
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    dataPLU = response;

                    $('#modal-loader').modal('hide');
                    $('#m_lov_plu').modal('hide');
                    if(typeof response.title !== 'undefined'){
                        swal({
                            title: response.title,
                            icon: 'error'
                        });
                    }
                    else{
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
                        dangerMode: false,
                    }).then(function(ok){
                        if(ok){
                            $('#tipe_mpp').prop('disabled',false);
                            $('#tgl_penyesuaian').attr('disabled',false);

                            $.ajax({
                                url: '{{url('/bo/transaksi/penyesuaian/input/doc_new')}}',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                beforeSend: function () {
                                    $('#modal-loader').modal('show');
                                },
                                success: function (response) {
                                    jenisdoc = 'baru';

                                    $('#modal-loader').modal('hide');

                                    $('#no_penyesuaian').val(response);
                                    $('#tgl_penyesuaian').select();

                                    $('#totalitem').val(0);
                                }
                            });
                        }
                    });
                }
                else{
                    $.ajax({
                        url: '{{url('/bo/transaksi/penyesuaian/input/doc_select')}}',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nodoc: nodoc
                        },
                        beforeSend: function(){
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            listPLU = [];
                            listPLU = response.list;
                            generateListData();

                            response = response.doc;

                            if(response != null){
                                $('input').val('');

                                jenisdoc = 'lama';

                                $('#tgl_penyesuaian').attr('disabled',true);
                                $('#tipe_mpp').prop('disabled',true);

                                console.log(response['trbo_nodoc']);
                                $('#no_penyesuaian').val(response['trbo_nodoc']);
                                $('#tgl_penyesuaian').val(formatDate(response['trbo_tgldoc']));
                                $('#no_referensi').val(response['trbo_noreff']);
                                $('#tgl_referensi').val(response['trbo_tglreff']);
                                $('#tipe_mpp').val(response['trbo_flagdisc1']);

                                if(response['trbo_flagdisc2'] != null){
                                    if(response['trbo_flagdisc2'].length == 1){
                                        tipebarang = '0' + response['trbo_flagdisc2'];
                                    }
                                    else tipebarang = response['trbo_flagdisc2'];
                                }
                                $('#tipe_barang').val(response['trbo_flagdisc2']);
                                $('#total').val(convertToRupiah(response['total']));
                                $('#totalitem').val(listPLU.length);
                                generateListData();
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
                                $('#m_lov_penyesuaian').modal('hide');
                                $('#plu').select();
                            }
                        }
                    });
                }
            }
            else if(no == 'reff'){
                if($('#no_penyesuaian').val() == '' || $('#tgl_penyesuaian').val() == ''){
                    if($('#m_lov_penyesuaian').is(':visible')){
                        $('#m_lov_penyesuaian').modal('hide');
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
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            if(response != null){
                                $('#no_referensi').val(response['trbo_nodoc']);
                                $('#tgl_referensi').val(formatDate(response['trbo_tgldoc']));
                            }

                            if($('#m_lov_penyesuaian').is(':visible')){
                                $('#m_lov_penyesuaian').modal('hide');
                                $('#plu').select();
                            }
                        }
                    });
                }
            }
        }

        $('#qty').on('keypress',function(e){
            if(e.which == 13){
                hitungQTY();

                $('#qtyk').select();
            }
        });

        $('#qty').on('change',function(){
            hitungQTY();
        });

        $('#qtyk').on('keypress',function(e){
            if(e.which == 13){
                hitungQTYK();

                $('#keterangan').select();
            }
        });

        $('#qtyk').on('change',function(){
            hitungQTYK();
        });

        function hitungQTY(){
            qty = parseFloat($('#qty').val());
            qtyk = parseFloat($('#qtyk').val());
            harga = parseFloat(unconvertToRupiah($('#hrgsatuan').val()));
            frac = parseFloat($('#kemasan').val().split('/').pop());

            if(dataPLU.persediaan + qty < 0){
                swal({
                    title: 'Persediaan Negatif!',
                    icon: 'warning'
                }).then(() => {
                    $('#qty').val('').select();
                });
            }
            else{
                if($('#tipe_mpp').val() == '1'){
                    if(dataPLU.hrgsatuan > 0){
                        subtotal = (qty * frac + qtyk) * (dataPLU.hrgsatuan / frac);
                    }
                    validateMPP();
                }
                else{
                    if(qtyk != null && $('#tipe_mpp').val() != '1'){
                        if(qtyk > 0 && $('#totalitem').val() == 0){
                            swal({
                                title: 'Quantity pertama harus diisi minus!',
                                icon: 'warning'
                            }).then(() => {
                                $('#qtyk').val(parseInt($('#qtyk').val()) * -1).select();
                                $('#qty').val(parseInt($('#qty').val()) * -1).select();

                                qty = parseFloat($('#qty').val());
                                qtyk = parseFloat($('#qtyk').val());

                                subtotal = (qty * frac + qtyk) * (dataPLU.hrgsatuan / frac);

                                $('#subtotal').val(subtotal);
                            });
                        }

                        if(dataPLU.hrgsatuan > 0){
                            subtotal = (qty * frac + qtyk) * (dataPLU.hrgsatuan / frac);
                        }
                    }
                    else if(qty != null){
                        if(dataPLU.hrgsatuan > 0){
                            subtotal = (qty * frac + qtyk) * (dataPLU.hrgsatuan / frac);
                        }
                        validateMPP();
                    }
                }

                $('#subtotal').val(convertToRupiah(subtotal));
            }
        }

        function hitungQTYK(){
            qty = parseFloat($('#qty').val());
            qtyk = parseFloat($('#qtyk').val());
            harga = parseFloat(unconvertToRupiah($('#hrgsatuan').val()));
            frac = parseFloat($('#kemasan').val().split('/').pop());

            lqtyk = 0;

            v_lastrec = 0;

            for(i=0;i<listPLU.length;i++){
                if(listPLU[i].trbo_prdcd == $('#plu').val()){
                    v_lastrec = i;
                    break;
                }
            }

            if(v_lastrec == 0 && $('#tipe_mpp').val() != '1'){
                if(qty > 0){
                    $.ajax({
                        url: '{{ url()->current() }}/hitung-qtyk',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nodoc: $('#no_penyesuaian').val(),
                        },
                        beforeSend: function () {

                        },
                        success: function (response) {
                            jum = response.jum;

                            if(jum == 0){
                                swal({
                                    title: 'QTY item pertama harus diisi minus!',
                                    icon: 'error'
                                }).then(() => {
                                    $('#qtyk').val(parseInt($('#qtyk').val()) * -1).select();
                                    $('#qty').val(parseInt($('#qty').val()) * -1).select();

                                    qty = parseFloat($('#qty').val());
                                    qtyk = parseFloat($('#qtyk').val());

                                    subtotal = (qty * frac + qtyk) * (dataPLU.hrgsatuan / frac);

                                    $('#subtotal').val(subtotal);

                                    lqtyk = 1;
                                });
                            }
                        }
                    });
                }
                else if(qtyk > 0){
                    $.ajax({
                        url: '{{ url()->current() }}/hitung-qtyk',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nodoc: $('#no_penyesuaian').val(),
                        },
                        beforeSend: function () {

                        },
                        success: function (response) {
                            jum = response.jum;

                            if(jum == 0){
                                $('#qtyk').val(parseInt($('#qtyk').val()) * -1).select();
                                $('#qty').val(parseInt($('#qty').val()) * -1).select();

                                qty = parseFloat($('#qty').val());
                                qtyk = parseFloat($('#qtyk').val());

                                subtotal = (qty * frac + qtyk) * (dataPLU.hrgsatuan / frac);

                                $('#subtotal').val(subtotal);

                                swal({
                                    title: 'QTY item pertama harus diisi minus!',
                                    icon: 'error'
                                }).then(() => {

                                    lqtyk = 1;
                                });
                            }
                        }
                    });
                }

                if(lqtyk == 1){
                    $('#qty').select();
                }
                else $('#subtotal').select();

                if(qtyk == 0 && qty == 0){
                    swal({
                        title: 'Quantity harus diisi!',
                        icon: 'warning'
                    });
                }
            }

            if(qtyk != null && v_lastrec > 1 && $('#tipe_mpp').val() != '1'){
                validateMPP();
            }

            if(dataPLU.hrgsatuan > 0){
                if($('#tipe_mpp').val() == '1'){
                    qty = qty + qtyk / frac;
                }
                else{
                    $.ajax({
                        url: '{{ url()->current() }}/hitung-qtyk',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nodoc: $('#no_penyesuaian').val(),
                        },
                        beforeSend: function () {

                        },
                        success: function (response) {
                            jum = response.jum;

                            if(jum < 1){
                                if(qty > 0){
                                    qty = ((qty * -1) + qtyk) / frac;
                                }
                                else qty = (qty + qtyk) / frac;
                            }
                            else qty = (qty + qtyk) / frac;
                        }
                    });
                }

                qtyk = qtyk % frac;
                subtotal = qty * dataPLU.hrgsatuan;

                console.log('qty : ' + qty);
                console.log('qtyk : ' + qtyk);
                console.log('harga : ' + harga);
                console.log('frac : ' + frac);

                $('#qty').val(parseInt(qty));
                $('#qtyk').val(qtyk);
                $('#subtotal').val(subtotal);
                console.log('x');
            }
        }

        function validateMPP(){
            qty = parseFloat($('#qty').val());
            qtyk = parseFloat($('#qtyk').val());
            harga = parseFloat(unconvertToRupiah($('#hrgsatuan').val()));
            frac = parseFloat($('#kemasan').val().split('/').pop());

            $.ajax({
                url: '{{ url()->current() }}/validate-mpp',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    nodoc: $('#no_penyesuaian').val(),
                },
                beforeSend: function () {

                },
                success: function (response) {
                    jum = response.jum;
                    hpp = response.hpp;

                    if($('#tipe_mpp').val() == '2' || $('#tipe_mpp').val() == '3'){
                        if(jum == 0){
                            if(qty >= 0 && $('#totalitem').val() > 0){
                                swal({
                                    title: 'QTY PLU Pertama harus diisi minus!',
                                    icon: 'error'
                                }).then(() => {
                                    $('#qtyk').val(parseInt($('#qtyk').val()) * -1).select();
                                    $('#qty').val(parseInt($('#qty').val()) * -1).select();

                                    qty = parseFloat($('#qty').val());
                                    qtyk = parseFloat($('#qtyk').val());

                                    subtotal = (qty * frac + qtyk) * (dataPLU.hrgsatuan / frac);

                                    $('#subtotal').val(subtotal);

                                    $('#qty').select();
                                });
                            }
                            else if(qtyk >= 0 && $('#totalitem').val() > 0){
                                swal({
                                    title: 'QTYK PLU Pertama harus diisi minus!',
                                    icon: 'error'
                                }).then(() => {
                                    $('#qtyk').val(parseInt($('#qtyk').val()) * -1).select();
                                    $('#qty').val(parseInt($('#qty').val()) * -1).select();

                                    qty = parseFloat($('#qty').val());
                                    qtyk = parseFloat($('#qtyk').val());

                                    subtotal = (qty * frac + qtyk) * (dataPLU.hrgsatuan / frac);

                                    $('#subtotal').val(subtotal);

                                    $('#qtyk').select();
                                });
                            }
                        }
                        else{
                            if(dataPLU.hrgsatuan != hpp){
                                swal({
                                    title: 'Harga satuan PLU kedua harus sama dengan PLU pertama!',
                                    icon: 'error'
                                });
                            }
                        }
                    }
                }
            });
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
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                if(typeof response.message === 'undefined'){
                                    swal({
                                        title: response.title,
                                        icon: response.status
                                    });

                                    doc_select($('#no_penyesuaian').val());
                                }
                                else{
                                    swal({
                                        title: response.title,
                                        text: response.message,
                                        icon: response.status
                                    });
                                }
                            }
                        });
                    }
                });
            }
        }

        function hapus(){
            swal({
                title: 'Yakin ingin menghapus data?',
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
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            doc_select($('#no_penyesuaian').val());

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
                                });
                            }
                        }
                    });
                }
            });
        }

        function lihatDaftar(){
            generateListData();
            $('#m_list').modal('show');
        }

        $('#m_list').on('shown.bs.modal',function(){
            if (!$.fn.DataTable.isDataTable('#table_list')) {
                $('#table_list').dataTable({
                    ordering: false,
                    searching: false,
                    lengthChange: false,
                    paging: false,
                    scrollY: "350px"
                });
            }

            generateListData();
        });

        function generateListData(){
            if ($.fn.DataTable.isDataTable('#table_list')) {
                $('#table_list').DataTable().destroy();
                $("#table_list tbody tr").remove();
            }

            for(i=0;i<listPLU.length;i++){
                $('#table_list tbody').append(`
                    <tr>
                        <td>${ listPLU[i].trbo_prdcd }</td>
                        <td>${ listPLU[i].prd_deskripsipendek }</td>
                        <td>${ listPLU[i].kemasan }</td>
                        <td class="text-right">${ convertToRupiah2(listPLU[i].qty) }</td>
                        <td class="text-right">${ convertToRupiah2(listPLU[i].qtyk) }</td>
                        <td class="text-right">${ convertToRupiah2(listPLU[i].trbo_hrgsatuan) }</td>
                        <td class="text-right">${ convertToRupiah2(listPLU[i].trbo_gross) }</td>
                    </tr>
                `);
            }
        }

    </script>

@endsection
