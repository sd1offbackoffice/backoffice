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
@section('header_right')
    RINCIAN PER DIVISI (UNIT/RUPIAH)
@endsection
    @php
        $tempdep = '';

        $count=0;
        $total=0;

        $st_sawalrph    =0;
        $st_baikrph     =0;
        $st_returrph    =0;
        $st_musnahrph =0;
        $st_hilangrph   =0;
        $st_lbaikrph    =0;
        $st_lreturrph   =0;
        $st_rph_sel_so  =0;
        $st_adjrph      =0;
        $st_koreksi     =0;
        $st_akhirrph    =0;

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
            <th colspan="2" style="text-align: center"></th>
            <th colspan="2" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PENERIMAAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
            <th colspan="4" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PENGELUARAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
        </tr>
        <tr style="text-align: center;">
            <th class="right" width="1%"></th>
            <th class="right" width="5%">SALDO AWAL</th>
            <th class="right" width="5%" >BAIK</th>
            <th class="right" width="5%" >RETUR</th>
            <th class="right" width="5%" >PEMUSNAHAN</th>
            <th class="right" width="5%" >HILANG</th>
            <th class="right" width="5%" >LAIN BAIK</th>
            <th class="right" width="5%" >LAIN RETUR</th>
            <th class="right" width="5%" >SO</th>
            <th class="right" width="5%" >PENYESUAIAN</th>
            <th class="right" width="5%" >KOREKSI</th>
            <th class="right" width="5%" >SALDOAKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdep != $data[$i]->lrs_kodedepartemen.$data[$i]->lrs_kategoribrg)
                <tr>
                    <td class="left"><b>DEPARTEMEN :</b></td>
                    <td class="left" colspan="3"><b>{{$data[$i]->lrs_kodedepartemen}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                    <td class="left"><b>KATEGORI :</b></td>
                    <td class="left" colspan="7"><b>{{$data[$i]->lrs_kategoribrg}}
                            - {{$data[$i]->kat_namakategori}}</b></td>
                </tr>
            @endif
            <tr>
                <td align="left">UNIT:</td>
                <td align="right">{{ number_format($data[$i]->sawalqty    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->baikqty      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->returqty     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->musnahqty     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->hilangqty   ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lbaikqty    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lreturqty    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->sel_so  ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->adjqty      ,0) }}</td>
                <td align="right"></td>
                <td align="right">{{ number_format($data[$i]->akhirqty    ,0) }}</td>
            </tr>
            <tr>
                <td align="left">Rp.</td>
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
                $count++;
                $total++;

                $st_sawalrph   += $data[$i]->sawalrph  ;
                $st_baikrph    += $data[$i]->baikrph   ;
                $st_returrph   += $data[$i]->returrph  ;
                $st_musnahrph  += $data[$i]->musnahrph ;
                $st_hilangrph  += $data[$i]->hilangrph ;
                $st_lbaikrph   += $data[$i]->lbaikrph  ;
                $st_lreturrph  += $data[$i]->lreturrph ;
                $st_rph_sel_so += $data[$i]->rph_sel_so;
                $st_adjrph     += $data[$i]->adjrph    ;
                $st_koreksi    += $data[$i]->koreksi   ;
                $st_akhirrph   += $data[$i]->akhirrph  ;

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

                        $tempdep = $data[$i]->lrs_kodedepartemen.$data[$i]->lrs_kategoribrg;
            @endphp
            @if( isset($data[$i+1]->lrs_kodedepartemen) && $tempdep != $data[$i+1]->lrs_kodedepartemen.$data[$i+1]->lrs_kategoribrg || !(isset($data[$i+1]->lrs_kodedepartemen)) )
                <tr style="border-bottom: 1px solid black;">
                    <td align="left">SUBTOTAL: {{ number_format($count   ,0)}} ITEM</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td align="left">Rp.</td>
                    <td align="right">{{ number_format($st_sawalrph   ,0)}}</td>
                    <td align="right">{{ number_format($st_baikrph          ,0)}}</td>
                    <td align="right">{{ number_format($st_returrph        ,0)}}</td>
                    <td align="right">{{ number_format($st_musnahrph     ,0)}}</td>
                    <td align="right">{{ number_format($st_hilangrph  ,0) }}</td>
                    <td align="right">{{ number_format($st_lbaikrph       ,0)}}</td>
                    <td align="right">{{ number_format($st_lreturrph      ,0)}}</td>
                    <td align="right">{{ number_format($st_rph_sel_so ,0) }}</td>
                    <td align="right">{{ number_format($st_adjrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_koreksi    ,0) }}</td>
                    <td align="right">{{ number_format($st_akhirrph   ,0) }}</td>
                </tr>
                @php
                    $st_sawalrph    =0;
                    $st_baikrph     =0;
                    $st_returrph    =0;
                    $st_musnahrph =0;
                    $st_hilangrph   =0;
                    $st_lbaikrph    =0;
                    $st_lreturrph   =0;
                    $st_rph_sel_so  =0;
                    $st_adjrph      =0;
                    $st_koreksi     =0;
                    $st_akhirrph =0;

                    $count =0;
                @endphp
            @endif


        @endfor
        <tr>
            <td class="left"><strong>TOTAL : {{ number_format($total   ,0) }} ITEM</strong></td>
        </tr>
        <tr>
            <th class="left"><strong>Rp.</strong></th>
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
