@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Register Pembatalan Memo Penyesuaian Persediaan
@endsection

@section('title')
    ** REGISTER PEMBATALAN MEMO PENYESUAIAN PERSEDIAAN **
@endsection

@section('subtitle')
    {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">NO</th>
            <th colspan="2">---- MPP ----</th>
            <th colspan="2">---- REF ----</th>
            <th class="tengah" rowspan="2">TOTAL</th>
            <th class="tengah" rowspan="2">STATUS</th>
            <th class="tengah" rowspan="2">KETERANGAN</th>
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
            $subtotal = 0;
            $total = 0;
        @endphp
        @foreach($data as $d)
            @if($temp != $d->msth_tgldoc)
                @if($temp != '')
                    <tr>
                        <td class="border-top left" colspan="5">SUBTOTAL TANGGAL {{ $temp }}</td>
                        <td class="border-top right">{{ number_format(round($subtotal), 0, '.', ',') }}</td>
                        <td class="border-top"></td>
                        <td class="border-top"></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->msth_tgldoc;
                    $subtotal = 0;
                @endphp
                <tr>
                    <td class="left" colspan="13">TANGGAL {{ $d->msth_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc}}</td>
                <td>{{ $d->msth_nopo }}</td>
                <td>{{ $d->msth_tglpo }}</td>
                <td class="right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
                <td>{{ $d->status }}</td>
                <td>{{ $d->keterangan }}</td>
            </tr>
            @php
                $i++;
                $subtotal += $d->total;
                $total += $d->total;
            @endphp
        @endforeach
        <tr>
            <td class="border-top left" colspan="5">SUBTOTAL TANGGAL {{ $temp }}</td>
            <td class="border-top right">{{ number_format(round($subtotal), 0, '.', ',') }}</td>
            <td class="border-top"></td>
            <td class="border-top"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="5">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format(round($total), 0, '.', ',') }}</td>
            <td class=""></td>
            <td class=""></td>
        </tr>
        </tfoot>
    </table>
@endsection
