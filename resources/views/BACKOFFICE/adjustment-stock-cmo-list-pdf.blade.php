@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Listing Adjustment Stock Virtual Commit Order
@endsection

@section('title')
    Listing Adjustment Stock Virtual Commit Order
@endsection

@section('subtitle')
    Tgl : {{ $tgl1 }} s/d {{ $tgl2 }}
@endsection

@section('content')
    <h3 class="right">(dalam kuantitas pcs.)</h3>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah">No.</th>
            <th colspan="2" class="tengah">----- PLU -----</th>
            <th rowspan="2" class="tengah">----- Deskripsi -----</th>
            <th colspan="2" class="center">----- BA -----</th>
            <th colspan="3" class="center">----- Kuantitas -----</th>
            <th rowspan="2" class="tengah">Tgl</th>
            <th rowspan="2" class="tengah">User</th>
        </tr>
        <tr>
            <th class="center">Idm.</th>
            <th class="center">Igr.</th>
            <th class="center">No. Ref</th>
            <th class="center">Tgl</th>
            <th class="right">Awal</th>
            <th class="right">Adjust</th>
            <th class="right">Akhir</th>
        </tr>
        </thead>
        <tbody>
        @php
            $no = 1;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="left">{{ $no++ }}</td>
                <td class="center">{{ $d->prc_pluidm }}</td>
                <td class="center">{{ $d->bac_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td class="center">{{ $d->bac_noba }}</td>
                <td class="center">{{ $d->bac_tglba }}</td>
                <td class="right">{{ $d->bac_qty_stock }}</td>
                <td class="right">{{ $d->bac_qty_selisih }}</td>
                <td class="right">{{ $d->bac_qty_adj }}</td>
                <td class="center">{{ $d->bac_tgladj }}</td>
                <td class="center">{{ $d->bac_modify_by }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
