@extends('navbar')
@section('title','LAPORAN KASIR | REKAP & EVALUASI PER MEMBER')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Evaluasi Langganan / Member</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Tanggal</label>
                            <input type="text" class="col-sm-7 form-control text-center" id="tanggal" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                            <div class="col-sm"></div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Langganan</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <input type="text" class="form-control text-left" id="langganan1" onchange="checkLanggananValid('langganan1')">
                                <button id="" type="button" class="btn btn-primary btn-lov btn-lov-langganan p-0" onclick="showLovLangganan('langganan1')" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-2 buttonInside p-0">
                                <input type="text" class="form-control text-left" id="langganan2" onchange="checkLanggananValid('langganan2')">
                                <button id="" type="button" class="btn btn-primary btn-lov btn-lov-langganan p-0" onclick="showLovLangganan('langganan2')" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <label class="col-sm pt-1 text-left">[kosong = semua]</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Outlet</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <input type="text" class="form-control text-left input-outlet" id="outlet1" onchange="checkOutlet('outlet1')">
                                <button type="button" class="btn btn-primary btn-lov p-0 btn-lov-outlet" onclick="showLovOutlet('outlet1')" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-2 buttonInside p-0">
                                <input type="text" class="form-control text-left input-outlet" id="outlet2" onchange="checkOutlet('outlet2')">
                                <button type="button" class="btn btn-primary btn-lov p-0 btn-lov-outlet" onclick="showLovOutlet('outlet2')" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <label class="col-sm pt-1 text-left">[kosong = tanpa outlet]</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Sub Outlet</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <input type="text" class="form-control text-left input-suboutlet" id="suboutlet1" onchange="checkSubOutlet('suboutlet1')">
                                <button id="btn_lov_kasir" type="button" class="btn btn-primary btn-lov p-0 btn-lov-suboutlet" onclick="showLovSubOutlet('suboutlet1')" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <label class="col-sm-1 pt-1 text-center">s/d</label>
                            <div class="col-sm-2 buttonInside p-0">
                                <input type="text" class="form-control text-left input-suboutlet" id="suboutlet2" onchange="checkSubOutlet('suboutlet2')">
                                <button id="btn_lov_kasir" type="button" class="btn btn-primary btn-lov p-0 btn-lov-suboutlet" onclick="showLovSubOutlet('suboutlet2')" disabled>
                                    <i class="fas fa-spinner fa-spin"></i>
                                </button>
                            </div>
                            <label class="col-sm pt-1 text-left">[kosong = semua sub outlet]</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Jenis Customer</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <select class="form-control" id="jenis_customer">
                                    <option value="M">MRO</option>
                                    <option value="G">GROUP</option>
                                    <option value="O">OMI</option>
                                    <option value="I">INDOMARET</option>
                                    <option value="K">KHUSUS</option>
                                    <option value="F">FREEPAS</option>
                                    <option value="B">BIASA</option>
                                    <option value="ALL">ALL</option>
                                    <option value="BIRU">MEMBER BIRU</option>
                                    <option value="MERAH">MEMBER MERAH</option>
                                </select>
                            </div>
                            <label class="col-sm pt-1 text-left">[ALL = semua customer]</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Tipe Monitoring</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <select class="form-control" id="monitoring">
                                    @foreach($monitoring as $m)
                                        <option value="{{ $m->mem_kodemonitoring == '' ? 'ALL' : $m->mem_kodemonitoring }}">
                                            @if($m->mem_kodemonitoring == '')
                                                ALL
                                            @else
                                                {{ $m->mem_kodemonitoring }} - {{ $m->mem_namamonitoring }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm pt-1 text-left">[ALL = semua]</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Sort By</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <select class="form-control" id="sort">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                            <label class="col-sm pt-1 text-left">[1 = Member | 2 = Nilai]</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Jenis Laporan</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <select class="form-control" id="jenis_laporan">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                            <label class="col-sm pt-1 text-left">[1 = Detail | 2 = Rekap]</label>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-3 text-right col-form-label pl-0">Include Barang Counter</label>
                            <div class="col-sm-2 buttonInside pl-0">
                                <select class="form-control" id="counter">
                                    <option value="y">Y</option>
                                    <option value="t">T</option>
                                </select>
                            </div>
                            <label class="col-sm pt-1 text-left">[Y / T]</label>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <button class="col-sm-2 btn btn-primary" onclick="cetak()">CETAK LAPORAN</button>
                            <div class="col-sm"></div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_langganan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_langganan">
                                    <thead>
                                    <tr>
                                        <th>Kode Member</th>
                                        <th>Nama Member</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_outlet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_outlet">
                                    <thead>
                                    <tr>
                                        <th>Kode Outlet</th>
                                        <th>Nama Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_suboutlet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_suboutlet">
                                    <thead>
                                    <tr>
                                        <th>Kode Outlet</th>
                                        <th>Kode Sub Outlet</th>
                                        <th>Nama Sub Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_lov_body">
                                    </tbody>
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
        var fieldLangganan;
        var fieldOutlet;
        var fieldSubOutlet;

        var tableLovLangganan;

        $(document).ready(function(){
            $('#tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });

            getLovLangganan('');
            getLovOutlet();
            getLovSubOutlet();
        });

        function getLovLangganan(value){
            tableLovLangganan = $('#table_lov_langganan').DataTable({
                "ajax": {
                    url: '{{ url()->current() }}/get-lov-langganan',
                    data: {
                        "search": value
                    }
                },
                "columns": [
                    {data: 'cus_kodemember'},
                    {data: 'cus_namamember'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-langganan').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#table_lov_langganan_filter input').addClass('text-uppercase').val(value);

                    $('.btn-lov-langganan').prop('disabled', false).html('').append('<i class="fas fa-question"></i>');

                    $(document).on('click', '.row-lov-langganan', function (e) {
                        $('#'+fieldLangganan).val($(this).find('td:eq(0)').html());

                        $('#m_lov_langganan').modal('hide');

                        checkLangganan();
                    });
                }
            });

            $('#table_lov_langganan_filter input').val(value);

            $('#table_lov_langganan_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    tableLovLangganan.destroy();
                    getLovLangganan($(this).val().toUpperCase());
                }
            });
        }

        $('#m_lov_langganan').on('shown.bs.modal',function(){
            $('#table_lov_langganan_filter input').select();
        });

        function showLovLangganan(field){
            fieldLangganan = field;

            $('#m_lov_langganan').modal('show');
        }

        function checkLangganan(){
            if($('#langganan1').val() && $('#langganan2').val() && $('#langganan1').val() > $('#langganan2').val()){
                swal({
                    title: 'Kode langganan 1 lebih besar dari kode langganan 2!',
                    icon: 'warning'
                }).then(function(){
                    $('#'+fieldLangganan).val('').focus();
                });

                return false;
            }
            return true;
        }

        function checkLanggananValid(field){
            if(checkLangganan() && $('#'+field).val() != ''){
                $.ajax({
                    url: '{{ url()->current() }}/check-langganan',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        value: $('#'+field).val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if(response == 'invalid'){
                            swal({
                                title: 'Kode member '+$('#'+field).val()+' tidak ditemukan!',
                                icon: 'error'
                            }).then(function(){
                                $('#'+field).select();
                            });
                        }
                        else{
                            field == 'langganan1' ? $('#langganan2').select() : $('#outlet1').select();
                        }
                    }
                });
            }
        }

        function getLovOutlet(){
            $('#table_lov_outlet').DataTable({
                "ajax": '{{ url()->current() }}/get-lov-outlet',
                "columns": [
                    {data: 'out_kodeoutlet'},
                    {data: 'out_namaoutlet'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-outlet').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('.btn-lov-outlet').prop('disabled', false).html('').append('<i class="fas fa-question"></i>');

                    $(document).on('click', '.row-lov-outlet', function (e) {
                        $('#'+fieldOutlet).val($(this).find('td:eq(0)').html());

                        $('#m_lov_outlet').modal('hide');

                        checkOutlet();
                    });
                }
            });
        }

        $('#m_lov_outlet').on('shown.bs.modal',function(){
            $('#table_lov_outlet_filter input').select();
        });

        function showLovOutlet(field){
            fieldOutlet = field;

            $('#m_lov_outlet').modal('show');
        }

        $('.input-outlet').on('keypress',function(e){
            if(e.which == 13){
                checkOutletValid($(this).attr('id'));
            }
        })

        function checkOutlet(){
            if($('#outlet1').val() && $('#outlet2').val() && $('#outlet1').val() > $('#outlet2').val()){
                swal({
                    title: 'Kode outlet 1 lebih besar dari kode outlet 2!',
                    icon: 'warning'
                }).then(function(){
                    $('#'+fieldOutlet).val('').focus();
                });

                return false;
            }
            return true;
        }

        function checkOutletValid(field){
            if(checkOutlet() && $('#'+field).val() != ''){
                $.ajax({
                    url: '{{ url()->current() }}/check-outlet',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        value: $('#'+field).val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if(response == 'invalid'){
                            swal({
                                title: 'Kode outlet '+$('#'+field).val()+' tidak ditemukan!',
                                icon: 'error'
                            }).then(function(){
                                $('#'+field).select();
                            });
                        }
                        else{
                            field == 'outlet1' ? $('#outlet2').select() : $('#suboutlet1').select();
                        }
                    }
                });
            }
        }

        function getLovSubOutlet(){
            $('#table_lov_suboutlet').DataTable({
                "ajax": '{{ url()->current() }}/get-lov-suboutlet',
                "columns": [
                    {data: 'sub_kodeoutlet'},
                    {data: 'sub_kodesuboutlet'},
                    {data: 'sub_namasuboutlet'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-suboutlet').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('.btn-lov-suboutlet').prop('disabled', false).html('').append('<i class="fas fa-question"></i>');

                    $(document).on('click', '.row-lov-suboutlet', function (e) {
                        if(($('#outlet1').val() && $(this).find('td:eq(0)').html() < $('#outlet1').val()) || ($('#outlet2').val() && $(this).find('td:eq(0)').html() > $('#outlet2').val())){
                            swal({
                                title: 'Kode outlet harus antara '+$('#outlet1').val()+' dan '+$('#outlet2').val()+'!',
                                icon: 'error'
                            });
                        }
                        else{
                            $('#'+fieldSubOutlet).val($(this).find('td:eq(1)').html());

                            $('#m_lov_suboutlet').modal('hide');

                            checkSubOutlet();
                        }
                    });
                }
            });
        }

        $('#m_lov_suboutlet').on('shown.bs.modal',function(){
            $('#table_lov_suboutlet_filter input').select();
        });

        function showLovSubOutlet(field){
            fieldSubOutlet = field;

            $('#m_lov_suboutlet').modal('show');
        }

        $('.input-suboutlet').on('keypress',function(e){
            if(e.which == 13){
                fieldSubOutlet = $(this).attr('id');
                checkSubOutletValid($(this).attr('id'));
            }
        })

        function checkSubOutlet(){
            if(($('#outlet1').val() && $('#suboutlet1').val().substr(0,1) < $('#outlet1').val()) || ($('#outlet2').val() && $('#suboutlet2').val().substr(0,1) > $('#outlet2').val())){
                swal({
                    title: 'Kode outlet harus antara '+$('#outlet1').val()+' dan '+$('#outlet2').val()+'!',
                    icon: 'error'
                }).then(function(){
                    $('#'+fieldSubOutlet).val('').focus();
                });

                return false;
            }
            if($('#suboutlet1').val() && $('#suboutlet2').val() && $('#suboutlet1').val() > $('#suboutlet2').val()){
                swal({
                    title: 'Kode sub outlet 1 lebih besar dari kode sub outlet 2!',
                    icon: 'warning'
                }).then(function(){
                    $('#'+fieldSubOutlet).val('').focus();
                });

                return false;
            }
            return true;
        }

        function checkSubOutletValid(field){
            if(checkSubOutlet() && $('#'+field).val() != ''){
                $.ajax({
                    url: '{{ url()->current() }}/check-suboutlet',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        value: $('#'+field).val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');

                        if(response == 'invalid'){
                            swal({
                                title: 'Kode sub outlet '+$('#'+field).val()+' tidak ditemukan!',
                                icon: 'error'
                            }).then(function(){
                                $('#'+field).select();
                            });
                        }
                        else{
                            field == 'suboutlet1' ? $('#suboutlet2').select() : $('#customer').select();
                        }
                    }
                });
            }
        }

        function cetak(){
            tgl1 = $("#tanggal").data('daterangepicker').startDate.format('DD/MM/YYYY');
            tgl2 = $("#tanggal").data('daterangepicker').endDate.format('DD/MM/YYYY');

            if($('#jenis_laporan').val() == '1')
                window.open(`{{ url()->current() }}/print-detail?tgl1=${tgl1}&tgl2=${tgl2}&member1=${$('#langganan1').val()}&member2=${$('#langganan1').val()}&outlet1=${$('#outlet1').val()}&outlet2=${$('#outlet2').val()}&suboutlet1=${$('#suboutlet1').val()}&suboutlet2=${$('#suboutlet2').val()}&jenis_customer=${$('#jenis_customer').val()}&monitoring=${$('#monitoring').val()}&sort=${$('#sort').val()}&jenis_laporan=${$('#jenis_laporan').val()}&counter=${$('#counter').val()}`
                    ,'_blank');
            else
                window.open(`{{ url()->current() }}/print-rekap?tgl1=${tgl1}&tgl2=${tgl2}&member1=${$('#langganan1').val()}&member2=${$('#langganan1').val()}&outlet1=${$('#outlet1').val()}&outlet2=${$('#outlet2').val()}&suboutlet1=${$('#suboutlet1').val()}&suboutlet2=${$('#suboutlet2').val()}&jenis_customer=${$('#jenis_customer').val()}&monitoring=${$('#monitoring').val()}&sort=${$('#sort').val()}&jenis_laporan=${$('#jenis_laporan').val()}&counter=${$('#counter').val()}`
                    ,'_blank');
        }
    </script>

@endsection
