@extends('navbar')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <fieldset class="card border-dark">
                    <legend  class="w-auto ml-5">Aktifkan Harga Jual</legend>
                    <div class="card-body cardForm">
                        <form class="form">
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Kode Plu</label>
                                <input type="text" id="kodePlu" class="form-control col-sm-2 mx-sm-1" onchange="getDetailPlu(this.value)">
                                <button class="btn ml-2" type="button" data-toggle="modal" data-target="#m_prodmast"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                <input type="text" id="#" class="form-control col-sm-5 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Divisi</label>
                                <input type="text" id="#" class="form-control col-sm-1 mx-sm-1" disabled>
                                <input type="text" id="#" class="form-control col-sm-4 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Department</label>
                                <input type="text" id="#" class="form-control col-sm-1 mx-sm-1" disabled>
                                <input type="text" id="#" class="form-control col-sm-4 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Kategori Barang</label>
                                <input type="text" id="#" class="form-control col-sm-1 mx-sm-1" disabled>
                                <input type="text" id="#" class="form-control col-sm-4 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Harga Jual Lama</label>
                                <input type="text" id="#" class="form-control col-sm-2 mx-sm-1" disabled>
                            </div>
                            <div class="form-group row mb-0">
                                <label class="col-sm-4 col-form-label text-md-right">Harga Jual Baru</label>
                                <input type="text" id="#" class="form-control col-sm-2 mx-sm-1" disabled>
                            </div>

                            <button type="button" class="btn btn-primary pl-4 pr-4 float-right">Aktifkan</button>
                        </form>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade" id="m_prodmast" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="searchProdmast" class="form-control search_lov" type="text" placeholder="Inputkan Nama / Kode Barang" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov">
                                    <thead>
                                    <tr>
                                        <td>Kode Barang</td>
                                        <td>Nama Barang</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($prodmast as $data)
                                        <tr onclick="lov_select('{{ $data->prd_prdcd }}')" class="row_lov">
                                            <td>{{ $data->prd_prdcd }}</td>
                                            <td>{{ $data->prd_deskripsipanjang }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // function getProdmast() {
        //     ajaxSetup();
        //     $.ajax({
        //         url: '/BackOffice/public/mstaktifhrgjual/getprodmast',
        //         type: 'post',
        //         data:({}),
        //         success: function (result) {
        //             $('#m_prodmast').modal('show');
        //         }, error : function () {
        //             swal("Error",'','error');
        //         }
        //     })
        // }

        $('#searchProdmast').keypress(function (e) {
            if (e.which === 13) {
                if ($(this).val().length < 3) {
                    $('.invalid-feedback').show();
                } else {
                    $('.invalid-feedback').hide();
                    ajaxSetup();
                    $.ajax({
                        url: '/BackOffice/public/mstaktifhrgjual/getprodmast',
                        type: 'post',
                        data:({search:$(this).val()}),
                        success: function (result) {

                        }, error : function () {
                            swal("Error",'','error');
                        }
                    })
                }
            }
        });

        function getDetailPlu(plu) {
            if (plu.length > 7){
                swal('Warning', "Kode Plu tidak boleh lebih dari 7", 'warning')
            } else {
                let max = plu.length;
                for (let i =0; i<(7-max); i++){
                    plu = '0'+plu;
                }

                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/mstaktifhrgjual/getdetailplu',
                    type: 'post',
                    data:({plu:plu}),
                    success: function (result) {
                        console.log(result)
                    }, error : function () {
                        swal("Error",'','error');
                    }
                })
            }
        }
    </script>





@endsection
