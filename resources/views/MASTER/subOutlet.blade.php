@extends('navbar')
@section('title','MASTER | MASTER SUB OUTLET')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="row justify-content-center">
                            <div class="col-sm-12 col-md-6">
                                <table class="table table-sm table-bordered shadow-sm fixed_header">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th class="text-center">Kode</th>
                                        <th class="thForNamaOutlet">Nama Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($outlet as $data)
                                        <tr class="tbodyTableSubOutlet row_lov" id="{{$data->out_kodeoutlet}}">
                                            <td class="text-center">{{$data->out_kodeoutlet}}</td>
                                            <td class="thForNamaOutlet">{{$data->out_namaoutlet}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <table class="table table-sm table-bordered shadow-sm fixed_header">
                                    <thead class="theadDataTables">
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
                </div>
            </div>
        </div>
    </div>

    <style>
        /*.tbodyTableSubOutlet:hover {*/
        /*    cursor: pointer;*/
        /*    background-color: grey;*/
        /*}*/

        /*.fixed_header tbody{*/
        /*    display:block;*/
        /*    overflow:auto;*/
        /*    height:300px;*/
        /*    !*width:100%;*!*/
        /*}*/

        /*.fixed_header thead {*/
        /*    background: black;*/
        /*    color:#fff;*/
        /*}*/

        /*.fixed_header th, .fixed_header td {*/
        /*    padding: 5px;*/
        /*    text-align: left;*/
        /*    width: 100px;*/
        /*}*/

        /*.fixed_header .thForNamaOutlet , .fixed_header .tdForNamaOutlet  {*/
        /*    padding: 5px;*/
        /*    text-align: left;*/
        /*    width: 84%;*/
        /*}*/

        /*.fixed_header thead tr{*/
        /*    display:block;*/
        /*}*/
    </style>

    <script>
        $('.tbodyTableSubOutlet').on('click', function () {
            $('.tbodyTableSubOutlet').removeClass("table-primary");
            $(this).addClass("table-primary");
            let outlet = $(this).attr('id');

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstsuboutlet/getsuboutlet',
                type: 'post',
                data:{outlet:outlet},
                success: function (result) {
                    $('#tbodyTableGetSubOutlet').html("");
                    if (result.length > 0) {
                        for (i=0 ; i < result.length; i++){
                            $('#tbodyTableGetSubOutlet').append(` <tr>
                                                                 <td class="text-center">`+ result[i]['sub_kodesuboutlet'] +`</td>
                                                                 <td class="thForNamaOutlet">`+ result[i]['sub_namasuboutlet'] +`</td>
                                                              </tr>`)
                        }
                    } else {
                        $('#tbodyTableGetSubOutlet').append(` <tr>
                                                                 <td class="text-center">--</td>
                                                                 <td class="thForNamaOutlet">--</td>
                                                              </tr>`)
                    }

                }, error: function (err) {
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            });
        })
    </script>




@endsection
