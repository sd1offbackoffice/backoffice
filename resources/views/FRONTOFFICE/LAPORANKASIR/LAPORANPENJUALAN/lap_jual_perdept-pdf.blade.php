@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-PENJUALAN PER DEPARTEMEN
@endsection

@section('title')
    @if(sizeof($data) != 0)
        {{$data[0]->title}} PER DEPARTEMEN
    @else
        PENJUALAN
    @endif
@endsection

@section('subtitle')
    {{$keterangan}}<br>{{$periode}}
    <style>
        @page {
           /*margin: 25px 20px;*/
           /*size: 1071pt 792pt;*/
           /* size: @yield('paper_size','595pt 842pt'); */
           size: @yield('paper_size','700pt 842pt');
           /*size: 842pt 638pt;*/
       }
    </style>
@endsection

@php
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
@endphp

@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th rowspan="2" colspan="2" style="text-align: left; vertical-align: middle;">DEPARTEMEN</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 100px;">PENJUALAN KOTOR</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 80px;">PPN</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 80px;">BEBAS PPN</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 80px;">PPN DTP</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 80px;">PENJUALAN BERSIH</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 100px;">H.P.P RATA2</th>
                <th colspan="2" style="text-align: right; vertical-align: middle;">------MARGIN------</th>
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
            // dd($data);
            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $freePPNTotal = 0;
            $ppnDTPTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;

            $temp_cdept = '';
            $tempDepartement = '';
            $grossTotal_body = 0;
            $taxTotal_body = 0;
            $netTotal_body = 0;
            $freePPNTotal_body = 0;
            $ppnDTPTotal_body = 0;
            $hppTotal_body = 0;
            $marginTotal_body = 0;
            $percentageTotal_body = 0;

        ?>
        @for($i=0;$i<sizeof($data);$i++)
        {{--TOTAL PER DIVISI--}}
            @if($i!=0)
                @if($divisi != $data[$i]->cdiv)
                <?php
                    $grossTotal = 0;
                    $taxTotal = 0;
                    $netTotal = 0;
                    $freePPNTotal = 0;
                    $ppnDTPTotal = 0;
                    $hppTotal = 0;
                    $marginTotal = 0;
                    $percentageTotal = 0;

                    for($j=$i-1;$j>($i-$counterDiv-1);$j--){
                        $grossTotal = $grossTotal + $data[$j]->ngross;
                        if($data[$i]->fdfbkp == 'Y')
                        {
                            $taxTotal = $taxTotal + $data[$j]->ntax;
                        }
                        else if($data[$i]->fdfbkp == 'P')
                        {
                            $freePPNTotal = $freePPNTotal + $data[$j]->ntax;
                        }
                        else {
                            $ppnDTPTotal = $ppnDTPTotal + $data[$j]->ntax;
                        }
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
                            $percentageTotal = "0.00";
                        }
                    }
                    $percentageTotal = round($percentageTotal, 2);
                    $counterDiv = 0;
                    ?>

                    <tr>
                        {{-- total setiap divisi --}}
                        <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($freePPNTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($ppnDTPTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{percent($percentageTotal)}}</td>
                    </tr>
                @endif
            @endif
        {{--HEADER--}}
            @if($divisi != $data[$i]->cdiv)
                <?php
                $divisi = $data[$i]->cdiv;
                ?>
                <tr>
                    {{-- FOOD, NON FOOD --}}
                    <td colspan="9" style="text-align: left; font-weight: bold;font-size: 15px;">{{$data[$i]->div_namadivisi}} Division</td>
                </tr>
            @endif
        @php
            $temp_cdept = $data[$i]->cdept;
            $tempDepartement = $data[$i]->dep_namadepartement;

            $grossTotal_body = $grossTotal_body + $data[$i]->ngross;
            if($data[$i]->fdfbkp == 'Y')
            {
                $taxTotal_body = $taxTotal_body + $data[$i]->ntax;
            }
            else if($data[$i]->fdfbkp == 'P')
            {
                $freePPNTotal_body = $freePPNTotal_body + $data[$i]->ntax;
            }
            else {
                $ppnDTPTotal_body = $ppnDTPTotal_body + $data[$i]->ntax;
            }
            $netTotal_body = $netTotal_body + $data[$i]->nnet;
            $hppTotal_body = $hppTotal_body + $data[$i]->nhpp;
            $marginTotal_body = $marginTotal_body + $data[$i]->nmargin;

            if($netTotal_body != 0){
                $percentageTotal_body = $marginTotal_body*100/$netTotal_body;
            }else{
                if($marginTotal_body != 0){
                    $percentageTotal_body = 100;
                }else{
                    $percentageTotal_body = "0.00";
                }
            }
            $percentageTotal_body = round($percentageTotal_body, 2);
       @endphp
        {{--BODY--}}
            {{-- KALAU DATA NEXT TIDAK NULL DAN NAMA DEPARTEMENT TIDAK SAMA DENGAN NAMA DEPARTEMENT YANG SELANJUTNYA --}}
            @if(isset($data[$i+1]) && ($tempDepartement != $data[$i+1]->dep_namadepartement) || !(isset($data[$i+1])) )
                <tr>
                    <td style="width: 20px; text-align: left">{{$temp_cdept}}</td>
                    <td style="width: 185px; text-align: left">{{$tempDepartement}}</td>
                    <td>{{rupiah($grossTotal_body)}}</td>
                    <td>{{rupiah($taxTotal_body)}}</td>
                    <td>{{rupiah($netTotal_body)}}</td>
                    <td>{{rupiah($freePPNTotal_body)}}</td>
                    <td>{{rupiah($ppnDTPTotal_body)}}</td>
                    <td>{{rupiah($hppTotal_body)}}</td>
                    <td>{{rupiah($marginTotal_body)}}</td>
                    <td>{{percent($percentageTotal_body)}}</td>
                </tr>
                @php
                    $grossTotal_body = 0;
                    $taxTotal_body = 0;
                    $netTotal_body = 0;
                    $freePPNTotal_body = 0;
                    $ppnDTPTotal_body = 0;
                    $hppTotal_body = 0;
                    $marginTotal_body = 0;
                    $percentageTotal_body = 0;
                @endphp
                {{-- KALAU SAMA MAKA DITOTAL DAN KODE DEPARTEMENT DAN NAMA DEPARTEMENT DI SIMPAN DI VARIABLE --}}
            @endif


            {{-- <tr>
                content diantara food division hingga total division
                <td style="width: 20px; text-align: left">{{$data[$i]->cdept}}</td>
                <td style="width: 185px; text-align: left">{{$data[$i]->dep_namadepartement}}</td>
                <td>{{rupiah($data[$i]->ngross)}}</td>
                @if($data[$i]->fdfbkp == 'Y')
                    <td>{{rupiah($data[$i]->ntax)}}</td>
                    <td>{{number_format("0",2)}}</td>
                    <td>{{number_format("0",2)}}</td>
                @endif
                @if($data[$i]->fdfbkp == 'P')
                    <td>{{number_format("0",2)}}</td>
                    <td>{{rupiah($data[$i]->ntax)}}</td>
                    <td>{{number_format("0",2)}}</td>
                @endif
                @if($data[$i]->fdfbkp == 'W' || $data[$i]->fdfbkp == 'G')
                    <td>{{number_format("0",2)}}</td>
                    <td>{{number_format("0",2)}}</td>
                    <td>{{rupiah($data[$i]->ntax)}}</td>
                @endif
                <td>{{rupiah($data[$i]->nnet)}}</td>
                <td>{{rupiah($data[$i]->nhpp)}}</td>
                <td>{{rupiah($data[$i]->nmargin)}}</td>
                <td>{{percent($cf_nmargin[$i])}}</td>
            </tr> --}}
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
            $freePPNTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;

            for($j=sizeof($data)-1;$j>(sizeof($data)-$counterDiv)-1;$j--){
                $grossTotal = $grossTotal + $data[$j]->ngross;
                $taxTotal = $taxTotal + $data[$j]->ntax;
                if($data[$j]->fdfbkp == 'Y')
                {
                    $taxTotal = $taxTotal + $data[$j]->ntax;
                }
                else if($data[$j]->fdfbkp == 'P')
                {
                    $freePPNTotal = $freePPNTotal + $data[$j]->ntax;
                }
                else {
                    $ppnDTPTotal = $ppnDTPTotal + $data[$j]->ntax;
                }
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
                    $percentageTotal = "0.00";
                }
            }
            $percentageTotal = round($percentageTotal, 2);
            $counterDiv = 0;
            ?>

            <tr>
                {{-- total khusus fast food doang --}}
                <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($freePPNTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($ppnDTPTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{percent($percentageTotal)}}</td>
            </tr>

            {{--GRAND TOTAL--}}
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL COUNTER</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['c'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">&nbsp;&nbsp;TOTAL BARANG KENA PAJAK</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['p'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG TIDAK KENA PAJAK</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['x'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG KENA CUKAI</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['k'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG BEBAS PPN</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['b'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG EXPORT</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['e'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG PPN DITANGGUNG PEMERINTAH</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['g'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL DEPARTEMEN 43</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['f'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">GRAND TOTAL (TANPA DEPT 40)</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['total']-$gross['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['total']-$tax['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['total']-$net['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['total']-$hpp['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['total']-$margin['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['tminp'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">GRAND TOTAL (+ DEPT 40)</td>
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
