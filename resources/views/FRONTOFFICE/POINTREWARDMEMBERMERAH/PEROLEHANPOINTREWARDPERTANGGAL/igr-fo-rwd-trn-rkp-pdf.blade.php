<!DOCTYPE html>
<html>

<head>
    <title>Laporan Rekap Perolehan Reward MyPoin</title>
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
            {{ $perusahaan->prs_namacabang }}<br><br><br>
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>
            TGL : {{ e(date("d-m-Y")) }}<br>
            JAM : {{ $datetime->format('H:i:s') }}
        </p>
    </div>
    <div style="text-align: center;margin-bottom: 0;padding-bottom: 0">
    <h2 >Rekap Perolehan Reward MyPoin <br>Tgl : {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0,10)}} </h2>
    </div>

</header>

<main style="margin-top: 50px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>NO.</th>
            <th>ID</th>
            <th>MEMBER MERAH</th>
            <th>POIN REWARD</th>
            <th>POIN VALID</th>
            <th>POIN INVALID</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $total_valid=0;
            $total_invalid=0;
            $temptgl = '';
            $temp='';
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<count($data);$i++)

                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $data[$i]->kodemember }}</td>
                    <td>{{ $data[$i]->namamember }}</td>
                    <td>{{ $data[$i]->js }}</td>
                    <td>{{ $data[$i]->tot_valid}}</td>
                    <td>{{ $data[$i]->tot_notvalid }}</td>
                </tr>
                @php
                    $total_valid+=$data[$i]->tot_valid;
                    $total_invalid+=$data[$i]->tot_notvalid;
                    $total+=$data[$i]->tot_jml;
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
            <th>mypoin INTRN:</th>
            <th>{{ isset($t_pi)?$t_pi:0 }}</th>
            <th>mypoin EXTRN:</th>
            <th>{{ isset($t_pe)?$t_pe:0 }}</th>
            <th rowspan="2">Total:</th>
            <th rowspan="2">{{ $total }}</th>
        </tr>
        <tr>
            <th>mypoin Valid:</th>
            <th>{{ isset($total_valid)?$total_valid:0 }}</th>
            <th>mypoin Invalid:</th>
            <th>{{ isset($total_invalid)?$total_invalid:0 }}</th>
        </tr>
        </tfoot>
    </table>
</main>

<br>
</body>


<style>
    @page {
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
