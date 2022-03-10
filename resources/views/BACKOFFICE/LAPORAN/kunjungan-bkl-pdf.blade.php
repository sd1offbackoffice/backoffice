@extends('html-template')

@section('table_font_size','7 px')

@section('paper_width','842pt')
@section('paper_width','595pt')

@section('page_title')
    LAPORAN BULANAN KEDATANGAN SUPPLIER BKL BERDASARKAN JADWAL HARI KUNJUNGAN
@endsection

@section('title')
    LAPORAN BULANAN KEDATANGAN SUPPLIER BKL BERDASARKAN JADWAL HARI KUNJUNGAN
@endsection

@section('subtitle')
    Periode : {{ $date }}
@endsection

@section('content')
    <table class="table" border="1">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="3" class="tengah">No.</th>
            <th rowspan="3" class="tengah">Kode<br>Supp</th>
            <th rowspan="3" class="tengah">Nama Supplier</th>
            <th colspan="7" class="center">Hari Kunjungan</th>
            <th rowspan="3" class="tengah">TOP</th>
            <th rowspan="3" class="tengah">LT</th>
            <th colspan="31" class="center">Hari Kedatangan</th>
            <th rowspan="3" class="tengah">%<br>ssuai<br>kdtngn</th>
            <th rowspan="3" class="tengah">%<br>ssuai<br>kunjgn</th>
        </tr>
        <tr>
            <th rowspan="2" class="tengah">Mgg</th>
            <th rowspan="2" class="tengah">Snn</th>
            <th rowspan="2" class="tengah">Sls</th>
            <th rowspan="2" class="tengah">Rbu</th>
            <th rowspan="2" class="tengah">Kms</th>
            <th rowspan="2" class="tengah">Jmt</th>
            <th rowspan="2" class="tengah">Sbt</th>
            @for($i=1;$i<=31;$i++)
                <th>{{ substr('0'.$i,-2) }}</th>
            @endfor
        </tr>
        <tr>
            @foreach($hari as $h)
                <th>{{ $h->hari }}</th>
            @endforeach
            @for($i=count($hari);$i<31;$i++)
                <th></th>
            @endfor
        </tr>
        </thead>
        <tbody>
        @php $no=1; @endphp
        @foreach($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->mstd_kodesupplier }}</td>
                <td class="left">{{ $d->sup_namasupplier }}</td>
                <td class="center">{{ $d->minggu }}</td>
                <td class="center">{{ $d->senin }}</td>
                <td class="center">{{ $d->selasa }}</td>
                <td class="center">{{ $d->rabu }}</td>
                <td class="center">{{ $d->kamis }}</td>
                <td class="center">{{ $d->jumat }}</td>
                <td class="center">{{ $d->sabtu }}</td>
                <td class="center">{{ $d->sup_top }}</td>
                <td class="center">{{ $d->sup_jangkawaktukirimbarang }}</td>
                @php
                    $tgl = explode(',',$d->tgl);
                @endphp
                @for($i=1;$i<=31;$i++)
                    @if(in_array(substr('0'.$i,-2),$tgl) != -1)
                        <td></td>
                    @else
                        <td class="center">Y</td>
                    @endif
                @endfor
                <td class="right">{{ number_format($d->ssdtg,2) }}</td>
                <td class="right">{{ number_format($d->sskunj,2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
