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
        <p>{{$perusahaan->prs_namaperusahaan}}</p>
        <p>{{$perusahaan->prs_namacabang}}</p>
        <p>{{$perusahaan->prs_namawilayah}}</p>
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
        $total_dpp     = 0;
        $total_3persen = 0;
        $total_ppn     = 0;
        $total_nilai   = 0;
    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th rowspan="2" align="left">No.</th>
            <th colspan="2" align="center">----NRB Proforma----</th>
            <th rowspan="2" align="center">TOKO IDM</th>
            <th colspan="2" align="center">----Dok Retur----</th>
            <th rowspan="2" align="center">DPP</th>
            <th rowspan="2" align="center">3%</th>
            <th rowspan="2" align="center">PPN</th>
            <th rowspan="2" align="center">Nilai</th>
        </tr>
        <tr style="text-align: center;">
            <th align="center">No.</th>
            <th align="center">Tgl</th>
            <th align="center">No.</th>
            <th align="center">Tgl</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($datas);$i++)
            <tr>
                <td align="left">{{ $datas[$i]->nomor }}</td>
                <td align="right">{{ $datas[$i]->bth_nonrb }}</td>
                <td align="right">{{ substr($datas[$i]->bth_tglnrb,0,10)  }}</td>
                <td align="right">{{ $datas[$i]->tko_kodeomi}}</td>
                <td align="right">{{ $datas[$i]->bth_nodoc    }}</td>
                <td align="right">{{ substr($datas[$i]->bth_tgldoc,0,10)   }}</td>
                <td align="right">{{ number_format($datas[$i]->dpp      ,2)   }}</td>
                <td align="right">{{ number_format($datas[$i]->tigapersen,2)  }}</td>
                <td align="right">{{ number_format($datas[$i]->btd_ppn  ,2)   }}</td>
                <td align="right">{{ number_format($datas[$i]->nilai    ,2)}}</td>
            </tr>
            @php
                $total_nilai      += $datas[$i]->nilai   ;
                $total_dpp        += $datas[$i]->dpp;
                $total_3persen    += $datas[$i]->tigapersen;
                $total_ppn        += $datas[$i]->btd_ppn;
                $total_nilai      += $datas[$i]->nilai;

                $tempnrb = $datas[$i]->bth_nonrb;
            @endphp


        @endfor
        </tbody>
        <tfoot style="border-top:solid 1px ">
        <tr>
            <td align="right" colspan="6"><strong>TOTAL NILAI BA</strong></td>
            <td align="right">{{ number_format($total_dpp    ,2) }}</td>
            <td align="right">{{ number_format($total_3persen,2) }}</td>
            <td align="right">{{ number_format($total_ppn    ,2) }}</td>
            <td align="right">{{ number_format($total_nilai  ,2) }}</td>
        </tr>
        </tfoot>
    </table>

    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>

</main>
</body>
</html>
