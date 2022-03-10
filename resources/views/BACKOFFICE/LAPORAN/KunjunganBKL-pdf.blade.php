<html>
<head>
    <title>LAPORAN-BULANAN KEDATANGAN SUPPLIER BKL</title>
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
        margin-top: 80px;
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
        <h2 style="text-align: center">LAPORAN BULANAN KEDATANGAN SUPPLIER BKL BERDASARKAN JADWAL HARI KUNJUNGAN</h2>
        <h4 style="text-align: center">Periode : {{$date}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="3" style="width: 20px; border-right: 1px solid black; border-bottom: 1px solid black">No.</th>
                <th rowspan="3" style="width: 20px; border-right: 1px solid black; border-bottom: 1px solid black">Kode<br>Supplier</th>
                <th rowspan="3" style="width: 50px; border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Nama Supplier</th>
                <th rowspan="2" colspan="7" style="border-right: 1px solid black; border-bottom: 1px solid black">Hari Kunjungan</th>
                <th rowspan="3" style="width: 25px; border-right: 1px solid black; border-left: 1px solid black;"><br>TOP</th>
                <th rowspan="3" style="width: 25px; border-right: 1px solid black; border-left: 1px solid black;"><br>LT</th>
                <th rowspan="1" style="border-right: 1px solid black; border-left: 1px solid black;" colspan="31">Hari Kedatangan</th>
                <th rowspan="3" style="width: 30px; border-right: 1px solid black; border-left: 1px solid black;">%<br>sesuai<br>kedatangan</th>
                <th rowspan="3" style="width: 30px; border-left: 1px solid black;">%<br>sesuai<br>kunjungan</th>
            </tr>
            <tr>
                @for($i=1;$i<=31;$i++)
                    <th style="width: 15px; border: 1px solid black">{{sprintf("%02d", $i)}}</th>
                @endfor
            </tr>
            <tr>
                <th style="width: 30px; border: 1px solid black">Minggu</th>
                <th style="width: 30px; border: 1px solid black">Senin</th>
                <th style="width: 30px; border: 1px solid black">Selasa</th>
                <th style="width: 30px; border: 1px solid black">Rabu</th>
                <th style="width: 30px; border: 1px solid black">Kamis</th>
                <th style="width: 30px; border: 1px solid black">Jum'at</th>
                <th style="width: 30px; border: 1px solid black">Sabtu</th>
                @for($i=0;$i<sizeof($hari);$i++)
                    <th style="border: 1px solid black">{{$hari[$i]->hari}}</th>
                @endfor
                @if(sizeof($hari) == 30)
                    <th style="border: 1px solid black"></th>
                @elseif(sizeof($hari) == 29)
                    <th style="border: 1px solid black"></th>
                    <th style="border: 1px solid black"></th>
                @elseif(sizeof($hari) == 28)
                    <th style="border: 1px solid black"></th>
                    <th style="border: 1px solid black"></th>
                    <th style="border: 1px solid black"></th>
                @endif
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: center">
            @for($i=0;$i<sizeof($datas);$i++)
                <tr>
                    <td style="border: 1px solid black">{{$i+1}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->mstd_kodesupplier}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->sup_namasupplier}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->minggu}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->senin}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->selasa}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->rabu}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->kamis}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->jumat}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->sabtu}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->sup_top}}</td>
                    <td style="border: 1px solid black">{{$datas[$i]->sup_jangkawaktukirimbarang}}</td>
                    @for($j=1;$j<=31;$j++)
                        @if(strpos(($datas[$i]->tgl),strval($j)))
                            <td style="border: 1px solid black">Y</td>
                        @else
                            <td style="border: 1px solid black"></td>
                        @endif
                    @endfor
                    <td style="border: 1px solid black">{{number_format(($datas[$i]->ssdtg), 2, '.', '')}}</td>
                    <td style="border: 1px solid black; border-right: none">{{number_format(($datas[$i]->sskunj), 2, '.', '')}}</td>
                </tr>
            @endfor
        </tbody>
    </table>
    <hr>
    <p style="float: right">** Selesai **</p>

</body>

</html>
