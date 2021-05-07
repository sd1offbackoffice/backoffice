<html>
<head>
    <title>LAPORAN-STOCK OUT berdasarkan KPH Mean</title>
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
        margin-top: 70px;
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
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="margin-top: -500px; float: right; line-height: 0.1px !important;">
        <p>{{$today}}</p>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN STOCK OUT berdasarkan KPH Mean</h2>
    </div>
</header>
    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th style="width: 40px; border-right: 1px solid black; border-bottom: 1px solid black">No.</th>
                <th style="width: 80px; border-right: 1px solid black; border-bottom: 1px solid black">PLU IDM</th>
                <th style="width: 80px; border-right: 1px solid black; border-bottom: 1px solid black">PLU IGR</th>
                <th style="width: 280px;border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Deskripsi</th>
                <th style="width: 90px;border-right: 1px solid black; border-bottom: 1px solid black">Qty Stock</th>
                <th style="width: 90px;border-right: 1px solid black; border-bottom: 1px solid black">Qty KPH MEAN</th>
                <th style="width: 70px;border-bottom: 1px solid black">PKMT</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black">
        <?php
            $temp = '';
            $divdeptkat = '';
        ?>
        @for($i=0;$i<sizeof($datas);$i++)
            @if($temp != $datas[$i]->divdeptkat)
                <tr>
                    <td colspan="7" style="border-bottom: 2px solid black; border-top: 2px solid black">{{$datas[$i]->divdeptkat}}</td>
                </tr>
                <?php
                 $temp = $datas[$i]->divdeptkat;
                ?>
            @endif
            <tr>
                <td>{{$i+1}}</td>
                <td>{{$datas[$i]->prc_pluidm}}</td>
                <td>{{$datas[$i]->prd_prdcd}}</td>
                <td>{{$datas[$i]->prd_deskripsipanjang}}</td>
                <td>{{$datas[$i]->st_saldoakhir}}</td>
                <td>{{$datas[$i]->ksl_mean}}</td>
                <td>{{$datas[$i]->pkm_pkmt}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
    <hr>
    <p style="float: left;line-height: 0.1px !important;"> Jumlah Item : {{sizeof($datas)}}</p>
    <p style="float: right; margin-top: -5px;line-height: 0.1px !important;">** Akhir Laporan **</p><br>
    <p style="float: right; margin-top: -5px;line-height: 0.1px !important;">Note : Nilai KSL Mean Sudah Dikali 3</p>
</body>

</html>
