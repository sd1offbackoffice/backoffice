<html>
<head>
    <title>LAPORAN-TRANSFER SATUAN PRODUK HOT BEVERAGES</title>
</head>
<style>
    /**
        Set the margins of the page to 0, so the footer and the header
        can be of the full height and width !
     **/
    @page {
        margin: 25px 25px;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 90px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }
    table{
        border: 1px;
    }
    .page-break {
        page-break-after: always;
    }
    .page-numbers:after { content: counter(page); }
</style>


<body>
<!-- Define header and footer blocks before your content -->
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
<header>
    <div style="margin-top: -20px; line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
    </div>
    <div style="margin-top: -30px; float: right; line-height: 0.1px !important;">
        <span>{{$today}}</span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">DATA PERHITUNGAN TRANSFER SATUAN PRODUK</h2>
        <h3 style="text-align: center">( dari produk dasar ke produk hot beverages yang dijual )</h3>
        <h4 style="text-align: center">Periode : {{$date1}} s/d {{$date2}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse; text-align: center">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="2" style="width: 62px; border: 1px solid black">Departemen</th>
                <th colspan="2" style="border: 1px solid black">PLU</th>
                <th colspan="2" style="border: 1px solid black">Nama / Spesifikasi</th>
                <th rowspan="2" style="width: 80px; border: 1px solid black">Satuan</th>
                <th rowspan="2" style="width: 80px; border: 1px solid black">Qty</th>
                <th rowspan="2" style="width: 80px; border: 1px solid black">Harga Sat<br>(Rp)</th>
                <th colspan="2" style="border: 1px solid black">Jumlah ( Rp. )</th>
            </tr>
            <tr>
                @for($i=0;$i<3;$i++)
                    <th style="width: 125px; border: 1px solid black">Items yg dijual</th>
                    <th style="width: 125px; border: 1px solid black">Items Produk Dasar</th>
                @endfor
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: center">
        <?php
            $counter = '';
            $cs_njadi = 0;
            $cs_ndasar = 0;
        ?>
        @for($i=0;$i<sizeof($datas);$i++)
            @if($counter == '' || $counter != $datas[$i]->trjd_prdcd)
                <tr>
                    <td style="border-bottom: 1px solid black">{{$datas[$i]->prd_kodedepartement}}</td>
                    <td colspan="2" style="border-bottom: 1px solid black; border-right: 1px solid black; text-align: left">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$datas[$i]->dep_namadepartement}}</td>
                    <td colspan="7" style="border-bottom: 1px solid black; background-color: gray"></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black"></td>
                    <td style="border: 1px solid black">{{$datas[$i]->trjd_prdcd}}</td>
                    <td style="border: 1px solid black"></td>
                    <td style="border: 1px solid black">{{$datas[$i]->desc_jadi}}</td>
                    <td style="border: 1px solid black"></td>
                    <td style="border: 1px solid black">{{$datas[$i]->unit_jadi}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->trjd_quantity}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->trjd_unitprice}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->nilai_jadi}}</td>
                    <td style="border: 1px solid black"></td>
                </tr>
                <?php
                    $cs_njadi = $cs_njadi + $datas[$i]->nilai_jadi;
                    $counter = $datas[$i]->trjd_prdcd;
                ?>
            @endif
{{--            <tr>--}}
{{--                <td style="border-bottom: 1px solid black; border-top: 1px solid black">{{$datas[$i]->prd_kodedepartement}}</td>--}}
{{--                <td colspan="2" style="border: 1px solid black; border-left: none; text-align: left">-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$datas[$i]->dep_namadepartement}}</td>--}}
{{--                <td colspan="7" style="border-bottom: 1px solid black; background-color: gray"></td>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <td></td>--}}
{{--                <td style="border: 1px solid black">{{$datas[$i]->trjd_prdcd}}</td>--}}
{{--                <td></td>--}}
{{--                <td style="border: 1px solid black">{{$datas[$i]->desc_jadi}}</td>--}}
{{--                <td></td>--}}
{{--                <td style="border: 1px solid black">{{$datas[$i]->unit_jadi}}</td>--}}
{{--                <td style="border: 1px solid black">{{$datas[$i]->trjd_quantity}}</td>--}}
{{--                <td style="border: 1px solid black">{{$datas[$i]->trjd_unitprice}}</td>--}}
{{--                <td style="border: 1px solid black">{{$datas[$i]->nilai_jadi}}</td>--}}
{{--                <td></td>--}}
{{--            </tr>--}}
            <tr>
                <td style="border: 1px solid black"></td>
                <td style="border: 1px solid black"></td>
                <td style="border: 1px solid black">{{$datas[$i]->hbv_prdcd_brd}}</td>
                <td style="border: 1px solid black"></td>
                <td style="border: 1px solid black">{{$datas[$i]->prd_deskripsipanjang}}</td>
                <td style="border: 1px solid black">{{$datas[$i]->prd_unit}}</td>
                <td style="border: 1px solid black">{{$datas[$i]->qty}}</td>
                <td style="border: 1px solid black">{{$datas[$i]->hrg_dasar}}</td>
                <td style="border: 1px solid black"></td>
                <td style="border: 1px solid black">{{$datas[$i]->nilai_dasar}}</td>
            </tr>
            <?php
            $cs_ndasar = $cs_ndasar + $datas[$i]->nilai_dasar;
            ?>
        @endfor
            <tr>
                <td colspan="7"></td>
                <td>Jumlah : </td>
                <td>{{$cs_njadi}}</td>
                <td>{{$cs_ndasar}}</td>
            </tr>
        </tbody>
    </table>
<div class="page-break"></div>
    <hr>
    <p>Rekapitulasi Penggunaan Produk Dasar :</p>
    <hr>
    <table class="table table-bordered table-responsive" style="border-collapse: collapse; text-align: center">
        <tbody style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center; font-weight: normal">
        <?php
        $cs_ndasarr = 0;
        ?>
        @for($i=0;$i<sizeof($datas2);$i++)
            <tr>
                <td style="width: 62px;"> </td>
                <td style="width: 125px;"> </td>
                <td style="width: 125px; border: 1px solid black">{{$datas2[$i]->plu_dsr}}</td>
                <td style="width: 125px;"> </td>
                <td style="width: 125px; border: 1px solid black">{{$datas2[$i]->desc_dsr}}</td>
                <td style="width: 80px; border: 1px solid black">{{$datas2[$i]->unit_dsr}}</td>
                <td style="width: 80px; border: 1px solid black">{{$datas2[$i]->qty_dsr}}</td>
                <td style="width: 80px; border: 1px solid black">{{$datas2[$i]->hrg_dsr}}</td>
                <td style="width: 125px;"> </td>
                <td style="width: 125px; border: 1px solid black">{{$datas2[$i]->nilai_dsr}}</td>
            </tr>
            <?php
            $cs_ndasarr = $cs_ndasarr + $datas2[$i]->nilai_dsr;
            ?>
        @endfor
            <tr>
                <td colspan="8"></td>
                <td style="border-top: 1px solid black">Jumlah : </td>
                <td style="border: 1px solid black">{{$cs_ndasarr}}</td>
            </tr>
        </tbody>
    </table>

</body>

</html>
