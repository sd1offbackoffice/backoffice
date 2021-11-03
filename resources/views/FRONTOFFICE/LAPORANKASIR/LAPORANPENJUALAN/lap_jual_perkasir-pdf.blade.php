@extends('pdf-template')

@section('custom_style')

@endsection

@section('table_font_size','10 px')

@section('page_title')
    LAPORAN-PENJUALAN PER KASIR
@endsection

@section('title')
    LAPORAN PENJUALAN PER KASIR
@endsection

@section('subtitle')
    {{$periode}}
@endsection

@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
    //    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
    function twopoint($angka){
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')
<h4 style="text-align: left; float: left;margin-top: -20px">Kasir : {{$kasir}}&nbsp;&nbsp;&nbsp;&nbsp;No. Stat : {{$station}}</h4><br>
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
    @for($i=0;$i<sizeof($data);$i++)
        {{--HEAD BODY--}}
        @if($divisi != $data[$i]->fdkdiv)
            <tr style="text-align:left; font-weight: bold;"><td colspan="8">*** DIVISI : {{$data[$i]->fdkdiv}} - {{$data[$i]->div_namadivisi}}</td></tr>
            <?php $divisi =  $data[$i]->fdkdiv; $departemen = ''?>
        @endif
        @if($departemen != $data[$i]->fdkdep)
            <tr style="text-align:left; font-weight: bold;"><td colspan="8">&nbsp;&nbsp;** DEPARTEMEN : {{$data[$i]->fdkdep}} - {{$data[$i]->dep_namadepartement}}</td></tr>
            <?php $departemen =  $data[$i]->fdkdep; $kategori = ''?>
        @endif
        {{--MAIN BODY--}}
        <tr>
            <td>{{$data[$i]->fdkatb}}</td>
            <td style="text-align: left">{{$data[$i]->kat_namakategori}}</td>
            <td>{{rupiah($data[$i]->fdnamt)}}</td>
            <td>{{rupiah($data[$i]->fdntax)}}</td>
            <td>{{rupiah($data[$i]->fdnnet)}}</td>
            <td>{{rupiah($data[$i]->fdnhpp)}}</td>
            <td>{{rupiah($data[$i]->fdnmrgn)}}</td>
            <td>{{twopoint($nmarginp[$i])}}</td>
        </tr>

        {{--SUMMARY VALUE--}}
        <?php
        //SUM
        foreach ($listIndex as $index){
            $sumGross[$index] = $sumGross[$index] + $data[$i]->fdnamt;
            $sumTax[$index] = $sumTax[$index] + $data[$i]->fdntax;
            $sumNet[$index] = $sumNet[$index] + $data[$i]->fdnnet;
            $sumHpp[$index] = $sumHpp[$index] + $data[$i]->fdnhpp;
            $sumMargin[$index] = $sumMargin[$index] + $data[$i]->fdnmrgn;
        }
        ?>

        @if(($i+1) < sizeof($data) )
            @if($departemen != $data[$i+1]->fdkdep || $divisi != $data[$i+1]->fdkdiv)
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
            @if($divisi != $data[$i+1]->fdkdiv)
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
</table>
<hr>
@endsection
