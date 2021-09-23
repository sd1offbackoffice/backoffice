<!DOCTYPE html>
<html>

<head>
    <title>Laporan Promosi per Rak Reguler</title>

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
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>
            TANGGAL : {{ substr(\Carbon\Carbon::now(),0,10) }}<br><br>
        </p>
    </div>
    <h2 style="text-align: center">Laporan Promosi per Rak Reguler</h2>
</header>

<main style="margin-top: 50px;">
    <p>
        Rak : {{ $koderak1 }}<br><br>
    </p>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>NO</th>
            <th>PLU</th>
            <th align="left">DESKRIPSI</th>
            <th>TGL AWAL</th>
            <th>TGL AKHIR</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $i=1;
            $tempsubrak = '';
            $tempshelving = '';
            $tempcborgf = '';
            $temppromosi = '';
        @endphp

        @if(sizeof($data)!=0)
            @foreach($data as $d)
                @if($tempsubrak != $d->subrak)
                    <tr style="border-top: 1px solid">
                        <td colspan="5" class="left"><b>Sub Rak : </b> {{$d->subrak}} </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>Shelving : </b>{{$d->shelving}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>Promosi : </b>{{$d->cborgf}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>{{$d->promosi}} - {{$d->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $tempsubrak=$d->subrak;
                        $tempshelving = $d->shelving;
                        $tempcborgf = $d->cborgf;
                        $temppromosi = $d->promosi;
                    @endphp
                @endif;
                @if($tempshelving != $d->shelving)
                    <tr>
                        <td colspan="5" class="left"><b>Shelving : </b>{{$d->shelving}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>Promosi : </b>{{$d->cborgf}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>{{$d->promosi}} - {{$d->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $tempshelving = $d->shelving;
                        $tempcborgf = $d->cborgf;
                        $temppromosi = $d->promosi;
                    @endphp
                @endif;
                @if($tempcborgf != $d->cborgf)
                    <tr>
                        <td colspan="5" class="left"><b>Promosi : </b>{{$d->cborgf}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>{{$d->promosi}} - {{$d->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $tempcborgf = $d->cborgf;
                        $temppromosi = $d->promosi;
                    @endphp
                @endif;
                @if($temppromosi != $d->promosi)
                    <tr>
                        <td colspan="5" class="left"><b>{{$d->promosi}} - {{$d->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $temppromosi = $d->promosi;
                    @endphp
                @endif;
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $d->plu }}</td>
                    <td align="left">{{ $d->descpen}}</td>
                    <td>{{ substr($d->cbh_tglawal,0,10) }}</td>
                    <td>{{ substr($d->cbh_tglakhir,0,10) }}</td>
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot></tfoot>
    </table>
</main>

<br>
</body>


<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: 600pt 500pt;
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
