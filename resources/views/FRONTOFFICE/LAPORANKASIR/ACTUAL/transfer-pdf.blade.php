<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rincian Transaksi Transfer - {{ $tanggal }}</title>
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
        ** LAPORAN RINCIAN TRANSAKSI TRANSFER **<br>
        Tanggal : {{ $tanggal }}
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th></th>
            <th colspan="2">Member</th>
            <th></th>
            <th colspan="6">Nilai ( Rp. )</th>
            <th></th>
        </tr>
        <tr>
            <th class="right">No.</th>
            <th class="center">Kode</th>
            <th class="center">Nama Membber</th>
            <th class="left">Struk Penjualan</th>
            <th class="right">Tran. Transfer</th>
            <th class="right">R/K</th>
            <th class="right">Tunai Fisik</th>
            <th class="right">Voucher</th>
            <th class="right">NK</th>
            <th class="right">Cashback</th>
            <th class="right">Keterangan</th>
        </tr>
        </thead>
        <tbody>
        @php
            $transfer = 0;
            $rk = 0;
            $tunai = 0;
            $voucher = 0;
            $nk = 0;
            $cb = 0;
            $i = 0;
        @endphp
        @if(!$data)
            <tr>
                <td colspan="11">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $d)
            @php
                $i++;
                $transfer += $d->rfr_transferamt;
                $rk += $d->rfr_nilairk;
                $tunai += $d->rfr_paymentrk;
                $voucher += $d->voucher;
                $nk += $d->nk;
                $cb += $d->cb;
            @endphp
            <tr>
                <td>{{ $i }}</td>
                <td class="left">{{ $d->rfr_kodemember }}</td>
                <td class="left">{{ $d->cus_namamember }}</td>
                <td class="left">{{ $d->kassa }}</td>
                <td class="right">{{ number_format($d->rfr_transferamt, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->rfr_nilairk, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->rfr_paymentrk, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->voucher, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->nk, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->cb, 0, '.', ',') }}</td>
                <td>{{ $d->rfr_attr1 }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4" class="right">TOTAL :</td>
            <td class="right">{{ number_format($transfer, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($rk, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($tunai, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($voucher, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($nk, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($cb, 0, '.', ',') }}</td>
            <td></td>
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
