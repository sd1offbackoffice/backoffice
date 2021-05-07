<html>
<head>
    <title>LAPORAN-CASH BACK / SUPPLIER / ITEM</title>
</head>
<script src={{asset('/js/sweetalert2.js')}}></script>
<script src={{asset('/js/jquery.js')}}></script>
<script src="{{asset('/js/jquery-ui.js')}}"></script>
<script>
    $(document).ready(function() {
        swal.fire('', "Tekan Ctrl+P untuk print !!", 'warning');
    });
</script>
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
        margin-top: 120px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        position: absolute;
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
    <div style="line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="float: right; margin-top: -22px; line-height: 0.1px !important;">
        <p>TGL : {{$today}} &nbsp; PRG : LSTCSB</p>
        <p>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>

    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">{{$judul}}</h2>
        <h4 style="text-align: center">Tanggal: {{$date1}} s/d {{$date2}}</h4>
    </div>
</header>


<table class="table table-bordered table-responsive" style="border-collapse: collapse">
    <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
    <tr style="text-align: center; vertical-align: center">
        <th style="width: 40px; border-right: 1px solid black; border-bottom: 1px solid black">No.</th>
        <th style="width: 80px; border-right: 1px solid black; border-bottom: 1px solid black;">Plu</th>
        <th style="width: 378px; border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Deskripsi</th>
        <th style="width: 100px; border-right: 1px solid black;border-bottom: 1px solid black">Tanggal</th>
        <th style="width: 50px; border-right: 1px solid black;border-bottom: 1px solid black">Qty</th>
        <th style="width: 80px; border-bottom: 1px solid black">Nilai</th>
    </tr>
    </thead>
    <tbody style="border-bottom: 3px solid black; text-align: center; vertical-align: center">
    <?php
    $supplier = '';
    $qtysup = 0;
    $nilaisup = 0;
    $plu = '';
    $qtyplu = 0;
    $nilaiplu = 0;
    $totalqty = 0;
    $totalnilai = 0;
    $numbering = 0;
    $qty = 0;
    ?>
    @for($i=0;$i<sizeof($datas);$i++)
        @if(($datas[$i]->qty)<0)
            <?php
            $qty = ($datas[$i]->qty)*(-1);
            ?>
        @else
            <?php
            $qty = $datas[$i]->qty;
            ?>
        @endif
        @if($supplier != $datas[$i]->sup_kodesupplier)
            @if($qtysup != 0)
                @if($qtysup<0)
                    <?php
                    $qtysup = $qtysup *(-1);
                    ?>
                @endif
                <tr>
                    <td> </td>
                    <td> Total Per Supplier : </td>
                    <td> </td>
                    <td> </td>
                    <td>{{$qtysup}}</td>
                    <td>{{$nilaisup}}</td>
                </tr>
            @endif
            <tr>
                <td>Supplier</td>
                <td>{{$datas[$i]->sup_kodesupplier}}</td>
                <td>{{$datas[$i]->sup_namasupplier}}</td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
            <?php
            $supplier = $datas[$i]->sup_kodesupplier;
            $totalqty = $totalqty + $qtysup;
            $totalnilai = $totalnilai + $nilaisup;
            $qtysup = 0;
            $nilaisup = 0;
            ?>
        @endif
        @if($plu != $datas[$i]->plu)
            @if($qtyplu != 0)
                @if($qtyplu<0)
                    <?php
                    $qtyplu = $qtyplu *(-1);
                    ?>
                @endif
                <tr>
                    <td> </td>
                    <td> Total Per Plu : </td>
                    <td> </td>
                    <td> </td>
                    <td>{{$qtyplu}}</td>
                    <td>{{$nilaiplu}}</td>
                </tr>
            @endif
            <?php
            $plu = $datas[$i]->plu;
            $qtysup = $qtysup + $qtyplu;
            $nilaisup = $nilaisup + $nilaiplu;
            $qtyplu = 0;
            $nilaiplu = 0;
            $numbering++;
            ?>
            <tr>
                <td>{{$numbering}}</td>
                <td>{{$datas[$i]->plu}}</td>
                <td>{{$datas[$i]->prd_deskripsipanjang}}</td>
                <td>{{$datas[$i]->tanggal}}</td>
                <td>{{$qty}}</td>
                <td>{{$datas[$i]->nilai}}</td>
            </tr>
        @else
            <tr>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>{{$datas[$i]->tanggal}}</td>
                <td>{{$qty}}</td>
                <td>{{$datas[$i]->nilai}}</td>
            </tr>
        @endif
        <?php
        $qtyplu = $qtyplu + ($datas[$i]->qty);
        $nilaiplu = $nilaiplu + ($datas[$i]->nilai);
        ?>
    @endfor
    <?php
    $qtysup = $qtysup + $qtyplu;
    $nilaisup = $nilaisup + $nilaiplu;
    $totalqty = $totalqty + $qtysup;
    $totalnilai = $totalnilai + $nilaisup;
    ?>
    @if($qtyplu<0)
        <?php
        $qtyplu = $qtyplu *(-1);
        ?>
    @endif
    <tr>
        <td> </td>
        <td> Total Per Plu : </td>
        <td> </td>
        <td> </td>
        <td>{{$qtyplu}}</td>
        <td>{{$nilaiplu}}</td>
    </tr>
    @if($qtysup<0)
        <?php
        $qtysup = $qtysup *(-1);
        ?>
    @endif
    <tr>
        <td> </td>
        <td> Total Per Supplier : </td>
        <td> </td>
        <td> </td>
        <td>{{$qtysup}}</td>
        <td>{{$nilaisup}}</td>
    </tr>
    @if($totalqty<0)
        <?php
        $totalqty = $totalqty *(-1);
        ?>
    @endif
    <tr>
        <td> </td>
        <td> ** Total Akhir : </td>
        <td> </td>
        <td> </td>
        <td>{{$totalqty}}</td>
        <td>{{$totalnilai}}</td>
    </tr>
    </tbody>
</table>
<hr>
<p style="float: right; line-height: 0.1px !important;">** akhir dari laporan **</p>

</body>

</html>
