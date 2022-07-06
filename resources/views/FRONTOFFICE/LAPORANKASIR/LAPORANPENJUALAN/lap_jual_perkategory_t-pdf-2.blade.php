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
            $divisi_name = '';
            $departemen = '';

            $qty_body = 0;
            $gross_body = 0;
            $tax_body = 0;
            $freePPN_body = 0;
            $ppnDTP_body = 0;
            $net_body = 0;
            $hpp_body = 0;
            $margin_body = 0;
            $percentage_body = 0;
            $temp_cf_margin = 0;

            $qtyTotal_departement = 0;   
            $grossTotal_departement = 0;
            $taxTotal_departement = 0;
            $netTotal_departement = 0;
            $freePPNTotal_departement = 0;
            $ppnDTPTotal_departement = 0;
            $hppTotal_departement = 0;
            $marginTotal_departement = 0;
            $percentageTotal_departement = 0;

            $qtyTotal_divisi = 0;   
            $grossTotal_divisi = 0;
            $taxTotal_divisi = 0;
            $netTotal_divisi = 0;
            $freePPNTotal_divisi = 0;
            $ppnDTPTotal_divisi = 0;
            $hppTotal_divisi = 0;
            $marginTotal_divisi = 0;
            $percentageTotal_divisi = 0;

            $qtyTotal = 0;
            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;
        ?>
        @for($i=0;$i<sizeof($data);$i++)
            {{--HEADER 1--}}
            @if($divisi != $data[$i]->fdkdiv)
                {{-- JIKA KODE DIVISI DENGAN INDEX I TIDAK SAMA DENGAN KOSONG OR TIDAK SAMA DENGAN DATA YANG DITAMPUNG DI DIVISI SELANJUTNYA MAKA PRINT  --}}
                <?php
                $divisi = $data[$i]->fdkdiv;
                ?>
                <tr>
                    <td colspan="11" style="text-align: left; font-weight: bold;font-size: 15px;">** DIVISI {{$data[$i]->fdkdiv}} - {{$data[$i]->div_namadivisi}}</td>
                </tr>
            @endif

            @if($departemen != $data[$i]->fdkdep)
                {{-- JIKA NAMA DEPARTEMENT TIDAK SAMA DENGAN NULL MAKAN DATA AKAN DI PRINT --}}
                {{-- JIKA DATA NEXT TIDAK SAMA DENGAN DATA YANG SEDANG DI SIMPAN DI $DEPARTEMENT MAKA DI PRINT --}}
                <?php
                $departemen = $data[$i]->fdkdep;
                ?>
                <tr>
                    <td colspan="11" style="text-align: left; font-weight: bold;font-size: 11px;">&nbsp;&nbsp;*DEPARTEMEN {{$data[$i]->fdkdep}} - {{$data[$i]->dep_namadepartement}}</td>
                </tr>
            @endif

            {{-- BODY --}}
            @php
                $tempKodeKategori = $data[$i]->fdkatb;
                $tempKategori = $data[$i]->kat_namakategori;
                $qty_body = $qty_body + $data[$i]->ktqty;
                $gross_body = $gross_body + $data[$i]->ngross;
                if($data[$i]->fdfbkp == 'Y')
                {
                    $tax_body = $tax_body + $data[$i]->ntax;
                }
                else if($data[$i]->fdfbkp == 'P')
                {
                    $freePPN_body = $freePPN_body + $data[$i]->ntax;
                }
                else if($data[$i]->fdfbkp == 'G'){
                    $ppnDTP_body = $ppnDTP_body + $data[$i]->ntax;
                }
                $net_body = $net_body + $data[$i]->nnet;
                $hpp_body = $hpp_body + $data[$i]->nhpp;
                $margin_body = $margin_body + $data[$i]->nmargin;
                if($net_body != 0){
                    $percentage_body = $margin_body*100/$net_body;
                }else{
                    if($margin_body != 0){
                        $percentage_body = 100;
                    }else{
                        $percentage_body = 0;
                    }
                }
                $percentage_body = round($percentage_body, 2);
                $temp_cf_margin = $cf_nmargin[$i];
            @endphp

            @if(isset($data[$i+1]) && ($tempKategori != $data[$i+1]->kat_namakategori) || !(isset($data[$i+1])) )
                <tr>
                    <td style="width: 20px; text-align: left">{{$tempKodeKategori}}</td>
                    <td style="width: 158px; text-align: left">{{$tempKategori}}</td>
                    @if($qty == 'Y')
                        <td>{{$qty_body}}</td>
                    @else
                        <td> </td>
                    @endif
                    <td>{{rupiah($gross_body)}}</td>
                    <td>{{rupiah($tax_body)}}</td>
                    <td>{{rupiah($freePPN_body)}}</td>
                    <td>{{rupiah($ppnDTP_body)}}</td>
                    <td>{{rupiah($net_body)}}</td>
                    <td>{{rupiah($hpp_body)}}</td>
                    <td>{{rupiah($margin_body)}}</td>
                    <td>{{percent($temp_cf_margin)}}</td>
                </tr>
                @php
                    $qty_body = 0;
                    $gross_body = 0;
                    $tax_body = 0;
                    $freePPN_body = 0;
                    $ppnDTP_body = 0;
                    $net_body = 0;
                    $hpp_body = 0;
                    $margin_body = 0;
                    $percentage_body = 0;
                    $temp_cf_margin = 0;
                @endphp
                {{-- KALAU SAMA MAKA DITOTAL DAN KODE DEPARTEMENT DAN NAMA DEPARTEMENT DI SIMPAN DI VARIABLE --}}
            @endif
            
            {{-- CALCULATE TOTAL PER DEPARTEMENT  --}}
            <?php  
                $departement_name =  $data[$i]->dep_namadepartement;
                $qtyTotal_departement = $qtyTotal_departement + $data[$i]->ktqty;
                $grossTotal_departement = $grossTotal_departement + $data[$i]->ngross;
                if($data[$i]->fdfbkp == 'Y')
                {
                    $taxTotal_departement = $taxTotal_departement + $data[$i]->ntax;
                }
                else if($data[$i]->fdfbkp == 'P')
                {
                    $freePPNTotal_departement = $freePPNTotal_departement + $data[$i]->ntax;
                }
                else {
                    $ppnDTPTotal_departement = $ppnDTPTotal_departement + $data[$i]->ntax;
                }
                $netTotal_departement = $netTotal_departement + $data[$i]->nnet;
                $hppTotal_departement = $hppTotal_departement + $data[$i]->nhpp;
                $marginTotal_departement = $marginTotal_departement + $data[$i]->nmargin;
                    
                if($netTotal_departement != 0){
                    $percentageTotal_departement = $marginTotal_departement*100/$netTotal_departement;
                }else{
                    if($marginTotal_departement != 0){
                        $percentageTotal_departement = 100;
                    }else{
                        $percentageTotal_departement = 0;
                    }
                }
                $percentageTotal_departement = round($percentageTotal_departement, 2);
            ?>

            {{-- KALO NAMA DEPARTEMENT BEDA THEN PRINT --}}
            @if(isset($data[$i+1]) && ($departement_name != $data[$i+1]->dep_namadepartement) || !(isset($data[$i+1])) )
                <tr>
                    {{-- total setiap departement --}}
                    <td colspan="2" style="text-align: left; font-weight: bold;">TOTAL PER DEPARTEMEN</td>
                    @if($qty == 'Y')
                        <td style="text-align: right; font-weight: bold;">{{$qtyTotal_departement}}</td>
                    @else
                        <td style="border-bottom: 1px solid black"> </td>
                    @endif
                    <td style="text-align: right; font-weight: bold;">{{rupiah($grossTotal_departement)}}</td>
                    <td style="text-align: right; font-weight: bold;">{{rupiah($taxTotal_departement)}}</td>
                    <td style="text-align: right; font-weight: bold;">{{rupiah($freePPNTotal_departement)}}</td>
                    <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTPTotal_departement)}}</td>
                    <td style="text-align: right; font-weight: bold;">{{rupiah($netTotal_departement)}}</td>
                    <td style="text-align: right; font-weight: bold;">{{rupiah($hppTotal_departement)}}</td>
                    <td style="text-align: right; font-weight: bold;">{{rupiah($marginTotal_departement)}}</td>
                    <td style="text-align: right; font-weight: bold;">{{percent($percentageTotal_departement)}}</td>
                </tr>
                @php
                    $qtyTotal_departement = 0;   
                    $grossTotal_departement = 0;
                    $taxTotal_departement = 0;
                    $netTotal_departement = 0;
                    $freePPNTotal_departement = 0;
                    $ppnDTPTotal_departement = 0;
                    $hppTotal_departement = 0;
                    $marginTotal_departement = 0;
                    $percentageTotal_departement = 0;
                @endphp
            @endif

                
            {{-- CALCULATE TOTAL PER DIVISI --}}
            @php   
                $divisi_name = $data[$i]->div_namadivisi;
                $qtyTotal_divisi = $qtyTotal_divisi + $data[$i]->ktqty;
                $grossTotal_divisi = $grossTotal_divisi + $data[$i]->ngross;
                if($data[$i]->fdfbkp == 'Y')
                {
                    $taxTotal_divisi = $taxTotal_divisi + $data[$i]->ntax;
                }
                else if($data[$i]->fdfbkp == 'P')
                {
                    $freePPNTotal_divisi = $freePPNTotal_divisi + $data[$i]->ntax;
                }
                else {
                    $ppnDTPTotal_divisi = $ppnDTPTotal_divisi + $data[$i]->ntax;
                }
                $netTotal_divisi = $netTotal_divisi + $data[$i]->nnet;
                $hppTotal_divisi = $hppTotal_divisi + $data[$i]->nhpp;
                $marginTotal_divisi = $marginTotal_divisi + $data[$i]->nmargin;
                    
                if($netTotal_divisi != 0){
                    $percentageTotal_divisi = $marginTotal_divisi*100/$netTotal_divisi;
                }else{
                    if($marginTotal_divisi != 0){
                        $percentageTotal_divisi = 100;
                    }else{
                        $percentageTotal_divisi = 0;
                    }
                }
                $percentageTotal_divisi = round($percentageTotal_divisi, 2);
            @endphp

            {{-- KALO NAMA DIVSI BEDA THEN PRINT --}}
            @if(isset($data[$i+1]) && ($divisi_name != $data[$i+1]->div_namadivisi) || !(isset($data[$i+1])) )
                <tr>
                    {{-- total setiap divisi --}}
                    <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                    @if($qty == 'Y')
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black">{{$qtyTotal_divisi}}</td>
                    @else
                        <td style="border-bottom: 1px solid black"> </td>
                    @endif
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($grossTotal_divisi)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($taxTotal_divisi)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($freePPNTotal_divisi)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($ppnDTPTotal_divisi)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($netTotal_divisi)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($hppTotal_divisi)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($marginTotal_divisi)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{percent($percentageTotal_divisi)}}</td>
                </tr>
                @php
                    $qtyTotal_divisi = 0;   
                    $grossTotal_divisi = 0;
                    $taxTotal_divisi = 0;
                    $netTotal_divisi = 0;
                    $freePPNTotal_divisi = 0;
                    $ppnDTPTotal_divisi = 0;
                    $hppTotal_divisi = 0;
                    $marginTotal_divisi = 0;
                    $percentageTotal_divisi = 0;
                @endphp
            @endif
        @endfor

        {{-- GRAND TOTAL --}}
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL COUNTER</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['c'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['c'])}}</td>
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
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['p'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['p'])}}</td>
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
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['x'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['x'])}}</td>
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
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['k'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['k'])}}</td>
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
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['b'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['b'])}}</td>
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
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['e'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['e'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: normal;">TOTAL BARANG PPN DITANGGUNG PEMERINTAH</td>
            <td style="text-align: right; font-weight: bold;"></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['g'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL DEPARTEMEN 43</td>
            <td></td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['f'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['f'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">GRAND TOTAL (TANPA DEPT 40)</td>
            @if($qty == 'Y')
                <td style="text-align: right; font-weight: bold;">{{$qtygrandtotal-1}}</td>
            @else
                <td> </td>
            @endif
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['total']-$gross['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['total']-$tax['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['total']-$tax['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['total']-$tax['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['total']-$net['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['total']-$hpp['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['total']-$margin['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['total']-$marginpersen['d'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">GRAND TOTAL (+ DEPT 40)</td>
            @if($qty == 'Y')
                <td style="text-align: right; font-weight: bold;">{{$qtygrandtotal}}</td>
            @else
                <td> </td>
            @endif
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['total'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['total'])}}</td>
        </tr>
        </tbody>
    </table>
@endsection
