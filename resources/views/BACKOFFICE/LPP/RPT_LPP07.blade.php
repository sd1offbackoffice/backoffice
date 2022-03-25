@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    {{ isset($data[0])?$data[0]->judul:'' }}
@endsection

@section('title')
    {{ isset($data[0])?$data[0]->judul:'' }}
@endsection

@section('subtitle')
    TANGGAL : {{date('d/M/Y',strtotime(str_replace('/','-',$tgl1)))}} s/d {{date('d/M/Y',strtotime(str_replace('/','-',$tgl2)))}}
@endsection

@section('paper_height','595pt')
@section('paper_width','1200pt')
    @php
        $tempmtr = '';

        $count_prdcd = 0;
        $total_prdcd = 0;

        $st_sawalqty      = 0;
        $st_sawalrph      = 0;
        $st_belirph       = 0;
        $st_bonusrph      = 0;
        $st_trmcbrph      = 0;
        $st_returrph     = 0;
        $st_rafakrph     = 0;
        $st_repackrph     = 0;
        $st_laininrph     = 0;
        $st_salesrph      = 0;
        $st_kirimrph      = 0;
        $st_repackrph    = 0;
        $st_hilangrph     = 0;
        $st_lainoutrph    = 0;
        $st_intrstrph     = 0;
        $st_adjrph        = 0;
        $st_koreksirph    = 0;
        $st_akhirrph      = 0;

        $st_akhirqty = 0;
        $total_sawalqty      = 0;
        $total_sawalrph      = 0;
        $total_belirph       = 0;
        $total_bonusrph      = 0;
        $total_trmcbrph      = 0;
        $total_returrph     = 0;
        $total_rafakrph     = 0;
        $total_repackrph     = 0;
        $total_laininrph     = 0;
        $total_salesrph      = 0;
        $total_kirimrph      = 0;
        $total_repackrph    = 0;
        $total_hilangrph     = 0;
        $total_lainoutrph    = 0;
        $total_intrstrph     = 0;
        $total_adjrph        = 0;
        $total_koreksirph    = 0;
        $total_akhirrph      = 0;
        $total_akhirqty = 0;
    @endphp
