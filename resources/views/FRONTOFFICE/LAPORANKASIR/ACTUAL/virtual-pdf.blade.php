<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Virtual Untuk Kasir Online - {{ $tanggal }}</title>
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
        ** TRANSAKSI VIRTUAL UNTUK KASIR ONLINE **<br>
        Tanggal : {{ $tanggal }}
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left">Tipe Transaksi</th>
            <th class="right">Penjualan</th>
            <th class="right">Fee</th>
        </tr>
        </thead>
        <tbody>
        @php
            $penjualan = 0;
            $fee = 0;
        @endphp
        @if(!$data)
            <tr>
                <td colspan="3">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $d)
            @php
                $penjualan += $d->ttl;
                $fee += $d->fee;
            @endphp
            <tr>
                <td class="left">{{ $d->vir_type }}</td>
                <td class="right">{{ number_format($d->ttl, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->fee, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="right">TOTAL NILAI</td>
            <td class="right">{{ number_format($penjualan, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($fee, 0, '.', ',') }}</td>
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
        border-top: 2px solid black;
        border-bottom: 2px solid black;
        font-weight: bold;
    }

    .keterangan{
        text-align: left;
    }
    .table{
        width: 100%;
        font-size: 10px;
        white-space: nowrap;
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
