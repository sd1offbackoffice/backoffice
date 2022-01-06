@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Sales Per Kategori Produk
@endsection

@section('title')
    Laporan Sales Per Kategori Produk
@endsection

@section('subtitle')
    TANGGAL : {{ $tanggal1 }} s/d {{ $tanggal2 }}
@endsection

@section('header_left')
    <table class="table-lg">
        <tr>
            <td class="left">Member</td>
            <td class="left">: {{$member}}</td>
            <td class="left"></td>
            <td class="left">Outlet</td>
            <td class="left">: {{$outlet}}</td>
        </tr>
        <tr>
            <td class="left">Jenis Member</td>
            <td class="left">: {{$group}}</td>
            <td class="left"></td>
            <td class="left">Suboutlet</td>
            <td class="left">: {{$suboutlet}}</td>
        </tr>
        <tr>
            <td class="left">Divisi</td>
            <td class="left">: {{$divisi}}</td>
            <td class="left"></td>
            <td class="left">Departement</td>
            <td class="left">: {{$departemen}}</td>
        </tr>
        <tr>
            <td class="left">Segmentasi</td>
            <td class="left">: {{$segmentasi}}</td>
            <td class="left"></td>
            <td class="left">Kategori</td>
            <td class="left">: {{$kategori}}</td>
        </tr>
    </table>
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left tengah">PLU</th>
            <th class="right tengah">QTY</th>
            <th class="right tengah">SALES</th>
            <th class="right tengah">MARGIN</th>
            <th class="right tengah">MARGIN %</th>
            <th class="right tengah">CONST. SLS</th>
            <th class="right tengah">CONST. MRG</th>
            <th class="right tengah">JUMLAH MEMBER</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $tempKat = '';

            $subtotal_qty = 0;
            $subtotal_sales = 0;
            $subtotal_margin = 0;
            $subtotal_marginpersen = 0;
            $subtotal_constsales  = 0;
            $subtotal_constmargin = 0;
            $subtotal_jumlahmember = 0;

            $total_qty = 0;
            $total_sales = 0;
            $total_margin = 0;
            $total_marginpersen = 0;
            $total_constsales  = 0;
            $total_constmargin = 0;
            $total_jumlahmember = 0;

        @endphp

        @for($i=0; $i<sizeof($data) ;$i++)
            @if($tempKat != $data[$i]->kodekategori )
                <tr>
                    <td colspan="8" class="left"><b>{{ $data[$i]->kodekategori }}-{{ $data[$i]->namakategori }}</b></td>
                </tr>
            @endif
            <tr>
                <td class="left">{{ $data[$i]->plu }}</td>
                <td class="right">{{ number_format($data[$i]->qty,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->sales,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->margin,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->marginpersen,2) }}</td>
                <td class="right">{{ number_format($data[$i]->constsales,2) }}</td>
                <td class="right">{{ number_format($data[$i]->constmargin,2) }}</td>
                <td class="right">{{ number_format($data[$i]->jumlahmember,0,".",",") }}</td>
            </tr>
            @php
                $tempKat = $data[$i]->kodekategori;

                $subtotal_qty += $data[$i]->qty;
                $subtotal_sales += $data[$i]->sales;
                $subtotal_margin += $data[$i]->margin;
                $subtotal_marginpersen += $data[$i]->marginpersen;
                $subtotal_constsales += $data[$i]->constsales;
                $subtotal_constmargin += $data[$i]->constmargin;
                $subtotal_jumlahmember += $data[$i]->jumlahmember;

                $total_qty += $data[$i]->qty;
                $total_sales += $data[$i]->sales;
                $total_margin += $data[$i]->margin;
                $total_marginpersen += $data[$i]->marginpersen;
                $total_constsales += $data[$i]->constsales;
                $total_constmargin += $data[$i]->constmargin;
                $total_jumlahmember += $data[$i]->jumlahmember;
            @endphp
            @if( !isset($data[$i+1]->kodekategori)  || (isset($data[$i+1]->kodekategori) && $tempKat != $data[$i+1]->kodekategori) )
                @php
                    $subtotal_marginpersen = $subtotal_margin/$subtotal_sales*100;
                @endphp
                <tr>
                    <th class="right"><b>Subtotal</b></th>
                    <th class="right">{{ number_format($subtotal_qty,0,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_sales,0,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_margin,0,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_marginpersen,2) }}</th>
                    <th class="right">{{ number_format($subtotal_constsales,2) }}</th>
                    <th class="right">{{ number_format($subtotal_constmargin,2) }}</th>
                    <th class="right">{{ number_format($subtotal_jumlahmember,0,".",",") }}</th>
                </tr>
                @php
                    $subtotal_qty = 0;
                    $subtotal_sales = 0;
                    $subtotal_margin = 0;
                    $subtotal_marginpersen = 0;
                    $subtotal_constsales = 0;
                    $subtotal_constmargin = 0;
                    $subtotal_jumlahmember = 0;
                @endphp
            @endif
        @endfor

        </tbody>
        @php
            //$total_marginpersen = 0;
            $total_marginpersen = $total_margin/$total_sales*100;

        @endphp
        <tfoot>
            <tr>
                <th class="right"><b>Total</b></th>
                <th class="right">{{ number_format($total_qty,0,".",",") }}</th>
                <th class="right">{{ number_format($total_sales,0,".",",") }}</th>
                <th class="right">{{ number_format($total_margin,0,".",",") }}</th>
                <th class="right">{{ number_format($total_marginpersen,2) }}</th>
                <th class="right">{{ number_format($total_constsales,2) }}</th>
                <th class="right">{{ number_format($total_constmargin,2) }}</th>
                <th class="right">{{ number_format($total_jumlahmember,0,".",",") }}</th>
            </tr>
        </tfoot>
    </table>
@endsection
