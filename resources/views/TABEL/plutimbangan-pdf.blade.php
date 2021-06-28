<html>
<head>
    <title>LAPORAN-TRANSFER SATUAN PRODUK HOT BEVERAGES</title>
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
    <div style="position: absolute; left: 580px; top: -17; line-height: 0.1px !important;">
        <p>TGL : {{$today}} JAM : {{$time}}</p><br>
        <span>PGM : TAB025</span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">TABEL P.L.U. TIMBANGAN</h2>
        <h3 style="text-align: center">Periode : </h3>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse; text-align: center">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th style="width: 80px; border: 1px solid black">PLU</th>
                <th style="width: 300px; border: 1px solid black">Deskripsi Timbangan</th>
                <th style="width: 80px; border: 1px solid black">UNIT/FRAC</th>
                <th style="width: 80px; border: 1px solid black">TAG</th>
                <th style="width: 80px; border: 1px solid black">HARGA JUAL</th>
                <th style="width: 100px; border: 1px solid black">KODE TIMBANGAN</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: center">
        @for($i=0;$i<sizeof($datas);$i++)
            <tr>
                <td>{{$datas[$i]->plu}}</td>
                <td>{{$datas[$i]->prd_desc}}</td>
                <td>{{$datas[$i]->prd_satuan}}</td>
                <td>{{$datas[$i]->prd_kodetag}}</td>
                <td>{{$datas[$i]->hrg_jual}}</td>
                <td>{{$datas[$i]->tmb_kode}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
</body>

</html>