@section('content')

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="2" style="text-align: right"></th>
            <th colspan="2" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PEMBELIAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
            <th colspan="5" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PENERIMAAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
            <th colspan="5" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - PENGELUARAN- - - - - - - - - - - - - - - - - - - - - - - - </th>
        </tr>
        <tr style="text-align: center;">
            <th></th>
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
            @if($tempmtr != $data[$i]->mpl_kodemonitoring)
                <tr>
                    <td class="left" colspan="5">TIPE MONITOR : {{$data[$i]->mpl_kodemonitoring}}
                            - {{$data[$i]->mpl_namamonitoring}}</td>
                </tr>
            @endif
            <tr>
                <td colspan="4" align="left">{{ $data[$i]->mpl_prdcd }} {{ $data[$i]->prd_deskripsipanjang }} {{ $data[$i]->kemasan }}</td>
            </tr>
            <tr>
                <td align="left">UNIT :</td>
                <td align="right">{{ number_format($data[$i]->sawalqty  ,0)}} </td>
                <td align="right">{{ number_format($data[$i]->beliqty      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->bonusqty     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->trmcbqty     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->retursalesqty,0) }}</td>
                <td align="right"></td>
                <td align="right">{{ number_format($data[$i]->repackqty    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->laininqty    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->salesqty,0) }}</td>
                <td align="right">{{ number_format($data[$i]->kirimqty,0) }}</td>
                <td align="right">{{ number_format($data[$i]->prepackqty,0) }}</td>
                <td align="right">{{ number_format($data[$i]->hilangqty,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lainoutqty,0) }}</td>
                <td align="right">{{ number_format($data[$i]->intrstqty,0) }}</td>
                <td align="right">{{ number_format($data[$i]->adjqty,0) }}</td>
                <td align="right">{{ 0 }}</td>
                <td align="right">{{ number_format($data[$i]->akhirqty,0) }}</td>
            </tr>
            <tr>
                <td align="left">Rp :</td>
                <td align="right">{{ number_format($data[$i]->sawalrph  ,0)}} </td>
                <td align="right">{{ number_format($data[$i]->belirph      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->bonusrph     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->trmcbrph     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->retursalesrph,0) }}</td>
                <td align="right">{{ number_format($data[$i]->rafakrph    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->repackrph    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->laininrph    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->salesrph,0) }}</td>
                <td align="right">{{ number_format($data[$i]->kirimrph,0) }}</td>
                <td align="right">{{ number_format($data[$i]->repackrph,0) }}</td>
                <td align="right">{{ number_format($data[$i]->hilangrph,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lainoutrph,0) }}</td>
                <td align="right">{{ number_format($data[$i]->intrstrph,0) }}</td>
                <td align="right">{{ number_format($data[$i]->adjrph,0) }}</td>
{{--                <td align="right">{{ number_format($data[$i]->sadj,0) }}</td>--}}
                <td align="right">{{ number_format(0,0) }}</td>
                <td align="right">{{ number_format($data[$i]->akhirrph,0) }}</td>
            </tr>
            @php
                $count_prdcd ++;
                $st_sawalqty      += $data[$i]->sawalqty  ;
                $st_sawalrph      += $data[$i]->sawalrph  ;
                $st_belirph       += $data[$i]->belirph   ;
                $st_bonusrph      += $data[$i]->bonusrph  ;
                $st_trmcbrph      += $data[$i]->trmcbrph  ;
                $st_returrph      += $data[$i]->retursalesrph  ;
                $st_rafakrph      += $data[$i]->rafakrph  ;
                $st_laininrph     += $data[$i]->laininrph ;
                $st_salesrph      += $data[$i]->salesrph  ;
                $st_kirimrph      += $data[$i]->kirimrph  ;
                $st_repackrph     += $data[$i]->repackrph ;
                $st_hilangrph     += $data[$i]->hilangrph ;
                $st_lainoutrph    += $data[$i]->lainoutrph;
                $st_intrstrph     += $data[$i]->intrstrph ;
                $st_adjrph        += $data[$i]->adjrph    ;
                $st_koreksirph    += $data[$i]->sadj;
                $st_akhirrph      += $data[$i]->akhirrph  ;
                $st_akhirqty     += $data[$i]->akhirqty  ;

                $total_sawalqty      += $data[$i]->sawalqty  ;
                $total_sawalrph      += $data[$i]->sawalrph  ;
                $total_belirph       += $data[$i]->belirph   ;
                $total_bonusrph      += $data[$i]->bonusrph  ;
                $total_trmcbrph      += $data[$i]->trmcbrph  ;
                $total_returrph      += $data[$i]->retursalesrph  ;
                $total_rafakrph      += $data[$i]->rafakrph  ;
                $total_repackrph     += $data[$i]->repackrph ;
                $total_laininrph     += $data[$i]->laininrph ;
                $total_salesrph      += $data[$i]->salesrph  ;
                $total_kirimrph      += $data[$i]->kirimrph  ;
                $total_hilangrph     += $data[$i]->hilangrph ;
                $total_lainoutrph    += $data[$i]->lainoutrph;
                $total_intrstrph     += $data[$i]->intrstrph ;
                $total_adjrph        += $data[$i]->adjrph    ;
                $total_koreksirph    += $data[$i]->sadj;
                $total_akhirrph      += $data[$i]->akhirrph  ;
                $total_akhirqty      += $data[$i]->akhirqty  ;

                $tempmtr = $data[$i]->mpl_kodemonitoring;
            @endphp
            @if( isset($data[$i+1]->mpl_kodemonitoring) && $tempmtr != $data[$i+1]->mpl_kodemonitoring || !(isset($data[$i+1]->mpl_kodemonitoring)) )
                <tr style="border-top: 1px solid black">
                    <th class="left">SUBTOTAL: </th>
                </tr>
                <tr>
                    <td class="left">UNIT :</td>
                    <td class="right" >{{ number_format($st_sawalqty,0)}}</td>
                    <td class="right" colspan="15"></td>
                    <td align="right">{{ number_format($st_akhirqty,0)}}</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">Rp.</td>
                    <td align="right">{{ number_format($st_sawalrph            ,0)}}</td>
                    <td align="right">{{ number_format($st_belirph            ,0)}}</td>
                    <td align="right">{{ number_format($st_bonusrph           ,0)}}</td>
                    <td align="right">{{ number_format($st_trmcbrph  ,0) }}</td>
                    <td align="right">{{ number_format($st_returrph          ,0)}}</td>
                    <td align="right">{{ number_format($st_rafakrph          ,0)}}</td>
                    <td align="right">{{ number_format($st_repackrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_laininrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_salesrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_kirimrph      ,0) }}</td>
                    <td align="right">{{ number_format($st_repackrph    ,0) }}</td>
                    <td align="right">{{ number_format($st_hilangrph ,0) }}</td>
                    <td align="right">{{ number_format($st_lainoutrph    ,0) }}</td>
                    <td align="right">{{ number_format($st_intrstrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_adjrph       ,0) }}</td>
{{--                    <td align="right">{{ number_format($st_koreksirph    ,0) }}</td>--}}
                    <td align="right">{{ number_format(0    ,0) }}</td>
                    <td align="right">{{ number_format($st_akhirrph    ,0) }}</td>
                </tr>
                @php
                    $st_sawalqty      = 0;
                    $st_sawalrph      = 0;
                    $st_belirph       = 0;
                    $st_bonusrph      = 0;
                    $st_trmcbrph      = 0;
                    $st_returrph     = 0;
                    $st_refakrph     = 0;
                    $st_repackrph     = 0;
                    $st_laininrph     = 0;
                    $st_salesrph      = 0;
                    $st_kirimrph      = 0;
                    $st_repackrph    = 0;
                    $st_hilangrph     = 0;
                    $st_lainoutrph    = 0;
                    $st_intrstrph     = 0;
                    $st_adjrph        = 0;
                    $st_koreksirph    = 0;
                    $st_akhirrph      = 0;
                    $st_akhirqty      = 0;
                    $count_prdcd ++;

                @endphp
            @endif
        @endfor

        <tr>
            <th align="left">GRANDTOTAL :</th>
        </tr>
        <tr>
            <th align="left"><strong>UNIT :</strong></th>
            <th align="right">{{ number_format($total_sawalqty,0) }}</th>
            <th align="left" colspan="15"></th>
            <th align="right">{{ number_format($total_akhirqty,0)}}</th>
        </tr>
        <tr>
            <th align="left" colspan="1"><strong>Rp :</strong></th>
            <th align="right">{{ number_format($total_sawalrph    ,0)}}</th>
            <th align="right">{{ number_format($total_belirph              ,0)}}</th>
            <th align="right">{{ number_format($total_bonusrph            ,0)}}</th>
            <th align="right">{{ number_format($total_trmcbrph            ,0)}}</th>
            <th align="right">{{ number_format($total_returrph  ,0) }}</th>
            <th align="right">{{ number_format($total_rafakrph          ,0)}}</th>
            <th align="right">{{ number_format($total_repackrph       ,0)}}</th>
            <th align="right">{{ number_format($total_laininrph      ,0) }}</th>
            <th align="right">{{ number_format($total_salesrph       ,0) }}</th>
            <th align="right">{{ number_format($total_kirimrph     ,0) }}</th>
            <th align="right">{{ number_format($total_repackrph       ,0)}}</th>
            <th align="right">{{ number_format($total_hilangrph     ,0) }}</th>
            <th align="right">{{ number_format($total_lainoutrph   ,0) }}</th>
            <th align="right">{{ number_format($total_intrstrph ,0) }}</th>
            <th align="right">{{ number_format($total_adjrph        ,0) }}</th>
{{--            <th align="right">{{ number_format($total_koreksirph     ,0) }}</th>--}}
            <th align="right">{{ number_format(0     ,0) }}</th>
            <th align="right">{{ number_format($total_akhirrph     ,0) }}</th>
        </tr>
        </tbody>
    </table>

@endsection

