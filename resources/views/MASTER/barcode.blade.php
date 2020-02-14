@extends('navbar')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Barcode</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="my-custom-scrollbar table-wrapper-scroll-y">
                            <table class="table table-sm border-bottom  justify-content-md-center" id="table-barcode">
                                <thead class="thead-dark">
                                <tr class="row justify-content-md-center p-0">
                                    <th class="col-sm-5">Barcode</th>
                                    <th class="col-sm-4">PRDCD</th>
                                    <th class="col-sm-2">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($barcode as $dataBarcode)
                                <tr class="row baris justify-content-md-center p-0">
                                    <td class="col-sm-5 pt-0 pb-0" >
                                        <input type="text" class="form-control" disabled value="{{$dataBarcode->brc_barcode}}">
                                    </td>
                                    <td class="col-sm-4 pt-0 pb-0">
                                        <input type="text" class="form-control" disabled value="{{$dataBarcode->brc_prdcd}}">
                                    </td>
                                    <td class="col-sm-2 pt-0 pb-0">
                                        <input type="text" class="form-control" disabled value="{{$dataBarcode->brc_status}}">
                                    </td>
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="form-group row">
                            <label for="i_prdcd" class=" col-sm-2 col-form-label text-right">PRDCD</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="i_prdcd" placeholder="...">
                            </div>
                            <div class="col-sm-3">
                                <div >
                                    <button class="btn btn-success" id="btn-search" onclick="search_barcode()">SEARCH</button>
                                    <button class="btn btn-success" id="btn-clear" onclick="clear_table()">CLEAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="vertical-align: middle;">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="loader" id="loader"></div>
                            <div class="col-sm-12">
                                <label for="">LOADING...</label>
                            </div>
                        </div>
                    </div>
                </div>
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
            /*color: #8A8A8A;*/
            font-weight: bold;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .my-custom-scrollbar {
            position: relative;
            height: 350px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .table-wrapper-scroll-y {
            display: block;
        }
    </style>

    <script>
        function tambah_row() {
            $('#table-barcode').append('<tr class="row baris justify-content-md-center"><td class="col-sm-5 pt-0 pb-0" ><input type="number" class="form-control" disabled></td><td class="col-sm-4 pt-0 pb-0"><input type="number" class="form-control" disabled></td><td class="col-sm-2 pt-0 pb-0"><input type="text" class="form-control" disabled></td></tr>');
        }
        function clear_table() {
            $('.baris').remove();
            tambah_row();
            $('#i_prdcd').val("");
        }

        $('#i_prdcd').keypress(function(e) {
            if (e.keyCode == 13) {
                convert_plu();
                search_barcode();
            }
        });

        function convert_plu() {
            var plu = $('#i_prdcd').val();
            console.log(plu.length);
            for(var i = plu.length ; i < 7 ; i++){
                plu='0'+plu;
            }
            $('#i_prdcd').val(plu);
        }
        function search_barcode() {
            convert_plu();
            var prdcd = $('#i_prdcd').val();
            $.ajax({
                url: '/BackOffice/public/mstbarcode/search_barcode',
                type:'POST',
                data:{"_token":"{{ csrf_token() }}",value:prdcd},
                beforeSend: function(){
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function(response){
                    $('.baris').remove();
                    if (response.length == 0){
                        swal({
                            title: 'Tidak ada data Barcode!',
                            icon: 'warning'
                        }).then((createData) => {
                            if (createData) {

                            }
                        });
                    }
                    else {
                        for(i=0;i<response.length;i++){
                            html = '<tr class="row baris justify-content-md-center"><td class="col-sm-5 pt-0 pb-0" ><input type="text" class="form-control" disabled value="'+response[i].brc_barcode+'"></td><td class="col-sm-4 pt-0 pb-0"><input type="text" class="form-control" disabled value="'+response[i].brc_prdcd+'"></td><td class="col-sm-2 pt-0 pb-0"><input type="text" class="form-control" disabled value="'+response[i].brc_status+'"></td></tr>';
                            $('#table-barcode').append(html);
                        }
                    }
                },
                complete: function(){
                    $('#modal-loader').modal('hide');
                }
            });
        }



    </script>

@endsection

