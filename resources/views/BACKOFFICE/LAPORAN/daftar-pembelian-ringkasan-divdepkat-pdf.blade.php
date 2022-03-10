@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Daftar Pembelian Ringkasan Divisi / Departemen / Kategori
@endsection

@section('title')
    Daftar Pembelian Ringkasan Divisi / Departemen / Kategori
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

        $st_div_gross = 0;
        $st_div_pot = 0;
        $st_div_disc = 0;
        $st_div_ppn = 0;
        $st_div_gross = 0;
        $st_div_bm = 0;
        $st_div_btl = 0;
        $st_div_tn = 0;

        $st_dep_gross = 0;
        $st_dep_pot = 0;
        $st_dep_disc = 0;
        $st_dep_ppn = 0;
        $st_dep_bm = 0;
        $st_dep_btl = 0;
        $st_dep_tn = 0;

        $sum_gross_bkp=0;
        $sum_gross_btkp=0;
        $sum_potongan_bkp=0;
        $sum_potongan_btkp=0;
        $sum_disc4_bkp=0;
        $sum_disc4_btkp=0;
        $sum_ppn_bkp=0;
        $sum_ppn_btkp=0;
        $sum_bm_bkp=0;
        $sum_bm_btkp=0;
        $sum_btl_bkp=0;
        $sum_btl_btkp=0;
        $sum_total_bkp=0;
        $sum_total_btkp=0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" width="10%">KODE</th>
            <th class="left" width="20%">NAMA KATEGORI</th>
            <th class="right" width="10%">GROSS</th>
            <th class="right" width="10%">POTONGAN</th>
            <th class="right" width="10%">DISCOUNT 4</th>
            <th class="right" width="10%">PPN</th>
            <th class="right" width="10%">BM</th>
            <th class="right" width="10%">BTL</th>
            <th class="right" width="10%">TOTAL NILAI</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->mstd_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="8"><b>{{$data[$i]->mstd_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->mstd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="8"><b>{{$data[$i]->mstd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif
            <tr>
                <td class="left">{{ $data[$i]->mstd_kodekategoribrg }}</td>
                <td class="left">{{ $data[$i]->kat_namakategori }}</td>
                <td class="right">{{ number_format($data[$i]->gross,2) }}</td>
                <td class="right">{{ number_format($data[$i]->pot,2) }}</td>
                <td class="right">{{ number_format($data[$i]->disc4,2) }}</td>
                <td class="right">{{ number_format($data[$i]->ppn,2) }}</td>
                <td class="right">{{ number_format($data[$i]->bm,2) }}</td>
                <td class="right">{{ number_format($data[$i]->btl,2) }}</td>
                <td class="right">{{ number_format($data[$i]->total,2) }}</td>
            </tr>
            @php
                $st_dep_gross += $data[$i]->gross;
                $st_dep_pot += $data[$i]->pot;
                $st_dep_disc += $data[$i]->disc4;
                $st_dep_ppn += $data[$i]->ppn;
                $st_dep_bm += $data[$i]->bm;
                $st_dep_btl += $data[$i]->btl;
                $st_dep_tn += $data[$i]->total;

                $st_div_gross += $data[$i]->gross;
                $st_div_pot += $data[$i]->pot;
                $st_div_disc += $data[$i]->disc4;
                $st_div_ppn += $data[$i]->ppn;
                $st_div_bm += $data[$i]->bm;
                $st_div_btl += $data[$i]->btl;
                $st_div_tn += $data[$i]->total;

                $sum_gross_bkp += $data[$i]->sum_gross_bkp;
                $sum_potongan_bkp += $data[$i]->sum_potongan_bkp;
                $sum_disc4_bkp += $data[$i]->sum_disc4_bkp;
                $sum_ppn_bkp += $data[$i]->sum_ppn_bkp;
                $sum_bm_bkp += $data[$i]->sum_bm_bkp;
                $sum_btl_bkp += $data[$i]->sum_btl_bkp;
                $sum_total_bkp += $data[$i]->sum_total_bkp;

                $sum_gross_btkp += $data[$i]->sum_gross_btkp;
                $sum_potongan_btkp += $data[$i]->sum_potongan_btkp;
                $sum_disc4_btkp += $data[$i]->sum_disc4_btkp;
                $sum_ppn_btkp += $data[$i]->sum_ppn_btkp;
                $sum_bm_btkp += $data[$i]->sum_bm_btkp;
                $sum_btl_btkp += $data[$i]->sum_btl_btkp;
                $sum_total_btkp += $data[$i]->sum_total_btkp;

                $tempdiv = $data[$i]->mstd_kodedivisi;
                $tempdep = $data[$i]->mstd_kodedepartement;
            @endphp
            @if( isset($data[$i+1]->mstd_kodedepartement) && $tempdep != $data[$i+1]->mstd_kodedepartement || !(isset($data[$i+1]->mstd_kodedepartement)) )
                <tr style="border-bottom: 1px solid black;">
                    <th class="left">SUB TOTAL DEPT</th>
                    <th class="left">{{ $data[$i]->mstd_kodedepartement }} - {{$data[$i]->dep_namadepartement}}</th>
                    <th class="right">{{ number_format( $st_dep_gross,2) }}</th>
                    <th class="right">{{ number_format($st_dep_pot,2) }}</th>
                    <th class="right">{{ number_format($st_dep_disc,2) }}</th>
                    <th class="right">{{ number_format($st_dep_ppn,2) }}</th>
                    <th class="right">{{ number_format($st_dep_bm ,2) }}</th>
                    <th class="right">{{ number_format($st_dep_btl,2) }}</th>
                    <th class="right">{{ number_format($st_dep_tn,2) }}</th>
                </tr>
                @php
                    $st_dep_gross = 0;
                    $st_dep_pot = 0;
                    $st_dep_disc = 0;
                    $st_dep_ppn = 0;
                    $st_dep_bm = 0;
                    $st_dep_btl = 0;
                    $st_dep_tn = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->mstd_kodedivisi) && $tempdiv != $data[$i+1]->mstd_kodedivisi) || !(isset($data[$i+1]->mstd_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <th class="left">SUB TOTAL DIVISI</th>
                    <th class="left">{{ $data[$i]->mstd_kodedivisi }} - {{ $data[$i]->div_namadivisi }}</th>
                    <th class="right">{{ number_format( $st_div_gross,2) }}</th>
                    <th class="right">{{ number_format($st_div_pot,2) }}</th>
                    <th class="right">{{ number_format($st_div_disc,2) }}</th>
                    <th class="right">{{ number_format($st_div_ppn,2) }}</th>
                    <th class="right">{{ number_format($st_div_bm ,2) }}</th>
                    <th class="right">{{ number_format($st_div_btl,2) }}</th>
                    <th class="right">{{ number_format($st_div_tn,2) }}</th>
                </tr>
                @php
                    $skipdiv = false;
                    $st_div_gross = 0;
                    $st_div_pot = 0;
                    $st_div_disc = 0;
                    $st_div_ppn = 0;
                    $st_div_bm = 0;
                    $st_div_btl = 0;
                    $st_div_tn = 0;
                @endphp
            @endif
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL BKP</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_disc4_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_total_bkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL BTKP</strong></th>
            <th class="right">{{ number_format($sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_disc4_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_total_btkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_disc4_bkp+$sum_disc4_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_bkp+$sum_bm_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_bkp+$sum_btl_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
