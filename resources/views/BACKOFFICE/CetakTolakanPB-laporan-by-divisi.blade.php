@extends('pdf-template')

@section('paper_size','842pt 595pt')

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
            <td colspan="5"></td>
        </tr>
        <tr>
            <td class="left" width="5%">PLU</td>
            <td class="left" width="22%">DESKRIPSI</td>
            <td class="left" width="5%" class="kanan">SATUAN</td>
            <td class="left" width="2%" class="tengah">TAG</td>
            <td class="left" width="22%">SUPPLIER</td>
            <td class="right padding-right" width="6%">PKMT</td>
            <td class="left" width="38%">KETERANGAN</td>
        </tr>
        </thead>
        <tbody>
        @php
            $tgl = '';
            $nopb = '';
            $div = '';
            $dep = '';
            $kat = '';
        @endphp
        @foreach($data as $t)
            @if($tgl != $t->tglpb && $nopb != $t->nopb)
                @php
                    $tgl = $t->tglpb;
                    $nopb = $t->nopb;
                @endphp
                <tr style="font-size: 9px">
                    <td colspan="2" style="text-align: left"><strong>{{ $t->tglpb }}<span style="display:inline-block; width:15;"></span>{{ $t->nopb }}</strong></td>
                    <td colspan="5"></td>
                </tr>
            @endif
            @if($div != $t->div || $dep != $t->dep || $kat != $t->kat)
                @php
                    $div = $t->div;
                    $dep = $t->dep;
                    $kat = $t->kat;
                @endphp
                <tr>
                    <td colspan="7" class="left" style="font-size: 9px">
                        <strong>
                            DIV : {{ $t->div }} - {{ $t->divname }}<span style="display:inline-block; width:15;"></span>
                            DEPT : {{ $t->dep }} - {{ $t->depname }}<span style="display:inline-block; width:15;"></span>
                            KAT : {{ $t->kat }} - {{ $t->katname }}
                        </strong>
                    </td>
                </tr>
            @endif
            <tr>
                <td class="left" width="5%">{{ $t->prdcd }}</td>
                <td class="left" width="22%">{{ $t->deskripsi }}</td>
                <td class="left" width="5%">{{ $t->satuan }}</td>
                <td class="left" width="2%">{{ $t->tag }}</td>
                <td class="left" width="22%">{{ $t->supco }} - {{ $t->supname }}</td>
                <td class="right  padding-right" width="6%">{{ $t->pkmt }}</td>
                <td class="left" width="38%">{{ $t->keterangan }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
