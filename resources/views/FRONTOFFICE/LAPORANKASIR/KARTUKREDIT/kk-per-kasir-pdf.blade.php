<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Kartu Kredit per Kasir {{ $tgl1 }} - {{ $tgl2 }}</title>
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
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ $_SESSION['usid'] }}<br><br>
            Hal. :<br><br>
            PRG : LAP617
    </div>
    <h2 style="text-align: center">
        ** LAPORAN TRANSAKSI KARTU KREDIT PER KASIR **<br>
        Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
    </h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left">Tanggal</th>
            <th class="left">Kasir</th>
            <th class="left">No. Trn</th>
            <th class="left">Mesin</th>
            <th class="left">No. Kartu Kredit</th>
            <th class="left">Nama Kartu</th>
            <th class="right">Nilai</th>
            <th class="right">Biaya Adm</th>
            <th class="right">Total</th>
        </tr>
        </thead>
        <tbody>
        @php
            $nilai = 0;
            $fee = 0;
            $total = 0;

            $arrNilai = [];
            $arrFee = [];
            $arrTotal = [];

            $fTgl = true;
            $fKasir = true;

            $tgl = '';
            $kasir = '';
        @endphp
        @foreach($data as $d)
            @php
                $nilai += $d->nilai;
                $fee += $d->admfee;
                $total += $d->nilai + $d->admfee;

                isset($arrNilai[$d->mesin]) ? $arrNilai[$d->mesin] += $d->nilai : $arrNilai[$d->mesin] = $d->nilai;
                isset($arrFee[$d->mesin]) ? $arrFee[$d->mesin] += $d->admfee : $arrFee[$d->mesin] = $d->admfee;
                isset($arrTotal[$d->mesin]) ? $arrTotal[$d->mesin] += $d->nilai + $d->admfee : $arrTotal[$d->mesin] = $d->nilai + $d->admfee;

                if($tgl != $d->tanggal){
                    $tgl = $d->tanggal;
                    $fTgl = true;
                }
                if($kasir != $d->kasir){
                    $kasir = $d->kasir;
                    $fKasir = true;
                }
            @endphp
            <tr>
                <td class="left">@if($fTgl || $tgl == '') {{ $d->tanggal }} @php $fTgl = false @endphp @endif</td>
                <td class="left">@if($fKasir || $kasir == '') {{ $d->kasir }} @php $fKasir = false @endphp @endif</td>
                <td class="left">{{ $d->jh_transactionno }}</td>
                <td class="left">{{ $d->mesin }}</td>
                <td class="left">{{ $d->nokartu }}</td>
                <td class="left">{{ $d->kt_cardname }}</td>
                <td class="right">{{ number_format($d->nilai, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->admfee, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->nilai + $d->admfee, 0, '.', ',') }}</td>
            </tr>
            @php
                $kartu = $d->kt_cardname;
                $mesin = $d->mesin;
                $tgl = $d->tanggal;
            @endphp
        @endforeach
        @php
            ksort($arrNilai);
            ksort($arrFee);
            ksort($arrTotal);
        @endphp
        <tfoot>
            <tr class="bold">
                <td class="top-bottom left" colspan="6">** GRAND TOTAL</td>
                <td class="top-bottom right">{{ number_format($nilai, 0, '.', ',') }}</td>
                <td class="top-bottom right">{{ number_format($fee, 0, '.', ',') }}</td>
                <td class="top-bottom right">{{ number_format($total, 0, '.', ',') }}</td>
            </tr>
        @foreach($arrNilai as $key => $data)
            <tr class="bold">
                <td class="left" colspan="6">TOTAL MESIN {{ $key }}</td>
                <td class="right">{{ number_format($arrNilai[$key], 0, '.', ',') }}</td>
                <td class="right">{{ number_format($arrFee[$key], 0, '.', ',') }}</td>
                <td class="right">{{ number_format($arrTotal[$key], 0, '.', ',') }}</td>
            </tr>
        @endforeach
        <tr class="bold">
            <td style="border-top: 1px solid black" colspan="9" class="right">** Akhir dari laporan **</td>
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
        size: 595pt 842pt;
        /*size: 842pt 638pt;*/
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
    }
    body {
        margin-top: 90px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.25;
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

    .keterangan{
        text-align: left;
    }
    .table{
        width: 100%;
        font-size: 11px;
        white-space: nowrap;
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

    .right{
        text-align: right;
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

    .tengah{
        vertical-align: middle !important;
    }
    .blank-row
    {
        line-height: 70px!important;
        color: white;
    }

    .bold td{
        font-weight: bold;
    }

    .top-bottom{
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }
</style>
</html>
