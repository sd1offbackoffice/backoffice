<!DOCTYPE html>
<html>
<head>
    <title>Kertas Kerja Harian PB Manual</title>
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
            Total record : {{ count($data) }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ $_SESSION['usid'] }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">** MONITORING STOK ITEM PARETO **</h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">PLU</th>
            <th class="tengah" rowspan="2">DESKRIPSI</th>
            <th class="tengah" rowspan="2">SATUAN</th>
            <th class="tengah" colspan="2">OUTSTAND PO</th>
            <th class="tengah" colspan="3">SALES 3 BULAN</th>
            <th class="tengah" rowspan="2">HARI<br>SALES</th>
            <th class="tengah" colspan="2">AVG SALES</th>
            <th class="tengah" rowspan="2">SALDO<br>SAAT INI</th>
            <th class="tengah" rowspan="2">PKMT</th>
        </tr>
        <tr>
            <th>JML</th>
            <th>QTY</th>
            <th>BLN-1</th>
            <th>BLN-2</th>
            <th>BLN-3</th>
            <th>BULAN</th>
            <th>HARI</th>
        </tr>
        </thead>
        <tbody>
        @php
            $div = '';
            $dep = '';
            $kat = '';
        @endphp
        @foreach($data as $d)
            @if($div != $d->div || $dep != $d->dep || $kat != $d->kat)
                @php
                    $div = $d->div;
                    $dep = $d->dep;
                    $kat = $d->kat;
                @endphp
                <tr>
                    <td colspan="13" class="left"><strong>DIV {{ $d->div }} {{ $d->nmdiv }} - DEPT {{ $d->dep }} {{ $d->nmdep }} - KAT {{ $d->kat }} {{ $d->nmkat }}</strong></td>
                </tr>
            @endif
            <tr>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->deskripsi }}</td>
                <td>{{ $d->satuan }}</td>
                <td class="right">{{ $d->outpo }}</td>
                <td class="right">{{ $d->outqty }}</td>
                <td class="right">{{ $d->qty3 }}</td>
                <td class="right">{{ $d->qty2 }}</td>
                <td class="right">{{ $d->qty1 }}</td>
                <td class="right">{{ $d->cp_hari }}</td>
                <td class="right">{{ $d->cp_avgbulan }}</td>
                <td class="right">{{ $d->cp_avghari }}</td>
                <td class="right">{{ $d->saldoakhir }}</td>
                <td class="right">{{ $d->pkmt }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="44" class="right">** Akhir dari laporan **</td>
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
