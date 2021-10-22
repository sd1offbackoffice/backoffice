<!DOCTYPE html>
<html>

<head>
    <title>Laporan Rekap Perolehan Reward MyPoin</title>
</head>

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
        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">REKAP PEROLEHAN REWARD POIN</p>
{{--        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">REKAP PEROLEHAN REWARD MYPOIN</p>--}}
        <p style="text-align: center;margin: 0;padding: 0">Tgl : {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0,10)}}</p>
    </div>
</header>
<body>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th align="right" class="padding-right" width="5%">NO.</th>
            <th align="left">ID</th>
            <th align="left">MEMBER MERAH</th>
            <th align="left">POIN REWARD</th>
            <th align="right">POIN VALID</th>
            <th align="right">POIN INVALID</th>
        </tr>
        </thead>
        <tbody>
        @php
            //$total = 0;
            $total_valid=0;
            $total_invalid=0;
            $temptgl = '';
            $temp='';
            $tempNama = '';
            $number = 0;
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<count($data);$i++)


                @if($tempNama != $data[$i]->kodemember )
                    @php
                        $number++
                    @endphp
                    <tr>
                        <td align="right" class="padding-right">{{ $number }}</td>
                        <td align="left">{{ $data[$i]->kodemember }}</td>
                        <td align="left">{{ $data[$i]->namamember }}</td>
                        <td align="left"> {{ $data[$i]->js }}</td>
                        <td align="right">{{ number_format($data[$i]->tot_valid, 0,".",",") }}</td>
                        <td align="right">{{ isset($data[$i]->tot_notvalid) ?  number_format($data[$i]->tot_notvalid, 0,".",",") : 0}}</td>
                    </tr>
                @else
                    <tr>
                        <td align="right" class="padding-right"></td>
                        <td align="left"></td>
                        <td align="left"></td>
                        <td align="left"> {{ $data[$i]->js }}</td>
                        <td align="right">{{ number_format($data[$i]->tot_valid, 0,".",",") }}</td>
                        <td align="right">{{ isset($data[$i]->tot_notvalid) ?  number_format($data[$i]->tot_notvalid, 0,".",",") : 0}}</td>
                    </tr>
                @endif
                @php
                    $total_valid+=$data[$i]->tot_valid;
                    $total_invalid+=$data[$i]->tot_notvalid;
                    $tempNama = $data[$i]->kodemember;
                @endphp
            @endfor
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        <tr>
            <th style="border-right: 1px solid black;" colspan="2">Poin INTERN: {{ isset($t_pi)?number_format($t_pi, 0,".",","):0 }}</th>
            <th style="border-right: 1px solid black;" colspan="2">Poin EXTERN: {{ isset($t_pe)?number_format($t_pe, 0,".",","):0 }}</th>
            <th colspan="2" rowspan="2" >Total: {{  number_format($total, 0,".",",")}}</th>
        </tr>
        <tr>
            <th style="border-right: 1px solid black;" colspan="2">Poin Valid: {{ isset($total_valid)?number_format($total_valid, 0,".",","):0 }}</th>
            <th style="border-right: 1px solid black;" colspan="2">Poin Invalid: {{ isset($total_invalid)?number_format($total_invalid, 0,".",","):0 }}</th>
        </tr>
        <tr>
            <th style="border-top: 1px solid black;" colspan="6" class="right">** Akhir dari laporan **</th>
        </tr>
        </tfoot>
    </table>
<br>
</body>


<style>
    /*@page {*/
    /*    size: 500pt 750pt;*/
    /*}*/

    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 0cm;
        margin-bottom: 50px;
    }

    body {
        margin-top: 70px;
        /*margin-bottom: 10px;*/
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

    .table tbody td.padding-right, .table thead th.padding-right{
        padding-right: 10px !important;
    }
</style>
</html>
