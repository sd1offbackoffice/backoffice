<html>
<head>
    <title>LAPORAN-RUBAH STATUS OMI</title>
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
{{--<header>--}}
{{--    <div style="line-height: 0.1px !important;">--}}
{{--        <p>{{$datas->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$datas->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="position: absolute; left: 595px; top: -8px">--}}
{{--        <span>{{$today}} {{$time}}</span>--}}
{{--    </div>--}}
{{--    <div style="line-height: 0.1 !important;">--}}
{{--        <h2 style="text-align: center">LAPORAN PROMOSI REDEEM via UNIQUE CODE</h2>--}}
{{--    </div>--}}
{{--</header>--}}



<div style="line-height: 0.1 !important; width: 380px">
    <p>{{$datas[0]->fkt_noseri}}</p>
    <span style="float: right">{{$p_jmlstruk}}</span>
    <br><br>
    <p>{{$datas[0]->prs_namaperusahaan}}</p>
    <p>{{$datas[0]->alamatpjk1}}</p>
    <p>{{$datas[0]->alamatpjk2}}</p>
    <p>{{$datas[0]->prs_npwp}}</p>
    <br>
    <p>{{$datas[0]->prs_tglsk}}</p>
</div>
<br>
<div style="line-height: 0.1 !important; width: 380px">
    <p>{{$datas[0]->cus_namamember}}</p>
    <p>{{$datas[0]->alamat1}}</p>
    <p>{{$datas[0]->alamat2}}</p>
    <div class="oneline" style="line-height: 0.1 !important; ">
        <p>{{$datas[0]->cus_npwp}}</p>
    </div>
    <div class="oneline" style="line-height: 0.1 !important; ">
        <p>NPPKP : {{$datas[0]->cus_npwp}}</p>
    </div>
</div>
<br><br>
<hr>

<table style="border-collapse: collapse">
    <tbody style="border: 1px solid black">
    @for($i=0;$i<sizeof($datas);$i++)
        <tr>
            <td style="text-align: center">{{$i+1}}</td>
            <td>{{$datas[$i]->prd_deskripsipendek}}</td>
            <td>{{$datas[$i]->qty}}</td>
            <td>{{$datas[$i]->hrgjual}}</td>
        </tr>
    @endfor
    </tbody>
</table>
<span style="float: left">Distribution Fee 2%</span>
<span style="float: right">{{$admfee}}</span>

</body>
</html>

