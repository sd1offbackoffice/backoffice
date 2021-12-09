@extends('html-template')

@section('table_font_size','8px')

@section('page_title')
    LAPORAN SERVICE LEVEL SALES THD PB (TOTAL)
@endsection

@section('title')
    ** LAPORAN SERVICE LEVEL SALES THD PB (TOTAL) **
@endsection

@section('subtitle')
    {{--    Periode :--}}
    {{--    {{ date("d/m/Y") }}--}}
@endsection

@php
    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
        }
@endphp

@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <td rowspan="2" style="border-right: 1px solid black">No.</td>
                <td rowspan="2" style="border-right: 1px solid black">Member</td>
                <td rowspan="2" style="border-right: 1px solid black">Cabang</td>
                <td colspan="3" style="border-bottom: 1px solid black; border-right: 1px solid black">-------- R U P I A H --------</td>
                <td colspan="3" style="border-bottom: 1px solid black; border-right: 1px solid black">--- Q U A N T I T Y ---</td>
                <td colspan="3" style="border-bottom: 1px solid black;">------ I T E M ------</td>
            </tr>
            <tr>
                <td style="border-right: 1px solid black">PO </td>
                <td style="border-right: 1px solid black">Realisasi </td>
                <td style="border-right: 1px solid black">% </td>

                <td style="border-right: 1px solid black">PO </td>
                <td style="border-right: 1px solid black">Realisasi </td>
                <td style="border-right: 1px solid black">% </td>

                <td style="border-right: 1px solid black">PO </td>
                <td style="border-right: 1px solid black">Realisasi </td>
                <td>% </td>
            </tr>
        </thead>
        <tbody>
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td>{{$i+1}}</td>
                <td style="text-align: left">{{$data[$i]->kodemember}} {{$data[$i]->cus_namamember}}</td>
                <td style="text-align: left">{{$data[$i]->pbo_kodeomi}} - {{$data[$i]->tko_namaomi}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->nilaio)}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->nilair)}}</td>
                @if($data[$i]->nilaio == '0' || $data[$i]->nilair == '0')
                    <td style="text-align: right">0</td>
                @else
                    <td style="text-align: right">{{round((float)($data[$i]->nilair)/(float)($data[$i]->nilaio) * 100, 2)}}</td>
                @endif

                <td style="text-align: right">{{rupiah($data[$i]->qtyo)}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->qtyr)}}</td>
                @if($data[$i]->qtyo == '0' || $data[$i]->qtyr == '0')
                    <td style="text-align: right">0</td>
                @else
                    <td style="text-align: right">{{round((float)($data[$i]->qtyr)/(float)($data[$i]->qtyo) * 100, 2)}}</td>
                @endif

                <td style="text-align: right">{{rupiah($data[$i]->itemo)}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->itemr)}}</td>
                @if($data[$i]->itemo == '0' || $data[$i]->itemr == '0')
                    <td style="text-align: right">0</td>
                @else
                    <td style="text-align: right">{{round((float)($data[$i]->itemr)/(float)($data[$i]->itemo) * 100, 2)}}</td>
                @endif
            </tr>
        @endfor
        <tr style="font-weight: bold">
            <td colspan="3" style="border-top: 2px solid black;">TOTAL SELURUHNYA</td>
            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['tnilo'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['tnilr'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{$val['totnil']}}</td>

            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['tqtyo'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['tqtyr'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{$val['totqty']}}</td>

            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['titemo'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['titemr'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{$val['totitem']}}</td>
        </tr>
        </tbody>
    </table>
@endsection
