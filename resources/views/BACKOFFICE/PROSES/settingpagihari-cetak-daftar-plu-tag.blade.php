<!DOCTYPE html>
<html>
<head>
    <title> LAPORAN SETTING PAGI HARI </title>
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
            {{ $perusahaan->prs_namacabang }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 10px !important;">
        <p>TANGGAL : {{ date("d-m-Y") }}<br><br>
            PROGRAM : SETTING PAGI HARI <br><br>
            JAM : {{ $datetime->format('H:i:s') }}<br><br>
    </div>
    <h2 style="text-align: center">** DAFTAR PLU TAG N, X **</h2>
</header>

<main>
    <table class="table table-responsive">
        <thead style="border-top: double; border-bottom: double;">
        <tr>
            <th class="tengah" width="5%">No.</th>
            <th class="tengah" style="text-align: left" width="10%">PLU</th>
            <th class="tengah" style="text-align: left" width="30%">Deskripsi</th>
            <th class="tengah" width="10%">Frac</th>
            <th class="tengah" width="10%">Tag</th>
            <th class="tengah" width="10%">Flag</th>
            <th class="tengah" width="10%">Qty</th>
            <th class="tengah" width="10%">OMI</th>
            <th class="tengah" width="5%">Rak</th>
        </tr>

        </thead>
        <tbody>
        @for($j = 0; $j < sizeof($data); $j++)
            @if($j == 0)
                <tr style="padding-top: 50px !important;">
                    <td colspan="13" style="text-align: left"><b>{{$data[$j]->prd_kodedivisi}} {{$data[$j]->prd_kodedepartement}} {{$data[$j]->prd_kodekategoribarang}}
                        - {{$data[$j]->div_namadivisi}}, {{$data[$j]->dep_namadepartement}}, {{$data[$j]->kat_namakategori}}</b></td>
                </tr>
                <tr>
                    <td colspan="13" style="border-bottom: 1px black solid"></td>
                </tr>
            @else
                @if($data[$j]->prd_kodedivisi != $data[$j-1]->prd_kodedivisi)
                    <tr>
                        <td colspan="13" style="border-bottom: 1px black solid"></td>
                    </tr>
                    <tr style="padding-top: 50px !important;">
                        <td colspan="13" style="text-align: left"><b>{{$data[$j]->prd_kodedivisi}} {{$data[$j]->prd_kodedepartement}} {{$data[$j]->prd_kodekategoribarang}}
                                - {{$data[$j]->div_namadivisi}}, {{$data[$j]->dep_namadepartement}}, {{$data[$j]->kat_namakategori}}</b></td>
                    </tr>
                    <tr>
                        <td colspan="13" style="border-bottom: 1px black solid"></td>
                    </tr>
                @elseif($data[$j]->prd_kodedepartement != $data[$j-1]->prd_kodedepartement)
                    <tr>
                        <td colspan="13" style="border-bottom: 1px black solid"></td>
                    </tr>
                    <tr style="padding-top: 50px !important;">
                        <td colspan="13" style="text-align: left"><b>{{$data[$j]->prd_kodedivisi}} {{$data[$j]->prd_kodedepartement}} {{$data[$j]->prd_kodekategoribarang}}
                                - {{$data[$j]->div_namadivisi}}, {{$data[$j]->dep_namadepartement}}, {{$data[$j]->kat_namakategori}}</b></td>
                    </tr>
                    <tr>
                        <td colspan="13" style="border-bottom: 1px black solid"></td>
                    </tr>
                @elseif($data[$j]->prd_kodekategoribarang != $data[$j-1]->prd_kodekategoribarang)
                    <tr>
                        <td colspan="13" style="border-bottom: 1px black solid"></td>
                    </tr>
                    <tr style="padding-top: 50px !important;">
                        <td colspan="13" style="text-align: left"><b>{{$data[$j]->prd_kodedivisi}} {{$data[$j]->prd_kodedepartement}} {{$data[$j]->prd_kodekategoribarang}}
                                - {{$data[$j]->div_namadivisi}}, {{$data[$j]->dep_namadepartement}}, {{$data[$j]->kat_namakategori}}</b></td>
                    </tr>
                    <tr>
                        <td colspan="13" style="border-bottom: 1px black solid"></td>
                    </tr>
                @endif
            @endif
            <tr>
                <td>{{ $j+1 }}</td>
                <td style="text-align: left">{{ $data[$j]->prd_prdcd }}</td>
                <td style="text-align: left">{{ $data[$j]->prd_deskripsipanjang }}</td>
                <td>{{ $data[$j]->prd_frac }}</td>
                <td>{{ $data[$j]->prd_kodetag }}</td>
                <td> </td>
                <td>{{ $data[$j]->st_saldoakhir }}</td>
                <td>{{ $data[$j]->omi }}</td>
                <td>{{ $data[$j]->lks_koderak }}</td>
            </tr>
        @endfor
        </tbody>
        <tr>
            <td colspan="13" style="border-bottom: 1px black solid"></td>
        </tr>
    </table>
</main>

<footer>
    <span class="right" style="float: right">** AKHIR LAPORAN **</span><span style="float: left" class="left">{{count($data)}} Item(s) Transferred</span>
</footer>

<br>
</body>
<style>
    @page {
        margin: 25px 20px;
        size: 595pt 842pt;
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
        font-size: 9px;
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

    .page-break {
        page-break-before: always;
    }

    .page-break-avoid{
        page-break-inside: avoid;
    }

    .table-header td{
        white-space: nowrap;
    }

    .blank-row
    {
        line-height: 70px!important;
        color: white;
    }

</style>
</html>
