@extends('navbar')
@section('title','Input | pembatalan BA Pemusnahan')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card">
                    <legend  class="w-auto ml-5">IGR BO BAPBBATAL</legend>
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-2 col-form-label text-md-right">Nomor BAPB</label>
                                        <input type="text" id="nmrtrn" class="form-control col-sm-2 mx-sm-1">
                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getNmrTRN('')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <button class="btn btn-danger col-sm-2 offset-sm-9">Hapus BAPB</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12 mt-3">
                                <hr>
                                <div class="tableFixedHeader" >
                                    <table class="table table-striped table-bordered" id="table2">
                                        <thead class="thead-dark thead-fixed">
                                        <tr class="d-flex text-center">
                                            <th style="width: 80px">X</th>
                                            <th style="width: 150px">PLU</th>
                                            <th style="width: 400px">Deskripsi</th>
                                            <th style="width: 130px">Satuan</th>
                                            <th style="width: 80px">CTN</th>
                                            <th style="width: 80px">PCS</th>
                                            <th style="width: 150px">Hrg. Satuan</th>
                                            <th style="width: 150px">Total</th>
                                            <th style="width: 350px">Keterangan</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        @for($i = 0; $i< 15; $i++)
                                            <tr class="d-flex baris" onclick="putDesPanjang(this)">
                                                <td style="width: 80px" class="text-center">
                                                    <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                                </td>
                                                <td class="buttonInside" style="width: 150px">
                                                    <input type="text" class="form-control plu" no="{{$i}}">
                                                    <button id="btn-no-doc" type="button" class="btn btn-lov ml-3" onclick="getPlu(this, '')" no="{{$i}}">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </td>
                                                <td style="width: 400px"><input disabled type="text"  class="form-control deskripsi"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan"></td>
                                                <td style="width: 80px"><input type="text" class="form-control ctn text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 1)"></td>
                                                <td style="width: 80px"><input type="text" class="form-control pcs text-right" id="{{$i}}" onchange="calculateQty(this.value, this.id, 2)"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga text-right"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total text-right"></td>
                                                <td style="width: 350px"><input type="text" class="form-control keterangan"></td>
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
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


    </script>

@endsection
