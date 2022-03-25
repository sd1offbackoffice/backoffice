@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    DATA PERHITUNGAN TRANSFER SATUAN PRODUK
@endsection

@section('title')
    ** DATA PERHITUNGAN TRANSFER SATUAN PRODUK **
@endsection

@section('subtitle')
    ( dari produk dasar ke produk hot beverages yang dijual )<br>
    Periode : {{ $tgl1 }} s/d {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah">Departemen</th>
            <th colspan="2">PLU</th>
            <th colspan="2">Nama / Spesifikasi</th>
            <th rowspan="2" class="tengah">Satuan</th>
            <th rowspan="2" class="tengah">Qty</th>
            <th rowspan="2" class="tengah">Harga Sat</th>
            <th colspan="2">Jumlah ( Rp. )</th>
        </tr>
        <tr>
            <th>Items yg dijual</th>
            <th>Items produk dasar</th>
            <th>Items yg dijual</th>
            <th>Items produk dasar</th>
            <th>Items yg dijual</th>
            <th>Items produk dasar</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempDep = null;
            $tempPLU = null;
            $tempQty = null;
            $jmlJual = 0;
            $jmlDasar = 0;
        @endphp
        @foreach($data as $d)
            @if($tempDep != $d->prd_kodedepartement)
                @php $tempDep = $d->prd_kodedepartement; @endphp
                <tr>
                    <td>{{ $d->prd_kodedepartement }} -</td>
                    <td colspan="2">{{ $d->dep_namadepartement }}</td>
                    <td colspan="7"></td>
                </tr>
            @endif
            @if($tempPLU != $d->trjd_prdcd || ($tempPLU == $d->trjd_prdcd && $tempQty != $d->trjd_quantity))
                @php
                    $tempPLU = $d->trjd_prdcd;
                    $tempQty = $d->trjd_quantity;
                    $jmlJual += $d->nilai_jadi;
                @endphp
                <tr>
                    <td></td>
                    <td>{{ $d->trjd_prdcd }}</td>
                    <td></td>
                    <td class="left">{{ strlen($d->desc_jadi) > 20 ? substr($d->desc_jadi, 0, 20).'...' : $d->desc_jadi }}</td>
                    <td></td>
                    <td class="left">{{ $d->unit_jadi }}</td>
                    <td class="right">{{ number_format($d->trjd_quantity) }}</td>
                    <td class="right">{{ number_format($d->trjd_unitprice) }}</td>
                    <td class="right">{{ number_format($d->nilai_jadi) }}</td>
                    <td></td>
                </tr>
            @endif
            <tr>
                <td colspan="2"></td>
                <td>{{ $d->hbv_prdcd_brd }}</td>
                <td></td>
                <td class="left">{{ strlen($d->prd_deskripsipanjang) > 20 ? substr($d->prd_deskripsipanjang, 0, 20).'...' : $d->prd_deskripsipanjang }}</td>
                <td class="left">{{ $d->prd_unit }}</td>
                <td class="right">{{ number_format($d->qty) }}</td>
                <td class="right">{{ number_format($d->hrg_dasar) }}</td>
                <td></td>
                <td class="right">{{ number_format($d->nilai_dasar) }}</td>
            </tr>

            @php
                $jmlDasar += $d->nilai_dasar;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7"></td>
                <td>Jumlah</td>
                <td class="right">{{ number_format($jmlJual) }}</td>
                <td class="right">{{ number_format($jmlDasar) }}</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <td colspan="6" class="left">Rekapitulasi Penggunaan Produk Dasar :</td>
        </tr>
        </thead>
        <tbody>
        @foreach($data2 as $d)
            <tr>
                <td class="left">{{ $d->plu_dsr }}</td>
                <td class="left">{{ $d->desc_dsr }}</td>
                <td class="left">{{ $d->unit_dsr }}</td>
                <td class="right">{{ number_format($d->qty_dsr) }}</td>
                <td class="right">{{ number_format($d->hrg_dsr) }}</td>
                <td class="right">{{ number_format($d->nilai_dsr) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td class="center">Jumlah</td>
                <td class="right">{{ number_format($jmlDasar) }}</td>
            </tr>
        </tfoot>
    </table>
@endsection
