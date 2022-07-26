@extends('navbar')
@section('title',(__('PB | PB PERISHABLE')))
@section('content')

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
{{--                    <legend class="w-auto ml-5">Header</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-10">--}}
                                <form>
                                    <div class="row text-right">
                                        <div class="col-sm-12">
                                            {{-- <label for="model" class="col-sm-2 col-form-label"></label> --}}
                                            <div class="form-group row mb-1 mt-1 justify-content-center">
                                                <div class="col-sm-3">
                                                    <input type="text" class="form-control text-center" id="model" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group row mb-0">
                                                        <label for="no-pb" class="col-sm-3 col-form-label">@lang('NOMOR PB')</label>
                                                        <div class="col-sm-4 buttonInside">
                                                            <input type="number" class="form-control" id="no-pb">
                                                            <button id="btn-no-pb" type="button" class="btn btn-lov p-0" onclick="getNmrPB()">
                                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label for="tgl-pb" class="col-sm-3 col-form-label">@lang('TANGGAL PB')</label>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" id="tgl-pb">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group row mt-2 mb-0 mr-1">
                                                        <button class="btn btn-primary btn-lg float-left col-sm-2" id="btn-proses" onclick="prosesDoc(event)" >
                                                        @lang('PROSES')
                                                       </button>
                                                       <button class="btn btn-danger btn-lg float-left ml-4" id="btn-hapus" onclick="deleteDoc(event)">
                                                           DELETE AND CLOSE
                                                       </button>
                                                   </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </fieldset>
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">@lang('Detail')</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="card-body p-0 tableFixedHeader" style="border-bottom: 1px solid black">
                                    <table class="table table-striped table-bordered float-left" id="table-supply">
                                        <thead class="header-table">
                                        <tr class="d-flex text-center">
                                            {{-- <th style="width: 3%">X</th> --}}
                                            <th style="width: 23%">@lang('SUPPLIER')</th>
                                            <th style="width: 23%">@lang('KODE SARANA')</th>
                                            <th style="width: 23%">@lang('VOLUME SARANA')</th>
                                            <th style="width: 23%">@lang('TOTAL KUBIKASE ITEM')</th>
                                            <th style="width: 8%">@lang('FLAG')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody1">
                                        @for($i = 0; $i< 5; $i++)
                                            <tr class="d-flex baris1">
                                                <td style="width: 23%"><input type="text" class="form-control supplierid" id="supplierid" no="{{$i}}"></td>
                                                <td style="width: 23%"><input disabled type="text" class="form-control kodesarana" id="kodesarana"></td>
                                                <td style="width: 23%"><input disabled type="text" class="form-control volsarana text-right"></td>
                                                <td style="width: 23%"><input disabled type="text" class="form-control totalkubik text-right"></td>
                                                <td style="width: 8%"><input disabled type="text" class="form-control flag text-right"></td>
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="card-body p-0 tableFixedHeader" style="border-bottom: 1px solid black">
                                    <table class="table table-striped table-bordered float-left" id="table-detail">
                                            <thead class="header-table">
                                            <tr class="d-flex text-center">
                                                {{-- <th style="width: 3%">X</th> --}}
                                                <th style="width: 10%">@lang('PLU')</th>
                                                <th style="width: 10%">@lang('PKM')</th>
                                                <th style="width: 10%">@lang('AVG SALES')</th>
                                                <th style="width: 10%">@lang('ISI CTN')</th>
                                                <th style="width: 10%">@lang('STOCK')</th>
                                                <th style="width: 10%">@lang('PO OUT')</th>
                                                <th style="width: 10%">@lang('PB OUT')</th>
                                                <th style="width: 10%">@lang('MIN DISPLAY')</th>
                                                <th style="width: 10%">@lang('MIN ORDER')</th>
                                                <th style="width: 10%">@lang('QTY PB')</th>
                                                <th style="width: 10%">@lang('DIMENSI')</th>
                                                <th style="width: 10%">@lang('KUBIKASE')</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tbody2">
                                            @for($i = 0; $i< 10; $i++)
                                                <tr class="d-flex baris2 ">
                                                    <td class="buttonInside" style="width: 10%"><input disabled type="text" class="form-control plu" id="plu" no="{{$i}}"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control pkm" id="pkm"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control avgsales"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control isictn"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control stock text-right"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control poout"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control pbout text-right"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control mindisp text-right"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control minord text-right" ></td>
                                                    <td style="width: 10%"><input type="number" class="form-control qtypb text-right"{{-- id="{{$i}}" onchange="qty(this.value,this.id,1)"--}}></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control dimensi text-right"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control kubikase"></td>
                                                </tr>
                                            @endfor
                                            </tbody>
                                            {{-- <tfoot>
                                            <tr>
                                                <td>
                                                    <input disabled type="text" class="mt-1 form-control deskripsiPanjang">
                                                    <button class="btn btn-primary btn-block" id="btn-addRow" >
                                                        @lang('TAMBAH BARIS BARU')
                                                    </button>
                                                </td>
                                            </tr>
                                            </tfoot> --}}
                                        </table>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mt-3 d-flex flex-row-reverse ">
                                        <div class="col-sm-8">

                                        </div>
                                        <div class="col-sm-4">
                                            <p>@lang('Supplier')</p>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3 d-flex flex-row-reverse ">
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="deskripsiPanjang" disabled>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="namasupplier" disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <fieldset class="card border-secondary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <form>
                                            <div class="row text-right">
                                                <div class="col-sm-12 ml-2">
                                                    <div class="form-group row mb-0">
                                                        <p class="col-sm-6 text-left" >@lang('DIMENSI -> dimensi in CTN')</p>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <p class="col-sm-6 text-left" >@lang('KUBIKASE -> ((STOCK + PO OUT + PB OUT + qty PB)/ ISI CTN) * DIMENSI')</p>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <div class="col-sm-10">
                                                            <button class="btn btn-primary btn-lg pl-4 pr-4 mr-4" id="btn-save" type="button">
                                                                @lang('SIMPAN PB')
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            {{-- <p id="lastmodif">Last Edited</p>  --}}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>



    {{--Modal TRN--}}
    <div class="modal fade" id="modal-help-1" tabindex="-1" role="dialog" aria-labelledby="modal-help-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search-modal-1" class="form-control search-modal-1" type="text" placeholder="..." aria-label="Search">
                        <div class="invalid-feedback"> </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm" id="modal-table-1">
                                        <thead class="header-modal">
                                        <tr class="font">
                                            <td>@lang('NO. PB')</td>
                                            <td>@lang('TANGGAL PB')</td>
                                        </tr>
                                        </thead>
                                        <tbody class="tbody-modal-1">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>


    <style>
        .header-modal{
            background: #0079C2;
            position: sticky; top: 0;
        }

        .header-table{
            background: #0079C2;
        }
        .highlight { background-color: blue; }


        .font{
            color: white;
            font-weight: bold;
        }

        tbody td {
            padding: 3px !important;
        }
    </style>


    <script>

        // let tempTrn;
        // let tempPlu;
        var tempStock = [{'plu' : '0000000', 'deskripsipanjang' : ''}];
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = dd + '/' + mm + '/' + yyyy;
        $('#no-pb').focus();
        $('#btn-proses').attr('disabled',true);

        $("#tgl-pb").datepicker({
            "dateFormat" : "dd/mm/yy",
        });

        $("#tgl-pb").val(today)

        // $(document).ready(function () {
        // //    panggil function yang mau di auto eksekusi saat web pertama kali dibuka
        //    alert("test");
        // });

        $(document).on('keypress', '#no-pb', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let nopb = $('#no-pb').val();
                nmrBaruPb(nopb);

            }
        });

        // $(document).on('keypress', '.qtypb', function (e) {
        //     if(e.which == 9) {
        //         qty(this.value,this.id, idsup);
        //         changeDesc()
        //         e.preventDefault();
        //     }
        // });

        $(document).on('keypress', '#tgl-pb', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                $('#btn-proses').focus();
            }
        });

        // var detailcounter = 0;
        // $(document).on('keypress','.qtypb',function(e){
        //     if (e.which == 9){

        //     }
        // });

        // $("#tbody2 tr").click(function() {
        //     var selected = $(this).hasClass("highlight");
        //     $("#tbody2 tr").removeClass("highlight");
        //     if(!selected)
        //             $(this).addClass("highlight");
        // });

        function nmrBaruPb(nopb){
            if(nopb == ''){
                swal({
                    title: "{{__('Buat Nomor PB Baru?')}}",
                    icon: 'info',
                    buttons: true,
                }).then(function(confirm){
                    if(confirm){
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/nmrBaruPb',
                            type: 'post',
                            data: {nopb: nopb},
                            // beforeSend: function () {
                                //     $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                // },
                                success: function (result){
                                clearField();
                                $('#no-pb').val(result);
                                $('#tgl-pb').val(formatDate('now'));
                                $('#model').val("{{__('* TAMBAH *')}}");
                                $('#deskripsiPanjang').val("");
                                $('#modal-loader').modal('hide')
                                $('#btn-hapus').attr('disabled', false);
                                $('#btn-save').attr('disabled', false);
                                $('#btn-proses').attr('disabled', false);
                                $('#tgl-pb').prop('disabled', false);
                                $("#tgl-pb").focus();
                            }, error: function () {
                                alert('error');
                                //$('#modal-loader').modal('hide')
                            }
                        })
                    }
                })
            } else {
                console.log('sukses');
                chooseSup(nopb);
            }
        }


        function getNmrPB() {
            $('#search-modal-1').val('')
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/lov_trn',
                type: 'post',
                data: {},
                success: function (result) {
                    // console.log(result)
                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        let temp = ` <tr class="modalRow" onclick=chooseSup('`+ result[i].pbp_nopb+`')>
                                        <td>`+ result[i].pbp_nopb +`</td>
                                        <td>`+ result[i].pbp_tglpb +`</td>
                                     </tr>`;
                        $('.tbody-modal-1').append(temp);
                    }
                    $('#modal-help-1').modal('show');
                }, error: function () {
                    alert('error');
                }
            });
        }

        $('#search-modal-1').keypress(function (e) {
            if (e.which === 13) {
                let search = $('#search-modal-1').val();
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/lov_trn',
                    type: 'post',
                    data: {search:search},
                    success: function (result) {
                        //console.log(result)
                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            let temp = ` <tr class="modalRow" onclick=chooseDoc('`+ result[i].pbp_nopb+`')>
                                        <td>`+ result[i].pbp_nopb +`</td>
                                        <td>`+ result[i].pbp_tglpb +`</td>
                                     </tr>`;
                            $('.tbody-modal-1').append(temp);
                        }
                        // $('#modal-help-1').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        })

        var totalsup = 0;
        function chooseSup(nopb) {
            // let tempgross = 0;
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/showSup',
                type: 'post',
                data: {nopb: nopb},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                   $('#modal-loader').modal('hide');

                    if(result.length == 0){
                        swal({
                            title: "{{__('Data tidak ada!')}}",
                            icon: 'error'
                        })
                    }
                    else{


                        console.log(result.data[0]);
                        console.log(result.flag);

                        if(result.flag == 1){
                            //console.log(result[0])
                            //flag == 1 berarti data ada dan sudah ditransfer
                            data = result.data[0]
                            var html1 = "";
                            var i;
                            var kodesup = "";
                            var kodesar = "";
                            totalsup = 0;
                            let tglpb = data.pbp_tglpb;
                            kodesup = data.pbp_kodesupplier;
                            kodesar = data.pbp_kodesarana;
                            $('.baris1').remove();
                            $('#model').val("");
                            console.log(result.data.length);
                            // console.log(result.length);

                            for(i=0; i<result.data.length; i++){

                                totalsup++;
                                data = result.data[i];
                                var kubikase2 = parseInt(data.pbp_kubikase);
                                var ttlkapasitas = parseInt(data.totalkapasitas);

                                if(kubikase2 > ttlkapasitas){
                                    console.log('yes');
                                }else{
                                    console.log('no');
                                }
                                data = result.data[i];

                                console.log(thousands_separators(1000));


                                if(kubikase2 > ttlkapasitas){
                                    html1 = `<tr id = `+ i +` class="d-flex baris1">
                                        <td style="width: 23%"><input type="text" class="form-control supplierid" id = `+ i +` onclick="chooseDoc('`+data.pbp_nopb +`','`+data.pbp_kodesupplier+`','`+data.pbp_kodesarana+`',this.id)" value="`+ data.pbp_kodesupplier +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control kodesarana" value="`+ data.pbp_kodesarana +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control volsarana text-right" value="`+ thousands_separators(data.totalkapasitas) +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control totalkubik text-right" value="`+ thousands_separators(data.pbp_kubikase) +`"></td>
                                        <td style="width: 8%"><input disabled type="text" id = `+ i +` class="form-control flag" value="X"></td>
                                        </tr>`;



                                    $('#tbody1').append(html1);
                                    // $('#namasupplier').val(data.sup_namasupplier);
                                }
                                else{


                                    html1 = `<tr id = `+ i +` class="d-flex baris1">
                                        <td style="width: 23%"><input type="text" class="form-control supplierid" id = `+ i +` onclick="chooseDoc('`+data.pbp_nopb +`','`+data.pbp_kodesupplier+`','`+data.pbp_kodesarana+`',this.id)" value="`+ data.pbp_kodesupplier +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control kodesarana" value="`+ data.pbp_kodesarana +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control volsarana text-right" value="`+ thousands_separators(data.totalkapasitas) +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control totalkubik text-right" value="`+ thousands_separators(data.pbp_kubikase) +`"></td>
                                        <td style="width: 8%"><input disabled type="text" id = `+ i +` class="form-control flag" value=""></td>
                                        </tr>`;



                                    $('#tbody1').append(html1);
                                    // $('#namasupplier').val(data.sup_namasupplier);
                                }


                                // total = tempgross + ppn;
                                // $('#total').val(convertToRupiah(tempgross));

                                // chooseDoc(data.pbp_nopb,data.pbp_kodesupplier,data.pbp_kodesarana);
                            }
                            $('#no-pb').val(data.pbp_nopb);
                            $('#tgl-pb').val(formatDate(data.pbp_tglpb));
                            $('#model').val("{{__('* PB SUDAH DICETAK / TRANSFER *')}}");
                            $('.qtypb')[0].focus();
                            $('#tgl-pb').prop('disabled', true);
                            $('#btn-save').attr('disabled', false);
                            $('#btn-proses').attr('disabled', true);
                            $('#btn-hapus').attr('disabled', false);

                        }
                        else {
                            //flag == 0 berarti data koreksi
                            data = result.data[0]
                            var html1 = "";
                            var i;
                            var kodesup = "";
                            var kodesar = "";
                            totalsup = 0;
                            let tglpb = data.pbp_tglpb;
                            kodesup = data.pbp_kodesupplier;
                            kodesar = data.pbp_kodesarana;
                            $('.baris1').remove();
                            console.log('b4 loop');
                            console.log(result.data.length);


                            for(i=0; i<result.data.length; i++){
                                // qtyctn = result[i].trbo_qty / result[i].prd_frac;
                                // qtypcs = result[i].trbo_qty % result[i].prd_frac;
                                // ppn = result[i].trbo_ppnrph * 0;
                                console.log('in loop');
                                data = result.data[i];
                                var kubikase2 = parseInt(data.pbp_kubikase);
                                var ttlkapasitas = parseInt(data.totalkapasitas);
                                totalsup++;
                                if(kubikase2 > ttlkapasitas){
                                    console.log('yes');
                                    console.log('kubikase2');
                                    console.log(kubikase2);
                                    console.log('ttlkapasitas');
                                    console.log(ttlkapasitas);
                                }else{
                                    console.log('no');
                                    console.log('kubikase2');
                                    console.log(kubikase2);
                                    console.log('ttlkapasitas');
                                    console.log(ttlkapasitas);
                                }
                                data = result.data[i];


                                if(kubikase2 > ttlkapasitas){
                                    html1 = `<tr id = `+ i +` class="d-flex baris1">
                                        <td style="width: 23%"><input type="text" class="form-control supplierid" id = `+ i +` onclick="chooseDoc('`+data.pbp_nopb +`','`+data.pbp_kodesupplier+`','`+data.pbp_kodesarana+`',this.id)" value="`+ data.pbp_kodesupplier +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control kodesarana" value="`+ data.pbp_kodesarana +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control volsarana text-right" value="`+ thousands_separators(data.totalkapasitas) +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control totalkubik text-right" value="`+ thousands_separators(data.pbp_kubikase) +`"></td>
                                        <td style="width: 8%"><input disabled type="text" id = `+ i +` class="form-control flag" value="X"></td>
                                        </tr>`;



                                    $('#tbody1').append(html1);
                                    // $('#namasupplier').val(data.sup_namasupplier);
                                }
                                else{
                                    html1 = `<tr id = `+ i +` class="d-flex baris1">
                                        <td style="width: 23%"><input type="text" class="form-control supplierid" id = `+ i +` onclick="chooseDoc('`+data.pbp_nopb +`','`+data.pbp_kodesupplier+`','`+data.pbp_kodesarana+`',this.id)" value="`+ data.pbp_kodesupplier +`"></td>
                                        <td style="width: 23%"><input disabled type="text" class="form-control kodesarana" value="`+ data.pbp_kodesarana +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control volsarana text-right" value="`+ thousands_separators(data.totalkapasitas) +`"></td>
                                        <td style="width: 23%"><input disabled type="text" id = `+ i +` class="form-control totalkubik text-right" value="`+ thousands_separators(data.pbp_kubikase) +`"></td>
                                        <td style="width: 8%"><input disabled type="text" id = `+ i +` class="form-control flag" value=""></td>
                                        </tr>`;



                                    $('#tbody1').append(html1);
                                    // $('#namasupplier').val(data.sup_namasupplier);
                                }

                                // total = tempgross + ppn;
                                // $('#total').val(convertToRupiah(tempgross));

                                // chooseDoc(data.pbp_nopb,data.pbp_kodesupplier,data.pbp_kodesarana);
                            }

                            $('#no-pb').val(data.pbp_nopb);
                            $('#tgl-pb').val(formatDate(data.pbp_tglpb));
                            var item = $("#model").val();
                            console.log(item);
                            if (item == "{{__('* TAMBAH *')}}") {
                                $('#model').val("{{__('* TAMBAH *')}}");
                            } else{
                                $('#model').val("{{__('* KOREKSI *')}}");
                            }
                            $('#btn-save').attr('disabled', false);
                            $('.qtypb')[0].focus();
                            $('#tgl-pb').prop('disabled', true);
                            console.log('after loop');
                            $('#btn-hapus').attr('disabled', false);
                            $('#btn-proses').attr('disabled', true);
                            // alert('Tidak ada PLU yang bisa di PB untuk tgl ' ||$tglpb);
                        }
                        chooseDoc(result.data[0].pbp_nopb,result.data[0].pbp_kodesupplier,result.data[0].pbp_kodesarana,0);


                    }
                }
                // alert("No DOC yg dipilih : " + val)
            })
            $('#modal-help-1').modal('hide');
            $('.qtypb')[0].focus();
        }

        let datas = [];

        function chooseDoc(nopb, kodesup, kodesar,idsup) {
            // let tempgross = 0;
            idsup = idsup;
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/showTrn',
                type: 'post',
                data: {nopb: nopb, kodesup: kodesup, kodesar: kodesar},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    if(result.length == 0){
                        swal({
                            title: "{{__('Data tidak ada!')}}",
                            icon: 'error'
                        })
                    }
                    else{
                        console.log(totalsup);
                        for(i = 0 ; i<totalsup ; i++){
                            $('.baris1')[i].style.backgroundColor = "";
                        }
                        $('#namasupplier').val(result[0].sup_namasupplier);
                        $('.baris1')[idsup].style.backgroundColor = "teal";

                        data = result[0];
                        tglpb = data.pbp_tglpb;
                        $('#tbody2').empty();

                        datas = result;

                        for(i=0; i<result.length; i++){

                            // datas[i] = result[i];

                            var temp = $('#tbody2').find('tr').length;
                                let index = parseInt(temp, 10)
                                var html1 = "";
                                var i;
                                var kodesup = "";
                                let tglpb = result[0].pbp_tglpb;

                                if(result[i].pbp_avgsales === null){
                                    result[i].pbp_avgsales = 0;
                                }
                                if(result[i].pbp_isictn === null){
                                    result[i].pbp_isictn = 0;
                                }

                                    // qtyctn = result[i].trbo_qty / result[i].prd_frac;
                                    // qtypcs = result[i].trbo_qty % result[i].prd_frac;
                                    // ppn = result[i].trbo_ppnrph * 0;
                                // kubikase = ((result[i].pbp_stock + result[i].pbp_poout + result[i].pbp_pbout + result[i].pbp_qtypb)/ result[i].pbp_isictn) * result[i].pbp_dimensi;
                                // result[i].pbp_kubikase = kubikase;

                                html2 = `<tr id = `+ i +` class="d-flex baris2">
                                                <td class="buttonInside" style="width: 10%">
                                                    <input disabled type="text" class="form-control plu" value="`+ result[i].pbp_prdcd +`">
                                                </td>
                                                <td style="width: 10%"><input disabled type="text" class="form-control pkm text-right" value="`+ result[i].pbp_pkm +`"></td>
                                                <td style="width: 10%"><input disabled type="text" class="form-control avgsales text-right" value="`+ result[i].pbp_avgsales +`"></td>
                                                <td style= "width: 10%"><input disabled type="text" class="form-control isictn text-right" value="`+ result[i].pbp_isictn +`"></td>
                                                <td style="width: 10%"><input disabled type="text" class="form-control stock text-right" value="`+ result[i].pbp_stock +`"></td>
                                                <td style="width: 10%"><input disabled type="text" class="form-control poout text-right" value="`+ result[i].pbp_qtypoout +`"></td>
                                                <td style="width: 10%"><input disabled type="text" class="form-control pbout text-right" value="`+ result[i].pbp_qtypbout +`"></td>
                                                <td style="width: 10%"><input disabled type="text" class="form-control mindisp text-right" value="`+ result[i].pbp_mindisplay +`"></td>
                                                <td style="width: 10%"><input disabled type="text" class="form-control minord text-right" value="`+ result[i].pbp_minorder +`"></td>
                                                <td style="width: 10%"><input type="text" class="form-control qtypb text-right" value="` + thousands_separators(result[i].pbp_qtypb) +`" id="`+ i +`"  onclick="changeDesc('`+result[i].pbp_prdcd+`')" onkeypress="qty(this.value,this.id, `+ idsup +`,event)"></td>
                                                <td style="width: 10%"><input disabled type="text" class="form-control dimensi text-right" value="`+ thousands_separators(result[i].pbp_dimensi)  +`"></td>
                                                <td style="width: 10%"><input disabled type="text" class="form-control kubikase text-right" value="`+ thousands_separators(result[i].pbp_kubikase) +`"></td>
                                            </tr>`;


                                $('#tbody2').append(html2);
                                // onchange="qty(this.value,this.id, `+ idsup +`)"
                                // total = tempgross + ppn;
                                // $('#total').val(convertToRupiah(tempgross));

                            // }
                            // else {
                            //         alert('Tidak ada PLU yang bisa di PB untuk tgl ' + tglpb);
                            //     }
                        }
                        $('#deskripsiPanjang').val(data.prd_deskripsipanjang);
                        $('.qtypb')[0].focus();
                        $('.baris2')[0].style.backgroundColor = "teal";

                    }


                   // $('#modal-loader').modal('hide');

                        // for(i=0; i<result.length; i++){
                        //     tempgross = parseFloat(tempgross) + parseFloat(result[i].trbo_gross)
                        // }
                        // $('#totalgross').val(convertToRupiah(tempgross));
                }
                // alert("No DOC yg dipilih : " + val)
            })
            $('#modal-help-1').modal('hide');

        }

        function changeDesc(prdcd){
            // console.log(datas);
            console.log(datas);

            for(var i = 0 ; i < datas.length ; i++){
                // console.log(i);
                    $('.baris2')[i].setAttribute("style", "background-color: none");
                    // $('.baris2')[i].style.backgroundColor = "";

                if (datas[i].pbp_prdcd == prdcd){
                    $('#deskripsiPanjang').val(datas[i].prd_deskripsipanjang);
                    $('.baris2')[i].setAttribute("style", "background-color: teal");
                    // $('.baris2')[i].style.backgroundColor = "teal";
                }
            }
        }




        function qty(val, index , idsup,e){
            //((STOCK + PO OUT + PB OUT + qty PB)/ ISI CTN) * DIMENSI

            // select pbp_qtypb into qtypb_db
            // from tbtr_pb_perishable
            //     WHERE     pbp_nopb = :no_pb
            //     AND pbp_kodesupplier = :h_supp
            //     AND pbp_kodesarana = :h_sarana
            //     AND pbp_prdcd = :d_prdcd;
            // console.log(e.which);
            if(e.which === 13) {
                e.preventDefault();
                index = parseInt(index);
                let nopb = $('#no-pb').val();
                let kodesup = $('.supplierid')[idsup].value;
                let kodesar = $('.kodesarana')[idsup].value;
                let volsar = $('.volsarana')[idsup].value;
                var volsarint = parseInt(thousands_combiners(thousands_combiners(volsar)));
                console.log('volsarint');
                console.log(volsarint);
                let plu     = $('.plu')[index].value;
                let pkm     = $('.pkm')[index].value;
                let stock = $('.stock')[index].value;
                let poout = $('.poout')[index].value;
                let pbout = $('.pbout')[index].value;
                let qtypb = thousands_combiners($('.qtypb')[index].value);
                let minorder = $('.minord')[index].value;
                let isictn = $('.isictn')[index].value;
                let dimensi = thousands_combiners($('.dimensi')[index].value);
                let tempKubikase;
                // let round = ROUND (( $pkm - $stock) / $minorder);
                // tempKubikase = ROUND(((stock + poout + pbout + qtypb)/isictn) * dimensi);

                // $('.kubikase')[index].value = tempKubikase;

                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/qtyPb',
                    type: 'post',
                    data: {plu:plu, nopb: nopb, qtypb:qtypb, stock:stock, poout:poout, pbout:pbout ,minorder:minorder, pkm:pkm, isictn:isictn, dimensi:dimensi, kodesup:kodesup, kodesar:kodesar}, //noplu sebelah kiri buat panggil noplu di controller, sebelah kanan yg dari parameter
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (result) { //result bukan dr controller, cuma penamaan
                        $('#modal-loader').modal('hide');
                        console.log(result);
                        if(result.message == ''){
                            console.log(result.kubikase);
                            console.log(result.qtypblog);
                            $('.kubikase')[index].value = thousands_separators(result.kubikase);
                            var totalkubik = parseInt(result.totalkubik);
                            $('.totalkubik')[idsup].value = thousands_separators(totalkubik);
                            console.log('totalkubik');
                            console.log(totalkubik);
                            console.log('volsarint');
                            console.log(volsarint);
                            if(totalkubik > volsarint){
                                $('.flag')[idsup].value = "X";
                            }
                            else{
                                $('.flag')[idsup].value = "";
                            }

                        }
                        else if (result.message == "{{__('Qty PB kelipatan min order')}}"){
                            qtypbint = parseInt(qtypb);
                            minorderint = parseInt(minorder);
                            console.log(qtypbint % minorderint);
                            console.log(minorderint);
                            console.log(qtypbint);  
                            times = parseInt(qtypbint / minorderint);
                            console.log('times');
                            console.log(times);
                            let qtypb2 = '';
                            if (qtypbint < minorderint){
                                $('.qtypb')[index].value = thousands_separators(minorder);
                            }
                            else{
                                if (qtypbint - (minorderint * times) >=  minorderint/2 ){
                                    qtypb2 = qtypbint + (minorderint - (qtypbint - (minorderint * times)))
                                    $('.qtypb')[index].value = thousands_separators(qtypb2);
                                    // qty(qtypb2, index , idsup,e);
                                }
                                else{
                                    qtypb2 = qtypbint - (qtypbint - (minorderint * times))
                                    $('.qtypb')[index].value = thousands_separators(qtypb2);
                                    // qty(qtypb2, index , idsup,e);
                                }
                            }
                            
                            
                            // $('.qtypb')[index].value = thousands_separators(minorder);
                            swal({
                                title: result.message,
                                icon: 'error'
                            }).then(function(confirm){
                                qty(qtypb2, index , idsup,e);
                            })
                            return;
                        }
                        else{
                            swal({
                                title: result.message,
                                icon: 'error'
                            })
                            return;
                        }
                        var qtycontroller = parseInt(result.qtypblog);
                        $('.qtypb')[index].value = thousands_separators(qtycontroller);
                        // $('.qtypb')[index].value = thousands_separators(qtypb);
                        console.log(datas.length);
                        console.log(index+1);

                        if(index+1 != datas.length){
                            $('.qtypb')[index+1].click();
                            $('.qtypb')[index+1].focus();
                        }
                    }, error: function (error) {
                        //$('#modal-loader').modal('hide')
                        console.log(error)
                    }
                })
            }


        }

        function prosesDoc(event) {
            event.preventDefault();
            let nopb = $('#no-pb').val();
            let tglpb = $('#tgl-pb').val();
            // if :no_pb is null then return; end if;
            if (!nopb){
                console.log('nopb null');
                return;
            }

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/prosesDoc',
                type: 'post',
                data: {nopb:nopb, tglpb:tglpb},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    console.log('hi proses');
                    console.log(response.temp);
                    console.log(response.no_pb);
                    if (response.flag == 0){
                        chooseSup(response.no_pb);
                        $('#btn-proses').attr('disabled', true);
                    }
                    else{
                        swal(response.status, response.message, response.status);
                        $('#btn-proses').attr('disabled', false);
                    }
                }
            })

        }


        $('#btn-save').on('click', function () {
            let tempTR  = $('.plu');
            let tglpb = $('#tgl-pb').val();
            let nopb   = $('#no-pb').val();
            let data   = [{ 'plu' : '' , 'pkm' : '', 'stock' : '', 'poout' : '', 'pbout' : '', 'qtypb' : '', 'minorder' : '', 'mindisplay' : '', 'isictn' : '', 'dimensi' : '', 'avgsales' : '', 'kubikase' : ''}];

            // if ($('.deskripsi').val().length < 1){
            //     swal({
            //         title:'Data Tidak Boleh Kosong',
            //         text: ' ',
            //         icon:'warning',
            //         timer: 1000,
            //         buttons: {
            //             confirm: false,
            //         },
            //     });

            //     return false;
            // }

            for (let i=0; i < tempTR.length; i++){
                let plu     = $('.plu')[i].value;
                let pkm     = $('.pkm')[i].value;
                let stock = $('.stock')[i].value;
                let poout = $('.poout')[i].value;
                let pbout = $('.pbout')[i].value;
                let qtypb = thousands_combiners($('.qtypb')[i].value);
                let minorder = $('.minord')[i].value;
                let mindisplay = $('.mindisp')[i].value;
                let isictn = $('.isictn')[i].value;
                let dimensi = thousands_combiners($('.dimensi')[i].value);
                let avgsales = $('.avgsales')[i].value;
                let kubikase = thousands_combiners($('.kubikase')[i].value);

                data.push({'plu' : plu , 'pkm' : pkm, 'stock' : stock, 'poout' : poout, 'pbout' : pbout, 'qtypb' : qtypb, 'minorder' : minorder, 'mindisplay' : mindisplay, 'isictn' : isictn, 'dimensi' : dimensi, 'avgsales' : avgsales, 'kubikase' : kubikase})

            }
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/saveDoc',
                type: 'post',
                data: {
                    data:data,
                    tglpb:tglpb,
                    nopb:nopb
                },
                // beforeSend: function () {
                //     $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                // },
                success: function (result) {
                    console.log(result)
                    if(result.errflag == 1){
                        swal({
                            title:result.status,
                            text: result.message,
                            icon: result.status,
                        });
                        return;
                    }
                    else if (result.errflag == 2){
                        swal({
                            title:result.status,
                            text: result.message,
                            icon: result.status,
                        }).then(function(confirm){
                            if(confirm){
                                ajaxSetup();
                                $.ajax({
                                    url: '{{ url()->current() }}/saveDoc2',
                                    type: 'post',
                                    data: {
                                        data:data,
                                        tglpb:tglpb,
                                        nopb:nopb
                                    },
                                    beforeSend: function () {
                                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                    },
                                    success: function (result){
                                        $('#modal-loader').modal('hide')
                                        swal({
                                            title: result.status,
                                            text: result.message,
                                            icon: result.status,
                                        });

                                        if(!result.nopbnew){
                                            return;
                                        }
                                        else{
                                            swal({
                                                title: "{{__('Simpan PB ?')}}",
                                                icon: 'warning',
                                                dangerMode: true,
                                                buttons: true,
                                            }).then(function(confirm){
                                                if(confirm){
                                                    ajaxSetup();
                                                    $.ajax({
                                                        url: '{{ url()->current() }}/saveDoc3',
                                                        type: 'post',
                                                        data: {
                                                            data:data,
                                                            tglpb:tglpb,
                                                            nopb:nopb
                                                        },
                                                        beforeSend: function () {
                                                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                                        },
                                                        success: function (result){
                                                            $('#modal-loader').modal('hide')
                                                            clearField();
                                                            $('#btn-save').attr("disabled", true)
                                                            swal({
                                                                title: result.status,
                                                                text: result.message,
                                                                icon: result.status,
                                                            }).then(function(confirm){
                                                                window.location.reload();
                                                            })

                                                        }, error: function () {
                                                            alert('error');
                                                            //$('#modal-loader').modal('hide')
                                                        }
                                                    }) 
                                                } else {
                                                    console.log('Tidak Save Doc3');
                                                }
                                            })
                                        }

                                    }, error: function () {
                                        alert('error');
                                        // $('#modal-loader').modal('hide')
                                    }
                                })
                            }
                        })
                    }
                    else {
                        swal({
                            title: "{{__('Simpan PB ?')}}",
                            icon: 'warning',
                            dangerMode: true,
                            buttons: true,
                        }).then(function(confirm){
                            if(confirm){
                                ajaxSetup();
                                $.ajax({
                                    url: '{{ url()->current() }}/saveDoc3',
                                    type: 'post',
                                    data: {
                                        data:data,
                                        tglpb:tglpb,
                                        nopb:nopb
                                    },
                                    beforeSend: function () {
                                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                    },
                                    success: function (result){
                                        $('#modal-loader').modal('hide')
                                        swal({
                                            title: result.status,
                                            text: result.message,
                                            icon: result.status,
                                        });
                                        clearField();
                                        $('#btn-save').attr("disabled", true)

                                    }, error: function () {
                                        alert('error');
                                        //$('#modal-loader').modal('hide')
                                    }
                                })
                            }
                        })
                    }
                //     swal({
                //     title: result.message,
                //     icon: result.status,
                //     dangerMode: true,
                //     buttons: true,
                // }).then(function(confirm){
                //     if(confirm){
                        // ajaxSetup();
                        // $.ajax({
                        //     url: '{{ url()->current() }}/saveDoc2',
                        //     type: 'post',
                        //     data: {
                        //         data:data,
                        //         tglpb:tglpb,
                        //         nopb:nopb
                        //     },
                        //     beforeSend: function () {
                        //         $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        //     },
                        //     success: function (result){
                        //         $('#modal-loader').modal('hide')
                        //         swal({
                        //             title: result.status,
                        //             text: result.message,
                        //             icon: result.status,
                        //         });

                        //         if(!result.nopbnew){
                        //             return;
                        //         }
                        //         else{
                        //             swal({
                        //                 title: 'Simpan PB ?',
                        //                 icon: 'warning',
                        //                 dangerMode: true,
                        //                 buttons: true,
                        //             }).then(function(confirm){
                        //                 if(confirm){
                        //                     ajaxSetup();
                        //                     $.ajax({
                        //                         url: '{{ url()->current() }}/saveDoc3',
                        //                         type: 'post',
                        //                         data: {
                        //                             data:data,
                        //                             tglpb:tglpb,
                        //                             nopb:nopb
                        //                         },
                        //                         beforeSend: function () {
                        //                             $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        //                         },
                        //                         success: function (result){
                        //                             $('#modal-loader').modal('hide')
                        //                             swal({
                        //                                 title: result.status,
                        //                                 text: result.message,
                        //                                 icon: result.status,
                        //                             });
                        //                             clearField();
                        //                             $('#btn-save').attr("disabled", true)

                        //                         }, error: function () {
                        //                             alert('error');
                        //                             //$('#modal-loader').modal('hide')
                        //                         }
                        //                     })
                        //                 } else {
                        //                     console.log('Tidak Save Doc3');
                        //                 }
                        //             })
                        //         }

                        //     }, error: function () {
                        //         alert('error');
                        //         // $('#modal-loader').modal('hide')
                        //     }
                        // })
                //     } else {
                //         console.log('Tidak Save Doc2');
                //     }
                // })
                // $('#modal-loader').modal('hide')
                    //
                }, error: function () {
                    alert('error');
                }
            })

        })

        // function focusToRow(index) {
        //     swal({
        //         title:'QTYB + QTYK < = 0',
        //         text: ' ',
        //         icon:'warning',
        //         timer: 1000,
        //         buttons: {
        //             confirm: false,
        //         },
        //     });
        //     $('.qtypb')[index].focus()
        // }

        function thousands_separators(num){
            if(num == null){
                num = '';
                return num;
            }
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return num_parts.join(".");

        }
        function thousands_combiners(num){
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(",", "");
            return num_parts.join(".");
        }



        function deleteDoc(event) {
            event.preventDefault();
            let nopb = $('#no-pb').val();

            swal({
                title: "{{__('Nomor PB Akan dihapus?')}}",
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function(confirm){
                if(confirm){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/deleteDoc',
                        type: 'post',
                        data: {nopb: nopb},
                        // beforeSend: function () {
                        //     $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        // },
                        success: function (response){
                            //$('#modal-loader').modal('hide');
                            if (response.message == "{{__('Draft sudah menjadi PB')}}"){
                                swal({
                                    title: "{{__('Tidak Bisa Delete')}}",
                                    text: response.message,
                                    icon: response.status,
                                })
                            }
                            else{
                                clearField()

                                swal({
                                    title: response.status,
                                    text: response.message,
                                    icon: response.status,
                                }).then(function(confirm){
                                    window.location.reload();
                                })
                            }
                            
                        }, error: function () {
                            alert('error');
                            //$('#modal-loader').modal('hide')
                        }
                    })
                } else {
                    console.log('Tidak dihapus');
                }
            })

        }

        function clearField(){
            $('#no-pb').val("");
            $('#tgl-pb').val(today);
            $('#model').val("");
            $('#deskripsiPanjang').val("");
            $('#namasupplier').val("");
            $('#tgl-pb').prop('disabled', false);

            console.log('remove table 2');
            $('.baris2').remove();
            for (i = 0; i< 15; i++) {
                $('#tbody2').append(temptable2(i));
            }
            console.log('remove table 1');
            $('.baris1').remove();
            for (i = 0; i< 5; i++) {
                $('#tbody1').append(temptable1(i));
            }

            //    Memperbaharui LOV Nomor TRN
            // tempTrn = null;
        }

        function temptable1(index){
            var tmptbl = `<tr class="d-flex baris1">
                                                <td style="width: 23%"><input type="text" class="form-control supplierid" id="supplierid" no="{{$i}}"></td>
                                                <td style="width: 23%"><input disabled type="text" class="form-control kodesarana" id="kodesarana"></td>
                                                <td style="width: 23%"><input disabled type="text" class="form-control volsarana text-right"></td>
                                                <td style="width: 23%"><input disabled type="text" class="form-control totalkubik text-right"></td>
                                                <td style="width: 8%"><input disabled type="text" class="form-control flag text-right"></td>
                                            </tr>`;

            return tmptbl;
        }

        function temptable2(index){
            var tmptbl = `<tr class="d-flex baris2">
                                                    <td class="buttonInside" style="width: 10%"><input disabled type="text" class="form-control plu" id="plu" no="{{$i}}"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control pkm" id="pkm"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control avgsales"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control isictn"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control stock text-right"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control poout"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control pbout text-right"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control mindisp text-right"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control minord text-right" ></td>
                                                    <td style="width: 10%"><input type="text" class="form-control qtypb text-right" id="{{$i}}"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control dimensi text-right"></td>
                                                    <td style="width: 10%"><input disabled type="text" class="form-control kubikase"></td>
                                                </tr>`;

            return tmptbl;
        }

    </script>

@endsection
