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

@section('content')
{{--<html>--}}
{{--<head>--}}
{{--    <title>LAPORAN-PENJUALAN PER DEPARTEMEN</title>--}}
{{--</head>--}}
{{--<style>--}}
{{--    /**--}}
{{--        Set the margins of the page to 0, so the footer and the header--}}
{{--        can be of the full height and width !--}}
{{--     **/--}}
{{--    @page {--}}
{{--        margin: 25px 25px;--}}
{{--    }--}}

{{--    /** Define now the real margins of every page in the PDF **/--}}
{{--    body {--}}
{{--        margin-top: 75px;--}}
{{--        margin-bottom: 10px;--}}
{{--        font-size: 9px;--}}
{{--        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;--}}
{{--        font-weight: 400;--}}
{{--        line-height: 1.8;--}}
{{--        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/--}}
{{--    }--}}

{{--    /** Define the header rules **/--}}
{{--    header {--}}
{{--        position: fixed;--}}
{{--        top: 0cm;--}}
{{--        left: 0cm;--}}
{{--        right: 0cm;--}}
{{--        height: 2cm;--}}
{{--    }--}}
{{--    table{--}}
{{--        border: 1px;--}}
{{--    }--}}
{{--    .page-break {--}}
{{--        page-break-after: always;--}}
{{--    }--}}
{{--    .page-numbers:after { content: counter(page); }--}}
{{--</style>--}}
{{--<body>--}}
{{--<!-- Define header and footer blocks before your content -->--}}

{{--<header>--}}
{{--    <div style="float:left; margin-top: 0px; line-height: 8px !important;">--}}
{{--        <p>--}}
{{--            {{ $data[0]->prs_namaperusahaan }}--}}
{{--        </p>--}}
{{--        <p>--}}
{{--            {{ $data[0]->prs_namacabang }}--}}
{{--        </p>--}}
{{--    </div>--}}
{{--    <div style="margin-top: -20px; line-height: 0.1px !important;">--}}
{{--        <p>{{$data[0]->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$data[0]->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="position: absolute; top: -13px; left: 580px">--}}
{{--        <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL : {{$today}} <br> PRG  : IDGP69E</span>--}}
{{--    </div>--}}
{{--    <div style="float:right; margin-top: 0px;">--}}
{{--        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>--}}
{{--        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>--}}
{{--        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>--}}
{{--    </div>--}}
{{--    <div style="float: center; line-height: 0.1 !important;">--}}
{{--        <h2 style="text-align: center">{{$data[0]->title}}</h2>--}}
{{--        <h2 style="text-align: center">PER DEPARTEMEN</h2>--}}
{{--        <h4 style="text-align: center">{{$keterangan}}</h4>--}}
{{--        <h4 style="text-align: center">{{$periode}}</h4>--}}
{{--    </div>--}}
{{--</header>--}}

<?php
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
?>

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th rowspan="2" colspan="2" style="text-align: left; vertical-align: middle;">DEPARTEMEN</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 100px;">PENJUALAN KOTOR</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 80px;">PAJAK</th>
                <th rowspan="2" style="text-align: right; vertical-align: middle; width: 100px;">PENJUALAN BERSIH</th>
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

            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;
        ?>
        @for($i=0;$i<sizeof($data);$i++)
        {{--TOTAL PER DIVISI--}}
            @if($i!=0)
                @if($divisi != $data[$i]->cdiv)

                    <?php
                    $grossTotal = 0;
                    $taxTotal = 0;
                    $netTotal = 0;
                    $hppTotal = 0;
                    $marginTotal = 0;
                    $percentageTotal = 0;

                    for($j=$i-1;$j>($i-$counterDiv-1);$j--){
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
                            $percentageTotal = "0.00";
                        }
                    }
                    $percentageTotal = round($percentageTotal, 2);
                    $counterDiv = 0;
                    ?>

                    <tr>
                        <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
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
                    <td colspan="9" style="text-align: left; font-weight: bold;font-size: 15px;">{{$data[$i]->div_namadivisi}} Division</td>
                </tr>
            @endif
        {{--BODY--}}
            <tr>
                <td style="width: 20px; text-align: left">{{$data[$i]->cdept}}</td>
                <td style="width: 185px; text-align: left">{{$data[$i]->dep_namadepartement}}</td>
                <td>{{rupiah($data[$i]->ngross)}}</td>
                <td>{{rupiah($data[$i]->ntax)}}</td>
                <td>{{rupiah($data[$i]->nnet)}}</td>
                <td>{{rupiah($data[$i]->nhpp)}}</td>
                <td>{{rupiah($data[$i]->nmargin)}}</td>
                <td>{{percent($cf_nmargin[$i])}}</td>
            </tr>
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
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;

            for($j=sizeof($data)-1;$j>(sizeof($data)-$counterDiv)-1;$j--){
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
                    $percentageTotal = "0.00";
                }
            }
            $percentageTotal = round($percentageTotal, 2);
            $counterDiv = 0;
            ?>

            <tr>
                <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
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
            <td colspan="2" style="text-align: right; font-weight: normal;">TOTAL BRG PPN DIBYR PMERINTH (MINYAK)</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['g'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['g'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; font-weight: normal;">TOTAL BRG PPN DIBYR PMERINTH (TEPUNG)</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($gross['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($tax['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($net['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($hpp['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{rupiah($margin['r'])}}</td>
            <td style="text-align: right; font-weight: bold;">{{percent($marginpersen['r'])}}</td>
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
{{--    <p style="float: right">**Akhir dari Laporan**</p>--}}

{{--</body>--}}
{{--</html>--}}
@endsection
