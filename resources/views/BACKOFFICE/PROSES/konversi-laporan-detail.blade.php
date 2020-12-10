<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penyesuaian Persediaan Konversi Perishable</title>
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
    <h2 style="text-align: center">DAFTAR PENYESUAIAN PERSEDIAAN<br>KONVERSI PERISHABLE</h2>
    {{--<h2>KERTAS KERJA ESTIMASI KEBUTUHAN TOKO IGR **<br>Periode : {{ $periode }}</h2>--}}
</header>

<footer>

</footer>

<main>
    <table class="table table-borderless table-header">
        <thead>
        <tr>
            <th>
                Tanggal
            </th>
            <th>
                : {{ $data[0]->msth_tgldoc }}
            </th>
            <th width="50%"></th>
            <th>RINCIAN PRODUK PER DIVISI / DEPARTEMEN / KATEGORI</th>
        </tr>
        </thead>
    </table>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="2" width="10%">---------------- BAPB ----------------</th>
            <th class="tengah" rowspan="2" width="5%">PLU</th>
            <th class="tengah" rowspan="2" width="15%">NAMA BARANG</th>
            <th class="tengah" rowspan="2" width="5%">KEMASAN</th>
            <th class="tengah right" rowspan="2" width="10%">HARGA SATUAN</th>
            <th class="tengah right" rowspan="2" width="10%">KUANTUM</th>
            <th class="tengah right" rowspan="2" width="10%">TOTAL NILAI</th>
            <th class="tengah" rowspan="2" width="35%">KETERANGAN</th>
        </tr>
        <tr>
            <th>NOMOR</th>
            <th>TANGGAL</th>
        </tr>
        </thead>
        <tbody>
        @php $div = ''; $dep = ''; $kat = ''; $print = false; @endphp
        @for($i=0;$i<count($data);$i++)
            @php $d = $data[$i]; @endphp
            @if($div != $d->prd_kodedivisi || $dep != $d->prd_kodedepartement || $kat != $d->prd_kodekategoribarang)
                @php
                    $div = $d->prd_kodedivisi;
                    $dep = $d->prd_kodedepartement;
                    $kat = $d->prd_kodekategoribarang;
                @endphp
            <tr>
                <td class="left">DIVISI</td>
                <td class="left">: {{ $d->prd_kodedivisi }} - {{ $d->div_namadivisi }}</td>
                <td colspan="7"></td>
            </tr>
            <tr>
                <td class="left">DEPARTEMEN</td>
                <td class="left">: {{ $d->prd_kodedepartement }} - {{ $d->dep_namadepartement }}</td>
                <td colspan="7"></td><td></td>
            </tr>
            <tr>
                <td class="left">KATEGORI</td>
                <td class="left">: {{ $d->prd_kodekategoribarang }} - {{ $d->kat_namakategori }}</td>
                <td colspan="7"></td>
            </tr>
            @endif
            <tr>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc }}</td>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->barang }}</td>
                <td>{{ $d->kemasan }}</td>
                <td class="right">{{ $d->harga }}</td>
                <td class="right">{{ $d->qty }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
                <td>{{ $d->keterangan }}</td>
            </tr>
            @php $j = $i; @endphp
            @if(++$j < count($data))
                @if($div != $data[$j]->prd_kodedivisi || $dep != $data[$j]->prd_kodedepartement || $kat != $data[$j]->prd_kodekategoribarang)
                    @php $print = false; @endphp
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL DEPARTEMENT : {{ $d->prd_kodedepartement }}</td>
                        <td class="right">{{ number_format($d->total,2) }}</td>
                    </tr>
                    <tr>
                        <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
                        <td class="right">{{ number_format($d->total,2) }}</td>
                    </tr>
                @endif
            @endif
        @endfor
        <tr>
            <td class="left" colspan="2">SUBTOTAL KATEGORI : {{ $d->prd_kodekategoribarang }}</td>
            <td colspan="5"></td>
            {{--<td class="right">{{ number_format($d->total,2) }}</td>--}}
            <td class="right">0.00</td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2">SUBTOTAL DEPARTEMENT : {{ $d->prd_kodedepartement }}</td>
            <td colspan="5"></td>
            {{--<td class="right">{{ number_format($d->total,2) }}</td>--}}
            <td class="right">0.00</td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2">SUBTOTAL DIVISI : {{ $d->prd_kodedivisi }}</td>
            <td colspan="5"></td>
            {{--<td class="right">{{ number_format($d->total,2) }}</td>--}}
            <td class="right">0.00</td>
            <td></td>
        </tr>
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2">TOTAL SELURUHNYA</td>
            <td colspan="5"></td>
            {{--<td class="right">{{ number_format($d->total,2) }}</td>--}}
            <td class="right">0.00</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
    <hr>
</main>

<br>
</body>
<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: 842pt 595pt;
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
