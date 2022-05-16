@extends('html-template')

@section('table_font_size','7px')

@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    LAPORAN BEDA TAG IGR OMI
@endsection

@section('title')
    {{$judul}}
@endsection

@section('subtitle')
    PER TANGGAL {{ $tanggal }}
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
    $pluomihold     = '';
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
                <th style="vertical-align: middle">PLU_OMI</th>
                <th style="vertical-align: middle">PLU_IGR</th>
                <th style="vertical-align: middle; text-align: left">DESKRIPSI</th>
                <th style="vertical-align: middle">FLAG OMI</th>
                <th style="vertical-align: middle">SATUAN</th>
                <th style="vertical-align: middle">TAG_OMI</th>
                <th style="vertical-align: middle">TAG_IGR</th>
                <th style="vertical-align: middle">LOKASI</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            {{-- @if($data[$i]->div_kodedivisi != $divisi || $data[$i]->dep_kodedepartement != $departement || $data[$i]->kat_kodekategori != $kategori)
                @if($katSatuan!=0)
                    <tr style="font-weight: bold; text-align: left">
                        <td colspan="15">TOTAL KATEGORI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$katProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$katSatuan}} SATUAN</td>
                    </tr>
                    @php
                        $katProduk = 0;
                        $katSatuan = 0;
                    @endphp
                @endif
                @if($depSatuan!=0 && $data[$i]->dep_kodedepartement != $departement)
                    <tr style="font-weight: bold; text-align: left">
                        <td colspan="15">TOTAL DEPARTEMENT &nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$depProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$depSatuan}} SATUAN</td>
                    </tr>
                    @php
                        $depProduk = 0;
                        $depSatuan = 0;
                    @endphp
                @endif
                @if($divSatuan!=0 && $data[$i]->div_kodedivisi != $divisi)
                    <tr style="font-weight: bold; text-align: left">
                        <td colspan="15">TOTAL DIVISI &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp; {{$divProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$divSatuan}} SATUAN</td>
                    </tr>
                    @php
                        $divProduk = 0;
                        $divSatuan = 0;
                    @endphp
                @endif
                @php
                    $divisi = $data[$i]->div_kodedivisi;
                    $departement = $data[$i]->dep_kodedepartement;
                    $kategori = $data[$i]->kat_kodekategori;  
                @endphp
                <tr style="text-align: left; font-weight: bold">
                    <td colspan="5">DIVISI : {{$data[$i]->divisi}}</td>
                    <td colspan="5">DEPARTEMENT : {{$data[$i]->departement}}</td>
                    <td colspan="5">KATEGORI : {{$data[$i]->kategori}}</td>
                </tr>
            @endif --}}
            @php
                if($data[$i]->prc_pluomi != $pluomihold){
                    $pluomihold = $data[$i]->prc_pluomi;
                }
                else{
                    $pluomihold = '';
                }
            @endphp
            
            <tr>
                <td>{{$pluomihold}}</td>
                <td>{{$data[$i]->prc_pluigr}}</td>
                <td style="text-align: left">{{$data[$i]->prd_deskripsipendek}}</td>
                <td>{{$data[$i]->prd_flagomi}}</td>
                <td>{{$data[$i]->prd_satuan}}</td>
                <td>{{$data[$i]->prc_kodetag}}</td>
                <td>{{$data[$i]->prd_kodetag}}</td>
                <td>{{$data[$i]->lokasi}}</td>
            </tr>
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
                $divSatuan++;
                $depSatuan++;
                $katSatuan++;
                $satuan++;
            @endphp
        @endfor
        {{-- <tr style="font-weight: bold; text-align: left">
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
        </tr> --}}
        </tbody>
    </table>
{{--    <p style="float: right; line-height: 0.1px !important;">** AKHIR LAPORAN **</p>--}}

{{--</body>--}}

{{--</html>--}}
@endsection
