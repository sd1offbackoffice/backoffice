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
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="margin-top: -10px; margin-left: 594px; line-height: 0.1px !important;">
        <span style="float: right; margin-right: 15px"> {{$today}}</span>
    </div>
    <div style="line-height: 0.1 !important;">
        <h2 style="text-align: center">Informasi PLU Perubahan Status untuk Pengecekan Rak Display</h2>
    </div>
    <div style="line-height: 0.1px !important;">
        <p>Nomor Dokumen &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{$datas[0]->nodoc}}</p>
    </div>
    <div style="margin-top: -50px; margin-left: 484px; line-height: 0.1px !important;">
        <p>No. Sortir&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;{{$datas[0]->nosortir}}</p>
    </div>
    <hr style="margin-top: -10px">
</header>

<body>
<table class="table table-bordered table-responsive">
    <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
    <tr style="text-align: center; vertical-align: center">
        <th style="width: 40px">PLU</th>
        <th style="width: 385px !important; text-align: left">DESKRIPSI</th>
        <th style="width: 90px">QTY (in PCS)</th>
        <th style="width: 213px !important; text-align: right">KETERANGAN</th>
    </tr>
    </thead>
    <tbody style="border-bottom: 3px solid black">
    {{$counter = 12}}
    @for($i=0; $i<sizeof($datas); $i++)
        <tr>
            <td style="width: 40px">{{$datas[$i]->prdcd}}</td>
            <td style="width: 385px !important; text-align: left">{{$datas[$i]->deskripsi}}</td>
            <td style="width: 90px; text-align: center">{{$datas[$i]->qty}}</td>
            <td style="width: 213px; !important; text-align: right">{{$datas[$i]->keterangan}}</td>
        </tr>
        @if($i==$counter)
    </tbody>
</table>
<div class="page-break"></div>
{{$counter = $counter + 12}}
<table class="table table-bordered table-responsive">
    <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
    <tr style="text-align: center; vertical-align: center">
        <th style="width: 40px">PLU</th>
        <th style="width: 385px !important; text-align: left">DESKRIPSI</th>
        <th style="width: 90px">QTY (in PCS)</th>
        <th style="width: 213px !important; text-align: right">KETERANGAN</th>
    </tr>
    </thead>
    <tbody style="border-bottom: 3px solid black">
    @endif
    @endfor
    </tbody>
</table>
<hr style="margin-top: 20px; margin-botton: 30px">
<div style="line-height: 0.1px !important; text-align: right">
    <label for="keterangan">** Akhir Laporan ** </label>
</div>
<hr style="margin-top: 10px; margin-botton: 20px">
</body>



</body>
</html>
