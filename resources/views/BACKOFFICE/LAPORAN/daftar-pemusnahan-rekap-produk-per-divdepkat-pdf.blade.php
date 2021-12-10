<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pemusnahan Rekap Produk Per Divisi / Departemen / Kategori</title>
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
    <h2 style="text-align: center">** DAFTAR PEMUSNAHAN BARANG **<br>REKAP PRODUK PER DIVISI / DEPARTEMEN / KATEGORI</h2>
</header>

<footer>

</footer>

<main>
    @php
        $tempdiv = '';
        $tempdep = '';
        $tempkat = '';
        $totaldiv = 0;
        $totaldep = 0;
        $totalkat = 0;
        $total = 0;
        $skipdep = false;

        $st_div_tn = 0;
        $st_dep_tn = 0;
        $st_kat_tn = 0;

        $sum_total=0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" style="vertical-align: middle;" width="10%">PLU</th>
            <th rowspan="2" style="vertical-align: middle;" width="20%">NAMA BARANG</th>
            <th rowspan="2" style="vertical-align: middle;" width="10%">KEMASAN</th>
            <th rowspan="2" class="right" width="10%">HARGA SATUAN</th>
            <th colspan="2" style="vertical-align: middle;" width="10%">-- KUANTUM --</th>
            <th rowspan="2" class="right" width="10%">TOTAL NILAI</th>
            <th rowspan="2" class="right" width="10%">KETERANGAN</th>
        </tr>
        <tr>
            <th class="right" width="10%">CTN</th>
            <th class="right" width="10%">PCS</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->mstd_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="7"><b>{{$data[$i]->mstd_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif;
            @if($tempdep != $data[$i]->mstd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="7"><b>{{$data[$i]->mstd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif;
            @if($tempkat != $data[$i]->mstd_kodekategoribrg)
                <tr>
                    <td class="left"><b>KATEGORI</b></td>
                    <td class="left" colspan="7"><b>{{$data[$i]->mstd_kodekategoribrg}} - {{$data[$i]->kat_namakategori}}</b>
                    </td>
                </tr>
            @endif;
            <tr>
                <td class="left">{{ $data[$i]->plu }}</td>
                <td class="left">{{ $data[$i]->barang }}</td>
                <td class="left">{{ $data[$i]->kemasan }}</td>
                <td class="right">{{ number_format($data[$i]->hrg_satuan,2) }}</td>
                <td class="right">{{ number_format($data[$i]->qty,2) }}</td>
                <td class="right">{{ number_format($data[$i]->qtyk,2) }}</td>
                <td class="right">{{ number_format($data[$i]->total,2) }}</td>
                <td class="left">{{ $data[$i]->keterangan }}</td>
            </tr>
            @php
                $st_kat_tn += $data[$i]->total;
                $st_dep_tn += $data[$i]->total;
                $st_div_tn += $data[$i]->total;

                $sum_total += $data[$i]->total;

                $tempdiv = $data[$i]->mstd_kodedivisi;
                $tempdep = $data[$i]->mstd_kodedepartement;
            @endphp
            @if( isset($data[$i+1]->mstd_kodekategoribrg) && $tempdep != $data[$i+1]->mstd_kodekategoribrg || !(isset($data[$i+1]->mstd_kodekategoribrg)) )
                <tr style="border-bottom: 1px solid black;font-style: italic">
                    <td class="left">SUB TOTAL KAT</td>
                    <td colspan="5" class="left">{{ $data[$i]->mstd_kodekategoribrg }} - {{$data[$i]->kat_namakategori}}</td>
                    <td class="right">{{ number_format($st_kat_tn,2) }}</td>
                    <td class="right"></td>
                </tr>
                @php
                    $st_kat_tn = 0;
                @endphp
            @endif
            @if( isset($data[$i+1]->mstd_kodedepartement) && $tempdep != $data[$i+1]->mstd_kodedepartement || !(isset($data[$i+1]->mstd_kodedepartement)) )
                <tr style="border-bottom: 1px solid black;font-style: italic">
                    <td class="left">SUB TOTAL DEPT</td>
                    <td colspan="5" class="left">{{ $data[$i]->mstd_kodedepartement }} - {{$data[$i]->dep_namadepartement}}</td>
                    <td class="right">{{ number_format($st_dep_tn,2) }}</td>
                    <td class="right"></td>
                </tr>
                @php
                    $st_dep_tn = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->mstd_kodedivisi) && $tempdiv != $data[$i+1]->mstd_kodedivisi) || !(isset($data[$i+1]->mstd_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;font-style: italic">
                    <td class="left">SUB TOTAL DIVISI</td>
                    <td colspan="5" class="left">{{ $data[$i]->mstd_kodedivisi }} - {{ $data[$i]->div_namadivisi }}</td>
                    <td class="right">{{ number_format($st_div_tn,2) }}</td>
                    <td class="right"></td>
                </tr>
                @php
                    $skipdiv = false;
                    $st_div_tn = 0;
                @endphp
            @endif
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="6"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="right">{{ number_format($sum_total ,2) }}</td>
            <td class="right"></td>
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
        size: 830pt 842pt;
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
        padding: 3px !important;
    }

    .right {
        text-align: right;
        padding: 3px !important;
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
