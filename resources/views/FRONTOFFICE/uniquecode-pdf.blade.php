<html>
<head>
    <title>LAPORAN-PROMOSI REDEEM via UNIQUE CODE</title>
</head>
<style>
    /**
        Set the margins of the page to 0, so the footer and the header
        can be of the full height and width !
     **/
    @page {
        margin: 25px 25px;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 120px;
        margin-bottom: 10px;
        font-size: 12px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }
    .page-break {
        page-break-after: always;
    }
    .page-numbers:after { content: counter(page); }

    .oneline{
        display: inline-block;
        padding: 5px;

    }

    table{
        margin: auto;
        width: 60%;
        padding: 10px;
    }
</style>
<body>
<!-- Define header and footer blocks before your content -->
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
<header>
    <div style="line-height: 0.1px !important;">
        <p>{{$datas->prs_namaperusahaan}}</p>
        <p>{{$datas->prs_namacabang}}</p>
    </div>
    <div style="position: absolute; left: 595px; top: -8px">
        <span>{{$today}} {{$time}}</span>
    </div>
    <div style="line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN PROMOSI REDEEM via UNIQUE CODE</h2>
    </div>
</header>


<div class="oneline" style="line-height: 0.1 !important; width: 150px">
    <p>Kode Promosi</p>
    <p>Periode</p>
    <p>Jenis Member</p>
    <p>Item Pembanding</p>
    <p>Minimum Pembelian</p>
</div>
<div class="oneline" style="line-height: 0.1 !important; width: 380px">
    <p> : {{$promosi}}</p>
    <p> : {{$tglawal}} s/d {{$tglakhir}}</p>
    <p> : {{$member}}</p>
    <p> : {{$item}}</p>
    <p> : {{$minbeli}} pcs</p>

</div>
<div class="oneline" style="line-height: 0.1 !important; width: 150px; margin-top: -62px">
    <p style="vertical-align: top">{{$tglpromo1}} s/d {{$tglpromo2}}</p>
</div>
<table style="border-collapse: collapse">
    <thead style="border: 3px solid black;">
        <tr style="text-align: center; vertical-align: center">
            <th style="width: 400px; text-align: left; border-right: 3px solid black">&nbsp;&nbsp;KETERANGAN</th>
            <th style="width: 200px; text-align: right">NILAI&nbsp;&nbsp;</th>
        </tr>
    </thead>
    <tbody style="border: 1px solid black">
        <tr>
            <td style="border-right: 1px solid black">Kunjungan Member ke I-Kiosk</td>
            <td style="text-align: right">{{$kunj}}</td>
        </tr>
        <tr>
            <td style="border-right: 1px solid black">Member yang Membeli Produk Perbandingan</td>
            <td style="text-align: right">{{$banding}}</td>
        </tr>
        <tr>
            <td style="border-right: 1px solid black">Member yang Menggunakan Unique Code</td>
            <td style="text-align: right">{{$unique}}</td>
        </tr>
        <tr>
            <td style="border-right: 1px solid black">Persentase Penggunaan Unique Code per Item</td>
            <td style="text-align: right">{{$persen}}%</td>
        </tr>
    </tbody>
</table>

</body>
</html>

