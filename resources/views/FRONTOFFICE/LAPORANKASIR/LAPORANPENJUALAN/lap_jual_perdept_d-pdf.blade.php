@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-PENJUALAN PER DEPARTEMEN
@endsection

@section('title')
    LAPORAN PENJUALAN PER DEPARTEMEN
@endsection

@section('subtitle')
    {{$keterangan}}
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
{{--        margin-top: 10px;--}}
{{--        margin-bottom: 0px;--}}
{{--        font-size: 9px;--}}
{{--        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;--}}
{{--        font-weight: 400;--}}
{{--        line-height: 1.8;--}}
{{--        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/--}}
{{--    }--}}

{{--    /** Define the header rules **/--}}
{{--    header {--}}
{{--        /*position: fixed;*/--}}
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
{{--<script src={{asset('/js/jquery.js')}}></script>--}}
{{--<script src={{asset('/js/sweetalert.js')}}></script>--}}
{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        swal('Information', 'Tekan Ctrl+P untuk print!', 'info');--}}
{{--    });--}}
{{--</script>--}}
{{--<body>--}}
<!-- Define header and footer blocks before your content -->
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
    if(sizeof($data)!=0){
        $counterDiv = 0;
        $headeromikod = '';
        $omikod = $data[0]->omikod;
        $divisi = '';
        $divisiFooter = $data[0]->div_namadivisi;

        $grossSbu = 0;
        $taxSbu = 0;
        $netSbu = 0;
        $hppSbu = 0;
        $marginSbu = 0;
        $percentageSbu = 0;
    }else{
        $counterDiv = 0;
        $headeromikod = '';
        $omikod = '';
        $divisi = '';
        $divisiFooter = '';

        $grossSbu = 0;
        $taxSbu = 0;
        $netSbu = 0;
        $hppSbu = 0;
        $marginSbu = 0;
        $percentageSbu = 0;
    }

?>

