<!DOCTYPE html>
<html>

<head>
        <title>{{ strtoupper($data1[0]->judul) }}</title>

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
                {{ $perusahaan->prs_namacabang }}<br><br>
                NOMOR TRN : {{ $data1[0]->trbo_nodoc }} <br>
                TANGGAL : {{ substr($data1[0]->trbo_tgldoc,0,10) }}<br><br>
                NO. REF : {{ substr($data1[0]->trbo_noreff,0,10) }}<br><br>
                KET : {{ substr($data1[0]->ket,0,10) }}<br><br>
            </p>
        </div>
        <div style="float:right; margin-top: 0px; line-height: 8px !important;">
            <p>
                PRG : IGR BO LIST<br>
            </p><br><br>
            <p>
                {{ $data1[0]->status }}
            </p>
        </div>
        <h2 style="text-align: center">  {{ $data1[0]->judul }} </h2>
    </header>

    <main style="margin-top: 50px;">
        <table class="table">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">PLU</th>
                <th rowspan="2">NAMA BARANG</th>
                <th colspan="2">KEMASAN</th>
                <th colspan="2">KWANTUM</th>
                <th rowspan="2">HARGA<br>SATUAN</th>
                <th rowspan="2">TOTAL</th>
                <th rowspan="2">KET</th>
            </tr>
            </thead>
            <tbody>
            @php
                $total = 0;
                $i=1;
        @endphp

        @if(sizeof($data1)!=0)
            @foreach($data1 as $d)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $d->trbo_prdcd }}</td>
                    <td>{{ $d->prd_deskripsipanjang}}</td>
                    <td>{{ $d->trbo_unit }}</td>
                    <td class="right">{{ $d->trbo_frac }}</td>
                    <td class="right">{{ $d->ctn }}</td>
                    <td class="right">{{ $d->pcs }}</td>
                    <td class="right">{{ number_format(round($d->trbo_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
                    <td>{{ $d->trbo_keterangan }}</td>
                </tr>
                @php
                    $i++;
                    $total += $d->total;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif


        </tbody>
        <tfoot>
        <tr>
            <td colspan="7"></td>
            <td style="font-weight: bold">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format(round($total), 0, '.', ',') }}</td>
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
