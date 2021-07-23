{{--NOTE :
Perubahan kulakukan untuk menyamakan dengan hasil laporan sesuai dengan yang kulihat, ku tidak tahu kenapa kenapa harus ada kondisi ini, tapi hasil laporannya begitu, ya begimana lagi
1. data perdivisi hanya menampilkan data dimana "omisbu == 'I'", kalau ingin menampilkan semua hapus semua kondisi dimana "omisbu == 'I'", harusnya ada 3
2. {{$datas[$i]->namasbu}} : {{$datas[$i]->omidiv}} {{$namaomi}} tidak ditampilkan
--}}

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
        margin-top: 100px;
        margin-bottom: 0px;
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
    <div style="margin-top: -20px;font-size: 12px ;line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
    </div>
    <div style="position: absolute; left: 590px; top: -17px">
        <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL : {{$today}} <br> PRG  : IDGP69E</span>
    </div>
    <div style="margin-top: 15px; line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN PENJUALAN</h2>
        <h2 style="text-align: center">PER DEPARTEMEN</h2>
    </div>
    <div style="margin-top: -30px; line-height: 0.1 !important;">
        <h4 style="text-align: left">{{$periode}}</h4>
        <h4 style="text-align: center; margin-top: -21px">{{$keterangan}}</h4>
{{--        <h4 style="text-align: right; margin-top: -42px">{{$datas[$i]->namasbu}} : {{$datas[$i]->omidiv}} {{$namaomi}}</h4>--}}
    </div>
</header>
<?php
$counterDiv = 0;
$omidiv = $datas[0]->omidiv;
$divisi = '';
$divisiFooter = $datas[0]->div_namadivisi;

?>
<table class="table table-bordered table-responsive" style="border-collapse: collapse;">
    <thead style="border-bottom: 3px solid black; text-align: center">
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
    @for($i=0;$i<sizeof($datas);$i++)
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
        @if($datas[$i]->omisbu == 'I')
            <tr>
                <td style="width: 20px; text-align: left">{{$datas[$i]->omidep}}</td>
                <td style="width: 215px; text-align: left">{{$datas[$i]->dep_namadepartement}}</td>
                <td>{{rupiah($datas[$i]->omiamt)}}</td>
                <td>{{rupiah($datas[$i]->omitax)}}</td>
                <td>{{rupiah($datas[$i]->ominet)}}</td>
                <td>{{rupiah($datas[$i]->omihpp)}}</td>
                <td style="width: 80px">{{rupiah($datas[$i]->omimrg)}}</td>
                <td style="width: 30px">{{$cf_nmargin[$i]}}</td>
            </tr>
        @endif
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
                        if($datas[$j]->omisbu == 'I'){
                            $grossTotal = $grossTotal + $datas[$j]->omiamt;
                            $taxTotal = $taxTotal + $datas[$j]->omitax;
                            $netTotal = $netTotal + $datas[$j]->ominet;
                            $hppTotal = $hppTotal + $datas[$j]->omihpp;
                            $marginTotal = $marginTotal + $datas[$j]->omimrg;
                        }
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
                    <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">SUB TOTAL</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{$percentageTotal}}</td>
                </tr>
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
                if($datas[$j]->omisbu == 'I'){
                    $grossTotal = $grossTotal + $datas[$j]->omiamt;
                    $taxTotal = $taxTotal + $datas[$j]->omitax;
                    $netTotal = $netTotal + $datas[$j]->ominet;
                    $hppTotal = $hppTotal + $datas[$j]->omihpp;
                    $marginTotal = $marginTotal + $datas[$j]->omimrg;
                }
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
                <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">SUB TOTAL</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{$percentageTotal}}</td>
            </tr>

{{--GRAND TOTAL BRUH!--}}
        <tr>
            <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL SELURUH OMI</td>
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
            <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL INDOMARET + OMI</td>
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

