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

         $st_qty_soic    =0;
         $st_qty_so      =0;
         $st_qty_total   =0;
         $st_rph_soic    =0;
         $st_rph_so      =0;
         $st_rph_total   =0;
         $total_qty_soic =0;
         $total_qty_so   =0;
         $total_qty_total=0;
         $total_rph_soic =0;
         $total_rph_so   =0;
         $total_rph_total=0;
    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="3" style="text-align: center"></th>
            <th colspan="5" style="text-align: center">----ADJUSTMENT----</th>
        </tr>
        <tr style="text-align: center;">
            <th>No.</th>
            <th>PLU</th>
            <th>DESKRIPSI - KEMASAN</th>
            <th>TANGGAL</th>
            <th>NILAI SO IC</th>
            <th>TANGGAL</th>
            <th>NILAI SONAS</th>
            <th>NILAI TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($datas);$i++)
            @if($tempdep != $datas[$i]->prd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="17"><b>{{$datas[$i]->prd_kodedepartement}}
                            - {{$datas[$i]->dep_namadepartement}}</b></td>
                </tr>
                <tr>
                    <td class="left"><b>KATEGORI</b></td>
                    <td class="left" colspan="17"><b>{{$datas[$i]->prd_kodekategoribarang}} - {{$datas[$i]->kat_namakategori}}</b>
                    </td>
                </tr>
            @endif;
            <tr>
                <td align="left">{{ $i+1 }}</td>
                <td align="left">{{ $datas[$i]->rso_prdcd }}</td>
                <td align="left">{{ $datas[$i]->prd_deskripsipanjang}}</td>
                <td align="right">{{ $datas[$i]->tgl_soic}}</td>
                <td align="right">{{ number_format($datas[$i]->qty_soic      ,2)}}</td>
                <td align="right">{{ $datas[$i]->tgl_so     ,2}}</td>
                <td align="right">{{ number_format($datas[$i]->qty_so     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->qty_total     ,2)}}</td>
            </tr>
            <tr>
                <td align="left"></td>
                <td align="left"></td>
                <td align="left"></td>
                <td align="right">{{ number_format($datas[$i]->rph_soic      ,2)}}</td>
                <td align="left"></td>
                <td align="right">{{ number_format($datas[$i]->rph_so     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->rph_total     ,2)}}</td>
            </tr>
            @php
        $st_qty_soic    += $datas[$i]->qty_soic    ;
        $st_qty_so      += $datas[$i]->qty_so      ;
        $st_qty_total   += $datas[$i]->qty_total   ;

        $st_rph_soic    += $datas[$i]->rph_soic    ;
        $st_rph_so      += $datas[$i]->rph_so      ;
        $st_rph_total   += $datas[$i]->rph_total   ;

        $total_qty_soic    += $datas[$i]->qty_soic    ;
        $total_qty_so      += $datas[$i]->qty_so      ;
        $total_qty_total   += $datas[$i]->qty_total   ;

        $total_rph_soic    += $datas[$i]->rph_soic    ;
        $total_rph_so      += $datas[$i]->rph_so      ;
        $total_rph_total   += $datas[$i]->rph_total   ;

                $tempdep = $datas[$i]->prd_kodedepartement;
            @endphp
            @if( isset($datas[$i+1]->prd_kodedepartement) && $tempdep != $datas[$i+1]->prd_kodedepartement || !(isset($datas[$i+1]->prd_kodedepartement)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="right">SUB TOTAL</td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_qty_soic        ,2)}}</td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_qty_so         ,2)}}</td>
                    <td align="right">{{ number_format($st_qty_total      ,2)}}</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_rph_soic        ,2)}}</td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_rph_so         ,2)}}</td>
                    <td align="right">{{ number_format($st_rph_total      ,2)}}</td>
                </tr>
                @php
                   $st_qty_soic  =0;
                   $st_qty_so    =0;
                   $st_qty_total =0;
                   $st_rph_soic  =0;
                   $st_rph_so    =0;
                   $st_rph_total =0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot style="border: 1px solid black;">
        <tr>
            <td class="left"></td>
            <td class="left"></td>
            <td class="right">TOTAL</td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_qty_soic        ,2)}}</td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_qty_so         ,2)}}</td>
            <td align="right">{{ number_format($total_qty_total      ,2)}}</td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="left"></td>
            <td class="left"></td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_rph_soic        ,2)}}</td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_rph_so         ,2)}}</td>
            <td align="right">{{ number_format($total_rph_total      ,2)}}</td>
        </tr>
        </tfoot>
    </table>

    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>

</main>
</body>
</html>
