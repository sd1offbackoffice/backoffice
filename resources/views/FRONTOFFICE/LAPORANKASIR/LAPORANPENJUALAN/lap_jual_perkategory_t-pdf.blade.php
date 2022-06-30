@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    PENJUALAN PER KATEGORY
@endsection

@section('title')
    LAPORAN PENJUALAN PER KATEGORY
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
    function percent($angka){
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                @if($qty == 'Y')
                    <th rowspan="2" colspan="2" style="text-align: left; vertical-align: middle;">KATEGORI</th>
                    <th rowspan="2" style="width: 60px; text-align: right; vertical-align: middle;">QTY</th>
                @else
                    <th rowspan="2" colspan="2" style="text-align: left; vertical-align: middle;">KATEGORI</th>
                    <th rowspan="2" style="width: 60px;">&nbsp;&nbsp;</th>
                @endif
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">PENJUALAN<br>KOTOR</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">PAJAK</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">BEBAS PPN</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">PPN DTP</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">PENJUALAN<br>BERSIH</th>
                <th rowspan="2" style="width: 80px; text-align: right; vertical-align: middle;">H.P.P RATA2</th>
                <th colspan="2" style="text-align: right; vertical-align: middle;">------MARGIN------</th>
            </tr>
            <tr>
                <td style="width: 70px">Rp.</td>
                <td style="width: 10px">%</td>
            </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black; text-align: right">
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
            dd($data);
        ?>
        @for($i=0;$i<sizeof($data);$i++)
        {{--TOTAL PER DEPARTEMEN DAN PER DIVISI--}}
            @if($i!=0)
                @if($departemen != $data[$i]->fdkdep)

                    <?php
                    $qtyTotal = 0;
                    $grossTotal = 0;
                    $taxTotal = 0;
                    $netTotal = 0;
                    $hppTotal = 0;
                    $marginTotal = 0;
                    $percentageTotal = 0;

                    for($j=$i-1;$j>($i-$counterDept-1);$j--){
                        $qtyTotal = $qtyTotal + $data[$j]->ktqty;
                        $grossTotal = $grossTotal + $data[$j]->ngross;
                        $taxTotal = $taxTotal + $data[$j]->ntax;
                        $netTotal = $netTotal + $data[$j]->nnet;
                        $hppTotal = $hppTotal + $data[$j]->nhpp;
                        $marginTotal = $marginTotal + $data[$j]->nmargin;
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
                        <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL PER DEPARTEMEN</td>
                        @if($qty == 'Y')
                            <td style="text-align: right; font-weight: bold;">{{rupiah($qtyTotal)}}</td>
                        @else
                            <td> </td>
                        @endif
                        <td style="text-align: right; font-weight: bold;">{{rupiah($grossTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;">{{rupiah($taxTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;">{{rupiah($netTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;">{{rupiah($hppTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;">{{rupiah($marginTotal)}}</td>
                        <td style="text-align: right; font-weight: bold;">{{percent($percentageTotal)}}</td>
                    </tr>
                @endif

                @if($divisi != $data[$i]->fdkdiv)

                    <?php
                    $qtyTotal = 0;
                    $grossTotal = 0;
                    $taxTotal = 0;
                    $netTotal = 0;
                    $hppTotal = 0;
                    $marginTotal = 0;
                    $percentageTotal = 0;

                    for($j=$i-1;$j>($i-$counterDiv-1);$j--){
                        $qtyTotal = $qtyTotal + $data[$j]->ktqty;
                        $grossTotal = $grossTotal + $data[$j]->ngross;
                        $taxTotal = $taxTotal + $data[$j]->ntax;
                        $netTotal = $netTotal + $data[$j]->nnet;
                        $hppTotal = $hppTotal + $data[$j]->nhpp;
                        $marginTotal = $marginTotal + $data[$j]->nmargin;
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
                        <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black">TOTAL PER DIVISI</td>
                        @if($qty == 'Y')
                            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($qtyTotal)}}</td>
                        @else
                            <td style="border-bottom: 1px solid black"> </td>
                        @endif
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($grossTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($taxTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($netTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($hppTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($marginTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{percent($percentageTotal)}}</td>
                    </tr>
                @endif
            @endif
        {{--HEADER--}}
            @if($divisi != $data[$i]->fdkdiv)
                <?php
                $divisi = $data[$i]->fdkdiv;
                ?>
                <tr>
                    <td colspan="11" style="text-align: left; font-weight: bold;font-size: 15px;">** DIVISI {{$data[$i]->fdkdiv}} - {{$data[$i]->div_namadivisi}}</td>
                </tr>
            @endif

            @if($departemen != $data[$i]->fdkdep)
                <?php
                $departemen = $data[$i]->fdkdep;
                ?>
                <tr>
                    <td colspan="9" style="text-align: left; font-weight: bold;font-size: 11px;">&nbsp;&nbsp;*DEPARTEMEN {{$data[$i]->fdkdep}} - {{$data[$i]->dep_namadepartement}}</td>
                </tr>
            @endif
        {{--BODY--}}
            <tr>
                <td style="width: 20px; text-align: left">{{$data[$i]->fdkatb}}</td>
                <td style="width: 158px; text-align: left">{{$data[$i]->kat_namakategori}}</td>
                @if($qty == 'Y')
                    <td>{{rupiah($data[$i]->ktqty)}}</td>
                @else
                    <td> </td>
                @endif
                <td>{{rupiah($data[$i]->ngross)}}</td>
                <td>{{rupiah($data[$i]->ntax)}}</td>
                <td>{{rupiah($data[$i]->nnet)}}</td>
                <td>{{rupiah($data[$i]->nhpp)}}</td>
                <td>{{rupiah($data[$i]->nmargin)}}</td>
                <td>{{percent($cf_nmargin[$i])}}</td>
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

            for($j=sizeof($data)-1;$j>(sizeof($data)-$counterDept)-1;$j--){
                $qtyTotal = $qtyTotal + $data[$j]->ktqty;
                $grossTotal = $grossTotal + $data[$j]->ngross;
                $taxTotal = $taxTotal + $data[$j]->ntax;
                $netTotal = $netTotal + $data[$j]->nnet;
                $hppTotal = $hppTotal + $data[$j]->nhpp;
                $marginTotal = $marginTotal + $data[$j]->nmargin;
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
                <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL PER DEPARTEMEN</td>
                @if($qty == 'Y')
                    <td style="text-align: right; font-weight: bold;">{{rupiah($qtyTotal)}}</td>
                @else
                    <td> </td>
                @endif
                <td style="text-align: right; font-weight: bold;">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold;">{{rupiah($taxTotal)}}</td>
                <td style="text-align: right; font-weight: bold;">{{rupiah($netTotal)}}</td>
                <td style="text-align: right; font-weight: bold;">{{rupiah($hppTotal)}}</td>
                <td style="text-align: right; font-weight: bold;">{{rupiah($marginTotal)}}</td>
                <td style="text-align: right; font-weight: bold;">{{percent($percentageTotal)}}</td>
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

            for($j=sizeof($data)-1;$j>(sizeof($data)-$counterDiv)-1;$j--){
                $qtyTotal = $qtyTotal + $data[$j]->ktqty;
                $grossTotal = $grossTotal + $data[$j]->ngross;
                $taxTotal = $taxTotal + $data[$j]->ntax;
                $netTotal = $netTotal + $data[$j]->nnet;
                $hppTotal = $hppTotal + $data[$j]->nhpp;
                $marginTotal = $marginTotal + $data[$j]->nmargin;
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
                <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black">TOTAL PER DIVISI</td>
                @if($qty == 'Y')
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($qtyTotal)}}</td>
                @else
                    <td style="border-bottom: 1px solid black"> </td>
                @endif
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($taxTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($netTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($hppTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{rupiah($marginTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{percent($percentageTotal)}}</td>
            </tr>

            {{--GRAND TOTAL--}}
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL COUNTER</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['c'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">&nbsp;&nbsp;TOTAL BARANG KENA PAJAK</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['p'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG TIDAK KENA PAJAK</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['x'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG KENA CUKAI</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['k'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG BEBAS PPN</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['b'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG EXPORT</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['e'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: normal;">TOTAL BARANG PPN DITANGGUNG PEMERINTAH</td>
            <td style="text-align: right; font-weight: bold;">(MINYAK)</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['g'])}}</td>
        </tr>
        {{-- <tr>
            <td colspan="2" style="text-align: right; font-weight: normal;">DIBYR PMRINTH</td>
            <td style="text-align: right; font-weight: bold;">(TEPUNG)</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['r'])}}</td>
        </tr> --}}
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL DEPARTEMEN 43</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['f'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">GRAND TOTAL (TANPA DEPT 40)</td>
            @if($qty == 'Y')
                <td style="text-align: right; font-weight: bold;">{{rupiah($qtygrandtotal-1)}}</td>
            @else
                <td> </td>
            @endif
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['total']-$gross['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['total']-$tax['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['total']-$net['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['total']-$hpp['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['total']-$margin['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['total']-$marginpersen['d'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">GRAND TOTAL (+ DEPT 40)</td>
            @if($qty == 'Y')
                <td style="text-align: right; font-weight: bold;">{{rupiah($qtygrandtotal)}}</td>
            @else
                <td> </td>
            @endif
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['total'])}}</td>
        </tr>
        </tbody>
    </table>
@endsection
