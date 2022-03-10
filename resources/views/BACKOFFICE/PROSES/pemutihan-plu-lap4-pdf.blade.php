@extends('html-template')

@section('table_font_size','7px')

@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    PEMUTIHAN PLU - LAPORAN
@endsection

@section('title')
    DAFTAR BARCODE YANG ADA DI INDOGROSIR DAN TIDAK ADA DI MD
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
                <th style="vertical-align: middle; text-align: left">KODE TAG&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">BARCODE&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">STATUS&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td style="text-align: left">{{$i+1}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->brc_prdcd}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->prd_deskripsipanjang}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->prd_kodetag}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->brc_barcode}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->brc_status}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
