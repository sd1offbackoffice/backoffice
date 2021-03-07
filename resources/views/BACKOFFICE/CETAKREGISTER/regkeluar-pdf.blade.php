<!DOCTYPE html>
<html>
<head>
    <title>Register Nota Pengeluaran Barang</title>
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
    <h2 style="text-align: center">** REGISTER NOTA PENGELUARAN BARANG **<br>{{ $tgl1 }} - {{ $tgl2 }}</h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">NO</th>
            <th colspan="2">---- BPB ----</th>
            <th colspan="2">---- NOTA RETUR ----</th>
            <th class="tengah" rowspan="2">------- SUPPLIER -------</th>
            <th class="tengah" rowspan="2">GROSS</th>
            <th class="tengah" rowspan="2">POTONGAN</th>
            <th class="tengah" rowspan="2">PPN</th>
            <th class="tengah" rowspan="2">PPN-BM</th>
            <th class="tengah" rowspan="2">BOTOL</th>
            <th class="tengah" rowspan="2">TOTAL</th>
            <th class="tengah" rowspan="2">STATUS</th>
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
            $subgross = 0;
            $subdiscount = 0;
            $submstd_ppnrph = 0;
            $submstd_ppnbmrph = 0;
            $submstd_ppnbtlrph = 0;
            $subtotal = 0;
        @endphp
        @foreach($data as $d)
            @if($temp != $d->msth_tgldoc)
                @if($temp != '')
                    <tr>
                        <td class="border-top left" colspan="6">SUBTOTAL TANGGAL {{ $d->msth_tgldoc }}</td>
                        <td class="border-top right">{{ number_format(round($subgross), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($subdiscount), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($submstd_ppnrph), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($submstd_ppnbmrph), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($submstd_ppnbtlrph), 0, '.', ',') }}</td>
                        <td class="border-top right">{{ number_format(round($subtotal), 0, '.', ',') }}</td>
                        <td class="border-top"></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->msth_tgldoc;
                    $subgross = 0;
                    $subdiscount = 0;
                    $submstd_ppnrph = 0;
                    $submstd_ppnbmrph = 0;
                    $submstd_ppnbtlrph = 0;
                    $subtotal = 0;
                @endphp
                <tr>
                    <td class="left" colspan="13">TANGGAL {{ $d->msth_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc}}</td>
                <td>{{ $d->msth_nofaktur }}</td>
                <td>{{ $d->msth_tglfaktur }}</td>
                <td class="left">{{ $d->supplier }}</td>
                <td class="right">{{ number_format(round($d->gross), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->discount), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->mstd_ppnrph), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->mstd_ppnbmrph), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->mstd_ppnbtlrph), 0, '.', ',') }}</td>
                <td class="right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
                <td>{{ $d->status }}</td>
            </tr>
            @php
                $i++;
                $subgross += $d->gross;
                $subdiscount += $d->discount;
                $submstd_ppnrph += $d->mstd_ppnrph;
                $submstd_ppnbmrph += $d->mstd_ppnbmrph;
                $submstd_ppnbtlrph += $d->mstd_ppnbtlrph;
                $subtotal += $d->total;
            @endphp
        @endforeach
        <tr>
            <td class="border-top left" colspan="6">SUBTOTAL TANGGAL {{ $temp }}</td>
            <td class="border-top right">{{ number_format(round($subgross), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($subdiscount), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($submstd_ppnrph), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($submstd_ppnbmrph), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($submstd_ppnbtlrph), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($subtotal), 0, '.', ',') }}</td>
            <td class="border-top"></td>
        </tr>
        <tr>
            <td class="border-top left" colspan="6">TOTAL SUPPLIER PKP</td>
            <td class="border-top right">{{ number_format(round($pkp->gross), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($pkp->potongan), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($pkp->ppn), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($pkp->ppnbm), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($pkp->botol), 0, '.', ',') }}</td>
            <td class="border-top right">{{ number_format(round($pkp->total), 0, '.', ',') }}</td>
            <td class="border-top"></td>
        </tr>
        <tr>
            <td class="left" colspan="6">TOTAL SUPPLIER NON PKP</td>
            <td class="right">{{ number_format(round($npkp->gross), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($npkp->potongan), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($npkp->ppn), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($npkp->ppnbm), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($npkp->botol), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($npkp->total), 0, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="6">TOTAL PENERIMAAN PEMBELIAN</td>
            <td class="right">{{ number_format(round($pembelian->gross), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pembelian->potongan), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pembelian->ppn), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pembelian->ppnbm), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pembelian->botol), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($pembelian->total), 0, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="6">TOTAL PENERIMAAN LAIN-LAIN</td>
            <td class="right">{{ number_format(round($lain->gross), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($lain->potongan), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($lain->ppn), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($lain->ppnbm), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($lain->botol), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($lain->total), 0, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="6">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format(round($total->gross), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($total->potongan), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($total->ppn), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($total->ppnbm), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($total->botol), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($total->total), 0, '.', ',') }}</td>
            <td class=""></td>
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
        @if($ukuran == 'kecil')
        size: 595pt 442pt;
        @else
        size: 595pt 842pt;
    @endif
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
