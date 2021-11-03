@extends('pdf-template')

@section('table_font_size','10 px')

@section('page_title')
    LAPORAN-PENJUALAN PER HARI
@endsection

@section('title')
    LAPORAN PENJUALAN PER HARI
@endsection

@section('subtitle')
    {{$periode}}
@endsection

@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
    //    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
    function twopoint($angka){
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="2" style="width: 80px; text-align: left; vertical-align: middle">TANGGAL</th>
                <th rowspan="2" style="width: 70px; text-align: left; vertical-align: middle">HARI</th>
                <th rowspan="2" style="width: 120px; text-align: right; vertical-align: middle">PENJUALAN<br>KOTOR</th>
                <th rowspan="2" style="width: 100px; text-align: right; vertical-align: middle">PAJAK</th>
                <th rowspan="2" style="width: 120px; text-align: right; vertical-align: middle">PENJUALAN<br>BERSIH</th>
                <th rowspan="2" style="width: 100px; text-align: right; vertical-align: middle">H.P.P RATA2</th>
                <th colspan="2" style=" text-align: right; vertical-align: middle">---MARGIN---</th>
{{--                <th style="width: 40px;">&nbsp;&nbsp;&nbsp;&nbsp;</th>--}}
            </tr>
            <tr>
                <td style="width: 100px; text-align: right">Rp.</td>
                <td style="width: 20px; text-align: right">%</td>
            </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black; text-align: right">
        @for($i=0;$i<sizeof($data);$i++)
            <?php
            $date = ($data[$i]->sls_periode);
            $createDate = new DateTime($date);
            $strip = $createDate->format('d-m-Y');
            ?>
            <tr>
                <td style="text-align: left">{{$strip}}</td>
                <td style="text-align: left">{{$data[$i]->hari}}</td>
                <td>{{rupiah($data[$i]->sls_nilai)}}</td>
                <td>{{rupiah($data[$i]->sls_tax)}}</td>
                <td>{{rupiah($data[$i]->sls_net)}}</td>
                <td>{{rupiah($data[$i]->sls_hpp)}}</td>
                <td>{{rupiah($data[$i]->sls_margin)}}</td>
                <td>{{twopoint(($data[$i]->p_margin))}}</td>
            </tr>
        @endfor
        <tr style="font-weight: bold">
            <td colspan="2" style="text-align: center; border-top: 1px black solid">GRAND TOTAL</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['gross'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['tax'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['net'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['hpp'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['margin'])}}</td>
            <td style="border-top: 1px solid black;">{{twopoint(($val['margp']))}}</td>
        </tr>
        </tbody>
    </table>
@endsection
