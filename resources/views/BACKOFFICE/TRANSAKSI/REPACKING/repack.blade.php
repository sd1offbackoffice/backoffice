@extends('navbar')
@section('title','TRANSAKSI | REPACKING')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card">
                    <legend class="w-auto ml-5">.:: [Header] ::.</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="col-sm-12">
                            <div class="form-group row mb-0">
                                <label class="col-sm-1 col-form-label" for="nomorTrn">NOMOR TRN</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="nomorTrn">
                                    <button onclick="getNmrTrn('')" id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <label class="col-sm-1 col-form-label text-right" for="tanggalTrn">TANGGAL TRN</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tanggalTrn" placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="keterangan" class="col-sm-1 col-form-label">KETERANGAN</label>
                                <div class="col-sm-5">
                                    <input class="form-control" id="keterangan" type="text">
                                </div>

                                <button class="btn btn-danger col-sm-2 btn-block" type="button">
                                    HAPUS DOKUMEN
                                </button>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="perubahanPlu" class="col-sm-1 col-form-label">PERUBAHAN PLU</label>
                                <div class="col-sm-2">
                                    <input class="form-control" id="perubahanPlu" type="text" onkeypress="return isY(event)" onchange="perubahanPluChecker()" maxlength="1">
                                </div>
                                <span style="margin-top: 8px" style="word-spacing: 2px">&nbsp;&nbsp;[&nbsp;/&nbsp;Y&nbsp;]&nbsp;&nbsp;</span>
                                <div class="col-sm-6" style="margin-top: 10px">
                                    <label class="radio-inline">
                                        <input class="radio rVal" type="radio" name="optradio" value="R" checked>Re-packing
                                    </label>
                                    <label class="radio-inline">
                                        <input class="radio pVal" type="radio" name="optradio" value="P">Pre-packing
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <div class="col-sm-2 text-center">
                                <button type="button" class="btn btn-success btn-block" style="width: 200px; margin-top: -120px; height: 60px">PRINT</button>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <input readonly type="text" id="jenisKertas" value="Kecil">
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" onclick="dropdownBiasa()">Biasa</a>
                                    <a class="dropdown-item" onclick="dropdownKecil()">Kecil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <fieldset class="card">
                        <legend class="w-auto ml-5">.:: [DETAIL] ::.</legend>
                        <div class="card-body shadow-lg cardForm">

                            <div class="p-0 tableFixedHeader" style="height: 250px;">
                                <table class="table table-sm table-striped table-bordered"
                                       id="table-header">
                                    <thead>
                                    <tr class="table-sm text-center">
                                        <th width="3%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="3%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="10%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="20%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="10%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="3%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="8%" colspan="2" class="text-center small">STOCK</th>
                                        <th width="8%" colspan="2" class="text-center small">KUANTUM</th>
                                        <th width="12%" class="text-center small">HRG.SATUAN</th>
                                        <th width="13%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="10%" style="background-color: white; border: none" class="text-center small"></th>
                                    </tr>
                                    <tr class="table-sm text-center">
                                        <th width="3%" class="text-center small"></th>
                                        <th width="3%" class="text-center small">P/R</th>
                                        <th width="10%" class="text-center small">PLU</th>
                                        <th width="20%" class="text-center small">DESKRIPSI</th>
                                        <th width="10%" class="text-center small">SATUAN</th>
                                        <th width="3%" class="text-center small">TAG</th>
                                        <th width="4%" class="text-center small">CTN</th>
                                        <th width="4%" class="text-center small">PCS</th>
                                        <th width="4%" class="text-center small">CTN</th>
                                        <th width="4%" class="text-center small">PCS</th>
                                        <th width="12%" class="text-center small">(IN CTN)</th>
                                        <th width="13%" class="text-center small">GROSS</th>
                                        <th width="10%" class="text-center small">PPN</th>
                                    </tr>
                                    </thead>
                                    <tbody id="body-table-header" style="height: 250px;">
                                    @for($i = 0 ; $i< 10 ; $i++)
                                        <tr class="baris">
                                            <td>
                                                <button class="btn btn-block btn-sm btn-danger btn-delete-row-header"><i
                                                            class="icon fas fa-times"></i></button>
                                            </td>
                                            <td>
                                                <input onkeypress="return isPR(event)" onchange="PRchecker()" maxlength="1" class="form-control pr"
                                                       type="text">
                                            </td>
                                            <td class="buttonInside" style="width: 150px;">
                                                <input type="text" class="form-control plu" value="" no="{{$i}}">
                                                <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" onclick="getPlu(this, '')" no="{{$i}}">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            <td>
                                                <input disabled class="form-control deskripsi"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control satuan"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control tag"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control ctn-stock"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control pcs-stock"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input class="form-control ctn-header ctn-kuantum"
                                                       rowheader=1
                                                       type="text">
                                            </td>
                                            <td>
                                                <input class="form-control pcs-header pcs-kuantum"
                                                       rowheader=1
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control hrg-satuan"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control gross"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control ppn"
                                                       type="text">
                                            </td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                            <input style="margin-left: 200px" class="col-sm-6" readonly type="text" id="deskripsi">
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <fieldset class="card">
                        <div class="card-body shadow-lg cardForm">

                            <div class="d-flex justify-content-end">
                                <label for="preItem" class="font-weight-normal" style="margin-right: 10px;">PRE-PACKING ITEM</label>
                                <input readonly id="preItem" type="text" style="margin-right: 30px" value="0">

                                <label for="preGross" class="font-weight-normal" style="margin-right: 10px;">PRE-PACKING GROSS</label>
                                <input readonly id="preGross" type="text" style="margin-right: 30px" value="0">

                                <label for="ppnAlt" class="font-weight-normal" style="margin-right: 10px;">PPN</label>
                                <input readonly id="ppnAlt" type="text" value="0">
                            </div>

                            <div class="d-flex justify-content-end">
                                <label for="preItem" class="font-weight-normal" style="margin-right: 10px;">RE-PACKING ITEM</label>
                                <input readonly id="reItem" type="text" style="margin-right: 39px" value="0">

                                <label for="reGross" class="font-weight-normal" style="margin-right: 10px;">RE-PACKING GROSS</label>
                                <input readonly id="reGross" type="text" style="margin-right: 16px" value="0">

                                <label for="ppnAlt" class="font-weight-normal" style="margin-right: 10px;">TOTAL</label>
                                <input readonly id="total" type="text" value="0">
                            </div>

                            <div class="d-flex justify-content-end">
                                <label for="totItem" class="font-weight-normal" style="margin-right: 10px;">TOTAL ITEM</label>
                                <input readonly id="totItem" type="text" style="margin-right: 84px" value="0">

                                <label for="totGross" class="font-weight-normal" style="margin-right: 10px;">TOTAL GROSS</label>
                                <input readonly id="totGross" type="text" style="margin-right: 258px" value="0">

                                {{--<button hidden id="hiddenSaveButton" type="button" onclick="saveMe()"></button>--}}

                            </div>
                            <div class="d-flex justify-content-start">
                                <span style="font-weight: bold">Ctrl+S : Simpan Data</span>
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

    </div>
    <style>
        #jenisKertas:hover{
            cursor: pointer;
        }
        .dropdown-item:hover{
            cursor: pointer;
        }
    </style>
    <script>
        let tempTrn;
        let tempPlu;

        let saveBool = true;
        let model;
        let noDoc;
        let tglDoc;
        let noReff;
        let tglReff;
        let keterangan;
        let rubahPlu;
        let group_option;
        let trbo_flagdoc;
        let noDocPrint;
        let noUrut;
        let deskripsiPanjang = {};
        let trbo_averagecost = {};
        let parameterR = 0;


        $('#tanggalTrn').datepicker({
            format: 'dd/mm/yyyy'
        });
        function dropdownBiasa(){
            $('#jenisKertas').val('Biasa');
        }
        function dropdownKecil() {
            $('#jenisKertas').val('Kecil');
        }

        function isY(evt){
            $('#perubahanPlu').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 121)
                return 89;

            if (charCode == 89)
                return true;
            return false;
        }
        function perubahanPluChecker() {
            group_option = 'R';
            if($('#perubahanPlu').val() == 'Y'){
                $('.rVal').prop('checked',true);
                $('.radio').attr('disabled','disabled');
            }else{
                $('.radio').removeAttr('disabled');
            }
        }

        function isPR(evt){
            $('.pr').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 114)
                return 82;
            else if (charCode == 112)
                return 80;

            if (charCode == 82 || charCode == 80)
                return true;
            return false;
        }

        function PRchecker(){
            if($('#perubahanPlu').val() != 'Y'){
                let counter = 1;
                let index = 0;
                if($('.rVal').is(':checked')){
                    for(i = 0; i < $('.pr').length; i++){
                        if ($('.pr')[i].value == 'R'){
                            counter--;
                            if(index == 0)
                                index = i;
                        }
                        if(counter<0){
                            swal({
                                title:'Re-Packing',
                                text: 'Sudah ada item re-packing, tidak bisa tambah data lagi',
                                icon:'warning',
                                timer: 2000,
                                buttons: {
                                    confirm: false,
                                },
                            });
                            $('.pr')[index].value = '';
                            $('.pr')[index].focus();
                            break
                        }
                    }
                }else{
                    for(i = 0; i < $('.pr').length; i++){
                        if ($('.pr')[i].value == 'P'){
                            counter--;
                            if(index == 0)
                                index = i;
                        }
                        if(counter<0){
                            swal({
                                title:'Re-Packing',
                                text: 'Sudah ada item pre-packing, tidak bisa tambah data lagi',
                                icon:'warning',
                                timer: 2000,
                                buttons: {
                                    confirm: false,
                                },
                            });
                            $('.pr')[index].value = '';
                            $('.pr')[index].focus();
                            break
                        }
                    }
                }
            }
        }

        $(window).bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                switch (String.fromCharCode(event.which).toLowerCase()) {
                    case 's':
                        event.preventDefault();
                        //$('#hiddenSaveButton').click();
                        //alert('ctrl-s');
                        saveMe();
                        break;
                    case 'S':
                        event.preventDefault();
                        //$('#hiddenSaveButton').click();
                        saveMe();
                        break;
                }
            }
        });

        function saveMe() {
            alert("save!");
            //$('.plu')[0].value = 'surprise';
        }

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let idModal = $('#idModal').val();
                let idRow   = $('#idRow').val();
                let val = $('#searchModal').val().toUpperCase();
                if(idModal === 'TRN'){
                    searchNmrTrn(val)
                } else {
                    searchPlu(idRow,val)
                }
            }
        });

        $('.plu').change(function () {

            let row = $(this).attr('no');
            let val = convertPlu($(this).val());
            if($('.plu')[row].value != ''){
                if($('.pr')[row].value === '' || $('.pr')[row].value == null){
                    $('.plu')[row].value = '';
                    swal('', "Isi kolom P/R dahulu !!", 'warning');
                    return false;
                }else{
                    choosePlu(val,row);
                }
            }

        });

        function searchNmrTrn(val) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/transaksi/repacking/getNmrTrn',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('#modalThName1').text('NO.LIST');
                    $('#modalThName2').text('TGL.LIST');
                    $('#modalThName3').text('NO.NOTA');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseTrn('"+ result[i].trbo_nodoc+"') class='modalRow'><td>"+ result[i].trbo_nodoc +"</td> <td>"+ formatDate(result[i].trbo_tgldoc) +"</td> <td>"+ result[i].nota +"</td></tr>")
                    }

                    $('#idModal').val('TRN')
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        $('#nomorTrn').keypress(function (e) {
            if (e.which === 13) {
                let val = this.value;

                // Get New TRN Nmr
                if(val === ''){
                    swal({
                        title: 'Buat Nomor Transaksi Baru?',
                        icon: 'info',
                        // dangerMode: true,
                        buttons: true,
                    }).then(function (confirm) {
                        if (confirm){
                            ajaxSetup();
                            $.ajax({
                                url: '/BackOffice/public/transaksi/repacking/getNewNmrTrn',
                                type: 'post',
                                data: {},
                                beforeSend: function () {
                                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                },
                                success: function (result) {
                                    $('#nomorTrn').val(result.noDoc);
                                    noDoc = result.noDoc;
                                    $('#tanggalTrn').val(formatDate('now'));
                                    tglDoc = formatDate('now');
                                    model = result.model;
                                    noReff = result.noReff;
                                    $('#modal-loader').modal('hide')
                                }, error: function () {
                                    alert('error');
                                    //$('#modal-loader').modal('hide');
                                }
                            })
                            // $('.baris').remove();
                            // for (i = 0; i< 8; i++) {
                            //     $('#tbody').append(tempTable(i));
                            // }
                        } else {
                            $('#nomorTrn').val('');
                        }
                    })
                } else {
                    chooseTrn(val);
                }
            }
        });

        function getNmrTrn(val) {
            $('#searchModal').val('')
            if(tempTrn == null){
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/transaksi/repacking/getNmrTrn',
                    type: 'post',
                    data: {
                        val:val
                    },
                    success: function (result) {
                        $('#modalThName1').text('NO.LIST');
                        $('#modalThName2').text('TGL.LIST');
                        $('#modalThName3').text('NO.NOTA');

                        tempTrn = result;
                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseTrn('"+ result[i].trbo_nodoc+"') class='modalRow'><td>"+ result[i].trbo_nodoc +"</td> <td>"+ formatDate(result[i].trbo_tgldoc) +"</td> <td>"+ result[i].nota +"</td></tr>")
                        }

                        $('#idModal').val('TRN')
                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            } else {
                $('#modalThName1').text('NO.LIST');
                $('#modalThName2').text('TGL.LIST');
                $('#modalThName3').text('NO.NOTA');

                $('.modalRow').remove();
                for (i = 0; i< tempTrn.length; i++){
                    $('#tbodyModalHelp').append("<tr onclick=chooseTrn('"+ tempTrn[i].trbo_nodoc+"') class='modalRow'><td>"+ tempTrn[i].trbo_nodoc +"</td> <td>"+ formatDate(tempTrn[i].trbo_tgldoc) +"</td> <td>"+ tempTrn[i].nota +"</td></tr>")
                }

                $('#idModal').val('TRN')
                $('#modalHelp').modal('show');
            }
        }

        function chooseTrn(a){
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/transaksi/repacking/chooseTrn',
                type: 'post',
                data: {
                    kode:a
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (rec) {
                    $('.baris').remove();

                    if(rec.length != 0) {
                        noDoc = rec[0].trbo_nodoc;
                        $('#nomorTrn').val(noDoc);
                        tglDoc = formatDate(rec[0].trbo_tgldoc);
                        $('#tanggalTrn').val(tglDoc);
                        noReff = rec[0].trbo_noreff;
                        tglReff = rec[0].trbo_tglreff;
                        keterangan = rec[0].trbo_keterangan;
                        $('#keterangan').val(keterangan);
                        rubahPlu = rec[0].trbo_flagdisc3;
                        $('#perubahanPlu').val(rubahPlu);
                        perubahanPluChecker();
                        if(rec[0].trbo_flagdisc2 == 'R'){
                            $('.rVal').attr('checked',true);
                            $('.pVal').attr('checked',false);
                        }else{
                            $('.pVal').attr('checked',true);
                            $('.rVal').attr('checked',false);
                        }
                        group_option = rec[0].trbo_flagdisc2;
                        model = '* KOREKSI *';
                        trbo_flagdoc = rec[0].trbo_flagdoc;
                        noDocPrint = rec[0].nota;
                        //noUrut = rec[0].trbo_seqno + 1;
                        for (i = 0; i< rec.length; i++) {
                            $('#body-table-header').append(tempTable());
                            $('.pr')[i].value = rec[i].trbo_flagdisc1;
                            $('.plu')[i].value = rec[i].trbo_prdcd;
                            $('.deskripsi')[i].value = rec[i].prd_deskripsipendek;
                            deskripsiPanjang[i] = rec[i].prd_deskripsipanjang;
                            $('.satuan')[i].value = (rec[i].prd_unit).concat("/",(rec[i].prd_frac));
                            $('.tag')[i].value = rec[i].prd_kodetag;
                            $('.ctn-stock')[i].value = parseInt((rec[i].st_saldoakhir)/(rec[i].prd_frac));
                            $('.pcs-stock')[i].value = (rec[i].st_saldoakhir)%(rec[i].prd_frac);
                            $('.ctn-kuantum')[i].value = parseInt((rec[i].trbo_qty)/(rec[i].prd_frac));
                            $('.pcs-kuantum')[i].value = (rec[i].trbo_qty)%(rec[i].prd_frac);
                            $('.hrg-satuan')[i].value = rec[i].trbo_hrgsatuan;
                            $('.gross')[i].value = rec[i].trbo_gross;
                            $('.ppn')[i].value = rec[i].trbo_ppnrph;
                        }
                        if (model == '* KOREKSI *') {
                            if (trbo_flagdoc == '*') {
                                model = '* NOTA SUDAH DICETAK *';
                                saveBool = false;
                                //disable savedata dan update data
                                $('.baris td input').attr('disabled','disabled');
                                $('.baris td button').attr('hidden',true);
                            } else {
                                saveBool = true;
                                //enable savedata dan update data
                                $('.baris td .pr').removeAttr('disabled');
                                $('.baris td .plu').removeAttr('disabled');
                                $('.baris td .ctn-kuantum').removeAttr('disabled');
                                $('.baris td .pcs-kuantum').removeAttr('disabled');
                                $('.baris td button').removeAttr('hidden');
                                $('.pr').removeAttr('disabled');
                                $('.plu').removeAttr('disabled');
                                $('.ctn-kuantum').removeAttr('disabled');
                                $('.pcs-kuantum').removeAttr('disabled');
                            }
                        } else {
                            saveBool = true;
                            //enable savedata dan update data
                            $('.baris td button').removeAttr('hidden');
                            $('.pr').removeAttr('disabled');
                            $('.plu').removeAttr('disabled');
                            $('.ctn-kuantum').removeAttr('disabled');
                            $('.pcs-kuantum').removeAttr('disabled');
                        }
                    }else{
                        for (i = 0; i< 10; i++) {
                            $('#body-table-header').append(tempTable());
                        }
                    }
                    $('#modalHelp').modal('hide');
                    $('#modal-loader').modal('hide');
                }, error: function () {
                }
            })
        }

        function getPlu(no, val) {
            $('#searchModal').val('');
            let index = no['attributes'][4]['nodeValue'];

            if($('.pr')[index].value === '' || $('.pr')[index].value == null){
                swal('', "Isi kolom P/R dahulu !!", 'warning');
                return false;
            }
            $('#idRow').val(index);

            if (tempPlu == null){
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/transaksi/repacking/getPlu',
                    type: 'post',
                    data: {
                        val:val
                    },
                    success: function (result) {
                        $('#modalThName1').text('Deskripsi');
                        $('#modalThName2').text('PLU');
                        $('#modalThName3').text('Satuan');

                        tempPlu = result;

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=choosePlu('"+ result[i].prd_prdcd +"','"+ index +"') class='modalRow'><td>"+ result[i].prd_deskripsipanjang +"</td> <td>"+ result[i].prd_prdcd +"</td> <td>"+ result[i].satuan +"</td></tr>")
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
                $('#modalThName3').text('Satuan');

                $('.modalRow').remove();
                for (i = 0; i< tempPlu.length; i++){
                    $('#tbodyModalHelp').append("<tr onclick=choosePlu('"+ tempPlu[i].prd_prdcd +"','"+ index +"') class='modalRow'><td>"+ tempPlu[i].prd_deskripsipanjang +"</td> <td>"+ tempPlu[i].prd_prdcd +"</td> <td>"+ tempPlu[i].satuan +"</td></tr>")
                }

                $('#idModal').val('PLU')
                $('#modalHelp').modal('show');
            }
        }

        function searchPlu(index, val) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/transaksi/repacking/getPlu',
                type: 'post',
                data: { val:val },
                success: function (result) {
                    $('#modalThName1').text('Deskripsi');
                    $('#modalThName2').text('PLU');
                    $('#modalThName3').text('Satuan');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=choosePlu('"+ result[i].prd_prdcd +"','"+ index +"') class='modalRow'><td>"+ result[i].prd_deskripsipanjang +"</td> <td>"+ result[i].prd_prdcd +"</td> <td>"+ result[i].satuan +"</td></tr>")
                    }

                    $('#idModal').val('PLU')
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function validate_rec(index){
            let tempPlu  = $('.plu');
            let counter = 1;
            if($('.pr')[index].value === 'R' && parameterR > 0){
                return false;
            }
            for (let i=0; i < tempPlu.length; i++){
                if($('.plu')[i].value === $('.plu')[index].value){
                    counter--;
                }
                if(counter < 0){
                    return false;
                }
            }
            return true;
        }

        function choosePlu(kode,index){

            $('#modalHelp').modal('hide');
            let temp        = 0;
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/transaksi/repacking/choosePlu',
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
                        data = result.data;
                        if(data.trbo_stokqty === null || data.trbo_stokqty == 0 || data.trbo_stokqty == ''){
                            swal('', "Tidak ada stok!", 'warning');
                            $('.plu')[index].value = '';
                            $('.deskripsi')[index].value = '';
                            deskripsiPanjang[index] = '';
                            $('.satuan')[index].value = '';
                            $('.tag')[index].value = '';
                            $('.ctn-stock')[index].value = '';
                            $('.pcs-stock')[index].value = '';
                            $('.ctn-kuantum')[index].value = '';
                            $('.pcs-kuantum')[index].value = '';
                            $('.hrg-satuan')[index].value = '';
                            $('.gross')[index].value = '';
                            $('.ppn')[index].value = '';
                        }
                        else if(!validate_rec(index)){
                            swal('', "Kode produk ".concat(kode," sudah ada"), 'warning');
                            $('.plu')[index].value = '';
                        }
                        else{
                            $('.plu')[index].value = kode;
                            $('.deskripsi')[index].value = data.prd_deskripsipendek;
                            deskripsiPanjang[index] = data.prd_deskripsipanjang;
                            $('.satuan')[index].value = data.prd_unit + ' / '+ data.prd_frac;
                            //hrgsatuan yang membingungkan
                            if($('.rVal').attr('checked',true)){
                                if($('.pr')[index].value == 'R'){
                                    $('.hrg-satuan')[index].value = $('#preGross').value;
                                    trbo_averagecost[index] = $('#preGross').value;
                                }else{
                                    if(data.lcostst == null || data.lcostst == 0){
                                        $('.hrg-satuan')[index].value = convertToRupiah(data.lcostprd);
                                        trbo_averagecost[index] = (data.lcostprd);
                                    }else{
                                        if(data.prd_unit == 'KG'){
                                            $('.hrg-satuan')[index].value = convertToRupiah(data.lcostst * 1);
                                            trbo_averagecost[index] = data.lcostst * 1;
                                        }else{
                                            $('.hrg-satuan')[index].value = convertToRupiah(data.lcostst * data.prd_frac);
                                            trbo_averagecost[index] = (data.lcostst * data.prd_frac);
                                        }
                                    }
                                }
                            }else{
                                if(data.lcostst == null || data.lcostst == 0){
                                    $('.hrg-satuan')[index].value = convertToRupiah(data.lcostprd);
                                    trbo_averagecost[index] = (data.lcostprd);
                                }else{
                                    if(data.prd_unit == 'KG'){
                                        $('.hrg-satuan')[index].value = convertToRupiah(data.lcostst * 1);
                                        trbo_averagecost[index] = data.lcostst * 1;
                                    }else{
                                        $('.hrg-satuan')[index].value = convertToRupiah(data.lcostst * data.prd_frac);
                                        trbo_averagecost[index] = (data.lcostst * data.prd_frac);
                                    }
                                }
                            }
                            $('.tag')[index].value = data.prd_kodetag;
                            $('.ctn-stock')[index].value = parseInt((data.trbo_stokqty)/(data.prd_frac));
                            $('.pcs-stock')[index].value = parseInt((data.trbo_stokqty)%(data.prd_frac));
                            $('.ctn-kuantum')[index].value = 0;
                            $('.pcs-kuantum')[index].value = 0;
                        }
                        for(i = 0; i < $('.plu').length; i++){
                            if ($('.plu')[i].value != ''){
                                temp = temp + 1;
                            }
                        }
                        $('#totalItem').val(temp);
                    } else if(result.kode === 0)  {
                        swal('', result.msg, 'warning');

                        $('.plu')[index].value = '';
                        $('.deskripsi')[index].value = '';
                        deskripsiPanjang = '';
                        $('.tag')[index].value = '';
                        $('.satuan')[index].value = '';
                        $('.ctn-stock')[index].value = '';
                        $('.pcs-stock')[index].value = '';
                        $('.ctn-kuantum')[index].value = '';
                        $('.pcs-kuantum')[index].value = '';
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
        function tempTable(index) {
            var temptbl =  ` <tr class="baris">
                                                <td style="width: 4%" class="text-center">
                                                    <button class="btn btn-danger btn-delete"  style="width: 100%" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td>
                                                    <input onkeypress="return isPR(event)" onchange="PRchecker()" maxlength="1" class="form-control pr" value=""
                                                           type="text">
                                                </td>
                                                <td class="buttonInside" style="width: 150px;">
                                                    <input type="text" class="form-control plu" no="`+ index +`" value="">
                                                    <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" onclick="getPlu(this, '')" no="`+ index +`">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </td>
                                                <td>
                                                <input disabled class="form-control deskripsi" value=""
                                                       type="text">
                                                </td>
                                                <td>
                                                    <input disabled class="form-control satuan" value=""
                                                           type="text">
                                                </td>
                                                <td>
                                                    <input disabled class="form-control tag" value=""
                                                           type="text">
                                                </td>
                                                <td>
                                                    <input disabled class="form-control ctn-stock" value=""
                                                           type="text">
                                                </td>
                                                <td>
                                                    <input disabled class="form-control pcs-stock" value=""
                                                           type="text">
                                                </td>
                                                <td>
                                                    <input class="form-control ctn-header ctn-kuantum" value=""
                                                           rowheader=1
                                                           type="text">
                                                </td>
                                                <td>
                                                    <input class="form-control pcs-header pcs-kuantum" value=""
                                                           rowheader=1
                                                           type="text">
                                                </td>
                                                <td>
                                                    <input disabled class="form-control hrg-satuan" value=""
                                                           type="text">
                                                </td>
                                                <td>
                                                    <input disabled class="form-control gross" value=""
                                                           type="text">
                                                </td>
                                                <td>
                                                    <input disabled class="form-control ppn" value=""
                                                           type="text">
                                                </td>
                                            </tr>`

            return temptbl;
        }
    </script>
@endsection