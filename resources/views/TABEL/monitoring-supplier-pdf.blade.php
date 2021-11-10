@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Tabel Monitoring Supplier {{ date("d/m/Y") }}
@endsection

@section('title')
    ** TABEL MONITORING SUPPLIER **
@endsection

@section('subtitle')
    Kode Monitoring : {{ $monitoring->kode }} - {{ $monitoring->nama }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="10%" class="tengah center">KODE SUPPLIER</th>
            <th width="80%" class="tengah padding-left">NAMA</th>
            <th width="5%" class="tengah center">PKP</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            <tr>
                <td width="5%" class="center">{{ $d->msu_kodesupplier }}</td>
                <td width="80%" class="left padding-left">{{ $d->sup_namasupplier }}</td>
                <td width="5%" class="center">{{ $d->sup_pkp }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
