<!DOCTYPE html>
<html>

<head>
    <title>Laporan Rincian Perolehan Reward MyPoin</title>
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
    <h2 style="text-align: center">Rincian Perolehan Reward MyPoin <br>Tgl : {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0,10)}} </h2>
</header>

<main style="margin-top: 50px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>ID MEMBER MERAH</th>
            <th>STRUK</th>
            <th>VALID</th>
            <th>INVALID</th>
            <th>JENIS</th>
            <th>KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $subtotalpertanggal = 0;
            $total_valid=0;
            $total_invalid=0;
            $temptgl = '';
            $temp='';
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<count($data);$i++)
                @if($temp != $data[$i]->tgl)
                    <tr>
                        <td>Tanggal :</td>
                        <td>{{ substr($data[$i]->tgl,1,10) }}</td>
                        <td colspan="4"></td>
                    </tr>
                @endif
                <tr>
                    <td>{{ $data[$i]->kodemember }}</td>
                    <td>{{ $data[$i]->trn }}</td>
                    <td>{{ $data[$i]->valid}}</td>
                    <td>{{ $data[$i]->notvalid }}</td>
                    <td class="right">{{ $data[$i]->js }}</td>
                    <td class="right">{{ $data[$i]->ket }}</td>
                </tr>
                @php
                    $subtotalpertanggal+=$subtotalpertanggal+$data[$i]->jml;
                     $total_valid+=$total_valid+$data[$i]->valid;
                     $total_invalid+=$total_invalid+$data[$i]->notvalid;
                @endphp
                @if( isset($datas[$i+1]->tgl) && $temptgl != $datas[$i+1]->tgl || !(isset($datas[$i+1]->tgl)) )
                    <tr>
                        <td colspan="3" class="right">Subtotal per Tgl :</td>
                        <td class="right">{{ $subtotalpertanggal }}</td>
                    </tr>
                    @php
                        $temp = $data[$i]->tgl;
                        $subtotalpertanggal = 0;
                    @endphp
                @endif
            @endfor
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif


        </tbody>
        <tfoot>
        <tr>
            <td >mypoin INTRN:</td>
            <td>{{ $t_pi }}</td>
            <td >mypoin EXTRN:</td>
            <td>{{ $t_pe }}</td>
            <td rowspan="2">Total Mypoin:</td>
            <td rowspan="2">{{ $total }}</td>
        </tr>
        <tr>
            <td>mypoin Valid:</td>
            <td>{{ $total_valid }}</td>
            <td >mypoin Invalid:</td>
            <td>{{ $total_invalid }}</td>
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
