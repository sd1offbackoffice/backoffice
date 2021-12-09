@extends('html-template')

@section('table_font_size','7 px')

@section('paper_size','842pt 595pt')
@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    DAFTAR PRODUK
@endsection

@section('title')
    {{$judul}}
@endsection

@section('subtitle')
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
    $produkHolder   = '';
    $produk         = 0;
    $satuan         = 0;
@endphp
@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="vertical-align: middle; text-align: left">KODE</th>
                <th style="vertical-align: middle; text-align: left">NAMA BARANG</th>
                <th style="vertical-align: middle">SATUAN</th>
                <th style="vertical-align: middle">MIN<br>JUAL</th>
                <th style="vertical-align: middle; text-align: right">HPP AKHIR</th>
                <th style="vertical-align: middle; text-align: right">HPP RATA2</th>
                <th style="vertical-align: middle; text-align: right">HRG JUAL</th>
                <th style="vertical-align: middle; text-align: right">MARGIN</th>
                <th style="vertical-align: middle">TGL AKTIF</th>
                <th style="vertical-align: middle">TAG</th>
                <th style="vertical-align: middle">RCV</th>
                <th style="vertical-align: middle">SUPPLIER</th>
                <th style="vertical-align: middle; text-align: right">TOP</th>
                <th style="vertical-align: middle; text-align: right">MINOR</th>
                <th style="vertical-align: middle;">PKM</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td style="text-align: left">{{$data[$i]->prd}}</td>
                <td style="text-align: left">{{$data[$i]->desc2}}</td>
                <td>{{$data[$i]->satuan}}</td>
                <td>{{$data[$i]->minjl}}</td>
                @if($p_hpp == '1')
                    <td style="text-align: right">{{oneDigit($data[$i]->prd_lastcost)}}</td>
                    <td style="text-align: right">{{oneDigit($data[$i]->prd_avgcost)}}</td>
                @else
                    <td style="text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td style="text-align: right">{{oneDigit($data[$i]->prd_hrgjual)}}</td>
                @if($cf_nmargin[$i] != -100)
                    <td style="text-align: right">{{$cf_nmargin[$i]}}%</td>
                @else
                    <td style="text-align: right">%</td>
                @endif
                <?php
                $date = new DateTime($data[$i]->prd_tglaktif);
                $strip = $date->format('d-m-Y');
                ?>
                <td>{{$strip}}</td>
                <td>{{$data[$i]->prd_kodetag}}</td>
                @if($data[$i]->st_prdcd != null)
                    <td>Y</td>
                @else
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif

                <td>{{$data[$i]->supplier}}</td>
                @if($data[$i]->hgb_top == '0')
                    <td style="text-align: right">{{zeroDigit($data[$i]->sup_top)}}</td>
                @else
                    <td style="text-align: right">{{zeroDigit($data[$i]->hgb_top)}}</td>
                @endif

                <td style="text-align: right">{{zeroDigit($data[$i]->prd_minorder)}}</td>
                @if($data[$i]->pkm_prdcd != null)
                    <td>Y</td>
                @else
                    <td>&nbsp;</td>
                @endif
            </tr>
            @php
                if($produkHolder == ''){
                    $produk++;
                    $produkHolder = $data[$i]->prd;
                }elseif(substr($data[$i]->prd,0,6) != substr($produkHolder,0,6)){
                    $produk++;
                    $produkHolder = $data[$i]->prd;
                }
                 $satuan++;
            @endphp
        @endfor
{{--        <tr style="font-weight: bold">--}}
{{--            <td colspan="2" style="text-align: right">TOTAL SELURUHNYA :</td>--}}
{{--            <td colspan="2" style="text-align: right">{{$produk}} PRODUK</td>--}}
{{--            <td colspan="1" style="text-align: right">{{$satuan}} SATUAN</td>--}}
{{--        </tr>--}}
        </tbody>
    </table>
    <p style="font-weight: bold">TOTAL SELURUHNYA :&nbsp;&nbsp;&nbsp;&nbsp; {{$produk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$satuan}} SATUAN</p>
@endsection
