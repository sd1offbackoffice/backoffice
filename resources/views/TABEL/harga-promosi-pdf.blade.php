@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    TABEL HARGA PROMOSI
@endsection

@section('title')
    TABEL HARGA PROMOSI
@endsection

@php
    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
    function percent($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th rowspan="2" style="text-align: left; vertical-align: middle; width: 5%">PLU</th>
                <th rowspan="2" style="text-align: left; vertical-align: middle; width: 40%">Deskripsi</th>
                <th rowspan="2" style="text-align: left; vertical-align: middle; width: 5%">Satuan</th>
                <th colspan="2" style="text-align: center; vertical-align: middle;">------- TANGGAL -------</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 10%">HARGA<br>JUAL</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 10%">POTONGAN<br>PERSEN</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 10%">POTONGAN<br>RUPIAH</th>
                <th rowspan="2" style="text-align: center; vertical-align: middle; width: 3%">JNS</th>
            </tr>
            <tr>
                <th style="text-align: center; vertical-align: middle; width: 8%">MULAI</th>
                <th style="text-align: center; vertical-align: middle; width: 8%">SELESAI</th>
            </tr>
        </thead>
        <tbody>
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td style="text-align: left">{{$data[$i]->prmd_prdcd}}</td>
                <td style="text-align: left">{{$data[$i]->prd_deskripsipanjang}}</td>
                <td style="text-align: left">{{$data[$i]->unit}}</td>
                <td style="text-align: center">{{$data[$i]->prmd_tglawal}}</td>
                <td style="text-align: center">{{$data[$i]->prmd_tglakhir}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->prmd_hrgjual)}}</td>
                <td style="text-align: right">{{percent($data[$i]->prmd_potonganpersen)}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->prmd_potonganrph)}}</td>
                <td style="text-align: center">{{$data[$i]->prmd_jenisdisc}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
