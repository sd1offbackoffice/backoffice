@extends('navbar')
@section('content')
    {{--<head>--}}
    {{--<script src="{{asset('/js/bootstrap-select.min.js')}}"></script>--}}
    {{--</head>--}}

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card">
                    <legend class="w-auto ml-5">Header Perubahan Status Barang</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row text-right">
                                <div class="col-sm-12">
                                    <div class="form-group row mb-0">
                                        <label for="i_nomordokumen" class="col-sm-4 col-form-label">Nomor Dokumen</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_nomordokumen" placeholder="TXT_NODOC">
                                        </div>
                                        <button class="btn sm-1" type="button" data-toggle="modal" onclick="getNmrSRT('')" style="margin-left: -20px"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                        <div class="col-sm-3" style="margin-left: -70px; margin-right: auto; margin-top: auto">
                                            <input type="checkbox" id="qtyplanogram" value="planogram"><label>&nbsp;&nbsp;Potong Qty Planogram</label>
                                        </div>
                                        <span id="printdoc" class="col-sm-2 btn btn-success btn-block" onclick="printDocument()">PRINT</span>
                                        <label for="i_tgldokumen" class="col-sm-4 col-form-label">Tanggal Dokumen</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_tgldokumen" placeholder="TXT_TGLDOC">
                                        </div>
                                        <input type="text" id="keterangan" class="form-control col-sm-3 text-right"  disabled>
                                        <label for="i_keterangan" class="col-sm-4 col-form-label">Keterangan</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_keterangan" placeholder="TXT_KETERANGAN">
                                        </div>
                                        <label for="nosortir" class="col-sm-4 col-form-label">Nomor Sortir</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_nosortir" placeholder="TXT_NOSORTIR">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="i_gudang" placeholder="TXT_GUDANG" disabled>
                                        </div>
                                        <div class="col-sm-3">
                                            {{--this div just for filling space--}}
                                        </div>
                                        <label for="i_tgldokumen" class="col-sm-4 col-form-label">Tanggal Dokumen</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="i_tglsortir" placeholder="TXT_TGLSORTIR">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </fieldset>
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Detail Perubahan Status Barang</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="col-sm-12">
                            <div class="tableFixedHeader" style="border-bottom: 1px solid black">
                                <table class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr class="d-flex align-items-center text-center">
                                            <th style="width: 80px"><br>X</th>
                                            <th style="width: 150px"><br>PLU</th>
                                            <th style="width: 400px"><br>Deskripsi</th>
                                            <th style="width: 130px"><br>Satuan</th>
                                            <th style="width: 80px"><br>PT</th>
                                            <th style="width: 80px"><br>RT/TG</th>
                                            <th style="width: 80px"><br>CTN</th>
                                            <th style="width: 80px"><br>PCS</th>
                                            <th style="width: 140px">HRG.SATUAN<br>(IN CTN)</th>
                                            <th style="width: 150px"><br>NILAI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    @for($i = 0; $i< 7; $i++)
                                        <tr class="d-flex baris">
                                            <td style="width: 80px" class="text-center">
                                                <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                            </td>
                                            <td class="buttonInside" style="width: 150px">
                                                <input type="text" class="form-control plu" no="{{$i}}">
                                                <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" onclick="getPlu(this, '')" no="{{$i}}">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            <td style="width: 400px"><input disabled type="text" class="form-control deskripsi"></td>
                                            <td style="width: 130px"><input disabled type="text" class="form-control satuan"></td>
                                            <td style="width: 80px"><input disabled type="text" class="form-control pt text-right"></td>
                                            <td style="width: 80px"><input disabled type="text" class="form-control rttg text-right"></td>
                                            <td style="width: 80px"><input type="text" class="form-control ctn text-right" id="{{$i}}" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                            <td style="width: 80px"><input type="text" class="form-control pcs text-right" id="{{$i}}" onkeypress="return isNumberKey(event)" onchange="calculateTotal(this.value, this.id)"></td>
                                            <td style="width: 140px"><input disabled type="text" class="form-control PRICE"></td>
                                            <td style="width: 150px"><input disabled type="text" class="form-control total text-right"></td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td><button id="addNewRow" class="btn btn-warning btn-block" onclick="addNewRow()">Tambah Baris Baru</button></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-9">
                                    <div class="row">
                                        <span class="font-weight-bold">Nilai Acost Perubahan Status Diambil dari</span>
                                    </div>
                                    <div class="row">
                                        <span class="font-weight-bold">Nilai Acost Pada Saat Melakukan Sortir Barang</span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <label class="col-form-label col-sm-6 text-left">TOTAL QTY</label>
                                    <input type="text" class="form-control col-sm-6 text-right" style="float:right" value="0" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="m_kodecabangHelp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchModal" class="form-control search_lov" type="text" placeholder="..." aria-label="Search">
                    </div>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th id="modalThName1"></th>
                                            <th id="modalThName2"></th>
                                            <th id="modalThName3"></th>
                                            <th id="modalThName4"></th>
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
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
        function deleteRow(e) {
            let temp        = 0;
            let tempTtlHrg  = 0;

            $(e).parents("tr").remove();

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