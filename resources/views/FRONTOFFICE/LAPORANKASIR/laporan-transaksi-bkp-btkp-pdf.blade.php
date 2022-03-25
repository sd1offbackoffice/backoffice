@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    Laporan Barang BKP & BTKP
@endsection

@section('title')
    ** LAPORAN BARANG BKP & BTKP **
@endsection

@section('subtitle')
    Tanggal {{ $tgl1 }} s/d {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="2" rowspan="2" class="left">KATEGORI</th>
            <th colspan="4" class="center">----- PENJUALAN -----</th>
            <th rowspan="2" class="right">TOTAL</th>
            <th colspan="4" class="center">----- REFUND -----</th>
            <th rowspan="2" class="right">TOTAL</th>
            <th rowspan="2" class="right">Penjualan Bersih</th>
            <th rowspan="2" class="right">PAJAK</th>
        </tr>
        <tr>
            <th class="right">BKP</th>
            <th class="right">BKP Bebas PPN</th>
            <th class="right">BTKP</th>
            <th class="right">Telah Di Cukai</th>
            <th class="right">BKP</th>
            <th class="right">BKP Bebas PPN</th>
            <th class="right">BTKP</th>
            <th class="right">Telah Di Cukai</th>
        </tr>
        </thead>
        <tbody>
        @php
            $dept = null;
            $totSbkp = 0;
            $totSokp = 0;
            $totStkp = 0;
            $totScki = 0;
            $totPenj = 0;
            $totRbkp = 0;
            $totRokp = 0;
            $totRtkp = 0;
            $totRcki = 0;
            $totRef = 0;

            $totSexp = 0;
            $totRexp = 0;

            $totSbkp43 = 0;
            $totSokp43 = 0;
            $totStkp43 = 0;
            $totScki43 = 0;
            $totPenj43 = 0;
            $totRbkp43 = 0;
            $totRokp43 = 0;
            $totRtkp43 = 0;
            $totRcki43 = 0;
            $totRef43 = 0;

            $totSbkp40 = 0;
            $totSokp40 = 0;
            $totStkp40 = 0;
            $totScki40 = 0;
            $totPenj40 = 0;
            $totRbkp40 = 0;
            $totRokp40 = 0;
            $totRtkp40 = 0;
            $totRcki40 = 0;
            $totRef40 = 0;

            $totSbkpAll = 0;
            $totSokpAll = 0;
            $totStkpAll = 0;
            $totSckiAll = 0;
            $totPenjAll = 0;
            $totRbkpAll = 0;
            $totRokpAll = 0;
            $totRtkpAll = 0;
            $totRckiAll = 0;
            $totRefAll = 0;
        @endphp
        @foreach($data as $d)
            @php
                if($d->dept == '43'){
                    $totSbkp43 = $d->sbkp;
                    $totSokp43 = $d->sokp;
                    $totStkp43 = $d->stkp;
                    $totScki43 = $d->scki;
                    $totPenj43 = $d->sbkp + $d->sokp + $d->stkp + $d->scki;
                    $totRbkp43 = $d->rbkp;
                    $totRokp43 = $d->rokp;
                    $totRtkp43 = $d->rtkp;
                    $totRcki43 = $d->rcki;
                    $totRef43 = $d->rbkp + $d->rokp + $d->rtkp + $d->rcki;
                }
                if($d->dept == '40'){
                    $totSbkp40 = $d->sbkp;
                    $totSokp40 = $d->sokp;
                    $totStkp40 = $d->stkp;
                    $totScki40 = $d->scki;
                    $totPenj40 = $d->sbkp + $d->sokp + $d->stkp + $d->scki;
                    $totRbkp40 = $d->rbkp;
                    $totRokp40 = $d->rokp;
                    $totRtkp40 = $d->rtkp;
                    $totRcki40 = $d->rcki;
                    $totRef40 = $d->rbkp + $d->rokp + $d->rtkp + $d->rcki;
                }

                $totSbkpAll += $d->sbkp;
                $totSokpAll += $d->sokp;
                $totStkpAll += $d->stkp;
                $totSckiAll += $d->scki;
                $totPenjAll += $d->sbkp + $d->sokp + $d->stkp + $d->scki;
                $totRbkpAll += $d->rbkp;
                $totRokpAll += $d->rokp;
                $totRtkpAll += $d->rtkp;
                $totRckiAll += $d->rcki;
                $totRefAll += $d->rbkp + $d->rokp + $d->rtkp + $d->rcki;
            @endphp


            @if($dept != $d->dept)
                @if($dept != null)
                    <tr class="bold">
                        <td colspan="2" class="left">TOTAL PER DEPT : {{ $dept }}</td>
                        <td class="right">{{ number_format($totSbkp) }}</td>
                        <td class="right">{{ number_format($totSokp) }}</td>
                        <td class="right">{{ number_format($totStkp) }}</td>
                        <td class="right">{{ number_format($totScki) }}</td>
                        <td class="right">{{ number_format($totPenj) }}</td>
                        <td class="right">{{ number_format($totRbkp) }}</td>
                        <td class="right">{{ number_format($totRokp) }}</td>
                        <td class="right">{{ number_format($totRtkp) }}</td>
                        <td class="right">{{ number_format($totRcki) }}</td>
                        <td class="right">{{ number_format($totRef) }}</td>
                        <td class="right">{{ number_format(($totPenj - $totRef) - (($totPenj - $totRef) / 111 * 11)) }}</td>
                        <td class="right">{{ number_format(($totPenj - $totRef) / 111 * 11) }}</td>
                    </tr>
                @endif
                @php
                    $dept = $d->dept;
                    $totSbkp = 0;
                    $totSokp = 0;
                    $totStkp = 0;
                    $totScki = 0;
                    $totPenj = 0;
                    $totRbkp = 0;
                    $totRokp = 0;
                    $totRtkp = 0;
                    $totRcki = 0;
                    $totRef = 0;
                @endphp
            @endif
            @php
                $totalPenjualan = $d->sbkp + $d->sokp + $d->stkp + $d->scki;
                $totalRefund = $d->rbkp + $d->rokp + $d->rtkp + $d->rcki;

                $totSbkp += $d->sbkp;
                $totSokp += $d->sokp;
                $totStkp += $d->stkp;
                $totScki += $d->scki;
                $totPenj += $totalPenjualan;
                $totRbkp += $d->rbkp;
                $totRokp += $d->rokp;
                $totRtkp += $d->rtkp;
                $totRcki += $d->rcki;
                $totRef += $totalRefund;

                $totSexp += $d->sexp;
                $totRexp += $d->rexp;
            @endphp
            <tr>
                <td class="left">{{ $d->kat_kodekategori }}</td>
                <td class="left">{{ $d->kat_namakategori }}</td>
                <td class="right">{{ number_format($d->sbkp) }}</td>
                <td class="right">{{ number_format($d->sokp) }}</td>
                <td class="right">{{ number_format($d->stkp) }}</td>
                <td class="right">{{ number_format($d->scki) }}</td>
                <td class="right">{{ number_format($totalPenjualan) }}</td>
                <td class="right">{{ number_format($d->rbkp) }}</td>
                <td class="right">{{ number_format($d->rokp) }}</td>
                <td class="right">{{ number_format($d->rtkp) }}</td>
                <td class="right">{{ number_format($d->rcki) }}</td>
                <td class="right">{{ number_format($totalRefund) }}</td>
                <td colspan="2"></td>
            </tr>
        @endforeach
            <tr class="bold">
                <td colspan="2" class="left">TOTAL PER DEPT : {{ $dept }}</td>
                <td class="right">{{ number_format($totSbkp) }}</td>
                <td class="right">{{ number_format($totSokp) }}</td>
                <td class="right">{{ number_format($totStkp) }}</td>
                <td class="right">{{ number_format($totScki) }}</td>
                <td class="right">{{ number_format($totPenj) }}</td>
                <td class="right">{{ number_format($totRbkp) }}</td>
                <td class="right">{{ number_format($totRokp) }}</td>
                <td class="right">{{ number_format($totRtkp) }}</td>
                <td class="right">{{ number_format($totRcki) }}</td>
                <td class="right">{{ number_format($totRef) }}</td>
                <td class="right">{{ number_format(($totPenj - $totRef) - (($totPenj - $totRef) / 111 * 11)) }}</td>
                <td class="right">{{ number_format(($totPenj - $totRef) / 111 * 11) }}</td>
            </tr>
            <tr class="bold" style="border-top: 1px solid black">
                <td colspan="2" class="left">** TOTAL BARANG EXPORT</td>
                <td class="right">0</td>
                <td class="right">0</td>
                <td class="right">{{ number_format($totSexp) }}</td>
                <td class="right">0</td>
                <td class="right">{{ number_format($totSexp) }}</td>
                <td class="right">0</td>
                <td class="right">0</td>
                <td class="right">{{ number_format($totRexp) }}</td>
                <td class="right">0</td>
                <td class="right">{{ number_format($totRexp) }}</td>
                <td class="right">0</td>
                <td class="right">0</td>
            </tr>
            <tr class="bold">
                <td colspan="2" class="left">** TOTAL DEPARTEMEN 43</td>
                <td class="right">{{ number_format($totSbkp43) }}</td>
                <td class="right">{{ number_format($totSokp43) }}</td>
                <td class="right">{{ number_format($totStkp43) }}</td>
                <td class="right">{{ number_format($totScki43) }}</td>
                <td class="right">{{ number_format($totPenj43) }}</td>
                <td class="right">{{ number_format($totRbkp43) }}</td>
                <td class="right">{{ number_format($totRokp43) }}</td>
                <td class="right">{{ number_format($totRtkp43) }}</td>
                <td class="right">{{ number_format($totRcki43) }}</td>
                <td class="right">{{ number_format($totRef43) }}</td>
                <td class="right">{{ number_format(($totPenj43 - $totRef43) - (($totPenj43 - $totRef43) / 111 * 11)) }}</td>
                <td class="right">{{ number_format(($totPenj43 - $totRef43) / 111 * 11) }}</td>
            </tr>
            <tr class="bold">
                <td colspan="2" class="left">** TOTAL AKHIR (TANPA DEPT 40)</td>
                <td class="right">{{ number_format($totSbkpAll - $totSbkp40) }}</td>
                <td class="right">{{ number_format($totSokpAll - $totSokp40) }}</td>
                <td class="right">{{ number_format($totStkpAll - $totStkp40) }}</td>
                <td class="right">{{ number_format($totSckiAll - $totScki40) }}</td>
                <td class="right">{{ number_format($totPenjAll - $totPenj40) }}</td>
                <td class="right">{{ number_format($totRbkpAll - $totRbkp40) }}</td>
                <td class="right">{{ number_format($totRokpAll - $totRokp40) }}</td>
                <td class="right">{{ number_format($totRtkpAll - $totRtkp40) }}</td>
                <td class="right">{{ number_format($totRckiAll - $totRcki40) }}</td>
                <td class="right">{{ number_format($totRefAll - $totRef40) }}</td>
                <td class="right">{{ number_format((($totPenjAll - $totPenj40) - ($totRefAll - $totRef40)) - ((($totPenjAll - $totPenj40) - ($totRefAll - $totRef40)) / 111 * 11)) }}</td>
                <td class="right">{{ number_format((($totPenjAll - $totPenj40) - ($totRefAll - $totRef40)) / 111 * 11) }}</td>
            </tr>
            <tr class="bold">
                <td colspan="2" class="left">** TOTAL AKHIR (+ DEPT 40)</td>
                <td class="right">{{ number_format($totSbkpAll) }}</td>
                <td class="right">{{ number_format($totSokpAll) }}</td>
                <td class="right">{{ number_format($totStkpAll) }}</td>
                <td class="right">{{ number_format($totSckiAll) }}</td>
                <td class="right">{{ number_format($totPenjAll) }}</td>
                <td class="right">{{ number_format($totRbkpAll) }}</td>
                <td class="right">{{ number_format($totRokpAll) }}</td>
                <td class="right">{{ number_format($totRtkpAll) }}</td>
                <td class="right">{{ number_format($totRckiAll) }}</td>
                <td class="right">{{ number_format($totRefAll) }}</td>
                <td class="right">{{ number_format(($totPenjAll - $totRefAll) - (($totPenjAll - $totRefAll) / 111 * 11)) }}</td>
                <td class="right">{{ number_format(($totPenjAll - $totRefAll) / 111 * 11) }}</td>
            </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
