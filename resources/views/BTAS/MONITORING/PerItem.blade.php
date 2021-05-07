@extends('navbar')
@section('title','MONITORING PER CUSTOMER')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Posisi Barang Titipan</legend>--}}
                    <div class="card-body shadow-lg cardForm">

                        <div class="p-0 tableFixedHeader" style="height: 250px;">
                            <table class="table table-sm table-striped table-bordered"
                                   id="table-header">
                                <thead>
                                <tr class="table-sm text-center">
                                    <th width="10%" class="text-center small">PLU</th>
                                    <th width="40%" class="text-center small">Deskripsi</th>
                                    <th width="10%" class="text-center small">UNIT</th>
                                    <th width="10%" class="text-center small">Qty Titipan</th>
                                    <th width="10%" class="text-center small">Qty SJ</th>
                                    <th width="10%" class="text-center small">Qty Sisa</th>
                                    <th width="10%" class="text-center small">Penitip</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-header" style="height: 250px;">
                                @for($i = 0 ; $i< sizeof($datas) ; $i++)
                                    <tr class="baris" onclick="SelectRow(this)">
                                        <td>{{$datas[$i]->trjd_prdcd}}</td>
                                        <td>{{$datas[$i]->prd_deskripsipendek}}</td>
                                        <td>{{$datas[$i]->prd_unit}}/{{$datas[$i]->prd_frac}}</td>
                                        <td style="text-align: right">{{$datas[$i]->struk}}</td>
                                        <td style="text-align: right">{{$qtysj[$i]}}</td>
                                        <td style="text-align: right">{{($datas[$i]->struk)-$qtysj[$i]}}</td>
                                        <td style="text-align: center">{{$datas[$i]->cust}} Customer</td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row">
                            <span class="col-sm-1"> </span>
                            <input class="col-sm-3" id="jmlItem" style="text-align: center" type="text" disabled value="{{sizeof($datas)}} ITEM">
                            <span class="col-sm-2"> </span>
                            <button class="col-sm-2 btn btn-primary" onclick="Urut()">View Urut</button>
                            <button class="col-sm-2 btn btn-primary" onclick="GetDetail()">Detail Per Item</button>
                            <button class="col-sm-2 btn btn-success" onclick="print()">Laporan</button>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    {{--Modal--}}
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="modalHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <label for="descid" class="col-sm-2">Deskripsi</label>
                        <input id="descid" nama="descid" class="form-control search_lov col-sm-6" type="text" disabled>
                        <input id="pluid" nama="pluid" class="form-control search_lov col-sm-2" type="text" disabled>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalTemplate">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Customer</th>
                                        <th>Struk</th>
                                        <th>Tgl Penitipan</th>
                                        <th>Qty Titipan</th>
                                        <th>Qty SJ</th>
                                        <th>Qty Sisa</th>
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

    <script src={{asset('/js/sweetalert2.js')}}></script>
    <script>
        let curTr = null;
        let prdcd = [];
        let unit = [];
        let itemDesc = [];
        $(document).ready(function() {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/btas/monitoring/peritem/getdata',
                type: 'post',
                success: function (result) {
                    for (i = 0; i< result.datas.length; i++){
                        prdcd[i] = result.datas[i].trjd_prdcd;
                        itemDesc[i] = result.datas[i].prd_deskripsipendek;
                        unit[i] = result.datas[i].prd_unit;
                    }
                }, error: function () {
                    alert('error');
                }
            })
        });

        function SelectRow(val){
            let row = val.rowIndex-1;
            curTr = row;
        }

        function GetDetail() {
            if(curTr == null){
                swal.fire('', "Tidak ada data yang dipilih !!", 'warning');
            }else{
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/btas/monitoring/peritem/getdetail',
                    type: 'post',
                    data: {
                        prdcd:prdcd[curTr]
                    },
                    success: function (result) {
                        $('.modalRow').remove();
                        for (i = 0; i< result.datas.length; i++){
                            $('#tbodyModalHelp').append("<tr class='modalRow'><td>"+ result.cust[i] +"</td> <td>"+ result.datas[i].modelstruk +"</td> <td>"+ formatDate(result.datas[i].sjh_tglpenitipan) +"</td><td>"+result.titip[i]+"</td><td>"+result.qtysj[i]+"</td><td>"+result.qtysisa[i]+"</td></tr>")
                        }
                        $('#descid').val(itemDesc[curTr]+' '+unit[i]);
                        $('#pluid').val(prdcd[curTr]);
                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        function Urut(){
            swal.fire({
                title: 'MONITORING URUT BERDASARKAN',
                showDenyButton: true,
                confirmButtonText: `ITEM PLU`,
                denyButtonText: `DESKRIPSI`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    UrutPlu();
                } else if (result.isDenied) {
                    UrutDesc();
                }
            })
        }
        function UrutPlu(){
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/btas/monitoring/peritem/getdata',
                type: 'post',
                success: function (result) {
                    $('.baris').remove();
                    for (i = 0; i< result.datas.length; i++){
                        prdcd[i] = result.datas[i].trjd_prdcd;
                        itemDesc[i] = result.datas[i].prd_deskripsipendek;
                        sisa = (result.datas[i].struk)-(result.qtysj[i]);

                        $('#body-table-header').append("<tr class='baris' onclick='SelectRow(this)'><td>"+ result.datas[i].trjd_prdcd +"</td> <td>"+ result.datas[i].prd_deskripsipendek +"</td> <td>"+ result.datas[i].prd_unit +"/"+ result.datas[i].prd_frac +"</td> <td style='text-align: right'>"+ result.datas[i].struk +"</td><td style='text-align: right'>"+result.qtysj[i]+"</td><td style='text-align: right'>"+sisa+"</td><td style='text-align: center'>"+result.datas[i].cust+" Customer</td> </tr>");
                    }
                    $('#jmlItem').val((result.datas.length)+" ITEM");
                }, error: function () {
                    alert('error');
                }
            })
        }
        function UrutDesc(){
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/btas/monitoring/peritem/sortdesc',
                type: 'post',
                success: function (result) {
                    $('.baris').remove();
                    for (i = 0; i< result.datas.length; i++){
                        prdcd[i] = result.datas[i].trjd_prdcd;
                        itemDesc[i] = result.datas[i].prd_deskripsipendek;
                        sisa = (result.datas[i].struk)-(result.qtysj[i]);

                        $('#body-table-header').append("<tr class='baris' onclick='SelectRow(this)'><td>"+ result.datas[i].trjd_prdcd +"</td> <td>"+ result.datas[i].prd_deskripsipendek +"</td> <td>"+ result.datas[i].prd_unit +"/"+ result.datas[i].prd_frac +"</td> <td style='text-align: right'>"+ result.datas[i].struk +"</td><td style='text-align: right'>"+result.qtysj[i]+"</td><td style='text-align: right'>"+sisa+"</td><td style='text-align: center'>"+result.datas[i].cust+" Customer</td> </tr>");
                    }
                    $('#jmlItem').val((result.datas.length)+" ITEM");
                }, error: function () {
                    alert('error');
                }
            })
        }

        function print() {
            swal.fire({
                title: 'Cetak Laporan Posisi Barang Per Item',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: `YA`,
                cancelButtonText: `TIDAK`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    ajaxSetup();
                    $.ajax({
                        url: '/BackOffice/public/btas/monitoring/peritem/checkdata',
                        type: 'post',
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (result) {
                            if(result.kode == '0'){
                                window.open('/BackOffice/public/btas/monitoring/peritem/printdoc','_blank');
                            }else{
                                swal.fire('', "tidak ada data", 'warning');
                            }

                            $('#modal-loader').modal('hide');
                        }, error: function (e) {
                            console.log(e);
                            alert('error');
                        }
                    })
                }
            })
        }
    </script>
@endsection
