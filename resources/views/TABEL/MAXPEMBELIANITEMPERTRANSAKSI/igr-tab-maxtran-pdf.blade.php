@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    TABEL MAX PEMBELIAN ITEM PER TRANSAKSI
@endsection

@section('title')
    ** TABEL MAX PEMBELIAN ITEM PER TRANSAKSI **
@endsection

@section('paper_width')
    842
@endsection

@section('paper_size')
    842pt  595pt
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah right padding-right">No</th>
            <th class="tengah left">PLU<br>DESKRIPSI</th>
            <th class="tengah right">MAX QTY REG BIRU</th>
            <th class="tengah right">MAX QTY REG BIRU PLUS</th>
            <th class="tengah right">MAX QTY FREEPASS</th>
            <th class="tengah right">MAX QTY RET MERAH</th>
            <th class="tengah right">MAX QTY SILVER</th>
            <th class="tengah right">MAX QTY GOLD 1</th>
            <th class="tengah right">MAX QTY GOLD 2</th>
            <th class="tengah right">MAX QTY GOLD 3</th>
            <th class="tengah right">MAX QTY PLATINUM</th>
        </tr>
        </thead>
        <tbody>
        @for($i = 0; $i < sizeof($data); $i++)
            <tr>
                <td class="right padding-right">{{$i+1}}</td>
                <td class="left">{{$data[$i]->mtr_prdcd}}</td>
                <td class="right">{{number_format($data[$i]->mtr_qtyregulerbiru, 0,".",",")}}</td>
                <td class="right">{{number_format($data[$i]->mtr_qtyregulerbiruplus, 0,".",",")}}</td>
                <td class="right">{{number_format($data[$i]->mtr_qtyfreepass, 0,".",",")}}</td>
                <td class="right">{{number_format($data[$i]->mtr_qtyretailermerah, 0,".",",")}}</td>
                <td class="right">{{number_format($data[$i]->mtr_qtysilver, 0,".",",")}}</td>
                <td class="right">{{number_format($data[$i]->mtr_qtygold1, 0,".",",")}}</td>
                <td class="right">{{number_format($data[$i]->mtr_qtygold2, 0,".",",")}}</td>
                <td class="right">{{number_format($data[$i]->mtr_qtygold3, 0,".",",")}}</td>
                <td class="right">{{number_format($data[$i]->mtr_qtyplatinum, 0,".",",")}}</td>
            </tr>
            <tr class="m-0 p-0">
                <td class="left"></td>
                <td class="left">{{$data[$i]->prd_deskripsipanjang}}</td>
                <td class="left">{{$data[$i]->unit}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection

