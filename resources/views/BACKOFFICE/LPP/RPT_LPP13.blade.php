<html>
<head>
    <title>LAPORAN</title>
</head>
<style>
    /**
        Set the margins of the page to 0, so the footer and the header
        can be of the full height and width !
     **/
    @page {
        margin: 25px 10px;
        size: 900pt 595pt;

    }

    table {
        width: 100%;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 70px;
        margin-bottom: 10px;
        font-size: 8px;
        /*font-size: 9px;*/
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

    .page-numbers:after {
        content: counter(page);
    }

    .page-break {
        page-break-after: always;
    }
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
    <div style="float:left; margin-top: -20px; line-height: 5px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 5px !important;">
        <p>{{ date("d/m/y  H:i:s") }}</p>
        <p>RINCIAN PER DIVISI (UNIT/RUPIAH)</p>
    </div>
    <div style="line-height: 0.1 !important; text-align: center !important;">
        <h2 style="">{{ $datas[0]->judul }} </h2>
        <p style="font-size: 10px !important;">TANGGAL : {{$tgl1 }}
            s/d {{$tgl2 }}</p>
    </div>
</header>

<main>
    @php
        $tempsup = '';
        $tempsup = '';

        $count_prdcd = 0;
        $total_prdcd = 0;

        $st_sawalrph      =0;
        $st_belirph       =0;
        $st_bonusrph      =0;
        $st_trmcbrph      =0;
        $st_retursalesrph =0;
        $st_rafakrph      =0;
        $st_repackrph     =0;
        $st_laininrph     =0;
        $st_salesrph      =0;
        $st_kirimrph      =0;
        $st_prepackrph    =0;
        $st_hilangrph     =0;
        $st_lainoutrph    =0;
        $st_intrstrph     =0;
        $st_sadj          =0;

        $total_sawalrph      =0;
        $total_belirph       =0;
        $total_bonusrph      =0;
        $total_trmcbrph      =0;
        $total_retursalesrph =0;
        $total_rafakrph      =0;
        $total_repackrph     =0;
        $total_laininrph     =0;
        $total_salesrph      =0;
        $total_kirimrph      =0;
        $total_prepackrph    =0;
        $total_hilangrph     =0;
        $total_lainoutrph    =0;
        $total_intrstrph     =0;
        $total_sadj          =0;
    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="3" style="text-align: right"></th>
            <th colspan="2" style="text-align: center">----PEMBELIAN----</th>
            <th colspan="5" style="text-align: center">----PENERIMAAN----</th>
            <th colspan="5" style="text-align: center">----PENGELUARAN----</th>
        </tr>
        <tr style="text-align: center;">
            <th></th>
            <th>SALDO AWAL</th>
            <th>MURNI</th>
            <th>BONUS</th>
            <th>TRANSFER IN</th>
            <th>RETUR<br> PENJUALAN</th>
            <th>RAFAKSI</th>
            <th>REPACK IN<br>(REPACK)</th>
            <th>LAIN-LAIN</th>
            <th>PENJUALAN</th>
            <th>TRANSFER OUT</th>
            <th>REPACK OUT<br>(PREPACK)</th>
            <th>HILANG</th>
            <th>LAIN-LAIN</th>
            <th>INTRANSIT</th>
            <th>PENYESUAIAN</th>
            <th>KOREKSI</th>
            <th>SALDO<br>AKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($datas);$i++)
            @if($tempsup != $datas[$i]->sup_kodesupplier)
                <tr>
                    <td class="left"><b>SUPPLIER: </b></td>
                    <td class="left"><b>{{$datas[$i]->sup_kodesupplier}}
                            - {{$datas[$i]->sup_namasupplier}}</b></td>
                </tr>
            @endif;
            <tr>
                <td class="left"><b>{{$datas[$i]->lpp_prdcd}}</b></td>
                <td class="left"><b>{{$datas[$i]->prd_deskripsipanjang}}</b>
                </td>
            </tr>
            <tr>
                <td align="left">UNIT : </td>
                <td align="right">{{ number_format($datas[$i]->sawalqty      ,2)}} </td>
                <td align="right">{{ number_format($datas[$i]->beliqty       ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->bonusqty      ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->trmcbqty      ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->retursalesqty ,2) }}</td>
                <td align="right"></td>
                <td align="right">{{ number_format($datas[$i]->repackqty     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->laininqty     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->salesqty      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->kirimqty      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->prepackqty    ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->hilangqty     ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lainoutqty    ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->intrstqty     ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->adjqty        ,2) }}</td>
                <td align="right">0</td>
                <td align="right">{{ number_format($datas[$i]->akhirqty      ,2) }}</td>
            </tr>
            <tr>
                <td align="left">Rp. </td>
                <td align="right">{{ number_format($datas[$i]->sawalrph      ,2) }} </td>
                <td align="right">{{ number_format($datas[$i]->belirph       ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->bonusrph      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->trmcbrph      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->retursalesrph ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->rafakrph      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->repackrph     ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->laininrph     ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->salesrph      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->kirimrph      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->prepackrph    ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->hilangrph     ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lainoutrph    ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->intrstrph     ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->sadj          ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->akhirrph      ,2) }}</td>
            </tr>
            @php
                $count_prdcd++;
                $total_prdcd++;

                $st_sawalrph      += $datas[$i]->sawalrph     ;
                $st_belirph       += $datas[$i]->belirph      ;
                $st_bonusrph      += $datas[$i]->bonusrph     ;
                $st_trmcbrph      += $datas[$i]->trmcbrph     ;
                $st_retursalesrph += $datas[$i]->retursalesrph;
                $st_rafakrph      += $datas[$i]->rafakrph     ;
                $st_repackrph     += $datas[$i]->repackrph    ;
                $st_laininrph     += $datas[$i]->laininrph    ;
                $st_salesrph      += $datas[$i]->salesrph     ;
                $st_kirimrph      += $datas[$i]->kirimrph     ;
                $st_prepackrph    += $datas[$i]->prepackrph   ;
                $st_hilangrph     += $datas[$i]->hilangrph    ;
                $st_lainoutrph    += $datas[$i]->lainoutrph   ;
                $st_intrstrph     += $datas[$i]->intrstrph    ;
                $st_sadj          += $datas[$i]->sadj         ;

                $total_sawalrph      += $datas[$i]->sawalrph     ;
                $total_belirph       += $datas[$i]->belirph      ;
                $total_bonusrph      += $datas[$i]->bonusrph     ;
                $total_trmcbrph      += $datas[$i]->trmcbrph     ;
                $total_retursalesrph += $datas[$i]->retursalesrph;
                $total_rafakrph      += $datas[$i]->rafakrph     ;
                $total_repackrph     += $datas[$i]->repackrph    ;
                $total_laininrph     += $datas[$i]->laininrph    ;
                $total_salesrph      += $datas[$i]->salesrph     ;
                $total_kirimrph      += $datas[$i]->kirimrph     ;
                $total_prepackrph    += $datas[$i]->prepackrph   ;
                $total_hilangrph     += $datas[$i]->hilangrph    ;
                $total_lainoutrph    += $datas[$i]->lainoutrph   ;
                $total_intrstrph     += $datas[$i]->intrstrph    ;
                $total_sadj          += $datas[$i]->sadj         ;

                $tempsup = $datas[$i]->lpp_kodedivisi;
                $tempdep = $datas[$i]->lpp_kodedepartemen;
            @endphp
            @if( isset($datas[$i+1]->sup_kodesupplier) && $tempsup != $datas[$i+1]->sup_kodesupplier || !(isset($datas[$i+1]->sup_kodesupplier)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUBTOTAL PER SUPPLIER :</td>
                    <td align="right">{{ number_format($st_sawalrph     ,2)}}</td>
                    <td align="right">{{ number_format($st_belirph      ,2)}}</td>
                    <td align="right">{{ number_format($st_bonusrph     ,2)}}</td>
                    <td align="right">{{ number_format($st_trmcbrph     ,2) }}</td>
                    <td align="right">{{ number_format($st_retursalesrph,2)}}</td>
                    <td align="right">{{ number_format($st_rafakrph     ,2)}}</td>
                    <td align="right">{{ number_format($st_repackrph    ,2) }}</td>
                    <td align="right">{{ number_format($st_laininrph    ,2) }}</td>
                    <td align="right">{{ number_format($st_salesrph     ,2) }}</td>
                    <td align="right">{{ number_format($st_kirimrph     ,2) }}</td>
                    <td align="right">{{ number_format($st_prepackrph   ,2) }}</td>
                    <td align="right">{{ number_format($st_hilangrph    ,2) }}</td>
                    <td align="right">{{ number_format($st_lainoutrph   ,2) }}</td>
                    <td align="right">{{ number_format($st_intrstrph    ,2) }}</td>
                    <td align="right">{{ number_format($st_sadj         ,2) }}</td>
                </tr>
                @php
                    $st_sawalrph     = 0;
                    $st_belirph      = 0;
                    $st_bonusrph     = 0;
                    $st_trmcbrph     = 0;
                    $st_retursalesrph= 0;
                    $st_rafakrph     = 0;
                    $st_repackrph    = 0;
                    $st_laininrph    = 0;
                    $st_salesrph     = 0;
                    $st_kirimrph     = 0;
                    $st_prepackrph   = 0;
                    $st_hilangrph    = 0;
                    $st_lainoutrph   = 0;
                    $st_intrstrph    = 0;
                    $st_sadj         = 0;
                @endphp
            @endif

        @endfor

        </tbody>
        <tfoot style="border-bottom: 1px solid black;border-top: 1px solid black;">
        <tr>
            <td class="left" colspan="1"><strong>TOTAL :</strong></td>
            <td align="right">{{ number_format($total_sawalrph     ,2) }}</td>
            <td align="right">{{ number_format($total_belirph      ,2) }}</td>
            <td align="right">{{ number_format($total_bonusrph     ,2) }}</td>
            <td align="right">{{ number_format($total_trmcbrph     ,2) }}</td>
            <td align="right">{{ number_format($total_retursalesrph,2) }}</td>
            <td align="right">{{ number_format($total_rafakrph     ,2) }}</td>
            <td align="right">{{ number_format($total_repackrph    ,2) }}</td>
            <td align="right">{{ number_format($total_laininrph    ,2) }}</td>
            <td align="right">{{ number_format($total_salesrph     ,2) }}</td>
            <td align="right">{{ number_format($total_kirimrph     ,2) }}</td>
            <td align="right">{{ number_format($total_prepackrph   ,2) }}</td>
            <td align="right">{{ number_format($total_hilangrph    ,2) }}</td>
            <td align="right">{{ number_format($total_lainoutrph   ,2) }}</td>
            <td align="right">{{ number_format($total_intrstrph    ,2) }}</td>
            <td align="right">{{ number_format($total_sadj         ,2) }}</td>
        </tr>
        </tfoot>
    </table>

    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>

</main>
</body>
</html>
