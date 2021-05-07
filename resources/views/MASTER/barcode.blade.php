@extends('navbar')
@section('title','MASTER | MASTER BARCODE')
@section('content')


    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <table class="table table-striped table-bordered" id="table-barcode">
                            <thead class="theadDataTables">
                            <tr class="">
                                <th>Barcode</th>
                                <th>PRDCD</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            @foreach($barcode as $dataBarcode)--}}
{{--                                <tr class="p-0 baris">--}}
{{--                                    <td>{{$dataBarcode->brc_barcode}}</td>--}}
{{--                                    <td>{{$dataBarcode->brc_prdcd}}</td>--}}
{{--                                    <td>{{$dataBarcode->brc_status}}</td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function (){
            $('#table-barcode').DataTable({
                "ajax": '{{ url('mstbarcode/getbarcode') }}',
                "columns": [
                    {data: 'brc_barcode', name: 'brc_barcode'},
                    {data: 'brc_prdcd', name: 'brc_prdcd'},
                    {data: 'brc_status', name: 'brc_status'},
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
                "order": []
            });
        })


    </script>

@endsection

