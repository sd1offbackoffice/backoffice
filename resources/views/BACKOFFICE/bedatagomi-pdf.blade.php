@extends('html-template')

@section('table_font_size','7px')

@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    BEDA TAG OMI IGR
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
    $divisi         = '';
    $departement    = '';
    $kategori       = '';

    $produkHolder   = '';
    $divProduk      = 0;
    $divSatuan      = 0;

    $depProduk      = 0;
    $depSatuan      = 0;

    $katProduk      = 0;
    $katSatuan      = 0;

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
            @if($data[$i]->prd_kodedivisi != $divisi || $data[$i]->prd_kodedepartement != $departement || $data[$i]->prd_kodekategoribarang != $kategori)
                @if($katSatuan!=0)
                    <tr style="font-weight: bold; text-align: left">
                        <td colspan="15">TOTAL KATEGORI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$katProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$katSatuan}} SATUAN</td>
                    </tr>
                    @php
                        $katProduk = 0;
                        $katSatuan = 0;
                    @endphp
                @endif
                @if($depSatuan!=0 && $data[$i]->prd_kodedepartement != $departement)
                    <tr style="font-weight: bold; text-align: left">
                        <td colspan="15">TOTAL DEPARTEMENT &nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$depProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$depSatuan}} SATUAN</td>
                    </tr>
                    @php
                        $depProduk = 0;
                        $depSatuan = 0;
                    @endphp
                @endif
                @if($divSatuan!=0 && $data[$i]->prd_kodedivisi != $divisi)
                    <tr style="font-weight: bold; text-align: left">
                        <td colspan="15">TOTAL DIVISI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$divProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$divSatuan}} SATUAN</td>
                    </tr>
                    @php
                        $divProduk = 0;
                        $divSatuan = 0;
                    @endphp
                @endif
                @php
                    $divisi = $data[$i]->prd_kodedivisi;
                    $departement = $data[$i]->prd_kodedepartement;
                    $kategori = $data[$i]->prd_kodekategoribarang;
                @endphp
                <tr style="text-align: left; font-weight: bold">
                    <td colspan="5">DIVISI : {{$data[$i]->divisi}}</td>
                    <td colspan="5">DEPARTEMENT : {{$data[$i]->dept}}</td>
                    <td colspan="5">KATEGORI : {{$data[$i]->kategori}}</td>
                </tr>
            @endif
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
                    $divProduk++;
                    $depProduk++;
                    $katProduk++;
                    $produk++;
                    $produkHolder = $data[$i]->prd;
                }elseif(substr($data[$i]->prd,0,6) != substr($produkHolder,0,6)){
                    $divProduk++;
                    $depProduk++;
                    $katProduk++;
                    $produk++;
                    $produkHolder = $data[$i]->prd;
                }
                $divSatuan++;
                $depSatuan++;
                $katSatuan++;
                $satuan++;
            @endphp
        @endfor
        <tr style="font-weight: bold; text-align: left">
            <td colspan="15">TOTAL KATEGORI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$katProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$katSatuan}} SATUAN</td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td colspan="15">TOTAL DEPARTEMENT &nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$depProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$depSatuan}} SATUAN</td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td colspan="15">TOTAL DIVISI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$divProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$divSatuan}} SATUAN</td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td colspan="15">TOTAL SELURUHNYA &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$produk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$satuan}} SATUAN</td>
        </tr>
        </tbody>
    </table>
{{--    <p style="float: right; line-height: 0.1px !important;">** AKHIR LAPORAN **</p>--}}

{{--</body>--}}

{{--</html>--}}
@endsection
