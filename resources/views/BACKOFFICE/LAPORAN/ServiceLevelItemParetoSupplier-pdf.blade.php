<html>
<head>
    <title>LAPORAN-SERVICE LEVEL ITEM PARETO</title>
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
        margin-top: 125px;
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

    $hasil_rupiah = number_format($angka);
    return $hasil_rupiah;

}
?>
<header>
    <div style="margin-top: -20px; line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="position: absolute; top: -17px; left: 500px; line-height: 0.1px !important;">
        <p>TGL : {{$today}}</p>
        <p>JAM : {{$time}}</p>
    </div>
    <div style="position: absolute; top: -2px; left: 600px; line-height: 0.1px !important;">
        <p>PRG : IGR_BO_SVCLVLPARETO</p>
    </div>
    <div style="margin-top: 25px; line-height: 0.1 !important;">
        <h2 style="text-align: center">{{$datas[0]->judul}}</h2>
        <h4 style="text-align: center">TANGGAL : {{$date1}} S/D {{$date2}}</h4>
        <p style="text-align: center">By Div-Dept_Kat</p>
    </div>
</header>

<p style="line-height: 0.1 !important;">KODE MONITORING : {{$p_kdmon}} - {{$p_nmon}}</p>
<p style="position: absolute; top: 15px;left: 680px; line-height: 0.1 !important;">By Supplier</p>
    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="2" style="width: 20px; border-right: 1px solid black; border-bottom: 1px solid black">No.</th>
                <th rowspan="2" style="width: 50px; border-right: 1px solid black; border-bottom: 1px solid black">Kode<br>Barang</th>
                <th rowspan="2" style="width: 288px; border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Nama<br>Barang</th>
                <th rowspan="2" style="width: 20px; border-right: 1px solid black; border-bottom: 1px solid black">Tag</th>
                <th colspan="2" style="border-right: 1px solid black; border-bottom: 1px solid black">PO</th>
                <th colspan="2" style="border-right: 1px solid black; border-bottom: 1px solid black">BPB</th>
                <th rowspan="2" style="width: 40px;border-right: 1px solid black; border-bottom: 1px solid black">%<br>Kuantum</th>
                <th rowspan="2" style="width: 40px;border-bottom: 1px solid black">%<br>Nilai</th>
            </tr>
            <tr>
                <th style="width: 65px; border: 1px solid black">Kuantum</th>
                <th style="width: 65px; border: 1px solid black">Nilai</th>
                <th style="width: 65px; border: 1px solid black">Kuantum</th>
                <th style="width: 65px; border: 1px solid black">Nilai</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black">
        <?php
            $supplier = '';
            $numbering = 1;

            $katotal = 0;
            $natotal = 0;
            $kbtotal = 0;
            $nbtotal = 0;

            $kasupplier = 0;
            $nasupplier = 0;
            $kbsupplier = 0;
            $nbsupplier = 0;
            $totksupplier = 0;
            $totnsupplier = 0;
        ?>
        @for($i=0;$i<sizeof($datas);$i++)
            @if($supplier != $datas[$i]->tpoh_kodesupplier)
                @if($i!=0)
                    <tr>
                        <td colspan="4" style="border-top: 2px solid black; border-bottom: 2px solid black">Total Per Supplier : </td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kasupplier)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nasupplier)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kbsupplier)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nbsupplier)}}</td>
                        @if($kasupplier != 0 && $kbsupplier != 0)
                            <?php
                            $totksupplier = (($kbsupplier)/(($kasupplier)))*100;
                            $totksupplier = number_format((float)$totksupplier, 2, '.', '');
                            ?>
                        @else
                            <?php
                            $totksupplier = 0;
                            ?>
                        @endif
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totksupplier}}</td>
                        @if($nasupplier != 0 && $nbsupplier != 0)
                            <?php
                            $totnsupplier = (($nbsupplier)/(($nasupplier)))*100;
                            $totnsupplier = number_format((float)$totnsupplier, 2, '.', '');
                            ?>
                        @else
                            <?php
                            $totnsupplier = 0;
                            ?>
                        @endif
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totnsupplier}}</td>
                    </tr>
                    <?php

                    $katotal = $katotal + $kasupplier;
                    $natotal = $natotal + $nasupplier;
                    $kbtotal = $kbtotal + $kbsupplier;
                    $nbtotal = $nbtotal + $nbsupplier;

                    $kasupplier = 0;
                    $nasupplier = 0;
                    $kbsupplier = 0;
                    $nbsupplier = 0;
                    $totksupplier = 0;
                    $totnsupplier = 0;
                    ?>
                @endif
                @php
                    $supplier = $datas[$i]->tpoh_kodesupplier;
                @endphp
                <tr>
                <td colspan="10" style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">SUPPLIER : {{$datas[$i]->tpoh_kodesupplier}} - {{$datas[$i]->sup_namasupplier}}</td>
                </tr>
            @endif
            <tr>
                <td>{{$numbering}}</td>
                <td>{{$datas[$i]->tpod_prdcd}}</td>
                <td>{{$datas[$i]->prd_deskripsipanjang}}</td>
                <td style="text-align: center">{{$datas[$i]->prd_kodetag}}</td>
                <td style="text-align: right">{{rupiah($datas[$i]->qtypo)}}</td>
                <td style="text-align: right">{{rupiah($datas[$i]->nilaia)}}</td>
                <td style="text-align: right">{{rupiah($datas[$i]->kuanb)}}</td>
                <td style="text-align: right">{{rupiah($datas[$i]->nilaib)}}</td>
                @if($datas[$i]->qtypo != 0 && $datas[$i]->kuanb != 0)
                    <?php
                    $cf_prsnqty = (($datas[$i]->kuanb)/(($datas[$i]->qtypo)-($datas[$i]->qty_po_outs)))*100;
                    $cf_prsnqty = number_format((float)$cf_prsnqty, 2, '.', '');
                    ?>
                @else
                    <?php
                    $cf_prsnqty = 0;
                    ?>
                @endif
                <td style="text-align: right">{{$cf_prsnqty}}</td>
                @if($datas[$i]->nilaia != 0 && $datas[$i]->nilaib != 0)
                    <?php
                    $prsnil = (($datas[$i]->nilaib)/(($datas[$i]->nilaia)-($datas[$i]->rph_po_outs)))*100;
                    $prsnil = number_format((float)$prsnil, 2, '.', '');
                    ?>
                @else
                    <?php
                    $prsnil = 0;
                    ?>
                @endif
                <td style="text-align: right">{{$prsnil}}</td>
                <?php
                    $kasupplier = $kasupplier + $datas[$i]->qtypo;
                    $nasupplier = $nasupplier + $datas[$i]->nilaia;
                    $kbsupplier = $kbsupplier + $datas[$i]->kuanb;
                    $nbsupplier = $nbsupplier + $datas[$i]->nilaib;
                ?>
            </tr>
        @endfor
        <?php
        $katotal = $katotal + $kasupplier;
        $natotal = $natotal + $nasupplier;
        $kbtotal = $kbtotal + $kbsupplier;
        $nbtotal = $nbtotal + $nbsupplier;
        ?>
        <tr>
            <td colspan="4" style="border-top: 2px solid black; border-bottom: 2px solid black">Total Per Supplier : </td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kasupplier)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nasupplier)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kbsupplier)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nbsupplier)}}</td>
            @if($kasupplier != 0 && $kbsupplier != 0)
                <?php
                $totksupplier = (($kbsupplier)/(($kasupplier)))*100;
                $totksupplier = number_format((float)$totksupplier, 2, '.', '');
                ?>
            @else
                <?php
                $totksupplier = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totksupplier}}</td>
            @if($nasupplier != 0 && $nbsupplier != 0)
                <?php
                $totnsupplier = (($nbsupplier)/(($nasupplier)))*100;
                $totnsupplier = number_format((float)$totnsupplier, 2, '.', '');
                ?>
            @else
                <?php
                $totnsupplier = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totnsupplier}}</td>
        </tr>
        <tr>
            <td colspan="4" style="border-top: 3px solid black; border-bottom: 3px solid black">Grand Total : </td>
            <td style="text-align: right; border-top: 3px solid black; border-bottom: 3px solid black">{{rupiah($katotal)}}</td>
            <td style="text-align: right; border-top: 3px solid black; border-bottom: 3px solid black">{{rupiah($natotal)}}</td>
            <td style="text-align: right; border-top: 3px solid black; border-bottom: 3px solid black">{{rupiah($kbtotal)}}</td>
            <td style="text-align: right; border-top: 3px solid black; border-bottom: 3px solid black">{{rupiah($nbtotal)}}</td>
            @if($katotal != 0 && $kbtotal != 0)
                <?php
                $totktotal = (($kbtotal)/(($katotal)))*100;
                $totktotal = number_format((float)$totktotal, 2, '.', '');
                ?>
            @else
                <?php
                $totktotal = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totktotal}}</td>
            @if($natotal != 0 && $nbtotal != 0)
                <?php
                $totntotal = (($nbtotal)/(($natotal)))*100;
                $totntotal = number_format((float)$totntotal, 2, '.', '');
                ?>
            @else
                <?php
                $totntotal = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totntotal}}</td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p style="float: right">** Akhir Laporan **</p>

</body>

</html>
