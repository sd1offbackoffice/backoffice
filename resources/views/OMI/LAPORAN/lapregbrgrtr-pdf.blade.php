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
        <span>TGL : {{$today}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRG : IGR0369 <br>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">** LAPORAN REGISTER BARANG RETUR  **</h2>
        <h4 style="text-align: center">TANGGAL : {{$date1}} s/d {{$date2}}</h4>
        <h4 style="text-align: center">NO. DOKUMEN : {{$nodoc1}} s/d {{$nodoc2}}</h4>
    </div>
</header>
<table style="border-collapse: collapse">
    <thead style="font-weight: bold; vertical-align: center; text-align: left; border-top: 2px solid black; border-bottom: 2px solid black">
        <tr>
            <td style="text-align: center">TANGGAL</td>
            <td>NO. NRB</td>
            <td style="text-align: center">TGL. NRB</td>
            <td>NO. DOKUMEN</td>
            <td style="text-align: right">ITEM</td>
            <td style="text-align: center">TOKO</td>
            <td>MEMBER</td>
            <td style="text-align: right">NILAI</td>
        </tr>
    </thead>
    <tbody>
    <?php
        $bkp = 0;
        $btkp = 0;
        $temp = '';
    ?>
    @for($i=0;$i<sizeof($datas);$i++)
        <?php
            $createDate = new DateTime($datas[$i]->tgldok);
            $strip = $createDate->format('d-m-Y');
            $createDate = new DateTime($datas[$i]->rom_tglreferensi);
            $strip2 = $createDate->format('d-m-Y');
            $bkp = $bkp + $datas[$i]->ttl_bkp;
            $btkp = $btkp + $datas[$i]->ttl_btkp;
        ?>
        <tr>
            @if($temp != $strip)
                <td style="text-align: center; width: 100px">{{$strip}}</td>
                <?php
                $temp = $strip;
                ?>
            @else
                <td></td>
            @endif

            <td style="text-align: center">{{$datas[$i]->rom_noreferensi}}</td>
            <td style="text-align: center; width: 100px">{{$strip2}}</td>
            <td>{{$datas[$i]->rom_nodokumen}}</td>
            <td>{{$datas[$i]->item}}</td>
            <td>{{$datas[$i]->rom_kodetoko}}</td>
            <td>{{$datas[$i]->member}}</td>
            <td style="text-align: right">{{rupiah($datas[$i]->total)}}</td>
        </tr>
    @endfor
    <tr>
        <td colspan="7" style="text-align: right; border-top: 1px solid black">TOTAL BKP</td>
        <td style="border-top: 1px solid black; text-align: right;">{{rupiah($bkp)}}</td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: right;">TOTAL BTKP</td>
        <td style="text-align: right;">{{rupiah($btkp)}}</td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: right; font-weight: bold; border-bottom: 1px solid black">TOTAL</td>
        <td style="border-bottom: 1px solid black; text-align: right;">{{rupiah($bkp + $btkp)}}</td>
    </tr>
    </tbody>
</table>
<hr>
<span style="float: right">** AKHIR LAPORAN **</span>
</body>
</html>

