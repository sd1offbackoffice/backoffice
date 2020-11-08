<!DOCTYPE html>
<html>
<head>
    <title>Surat Jalan Packlist</title>
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
    <h2 style="text-align: center">SURAT JALAN PACKLIST</h2>
</header>

<footer>

</footer>

<main>
    @if($data)
    @php
        $temp = '';
        $i = 0;
        $total = 0;
        $ppn = 0;
    @endphp
    @foreach($data as $d)
    @if($temp != $d->msth_nodoc)
    @if($temp != '')
    </tbody>
    <tfoot style="text-align: center">
    <tr>
        <td colspan="5"></td>
        <td colspan="2" style="text-align: left"><strong>TOTAL</strong></td>
        <td style="text-align: right">{{ number_format($total,2) }}</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td colspan="2" style="text-align: left"><strong>PPN</strong></td>
        <td style="text-align: right">{{ number_format($ppn,2) }}</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td colspan="2" style="text-align: left"><strong>TOTAL SELURUHNYA</strong></td>
        <td style="text-align: right">{{ number_format($total + $ppn,2) }}</td>
        <td></td>
    </tr>
    </tfoot>
    </table>
    {{--<br>--}}
    {{--<table style="width: 100%; font-weight: bold" class="table-ttd page-break-avoid">--}}
        {{--<tr>--}}
            {{--<td>DIBUAT</td>--}}
            {{--<td>DIPERIKSA</td>--}}
            {{--<td>MENYETUJUI</td>--}}
            {{--<td>PELAKSANA</td>--}}
            {{--<td>PENERIMA</td>--}}
        {{--</tr>--}}
        {{--<tr class="blank-row">--}}
            {{--<td colspan="5">.</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
            {{--<td>ADMINISTRASI</td>--}}
            {{--<td>KEPALA GUDANG</td>--}}
            {{--<td>STORE MANAGER</td>--}}
            {{--<td>STOCK CLERK / PETUGAS GUDANG</td>--}}
            {{--<td>CABANG PENERIMA</td>--}}
        {{--</tr>--}}
    {{--</table>--}}
    <div class="page-break"></div>
    @endif
    @php
        $temp = $d->msth_nodoc;
        $i = 0;
        $total = 0;
        $ppn = 0;
    @endphp
    <table class="table-borderless table-header">
        <tr style="text-align: left">
            <td>
                Nomor<br>
                Nomor Reff
            </td>
            <td>
                : {{ $d->msth_nodoc }}<br>
                :
            </td>
            <td>
                Tanggal<br>
                Tanggal Reff
            </td>
            <td>
                : {{ $d->msth_tgldoc }}<br>
                :
            </td>
            <td>
                Untuk Cabang<br>
                Gudang
            </td>
            <td>
                : {{ $d->cabang }}<br>
                : {{ $d->gudang }}
            </td>
        </tr>
    </table>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2" width="1%">NO</th>
            <th class="tengah" rowspan="2" width="6%">PLU</th>
            <th class="tengah" rowspan="2" width="40%">NAMA BARANG</th>
            <th class="tengah" rowspan="2" width="5%">KEMASAN</th>
            <th colspan="2" width="10%">KWANTUM</th>
            <th class="tengah" rowspan="2" width="8%">HARGA SATUAN</th>
            <th class="tengah" rowspan="2" width="8%">TOTAL NILAI</th>
            <th class="tengah" rowspan="2" width="20%">KETERANGAN</th>
        </tr>
        <tr>
            <th>BESAR</th>
            <th>KECIL</th>
        </tr>
        </thead>
        <tbody>
        @endif
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $d->mstd_prdcd }}</td>
            <td class="left">{{ $d->prd_deskripsipanjang }}</td>
            <td>{{ $d->kemasan }}</td>
            <td>{{ $d->mstd_qty / $d->mstd_frac }}</td>
            <td>{{ $d->mstd_qty % $d->mstd_frac }}</td>
            <td style="text-align: right">{{ number_format($d->mstd_hrgsatuan,2) }}</td>
            <td style="text-align: right">{{ number_format($d->mstd_gross,2) }}</td>
            <td>{{ $d->mstd_keterangan }}</td>
        </tr>
        @php
            $total += $d->mstd_gross;
            $ppn += $d->mstd_ppnrph;
        @endphp
        @endforeach
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td colspan="5"></td>
            <td colspan="2" style="text-align: left"><strong>TOTAL</strong></td>
            <td style="text-align: right">{{ number_format($total,2) }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td colspan="2" style="text-align: left"><strong>PPN</strong></td>
            <td style="text-align: right">{{ number_format($ppn,2) }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td colspan="2" style="text-align: left"><strong>TOTAL SELURUHNYA</strong></td>
            <td style="text-align: right">{{ number_format($total + $ppn,2) }}</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
    <br>
    <table style="width: 100%; font-weight: bold" class="table-ttd page-break-avoid">
        <tr>
            <td>DIBUAT</td>
            <td>DIPERIKSA</td>
            <td>MENYETUJUI</td>
            <td>PELAKSANA</td>
            <td>PENERIMA</td>
        </tr>
        <tr class="blank-row">
            <td colspan="5">.</td>
        </tr>
        <tr>
            <td>ADMINISTRASI</td>
            <td>KEPALA GUDANG</td>
            <td>STORE MANAGER</td>
            <td>STOCK CLERK / PETUGAS GUDANG</td>
            <td>CABANG PENERIMA</td>
        </tr>
    </table>
    @else
        <h3 class="center">Data tidak ditemukan!</h3>
    @endif
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
        /*white-space: nowrap;*/
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

</style>
</html>
