@extends('pdf-template')

@section('paper_size','842pt 595pt')

@section('custom_style')
{{--    body{--}}
{{--    margin-left:-100px;--}}
{{--    }--}}
    #table-custom-ryan{
        font-size: 7px;
        white-space: nowrap;
        color: #212529;
    }
@endsection

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-PENJUALAN PER DIVISI
@endsection

@section('title')
    LAPORAN PENJUALAN
@endsection

@section('subtitle')
    Periode : {{$date1}} s/d {{$date2}}<br>Kode Monitoring :  : {{$mon}}<br>Margin : {{$margin1}} s/d {{$margin2}}
@endsection

@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
    //    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
    function twopoint($angka){
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')

<table id="table-custom-ryan" style="border-collapse: collapse">
    <thead style="font-weight: bold; vertical-align: middle; text-align: center; border-top: 2px solid black; border-bottom: 2px solid black">
        <tr>
            <td colspan="2" rowspan="3" style="border-right: 1px solid black;">------- P  R  O  D  U  K---------</td>
            <td rowspan="3" style="border-right: 1px solid black">UNIT</td>
            <td colspan="12" style="border-right: 1px solid black">SATUAN JUAL</td>
            <td rowspan="3" style="border-right: 1px solid black">KWAN<br>TUM</td>
            <td rowspan="3" style="border-right: 1px solid black">PENJUALAN<br>KOTOR</td>
            <td rowspan="3" style="border-right: 1px solid black">PAJAK</td>
            <td rowspan="3" style="border-right: 1px solid black">PENJUALAN<br>BERSIH</td>
            <td rowspan="3" style="border-right: 1px solid black">HPP<br>RATA-RATA</td>
            <td colspan="2" style="border-right: 1px solid black">--MARGIN--</td>
            <td rowspan="3">T<br>A<br>G</td>
        </tr>
        <tr style="border-top: 1px solid black;">
            @for($i=0;$i<4;$i++)
                <td colspan="3" style="border-right: 1px solid black; border-top: 1px solid black;">--------{{$i}}--------</td>
            @endfor
            <td rowspan="2" style="border-right: 1px solid black; border-top: 1px solid black;">Rp.</td>
            <td rowspan="2" style="border-right: 1px solid black; border-top: 1px solid black;">%</td>
        </tr>
        <tr style="border-top: 1px solid black;">
            @for($i=0;$i<4;$i++)
                <td style="border-right: 1px solid black; border-top: 1px solid black;">TRN</td>
                <td style="border-right: 1px solid black; border-top: 1px solid black;">QTY</td>
                <td style="border-right: 1px solid black; border-top: 1px solid black;">NILAI</td>
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
            <tr style="text-align:left; font-weight: bold;"><td colspan="23">*** DIVISI : {{$data[$i]->fdkdiv}} - {{$data[$i]->div_namadivisi}}</td></tr>
            <?php $divisi =  $data[$i]->fdkdiv; $departemen = ''?>
        @endif
        @if($departemen != $data[$i]->fdkdep)
            <tr style="text-align:left; font-weight: bold;"><td colspan="23">&nbsp;&nbsp;** DEPARTEMEN : {{$data[$i]->fdkdep}} - {{$data[$i]->dep_namadepartement}}</td></tr>
            <?php $departemen =  $data[$i]->fdkdep; $kategori = ''?>
        @endif
        @if($kategori != $data[$i]->fdkatb)
            <tr style="text-align:left; font-weight: bold;"><td colspan="23">&nbsp;&nbsp;&nbsp;&nbsp;* KATEGORI : {{$data[$i]->fdkatb}} - {{$data[$i]->kat_namakategori}}</td></tr>
            <?php $kategori =  $data[$i]->fdkatb?>
        @endif
        {{--MAIN BODY--}}
        <tr>
            <td style="width: 8px; text-align: center">{{$data[$i]->fdkplu}}</td>
            <td style="width: 300px; text-align: left">{{$data[$i]->prd_deskripsipanjang}}</td>
            <td style="width: 20px; text-align: center">{{$data[$i]->unit}}</td>

            <td style="width: 20px">{{$data[$i]->fdntr0}}</td>
            <td style="width: 20px">{{$data[$i]->fdsat0}}</td>
            <td style="width: 40px">{{rupiah($data[$i]->fdnam0)}}</td>

            <td style="width: 20px">{{$data[$i]->fdntr1}}</td>
            <td style="width: 20px">{{$data[$i]->fdsat1}}</td>
            <td style="width: 40px">{{rupiah($data[$i]->fdnam1)}}</td>

            <td style="width: 20px">{{$data[$i]->fdntr2}}</td>
            <td style="width: 20px">{{$data[$i]->fdsat2}}</td>
            <td style="width: 40px">{{rupiah($data[$i]->fdnam2)}}</td>

            <td style="width: 20px">{{$data[$i]->fdntr3}}</td>
            <td style="width: 20px">{{$data[$i]->fdsat3}}</td>
            <td style="width: 40px">{{rupiah($data[$i]->fdnam3)}}</td>

            <td style="width: 35px">{{rupiah($data[$i]->tot1)}}</td>
            <td style="width: 50px">{{rupiah($data[$i]->tot2)}}</td>
            <td style="width: 40px">{{rupiah($data[$i]->tot3)}}</td>
            <td style="width: 50px">{{rupiah($data[$i]->tot4)}}</td>
            <td style="width: 50px">{{rupiah($data[$i]->tot5)}}</td>
            <td style="width: 40px">{{rupiah($data[$i]->tot6)}}</td>
            <td style="width: 20px">{{twopoint(($data[$i]->nmarginp))}}</td>

            <td style="width: 15px; text-align: center">{{$data[$i]->prd_kodetag}}</td>
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
                            echo twopoint(($sumMargin['kat']*100/$sumNet['kat']));
                        }else{
                            if($sumMargin['kat'] != 0){
                                echo 100;
                            }else{
                                echo "0.00";
                            }
                        }
                        ?></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
                            echo twopoint(($sumMargin['dep']*100/$sumNet['dep']));
                        }else{
                            if($sumMargin['dep'] != 0){
                                echo 100;
                            }else{
                                echo "0.00";
                            }
                        }
                        ?></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <?php
                $sumNilai1['dep'] = 0; $sumNilai2['dep'] = 0; $sumNilai3['dep'] = 0; $sumNilai4['dep'] = 0;
                $sumKwantum['dep'] = 0; $sumGross['dep'] = 0; $sumTax['dep'] = 0; $sumNet['dep'] = 0; $sumHpp['dep'] = 0; $sumMargin['dep'] = 0;
                ?>
            @endif
            @if($divisi != $data[$i+1]->fdkdiv)
                <tr style="font-weight: bold;">
                    <td colspan="5" style="text-align: left; border-bottom: 1px solid black">*** TOTAL PER DIVISI : </td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumNilai1['div'])}}</td>
                    <td colspan="2" style="border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumNilai2['div'])}}</td>
                    <td colspan="2" style="border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumNilai3['div'])}}</td>
                    <td colspan="2" style="border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumNilai4['div'])}}</td>
                    <td style="border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumGross['div'])}}</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumTax['div'])}}</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumNet['div'])}}</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumHpp['div'])}}</td>
                    <td style="border-bottom: 1px solid black">{{rupiah($sumMargin['div'])}}</td>
                    <td style="border-bottom: 1px solid black"><?php
                        if($sumNet['div'] != 0){
                            echo twopoint(($sumMargin['div']*100/$sumNet['div']));
                        }else{
                            if($sumMargin['div'] != 0){
                                echo 100;
                            }else{
                                echo "0.00";
                            }
                        }
                        ?></td>
                    <td style="border-bottom: 1px solid black">&nbsp;&nbsp;</td>
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
                    echo twopoint(($sumMargin['kat']*100/$sumNet['kat']));
                }else{
                    if($sumMargin['kat'] != 0){
                        echo 100;
                    }else{
                        echo "0.00";
                    }
                }
                ?></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
                    echo twopoint(($sumMargin['dep']*100/$sumNet['dep']));
                }else{
                    if($sumMargin['dep'] != 0){
                        echo 100;
                    }else{
                        echo "0.00";
                    }
                }
                ?></td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <?php
        $sumNilai1['dep'] = 0; $sumNilai2['dep'] = 0; $sumNilai3['dep'] = 0; $sumNilai4['dep'] = 0;
        $sumKwantum['dep'] = 0; $sumGross['dep'] = 0; $sumTax['dep'] = 0; $sumNet['dep'] = 0; $sumHpp['dep'] = 0; $sumMargin['dep'] = 0;
        ?>

