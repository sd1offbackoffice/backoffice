@extends('navbar')

@section('title','BTAS | PROSES PENITIPAN BARANG')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">Proses Penitipan Barang Atas Struk</legend>
                            <div class="card-body py-0">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label  text-right pl-0 pr-0">Tanggal</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="tgl">
                                    </div>
                                    <label for="prdcd" class="col-sm-2 col-form-label text-right pl-0 pr-0">Customer</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" id="cus_kode" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label  text-right pl-0 pr-0">Station</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="station">
                                    </div>
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-left" id="cus_nama" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label  text-right pl-0 pr-0">Kasir</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="kasir">
                                    </div>
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label  text-right pl-0 pr-0">Keterangan</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control text-left" id="keterangan" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label pl-0 pr-0">No. Transaksi</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="notrx">
                                    </div>
                                    <div class="col-sm"></div>
                                    <button class="col-sm-3 btn btn-primary" id="btn_proses" onclick="process()">PROSES TITIP BARANG</button>
                                    <div class="col-sm"></div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">Detail PLU per Struk</legend>
                            <div class="card-body pt-0 pb-0">
                                <div class="row form-group mb-0 ml-1 mr-3">
                                    <label for="prdcd" class="col-sm-1 text-center col-form-label pr-1 pl-0">No. Urut</label>
                                    <label for="prdcd" class="col-sm text-center pl-0 pr-0 col-form-label">PLU</label>
                                    <label for="prdcd" class="col-sm text-center pl-0 pr-0 col-form-label">Harga Satuan</label>
                                    <label for="prdcd" class="col-sm text-center pl-0 pr-0 col-form-label">Qty Struk</label>
                                    <label for="prdcd" class="col-sm text-center col-form-label pr-1">Qty Refund</label>
                                    <label for="prdcd" class="col-sm text-center col-form-label pl-0 pr-0">Qty yg Dititip</label>
                                    <label for="prdcd" class="col-sm text-center col-form-label pl-0 pr-0">Nilai Struk</label>
                                </div>
                                <div class="scrollable-field mb-2" id="detail">
                                    @for($i=0;$i<10;$i++)
                                        <div class="row form-group m-1 mb-2">
                                            <div class="col-sm-1 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-2 text-right col-form-label pl-0 pr-0">Deskripsi</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control text-left" id="deskripsi" disabled>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="unit" disabled>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_customer">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Nama Member</th>
                                        <th>Kode</th>
                                        <th>Station</th>
                                        <th>Kasir</th>
                                        <th>No. Transaksi</th>
                                        <th>Tgl Struk</th>
                                        <th>Tgl Penitipan</th>
                                        <th>No. SJAS</th>
                                        <th>Tgl SJAS</th>
                                        <th>Flag</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_autorisasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Autorisasi MGR</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label  text-right pl-0 pr-0">User</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control text-left text-uppercase" id="aut_user">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label  text-right pl-0 pr-0">Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control text-left text-uppercase" id="aut_pass">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-5"></div>
                            <button class="btn btn-primary col-sm-2" onclick="authUser()">OK</button>
                            <div class="col-sm-5"></div>
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
            overflow-y: hidden;
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

        .clicked, .row-detail:hover{
            background-color: grey !important;
            color: white;
        }

        .scrollable-field{
            max-height: 370px;
            overflow-y: scroll;
            overflow-x: hidden;
        }
    </style>

    <script>
        var data = [];
        var detail = [];

        $(document).ready(function(){
            $('#tgl').datepicker({
                "dateFormat" : "dd/mm/yy",
            });
            $('#tgl').datepicker('setDate', new Date());
        });

        $('#tgl').on('keypress',function(e){
            if(e.which == 13){
                $('#station').select();
            }
        });

        $('#station').on('keypress',function(e){
            if(e.which == 13){
                $('#kasir').select();
            }
        });

        $('#kasir').on('keypress',function(e){
            if(e.which == 13){
                $('#notrx').select();
            }
        });

        $('#notrx').on('keypress',function(e){
            if(e.which == 13){
                getData();
            }
        });

        function getData(){
            if(!$('#tgl').val() || !$('#station').val() || !$('#kasir').val() || !$('#notrx').val()){
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/get-data',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        tgl: $('#tgl').val(),
                        station: $('#station').val(),
                        kasir: $('#kasir').val(),
                        notrx: $('#notrx').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        $('#cus_kode').val(response.kode);
                        $('#cus_nama').val(response.nama);
                        $('#keterangan').val(response.status);
                        $('#btn_proses').prop('disabled',response.button);

                        data = response;
                        $('#detail').html('');
                        for(i=0;i<data.detail.length;i++){
                            fillDetail(data.detail[i],i);
                        }
                        for(i=data.detail.length;i<8;i++){
                            generateDetailDummy();
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {

                        });
                    }
                });
            }
        }

        function fillDetail(data, row){
            $('#detail').append(
                `<div id="row-${row}" class="row form-group m-1 mb-2" onmouseover="showDesc(${row})">
                    <div class="col-sm-1 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled value="${ data.trjd_seqno }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled value="${ data.trjd_prdcd }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-right" disabled value="${ convertToRupiah2(data.trjd_unitprice) }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-right" disabled value="${ data.trjd_quantity }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-right" disabled value="${ data.qtyrefund }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-right" disabled value="${ data.qtytitip }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-right" disabled value="${ convertToRupiah2(data.trjd_nominalamt) }">
                    </div>
                </div>`
            );
        }

        function generateDetailDummy(){
            $('#detail').append(
                `<div class="row form-group m-1 mb-2">
                    <div class="col-sm-1 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled>
                    </div>
                </div>`
            );
        }

        function showDesc(row){
            $('#deskripsi').val(data.detail[row].prd_deskripsipanjang);
            $('#unit').val(data.detail[row].unit);

            $('#detail div').css('border','none');

            $('#row-'+row).css('border','2px solid blue');

        }

        function process(){
            if(!$('#tgl').val() || !$('#station').val() || !$('#kasir').val() || !$('#notrx').val()){
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
            }
            else{
                $.ajax({
                    url: '{{ url()->current() }}/process',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        tgl: $('#tgl').val(),
                        station: $('#station').val(),
                        kasir: $('#kasir').val(),
                        notrx: $('#notrx').val(),
                        cus_kode: $('#cus_kode').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        swal({
                            title: 'Transaksi berhasil diproses!',
                            icon: 'success'
                        });

                        $('#btn_proses').prop('disabled',false);

                        $('#detail').html('');
                        for(i=0;i<8;i++){
                            generateDetailDummy();
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {
                            $('input').val('');

                            $('#tgl').datepicker('setDate', new Date());
                            $('#detail').html('');
                            for(i=0;i<8;i++){
                                generateDetailDummy();
                            }
                        });
                    }
                });
            }
        }
    </script>
@endsection
