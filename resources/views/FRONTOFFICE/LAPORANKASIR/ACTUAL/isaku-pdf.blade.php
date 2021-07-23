<!DOCTYPE html>
<html>
<head>
    <title>Transaksi i-Saku - {{ $tanggal }}</title>
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
            {{ $perusahaan->prs_namaperusahaan }}<br><br>
            {{ $perusahaan->prs_namacabang }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ $_SESSION['usid'] }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">
        TRANSAKSI PENERIMAAN dan PENGELUARAN I.SAKU<br>
        PENJUALAN dengan I.SAKU<br>
        Tanggal : {{ $tanggal }}
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah left">Kassa</th>
            <th colspan="2" class="tengah right">Penerimaan</th>
            <th colspan="2" class="tengah right">Pengeluaran</th>
            <th rowspan="2" class="tengah right">Penjualan</th>
        </tr>
        <tr>
            <th class="right">Nilai</th>
            <th class="right">Fee</th>
            <th class="right">Nilai</th>
            <th class="right">Fee</th>
        </tr>
        </thead>
        <tbody>
        @php
            $nilaiIn = 0;
            $feeIn = 0;
            $nilaiOut = 0;
            $feeOut = 0;
            $buy = 0;
        @endphp
        @foreach($data as $d)
            @php
                $nilaiIn += $d->nilai_in;
                $feeIn += $d->fee_in;
                $nilaiOut += $d->nilai_out;
                $feeOut += $d->fee_out;
                $buy += $d->nilai_buy;
            @endphp
            <tr>
                <td class="left">{{ $d->kassa }}</td>
                <td class="right">{{ number_format($d->nilai_in, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->fee_in, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->nilai_out, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->fee_out, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->nilai_buy, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="left">TOTAL : </td>
            <td class="right">{{ number_format($nilaiIn, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($feeIn, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($nilaiOut, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($feeOut, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($buy, 0, '.', ',') }}</td>
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
        size: 595pt 842pt;
        /*size: 842pt 638pt;*/
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
        line-height: 1.25;
    }
    table{
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
    thead{
        text-align: center;
    }
    tbody{
        text-align: center;
    }
    tfoot{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .keterangan{
        text-align: left;
    }
    .table{
        width: 100%;
        font-size: 12px;
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
    .table th{
        vertical-align: top;
        padding: 0.20rem 0;
    }
    .judul, .table-borderless{
        text-align: center;
    }
    .table-borderless th, .table-borderless td {
        border: 0;
        padding: 0.50rem;
    }
    .center{
        text-align: center;
    }

    .left{
        text-align: left;
    }

    .right{
        text-align: right;
    }

    .page-break {
        page-break-before: always;
    }

    .page-break-avoid{
        page-break-inside: avoid;
    }

    .table-header td{
        white-space: nowrap;
    }

    .tengah{
        vertical-align: middle !important;
    }
    .blank-row
    {
        line-height: 70px!important;
        color: white;
    }

</style>
</html>
