@extends('navbar')
@section('title','Laporan Promosi Redeem via Unique Code')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5 text-center">LAPORAN PROMOSI REDEEM UNIQUE CODE</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Jenis Promosi</label>
                            <select class="col-sm-2 text-center form-control" name="jenisPromosi" id="jenisPromosi">
                                <option value="cashback">CASHBACK</option> <!--program lama opsi 1-->
                                <option value="gift">GIFT</option> <!--program lama opsi 2-->
                            </select>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Kode Promosi</label>
                            <div class="col-sm-2 buttonInside" style="margin-left: -15px; margin-right: 30px">
                                <input type="text" class="form-control" id="kodePromosi">
                                <button type="button" class="btn btn-lov p-0" onclick="toggleData()">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <input class="col-sm-6 text-center form-control" type="text" id="namaPromosi" disabled>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Periode Promosi</label>
                            <input class="col-sm-3 text-center form-control" type="text" id="p_promosiA" disabled>
                            <label class="col-sm-2 col-form-label text-center">s/d</label>
                            <input class="col-sm-3 text-center form-control" type="text" id="p_promosiB" disabled>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Periode Sales</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Jenis Member</label>
                            <select class="col-sm-2 text-center form-control" name="jenisMember" id="jenisMember">
                                <option value="all">ALL</option> <!--program lama opsi 3-->
                                <option value="biasa">BIASA</option> <!--program lama opsi 2-->
                                <option value="khusus">KHUSUS</option> <!--program lama opsi 1-->
                            </select>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Item Pembanding</label>
                            <div class="col-sm-2 buttonInside" style="margin-left: -15px; margin-right: 30px">
                                <input type="text" class="form-control" id="kodePembanding">
                                <button type="button" class="btn btn-lov p-0" onclick="toggleData2()">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <input class="col-sm-6 text-center form-control" type="text" disabled id="namaPembanding">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Minimum Pembelian</label>
                            <input class="col-sm-2 text-center form-control" type="text" id="minPembelian" onkeypress="return isNumberKey(event)">
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success col-sm-3" type="button" id="cetak" onclick="cetak()">CETAK</button>
                        </div>
                        <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!--MODAL Cash Back-->
    <div class="modal fade" id="m_cashback" tabindex="-1" role="dialog" aria-labelledby="m_cashback" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Promosi Cash Back</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableCashBack">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Promosi</th>
                                        <th>Nama Promosi</th>
                                        <th>Cbh_Tglawal</th>
                                        <th>Cbh_Tglakhir</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyCashBack"></tbody>
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
    <!-- END OF MODAL Gift-->

    <!--MODAL Cash Back-->
    <div class="modal fade" id="m_gift" tabindex="-1" role="dialog" aria-labelledby="m_gift" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Promosi Gift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableGift">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Promosi</th>
                                        <th>Nama Promosi</th>
                                        <th>Gfh_Tglawal</th>
                                        <th>Gfh_Tglakhir</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyGift"></tbody>
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
    <!-- END OF MODAL Pembanding-->

    <!--MODAL Cash Back-->
    <div class="modal fade" id="m_pembanding" tabindex="-1" role="dialog" aria-labelledby="m_pembanding" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tablePembanding">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyPembanding"></tbody>
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
    <!-- END OF MODAL Pembanding-->

    <script>
        let tableCashBack;
        let tableGift;
        let tablePembanding;

        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $(document).ready(function () {
            getCashBack();
            getGift();
            getPembanding();
        })

        function getCashBack(){
            tableCashBack =  $('#tableCashBack').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/getcashback' }}',
                },
                "columns": [
                    {data: 'cbh_kodepromosi', name: 'cbh_kodepromosi'},
                    {data: 'cbh_namapromosi', name: 'cbh_namapromosi'},
                    {data: 'cbh_tglawal', name: 'cbh_tglawal'},
                    {data: 'cbh_tglakhir', name: 'cbh_tglakhir'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowCB');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        function getGift(){
            tableGift =  $('#tableGift').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/getgift' }}',
                },
                "columns": [
                    {data: 'gfh_kodepromosi', name: 'gfh_kodepromosi'},
                    {data: 'gfh_namapromosi', name: 'gfh_namapromosi'},
                    {data: 'gfh_tglawal', name: 'gfh_tglawal'},
                    {data: 'gfh_tglakhir', name: 'gfh_tglakhir'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowGift');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        function getPembanding(){
            tablePembanding =  $('#tablePembanding').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/getpembanding' }}',
                },
                "columns": [
                    {data: 'prd_deskripsipendek', name: 'prd_deskripsipendek'},
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
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowPembanding');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalRowCB', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().text();
            let nama = currentButton.children().first().next().text();
            let tgl1 = currentButton.children().first().next().next().text();
            let tgl2 = currentButton.children().first().next().next().next().text();

            $('#kodePromosi').val(kode);
            $('#namaPromosi').val(nama);
            $('#p_promosiA').val(tgl1);
            $('#p_promosiB').val(tgl2);

            $('#m_cashback').modal('toggle');
        });
        $(document).on('click', '.modalRowGift', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().text();
            let nama = currentButton.children().first().next().text();
            let tgl1 = currentButton.children().first().next().next().text();
            let tgl2 = currentButton.children().first().next().next().next().text();

            $('#kodePromosi').val(kode);
            $('#namaPromosi').val(nama);
            $('#p_promosiA').val(tgl1);
            $('#p_promosiB').val(tgl2);

            $('#m_gift').modal('toggle');
        });
        $(document).on('click', '.modalRowPembanding', function () {
            let currentButton = $(this);
            let nama = currentButton.children().first().text();
            let kode = currentButton.children().first().next().text();

            $('#kodePembanding').val(kode);
            $('#namaPembanding').val(nama);

            $('#m_pembanding').modal('toggle');
        });

        function toggleData(){
            if($('#jenisPromosi').val() == "cashback"){
                $('#m_cashback').modal('toggle');
            }else if($('#jenisPromosi').val() == "gift"){
                $('#m_gift').modal('toggle');
            }else{
                swal({
                    title:'Alert',
                    text: 'Jenis Promosi Harus Ditentukan !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#jenisPromosi').focus();
                });
            }
        }

        function toggleData2(){
            $('#m_pembanding').modal('toggle');
        }

        function checkKodeCBExist(){
            for(i=0;i<tableCashBack.data().length;i++){
                if(tableCashBack.row(i).data()['cbh_kodepromosi'] == $('#kodePromosi').val()){
                    return i;
                }
            }
            return 'false';
        }

        function checkKodeGiftExist(){
            for(i=0;i<tableGift.data().length;i++){
                if(tableGift.row(i).data()['gfh_kodepromosi'] == $('#kodePromosi').val()){
                    return i;
                }
            }
            return 'false';
        }

        function checkKodePembandingExist(){
            // if(tablePembanding.data().length == 0){
            //     return checkKodePembandingExist();
            // }
            for(i=0;i<tablePembanding.data().length;i++){
                if(tablePembanding.row(i).data()['prd_prdcd'] == $('#kodePembanding').val()){
                    return i;
                }
            }
            return 'false';
        }

        $('#kodePromosi').on('change', function (e) {
            if($('#kodePromosi').val() == ''){
                //$('#kodePromosi').val('');
                $('#namaPromosi').val('');
                $('#p_promosiA').val('');
                $('#p_promosiB').val('');
            }else{
                if($('#jenisPromosi').val() == "cashback"){
                    let index = checkKodeCBExist();
                    if(index != 'false'){
                        //let kode = tableCashBack.row(i).data()['cbh_kodepromosi'];
                        let nama = tableCashBack.row(index).data()['cbh_namapromosi'];
                        let tgl1 = tableCashBack.row(index).data()['cbh_tglawal'];
                        let tgl2 = tableCashBack.row(index).data()['cbh_tglakhir'];

                        //$('#kodePromosi').val(kode); //ga perlu, kan sudah diinput makanya bisa terjadi perubahan
                        $('#namaPromosi').val(nama);
                        $('#p_promosiA').val(tgl1);
                        $('#p_promosiB').val(tgl2);
                    }else{
                        swal({
                            title:'Alert',
                            text: 'Kode Promosi Tidak Ada !!',
                            icon:'warning',
                            timer: 2000,
                            buttons: {
                                confirm: false,
                            },
                        }).then(() => {
                            $('#kodePromosi').val('');
                            $('#namaPromosi').val('');
                            $('#p_promosiA').val('');
                            $('#p_promosiB').val('');
                            $('#kodePromosi').focus();
                        });
                    }
                }else if($('#jenisPromosi').val() == "gift"){
                    let index = checkKodeGiftExist();
                    if(index != 'false'){
                        //let kode = tableGift.row(i).data()['gfh_kodepromosi'];
                        let nama = tableGift.row(index).data()['gfh_namapromosi'];
                        let tgl1 = tableGift.row(index).data()['gfh_tglawal'];
                        let tgl2 = tableGift.row(index).data()['gfh_tglakhir'];

                        //$('#kodePromosi').val(kode); //ga perlu, kan sudah diinput makanya bisa terjadi perubahan
                        $('#namaPromosi').val(nama);
                        $('#p_promosiA').val(tgl1);
                        $('#p_promosiB').val(tgl2);
                    }else{
                        swal({
                            title:'Alert',
                            text: 'Kode Promosi Tidak Ada !!',
                            icon:'warning',
                            timer: 2000,
                            buttons: {
                                confirm: false,
                            },
                        }).then(() => {
                            $('#kodePromosi').val('');
                            $('#namaPromosi').val('');
                            $('#p_promosiA').val('');
                            $('#p_promosiB').val('');
                            $('#kodePromosi').focus();
                        });
                    }
                }else{
                    swal({
                        title:'Alert',
                        text: 'Jenis Promosi Harus Ditentukan !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    }).then(() => {
                        $('#jenisPromosi').focus();
                    });
                }
            }
        });

        $('#kodePromosi').on('keypress', function (e) {
            if(e.which == 13){
                if($('#kodePromosi').val() == ''){
                    swal({
                        title:'Alert',
                        text: 'Kode Promosi Tidak Boleh Kosong !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    }).then(() => {
                        $('#namaPromosi').val('');
                        $('#p_promosiA').val('');
                        $('#p_promosiB').val('');
                        $('#kodePromosi').focus();
                    });
                }else{
                    $('#kodePromosi').change();
                }
            }
        });

        $('#kodePembanding').on('change', function (e) {
            let kode = $('#kodePembanding').val();
            if(kode == ''){
                //do nothing
                return false;
            }
            if(kode.substr(1,1) == '#'){
                $('#kodePembanding').val(kode.substr(2,(kode.length)-1));
                let kode = $('#kodePembanding').val();
            }
            if(kode.length < 7){
                //$('#kodePembanding').val(kode.padStart(kode.padEnd(kode.substr(0,(kode.length)-1),'0'),7,'0'));
                $('#kodePembanding').val(kode.padStart(7,'0'));
            }
            let index = checkKodePembandingExist();
            if(index != 'false'){
                let nama = tablePembanding.row(index).data()['prd_deskripsipendek'];

                $('#namaPembanding').val(nama);
            }else{
                swal({
                    title:'Alert',
                    text: 'Kode PLU '+$('#kodePembanding').val()+' - '+ <?php echo $_SESSION['kdigr'] ?> + ' Tidak Terdaftar di Master Barang',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#kodePembanding').val('');
                    $('#namaPembanding').val('');
                });
            }
        });

        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function cetak(){
            if($('#jenisPromosi').val() != "cashback" && $('#jenisPromosi').val() != "gift"){
                swal({
                    title:'Alert',
                    text: 'Jenis Promosi Harus Ditentukan !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#jenisPromosi').focus();
                });
                return false;
            }
            if($('#kodePromosi').val() == ''){
                swal({
                    title:'Alert',
                    text: 'Kode Promosi Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#jenisPromosi').focus();
                });
                return false;
            }
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal({
                    title:'Alert',
                    text: 'Tanggal Awal/Akhir Promosi Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#jenisPromosi').focus();
                });
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            if($('#jenisMember').val() != "all" && $('#jenisMember').val() != "biasa" && $('#jenisMember').val() != "khusus"){
                swal({
                    title:'Alert',
                    text: 'Jenis Member Harus Ditentukan !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#jenisMember').focus();
                });
                return false;
            }
            if($('#kodePembanding').val() != ''){
                if(checkKodePembandingExist() == 'false'){
                    swal({
                        title:'Alert',
                        text: 'Kode PLU '+$('#kodePembanding').val()+' - '+ <?php echo $_SESSION['kdigr'] ?> + ' Tidak Terdaftar di Master Barang',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    }).then(() => {
                        $('#kodePembanding').val('');
                        $('#namaPembanding').val('');
                    });
                    return false;
                }
            }
            if($('#minPembelian').val() == '0' || $('#minPembelian').val() == ''){
                $('#minPembelian').val(1);
            }

            //CETAK
            window.open(`{{ url()->current() }}/cetak?jenisPromosi=${$('#jenisPromosi').val()}&kodePromosi=${$('#kodePromosi').val()}&namaPromosi=${$('#namaPromosi').val()}&tglSales1=${dateA}&tglSales2=${dateB}&tglPromo1=${$('#p_promosiA').val()}&tglPromo2=${$('#p_promosiB').val()}&jenisMember=${$('#jenisMember').val()}&kodePembanding=${$('#kodePembanding').val()}&namaPembanding=${$('#namaPembanding').val()}&minPembelian=${$('#minPembelian').val()}`, '_blank');
            bersihkan();
            //data yang digunakan adalah data di ajax bawah ini
            {{--$.ajax({--}}
            {{--    url: '{{ url()->current() }}/cetak',--}}
            {{--    type: 'GET',--}}
            {{--    data: {--}}
            {{--        jenisPromosi: $('#jenisPromosi').val(),--}}
            {{--        kodePromosi: $('#kodePromosi').val(),--}}
            {{--        namaPromosi: $('#namaPromosi').val(),--}}
            {{--        tglSales1: dateA,--}}
            {{--        tglSales2: dateB,--}}
            {{--        tglPromo1: $('#p_promosiA').val(),--}}
            {{--        tglPromo2: $('#p_promosiB').val(),--}}
            {{--        jenisMember: $('#jenisMember').val(),--}}
            {{--        kodePembanding: $('#kodePembanding').val(),--}}
            {{--        namaPembanding: $('#namaPembanding').val(),--}}
            {{--        minPembelian: $('#minPembelian').val(),--}}
            {{--    },--}}
            {{--    beforeSend: function () {--}}
            {{--        $('#modal-loader').modal('show');--}}
            {{--    },--}}
            {{--    success: function (rec) {--}}
            {{--        $('#modal-loader').modal('hide');--}}

            {{--    },--}}
            {{--    error: function (error) {--}}
            {{--        $('#modal-loader').modal('hide');--}}
            {{--        swal({--}}
            {{--            title: error.responseJSON.title,--}}
            {{--            text: error.responseJSON.message,--}}
            {{--            icon: 'error',--}}
            {{--        });--}}
            {{--        return false;--}}
            {{--    }--}}
            {{--});--}}
        }

        function bersihkan(){
            $('#jenisPromosi').val('cashback');
            $('#kodePromosi').val('');
            $('#namaPromosi').val('');
            $('#p_promosiA').val('');
            $('#p_promosiB').val('');
            $('#daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
            $('#jenisMember').val('all');
            $('#kodePembanding').val('');
            $('#namaPembanding').val('');
            $('#minPembelian').val('');
        }
    </script>
@endsection
