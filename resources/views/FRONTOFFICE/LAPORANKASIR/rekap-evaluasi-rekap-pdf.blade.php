@extends('pdf-template')

@section('page_title')
    Evaluasi Langganan Per Member {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('title')
    ** EVALUASI LANGGANAN PER MEMBER **
@endsection

@section('subtitle')
    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('header_left')
    <br>
    <p>
        BARANG COUNTER : {{ strtoupper($counter) }}
    </p>
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="center tengah" colspan="2">OUTLET</th>
            <th class="center tengah" colspan="2">SUB OUTLET</th>
            <th class="right tengah">SLIP</th>
            <th class="right tengah">PRODUK</th>
            <th class="right tengah">MEMBER</th>
            <th class="right tengah">KUNJ</th>
            <th class="right tengah">KONT</th>
            <th class="right tengah">RUPIAH</th>
            <th class="right tengah">&nbsp;&nbsp;&nbsp;&nbsp;KONT</th>
            <th class="right tengah">MARGIN</th>
            <th class="right tengah">&nbsp;&nbsp;&nbsp;&nbsp;KONT</th>
            <th class="right tengah">%</th>
            <th class="right">&nbsp;&nbsp;&nbsp;&nbsp;MBR<br>1X / BLN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tot_slip = 0;
            $tot_produk = 0;
            $tot_member = 0;
            $tot_kunjungan = 0;
            $tot_kont1 = 0;
            $tot_rupiah = 0;
            $tot_kont2 = 0;
            $tot_margin = 0;
            $tot_kont3 = 0;
            $tot_cost = 0;
            $tot_mbr = 0;

            $tot_slip_lain = 0;
            $tot_produk_lain = 0;
            $tot_member_lain = 0;
            $tot_kunjungan_lain = 0;
            $tot_kont1_lain = 0;
            $tot_rupiah_lain = 0;
            $tot_kont2_lain = 0;
            $tot_margin_lain = 0;
            $tot_kont3_lain = 0;
            $tot_cost_lain = 0;
            $tot_mbr_lain = 0;
        @endphp
        @foreach($data as $d)
            @if($d->otmemb != null)
                @php
                    $cf_totmemb = $d->otmemb;
                    $cf_marginp = $d->otamt == null ? 0 : ($d->otamt - $d->otcost) / $d->otamt * 100;

                    $margin = $d->otamt - $d->otcost;
                    $kont1 = $d->otfreq / $total_kunj * 100;
                    $kont2 = $d->otamt / $total_rupiah * 100;
                    $kont3 = $margin / $total_margin * 100;

                    $tot_slip += $d->otslip;
                    $tot_produk += $d->otprod;
                    $tot_member += $d->otmemb;
                    $tot_kunjungan += $d->otfreq;
                    $tot_kont1 += $kont1;
                    $tot_rupiah += $d->otamt;
                    $tot_kont2 += $kont2;
                    $tot_margin += $margin;
                    $tot_kont3 += $kont3;
                    $tot_cost += $d->otcost;
                    $tot_mbr += $d->otbmemb;
                @endphp

                <tr>
                    <td colspan="2" class="left">{{ $d->foutlt }} &nbsp; {{ strlen($d->out_namaoutlet) > 7 ? substr($d->out_namaoutlet, 0, 7).'...' : $d->out_namaoutlet }}</td>
{{--                    <td width="4%" class="left"></td>--}}
                    <td colspan="2" class="left">{{ $d->fsoutl }} &nbsp; {{ strlen($d->sub_namasuboutlet) > 7 ? substr($d->sub_namasuboutlet, 0, 7).'...' : $d->sub_namasuboutlet }}</td>
{{--                    <td class="left">{{ strlen($d->sub_namasuboutlet) > 7 ? substr($d->sub_namasuboutlet, 0, 7).'...' : $d->sub_namasuboutlet }}</td>--}}
                    <td class="right">{{ $d->otslip }}</td>
                    <td class="right">{{ $d->otprod }}</td>
                    <td class="right">{{ $d->otmemb }}</td>
                    <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->otfreq }}</td>
                    <td class="right">{{ number_format($kont1, 2, '.', ',') }}</td>
                    <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($d->otamt, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($kont2, 2, '.', ',') }}</td>
                    <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($margin, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($kont3, 2, '.', ',') }}</td>
                    <td class="right">{{ number_format($cf_marginp, 2, '.', ',') }}</td>
                    <td class="right">{{ $d->otbmemb }}</td>
                </tr>
            @endif
            @if($d->qtmemb != null)
                @php
                    $cf_totmemb = $d->otmemb + $d->qtmemb;
                    $cf_marginp = $d->qtamt == null ? 0 : ($d->qtamt - $d->qtcost) / $d->qtamt * 100;

                    $margin = $d->qtamt - $d->qtcost;
                    $kont1 = $d->qtfreq / $total_kunj * 100;
                    $kont2 = $d->qtamt / $total_rupiah * 100;
                    $kont3 = $margin / $total_margin * 100;

                    $tot_slip_lain += $d->qtslip;
                    $tot_produk_lain += $d->qtprod;
                    $tot_member_lain += $d->qtmemb;
                    $tot_kunjungan_lain += $d->qtfreq;
                    $tot_kont1_lain += $kont1;
                    $tot_rupiah_lain += $d->qtamt;
                    $tot_kont2_lain += $kont2;
                    $tot_margin_lain += $margin;
                    $tot_kont3_lain += $kont3;
                    $tot_cost_lain += $d->qtcost;
                    $tot_mbr_lain += $d->qtbmemb;
                @endphp

                <tr>
                    <td class="left" colspan="4">CBG LAIN [ {{ strlen($d->out_namaoutlet) > 7 ? substr($d->out_namaoutlet, 0, 7).'...' : $d->out_namaoutlet }} ]</td>
                    <td class="right">{{ $d->qtslip }}</td>
                    <td class="right">{{ $d->qtprod }}</td>
                    <td class="right">{{ $d->qtmemb }}</td>
                    <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->qtfreq }}</td>
                    <td class="right">{{ number_format($kont1, 2, '.', ',') }}</td>
                    <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($d->qtamt, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($kont2, 2, '.', ',') }}</td>
                    <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($margin, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($kont3, 2, '.', ',') }}</td>
                    <td class="right">{{ number_format($cf_marginp, 2, '.', ',') }}</td>
                    <td class="right">{{ $d->qtbmemb }}</td>
                </tr>
        @endif
        @endforeach
        <tfoot>
        <tr class="bold">
            <td class="right" colspan="4">TOTAL :</td>
            <td class="right">{{ number_format($tot_slip, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_produk, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_member, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kunjungan, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kont1, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_rupiah, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kont2, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_margin, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kont3, 2, '.', ',') }}</td>
            <td class="right">{{ number_format(($tot_rupiah - $tot_cost) / $tot_rupiah * 100, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_mbr, 0, '.', ',') }}</td>
        </tr>
        <tr class="bold">
            <td class="right" colspan="4">TOTAL CAB LAIN :</td>
            <td class="right">{{ number_format($tot_slip_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_produk_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_member_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kunjungan_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kont1_lain, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_rupiah_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kont2_lain, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_margin_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kont3_lain, 2, '.', ',') }}</td>
            <td class="right">{{ number_format(($tot_rupiah_lain - $tot_cost_lain) / $tot_rupiah_lain * 100, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_mbr_lain, 0, '.', ',') }}</td>
        </tr>
        <tr class="bold">
            <td class="right" colspan="4">TOTAL :</td>
            <td class="right">{{ number_format($tot_slip + $tot_slip_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_produk + $tot_produk_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_member + $tot_member_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kunjungan + $tot_kunjungan_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kont1 + $tot_kont1_lain, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_rupiah + $tot_rupiah_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kont2 + $tot_kont2_lain, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_margin + $tot_margin_lain, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_kont3 + $tot_kont3_lain, 2, '.', ',') }}</td>
            <td class="right">{{ number_format((($tot_rupiah + $tot_rupiah_lain) - ($tot_cost + $tot_cost_lain)) / ($tot_rupiah + $tot_rupiah_lain) * 100, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($tot_mbr + $tot_mbr_lain, 0, '.', ',') }}</td>
        </tr>
        {{--        <tr class="bold">--}}
        {{--            <td colspan="13" class="right">Total Poin Internal Member Merah : {{ $poin }}</td>--}}
        {{--            <td colspan="2"></td>--}}
        {{--        </tr>--}}
        </tfoot>
    </table>
@endsection
