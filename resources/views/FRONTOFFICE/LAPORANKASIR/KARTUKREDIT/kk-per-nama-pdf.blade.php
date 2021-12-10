<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Kartu Kredit per Nama {{ $tgl1 }} - {{ $tgl2 }}</title>
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
            {{ $perusahaan->prs_namacabang }}<br><br>

        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ Session::get('usid') }}<br><br>
            Hal. :<br><br>
            PRG : LAP203
    </div>
    <h2 style="text-align: center">
        ** LAPORAN TRANSAKSI KARTU KREDIT PER NAMA KARTU **<br>
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
            <th class="left">Mesin</th>
            <th class="left">Kartu Kredit</th>
            <th class="left">Nomor Kartu</th>
            <th class="left">No. Trn</th>
            <th class="center">Kasir</th>
            <th class="center">Member</th>
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

            $nilaiKartu = 0;
            $feeKartu = 0;
            $totalKartu = 0;

            $nilaiMesin = 0;
            $feeMesin = 0;
            $totalMesin = 0;

            $nilaiTgl = 0;
            $feeTgl = 0;
            $totalTgl = 0;

            $kartu = '';
            $mesin = '';
            $tgl = '';

            $fKartu = '';
            $fMesin = '';
            $fTgl = '';
        @endphp
        @foreach($data as $d)
            @if($kartu != $d->nmcard && $kartu != '')
                <tr class="bold">
                    <td colspan="2"></td>
                    <td class="left" colspan="5">TOTAL {{ $kartu }}</td>
                    <td class="right">{{ number_format($nilaiKartu, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($feeKartu, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($totalKartu, 0, '.', ',') }}</td>
                </tr>
                @php
                    $kartu = $d->nmcard;
                    $fKartu = true;
                    $nilaiKartu = 0;
                    $feeKartu = 0;
                    $totalKartu = 0;
                @endphp
            @endif
            @if($mesin != $d->mesin && $mesin != '')
                @if($fKartu != true)
                    <tr class="bold">
                        <td colspan="2"></td>
                        <td class="left" colspan="5">TOTAL {{ $kartu }}</td>
                        <td class="right">{{ number_format($nilaiKartu, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($feeKartu, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($totalKartu, 0, '.', ',') }}</td>
                    </tr>
                    @php
                        $kartu = $d->nmcard;
                        $fKartu = true;
                        $nilaiKartu = 0;
                        $feeKartu = 0;
                        $totalKartu = 0;
                    @endphp
                @endif

                <tr class="bold">
                    <td></td>
                    <td class="left" colspan="6">TOTAL MESIN {{ $mesin }}</td>
                    <td class="right">{{ number_format($nilaiMesin, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($feeMesin, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($totalMesin, 0, '.', ',') }}</td>
                </tr>
                @php
                    isset($arrNilai[$mesin]) ? $arrNilai[$mesin] += $nilaiMesin : $arrNilai[$mesin] = $nilaiMesin;
                    isset($arrFee[$mesin]) ? $arrFee[$mesin] += $feeMesin : $arrFee[$mesin] = $feeMesin;
                    isset($arrTotal[$mesin]) ? $arrTotal[$mesin] += $totalMesin : $arrTotal[$mesin] = $totalMesin;

                    $mesin = $d->mesin;
                    $fMesin = true;

                    $nilaiMesin = 0;
                    $feeMesin = 0;
                    $totalMesin = 0;
                @endphp
            @endif
            @if($tgl != $d->tglt && $tgl != '')
                @if($fKartu != true)
                    <tr class="bold">
                        <td colspan="2"></td>
                        <td class="left" colspan="5">TOTAL {{ $kartu }}</td>
                        <td class="right">{{ number_format($nilaiKartu, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($feeKartu, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($totalKartu, 0, '.', ',') }}</td>
                    </tr>
                    @php
                        $kartu = $d->nmcard;
                        $fKartu = true;
                        $nilaiKartu = 0;
                        $feeKartu = 0;
                        $totalKartu = 0;
                    @endphp
                @endif

                @if($fMesin != true){
                    <tr class="bold">
                        <td></td>
                        <td class="left" colspan="6">TOTAL MESIN {{ $mesin }}</td>
                        <td class="right">{{ number_format($nilaiMesin, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($feeMesin, 0, '.', ',') }}</td>
                        <td class="right">{{ number_format($totalMesin, 0, '.', ',') }}</td>
                    </tr>
                    @php
                        isset($arrNilai[$mesin]) ? $arrNilai[$mesin] += $nilaiMesin : $arrNilai[$mesin] = $nilaiMesin;
                        isset($arrFee[$mesin]) ? $arrFee[$mesin] += $feeMesin : $arrFee[$mesin] = $feeMesin;
                        isset($arrTotal[$mesin]) ? $arrTotal[$mesin] += $totalMesin : $arrTotal[$mesin] = $totalMesin;

                        $mesin = $d->mesin;
                        $fMesin = true;

                        $nilaiMesin = 0;
                        $feeMesin = 0;
                        $totalMesin = 0;
                    @endphp
                @endif

                <tr class="bold">
                    <td class="left" colspan="7">TOTAL {{ $tgl }}</td>
                    <td class="right">{{ number_format($nilaiTgl, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($feeTgl, 0, '.', ',') }}</td>
                    <td class="right">{{ number_format($totalTgl, 0, '.', ',') }}</td>
                </tr>
                @php
                    $tgl = $d->tglt;
                    $fTgl = true;
                    $nilaiTgl = 0;
                    $feeTgl = 0;
                    $totalTgl = 0;
                @endphp
            @endif

            @php
                $nilai += $d->ccamt;
                $fee += $d->ccadmfee;
                $total += $d->ccamt + $d->ccadmfee;

                $nilaiKartu += $d->ccamt;
                $feeKartu += $d->ccadmfee;
                $totalKartu += $d->ccamt + $d->ccadmfee;

                $nilaiMesin += $d->ccamt;
                $feeMesin += $d->ccadmfee;
                $totalMesin += $d->ccamt + $d->ccadmfee;

                $nilaiTgl += $d->ccamt;
                $feeTgl += $d->ccadmfee;
                $totalTgl += $d->ccamt + $d->ccadmfee;
            @endphp
            <tr>
                <td class="left">@if($fTgl || $tgl == '') {{ $d->tglt }} @php $fTgl = false @endphp @endif</td>
                <td class="left">@if($fMesin || $mesin == '') {{ $d->mesin }} @php $fMesin = false @endphp @endif</td>
                <td class="left">@if($fKartu || $kartu == '') {{ $d->nmcard }} @php $fKartu = false @endphp @endif</td>
                <td class="left">{{ $d->ccno }}</td>
                <td class="left">{{ $d->jh_transactionno }}</td>
                <td class="left">{{ $d->kasir }}</td>
                <td class="center">{{ $d->memb }}</td>
                <td class="right">{{ number_format($d->ccamt, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->ccadmfee, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->ccamt + $d->ccadmfee, 0, '.', ',') }}</td>
            </tr>
            @php
                $kartu = $d->nmcard;
                $mesin = $d->mesin;
                $tgl = $d->tglt;
            @endphp
        @endforeach
        <tr class="bold">
            <td colspan="2"></td>
            <td class="left" colspan="5">TOTAL {{ $kartu }}</td>
            <td class="right">{{ number_format($nilaiKartu, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($feeKartu, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($totalKartu, 0, '.', ',') }}</td>
        </tr>
        <tr class="bold">
            <td></td>
            <td class="left" colspan="6">TOTAL MESIN {{ $mesin }}</td>
            <td class="right">{{ number_format($nilaiMesin, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($feeMesin, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($totalMesin, 0, '.', ',') }}</td>
        </tr>
        <tr class="bold">
            <td class="left" colspan="7">TOTAL {{ $tgl }}</td>
            <td class="right">{{ number_format($nilaiTgl, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($feeTgl, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($totalTgl, 0, '.', ',') }}</td>
        </tr>
        </tbody>
        <tfoot>
        <tr class="bold">
            <td class="left" colspan="7">** TOTAL AKHIR</td>
            <td class="right">{{ number_format($nilai, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($fee, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total, 0, '.', ',') }}</td>
        </tr>
        @php
            isset($arrNilai[$mesin]) ? $arrNilai[$mesin] += $nilaiMesin : $arrNilai[$mesin] = $nilaiMesin;
            isset($arrFee[$mesin]) ? $arrFee[$mesin] += $feeMesin : $arrFee[$mesin] = $feeMesin;
            isset($arrTotal[$mesin]) ? $arrTotal[$mesin] += $totalMesin : $arrTotal[$mesin] = $totalMesin;

            ksort($arrNilai);
            ksort($arrFee);
            ksort($arrTotal);
        @endphp

        @foreach($arrNilai as $key => $data)
            <tr class="bold">
                <td class="left" colspan="7">TOTAL MESIN {{ $key }}</td>
                <td class="right">{{ number_format($arrNilai[$key], 0, '.', ',') }}</td>
                <td class="right">{{ number_format($arrFee[$key], 0, '.', ',') }}</td>
                <td class="right">{{ number_format($arrTotal[$key], 0, '.', ',') }}</td>
            </tr>
        @endforeach
        <tr class="bold">
            <td style="border-top: 1px solid black" colspan="10" class="right">** Akhir dari laporan **</td>
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
</style>
</html>
