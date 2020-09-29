@if(count($tolakan) == 0)
    <head>
        <title>Laporan Tolakan PB by Divisi {{ $tgl1 }} - {{ $tgl2 }}</title>
    </head>
    <p style="text-align: center"><strong>** DATA TIDAK ADA **</strong></p>
@else
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tolakan PB by Divisi {{ $tgl1 }} - {{ $tgl2 }}</title>
</head>
<body>
<!-- <a href="/getPdf"><button>Download PDF</button></a> -->

<?php
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
<header>
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>{{ $perusahaan->prs_namaperusahaan }}<br><br>
            {{ $perusahaan->prs_namacabang }}<br><br>
            {{ $perusahaan->prs_namaregional }}</p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>TGL : {{ date("d-m-Y") }}<br><br>
            JAM : {{ $datetime->format('H:i:s') }}<br><br>
            PGM : IGR_BO_CTKTLKNPB</p>
    </div>
    <p style="text-align: center"><strong style="font-size: 10">{{ $title }}</strong><br>TANGGAL : {{ $tgl1 }} s/d {{ $tgl2 }}</p>
</header>

<footer>

</footer>

<main>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="font-size: 9px">
            <td colspan="2" style="text-align: left"><strong>TANGGAL<span style="display:inline-block; width:15;"></span>DOKUMEN</strong></td>
            <td colspan="5"></td>
        </tr>
        <tr>
            <td width="5%">PLU</td>
            <td width="25%">DESKRIPSI</td>
            <td width="5%" class="kanan">SATUAN</td>
            <td width="2%" class="tengah">TAG</td>
            <td width="22%">SUPPLIER</td>
            <td width="3%">PKMT</td>
            <td width="38%">KETERANGAN</td>
        </tr>
        </thead>
        <tbody>
        @php
            $tgl = '';
            $nopb = '';
            $div = '';
            $dep = '';
            $kat = '';
        @endphp
        @foreach($tolakan as $t)
            @if($tgl != $t->tglpb && $nopb != $t->nopb)
                @php
                    $tgl = $t->tglpb;
                    $nopb = $t->nopb;
                @endphp
                <tr style="font-size: 9px">
                    <td colspan="2" style="text-align: left"><strong>{{ $t->tglpb }}<span style="display:inline-block; width:15;"></span>{{ $t->nopb }}</strong></td>
                    <td colspan="5"></td>
                </tr>
            @endif
            @if($div != $t->div || $dep != $t->dep || $kat != $t->kat)
                @php
                    $div = $t->div;
                    $dep = $t->dep;
                    $kat = $t->kat;
                @endphp
                <tr>
                    <td colspan="7" style="font-size: 9px">
                        <strong>
                        DIV : {{ $t->div }} - {{ $t->divname }}<span style="display:inline-block; width:15;"></span>
                        DEPT : {{ $t->dep }} - {{ $t->depname }}<span style="display:inline-block; width:15;"></span>
                        KAT : {{ $t->kat }} - {{ $t->katname }}
                        </strong>
                    </td>
                </tr>
            @endif
            <tr>
                <td width="5%">{{ $t->prdcd }}</td>
                <td width="25%">{{ $t->deskripsi }}</td>
                <td width="5%" class="kanan">{{ $t->satuan }}</td>
                <td width="2%" class="tengah">{{ $t->tag }}</td>
                <td width="22%">{{ $t->supco }} - {{ $t->supname }}</td>
                <td width="3%" class="tengah">{{ $t->pkmt }}</td>
                <td width="38%">{{ $t->keterangan }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>

    <hr>
    <strong style="float:right">** Akhir Dari Laporan **</strong>
</main>

<br>
</body>
<style>
    @page {
        margin: 25px 25px;
        /*size: 1071pt 792pt;*/
        size: 595pt 842pt;
    }

    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }
    body {
        margin-top: 70px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
    }

    table{
        border-collapse: collapse;
        font-size: 7px;
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
    .table{
        width: 100%;
        white-space: nowrap;
        color: #212529;
        /*padding-top: 20px;*/
        margin-top: 25px;
    }
    .kanan{
        text-align: right;
    }

    .tengah{
        text-align: center;
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

    .tengah{
        text-align: center;
    }

</style>
</html>
@endif
