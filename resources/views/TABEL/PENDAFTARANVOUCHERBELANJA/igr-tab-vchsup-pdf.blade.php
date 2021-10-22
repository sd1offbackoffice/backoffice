<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN REGISTER PPR</title>

</head>
<body>

<?php
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
<header>
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>{{$perusahaan->prs_namaperusahaan ?? '..'}}</p>
        <p>{{$perusahaan->prs_namacabang ?? '..'}}</p>
        <p>{{$perusahaan->prs_namawilayah ?? '..'}}</p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 5px !important;">
        <p> Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
    </div>
    <h2 style="text-align: center">** TABEL PENDAFTARAN VOUCHER SUPPLIER ** </h2>
</header>

<main style="margin-top: 0px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>SINGKATAN<br>SUPPLIER</th>
            <th>NILAI VOUCHER</th>
            <th>TGL MULAI</th>
            <th>TGL AKHIR</th>
            <th>MAX VOUCHER</th>
            <th>MIN STRUK</th>
            <th>JOIN PROMO</th>
            <th>KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
        @if(sizeof($data)!=0)
            @for($i = 0; $i < sizeof($data); $i++)
                <tr>
                    <td align="center">{{$data[$i]->vcs_namasupplier}}</td>
                    <td align="center">{{$data[$i]->vcs_nilaivoucher}}</td>
                    <td align="center">{{substr($data[$i]->vcs_tglmulai,0,10)}}</td>
                    <td align="center">{{substr($data[$i]->vcs_tglakhir,0,10)}}</td>
                    <td align="center">{{$data[$i]->vcs_maxvoucher}}</td>
                    <td align="center">{{$data[$i]->vcs_minstruk}}</td>
                    <td align="center">{{$data[$i]->vcs_joinpromo}}</td>
                    <td align="left">{{$data[$i]->vcs_keterangan}}</td>
                </tr>
            @endfor
        @else
            <tr>
                <td colspan="12">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <p style="text-align: right">**Akhir dari Laporan **</p>

</main>

<br>
</body>


<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: 750pt 500pt;
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

    table {
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

    thead {
        text-align: center;
    }

    tbody {
        text-align: center;
    }

    tfoot {
        border-top: 1px solid black;
    }

    .keterangan {
        text-align: left;
    }

    .table {
        width: 100%;
        font-size: 7px;
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }

    .table-ttd {
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

    .table th {
        vertical-align: top;
        padding: 0.20rem 0;
    }

    .judul, .table-borderless {
        text-align: center;
    }

    .table-borderless th, .table-borderless td {
        border: 0;
        padding: 0.50rem;
    }

    .center {
        text-align: center;
    }

    .left {
        text-align: left;
    }

    .right {
        text-align: right;
    }

    .page-break {
        page-break-before: always;
    }

    .page-break-avoid {
        page-break-inside: avoid;
    }

    .table-header td {
        white-space: nowrap;
    }

    .tengah {
        vertical-align: middle !important;
    }

    .blank-row {
        line-height: 70px !important;
        color: white;
    }

    .border-top {
        border-bottom: 1px solid black;
    }

</style>
</html>
