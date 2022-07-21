@extends('navbar')
@section('title','MASTER | MASTER OUTLET')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-7">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <table class="table table-sm table-bordered shadow-sm fixed_header">
                            <thead class="theadDataTables">
                            <tr>
                                <th class="text-center">@lang('Kode')</th>
                                <th class="thForNamaOutlet">@lang('Nama Outlet')</th>
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
                </div>
            </div>
        </div>
    </div>

@endsection
