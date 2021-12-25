@extends('html-template')

@section('table_font_size','7 px')

@section('paper_size','842pt 595pt')
@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    DAFTAR MARGIN NEGATIF
@endsection

@section('title')
    ** DAFTAR MARGIN NEGATIF **
@endsection

@section('subtitle')
    {{$urut}}<br>
    @if($tag != '')
        TAG : {{$tag}}
    @endif
@endsection

@php
    function zeroDigit($angka){
        $digit = number_format($angka,0,'.',',');
        return $digit;
    }
    function oneDigit($angka){
        $digit = number_format($angka,1,'.',',');
        return $digit;
    }
    function twoDigit($angka){
        $digit = number_format($angka,2,'.',',');
        return $digit;
    }
    $divisi         = '';
    $departement    = '';
    $kategori       = '';


    $produkHolder   = '';
    $divProduk      = 0;
    $depProduk      = 0;
    $katProduk      = 0;
    $produk         = 0;
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: left">KODE</th>
                <th rowspan="2" style="vertical-align: middle; text-align: left">NAMA BARANG</th>
                <th rowspan="2" style="vertical-align: middle">UNIT/FRAC</th>
                <th rowspan="2" style="vertical-align: middle">HRG BELI</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">HPP TERAKHIR<br>(LCOST)</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">HPP RATA2<br>(ACOST)</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">HRG JUAL</th>
                <th colspan="3" style="vertical-align: middle; text-align: center">------------ M A R G I N ------------</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">STOCK</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">AVG SLS&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th rowspan="2" style="vertical-align: middle">TAG</th>
                <th rowspan="2" style="vertical-align: middle">KETERANGAN</th>
            </tr>
        <tr>
            <th style="text-align: right">HRG BELI</th>
            <th style="text-align: right">LCOST</th>
            <th style="text-align: right">ACOST</th>
        </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            @if($ac_margin[$i] < 0)
                @if($data[$i]->divisi != $divisi || $data[$i]->dept != $departement || $data[$i]->kategori != $kategori)
                    @if($katProduk!=0)
                        <tr style="font-weight: bold; text-align: left">
                            <td colspan="12">SUBTOTAL/KATEGORI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$katProduk}} PRODUK</td>
                        </tr>
                        @php
                            $katProduk = 0;
                        @endphp
                    @endif
                    @if($depProduk!=0 && $data[$i]->dept != $departement)
                        <tr style="font-weight: bold; text-align: left">
                            <td colspan="12">SUBTOTAL/DEPARTEMENT &nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$depProduk}} PRODUK</td>
                        </tr>
                        @php
                            $depProduk = 0;
                        @endphp
                    @endif
                    @if($divProduk!=0 && $data[$i]->divisi != $divisi)
                        <tr style="font-weight: bold; text-align: left">
                            <td colspan="12">SUBTOTAL/DIVISI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$divProduk}} PRODUK</td>
                        </tr>
                        @php
                            $divProduk = 0;
                        @endphp
                    @endif
                    <tr style="text-align: left; font-weight: bold">
                        <td colspan="4">DIVISI : {{$data[$i]->divisi}}</td>
                        <td colspan="4">DEPARTEMENT : {{$data[$i]->dept}}</td>
                        <td colspan="4">KATEGORI : {{$data[$i]->kategori}}</td>
                    </tr>
                    @php
                        $divisi = $data[$i]->divisi;
                        $departement = $data[$i]->dept;
                        $kategori = $data[$i]->kategori;
                    @endphp
                @endif
                {{--MAIN TABLE--}}
                <tr>
                    <td style="text-align: left">{{$data[$i]->prd_prdcd}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: left">{{$data[$i]->desc2}}</td>
                    <td>{{$data[$i]->satuan}}</td>
                    <td style="text-align: right">{{twoDigit($cf_mprice[$i])}}</td>
                    <td style="text-align: right">{{oneDigit($data[$i]->prd_lastcost)}}</td>
                    <td style="text-align: right">{{oneDigit($data[$i]->avgcost)}}</td>
                    @if($data[$i]->prmd_prdcd != '')
                        <td style="text-align: right">{{oneDigit($cp_njual[$i])}}</td>
                    @else
                        <td style="text-align: right">{{oneDigit($data[$i]->price_a)}}</td>
                    @endif
                    <td style="text-align: right">{{twoDigit($cp_nhbmargin[$i])}}%</td>
                    <td style="text-align: right">{{twoDigit($cp_nlcmargin[$i])}}%</td>
                    <td style="text-align: right">{{twoDigit($cp_nacmargin[$i])}}%</td>
                    <td style="text-align: right">{{zeroDigit($data[$i]->qty)}}</td>
                    <td style="text-align: right">{{twoDigit($avgsls[$i])}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>{{$data[$i]->tag}}</td>
                    @if($data[$i]->spot_prdcd != '')
                        <td style="text-align: left">PROMO</td>
                    @else
                        <td style="text-align: left">{{--CF_ket--}}</td>
                    @endif
                </tr>
                {{--MAIN TABLE--}}
                @php
                    if($produkHolder == ''){
                        $divProduk++;
                        $depProduk++;
                        $katProduk++;
                        $produk++;
                        $produkHolder = $data[$i]->prd_prdcd;
                    }elseif(substr($data[$i]->prd_prdcd,0,6) != substr($produkHolder,0,6)){
                        $divProduk++;
                        $depProduk++;
                        $katProduk++;
                        $produk++;
                        $produkHolder = $data[$i]->prd_prdcd;
                    }
                @endphp
            @endif
        @endfor
        <tr style="font-weight: bold; text-align: left">
            <td colspan="12">SUBTOTAL/KATEGORI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$katProduk}} PRODUK</td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td colspan="12">SUBTOTAL/DEPARTEMENT &nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$depProduk}} PRODUK</td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td colspan="12">SUBTOTAL/DIVISI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$divProduk}} PRODUK</td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td colspan="12">SUBTOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$produk}} PRODUK</td>
        </tr>
        </tbody>
    </table>
{{--    <p style="float: right; line-height: 0.1px !important;">** AKHIR LAPORAN **</p>--}}

{{--</body>--}}

{{--</html>--}}
@endsection
