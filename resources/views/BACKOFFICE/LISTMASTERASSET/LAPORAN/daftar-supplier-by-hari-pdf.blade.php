@extends('html-template')

@section('table_font_size','7px')

@section('page_title')
    DAFTAR SUPPLIER BY HARI
@endsection

@section('title')
    ** DAFTAR SUPPLIER BY HARI **
@endsection

@section('subtitle')

@endsection

@php

    function zeroDigit($angka){
        $digit = number_format($angka,0,'.',',');
        return $digit;
    }
    $hari = '';
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="vertical-align: middle; text-align: left">KODE&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">NAMA SUPPLIER&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">STS.PEN.BRG&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">JK.WK.KI.BR&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">DISC&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: right">MIN (RP)&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: right">MIN (CTN)&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: right">PKP&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            @if($hari != $data[$i]->hari)
                <tr>
                    <td colspan="8" style="text-align: left; font-weight: bold">HARI : {{$data[$i]->hari}}</td>
                </tr>
                @php
                    $hari = $data[$i]->hari;
                @endphp
            @endif
            <tr>
                <td style="text-align: left">{{$data[$i]->sk}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->sup_namasupplier}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->sup_flagpenangananproduk}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->sup_jangkawaktukirimbarang}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->sup_flagdiscontinuesupplier}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: right">{{zeroDigit($data[$i]->sup_minrph)}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: right">{{zeroDigit($data[$i]->sup_minkarton)}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: right">{{$data[$i]->sup_pkp}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
