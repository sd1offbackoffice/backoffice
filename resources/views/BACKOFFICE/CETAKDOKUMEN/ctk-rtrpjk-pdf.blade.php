<!DOCTYPE html>
<html>

<head>
    <title>{{ strtoupper($data1[0]->judul) }}</title>

</head>
<body>

<?php
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);

$bulan = '';
if (substr($data1[0]->mstd_date2, 4, 2) == '01') {
    $bulan = 'JANUARI';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '02') {
    $bulan = 'FEBRUARI';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '03') {
    $bulan = 'MARET';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '04') {
    $bulan = 'APRIL';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '05') {
    $bulan = 'MEI';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '06') {
    $bulan = 'JUNI';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '07') {
    $bulan = 'JULI';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '08') {
    $bulan = 'AGUSTUS';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '09') {
    $bulan = 'SEPTEMBER';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '10') {
    $bulan = 'OKTOBER';
} else if (substr($data1[0]->mstd_date2, 4, 2) == '11') {
    $bulan = 'NOVEMBER';
else {
        $bulan = 'DESEMBER';
    }

    $cf_fakturpjk = $data1[0]->mstd_istype . '.' . $data1[0]->mstd_invno;
    $cf_harga = floor($data1[0]->cs_harga * 0.1);
    $cf_nofak = $data1[0]->prs_kodemto . '.' . substr($data1[0]->msth_tgldoc, 8, 2) . '.0' . $data1[0]->mstd_docno2 . $data1[0]->msth_flagdoc == 'T' ? '*' : '';
    $cf_skp_sup = '';
    if ($data1[0]->sup_tglsk) {
        $cf_skp_sup = $data1[0]->sup_nosk . '         Tanggal PKP : ' . $data1[0]->sup_tglSk;
    } else {
        $cf_skp_sup = $data1[0]->sup_nosk;
    }
    $f_1 = $data1[0]->sup_namanpwp ? $data1[0]->sup_namanpwp : $data1[0]->sup_namasupplier ." ". $data1[0]->sup_singkatansupplier;
    ?>
<header>
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>
            {{$cf_fakturpjk}} {{$f_1}}<br>
            {{ $perusahaan->prs_namaperusahaan }}<br>
            {{ $data1[0]->const_addr }}<br><br>
            {{ $data1[0]->prs_npwp }}<br><br><br>
            {{ $data1[0]->sup_namasupplier }}<br><br>
            {{ $data1[0]->addr_sup }}<br><br>
            {{ $data1[0]->sup_npwp }}<br><br>
            {{ $cf_skp_sup }}<br><br>
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>
            PRG : IGR BO LIST<br>
        </p><br><br>
        <p>
            {{ $data1[0]->status }}
        </p>
    </div>
    <h2 style="text-align: center">  {{ $data1[0]->judul }} </h2>
</header>

<main style="margin-top: 50px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>NO</th>
            <th>NAMA BARANG</th>
            <th>QTY</th>
            <th>HARGA</th>
            <th>TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $i=1;
        @endphp

        @if(sizeof($data1)!=0)
            @foreach($data1 as $d)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $d->prd_deskripsipanjang}}</td>
                    <td class="right">{{ $d->nqty }}</td>
                    <td class="right">{{ number_format(round($d->nprice), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($d->ngross), 0, '.', ',') }}</td>
                </tr>
                @php
                    $i++;
                    $total += $d->total;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif


        </tbody>
        <tfoot>
        <tr>
            <td colspan="7"></td>
            <td style="font-weight: bold">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format(round($total), 0, '.', ',') }}</td>
        </tr>
        </tfoot>
    </table>
</main>

<br>
</body>


<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: 750pt 500pt;
    }

    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
    }

    body {
        margin-top: 80px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
    }

    table {
        border-collapse: collapse;
    }

    tbody {
        display: table-row-group;
        vertical-align: middle;
        border-color: inherit;
    }

    tr {
        display: table-row;
        vertical-align: inherit;
        border-color: inherit;
    }

    td {
        display: table-cell;
    }

    thead {
        text-align: center;
    }

    tbody {
        text-align: center;
    }

    tfoot {
        border-top: 1px solid black;
    }

    .keterangan {
        text-align: left;
    }

    .table {
        width: 100%;
        font-size: 7px;
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }

    .table-ttd {
        width: 100%;
        font-size: 9px;
        /*white-space: nowrap;*/
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }

    .table tbody td {
        /*font-size: 6px;*/
        vertical-align: top;
        /*border-top: 1px solid #dee2e6;*/
        padding: 0.20rem 0;
        width: auto;
    }

    .table th {
        vertical-align: top;
        padding: 0.20rem 0;
    }

    .judul, .table-borderless {
        text-align: center;
    }

    .table-borderless th, .table-borderless td {
        border: 0;
        padding: 0.50rem;
    }

    .center {
        text-align: center;
    }

    .left {
        text-align: left;
    }

    .right {
        text-align: right;
    }

    .page-break {
        page-break-before: always;
    }

    .page-break-avoid {
        page-break-inside: avoid;
    }

    .table-header td {
        white-space: nowrap;
    }

    .tengah {
        vertical-align: middle !important;
    }

    .blank-row {
        line-height: 70px !important;
        color: white;
    }

    .border-top {
        border-bottom: 1px solid black;
    }

</style>
</html>
