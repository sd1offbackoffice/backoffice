@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Discount 4
@endsection

@section('title')
    Laporan Discount 4
@endsection

@section('subtitle')
    TANGGAL : {{ $tgl1 }} s/d {{ $tgl2 }}
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
            <th class="left tengah">TANGGAL</th>
            <th class="right tengah padding-right">PLU</th>
            <th class="left tengah">DESKRIPSI</th>
            <th class="left tengah">SATUAN</th>
            <th class="right tengah">QTY</th>
            <th class="right tengah">HARGA</th>
            <th class="right tengah">NILAI</th>
            <th class="right tengah">DISCOUNT</th>
            <th class="right tengah">DISCOUNT 4</th>
            <th class="right tengah">DIS4CR</th>
            <th class="right tengah">DIS4RR</th>
            <th class="right tengah">DIS4JR</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempSupplier='';

        @endphp

        @for($i=0; $i<sizeof($data) ;$i++)
            @if($tempSupplier != $data[$i]->sup_namasupplier )
                <tr>
                    <td colspan="9" class="left"><b>SUPPLIER : {{ $data[$i]->sup_namasupplier }}</b></td>
                </tr>
            @endif
            <tr>
                <td class="left">{{ $data[$i]->mstd_tgldoc }}</td>
                <td class="right tengah padding-right">{{ $data[$i]->mstd_prdcd }}</td>
                <td class="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td class="left">{{ $data[$i]->satuan }}</td>
                <td class="right">{{ number_format($data[$i]->qty,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->mstd_hrgsatuan,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->mstd_gross,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->mstd_discrph,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->mstd_rphdisc4,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->mstd_dis4cr,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->mstd_dis4rr,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->mstd_dis4jr,2,".",",") }}</td>
            </tr>
            @php
                $tempSupplier = $data[$i]->sup_namasupplier;
            @endphp

        @endfor
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
