@extends('navbar')
@section('title','PB | KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR')
@section('content')


    <div class="container-fluid">
        <fieldset class="card border-secondary">
            <div class="card-body shadow-lg cardForm">
                <div class="row">
                    <label for="periode" class="col-sm-1 col-form-label">Tanggal</label>
                    <div class="col-sm-2">
                        <input maxlength="10" type="text" class="form-control tanggal" id="periode">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="keterangan" disabled value="DATA KKEI">
                    </div>
                </div>
{{--                <table id="table_data" class="table table-sm table-striped table-bordered mb-3 text-center">--}}
{{--                    --}}{{--                    <table id="table_data" class="table table-sm table-bordered mb-3 text-left">--}}
{{--                    <thead class="theadDataTables text-center">--}}
{{--                    <tr class="">--}}
{{--                        <th rowspan="2"><i class="fas fa-trash"></i> </th>--}}
{{--                        <th rowspan="2">PLU</th>--}}
{{--                        <th rowspan="2">Unit</th>--}}
{{--                        <th rowspan="2">Frac</th>--}}
{{--                        <th rowspan="2">Harga Beli</th>--}}
{{--                        <th rowspan="2">Discount</th>--}}
{{--                        <th colspan="3">--- Sales 3 Bulan Terakhir ---</th>--}}
{{--                        <th colspan="2">--- AVG Sales ---</th>--}}
{{--                        <th rowspan="2">Saldo Akhir</th>--}}
{{--                        <th rowspan="2">Estimasi in PCS</th>--}}
{{--                        <th colspan="5">--- Breakdown PB ---</th>--}}
{{--                        <th colspan="2">--- Buffer ---</th>--}}
{{--                        <th rowspan="2">Saldo Akhir</th>--}}
{{--                        <th colspan="2">Outstanding PO</th>--}}
{{--                        <th colspan="5">--- Tanggal Kirim ---</th>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th>1</th>--}}
{{--                        <th>2</th>--}}
{{--                        <th>3</th>--}}
{{--                        <th>Bulan</th>--}}
{{--                        <th>Hari</th>--}}
{{--                        <th>Minggu 1</th>--}}
{{--                        <th>Minggu 2</th>--}}
{{--                        <th>Minggu 3</th>--}}
{{--                        <th>Minggu 4</th>--}}
{{--                        <th>Minggu 5</th>--}}
{{--                        <th>Lead Time</th>--}}
{{--                        <th>Safety Stock</th>--}}
{{--                        <th>Total</th>--}}
{{--                        <th>QTY</th>--}}
{{--                        <th>1</th>--}}
{{--                        <th>2</th>--}}
{{--                        <th>3</th>--}}
{{--                        <th>4</th>--}}
{{--                        <th>5</th>--}}
{{--                    </tr>--}}
{{--                        <tr class="">--}}
{{--                            <th rowspan="2"><i class="fas fa-trash"></i> </th>--}}
{{--                            <th rowspan="2">PLU</th>--}}
{{--                            <th rowspan="2">Unit</th>--}}
{{--                            <th rowspan="2">Frac</th>--}}
{{--                            <th rowspan="2">Harga Beli</th>--}}
{{--                            <th rowspan="2">Discount</th>--}}
{{--                            <th colspan="3">--- Sales 3 Bulan Terakhir ---</th>--}}
{{--                            <th colspan="2">--- AVG Sales ---</th>--}}
{{--                            <th rowspan="2">Saldo Akhir</th>--}}
{{--                            <th rowspan="2">Estimasi in PCS</th>--}}
{{--                            <th colspan="5">--- Breakdown PB ---</th>--}}
{{--                            <th colspan="2">--- Buffer ---</th>--}}
{{--                            <th rowspan="2">Saldo Akhir</th>--}}
{{--                            <th colspan="2">Outstanding PO</th>--}}
{{--                            <th colspan="5">--- Tanggal Kirim ---</th>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <th>1</th>--}}
{{--                            <th>2</th>--}}
{{--                            <th>3</th>--}}
{{--                            <th>Bulan</th>--}}
{{--                            <th>Hari</th>--}}
{{--                            <th>Minggu 1</th>--}}
{{--                            <th>Minggu 2</th>--}}
{{--                            <th>Minggu 3</th>--}}
{{--                            <th>Minggu 4</th>--}}
{{--                            <th>Minggu 5</th>--}}
{{--                            <th>Lead Time</th>--}}
{{--                            <th>Safety Stock</th>--}}
{{--                            <th>Total</th>--}}
{{--                            <th>QTY</th>--}}
{{--                            <th>1</th>--}}
{{--                            <th>2</th>--}}
{{--                            <th>3</th>--}}
{{--                            <th>4</th>--}}
{{--                            <th>5</th>--}}
{{--                        </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                        <tr>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                            <td></td>--}}
{{--                        </tr>--}}
{{--                    </tbody>--}}
{{--                </table>--}}
                <div class="row">
                    <div class="col-sm-3 pr-0">
                        <fieldset class="card border-secondary">
                            <legend class="w-auto ml-4">Detail</legend>
{{--                            <div class="kiri col-sm table-wrapper-scroll-y my-custom-scrollbar scroll-y">--}}
                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y" style="position: sticky; overflow-x: hidden">
                                <table id="table-detail" class="table table-sm table-bordered m-1 mb-4">
                                    <thead>
                                    <tr class="d-flex text-center putih">
                                        <th class="col-sm-12" style="color: #5AA4DD">.</th>
                                    </tr>
                                    <tr class="d-flex text-center">
                                        <th class="col-sm-2"></th>
                                        <th class="col-sm-4">PLU</th>
                                        <th class="col-sm-3">Unit</th>
                                        <th class="col-sm-3">Frac</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @for($i=0;$i<10;$i++)
                                    <tr class="d-flex baris" id="row_detail_{{ $i }}">
                                        <td class="col-sm-2 text-center">
                                            <button onclick="deleteRow({{ $i }})" class="col-sm btn btn-danger btn-delete">X</button>
                                        </td>
                                        <td class="col-sm-4">
                                            <input type="number" class="form-control kke_prdcd" onkeypress="get_detail_produk(event,'{{ $i }}')">
                                        </td>
                                        <td class="col-sm-3">
                                            <input disabled type="text" class="form-control kke_unit">
                                        </td>
                                        <td class="col-sm-3">
                                            <input disabled type="text" class="form-control kke_frac">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_deskripsi">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_panjangprod">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_lebarprod">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_tinggiprod">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_panjangkmsn">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_lebarkmsn">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_tinggikmsn">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_beratproduk">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_beratkmsn">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_kubikasiprod">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_kubikasikmsn">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_kdsup">
                                        </td>
                                        <td hidden>
                                            <input type="text" class="form-control kke_nmsup">
                                        </td>
                                    </tr>
                                    @endfor
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
                            <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y" style="position: sticky">
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
                                        <th class="col-sm-2">Saldo Akhir</th>
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
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_hargabeli"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_discount"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_sales01"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_sales02"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_sales03"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_avgbln"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_avghari"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_saldoawal"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control cek kke_estimasi"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control cek kke_breakpb01"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control cek kke_breakpb02"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control cek kke_breakpb03"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control cek kke_breakpb04"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control cek kke_breakpb05"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_bufferlt"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_bufferss"></td>
                                        <td class="col-sm-2"><input disabled type="text" class="form-control kke_saldoakhir"></td>
                                        <td class="col-sm-1"><input disabled type="text" class="form-control kke_outpototal"></td>
                                        <td class="col-sm-1"><input disabled type="text" class="form-control kke_outpoqty"></td>
                                        <td class="col-sm-2"><input maxlength="10" type="text" class="form-control tanggal kke_tglkirim01"></td>
                                        <td class="col-sm-2"><input maxlength="10" type="text" class="form-control tanggal kke_tglkirim02"></td>
                                        <td class="col-sm-2"><input maxlength="10" type="text" class="form-control tanggal kke_tglkirim03"></td>
                                        <td class="col-sm-2"><input maxlength="10" type="text" class="form-control tanggal kke_tglkirim04"></td>
                                        <td class="col-sm-2"><input maxlength="10" type="text" class="form-control tanggal kke_tglkirim05"></td>
                                    </tr>
                                    @php } @endphp
                                    </tbody>
                                    <tfoot>
                                        <tr class="d-flex text-center">
                                            <td class="col-sm-12"></td>
                                            <th class="col-sm-4 text-right"><h4 class="">Total Kubikasi</h4></th>
                                            <th class="col-sm-2"><input disabled type="text" class="form-control" id="total_kke_estimasi"></th>
                                            <th class="col-sm-2"><input disabled type="text" class="form-control" id="total_kke_breakpb01"></th>
                                            <th class="col-sm-2"><input disabled type="text" class="form-control" id="total_kke_breakpb02"></th>
                                            <th class="col-sm-2"><input disabled type="text" class="form-control" id="total_kke_breakpb03"></th>
                                            <th class="col-sm-2"><input disabled type="text" class="form-control" id="total_kke_breakpb04"></th>
                                            <th class="col-sm-2"><input disabled type="text" class="form-control" id="total_kke_breakpb05"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row mt-2">
                    <label for="periode" class="col-sm-1 col-form-label text-right pr-0">Search PLU :</label>
                    <div class="col-sm-2 pr-0">
                        <input type="text" class="form-control" id="i-search" maxlength="7">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-6">
                        <input disabled type="text" class="form-control" id="txt_deskripsi">
                    </div>
                    <div class="col-sm-5 mb-1 text-right">
                        <button id="btn-save" class="col-sm-3 btn btn-success" onclick="save()">SAVE</button>
                        <button id="btn-print" class="col-sm-3 btn btn-primary" onclick="print()">PRINT</button>
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
            /*overflow-y: hidden;*/
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

        #table_data thead th{
            vertical-align: middle;
        }

        #table_data td{
            white-space: nowrap;
        }

        thead tr th{
            background-color: #5AA4DD;
            color: white;
        }

    </style>

    <script>
        var getDetail = false;

        $(document).ready(function(){
            ready();

            $('#periode').prop('disabled',false);
            $('#periode').on('keydown',function(event){
                if(event.which == 13 && checkDate($(this).val()) && !getDetail){
                    getDetail = true;
                    get_detail_kkei($(this).val());
                }
            });

            initTable();
        });

        function initTable(){
            $('#table_data').DataTable({
                sort: false,
                scrollY: 350,
                scrollX: true,
                scrollCollapse: true,
                searching: false,
                paging: false,
                fixedColumns: true,
                fixedColumns:   {
                    leftColumns: 3,
                    rigthColumns: 1
                }
            });
        }

        $('.tanggal').datepicker({
            "dateFormat" : "dd/mm/yy"
        });

        $('#periode').val(formatDate('now'));

        //scroll bersamaan
        $('.scroll-y').on('scroll', function(){
            $(".scroll-y").not(this).scrollTop($(this).scrollTop());
        });

        $('#periode').select();

        currentPos = 0;
        currentIndex = 0;
        special = false;
        rowCount = 0;
        deletable = false;
        deleted = [];

        edit = true;

        saldowal = 0;

        function ready(){
            $('#total_kke_estimasi').val(0);
            $('#total_kke_breakpb01').val(0);
            $('#total_kke_breakpb02').val(0);
            $('#total_kke_breakpb03').val(0);
            $('#total_kke_breakpb04').val(0);
            $('#total_kke_breakpb05').val(0);
            $('#txt_deskripsi').val('');
            $('#btn-save').prop('disabled',true);
            $('#btn-print').prop('disabled',true);

            $('.tanggal').off('blur change');
            $('input').off('click');
            $('input').off('keypress');
            $('.kke_tglkirim05').off('change');
            $('.cek').off('change blur');
            $('#periode').off('change');

            $('#periode').on('change',function(){
                if(checkDate($(this).val()) && !getDetail){
                    getDetail = true;
                    get_detail_kkei($(this).val());
                }
            });

            $('#i-search').on('keypress',function(event){
                if(event.which == 13){
                    search($(this).val());
                }
            });

            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy"
            });

            $('.tanggal').each(function(){
                if($(this).attr('class').split(' ').pop() == 'hasDatepicker'){
                    thisClass = $(this).attr('class').split(' ');
                    thisClass = thisClass[thisClass.length - 2];
                    $(this).removeClass(thisClass).addClass(thisClass);
                }
            });

            $('.tanggal').on('blur change',function(){
                if($(this).val() != '' && !checkDate($(this).val())){
                    if($(this).attr('id') == 'periode')
                        id = $(this).attr('id');
                    else id = $(this).parent().parent().attr('id');
                    thisClass = $(this).attr('class').split(' ').pop();

                    swal({
                        title: 'Periksa kembali inputan tanggal!',
                        icon: 'error',
                    }).then(function(){
                        if(id == 'periode'){
                            $('#periode').val('');
                            $('#periode').select();
                        }
                        else{
                            $('#'+id).find('.'+thisClass).val('');
                            $('#'+id).find('.'+thisClass).select();
                        }
                    });
                }
            });




            $('input').on('focus',function(){
                $(this).select();
            });


            $('input').on('keypress',function(event){
                if(event.which == 13 && !$(this).hasClass('kke_prdcd') && $(this).attr('id') != 'i-search' && !$(this).hasClass('kke_tglkirim05')){
                    if($(this).hasClass('kke_bufferss')){
                        $(this).val(parseInt(convertToRupiah2($(this).val())));
                        $(this).parent().parent().find('.kke_tglkirim01').select();
                    }
                    else{
                        if(!$(this).hasClass('tanggal')){
                            $(this).val(parseInt(convertToRupiah2($(this).val())));
                        }
                        $(this).parent().next().find('input').select();
                    }
                }
                else if($(this).attr('class').split(' ').pop() == 'kke_tglkirim05'){
                    row = parseInt($(this).parent().parent().attr('id').split('_').pop())+1;
                    $('#row_detail_'+row).find('.kke_prdcd').select();
                }
            });


            $('input').on('focus',function (event) {
                if($(this).attr('id') != 'periode' && $(this).attr('id') != 'keterangan' && $(this).attr('id') != 'txt_deskripsi' && $(this).attr('id') != 'i-search'){
                    currentRow = $(this).parent().parent().attr('id').split('_').pop();

                    $('#txt_deskripsi').val($('#row_detail_'+currentRow).find('.kke_deskripsi').val());
                    saldoawal = parseInt(unconvertToRupiah($('#row_form_'+currentRow).find('.kke_saldoawal').val()));

                    idx = $(this).parent().index();
                    currentPos  = $('#row_form_0:nth-child(1)').find('td').innerWidth() * (idx - 1);
                    $('.table-wrapper-scroll-y').animate({ scrollLeft: currentPos }, 100);
                }
            });


            $('.kke_tglkirim05').on('change',function(){
                rowNext = parseInt($(this).parent().parent().attr('id').split('_').pop()) + 1;

                if($('#row_detail_'+rowNext).attr('id') != 'row_detail_'+rowNext){
                    addRow();
                }

                $('#row_detail_'+rowNext).find('.kke_prdcd').select();
            });

            $('.cek').on('change blur',function(){
                thisClass = $(this).attr('class').split(' ').pop();
                id = $(this).parent().parent().attr('id');

                if(thisClass != 'kke_estimasi' && parseInt(unconvertToRupiah($(this).val())) < 0){
                    swal({
                        title: 'Nilai yang diinputkan tidak boleh kurang dari 0!',
                        icon: 'error',
                    }).then(function () {
                        $('#'+id).find('.'+thisClass).select();
                    });
                }
                else{
                    estimasi = 0;
                    pb = 0;

                    $('#'+id).find('.cek').each(function(){
                        if($(this).attr('class').split(' ').pop() == 'kke_estimasi') {
                            estimasi = parseInt(unconvertToRupiah($(this).val()));
                        }
                        else{
                            pb += parseInt(unconvertToRupiah($(this).val()));
                        }
                    });

                    if(estimasi <= 0 || parseInt(unconvertToRupiah($('#'+id).find('.kke_estimasi').val())).length == 0){
                        swal({
                            title: 'Nilai estimasi harus lebih dari 0!',
                            icon: 'error',
                        }).then(function () {
                            $('#'+id).find('.'+thisClass).select();
                        });
                    }
                    else if(pb > estimasi){
                        if($(this).attr('class').split(' ').pop() == 'kke_estimasi'){
                            swal({
                                title: 'Nilai estimasi tidak boleh lebih kecil dari total Breakdown PB!',
                                icon: 'error',
                            }).then(function () {
                                $('#'+id).find('.'+thisClass).select();
                            });
                        }
                        else {
                            swal({
                                title: 'Total Breakdown PB tidak boleh melebihi nilai estimasi!',
                                icon: 'error'
                            }).then(function () {
                                $('#'+id).find('.'+thisClass).select();
                            });
                        }
                    }
                    else{
                        saldoakhir = saldoawal + parseInt(unconvertToRupiah($('#'+id).find('.kke_estimasi').val()));
                        $('#'+id).find('.kke_saldoakhir').val(convertToRupiah2(saldoakhir));

                        totalKubikasi = 0;
                        totalBerat = 0;
                        $('.'+thisClass).each(function(){
                            if(parseInt(unconvertToRupiah($(this).val())) > 0) {
                                currId = $(this).parent().parent().attr('id').split('_').pop();
                                // console.log(parseInt(unconvertToRupiah($(this).val())));
                                totalKubikasi += $('#row_detail_'+currId).find('.kke_kubikasikmsn').val() * parseInt(unconvertToRupiah($(this).val()));
                                totalBerat += $('#row_detail_'+currId).find('.kke_beratkmsn').val() * parseInt(unconvertToRupiah($(this).val()));
                            }
                        });

                        totalKubikasi = totalKubikasi / 28.5;
                        totalBerat = totalBerat / 20900;

                        // console.log(totalKubikasi);
                        // console.log(totalBerat);

                        if(totalKubikasi > totalBerat){
                            total = Math.ceil(totalKubikasi);
                            if(total < 1)
                                total = 1;
                        }
                        else{
                            total = Math.ceil(totalBerat);
                            if(total < 1)
                                total = 1;
                        }
                        $('#total_'+thisClass).val(total);
                    }
                }
            });
        }

        function get_detail_produk(event,row){
            if(event.which == 13){
                if(edit){
                    prdcd = convertPlu($(event.target).val());

                    ada = false;

                    $('.kke_prdcd').each(function(){
                        if($(this).parent().parent().attr('id') != 'row_detail_'+row){
                            if($(this).val() == prdcd){
                                ada = true;
                                return 0;
                            }
                        }
                    });

                    if(!ada){
                        $.ajax({
                            url: '/BackOffice/public/bo/pb/kkei/get_detail_produk',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {prdcd: prdcd, periode: $('#periode').val()},
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (response) {
                                $('#modal-loader').modal('toggle');

                                if (response.status == 'success') {
                                    $('#row_form_'+row).find('input').each(function () {
                                        $(this).val('0');
                                    });
                                    $('#row_form_'+row).find('.tanggal').each(function () {
                                        $(this).val('');
                                    });

                                    $('#row_detail_'+row).find('.kke_prdcd').val(response.data.prd_prdcd);
                                    $('#row_detail_'+row).find('.kke_unit').val(response.data.unit);
                                    $('#row_detail_'+row).find('.kke_frac').val(convertToRupiah2(response.data.frac));
                                    $('#row_form_'+row).find('.kke_hargabeli').val(convertToRupiah(response.data.hargabeli));
                                    $('#row_form_'+row).find('.kke_discount').val(convertToRupiah(response.data.diskon));
                                    $('#row_form_'+row).find('.kke_sales01').val(convertToRupiah2(response.data.sales1));
                                    $('#row_form_'+row).find('.kke_sales02').val(convertToRupiah2(response.data.sales2));
                                    $('#row_form_'+row).find('.kke_sales03').val(convertToRupiah2(response.data.sales3));
                                    $('#row_form_'+row).find('.kke_avgbln').val(convertToRupiah(response.data.avgslsbln));
                                    $('#row_form_'+row).find('.kke_avghari').val(convertToRupiah(response.data.avgslshari));
                                    $('#row_form_'+row).find('.kke_saldoawal').val(convertToRupiah2(nvl(response.data.saldoawal,0)));
                                    $('#row_form_'+row).find('.kke_saldoakhir').val(convertToRupiah2(nvl(response.data.saldoakhir,0)));

                                    $('#row_detail_'+row).find('.kke_deskripsi').val(response.data.deskripsi);

                                    $('#txt_deskripsi').val($('#row_detail_'+row).find('.kke_deskripsi').val());

                                    $('#row_detail_'+row).find('.kke_panjangprod').val(response.data.panjangproduk);
                                    $('#row_detail_'+row).find('.kke_lebarprod').val(response.data.lebarproduk);
                                    $('#row_detail_'+row).find('.kke_tinggiprod').val(response.data.tinggiproduk);
                                    $('#row_detail_'+row).find('.kke_panjangkmsn').val(response.data.panjangkemasan);
                                    $('#row_detail_'+row).find('.kke_lebarkmsn').val(response.data.lebarkemasan);
                                    $('#row_detail_'+row).find('.kke_tinggikmsn').val(response.data.tinggikemasan);
                                    $('#row_detail_'+row).find('.kke_beratproduk').val(response.data.beratprod);
                                    $('#row_detail_'+row).find('.kke_beratkmsn').val(response.data.beratkmsn);
                                    $('#row_detail_'+row).find('.kke_kubikasiprod').val(response.data.kubikasiprod);
                                    $('#row_detail_'+row).find('.kke_kubikasikmsn').val(response.data.kubikasikemasan);
                                    $('#row_detail_'+row).find('.kke_kdsup').val(response.data.kodesupplier);
                                    $('#row_detail_'+row).find('.kke_nmsup').val(response.data.namasupplier);

                                    $('#row_form_'+row).find('.kke_estimasi').prop('disabled',false);
                                    $('#row_form_'+row).find('.kke_breakpb01').prop('disabled',false);
                                    $('#row_form_'+row).find('.kke_breakpb02').prop('disabled',false);
                                    $('#row_form_'+row).find('.kke_breakpb03').prop('disabled',false);
                                    $('#row_form_'+row).find('.kke_breakpb04').prop('disabled',false);
                                    $('#row_form_'+row).find('.kke_breakpb05').prop('disabled',false);
                                    $('#row_form_'+row).find('.kke_bufferlt').prop('disabled',false);
                                    $('#row_form_'+row).find('.kke_bufferss').prop('disabled',false);
                                    $('#row_form_'+row).find('.tanggal').prop('disabled',false);

                                    if(response.kkei != null){
                                         $('#row_form_'+row).find('.kke_estimasi').val(convertToRupiah2(response.kkei.kke_estimasi));
                                        $('#row_form_'+row).find('.kke_breakpb01').val(convertToRupiah2(response.kkei.kke_breakpb01));
                                        $('#row_form_'+row).find('.kke_breakpb02').val(convertToRupiah2(response.kkei.kke_breakpb02));
                                        $('#row_form_'+row).find('.kke_breakpb03').val(convertToRupiah2(response.kkei.kke_breakpb03));
                                        $('#row_form_'+row).find('.kke_breakpb04').val(convertToRupiah2(response.kkei.kke_breakpb04));
                                        $('#row_form_'+row).find('.kke_breakpb05').val(convertToRupiah2(response.kkei.kke_breakpb05));
                                         $('#row_form_'+row).find('.kke_bufferlt').val(convertToRupiah2(response.kkei.kke_bufferlt));
                                         $('#row_form_'+row).find('.kke_bufferss').val(convertToRupiah2(response.kkei.kke_bufferss));
                                        $('#row_form_'+row).find('.kke_tglkirim01').val(formatDate(response.kkei.kke_tglkirim01));
                                        $('#row_form_'+row).find('.kke_tglkirim02').val(formatDate(response.kkei.kke_tglkirim02));
                                        $('#row_form_'+row).find('.kke_tglkirim03').val(formatDate(response.kkei.kke_tglkirim03));
                                        $('#row_form_'+row).find('.kke_tglkirim04').val(formatDate(response.kkei.kke_tglkirim04));
                                        $('#row_form_'+row).find('.kke_tglkirim05').val(formatDate(response.kkei.kke_tglkirim05));
                                    }

                                    ready();
                                    $('#row_form_'+row).find('.hasDatepicker').prop('disabled',false);
                                    $('#row_form_'+row).find('.hasDatepicker').prop('readonly',false);

                                    cek();

                                    if(nvl(response.data.panjangproduk,0) == 0 || nvl(response.data.lebarproduk,0) == 0 || nvl(response.data.tinggiproduk,0) == 0){
                                        swal({
                                            title: 'PLU '+response.data.prd_prdcd+' tidak mempunyai dimensi!',
                                            icon: 'error'
                                        }).then(function(){
                                            $('#row_form_'+row).find('.kke_estimasi').select();
                                        });
                                    }
                                    else{
                                        $('#row_form_'+row).find('.kke_estimasi').select();
                                    }
                                    $('#btn-save').prop('disabled',false);

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
                        title: 'Data tidak bisa diubah!',
                        icon: 'error'
                    });
                }
            }
        }

        function get_detail_kkei(periode){
            periode = periode.replace(/\//g, '');

            deleted = [];


            $.ajax({
                url: '/BackOffice/public/bo/pb/kkei/get_detail_kkei',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {periode: periode},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    getDetail = false;

                    now = new Date;
                    periode = $('#periode').datepicker('getDate');

                    $('#table-detail').find('tbody tr').remove();
                    $('#table-form').find('tbody tr').remove();

                    rowCount = 0;

                    if (response.data.length > 0) {
                        for(i=0;i<response.data.length;i++){
                            deskripsi = response.data[i].kke_deskripsi;

                            trData = '<tr class="baris"  id="row_detail_'+rowCount+'">' +
                                '<td class="text-center">' +
                                '<button class="col-sm btn btn-danger btn-delete" onclick="deleteRow('+rowCount+')">X</button>' +
                                '</td>' +
                                '<td class="">' +
                                '<input type="number" class="form-control kke_prdcd" onkeypress="get_detail_produk(event,'+rowCount+')" value="'+response.data[i].kke_prdcd+'">' +
                                '</td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_unit" value='+response.data[i].kke_unit+'>' +
                                '</td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_frac" value='+response.data[i].kke_frac+'>' +
                                '</td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_hargabeli" value=' + convertToRupiah(response.data[i].kke_hargabeli) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_discount" value=' + convertToRupiah(Math.round(response.data[i].kke_discount)) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_sales01" value=' + convertToRupiah2(response.data[i].kke_sales01) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_sales02" value=' + convertToRupiah2(response.data[i].kke_sales01) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_sales03" value=' + convertToRupiah2(response.data[i].kke_sales03) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_avgbln" value=' + convertToRupiah(response.data[i].kke_avgbln) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_avghari" value=' + convertToRupiah(response.data[i].kke_avghari) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_saldoawal" value=' + convertToRupiah2(response.data[i].kke_saldoawal) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control cek kke_estimasi" value=' + convertToRupiah2(response.data[i].kke_estimasi) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control cek kke_breakpb01" value=' + convertToRupiah2(response.data[i].kke_breakpb01) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control cek kke_breakpb02" value=' + convertToRupiah2(response.data[i].kke_breakpb02) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control cek kke_breakpb03" value=' + convertToRupiah2(response.data[i].kke_breakpb03) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control cek kke_breakpb04" value=' + convertToRupiah2(response.data[i].kke_breakpb04) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control cek kke_breakpb05" value=' + convertToRupiah2(response.data[i].kke_breakpb05) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control kke_bufferlt" value=' + convertToRupiah2(response.data[i].kke_bufferlt) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control kke_bufferss" value=' + convertToRupiah2(response.data[i].kke_bufferss) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_saldoakhir" value=' + convertToRupiah2(response.data[i].kke_saldoakhir) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_outpototal" value=' + convertToRupiah2(response.data[i].kke_outpototal) + '></td>' +
                                '<td class="">' +
                                '<input disabled type="text" class="form-control kke_outpoqty" value=' + convertToRupiah2(response.data[i].kke_outpoqty) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim01" value=' + formatDate(response.data[i].kke_tglkirim01) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim02" value=' + formatDate(response.data[i].kke_tglkirim02) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim03" value=' + formatDate(response.data[i].kke_tglkirim03) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim04" value=' + formatDate(response.data[i].kke_tglkirim04) + '></td>' +
                                '<td class="">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim05" value=' + formatDate(response.data[i].kke_tglkirim05) + '></td>' +
                            '</tr>';

                            trDetail = '<tr class="d-flex baris"  id="row_detail_'+rowCount+'">' +
                                '<td class="col-sm-2 text-center">' +
                                '<button class="col-sm btn btn-danger btn-delete" onclick="deleteRow('+rowCount+')">X</button>' +
                                '</td>' +
                                '<td class="col-sm-4">' +
                                '<input type="number" class="form-control kke_prdcd" onkeypress="get_detail_produk(event,'+rowCount+')" value="'+response.data[i].kke_prdcd+'">' +
                                '</td>' +
                                '<td class="col-sm-3">' +
                                '<input disabled type="text" class="form-control kke_unit" value='+response.data[i].kke_unit+'>' +
                                '</td>' +
                                '<td class="col-sm-3">' +
                                '<input disabled type="text" class="form-control kke_frac" value='+response.data[i].kke_frac+'>' +
                                '</td>' +
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_deskripsi" value="'+response.data[i].kke_deskripsi+'">'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_panjangprod" value='+response.data[i].kke_panjangprod+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_lebarprod" value='+response.data[i].kke_lebarprod+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_tinggiprod" value='+response.data[i].kke_tinggiprod+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_panjangkmsn" value='+response.data[i].kke_panjangkmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_lebarkmsn" value='+response.data[i].kke_lebarkmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_tinggikmsn" value='+response.data[i].kke_tinggikmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_beratproduk" value='+response.data[i].kke_beratproduk+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_beratkmsn" value='+response.data[i].kke_beratkmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_kubikasiprod" value='+response.data[i].kke_kubikasiprod+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_kubikasikmsn" value='+response.data[i].kke_kubikasikmsn+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_kdsup" value='+response.data[i].kke_kdsup+'>'+
                                '</td>'+
                                '<td hidden>'+
                                '<input type="text" class="form-control kke_nmsup" value='+response.data[i].kke_nmsup+'>'+
                                '</td>'
                                '</tr>';

                            trForm = '<tr id="row_form_' + i + '" class="d-flex baris number">' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control kke_hargabeli" value=' + convertToRupiah(response.data[i].kke_hargabeli) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control kke_discount" value=' + convertToRupiah(Math.round(response.data[i].kke_discount)) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control kke_sales01" value=' + convertToRupiah2(response.data[i].kke_sales01) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control kke_sales02" value=' + convertToRupiah2(response.data[i].kke_sales01) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control kke_sales03" value=' + convertToRupiah2(response.data[i].kke_sales03) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control kke_avgbln" value=' + convertToRupiah(response.data[i].kke_avgbln) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control kke_avghari" value=' + convertToRupiah(response.data[i].kke_avghari) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control kke_saldoawal" value=' + convertToRupiah2(response.data[i].kke_saldoawal) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control cek kke_estimasi" value=' + convertToRupiah2(response.data[i].kke_estimasi) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control cek kke_breakpb01" value=' + convertToRupiah2(response.data[i].kke_breakpb01) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control cek kke_breakpb02" value=' + convertToRupiah2(response.data[i].kke_breakpb02) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control cek kke_breakpb03" value=' + convertToRupiah2(response.data[i].kke_breakpb03) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control cek kke_breakpb04" value=' + convertToRupiah2(response.data[i].kke_breakpb04) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control cek kke_breakpb05" value=' + convertToRupiah2(response.data[i].kke_breakpb05) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control kke_bufferlt" value=' + convertToRupiah2(response.data[i].kke_bufferlt) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control kke_bufferss" value=' + convertToRupiah2(response.data[i].kke_bufferss) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input disabled type="text" class="form-control kke_saldoakhir" value=' + convertToRupiah2(response.data[i].kke_saldoakhir) + '></td>' +
                                '<td class="col-sm-1">' +
                                '<input disabled type="text" class="form-control kke_outpototal" value=' + convertToRupiah2(response.data[i].kke_outpototal) + '></td>' +
                                '<td class="col-sm-1">' +
                                '<input disabled type="text" class="form-control kke_outpoqty" value=' + convertToRupiah2(response.data[i].kke_outpoqty) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim01" value=' + formatDate(response.data[i].kke_tglkirim01) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim02" value=' + formatDate(response.data[i].kke_tglkirim02) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim03" value=' + formatDate(response.data[i].kke_tglkirim03) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim04" value=' + formatDate(response.data[i].kke_tglkirim04) + '></td>' +
                                '<td class="col-sm-2">' +
                                '<input type="text" class="form-control tanggal kke_tglkirim05" value=' + formatDate(response.data[i].kke_tglkirim05) + '></td>' +
                                '</tr>';

                            $('#table-detail').append(trDetail);
                            $('#table-form').append(trForm);

                            $('#table_data').append(trData);

                            rowCount++;
                        }

                        for(i=response.data.length;i<10;i++){
                            addRow();
                        }

                        ready();

                        totalKubikasi = 0;
                        totalBerat = 0;
                        $('.kke_estimasi').each(function(){
                            if($(this).val() > 0) {
                                currId = $(this).parent().parent().attr('id').split('_').pop();
                                totalKubikasi += $('#row_detail_'+currId).find('.kke_kubikasikmsn').val() * $(this).val();
                                totalBerat += $('#row_detail_'+currId).find('.kke_beratkmsn').val() * $(this).val();
                            }
                        });

                        totalKubikasi = totalKubikasi / 28.5;
                        totalBerat = totalBerat / 20900;

                        if(totalKubikasi > totalBerat){
                            total = Math.ceil(totalKubikasi);
                        }
                        else{
                            total = Math.ceil(totalBerat);
                        }
                        $('#total_kke_estimasi').val(total);

                        $('#total_kke_breakpb01').val(response.data[0].kke_kubik1);
                        $('#total_kke_breakpb02').val(response.data[0].kke_kubik2);
                        $('#total_kke_breakpb03').val(response.data[0].kke_kubik3);
                        $('#total_kke_breakpb04').val(response.data[0].kke_kubik4);
                        $('#total_kke_breakpb05').val(response.data[0].kke_kubik5);

                        if(response.data[0].kke_upload == 'Y'){
                            deletable = false;
                            $('#keterangan').val('DATA SUDAH DIUPLOAD');
                            $('#table-detail').find('input').each(function(){
                                if($(this).attr('class').split(' ').pop() == 'kke_prdcd')
                                    $(this).prop('readonly',true);
                                else $(this).prop('disabled',true);
                            });
                            $('#table-form').find('input').each(function(){
                                $(this).prop('disabled',true);
                            });

                            $('#btn-save').prop('disabled',true);
                            $('#btn-print').prop('disabled',false);

                            edit = false;
                        }
                        else{
                            deletable = true;
                            $('#keterangan').val('DATA BELUM DIUPLOAD');
                            $('#btn-save').prop('disabled',false);
                            $('#btn-print').prop('disabled',false);
                            edit = true;
                            cek();
                        }
                        $('#periode').prop('disabled',false);
                        $('#periode').prop('readonly',false);
                    }
                    else{
                        for(i=response.data.length;i<10;i++){
                            addRow();
                        }

                        ready();
                    }

                    $('#row_detail_0').find('.kke_prdcd').select();

                    if(periode.getMonth() != now.getMonth() || periode.getFullYear() != now.getFullYear()){
                        swal({
                            title: 'Periode harus bulan berjalan!',
                            icon: 'warning'
                        }).then(function(){
                            $('#row_detail_0').find('.kke_prdcd').select();
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
                            '<input type="number" class="form-control kke_prdcd" onkeypress="get_detail_produk(event,'+rowCount+')">' +
                            '</td>' +
                            '<td class="col-sm-3">' +
                            '<input disabled type="text" class="form-control kke_unit">' +
                            '</td>' +
                            '<td class="col-sm-3">' +
                            '<input disabled type="text" class="form-control kke_frac">' +
                            '</td>' +
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_deskripsi">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_panjangprod">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_lebarprod">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_tinggiprod">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_panjangkmsn">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_lebarkmsn">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_tinggikmsn">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_beratproduk">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_beratkmsn">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_kubikasiprod">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_kubikasikmsn">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_kdsup">' +
                            '</td>'+
                            '<td hidden>'+
                            '<input type="text" class="form-control kke_nmsup">' +
                            '</td>'
                        '</tr>';

            trForm = '<tr id="row_form_' + rowCount + '" class="d-flex baris number">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_hargabeli">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_discount">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_sales01">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_sales02">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_sales03">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_avgbln">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_avghari">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_saldoawal">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control cek kke_estimasi">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control cek kke_breakpb01">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control cek kke_breakpb02">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control cek kke_breakpb03">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control cek kke_breakpb04">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control cek kke_breakpb05">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_bufferlt">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_bufferss">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control kke_saldoakhir">' +
                        '<td class="col-sm-1">' +
                        '<input disabled type="text" class="form-control kke_outpototal">' +
                        '<td class="col-sm-1">' +
                        '<input disabled type="text" class="form-control kke_outpoqty">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control tanggal kke_tglkirim01">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control tanggal kke_tglkirim02">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control tanggal kke_tglkirim03">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control tanggal kke_tglkirim04">' +
                        '<td class="col-sm-2">' +
                        '<input disabled type="text" class="form-control tanggal kke_tglkirim05">' +
                    '</tr>';

            $('#table-detail').append(trDetail);
            $('#table-form').append(trForm);

            rowCount++;
        }

        function deleteRow(row){
            if(deletable){
                deleted.push($('#row_detail_'+row).find('.kke_prdcd').val());

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
            else{
                swal({
                    title: 'Data tidak bisa didelete',
                    icon: 'error'
                });
            }
        }

        function search(plu){
            found = false;

            $('#i-search').val(convertPlu(plu));
            $('.kke_prdcd').each(function(){
                if($(this).val() == convertPlu(plu)){
                    // $('#modal-loader').modal('toggle');
                    $(this).select();
                    idx = $(this).parent().parent().index();
                    currentPos  = $('#row_detail_0:nth-child(1)').find('td').innerHeight() * (idx - 1);
                    $('.table-wrapper-scroll-y').animate({ scrollTop: currentPos }, 100);
                    found = true;
                    return false;
                }
            });
            if(!found){
                swal({
                    title: 'Data tidak ada!',
                    icon: 'error'
                }).then(function(){
                    $('#modal-loader').hide('toggle');
                    $('#i-search').select();
                });
            }
        }

        function save(){
            datas = [];

            $('#table-detail').find('tbody tr').each(function(){
                row = $(this).attr('id').split('_').pop();

                if($('#row_detail_'+row).find('.kke_prdcd').val().length > 0){
                    data = {};
                    $('#row_detail_'+row).find('input').each(function(){
                        data[$(this).attr('class').split(' ').pop()] = $(this).val();
                    });

                    $('#row_form_'+row).find('input').each(function(){
                        // if($(this).hasClass('kke_hargabeli') || $(this).hasClass('kke_discount') || $(this).hasClass('kke_sales01') || $(this).hasClass('kke_sales02') || $(this).hasClass('kke_sales03') || $(this).hasClass('kke_avgbln') || $(this).hasClass('kke_avghari')){
                        //     data[$(this).attr('class').split(' ').pop()] = unconvertToRupiah($(this).val());
                        // }
                        // else data[$(this).attr('class').split(' ').pop()] = $(this).val();
                        if($(this).hasClass('tanggal')){
                            data[$(this).attr('class').split(' ').pop()] = $(this).val();
                        }
                        else{
                            data[$(this).attr('class').split(' ').pop()] = unconvertToRupiah($(this).val());
                        }
                    });

                    data['kke_kubik1'] = $('#total_kke_breakpb01').val();
                    data['kke_kubik2'] = $('#total_kke_breakpb02').val();
                    data['kke_kubik3'] = $('#total_kke_breakpb03').val();
                    data['kke_kubik4'] = $('#total_kke_breakpb04').val();
                    data['kke_kubik5'] = $('#total_kke_breakpb05').val();
                    data['kke_periode'] = $('#periode').val().replace(/\//g, '');

                    datas.push(data);
                }
            });

            $.ajax({
                url: '/BackOffice/public/bo/pb/kkei/save',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    periode: $('#periode').val().replace(/\//g, ''),
                    kkei: datas,
                    deleted: deleted
                },
                beforeSend: function () {
                    $('#modal-loader').modal('toggle');
                    // console.log(datas);
                },
                success: function (response){
                    $('#modal-loader').modal('toggle');
                    if(response.status == 'success'){
                        swal({
                            title: response.message,
                            icon: "success"
                        });
                        $('#btn-print').prop('disabled',false);
                    }
                    else{
                        swal({
                            title: response.message,
                            icon: "error"
                        });
                    }
                }
            });


        }

        function cek(){
            if(edit){
                $('#table-detail').find('.kke_prdcd').each(function(){
                    if($(this).val().length > 0){
                        row = $(this).parent().parent().attr('id').split('_').pop();
                        $('#row_form_'+row).find('.tanggal').prop('disabled',false);
                    }
                });
            }
            else{
                $('#table-detail').find('.kke_prdcd').each(function(){
                    if($(this).val().length > 0){
                        row = $(this).parent().parent().attr('id').split('_').pop();
                        $('#row_form_'+row).find('.tanggal').prop('disabled',true);
                    }
                });
            }
        }

        function print(){

            // Data to post
            data = {
                periode : $('#periode').val().replace(/\//g,'')
            };

            periode = $('#periode').val().replace(/\//g,'');
            url = '{{ url('/bo/pb/kkei/laporan?periode=') }}'+periode;

            window.open(url);

            {{--// Use XMLHttpRequest instead of Jquery $ajax--}}
            {{--$('#modal-loader').modal('toggle');--}}
            {{--xhttp = new XMLHttpRequest();--}}
            {{--xhttp.onreadystatechange = function() {--}}
                {{--var a;--}}
                {{--if (xhttp.readyState === 4 && xhttp.status === 200) {--}}
                    {{--// Trick for making downloadable link--}}
                    {{--a = document.createElement('a');--}}
                    {{--a.href = window.URL.createObjectURL(xhttp.response);--}}

                    {{--disposition = xhttp.getResponseHeader('Content-Disposition');--}}
                    {{--filename = disposition.substr(disposition.indexOf('"') + 1).replace('"','');--}}

                    {{--// Give filename you wish to download--}}
                    {{--a.download = filename;--}}
                    {{--a.style.display = 'none';--}}
                    {{--document.body.appendChild(a);--}}
                    {{--a.click();--}}
                    {{--$('#modal-loader').modal('toggle');--}}
                {{--}--}}
            {{--};--}}
            {{--// Post data to URL which handles post request--}}
            {{--xhttp.open("POST", "{{ url('bo/pb/kkei/laporan') }}");--}}
            {{--xhttp.setRequestHeader("Content-Type", "application/json");--}}
            {{--xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));--}}
            {{--// You should set responseType as blob for binary responses--}}
            {{--xhttp.responseType = 'blob';--}}
            {{--xhttp.send(JSON.stringify(data));--}}
        }
    </script>
@endsection
