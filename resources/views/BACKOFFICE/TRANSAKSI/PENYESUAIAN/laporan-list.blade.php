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
            {{ $data[0]->prs_namaperusahaan }}<br><br>
            {{ $data[0]->prs_namacabang }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d-m-Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ $_SESSION['usid'] }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">** EDIT LIST PENYESUAIAN PERSEDIAAN **</h2>
    {{--<h2>KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR **<br>Periode : {{ $periode }}</h2>--}}
</header>

<footer>

</footer>

<main>
    @php
        $temp = '';
        $i = 0;
        $total = 0;
    @endphp
    @foreach($data as $d)
        @if($temp != $d->trbo_nodoc)
            @if($temp != '')
                </tbody>
                <tfoot style="text-align: center">
                    <tr>
                        <td colspan="5"></td>
                        <td colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
                        <td>{{ number_format($total,1) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                </table>
                <div class="page-break"></div>
            @endif
            @php
                $temp = $d->trbo_nodoc;
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
                        : {{ $d->trbo_nodoc }}<br>
                        : <br>
                        : {{ $d->keterangan_h }}
                    </td>
                    <td>
                        Tanggal<br>
                        Tanggal<br>
                        <span style="color:white">.</span>
                    </td>
                    <td>
                        : @if($d->trbo_tgldoc != '')
                            {{ date('d/m/Y', strtotime($d->trbo_tgldoc)) }}
                          @endif
                            <br>
                        : @if($d->trbo_tglreff != '')
                            {{ date('d/m/Y', strtotime($d->trbo_tglreff)) }}
                          @endif
                            <br>
                        <span style="color:white">.</span>
                    </td>
                </tr>
            </table>

                <table class="table">
                    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                    <tr>
                        <th class="tengah" rowspan="2" width="3%">No</th>
                        <th class="tengah" rowspan="2" width="7%">PLU</th>
                        <th class="tengah" rowspan="2" width="40%">NAMA BARANG</th>
                        <th class="tengah" rowspan="2" width="7%">KEMASAN</th>
                        <th colspan="2" width="10%">KWANTUM</th>
                        <th class="tengah" width="10%">HARGA</th>
                        <th class="tengah" rowspan="2" width="10%">TOTAL</th>
                        <th class="tengah" rowspan="2" width="13%">KETERANGAN</th>
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
            <td>{{ $d->plu }}</td>
            <td class="left">{{ $d->prd_deskripsipanjang }}</td>
            <td>{{ $d->kemasan }}</td>
            <td>{{ number_format($d->trbo_qty / $d->prd_frac,0) }}</td>
            <td>{{ $d->trbo_qty % $d->prd_frac }}</td>
            <td>{{ number_format($d->trbo_hrgsatuan,2) }}</td>
            <td>{{ number_format($d->trbo_gross,1) }}</td>
            <td>{{ $d->trbo_keterangan }}</td>
        </tr>
        @php $total += $d->trbo_gross; @endphp
    @endforeach
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td colspan="5"></td>
            <td colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td>{{ $total }}</td>
            <td></td>
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
