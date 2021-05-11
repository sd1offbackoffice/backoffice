@extends('navbar')
@section('content')
    {{--<head>--}}
    {{--<script src="{{asset('/js/bootstrap-select.min.js')}}"></script>--}}
    {{--</head>--}}

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Header Perubahan Status Barang</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row text-right">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <div class="col-sm-2 buttonInside">
                                            <input onchange="getNmrTrn()" type="text" class="form-control" id="nomorTrn">
                                            <button id="btn-no-doc" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                    data-target="#pilihNmr">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <label for="i_nomordokumen" class="col-sm-4 col-form-label">Nomor Dokumen</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_nomordokumen" placeholder="TXT_NODOC">
                                        </div>
                                        <div class="col-sm-4 text-left" style="margin-left: -34px">
                                            <button class="btn sm-1" type="button" data-toggle="modal" onclick="getNmrRSN('')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                            <input type="checkbox" id="qtyplanogram" value="planogram"><label>&nbsp;&nbsp;Potong Qty Planogram</label>
                                        </div>
                                        <span id="printdoc" class="col-sm-2 btn btn-success btn-block" onclick="printDocument()">PRINT</span>
                                        <label for="i_tgldokumen" class="col-sm-4 col-form-label">Tanggal Dokumen</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_tgldokumen" placeholder="TXT_TGLDOC">
                                        </div>
                                        <div class="col-sm-1" style="margin-right: -34px">
                                            {{--this div just for filling space--}}
                                        </div>
                                        <input type="text" id="keterangan" class="form-control col-sm-2 text-right" disabled PLACEHOLDER="STATUS DOKUMEN">
                                        <label for="i_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_keterangan" placeholder="TXT_KETERANGAN">
                                        </div>
                                        <label for="nosortir" class="col-sm-4 col-form-label">Nomor Sortir</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_nosortir" placeholder="TXT_NOSORTIR">
                                        </div>
                                        <button class="btn sm-1" type="button" data-toggle="modal" onclick="getNmrSRT('')" style="margin-left: -20px"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_gudang" placeholder="TXT_GUDANG" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            {{--this div just for filling space--}}
                                        </div>
                                        <label for="i_tgldokumen" class="col-sm-4 col-form-label">Tanggal Sortir</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_tglsortir" placeholder="TXT_TGLSORTIR" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Detail Perubahan Status Barang</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="col-sm-12">
                            <div class="tableFixedHeader" style="border-bottom: 1px solid black">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr class="d-flex align-items-center text-center">
                                            <th style="width: 8%"><br>PLU</th>
                                            <th style="width: 42%"><br>Deskripsi</th>
                                            <th style="width: 8%"><br>Satuan</th>
                                            <th style="width: 6%"><br>PT</th>
                                            <th style="width: 6%"><br>RT/TG</th>
                                            <th style="width: 6%"><br>CTN</th>
                                            <th style="width: 6%"><br>PCS</th>
                                            <th style="width: 9%">HRG.SATUAN<br>(IN CTN)</th>
                                            <th style="width: 9%"><br>NILAI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    @for($i = 0; $i< 8; $i++)
                                        <tr class="d-flex baris">
                                            <td class="buttonInside" style="width: 8%">
                                                <input disabled="" type="text" class="form-control plu" no="{{$i}}">
                                            </td>
                                            <td style="width: 42%"><input disabled type="text" class="form-control deskripsi"></td>
                                            <td style="width: 8%"><input disabled type="text" class="form-control satuan"></td>
                                            <td style="width: 6%"><input type="text" class="form-control pt text-right" onkeypress="return isBTR(event)" maxlength="1"></td>
                                            <td style="width: 6%"><input type="text" class="form-control rttg text-right" onkeypress="return isBTR(event)" maxlength="1"></td>
                                            <td style="width: 6%"><input type="text" class="form-control ctn text-right" id="{{$i}}" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)"></td>
                                            <td style="width: 6%"><input type="text" class="form-control pcs text-right" id="{{$i}}" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control price"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control total text-right"></td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-9">
                                    <div class="row">
                                        <span class="font-weight-bold">Nilai Acost Perubahan Status Diambil dari</span>
                                    </div>
                                    <div class="row">
                                        <span class="font-weight-bold">Nilai Acost Pada Saat Melakukan Sortir Barang</span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label class="col-form-label col-sm-6 text-left">TOTAL</label>
                                    <input id="total" type="text" class="form-control col-sm-6 text-right" style="float:right" value="0" disabled>
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

    <!-- Modal SRT-->
    <div class="modal fade" id="modalHelpSRT" tabindex="-1" role="dialog" aria-labelledby="m_kodecabangHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModalSRT" class="form-control search_lov" type="text" placeholder="..." aria-label="Search">
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
                                            <th id="modalThNameSRT1"></th>
                                            <th id="modalThNameSRT2"></th>
                                            <th id="modalThNameSRT3"></th>
                                            <th id="modalThNameSRT4"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelpSRT"></tbody>
                                    </table>
                                    <p class="text-hide" id="idModalSRT"></p>
                                    <p class="text-hide" id="idRowSRT"></p>
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
        let tempRsn;
        let tempSrt;
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function isBTR(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode == 66|| charCode == 84 || charCode == 82)
                return true;
            return false;
        }

        function calculateTotal(){
            let total = 0;
            for(i = 0; i < $('.plu').length; i++){
                if ($('.plu')[i].value != ''){
                    let gross = unconvertToRupiah($('.total')[i].value);
                    total = total + parseFloat(gross);
                }
            }
            //total = total.toFixed(2);
            $('#total').val(convertToRupiah(total));
        }

        function calculateHarga(value, index) {
            let satuan    = $('.satuan')[index].value;
            let ctn     = $('.ctn')[index].value;
            let pcs     = $('.pcs')[index].value;
            let frac    = satuan.substr(satuan.indexOf('/')+1);
            let price;
            if(frac == 'KG'){
                price   = parseFloat(unconvertToRupiah($('.price')[index].value))
            }else{
                price   = parseFloat(unconvertToRupiah($('.price')[index].value))/frac;
            }
            if($('.plu')[index].value != ''){
                $('.total')[index].value = 0;
                if(ctn != 0 || ctn != ''){
                    $('.total')[index].value = parseFloat($('.total')[index].value) + parseFloat(ctn * price);
                }
                if(pcs != 0 || pcs != ''){
                    $('.total')[index].value = parseFloat($('.total')[index].value) + parseFloat((pcs/frac) * price );
                }
                $('.total')[index].value = convertToRupiah($('.total')[index].value);
            }
            calculateTotal();
        }

        function tempTable(index) {
            var temptbl =  ` <tr class="d-flex baris">
                                                <td class="buttonInside" style="width: 8%">
                                                    <input disabled type="text" class="form-control plu" value=""  no="`+ index +`" id="`+ index +`" onchange="searchPlu2(this.value, this.id)">

                                                </td>
                                                <td style="width: 42%"><input disabled type="text"  class="form-control deskripsi" value=""></td>
                                                <td style="width: 8%"><input disabled type="text" class="form-control satuan" value=""></td>
                                                <td style="width: 6%"><input disabled type="text" class="form-control pt text-right" value="" onkeypress="return isBTR(event)" maxlength="1"></td>
                                                <td style="width: 6%"><input disabled type="text" class="form-control rttg text-right" value="" onkeypress="return isBTR(event)" maxlength="1"></td>
                                                <td style="width: 6%"><input type="text" class="form-control ctn text-right" value="" id="`+ index +`" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)"></td>
                                                <td style="width: 6%"><input type="text" class="form-control pcs text-right" value="" id="`+ index +`" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)"></td>
                                                <td style="width: 9%"><input disabled type="text" class="form-control price text-right" value=""></td>
                                                <td style="width: 9%"><input disabled type="text" class="form-control total text-right" value=""></td>
                                            </tr>`

            return temptbl;
        }

        $('#i_nomordokumen').keypress(function (e) {
            if (e.which === 13) {
                let val = this.value;

                // Get New RSN Nmr
                if(val === ''){
                    swal({
                        title: 'Buat Nomor Rubah Status Baru?',
                        icon: 'info',
                        // dangerMode: true,
                        buttons: true,
                    }).then(function (confirm) {
                        if (confirm){
                            ajaxSetup();
                            $.ajax({
                                url: '/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/getnewnmrrsn',
                                type: 'post',
                                data: {},
                                beforeSend: function () {
                                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                },
                                success: function (result) {
                                    $('#i_nomordokumen').val(result);
                                    $('#i_tgldokumen').val(formatDate('now'));
                                    $('#keterangan').val('* TAMBAH');
                                    $('#totalQty').val(0);
                                    $('#modal-loader').modal('hide');
                                    $('#i_nosortir').val('');
                                    $('#i_tglsortir').val('');
                                    $('#i_gudang').val('');
                                    //$('#deleteDoc').attr( 'disabled', true );
                                    //$('#saveData').attr( 'disabled', false );
                                }, error: function (e) {
                                    alert('error');
                                    $('#modal-loader').modal('hide')
                                }
                            })
                            $('.baris').remove();
                            for (i = 0; i< 8; i++) {
                                $('#tbody').append(tempTable(i));
                            }
                        } else {
                            $('#i_nomordokumen').val('');
                            $('#keterangan').val('');
                        }
                    })
                } else {
                    chooseRsn(val);
                }
            }
        })

        $('#i_nosortir').keypress(function (e) {
            if (e.which === 13) {
                let val = this.value;

                // Get Nmr SRT
                chooseSrt(val);

            }
        })

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let idModal = $('#idModal').val();
                let idRow   = $('#idRow').val();
                let val = $('#searchModal').val().toUpperCase();
                if(idModal === 'RSN'){
                    searchNmrRSN(val)
                } else {
                    searchPlu(idRow,val)
                }
            }
        })

        $('#searchModalSRT').keypress(function (e) {
            if (e.which === 13) {
                let idModalSRT = $('#idModalSRT').val();
                let idRowSRT   = $('#idRowSRT').val();
                let val = $('#searchModalSRT').val().toUpperCase();
                if(idModalSRT === 'SRT'){
                    searchNmrSRT(val)
                } else {
                    searchPlu(idRowSRT,val)
                }
            }
        })

        function searchNmrRSN(val) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/getnmrrsn',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('#modalThName1').text('NO.DOC');
                    $('#modalThName2').text('TGL.DOC');
                    $('#modalThName3').text('KETERANGAN');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        if(result[i].msth_keterangan_header == null){
                            result[i].msth_keterangan_header = "";
                        }
                        $('#tbodyModalHelp').append("<tr onclick=chooseRsn('"+ result[i].msth_nopo+"') class='modalRow'><td>"+ result[i].msth_nopo +"</td> <td>"+ formatDate(result[i].msth_tglpo) +"</td> <td>"+ result[i].msth_keterangan_header +"</td></tr>")
                    }

                    $('#idModal').val('RSN')
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function getNmrRSN(val) {
            $('#searchModal').val('')
            if(tempRsn == null){
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/getnmrrsn',
                    type: 'post',
                    data: {
                        val:val
                    },
                    success: function (result) {
                        $('#modalThName1').text('NO.DOC');
                        $('#modalThName2').text('TGL.DOC');
                        $('#modalThName3').text('KETERANGAN');

                        tempRsn = result;
                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            if(result[i].msth_keterangan_header == null){
                                result[i].msth_keterangan_header = "";
                            }
                            $('#tbodyModalHelp').append("<tr onclick=chooseRsn('"+ result[i].msth_nopo+"') class='modalRow'><td>"+ result[i].msth_nopo +"</td> <td>"+ formatDate(result[i].msth_tglpo) +"</td> <td>"+ result[i].msth_keterangan_header +"</td></tr>")
                        }

                        $('#idModal').val('RSN')
                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            } else {
                $('#modalThName1').text('NO.DOC');
                $('#modalThName2').text('TGL.DOC');
                $('#modalThName3').text('KETERANGAN');

                $('.modalRow').remove();
                for (i = 0; i< tempRsn.length; i++){
                    if(tempRsn[i].msth_keterangan_header == null){
                        tempRsn[i].msth_keterangan_header = " ";
                    }
                    $('#tbodyModalHelp').append("<tr onclick=chooseRsn('"+ tempRsn[i].msth_nopo+"') class='modalRow'><td>"+ tempRsn[i].msth_nopo +"</td> <td>"+ formatDate(tempRsn[i].msth_tglpo) +"</td> <td>"+ tempRsn[i].msth_keterangan_header +"</td></tr>")
                }

                $('#idModal').val('RSN')
                $('#modalHelp').modal('show');
            }
        }

        function searchNmrSRT(val) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/getnmrsrt',
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
                        $('#tbodyModalHelpSRT').append("<tr onclick=chooseSrt('"+ result[i].srt_nosortir+"') class='modalRow'><td>"+ result[i].srt_nosortir +"</td> <td>"+ formatDate(result[i].srt_tglsortir) +"</td> <td>"+ result[i].srt_keterangan +"</td><td>"+ result[i].srt_gudangtoko +"</td></tr>")
                    }

                    $('#idModalSRT').val('SRT')
                    $('#modalHelpSRT').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function getNmrSRT(val) {
            $('#searchModalSRT').val('')
            if(tempSrt == null){
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/getnmrsrt',
                    type: 'post',
                    data: {
                        val:val
                    },
                    success: function (result) {
                        $('#modalThNameSRT1').text('NO.DOC');
                        $('#modalThNameSRT2').text('TGL.DOC');
                        $('#modalThNameSRT3').text('KETERANGAN');
                        $('#modalThNameSRT4').text('PLU DI');

                        tempSrt = result;
                        $('.modalRowSRT').remove();
                        for (i = 0; i< result.length; i++){
                            if(result[i].srt_keterangan == null){
                                result[i].srt_keterangan = " ";
                            }
                            $('#tbodyModalHelpSRT').append("<tr onclick=chooseSrt('"+ result[i].srt_nosortir+"') class='modalRow'><td>"+ result[i].srt_nosortir +"</td> <td>"+ formatDate(result[i].srt_tglsortir) +"</td> <td>"+ result[i].srt_keterangan +"</td><td>"+ result[i].srt_gudangtoko +"</td></tr>")
                        }

                        $('#idModalSRT').val('SRT')
                        $('#modalHelpSRT').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            } else {
                $('#modalThNameSRT1').text('NO.DOC');
                $('#modalThNameSRT2').text('TGL.DOC');
                $('#modalThNameSRT3').text('KETERANGAN');
                $('#modalThNameSRT4').text('PLU DI');

                $('.modalRowSRT').remove();
                for (i = 0; i< tempSrt.length; i++){
                    if(tempSrt[i].srt_keterangan == null){
                        tempSrt[i].srt_keterangan = " ";
                    }
                    $('#tbodyModalHelpSRT').append("<tr onclick=chooseSrt('"+ tempSrt[i].srt_nosortir+"') class='modalRow'><td>"+ tempSrt[i].srt_nosortir +"</td> <td>"+ formatDate(tempSrt[i].srt_tglsortir) +"</td> <td>"+ tempSrt[i].srt_keterangan +"</td><td>"+ tempSrt[i].srt_gudangtoko +"</td></tr>")
                }

                $('#idModalSRT').val('SRT')
                $('#modalHelpSRT').modal('show');
            }
        }

        function chooseRsn(kode) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/choosersn',
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
                        for (i = 0; i< 7; i++) {
                            $('#tbody').append(tempTable());
                        }
                    } else {
                        $('#i_nomordokumen').val(result[0].msth_nopo);
                        $('#i_tgldokumen').val(formatDate(result[0].msth_tgldoc));
                        $('#i_keterangan').val(result[0].msth_keterangan_header);
                        $('#i_nosortir').val(result[0].msth_nofaktur);
                        if (result[0].nota === 'Data Sudah Dicetak') {
                            $('#keterangan').val(result[0].nota);
                            //$('#addNewRow').attr('disabled', true);
                        }else{
                            $('#keterangan').val('*KOREKSI*');
                            //$('#addNewRow').attr( 'disabled', false);
                        }
                        chooseSrt("fromRsn");
                        }
                    $('#modal-loader').modal('hide');
                    //calculateTotal();
                }, error: function (e) {
                    alert('error');
                    $('#modal-loader').modal('hide');
                }
            })
            $('#modalHelp').modal('hide')
        }

        function chooseSrt(kode) {
            let fromRsn = false;
            if(kode == "fromRsn"){
                kode = $('#i_nosortir').val();
                fromRsn = true;
            }
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/choosesrt',
                type: 'post',
                data: {
                    kode:kode
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    //from Rsn
                    if(fromRsn){
                        if(result.length === 0){
                            swal('', "Nomor Dokumen Sortir Tidak Ada !!", 'warning');
                        }else{
                            $('#i_tglsortir').val(formatDate(result[0].srt_tglsortir));
                            if(result[0].srt_gudangtoko == 'G'){
                                $('#i_gudang').val("GUDANG");
                            }else{
                                $('#i_gudang').val("TOKO");
                            }
                            $('.baris').remove();
                            for (i = 0; i< result.length; i++) {
                                let tempPT = "";
                                let tempRT = "";
                                let temppcs = 0;
                                let tempktn = 0;
                                tempPT = "B";
                                if(result[i].hgb_statusbarang = "PT"){
                                    tempRT = "R"
                                }else if(result[i].hgb_statusbarang = "RT"){
                                    tempRT = "T"
                                }else if(result[i].hgb_statusbarang = "TG"){
                                    tempRT = "T"
                                }else if(result[i].sup_flagpenangananproduk = "PT"){
                                    tempRT = "R"
                                }else if(result[i].sup_flagpenangananproduk = "RT"){
                                    tempRT = "T"
                                }else if(result[i].sup_flagpenangananproduk = "TG"){
                                    tempRT = "T"
                                }
                                if(result[i].srt_qtykarton != null){
                                    tempktn = parseInt(result[i].srt_qtykarton);
                                }
                                if(result[i].srt_qtypcs != null){
                                    temppcs = parseInt(result[i].srt_qtypcs);
                                }
                                if($('#keterangan').val() === "Data Sudah Dicetak"){
                                    let temp =  ` <tr class="d-flex baris">
                                            <td class="buttonInside" style="width: 8%">
                                                <input disabled type="text" class="form-control plu" value="`+ result[i].srt_prdcd +`">
                                            </td>
                                            <td style="width: 42%"><input disabled type="text"  class="form-control deskripsi" value="`+ result[i].prd_deskripsipanjang +`"></td>
                                            <td style="width: 8%"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                            <td style="width: 6%"><input disabled type="text"  class="form-control pt text-right" value="`+ tempPT +`" onkeypress="return isBTR(event)" maxlength="1"></td>
                                            <td style="width: 6%"><input disabled type="text"  class="form-control rttg text-right" value="`+ tempRT +`" onkeypress="return isBTR(event)" maxlength="1"></td>
                                            <td style="width: 6%"><input disabled type="text" class="form-control ctn text-right" id="`+ i +`" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)" value="` + tempktn +`"></td>
                                            <td style="width: 6%"><input disabled type="text" class="form-control pcs text-right" id="`+ i +`" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)" value="` + temppcs +`"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control price text-right" value="`+ convertToRupiah(result[i].srt_hrgsatuan) +`"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control total text-right" value="` + convertToRupiah(parseFloat(result[i].srt_hrgsatuan * (temppcs/result[i].prd_frac))+ parseFloat(result[i].srt_hrgsatuan * tempktn)) +`"></td>
                                        </tr>`
                                    $('#tbody').append(temp);
                                }else{
                                    let temp =  ` <tr class="d-flex baris">
                                            <td class="buttonInside" style="width: 8%">
                                                <input disabled type="text" class="form-control plu" value="`+ result[i].srt_prdcd +`">
                                            </td>
                                            <td style="width: 42%"><input disabled type="text"  class="form-control deskripsi" value="`+ result[i].prd_deskripsipanjang +`"></td>
                                            <td style="width: 8%"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                            <td style="width: 6%"><input type="text"  class="form-control pt text-right" value="`+ tempPT +`" onkeypress="return isBTR(event)" maxlength="1"></td>
                                            <td style="width: 6%"><input type="text"  class="form-control rttg text-right" value="`+ tempRT +`" onkeypress="return isBTR(event)" maxlength="1"></td>
                                            <td style="width: 6%"><input type="text" class="form-control ctn text-right" id="`+ i +`" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)" value="` + tempktn +`"></td>
                                            <td style="width: 6%"><input type="text" class="form-control pcs text-right" id="`+ i +`" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)" value="` + temppcs +`"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control price text-right" value="`+ convertToRupiah(result[i].srt_hrgsatuan) +`"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control total text-right" value="` + convertToRupiah(parseFloat(result[i].srt_hrgsatuan * (temppcs/result[i].prd_frac))+ parseFloat(result[i].srt_hrgsatuan * tempktn)) +`"></td>
                                        </tr>`
                                    $('#tbody').append(temp);
                                }

                            }
                        }calculateTotal();return;
                    }

                    //new Srt
                    if(result.length === 0){
                        swal('', "Nomor Dokumen Sortir Tidak Ada !!", 'warning');
                    }else if(result[0].srt_flagdisc3 === 'P'){
                        swal('', "Nomor Dokumen Sortir Telah Diproses !!", 'warning');
                    }
                    else{
                        $('#i_nosortir').val(result[0].srt_nosortir);
                        $('#i_tglsortir').val(formatDate(result[0].srt_tglsortir));
                        if(result[0].srt_gudangtoko == 'G'){
                            $('#i_gudang').val("GUDANG");
                        }else{
                            $('#i_gudang').val("TOKO");
                        }

                        $('.baris').remove();
                        for (i = 0; i< result.length; i++) {
                            let tempPT = "";
                            let tempRT = "";
                            let temppcs = 0;
                            let tempktn = 0;
                            tempPT = "B";
                            // if(result[i].prd_perlakuanbarang === "PT"){
                            //     tempPT = "PT"
                            // }
                            // else{
                            //     tempRT = result[i].prd_perlakuanbarang;
                            // }
                            if(result[i].hgb_statusbarang = "PT"){
                                tempRT = "R"
                            }else if(result[i].hgb_statusbarang = "RT"){
                                tempRT = "T"
                            }else if(result[i].hgb_statusbarang = "TG"){
                                tempRT = "T"
                            }else if(result[i].sup_flagpenangananproduk = "PT"){
                                tempRT = "R"
                            }else if(result[i].sup_flagpenangananproduk = "RT"){
                                tempRT = "T"
                            }else if(result[i].sup_flagpenangananproduk = "TG"){
                                tempRT = "T"
                            }
                            if(result[i].srt_qtykarton != null){
                                tempktn = parseInt(result[i].srt_qtykarton);
                            }
                            if(result[i].srt_qtypcs != null){
                                temppcs = parseInt(result[i].srt_qtypcs);
                            }
                            let temp =  ` <tr class="d-flex baris">
                                            <td class="buttonInside" style="width: 8%">
                                                <input disabled type="text" class="form-control plu" value="`+ result[i].srt_prdcd +`">
                                            </td>
                                            <td style="width: 42%"><input disabled type="text"  class="form-control deskripsi" value="`+ result[i].prd_deskripsipanjang +`"></td>
                                            <td style="width: 8%"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                            <td style="width: 6%"><input type="text"  class="form-control pt text-right" value="`+ tempPT +`" onkeypress="return isBTR(event)" maxlength="1"></td>
                                            <td style="width: 6%"><input type="text"  class="form-control rttg text-right" value="`+ tempRT +`" onkeypress="return isBTR(event)" maxlength="1"></td>
                                            <td style="width: 6%"><input type="text" class="form-control ctn text-right" id="`+ i +`" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)" value="` + tempktn +`"></td>
                                            <td style="width: 6%"><input type="text" class="form-control pcs text-right" id="`+ i +`" onkeypress="return isNumberKey(event)" onchange="calculateHarga(this.value, this.id)" value="` + temppcs +`"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control price text-right" value="`+ convertToRupiah(result[i].srt_hrgsatuan) +`"></td>
                                            <td style="width: 9%"><input disabled type="text" class="form-control total text-right" value="` + convertToRupiah(parseFloat(result[i].srt_hrgsatuan * (temppcs/result[i].prd_frac))+ parseFloat(result[i].srt_hrgsatuan * tempktn)) +`"></td>
                                        </tr>`

                            $('#tbody').append(temp);
                        }
                    }
                    $('#modal-loader').modal('hide');
                    calculateTotal();
                }, error: function () {
                    alert('error');
                    $('#modal-loader').modal('hide');
                }
            })
            $('#modalHelpSRT').modal('hide')
        }

        function printDocument(){
            let doc         = $('#i_nomordokumen').val();
            let keterangan  = $('#keterangan').val();
            let docSort     = $('#i_nosortir').val();

            if (!doc || !keterangan || !docSort){
                swal('Data Tidak Boleh Kosong','','warning')
                return false;
            }

            if(doc && docSort && keterangan === '* TAMBAH' || doc && docSort && keterangan === '*KOREKSI*'){
                saveData('cetak');
            } else {
                window.open('url(\'/bo/transaksi/pengeluaran/inqueryrtrsup/get-data-detail\')transaksi/perubahanstatus/rubahStatus/printdoc/'+doc+'/','_blank');

                ajaxSetup();
                $.ajax({
                    type: "post",
                    url: "/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/checkrak",
                    data: {noDoc:doc},
                    success: function (result) {
                        if(result.rak == '1'){
                            window.open('/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/printdocrak/'+doc+'/','_blank');
                        }
                    }
                });

                clearField();
            }
        }

        // function printDocumentRak() {
        //     let doc         = $('#i_nomordokumen').val();
        //     window.open('/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/printdocrak/'+doc+'/','_blank');
        // }

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
        function focusToRowfd(index) {
            // swal('QTYB + QTYK < = 0','', 'warning')
            swal({
                title:'There is something wrong',
                text: ' ',
                icon:'warning',
                timer: 1000,
                buttons: {
                    confirm: false,
                },
            });
            $('.pt')[index].focus()
        }

        function clearField() {
            $('input').val('')
            $('.baris').remove();

            for (i = 0; i< 8; i++) {
                $('#tbody').append(tempTable(i));
            }

            //    Memperbaharui LOV Nomor SRT
            tempSrt = null;
            tempRsn = null;

        }

        function saveData(status){
            let tempPlu  = $('.plu');
            let tempDate= $('#i_tgldokumen').val();
            let noDoc   = $('#i_nomordokumen').val();
            let tglDoc = $('#i_tgldokumen').val();
            let noSort   = $('#i_nosortir').val();
            let tglSort   = $('#i_tglsortir').val();
            let keterangan    = $('#i_keterangan').val();
            let date    = tempDate.substr(3,2) + '/'+ tempDate.substr(0,2)+ '/'+ tempDate.substr(6,4);
            let dateSort    = tglSort.substr(3,2) + '/'+ tglSort.substr(0,2)+ '/'+ tglSort.substr(6,4);
            let gt    = $('.i_gudang').val();

            let plano    = $('#qtyplanogram').val();
            let datas   = [{'mstd_prdcd' : '', 'flagdisc1' : '', 'flagdisc2' : '', 'mstd_qty' : '', 'mstd_desc' : '' ,'gross' : ''}];
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
                let arr     = temp.split(" / ");
                let unit    = arr[0];
                let fd1     = $('.pt')[i].value;
                let fd2     = $('.rttg')[i].value;
                let frac    = temp.substr(temp.indexOf('/')+1);
                let ctn     = parseInt( $('.ctn')[i].value);
                let pcs     = parseInt( $('.pcs')[i].value);
                let desc    = $('.deskripsi')[i].value;


                if ( tempPlu[i].value){
                    qty  = (ctn * parseInt(frac) + pcs);

                    if (qty < 1){
                        focusToRow(i);
                        return false;
                    }
                    // if(fd1 == '' && fd2 == '' || fd1 == null && fd2 == null || fd1 != null && fd2 != null){
                    //     focusToRowfd(i);
                    //     return false;
                    // }
                    if(fd1 == null && fd2 == null){
                        focusToRowfd(i);
                        return false;
                    }
                    datas.push({'mstd_prdcd': $('.plu')[i].value, 'flagdisc1' : fd1 , 'flagdisc2' : fd2 ,'mstd_qty' : qty, 'mstd_desc' : desc, 'gross' : unconvertToRupiah($('.total')[i].value)})
                }
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/savedata',
                type: 'post',
                data: {
                    datas:datas,
                    date:date,
                    keterangan:keterangan,
                    noDoc:noDoc,
                    tglDoc:tglDoc,
                    noSort:noSort,
                    tglSort:tglSort,
                    statusPlano:plano,
                    gudangtoko:gt

                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if(result.kode == '1'){
                        if (status == 'cetak'){
                            window.open('/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/printdoc/'+result.msg+'/','_blank');
                            $.ajax({
                                type: "post",
                                url: "/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/checkrak",
                                data: {noDoc:noDoc},
                                success: function (result) {
                                    if(result.rak == '1'){
                                        window.open('/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/printdocrak/'+result.msg+'/','_blank');
                                    }
                                }
                            });
                            clearField();
                        } else {
                            swal('Dokumen Berhasil disimpan','','success')
                        }
                    } else if(result.kode == '2'){
                        swal('', result.msg, 'warning');
                    } else if(result.kode == '3'){
                        swal('Revisi Tidak Diperkenankan Lagi Karena Data Sudah Dicetak !!');
                        window.open('/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/printdoc/'+result.msg+'/','_blank');
                        $.ajax({
                            type: "post",
                            url: "/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/checkrak",
                            data: {noDoc:noDoc},
                            success: function (result) {
                                if(result.rak == '1'){
                                    window.open('/BackOffice/public/bo/transaksi/perubahanstatus/rubahStatus/printdocrak/'+result.msg+'/','_blank');
                                }
                            }
                        });
                        clearField();
                    }else {
                        swal('ERROR', "Something's Error", 'error');
                    }
                    $('#modal-loader').modal('hide')
                    $('#pilihan').val('M');
                    //$('#saveData').attr("disabled", true)
                    clearField();
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }
    </script>
@endsection
