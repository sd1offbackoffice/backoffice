@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    TABEL MONITORING PRODUK {{ date("d/m/Y") }}
@endsection

@section('title')
    ** TABEL MONITORING PRODUK **
@endsection

@section('subtitle')
    Kode Monitoring : {{ $monitoring->kode }} - {{ $monitoring->nama }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="5%" class="right padding-right">No</th>
            <th width="5%" class="tengah center">PLU</th>
            <th width="80%" class="left padding-left">DESKRIPSI</th>
            <th width="5%" class="tengah center">UNIT/FRAC</th>
            <th width="5%" class="tengah">TAG</th>
        </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($data as $d)
            <tr>
                <td width="5%" class="right padding-right">{{ $no++ }}</td>
                <td width="5%" class="center">{{ $d->mpl_prdcd }}</td>
                <td width="80%" class="left padding-left">{{ $d->prd_deskripsipanjang }}</td>
                <td width="5%" class="left">{{ $d->satuan }}</td>
                <td width="5%" class="center">{{ $d->prd_kodetag }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
