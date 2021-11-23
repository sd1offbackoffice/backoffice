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
            <th width="2%" class="right tengah padding-right">No.</th>
            <th class="left tengah">KODE</th>
            <th class="left tengah">NAMA</th>
            <th class="left tengah">PKP</th>
        </tr>
        </thead>
        <tbody>
        @php
            $no=1;
        @endphp
        @foreach($data as $d)
            <tr>
                <td width="2%" class="right  padding-right">{{ $no }}</td>
                <td class="left">{{ $d->msu_kodesupplier }}</td>
                <td class="left">{{ $d->sup_namasupplier }}</td>
                <td class="left">{{ $d->sup_pkp }}</td>
            </tr>
            @php
                $no++;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
