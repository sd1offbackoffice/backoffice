@extends('html-template')

@section('table_font_size','7px')

@section('paper_size','842pt 595pt')
@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    PEMUTIHAN PLU - LAPORAN
@endsection

@section('title')
    {{$ket}}
@endsection

@section('subtitle')
@endsection
@php
    $counter = 1;
    $holder = '';
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="vertical-align: middle; text-align: left">NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">PLU&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">DESKRIPSI&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">BARCODE MD&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">BARCODE IGR&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            @if($holder != $data[$i]->plu)
                <tr>
                    <td style="text-align: left">{{$counter}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">{{$data[$i]->plu}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">{{$data[$i]->prd_deskripsipanjang}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">{{$data[$i]->brc_md}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">{{$data[$i]->brc_igr}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                @php
                    $holder = $data[$i]->plu;
                    $counter++;
                @endphp
            @else
                <tr>
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">{{$data[$i]->brc_md}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">{{$data[$i]->brc_igr}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            @endif
        @endfor
        </tbody>
    </table>
@endsection
