<!DOCTYPE html>
<html>

<head>
    <title>Report</title>

</head>
<body>
@php
    $datetime = new DateTime();
    $timezone = new DateTimeZone('Asia/Jakarta');
    $datetime->setTimezone($timezone);
    $temp_docno2 ='';
@endphp
@for($i=0;$i<sizeof($data);$i++)
@php
    $bulan = '';
    if (substr($data[$i]->mstd_date2, 4, 2) == '01') {
        $bulan = 'JANUARI';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '02') {
        $bulan = 'FEBRUARI';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '03') {
        $bulan = 'MARET';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '04') {
        $bulan = 'APRIL';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '05') {
        $bulan = 'MEI';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '06') {
        $bulan = 'JUNI';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '07') {
        $bulan = 'JULI';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '08') {
        $bulan = 'AGUSTUS';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '09') {
        $bulan = 'SEPTEMBER';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '10') {
        $bulan = 'OKTOBER';
    } else if (substr($data[$i]->mstd_date2, 4, 2) == '11') {
        $bulan = 'NOVEMBER';
    } else {
        $bulan = 'DESEMBER';
    }
    $cf_fakturpjk = '';
    $cf_nofak = '';
    $f_1 = '';
    $flag = '';
    $faktur = '';
    $cf_skp_sup = '';

    $cf_fakturpjk = $data[$i]->mstd_istype . '.' . $data[$i]->mstd_invno;
    $cf_nofak = $data[$i]->prs_kodemto . '.' . substr($data[$i]->msth_tgldoc, 8, 2) . '.0' . $data[$i]->mstd_docno2 . $data[$i]->msth_flagdoc == 'T' ? '*' : '';
    if ($data[$i]->sup_tglsk) {
        $cf_skp_sup = $data[$i]->sup_nosk . ' Tanggal PKP : ' . date('d-M-y', strtotime(substr($data[$i]->sup_tglsk, 0, 10)));
    } else {
        $cf_skp_sup = $data[$i]->sup_nosk;
    }
    $f_1 = $data[$i]->sup_namanpwp ? $data[$i]->sup_namanpwp : $data[$i]->sup_namasupplier . " " . $data[$i]->sup_singkatansupplier;
    $flag = $data[$i]->msth_flagdoc==1?'*':'';
    $faktur = $data[$i]->prs_kodemto.'.' . substr($data[$i]->msth_tgldoc,9,2) . '.0'.$data[$i]->mstd_docno2.$flag;
@endphp
@if($temp_docno2!=$data[$i]->mstd_docno2)
    @php
        $temp_docno2 = $data[$i]->mstd_docno2;
    @endphp
    <table class="table ml-2" style="font-size: 8px; table-layout: fixed;margin-top: -50px">
        <tr>
            <td colspan="3"></td>
            <td>{{$faktur}}</td>
        </tr>
        <tr>
            <td width="50px"></td>
            <td>{{$data[$i]->mstd_istype.'.'.$data[$i]->mstd_invno}}</td>
            <td>{{date('d-m-y', strtotime(substr($data[$i]->mstd_date3, 0, 10)))}}</td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="3" >{{$cf_fakturpjk}} {{$f_1}}</td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="3">{{ $perusahaan->prs_namaperusahaan }}</td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="3">{{ $data[$i]->const_addr }}</td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="3">{{ $data[$i]->prs_npwp }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="3">{{ $data[$i]->sup_namasupplier }}</td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="3">{{ $data[$i]->addr_sup }}</td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="3">{{ $data[$i]->sup_npwp }}</td>
        </tr>
        <tr>
            <td></td>
            <td align="left" colspan="3">{{ $cf_skp_sup }}</td>
        </tr>
    </table>
    <br><br>
    <table class="table">
        <tbody>
    @endif
        @php
           $total = 0;
           $no=1;
           $nqty2    = floor($data[$i]->mstd_qty/$data[$i]->mstd_frac);
           $nqtyk     = $data[$i]->mstd_qty % $data[$i]->mstd_frac;
           if ($data[$i]->mstd_unit =='KG '){
                $nqty    = (((floor($data[$i]->mstd_qty/$data[$i]->mstd_frac)) * $data[$i]->mstd_frac) + (($data[$i]->mstd_qty % $data[$i]->mstd_frac))) / $data[$i]->mstd_frac;
           }
           else{
                $nqty    = ((floor($data[$i]->mstd_qty/$data[$i]->mstd_frac)) * $data[$i]->mstd_frac) + ($data[$i]->mstd_qty % $data[$i]->mstd_frac);
           }
           $ngross  = $data[$i]->mstd_gross - $data[$i]->mstd_discrph;
           $nprice  = ( $ngross / ($nqty2 * $data[$i]->mstd_frac + $nqtyk) );
        @endphp
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $data[$i]->prd_deskripsipanjang}}</td>
            <td class="right">{{ $nqty }}</td>
            <td class="right">{{ number_format(round($nprice), 0, '.', ',') }}</td>
            <td class="right">{{ number_format(round($ngross), 0, '.', ',') }}</td>
        </tr>
        @php
            $no++;
            $total += $ngross;
        @endphp


    @if( ( isset($data[$i+1]) && $temp_docno2!=$data[$i+1]->mstd_docno2) || !isset($data[$i+1]) )
        </tbody>
    </table>
    <table class="table" >
        <tr>
            <td colspan="4"></td>
            <td class="right">{{ number_format(round($total), 0, '.', ',') }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td class="right">{{ number_format(floor($total * $perusahaan->prs_nilaippn), 0, '.', ',') }}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="center">{{$perusahaan->prs_namawilayah}}, {{date("d F Y")}}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="center"></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="center"></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="center"></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="center"></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="center"></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td align="center">{{$namattd}}</td>
            <td></td>
        </tr>
        <tr class="mb-0 pb-0">
            <td colspan="2"></td>
            <td align="center">{{$jabatan1}}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" align="left">No. NPB : {{$data[$i]->msth_nodoc}}</td>
            <td align="center">{{$jabatan2}}</td>
            <td></td>
        </tr>
    </table>
    <div class="pagebreak"></div>
@endif
@endfor

</body>


<style>
    @page {
        /*margin: 25px 20px;*/
        /*size: 1071pt 792pt;*/
        size: 600pt 750pt;
    }
    .pagebreak {
        page-break-before: always;
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
