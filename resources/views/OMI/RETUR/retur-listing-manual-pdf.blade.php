<!DOCTYPE html>
<html>
<head>
    <title>LIST BUKTI PENERIMAAN BARANG RETUR</title>
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
            {{ $perusahaan->prs_namacabang }}<br><br>
            Member : {{ $data[0]->rom_member }} - {{ $data[0]->cus_namamember }}<br><br>
            N.P.W.P : {{ $data[0]->cus_npwp }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Waktu Cetak : {{ date("d/m/Y").' - '.$datetime->format('H:i:s') }}<br><br>
            No. PO : {{ $data[0]->rom_nopo }}<br><br>
            No. NRB : {{ $data[0]->rom_noreferensi }}<br><br>
            TOP : {{ $data[0]->rom_tgljatuhtempo }}<br><br>
{{--            Hal. :<br><br>--}}
{{--            <i>User ID</i> : {{ $_SESSION['usid'] }}<br><br>--}}

    </div>
    <h2 style="text-align: center">
        ** LIST BUKTI PENERIMAAN BARANG RETUR **<br>
        No : {{ $nodoc }} Tanggal : {{ $tgldoc }}<br>
        (MANUAL)
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah">No.</th>
            <th rowspan="2" class="tengah left">PLU</th>
            <th rowspan="2" class="tengah left">Deskripsi</th>
            <th rowspan="2" class="tengah left">Satuan</th>
            <th colspan="2" class="center">----- Kuantitas -----</th>
            <th rowspan="2" class="tengah right">Harga Average</th>
            <th rowspan="2" class="tengah">Total</th>
        </tr>
        <tr>
            <th class="right">Permohonan</th>
            <th class="right">Realisasi</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 0; $subtotal = 0; @endphp
        @foreach($data as $d)
            <tr>
                <td>{{ ++$i }}</td>
                <td class="left">{{ $d->rom_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td class="left">{{ $d->kemasan }}</td>
                <td class="right">{{ $d->rom_qty }}</td>
                <td class="right">{{ $d->rom_qtyrealisasi }}</td>
                <td class="right">{{ number_format($d->rom_avgcost,0,'.',',') }}</td>
                <td class="right">{{ number_format($d->rom_ttlcost,0,'.',',') }}</td>
            </tr>
            @php $subtotal += $d->rom_ttlcost; @endphp
        @endforeach
        </tbody>
        <tfoot>
            <tr class="bold">
                <td class="top-bottom" colspan="2">TOTAL</td>
                <td class="top-bottom" colspan="5"></td>
                <td class="top-bottom right">{{ number_format($subtotal,0,'.',',') }}</td>
            </tr>
        </tfoot>
    </table>
    <table style="width: 100%; font-weight: bold" class="table table-ttd page-break-avoid">
        <tr>
            <td>Penerimaan Dokumen,</td>
            <td>Disetujui,</td>
            <td>Dicetak,</td>
        </tr>
        <tr class="blank-row">
            <td colspan="4">.</td>
        </tr>
        <tr>
            <td><p class="overline">Supplier</p></td>
            <td><p class="overline">Logistic Adm. Officer</p></td>
            <td><p class="overline">Logistic Adm. Clerk -R-</p></td>
        </tr>
    </table>
</main>

<br>
</body>
<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: 595pt 442pt;
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
