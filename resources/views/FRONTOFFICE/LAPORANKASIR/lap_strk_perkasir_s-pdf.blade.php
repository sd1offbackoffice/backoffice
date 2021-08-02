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
        /*margin-top: 120px;*/
        margin-bottom: 10px;
        font-size: 11px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        /*position: fixed;*/
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
        margin-bottom: 20px;
    }
    table{
        border: 1px;
    }
    .page-break {
        page-break-after: always;
    }
    .page-numbers:after { content: counter(page); }
</style>
<script src={{asset('/js/jquery.js')}}></script>
<script src={{asset('/js/sweetalert.js')}}></script>
<script>
    $(document).ready(function() {
        swal('Information', 'Tekan Ctrl+P untuk print!', 'info');
    });
</script>
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
    <div style="float: right; margin-top: -35px">
        <span>TGL : {{$today}}<br>JAM : {{$time}}</span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">** REKAP STRUK PER / KASIR **</h2>
        <h2 style="text-align: center">Transaksi : Sales</h2>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th style="width: 8%; border-right: 1px solid black; border-bottom: 1px solid black;">TANGGAL</th>
                <th style="width: 5%; border-right: 1px solid black; border-bottom: 1px solid black;">STT</th>
                <th style="width: 30%; border-right: 1px solid black; border-bottom: 1px solid black;">-----KASIR-----</th>
                <th style="width: 12%; border-bottom: 1px solid black;">STRUK</th>
                <th style="width: 12%; border-right: 1px solid black; border-bottom: 1px solid black;">TOTAL</th>
                <th style="width: 12%; border-bottom: 1px solid black;">STRUK</th>
                <th style="width: 12%; border-right: 1px solid black; border-bottom: 1px solid black;">TOTAL</th>
                <th style="width: 12%; border-bottom: 1px solid black;">STRUK</th>
                <th style="width: 12%; border-bottom: 1px solid black;">TOTAL</th>
            </tr>
        </thead>
        <?php
        $theDate = '';
        $cashier = '';
        $countKasir = 0;
        $countTotal = 0;
        ?>
        <tbody style="border-bottom: 3px solid black; text-align: right">
        @for($i=0;$i<sizeof($datas);$i = $i + 3)
            <?php
            $createDate = new DateTime($datas[$i]->jh_transactiondate);
            $strip = $createDate->format('d-m-Y');
            ?>
            @if($i!=0 && $cashier != $datas[$i]->jh_cashier)
                <tr style="font-weight: bold">
                    <td style="border-bottom: 1px solid black" colspan="5">Total Per Kasir : </td>
                    <td style="border-bottom: 1px solid black" colspan="4">{{rupiah($countKasir)}}</td>
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
                @if($cashier != $datas[$i]->jh_cashier)
                    <?php
                    $countKasir = 0;
                    $cashier = $datas[$i]->jh_cashier
                    ?>
                        <td style="text-align: center">{{$datas[$i]->jh_cashierstation}}</td>
                        <td style="text-align: left">{{$cashier}}</td>
                @else
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td style="text-align: center">{{$datas[$i]->jh_transactionno}}</td>
                <td>{{rupiah($datas[$i]->jh_transactionamt)}}</td>
                    <?php
                    $countKasir = $countKasir + ($datas[$i]->jh_transactionamt);
                    $countTotal = $countTotal + ($datas[$i]->jh_transactionamt);
                    ?>
                @if($i+1 < sizeof($datas))
                    @if($cashier == $datas[$i+1]->jh_cashier)
                        <td style="text-align: center">{{$datas[$i+1]->jh_transactionno}}</td>
                        <td>{{rupiah($datas[$i+1]->jh_transactionamt)}}</td>
                        <?php
                        $countKasir = $countKasir + ($datas[$i+1]->jh_transactionamt);
                        $countTotal = $countTotal + ($datas[$i+1]->jh_transactionamt);
                        ?>
                    @else
                        <?php $i--;//$i dikurangi 1,?>
                        <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    @endif
                @endif
                @if($i+2 < sizeof($datas))
                    @if($cashier == $datas[$i+2]->jh_cashier)
                        <td style="text-align: center">{{$datas[$i+2]->jh_transactionno}}</td>
                        <td>{{rupiah($datas[$i+2]->jh_transactionamt)}}</td>
                        <?php
                        $countKasir = $countKasir + ($datas[$i+2]->jh_transactionamt);
                        $countTotal = $countTotal + ($datas[$i+2]->jh_transactionamt);
                        ?>
                    @else
                        <?php $i--; //karena $i sudah dikurangi 1 sebelumnya maka, $i+2 akan terasa menjadi $i+1, $i+1 != data tidak ada, maka $i+2 juga tidak ada data?>
                        <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    @endif
                @endif
            </tr>

        @endfor
        <tr style="font-weight: bold">
            <td style="border-bottom: 1px solid black" colspan="5">Total Per Kasir : </td>
            <td style="border-bottom: 1px solid black" colspan="4">{{rupiah($countKasir)}}</td>
        </tr>
        <tr style="font-weight: bold">
            <td style="border-bottom: 1px solid black" colspan="5">Total Per Seluruhnya : </td>
            <td style="border-bottom: 1px solid black" colspan="4">{{rupiah($countTotal)}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p style="float: left">Khusus Member OMI Nilai Total Rupiah Telah Termasuk Distribution Fee ...</p>
    <p style="float: right">**Akhir dari Laporan**</p>

</body>
</html>

