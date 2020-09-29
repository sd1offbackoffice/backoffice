@extends('navbar')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-7">
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
                                    <table class="table table-striped table-bordered" id="table2">
                                        <thead class="thead-dark">
                                        <tr class="d-flex text-center">
                                            <th style="width: 120px">Action</th>
                                            <th style="width: 130px">PLU</th>
                                            <th style="width: 350px">Deskripsi</th>
                                            <th style="width: 130px">Satuan</th>
                                            <th style="width: 80px">CTN</th>
                                            <th style="width: 80px">PCS</th>
                                            <th style="width: 150px">Hrg. Satuan</th>
                                            <th style="width: 150px">Total</th>
                                            <th style="width: 350px">Keterangan</th>
                                            <!-- <th>Action</th> -->
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        @for($i = 0; $i< 11; $i++)
                                            <tr class="d-flex baris">
                                                <td style="width: 120px">
                                                    <button class="btn btn-danger btn-delete"  style="width: 40px" onclick="deleteRow(this)">X</button>
                                                    <button class="btn" type="button" data-toggle="modal" onclick="getPlu()" style="width: 40px; padding: 0; margin: 0"><img src="{{asset('image/icon/help.png')}}"></button>
                                                </td>
                                                <td style="width: 130px"><input type="text" class="form-control plu" onchange="cal(this)"></td>
                                                <td style="width: 350px"><input disabled type="text"  class="form-control deskripsi"></td>
                                                <td style="width: 130px"><input disabled type="text" class="form-control satuan"></td>
                                                <td style="width: 80px"><input type="text" class="form-control ctn"></td>
                                                <td style="width: 80px"><input type="text" class="form-control pcs"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control harga"></td>
                                                <td style="width: 150px"><input disabled type="text" class="form-control total"></td>
                                                <td style="width: 350px"><input type="text" class="form-control keterangan">
                                                </td>
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                                <span style="float:right"><button id="but_add" class="btn btn-danger">Add New
                                Row</button></span>
                                <span style="float:right"><button id="proses" onclick="proses()"
                                                                  class="btn btn-success mr-3">proses</button></span>
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

    <style>
        .pane--table2 thead {
            display: table-row;
        }

        .table-fixed thead {
            width: 97%;
        }

        .table-fixed tbody {
            height: 400px;
            overflow-y: auto;
            width: 100%;
        }



    </style>

    <script>
        function  getNmrTRN(val) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bo/transaksi/pemusnahan/brgrusak/getnmrtrn',
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
                url: '/BackOffice/public/bo/transaksi/pemusnahan/brgrusak/getplu',
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

        function proses() {
            // var myRows = [];
            // var $headers = $("th");
            // var $rows = $("tbody tr").each(function (index) {
            //     $cells = $(this).find("td input");
            //     myRows[index] = {};
            //     $cells.each(function (cellIndex) {
            //         myRows[index][$($headers[cellIndex]).html()] = $(this).val();
            //     });
            // });
            //
            // // Let's put this in the object like you want and convert to JSON (Note: jQuery will also do this for you on the Ajax request)
            // var myObj = {};
            // myObj.myrows = myRows;
            // var datas = myObj['myrows']
            // console.log(datas)

            window.open('/BackOffice/public/test');
        }

        //Function for Table
        $(function () {
            $('#table2').SetEditable({
                $addButton: $('#but_add'),
                columnsEd: "0,1,2,3"
            });
        })


        function deleteRow(e) {
            $(e).parents("tr").remove();
        }




    </script>

@endsection
