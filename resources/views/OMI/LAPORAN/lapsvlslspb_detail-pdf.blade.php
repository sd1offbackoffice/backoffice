<html>
<head>
    <title>LAPORAN-PENJUALAN PER DIVISI</title>
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
        margin-top: 10px;
        margin-bottom: 0px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        /*position: fixed;*/
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
        margin-bottom: 30px;
    }
    table{
        border: 1px;
    }
    .page-break {
        page-break-after: always;
    }
    .page-numbers:after { content: counter(page); }
</style>
<script src={{asset('/js/jquery.js')}}></script>
<script src={{asset('/js/sweetalert.js')}}></script>
<script>
    $(document).ready(function() {
        swal('Information', 'Tekan Ctrl+P untuk print!', 'info');
    });
</script>
<body>
<!-- Define header and footer blocks before your content -->
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
//rupiah formatter (no Rp or .00)
function rupiah($angka){
    //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,0,'.',',');
    return $hasil_rupiah;
}
?>

<header>
    <div style="font-size: 12px ;line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="float: right; margin-top: -38px">
        <span>TGL : {{$today}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRG : LAP224 <br>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">** LAPORAN SERVICE LEVEL SALES THD PB (DETAIL) ** </h2>
        <h4 style="text-align: center">Periode : {{$date1}} s/d {{$date2}}</h4>
        <h4 style="text-align: center">No. PB : {{$pb1}} s/d {{$pb2}}</h4>
    </div>
</header>
<table class="table table-bordered table-responsive" style="border-collapse: collapse">
    <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
    <tr>
        <td rowspan="2" style="border-right: 1px solid black">No.</td>
        <td rowspan="2" style="border-right: 1px solid black">Member</td>
        <td rowspan="2" style="border-right: 1px solid black">Cabang</td>
        <td colspan="3" style="text-align: center; border-bottom: 1px solid black; border-right: 1px solid black">-------- R U P I A H --------</td>
        <td colspan="3" style="text-align: center; border-bottom: 1px solid black; border-right: 1px solid black">--- Q U A N T I T Y ---</td>
        <td colspan="3" style="text-align: center; border-bottom: 1px solid black;">------ I T E M ------</td>
    </tr>
    <tr style="text-align: right;">
        <td style="border-right: 1px solid black">PO </td>
        <td style="border-right: 1px solid black">Realisasi </td>
        <td style="border-right: 1px solid black">% </td>

        <td style="border-right: 1px solid black">PO </td>
        <td style="border-right: 1px solid black">Realisasi </td>
        <td style="border-right: 1px solid black">% </td>

        <td style="border-right: 1px solid black">PO </td>
        <td style="border-right: 1px solid black">Realisasi </td>
        <td>% </td>
    </tr>
    </thead>
    <tbody style="border-bottom: 3px solid black">
    <?php
        $counter = 0;
        $kode = '';

        $nilo = 0;
        $nilr = 0;

        $qtyo = 0;
        $qtyr = 0;

        $itemo = 0;
        $itemr = 0;
    ?>
    @for($i=0;$i<sizeof($datas);$i++)
        <tr>
            @if($kode != $datas[$i]->kodemember)
                @if($i!=0)
                    <tr style="font-weight: bold">
                        <td colspan="3" style="border-top: 2px solid black;">TOTAL PER MEMBER</td>
                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($nilo)}}</td>
                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($nilr)}}</td>
                        @if($nilo == 0 || $nilr == 0)
                            <td style="text-align: right; border-top: 2px solid black;">0</td>
                        @else
                            <td style="text-align: right; border-top: 2px solid black;">{{round($nilr/$nilo * 100, 2)}}</td>
                        @endif

                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($qtyo)}}</td>
                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($qtyr)}}</td>
                        @if($qtyo == 0 || $qtyr == 0)
                            <td style="text-align: right; border-top: 2px solid black;">0</td>
                        @else
                            <td style="text-align: right; border-top: 2px solid black;">{{round($qtyr/$qtyo * 100, 2)}}</td>
                        @endif

                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($itemo)}}</td>
                        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($itemr)}}</td>
                        @if($itemo == 0 || $itemr == 0)
                            <td style="text-align: right; border-top: 2px solid black;">0</td>
                        @else
                            <td style="text-align: right; border-top: 2px solid black;">{{round($itemr/$itemo * 100, 2)}}</td>
                        @endif
                    </tr>
                    <?php
                    $nilo = 0;
                    $nilr = 0;

                    $qtyo = 0;
                    $qtyr = 0;

                    $itemo = 0;
                    $itemr = 0;
                    ?>
                @endif
                <?php
                $kode = $datas[$i]->kodemember;
                $counter++;
                ?>
                <td>{{$counter}}</td>
                <td>{{$datas[$i]->kodemember}} {{$datas[$i]->namamember}}</td>
                <td>{{$datas[$i]->pbo_kodeomi}} - {{$datas[$i]->tko_namaomi}}</td>
            @else
                <td></td>
                <td></td>
                <td></td>
            @endif
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
        <?php
            $nilo = $nilo + $datas[$i]->nilaio;
            $nilr = $nilr + $datas[$i]->nilair;

            $qtyo = $qtyo + $datas[$i]->qtyo;
            $qtyr = $qtyr + $datas[$i]->qtyr;

            $itemo = $itemo + $datas[$i]->itemo;
            $itemr = $itemr + $datas[$i]->itemr;
        ?>
    @endfor
    <tr style="font-weight: bold">
        <td colspan="3" style="border-top: 2px solid black;">TOTAL PER MEMBER</td>
        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($nilo)}}</td>
        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($nilr)}}</td>
        @if($nilo == 0 || $nilr == 0)
            <td style="text-align: right; border-top: 2px solid black;">0</td>
        @else
            <td style="text-align: right; border-top: 2px solid black;">{{round($nilr/$nilo * 100, 2)}}</td>
        @endif

        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($qtyo)}}</td>
        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($qtyr)}}</td>
        @if($qtyo == 0 || $qtyr == 0)
            <td style="text-align: right; border-top: 2px solid black;">0</td>
        @else
            <td style="text-align: right; border-top: 2px solid black;">{{round($qtyr/$qtyo * 100, 2)}}</td>
        @endif

        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($itemo)}}</td>
        <td style="text-align: right; border-top: 2px solid black;">{{rupiah($itemr)}}</td>
        @if($itemo == 0 || $itemr == 0)
            <td style="text-align: right; border-top: 2px solid black;">0</td>
        @else
            <td style="text-align: right; border-top: 2px solid black;">{{round($itemr/$itemo * 100, 2)}}</td>
        @endif
    </tr>
    <tr style="font-weight: bold">
        <td colspan="3" style="border-top: 2px solid black;">TOTAL SELURUHNYA</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['tnilo'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['tnilr'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{$val['totnil']}}</td>

        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['tqtyo'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['tqtyr'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{$val['totqty']}}</td>

        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['titemo'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{rupiah($val['titemr'])}}</td>
        <td style="text-align: right; border-top: 2px solid black;">&nbsp;&nbsp;{{$val['totitem']}}</td>
    </tr>
    </tbody>
</table>
<hr>
<span style="font-weight: bold; float: right">** Akhir Laporan **</span>
</body>
</html>

