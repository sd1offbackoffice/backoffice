@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Tolakan PB by Divisi {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('title')
    {{ $title }}
@endsection

@section('subtitle')
    TANGGAL : {{ $tgl1 }} s/d {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="font-size: 9px">
            <td colspan="2" style="text-align: left"><strong>TANGGAL<span style="display:inline-block; width:15;"></span>DOKUMEN</strong></td>
            <td colspan="7"></td>
        </tr>
        <tr>
            <td width="5%">PLU</td>
            <td width="27%" class="left">DESKRIPSI</td>
            <td width="5%" class="kanan">SATUAN</td>
            <td width="5%" class="tengah">TAG</td>
            <td width="5%">DIV</td>
            <td width="5%">DEPT</td>
            <td width="5%">KAT</td>
            <td width="5%">PKMT</td>
            <td width="38%">KETERANGAN</td>
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
                    <td colspan="2" style="text-align: left"><strong>{{ $t->tglpb }}<span style="display:inline-block; width:15;"></span>{{ $t->nopb }}</strong></td>
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
                <td width="27%" class="left">{{ $t->deskripsi }}</td>
                <td width="5%" class="tengah">{{ $t->satuan }}</td>
                <td width="5%" class="tengah">{{ $t->tag }}</td>
                <td width="5%" class="tengah">{{ $t->div }}</td>
                <td width="5%" class="tengah">{{ $t->dep }}</td>
                <td width="5%" class="tengah">{{ $t->kat }}</td>
                <td width="5%" class="tengah">{{ $t->pkmt }}</td>
                <td width="38%">{{ $t->keterangan }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
