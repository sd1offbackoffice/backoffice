@extends('navbar')
@section('title','Approval Member Platinum')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5">Approving Customer Platinum</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                            <br>
                            <div class="row">
                                <div class="col-sm-6 align-self-center">
                                    <div class="d-flex justify-content-center">
                                        <label>Tahun&nbsp;&nbsp;&nbsp; : &nbsp;<input type="text" id="tahun" style="background-color: lightgray; text-align: center; color: black" disabled></label>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <label>Periode : &nbsp;<input type="text" id="periode" style="background-color: lightgray; text-align: center; color: black" disabled></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex justify-content-center p-0 tableFixedHeader" style="height: 150px;">
                                        <table class="table table-sm table-striped table-bordered" id="table-header">
                                            <thead>
                                                <tr class="table-sm text-center">
                                                    <th width="10%">ID</th>
                                                    <th width="30%">Keterangan</th>
                                                    <th width="30%">Min Transaksi</th>
                                                    <th width="30%">Max Transaksi</th>
                                                </tr>
                                            </thead>
                                            <tbody style="height: 250px;">
                                            @for($i=0;$i<sizeof($segmentasi);$i++)
                                                <tr>
                                                    <td>{{$segmentasi[$i]->seg_id}}</td>
                                                    <td>{{$segmentasi[$i]->seg_nama}}</td>
                                                    <td>{{$segmentasi[$i]->seg_mintrx}}</td>
                                                    <td>{{$segmentasi[$i]->seg_maxtrx}}</td>
                                                </tr>
                                            @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <fieldset class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="d-flex justify-content-center p-0 tableFixedHeader" style="height: 300px;">
                            <table class="table table-sm table-striped table-bordered" id="table-header">
                                <thead>
                                <tr class="table-sm text-center">
                                    <th width="15%">Kode Member</th>
                                    <th width="20%">Segmentasi Lama</th>
                                    <th width="20%">Ket</th>
                                    <th width="10%"> </th>
                                    <th width="10%"> </th>
                                    <th width="10%"> </th>
                                    <th width="15%"> </th>
                                </tr>
                                </thead>
                                <tbody id="mainTable" style="height: 250px; text-align: center; vertical-align: middle">
                                @for($i=0;$i<sizeof($datas);$i++)
                                    <tr onclick="shownama(this)">
                                        <td>{{$datas[$i]->sgc_kd_member}}</td>
                                        <td>{{$datas[$i]->sgc_lampau}}</td>
                                        <td><input class="namaseg" type="text" disabled value="TETAP {{$nama_seg[$i]->seg_nama}}"></td>
                                        <td><input onchange="radHandler(this)" type="radio" name="rad{{$i}}" id="turun{{$i}}" value="turun">
                                            <label>Turun</label></td>
                                        <td><input onchange="radHandler(this)" type="radio" name="rad{{$i}}" id="tetap{{$i}}" value="tetap" checked>
                                            <label>Tetap</label></td>
                                        <td><input onchange="radHandler(this)" type="radio" name="rad{{$i}}" id="naik{{$i}}" value="naik">
                                            <label>Naik</label></td>
                                        <td><button type="button" class="btn btn-primary btn-block" onclick="approve(this)">APPROVE</button></td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row">
                            <input id="namaMember" class="col-sm-8" type="text" disabled>
                            <span class="col-sm-4">*Pilih untuk menurunkan/menaikkan <br>segmentasi member/ tetap</span>
                        </div>
                        <br>
{{--                        <button class="btn btn-success btn-block float-right col-sm-3">CETAK LAPORAN</button>--}}
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <style>
        td input{
            border: none;
            text-align: center;
            color: black;
        }
    </style>

    <script src={{asset('/js/sweetalert2.js')}}></script>
    <script>
        let tempDatas;
        let namaMember;
        let namaSeg;
        let auth;
        $(document).ready(function() {
            let d = new Date();
            let month = d.getMonth()+1;
            let periode = 1;
            month = ((''+month).length<2 ? '0' : '') + month;
            if(month > 6){
                periode = 2;
            }
            let year = d.getFullYear();

            $('#tahun').val(year);
            $('#periode').val(periode);

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/frontoffice/amp/getdata',
                type: 'post',
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    tempDatas = result.datas;
                    namaSeg = result.namaseg;
                    auth = result.auth;
                    namaMember = result.namaMember;

                    $('#modal-loader').modal('hide');
                }, error: function () {
                    alert('error');
                }
            })
        });

        function radHandler(val){
            let index = val.parentNode.parentNode.rowIndex-1;
            let rad = val.value;
            let updn = 'TURUN';
            if(tempDatas[index].sgc_default == 6){
                updn = 'NAIK'
            }
            if(rad == "turun" && updn == 'NAIK'){
                swal.fire('Member tidak bisa diturunkan, tidak sesuai perhitungan!','','warning');
                $("#"+rad+index).prop("checked", false);
                $("#tetap"+index).prop("checked", true);
                let w;
                for(i=0;i<namaSeg.length;i++){
                    if(tempDatas[index].sgc_lampau == namaSeg[i].seg_id){
                        w = namaSeg[i].seg_nama;
                        break;
                    }
                }
                $('.namaseg')[index].value = 'TETAP ' + w;
                return false;
            }else if(rad == "naik" && updn == 'TURUN'){
                swal.fire('Member sudah Platinum, tidak bisa dinaikkan lagi!','','warning');
                $("#"+rad+index).prop("checked", false);
                $("#tetap"+index).prop("checked", true);
                let w;
                for(i=0;i<namaSeg.length;i++){
                    if(tempDatas[index].sgc_lampau == namaSeg[i].seg_id){
                        w = namaSeg[i].seg_nama;
                        break;
                    }
                }
                $('.namaseg')[index].value = 'TETAP ' + w;
                return false;
            }
        //    --++ISI KET++--
            if(rad == "turun"){
                let w;
                for(i=0;i<namaSeg.length;i++){
                    if(tempDatas[index].sgc_default == namaSeg[i].seg_id){
                        w = namaSeg[i].seg_nama;
                        break;
                    }
                }
                $('.namaseg')[index].value = 'PLATINUM -> ' + w;
            }
            if(rad == "tetap"){
                let w;
                for(i=0;i<namaSeg.length;i++){
                    if(tempDatas[index].sgc_lampau == namaSeg[i].seg_id){
                        w = namaSeg[i].seg_nama;
                        break;
                    }
                }
                $('.namaseg')[index].value = 'TETAP ' + w;
            }
            if(rad == "naik"){
                let w;
                for(i=0;i<namaSeg.length;i++){
                    if(tempDatas[index].sgc_lampau == namaSeg[i].seg_id){
                        w = namaSeg[i].seg_nama;
                        break;
                    }
                }
                $('.namaseg')[index].value = w + ' -> PLATINUM';
            }
        }

        function shownama(val){
            let index = val.rowIndex-1;
            $('#namaMember').val(namaMember[index].cus_namamember);
        }

        function approve(val){
            let index = val.parentNode.parentNode.rowIndex-1;
            if(auth){
                let updn = 'TURUN';
                if(tempDatas[index].sgc_default == 6){
                    updn = 'NAIK'
                }
                if(updn == 'NAIK'){
                    if(document.getElementById("tetap"+index).checked){
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/amp/updatedata',
                            type: 'post',
                            data: {
                                kd_member:tempDatas[index].sgc_kd_member,
                                sgc_tahun:$('#tahun').val(),
                                sgc_periode:$('#periode').val(),
                                rekomendasi:tempDatas[index].sgc_rekomendasi
                            },
                            success: function (result) {
                                swal.fire('Data berhasil di update','','info');
                                location.reload();
                            }, error: function () {
                                alert('error');
                            }
                        })
                    }else if(document.getElementById("naik"+index).checked){
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/amp/updatedata2',
                            type: 'post',
                            data: {
                                kd_member:tempDatas[index].sgc_kd_member,
                                sgc_tahun:$('#tahun').val(),
                                sgc_periode:$('#periode').val()
                            },
                            success: function (result) {
                                swal.fire('Data berhasil di update','','info');
                                location.reload();
                            }, error: function () {
                                alert('error');
                            }
                        })
                    }
                }else if(updn == 'TURUN'){
                    if(document.getElementById("tetap"+index).checked){
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/amp/updatedata3',
                            type: 'post',
                            data: {
                                kd_member:tempDatas[index].sgc_kd_member,
                                sgc_tahun:$('#tahun').val(),
                                sgc_periode:$('#periode').val()
                            },
                            success: function (result) {
                                swal.fire('Data berhasil di update','','info');
                                location.reload();
                            }, error: function () {
                                alert('error');
                            }
                        })
                    }else if(document.getElementById("turun"+index).checked){
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/amp/updatedata4',
                            type: 'post',
                            data: {
                                kd_member:tempDatas[index].sgc_kd_member,
                                sgc_tahun:$('#tahun').val(),
                                sgc_periode:$('#periode').val(),
                                deflt:tempDatas[index].sgc_default
                            },
                            success: function (result) {
                                swal.fire('Data berhasil di update','','info');
                                location.reload();
                            }, error: function () {
                                alert('error');
                            }
                        })
                    }
                }

            }else{
                swal.fire('Anda Tidak Berhak meng-Approve Segmentasi Member Platinum','','warning');
            }
        }
    </script>
@endsection
