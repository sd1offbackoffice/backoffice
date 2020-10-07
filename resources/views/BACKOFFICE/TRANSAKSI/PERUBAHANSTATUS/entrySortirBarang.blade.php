@extends('navbar')
@section('content')
    {{--<head>--}}
    {{--<script src="{{asset('/js/bootstrap-select.min.js')}}"></script>--}}
    {{--</head>--}}

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card">
                    <legend class="w-auto ml-5">Header Dokumen Sortir Barang</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row text-right">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="i_nomordokumen" class="col-sm-4 col-form-label">Nomor Dokumen</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_nomordokumen" placeholder="V_NOSORTIR">
                                        </div>
                                        <button class="btn sm-1" type="button" data-toggle="modal" onclick="getNmrSRT('')" style="margin-left: -20px;margin-right: auto"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                        <span id="printdoc" class="col-sm-2 btn btn-success btn-block" onclick="printDocument()">PRINT</span>
                                        <label for="i_tgldokumen" class="col-sm-4 col-form-label">Tgl Dokumen</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_tgldokumen" placeholder="V_TGLSORTIR">
                                        </div>
                                        <input type="text" id="keterangan" class="form-control col-sm-3 text-right"  disabled>
                                        <label for="i_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_keterangan" placeholder="V_KET">
                                        </div>
                                        <label for="i_PLU" class="col-sm-4 col-form-label">PLU Di</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control text-uppercase" id="i_PLU" placeholder="V_GUI" onkeypress="return pluDi(event)">
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
                            <div class="tableFixedHeader" style="border-bottom: 1px solid black">
                                <table class="table table-striped table-bordered" id="table2">
                                    <thead class="thead-dark">
                                    <tr class="d-flex text-center">
                                        <th style="width: 80px;">X</th>
                                        <th style="width: 150px">PLU</th>
                                        <th style="width: 400px">Deskripsi</th>
                                        <th style="width: 130px">Satuan</th>
                                        <th style="width: 80px">TAG</th>
                                        <th style="width: 140px">AVG.COST</th>
                                        <th style="width: 80px">CTN</th>
                                        <th style="width: 80px">PCS</th>
                                        <th style="width: 80px">PT</th>
                                        <th style="width: 80px">RT/TG</th>
                                        <th style="width: 150px">Total Harga</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    @for($i = 0; $i< 8; $i++)
                                        <tr class="d-flex baris">
                                            <td style="width: 80px" class="text-center">
                                                <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                            </td>
                                            <td class="buttonInside" style="width: 150px">
                                                <input type="text" class="form-control plu" no="{{$i}}">
                                                <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" onclick="getPlu(this, '')" no="{{$i}}">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            <td style="width: 400px"><input disabled type="text" class="form-control deskripsi"></td>
                                            <td style="width: 130px"><input disabled type="text" class="form-control satuan"></td>
                                            <td style="width: 80px"><input disabled type="text" class="form-control tag text-right"></td>
                                            <td style="width: 140px"><input disabled type="text" class="form-control avgcost"></td>
                                            <td style="width: 80px"><input type="text" class="form-control ctn text-right" id="{{$i}}" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                            <td style="width: 80px"><input type="text" class="form-control pcs text-right" id="{{$i}}" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                            <td style="width: 80px"><input disabled type="text" class="form-control pt text-right"></td>
                                            <td style="width: 80px"><input disabled type="text" class="form-control rttg text-right"></td>
                                            <td style="width: 150px"><input disabled type="text" class="form-control total text-right"></td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><button id="addNewRow" class="btn btn-warning btn-block" onclick="addNewRow()">Tambah Baris Baru</button></td>
                                        </tr>
                                    </tfoot>
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
                                    <span class="text-capitalize font-weight-bold" style="float: right">nomor sortir barang yang sudah dibuat harus segera dibuatkan perubahan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="m_kodecabangHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov" type="text" placeholder="..." aria-label="Search">
                    </div>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th id="modalThName1"></th>
                                            <th id="modalThName2"></th>
                                            <th id="modalThName3"></th>
                                            <th id="modalThName4"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp"></tbody>
                                    </table>
                                    <p class="text-hide" id="idModal"></p>
                                    <p class="text-hide" id="idRow"></p>
                                </div>
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
        let tempSrt;
        let tempPlu;

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
                                url: '/BackOffice/public/bo/transaksi/perubahanstatus/entrySortirBarang/getnewnmrsrt',
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
            calculateQty();
            let satuan    = $('.satuan')[index].value;
            let ctn     = $('.ctn')[index].value;
            let pcs     = $('.pcs')[index].value;
            let frac    = satuan.substr(satuan.indexOf('/')+1);
            let price   = (unconvertToRupiah($('.avgcost')[index].value))/frac;
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
                window.open('/BackOffice/public/bo/transaksi/perubahanstatus/entrySortirBarang/printdoc/'+doc+'/');
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
            let datas   = [{'plu' : '', 'qty' : '', 'harga' : '', 'total' : '', 'keterangan' : ''}];
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
                var total   = 0;
                let temp    = $('.satuan')[i].value;
                let frac    = temp.substr(temp.indexOf('/')+1);

                if ( tempTR[i].value){
                    qty  = parseInt( $('.ctn')[i].value * frac) + parseInt($('.pcs')[i].value);

                    if (qty < 1){
                        focusToRow(i);
                        return false;
                    }
                    datas.push({'plu': $('.plu')[i].value, 'qty' : qty, 'harga' : unconvertToRupiah($('.harga')[i].value), 'total' : unconvertToRupiah($('.total')[i].value), 'keterangan' : $('.keterangan')[i].value})
                }
            }
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
                url: '/BackOffice/public/bo/transaksi/perubahanstatus/entrySortirBarang/choosesrt',
                type: 'post',
                data: {
                    kode:kode
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#totalItem').val(result.length);
                    if(result.length === 0){
                        $('.baris').remove();
                        for (i = 0; i< 11; i++) {
                            $('#tbody').append(tempTable());
                        }
                    } else {
                        $('#i_nomordokumen').val(result[0].srt_nosortir);
                        $('#i_tgldokumen').val(formatDate(result[0].srt_tglsortir));
                        $('#i_keterangan').val(result[0].srt_keterangan);
                        $('#i_PLU').val(result[0].srt_gudangtoko);
                        if (result[0].nota === 'Data Sudah Dicetak') {
                            $('#keterangan').val(result[0].nota);
                            //$('#saveData').attr( 'disabled', true );
                            $('#addNewRow').attr( 'disabled', true );
                            $('#deleteDoc').attr( 'disabled', true );

                            $('.baris').remove();
                            for (i = 0; i< result.length; i++) {
                                let tempPT = "";
                                let tempRT = "";
                                if(result[i].prd_perlakuanbarang === "PT"){
                                    tempPT = "PT"
                                }
                                else{
                                    tempRT = result[i].prd_perlakuanbarang;
                                }
                                if(result[i].srt_tag === null){
                                    result[i].srt_tag = "";
                                }
                                let temp =  ` <tr class="d-flex baris">
                                                <td style="width: 80px" class="text-center">
                                                    <button disabled class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 150px">
                                                    <input disabled type="text" class="form-control plu" value="`+ result[i].srt_prdcd +`">
                                                </td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi" value="`+ result[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                                <td style="width: 80px"><input disabled type="text"  class="form-control tag text-right" value="`+ result[i].srt_tag +`"></td>
                                                <td style="width: 140px"><input disabled type="text"  class="form-control avgcost" value="`+ convertToRupiah(result[i].srt_avgcost) +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control ctn text-right" value="` + result[i].srt_qtykarton +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control pcs text-right" value="` + result[i].srt_qtypcs +`"></td>
                                                <td style="width: 80px"><input disabled type="text"  class="form-control pt text-right" value="`+ tempPT +`"></td>
                                                <td style="width: 80px"><input disabled type="text"  class="form-control rttg text-right" value="`+ tempRT +`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right" value="`+ convertToRupiah(result[i].srt_ttlhrg) +`"></td>
                                            </tr>`

                                $('#tbody').append(temp);
                            }
                        } else {
                            $('#keterangan').val('*KOREKSI*');
                            //$('#saveData').attr( 'disabled', false );
                            $('#addNewRow').attr( 'disabled', false);
                            $('#deleteDoc').attr( 'disabled', false );

                            $('.baris').remove();
                            for (i = 0; i< result.length; i++) {
                                let tempPT = "";
                                let tempRT = "";
                                if(result[i].prd_perlakuanbarang === "PT"){
                                    tempPT = "PT"
                                }
                                else{
                                    tempRT = result[i].prd_perlakuanbarang;
                                }
                                if(result[i].srt_tag === null){
                                    result[i].srt_tag = "";
                                }
                                let temp =  ` <tr class="d-flex baris"">
                                                <td style="width: 80px" class="text-center">
                                                    <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 150px">
                                                    <input type="text" class="form-control plu" value="`+ result[i].rsk_prdcd +`">
                                                     <button id="btn-no-doc" type="button" class="btn btn-lov ml-3 mt-1" onclick="getPlu(this,'')" no="`+ i +`">
                                                        <img src="../../../../../public/image/icon/help.png" width="30px">
                                                    </button>
                                                </td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi" value="`+ result[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                                <td style="width: 80px"><input disabled type="text"  class="form-control tag text-right" value="`+ result[i].srt_tag +`"></td>
                                                <td style="width: 140px"><input disabled type="text"  class="form-control avgcost" value="`+ convertToRupiah(result[i].srt_avgcost) +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control ctn text-right" value="` + result[i].srt_qtykarton +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control pcs text-right" value="` + result[i].srt_qtypcs +`"></td>
                                                <td style="width: 80px"><input disabled type="text"  class="form-control pt text-right" value="`+ tempPT +`"></td>
                                                <td style="width: 80px"><input disabled type="text"  class="form-control rttg text-right" value="`+ tempRT +`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right" value="`+ convertToRupiah(result[i].srt_ttlhrg) +`"></td>
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

        function getNmrSRT(val) {
            $('#searchModal').val('')
            if(tempSrt == null){
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/transaksi/perubahanstatus/entrySortirBarang/getnmrsrt',
                    type: 'post',
                    data: {
                        val:val
                    },
                    success: function (result) {
                        $('#modalThName1').text('NO.DOC');
                        $('#modalThName2').text('TGL.DOC');
                        $('#modalThName3').text('KETERANGAN');
                        $('#modalThName4').text('PLU DI');

                        tempSrt = result;
                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            if(result[i].srt_keterangan == null){
                                result[i].srt_keterangan = " ";
                            }
                            $('#tbodyModalHelp').append("<tr onclick=chooseSrt('"+ result[i].srt_nosortir+"') class='modalRow'><td>"+ result[i].srt_nosortir +"</td> <td>"+ formatDate(result[i].srt_tglsortir) +"</td> <td>"+ result[i].srt_keterangan +"</td><td>"+ result[i].srt_gudangtoko +"</td></tr>")
                        }

                        $('#idModal').val('SRT')
                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            } else {
                $('#modalThName1').text('NO.DOC');
                $('#modalThName2').text('TGL.DOC');
                $('#modalThName3').text('KETERANGAN');
                $('#modalThName4').text('PLU DI');

                $('.modalRow').remove();
                for (i = 0; i< tempSrt.length; i++){
                    if(tempSrt[i].srt_keterangan == null){
                        tempSrt[i].srt_keterangan = " ";
                    }
                    $('#tbodyModalHelp').append("<tr onclick=chooseSrt('"+ tempSrt[i].srt_nosortir+"') class='modalRow'><td>"+ tempSrt[i].srt_nosortir +"</td> <td>"+ formatDate(tempSrt[i].srt_tglsortir) +"</td> <td>"+ tempSrt[i].srt_keterangan +"</td><td>"+ tempSrt[i].srt_gudangtoko +"</td></tr>")
                }

                $('#idModal').val('SRT')
                $('#modalHelp').modal('show');
            }
        }

        function searchNmrSRT(val) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/perubahanstatus/entrySortirBarang/getnmrsrt',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('#modalThName1').text('NO.DOC');
                    $('#modalThName2').text('TGL.DOC');
                    $('#modalThName3').text('KETERANGAN');
                    $('#modalThName4').text('PLU DI');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseSrt('"+ result[i].srt_nosortir+"') class='modalRow'><td>"+ result[i].srt_nosortir +"</td> <td>"+ formatDate(result[i].srt_tglsortir) +"</td> <td>"+ result[i].srt_keterangan +"</td><td>"+ result[i].srt_gudangtoko +"</td></tr>")
                    }

                    $('#idModal').val('SRT')
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function choosePlu(kode,index) {
            for (let i =0 ; i <$('.plu').length; i++){
                if ($('.plu')[i]['attributes'][2]['value'] == index){
                    index = i
                }
            }

            $('.plu')[index].value = kode;
            $('#modalHelp').modal('hide');

            let temp        = 0;

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/perubahanstatus/entrySortirBarang/chooseplu',
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
                            $('.avgcost')[index].value = convertToRupiah(data.st_avgcost * data.prd_frac);
                            $('.ctn')[index].value = '0';
                            $('.pcs')[index].value = '0';
                            if(data.prd_perlakuanbarang === "PT"){
                                $('.pt')[index].value = 'PT';
                                $('.rttg')[index].value = '';
                            }
                            else{
                                $('.pt')[index].value = '';
                                $('.rttg')[index].value = data.prd_perlakuanbarang;
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
                        $('.plu')[index].value = data.prd_prdcd;
                        $('.deskripsi')[index].value = data.prd_deskripsipendek;
                        $('.tag')[index].value = data.prd_kodetag;
                        $('.satuan')[index].value = data.prd_unit + ' / '+ data.prd_frac;
                        $('.ctn')[index].value = '0';
                        $('.pcs')[index].value = '0';
                        if(data.prd_perlakuanbarang === "PT"){
                            $('.pt')[index].value = 'PT';
                            $('.rttg')[index].value = '';
                        }
                        else{
                            $('.pt')[index].value = '';
                            $('.rttg')[index].value = data.prd_perlakuanbarang;
                        }

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

        function getPlu(no, val) {
            $('#searchModal').val('');
            let index = no['attributes'][4]['nodeValue'];
            $('#idRow').val(index);

            if (tempPlu == null){
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/transaksi/perubahanstatus/entrySortirBarang/getplu',
                    type: 'post',
                    data: {
                        val:val
                    },
                    success: function (result) {
                        $('#modalThName1').text('Deskripsi');
                        $('#modalThName2').text('PLU');
                        $('#modalThName3').hide();

                        tempPlu = result;

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=choosePlu('"+ result[i].prd_prdcd +"','"+ index +"') class='modalRow'><td>"+ result[i].prd_deskripsipanjang +"</td> <td>"+ result[i].prd_prdcd +"</td></tr>")
                        }

                        $('#idModal').val('PLU')
                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
            else {
                $('#modalThName1').text('Deskripsi');
                $('#modalThName2').text('PLU');
                $('#modalThName3').hide();

                $('.modalRow').remove();
                for (i = 0; i< tempPlu.length; i++){
                    $('#tbodyModalHelp').append("<tr onclick=choosePlu('"+ tempPlu[i].prd_prdcd +"','"+ index +"') class='modalRow'><td>"+ tempPlu[i].prd_deskripsipanjang +"</td> <td>"+ tempPlu[i].prd_prdcd +"</td></tr>")
                }

                $('#idModal').val('PLU')
                $('#modalHelp').modal('show');
            }
        }

        function searchPlu(index, val) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/perubahanstatus/entrySortirBarang/getplu',
                type: 'post',
                data: { val:val },
                success: function (result) {
                    $('#modalThName1').text('Deskripsi');
                    $('#modalThName2').text('PLU');
                    $('#modalThName3').hide();

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=choosePlu('"+ result[i].prd_prdcd +"','"+ index +"') class='modalRow'><td>"+ result[i].prd_deskripsipanjang +"</td> <td>"+ result[i].prd_prdcd +"</td></tr>")
                    }

                    $('#idModal').val('PLU')
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function tempTable(index) {
            var temptbl =  ` <tr class="d-flex baris">
                                                <td style="width: 80px" class="text-center">
                                                    <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 150px">
                                                    <input type="text" class="form-control plu" value=""  no="`+ index +`" id="`+ index +`" onchange="searchPlu2(this.value, this.id)">
                                                     <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" onclick="getPlu(this, '')" no="`+ index +`">
                                                        <img src="../../../../../public/image/icon/help.png" width="30px">
                                                    </button>
                                                </td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi" value=""></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan" value=""></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control tag text-right" value=""></td>
                                                <td style="width: 140px"><input disabled type="text" class="form-control avgcost" value=""></td>
                                                <td style="width: 80px"><input type="text" class="form-control ctn text-right" value="" id="`+ index +`" onkeypress="return isNumberKey(event)" onchange="calculateQty(this.value, this.id)"></td>
                                                <td style="width: 80px"><input type="text" class="form-control pcs text-right" value="" id="`+ index +`" onkeypress="return isNumberKey(event)" onchange="calculateQty(this.value, this.id)"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control pt text-right" value=""></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control rttg text-right" value=""></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right" value=""></td>
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
        }
    </script>
@endsection
