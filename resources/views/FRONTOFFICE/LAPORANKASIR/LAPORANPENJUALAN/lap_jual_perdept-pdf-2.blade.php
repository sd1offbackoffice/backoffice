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
        <thead style="border-top: 2px solid black;border-bottom:2px solid black">
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
            // dd($data);

            $divisi ='';

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
            $gross_body = 0;
            $tax_body = 0;
            $net_body = 0;
            $freePPN_body = 0;
            $ppnDTP_body = 0;
            $hpp_body = 0;
            $margin_body = 0;
            $percentage_body = 0;

            $grossTotal_divisi = 0;
            $taxTotal_divisi = 0;
            $netTotal_divisi = 0;
            $freePPNTotal_divisi = 0;
            $ppnDTPTotal_divisi = 0;
            $hppTotal_divisi = 0;
            $marginTotal_divisi = 0;
            $percentageTotal_divisi = 0;

            $total_data = count($data);
            // dd($total_data)
        ?>

        {{--TOTAL PER DIVISI--}}
        {{-- Alasan total diletakkan di atas header, karena kalo sudah $divisi != $data[$i+1]->cdiv, maka string dari $divisi akan berubah ke index selanjutnya --}}
        @for($i=0;$i<$total_data;$i++)

            {{--HEADER--}}
            {{-- kalo cdiv next tidak sama dengan cdiv index sekarang, maka print nama division --}}
            @if($divisi != $data[$i]->cdiv)
                <tr>
                    {{-- FOOD, NON FOOD --}}
                    <td colspan="10" style="text-align: left; font-weight: bold;font-size: 15px;">{{$data[$i]->div_namadivisi}} Division</td>
                </tr>
                {{-- setelah print maka divisi akan diganti dengan cdiv selanjutnya  --}}
                <?php
                    $divisi = $data[$i]->cdiv;
                ?>
            @endif

            {{-- calculate jumlah tiap departement, kalo beda maka akan di print --}}
            @php
                $temp_cdept = $data[$i]->cdept;
                $tempDepartement = $data[$i]->dep_namadepartement;
                $gross_body = $gross_body + $data[$i]->ngross;

                if($data[$i]->fdfbkp == 'Y')
                {
                    $tax_body = $tax_body + $data[$i]->ntax;
                }
                else if($data[$i]->fdfbkp == 'P')
                {
                    $freePPN_body = $freePPN_body + $data[$i]->ntax;
                }
                else {
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
                        $percentage_body = "0.00";
                    }
                }
                $percentage_body = round($percentage_body, 2);
            @endphp

            {{--BODY--}}
            {{-- KALAU DATA NEXT TIDAK NULL DAN NAMA DEPARTEMENT TIDAK SAMA DENGAN NAMA DEPARTEMENT YANG SELANJUTNYA --}}
            @if(isset($data[$i+1]) && ($tempDepartement != $data[$i+1]->dep_namadepartement) || !(isset($data[$i+1])) )
                <tr>
                    <td style="width: 20px; text-align: left">{{$temp_cdept}}</td>
                    <td style="width: 185px; text-align: left">{{$tempDepartement}}</td>
                    <td>{{rupiah($gross_body)}}</td>
                    <td>{{rupiah($tax_body)}}</td>
                    <td>{{rupiah($freePPN_body)}}</td>
                    <td>{{rupiah($ppnDTP_body)}}</td>
                    <td>{{rupiah($net_body)}}</td>
                    <td>{{rupiah($hpp_body)}}</td>
                    <td>{{rupiah($margin_body)}}</td>
                    <td>{{percent($percentage_body)}}</td>
                </tr>
                @php
                    $gross_body = 0;
                    $tax_body = 0;
                    $net_body = 0;
                    $freePPN_body = 0;
                    $ppnDTP_body = 0;
                    $hpp_body = 0;
                    $margin_body = 0;
                    $percentage_body = 0;
                @endphp
                {{-- KALAU SAMA MAKA DITOTAL DAN KODE DEPARTEMENT DAN NAMA DEPARTEMENT DI SIMPAN DI VARIABLE --}}
            @endif

            <?php
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
                        $percentageTotal_divisi = "0.00";
                    }
                }
                $percentageTotal_divisi = round($percentageTotal_divisi, 2);
            ?>


            @if(isset($data[$i+1]) && ($divisi != $data[$i+1]->cdiv) || !(isset($data[$i+1])) )
                <tr>
                    {{-- total setiap divisi --}}
                    <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
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

        {{--GRAND TOTAL--}}
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL COUNTER</td>
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
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['y'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['y'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['y'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['y'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['y'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['y'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['y'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['y'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG TIDAK KENA PAJAK</td>
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
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG EXPORT</td>
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
            <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL BARANG PPN DITANGGUNG PEMERINTAH</td>
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
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['total']-$gross['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['total']-$tax['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($freePPN['total']-$freePPN['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($ppnDTP['total']-$ppnDTP['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['total']-$net['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['total']-$hpp['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['total']-$margin['d'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['tminp'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: bold;">GRAND TOTAL (+ DEPT 40)</td>
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
