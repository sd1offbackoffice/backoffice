<!DOCTYPE html>
<html>

<head>
    <title>Laporan Promosi yang Masih Berlaku</title>

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
            {{ $perusahaan->prs_namaperusahaan }}
        </p>
        <p>
            {{ $perusahaan->prs_namacabang }}
        </p>
        <br>
        <p>
            Jenis : {{ $data[0]->cborgf }}<br><br>
        </p>
    </div>
    <div style="float:right; margin-top: 0px;">
        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>
        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>
        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>
    </div>
    <div>
        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">LAPORAN PROMOSI YANG MASIH BERLAKU</p>
    </div>
</header>

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th align="right" class="padding-right" rowspan="3">No</th>
            <th align="left" rowspan="3">Kode<br>Promosi</th>
            <th align="left" rowspan="3" align="left">Nama Program Promosi</th>
            <th align="left" rowspan="3">Berlaku<br>untuk<br>Member</th>
            <th align="left" rowspan="3">Produk Sponsor</th>
            <th align="left" rowspan="3">Produk Hadiah</th>
            <th style="padding-left: 5px" colspan="3">Mekanisme</th>
            <th align="left" colspan="2">Periode Promosi</th>
        </tr>
        <tr>
            <th colspan="2">Beli</th>
            <th align="left" class="padding-right" >Hadiah</th>
            <th align="left" >Awal</th>
            <th align="left" >Akhir</th>
        </tr>
        <tr>
            <th align="right" class="padding-right">Rp.</th>
            <th align="right" class="padding-right">Qty.</th>
            <th align="right" class="padding-right">Qty.</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $i=1;
        @endphp

        @if(sizeof($data)!=0)
            @foreach($data as $d)
                <tr>
                    <td align="right" class="padding-right">{{ $i }}</td>
                    <td align="left">{{ $d->kodepromosi }}</td>
                    <td align="left">{{ $d->promosi}}</td>
                    <td align="left">{{ $d->memberberlaku }}</td>
                    <td align="left">{{ $d->plu }}</td>
                    <td align="right" class="padding-right">{{ $d->hadiah }}</td>
                    <td align="right">{{ number_format($d->minbeli, 0,".",",")  }}</td>
                    <td align="right" class="padding-right">{{ number_format($d->minqty, 0,".",",") }}</td>
                    <td align="right" class="padding-right">{{ number_format($d->gfh_jmlhadiah, 0,".",",") }}</td>
                    <td align="left" class="padding-right">{{ date('d/m/Y',strtotime(substr($d->gfh_tglawal,0,10))) }}</td>
                    <td align="left">{{ date('d/m/Y',strtotime(substr($d->gfh_tglakhir,0,10))) }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        <tr>
            <th colspan="11" class="right">** Akhir dari laporan **</th>
        </tr>
        </tfoot>
    </table>

<br>
</body>


<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
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
    .table tbody td.padding-right, .table thead th.padding-right {
        padding-right: 10px !important;
    }
</style>
</html>
