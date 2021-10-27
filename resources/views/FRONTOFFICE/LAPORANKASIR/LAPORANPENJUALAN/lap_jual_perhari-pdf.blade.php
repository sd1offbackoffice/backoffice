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

@section('content')
{{--<html>--}}
{{--<head>--}}
{{--    <title>LAPORAN-PENJUALAN PER HARI</title>--}}
{{--</head>--}}
{{--<style>--}}
{{--    /**--}}
{{--        Set the margins of the page to 0, so the footer and the header--}}
{{--        can be of the full height and width !--}}
{{--     **/--}}
{{--    @page {--}}
{{--        margin: 25px 25px;--}}
{{--    }--}}

{{--    /** Define now the real margins of every page in the PDF **/--}}
{{--    body {--}}
{{--        margin-top: 80px;--}}
{{--        margin-bottom: 10px;--}}
{{--        font-size: 11px;--}}
{{--        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;--}}
{{--        font-weight: 400;--}}
{{--        line-height: 1.8;--}}
{{--        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/--}}
{{--    }--}}

{{--    /** Define the header rules **/--}}
{{--    header {--}}
{{--        position: fixed;--}}
{{--        top: 0cm;--}}
{{--        left: 0cm;--}}
{{--        right: 0cm;--}}
{{--        height: 2cm;--}}
{{--    }--}}
{{--    table{--}}
{{--        border: 1px;--}}
{{--    }--}}
{{--    .page-break {--}}
{{--        page-break-after: always;--}}
{{--    }--}}
{{--    .page-numbers:after { content: counter(page); }--}}
{{--</style>--}}
{{--<body>--}}
{{--<!-- Define header and footer blocks before your content -->--}}

{{--<header>--}}
{{--    <div style="float:left; margin-top: 0px; line-height: 8px !important;">--}}
{{--        <p>--}}
{{--            {{ $data[0]->prs_namaperusahaan }}--}}
{{--        </p>--}}
{{--        <p>--}}
{{--            {{ $data[0]->prs_namacabang }}--}}
{{--        </p>--}}
{{--    </div>--}}
{{--    <div style="margin-top: -20px; line-height: 0.1px !important;">--}}
{{--        <p>{{$data[0]->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$data[0]->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="position: absolute; top: -20px; left: 550px">--}}
{{--        <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL : {{$today}} <br> PRG  : IDGP69D</span>--}}
{{--    </div>--}}
{{--    <div style="float:right; margin-top: 0px;">--}}
{{--        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>--}}
{{--        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>--}}
{{--        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>--}}
{{--    </div>--}}
{{--    <div style="float: center; line-height: 0.1 !important;">--}}
{{--        <h2 style="text-align: center">LAPORAN PENJUALAN</h2>--}}
{{--        <h2 style="text-align: center">PER HARI</h2>--}}
{{--        <h4 style="text-align: center">{{$periode}}</h4>--}}
{{--    </div>--}}
{{--</header>--}}

<?php
//$i = 1;
//$datetime = new DateTime();
//$timezone = new DateTimeZone('Asia/Jakarta');
//$datetime->setTimezone($timezone);
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
?>

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
{{--    <p style="float: right">**Akhir dari Laporan**</p>--}}

{{--</body>--}}
{{--</html>--}}
@endsection
