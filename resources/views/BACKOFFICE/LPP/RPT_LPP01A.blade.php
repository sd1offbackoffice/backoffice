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

        $st_div_qty_soic  = 0;
        $st_div_qty_so    = 0;
        $st_div_qty_total = 0;
        $st_dep_qty_soic  = 0;
        $st_dep_qty_so    = 0;
        $st_dep_qty_total = 0;
        $total_qty_soic   = 0;
        $total_qty_so     = 0;
        $total_qty_total  = 0;
        $st_div_rph_soic  = 0;
        $st_div_rph_so    = 0;
        $st_div_rph_total = 0;
        $st_dep_rph_soic  = 0;
        $st_dep_rph_so    = 0;
        $st_dep_rph_total = 0;
        $total_rph_soic   = 0;
        $total_rph_so     = 0;
        $total_rph_total = 0;
    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th style="text-align: center"></th>
            <th colspan="2" style="text-align: center">----KATEGORI----</th>
            <th colspan="3" style="text-align: center">----ADJUSTMENT----</th>
        </tr>
        <tr style="text-align: center;">
            <th>No.</th>
            <th>KODE - NAMA</th>
            <th>SO IC</th>
            <th>SONAS</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($datas);$i++)
            @if($tempdiv != $datas[$i]->prd_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="17"><b>{{$datas[$i]->prd_kodedivisi}} - {{$datas[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif;
            @if($tempdep != $datas[$i]->prd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="17"><b>{{$datas[$i]->prd_kodedepartement}}
                            - {{$datas[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif;
            <tr>
                <td align="left">{{ $i+1 }}</td>
                <td align="left">{{ $datas[$i]->prd_kodekategoribarang }}-{{ $datas[$i]->kat_namakategori}}</td>
                <td align="right">{{ number_format($datas[$i]->qty_soic      ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->qty_so     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->qty_total     ,2)}}</td>
            </tr>
            <tr>
                <td align="left"></td>
                <td align="left"></td>
                <td align="right">{{ number_format($datas[$i]->rph_soic      ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->rph_so     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->rph_total     ,2)}}</td>
            </tr>
            @php
        $st_div_qty_soic    += $datas[$i]->qty_soic    ;
        $st_div_qty_so      += $datas[$i]->qty_so      ;
        $st_div_qty_total   += $datas[$i]->qty_total   ;

        $st_dep_qty_soic    += $datas[$i]->qty_soic    ;
        $st_dep_qty_so      += $datas[$i]->qty_so      ;
        $st_dep_qty_total   += $datas[$i]->qty_total   ;

        $total_qty_soic    += $datas[$i]->qty_soic    ;
        $total_qty_so      += $datas[$i]->qty_so      ;
        $total_qty_total   += $datas[$i]->qty_total   ;

        $st_div_rph_soic    += $datas[$i]->rph_soic    ;
        $st_div_rph_so      += $datas[$i]->rph_so      ;
        $st_div_rph_total   += $datas[$i]->rph_total   ;

        $st_dep_rph_soic    += $datas[$i]->rph_soic    ;
        $st_dep_rph_so      += $datas[$i]->rph_so      ;
        $st_dep_rph_total   += $datas[$i]->rph_total   ;

        $total_rph_soic    += $datas[$i]->rph_soic    ;
        $total_rph_so      += $datas[$i]->rph_so      ;
        $total_rph_total   += $datas[$i]->rph_total   ;

                $tempdiv = $datas[$i]->prd_kodedivisi;
                $tempdep = $datas[$i]->prd_kodedepartement;
            @endphp
            @if( isset($datas[$i+1]->prd_kodedepartement) && $tempdep != $datas[$i+1]->prd_kodedepartement || !(isset($datas[$i+1]->prd_kodedepartement)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DEPARTEMEN</td>
                    <td align="right">{{ number_format($st_dep_qty_soic        ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_qty_so         ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_qty_total      ,2)}}</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td class="left"></td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_dep_rph_soic        ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_rph_so         ,2)}}</td>
                    <td align="right">{{ number_format($st_dep_rph_total      ,2)}}</td>
                </tr>
                @php
                    $st_dep_qty_soic  =0;
                   $st_dep_qty_so    =0;
                   $st_dep_qty_total =0;
                @endphp
            @endif
            @if((isset($datas[$i+1]->prd_kodedivisi) && $tempdiv != $datas[$i+1]->prd_kodedivisi) || !(isset($datas[$i+1]->prd_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DIVISI</td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_div_qty_soic            ,2)}}</td>
                    <td align="right">{{ number_format($st_div_qty_so             ,2)}}</td>
                    <td align="right">{{ number_format($st_div_qty_total          ,2)}}</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td class="left"></td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_div_rph_soic            ,2)}}</td>
                    <td align="right">{{ number_format($st_div_rph_so             ,2)}}</td>
                    <td align="right">{{ number_format($st_div_rph_total          ,2)}}</td>
                </tr>
                @php
                        $st_div_qty_soic = 0;
                        $st_div_qty_so   = 0;
                        $st_div_qty_total= 0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot style="border: 1px solid black;">
        <tr>
            <td class="left" colspan="1"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_qty_soic  ,2)}}</td>
            <td align="right">{{ number_format($total_qty_so   ,2)}}</td>
            <td align="right">{{ number_format($total_qty_total,2)}}</td>
        </tr>
        <tr>
            <td class="left" colspan="1"></td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_rph_soic  ,2)}}</td>
            <td align="right">{{ number_format($total_rph_so   ,2)}}</td>
            <td align="right">{{ number_format($total_rph_total,2)}}</td>
        </tr>
        </tfoot>
    </table>

    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>

</main>
</body>
</html>
