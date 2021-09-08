<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN SALES TRANSAKSI / NILAI STRUK</title>

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
            PRG : IGR FO TRN PERNSTRUK<br>
        </p><br><br>
    </div>
    <h2 style="text-align: center"> LAPORAN SALES TRANSAKSI / NILAI STRUK </h2>
    <h2 style="text-align: center"> Member : {{$member}} </h2>
</header>

<main style="margin-top: 50px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2">Tanggal</th>
            <th colspan="2">{{$bb1}}-{{$ba1}}</th>
            <th colspan="2">{{$bb2}}-{{$ba2}}</th>
            <th colspan="2">{{$bb3}}-{{$ba3}}</th>
            <th colspan="2">{{$bb4}}-{{$ba4}}</th>
            <th colspan="2">{{$bb5}}-{{$ba5}}</th>
            <th colspan="2">{{$bb6}}-{{$ba6}}</th>
            <th colspan="2">{{$bb7}}-{{$ba7}}</th>
            <th colspan="2">{{$bb8}}-{{$ba8}}</th>
            <th colspan="2">{{$bb9}}-{{$ba9}}</th>
            <th colspan="2">{{$bb10}}-{{$ba10}}</th>
            <th rowspan="2" colspan="2">TOTAL</th>
        </tr>
        <tr>
            <th>STRK</th>
            <th>TTL NILAI</th>
            <th>STRK</th>
            <th>TTL NILAI</th>
            <th>STRK</th>
            <th>TTL NILAI</th>
            <th>STRK</th>
            <th>TTL NILAI</th>
            <th>STRK</th>
            <th>TTL NILAI</th>
            <th>STRK</th>
            <th>TTL NILAI</th>
            <th>STRK</th>
            <th>TTL NILAI</th>
            <th>STRK</th>
            <th>TTL NILAI</th>
            <th>STRK</th>
            <th>TTL NILAI</th>
            <th>STRK</th>
            <th>TTL NILAI</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $i=1;

            $subsn1=0;
            $subsn2=0;
            $subsn3=0;
            $subsn4=0;
            $subsn5=0;
            $subsn6=0;
            $subsn7=0;
            $subsn8=0;
            $subsn9=0;
            $subsn10=0;

            $subsa1=0;
            $subsa2=0;
            $subsa3=0;
            $subsa4=0;
            $subsa5=0;
            $subsa6=0;
            $subsa7=0;
            $subsa8=0;
            $subsa9=0;
            $subsa10=0;
            $tot_sn=0;
            $tot_sa=0;
        @endphp

        @if(sizeof($data)!=0)
            @foreach($data as $d)
                @php
                    $sn = $d->sn1 + $d->sn2 + $d->sn3 + $d->sn4 + $d->sn5 + $d->sn6 + $d->sn7 + $d->sn8 + $d->sn9 + $d->sn10;
                    $sa = $d->sa1 + $d->sa2 + $d->sa3 + $d->sa4 + $d->sa5 + $d->sa6 + $d->sa7 + $d->sa8 + $d->sa9 + $d->sa10;
                @endphp
                <tr>
                    <td>{{substr($d->jh_transactiondate,0,10) }}</td>
                    <td>{{ $d->sn1 }}</td>
                    <td>{{ $d->sa1 }}</td>
                    <td>{{ $d->sn2 }}</td>
                    <td>{{ $d->sa2 }}</td>
                    <td>{{ $d->sn3 }}</td>
                    <td>{{ $d->sa3 }}</td>
                    <td>{{ $d->sn4 }}</td>
                    <td>{{ $d->sa4 }}</td>
                    <td>{{ $d->sn5 }}</td>
                    <td>{{ $d->sa5 }}</td>
                    <td>{{ $d->sn6 }}</td>
                    <td>{{ $d->sa6 }}</td>
                    <td>{{ $d->sn7 }}</td>
                    <td>{{ $d->sa7 }}</td>
                    <td>{{ $d->sn8 }}</td>
                    <td>{{ $d->sa8 }}</td>
                    <td>{{ $d->sn9 }}</td>
                    <td>{{ $d->sa9 }}</td>
                    <td>{{ $d->sn10 }}</td>
                    <td>{{ $d->sa10 }}</td>
                    <td>{{ $sn }}</td>
                    <td>{{ $sa }}</td>
                </tr>
                @php
                    $subsn1+=$d->sn1;
                    $subsn2+=$d->sn2;
                    $subsn3+=$d->sn3;
                    $subsn4+=$d->sn4;
                    $subsn5+=$d->sn5;
                    $subsn6+=$d->sn6;
                    $subsn7+=$d->sn7;
                    $subsn8+=$d->sn8;
                    $subsn9+=$d->sn9;
                    $subsn10+=$d->sn10;

                    $subsa1+=$d->sa1;
                    $subsa2+=$d->sa2;
                    $subsa3+=$d->sa3;
                    $subsa4+=$d->sa4;
                    $subsa5+=$d->sa5;
                    $subsa6+=$d->sa6;
                    $subsa7+=$d->sa7;
                    $subsa8+=$d->sa8;
                    $subsa9+=$d->sa9;
                    $subsa10+=$d->sa10;

                $tot_sn += $sn;
                $tot_sa += $sa;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif


        </tbody>
        <tfoot>
        <tr style="font-style: bold;text-align: center">
            <td></td>
            <td>{{ $subsn1 }}</td>
            <td>{{ $subsa1 }}</td>
            <td>{{ $subsn2 }}</td>
            <td>{{ $subsa2 }}</td>
            <td>{{ $subsn3 }}</td>
            <td>{{ $subsa3 }}</td>
            <td>{{ $subsn4 }}</td>
            <td>{{ $subsa4 }}</td>
            <td>{{ $subsn5 }}</td>
            <td>{{ $subsa5 }}</td>
            <td>{{ $subsn6 }}</td>
            <td>{{ $subsa6 }}</td>
            <td>{{ $subsn7 }}</td>
            <td>{{ $subsa7 }}</td>
            <td>{{ $subsn8 }}</td>
            <td>{{ $subsa8 }}</td>
            <td>{{ $subsn9 }}</td>
            <td>{{ $subsa9 }}</td>
            <td>{{ $subsn10 }}</td>
            <td>{{ $subsa10 }}</td>
            <td>{{ $tot_sn }}</td>
            <td>{{ $tot_sa }}</td>
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
