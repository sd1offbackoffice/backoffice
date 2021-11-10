@extends('navbar')
@section('title','MASTER | MASTER JENIS ITEM')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <fieldset class="card border-secondary">
                            <legend  class="w-auto ml-3 h5 ">Input Jenis Rak Untuk PLU Planogram</legend>
                            <div class="card-body">
                                <div class="row ">
                                    <label for="i_pluplanogram" class="col-sm-3 col-form-label text-right">PLU Planogram</label>
                                    <div class="col-sm-2 buttonInside" style="margin-left: -15px">
                                        <input type="text"  class="form-control" id="i_pluplanogram" placeholder="..." value="">
                                        <button id="btn-no-doc" type="button" class="btn btn-lov p-0"  data-toggle="modal" data-target="#m_pluHelp">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <input type="text" class="col-sm-5 form-control" disabled id="i_deskripsi" >
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary btn-block" id="btn-save" onclick="save()">SAVE</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="i_unitfrac" class="col-sm-3 col-form-label text-right">Unit/Frac</label>
                                    <input type="text" class="col-sm-1 form-control" disabled id="i_unitfrac" >
                                </div>
                                <div class="row">
                                    <label for="i_maxpalet" class="col-sm-3 col-form-label text-right">Max Palet</label>
                                    <div class="col-sm-2 row">
                                        <input type="text" class="col-sm-4 form-control" disabled id="i_maxpalet" >
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="i_jenisrak" class="col-sm-3 col-form-label text-right">Jenis Rak</label>
                                    <div class="col-sm-2 row">
                                        <input style="text-transform: uppercase;" type="text" class="col-sm-4 form-control" id="i_jenisrak" placeholder="..." >
                                        <label id="l_jenisrak" class="col-sm-7 col-form-label text-left">D / N</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row">
                            <div class="col-sm-3 p-0">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-3 h5 ">Trend Sales</legend>
                                    <div class="card-body pt-0 pb-0">
                                        <table class="table table-sm border-bottom  justify-content-md-center p-0" id="table-barcode">
                                            <thead>
                                            <tr class="row theadDataTables">
                                                <th class="col-sm-2"></th>
                                                <th class="col-sm-4 text-center small">QTY</th>
                                                <th class="col-sm-6 text-center small">RUPIAH</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="row justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;">
                                                    JAN
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_01">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_01">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    FEB
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_02">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_02">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    MAR
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_03">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_03">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    APR
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_04">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_04">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    MEI
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_05">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_05">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    JUN
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_06">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled  id="sls_rph_06">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    JUL
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_07">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled  id="sls_rph_07">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    AGU
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_08">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_08">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    SEP
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_09">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_09">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    OKT
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_10">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_10">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    NOV
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_11">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_11">
                                                </td>
                                            </tr>
                                            <tr class="row  justify-content-md-center p-0">
                                                <td class="col-sm-2 p-0 text-center" style="padding-top: .45rem!important;" >
                                                    DES
                                                </td>
                                                <td class="col-sm-4 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_qty_12">
                                                </td>
                                                <td class="col-sm-6 p-0">
                                                    <input type="text" class="form-control text-right" disabled id="sls_rph_12">
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-4 p-0">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-3 h5">Daftar PO Yang Masih Aktif</legend>
                                    <div class="card-body pt-0 pb-0 my-custom-scrollbar table-wrapper-scroll-y">
                                        <table class="table table-sm border-bottom  justify-content-md-center p-0" id="table-po">
                                            <thead>
                                            <tr class="row justify-content-md-center theadDataTables">
                                                <th class="col-sm-5 text-center small">Nomor PO</th>
                                                <th class="col-sm-5 text-center small">Tanggal PO</th>
                                                <th class="col-sm-2 text-center small">Qty PO</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="row baris justify-content-md-center p-0">
                                                <td class="col-sm-5 p-0 text-center" >
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="col-sm-5 p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="col-sm-2 p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-5 p-0">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-3 h5">Daftar Lokasi PLU</legend>
                                    <div class="card-body pt-0 pb-0 my-custom-scrollbar table-wrapper-scroll-y">
                                        <table class="table table-sm border-bottom  justify-content-md-center p-0" id="table-lokasi-plu">
                                            <thead>
                                            <tr class="row justify-content-md-center theadDataTables">
                                                <th class="col-sm-4 text-center small">Lokasi PLU</th>
                                                <th class="col-sm-2 text-center small">Jenis</th>
                                                <th class="col-sm-2 text-center small">Qty</th>
                                                <th class="col-sm-2 text-center small">Max Plano</th>
                                                <th class="col-sm-2 text-center small">Max Display</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="row baris justify-content-md-center p-0">
                                                <td class="col-sm-4 p-0 text-center" >
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="col-sm-2 p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="col-sm-2 p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="col-sm-2 p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                                <td class="col-sm-2 p-0">
                                                    <input type="text" class="form-control" disabled>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8 p-0">
                                <fieldset class="card border-secondary">
                                    <legend  class="w-auto ml-3 h5 ">Stock</legend>
                                    <div class="card-body p-1">
                                        <table class="table border-bottom  justify-content-md-center p-0" id="table-stock">
                                            <thead class="theadDataTables">
                                            <tr class="justify-content-md-center">
                                                <th class="text-center small">LOKASI</th>
                                                <th class="text-center small">AWAL</th>
                                                <th class="text-center small">TERIMA</th>
                                                <th class="text-center small">KELUAR</th>
                                                <th class="text-center small">SALES</th>
                                                <th class="text-center small">RETUR</th>
                                                <th class="text-center small">ADJ</th>
                                                <th class="text-center small">INSTRST</th>
                                                <th class="text-center small">AKHIR</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="justify-content-md-center p-0">
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" id="lokasi" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" id="awal" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" id="terima" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" id="keluar" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" id="sales" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" id="retur" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" id="adj" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" id="instrst" disabled>
                                                </td>
                                                <td class="p-0">
                                                    <input type="text" class="form-control text-center" id="akhir" disabled>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-sm-4 my-auto">
                                <div class="row">
                                    <div class="col-sm-1">
                                    </div>
                                    <table class="table border-bottom col-sm-6 justify-content-md-center" id="table-barcode">
                                        <thead class="theadDataTables">
                                        <tr class="justify-content-md-center">
                                            <th class="text-center">AVERAGE SALES</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="justify-content-md-center p-0">
                                            <td class="p-0">
                                                <input type="text" class="form-control text-center" id="avgsales" disabled>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-sm-1 my-auto">
                                        <button class="btn btn-primary btn-lg" id="btn-penerimaan"  data-toggle="modal" data-target="#m_penerimaan">Penerimaan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="m_pluHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master PLU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalPlu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody>
{{--                                    @foreach($produk as $p)--}}
{{--                                        <tr onclick="lov_select('{{ $p->prd_prdcd }}')" class="row_lov">--}}
{{--                                            <td>{{ $p->prd_deskripsipanjang }}</td>--}}
{{--                                            <td>{{ $p->prd_prdcd }}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
                                    </tbody>
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

    <div class="modal fade" id="m_penerimaan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-scrollable modal-xl " role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Table Penerimaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="height: 650px">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm table-striped table-bordered display compact" id="table_penerimaan">
                                    <thead class="theadDataTables">
                                    <tr class="thNormal text-center">
                                        <th width="20%">Supplier</th>
                                        <th width="10%">Qty BPB</th>
                                        <th width="7.5%">Bonus 1</th>
                                        <th width="7.5%">Bonus 2</th>
                                        <th width="10%">Dokumen</th>
                                        <th width="12.5%">Tanggal</th>
                                        <th width="10%">Top</th>
                                        <th width="10%">Last Cost (pcs)</th>
                                        <th width="10%">Avg Cost (pcs)</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody_table_penerimaan">
                                    <tr class="baris">
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                        <td class="p-0">
                                            <input type="text" class="form-control" value="" disabled>
                                        </td>
                                    </tr>
                                    </tbody>
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
    <script>
        $(document).ready(function () {
            getModalData('');
            $('#i_pluplanogram').select();
        });

        function getModalData(value){
            let tableModal = $('#tableModalPlu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-prodmast',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang', width : '80%'},
                    {data: 'prd_prdcd', name: 'prd_prdcd', width : '20%'},
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
                "order": [],
                columnDefs : [
                ]
            });

            $('#tableModalPlu_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalData(val);
                }
            })
        }
        $('#m_pluHelp').on('shown.bs.modal',function(e) {
            setTimeout(
                function()
                {
                    $('#tableModalPlu_filter label input').focus();
                }, 200);
        } );

        $(document).on('click', '.modalRow', function () {
            let plu = $(this).find('td')[1]['innerHTML']

            lov_select(plu)
        } );

        month = ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGU','SEP','OKT','NOV','DES'];
        $('#i_pluplanogram').keypress(function(e) {
            if (e.keyCode == 13) {
                convert_plu();
                var p = $('#i_pluplanogram').val();
                get_data(p);
            }
        });
        $('#i_jenisrak').on('change',function(e) {
            $('#i_jenisrak').val($('#i_jenisrak').val().toUpperCase());
            value = $('#i_jenisrak').val();
            if(value != 'D' && value != 'N'){
                swal({
                    title: 'Jenis Rak Input D/N',
                    icon: 'warning'
                }).then((createData) => {
                        $('#i_jenisrak').val('');
                        $('#i_jenisrak').focus();
                });

            }
        });
        $('#i_jenisrak').keypress(function(e) {
            if (e.keyCode == 13) {
                $('#btn-save').focus();
            }
        });

        function convert_plu() {
            var plu = $('#i_pluplanogram').val();
            console.log(plu.length);
            for(var i = plu.length ; i < 7 ; i++){
                plu='0'+plu;
            }
            $('#i_pluplanogram').val(plu);
        }

        function get_data(value) {
            $.ajax({
                url: '{{ url()->current() }}/lov-select',
                type:'POST',
                data:{"_token":"{{ csrf_token() }}",value: value},
                beforeSend: function(){
                    $('#m_pluHelp').modal('hide');
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function(response){
                    console.log(response);
                    $('#modal-loader').modal('hide');
                    $('#i_pluplanogram').val(value);
                    $('#i_deskripsi').val(response['produk']['prd_deskripsipanjang']);
                    $('#i_unitfrac').val(response['produk']['prd_unit']+'/'+response['produk']['prd_frac']);
                    $('#i_maxpalet').val(response['palet']['mpt_maxqty']);
                    $('#sls_qty_01').val(convertToRupiah(response['trendsales']['sls_qty_01']));
                    $('#sls_qty_02').val(convertToRupiah(response['trendsales']['sls_qty_02']));
                    $('#sls_qty_03').val(convertToRupiah(response['trendsales']['sls_qty_03']));
                    $('#sls_qty_04').val(convertToRupiah(response['trendsales']['sls_qty_04']));
                    $('#sls_qty_05').val(convertToRupiah(response['trendsales']['sls_qty_05']));
                    $('#sls_qty_06').val(convertToRupiah(response['trendsales']['sls_qty_06']));
                    $('#sls_qty_07').val(convertToRupiah(response['trendsales']['sls_qty_07']));
                    $('#sls_qty_08').val(convertToRupiah(response['trendsales']['sls_qty_08']));
                    $('#sls_qty_09').val(convertToRupiah(response['trendsales']['sls_qty_09']));
                    $('#sls_qty_10').val(convertToRupiah(response['trendsales']['sls_qty_10']));
                    $('#sls_qty_11').val(convertToRupiah(response['trendsales']['sls_qty_11']));
                    $('#sls_qty_12').val(convertToRupiah(response['trendsales']['sls_qty_12']));
                    $('#sls_rph_01').val(convertToRupiah(response['trendsales']['sls_rph_01']));
                    $('#sls_rph_02').val(convertToRupiah(response['trendsales']['sls_rph_02']));
                    $('#sls_rph_03').val(convertToRupiah(response['trendsales']['sls_rph_03']));
                    $('#sls_rph_04').val(convertToRupiah(response['trendsales']['sls_rph_04']));
                    $('#sls_rph_05').val(convertToRupiah(response['trendsales']['sls_rph_05']));
                    $('#sls_rph_06').val(convertToRupiah(response['trendsales']['sls_rph_06']));
                    $('#sls_rph_07').val(convertToRupiah(response['trendsales']['sls_rph_07']));
                    $('#sls_rph_08').val(convertToRupiah(response['trendsales']['sls_rph_08']));
                    $('#sls_rph_09').val(convertToRupiah(response['trendsales']['sls_rph_09']));
                    $('#sls_rph_10').val(convertToRupiah(response['trendsales']['sls_rph_10']));
                    $('#sls_rph_11').val(convertToRupiah(response['trendsales']['sls_rph_11']));
                    $('#sls_rph_12').val(convertToRupiah(response['trendsales']['sls_rph_12']));

                    $('.baris').remove();
                    for (var i = 0; i < response['po'].length ; i++ ){
                        $('#table-po').append('<tr class="row baris justify-content-md-center p-0"> <td class="col-sm-5 p-0 text-center" > <input type="text" class="form-control" disabled value="'+response['po'][i].tpoh_nopo+'"> </td> <td class="col-sm-5 p-0"><input type="text" class="form-control" disabled value="'+formatDate(response['po'][i].tpoh_tglpo.substr(0,10))+'"> </td> <td class="col-sm-2 p-0"><input type="text" class="form-control" disabled  value="'+response['po'][i].tpod_qtypo+'"></td></tr>');
                    }
                    for (var i = 0; i < response['lokasi'].length ; i++ ){
                        $('#table-lokasi-plu').append('<tr class="row baris justify-content-md-center p-0"><td class="col-sm-4 p-0 text-center" ><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_koderak+'.'+response['lokasi'][i].lks_kodesubrak+'.'+response['lokasi'][i].lks_tiperak+'.'+response['lokasi'][i].lks_shelvingrak+'.'+response['lokasi'][i].lks_nourut+'"></td><td class="col-sm-2 p-0"><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_jenisrak+'"></td><td class="col-sm-2 p-0"><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_qty+'"></td><td class="col-sm-2 p-0"><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_maxplano+'"></td><td class="col-sm-2 p-0"><input type="text" class="form-control" disabled value="'+response['lokasi'][i].lks_maxdisplay+'"></td></tr>');
                    }
                    $('#lokasi').val(response['prodstock'].st);
                    $('#awal').val(convertToRupiah(response['prodstock'].st_saldoawal));
                    $('#terima').val(convertToRupiah(response['prodstock'].st_trfin));
                    $('#keluar').val(convertToRupiah(response['prodstock'].st_trfout));
                    $('#sales').val(convertToRupiah(response['prodstock'].st_sales));
                    $('#retur').val(convertToRupiah(response['prodstock'].st_retur));
                    $('#adj').val(convertToRupiah(response['prodstock'].st_adj));
                    $('#instrst').val(convertToRupiah(response['prodstock'].st_intransit));
                    $('#akhir').val(convertToRupiah(response['prodstock'].st_saldoakhir));
                    $('#avgsales').val(convertToRupiah(response['AVGSALES']));


                    for (var i = 0; i < response['supplier'].length ; i++ ){
                    $('#table_penerimaan').append('<tr class="baris"><td class="p-0">\n' +
                        '<textarea class="form-control" cols="10" rows="2" wrap="hard" disabled>'+response['supplier'][i].sup_namasupplier+'</textarea>\n' +
                        '</td>\n' +
                        '<td class="p-0">\n' +
                        '    <input type="text" class="form-control text-right p-1" value="'+(response['supplier'][i].trm_qtybns)+'" disabled>\n' +
                        '</td>\n' +
                        '<td class="p-0">\n' +
                        '    <input type="text" class="form-control text-right p-1" value="'+response['supplier'][i].trm_bonus+'" disabled>\n' +
                        '</td>\n' +
                        '<td class="p-0">\n' +
                        '    <input type="text" class="form-control text-right p-1" value="'+response['supplier'][i].trm_bonus2+'" disabled>\n' +
                        '</td>\n' +
                        '<td class="p-0">\n' +
                        '    <input type="text" class="form-control p-1" value="'+response['supplier'][i].trm_dokumen+'" disabled>\n' +
                        '</td>\n' +
                        '<td class="p-0">\n' +
                        '    <input type="text" class="form-control p-1" value="'+formatDate(response['supplier'][i].trm_tanggal)+'" disabled>\n' +
                        '</td>\n' +
                        '<td class="p-0">\n' +
                        '    <input type="text" class="form-control p-1" value="'+response['supplier'][i].trm_top+'" disabled>\n' +
                        '</td>\n' +
                        '<td class="p-0">\n' +
                        '    <input type="text" class="form-control text-right p-1" value="'+convertToRupiah(response['supplier'][i].trm_hpp)+'" disabled>\n' +
                        '</td>\n' +
                        '<td class="p-0">\n' +
                        '    <input type="text" class="form-control text-right p-1" value="'+convertToRupiah(response['supplier'][i].trm_acost)+'" disabled>\n' +
                        '</td><tr>');
                    null_check();
                    }
                    $('#i_jenisrak').select();
                },
                error : function (err){
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                },
                complete: function(){
                    if($('#m_pluHelp').is(':visible')){
                        $('#search_lov').val('');
                        $('#table_lov .row_lov').remove();
                        $('#table_lov').append(trlov);
                    }
                }
            });
        }
        var trlov = $('#table_lov tbody').html();

        function lov_select(value){
            get_data(value);
        }

        $('#search_lov').keypress(function (e) {
            if (e.which == 13) {
                if(this.value.length == 0) {
                    $('#table_lov .row_lov').remove();
                    $('#table_lov').append(trlov);
                    $('.invalid-feedback').hide();
                }
                else if(this.value.length >= 3) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '{{ url()->current() }}/lov-search',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        success: function (response) {
                            $('#table_lov .row_lov').remove();
                            html = "";
                            console.log(response.length);
                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov" onclick=lov_select("' + response[i].prd_prdcd + '")><td>' + response[i].prd_deskripsipanjang + '</td><td>' + response[i].prd_prdcd + '</td></tr>';
                                trlov += html;
                                $('#table_lov').append(html);
                            }
                        }, error : function (err){
                            console.log(err.responseJSON.message.substr(0,150));
                            alertError(err.statusText, err.responseJSON.message);
                        }
                    });
                }
                else{
                    $('.invalid-feedback').show();
                }
            }
        });


        function save() {
            $('#l_jenisrak').css("color", "black");
            $('#i_jenisrak').val($('#i_jenisrak').val().toUpperCase());
            if( $('#i_jenisrak').val()!='D' && $('#i_jenisrak').val()!='N'){
                $('#i_jenisrak').val("");
                $('#i_jenisrak').select();
                $('#l_jenisrak').css("color", "red");
            }
            else {
                var prdcd = $('#i_pluplanogram').val();
                var jenisrak = $('#i_jenisrak').val();
                var prdcd = $('#i_pluplanogram').val();
                $.ajax({
                    url: '{{ url()->current() }}/save-data',
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}", prdcd:prdcd,jenisrak:jenisrak},
                    success: function (response) {
                        console.log(response);
                        swal({
                            title: response['message'],
                            icon: response['status']
                        }).then((createData) => {
                            window.location.reload();
                        });
                    }, error : function (err){
                        console.log(err.responseJSON.message.substr(0,150));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                });

            }
        }

        function null_check() {
            $("input:text").each(function(){
                var $this = $(this);
                if($this.val()=="null"){
                    $this.val("0");
                }
            });
        }
    </script>

@endsection

