{{----------------------------------------------------------------------------}}
@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    @lang('DAFTAR PB / SUPPLIER')
@endsection

@section('title')
    @lang('DAFTAR PB / SUPPLIER')
@endsection

@section('subtitle')
    {{ date('d/m/Y', strtotime($tgl_start)) }} - {{ date('d/m/Y', strtotime($tgl_end)) }}
@endsection

@section('content')

    @for($i=0; $i<sizeof($data); $i++)
        @if($i == 0)
            <div style="line-height: 0.3 !important;  ">
                <p>No. PB : {{$data[$i]->pbh_nopb}}</p>
                <p>Supplier: {{$data[$i]->supplier}}</p>
            </div>

            <table class="table" style="">
                <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <tr>
                    <th rowspan="2" class="">@lang('PLU')</th>
                    <th rowspan="2" class="">@lang('DESKRIPSI')</th>
                    <th rowspan="2" class="">@lang('SATUAN')</th>
                    <th rowspan="2" class="">@lang('TAG')</th>
                    <th colspan="2" class="">@lang('----STOK-----')</th>
                    <th colspan="2" class="">@lang('-----PKM------')</th>
                    <th rowspan="2" class="">@lang('QTY')<br>PO OUT</th>
                    <th rowspan="2" class="">@lang('QTY')<br>PB OUT</th>
                    <th colspan="2" class="">@lang('---ORDER---')</th>
                    <th rowspan="2" class="">@lang('MIN ORDER')</th>
                    <th rowspan="2" class="">@lang('JUMLAH')</th>
                    <th rowspan="2" class="">@lang('IDM')</th>
                    <th rowspan="2" class="">@lang('OMI')</th>
                    <th rowspan="2" class="">@lang('SP')</th>
                </tr>
                <tr>
                    <th class="right">@lang('QTYB')</th>
                    <th class="right">@lang('K')</th>
                    <th class="right">@lang('QTYB')</th>
                    <th class="right">@lang('K')</th>
                    <th class="right">@lang('QTYB')</th>
                    <th class="right">@lang('K')</th>
                </tr>
                </thead>
                <tbody style="border-bottom: 1px solid black; border-top: 1px solid black">
                {{$totalAll = 0}}
                @for($j = $i; $j < sizeof($data); $j++)
                    @if($data[$j]->pbh_nopb == $data[$i]->pbh_nopb && $data[$j]->supplier == $data[$i]->supplier)
                        @if($j == 0)
                            <tr>
                                <td class="left">@lang('Departement')</td>
                                <td class="left" colspan="16">: {{$data[$j]->departement}}</td>
                            </tr>
                            <tr>
                                <td class="left">@lang('Kategori')</td>
                                <td class="left"  colspan="16"> : {{$data[$j]->kategori}}</td>
                            </tr>
                            {{$totalsupplier = 0}}
                            {{$totalkategori = 0}}
                            {{$kategori = 0}}
                        @else
                            @if($data[$j]->departement != $data[$j-1]->departement)
                                <tr>
                                    <td class="left">@lang('Departement')</td>
                                    <td class="left" colspan="16">: {{$data[$j]->departement}}</td>
                                </tr>
                                <tr>
                                    <td class="left">@lang('Kategori')</td>
                                    <td class="left" colspan="16">: {{$data[$j]->kategori}}</td>
                                </tr>
                                {{$totalkategori = 0}}
                                {{$kategori = 0}}
                            @elseif($data[$j]->kategori != $data[$j-1]->kategori)
                                <tr>
                                    <td class="left">@lang('Kategori')</td>
                                    <td class="left" colspan="16">: {{$data[$j]->kategori}}</td>
                                </tr>
                                {{$kategori = 0}}
                            @endif
                        @endif
                        {{--                            ISI TABLE--}}
                        <tr style="text-align: right">
                            <td style="text-align: left">{{$data[$j]->pbd_prdcd}}</td>
                            <td style="text-align: left">{{$data[$j]->prd_deskripsipanjang}}</td>
                            <td>{{$data[$j]->satuan}}</td>
                            <td>{{$data[$j]->tag}}</td>
                            <td>{{$data[$j]->stock_qty}}</td>
                            <td>{{$data[$j]->stock_qtyk}}</td>
                            <td>{{$data[$j]->pkm_qty}}</td>
                            <td>{{$data[$j]->pkm_qtyk}}</td>
                            <td>{{$data[$j]->pbd_ostpo}}</td>
                            <td>{{$data[$j]->pbd_ostpb}}</td>
                            <td>{{$data[$j]->qty}}</td>
                            <td>{{$data[$j]->qtyk}}</td>
                            @if($tipepb == 'R')
                                <td>{{$data[$j]->prd_minorder}}</td>
                            @else
                                <td>{{$data[$j]->min_minorder}}</td>
                            @endif
                            <td>{{number_format( $data[$j]->gross ,0,',','.')}}</td>
                            @if($data[$j]->idm == '0')
                                <td style="text-align: center"> </td>
                            @else
                                <td style="text-align: center">*</td>
                            @endif
                            @if($data[$j]->omi == '0')
                                <td style="text-align: center"> </td>
                            @else
                                <td style="text-align: center">*</td>
                            @endif
                            <td style="text-align: center"> </td>
                        </tr>

                        {{--                            PERHITUNGAN TOTAL--}}
                        {{$kategori = $kategori + $data[$j]->gross }}
                        {{$totalkategori = $totalkategori + $data[$j]->gross }}
                        {{$totalsupplier = $totalsupplier + $data[$j]->gross  }}
                        {{$totalAll = $totalAll + $data[$j]->gross   }}

                        {{--                            PENULISAN TOTAL--}}
                        @if(isset($data[$j+1]))
                            @if($data[$i]->supplier != $data[$j+1]->supplier)
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Kategori : ')</td>
                                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                                </tr>
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Departement : ')</td>
                                    <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                                </tr>
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Supplier : ')</td>
                                    <td>{{number_format( $totalsupplier,0,',','.')}}</td>
                                </tr>
                            @elseif($data[$j]->departement != $data[$j+1]->departement)
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Kategori : ')</td>
                                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                                </tr>
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Departement : ')</td>
                                    <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                                </tr>
                            @elseif($data[$j]->kategori != $data[$j+1]->kategori)
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Kategori : ')</td>
                                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                                </tr>
                            @endif
                        @endif

                    @endif
                @endfor
                </tbody>
            </table>
        @else <!-- IF I ==0 -->
        @if($data[$i]->pbh_nopb != $data[$i-1]->pbh_nopb || $data[$i]->supplier != $data[$i-1]->supplier)
            <div class="page-break"></div>
            <div style="line-height: 0.3 !important;  ">
                <p>No. PB : {{$data[$i]->pbh_nopb}}</p>
                <p>Supplier: {{$data[$i]->supplier}}</p>
{{--                @php$totalsupplier = 0@endphp--}}
                <p style="font-size: 0">{{$totalsupplier = 0}}</p>
            </div>
            <table class="table">
                <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <tr>
                    <th rowspan="2" class="">@lang('PLU')</th>
                    <th rowspan="2" class="">@lang('DESKRIPSI')</th>
                    <th rowspan="2" class="">@lang('SATUAN')</th>
                    <th rowspan="2" class="">@lang('TAG</th>
                    <th colspan="2" class="">@lang('----STOK-----')</th>
                    <th colspan="2" class="">@lang('-----PKM------')</th>
                    <th rowspan="2" class="">@lang('QTY')<br>PO OUT</th>
                    <th rowspan="2" class="">@lang('QTY')<br>PB OUT</th>
                    <th colspan="2" class="">@lang('---ORDER---')</th>
                    <th rowspan="2" class="">@lang('MIN ORDER')</th>
                    <th rowspan="2" class="">@lang('JUMLAH')</th>
                    <th rowspan="2" class="">@lang('IDM')</th>
                    <th rowspan="2" class="">@lang('OMI')</th>
                    <th rowspan="2" class="">@lang('SP')</th>
                </tr>
                <tr>
                    <th class="">@lang('QTYB')</th>
                    <th class="">@lang('K')</th>
                    <th class="">@lang('QTYB')</th>
                    <th class="">@lang('K')</th>
                    <th class="">@lang('QTYB')</th>
                    <th class="">@lang('K')</th>
                </tr>
                </thead>
                <tbody style="border-bottom: 1px solid black">
                @for($j = $i; $j < sizeof($data); $j++)
                    @if($data[$j]->pbh_nopb == $data[$i]->pbh_nopb && $data[$j]->supplier == $data[$i]->supplier)
                        @if($data[$j]->supplier != $data[$j-1]->supplier || $data[$j]->pbh_nopb != $data[$j-1]->pbh_nopb)
                            <tr>
                                <td class="left">@lang('Departement')</td>
                                <td class="left" colspan="16">: {{$data[$j]->departement}}</td>
                            </tr>
                            <tr>
                                <td class="left">@lang('Kategori')</td>
                                <td class="left" colspan="16">: {{$data[$j]->kategori}}</td>
                            </tr>
                            {{$totalsuplier = 0}}
                            {{$totalkategori = 0}}
                            {{$kategori = 0}}
                        @elseif($data[$j]->departement != $data[$j-1]->departement)
                            <tr>
                                <td class="left">@lang('Departement')</td>
                                <td class="left" colspan="16">: {{$data[$j]->departement}}</td>
                            </tr>
                            <tr>
                                <td class="left">@lang('Kategori')</td>
                                <td class="left" colspan="16">: {{$data[$j]->kategori}}</td>
                            </tr>
                            {{$totalkategori = 0}}
                            {{$kategori = 0}}
                        @elseif($data[$j]->kategori != $data[$j-1]->kategori)
                            <tr>
                                <td class="left">@lang('Kategori')</td>
                                <td class="left" colspan="16">: {{$data[$j]->kategori}}</td>
                            </tr>
                            {{$kategori = 0}}
                        @endif

                        {{--                            ISI TABLE--}}
                        <tr style="text-align: right">
                            <td style="text-align: left">{{$data[$j]->pbd_prdcd}}</td>
                            <td style="text-align: left">{{$data[$j]->prd_deskripsipanjang}}</td>
                            <td>{{$data[$j]->satuan}}</td>
                            <td>{{$data[$j]->tag}}</td>
                            <td>{{$data[$j]->stock_qty}}</td>
                            <td>{{$data[$j]->stock_qtyk}}</td>
                            <td>{{$data[$j]->pkm_qty}}</td>
                            <td>{{$data[$j]->pkm_qtyk}}</td>
                            <td>{{$data[$j]->pbd_ostpo}}</td>
                            <td>{{$data[$j]->pbd_ostpb}}</td>
                            <td>{{$data[$j]->qty}}</td>
                            <td>{{$data[$j]->qtyk}}</td>
                            @if($tipepb == 'R')
                                <td>{{$data[$j]->prd_minorder}}</td>
                            @else
                                <td>{{$data[$j]->min_minorder}}</td>
                            @endif
                            <td>{{number_format( $data[$j]->gross ,0,',','.')}}</td>
                            @if($data[$j]->idm == '0')
                                <td style="text-align: center"> </td>
                            @else
                                <td style="text-align: center">*</td>
                            @endif
                            @if($data[$j]->omi == '0')
                                <td style="text-align: center"> </td>
                            @else
                                <td style="text-align: center">*</td>
                            @endif
                            <td style="text-align: center"> </td>
                        </tr>

                        {{--                            PERHITUNGAN TOTAL--}}
                        {{$kategori = $kategori + $data[$j]->gross }}
                        {{$totalkategori = $totalkategori + $data[$j]->gross }}
                        {{$totalsupplier = $totalsupplier + $data[$j]->gross  }}
                        {{$totalAll = $totalAll + $data[$j]->gross   }}

                        {{--                            PENULISAN TOTAL--}}
                        @if(isset($data[$j+1]))
                            @if($data[$i]->supplier != $data[$j+1]->supplier)
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Kategori : ')</td>
                                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                                </tr>
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Departement : ')</td>
                                    <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                                </tr>
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Supplier : ')</td>
                                    <td>{{number_format( $totalsupplier,0,',','.')}}</td>
                                </tr>
                            @elseif($data[$j]->departement != $data[$j+1]->departement)
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Kategori : ')</td>
                                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                                </tr>
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Departement : ')</td>
                                    <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                                </tr>
                            @elseif($data[$j]->kategori != $data[$j+1]->kategori)
                                <tr style="text-align: right; font-weight: bold">
                                    <td colspan="13">@lang('Total Kategori : ')</td>
                                    <td>{{number_format( $kategori ,0,',','.')}}</td>
                                </tr>
                            @endif
                        @else <!-- TOTAL UNTUK DATA PALING AKHIR -->
                        <tr style="text-align: right; font-weight: bold">
                            <td colspan="13">@lang('Total Kategori : ')</td>
                            <td>{{number_format( $kategori ,0,',','.')}}</td>
                        </tr>
                        <tr style="text-align: right; font-weight: bold">
                            <td colspan="13">@lang('Total Departement : ')</td>
                            <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                        </tr>
                        <tr style="text-align: right; font-weight: bold">
                            <td colspan="13">@lang('Total Supplier : ')</td>
                            <td>{{number_format( $totalsupplier,0,',','.')}}</td>
                        </tr>
                        <tr style="text-align: right; font-weight: bold">
                            <td colspan="13">@lang('Total Akhir : ')</td>
                            <td>{{number_format( $totalAll,0,',','.')}}</td>
                        </tr>
                        @endif
                    @endif
                @endfor
                </tbody>
            </table>
        @endif
        @endif
    @endfor

    <p class="right">Keterangan : Kolom Omi = '*'  -> Khusus Plu OMI: Kolom Idm = '*'  -> Khusus Plu IDM: Kolom Super Promo = '*'  -> Khusus Plu Promo</p>

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
{{--        margin: 25px 10px;--}}
{{--    }--}}

