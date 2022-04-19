{{----------------------------------------------------------------------------}}
@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN DAFTAR TOLAKAN PB / SUPPLIER
@endsection

@section('title')
    LAPORAN DAFTAR TOLAKAN PB / SUPPLIER
@endsection

@section('subtitle')
    TANGGAL {{ $date1 }} - {{ $date2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left">PLU</th>
            <th class="left">DESKRIPSI</th>
            <th class="right">SATUAN</th>
            <th class="right">TAGDIV</th>
            <th class="right">DEPT</th>
            <th class="right">KAT</th>
            <th class="right padding-right">PKMT</th>
            <th class="left" >KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $kunjungan  = 0;
            $slip       = 0;
            $produk     = 0;
            $rupiah     = 0;
            $margin     = 0;
            $number     = 1;
        @endphp
        @for($i=0; $i<sizeof($data); $i++)
            @if($i == 0)
                <tr>
                    <td colspan="8" style="font-weight: bold !important; margin-top: 10px !important;" class="left">Tanggal : {{date('d-m-y', strtotime($data[$i]->tglpb))}}  Dokumen : {{$data[$i]->nopb}}</td>
                </tr>
                <tr>
                    <td  style="font-weight: bold !important;" class="left">{{$data[$i]->supco}} - {{$data[$i]->supname}}</td>
                </tr>
            @else
                @if(substr($data[$i]->tglpb,0,10) != substr($data[$i-1]->tglpb,0,10))
                    <tr>
                        <td colspan="8" style="font-weight: bold !important; margin-top: 10px !important;" class="left">Tanggal : {{date('d-m-y', strtotime($data[$i]->tglpb))}}  Dokumen : {{$data[$i]->nopb}}</td>
                    </tr>
                    <tr>
                        <td  style="font-weight: bold !important;" class="left">{{$data[$i]->supco}} - {{$data[$i]->supname}}</td>
                    </tr>
                @endif
                @if($data[$i]->supco != $data[$i-1]->supco)
                    <tr>
                        <td  style="font-weight: bold !important;" class="left">{{$data[$i]->supco}} - {{$data[$i]->supname}}</td>
                    </tr>
                @endif
            @endif
            <tr>
                <td class="left">{{$data[$i]->prdcd}}</td>
                <td class="left">{{$data[$i]->deskripsi}}</td>
                <td class="right">{{$data[$i]->satuan}}</td>
                <td class="right">{{$data[$i]->div}}</td>
                <td class="right">{{$data[$i]->dep}}</td>
                <td class="right">{{$data[$i]->kat}}</td>
                <td class="right padding-right">{{$data[$i]->pkmt}}</td>
                <td class="left">{{$data[$i]->tlk_keterangantolakan}}</td>
            </tr>
        @endfor
        </tbody>
        <tfoot>
{{--        <tr>--}}
{{--            <td class="left" colspan="4">Total :</td>--}}
{{--            <td class="right">{{$kunjungan}}</td>--}}
{{--            <td class="right">{{$slip}}</td>--}}
{{--            <td class="right">{{number_format($produk ,2,'.',',')}}</td>--}}
{{--            <td class="right">{{number_format($rupiah ,2,'.',',')}}</td>--}}
{{--            <td class="right">{{number_format($margin ,2,'.',',')}}</td>--}}
{{--            <td class="right">{{number_format((($margin/(($rupiah > 0) ? $rupiah : 1))*100),2) }}</td>--}}
{{--        </tr>--}}
        </tfoot>
    </table>
@endsection





{{--<html>--}}
{{--<head>--}}
{{--    <title>LAPORAN</title>--}}
{{--</head>--}}
{{--<style>--}}
{{--    /**--}}
{{--        Set the margins of the page to 0, so the footer and the header--}}
{{--        can be of the full height and width !--}}
{{--     **/--}}
{{--    @page {--}}
{{--        margin: 25px 25px;--}}
{{--    }--}}

{{--    /** Define now the real margins of every page in the PDF **/--}}
{{--    body {--}}
{{--        margin-top: 70px;--}}
{{--        margin-bottom: 10px;--}}
{{--        font-size: 9px;--}}
{{--        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;--}}
{{--        font-weight: 400;--}}
{{--        line-height: 1.8;--}}
{{--        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/--}}
{{--    }--}}

{{--    /** Define the header rules **/--}}
{{--    header {--}}
{{--        position: fixed;--}}
{{--        top: 0cm;--}}
{{--        left: 0cm;--}}
{{--        right: 0cm;--}}
{{--        height: 2cm;--}}
{{--    }--}}
{{--    .page-numbers:after { content: counter(page); }--}}
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
{{--    <div style="float:left; margin-top: -20px; line-height: 5px !important;">--}}
{{--        <p>{{$datas[0]->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$datas[0]->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="float:right; margin-top: 0px; line-height: 5px !important;">--}}
{{--        <p>{{ date("d-M-y  H:i:s") }}</p>--}}
{{--        <p> IGR_BO_CTKTLKNPBPSUP </p>--}}
{{--    </div>--}}
{{--    --}}{{--<h2 style="text-align: center">LAPORAN DAFTAR TOLAKAN PB / SUPPLIER <br>TANGGAL : {{date('d-M-y', strtotime($date1)) }} s/d {{date('d-M-y', strtotime($date2)) }}</h2>--}}
{{--    <div style="line-height: 0.3 !important; text-align: center !important;">--}}
{{--        <h2 style="text-align: center">LAPORAN DAFTAR TOLAKAN PB / SUPPLIER </h2>--}}
{{--        <p style="font-size: 10px !important; text-align: center !important; margin-left: 100px">TANGGAL : {{date('d-M-y', strtotime($date1)) }} s/d {{date('d-M-y', strtotime($date2)) }}</p>--}}
{{--    </div>--}}
{{--</header>--}}

{{--<main>--}}
{{--    <table class="table table-bordered table-responsive" style="">--}}
{{--        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
{{--        <tr style="text-align: center;">--}}
{{--            <th style="width: 30px">PLU</th>--}}
{{--            <th style="width: 280px !important; text-align: left">DESKRIPSI</th>--}}
{{--            <th style="width: 30px">SATUAN</th>--}}
{{--            <th style="width: 30px">TAGDIV</th>--}}
{{--            <th style="width: 30px">DEPT</th>--}}
{{--            <th style="width: 30px">KAT</th>--}}
{{--            <th style="width: 30px">PKMT</th>--}}
{{--            <th style="width: 180px; text-align: left">KETERANGAN</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody style="border-bottom: 1px solid black">--}}
{{--        @for($i=0; $i<sizeof($datas); $i++)--}}
{{--            @if($i == 0)--}}
{{--                <tr>--}}
{{--                    <td colspan="8" style="font-weight: bold !important; margin-top: 10px !important;">{{date('d-m-y', strtotime($datas[$i]->tglpb))}}  - {{$datas[$i]->nopb}}</td>--}}
{{--                    <td colspan="8" style="font-weight: bold !important; margin-top: 10px !important;">Tanggal : {{substr($datas[$i]->tglpb,0,10)}}  Dokumen : {{$datas[$i]->nopb}}</td>--}}
{{--                </tr>--}}
{{--                <tr>--}}
{{--                    <td colspan="8" style="font-weight: bold !important;">{{$datas[$i]->supco}} - {{$datas[$i]->supname}}</td>--}}
{{--                </tr>--}}
{{--                @else--}}
{{--                @if(substr($datas[$i]->tglpb,0,10) != substr($datas[$i-1]->tglpb,0,10))--}}
{{--                    <tr>--}}
{{--                        <td colspan="8" style="font-weight: bold !important; margin-top: 10px !important;">{{date('d-m-y', strtotime($datas[$i]->tglpb))}}  - {{$datas[$i]->nopb}}</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td colspan="8" style="font-weight: bold !important;">{{$datas[$i]->supco}} - {{$datas[$i]->supname}}</td>--}}
{{--                    </tr>--}}
{{--                @endif--}}
{{--                @if($datas[$i]->supco != $datas[$i-1]->supco)--}}
{{--                    <tr>--}}
{{--                        <td colspan="8" style="font-weight: bold !important; margin-top: 20px !important;">{{$datas[$i]->supco}} - {{$datas[$i]->supname}}</td>--}}
{{--                    </tr>--}}
{{--                @endif--}}
{{--                @endif--}}
{{--            <tr>--}}
{{--                <td>{{$datas[$i]->prdcd}}</td>--}}
{{--                <td>{{$datas[$i]->deskripsi}}</td>--}}
{{--                <td style="width: 280px !important;">{{$datas[$i]->deskripsi}}</td>--}}
{{--                <td style="text-align: center">{{$datas[$i]->satuan}}</td>--}}
{{--                <td style="text-align: right">{{$datas[$i]->div}}</td>--}}
{{--                <td style="text-align: right">{{$datas[$i]->dep}}</td>--}}
{{--                <td style="text-align: right">{{$datas[$i]->kat}}</td>--}}
{{--                <td style="text-align: right">{{$datas[$i]->pkmt}}</td>--}}
{{--                <td>{{$datas[$i]->tlk_keterangantolakan}}</td>--}}
{{--            </tr>--}}
{{--        @endfor--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--    <p style="text-align: right"> ** Akhir Dari Laporan ** </p>--}}
{{--</main>--}}

{{--@else--}}
{{--    <header>--}}
{{--        <div style="float:left; margin-top: -20px; line-height: 5px !important;">--}}
{{--            <p>--</p>--}}
{{--            <p>--</p>--}}
{{--        </div>--}}
{{--        <div style="float:right; margin-top: 0px; line-height: 5px !important;">--}}
{{--            <p>{{ date("d-M-y  H:i:s") }}</p>--}}
{{--            <p> IGR_BO_CTKTLKNPBPSUP </p>--}}
{{--        </div>--}}
{{--        <div style="line-height: 0.3 !important; text-align: center !important;">--}}
{{--            <h2 style="text-align: center">LAPORAN DAFTAR TOLAKAN PB / SUPPLIER </h2>--}}
{{--            <p style="font-size: 10px !important; text-align: center !important; margin-left: 100px">TANGGAL : -- s/d --</p>--}}
{{--        </div>--}}
{{--    </header>--}}

{{--    <main>--}}
{{--        <table class="table table-bordered table-responsive" style="">--}}
{{--            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
{{--            <tr style="text-align: center;">--}}
{{--                <th style="width: 30px">PLU</th>--}}
{{--                <th style="width: 300px !important;">DESKRIPSI</th>--}}
{{--                <th style="width: 45px">SATUAN</th>--}}
{{--                <th style="width: 45px">TAGDIV</th>--}}
{{--                <th style="width: 45px">DEPT</th>--}}
{{--                <th style="width: 45px">KAT</th>--}}
{{--                <th style="width: 45px">PKMT</th>--}}
{{--                <th style="width: 150px">KETERANGAN</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody style="border-bottom: 1px solid black">--}}
{{--           <tr>--}}
{{--               <td colspan="8" style="text-align: center">** No Data **</td>--}}
{{--           </tr>--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--        <p style="text-align: right"> ** Akhir Dari Laporan ** </p>--}}

{{--@endif--}}

{{--</body>--}}
{{--</html>--}}
