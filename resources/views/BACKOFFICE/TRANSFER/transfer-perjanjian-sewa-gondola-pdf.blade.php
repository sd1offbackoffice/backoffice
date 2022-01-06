@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    TEMP_GDL_{{ \Carbon\Carbon::now()->format('Y-m-d') }}_01
@endsection

@section('title')
    ** TEMP_GDL_{{ \Carbon\Carbon::now()->format('Y-m-d') }}_01 **
@endsection

@section('subtitle')
{{--    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}--}}
@endsection

@section('header_left')
{{--    <p>MONITORING : {{ $monitoring }}</p>--}}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah center">No. Perjanjian Sewa</th>
            <th class="tengah center">PLU</th>
            <th class="tengah left">Deskripsi</th>
            <th class="tengah center">Unit</th>
            <th class="tengah left">Principal</th>
            <th class="tengah center">Display</th>
            <th class="tengah right">Qty_N+</th>
            <th class="tengah center">Mulai</th>
            <th class="tengah center">Berakhir</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            <tr>
                <th class="tengah center">{{ $d->ftnpjs }}</th>
                <th class="tengah center">{{ $d->ftkode }}</th>
                <th class="tengah left">{{ $d->prd_deskripsipendek }}</th>
                <th class="tengah center">{{ $d->prd_unit }} / {{ $d->prd_frac }}</th>
                <th class="tengah left">{{ $d->ftkpcp }} - </th>
                <th class="tengah center">{{ $d->ftkdis }}</th>
                <th class="tengah right">{{ number_format($d->ftkqty) }}</th>
                <th class="tengah center">{{ $d->ftfrtg }}</th>
                <th class="tengah center">{{ $d->fttotg }}</th>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
