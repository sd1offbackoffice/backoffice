<html>
<head>
    <title>LAPORAN-OUTSTANDING SCANNING IDM / OMI</title>
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
        margin-top: 80px;
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
    </div>
    <div style="margin-top: -500px; float: right; line-height: 0.1px !important;">
        <p>{{$today}}</p>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN OUTSTANDING SCANNING IDM / OMI</h2>
        <h4 style="text-align: center">{{$p_tgl}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th style="width: 40px; border-right: 1px solid black; border-bottom: 1px solid black">No.</th>
                <th style="width: 80px; border-right: 1px solid black; border-bottom: 1px solid black">PLU</th>
                <th style="width: 442px;border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Deskripsi</th>
                <th style="width: 100px;border-right: 1px solid black; border-bottom: 1px solid black">Unit/Frac</th>
                <th style="width: 70px;border-bottom: 1px solid black">Qty</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black">
            @for($i=0;$i<sizeof($datas);$i++)
                <tr>
                    <td>{{$datas[$i]->nomor}}</td>
                    <td>{{$datas[$i]->prd_prdcd}}</td>
                    <td>{{$datas[$i]->prd_deskripsipanjang}}</td>
                    <td>{{$datas[$i]->unit}}</td>
                    <td>{{$datas[$i]->qty}}</td>
                </tr>
            @endfor
        </tbody>
    </table>
    <hr>
    <p style="float: right">** Selesai **</p>

</body>

</html>
