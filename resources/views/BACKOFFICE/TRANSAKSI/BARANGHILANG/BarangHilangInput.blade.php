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
                                                <button type="button" class="btn p-0" onclick="getNmrTRN()">
                                                    <img src="{{asset('image/icon/help.png')}}" width="30px"></button>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label for="tgl-doc" class="col-sm-2 col-form-label">TANGGAL DOC</label>
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="tgl-doc">
                                                </div>
                                                <label for="model" class="col-sm-4 col-form-label"></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control text-center" id="model" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label for="tipe" class="col-sm-2 col-form-label">TYPE</label>
                                                <select class="form-control col-sm-2 mx-sm-3" id="tipe">
                                                    <option value="0">BARANG BAIK</option>
                                                    <option value="1">BARANG RETUR</option>
                                                </select>
                                                <button class="btn btn-danger btn-sm float-left" id="btn-hapus" onclick="deleteDocument()">
                                                    HAPUS DOKUMEN
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <fieldset class="card border-dark">
                                <legend class="w-auto ml-5">Detail</legend>
                                    <div class="card-body p-0 tableFixedHeader">
                                        <table class="table table-striped table-bordered" id="table-detail">
                                            <thead class="thead-dark">
                                            <tr class="d-flex text-center">
                                                <th style="width: 80px">X</th>
                                                <th style="width: 125px">PLU</th>
                                                <th style="width: 400px">Deskripsi</th>
                                                <th style="width: 125px">Satuan</th>
                                                <th style="width: 70px">TAG</th>
                                                <th style="width: 70px">BKP</th>
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
                                                <tr class="d-flex baris" onclick="putDesPanjang(this)">
                                                    <td style="width: 80px" class="text-center">
                                                        <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow()">X</button>
                                                    </td>
                                                    <td class="buttonInside" style="width: 125px">
                                                        <input type="text" class="form-control plu" id="plu" no="{{$i}}">
                                                        <button id="btn-no-plu" type="button" class="btn btn-lov ml-3" onclick="getPlu(this)" no="{{$i}}">
                                                            <img src="{{ (asset('image/icon/help.png')) }}" width="20px">
                                                        </button>
                                                    </td>
                                                    <td style="width: 400px"><input disabled type="text" class="form-control deskripsi" id="deskripsi"></td>
                                                    <td style="width: 125px"><input disabled type="text" class="form-control satuan"></td>
                                                    <td style="width: 70px"><input disabled type="text" class="form-control tag text-right"></td>
                                                    <td style="width: 70px"><input disabled type="text" class="form-control bkp"></td>
                                                    <td style="width: 80px"><input disabled type="text" class="form-control stock"></td>
                                                    <td style="width: 180px"><input type="text" class="form-control hrgsatuan"></td>
                                                    <td style="width: 80px"><input type="text" class="form-control ctn text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 1)"></td>
                                                    <td style="width: 80px"><input type="text" class="form-control pcs text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 2)"></td>
                                                    <td style="width: 180px"><input disabled type="text" class="form-control gross text-right"></td>
                                                    <td style="width: 400px"><input type="text" class="form-control keterangan text-right"></td>
                                                </tr>
                                            @endfor
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td>
                                                    <button class="btn btn-warning btn-block" id="btn-addRow" onclick="addRow()">
                                                        TAMBAH BARIS BARU
                                                    </button>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form class="form">
                                                <div class="form-group row mb-0">
                                                    <label for="deskripsiPanjang" class="col-sm-1 col-form-label text-right"></label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="deskripsiPanjang" disabled>
                                                    </div>
                                                    <label for="avg-cost" class="col-sm-2 col-form-label text-right">AVG COST</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="avg-cost" disabled>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                            </fieldset>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-10">
                                    <form>
                                        <div class="row text-right">
                                            <div class="col-sm-12">
                                                <div class="form-group row mb-0">
                                                    <label for="total-item" class="col-sm-2 col-form-label text-right">TOTAL ITEM</label>
                                                    <div class="col-sm-2">
                                                        <input disabled type="text" class="form-control" id="total-item">
                                                    </div>
                                                    <label for="totalgross" class="col-sm-5 col-form-label text-right">GROSS</label>
                                                    <div class="col-sm-3">
                                                        <input disabled type="text" class="form-control" id="totalgross">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <label for="ppn" class="col-sm-9 col-form-label text-right">PPN</label>
                                                    <div class="col-sm-3">
                                                        <input  disabled type="text" class="form-control" id="ppn">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <div class="col-sm-4">
                                                        <button class="btn btn-primary pl-2 pr-2 mr-2" id="btn-save" onclick="saveDokumen('new')">
                                                            SAVE DOKUMEN
                                                        </button>
                                                    </div>
                                                    <label for="total" class="col-sm-5 col-form-label text-right">TOTAL</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="total"disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                        <div class="invalid-feedback"> Inputkan minimal 3 karakter</div>
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

        $("#tgl-doc").datepicker({
            "dateFormat" : "dd/mm/yy",
        });

        $("#tgl-doc").val(today)

        // $(document).ready(function () {
        // //    panggil function yang mau di auto eksekusi saati web pertama kali dibuka
        //    alert("test");
        // });

        $(document).on('keypress', '#no-trn', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                let nodoc = $('#no-trn').val();
                chooseDoc(nodoc);
                nmrBaruTrn(nodoc);
            }
        });

        function nmrBaruTrn(nodoc){
            if(nodoc == ''){
                swal({
                    title: 'Buat Nomor Hilang Baru?',
                    icon: 'info',
                    buttons: true,
                }).then(function(confirm){
                    if(confirm){
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/bo/transaksi/brghilang/input/nmrBaruTrn',
                            type: 'post',
                            data: {nodoc: nodoc},
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (result){
                                $('#no-trn').val(result);
                                $('#tgl-doc').val(formatDate('now'));
                                $('#model').val('* TAMBAH *');
                                $('#deskripsiPanjang').val("");
                                $('#total-item').val("");
                                $('#totalgross').val("");
                                $('#ppn').val("");
                                $('#total').val("");
                                $('#modal-loader').modal('hide')
                                $('#btn-hapus').attr('disabled', false);
                                $('#btn-save').attr('disabled', false);
                                $('#btn-addRow').attr('disabled', false);
                            }, error: function () {
                                alert('error');
                                $('#modal-loader').modal('hide')
                            }
                        })
                    }
                })
            } else {
                chooseDoc(nodoc);
            }
        }

        function getNmrTRN() {
            $('#search-modal-1').val('')
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/brghilang/input/lov_trn',
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
                    url: '/BackOffice/public/bo/transaksi/brghilang/input/lov_trn',
                    type: 'post',
                    data: {search:search},
                    success: function (result) {
                        //console.log(result)
                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            let temp = ` <tr class="modalRow" onclick=chooseDoc('`+ result[i].trbo_nodoc+`')>
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
                let search = $('#search-modal-2').val('');
                let index = temp['attributes'][4]['value'];
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bo/transaksi/brghilang/input/lov_plu',
                    type: 'post',
                    data: {search: search},
                    success: function (result) {
                        //console.log(result)
                        $('.modalRow').remove();
                        for (i = 0; i < result.length; i++) {
                            let temp = "<tr onclick=choosePlu('" + result[i].prd_prdcd + "','" + index + "') class='modalRow'><td>" +
                                result[i].prd_deskripsipanjang + "</td> <td>"
                                + result[i].prd_prdcd + "</td></tr>"
                            $('.tbody-modal-2').append(temp);
                        }
                        // $('#modal-help-1').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                });
            }
        })

        function getPlu(temp) {
            $('#search-modal-2').val('')
            let index = temp['attributes'][4]['value']; //value nya string makanya pake petik
            // console.log(index)
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/brghilang/input/lov_plu',
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
                url: '/BackOffice/public/bo/transaksi/brghilang/input/showTrn',
                type: 'post',
                data: {nodoc: nodoc},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    for(i=0; i<result.length; i++){
                        tempgross = parseFloat(tempgross) + parseFloat(result[i].trbo_gross)
                    }
                    $('#totalgross').val(convertToRupiah(tempgross));

                    if(result[0].nota == 'Belum Cetak Nota'){
                        // console.log(result)
                        var html = "";
                        var i;
                        $('.baris').remove();

                        for(i=0; i<result.length; i++){
                            qtyctn = result[i].trbo_qty / result[i].prd_frac;
                            qtypcs = result[i].trbo_qty % result[i].prd_frac;
                            ppn = result[i].trbo_ppnrph * 0;

                            html = `<tr class="d-flex baris" onclick="putDesPanjang(this)">
                                                <td style="width: 80px" class="text-center">
                                                    <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow()">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 125px">
                                                    <input type="text" class="form-control plu" value="`+ result[i].trbo_prdcd +`">
                                                </td>
                                                <td style="width: 400px"><input disabled type="text" class="form-control deskripsi" value="`+ nvl(result[i].prd_deskripsipendek, '') +`"></td>
                                                <td style="width: 125px"><input disabled type="text" class="form-control satuan" value="`+ nvl(result[i].prd_unit, '') +` / `+ nvl(result[i].prd_frac, '') +`"></td>
                                                <td style="width: 70px"><input disabled type="text" class="form-control tag" value="`+ nvl(result[i].prd_kodetag, '') +`"></td>
                                                <td style="width: 70px"><input disabled type="text" class="form-control bkp" value="`+ nvl(result[i].prd_flagbkp1, '') +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control stock text-right" value="`+ nvl(result[i].trbo_stokqty, '') +`"></td>
                                                <td style="width: 180px"><input type="text" class="form-control hrgsatuan text-right" value="`+ nvl(convertToRupiah(result[i].trbo_hrgsatuan), '') +`"></td>
                                                <td style="width: 80px"><input type="text" class="form-control ctn text-right" value="` + Math.floor(qtyctn) +`" id="`+ i +`" onchange="calculateQty(this.value,this.id,1)"></td>
                                                <td style="width: 80px"><input type="text" class="form-control pcs text-right" value="` + qtypcs +`" id="`+ i +`" onchange="calculateQty(this.value,this.id,2)"></td>
                                                <td style="width: 180px"><input disabled type="text" class="form-control gross text-right" value="`+ nvl(convertToRupiah(result[i].trbo_gross), '') +`"></td>
                                                <td style="width: 400px"><input type="text" class="form-control keterangan" value="`+ nvl(result[i].trbo_keterangan, '') +`"></td>
                                            </tr>`;

                            $('#tbody').append(html);
                            $('#no-trn').val(result[i].trbo_nodoc);
                            $('#tgl-doc').val(formatDate(result[i].trbo_tgldoc));
                            $('#model').val('* KOREKSI *');
                            $('#deskripsiPanjang').val(result[i].prd_deskripsipanjang);
                            $('#avg-cost').val(convertToRupiah(result[i].trbo_averagecost));
                            $('#total-item').val(result.length);
                            $('#ppn').val(convertToRupiah(ppn));
                            $('#btn-save').attr('disabled', false);
                            $('#btn-hapus').attr('disabled', false);
                            $('#btn-addRow').attr('disabled', false);
                            total = tempgross + ppn;
                            $('#total').val(convertToRupiah(total));
                        }
                    } else {
                        var html = "";
                        var i;
                        $('.baris').remove();

                        for (i = 0; i < result.length; i++) {
                            qtyctn = result[i].trbo_qty / result[i].prd_frac;
                            qtypcs = result[i].trbo_qty % result[i].prd_frac;
                            ppn = result[i].trbo_ppnrph * 0;

                            html = `<tr class="d-flex baris" onclick="putDesPanjang(this)">
                                                <td style="width: 80px" class="text-center">
                                                    <button disabled class="btn btn-danger btn-delete" style="width: 40px" onclick="deleteRow()">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 125px">
                                                    <input disabled type="text" class="form-control plu" value="` + result[i].trbo_prdcd + `">
                                                </td>
                                                <td style="width: 400px"><input disabled type="text" class="form-control deskripsi" value="` + nvl(result[i].prd_deskripsipendek, '') + `"></td>
                                                <td style="width: 125px"><input disabled type="text" class="form-control satuan" value="` + nvl(result[i].prd_unit,'') + ` / ` + nvl(result[i].prd_frac, '') + `"></td>
                                                <td style="width: 70px"><input disabled type="text" class="form-control tag" value="` + nvl(result[i].prd_kodetag, '') + `"></td>
                                                <td style="width: 70px"><input disabled type="text" class="form-control bkp" value="` + nvl(result[i].prd_flagbkp1, '') + `"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control stock text-right" value="` + nvl(result[i].trbo_qty, '') + `"></td>
                                                <td style="width: 180px"><input disabled type="text" class="form-control hrgsatuan text-right" value="` + nvl(convertToRupiah(result[i].trbo_hrgsatuan), '') + `"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control ctn text-right" value="` + Math.floor(qtyctn) + `" id="` + i + `" onchange="calculateQty(this.value,this.id,1)"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control pcs text-right" value="` + qtypcs + `" id="` + i + `" onchange="calculateQty(this.value,this.id,2)"></td>
                                                <td style="width: 180px"><input disabled type="text" class="form-control gross text-right" value="` + nvl(convertToRupiah(result[i].trbo_gross), '') + `"></td>
                                                <td style="width: 400px"><input disabled type="text" class="form-control keterangan" value="` + nvl(result[i].trbo_keterangan, '') + `"></td>
                                            </tr>`;

                            $('#tbody').append(html);
                            $('#no-trn').val(result[i].trbo_nodoc);
                            $('#tgl-doc').val(formatDate(result[i].trbo_tgldoc));
                            $('#model').val('* NOTA SUDAH DICETAK *');
                            $('#deskripsiPanjang').val(result[i].prd_deskripsipanjang);
                            $('#avg-cost').val(convertToRupiah(result[i].trbo_averagecost));
                            $('#total-item').val(result.length);
                            $('#ppn').val(ppn);
                            $('#btn-save').attr('disabled', true);
                            $('#btn-hapus').attr('disabled', true);
                            $('#btn-addRow').attr('disabled', true);
                            total = tempgross + ppn;
                            $('#total').val(convertToRupiah(total));
                        }
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
                url: '/BackOffice/public/bo/transaksi/brghilang/input/showPlu',
                type: 'post',
                data: {noplu:noplu}, //noplu sebelah kiri buat panggil noplu di controller, sebelah kanan yg dari parameter
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (result) { //result bukan dr controller, cuma penamaan
                    $('#modal-loader').modal('hide');

                    if(result.noplu == 0){
                        swal('', result.message, 'warning')
                        $('#deskripsiPanjang').val('')

                        data = result.data[0];

                        $('.plu')[index].value = data.st_prdcd;
                        $('.deskripsi')[index].value = data.prd_deskripsipendek;
                        $('.satuan')[index].value = data.prd_unit + ' / ' + data.prd_frac;
                        $('.tag')[index].value = data.prd_kodetag;
                        $('.bkp')[index].value = data.prd_flagbkp1;
                        $('.ctn')[index].value = '0';
                        $('.pcs')[index].value = '0';
                        $('.hrgsatuan')[index].value = convertToRupiah(data.hrgsatuan);
                        $('.stock')[index].value = data.st_saldoakhir;
                        $('#avg-cost')[index].value = convertToRupiah(data.hrgsatuan);
                        $('#deskripsiPanjang').val(data.prd_deskripsipanjang);

                        // tempStock.push({'plu' : data.st_prdcd, 'stock' : data.st_saldoakhir, 'deskripsipanjang' : data.prd_deskripsipanjang})
                        for (i = 0; i < $('.plu').length; i++) {
                            if ($('.plu')[i].value != '') {
                                temp = temp + 1;
                            }
                        }
                        $('#total-item').val(temp)
                    } else {
                        data = result.data[0]; //array sebagai penanda data mana yang dipilih, pake result.data krn controller nya manggil byk

                        $('.plu')[index].value = data.st_prdcd;
                        $('.deskripsi')[index].value = data.prd_deskripsipendek;
                        $('.satuan')[index].value = data.prd_unit + ' / ' + data.prd_frac;
                        $('.tag')[index].value = data.prd_kodetag;
                        $('.bkp')[index].value = data.prd_flagbkp1;
                        $('.ctn')[index].value = '0';
                        $('.pcs')[index].value = '0';
                        $('.hrgsatuan')[index].value = convertToRupiah(data.hrgsatuan);
                        $('.stock')[index].value = data.st_saldoakhir;
                        $('#avg-cost')[index].value = convertToRupiah(data.hrgsatuan);
                        $('#deskripsiPanjang').val(data.prd_deskripsipanjang);

                        // tempStock.push({'plu' : data.st_prdcd, 'stock' : data.st_saldoakhir, 'deskripsipanjang' : data.prd_deskripsipanjang})
                        for (i = 0; i < $('.plu').length; i++) {
                            if ($('.plu')[i].value != '') {
                                temp = temp + 1;
                            }
                        }
                        $('#total-item').val(temp)
                    }

                }, error: function (error) {
                    console.log(error);
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

        function saveDokumen(status) {
            let tempTR  = $('.plu');
            let tempDate= $('#tgl-doc').val();
            let noDoc   = $('#no-trn').val();
            // let type    = $('#pilihan').val();
            let date    = tempDate.substr(3,2) + '/'+ tempDate.substr(0,2)+ '/'+ tempDate.substr(6,4);
            let data   = [{'plu' : '', 'qty' : '', 'harga' : '', 'total' : '', 'keterangan' : ''}];

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
                var total   = 0;
                let temp    = $('.satuan')[i].value;
                let frac    = temp.substr(temp.indexOf('/')+1);

                if ( tempTR[i].value){
                    qty  = parseInt( $('.ctn')[i].value * frac) + parseInt($('.pcs')[i].value);

                    if (qty < 1){
                        focusToRow(i);
                        return false;
                    }
                    data.push({'plu': $('.plu')[i].value, 'qty' : qty, 'harga' : unconvertToRupiah($('.harga')[i].value), 'total' : unconvertToRupiah($('.total')[i].value), 'keterangan' : $('.keterangan')[i].value})
                }
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public//bo/transaksi/brghilang/input/saveDoc',
                type: 'post',
                data: {
                    data:data,
                    date:date,
                    type:type,
                    noDoc:noDoc
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    console.log(result.kode)
                    if(result.kode == '1'){
                        swal('Dokumen Berhasil disimpan','','success')
                    } else {
                        swal('ERROR', "Something's Error", 'error')
                    }
                    $('#modal-loader').modal('hide')
                    // $('#pilihan').val('M');
                    $('#btn-save').attr("disabled", true)
                    clearField();
                }, error: function () {
                    alert('error');
                }
            })
        }

        {{--$('#btn-hapus').on('click', function () {--}}
            {{--let nodoc = $('#no-trn').val();--}}
            {{--$.ajax({--}}
                {{--url: '/BackOffice/public/bo/transaksi/brghilang/input/deleteDoc',--}}
                {{--type: 'GET',--}}
                {{--data: {"_token": "{{ csrf_token() }}", nodoc: nodoc},--}}
                {{--beforeSend: function () {--}}
                    {{--$('#modal-loader').modal({backdrop: 'static', keyboard: false});--}}
                {{--},--}}
                {{--success: function (result) {--}}
                    {{--swal({--}}
                        {{--title: 'Nomor Dokumen Dihapus?',--}}
                        {{--icon: 'warning'--}}
                    {{--}).then((confirm) => {--}}
                        {{--$('#no-trn').val('');--}}
                        {{--$('.baris').remove();--}}
                        {{--clearField();--}}
                    {{--});--}}
                {{--},--}}
                {{--complete: function () {--}}
                    {{--$('#modal-loader').modal('hide');--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}

        {{--$('#btn-addRow').on('click', function(e) {--}}
            {{--var temp = $('#tbody').find('tr').length;--}}
            {{--let index = parseInt(temp, 10)--}}
            {{--var tempTable = `<tr class="d-flex baris" onclick="putDesPanjang(this)">--}}
                                                {{--<td style="width: 80px" class="text-center">--}}
                                                    {{--<button disabled class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow()">X</button>--}}
                                                {{--</td>--}}
                                                {{--<td class="buttonInside" style="width: 125px">--}}
                                                    {{--<input type="text" class="form-control plu" value=""  no="`+ index +`" id="`+ index +`" onchange="searchPlu2(this.value, this.id)">--}}
                                                     {{--<button id="btn-no-doc" type="button" class="btn btn-lov ml-3" onclick="getPlu()" no="`+ index +`">--}}
                                                        {{--<img src="../../../../../public/image/icon/help.png" width="25px">--}}
                                                    {{--</button>--}}
                                                {{--</td>--}}
                                                {{--<td style="width: 400px"><input disabled type="text" class="form-control deskripsi"></td>--}}
                                                {{--<td style="width: 125px"><input disabled type="text" class="form-control satuan"></td>--}}
                                                {{--<td style="width: 70px"><input disabled type="text" class="form-control tag"></td>--}}
                                                {{--<td style="width: 70px"><input disabled type="text" class="form-control bkp"></td>--}}
                                                {{--<td style="width: 80px"><input disabled type="text" class="form-control stock text-right"></td>--}}
                                                {{--<td style="width: 180px"><input disabled type="text" class="form-control hrgsatuan text-right"></td>--}}
                                                {{--<td style="width: 80px"><input disabled type="text" class="form-control ctn text-right" id="`+ index +`" onchange="calculateQty(this.value,this.id,1)"></td>--}}
                                                {{--<td style="width: 80px"><input disabled type="text" class="form-control pcs text-right" id="` + i + `" onchange="calculateQty(this.value,this.id,2)"></td>--}}
                                                {{--<td style="width: 180px"><input disabled type="text" class="form-control gross text-right"></td>--}}
                                                {{--<td style="width: 400px"><input disabled type="text" class="form-control keterangan"></td>--}}
                                            {{--</tr>`;--}}
            {{--$('#tbody').append(tempTable(index));--}}
        {{--});--}}

        function deleteRow(e) {
            let temp        = 0;
            let tempGross  = 0;

            $(e).parents("tr").remove();
            $('#deskripsiPanjang').val('')

            for(i = 0; i < $('.plu').length; i++){
                if ($('.plu')[i].value != ''){
                    temp = temp + 1;
                }
                if($('.total')[i].value != ''){
                    tempGross = parseFloat(tempGross) + parseFloat(unconvertToRupiah($('.gross')[i].value));
                }
            }
            $('#total-item').val(temp);
            $('#totalgross').val(convertToRupiah(tempGross));
        }

        {{--function clearField(){--}}
            {{--$('#no-trn').val("");--}}
            {{--$('#tgl-doc').val("");--}}
            {{--$('#model').val("");--}}
            {{--$('#deskripsiPanjang').val("");--}}
            {{--$('#avg-cost').val("");--}}
            {{--$('#total-item').val("");--}}
            {{--$('#totalgross').val("");--}}
            {{--$('#ppn').val("");--}}
            {{--$('#total').val("");--}}

            {{--$('.baris').remove();--}}

            {{--for (i = 0; i< 15; i++) {--}}
               {{--var tempTable = `<tr class="d-flex baris" onclick="putDesPanjang(this)">--}}
                                                {{--<td style="width: 80px" class="text-center">--}}
                                                    {{--<button disabled class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>--}}
                                                {{--</td>--}}
                                                {{--<td class="buttonInside" style="width: 125px">--}}
                                                    {{--<input disabled type="text" class="form-control plu" value="\` + result[i].trbo_prdcd + \`">--}}
                                                     {{--<button id="btn-no-doc" type="button" class="btn btn-lov ml-3 mt-1" onclick="getPlu(this,'')" no="` + i + `">--}}
                                                        {{--<img src="../../../../../public/image/icon/help.png" width="25px">--}}
                                                    {{--</button>--}}
                                                {{--</td>--}}
                                                {{--<td style="width: 400px"><input disabled type="text" class="form-control deskripsi"></td>--}}
                                                {{--<td style="width: 125px"><input disabled type="text" class="form-control satuan"></td>--}}
                                                {{--<td style="width: 70px"><input disabled type="text" class="form-control tag"></td>--}}
                                                {{--<td style="width: 70px"><input disabled type="text" class="form-control bkp"></td>--}}
                                                {{--<td style="width: 80px"><input disabled type="text" class="form-control stock text-right"></td>--}}
                                                {{--<td style="width: 180px"><input disabled type="text" class="form-control hrgsatuan text-right"></td>--}}
                                                {{--<td style="width: 80px"><input disabled type="text" class="form-control ctn text-right" id="`+ index +`" onchange="calculateQty(this.value,this.id,1)"></td>--}}
                                                {{--<td style="width: 80px"><input disabled type="text" class="form-control pcs text-right" id="` + i + `" onchange="calculateQty(this.value,this.id,2)"></td>--}}
                                                {{--<td style="width: 180px"><input disabled type="text" class="form-control gross text-right"></td>--}}
                                                {{--<td style="width: 400px"><input disabled type="text" class="form-control keterangan"></td>--}}
                                            {{--</tr>`;--}}
                {{--$('#tbody').append(tempTable(i));--}}
            {{--}--}}

            {{--//    Memperbaharui LOV Nomor TRN--}}
            {{--// tempTrn = null;--}}
        {{--}--}}

    </script>

@endsection
