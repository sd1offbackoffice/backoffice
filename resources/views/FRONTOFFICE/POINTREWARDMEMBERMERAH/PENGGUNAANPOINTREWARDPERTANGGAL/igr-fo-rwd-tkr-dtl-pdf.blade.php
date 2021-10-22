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
        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">RINCIAN PENGGUNAAN REWARD POIN</p>
        {{--        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">REKAP PEROLEHAN REWARD MYPOIN</p>--}}
        <p style="text-align: center;margin: 0;padding: 0">Tgl : {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0,10)}}</p>
    </div>

</header>

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="4"></th>
            <th colspan="2" align="center" style="padding-left: 100px">---- Pembayaran ----</th>
            <th></th>
        </tr>
        <tr>
            <th align="right" class="padding-right" width="1%">No.</th>
            <th align="left" width="5%">ID</th>
            <th align="left">Member Merah</th>
            <th align="left">Struk</th>
            <th align="right">Trn.Normal</th>
            <th align="right">Trn.Redeem</th>
            <th align="right">Total Penggunaan</th>
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
            $number =1;
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<count($data);$i++)
                @if($temptgl != substr($data[$i]->tgl,0,10))
                <tr style="font-weight: bold">
                    <td align="left">Tanggal : {{ substr($data[$i]->tgl,0,10) }}</td>
                    <td colspan="6"></td>
                </tr>
                @endif
                <tr>
                    <td align="right" class="padding-right">{{ $number }}</td>
                    <td align="left">{{ $data[$i]->kodemember }}</td>
                    <td align="left">{{ $data[$i]->namamember }}</td>
                    <td align="left">{{ $data[$i]->trn }}</td>
                    <td align="right">{{ number_format($data[$i]->tkr, 0,".",",")}}</td>
                    <td align="right">{{ number_format($data[$i]->rdm, 0,".",",")}}</td>
                    <td align="right"> {{ number_format($data[$i]->tot_tkr, 0,".",",")}}</td>
                </tr>

                @php
                    $sub_tkr += $data[$i]->tkr;
                    $sub_rdm += $data[$i]->rdm;
                    $sub_tot_tkr += $data[$i]->tot_tkr;
                    $total_tkr += $data[$i]->tkr;
                    $total_rdm += $data[$i]->rdm;
                    $total_tot_tkr += $data[$i]->tot_tkr;
                    $temptgl = substr($data[$i]->tgl,0,10);
                    $number++;
                @endphp
                @if( isset($data[$i+1]->tgl) && $temptgl != substr($data[$i+1]->tgl,0,10) || !(isset($data[$i+1]->tgl)) )
                    <tr style="font-weight: bold">
                        <td colspan="3"></td>
                        <td align="right">Subtotal Per Tgl</td>
                        <td align="right">{{ number_format($sub_tkr, 0,".",",")  }}</td>
                        <td align="right">{{ number_format($sub_rdm, 0,".",",")  }}</td>
                        <td align="right">{{ number_format($sub_tot_tkr, 0,".",",")  }}</td>
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
            <td colspan="3"></td>
            <td align="right">Total</td>
            <td align="right">{{ number_format($total_tkr, 0,".",",")  }}</td>
            <td align="right">{{ number_format($total_rdm, 0,".",",")  }}</td>
            <td align="right">{{ number_format($total_tot_tkr, 0,".",",")  }}</td>
        </tr>
        <tr>
            <th style="border-top: 1px solid black;" colspan="7" class="right">** Akhir dari laporan **</th>
        </tr>
        </tfoot>
    </table>
</body>


<style>
    /*@page {*/
    /*    size: 750pt 500pt;*/
    /*}*/

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
    .table tbody td.padding-right, .table thead th.padding-right {
        padding-right: 10px !important;
    }
</style>
</html>
