@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    PLU Non Charge Credit Card
@endsection

@section('title')
    ** PLU Non Charge Credit Card **
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="5%" class="tengah center">No</th>
            <th width="5%" class="tengah center">PLU</th>
            <th width="80%" class="tengah padding-left">DESKRIPSI</th>
            <th width="10%" class="tengah center">UNIT/FRAC</th>
        </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($data as $d)
            <tr>
                <td width="5%" class="center">{{ $no++ }}</td>
                <td width="5%" class="center">{{ $d->non_prdcd }}</td>
                <td width="80%" class="left padding-left">{{ $d->prd_deskripsipanjang }}</td>
                <td width="10%" class="left">{{ $d->unit }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
