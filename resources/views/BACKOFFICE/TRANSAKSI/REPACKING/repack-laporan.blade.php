<html>
<head>
    <title>LAPORAN-RAK</title>
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
        margin-top: 100px;
        margin-bottom: 10px;
        font-size: 9px;
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
    table{
        border: 1px;
    }
    .page-break {
        page-break-after: always;
    }
    .page-numbers:after { content: counter(page); }
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
    <div style="margin-top: -20px; line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_alamat1}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="margin-top: -10px; margin-left: 594px; line-height: 0.1px !important;">
        <span style="float: right; margin-right: 15px">Tgl/Jam Cetak : &nbsp;&nbsp;&nbsp;&nbsp; {{$today}}</span>
    </div>
    <div style="line-height: 0.1 !important;">
        <h2 style="text-align: center">Informasi PLU Perubahan Status untuk Pengecekan Rak Display</h2>
    </div>
    <div style="line-height: 0.1px !important;">
        <p>Nomor Dokumen &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </p>
    </div>
    <div style="margin-top: -50px; margin-left: 484px; line-height: 0.1px !important;">
        <p>No. Sortir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>
    <hr style="margin-top: -10px">
</header>

<body>
<p>Still Empty MAHBOIIII!!!</p>
</body>



</body>
</html>
