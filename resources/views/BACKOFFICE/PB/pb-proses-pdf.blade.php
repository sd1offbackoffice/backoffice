@extends('html-template')

@section('table_font_size','7 px')
@section('paper_height','442pt')
@section('paper_width','842pt')

@section('page_title')
    @lang('LAPORAN PB MANUAL DI TOKO IGR')
@endsection

@section('title')
    @lang('LAPORAN PB MANUAL DI TOKO IGR')
@endsection

@section('subtitle')
    @lang('Tgl : '){{ $tgl1 }} @lang('s/d') {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="3" class="bawah center">@lang('No.')</th>
            <th rowspan="3" class="bawah center">@lang('Div')</th>
            <th rowspan="3" class="bawah center">@lang('Dep')</th>
            <th rowspan="3" class="bawah center">@lang('Kat')</th>
            <th rowspan="3" class="bawah center">@lang('PLU')</th>
            <th rowspan="3" class="bawah center">@lang('Deskripsi')</th>
            <th rowspan="3" class="bawah center">@lang('Nama Supplier')</th>
            <th rowspan="3" class="bawah center">@lang('Frac')</th>
            <th rowspan="3" class="bawah center">@lang('PKM')</th>
            <th rowspan="3" class="bawah center">@lang('SOH')</th>
            <th colspan="4" class="center">@lang('Draft PB Manual')</th>
            <th colspan="4" class="center">@lang('PB Manual')</th>
        </tr>
        <tr>
            <th rowspan="2" class="bawah center">@lang('No.')</th>
            <th rowspan="2" class="bawah center">@lang('Tgl Input')</th>
            <th colspan="2" class="center">@lang('Qty')</th>
            <th rowspan="2" class="bawah center">@lang('User ID')</th>
            <th rowspan="2" class="bawah center">@lang('No.')</th>
            <th rowspan="2" class="bawah center">@lang('Tgl Input')</th>
            <th rowspan="2" class="bawah center">@lang('Qty')</th>
            <th rowspan="2" class="bawah center">@lang('User ID')</th>
        </tr>
        <tr>
            <th class="bawah center">@lang('Input')</th>
            <th class="bawah center">@lang('Real')</th>
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
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="left"></td>
                @else
                    <td class="left">{{ $no++ }}</td>
                    <td class="center">{{ $d->pdm_kodedivisi }}</td>
                    <td class="center">{{ $d->pdm_kodedepartement }}</td>
                    <td class="center">{{ $d->pdm_kodekategoribrg }}</td>
                @endif

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
