@extends('navbar')
@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    {{--<legend class="w-auto ml-5">Input</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <div class="row">
                            <div class="col-sm-10">
                                <form>
                                    <div class="row text-right">
                                        <div class="col-sm-12">
                                            <div class="form-group row mb-0">
                                                <label for="no-trn" class="col-sm-2 col-form-label">NOMOR TRN</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="no-trn">
                                                </div>
                                                <button type="button" class="btn p-0" data-toggle="modal" data-target="#modal-notrn">
                                                    <img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label for="tgl-doc" class="col-sm-2 col-form-label">TANGGAL DOC</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="tgl-doc">
                                                </div>
                                                <label for="model" class="col-sm-4 col-form-label"></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="model" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label for="tipe" class="col-sm-2 col-form-label">TYPE</label>
                                                <select class="form-control col-sm-2 mx-sm-3" id="tipe">
                                                    <option value="0">BARANG BAIK</option>
                                                    <option value="1">BARANG RETUR</option>
                                                </select>
                                                <button class="btn btn-danger btn-sm float-left" id="btn-hapus" onclick="hapusDokumen()">
                                                    HAPUS DOKUMEN
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Detail</legend>
                    <div class="card-body cardForm">
                        <div class="card-body p-0 tableFixedHeader">
                            <table class="table table-striped table-bordered" id="table-detail">
                                <thead class="thead-dark">
                                <tr class="d-flex text-center">
                                    <th style="width: 80px">X</th>
                                    <th style="width: 150px">PLU</th>
                                    <th style="width: 400px">Deskripsi</th>
                                    <th style="width: 150px">Satuan</th>
                                    <th style="width: 80px">Tag</th>
                                    <th style="width: 80px">BKP</th>
                                    <th style="width: 80px">Stock</th>
                                    <th style="width: 180px">Hrg. Satuan</th>
                                    <th style="width: 80px">CTN</th>
                                    <th style="width: 80px">PCS</th>
                                    <th style="width: 180px">Gross</th>
                                    <th style="width: 400px">Keterangan</th>
                                </tr>
                                </thead>
                                <tbody id="tbody">
                                @for($i = 0; $i< 15; $i++)
                                    <tr class="d-flex row-detail" onclick="putDesPanjang(this)">
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
                                        <td style="width: 150px"><input disabled type="text" class="form-control satuan"></td>
                                        <td style="width: 80px"><input disabled type="text" class="form-control tag text-right"></td>
                                        <td style="width: 80px"><input disabled type="text" class="form-control bkp"></td>
                                        <td style="width: 80px"><input disabled type="text" class="form-control stock"></td>
                                        <td style="width: 180px"><input type="text" class="form-control hrgSatuan"></td>
                                        <td style="width: 80px"><input type="text" class="form-control ctn text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 1)"></td>
                                        <td style="width: 80px"><input type="text" class="form-control pcs text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 2)"></td>
                                        <td style="width: 180px"><input disabled type="text" class="form-control gross text-right"></td>
                                        <td style="width: 400px"><input type="text" class="form-control keterangan text-right"></td>
                                        {{--<td style="width: 150px"><input disabled type="text" class="form-control total text-right"></td>--}}
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mb-0">
                                        <label for="deskripsi" class="col-sm-1 col-form-label text-right"></label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="deskripsi" disabled>
                                        </div>
                                        <label for="avg-cost" class="col-sm-2 col-form-label text-right">AVG COST</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="avg-cost" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label for="total-item" class="col-sm-2 col-form-label text-right">TOTAL ITEM</label>
                                        <div class="col-sm-2">
                                        <input type="text" class="form-control" id="total-item">
                                        </div>
                                        <label for="gross" class="col-sm-5 col-form-label text-right">GROSS</label>
                                        <div class="col-sm-3">
                                        <input type="text" class="form-control" id="gross">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        {{--<label for="total-item" class="col-sm-2 col-form-label text-right">TOTAL ITEM</label>--}}
                                        {{--<div class="col-sm-2">--}}
                                            {{--<input type="text" class="form-control" id="total-item">--}}
                                        {{--</div>--}}
                                        <label for="ppn" class="col-sm-9 col-form-label text-right">PPN</label>
                                        <div class="col-sm-3">
                                        <input type="text" class="form-control" id="ppn">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                    <div class="col-sm-4 text-center">
                                        <button class="btn btn-primary pl-2 pr-2 mr-2" id="btn-save" onclick="saveDokumen()">
                                        SAVE DOKUMEN
                                        </button>
                                    </div>
                                    <label for="total" class="col-sm-5 col-form-label text-right">TOTAL</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="total"disabled>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-notrn" tabindex="-1" role="dialog" aria-labelledby="modal-notrn" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="modal-search" class="form-control modal-search" type="text" placeholder="..." aria-label="Search" search="notrn">
                        <div class="invalid-feedback"> Inputkan minimal 3 karakter</div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm" id="modal-table">
                                        <thead class="header_lov">
                                        <tr class="font">
                                            <td>NO. LIST</td>
                                            <td>TIPE</td>
                                            <td>NO. NOTA</td>
                                        </tr>
                                        </thead>
                                        <tbody class="tbody-modal">
                                        @foreach($lovTrn as $t)
                                            <tr onclick="helpTrn('{{ $t->trbo_nodoc }}')" class="row_lov">
                                                <td>{{ $t->trbo_nodoc }}</td>
                                                <td>{{ $t->trbo_tipe }}</td>
                                                <td>{{ $t->nota }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{--<p class="text-hide" id="idModal"></p>--}}
                                    {{--<p class="text-hide" id="idRow"></p>--}}
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
        .header_lov{
            background: #0079C2;
            position: sticky; top: 0;
        }

        .font{
            color: white;
        }

        tbody td {
            padding: 3px !important;
        }
    </style>


    <script>
        let tempTrn;
        var tempStock = [{'plu' : '0000000', 'stock' : '0', 'deskripsipanjang' : ''}];

        $(document).on('keypress', '#no-trn', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let nodoc = $('#no-trn').val();
                helpTrn(nodoc);
            }
        });

        $('#tgl-doc').datepicker({
            "dateFormat" : "dd/mm/yy",
        });

        function helpTrn(nodoc) {
            $('#modal-notrn').modal('hide');
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public//bo/transaksi/brghilang/input/showDataTrn',
                type: 'post',
                data: {nodoc: nodoc},
                beforeSend: function () {
                    // $('#modal-loader').modal('show');
                },
                success: function (result) {
                    // $('#modal-loader').modal('hide');
                    //console.log(result);
                    $('#table-detail .row-detail').remove();
                    if (result) {
                        console.log(result.data[0]);
                        var html = "";
                        var i;
                        for (i = 0; i < result.data.length; i++) {
                            // var pkm = parseInt(result.data[i].pkm_pkmt) + parseInt(result.data[i].ngdl);
                            // var hpp = result.data[i].prd_lastcost / result.data[i].nfrac;
                            // html = '<tr class="row-detail d-flex" onclick="putDesPanjang(this)">' +
                            //     '<td class="col-1">' + result.data[i].mstd_prdcd + '</td>' +
                            //     '<td class="col-3">' + result.data[i].prd_deskripsipendek + '</td>' +
                            //     '<td class="col-1 pl-0 pr-0 text-right">' + convertToRupiah2(result.data[i].st_saldoakhir) + '</td>' +
                            //     '<td class="col-2 text-right">' + convertToRupiah2(result.data[i].st_sales) + '</td>' +
                            //     '<td class="col-2 text-right">' + convertToRupiah2(pkm) + '</td>' +
                            //     '<td class="col-2 text-right">' + convertToRupiah(hpp) + '</td>' +
                            //     '<td class="col-1 text-right">' + result.data[i].prd_kodetag + '</td>' +
                            //     '</tr>'
                            ctn = result.data[i].trbo_qty / result[i].prd_frac;
                            pcs = result.data[i].trbo_qty % result.data[i].prd_frac;
                            // ttl = result[i].st_saldoakhir * result[i].hrgsatuan / result[i].prd_frac;
                            // totalHrg = parseFloat(ttlharga) + parseFloat(ttl);

                            html =  ` <tr class="d-flex row-detail" onclick="putDesPanjang(this)">
                                                <td style="width: 80px" class="text-center">
                                                    <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 150px">
                                                    <input disabled type="text" class="form-control plu" value="`+ result.data[i].trbo_prdcd +`">
                                                </td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi" value="`+ result.data[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                                <td style="width: 80px"><input disabled type="text"  class="form-control tag text-right" value="`+ result.data[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 80px"><input disabled type="text"  class="form-control bkp" value="`+ result.data[i].prd_flagbkp1 +`"></td>
                                                <td style="width: 80px"><input disabled type="text"  class="form-control stock" value="`+ result.data[i].trbo_stokqty +`"></td>
                                                <td style="width: 180px"><input disabled type="text"  class="form-control hrgSatuan" value="`+ result.data[i].trbo_hrgsatuan +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control ctn text-right" value="`+ parseInt(ctn) +`" id="`+ i +`" onchange="calculateQty(this.value,this.id,1)"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control pcs text-right" value="`+ pcs +`" id="`+ i +`" onchange="calculateQty(this.value,this.id,2)"></td>
                                                <td style="width: 180px"><input disabled type="text"  class="form-control gross" value="`+ result.data[i].trbo_gross +`"></td>
                                                // <td style="width: 150px"><input disabled type="text" class="form-control harga text-right" value="`+ convertToRupiah(result[i].hrgsatuan )+`"></td>
                                                // <td style="width: 150px"><input disabled type="text" class="form-control total text-right" value="`+ convertToRupiah(ttl) +`"></td>
                                                <td style="width: 400px"><input disabled type="text" class="form-control keterangan" value="Barang Rusak">
                                                </td>
                                            </tr>`

                            // $('#gross').val(result.data[i].trbo_gross);
                            $('#no-doc').val(result.data[i].trbo_nodoc);
                            $('#tgl-doc').val(result.data[i].trbo_tgldoc);
                            $('#total-item').val(result.count);
                            $('#tbody').append(html);
                        }
                    }
                }, error: function () {
                    alert('error');
                }
            })
        }

        function putDesPanjang(e) {
            let plu = e['cells'][1]['childNodes'][1].value

            if (plu){
                for (var i=0; i < tempStock.length; i++) {
                    if (tempStock[i].plu === plu) {
                        $('#deskripsi').val(tempStock[i].deskripsipanjang)
                    }
                }
            } else {
                $('#deskripsi').val('')
            }
        }

        // function showDataTrn(val) {
        //     // $('#searchModal').val('')
        //     if(tempTrn == null){
        //         ajaxSetup();
        //         $.ajax({
        //             url: '/BackOffice/public/bo/transaksi/brghilang/input/showDataTrn',
        //             type: 'post',
        //             data: {
        //                 val:val
        //             },
        //             success: function (result) {
        //                 // $('#modalThName1').text('NO.DOC');
        //                 // $('#modalThName2').text('TGL.DOC');
        //                 // $('#modalThName3').text('NOTA');
        //                 // $('#modalThName3').show();
        //
        //                 tempTrn = result;
        //
        //                 $('.modalRow').remove();
        //                 for (i = 0; i< result.length; i++){
        //                     $('#tbody-modal').append("<tr onclick=lovTrn('"+ result[i].trbo_nodoc+"') class='modalRow'><td>"+
        //                         result[i].trbo_nodoc +"</td> <td>"+
        //                         formatDate(result[i].trbo_tgldoc) +"</td> <td>"+
        //                         result[i].nota +"</td></tr>")
        //                 }
        //
        //                 $('#idModal').val('TRN')
        //                 $('#modal-notrn').modal('show');
        //             }, error: function () {
        //                 alert('error');
        //             }
        //         })
        //     } else {
        //         // $('#modalThName1').text('NO.DOC');
        //         // $('#modalThName2').text('TGL.DOC');
        //         // $('#modalThName3').text('NOTA');
        //         // $('#modalThName3').show();
        //
        //         $('.modalRow').remove();
        //         for (i = 0; i< tempTrn.length; i++){
        //             $('#tbody-modal').append("<tr onclick=lovTrn('"+ tempTrn[i].trbo_nodoc+"') class='modalRow'><td>"+
        //                 tempTrn[i].trbo_nodoc +"</td> <td>"+
        //                 formatDate(tempTrn[i].trbo_tgldoc) +"</td> <td>"+
        //                 tempTrn[i].nota +"</td></tr>")
        //         }
        //
        //         $('#idModal').val('TRN')
        //         $('#modal-notrn').modal('show');
        //     }
        // }




    </script>


@endsection