<!--OUT OF LOOP DIVISI-->
        <tr style="font-weight: bold;">
            <td colspan="5" style="text-align: left; border-bottom: 1px solid black">*** TOTAL PER DIVISI : </td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumNilai1['div'])}}</td>
            <td colspan="2" style="border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumNilai2['div'])}}</td>
            <td colspan="2" style="border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumNilai3['div'])}}</td>
            <td colspan="2" style="border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumNilai4['div'])}}</td>
            <td style="border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumGross['div'])}}</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumTax['div'])}}</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumNet['div'])}}</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumHpp['div'])}}</td>
            <td style="border-bottom: 1px solid black">{{rupiah($sumMargin['div'])}}</td>
            <td style="border-bottom: 1px solid black"><?php
                if($sumNet['div'] != 0){
                    echo twopoint(($sumMargin['div']*100/$sumNet['div']));
                }else{
                    if($sumMargin['div'] != 0){
                        echo 100;
                    }else{
                        echo "0.00";
                    }
                }
                ?></td>
            <td style="border-bottom: 1px solid black">&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        <?php
        $sumNilai1['div'] = 0; $sumNilai2['div'] = 0; $sumNilai3['div'] = 0; $sumNilai4['div'] = 0;
        $sumKwantum['div'] = 0; $sumGross['div'] = 0; $sumTax['div'] = 0; $sumNet['div'] = 0; $sumHpp['div'] = 0; $sumMargin['div'] = 0;
        ?>
        @foreach($arrayIndex as $index)
            @if($index != 'f')
                <tr style="font-weight: bold;">
                    ['c','p','x','i','b','e','g','r','h','total-40','total','f']
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
                    <td>{{twopoint(($margp[$index]))}}</td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
@endsection
