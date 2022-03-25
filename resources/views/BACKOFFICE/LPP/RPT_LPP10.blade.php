@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    {{ $title }}
@endsection

@section('title')
    {{ $title }}
@endsection

@section('subtitle')
    TANGGAL : {{date('d/M/Y',strtotime(str_replace('/','-',$tgl1)))}} s/d {{date('d/M/Y',strtotime(str_replace('/','-',$tgl2)))}}
@endsection

@section('paper_height','595pt')
@section('paper_width','1200pt')
@section('header_right')
    RINCIAN PER DIVISI (UNIT/RUPIAH)
@endsection
    @php
        $tempdiv = '';
        $tempdep = '';

        $st_div_sawalrph    =0;
        $st_div_baikrph     =0;
        $st_div_returrph    =0;
        $st_div_musnahrph =0;
        $st_div_hilangrph   =0;
        $st_div_lbaikrph    =0;
        $st_div_lreturrph   =0;
        $st_div_rph_sel_so  =0;
        $st_div_adjrph      =0;
        $st_div_koreksi     =0;
        $st_div_akhirrph    =0;

        $st_dep_sawalrph    =0;
        $st_dep_baikrph     =0;
        $st_dep_retrurph    =0;
        $st_dep_musnahrph =0;
        $st_dep_hilangrph   =0;
        $st_dep_lbaikrph    =0;
        $st_dep_lreturrph   =0;
        $st_dep_rph_sel_so  =0;
        $st_dep_adjrph      =0;
        $st_dep_koreksi     =0;
        $st_dep_akhirrph    =0;

        $total_sawalrph    =0;
        $total_baikrph     =0;
        $total_retrurrph    =0;
        $total_musnahrph =0;
        $total_hilangrph   =0;
        $total_lbaikrph    =0;
        $total_lreturrph   =0;
        $total_rph_sel_so  =0;
        $total_adjrph      =0;
        $total_koreksi     =0;
        $total_akhirrph    =0;
    @endphp
