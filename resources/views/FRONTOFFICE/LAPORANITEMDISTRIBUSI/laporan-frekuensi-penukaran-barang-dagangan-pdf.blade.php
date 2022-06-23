@extends('frekuensi_penukaran_barang_template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Frekuensi Penukaran Barang Dagangan

@endsection

@section('title')
    Laporan Frekuensi Penukaran Barang Dagangan<br>
    Per Member Merah
@endsection


@section('subtitle')
    @php
        $bulanName = array(
        'JANUARI','FEBRURI','MARET','APRIL','MEI','JUNI','JULI','AGUSTUS','SEPTEMBER','OKTOBER','NOVEMBER','DESEMBER'
        );
    @endphp
    <br> {{ 'Periode : '. $bulanName[(int) substr($bulan,0,2)-1].' '.substr($bulan,3,4)}}<br>
@endsection

@section('content')

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah right padding-right" style="border-left: 1px solid black; border-right: 1px solid black;" rowspan="2">No.</th>
            <th class="tengah center" style="border-bottom: 1px solid black " colspan="2">Member Toko Igr.</th>
            <th class="tengah center" style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black;" colspan="2">Barang yang ditukar</th>


            <th class="tengah " style="border-right:1px solid black;" rowspan="2">Frekuensi<br>Penukaran<br>Barang</th>
        </tr>
        <tr>
            <th class="tengah center" style=" border-right: 1px solid black;">Kode</th>
            <th class="tengah center">Nama</th>
            <th class="tengah center" style="border-left: 1px solid black; border-right: 1px solid black;">PLU</th>
            <th class="tengah center"style=" border-right: 1px solid black;">Deskripsi</th>
        </tr>
        </thead>
        <tbody>

        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td class="right padding-right">{{$i+1}}</td>
                <td>{{ $data[$i]->rom_member }}</td>
                <td class="left">{{ $data[$i]->cus_namamember }}</td>
                <td>{{ $data[$i]->rom_prdcd }}</td>
                <td class="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td class="right">{{ $data[$i]->qty }}</td>
                @endfor
            </tr>
            {{--        <tr>--}}
            {{--            <th class="center" colspan="9">Total</th>--}}
            {{--            <th class="right">50000</th>--}}
            {{--        </tr>--}}
        </tbody>
        <tfooter>
            <tr>
                <th colspan="10" class="left" style="border-top:1px solid black; font-style: italic">* Data yang disampaikan dalam laporan ini adalah untuk item(s) distribusi tertentu
                </th>
            </tr>
            {{--            <tr>--}}
            {{--                <th colspan="10" class="left" style="font-style: italic">** Berisi unit jual di Toko igr.</th>--}}
            {{--            </tr>--}}
        </tfooter>
    </table>
@endsection
