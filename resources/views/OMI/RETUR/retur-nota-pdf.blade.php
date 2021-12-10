<!DOCTYPE html>
<html>
<head>
    <title>NOTA BARANG {{ $tipe }}</title>
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
            Status : BAIK ke {{ $tipe }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ Session::get('usid') }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">
        ** NOTA BARANG {{ $tipe }} **<br>
        (RETUR OMI VIA DCP)<br>
        No. : {{ $data[0]->mstd_nodoc }}<span style="color:white">.................</span> Tanggal : {{ $data[0]->tgldoc }}<br>
        No. BPB Retur : {{ $nodoc }} Tanggal : {{ $tgldoc }}
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah">No.</th>
            <th class="tengah">PLU</th>
            <th class="tengah left">Deskripsi Barang</th>
            <th class="tengah">Tag</th>
            <th class="tengah right">Satuan</th>
            <th class="tengah">Qty</th>
            <th class="tengah">Fr</th>
            <th class="tengah">Avg. Cost</th>
            <th class="tengah">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 0; $subtotal = 0; @endphp
        @foreach($data as $d)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td>{{ $d->prd_kodetag }}</td>
                <td class="right">{{ $d->kemasan }}</td>
                <td class="right">{{ $d->qty }}</td>
                <td class="right">{{ $d->qtyk }}</td>
                <td class="right">{{ number_format($d->avgcost,0,'.',',') }}</td>
                <td class="right">{{ number_format($d->subtotal,0,'.',',') }}</td>
            </tr>
            @php $subtotal += $d->subtotal; @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr class="bold">
            <td colspan="6">{{ $data[0]->tko_namaomi }} {{ $data[0]->rom_kodetoko }} ( {{ $data[0]->rom_member }} )</td>
            <td>TOTAL</td>
            <td colspan="2" class="right">{{ number_format($subtotal,0,'.',',') }}</td>
            <td colspan="7"></td>
        </tr>
        <tr class="bold">
            <td colspan="14" class="left">BUKTI RETUR NO {{ $data[0]->rom_noreferensi }}</td>
        </tr>
        </tfoot>
    </table>

    <table style="width: 100%; font-weight: bold" class="table-ttd page-break-avoid">
        <tr>
            <td>Disetujui,</td>
            <td>Dicetak,</td>
        </tr>
        <tr class="blank-row">
            <td colspan="4">.</td>
        </tr>
        <tr>
            <td><p class="overline">Logistic Adm. Spv</p></td>
            <td><p class="overline">Logistic Adm. Clr</p></td>
        </tr>
    </table>
</main>

<br>
</body>
<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: 595pt 842pt;
        /*size: 842pt 595pt;*/
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

    .overline{
        text-decoration: overline;
    }
</style>
</html>
