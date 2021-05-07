<!DOCTYPE html>
<html>
<head>
    <title>Tanda Terima Barang (SJAS)</title>
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
            {{ $perusahaan->prs_namacabang }}<br><br><br><br><br><br>
            Total record : {{ count($data) }}<br><br>
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>
            <strong>{{ $reprint }}</strong><br><br>
            Dicetak : {{ date("d/m/Y") }} {{ $datetime->format('H:i:s') }}<br><br>
            Customer : {{ $data[0]->sjh_kodecustomer }} {{ $data[0]->cus_namamember }}<br><br>
            Struk : {{ $data[0]->sjh_tglstruk }} - {{ $data[0]->struk }}<br><br>
            Tahap : {{ $data[0]->sjd_tahapan }} Penitipan : {{ $data[0]->sjh_tglpenitipan }}
        </p>
    </div>
    <div style="text-align: center">
        <h2>** TANDA TERIMA BARANG **<br>
        ( Surat Jalan Atas Struk )<br>
        No. {{ $data[0]->sjh_nosjas }} - {{ $data[0]->sjd_tgltahapan }}
        </h2>
    </div>

</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>NO</th>
            <th>ITEM BARANG</th>
            <th>PLU</th>
            <th>UNIT</th>
            <th>JUMLAH AMBIL</th>
            <th>SISA TITIPAN</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            <tr>
                <td>{{ $d->sjd_seqno }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td>{{ $d->sjd_prdcd }}</td>
                <td>{{ $d->unit }}</td>
                <td class="right">{{ $d->sjd_qtystruk }}</td>
                <td class="right">{{ $d->qtysisa }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <br>
    <table style="width: 100%; font-weight: bold" class="table-ttd page-break-avoid">
        <tr>
            <td>Diterima,</td>
            <td>Diserahkan,</td>
            <td>Disetujui,</td>
            <td>Dibuat,</td>
        </tr>
        <tr class="blank-row">
            <td colspan="4">.</td>
        </tr>
        <tr>
            <td>Customer</td>
            <td>Checker SPV / Delivery</td>
            <td>Duty Manager</td>
            <td>Checker</td>
        </tr>
        <tr><td colspan="4" class="left" style="font-weight: normal">Note : INDOGROSIR Tidak Bertanggung Jawab Terhadap Barang Titipan Jika Terjadi Musibah Kebakaran / Kebanjiran / dll.</td></tr>
    </table>
</main>

<br>
</body>
<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: 595pt 442pt;
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
    }
    body {
        margin-top: 100px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
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
        font-size: 7px;
        /*white-space: nowrap;*/
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table-ttd{
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

    .border-top{
        border-top: 1px solid black;
    }

</style>
</html>
