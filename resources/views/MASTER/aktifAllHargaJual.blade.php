@extends('navbar')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <fieldset class="card border-dark">
                    <legend  class="w-auto ml-5">Aktifkan Harga Jual All Item</legend>
                    <div class="card-body cardForm">
                        <form class="form mb-5">
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-5">
                                    <button type="button" id="btnAktifkanHrg" class="btn btn-primary btn-block btnAktifkanHrg" onclick="aktifkanAllItem()">Aktifkan Harga Jual All Item</button>
                                </div>
                            </div>
                        </form>

                        <table class="table table bordered table-sm mt-3" id="tableAktifkanAll">
                            <thead style="background-color: #5AA4DD; color: white">
                            <tr class="text-center">
                                <th class="">PLU</th>
                                <th class="">Deskripsi</th>
                                <th class="">Harga Lama</th>
                                <th class="">Harga Baru</th>
                            </tr>
                            </thead>
                            <tbdoy>
                                @foreach($getData as $data)
                                    <tr>
                                        <td>{{$data->prd_prdcd}}</td>
                                        <td>{{$data->prd_deskripsipanjang}}</td>
                                        <td>{{$data->prd_hrgjual}}</td>
                                        <td>{{$data->prd_hrgjual3}}</td>
                                    </tr>
                                @endforeach
                            </tbdoy>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $('#tableAktifkanAll').DataTable({
                "lengthChange": false,
                "ordering" : false,
                scrollY : 460,
                "columns": [
                    { "width": "10%" },
                    null,
                    { "width": "15%" },
                    { "width": "15%" }
                ]
            });
        });

        function aktifkanAllItem() {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/mstaktifallhrgjual/aktifallitem',
                type:'post',
                beforeSend: function(){
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    swal('SUCCESS', result, 'success')
                    location.reload();
                }, error : function (error) {
                    $('#modal-loader').modal('hide');
                    console.log(error)
                    swal("Error",'','error');
                }
            })
        }
    </script>

@endsection
