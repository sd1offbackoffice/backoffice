<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tolakan PB</title>
</head>
<body>
<!-- <a href="/getPdf"><button>Download PDF</button></a> -->

<?php
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
<header>
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>{{ $perusahaan->prs_namaperusahaan }}<br><br>
            {{ $perusahaan->prs_namacabang }}<br><br>
            {{ $perusahaan->prs_namaregional }}</p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>TGL : {{ date("d-m-Y") }}<br><br>
            JAM : {{ $datetime->format('H:i:s') }}<br><br>
            PGM : IGR_BO_CTKTLKNPB</p>
    </div>
    <p style="text-align: center"><strong style="font-size: 10">{{ $title }}</strong><br>TANGGAL : 01/08/2015 s/d 01/08/2015</p>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <td>TANGGAL<span style="display:inline-block; width:15;"></span>DOKUMEN</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td width="3%">PLU</td>
            <td width="8%">DESKRIPSI</td>
            <td width="2%" class="kanan">SATUAN</td>
            <td width="2%">TAG</td>
            <td width="2%">SUPPLIER</td>
            <td width="2%">PKMT</td>
            <td width="2%">KETERANGAN</td>
        </tr>
        </thead>
        <tbody>
        {{--@foreach($tolakan as $t)--}}
            {{--<tr>--}}
                {{--<td width="3%">{{ $t->prdcd }}</td>--}}
                {{--<td width="8%">{{ substr($t->prd_desk,0,25) }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->prd_satuan }}</td>--}}
                {{--<td width="2%" class="tengah">{{ $t->prd_kodetag }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->stok_qtyb }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->stok_qtyk}}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->minorder_qtyb }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->minorder_qtyk }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->max_qtyb }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->max_qtyk }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->min_qtyb }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->min_qtyb }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->po_qtyb }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->po_qtyk }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->pb_qtyb }}</td>--}}
                {{--<td width="2%" class="kanan">{{ $t->pb_qtyk }}</td>--}}
            {{--</tr>--}}
        {{--@endforeach--}}
        </tbody>
        <tfoot>
        </tfoot>
    </table>

    <hr>
    <strong style="float:right">** Akhir Dari Laporan **</strong>
</main>

<br>
</body>
<style>
    @page {
        margin: 25px 25px;
        /*size: 1071pt 792pt;*/
        size: 595pt 842pt;
    }

    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }
    body {
        margin-top: 70px;
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
    .table{
        width: 100%;
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        margin-top: 25px;
    }
    .kanan{
        text-align: right;
    }

    .tengah{
        text-align: center;
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

</style>
</html>