{{--            <header>--}}
{{--                <div style="font-size: 12px ;line-height: 0.1px !important;">--}}
{{--                    <p>{{$data[0]->prs_namaperusahaan}}</p>--}}
{{--                    <p>{{$data[0]->prs_namacabang}}</p>--}}
{{--                </div>--}}
{{--                <div style="float: right; margin-top: -38px">--}}
{{--                    <span>Tgl. Cetak : {{$today}}<br>Jam. Cetak : {{$time}}<br><i>User ID</i> : {{ $_SESSION['usid'] }}</span>--}}
{{--                </div>--}}
{{--                <div style="margin-top: 35px; line-height: 0.1 !important;">--}}
{{--                    <h2 style="text-align: center">LAPORAN PENJUALAN</h2>--}}
{{--                    <h2 style="text-align: center">PER DEPARTEMEN</h2>--}}
{{--                    <h4 style="text-align: center">{{$keterangan}}</h4>--}}
{{--                </div>--}}
{{--            </header>--}}
        @for($i=0;$i<sizeof($data);$i++)
            @if($headeromikod != $data[$i]->omikod)
                <?php
                $headeromikod = $data[$i]->omikod;
                ?>
            <table class="table table-bordered table-responsive" style="border-collapse: collapse;">
                <thead style="border-bottom: 3px solid black; text-align: center">
                <tr>
                    <th colspan="3" style="text-align: left; border-bottom: 2px solid black;">{{$periode}}</th>
                    <th colspan="5" style="text-align: right; border-bottom: 2px solid black">{{$data[$i]->namasbu}} : {{$data[$i]->omikod}} {{$data[$i]->namaomi}}</th>
                </tr>
                <tr style="text-align: center; vertical-align: center">
                    <th colspan="2" style="text-align: left; border-right: 1px solid black; border-bottom: 1px solid black;">DEPARTEMEN</th>
                    <th style="width: 100px;border-right: 1px solid black; border-bottom: 1px solid black">PENJUALAN KOTOR</th>
                    <th style="width: 80px; border-right: 1px solid black; border-left: 1px solid black;">PAJAK</th>
                    <th style="width: 100px; border-right: 1px solid black; border-left: 1px solid black;">PENJUALAN BERSIH</th>
                    <th style="width: 100px;border-right: 1px solid black; border-left: 1px solid black;">H.P.P RATA2</th>
                    <th colspan="2" style="border-left: 1px solid black;">------MARGIN------</th>
                </tr>
                </thead>
                <tbody style="border-bottom: 3px solid black; text-align: right">
        @endif
        <?php
            $grossTotal = 0;
            $taxTotal = 0;
            $netTotal = 0;
            $hppTotal = 0;
            $marginTotal = 0;
            $percentageTotal = 0;
        ?>

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
            <tr>
                <td style="width: 20px; text-align: left">{{$data[$i]->omidep}}</td>
                <td style="width: 225px; text-align: left">{{$data[$i]->dep_namadepartement}}</td>
                <td>{{rupiah($data[$i]->omiamt)}}</td>
                <td>{{rupiah($data[$i]->omitax)}}</td>
                <td>{{rupiah($data[$i]->ominet)}}</td>
                <td>{{rupiah($data[$i]->omihpp)}}</td>
                <td style="width: 80px">{{rupiah($data[$i]->omimrg)}}</td>
                <td style="width: 20px">{{percent($cf_nmargin[$i])}}</td>
            </tr>
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
                        $grossTotal = $grossTotal + $data[$j]->omiamt;
                        $taxTotal = $taxTotal + $data[$j]->omitax;
                        $netTotal = $netTotal + $data[$j]->ominet;
                        $hppTotal = $hppTotal + $data[$j]->omihpp;
                        $marginTotal = $marginTotal + $data[$j]->omimrg;
                    }
                    $grossSbu = $grossSbu + $grossTotal;
                    $taxSbu = $taxSbu + $taxTotal;
                    $netSbu = $netSbu + $netTotal;
                    $hppSbu = $hppSbu + $hppTotal;
                    $marginSbu = $marginSbu + $marginTotal;
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
                    <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{percent($percentageTotal)}}</td>
                </tr>
            @endif
            @if($omikod != $data[$i+1]->omikod)
                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL PER INDOMARET ({{$data[$i]->omikod}})</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginSbu)}}</td>
                    <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">
                        <?php
                        if($netSbu != 0){
                            $calculator = ($marginSbu/$netSbu)*100;
                        }else{
                            if($marginSbu != 0){
                                $calculator = 100;
                            }else{
                                $calculator = 0;
                            }
                        }
                        echo percent($calculator);
                        ?>
                    </td>
                </tr>
                <?php
                $omikod = $data[$i+1]->omikod;

                $grossSbu = 0;
                $taxSbu = 0;
                $netSbu = 0;
                $hppSbu = 0;
                $marginSbu = 0;
                $percentageSbu = 0;
                ?>
                </tbody>
                </table><br>
{{--            <div class="page-break">  </div>--}}
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
                $grossTotal = $grossTotal + $data[$j]->omiamt;
                $taxTotal = $taxTotal + $data[$j]->omitax;
                $netTotal = $netTotal + $data[$j]->ominet;
                $hppTotal = $hppTotal + $data[$j]->omihpp;
                $marginTotal = $marginTotal + $data[$j]->omimrg;
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
                <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL PER DIVISI</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($grossTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($taxTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($netTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hppTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($marginTotal)}}</td>
                <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{percent($percentageTotal)}}</td>
            </tr>
        </tbody>
    </table>
    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-bottom: 3px solid black; text-align: center">
        <tr style="text-align: center; vertical-align: center">
            <th colspan="2" style="text-align: left; border-right: 1px solid black; border-bottom: 1px solid black;"></th>
            <th style="width: 100px;border-right: 1px solid black; border-bottom: 1px solid black"></th>
            <th style="width: 80px; border-right: 1px solid black; border-left: 1px solid black;"></th>
            <th style="width: 100px; border-right: 1px solid black; border-left: 1px solid black;"></th>
            <th style="width: 100px;border-right: 1px solid black; border-left: 1px solid black;"></th>
            <th colspan="2" style="border-left: 1px solid black;"></th>
        </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: right">
        <tr>
            <td colspan="2" style="width: 300px; text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL SELURUH OMI</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($gross['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($tax['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($net['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hpp['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($margin['o'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{percent($marginpersen['o'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL SELURUH INDOMARET</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($gross['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($tax['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($net['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hpp['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($margin['i'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{percent($marginpersen['i'])}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: left; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">TOTAL SELURUH INDOMARET</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($gross['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($tax['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($net['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($hpp['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{rupiah($margin['total'])}}</td>
            <td style="text-align: right; font-weight: bold;font-size: 10px; border-bottom: 1px solid black;">{{percent($marginpersen['total'])}}</td>
        </tr>
        </tbody>
    </table>

    <hr>
{{--    <p style="float: right">**Akhir dari Laporan**</p>--}}

{{--</body>--}}
{{--</html>--}}
@endsection

