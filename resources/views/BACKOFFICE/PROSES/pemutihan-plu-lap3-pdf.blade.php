@extends('html-template')

@section('table_font_size','7px')

@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    PEMUTIHAN PLU - LAPORAN
@endsection

@section('title')
    DAFTAR PERUBAHAN DATA PRODMAST INDOGROSIR
@endsection

@section('subtitle')
@endsection

@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="vertical-align: middle; text-align: left">NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">PLU&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">DESKRIPSI&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: center">KODE&nbsp;&nbsp;&nbsp;&nbsp;<br>CABANG&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: center">KATEGORI&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: center">KODE&nbsp;&nbsp;&nbsp;&nbsp;<br>TAG&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td style="text-align: left">{{$i+1}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->hrp_prdcd}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->prd_deskripsipanjang}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: center">&nbsp;&nbsp;{{$data[$i]->hrp_kodecabang_o}} - {{$data[$i]->hrp_kodecabang_n}}&nbsp;&nbsp;</td>
                <td style="text-align: center">&nbsp;&nbsp;{{$data[$i]->hrp_kategoritoko_o}} - {{$data[$i]->hrp_kategoritoko_n}}&nbsp;&nbsp;</td>
                <td style="text-align: center">&nbsp;&nbsp;{{$data[$i]->hrp_kodetag_o}} - {{$data[$i]->hrp_kodetag_n}}&nbsp;&nbsp;</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
