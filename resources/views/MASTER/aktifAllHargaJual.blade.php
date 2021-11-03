@extends('navbar')
@section('title','MASTER | AKTIFKAN HARGA JUAL ALL ITEM')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
               <div class="card border-dark">
                   <div class="card-body cardForm">
                       <form class="form mb-5">
                           <div class="row justify-content-center">
                               <div class="col-sm-12 col-md-5">
                                   <button type="button" id="btnAktifkanHrg" class="btn btn-primary btn-lg btn-block btnAktifkanHrg" onclick="aktifkanAllItem()">Aktifkan Harga Jual All Item</button>
                               </div>
                           </div>
                       </form>

                       <table class="table table bordered table-sm mt-3" id="tableAktifkanAll">
                           <thead class="theadDataTables">
                           <tr class="text-center">
                               <th class="">PLU</th>
                               <th class="">Deskripsi</th>
                               <th class="">Harga Lama</th>
                               <th class="">Harga Baru</th>
                           </tr>
                           </thead>
                           <tbdoy>
{{--                               @foreach($getData as $data)--}}
{{--                                   <tr>--}}
{{--                                       <td>{{$data->prd_prdcd}}</td>--}}
{{--                                       <td>{{$data->prd_deskripsipanjang}}</td>--}}
{{--                                       <td class="text-right">{{$data->prd_hrgjual}}</td>--}}
{{--                                       <td class="text-right">{{$data->prd_hrgjual3}}</td>--}}
{{--                                   </tr>--}}
{{--                               @endforeach--}}
                           </tbdoy>
                       </table>
                   </div>
               </div>
            </div>
        </div>
    </div>


    <script>
        let tableData = $('#tableAktifkanAll').DataTable();
        $(document).ready(function () {
            // $('#tableAktifkanAll').DataTable({
            //     "lengthChange": false,
            //     "ordering" : false,
            //     scrollY : 460,
            //     "columns": [
            //         { "width": "10%" },
            //         null,
            //         { "width": "15%" },
            //         { "width": "15%" }
            //     ]
            // });
            getData();
        });

        function getData(){
            tableData.destroy();
            tableData =  $('#tableAktifkanAll').DataTable({
                "ajax": {
                    'url' : '{{url()->current()}}/getdata',
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd', width : '10%'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang', width : '60%'},
                    {data: 'prd_hrgjual', name: 'prd_hrgjual', width : '15%'},
                    {data: 'prd_hrgjual3', name: 'prd_hrgjual3', width : '15%'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                },
                "order": [],
                columnDefs : [
                ]
            });
        }

        function aktifkanAllItem() {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/aktifallitem',
                type:'post',
                beforeSend: function(){
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    swal('SUCCESS', result, 'success')
                    getData();
                    // setTimeout(function(){location.reload()}, 2000);
                }, error : function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }
    </script>

@endsection
