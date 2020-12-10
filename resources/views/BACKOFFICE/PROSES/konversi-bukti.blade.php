<!DOCTYPE html>
<html>
<head>
    <title>Memo Penyesuaian Persediaan Konversi Perishable</title>
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
        <p>Tgl. Cetak : {{ date("d-m-Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ $_SESSION['usid'] }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">MEMO PENYESUAIAN PERSEDIAAN<br>KONVERSI PERISHABLE</h2>
    {{--<h2>KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR **<br>Periode : {{ $periode }}</h2>--}}
</header>

<footer>

</footer>

<main>
    @php $i=0; @endphp
    @foreach($datas as $data)
        @php $i++; @endphp
        <table class="table table-borderless table-header">
            <tr style="text-align: left">
                <td style="float:left">
                    Nomor &nbsp;&nbsp;&nbsp;&nbsp; : {{ $data[0]->msth_nodoc }}<br>
                    Tanggal &nbsp;&nbsp; : {{ $data[0]->msth_tgldoc }}
                </td>
                <td width="60%" style="font-size: 18px;text-align: right !important;float: right;@if($reprint != '1')color:white;@endif">RE-PRINT</td>
            </tr>
        </table>
        <table class="table">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th class="tengah" rowspan="2">NO</th>
                <th class="tengah" rowspan="2">PLU</th>
                <th class="tengah" rowspan="2">NAMA BARANG</th>
                <th class="tengah" rowspan="2">KEMASAN</th>
                <th colspan="2">KWANTUM</th>
                <th class="tengah" rowspan="2">HARGA IN CTN</th>
                <th class="tengah" rowspan="2">TOTAL OUT</th>
                <th class="tengah" rowspan="2">TOTAL IN</th>
                <th class="tengah" rowspan="2">KETERANGAN</th>
            </tr>
            <tr>
                <th>BESAR</th>
                <th>KECIL</th>
            </tr>
            </thead>
            <tbody>
            @php $out=0;$in=0;$qtyout=0;$qtyin=0; @endphp
            @foreach($data as $d)
                @php
                    $out += $d->qty_out;
                    $in += $d->qty_in;
                    $qtyout += $d->gross_out;
                    $qtyin += $d->gross_in;
                @endphp
                <tr>
                    <td>{{ $d->mstd_seqno }}</td>
                    <td>{{ $d->mstd_prdcd }}</td>
                    <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                    <td>{{ $d->kemasan }}</td>
                    <td>{{ intval($d->mstd_qty / $d->mstd_frac) }}</td>
                    <td>{{ $d->mstd_qty % $d->mstd_frac }}</td>
                    <td class="right">{{ $d->mstd_hrgsatuan }}</td>
                    <td class="right">{{ number_format($d->gross_out,2) }}</td>
                    <td class="right">{{ number_format($d->gross_in,2) }}</td>
                    <td>{{ $d->mstd_keterangan }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot style="text-align: center">
            <tr>
                <td colspan="4">QTY SUSUT : {{ $out - $in }} &nbsp;&nbsp;&nbsp;&nbsp; RPH SUSUT : {{ $qtyout - $qtyin }}</td>
                <td colspan="3">TOTAL SELURUHNYA :</td>
                <td class="right">{{ number_format($qtyout,2) }}</td>
                <td class="right">{{ number_format($qtyin,2) }}</td>
                <td></td>
            </tr>
            </tfoot>
        </table>
        <hr>
        @if($i != count($datas))
            <div class="page-break"></div>
        @endif
    @endforeach
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
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table-ttd{
        width: 15%;
    }
    .table tbody td {
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

    .table-header td{
        white-space: nowrap;
    }

    .tengah{
        vertical-align: middle !important;
    }
</style>
</html>
