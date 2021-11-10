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
            <th class="left">SUPPLIER</th>
            <th class="right padding-right">STRUK</th>
            <th class="left">TGL STRUK</th>
            <th class="right">TOTAL</th>
            <th class="right">TOTAL STRUK</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total       = 0;
            $total_struk = 0;
        @endphp
        @foreach($data as $value)
            <tr>
                <td class="right padding-right">{{$value->no_bukti}}</td>
                <td class="left">{{date('d/m/Y', strtotime($value->tgl_bukti))}}</td>
                <td class="left">{{$value->kodetoko}}</td>
                <td class="left">{{$value->cus_kodemember}} {{$value->cus_namamember}}</td>
                <td class="left">{{$value->kodesupplier}} {{$value->sup_namasupplier}}</td>
                <td class="right padding-right">{{$value->no_tran}}</td>
                <td class="left">{{date('d/m/Y', strtotime($value->tgl_tran))}}</td>
                <td class="right">{{number_format(round($value->harga), 2, '.', ',')}}</td>
                <td class="right">{{number_format(round($value->gross), 2, '.', ',')}}</td>
            </tr>
            @php
                $total = $total + $value->harga;
                $total_struk = $total_struk + $value->gross;
            @endphp
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="7">Total Akhir :</td>
            <td class="right">{{number_format($total ,2,'.',',')}}</td>
            <td class="right">{{number_format($total_struk ,2,'.',',')}}</td>
        </tr>
        </tfoot>
    </table>
@endsection
