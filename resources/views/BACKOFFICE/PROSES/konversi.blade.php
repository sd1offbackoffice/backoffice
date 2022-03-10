@extends('navbar')

@section('title','PROSES | KONVERSI ITEM PERISHABLE OLAHAN')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <fieldset class="card border-secondary m-2">
                        <legend  class="w-auto ml-5">Perubahan PLU Utuh Menjadi PLU Olahan</legend>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">PLU UTUH</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="utuh_plu">
                                    <button id="btn_lov_plu_utuh" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_plu_utuh" disabled>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </button>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="utuh_desk" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">QTY UTUH</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="utuh_qty" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">PLU OLAHAN</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="olahan_plu" disabled>
                                </div>
                                {{--<div class="d-none">--}}
                                    {{--<button class="btn btn-primary rounded-circle btn_lov" id="btn_lov_trn" data-toggle="modal" data-target="#m_lov_trn" disabled>--}}
                                        {{--<i class="fas fa-spinner fa-spin"></i>--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                                <div class="col">
                                    <input type="text" class="form-control" id="olahan_desk" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">QTY OLAHAN</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="olahan_qty" disabled>
                                </div>
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">% WASTE</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control" id="waste" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9"><span class="align-middle"><strong>*Qty in gram</strong></span></div>
                                <div class="col-sm-3">
                                    <button class="col btn btn-primary" onclick="konversiUtuhOlahan()">PROSES KONVERSI</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary m-2">
                        <legend  class="w-auto ml-5">Perubahan PLU Olahan Menjadi PLU Mix</legend>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">PLU MIX</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="mix_plu">
                                    <button id="btn_lov_plu_mix" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_plu_mix" disabled>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </button>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="mix_desk" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">QTY MIX</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="mix_qty">
                                </div>
                            </div>
                            <br>
                            <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                <thead class="thColor">
                                <tr>
                                    <th width="20%">PLU Olahan</th>
                                    <th width="60%">Deskripsi</th>
                                    <th width="20%">QTY Olahan</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="row mt-1">
                                <div class="col-sm-9"><span class="align-middle"><strong>*Qty in gram</strong></span></div>
                                <div class="col-sm-3">
                                    <button class="col btn btn-primary" onclick="konversiOlahanMix()">PROSES KONVERSI</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="card border-secondary m-2">
                        <legend  class="w-auto ml-5">Cek Data Konversi</legend>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">PERIODE</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="periode1">
                                </div>
                                <p class="mt-1 ml-2 mr-2">s/d</p>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="periode2">
                                </div>
                                <div class="col"></div>
                                <div class="col-sm-3">
                                    <button class="col btn btn-primary" onclick="printBukti()">CETAK BUKTI TRANSAKSI</button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">NO DOKUMEN</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="nodoc" disabled>
                                    <button id="btn_lov_nodoc" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_nodoc" disabled>
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </button>
                                </div>
                                <div class="col-sm-5"></div>
                                <div class="col-sm-3">
                                    <button class="col btn btn-primary" onclick="printLaporanRekap()">CETAK LAPORAN REKAP</button>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-sm-9">
                                    <span class="align-middle">
                                        <strong>
                                            **Untuk cetak bukti transaksi, pilih salah satu inputan antara Periode dengan No Dokumen<br>
                                            &emsp;Untuk cetak laporan sesuai dengan inputan Periode
                                        </strong>
                                    </span>
                                </div>
                                <div class="col-sm-3">
                                    <button class="col btn btn-primary" onclick="printLaporanDetail()">CETAK LAPORAN RINCI</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_plu_utuh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_plu_utuh">
                                    <thead>
                                    <tr>
                                        <th>Deskripsi Utuh</th>
                                        <th>PLU Utuh</th>
                                        <th>Deskripsi Olah</th>
                                        <th>PLU Olah</th>
                                        <th>% Waste</th>
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

    <div class="modal fade" id="m_lov_plu_mix" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_plu_mix">
                                    <thead>
                                    <tr>
                                        <th>PLU</th>
                                        <th>DESKRIPSI</th>
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

    <div class="modal fade" id="m_lov_nodoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_nodoc">
                                    <thead>
                                    <tr>
                                        <th>No Dokumen</th>
                                        <th>Tanggal Dokumen</th>
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

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang{
            position:absolute;
            bottom: 10px;
            right: 3vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .btn-lov-plu{
            position:absolute;
            bottom: 10px;
            right: 2vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .modal thead tr th{
            vertical-align: middle;
        }
    </style>

    <script>
        var dataPluUtuh = [];

        $(document).ready(function(){
            $('#periode1').datepicker({
                "dateFormat" : "dd/mm/yy",
            }).on('change', function (e) {
                cekTanggal('periode1');
            });

            $('#periode2').datepicker({
                "dateFormat" : "dd/mm/yy",
            }).on('change', function (e) {
                cekTanggal('periode2');
            });

            tabel = $('#table_daftar').DataTable({
                "scrollY": "30vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });

            getLovUtuh();
            getLovMix();
            getLovNodoc();
        });

        function cekTanggal(periode){
            $('#nodoc').val('');
            if($('#periode1').val() > $('#periode2').val() && ($('#periode1').val() != '' && $('#periode2').val() != '')){
                swal({
                    title: 'Periode 1 lebih besar dari Periode 2!',
                    icon: 'warning'
                }).then(() => {
                    if(periode == 'periode1')
                        $('#periode1').val('').select();
                    else $('#periode2').val('').select();
                });
            }
        }

        function getLovUtuh(){
            lovutuh = $('#table_lov_plu_utuh').DataTable({
                "ajax": '{{ url()->current().'/get-data-lov-plu-utuh' }}',
                "columns": [
                    {data: 'utuh_desk', name: 'utuh_desk'},
                    {data: 'utuh_prdcd', name: 'utuh_prdcd'},
                    {data: 'olah_desk', name: 'olah_desk'},
                    {data: 'olah_prdcd', name: 'olah_prdcd'},
                    {data: 'was_persen', name: 'was_persen'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    dataPluUtuh.push(data);
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).find(':eq(2)').addClass('text-left');
                    $(row).addClass('row-lov-plu-utuh').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_plu_utuh').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-plu-utuh', function (e) {
                        $('#utuh_qty').val('');
                        $('#olahan_qty').val('');
                        $('#utuh_plu').val($(this).find('td:eq(1)').html());
                        $('#utuh_desk').val($(this).find('td:eq(0)').html().replace(/&amp;/g, '&'));
                        $('#olahan_plu').val($(this).find('td:eq(3)').html());
                        $('#olahan_desk').val($(this).find('td:eq(2)').html().replace(/&amp;/g, '&'));
                        $('#waste').val($(this).find('td:eq(4)').html());

                        $('#m_lov_plu_utuh').modal('hide');

                        $('#olahan_qty').prop('disabled',false);
                        $('#utuh_qty').prop('disabled',false).select();
                    });
                }
            });
        }

        function getLovMix(){
            lovutuh = $('#table_lov_plu_mix').DataTable({
                "ajax": '{{ url()->current().'/get-data-lov-plu-mix' }}',
                "columns": [
                    {data: 'mix_prdcd', name: 'mix_prdcd'},
                    {data: 'mix_desk', name: 'mix_desk'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    // dataPluMix.push(data);
                    $(row).find(':eq(1)').addClass('text-left');
                    $(row).addClass('row-lov-plu-mix').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_plu_mix').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-plu-mix', function (e) {
                        $('#mix_plu').val($(this).find('td:eq(0)').html());
                        $('#mix_desk').val($(this).find('td:eq(1)').html().replace(/&amp;/g, '&'));
                        $('#mix_qty').val(0);

                        $('#m_lov_plu_mix').modal('hide');

                        getDataPluOlahan();
                    });
                }
            });
        }

        $('#mix_plu').on('keypress',function(e){
            if(e.which == 13){
                $.ajax({
                    type: "GET",
                    url: "{{ url()->current().'/get-data-plu-mix' }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        plu: convertPlu($('#mix_plu').val()),
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if(response == ''){
                            swal({
                                title: 'PLU tidak ditemukan!',
                                icon: 'error'
                            }).then(() => {

                            });
                        }
                        else{
                            $('#mix_plu').val(response.mix_prdcd);
                            $('#mix_desk').val(response.mix_desk.replace(/&amp;/g, '&'));
                            $('#mix_qty').val(0);

                            getDataPluOlahan();
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        // handle error
                        swal({
                            title: 'Terjadi kesalahan!',
                            text: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {

                        });
                    }
                });
            }
        });

        function getDataPluOlahan(){
            $.ajax({
                type: "GET",
                url: "{{ url()->current().'/get-data-plu-olahan' }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    plu: $('#mix_plu').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if($.fn.DataTable.isDataTable('#table_daftar')){
                        $('#table_daftar').DataTable().destroy();
                        $("#table_daftar tbody [role='row']").remove();
                    }

                    for(i=0;i<response.length;i++){
                        html = `<tr>` +
                            `<td>${response[i].knv_prdcd_konv}</td>` +
                            `<td class="text-left">${response[i].deskripsi}</td>` +
                            `<td><input type="number" class="form-control text-right" value="0"></td>`+
                            `</tr>`;

                        $('#table_daftar tbody').append(html);
                    }

                    tabel = $('#table_daftar').DataTable({
                        "scrollY": "30vh",
                        "paging" : false,
                        "sort": false,
                        "bInfo": false,
                        "searching": false
                    });
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: 'Terjadi kesalahan!',
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {

                    });
                }
            });
        }

        function getLovNodoc(){
            lovnodoc = $('#table_lov_nodoc').DataTable({
                "ajax": '{{ url()->current().'/get-data-lov-nodoc' }}',
                "columns": [
                    {data: 'msth_nodoc', name: 'msth_nodoc'},
                    {data: 'msth_tgldoc', name: 'msth_tgldoc'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    // dataPluUtuh.push(data);
                    $(row).addClass('row-lov-nodoc').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_nodoc').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-nodoc', function (e) {
                        $('#nodoc').val($(this).find('td:eq(0)').html());

                        $('#periode1').val('');
                        $('#periode2').val('');

                        $('#m_lov_nodoc').modal('hide');
                    });
                }
            });
        }

        $('#utuh_plu').on('keypress',function(e){
            if(e.which == 13){
                $.ajax({
                    type: "GET",
                    url: "{{ url()->current().'/get-data-plu-utuh' }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        plu: convertPlu($('#utuh_plu').val()),
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if(response == ''){
                            swal({
                                title: 'PLU tidak ditemukan!',
                                icon: 'error'
                            }).then(() => {

                            });
                        }
                        else{
                            $('#utuh_qty').val('');
                            $('#olahan_qty').val('');
                            $('#utuh_plu').val(response.utuh_prdcd);
                            $('#utuh_desk').val(response.utuh_desk.replace(/&amp;/g, '&'));
                            $('#olahan_plu').val(response.olah_prdcd);
                            $('#olahan_desk').val(response.olah_desk.replace(/&amp;/g, '&'));
                            $('#waste').val(response.was_persen);

                            $('#olahan_qty').prop('disabled',false);
                            $('#utuh_qty').prop('disabled',false).select();
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        // handle error
                        swal({
                            title: 'Terjadi kesalahan!',
                            text: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {

                        });
                    }
                });
            }
        });

        function konversiUtuhOlahan(){
            if($('#utuh_plu').val() == ''){
                swal({
                    title: 'Data belum dipilih!',
                    icon: 'warning'
                });
            }
            else if($('#utuh_qty').val().length == 0 || $('#olahan_qty').val().length == 0){
                swal({
                    title: 'Inputan Qty belum lengkap!',
                    icon: 'warning'
                });
            }
            else if($('#utuh_qty').val() == 0){
                swal({
                    title: 'Qty PLU Utuh tidak boleh 0!',
                    icon: 'warning'
                });
            }
            else if($('#olahan_qty').val() == 0){
                swal({
                    title: 'Qty PLU Olahan tidak boleh 0!',
                    icon: 'warning'
                });
            }
            else if(parseInt($('#olahan_qty').val()) >= parseInt($('#utuh_qty').val())){
                swal({
                    title: 'Qty PLU Olahan lebih besar / sama dengan Qty PLU Utuh!',
                    icon: 'warning'
                });
            }
            else if($('#utuh_qty').val() - $('#olahan_qty').val() > $('#utuh_qty').val() * ($('#waste').val() / 100)){
                swal({
                    title: 'Selisih Qty PLU Utuh dengan PLU Olahan tidak sesuai dengan % Waste!',
                    icon: 'warning'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin melakukan proses konversi?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            type: "POST",
                            url: "{{ url()->current().'/konversi-utuh-olahan' }}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                utuhprdcd: $('#utuh_plu').val(),
                                utuhqty: $('#utuh_qty').val(),
                                olahprdcd: $('#olahan_plu').val(),
                                olahqty: $('#olahan_qty').val()
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.alert,
                                    icon: response.status
                                }).then(() => {
                                    if(response.status == 'success'){
                                        lovnodoc.ajax.reload();
                                        $('input').val('');
                                        $('#nodoc').val(response.nodoc);
                                        window.open('{{ url()->current() }}/print-bukti?nodoc='+$('#nodoc').val(),'_blank');
                                    }
                                });
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                // handle error
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: error.responseJSON.message,
                                    icon: 'error'
                                }).then(() => {

                                });
                            }
                        });
                    }
                });
            }
        }

        function konversiOlahanMix(){
            plu = '';
            check = true;
            $('#table_daftar tbody tr').each(function(){
                if($(this).find(':eq(2) input').val() <= 0){
                    plu = $(this).find(':eq(0)').html();
                    check = false;
                    return false;
                }
            });

            if($('#mix_plu').val() == ''){
                swal({
                    title: 'Data Konversi belum dipilih!',
                    icon: 'warning'
                });
            }
            else if($('#mix_qty').val() <= 0){
                swal({
                    title: 'Qty Olahan tidak boleh 0!',
                    icon: 'warning'
                }).then(() => {
                    $('#mix_qty').select();
                });
            }
            else if(!check){
                swal({
                    title: 'Qty PLU '+plu+' Olahan tidak boleh 0!',
                    icon: 'warning'
                }).then(() => {

                });
            }
            else{
                olah = [];
                $('#table_daftar tbody tr').each(function(){
                    o = {};
                    o.plu = $(this).find(':eq(0)').html();
                    o.qty = $(this).find(':eq(2) input').val();
                    olah.push(o);
                });

                $.ajax({
                    type: "GET",
                    url: "{{ url()->current().'/check-qty-olahan-mix' }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        mix_plu: $('#mix_plu').val(),
                        mix_qty: $('#mix_qty').val(),
                        olahan: olah
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        doKonversiOlahanMix();
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        // handle error
                        swal({
                            title: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {

                        });
                    }
                });
            }
        }

        function doKonversiOlahanMix(){
            swal({
                title: 'Yakin ingin melakukan proses konversi PLU '+$('#mix_plu').val()+'?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    olah = [];
                    $('#table_daftar tbody tr').each(function(){
                        o = {};
                        o.plu = $(this).find(':eq(0)').html();
                        o.qty = $(this).find(':eq(2) input').val();
                        olah.push(o);
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{ url()->current().'/konversi-olahan-mix' }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            mix_plu: $('#mix_plu').val(),
                            mix_qty: $('#mix_qty').val(),
                            olahan: olah
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            swal({
                                title: response.alert,
                                icon: response.status
                            }).then(() => {
                                if(response.status == 'success'){
                                    if($.fn.DataTable.isDataTable('#table_daftar')){
                                        $('#table_daftar').DataTable().destroy();
                                        $("#table_daftar tbody [role='row']").remove();
                                    }

                                    tabel = $('#table_daftar').DataTable({
                                        "scrollY": "30vh",
                                        "paging" : false,
                                        "sort": false,
                                        "bInfo": false,
                                        "searching": false
                                    });

                                    lovnodoc.ajax.reload();
                                    $('input').val('');

                                    $('#nodoc').val(response.nodoc);
                                    window.open('{{ url()->current() }}/print-bukti?nodoc='+$('#nodoc').val(),'_blank');
                                }
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            // handle error
                            swal({
                                title: 'Terjadi kesalahan!',
                                text: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {

                            });
                        }
                    });
                }
            });
        }

        function printBukti(){
            if(!(($('#nodoc').val() != '') || ($('#periode1').val() != '' && $('#periode2').val() != ''))){
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
            }
            else if($('#nodoc').val() != ''){
                window.open('{{ url()->current() }}/print-bukti?nodoc='+$('#nodoc').val()+'&reprint=1','_blank');
            }
            else{
                window.open('{{ url()->current() }}/print-bukti?periode1='+$('#periode1').val()+'&periode2='+$('#periode2').val()+'&reprint=1','_blank');
            }
        }

        function printLaporanRekap(){
            if(!($('#periode1').val() != '' && $('#periode2').val() != '')){
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
            }
            else{
                window.open('{{ url()->current() }}/print-laporan-rekap?periode1='+$('#periode1').val()+'&periode2='+$('#periode2').val(),'_blank');
            }
        }

        function printLaporanDetail(){
            if(!($('#periode1').val() != '' && $('#periode2').val() != '')){
                swal({
                    title: 'Inputan belum lengkap!',
                    icon: 'warning'
                });
            }
            else{
                window.open('{{ url()->current() }}/print-laporan-detail?periode1='+$('#periode1').val()+'&periode2='+$('#periode2').val(),'_blank');
            }
        }
    </script>

@endsection
