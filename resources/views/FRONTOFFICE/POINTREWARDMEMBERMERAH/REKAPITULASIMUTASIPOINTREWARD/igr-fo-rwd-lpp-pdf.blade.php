<!DOCTYPE html>
<html>

<head>
    <title>Rincian Penggunaan Reward MyPoin</title>
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
            <b>{{ $perusahaan->prs_namaperusahaan }}</b><br>
            {{ $perusahaan->prs_namacabang }}<br><br><br>
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>
            TGL : {{ e(date("d-m-Y")) }}<br>
            JAM : {{ $datetime->format('H:i:s') }}
        </p>
    </div>
    <div style="text-align: center;margin-bottom: 0;padding-bottom: 0">
    <h2 >REKAPITULASI MUTASI POINT REWARD <br>Tgl : {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0
,10)}} </h2>
    </div>

</header>

<main style="margin-top: 50px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="5"></th>
            <th colspan="2">---- Pemakaian ----</th>
            <th colspan="2"></th>
        </tr>
        <tr>
            <th>MEMBER MERAH</th>
            <th>ID. MEMBER</th>
            <th>Saldo Awal</th>
            <th>Perolehan Hadiah Struk Trn</th>
            <th>Transfer Dari Kode Member Lama</th>
            <th>Pembayaran Dengan Point</th>
            <th>Produk Redeem Point</th>
            <th>Transfer Dari Kode Member Baru</th>
            <th>Saldo Akhir</th>
        </tr>
        </thead>
        <tbody>
        @php
            $sub_tkr = 0;
            $sub_rdm= 0;
            $sub_tot_tkr = 0;
            $total_tkr = 0;
            $total_rdm= 0;
            $total_tot_tkr = 0;
            $temptgl = '';
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<count($data);$i++)
                <tr>
                    <td>{{ $data[$i]->cus_namamember }}</td>
                    <td>{{ $data[$i]->kdmbr }}</td>
                    <td>{{ $data[$i]->saldo_awal_bulan }}</td>
                    <td>{{ $data[$i]->perolehanpoint}}</td>
                    <td>{{ $data[$i]->trf_kodelama }}</td>
                    <td>{{ $data[$i]->penukaranpoint }}</td>
                    <td>{{ $data[$i]->redeempoint }}</td>
                    <td>{{ $data[$i]->trf_kodebaru }}</td>
                    <td>{{ $data[$i]->saldo_akhir_bulan }}</td>
                </tr>
            @endfor
        @else
            <tr>
                <td colspan="6">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        </tfoot>
    </table>
</main>

<br>
</body>


<style>
    @page {
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
