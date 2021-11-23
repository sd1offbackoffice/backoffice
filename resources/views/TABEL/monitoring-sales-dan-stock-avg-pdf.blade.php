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
            <th class="tengah left">NO.</th>
            <th class="tengah right padding-right">PLU</th>
            <th class="tengah left">DESKRIPSI</th>
            <th class="tengah left">KEMASAN</th>
            <th class="tengah right">AVG SALES</th>
            <th class="tengah right">AVG SALES QTY</th>
            <th class="tengah right">SALES QTY</th>
            <th class="tengah right">SALDO AKHIR</th>
            <th class="tengah right">PKMT</th>
            <th class="tengah right">PO OUTS</th>
            <th class="tengah right padding-right">PB OUTS</th>
            <th class="tengah left">JADWAL PB</th>
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
                <td class="left">{{ $i }}</td>
                <td class="right padding-right">{{ $d->prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipendek }}</td>
                <td class="left">{{ $d->kemasan }}</td>
                <td class="right">{{ number_format($d->avgsales,0,'.',',') }}</td>
                <td class="right">{{ number_format($d->avgqty,0,'.',',') }}</td>
                <td class="right">{{ number_format($d->sales_,0,'.',',') }}</td>
                <td class="right">{{ number_format($d->saldo,0,'.',',') }}</td>
                <td class="right">{{ number_format($d->ftpkmt,0,'.',',') }}</td>
                <td class="right">{{ number_format($d->po,0,'.',',') }}</td>
                <td class="right padding-right">{{ number_format($d->pb,0,'.',',') }}</td>
                <td class="left">{{ $d->cp_tglpb }}</td>
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
        <tfoot style="border-bottom: none">
        <tr>
            <th class="center" colspan="3"><b>TOTAL SELURUH</b></th>
            <th class="left">{{$i-1}} item</th>
            <th class="right">{{ number_format($total_avgsales,0,'.',',') }}</th>
            <th class="right">{{ number_format($total_avgqty,0,'.',',') }}</th>
            <th class="right">{{ number_format($total_sales_,0,'.',',') }}</th>
            <th class="right">{{ number_format($total_saldo,0,'.',',') }}</th>
            <th class="right">{{ number_format($total_ftpkmt,0,'.',',') }}</th>
            <th class="right">{{ number_format($total_po,0,'.',',') }}</th>
            <th class="right padding-right">{{ number_format($total_pb,0,'.',',') }}</th>
            <th class="right"></th>
        </tr>
        </tfoot>
    </table>
@endsection
