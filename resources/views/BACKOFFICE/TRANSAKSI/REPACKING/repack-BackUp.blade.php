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
                                <div class="col-sm-2">
                                    <input type="text" disabled class="form-control" id="model" style="border: 0px;background-color: inherit; font-weight: bold; width: auto">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="keterangan" class="col-sm-1 col-form-label">KETERANGAN</label>
                                <div class="col-sm-5">
                                    <input class="form-control" id="keterangan" type="text">
                                </div>

                                <button disabled class="btn btn-danger col-sm-2 btn-block" id="hapusDoc" type="button">
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
                                <button onclick="print()" type="button" class="btn btn-success btn-block" style="width: 200px; margin-top: -120px; height: 60px">PRINT</button>
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
                                        <tr class="baris" onclick="showDesPanjang(this)">
                                            <td>
                                                <button onclick="deleteRow(this)" class="btn btn-block btn-sm btn-danger btn-delete-row-header"><i
                                                            class="icon fas fa-times"></i></button>
                                            </td>
                                            <td>
                                                <input onkeypress="return isPR(event)" onchange="PRchecker(this)" maxlength="1" class="form-control pr"
                                                       type="text">
                                            </td>
                                            <td class="buttonInside" style="width: 150px;">
                                                <input onfocus="penampungPlu(this)" onchange="penangkapPlu(this)" type="text" class="form-control plu" value="">
                                                <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" onclick="getPlu(this, '')">
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
                                                <input onchange="kuantumChecker(this)" onkeypress="return isNumberKey(event)" class="form-control ctn-header ctn-kuantum"
                                                       rowheader=1
                                                       type="text">
                                            </td>
                                            <td>
                                                <input onchange="kuantumChecker(this)" onkeypress="return isNumberKey(event)" class="form-control pcs-header pcs-kuantum"
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
                                    <tfoot>
                                        <tr>
                                            <td colspan="13"><button id="addRow" class="btn btn-primary btn-block" onclick="addNewRow()">Tambah Baris Baru</button></td>
                                        </tr>
                                    </tfoot>
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
                                <input readonly id="preGross" type="text" style="margin-right: 30px" value="0.00">

                                <label for="ppnAlt" class="font-weight-normal" style="margin-right: 10px;">PPN</label>
                                <input readonly id="ppnAlt" type="text" value="0.00">
                            </div>

                            <div class="d-flex justify-content-end">
                                <label for="preItem" class="font-weight-normal" style="margin-right: 10px;">RE-PACKING ITEM</label>
                                <input readonly id="reItem" type="text" style="margin-right: 39px" value="0">

                                <label for="reGross" class="font-weight-normal" style="margin-right: 10px;">RE-PACKING GROSS</label>
                                <input readonly id="reGross" type="text" style="margin-right: 16px" value="0.00">

                                <label for="ppnAlt" class="font-weight-normal" style="margin-right: 10px;">TOTAL</label>
                                <input readonly id="total" type="text" value="0.00">
                            </div>

                            <div class="d-flex justify-content-end">
                                <label for="totItem" class="font-weight-normal" style="margin-right: 10px;">TOTAL ITEM</label>
                                <input readonly id="totItem" type="text" style="margin-right: 84px" value="0">

                                <label for="totGross" class="font-weight-normal" style="margin-right: 10px;">TOTAL GROSS</label>
                                <input readonly id="totGross" type="text" style="margin-right: 258px" value="0.00">

                                {{--<button hidden id="hiddenSaveButton" type="button" onclick="saveMe()"></button>--}}

                            </div>
                            <br>
                            <div class="d-flex justify-content-start">
                                <span style="font-weight: bold">Ctrl+S : Simpan Data &nbsp;&nbsp; atau tekan &nbsp;&nbsp;</span>
                                <button onclick="saveMe()" type="button" class="btn btn-primary btn-block col-sm-2">Save</button>
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
        let temporary;

        let saveBool = true;
        let model;
        let noDoc;
        let tglDoc;
        let noReff;
        let tglReff;
        let keterangan;
        let rubahPlu;
        let group_option;
        let trbo_flagdoc = '';
        let noDocPrint;
        let noUrut;
        let deskripsiPanjang = [];
        let trbo_averagecost = [];
        let parameterR = 0;
        let totalGrossP = 0;
        let totalGrossR = 0;


        $('#tanggalTrn').datepicker({
            format: 'dd/mm/yyyy'
        });
        function dropdownBiasa(){
            $('#jenisKertas').val('Biasa');
        }
        function dropdownKecil() {
            $('#jenisKertas').val('Kecil');
        }

        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function penampungPlu(iniPlu){
            if(iniPlu.value != ''){
                temporary = iniPlu.value;
            }

        }

        // $('input').on('focusin', function(){
        //     console.log("Saving value " + $(this).val());
        //     $(this).data('val', $(this).val());
        // });

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
            //group_option = 'R';
            if($('#perubahanPlu').val() == 'Y'){
                $('.rVal').prop('checked',true); //GROUP OPTION MENJADI R
                $('.radio').attr('disabled','disabled');
                $('.baris').remove();
                $('#body-table-header').append(tempTable(0));
                $('#body-table-header').append(tempTable(1));
                $('.baris td button').attr('hidden',true);
                $('#addRow').attr('hidden',true);
            }else{
                $('.radio').removeAttr('disabled');
                $('.baris td button').removeAttr('hidden');
                $('#addRow').removeAttr('hidden');
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

        function addNewRow() {
            $('#body-table-header').append(tempTable());
        }

        function deleteRow(e) {
            deskripsiPanjang.splice((e.parentNode.parentNode.rowIndex)-2, 1);
            trbo_averagecost.splice((e.parentNode.parentNode.rowIndex)-2, 1);
            //deskripsiPanjang[e.parentNode.parentNode.rowIndex] = '';
            //trbo_averagecost[e.parentNode.parentNode.rowIndex] = 0;
            //alert(e.parentNode.parentNode.rowIndex); cara mendapatkan row ketika onclick javascript
            $(e).parents("tr").remove();
            $('#deskripsi').val('');

            if($("input[type='radio'][name='optradio']:checked").val() === 'R'){
                for(i = 0; i < $('.plu').length; i++){
                    if($('.pr')[i].value === 'R'){
                        rDinamis(i);
                        break
                    }
                }
            }
            totalPPN();
            totalGross();
            qtyCounter();

        }

        function showDesPanjang(e) {
            $('#deskripsi').val(deskripsiPanjang[e.rowIndex-2]);
        }

        function rDinamis(index){
            totalGross();
            let satuancounter   = $('.satuan')[index].value;
            let fraccounter     = satuancounter.substr(satuancounter.indexOf('/')+1);
            let ctnKuantum      = $('.ctn-kuantum')[index].value;
            let pcsKuantum      = $('.pcs-kuantum')[index].value;

            let totalKuantum = (parseInt(ctnKuantum) * parseInt(fraccounter)) + parseInt(pcsKuantum);

            $('.hrg-satuan')[index].value = $('#preGross').value;
            trbo_averagecost[index] = $('#preGross').value;
            if($('.pr')[index].value === 'R' && totalKuantum > 0 && totalGrossP > 0){
                $('.hrg-satuan')[index].value = convertToRupiah((totalGrossP/totalKuantum)*parseInt(fraccounter));
                trbo_averagecost[index] = (totalGrossP/totalKuantum)*parseInt(fraccounter);
            }
            $('.gross')[index].value = convertToRupiah( (ctnKuantum * unconvertToRupiah($('.hrg-satuan')[index].value)) + ((unconvertToRupiah($('.hrg-satuan')[index].value)/fraccounter)*pcsKuantum) );
        }

        //Ini PRchecker v0.1
        // function PRchecker(elem){
        //     let trElement = elem.parentElement.parentElement;
        //     let tr = document.getElementsByTagName('tr');
        //     tr = Array.prototype.slice.call(tr);
        //     let row = tr.indexOf(trElement)-2;
        //
        //     if($('#perubahanPlu').val() != 'Y'){
        //         let index = null;
        //         if($('.rVal').is(':checked')){
        //             if($('.pr')[row].value == 'R'){
        //                 for(i = 0; i < $('.pr').length; i++){
        //                     if ($('.pr')[i].value == 'R' && i != row){
        //                         swal({
        //                             title:'Re-Packing',
        //                             text: 'Sudah ada item re-packing, tidak bisa tambah data lagi',
        //                             icon:'warning',
        //                             timer: 2000,
        //                             buttons: {
        //                                 confirm: false,
        //                             },
        //                         });
        //                         if ($('.plu')[row].value != ''){
        //                             $('.pr')[row].value = 'P';
        //                         }else{
        //                             $('.pr')[row].value = '';
        //                         }
        //                         index = i;
        //                         $('.pr')[row].focus();
        //                         break
        //                     }
        //                 }if(index == null && $('.plu')[row].value != ''){
        //                     rDinamis(row);
        //                     totalGross();
        //                 }
        //             }else if($('.plu')[row].value != ''){
        //                 choosePlu(($('.plu')[row].value),row); //ctn-kuantum dan pcs-kuantum kembali jadi 0
        //             }
        //
        //         }else{
        //             if($('.pr')[row].value == 'P'){
        //                 for(i = 0; i < $('.pr').length; i++){
        //                     if ($('.pr')[i].value == 'P' && i != row){
        //                         swal({
        //                             title:'Re-Packing',
        //                             text: 'Sudah ada item pre-packing, tidak bisa tambah data lagi',
        //                             icon:'warning',
        //                             timer: 2000,
        //                             buttons: {
        //                                 confirm: false,
        //                             },
        //                         });
        //                         if ($('.plu')[row].value != ''){
        //                             $('.pr')[row].value = 'R';
        //                         }else{
        //                             $('.pr')[row].value = '';
        //                         }
        //                         $('.pr')[row].focus();
        //                         break
        //                     }
        //                 }
        //             }
        //         }
        //
        //     }
        // }

        function PRchecker(elem){
            let row = elem.parentNode.parentNode.rowIndex-2;
            if(row-1 >= 0){
                if($('.plu')[row-1].value == ''){
                    swal({
                        title:'Packing',
                        text: 'Row atas masih kosong',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    });
                    $('.pr')[row].value = '';
                }
            }
            if($('#perubahanPlu').val() != 'Y'){
                let index = null;
                if($('.rVal').is(':checked')){
                    if($('.pr')[row].value == 'R'){
                        if(row+1 <= $('.pr').length){
                            if($('.pr')[row+1].value != ''){
                                swal({
                                    title:'Re-Packing',
                                    text: 'Di row bawah ada data',
                                    icon:'warning',
                                    timer: 2000,
                                    buttons: {
                                        confirm: false,
                                    },
                                });
                                $('.pr')[row].value = 'P';
                                return;
                            }
                        }
                        for(i = 0; i < $('.pr').length; i++){
                            if ($('.pr')[i].value == 'R' && i != row){
                                swal({
                                    title:'Re-Packing',
                                    text: 'Sudah ada item re-packing, tidak bisa tambah data lagi',
                                    icon:'warning',
                                    timer: 2000,
                                    buttons: {
                                        confirm: false,
                                    },
                                });
                                if ($('.plu')[row].value != ''){
                                    $('.pr')[row].value = 'P';
                                }else{
                                    $('.pr')[row].value = '';
                                }
                                index = i;
                                $('.pr')[row].focus();
                                break
                            }
                        }if(index == null && $('.plu')[row].value != ''){
                            rDinamis(row);
                            totalGross();
                            qtyCounter();
                        }
                    }else if($('.pr')[row].value == 'P'){
                        for(i = 0; i < $('.pr').length; i++){
                            if ($('.pr')[i].value == 'R'){
                                swal({
                                    title:'Re-Packing',
                                    text: 'Sudah ada item re-packing, tidak bisa tambah data lagi',
                                    icon:'warning',
                                    timer: 2000,
                                    buttons: {
                                        confirm: false,
                                    },
                                });
                                $('.pr')[row].value = '';
                                $('.pr')[i].focus();
                                break
                            }
                        }
                    }else{
                        if($('.plu')[row].value != ''){
                            swal({
                                title:'Re-Packing',
                                text: 'Item sudah ada, tidak bisa mengosongkan kolom',
                                icon:'warning',
                                timer: 2000,
                                buttons: {
                                    confirm: false,
                                },
                            });
                            $('.pr')[row].value = 'P';
                            choosePlu(($('.plu')[row].value),row); //ctn-kuantum dan pcs kuantum kembali menjadi 0
                            $('.pr')[row].focus();
                        }
                    }

                }else{
                    if($('.pr')[row].value == 'P'){
                        if(row+1 <= $('.pr').length){
                            if($('.pr')[row+1].value != ''){
                                swal({
                                    title:'Pre-Packing',
                                    text: 'Di row bawah ada data',
                                    icon:'warning',
                                    timer: 2000,
                                    buttons: {
                                        confirm: false,
                                    },
                                });
                                $('.pr')[row].value = 'R';
                                return;
                            }
                        }
                        for(i = 0; i < $('.pr').length; i++){
                            if ($('.pr')[i].value == 'P' && i != row){
                                swal({
                                    title:'Pre-Packing',
                                    text: 'Sudah ada item pre-packing, tidak bisa tambah data lagi',
                                    icon:'warning',
                                    timer: 2000,
                                    buttons: {
                                        confirm: false,
                                    },
                                });
                                if ($('.plu')[row].value != ''){
                                    $('.pr')[row].value = 'R';
                                }else{
                                    $('.pr')[row].value = '';
                                }
                                $('.pr')[row].focus();
                                break
                            }
                        }
                    }else if($('.pr')[row].value == 'R'){
                        for(i = 0; i < $('.pr').length; i++){
                            if ($('.pr')[i].value == 'P'){
                                swal({
                                    title:'Pre-Packing',
                                    text: 'Sudah ada item pre-packing, tidak bisa tambah data lagi',
                                    icon:'warning',
                                    timer: 2000,
                                    buttons: {
                                        confirm: false,
                                    },
                                });
                                $('.pr')[row].value = '';
                                $('.pr')[i].focus();
                                break
                            }
                        }
                    }else{
                        if($('.plu')[row].value != ''){
                            swal({
                                title:'Pre-Packing',
                                text: 'Item sudah ada, tidak bisa mengosongkan kolom',
                                icon:'warning',
                                timer: 2000,
                                buttons: {
                                    confirm: false,
                                },
                            });
                            $('.pr')[row].value = 'R';
                            choosePlu(($('.plu')[row].value),row); //ctn-kuantum dan pcs kuantum kembali menjadi 0
                            $('.pr')[row].focus();
                        }
                    }
                }

            }
            else{
                if($('.pr')[0].value == 'R'){
                    $('.pr')[0].value = 'P';
                }else if($('.pr')[0].value == '' && $('.plu')[0].value != ''){
                    swal({
                        title:'Pre-Packing',
                        text: 'Item sudah ada, tidak bisa mengosongkan kolom',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    });
                    $('.plu')[row].value = 'P'
                }
                if($('.pr')[1].value == 'P'){
                    if($('.plu')[0].value == ''){
                        $('.pr')[1].value = '';
                    }else{
                        $('.pr')[1].value = 'R';
                    }
                }else if($('.pr')[0].value == '' && $('.plu')[0].value != ''){
                    swal({
                        title:'Re-Packing',
                        text: 'Item sudah ada, tidak bisa mengosongkan kolom',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    });
                    $('.plu')[row].value = 'R'
                }
            }
        }

        $(window).bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                if(String.fromCharCode(event.which).toLowerCase() === 's'){
                    event.preventDefault();
                    saveMe();
                }
                // switch (String.fromCharCode(event.which).toLowerCase()) {
                //     case 's':
                //         event.preventDefault();
                //         //$('#hiddenSaveButton').click();
                //         //alert('ctrl-s');
                //         saveMe();
                //         break;
                //     case 'S':
                //         event.preventDefault();
                //         //$('#hiddenSaveButton').click();
                //         saveMe();
                //         break;
                // }
            }
        });
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
            $('.ctn-kuantum')[index].focus();
        }

        function saveMe() {
            if(saveBool){
                swal({
                    title: "Apakah anda yakin?",
                    text: "Data akan disimpan!",
                    icon: "warning",
                    buttons: [
                        'Tidak, batalkan!',
                        'Ya, saya yakin!'
                    ],
                    dangerMode: true,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        saveData();
                    } else {
                        swal("Dibatalkan", "Data tidak jadi disimpan", "error");
                    }
                });
            }
            else{
                swal("Gagal", "Data tidak bisa disimpan", "error");
            }
        }

        function saveData(){
            let counter = 0;
            for(i = 0; i < $('.plu').length; i++) {
                if ($('.plu')[i].value != '') {
                    counter++;
                    if($('.ctn-kuantum')[i].value === ''){
                        $('.ctn-kuantum')[i].value = 0;
                    }
                    if($('.pcs-kuantum')[i].value === ''){
                        $('.pcs-kuantum')[i].value = 0;
                    }
                    if((parseInt($('.ctn-kuantum')[i].value) + parseInt($('.pcs-kuantum')[i].value)) === 0){
                        $('.ctn-kuantum')[i].focus();
                        swal("Gagal", "Qty CTN/PCS Tidak Boleh Kosong !!", "error");
                        return false;
                    }
                }
            }
            if(counter === 0 || $('#nomorTrn').val() === ''){
                swal("Gagal", "Tidak ada data !!", "error");
                return false;
            }

            let nomorTrn = $('#nomorTrn').val();
            let tempDate= $('#tanggalTrn').val();
            let date    = tempDate.substr(3,2) + '/'+ tempDate.substr(0,2)+ '/'+ tempDate.substr(6,4);
            let keterangan = $('#keterangan').val();
            let trbo_flagdisc3 = $('#perubahanPlu').val();
            let trbo_flagdisc2 = $("input[type='radio'][name='optradio']:checked").val();
            //let noReff = noReff; //liat no reff di pra insert
            //tgl reff = date(tanggal trn)

            let datas   = [{'flagdisc1' : '', 'plu' : '', 'stokqty':'', 'qty' : '','hrgsatuan' : '', 'averagecost' : '', 'gross' : '', 'ppn': ''}];

            if ($('#model').val().length < 1){
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
            for (let i=0; i < deskripsiPanjang.length; i++){
                var qtystok = 0;
                var qty     = 0;
                let temp    = $('.satuan')[i].value;
                let arr     = temp.split(" / ");
                let unit    = arr[0];
                let frac    = temp.substr(temp.indexOf('/')+1);
                let ctnstok = parseInt( $('.ctn-stock')[i].value);
                let pcsstok = parseInt( $('.pcs-stock')[i].value);
                let ctn     = parseInt( $('.ctn-kuantum')[i].value);
                let pcs     = parseInt( $('.pcs-kuantum')[i].value);

                if ( $('.plu')[i].value){
                    if(unit === "KG"){
                        frac = 1;
                    }
                    qtystok = (ctnstok * parseInt(frac) + pcsstok);
                    qty  = (ctn * parseInt(frac) + pcs);

                    if (qty < 1){
                        focusToRow(i);
                        return false;
                    }
                    datas.push({'flagdisc1': $('.pr')[i].value, 'plu' : $('.plu')[i].value, 'stokqty' : qtystok , 'qty' : qty ,'hrgsatuan' : unconvertToRupiah($('.hrg-satuan')[i].value), 'averagecost' : trbo_averagecost[i] ,'gross' : unconvertToRupiah($('.gross')[i].value), 'ppn' : unconvertToRupiah($('.ppn')[i].value)})
                }
            }

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/saveData',
                type: 'post',
                data: {
                    nomorTrn:nomorTrn,
                    tanggalTrn:date,
                    keterangan:keterangan,
                    statusPrint:trbo_flagdoc,
                    trbo_flagdisc3:trbo_flagdisc3,
                    trbo_flagdisc2:trbo_flagdisc2,
                    noreff:noReff,
                    datas:datas
                },
                success: function () {
                    swal({
                        title: 'Tersimpan!',
                        text: 'Data telah berhasil disimpan!',
                        icon: 'success'
                    });
                    if(trbo_flagdoc == ''){
                        trbo_flagdoc = '0';
                    }
                    //clearForm();
                }, error: function () {
                    alert('error');
                }
            });
        }

        function qtyCounter(){
            let qtyR = 0;
            let qtyP = 0;
            for(i = 0; i < $('.plu').length; i++) {
                if ($('.plu')[i].value != '') {
                    if($('.pr')[i].value === 'R'){
                        qtyR++;
                    }else{
                        qtyP++;
                    }
                }
            }
            $('#reItem').val(qtyR);
            $('#preItem').val(qtyP);
            $('#totItem').val(qtyR+qtyP);
        }

        function kuantumChecker(elem){
            let row = elem.parentNode.parentNode.rowIndex-2;

            if ($('.plu')[row].value != ''){
                let satuancounter   = $('.satuan')[row].value;
                let fraccounter     = satuancounter.substr(satuancounter.indexOf('/')+1);
                let ctnStock        = $('.ctn-stock')[row].value;
                let pcsStock        = $('.pcs-stock')[row].value;
                let ctnKuantum      = parseInt($('.ctn-kuantum')[row].value);
                let pcsKuantum      = parseInt($('.pcs-kuantum')[row].value);

                let totalKuantum = (parseInt(ctnKuantum) * parseInt(fraccounter)) + parseInt(pcsKuantum);
                let totalStock = (parseInt(ctnStock) * parseInt(fraccounter)) + parseInt(pcsStock);

                if(totalKuantum > totalStock){
                    swal({
                        title:'Kuantum > Stock',
                        text: ' ',
                        icon:'warning',
                        timer: 1000,
                        buttons: {
                            confirm: false,
                        },
                    });
                    $('.ctn-kuantum')[row].focus();
                    $('.ctn-kuantum')[row].value = 0;
                    $('.pcs-kuantum')[row].value = 0;
                    return false;
                }
                //$('.gross')[row].value = convertToRupiah( (ctnKuantum * unconvertToRupiah($('.hrg-satuan')[row].value)) + ((unconvertToRupiah($('.hrg-satuan')[row].value)/fraccounter)*pcsKuantum) );
                if($("input[type='radio'][name='optradio']:checked").val() === 'R'){
                    let thereisR        = 0;

                    if($('.pr')[row].value === 'P'){
                        for(i = 0; i < $('.plu').length; i++){
                            if($('.pr')[i].value === 'R'){
                                thereisR = i;
                                break
                            }
                        }
                        if(thereisR != 0 ){
                            rDinamis(thereisR);
                        }
                    }
                    if($('.pr')[row].value === 'R' && totalKuantum > 0 && totalGrossP > 0){
                        $('.hrg-satuan')[row].value = convertToRupiah((totalGrossP/totalKuantum)*parseInt(fraccounter));
                        trbo_averagecost[row] = (totalGrossP/totalKuantum)*parseInt(fraccounter);
                    }
                    $('.gross')[row].value = convertToRupiah( (ctnKuantum * unconvertToRupiah($('.hrg-satuan')[row].value)) + ((unconvertToRupiah($('.hrg-satuan')[row].value)/fraccounter)*pcsKuantum) );
                }
                else if($("input[type='radio'][name='optradio']:checked").val() === 'P'){
                    $('.gross')[row].value = convertToRupiah( (ctnKuantum * unconvertToRupiah($('.hrg-satuan')[row].value)) + ((unconvertToRupiah($('.hrg-satuan')[row].value)/fraccounter)*pcsKuantum) );
                    if($('.pr')[row].value === 'P'){
                        let acostp = trbo_averagecost[row] * ((ctnKuantum*parseInt(fraccounter))+pcsKuantum);
                        let t_acost = unconvertToRupiah($('#reGross').val());
                        for(i = 0; i < $('.plu').length; i++){
                            if($('.pr')[i].value === 'R'){
                                $('.gross')[i].value = convertToRupiah( (unconvertToRupiah($('.gross')[i].value)/t_acost)*acostp );
                                trbo_averagecost[i] = unconvertToRupiah($('.gross')[i].value)/(ctnKuantum+(pcsKuantum/parseInt(fraccounter)))
                                $('.hrg-satuan')[i].value = convertToRupiah(trbo_averagecost[i]);
                            }
                        }
                    }
                }

            }

            totalGross();
        }

        function totalGross(){
            totalGrossP = 0;
            totalGrossR = 0;
            for(i = 0; i < $('.plu').length; i++){
                if ($('.pr')[i].value === 'P'){
                    totalGrossP = totalGrossP + parseFloat(unconvertToRupiah($('.gross')[i].value));
                }else{
                    totalGrossR = totalGrossR + parseFloat(unconvertToRupiah($('.gross')[i].value));
                }
            }
            $('#preGross').val(convertToRupiah(totalGrossP));
            $('#reGross').val(convertToRupiah(totalGrossR));
            $('#totGross').val(convertToRupiah(totalGrossP+totalGrossR));
            $('#total').val(convertToRupiah(totalGrossP+totalGrossR+unconvertToRupiah($('#ppn').value)));
        }

        function totalPPN(){
            let ppn = 0;
            for(i = 0; i < $('.plu').length; i++){
                ppn = ppn + unconvertToRupiah($('#ppn').value);
            }
            $('#ppn').val(convertToRupiah(ppn));
            $('#total').val(convertToRupiah(unconvertToRupiah($('#totGross').value)+ppn));
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


        function penangkapPlu(w){
            let row = w.parentNode.parentNode.rowIndex-2;
            let val = convertPlu(w.value);
            if($('.deskripsi')[row].value !== '' && $('.plu')[row].value === ''){
                swal('', "Data Kosong, harap mengisi plu dengan benar !!", 'warning');
                $('.plu')[row].value = temporary;
            }else if($('.plu')[row].value != ''){
                if($('.pr')[row].value === '' || $('.pr')[row].value == null){
                    $('.plu')[row].value = '';
                    swal('', "Isi kolom P/R dahulu !!", 'warning');
                    return false;
                }
                else{
                    choosePlu(val,row);
                    qtyCounter();
                    totalPPN();
                }
            }
        }

        $('#hapusDoc').click(function () {
            if($('#nomorTrn').val() != ''){
                swal({
                    title: "Apakah anda yakin?",
                    text: "Data tidak akan bisa diakses lagi bila dihapus!",
                    icon: "warning",
                    buttons: [
                        'Tidak, batalkan!',
                        'Ya, saya yakin!'
                    ],
                    dangerMode: true,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        let val = $('#nomorTrn').val();
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/deleteTrn',
                            type: 'post',
                            data: {
                                val:val
                            },
                            success: function (result) {
                                if(result.kode == '1'){
                                    swal({
                                        title: 'Terhapus!',
                                        text: 'Data telah berhasil dihapus!',
                                        icon: 'success'
                                    })
                                    clearForm();
                                }
                                else{
                                    swal("Gagal!", "Data tidak berhasil dihapus", "error");
                                }
                            }, error: function () {
                                swal("Gagal!", "Data tidak berhasil dihapus", "error");
                            }
                        })
                    } else {
                        swal("Dibatalkan", "Data tidak jadi dihapus", "error");
                    }
                });
            }else{
                swal("Nomor transaksi kosong", "Data tidak berhasil dihapus", "error");
            }
        });

        // $('.plu').change(function () {
        //
        //     let row = $(this).attr('no');
        //     let val = convertPlu($(this).val());
        //     if($('.plu')[row].value != ''){
        //         if($('.pr')[row].value === '' || $('.pr')[row].value == null){
        //             $('.plu')[row].value = '';
        //             swal('', "Isi kolom P/R dahulu !!", 'warning');
        //             return false;
        //         }else{
        //             choosePlu(val,row);
        //             qtyCounter();
        //             totalPPN();
        //         }
        //     }
        //
        // });

        function clearForm(){
            $('#hapusDoc').attr('disabled','disabled');
            $('#model').val('');

            $('#nomorTrn').val('');
            $('#tanggalTrn').val('');
            $('#keterangan').val('');
            $('#perubahanPlu').val('');
            $('#deskripsi').val('');
            $('#preItem').val('0.00');
            $('#reItem').val('0.00');
            $('#totItem').val('0.00');
            $('#preGross').val('0.00');
            $('#reGross').val('0.00');
            $('#totGross').val('0.00');
            $('#ppnAlt').val('0.00');
            $('#total').val('0.00');

            $('.rVal').prop('checked',true);
            $('.pVal').prop('checked',false);

            $('.pr').removeAttr('disabled');
            $('.plu').removeAttr('disabled');
            $('.ctn-kuantum').removeAttr('disabled');
            $('.pcs-kuantum').removeAttr('disabled');

            $('.baris td button').removeAttr('hidden');
            $('#addRow').removeAttr('hidden');


            $('.baris').remove();
            for (i = 0; i< 10; i++) {
                $('#body-table-header').append(tempTable());
            }

            trbo_averagecost = [];
            deskripsiPanjang = [];
            trbo_flagdoc = '';

            //dropdownKecil();
        }

        function searchNmrTrn(val) {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getNmrTrn',
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
                                url: '{{ url()->current() }}/getNewNmrTrn',
                                type: 'post',
                                data: {},
                                beforeSend: function () {
                                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                },
                                success: function (result) {
                                    $('#hapusDoc').attr('disabled','disabled');
                                    $('#nomorTrn').val(result.noDoc);
                                    noDoc = result.noDoc;
                                    $('#tanggalTrn').val(formatDate('now'));
                                    tglDoc = formatDate('now');
                                    model = result.model;
                                    $('#model').val(model);
                                    noReff = result.noReff;
                                    $('#modal-loader').modal('hide')
                                    trbo_flagdoc = '';
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
                    url: '{{ url()->current() }}/getNmrTrn',
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
            deskripsiPanjang = [];
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/chooseTrn',
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
                        $('#hapusDoc').removeAttr('disabled');
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
                        //perubahanPluChecker();
                        if(rec[0].trbo_flagdisc2 == 'R'){
                            $('.rVal').prop('checked',true);
                            $('.pVal').prop('checked',false);
                        }else{
                            $('.pVal').prop('checked',true);
                            $('.rVal').prop('checked',false);
                        }
                        group_option = rec[0].trbo_flagdisc2;
                        model = '* KOREKSI *';
                        $('#model').val(model);
                        trbo_flagdoc = rec[0].trbo_flagdoc;
                        noDocPrint = rec[0].nota;
                        //noUrut = rec[0].trbo_seqno + 1;
                        for (i = 0; i< rec.length; i++) {
                            $('#body-table-header').append(tempTable());
                            $('.pr')[i].value = rec[i].trbo_flagdisc1;
                            $('.plu')[i].value = rec[i].trbo_prdcd;
                            $('.deskripsi')[i].value = rec[i].prd_deskripsipendek;
                            //deskripsiPanjang.push(rec[i].prd_deskripsipanjang);
                            deskripsiPanjang[i] = rec[i].prd_deskripsipanjang;
                            $('.satuan')[i].value = (rec[i].prd_unit).concat("/",(rec[i].prd_frac));
                            $('.tag')[i].value = rec[i].prd_kodetag;
                            $('.ctn-stock')[i].value = parseInt((rec[i].st_saldoakhir)/(rec[i].prd_frac));
                            $('.pcs-stock')[i].value = (rec[i].st_saldoakhir)%(rec[i].prd_frac);
                            $('.ctn-kuantum')[i].value = parseInt((rec[i].trbo_qty)/(rec[i].prd_frac));
                            $('.pcs-kuantum')[i].value = (rec[i].trbo_qty)%(rec[i].prd_frac);
                            $('.hrg-satuan')[i].value = rec[i].trbo_hrgsatuan;
                            trbo_averagecost[i] = rec[i].trbo_averagecost;
                            $('.gross')[i].value = rec[i].trbo_gross;
                            $('.ppn')[i].value = rec[i].trbo_ppnrph;
                        }
                        if (model == '* KOREKSI *') {
                            if (trbo_flagdoc == '*') {
                                model = '* NOTA SUDAH DICETAK *';
                                $('#model').val(model);
                                saveBool = false;
                                //disable savedata dan update data
                                $('.baris td input').attr('disabled','disabled');
                                $('.baris td button').attr('hidden',true);
                                $('#addRow').attr('hidden',true);
                            } else {
                                saveBool = true;
                                //enable savedata dan update data
                                if(rubahPlu == 'Y'){
                                    $('.baris td button').attr('hidden',true);
                                    $('#addRow').attr('hidden',true);
                                }else{
                                    $('.baris td button').removeAttr('hidden');
                                    $('#addRow').removeAttr('hidden');
                                }
                                $('.pr').removeAttr('disabled');
                                $('.plu').removeAttr('disabled');
                                $('.ctn-kuantum').removeAttr('disabled');
                                $('.pcs-kuantum').removeAttr('disabled');

                            }
                        } else {
                            saveBool = true;
                            //enable savedata dan update data
                            if($('#perubahanPlu').value == 'Y'){
                                $('.baris td button').attr('hidden',true);
                                $('#addRow').attr('hidden',true);
                            }else{
                                $('.baris td button').removeAttr('hidden');
                                $('#addRow').removeAttr('hidden');
                            }
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
                    totalGross();
                    totalPPN();
                    qtyCounter();
                }, error: function () {
                }
            })
        }

        function getPlu(no, val) {
            $('#searchModal').val('');
            let index = no.parentNode.parentNode.rowIndex-2;

            if($('.pr')[index].value === '' || $('.pr')[index].value == null){
                swal('', "Isi kolom P/R dahulu !!", 'warning');
                return false;
            }
            $('#idRow').val(index);

            if (tempPlu == null){
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/getPlu',
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
                url: '{{ url()->current() }}/getPlu',
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
            let temp  = $('.plu');
            let counter = 1;
            if($('.pr')[index].value === 'R' && parameterR > 0){
                return false;
            }
            for (let i=0; i < temp.length; i++){
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
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/choosePlu',
                type: 'post',
                data: {
                    kode: kode
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    $('.plu')[index].value = kode;

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
                            qtyCounter();
                        }
                        else{
                            $('.plu')[index].value = kode;
                            $('.deskripsi')[index].value = data.prd_deskripsipendek;
                            deskripsiPanjang[index] = data.prd_deskripsipanjang;
                            $('#deskripsi').val(data.prd_deskripsipanjang);
                            $('.satuan')[index].value = data.prd_unit + ' / '+ data.prd_frac;
                            //hrgsatuan yang membingungkan
                            if($("input[type='radio'][name='optradio']:checked").val() === 'R'){
                                if($('.pr')[index].value == 'R'){
                                    $('.hrg-satuan')[index].value = $('#preGross').val();
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
                            if(data.prd_flagbkp1 === 'Y'){
                                $('.ppn')[index].value = convertToRupiah(0.00);
                            }else{
                                $('.ppn')[index].value = convertToRupiah(0.00);
                            }
                        }

                    } else if(result.kode === 0)  {
                        if($('.deskripsi')[index].value !== ''){
                            swal('', "Data tidak ketemu !! \n Mengembalikan plu ke nilai sebelumnya karena ada data pada row ini !!", 'warning');
                            $('.plu')[index].value = temporary;
                            return;
                        }
                        swal('', result.msg, 'warning');

                        $('.plu')[index].value = '';
                        $('.deskripsi')[index].value = '';
                        deskripsiPanjang[index] = '';
                        $('.tag')[index].value = '';
                        $('.satuan')[index].value = '';
                        $('.ctn-stock')[index].value = '';
                        $('.pcs-stock')[index].value = '';
                        $('.ctn-kuantum')[index].value = '';
                        $('.pcs-kuantum')[index].value = '';
                        $('.hrg-satuan')[index].value = '';
                        $('.gross')[index].value = '';
                        $('.ppn')[index].value = '';

                    } else {
                        swal('Error', 'Somethings error', 'error');
                    }
                    qtyCounter();
                    totalPPN();
                }, error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            })
        }

        function print(){
            if($('#reItem').val() > 0 && $('#preItem').val() == 0){
                swal('Re-packing', 'Tipe "P" belum diinput, proses tidak bisa dilakukan', 'warning');
                return false;
            }else if($('#preItem').val() > 0 && $('#reItem').val() == 0){
                swal('Re-packing', 'Tipe "R" belum diinput, proses tidak bisa dilakukan', 'warning');
                return false;
            }
            if($('#perubahanPlu').val() === 'Y'){
                if($('#preItem').val() != 1){
                    swal('Re-packing', 'Untuk Rubah PLU Tipe "P" tidak boleh lebih dari 1 item, proses tidak bisa dilakukan', 'warning');
                    return false;
                }else if($('#reItem').val() != 1){
                    swal('Re-packing', 'Untuk Rubah PLU Tipe "R" tidak boleh lebih dari 1 item, proses tidak bisa dilakukan', 'warning');
                    return false;
                }
            }
            swal({
                title: "Apakah anda yakin?",
                text: "Data akan disimpan/perbaharui dan di cetak/print!",
                icon: "warning",
                buttons: [
                    'Tidak, batalkan!',
                    'Ya, saya yakin!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    let nomorTrn = $('#nomorTrn').val();
                    let keterangan = $('#keterangan').val();
                    // >> Sepertinya ga pakai karena status print nya di flagdoc hanya sudah print atau belum, yaitu * atau 0
                    // if(trbo_flagdoc == '0'){
                    //     trbo_flagdoc = '1';
                    // }
                    saveData();
                    if(true){
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/print',
                            type: 'post',
                            data: {
                                nomorTrn:nomorTrn,
                                noReff:noReff,
                                keterangan:keterangan
                            },
                            success: function () {
                                if($('#jenisKertas').val() == 'Biasa'){
                                    window.open('{{ url()->current() }}/printdoc/'+nomorTrn+'/','_blank');
                                }else if($('#jenisKertas').val() == 'Kecil'){
                                    window.open('{{ url()->current() }}/printdockecil/'+nomorTrn+'/','_blank');
                                }
                                clearForm();
                            }, error: function () {
                                alert('error');
                            }
                        })
                    }
                } else {
                    swal("Dibatalkan", "Data tidak jadi disimpan/perbaharui dan di di cetak/print", "error");
                }
            });
        }

        function tempTable() {
            var temptbl =  ` <tr class="baris" onclick="showDesPanjang(this)">
                                                <td style="width: 4%" class="text-center">
                                                    <button onclick="deleteRow(this)" class="btn btn-danger btn-delete"  style="width: 100%" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td>
                                                    <input onkeypress="return isPR(event)" onchange="PRchecker(this)" maxlength="1" class="form-control pr" value=""
                                                           type="text">
                                                </td>
                                                <td class="buttonInside" style="width: 150px;">
                                                    <input onfocus="penampungPlu(this)" onchange="penangkapPlu(this)" type="text" class="form-control plu"  value="">
                                                    <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" onclick="getPlu(this, '')">
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
                                                    <input onchange="kuantumChecker(this)" onkeypress="return isNumberKey(event)" class="form-control ctn-header ctn-kuantum" value=""
                                                           rowheader=1
                                                           type="text">
                                                </td>
                                                <td>
                                                    <input onchange="kuantumChecker(this)" onkeypress="return isNumberKey(event)" class="form-control pcs-header pcs-kuantum" value=""
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
