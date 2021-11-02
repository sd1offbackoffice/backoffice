@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Listing Tolakan BKL OMI
@endsection

@section('title')
    LISTING TOLAKAN BKL OMI
@endsection

{{--@section('subtitle')--}}
{{--    {{ $tgl_start }} - {{ $tgl_end }}--}}
{{--@endsection--}}

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="center">NO</th>
            <th class="left">CAB</th>
            <th class="left">NAMA</th>
            <th class="right padding-right">NO DOC</th>
            <th class="left">TGL DOC</th>
            <th class="left">SUPPLIER</th>
            <th class="right padding-right">PLU</th>
            <th class="left">NAMA BARANG</th>
            <th class="left">SATUAN</th>
            <th class="right">QTY</th>
            <th class="right padding-right">BONUS</th>
            <th class="left">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $number     = 1;
        @endphp
        @foreach($data as $value)
            <tr>
                <td class="center">{{$number}}</td>
                <td class="left">{{$value->kodetoko}}</td>
                <td class="left">{{$value->tko_namaomi}}</td>
                <td class="right padding-right">{{$value->no_bukti}}</td>
                <td class="left">{{date('d/m/Y', strtotime($value->tgl_bukti))}}</td>
                <td class="left">{{$value->kodesupplier}}</td>
                <td class="right padding-right">{{$value->prdcd}}</td>
                <td class="left">{{$value->prd_deskripsipendek}}</td>
                <td class="left">{{$value->satuan}}</td>
                <td class="right">{{$value->qty}}</td>
                <td class="right padding-right">{{$value->bonus}}</td>
                <td class="left">{{$value->keterangan}}</td>
            </tr>
            @php
                $number++;
            @endphp
        @endforeach
        </tbody>
        <tfoot></tfoot>
    </table>
@endsection
