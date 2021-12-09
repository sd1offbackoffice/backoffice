@extends('html-template')

@section('table_font_size','7px')

@section('page_title')
    DAFTAR STATUS TAG BAR
@endsection

@section('title')
    ** LISTING STATUS TAG BARCODE **
@endsection

@section('subtitle')
@endsection

@php
    $departemen = '';
    $kategori = '';
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="vertical-align: middle; text-align: left">PLU</th>
                <th style="vertical-align: middle; text-align: left">DESKRIPSI</th>
                <th style="vertical-align: middle; text-align: left">SATUAN</th>
                <th style="vertical-align: middle; text-align: left">STS</th>
            </tr>
        </thead>
        <tbody style="text-align: left; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            @if($departemen != $data[$i]->dep)
                <tr>
                    <td colspan="4" style="text-align: left">{{$data[$i]->dep}}</td>
                </tr>
                @php
                  $departemen = $data[$i]->dep;
                @endphp
            @endif
            @if($kategori != $data[$i]->kat)
                <tr>
                    <td colspan="4" style="text-align: left">{{$data[$i]->kat}}</td>
                </tr>
                @php
                    $kategori = $data[$i]->kat;
                @endphp
            @endif
            <tr>
                <td>{{$data[$i]->prd_prdcd}}</td>
                <td>{{$data[$i]->prd_deskripsipanjang}}</td>
                <td>{{$data[$i]->prd_unit_prd_frac}}</td>
                <td>{{$data[$i]->prd_flagbarcode1}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
