<!DOCTYPE html>
<html>

<head>
        <title>Laporan SPB Manual</title>
    </head>
    <body>

    <?php
    $datetime = new DateTime();
    $timezone = new DateTimeZone('Asia/Jakarta');
    $datetime->setTimezone($timezone);
    ?>
    <header>
        <div style="float:left; margin-top: 0px; line-height: 8px !important;">
            <p>
                <b>{{ $perusahaan->prs_namaperusahaan }}</b><br>
                {{ $perusahaan->prs_namacabang }}<br><br><br>
                {{ $p_order }}
            </p>
        </div>
        <div style="float:right; margin-top: 0px; line-height: 8px !important;">
            <p>
                TGL : {{ e(date("d-m-Y")) }}<br>
                JAM : {{ $datetime->format('H:i:s') }}
            </p>
        </div>
        <h2 style="text-align: center">  Laporan SPB Manual </h2>
    </header>

    <main style="margin-top: 50px;">
        <table class="table">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">PLU</th>
                <th rowspan="2">DESKRIPSI</th>
                <th colspan="2">---PERMINTAAN---</th>
                <th rowspan="2">QTY<br>(CTN)</th>
                <th colspan="2">----LOKASI----</th>
                <th rowspan="2">REALISASI</th>
            </tr>
            <tr>
                <th>TGL</th>
                <th>OLEH</th>
                <th>ASAL</th>
                <th>TUJUAN</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total = 0;
                $i=1;
        @endphp

        @if(sizeof($data)!=0)
            @foreach($data as $d)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $d->spb_prdcd }}</td>
                    <td>{{ $d->prd_deskripsipanjang}}</td>
                    <td>{{ $d->satuan }}</td>
                    <td class="right">{{ $d->spb_create_dt }}</td>
                    <td class="right">{{ $d->spb_create_by }}</td>
                    <td class="right">{{ $d->spb_minus }}</td>
                    <td class="right">{{ $d->spb_lokasiasal }}</td>
                    <td class="right">{{ $d->spb_lokasitujuan }}</td>
                    <td class="right">{{ number_format(round($d->realisasi), 0, '.', ',') }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif


        </tbody>
        <tfoot>
        </tfoot>
    </table>
</main>

<br>
</body>


<style>
    @page {
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