{{--    /** Define now the real margins of every page in the PDF **/--}}
{{--    body {--}}
{{--        margin-top: 70px;--}}
{{--        margin-bottom: 10px;--}}
{{--        font-size: 8px;--}}
{{--        /*font-size: 9px;*/--}}
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

{{--    .page-break {--}}
{{--        page-break-after: always;--}}
{{--    }--}}
{{--</style>--}}


{{--<body>--}}
{{--<!-- Define header and footer blocks before your content -->--}}
{{--<?php--}}
{{--$i = 1;--}}
{{--$datetime = new DateTime();--}}
{{--$timezone = new DateTimeZone('Asia/Jakarta');--}}
{{--$datetime->setTimezone($timezone);--}}
{{--?>--}}

{{--<div class="page-break"></div>--}}

{{--@if($data)--}}
{{--    <header>--}}
{{--        <div style="float:left; margin-top: -20px; line-height: 5px !important;">--}}
{{--            <p>{{$data[0]->prs_namaperusahaan}}</p>--}}
{{--            <p>{{$data[0]->prs_namacabang}}</p>--}}
{{--        </div>--}}
{{--        <div style="float:right; margin-top: 0px; line-height: 5px !important;">--}}
{{--            <p>{{ date("d-M-y  H:i:s") }}</p>--}}
{{--        </div>--}}
{{--        <div style="line-height: 0.3 !important; text-align: center !important;">--}}
{{--            <h2 style="">DAFTAR PB / SUPPLIER </h2>--}}
{{--            <p style="font-size: 10px !important;">TANGGAL : {{date('d-m-Y', strtotime($date1)) }} s/d {{date('d-m-Y', strtotime($date2)) }}</p>--}}
{{--        </div>--}}
{{--    </header>--}}

{{--    <main>--}}

{{--        @for($i=0; $i<sizeof($data); $i++)--}}
{{--            @if($i == 0)--}}
{{--                <div style="line-height: 0.3 !important;  ">--}}
{{--                    <p>No. PB : {{$data[$i]->pbh_nopb}}</p>--}}
{{--                    <p>Supplier: {{$data[$i]->supplier}}</p>--}}
{{--                </div>--}}

{{--                <table class="table table-bordered table-responsive" style="">--}}
{{--                    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
{{--                    <tr style="text-align: center;">--}}
{{--                        <th rowspan="2" style="width: 5px; text-align: left">PLU</th>--}}
{{--                        <th rowspan="2" style="width: 275px; text-align: left">DESKRIPSI</th>--}}
{{--                        <th rowspan="2" style="width: 15px">SATUAN</th>--}}
{{--                        <th rowspan="2" style="width: 15px">TAG</th>--}}
{{--                        <th colspan="2" style="width: 50px">----STOK-----</th>--}}
{{--                        <th colspan="2" style="width: 50px">-----PKM------</th>--}}
{{--                        <th rowspan="2" style="width: 30px">QTY<br>PO OUT</th>--}}
{{--                        <th rowspan="2" style="width: 30px">QTY<br>PB OUT</th>--}}
{{--                        <th colspan="2" style="width: 50px">---ORDER---</th>--}}
{{--                        <th rowspan="2" style="width: 12px;">MIN ORDER</th>--}}
{{--                        <th rowspan="2" style="width: 45px; text-align: right">JUMLAH</th>--}}
{{--                        <th rowspan="2" style="width: 8px">IDM</th>--}}
{{--                        <th rowspan="2" style="width: 8px">OMI</th>--}}
{{--                        <th rowspan="2" style="width: 8px">SP</th>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <th style="text-align: right">QTYB</th>--}}
{{--                        <th style="text-align: right">K</th>--}}
{{--                        <th style="text-align: right">QTYB</th>--}}
{{--                        <th style="text-align: right">K</th>--}}
{{--                        <th style="text-align: right">QTYB</th>--}}
{{--                        <th style="text-align: right">K</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody style="border-bottom: 1px solid black">--}}
{{--                        @for($j = $i; $j < sizeof($data); $j++)--}}
{{--                            @if($data[$j]->pbh_nopb == $data[$i]->pbh_nopb && $data[$j]->supplier == $data[$i]->supplier)--}}
{{--                                @if($j == 0)--}}
{{--                                    <tr>--}}
{{--                                        <td>Departement</td>--}}
{{--                                        <td>: {{$data[$j]->departement}}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Kategori</td>--}}
{{--                                        <td>: {{$data[$j]->kategori}}</td>--}}
{{--                                    </tr>--}}
{{--                                    {{$totalsupplier = 0}}--}}
{{--                                    {{$totalkategori = 0}}--}}
{{--                                    {{$kategori = 0}}--}}
{{--                                @else--}}
{{--                                    @if($data[$j]->departement != $data[$j-1]->departement)--}}
{{--                                        <tr>--}}
{{--                                            <td>Departement</td>--}}
{{--                                            <td>: {{$data[$j]->departement}}</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <td>Kategori</td>--}}
{{--                                            <td>: {{$data[$j]->kategori}}</td>--}}
{{--                                        </tr>--}}
{{--                                        {{$totalkategori = 0}}--}}
{{--                                        {{$kategori = 0}}--}}
{{--                                    @elseif($data[$j]->kategori != $data[$j-1]->kategori)--}}
{{--                                        <tr>--}}
{{--                                            <td>Kategori</td>--}}
{{--                                            <td>: {{$data[$j]->kategori}}</td>--}}
{{--                                        </tr>--}}
{{--                                        {{$kategori = 0}}--}}
{{--                                    @endif--}}
{{--                                @endif--}}
{{--                                ISI TABLE--}}
{{--                                <tr style="text-align: right">--}}
{{--                                    <td style="text-align: left">{{$data[$j]->pbd_prdcd}}</td>--}}
{{--                                    <td style="text-align: left">{{$data[$j]->prd_deskripsipanjang}}</td>--}}
{{--                                    <td>{{$data[$j]->satuan}}</td>--}}
{{--                                    <td>{{$data[$j]->tag}}</td>--}}
{{--                                    <td>{{$data[$j]->stock_qty}}</td>--}}
{{--                                    <td>{{$data[$j]->stock_qtyk}}</td>--}}
{{--                                    <td>{{$data[$j]->pkm_qty}}</td>--}}
{{--                                    <td>{{$data[$j]->pkm_qtyk}}</td>--}}
{{--                                    <td>{{$data[$j]->pbd_ostpo}}</td>--}}
{{--                                    <td>{{$data[$j]->pbd_ostpb}}</td>--}}
{{--                                    <td>{{$data[$j]->qty}}</td>--}}
{{--                                    <td>{{$data[$j]->qtyk}}</td>--}}
{{--                                    @if($tipepb == 'R')--}}
{{--                                        <td>{{$data[$j]->prd_minorder}}</td>--}}
{{--                                    @else--}}
{{--                                        <td>{{$data[$j]->min_minorder}}</td>--}}
{{--                                    @endif--}}
{{--                                    <td>{{number_format( $data[$j]->gross ,0,',','.')}}</td>--}}
{{--                                    @if($data[$j]->idm == '0')--}}
{{--                                        <td style="text-align: center"> </td>--}}
{{--                                    @else--}}
{{--                                        <td style="text-align: center">*</td>--}}
{{--                                    @endif--}}
{{--                                    @if($data[$j]->omi == '0')--}}
{{--                                        <td style="text-align: center"> </td>--}}
{{--                                    @else--}}
{{--                                        <td style="text-align: center">*</td>--}}
{{--                                    @endif--}}
{{--                                    <td style="text-align: center">?</td>--}}
{{--                                </tr>--}}

{{--                                PERHITUNGAN TOTAL--}}
{{--                                {{$kategori = $kategori + $data[$j]->gross }}--}}
{{--                                {{$totalkategori = $totalkategori + $data[$j]->gross }}--}}
{{--                                {{$totalsupplier = $totalsupplier + $data[$j]->gross  }}--}}

{{--                                PENULISAN TOTAL--}}
{{--                                @if(isset($data[$j+1]))--}}
{{--                                    @if($data[$i]->supplier != $data[$j+1]->supplier)--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Kategori :</td>--}}
{{--                                            <td>{{number_format( $kategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Departement : </td>--}}
{{--                                            <td>{{number_format( $totalkategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Supplier : </td>--}}
{{--                                            <td>{{number_format( $totalsupplier,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @elseif($data[$j]->departement != $data[$j+1]->departement)--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Kategori :</td>--}}
{{--                                            <td>{{number_format( $kategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Departement : </td>--}}
{{--                                            <td>{{number_format( $totalkategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @elseif($data[$j]->kategori != $data[$j+1]->kategori)--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Kategori :</td>--}}
{{--                                            <td>{{number_format( $kategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endif--}}
{{--                                @endif--}}

{{--                            @endif--}}
{{--                        @endfor--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            @else <!-- IF I ==0 -->--}}
{{--                @if($data[$i]->pbh_nopb != $data[$i-1]->pbh_nopb || $data[$i]->supplier != $data[$i-1]->supplier)--}}
{{--                    <div class="page-break"></div>--}}
{{--                    <div style="line-height: 0.3 !important;  ">--}}
{{--                        <p>No. PB : {{$data[$i]->pbh_nopb}}</p>--}}
{{--                        <p>Supplier: {{$data[$i]->supplier}}</p>--}}
{{--                        {{$totalsupplier = 0}}--}}
{{--                    </div>--}}
{{--                    <table>--}}
{{--                        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
{{--                        <tr style="text-align: center;">--}}
{{--                            <th rowspan="2" style="width: 5px; text-align: left">PLU</th>--}}
{{--                            <th rowspan="2" style="width: 275px; text-align: left">DESKRIPSI</th>--}}
{{--                            <th rowspan="2" style="width: 15px">SATUAN</th>--}}
{{--                            <th rowspan="2" style="width: 15px">TAG</th>--}}
{{--                            <th colspan="2" style="width: 50px">----STOK-----</th>--}}
{{--                            <th colspan="2" style="width: 50px">-----PKM------</th>--}}
{{--                            <th rowspan="2" style="width: 30px">QTY<br>PO OUT</th>--}}
{{--                            <th rowspan="2" style="width: 30px">QTY<br>PB OUT</th>--}}
{{--                            <th colspan="2" style="width: 50px">---ORDER---</th>--}}
{{--                            <th rowspan="2" style="width: 12px;">MIN ORDER</th>--}}
{{--                            <th rowspan="2" style="width: 45px; text-align: right">JUMLAH</th>--}}
{{--                            <th rowspan="2" style="width: 8px">IDM</th>--}}
{{--                            <th rowspan="2" style="width: 8px">OMI</th>--}}
{{--                            <th rowspan="2" style="width: 8px">SP</th>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <th style="text-align: right">QTYB</th>--}}
{{--                            <th style="text-align: right">K</th>--}}
{{--                            <th style="text-align: right">QTYB</th>--}}
{{--                            <th style="text-align: right">K</th>--}}
{{--                            <th style="text-align: right">QTYB</th>--}}
{{--                            <th style="text-align: right">K</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody style="border-bottom: 1px solid black">--}}
{{--                        @for($j = $i; $j < sizeof($data); $j++)--}}
{{--                            @if($data[$j]->pbh_nopb == $data[$i]->pbh_nopb && $data[$j]->supplier == $data[$i]->supplier)--}}
{{--                                @if($data[$j]->supplier != $data[$j-1]->supplier || $data[$j]->pbh_nopb != $data[$j-1]->pbh_nopb)--}}
{{--                                <tr>--}}
{{--                                    <td>Departement</td>--}}
{{--                                    <td>: {{$data[$j]->departement}}</td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>Kategori</td>--}}
{{--                                    <td>: {{$data[$j]->kategori}}</td>--}}
{{--                                </tr>--}}
{{--                                {{$totalsuplier = 0}}--}}
{{--                                {{$totalkategori = 0}}--}}
{{--                                {{$kategori = 0}}--}}
{{--                                @elseif($data[$j]->departement != $data[$j-1]->departement)--}}
{{--                                    <tr>--}}
{{--                                        <td>Departement</td>--}}
{{--                                        <td>: {{$data[$j]->departement}}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Kategori</td>--}}
{{--                                        <td>: {{$data[$j]->kategori}}</td>--}}
{{--                                    </tr>--}}
{{--                                    {{$totalkategori = 0}}--}}
{{--                                    {{$kategori = 0}}--}}
{{--                                @elseif($data[$j]->kategori != $data[$j-1]->kategori)--}}
{{--                                    <tr>--}}
{{--                                        <td>Kategori</td>--}}
{{--                                        <td>: {{$data[$j]->kategori}}</td>--}}
{{--                                    </tr>--}}
{{--                                    {{$kategori = 0}}--}}
{{--                                @endif--}}

{{--                                ISI TABLE--}}
{{--                                <tr style="text-align: right">--}}
{{--                                    <td style="text-align: left">{{$data[$j]->pbd_prdcd}}</td>--}}
{{--                                    <td style="text-align: left">{{$data[$j]->prd_deskripsipanjang}}</td>--}}
{{--                                    <td>{{$data[$j]->satuan}}</td>--}}
{{--                                    <td>{{$data[$j]->tag}}</td>--}}
{{--                                    <td>{{$data[$j]->stock_qty}}</td>--}}
{{--                                    <td>{{$data[$j]->stock_qtyk}}</td>--}}
{{--                                    <td>{{$data[$j]->pkm_qty}}</td>--}}
{{--                                    <td>{{$data[$j]->pkm_qtyk}}</td>--}}
{{--                                    <td>{{$data[$j]->pbd_ostpo}}</td>--}}
{{--                                    <td>{{$data[$j]->pbd_ostpb}}</td>--}}
{{--                                    <td>{{$data[$j]->qty}}</td>--}}
{{--                                    <td>{{$data[$j]->qtyk}}</td>--}}
{{--                                    @if($tipepb == 'R')--}}
{{--                                        <td>{{$data[$j]->prd_minorder}}</td>--}}
{{--                                    @else--}}
{{--                                        <td>{{$data[$j]->min_minorder}}</td>--}}
{{--                                    @endif--}}
{{--                                    <td>{{number_format( $data[$j]->gross ,0,',','.')}}</td>--}}
{{--                                    @if($data[$j]->idm == '0')--}}
{{--                                        <td style="text-align: center"> </td>--}}
{{--                                    @else--}}
{{--                                        <td style="text-align: center">*</td>--}}
{{--                                    @endif--}}
{{--                                    @if($data[$j]->omi == '0')--}}
{{--                                        <td style="text-align: center"> </td>--}}
{{--                                    @else--}}
{{--                                        <td style="text-align: center">*</td>--}}
{{--                                    @endif--}}
{{--                                    <td style="text-align: center">?</td>--}}
{{--                                </tr>--}}

{{--                                PERHITUNGAN TOTAL--}}
{{--                                {{$kategori = $kategori + $data[$j]->gross }}--}}
{{--                                {{$totalkategori = $totalkategori + $data[$j]->gross }}--}}
{{--                                {{$totalsupplier = $totalsupplier + $data[$j]->gross  }}--}}

{{--                                PENULISAN TOTAL--}}
{{--                                @if(isset($data[$j+1]))--}}
{{--                                    @if($data[$i]->supplier != $data[$j+1]->supplier)--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Kategori :</td>--}}
{{--                                            <td>{{number_format( $kategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Departement : </td>--}}
{{--                                            <td>{{number_format( $totalkategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Supplier : </td>--}}
{{--                                            <td>{{number_format( $totalsupplier,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @elseif($data[$j]->departement != $data[$j+1]->departement)--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Kategori :</td>--}}
{{--                                            <td>{{number_format( $kategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Departement : </td>--}}
{{--                                            <td>{{number_format( $totalkategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @elseif($data[$j]->kategori != $data[$j+1]->kategori)--}}
{{--                                        <tr style="text-align: right; font-weight: bold">--}}
{{--                                            <td colspan="13">Total Kategori :</td>--}}
{{--                                            <td>{{number_format( $kategori ,0,',','.')}}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endif--}}
{{--                                @else <!-- TOTAL UNTUK DATA PALING AKHIR -->--}}
{{--                                    <tr style="text-align: right; font-weight: bold">--}}
{{--                                        <td colspan="13">Total Kategori :</td>--}}
{{--                                        <td>{{number_format( $kategori ,0,',','.')}}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr style="text-align: right; font-weight: bold">--}}
{{--                                        <td colspan="13">Total Departement : </td>--}}
{{--                                        <td>{{number_format( $totalkategori ,0,',','.')}}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr style="text-align: right; font-weight: bold">--}}
{{--                                        <td colspan="13">Total Supplier : </td>--}}
{{--                                        <td>{{number_format( $totalsupplier,0,',','.')}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
{{--                            @endif--}}
{{--                        @endfor--}}
{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                @endif--}}
{{--            @endif--}}
{{--        @endfor--}}
{{--        <p style="text-align: right"> ** Akhir Dari Laporan ** </p>--}}
{{--    </main>--}}

{{--@else--}}
{{--    <header>--}}
{{--        <div style="float:left; margin-top: -20px; line-height: 5px !important;">--}}
{{--            <p>--</p>--}}
{{--            <p>--</p>--}}
{{--        </div>--}}
{{--        <div style="float:right; margin-top: 0px; line-height: 5px !important;">--}}
{{--            <p>{{ date("d-M-y  H:i:s") }}</p>--}}
{{--        </div>--}}
{{--        <div style="line-height: 0.3 !important; text-align: center !important;">--}}
{{--            <h2 style="">DAFTAR PB / SUPPLIER </h2>--}}
{{--            <p style="font-size: 10px !important;">TANGGAL : -- s/d --</p>--}}
{{--        </div>--}}
{{--    </header>--}}

{{--    <main>--}}
{{--        <table class="table table-bordered table-responsive" style="">--}}
{{--            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">--}}
{{--            <tr style="text-align: center;">--}}
{{--                <th rowspan="2" style="width: 40px; text-align: left">PLU</th>--}}
{{--                <th rowspan="2" style="width: 150px; text-align: left">DESKRIPSI</th>--}}
{{--                <th rowspan="2" style="width: 28px">SATUAN</th>--}}
{{--                <th rowspan="2" style="width: 28px">TAG</th>--}}
{{--                <th colspan="2" style="width: 50px">----STOK-----</th>--}}
{{--                <th colspan="2" style="width: 50px">-----PKM------</th>--}}
{{--                <th rowspan="2" style="width: 30px">QTY<br>PO OUT</th>--}}
{{--                <th rowspan="2" style="width: 30px">QTY<br>PB OUT</th>--}}
{{--                <th colspan="2" style="width: 50px">---ORDER---</th>--}}
{{--                <th rowspan="2" style="width: 12px;">MIN ORDER</th>--}}
{{--                <th rowspan="2" style="width: 45px; text-align: right">JUMLAH</th>--}}
{{--                <th rowspan="2" style="width: 8px">IDM</th>--}}
{{--                <th rowspan="2" style="width: 8px">OMI</th>--}}
{{--                <th rowspan="2" style="width: 8px">SP</th>--}}
{{--            </tr>--}}
{{--            <tr>--}}
{{--                <th style="text-align: right">QTYB</th>--}}
{{--                <th style="text-align: right">K</th>--}}
{{--                <th style="text-align: right">QTYB</th>--}}
{{--                <th style="text-align: right">K</th>--}}
{{--                <th style="text-align: right">QTYB</th>--}}
{{--                <th style="text-align: right">K</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody style="border-bottom: 1px solid black">--}}
{{--            <tr>--}}
{{--                <td colspan="17" style="text-align: center">** No Data **</td>--}}
{{--            </tr>--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </main>--}}
{{--@endif--}}

{{--</body>--}}
{{--</html>--}}
