@extends('pdf-template')

@section('table_font_size','8 px')

@section('page_title')
    TABEL PLU TIMBANGAN
@endsection

@section('title')
    TABEL P.L.U. TIMBANGAN
@endsection

@section('subtitle')
{{--    Periode :--}}
{{--    {{ date("d/m/Y") }}--}}
@endsection

@php
    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')
    <table class="table table-bordered table-responsive" style="border-collapse: collapse; text-align: center">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black; text-align: center">
            <tr style="vertical-align: middle">
                <th style="text-align: left; width: 80px;">PLU</th>
                <th style="text-align: left; width: 300px;">Deskripsi Timbangan</th>
                <th style="text-align: left; width: 80px;">UNIT/FRAC</th>
                <th style="text-align: left; width: 80px;">TAG</th>
                <th style="text-align: right; width: 80px;">HARGA JUAL</th>
                <th style="text-align: right; width: 100px;">KODE TIMBANGAN</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black; text-align: left">
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td>{{$data[$i]->plu}}</td>
                <td>{{$data[$i]->prd_desc}}</td>
                <td>{{$data[$i]->prd_satuan}}</td>
                <td>{{$data[$i]->prd_kodetag}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->hrg_jual)}}</td>
                <td style="text-align: right">{{$data[$i]->tmb_kode}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
