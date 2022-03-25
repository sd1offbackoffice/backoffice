@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    BERITA ACARA Adjustment Stock Virtual
@endsection

@section('title')
    BERITA ACARA
@endsection

@section('subtitle')
    Adjustment Stock Virtual<br>
    Nomor : {{ $noba }}
@endsection

@section('content')
    <h3>{{ $judul }}</h3>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah">No.</th>
            <th rowspan="2" class="tengah">PLU</th>
            <th rowspan="2" class="tengah">Deskripsi</th>
            <th colspan="3" class="center">----- Kuantitas Stock Virtual -----</th>
            <th rowspan="2" class="tengah left padding-left">Keterangan</th>
        </tr>
        <tr>
            <th class="right">---- Data</th>
            <th class="right">---- Fisik</th>
            <th class="right">---- Selisih</th>
        </tr>
        </thead>
        <tbody>
        @php
            $no = 1;
            $totData = 0;
            $totFisik = 0;
            $totSelisih = 0;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="left">{{ $no++ }}</td>
                <td class="center">{{ $d->bac_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td class="right">{{ $d->bac_qty_stock }}</td>
                <td class="right">{{ $d->bac_qty_ba }}</td>
                <td class="right">{{ $d->selisih }}</td>
                <td class="left padding-left">{{ $d->bac_keterangan }}</td>
            </tr>

            @php
                $totData += $d->bac_qty_stock;
                $totFisik += $d->bac_qty_ba;
                $totSelisih += $d->selisih;
            @endphp
        @endforeach
            <tr style="border-top: 1px solid black">
                <td colspan="3" class="right">TOTAL</td>
                <td class="right">{{ $totData }}</td>
                <td class="right">{{ $totFisik }}</td>
                <td class="right">{{ $totSelisih }}</td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
