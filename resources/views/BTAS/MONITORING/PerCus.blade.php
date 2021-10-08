@extends('navbar')
@section('title','MONITORING PER CUSTOMER')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Monitoring Barang Titipan per Customer (Urut Tanggal Penitipan)</legend>
                    <div class="card-body shadow-lg cardForm">

                        <div class="p-0 tableFixedHeader" style="height: 250px;">
                            <table class="table table-sm table-striped table-bordered"
                                   id="table-header">
                                <thead>
                                <tr class="table-sm text-center">
                                    <th width="50%" class="text-center small">Nama Customer</th>
                                    <th width="15%" class="text-center small">Kode Customer</th>
                                    <th width="15%" class="text-center small">Tgl Penitipan</th>
                                    <th width="20%" class="text-center small">No Struk</th>
                                </tr>
                                </thead>
                                <tbody id="body-table-header" style="height: 250px;">
                                @for($i = 0 ; $i< sizeof($datas) ; $i++)
                                    <tr class="baris" onclick="SelectRow(this)">
                                        <td>{{$datas[$i]->cus_namamember}}</td>
                                        <td>{{$datas[$i]->sjh_kodecustomer}}</td>
                                        <?php
                                        $split = explode(' ',($datas[$i]->sjh_tglpenitipan));
                                        $split = explode('-',$split[0]);
                                        ?>
                                        <td>{{$split[2]}}/{{$split[1]}}/{{$split[0]}}</td>
                                        <td>{{$datas[$i]->viewstruk}}</td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-1" for="keterangan">Keterangan</label>
                                <input class="col-sm-4" id="keterangan" type="text" name="keterangan" disabled>
                            <span class="col-sm-1"> </span>
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
                        <label for="tanggalH" class="col-sm-2">Tgl Penitipan</label>
                        <input id="tanggalH" nama="tanggalH" class="form-control search_lov col-sm-3" type="text" disabled>
                        <label for="strukH" class="col-sm-1" style="margin-left: 60px;">Struk</label>
                        <input id="strukH" nama="strukH" class="form-control search_lov col-sm-4" type="text" disabled>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalTemplate">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>No. Urut</th>
                                        <th>Deskripsi</th>
                                        <th>UNIT</th>
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
        let kodeCust = [];
        let noSJAS = [];
        let frekTahapan = [];
        let tanggalTrn = [];
        let tanggalTitip = [];
        let noStruk = [];
        let struk = [];
        $(document).ready(function() {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/btas/monitoring/percus/getdata',
                type: 'post',
                success: function (result) {
                    for (i = 0; i< result.length; i++){
                        noSJAS[i] = result[i].sjh_nosjas;
                        frekTahapan[i] = result[i].sjh_frektahapan;
                        kodeCust[i] = result[i].sjh_kodecustomer;
                        tanggalTrn[i] = result[i].sjh_tglstruk;
                        tanggalTitip[i] = result[i].sjh_tglpenitipan;
                        noStruk[i] = result[i].viewstruk;
                        struk[i] = result[i].sjh_nostruk;
                    }
                }, error: function () {
                    alert('error');
                }
            })
        });

        $('.bigGuy').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        // $('#body-table-header').find('tr').click( function(){
        //     let temp = $(this).index();
        //     curTr = temp;
        //     if(noSJAS[temp] == null){
        //         $('#keterangan').val("Blm Pernah Diambil");
        //     }else{
        //         $('#keterangan').val("Sudah "+frekTahapan[temp]+" x Srt. Jalan");
        //     }
        // });

        function SelectRow(val){
            let row = val.rowIndex-1;
            curTr = row;
            if(noSJAS[row] == null){
                $('#keterangan').val("Blm Pernah Diambil");
            }else{
                $('#keterangan').val("Sudah "+frekTahapan[row]+" x Srt. Jalan");
            }
        }

        function GetDetail() {
            if(curTr == null){
                swal.fire('', "Tidak ada data yang dipilih !!", 'warning');
            }else{
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/btas/monitoring/percus/getdetail',
                    type: 'post',
                    data: {
                        kodeMember:kodeCust[curTr],
                        tanggalTrn:tanggalTrn[curTr],
                        noSJAS:noSJAS[curTr],
                        noStruk:noStruk[curTr]
                    },
                    success: function (result) {
                        $('.modalRow').remove();
                        for (i = 0; i< result.datas.length; i++){
                            qty = 0;
                            if(result.qty != null){
                                qty = result.qty[i].qty;
                            }
                            qtySisa = (result.datas[i].trjd_quantity)-qty;
                            $('#tbodyModalHelp').append("<tr class='modalRow'><td>"+ result.datas[i].trjd_seqno +"</td> <td>"+ result.datas[i].prd_deskripsipendek +"</td> <td>"+ result.datas[i].unit +"</td><td>"+result.datas[i].trjd_quantity+"</td><td>"+qty+"</td><td>"+qtySisa+"</td></tr>")
                        }
                        let date = tanggalTitip[curTr].substr(0,10);
                        date = date.split('-');
                        $('#tanggalH').val(date[2]+'-'+date[1]+'-'+date[0]);
                        $('#strukH').val(noStruk[curTr]);
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
                confirmButtonText: `NAMA CUSTOMER`,
                denyButtonText: `TGL PENITIPAN`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $('.baris').remove();
                    UrutCust();
                } else if (result.isDenied) {
                    $('.baris').remove();
                    UrutTgl();
                }
            })
        }
        function UrutCust(){
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/btas/monitoring/percus/sortcust',
                type: 'post',
                success: function (result) {
                    for (i = 0; i< result.length; i++){
                        noSJAS[i] = result[i].sjh_nosjas;
                        frekTahapan[i] = result[i].sjh_frektahapan;
                        kodeCust[i] = result[i].sjh_kodecustomer;
                        tanggalTrn[i] = result[i].sjh_tglstruk;
                        tanggalTitip[i] = result[i].sjh_tglpenitipan;
                        noStruk[i] = result[i].viewstruk;
                        struk[i] = result[i].sjh_nostruk;

                        $('#body-table-header').append("<tr class='baris' onclick='SelectRow(this)'><td>"+ result[i].cus_namamember +"</td> <td>"+ result[i].sjh_kodecustomer +"</td> <td>"+ formatDate(result[i].sjh_tglpenitipan) +"</td> <td>"+ result[i].viewstruk +"</td></tr>");
                    }
                }, error: function () {
                    alert('error');
                }
            })
        }
        function UrutTgl(){
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/btas/monitoring/percus/sorttgl',
                type: 'post',
                success: function (result) {
                    for (i = 0; i< result.length; i++){
                        noSJAS[i] = result[i].sjh_nosjas;
                        frekTahapan[i] = result[i].sjh_frektahapan;
                        kodeCust[i] = result[i].sjh_kodecustomer;
                        tanggalTrn[i] = result[i].sjh_tglstruk;
                        tanggalTitip[i] = result[i].sjh_tglpenitipan;
                        noStruk[i] = result[i].viewstruk;
                        struk[i] = result[i].sjh_nostruk;

                        $('#body-table-header').append("<tr class='baris' onclick='SelectRow(this)'><td>"+ result[i].cus_namamember +"</td> <td>"+ result[i].sjh_kodecustomer +"</td> <td>"+ formatDate(result[i].sjh_tglpenitipan) +"</td> <td>"+ result[i].viewstruk +"</td></tr>");
                    }
                }, error: function () {
                    alert('error');
                }
            })
        }

        function print() {
            swal.fire({
                title: 'Laporan Brg Titipan PerCustomer, Cetak Untuk ?',
                showDenyButton: true,
                confirmButtonText: `Semua Customer`,
                denyButtonText: `Customer Ini`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    ajaxSetup();
                    $.ajax({
                        url: '/BackOffice/public/btas/monitoring/percus/checkdata',
                        type: 'post',
                        data: {
                            all:'Y'
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (result) {
                            if(result.kode == '0'){
                                window.open('/BackOffice/public/btas/monitoring/percus/printdoc/Y/_/_','_blank');
                            }else{
                                swal.fire('', "tidak ada data", 'warning');
                            }

                            $('#modal-loader').modal('hide');
                        }, error: function (e) {
                            console.log(e);
                            alert('error');
                        }
                    })
                } else if (result.isDenied) {
                    if(curTr == null){
                        swal.fire('', "Tidak ada data yang dipilih !!", 'warning');
                        return false
                    }else{
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/btas/monitoring/percus/checkdata',
                            type: 'post',
                            data: {
                                all:'',
                                kodeMem:kodeCust[curTr],
                                struk:struk[curTr]

                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (result) {
                                if(result.kode == '0'){
                                    window.open('/BackOffice/public/btas/monitoring/percus/printdoc/_/'+kodeCust[curTr]+'/'+struk[curTr]+'','_blank');
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
                }
            })
        }
    </script>
@endsection
