@extends('navbar')
@section('content')


    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-5">Master Hari Libur</legend>
                    <div class="card-body shadow-lg cardForm">


                        <div class="tableFixedHeader">
                            <table class="table table-sm table-hover table-bordered" id="table-harilibur">
                                <thead class="thead-dark">
                                <tr>
                                    {{--<th scope="col">#</th>--}}
                                    {{--<th scope="col">First</th>--}}
                                    <th class="col-sm-2">TANGGAL</th>
                                    <th class="col-sm-5">KETERANGAN</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($harilibur as $dataHariLibur)
                                    <tr class="row_harilibur justify-content-md-center p-0">
                                        <td class="col-4">{{ date('d F Y', strtotime($dataHariLibur->lib_tgllibur)) }}</td>
                                        <td class="col-8">{{$dataHariLibur->lib_keteranganlibur}}</td>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                        <br>
                        <div class="form-group row">
                            <label for="i_tgl" class=" col-sm-2 col-form-label text-right">TANGGAL</label>
                            <div class="col-sm-3">
                                <td>
                                    <input type="date" class="form-control col-sm-8 " data-date-format="DD MMMM YYYY" id="i_tgl" placeholder="..." )>
                                </td>
                                <td>
                                <input type="text" class="form-control" id="i_keterangan" placeholder="...">
                                </td>
                            </div>
                            {{--<div class="col-sm-3">--}}
                                {{--<div >--}}
                                    {{--<button class="btn btn-success" id="btn-search" onclick="search_barcode()">SEARCH</button>--}}
                                    {{--<button class="btn btn-success" id="btn-clear" onclick="clear_table()">CLEAR</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
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

        .row_harilibur:hover{
            cursor: pointer;
            background-color: grey;
        }


        /*.tableFixedHeader          { overflow-y: auto; height: 300px; }*/
        /*.tableFixedHeader thead th { position: sticky; top: 0; }*/
        /*.tableFixedHeader th     { background:#eee; }*/
        /*.tableFixedHeader table  { border-collapse: collapse; width: 100%; }*/
        /*.tableFixedHeader th, td { padding: 8px 16px; }*/


    </style>



    <script>

        // $("#i_tgl").datepicker({
        //     "dateFormat" : "dd/mm/yy"
        // });

    </script>

@endsection
