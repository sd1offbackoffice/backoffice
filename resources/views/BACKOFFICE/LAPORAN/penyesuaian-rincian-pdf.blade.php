<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penyesuaian Persediaan Rincian Produk Per Divisi / Departement / Kategori</title>
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
            {{ $perusahaan->prs_namacabang }}<br><br><br><br>
            <strong>Tanggal : {{ $tgl1 }} - {{ $tgl2 }}</strong><br><br>
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ Session::get('usid') }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">** DAFTAR PENYESUAIAN PERSEDIAAN **<br>RINCIAN PRODUK PER DIVISI / DEPARTEMEN / KATEGORI</h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="10%" class="center" colspan="2">---------- BAPB ----------</th>
            <th width="5%" class="tengah" rowspan="2">PLU</th>
            <th width="15%" class="tengah left" rowspan="2">NAMA BARANG</th>
            <th width="10%" class="tengah" rowspan="2">KEMASAN</th>
            <th width="10%" class="tengah" rowspan="2">HARGA SATUAN</th>
            <th width="5%" class="tengah" rowspan="2">KUANTUM</th>
            <th width="10%" class="tengah" rowspan="2">TOTAL NILAI</th>
            <th width="35%" class="tengah" rowspan="2">KETERANGAN</th>
        </tr>
        <tr>
            <th class="center" width="3%">NOMOR</th>
            <th class="center" width="3%">TANGGAL</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempdiv = '';
            $tempdep = '';
            $tempkat = '';
            $totaldiv = 0;
            $totaldep = 0;
            $totalkat = 0;
            $total = 0;
            $skipdep = false;
            $skipkat = false;
        @endphp
        @for($i=0;$i<count($data);$i++)
            @php
                $d = $data[$i];
                $total += $d->total;
                $skipdep = false;
                $skipkat = false;
            @endphp
            @if($tempdiv != $d->prd_kodedivisi)
                @if($tempdiv != '')
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td colspan="5"></td>
                        <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php $totaldep = 0; $skipdep = true;@endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
                        <td colspan="5"></td>
                        <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php $totaldiv = 0; @endphp
                @endif
                @php $tempdiv = $d->prd_kodedivisi @endphp
                <tr>
                    <td class="left"><strong>DIVISI</strong></td>
                    <td><strong>: {{ $d->prd_kodedivisi }}</strong></td>
                    <td class="left" colspan="7"><strong> - {{ $d->div_namadivisi }}</strong></td>
                </tr>
            @endif
            @php $totaldiv += $d->total @endphp
            @if($tempdep != $d->prd_kodedepartement)
                @if($tempdep != '' && !$skipdep)
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
                        <td colspan="5"></td>
                        <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php $totalkat = 0; $skipkat = true; @endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td colspan="5"></td>
                        <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php $totaldep = 0; @endphp
                @endif
                @php $tempdep = $d->prd_kodedepartement @endphp
                <tr>
                    <td class="left"><strong>DEPARTEMENT</strong></td>
                    <td><strong>: {{ $d->prd_kodedepartement }}</strong></td>
                    <td class="left" colspan="7"><strong> - {{ $d->dep_namadepartement }}</strong></td>
                </tr>
            @endif
            @php $totaldep += $d->total @endphp
            @if($tempkat != $d->prd_kodekategoribarang)
                @if($tempkat != '' && !$skipkat)
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
                        <td colspan="5"></td>
                        <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php $totalkat = 0; @endphp
                @endif
                @php $tempkat = $d->prd_kodekategoribarang @endphp
                <tr>
                    <td class="left"><strong>KATEGORI</strong></td>
                    <td><strong>: {{ $d->prd_kodekategoribarang }}</strong></td>
                    <td class="left" colspan="7"><strong> - {{ $d->kat_namakategori}}</strong></td>
                </tr>
            @endif
            @php $totalkat += $d->total @endphp
            <tr>
                <td>{{ $d->msth_nodoc }}</td>
                <td>{{ $d->msth_tgldoc }}</td>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->barang }}</td>
                <td>{{ $d->kemasan }}</td>
                <td class="right">{{ number_format($d->harga,2) }}</td>
                <td>{{ $d->qty }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
                <td>{{ $d->keterangan }}</td>
            </tr>
        @endfor
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
            <td colspan="5"></td>
            <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
            <td colspan="5"></td>
            <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
            <td colspan="5"></td>
            <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
            <td></td>
        </tr>
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td colspan="5"></td>
            <td class="right"><strong>{{ number_format($total,2) }}</strong></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
    <hr>
    <p class="right"><strong>** AKHIR DARI LAPORAN **</strong></p>
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
    .table{
        width: 100%;
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
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
