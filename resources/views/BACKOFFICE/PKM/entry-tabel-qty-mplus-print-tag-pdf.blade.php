@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    List M+ yang tidak ada di Prodcrm & Tag = A R N O H X
@endsection

@section('title')
    ** List M+ yang tidak ada di Prodcrm & Tag = A R N O H X **
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="center">PLU</th>
            <th class="left">DESKRIPSI<th>
            <th class="left">SATUAN</th>
            <th class="right">AVERAGE SL</th>
            <th class="center">TAG</th>
            <th class="right">QTY</th>
            <th class="center">KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
        @php $plu = null; @endphp
        @foreach($data as $d)
            <tr>
                <th class="">{{ $d->pkmp_prdcd }}</th>
                <th class="left ">{{ $d->prd_deskripsipanjang }}<th>
                <th class="left">{{ $d->unit }}</th>
                <th class="right">{{ number_format($d->pkm_qtyaverage, 2) }}</th>
                <th class="center">{{ $d->prc_kodetag }}</th>
                <th class="right">{{ number_format($d->pkmp_qtyminor, 2) }}</th>
                <th class="center">{{ $d->keterangan }}</th>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
