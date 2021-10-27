@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    {{ strtoupper($data1[0]->judul) }}
@endsection

@section('title')
    {{ $title }}
@endsection

@section('subtitle')
    {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">NO</th>
            <th colspan="2">---- BAPB ----</th>
            <th colspan="2">---- REF ----</th>
            <th class="tengah right" rowspan="2">TOTAL</th>
            <th class="tengah" rowspan="2">STATUS</th>
            <th class="tengah" rowspan="2">KETERANGAN</th>
        </tr>
        <tr>
            <th>NOMOR</th>
            <th>TANGGAL</th>
            <th>NOMOR</th>
            <th>TANGGAL</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 1;
            $temp = '';
            $total = 0;
            $subtotal = 0;
        @endphp
        @foreach($data as $d)
            @if($temp != $d->msth_tgldoc)
                @if($temp != '')
                    <tr>
                        <td class="left" colspan="5">SUBTOTAL TANGGAL {{ $temp }}</td>
                        <td class="right">{{ number_format($subtotal, 2, '.', ',') }}</td>
                        <td class="" colspan="2"></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->msth_tgldoc;
                    $subtotal = 0;
                @endphp
                <tr>
                    <td class="left border-top" colspan="11">TANGGAL {{ $d->msth_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->mstd_nodoc }}</td>
                <td>{{ $d->msth_tgldoc}}</td>
                <td class="tengah">{{ $d->mstd_nopo }}</td>
                <td class="tengah">{{ $d->mstd_tglpo }}</td>
                <td class="right">{{ number_format($d->total, 2, '.', ',') }}</td>
                <td class="tengah">{{ $d->status }}</td>
                <td class="tengah">{{ $d->cket1 }}</td>
            </tr>
            @php
                $i++;
                $subtotal += $d->total;
                $total += $d->total;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="5">SUBTOTAL TANGGAL {{ $temp }}</td>
            <td class="right">{{ number_format($subtotal, 2, '.', ',') }}</td>
            <td class="" colspan="2"></td>
        </tr>
        <tr>
            <td class="border-top left" colspan="5">TOTAL SELURUHNYA</td>
            <td class="border-top right">{{ number_format($total, 2, '.', ',') }}</td>
            <td class="border-top" colspan="2"></td>
        </tr>
        </tfoot>
    </table>
@endsection
<!DOCTYPE html>
<html>

<head>
    <title>{{ strtoupper($data1[0]->judul) }}</title>

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
            <b>{{ $perusahaan->prs_namaperusahaan }}</b><br><br>
            NPWP : {{ $perusahaan->prs_npwp }}<br><br>
            NOMOR : {{ $data1[0]->msth_nodoc }} <br>TANGGAL : {{ substr($data1[0]->msth_tgldoc,0,10) }}<br><br>
            NO. REF : {{ $data1[0]->msth_nopo }} <br>TGL. REF : {{ substr($data1[0]->msth_tglpo,0,10) }}<br><br>
            KETERANGAN : {{ $data1[0]->ket }} <br><br>
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>
            {{ $perusahaan->prs_namacabang }}<br>
            {{ $perusahaan->prs_alamat1 }}<br>
            {{ $perusahaan->prs_alamat3 }}
        </p><br><br>
        <p>
            {{ $data1[0]->status }}
        </p>
    </div>
    <h2 style="text-align: center"> NOTA PENGELUARAN BARANG <br>{{ strtoupper($data1[0]->judul) }}</h2>
</header>

<main style="margin-top: 50px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">PLU</th>
            <th rowspan="2">NAMA BARANG</th>
            <th colspan="2">KEMASAN</th>
            <th colspan="2">KWANTUM</th>
            <th rowspan="2">HARGA<br>SATUAN</th>
            <th rowspan="2">TOTAL</th>
            <th rowspan="2">KETERANGAN</th>
        </tr>
        <tr>
            <th>UNIT</th>
            <th>FRAC</th>
            <th>CTN</th>
            <th>PCs</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $i=1;
        @endphp

        @if(sizeof($data1)!=0)
            @foreach($data1 as $d)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $d->mstd_prdcd }}</td>
                    <td>{{ $d->prd_deskripsipanjang}}</td>
                    <td>{{ $d->mstd_unit }}</td>
                    <td class="right">{{ $d->mstd_frac }}</td>
                    <td class="right">{{ $d->ctn }}</td>
                    <td class="right">{{ $d->pcs }}</td>
                    <td class="right">{{ number_format(round($d->mstd_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
                    <td>{{ $d->mstd_keterangan }}</td>
                </tr>
                @php
                    $i++;
                    $total += $d->total;
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
            <td colspan="7"></td>
            <td style="font-weight: bold">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format(round($total), 0, '.', ',') }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="10">
                <table class="table" border="1">
                    <thead>
                    </thead>
                    <tbody>
                    <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
                        <td class="left" colspan="3">&nbsp; DIBUAT <br><br><br></td>
                        <td class="left" colspan="3">&nbsp; DIPERIKSA :</td>
                        <td class="left" colspan="4">&nbsp; MENYETUJUI :</td>
                        <td class="left" colspan="4">&nbsp; PELAKSANA :</td>
                    </tr>
                    <tr>
                        <td class="left" colspan="3">&nbsp; ADMINISTRASI</td>
                        <td class="left" colspan="3">&nbsp; KEPALA GUDANG</td>
                        <td class="left" colspan="4">&nbsp; STORE MANAGER</td>
                        <td class="left" colspan="4">&nbsp; STOCK CLERK / PETUGAS GUDANG</td>
                    </tr>
                    </tbody>
                </table>
            </td>
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
