<!DOCTYPE html>
<html>
<head>
    <title>Register Memo Penyesuaian Persediaan</title>
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
    <h2 style="text-align: center">** REGISTER MEMO PENYESUAIAN PERSEDIAAN **<br>{{ $tgl1 }} - {{ $tgl2 }}</h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">NO</th>
            <th colspan="2">---- MPP ----</th>
            <th colspan="2">---- REF ----</th>
            <th class="tengah" rowspan="2">TOTAL</th>
            <th class="tengah" rowspan="2">STATUS</th>
            <th class="tengah" rowspan="2">KETERANGAN</th>
            <th class="tengah" rowspan="2">STATUS BARANG</th>
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
            $totalbaik = 0;
            $totalretur = 0;
            $totalrusak = 0;
            $totalall = 0;
        @endphp
        @foreach($data as $d)
            @if($temp != $d->msth_tgldoc)
                @if($temp != '')
                    <tr>
                        <td class="left" colspan="5">SUBTOTAL BARANG BAIK TANGGAL {{ $temp }}</td>
                        <td class="right">{{ number_format($subtotalbaik, 2, '.', ',') }}</td>
                        <td class=""></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="5">SUBTOTAL BARANG RETUR TANGGAL {{ $temp }}</td>
                        <td class="right">{{ number_format($subtotalretur, 2, '.', ',') }}</td>
                        <td class=""></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="5">SUBTOTAL BARANG RUSAK TANGGAL {{ $temp }}</td>
                        <td class="right">{{ number_format($subtotalrusak, 2, '.', ',') }}</td>
                        <td class=""></td>
                    </tr>
                @endif
                @php
                    $i = 1;
                    $temp = $d->msth_tgldoc;
                    $subtotalbaik = 0;
                    $subtotalretur = 0;
                    $subtotalrusak = 0;
                @endphp
                <tr>
                    <td class="left border-top" colspan="11">TANGGAL {{ $d->msth_tgldoc }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc}}</td>
                <td class="tengah">{{ $d->msth_noref3}}</td>
                <td class="tengah">{{ $d->msth_tgref3 }}</td>
                <td class="right">{{ number_format($d->total, 2, '.', ',') }}</td>
                <td class="tengah">{{ $d->status }}</td>
                <td class="tengah">{{ $d->keterangan }}</td>
                <td class="tengah">{{ $d->sbrg }}</td>
            </tr>
            @php
                $i++;

                if($d->sbrg == 'BAIK'){
                    $subtotalbaik += $d->total;
                    $totalbaik += $d->total;
                }
                else if($d->sbrg == 'RETUR'){
                    $subtotalretur += $d->total;
                    $totalretur += $d->total;
                }
                else{
                    $subtotalrusak += $d->total;
                    $totalrusak += $d->total;
                }

                $totalall += $d->total;
            @endphp
        @endforeach
        <tr>
            <td class="left" colspan="5">SUBTOTAL BARANG BAIK TANGGAL {{ $temp }}</td>
            <td class="right">{{ number_format($subtotalbaik, 2, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="5">SUBTOTAL BARANG RETUR TANGGAL {{ $temp }}</td>
            <td class="right">{{ number_format($subtotalretur, 2, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="left" colspan="5">SUBTOTAL BARANG RUSAK TANGGAL {{ $temp }}</td>
            <td class="right">{{ number_format($subtotalrusak, 2, '.', ',') }}</td>
            <td class=""></td>
        </tr>
        <tr>
            <td class="border-top left" colspan="5">TOTAL SELURUHNYA</td>
            <td class="border-top right">{{ number_format($totalall, 2, '.', ',') }}</td>
            <td class="border-top" colspan="3"></td>
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
