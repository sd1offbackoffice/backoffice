@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height','442pt')


@section('page_title')
    Memo Penyesuaian Persediaan Konversi Perishable
@endsection

@section('title')
    Memo Penyesuaian Persediaan<br>Konversi Perishable
@endsection

@section('content')
    @php $i=0; @endphp
    @foreach($datas as $data)
        @php $i++; @endphp
        <table class="table table-borderless table-header">
            <tr style="text-align: left">
                <td style="float:left">
                    Nomor &nbsp;&nbsp;&nbsp;&nbsp; : {{ $data[0]->msth_nodoc }}<br>
                    Tanggal &nbsp;&nbsp; : {{ $data[0]->msth_tgldoc }}
                </td>
                <td width="60%" style="font-size: 18px;text-align: right !important;float: right;@if($reprint != '1')color:white;@endif">RE-PRINT</td>
            </tr>
        </table>
        <table class="table">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th class="tengah" rowspan="2">NO</th>
                <th class="tengah" rowspan="2">PLU</th>
                <th class="tengah" rowspan="2">NAMA BARANG</th>
                <th class="tengah" rowspan="2">KEMASAN</th>
                <th colspan="2">KWANTUM</th>
                <th class="tengah right" rowspan="2">HARGA IN CTN</th>
                <th class="tengah right" rowspan="2">TOTAL OUT</th>
                <th class="tengah right" rowspan="2">TOTAL IN</th>
                <th class="tengah" rowspan="2">KETERANGAN</th>
            </tr>
            <tr>
                <th>BESAR</th>
                <th>KECIL</th>
            </tr>
            </thead>
            <tbody>
            @php $out=0;$in=0;$qtyout=0;$qtyin=0; @endphp
            @foreach($data as $d)
                @php
                    $out += $d->qty_out;
                    $in += $d->qty_in;
                    $qtyout += $d->gross_out;
                    $qtyin += $d->gross_in;
                @endphp
                <tr>
                    <td>{{ $d->mstd_seqno }}</td>
                    <td>{{ $d->mstd_prdcd }}</td>
                    <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                    <td>{{ $d->kemasan }}</td>
                    <td>{{ intval($d->mstd_qty / $d->mstd_frac) }}</td>
                    <td>{{ $d->mstd_qty % $d->mstd_frac }}</td>
                    <td class="right">{{ $d->mstd_hrgsatuan }}</td>
                    <td class="right">{{ number_format($d->gross_out,2) }}</td>
                    <td class="right">{{ number_format($d->gross_in,2) }}</td>
                    <td>{{ $d->mstd_keterangan }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot style="text-align: center">
            <tr>
                <td colspan="4">QTY SUSUT : {{ $out - $in }} &nbsp;&nbsp;&nbsp;&nbsp; RPH SUSUT : {{ number_format($qtyout - $qtyin, 2) }}</td>
                <td colspan="3">TOTAL SELURUHNYA :</td>
                <td class="right">{{ number_format($qtyout,2) }}</td>
                <td class="right">{{ number_format($qtyin,2) }}</td>
                <td></td>
            </tr>
            </tfoot>
        </table>
        @if($i != count($datas))
            <div class="page-break"></div>
        @endif
    @endforeach
@endsection
