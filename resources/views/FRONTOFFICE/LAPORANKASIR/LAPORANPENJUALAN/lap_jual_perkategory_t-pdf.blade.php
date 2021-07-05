<html>
<head>
    <title>LAPORAN-PENJUALAN PER KATEGORY</title>
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
    <div style="position: absolute; top: -13px; left: 580px">
        <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL : {{$today}} <br> PRG  : IDGP69B</span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN PENJUALAN</h2>
        <h2 style="text-align: center">PER KATEGORY</h2>
        <h4 style="text-align: center">{{$date1}} s/d {{$date2}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th colspan="2" style="border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">KATEGORI</th>
                <th style="width: 65px; border-right: 1px solid black; border-bottom: 1px solid black;">QTY</th>
                <th style="width: 100px;border-right: 1px solid black; border-bottom: 1px solid black">PENJUALAN KOTOR</th>
                <th style="width: 80px; border-right: 1px solid black; border-left: 1px solid black;">PAJAK</th>
                <th style="width: 100px; border-right: 1px solid black; border-left: 1px solid black;">PENJUALAN BERSIH</th>
                <th style="width: 100px;border-right: 1px solid black; border-left: 1px solid black;">H.P.P RATA2</th>
                <th colspan="2" style="border-left: 1px solid black;">------MARGIN------</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: right">
        <?php
            $counterDiv = 0;
            $counterDept = 0;

            $divisi = '';
            $departemen = '';

            $qtyTotal = 0;
            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;
        ?>
        @for($i=0;$i<sizeof($datas);$i++)
        {{--TOTAL PER DEPARTEMEN DAN PER DIVISI--}}
            @if($i!=0)
                @if($departemen != $datas[$i]->fdkdep)

                    <?php
                    $qtyTotal = 0;
                    $grossTotal = 0;
                    $taxTotal = 0;
                    $netTotal = 0;
                    $hppTotal = 0;
                    $marginTotal = 0;
                    $percentageTotal = 0;

                    for($j=$i-1;$j>($i-$counterDept-1);$j--){
                        $qtyTotal = $qtyTotal + $datas[$j]->ktqty;
                        $grossTotal = $grossTotal + $datas[$j]->ngross;
                        $taxTotal = $taxTotal + $datas[$j]->ntax;
                        $netTotal = $netTotal + $datas[$j]->nnet;
                        $hppTotal = $hppTotal + $datas[$j]->nhpp;
                        $marginTotal = $marginTotal + $datas[$j]->nmargin;
                    }
                    if($netTotal != 0){
                        $percentageTotal = $marginTotal*100/$netTotal;
                    }else{
                        if($marginTotal != 0){
                            $percentageTotal = 100;
                        }else{
                            $percentageTotal = 0;
                        }
                    }
                    $percentageTotal = round($percentageTotal, 2);
                    $counterDept = 0;
                    ?>

                    <tr>
                        <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px;">TOTAL PER DEPARTEMEN</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtyTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($grossTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($taxTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($netTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hppTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($marginTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$percentageTotal}}</td>
                    </tr>
                @endif

                @if($divisi != $datas[$i]->fdkdiv)

                    <?php
                    $qtyTotal = 0;
                    $grossTotal = 0;
                    $taxTotal = 0;
                    $netTotal = 0;
                    $hppTotal = 0;
                    $marginTotal = 0;
                    $percentageTotal = 0;

                    for($j=$i-1;$j>($i-$counterDiv-1);$j--){
                        $qtyTotal = $qtyTotal + $datas[$j]->ktqty;
                        $grossTotal = $grossTotal + $datas[$j]->ngross;
                        $taxTotal = $taxTotal + $datas[$j]->ntax;
                        $netTotal = $netTotal + $datas[$j]->nnet;
                        $hppTotal = $hppTotal + $datas[$j]->nhpp;
                        $marginTotal = $marginTotal + $datas[$j]->nmargin;
                    }
                    if($netTotal != 0){
                        $percentageTotal = $marginTotal*100/$netTotal;
                    }else{
                        if($marginTotal != 0){
                            $percentageTotal = 100;
                        }else{
                            $percentageTotal = 0;
                        }
                    }
                    $percentageTotal = round($percentageTotal, 2);
                    $counterDiv = 0;
                    ?>

                    <tr>
                        <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px;">TOTAL PER DIVISI</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtyTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($grossTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($taxTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($netTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hppTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($marginTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$percentageTotal}}</td>
                    </tr>
                @endif
            @endif
        {{--HEADER--}}
            @if($divisi != $datas[$i]->fdkdiv)
                <?php
                $divisi = $datas[$i]->fdkdiv;
                ?>
                <tr>
                    <td colspan="9" style="text-align: left; font-weight: bold;font-size: 15px;">** DIVISI {{$datas[$i]->fdkdiv}} - {{$datas[$i]->div_namadivisi}}</td>
                </tr>
            @endif

            @if($departemen != $datas[$i]->fdkdep)
                <?php
                $departemen = $datas[$i]->fdkdep;
                ?>
                <tr>
                    <td colspan="9" style="text-align: left; font-weight: bold;font-size: 11px;">&nbsp;&nbsp;*DEPARTEMEN {{$datas[$i]->fdkdep}} - {{$datas[$i]->dep_namadepartement}}</td>
                </tr>
            @endif
            <tr>
                <td style="width: 20px; text-align: left">{{$datas[$i]->fdkatb}}</td>
                <td style="width: 160px; text-align: left">{{$datas[$i]->kat_namakategori}}</td>
                <td>{{rupiah($datas[$i]->ktqty)}}</td>
                <td>{{rupiah($datas[$i]->ngross)}}</td>
                <td>{{rupiah($datas[$i]->ntax)}}</td>
                <td>{{rupiah($datas[$i]->nnet)}}</td>
                <td>{{rupiah($datas[$i]->nhpp)}}</td>
                <td style="width: 80px">{{rupiah($datas[$i]->nmargin)}}</td>
                <td style="width: 20px">{{$cf_nmargin[$i]}}</td>
            </tr>
            <?php
                $counterDiv++;
                $counterDept++;
            ?>
    <!--UNTUK DATA SEBELUM KELUAR DARI LOOP-->
        @if(($i+1) == sizeof($datas))
                <?php
                //DEPARTEMEN
                $qtyTotal = 0;
                $grossTotal = 0;
                $taxTotal = 0;
                $netTotal = 0;
                $hppTotal = 0;
                $marginTotal = 0;
                $percentageTotal = 0;

                for($j=$i;$j>($i-$counterDept);$j--){
                    $qtyTotal = $qtyTotal + $datas[$j]->ktqty;
                    $grossTotal = $grossTotal + $datas[$j]->ngross;
                    $taxTotal = $taxTotal + $datas[$j]->ntax;
                    $netTotal = $netTotal + $datas[$j]->nnet;
                    $hppTotal = $hppTotal + $datas[$j]->nhpp;
                    $marginTotal = $marginTotal + $datas[$j]->nmargin;
                }
                if($netTotal != 0){
                    $percentageTotal = $marginTotal*100/$netTotal;
                }else{
                    if($marginTotal != 0){
                        $percentageTotal = 100;
                    }else{
                        $percentageTotal = 0;
                    }
                }
                $percentageTotal = round($percentageTotal, 2);
                $counterDept = 0;
                ?>

                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px;">TOTAL PER DEPARTEMEN</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtyTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($grossTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($taxTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($netTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hppTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($marginTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$percentageTotal}}</td>
                </tr>

                <?php
                //DIVISI
                $qtyTotal = 0;
                $grossTotal = 0;
                $taxTotal = 0;
                $netTotal = 0;
                $hppTotal = 0;
                $marginTotal = 0;
                $percentageTotal = 0;

                for($j=$i;$j>($i-$counterDiv);$j--){
                    $qtyTotal = $qtyTotal + $datas[$j]->ktqty;
                    $grossTotal = $grossTotal + $datas[$j]->ngross;
                    $taxTotal = $taxTotal + $datas[$j]->ntax;
                    $netTotal = $netTotal + $datas[$j]->nnet;
                    $hppTotal = $hppTotal + $datas[$j]->nhpp;
                    $marginTotal = $marginTotal + $datas[$j]->nmargin;
                }
                if($netTotal != 0){
                    $percentageTotal = $marginTotal*100/$netTotal;
                }else{
                    if($marginTotal != 0){
                        $percentageTotal = 100;
                    }else{
                        $percentageTotal = 0;
                    }
                }
                $percentageTotal = round($percentageTotal, 2);
                $counterDiv = 0;
                ?>

                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px;">TOTAL PER DIVISI</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtyTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($grossTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($taxTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($netTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hppTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($marginTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$percentageTotal}}</td>
                </tr>

        {{--GRAND TOTAL--}}
        @endif
        @endfor
        </tbody>
    </table>
    <hr>
    <p style="float: right">**Akhir dari Laporan**</p>

</body>
</html>

