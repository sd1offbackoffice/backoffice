@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN CASH BACK / EVENT / ITEM
@endsection

@section('title')
    ** LAPORAN CASH BACK PER EVENT PROMOSI PER ITEM **
@endsection

@section('subtitle')
    Tanggal: {{$date1}} s/d {{$date2}}
@endsection

@section('content')
{{--<html>--}}
{{--<head>--}}
{{--    <title>LAPORAN-CASH BACK / SUPPLIER / ITEM</title>--}}
{{--</head>--}}
{{--<script src={{asset('/js/sweetalert2.js')}}></script>--}}
{{--<script src={{asset('/js/jquery.js')}}></script>--}}
{{--<script src="{{asset('/js/jquery-ui.js')}}"></script>--}}
{{--<script>--}}
{{--    $(document).ready(function() {--}}
{{--        swal.fire('', "Tekan Ctrl+P untuk print !!", 'warning');--}}
{{--    });--}}
{{--</script>--}}
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
{{--        margin-top: 120px;--}}
{{--        margin-bottom: 10px;--}}
{{--        font-size: 9px;--}}
{{--        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;--}}
{{--        font-weight: 400;--}}
{{--        line-height: 1.8;--}}
{{--        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/--}}
{{--    }--}}

{{--    /** Define the header rules **/--}}
{{--    header {--}}
{{--        position: absolute;--}}
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
{{--<?php--}}
{{--$i = 1;--}}
{{--$datetime = new DateTime();--}}
{{--$timezone = new DateTimeZone('Asia/Jakarta');--}}
{{--$datetime->setTimezone($timezone);--}}
{{--?>--}}
{{--<header>--}}
{{--    <div style="line-height: 0.1px !important;">--}}
{{--        <p>{{$data[0]->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$data[0]->prs_namacabang}}</p>--}}
{{--        <p>{{$data[0]->prs_namawilayah}}</p>--}}
{{--    </div>--}}
{{--    <div style="float: right; margin-top: -22px; line-height: 0.1px !important;">--}}
{{--        <p>TGL : {{$today}} &nbsp; PRG : LSTCSB</p>--}}
{{--        <p>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>--}}
{{--    </div>--}}

{{--    <div style="margin-top: 35px; line-height: 0.1 !important;">--}}
{{--        <h2 style="text-align: center">** LAPORAN CASH BACK PER EVENT PROMOSI PER ITEM **</h2>--}}
{{--        <h4 style="text-align: center">Tanggal: {{$date1}} s/d {{$date2}}</h4>--}}
{{--    </div>--}}
{{--</header>--}}

<?php
//rupiah formatter (no Rp or .00)
function rupiah($angka){
    //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,0,'.',',');
    return $hasil_rupiah;
}
?>

    <table class="table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="2" style="width: 70px; border-right: 1px solid black; border-bottom: 1px solid black">Kd PLU</th>
                <th rowspan="2" style="width: 380px; border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Deskripsi</th>
                <th rowspan="2" style="width: 70px; border-right: 1px solid black; border-bottom: 1px solid black">Supplier</th>
                <th rowspan="2" style="width: 300px; border-right: 1px solid black;border-bottom: 1px solid black; text-align: left">Nama Supplier</th>
                <th colspan="2" style="border-right: 1px solid black;border-bottom: 1px solid black">Sales</th>
                <th colspan="2" style="border-bottom: 1px solid black">Refund</th>
            </tr>
            <tr>
                <th style="width: 50px; border-right: 1px solid black;">Qty</th>
                <th style="width: 100px; border-right: 1px solid black;">Nilai</th>
                <th style="width: 50px; border-right: 1px solid black;">Qty</th>
                <th style="width: 100px">Nilai</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black; text-align: center; vertical-align: center">
        <?php
            $kode = '';
            $cDeskripsi = '';
            $nilaiSales = 0;
            $nilaiRefund = 0;
            $totalSales = 0;
            $totalRefund = 0;
        ?>
        @for($i=0;$i<sizeof($data);$i++)
            <?php
            $awal = new DateTime($data[$i]->cbh_tglawal);
            $strip = $awal->format('d/m/Y');
            $akhir = new DateTime($data[$i]->cbh_tglakhir);
            $strip2 = $akhir->format('d/m/Y');
            ?>
            @if($kode != $data[$i]->cbh_kodepromosi)
                @if($i != 0)
                    <tr style="font-weight: bold">
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td style="text-align: right">Total Per Event</td>
                        <td colspan="2" style="text-align: right">{{rupiah($nilaiSales)}}</td>
                        <td colspan="2" style="text-align: right">{{rupiah($nilaiRefund)}}</td>
                    </tr>
                @endif
                <tr>
                    <td>{{$data[$i]->cbh_kodepromosi}}</td>
                    <td>{{$data[$i]->cbh_kodeperjanjian}}</td>
                    <td> </td>
                    <td style="text-align: left"> {{$data[$i]->cbh_namapromosi}}</td>
                    <td colspan="4">({{$strip}} S/D {{$strip2}})</td>
                </tr>
                <?php
                $kode = $data[$i]->cbh_kodepromosi;
                $totalSales = $totalSales + $nilaiSales;
                $totalRefund = $totalRefund + $nilaiRefund;
                $nilaiSales = 0;
                $nilaiRefund = 0;
                ?>
            @endif
            @if($data[$i]->prd_deskripsipanjang == null || $data[$i]->prd_deskripsipanjang == '')
                <?php
                    $cDeskripsi = 'CASHBACK GABUNGAN';
                ?>
            @else
                <?php
                $cDeskripsi = $data[$i]->prd_deskripsipanjang;
                ?>
            @endif
            <tr>
                <td>{{$data[$i]->plu}}</td>
                <td style="text-align: left">{{$cDeskripsi}}</td>
                <td>{{$data[$i]->sup_kodesupplier}}</td>
                <td style="text-align: left">{{$data[$i]->sup_namasupplier}}</td>
                <td style="text-align: right">{{$data[$i]->qtysls}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->nilsls)}}</td>
                <td style="text-align: right">{{$data[$i]->qtyref}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->nilref)}}</td>
            </tr>
            <?php
            $nilaiSales = $nilaiSales + ($data[$i]->nilsls);
            $nilaiRefund = $nilaiRefund + ($data[$i]->nilref);
            ?>
        @endfor
        <tr style="font-weight: bold">
            <td> </td>
            <td> </td>
            <td> </td>
            <td style="text-align: right">Total Per Event</td>
            <td colspan="2" style="text-align: right">{{rupiah($nilaiSales)}}</td>
            <td colspan="2" style="text-align: right">{{rupiah($nilaiRefund)}}</td>
        </tr>
        <?php
        $totalSales = $totalSales + $nilaiSales;
        $totalRefund = $totalRefund + $nilaiRefund;
        ?>
        <tr style="font-weight: bold; border-top: 1px solid black">
            <td style="border-top: 1px solid black"> </td>
            <td style="border-top: 1px solid black"> </td>
            <td style="border-top: 1px solid black"> </td>
            <td style="text-align: right; border-top: 1px solid black">Grand Total</td>
            <td colspan="2" style="text-align: right; border-top: 1px solid black">{{rupiah($totalSales)}}</td>
            <td colspan="2" style="text-align: right; border-top: 1px solid black">{{rupiah($totalRefund)}}</td>
        </tr>
        </tbody>
    </table>
{{--    <p style="float: right; line-height: 0.1px !important;">** AKHIR LAPORAN **</p>--}}

{{--</body>--}}

{{--</html>--}}
@endsection
