{{----------------------------------------------------------------------------}}
@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
     Laporan Pareto Sales By Member
@endsection

@section('title')
    LAPORAN PARETO SALES BY MEMBER
@endsection

@section('subtitle')
    {{ $tgl_start }} - {{ $tgl_end }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right">NO</th>
            <th class="right padding-right">NOMOR</th>
            <th class="left">NAMA LANGGANAN</th>
            <th class="left">OUTLET</th>
            <th class="right">KUNJUNGAN</th>
            <th class="right">SLIP</th>
            <th class="right">PRODUK</th>
            <th class="right">RUPIAH</th>
            <th class="right">MARGIN</th>
            <th class="right">%</th>
        </tr>
        </thead>
        <tbody>
        @php
           $kunjungan  = 0;
           $slip       = 0;
           $produk     = 0;
           $rupiah     = 0;
           $margin     = 0;
           $number     = 1;
        @endphp
        @foreach($data as $value)
            <tr>
                <td class="right">{{ $number }}</td>
                <td class="right padding-right">{{$value->fcusno}}</td>
                <td class="left">{{$value->fnama}}</td>
                <td class="left">{{$value->foutlt}} - {{$value->out_namaoutlet}}</td>
                <td class="right">{{$value->fwfreq}}</td>
                <td class="right">{{$value->fwslip}}</td>
                <td class="right">{{$value->fwprod}}</td>
                <td class="right">{{number_format($value->fwamt ,2,'.',',')}}</td>
                <td class="right">{{number_format($value->fgrsmargn ,2,'.',',')}}</td>
                <td class="right">{{number_format((($value->fgrsmargn/(($value->fwamt > 0) ? $value->fwamt : 1))*100),2) }}</td>
            </tr>
            @php
                $number++;
                $kunjungan = $kunjungan + $value->fwfreq;
                $slip = $slip + $value->fwslip;
                $produk = $produk + $value->fwprod;
                $rupiah = $rupiah + $value->fwamt;
                $margin = $margin + $value->fgrsmargn;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="4">Total :</td>
            <td class="right">{{$kunjungan}}</td>
            <td class="right">{{$slip}}</td>
            <td class="right">{{number_format($produk ,2,'.',',')}}</td>
            <td class="right">{{number_format($rupiah ,2,'.',',')}}</td>
            <td class="right">{{number_format($margin ,2,'.',',')}}</td>
            <td class="right">{{number_format((($margin/(($rupiah > 0) ? $rupiah : 1))*100),2) }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
