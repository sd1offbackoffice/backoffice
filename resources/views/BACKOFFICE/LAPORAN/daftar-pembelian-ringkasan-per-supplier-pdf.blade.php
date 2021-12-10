<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pembelian Ringkasan Per Supplier</title>
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
    <h2 style="text-align: center">** DAFTAR PEMBELIAN **<br>RINGKASAN PER SUPPLIER</h2>
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

        $st_div_gross = 0;
        $st_div_pot = 0;
        $st_div_disc = 0;
        $st_div_ppn = 0;
        $st_div_gross = 0;
        $st_div_bm = 0;
        $st_div_btl = 0;
        $st_div_tn = 0;

        $st_dep_gross = 0;
        $st_dep_pot = 0;
        $st_dep_disc = 0;
        $st_dep_ppn = 0;
        $st_dep_bm = 0;
        $st_dep_btl = 0;
        $st_dep_tn = 0;

        $sum_gross_bkp=0;
        $sum_gross_btkp=0;
        $sum_potongan_bkp=0;
        $sum_potongan_btkp=0;
        $sum_ppn_bkp=0;
        $sum_ppn_btkp=0;
        $sum_bm_bkp=0;
        $sum_bm_btkp=0;
        $sum_btl_bkp=0;
        $sum_btl_btkp=0;
        $sum_total_bkp=0;
        $sum_total_btkp=0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" width="10%">KODE</th>
            <th class="left" width="20%">NAMA SUPPLIER</th>
            <th class="right" width="10%">GROSS</th>
            <th class="right" width="10%">POTONGAN</th>
            <th class="right" width="10%">PPN</th>
            <th class="right" width="10%">BM</th>
            <th class="right" width="10%">BTL</th>
            <th class="right" width="10%">TOTAL NILAI</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            <tr>
                <td class="left">{{ $data[$i]->mstd_kodesupplier }}</td>
                <td class="left">{{ $data[$i]->sup_namasupplier }}</td>
                <td class="right">{{ number_format($data[$i]->gross,2) }}</td>
                <td class="right">{{ number_format($data[$i]->pot,2) }}</td>
                <td class="right">{{ number_format($data[$i]->ppn,2) }}</td>
                <td class="right">{{ number_format($data[$i]->bm,2) }}</td>
                <td class="right">{{ number_format($data[$i]->btl,2) }}</td>
                <td class="right">{{ number_format($data[$i]->total,2) }}</td>
            </tr>
            @php
                $sum_gross_bkp += $data[$i]->sum_gross_bkp;
                $sum_potongan_bkp += $data[$i]->sum_potongan_bkp;
                $sum_ppn_bkp += $data[$i]->sum_ppn_bkp;
                $sum_bm_bkp += $data[$i]->sum_bm_bkp;
                $sum_btl_bkp += $data[$i]->sum_btl_bkp;
                $sum_total_bkp += $data[$i]->sum_total_bkp;

                $sum_gross_btkp += $data[$i]->sum_gross_btkp;
                $sum_potongan_btkp += $data[$i]->sum_potongan_btkp;
                $sum_ppn_btkp += $data[$i]->sum_ppn_btkp;
                $sum_bm_btkp += $data[$i]->sum_bm_btkp;
                $sum_btl_btkp += $data[$i]->sum_btl_btkp;
                $sum_total_btkp += $data[$i]->sum_total_btkp;

            @endphp
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BKP</strong></td>
            <td class="right">{{ number_format($sum_gross_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_potongan_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_ppn_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_bm_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_btl_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_total_bkp ,2) }}</td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BTKP</strong></td>
            <td class="right">{{ number_format($sum_gross_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_potongan_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_ppn_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_bm_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_btl_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_total_btkp ,2) }}</td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_bm_bkp+$sum_bm_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_btl_bkp+$sum_btl_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</td>
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
        size: 710pt 842pt;
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
