<html>
<head>
    <title>LAPORAN-PENJUALAN PER DIVISI</title>
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
        margin-bottom: 30px;
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
        swal('Information', 'Tekan Ctrl+P untuk print!\n\nPRINT DENGAN FORMAT LANDSCAPE UNTUK HASIL YANG BAGUS', 'info');
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
    <div style="font-size: 12px ;line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="float: right; margin-top: -38px">
        <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL : {{$today}} <br> PRG  : IDGP69H</span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN PENJUALAN</h2>
        <h4 style="text-align: center">Periode : {{$date1}} s/d {{$date2}}</h4>
        <h4 style="text-align: center">Margin : {{$margin1}} s/d {{$margin2}}</h4>
    </div>
</header>
<table style="border-collapse: collapse">
    <thead style="font-weight: bold; vertical-align: center; text-align: center; border-top: 2px solid black; border-bottom: 2px solid black">
        <tr>
            <td colspan="2" rowspan="3" style="border-right: 1px solid black">------- P  R  O  D  U  K---------</td>
            <td rowspan="3" style="width: 5%; border-right: 1px solid black">UNIT</td>
            <td colspan="12" style="border-right: 1px solid black">SATUAN JUAL</td>
            <td rowspan="3" style="width: 5%; border-right: 1px solid black">KWANTUM</td>
            <td rowspan="3" style="width: 12%; border-right: 1px solid black">PENJUALAN KOTOR</td>
            <td rowspan="3" style="width: 12%; border-right: 1px solid black">PAJAK</td>
            <td rowspan="3" style="width: 12%; border-right: 1px solid black">PENJUALAN BERSIH</td>
            <td rowspan="3" style="width: 12%; border-right: 1px solid black">HPP RATA-RATA</td>
            <td rowspan="3" colspan="2" style="border-right: 1px solid black">--MARGIN--</td>
            <td rowspan="3" style="width: 5%">T<br>A<br>G</td>
        </tr>
        <tr style="border-top: 1px solid black;">
            @for($i=0;$i<4;$i++)
                <td colspan="3" style="border-right: 1px solid black">--------{{$i}}--------</td>
            @endfor
        </tr>
        <tr style="border-top: 1px solid black;">
            @for($i=0;$i<4;$i++)
                <td style="width: 3%; border-right: 1px solid black">TRN</td>
                <td style="width: 3%; border-right: 1px solid black">QTY</td>
                <td style="width: 3%; border-right: 1px solid black">NILAI</td>
            @endfor
        </tr>
    </thead>
    <?php
    $divisi = '';
    $departemen = '';
    $kategori = '';

    //SUMMARY DECLARE
    $listIndex = ['div','dep','kat'];
    foreach ($listIndex as $index){
        $sumNilai1[$index] = 0; $sumNilai2[$index] = 0; $sumNilai3[$index] = 0; $sumNilai4[$index] = 0;
        $sumKwantum[$index] = 0; $sumGross[$index] = 0; $sumTax[$index] = 0; $sumNet[$index] = 0; $sumHpp[$index] = 0; $sumMargin[$index] = 0;
    }
    ?>
    <tbody style="text-align: right;">
    @for($i=0;$i<sizeof($datas);$i++)
        {{--HEAD BODY--}}
        @if($divisi != $datas[$i]->fdkdiv)
            <tr style="text-align:left; font-weight: bold; font-size: 25px"><td colspan="23">*** DIVISI : {{$datas[$i]->fdkdiv}} - {{$datas[$i]->div_namadivisi}}</td></tr>
            <?php $divisi =  $datas[$i]->fdkdiv; $departemen = ''?>
        @endif
        @if($departemen != $datas[$i]->fdkdep)
            <tr style="text-align:left; font-weight: bold; font-size: 20px"><td colspan="23">&nbsp;&nbsp;** DEPARTEMEN : {{$datas[$i]->fdkdep}} - {{$datas[$i]->dep_namadepartement}}</td></tr>
            <?php $departemen =  $datas[$i]->fdkdep; $kategori = ''?>
        @endif
        @if($kategori != $datas[$i]->fdkatb)
            <tr style="text-align:left; font-weight: bold; font-size: 15px"><td colspan="23">&nbsp;&nbsp;&nbsp;&nbsp;* KATEGORI : {{$datas[$i]->fdkatb}} - {{$datas[$i]->kat_namakategori}}</td></tr>
            <?php $kategori =  $datas[$i]->fdkatb?>
        @endif
        {{--MAIN BODY--}}
        <tr>
            <td style="width: 5%; text-align: center">{{$datas[$i]->fdkplu}}</td>
            <td style="width: 15%; text-align: left">{{$datas[$i]->prd_deskripsipanjang}}</td>
            <td style="text-align: center">{{$datas[$i]->unit}}</td>

            <td>{{rupiah($datas[$i]->fdntr0)}}</td>
            <td>{{rupiah($datas[$i]->fdsat0)}}</td>
            <td>{{rupiah($datas[$i]->fdnam0)}}</td>

            <td>{{rupiah($datas[$i]->fdntr1)}}</td>
            <td>{{rupiah($datas[$i]->fdsat1)}}</td>
            <td>{{rupiah($datas[$i]->fdnam1)}}</td>

            <td>{{rupiah($datas[$i]->fdntr2)}}</td>
            <td>{{rupiah($datas[$i]->fdsat2)}}</td>
            <td>{{rupiah($datas[$i]->fdnam2)}}</td>

            <td>{{rupiah($datas[$i]->fdntr3)}}</td>
            <td>{{rupiah($datas[$i]->fdsat3)}}</td>
            <td>{{rupiah($datas[$i]->fdnam3)}}</td>

            <td>{{rupiah($datas[$i]->tot1)}}</td>
            <td>{{rupiah($datas[$i]->tot2)}}</td>
            <td>{{rupiah($datas[$i]->tot3)}}</td>
            <td>{{rupiah($datas[$i]->tot4)}}</td>
            <td>{{rupiah($datas[$i]->tot5)}}</td>
            <td style="width: 11%">{{rupiah($datas[$i]->tot6)}}</td>
            <td style="width: 4%">{{round(($datas[$i]->nmarginp), 2)}}</td>

            <td style="text-align: center">{{$datas[$i]->prd_kodetag}}</td>
        </tr>

        {{--SUMMARY VALUE--}}
        <?php
        //SUM
        foreach ($listIndex as $index){
            $sumNilai1[$index] = $sumNilai1[$index] + $datas[$i]->fdnam0;
            $sumNilai2[$index] = $sumNilai2[$index] + $datas[$i]->fdnam1;
            $sumNilai3[$index] = $sumNilai3[$index] + $datas[$i]->fdnam2;
            $sumNilai4[$index] = $sumNilai4[$index] + $datas[$i]->fdnam3;

            $sumKwantum[$index] = $sumKwantum[$index] + $datas[$i]->tot1;
            $sumGross[$index] = $sumGross[$index] + $datas[$i]->tot2;
            $sumTax[$index] = $sumTax[$index] + $datas[$i]->tot3;
            $sumNet[$index] = $sumNet[$index] + $datas[$i]->tot4;
            $sumHpp[$index] = $sumHpp[$index] + $datas[$i]->tot5;
            $sumMargin[$index] = $sumMargin[$index] + $datas[$i]->tot6;
        }
        ?>

        @if(($i+1) < sizeof($datas) )
            @if($kategori != $datas[$i+1]->fdkatb || $departemen != $datas[$i+1]->fdkdep)
                <tr style="font-weight: bold; font-size: 15px">
                    <td colspan="5" style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;* TOTAL PER KATEGORI : </td>
                    <td>{{rupiah($sumNilai1['kat'])}}</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumNilai2['kat'])}}</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumNilai3['kat'])}}</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumNilai4['kat'])}}</td>
                    <td>{{rupiah($sumKwantum['kat'])}}</td>
                    <td>{{rupiah($sumGross['kat'])}}</td>
                    <td>{{rupiah($sumTax['kat'])}}</td>
                    <td>{{rupiah($sumNet['kat'])}}</td>
                    <td>{{rupiah($sumHpp['kat'])}}</td>
                    <td>{{rupiah($sumMargin['kat'])}}</td>
                    <td><?php
                        if($sumNet['kat'] != 0){
                            echo round(($sumMargin['kat']*100/$sumNet['kat']), 2);
                        }else{
                            if($sumMargin['kat'] != 0){
                                echo 100;
                            }else{
                                echo 0;
                            }
                        }
                        ?></td>
                </tr>
                <?php
                $sumNilai1['kat'] = 0; $sumNilai2['kat'] = 0; $sumNilai3['kat'] = 0; $sumNilai4['kat'] = 0;
                $sumKwantum['kat'] = 0; $sumGross['kat'] = 0; $sumTax['kat'] = 0; $sumNet['kat'] = 0; $sumHpp['kat'] = 0; $sumMargin['kat'] = 0;
                ?>
            @endif
            @if($departemen != $datas[$i+1]->fdkdep || $divisi != $datas[$i+1]->fdkdiv)
                <tr style="font-weight: bold; font-size: 16px">
                    <td colspan="5" style="text-align: left">&nbsp;&nbsp;** TOTAL PER DEPARTEMEN : </td>
                    <td>{{rupiah($sumNilai1['dep'])}}</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumNilai2['dep'])}}</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumNilai3['dep'])}}</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumNilai4['dep'])}}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumGross['dep'])}}</td>
                    <td>{{rupiah($sumTax['dep'])}}</td>
                    <td>{{rupiah($sumNet['dep'])}}</td>
                    <td>{{rupiah($sumHpp['dep'])}}</td>
                    <td>{{rupiah($sumMargin['dep'])}}</td>
                    <td><?php
                        if($sumNet['dep'] != 0){
                            echo round(($sumMargin['dep']*100/$sumNet['dep']), 2);
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
                $sumNilai1['dep'] = 0; $sumNilai2['dep'] = 0; $sumNilai3['dep'] = 0; $sumNilai4['dep'] = 0;
                $sumKwantum['dep'] = 0; $sumGross['dep'] = 0; $sumTax['dep'] = 0; $sumNet['dep'] = 0; $sumHpp['dep'] = 0; $sumMargin['dep'] = 0;
                ?>
            @endif
            @if($divisi != $datas[$i+1]->fdkdiv)
                <tr style="font-weight: bold; font-size: 17px">
                    <td colspan="5" style="text-align: left">*** TOTAL PER DIVISI : </td>
                    <td>{{rupiah($sumNilai1['div'])}}</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumNilai2['div'])}}</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumNilai3['div'])}}</td>
                    <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumNilai4['div'])}}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{rupiah($sumGross['div'])}}</td>
                    <td>{{rupiah($sumTax['div'])}}</td>
                    <td>{{rupiah($sumNet['div'])}}</td>
                    <td>{{rupiah($sumHpp['div'])}}</td>
                    <td>{{rupiah($sumMargin['div'])}}</td>
                    <td><?php
                        if($sumNet['div'] != 0){
                            echo round(($sumMargin['div']*100/$sumNet['div']), 2);
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
                $sumNilai1['div'] = 0; $sumNilai2['div'] = 0; $sumNilai3['div'] = 0; $sumNilai4['div'] = 0;
                $sumKwantum['div'] = 0; $sumGross['div'] = 0; $sumTax['div'] = 0; $sumNet['div'] = 0; $sumHpp['div'] = 0; $sumMargin['div'] = 0;
                ?>
            @endif
        @endif
    @endfor

<!--OUT OF LOOP KATEGORI-->
        <tr style="font-weight: bold; font-size: 15px">
            <td colspan="5" style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;* TOTAL PER KATEGORI : </td>
            <td>{{rupiah($sumNilai1['kat'])}}</td>
            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumNilai2['kat'])}}</td>
            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumNilai3['kat'])}}</td>
            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumNilai4['kat'])}}</td>
            <td>{{rupiah($sumKwantum['kat'])}}</td>
            <td>{{rupiah($sumGross['kat'])}}</td>
            <td>{{rupiah($sumTax['kat'])}}</td>
            <td>{{rupiah($sumNet['kat'])}}</td>
            <td>{{rupiah($sumHpp['kat'])}}</td>
            <td>{{rupiah($sumMargin['kat'])}}</td>
            <td><?php
                if($sumNet['kat'] != 0){
                    echo round(($sumMargin['kat']*100/$sumNet['kat']), 2);
                }else{
                    if($sumMargin['kat'] != 0){
                        echo 100;
                    }else{
                        echo 0;
                    }
                }
                ?></td>
        </tr>
        <?php
        $sumNilai1['kat'] = 0; $sumNilai2['kat'] = 0; $sumNilai3['kat'] = 0; $sumNilai4['kat'] = 0;
        $sumKwantum['kat'] = 0; $sumGross['kat'] = 0; $sumTax['kat'] = 0; $sumNet['kat'] = 0; $sumHpp['kat'] = 0; $sumMargin['kat'] = 0;
        ?>

