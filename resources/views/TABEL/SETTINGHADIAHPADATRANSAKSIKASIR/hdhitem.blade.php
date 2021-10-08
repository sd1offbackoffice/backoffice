@extends('navbar')
@section('title','HADIAH PER ITEM BARANG')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">HADIAH PER ITEM BARANG</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">PLU Transaksi</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="pluTrans">
                                <button id="trans" type="button" class="btn btn-lov p-0" onclick="ToggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <input class="col-sm-8 text-left form-control" type="text" id="ketTrans" disabled>
                        </div>
                        <br>

                        {{--PERIODE DAN SYARAT PEMBELIAN/STRUK--}}
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-12 text-center">PERIODE :</span>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Tgl Mulai</label>
                                    <input class="col-sm-8 text-center form-control" type="text" id="daterangepicker">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-12 text-left">SYARAT PEMBELIAN / STRUK :</span>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Min PCS</label>
                                    <input class="col-sm-4 text-center form-control" type="number" id="minPcs" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    <label class="col-sm-2 col-form-label text-right">Max PCS</label>
                                    <input class="col-sm-4 text-center form-control" type="number" id="maxPcs" min="0" value="0" onkeypress="return isNumberKey(event)">
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Min Rph</label>
                                    <input class="col-sm-4 text-center form-control" type="number" id="minRph" min="0" value="1" onkeypress="return isNumberKey(event)">
                                    <label class="col-sm-2 col-form-label text-right">Max RPH</label>
                                    <input class="col-sm-4 text-center form-control" type="number" id="maxRph" min="0" value="0" onkeypress="return isNumberKey(event)">
                                </div>
                            </div>
                        </div>
                        <br>

                        {{--HADIAH TRANSAKSI--}}
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">PLU Hadiah</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="pluHadiah">
                                <button id="hadiah" type="button" class="btn btn-lov p-0" onclick="ToggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <input class="col-sm-8 text-left form-control" type="text" id="ketHadiah" disabled>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Jumlah yang diperoleh</label>
                            <input class="col-sm-2 text-center form-control" type="number" id="jumlahHadiah" min="1" value="1" onkeypress="return isNumberKey(event)">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Kelipatan</label>
                            <input class="col-sm-1 text-center form-control" type="number" id="kelipatan">
                            <label class="col-sm-2 col-form-label text-left">[ Y / T ]</label>
                        </div>
                        <br>

                        {{--PEROLEHAN/MEMBER/HARI DAN ALOKASI PER HARI :--}}
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-12 text-center">PEROLEHAN / MEMBER / HARI :</span>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Max JML</label>
                                    <input class="col-sm-8 text-center form-control" type="number" id="jmlPerhari" min="0" value="0" onkeypress="return isNumberKey(event)">
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Max Frek</label>
                                    <input class="col-sm-6 text-center form-control" type="number" id="maxFrekHadiah" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    <label class="col-sm-2 col-form-label text-left">x</label>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-12">ALOKASI PER HARI :</span>
                                </div>
                                <div class="row">
                                    <label class="col-sm-4 col-form-label text-right">Max Pengeluaran Hadiah Per Hari</label>
                                    <input class="col-sm-6 text-center form-control" type="number" id="maxKeluar" min="0" value="0" onkeypress="return isNumberKey(event)">
                                </div>
                            </div>
                        </div>

                        {{--TOTAL ALOKASI HADIAH DAN JENIS MEMBER--}}
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-12 text-center">TOTAL ALOKASI HADIAH :</span>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Alokasi</label>
                                    <input class="col-sm-6 text-center form-control" type="number" id="alokasi" min="0" value="0" onkeypress="return isNumberKey(event)">
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Tersisa</label>
                                    <input class="col-sm-6 text-center form-control" type="number" id="sisa" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    <label class="col-sm-2 col-form-label text-left">PCS</label>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">Terpakai</label>
                                    <input class="col-sm-6 text-center form-control" type="number" id="pakai" min="0" value="0" onkeypress="return isNumberKey(event)">
                                    <label class="col-sm-2 col-form-label text-left">PCS</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <span style="text-decoration: underline" class="col-sm-12">JENIS MEMBER : &nbsp;&nbsp;[ ENTER = CHECKED / UNCHECKED]</span>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="RB" onkeydown="check(this)" checked>&nbsp;REGULER BIRU</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="RGP" onkeydown="check(this)" checked>&nbsp;REGULER BIRU PLUS</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="F" onkeydown="check(this)" checked>&nbsp;FREEPASS</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="RM" onkeydown="check(this)" checked>&nbsp;RETAILER MERAH</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="S" onkeydown="check(this)" checked>&nbsp;SILVER</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="P" onkeydown="check(this)" checked>&nbsp;PLATINUM</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="G1" onkeydown="check(this)" checked>&nbsp;GOLD 1</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="G2" onkeydown="check(this)" checked>&nbsp;GOLD 2</label>
                                        </div>
                                        <div class="row checkbox">
                                            <label><input type="checkbox" value="" id="G3" onkeydown="check(this)" checked>&nbsp;GOLD 3</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>

                        {{--EVENT PROMOSI--}}
                        <div class="row">
                            <label class="col-sm-4 col-form-label text-right">Hadiah Ini Untuk Event Promo</label>
                            <input class="col-sm-6 text-center form-control" type="text" id="keterangan">
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label text-right">Max Frek</label>
                            <input class="col-sm-6 text-center form-control" type="number" id="maxFrekPrevent" min="0" value="0" onkeypress="return isNumberKey(event)">
                            <label class="col-sm-2 col-form-label text-left">x</label>
                        </div>
                        <div class="row">
                            <label class="col-sm-4 col-form-label text-right">Max PCS</label>
                            <input class="col-sm-6 text-center form-control" type="number" id="maxJmlPrevent" min="0" value="1" onkeypress="return isNumberKey(event)">
                        </div>
                        <br>

                        {{--BUTTONS--}}
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary col-sm-1" type="button">NEW</button>&nbsp;
                            <button class="btn btn-primary col-sm-1" type="button">EDIT</button>&nbsp;
                            <button class="btn btn-primary col-sm-1" type="button">SAVE</button>&nbsp;
                            <button class="btn btn-primary col-sm-2" type="button" id="history" onclick="ToggleData(this)">History Hadiah</button>
                        </div>
                        <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!--MODAL Plu-->
    <div class="modal fade" id="m_plu" tabindex="-1" role="dialog" aria-labelledby="m_plu" aria-hidden="true">
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
                                <table class="table table-striped table-bordered" id="tablePlu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Frac</th>
                                        <th>Harga</th>
                                        <th>Tag</th>
                                        <th>MinJual</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyPlu"></tbody>
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
    <!-- END OF MODAL Plu-->

    <!--MODAL Hadiah-->
    <div class="modal fade" id="m_hadiah" tabindex="-1" role="dialog" aria-labelledby="m_hadiah" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Barang Hadiah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableHadiah">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyHadiah"></tbody>
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
    <!-- END OF MODAL Hadiah-->

    <!--MODAL DATA ADA-->
    <div class="modal fade" id="m_history" tabindex="-1" role="dialog" aria-labelledby="m_history" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">History Promosi Cabang Per Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <input type="text" id="hiddenParamater" hidden>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableHistory">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Berlaku</th>
                                        <th>Keterangan</th>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                        <th>Kode</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyHistory"></tbody>
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
    <!-- END OF MODAL DATA ADA-->

    <script>
        let tablePlu;
        let tableHadiah;
        let tableHistory;
        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $(document).ready(function () {
            PluModal('');
            HadiahModal();
            HistoryModal();
        });

        //Custom Filtering untuk dept
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {

                if ( settings.nTable.id === 'tablePlu' || settings.nTable.id === 'tableHadiah' ) {
                    return true; //no filtering on modal div
                }

                if ( settings.nTable.id === 'tableHistory' ) {
                    let hiddenParameter = $('#hiddenParamater').val();
                    let val = data[3];
                    if ( hiddenParameter === val )
                    {
                        return true;
                    }else if( hiddenParameter == ''){
                        return true;
                    }
                }
                return false;
            }
        );
        $('#hiddenParamater').change( function() {
            tableHistory.draw(true);
        } );
        // $(document).on({
        //     ajaxStart: function() { $('#modal-loader').modal('show');   },
        //     ajaxStop: function() { $('#modal-loader').modal('hide'); }
        // });

        $('#pluTrans').on('keydown', function() {
            if(event.key == 'Tab'){
                if(isEmpty($('#pluTrans').val())){
                    swal({
                        title:'Alert',
                        text: 'Kode Barang Tidak Boleh Kosong !!',
                        icon:'warning',
                    }).then(() => {
                        $('#pluTrans').focus();
                    });
                }else{
                    $('#pluTrans').change();
                }
            }
        });
        $('#pluTrans').on('change', function() {
            let crop = $('#pluTrans').val().toUpperCase();
            if(crop != ''){
                if(crop.substr(0,1) == '#'){
                    crop = crop.substr(1,(crop.length)-1);
                }
            }
            if(crop.length < 7){
                crop = crop.padStart(7,'0');
            }
            $.ajax({
                url: '{{ url()->current() }}/checkplu',
                type: 'GET',
                data: {
                    prd:crop
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response == '0'){
                        swal({
                            title:'Alert',
                            text: 'Kode PLU '+crop+'-'+<?php echo $_SESSION['kdigr'] ?>+' Tidak Terdaftar di Master Barang  !!',
                            icon:'warning',
                        }).then(() => {
                            $('#pluTrans').select();
                        });
                    }else{
                        if(response.status == 'tidak baru'){
                            swal({
                                title: 'Data Promosi Untuk PLU tsb Sudah Ada',
                                icon: 'warning',
                                buttons: {
                                    baru: {
                                        text: 'Bikin Promosi Baru',
                                        value: 'B'
                                    },
                                    lama: {
                                        text: 'Lihat Promosi Yang Sudah Ada',
                                        value: 'L'
                                    }
                                },
                                dangerMode: true
                            }).then(function(input){
                                if(input == 'B'){
                                    $('#pluTrans').val(response.prdcd);
                                    $('#ketTrans').val(response.deskripsi);
                                    $('#pluTrans').prop('disabled',true);
                                }else{
                                    $('#hiddenParamater').val(response.prdcd).change();
                                    //setTimeout(function(){ $('#m_history').modal('toggle'); }, 5000);
                                    $('#m_history').modal('toggle');
                                }
                            });
                        }
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        });

        $('#pluHadiah').on('keydown', function() {
            if(event.key == 'Tab'){
                if(isEmpty($('#pluHadiah').val())){
                    swal({
                        title:'Alert',
                        text: 'Kode Barang Hadiah Tidak Boleh Kosong !!',
                        icon:'warning',
                    }).then(() => {
                        $('#pluHadiah').focus();
                    });
                }
            }
        });
        $('#pluHadiah').on('change', function() {
            let crop = $('#pluHadiah').val().toUpperCase();
            if(crop != ''){
                if(crop.substr(0,1) == '#'){
                    crop = crop.substr(1,(crop.length)-1);
                }
            }
            if(crop.length < 7){
                crop = crop.padStart(7,'0');
            }
            if(index = checkHadiahExist(crop)){
                index = index-1;
                $('#pluHadiah').val(tableHadiah.row(index).data()['bprp_prdcd']);
                $('#ketHadiah').val(tableHadiah.row(index).data()['bprp_ketpanjang']);
            }else{
                swal({
                    title:'Alert',
                    text: 'PLU Hadiah Tidak Terdaftar !!',
                    icon:'warning',
                }).then(() => {
                    $('#pluHadiah').select();
                });
            }
        });

        $('#minPcs').on('change', function() {
            let result = NoneOrBoth($('#minPcs').val(), $('#minRph').val());
            if(result == 'none'){
                $('#minRph').val(1);
            }else if(result == 'both'){
                $('#minRph').val(0);
            }
        });

        $('#minRph').on('change', function() {
            let result = NoneOrBoth($('#minPcs').val(), $('#minRph').val());
            if(result == 'none'){
                swal({
                    title:'Alert',
                    text: 'Minimum JML atau HRG Struk harus diisi !!',
                    icon:'warning',
                }).then(() => {
                    $('#minRph').val(1).select();
                });
            }else if(result == 'both'){
                swal({
                    title:'Alert',
                    text: 'Isi Salah Satu Antara Minimum JML atau HRG Struk !!',
                    icon:'warning',
                }).then(() => {
                    $('#minRph').val(0).select();
                });
            }
        });

        $('#jumlahHadiah').on('change', function() {
            if($('#jumlahHadiah').val() < 1){
                swal({
                    title:'Alert',
                    text: 'Qty Hadiah Tidak Boleh Dikosongkan !!',
                    icon:'warning',
                }).then(() => {
                    $('#jumlahHadiah').val(1).select();
                });
            }
        });

        $('#maxFrekPrevent').on('change', function() {
            let result = NoneOrBoth($('#maxFrekPrevent').val(), $('#maxJmlPrevent').val());
            if(result == 'none'){
                $('#maxJmlPrevent').val(1);
            }else if(result == 'both'){
                $('#maxJmlPrevent').val(0);
            }
        });

        $('#maxJmlPrevent').on('change', function() {
            let result = NoneOrBoth($('#maxFrekPrevent').val(), $('#maxJmlPrevent').val());
            if(result == 'none'){
                swal({
                    title:'Alert',
                    text: 'Maximum PCS atau FREK Event Promo harus diisi !!',
                    icon:'warning',
                }).then(() => {
                    $('#maxJmlPrevent').val(1).select();
                });
            }else if(result == 'both'){
                swal({
                    title:'Alert',
                    text: 'Isi Salah Satu Antara Maximum PCS atau FREK Event Promo !!',
                    icon:'warning',
                }).then(() => {
                    $('#maxJmlPrevent').val(0).select();
                });
            }
        });

        //Untuk periksa apakah plu hadiah ada
        function checkHadiahExist(val){
            for(i=0;i<tableHadiah.data().length;i++){
                if(tableHadiah.row(i).data()['bprp_prdcd'] == val){
                    return i+1;
                }
            }
            return false;
        }

        function NoneOrBoth(a,b){
            if(a == 0 && b == 0){
                return 'none';
            }else if(a != 0 && b != 0){
                return 'both';
            }
        }

        function check(val){
            if(event.which == 13){
                if($('#'+val.id).is(":checked")){
                    $('#'+val.id).prop('checked', false);
                }else{
                    $('#'+val.id).prop('checked', true);
                }
            }
        }

        function PluModal(value){
            tablePlu =  $('#tablePlu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modalplu' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'frac', name: 'frac'},
                    {data: 'hrgjual', name: 'hrgjual'},
                    {data: 'prd_kodetag', name: 'prd_kodetag'},
                    {data: 'jual', name: 'jual'},
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
                    $(row).addClass('modalPlu');
                },
                columnDefs : [
                ],
                "order": []
            });

            $('#tablePlu_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tablePlu.destroy();
                    PluModal(val);
                }
            })
        }

        function HadiahModal(){
            tableHadiah =  $('#tableHadiah').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modalhadiah' }}',
                },
                "columns": [
                    {data: 'bprp_ketpanjang', name: 'bprp_ketpanjang'},
                    {data: 'bprp_prdcd', name: 'bprp_prdcd'},
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
                    $(row).addClass('modalHadiah');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        function HistoryModal(){
            tableHistory =  $('#tableHistory').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modalhistory' }}',
                },
                "columns": [
                    {data: 'berlaku', name: 'berlaku'},
                    {data: 'ish_keterangan', name: 'berlaku'},
                    {data: 'prd_deskripsipanjang', name: 'berlaku'},
                    {data: 'isd_prdcd', name: 'isd_prdcd'},
                    {data: 'isd_kodepromosi', name: 'isd_kodepromosi'},
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
                    $(row).addClass('modalHistory');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalPlu', function () {
            let currentButton = $(this);
            let nama = currentButton.children().first().text();
            let kode = currentButton.children().first().next().next().next().next().next().text();

            $('#pluTrans').val(kode);
            $('#ketTrans').val(nama);
            $('#pluTrans').change();

            $('#m_plu').modal('toggle');
        });

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalHadiah', function () {
            let currentButton = $(this);
            let nama = currentButton.children().first().text();
            let kode = currentButton.children().first().next().text();

            $('#pluHadiah').val(kode);
            $('#ketHadiah').val(nama);

            $('#m_hadiah').modal('toggle');
        });

        function ToggleData(val){
            if(val.id == 'trans'){
                $('#m_plu').modal('toggle');
            }else if(val.id == 'hadiah'){
                $('#m_hadiah').modal('toggle');
            }else if(val.id == 'history'){
                $('#hiddenParamater').val('').change();
                $('#m_history').modal('toggle');
            }
        }

        function isNumberKey(evt){
            let charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function isEmpty(input){
            if(input.length == 0){
                return true;
            }
            return false;
        }

        function ClearForm(){

        }
    </script>
@endsection
