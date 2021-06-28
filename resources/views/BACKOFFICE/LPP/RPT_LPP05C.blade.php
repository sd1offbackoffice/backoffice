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
        <h2 style="">{{ $title }} </h2>
        <p style="font-size: 10px !important;">TANGGAL : {{$tgl1 }}
            s/d {{$tgl2 }}</p>
    </div>
</header>

<main>
    @php
        $tempdiv = '';
        $tempdep = '';

        $count_prdcd = 0;
        $total_prdcd = 0;

        $st_sawalqty      = 0;
        $st_akhirqty      = 0;
        $st_servtok      = 0;


        $st_sawalrph      = 0;
        $st_belirph       = 0;
        $st_bonusrph      = 0;
        $st_trmcbrph      = 0;
        $st_returrph     = 0;
        $st_rafakrph     = 0;
        $st_repackrph     = 0;
        $st_laininrph     = 0;
        $st_salesrph      = 0;
        $st_kirimrph      = 0;
        $st_repackrph    = 0;
        $st_hilangrph     = 0;
        $st_selsorph     = 0;
        $st_lainoutrph    = 0;
        $st_intrstrph     = 0;
        $st_adjrph        = 0;
        $st_koreksirph    = 0;
        $st_akhirrph      = 0;
        $st_servsup     = 0;


        $total_akhirqty      = 0;
        $total_servtok     = 0;

        $total_sawalqty      = 0;
        $total_sawalrph      = 0;
        $total_belirph       = 0;
        $total_bonusrph      = 0;
        $total_trmcbrph      = 0;
        $total_returrph     = 0;
        $total_selsorph     = 0;
        $total_repackrph     = 0;
        $total_laininrph     = 0;
        $total_salesrph      = 0;
        $total_kirimrph      = 0;
        $total_repackrph    = 0;
        $total_hilangrph     = 0;
        $total_selisih_so = 0;
        $total_lainoutrph    = 0;
        $total_intrstrph     = 0;
        $total_adjrph        = 0;
        $total_koreksirph    = 0;
        $total_akhirrph      = 0;
        $total_servsup      = 0;
    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="2" style="text-align: right"></th>
            <th colspan="2" style="text-align: center">----PEMBELIAN----</th>
            <th colspan="5" style="text-align: center">----PENERIMAAN----</th>
            <th colspan="5" style="text-align: center">----PENGELUARAN----</th>
        </tr>
        <tr style="text-align: center;">
            <th></th>
            <th width="10%">SALDO AWAL</th>
            <th>MURNI</th>
            <th>BONUS</th>
            <th>TRANSFER IN</th>
            <th>RETUR<br> PENJUALAN</th>
            <th>REPACK IN<br>(REPACK)</th>
            <th>LAIN-LAIN</th>
            <th>PENJUALAN</th>
            <th>TRANSFER OUT</th>
            <th>REPACK OUT<br>(PREPACK)</th>
            <th>HILANG</th>
            <th>SO</th>
            <th>LAIN-LAIN</th>
            <th>INTRANSIT</th>
            <th>PENYESUAIAN</th>
            <th>KOREKSI</th>
            <th>SALDO<br>AKHIR</th>
            <th>SERVICE<br>TOKO<br>/ SUPPLIER</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($datas);$i++)
            @if($tempdep != $datas[$i]->lpp_kodedepartemen)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left"><b>{{$datas[$i]->lpp_kodedepartemen}}
                            - {{$datas[$i]->dep_namadepartement}}</b></td>
                </tr>
                <tr>
                    <td class="left"><b>KATEGORI :</b></td>
                    <td class="left"><b>{{$datas[$i]->lpp_kategoribrg}} - {{$datas[$i]->kat_namakategori}}</b>
                    </td>
                </tr>
            @endif;
            <tr>
                <td align="left">{{ $datas[$i]->lpp_prdcd }}</td>
                <td colspan="3" align="left">{{ $datas[$i]->prd_deskripsipanjang }}</td>
                <td align="left">{{ $datas[$i]->kemasan }}</td>
            </tr>
            <tr>
                <td align="left">UNIT :</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtybegbal       ,2)}} </td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtybeli         ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtybonus        ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtytrmcb        ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtyretursales   ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtyrepack       ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtylainin       ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtysales        ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtykirim        ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtyprepacking   ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtyhilang       ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qty_selisih_so  ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtylainout      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtyintransit    ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtyadj          ,2) }}</td>
                <td align="right">{{ 0 }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_qtyakhir        ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_tokoservq       ,2) }}</td>
            </tr>
            <tr>
                <td align="left">Rp :</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphbegbal       ,2)}} </td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphbeli         ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphbonus        ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphtrmcb        ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphretursales   ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphrepack       ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphlainin       ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphsales        ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphkirim        ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphprepacking   ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphhilang       ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rph_selisih_so  ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphlainout      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphintransit    ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphadj          ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->koreksi             ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_rphakhir        ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lpp_supplierservq   ,2) }}</td>
            </tr>
            @php
                $count_prdcd++;
                $total_prdcd++;

                $st_akhirqty      += $datas[$i]->lpp_qtyakhir  ;
                $st_servtok      += $datas[$i]->lpp_tokoservq  ;

                $st_sawalqty      += $datas[$i]->lpp_qtybegbal  ;
                $st_sawalrph      += $datas[$i]->lpp_rphbegbal    ;
                $st_belirph       += $datas[$i]->lpp_rphbeli      ;
                $st_bonusrph      += $datas[$i]->lpp_rphbonus     ;
                $st_trmcbrph      += $datas[$i]->lpp_rphtrmcb     ;
                $st_returrph      += $datas[$i]->lpp_rphretursales;
                $st_rafakrph      += $datas[$i]->lpp_rphrepack    ;
                $st_laininrph     += $datas[$i]->lpp_rphlainin    ;
                $st_salesrph      += $datas[$i]->lpp_rphsales     ;
                $st_kirimrph      += $datas[$i]->lpp_rphkirim     ;
                $st_repackrph     += $datas[$i]->lpp_rphprepacking;
                $st_hilangrph     += $datas[$i]->lpp_rphhilang    ;
                $st_selsorph     += $datas[$i]->lpp_rph_selisih_so;
                $st_lainoutrph    += $datas[$i]->lpp_rphlainout   ;
                $st_intrstrph     += $datas[$i]->lpp_rphintransit ;
                $st_adjrph        += $datas[$i]->lpp_rphadj       ;
                $st_koreksirph    += $datas[$i]->koreksi          ;
                $st_akhirrph      += $datas[$i]->lpp_rphakhir     ;
                $st_servsup      += $datas[$i]->lpp_supplierservq ;

                $total_akhirqty    += $datas[$i]->lpp_qtyakhir;
                $total_servtok     += $datas[$i]->lpp_tokoservq;

                $total_sawalqty      += $datas[$i]->lpp_qtybegbal  ;
                $total_sawalrph      += $datas[$i]->lpp_rphbegbal;
                $total_belirph       += $datas[$i]->lpp_rphbeli;
                $total_bonusrph      += $datas[$i]->lpp_rphbonus;
                $total_trmcbrph      += $datas[$i]->lpp_rphtrmcb;
                $total_returrph      += $datas[$i]->lpp_rphretursales ;
                $total_selsorph       += $datas[$i]->lpp_rph_selisih_so;
                $total_repackrph     += $datas[$i]->lpp_rphprepacking;
                $total_laininrph     += $datas[$i]->lpp_rphlainin;
                $total_salesrph      += $datas[$i]->lpp_rphsales;
                $total_kirimrph      += $datas[$i]->lpp_rphkirim;
                $total_hilangrph     += $datas[$i]->lpp_rphhilang;
                $total_selisih_so    += $datas[$i]->lpp_rph_selisih_so;
                $total_lainoutrph    += $datas[$i]->lpp_rphlainout;
                $total_intrstrph     += $datas[$i]->lpp_rphintransit;
                $total_adjrph        += $datas[$i]->lpp_rphadj;
                $total_koreksirph    += $datas[$i]->koreksi;
                $total_akhirrph      += $datas[$i]->lpp_rphakhir;
                $total_servsup     += $datas[$i]->lpp_supplierservq;

                $tempdep = $datas[$i]->lpp_kodedepartemen;
            @endphp
            @if( isset($datas[$i+1]->lpp_kodedepartemen) && $tempdep != $datas[$i+1]->lpp_kodedepartemen || !(isset($datas[$i+1]->lpp_kodedepartemen)) )
                <tr>
                    <td class="right">{{ $count_prdcd }}</td>
                    <td class="left">ITEM</td>
                </tr>
                <tr>
                    <td class="left">UNIT :</td>
                    <td class="right" colspan="16">{{ $st_sawalqty }}</td>
                    <td align="right">{{ number_format($st_akhirqty    ,2) }}</td>
                    <td align="right">{{ number_format($st_servsup    ,2) }}</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">Rp.</td>
                    <td align="right">{{ number_format($st_sawalrph            ,2)}}</td>
                    <td align="right">{{ number_format($st_belirph            ,2)}}</td>
                    <td align="right">{{ number_format($st_bonusrph           ,2)}}</td>
                    <td align="right">{{ number_format($st_trmcbrph  ,2) }}</td>
                    <td align="right">{{ number_format($st_returrph          ,2)}}</td>
                    <td align="right">{{ number_format($st_repackrph     ,2) }}</td>
                    <td align="right">{{ number_format($st_laininrph     ,2) }}</td>
                    <td align="right">{{ number_format($st_salesrph     ,2) }}</td>
                    <td align="right">{{ number_format($st_kirimrph      ,2) }}</td>
                    <td align="right">{{ number_format($st_repackrph    ,2) }}</td>
                    <td align="right">{{ number_format($st_hilangrph ,2) }}</td>
                    <td align="right">{{ number_format($st_selsorph ,2) }}</td>
                    <td align="right">{{ number_format($st_lainoutrph    ,2) }}</td>
                    <td align="right">{{ number_format($st_intrstrph     ,2) }}</td>
                    <td align="right">{{ number_format($st_adjrph       ,2) }}</td>
                    <td align="right">{{ number_format($st_koreksirph    ,2) }}</td>
                    <td align="right">{{ number_format($st_akhirrph    ,2) }}</td>
                    <td align="right">{{ number_format($st_servsup    ,2) }}</td>
                </tr>
                @php
                    $st_akhirqty     =0;
                    $st_servtok      =0;
                    $st_sawalqty     =0;
                    $st_sawalrph     =0;
                    $st_belirph      =0;
                    $st_bonusrph     =0;
                    $st_trmcbrph     =0;
                    $st_returrph     =0;
                    $st_laininrph    =0;
                    $st_salesrph     =0;
                    $st_kirimrph     =0;
                    $st_repackrph    =0;
                    $st_hilangrph    =0;
                    $st_selsorph     =0;
                    $st_lainoutrph   =0;
                    $st_intrstrph    =0;
                    $st_adjrph       =0;
                    $st_koreksirph   =0;
                    $st_akhirrph     =0;
                    $st_servsup   =0;
                    $count_prdcd      = 0;

                @endphp
            @endif
        @endfor

        </tbody>
        <tfoot style="border-bottom: 1px solid black;border-top: 1px solid black;">
        <tr>
            <td class="right"><strong>TOTAL</strong></td>
            <td class="right">{{ $total_prdcd }}</td>
            <td class="text-left"><strong>ITEM</strong></td>
        </tr>
        <tr>
            <td class="left"><strong>UNIT :</strong></td>
            <td class="right" colspan="16">{{ $total_sawalqty }}</td>
            <td align="right">{{ number_format($total_akhirqty    ,2) }}</td>
            <td align="right">{{ number_format($total_servsup    ,2) }}</td>
        </tr>
        <tr>
            <td class="left">Rp.</td>
            <td align="right">{{ number_format($total_sawalrph            ,2)}}</td>
            <td align="right">{{ number_format($total_belirph            ,2)}}</td>
            <td align="right">{{ number_format($total_bonusrph           ,2)}}</td>
            <td align="right">{{ number_format($total_trmcbrph  ,2) }}</td>
            <td align="right">{{ number_format($total_returrph          ,2)}}</td>
            <td align="right">{{ number_format($total_repackrph     ,2) }}</td>
            <td align="right">{{ number_format($total_laininrph     ,2) }}</td>
            <td align="right">{{ number_format($total_salesrph     ,2) }}</td>
            <td align="right">{{ number_format($total_kirimrph      ,2) }}</td>
            <td align="right">{{ number_format($total_repackrph    ,2) }}</td>
            <td align="right">{{ number_format($total_hilangrph ,2) }}</td>
            <td align="right">{{ number_format($total_selsorph ,2) }}</td>
            <td align="right">{{ number_format($total_lainoutrph    ,2) }}</td>
            <td align="right">{{ number_format($total_intrstrph     ,2) }}</td>
            <td align="right">{{ number_format($total_adjrph       ,2) }}</td>
            <td align="right">{{ number_format($total_koreksirph    ,2) }}</td>
            <td align="right">{{ number_format($total_akhirrph    ,2) }}</td>
            <td align="right">{{ number_format($total_servsup    ,2) }}</td>
        </tr>
        </tfoot>
    </table>

    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>

</main>
</body>
</html>
