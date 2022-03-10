@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    DAFTAR PEMUSNAHAN BARANG
@endsection

@section('title')
    DAFTAR PEMUSNAHAN BARANG
@endsection

@section('header_right')
    Rekap Produk Per Divisi / Departemen / Kategori
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
        $st_kat_tn = 0;

        $sum_total=0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="left">PLU</th>
            <th rowspan="2" class="left">NAMA BARANG</th>
            <th rowspan="2" class="left">KEMASAN</th>
            <th rowspan="2" class="right padding-right">HARGA SATUAN</th>
            <th colspan="2" >-- KUANTUM --</th>
            <th rowspan="2" class="right padding-right">TOTAL NILAI</th>
            <th rowspan="2" class="left">KETERANGAN</th>
        </tr>
        <tr>
            <th class="right" >CTN</th>
            <th class="right" >PCS</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->mstd_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="7"><b>{{$data[$i]->mstd_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->mstd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="7"><b>{{$data[$i]->mstd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif
            @if($tempkat != $data[$i]->mstd_kodekategoribrg)
                <tr>
                    <td class="left"><b>KATEGORI</b></td>
                    <td class="left" colspan="7"><b>{{$data[$i]->mstd_kodekategoribrg}} - {{$data[$i]->kat_namakategori}}</b>
                    </td>
                </tr>
            @endif
            <tr>
                <td class="left">{{ $data[$i]->plu }}</td>
                <td class="left">{{ $data[$i]->barang }}</td>
                <td class="left">{{ $data[$i]->kemasan }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->hrg_satuan,2) }}</td>
                <td class="right">{{ number_format($data[$i]->qty,2) }}</td>
                <td class="right">{{ number_format($data[$i]->qtyk,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->total,2) }}</td>
                <td class="left">{{ $data[$i]->keterangan }}</td>
            </tr>
            @php
                $st_kat_tn += $data[$i]->total;
                $st_dep_tn += $data[$i]->total;
                $st_div_tn += $data[$i]->total;

                $sum_total += $data[$i]->total;

                $tempkat = $data[$i]->mstd_kodekategoribrg;
                $tempdiv = $data[$i]->mstd_kodedivisi;
                $tempdep = $data[$i]->mstd_kodedepartement;
            @endphp
            @if( isset($data[$i+1]->mstd_kodekategoribrg) && $tempkat != $data[$i+1]->mstd_kodekategoribrg || !(isset($data[$i+1]->mstd_kodekategoribrg)) )
                <tr >
                    <th class="left">SUB TOTAL KAT</th>
                    <th colspan="5" class="left">{{ $data[$i]->mstd_kodekategoribrg }}</th>
                    <th class="right padding-right"  style="border-top: 1px black dashed">{{ number_format($st_kat_tn,2) }}</th>
                    <th class="right"></th>
                </tr>
                @php
                    $st_kat_tn = 0;
                @endphp
            @endif
            @if( isset($data[$i+1]->mstd_kodedepartement) && $tempdep != $data[$i+1]->mstd_kodedepartement || !(isset($data[$i+1]->mstd_kodedepartement)) )
                <tr >
                    <th class="left">SUB TOTAL DEPT</th>
                    <th colspan="5" class="left">{{ $data[$i]->mstd_kodedepartement }}</th>
                    <th class="right padding-right" style="border-top: 1px black dashed">{{ number_format($st_dep_tn,2) }}</th>
                    <th class="right"></th>
                </tr>
                @php
                    $st_dep_tn = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->mstd_kodedivisi) && $tempdiv != $data[$i+1]->mstd_kodedivisi) || !(isset($data[$i+1]->mstd_kodedivisi)) )
                <tr >
                    <th class="left">SUB TOTAL DIVISI</th>
                    <th colspan="5" class="left">{{ $data[$i]->mstd_kodedivisi }}</th>
                    <th class="right padding-right"  style="border-top: 1px black dashed">{{ number_format($st_div_tn,2) }}</th>
                    <th class="right"></th>
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
            <th class="left" colspan="6"><strong>TOTAL SELURUHNYA</strong></th>
            <th class="right padding-right">{{ number_format($sum_total ,2) }}</th>
            <th class="right"></th>
        </tr>
        </tfoot>
    </table>
@endsection
