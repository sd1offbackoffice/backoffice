<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pembelian Per Divisi / Departement / Kategori</title>
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
            <i>User ID</i> : {{ $_SESSION['usid'] }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">** DAFTAR PEMBELIAN **</h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="10%" class="center" colspan="2">---------- BAPB ----------</th>
            <th width="5%" class="tengah" rowspan="2">PLU</th>
            <th width="20%" class="tengah left" rowspan="2">NAMA BARANG</th>
            <th width="5%" class="tengah" rowspan="2">KEMASAN</th>
            <th width="5%" class="tengah" rowspan="2">HARGA BELI</th>
            <th width="5%" colspan="2">KUANTUM</th>
            <th width="5%" class="tengah" rowspan="2">GROSS</th>
            <th width="5%" class="tengah" rowspan="2">PPN</th>
            <th width="5%" class="tengah" rowspan="2">PPN-BM</th>
            <th width="5%" class="tengah" rowspan="2">BOTOL</th>
            <th width="10%" class="tengah" rowspan="2">TOTAL NILAI</th>
            <th width="5%" class="tengah" rowspan="2">KETERANGAN</th>
            <th width="5%" class="tengah" rowspan="2">LCOST</th>
            <th width="5%" class="tengah" rowspan="2">ACOST</th>
        </tr>
        <tr>
            <th class="center">NOMOR</th>
            <th class="center">TANGGAL</th>
            <th class="center">CTN</th>
            <th class="center">PCS</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempdiv = '';
            $tempdep = '';
            $tempkat = '';
            $grosskat = 0;
            $potkat = 0;
            $ppnkat = 0;
            $bmkat = 0;
            $btlkat = 0;
            $totalkat = 0;
            $grossdep = 0;
            $potdep = 0;
            $ppndep = 0;
            $bmdep = 0;
            $btldep = 0;
            $totaldep = 0;
            $grossdiv = 0;
            $potdiv = 0;
            $ppndiv = 0;
            $bmdiv = 0;
            $btldiv = 0;
            $totaldiv = 0;
            $total = 0;
            $skipdep = false;
            $skipkat = false;
            $grossbkp = 0;
            $potbkp = 0;
            $ppnbkp = 0;
            $bmbkp = 0;
            $btlbkp = 0;
            $totalbkp = 0;
            $grossbtkp = 0;
            $potbtkp = 0;
            $ppnbtkp = 0;
            $bmbtkp = 0;
            $btlbtkp = 0;
            $totalbtkp = 0;
        @endphp
        @for($i=0;$i<count($data);$i++)
            @php
                $d = $data[$i];
                $total += $d->total;
                $skipdep = false;
                $skipkat = false;
                $grossbkp += $d->grossbkp;
                $potbkp += $d->potbkp;
                $ppnbkp += $d->ppnbkp;
                $bmbkp += $d->bmbkp;
                $btlbkp += $d->btlbkp;
                $totalbkp += $d->totalbkp;
                $grossbtkp += $d->grossbtkp;
                $potbtkp += $d->potbtkp;
                $ppnbtkp += $d->ppnbtkp;
                $bmbtkp += $d->bmbtkp;
                $btlbtkp += $d->btlbtkp;
                $totalbtkp += $d->totalbtkp;
            @endphp
            @if($tempdiv != $d->mstd_kodedivisi)
                @if($tempdiv != '')
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grosskat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppnkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btlkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
                    </tr>
                    @php
                        $grosskat = 0;
                        $potkat = 0;
                        $ppnkat = 0;
                        $bmkat = 0;
                        $btlkat = 0;
                        $totalkat = 0;
                        $skipkat = true;
                    @endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grossdep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppndep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmdep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btldep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php
                        $grossdep = 0;
                        $potdep = 0;
                        $ppndep = 0;
                        $bmdep = 0;
                        $btldep = 0;
                        $totaldep = 0;
                        $skipdep = true;
                    @endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grossdiv,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppndiv,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmdiv,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btldiv,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php
                        $grossdiv = 0;
                        $potdiv = 0;
                        $ppndiv = 0;
                        $bmdiv = 0;
                        $btldiv = 0;
                        $totaldiv = 0;
                    @endphp
                @endif
                @php $tempdiv = $d->mstd_kodedivisi @endphp
                <tr>
                    <td class="left"><strong>DIVISI</strong></td>
                    <td><strong>: {{ $d->mstd_kodedivisi }}</strong></td>
                    <td class="left" colspan="14"><strong> - {{ $d->div_namadivisi }}</strong></td>
                </tr>
            @endif
            @php
                $grossdiv += $d->gross;
                $ppndiv += $d->ppn;
                $bmdiv += $d->bm;
                $btldiv += $d->btl;
                $totaldiv += $d->total;
            @endphp
            @if($tempdep != $d->mstd_kodedepartement)
                @if($tempdep != '' && !$skipdep)
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grosskat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppnkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btlkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
                    </tr>
                    @php
                        $grosskat = 0;
                        $potkat = 0;
                        $ppnkat = 0;
                        $bmkat = 0;
                        $btlkat = 0;
                        $totalkat = 0;
                        $skipkat = true;
                    @endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grossdep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppndep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmdep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btldep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php
                        $totaldep = 0;
                        $grossdep = 0;
                        $potdep = 0;
                        $ppndep = 0;
                        $bmdep = 0;
                        $btldep = 0;
                    @endphp
                @endif
                @php $tempdep = $d->mstd_kodedepartement @endphp
                <tr>
                    <td class="left"><strong>DEPARTEMENT</strong></td>
                    <td><strong>: {{ $d->mstd_kodedepartement }}</strong></td>
                    <td class="left" colspan="14"><strong> - {{ $d->dep_namadepartement }}</strong></td>
                </tr>
            @endif
            @php
                $grossdep += $d->gross;
                $ppndep += $d->ppn;
                $bmdep += $d->bm;
                $btldep += $d->btl;
                $totaldep += $d->total;
            @endphp
            @if($tempkat != $d->mstd_kodekategoribrg)
                @if($tempkat != '' && !$skipkat)
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grosskat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppnkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btlkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php $totalkat = 0; @endphp
                @endif
                @php $tempkat = $d->mstd_kodekategoribrg @endphp
                <tr>
                    <td class="left"><strong>KATEGORI</strong></td>
                    <td><strong>: {{ $d->mstd_kodekategoribrg }}</strong></td>
                    <td class="left" colspan="14"><strong> - {{ $d->kat_namakategori}}</strong></td>
                </tr>
            @endif
            @php
                $grosskat += $d->gross;
                $ppnkat += $d->ppn;
                $bmkat += $d->bm;
                $btlkat += $d->btl;
                $totalkat += $d->total;
            @endphp
            <tr>
                <td>{{ $d->mstd_nodoc }}</td>
                <td>{{ $d->mstd_tgldoc }}</td>
                <td>{{ $d->mstd_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td>{{ $d->unit }}</td>
                <td class="right">{{ number_format($d->hg_beli,2) }}</td>
                <td>{{ $d->ctn }}</td>
                <td>{{ $d->pcs }}</td>
                <td class="right">{{ number_format($d->gross,2) }}</td>
                <td class="right">{{ number_format($d->ppn,2) }}</td>
                <td class="right">{{ number_format($d->bm,2) }}</td>
                <td class="right">{{ number_format($d->btl,2) }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
                <td>{{ $d->mstd_keterangan }}</td>
                <td class="right">{{ number_format($d->lcost,2) }}</td>
                <td class="right">{{ number_format($d->acost,2) }}</td>
            </tr>
        @endfor
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grosskat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potkat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppnkat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmkat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btlkat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossdep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potdep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppndep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmdep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btldep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossdiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potdiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppndiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmdiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btldiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
            <td colspan="8"></td>
        </tr>
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BKP</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppnbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btlbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalbkp,2) }}</strong></td>
            <th colspan="3"></th>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BTKP</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppnbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btlbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalbtkp,2) }}</strong></td>
            <th colspan="3"></th>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossbkp + $grossbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potbtkp + $potbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppnbtkp + $ppnbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmbtkp + $bmbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btlbtkp + $btlbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalbtkp + $totalbkp,2) }}</strong></td>
            <th colspan="3"></th>
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
        size: 1071pt 792pt;
        /*size: 842pt 595pt;*/
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
