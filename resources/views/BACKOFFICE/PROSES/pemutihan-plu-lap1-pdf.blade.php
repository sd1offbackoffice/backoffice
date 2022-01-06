@extends('html-template')

@section('table_font_size','7px')

@section('paper_size','842pt 595pt')
@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    PEMUTIHAN PLU - LAPORAN
@endsection

@section('title')
    DAFTAR PLU YANG ADA DI INDOGROSIR DAN TIDAK ADA DI MD
@endsection

@section('subtitle')
    {{$ket}}<br>
    Tgl Proses : {{$periode}}
@endsection

@section('nodata',$kosong)

@section('content')

    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
            <tr>
                <th style="vertical-align: middle; text-align: left">NO.&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">PLU&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">DESKRIPSI&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: left">SATUAN&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: center">KODE&nbsp;&nbsp;&nbsp;&nbsp;<br>CAB&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: center">KAT&nbsp;&nbsp;&nbsp;&nbsp;<br>TOKO&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: center">KODE&nbsp;&nbsp;&nbsp;&nbsp;<br>TAG&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th style="vertical-align: middle; text-align: right">SALDO&nbsp;&nbsp;&nbsp;&nbsp;<br>(PCS)&nbsp;&nbsp;&nbsp;&nbsp;</th>
            </tr>
        </thead>
        <tbody style="text-align: center; vertical-align: middle">
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td style="text-align: left">{{$i+1}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->hpt_prdcd}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->prd_deskripsipanjang}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: left">{{$data[$i]->satuan}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: center">{{$data[$i]->hpt_kodecabang}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: center">{{$data[$i]->hpt_kategoritoko}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: center">{{$data[$i]->hpt_kodetag}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td style="text-align: right">{{$data[$i]->hpt_saldoakhir}}</td>
            </tr>
        @endfor
        </tbody>
    </table>
@endsection
