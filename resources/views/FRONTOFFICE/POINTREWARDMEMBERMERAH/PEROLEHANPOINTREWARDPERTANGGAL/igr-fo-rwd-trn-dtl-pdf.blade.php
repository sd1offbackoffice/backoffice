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
            <b>{{ $perusahaan->prs_namaperusahaan }}</b>
        </p>
        <p>
            <b>{{ $perusahaan->prs_namacabang }}</b>
        </p>
    </div>
    <div style="float:right; margin-top: 0px;">
        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>
        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>
        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>
    </div>
    <div style="float:center;">
        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">RINCIAN PEROLEHAN REWARD
            POIN</p>
        {{--        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">REKAP PEROLEHAN REWARD MYPOIN</p>--}}
        <p style="text-align: center;margin: 0;padding: 0">Tgl : {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0,10)}}</p>
    </div>
</header>

<table class="table">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
        <th align="right" class="padding-right" width="1%">No.</th>
        <th align="left" width="8%">ID - MEMBER MERAH</th>
        <th align="right">STRUK</th>
        <th align="right">VALID</th>
        <th align="right" class="padding-right">INVALID</th>
        <th align="left">JENIS</th>
        <th align="left">KETERANGAN</th>
    </tr>
    </thead>
    <tbody>
    @php
        $subtotalpertanggal = 0;
        $total_valid=0;
        $total_invalid=0;
        $temptgl = '';
        $temp='';
        $tempNama='';
        $number=0;
    @endphp

    @if(sizeof($data)!=0)
        @for($i=0;$i<count($data);$i++)
            @if($temp != substr($data[$i]->tgl,0,10))
                @php
                    $time = strtotime(substr($data[$i]->tgl,0,10));
                    $newformat = date('d/m/Y',$time);
                @endphp
                <tr>
                    <th align="left">Tanggal : {{ $newformat }}</th>
                    <td colspan="6"></td>
                </tr>
            @endif
            @if($tempNama != $data[$i]->kodemember )
                @php
                    $number++
                @endphp
                <tr>
                    <td align="right" class="padding-right">{{ $number }}</td>
                    <td align="left">{{ $data[$i]->kodemember }}</td>
                    <td align="right">{{ $data[$i]->trn }}</td>
                    <td align="right">{{ number_format($data[$i]->valid, 0,".",",") }}</td>
                    <td align="right" class="padding-right">{{ number_format($data[$i]->notvalid, 0,".",",") }}</td>
                    <td align="left">{{ $data[$i]->js}}</td>
                    <td align="left">{{ $data[$i]->ket }}</td>
                </tr>
            @else
                <tr>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="right">{{ $data[$i]->trn }}</td>
                    <td align="right">{{ number_format($data[$i]->valid, 0,".",",") }}</td>
                    <td align="right" class="padding-right">{{ number_format($data[$i]->notvalid, 0,".",",") }}</td>
                    <td align="left">{{ $data[$i]->js}}</td>
                    <td align="left">{{ $data[$i]->ket }}</td>
                </tr>
            @endif

            @php
                $subtotalpertanggal=$subtotalpertanggal+$data[$i]->valid;
                 $total_valid=$total_valid+$data[$i]->valid;
                 $total_invalid=$total_invalid+$data[$i]->notvalid;
                 $temp = substr($data[$i]->tgl,0,10);
                 $tempNama = $data[$i]->kodemember;

            @endphp
            @if( isset($data[$i+1]->tgl) && $temp != substr($data[$i+1]->tgl,0,10) || !(isset($data[$i+1]->tgl)) )
                <tr>
                    <th colspan="3" class="right">Subtotal per Tgl :</th>
                    <th class="right">{{ number_format($subtotalpertanggal, 0,".",",")  }}</th>
                </tr>
                @php
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
        <th style="border-right: 1px solid black;" colspan="2">Poin INTERN: {{ isset($t_pi)?number_format($t_pi, 0,".",","):0 }}</th>
        <th style="border-right: 1px solid black;" colspan="3">Poin EXTERN: {{ isset($t_pe)?number_format($t_pe, 0,".",","):0 }}</th>
        <th colspan="2" rowspan="3" >Total: {{  number_format($total, 0,".",",")}}</th>
    </tr>
    <tr>
        <th style="border-right: 1px solid black;" colspan="2">Poin Valid: {{ isset($total_valid)?number_format($total_valid, 0,".",","):0 }}</th>
        <th style="border-right: 1px solid black;" colspan="3">Poin Invalid: {{ isset($total_invalid)?number_format($total_invalid, 0,".",","):0 }}</th>
    </tr>
    <tr>
        <th style="border-top: 1px solid black;" colspan="7" class="right">** Akhir dari laporan **</th>
    </tr>
    </tfoot>
</table>

<br>

</body>


<style>
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 3cm;
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

    .table tbody td.padding-right, .table thead th.padding-right {
        padding-right: 10px !important;
    }
</style>
</html>
