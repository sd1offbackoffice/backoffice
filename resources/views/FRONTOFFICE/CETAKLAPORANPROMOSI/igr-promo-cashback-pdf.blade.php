@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Promosi yang Masih Berlaku
@endsection

@section('title')
    Laporan Promosi yang Masih Berlaku
@endsection

@section('header_left')
    <br>
    Jenis : {{ $data[0]->cborgf }}
@endsection

@section('paper_width')
    842
@endsection

@section('paper_size')
    842pt  595pt
@endsection

@section('content')
    <br>
<table class="table">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
        <th class="right padding-right" rowspan="2">No</th>
        <th class="left" rowspan="2">Kode<br>Promosi</th>
        <th class="left" rowspan="2">Nama Program Promosi</th>
        <th class="left" rowspan="2">Berlaku <br>untuk <br>Member</th>
        <th class="left" rowspan="2">Produk Sponsor</th>
        <th class="right padding-right" rowspan="2">Cashback</th>
        <th class="left" colspan="2">Periode Promosi</th>
    </tr>
    <tr>
        <th class="left">Awal</th>
        <th class="left">Akhir</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total = 0;
        $i=1;
        $tempkodepromosi = '';
    @endphp

    @if(sizeof($data)!=0)
        @foreach($data as $d)
            @if($tempkodepromosi != $d->kodepromosi)
            <tr>
                <td class="right padding-right">{{ $i }}</td>
                <td class="left">{{ $d->kodepromosi }}</td>
                <td class="left">{{ $d->promosi}}</td>
                <td class="left">{{ $d->memberberlaku }}</td>
                <td class="left">{{ $d->plu }}</td>
                <td class="right padding-right">{{ number_format($d->cashbackamt, 0,".",",") }}</td>
                <td class="left padding-right">{{ date('d/m/Y',strtotime(substr($d->cbh_tglawal,0,10))) }}</td>
                <td class="left">{{ date('d/m/Y',strtotime(substr($d->cbh_tglakhir,0,10))) }}</td>
            </tr>
            @php
                $tempkodepromosi =  $d->kodepromosi;
                $i++;
            @endphp
            @else
                <tr>
                    <td class="right padding-right"> </td>
                    <td class="left"> </td>
                    <td class="left"> </td>
                    <td class="left"> </td>
                    <td class="left">{{ $d->plu }}</td>
                    <td class="right padding-right">{{ $d->cashbackamt }}</td>
                    <td class="left"> </td>
                    <td class="left"> </td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="10">TIDAK ADA DATA</td>
        </tr>
    @endif
    </tbody>
    <tfoot>
    </tfoot>
</table>
@endsection
