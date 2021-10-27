@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan SPB Manual
@endsection

@section('title')
    Laporan SPB Manual
@endsection

@section('header_left')
    <br>
    {{ $p_order }}
@endsection
@section('content')

        <table class="table">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th class="right padding-right tengah" rowspan="2">NO</th>
                <th class="left tengah" rowspan="2" >PLU</th>
                <th class="left tengah" rowspan="2" >DESKRIPSI</th>
                <th class="left tengah" rowspan="2" >SATUAN</th>
                <th class="left" colspan="2" style="padding-left: 4px" colspan="2">---PERMINTAAN---</th>
                <th class="right padding-right tengah" rowspan="2">QTY<br>(CTN)</th>
                <th class="left" colspan="2" style="padding-left: 20px">----LOKASI----</th>
                <th class="right tengah" rowspan="2">REALISASI</th>
            </tr>
            <tr>
                <th class="left">TGL</th>
                <th class="left">OLEH</th>
                <th class="left">ASAL</th>
                <th class="left">TUJUAN</th>
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
                    <td class="left">{{ $d->spb_prdcd }}</td>
                    <td class="left">{{ $d->prd_deskripsipanjang}}</td>
                    <td class="left">{{ $d->satuan }}</td>
                    <td class="left">{{ date('d/m/Y',strtotime(substr($d->spb_create_dt,0,10))) }}</td>
                    <td class="left">{{ $d->spb_create_by }}</td>
                    <td class="right padding-right">{{ number_format($d->spb_minus, 0,".",",") }}</td>
                    <td class="left">{{ $d->spb_lokasiasal }}</td>
                    <td class="left">{{ $d->spb_lokasitujuan }}</td>
                    <td class="right">{{ $d->realisasi }}</td>
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
