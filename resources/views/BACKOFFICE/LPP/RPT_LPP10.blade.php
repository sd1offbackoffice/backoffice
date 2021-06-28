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

        $st_div_sawalrph    =0;
        $st_div_baikrph     =0;
        $st_div_returrph    =0;
        $st_div_musnahrph =0;
        $st_div_hilangrph   =0;
        $st_div_lbaikrph    =0;
        $st_div_lreturrph   =0;
        $st_div_rph_sel_so  =0;
        $st_div_adjrph      =0;
        $st_div_koreksi     =0;
        $st_div_akhirrph    =0;

        $st_dep_sawalrph    =0;
        $st_dep_baikrph     =0;
        $st_dep_retrurph    =0;
        $st_dep_musnahrph =0;
        $st_dep_hilangrph   =0;
        $st_dep_lbaikrph    =0;
        $st_dep_lreturrph   =0;
        $st_dep_rph_sel_so  =0;
        $st_dep_adjrph      =0;
        $st_dep_koreksi     =0;
        $st_dep_akhirrph    =0;

        $total_sawalrph    =0;
        $total_baikrph     =0;
        $total_retrurrph    =0;
        $total_musnahrph =0;
        $total_hilangrph   =0;
        $total_lbaikrph    =0;
        $total_lreturrph   =0;
        $total_rph_sel_so  =0;
        $total_adjrph      =0;
        $total_koreksi     =0;
        $total_akhirrph    =0;
    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="3" style="text-align: center"></th>
            <th colspan="2" style="text-align: center">----PENERIMAAN----</th>
            <th colspan="4" style="text-align: center">----PENGELUARAN----</th>
        </tr>
        <tr style="text-align: center;">
            <th>KODE</th>
            <th>NAMA KATEGORI</th>
            <th width="10%">SALDO AWAL</th>
            <th>BAIK</th>
            <th>RETUR</th>
            <th>PEMUSNAHAN</th>
            <th>HILANG</th>
            <th>LAIN BAIK</th>
            <th>LAIN RETUR</th>
            <th>SO</th>
            <th>PENYESUAIAN</th>
            <th>KOREKSI</th>
            <th>SALDOAKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($datas);$i++)
            @if($tempdiv != $datas[$i]->lrs_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="17"><b>{{$datas[$i]->lrs_kodedivisi}} - {{$datas[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif;
            @if($tempdep != $datas[$i]->lrs_kodedepartemen)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="17"><b>{{$datas[$i]->lrs_kodedepartemen}}
                            - {{$datas[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif;
            <tr>
                <td align="left">{{ $datas[$i]->lrs_kategoribrg }}</td>
                <td align="left">{{ $datas[$i]->kat_namakategori }}</td>
                <td align="right">{{ number_format($datas[$i]->sawalrph    ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->baikrph      ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->returrph     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->musnahrph     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->hilangrph   ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lbaikrph    ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lreturrph    ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->rph_sel_so  ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->adjrph      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->koreksi     ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->akhirrph    ,2) }}</td>
            </tr>
            @php
        $st_div_sawalrph   += $datas[$i]->sawalrph  ;
        $st_div_baikrph    += $datas[$i]->baikrph   ;
        $st_div_returrph   += $datas[$i]->returrph  ;
        $st_div_musnahrph  += $datas[$i]->musnahrph ;
        $st_div_hilangrph  += $datas[$i]->hilangrph ;
        $st_div_lbaikrph   += $datas[$i]->lbaikrph  ;
        $st_div_lreturrph  += $datas[$i]->lreturrph ;
        $st_div_rph_sel_so += $datas[$i]->rph_sel_so;
        $st_div_adjrph     += $datas[$i]->adjrph    ;
        $st_div_koreksi    += $datas[$i]->koreksi   ;
        $st_div_akhirrph   += $datas[$i]->akhirrph  ;

        $st_dep_sawalrph   += $datas[$i]->sawalrph  ;
        $st_dep_baikrph    += $datas[$i]->baikrph   ;
        $st_dep_retrurph   += $datas[$i]->returrph  ;
        $st_dep_musnahrph  += $datas[$i]->musnahrph ;
        $st_dep_hilangrph  += $datas[$i]->hilangrph ;
        $st_dep_lbaikrph   += $datas[$i]->lbaikrph  ;
        $st_dep_lreturrph  += $datas[$i]->lreturrph ;
        $st_dep_rph_sel_so += $datas[$i]->rph_sel_so;
        $st_dep_adjrph     += $datas[$i]->adjrph    ;
        $st_dep_koreksi    += $datas[$i]->koreksi   ;
        $st_dep_akhirrph   += $datas[$i]->akhirrph  ;

        $total_sawalrph   += $datas[$i]->sawalrph  ;
        $total_baikrph    += $datas[$i]->baikrph   ;
        $total_retrurrph   += $datas[$i]->returrph  ;
        $total_musnahrph+= $datas[$i]->musnahrph ;
        $total_hilangrph  += $datas[$i]->hilangrph ;
        $total_lbaikrph   += $datas[$i]->lbaikrph  ;
        $total_lreturrph  += $datas[$i]->lreturrph ;
        $total_rph_sel_so += $datas[$i]->rph_sel_so;
        $total_adjrph     += $datas[$i]->adjrph    ;
        $total_koreksi    += $datas[$i]->koreksi   ;
        $total_akhirrph   += $datas[$i]->akhirrph  ;

                $tempdiv = $datas[$i]->lrs_kodedivisi;
                $tempdep = $datas[$i]->lrs_kodedepartemen;
            @endphp
            @if( isset($datas[$i+1]->lrs_kodedepartemen) && $tempdep != $datas[$i+1]->lrs_kodedepartemen || !(isset($datas[$i+1]->lrs_kodedepartemen)) )
                <tr style="border-bottom: 1px solid black;">
                    <td align="left" colspan="2">SUB TOTAL DEPT</td>
                    <td align="right">{{ number_format($st_div_sawalrph   ,2)}}</td>
                    <td align="right">{{ number_format($st_div_baikrph          ,2)}}</td>
                    <td align="right">{{ number_format($st_div_returrph        ,2)}}</td>
                    <td align="right">{{ number_format($st_div_musnahrph     ,2)}}</td>
                    <td align="right">{{ number_format($st_div_hilangrph  ,2) }}</td>
                    <td align="right">{{ number_format($st_div_lbaikrph       ,2)}}</td>
                    <td align="right">{{ number_format($st_div_lreturrph      ,2)}}</td>
                    <td align="right">{{ number_format($st_div_rph_sel_so ,2) }}</td>
                    <td align="right">{{ number_format($st_div_adjrph     ,2) }}</td>
                    <td align="right">{{ number_format($st_div_koreksi    ,2) }}</td>
                    <td align="right">{{ number_format($st_div_akhirrph   ,2) }}</td>
                </tr>
                @php
                    $st_div_sawalrph    =0;
                    $st_div_baikrph     =0;
                    $st_div_returrph    =0;
                    $st_div_musnahrph =0;
                    $st_div_hilangrph   =0;
                    $st_div_lbaikrph    =0;
                    $st_div_lreturrph   =0;
                    $st_div_rph_sel_so  =0;
                    $st_div_adjrph      =0;
                    $st_div_koreksi     =0;
                    $st_div_akhirrph =0;
                @endphp
            @endif
            @if((isset($datas[$i+1]->lrs_kodedivisi) && $tempdiv != $datas[$i+1]->lrs_kodedivisi) || !(isset($datas[$i+1]->lrs_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left" colspan="2">SUB TOTAL DIVISI</td>
                    <td align="right">{{ number_format($st_dep_sawalrph   ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_baikrph          ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_retrurph        ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_musnahrph     ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_hilangrph  ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_lbaikrph       ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_lreturrph      ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_rph_sel_so ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_adjrph     ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_koreksi    ,2) }}</td>
                    <td align="right">{{ number_format($st_dep_akhirrph   ,2) }}</td>
                </tr>
                @php
                 $st_dep_sawalrph    =0;
                 $st_dep_baikrph     =0;
                 $st_dep_retrurph    =0;
                 $st_dep_musnahrph =0;
                 $st_dep_hilangrph   =0;
                 $st_dep_lbaikrph    =0;
                 $st_dep_lreturrph   =0;
                 $st_dep_rph_sel_so  =0;
                 $st_dep_adjrph      =0;
                 $st_dep_koreksi     =0;
                 $st_dep_akhirrph =0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td align="right">{{ number_format($total_sawalrph   ,2)}}</td>
            <td align="right">{{ number_format($total_baikrph          ,2)}}</td>
            <td align="right">{{ number_format($total_retrurrph        ,2)}}</td>
            <td align="right">{{ number_format($total_musnahrph     ,2)}}</td>
            <td align="right">{{ number_format($total_hilangrph  ,2) }}</td>
            <td align="right">{{ number_format($total_lbaikrph       ,2)}}</td>
            <td align="right">{{ number_format($total_lreturrph      ,2)}}</td>
            <td align="right">{{ number_format($total_rph_sel_so ,2) }}</td>
            <td align="right">{{ number_format($total_adjrph     ,2) }}</td>
            <td align="right">{{ number_format($total_koreksi    ,2) }}</td>
            <td align="right">{{ number_format($total_akhirrph   ,2) }}</td>
        </tr>
        </tfoot>
    </table>

    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>

</main>
</body>
</html>
