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
        <span>TGL : {{$today}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRG : LAP448 <br>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">{{$title}}</h2>
        <h4 style="text-align: center">Tanggal : {{$date1}} s/d {{$date2}}</h4>
    </div>
</header>
<table style="border-collapse: collapse">
    <thead style="font-weight: bold; vertical-align: center; border-top: 2px solid black; border-bottom: 2px solid black">
        <tr>
            <td>NO</td>
            <td>NO. PB</td>
            <td style="text-align: center">TANGGAL</td>
            <td>PLU</td>
            <td>DESKRIPSI</td>
            <td>SATUAN</td>
            <td style="text-align: right">QTY</td>
            <td style="text-align: right">NILAI</td>
        </tr>
    </thead>
    <tbody>
    <?php
        $counter = 0;
        $temppb = $datas[$i]->nopb;
        $tempTotal = 0;
        $tempGrandTotal = 0;
    ?>
    @for($i=0;$i<sizeof($datas);$i++)
        <?php
            $createDate = new DateTime($datas[$i]->tglpb);
            $strip = $createDate->format('d-m-Y');

            if($datas[$i]->nopb != $temppb){
                $temppb = $datas[$i]->nopb;
                $tempGrandTotal = $tempGrandTotal + $tempTotal;
                $counter = 0;
                ?>
                <tr>
                    <td colspan="7" style="text-align: right; font-weight: bold;">Total Per No. PO :</td>
                    <td style="text-align: right; font-weight: bold;">{{rupiah($tempTotal)}}</td>
                </tr>
                <?php
                $tempTotal = 0;
            }
            $tempTotal = $tempTotal + (($datas[$i]->nilo)+($datas[$i]->ppno));
            $counter++;
        ?>
        <tr>
            <td>{{$counter}}</td>
            @if($counter == 1)
                <td>{{$datas[$i]->nopb}}</td>
                <td style="text-align: center">{{$strip}}</td>
            @else
                <td></td>
                <td></td>
            @endif
            <td>{{$datas[$i]->pbo_pluigr}}</td>
            <td>{{$datas[$i]->prd_deskripsipanjang}}</td>
            <td>{{$datas[$i]->kemasan}}</td>
            <td style="text-align: right">{{$datas[$i]->qtyo}}</td>
            <td style="text-align: right">{{rupiah(($datas[$i]->nilo)+($datas[$i]->ppno))}}</td>
        </tr>
    @endfor
    <tr>
        <td colspan="7" style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">Total Per No. PO :</td>
        <td style="text-align: right; font-weight: bold; border-bottom: 1px solid black;">{{rupiah($tempTotal)}}</td>
    </tr>
    <?php
        $tempGrandTotal = $tempGrandTotal + $tempTotal;
    ?>
    <tr>
        <td colspan="7" style="text-align: right; font-weight: bold;">Total Seluruhnya :</td>
        <td style="text-align: right; font-weight: bold;">{{rupiah($tempGrandTotal)}}</td>
    </tr>
    </tbody>
</table>
</body>
</html>

