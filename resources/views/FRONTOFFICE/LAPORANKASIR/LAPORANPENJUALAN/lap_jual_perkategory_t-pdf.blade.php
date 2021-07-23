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
        <h4 style="text-align: center">{{$periode}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                @if($qty == 'Y')
                    <th colspan="2" style="border-right: 1px solid black; text-align: left">KATEGORI</th>
                    <th style="width: 67px; border-right: 1px solid black;">QTY</th>
                @else
                    <th colspan="2" style="text-align: left">KATEGORI</th>
                    <th style="width: 67px; border-right: 1px solid black;">&nbsp;&nbsp;</th>
                @endif
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
                        @if($qty == 'Y')
                            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtyTotal)}}</td>
                        @else
                            <td> </td>
                        @endif
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
                        @if($qty == 'Y')
                            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtyTotal)}}</td>
                        @else
                            <td> </td>
                        @endif
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
        {{--BODY--}}
            <tr>
                <td style="width: 20px; text-align: left">{{$datas[$i]->fdkatb}}</td>
                <td style="width: 158px; text-align: left">{{$datas[$i]->kat_namakategori}}</td>
                @if($qty == 'Y')
                    <td>{{rupiah($datas[$i]->ktqty)}}</td>
                @else
                    <td> </td>
                @endif
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
        @endfor
        <!--Menampilkan Data setelah keluar dari loop-->
            <?php
            //DEPARTEMEN
            $qtyTotal = 0;
            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;

            for($j=sizeof($datas)-1;$j>(sizeof($datas)-$counterDept)-1;$j--){
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
                @if($qty == 'Y')
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtyTotal)}}</td>
                @else
                    <td> </td>
                @endif
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

            for($j=sizeof($datas)-1;$j>(sizeof($datas)-$counterDiv)-1;$j--){
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
                @if($qty == 'Y')
                    <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtyTotal)}}</td>
                @else
                    <td> </td>
                @endif
                <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($taxTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($netTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hppTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($marginTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$percentageTotal}}</td>
            </tr>

            {{--GRAND TOTAL--}}
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL COUNTER</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['c']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">&nbsp;&nbsp;TOTAL BARANG KENA PAJAK</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['p']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL BARANG TIDAK KENA PAJAK</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['x']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL BARANG KENA CUKAI</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['k']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL BARANG BEBAS PPN</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['b']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL BARANG EXPORT</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['e']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: normal;font-size: 10px;">TOTAL BRG PPN</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">(MINYAK)</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['g']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: normal;font-size: 10px;">DIBYR PMRINTH</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">(TEPUNG)</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['r']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL DEPARTEMEN 43</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['f']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">GRAND TOTAL (TANPA DEPT 40)</td>
            @if($qty == 'Y')
                <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtygrandtotal-1)}}</td>
            @else
                <td> </td>
            @endif
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['total']-$gross['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['total']-$tax['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['total']-$net['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['total']-$hpp['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['total']-$margin['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['total']-$marginpersen['d']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">GRAND TOTAL (+ DEPT 40)</td>
            @if($qty == 'Y')
                <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($qtygrandtotal)}}</td>
            @else
                <td> </td>
            @endif
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{$marginpersen['total']}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p style="float: right">**Akhir dari Laporan**</p>

</body>
</html>

