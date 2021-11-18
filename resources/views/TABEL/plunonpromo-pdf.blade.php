@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Tabel PLU Yang Tidak Ikut Promo
@endsection

@section('title')
    ** Tabel PLU Yang Tidak Ikut Promo **
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>NO</th>
            <th>PLU</th>
            <th>DESKRIPSI</th>
            <th>SATUAN</th>
        </tr>
        </thead>
        <tbody>
        @php $i=1; @endphp
        @foreach($data as $d)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->desk }}</td>
                <td>{{ $d->satuan }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
