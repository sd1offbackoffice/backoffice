<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penyesuaian</title>
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
            NPWP : {{ $perusahaan->prs_npwp }}<br><br>
            @if($reprint == 1)
                <strong>REPRINT</strong>
            @endif
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d-m-Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ Session::get('usid') }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">** MEMO PENYESUAIAN PERSEDIAAN **</h2>
</header>

<footer>

</footer>

<main>
    @if(count($report) == 0)
        <h4 class="center">@yield('nodata','TIDAK ADA DATA')</h4>
    @else
    @php
        $temp = '';
        $i = 0;
        $total = 0;
    @endphp
    @foreach($report as $d)
    @if($temp != $d->msth_nodoc)
    @if($temp != '')
    </tbody>
    <tfoot style="text-align: center">
    <tr>
        <td colspan="5"></td>
        <td colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
        <td class="right">{{ number_format($total,1) }}</td>
        <td></td>
    </tr>
    </tfoot>
    </table>
    <br>
    <table style="width: 100%; font-weight: bold" class="table-ttd">
        <tr>
            <td style="border-left: 1px solid black">DIBUAT</td>
            <td style="border-left: 1px solid black">DIPERIKSA</td>
            <td style="border-left: 1px solid black">MENYETUJUI</td>
            <td style="border-left: 1px solid black">PELAKSANA</td>
        </tr>
        <tr class="blank-row">
            <td style="border-left: 1px solid black">ttd</td>
            <td style="border-left: 1px solid black">ttd</td>
            <td style="border-left: 1px solid black">ttd</td>
            <td style="border-left: 1px solid black">ttd</td>
        </tr>
        <tr>
            <td style="border-left: 1px solid black">ADMINISTRASI</td>
            <td style="border-left: 1px solid black">KEPALA GUDANG</td>
            <td style="border-left: 1px solid black">STORE MANAGER</td>
            <td style="border-left: 1px solid black">STOCK CLERK / PETUGAS GUDANG</td>
        </tr>
    </table>
    <div class="page-break"></div>
    @endif
    @php
        $temp = $d->msth_nodoc;
        $i = 0;
    @endphp
    <table class="table-borderless table-header">
        <tr style="text-align: left">
            <td>
                Nomor Penyesuaian<br>
                Nomor Refferensi<br>
                Keterangan
            </td>
            <td>
                : {{ $d->msth_nodoc }}<br>
                : <br>
                : {{ $d->keterangan_h }}
            </td>
            <td>
                Tanggal<br>
                Tanggal<br>
                <span style="color:white">.</span>
            </td>
            <td>
                : @if($d->msth_tgldoc != '')
                    {{ date('d/m/Y', strtotime($d->msth_tgldoc)) }}
                @endif
                <br>
                : @if($d->trbo_tglreff != '')
                    {{ date('d/m/Y', strtotime($d->trbo_tglreff)) }}
                @endif
                <br>
                <span style="color:white">.</span>
            </td>
            <td>
                {{ $perusahaan->prs_namacabang }}<br>
                {{ $perusahaan->prs_alamat1 }} {{ $perusahaan->prs_alamat3 }}
            </td>
        </tr>
    </table>

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">No</th>
            <th class="tengah" rowspan="2">PLU</th>
            <th class="tengah" rowspan="2">NAMA BARANG</th>
            <th class="tengah" rowspan="2">KEMASAN</th>
            <th colspan="2">KWANTUM</th>
            <th class="tengah">HARGA</th>
            <th class="tengah" rowspan="2">TOTAL</th>
            <th class="tengah" rowspan="2">KETERANGAN</th>
        </tr>
        <tr>
            <th>BESAR</th>
            <th>KECIL</th>
            <th>IN CTN</th>
        </tr>
        </thead>
        <tbody>
        @endif
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $d->mstd_prdcd }}</td>
            <td class="left">{{ $d->prd_deskripsipanjang }}</td>
            <td>{{ $d->kemasan }}</td>
            <td>{{ number_format($d->mstd_qty < 0 ? ceil($d->mstd_qty / $d->mstd_frac) : floor($d->mstd_qty / $d->mstd_frac),0) }}</td>
            <td>{{ $d->mstd_qty % $d->mstd_frac }}</td>
            <td class="right">{{ number_format($d->mstd_hrgsatuan,2) }}</td>
            <td class="right">{{ number_format($d->mstd_gross,1) }}</td>
            <td>{{ $d->mstd_keterangan }}</td>
        </tr>
        @php $total += $d->mstd_gross; @endphp
        @endforeach
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td colspan="5"></td>
            <td colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="right">{{ number_format($total,1) }}</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
    <br>
    <table style="width: 100%; font-weight: bold" class="table-ttd">
        <tr>
            <td style="border-left: 1px solid black">DIBUAT</td>
            <td style="border-left: 1px solid black">DIPERIKSA</td>
            <td style="border-left: 1px solid black">MENYETUJUI</td>
            <td style="border-left: 1px solid black">PELAKSANA</td>
        </tr>
        <tr class="blank-row">
            <td style="border-left: 1px solid black">ttd</td>
            <td style="border-left: 1px solid black">ttd</td>
            <td style="border-left: 1px solid black">ttd</td>
            <td style="border-left: 1px solid black">ttd</td>
        </tr>
        <tr>
            <td style="border-left: 1px solid black">ADMINISTRASI</td>
            <td style="border-left: 1px solid black">KEPALA GUDANG</td>
            <td style="border-left: 1px solid black">STORE MANAGER</td>
            <td style="border-left: 1px solid black">STOCK CLERK / PETUGAS GUDANG</td>
        </tr>
    </table>
    @endif
</main>

<br>
</body>
<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        @if($ukuran == 'besar')
        size: 595pt 842pt;
        @else
        size: 595pt 442pt;
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
        font-size: 8px;
        /*white-space: nowrap;*/
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }
    .table-ttd{
        width: 15%;
        border: 1px solid black;
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

    .table-header td{
        white-space: nowrap;
    }

    .tengah{
        vertical-align: middle !important;
    }

    .blank-row{
        line-height: 70px!important;
        color: white;
    }
</style>
</html>
