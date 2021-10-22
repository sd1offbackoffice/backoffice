<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN PENCETAKAN FAKTUR PAJAK STANDAR OMI NON PKP</title>

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
            {{ $perusahaan->prs_namaperusahaan }}
        </p>
        <p>
            {{ $perusahaan->prs_namacabang }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px;">
        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>
        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>
        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>
    </div>
    <div style="float:center;">
        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">LAPORAN PENCETAKAN</p>
        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">FAKTUR PAJAK STANDAR OMI NON PKP</p>
        <p style="text-align: center;margin: 0;padding: 0">Tgl : {{ substr($tgl1,0,10) .' - '. substr($tgl2,0,10) }} </p>
    </div>
</header>

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th align="left">TGL STR</th>
            <th align="left">CUSTOMER</th>
            <th align="left">STT</th>
            <th align="left">KASIR</th>
            <th align="left">STR. NO</th>
            <th align="left">NO SERI FP</th>
            <th align="left">TGL FP</th>
            <th align="right">DPP</th>
            <th align="right">PPN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_dpp = 0;
            $total_ppn = 0;
        @endphp

        @if(sizeof($data)!=0)
            @foreach($data as $d)
                <tr>
                    <td align="left">{{ date('d/m/Y',strtotime(substr($d->tgl_struk,0,10))) }}</td>
                    <td align="left">{{ $d->customer }}</td>
                    <td align="left">{{ $d->station}}</td>
                    <td align="left">{{ $d->kasir }}</td>
                    <td align="left">{{ $d->struk_no }}</td>
                    <td align="left">{{ $d->no_seri_fp }}</td>
                    <td align="left">{{ date('d/m/Y',strtotime(substr($d->tgl_fp,0,10))) }}</td>
                    <td align="right">{{ number_format($d->dpp, 0,".",",") }}</td>
                    <td align="right">{{ number_format($d->ppn, 0,".",",") }}</td>
                </tr>
                @php
                    $total_dpp += $d->dpp;
                    $total_ppn += $d->ppn;
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
            <th colspan="7" align="right">TOTAL</th>
            <th align="right">{{ number_format($total_dpp, 0,".",",") }}</th>
            <th align="right">{{ number_format($total_ppn, 0,".",",") }}</th>
        </tr>
        <tr>
            <th style="border-top: 1px solid black;" colspan="9" class="right">** Akhir dari laporan **</th>
        </tr>
        </tfoot>
    </table>

<br>
</body>


<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        /*size: 600pt 500pt;*/
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
