@extends('navbar')
@section('title','MASTER | MASTER OMI')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="row justify-content-center">
                            <div class="col-sm-12 col-md-5">
                                <form class="form">
                                    <div class="form-group row">
                                        <label for="chooseTypeOmi" class="col-sm-3 col-form-label">@lang('Kode SBU')</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="chooseTypeOmi">
                                                <option value="M">@lang('M - MRO')</option>
                                                <option value="K">@lang('K - CHARMANT')</option>
                                                <option value="C">@lang('C - IDM CONV')</option>
                                                <option value="O" selected>@lang('O - OMI')</option>
                                                <option value="I">@lang('I - IDM')</option>
                                            </select>
                                        </div>
                                        <div class="sol-sm-3">
                                            <button type="button" class="btn btn-primary pl-4 pr-4" onclick="getTokoOmi()">@lang('Pilih')</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <hr width="50%" style="border: 1px solid rgba(0,0,0,0.3);">

                        <div class="row" style="max-height: 65vh; overflow-y: scroll">
                            <div class="col-sm-12">
                                <table class="table table-sm table-striped table-bordered display compact" id="tableTokoOmi">
                                    <thead style="background-color: #5AA4DD; color: white">
                                    <tr class=" thNormal">
                                        <th>@lang('Kode')</th>
                                        <th>@lang('Nama')</th>
                                        <th>@lang('Fee')</th>
                                        <th>@lang('Kode')</th>
                                        <th>@lang('Member')</th>
                                        <th>@lang('Tgl Go')</th>
                                        <th>@lang('Tgl Tutup')</th>
                                        <th>@lang('Flag VB')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyTableOmi"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="m_detailTokoOmi" tabindex="-1" role="dialog" aria-labelledby="m_detailTokoOmiHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalDetailTokoOmi"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12" id="panelModalDetailTokoOmi">
                                <ul class="nav nav-tabs" id="myTabDetailTokoOmi" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="detailOmi-tab" data-toggle="tab" href="#detailOmi" role="tab" aria-controls="detail" aria-selected="false">@lang('Detail')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="identityOmi-tab" data-toggle="tab" href="#identityOmi" role="tab" aria-controls="identity" aria-selected="true">Identity</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pajakOmi-tab" data-toggle="tab" href="#pajakOmi" role="tab" aria-controls="pajak" aria-selected="false">@lang('Pajak')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="perjanjianOmi-tab" data-toggle="tab" href="#perjanjianOmi" role="tab" aria-controls="perjanjian" aria-selected="false">@lang('Perjanjian')</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContentDetailTokoOmi">
                                    <div class="tab-pane fade" id="detailOmi" role="tabpanel" aria-labelledby="detailOmi-tab">
                                        <div class="card">
                                            <div class="card-body border-dark cardEditTokoOmi">
                                                <form class="form">
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Kode Member')</label>
                                                        <input type="text" id="kodeDetailCust" class="form-control col-sm-2 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Nama Member')</label>
                                                        <input type="text" id="namaDetailCust" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Alamat')</label>
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
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Telepon')</label>
                                                        <input type="text" id="tlpDetail" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('NPWP')</label>
                                                        <input type="text" id="npwpDetail" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>

                                                    <br>

                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Status Toko')</label>
                                                        <select class="form-control col-sm-3 mx-sm-1" id="statusToko">
                                                            <option value="1">@lang('1 - Perumahan')</option>
                                                            <option value="2">@lang('2 - Pertokoan')</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Jam Buka')</label>
                                                        <input type="text" id="jamBuka" class="form-control col-sm-2 mx-sm-1" placeholder="hh:mi:ss"  onchange="converttime(this.value, this.id)">
                                                        <label class="col-sm-1 col-form-label text-md-right">@lang('s/d')</label>
                                                        <input type="text" id="jamTutup" class="form-control col-sm-2 mx-sm-1" placeholder="hh:mi:ss" onchange="converttime(this.value, this.id)">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Jadwal Kirim Barang')</label>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari1">
                                                            <label class="" for="defaultCheck1">@lang('Mng')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari2">
                                                            <label class="" for="defaultCheck1">@lang('Sen')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari3">
                                                            <label class="" for="defaultCheck1">@lang('Sel')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari4">
                                                            <label class="" for="defaultCheck1">@lang('Rab')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari5">
                                                            <label class="" for="defaultCheck1">@lang('Kam')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari6">
                                                            <label class="" for="defaultCheck1">@lang('Jum')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari7">
                                                            <label class="" for="defaultCheck1">@lang('Sab')</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Tgl Update Jadwal')</label>
                                                        {{--<input type="date" id="tglUpdate" class="form-control col-sm-3 mx-sm-1">--}}
                                                        <input type="text" id="tglUpdate" class="form-control col-sm-3 mx-sm-1 tanggal" readonly>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Flag Edit PB di Toko')</label>
                                                        <select class="form-control col-sm-1 mx-sm-1" id="flagPB">
                                                            <option value="Y">@lang('Y')</option>
                                                            <option value="N">@lang('N')</option>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> {{--Close for class "tab-detailomi"--}}

                                    <div class="tab-pane fade show active" id="identityOmi" role="tabpanel" aria-labelledby="identityOmi-tab">
                                        <div class="card">
                                            <div class="card-body border-dark cardEditTokoOmi">
                                                <form class="form">
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Kode Cabang (OMI)')</label>
                                                        <input type="text" id="kodeOmi" class="form-control col-sm-2 mx-sm-1" onchange="getDetailOmi(this.value)" onkeyup="convertToUpper(this.value, this.id)">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Nama Cabang (OMI)')</label>
                                                        <input type="text" id="namaOmi" class="form-control col-sm-5 mx-sm-1">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Kode IGR')</label>
                                                        <input type="text" id="kodeIgr" class="form-control col-sm-1 mx-sm-1" onchange="getBranchName(this.value)">
                                                        <input type="text" id="namaCabang" class="form-control col-sm-4 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Flag Distant Fee')</label>
                                                        <select class="form-control col-sm-1 mx-sm-1" id="flagFee">
                                                            <option value=""></option>
                                                            <option value="Y">@lang('Y')</option>
                                                        </select>
                                                        <label class="col-sm-2 col-form-label text-md-right">@lang('Flag VB')</label>
                                                        <select class="form-control col-sm-1 mx-sm-1" id="flagVb">
                                                            <option value=""></option>
                                                            <option value="Y">@lang('Y')</option>
                                                            <option value="N">@lang('N')</option>
                                                        </select>
                                                        <label class="col-sm-2 col-form-label text-md-right flagKph">@lang('Flag KPH')</label>
                                                        <select class="form-control col-sm-1 mx-sm-1 flagKph" id="flagKph">
                                                            <option value="Y">@lang('Y')</option>
                                                            <option value="N">@lang('N')</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Customer')</label>
                                                        <input type="text" id="kodeCust" class="form-control col-sm-2 mx-sm-1" onchange="getCustomerName(this.value)" onkeyup="convertToUpper(this.value, this.id)">
                                                        <input type="text" id="namaCust" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Tgl Go')</label>
                                                        {{--<input type="date" id="tglGo" class="form-control col-sm-3 mx-sm-1">--}}
                                                        <input type="text" id="tglGo" class="form-control col-sm-3 mx-sm-1 tanggal" placeholder="DD/MM/YYYY">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Tgl Tutup')</label>
                                                        {{--<input type="date" id="tglTutup" class="form-control col-sm-3 mx-sm-1">--}}
                                                        <input type="text" id="tglTutup" class="form-control col-sm-3 mx-sm-1 tanggal" placeholder="DD/MM/YYYY">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> {{--Close for class "tab-identityomi"--}}

                                    <div class="tab-pane fade" id="pajakOmi" role="tabpanel" aria-labelledby="pajakOmi-tab">
                                        <div class="card">
                                            <div class="card-body border-dark cardEditTokoOmi">
                                                <form class="form">
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('No. Depan FP')</label>
                                                        <input type="text" id="tipeOmi" class="form-control col-sm-7 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('No. NPWP')</label>
                                                        <input type="text" id="npwp" class="form-control col-sm-7 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Tanggal Tax')</label>
                                                        <input type="text" id="tanggalTax" class="form-control col-sm-7 mx-sm-1" disabled>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>{{--Close for class "tab-pajakOmi"--}}

                                    {{--*************DICOMMENT KARENA DI IAS ORACLE JUGA DICOMMENT************--}}
                                    <div class="tab-pane fade" id="perjanjianOmi" role="tabpanel" aria-labelledby="perjanjianOmi-tab">
                                        <div class="card">
                                            <div class="card-body border-dark cardEditTokoOmi">
                                                <form class="form">
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Kode Perjanjian')</label>
                                                        <input type="text" id="#" class="form-control col-sm-7 mx-sm-1">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Periode Awal')</label>
                                                        <input type="date" id="#" class="form-control col-sm-7 mx-sm-1">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Periode Akhir')</label>
                                                        <input type="date" id="#" class="form-control col-sm-7 mx-sm-1">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Amount')</label>
                                                        <input type="text" id="#" class="form-control col-sm-7 mx-sm-1">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Tgl Tagih')</label>
                                                        <input type="date" id="#" class="form-control col-sm-7 mx-sm-1">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> {{--Close for class "tab-PerjajianOmi"--}}

                                </div> {{--Close for class "tab-content"--}}
                            </div> {{--Close for class "col-sm-12"--}}
                        </div> {{--Close for class "row"--}}
                    </div> {{--Close for class "container"--}}
                </div> {{--Close for class "modal-body"--}}
                <div class="modal-footer">
                    <div class="col-sm-3"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal">@lang('Cancel')</button></div>
                    <div class="col-sm-3" id="btnEditTokoOmi"><button type="button" class="btn btn-primary btn-block"  onclick="editTokoOmi()">@lang('Edit')</button></div>
                    <div class="col-sm-3" id="btnTambahTokoOmi"><button type="button" class="btn btn-primary btn-block" onclick="tambahTokoOmi()">@lang('Tambah')</button></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Expand -->
    <div class="modal fade" id="m_expand" tabindex="-1" role="dialog"   aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Detail Tokoigr')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalExpand">
                                    <thead class="theadDataTables">
                                    <tr class="text-center">
                                        <th>@lang('OMI')</th>
                                        <th style="width: 25%">@lang('Nama')</th>
                                        <th style="width: 5%">@lang('Flag D.Fee')</th>
                                        <th>@lang('Distribution ')<br>@lang(' Fee')</th>
                                        <th>@lang('Flag Margin')</th>
                                        <th>@lang('Subsidi Pemanjangan')</th>
                                        <th>@lang('Flag Credit Limit OMI')</th>
                                        <th style="width: 10%">@lang('Tipe U/SPBU')</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalExpand">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-left">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">@lang('Kode OMI')</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="searchModalExpand" placeholder="...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4"><p>@lang('* Tekan enter untuk konfirmasi perubahan ')<br> </p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi User -->
    <div class="modal" tabindex="-1" role="dialog" id="m_konfirmasi">
        <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Konfirmasi')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label for="konfirmasi_user" class="col-sm-4 col-form-label text-right">@lang('Kode Pemakai')</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="konfirmasi_user" placeholder="...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="konfirmasi_password" class="col-sm-4 col-form-label text-right">@lang('Password')</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="konfirmasi_password" placeholder="...">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary pl-4 pr-4" onclick="confirmEditExpand()">@lang('OK')</button>
                    <button type="button" class="btn btn-danger pl-4 pr-4" data-dismiss="modal">@lang('Back')</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cardEditTokoOmi{
            height: 525px;
        }

        #tableModalExpand td, #tableModalExpand th{
            padding: 0;
        }

        #searchModalExpand, #konfirmasi_user, .inputModalExpand {
            text-transform: uppercase;
        }
    </style>

    <script>

        let tableModal =  $('#tableTokoOmi').DataTable();
        let valueEditExpand;
        let columnEditExpand;
        let kodeomiEditExpand;

        $(document).ready(function () {
            $('.flagKph').hide();
            // $('#m_detailTokoOmi').modal('show');
            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy"
            });
            getTokoOmi()
        });

        $('#m_detailTokoOmi').on('shown.bs.modal', function (){
            setTimeout(function() {
                $('#kodeOmi').focus();
            }, 1000);
        })

        function editTokoOmi() {
            if(!$('#kodeOmi').val()) {
                swal({
                    title : "{{__('Kode OMI Tidak Boleh Kosong !!!')}}",
                    text : '',
                    icon : 'warning',
                    timer : 1000
                })
                $('#kodeOmi').focus();
                return false;
            } else if(!$('#namaOmi').val()) {
                swal({
                    title : "{{__('Nama OMI Tidak Boleh Kosong !!!')}}",
                    text : '',
                    icon : 'warning',
                    timer : 1000
                })
                $('#namaOmi').focus();
                return false;
            } else if(!$('#namaCabang').val()) {
                swal({
                    title : "{{__('Kode IGR Tidak Boleh Kosong !!!')}}",
                    text : '',
                    icon : 'warning',
                    timer : 1000
                })
                $('#kodeIgr').focus();
                return false;
            } else if(!$('#namaCust').val()) {
                swal({
                    title : "{{__('Kode Member Tidak Boleh Kosong !!!')}}",
                    text : '',
                    icon : 'warning',
                    timer : 1000
                })
                $('#kodeCust').focus();
                return false;
            }

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
                url: '{{ url()->current() }}/updatetokoomi',
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
                }, error: function (err) {
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function tambahTokoOmi(){
            if(!$('#kodeOmi').val()) {
                swal({
                    title : "{{__('Kode OMI Tidak Boleh Kosong !!!')}}",
                    text : '',
                    icon : 'warning',
                    timer : 1000
                })
                $('#kodeOmi').focus();
                return false;
            } else if(!$('#namaOmi').val()) {
                swal({
                    title : "{{__('Nama OMI Tidak Boleh Kosong !!!')}}",
                    text : '',
                    icon : 'warning',
                    timer : 1000
                })
                $('#namaOmi').focus();
                return false;
            } else if(!$('#namaCabang').val()) {
                swal({
                    title : "{{__('Kode IGR Tidak Boleh Kosong !!!')}}",
                    text : '',
                    icon : 'warning',
                    timer : 1000
                })
                $('#kodeIgr').focus();
                return false;
            } else if(!$('#namaCust').val()) {
                swal({
                    title : "{{__('Kode Member Tidak Boleh Kosong !!!')}}",
                    text : '',
                    icon : 'warning',
                    timer : 1000
                })
                $('#kodeCust').focus();
                return false;
            }

            $.ajax({
                url: '{{ url()->current() }}/tambahtokoomi',
                type: 'post',
                data:{
                    kodeSBU:$('#chooseTypeOmi').val(),
                    kodeOmi:$('#kodeOmi').val(),
                    namaOmi:$('#namaOmi').val(),
                    kodeIgr:$('#kodeIgr').val(),
                    flagFee:$('#flagFee').val(),
                    flagVb:$('#flagVb').val(),
                    flagKph:$('#flagKph').val(),
                    kodeCust:$('#kodeCust').val(),
                    tglGo:$('#tglGo').val(),
                    tglTutup:$('#tglTutup').val(),
                },
                success: function (result) {
                    swal('Success', result, 'success');
                    $('#m_detailTokoOmi').modal('hide');
                    getTokoOmi();
                }, error: function (err) {
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function getCustomerName(member) {
            if(!member){
                swal({
                    title : "{{__('Kode Member Tidak boleh Kosong')}}",
                    text : '',
                    icon : 'warning',
                    timer : 1000
                })
                $('#kodeCust').focus();
                $('#namaCust').val('');
            } else {
                $.ajax({
                    url: '{{ url()->current() }}/getcustomername',
                    type: 'POST',
                    data: {member:member},
                    success: function (result) {
                        if (result.length ===0){
                            swal({
                                title : "{{__('Kode Member Tidak Terdaftar')}}",
                                text : '',
                                icon : 'info',
                                timer : 1000
                            })
                            $('#namaCust').val('');
                            $('#kodeCust').focus();

                        } else {
                            $('#namaCust').val(result[0].cus_namamember);
                        }

                    }, error: function (err) {
                        console.log(err.responseJSON.message.substr(0,100));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                })
            }
        }

        function getBranchName(kodeIgr) {
            if(!kodeIgr){
                swal("Error","{{__('Kode Indogrosir Tidak boleh Kosong')}}", "error");
            } else {
                $.ajax({
                    url: '{{ url()->current() }}/getbranchname',
                    type: 'POST',
                    data: {kodeIgr: kodeIgr},
                    success: function (result) {
                        if (result.length ===0){
                            swal({
                                title : "{{__('Kode Indogrosir Tidak Terdaftar')}}",
                                text : '',
                                icon : 'info',
                                timer : 1000
                            })
                            $('#kodeIgr').focus();
                            $('#namaCabang').val('');
                        } else {
                            $('#namaCabang').val(result[0].cab_namacabang);
                        }

                    }, error: function (err) {
                        console.log(err.responseJSON.message.substr(0,100));
                        alertError(err.statusText, err.responseJSON.message);
                    }
                })
            }
        }

        function getTokoOmi() {
            let kodeSBU = $('#chooseTypeOmi').val();

            if (kodeSBU === 'M' || kodeSBU === 'O'){
                $('.flagKph').hide();
            } else {
                $('.flagKph').show();
            }

            tableModal.destroy();
            tableModal =  $('#tableTokoOmi').DataTable({
                "ajax": {
                    'url' : '{{url()->current()}}/gettokoomi',
                    "data" : {
                        'kodeSBU' : kodeSBU
                    },
                },
                "columns": [
                    {data: 'tko_kodeomi', name: 'tko_kodeomi', "width": "5%"},
                    {data: 'tko_namaomi', name: 'tko_namaomi', "width": "25%"},
                    {data: 'tko_flagdistfee', name: 'tko_flagdistfee', "width": "5%"},
                    {data: 'tko_kodecustomer', name: 'tko_kodecustomer', "width": "10%"},
                    {data: 'cus_namamember', name: 'cus_namamember', "width": "25%"},
                    {data: 'tko_tglgo', name: 'tko_tglgo', "width": "10%"},
                    {data: 'tko_tgltutup', name: 'tko_tgltutup', "width": "10%"},
                    {data: 'tko_flagvb', name: 'tko_flagvb', "width": "5%"},
                    // {data: 'tko_kodeomi', name: 'tko_kodeomi',"width": "10%"},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow modalOmiRow');
                },
                columnDefs : [
                    { targets : [5],
                        render : function (data, type, row) {
                            return formatDate(data);
                            // return data
                        }
                    },  { targets : [6],
                        render : function (data, type, row) {
                            if (data) {
                                return formatDate(data);
                                // return data
                            } else {
                                return data
                            }
                        }
                    },
                ],
                "order": []
            });

            $(document).on('click', '.modalOmiRow', function () {
                let kodeomi = $(this).find('td')[0]['innerHTML']

                getDetailOmi(kodeomi)
            } );

            $(document).on( 'click', '#btnExpand', function () {
                appendDatatoModalExpand(tableModal.data());
            })

            setTimeout(function(){
                $("#tableTokoOmi_info").append("<br>@lang('* Klik Kode OMI untuk melihat detail')")
                $("#tableTokoOmi_wrapper").append(` <div class="text-center mt-3">
                                                    <button class='btn btn-primary text-center pl-5 pr-5' data-toggle='modal' data-target='#' onclick="createNewOmi()">@lang('Buat OMI Baru')</button>
                                                    <button class='btn btn-primary text-center pl-5 pr-5' id="btnExpand" data-toggle='modal' data-target='#m_expand' >@lang('Expand Data OMI')</button>
                                                </div> `)
            }, 2000);

        }

        function getDetailOmi(kodeOmi) {
            clearField();
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/detailtokoomi',
                type: 'POST',
                data:{kodeOmi:kodeOmi},
                success: function (result) {
                    if(result.kode == 0){
                        // alertError("Data Tidak Ditemukan!!","")
                        // return false;
                        createNewOmi(kodeOmi)
                        return false;
                    }

                    let identity= result.identity[0];
                    let detail  = result.detail[0];

                    $('#detailOmi-tab').show();

                    $('#kodeOmi').val(identity.tko_kodeomi);
                    $('#namaOmi').val(identity.tko_namaomi);
                    $('#kodeIgr').val(identity.tko_kodeigr);
                    $('#namaCabang').val(identity.cab_namacabang);
                    $('#flagFee').val(identity.tko_flagdistfee);
                    $('#flagVb').val(identity.tko_flagvb);
                    $('#flagKph').val(identity.tko_flagkph);
                    $('#kodeCust').val(identity.tko_kodecustomer);
                    $('#namaCust').val(identity.cus_namamember);
                    // $('#tglGo').val(formatDateCustom(formatDateForInputType(identity.tko_tglgo),'dd-mm-y'));
                    $('#tglGo').val(formatDate(identity.tko_tglgo));
                    // $('#tglTutup').val((identity.tko_tgltutup) ? formatDateCustom(formatDateForInputType(identity.tko_tgltutup),'dd-M-yy') : '');
                    $('#tglTutup').val(formatDate(identity.tko_tgltutup));

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
                    $('#tglUpdate').val(formatDate(identity.tko_tglberlakujadwal));
                    // $('#tglUpdate').val((identity.tko_tglberlakujadwal) ? formatDateCustom(formatDateForInputType(identity.tko_tglberlakujadwal),'dd-mm-y') : '');
                    $('#flagPB').val(identity.tko_flageditpb);

                    if(identity.tko_jadwalkirimbrg){
                        for(let i =0; i<identity.tko_jadwalkirimbrg.length; i++){
                            if (identity.tko_jadwalkirimbrg[i] === 'Y'){
                                $('#hari'+(i+1)).prop('checked', true)
                            }
                        }
                    }

                    $('#tipeOmi').val(identity.tko_tipeomi);
                    $('#npwp').val(identity.cus_npwp);
                    $('#tanggalTax').val(identity.cus_tglpajak);

                    $('#titleModalDetailTokoOmi').text(identity.tko_kodeomi + " - "+ identity.tko_namaomi);
                    $('#btnEditTokoOmi').show();
                    $('#btnTambahTokoOmi').hide();
                    $('#m_detailTokoOmi').modal('show');
                }, error: function (err) {
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function appendDatatoModalExpand(data){
            $('#tbodyModalExpand').children().remove();
            if (data.length === 0){
                $('#tbodyModalExpand').append(`<tr><td colspan="8" class="text-center">--</td></tr>`)
            } else  {
                for(i = 0; i< data.length; i++){
                    $('#tbodyModalExpand').append(`<tr class="text-center">
                                                        <td  class="text-left">${data[i].tko_kodeomi}</td>
                                                        <td  class="text-left"  style="width: 25%">${data[i].tko_namaomi}</td>
                                                        <td style="width: 5%">
                                                            <input class="form-control flagFee inputModalExpand" column="tko_flagdistfee" type="text" value="${nvl(data[i].tko_flagdistfee,'')}">
                                                        </td>
                                                        <td>
                                                            <input class="form-control persenFee inputModalExpand" column="tko_persendistributionfee" type="text" value="${nvl(data[i].tko_persendistributionfee,'')}">
                                                        </td>
                                                        <td>
                                                             <input class="form-control persenMargin inputModalExpand" column="tko_persenmargin" type="text" value="${nvl(data[i].tko_persenmargin,'')}">
                                                        </td>
                                                        <td>
                                                             <input class="form-control flagSubsidi inputModalExpand" column="tko_flagsubsidipemanjangan" type="text" value="${nvl(data[i].tko_flagsubsidipemanjangan,"")}">
                                                        </td>
                                                        <td>
                                                             <input class="form-control flagCredit inputModalExpand" column="tko_flagcreditlimitomi" type="text" value="${nvl(data[i].tko_flagcreditlimitomi,"")}">
                                                        </td>
                                                        <td style="width: 10%">
                                                             <input class="form-control tipeOmi inputModalExpand" column="tko_tipeomi" type="text" value="${nvl(data[i].tko_tipeomi,"")}">
                                                        </td>
                                                    </tr>`)
                }
            }
        }

        $(window).bind('keydown', function(event) {
            if (event.ctrlKey || event.metaKey) {
                if(String.fromCharCode(event.which).toLowerCase() === 's'){
                    $('#searchModalExpand').focus();
                    event.preventDefault();
                }
            }
        });

        $(document).on('keypress', '#searchModalExpand', function (event) {
            if (event.which == 13){
                let search = $(this).val().toUpperCase();
                let flagSearch = 0;

                $('#tbodyModalExpand tr td:nth-child(1)').each( function(){
                    if (search == $(this).text()){
                        flagSearch = 1;
                        let self = $(this);
                        self.parent().find('.persenMargin').focus();
                        $('#searchModalExpand').val('')
                        return false;
                    }
                });

                if (flagSearch < 1) {
                    swal({
                        title: `{{__('Kode OMI')}} ${search} {{__('Tidak Terdaftar')}}`,
                        text: ` `,
                        icon: "warning",
                        button: false,
                        timer: 1000
                    });
                    // $(this).val('')
                    $(this).focus()
                }
            }
        })

        $(document).on('keypress', '.inputModalExpand', function (event) {
            if (event.which == 13){
                valueEditExpand     = $(this).val().toUpperCase().trim();
                columnEditExpand    = $(this).attr('column');
                let parent  = $(this).parents('tr');
                kodeomiEditExpand   = parent.find("td:nth-child(1)")[0]['innerText'];

                if (columnEditExpand == 'tko_flagsubsidipemanjangan' || columnEditExpand == 'tko_flagcreditlimitomi' && valueEditExpand){
                    if(valueEditExpand != 'Y'){
                     swal({
                         title: `{{__("Hanya boleh diisi 'Y' atau biarkan kosong!!")}}`,
                         text: ` `,
                         icon: "info",
                         button: false,
                         timer: 1500
                     });
                        $(this).val('')
                        return false;
                    }
                } else if(columnEditExpand == 'tko_tipeomi' && valueEditExpand){
                    if(valueEditExpand != 'HR' && valueEditExpand != 'HG' && valueEditExpand != 'HE'){
                        swal({
                            title: `{{__("Hanya boleh diisi 'HR' / 'HG' / 'HE' atau biarkan kosong!!")}}`,
                            text: ` `,
                            icon: "info",
                            button: false,
                            timer: 1500
                        });
                        $(this).val('')
                        return false;
                    }
                }

                $('#m_konfirmasi').modal('show');
                $('#konfirmasi_user').focus();
                $('#konfirmasi_user').val('');
                $('#konfirmasi_password').val('');
            }
        })

        async function confirmEditExpand(){
            let confirmUser = $('#konfirmasi_user').val().toUpperCase();
            let confirmPass = $('#konfirmasi_password').val();
            let updateMKTHO = 'N';

            $('#m_konfirmasi').modal('hide');

            if (columnEditExpand == "tko_persendistributionfee"){
                await swal({
                    title: "{{__('Update Data DF ke OMI?')}}",
                    icon: 'info',
                    buttons: {
                        confirm: "{{__('Ya')}}",
                        roll: {
                            text: "{{__('Tidak')}}",
                        },
                    }
                }).then(function (confirm) {
                    switch (confirm) {
                        case true:
                            updateMKTHO = 'Y';
                            break;

                        case "lain":
                            updateMKTHO = 'N';
                            break;

                        default:
                            updateMKTHO = 'N';
                    }
                })
            }

            callFuncEditExpand(confirmUser, confirmPass, updateMKTHO);
        }

        function callFuncEditExpand(confirmUser, confirmPass, updateMKTHO){
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/confirmedit',
                type: 'POST',
                data: {
                    confirmUser:confirmUser,
                    confirmPass:confirmPass,
                    updateMKTHO:updateMKTHO,
                    kodeomiEditExpand:kodeomiEditExpand,
                    columnEditExpand:columnEditExpand,
                    valueEditExpand:valueEditExpand,
                    kodeSBU:$('#chooseTypeOmi').val(),
                },
                success: function (result) {
                    console.log(result);
                    if(result.kode == 1){
                        swal({
                            icon: 'success',
                            text: result.msg,
                            buttons: false,
                            timer: 2000,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });

                        getTokoOmi()
                        $('#m_expand').modal('hide')

                        setTimeout(function(){
                            $('#btnExpand').trigger('click');
                        }, 2000);
                        // setTimeout(function(){location.reload()}, 2000);
                    } else {
                        swal({
                            icon: 'warning',
                            text: result.msg,
                            buttons: false,
                            timer: 2000,
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        });
                    }
                }, error: function (err) {
                    console.log(err);
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function createNewOmi(kodeomi){
            $('#titleModalDetailTokoOmi').text("{{__('Buat Omi Baru')}}");
            $('.active').removeClass('active')
            $('#detailOmi-tab').hide();
            $('#identityOmi-tab').addClass("active");
            $('#identityOmi').addClass("show active");
            $('#identityOmi').attr("aria-selected", true)
            $('#btnEditTokoOmi').hide();
            $('#btnTambahTokoOmi').show();
            clearField();
            $('#kodeOmi').val(kodeomi);
            $('#namaOmi').focus();
            $('#m_detailTokoOmi').modal('show');
        }

        $(document).on('click', '.btnActionDetail', function () {
            let kodeomi = $(this)

            console.log(kodeomi);

            // getDetailOmi(kodeomi);
        } );

        function converttime(time, id) {
            let temp = "";
            if (time.length < 6){
                swal("Error", "{{__('Masukan 6 digit angka')}}", "error");
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

        function appendPaneltoModal(){
            $('#panelModalDetailTokoOmi').append(`<ul class="nav nav-tabs" id="myTabDetailTokoOmi" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="detailOmi-tab" data-toggle="tab" href="#detailOmi" role="tab" aria-controls="detail" aria-selected="true">@lang('Detail')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="identityOmi-tab" data-toggle="tab" href="#identityOmi" role="tab" aria-controls="identity" aria-selected="false">@lang('Identity')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pajakOmi-tab" data-toggle="tab" href="#pajakOmi" role="tab" aria-controls="pajak" aria-selected="false">@lang('Pajak')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="perjanjianOmi-tab" data-toggle="tab" href="#perjanjianOmi" role="tab" aria-controls="perjanjian" aria-selected="false">@lang('Perjanjian')</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="myTabContentDetailTokoOmi">
                                    <div class="tab-pane fade show active" id="detailOmi" role="tabpanel" aria-labelledby="detailOmi-tab">
                                        <div class="card">
                                            <div class="card-body border-dark cardEditTokoOmi">
                                                <form class="form">
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Kode Member')</label>
                                                        <input type="text" id="kodeDetailCust" class="form-control col-sm-2 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Nama Member')</label>
                                                        <input type="text" id="namaDetailCust" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Alamat')</label>
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
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Telepon')</label>
                                                        <input type="text" id="tlpDetail" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('NPWP')</label>
                                                        <input type="text" id="npwpDetail" class="form-control col-sm-5 mx-sm-1" disabled>
                                                    </div>

                                                    <br>

                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Status Toko')</label>
                                                        <select class="form-control col-sm-3 mx-sm-1" id="statusToko">
                                                            <option value="1">@lang('1 - Perumahan')</option>
                                                            <option value="2">@lang('2 - Pertokoan')</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Jam Buka')</label>
                                                        <input type="text" id="jamBuka" class="form-control col-sm-2 mx-sm-1" placeholder="hh:mi:ss"  onchange="converttime(this.value, this.id)">
                                                        <label class="col-sm-1 col-form-label text-md-right">s/d</label>
                                                        <input type="text" id="jamTutup" class="form-control col-sm-2 mx-sm-1" placeholder="hh:mi:ss" onchange="converttime(this.value, this.id)">
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Jadwal Kirim Barang')</label>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari1">
                                                            <label class="" for="defaultCheck1">@lang('Mng')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari2">
                                                            <label class="" for="defaultCheck1">@lang('Sen')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari3">
                                                            <label class="" for="defaultCheck1">@lang('Sel')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari4">
                                                            <label class="" for="defaultCheck1">@lang('Rab')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari5">
                                                            <label class="" for="defaultCheck1">@lang('Kam')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari6">
                                                            <label class="" for="defaultCheck1">@lang('Jum')</label>
                                                        </div>
                                                        <div class="form-check mx-sm-1 mt-2">
                                                            <input class="form-check-input" type="checkbox" value="" id="hari7">
                                                            <label class="" for="defaultCheck1">@lang('Sab')</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Tgl Update Jadwal')</label>
                                                        <input type="text" id="tglUpdate" class="form-control col-sm-3 mx-sm-1 tanggal" readonly>
                                                    </div>
                                                    <div class="form-group row mb-0">
                                                        <label class="col-sm-4 col-form-label text-md-right">@lang('Flag Edit PB di Toko')</label>
                                                        <select class="form-control col-sm-1 mx-sm-1" id="flagPB">
                                                            <option value="Y">@lang('Y')</option>
                                                            <option value="N">@lang('N')</option>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="identityOmi" role="tabpanel" aria-labelledby="identityOmi-tab">
                                            <div class="card">
                                                <div class="card-body border-dark cardEditTokoOmi">
                                                    <form class="form">
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Kode Cabang (OMI)')</label>
                                                            <input type="text" id="kodeOmi" class="form-control col-sm-2 mx-sm-1" onchange="getDetailOmi(this.value)" onkeyup="convertToUpper(this.value, this.id)">
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Nama Cabang (OMI)')</label>
                                                            <input type="text" id="namaOmi" class="form-control col-sm-5 mx-sm-1">
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Kode IGR')</label>
                                                            <input type="text" id="kodeIgr" class="form-control col-sm-1 mx-sm-1" onchange="getBranchName(this.value)">
                                                            <input type="text" id="namaCabang" class="form-control col-sm-4 mx-sm-1" disabled>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Flag Distant Fee')</label>
                                                            <select class="form-control col-sm-1 mx-sm-1" id="flagFee">
                                                                <option value="Y">Y</option>
                                                                <option value="N">N</option>
                                                            </select>
                                                            <label class="col-sm-2 col-form-label text-md-right">@lang('Flag VB')</label>
                                                            <select class="form-control col-sm-1 mx-sm-1" id="flagVb">
                                                                <option value="Y">Y</option>
                                                                <option value="N">N</option>
                                                            </select>
                                                            <label class="col-sm-2 col-form-label text-md-right flagKph">@lang('Flag KPH')</label>
                                                            <select class="form-control col-sm-1 mx-sm-1 flagKph" id="flagKph">
                                                                <option value="Y">Y</option>
                                                                <option value="N">N</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Customer')</label>
                                                            <input type="text" id="kodeCust" class="form-control col-sm-2 mx-sm-1" onchange="getCustomerName(this.value)" onkeyup="convertToUpper(this.value, this.id)">
                                                            <input type="text" id="namaCust" class="form-control col-sm-5 mx-sm-1" disabled>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Tgl Go')</label>
                                                            <input type="text" id="tglGo" class="form-control col-sm-3 mx-sm-1 tanggal" readonly>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Tgl Tutup')</label>
                                                            <input type="text" id="tglTutup" class="form-control col-sm-3 mx-sm-1 tanggal" readonly>
                                                        </div>
                                                    </form>
                                                 </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="pajakOmi" role="tabpanel" aria-labelledby="pajakOmi-tab">
                                            <div class="card">
                                                <div class="card-body border-dark cardEditTokoOmi">
                                                    <form class="form">
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('No. Depan FP')</label>
                                                            <input type="text" id="tipeOmi" class="form-control col-sm-7 mx-sm-1" disabled>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('No. NPWP')</label>
                                                            <input type="text" id="npwp" class="form-control col-sm-7 mx-sm-1" disabled>
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Tanggal Tax')</label>
                                                            <input type="text" id="tanggalTax" class="form-control col-sm-7 mx-sm-1" disabled>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="perjanjianOmi" role="tabpanel" aria-labelledby="perjanjianOmi-tab">
                                            <div class="card">
                                                <div class="card-body border-dark cardEditTokoOmi">
                                                    <form class="form">
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Kode Perjanjian')</label>
                                                            <input type="text" id="#" class="form-control col-sm-7 mx-sm-1">
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Periode Awal')</label>
                                                            <input type="date" id="#" class="form-control col-sm-7 mx-sm-1">
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Periode Akhir')</label>
                                                            <input type="date" id="#" class="form-control col-sm-7 mx-sm-1">
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Amount')</label>
                                                            <input type="text" id="#" class="form-control col-sm-7 mx-sm-1">
                                                        </div>
                                                        <div class="form-group row mb-0">
                                                            <label class="col-sm-4 col-form-label text-md-right">@lang('Tgl Tagih')</label>
                                                            <input type="date" id="#" class="form-control col-sm-7 mx-sm-1">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                </div>`);
        }
    </script>




@endsection
