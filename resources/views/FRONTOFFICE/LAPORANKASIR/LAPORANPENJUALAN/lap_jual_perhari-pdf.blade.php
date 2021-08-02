<html>
<head>
    <title>LAPORAN-PENJUALAN PER HARI</title>
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
        font-size: 11px;
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
//rupiah formatter (no Rp or .00)
function rupiah($angka){
    //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,0,'.',',');
    return $hasil_rupiah;
}
?>
<header>
    <div style="margin-top: -20px; line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
    </div>
    <div style="position: absolute; top: -20px; left: 550px">
        <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL : {{$today}} <br> PRG  : IDGP69D</span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN PENJUALAN</h2>
        <h2 style="text-align: center">PER HARI</h2>
        <h4 style="text-align: center">{{$periode}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th style="width: 80px; border-right: 1px solid black; border-bottom: 1px solid black;">TANGGAL</th>
                <th style="width: 70px; text-align: left; border-right: 1px solid black; border-bottom: 1px solid black">HARI</th>
                <th style="width: 120px; border-right: 1px solid black; border-left: 1px solid black;">PENJUALAN KOTOR</th>
                <th style="width: 100px; border-right: 1px solid black; border-left: 1px solid black;">PAJAK</th>
                <th style="width: 120px; border-right: 1px solid black; border-left: 1px solid black;">PENJUALAN BERSIH</th>
                <th style="width: 100px; border-right: 1px solid black; border-left: 1px solid black;">H.P.P RATA2</th>
                <th style="width: 100px; border-left: 1px solid black;">---MARGIN---</th>
                <th style="width: 40px;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: right">
        @for($i=0;$i<sizeof($datas);$i++)
            <?php
            $date = ($datas[$i]->sls_periode);
            $createDate = new DateTime($date);
            $strip = $createDate->format('d-m-Y');
            ?>
            <tr>
                <td style="text-align: center">{{$strip}}</td>
                <td style="text-align: left">{{$datas[$i]->hari}}</td>
                <td>{{rupiah($datas[$i]->sls_nilai)}}</td>
                <td>{{rupiah($datas[$i]->sls_tax)}}</td>
                <td>{{rupiah($datas[$i]->sls_net)}}</td>
                <td>{{rupiah($datas[$i]->sls_hpp)}}</td>
                <td>{{rupiah($datas[$i]->sls_margin)}}</td>
                <td>{{round(($datas[$i]->p_margin), 2)}}</td>
            </tr>
        @endfor
        <tr style="font-weight: bold">
            <td colspan="2" style="text-align: center; border-top: 1px black solid">GRAND TOTAL</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['gross'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['tax'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['net'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['hpp'])}}</td>
            <td style="border-top: 1px solid black;">{{rupiah($val['margin'])}}</td>
            <td style="border-top: 1px solid black;">{{round(($val['margp']), 2)}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p style="float: right">**Akhir dari Laporan**</p>

</body>
</html>

