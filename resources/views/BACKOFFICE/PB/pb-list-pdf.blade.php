@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LISTING ITEM(S) YANG DAPAT DIBENTUK PB MANUAL DI TOKO IGR
@endsection

@section('title')
    LISTING ITEM(S) YANG DAPAT DIBENTUK PB MANUAL DI TOKO IGR
@endsection

@section('subtitle')
    Tgl : {{ $tgl1 }} s/d {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah">No.</th>
            <th colspan="2" class="center">------------------------------------------- BARANG DAGANGAN -------------------------------------------</th>
            <th colspan="2" class="center">--------------- PERIODE BERLAKU ---------------</th>
            <th rowspan="2" class="tengah">Tgl. Input</th>
            <th rowspan="2" class="tengah">User ID</th>
        </tr>
        <tr>
            <th class="center">PLU</th>
            <th class="center">Deskripsi</th>
            <th class="center">Tgl. Awal</th>
            <th class="center">Tgl. Akhir</th>
        </tr>
        </thead>
        <tbody>
        @php
            $no = 1;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="left">{{ $no++ }}</td>
                <td class="center">{{ $d->plu }}</td>
                <td class="left">{{ $d->deskripsi }}</td>
                <td class="center">{{ $d->tglawal }}</td>
                <td class="center">{{ $d->tglakhir }}</td>
                <td class="center">{{ $d->ppb_create_dt }}</td>
                <td class="center">{{ $d->ppb_create_by }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
