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

@section('paper_height')
    595pt
@endsection

@section('paper_width')
    842pt
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right tengah">NO</th>
            <th class="left tengah">Member</th>
            <th class="left tengah">Khusus</th>
            <th class="left tengah">Group</th>
            <th class="left tengah">Outlet</th>
            <th class="left tengah">SubOutlet</th>
            <th class="right tengah">QTY</th>
            <th class="right tengah">SALES</th>
            <th class="right tengah">MARGIN</th>
            <th class="right tengah">MARGIN %</th>
            <th class="right tengah">CONST. SLS</th>
            <th class="right tengah">CONST. MRG</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $tempPlu = '';

            $subtotal_qty = 0;
            $subtotal_sales = 0;
            $subtotal_margin = 0;
            $subtotal_marginpersen = 0;
            $subtotal_constsales  = 0;
            $subtotal_constmargin = 0;

            $total_qty = 0;
            $total_sales = 0;
            $total_margin = 0;
            $total_marginpersen = 0;
            $total_constsales  = 0;
            $total_constmargin = 0;

        @endphp

        @for($i=0; $i<sizeof($data) ;$i++)
            @if($tempPlu != $data[$i]->prd_prdcd )
                <tr>
                    <td colspan="9" class="left"><b>{{ $data[$i]->plu }}</b></td>
                </tr>
            @endif
            <tr>
                <td class="right padding-right">{{ $i+1 }}</td>
                <td class="left">{{ $data[$i]->nama }}</td>
                <td class="left">{{ $data[$i]->memberkhusus }}</td>
                <td class="left">{{ $data[$i]->membergroup }}</td>
                <td class="left">{{ $data[$i]->outlet }}</td>
                <td class="left">{{ $data[$i]->suboutlet }}</td>
                <td class="right">{{ number_format($data[$i]->qty,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->sales,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->margin,0,".",",") }}</td>
                <td class="right">{{ $data[$i]->marginpersen }}</td>
                <td class="right">{{ $data[$i]->constsales }}</td>
                <td class="right">{{ $data[$i]->constmargin }}</td>
            </tr>
            @php
                $tempPlu = $data[$i]->prd_prdcd;

                $subtotal_qty += $data[$i]->qty;
                $subtotal_sales += $data[$i]->sales;
                $subtotal_margin += $data[$i]->margin;
                $subtotal_marginpersen += $data[$i]->marginpersen;
                $subtotal_constsales += $data[$i]->constsales;
                $subtotal_constmargin += $data[$i]->constmargin;

                $total_qty += $data[$i]->qty;
                $total_sales += $data[$i]->sales;
                $total_margin += $data[$i]->margin;
                $total_marginpersen += $data[$i]->marginpersen;
                $total_constsales += $data[$i]->constsales;
                $total_constmargin += $data[$i]->constmargin;
            @endphp
            @if( !isset($data[$i+1]->prd_prdcd)  || (isset($data[$i+1]->prd_prdcd) && $tempPlu != $data[$i+1]->prd_prdcd) )
                @php
                    $subtotal_marginpersen = $subtotal_margin/$subtotal_sales*100;
                @endphp
                <tr>
                    <th colspan="6" class="right"><b>Subtotal</b></th>
                    <th class="right">{{ number_format($subtotal_qty,0,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_sales,0,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_margin,0,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_marginpersen,2,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_constsales,2,".",",") }}</th>
                    <th class="right">{{ number_format($subtotal_constmargin,2,".",",") }}</th>
                </tr>
                @php
                    $subtotal_qty = 0;
                    $subtotal_sales = 0;
                    $subtotal_margin = 0;
                    $subtotal_marginpersen = 0;
                    $subtotal_constsales = 0;
                    $subtotal_constmargin = 0;
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
                <th colspan="6" class="right"><b>Total</b></th>
                <th class="right">{{ number_format($total_qty,0,".",",") }}</th>
                <th class="right">{{ number_format($total_sales,0,".",",") }}</th>
                <th class="right">{{ number_format($total_margin,0,".",",") }}</th>
                <th class="right">{{ number_format($total_marginpersen,2,".",",") }}</th>
                <th class="right">{{ number_format($total_constsales,2,".",",") }}</th>
                <th class="right">{{ number_format($total_constmargin,2,".",",") }}</th>
            </tr>
        </tfoot>
    </table>
@endsection
