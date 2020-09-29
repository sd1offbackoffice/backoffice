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
                                        <button id="printdoc" class="col-sm-2 btn btn-success btn-block" onclick="printDocument()">PRINT</button>
                                        <label for="i_tgldokumen" class="col-sm-4 col-form-label">Tgl Dokumen</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_tgldokumen" placeholder="V_TGLSORTIR">
                                        </div>
                                        <label for="i_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_keterangan" placeholder="V_KET">
                                        </div>
                                        <label for="i_PLU" class="col-sm-4 col-form-label">PLU Di</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_PLU" placeholder="V_GUI">
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
                                        <th style="width: 80px">X</th>
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
                                    @for($i = 0; $i< 15; $i++)
                                        <tr class="d-flex baris" onclick="putDesPanjang(this)">
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
                                            <td style="width: 80px"><input type="text" class="form-control ctn text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 1)"></td>
                                            <td style="width: 80px"><input type="text" class="form-control pcs text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 2)"></td>
                                            <td style="width: 80px"><input disabled type="text" class="form-control pt text-right"></td>
                                            <td style="width: 80px"><input disabled type="text" class="form-control rttg text-right"></td>
                                            <td style="width: 150px"><input disabled type="text" class="form-control total text-right"></td>
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
                                        <input type="text" class="form-control col-sm-6 text-right" id="totalItem" value="0" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <button id="addNewRow" class="col-sm-2 offset-sm-10 btn btn-warning btn-block"  onclick="addNewRow()" >Tambah Baris Baru</button>
                                    </div>
                                    <span class="text-capitalize font-weight-bold" style="float: right">nomor sortir barang yang sudah dibuat harus segera dibuatkan perubahan</span>
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
    </style>
    <script>
        let tempSrt;

        $("#i_tgldokumen").datepicker({
            "dateFormat" : "dd/mm/yy",
        });

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
            let tempNilai = 0;
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
                    if(result.length === 0){
                        $('.baris').remove();
                        for (i = 0; i< 11; i++) {
                            $('#tbody').append(tempTable());
                        }
                    } else {
                        $('#nmrtrn').val(result[0].rsk_nodoc);
                        $('#tgltrn').val(formatDate(result[0].rsk_tgldoc));
                        $('#totalItem').val(result.length);
                        for (i = 0; i< result.length; i++) {
                            tempNilai = parseFloat(tempNilai) + parseFloat(result[i].rsk_nilai)
                        }
                        $('#totalHarga').val(convertToRupiah(tempNilai));

                        if (result[0].nota === 'Sudah Cetak Nota') {
                            $('#keterangan').val(result[0].nota);
                            $('#saveData').attr( 'disabled', true );
                            $('#addNewRow').attr( 'disabled', true );
                            $('#deleteDoc').attr( 'disabled', true );

                            $('.baris').remove();
                            for (i = 0; i< result.length; i++) {
                                let temp =  ` <tr class="d-flex baris">
                                                <td style="width: 80px" class="text-center">
                                                    <button disabled class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 150px">
                                                    <input disabled type="text" class="form-control plu" value="`+ result[i].rsk_prdcd +`">
                                                </td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi" value="`+ result[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control ctn text-right" value="` + result[i].qty_ctn +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control pcs text-right" value="` + result[i].qty_pcs +`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right" value="`+ convertToRupiah(result[i].rsk_hrgsatuan )+`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right" value="`+ convertToRupiah(result[i].rsk_nilai) +`"></td>
                                                <td style="width: 350px"><input disabled type="text" class="form-control keterangan" value="`+ result[i].rsk_keterangan +`">
                                                </td>
                                            </tr>`

                                $('#tbody').append(temp);
                            }
                        } else {
                            $('#keterangan').val('*KOREKSI*');
                            $('#saveData').attr( 'disabled', false );
                            $('#addNewRow').attr( 'disabled', false);
                            $('#deleteDoc').attr( 'disabled', false );

                            $('.baris').remove();
                            for (i = 0; i< result.length; i++) {
                                let temp =  ` <tr class="d-flex baris" onclick="putDesPanjang(this)">
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
                                                <td style="width: 80px"><input type="text" class="form-control ctn text-right" value="` + result[i].qty_ctn +`" id="`+ i +`" onchange="calculateQty(this.value,this.id,1)"></td>
                                                <td style="width: 80px"><input type="text" class="form-control pcs text-right" value="` + result[i].qty_pcs +`" id="`+ i +`" onchange="calculateQty(this.value,this.id,2)"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right" value="`+ convertToRupiah(result[i].rsk_hrgsatuan )+`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right" value="`+ convertToRupiah(result[i].rsk_nilai) +`"></td>
                                                <td style="width: 350px"><input type="text" class="form-control keterangan" value="`+ result[i].rsk_keterangan +`">
                                                </td>
                                            </tr>`

                                $('#tbody').append(temp);
                            }
                        }
                    }
                    $('#modal-loader').modal('hide')
                }, error: function () {
                    alert('error');
                    $('#modal-loader').modal('hide')
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

        function tempTable(index) {
            var temptbl =  ` <tr class="d-flex baris" onclick="putDesPanjang(this)">
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
                                                <td style="width: 80px"><input type="text" class="form-control ctn text-right" value="" id="`+ index +`" onchange="calculateQty(this.value, this.id, 1)"></td>
                                                <td style="width: 80px"><input type="text" class="form-control pcs text-right" value="" id="`+ index +`" onchange="calculateQty(this.value, this.id, 2)"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control pt text-right" value=""></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control rttg text-right" value=""></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right" value=""></td>
                                                </td>
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
    </script>
@endsection
