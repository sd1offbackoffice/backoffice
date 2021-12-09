@extends('html-template')

@section('table_font_size','7 px')

@section('paper_size','842pt 595pt')
@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    DAFTAR PERUBAHAN HARGA JUAL
@endsection

@section('title')
    ** DAFTAR PERUBAHAN HARGA JUAL **
@endsection

@section('subtitle')
    TGL : {{$date1}} s/d {{$date2}}
    {{$urut}}
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


    $produkHolder   = '';
    $produk         = 0;
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th rowspan="2" style="vertical-align: middle; text-align: left">KODE</th>
                <th rowspan="2" style="vertical-align: middle; text-align: left">NAMA BARANG</th>
                <th rowspan="2" style="vertical-align: middle">SATUAN</th>
                <th rowspan="2" style="vertical-align: middle">MIN<br>JUAL</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">HPP TERAKHIR</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">HPP RATA2</th>
                <th colspan="2" style="vertical-align: middle; text-align: center">------ HARGA JUAL ------</th>
                <th rowspan="2" style="vertical-align: middle; text-align: right">MARGIN<br>BARU</th>
                <th rowspan="2" style="vertical-align: middle">TGL AKTIF</th>
                <th rowspan="2" style="vertical-align: middle">TAG</th>
                <th rowspan="2" style="vertical-align: middle">TGL PROMOSI</th>
            </tr>
        <tr>
            <th style="text-align: right">LAMA</th>
            <th style="text-align: right">BARU</th>
        </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            {{--MAIN TABLE--}}
            <tr>
                <td style="text-align: left">{{$data[$i]->prd_prdcd}}</td>
                <td style="text-align: left">{{$data[$i]->desc2}}</td>
                <td>{{$data[$i]->satuan}}</td>
                <td style="text-align: right">{{zeroDigit($data[$i]->prd_minjual)}}</td>
                <td style="text-align: right">{{oneDigit($data[$i]->prd_lastcost)}}</td>
                <td style="text-align: right">{{oneDigit($data[$i]->prd_avgcost)}}</td>
                <td style="text-align: right">{{oneDigit($data[$i]->price_b)}}</td>
                <td style="text-align: right">{{oneDigit($data[$i]->price_a)}}</td>
                <td style="text-align: right">{{twoDigit($cf_nmargin[$i])}}</td>
                <?php
                $date = new DateTime($data[$i]->prd_tglhrgjual);
                $strip = $date->format('d-m-Y');
                ?>
                <td>{{$strip}}</td>
                <td>{{$data[$i]->tag}}</td>
                <?php
                if($data[$i]->prm_tglmulai != ''){
                    $date = new DateTime($data[$i]->prm_tglmulai);
                    $strip = $date->format('d-m-Y');
                    $date = new DateTime($data[$i]->prm_tglakhir);
                    $strip2 = $date->format('d-m-Y');
                    $context = $strip." s/d ".$strip2;
                }else{
                    $context = "";
                }
                ?>
                <td>{{$context}}</td>
            </tr>
            {{--MAIN TABLE--}}
            @php
                if($produkHolder == ''){
                    $produk++;
                    $produkHolder = $data[$i]->prd_prdcd;
                }elseif(substr($data[$i]->prd_prdcd,0,6) != substr($produkHolder,0,6)){
                    $produk++;
                    $produkHolder = $data[$i]->prd_prdcd;
                }
            @endphp
        @endfor
        <tr style="font-weight: bold; text-align: left">
            <td colspan="12">SUBTOTAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$produk}} PRODUK</td>
        </tr>
        </tbody>
    </table>
{{--    <p style="float: right; line-height: 0.1px !important;">** AKHIR LAPORAN **</p>--}}

{{--</body>--}}

{{--</html>--}}
@endsection
