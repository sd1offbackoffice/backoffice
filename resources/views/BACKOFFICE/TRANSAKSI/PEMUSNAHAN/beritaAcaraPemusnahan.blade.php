@extends('navbar')
@section('title','PEMUSNAHAN | BERITA ACARA PEMUSNAHAN')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">No. Dokumen</label>
                                        <div class="col-sm-5 buttonInside">
                                            <input type="text" id="noDoc" class="form-control">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" data-target="#modalHelpDocument" >
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Tanggal Dokumen</label>
                                        <input type="text" id="tglDoc" class="form-control col-sm-5 mx-sm-3">
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">No. PBBR</label>
                                        <div class="col-sm-5 buttonInside">
                                            <input type="text" id="noPBBR" class="form-control">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" data-target="#modalHelpPBBR"  id="buttonPBBR">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Tanggal PBBR</label>
                                        <input type="text" id="tglPBBR" class="form-control col-sm-5 mx-sm-3" disabled>
                                    </div>
                                    <div class="form-group row mb-3 mt-2">
                                        <input type="text" id="keterangan" class="form-control col-sm-6 text-right" style="margin-left: 50%"  disabled>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12">
                                <div class="tableFixedHeader" style="border-bottom: 1px solid black">
                                    <table class="table table-striped table-bordered" id="table2">
                                        <thead class="theadDataTables">
                                        <tr class="d-flex text-center">
                                            <th style="width: 150px">PLU</th>
                                            <th style="width: 400px">Deskripsi</th>
                                            <th style="width: 130px">Satuan</th>
                                            <th style="width: 150px">Hrg. Satuan</th>
                                            <th style="width: 80px">Qty Rsk</th>
                                            <th style="width: 80px">Qty Real</th>
                                            <th style="width: 150px">Nilai</th>
                                            <th style="width: 350px">Keterangan</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        @for($i = 0; $i< 9; $i++)
                                            <tr class="d-flex baris">
                                                <td style="width: 150px"><input disabled type="text" class="form-control plu"></td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control qtyRsk text-right"></td>
                                                <td style="width: 80px"><input type="text" class="form-control qtyReal text-right"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control nilai text-right"></td>
                                                <td style="width: 350px"><input disabled type="text" class="form-control keterangan"></td>
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
                                            <span style=""><button id="saveData" class="btn btn-primary btn-block" onclick="saveData('new')" disabled>Simpan Dokumen</button></span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-5 offset-sm-5">
                                            <label class="col-form-label col-sm-4 offset-sm-5 text-right">Total Item</label>
                                            <input type="text" class="form-control col-sm-2 text-right" id="totalItem" value="0" style="float: right" disabled>
                                        </div>
                                        <div class="col-sm-2">
                                            <span style=""><button id="printdoc" class="btn btn-success btn-block" onclick="printDocument()">Cetak Dokumen</button></span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-sm-5 offset-sm-5">
                                            <label class="col-form-label col-sm-4 offset-sm-5 text-right">Total Harga</label>
                                            <input type="text" class="form-control col-sm-3 text-right" id="totalHarga" value="0" style="float: right" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Dokumen-->
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
                                        <th>No. Dokumen</th>
                                        <th>No. Referensi</th>
                                        <th>Tgl Refrensi</th>
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
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal PBBR-->
    <div class="modal fade" id="modalHelpPBBR" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar barang Rusak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="tableModalPBBR">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No. Dokumen</th>
                                        <th>Tgl. Dokumen</th>
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
        let tempDoc;
        let tempPBBR;
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = dd + '/' + mm + '/' + yyyy;


        $(document).ready(function (){
            $("#tglDoc").datepicker({
                "dateFormat" : "dd/mm/yy",
            });
            $('#tglDoc').val(today);
            getDataModalDocument('')
            getDataModalPBBR('')
            $('#noDoc').focus();
        })

        function  getDataModalDocument(val) {
            let tableModalDocument = $('#tableModalDocument').DataTable({
                "ajax": {
                    'url' : '{{ url('bo/transaksi/pemusnahan/bapemusnahan/getnodoc') }}',
                    "data" : {
                        'value': val
                    },
                },
                "columns": [
                    {data: 'brsk_nodoc', name: 'brsk_nodoc'},
                    {data: 'brsk_noref', name: 'brsk_noref'},
                    {data: 'brsk_tglref', name: 'brsk_tglref'},
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
                    { targets : [2],
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

            chooseDoc(document)
        });

        function  getDataModalPBBR(val) {
            let tableModalDocument = $('#tableModalPBBR').DataTable({
                "ajax": {
                    'url' : '{{ url('bo/transaksi/pemusnahan/bapemusnahan/getnopbbr') }}',
                    "data" : {
                        'value': val
                    },
                },
                "columns": [
                    {data: 'rsk_nodoc', name: 'rsk_nodoc'},
                    {data: 'rsk_tgldoc', name: 'rsk_tgldoc'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row_lov row_lov_pbbr');
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

            $('#tableModalPBBR_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase(); console.log(val);

                    tableModalDocument.destroy();
                    getDataModalDocument(val);
                }
            })
        }

        $(document).on('click', '.row_lov_pbbr', function () {
            var currentButton = $(this);
            let pbbr = currentButton.children().first().text();

            choosePBBR(pbbr)
        });

        /****************************************************/


        function chooseDoc(val) {
            let tempNilai = 0;

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/choosedoc',
                type: 'post',
                data: {
                    val:val
                },
                beforeSend: function () {
                    $('#modalHelpDocument').modal('hide');
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    if (result.kode == '1') {
                        $('#noPBBR').attr('disabled', true);
                        $('#tglDoc').attr('disabled', true);
                        $('#buttonPBBR').hide();
                        $('#noDoc').val(result.data[0].brsk_nodoc);
                        $('#tglDoc').val(formatDate(result.data[0].brsk_tgldoc));
                        $('#noPBBR').val(result.data[0].brsk_noref);
                        $('#tglPBBR').val(formatDate(result.data[0].brsk_tglref));
                        $('#keterangan').val(result.keterangan);

                        for (i = 0; i< result.data.length; i++) {
                            tempNilai = parseFloat(tempNilai) + parseFloat(result.data[i].brsk_nilai)
                        }
                        $('#totalHarga').val(convertToRupiah(tempNilai));

                        $('.baris').remove();
                        for (i = 0; i< result.data.length; i++) {
                            let temp =  `  <tr class="d-flex baris" onclick="putDesPanjang('`+ result.data[i].prd_deskripsipanjang+`')">
                                                <td style="width: 150px"><input disabled type="text" class="form-control plu" value="`+ result.data[i].brsk_prdcd +`"></td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi" value="`+ result.data[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan" value="`+ result.data[i].prd_unit +`/`+ result.data[i].prd_frac +`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right" value="`+ convertToRupiah(result.data[i].brsk_hrgsatuan) +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control qtyRsk text-right" value="`+ result.data[i].brsk_qty_rsk +`"></td>
                                                <td style="width: 80px"><input onblur="calculateQty(this.value,this.id)"  type="text" class="form-control qtyReal text-right" id="`+ i +`" value="`+ result.data[i].brsk_qty_real +`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control nilai text-right" value="`+ convertToRupiah(result.data[i].brsk_nilai) +`"></td>
                                                <td style="width: 350px"><input disabled type="text" class="form-control keterangan" value="`+ result.data[i].brsk_keterangan +`"></td>
                                            </tr>`;

                            $('#tbody').append(temp);
                        }

                        $('#totalItem').val(result.data.length);
                    } else {
                        swal(result.msg, '', 'warning');
                        clearField();
                    }

                    if($('#keterangan').val() === '* TAMBAH *' || $('#keterangan').val() === '* KOREKSI *'){
                        $('#saveData').attr('disabled', false)
                        $('.qtyReal').attr('disabled', false)
                    } else {
                        $('#saveData').attr('disabled', true)
                        $('.qtyReal').attr('disabled', true)
                    }

                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function choosePBBR(val) {
            let tempNilai = 0;

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/choosepbbr',
                type: 'post',
                data: {
                    val:val
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    $('#modalHelpPBBR').modal('hide');
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');

                    if(result.kode == 0){
                        swal(result.msg,'','warning');
                        $('.baris').remove()
                        for (i = 0; i< 9; i++) {
                            $('#tbody').append(tempTable());
                        }
                    } else {
                        for (i = 0; i< result.data.length; i++) {
                            tempNilai = parseFloat(tempNilai) + parseFloat(result.data[i].rsk_nilai)
                        }
                        $('#totalHarga').val(convertToRupiah(tempNilai));

                        $('.baris').remove();
                        for (i = 0; i< result.data.length; i++) {
                            let temp =  `  <tr class="d-flex baris" onclick="putDesPanjang('`+ (result.data[i].prd_deskripsipanjang).replace("'", "`") +`')">
                                                <td style="width: 150px"><input disabled type="text" class="form-control plu" value="`+ result.data[i].rsk_prdcd +`"></td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi" value="`+ result.data[i].prd_deskripsipendek +`"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan" value="`+ result.data[i].prd_unit +`/`+ result.data[i].prd_frac +`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right" value="`+ convertToRupiah(result.data[i].rsk_hrgsatuan) +`"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control qtyRsk text-right" value="`+ result.data[i].rsk_qty +`"></td>
                                                <td style="width: 80px"><input onblur="calculateQty(this.value,this.id)"  type="text" class="form-control qtyReal text-right" id="`+ i +`" value="`+ result.data[i].rsk_qty +`"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control nilai text-right" value="`+ convertToRupiah(result.data[i].rsk_nilai) +`"></td>
                                                <td style="width: 350px"><input disabled type="text" class="form-control keterangan" value="`+ result.data[i].rsk_keterangan +`"></td>
                                            </tr>`;

                            $('#tbody').append(temp);
                        }

                        $('#noPBBR').val( result.data[0].rsk_nodoc)
                        $('#tglPBBR').val(formatDate(result.data[0].rsk_tgldoc))
                        $('#totalItem').val(result.data.length);
                    }
                }, error: function () {
                    alert('error');
                }
            })
        }

        $('#noDoc').keypress(function (e) {
            if (e.which === 13) {
                let val = this.value;

                if (val === ''){
                    swal({
                        title: 'Buat Nomor BA Pemusnahan Baru?',
                        icon: 'info',
                        buttons: true,
                    }).then(function (confirm) {
                        if (confirm){
                            ajaxSetup();
                            $.ajax({
                                url: '{{ url()->current() }}/getnewnmrdoc',
                                type: 'post',
                                data: {},
                                beforeSend: function () {
                                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                },
                                success: function (result) {
                                    $('#noDoc').val(result);
                                    $('#tglDoc').val(formatDate('now'));
                                    $('#keterangan').val('* TAMBAH *');
                                    $('#deskripsiPanjang').val("");
                                    $('#totalItem').val("");
                                    $('#totalHarga').val("");
                                    $('#modal-loader').modal('hide')
                                    $('#noPBBR').attr( 'disabled', false);
                                    $('#noPBBR').val("")
                                    $('#tglPBBR').val("")
                                    $('#buttonPBBR').show();
                                    $('#tglDoc').attr( 'disabled', false );
                                    $('#saveData').attr('disabled', false)

                                    $('.baris').remove();
                                    for (i = 0; i< 9; i++) {
                                        $('#tbody').append(tempTable());
                                    }
                                    $('#noPBBR').focus();
                                }, error: function (err) {
                                    $('#modal-loader').modal('hide');
                                    console.log(err.responseJSON.message.substr(0,100));
                                    alertError(err.statusText, err.responseJSON.message);
                                }
                            })
                        } else {
                            $('#nmrtrn').val('')
                            $('#keterangan').val('')
                        }
                    })
                } else {
                    chooseDoc(val)
                }
            }
        })

        $('#noPBBR').keypress(function (e) {
            if (e.which === 13) {
                let val = this.value;

                if(!val){
                    swal('No Referensi Tidak Boleh Kosong !', '', 'warning')
                    $('#noPBBR').focus();
                } else {
                    choosePBBR(val);
                }
            }
        })

        function calculateQty(val, index) {
            let harga = $('.harga')[index].value;
            let temp    = $('.satuan')[index].value;
            let stock    = $('.qtyRsk')[index].value;
            let frac    = temp.substr(temp.indexOf('/')+1);

            if (val > stock){
                focusToRow(index, 1)
                return false;
            } else  if(val <= 0){
                focusToRow(index, 0)
                return false;
            }

            let calculate   = val * unconvertToRupiah(harga) / frac;
            $('.nilai')[index].value = convertToRupiah(calculate);
            calculateTotal()
        }

        function calculateTotal() {
            let temp    = $('.nilai');
            let total   = 0;

            for (i=0; i<temp.length; i++){
                total = parseFloat(total) + parseFloat(unconvertToRupiah($('.nilai')[i].value))
            }

            $('#totalHarga').val(convertToRupiah(total))
        }

        function saveData(status) {
            let doc         = $('#noDoc').val();
            let tglDoc      = $('#tglDoc').val();
            let pbbr        = $('#noPBBR').val();
            let tglpbbr     = $('#tglPBBR').val();
            let temp        = $('.plu');
            let datas   = [{'plu' : '', 'qtyRsk' : '', 'qtyReal' : '', 'harga' : '', 'total' : '', 'keterangan' : ''}];

            if (!doc || !pbbr){
                swal('Data Tidak Boleh Kosong !')
                return false;
            } else {
                for (let i=0; i < temp.length; i++){
                    datas.push({'plu': $('.plu')[i].value, 'qtyRsk' : $('.qtyRsk')[i].value, 'qtyReal' : $('.qtyReal')[i].value, 'harga' : unconvertToRupiah($('.harga')[i].value), 'total' : unconvertToRupiah($('.nilai')[i].value), 'keterangan' : $('.keterangan')[i].value})
                }

                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/savedata',
                    type: 'post',
                    data: {
                        datas:datas,
                        doc:doc,
                        tglDoc:tglDoc,
                        pbbr:pbbr,
                        tglPBBR:tglpbbr
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (result) {
                        $('#modal-loader').modal('hide');
                        if(result.kode == '1'){
                            if (status == 'cetak'){
                                window.open('{{ url()->current() }}/printdoc/'+result.msg+'/');
                                // clearField();
                            } else {
                                swal('Dokumen Berhasil disimpan','','success')
                            }
                        } else {
                            swal('ERROR', "Something's Error", 'error')
                        }
                        clearField()
                    }, error: function (err) {
                        $('#modal-loader').modal('hide');
                        console.log(err.responseJSON.message.substr(0,100));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                })
            }

        }

        function printDocument() {
            let doc         = $('#noDoc').val();
            let pbbr        = $('#noPBBR').val();
            let keterangan  = $('#keterangan').val();

            if (!doc || !keterangan || !pbbr){
                swal('Data Tidak Boleh Kosong','','warning')
                return false;
            }

            if(doc && keterangan === '* TAMBAH *' || doc && keterangan === '* KOREKSI *'){
                saveData('cetak');
            } else {
                window.open('{{ url()->current() }}/printdoc/'+doc+'/');
                clearField();
            }

            // window.open('/BackOffice/public/bo/transaksi/pemusnahan/bapemusnahan/printdoc/');
            // window.open('/BackOffice/public/bo/transaksi/pemusnahan/bapemusnahan/printdoc/'+result.msg+'/');
        }

        function putDesPanjang(val) {
            $('#deskripsiPanjang').val(val);
        }

        function tempTable() {
            let temp = `<tr class="d-flex baris">
                                                <td style="width: 150px"><input disabled type="text" class="form-control plu"></td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right"></td>
                                                <td style="width: 80px"><input disabled type="text" class="form-control qtyRsk text-right"></td>
                                                <td style="width: 80px"><input type="text" class="form-control qtyReal text-right"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control nilai text-right"></td>
                                                <td style="width: 350px"><input disabled type="text" class="form-control keterangan"></td>
                                            </tr>`

            return temp;
        }

        function focusToRow(index, status) {
            if(status === '0'){
                msg = "QTY Realisasi <= 0";
            } else {
                msg = 'QTY Realisasi Tidak Boleh > QTY PPR';
            }

            $('.qtyReal')[index].focus();

            swal({
                title:msg,
                text: ' ',
                icon:'warning',
                timer: 1000,
                buttons: {
                    confirm: false,
                },
            });

        }

        function clearField() {
            $('#noDoc').val('');
            $('#tglDoc').val('');
            $('#noPBBR').val('');
            $('#tglPBBR').val('');
            $('#totalItem').val('');
            $('#totalHarga').val('');
            $('#deskripsiPanjang').val('');
            $('#keterangan').val('');

            tempDoc = null;
            $('.baris').remove();
            for (i = 0; i< 9; i++) {
                $('#tbody').append(tempTable());
            }
        }

    </script>

@endsection
