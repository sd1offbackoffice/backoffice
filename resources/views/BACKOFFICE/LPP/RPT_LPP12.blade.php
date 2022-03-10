@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    {{ $title }}
@endsection

@section('title')
    {{ $title }}
@endsection

@section('subtitle')
    TANGGAL : {{$tgl1}} s/d {{$tgl2}}
@endsection

@section('paper_height','595pt')
@section('paper_width','1200pt')
    @php
        $tempdiv = '';
        $tempdiv = '';

        $count_prdcd = 0;
        $total_prdcd = 0;

        $st_dep_nbegbal    =0;
        $st_dep_beli       =0;
        $st_dep_bonus      =0;
        $st_dep_trmcb      =0;
        $st_dep_retursales =0;
        $st_dep_rafak      =0;
        $st_dep_repack     =0;
        $st_dep_nlainin    =0;
        $st_dep_sales      =0;
        $st_dep_kirim      =0;
        $st_dep_prepack    =0;
        $st_dep_hilang     =0;
        $st_dep_nlainout   =0;
        $st_dep_intrst     =0;
        $st_dep_nadj       =0;
        $st_dep_koreksi    =0;
        $st_dep_nakhir     =0;

        $st_div_nbegbal    =0;
        $st_div_beli       =0;
        $st_div_bonus      =0;
        $st_div_trmcb      =0;
        $st_div_retursales =0;
        $st_div_rafak      =0;
        $st_div_repack     =0;
        $st_div_nlainin    =0;
        $st_div_sales      =0;
        $st_div_kirim      =0;
        $st_div_prepack    =0;
        $st_div_hilang     =0;
        $st_div_nlainout   =0;
        $st_div_intrst     =0;
        $st_div_nadj       =0;
        $st_div_koreksi    =0;
        $st_div_nakhir     =0;

        $total_nbegbal     =0;
        $total_beli        =0;
        $total_bonus       =0;
        $total_trmcb       =0;
        $total_retursales  =0;
        $total_rafak       =0;
        $total_repack      =0;
        $total_nlainin     =0;
        $total_sales       =0;
        $total_kirim       =0;
        $total_prepack     =0;
        $total_hilang      =0;
        $total_nlainout    =0;
        $total_intrst      =0;
        $total_nadj        =0;
        $total_koreksi     =0;
        $total_nakhir      =0;
    @endphp
