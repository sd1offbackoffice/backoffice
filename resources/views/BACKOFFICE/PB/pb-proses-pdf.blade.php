@extends('html-template')

@section('table_font_size','7 px')
@section('paper_height','442pt')
@section('paper_width','842pt')

@section('page_title')
    LAPORAN PB MANUAL DI TOKO IGR
@endsection

@section('title')
    LAPORAN PB MANUAL DI TOKO IGR
@endsection

@section('subtitle')
    Tgl : {{ $tgl1 }} s/d {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="3" class="bawah center">No.</th>
            <th rowspan="3" class="bawah center">Div</th>
            <th rowspan="3" class="bawah center">Dep</th>
            <th rowspan="3" class="bawah center">Kat</th>
            <th rowspan="3" class="bawah center">PLU</th>
            <th rowspan="3" class="bawah center">Deskripsi</th>
            <th rowspan="3" class="bawah center">Nama Supplier</th>
            <th rowspan="3" class="bawah center">Frac</th>
            <th rowspan="3" class="bawah center">PKM</th>
            <th rowspan="3" class="bawah center">SOH</th>
            <th colspan="4" class="center">Draft PB Manual</th>
            <th colspan="4" class="center">PB Manual</th>
        </tr>
        <tr>
            <th rowspan="2" class="bawah center">No.</th>
            <th rowspan="2" class="bawah center">Tgl Input</th>
            <th colspan="2" class="center">Qty</th>
            <th rowspan="2" class="bawah center">User ID</th>
            <th rowspan="2" class="bawah center">No.</th>
            <th rowspan="2" class="bawah center">Tgl Input</th>
            <th rowspan="2" class="bawah center">Qty</th>
            <th rowspan="2" class="bawah center">User ID</th>
        </tr>
        <tr>
            <th class="bawah center">Input</th>
            <th class="bawah center">Real</th>
        </tr>
        </thead>
        <tbody>
        @php
            $no = 1;
            $div = null;
            $dep = null;
            $kat = null;
        @endphp
        @foreach($data as $d)
            <tr>
                @if($div == $d->pdm_kodedivisi && $dep == $d->pdm_kodedepartement && $kat == $d->pdm_kodekategoribrg)
                    <td class="left"></td>
                @else
                    <td class="left">{{ $no++ }}</td>
                @endif
                <td class="center">{{ $div == $d->pdm_kodedivisi ? '' : $d->pdm_kodedivisi }}</td>
                <td class="center">{{ $dep == $d->pdm_kodedepartement ? '' : $d->pdm_kodedepartement }}</td>
                <td class="center">{{ $kat == $d->pdm_kodekategoribrg ? '' : $d->pdm_kodekategoribrg }}</td>
                <td class="center">{{ $d->pdm_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td class="left">{{ $d->sup_namasupplier }}</td>
                <td class="right">{{ $d->prd_frac }}</td>
                <td class="right">{{ $d->pdm_pkmt }}</td>
                <td class="right">{{ $d->pdm_saldoakhir }}</td>
                <td class="center">{{ $d->pdm_nodraft }}</td>
                <td class="center">{{ $d->pdm_create_dt }}</td>
                <td class="right">{{ $d->qty_input }}</td>
                <td class="right">{{ $d->pdm_qtypb }}</td>
                <td class="center">{{ $d->pdm_create_by }}</td>
                <td class="center">{{ $d->phm_nopb }}</td>
                <td class="center">{{ $d->phm_tglpb }}</td>
                <td class="right">{{ $d->pdm_qtypb }}</td>
                <td class="center">{{ $d->phm_approval }}</td>
            </tr>
            @php
                $div = $d->pdm_kodedivisi;
                $dep = $d->pdm_kodedepartement;
                $kat = $d->pdm_kodekategoribrg;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
