@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN PENCETAKAN FAKTUR PAJAK STANDAR
@endsection

@section('title')
    LAPORAN PENCETAKAN FAKTUR PAJAK STANDAR
@endsection

@section('subtitle')
    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left">TGL. STR</th>
            <th class="left">CUSTOMER</th>
            <th class="left">STT</th>
            <th class="left">KASIR</th>
            <th class="left">STR. NO</th>
            <th class="left">NO SERI FP</th>
            <th class="left">TGL FP</th>
            <th class="right">DPP</th>
            <th class="right">PPN</th>
            <th class="right">PPN DIBEBASKAN</th>
            <th class="right">PPN DTP</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_dpp = 0;
            $total_ppn = 0;
            $total_ppn_bebas = 0;
            $total_ppn_dtp = 0;
        @endphp

        @if(sizeof($data)!=0)
            @foreach($data as $d)
                <tr>
                    <td class="left">{{ date('d/m/Y',strtotime(substr($d->tgl_struk,0,10))) }}</td>
                    <td class="left">{{ $d->customer }}</td>
                    <td class="left">{{ $d->station}}</td>
                    <td class="left">{{ $d->kasir }}</td>
                    <td class="left">{{ $d->struk_no }}</td>
                    <td class="left">{{ $d->no_seri_fp }}</td>
                    <td class="left">{{ date('d/m/Y',strtotime(substr($d->tgl_fp,0,10))) }}</td>
                    <td class="right">{{ number_format($d->dpp, 0,".",",") }}</td>
                    <td class="right">{{ number_format(($d->trjd_flagtax1 == 'Y' && $d->trjd_flagtax2 == 'Y') ? $d->ppn : 0, 0,".",",") }}</td>
                    <td class="right">{{ number_format(($d->trjd_flagtax1 == 'Y' && $d->trjd_flagtax2 == 'P') ? $d->ppn : 0, 0,".",",") }}</td>
                    <td class="right">{{ number_format(($d->trjd_flagtax1 == 'Y' && in_array($d->trjd_flagtax2, ['W','G'])) ? $d->ppn : 0, 0,".",",") }}</td>
                </tr>
                @php
                    $total_dpp += $d->dpp;
                    $total_ppn += $d->ppn;
                    $total_ppn_bebas += ($d->trjd_flagtax1 == 'Y' && $d->trjd_flagtax2 == 'P') ? $d->ppn : 0;
                    $total_ppn_dtp += ($d->trjd_flagtax1 == 'Y' && in_array($d->trjd_flagtax2, ['W','G'])) ? $d->ppn : 0;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        <tr>
            <th colspan="7" class="right">TOTAL :</th>
            <th class="right">{{ number_format($total_dpp, 0,".",",") }}</th>
            <th class="right">{{ number_format($total_ppn, 0,".",",") }}</th>
            <th class="right">{{ number_format($total_ppn_bebas, 0,".",",") }}</th>
            <th class="right">{{ number_format($total_ppn_dtp, 0,".",",") }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
