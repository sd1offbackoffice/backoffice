@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    Daftar PB Yang Tidak Terbentuk PO
@endsection

@section('title')
    Daftar PB Yang Tidak Terbentuk PO
@endsection

@section('subtitle')
    Periode: {{$tanggal1}} s/d {{$tanggal2}}
@endsection

@section('content')

    <table class="table-bordered" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
        <tr>
            <th rowspan="2" class="tengah">No</th>
            <th width="20%" colspan="2" class="tengah">PB</th>
            <th width="20%" colspan="2" class="tengah">PLU</th>
            <th width="30%" rowspan="2" class="tengah left">Deskripsi</th>
            <th width="10%" rowspan="2" class="tengah right">Qty. PB</th>
            <th width="20%" rowspan="2" class="tengah">Keterangan</th>
        </tr>
        <tr>
            <th class="tengah">No</th>
            <th class="tengah">Tanggal</th>
            <th class="tengah">MCG</th>
            <th class="tengah">Igr</th>
        </tr>
        </thead>
        <tbody>
        @php
        $i=1;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="center">{{$i}}</td>
                <td class="center">{{$d->NOPB}}</td>
                <td class="center">{{$d->TGLPB}}</td>
                <td class="center">{{$d->PLUMCG}}</td>
                <td class="center">{{$d->PLUIGR}}</td>
                <td class="left">{{$d->deskripsi}}</td>
                <td class="right">{{$d->QTYPB}}</td>
                <td class="center">{{$d->KET}}</td>
            </tr>
            @php
                $i++;
            @endphp
        @endforeach
        </tbody>
    </table>
@endsection
