@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    MONITORING SALES & STOK SUPER FAST MOVING PRODUCT
@endsection

@section('title')
    MONITORING SALES & STOK SUPER FAST MOVING PRODUCT<br>
    AVG SALES 3 BULAN : {{$namabulan}}
@endsection

@section('subtitle')
    <br>Margin : {{ $periode }}<br>
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
            $total_avgsales=0;
            $total_avgqty=0;
            $total_sales_=0;
            $total_saldo=0;
            $total_ftpkmt=0;
            $total_po=0;
            $total_pb=0;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="center">{{ $i }}</td>
                <td class="center">{{ $d->prdcd }}</td>
                <td class="center">{{ $d->prd_deskripsipendek }}</td>
                <td class="center">{{ $d->kemasan }}</td>
                <td class="center">{{ number_format($d->avgsales,0,'.',',') }}</td>
                <td class="center">{{ number_format($d->avgqty,0,'.',',') }}</td>
                <td class="center">{{ number_format($d->sales_,0,'.',',') }}</td>
                <td class="center">{{ number_format($d->saldo,0,'.',',') }}</td>
                <td class="center">{{ number_format($d->ftpkmt,0,'.',',') }}</td>
                <td class="center">{{ number_format($d->po,0,'.',',') }}</td>
                <td class="center">{{ number_format($d->pb,0,'.',',') }}</td>
                <td class="center">{{ $d->cp_tglpb }}</td>
            </tr>
            @php
                $total_avgsales += $d->avgsales;
                $total_avgqty += $d->avgqty;
                $total_sales_ += $d->sales_;
                $total_saldo += $d->saldo;
                $total_ftpkmt += $d->ftpkmt;
                $total_po += $d->po;
                $total_pb += $d->pb;
                $i++;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th class="center" colspan="3"><b>TOTAL SELURUH</b></th>
            <th class="center">{{$i-1}} item</th>
            <th class="center">{{ number_format($total_avgsales,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_avgqty,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_sales_,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_saldo,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_ftpkmt,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_po,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_pb,0,'.',',') }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
