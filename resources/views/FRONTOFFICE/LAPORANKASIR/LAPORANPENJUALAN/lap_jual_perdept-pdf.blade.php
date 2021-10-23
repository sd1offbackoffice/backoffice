<html>
<head>
    <title>LAPORAN-PENJUALAN PER DEPARTEMEN</title>
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
        margin-top: 75px;
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
//    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,2,'.',',');
    return $hasil_rupiah;
}
function percent($angka){
    $hasil_rupiah = number_format($angka,2,'.',',');
    return $hasil_rupiah;
}
?>
<header>
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>
            {{ $datas[0]->prs_namaperusahaan }}
        </p>
        <p>
            {{ $datas[0]->prs_namacabang }}
        </p>
    </div>
{{--    <div style="margin-top: -20px; line-height: 0.1px !important;">--}}
{{--        <p>{{$datas[0]->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$datas[0]->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="position: absolute; top: -13px; left: 580px">--}}
{{--        <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL : {{$today}} <br> PRG  : IDGP69E</span>--}}
{{--    </div>--}}
    <div style="float:right; margin-top: 0px;">
        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>
        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>
        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>
    </div>
    <div style="float: center; line-height: 0.1 !important;">
        <h2 style="text-align: center">{{$datas[0]->title}}</h2>
        <h2 style="text-align: center">PER DEPARTEMEN</h2>
        <h4 style="text-align: center">{{$keterangan}}</h4>
        <h4 style="text-align: center">{{$periode}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black; vertical-align: middle">
            <tr>
                <th rowspan="2" colspan="2" style="text-align: left;">DEPARTEMEN</th>
                <th rowspan="2" style="text-align: right; width: 100px;">PENJUALAN KOTOR</th>
                <th rowspan="2" style="text-align: right; width: 80px;">PAJAK</th>
                <th rowspan="2" style="text-align: right; width: 100px;">PENJUALAN BERSIH</th>
                <th rowspan="2" style="text-align: right; width: 100px;">H.P.P RATA2</th>
                <th colspan="2" style="text-align: right;">------MARGIN------</th>
            </tr>
            <tr>
                <td style="width: 80px; text-align: right;">Rp.</td>
                <td style="width: 20px; text-align: right;">%</td>
            </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black; text-align: right">
        <?php
            $counterDiv = 0;
            $divisi = '';

            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;
        ?>
        @for($i=0;$i<sizeof($datas);$i++)
        {{--TOTAL PER DIVISI--}}
            @if($i!=0)
                @if($divisi != $datas[$i]->cdiv)

                    <?php
                    $grossTotal = 0;
                    $taxTotal = 0;
                    $netTotal = 0;
                    $hppTotal = 0;
                    $marginTotal = 0;
                    $percentageTotal = 0;

                    for($j=$i-1;$j>($i-$counterDiv-1);$j--){
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
                            $percentageTotal = "0.00";
                        }
                    }
                    $percentageTotal = round($percentageTotal, 2);
                    $counterDiv = 0;
                    ?>

                    <tr>
                        <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{percent($percentageTotal)}}</td>
                    </tr>
                @endif
            @endif
        {{--HEADER--}}
            @if($divisi != $datas[$i]->cdiv)
                <?php
                $divisi = $datas[$i]->cdiv;
                ?>
                <tr>
                    <td colspan="9" style="text-align: left; font-weight: bold;font-size: 15px;">{{$datas[$i]->div_namadivisi}} Division</td>
                </tr>
            @endif
        {{--BODY--}}
            <tr>
                <td style="width: 20px; text-align: left">{{$datas[$i]->cdept}}</td>
                <td style="width: 225px; text-align: left">{{$datas[$i]->dep_namadepartement}}</td>
                <td>{{rupiah($datas[$i]->ngross)}}</td>
                <td>{{rupiah($datas[$i]->ntax)}}</td>
                <td>{{rupiah($datas[$i]->nnet)}}</td>
                <td>{{rupiah($datas[$i]->nhpp)}}</td>
                <td>{{rupiah($datas[$i]->nmargin)}}</td>
                <td>{{percent($cf_nmargin[$i])}}</td>
            </tr>
            <?php
                $counterDiv++;
            ?>
        @endfor
        <!--Menampilkan Data setelah keluar dari loop-->
            <?php
            //DIVISI
            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;

            for($j=sizeof($datas)-1;$j>(sizeof($datas)-$counterDiv)-1;$j--){
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
                    $percentageTotal = "0.00";
                }
            }
            $percentageTotal = round($percentageTotal, 2);
            $counterDiv = 0;
            ?>

            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{percent($percentageTotal)}}</td>
            </tr>

            {{--GRAND TOTAL--}}
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL COUNTER</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['c'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['c'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">&nbsp;&nbsp;TOTAL BARANG KENA PAJAK</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['p'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['p'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL BARANG TIDAK KENA PAJAK</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['x'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['x'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL BARANG KENA CUKAI</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['k'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['k'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL BARANG BEBAS PPN</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['b'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['b'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL BARANG EXPORT</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['e'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['e'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: normal;font-size: 10px;">TOTAL BRG PPN DIBYR PMERINTH (MINYAK)</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['g'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['g'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: normal;font-size: 10px;">TOTAL BRG PPN DIBYR PMERINTH (TEPUNG)</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['r'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['r'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">TOTAL DEPARTEMEN 43</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['f'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['f'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">GRAND TOTAL (TANPA DEPT 40)</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['total']-$gross['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['total']-$tax['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['total']-$net['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['total']-$hpp['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['total']-$margin['d'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['tminp'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;font-size: 10px;">GRAND TOTAL (+ DEPT 40)</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($gross['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($tax['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($net['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($hpp['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{rupiah($margin['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px;">{{percent($marginpersen['total'])}}</td>
        </tr>
        </tbody>
    </table>
    <p style="float: right">**Akhir dari Laporan**</p>

</body>
</html>

