@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Sales Per Divisi Departement
@endsection

@section('title')
    Laporan Sales Per Divisi Departement
@endsection

@section('subtitle')
    TANGGAL : {{ $tanggal1 }} s/d {{ $tanggal2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right tengah">NO</th>
            <th class="left tengah">DEPARTEMENT</th>
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
            $tempDiv = '';

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
            @if($tempDiv != $data[$i]->kodedivisi )
                <tr>
                    <td colspan="9" class="left"><b>{{ $data[$i]->kodedivisi }}-{{ $data[$i]->namadivisi }}</b></td>
                </tr>
            @endif
            <tr>
                <td class="right padding-right">{{ $i+1 }}</td>
                <td class="left">{{ $data[$i]->kodedepartement }}-{{ $data[$i]->namadepartement }}</td>
                <td class="right">{{ number_format($data[$i]->qty,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->sales,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->margin,0,".",",") }}</td>
                <td class="right">{{ $data[$i]->marginpersen }}</td>
                <td class="right">{{ $data[$i]->constsales }}</td>
                <td class="right">{{ $data[$i]->constmargin }}</td>
                <td class="right">{{ number_format($data[$i]->jumlahmember,0,".",",") }}</td>
            </tr>
            @php
                $tempDiv = $data[$i]->kodedivisi;

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
            @if( !isset($data[$i+1]->kodedivisi)  || (isset($data[$i+1]->kodedivisi) && $tempDiv != $data[$i+1]->kodedivisi) )
                @php
                    $subtotal_marginpersen = $subtotal_margin/$subtotal_sales*100;
                @endphp
                <tr>
                    <th colspan="2" class="right"><b>Subtotal</b></th>
                    <th class="right">{{ number_format($subtotal_qty,0,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_sales,0,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_margin,0,".",",") }}</th>
                    <th class="right">{{ $subtotal_marginpersen }}</th>
                    <th class="right">{{ $subtotal_constsales }}</th>
                    <th class="right">{{ $subtotal_constmargin }}</th>
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
            $total_marginpersen = $total_margin/$total_sales*100;
        @endphp
        <tfoot>
            <tr>
                <th colspan="2" class="right"><b>Total</b></th>
                <th class="right">{{ number_format($total_qty,0,".",",") }}</th>
                <th class="right">{{ number_format($total_sales,0,".",",") }}</th>
                <th class="right">{{ number_format($total_margin,0,".",",") }}</th>
                <th class="right">{{ number_format($total_marginpersen,2,".",",") }}</th>
                <th class="right">{{ $total_constsales }}</th>
                <th class="right">{{ $total_constmargin }}</th>
                <th class="right">{{ number_format($total_jumlahmember,0,".",",") }}</th>
            </tr>
        </tfoot>
    </table>
@endsection
