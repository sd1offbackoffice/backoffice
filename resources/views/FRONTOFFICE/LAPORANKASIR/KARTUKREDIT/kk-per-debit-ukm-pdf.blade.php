<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Kartu Debit & Kredit Usaha {{ $tgl1 }} - {{ $tgl2 }}</title>
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
        ** LAPORAN TRANSAKSI KARTU DEBIT & KREDIT USAHA **<br>
        Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" colspan="2">Jenis Kartu</th>
            <th class="right">Pembayaran</th>
            <th class="right">Tarik Tunai</th>
            <th class="left">&nbsp;&nbsp;&nbsp;&nbsp;ID. Trans</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tanggal = '';
            $namakartu = '';

            $nilai = 0;
            $tunai = 0;

            $nilaiTgl = 0;
            $tunaiTgl = 0;

            $nilaiTotal = 0;
            $tunaiTotal = 0;
        @endphp
        @foreach($data as $d)
            @php

            @endphp
            @if($tanggal != $d->tanggal)
                @if($namakartu != '')
                    <tr>
                        <td class="left" colspan="2">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Subtotal Per Jenis Debit
                        </td>
                        <td class="right">{{ number_format($nilai, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($tunai, 0, '.', ',') }}</td>
                        <td></td>
                    </tr>
                    <tr class="bold">
                        <td class="left" colspan="2">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Subtotal Debit
                        </td>
                        <td class="right">{{ number_format($nilaiTgl, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($tunaiTgl, 0, '.', ',') }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Subtotal Per Tanggal
                        </td>
                        <td class="right">{{ number_format($nilaiTgl, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($tunaiTgl, 0, '.', ',') }}</td>
                        <td></td>
                    </tr>
                @endif
                <tr class="bold">
                    <td colspan="5" class="left">Tgl : {{ $d->tanggal }}</td>
                </tr>
                @php
                    $tanggal = $d->tanggal;
                    $nilai = 0;
                    $tunai = 0;
                    $nilaiTgl = 0;
                    $tunaiTgl = 0;
                    $namakartu = '';
                    $kode = '';
                @endphp
            @endif
            @if($namakartu != $d->namakartu || $kode != $d->kode)
                @if($namakartu != '')
                    <tr>
                        <td class="left" colspan="2">
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Subtotal per Jenis Debit
                        </td>
                        <td class="right">{{ number_format($nilai, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($tunai, 0, '.', ',') }}</td>
                        <td></td>
                    </tr>
                    @php
                        $nilai = 0;
                        $tunai = 0;
                    @endphp
                @endif
                @php $namakartu = $d->namakartu; $kode = $d->kode; @endphp
                <tr>
                    <td class="left">{{ $d->namakartu }}</td>
                    <td class="left">{{ $d->kode }}</td>
                    <td colspan="3"></td>
                </tr>
            @endif
            <tr>
                <td class="left" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->cardcode }}</td>
                <td class="right">{{ number_format($d->nilai, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->tunai, 0, '.', ',') }}</td>
                <td class="left">&nbsp;&nbsp;&nbsp;&nbsp;{{ $d->idtrans }}</td>
            </tr>
        @php
            $nilai += $d->nilai;
            $tunai += $d->tunai;
            $nilaiTgl += $d->nilai;
            $tunaiTgl += $d->tunai;
            $nilaiTotal += $d->nilai;
            $tunaiTotal += $d->tunai;
        @endphp
        @endforeach
            <tr>
                <td class="left" colspan="2">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Subtotal Per Jenis Debit
                </td>
                <td class="right">{{ number_format($nilai, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($tunai, 0, '.', ',') }}</td>
                <td></td>
            </tr>
            <tr class="bold">
                <td class="left" colspan="2">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Subtotal Debit
                </td>
                <td class="right">{{ number_format($nilaiTgl, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($tunaiTgl, 0, '.', ',') }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="left" colspan="2">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Subtotal Per Tanggal
                </td>
                <td class="right">{{ number_format($nilaiTgl, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($tunaiTgl, 0, '.', ',') }}</td>
                <td></td>
            </tr>
        <tfoot>
            <tr class="bold">
                <td class="top-bottom left" colspan="2">** TOTAL DEBIT</td>
                <td class="top-bottom right">{{ number_format($nilaiTotal, 0, '.', ',') }}</td>
                <td class="top-bottom right">{{ number_format($tunaiTotal, 0, '.', ',') }}</td>
                <td></td>
            </tr>
            <tr class="bold">
                <td style="border-top: 1px solid black" colspan="9" class="right">** Akhir dari laporan **</td>
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
        font-size: 11px;
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
