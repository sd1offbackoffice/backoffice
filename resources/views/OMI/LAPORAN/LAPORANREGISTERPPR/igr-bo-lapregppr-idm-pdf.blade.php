<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN REGISTER PPR IDM</title>

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
            {{ $perusahaan->prs_namacabang }}<br><br>
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>
            TANGGAL : {{ substr(\Carbon\Carbon::now(),0,10) }}<br><br>
        </p>
    </div>
    <h2 style="text-align: center">** LAPORAN REGISTER PPR IDM ** </h2>
    <h4 style="text-align: center">
        {{ 'Tgl : '. substr($tgl1,0,10) .' - '. substr($tgl2,0,10) }}<br>
        {{ 'No. Dokumen : '. $nodoc1 .' - '. $nodoc2 }}<br>
    </h4>
</header>

<main style="margin-top: 50px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>TGL</th>
            <th>NO. NRB</th>
            <th>NO. DOK</th>
            <th>NO. NOTA RETUR</th>
            <th>ITEM</th>
            <th>MEMBER</th>
            <th>NILAI</th>
            <th>PPN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_nilai = 0;
            $total_ppn = 0;
            $tgl_temp = '';
        @endphp
        @if(sizeof($data)!=0)
            @foreach($data as $d)
                @if($tgl_temp != $d->trpt_salesinvoicedate)
                    <tr>
                        <td>{{ substr($d->trpt_salesinvoicedate,0,10) }}</td>
                        <td>{{ $d->trpt_invoicetaxno }}</td>
                        <td>{{ $d->trpt_salesinvoiceno}}</td>
                        <td>{{ $d->cf_item }}</td>
                        <td>{{ $d->tko_kodeomi }}</td>
                        <td>{{ $d->member }}</td>
                        <td>{{ number_format($d->trpt_netsales,2) }}</td>
                        <td>{{ number_format($d->trpt_ppntaxvalue,2) }}</td>
                    </tr>
                @else
                    <tr>
                        <td></td>
                        <td>{{ $d->trpt_invoicetaxno }}</td>
                        <td>{{ $d->trpt_salesinvoiceno}}</td>
                        <td>{{ $d->cf_item }}</td>
                        <td>{{ $d->tko_kodeomi }}</td>
                        <td>{{ $d->member }}</td>
                        <td>{{ number_format($d->trpt_netsales,2) }}</td>
                        <td>{{ number_format($d->trpt_ppntaxvalue,2) }}</td>
                    </tr>
                @endif
                @php
                    $tgl_temp = $d->trpt_salesinvoicedate;
                    $total_nilai += $d->trpt_netsales;
                    $total_ppn += $d->trpt_ppntaxvalue;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="12">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6" align="right">TOTAL</td>
            <td align="center">{{ $total_nilai }}</td>
            <td align="center">{{ $total_ppn }}</td>
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
