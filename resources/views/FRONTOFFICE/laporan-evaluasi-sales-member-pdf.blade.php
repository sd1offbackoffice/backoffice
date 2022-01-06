@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN EVALUASI SALES MEMBER
@endsection

@section('title')
    ** LAPORAN EVALUASI SALES MEMBER **
@endsection

@section('subtitle')
    Tanggal {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('header_left')
    <p>ORDER BY : {{ $sort }}</p>
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="8%" class="center">Kode</th>
            <th width="28%" class="left">Member</th>
            <th width="8%" class="left padding-left">Kunj</th>
            <th width="8%" class="tengah center">Struk</th>
            <th width="8%" class="right">Produk</th>
            <th width="8%" class="right">Sales Gross</th>
            <th width="8%" class="right">Sales Net</th>
            <th width="8%" class="right">PPN</th>
            <th width="8%" class="right">Margin</th>
            <th width="8%" class="right">%</th>
        </tr>
        </thead>
        <tbody>
        @php
            $kunj = 0;
            $struk = 0;
            $qty = 0;
            $salesgross = 0;
            $salesnet = 0;
            $ppn = 0;
            $margin = 0;
        @endphp
        @foreach($data as $d)
            <tr>
                <td width="8%" class="center">{{ $d->trjd_cus_kodemember }}</td>
                <td width="28%" class="left">{{ $d->cus_namamember }}</td>
                <td width="8%" class="left padding-left">{{ $d->kunj }}</td>
                <td width="8%" class="tengah center">{{ $d->struk }}</td>
                <td width="8%" class="right">{{ number_format($d->qty, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->salesgross, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->sales, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->sales * 0.1, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->margin, 0, '.', ',') }}</td>
                <td width="8%" class="right">{{ number_format($d->margin / $d->sales * 100, 2, '.', ',') }}%</td>
            </tr>

            @php
                $kunj += $d->kunj;
                $struk += $d->struk;
                $qty += $d->qty;
                $salesgross += $d->salesgross;
                $salesnet += $d->sales;
                $ppn += $d->sales * 0.1;
                $margin += $d->margin;
            @endphp
        @endforeach
        <tr style="border-top: 1px solid black">
            <td width="36%" class="left" colspan="2">TOTAL</td>
            <td width="8%" class="left padding-left">{{ $kunj }}</td>
            <td width="8%" class="tengah center">{{ $struk }}</td>
            <td width="8%" class="right">{{ number_format($qty, 0, '.', ',') }}</td>
            <td width="8%" class="right">{{ number_format($salesgross, 0, '.', ',') }}</td>
            <td width="8%" class="right">{{ number_format($salesnet, 0, '.', ',') }}</td>
            <td width="8%" class="right">{{ number_format($ppn, 0, '.', ',') }}</td>
            <td width="8%" class="right">{{ number_format($margin, 0, '.', ',') }}</td>
            <td width="8%" class="right">{{ number_format($margin / $salesnet * 100, 2, '.', ',') }}%</td>
        </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
