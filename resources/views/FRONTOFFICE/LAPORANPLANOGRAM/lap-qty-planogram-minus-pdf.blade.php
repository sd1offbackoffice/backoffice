@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN QTY PLANOGRAM MINUS
@endsection

@section('title')
    LAPORAN QTY PLANOGRAM MINUS
@endsection

@section('content')

<table class="table">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
        <th align="right" class="padding-right">NO.</th>
        <th align="left">LOKASI</th>
        <th align="right" class="padding-right">QTY</th>
        <th align="left">PLU</th>
        <th align="left">DESKRIPSI</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total = 0;
        $i=1;
    @endphp

    @if(sizeof($data)!=0)
        @foreach($data as $d)
            <tr>
                <td align="right" class="padding-right">{{ $i }}</td>
                <td align="left">{{ $d->lokasi }}</td>
                <td align="right" class="padding-right">{{ number_format($d->lks_qty, 0,".",",") }}</td>
                <td align="left">{{ $d->lks_prdcd }}</td>
                <td align="left">{{ $d->prd_deskripsipanjang}}</td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
    @else
        <tr>
            <td colspan="10">TIDAK ADA DATA</td>
        </tr>
    @endif
    </tbody>
    <tfoot>
    </tfoot>
</table>
@endsection
