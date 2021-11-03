@extends('html-template')

{{--@section('table_font_size','7 px')--}}

@section('paper_size','842pt 595pt')
{{--@section('paper_size','1200pt 595pt')--}}

@section('page_title')
    LAPORAN-PENJUALAN PER DIVISI
@endsection

{{--@section('custom_style')--}}
{{--    body{--}}
{{--    font-size: 7px;--}}
{{--    }--}}
{{--@endsection--}}

@section('title')
    LAPORAN PENJUALAN
@endsection

@section('subtitle')
    Periode : {{$date1}} s/d {{$date2}}<br>Margin : {{$margin1}} s/d {{$margin2}}
@endsection

@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
    //    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')
<table style="border-collapse: collapse; font-size: 7px">
    <thead style="font-weight: bold; vertical-align: center; text-align: center; border-top: 2px solid black; border-bottom: 2px solid black">
        <tr>
            <td colspan="2" rowspan="3" style="border-right: 1px solid black">------- P  R  O  D  U  K---------</td>
            <td rowspan="3" style="width: 5%; border-right: 1px solid black">UNIT</td>
            <td colspan="12" style="border-right: 1px solid black">SATUAN JUAL</td>
            <td rowspan="3" style="width: 5%; border-right: 1px solid black">KWAN<br>TUM</td>
            <td rowspan="3" style="width: 8%; border-right: 1px solid black">PENJUALAN KOTOR</td>
            <td rowspan="3" style="width: 8%; border-right: 1px solid black">PAJAK</td>
            <td rowspan="3" style="width: 8%; border-right: 1px solid black">PENJUALAN BERSIH</td>
            <td rowspan="3" style="width: 8%; border-right: 1px solid black">HPP RATA-RATA</td>
            <td rowspan="3" colspan="2" style="border-right: 1px solid black">--MARGIN--</td>
            <td rowspan="3" style="width: 2%">T<br>A<br>G</td>
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
    @for($i=0;$i<sizeof($data);$i++)
        {{--HEAD BODY--}}
        @if($divisi != $data[$i]->fdkdiv)
            <tr style="text-align:left; font-weight: bold; font-size: 25px"><td colspan="23">*** DIVISI : {{$data[$i]->fdkdiv}} - {{$data[$i]->div_namadivisi}}</td></tr>
            <?php $divisi =  $data[$i]->fdkdiv; $departemen = ''?>
        @endif
        @if($departemen != $data[$i]->fdkdep)
            <tr style="text-align:left; font-weight: bold; font-size: 20px"><td colspan="23">&nbsp;&nbsp;** DEPARTEMEN : {{$data[$i]->fdkdep}} - {{$data[$i]->dep_namadepartement}}</td></tr>
            <?php $departemen =  $data[$i]->fdkdep; $kategori = ''?>
        @endif
        @if($kategori != $data[$i]->fdkatb)
            <tr style="text-align:left; font-weight: bold;"><td colspan="23">&nbsp;&nbsp;&nbsp;&nbsp;* KATEGORI : {{$data[$i]->fdkatb}} - {{$data[$i]->kat_namakategori}}</td></tr>
            <?php $kategori =  $data[$i]->fdkatb?>
        @endif
        {{--MAIN BODY--}}
        <tr>
            <td style="width: 5%; text-align: center">{{$data[$i]->fdkplu}}</td>
            <td style="width: 15%; text-align: left">{{$data[$i]->prd_deskripsipanjang}}</td>
            <td style="text-align: center">{{$data[$i]->unit}}</td>

            <td>{{rupiah($data[$i]->fdntr0)}}</td>
            <td>{{rupiah($data[$i]->fdsat0)}}</td>
            <td>{{rupiah($data[$i]->fdnam0)}}</td>

            <td>{{rupiah($data[$i]->fdntr1)}}</td>
            <td>{{rupiah($data[$i]->fdsat1)}}</td>
            <td>{{rupiah($data[$i]->fdnam1)}}</td>

            <td>{{rupiah($data[$i]->fdntr2)}}</td>
            <td>{{rupiah($data[$i]->fdsat2)}}</td>
            <td>{{rupiah($data[$i]->fdnam2)}}</td>

            <td>{{rupiah($data[$i]->fdntr3)}}</td>
            <td>{{rupiah($data[$i]->fdsat3)}}</td>
            <td>{{rupiah($data[$i]->fdnam3)}}</td>

            <td>{{rupiah($data[$i]->tot1)}}</td>
            <td>{{rupiah($data[$i]->tot2)}}</td>
            <td>{{rupiah($data[$i]->tot3)}}</td>
            <td>{{rupiah($data[$i]->tot4)}}</td>
            <td>{{rupiah($data[$i]->tot5)}}</td>
            <td style="width: 11%">{{rupiah($data[$i]->tot6)}}</td>
            <td style="width: 4%">{{round(($data[$i]->nmarginp), 2)}}</td>

            <td style="text-align: center">{{$data[$i]->prd_kodetag}}</td>
        </tr>

        {{--SUMMARY VALUE--}}
        <?php
        //SUM
        foreach ($listIndex as $index){
            $sumNilai1[$index] = $sumNilai1[$index] + $data[$i]->fdnam0;
            $sumNilai2[$index] = $sumNilai2[$index] + $data[$i]->fdnam1;
            $sumNilai3[$index] = $sumNilai3[$index] + $data[$i]->fdnam2;
            $sumNilai4[$index] = $sumNilai4[$index] + $data[$i]->fdnam3;

            $sumKwantum[$index] = $sumKwantum[$index] + $data[$i]->tot1;
            $sumGross[$index] = $sumGross[$index] + $data[$i]->tot2;
            $sumTax[$index] = $sumTax[$index] + $data[$i]->tot3;
            $sumNet[$index] = $sumNet[$index] + $data[$i]->tot4;
            $sumHpp[$index] = $sumHpp[$index] + $data[$i]->tot5;
            $sumMargin[$index] = $sumMargin[$index] + $data[$i]->tot6;
        }
        ?>

        @if(($i+1) < sizeof($data) )
            @if($kategori != $data[$i+1]->fdkatb || $departemen != $data[$i+1]->fdkdep)
                <tr style="font-weight: bold;">
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
            @if($departemen != $data[$i+1]->fdkdep || $divisi != $data[$i+1]->fdkdiv)
                <tr style="font-weight: bold;">
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
            @if($divisi != $data[$i+1]->fdkdiv)
                <tr style="font-weight: bold;">
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
        <tr style="font-weight: bold;">
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
        <tr style="font-weight: bold;">
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
        <tr style="font-weight: bold;">
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
@endsection
