<!DOCTYPE html>
<html>
<head>
    <title>LISTING BUKTI BARANG RETUR DARI OMI VIA DCP</title>
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
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ Session::get('usid') }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">
        ** LISTING BUKTI BARANG RETUR DARI OMI VIA DCP **<br>
        OMI : {{ $kodetoko }} - {{ $namatoko }}<br>
        No Dokumen : {{ $nodoc }}
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th class="left">No. Dok</th>
                <th class="left">Tgl. Dok</th>
                <th class="left">PLU</th>
                <th class="left">Nama Barang</th>
                <th class="left">Satuan</th>
                <th class="right">Qty</th>
                <th class="right">Nilai</th>
            </tr>
        </thead>
        <tbody>
        @php $subnilai = 0; $temp = ''; @endphp
        @foreach($data as $d)
            @if($d->rom_noreferensi != $temp && $temp != '')
                @php $subnilai = 0; @endphp
                <tr>
                    <td colspan="2">SUBTOTAL :</td>
                    <td colspan="4"></td>
                    <td class="right">{{ number_format($subnilai,0,'.',',') }}</td>
                </tr>
            @endif
            <tr>
                @if($d->rom_noreferensi != $temp)
                    @php $temp = $d->rom_noreferensi; @endphp
                    <td class="left">{{ $d->rom_noreferensi }}</td>
                    <td class="left">{{ $d->rom_tglreferensi }}</td>
                @else
                    <td colspan="2"></td>
                @endif
                <td class="left">{{ $d->prc_pluomi }}</td>
                <td class="left">{{ $d->prd_deskripsipendek }}</td>
                <td class="left">{{ $d->kemasan }}</td>
                <td class="right">{{ $d->rom_qty }}</td>
                <td class="right">{{ number_format($d->rom_ttl,0,'.',',') }}</td>
            </tr>
            @php $subnilai += $d->rom_ttl; @endphp
        @endforeach
            <tr class="bold">
                <td class="left" colspan="2">SUBTOTAL :</td>
                <td colspan="4"></td>
                <td class="right top-bottom">{{ number_format($subnilai,0,'.',',') }}</td>
            </tr>
        </tbody>
        <tfoot>
        <tr class="bold">
            <td class="top-bottom" colspan="2">TOTAL AKHIR :</td>
            <td class="top-bottom" colspan="4"></td>
            <td class="top-bottom right">{{ number_format($subnilai,0,'.',',') }}</td>
        </tr>
        <tr class="bold">
            <td colspan="7" class="right">** Akhir dari laporan **</td>
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
        /*size: 595pt 842pt;*/
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
