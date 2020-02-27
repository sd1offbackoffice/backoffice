@extends('navbar')
@section('content')


    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Kertas Kerja Estimasi Kebutuhan Toko IGR</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <label for="periode" class="col-sm-1 col-form-label">Tanggal</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control tanggal" id="periode" readonly>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="keterangan" readonly value="DATA KKEI">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 pr-0">
                                <fieldset class="card border-secondary">
                                    <legend class="w-auto ml-4">Detail</legend>
                                    <div class="kiri col-sm table-wrapper-scroll-y my-custom-scrollbar scroll-y">
                                        <table id="table-detail" class="table table-sm table-bordered m-1 mb-4">
                                            <thead>
                                            <tr class="d-flex text-center putih">
                                                <th class="col-sm-12">.</th>
                                            </tr>
                                            <tr class="col-sm-12"></tr>
                                            <tr class="d-flex text-center">
                                                <th class="col-sm-2"></th>
                                                <th class="col-sm-4">PLU</th>
                                                <th class="col-sm-3">Unit</th>
                                                <th class="col-sm-3">Frac</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php for($i=0;$i<10;$i++){ @endphp
                                            <tr class="d-flex baris" id="row_detail_{{ $i }}">
                                                <td class="col-sm-2 text-center">
                                                    <button onclick="deleteRow({{ $i }})" class="col-sm btn btn-danger btn-delete">X</button>
                                                </td>
                                                <td class="col-sm-4">
                                                    <input type="number" class="form-control i-plu" onkeypress="get_detail_produk(event,'{{ $i }}')">
                                                </td>
                                                <td class="col-sm-3">
                                                    <input disabled type="text" class="form-control unit">
                                                </td>
                                                <td class="col-sm-3">
                                                    <input disabled type="text" class="form-control frac">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control deskripsi">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control panjangproduk">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control lebarproduk">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control tinggiproduk">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control panjangkemasan">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control lebarkemasan">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control tinggikemasan">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control beratprod">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control beratkmsn">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control kubikasiprod">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control kubikasikemasan">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control kodesupplier">
                                                </td>
                                                <td hidden>
                                                    <input type="text" class="form-control namasupplier">
                                                </td>
                                            </tr>
                                            @php } @endphp
                                            </tbody>
                                            <tfoot>
                                                <tr class="d-flex putih">
                                                    <td class="col-sm-12"><input disabled type="text" class="form-control" style="background-color: white;border: none;"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-sm-8 pl-0">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-4">Form</legend>
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden">
                                        <table id="table-form" class="table table-sm table-bordered mb-3">
                                            <thead>
                                            <tr class="d-flex text-center">
                                                <th class="col-sm-4"></th>
                                                <th class="col-sm-6">--- Sales 3 Bulan Terakhir ---</th>
                                                <th class="col-sm-4">-- AVG Sales --</th>
                                                <th class="col-sm-4"></th>
                                                <th class="col-sm-10">------ Breakdown PB ------</th>
                                                <th class="col-sm-4">---- Buffer ----</th>
                                                <th class="col-sm-2"></th>
                                                <th class="col-sm-2">Outstanding PO</th>
                                                <th class="col-sm-10">------ Tanggal Kirim ------</th>
                                            </tr>
                                            <tr class="d-flex text-center">
                                                <th class="col-sm-2">Harga Beli</th>
                                                <th class="col-sm-2">Discount</th>
                                                <th class="col-sm-2">1</th>
                                                <th class="col-sm-2">2</th>
                                                <th class="col-sm-2">3</th>
                                                <th class="col-sm-2">Bulan</th>
                                                <th class="col-sm-2">Hari</th>
                                                <th class="col-sm-2">Saldo Awal</th>
                                                <th class="col-sm-2">Estimasi in PCS</th>
                                                <th class="col-sm-2">Minggu 1</th>
                                                <th class="col-sm-2">Minggu 2</th>
                                                <th class="col-sm-2">Minggu 3</th>
                                                <th class="col-sm-2">Minggu 4</th>
                                                <th class="col-sm-2">Minggu 5</th>
                                                <th class="col-sm-2">Lead Time</th>
                                                <th class="col-sm-2">Safety Stock</th>
                                                <th class="col-sm-2">Saldo Akhir</th>
                                                <th class="col-sm-1">Total</th>
                                                <th class="col-sm-1">QTY</th>
                                                <th class="col-sm-2">1</th>
                                                <th class="col-sm-2">2</th>
                                                <th class="col-sm-2">3</th>
                                                <th class="col-sm-2">4</th>
                                                <th class="col-sm-2">5</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php for($i=0;$i<10;$i++){ @endphp
                                            <tr id="row_form_{{ $i }}" class="d-flex baris number">
                                                <td class="col-sm-2"><input disabled type="text" class="form-control hargabeli"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control discount"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control sales1"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control sales2"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control sales3"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control avgbulan"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control avghari"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control saldoawal"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control estimasi"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control minggu1"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control minggu2"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control minggu3"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control minggu4"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control minggu5"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control leadtime"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control safetystock"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control saldoakhir"></td>
                                                <td class="col-sm-1"><input disabled type="text" class="form-control total"></td>
                                                <td class="col-sm-1"><input disabled type="text" class="form-control qty"></td>
                                                <td class="col-sm-2"><input readonly type="text" class="form-control tanggal tglkirim1"></td>
                                                <td class="col-sm-2"><input readonly type="text" class="form-control tanggal tglkirim2"></td>
                                                <td class="col-sm-2"><input readonly type="text" class="form-control tanggal tglkirim3"></td>
                                                <td class="col-sm-2"><input readonly type="text" class="form-control tanggal tglkirim4"></td>
                                                <td class="col-sm-2"><input readonly type="text" class="form-control tanggal tglkirim5"></td>
                                            </tr>
                                            @php } @endphp
                                            </tbody>
                                            <tfoot>
                                                <tr class="d-flex text-center">
                                                    <td class="col-sm-12"></td>
                                                    <th class="col-sm-4 text-right">Total Kubikasi</th>
                                                    <th class="col-sm-2"><input disabled type="text" class="form-control"></th>
                                                    <th class="col-sm-2"><input disabled type="text" class="form-control"></th>
                                                    <th class="col-sm-2"><input disabled type="text" class="form-control"></th>
                                                    <th class="col-sm-2"><input disabled type="text" class="form-control"></th>
                                                    <th class="col-sm-2"><input disabled type="text" class="form-control"></th>
                                                    <th class="col-sm-2"><input disabled type="text" class="form-control"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="txt_deskripsi" readonly>
                            </div>
                            <div class="col-sm-5 mb-1 text-right">
                                <button id="btn-save" class="col-sm-3 btn btn-success">SAVE</button>
                                <button id="btn-print" class="col-sm-3 btn btn-primary">PRINT</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <h4>Kebutuhan Kontainer : 20 Feet</h4>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>

    {{--LOADER--}}
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12 text-center">
                                <label for="">LOADING...</label>
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
        label {
            color: #232443;
            font-weight: bold;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_divisi:hover{
            cursor: pointer;
            background-color: grey;
        }
        .my-custom-scrollbar {
            position: relative;
            height: 564px;
            overflow-x: auto;
        }

        .hidden{
            overflow-y: hidden;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .kiri{
            height: 570px;
        }

        .putih{
            color: white;
        }
        .putih th, table{
            border: none;
        }

        .number input{
            text-align: right;
        }

    </style>

    <script>

        $('.tanggal').datepicker({
            "dateFormat" : "dd/mm/yy"
        });

        $('#periode').val(formatDate('now'));

        $('input').on('click',function(){
            $(this).select();
        });

        //scroll bersamaan
        $('.scroll-y').on('scroll', function(){
            $(".scroll-y").not(this).scrollTop($(this).scrollTop());
        });

        $('#row_detail_0').find('.i-plu').select();

        currentPos = 0;
        currentIndex = 0;
        special = false;
        rowCount = 10;

        ready();

        function ready(){
            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy"
            });

            $('input').on('keypress',function(event){
                if(event.which == 13 && $(this).attr('class').substr(-5) != 'i-plu'){
                    if($(this).attr('class').substr(-11) == 'safetystock'){
                        $(this).parent().parent().find('.tglkirim1').select();
                    }
                    else if($(this).attr('class').substr(-9) == 'tglkirim5'){
                        rowNext = parseInt($(this).parent().parent().attr('id').substr(-1)) + 1;
                        $('#row_detail_'+rowNext).find('.i-plu').select();
                    }
                    else{
                        $(this).parent().next().find('input').select();
                    }
                }
            });

            $('input').focus(function (event) {
                if($(this).attr('id') != 'periode' && $(this).attr('id') != 'keterangan'){
                    // console.log($(this).parent().parent().find('.deskripsi').val());
                    currentRow = $(this).parent().parent().attr('id').substr(-1);
                    $('#txt_deskripsi').val($('#row_detail_'+currentRow).find('.deskripsi').val());


                    if($(this).attr('class').substr(-5) == 'i-plu'){
                        $('.table-wrapper-scroll-y').animate({ scrollLeft: 0 }, 300);
                        currentPos = 0;
                        currentIndex = 0;
                    }
                    else if(special){
                        currentPos = ($(this).parent().index()) * $(this).parent().width();
                        $('.table-wrapper-scroll-y').animate({ scrollLeft: currentPos }, 300);
                        special = false;
                    }
                    else if(currentIndex < $(this).parent().index()){
                        if($(this).attr('class').substr(-8) == 'estimasi'){
                            pos = $(this).parent().position().left;
                            currentPos += pos;
                            $('.table-wrapper-scroll-y').animate({ scrollLeft: currentPos }, 300);
                            currentIndex = $(this).parent().index();
                        }
                        else{
                            pos = $(this).parent().position().left;
                            currentPos += pos;
                            $('.table-wrapper-scroll-y').animate({ scrollLeft: currentPos }, 300);
                            currentIndex = $(this).parent().index();
                        }
                    }
                    else{
                        currentIndex = $(this).parent().index();
                        special = true;
                    }
                }

            });

            $('.tglkirim5').on('change',function(){
                rowNext = parseInt($(this).parent().parent().attr('id').substr(-1)) + 1;

                $('#row_detail_'+rowNext).find('.i-plu').select();
            });

            $('#periode').on('change',function(){
                get_detail_kkei($(this).val());
            });
        }

        function get_detail_produk(event,row){
            if(event.which == 13){
                if($(event.target).val().length <= 7 && $(event.target).val().length > 0){
                    prdcd = convertPlu($(event.target).val());

                    ada = false;

                    $('.i-plu').each(function(){
                        if($(this).parent().parent().attr('id') != 'row_detail_'+row){
                            if($(this).val() == prdcd){
                                ada = true;
                                return 0;
                            }
                        }
                    });

                    if(!ada){
                        $.ajax({
                            url: '/BackOffice/public/bokkei/get_detail_produk',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {prdcd: prdcd, periode: $('#periode').val()},
                            beforeSend: function () {
                                $('#modal-loader').modal('toggle');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('toggle');

                                console.log(response);
                                if (response.status == 'success') {
                                    $('#row_form_'+row).find('input').each(function () {
                                        $(this).val('0');
                                    });
                                    $('#row_form_'+row).find('.tanggal').each(function () {
                                        $(this).val('');
                                    });

                                    $('#row_detail_'+row).find('.i-plu').val(response.data.prd_prdcd);
                                    $('#row_detail_'+row).find('.unit').val(response.data.unit);
                                    $('#row_detail_'+row).find('.frac').val(response.data.frac);
                                    $('#row_form_'+row).find('.hargabeli').val(convertToRupiah2(response.data.hargabeli));
                                    $('#row_form_'+row).find('.discount').val(convertToRupiah(response.data.diskon));
                                    $('#row_form_'+row).find('.sales1').val(convertToRupiah2(response.data.sales1));
                                    $('#row_form_'+row).find('.sales2').val(convertToRupiah2(response.data.sales2));
                                    $('#row_form_'+row).find('.sales3').val(convertToRupiah2(response.data.sales3));
                                    $('#row_form_'+row).find('.avgbulan').val(convertToRupiah(response.data.avgslsbln));
                                    $('#row_form_'+row).find('.avghari').val(convertToRupiah(response.data.avgslshari));
                                    $('#row_form_'+row).find('.saldoawal').val(response.data.saldoawal);
                                    $('#row_form_'+row).find('.saldoakhir').val(response.data.saldoakhir);

                                    $('#row_detail_'+row).find('.deskripsi').val(response.data.deskripsi);


                                    $('#row_form_'+row).find('.estimasi').prop('disabled',false);
                                    $('#row_form_'+row).find('.estimasi').select();
                                    $('#txt_deskripsi').val($('#row_detail_'+row).find('.deskripsi').val());

                                    $('#row_detail_'+row).find('.panjangproduk').val(response.data.panjangproduk);
                                    $('#row_detail_'+row).find('.lebarproduk').val(response.data.lebarproduk);
                                    $('#row_detail_'+row).find('.tinggiproduk').val(response.data.tinggiproduk);
                                    $('#row_detail_'+row).find('.panjangkemasan').val(response.data.panjangkemasan);
                                    $('#row_detail_'+row).find('.lebarkemasan').val(response.data.lebarkemasan);
                                    $('#row_detail_'+row).find('.tinggikemasan').val(response.data.tinggikemasan);
                                    $('#row_detail_'+row).find('.beratprod').val(response.data.beratprod);
                                    $('#row_detail_'+row).find('.beratkmsn').val(response.data.beratkmsn);
                                    $('#row_detail_'+row).find('.kubikasiprod').val(response.data.kubikasiprod);
                                    $('#row_detail_'+row).find('.kubikasikemasan').val(response.data.kubikasikemasan);
                                    $('#row_detail_'+row).find('.kodesupplier').val(response.data.kodesupplier);
                                    $('#row_detail_'+row).find('.namasupplier').val(response.data.namasupplier);
                                }
                                else {
                                    swal({
                                        title: response.message,
                                        icon: "error"
                                    }).then(function () {
                                        $(event.target).select();
                                    });
                                }
                            }
                        });
                    }
                    else{
                        swal({
                            title: 'Kode produk '+prdcd+' sudah ada!',
                            icon: 'error'
                        }).then(function(){
                            $(event.target).select();
                        });
                    }
                }
                else{
                    swal({
                        title: 'Cek kembali PLU',
                        icon: 'error'
                    }).then(function(){
                        $(event.target).select();
                    });
                }
            }
        }

        function get_detail_kkei(periode){
            periode = periode.replace(/\//g, '')

            $.ajax({
                url: '/BackOffice/public/bokkei/get_detail_kkei',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {periode: periode},
                beforeSend: function () {
                    $('#modal-loader').modal('toggle');
                },
                success: function (response) {
                    $('#modal-loader').modal('toggle');

                    console.log(response.data[0]);
                    if (response.status == 'success') {
                        $('#table-detail').find('tbody tr').remove();
                        $('#table-form').find('tbody tr').remove();

                        rowCount = 0;

                        for(i=0;i<response.data.length;i++){
                            trDetail = '<tr class="d-flex baris"  id="row_detail_'+rowCount+'">' +
                                '<td class="col-sm-2 text-center">' +
                                '<button class="col-sm btn btn-danger btn-delete" onclick="deleteRow('+rowCount+')">X</button>' +
                                '</td>' +
                                '<td class="col-sm-4">' +
                                '<input type="number" class="form-control i-plu" onkeypress="get_detail_produk(event,'+rowCount+')" value="'+response.data[i].kke_prdcd+'">' +
                                '</td>' +
                                '<td class="col-sm-3">' +
                                '<input disabled type="text" class="form-control unit" value='+response.data[i].kke_unit+'>' +
                                '</td>' +
                                '<td class="col-sm-3">' +
                                '<input disabled type="text" class="form-control frac" value='+response.data[i].kke_frac+'>' +
                                '</td>' +
                                '<td hidden>'+
                                '<input type="text" class="form-control deskripsi" value='+response.data[i].kke_deskripsi+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control panjangproduk" value='+response.data[i].kke_panjangproduk+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control lebarproduk" value='+response.data[i].kke_lebarprod+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control tinggiproduk" value='+response.data[i].kke_tinggiprod+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control panjangkemasan" value='+response.data[i].kke_panjangkmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control lebarkemasan" value='+response.data[i].kke_lebarkmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control tinggikemasan" value='+response.data[i].kke_tinggikmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control beratprod" value='+response.data[i].kke_beratproduk+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control beratkmsn" value='+response.data[i].kke_beratkmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kubikasiprod" value='+response.data[i].kke_kubikasiprod+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kubikasikemasan" value='+response.data[i].kke_kubikasikmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kodesupplier" value='+response.data[i].kke_kdsup+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control namasupplier" value='+response.data[i].kke_nmsup+'>'+
                                '</td>'
                                '</tr>';

                            trForm = '<tr id="row_form_' + i + '" class="d-flex baris number">' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control hargabeli" value=' + convertToRupiah2(response.data[i].kke_hargabeli) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control discount" value=' + convertToRupiah2(Math.round(response.data[i].kke_discount)) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control sales1" value=' + convertToRupiah2(response.data[i].kke_sales01) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control sales2" value=' + convertToRupiah2(response.data[i].kke_sales01) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control sales3" value=' + convertToRupiah2(response.data[i].kke_sales03) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control avgbulan" value=' + convertToRupiah(response.data[i].kke_avgbln) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control avghari" value=' + convertToRupiah(response.data[i].kke_avghari) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control saldoawal" value=' + response.data[i].kke_saldoawal + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control estimasi" value=' + convertToRupiah2(response.data[i].kke_estimasi) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control minggu1" value=' + convertToRupiah2(response.data[i].kke_breakpb01) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control minggu2" value=' + convertToRupiah2(response.data[i].kke_breakpb02) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control minggu3" value=' + convertToRupiah2(response.data[i].kke_breakpb03) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control minggu4" value=' + convertToRupiah2(response.data[i].kke_breakpb04) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control minggu5" value=' + convertToRupiah2(response.data[i].kke_breakpb05) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control leadtime" value=' + response.data[i].kke_bufferlt + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control safetystock" value=' + response.data[i].kke_bufferss + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control saldoakhir" value=' + response.data[i].kke_saldoakhir + '></td>' +
                                '<td class="col-sm-1">' +
                                '<input disabled type="text" class="form-control total" value=' + response.data[i].kke_outpototal + '></td>' +
                                '<td class="col-sm-1">' +
                                '<input disabled type="text" class="form-control qty" value=' + response.data[i].kke_outpoqty + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input readonly type="text" class="form-control tanggal tglkirim1" value=' + formatDate(response.data[i].kke_tglkirim01) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input readonly type="text" class="form-control tanggal tglkirim2" value=' + formatDate(response.data[i].kke_tglkirim02) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input readonly type="text" class="form-control tanggal tglkirim3" value=' + formatDate(response.data[i].kke_tglkirim03) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input readonly type="text" class="form-control tanggal tglkirim4" value=' + formatDate(response.data[i].kke_tglkirim04) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input readonly type="text" class="form-control tanggal tglkirim5" value=' + formatDate(response.data[i].kke_tglkirim05) + '></td> value=' + response.data[i].kke_asdfka + '' +
                                '</tr>';

                            $('#table-detail').append(trDetail);
                            $('#table-form').append(trForm);

                            rowCount++;
                        }

                        for(i=response.data.length;i<10;i++){
                            addRow();
                        }

                        if(response.data[0].kke_upload == 'Y'){
                            $('#keterangan').val('DATA SUDAH DIUPLOAD');
                            $('input').each(function(){
                                $(this).prop('readonly',true);
                            });
                            $('button').each(function(){
                                $(this).prop('disabled',true);
                            });

                            $('#periode').prop('disabled',false);
                        }
                        else{
                            $('#keterangan').val('DATA BELUM DIUPLOAD');
                        }

                        ready();
                    }
                    else {
                        swal({
                            title: response.message,
                            icon: "error"
                        }).then(function () {
                            $(event.target).select();
                        });
                    }
                }
            });
        }

        function addRow(){
            trDetail = '<tr class="d-flex baris"  id="row_detail_'+rowCount+'">' +
                            '<td class="col-sm-2 text-center">' +
                            '<button class="col-sm btn btn-danger btn-delete" onclick="deleteRow('+rowCount+')">X</button>' +
                            '</td>' +
                            '<td class="col-sm-4">' +
                            '<input type="number" class="form-control i-plu" onkeypress="get_detail_produk(event,'+rowCount+')">' +
                            '</td>' +
                            '<td class="col-sm-3">' +
                            '<input disabled type="text" class="form-control unit">' +
                            '</td>' +
                            '<td class="col-sm-3">' +
                            '<input disabled type="text" class="form-control frac">' +
                            '</td>' +
                            '<td hidden>'+
                            '<input type="text" class="form-control deskripsi">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control panjangproduk">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control lebarproduk">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control tinggiproduk">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control panjangkemasan">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control lebarkemasan">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control tinggikemasan">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control beratprod">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control beratkmsn">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kubikasiprod">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kubikasikemasan">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kodesupplier">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control namasupplier">' +
                            '</td>'
                        '</tr>';

            trForm = '<tr id="row_form_' + i + '" class="d-flex baris number">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control hargabeli">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control discount">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control sales1">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control sales2">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control sales3">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control avgbulan">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control avghari">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control saldoawal">' +
                        '<td class="col-sm-2">' +
                        '<input type="text" class="form-control estimasi">' +
                        '<td class="col-sm-2">' +
                        '<input type="text" class="form-control minggu1">' +
                        '<td class="col-sm-2">' +
                        '<input type="text" class="form-control minggu2">' +
                        '<td class="col-sm-2">' +
                        '<input type="text" class="form-control minggu3">' +
                        '<td class="col-sm-2">' +
                        '<input type="text" class="form-control minggu4">' +
                        '<td class="col-sm-2">' +
                        '<input type="text" class="form-control minggu5">' +
                        '<td class="col-sm-2">' +
                        '<input type="text" class="form-control leadtime">' +
                        '<td class="col-sm-2">' +
                        '<input type="text" class="form-control safetystock">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control saldoakhir">' +
                        '<td class="col-sm-1">' +
                        '<input disabled type="text" class="form-control total">' +
                        '<td class="col-sm-1">' +
                        '<input disabled type="text" class="form-control qty">' +
                        '<td class="col-sm-2">' +
                        '<input readonly type="text" class="form-control tanggal tglkirim1">' +
                        '<td class="col-sm-2">' +
                        '<input readonly type="text" class="form-control tanggal tglkirim2">' +
                        '<td class="col-sm-2">' +
                        '<input readonly type="text" class="form-control tanggal tglkirim3">' +
                        '<td class="col-sm-2">' +
                        '<input readonly type="text" class="form-control tanggal tglkirim4">' +
                        '<td class="col-sm-2">' +
                        '<input readonly type="text" class="form-control tanggal tglkirim5">' +
                    '</tr>';

            $('#table-detail').append(trDetail);
            $('#table-form').append(trForm);

            rowCount++;
        }

        function deleteRow(row){
            $('#row_detail_'+row).remove();
            $('#row_form_'+row).remove();

            count = 0;
            $('#table-detail').find('#row_detail').each(function(){
                count++;
            });

            if(count < 10){
                addRow();
            }
        }


    </script>

@endsection
