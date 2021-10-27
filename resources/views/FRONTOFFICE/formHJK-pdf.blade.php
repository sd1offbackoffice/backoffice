@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    FORM USULAN HARGA JUAL KHUSUS ( NAIK / TURUN )
@endsection

@section('title')
    FORM USULAN HARGA JUAL KHUSUS ( NAIK / TURUN )
@endsection

@section('subtitle')
    Periode : {{$date1}} s/d {{$date2}}
@endsection

@section('content')

{{--<html>--}}
{{--<head>--}}
{{--    <title>FORM USULAN HARGA JUAL KHUSUS ( NAIK / TURUN )</title>--}}
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
{{--        margin-top: 100px;--}}
{{--        margin-bottom: 10px;--}}
{{--        font-size: 9px;--}}
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
{{--<?php--}}
{{--$i = 1;--}}
{{--$datetime = new DateTime();--}}
{{--$timezone = new DateTimeZone('Asia/Jakarta');--}}
{{--$datetime->setTimezone($timezone);--}}
{{--?>--}}
{{--<header>--}}
{{--    <div style="float:left; margin-top: 0px; line-height: 8px !important;">--}}
{{--        <p>{{$prs->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$prs->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="margin-top: -20px; line-height: 0.1px !important;">--}}
{{--        <p>{{$perusahaan->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$perusahaan->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="position: absolute;top: -17px; left: 576px; line-height: 0.1px !important;">--}}
{{--        <p>Tgl pengajuan : {{$today}} {{$time}}</p>--}}
{{--    </div>--}}
{{--    <div style="float:right; margin-top: 0px;">--}}
{{--        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>--}}
{{--        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>--}}
{{--        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>--}}
{{--    </div>--}}
{{--    <div style="float:center;line-height: 0.1 !important;">--}}
{{--        <h2 style="text-align: center">FORM USULAN HARGA JUAL KHUSUS ( NAIK / TURUN )</h2>--}}
{{--        <h4 style="text-align: center">Periode : {{$date1}} s/d {{$date2}}</h4>--}}
{{--    </div>--}}
{{--</header>--}}
<?php
function rupiah($angka){
    //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,2,'.',',');
    return $hasil_rupiah;
}
function percent($angka){
    //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,2,'.',',');
    return $hasil_rupiah;
}
?>

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="3" width="20px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">No.</th>
                <th rowspan="3" width="40px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">PLU</th>
                <th rowspan="3" width="150px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">DESKRIPSI</th>
                <th rowspan="3" width="20px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">QTY</th>
                <th rowspan="3" width="30px" style="text-align: center; vertical-align: middle; border-right: 1px solid black">SATUAN</th>
                <th colspan="4" style="border-right: 1px solid black">Rp.</th>
                <th colspan="3">% Margin</th>
            </tr>
            <tr style="text-align: center; vertical-align: center">
                <th colspan="2" style="border-right: 1px solid black; border-top: 1px solid black">HPP (Include PPN)</th>
                <th colspan="2" style="border-right: 1px solid black; border-top: 1px solid black">Harga Jual</th>
                <th rowspan="2" width="60px" style="text-align: center; vertical-align: middle; border-right: 1px solid black; border-top: 1px solid black">Normal</th>
                <th colspan="2" style="border-top: 1px solid black">Usulan</th>
            </tr>
            <tr style="text-align: center; vertical-align: center">
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Last Cost</th>
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Avg Cost</th>
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Normal</th>
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Usulan</th>
                <th width="60px" style="border-right: 1px solid black; border-top: 1px solid black">Last Cost</th>
                <th width="60px" style="border-top: 1px solid black">Avg Cost</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 1px solid black">
        @for($i=1;$i<sizeof($data);$i++)
            <tr style="text-align: center; vertical-align: center">
                <td>{{$i}}</td>
                <td>{{$data[$i]['plu']}}</td>
                <td style="text-align: left">{{$data[$i]['deskripsi']}}</td>
                <td>{{$data[$i]['qty']}}</td>
                <td>{{$data[$i]['satuan']}}</td>
                <td style="text-align: right">{{rupiah($data[$i]['lcost'])}}</td>
                <td style="text-align: right">{{rupiah($data[$i]['avgcost'])}}</td>
                <td style="text-align: right">{{rupiah($data[$i]['normal'])}}</td>
                <td style="text-align: right">{{rupiah($data[$i]['usulan'])}}</td>
                <td>{{percent($data[$i]['normalmargin'])}}</td>
                <td>{{percent($data[$i]['lcostmargin'])}}</td>
                <td>{{percent($data[$i]['avgcostmargin'])}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
    <table style="font-size: 12px; margin-top: 20px">
        <tbody>
        <tr>
            <td style="width: 50px"> </td>
            <td style="width: 120px">Diproses :</td>
            <td style="width: 20px"> </td>
            <td style="width: 120px">Disetujui :</td>
            <td style="width: 20px"> </td>
            <td style="width: 120px">Disetujui :</td>
            <td style="width: 20px"> </td>
            <td style="width: 120px">Dibuat :</td>
        </tr>
        @for($i=0; $i<10; $i++)
            <tr><td colspan="5"></td></tr>
        @endfor
        <tr>
            <td> </td>
            <td style="border-bottom: 1px black solid"></td>
            <td> </td>
            <td style="border-bottom: 1px black solid"></td>
            <td> </td>
            <td style="border-bottom: 1px black solid"></td>
            <td> </td>
            <td style="border-bottom: 1px black solid"></td>
        </tr>
        <tr>
            <td> </td>
            <td>Merchandising Support Mgr.</td>
            <td> </td>
            <td>Merchandising Sr. Mgr.</td>
            <td> </td>
            <td>Merchandising Mgr.</td>
            <td> </td>
            <td>Store Mgr. / Store Jr. Mgr.</td>
        </tr>
        </tbody>
    </table>
<br>
    <p style="line-height: 0.1 !important;">*Qty. hasil deal dengan Member tertentu &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; KETERANGAN  : berlaku untuk satuan jual karton dan pcs.</p>

{{--</body>--}}

{{--</html>--}}

@endsection
