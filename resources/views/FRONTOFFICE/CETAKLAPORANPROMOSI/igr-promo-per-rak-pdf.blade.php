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
            {{ $perusahaan->prs_namaperusahaan }}
        </p>
        <p>
            {{ $perusahaan->prs_namacabang }}
        </p>
        <br>
    </div>
    <div style="float:right; margin-top: 0px;">
        Tgl. Cetak : {{ e(date("d/m/Y")) }}<br>
        Jam. Cetak : {{ $datetime->format('H:i:s') }}<br>
        <i>User ID</i> : {{ $_SESSION['usid'] }}<br>
    </div>
    <div>
        <p style="font-weight:bold;font-size:14px;text-align: center;margin: 0;padding: 0">LAPORAN PROMOSI PER RAK REGULER</p>
    </div>

</header>

        @php
            $total = 0;
            $no=1;
            $temprak = '';
            $tempsubrak = '';
            $tempshelving = '';
            $tempcborgf = '';
            $temppromosi = '';
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<sizeof($data);$i++)
                @if($temprak != $data[$i]->rak)
                        <table class="table">
                            <thead>
                            <tr>
                                <th align="left" style="font-size: 10px">Rak : {{ $data[$i]->rak }}</th>
                            </tr>
                            <tr>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" align="right" class="padding-right">NO.</th>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" align="left">PLU</th>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" align="left">DESKRIPSI</th>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" align="left">TGL AWAL</th>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" align="left">TGL AKHIR</th>
                            </tr>
                            </thead>
                        @php
                            $temprak=$data[$i]->rak;
                        @endphp
                @endif
                @if($tempsubrak != $data[$i]->subrak)
                </tbody>
                    <tr style="border-top: 1px solid">
                        <td colspan="5" class="left"><b>Sub Rak : </b> {{$data[$i]->subrak}} </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>Shelving : </b>{{$data[$i]->shelving}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>Promosi : </b>{{$data[$i]->cborgf}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>{{$data[$i]->promosi}} - {{$data[$i]->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $tempsubrak=$data[$i]->subrak;
                        $tempshelving = $data[$i]->shelving;
                        $tempcborgf = $data[$i]->cborgf;
                        $temppromosi = $data[$i]->promosi;
                    @endphp
                @endif
                @if($tempshelving != $data[$i]->shelving)
                    <tr>
                        <td colspan="5" class="left"><b>Shelving : </b>{{$data[$i]->shelving}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>Promosi : </b>{{$data[$i]->cborgf}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>{{$data[$i]->promosi}} - {{$data[$i]->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $tempshelving = $data[$i]->shelving;
                        $tempcborgf = $data[$i]->cborgf;
                        $temppromosi = $data[$i]->promosi;
                    @endphp
                @endif
                @if($tempcborgf != $data[$i]->cborgf)
                    <tr>
                        <td colspan="5" class="left"><b>Promosi : </b>{{$data[$i]->cborgf}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>{{$data[$i]->promosi}} - {{$data[$i]->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $tempcborgf = $data[$i]->cborgf;
                        $temppromosi = $data[$i]->promosi;
                    @endphp
                @endif
                @if($temppromosi != $data[$i]->promosi)
                    <tr>
                        <td colspan="5" class="left"><b>{{$data[$i]->promosi}} - {{$data[$i]->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $temppromosi = $data[$i]->promosi;
                    @endphp
                @endif
                <tr>
                    <td align="right" class="padding-right">{{ $no }}</td>
                    <td align="left">{{ $data[$i]->plu }}</td>
                    <td align="left">{{ $data[$i]->descpen}}</td>
                    <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->cbh_tglawal,0,10))) }}</td>
                    <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->cbh_tglakhir,0,10))) }}</td>
                </tr>
                @if( (isset($data[$i+1]->rak) && $temprak != $data[$i+1]->rak) || !isset($data[$i+1]->rak) )
                        </tbody>
                        </table>
                @endif
                @php
                    $no++;
                @endphp
            @endfor
        @else
            <p align="center"> TIDAK ADA DATA </p>
        @endif
        <br>
            <p style="border-top: 1px solid black" class="right">** Akhir dari laporan **</p>


<br>
</body>


<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        /*size: 600pt 500pt;*/
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
        padding-right: 10px !important;
    }
</style>
</html>
