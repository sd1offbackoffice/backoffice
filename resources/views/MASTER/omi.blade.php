@extends('navbar')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-11">
                <fieldset class="card border-dark">
                    <legend  class="w-auto ml-5">Master OMI</legend>
                    <div class="card-body cardForm">
                        <div class="row justify-content-center">
                            <div class="col-sm-12 col-md-5">
                                <form class="form">
                                    <div class="form-group row">
                                        <label for="chooseTypeOmi" class="col-sm-3 col-form-label">Kode SBU</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="chooseTypeOmi">
                                                <option value="M">M - MRO</option>
                                                <option value="K">K - KHUSUS</option>
                                                <option value="C">C - IDM CONV</option>
                                                <option value="O">O - OMI</option>
                                                <option value="I">I - IDM</option>
                                            </select>
                                        </div>
                                        <div class="sol-sm-3">
                                            <button type="button" class="btn btn-primary pl-4 pr-4" onclick="getTokoOmi()">Submit</button>
                                            {{--<button type="button" class="btn btn-success pl-4 pr-4" data-toggle="modal" data-target="#m_detailTokoOmi" onclick="getDetailOmi('MN03')">asd</button>--}}
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <hr width="50%" style="border: 1px solid rgba(0,0,0,0.3);">

                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-sm table-striped table-bordered display compact" id="tableTokoOmi">
                                    <thead style="background-color: #5AA4DD; color: white">
                                    <tr class=" thNormal">
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Fee</th>
                                        <th>Distribution Fee</th>
                                        <th>Kode</th>
                                        <th>Member</th>
                                        <th>Tgl Go</th>
                                        <th>Tgl Tutup</th>
                                        <th>Flag <br>  VB</th>
                                        <th>Flag <br>  Margin</th>
                                        <th>Sub Pemanjangan</th>
                                        <th>Sub CLO</th>
                                        <th>Sub Tipe</th>
                                        <th>Action</th>

                                        {{--<th width="20px">Kode</th>--}}
                                        {{--<th width="130px">Nama</th>--}}
                                        {{--<th width="20px">Fee</th>--}}
                                        {{--<th width="50px">Distribution Fee</th>--}}
                                        {{--<th width="30px">Kode</th>--}}
                                        {{--<th width="110px">Member</th>--}}
                                        {{--<th width="40px">Tgl Go</th>--}}
                                        {{--<th width="40px">Tgl Tutup</th>--}}
                                        {{--<th width="20px">Flag <br>  VB</th>--}}
                                        {{--<th width="20px">Flag <br>  Margin</th>--}}
                                        {{--<th width="40px">Sub Pemanjangan</th>--}}
                                        {{--<th width="20px">Sub CLO</th>--}}
                                        {{--<th width="20px">Sub Tipe</th>--}}
                                        {{--<th width="30px">Action</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyTableOmi"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="m_detailTokoOmi" tabindex="-1" role="dialog" aria-labelledby="m_detailTokoOmiHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs" id="myTabDetailTokoOmi" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="identityOmi-tab" data-toggle="tab" href="#identityOmi" role="tab" aria-controls="identity" aria-selected="true">Identity</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="detailOmi-tab" data-toggle="tab" href="#detailOmi" role="tab" aria-controls="detail" aria-selected="false">Detail</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pajakOmi-tab" data-toggle="tab" href="#pajakOmi" role="tab" aria-controls="pajak" aria-selected="false">Pajak</a>
                                    </li>
                                    {{--<li class="nav-item">--}}
                                        {{--<a class="nav-link" id="perjanjianOmi-tab" data-toggle="tab" href="#perjanjianOmi" role="tab" aria-controls="perjanjian" aria-selected="false">Perjanjian</a>--}}
                                    {{--</li>--}}
                                </ul>

                                <div class="tab-content" id="myTabContentDetailTokoOmi">
                                    <div class="tab-pane fade show active" id="identityOmi" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="card">
                                            <div class="card-body border-dark cardEditTokoOmi">
                                                <form class="form">
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Kode Cabang (OMI)</label>
                                                        <input type="text" id="kodeOmi" class="form-control col-sm-2 mx-sm-1" onchange="getDetailOmi(this.value)" onkeyup="convertToUpper(this.value, this.id)">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Nama Cabang (OMI)</label>
                                                        <input type="text" id="namaOmi" class="form-control col-sm-5 mx-sm-1">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Kode IGR</label>
                                                        <input type="text" id="kodeIgr" class="form-control col-sm-1 mx-sm-1" onchange="getBranchName(this.value)">
                                                        <input type="text" id="namaCabang" class="form-control col-sm-4 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Flag Distant Fee</label>
                                                        <select class="form-control col-sm-1 mx-sm-1" id="flagFee">
                                                            <option value="Y">Y</option>
                                                            <option value="N">N</option>
                                                        </select>
                                                        <label class="col-sm-2 col-form-label text-md-right">Flag VB</label>
                                                        <select class="form-control col-sm-1 mx-sm-1" id="flagVb">
                                                            <option value="Y">Y</option>
                                                            <option value="N">N</option>
                                                        </select>
                                                        <label class="col-sm-2 col-form-label text-md-right flagKph">Flag KPH</label>
                                                        <select class="form-control col-sm-1 mx-sm-1 flagKph" id="flagKph">
                                                            <option value="Y">Y</option>
                                                            <option value="N">N</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Customer</label>
                                                        <input type="text" id="kodeCust" class="form-control col-sm-2 mx-sm-1" onchange="getCustomerName(this.value)" onkeyup="convertToUpper(this.value, this.id)">
                                                        <input type="text" id="namaCust" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Tgl Go</label>
                                                        <input type="date" id="tglGo" class="form-control col-sm-3 mx-sm-1">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Tgl Tutup</label>
                                                        <input type="date" id="tglTutup" class="form-control col-sm-3 mx-sm-1">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> {{--Close for class "tab-identityomi"--}}

                                    <div class="tab-pane fade" id="detailOmi" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="card">
                                            <div class="card-body border-dark cardEditTokoOmi">
                                                <form class="form">
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Kode Member</label>
                                                        <input type="text" id="kodeDetailCust" class="form-control col-sm-2 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Nama Member</label>
                                                        <input type="text" id="namaDetailCust" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Alamat</label>
                                                        <input type="text" id="alamatDetail1" class="form-control col-sm-7 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right"></label>
                                                        <input type="text" id="alamatDetail2" class="form-control col-sm-3 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right"></label>
                                                        <input type="text" id="alamatDetail3" class="form-control col-sm-4 mx-sm-1" disabled>
                                                        <input type="text" id="alamatDetail4" class="form-control col-sm-2 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Telephone</label>
                                                        <input type="text" id="tlpDetail" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">NPWP</label>
                                                        <input type="text" id="npwpDetail" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>

                                                    <br>

                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Status Toko</label>
                                                        <select class="form-control col-sm-3 mx-sm-1" id="statusToko">
                                                            <option value="1">1 - Perumahan</option>
                                                            <option value="2">2 - Pertokoan</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Jam Buka</label>
                                                        <input type="text" id="jamBuka" class="form-control col-sm-2 mx-sm-1" placeholder="hh:mi:ss"  onchange="converttime(this.value, this.id)">
                                                        <label class="col-sm-1 col-form-label text-md-right">s/d</label>
                                                        <input type="text" id="jamTutup" class="form-control col-sm-2 mx-sm-1" placeholder="hh:mi:ss" onchange="converttime(this.value, this.id)">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Jadwal Kirim Barang</label>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari1">
                                                            <label class="" for="defaultCheck1">Mng</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari2">
                                                            <label class="" for="defaultCheck1">Sen</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari3">
                                                            <label class="" for="defaultCheck1">Sel</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari4">
                                                            <label class="" for="defaultCheck1">Rab</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari5">
                                                            <label class="" for="defaultCheck1">Kam</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari6">
                                                            <label class="" for="defaultCheck1">Jum</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari7">
                                                            <label class="" for="defaultCheck1">Sab</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Tgl Update Jadwal</label>
                                                        <input type="date" id="tglUpdate" class="form-control col-sm-3 mx-sm-1">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Flag Edit PB di Toko</label>
                                                        <select class="form-control col-sm-1 mx-sm-1" id="flagPB">
                                                            <option value="Y">Y</option>
                                                            <option value="N">N</option>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> {{--Close for class "tab-detailomi"--}}

                                    <div class="tab-pane fade" id="pajakOmi" role="tabpanel" aria-labelledby="contact-tab">
                                        <div class="card">
                                            <div class="card-body border-dark cardEditTokoOmi">
                                                <form class="form">
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">No. Depan FP</label>
                                                        <input type="text" id="tipeOmi" class="form-control col-sm-7 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">No. NPWP</label>
                                                        <input type="text" id="npwp" class="form-control col-sm-7 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">Tanggal Tax</label>
                                                        <input type="text" id="tanggalTax" class="form-control col-sm-7 mx-sm-1" disabled>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>{{--Close for class "tab-pajakOmi"--}}

                                    <div>
                                        {{--*************DICOMMENT KARENA DI IAS ORACLE JUGA DICOMMENT************--}}
                                        {{--<div class="tab-pane fade" id="perjanjianOmi" role="tabpanel" aria-labelledby="contact-tab">--}}
                                        {{--<div class="card">--}}
                                        {{--<div class="card-body border-dark cardEditTokoOmi">--}}
                                        {{--<form class="form">--}}
                                        {{--<div class="form-group row mb-0">--}}
                                        {{--<label class="col-sm-4 col-form-label text-md-right">Kode Perjanjian</label>--}}
                                        {{--<input type="text" id="#" class="form-control col-sm-7 mx-sm-1">--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group row mb-0">--}}
                                        {{--<label class="col-sm-4 col-form-label text-md-right">Periode Awal</label>--}}
                                        {{--<input type="date" id="#" class="form-control col-sm-7 mx-sm-1">--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group row mb-0">--}}
                                        {{--<label class="col-sm-4 col-form-label text-md-right">Periode Akhir</label>--}}
                                        {{--<input type="date" id="#" class="form-control col-sm-7 mx-sm-1">--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group row mb-0">--}}
                                        {{--<label class="col-sm-4 col-form-label text-md-right">Amount</label>--}}
                                        {{--<input type="text" id="#" class="form-control col-sm-7 mx-sm-1">--}}
                                        {{--</div>--}}
                                        {{--<div class="form-group row mb-0">--}}
                                        {{--<label class="col-sm-4 col-form-label text-md-right">Tgl Tagih</label>--}}
                                        {{--<input type="date" id="#" class="form-control col-sm-7 mx-sm-1">--}}
                                        {{--</div>--}}
                                        {{--</form>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}{{--Close for class "tab-PerjajianOmi"--}}
                                    </div>

                                </div> {{--Close for class "tab-content"--}}
                            </div> {{--Close for class "col-sm-12"--}}
                        </div> {{--Close for class "row"--}}
                    </div> {{--Close for class "container"--}}
                </div> {{--Close for class "modal-body"--}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary pl-4 pr-4" onclick="editTokoOmi()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cardEditTokoOmi{
            height: 525px;
        }
    </style>

    <script>

        $(document).ready(function () {
            $('#tableTokoOmi').DataTable({
                "lengthChange": false,
                "ordering" : false,
                scrollY : 500,
            });
            $('.flagKph').hide();
            // $('#m_detailTokoOmi').modal('show');

        });

        function editTokoOmi() {
            let hari="";
            for(i=1; i<8; i++){
                if ($('#hari'+i).is(":checked")){
                    hari = hari+'Y';
                } else {
                    hari = hari+'_';
                }
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstomi/updatetokoomi',
                type: 'post',
                data:{
                    kodeOmi:$('#kodeOmi').val(),
                    namaOmi:$('#namaOmi').val(),
                    kodeIgr:$('#kodeIgr').val(),
                    flagFee:$('#flagFee').val(),
                    flagVb:$('#flagVb').val(),
                    flagKph:$('#flagKph').val(),
                    kodeCust:$('#kodeCust').val(),
                    tglGo:$('#tglGo').val(),
                    tglTutup:$('#tglTutup').val(),
                    statusToko:$('#statusToko').val(),
                    jamBuka:$('#jamBuka').val(),
                    jamTutup:$('#jamTutup').val(),
                    tglUpdate:$('#tglUpdate').val(),
                    flagPB:$('#flagPB').val(),
                    hari:hari,
                },
                success: function (result) {
                    swal('Success', result, 'success');
                    $('#m_detailTokoOmi').modal('hide');
                    getTokoOmi();
                }, error: function () {
                    swal("Error",'','error');
                }
            })
        }

        function getCustomerName(member) {
            if(!member){
                swal("Error","Kode Member Tidak boleh Kosong", "error");
            } else {
                $.ajax({
                    url: '/BackOffice/public/mstomi/getcustomername',
                    type: 'POST',
                    data: {member:member},
                    success: function (result) {
                        if (result.length ===0){
                            swal("Error","Kode Member Tidak Terdaftar !!!", "error");
                        } else {
                            $('#namaCust').val(result[0].cus_namamember);
                        }

                    }, error: function () {
                        swal("Error","","error");
                    }
                })
            }
        }

        function getBranchName(kodeIgr) {
            if(!kodeIgr){
                swal("Error","Kode Indogrosir Tidak boleh Kosong", "error");
            } else {
                $.ajax({
                    url: '/BackOffice/public/mstomi/getbranchname',
                    type: 'POST',
                    data: {kodeIgr: kodeIgr},
                    success: function (result) {
                        if (result.length ===0){
                            swal("Error","Kode Indogrosir Tidak Terdaftar !!!", "error");
                        } else {
                            $('#namaCabang').val(result[0].cab_namacabang);
                        }

                    }, error: function () {
                        swal("Error","","error");
                    }
                })
            }
        }

        function getDetailOmi(kodeOmi) {
            clearField();
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstomi/edittokoomi',
                type: 'POST',
                data:{kodeOmi:kodeOmi},
                success: function (result) {
                    let identity= result.identity[0];
                    let detail  = result.detail[0];

                    $('#kodeOmi').val(identity.tko_kodeomi);
                    $('#namaOmi').val(identity.tko_namaomi);
                    $('#kodeIgr').val(identity.tko_kodeigr);
                    $('#namaCabang').val(identity.cab_namacabang);
                    $('#flagFee').val(identity.tko_flagdistfee);
                    $('#flagVb').val(identity.tko_flagvb);
                    $('#flagKph').val(identity.tko_flagkph);
                    $('#kodeCust').val(identity.tko_kodecustomer);
                    $('#namaCust').val(identity.cus_namamember);
                    $('#tglGo').val(convertDate(identity.tko_tglgo));
                    $('#tglTutup').val(convertDate(identity.tko_tgltutup));

                    $('#kodeDetailCust').val(detail.cus_kodemember);
                    $('#namaDetailCust').val(detail.cus_namamember);
                    $('#alamatDetail1').val(detail.cus_alamatmember1);
                    $('#alamatDetail2').val(detail.cus_alamatmember4);
                    $('#alamatDetail3').val(detail.cus_alamatmember2);
                    $('#alamatDetail4').val(detail.cus_alamatmember3);
                    $('#tlpDetail').val(detail.cus_tlpmember);
                    $('#npwpDetail').val(detail.cus_npwp);
                    $('#statusToko').val(identity.tko_statustoko);
                    $('#jamBuka').val(identity.tko_jambukatoko);
                    $('#jamTutup').val(identity.tko_jamtutuptoko);
                    $('#tglUpdate').val(convertDate(identity.tko_tglberlakujadwal));
                    $('#flagPB').val(identity.tko_flageditpb);

                    for(let i =0; i<identity.tko_jadwalkirimbrg.length; i++){
                        if (identity.tko_jadwalkirimbrg[i] === 'Y'){
                            $('#hari'+(i+1)).prop('checked', true)
                        }
                    }

                    $('#tipeOmi').val(identity.tko_tipeomi);
                    $('#npwp').val(identity.cus_npwp);
                    $('#tanggalTax').val(identity.cus_tglpajak);
                }, error: function () {
                    alert('error');
                }
            })
        }

        function getTokoOmi() {
            let kodeSBU = $('#chooseTypeOmi').val();

            if (kodeSBU === 'M' || kodeSBU === 'O'){
                $('.flagKph').hide();
            } else {
                $('.flagKph').show();
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstomi/gettokoomi',
                type: 'POST',
                data: {kodeSBU:kodeSBU},
                success: function (result) {
                    $('#tableTokoOmi').DataTable().clear();

                    if (result.length === 0){
                        $('#tableTokoOmi').DataTable().row.add(["-","-","-","-","-","-","-","-","-","-","-","-","-", "-"]).draw();
                    } else  {
                        for(i = 1; i< result.length; i++){
                            $('#tableTokoOmi').DataTable().row.add(
                                [result[i].tko_kodeomi, result[i].tko_namaomi, result[i].tko_flagdistfee, result[i].tko_persendistributionfee,
                                    result[i].tko_kodecustomer, result[i].cus_namamember, convertDate(result[i].tko_tglgo), convertDate(result[i].tko_tgltutup),
                                    result[i].tko_flagvb, result[i].tko_persenmargin, result[i].tko_flagsubsidipemanjangan, result[i].tko_flagcreditlimitomi,
                                    result[i].tko_tipeomi, "<button class='btn btn-success btn-block text-center' data-toggle='modal' data-target='#m_detailTokoOmi' onclick='getDetailOmi(`"+ result[i].tko_kodeomi +"`)'>Edit</button>"
                                ]).draw();
                        }
                    }
                }, error: function () {
                    console.log('error');
                }
            })
        }

        function convertDate(date) {
            if (!date){
                return date;
            } else {
                return date.substr(0,10);
            }
        }

        function converttime(time, id) {
            let temp = "";
            if (time.length < 6){
                swal("Error", "Masukan 6 digit angka", "error");
                return false;
            } else  {
                let number = /^[0-9]+$/;
                for (i=0; i< time.length; i++){
                    if(time[i].match(number)){
                        temp = temp+time[i];
                    }
                }
                let result = temp[0]+temp[1]+':'+temp[2]+temp[3]+':'+temp[4]+temp[5];
                $('#'+id).val(result);
            }

        }

        function clearField() {
            $('#kodeOmi').val('');
            $('#namaOmi').val('');
            $('#kodeIgr').val('');
            $('#namaCabang').val('');
            $('#flagFee').val('');
            $('#flagVb').val('');
            $('#flagKph').val('');
            $('#kodeCust').val('');
            $('#namaCust').val('');
            $('#tglGo').val('');
            $('#tglTutup').val('');

            $('#kodeDetailCust').val('');
            $('#namaDetailCust').val('');
            $('#alamatDetail1').val('');
            $('#alamatDetail2').val('');
            $('#alamatDetail3').val('');
            $('#alamatDetail4').val('');
            $('#tlpDetail').val('');
            $('#npwpDetail').val('');
            $('#statusToko').val('');
            $('#jamBuka').val('');
            $('#jamTutup').val('');
            $('#tglUpdate').val('');
            $('#flagPB').val('');

            for(let i =1; i<8; i++){
                $('#hari'+(i)).prop('checked', false)
            }

            $('#tipeOmi').val('');
            $('#npwp').val('');
            $('#tanggalTax').val('');
        }
    </script>




@endsection
