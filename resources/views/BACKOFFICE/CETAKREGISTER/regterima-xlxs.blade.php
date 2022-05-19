
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right" rowspan="2">NO</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="center" colspan="2">BPB</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right" rowspan="2">TOP</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left" rowspan="2">J. TEMPO</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left" rowspan="2">SUPPLIER</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right" rowspan="2">GROSS</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right" rowspan="2">POTONGAN</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right" rowspan="2">PPN</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right" rowspan="2">PPN-BM</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right" rowspan="2">BOTOL</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right" rowspan="2">TOTAL</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left" rowspan="2">STATUS</th>
        </tr>
        <tr>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">NOMOR</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">TANGGAL</th>
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
                        <td style="font-weight: bold;border-top: 1px solid black;" align="left" colspan="6">SUBTOTAL TANGGAL</td>
                        <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format(round($subgross), 0, '.', ',') }}</td>
                        <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format(round($subdiscount), 0, '.', ',') }}</td>
                        <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format(round($submstd_ppnrph), 0, '.', ',') }}</td>
                        <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format(round($submstd_ppnbmrph), 0, '.', ',') }}</td>
                        <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format(round($submstd_ppnbtlrph), 0, '.', ',') }}</td>
                        <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format(round($subtotal), 0, '.', ',') }}</td>
                        <td style="font-weight: bold;border-top: 1px solid black;" align=""></td>
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
                    <td align="left" colspan="13">TANGGAL {{ $d->msth_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc}}</td>
                <td>{{ $d->msth_cterm }}</td>
                <td>{{ $d->msth_top }}</td>
                <td align="left">{{ $d->supplier }}</td>
                <td align="right">{{ number_format(round($d->gross), 0, '.', ',') }}</td>
                <td align="right">{{ number_format(round($d->discount), 0, '.', ',') }}</td>
                <td align="right">{{ number_format(round($d->mstd_ppnrph), 0, '.', ',') }}</td>
                <td align="right">{{ number_format(round($d->mstd_ppnbmrph), 0, '.', ',') }}</td>
                <td align="right">{{ number_format(round($d->mstd_ppnbtlrph), 0, '.', ',') }}</td>
                <td align="right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
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
        </tbody>
        <tfoot>
        <tr>
            <td style="font-weight: bold;" align="left" colspan="6">SUBTOTAL TANGGAL</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($subgross), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($subdiscount), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($submstd_ppnrph), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($submstd_ppnbmrph), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($submstd_ppnbtlrph), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($subtotal), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align=""></td>
        </tr>
        <tr>
            <td style="font-weight: bold;" align="left" colspan="6">TOTAL SUPPLIER PKP</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pkp->gross), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pkp->potongan), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pkp->ppn), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pkp->ppnbm), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pkp->botol), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pkp->total), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align=""></td>
        </tr>
        <tr>
            <td style="font-weight: bold;" align="left" colspan="6">TOTAL SUPPLIER NON PKP</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($npkp->gross), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($npkp->potongan), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($npkp->ppn), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($npkp->ppnbm), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($npkp->botol), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($npkp->total), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align=""></td>
        </tr>
        <tr>
            <td style="font-weight: bold;" align="left" colspan="6">TOTAL PENERIMAAN PEMBELIAN</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pembelian->gross), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pembelian->potongan), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pembelian->ppn), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pembelian->ppnbm), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pembelian->botol), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($pembelian->total), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align=""></td>
        </tr>
        <tr>
            <td style="font-weight: bold;" align="left" colspan="6">TOTAL PENERIMAAN LAIN-LAIN</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($lain->gross), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($lain->potongan), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($lain->ppn), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($lain->ppnbm), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($lain->botol), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($lain->total), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align=""></td>
        </tr>
        <tr>
            <td style="font-weight: bold;" align="left" colspan="6">TOTAL SELURUHNYA</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($total->gross), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($total->potongan), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($total->ppn), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($total->ppnbm), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($total->botol), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align="right">{{ number_format(round($total->total), 0, '.', ',') }}</td>
            <td style="font-weight: bold;" align=""></td>
        </tr>
        </tfoot>
    </table>
