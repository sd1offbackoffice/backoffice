@extends('navbar')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend  class="w-auto ml-5">Master Sub Outlet</legend>
                    <div class="card-body cardForm">
                        <div class="row justify-content-center">
                            <div class="col-sm-12 col-md-6">
                                <table class="table table-sm table-bordered shadow-sm fixed_header">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Kode</th>
                                        <th class="thForNamaOutlet">Nama Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($outlet as $data)
                                        <tr class="tbodyTableSubOutlet" id="{{$data->out_kodeoutlet}}">
                                            <td class="text-center">{{$data->out_kodeoutlet}}</td>
                                            <td class="thForNamaOutlet">{{$data->out_namaoutlet}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <table class="table table-sm table-bordered shadow-sm fixed_header">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Kode</th>
                                        <th class="thForNamaOutlet">Nama Sub Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyTableGetSubOutlet">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <style>
        .tbodyTableSubOutlet:hover {
            cursor: pointer;
            background-color: grey;
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

    <script>
        $('.tbodyTableSubOutlet').on('click', function () {
            $('.tbodyTableSubOutlet').removeClass("table-success");
            $(this).addClass("table-success");
            let outlet = $(this).attr('id');

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstsuboutlet/getsuboutlet',
                type: 'post',
                data:{outlet:outlet},
                success: function (result) {
                    $('#tbodyTableGetSubOutlet').html("");
                    for (i=0 ; i < result.length; i++){
                        $('#tbodyTableGetSubOutlet').append(` <tr>
                                                                 <td class="text-center">`+ result[i]['sub_kodesuboutlet'] +`</td>
                                                                 <td class="thForNamaOutlet">`+ result[i]['sub_namasuboutlet'] +`</td>
                                                              </tr>`)
                    }
                }, error: function () {
                    swal("Error","", "error");
                }
            });
        })
    </script>




@endsection
