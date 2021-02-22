<!DOCTYPE html>
<html>
<head>
    <title>Register Repacking</title>
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
            Hal. :
    </div>
    <h2 style="text-align: center">** REGISTER REPACKING **<br>{{ $tgl1 }} - {{ $tgl2 }}</h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">NO</th>
            <th colspan="2">---- REPACKING ----</th>
            <th colspan="2">---- ITEM ----</th>
            <th class="tengah right" rowspan="2">GROSS</th>
            <th class="tengah right" rowspan="2">PPN</th>
            <th class="tengah right" rowspan="2">PPN-BM</th>
            <th class="tengah right" rowspan="2">BOTOL</th>
            <th class="tengah right" rowspan="2">TOTAL NILAI</th>
            <th class="tengah" rowspan="2">STATUS</th>
        </tr>
        <tr>
            <th>NOMOR</th>
            <th>TANGGAL</th>
            <th>PREPACK</th>
            <th>REPACK</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 1;
            $temp = '';
            $gross = 0;
            $ppn = 0;
            $ppnbm = 0;
            $botol = 0;
            $total = 0;
        @endphp
        @foreach($data as $d)
            @if($temp != $d->msth_tgldoc)
                @if($temp != '')
                    <tr>
                        <td class="border-top left" colspan="5">SUBTOTAL TANGGAL {{ $d->msth_tgldoc }}</td>
                        <td class="border-top right">{{ number_format($subgross, 2, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format($subppn, 2, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format($subppnbm, 2, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format($subbotol, 2, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format($subtotal, 2, '.', ',') }}</td>
                        <td class="border-top" colspan="2"></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->msth_tgldoc;
                    $subgross = 0;
                    $subppn = 0;
                    $subppnbm = 0;
                    $subbotol = 0;
                    $subtotal = 0;
                @endphp
                <tr>
                    <td class="left" colspan="11">TANGGAL {{ $d->msth_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc}}</td>
                <td class="tengah">{{ $d->prepack }}</td>
                <td class="tengah">{{ $d->repack }}</td>
                <td class="right">{{ number_format($d->gross, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($d->ppn, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($d->ppnbm, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($d->botol, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($d->total, 2, '.', ',') }}</td>
                <td class="tengahtengah ">{{ $d->status }}</td>
            </tr>
            @php
                $i++;
                $subgross += $d->gross;
                $subppn += $d->ppn;
                $subppnbm += $d->ppnbm;
                $subbotol += $d->botol;
                $subtotal += $d->total;

                $gross += $d->gross;
                $ppn += $d->ppn;
                $ppnbm += $d->ppnbm;
                $botol += $d->botol;
                $total += $d->total;
            @endphp
        @endforeach
        <tr>
            <td class="border-top left" colspan="5">SUBTOTAL TANGGAL {{ $d->msth_tgldoc }}</td>
            <td class="border-top right">{{ number_format($subgross, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($subppn, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($subppnbm, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($subbotol, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($subtotal, 2, '.', ',') }}</td>
            <td class="border-top"></td>
        </tr>
        <tr>
            <td class="border-top left" colspan="5">TOTAL SELURUHNYA</td>
            <td class="border-top right">{{ number_format($gross, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($ppn, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($ppnbm, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($botol, 2, '.', ',') }}</td>
            <td class="border-top right">{{ number_format($total, 2, '.', ',') }}</td>
            <td class="border-top"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="13" class="right">** Akhir dari laporan **</td>
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
        size: 595pt 442pt;
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
        font-size: 7px;
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table-ttd{
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

    .border-top{
        border-top: 1px solid black;
    }

</style>
</html>