@section('content')

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="3" style="text-align: center"></th>
            <th colspan="2" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PENERIMAAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
            <th colspan="4" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PENGELUARAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
        </tr>
        <tr style="text-align: center;">
            <th class="left">KODE</th>
            <th class="left" width="5%">NAMA KATEGORI</th>
            <th class="right" width="5%">SALDO AWAL</th>
            <th class="right">BAIK</th>
            <th class="right">RETUR</th>
            <th class="right">PEMUSNAHAN</th>
            <th class="right">HILANG</th>
            <th class="right">LAIN BAIK</th>
            <th class="right">LAIN RETUR</th>
            <th class="right" width="5%">SO</th>
            <th class="right">PENYESUAIAN</th>
            <th class="right">KOREKSI</th>
            <th class="right">SALDOAKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->lrs_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="17"><b>{{$data[$i]->lrs_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->lrs_kodedepartemen)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="17"><b>{{$data[$i]->lrs_kodedepartemen}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $data[$i]->lrs_kategoribrg }}</td>
                <td align="left">{{ $data[$i]->kat_namakategori }}</td>
                <td align="right">{{ number_format($data[$i]->sawalrph    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->baikrph      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->returrph     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->musnahrph     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->hilangrph   ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lbaikrph    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lreturrph    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->rph_sel_so  ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->adjrph      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->koreksi     ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->akhirrph    ,0) }}</td>
            </tr>
            @php
        $st_div_sawalrph   += $data[$i]->sawalrph  ;
        $st_div_baikrph    += $data[$i]->baikrph   ;
        $st_div_returrph   += $data[$i]->returrph  ;
        $st_div_musnahrph  += $data[$i]->musnahrph ;
        $st_div_hilangrph  += $data[$i]->hilangrph ;
        $st_div_lbaikrph   += $data[$i]->lbaikrph  ;
        $st_div_lreturrph  += $data[$i]->lreturrph ;
        $st_div_rph_sel_so += $data[$i]->rph_sel_so;
        $st_div_adjrph     += $data[$i]->adjrph    ;
        $st_div_koreksi    += $data[$i]->koreksi   ;
        $st_div_akhirrph   += $data[$i]->akhirrph  ;

        $st_dep_sawalrph   += $data[$i]->sawalrph  ;
        $st_dep_baikrph    += $data[$i]->baikrph   ;
        $st_dep_retrurph   += $data[$i]->returrph  ;
        $st_dep_musnahrph  += $data[$i]->musnahrph ;
        $st_dep_hilangrph  += $data[$i]->hilangrph ;
        $st_dep_lbaikrph   += $data[$i]->lbaikrph  ;
        $st_dep_lreturrph  += $data[$i]->lreturrph ;
        $st_dep_rph_sel_so += $data[$i]->rph_sel_so;
        $st_dep_adjrph     += $data[$i]->adjrph    ;
        $st_dep_koreksi    += $data[$i]->koreksi   ;
        $st_dep_akhirrph   += $data[$i]->akhirrph  ;

        $total_sawalrph   += $data[$i]->sawalrph  ;
        $total_baikrph    += $data[$i]->baikrph   ;
        $total_retrurrph   += $data[$i]->returrph  ;
        $total_musnahrph+= $data[$i]->musnahrph ;
        $total_hilangrph  += $data[$i]->hilangrph ;
        $total_lbaikrph   += $data[$i]->lbaikrph  ;
        $total_lreturrph  += $data[$i]->lreturrph ;
        $total_rph_sel_so += $data[$i]->rph_sel_so;
        $total_adjrph     += $data[$i]->adjrph    ;
        $total_koreksi    += $data[$i]->koreksi   ;
        $total_akhirrph   += $data[$i]->akhirrph  ;

                $tempdiv = $data[$i]->lrs_kodedivisi;
                $tempdep = $data[$i]->lrs_kodedepartemen;
            @endphp
            @if( isset($data[$i+1]->lrs_kodedepartemen) && $tempdep != $data[$i+1]->lrs_kodedepartemen || !(isset($data[$i+1]->lrs_kodedepartemen)) )
                <tr style="border-bottom: 1px solid black;">
                    <td align="left" colspan="2">SUB TOTAL DEPT</td>
                    <td align="right">{{ number_format($st_div_sawalrph   ,0)}}</td>
                    <td align="right">{{ number_format($st_div_baikrph          ,0)}}</td>
                    <td align="right">{{ number_format($st_div_returrph        ,0)}}</td>
                    <td align="right">{{ number_format($st_div_musnahrph     ,0)}}</td>
                    <td align="right">{{ number_format($st_div_hilangrph  ,0) }}</td>
                    <td align="right">{{ number_format($st_div_lbaikrph       ,0)}}</td>
                    <td align="right">{{ number_format($st_div_lreturrph      ,0)}}</td>
                    <td align="right">{{ number_format($st_div_rph_sel_so ,0) }}</td>
                    <td align="right">{{ number_format($st_div_adjrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_div_koreksi    ,0) }}</td>
                    <td align="right">{{ number_format($st_div_akhirrph   ,0) }}</td>
                </tr>
                @php
                    $st_div_sawalrph    =0;
                    $st_div_baikrph     =0;
                    $st_div_returrph    =0;
                    $st_div_musnahrph =0;
                    $st_div_hilangrph   =0;
                    $st_div_lbaikrph    =0;
                    $st_div_lreturrph   =0;
                    $st_div_rph_sel_so  =0;
                    $st_div_adjrph      =0;
                    $st_div_koreksi     =0;
                    $st_div_akhirrph =0;
                @endphp
            @endif
            @if((isset($data[$i+1]->lrs_kodedivisi) && $tempdiv != $data[$i+1]->lrs_kodedivisi) || !(isset($data[$i+1]->lrs_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left" colspan="2">SUB TOTAL DIVISI</td>
                    <td align="right">{{ number_format($st_dep_sawalrph   ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_baikrph          ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_retrurph        ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_musnahrph     ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_hilangrph  ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_lbaikrph       ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_lreturrph      ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_rph_sel_so ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_adjrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_koreksi    ,0) }}</td>
                    <td align="right">{{ number_format($st_dep_akhirrph   ,0) }}</td>
                </tr>
                @php
                 $st_dep_sawalrph    =0;
                 $st_dep_baikrph     =0;
                 $st_dep_retrurph    =0;
                 $st_dep_musnahrph =0;
                 $st_dep_hilangrph   =0;
                 $st_dep_lbaikrph    =0;
                 $st_dep_lreturrph   =0;
                 $st_dep_rph_sel_so  =0;
                 $st_dep_adjrph      =0;
                 $st_dep_koreksi     =0;
                 $st_dep_akhirrph =0;
                @endphp
            @endif

        @endfor
        <tr>
            <th class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></th>
            <th align="right">{{ number_format($total_sawalrph   ,0)}}</th>
            <th align="right">{{ number_format($total_baikrph          ,0)}}</th>
            <th align="right">{{ number_format($total_retrurrph        ,0)}}</th>
            <th align="right">{{ number_format($total_musnahrph     ,0)}}</th>
            <th align="right">{{ number_format($total_hilangrph  ,0) }}</th>
            <th align="right">{{ number_format($total_lbaikrph       ,0)}}</th>
            <th align="right">{{ number_format($total_lreturrph      ,0)}}</th>
            <th align="right">{{ number_format($total_rph_sel_so ,0) }}</th>
            <th align="right">{{ number_format($total_adjrph     ,0) }}</th>
            <th align="right">{{ number_format($total_koreksi    ,0) }}</th>
            <th align="right">{{ number_format($total_akhirrph   ,0) }}</th>
        </tr>
        </tbody>
    </table>

  @endsection
