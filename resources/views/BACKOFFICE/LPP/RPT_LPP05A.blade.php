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
        $tempdep = '';

        $count_prdcd = 0;
        $total_prdcd = 0;

        $st_sawalqty      = 0;
        $st_akhirqty      = 0;
        $st_servtok      = 0;


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
        $st_selsorph     = 0;
        $st_lainoutrph    = 0;
        $st_intrstrph     = 0;
        $st_adjrph        = 0;
        $st_koreksirph    = 0;
        $st_akhirrph      = 0;
        $st_servsup     = 0;


        $total_akhirqty      = 0;
        $total_servtok     = 0;

        $total_sawalqty      = 0;
        $total_sawalrph      = 0;
        $total_belirph       = 0;
        $total_bonusrph      = 0;
        $total_trmcbrph      = 0;
        $total_returrph     = 0;
        $total_selsorph     = 0;
        $total_repackrph     = 0;
        $total_laininrph     = 0;
        $total_salesrph      = 0;
        $total_kirimrph      = 0;
        $total_repackrph    = 0;
        $total_hilangrph     = 0;
        $total_selisih_so = 0;
        $total_lainoutrph    = 0;
        $total_intrstrph     = 0;
        $total_adjrph        = 0;
        $total_koreksirph    = 0;
        $total_akhirrph      = 0;
        $total_servsup      = 0;
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
            <th class="right">SO</th>
            <th class="right">LAIN-LAIN</th>
            <th class="right">INTRANSIT</th>
            <th class="right">PENYESUAIAN</th>
            <th class="right">KOREKSI</th>
            <th class="right">SALDO<br>AKHIR</th>
            <th class="right">SERVICE<br>TOKO<br>/ SUPPLIER</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdep != $data[$i]->lpp_kodedepartemen.$data[$i]->lpp_kategoribrg)
                <th class="left" colspan="7">
                    DEPARTEMEN : {{$data[$i]->lpp_kodedepartemen}}
                    - {{$data[$i]->dep_namadepartement}}
                </th>
                <th class="left" colspan="12">
                    KATEGORI : {{$data[$i]->lpp_kategoribrg}} - {{$data[$i]->kat_namakategori}}
                </th>
            @endif
            <tr>
                <td align="left">{{ $data[$i]->lpp_prdcd }}</td>
                <td colspan="3" align="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td align="left">{{ $data[$i]->kemasan }}</td>
            </tr>
            <tr>
                <td align="left">UNIT :</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtybegbal       ,0)}} </td>
                <td align="right">{{ number_format($data[$i]->lpp_qtybeli         ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtybonus        ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtytrmcb        ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtyretursales   ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtyrepack       ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtylainin       ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtysales        ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtykirim        ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtyprepacking   ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtyhilang       ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qty_selisih_so  ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtylainout      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtyintransit    ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtyadj          ,0) }}</td>
                <td align="right">{{ 0 }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_qtyakhir        ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_tokoservq       ,0) }}</td>
            </tr>
            <tr>
                <td align="left">Rp :</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphbegbal       ,0)}} </td>
                <td align="right">{{ number_format($data[$i]->lpp_rphbeli         ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphbonus        ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphtrmcb        ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphretursales   ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphrepack       ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphlainin       ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphsales        ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphkirim        ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphprepacking   ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphhilang       ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rph_selisih_so  ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphlainout      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphintransit    ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphadj          ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->koreksi             ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_rphakhir        ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lpp_supplierservq   ,0) }}</td>
            </tr>
            @php
                $count_prdcd++;
                $total_prdcd++;

                $st_akhirqty      += $data[$i]->lpp_qtyakhir  ;
                $st_servtok      += $data[$i]->lpp_tokoservq  ;

                $st_sawalqty      += $data[$i]->lpp_qtybegbal  ;
                $st_sawalrph      += $data[$i]->lpp_rphbegbal    ;
                $st_belirph       += $data[$i]->lpp_rphbeli      ;
                $st_bonusrph      += $data[$i]->lpp_rphbonus     ;
                $st_trmcbrph      += $data[$i]->lpp_rphtrmcb     ;
                $st_returrph      += $data[$i]->lpp_rphretursales;
                $st_rafakrph      += $data[$i]->lpp_rphrepack    ;
                $st_laininrph     += $data[$i]->lpp_rphlainin    ;
                $st_salesrph      += $data[$i]->lpp_rphsales     ;
                $st_kirimrph      += $data[$i]->lpp_rphkirim     ;
                $st_repackrph     += $data[$i]->lpp_rphprepacking;
                $st_hilangrph     += $data[$i]->lpp_rphhilang    ;
                $st_selsorph     += $data[$i]->lpp_rph_selisih_so;
                $st_lainoutrph    += $data[$i]->lpp_rphlainout   ;
                $st_intrstrph     += $data[$i]->lpp_rphintransit ;
                $st_adjrph        += $data[$i]->lpp_rphadj       ;
                $st_koreksirph    += $data[$i]->koreksi          ;
                $st_akhirrph      += $data[$i]->lpp_rphakhir     ;
                $st_servsup      += $data[$i]->lpp_supplierservq;

                $total_akhirqty    += $data[$i]->lpp_qtyakhir;
                $total_servtok     += $data[$i]->lpp_tokoservq;

                $total_sawalqty      += $data[$i]->lpp_qtybegbal  ;
                $total_sawalrph      += $data[$i]->lpp_rphbegbal;
                $total_belirph       += $data[$i]->lpp_rphbeli;
                $total_bonusrph      += $data[$i]->lpp_rphbonus;
                $total_trmcbrph      += $data[$i]->lpp_rphtrmcb;
                $total_returrph      += $data[$i]->lpp_rphretursales ;
                $total_selsorph       += $data[$i]->lpp_rph_selisih_so;
                $total_repackrph     += $data[$i]->lpp_rphrepack;
                $total_laininrph     += $data[$i]->lpp_rphlainin;
                $total_salesrph      += $data[$i]->lpp_rphsales;
                $total_kirimrph      += $data[$i]->lpp_rphkirim;
                $total_hilangrph     += $data[$i]->lpp_rphhilang;
                $total_selisih_so    += $data[$i]->lpp_rph_selisih_so;
                $total_lainoutrph    += $data[$i]->lpp_rphlainout;
                $total_intrstrph     += $data[$i]->lpp_rphintransit;
                $total_adjrph        += $data[$i]->lpp_rphadj;
                $total_koreksirph    += $data[$i]->koreksi;
                $total_akhirrph      += $data[$i]->lpp_rphakhir;
                $total_servsup     += $data[$i]->lpp_supplierservq;

                $tempdep = $data[$i]->lpp_kodedepartemen.$data[$i]->lpp_kategoribrg;
            @endphp
            @if( isset($data[$i+1]->lpp_kodedepartemen) && $tempdep != $data[$i+1]->lpp_kodedepartemen.$data[$i+1]->lpp_kategoribrg || !(isset($data[$i+1]->lpp_kodedepartemen)) )
                <tr style="border-top: 1px solid black">
                    <th class="left">TOTAL: </th>
                    <th class="right">{{ number_format($count_prdcd,0) }} ITEM</th>
                </tr>
                <tr>
                    <th class="left">UNIT :</th>
                    <th class="right" >{{ number_format($st_sawalqty,0) }}</th>
                    <th class="right" colspan="15"></th>
                    <th align="right">{{ number_format($st_servsup    ,0) }}</th>
                </tr>
                <tr sthle="border-bottom: 1px solid black;">
                    <th class="left">Rp.</th>
                    <th align="right">{{ number_format($st_sawalrph            ,0)}}</th>
                    <th align="right">{{ number_format($st_belirph            ,0)}}</th>
                    <th align="right">{{ number_format($st_bonusrph           ,0)}}</th>
                    <th align="right">{{ number_format($st_trmcbrph  ,0) }}</th>
                    <th align="right">{{ number_format($st_returrph          ,0)}}</th>
                    <th align="right">{{ number_format($st_repackrph     ,0) }}</th>
                    <th align="right">{{ number_format($st_laininrph     ,0) }}</th>
                    <th align="right">{{ number_format($st_salesrph     ,0) }}</th>
                    <th align="right">{{ number_format($st_kirimrph      ,0) }}</th>
                    <th align="right">{{ number_format($st_repackrph    ,0) }}</th>
                    <th align="right">{{ number_format($st_hilangrph       ,0) }}</th>
                    <th align="right">{{ number_format($st_selsorph        ,0) }}</th>
                    <th align="right">{{ number_format($st_lainoutrph    ,0) }}</th>
                    <th align="right">{{ number_format($st_intrstrph     ,0) }}</th>
                    <th align="right">{{ number_format($st_adjrph       ,0) }}</th>
                    <th align="right">{{ number_format($st_koreksirph    ,0) }}</th>
                    <th align="right">{{ number_format($st_akhirrph    ,0) }}</th>
                    <th align="right">{{ number_format($st_servsup    ,0) }}</th>
                </tr>
                @php
                    $st_akhirqty     =0;
                    $st_servtok      =0;
                    $st_sawalqty     =0;
                    $st_sawalrph     =0;
                    $st_belirph      =0;
                    $st_bonusrph     =0;
                    $st_trmcbrph     =0;
                    $st_returrph     =0;
                    $st_rafakrph     =0;
                    $st_laininrph    =0;
                    $st_salesrph     =0;
                    $st_kirimrph     =0;
                    $st_repackrph    =0;
                    $st_hilangrph    =0;
                    $st_selsorph     =0;
                    $st_lainoutrph   =0;
                    $st_intrstrph    =0;
                    $st_adjrph       =0;
                    $st_koreksirph   =0;
                    $st_akhirrph     =0;
                    $st_servsup   =0;
                    $count_prdcd      = 0;

                @endphp
            @endif
        @endfor

        <tr style="border-top: 1px solid black">
            <th class="left">TOTAL: </th>
            <th class="right">{{ number_format($total_prdcd,0) }} ITEM</th>
        </tr>
        <tr>
            <th class="left"><strong>UNIT :</strong></th>
            <th class="right" >{{ number_format($total_sawalqty,0) }}</th>
            <th class="right" colspan="15"></th>
            <th align="right">{{ number_format($total_akhirqty    ,0) }}</th>
            <th align="right"></th>
        </tr>
        <tr>
            <th class="left">Rp.</th>
            <th align="right">{{ number_format($total_sawalrph            ,0)}}</th>
            <th align="right">{{ number_format($total_belirph            ,0)}}</th>
            <th align="right">{{ number_format($total_bonusrph           ,0)}}</th>
            <th align="right">{{ number_format($total_trmcbrph  ,0) }}</th>
            <th align="right">{{ number_format($total_returrph          ,0)}}</th>
            <th align="right">{{ number_format($total_repackrph     ,0) }}</th>
            <th align="right">{{ number_format($total_laininrph     ,0) }}</th>
            <th align="right">{{ number_format($total_salesrph     ,0) }}</th>
            <th align="right">{{ number_format($total_kirimrph      ,0) }}</th>
            <th align="right">{{ number_format($total_repackrph    ,0) }}</th>
            <th align="right">{{ number_format($total_hilangrph ,0) }}</th>
            <th align="right">{{ number_format($total_selsorph ,0) }}</th>
            <th align="right">{{ number_format($total_lainoutrph    ,0) }}</th>
            <th align="right">{{ number_format($total_intrstrph     ,0) }}</th>
            <th align="right">{{ number_format($total_adjrph       ,0) }}</th>
            <th align="right">{{ number_format($total_koreksirph    ,0) }}</th>
            <th align="right">{{ number_format($total_akhirrph    ,0) }}</th>
            <th align="right">{{ number_format($total_servsup    ,0) }}</th>
        </tr>
        </tbody>

    </table>

@endsection
