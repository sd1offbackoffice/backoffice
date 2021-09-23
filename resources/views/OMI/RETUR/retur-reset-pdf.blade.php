<!DOCTYPE html>
<html>
<head>
    <title>STRUK RESET KASIR</title>
</head>
<body>

<?php
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
<header>
    {{--    <p>--}}
    {{--        {{ $perusahaan->prs_namaperusahaan }}<br>--}}
    {{--        {{ $perusahaan->prs_namacabang }}<br><br>--}}
    {{--    </p>--}}
    {{--    <h3 style="text-align: center">--}}
    {{--        ** STRUK RESET KASIR **<br>--}}
    {{--        No. Reset : {{ $noreset }}--}}
    {{--    </h3>--}}
</header>

<footer>

</footer>

<main>
    <p>
        {{ $perusahaan->prs_namaperusahaan }}<br>
        {{ $perusahaan->prs_namacabang }}<br><br>
    </p>
    <h3 style="text-align: center">
        ** STRUK RESET KASIR **<br>
        No. Reset : {{ $noreset }}
    </h3>
    <hr>
    <hr>
    <hr>
    <br>
    <table width="100%">
        <tbody>
        <tr>
            <td class="left">KODE CABANG</td>
            <td class="left">: {{ $data->rom_kodeigr }}</td>
        </tr>
        <tr>
            <td class="left">TANGGAL</td>
            <td class="left">: {{ $tanggal }}</td>
        </tr>
        <tr>
            <td class="left">JAM SELESAI</td>
            <td class="left">: {{ $data->jam }}</td>
        </tr>
        <tr>
            <td class="left">NOMOR STATION</td>
            <td class="left">: {{ $data->rom_station }}</td>
        </tr>
        <tr>
            <td class="left">KASIR</td>
            <td class="left">: {{ $data->rom_kodekasir }}</td>
        </tr>
        <tr class="blank-row">
            <td>.</td>
        </tr>
        <tr>
            <td class="left">DIRESET OLEH</td>
            <td class="left">: {{ $data->js_create_by }}</td>
        </tr>
        <tr>
            <td class="left">TANGGAL</td>
            <td class="left">: {{ $data->tanggal }}</td>
        </tr>
        <tr>
            <td class="left">JAM</td>
            <td class="left">: {{ $data->jam }}</td>
        </tr>
        <tr class="blank-row">
            <td>.</td>
        </tr>
        <tr>
            <td class="left">Rp. KREDIT</td>
            <td class="left">: {{ number_format($data->js_totcreditsalesamt,2,'.',',') }}</td>
        </tr>
        <tr class="blank-row">
            <td>.</td>
        </tr>
        <tr>
            <td colspan="2">**------------------INFORMASI TRANSAKSI------------------**</td>
        </tr>
        <tr>
            <td class="left">PENJUALAN</td>
            <td class="left">: {{ number_format($data->penjualan,2,'.',',') }}</td>
        </tr>
        <tr>
            <td class="left">TOTAL TRANSAKSI</td>
            <td class="left">: {{ number_format($data->penjualan,2,'.',',') }}</td>
        </tr>
        <tr class="blank-row">
            <td>.</td>
        </tr>
        <tr>
            <td colspan="2">**-------------------INFORMASI LAIN-LAIN-------------------**</td>
        </tr>
        <tr>
            <td class="left">JUMLAH TRANSAKSI</td>
            <td class="left">: {{ $data->rom_jenistransaksi }}</td>
        </tr>
        <tr>
            <td class="left">JUMLAH VOID</td>
            <td class="left">: 0</td>
        </tr>
        </tbody>
    </table>
</main>

<br>
</body>
<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        /*size: 595pt 842pt;*/
        size: 298pt 502pt;
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
        margin-top: 0px;
        margin-bottom: 0px;
        font-size: 12px;
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
        line-height: 20px!important;
        color: white;
    }

    .bold td{
        font-weight: bold;
    }

    .top-bottom{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .top{
        border-top: 1px solid black;
    }
</style>
</html>
