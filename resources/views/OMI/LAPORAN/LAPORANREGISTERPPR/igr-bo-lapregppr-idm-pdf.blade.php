@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN REGISTER PPR IDM
@endsection

@section('title')
    LAPORAN REGISTER PPR IDM
@endsection

@section('subtitle')
    {{ 'Tgl : '. substr($tgl1,0,10) .' - '. substr($tgl2,0,10) }}<br>
    {{ 'No. Dokumen : '. $nodoc1 .' - '. $nodoc2 }}<br>
@endsection


@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left">TGL</th>
            <th class="right">NO. NRB</th>
            <th class="right">NO. DOK</th>
            <th class="right padding-right">NO. NOTA RETUR</th>
            <th class="left">ITEM</th>
            <th class="left">MEMBER</th>
            <th class="right">NILAI</th>
            <th class="right">PPN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_nilai = 0;
            $total_ppn = 0;
            $tgl_temp = '';
        @endphp
        @if(sizeof($data)!=0)
            @foreach($data as $d)
                @if($tgl_temp != $d->trpt_salesinvoicedate)
                    <tr>
                        <td class="left">{{ date('d/m/Y',strtotime(substr($d->trpt_salesinvoicedate,0,10))) }}</td>
                        <td class="right">{{ $d->trpt_invoicetaxno }}</td>
                        <td class="right">{{ $d->trpt_salesinvoiceno}}</td>
                        <td class="right padding-right">{{ $d->cf_item }}</td>
                        <td class="left">{{ $d->tko_kodeomi }}</td>
                        <td class="left">{{ $d->member }}</td>
                        <td class="right">{{ number_format($d->trpt_netsales,0) }}</td>
                        <td class="right">{{ number_format($d->trpt_ppntaxvalue,0) }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="left"></td>
                        <td class="right">{{ $d->trpt_invoicetaxno }}</td>
                        <td class="right">{{ $d->trpt_salesinvoiceno}}</td>
                        <td class="right padding-right">{{ $d->cf_item }}</td>
                        <td class="left">{{ $d->tko_kodeomi }}</td>
                        <td class="left">{{ $d->member }}</td>
                        <td class="right">{{ number_format($d->trpt_netsales,0) }}</td>
                        <td class="right">{{ number_format($d->trpt_ppntaxvalue,0) }}</td>
                    </tr>
                @endif
                @php
                    $tgl_temp = $d->trpt_salesinvoicedate;
                    $total_nilai += $d->trpt_netsales;
                    $total_ppn += $d->trpt_ppntaxvalue;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="12">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot style="border-bottom: none">
        <tr>
            <th colspan="6" align="right">TOTAL</th>
            <th align="right">{{ number_format($total_nilai,0) }}</th>
            <th align="center">{{ number_format($total_ppn,0) }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
