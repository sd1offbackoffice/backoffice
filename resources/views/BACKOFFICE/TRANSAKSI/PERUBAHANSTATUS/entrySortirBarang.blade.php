@extends('navbar')
@section('title','TRANSAKSI | SORTIR BARANG')
@section('content')
    {{--<head>--}}
    {{--<script src="{{asset('/js/bootstrap-select.min.js')}}"></script>--}}
    {{--</head>--}}

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Header Dokumen Sortir Barang</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row text-right">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="i_nomordokumen" class="col-sm-4 col-form-label">Nomor Dokumen</label>
                                        <div class="col-sm-5 buttonInside">
                                            <input onchange="getNmrSRT()" type="text" class="form-control" id="i_nomordokumen">
                                            <button id="btn-no-doc" type="button" class="btn btn-lov p-0"  data-toggle="modal"
                                                    data-target="#nmrSrt">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <span id="printdoc" class="col-sm-2 btn btn-success btn-block" onclick="printDocument()">PRINT</span>
                                        <label for="i_tgldokumen" class="col-sm-4 col-form-label">Tgl Dokumen</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_tgldokumen">
                                        </div>
                                        <div class="col-sm-1">
                                            {{--this div just for filling space--}}
                                        </div>
                                        <input hidden type="text" id="keterangan" class="form-control col-sm-2 text-right" placeholder="STATUS DOKUMEN" disabled>
                                        <label for="i_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_keterangan">
                                        </div>
                                        <label for="i_PLU" class="col-sm-4 col-form-label">PLU Di</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_PLU" onkeypress="return pluDi(event)" oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);">
                                        </div>
                                        <span class="col-sm-3 text-justify font-weight-bold col-form-label">  G - Gudang / T - Toko</span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Detail Dokumen Sortir Barang</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="col-sm-12">
                            <div class="p-0 tableFixedHeader" style="border-bottom: 1px solid black">
                                <table class="table table-sm table-striped table-bordered"
                                       id="table-header">
                                    <thead>
                                    <tr class="table-sm text-center">
                                        <th style="width: 4%;">X</th>
                                        <th style="width: 8%">PLU</th>
                                        <th style="width: 32%">Deskripsi</th>
                                        <th style="width: 8%">Satuan</th>
                                        <th style="width: 6%">TAG</th>
                                        <th style="width: 9%">AVG.COST</th>
                                        <th style="width: 6%">CTN</th>
                                        <th style="width: 6%">PCS</th>
                                        <th style="width: 6%">PT</th>
                                        <th style="width: 6%">RT/TG</th>
                                        <th style="width: 9%">Total Harga</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody" style="height: 250px;">
                                    @for($i = 0; $i< 8; $i++)
                                        <tr class="baris">
                                            <td style="width: 4%" class="text-center">
                                                <button class="btn btn-danger btn-delete"  style="width: 100%" onclick="deleteRow(this)">X</button>
                                            </td>
                                            <td class="buttonInside" style="width: 8%">
                                                <input onclick="TheRowNum(this)" onchange="getPlu(this)" type="text" class="form-control plu">
                                                <button onclick="TheRowNum(this)" type="button" class="btn btn-lov ml-3" data-toggle="modal"
                                                        data-target="#pilihPlu">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            <td style="width: 32%"><input disabled type="text" class="form-control deskripsi"></td>
                                            <td style="width: 8%"><input disabled type="text" class="form-control satuan"></td>
                                            <td style="width: 6%"><input disabled type="text" class="form-control tag text-right"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control avgcost"></td>
                                            <td style="width: 6%"><input type="text" class="form-control ctn text-right" id="{{$i}}" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                            <td style="width: 6%"><input type="text" class="form-control pcs text-right" id="{{$i}}" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                            <td style="width: 6%"><input disabled type="text" class="form-control pt text-right"></td>
                                            <td style="width: 6%"><input disabled type="text" class="form-control rttg text-right"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control total text-right"></td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-3">
                                    <div class="row">
                                        <label class="col-form-label col-sm-6 text-left">TOTAL ITEM</label>
                                        <input type="text" class="form-control col-sm-6 text-right" id="totalItem" value="0" disabled>
                                    </div>
                                    <div class="row">
                                        <label class="col-form-label col-sm-6 text-left">TOTAL QTY</label>
                                        <input type="text" class="form-control col-sm-6 text-right" id="totalQty" value="0" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <span class="text-capitalize font-weight-bold" style="float: right">nomor sortir barang yang sudah dibuat harus segera dibuatkan perubahan</span><br>
                                    <br><div class="d-flex flex-row-reverse">
                                        <button id="tombolsave" class="btn btn-primary btn-block col-sm-3" onclick="saveNow()">Simpan Data</button>
                                        <div class="col-sm-1">
{{--                                        hanya pengisi ruang--}}
                                        </div>
                                        <button id="addNewRow" class="btn btn-primary btn-block col-sm-3" onclick="addNewRow()">Tambah Baris Baru</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade" id="nmrSrt" tabindex="-1" role="dialog" aria-labelledby="nmrSrt" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Memilih Nomor Sortir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableSrt">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>NO.SORTIR</th>
                                        <th>TGL.SORTIR</th>
                                        <th>KETERANGAN</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    {{--Modal PLU--}}
    <div class="modal fade" id="pilihPlu" tabindex="-1" role="dialog" aria-labelledby="pilihPlu" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Memilih Nomor Plu</h5>
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
                                        <th>Dskripsi</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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
        tbody td {
            padding: 3px !important;
        }
        #printdoc:hover{
            cursor: pointer;
        }
    </style>
    <script>
        let rowNum;

        $(document).ready(function () {
            srtLoad('');
            pluLoad('');
        });

        function srtLoad(value){
            let tableSrt = $('#tableSrt').DataTable({
                "ajax": {
                    'url' : '{{ url('/bo/transaksi/perubahanstatus/entrySortirBarang/modalsrt') }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'srt_nosortir', name: 'srt_nosortir'},
                    {data: 'srt_tglsortir', name: 'srt_tglsortir'},
                    {data: 'srt_keterangan', name: 'srt_keterangan'},
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
                    $(row).addClass('modalRowSrt');
                },
                "order": []
            });

            $('#tableSrt_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableSrt.destroy();
                    srtLoad(val);
                }
            })
        }

        function pluLoad(value){
            let tablePlu = $('#tablePlu').DataTable({
                "ajax": {
                    'url' : '{{ url('/bo/transaksi/perubahanstatus/entrySortirBarang/modalplu') }}',
                    "data" : {
                        'value' : value
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
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowPlu');
                },
                "order": []
            });

            $('#tablePlu_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tablePlu.destroy();
                    pluLoad(val);
                }
            })
        }

        $(document).on('click', '.modalRowSrt', function () {
            var currentButton = $(this);
            let kode = currentButton.children().first().text();
            chooseSrt(kode);
            $('#nmrSrt').modal('hide');
        });
        $(document).on('click', '.modalRowPlu', function () {
            var currentButton = $(this);
            let kode = currentButton.children().first().next().text();
            choosePlu(kode,rowNum);
            $('#pilihPlu').modal('hide');
        });

        function TheRowNum(val){
            rowNum = val.parentNode.parentNode.rowIndex-1;
        }

        $("#i_tgldokumen").datepicker({
            "dateFormat" : "dd/mm/yy",
        });

        function pluDi(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode === 71 || charCode === 103 || charCode === 84 || charCode === 116)
                return true;
            return false;
        }

        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        $('#i_nomordokumen').keypress(function (e) {
            if (e.which === 13) {
                let val = this.value;

                // Get New SRT Nmr
                if(val === ''){
                    swal({
                        title: 'Buat Nomor Sortir Baru?',
                        icon: 'info',
                        // dangerMode: true,
                        buttons: true,
                    }).then(function (confirm) {
                        if (confirm){
                            ajaxSetup();
                            $.ajax({
                                url: '{{ url()->current() }}/getnewnmrsrt',
                                type: 'post',
                                data: {},
                                beforeSend: function () {
                                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                },
                                success: function (result) {
                                    $('#i_nomordokumen').val(result);
                                    $('#i_tgldokumen').val(formatDate('now'));
                                    $('#keterangan').val('* TAMBAH');
                                    $('#totalItem').val("");
                                    $('#totalItem').val(0);
                                    $('#modal-loader').modal('hide')
                                    //$('#deleteDoc').attr( 'disabled', true );
                                    //$('#saveData').attr( 'disabled', false );
                                }, error: function () {
                                    alert('error');
                                    $('#modal-loader').modal('hide')
                                }
                            })
                            $('.baris').remove();
                            for (i = 0; i< 8; i++) {
                                $('#tbody').append(tempTable(i));
                            }
                        } else {
                            $('#i_nomordokumen').val('')
                            $('#keterangan').val('')
                        }
                    })
                } else {
                    chooseSrt(val);
                }
            }
        })

        function calculateTotal(value, index) {
            let satuan    = $('.satuan')[index].value;
            let ctn     = $('.ctn')[index].value;
            let pcs     = $('.pcs')[index].value;
            let frac    = satuan.substr(satuan.indexOf('/')+1);
            let price;
            if(frac == 'KG'){
                price   = parseFloat(unconvertToRupiah($('.avgcost')[index].value))
            }else{
                price   = parseFloat(unconvertToRupiah($('.avgcost')[index].value))/frac;
            }
            if($('.plu')[index].value != ''){
                $('.total')[index].value = 0;
                if(ctn != 0 || ctn != ''){
                    $('.total')[index].value = parseFloat($('.total')[index].value) + parseFloat(ctn * frac * price);
                }
                if(pcs != 0 || pcs != ''){
                    $('.total')[index].value = parseFloat($('.total')[index].value) + parseFloat(pcs * price);
                }
                $('.total')[index].value = convertToRupiah($('.total')[index].value);
            }
            calculateQty();
        }

        function calculateQty(){
            let qty = 0;
            for(i = 0; i < $('.plu').length; i++){
                if ($('.plu')[i].value != ''){
                    let satuancounter    = $('.satuan')[i].value;
                    let ctncounter     = $('.ctn')[i].value;
                    let pcscounter     = $('.pcs')[i].value;
                    let fraccounter    = satuancounter.substr(satuancounter.indexOf('/')+1);
                    if(pcscounter != 0){
                        qty = qty + parseInt(pcscounter);
                    }
                    if(ctncounter != 0){
                        qty = qty + (parseInt(ctncounter) * parseInt(fraccounter));
                    }
                }
            }
            $('#totalQty').val(qty);
        }

        function saveNow(){
            let tempPlu  = $('.plu');
            let tempDate= $('#i_tgldokumen').val();
            let noDoc   = $('#i_nomordokumen').val();
            let keterangan    = $('#i_keterangan').val();
            let pludi    = $('#i_PLU').val();
            let date    = tempDate.substr(3,2) + '/'+ tempDate.substr(0,2)+ '/'+ tempDate.substr(6,4);
            let datas   = [{'plu' : '', 'ctn' : '', 'pcs' : '', 'avgcost' : '', 'total' : ''}];
            for (let i=0; i < tempPlu.length; i++){
                var qty     = 0;
                let temp    = $('.satuan')[i].value;
                let tag    = $('.tag')[i].value;
                let arr     = temp.split(" / ");
                let unit    = arr[0];
                let frac    = temp.substr(temp.indexOf('/')+1);
                let ctn     = parseInt( $('.ctn')[i].value);
                let pcs     = parseInt( $('.pcs')[i].value);

                if ( tempPlu[i].value){
                    qty  = (ctn * parseInt(frac) + pcs);

                    datas.push({'plu': $('.plu')[i].value, 'unit' : unit , 'frac' : frac ,'ctn' : ctn, 'pcs' : pcs,'avgcost' : unconvertToRupiah($('.avgcost')[i].value), 'total' : unconvertToRupiah($('.total')[i].value), 'tag' : tag})
                }
            }

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/savedata',
                type: 'post',
                data: {
                    datas:datas,
                    date:date,
                    keterangan:keterangan,
                    pludi:pludi,
                    noDoc:noDoc
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    console.log(result.kode)
                    if(result.kode == '1'){
                        swal('Dokumen Berhasil disimpan','','success');
                    } else if(result.kode == '2'){
                        swal('', result.msg, 'warning');
                    } else if(result.kode == '3'){
                        swal.fire('Revisi Tidak Diperkenankan Lagi Karena Data Sudah Dicetak !!');
                    }else {
                        swal('ERROR', "Something's Error", 'error')
                    }
                    clearField();
                    $('#modal-loader').modal('hide');
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

        function printDocument(){
            let doc         = $('#i_nomordokumen').val();
            let keterangan  = $('#keterangan').val();
            let plu         = $('#i_PLU').val();

            // if (!doc || !keterangan || !plu){
            //     swal('Data Tidak Boleh Kosong','','warning');
            //     return false;
            // }

            if (!doc || !keterangan){
                swal('Data Tidak Boleh Kosong','','warning')
                return false;
            }

            if(plu !== 'G' && plu !== "T"){
                swal('Inputan Plu di Gudang / Toko Salah!','','warning');
                return false;
            }
            if(doc && keterangan === '* TAMBAH' || doc && keterangan === '*KOREKSI*'){
                saveData('cetak');
            } else {
                window.open('{{ url()->current() }}/printdoc/'+doc+'/');
                clearField();
            }
        }

        function clearField() {
            $('input').val('')
            $('.baris').remove();

            for (i = 0; i< 8; i++) {
                $('#tbody').append(tempTable(i));
            }

            //    Memperbaharui LOV Nomor SRT
            tempSrt = null;
            tempPlu = null;

        }

        function saveData(status){
            let tempPlu  = $('.plu');
            let tempDate= $('#i_tgldokumen').val();
            let noDoc   = $('#i_nomordokumen').val();
            let keterangan    = $('#i_keterangan').val();
            let pludi    = $('#i_PLU').val();
            let date    = tempDate.substr(3,2) + '/'+ tempDate.substr(0,2)+ '/'+ tempDate.substr(6,4);
            let datas   = [{'plu' : '', 'ctn' : '', 'pcs' : '', 'avgcost' : '', 'total' : ''}];
            if ($('.deskripsi').val().length < 1){
                swal({
                    title:'Data Tidak Boleh Kosong',
                    text: ' ',
                    icon:'warning',
                    timer: 1000,
                    buttons: {
                        confirm: false,
                    },
                });

                return false;
            }

            for (let i=0; i < tempPlu.length; i++){
                var qty     = 0;
                let temp    = $('.satuan')[i].value;
                let tag    = $('.tag')[i].value;
                let arr     = temp.split(" / ");
                let unit    = arr[0];
                let frac    = temp.substr(temp.indexOf('/')+1);
                let ctn     = parseInt( $('.ctn')[i].value);
                let pcs     = parseInt( $('.pcs')[i].value);

                if ( tempPlu[i].value){
                    qty  = (ctn * parseInt(frac) + pcs);

                    if (qty < 1){
                        focusToRow(i);
                        return false;
                    }
                    datas.push({'plu': $('.plu')[i].value, 'unit' : unit , 'frac' : frac ,'ctn' : ctn, 'pcs' : pcs,'avgcost' : unconvertToRupiah($('.avgcost')[i].value), 'total' : unconvertToRupiah($('.total')[i].value), 'tag' : tag})
                }
            }

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/savedata',
                type: 'post',
                data: {
                    datas:datas,
                    date:date,
                    keterangan:keterangan,
                    pludi:pludi,
                    noDoc:noDoc
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    console.log(result.kode)
                    if(result.kode == '1'){
                        if (status == 'cetak'){
                            window.open('{{ url()->current() }}/printdoc/'+result.msg+'/');
                            clearField();
                        } else {
                            swal('Dokumen Berhasil disimpan','','success')
                        }
                    } else if(result.kode == '2'){
                        swal('', result.msg, 'warning');
                    } else if(result.kode == '3'){
                        swal.fire('Revisi Tidak Diperkenankan Lagi Karena Data Sudah Dicetak !!')
                        window.open('{{ url()->current() }}/printdoc/'+result.msg+'/');
                        clearField();
                    }else {
                        swal('ERROR', "Something's Error", 'error')
                    }
                    $('#modal-loader').modal('hide');
                    clearField();
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

        function focusToRow(index) {
            // swal('QTYB + QTYK < = 0','', 'warning')
            swal({
                title:'QTYB + QTYK < = 0',
                text: ' ',
                icon:'warning',
                timer: 1000,
                buttons: {
                    confirm: false,
                },
            });
            $('.ctn')[index].focus()
        }

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let idModal = $('#idModal').val();
                let idRow   = $('#idRow').val();
                let val = $('#searchModal').val().toUpperCase();
                if(idModal === 'SRT'){
                    searchNmrSRT(val)
                } else {
                    searchPlu(idRow,val)
                }
            }
        })

        function chooseSrt(kode) {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/choosesrt',
                type: 'post',
                data: {
                    kode:kode
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if(result.length === 0){
                        $('.baris').remove();
                        for (i = 0; i< 11; i++) {
                            $('#tbody').append(tempTable());
                        }
                    } else {
                        $('#totalItem').val(result.length);
                        $('#i_nomordokumen').val(result[0].srt_nosortir);
                        $('#i_tgldokumen').val(formatDate(result[0].srt_tglsortir));
                        $('#i_keterangan').val(result[0].srt_keterangan);
                        $('#i_PLU').val(result[0].srt_gudangtoko);
                        if (result[0].nota === 'Data Sudah Dicetak') {
                            $('#keterangan').val(result[0].nota);
                            //$('#saveData').attr( 'disabled', true );
                            $('#addNewRow').attr( 'disabled', true );
                            $('#tombolsave').attr( 'disabled', true );
                            //$('#deleteDoc').attr( 'disabled', true );

                            $('.baris').remove();
                            for (i = 0; i< result.length; i++) {
                                let tempPT = "";
                                let tempRT = "";
                                if(result[i].prd_perlakuanbarang === "PT"){
                                    tempPT = "Y"
                                }
                                else{
                                    tempRT = "Y";
                                }
                                if(result[i].srt_tag === null){
                                    result[i].srt_tag = "";
                                }
                                let temp =  ` <tr class="baris">
                                                <td style="width: 4%" class="text-center">
                                                    <button disabled class="btn btn-danger btn-delete"  style="width: 100%" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 8%">
                                                    <input disabled type="text" class="form-control plu" value="`+ result[i].srt_prdcd +`">
                                                </td>
                                                <td style="width: 32%"><input disabled type="text"  class="form-control deskripsi" value="`+ result[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 8%"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                                <td style="width: 6%"><input disabled type="text"  class="form-control tag text-right" value="`+ result[i].srt_tag +`"></td>
                                                <td style="width: 9%"><input disabled type="text"  class="form-control avgcost" value="`+ convertToRupiah(result[i].srt_avgcost) +`"></td>
                                                <td style="width: 6%"><input disabled type="text" class="form-control ctn text-right" value="` + result[i].srt_qtykarton +`"></td>
                                                <td style="width: 6%"><input disabled type="text" class="form-control pcs text-right" value="` + result[i].srt_qtypcs +`"></td>
                                                <td style="width: 6%"><input disabled type="text"  class="form-control pt text-right" value="`+ tempPT +`"></td>
                                                <td style="width: 6%"><input disabled type="text"  class="form-control rttg text-right" value="`+ tempRT +`"></td>
                                                <td style="width: 9%"><input disabled type="text" class="form-control total text-right" value="`+ convertToRupiah(result[i].srt_ttlhrg) +`"></td>
                                            </tr>`

                                $('#tbody').append(temp);
                            }
                        } else {
                            $('#keterangan').val('*KOREKSI*');
                            //$('#saveData').attr( 'disabled', false );
                            $('#addNewRow').attr( 'disabled', false);
                            $('#tombolsave').attr( 'disabled', false);
                            //$('#deleteDoc').attr( 'disabled', false );

                            $('.baris').remove();
                            for (i = 0; i< result.length; i++) {
                                let tempPT = "";
                                let tempRT = "";
                                if(result[i].prd_perlakuanbarang === "PT"){
                                    tempPT = "Y"
                                }
                                else{
                                    tempRT = "Y";
                                }
                                if(result[i].srt_tag === null){
                                    result[i].srt_tag = "";
                                }

                                let temp =  ` <tr class="baris"">
                                                <td style="width: 4%" class="text-center">
                                                    <button class="btn btn-danger btn-delete"  style="width: 100%" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 8%">
                                                    <input type="text" class="form-control plu" value="`+ result[i].srt_prdcd +`">
                                                     <button onclick="TheRowNum(this)" type="button" class="btn btn-lov ml-3" data-toggle="modal"
                                                        data-target="#pilihPlu">
                                                        <img src="../../../../../public/image/icon/help.png" width="30px">
                                                    </button>
                                                </td>
                                                <td style="width: 32%"><input disabled type="text"  class="form-control deskripsi" value="`+ result[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 8%"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                                <td style="width: 6%"><input disabled type="text"  class="form-control tag text-right" value="`+ result[i].srt_tag +`"></td>
                                                <td style="width: 9%"><input disabled type="text"  class="form-control avgcost" value="`+ convertToRupiah(result[i].srt_avgcost) +`"></td>
                                                <td style="width: 6%"><input type="text" class="form-control ctn text-right" value="` + result[i].srt_qtykarton +`" id="`+ i +`" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                                <td style="width: 6%"><input type="text" class="form-control pcs text-right" value="` + result[i].srt_qtypcs +`" id="`+ i +`" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                                <td style="width: 6%"><input disabled type="text"  class="form-control pt text-right" value="`+ tempPT +`"></td>
                                                <td style="width: 6%"><input disabled type="text"  class="form-control rttg text-right" value="`+ tempRT +`"></td>
                                                <td style="width: 9%"><input disabled type="text" class="form-control total text-right" value="`+ convertToRupiah(result[i].srt_ttlhrg) +`"></td>
                                                </td>
                                            </tr>`

                                $('#tbody').append(temp);

                            }
                        }
                    }
                    $('#modal-loader').modal('hide');
                    calculateQty();
                }, error: function () {
                    alert('error');
                    $('#modal-loader').modal('hide');
                }
            })
            $('#modalHelp').modal('hide')
        }

        function getNmrSRT() {
            let val = $('#i_nomordokumen').val();
            if(val!=''){
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/getnmrsrt',
                    type: 'post',
                    data: {
                        val:val
                    },
                    success: function (result) {
                        if(result.srt_nosortir){
                            chooseSrt(result.srt_nosortir);
                        }else{
                            swal('', "Nomor Tidak dikenali", 'warning');
                            $('#i_nosortir').val('');
                            $('#keterangan').val('');
                        }
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        function choosePlu(kode,index) {
            $('.plu')[index].value = kode;
            $('#modalHelp').modal('hide');

            let temp        = 0;

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/chooseplu',
                type: 'post',
                data: {
                    kode: kode
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    if (result.kode === 1){
                        data = result.data[0];
                        if(data.st_avgcost === null){
                            swal('', "Tidak ada di stok!", 'warning');
                            $('.plu')[index].value = '';
                            $('.deskripsi')[index].value = '';
                            $('.tag')[index].value = '';
                            $('.satuan')[index].value = '';
                            $('.avgcost')[index].value = '';
                            $('.ctn')[index].value = '';
                            $('.pcs')[index].value = '';
                            $('.pt')[index].value = '';
                            $('.rttg')[index].value = '';
                        }
                        else{
                            $('.plu')[index].value = data.prd_prdcd;
                            $('.deskripsi')[index].value = data.prd_deskripsipendek;
                            $('.tag')[index].value = data.prd_kodetag;
                            $('.satuan')[index].value = data.prd_unit + ' / '+ data.prd_frac;
                            if(data.prd_unit == 'KG'){
                                $('.avgcost')[index].value = convertToRupiah(data.st_avgcost * 1);
                            }else{
                                $('.avgcost')[index].value = convertToRupiah(data.st_avgcost * data.prd_frac);
                            }
                            $('.ctn')[index].value = '0';
                            $('.pcs')[index].value = '0';
                            if(data.prd_perlakuanbarang === "PT"){
                                $('.pt')[index].value = 'Y';
                                $('.rttg')[index].value = '';
                            }
                            else{
                                $('.pt')[index].value = '';
                                $('.rttg')[index].value = 'Y';
                            }
                        }
                        for(i = 0; i < $('.plu').length; i++){
                            if ($('.plu')[i].value != ''){
                                temp = temp + 1;
                            }
                        }
                        $('#totalItem').val(temp);
                    } else if(result.kode === 0)  {
                        swal('', result.msg, 'warning');

                        data = result.data[0];
                        $('.plu')[index].value = '';
                        $('.deskripsi')[index].value = '';
                        $('.tag')[index].value = '';
                        $('.satuan')[index].value = '';
                        $('.ctn')[index].value = '';
                        $('.pcs')[index].value = '';
                        $('.pt')[index].value = '';
                        $('.rttg')[index].value = '';
                        for(i = 0; i < $('.plu').length; i++){
                            if ($('.plu')[i].value != ''){
                                temp = temp + 1;
                            }
                        }
                        $('#totalItem').val(temp);
                    } else {
                        swal('Error', 'Somethings error', 'error');
                    }
                }, error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            })
        }

        function getPlu(w) {
            choosePlu(w.value,rowNum);
        }

        function tempTable(index) {
            var temptbl =  ` <tr class="baris">
                                                <td style="width: 4%" class="text-center">
                                                    <button class="btn btn-danger btn-delete"  style="width: 100%" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 8%">
                                                    <input onclick="TheRowNum(this)" onchange="getPlu(this)" type="text" class="form-control plu" value="">
                                                     <button onclick="TheRowNum(this)" type="button" class="btn btn-lov ml-3" data-toggle="modal"
                                                        data-target="#pilihPlu">
                                                        <img src="../../../../../public/image/icon/help.png" width="30px">
                                                    </button>
                                                </td>
                                                <td style="width: 32%"><input disabled type="text"  class="form-control deskripsi" value=""></td>
                                                <td style="width: 8%"><input disabled type="text" class="form-control satuan" value=""></td>
                                                <td style="width: 6%"><input disabled type="text" class="form-control tag text-right" value=""></td>
                                                <td style="width: 9%"><input disabled type="text" class="form-control avgcost" value=""></td>
                                                <td style="width: 6%"><input type="text" class="form-control ctn text-right" value="" id="`+ index +`" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                                <td style="width: 6%"><input type="text" class="form-control pcs text-right" value="" id="`+ index +`" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                                <td style="width: 6%"><input disabled type="text" class="form-control pt text-right" value=""></td>
                                                <td style="width: 6%"><input disabled type="text" class="form-control rttg text-right" value=""></td>
                                                <td style="width: 9%"><input disabled type="text" class="form-control total text-right" value=""></td>
                                            </tr>`

            return temptbl;
        }

        function addNewRow() {
            let temp = $('#tbody').find('tr').length;
            // let temp = $('#tbody').find('tr:last').find('input')[0]['attributes']['no']['value'];
            let index = parseInt(temp,10)

            $('#tbody').append(tempTable(index))
            // $('#tbody').append(tempTable(index+1))
        }

        function deleteRow(e) {
            let temp        = 0;
            let tempTtlHrg  = 0;

            $(e).parents("tr").remove();

            for(i = 0; i < $('.plu').length; i++){
                if ($('.plu')[i].value != ''){
                    temp = temp + 1;
                }
                if($('.total')[i].value != ''){
                    tempTtlHrg = parseFloat(tempTtlHrg) + parseFloat(unconvertToRupiah($('.total')[i].value));
                }
            }
            $('#totalItem').val(temp);
            $('#totalHarga').val(convertToRupiah(tempTtlHrg));
            calculateQty();
        }
    </script>
@endsection
