@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Monitoring PLU Baru
@endsection

@section('title')
    ** MONITORING PLU BARU **
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>PLU</th>
            <th>DESKRIPSI</th>
            <th>TGL DAFTAR</th>
            <th>TGL BPB</th>
            <th>PKMT</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            <tr>
                <td>{{ $d->fmkplu }}</td>
                <td class="left">{{ $d->deskripsi }}</td>
                <td>{{ $d->fmtgld }}</td>
                <td>{{ $d->tglbpb }}</td>
                <td>{{ $d->fmpkmt }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>

        </tfoot>
    </table>
@endsection
