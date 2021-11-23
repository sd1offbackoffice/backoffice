@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN PENCETAKAN FAKTUR PAJAK STANDAR NONPKP
@endsection

@section('title')
    LAPORAN PENCETAKAN FAKTUR PAJAK STANDAR NONPKP
@endsection

@section('subtitle')
    Periode : {{ $periode }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left">CUSTOMER</th>
            <th class="left">NO. SERI FP</th>
            <th class="left">TGL FP</th>
            <th class="right">DPP</th>
            <th class="right">PPN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_dpp = 0;
            $total_ppn = 0;
        @endphp

        @if(sizeof($data)!=0)
            @foreach($data as $d)
                <tr>
                    <td class="left">{{ $d->customer }}</td>
                    <td class="left">{{ $d->nomor_faktur }}</td>
                    <td class="left">{{ date('d/m/Y',strtotime(substr($d->tgl_faktur,0,10))) }}</td>
                    <td class="right">{{ number_format($d->dpp, 0,".",",") }}</td>
                    <td class="right">{{ number_format($d->ppn, 0,".",",") }}</td>
                </tr>
                @php
                    $total_dpp += $d->dpp;
                    $total_ppn += $d->ppn;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot style="border-bottom: none">
        <tr>
            <th colspan="3" class="right">TOTAL :</th>
            <th class="right">{{ number_format($total_dpp, 0,".",",") }}</th>
            <th class="right">{{ number_format($total_ppn, 0,".",",") }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
