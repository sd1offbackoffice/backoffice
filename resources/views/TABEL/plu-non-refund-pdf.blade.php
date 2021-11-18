@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    PLU Non Refund
@endsection

@section('title')
    ** PLU NON REFUND **
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="15%" class="tengah">NO</th>
            <th width="25%" class="left">PLU</th>
            <th width="45%" class="left padding-left">DESKRIPSI</th>
            <th width="15%" class="tengah center">SATUAN</th>
        </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($data as $d)
            <tr>
                <td width="15%" class="center">{{ $no++ }}</td>
                <td width="25%" class="center">{{ $d->plu }}</td>
                <td width="45%" class="left padding-left">{{ $d->desk }}</td>
                <td width="15%" class="left">{{ $d->satuan }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
