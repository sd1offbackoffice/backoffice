@extends('navbar')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7 col-sm-8">
                <fieldset class="card">
                    <legend  class="w-auto ml-5">IGR BO PEMUSNAHAN</legend>
                    <div class="card-body cardForm">
                        <div class="row">
                            <div class="col-sm-12">
                                <form>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-2 col-form-label text-md-right">Nomor TRN</label>
                                        <input type="text" id="nmrtrn" class="form-control col-sm-2 mx-sm-1">
                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getNmrTRN('')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                        <label class="col-sm-2 col-form-label text-md-right">Tanggal</label>
                                        <input type="date" id="tgltrn" class="form-control col-sm-2 mx-sm-1">
                                    </div>
                                    <div class="form-group row mb-0 mt-2">
                                        <label class="col-sm-2 col-form-label text-md-right">Pilihan</label>
                                        <select class="form-control col-sm-3 mx-sm-1" id="pilihan">
                                            <option value="M" selected>Manual</option>
                                            <option value="A" >Semua Barang Rusak di Lpp</option>
                                        </select>
                                        <input type="text" id="keterangan" class="form-control col-sm-3 text-right" style="margin-left: 145px" disabled>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <button type="button" id="save" class="btn btn-primary mt-3 mb-3 col-sm-2" style="margin-left: 56.1%" onclick="saveData()">Save</button>
                                        <button type="button" id="delete" class="btn btn-danger mt-3 mb-3 col-sm-2  ml-3" onclick="deleteData()">Delete</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-12">
                                <div class="tableFixedHeader">
                                    <table id="table-detail" class="table table-sm table-bordered m-1 mb-4">
                                        <thead>
                                        <tr class="d-flex text-center">
                                            <th class="col-sm-1">x</th>
                                            <th class="col-sm-2">PLU</th>
                                            <th class="col-sm-3">Deskripsi</th>
                                            <th class="col-sm-1">Satuan</th>
                                            <th class="col-sm-1">CTN</th>
                                            <th class="col-sm-1">PCS</th>
                                            <th class="col-sm-2">Hrg. Satuan</th>
                                            <th class="col-sm-2">Total</th>
                                            <th class="col-sm-3">Keterangan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($i=0;$i<10;$i++)
                                            <tr class="d-flex baris" id="row_detail_{{ $i }}">
                                                <td class="col-sm-1 text-center">
                                                    <button onclick="deleteRow({{ $i }})" class="col-sm btn btn-danger btn-delete">X</button>
                                                    {{--<button class="btn" type="button" data-toggle="modal" onclick="getPlu()"><img src="{{asset('image/icon/help.png')}}" width="40px"></button>--}}
                                                </td>
                                                <td class="col-sm-2 buttonInside">
                                                    {{--<input type="text" class="form-control kke_hargabeli">--}}
                                                    <input type="text" class="form-control" id="no_penyesuaian">
                                                    <button id="btn-no-doc" type="button" class="btn btn-lov divisi1 ml-3">
                                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                    </button>
                                                </td>
                                                <td class="col-sm-3"><input disabled  type="text" class="form-control kke_discount"></td>
                                                <td class="col-sm-1"><input disabled type="text" class="form-control kke_sales01"></td>
                                                <td class="col-sm-1"><input type="text" class="form-control kke_sales02"></td>
                                                <td class="col-sm-1"><input type="text" class="form-control kke_sales03"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control kke_avgbln"></td>
                                                <td class="col-sm-2"><input disabled type="text" class="form-control kke_avghari"></td>
                                                <td class="col-sm-3"><input type="text" class="form-control kke_avghari"></td>
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
                                    <p class="text-hide" id="idField"></p>
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


    <script>
        function  getNmrTRN(val) {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getnmrtrn',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('#modalThName1').text('NO.DOC');
                    $('#modalThName2').text('TGL.DOC');
                    $('#modalThName3').text('NOTA');
                    $('#modalThName3').show();

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseTrn('"+ result[i].rsk_nodoc+"') class='modalRow'><td>"+ result[i].rsk_nodoc +"</td> <td>"+ formatDate(result[i].rsk_tgldoc) +"</td> <td>"+ result[i].nota +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function getPlu() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getplu',
                type: 'post',
                data: {},
                success: function (result) {
                    $('#modalThName1').text('Deskripsi');
                    $('#modalThName2').text('PLU');
                    $('#modalThName3').hide();

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=choosePlu('"+ result[i].prd_prdcd+"') class='modalRow'><td>"+ result[i].prd_deskripsipendek +"</td> <td>"+ result[i].prd_prdcd +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                getNmrTRN($('#searchModal').val())
            }
        })




    </script>

@endsection
