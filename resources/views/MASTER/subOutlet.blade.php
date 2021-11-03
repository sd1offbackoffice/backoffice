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
                                <table class="table table-sm table-bordered shadow-sm fixed_header" id="tableOutlet">
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


    <script>
        $('.tbodyTableSubOutlet').on('click', function () {
            $('.tbodyTableSubOutlet').removeClass("table-primary");
            $(this).addClass("table-primary");
            let outlet = $(this).attr('id');

            viewSubOutlet(outlet)
        })

        function viewSubOutlet(outlet){
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/getsuboutlet',
                type: 'post',
                data:{outlet:outlet},
                beforeSend : function (){
                    $('#tbodyTableGetSubOutlet').html("");
                }, success: function (result) {
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
        }


        // Untuk tombol Up Arrow dan Down Arrow
        // * Data table dimulai dari index ke 0, tapi index tr  dimulai dari 1, karena index tr 0 adalah thead. Jadi data index ke 0 ada di tr ke 1 dst. Oleh karna itu ada +1 untuk dibagian tr active
        $(window).bind('keydown', function(event) {
            if (event.which == 40){ // Down Arrow
                let indexActiveOutlet = $('.table-primary').children().first().text();
                if (!indexActiveOutlet) {
                    viewSubOutlet(0)
                    $('#tableOutlet tr:eq(1)').addClass("table-primary")
                } else {
                    $('.tbodyTableSubOutlet').removeClass("table-primary");
                    let nextActiveOutlet = parseInt(indexActiveOutlet) + 1
                    $(`#tableOutlet tr:eq(${nextActiveOutlet + 1})`).addClass("table-primary")
                    viewSubOutlet(nextActiveOutlet)
                }
            }
             else if (event.which == 38){ // Up Arrow
                let indexActiveOutlet = $('.table-primary').children().first().text();
                if (!indexActiveOutlet) {
                    viewSubOutlet(0)
                    $('#tableOutlet tr:eq(1)').addClass("table-primary")
                } else if(indexActiveOutlet == 0){
                    $('.tbodyTableSubOutlet').removeClass("table-primary");
                    viewSubOutlet(6)
                    $('#tableOutlet tr:eq(7)').addClass("table-primary")
                } else {
                    $('.tbodyTableSubOutlet').removeClass("table-primary");
                    let nextActiveOutlet = parseInt(indexActiveOutlet) - 1;
                    viewSubOutlet(nextActiveOutlet)
                    $(`#tableOutlet tr:eq(${nextActiveOutlet + 1})`).addClass("table-primary")
                }
            }
        });
    </script>




@endsection
