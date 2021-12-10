<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penyesuaian Persediaan Konversi Perishable</title>
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
        <p>Tgl. Cetak : {{ date("d-m-Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ Session::get('usid') }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">DAFTAR PENYESUAIAN PERSEDIAAN<br>KONVERSI PERISHABLE</h2>
    {{--<h2>KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR **<br>Periode : {{ $periode }}</h2>--}}
</header>

<footer>

</footer>

<main>
    <table class="table table-borderless table-header">
        <thead>
        <tr>
            <th>
                Tanggal
            </th>
            <th>
                : {{ $data[0]->mstd_tgldoc }}
            </th>
            <th width="50%"></th>
            <th>RINGKASAN DIVISI / DEPARTEMEN / KATEGORI</th>
        </tr>
        </thead>
    </table>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" width="10%">KODE</th>
            <th class="left" width="70%">NAMA KATEGORI</th>
            <th class="right" width="20%">TOTAL NILAI</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            <tr>
                <td class="left">DIVISI</td>
                <td class="left">: {{ $d->prd_kodedivisi }} - {{ $d->div_namadivisi }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="left">DEPARTEMEN</td>
                <td class="left">: {{ $d->prd_kodedepartement }} - {{ $d->dep_namadepartement }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="left">{{ $d->prd_kodekategoribarang }}</td>
                <td class="left">{{ $d->kat_namakategori }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
            </tr>
            <tr>
                <td class="left" colspan="2">SUBTOTAL DEPARTEMENT : {{ $d->prd_kodedepartement }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
            </tr>
            <tr>
                <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format($d->total,2) }}</td>
        </tr>
        </tfoot>
    </table>
    <hr>
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
        vertical-align: tengah;
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
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table-ttd{
        width: 15%;
    }
    .table tbody td {
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

    .table-header td{
        white-space: nowrap;
    }

    .tengah{
        vertical-align: middle !important;
    }
</style>
</html>
