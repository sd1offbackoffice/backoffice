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

        $st_div_sawalrph   = 0;
        $st_div_sawalqty   = 0;
        $st_div_beli       = 0;
        $st_div_bonus      = 0;
        $st_div_trmcb      = 0;
        $st_div_retursales = 0;
        $st_div_repack     = 0;
        $st_div_lainin     = 0;
        $st_div_sales      = 0;
        $st_div_kirim      = 0;
        $st_div_prepack    = 0;
        $st_div_hilang     = 0;
        $st_div_lainout    = 0;
        $st_div_rph_sel_so = 0;
        $st_div_intrst     = 0;
        $st_div_adj        = 0;
        $st_div_koreksi    = 0;
        $st_div_akhir      = 0;

        $st_dep_sawalrph   = 0;
        $st_dep_sawalqty   = 0;
        $st_dep_beli       = 0;
        $st_dep_bonus      = 0;
        $st_dep_trmcb      = 0;
        $st_dep_retursales = 0;
        $st_dep_repack     = 0;
        $st_dep_lainin     = 0;
        $st_dep_sales      = 0;
        $st_dep_kirim      = 0;
        $st_dep_prepack    = 0;
        $st_dep_hilang     = 0;
        $st_dep_lainout    = 0;
        $st_dep_rph_sel_so = 0;
        $st_dep_intrst     = 0;
        $st_dep_adj        = 0;
        $st_dep_koreksi    = 0;
        $st_dep_akhir      = 0;

        $total_sawalrph   = 0;
        $total_sawalqty   = 0;
        $total_beli       = 0;
        $total_bonus      = 0;
        $total_trmcb      = 0;
        $total_retursales = 0;
        $total_repack     = 0;
        $total_lainin     = 0;
        $total_sales      = 0;
        $total_kirim      = 0;
        $total_prepack    = 0;
        $total_hilang     = 0;
        $total_lainout    = 0;
        $total_rph_sel_so = 0;
        $total_intrst     = 0;
        $total_adj        = 0;
        $total_koreksi    = 0;
        $total_akhir      = 0;
    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="3" style="text-align: center"></th>
            <th colspan="2" style="text-align: center">----PEMBELIAN----</th>
            <th colspan="5" style="text-align: center">----PENERIMAAN----</th>
            <th colspan="5" style="text-align: center">----PENGELUARAN----</th>
        </tr>
        <tr style="text-align: center;">
            <th>KODE</th>
            <th>NAMA KATEGORI</th>
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
            <th>LAIN-LAIN</th>
            <th>SO</th>
            <th>INTRANSIT</th>
            <th>PENYESUAIAN</th>
            <th>KOREKSI</th>
            <th>SALDO<br>AKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($datas);$i++)
            @if($tempdiv != $datas[$i]->lpp_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="17"><b>{{$datas[$i]->lpp_kodedivisi}} - {{$datas[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif;
            @if($tempdep != $datas[$i]->lpp_kodedepartemen)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="17"><b>{{$datas[$i]->lpp_kodedepartemen}}
                            - {{$datas[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif;
            <tr>
                <td align="left">{{ $datas[$i]->lpp_kategoribrg }}</td>
                <td align="left">{{ $datas[$i]->kat_namakategori }}</td>
                <td align="right">{{ number_format($datas[$i]->sawalrph  ,2)}} ( {{$datas[$i]->sawalqty}} )</td>
                <td align="right">{{ number_format($datas[$i]->beli      ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->bonus     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->trmcb     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->retursales,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->repack    ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lainin    ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->sales,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->kirim,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->prepack,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->hilang,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lainout,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->rph_sel_so,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->intrst,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->adj,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->koreksi,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->akhir,2) }}</td>
            </tr>
            @php
        $st_div_sawalrph   += $datas[$i]->sawalrph   ;
        $st_div_sawalqty   += $datas[$i]->sawalqty   ;
        $st_div_beli       += $datas[$i]->beli       ;
        $st_div_bonus      += $datas[$i]->bonus      ;
        $st_div_trmcb      += $datas[$i]->trmcb      ;
        $st_div_retursales += $datas[$i]->retursales ;
        $st_div_repack     += $datas[$i]->repack     ;
        $st_div_lainin     += $datas[$i]->lainin     ;
        $st_div_sales      += $datas[$i]->sales      ;
        $st_div_kirim      += $datas[$i]->kirim      ;
        $st_div_prepack    += $datas[$i]->prepack    ;
        $st_div_hilang     += $datas[$i]->hilang     ;
        $st_div_lainout    += $datas[$i]->lainout    ;
        $st_div_rph_sel_so += $datas[$i]->rph_sel_so ;
        $st_div_intrst     += $datas[$i]->intrst     ;
        $st_div_adj        += $datas[$i]->adj        ;
        $st_div_koreksi    += $datas[$i]->koreksi    ;
        $st_div_akhir      += $datas[$i]->akhir      ;

        $st_dep_sawalrph   += $datas[$i]->sawalrph   ;
        $st_dep_sawalqty   += $datas[$i]->sawalqty   ;
        $st_dep_beli       += $datas[$i]->beli       ;
        $st_dep_bonus      += $datas[$i]->bonus      ;
        $st_dep_trmcb      += $datas[$i]->trmcb      ;
        $st_dep_retursales += $datas[$i]->retursales ;
        $st_dep_repack     += $datas[$i]->repack     ;
        $st_dep_lainin     += $datas[$i]->lainin     ;
        $st_dep_sales      += $datas[$i]->sales      ;
        $st_dep_kirim      += $datas[$i]->kirim      ;
        $st_dep_prepack    += $datas[$i]->prepack    ;
        $st_dep_hilang     += $datas[$i]->hilang     ;
        $st_dep_lainout    += $datas[$i]->lainout    ;
        $st_dep_rph_sel_so += $datas[$i]->rph_sel_so ;
        $st_dep_intrst     += $datas[$i]->intrst     ;
        $st_dep_adj        += $datas[$i]->adj        ;
        $st_dep_koreksi    += $datas[$i]->koreksi    ;
        $st_dep_akhir      += $datas[$i]->akhir      ;

        $total_sawalrph   += $datas[$i]->sawalrph   ;
        $total_sawalqty   += $datas[$i]->sawalqty   ;
        $total_beli       += $datas[$i]->beli       ;
        $total_bonus      += $datas[$i]->bonus      ;
        $total_trmcb      += $datas[$i]->trmcb      ;
        $total_retursales += $datas[$i]->retursales ;
        $total_repack     += $datas[$i]->repack     ;
        $total_lainin     += $datas[$i]->lainin     ;
        $total_sales      += $datas[$i]->sales      ;
        $total_kirim      += $datas[$i]->kirim      ;
        $total_prepack    += $datas[$i]->prepack    ;
        $total_hilang     += $datas[$i]->hilang     ;
        $total_lainout    += $datas[$i]->lainout    ;
        $total_rph_sel_so += $datas[$i]->rph_sel_so ;
        $total_intrst     += $datas[$i]->intrst     ;
        $total_adj        += $datas[$i]->adj        ;
        $total_koreksi    += $datas[$i]->koreksi    ;
        $total_akhir      += $datas[$i]->akhir      ;

                $tempdiv = $datas[$i]->lpp_kodedivisi;
                $tempdep = $datas[$i]->lpp_kodedepartemen;
            @endphp
            @if( isset($datas[$i+1]->lpp_kodedepartemen) && $tempdep != $datas[$i+1]->lpp_kodedepartemen || !(isset($datas[$i+1]->lpp_kodedepartemen)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DEPT</td>
                    <td class="left">{{ $datas[$i]->lpp_kodedepartemen }} - {{$datas[$i]->dep_namadepartement}}</td>
                    <td align="right">{{ number_format($st_dep_sawalrph  ,2)}} ( {{$st_dep_sawalqty}} )</td>
                    <td align="right">{{ number_format($st_dep_beli            ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_bonus          ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_trmcb          ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_retursales,2) }}</td>
                    <td align="right">{{ number_format($st_dep_repack        ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_lainin        ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_sales     ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_kirim     ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_prepack   ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_hilang    ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_lainout   ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_rph_sel_so,2) }}</td>
                    <td align="right">{{ number_format($st_dep_intrst    ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_adj       ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_koreksi   ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_akhir     ,2) }}</td>
                </tr>
                @php
                     $st_dep_sawalrph   = 0;
                     $st_dep_sawalqty   = 0;
                     $st_dep_beli       = 0;
                     $st_dep_bonus      = 0;
                     $st_dep_trmcb      = 0;
                     $st_dep_retursales = 0;
                     $st_dep_repack     = 0;
                     $st_dep_lainin     = 0;
                     $st_dep_sales      = 0;
                     $st_dep_kirim      = 0;
                     $st_dep_prepack    = 0;
                     $st_dep_hilang     = 0;
                     $st_dep_lainout    = 0;
                     $st_dep_rph_sel_so = 0;
                     $st_dep_intrst     = 0;
                     $st_dep_adj        = 0;
                     $st_dep_koreksi    = 0;
                     $st_dep_akhir      = 0;
                @endphp
            @endif
            @if((isset($datas[$i+1]->lpp_kodedivisi) && $tempdiv != $datas[$i+1]->lpp_kodedivisi) || !(isset($datas[$i+1]->lpp_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DIVISI</td>
                    <td class="left">{{ $datas[$i]->lpp_kodedivisi }} - {{ $datas[$i]->div_namadivisi }}</td>
                    <td align="right">{{ number_format($st_div_sawalrph  ,2)}} ( {{$st_div_sawalqty}} )</td>
                    <td align="right">{{ number_format($st_div_beli            ,2)}}</td>
                    <td align="right">{{ number_format($st_div_bonus          ,2)}}</td>
                    <td align="right">{{ number_format($st_div_trmcb          ,2)}}</td>
                    <td align="right">{{ number_format($st_div_retursales,2) }}</td>
                    <td align="right">{{ number_format($st_div_repack        ,2)}}</td>
                    <td align="right">{{ number_format($st_div_lainin        ,2)}}</td>
                    <td align="right">{{ number_format($st_div_sales     ,2) }}</td>
                    <td align="right">{{ number_format($st_div_kirim     ,2) }}</td>
                    <td align="right">{{ number_format($st_div_prepack   ,2) }}</td>
                    <td align="right">{{ number_format($st_div_hilang    ,2) }}</td>
                    <td align="right">{{ number_format($st_div_lainout   ,2) }}</td>
                    <td align="right">{{ number_format($st_div_rph_sel_so,2) }}</td>
                    <td align="right">{{ number_format($st_div_intrst    ,2) }}</td>
                    <td align="right">{{ number_format($st_div_adj       ,2) }}</td>
                    <td align="right">{{ number_format($st_div_koreksi   ,2) }}</td>
                    <td align="right">{{ number_format($st_div_akhir     ,2) }}</td>
                </tr>
                @php
                        $st_div_sawalrph   = 0;
                        $st_div_sawalqty   = 0;
                        $st_div_beli       = 0;
                        $st_div_bonus      = 0;
                        $st_div_trmcb      = 0;
                        $st_div_retursales = 0;
                        $st_div_repack     = 0;
                        $st_div_lainin     = 0;
                        $st_div_sales      = 0;
                        $st_div_kirim      = 0;
                        $st_div_prepack    = 0;
                        $st_div_hilang     = 0;
                        $st_div_lainout    = 0;
                        $st_div_rph_sel_so = 0;
                        $st_div_intrst     = 0;
                        $st_div_adj        = 0;
                        $st_div_koreksi    = 0;
                        $st_div_akhir      = 0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="1"><strong>TOTAL SELURUHNYA</strong></td>
            <td align="right">{{ number_format($total_sawalrph  ,2)}} ( {{$total_sawalqty}} )</td>
            <td align="right">{{ number_format($total_beli            ,2)}}</td>
            <td align="right">{{ number_format($total_bonus          ,2)}}</td>
            <td align="right">{{ number_format($total_trmcb          ,2)}}</td>
            <td align="right">{{ number_format($total_retursales,2) }}</td>
            <td align="right">{{ number_format($total_repack        ,2)}}</td>
            <td align="right">{{ number_format($total_lainin        ,2)}}</td>
            <td align="right">{{ number_format($total_sales     ,2) }}</td>
            <td align="right">{{ number_format($total_kirim     ,2) }}</td>
            <td align="right">{{ number_format($total_prepack   ,2) }}</td>
            <td align="right">{{ number_format($total_hilang    ,2) }}</td>
            <td align="right">{{ number_format($total_lainout   ,2) }}</td>
            <td align="right">{{ number_format($total_rph_sel_so,2) }}</td>
            <td align="right">{{ number_format($total_intrst    ,2) }}</td>
            <td align="right">{{ number_format($total_adj       ,2) }}</td>
            <td align="right">{{ number_format($total_koreksi   ,2) }}</td>
            <td align="right">{{ number_format($total_akhir     ,2) }}</td>
        </tr>
        <tr>
            <td class="left" colspan="4"><strong>Lain - Lain Out termasuk :</strong></td>
            <td class="left" colspan="4"><strong>Transfer In termasuk :</strong></td>
            <td class="left" colspan="4"><strong>Transfer Out termasuk :</strong></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>Nilai BA IDM (Acost) --></strong></td>
            <td class="left" colspan="2"><strong>{{$p_nilaiidmacost}}</strong></td>
            <td class="left" colspan="2"><strong>Nilai Penjualan HBV --> </strong></td>
            <td class="left" colspan="2"><strong>{{$p_nilaihbvtrfin}}</strong></td>
            <td class="left" colspan="2"><strong>Nilai Penjualan HBV --> </strong></td>
            <td class="left" colspan="2"><strong>{{$p_nilaihbvtrfout}}</strong></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>Nilai BA IDM (Price) --></strong></td>
            <td class="left" colspan="2"><strong>{{$p_nilaiidmprice}}</strong></td>
        </tr>
        <tr>
            <td class="left" colspan="4"><strong>Nilai SO termasuk : SONAS + SO IC</strong></td>
        </tr>
        </tfoot>
    </table>

    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>

</main>
</body>
</html>
