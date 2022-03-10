@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LIST PLU DENGAN BANYAK LOKASI DALAM FILE RAK PDF
@endsection

@section('title')
    ** TEMP_GDL_{{ \Carbon\Carbon::now()->format('Y-m-d') }}_01 **
@endsection

@section('subtitle')
@endsection

@section('header_left')
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah left">P.L.U</th>
            <th class="tengah left">DESKRIPSI</th>
            <th class="tengah right">RAK</th>
            <th class="tengah right">SUBRAK</th>
            <th class="tengah right">TIPE</th>
            <th class="tengah right">SHELVING</th>
            <th class="tengah right">NO. URUT</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            <tr>
                <th class="tengah left">{{ $d->fmkplu }}</th>
                <th class="tengah left">{{ $d->prd_deskripsipanjang }}</th>
                <th class="tengah right">{{ $d->fmkrak }}</th>
                <th class="tengah right">{{ $d->fmksrak }}</th>
                <th class="tengah right">{{ $d->fmtipe }} - </th>
                <th class="tengah right">{{ $d->fmselv }}</th>
                <th class="tengah right">{{ number_format($d->fmnour) }}</th>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
