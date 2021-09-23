<!DOCTYPE html>
<html>

<head>
    <title>LAPORAN REKAPITULASI REGISTER PPR IDM</title>

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
            TANGGAL : {{ substr(\Carbon\Carbon::now(),0,10) }}<br><br>
        </p>
    </div>
    <h2 style="text-align: center">** LAPORAN REKAPITULASI REGISTER PPR IDM ** </h2>
    <h4 style="text-align: center">
        {{ 'Member : '. $member1 .' - '. $member2 }}<br>
        {{ 'Tgl : '. substr($tgl1,0,10) .' - '. substr($tgl2,0,10) }}<br>
        {{ 'No. Dokumen : '. $nodoc1 .' - '. $nodoc2 }}<br>
    </h4>
</header>

<main style="margin-top: 50px;">
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th>MEMBER</th>
            <th>TOKO</th>
            <th>TANGGAL</th>
            <th>NO. NRB</th>
            <th>NO. DOKUMEN</th>
            <th>ITEM</th>
            <th>NILAI</th>
            <th>PPN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_harga = 0;
            $total_ppn = 0;
            $sub_harga = 0;
            $sub_ppn = 0;
            $member_temp = '';
        @endphp
        @if(sizeof($data)!=0)
            @for($i=0;$i<sizeof($data);$i++)
                @if($member_temp != $data[$i]->member)
                    <tr>
                        <td align="left">{{ $data[$i]->member }}</td>
                        <td>{{ $data[$i]->tko_kodeomi }}</td>
                        <td>{{ substr($data[$i]->trpt_salesinvoicedate,0,10)}}</td>
                        <td>{{ $data[$i]->trpt_invoicetaxno }}</td>
                        <td>{{ $data[$i]->trpt_salesinvoiceno }}</td>
                        <td>{{ $data[$i]->cf_item }}</td>
                        <td>{{ number_format($data[$i]->trpt_netsales,2) }}</td>
                        <td>{{ number_format($data[$i]->trpt_ppntaxvalue,2) }}</td>
                    </tr>

                @else
                    <tr>
                        <td align="left"></td>
                        <td>{{ $data[$i]->tko_kodeomi }}</td>
                        <td>{{ substr($data[$i]->trpt_salesinvoicedate,0,10)}}</td>
                        <td>{{ $data[$i]->trpt_invoicetaxno }}</td>
                        <td>{{ $data[$i]->trpt_salesinvoiceno }}</td>
                        <td>{{ $data[$i]->cf_item }}</td>
                        <td>{{ number_format($data[$i]->trpt_netsales,2) }}</td>
                        <td>{{ number_format($data[$i]->trpt_ppntaxvalue,2) }}</td>
                    </tr>
                @endif
                @php
                    $sub_harga += $data[$i]->trpt_netsales;
                    $sub_ppn += $data[$i]->trpt_ppntaxvalue;
                    $member_temp = $data[$i]->member;
                    $total_harga += $data[$i]->trpt_netsales;
                    $total_ppn += $data[$i]->trpt_ppntaxvalue;
                @endphp
                @if( isset($data[$i+1]->member) && $member_temp != $data[$i+1]->member || !(isset($data[$i+1]->member)) )
                    <tr>
                        <td colspan="6" align="right"><b> SUB TOTAL :</b></td>
                        <td>{{ number_format($sub_harga,2) }}</td>
                        <td>{{ number_format($sub_ppn,2) }}</td>
                    </tr>
                    @php
                        $sub_harga =0;
                        $sub_ppn =0;
                    @endphp
                @endif

            @endfor
        @else
            <tr>
                <td colspan="8">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6" align="right"><b>TOTAL</b></td>
            <td align="center">{{ number_format($total_harga,2) }}</td>
            <td align="center">{{ number_format($total_ppn,2) }}</td>
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
        margin-top: 100px;
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
