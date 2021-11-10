@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Listing Bukti Transfer barang Kirim Langsung Dari OMI
@endsection

@section('title')
    LISTING BUKTI TRANSFER BARANG KIRIM LANGSUNG DARI OMI
@endsection

{{--@section('subtitle')--}}
{{--    {{ $tgl_start }} - {{ $tgl_end }}--}}
{{--@endsection--}}

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right">NO DOK</th>
            <th class="left">TGL DOK</th>
            <th class="left">TOKO</th>
            <th class="left">MEMBER</th>
            <th class="left" colspan="2">SUPPLIER</th>
            <th class="right padding-right">STRUK</th>
            <th class="left">TGL STRUK</th>
            <th class="right padding-right">PLU</th>
            <th class="left">NAMA BARANG</th>
            <th class="left">SATUAN</th>
            <th class="right">QTY</th>
            <th class="right">BNS</th>
            <th class="right">PRICE</th>
            <th class="right">TOTAL</th>
            <th class="right">TOTAL STRUK</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_all = 0;
            $struk_all = 0;
            $total = 0;
            $struk = 0;
        @endphp
        @for($i = 0; $i < sizeof($data); $i++)
            <tr>
                <td class="right padding-right">{{$data[$i]->no_bukti}}</td>
                <td class="left">{{date('d/m/Y', strtotime($data[$i]->tgl_bukti))}}</td>
                <td class="left">{{$data[$i]->kodetoko}}</td>
                <td class="left">{{$data[$i]->cus_kodemember}}</td>
                <td class="left">{{$data[$i]->kodesupplier}}</td>
                <td class="left">{{$data[$i]->sup_namasupplier}}</td>
                <td class="right padding-right">{{$data[$i]->no_tran}}</td>
                <td class="left">{{date('d/m/Y', strtotime($data[$i]->tgl_tran))}}</td>
                <td class="right padding-right">{{$data[$i]->prdcd}}</td>
                <td class="left">{{$data[$i]->prd_deskripsipendek}}</td>
                <td class="left">{{$data[$i]->satuan}}</td>
                <td class="right">{{$data[$i]->qty}}</td>
                <td class="right">{{$data[$i]->bonus}}</td>
                <td class="right">{{number_format(round($data[$i]->harga), 2, '.', ',')}}</td>
                <td class="right">{{number_format(round($data[$i]->total), 2, '.', ',')}}</td>
                <td class="right">{{number_format(round($data[$i]->gross), 2, '.', ',')}}</td>
            </tr>
            @php
                $total = $total + $data[$i]->total;
                $struk = $struk + $data[$i]->gross;
                $total_all = $total_all + $data[$i]->total;
                $struk_all = $struk_all + $data[$i]->gross;
            @endphp
            @if($i == (sizeof($data)-1) || $data[$i]->no_bukti != $data[$i+1]->no_bukti)
                <tr style="border-bottom: 1px solid black">
                    <td colspan="14" style="text-align: right; border-bottom: 1px solid black">** Sub Total :</td>
                    <td style="text-align: right; border-bottom: 1px solid black">{{number_format($total ,2,'.',',')}}</td>
                    <td style="text-align: right; border-bottom: 1px solid black">{{number_format($struk ,2,'.',',')}}</td>
                    {{$total = 0}} {{$struk = 0}}
                </tr>
            @endif
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="14">Total Akhir :</td>
            <td class="right">{{number_format($total_all ,2,'.',',')}}</td>
            <td class="right">{{number_format($struk_all ,2,'.',',')}}</td>
        </tr>
        </tfoot>
    </table>
@endsection
