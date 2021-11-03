@extends('navbar')
@section('title','PEMUSNAHAN | BARANG RUSAK')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-7">
                <card class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-2 col-form-label text-md-right">Nomor TRN</label>

                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="nmrtrn" class="form-control">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" data-target="#modalHelpDocument">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-2 col-form-label text-md-right">Tanggal</label>
                                        <input type="text" id="tgltrn" class="form-control col-sm-2 mx-sm-3">
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-2 col-form-label text-md-right">Pilihan</label>
                                        <select class="form-control col-sm-3 mx-sm-3" id="pilihan">
                                            <option value="M" selected>Manual</option>
                                            <option value="A" >Semua Barang Rusak di Lpp</option>
                                        </select>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <input type="text" id="keterangan" class="form-control col-sm-3 text-right" style="margin-left: 74%"  disabled>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12">
                                <div class="tableFixedHeader" style="border-bottom: 1px solid black">
                                    <table class="table table-striped table-bordered" id="table2">
                                        <thead class="theadDataTables">
                                        <tr class="d-flex text-center">
                                            <th style="width: 80px">X</th>
                                            <th style="width: 150px">PLU</th>
                                            <th style="width: 400px">Deskripsi</th>
                                            <th style="width: 130px">Satuan</th>
                                            <th style="width: 80px">CTN</th>
                                            <th style="width: 80px">PCS</th>
                                            <th style="width: 150px">Hrg. Satuan</th>
                                            <th style="width: 150px">Total</th>
                                            <th style="width: 350px">Keterangan</th>
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
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan"></td>
                                                <td style="width: 80px"><input type="text" class="form-control ctn text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 1)"></td>
                                                <td style="width: 80px"><input type="text" class="form-control pcs text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 2)"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right"></td>
                                                <td style="width: 350px"><input type="text" class="form-control keterangan"></td>
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-2">
                                    <div class="row">
                                        <div class="col-sm-5 offset-sm-5">
                                            <input type="text" class="form-control" id="deskripsiPanjang" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <span style=""><button id="addNewRow" class="btn btn-primary  btn-block" onclick="addNewRow()" >Tambah Baris Baru</button></span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-5 offset-sm-5">
                                            <label class="col-form-label col-sm-4 offset-sm-5 text-right">Total Item</label>
                                            <input type="text" class="form-control col-sm-2 text-right" id="totalItem" value="0" style="float: right" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <span style=""><button id="saveData" class="btn btn-primary btn-block" onclick="saveData('new')" disabled>Simpan Dokumen</button></span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-5 offset-sm-5">
                                            <label class="col-form-label col-sm-4 offset-sm-5 text-right">Total Harga</label>
                                            <input type="text" class="form-control col-sm-3 text-right" id="totalHarga" value="0" style="float: right" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <span style=""><button id="deleteDoc" class="btn btn-danger btn-block" onclick="deleteDocument()" disabled>Hapus Dokumen</button></span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-5 offset-sm-5">
                                        </div>
                                        <div class="col-sm-2">
                                            <span style=""><button id="printdoc" class="btn btn-success btn-block" onclick="printDocument()">Cetak Dokumen</button></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </card>
            </div>
        </div>
    </div>

    <!-- Modal Document-->
    <div class="modal fade" id="modalHelpDocument" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="tableModalDocument">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>NO. DOC</th>
                                        <th>TGL. DOC</th>
                                        <th>NOTA</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal PLU -->
    <div class="modal fade" id="modalHelpPlu" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Prodmast</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm" id="tableModalPlu">
                                        <thead>
                                        <tr>
                                            <th>DESKRIPSI</th>
                                            <th>PLU</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp"></tbody>
                                    </table>
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

    <p class="text-hide" id="idRow"></p>

    <style>
        tbody td {
            padding: 3px !important;
        }


    </style>

    <script>
        let tempTrn;
        let tempPlu;
        var tempStock = [{'plu' : '0000000', 'stock' : '0', 'deskripsipanjang' : ''}];
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = dd + '/' + mm + '/' + yyyy;

        $(document).ready(function (){
            $("#tgltrn").datepicker({
                "dateFormat" : "dd/mm/yy",
            });
            $('#tgltrn').val(today);
            getDataModalDocument('')
            getDataModalPlu('')
        })

        function  getDataModalDocument(val) {
            let tableModalDocument = $('#tableModalDocument').DataTable({
                "ajax": {
                    'url' : '{{ url('bo/transaksi/pemusnahan/brgrusak/getnmrtrn') }}',
                    "data" : {
                        'value': val
                    },
                },
                "columns": [
                    {data: 'rsk_nodoc', name: 'rsk_nodoc'},
                    {data: 'rsk_tgldoc', name: 'rsk_tgldoc'},
                    {data: 'nota', name: 'nota'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row_lov row_lov_document');
                },
                columnDefs : [
                    { targets : [1],
                        render : function (data, type, row) {
                            return formatDate(data)
                        }
                    }
                ],
                "order": []
            });

            $('#tableModalDocument_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase(); console.log(val);

                    tableModalDocument.destroy();
                    getDataModalDocument(val);
                }
            })
        }

        $(document).on('click', '.row_lov_document', function () {
            var currentButton = $(this);
            let document = currentButton.children().first().text();

            chooseTrn(document)
        });

        function  getDataModalPlu(val) {
            let tableModalPlu= $('#tableModalPlu').DataTable({
                "ajax": {
                    'url' : '{{ url('bo/transaksi/pemusnahan/brgrusak/getplu') }}',
                    "data" : {
                        'value': val
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row_lov row_lov_plu');
                },
                columnDefs : [],
                "order": []
            });

            $('#tableModalPlu_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModalPlu.destroy();
                    getDataModalPlu(val);
                }
            })
        }

        $(document).on('click', '.row_lov_plu', function () {
            var currentButton = $(this);
            let prodmast = currentButton.children().next().text();
            let index =     $('#idRow').val();

            choosePlu(prodmast,index)
        });

        function getPlu(no, val) {
            let index = no['attributes'][4]['nodeValue'];
            $('#idRow').val(index);
            $('#modalHelpPlu').modal('show');
        }

        $('#nmrtrn').keypress(function (e) {
            if (e.which === 13) {
                let val = this.value;

                // Get New TRN Nmr
                if(val === ''){
                    swal({
                        title: 'Buat Nomor Pemusnahan Baru?',
                        icon: 'info',
                        // dangerMode: true,
                        buttons: true,
                    }).then(function (confirm) {
                        if (confirm){
                            ajaxSetup();
                            $.ajax({
                                url: '{{ url()->current() }}/getnewnmrtrn',
                                type: 'post',
                                data: {},
                                beforeSend: function () {
                                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                },
                                success: function (result) {
                                    $('#nmrtrn').val(result);
                                    $('#tgltrn').val(formatDate('now'));
                                    $('#keterangan').val('* TAMBAH');
                                    $('#deskripsiPanjang').val("");
                                    $('#totalItem').val("");
                                    $('#totalHarga').val("");
                                    $('#modal-loader').modal('hide')
                                    $('#deleteDoc').attr( 'disabled', true );
                                    $('#saveData').attr( 'disabled', false );
                                }, error: function () {
                                    alert('error');
                                    $('#modal-loader').modal('hide')
                                }
                            })
                            $('.baris').remove();
                            for (i = 0; i< 11; i++) {
                                $('#tbody').append(tempTable(i));
                            }
                        } else {
                            $('#nmrtrn').val('')
                            $('#keterangan').val('')
                        }
                    })
                } else {
                    chooseTrn(val)
                }
            }
        })

        $('#pilihan').on('change',function () {
            let type = $('#pilihan').val();
            let ttlharga = 0;

            if (type === 'A'){
                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/showall',
                    type: 'post',
                    data: {},
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (result) {
                        $('.baris').remove();
                        for (i = 0; i< result.length; i++) {
                            cat = result[i].st_saldoakhir/result[i].prd_frac;
                            pcs = result[i].st_saldoakhir % result[i].prd_frac;
                            ttl = result[i].st_saldoakhir * result[i].hrgsatuan / result[i].prd_frac;
                            ttlharga = parseFloat(ttlharga) + parseFloat(ttl);

                            let temp =  ` <tr class="d-flex baris" onclick="putDesPanjang(this)">
                                                <td style="width: 80px" class="text-center">
                                                    <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 150px">
                                                    <input disabled type="text" class="form-control plu" value="`+ result[i].st_prdcd +`">
                                                </td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi" value="`+ result[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan" value="`+ result[i].prd_unit +` / `+ result[i].prd_frac +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control ctn text-right" value="`+ parseInt(cat) +`" id="`+ i +`" onchange="calculateQty(this.value,this.id,1)"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control pcs text-right" value="`+ pcs +`" id="`+ i +`" onchange="calculateQty(this.value,this.id,2)"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right" value="`+ convertToRupiah(result[i].hrgsatuan )+`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right" value="`+ convertToRupiah(ttl) +`"></td>
                                                <td style="width: 350px"><input disabled type="text" class="form-control keterangan" value="Barang Rusak">
                                                </td>
                                            </tr>`

                            $('#tbody').append(temp);
                        }
                        $('#addNewRow').attr('disabled', true)
                        $('#saveData').attr('disabled', false)
                        $('#totalItem').val(result.length)
                        $('#totalHarga').val(convertToRupiah(ttlharga))
                        $('#modal-loader').modal('hide');
                    }, error: function () {
                        alert('error');
                        $('#modal-loader').modal('hide')
                    }
                })
            }
        })

        function chooseTrn(kode) {
            let tempNilai = 0;
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/choosetrn',
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
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
            $('#modalHelpDocument').modal('hide')
        }

        function choosePlu(kode,index) {
            for (let i =0 ; i <$('.plu').length; i++){
                if ($('.plu')[i]['attributes'][2]['value'] == index){
                    index = i
                }
            }

            $('.plu')[index].value = kode;
            $('#modalHelpPlu').modal('hide');

            let type        = $('#pilihan').val();
            let temp        = 0;

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/chooseplu',
                type: 'post',
                data: {
                    kode: kode,
                    type: type
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    if (result.kode === 1){
                        data = result.data[0];

                        $('.plu')[index].value = data.st_prdcd;
                        $('.deskripsi')[index].value = data.prd_deskripsipendek;
                        $('.satuan')[index].value = data.prd_unit + ' / '+ data.prd_frac;
                        $('.ctn')[index].value = '0';
                        $('.pcs')[index].value = '0';
                        $('.harga')[index].value = convertToRupiah(data.hrgsatuan);
                        $('.total')[index].value = '0';
                        $('#deskripsiPanjang').val(data.prd_deskripsipanjang)

                        tempStock.push({'plu' : data.st_prdcd, 'stock' : data.st_saldoakhir, 'deskripsipanjang' : data.prd_deskripsipanjang})
                        for(i = 0; i < $('.plu').length; i++){
                            if ($('.plu')[i].value != ''){
                                temp = temp + 1;
                            }
                        }
                        $('#totalItem').val(temp)
                    } else if(result.kode === 0)  {
                        swal('', result.msg, 'warning')
                        $('#deskripsiPanjang').val('')

                        data = result.data[0];
                        $('.plu')[index].value = data.st_prdcd;
                        $('.deskripsi')[index].value = data.prd_deskripsipendek;
                        $('.satuan')[index].value = data.prd_unit + ' / '+ data.prd_frac;
                        $('.ctn')[index].value = '0';
                        $('.pcs')[index].value = '0';
                        $('.harga')[index].value = convertToRupiah(data.prd_avgcost);
                        $('.total')[index].value = '0';
                        $('#deskripsiPanjang').val(data.prd_deskripsipanjang)

                        tempStock.push({'plu' : data.st_prdcd, 'stock' : data.st_saldoakhir,  'deskripsipanjang' : data.prd_deskripsipanjang})
                        for(i = 0; i < $('.plu').length; i++){
                            if ($('.plu')[i].value != ''){
                               temp = temp + 1;
                            }
                        }
                        $('#totalItem').val(temp)
                    } else {
                        swal('Error', 'Somethings error', 'error')
                    }
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function searchPlu2(val, row){
            choosePlu(convertPlu(val),row)
        }

        $('.plu').keypress(function (e) {
            if (e.which === 13) {
                let row = $(this).attr('no');
                let val = convertPlu($(this).val());

                choosePlu(val,row)

            }
        })

        function calculateQty(value, index, kode) {
            let plu     = $('.plu')[index].value;
            let temp    = $('.satuan')[index].value;
            let ctn     = $('.ctn')[index];
            let pcs     = $('.pcs')[index];
            let harga   = $('.harga')[index].value;
            let total   = $('.total')[index];
            let totalHarga = $('#totalHarga');
            let tempTtlHrg = 0;
            let frac    = temp.substr(temp.indexOf('/')+1);
            let stock;
            let qty = 0;
            let qty1 = 0;
            let qty2 = 0;

            for (var i=0; i < tempStock.length; i++) {
                if (tempStock[i].plu === plu) {
                    stock =  tempStock[i].stock;
                }
            }

            qty1 = ctn.value * frac;
            qty2 = pcs.value;
            qty  = parseInt(qty1) + parseInt(qty2);

            if (qty > stock) {
                ctn.value   = 0;
                pcs.value   = 0;
                total.value = 0;
                msg = "Stock Barang Rusak (" + stock + " PCS) < Inputan (" + qty + " PCS)";
                swal('', msg, 'warning')
            } else {
                price = qty * unconvertToRupiah(harga) / frac;
                parseInt(totalHarga,10);
                parseInt(price,10);
                total.value = convertToRupiah(price);

                for(i = 0; i < $('.total').length; i++){
                    if($('.total')[i].value != ''){
                        tempTtlHrg = parseFloat(tempTtlHrg) + parseFloat(unconvertToRupiah($('.total')[i].value));
                    }
                }
                totalHarga.val(convertToRupiah(tempTtlHrg));
                // convertToRupiah(sumTotalHarga)
            }
        }

        function putDesPanjang(e) {
            let plu = e['cells'][1]['childNodes'][1].value

            if (plu){
                for (var i=0; i < tempStock.length; i++) {
                    if (tempStock[i].plu === plu) {
                        $('#deskripsiPanjang').val(tempStock[i].deskripsipanjang)
                    }
                }
            } else {
                $('#deskripsiPanjang').val('')
            }
        }

        function saveData(status) {
            let tempTR  = $('.plu');
            let tempDate= $('#tgltrn').val();
            let noDoc   = $('#nmrtrn').val();
            let type    = $('#pilihan').val();
            let date    = tempDate.substr(3,2) + '/'+ tempDate.substr(0,2)+ '/'+ tempDate.substr(6,4);
            let datas   = [{'plu' : '', 'qty' : '', 'harga' : '', 'total' : '', 'keterangan' : ''}];

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
                    datas.push({'plu': $('.plu')[i].value, 'qty' : qty, 'harga' : unconvertToRupiah($('.harga')[i].value), 'total' : unconvertToRupiah($('.total')[i].value), 'keterangan' : $('.keterangan')[i].value})
                }
            }

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/savedata',
                type: 'post',
                data: {
                    datas:datas,
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
                        if (status == 'cetak'){
                            window.open('{{ url()->current() }}/printdoc/'+result.msg+'/');
                            clearField();
                        } else {
                            swal('Dokumen Berhasil disimpan','','success')
                        }
                    } else {
                        swal('ERROR', "Something's Error", 'error')
                    }
                    $('#modal-loader').modal('hide')
                   $('#pilihan').val('M');
                   $('#saveData').attr("disabled", true)
                    clearField();
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })

        }

        function deleteDocument() {
            let docNum = $('#nmrtrn').val()

            swal({
                title: 'Nomor Dokumen Akan dihapus?',
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                if (confirm){
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/deletedoc',
                        type: 'post',
                        data: {docNum:docNum},
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (result) {
                            $('#modal-loader').modal('hide');
                            swal('Success', 'Dokumen Berhasil dihapus', 'success');
                            clearField();
                        }, error: function (err) {
                            $('#modal-loader').modal('hide');
                            console.log(err.responseJSON.message.substr(0,100));
                            alertError(err.statusText, err.responseJSON.message);
                        }
                    })
                } else {
                    console.log('Tidak dihapus');
                }
            })
        }

        function printDocument(){
            let doc         = $('#nmrtrn').val();
            let keterangan  = $('#keterangan').val();

            if (!doc || !keterangan){
                swal('Data Tidak Boleh Kosong','','warning')
                return false;
            }

            if(doc && keterangan === '* TAMBAH' || doc && keterangan === '*KOREKSI*'){
                saveData('cetak');
            } else {
                window.open('{{ url()->current() }}/printdoc/'+doc+'/');
                clearField();
            }
        }

        function focusToRow(index) {
            // swal('QTYB + QTYK < = 0','', 'warning')
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

        function clearField() {
            $('input').val('')
            $('.baris').remove();

            for (i = 0; i< 15; i++) {
                $('#tbody').append(tempTable(i));
            }

        //    Memperbaharui LOV Nomor TRN
            tempTrn = null;

        }

        //***************
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
                                                <td style="width: 80px"><input type="text" class="form-control ctn text-right" value="" id="`+ index +`" onchange="calculateQty(this.value, this.id, 1)"></td>
                                                <td style="width: 80px"><input type="text" class="form-control pcs text-right" value="" id="`+ index +`" onchange="calculateQty(this.value, this.id, 2)"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right" value=""></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right" value=""></td>
                                                <td style="width: 350px"><input type="text" class="form-control keterangan" value=""></td>
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

        function deleteRow(e) {
            let temp        = 0;
            let tempTtlHrg  = 0;

            $(e).parents("tr").remove();
            $('#deskripsiPanjang').val('')

            for(i = 0; i < $('.plu').length; i++){
                if ($('.plu')[i].value != ''){
                    temp = temp + 1;
                }
                if($('.total')[i].value != ''){
                    tempTtlHrg = parseFloat(tempTtlHrg) + parseFloat(unconvertToRupiah($('.total')[i].value));
                }
            }
            $('#totalItem').val(temp);
            $('#totalHarga').val(convertToRupiah(tempTtlHrg));
        }

    </script>

@endsection
