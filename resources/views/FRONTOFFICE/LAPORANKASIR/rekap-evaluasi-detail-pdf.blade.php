@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Evaluasi Langganan Per Member {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('title')
    ** Evaluasi Langganan Per Member **
@endsection

@section('subtitle')
    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('custom_style')
    @page{
        size: A4
    }
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right">No.</th>
            <th class="center">Nomor</th>
            <th class="center">Nama Langganan</th>
            <th class="center" colspan="2">Outlet</th>
            <th class="center" colspan="2">Sub Outlet</th>
            <th class="right">Kunjungan</th>
            <th class="right">Slip</th>
            <th class="right">Produk</th>
            <th class="right">Rupiah</th>
            <th class="right">Margin</th>
            <th class="right">%</th>
        </tr>
        </thead>
        <tbody>
        @php
            $kunjungan = 0;
            $slip = 0;
            $produk = 0;
            $rupiah = 0;
            $margin = 0;

            $no = 1;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="right padding-right">{{ $no }}</td>
                <td class="left">{{ $d->fcusno }}</td>
                <td class="left">&nbsp;{{ strlen($d->fnama) < 15 ? $d->fnama : substr($d->fnama,0,15).'...' }}</td>
                <td class="left">{{ $d->foutlt }}</td>
                <td class="left">{{ strlen($d->out_namaoutlet) < 10 ? $d->out_namaoutlet : substr($d->out_namaoutlet,0,10).'...' }}</td>
                <td class="left">&nbsp;&nbsp;{{ $d->fsoutl }}</td>
                <td class="left">{{ strlen($d->sub_namasuboutlet) < 10 ? $d->sub_namasuboutlet : substr($d->sub_namasuboutlet,0,10).'...' }}</td>
                <td class="right">&nbsp;{{ $d->fwfreq }}</td>
                <td class="right">{{ $d->fwslip }}</td>
                <td class="right">{{ $d->fwprod }}</td>
                <td class="right">{{ number_format($d->fwamt, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->fgrsmargn, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->fgrsmargn / $d->fwamt * 100, 1, '.', ',') }}</td>
            </tr>
        @php
            $no++;
            $kunjungan += $d->fwfreq;
            $slip += $d->fwslip;
            $produk += $d->fwprod;
            $rupiah += $d->fwamt;
            $margin += $d->fgrsmargn;
        @endphp
        @endforeach
        <tfoot>
        <tr class="bold">
            <td class="top-bottom right" colspan="7">TOTAL :</td>
            <td class="top-bottom right">{{ number_format($kunjungan, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($slip, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($produk, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($rupiah, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($margin, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($margin / $rupiah * 100, 2, '.', ',') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
