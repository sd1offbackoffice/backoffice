<!DOCTYPE html>
<html>
<head>
    <title>Daftar Penerimaan Produk Divisi / Departemen / Kategori</title>
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
    <h2 style="text-align: center">** DAFTAR PEMBELIAN **<br>RINGKASAN DIVISI / DEPARTEMEN / KATEGORI</h2>
</header>

<footer>

</footer>

<main>
    @php
        $tempdiv = '';
        $tempdep = '';
        $tempkat = '';

        $totaldiv = 0;
        $totaldep = 0;
        $totalkat = 0;
        $total = 0;
        $skipdep = false;

        $st_div_gross = 0;
        $st_div_potongan = 0;
        $st_div_disc = 0;
        $st_div_ppn = 0;
        $st_div_gross = 0;
        $st_div_bm = 0;
        $st_div_btl = 0;
        $st_div_tn = 0;

        $st_dep_gross = 0;
        $st_dep_potongan = 0;
        $st_dep_disc = 0;
        $st_dep_ppn = 0;
        $st_dep_bm = 0;
        $st_dep_btl = 0;
        $st_dep_tn = 0;

        $st_kat_gross = 0;
        $st_kat_potongan = 0;
        $st_kat_disc = 0;
        $st_kat_ppn = 0;
        $st_kat_bm = 0;
        $st_kat_btl = 0;
        $st_kat_tn = 0;

        $sum_gross_bkp=0;
        $sum_gross_btkp=0;
        $sum_potongan_bkp=0;
        $sum_potongan_btkp=0;
        $sum_ppn_bkp=0;
        $sum_ppn_btkp=0;
        $sum_bm_bkp=0;
        $sum_bm_btkp=0;
        $sum_btl_bkp=0;
        $sum_btl_btkp=0;
        $sum_total_bkp=0;
        $sum_total_btkp=0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        {{--style="border-top: 1px solid black;border-bottom: 1px solid black;"--}}
        <tr style="border:1px solid black;">
            <th colspan="2">---NPB---</th>
            <th rowspan="2" style="vertical-align: middle;">PLU</th>
            <th rowspan="2" style="vertical-align: middle;">NAMA BARANG</th>
            <th rowspan="2" style="vertical-align: middle;">KEMASAN</th>
            <th rowspan="2" style="vertical-align: middle;">HARGA BELI</th>
            <th colspan="2" style="vertical-align: middle;">-KUANTUM-</th>
            <th rowspan="2" style="vertical-align: middle;">BONUS</th>
            <th rowspan="2" style="vertical-align: middle;">GROSS</th>
            <th rowspan="2" style="vertical-align: middle;">POTONGAN</th>
            <th rowspan="2" style="vertical-align: middle;">PPN</th>
            <th rowspan="2" style="vertical-align: middle;">PPN-BM</th>
            <th rowspan="2" style="vertical-align: middle;">BOTOL</th>
            <th rowspan="2" style="vertical-align: middle;">TOTAL NILAI</th>
            <th rowspan="2" style="vertical-align: middle;">KETERANGAN</th>
            <th rowspan="2" style="vertical-align: middle;">LCOST</th>
            <th rowspan="2" style="vertical-align: middle;">ACOST</th>
        </tr>
        <tr>
            <th>NOMOR</th>
            <th>TANGGAL</th>
            <th>CTN</th>
            <th>PCS</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->mstd_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="17"><b>{{$data[$i]->mstd_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif;
            @if($tempdep != $data[$i]->mstd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="17"><b>{{$data[$i]->mstd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif;
            @if($tempkat != $data[$i]->mstd_kodekategoribrg)
                <tr>
                    <td class="left"><b>KATEGORI</b></td>
                    <td class="left" colspan="17"><b>{{$data[$i]->mstd_kodekategoribrg}}
                            - {{$data[$i]->kat_namakategori}}</b></td>
                </tr>
            @endif;
            <tr>
                <td class="left">{{ $data[$i]->no_doc }}</td>
                <td class="left">{{ $data[$i]->tgl_doc }}</td>
                <td class="left">{{ $data[$i]->plu }}</td>
                <td class="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td class="left">{{ $data[$i]->kemasan }}</td>
                <td class="left">{{ $data[$i]->mstd_hrgsatuan }}</td>
                <td class="left">{{ $data[$i]->ctn }}</td>
                <td class="left">{{ $data[$i]->pcs }}</td>
                <td class="left">{{ $data[$i]->bonus }}</td>
                <td class="right">{{ number_format($data[$i]->gross,2) }}</td>
                <td class="right">{{ number_format($data[$i]->potongan,2) }}</td>
                <td class="right">{{ number_format($data[$i]->ppn,2) }}</td>
                <td class="right">{{ number_format($data[$i]->bm,2) }}</td>
                <td class="right">{{ number_format($data[$i]->btl,2) }}</td>
                <td class="right">{{ number_format($data[$i]->total,2) }}</td>
                <td class="left">{{ $data[$i]->mstd_keterangan }}</td>
                <td class="right">{{ number_format($data[$i]->lcost,2) }}</td>
                <td class="right">{{ number_format($data[$i]->acost,2) }}</td>
            </tr>
            @php
                $st_dep_gross += $data[$i]->gross;
                $st_dep_potongan += $data[$i]->potongan;
                $st_dep_ppn += $data[$i]->ppn;
                $st_dep_bm += $data[$i]->bm;
                $st_dep_btl += $data[$i]->btl;
                $st_dep_tn += $data[$i]->total;

                $st_div_gross += $data[$i]->gross;
                $st_div_potongan += $data[$i]->potongan;
                $st_div_ppn += $data[$i]->ppn;
                $st_div_bm += $data[$i]->bm;
                $st_div_btl += $data[$i]->btl;
                $st_div_tn += $data[$i]->total;

                $st_kat_gross += $data[$i]->gross;
                $st_kat_potongan += $data[$i]->potongan;
                $st_kat_ppn += $data[$i]->ppn;
                $st_kat_bm += $data[$i]->bm;
                $st_kat_btl += $data[$i]->btl;
                $st_kat_tn += $data[$i]->total;

                $sum_gross_bkp += $data[$i]->sum_gross_bkp;
                $sum_potongan_bkp += $data[$i]->sum_potongan_bkp;
                $sum_ppn_bkp += $data[$i]->sum_ppn_bkp;
                $sum_bm_bkp += $data[$i]->sum_bm_bkp;
                $sum_btl_bkp += $data[$i]->sum_btl_bkp;
                $sum_total_bkp += $data[$i]->sum_total_bkp;

                $sum_gross_btkp += $data[$i]->sum_gross_btkp;
                $sum_potongan_btkp += $data[$i]->sum_potongan_btkp;
                $sum_ppn_btkp += $data[$i]->sum_ppn_btkp;
                $sum_bm_btkp += $data[$i]->sum_bm_btkp;
                $sum_btl_btkp += $data[$i]->sum_btl_btkp;
                $sum_total_btkp += $data[$i]->sum_total_btkp;

                $tempdiv = $data[$i]->mstd_kodedivisi;
                $tempdep = $data[$i]->mstd_kodedepartement;
                $tempkat = $data[$i]->mstd_kodekategoribrg;
            @endphp
            @if((isset($data[$i+1]->mstd_kodekategoribrg) && $tempkat != $data[$i+1]->mstd_kodekategoribrg) || !(isset($data[$i+1]->mstd_kodekategoribrg)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL KATEGORI</td>
                    <td class="left" colspan="8">{{ $data[$i]->mstd_kodekategoribrg }} - {{ $data[$i]->kat_namakategori }}</td>
                    <td class="right">{{ number_format($st_kat_gross,2) }}</td>
                    <td class="right">{{ number_format($st_kat_potongan,2) }}</td>
                    <td class="right">{{ number_format($st_kat_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_kat_bm ,2) }}</td>
                    <td class="right">{{ number_format($st_kat_btl,2) }}</td>
                    <td class="right">{{ number_format($st_kat_tn,2) }}</td>
                    <td class="right" colspan="3"></td>
                </tr>
                @php
                    $skipdiv = false;
                    $st_kat_gross = 0;
                    $st_kat_potongan = 0;
                    $st_kat_ppn = 0;
                    $st_kat_bm = 0;
                    $st_kat_btl = 0;
                    $st_kat_tn = 0;
                @endphp
            @endif
            @if( isset($data[$i+1]->mstd_kodedepartement) && $tempdep != $data[$i+1]->mstd_kodedepartement || !(isset($data[$i+1]->mstd_kodedepartement)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DEPT</td>
                    <td class="left" colspan="8">{{ $data[$i]->mstd_kodedepartement }} - {{$data[$i]->dep_namadepartement}}</td>
                    <td class="right">{{ number_format( $st_dep_gross,2) }}</td>
                    <td class="right">{{ number_format($st_dep_potongan,2) }}</td>
                    <td class="right">{{ number_format($st_dep_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_dep_bm ,2) }}</td>
                    <td class="right">{{ number_format($st_dep_btl,2) }}</td>
                    <td class="right">{{ number_format($st_dep_tn,2) }}</td>
                    <td class="right" colspan="3"></td>
                </tr>
                @php
                    $st_dep_gross = 0;
                    $st_dep_potongan = 0;
                    $st_dep_ppn = 0;
                    $st_dep_bm = 0;
                    $st_dep_btl = 0;
                    $st_dep_tn = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->mstd_kodedivisi) && $tempdiv != $data[$i+1]->mstd_kodedivisi) || !(isset($data[$i+1]->mstd_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DIVISI</td>
                    <td class="left" colspan="8">{{ $data[$i]->mstd_kodedivisi }} - {{ $data[$i]->div_namadivisi }}</td>
                    <td class="right">{{ number_format( $st_div_gross,2) }}</td>
                    <td class="right">{{ number_format($st_div_potongan,2) }}</td>
                    <td class="right">{{ number_format($st_div_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_div_bm ,2) }}</td>
                    <td class="right">{{ number_format($st_div_btl,2) }}</td>
                    <td class="right">{{ number_format($st_div_tn,2) }}</td>
                    <td class="right" colspan="3"></td>
                </tr>
                @php
                    $skipdiv = false;
                    $st_div_gross = 0;
                    $st_div_potongan = 0;
                    $st_div_ppn = 0;
                    $st_div_bm = 0;
                    $st_div_btl = 0;
                    $st_div_tn = 0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="9"><strong>TOTAL BKP</strong></td>
            <td class="right">{{ number_format($sum_gross_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_potongan_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_ppn_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_bm_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_btl_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_total_bkp ,2) }}</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td class="left" colspan="9"><strong>TOTAL BTKP</strong></td>
            <td class="right">{{ number_format($sum_gross_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_potongan_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_ppn_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_bm_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_btl_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_total_btkp ,2) }}</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td class="left" colspan="9"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_bm_bkp+$sum_bm_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_btl_bkp+$sum_btl_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</td>
            <td colspan="3"></td>
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
        size: 1200pt 842pt;
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
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        /*margin-top: 25px;*/
    }

    .table-ttd {
        width: 15%;
    }

    .table tbody td {
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
        padding: 3px !important;
    }

    .right {
        text-align: right;
        padding: 3px !important;
    }

    .page-break {
        page-break-before: always;
    }

    .table-header td {
        white-space: nowrap;
    }

    .tengah {
        vertical-align: middle !important;
    }
</style>
</html>