@section('content')
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="3" style="text-align: right"></th>
            <th colspan="2" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PEMBELIAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
            <th colspan="5" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PENERIMAAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
            <th colspan="5" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PENGELUARAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
        </tr>
        <tr style="text-align: center;">
            <th class="left">KODE</th>
            <th class="left" width="5%">NAMA KATEGORI</th>
            <th class="right" width="5%">SALDO AWAL</th>
            <th class="right">MURNI</th>
            <th class="right">BONUS</th>
            <th class="right">TRANSFER IN</th>
            <th class="right">RETUR<br> PENJUALAN</th>
            <th class="right">RAFAKSI</th>
            <th class="right">REPACK IN<br>(REPACK)</th>
            <th class="right">LAIN-LAIN</th>
            <th class="right">PENJUALAN</th>
            <th class="right">TRANSFER OUT</th>
            <th class="right">REPACK OUT<br>(PREPACK)</th>
            <th class="right">HILANG</th>
            <th class="right">LAIN-LAIN</th>
            <th class="right">INTRANSIT</th>
            <th class="right">PENYESUAIAN</th>
            <th class="right">KOREKSI</th>
            <th class="right">SALDO<br>AKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->lpp_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left"><b>{{$data[$i]->lpp_kodedivisi}}
                            - {{$data[$i]->div_namadivisi}}</b></td>
                </tr>
                <tr>
                    <td class="left"><b>DEPARTEMEN :</b></td>
                    <td class="left"><b>{{$data[$i]->lpp_kodedepartemen}} - {{$data[$i]->dep_namadepartement}}</b>
                    </td>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $data[$i]->lpp_kategoribrg }}</td>
                <td align="left">{{ $data[$i]->kat_namakategori }}</td>
                <td align="right">{{ number_format($data[$i]->nbegbal  ,0)}} </td>
                <td align="right">{{ number_format($data[$i]->beli      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->bonus     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->trmcb     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->retursales,0) }}</td>
                <td align="right">{{ number_format($data[$i]->rafak     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->repack    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->nlainin   ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->sales     ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->kirim     ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->prepack   ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->hilang    ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->nlainout  ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->intrst    ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->nadj      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->koreksi   ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->nakhir    ,0) }}</td>
            </tr>
            @php
                $count_prdcd++;
                $total_prdcd++;

                $st_dep_nbegbal     += $data[$i]->nbegbal   ;
                $st_dep_beli        += $data[$i]->beli      ;
                $st_dep_bonus       += $data[$i]->bonus     ;
                $st_dep_trmcb       += $data[$i]->trmcb     ;
                $st_dep_retursales  += $data[$i]->retursales;
                $st_dep_rafak       += $data[$i]->rafak     ;
                $st_dep_repack      += $data[$i]->repack    ;
                $st_dep_nlainin     += $data[$i]->nlainin   ;
                $st_dep_sales       += $data[$i]->sales     ;
                $st_dep_kirim       += $data[$i]->kirim     ;
                $st_dep_prepack     += $data[$i]->prepack   ;
                $st_dep_hilang      += $data[$i]->hilang    ;
                $st_dep_nlainout    += $data[$i]->nlainout  ;
                $st_dep_intrst      += $data[$i]->intrst    ;
                $st_dep_nadj        += $data[$i]->nadj      ;
                $st_dep_koreksi     += $data[$i]->koreksi   ;
                $st_dep_nakhir      += $data[$i]->nakhir    ;

                $st_div_nbegbal     += $data[$i]->nbegbal   ;
                $st_div_beli        += $data[$i]->beli      ;
                $st_div_bonus       += $data[$i]->bonus     ;
                $st_div_trmcb       += $data[$i]->trmcb     ;
                $st_div_retursales  += $data[$i]->retursales;
                $st_div_rafak       += $data[$i]->rafak     ;
                $st_div_repack      += $data[$i]->repack    ;
                $st_div_nlainin     += $data[$i]->nlainin   ;
                $st_div_sales       += $data[$i]->sales     ;
                $st_div_kirim       += $data[$i]->kirim     ;
                $st_div_prepack     += $data[$i]->prepack   ;
                $st_div_hilang      += $data[$i]->hilang    ;
                $st_div_nlainout    += $data[$i]->nlainout  ;
                $st_div_intrst      += $data[$i]->intrst    ;
                $st_div_nadj        += $data[$i]->nadj      ;
                $st_div_koreksi     += $data[$i]->koreksi   ;
                $st_div_nakhir      += $data[$i]->nakhir    ;

                $total_nbegbal     += $data[$i]->nbegbal   ;
                $total_beli        += $data[$i]->beli      ;
                $total_bonus       += $data[$i]->bonus     ;
                $total_trmcb       += $data[$i]->trmcb     ;
                $total_retursales  += $data[$i]->retursales;
                $total_rafak       += $data[$i]->rafak     ;
                $total_repack      += $data[$i]->repack    ;
                $total_nlainin     += $data[$i]->nlainin   ;
                $total_sales       += $data[$i]->sales     ;
                $total_kirim       += $data[$i]->kirim     ;
                $total_prepack     += $data[$i]->prepack   ;
                $total_hilang      += $data[$i]->hilang    ;
                $total_nlainout    += $data[$i]->nlainout  ;
                $total_intrst      += $data[$i]->intrst    ;
                $total_nadj        += $data[$i]->nadj      ;
                $total_koreksi     += $data[$i]->koreksi   ;
                $total_nakhir      += $data[$i]->nakhir    ;

                $tempdiv = $data[$i]->lpp_kodedivisi;
                $tempdep = $data[$i]->lpp_kodedepartemen;
            @endphp
            @if( isset($data[$i+1]->lpp_kodedivisi) && $tempdiv != $data[$i+1]->lpp_kodedivisi || !(isset($data[$i+1]->lpp_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUBTOTAL DEPARTEMEN :</td>
                    <td align="right">{{ number_format($st_div_nbegbal   ,0)}}</td>
                    <td align="right">{{ number_format($st_div_beli      ,0)}}</td>
                    <td align="right">{{ number_format($st_div_bonus     ,0)}}</td>
                    <td align="right">{{ number_format($st_div_trmcb     ,0) }}</td>
                    <td align="right">{{ number_format($st_div_retursales,0)}}</td>
                    <td align="right">{{ number_format($st_div_rafak     ,0)}}</td>
                    <td align="right">{{ number_format($st_div_repack    ,0) }}</td>
                    <td align="right">{{ number_format($st_div_nlainin   ,0) }}</td>
                    <td align="right">{{ number_format($st_div_sales     ,0) }}</td>
                    <td align="right">{{ number_format($st_div_kirim     ,0) }}</td>
                    <td align="right">{{ number_format($st_div_prepack   ,0) }}</td>
                    <td align="right">{{ number_format($st_div_hilang    ,0) }}</td>
                    <td align="right">{{ number_format($st_div_nlainout  ,0) }}</td>
                    <td align="right">{{ number_format($st_div_intrst    ,0) }}</td>
                    <td align="right">{{ number_format($st_div_nadj      ,0) }}</td>
                    <td align="right">{{ number_format($st_div_koreksi   ,0) }}</td>
                    <td align="right">{{ number_format($st_div_nakhir    ,0) }}</td>
                </tr>
                @php
                    $st_div_nbegbal    = 0;
                    $st_div_beli       = 0;
                    $st_div_bonus      = 0;
                    $st_div_trmcb      = 0;
                    $st_div_retursales = 0;
                    $st_div_rafak      = 0;
                    $st_div_repack     = 0;
                    $st_div_nlainin    = 0;
                    $st_div_sales      = 0;
                    $st_div_kirim      = 0;
                    $st_div_prepack    = 0;
                    $st_div_hilang     = 0;
                    $st_div_nlainout   = 0;
                    $st_div_intrst     = 0;
                    $st_div_nadj       = 0;
                    $st_div_koreksi    = 0;
                    $st_div_nakhir     = 0;
                @endphp
            @endif
            @if( isset($data[$i+1]->lpp_kodedepartemen) && $tempdep != $data[$i+1]->lpp_kodedepartemen || !(isset($data[$i+1]->lpp_kodedepartemen)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUBTOTAL DEPARTEMEN :</td>
                    <td align="right">{{ number_format($st_dep_nbegbal   ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_beli      ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_bonus     ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_trmcb     ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_retursales,0)}}</td>
                    <td align="right">{{ number_format($st_dep_rafak     ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_repack    ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_nlainin   ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_sales     ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_kirim     ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_prepack   ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_hilang    ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_nlainout  ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_intrst    ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_nadj      ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_koreksi   ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_nakhir    ,0) }}</td>
                </tr>
                @php
                    $st_dep_nbegbal    = 0;
                    $st_dep_beli       = 0;
                    $st_dep_bonus      = 0;
                    $st_dep_trmcb      = 0;
                    $st_dep_retursales = 0;
                    $st_dep_rafak      = 0;
                    $st_dep_repack     = 0;
                    $st_dep_nlainin    = 0;
                    $st_dep_sales      = 0;
                    $st_dep_kirim      = 0;
                    $st_dep_prepack    = 0;
                    $st_dep_hilang     = 0;
                    $st_dep_nlainout   = 0;
                    $st_dep_intrst     = 0;
                    $st_dep_nadj       = 0;
                    $st_dep_koreksi    = 0;
                    $st_dep_nakhir     = 0;
                @endphp
            @endif

        @endfor

        <tr>
            <th class="left" colspan="1"><strong>TOTAL SELURUHNYA :</strong></th>
            <th align="right">{{ number_format($total_nbegbal   ,0) }}</th>
            <th align="right">{{ number_format($total_beli      ,0) }}</th>
            <th align="right">{{ number_format($total_bonus     ,0) }}</th>
            <th align="right">{{ number_format($total_trmcb     ,0) }}</th>
            <th align="right">{{ number_format($total_retursales,0) }}</th>
            <th align="right">{{ number_format($total_rafak     ,0) }}</th>
            <th align="right">{{ number_format($total_repack    ,0) }}</th>
            <th align="right">{{ number_format($total_nlainin   ,0) }}</th>
            <th align="right">{{ number_format($total_sales     ,0) }}</th>
            <th align="right">{{ number_format($total_kirim     ,0) }}</th>
            <th align="right">{{ number_format($total_prepack   ,0) }}</th>
            <th align="right">{{ number_format($total_hilang    ,0) }}</th>
            <th align="right">{{ number_format($total_nlainout  ,0) }}</th>
            <th align="right">{{ number_format($total_intrst    ,0) }}</th>
            <th align="right">{{ number_format($total_nadj      ,0) }}</th>
            <th align="right">{{ number_format($total_koreksi   ,0) }}</th>
            <th align="right">{{ number_format($total_nakhir    ,0) }}</th>
        </tr>
        </tbody>
    </table>
@endsection
