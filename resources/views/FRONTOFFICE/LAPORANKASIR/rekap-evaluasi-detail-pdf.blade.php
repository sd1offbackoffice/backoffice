<!DOCTYPE html>
<html>
<head>
    <title>EVALUASI LANGGANAN PER MEMBER {{ $tgl1 }} - {{ $tgl2 }}</title>
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
            {{ $perusahaan->prs_namacabang }}<br><br><br><br>
            Jenis Member : Member Merah
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ $_SESSION['usid'] }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">
        ** EVALUASI LANGGANAN PER MEMBER **<br>
        Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="center">No.</th>
            <th class="center">Nomor</th>
            <th class="center">Nama Langganan</th>
            <th class="center" colspan="2">Outlet</th>
            <th class="center" colspan="2">Sub Outlet</th>
            <th class="right">Kunjungan</th>
            <th class="right">Slip</th>
            <th class="right">Produk</th>
            <th class="right">Rupiah</th>
            <th class="right">Margin</th>
            <th class="right">%</th>
        </tr>
        </thead>
        <tbody>
        @php
            $kunjungan = 0;
            $slip = 0;
            $produk = 0;
            $rupiah = 0;
            $margin = 0;

            $no = 1;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="left">{{ $no }}</td>
                <td class="left">{{ $d->fcusno }}</td>
                <td class="left">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->fnama }}</td>
                <td class="left">{{ $d->foutlt }}</td>
                <td class="left">{{ $d->out_namaoutlet }}</td>
                <td class="left">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->fsoutl }}</td>
                <td class="left">{{ $d->sub_namasuboutlet }}</td>
                <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->fwfreq }}</td>
                <td class="right">{{ $d->fwslip }}</td>
                <td class="right">{{ $d->fwprod }}</td>
                <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($d->fwamt, 0, '.', ',') }}</td>
                <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($d->fgrsmargn, 0, '.', ',') }}</td>
                <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($d->fgrsmargn / $d->fwamt * 100, 2) }}</td>
            </tr>
            @php
                $no++;
                $kunjungan += $d->fwfreq;
                $slip += $d->fwslip;
                $produk += $d->fwprod;
                $rupiah += $d->fwamt;
                $margin += $d->fgrsmargn;
            @endphp
        @endforeach
        <tfoot>
        <tr class="bold">
            <td class="top-bottom right" colspan="7">TOTAL :</td>
            <td class="top-bottom right">{{ number_format($kunjungan, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($slip, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($produk, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($rupiah, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($margin, 0, '.', ',') }}</td>
            <td class="top-bottom right">{{ number_format($margin / $rupiah * 100, 2, '.', ',') }}</td>
        </tr>
        <tr class="bold">
            <td style="border-top: 1px solid black" colspan="13" class="right">** Akhir dari laporan **</td>
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

    .bold td{
        font-weight: bold;
    }

    .top-bottom{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }
</style>
</html>
