@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    @lang('Laporan Tolakan PB by Divisi') {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('title')
    {{ $title }}
@endsection

@section('subtitle')
    @lang('TANGGAL : ') {{ $tgl1 }} @lang('s/d') {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="font-size: 9px">
            <td colspan="2" style="text-align: left"><strong>@lang('TANGGAL')&nbsp;&nbsp;&nbsp;@lang('DOKUMEN')</strong></td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td width="5%">@lang('PLU')</td>
            <td width="27%" class="center">@lang('DESKRIPSI')</td>
            <td width="5%" class="kanan">@lang('SATUAN')</td>
            <td width="5%" class="tengah">@lang('TAG')</td>
            <td width="5%">@lang('DIV')</td>
            <td width="5%">@lang('DEPT')</td>
            <td width="5%">@lang('KAT')</td>
            <td width="5%">@lang('PKMT')</td>
            <td width="38%" class="padding-left">@lang('KETERANGAN')</td>
        </tr>
        </thead>
        <tbody>
        @php
            $tgl = '';
            $nopb = '';
            $sup = '';
        @endphp
        @foreach($data as $t)
            @if($tgl != $t->tglpb && $nopb != $t->nopb)
                @php
                    $tgl = $t->tglpb;
                    $nopb = $t->nopb;
                @endphp
                <tr style="font-size: 9px">
                    <td colspan="2" style="text-align: left"><strong>{{ $t->tglpb }}&nbsp;&nbsp;&nbsp;{{ $t->nopb }}</strong></td>
                    <td colspan="7"></td>
                </tr>
            @endif
            @if($sup != $t->supco)
                @php
                    $sup = $t->supco;
                @endphp
                <tr>
                    <td colspan="7" style="font-size: 9px" class="left">
                        <strong>
                            {{ $t->supco }} - {{ $t->supname }}
                        </strong>
                    </td>
                </tr>
            @endif
            <tr>
                <td width="5%">{{ $t->prdcd }}</td>
                <td width="27%" class="left padding-left">{{ $t->deskripsi }}</td>
                <td width="5%" class="tengah">{{ $t->satuan }}</td>
                <td width="5%" class="right">{{ $t->tag }}</td>
                <td width="5%" class="right">{{ $t->div }}</td>
                <td width="5%" class="right">{{ $t->dep }}</td>
                <td width="5%" class="right">{{ $t->kat }}</td>
                <td width="5%" class="right">{{ $t->pkmt }}</td>
                <td width="38%" class="left padding-left">{{ $t->keterangan }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
