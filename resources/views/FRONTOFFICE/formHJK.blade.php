@extends('navbar')
@section('title','FORM HARGA JUAL KHUSUS')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5 text-center">FORM USULAN HARGA JUAL KHUSUS (NAIK/TURUN)</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                            <br>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Periode</label>
                                <input class="col-sm-3 text-center form-control" type="text" id="daterangepicker">
                                <label class="col-sm-2 text-left">DD / MM / YYYY</label>
                            </div>
                            <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">FORM</legend>
                    <div class="card-body shadow-lg cardForm">

                            <br>
                            <div class="p-0 tableFixedHeader" style="height: 250px;">
                                <table class="table table-sm table-striped table-bordered"
                                       id="table-header">
                                    <thead>
                                    <tr class="table-sm text-center">
                                        <th rowspan="3" width="3%" class="text-center small"></th>
                                        <th rowspan="3" width="10%" class="text-center small" style="text-align: center; vertical-align: middle">PLU</th>
                                        <th rowspan="3" width="20%" class="text-center small" style="text-align: center; vertical-align: middle">DESKRIPSI</th>
                                        <th rowspan="3" width="7%" class="text-center small" style="text-align: center; vertical-align: middle">QTY</th>
                                        <th rowspan="3" width="10%" class="text-center small" style="text-align: center; vertical-align: middle">SATUAN</th>
                                        <th colspan="4">Rp.</th>
                                        <th colspan="3">% Margin</th>
                                    </tr>
                                    <tr class="table-sm text-center">
                                        <th colspan="2">HPP (Include PPN)</th>
                                        <th colspan="2">Harga Jual</th>
                                        <th rowspan="2" width="7%" style="text-align: center; vertical-align: middle">Normal</th>
                                        <th colspan="2">Usulan</th>
                                    </tr>
                                    <tr class="table-sm text-center">
                                        <th width="7%">Last Cost</th>
                                        <th width="7%">Avg Cost</th>
                                        <th width="7%">Normal</th>
                                        <th width="7%">Usulan</th>
                                        <th width="7%">Last Cost</th>
                                        <th width="7%">Avg Cost</th>
                                    </tr>
                                    </thead>
                                    <tbody id="body-table-header" style="height: 250px;">
                                    @for($i = 0 ; $i< 10 ; $i++)
                                        <tr>
                                            <td>
                                                <button onclick="deleteRow(this)" class="btn btn-block btn-sm btn-danger btn-delete-row-header"><i
                                                        class="icon fas fa-times"></i></button>
                                            </td>
                                            <td class="buttonInside" style="width: 150px;">
                                                <input type="text" class="form-control plu" value="" onchange="checkPlu(this)">
                                                <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" data-toggle="modal"
                                                        data-target="#modalHelp" onclick="getIndex(this)">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            <td><input disabled class="form-control deskripsi" type="text"></td>
                                            <td><input class="form-control qty" type="text" onkeypress="return isNumberKey(event)"></td>
                                            <td><input disabled class="form-control satuan" type="text"></td>
                                            <td><input disabled class="form-control lastcost" type="text"></td>
                                            <td><input disabled class="form-control avgcost" type="text"></td>
                                            <td><input disabled class="form-control normal" type="text"></td>
                                            <td><input class="form-control usulan" onchange="calculateMargin(this)" type="text" onkeypress="return isNumberKey(event)"onkeypress="return isNumberKey(event)"></td>
                                            <td><input disabled class="form-control normalMargin" type="text"></td>
                                            <td><input disabled class="form-control lastcostMargin" type="text"></td>
                                            <td><input disabled class="form-control avgcostMargin" type="text"></td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between bd-highlight mb-3">
                                <div class="p-2 bd-highlight">* QTY hasil deal dengan Member tertentu<br>Keterangan : <br>berlaku untuk satuan jual karton dan pcs</div>
                                <div class="p-2 bd-highlight row">
                                    <input disabled class="form-control col-sm-6" name="item" type="text" id="item">
                                    <label class="col-sm-6" style="margin-top: 5px" for="item">Item</label>
                                </div>
                                <div class="p-2 bd-highlight"><button type="button" class="btn btn-primary btn-block" onclick="tambahRow()">Tambah baris</button></div>
                                <div class="p-2 bd-highlight"><button type="button" class="btn btn-success btn-block" onclick="print()">PRINT</button></div>
                            </div>

                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="modalHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Memilih PLU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalTemplate">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Plu</th>
                                        <th>Deskripsi</th>
                                        <th>Satuan</th>
                                        <th>Hargajual</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                                <p class="text-hide" id="idRow"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script src={{asset('/js/sweetalert2.js')}}></script>
    <script>
        let tempPlu;
        let indexNo;

        $(document).ready(function () {
            loadPlu('');
        });

        function loadPlu(value){
            let tableModal = $('#tableModalTemplate').DataTable({
                "ajax": {
                    'url' : '{{ url('frontoffice/formHJK/datamodal') }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'satuan', name: 'satuan'},
                    {data: 'prd_hrgjual', name: 'prd_hrgjual'},
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
                },
                "order": []
            });

            $('#tableModalTemplate_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    loadPlu(val);
                }
            })
        }

        $(document).on('click', '.modalRow', function () {
            var currentButton = $(this);
            let plu = currentButton.children().first().text();
            let deskripsi = currentButton.children().first().next().text();

            choosePlu(plu,indexNo);

        });

        function getIndex(val){
            indexNo = val.parentNode.parentNode.rowIndex-3;
        }

        $(function() {
            let d = new Date();

            let month = d.getMonth()+1;
            let day = d.getDate();

            let output =
                ((''+day).length<2 ? '0' : '') + day + '/' +
                ((''+month).length<2 ? '0' : '') + month + '/' + d.getFullYear();
            $("#daterangepicker").daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY',
                },
                minDate : output
            });
        });

        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function tambahRow() {
            $('#body-table-header').append(tempTable());
        }

        function counter(){
            let qty = 0;
            for(i = 0; i < $('.plu').length; i++) {
                if ($('.plu')[i].value != '') {
                    qty++;
                }
            }
            $('#item').val(qty);
        }

        function checkPlu(no){
            let index = no.parentNode.parentNode.rowIndex-3;
            let kode = $('.plu')[index].value;
            if(kode != ''){
                choosePlu(kode,index);
            }
        }

        function choosePlu(kode,index){
            $('#modalHelp').modal('hide');
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/frontoffice/formHJK/chooseplu',
                type: 'post',
                data: {
                    kode: kode
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if (result.kode === 1){
                        data = result.data[0];
                        let vfrac = '';
                        if(data.unit == 'KG'){
                            vfrac = 1;
                        }else{
                            vfrac = parseInt(data.frac);
                        }
                        let cpromo;
                        let nfmjual;
                        let lcost;
                        let acost;
                        let marlcost;
                        let maracost;
                        let hrgjual_normal;

                        let d = new Date();
                        let month = d.getMonth() + 1;
                        let day = d.getDate();
                        let seconds = d.getSeconds();
                        let minutes = d.getMinutes();
                        let hour = d.getHours();
                        let output =
                            (('' + month).length < 2 ? '0' : '') + month + '-' +
                            (('' + day).length < 2 ? '0' : '') + day + '-' + d.getFullYear() + ' ' +
                            (('' + hour).length < 2 ? '0' : '') + hour + ':' +
                            (('' + minutes).length < 2 ? '0' : '') + minutes + ':' +
                            (('' + seconds).length < 2 ? '0' : '') + seconds;
                        let a = data.fmfrtg + ' ' + data.fmfrhr;
                        let b = data.fmtotg + ' ' + data.fmtohr;
                        let d1 = Date.parse(output);
                        let d2 = Date.parse(a);
                        let d3 = Date.parse(b);
                        if(data.prmd_prdcd != 'xxx'){
                            if(d1 >= d2 && d1 <= d3){
                                cpromo = true;

                                if((data.pkp == 'Y' && data.pkp2 != 'P') || (data.pkp == 'Y' && data.pkp2 != 'W') || (data.pkp == 'Y' && data.pkp2 != 'G')){
                                    if(data.fmjual != 0){
                                        nfmjual = data.fmjual;
                                    }else if(data.fmpotp != 0){
                                        nfmjual = data.price_a -(data.price_a *(data.fmpotp / 100));
                                    }else{
                                        nfmjual = data.price_a - data.fmpotr;
                                    }
                                    if(data.ptag == 'Q'){
                                        lcost = data.prd_lcost;
                                        acost = data.st_lcost * vfrac;

                                        marlcost = (1 - data.prd_lcost / nfmjual) * 100;
                                        maracost = (1 -((data.st_lcost * vfrac) / nfmjual)) * 100;
                                    }else{
                                        lcost = 1.1 * data.prd_lcost;
                                        acost = 1.1 * data.st_lcost * vfrac;

                                        marlcost = (1 - 1.1 * data.prd_lcost / nfmjual) * 100;
                                        maracost = (1 - 1.1 *((data.st_lcost * vfrac)) / nfmjual) * 100;
                                    }
                                }else{
                                    if(data.fmjual != 0){
                                        nfmjual = data.fmjual;
                                    }else if(data.fmpotp != 0){
                                        nfmjual = data.price_a -(data.price_a * (data.fmpotp / 100));
                                    }else{
                                        nfmjual = data.price_a - data.fmpotr;
                                    }
                                    lcost = data.prd_lcost;
                                    acost = data.st_lcost * vfrac;

                                    marlcost = (1 - data.prd_lcost / nfmjual) * 100;
                                    maracost = (1 - (data.st_lcost * vfrac) / nfmjual) * 100;
                                }
                            }else{
                                cpromo = false;

                                if((data.pkp == 'Y'&& data.pkp2 != 'P') || (data.pkp == 'Y'&& data.pkp2 != 'W') || (data.pkp == 'Y'&& data.pkp2 != 'G')){
                                    if(data.ptag == 'Q'){
                                        lcost = data.prd_lcost;
                                        acost = data.st_lcost * vfrac;

                                        marlcost = (1 - data.prd_lcost / data.price_a) * 100;
                                        maracost = (1 - (data.st_lcost * vfrac) / data.price_a) * 100;
                                    }else{
                                        lcost = 1.1 * data.prd_lcost;
                                        acost = 1.1 * data.st_lcost * vfrac;

                                        marlcost = (1 - 1.1 * data.prd_lcost / data.price_a) * 100;
                                        maracost = (1 - 1.1 *(data.st_lcost * vfrac) / data.price_a) * 100;
                                    }
                                }
                            }
                        }else{
                            cpromo = false;

                            if(data.price_a > 0){
                                if((data.pkp == 'Y'&& data.pkp2 != 'P') || (data.pkp == 'Y'&& data.pkp2 != 'W') || (data.pkp == 'Y'&& data.pkp2 != 'G')){
                                    if(data.ptag = 'Q'){
                                        lcost = data.prd_lcost;
                                        acost = data.st_lcost * vfrac;

                                        marlcost = (1 - data.prd_lcost / data.price_a) * 100;
                                        maracost = (1 - (data.st_lcost * vfrac) / data.price_a) * 100;
                                    }else{
                                        lcost = 1.1 * data.prd_lcost;
                                        acost = 1.1 * data.st_lcost * vfrac;

                                        marlcost = (1 - 1.1 * data.prd_lcost / data.price_a) * 100;
                                        maracost = (1 - 1.1 *(data.st_lcost * vfrac) / data.price_a) * 100;
                                    }
                                }else{
                                    lcost = data.prd_lcost;
                                    acost = data.st_lcost * vfrac;

                                    marlcost = (1 - data.prd_lcost / data.price_a) * 100;
                                    maracost = (1 - (data.st_lcost * vfrac) / data.price_a) * 100;
                                }
                            }else{
                                marlcost = 0;
                                maracost = 0;
                            }
                        }
                        satuan = data.unit + '/' + data.frac;

                        if(cpromo == true){
                            hrgjual_normal = nfmjual;
                        }else{
                            hrgjual_normal = data.price_a;
                        }

                        $('.plu')[index].value = kode;
                        $('.deskripsi')[index].value = data.deskripsi;
                        $('.satuan')[index].value = satuan;
                        $('.lastcost')[index].value = parseFloat(lcost).toFixed(2);
                        $('.avgcost')[index].value = parseFloat(acost).toFixed(2);
                        $('.normal')[index].value = hrgjual_normal;
                        $('.normalMargin')[index].value = 0;
                        $('.lastcostMargin')[index].value = 0;
                        $('.avgcostMargin')[index].value = 0;

                        $('.qty')[index].value = 0;
                        $('.usulan')[index].value = 0;

                    }else{
                        swal.fire('', result.msg, 'warning');
                        $('.plu')[index].value = '';
                        $('.deskripsi')[index].value = '';
                        $('.satuan')[index].value = '';
                        $('.lastcost')[index].value = '';
                        $('.avgcost')[index].value = '';
                        $('.normal')[index].value = '';
                        $('.normalMargin')[index].value = '';
                        $('.lastcostMargin')[index].value = '';
                        $('.avgcostMargin')[index].value = '';

                        $('.qty')[index].value = '';
                        $('.usulan')[index].value = '';
                    }
                    $('#modal-loader').modal('hide');
                    counter();
                }, error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            })
        }

        function calculateMargin(e){
            let index = e.parentNode.parentNode.rowIndex-3;
            let kode = $('.plu')[index].value;
            if(kode == ''){
                swal.fire('Input masih kosong','','warning');
                $('.usulan')[index].value = '';
                return false;
            }
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/frontoffice/formHJK/calculatemargin',
                type: 'post',
                data: {
                    kode: kode
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    data = result.data[0];
                    let vfrac = '';
                    let PRSNRML = '';
                    let MARLCOST = '';
                    let MARACOST = '';
                    if (data.unit == 'KG') {
                        vfrac = 1;
                    } else {
                        vfrac = parseInt(data.frac);
                    }
                    if((data.pkp == 'Y'&& data.pkp2 != 'P') || (data.pkp == 'Y'&& data.pkp2 != 'W') || (data.pkp == 'Y'&& data.pkp2 != 'G')){
                        if(data.ptag == 'Q'){
                            PRSNRML  = (1 - data.prd_acost / parseFloat($('.normal')[index].value)) * 100;
                            MARLCOST = (1 - data.prd_lcost / parseFloat($('.usulan')[index].value)) * 100;
                            MARACOST = (1 - (data.st_lcost * vfrac) / parseFloat($('.usulan')[index].value)) * 100;
                        }else{
                            PRSNRML  = (1 - 1.1 * data.prd_acost / parseFloat($('.normal')[index].value)) * 100;
                            MARLCOST = (1 - 1.1 * data.prd_lcost / parseFloat($('.usulan')[index].value)) * 100;
                            MARACOST = (1 - 1.1 * (data.st_lcost * vfrac) / parseFloat($('.usulan')[index].value)) * 100;
                        }
                    }else{
                        PRSNRML  = (1 - data.prd_acost / parseFloat($('.normal')[index].value)) * 100;
                        MARLCOST = (1 - data.prd_lcost / parseFloat($('.usulan')[index].value)) * 100;
                        MARACOST = (1 - (data.st_lcost * vfrac) / parseFloat($('.usulan')[index].value)) * 100;
                    }
                    $('.normalMargin')[index].value = PRSNRML.toFixed(2);
                    $('.lastcostMargin')[index].value = MARLCOST.toFixed(2);
                    $('.avgcostMargin')[index].value = MARACOST.toFixed(2);
                    $('#modal-loader').modal('hide');

                }, error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            })
        }

        function deleteRow(e) {
            $(e).parents("tr").remove();
            counter();
        }

        function print() {
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal.fire('Input masih kosong','','warning');
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            let counter = 0;
            for(i = 0; i < $('.plu').length; i++) {
                if ($('.plu')[i].value != '') {
                    counter++;
                    if($('.qty')[i].value === ''){
                        $('.qty')[i].value = 0;
                    }
                    if((parseInt($('.qty')[i].value)) <= 0){
                        $('.qty')[i].focus();
                        swal.fire("Gagal", "Inputan Qty Tidak Boleh Lebih Kecil Dari 0 !!", "error");
                        return false;
                    }
                    if($('.usulan')[i].value === ''){
                        $('.usulan')[i].value = 0;
                    }
                    if((parseInt($('.usulan')[i].value)) <= 0){
                        $('.usulan')[i].focus();
                        swal.fire("Gagal", "Inputan Harga Usulan Tidak Boleh <= 0 !!", "error");
                        return false;
                    }
                }
            }
            if(counter === 0 || $('#nomorTrn').val() === ''){
                swal.fire("Gagal", "Tidak ada data !!", "error");
                return false;
            }

            let datas   = [{'plu' : '', 'deskripsi':'', 'qty' : '','satuan' : '', 'lcost' : '', 'avgcost' : '', 'normal': '', 'usulan' : '', 'normalmargin' : '', 'lcostmargin' : '', 'avgcostmargin' : ''}];

            for(i = 0; i < $('.plu').length; i++) {
                if ($('.plu')[i].value != '') {
                    datas.push({'plu' : $('.plu')[i].value, 'deskripsi' : $('.deskripsi')[i].value, 'qty' : $('.qty')[i].value,'satuan' : $('.satuan')[i].value, 'lcost' : $('.lastcost')[i].value, 'avgcost' : $('.avgcost')[i].value, 'normal': $('.normal')[i].value, 'usulan' : $('.usulan')[i].value, 'normalmargin' : $('.normalMargin')[i].value, 'lcostmargin' : $('.lastcostMargin')[i].value, 'avgcostmargin' : $('.avgcostMargin')[i].value})
                }
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/frontoffice/formHJK/printdocument',
                type: 'get',
                data: {
                    dateA:dateA,
                    dateB:dateB,
                    datas:datas
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (w) {
                    window.open(this.url,'_blank');
                    $('#modal-loader').modal('hide');
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }

        function tempTable() {
            var temptbl =  ` <tr>
                                            <td>
                                                <button onclick="deleteRow(this)" class="btn btn-block btn-sm btn-danger btn-delete-row-header"><i
                                                        class="icon fas fa-times"></i></button>
                                            </td>
                                            <td class="buttonInside" style="width: 150px;">
                                                <input type="text" class="form-control plu" value="">
                                                <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" data-toggle="modal"
                                                        data-target="#modalHelp" onclick="getIndex(this)">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            <td><input disabled class="form-control deskripsi" type="text"></td>
                                            <td><input class="form-control qty" type="text" onkeypress="return isNumberKey(event)"></td>
                                            <td><input disabled class="form-control satuan" type="text"></td>
                                            <td><input disabled class="form-control lastcost" type="text"></td>
                                            <td><input disabled class="form-control avgcost" type="text"></td>
                                            <td><input disabled class="form-control normal" type="text"></td>
                                            <td><input class="form-control usulan" onchange="calculateMargin(this)" type="text" onkeypress="return isNumberKey(event)"></td>
                                            <td><input disabled class="form-control normalMargin" type="text"></td>
                                            <td><input disabled class="form-control lastcostMargin" type="text"></td>
                                            <td><input disabled class="form-control avgcostMargin" type="text"></td>
                                        </tr>`

            return temptbl;
        }
    </script>
@endsection
