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
@section('paper_width','1250pt')
@section('header_right')
    RINGKASAN PER DIVISI (RUPIAH)
@endsection
    @php
        $tempdiv = '';
        $tempdep = '';

        $st_div_sawalrph   = 0;
        $st_div_sawalqty   = 0;
        $st_div_beli       = 0;
        $st_div_bonus      = 0;
        $st_div_trmcb      = 0;
        $st_div_retursales = 0;
        $st_div_repack     = 0;
        $st_div_lainin     = 0;
        $st_div_sales      = 0;
        $st_div_kirim      = 0;
        $st_div_prepack    = 0;
        $st_div_hilang     = 0;
        $st_div_lainout    = 0;
        $st_div_rph_sel_so = 0;
        $st_div_intrst     = 0;
        $st_div_adj        = 0;
        $st_div_koreksi    = 0;
        $st_div_akhir      = 0;
        $st_div_akhirq      = 0;

        $st_dep_sawalrph   = 0;
        $st_dep_sawalqty   = 0;
        $st_dep_beli       = 0;
        $st_dep_bonus      = 0;
        $st_dep_trmcb      = 0;
        $st_dep_retursales = 0;
        $st_dep_repack     = 0;
        $st_dep_lainin     = 0;
        $st_dep_sales      = 0;
        $st_dep_kirim      = 0;
        $st_dep_prepack    = 0;
        $st_dep_hilang     = 0;
        $st_dep_lainout    = 0;
        $st_dep_rph_sel_so = 0;
        $st_dep_intrst     = 0;
        $st_dep_adj        = 0;
        $st_dep_koreksi    = 0;
        $st_dep_akhir      = 0;
        $st_dep_akhirq      = 0;

        $total_sawalrph   = 0;
        $total_sawalqty   = 0;
        $total_beli       = 0;
        $total_bonus      = 0;
        $total_trmcb      = 0;
        $total_retursales = 0;
        $total_repack     = 0;
        $total_lainin     = 0;
        $total_sales      = 0;
        $total_kirim      = 0;
        $total_prepack    = 0;
        $total_hilang     = 0;
        $total_lainout    = 0;
        $total_rph_sel_so = 0;
        $total_intrst     = 0;
        $total_adj        = 0;
        $total_koreksi    = 0;
        $total_akhir      = 0;
        $total_akhirq      = 0;
    @endphp
