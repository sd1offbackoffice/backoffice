<html>
<head>
    <title>LAPORAN-PENJUALAN PER KASIR</title>
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
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
//    $hasil_rupiah = number_format($angka,0,'.',',');
    return $hasil_rupiah;
}
function twopoint($angka){
    $hasil_rupiah = number_format($angka,2,'.',',');
    return $hasil_rupiah;
}
?>

<header>
{{--    <div style="font-size: 12px ;line-height: 0.1px !important;">--}}
{{--        <p>{{$datas[0]->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$datas[0]->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="position: absolute; left: 512px; top: -6px">--}}
{{--        <span>TGL CETAK : {{$today}}<br>JAM CETAK : {{$time}}<br><span style="font-style: italic">USER ID : 111</span></span>--}}
{{--        <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL :  <br> PRG  : IDGP69S</span>--}}
{{--    </div>--}}
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>
            {{ $datas[0]->prs_namaperusahaan }}
        </p>
        <p>
            {{ $datas[0]->prs_namacabang }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px;">
        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>
        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>
        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>
    </div>
    <div style="margin-top: 30px; line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN PENJUALAN</h2>
        <h2 style="text-align: center">PER KASIR</h2>
        <h4 style="text-align: center">{{$periode}}</h4>
        <h4 style="text-align: left">Kasir : {{$kasir}}&nbsp;&nbsp;&nbsp;&nbsp;No. Stat : {{$station}}</h4>
    </div>
</header>
<table style="border-collapse: collapse">
    <thead style="font-weight: bold; vertical-align: middle; border-top: 2px solid black; border-bottom: 2px solid black">
        <tr>
            <td rowspan="2" style="width: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td rowspan="2" style="width: 150px; text-align: left">KATEGORI</td>
            <td rowspan="2" style="width: 100px; text-align: right">PENJUALAN<br>KOTOR</td>
            <td rowspan="2" style="width: 100px; text-align: right">PAJAK</td>
            <td rowspan="2" style="width: 100px; text-align: right">PENJUALAN<br>BERSIH</td>
            <td rowspan="2" style="width: 100px; text-align: right">HPP RATA2</td>
            <td style="text-align: right" colspan="2">--MARGIN--</td>
{{--            <td style="width: 100px; text-align: right">--MARGIN--</td>--}}
{{--            <td style="width: 20px; ">&nbsp;&nbsp;&nbsp;&nbsp;</td>--}}
        </tr>
        <tr>
            <td style="width: 100px; text-align: right">Rp.</td>
            <td style="width: 20px; text-align: right">%</td>
        </tr>
    </thead>
    <?php
    $divisi = '';
    $departemen = '';

    //SUMMARY DECLARE
    $listIndex = ['div','dep','kat'];
    foreach ($listIndex as $index){
        $sumGross[$index] = 0; $sumTax[$index] = 0; $sumNet[$index] = 0; $sumHpp[$index] = 0; $sumMargin[$index] = 0;
    }
    ?>
    <tbody style="text-align: right;">
    @for($i=0;$i<sizeof($datas);$i++)
        {{--HEAD BODY--}}
        @if($divisi != $datas[$i]->fdkdiv)
            <tr style="text-align:left; font-weight: bold;"><td colspan="8">*** DIVISI : {{$datas[$i]->fdkdiv}} - {{$datas[$i]->div_namadivisi}}</td></tr>
            <?php $divisi =  $datas[$i]->fdkdiv?>
        @endif
        @if($departemen != $datas[$i]->fdkdep)
            <tr style="text-align:left; font-weight: bold;"><td colspan="8">&nbsp;&nbsp;** DEPARTEMEN : {{$datas[$i]->fdkdep}} - {{$datas[$i]->dep_namadepartement}}</td></tr>
            <?php $departemen =  $datas[$i]->fdkdep?>
        @endif
        {{--MAIN BODY--}}
        <tr>
            <td>{{$datas[$i]->fdkatb}}</td>
            <td style="text-align: left">{{$datas[$i]->kat_namakategori}}</td>
            <td>{{rupiah($datas[$i]->fdnamt)}}</td>
            <td>{{rupiah($datas[$i]->fdntax)}}</td>
            <td>{{rupiah($datas[$i]->fdnnet)}}</td>
            <td>{{rupiah($datas[$i]->fdnhpp)}}</td>
            <td>{{rupiah($datas[$i]->fdnmrgn)}}</td>
            <td>{{twopoint($nmarginp[$i])}}</td>
        </tr>

        {{--SUMMARY VALUE--}}
        <?php
        //SUM
        foreach ($listIndex as $index){
            $sumGross[$index] = $sumGross[$index] + $datas[$i]->fdnamt;
            $sumTax[$index] = $sumTax[$index] + $datas[$i]->fdntax;
            $sumNet[$index] = $sumNet[$index] + $datas[$i]->fdnnet;
            $sumHpp[$index] = $sumHpp[$index] + $datas[$i]->fdnhpp;
            $sumMargin[$index] = $sumMargin[$index] + $datas[$i]->fdnmrgn;
        }
        ?>

        @if(($i+1) < sizeof($datas) )
            @if($departemen != $datas[$i+1]->fdkdep)
                <tr style="font-weight: bold;">
                    <td colspan="2" style="text-align: left">&nbsp;&nbsp;** TOTAL PER DEPARTEMEN : </td>
                    <td>{{rupiah($sumGross['dep'])}}</td>
                    <td>{{rupiah($sumTax['dep'])}}</td>
                    <td>{{rupiah($sumNet['dep'])}}</td>
                    <td>{{rupiah($sumHpp['dep'])}}</td>
                    <td>{{rupiah($sumMargin['dep'])}}</td>
                    <td><?php
                        if($sumNet['dep'] != 0){
                            echo twopoint(($sumMargin['dep']*100/$sumNet['dep']), 2);
                        }else{
                            if($sumMargin['dep'] != 0){
                                echo 100;
                            }else{
                                echo 0;
                            }
                        }
                        ?></td>
                </tr>
                <?php
                $sumGross['dep'] = 0; $sumTax['dep'] = 0; $sumNet['dep'] = 0; $sumHpp['dep'] = 0; $sumMargin['dep'] = 0;
                ?>
            @endif
            @if($divisi != $datas[$i+1]->fdkdiv)
                <tr style="font-weight: bold;">
                    <td colspan="2" style="text-align: left; border-bottom: 1px solid black">*** TOTAL PER DIVISI : </td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumGross['div'])}}</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumTax['div'])}}</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumNet['div'])}}</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumHpp['div'])}}</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumMargin['div'])}}</td>
                    <td style="border-bottom: 1px solid black"><?php
                        if($sumNet['div'] != 0){
                            echo twopoint(($sumMargin['div']*100/$sumNet['div']), 2);
                        }else{
                            if($sumMargin['div'] != 0){
                                echo 100;
                            }else{
                                echo 0;
                            }
                        }
                        ?></td>
                </tr>
                <?php
                $sumGross['div'] = 0; $sumTax['div'] = 0; $sumNet['div'] = 0; $sumHpp['div'] = 0; $sumMargin['div'] = 0;
                ?>
            @endif
        @endif
    @endfor