<!--OUT OF LOOP DEPARTEMEN-->
        <tr style="font-weight: bold; font-size: 16px">
            <td colspan="5" style="text-align: left">&nbsp;&nbsp;** TOTAL PER DEPARTEMEN : </td>
            <td>{{rupiah($sumNilai1['dep'])}}</td>
            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumNilai2['dep'])}}</td>
            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumNilai3['dep'])}}</td>
            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumNilai4['dep'])}}</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumGross['dep'])}}</td>
            <td>{{rupiah($sumTax['dep'])}}</td>
            <td>{{rupiah($sumNet['dep'])}}</td>
            <td>{{rupiah($sumHpp['dep'])}}</td>
            <td>{{rupiah($sumMargin['dep'])}}</td>
            <td><?php
                if($sumNet['dep'] != 0){
                    echo round(($sumMargin['dep']*100/$sumNet['dep']), 2);
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
        $sumNilai1['dep'] = 0; $sumNilai2['dep'] = 0; $sumNilai3['dep'] = 0; $sumNilai4['dep'] = 0;
        $sumKwantum['dep'] = 0; $sumGross['dep'] = 0; $sumTax['dep'] = 0; $sumNet['dep'] = 0; $sumHpp['dep'] = 0; $sumMargin['dep'] = 0;
        ?>

<!--OUT OF LOOP DIVISI-->
        <tr style="font-weight: bold; font-size: 17px">
            <td colspan="5" style="text-align: left">*** TOTAL PER DIVISI : </td>
            <td>{{rupiah($sumNilai1['div'])}}</td>
            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumNilai2['div'])}}</td>
            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumNilai3['div'])}}</td>
            <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumNilai4['div'])}}</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>{{rupiah($sumGross['div'])}}</td>
            <td>{{rupiah($sumTax['div'])}}</td>
            <td>{{rupiah($sumNet['div'])}}</td>
            <td>{{rupiah($sumHpp['div'])}}</td>
            <td>{{rupiah($sumMargin['div'])}}</td>
            <td><?php
                if($sumNet['div'] != 0){
                    echo round(($sumMargin['div']*100/$sumNet['div']), 2);
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
        $sumNilai1['div'] = 0; $sumNilai2['div'] = 0; $sumNilai3['div'] = 0; $sumNilai4['div'] = 0;
        $sumKwantum['div'] = 0; $sumGross['div'] = 0; $sumTax['div'] = 0; $sumNet['div'] = 0; $sumHpp['div'] = 0; $sumMargin['div'] = 0;
        ?>
        @foreach($arrayIndex as $index)
            @if($index != 'f')
                <tr style="font-weight: bold;">
                    @if($index == 'c')
                        <td colspan="16">TOTAL COUNTER</td>
                    @elseif($index == 'p')
                        <td colspan="16">TOTAL BARANG KENA PAJAK</td>
                    @elseif($index == 'x')
                        <td colspan="16">TOTAL BARANG TIDAK KENA PAJAK</td>
                    @elseif($index == 'i')
                        <td colspan="16">TOTAL BARANG KENA CUKAI</td>
                    @elseif($index == 'b')
                        <td colspan="16">TOTAL BARANG BEBAS PPN</td>
                    @elseif($index == 'e')
                        <td colspan="16">TOTAL BARANG EXPORT)</td>
                    @elseif($index == 'g')
                        <td colspan="16">TOTAL BRG PPN DIBYR PMRINTH (MINYAK)</td>
                    @elseif($index == 'r')
                        <td colspan="16">TOTAL BRG PPN DIBYR PMRINTH (TEPUNG)</td>
                    @elseif($index == 'h')
                        <td colspan="16">TOTAL DEPARTEMEN 43</td>
                    @elseif($index == 'total-40')
                        <td colspan="16">GRAND TOTAL (TANPA DEPT 40)</td>
                    @elseif($index == 'total')
                        <td colspan="16">GRAND TOTAL (+ DEPT 40)</td>
                    @endif
                    <td>{{rupiah($gross[$index])}}</td>
                    <td>{{rupiah($tax[$index])}}</td>
                    <td>{{rupiah($net[$index])}}</td>
                    <td>{{rupiah($hpp[$index])}}</td>
                    <td>{{rupiah($margin[$index])}}</td>
                    <td>{{round(($margp[$index]), 2)}}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
</body>
</html>

