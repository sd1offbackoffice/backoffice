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
            {{ $perusahaan->prs_namacabang }}<br><br><br><br>
            <strong>Tanggal : {{ $tgl1 }} - {{ $tgl2 }}</strong><br><br>
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ Session::get('usid') }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">** DAFTAR PENYESUAIAN PERSEDIAAN **<br>RINGKASAN DIVISI / DEPARTEMEN / KATEGORI</h2>
</header>

<footer>

</footer>

<main>
    {{--<table class="table table-borderless table-header">--}}
    {{--<thead>--}}
    {{--<tr>--}}
    {{--<th>--}}
    {{--Tanggal--}}
    {{--</th>--}}
    {{--<th>--}}
    {{--: {{ $tgl1 }} s/d {{ $tgl2 }}--}}
    {{--</th>--}}
    {{--<th width="50%"></th>--}}
    {{--<th>RINGKASAN DIVISI / DEPARTEMEN / KATEGORI</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--</table>--}}
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" width="10%">KODE</th>
            <th class="left" width="70%">NAMA KATEGORI</th>
            <th class="right" width="20%">TOTAL NILAI</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempdiv = '';
            $tempdep = '';
            $tempkat = '';
            $totaldiv = 0;
            $totaldep = 0;
            $totalkat = 0;
            $total = 0;
            $skipdep = false;
        @endphp
        @for($i=0;$i<count($data);$i++)
            @php
                $d = $data[$i];
                $total += $d->total;
                $skipdep = false;
            @endphp
            @if($tempdiv != $d->prd_kodedivisi)
                @if($tempdiv != '')
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
                    </tr>
                    @php $totaldep = 0; $skipdep = true;@endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
                    </tr>
                    @php $totaldiv = 0; @endphp
                @endif
                @php $tempdiv = $d->prd_kodedivisi @endphp
                <tr>
                    <td class="left"><strong>DIVISI</strong></td>
                    <td class="left"><strong>: {{ $d->prd_kodedivisi }} - {{ $d->div_namadivisi }}</strong></td>
                    <td></td>
                </tr>
            @endif
            @php $totaldiv += $d->total @endphp
            @if($tempdep != $d->prd_kodedepartement)
                @if($tempdep != '' && !$skipdep)
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
                    </tr>
                    @php $totaldep = 0; @endphp
                @endif
                @php $tempdep = $d->prd_kodedepartement @endphp
                <tr>
                    <td class="left"><strong>DEPARTEMEN</strong></td>
                    <td class="left"><strong>: {{ $d->prd_kodedepartement }} - {{ $d->dep_namadepartement }}</strong>
                    </td>
                    <td></td>
                </tr>
            @endif
            @php $totaldep += $d->total @endphp
            <tr>
                <td class="left">{{ $d->prd_kodekategoribarang }}</td>
                <td class="left">{{ $d->kat_namakategori }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
            </tr>
        @endfor
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
            <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
            <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
        </tr>
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="right"><strong>{{ number_format($total,2) }}</strong></td>
        </tr>
        </tfoot>
    </table>
    <hr>
    <p class="right"><strong>** AKHIR DARI LAPORAN **</strong></p>
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

    table {
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
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }

    .table-ttd {
        width: 15%;
    }

    .table tbody td {
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

    .table-header td {
        white-space: nowrap;
    }

    .tengah {
        vertical-align: middle !important;
    }
</style>
</html>
