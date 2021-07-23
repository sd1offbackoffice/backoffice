@extends('navbar')

@section('title','PKM | PROSES KERTAS KERJA PKM')

@section('content')

    <div class="container" id="main_view">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">PROSES ALL DATA PKM</legend>

                    <div class="card-body">
                        <div class="row form-group">
                            <label for="periode" class="col-sm-3 text-right col-form-label">Periode Proses</label>
                            <div class="col-sm-2">
                                <input maxlength="10" type="text" class="form-control tanggal" id="periode">
                            </div>
                            <label class="col-form-label">[ MM/YYYY ]</label>
                        </div>
                        <div class="row form-group">
                            <label for="prdcd" class="col-sm-3 text-right col-form-label">PRDCD</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="prdcd" disabled>
                                <button id="btn_prdcd" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_prdcd" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <label class="col-form-label">[ ALL PLU -> KOSONG ]</label>
                        </div>
                        <div class="row form-group">
                            <label for="desk" class="col-sm-3 text-right col-form-label"></label>
                            <div class="col-sm-8">
                                <input maxlength="10" type="text" class="form-control" id="desk" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="sales1" class="col-sm-3 text-right col-form-label">Periode Sales 1</label>
                            <div class="col-sm-2">
                                <input maxlength="10" type="text" class="form-control tanggal" id="sales1">
                            </div>
                            <label class="col-form-label">[ MM/YYYY ]</label>
                        </div>
                        <div class="row form-group">
                            <label for="sales2" class="col-sm-3 text-right col-form-label">Periode Sales 2</label>
                            <div class="col-sm-2">
                                <input maxlength="10" type="text" class="form-control tanggal" id="sales2">
                            </div>
                            <label class="col-form-label">[ MM/YYYY ]</label>
                        </div>
                        <div class="row form-group">
                            <label for="sales3" class="col-sm-3 text-right col-form-label">Periode Sales 3</label>
                            <div class="col-sm-2">
                                <input maxlength="10" type="text" class="form-control tanggal" id="sales3">
                            </div>
                            <label class="col-form-label">[ MM/YYYY ]</label>
                        </div>
                        <div class="row form-group">
                            <label for="sales3" class="col-sm-3 text-right col-form-label">Hitung Ulang Data Sales</label>
                            <div class="col-sm-2">
                                <select class="form-control">
                                    <option>Ya</option>
                                    <option selected>Tidak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0 mr-3">
                        <div class="row">
                            <button id="btn_history" class="col-sm-4 btn btn-primary ml-3" onclick="showHistoryView()">
                                History Proses dan Inquery
                            </button>
                            <div class="col"></div>
                            <button class="col-sm-4 btn btn-success mr-2" onclick="proses()">PROSES ALL DATA PKM</button>
                        </div>
                    </div>

                </fieldset>
            </div>
        </div>
    </div>

    <div class="container-fluid" id="history_view" style="display: none">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">History Proses dan Inquery ALL PKM</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <button class="ml-4 col-sm-1 btn btn-primary" onclick="showMainView()">BACK</button>
                        </div>
                        <div class="row form-group">
                            <table class="table table-sm mb-0 text-right" id="table_history">
                                <thead class="text-center thColor">
                                <tr>
                                    <th class="align-middle">PRDCD</th>
                                    <th class="text-center">Min<br>Display</th>
                                    <th class="text-center">Min<br>Order</th>
                                    <th class="text-center">AVG<br>3 bln akhir</th>
                                    <th class="align-middle" colspan="3">Bln ke-3 terakhir</th>
                                    <th class="align-middle" colspan="3">Bln ke-2 terakhir</th>
                                    <th class="align-middle" colspan="3">Bln ke-1 terakhir</th>
                                    <th class="align-middle">MPKM</th>
                                    <th class="align-middle" width="6%">PKM*</th>
                                    <th class="align-middle">M+</th>
                                    <th class="align-middle">PKMT</th>
                                    <th class="align-middle">Proses</th>
                                    <th class="align-middle">Adjust</th>
                                </tr>
                                </thead>
                                <tbody id="">
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                        <div class="row form-group">
                            <label for="desk" class="col-sm-1 text-right col-form-label">Deskripsi</label>
                            <div class="col-sm-4">
                                <input maxlength="10" type="text" class="form-control" id="h_desk" disabled>
                            </div>
                            <label for="desk" class="col-sm-1 text-right col-form-label">Nama Supplier</label>
                            <div class="col pr-5">
                                <input maxlength="10" type="text" class="form-control" id="h_namasupplier" disabled>
                            </div>
                            <button class="mr-5 col-sm-2 btn btn-primary" id="btn_cetak">CETAK STATUS STORAGE</button>
                        </div>
                        <div class="row form-group">
                            <label for="desk" class="col-sm-1 text-right col-form-label">Periode Proses</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="h_periode" disabled>
                            </div>
                            <div class="col-sm-3"></div>
                            <label for="desk" class="col-sm-1 text-right col-form-label">Supplier</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="h_kodesupplier" disabled>
                            </div>
                            <label for="desk" class="text-right col-form-label ml-3">Koef</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="h_koef" disabled>
                            </div>
                            <label for="desk" class="text-right col-form-label ml-2">LT</label>
                            <div class="col-sm-1">
                                <input maxlength="10" type="text" class="form-control text-center" id="h_lt" disabled>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_prdcd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_prdcd">
                                    <thead class="thColor">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                        <th>Konversi</th>
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

    <div class="modal fade" id="m_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">

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

        .clicked, .row-history:hover{
            background-color: grey !important;
            color: white;
        }

    </style>

    <script>
        var listNomor = [];
        var selected = [];
        var dataNodoc = [];
        var dataVNew = [];
        var historyData = [];

        $(document).ready(function(){
            $('.tanggal').MonthPicker({
                Button: false
            });

            getPRDCD();
            getHistory();
        });

        function getPRDCD(){
            lovutuh = $('#table_prdcd').DataTable({
                "ajax": '{{ url()->current().'/get-data-lov-prdcd' }}',
                "columns": [
                    {data: 'desk', name: 'desk'},
                    {data: 'plu', name: 'plu'},
                    {data: 'konversi', name: 'konversi'}
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
                    $(row).addClass('row-prdcd').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_prdcd').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-prdcd', function (e) {
                        $('#prdcd').val($(this).find('td:eq(1)').html());
                        $('#desk').val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));
                        // $('#olahan_plu').val($(this).find('td:eq(3)').html());

                        $('#m_prdcd').modal('hide');
                    });
                }
            });
        }

        function getHistory(){
            $('#table_history').DataTable({
                "ajax": '{{ url()->current().'/get-data-history' }}',
                "columns": [
                    {data: 'pkm_prdcd', name: 'pkm_prdcd'},
                    {data: 'pkm_mindisplay'},
                    {data: 'pkm_minorder'},
                    {data: 'avgqty',render: function(data){
                            return data ? parseFloat(data).toFixed(3) : '';
                        }
                    },
                    {data: 'bln1'},
                    {data: 'qty1',render: function(data){
                            return convertToRupiah2(data);
                        }
                    },
                    {data: 'hari1',render: function(data){
                            return '/' + (data ? data : '') + ' hari';
                        }
                    },
                    {data: 'bln2'},
                    {data: 'qty2',render: function(data){
                            return convertToRupiah2(data);
                        }
                    },
                    {data: 'hari2',render: function(data){
                            return '/' + (data ? data : '') + ' hari';
                        }
                    },
                    {data: 'bln3'},
                    {data: 'qty3',render: function(data){
                            return convertToRupiah2(data);
                        }
                    },
                    {data: 'hari3',render: function(data){
                            return '/' + (data ? data : '') + ' hari';
                        }
                    },
                    {data: 'pkm_mpkm',render: function(data){
                            return convertToRupiah2(data);
                        }
                    },
                    {data: null},
                    {data: 'pkm_qtymplus',render: function(data){
                            return convertToRupiah2(data);
                        }
                    },
                    {data: 'pkm_pkmt',render: function(data){
                            return convertToRupiah2(data);
                        }
                    },
                    {data: 'proses'},
                    {data: 'adjust'},
                    {data: 'pkm_kodesupplier', visible: false, searchable: true},
                    {data: 'sup_namasupplier', visible: false, searchable: true},
                ],
                columnDefs: [
                    {
                        targets: [0],
                        className: 'text-center'
                    },
                    {
                        targets: 14,
                        className: 'pb-0 pt-0'
                    }
                ],
                "createdRow": function (row, data, dataIndex) {
                    $(row).on('click',function(){
                        $('.clicked').removeClass('clicked');
                        $(row).addClass('clicked');
                        showHistoryDetail(dataIndex);
                    });
                    $(row).find('td:eq(14)').empty().append('<input class="pb-0 pt-0 form-control text-right" value="'+data.pkm_pkm+'" onkeypress="changePKM(event,'+dataIndex+')">');
                    $(row).addClass('row-history').css({'cursor': 'pointer'});

                    historyData.push(data);
                },
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "order" : [],
                "initComplete": function(){

                }
            });
            $('#table_history_wrapper').css('width','100%');
        }

        function showMainView(){
            $('#main_view').show();
            $('#history_view').hide();
        }

        function showHistoryView(){
            $('#main_view').hide();
            $('#history_view').show();
        }

        function showHistoryDetail(idx){
            data = historyData[idx];

            $('#h_desk').val(data.prd_deskripsipanjang);
            $('#h_periode').val(data.bulan);
            $('#h_namasupplier').val(data.sup_namasupplier);
            $('#h_kodesupplier').val(data.pkm_kodesupplier);
            $('#h_koef').val(data.pkm_koefisien);
            $('#h_lt').val(data.pkm_leadtime);
        }

        function changePKM(e,idx){
            if(e.which === 13){
                swal({
                    title: 'Yakin ingin melakukan perubahan nilai PKM?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if (ok) {
                        data = historyData[idx];
                        $.ajax({
                            url: '{{ url()->current() }}/change-pkm',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                prdcd: data.pkm_prdcd,
                                pkm: $(e.target).val(),
                                mpkm: data.pkm_mpkm,
                                qtymplus: data.pkm_qtymplus,
                                pkmt: data.pkm_pkmt
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: response.title,
                                    icon: response.status,
                                });

                                if(response.status === 'error')
                                    $(e.target).val(data.pkm_pkm)
                                else historyData[idx].pkm_pkm = $(e.target).val();
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: error.responseJSON.message,
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            }
        }

        function proses(){
            swal({
                title: 'SKIP, TXT_MON',
                icon: 'error'
            });
            {{--periodeAktif = $.datepicker.formatDate('mm/yy', new Date());--}}

            {{--if(!$('#periode').val() || !$('#prdcd').val() || !$('#sales1').val() || !$('#sales2').val() || !$('#sales3').val()){--}}
                {{--swal({--}}
                    {{--title: 'Inputan belum lengkap!',--}}
                    {{--icon: 'error'--}}
                {{--});--}}
            {{--}--}}
            {{--else if($('#periode').val() > periodeAktif){--}}
                {{--swal({--}}
                    {{--title: 'Periode lebih besar dari periode aktif!',--}}
                    {{--icon: 'error'--}}
                {{--});--}}
            {{--}--}}
            {{--else if($('#sales1').val() > periodeAktif){--}}
                {{--swal({--}}
                    {{--title: 'Periode Sales 1 lebih besar dari periode aktif!',--}}
                    {{--icon: 'error'--}}
                {{--});--}}
            {{--}--}}
            {{--else if($('#sales2').val() > periodeAktif){--}}
                {{--swal({--}}
                    {{--title: 'Periode Sales 2 lebih besar dari periode aktif!',--}}
                    {{--icon: 'error'--}}
                {{--});--}}
            {{--}--}}
            {{--else if($('#sales3').val() > periodeAktif){--}}
                {{--swal({--}}
                    {{--title: 'Periode Sales 3 lebih besar dari periode aktif!',--}}
                    {{--icon: 'error'--}}
                {{--});--}}
            {{--}--}}
            {{--else{--}}
                {{--swal({--}}
                    {{--title: 'Yakin ingin melakukan proses data?',--}}
                    {{--icon: 'warning',--}}
                    {{--buttons: true,--}}
                    {{--dangerMode: true--}}
                {{--}).then((ok) => {--}}
                    {{--if(ok){--}}
                        {{--$.ajax({--}}
                            {{--url: '{{ url()->current() }}/proses',--}}
                            {{--type: 'POST',--}}
                            {{--headers: {--}}
                                {{--'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
                            {{--},--}}
                            {{--data: {--}}
                                {{--periode: $('#periode').val(),--}}
                                {{--sales1: $('#sales1').val(),--}}
                                {{--sales2: $('#sales2').val(),--}}
                                {{--sales3: $('#sales3').val(),--}}

                            {{--},--}}
                            {{--beforeSend: function () {--}}
                                {{--$('#modal-loader').modal('show');--}}
                            {{--},--}}
                            {{--success: function (response) {--}}
                                {{--$('#modal-loader').modal('hide');--}}
                                {{--swal({--}}
                                    {{--title: response.title,--}}
                                    {{--text: response.message,--}}
                                    {{--icon: response.status,--}}
                                {{--});--}}
                            {{--},--}}
                            {{--error: function (error) {--}}
                                {{--$('#modal-loader').modal('hide');--}}
                                {{--swal({--}}
                                    {{--title: 'Terjadi kesalahan!',--}}
                                    {{--text: error.responseJSON.message,--}}
                                    {{--icon: 'error',--}}
                                {{--});--}}
                            {{--}--}}
                        {{--});--}}
                    {{--}--}}
                {{--});--}}
            {{--}--}}
        }

        $('#btn_cetak').on('click',() => {
            swal({
                title: 'File akan terdownload beberapa saat lagi',
                icon: 'success'
            });
            window.location.href = '{{ url()->current().'/cetak-status-storage' }}';
        });

    </script>

@endsection
