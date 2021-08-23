<!DOCTYPE html>
<html>

<head>
    <title>Rincian Penggunaan Reward MyPoin</title>
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
    <h2 >Rincian Penggunaan Reward MyPoin <br>Tgl : {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0
,10)}} </h2>
    </div>

</header>

<main style="margin-top: 50px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="3"></th>
            <th colspan="2">---- Pembayaran ----</th>
            <th></th>
        </tr>
        <tr>
            <th>ID</th>
            <th>MEMBER MERAH</th>
            <th>Struk</th>
            <th>Trn.Normal</th>
            <th>Trn.Redeem</th>
            <th>Total<br>Penggunaan</th>
        </tr>
        </thead>
        <tbody>
        @php
            $sub_tkr = 0;
            $sub_rdm= 0;
            $sub_tot_tkr = 0;
            $total_tkr = 0;
            $total_rdm= 0;
            $total_tot_tkr = 0;
            $temptgl = '';
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<count($data);$i++)
                @if($temptgl != substr($data[$i]->tgl,0,10))
                <tr style="font-weight: bold">
                    <td>Tanggal</td>
                    <td>{{ substr($data[$i]->tgl,0,10) }}</td>
                    <td colspan="4"></td>
                </tr>
                @endif
                <tr>
                    <td>{{ $data[$i]->kodemember }}</td>
                    <td>{{ $data[$i]->namamember }}</td>
                    <td>{{ $data[$i]->trn }}</td>
                    <td>{{ $data[$i]->tkr}}</td>
                    <td>{{ $data[$i]->rdm }}</td>
                    <td>{{ $data[$i]->tot_tkr }}</td>
                </tr>

                @php
                    $sub_tkr += $data[$i]->tkr;
                    $sub_rdm += $data[$i]->rdm;
                    $sub_tot_tkr += $data[$i]->tot_tkr;
                    $total_tkr += $data[$i]->tkr;
                    $total_rdm += $data[$i]->rdm;
                    $total_tot_tkr += $data[$i]->tot_tkr;
                    $temptgl = substr($data[$i]->tgl,0,10);
                @endphp
                @if( isset($data[$i+1]->tgl) && $temptgl != substr($data[$i+1]->tgl,0,10) || !(isset($data[$i+1]->tgl)) )
                    <tr style="font-weight: bold">
                        <td colspan="2"></td>
                        <td>Subtotal Per Tgl</td>
                        <td>{{ $sub_tkr }}</td>
                        <td>{{ $sub_rdm }}</td>
                        <td>{{ $sub_tot_tkr }}</td>
                    </tr>
                    @php
                        $sub_tkr  =  0;
                        $sub_rdm  =  0;
                        $sub_tot_tkr =  0;
                    @endphp
                @endif
            @endfor
        @else
            <tr>
                <td colspan="6">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        <tr style="font-weight: bold;text-align: center">
            <td colspan="2"></td>
            <td>Total</td>
            <td>{{ $total_tkr }}</td>
            <td>{{ $total_rdm }}</td>
            <td>{{ $total_tot_tkr }}</td>
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
