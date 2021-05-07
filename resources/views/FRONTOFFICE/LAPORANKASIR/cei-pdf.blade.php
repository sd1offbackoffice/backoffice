<html>
<head>
    <title>LAPORAN-CASH BACK / SUPPLIER / ITEM</title>
</head>
<script src={{asset('/js/sweetalert2.js')}}></script>
<script src={{asset('/js/jquery.js')}}></script>
<script src="{{asset('/js/jquery-ui.js')}}"></script>
<script>
    $(document).ready(function() {
        swal.fire('', "Tekan Ctrl+P untuk print !!", 'warning');
    });
</script>
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
        position: absolute;
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
    <div style="line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="float: right; margin-top: -22px; line-height: 0.1px !important;">
        <p>TGL : {{$today}} &nbsp; PRG : LSTCSB</p>
        <p>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>

    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">** LAPORAN CASH BACK PER EVENT PROMOSI PER ITEM **</h2>
        <h4 style="text-align: center">Tanggal: {{$date1}} s/d {{$date2}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="2" style="width: 80px; border-right: 1px solid black; border-bottom: 1px solid black">Kd PLU</th>
                <th rowspan="2" style="width: 300px; border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Deskripsi</th>
                <th rowspan="2" style="width: 80px; border-right: 1px solid black; border-bottom: 1px solid black">Supplier</th>
                <th rowspan="2" style="width: 300px; border-right: 1px solid black;border-bottom: 1px solid black; text-align: left">Nama Supplier</th>
                <th colspan="2" style="border-right: 1px solid black;border-bottom: 1px solid black">Sales</th>
                <th colspan="2" style="border-bottom: 1px solid black">Refund</th>
            </tr>
            <tr>
                <th style="width: 80px; border-right: 1px solid black;">Qty</th>
                <th style="width: 100px; border-right: 1px solid black;">Nilai</th>
                <th style="width: 80px; border-right: 1px solid black;">Qty</th>
                <th style="width: 100px">Nilai</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: center; vertical-align: center">
        <?php
            $kode = '';
            $cDeskripsi = '';
            $nilaiSales = 0;
            $nilaiRefund = 0;
            $totalSales = 0;
            $totalRefund = 0;
        ?>
        @for($i=0;$i<sizeof($datas);$i++)
            @if($kode != $datas[$i]->cbh_kodepromosi)
                @if($i != 0)
                    <tr>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td style="text-align: right">Total Per Event</td>
                        <td colspan="2">{{$nilaiSales}}</td>
                        <td colspan="2">{{$nilaiRefund}}</td>
                    </tr>
                @endif
                <tr>
                    <td>{{$datas[$i]->cbh_kodepromosi}}</td>
                    <td>{{$datas[$i]->cbh_kodeperjanjian}}</td>
                    <td> </td>
                    <td style="text-align: left"> {{$datas[$i]->cbh_namapromosi}}</td>
                    <td colspan="4">({{$datas[$i]->cbh_tglawal}} S/D {{$datas[$i]->cbh_tglakhir}})</td>
                </tr>
                <?php
                $kode = $datas[$i]->cbh_kodepromosi;
                $totalSales = $totalSales + $nilaiSales;
                $totalRefund = $totalRefund + $nilaiRefund;
                $nilaiSales = 0;
                $nilaiRefund = 0;
                ?>
            @endif
            @if($datas[$i]->prd_deskripsipanjang == null || $datas[$i]->prd_deskripsipanjang == '')
                <?php
                    $cDeskripsi = 'CASHBACK GABUNGAN';
                ?>
            @else
                <?php
                $cDeskripsi = $datas[$i]->prd_deskripsipanjang;
                ?>
            @endif
            <tr>
                <td>{{$datas[$i]->plu}}</td>
                <td style="text-align: left">{{$cDeskripsi}}</td>
                <td>{{$datas[$i]->sup_kodesupplier}}</td>
                <td style="text-align: left">{{$datas[$i]->sup_namasupplier}}</td>
                <td style="text-align: right">{{$datas[$i]->qtysls}}</td>
                <td style="text-align: right">{{$datas[$i]->nilsls}}</td>
                <td style="text-align: right">{{$datas[$i]->qtyref}}</td>
                <td style="text-align: right">{{$datas[$i]->nilref}}</td>
            </tr>
            <?php
            $nilaiSales = $nilaiSales + ($datas[$i]->nilsls);
            $nilaiRefund = $nilaiRefund + ($datas[$i]->nilref);
            ?>
        @endfor
        <tr>
            <td> </td>
            <td> </td>
            <td> </td>
            <td style="text-align: right">Total Per Event</td>
            <td colspan="2">{{$nilaiSales}}</td>
            <td colspan="2">{{$nilaiRefund}}</td>
        </tr>
        <?php
        $totalSales = $totalSales + $nilaiSales;
        $totalRefund = $totalRefund + $nilaiRefund;
        ?>
        <tr>
            <td> </td>
            <td> </td>
            <td> </td>
            <td style="text-align: right">Grand Total</td>
            <td colspan="2">{{$totalSales}}</td>
            <td colspan="2">{{$totalRefund}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p style="float: right; line-height: 0.1px !important;">** AKHIR LAPORAN **</p>

</body>

</html>
