{{--<html>--}}
{{--<head>--}}
    {{--<title>LAPORAN</title>--}}
{{--</head>--}}
{{--<style>--}}
    {{--/**--}}
        {{--Set the margins of the page to 0, so the footer and the header--}}
        {{--can be of the full height and width !--}}
     {{--**/--}}
    {{--@page {--}}
        {{--margin: 25px 25px;--}}
    {{--}--}}

    {{--/** Define now the real margins of every page in the PDF **/--}}
    {{--body {--}}
        {{--margin-top: 70px;--}}
        {{--margin-bottom: 10px;--}}
        {{--font-size: 9px;--}}
        {{--font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;--}}
        {{--font-weight: 400;--}}
        {{--line-height: 1.8;--}}
        {{--/*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/--}}
    {{--}--}}

    {{--/** Define the header rules **/--}}
    {{--header {--}}
        {{--position: fixed;--}}
        {{--top: 0cm;--}}
        {{--left: 0cm;--}}
        {{--right: 0cm;--}}
        {{--height: 2cm;--}}
    {{--}--}}
    {{--.page-numbers:after { content: counter(page); }--}}

    {{--.page-break {--}}
        {{--page-break-after: always;--}}
    {{--}--}}
{{--</style>--}}


{{--<body>--}}
{{--<!-- Define header and footer blocks before your content -->--}}
{{--<?php--}}
{{--$i = 1;--}}
{{--$datetime = new DateTime();--}}
{{--$timezone = new DateTimeZone('Asia/Jakarta');--}}
{{--$datetime->setTimezone($timezone);--}}
{{--?>--}}

{{--@if($datas)--}}
    {{--<header>--}}
        {{--<div style="float:left; margin-top: -20px; line-height: 5px !important;">--}}
            {{--<p>{{$datas[0]->prs_namaperusahaan}}</p>--}}
            {{--<p>{{$datas[0]->prs_namacabang}}</p>--}}
        {{--</div>--}}
        {{--<div style="float:right; margin-top: 0px; line-height: 5px !important;">--}}
            {{--<p>{{ date("d-M-y  H:i:s") }}</p>--}}
        {{--</div>--}}
        {{--<div style="line-height: 0.3 !important; text-align: center !important;">--}}
            {{--<h2 style="">DAFTAR PB / SUPPLIER </h2>--}}
            {{--<p style="font-size: 10px !important;">TANGGAL : {{date('d-m-Y', strtotime($date1)) }} s/d {{date('d-m-Y', strtotime($date2)) }}</p>--}}
        {{--</div>--}}
    {{--</header>--}}

    {{--<main>--}}
        {{--@for($i=0; $i<sizeof($datas); $i++)--}}
            {{--@if($i == 0)--}}
            {{--<div style="line-height: 0.3 !important;  ">--}}
                {{--<p>No. PB : {{$datas[0]->pbh_nopb}}</p>--}}
                {{--<p>Supplier: {{$datas[0]->supplier}}</p>--}}
            {{--</div>--}}
            {{--<table class="table table-bordered table-responsive" style="">--}}
                {{--<thead style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
                {{--<tr style="text-align: center;">--}}
                    {{--<th rowspan="2" style="width: 40px; text-align: left">PLU</th>--}}
                    {{--<th rowspan="2" style="width: 150px; text-align: left">DESKRIPSI</th>--}}
                    {{--<th rowspan="2" style="width: 28px">SATUAN</th>--}}
                    {{--<th rowspan="2" style="width: 28px">TAG</th>--}}
                    {{--<th colspan="2" style="width: 50px">----STOK-----</th>--}}
                    {{--<th colspan="2" style="width: 50px">-----PKM------</th>--}}
                    {{--<th rowspan="2" style="width: 30px">QTY<br>PO OUT</th>--}}
                    {{--<th rowspan="2" style="width: 30px">QTY<br>PB OUT</th>--}}
                    {{--<th colspan="2" style="width: 50px">---ORDER---</th>--}}
                    {{--<th rowspan="2" style="width: 12px;">MIN ORDER</th>--}}
                    {{--<th rowspan="2" style="width: 45px; text-align: right">JUMLAH</th>--}}
                    {{--<th rowspan="2" style="width: 8px">IDM</th>--}}
                    {{--<th rowspan="2" style="width: 8px">OMI</th>--}}
                    {{--<th rowspan="2" style="width: 8px">SP</th>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                    {{--<th style="text-align: right">QTYB</th>--}}
                    {{--<th style="text-align: right">K</th>--}}
                    {{--<th style="text-align: right">QTYB</th>--}}
                    {{--<th style="text-align: right">K</th>--}}
                    {{--<th style="text-align: right">QTYB</th>--}}
                    {{--<th style="text-align: right">K</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--@else--}}
                {{--@if(isset($datas[$i+1]))--}}
                {{--@if($datas[$i]->pbh_nopb != $datas[$i+1]->pbh_nopb || $datas[$i]->supplier != $datas[$i+1]->supplier)--}}
                {{--<div class="page-break"></div>--}}
                {{--<div style="line-height: 0.3 !important;  ">--}}
                {{--<p>No. PB : {{$datas[$i]->pbh_nopb}}</p>--}}
                {{--<p>Supplier: {{$datas[$i]->supplier}}</p>--}}
                {{--</div>--}}
                {{--<table class="table table-bordered table-responsive" style="">--}}
                {{--<thead style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
                {{--<tr style="text-align: center;">--}}
                {{--<th rowspan="2" style="width: 40px; text-align: left">PLU</th>--}}
                {{--<th rowspan="2" style="width: 150px; text-align: left">DESKRIPSI</th>--}}
                {{--<th rowspan="2" style="width: 28px">SATUAN</th>--}}
                {{--<th rowspan="2" style="width: 28px">TAG</th>--}}
                {{--<th colspan="2" span style="width: 50px">----STOK-----</th>--}}
                {{--<th colspan="2" style="width: 50px">-----PKM------</th>--}}
                {{--<th rowspan="2" style="width: 30px">QTY<br>PO OUT</th>--}}
                {{--<th rowspan="2" style="width: 30px">QTY<br>PB OUT</th>--}}
                {{--<th colspan="2" style="width: 50px">---ORDER---</th>--}}
                {{--<th rowspan="2" style="width: 12px;">MIN ORDER</th>--}}
                {{--<th rowspan="2" style="width: 45px; text-align: right">JUMLAH</th>--}}
                {{--<th rowspan="2" style="width: 8px">IDM</th>--}}
                {{--<th rowspan="2" style="width: 8px">OMI</th>--}}
                {{--<th rowspan="2" style="width: 8px">SP</th>--}}
                {{--</tr>--}}
                {{--<tr>--}}
                {{--<th style="text-align: right">QTYB</th>--}}
                {{--<th style="text-align: right">K</th>--}}
                {{--<th style="text-align: right">QTYB</th>--}}
                {{--<th style="text-align: right">K</th>--}}
                {{--<th style="text-align: right">QTYB</th>--}}
                {{--<th style="text-align: right">K</th>--}}
                {{--</tr>--}}
                {{--</thead>--}}
                {{--@endif--}}
                {{--@endif--}}
                {{--@endif--}}

                {{--<tbody style="border-bottom: 1px solid black">--}}
                {{--@for($i=0; $i<sizeof($datas); $i++)--}}
                {{--@if($i == 0)--}}
                    {{--<tr>--}}
                        {{--<td>Departement</td>--}}
                        {{--<td>: {{$datas[0]->departement}}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                        {{--<td>Kategori</td>--}}
                        {{--<td>: {{$datas[0]->kategori}}</td>--}}
                    {{--</tr>--}}
                {{--@else--}}
                    {{--@if($datas[$i]->departement != $datas[$i-1]->departement)--}}
                        {{--<tr>--}}
                            {{--<td>Departement</td>--}}
                            {{--<td>: {{$datas[$i]->departement}}</td>--}}
                        {{--</tr>--}}
                        {{--<tr>--}}
                            {{--<td>Kategori</td>--}}
                            {{--<td>: {{$datas[$i]->kategori}}</td>--}}
                        {{--</tr>--}}
                        {{--{{$totalkategori = 0}}--}}
                        {{--{{$kategori = 0}}--}}
                    {{--@elseif($datas[$i]->kategori != $datas[$i-1]->kategori)--}}
                        {{--<tr>--}}
                            {{--<td>Kategori</td>--}}
                            {{--<td>: {{$datas[$i]->kategori}}</td>--}}
                        {{--</tr>--}}
                        {{--{{$totalkategori = $totalkategori + $kategori}}--}}
                        {{--{{$kategori = 0}}--}}
                    {{--@endif--}}
                {{--@endif--}}

                {{--<tr style="text-align: right">--}}
                    {{--<td style="text-align: left">{{$datas[$i]->pbd_prdcd}}</td>--}}
                    {{--<td style="text-align: left">{{$datas[$i]->prd_deskripsipanjang}}</td>--}}
                    {{--<td>{{$datas[$i]->satuan}}</td>--}}
                    {{--<td>{{$datas[$i]->tag}}</td>--}}
                    {{--<td>{{$datas[$i]->stock_qty}}</td>--}}
                    {{--<td>{{$datas[$i]->stock_qtyk}}</td>--}}
                    {{--<td>{{$datas[$i]->pkm_qty}}</td>--}}
                    {{--<td>{{$datas[$i]->pkm_qtyk}}</td>--}}
                    {{--<td>{{$datas[$i]->pbd_ostpo}}</td>--}}
                    {{--<td>{{$datas[$i]->pbd_ostpb}}</td>--}}
                    {{--<td>{{$datas[$i]->qty}}</td>--}}
                    {{--<td>{{$datas[$i]->qtyk}}</td>--}}
                    {{--@if($tipepb == 'R')--}}
                        {{--<td>{{$datas[$i]->prd_minorder}}</td>--}}
                    {{--@else--}}
                        {{--<td>{{$datas[$i]->min_minorder}}</td>--}}
                    {{--@endif--}}
                    {{--<td>{{number_format( $datas[$i]->gross ,0,',','.')}}</td>--}}
                    {{--@if($datas[$i]->idm == '0')--}}
                        {{--<td style="text-align: center"> </td>--}}
                    {{--@else--}}
                        {{--<td style="text-align: center">*</td>--}}
                    {{--@endif--}}
                    {{--@if($datas[$i]->omi == '0')--}}
                        {{--<td style="text-align: center"> </td>--}}
                    {{--@else--}}
                        {{--<td style="text-align: center">*</td>--}}
                    {{--@endif--}}
                    {{--<td style="text-align: center">?</td>--}}
                {{--</tr>--}}

                {{--{{$kategori = $kategori + $datas[$i]->gross }}--}}
                {{--{{$totalkategori = $totalkategori + $datas[$i]->gross }}--}}

                {{--@if(isset($datas[$i+1]))--}}
                    {{--@if($datas[$i]->departement != $datas[$i+1]->departement)--}}
                        {{--<tr style="text-align: right; font-weight: bold">--}}
                            {{--<td colspan="13">Total Kategori :</td>--}}
                            {{--<td>{{number_format( $kategori ,0,',','.')}}</td>--}}
                        {{--</tr>--}}
                        {{--<tr style="text-align: right; font-weight: bold">--}}
                            {{--<td colspan="13">Total Departement : </td>--}}
                            {{--<td>{{number_format( $totalkategori ,0,',','.')}}</td>--}}
                        {{--</tr>--}}
                    {{--@elseif($datas[$i]->kategori != $datas[$i+1]->kategori)--}}
                        {{--<tr style="text-align: right; font-weight: bold">--}}
                            {{--<td colspan="13">Total Kategori :</td>--}}
                            {{--<td>{{number_format( $kategori ,0,',','.')}}</td>--}}
                        {{--</tr>--}}
                    {{--@endif--}}
                {{--@else--}}
                    {{--<tr style="text-align: right; font-weight: bold">--}}
                        {{--<td colspan="13">Total Kategori :</td>--}}
                        {{--<td>{{number_format( $kategori ,0,',','.')}}</td>--}}
                    {{--</tr>--}}
                    {{--<tr style="text-align: right; font-weight: bold">--}}
                        {{--<td colspan="13">Total Departement :</td>--}}
                        {{--<td>{{number_format( $totalkategori ,0,',','.')}}</td>--}}
                    {{--</tr>--}}
                {{--@endif--}}
                {{--</tbody>--}}
            {{--</table>--}}
        {{--@endfor--}}
        {{--<p style="text-align: right"> ** Akhir Dari Laporan ** </p>--}}
    {{--</main>--}}

{{--@else--}}
    {{--<header>--}}
        {{--<div style="float:left; margin-top: -20px; line-height: 5px !important;">--}}
            {{--<p>--</p>--}}
            {{--<p>--</p>--}}
        {{--</div>--}}
        {{--<div style="float:right; margin-top: 0px; line-height: 5px !important;">--}}
            {{--<p>{{ date("d-M-y  H:i:s") }}</p>--}}
            {{--<p> IGR_BO_CTKTLKNPBPSUP </p>--}}
        {{--</div>--}}
        {{--<div style="line-height: 0.3 !important; text-align: center !important;">--}}
            {{--<h2 style="text-align: center">LAPORAN DAFTAR TOLAKAN PB / SUPPLIER </h2>--}}
            {{--<p style="font-size: 10px !important; text-align: center !important; margin-left: 100px">TANGGAL : -- s/d --</p>--}}
        {{--</div>--}}
    {{--</header>--}}

    {{--<main>--}}
        {{--<table class="table table-bordered table-responsive" style="">--}}
            {{--<thead style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
            {{--<tr style="text-align: center;">--}}
                {{--<th style="width: 30px">PLU</th>--}}
                {{--<th style="width: 300px !important;">DESKRIPSI</th>--}}
                {{--<th style="width: 45px">SATUAN</th>--}}
                {{--<th style="width: 45px">TAGDIV</th>--}}
                {{--<th style="width: 45px">DEPT</th>--}}
                {{--<th style="width: 45px">KAT</th>--}}
                {{--<th style="width: 45px">PKMT</th>--}}
                {{--<th style="width: 150px">KETERANGAN</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody style="border-bottom: 1px solid black">--}}
            {{--<tr>--}}
                {{--<td colspan="8" style="text-align: center">** No Data **</td>--}}
            {{--</tr>--}}
            {{--</tbody>--}}
        {{--</table>--}}
        {{--<p style="text-align: right"> ** Akhir Dari Laporan ** </p>--}}

{{--@endif--}}

{{--</body>--}}
{{--</html>--}}



























@for($i=0; $i<sizeof($datas); $i++)
    @if($i == 0)
        <div style="line-height: 0.3 !important;  ">
            <p>No. PB : {{$datas[0]->pbh_nopb}}</p>
            <p>Supplier: {{$datas[0]->supplier}}</p>
        </div>
        <table class="table table-bordered table-responsive" style="">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr style="text-align: center;">
                <th rowspan="2" style="width: 40px; text-align: left">PLU</th>
                <th rowspan="2" style="width: 150px; text-align: left">DESKRIPSI</th>
                <th rowspan="2" style="width: 28px">SATUAN</th>
                <th rowspan="2" style="width: 28px">TAG</th>
                <th colspan="2" style="width: 50px">----STOK-----</th>
                <th colspan="2" style="width: 50px">-----PKM------</th>
                <th rowspan="2" style="width: 30px">QTY<br>PO OUT</th>
                <th rowspan="2" style="width: 30px">QTY<br>PB OUT</th>
                <th colspan="2" style="width: 50px">---ORDER---</th>
                <th rowspan="2" style="width: 12px;">MIN ORDER</th>
                <th rowspan="2" style="width: 45px; text-align: right">JUMLAH</th>
                <th rowspan="2" style="width: 8px">IDM</th>
                <th rowspan="2" style="width: 8px">OMI</th>
                <th rowspan="2" style="width: 8px">SP</th>
            </tr>
            <tr>
                <th style="text-align: right">QTYB</th>
                <th style="text-align: right">K</th>
                <th style="text-align: right">QTYB</th>
                <th style="text-align: right">K</th>
                <th style="text-align: right">QTYB</th>
                <th style="text-align: right">K</th>
            </tr>
            </thead>
            <tbody style="border-bottom: 1px solid black">
            <tr>
                <td>Departement</td>
                <td>: {{$datas[0]->departement}}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>: {{$datas[0]->kategori}}</td>
            </tr>
            <tr style="text-align: right">
                <td style="text-align: left">{{$datas[$i]->pbd_prdcd}}</td>
                <td style="text-align: left">{{$datas[$i]->prd_deskripsipanjang}}</td>
                <td>{{$datas[$i]->satuan}}</td>
                <td>{{$datas[$i]->tag}}</td>
                <td>{{$datas[$i]->stock_qty}}</td>
                <td>{{$datas[$i]->stock_qtyk}}</td>
                <td>{{$datas[$i]->pkm_qty}}</td>
                <td>{{$datas[$i]->pkm_qtyk}}</td>
                <td>{{$datas[$i]->pbd_ostpo}}</td>
                <td>{{$datas[$i]->pbd_ostpb}}</td>
                <td>{{$datas[$i]->qty}}</td>
                <td>{{$datas[$i]->qtyk}}</td>
                @if($tipepb == 'R')
                    <td>{{$datas[$i]->prd_minorder}}</td>
                @else
                    <td>{{$datas[$i]->min_minorder}}</td>
                @endif
                <td>{{number_format( $datas[$i]->gross ,0,',','.')}}</td>
                @if($datas[$i]->idm == '0')
                    <td style="text-align: center"> </td>
                @else
                    <td style="text-align: center">*</td>
                @endif
                @if($datas[$i]->omi == '0')
                    <td style="text-align: center"> </td>
                @else
                    <td style="text-align: center">*</td>
                @endif
                <td style="text-align: center">?</td>
            </tr>

            {{$kategori = $kategori + $datas[$i]->gross }}
            {{$totalkategori = $totalkategori + $datas[$i]->gross }}

            @if(isset($datas[$i+1]))
                @if($datas[0]->pbh_nopb != $datas[1]->pbh_nopb || $datas[0]->supplier != $datas[1]->supplier)
                    <tr style="text-align: right; font-weight: bold">
                        <td colspan="13">Total Kategori :</td>
                        <td>{{number_format( $kategori ,0,',','.')}}</td>
                    </tr>
                    <tr style="text-align: right; font-weight: bold">
                        <td colspan="13">Total Departement : </td>
                        <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                    </tr>
                    <tr style="text-align: right; font-weight: bold">
                        <td colspan="13">Total Supplier : </td>
                        <td>{{number_format( 5123456,0,',','.')}}</td>
                    </tr>
                    {{--</tbody>--}}
                    {{--</table>--}}
                @elseif($datas[0]->departement != $datas[1]->departement)
                    <tr style="text-align: right; font-weight: bold">
                        <td colspan="13">Total Kategori :</td>
                        <td>{{number_format( $kategori ,0,',','.')}}</td>
                    </tr>
                    <tr style="text-align: right; font-weight: bold">
                        <td colspan="13">Total Departement : </td>
                        <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                    </tr>
                @elseif($datas[0]->kategori != $datas[1]->kategori)
                    <tr style="text-align: right; font-weight: bold">
                        <td colspan="13">Total Kategori :</td>
                        <td>{{number_format( $kategori ,0,',','.')}}</td>
                    </tr>
                @endif
            @else
                <tr style="text-align: right; font-weight: bold">
                    <td colspan="13">Total Kategori :</td>
                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                </tr>
                <tr style="text-align: right; font-weight: bold">
                    <td colspan="13">Total Departement :</td>
                    <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                </tr>
                <tr style="text-align: right; font-weight: bold">
                    <td colspan="13">Total Supplier : </td>
                    <td>{{number_format( 5123456,0,',','.')}}</td>
                </tr>
            </tbody>
        </table>
        @endif
        {{--</tbody>--}}
        {{--</table>--}}
    @else <!-- ********************************************************** -->
    @if($datas[$i]->pbh_nopb != $datas[$i-1]->pbh_nopb || $datas[$i]->supplier != $datas[$i-1]->supplier)
        <div class="page-break"></div>
        <div style="line-height: 0.3 !important;  ">
            <p>No. PB : {{$datas[$i]->pbh_nopb}}</p>
            <p>Supplier: {{$datas[$i]->supplier}}</p>
        </div>
    @endif
    <table class="table table-bordered table-responsive" style="">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th rowspan="2" style="width: 40px; text-align: left">PLU</th>
            <th rowspan="2" style="width: 150px; text-align: left">DESKRIPSI</th>
            <th rowspan="2" style="width: 28px">SATUAN</th>
            <th rowspan="2" style="width: 28px">TAG</th>
            <th colspan="2" style="width: 50px">----STOK-----</th>
            <th colspan="2" style="width: 50px">-----PKM------</th>
            <th rowspan="2" style="width: 30px">QTY<br>PO OUT</th>
            <th rowspan="2" style="width: 30px">QTY<br>PB OUT</th>
            <th colspan="2" style="width: 50px">---ORDER---</th>
            <th rowspan="2" style="width: 12px;">MIN ORDER</th>
            <th rowspan="2" style="width: 45px; text-align: right">JUMLAH</th>
            <th rowspan="2" style="width: 8px">IDM</th>
            <th rowspan="2" style="width: 8px">OMI</th>
            <th rowspan="2" style="width: 8px">SP</th>
        </tr>
        <tr>
            <th style="text-align: right">QTYB</th>
            <th style="text-align: right">K</th>
            <th style="text-align: right">QTYB</th>
            <th style="text-align: right">K</th>
            <th style="text-align: right">QTYB</th>
            <th style="text-align: right">K</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 1px solid black">
        @if($datas[$i]->pbh_nopb != $datas[$i-1]->pbh_nopb || $datas[$i]->supplier != $datas[$i-1]->supplier)
            <tr>
                <td>Departement</td>
                <td>: {{$datas[$i]->departement}}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>: {{$datas[$i]->kategori}}</td>
            </tr>
        @elseif($datas[$i]->departement != $datas[$i-1]->departement)
            <tr>
                <td>Departement</td>
                <td>: {{$datas[$i]->departement}}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>: {{$datas[$i]->kategori}}</td>
            </tr>
            {{$totalkategori = 0}}
            {{$kategori = 0}}
        @elseif($datas[$i]->kategori != $datas[$i-1]->kategori)
            <tr>
                <td>Kategori</td>
                <td>: {{$datas[$i]->kategori}}</td>
            </tr>
            {{$totalkategori = $totalkategori + $kategori}}
            {{$kategori = 0}}
        @endif

        <tr style="text-align: right">
            <td style="text-align: left">{{$datas[$i]->pbd_prdcd}}</td>
            <td style="text-align: left">{{$datas[$i]->prd_deskripsipanjang}}</td>
            <td>{{$datas[$i]->satuan}}</td>
            <td>{{$datas[$i]->tag}}</td>
            <td>{{$datas[$i]->stock_qty}}</td>
            <td>{{$datas[$i]->stock_qtyk}}</td>
            <td>{{$datas[$i]->pkm_qty}}</td>
            <td>{{$datas[$i]->pkm_qtyk}}</td>
            <td>{{$datas[$i]->pbd_ostpo}}</td>
            <td>{{$datas[$i]->pbd_ostpb}}</td>
            <td>{{$datas[$i]->qty}}</td>
            <td>{{$datas[$i]->qtyk}}</td>
            @if($tipepb == 'R')
                <td>{{$datas[$i]->prd_minorder}}</td>
            @else
                <td>{{$datas[$i]->min_minorder}}</td>
            @endif
            <td>{{number_format( $datas[$i]->gross ,0,',','.')}}</td>
            @if($datas[$i]->idm == '0')
                <td style="text-align: center"> </td>
            @else
                <td style="text-align: center">*</td>
            @endif
            @if($datas[$i]->omi == '0')
                <td style="text-align: center"> </td>
            @else
                <td style="text-align: center">*</td>
            @endif
            <td style="text-align: center">?</td>
        </tr>

        {{$kategori = $kategori + $datas[$i]->gross }}
        {{$totalkategori = $totalkategori + $datas[$i]->gross }}


        @if(isset($datas[$i+1]))
            @if($datas[$i]->supplier != $datas[$i+1]->supplier)
                {{--<tr>--}}
                {{--<td colspan="10">OKEEE</td>--}}
                {{--</tr>--}}
                <tr style="text-align: right; font-weight: bold">
                    <td colspan="13">Total Kategori :</td>
                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                </tr>
                <tr style="text-align: right; font-weight: bold">
                    <td colspan="13">Total Departement : </td>
                    <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                </tr>
                <tr style="text-align: right; font-weight: bold">
                    <td colspan="13">Total Supplier : </td>
                    <td>{{number_format( 5123456,0,',','.')}}</td>
                </tr>
            @elseif($datas[$i]->departement != $datas[$i+1]->departement)
                <tr style="text-align: right; font-weight: bold">
                    <td colspan="13">Total Kategori :</td>
                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                </tr>
                <tr style="text-align: right; font-weight: bold">
                    <td colspan="13">Total Departement : </td>
                    <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                </tr>
            @elseif($datas[$i]->kategori != $datas[$i+1]->kategori)
                <tr style="text-align: right; font-weight: bold">
                    <td colspan="13">Total Kategori :</td>
                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                </tr>
            @endif
        @else
            <tr style="text-align: right; font-weight: bold">
                <td colspan="13">Total Kategori :</td>
                <td>{{number_format( $kategori ,0,',','.')}}</td>
            </tr>
            <tr style="text-align: right; font-weight: bold">
                <td colspan="13">Total Departement :</td>
                <td>{{number_format( $totalkategori ,0,',','.')}}</td>
            </tr>
            <tr style="text-align: right; font-weight: bold">
                <td colspan="13">Total Supplier : </td>
                <td>{{number_format( 5123456,0,',','.')}}</td>
            </tr>
        @endif
        </tbody>
    </table>
    @endif
@endfor
