@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Monitoring Stok Item Pareto
@endsection

@section('title')
    ** MONITORING STOK ITEM PARETO **
@endsection

@section('subtitle')
    STOK <50% PKMT
@endsection

@section('header_left')
    <p>Tabel Monitoring : {{ $monitoring->kode }} - {{ $monitoring->nama }}</p>
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">PLU</th>
            <th class="tengah" rowspan="2">DESKRIPSI</th>
            <th class="tengah" rowspan="2">SATUAN</th>
            <th class="right" colspan="2">OUTSTAND PO</th>
            <th class="tengah" colspan="3">SALES 3 BULAN</th>
            <th class="right" rowspan="2">HARI<br>SALES</th>
            <th class="right" colspan="2">AVG SALES</th>
            <th class="right" rowspan="2">SALDO<br>SAAT INI</th>
            <th class="right" rowspan="2">PKMT</th>
        </tr>
        <tr>
            <th class="right">JML</th>
            <th class="right">QTY</th>
            <th class="right">BLN-1</th>
            <th class="right">BLN-2</th>
            <th class="right">BLN-3</th>
            <th class="right">BULAN</th>
            <th class="right">HARI</th>
        </tr>
        </thead>
        <tbody>
        @php
            $div = '';
            $dep = '';
            $kat = '';
        @endphp
        @foreach($data as $d)
            @if($div != $d->div || $dep != $d->dep || $kat != $d->kat)
                @php
                    $div = $d->div;
                    $dep = $d->dep;
                    $kat = $d->kat;
                @endphp
                <tr>
                    <td colspan="13" class="left"><strong>DIV {{ $d->div }} {{ $d->nmdiv }} - DEPT {{ $d->dep }} {{ $d->nmdep }} - KAT {{ $d->kat }} {{ $d->nmkat }}</strong></td>
                </tr>
            @endif
            <tr>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->deskripsi }}</td>
                <td>{{ $d->satuan }}</td>
                <td class="right">{{ number_format($d->outpo) }}</td>
                <td class="right">{{ number_format($d->outqty) }}</td>
                <td class="right">{{ number_format($d->qty3) }}</td>
                <td class="right">{{ number_format($d->qty2) }}</td>
                <td class="right">{{ number_format($d->qty1) }}</td>
                <td class="right">{{ number_format($d->cp_hari) }}</td>
                <td class="right">{{ number_format($d->cp_avgbulan) }}</td>
                <td class="right">{{ number_format($d->cp_avghari) }}</td>
                <td class="right">{{ number_format($d->saldoakhir) }}</td>
                <td class="right">{{ number_format($d->pkmt) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
