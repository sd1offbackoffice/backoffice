@extends('navbar')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-7">
                <fieldset class="card border-dark">
                    <legend  class="w-auto ml-5">Master Outlet</legend>
                    <div class="card-body cardForm">
                        <table class="table table-sm table-bordered shadow-sm fixed_header">
                            <thead>
                            <tr>
                                <th class="text-center">Kode</th>
                                <th class="thForNamaOutlet">Nama Outlet</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($outlet as $data)
                                <tr>
                                    <td class="text-center">{{$data->out_kodeoutlet}}</td>
                                    <td class="tdForNamaOutlet">{{$data->out_namaoutlet}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <style>
        .fixed_header{
            /*width: 400px;*/
            table-layout: fixed;
            border-collapse: collapse;
        }

        .fixed_header tbody{
            display:block;
            overflow:auto;
            height:300px;
            /*width:100%;*/
        }

        .fixed_header thead {
            background: black;
            color:#fff;
        }

        .fixed_header th, .fixed_header td {
            padding: 5px;
            text-align: left;
            width: 100px;
        }

        .fixed_header .thForNamaOutlet , .fixed_header .tdForNamaOutlet  {
            padding: 5px;
            text-align: left;
            width: 84%;
        }

        .fixed_header thead tr{
            display:block;
        }
    </style>





@endsection
