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
        $tempdiv = '';
        $tempdep = '';

        $count_prdcd = 0;
        $total_prdcd = 0;

        $st_sawalrph   =0;
        $st_baikrph    =0;
        $st_rusakrph   =0;
        $st_supplierrph=0;
        $st_hilangrph  =0;
        $st_lbaikrph   =0;
        $st_lrusakrph  =0;
        $st_selso_rph  =0;
        $st_adjrph     =0;
        $st_koreksi    =0;
        $st_akhirrph   =0;


        $total_sawalrph   =0;
        $total_baikrph    =0;
        $total_rusakrph   =0;
        $total_supplierrph=0;
        $total_hilangrph  =0;
        $total_lbaikrph   =0;
        $total_lrusakrph  =0;
        $total_selso_rph  =0;
        $total_adjrph     =0;
        $total_koreksi    =0;
        $total_akhirrph   =0;

    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="2" style="text-align: right"></th>
            <th colspan="2" style="text-align: center">----PENERIMAAN----</th>
            <th colspan="5" style="text-align: center">----PENGELUARAN----</th>
        </tr>
        <tr style="text-align: center;">
            <th></th>
            <th width="10%">SALDO AWAL</th>
            <th>BAIK</th>
            <th>RUSAK</th>
            <th>KE SUPPLIER</th>
            <th>HILANG</th>
            <th>LAIN BAIK</th>
            <th>LAIN RUSAK</th>
            <th>PENYESUAIAN</th>
            <th>SALDO AKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($datas);$i++)
            @if($tempdep != $datas[$i]->lrt_kodedepartemen)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left"><b>{{$datas[$i]->lrt_kodedepartemen}}
                            - {{$datas[$i]->dep_namadepartement}}</b></td>
                </tr>
                <tr>
                    <td class="left"><b>KATEGORI :</b></td>
                    <td class="left"><b>{{$datas[$i]->lrt_kategoribrg}} - {{$datas[$i]->kat_namakategori}}</b>
                    </td>
                </tr>
            @endif;
            <tr>
                <td align="left">{{ $datas[$i]->lrt_prdcd }}</td>
                <td colspan="3" align="left">{{ $datas[$i]->prd_deskripsipanjang }}</td>
                <td align="left">{{ $datas[$i]->kemasan }}</td>
            </tr>
            <tr>
                <td align="left">UNIT :</td>
                <td align="right">{{ number_format($datas[$i]->sawalqty  ,2)}} </td>
                <td align="right">{{ number_format($datas[$i]->baikqty      ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->rusakqty     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->supplierqty     ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->hilangqty   ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lbaikqty    ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lrusakqty    ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->adjqty      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->akhirqty    ,2) }}</td>
            </tr>
            <tr>
                <td align="left">Rp :</td>
                <td align="right">{{ number_format($datas[$i]->sawalrph   ,2)}} </td>
                <td align="right">{{ number_format($datas[$i]->baikrph    ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->rusakrph   ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->supplierrph,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->hilangrph  ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->lbaikrph   ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->lrusakrph  ,2)}}</td>
                <td align="right">{{ number_format($datas[$i]->adjrph      ,2) }}</td>
                <td align="right">{{ number_format($datas[$i]->akhirrph    ,2) }}</td>
            </tr>
            @php
                $count_prdcd++;
                    $total_prdcd++;

                $st_sawalrph    += $datas[$i]->sawalrph;
                $st_baikrph     += $datas[$i]->baikrph;
                $st_rusakrph    += $datas[$i]->rusakrph;
                $st_supplierrph += $datas[$i]->supplierrph;
                $st_hilangrph   += $datas[$i]->hilangrph;
                $st_lbaikrph    += $datas[$i]->lbaikrph;
                $st_lrusakrph   += $datas[$i]->lrusakrph;
                $st_adjrph      += $datas[$i]->adjrph;
                $st_akhirrph    += $datas[$i]->akhirrph;

                $total_sawalrph    += $datas[$i]->sawalrph;
                $total_baikrph     += $datas[$i]->baikrph;
                $total_rusakrph    += $datas[$i]->rusakrph;
                $total_supplierrph += $datas[$i]->supplierrph;
                $total_hilangrph   += $datas[$i]->hilangrph;
                $total_lbaikrph    += $datas[$i]->lbaikrph;
                $total_lrusakrph   += $datas[$i]->lrusakrph;
                $total_adjrph      += $datas[$i]->adjrph;
                $total_akhirrph    += $datas[$i]->akhirrph;

                $tempdep = $datas[$i]->lrt_kodedepartemen;
            @endphp
            @if( isset($datas[$i+1]->lrt_kodedepartemen) && $tempdep != $datas[$i+1]->lrt_kodedepartemen || !(isset($datas[$i+1]->lrt_kodedepartemen)) )
                <tr>
                    <td class="right">SUBTOTAL</td>
                    <td class="right">{{ $count_prdcd }}</td>
                    <td class="left">ITEM</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td align="left">Rp :</td>
                    <td align="right">{{ number_format($st_sawalrph   ,2)}} </td>
                    <td align="right">{{ number_format($st_baikrph    ,2)}}</td>
                    <td align="right">{{ number_format($st_rusakrph   ,2)}}</td>
                    <td align="right">{{ number_format($st_supplierrph,2)}}</td>
                    <td align="right">{{ number_format($st_hilangrph  ,2) }}</td>
                    <td align="right">{{ number_format($st_lbaikrph   ,2)}}</td>
                    <td align="right">{{ number_format($st_lrusakrph  ,2)}}</td>
                    <td align="right">{{ number_format($st_adjrph      ,2) }}</td>
                    <td align="right">{{ number_format($st_akhirrph    ,2) }}</td>
                </tr>
                @php
                    $st_sawalqty =0;
                    $st_sawalrph   =0;
                    $st_baikrph     =0;
                    $st_rusakrph    =0;
                    $st_supplierrph =0;
                    $st_hilangrph   =0;
                    $st_lbaikrph    =0;
                    $st_lrusakrph   =0;
                    $st_adjrph      =0;
                    $st_akhirrph   =0;
                @endphp
            @endif
        @endfor
        </tbody>
        <tfoot style="border-bottom: 1px solid black;border-top: 1px solid black;">
        <tr>
            <td class="right">TOTAL</td>
            <td class="right">{{ $total_prdcd }}</td>
            <td class="left"><strong>ITEM</strong></td>
        </tr>
        <tr>
            <td class="left" colspan="1"><strong>Rp :</strong></td>
            <td align="right">{{ number_format($total_sawalrph         ,2)}}</td>
            <td align="right">{{ number_format($total_baikrph         ,2)}}</td>
            <td align="right">{{ number_format($total_rusakrph        ,2)}}</td>
            <td align="right">{{ number_format($total_supplierrph,2) }}</td>
            <td align="right">{{ number_format($total_hilangrph      ,2)}}</td>
            <td align="right">{{ number_format($total_lbaikrph       ,2)}}</td>
            <td align="right">{{ number_format($total_lrusakrph  ,2) }}</td>
            <td align="right">{{ number_format($total_adjrph     ,2) }}</td>
            <td align="right">{{ number_format($total_akhirrph   ,2) }}</td>
        </tr>
        </tfoot>
    </table>

    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>

</main>
</body>
</html>
