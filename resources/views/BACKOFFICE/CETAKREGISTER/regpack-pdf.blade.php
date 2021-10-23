@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Register Repacking
@endsection

@section('title')
    ** REGISTER REPACKING **
@endsection

@section('subtitle')
    {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">NO</th>
            <th colspan="2">---- REPACKING ----</th>
            <th colspan="2">---- ITEM ----</th>
            <th class="tengah right" rowspan="2">GROSS</th>
            <th class="tengah right" rowspan="2">PPN</th>
            <th class="tengah right" rowspan="2">PPN-BM</th>
            <th class="tengah right" rowspan="2">BOTOL</th>
            <th class="tengah right" rowspan="2">TOTAL NILAI</th>
            <th class="tengah" rowspan="2">STATUS</th>
        </tr>
        <tr>
            <th>NOMOR</th>
            <th>TANGGAL</th>
            <th>PREPACK</th>
            <th>REPACK</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 1;
            $temp = '';
            $gross = 0;
            $ppn = 0;
            $ppnbm = 0;
            $botol = 0;
            $total = 0;
        @endphp
        @foreach($data as $d)
            @if($temp != $d->msth_tgldoc)
                @if($temp != '')
                    <tr>
                        <td class="border-top left" colspan="5">SUBTOTAL TANGGAL {{ $d->msth_tgldoc }}</td>
                        <td class="border-top right">{{ number_format($subgross, 2, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format($subppn, 2, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format($subppnbm, 2, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format($subbotol, 2, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format($subtotal, 2, '.', ',') }}</td>
                        <td class="border-top" colspan="2"></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->msth_tgldoc;
                    $subgross = 0;
                    $subppn = 0;
                    $subppnbm = 0;
                    $subbotol = 0;
                    $subtotal = 0;
                @endphp
                <tr>
                    <td class="left" colspan="11">TANGGAL {{ $d->msth_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc}}</td>
                <td class="tengah">{{ $d->prepack }}</td>
                <td class="tengah">{{ $d->repack }}</td>
                <td class="right">{{ number_format($d->gross, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($d->ppn, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($d->ppnbm, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($d->botol, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($d->total, 2, '.', ',') }}</td>
                <td class="tengahtengah ">{{ $d->status }}</td>
            </tr>
            @php
                $i++;
                $subgross += $d->gross;
                $subppn += $d->ppn;
                $subppnbm += $d->ppnbm;
                $subbotol += $d->botol;
                $subtotal += $d->total;

                $gross += $d->gross;
                $ppn += $d->ppn;
                $ppnbm += $d->ppnbm;
                $botol += $d->botol;
                $total += $d->total;
            @endphp
        @endforeach
        <tr>
            <td class="border-top left" colspan="5">SUBTOTAL TANGGAL {{ $temp }}</td>
            <td class="border-top right">{{ number_format($subgross, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($subppn, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($subppnbm, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($subbotol, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($subtotal, 2, '.', ',') }}</td>
            <td class="border-top"></td>
        </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="border-top left" colspan="5">TOTAL SELURUHNYA</td>
                <td class="border-top right">{{ number_format($gross, 2, '.', ',') }}</td>
                <td class="border-top right">{{ number_format($ppn, 2, '.', ',') }}</td>
                <td class="border-top right">{{ number_format($ppnbm, 2, '.', ',') }}</td>
                <td class="border-top right">{{ number_format($botol, 2, '.', ',') }}</td>
                <td class="border-top right">{{ number_format($total, 2, '.', ',') }}</td>
                <td class="border-top"></td>
            </tr>
        </tfoot>
    </table>
@endsection
