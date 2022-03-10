@php
    $nodoc = "";
    $nosortir = "";
    if(sizeof($data)>0){
        $nodoc = $data[0]->nodoc;
        $nosortir = $data[0]->nosortir;
    }
@endphp
@extends('html-template')

@section('paper_height','842pt')
@section('paper_width','595pt')

@section('table_font_size','7px')

@section('page_title')
    LAPORAN RUBAH STATUS - RAK
@endsection

@section('title')
    Informasi PLU Perubahan Status untuk Pengecekan Rak Display
@endsection

@section('subtitle')
    <br><br><br>
    <span style="float: left !important; text-align: left !important;">
        No. Dokumen &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$nodoc}}<br>
    </span>
    <span style="float: right !important; text-align: left !important;">
        No. Sortir &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$nosortir}}
    </span>
@endsection

@section('content')

<table class="table table-bordered table-responsive">
    <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
    <tr style="text-align: left; vertical-align: middle">
        <th style="width: 40px">PLU</th>
        <th style="width: 385px !important;">DESKRIPSI</th>
        <th style="width: 90px">QTY (in PCS)</th>
        <th style="width: 213px !important;">KETERANGAN</th>
    </tr>
    </thead>
    <tbody style="border-bottom: 2px solid black">
    @for($i=0; $i<sizeof($data); $i++)
        <tr style="text-align: left">
            <td style="width: 40px">{{$data[$i]->prdcd}}</td>
            <td style="width: 385px !important;">{{$data[$i]->deskripsi}}</td>
            <td style="width: 90px;">{{$data[$i]->qty}}</td>
            <td style="width: 213px; !important;">{{$data[$i]->keterangan}}</td>
        </tr>
    @endfor
    </tbody>
</table>
@endsection
