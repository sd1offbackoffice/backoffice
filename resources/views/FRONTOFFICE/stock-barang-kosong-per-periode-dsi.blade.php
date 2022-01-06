@extends('navbar')
@section('title','FO | STOCK BARANG KOSONG PER PERIODE DSI')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Stock Barang Kosong Per Periode DSI</legend>
                    <div class="card-body">
                        <div class="row form-group">
                            <label for="tanggal" class="col-sm-2 text-right col-form-label">Tanggal</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control text-center" id="tanggal" placeholder="DD/MM/YYYY - DD/MM/YYYY" readonly>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-sm-2 text-right col-form-label">MONITORING</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="monitoringPLU">
                                    @foreach($monitoringPLU as $mP)
                                        <option value="{{ $mP->mpl_kodemonitoring }}">{{ $mP->mpl_namamonitoring }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 text-right col-form-label">DSI</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="dsi">
                                    @for($i=1;$i<=30;$i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm"></div>
                            <div class="col-sm-3">
                                <button class="col btn btn-primary" onclick="viewReport()">VIEW REPORT</button>
                            </div>
                            <div class="col-sm-3">
                                <button class="col btn btn-primary" onclick="print()">EXPORT</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="reportField" style="display: none">
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
                                            <th class="align-middle text-center" rowspan="4">PRDCD</th>
                                            <th class="align-middle text-center" rowspan="4">DESKRIPSI</th>
                                            <th class="align-middle text-center" rowspan="4">FRAC</th>
                                            <th class="align-middle text-center" rowspan="2" colspan="2">PO</th>
                                            <th class="align-middle text-center" rowspan="2" colspan="2">BPB</th>
                                            <th class="align-middle text-center" rowspan="4">SL</th>
                                            <th class="align-middle text-center" rowspan="4">AVG</th>
                                            <th class="align-middle text-center" colspan="4">2021</th>
                                            <th class="align-middle text-center" rowspan="2" colspan="4">EST. LOST SALES</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">NOV</th>
                                            <th colspan="2">DES</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2">FRQ</th>
                                            <th rowspan="2">QTY</th>
                                            <th rowspan="2">FRQ</th>
                                            <th rowspan="2">QTY</th>
                                            <th>29</th>
                                            <th>30</th>
                                            <th>01</th>
                                            <th>02</th>
                                            <th rowspan="2">AVG/DSI</th>
                                            <th rowspan="2">QTY</th>
                                            <th rowspan="2">HRG JUAL</th>
                                            <th rowspan="2">RUPIAH</th>
                                        </tr>
                                        <tr>
                                            <th>-QTY</th>
                                            <th>-QTY</th>
                                            <th>-QTY</th>
                                            <th>-QTY</th>
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

            // $('#tableReport').DataTable({
            //     "paging": false,
            //     "scrollY": "40vh",
            //     "lengthChange": true,
            //     "searching": true,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": false,
            //     "responsive": true,
            //     "createdRow": function (row, data, dataIndex) {
            //     },
            //     "initComplete" : function(){
            //     }
            // });
        });

        function viewReport() {
            tanggal = $('#tanggal').val().split(' - ');

            tgl1 = tanggal[0];
            tgl2 = tanggal[1];

            if ($.fn.DataTable.isDataTable('#tableReport')) {
                $('#tableReport').DataTable().destroy();
                $("#tableReport tbody [role='row']").remove();
            }

            $.ajax({
                url: '{{ url()->current() }}/view-report',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    'tgl1' : tgl1,
                    'tgl2' : tgl2,
                    'monitoringPLU' : $('#monitoringPLU').val(),
                    'dsi' : $('#dsi').val(),
                },
                beforeSend: function () {
                    // $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#tableReport').DataTable().destroy();

                    thead = '';
                    tr = '';

                    arrTahun = response.arrTahun;
                    arrBulan = response.arrBulan;
                    arrTanggal = response.arrTanggal;

                    $('#tableReport thead').empty();

                    thead += `<tr>
                                <th class="align-middle text-center" rowspan="4">PRDCD</th>
                                <th class="align-middle text-center" rowspan="4">DESKRIPSI</th>
                                <th class="align-middle text-center" rowspan="4">FRAC</th>
                                <th class="align-middle text-center" rowspan="2" colspan="2">PO</th>
                                <th class="align-middle text-center" rowspan="2" colspan="2">BPB</th>
                                <th class="align-middle text-center" rowspan="4">SL</th>
                                <th class="align-middle text-center" rowspan="4">AVG</th>`;

                    for(i=0;i<arrTahun.length;i++){
                        thead += `<th class="align-middle text-center" colspan="${arrTahun[i].qty}">${arrTahun[i].tahun}</th>`;
                    }

                    thead += `<th class="align-middle text-center" rowspan="2" colspan="4">EST. LOST SALES</th>
                            </tr>`;

                    thead += `<tr>`
                    for(i=0;i<arrBulan.length;i++){
                        thead += `<th class="align-middle text-center" colspan="${arrBulan[i].qty}">${ arrBulan[i].bulan }</th>`
                    }
                    thead += `</tr>`

                    thead += `<tr>
                                <th class="align-middle" rowspan="2">FRQ</th>
                                <th class="align-middle" rowspan="2">QTY</th>
                                <th class="align-middle" rowspan="2">FRQ</th>
                                <th class="align-middle" rowspan="2">QTY</th>`
                    for(i=0;i<arrTanggal.length;i++){
                        thead += `<th class="align-middle text-center">${ arrTanggal[i].substr(0,2) }</th>`
                    }
                    thead += `<th class="align-middle" rowspan="2">AVG/DSI</th>
                              <th class="align-middle text-center" rowspan="2">QTY</th>
                              <th class="align-middle" rowspan="2">HRG JUAL</th>
                              <th class="align-middle" rowspan="2">RUPIAH</th>
                            </tr>`

                    thead += `<tr>`
                    for(i=0;i<arrTanggal.length;i++){
                        thead += `<td class="text-center">QTY</td>`;
                    }
                    thead += `</tr>`

                    $('#tableReport thead').empty().append(thead);
                    $('#reportField').show();


                    data = response.customData;
                    for(i=0;i<data.length;i++){
                        tr = `
                            <tr>
                                <td>${data[i].sth_prdcd}</td>
                                <td class="text-nowrap">${ data[i].desk }</td>
                                <td class="text-right">${ data[i].frac }</td>
                                <td class="text-right">${ convertToRupiah2(data[i].frqpo) }</td>
                                <td class="text-right">${ convertToRupiah2(data[i].qtypo) }</td>
                                <td class="text-right">${ convertToRupiah2(data[i].frqbpb) }</td>
                                <td class="text-right">${ convertToRupiah2(data[i].qtybpb) }</td>
                                <td class="text-right">${ convertToRupiah2(data[i].sl) }</td>
                                <td class="text-right">${ nvl(convertToRupiah2(data[i].v_avg_qty, '-')) }</td>`;

                        for(j=0;j<arrTanggal.length;j++){
                            tr += `<td class="text-right">${ convertToRupiah2(data[i][arrTanggal[j]]) }</td>`;
                        }

                        tr += `<td class="text-right">${nvl(convertToRupiah2(data[i].avgdsi), '-')}</td>
                                    <td class="text-right">${ convertToRupiah2(data[i].qty) }</td>
                                    <td class="text-right">${ convertToRupiah2(data[i].hrgjual) }</td>
                                    <td class="text-right">${ convertToRupiah2(data[i].rupiah) }</td>
                                </tr>`;

                        $('#tableReport tbody').append(tr);
                    }

                    $('#tableReport').DataTable({
                        "paging": false,
                        "scrollX": true,
                        "scrollY": "37vh",
                        "lengthChange": true,
                        "searching": false,
                        "ordering": false,
                        "info": true,
                        "autoWidth": false,
                        "responsive": true,
                        "createdRow": function (row, data, dataIndex) {
                        },
                        "initComplete" : function(){
                        }
                    });
                },
                error: function (error) {
                    swal({
                        title: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {

                    });
                }
            });
        }

        function getData(){
            $('#tableReport').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/view-report',
                    "data" : {
                        'tgl1' : tgl1,
                        'tgl2' : tgl2,
                        'monitoringPLU' : $('#monitoringPLU').val(),
                        'dsi' : $('#dsi').val(),
                    },
                },
                "columns": [
                    {data: 'trjd_cus_kodemember'},
                    {data: 'cus_namamember'},
                    {data: null, render: function(data){
                            return convertToRupiah2(data.kunj);
                        }
                    },
                ],
                "paging": false,
                "scrollY": "40vh",
                "lengthChange": true,
                "searching": true,
                "ordering": false,
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
            tanggal = $('#tanggal').val().split(' - ');

            tgl1 = tanggal[0];
            tgl2 = tanggal[1];

            swal({
                title: 'Pilih format laporan!',
                icon: 'warning',
                buttons: {
                    pdf: 'PDF',
                    csv: 'CSV'
                },
                dangerMode: true,
            }).then(function(result){
                if(result == 'pdf'){
                    url = `{{ url()->current() }}/export-pdf?tgl1=${tgl1}&tgl2=${tgl2}&monitoringPLU=${$('#monitoringPLU').val()}&dsi=${$('#dsi').val()}`;
                }
                else if(result == 'csv'){
                    url = '{{ url()->current() }}/export-csv?tgl1='+tgl1+'&tgl2='+tgl2+'&group='+$('#group').val()+'&outlet='+$('#outlet').val()+'&suboutlet='+$('#suboutlet').val()+'&segmentasi='+$('#segmentasi').val()+'&monitoringMember='+$('#monitoringMember').val()+'&monitoringPLU='+$('#monitoringPLU').val()+'&member='+$('#member').val()+'&sort='+$('#sort').val();
                }
                if(result)
                    window.open(url);
            });
        }
    </script>

@endsection
