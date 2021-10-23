@extends('pdf-template')

@section('paper_size',$ukuran == 'besar' ? '595pt 842pt': '595pt 442pt')

@section('table_font_size','7 px')

@section('page_title')
    Register Nota Pengeluaran Barang
@endsection

@section('title')
    ** REGISTER NOTA PENGELUARAN BARANG **
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
            <th class="tengah" rowspan="2">PPN-BM</th>
            <th class="tengah" rowspan="2">BOTOL</th>
            <th class="tengah" rowspan="2">TOTAL</th>
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
                        <td class="border-top left" colspan="6">SUBTOTAL TANGGAL {{ $d->msth_tgldoc }}</td>
                        <td class="border-top right">{{ number_format(round($subgross), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($subdiscount), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($submstd_ppnrph), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($submstd_ppnbmrph), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($submstd_ppnbtlrph), 0, '.', ',') }}</td>
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
                <td>{{ $d->msth_nofaktur }}</td>
                <td>{{ $d->msth_tglfaktur }}</td>
                <td class="left">{{ $d->supplier }}</td>
                <td class="right">{{ number_format(round($d->gross), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->discount), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->mstd_ppnrph), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->mstd_ppnbmrph), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->mstd_ppnbtlrph), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
                <td>{{ $d->status }}</td>
            </tr>
            @php
                $i++;
                $subgross += $d->gross;
                $subdiscount += $d->discount;
                $submstd_ppnrph += $d->mstd_ppnrph;
                $submstd_ppnbmrph += $d->mstd_ppnbmrph;
                $submstd_ppnbtlrph += $d->mstd_ppnbtlrph;
                $subtotal += $d->total;
            @endphp
        @endforeach
            <tr>
                <td class="border-top left" colspan="6">SUBTOTAL TANGGAL {{ $temp }}</td>
                <td class="border-top right">{{ number_format(round($subgross), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($subdiscount), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($submstd_ppnrph), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($submstd_ppnbmrph), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($submstd_ppnbtlrph), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($subtotal), 0, '.', ',') }}</td>
                <td class="border-top"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="border-top left" colspan="6">TOTAL SUPPLIER PKP</td>
                <td class="border-top right">{{ number_format(round($pkp->gross), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($pkp->potongan), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($pkp->ppn), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($pkp->ppnbm), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($pkp->botol), 0, '.', ',') }}</td>
                <td class="border-top right">{{ number_format(round($pkp->total), 0, '.', ',') }}</td>
                <td class="border-top"></td>
            </tr>
            <tr>
                <td class="left" colspan="6">TOTAL SUPPLIER NON PKP</td>
                <td class="right">{{ number_format(round($npkp->gross), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($npkp->potongan), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($npkp->ppn), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($npkp->ppnbm), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($npkp->botol), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($npkp->total), 0, '.', ',') }}</td>
                <td class=""></td>
            </tr>
            <tr>
                <td class="left" colspan="6">TOTAL PENERIMAAN PEMBELIAN</td>
                <td class="right">{{ number_format(round($pembelian->gross), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($pembelian->potongan), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($pembelian->ppn), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($pembelian->ppnbm), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($pembelian->botol), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($pembelian->total), 0, '.', ',') }}</td>
                <td class=""></td>
            </tr>
            <tr>
                <td class="left" colspan="6">TOTAL PENERIMAAN LAIN-LAIN</td>
                <td class="right">{{ number_format(round($lain->gross), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($lain->potongan), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($lain->ppn), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($lain->ppnbm), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($lain->botol), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($lain->total), 0, '.', ',') }}</td>
                <td class=""></td>
            </tr>
            <tr>
                <td class="left" colspan="6">TOTAL SELURUHNYA</td>
                <td class="right">{{ number_format(round($total->gross), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($total->potongan), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($total->ppn), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($total->ppnbm), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($total->botol), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($total->total), 0, '.', ',') }}</td>
                <td class=""></td>
            </tr>
        </tfoot>
    </table>
@endsection
