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

    $hasil_rupiah = number_format($angka,2,',','.');
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
        <h2 style="text-align: center">** SERVICE LEVEL ITEM PARETO **</h2>
        <h4 style="text-align: center">TANGGAL : {{$date1}} S/D {{$date2}}</h4>
        <p style="text-align: center">By Div-Dept_Kat</p>
    </div>
</header>

<p style="line-height: 0.1 !important;">KODE MONITORING : {{$p_kdmon}} - {{$p_nmon}}</p>
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
            $divisi = '';
            $departemen = '';
            $kategori = '';
            $numbering = 1;

            $kakategori = 0;
            $nakategori = 0;
            $kbkategori = 0;
            $nbkategori = 0;
            $totkkategori = 0;
            $totnkategori = 0;

            $kadepartement = 0;
            $nadepartement = 0;
            $kbdepartement = 0;
            $nbdepartement = 0;
            $totkdepartement = 0;
            $totndepartement = 0;

            $kadivisi = 0;
            $nadivisi = 0;
            $kbdivisi = 0;
            $nbdivisi = 0;
            $totkdivisi = 0;
            $totndivisi = 0;

            $katotal = 0;
            $natotal = 0;
            $kbtotal = 0;
            $nbtotal = 0;
            $totktotal = 0;
            $totntotal = 0;
        ?>
        @for($i=0;$i<sizeof($datas);$i++)

            @if($divisi != $datas[$i]->tpod_kodedivisi)
                @if($i!=0)
                    <tr>
                        <td colspan="4" style="border-top: 2px solid black; border-bottom: 2px solid black">Total Per Divisi : </td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kadivisi)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nadivisi)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kbdivisi)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nbdivisi)}}</td>
                        @if($kadivisi != 0 && $kbdivisi != 0)
                            <?php
                            $totkdivisi = (($kbdivisi)/(($kadivisi)))*100;
                            $totkdivisi = number_format((float)$totkdivisi, 2, '.', '');
                            ?>
                        @else
                            <?php
                            $totkdivisi = 0;
                            ?>
                        @endif
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totkdivisi}}</td>
                        @if($nadivisi != 0 && $nbdivisi != 0)
                            <?php
                            $totndivisi = (($nbdivisi)/(($nadivisi)))*100;
                            $totndivisi = number_format((float)$totndivisi, 2, '.', '');
                            ?>
                        @else
                            <?php
                            $totndivisi = 0;
                            ?>
                        @endif
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totndivisi}}</td>
                    </tr>
                @endif
                <tr>
                <td colspan="10" style="border-top: 2px solid black; border-bottom: 2px solid black">DIVISI : {{$datas[$i]->tpod_kodedivisi}} - {{$datas[$i]->div_namadivisi}}</td>
                </tr>
                <?php
                $divisi = $datas[$i]->tpod_kodedivisi;

                $katotal = $katotal + $kadivisi;
                $natotal = $natotal + $nadivisi;
                $kbtotal = $kbtotal + $kbdivisi;
                $nbtotal = $nbtotal + $nbdivisi;

                $kadivisi = 0;
                $nadivisi = 0;
                $kbdivisi = 0;
                $nbdivisi = 0;
                $totkdivisi = 0;
                $totndivisi = 0;
                ?>
            @endif
            @if($departemen != $datas[$i]->tpod_kodedepartemen)
                @if($i!=0)
                    <tr>
                        <td colspan="4" style="border-top: 2px solid black; border-bottom: 2px solid black">Total Per Departemen : </td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kadepartement)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nadepartement)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kbdepartement)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nbdepartement)}}</td>
                        @if($kadepartement != 0 && $kbdepartement != 0)
                            <?php
                            $totkdepartement = (($kbdepartement)/(($kadepartement)))*100;
                            $totkdepartement = number_format((float)$totkdepartement, 2, '.', '');
                            ?>
                        @else
                            <?php
                            $totkdepartement = 0;
                            ?>
                        @endif
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totkdepartement}}</td>
                        @if($nadepartement != 0 && $nbdepartement != 0)
                            <?php
                            $totndepartement = (($nbdepartement)/(($nadepartement)))*100;
                            $totndepartement = number_format((float)$totndepartement, 2, '.', '');
                            ?>
                        @else
                            <?php
                            $totndepartement = 0;
                            ?>
                        @endif
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totndepartement}}</td>
                    </tr>
                @endif
                <tr>
                <td style="border-top: 2px solid black; border-bottom: 2px solid black"> </td>
                <td colspan="9" style="border-top: 2px solid black; border-bottom: 2px solid black">DEPARTEMEN : {{$datas[$i]->tpod_kodedepartemen}} - {{$datas[$i]->dep_namadepartement}}</td>
                </tr>
                <?php
                $departemen = $datas[$i]->tpod_kodedepartemen;

                $kadivisi = $kadivisi + $kadepartement;
                $nadivisi = $nadivisi + $nadepartement;
                $kbdivisi = $kbdivisi + $kbdepartement;
                $nbdivisi = $nbdivisi + $nbdepartement;

                $kadepartement = 0;
                $nadepartement = 0;
                $kbdepartement = 0;
                $nbdepartement = 0;
                $totkdepartement = 0;
                $totndepartement = 0;
                ?>
            @endif
            @if($kategori != $datas[$i]->tpod_kategoribarang)
                @if($i!=0)
                    <tr>
                        <td colspan="4" style="border-top: 2px solid black; border-bottom: 2px solid black">Total Per Kategori : </td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kakategori)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nakategori)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kbkategori)}}</td>
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nbkategori)}}</td>
                        @if($kakategori != 0 && $kbkategori != 0)
                            <?php
                            $totkkategori = (($kbkategori)/(($kakategori)))*100;
                            $totkkategori = number_format((float)$totkkategori, 2, '.', '');
                            ?>
                        @else
                            <?php
                            $totkkategori = 0;
                            ?>
                        @endif
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totkkategori}}</td>
                        @if($nakategori != 0 && $nbkategori != 0)
                            <?php
                            $totnkategori = (($nbkategori)/(($nakategori)))*100;
                            $totnkategori = number_format((float)$totnkategori, 2, '.', '');
                            ?>
                        @else
                            <?php
                            $totnkategori = 0;
                            ?>
                        @endif
                        <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totnkategori}}</td>
                    </tr>
                @endif
                <tr>
                <td colspan="2" style="border-top: 2px solid black; border-bottom: 2px solid black"> </td>
                <td colspan="8" style="border-top: 2px solid black; border-bottom: 2px solid black">KATEGORI : {{$datas[$i]->tpod_kategoribarang}} - {{$datas[$i]->kat_namakategori}}</td>
                </tr>
                <?php
                $kategori = $datas[$i]->tpod_kategoribarang;

                $kadepartement = $kadepartement + $kakategori;
                $nadepartement = $nadepartement + $nakategori;
                $kbdepartement = $kbdepartement + $kbkategori;
                $nbdepartement = $nbdepartement + $nbkategori;

                $kakategori = 0;
                $nakategori = 0;
                $kbkategori = 0;
                $nbkategori = 0;
                $totkkategori = 0;
                $totnkategori = 0;
                ?>
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
                    $kakategori = $kakategori + $datas[$i]->qtypo;
                    $nakategori = $nakategori + $datas[$i]->nilaia;
                    $kbkategori = $kbkategori + $datas[$i]->kuanb;
                    $nbkategori = $nbkategori + $datas[$i]->nilaib;
                ?>
            </tr>
        @endfor
        <?php
        $kadepartement = $kadepartement + $kakategori;
        $nadepartement = $nadepartement + $nakategori;
        $kbdepartement = $kbdepartement + $kbkategori;
        $nbdepartement = $nbdepartement + $nbkategori;

        $kadivisi = $kadivisi + $kadepartement;
        $nadivisi = $nadivisi + $nadepartement;
        $kbdivisi = $kbdivisi + $kbdepartement;
        $nbdivisi = $nbdivisi + $nbdepartement;

        $katotal = $katotal + $kadivisi;
        $natotal = $natotal + $nadivisi;
        $kbtotal = $kbtotal + $kbdivisi;
        $nbtotal = $nbtotal + $nbdivisi;
        ?>
        <tr>
            <td colspan="4" style="border-top: 2px solid black; border-bottom: 2px solid black">Total Per Kategori : </td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kakategori)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nakategori)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kbkategori)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nbkategori)}}</td>
            @if($kakategori != 0 && $kbkategori != 0)
                <?php
                $totkkategori = (($kbkategori)/(($kakategori)))*100;
                $totkkategori = number_format((float)$totkkategori, 2, '.', '');
                ?>
            @else
                <?php
                $totkkategori = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totkkategori}}</td>
            @if($nakategori != 0 && $nbkategori != 0)
                <?php
                $totnkategori = (($nbkategori)/(($nakategori)))*100;
                $totnkategori = number_format((float)$totnkategori, 2, '.', '');
                ?>
            @else
                <?php
                $totnkategori = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totnkategori}}</td>
        </tr>
        <tr>
            <td colspan="4" style="border-top: 2px solid black; border-bottom: 2px solid black">Total Per Departemen : </td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kadepartement)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nadepartement)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kbdepartement)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nbdepartement)}}</td>
            @if($kadepartement != 0 && $kbdepartement != 0)
                <?php
                $totkdepartement = (($kbdepartement)/(($kadepartement)))*100;
                $totkdepartement = number_format((float)$totkdepartement, 2, '.', '');
                ?>
            @else
                <?php
                $totkdepartement = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totkdepartement}}</td>
            @if($nadepartement != 0 && $nbdepartement != 0)
                <?php
                $totndepartement = (($nbdepartement)/(($nadepartement)))*100;
                $totndepartement = number_format((float)$totndepartement, 2, '.', '');
                ?>
            @else
                <?php
                $totndepartement = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totndepartement}}</td>
        </tr>
        <tr>
            <td colspan="4" style="border-top: 2px solid black; border-bottom: 2px solid black">Total Per Divisi : </td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kadivisi)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nadivisi)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($kbdivisi)}}</td>
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{rupiah($nbdivisi)}}</td>
            @if($kadivisi != 0 && $kbdivisi != 0)
                <?php
                $totkdivisi = (($kbdivisi)/(($kadivisi)))*100;
                $totkdivisi = number_format((float)$totkdivisi, 2, '.', '');
                ?>
            @else
                <?php
                $totkdivisi = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totkdivisi}}</td>
            @if($nadivisi != 0 && $nbdivisi != 0)
                <?php
                $totndivisi = (($nbdivisi)/(($nadivisi)))*100;
                $totndivisi = number_format((float)$totndivisi, 2, '.', '');
                ?>
            @else
                <?php
                $totndivisi = 0;
                ?>
            @endif
            <td style="text-align: right; border-top: 2px solid black; border-bottom: 2px solid black">{{$totndivisi}}</td>
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
