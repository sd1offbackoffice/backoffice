<!DOCTYPE html>
<html>
<head>
    <title> HAPUS TAHUN  </title>
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
    <div style="float:right; margin-top: 0px; line-height: 10px !important;">
        <p>TANGGAL : {{ date("d-m-Y") }}<br><br>
            PROGRAM : RETUR BARANG KE SUPPLIER & SUPPLIER <br><br>
            JAM : {{ $datetime->format('H:i:s') }}<br><br>
    </div>
    <h2 style="text-align: center">RETUR BARANG KE SUPPLIER & SUPPLIER</h2>
</header>

<footer>

</footer>

<main>
    <table class="table table-responsive">
        <thead style="border-top: double; border-bottom: double;">
        <tr>
            <th class="tengah" width="5%">No.</th>
            <th class="tengah" style="text-align: left" width="15%">Kode Member</th>
            <th class="tengah" style="text-align: left" width="20%">Nama Member</th>
            <th class="tengah" width="20%">Saldo Sebelum</th>
            <th class="tengah" width="20%">Saldo Sekarang</th>
            <th class="tengah" width="20%">Nilai yg Dihapus</th>
        </tr>

        </thead>
        <tbody>
        @for($j = 0; $j < sizeof($data); $j++)
            <tr>
                <td>{{ $j+1 }}</td>
                <td style="text-align: left">{{ $data[$j]->kd_member }}</td>
                <td style="text-align: left">{{ $data[$j]->nm_member }}</td>
                <td style="text-align: left">{{ $data[$j]->sebelum }}</td>
                <td>{{ $data[$j]->sesudah }}</td>
                <td>{{ $data[$j]->hapus }}</td>
            </tr>
        @endfor
        </tbody>
        <tr>
            <td colspan="13" style="border-bottom: 1px black solid"></td>
        </tr>
    </table>
    <span class="right" style="float: right">Total Data Yang Di Hapus :</span><span style="float: right" class="right">{{count($data)}} Item(s) Transferred</span>
</main>

<br>
</body>
<style>
    @page {
        margin: 25px 20px;
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

    .table{
        width: 100%;
        font-size: 9px;
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

    .page-break {
        page-break-before: always;
    }

    .page-break-avoid{
        page-break-inside: avoid;
    }

    .table-header td{
        white-space: nowrap;
    }

    .blank-row
    {
        line-height: 70px!important;
        color: white;
    }

</style>
</html>
