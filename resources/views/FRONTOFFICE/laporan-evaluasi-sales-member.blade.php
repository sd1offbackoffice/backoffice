@extends('navbar')
@section('title','FO | LAPORAN EVALUASI SALES MEMBER')
@section('content')


    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Laporan Evaluasi Sales Member</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-center" id="tanggal" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">GROUP</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="group">
                                    <option value="ALL">ALL</option>
                                    @foreach($group as $g)
                                        <option value="{{$g->jm_kode}}">{{$g->jm_keterangan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">OUTLET</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="outlet">
                                    <option value="ALL">ALL</option>
                                    @foreach($outlet as $o)
                                        <option value="{{$o->out_kodeoutlet}}">{{$o->out_namaoutlet}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">SEGMENTASI</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="segmentasi">
                                    <option value="ALL">ALL</option>
                                    @foreach($segmentasi as $seg)
                                        <option value="{{$seg->seg_id}}">{{$seg->seg_nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">SUBOUTLET</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="suboutlet">
                                    <option value="ALL">ALL</option>
                                    @foreach($suboutlet as $so)
                                        <option value="{{$so->sub_kodesuboutlet}}">{{$so->sub_namasuboutlet}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MONITORING</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="monitoringMember">
                                    <option value="ALL">ALL</option>
                                    @foreach($monitoringMember as $mM)
                                        <option value="{{ $mM->mem_namamonitoring }}">{{ $mM->mem_namamonitoring }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MEMBER</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="member">
                                    <option value="ALL">ALL</option>
                                    <option value="KHUSUS">KHUSUS</option>
                                    <option value="BIASA">BIASA</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">SORT BY (DESC)</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="sort">
                                    <option value="KODEMEMBER">KODE MEMBER</option>
                                    <option value="NAMAMEMBER">NAMA MEMBER</option>
                                    <option value="KUNJUNGAN">KUNJUNGAN</option>
                                    <option value="STRUK">STRUK</option>
                                    <option value="PRODUK">PRODUK</option>
                                    <option value="SALESNET">SALES NET</option>
                                    <option value="SALESGROSS">SALES GROSS</option>
                                    <option value="MARGIN">MARGIN</option>
                                </select>
                            </div>
                            <label class="col-sm-2 pl-0 pr-0 text-right col-form-label">MONITORING PLU</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="monitoringPLU">
                                    <option value="ALL">ALL</option>
                                    @foreach($monitoringPLU as $mP)
                                        <option value="{{ $mP->mpl_kodemonitoring }}">{{ $mP->mpl_namamonitoring }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <div class="col-sm-3">
                                <button class="col btn btn-primary" onclick="viewReport()">VIEW REPORT</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="container" id="">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-3"></legend>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="tableReport">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Member</th>
                                        <th>Kunj</th>
                                        <th>Struk</th>
                                        <th>Produk</th>
                                        <th>Sales Gross</th>
                                        <th>Sales Net</th>
                                        <th>PPN</th>
                                        <th>Margin</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </fieldset>
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

        .fix-height{
            height: 460px;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov{
            position:absolute;
            right: 20px;
            top: 4px;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }


    </style>

    <script>


        $(document).ready(function(){
            // getModalData('');

            // $('button').prop('disabled',falsse);
            // $('input').prop('disabled',false);
            // $('select').prop('disabled',false);
            // $('.waktu input').prop('disabled',true);

            currVar = '';

            date = new Date();

            $('#tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                },
                // minDate: new Date(date.getFullYear(), date.getMonth(), 1),
                // maxDate: new Date(),
                // startDate: new Date(date.getFullYear(), date.getMonth(), 1),
                // endDate: new Date()
            });

            $('#tableReport').DataTable({
                "paging": false,
                "scrollY": "40vh",
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                },
                "initComplete" : function(){
                }
            });
        });

        function viewReport() {
            tanggal = $('#tanggal').val().split(' - ');

            tgl1 = tanggal[0];
            tgl2 = tanggal[1];

            if ($.fn.DataTable.isDataTable('#tableReport')) {
                $('#tableReport').DataTable().destroy();
            }

            $('#tableReport').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/view-report',
                    "data" : {
                        'tgl1' : tgl1,
                        'tgl2' : tgl2,
                        'group' : $('#group').val(),
                        'outlet' : $('#outlet').val(),
                        'suboutlet' : $('#suboutlet').val(),
                        'segmentasi' : $('#segmentasi').val(),
                        'monitoringMember' : $('#monitoringMember').val(),
                        'monitoringPLU' : $('#monitoringPLU').val(),
                        'member' : $('#member').val(),
                        'sort' : $('#sort').val()
                    },
                },
                "columns": [
                    {data: 'trjd_cus_kodemember'},
                    {data: 'cus_namamember'},
                    {data: null, render: function(data){
                            return convertToRupiah2(data.kunj);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.struk);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.qty);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.salesgross);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.sales);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.sales * 0.1);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah2(data.margin);
                        }
                    },
                    {data: null, render: function(data){
                            return convertToRupiah((data.margin / data.sales * 100))+'%';
                        }
                    },
                ],
                "paging": false,
                "scrollY": "40vh",
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    // $(row).addClass('row-plu');
                    $(row).find('td').addClass('text-right');
                    $(row).find('td:eq(0)').removeClass('text-right').addClass('text-left');
                    $(row).find('td:eq(1)').removeClass('text-right').addClass('text-left');
                },
                "initComplete" : function(){
                    // $('#table_lov_plu_filter input').val(value).select();
                    //
                    // $(".row-plu").prop("onclick", null).off("click");
                    //
                    // $(document).on('click', '.row-plu', function (e) {
                    //     $('#'+currVar).val($(this).find('td:eq(1)').html());
                    //
                    //     $('#m_lov_plu').modal('hide');
                    //
                    //     checkPLU(currVar);
                    // });
                }
            });
        }

        function print(){
            periode = $('#periode').val().split(' - ');

            periode1 = periode[0];
            periode2 = periode[1];

            div1 = nvl($('#divisi1').val(), '0');
            div2 = nvl($('#divisi2').val(), '9');
            dep1 = nvl($('#departement1').val(), '00');
            dep2 = nvl($('#departement2').val(), '99');
            kat1 = nvl($('#kategori1').val(), '00');
            kat2 = nvl($('#kategori2').val(), '99');
            plu1 = nvl($('#plu1').val(), '0000000');
            plu2 = nvl($('#plu2').val(), '9999999');
            laporan = nvl($('#laporan').val(), 'DETAIL');

            if(laporan == 'REKAP')
                url = '{{ url()->current() }}/print-rekap?periode1=' + periode1 + '&periode2=' + periode2 + '&div1=' + div1 + '&div2=' + div2 + '&dep1=' + dep1 + '&dep2=' + dep2 + '&kat1=' + kat1 + '&kat2=' + kat2 + '&plu1=' + plu1 + '&plu2=' + plu2 + '&laporan=' + laporan;
            else url = '{{ url()->current() }}/print-detail?periode1=' + periode1 + '&periode2=' + periode2 + '&div1=' + div1 + '&div2=' + div2 + '&dep1=' + dep1 + '&dep2=' + dep2 + '&kat1=' + kat1 + '&kat2=' + kat2 + '&plu1=' + plu1 + '&plu2=' + plu2 + '&laporan=' + laporan;

            window.open(url);
        }
    </script>

@endsection
