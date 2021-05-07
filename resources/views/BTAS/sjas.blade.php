@extends('navbar')

@section('title','BTAS | SURAT JALAN ATAS STRUK')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <div class="card-body pt-0">
                        <fieldset class="card border-secondary mt-0">
                            <legend  class="w-auto ml-3">Proses Surat Jalan Atas Struk</legend>
                            <div class="card-body py-0">
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 col-form-label text-right pl-0 pr-0">Customer</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input type="text" class="form-control text-left" id="cus_kode" disabled>
                                        <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovCustomer()">
                                            <i class="fas fa-question"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control text-left" id="cus_nama" disabled>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 text-right col-form-label  text-right pl-0 pr-0">STRUK</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" id="tglstruk" disabled>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <label for="prdcd" class="col-sm-2 text-left col-form-label pl-0 pr-0">[Tgl Struk]</label>
                                    <div class="col-sm-3"></div>
                                    <label for="prdcd" class="col-sm-2 text-center col-form-label pl-0 pr-0">[TAHAPAN]</label>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 text-right col-form-label  text-right pl-0"></label>
                                    <div class="col-sm-1 pr-0">
                                        <input type="text" class="form-control text-left" id="station" disabled>
                                    </div>
                                    <div class="col-sm-1 pr-0">
                                        <input type="text" class="form-control text-left" id="kasir" disabled>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-left" id="transaksi" disabled>
                                    </div>
                                    <label for="prdcd" class="col-sm-3 text-left col-form-label pl-0 pr-0">[Station - Kasir - Transaksi]</label>
                                    <div class="col-sm"></div>
                                    <button class="col-sm-1 btn btn-primary mr-1" onclick="prev()"><<</button>
                                    <button class="col-sm-1 btn btn-primary ml-1" onclick="next()">>></button>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 text-right col-form-label pl-0 pr-0">Surat Jalan</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" id="nosjas" disabled>
                                    </div>
                                    <label for="prdcd" class="col-sm-1 pr-0 text-right col-form-label">Tahapan</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-center" id="tahapan" disabled>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control text-center" id="status" disabled>
                                    </div>
                                    <div class="col-sm"></div>
                                    <label for="prdcd" class="col-sm-2 text-center col-form-label pl-0 pr-0">[PROSES & CETAK]</label>
                                </div>
                                <div class="row form-group">
                                    <label for="prdcd" class="col-sm-1 text-right col-form-label pl-0 pr-0"></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-left" id="tglsjas" disabled>
                                    </div>
                                    <label for="prdcd" class="col-sm-1 pl-0 text-right col-form-label"></label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-center" id="tgltitip" disabled>
                                    </div>
                                    <div class="col-sm"></div>
                                    <button class="col-sm-2 btn btn-primary" onclick="print()">SJAS OK</button>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-0" id="data-field">
                            <legend  class="w-auto ml-3">INFO</legend>
                            <div class="card-body pt-0 pb-0">
                                <div class="row form-group mb-0 ml-1 mr-3">
                                    <label for="prdcd" class="col-sm-1 text-center col-form-label pr-1 pl-0">No. Urut</label>
                                    <label for="prdcd" class="col-sm-2 text-center pl-0 pr-0 col-form-label">PLU</label>
                                    <label for="prdcd" class="col-sm text-center pl-0 pr-0 col-form-label">Qty Struk</label>
                                    <label for="prdcd" class="col-sm text-center col-form-label pr-1">Qty Refund</label>
                                    <label for="prdcd" class="col-sm text-center col-form-label pl-0 pr-0">Qty Titipan</label>
                                    <label for="prdcd" class="col-sm text-center col-form-label pl-0 pr-0">Qty Tahapan</label>
                                    <label for="prdcd" class="col-sm text-center col-form-label pl-0 pr-0">Qty Sisa</label>
                                </div>
                                <div class="scrollable-field mb-2" id="detail">
                                    @for($i=0;$i<10;$i++)
                                        <div class="row form-group m-1 mb-2">
                                            <div class="col-sm-1 pr-1 pl-1">
                                                <input type="text" class="form-control text-center" disabled>
                                            </div>
                                            <div class="col-sm-2 pr-1 pl-1">
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
    <div class="modal fade" id="m_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label  text-right pl-0">No Urut</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="add_nourut" disabled>
                            </div>
                            <div class="col-sm-1" id="nourut_loading">
                                <h4><i class="text-primary fas fa-spinner fa-spin"></i></h4>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 col-form-label text-right">Kode Rak</label>
                            <div class="col-sm-3 buttonInside">
                                <input type="text" class="form-control text-left" id="add_koderak">
                                <button id="btn_departement" type="button" class="btn btn-primary btn-lov p-0" onclick="showLovRak()">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row form-group" id="add_field_subrak">
                            <label class="col-sm-3 col-form-label text-right">Kode Sub Rak</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-left" id="add_subrak">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="btn btn-danger col-sm-2" onclick="$('#m_add').modal('hide')">BATAL</button>
                            <div class="col-sm-1"></div>
                            <button class="btn btn-success col-sm-2" onclick="addPlano()">TAMBAH</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="m_koderak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_koderak">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode Rak</th>
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
    <div class="modal fade" id="m_subrak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_subrak">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Kode Rak</th>
                                        <th>Sub Rak</th>
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
        var currRow = 0;
        var sjasok = 0;

        $(document).ready(function(){

        });

        function showLovCustomer(){
            $('#m_customer').modal('show');

            if(!$.fn.DataTable.isDataTable('#table_customer')){
                getLovCustomer();
            }
        }

        function getLovCustomer(){
            $('#table_customer').DataTable({
                "ajax": '{{ url()->current().'/get-lov-customer' }}',
                "columns": [
                    {data: 'cus_namamember'},
                    {data: 'sjh_kodecustomer'},
                    {data: 'stat'},
                    {data: 'kasir'},
                    {data: 'no'},
                    {data: 'sjh_tglstruk'},
                    {data: 'sjh_tglpenitipan'},
                    {data: 'sjh_nosjas'},
                    {data: 'sjh_tglsjas'},
                    {data: 'sjh_flagselesai'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-customer').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $(document).on('click', '.row-customer', function (e) {
                        $('#cus_kode').val($(this).find('td:eq(1)').html());
                        $('#cus_nama').val($(this).find('td:eq(0)').html());
                        $('#tglstruk').val($(this).find('td:eq(5)').html());
                        $('#station').val($(this).find('td:eq(2)').html());
                        $('#kasir').val($(this).find('td:eq(3)').html());
                        $('#transaksi').val($(this).find('td:eq(4)').html());
                        $('#nosjas').val($(this).find('td:eq(7)').html());
                        $('#tglsjas').val($(this).find('td:eq(8)').html());
                        $('#tgltitip').val($(this).find('td:eq(6)').html());

                        $('#m_customer').modal('hide');

                        getData();
                    });
                }
            });
        }

        function getData(){
            sjasok = 0;

            $.ajax({
                url: '{{ url()->current() }}/get-data',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    cus_kode: $('#cus_kode').val(),
                    station: $('#station').val(),
                    kasir: $('#kasir').val(),
                    nostruk: $('#transaksi').val(),
                    tglstruk: $('#tglstruk').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    data = response.data;
                    detail = response.detail;

                    $('#cus_nama').val(data.cus_nama);
                    $('#tglstruk').val(data.tglstruk);
                    $('#station').val(data.station);
                    $('#kasir').val(data.kasir);
                    $('#transaksi').val(data.no);
                    $('#nosjas').val(data.nosj);
                    $('#tglsjas').val(data.tglsj);
                    $('#tahapan').val(data.tahap);
                    $('#status').val(data.status);
                    $('#tgltitip').val(data.tgltitip);

                    $('#detail').html('');
                    for(i=0;i<detail.length;i++){
                        fillDetail(detail[i],i);
                    }
                    for(i=detail.length;i<8;i++){
                        generateDetailDummy();
                    }
                    $('#qtyambil-0').select();
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

        function fillDetail(data, row){
            $('#detail').append(
                `<div class="row form-group m-1 mb-2">
                    <div class="col-sm-1 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled value="${ data.trjd_seqno }">
                    </div>
                    <div class="col-sm-2 pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled value="${ data.trjd_prdcd }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled value="${ data.trjd_quantity }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled value="${ data.qtyrefund }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" disabled value="${ data.qtytitip }">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" id="qtyambil-${row}" value="${ data.qtyambil }" onfocus="showInfo(${row})" onkeypress="editQty(event,${row})">
                    </div>
                    <div class="col-sm pr-1 pl-1">
                        <input type="text" class="form-control text-center" id="qtysisa-${row}" disabled value="${ data.qtysisa }">
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
                    <div class="col-sm-2 pr-1 pl-1">
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

        function prev(){
            if($('#tahapan').val() == '1'){
                swal({
                    title: 'Sudah pada tahapan awal!',
                    icon: 'warning'
                });
            }
            else{
                $('#tahapan').val(parseInt($('#tahapan').val()) - 1);
            }
        }

        function next(){
            if(data.flagselesai == 'Y'){
                if(parseInt($('#tahapan').val()) + 1 > data.tahap){
                    swal({
                        title: 'Sudah di akhir data!',
                        icon: 'warning'
                    });
                }
                else{
                    $('#tahapan').val(parseInt($('#tahapan').val()) + 1);
                }
            }
            else{
                if(parseInt($('#tahapan').val()) + 1 > data.tahap){
                    swal({
                        title: 'Tahapan ' + $('#tahapan').val() + ' sudah terakhir!',
                        icon: 'warning'
                    });
                }
                else{
                    $('#tahapan').val(parseInt($('#tahapan').val()) + 1);

                    if($('#tahapan').val() == parseInt(data.tahap) + 1){

                    }
                }
            }
        }

        function showInfo(row){
            $('#deskripsi').val(detail[row].prd_deskripsipanjang);
            $('#unit').val(detail[row].unit);
        }

        function editQty(e, row){
            if(e.which == 13){
                currRow = row;

                if($('#qtyambil-'+row).val() > $('#qtysisa-'+row).val()){
                    swal({
                        title: 'Qty tidak boleh lebih besar dari sisa!',
                        icon: 'warning'
                    }).then(() => {
                        $('#qtyambil-'+row).val(0).select();
                    });
                }
                else{
                    $('#qtysisa-'+row).val(parseInt(detail[row].qtysisa) - parseInt($('#qtyambil-'+row).val()));

                    if(data.flagoto == '1'){
                        swal({
                            title: 'Item sudah dititipkan lebih dari 2 hari, harus dibuatkan SJ semua!',
                            icon: 'warning',
                            buttons: {
                                ok : 'ALL QTY',
                                aut : 'Autorisasi MGR'
                            }
                        }).then((ok) => {
                            if(ok == 'aut'){
                                $('#aut_user').val('');
                                $('#aut_pass').val('');
                                $('#m_autorisasi').modal('show');
                            }
                            else{

                            }
                        });
                    }
                    else{
                        $('#qtysisa-'+row).val(detail[row].qtysisa);
                        $('#qtyambil-'+row).val(0).select();
                    }
                }
            }
        }

        $('#m_autorisasi').on('shown.bs.modal', () => {$('#aut_user').select()});

        $('#aut_user').on('keypress',(e) => e.which == 13 ? $('#aut_pass').select() : null);

        $('#aut_pass').on('keypress',(e) => e.which == 13 ? authUser() : null);

        function authUser(){
            $.ajax({
                url: '{{ url()->current() }}/auth-user',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    username: $('#aut_user').val(),
                    password: $('#aut_pass').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if(response == 'false'){
                        if(response == 'false'){
                            alertError('Autorisasi untuk masa perpanjangan ditolak!','');
                        }
                    }
                    else{
                        if(sjasok == '1'){

                        }
                        else{
                            $('#qtysisa-'+currRow).val(detail[currRow].qtysisa - $('#qtyambil-'+currRow).val());
                        }

                        $('#m_autorisasi').modal('hide');
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

        function print(){
            $.ajax({
                url: '{{ url()->current() }}/check-print',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    nosj: $('#nosjas').val(),
                    cus_kode: $('#cus_kode').val(),
                    tahapan: $('#tahapan').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if(response == 'true'){
                        swal({
                            title: 'Cetak Surat Jalan dengan model?',
                            icon: 'warning',
                            buttons: {
                                all : 'Semua Item Struk',
                                item : 'Hanya Item yang diambil',
                                cancel : 'BATAL'
                            }
                        }).then((ok) => {
                            if(ok){
                                window.open(`{{ url()->current() }}/print?nosj=${$('#nosjas').val()}&tahap=${$('#tahapan').val()}&cus_kode=${$('#cus_kode').val()}&item=${ok.substr(0,1).toUpperCase()}&reprint=Y`,'_blank');
                            }
                            else{

                            }
                        });
                    }
                    else{

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
    </script>
@endsection
