@extends('html-template')

@section('table_font_size','7 px')
@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    LAPORAN REKOMENDASI STATUS PERUBAHAN ITEM(S)
@endsection

@section('title')
    LAPORAN REKOMENDASI STATUS PERUBAHAN ITEM(S)
@endsection

@section('subtitle')
    Tanggal : {{ $periode }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="left">No.</th>
            <th rowspan="2" class="center">PLU</th>
            <th rowspan="2" class="left">Deskripsi</th>
            <th class="center">Dijual di</th>
            <th rowspan="2" class="center">Tag</th>
            <th rowspan="2" class="right">Frac</th>
            <th rowspan="2" class="right">Min.Or</th>
            <th class="right">Avg Sales per</th>
            <th rowspan="2" class="right">PKM</th>
            <th class="right">PKM + 50%</th>
            <th class="right">Max</th>
            <th class="right">Max</th>
            <th class="center">Status</th>
            <th class="center">Rekomendasi</th>
        </tr>
        <tr>
            <th class="center">IDM / OMI</th>
            <th class="right">Day ( 3 bln )</th>
            <th class="right">Min.Or</th>
            <th class="right">Display</th>
            <th class="right">Pallet</th>
            <th class="center">Sekarang</th>
            <th class="center">Status</th>
        </tr>
        </thead>
        <tbody>
        @php
            $no = 1;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="left">{{ $no++ }}</td>
                <td class="center">{{ $d->pkm_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td class="center">{{ $d->idmomi }}</td>
                <td class="center">{{ $d->prd_kodetag }}</td>
                <td class="right">{{ $d->prd_frac }}</td>
                <td class="right">{{ $d->prd_minorder }}</td>
                <td class="right">{{ round($d->pkm_qtyaverage) }}</td>
                <td class="right">{{ $d->pkm_pkmt }}</td>
                <td class="right">{{ $d->pkmtmin }}</td>
                <td class="right">{{ $d->lks_maxdisplay }}</td>
                <td class="right">{{ $d->mpt_maxqty }}</td>
                <td class="center">{{ $d->status }}</td>
                <td class="center">{{ $d->rekomendasi }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
