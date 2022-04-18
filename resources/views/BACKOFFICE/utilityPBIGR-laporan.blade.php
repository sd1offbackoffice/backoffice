@section('paper_height','850pt')
@section('paper_width','1000pt')

@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN PEMBENTUKAN M PLUS.I DAN M PLUS.O
@endsection

@section('title')
    LAPORAN PEMBENTUKAN M PLUS.I DAN M PLUS.O
@endsection

@section('subtitle')
    Periode : {{date('m-Y', strtotime($periode)) }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th rowspan="3" style="width: 10px">NO</th>
            <th colspan="2" rowspan="1">-----------PLU-----------</th>
            <th rowspan="3" style="width: 90px">DESKRIPSI</th>
            <th colspan="2" rowspan="1">BULAN SEBELUMNYA</th>
            <th colspan="4" rowspan="1">----------------BULAN BERJALAN----------------</th>
            <th rowspan="3" style="text-align: right; width: 40px">AVG <br> PB <br> OMI</th>
            <th rowspan="3" style="width: 30px">TAG <br> IGR</th>
            <th rowspan="3" style="width: 30px">TAG <br> IDM</th>
            <th rowspan="3" style="text-align: right; width: 30px">QTY <br> Frac <br> IGR</th>
            <th rowspan="3" style="text-align: right; width: 40px">S/L <br> Supp <br>(%)</th>
            <th colspan="2" rowspan="1" style="text-align: right">MINOR/FRAC</th>
            <th rowspan="3" style="width: 50px">NAIK/<br>TURUN <br> MINOR</th>
            <th rowspan="3" style="width: 50px">KETERANGAN</th>
            <th rowspan="3" style="text-align: right;width: 20px">n*</th>
            <th colspan="2" rowspan="1">-----QTY M PLUS.I-----</th>
            <th colspan="2" rowspan="1">-----QTY M PLUS.0-----</th>
        </tr>
        <tr>
            <th rowspan="2" style="width: 20px">IDM</th>
            <th rowspan="2" style="width: 20px">IGR</th>
            <th rowspan="2" style="width: 30px;text-align: right">QTY KPH <br> MEAN</th>
            <th rowspan="2" style="width: 30px;text-align: right">QTY <br> MINOR</th>
            <th colspan="3" rowspan="1" style="text-align: center">------------QTY KPH MEAN------------</th>
            <th rowspan="2" style="text-align: right; width: 30px">QTY <br> MINOR</th>
            <th rowspan="2" style="text-align: right; width: 30px">B-2</th>
            <th rowspan="2" style="text-align: right; width: 30px">B-1</th>
            <th rowspan="2" style="text-align: right; width: 50px">EXISTING</th>
            <th rowspan="2" style="text-align: right; width: 50px">USULAN</th>
            <th rowspan="2" style="text-align: right; width: 50px">EXISTING</th>
            <th rowspan="2" style="text-align: right; width: 50px">USULAN</th>
        </tr>
        <tr>
            <th style="width: 50px;text-align: right">1x</th>
            <th style="width: 50px;text-align: right">3x</th>
            <th style="width: 50px;text-align: right">4x</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i = 1;
        @endphp
        @foreach($data as $value)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$value->prc_pluidm}}</td>
                <td>{{$value->thp_prdcd}}</td>
                <td style="text-align: left">{{$value->prd_deskripsipanjang}}</td>
                <td style="text-align: right">{{$value->kphold}}</td>
                <td style="text-align: right">{{$value->minold}}</td>
                <td style="text-align: right">{{$value->kph1}}</td>
                <td style="text-align: right">{{$value->kph3}}</td>
                <td style="text-align: right">{{$value->kph4}}</td>
                <td style="text-align: right">{{$value->minor}}</td>
                <td style="text-align: right">{{$value->thp_avgpb_omi}}</td>
                <td style="text-align: center">{{$value->prd_kodetag}}</td>
                <td style="text-align: center">{{$value->prc_kodetag}}</td>
                <td style="text-align: right">{{$value->prd_frac}}</td>
                <td style="text-align: right">{{$value->thp_sl_mplusi}}</td>
                <td style="text-align: right">{{$value->minfracold}}</td>
                <td style="text-align: right">{{$value->minfrac}}</td>
                <td style="text-align: center">{{$value->minfracket}}</td>
                <td style="text-align: center">{{$value->keterangan}}</td>
                <td style="text-align: right">{{$value->thp_n_mplusi}}</td>
                <td style="text-align: right">{{$value->mplusiex}}</td>
                <td style="text-align: right">{{$value->thp_mplusi}}</td>
                <td style="text-align: right">{{$value->mplusoex}}</td>
                <td style="text-align: right">{{$value->thp_mpluso}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <p><strong>*n merupakan koefisien yang besarannya tergantung dari tingkat service level Supplier untuk PLU tsb</strong></p>
@endsection


{{--*****************************************************************************************--}}
{{--<html>--}}
{{--<head>--}}
{{--</head>--}}
{{--<style>--}}
{{--    /**--}}
{{--        Set the margins of the page to 0, so the footer and the header--}}
{{--        can be of the full height and width !--}}
{{--     **/--}}
{{--    @page {--}}
{{--        margin: 25px 25px;--}}
{{--        size: 1071pt 792pt;--}}
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
{{--<header>--}}
{{--    <div style="float:left; margin-top: -20px; line-height: 5px !important;">--}}
{{--        <p>{{$datas[0]->prs_namaperusahaan}}</p>--}}
{{--        <p>{{$datas[0]->prs_namacabang}}</p>--}}
{{--    </div>--}}
{{--    <div style="float:right; margin-top: 0px; line-height: 5px !important;">--}}
{{--        <p>{{ date("d-M-y  H:i:s") }}</p>--}}
{{--    </div>--}}
{{--    <h2 style="text-align: center">LAPORAN PEMBENTUKAN M PLUS.I DAN M PLUS.O<br>Periode : {{date('m-Y', strtotime($periode)) }}</h2>--}}
{{--</header>--}}

{{--<main>--}}
{{--    <table class="table table-bordered table-responsive" style="">--}}
{{--        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
{{--        <tr style="text-align: center;">--}}
{{--            <th rowspan="3" style="width: 10px">NO</th>--}}
{{--            <th colspan="2" rowspan="1">-----------PLU-----------</th>--}}
{{--            <th rowspan="3" style="width: 90px">DESKRIPSI</th>--}}
{{--            <th colspan="2" rowspan="1">BULAN SEBELUMNYA</th>--}}
{{--            <th colspan="4" rowspan="1">----------------BULAN BERJALAN----------------</th>--}}
{{--            <th rowspan="3" style="text-align: right; width: 40px">AVG <br> PB <br> OMI</th>--}}
{{--            <th rowspan="3" style="width: 30px">TAG <br> IGR</th>--}}
{{--            <th rowspan="3" style="width: 30px">TAG <br> IDM</th>--}}
{{--            <th rowspan="3" style="text-align: right; width: 30px">QTY <br> Frac <br> IGR</th>--}}
{{--            <th rowspan="3" style="text-align: right; width: 40px">S/L <br> Supp <br>(%)</th>--}}
{{--            <th colspan="2" rowspan="1" style="text-align: right">MINOR/FRAC</th>--}}
{{--            <th rowspan="3" style="width: 50px">NAIK/<br>TURUN <br> MINOR</th>--}}
{{--            <th rowspan="3" style="width: 50px">KETERANGAN</th>--}}
{{--            <th rowspan="3" style="text-align: right;width: 20px">n*</th>--}}
{{--            <th colspan="2" rowspan="1">-----QTY M PLUS.I-----</th>--}}
{{--            <th colspan="2" rowspan="1">-----QTY M PLUS.0-----</th>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th rowspan="2" style="width: 20px">IDM</th>--}}
{{--            <th rowspan="2" style="width: 20px">IGR</th>--}}
{{--            <th rowspan="2" style="width: 30px;text-align: right">QTY KPH <br> MEAN</th>--}}
{{--            <th rowspan="2" style="width: 30px;text-align: right">QTY <br> MINOR</th>--}}
{{--            <th colspan="3" rowspan="1" style="text-align: center">------------QTY KPH MEAN------------</th>--}}
{{--            <th rowspan="2" style="text-align: right; width: 30px">QTY <br> MINOR</th>--}}
{{--            <th rowspan="2" style="text-align: right; width: 30px">B-2</th>--}}
{{--            <th rowspan="2" style="text-align: right; width: 30px">B-1</th>--}}
{{--            <th rowspan="2" style="text-align: right; width: 50px">EXISTING</th>--}}
{{--            <th rowspan="2" style="text-align: right; width: 50px">USULAN</th>--}}
{{--            <th rowspan="2" style="text-align: right; width: 50px">EXISTING</th>--}}
{{--            <th rowspan="2" style="text-align: right; width: 50px">USULAN</th>--}}
{{--        </tr>--}}
{{--        <tr>--}}
{{--            <th style="width: 50px;text-align: right">1x</th>--}}
{{--            <th style="width: 50px;text-align: right">3x</th>--}}
{{--            <th style="width: 50px;text-align: right">4x</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($datas as $data)--}}
{{--            <tr>--}}
{{--                <td>{{$i++}}</td>--}}
{{--                <td>{{$data->prc_pluidm}}</td>--}}
{{--                <td>{{$data->thp_prdcd}}</td>--}}
{{--                <td>{{$data->prd_deskripsipanjang}}</td>--}}
{{--                <td style="text-align: right">{{$data->kphold}}</td>--}}
{{--                <td style="text-align: right">{{$data->minold}}</td>--}}
{{--                <td style="text-align: right">{{$data->kph1}}</td>--}}
{{--                <td style="text-align: right">{{$data->kph3}}</td>--}}
{{--                <td style="text-align: right">{{$data->kph4}}</td>--}}
{{--                <td style="text-align: right">{{$data->minor}}</td>--}}
{{--                <td style="text-align: right">{{$data->thp_avgpb_omi}}</td>--}}
{{--                <td style="text-align: center">{{$data->prd_kodetag}}</td>--}}
{{--                <td style="text-align: center">{{$data->prc_kodetag}}</td>--}}
{{--                <td style="text-align: right">{{$data->prd_frac}}</td>--}}
{{--                <td style="text-align: right">{{$data->thp_sl_mplusi}}</td>--}}
{{--                <td style="text-align: right">{{$data->minfracold}}</td>--}}
{{--                <td style="text-align: right">{{$data->minfrac}}</td>--}}
{{--                <td style="text-align: center">{{$data->minfracket}}</td>--}}
{{--                <td style="text-align: center">{{$data->keterangan}}</td>--}}
{{--                <td style="text-align: right">{{$data->thp_n_mplusi}}</td>--}}
{{--                <td style="text-align: right">{{$data->mplusiex}}</td>--}}
{{--                <td style="text-align: right">{{$data->thp_mplusi}}</td>--}}
{{--                <td style="text-align: right">{{$data->mplusoex}}</td>--}}
{{--                <td style="text-align: right">{{$data->thp_mpluso}}</td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--</main>--}}

{{--</body>--}}
{{--</html>--}}
