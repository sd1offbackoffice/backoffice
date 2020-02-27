@extends('navbar')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-6">Master Hari Libur</legend>
                    <div class="card-body shadow-lg cardForm">



                        <div class="tableFixedHeader">

                            {{--<table class="table table-sm border-bottom table-hover justify-content-md-center" id="table-harilibur">--}}
                                <table class="table table-sm table-hover table-bordered">

                                <thead class="thead-dark">
                                {{--<tr class="row justify-content-md-center p-0" >--}}
                                <table class="table table-sm table-hover table-bordered">
                                    <th scope="col">Tanggal.</th>
                                    <th scope="col">Keterangan</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($harilibur as $dataHariLibur)
                                    <tr class="row baris justify-content-md-center p-0">
                                        <td class="col-sm-3 pt-0 pb-0" >
                                            <input type="text" class="form-control" disabled value=" {{ date('d-m-Y', strtotime($dataHariLibur->lib_tgllibur)) }}">
                                        </td>
                                        <td class="col-sm-6 pt-0 pb-0">
                                            <input type="text" class="form-control" disabled value="{{$dataHariLibur->lib_keteranganlibur}}">
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                            </div>

                        <div class="tableFixedHeader">
                            <table class="table table-sm table-hover table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Keterangan</th>
                                </tr>
                                </thead>
                                @foreach($harilibur as $dataHariLibur)
                                    <tr class="row baris justify-content-md-center p-0">
                                        <td class="col-sm-3 pt-0 pb-0" >
                                            <input type="text" class="form-control" disabled value=" {{ date('d-m-Y', strtotime($dataHariLibur->lib_tgllibur)) }}">
                                        </td>
                                        <td class="col-sm-6 pt-0 pb-0">
                                            <input type="text" class="form-control" disabled value="{{$dataHariLibur->lib_keteranganlibur}}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <br>
                        {{--<div class="form-group row">
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
                        </div>--}}
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <style>
        /*body {*/
            /*background-color: #edece9;*/
            /*!*background-color: #ECF2F4  !important;*!*/
        /*}*/
        /*label {*/
            /*color: #232443;*/
            /*!*color: #8A8A8A;*!*/
            /*font-weight: bold;*/
        /*}*/
        /*input[type=number]::-webkit-inner-spin-button,*/
        /*input[type=number]::-webkit-outer-spin-button,*/
        /*input[type=date]::-webkit-inner-spin-button,*/
        /*input[type=date]::-webkit-outer-spin-button{*/
            /*-webkit-appearance: none;*/
            /*margin: 0;*/
        /*}*/
        /*.cardForm {*/
            /*box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);*/
        /*}*/
        .my-custom-scrollbar {
            position: relative;
            height: 350px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        .table-wrapper-scroll-y {
            display: block;
        }
        .navbar-fixed {
            top: 0;
            z-index: 100;
            position: fixed;
            width: 100%;
        }

        /*.tableFixedHeader          { overflow-y: auto; height: 300px; }*/
        /*.tableFixedHeader thead th { position: sticky; top: 0; }*/
        /*.tableFixedHeader th     { background:#eee; }*/
        /*.tableFixedHeader table  { border-collapse: collapse; width: 100%; }*/
        /*.tableFixedHeader th, td { padding: 8px 16px; }*/


    </style>



    {{--<script>--}}

        {{--$(document).ready(function () {--}}
            {{--$('#table-harilibur').DataTable({--}}
                {{--"lengthChange": false,--}}
                {{--"ordering" : false,--}}
                {{--"searching": false--}}
                {{--sc--}}
                {{--//scrollY : 500,--}}
            {{--});--}}
           {{--// $('.dataTables_length').addClass('bs-select');--}}
        {{--});--}}

    {{--</script>--}}

@endsection
