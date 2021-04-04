<!DOCTYPE html>
<html>
<head>
    <title>Kertas Kerja Status</title>
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
            Total record : {{ count($data) }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>Tgl. Cetak : {{ date("d/m/Y") }}<br><br>
            Jam Cetak : {{ $datetime->format('H:i:s') }}<br><br>
            <i>User ID</i> : {{ $_SESSION['usid'] }}<br><br>
            Hal. :
    </div>
    <h2 style="text-align: center">** KERTAS KERJA STATUS **<br>Periode : {{ $periode }}</h2>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">RAK</th>
            <th class="tengah" rowspan="2">SR</th>
            <th class="tengah" rowspan="2">TR</th>
            <th class="tengah" rowspan="2">SH</th>
            <th class="tengah" rowspan="2">NU</th>
            <th class="tengah" rowspan="2">DIV</th>
            <th class="tengah" rowspan="2">DEP</th>
            <th class="tengah" rowspan="2">KAT</th>
            <th class="tengah" rowspan="2">PLU</th>
            <th class="tengah" rowspan="2">DESKRIPSI</th>
            <th class="tengah" rowspan="2">TAG</th>
            <th class="tengah" rowspan="2">ITM_PRT</th>
            <th class="tengah" rowspan="2">FRAC</th>
            <th class="tengah" colspan="3">---- AVG SALES IN PCS ----</th>
            <th class="tengah" rowspan="2">MINOR</th>
            <th class="tengah" rowspan="2">MINDIS</th>
            <th class="tengah" rowspan="2">LT</th>
            <th class="tengah" rowspan="2">%SL</th>
            <th class="tengah" rowspan="2">KOEF</th>
            <th class="tengah" rowspan="2">PKM</th>
            <th class="tengah" rowspan="2">MPKM</th>
            <th class="tengah" rowspan="2">M+</th>
            <th class="tengah" rowspan="2">PKMT</th>
            <th class="tengah" rowspan="2">PKMT+<br>50%MINOR</th>
            <th class="tengah" rowspan="2">MAX_DIS</th>
            <th class="tengah" rowspan="2">MAX_PLT</th>
            <th class="tengah" rowspan="2">ROW_SB</th>
            <th class="tengah" rowspan="2">ROW_SK</th>
            <th class="tengah" rowspan="2">%SK</th>
            <th class="tengah" rowspan="2">QTY_SK</th>
            <th class="tengah" rowspan="2">STS_RMS</th>
            <th class="tengah" rowspan="2">EXIS_STS</th>
            <th class="tengah" rowspan="2">ADJ_STS</th>
            <th class="tengah" rowspan="2">OMI/IDM</th>
            <th class="tengah" rowspan="2">MAX_PLANO<br>OMI</th>
            <th class="tengah" rowspan="2">MINPCT<br>OMI(%)</th>
            <th class="tengah" colspan="3">DIMENSI</th>
            <th class="tengah" rowspan="2">VOL<br>(CM3)</th>
            <th class="tengah" rowspan="2">MAX_PLANO<br>TOKO</th>
            <th class="tengah" rowspan="2">MINPCS<br>TOKO(%)</th>
        </tr>
        <tr>
            <th>IGR</th>
            <th>IDM/OMI</th>
            <th>TTL AVG</th>
            <th>P</th>
            <th>L</th>
            <th>T</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            @php
                $pkmt50minor = $d->pkmt + 0.5 * $d->minor;
                $qtysk = round($d->maxpallet * ($rowsk/$rowsb*50) / 100);
            @endphp
            <tr>
                <td>{{ $d->rak }}</td>
                <td>{{ $d->sr }}</td>
                <td>{{ $d->tr }}</td>
                <td>{{ $d->sh }}</td>
                <td>{{ $d->nu }}</td>
                <td>{{ $d->div }}</td>
                <td>{{ $d->dep }}</td>
                <td>{{ $d->kat }}</td>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->deskripsi }}</td>
                <td>{{ $d->tag }}</td>
                <td>{{ $d->cp_prt }}</td>
                <td>{{ $d->frac }}</td>
                <td>{{ $d->igr == 0 ? 0 : round($d->igr / $d->hariigr) }}</td>
                <td>{{ $d->omi == 0 ? 0 : round($d->omi / $d->hariomi) }}</td>
                <td>{{ ($d->igr == 0 ? 0 : round($d->igr / $d->hariigr)) + ($d->omi == 0 ? 0 : round($d->omi / $d->hariomi)) }}</td>
                <td>{{ $d->minor }}</td>
                <td>{{ $d->mindisplay }}</td>
                <td>{{ $d->lt }}</td>
                <td>{{ $d->sl }}</td>
                <td>{{ $d->koef }}</td>
                <td>{{ $d->pkm }}</td>
                <td>{{ $d->mpkm }}</td>
                <td>{{ $d->mplus }}</td>
                <td>{{ $d->pkmt }}</td>
                <td>{{ $pkmt50minor }}</td>
                <td>{{ $d->maxdisplay }}</td>
                <td>{{ $d->maxpallet }}</td>
                <td>{{ $rowsb }}</td>
                <td>{{ $rowsk }}</td>
                <td>{{ round($rowsk/$rowsb*50) }}</td>
                <td>{{ $qtysk }}</td>
                <td>
                    @if($pkmt50minor > $qtysk)
                        S
                    @elseif($pkmt50minor > $d->maxdisplay && $pkmt50minor < $qtysk)
                        SK
                    @elseif($pkmt50minor <= $d->maxdisplay)
                        NS
                    @endif
                </td>
                <td>{{ $d->pln_sts }}</td>
                <td>{{ $d->adj_sts }}</td>
                <td>{{ $d->j_omi_idm }}</td>
                <td>{{ $d->maxplano_omi }}</td>
                <td>{{ $d->minpct_omi }}</td>
                <td>{{ $d->p }}</td>
                <td>{{ $d->l }}</td>
                <td>{{ $d->t }}</td>
                <td>{{ $d->volume }}</td>
                <td>{{ $d->maxplano_toko }}</td>
                <td>{{ $d->minpct_toko }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="44" class="right">** Akhir dari laporan **</td>
        </tr>
        </tfoot>
    </table>
</main>

<br>
</body>
<style>
    @page {
        /*margin: 25px 20px;*/
        size: 1071pt 792pt;
        /*size: 595pt 842pt;*/
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
