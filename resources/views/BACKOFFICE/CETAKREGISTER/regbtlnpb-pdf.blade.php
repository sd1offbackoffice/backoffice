@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Register Pembatalan Pengeluaran Barang
@endsection

@section('title')
    ** REGISTER PEMBATALAN PENGELUARAN BARANG **
@endsection

@section('subtitle')
    {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">NO</th>
            <th colspan="2">---- BPB ----</th>
            <th colspan="2">---- NOTA RETUR ----</th>
            <th class="tengah" rowspan="2">------- SUPPLIER -------</th>
            <th class="tengah" rowspan="2">GROSS</th>
            <th class="tengah" rowspan="2">POTONGAN</th>
            <th class="tengah" rowspan="2">PPN</th>
            <th class="tengah" rowspan="2">TOTAL NILAI</th>
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
            $subgross = 0;
            $subdiscount = 0;
            $submstd_ppnrph = 0;
            $submstd_ppnbmrph = 0;
            $submstd_ppnbtlrph = 0;
            $subtotal = 0;
        @endphp
        @foreach($data as $d)
            @if($temp != $d->msth_tgldoc)
                @if($temp != '')
                    <tr>
                        <td class="border-top left" colspan="6">SUBTOTAL TANGGAL {{ $temp }}</td>
                        <td class="border-top right">{{ number_format(round($subgross), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($subdiscount), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($submstd_ppnrph), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($subtotal), 0, '.', ',') }}</td>
                        <td class="border-top"></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->msth_tgldoc;
                    $subgross = 0;
                    $subdiscount = 0;
                    $submstd_ppnrph = 0;
                    $submstd_ppnbmrph = 0;
                    $submstd_ppnbtlrph = 0;
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
                <td>{{ $d->mstd_docno2 }}</td>
                <td>{{ $d->mstd_date2 }}</td>
                <td class="left">{{ $d->supplier }}</td>
                <td class="right">{{ number_format(round($d->mstd_gross), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->mstd_discrph), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->mstd_ppnrph), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->mstd_gross + $d->mstd_ppnrph - $d->mstd_discrph), 0, '.', ',') }}</td>
                <td>{{ $d->status }}</td>
            </tr>
            @php
                $i++;
                $subgross += $d->mstd_gross;
                $subdiscount += $d->mstd_discrph;
                $submstd_ppnrph += $d->mstd_ppnrph;
                $subtotal += $d->mstd_gross + $d->mstd_ppnrph - $d->mstd_discrph;
            @endphp
        @endforeach
        <tr>
            <td class="border-top left" colspan="6">SUBTOTAL TANGGAL {{ $temp }}</td>
            <td class="border-top right">{{ number_format(round($subgross), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($subdiscount), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($submstd_ppnrph), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($subtotal), 0, '.', ',') }}</td>
            <td class="border-top"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="6">TOTAL SUPPLIER PKP</td>
            <td class="right">{{ number_format(round($pkp->gross), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pkp->potongan), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pkp->ppn), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pkp->total), 0, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="6">TOTAL SUPPLIER NON PKP</td>
            <td class="right">{{ number_format(round($npkp->gross), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($npkp->potongan), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($npkp->ppn), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($npkp->total), 0, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="6">TOTAL PENERIMAAN PEMBELIAN</td>
            <td class="right">{{ number_format(round($pembelian->gross), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pembelian->potongan), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pembelian->ppn), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pembelian->total), 0, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="6">TOTAL PENERIMAAN LAIN-LAIN</td>
            <td class="right">{{ number_format(round($lain->gross), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($lain->potongan), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($lain->ppn), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($lain->total), 0, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="6">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format(round($total->gross), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($total->potongan), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($total->ppn), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($total->total), 0, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        </tfoot>
    </table>
@endsection
