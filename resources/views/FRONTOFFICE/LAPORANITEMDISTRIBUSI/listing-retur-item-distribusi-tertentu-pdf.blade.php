@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Listing Retur Item(s) Distribusi Tertentu
@endsection

@section('title')
    Listing Retur Item(s) Distribusi Tertentu
@endsection

@section('subtitle')
    Periode : {{ $tgl1 }}
@endsection

@section('content')

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah right padding-right" rowspan="2">No.</th>
            <th class="tengah center" rowspan="2">Kode Member</th>
            <th class="tengah center" colspan="2">Struk Penukaran Barang Distribusi (SPBD)</th>
            <th class="tengah center" colspan="2">Struk Penjualan (SP) Pengganti</th>
            <th class="tengah center " rowspan="2">Selisih antara Nilai (Rp.) SPBD<br>vs Nilai (Rp.) SPBD yang<br>digunakan</th>
        </tr>
        <tr>
            <th class="tengah center">No. SPBD</th>
            <th class="tengah center">Nilai (Rp.) SPBD</th>
            <th class="tengah center">No. SP</th>
            <th class="tengah center">Nilai (Rp.) SPBD yang<br>digunakan</th>
        </tr>
        </thead>
        <tbody>
{{--        <tr>--}}
{{--            <td class="right padding-right">1</td>--}}
{{--            <td class="center">MM123456</td>--}}
{{--            <td class="center">SPBD/KMY/13028</td>--}}
{{--            <td class="center">75000</td>--}}
{{--            <td class="center">SP123924</td>--}}
{{--            <td class="center">75000</td>--}}
{{--            <td class="center">0</td>--}}
{{--        </tr>--}}

        @php
            $spbd = 0;
            $usedSpbd = 0;
            $selisih = 0;
        @endphp
        @foreach($data as $key => $d)
            <tr>
                <td class="right padding-right">{{ $key+1 }}</td>
                <td class="center">{{ $d->vcrt_kodemember }}</td>
                <td class="center">{{ $d->no_sp }}</td>
                <td class="right">{{ number_format($d->vcrt_nominal) }}</td>
                <td class="center">{{ $d->no_spbd == 'SPBD/KMY/' ? '' : $d->no_spbd }}</td>
                <td class="right">{{ number_format($d->jh_voucheramt) }}</td>
                <td class="right">{{ number_format($d->selisih) }}</td>
            </tr>
            @php
                $spbd += $d->jh_voucheramt;
                $usedSpbd += $d->vcrt_nominal;
                $selisih += $d->selisih;
            @endphp
        @endforeach
            <tr style="border-top: 1px solid black">
                <td class="center" colspan="2">Total (Rp.)</td>
                <td></td>
                <td class="right">{{ number_format($usedSpbd) }}</td>
                <td></td>
                <td class="right">{{ number_format($spbd) }}</td>
                <td class="right">{{ number_format($selisih) }}</td>
            </tr>
        </tbody>
        <tfooter>

        </tfooter>
    </table>
@endsection
