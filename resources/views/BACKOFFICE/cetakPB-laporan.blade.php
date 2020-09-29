<html>
<head>
    <title>LAPORAN</title>
</head>
<style>
    /**
        Set the margins of the page to 0, so the footer and the header
        can be of the full height and width !
     **/
    @page {
        margin: 25px 10px;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 70px;
        margin-bottom: 10px;
        font-size: 8px;
        /*font-size: 9px;*/
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }
    .page-numbers:after { content: counter(page); }

    .page-break {
        page-break-after: always;
    }
</style>


<body>
<!-- Define header and footer blocks before your content -->
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>

{{--<div class="page-break"></div>--}}

@if($datas)
    <header>
        <div style="float:left; margin-top: -20px; line-height: 5px !important;">
            <p>{{$datas[0]->prs_namaperusahaan}}</p>
            <p>{{$datas[0]->prs_namacabang}}</p>
        </div>
        <div style="float:right; margin-top: 0px; line-height: 5px !important;">
            <p>{{ date("d-M-y  H:i:s") }}</p>
        </div>
        <div style="line-height: 0.3 !important; text-align: center !important;">
            <h2 style="">DAFTAR PB / SUPPLIER </h2>
            <p style="font-size: 10px !important;">TANGGAL : {{date('d-m-Y', strtotime($date1)) }} s/d {{date('d-m-Y', strtotime($date2)) }}</p>
        </div>
    </header>

    <main>

        @for($i=0; $i<sizeof($datas); $i++)
            @if($i == 0)
                <div style="line-height: 0.3 !important;  ">
                    <p>No. PB : {{$datas[$i]->pbh_nopb}}</p>
                    <p>Supplier: {{$datas[$i]->supplier}}</p>
                </div>

                <table class="table table-bordered table-responsive" style="">
                    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                    <tr style="text-align: center;">
                        <th rowspan="2" style="width: 5px; text-align: left">PLU</th>
                        <th rowspan="2" style="width: 275px; text-align: left">DESKRIPSI</th>
                        <th rowspan="2" style="width: 15px">SATUAN</th>
                        <th rowspan="2" style="width: 15px">TAG</th>
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
                        @for($j = $i; $j < sizeof($datas); $j++)
                            @if($datas[$j]->pbh_nopb == $datas[$i]->pbh_nopb && $datas[$j]->supplier == $datas[$i]->supplier)
                                @if($j == 0)
                                    <tr>
                                        <td>Departement</td>
                                        <td>: {{$datas[$j]->departement}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kategori</td>
                                        <td>: {{$datas[$j]->kategori}}</td>
                                    </tr>
                                    {{$totalsupplier = 0}}
                                    {{$totalkategori = 0}}
                                    {{$kategori = 0}}
                                @else
                                    @if($datas[$j]->departement != $datas[$j-1]->departement)
                                        <tr>
                                            <td>Departement</td>
                                            <td>: {{$datas[$j]->departement}}</td>
                                        </tr>
                                        <tr>
                                            <td>Kategori</td>
                                            <td>: {{$datas[$j]->kategori}}</td>
                                        </tr>
                                        {{$totalkategori = 0}}
                                        {{$kategori = 0}}
                                    @elseif($datas[$j]->kategori != $datas[$j-1]->kategori)
                                        <tr>
                                            <td>Kategori</td>
                                            <td>: {{$datas[$j]->kategori}}</td>
                                        </tr>
                                        {{$kategori = 0}}
                                    @endif
                                @endif
                                {{--ISI TABLE--}}
                                <tr style="text-align: right">
                                    <td style="text-align: left">{{$datas[$j]->pbd_prdcd}}</td>
                                    <td style="text-align: left">{{$datas[$j]->prd_deskripsipanjang}}</td>
                                    <td>{{$datas[$j]->satuan}}</td>
                                    <td>{{$datas[$j]->tag}}</td>
                                    <td>{{$datas[$j]->stock_qty}}</td>
                                    <td>{{$datas[$j]->stock_qtyk}}</td>
                                    <td>{{$datas[$j]->pkm_qty}}</td>
                                    <td>{{$datas[$j]->pkm_qtyk}}</td>
                                    <td>{{$datas[$j]->pbd_ostpo}}</td>
                                    <td>{{$datas[$j]->pbd_ostpb}}</td>
                                    <td>{{$datas[$j]->qty}}</td>
                                    <td>{{$datas[$j]->qtyk}}</td>
                                    @if($tipepb == 'R')
                                        <td>{{$datas[$j]->prd_minorder}}</td>
                                    @else
                                        <td>{{$datas[$j]->min_minorder}}</td>
                                    @endif
                                    <td>{{number_format( $datas[$j]->gross ,0,',','.')}}</td>
                                    @if($datas[$j]->idm == '0')
                                        <td style="text-align: center"> </td>
                                    @else
                                        <td style="text-align: center">*</td>
                                    @endif
                                    @if($datas[$j]->omi == '0')
                                        <td style="text-align: center"> </td>
                                    @else
                                        <td style="text-align: center">*</td>
                                    @endif
                                    <td style="text-align: center">?</td>
                                </tr>

                                {{--PERHITUNGAN TOTAL--}}
                                {{$kategori = $kategori + $datas[$j]->gross }}
                                {{$totalkategori = $totalkategori + $datas[$j]->gross }}
                                {{$totalsupplier = $totalsupplier + $datas[$j]->gross  }}

                                {{--PENULISAN TOTAL--}}
                                @if(isset($datas[$j+1]))
                                    @if($datas[$i]->supplier != $datas[$j+1]->supplier)
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
                                            <td>{{number_format( $totalsupplier,0,',','.')}}</td>
                                        </tr>
                                    @elseif($datas[$j]->departement != $datas[$j+1]->departement)
                                        <tr style="text-align: right; font-weight: bold">
                                            <td colspan="13">Total Kategori :</td>
                                            <td>{{number_format( $kategori ,0,',','.')}}</td>
                                        </tr>
                                        <tr style="text-align: right; font-weight: bold">
                                            <td colspan="13">Total Departement : </td>
                                            <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                                        </tr>
                                    @elseif($datas[$j]->kategori != $datas[$j+1]->kategori)
                                        <tr style="text-align: right; font-weight: bold">
                                            <td colspan="13">Total Kategori :</td>
                                            <td>{{number_format( $kategori ,0,',','.')}}</td>
                                        </tr>
                                    @endif
                                @endif

                            @endif
                        @endfor
                    </tbody>
                </table>
            @else <!-- IF I ==0 -->
                @if($datas[$i]->pbh_nopb != $datas[$i-1]->pbh_nopb || $datas[$i]->supplier != $datas[$i-1]->supplier)
                    <div class="page-break"></div>
                    <div style="line-height: 0.3 !important;  ">
                        <p>No. PB : {{$datas[$i]->pbh_nopb}}</p>
                        <p>Supplier: {{$datas[$i]->supplier}}</p>
                        {{$totalsupplier = 0}}
                    </div>
                    <table>
                        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                        <tr style="text-align: center;">
                            <th rowspan="2" style="width: 5px; text-align: left">PLU</th>
                            <th rowspan="2" style="width: 275px; text-align: left">DESKRIPSI</th>
                            <th rowspan="2" style="width: 15px">SATUAN</th>
                            <th rowspan="2" style="width: 15px">TAG</th>
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
                        @for($j = $i; $j < sizeof($datas); $j++)
                            @if($datas[$j]->pbh_nopb == $datas[$i]->pbh_nopb && $datas[$j]->supplier == $datas[$i]->supplier)
                                @if($datas[$j]->supplier != $datas[$j-1]->supplier || $datas[$j]->pbh_nopb != $datas[$j-1]->pbh_nopb)
                                <tr>
                                    <td>Departement</td>
                                    <td>: {{$datas[$j]->departement}}</td>
                                </tr>
                                <tr>
                                    <td>Kategori</td>
                                    <td>: {{$datas[$j]->kategori}}</td>
                                </tr>
                                {{$totalsuplier = 0}}
                                {{$totalkategori = 0}}
                                {{$kategori = 0}}
                                @elseif($datas[$j]->departement != $datas[$j-1]->departement)
                                    <tr>
                                        <td>Departement</td>
                                        <td>: {{$datas[$j]->departement}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kategori</td>
                                        <td>: {{$datas[$j]->kategori}}</td>
                                    </tr>
                                    {{$totalkategori = 0}}
                                    {{$kategori = 0}}
                                @elseif($datas[$j]->kategori != $datas[$j-1]->kategori)
                                    <tr>
                                        <td>Kategori</td>
                                        <td>: {{$datas[$j]->kategori}}</td>
                                    </tr>
                                    {{$kategori = 0}}
                                @endif

                                {{--ISI TABLE--}}
                                <tr style="text-align: right">
                                    <td style="text-align: left">{{$datas[$j]->pbd_prdcd}}</td>
                                    <td style="text-align: left">{{$datas[$j]->prd_deskripsipanjang}}</td>
                                    <td>{{$datas[$j]->satuan}}</td>
                                    <td>{{$datas[$j]->tag}}</td>
                                    <td>{{$datas[$j]->stock_qty}}</td>
                                    <td>{{$datas[$j]->stock_qtyk}}</td>
                                    <td>{{$datas[$j]->pkm_qty}}</td>
                                    <td>{{$datas[$j]->pkm_qtyk}}</td>
                                    <td>{{$datas[$j]->pbd_ostpo}}</td>
                                    <td>{{$datas[$j]->pbd_ostpb}}</td>
                                    <td>{{$datas[$j]->qty}}</td>
                                    <td>{{$datas[$j]->qtyk}}</td>
                                    @if($tipepb == 'R')
                                        <td>{{$datas[$j]->prd_minorder}}</td>
                                    @else
                                        <td>{{$datas[$j]->min_minorder}}</td>
                                    @endif
                                    <td>{{number_format( $datas[$j]->gross ,0,',','.')}}</td>
                                    @if($datas[$j]->idm == '0')
                                        <td style="text-align: center"> </td>
                                    @else
                                        <td style="text-align: center">*</td>
                                    @endif
                                    @if($datas[$j]->omi == '0')
                                        <td style="text-align: center"> </td>
                                    @else
                                        <td style="text-align: center">*</td>
                                    @endif
                                    <td style="text-align: center">?</td>
                                </tr>

                                {{--PERHITUNGAN TOTAL--}}
                                {{$kategori = $kategori + $datas[$j]->gross }}
                                {{$totalkategori = $totalkategori + $datas[$j]->gross }}
                                {{$totalsupplier = $totalsupplier + $datas[$j]->gross  }}

                                {{--PENULISAN TOTAL--}}
                                @if(isset($datas[$j+1]))
                                    @if($datas[$i]->supplier != $datas[$j+1]->supplier)
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
                                            <td>{{number_format( $totalsupplier,0,',','.')}}</td>
                                        </tr>
                                    @elseif($datas[$j]->departement != $datas[$j+1]->departement)
                                        <tr style="text-align: right; font-weight: bold">
                                            <td colspan="13">Total Kategori :</td>
                                            <td>{{number_format( $kategori ,0,',','.')}}</td>
                                        </tr>
                                        <tr style="text-align: right; font-weight: bold">
                                            <td colspan="13">Total Departement : </td>
                                            <td>{{number_format( $totalkategori ,0,',','.')}}</td>
                                        </tr>
                                    @elseif($datas[$j]->kategori != $datas[$j+1]->kategori)
                                        <tr style="text-align: right; font-weight: bold">
                                            <td colspan="13">Total Kategori :</td>
                                            <td>{{number_format( $kategori ,0,',','.')}}</td>
                                        </tr>
                                    @endif
                                @else <!-- TOTAL UNTUK DATA PALING AKHIR -->
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
                                        <td>{{number_format( $totalsupplier,0,',','.')}}</td>
                                    </tr>
                                @endif
                            @endif
                        @endfor
                        </tbody>
                    </table>
                @endif
            @endif
        @endfor
        <p style="text-align: right"> ** Akhir Dari Laporan ** </p>
    </main>

@else
    <header>
        <div style="float:left; margin-top: -20px; line-height: 5px !important;">
            <p>--</p>
            <p>--</p>
        </div>
        <div style="float:right; margin-top: 0px; line-height: 5px !important;">
            <p>{{ date("d-M-y  H:i:s") }}</p>
        </div>
        <div style="line-height: 0.3 !important; text-align: center !important;">
            <h2 style="">DAFTAR PB / SUPPLIER </h2>
            <p style="font-size: 10px !important;">TANGGAL : -- s/d --</p>
        </div>
    </header>

    <main>
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
                <td colspan="17" style="text-align: center">** No Data **</td>
            </tr>
            </tbody>
        </table>
    </main>
@endif

</body>
</html>