<!--OUT OF LOOP DEPARTEMEN-->
        <tr style="font-weight: bold;">
            <td colspan="2" style="text-align: left">&nbsp;&nbsp;** TOTAL PER DEPARTEMEN : </td>
            <td>{{rupiah($sumGross['dep'])}}</td>
            <td>{{rupiah($sumTax['dep'])}}</td>
            <td>{{rupiah($sumNet['dep'])}}</td>
            <td>{{rupiah($sumHpp['dep'])}}</td>
            <td>{{rupiah($sumMargin['dep'])}}</td>
            <td><?php
                if($sumNet['dep'] != 0){
                    echo twopoint(($sumMargin['dep']*100/$sumNet['dep']), 2);
                }else{
                    if($sumMargin['dep'] != 0){
                        echo 100;
                    }else{
                        echo 0;
                    }
                }
                ?></td>
        </tr>
        <?php
        $sumGross['dep'] = 0; $sumTax['dep'] = 0; $sumNet['dep'] = 0; $sumHpp['dep'] = 0; $sumMargin['dep'] = 0;
        ?>

<!--OUT OF LOOP DIVISI-->
        <tr style="font-weight: bold;">
            <td colspan="2" style="text-align: left; border-bottom: 1px solid black">*** TOTAL PER DIVISI : </td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumGross['div'])}}</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumTax['div'])}}</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumNet['div'])}}</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumHpp['div'])}}</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumMargin['div'])}}</td>
            <td style="border-bottom: 1px solid black"><?php
                if($sumNet['div'] != 0){
                    echo twopoint(($sumMargin['div']*100/$sumNet['div']), 2);
                }else{
                    if($sumMargin['div'] != 0){
                        echo 100;
                    }else{
                        echo 0;
                    }
                }
                ?></td>
        </tr>
        <?php
        $sumGross['div'] = 0; $sumTax['div'] = 0; $sumNet['div'] = 0; $sumHpp['div'] = 0; $sumMargin['div'] = 0;
        ?>
        @foreach($arrayIndex as $index)
            @if($index != 'f' && $index != 'd')
                <tr style="font-weight: bold;">
                    ['c','p','x','i','b','e','g','r','h','total-40','total','f']
                    @if($index == 'c')
                        <td colspan="2">TOTAL COUNTER</td>
                    @elseif($index == 'p')
                        <td colspan="2">TOTAL BARANG KENA PAJAK</td>
                    @elseif($index == 'x')
                        <td colspan="2">TOTAL BARANG TIDAK KENA PAJAK</td>
                    @elseif($index == 'b')
                        <td colspan="2">TOTAL BARANG BEBAS PPN</td>
                    @elseif($index == 'e')
                        <td colspan="2">TOTAL BARANG EXPORT</td>
                    @elseif($index == 'g')
                        <td colspan="2">TOTAL BRG PPN DIBYR PMRINTH (MINYAK)</td>
                    @elseif($index == 'r')
                        <td colspan="2">TOTAL BRG PPN DIBYR PMRINTH (TEPUNG)</td>
                    @elseif($index == 'h')
                        <td colspan="2">TOTAL DEPARTEMEN 43</td>
                    @elseif($index == 'total-40')
                        <td colspan="2">GRAND TOTAL (TANPA DEPT 40)</td>
                    @elseif($index == 'total')
                        <td colspan="2">GRAND TOTAL (+ DEPT 40)</td>
                    @endif
                    <td>{{rupiah($gross[$index])}}</td>
                    <td>{{rupiah($tax[$index])}}</td>
                    <td>{{rupiah($net[$index])}}</td>
                    <td>{{rupiah($hpp[$index])}}</td>
                    <td>{{rupiah($margin[$index])}}</td>
                    <td>{{twopoint(($margp[$index]), 2)}}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
    <hr>
    <span style="float: right">**Akhir dari laporan**</span>
</table>
</body>
</html>

