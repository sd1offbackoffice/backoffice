
@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    DAFTAR PEMUSNAHAN BARANG
@endsection

@section('title')
    DAFTAR PEMUSNAHAN BARANG
@endsection

@section('header_right')
    Ringkasan Divisi / Departemen / Kategori
@endsection

@section('subtitle')
    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    @php
        $tempdiv = '';
        $tempdep = '';
        $tempkat = '';
        $totaldiv = 0;
        $totaldep = 0;
        $totalkat = 0;
        $total = 0;
        $skipdep = false;

        $st_div_tn = 0;

        $st_dep_tn = 0;

        $sum_total=0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" width="10%">KODE</th>
            <th class="left" >NAMA KATEGORI</th>
            <th class="right">TOTAL NILAI</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->mstd_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="2"><b>{{$data[$i]->mstd_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->mstd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="2"><b>{{$data[$i]->mstd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif
            <tr>
                <td class="left">{{ $data[$i]->mstd_kodekategoribrg }}</td>
                <td class="left">{{ $data[$i]->kat_namakategori }}</td>
                <td class="right">{{ number_format($data[$i]->total,2) }}</td>
            </tr>
            @php
                $st_dep_tn += $data[$i]->total;

                $st_div_tn += $data[$i]->total;

                $sum_total += $data[$i]->total;

                $tempdiv = $data[$i]->mstd_kodedivisi;
                $tempdep = $data[$i]->mstd_kodedepartement;
            @endphp
            @if( isset($data[$i+1]->mstd_kodedepartement) && $tempdep != $data[$i+1]->mstd_kodedepartement || !(isset($data[$i+1]->mstd_kodedepartement)) )
                <tr >
                    <th class="left">SUB TOTAL DEPT</th>
                    <th class="left">{{ $data[$i]->mstd_kodedepartement }}</th>
                    <th class="right">{{ number_format($st_dep_tn,2) }}</th>
                </tr>
                @php
                    $st_dep_tn = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->mstd_kodedivisi) && $tempdiv != $data[$i+1]->mstd_kodedivisi) || !(isset($data[$i+1]->mstd_kodedivisi)) )
                <tr >
                    <th class="left">SUB TOTAL DIVISI</th>
                    <th class="left">{{ $data[$i]->mstd_kodedivisi }}</th>
                    <th class="right">{{ number_format($st_div_tn,2) }}</th>
                </tr>
                @php
                    $skipdiv = false;
                    $st_div_tn = 0;
                @endphp
            @endif
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></th>
            <th class="right">{{ number_format($sum_total ,2) }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
