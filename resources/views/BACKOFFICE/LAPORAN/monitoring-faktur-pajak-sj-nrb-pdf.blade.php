@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
   LAPORAN MONITORING PENGECEKAN FAKTUR PAJAK {{$cetak}}
@endsection

@section('title')
    LAPORAN MONITORING PENGECEKAN FAKTUR PAJAK {{$cetak}}
@endsection

@section('subtitle')
    TANGGAL : {{ $tgl1 }} s/d {{ $tgl2 }}
    <br>
    {{$keterangan}}
@endsection

{{--@section('paper_height')--}}
{{--    595pt--}}
{{--@endsection--}}

{{--@section('paper_width')--}}
{{--    842pt--}}
{{--@endsection--}}
@php
    $tot_item = 0;
    $tot_gross = 0;
@endphp
@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left tengah">No</th>
            <th class="left tengah">TANGGAL</th>
            <th class="left tengah">No. DOKUMEN</th>
            <th class="left tengah">NO. FAKTUR PAJAK</th>
            <th class="right tengah">ITEM</th>
            <th class="right padding-right tengah">TOTAL</th>
            <th class="left tengah">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>

        @for($i=0; $i<sizeof($data) ;$i++)
            <tr>
                <td class="left">{{ $i+1 }}</td>
                <td class="left">{{ date('d/m/Y',strtotime(substr($data[$i]->mstd_tgldoc ,0,10)))}}</td>
                <td class="left">{{ $data[$i]->mstd_nodoc }}</td>
                <td class="left">{{ $data[$i]->mstd_invno }}</td>
                <td class="right">{{ number_format($data[$i]->item,0,".",",") }}</td>
                <td class="right padding-right">{{ $data[$i]->gross }}</td>
                <td class="left">{{ $data[$i]->keterangan }}</td>
            </tr>
            @php
                $tot_item += $data[$i]->item;
                $tot_gross += $data[$i]->gross;
            @endphp

        @endfor
        </tbody>
        <tfoot>
        <tr>
            <th class="left" colspan="4"> TOTAL SELURUHNYA </th>
            <th class="right">{{ number_format($tot_item,0,".",",") }}</th>
            <th class="right padding-right">{{ number_format($tot_gross,0,".",",") }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
