<html>
<head>
    <title>LAPORAN SERVICE LEVEL SALES THD PB (TOTAL)</title>
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
        margin-top: 100px;
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

function rupiah($angka){
    //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,0,'.',',');
    return $hasil_rupiah;
}
?>
<header>
    <div style="margin-top: -20px; line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="position: absolute;top: -20px; left: 586px; line-height: 0.1px !important;">
        <p>TGL : {{$today}} &nbsp;&nbsp;&nbsp;&nbsp; PRG : LAP224</p>
        <p>JAM : {{$time}}</p>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">** LAPORAN SERVICE LEVEL SALES THD PB (TOTAL) ** </h2>
        <h4 style="text-align: center">Periode : {{$date1}} s/d {{$date2}}</h4>
        <h4 style="text-align: center">No. PB : {{$pb1}} s/d {{$pb2}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr>
                <td rowspan="2" style="width: 20px; border-right: 1px solid black">No.</td>
                <td rowspan="2" style="width: 122px; border-right: 1px solid black">Member</td>
                <td rowspan="2" style="width: 122px; border-right: 1px solid black">Cabang</td>
                <td colspan="3" style="text-align: center; border-bottom: 1px solid black; border-right: 1px solid black">-------- R U P I A H --------</td>
                <td colspan="3" style="text-align: center; border-bottom: 1px solid black; border-right: 1px solid black">--- Q U A N T I T Y ---</td>
                <td colspan="3" style="text-align: center; border-bottom: 1px solid black;">------ I T E M ------</td>
            </tr>
            <tr style="text-align: right;">
                <td style="width: 50px; border-right: 1px solid black">PO </td>
                <td style="width: 50px; border-right: 1px solid black">Realisasi </td>
                <td style="width: 50px; border-right: 1px solid black">% </td>

                <td style="width: 50px; border-right: 1px solid black">PO </td>
                <td style="width: 50px; border-right: 1px solid black">Realisasi </td>
                <td style="width: 50px; border-right: 1px solid black">% </td>

                <td style="width: 50px; border-right: 1px solid black">PO </td>
                <td style="width: 50px; border-right: 1px solid black">Realisasi </td>
                <td style="width: 50px;">% </td>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black">
        @for($i=0;$i<sizeof($datas);$i++)
            <tr>
                <td>{{$i+1}}</td>
                <td>{{$datas[$i]->kodemember}} {{$datas[$i]->cus_namamember}}</td>
                <td>{{$datas[$i]->pbo_kodeomi}} - {{$datas[$i]->tko_namaomi}}</td>
                <td style="text-align: right">{{rupiah($datas[$i]->nilaio)}}</td>
                <td style="text-align: right">{{rupiah($datas[$i]->nilair)}}</td>
                @if($datas[$i]->nilaio == '0' || $datas[$i]->nilair == '0')
                    <td style="text-align: right">0</td>
                @else
                    <td style="text-align: right">{{round((float)($datas[$i]->nilair)/(float)($datas[$i]->nilaio) * 100, 2)}}</td>
                @endif

                <td style="text-align: right">{{rupiah($datas[$i]->qtyo)}}</td>
                <td style="text-align: right">{{rupiah($datas[$i]->qtyr)}}</td>
                @if($datas[$i]->qtyo == '0' || $datas[$i]->qtyr == '0')
                    <td style="text-align: right">0</td>
                @else
                    <td style="text-align: right">{{round((float)($datas[$i]->qtyr)/(float)($datas[$i]->qtyo) * 100, 2)}}</td>
                @endif

                <td style="text-align: right">{{rupiah($datas[$i]->itemo)}}</td>
                <td style="text-align: right">{{rupiah($datas[$i]->itemr)}}</td>
                @if($datas[$i]->itemo == '0' || $datas[$i]->itemr == '0')
                    <td style="text-align: right">0</td>
                @else
                    <td style="text-align: right">{{round((float)($datas[$i]->itemr)/(float)($datas[$i]->itemo) * 100, 2)}}</td>
                @endif
            </tr>
        @endfor
        <tr style="font-weight: bold">
            <td colspan="3" style="border-top: 2px solid black;">TOTAL SELURUHNYA</td>
            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['tnilo'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['tnilr'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{$val['totnil']}}</td>

            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['tqtyo'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['tqtyr'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{$val['totqty']}}</td>

            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['titemo'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{rupiah($val['titemr'])}}</td>
            <td style="text-align: right; border-top: 2px solid black;">{{$val['totitem']}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
<span style="font-weight: bold; float: right">** Akhir Laporan **</span>
<br>
</body>

</html>
