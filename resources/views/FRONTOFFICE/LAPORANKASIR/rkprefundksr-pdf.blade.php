<html>
<head>
    <title>LAPORAN-REKAP STRUK PER / KASIR</title>
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
    <div style="line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="position: absolute; left: 545px; top: -8px">
        <span>TGL : {{$today}}&nbsp;&nbsp;&nbsp;&nbsp;PRG : LAP324<br>JAM : {{$time}}</span>
    </div>
    <div style="line-height: 0.1 !important;">
        <h2 style="text-align: center">** REKAP STRUK REFUND KASIR **</h2>
        <h2 style="text-align: center">Tanggal : {{$date1}} s/d {{$date2}}</h2>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th style="width: 110px; border-right: 1px solid black;">Tgl. Refund</th>
                <th style="width: 50px;">Kasir</th>
                <th style="width: 210px; border-right: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="width: 100px; border-right: 1px solid black;">No. TRN</th>
                <th style="width: 110px; border-right: 1px solid black;">Tgl. Transaksi</th>
                <th style="width: 150px; border-bottom: 1px solid black;">Nilai</th>
            </tr>
        </thead>
        <?php
        $theDate = '';
        $cashier = '';
        $countKasir = 0;
        $countTotal = 0;
        ?>
        <tbody style="border-bottom: 3px solid black;">
        @for($i=0;$i<sizeof($datas);$i++)
            <?php
            $createDate = new DateTime($val['tgl_refund'][$i]);
            $strip = $createDate->format('d-m-Y');
            $createDate = new DateTime($val['tgl_trn'][$i]);
            $strip2 = $createDate->format('d-m-Y');
            ?>
            @if($i!=0 && $cashier != $val['cashierid'][$i])
                <tr style="font-weight: bold">
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left;" colspan="4">Total Kasir : </td>
                    <td style="text-align: right; border-top: 1px solid black;">{{rupiah($countKasir)}}</td>
                </tr>
            @endif
            <tr>
                @if($theDate != $strip)
                    <?php
                    $theDate = $strip
                    ?>
                        <td style="text-align: center">{{$strip}}</td>
                @else
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                @if($cashier != $val['cashierid'][$i])
                    <?php
                    $countKasir = 0;
                    $cashier = $val['cashierid'][$i];
                    ?>
                        <td style="text-align: right">{{$cashier}}</td>
                        <td style="text-align: left">- {{$val['cashiername'][$i]}}</td>
                @else
                    <td style="text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td style="text-align: center">{{$val['no_trn'][$i]}}</td>
                <td style="text-align: center">{{$strip2}}</td>
                <td style="text-align: right">{{rupiah($val['nilai'][$i])}}</td>
                <?php
                $countKasir = $countKasir + ($val['nilai'][$i]);
                $countTotal = $countTotal + ($val['nilai'][$i]);
                ?>
            </tr>

        @endfor
        <tr style="font-weight: bold">
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="text-align: left;" colspan="4">Total Kasir : </td>
            <td style="border-top: 1px solid black; text-align: right">{{rupiah($countKasir)}}</td>
        </tr>
        <tr style="font-weight: bold">
            <td style="border-top: 2px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="border-top: 2px solid black; text-align: left;" colspan="4">Total Seluruhnya : </td>
            <td style="border-top: 2px solid black; text-align: right">{{rupiah($countTotal)}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p style="float: right">**Akhir dari Laporan**</p>

</body>
</html>

