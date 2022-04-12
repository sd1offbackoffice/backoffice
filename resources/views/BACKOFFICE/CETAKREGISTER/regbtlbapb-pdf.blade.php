@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Register Pembatalan BAPB
@endsection

@section('title')
    ** REGISTER PEMBATALAN BAPB **
@endsection

@section('subtitle')
    {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah right" rowspan="2">NO</th>
            <th colspan="2">---- NBH ----</th>
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
            @if($temp != $d->mstd_tgldoc)
                @if($temp != '')
                    <tr>
                        <td class="left" colspan="5">** SUBTOTAL TANGGAL : {{ $temp }}</td>
                        <td class="right">{{ number_format($subtotal, 2, '.', ',') }}</td>
                        <td class="" colspan="2"></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->mstd_tgldoc;
                    $subtotal = 0;
                @endphp
                <tr>
                    <td class="left border-top" colspan="11">** TANGGAL : {{ $d->mstd_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td class="right">{{ $i }}</td>
                <td>{{ $d->mstd_nodoc }}</td>
                <td>{{ $d->mstd_tgldoc}}</td>
                <td class="tengah">{{ $d->msth_noref3 }}</td>
                <td class="tengah">{{ $d->msth_tgref3 }}</td>
                <td class="right">{{ number_format($d->mstd_gross, 2, '.', ',') }}</td>
                <td class="tengah">{{ $d->status }}</td>
            </tr>
            @php
                $i++;
                $subtotal += $d->mstd_gross;
                $total += $d->mstd_gross;
            @endphp
        @endforeach
        <tr>
            <td class="left" colspan="5">** SUBTOTAL TANGGAL : {{ $temp }}</td>
            <td class="right">{{ number_format($subtotal, 2, '.', ',') }}</td>
            <td class="" colspan="2"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td class="border-top left" colspan="5">** TOTAL SELURUHNYA</td>
            <td class="border-top right">{{ number_format($total, 2, '.', ',') }}</td>
            <td class="border-top" colspan="2"></td>
        </tr>
        </tfoot>
    </table>
@endsection
