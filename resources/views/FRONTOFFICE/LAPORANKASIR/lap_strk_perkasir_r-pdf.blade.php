@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-REKAP STRUK PER / KASIR
@endsection

@section('title')
    ** REKAP STRUK PER / KASIR **
@endsection

@section('subtitle')
    Transaksi : Refund
@endsection

@section('content')

{{--<html>--}}
{{--<head>--}}
{{--    <title>LAPORAN-REKAP STRUK PER / KASIR</title>--}}
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
{{--        margin-top: 120px;--}}
{{--        margin-bottom: 10px;--}}
{{--        font-size: 11px;--}}
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
{{--    <div style="line-height: 0.1px !important;">--}}
{{--        <p>{{$data[0]->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$data[0]->prs_namacabang}}</p>--}}
{{--        <p>{{$data[0]->prs_namawilayah}}</p>--}}
{{--    </div>--}}
{{--    <div style="position: absolute; left: 645px; top: -8px">--}}
{{--        <span>TGL : {{$today}}<br>JAM : {{$time}}</span>--}}
{{--    </div>--}}
{{--    <div style="line-height: 0.1 !important;">--}}
{{--        <h2 style="text-align: center">** REKAP STRUK PER / KASIR **</h2>--}}
{{--        <h2 style="text-align: center">Transaksi : Refund</h2>--}}
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

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th style="border-right: 1px solid black;">TANGGAL</th>
                <th style="border-right: 1px solid black;">STT</th>
                <th style="border-right: 1px solid black;">-----KASIR-----</th>
                <th colspan="2" style="border-bottom: 1px solid black; border-right: 1px solid black">------REFUND------</th>
                <th colspan="3" style="border-right: 1px solid black; border-bottom: 1px solid black;">--------------REFERENSI--------------</th>
            </tr>
            <tr>
                <th style="border-right: 1px solid black; border-bottom: 1px solid black; width: 75px">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="border-right: 1px solid black; border-bottom: 1px solid black; width: 30px">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="border-right: 1px solid black; border-bottom: 1px solid black; width: 150px">&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="width: 60px; border: 1px solid black">STRUK</th>
                <th style="width: 120px; border: 1px solid black">TOTAL</th>
                <th style="width: 75px; border: 1px solid black">TGL</th>
                <th style="width: 150px; border: 1px solid black">KASIR</th>
                <th style="width: 60px; border: 1px solid black">STRUK</th>
            </tr>
        </thead>
        <?php
        $theDate = '';
        $cashier = '';
        $countKasir = 0;
        $countTotal = 0;
        ?>
        <tbody style="border-bottom: 3px solid black; text-align: right">
        @for($i=0;$i<sizeof($data);$i++)
            <?php
            $createDate = new DateTime($data[$i]->jh_transactiondate);
            $strip = $createDate->format('d-m-Y');
            $createDate = new DateTime($data[$i]->jh_referencedate);
            $strip2 = $createDate->format('d-m-Y');
            ?>
            @if($i!=0 && $cashier != $data[$i]->jh_cashier)
                <tr style="font-weight: bold">
                    <td style="border-bottom: 1px solid black" colspan="3">Total Per Kasir : </td>
                    <td style="border-bottom: 1px solid black" colspan="5">{{rupiah($countKasir)}}</td>
                </tr>
            @endif
            <tr>
                @if($theDate != $strip)
                    <?php
                    $theDate = $strip
                    ?>
                        <td style="text-align: center">{{$strip}}</td>
                @else
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                @if($cashier != $data[$i]->jh_cashier)
                    <?php
                    $countKasir = 0;
                    $cashier = $data[$i]->jh_cashier
                    ?>
                        <td style="text-align: center">{{$data[$i]->jh_cashierstation}}</td>
                        <td style="text-align: left">{{$cashier}}</td>
                @else
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td style="text-align: center">{{$data[$i]->jh_transactionno}}</td>
                <td>{{rupiah($data[$i]->jh_transactionamt)}}</td>
                <?php
                $countKasir = $countKasir + ($data[$i]->jh_transactionamt);
                $countTotal = $countTotal + ($data[$i]->jh_transactionamt);
                ?>
                <td style="text-align: center">{{$strip2}}</td>
                <td style="text-align: left">{{$data[$i]->jh_referencecashierid}}</td>
                <td style="text-align: center;">{{$data[$i]->jh_referenceno}}</td>
            </tr>

        @endfor
        <tr style="font-weight: bold">
            <td style="border-bottom: 1px solid black" colspan="5">Total Per Kasir : </td>
            <td style="border-bottom: 1px solid black" colspan="4">{{rupiah($countKasir)}}</td>
        </tr>
        <tr style="font-weight: bold">
            <td style="border-bottom: 1px solid black" colspan="5">Total Per Seluruhnya : </td>
            <td style="border-bottom: 1px solid black" colspan="4">{{rupiah($countTotal)}}</td>
        </tr>
        </tbody>
    </table>

    <p style="float: left">Khusus Member OMI Nilai Total Rupiah Telah Termasuk Distribution Fee ...</p>
{{--    <p style="float: right">**Akhir dari Laporan**</p>--}}

{{--</body>--}}
{{--</html>--}}
@endsection
