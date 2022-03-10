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
        $tempsup = '';
        $tempsup = '';

        $count_prdcd = 0;
        $total_prdcd = 0;

        $st_sawalrph      =0;
        $st_belirph       =0;
        $st_bonusrph      =0;
        $st_trmcbrph      =0;
        $st_retursalesrph =0;
        $st_rafakrph      =0;
        $st_repackrph     =0;
        $st_laininrph     =0;
        $st_salesrph      =0;
        $st_kirimrph      =0;
        $st_prepackrph    =0;
        $st_hilangrph     =0;
        $st_lainoutrph    =0;
        $st_intrstrph     =0;
        $st_sadj          =0;

        $total_sawalrph      =0;
        $total_belirph       =0;
        $total_bonusrph      =0;
        $total_trmcbrph      =0;
        $total_retursalesrph =0;
        $total_rafakrph      =0;
        $total_repackrph     =0;
        $total_laininrph     =0;
        $total_salesrph      =0;
        $total_kirimrph      =0;
        $total_prepackrph    =0;
        $total_hilangrph     =0;
        $total_lainoutrph    =0;
        $total_intrstrph     =0;
        $total_sadj          =0;
    @endphp
@section('content')

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="3" style="text-align: right"></th>
            <th colspan="2" style="text-align: center">----PEMBELIAN----</th>
            <th colspan="5" style="text-align: center">----PENERIMAAN----</th>
            <th colspan="5" style="text-align: center">----PENGELUARAN----</th>
        </tr>
        <tr style="text-align: center;">
            <th></th>
            <th class="right">SALDO AWAL</th>
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
            @if($tempsup != $data[$i]->sup_kodesupplier)
                <tr>
                    <td class="left"><b>SUPPLIER: </b></td>
                    <td class="left"><b>{{$data[$i]->sup_kodesupplier}}
                            - {{$data[$i]->sup_namasupplier}}</b></td>
                </tr>
            @endif
            <tr>
                <td class="left"><b>{{$data[$i]->lpp_prdcd}}</b></td>
                <td class="left"><b>{{$data[$i]->prd_deskripsipanjang}}</b>
                </td>
            </tr>
            <tr>
                <td align="left">UNIT : </td>
                <td align="right">{{ number_format($data[$i]->sawalqty      ,0)}} </td>
                <td align="right">{{ number_format($data[$i]->beliqty       ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->bonusqty      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->trmcbqty      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->retursalesqty ,0) }}</td>
                <td align="right"></td>
                <td align="right">{{ number_format($data[$i]->repackqty     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->laininqty     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->salesqty      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->kirimqty      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->prepackqty    ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->hilangqty     ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lainoutqty    ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->intrstqty     ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->adjqty        ,0) }}</td>
                <td align="right">0</td>
                <td align="right">{{ number_format($data[$i]->akhirqty      ,0) }}</td>
            </tr>
            <tr>
                <td align="left">Rp. </td>
                <td align="right">{{ number_format($data[$i]->sawalrph      ,0) }} </td>
                <td align="right">{{ number_format($data[$i]->belirph       ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->bonusrph      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->trmcbrph      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->retursalesrph ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->rafakrph      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->repackrph     ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->laininrph     ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->salesrph      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->kirimrph      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->prepackrph    ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->hilangrph     ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lainoutrph    ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->intrstrph     ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->sadj          ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->akhirrph      ,0) }}</td>
            </tr>
            @php
                $count_prdcd++;
                $total_prdcd++;

                $st_sawalrph      += $data[$i]->sawalrph     ;
                $st_belirph       += $data[$i]->belirph      ;
                $st_bonusrph      += $data[$i]->bonusrph     ;
                $st_trmcbrph      += $data[$i]->trmcbrph     ;
                $st_retursalesrph += $data[$i]->retursalesrph;
                $st_rafakrph      += $data[$i]->rafakrph     ;
                $st_repackrph     += $data[$i]->repackrph    ;
                $st_laininrph     += $data[$i]->laininrph    ;
                $st_salesrph      += $data[$i]->salesrph     ;
                $st_kirimrph      += $data[$i]->kirimrph     ;
                $st_prepackrph    += $data[$i]->prepackrph   ;
                $st_hilangrph     += $data[$i]->hilangrph    ;
                $st_lainoutrph    += $data[$i]->lainoutrph   ;
                $st_intrstrph     += $data[$i]->intrstrph    ;
                $st_sadj          += $data[$i]->sadj         ;

                $total_sawalrph      += $data[$i]->sawalrph     ;
                $total_belirph       += $data[$i]->belirph      ;
                $total_bonusrph      += $data[$i]->bonusrph     ;
                $total_trmcbrph      += $data[$i]->trmcbrph     ;
                $total_retursalesrph += $data[$i]->retursalesrph;
                $total_rafakrph      += $data[$i]->rafakrph     ;
                $total_repackrph     += $data[$i]->repackrph    ;
                $total_laininrph     += $data[$i]->laininrph    ;
                $total_salesrph      += $data[$i]->salesrph     ;
                $total_kirimrph      += $data[$i]->kirimrph     ;
                $total_prepackrph    += $data[$i]->prepackrph   ;
                $total_hilangrph     += $data[$i]->hilangrph    ;
                $total_lainoutrph    += $data[$i]->lainoutrph   ;
                $total_intrstrph     += $data[$i]->intrstrph    ;
                $total_sadj          += $data[$i]->sadj         ;

                $tempsup = $data[$i]->lpp_kodedivisi;
                $tempdep = $data[$i]->lpp_kodedepartemen;
            @endphp
            @if( isset($data[$i+1]->sup_kodesupplier) && $tempsup != $data[$i+1]->sup_kodesupplier || !(isset($data[$i+1]->sup_kodesupplier)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUBTOTAL PER SUPPLIER :</td>
                    <td align="right">{{ number_format($st_sawalrph     ,0)}}</td>
                    <td align="right">{{ number_format($st_belirph      ,0)}}</td>
                    <td align="right">{{ number_format($st_bonusrph     ,0)}}</td>
                    <td align="right">{{ number_format($st_trmcbrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_retursalesrph,0)}}</td>
                    <td align="right">{{ number_format($st_rafakrph     ,0)}}</td>
                    <td align="right">{{ number_format($st_repackrph    ,0) }}</td>
                    <td align="right">{{ number_format($st_laininrph    ,0) }}</td>
                    <td align="right">{{ number_format($st_salesrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_kirimrph     ,0) }}</td>
                    <td align="right">{{ number_format($st_prepackrph   ,0) }}</td>
                    <td align="right">{{ number_format($st_hilangrph    ,0) }}</td>
                    <td align="right">{{ number_format($st_lainoutrph   ,0) }}</td>
                    <td align="right">{{ number_format($st_intrstrph    ,0) }}</td>
                    <td align="right">{{ number_format($st_sadj         ,0) }}</td>
                </tr>
                @php
                    $st_sawalrph     = 0;
                    $st_belirph      = 0;
                    $st_bonusrph     = 0;
                    $st_trmcbrph     = 0;
                    $st_retursalesrph= 0;
                    $st_rafakrph     = 0;
                    $st_repackrph    = 0;
                    $st_laininrph    = 0;
                    $st_salesrph     = 0;
                    $st_kirimrph     = 0;
                    $st_prepackrph   = 0;
                    $st_hilangrph    = 0;
                    $st_lainoutrph   = 0;
                    $st_intrstrph    = 0;
                    $st_sadj         = 0;
                @endphp
            @endif

        @endfor

        </tbody>
        <tfoot style="border-bottom: 1px solid black;border-top: 1px solid black;">
        <tr>
            <td class="left" colspan="1"><strong>TOTAL :</strong></td>
            <td align="right">{{ number_format($total_sawalrph     ,0) }}</td>
            <td align="right">{{ number_format($total_belirph      ,0) }}</td>
            <td align="right">{{ number_format($total_bonusrph     ,0) }}</td>
            <td align="right">{{ number_format($total_trmcbrph     ,0) }}</td>
            <td align="right">{{ number_format($total_retursalesrph,0) }}</td>
            <td align="right">{{ number_format($total_rafakrph     ,0) }}</td>
            <td align="right">{{ number_format($total_repackrph    ,0) }}</td>
            <td align="right">{{ number_format($total_laininrph    ,0) }}</td>
            <td align="right">{{ number_format($total_salesrph     ,0) }}</td>
            <td align="right">{{ number_format($total_kirimrph     ,0) }}</td>
            <td align="right">{{ number_format($total_prepackrph   ,0) }}</td>
            <td align="right">{{ number_format($total_hilangrph    ,0) }}</td>
            <td align="right">{{ number_format($total_lainoutrph   ,0) }}</td>
            <td align="right">{{ number_format($total_intrstrph    ,0) }}</td>
            <td align="right">{{ number_format($total_sadj         ,0) }}</td>
        </tr>
        </tfoot>
    </table>

@endsection
