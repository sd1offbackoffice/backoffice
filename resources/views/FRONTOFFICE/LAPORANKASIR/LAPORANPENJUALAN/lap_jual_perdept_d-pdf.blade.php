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
        margin-top: 10px;
        margin-bottom: 0px;
        font-size: 9px;
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
<?php
$counterDiv = 0;
$headeromikod = '';
$omikod = $datas[0]->omikod;
$divisi = '';
$divisiFooter = $datas[0]->div_namadivisi;

$grossSbu = 0;
$taxSbu = 0;
$netSbu = 0;
$hppSbu = 0;
$marginSbu = 0;
$percentageSbu = 0;
?>
    @for($i=0;$i<sizeof($datas);$i++)
        @if($headeromikod != $datas[$i]->omikod)
            <?php
                $headeromikod = $datas[$i]->omikod;
            ?>
            <header>
                <div style="font-size: 12px ;line-height: 0.1px !important;">
                    <p>{{$datas[0]->prs_namaperusahaan}}</p>
                    <p>{{$datas[0]->prs_namacabang}}</p>
                </div>
                <div style="float: right; margin-top: -38px">
                    <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL : {{$today}} <br> PRG  : IDGP69E</span>
                </div>
                <div style="margin-top: 35px; line-height: 0.1 !important;">
                    <h2 style="text-align: center">LAPORAN PENJUALAN</h2>
                    <h2 style="text-align: center">PER DEPARTEMEN</h2>
                    <h4 style="text-align: center">{{$keterangan}}</h4>
                </div>
            </header>

            <table class="table table-bordered table-responsive" style="border-collapse: collapse;">
                <thead style="border-bottom: 3px solid black; text-align: center">
                <tr>
                    <th colspan="3" style="text-align: left; border-bottom: 2px solid black;">{{$periode}}</th>
                    <th colspan="5" style="text-align: right; border-bottom: 2px solid black">{{$datas[$i]->namasbu}} : {{$datas[$i]->omikod}} {{$datas[$i]->namaomi}}</th>
                </tr>
                <tr style="text-align: center; vertical-align: center">
                    <th colspan="2" style="text-align: left; border-right: 1px solid black; border-bottom: 1px solid black;">DEPARTEMEN</th>
                    <th style="width: 100px;border-right: 1px solid black; border-bottom: 1px solid black">PENJUALAN KOTOR</th>
                    <th style="width: 80px; border-right: 1px solid black; border-left: 1px solid black;">PAJAK</th>
                    <th style="width: 100px; border-right: 1px solid black; border-left: 1px solid black;">PENJUALAN BERSIH</th>
                    <th style="width: 100px;border-right: 1px solid black; border-left: 1px solid black;">H.P.P RATA2</th>
                    <th colspan="2" style="border-left: 1px solid black;">------MARGIN------</th>
                </tr>
                </thead>
                <tbody style="border-bottom: 3px solid black; text-align: right">
        @endif
        <?php
            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;
        ?>

        {{--HEADER--}}
            @if($divisi != $datas[$i]->div_namadivisi)
                <?php
                $divisi = $datas[$i]->div_namadivisi;
                ?>
                <tr>
                    <td colspan="9" style="text-align: left; font-weight: bold;font-size: 15px;">{{$datas[$i]->div_namadivisi}} Division</td>
                </tr>
            @endif
        {{--BODY--}}
            <tr>
                <td style="width: 20px; text-align: left">{{$datas[$i]->omidep}}</td>
                <td style="width: 225px; text-align: left">{{$datas[$i]->dep_namadepartement}}</td>
                <td>{{rupiah($datas[$i]->omiamt)}}</td>
                <td>{{rupiah($datas[$i]->omitax)}}</td>
                <td>{{rupiah($datas[$i]->ominet)}}</td>
                <td>{{rupiah($datas[$i]->omihpp)}}</td>
                <td style="width: 80px">{{rupiah($datas[$i]->omimrg)}}</td>
                <td style="width: 20px">{{$cf_nmargin[$i]}}</td>
            </tr>
            <?php
                $counterDiv++;
            ?>
        @if($i+1 < sizeof($datas))
            @if($divisiFooter != $datas[$i+1]->div_namadivisi)
                <?php
                    $divisiFooter = $datas[$i+1]->div_namadivisi;
                    $grossTotal = 0;
                    $taxTotal = 0;
                    $netTotal = 0;
                    $hppTotal = 0;
                    $marginTotal = 0;
                    $percentageTotal = 0;

                    for($j=$i;$j>($i-$counterDiv);$j--){
                        $grossTotal = $grossTotal + $datas[$j]->omiamt;
                        $taxTotal = $taxTotal + $datas[$j]->omitax;
                        $netTotal = $netTotal + $datas[$j]->ominet;
                        $hppTotal = $hppTotal + $datas[$j]->omihpp;
                        $marginTotal = $marginTotal + $datas[$j]->omimrg;
                    }
                    $grossSbu = $grossSbu + $grossTotal;
                    $taxSbu = $taxSbu + $taxTotal;
                    $netSbu = $netSbu + $netTotal;
                    $hppSbu = $hppSbu + $hppTotal;
                    $marginSbu = $marginSbu + $marginTotal;
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
                    <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{$percentageTotal}}</td>
                </tr>
            @endif
            @if($omikod != $datas[$i+1]->omikod)
                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL PER INDOMARET ({{$datas[$i]->omikod}})</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{round(($marginSbu/$netSbu)*100)}}</td>
                </tr>
                <?php
                $omikod = $datas[$i+1]->omikod;

                $grossSbu = 0;
                $taxSbu = 0;
                $netSbu = 0;
                $hppSbu = 0;
                $marginSbu = 0;
                $percentageSbu = 0;
                ?>
                </tbody>
                </table>
            <div class="page-break">  </div>
            @endif
        @endif
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
                $grossTotal = $grossTotal + $datas[$j]->omiamt;
                $taxTotal = $taxTotal + $datas[$j]->omitax;
                $netTotal = $netTotal + $datas[$j]->ominet;
                $hppTotal = $hppTotal + $datas[$j]->omihpp;
                $marginTotal = $marginTotal + $datas[$j]->omimrg;
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
                <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{$percentageTotal}}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-bottom: 3px solid black; text-align: center">
        <tr style="text-align: center; vertical-align: center">
            <th colspan="2" style="text-align: left; border-right: 1px solid black; border-bottom: 1px solid black;"></th>
            <th style="width: 100px;border-right: 1px solid black; border-bottom: 1px solid black"></th>
            <th style="width: 80px; border-right: 1px solid black; border-left: 1px solid black;"></th>
            <th style="width: 100px; border-right: 1px solid black; border-left: 1px solid black;"></th>
            <th style="width: 100px;border-right: 1px solid black; border-left: 1px solid black;"></th>
            <th colspan="2" style="border-left: 1px solid black;"></th>
        </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: right">
        <tr>
            <td colspan="2" style="width: 300px; text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL SELURUH OMI</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($gross['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($tax['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($net['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hpp['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($margin['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{$marginpersen['o']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL SELURUH INDOMARET</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($gross['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($tax['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($net['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hpp['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($margin['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{$marginpersen['i']}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL SELURUH INDOMARET</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($gross['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($tax['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($net['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hpp['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($margin['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{$marginpersen['total']}}</td>
        </tr>
        </tbody>
    </table>

    <hr>
    <p style="float: right">**Akhir dari Laporan**</p>

</body>
</html>

