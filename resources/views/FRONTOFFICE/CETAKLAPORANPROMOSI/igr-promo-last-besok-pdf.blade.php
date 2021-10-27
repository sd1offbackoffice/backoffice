@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN PROMOSI YANG AKAN BERAKHIR
@endsection

@section('title')
    LAPORAN PROMOSI YANG AKAN BERAKHIR
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="right padding-right">No</th>
            <th rowspan="2" class="left">Kode Promosi</th>
            <th rowspan="2" class="left">Nama Program Promosi</th>
            <th rowspan="2" class="left">Produk Sponsor</th>
            <th colspan="2" class="left" style="padding-left: 25px">Periode Promosi</th>
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
        @endphp

        @if(sizeof($data)!=0)
            @foreach($data as $d)
                <tr>
                    <td class="right padding-right">{{ $i }}</td>
                    <td class="left">{{ $d->cbh_kodepromosi }}</td>
                    <td class="left">{{ $d->promosi}}</td>
                    <td class="left">{{ $d->plu }} - {{ $d->descpan }}</td>
                    <td class="left">{{ date('d/m/Y',strtotime(substr($d->cbh_tglawal,0,10))) }}</td>
                    <td class="left">{{ date('d/m/Y',strtotime(substr($d->cbh_tglakhir,0,10))) }}</td>
                </tr>
                @php
                    $i++;
                @endphp
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
