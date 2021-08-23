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
            BARANG COUNTER : {{ $counter }}
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
            <th class="center tengah" colspan="2">Outlet</th>
            <th class="center tengah" colspan="2">Sub Outlet</th>
            <th class="right tengah">Slip</th>
            <th class="right tengah">Produk</th>
            <th class="right tengah">Member</th>
            <th class="right tengah">Kunjungan</th>
            <th class="right tengah">Kont</th>
            <th class="right tengah">Rupiah</th>
            <th class="right tengah">&nbsp;&nbsp;&nbsp;&nbsp;Kont</th>
            <th class="right tengah">Margin</th>
            <th class="right tengah">&nbsp;&nbsp;&nbsp;&nbsp;Kont</th>
            <th class="right tengah">%</th>
            <th class="right">&nbsp;&nbsp;&nbsp;&nbsp;MBR<br>1X / BLN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $kunjungan = 0;
            $slip = 0;
            $produk = 0;
            $member = 0;
            $rupiah = 0;
            $margin = 0;
            $otbmemb = 0;

            $no = 1;
        @endphp
        @foreach($data as $d)
            <tr>
                <td class="left">{{ $d->foutlt }}</td>
                <td class="left">{{ $d->out_namaoutlet }}</td>
                <td class="left">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->fsoutl }}</td>
                <td class="left">{{ $d->sub_namasuboutlet }}</td>
                <td class="right">{{ $d->otslip }}</td>
                <td class="right">{{ $d->otprod }}</td>
                <td class="right">{{ $d->otmemb }}</td>
                <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->otfreq }}</td>
                <td class="right">{{ $d->qtmemb }}</td>
                <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($d->otamt, 0, '.', ',') }}</td>
                <td class="right">{{ $d->qtamt }}</td>
                <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format($d->otamt - $d->otcost, 0, '.', ',') }}</td>
                <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->qtcost }}</td>
                <td class="right">&nbsp;&nbsp;&nbsp;&nbsp;{{ number_format(($d->otamt - $d->otcost) / $d->otamt * 100, 2) }}</td>
                <td class="right">{{ $d->otbmemb }}</td>
            </tr>
        @php
            $no++;
            $kunjungan += $d->otfreq;
            $slip += $d->otslip;
            $produk += $d->otprod;
            $member += $d->otmemb;
            $rupiah += $d->otamt;
            $margin += ($d->otamt - $d->otcost);

            $otbmemb += $d->otbmemb;
        @endphp
        @endforeach
        <tfoot>
        <tr class="bold">
            <td class="right" colspan="4">TOTAL :</td>
            <td class="right">{{ number_format($slip, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($produk, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($member, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($kunjungan, 0, '.', ',') }}</td>
            <td></td>
            <td class="right">{{ number_format($rupiah, 0, '.', ',') }}</td>
            <td></td>
            <td class="right">{{ number_format($margin, 0, '.', ',') }}</td>
            <td></td>
            <td class="right">{{ number_format($margin / $rupiah * 100, 2, '.', ',') }}</td>
            <td class="right">{{ number_format($otbmemb, 0, '.', ',') }}</td>
        </tr>
        <tr class="bold">
            <td class="right" colspan="4">TOTAL CAB LAIN :</td>
            <td class="right" colspan="11"></td>
        </tr>
        <tr class="bold">
            <td class="right" colspan="4">GRAND TOTAL :</td>
            <td class="right" colspan="11"></td>
        </tr>
        <tr class="bold">
            <td colspan="13" class="right">Total Poin Internal Member Merah : {{ $poin }}</td>
            <td colspan="2"></td>
        </tr>
        <tr class="bold">
            <td style="border-top: 1px solid black" colspan="15" class="right">** Akhir dari laporan **</td>
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
