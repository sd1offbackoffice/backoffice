@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    MONITORING SALES & STOK SUPER FAST MOVING PRODUCT
@endsection

@section('title')
    MONITORING SALES & STOK SUPER FAST MOVING PRODUCT<br>
    AVG SALES 3 BULAN : {{$namaBulan}}
@endsection

@section('subtitle')
    Margin : {{ $periode }}
    Kode Monitoring : {{ $kodemonitoring }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah center">NO.</th>
            <th class="tengah center">PLU</th>
            <th class="tengah center">DESKRIPSI</th>
            <th class="tengah center">KEMASAN</th>
            <th class="tengah center">AVG SALES</th>
            <th class="tengah center">AVG SALES QTY</th>
            <th class="tengah center">SALES QTY</th>
            <th class="tengah center">MARGIN</th>
            <th class="tengah center">%</th>
            <th class="tengah center">SALDO AKHIR</th>
            <th class="tengah center">PKMT</th>
            <th class="tengah center">PO OUTS</th>
            <th class="tengah center">PB OUTS</th>
            <th class="tengah center">JADWAL PB</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i=1;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="center">{{ $i }}</td>
                <td class="center">{{ $d->prdcd }}</td>
                <td class="center">{{ $d->prd_deskripsipendek }}</td>
                <td class="center">{{ $d->kemasan }}</td>
                <td class="center">{{ $d->avgsales }}</td>
                <td class="center">{{ $d->avgqty }}</td>
                <td class="center">{{ $d->sales_ }}</td>
                <td class="center">{{ $d->margin }}</td>
                <td class="center">{{ $d->margin2 }}</td>
                <td class="center">{{ $d->saldo }}</td>
                <td class="center">{{ $d->ftpkmt }}</td>
                <td class="center">{{ $d->po }}</td>
                <td class="center">{{ $d->pb }}</td>
                <td class="center">{{ $d->cp_tglPB }}</td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="center">TOTAL SELURUH</td>
            <td class="center">{{$i-1}} item</td>
            <td class="center">{{ $d->prdcd }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