@section('content')

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="3" style="text-align: center"></th>
            <th colspan="2" style="text-align: center">----------------PEMBELIAN----------------</th>
            <th colspan="5" style="text-align: center">------------------------------------PENERIMAAN------------------------------------</th>
            <th colspan="5" style="text-align: center">------------------------------------PENGELUARAN------------------------------------</th>
        </tr>
        <tr style="text-align: center;">
            <th class="left">KODE</th>
            <th class="left">NAMA KATEGORI</th>
            <th class="right" width="10%">SALDO AWAL</th>
            <th class="right">MURNI</th>
            <th class="right">BONUS</th>
            <th class="right">TRANSFER IN</th>
            <th class="right">RETUR<br> PENJUALAN</th>
            <th class="right">REPACK IN<br>(REPACK)</th>
            <th class="right">LAIN-LAIN</th>
            <th class="right">PENJUALAN</th>
            <th class="right">TRANSFER OUT</th>
            <th class="right">REPACK OUT<br>(PREPACK)</th>
            <th class="right">HILANG</th>
            <th class="right">LAIN-LAIN</th>
            <th class="right">SO</th>
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
                    <td class="left" colspan="17"><b>{{$data[$i]->lpp_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->lpp_kodedepartemen)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="17"><b>{{$data[$i]->lpp_kodedepartemen}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $data[$i]->lpp_kategoribrg }}</td>
                <td align="left">{{ $data[$i]->kat_namakategori }}</td>
                <td align="right">{{ number_format($data[$i]->sawalrph  ,0)}} <br> {{number_format($data[$i]->sawalqty  ,0)}} </td>
                <td align="right">{{ number_format($data[$i]->beli      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->bonus     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->trmcb     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->retursales,0) }}</td>
                <td align="right">{{ number_format($data[$i]->repack    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lainin    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->sales,0) }}</td>
                <td align="right">{{ number_format($data[$i]->kirim,0) }}</td>
                <td align="right">{{ number_format($data[$i]->prepack,0) }}</td>
                <td align="right">{{ number_format($data[$i]->hilang,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lainout,0) }}</td>
                <td align="right">{{ number_format($data[$i]->rph_sel_so,0) }}</td>
                <td align="right">{{ number_format($data[$i]->intrst,0) }}</td>
                <td align="right">{{ number_format($data[$i]->adj,0) }}</td>
                <td align="right">{{ round($data[$i]->koreksi) }}</td>
                <td align="right">{{ number_format($data[$i]->akhir,0) }} <br> {{$data[$i]->akhirq}}</td>
            </tr>
            @php
        $st_div_sawalrph   += $data[$i]->sawalrph   ;
        $st_div_sawalqty   += $data[$i]->sawalqty   ;
        $st_div_beli       += $data[$i]->beli       ;
        $st_div_bonus      += $data[$i]->bonus      ;
        $st_div_trmcb      += $data[$i]->trmcb      ;
        $st_div_retursales += $data[$i]->retursales ;
        $st_div_repack     += $data[$i]->repack     ;
        $st_div_lainin     += $data[$i]->lainin     ;
        $st_div_sales      += $data[$i]->sales      ;
        $st_div_kirim      += $data[$i]->kirim      ;
        $st_div_prepack    += $data[$i]->prepack    ;
        $st_div_hilang     += $data[$i]->hilang     ;
        $st_div_lainout    += $data[$i]->lainout    ;
        $st_div_rph_sel_so += $data[$i]->rph_sel_so ;
        $st_div_intrst     += $data[$i]->intrst     ;
        $st_div_adj        += $data[$i]->adj        ;
        $st_div_koreksi    += $data[$i]->koreksi    ;
        $st_div_akhir      += $data[$i]->akhir      ;
        $st_div_akhirq      += $data[$i]->akhirq    ;

        $st_dep_sawalrph   += $data[$i]->sawalrph   ;
        $st_dep_sawalqty   += $data[$i]->sawalqty   ;
        $st_dep_beli       += $data[$i]->beli       ;
        $st_dep_bonus      += $data[$i]->bonus      ;
        $st_dep_trmcb      += $data[$i]->trmcb      ;
        $st_dep_retursales += $data[$i]->retursales ;
        $st_dep_repack     += $data[$i]->repack     ;
        $st_dep_lainin     += $data[$i]->lainin     ;
        $st_dep_sales      += $data[$i]->sales      ;
        $st_dep_kirim      += $data[$i]->kirim      ;
        $st_dep_prepack    += $data[$i]->prepack    ;
        $st_dep_hilang     += $data[$i]->hilang     ;
        $st_dep_lainout    += $data[$i]->lainout    ;
        $st_dep_rph_sel_so += $data[$i]->rph_sel_so ;
        $st_dep_intrst     += $data[$i]->intrst     ;
        $st_dep_adj        += $data[$i]->adj        ;
        $st_dep_koreksi    += $data[$i]->koreksi    ;
        $st_dep_akhir      += $data[$i]->akhir      ;
        $st_dep_akhirq      += $data[$i]->akhirq    ;

        $total_sawalrph   += $data[$i]->sawalrph   ;
        $total_sawalqty   += $data[$i]->sawalqty   ;
        $total_beli       += $data[$i]->beli       ;
        $total_bonus      += $data[$i]->bonus      ;
        $total_trmcb      += $data[$i]->trmcb      ;
        $total_retursales += $data[$i]->retursales ;
        $total_repack     += $data[$i]->repack     ;
        $total_lainin     += $data[$i]->lainin     ;
        $total_sales      += $data[$i]->sales      ;
        $total_kirim      += $data[$i]->kirim      ;
        $total_prepack    += $data[$i]->prepack    ;
        $total_hilang     += $data[$i]->hilang     ;
        $total_lainout    += $data[$i]->lainout    ;
        $total_rph_sel_so += $data[$i]->rph_sel_so ;
        $total_intrst     += $data[$i]->intrst     ;
        $total_adj        += $data[$i]->adj        ;
        $total_koreksi    += $data[$i]->koreksi    ;
        $total_akhir      += $data[$i]->akhir      ;
        $total_akhirq      += $data[$i]->akhirq    ;

        $tempdiv = $data[$i]->lpp_kodedivisi;
        $tempdep = $data[$i]->lpp_kodedepartemen;
            @endphp
            @if( isset($data[$i+1]->lpp_kodedepartemen) && $tempdep != $data[$i+1]->lpp_kodedepartemen || !(isset($data[$i+1]->lpp_kodedepartemen)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DEPT</td>
                    <td class="left">{{ $data[$i]->lpp_kodedepartemen }} - {{$data[$i]->dep_namadepartement}}</td>
                    <td align="right">{{ number_format($st_dep_sawalrph  ,0)}} <br>{{number_format($st_dep_sawalqty  ,0)}} </td>
                    <td align="right">{{ number_format($st_dep_beli            ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_bonus          ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_trmcb          ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_retursales,0) }}</td>
                    <td align="right">{{ number_format($st_dep_repack        ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_lainin        ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_sales     ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_kirim     ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_prepack   ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_hilang    ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_lainout   ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_rph_sel_so,0) }}</td>
                    <td align="right">{{ number_format($st_dep_intrst    ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_adj       ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_koreksi   ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_akhir     ,0) }} <br> {{ number_format($st_dep_akhirq     ,0) }}</td>
                </tr>
                @php
                     $st_dep_sawalrph   = 0;
                     $st_dep_sawalqty   = 0;
                     $st_dep_beli       = 0;
                     $st_dep_bonus      = 0;
                     $st_dep_trmcb      = 0;
                     $st_dep_retursales = 0;
                     $st_dep_repack     = 0;
                     $st_dep_lainin     = 0;
                     $st_dep_sales      = 0;
                     $st_dep_kirim      = 0;
                     $st_dep_prepack    = 0;
                     $st_dep_hilang     = 0;
                     $st_dep_lainout    = 0;
                     $st_dep_rph_sel_so = 0;
                     $st_dep_intrst     = 0;
                     $st_dep_adj        = 0;
                     $st_dep_koreksi    = 0;
                     $st_dep_akhir      = 0;
                     $st_dep_akhirq      = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->lpp_kodedivisi) && $tempdiv != $data[$i+1]->lpp_kodedivisi) || !(isset($data[$i+1]->lpp_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DIVISI</td>
                    <td class="left">{{ $data[$i]->lpp_kodedivisi }} - {{ $data[$i]->div_namadivisi }}</td>
                    <td align="right">{{ number_format($st_div_sawalrph  ,0)}} <br> {{number_format($st_div_sawalqty  ,0)}}</td>
                    <td align="right">{{ number_format($st_div_beli            ,0)}}</td>
                    <td align="right">{{ number_format($st_div_bonus          ,0)}}</td>
                    <td align="right">{{ number_format($st_div_trmcb          ,0)}}</td>
                    <td align="right">{{ number_format($st_div_retursales,0) }}</td>
                    <td align="right">{{ number_format($st_div_repack        ,0)}}</td>
                    <td align="right">{{ number_format($st_div_lainin        ,0)}}</td>
                    <td align="right">{{ number_format($st_div_sales     ,0) }}</td>
                    <td align="right">{{ number_format($st_div_kirim     ,0) }}</td>
                    <td align="right">{{ number_format($st_div_prepack   ,0) }}</td>
                    <td align="right">{{ number_format($st_div_hilang    ,0) }}</td>
                    <td align="right">{{ number_format($st_div_lainout   ,0) }}</td>
                    <td align="right">{{ number_format($st_div_rph_sel_so,0) }}</td>
                    <td align="right">{{ number_format($st_div_intrst    ,0) }}</td>
                    <td align="right">{{ number_format($st_div_adj       ,0) }}</td>
                    <td align="right">{{ number_format($st_div_koreksi   ,0) }}</td>
                    <td align="right">{{ number_format($st_div_akhir     ,0) }} <br> {{ number_format($st_div_akhirq,0) }}</td>
                </tr>
                @php
                        $st_div_sawalrph   = 0;
                        $st_div_sawalqty   = 0;
                        $st_div_beli       = 0;
                        $st_div_bonus      = 0;
                        $st_div_trmcb      = 0;
                        $st_div_retursales = 0;
                        $st_div_repack     = 0;
                        $st_div_lainin     = 0;
                        $st_div_sales      = 0;
                        $st_div_kirim      = 0;
                        $st_div_prepack    = 0;
                        $st_div_hilang     = 0;
                        $st_div_lainout    = 0;
                        $st_div_rph_sel_so = 0;
                        $st_div_intrst     = 0;
                        $st_div_adj        = 0;
                        $st_div_koreksi    = 0;
                        $st_div_akhir      = 0;
                        $st_div_akhirq      = 0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td align="right">{{ number_format($total_sawalrph  ,0)}} <br> {{number_format($total_sawalqty  ,0)}}</td>
            <td align="right">{{ number_format($total_beli            ,0)}}</td>
            <td align="right">{{ number_format($total_bonus          ,0)}}</td>
            <td align="right">{{ number_format($total_trmcb          ,0)}}</td>
            <td align="right">{{ number_format($total_retursales,0) }}</td>
            <td align="right">{{ number_format($total_repack        ,0)}}</td>
            <td align="right">{{ number_format($total_lainin        ,0)}}</td>
            <td align="right">{{ number_format($total_sales     ,0) }}</td>
            <td align="right">{{ number_format($total_kirim     ,0) }}</td>
            <td align="right">{{ number_format($total_prepack   ,0) }}</td>
            <td align="right">{{ number_format($total_hilang    ,0) }}</td>
            <td align="right">{{ number_format($total_lainout   ,0) }}</td>
            <td align="right">{{ number_format($total_rph_sel_so,0) }}</td>
            <td align="right">{{ number_format($total_intrst    ,0) }}</td>
            <td align="right">{{ number_format($total_adj       ,0) }}</td>
            <td align="right">{{ number_format($total_koreksi   ,0) }}</td>
            <td align="right">{{ number_format($total_akhir     ,0) }} <br>{{ number_format($total_akhirq,0) }} </td>
        </tr>
        <tr>
            <td class="left" colspan="4"><strong>Lain - Lain Out termasuk :</strong></td>
            <td class="left" colspan="4"><strong>Transfer In termasuk :</strong></td>
            <td class="left" colspan="4"><strong>Transfer Out termasuk :</strong></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>Nilai BA IDM (Acost) --></strong></td>
            <td class="left" colspan="2"><strong>{{ number_format($p_nilaiidmacost,0) }}</strong></td>
            <td class="left" colspan="2"><strong>Nilai Penjualan HBV --> </strong></td>
            <td class="left" colspan="2"><strong>{{ number_format($p_nilaihbvtrfin,0) }} </strong></td>
            <td class="left" colspan="2"><strong>Nilai Penjualan HBV --> </strong></td>
            <td class="left" colspan="2"><strong>{{ number_format($p_nilaihbvtrfout,0) }} </strong></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>Nilai BA IDM (Price) --></strong></td>
            <td class="left" colspan="2"><strong>{{ number_format($p_nilaiidmprice,0) }} </strong></td>
        </tr>
        <tr>
            <td class="left" colspan="4"><strong>Nilai SO termasuk : SONAS + SO IC</strong></td>
        </tr>
        </tfoot>
    </table>

@endsection
