{{--NOTE :
Perubahan kulakukan untuk menyamakan dengan hasil laporan sesuai dengan yang kulihat, ku tidak tahu kenapa kenapa harus ada kondisi ini, tapi hasil laporannya begitu, ya begimana lagi
1. data perdivisi hanya menampilkan data dimana "omisbu == 'I'", kalau ingin menampilkan semua hapus semua kondisi dimana "omisbu == 'I'", harusnya ada 3
2. {{$data[$i]->namasbu}} : {{$data[$i]->omidiv}} {{$namaomi}} tidak ditampilkan
--}}

@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-PENJUALAN PER DEPARTEMEN
@endsection

@section('title')
    LAPORAN PENJUALAN PER DEPARTEMEN
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
{{--        margin-top: 85px;--}}
{{--        margin-bottom: 0px;--}}
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
{{--    <div style="margin-top: -20px;font-size: 12px ;line-height: 0.1px !important;">--}}
{{--        <p>{{$data[0]->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$data[0]->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="position: absolute; left: 590px; top: -17px">--}}
{{--        <span>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TGL : {{$today}} <br> PRG  : IDGP69E</span>--}}
{{--    </div>--}}
{{--    <div style="float:right; margin-top: 0px;">--}}
{{--        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>--}}
{{--        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>--}}
{{--        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>--}}
{{--    </div>--}}
{{--    <div style="float: center; line-height: 0.1 !important;">--}}
{{--        <h2 style="text-align: center">LAPORAN PENJUALAN</h2>--}}
{{--        <h2 style="text-align: center">PER DEPARTEMEN</h2>--}}
{{--        <h4 style="text-align: center;">{{$keterangan}}</h4>--}}
{{--        <h4 style="text-align: center">{{$periode}}</h4>--}}
{{--    </div>--}}
{{--</header>--}}
<?php
//rupiah formatter (no Rp or .00)
function rupiah($angka){
    //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,2,'.',',');
    return $hasil_rupiah;
}
function percent($angka){
    $hasil_rupiah = number_format($angka,2,'.',',');
    return $hasil_rupiah;
}
?>

<?php
$counterDiv = 0;
$omidiv = $data[0]->omidiv;
$divisi = '';
$divisiFooter = $data[0]->div_namadivisi;

?>
<table class="table table-bordered table-responsive" style="border-collapse: collapse;">
    <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
    <tr>
        <th rowspan="2" colspan="2" style="text-align: left; vertical-align: middle;">DEPARTEMEN</th>
        <th rowspan="2" style="text-align: right; vertical-align: middle; width: 100px;">PENJUALAN KOTOR</th>
        <th rowspan="2" style="text-align: right; vertical-align: middle;  width: 80px;">PAJAK</th>
        <th rowspan="2" style="text-align: right; vertical-align: middle; width: 100px;">PENJUALAN BERSIH</th>
        <th rowspan="2" style="text-align: right; vertical-align: middle; width: 100px;">H.P.P RATA2</th>
        <th colspan="2" style="text-align: right;">------MARGIN------</th>
    </tr>
    <tr>
        <td style="width: 80px; text-align: right;">Rp.</td>
        <td style="width: 20px; text-align: right;">%</td>
    </tr>
    </thead>
    <tbody style="border-bottom: 3px solid black; text-align: right">
    @for($i=0;$i<sizeof($data);$i++)
        {{--HEADER--}}
            @if($divisi != $data[$i]->div_namadivisi)
                <?php
                $divisi = $data[$i]->div_namadivisi;
                ?>
                <tr>
                    <td colspan="9" style="text-align: left; font-weight: bold;font-size: 15px;">{{$data[$i]->div_namadivisi}} Division</td>
                </tr>
            @endif
        {{--BODY--}}
        @if($data[$i]->omisbu == 'I')
            <tr>
                <td style="width: 20px; text-align: left">{{$data[$i]->omidep}}</td>
                <td style="width: 200px; text-align: left">{{$data[$i]->dep_namadepartement}}</td>
                <td>{{rupiah($data[$i]->omiamt)}}</td>
                <td>{{rupiah($data[$i]->omitax)}}</td>
                <td>{{rupiah($data[$i]->ominet)}}</td>
                <td>{{rupiah($data[$i]->omihpp)}}</td>
                <td>{{rupiah($data[$i]->omimrg)}}</td>
                <td>{{percent($cf_nmargin[$i])}}</td>
            </tr>
        @endif
            <?php
                $counterDiv++;
            ?>
        @if($i+1 < sizeof($data))
            @if($divisiFooter != $data[$i+1]->div_namadivisi)
                <?php
                    $divisiFooter = $data[$i+1]->div_namadivisi;
                    $grossTotal = 0;
                    $taxTotal = 0;
                    $netTotal = 0;
                    $hppTotal = 0;
                    $marginTotal = 0;
                    $percentageTotal = 0;

                    for($j=$i;$j>($i-$counterDiv);$j--){
                        if($data[$j]->omisbu == 'I'){
                            $grossTotal = $grossTotal + $data[$j]->omiamt;
                            $taxTotal = $taxTotal + $data[$j]->omitax;
                            $netTotal = $netTotal + $data[$j]->ominet;
                            $hppTotal = $hppTotal + $data[$j]->omihpp;
                            $marginTotal = $marginTotal + $data[$j]->omimrg;
                        }
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
                    <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">SUB TOTAL</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                    <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{percent($percentageTotal)}}</td>
                </tr>
            @endif
        @endif
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
                if($data[$j]->omisbu == 'I'){
                    $grossTotal = $grossTotal + $data[$j]->omiamt;
                    $taxTotal = $taxTotal + $data[$j]->omitax;
                    $netTotal = $netTotal + $data[$j]->ominet;
                    $hppTotal = $hppTotal + $data[$j]->omihpp;
                    $marginTotal = $marginTotal + $data[$j]->omimrg;
                }
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
                <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">SUB TOTAL</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{percent($percentageTotal)}}</td>
            </tr>

{{--GRAND TOTAL BRUH!--}}
        <tr>
            <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">TOTAL SELURUH OMI</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($gross['o'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($tax['o'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($net['o'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($hpp['o'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($margin['o'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{percent($marginpersen['o'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">TOTAL SELURUH INDOMARET</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($gross['i'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($tax['i'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($net['i'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($hpp['i'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($margin['i'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{percent($marginpersen['i'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; font-weight: bold; border-bottom: 1px solid black;">TOTAL INDOMARET + OMI</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($gross['total'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($tax['total'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($net['total'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($hpp['total'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($margin['total'])}}</td>
            <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{percent($marginpersen['total'])}}</td>
        </tr>
        </tbody>
    </table>

{{--    <p style="float: right">**Akhir dari Laporan**</p>--}}

{{--</body>--}}
{{--</html>--}}
@endsection
