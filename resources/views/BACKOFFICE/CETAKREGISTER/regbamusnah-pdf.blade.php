@extends('pdf-template')

@section('paper_size','595pt 442pt')

@section('table_font_size','7 px')

@section('page_title')
    Register Berita Acara Pemusnahan Barang
@endsection

@section('title')
    ** Register Berita Acara Pemusnahan Barang **
@endsection

@section('subtitle')
    {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">NO</th>
            <th colspan="2">---- BAPB ----</th>
            <th colspan="2">---- REF ----</th>
            <th class="tengah right" rowspan="2">TOTAL</th>
            <th class="tengah" rowspan="2">STATUS</th>
        </tr>
        <tr>
            <th>NOMOR</th>
            <th>TANGGAL</th>
            <th>NOMOR</th>
            <th>TANGGAL</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 1;
            $temp = '';
            $total = 0;
            $subtotal = 0;
        @endphp
        @foreach($data as $d)
            @if($temp != $d->msth_tgldoc)
                @if($temp != '')
                    <tr class="border-top">
                        <td class="left" colspan="5">** SUBTOTAL TANGGAL {{ $temp }}</td>
                        <td class="right">{{ number_format($subtotal, 2, '.', ',') }}</td>
                        <td class="" colspan="2"></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->msth_tgldoc;
                    $subtotal = 0;
                @endphp
                <tr>
                    <td class="left" colspan="11">** TANGGAL : {{ $d->msth_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc}}</td>
                <td class="tengah">{{ $d->msth_nopo }}</td>
                <td class="tengah">{{ $d->msth_tglpo }}</td>
                <td class="right">{{ number_format($d->total, 2, '.', ',') }}</td>
                <td class="tengah">{{ $d->status }}</td>
            </tr>
            @php
                $i++;
                $subtotal += $d->total;
                $total += $d->total;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="5">** SUBTOTAL TANGGAL {{ $temp }}</td>
            <td class="right">{{ number_format($subtotal, 2, '.', ',') }}</td>
            <td class="" colspan="2"></td>
        </tr>
        <tr>
            <td class="border-top left" colspan="5">** TOTAL SELURUHNYA</td>
            <td class="border-top right">{{ number_format($total, 2, '.', ',') }}</td>
            <td class="border-top" colspan="2"></td>
        </tr>
        </tfoot>
    </table>
@endsection
