@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    @lang('Laporan Tolakan PB')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <td colspan="4"></td>
            <td colspan="2">@lang('STOK')</td>
            <td colspan="2">@lang('MIN ORDER')</td>
            <td colspan="2">@lang('MAX')</td>
            <td colspan="2">@lang('MIN')</td>
            <td colspan="2">@lang('PO OUT')</td>
            <td colspan="2">@lang('PB OUT')</td>
        </tr>
        <tr>
            <td width="3%">@lang('PLU')</td>
            <td width="8%">@lang('DESKRIPSI')</td>
            <td width="2%" class="kanan">@lang('SATUAN')</td>
            <td width="2%">@lang('TAG')</td>
            <td width="2%" class="kanan">@lang('QTY B')</td>
            <td width="2%" class="kanan">@lang('------K')</td>
            <td width="2%" class="kanan">@lang('QTY B')</td>
            <td width="2%" class="kanan">@lang('------K')</td>
            <td width="2%" class="kanan">@lang('QTY B')</td>
            <td width="2%" class="kanan">@lang('------K')</td>
            <td width="2%" class="kanan">@lang('QTY B')</td>
            <td width="2%" class="kanan">@lang('------K')</td>
            <td width="2%" class="kanan">@lang('QTY B')</td>
            <td width="2%" class="kanan">@lang('------K')</td>
            <td width="2%" class="kanan">@lang('QTY B')</td>
            <td width="2%" class="kanan">@lang('------K')</td>
        </tr>
        </thead>
        <tbody>
        @foreach($tolakan as $t)
            <tr>
                <td width="3%">{{ $t->prdcd }}</td>
                <td width="8%">{{ substr($t->prd_desk,0,25) }}</td>
                <td width="2%" class="kanan">{{ $t->prd_satuan }}</td>
                <td width="2%" class="tengah">{{ $t->prd_kodetag }}</td>
                <td width="2%" class="kanan">{{ $t->stok_qtyb }}</td>
                <td width="2%" class="kanan">{{ $t->stok_qtyk}}</td>
                <td width="2%" class="kanan">{{ $t->minorder_qtyb }}</td>
                <td width="2%" class="kanan">{{ $t->minorder_qtyk }}</td>
                <td width="2%" class="kanan">{{ $t->max_qtyb }}</td>
                <td width="2%" class="kanan">{{ $t->max_qtyk }}</td>
                <td width="2%" class="kanan">{{ $t->min_qtyb }}</td>
                <td width="2%" class="kanan">{{ $t->min_qtyb }}</td>
                <td width="2%" class="kanan">{{ $t->po_qtyb }}</td>
                <td width="2%" class="kanan">{{ $t->po_qtyk }}</td>
                <td width="2%" class="kanan">{{ $t->pb_qtyb }}</td>
                <td width="2%" class="kanan">{{ $t->pb_qtyk }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
