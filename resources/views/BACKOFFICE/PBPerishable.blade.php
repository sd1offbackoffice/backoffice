@extends('navbar')
@section('title','PB | PB PERISHABLE')
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
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control text-center" id="model" disabled>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label for="no-pb" class="col-sm-2 col-form-label">NOMOR PB</label>
                                                <div class="col-sm-2 buttonInside">
                                                    <input type="text" class="form-control" id="no-pb">
                                                    <button id="btn-no-pb" type="button" class="btn btn-lov p-0" onclick="getNmrPB()">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label for="tgl-pb" class="col-sm-2 col-form-label">TANGGAL PB</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="tgl-pb">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0 ml-5">
                                                 <button class="btn btn-primary btn-sm float-left" id="btn-proses" {{--onclick="deleteDoc(event)"--}}> 
                                                    PROSES
                                                </button>
                                                <button class="btn btn-primary btn-sm float-left" id="btn-hapus" onclick="deleteDoc(event)">
                                                    DELETE AND CLOSE
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </fieldset>
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Detail</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="col-sm-12">
                            <div class="card-body p-0 tableFixedHeader" style="border-bottom: 1px solid black">
                                <table class="table table-striped table-bordered" id="table-detail">
                                    <thead class="header-table">
                                    <tr class="d-flex text-center">
                                        {{-- <th style="width: 3%">X</th> --}}
                                        <th style="width: 7%">SUPPLIER</th>
                                        <th style="width: 7%">KODE SARANA</th>
                                        <th style="width: 7%">VOLUME SARANA</th>
                                        <th style="width: 7%">TOTAL KUBIKASE ITEM</th>                                       
                                    </tr>
                                    </thead>
                                    <tbody id="tbody1">
                                    @for($i = 0; $i< 5; $i++)
                                        <tr class="d-flex baris">
                                            <td style="width: 7%"><input type="text" class="form-control supplierid" id="supplierid" no="{{$i}}"></td>
                                            <td style="width: 7%"><input disabled type="text" class="form-control kodesarana" id="kodesarana"></td>
                                            <td style="width: 7%"><input disabled type="text" class="form-control volumesar text-right"></td>
                                            <td style="width: 7%"><input disabled type="text" class="form-control totalkubik text-right"></td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                                <table class="table table-striped table-bordered" id="table-detail">
                                    <thead class="header-table">
                                    <tr class="d-flex text-center">
                                        {{-- <th style="width: 3%">X</th> --}}
                                        <th style="width: 7%">PLU</th>
                                        <th style="width: 5%">PKM</th>
                                        <th style="width: 7%">AVG SALES</th>
                                        <th style="width: 5%">ISI CTN</th>
                                        <th style="width: 5%">STOCK</th>
                                        <th style="width: 5%">PO OUT</th>
                                        <th style="width: 5%">PBOUT</th>
                                        <th style="width: 5%">MIN DISPLAY</th>
                                        <th style="width: 5%">MIN ORDER</th>
                                        <th style="width: 5%">QTY PB</th>
                                        <th style="width: 5%">DIMENSI</th>
                                        <th style="width: 8%">KUBIKASE</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody2">
                                    @for($i = 0; $i< 10; $i++)
                                        <tr class="d-flex baris">
                                            {{-- <td style="width: 3%" class="text-center">
                                                <button class="btn btn-danger btn-delete"  style="width: 100%" onclick="deleteRow(this)">X</button>
                                            </td> --}}

                                            <td class="buttonInside" style="width: 7%">
                                                <input type="text" class="form-control plu" id="plu" no="{{$i}}">
                                                <button id="btn-no-plu" type="button" class="btn btn-lov ml-3" onclick="getPlu(this)" no="{{$i}}">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            {{-- <td style="width: 5%"><input disabled type="text" class="form-control deskripsi" id="deskripsi"></td> --}}
                                            <td style="width: 5%"><input disabled type="text" class="form-control pkm" id="pkm"></td>
                                            <td style="width: 7%"><input disabled type="text" class="form-control avgsales"></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control isictn"></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control stock text-right"></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control poout"></td>                                            
                                            <td style="width: 5%"><input type="text" class="form-control pbout text-right"></td>
                                            <td style="width: 5%"><input type="text" class="form-control mindisp text-right"></td>
                                            <td style="width: 5%"><input type="text" class="form-control minord text-right" ></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control qtypb text-right"id="{{$i}}" onchange="qty(this.value,this.id,1)"></td>
                                            <td style="width: 5%"><input type="text" class="form-control dimensi text-right"></td>
                                            <td style="width: 8%"><input type="text" class="form-control kubikase"></td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td>
                                            <input disabled type="text" class="mt-1 form-control deskripsiPanjang">
                                            {{-- <button class="btn btn-primary btn-block" id="btn-addRow" >
                                                TAMBAH BARIS BARU
                                            </button> --}}
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mb-0">
                                        <label for="deskripsiPanjang" class="col-sm-1 col-form-label text-right"></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="deskripsiPanjang" disabled>
                                        </div>
                                        <label for="avg-cost" class="col-sm-2 col-form-label text-right">AVG COST</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control text-right" id="avg-cost" disabled>
                                        </div>
                                    </div>
                                </form>
                            </div> --}}
                        </div>
                        <fieldset class="card border-secondary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <form>
                                            <div class="row text-right">
                                                <div class="col-sm-12">
                                                    <div class="form-group row mb-0">
                                                        <p class="col-sm-2" >DIMENSI -> dimensi in CTN</p>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <p class="col-sm-2" >KUBIKASE -> ((STOCK + PO OUT + PB OUT + qty PB)/ ISI CTN) * DIMENSI</p>
                                                    </div>
                                                    <div class="form-group row mb-0">                                                       
                                                        <div class="col-sm-10">
                                                            <button class="btn btn-primary pl-4 pr-4 mr-4" id="btn-save" type="button">
                                                                SIMPAN PB
                                                            </button>
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
                                            <td>NO. DOC</td>
                                            <td>TIPE</td>
                                            <td>NOTA</td>
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

    {{--Modal Plu--}}
    <div class="modal fade" id="modal-help-2" tabindex="-1" role="dialog" aria-labelledby="modal-help-2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search-modal-2" class="form-control search-modal-2" type="text" placeholder="..." aria-label="Search">
{{--                        <div class="invalid-feedback"> Inputkan minimal 3 karakter</div>--}}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm" id="modal-table-2">
                                        <thead class="header-modal">
                                        <tr class="font">
                                            <td>Deskripsi</td>
                                            <td>PLU</td>
                                        </tr>
                                        </thead>
                                        <tbody class="tbody-modal-2">
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
                let nodoc = $('#no-pb').val();
                nmrBaruTrn(nodoc);
            }
        });

        // function nmrBaruTrn(nodoc){
        //     if(nodoc == ''){
        //         swal({
        //             title: 'Buat Nomor Hilang Baru?',
        //             icon: 'info',
        //             buttons: true,
        //         }).then(function(confirm){
        //             if(confirm){
        //                 ajaxSetup();
        //                 $.ajax({
        //                     url: '{{ url()->current() }}/nmrBaruTrn',
        //                     type: 'post',
        //                     data: {nodoc: nodoc},
        //                     // beforeSend: function () {
        //                     //     $('#modal-loader').modal({backdrop: 'static', keyboard: false});
        //                     // },
        //                     success: function (result){
        //                         $('#no-pb').val(result);
        //                         $('#tgl-pb').val(formatDate('now'));
        //                         $('#model').val('* TAMBAH *');
        //                         $('#deskripsiPanjang').val("");
        //                         $('#total-item').val("");
        //                         $('#totalgross').val("");
        //                         $('#ppn').val("");
        //                         $('#total').val("");
        //                         $('#modal-loader').modal('hide')
        //                         $('#btn-hapus').attr('disabled', false);
        //                         $('#btn-save').attr('disabled', false);
        //                         $('#btn-addRow').attr('disabled', false);
        //                     }, error: function () {
        //                         alert('error');
        //                         //$('#modal-loader').modal('hide')
        //                     }
        //                 })
        //             }
        //         })
        //     } else {
        //         chooseDoc(nodoc);
        //     }
        // }

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
                        let temp = ` <tr class="modalRow" onclick=chooseDoc('`+ result[i].trbo_nodoc+`')>
                                        <td>`+ result[i].trbo_nodoc +`</td>
                                        <td>`+ result[i].trbo_tipe +`</td>
                                        <td>`+ result[i].nota +`</td>
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
                            let temp = `<tr class="modalRow" onclick=chooseDoc('`+ result[i].trbo_nodoc+`')>
                                        <td>`+ result[i].trbo_nodoc +`</td>
                                        <td>`+ result[i].trbo_tipe +`</td>
                                        <td>`+ result[i].nota +`</td>
                                     </tr>`;
                            $('.tbody-modal-1').append(temp);
                        }
                        // $('#modal-help-1').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                });
            }
        })

        $('#search-modal-2').keypress(function (e) {
            if (e.which === 13) {
                let search = $('#search-modal-2').val();
                let index = this['attributes'][4]['value'];
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/lov_plu',
                    type: 'POST',
                    data: {search: search},
                    success: function (result) {
                        // console.log(result)
                        $('.modalRow').remove();
                        for (i = 0; i < result.length; i++) {
                            let temp = "<tr onclick=choosePlu('"+ result[i].prd_prdcd +"','"+ index +"') class='modalRow'>" +
                                "<td>"+ result[i].prd_deskripsipanjang +"</td> " +
                                "<td>"+ result[i].prd_prdcd +"</td>" +
                                "</tr>"
                            $('.tbody-modal-2').append(temp);
                        }
                        // $('#modal-help-1').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                });
            }
        });

        function getPlu(temp) {
            $('#search-modal-2').val('')
            let index = temp['attributes'][4]['value']; //value nya string makanya pake petik
            // console.log(index)
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/lov_plu',
                type: 'post',
                data: {index:index},
                success: function (result) {
                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        let temp = "<tr onclick=choosePlu('"+ result[i].prd_prdcd +"','"+ index +"') class='modalRow'>" +
                            "<td>"+ result[i].prd_deskripsipanjang +"</td> " +
                            "<td>"+ result[i].prd_prdcd +"</td>" +
                            "</tr>"
                        $('.tbody-modal-2').append(temp);
                    }
                    $('#modal-help-2').modal('show');
                }, error: function () {
                    alert('error');
                }
            });
        }

        function chooseDoc(nodoc) {
            let tempgross = 0;
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/showTrn',
                type: 'post',
                data: {nodoc: nodoc},
                // beforeSend: function () {
                //     $('#modal-loader').modal('show');
                // },
                success: function (result) {
                   // $('#modal-loader').modal('hide');

                    if(result.length == 0){
                        swal({
                            title: 'Data tidak ada!',
                            icon: 'error'
                        })
                    }
                    else{
                        for(i=0; i<result.length; i++){
                            tempgross = parseFloat(tempgross) + parseFloat(result[i].trbo_gross)
                        }
                        $('#totalgross').val(convertToRupiah(tempgross));

                        if(result[0].nota === 'Belum Cetak Nota'){
                            //console.log(result[0])
                            var html1 = "";
                            var html2 = "";
                            var i;
                            $('.baris').remove();

                            for(i=0; i<result.length; i++){
                                // qtyctn = result[i].trbo_qty / result[i].prd_frac;
                                // qtypcs = result[i].trbo_qty % result[i].prd_frac;
                                // ppn = result[i].trbo_ppnrph * 0;
                                kubikase = ((result[i].pbp_stock + result[i].pbp_poout + result[i].pbp_pbout + result[i].pbp_qtypb)/ result[i].pbp_isictn) * result[i].pbp_dimensi; 
                                result[i].pbp_kubikase = kubikase;

                                

                                html2 = `<tr class="d-flex baris">                                               
                                                <td class="buttonInside" style="width: 7%">
                                                    <input type="text" class="form-control plu" value="`+ result[i].pbp_prdcd +`">
                                                </td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control pkm" value="`+ result[i].pbp_pkm +`"></td>
                                                <td style="width: 7%"><input disabled type="text" class="form-control avgsales" value="`+ result[i].pbp_avgsales +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control isictn" value="`+ result[i].pbp_isictn +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control stock text-right" value="`+ result[i].pbp_stock +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control poout" value="`+ result[i].pbp_qtypoout +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control pbout text-right" value="`+ result[i].pbp_qtypnout +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control mindisp text-right" value="`+ result[i].pbp_mindisplay +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control minord text-right" value="`+ result[i].pbp_minorder +`"></td>
                                                <td style="width: 5%"><input type="text" class="form-control qtypb text-right" value="` + result[i].pbp_qtypb +`" id="`+ i +`" onchange="qty(this.value,this.id,2)"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control dimensi text-right" value="`+ result[i].pbp_dimensi +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control kubikase text-right" value="`+ result[i].pbp_kubikase +`"></td>
                                            </tr>`;
                                
                                
                                $('#tbody2').append(html2);
                                $('#no-pb').val(result[i].pbp_nopb);
                                $('#tgl-pb').val(formatDate(result[i].pbp_tglpb));
                                $('#model').val('* KOREKSI *');
                                $('#deskripsiPanjang').val(result[i].prd_deskripsipanjang);
                                $('#avg-cost').val(convertToRupiah(result[i].trbo_averagecost));
                                $('#total-item').val(result.length);
                                $('#ppn').val('0');
                                $('#btn-save').attr('disabled', false);
                                $('#btn-hapus').attr('disabled', false);
                                $('#btn-addRow').attr('disabled', false);
                                // total = tempgross + ppn;
                                $('#total').val(convertToRupiah(tempgross));
                            }
                        } else {
                            var html2 = "";
                            var i;
                            $('.baris').remove();

                            for (i = 0; i < result.length; i++) {
                                // qtyctn = result[i].trbo_qty / result[i].prd_frac;
                                // qtypcs = result[i].trbo_qty % result[i].prd_frac;
                                // ppn = result[i].trbo_ppnrph * 0;
                                kubikase = ((result[i].pbp_stock + result[i].pbp_poout + result[i].pbp_pbout + result[i].pbp_qtypb)/ result[i].pbp_isictn) * result[i].pbp_dimensi; 
                                result[i].pbp_kubikase = kubikase;


                                html2 = `<tr class="d-flex baris">                                               
                                                <td class="buttonInside" style="width: 7%">
                                                    <input type="text" class="form-control plu" value="`+ result[i].pbp_prdcd +`">
                                                </td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control pkm" value="`+ result[i].pbp_pkm +`"></td>
                                                <td style="width: 7%"><input disabled type="text" class="form-control avgsales" value="`+ result[i].pbp_avgsales +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control isictn" value="`+ result[i].pbp_isictn +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control stock text-right" value="`+ result[i].pbp_stock +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control poout" value="`+ result[i].pbp_qtypoout +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control pbout text-right" value="`+ result[i].pbp_qtypnout +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control mindisp text-right" value="`+ result[i].pbp_mindisplay +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control minord text-right" value="`+ result[i].pbp_minorder +`"></td>
                                                <td style="width: 5%"><input type="text" class="form-control qtypb text-right" value="` + result[i].pbp_qtypb +`" id="`+ i +`" onchange="qty(this.value,this.id,2)"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control dimensi text-right" value="`+ result[i].pbp_dimensi +`"></td>
                                                <td style="width: 5%"><input disabled type="text" class="form-control kubikase text-right" value="`+ result[i].pbp_kubikase +`"></td>
                                            </tr>`;

                                $('#tbody2').append(html2);
                                $('#no-pb').val(result[i].trbo_nodoc);
                                $('#tgl-pb').val(formatDate(result[i].pbp_createdt));
                                $('#model').val('* PB SUDAH DICETAK / TRANSFER *');
                                $('#deskripsiPanjang').val(result[i].prd_deskripsipanjang);
                                $('#total-item').val(result.length);
                                $('#ppn').val('0');
                                $('#btn-save').attr('disabled', true);
                                $('#btn-hapus').attr('disabled', true);
                                $('#btn-addRow').attr('disabled', true);
                                // total = tempgross + ppn;
                                $('#total').val(convertToRupiah(tempgross));
                            }
                        }
                        html1 = `<tr class="d-flex baris">
                                <td style="width: 7%"><input type="text" class="form-control supplierid" value="`+ result[i].pbp_kodesupplier +`"></td>
                                <td style="width: 7%"><input disabled type="text" class="form-control kodesarana" value="`+ result[i].pbp_kodesarana +`"></td>
                                <td style="width: 7%"><input disabled type="text" class="form-control volumesar text-right" value="`+ result[i].pbp_volsarana +`"></td>
                                <td style="width: 7%"><input disabled type="text" class="form-control totalkubik text-right" value="`+ result[i].pbp_kubikase +`"></td>
                                </tr>`;

                        $('#tbody1').append(html1);

                    }
                }
                // alert("No DOC yg dipilih : " + val)
            })
            $('#modal-help-1').modal('hide');
        }

        function choosePlu(noplu, index) {
            // for (let i =0 ; i <$('.plu').length; i++){
            //     if ($('.plu')[i]['attributes'][2]['value'] == index){ //i itu index ke brp, 2 itu baris 2,
            // value nya buat dptin nama class, class biasa pake di css, id javascript, name buat php
            //         index = i;
            //     }
            // }

            $('.plu')[index].value = noplu;
            $('#modal-help-2').modal('hide');
            let temp = 0;
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/showPlu',
                type: 'post',
                data: {noplu:noplu}, //noplu sebelah kiri buat panggil noplu di controller, sebelah kanan yg dari parameter
                // beforeSend: function () {
                //     $('#modal-loader').modal('show');
                // },
                success: function (result) { //result bukan dr controller, cuma penamaan
                    //$('#modal-loader').modal('hide');

                    if(result.noplu === 1){
                        data = result.data[0]; //array sebagai penanda data mana yang dipilih, pake result.data krn controller nya manggil byk

                        $('.plu')[index].value = data.st_prdcd;
                        $('.deskripsi')[index].value = data.prd_deskripsipendek;
                        $('.satuan')[index].value = data.prd_unit + ' / ' + data.prd_frac;
                        $('.tag')[index].value = data.prd_kodetag;
                        $('.bkp')[index].value = data.prd_flagbkp1;
                        $('.ctn')[index].value = '0';
                        $('.pcs')[index].value = '0';
                        $('.hrgsatuan')[index].value = convertToRupiah(result.hrgsatuan);
                        $('.stock')[index].value = convertToRupiah2(data.st_saldoakhir);
                        $('#avg-cost').val(convertToRupiah(result.avgcost));
                        $('#deskripsiPanjang').val(data.prd_deskripsipanjang);

                        for (i = 0; i < $('.plu').length; i++) {
                            if ($('.plu')[i].value != '') {
                                temp = temp + 1;
                            }
                        }
                        $('#total-item').val(temp)
                    } else if (result.noplu === 0){
                        swal('', result.message, 'warning')
                        $('#deskripsiPanjang').val('');
                        $('#avg-cost').val('');

                        data = result.data[0]; //array sebagai penanda data mana yang dipilih, pake result.data krn controller nya manggil byk

                        $('.plu')[index].value = data.st_prdcd;
                        $('.deskripsi')[index].value = data.prd_deskripsipendek;
                        $('.satuan')[index].value = data.prd_unit + ' / ' + data.prd_frac;
                        $('.tag')[index].value = data.prd_kodetag;
                        $('.bkp')[index].value = data.prd_flagbkp1;
                        $('.ctn')[index].value = '0';
                        $('.pcs')[index].value = '0';
                        $('.hrgsatuan')[index].value = convertToRupiah(result.hrgsatuan);
                        $('.stock')[index].value = convertToRupiah2(data.st_saldoakhir);
                        $('#avg-cost').val(convertToRupiah(result.hrgsatuan));
                        $('#deskripsiPanjang').val(data.prd_deskripsipanjang);

                        for (i = 0; i < $('.plu').length; i++) {
                            if ($('.plu')[i].value != '') {
                                temp = temp + 1;
                            }
                        }
                        $('#total-item').val(temp)
                    } else {
                        swal('Error', '', 'error')
                    }
                }, error: function (error) {
                    //$('#modal-loader').modal('hide')
                    console.log(error)
                }
            })
            // alert("No PLU yg dipilih : " + noplu)
        }

        $('.plu').keypress(function (e) {
            if (e.which === 13) {
                let row = $(this).attr('no');
                let val = convertPlu($(this).val());
                choosePlu(val,row)
            }
        })

        function qty(value, index, noplu){
            let plu     = $('.plu')[index].value;
            let temp    = $('.satuan')[index].value;
            let ctn     = $('.ctn')[index];
            let pcs     = $('.pcs')[index];
            let hrgsatuan = $('.hrgsatuan')[index].value;
            let gross   = $('.gross')[index];
            let totalgross = $('#totalgross');
            let total = $('#total');
            let ppn = $('#ppn');
            let tempTtlGross = 0;
            let frac    = temp.substr(temp.indexOf('/')+1);
            let stock;
            let qty = 0;
            let qty1 = 0;
            let qty2 = 0;
            let ttl;
            let hitqty;
            let hitctn;
            let hitpcs;

            hitqty = (parseInt(ctn.value) * frac) + parseInt(pcs.value);
            hitctn = hitqty/frac;
            hitpcs = hitqty%frac;

            qty1 = ctn.value * frac;
            qty2 = pcs.value;
            qty  = parseInt(qty1) + parseInt(qty2);

            price = qty * unconvertToRupiah(hrgsatuan) / frac;
            parseInt(totalgross,10);
            parseInt(price,10);
            gross.value = convertToRupiah(price);

            for(i = 0; i < $('.gross').length; i++){
                if($('.gross')[i].value != ''){
                    tempTtlGross = parseFloat(tempTtlGross) + parseFloat(unconvertToRupiah($('.gross')[i].value));
                }
            }
            totalgross.val(convertToRupiah(tempTtlGross));
            ctn.value = Math.floor(hitctn,0);
            pcs.value = hitpcs;
            ppn.value = 0;
            ppn.val('0');
            ttl = tempTtlGross + ppn;
            total.val(convertToRupiah(tempTtlGross));

        }

        $('#btn-save').on('click', function () {
            let tempTR  = $('.plu');
            let tempDate= $('#tgl-pb').val();
            let nodoc   = $('#no-pb').val();
            let date    = tempDate.substr(3,2) + '/'+ tempDate.substr(0,2)+ '/'+ tempDate.substr(6,4);
            let data   = [{'plu' : '', 'qty' : '', 'hrgsatuan' : '', 'gross' : '', 'keterangan' : ''}];

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

            for (let i=0; i < tempTR.length; i++){
                var qty     = 0;
                let temp    = $('.satuan')[i].value;
                let frac    = temp.substr(temp.indexOf('/')+1);

                if ( tempTR[i].value){
                    qty  = parseInt( $('.ctn')[i].value * frac) + parseInt($('.pcs')[i].value);

                    if (qty < 1){
                        focusToRow(i);
                        return false;
                    }
                    data.push({'plu': $('.plu')[i].value, 'qty' : qty, 'hrgsatuan' : unconvertToRupiah($('.hrgsatuan')[i].value),
                        'gross' : unconvertToRupiah($('.gross')[i].value), 'keterangan' : $('.keterangan')[i].value})
                }
            }

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/saveDoc',
                type: 'post',
                data: {
                    data:data,
                    date:date,
                    nodoc:nodoc
                },
                // beforeSend: function () {
                //     $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                // },
                success: function (result) {
                    console.log(result)
                    if(result.kode == '1'){
                        swal('Dokumen Berhasil disimpan','','success')
                            .then((value) => {
                                window.location.reload();
                            });
                    } else {
                        swal('ERROR', "Something's Error", 'error')
                    }
                   // $('#modal-loader').modal('hide')
                    $('#btn-save').attr("disabled", true)
                    // clearField();
                }, error: function () {
                    alert('error');
                }
            })
        });

        function focusToRow(index) {
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

        function deleteDoc(event) {
            event.preventDefault();
            let nodoc = $('#no-pb').val();

                swal({
                    title: 'Nomor Dokumen Akan dihapus?',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: true,
                }).then(function(confirm){
                    if(confirm){ 
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/deleteDoc',
                            type: 'post',
                            data: {nodoc: nodoc},
                            // beforeSend: function () {
                            //     $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            // },
                            success: function (result){
                                //$('#modal-loader').modal('hide');
                                clearField();
                                swal({
                                    title: result.msg,
                                    icon: 'success'
                                });
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

        $('#btn-addRow').on('click', function() {
            var temp = $('#tbody').find('tr').length;
            let index = parseInt(temp, 10)
            html = `<tr class="d-flex baris">
                                            <td class="buttonInside" style="width: 7%">
                                                <input type="text" class="form-control plu" id="plu" no="{{$i}}">
                                                <button id="btn-no-plu" type="button" class="btn btn-lov ml-3" onclick="getPlu(this)" no="{{$i}}">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control pkm" id="pkm"></td>
                                            <td style="width: 7%"><input disabled type="text" class="form-control avgsales"></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control isictn"></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control stock text-right"></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control poout"></td>                                            
                                            <td style="width: 5%"><input type="text" class="form-control pbout text-right"></td>
                                            <td style="width: 5%"><input type="text" class="form-control mindisp text-right"></td>
                                            <td style="width: 5%"><input type="text" class="form-control minord text-right" ></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control qtypb text-right"id="{{$i}}" onchange="qty(this.value,this.id,1)"></td>
                                            <td style="width: 5%"><input type="text" class="form-control dimensi text-right"></td>
                                            <td style="width: 8%"><input type="text" class="form-control kubikase"></td>
                                        </tr>`;
            $('#tbody').append(html);
        });

        function deleteRow(e) {
            let temp        = 0;
            let tempGross  = 0;
            let tempTtl = 0;

            $(e).parents("tr").remove();
            $('#deskripsiPanjang').val('')

            for(i = 0; i < $('.plu').length; i++){
                if ($('.plu')[i].value != ''){
                    temp = temp + 1;
                }
                if($('.gross')[i].value != ''){
                    tempGross = parseFloat(tempGross) + parseFloat(unconvertToRupiah($('.gross')[i].value));
                }
                if($('#total')[i].value != ''){
                    tempTtl = parseFloat(tempTtl) + parseFloat(unconvertToRupiah($('.gross')[i].value));
                }
            }
            $('#total-item').val(temp);
            $('#totalgross').val(convertToRupiah(tempGross));
            $('#total').val(convertToRupiah(tempTtl));
        }

        function clearField(){
            $('#no-pb').val("");
            $('#tgl-pb').val(today);
            $('#model').val("");
            $('#deskripsiPanjang').val("");
            $('#avg-cost').val("");
            $('#total-item').val("");
            $('#totalgross').val("");
            $('#ppn').val("");
            $('#total').val("");

            $('.baris').remove();

            for (i = 0; i< 15; i++) {
                $('#tbody').append(temptable(i));
            }

            //    Memperbaharui LOV Nomor TRN
            // tempTrn = null;
        }

        function temptable(index){
            var tmptbl = `<tr class="d-flex baris">
                                            <td class="buttonInside" style="width: 7%">
                                                <input type="text" class="form-control plu" id="plu" no="{{$i}}">
                                                <button id="btn-no-plu" type="button" class="btn btn-lov ml-3" onclick="getPlu(this)" no="{{$i}}">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control pkm" id="pkm"></td>
                                            <td style="width: 7%"><input disabled type="text" class="form-control avgsales"></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control isictn"></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control stock text-right"></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control poout"></td>                                            
                                            <td style="width: 5%"><input type="text" class="form-control pbout text-right"></td>
                                            <td style="width: 5%"><input type="text" class="form-control mindisp text-right"></td>
                                            <td style="width: 5%"><input type="text" class="form-control minord text-right" ></td>
                                            <td style="width: 5%"><input disabled type="text" class="form-control qtypb text-right"id="{{$i}}" onchange="qty(this.value,this.id,1)"></td>
                                            <td style="width: 5%"><input type="text" class="form-control dimensi text-right"></td>
                                            <td style="width: 8%"><input type="text" class="form-control kubikase"></td>
                                        </tr>`;

            return tmptbl;
        }

    </script>

@endsection
