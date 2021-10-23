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
            {{ $perusahaan->prs_namaperusahaan }}
        </p>
        <p>
            {{ $perusahaan->prs_namacabang }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px;">
        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>
        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>
        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>
    </div>
    <div style="float:center;">
        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">LAPORAN SALES TRANSAKSI / NILAI STRUK</p>
        {{--        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">REKAP PEROLEHAN REWARD MYPOIN</p>--}}
        <p style="text-align: center;margin: 0;padding: 0">Member : {{$member}} </p>
    </div>
</header>

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" align="left">Tanggal</th>
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
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
            <th class="padding-right">STRK</th>
            <th class="padding-right">TTL NILAI</th>
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
                    <td align="left">{{ date('d/m/Y',strtotime(substr($d->jh_transactiondate,0,10))) }}</td>
                    <td>{{ number_format($d->sn1, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa1, 0,".",",") }}</td>
                    <td>{{ number_format($d->sn2, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa2, 0,".",",") }}</td>
                    <td>{{ number_format($d->sn3, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa3, 0,".",",") }}</td>
                    <td>{{ number_format($d->sn4, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa4, 0,".",",") }}</td>
                    <td>{{ number_format($d->sn5, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa5, 0,".",",") }}</td>
                    <td>{{ number_format($d->sn6, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa6, 0,".",",") }}</td>
                    <td>{{ number_format($d->sn7, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa7, 0,".",",") }}</td>
                    <td>{{ number_format($d->sn8, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa8, 0,".",",") }}</td>
                    <td>{{ number_format($d->sn9, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa9, 0,".",",") }}</td>
                    <td>{{ number_format($d->sn10, 0,".",",") }}</td>
                    <td>{{ number_format($d->sa10, 0,".",",") }}</td>
                    <td>{{ number_format($sn, 0,".",",") }}</td>
                    <td>{{ number_format($sa, 0,".",",") }}</td>
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
            <td>{{ number_format($subsn1, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsn2, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsn3, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsn4, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsn5, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsn6, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsn7, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsn8, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsn9, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsn10, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($tot_sn, 0,".",",") }}</td>
            <td></td>
        </tr>
        <tr style="font-style: bold;text-align: center">
            <td></td>
            <td></td>
            <td>{{ number_format($subsa1, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsa2, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsa3, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsa4, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsa5, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsa6, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsa7, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsa8, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsa9, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($subsa10, 0,".",",") }}</td>
            <td></td>
            <td>{{ number_format($tot_sa, 0,".",",") }}</td>
        </tr>
        <tr>
            <th style="border-top: 1px solid black;" colspan="23" class="right">** Akhir dari laporan **</th>
        </tr>
        </tfoot>
    </table>
</body>


<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
    }

    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
    }

    body {
        margin-top: 70px;
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

    .table tbody td.padding-right, .table thead th.padding-right {
        padding-right: 3px !important;
    }
</style>
</html>
