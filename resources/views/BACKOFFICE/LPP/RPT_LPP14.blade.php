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

        $st_sawalrph   =0;
        $st_baikrph    =0;
        $st_rusakrph   =0;
        $st_supplierrph=0;
        $st_hilangrph  =0;
        $st_lbaikrph   =0;
        $st_lrusakrph  =0;
        $st_selso_rph  =0;
        $st_adjrph     =0;
        $st_koreksi    =0;
        $st_akhirrph   =0;


        $total_sawalrph   =0;
        $total_baikrph    =0;
        $total_rusakrph   =0;
        $total_supplierrph=0;
        $total_hilangrph  =0;
        $total_lbaikrph   =0;
        $total_lrusakrph  =0;
        $total_selso_rph  =0;
        $total_adjrph     =0;
        $total_koreksi    =0;
        $total_akhirrph   =0;

    @endphp
@section('content')

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th colspan="2" style="text-align: right"></th>
            <th colspan="2" style="text-align: center">----PENERIMAAN----</th>
            <th colspan="5" style="text-align: center">----PENGELUARAN----</th>
        </tr>
        <tr style="text-align: center;">
            <th></th>
            <th class="right" width="10%">SALDO AWAL</th>
            <th class="right">BAIK</th>
            <th class="right">RUSAK</th>
            <th class="right">KE SUPPLIER</th>
            <th class="right">HILANG</th>
            <th class="right">LAIN BAIK</th>
            <th class="right">LAIN RUSAK</th>
            <th class="right">PENYESUAIAN</th>
            <th class="right">SALDO AKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdep != $data[$i]->lrt_kodedepartemen)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left"><b>{{$data[$i]->lrt_kodedepartemen}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
                <tr>
                    <td class="left"><b>KATEGORI :</b></td>
                    <td class="left"><b>{{$data[$i]->lrt_kategoribrg}} - {{$data[$i]->kat_namakategori}}</b>
                    </td>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $data[$i]->lrt_prdcd }}</td>
                <td colspan="3" align="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td align="left">{{ $data[$i]->kemasan }}</td>
            </tr>
            <tr>
                <td align="left">UNIT :</td>
                <td align="right">{{ number_format($data[$i]->sawalqty  ,0)}} </td>
                <td align="right">{{ number_format($data[$i]->baikqty      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->rusakqty     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->supplierqty     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->hilangqty   ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lbaikqty    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lrusakqty    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->adjqty      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->akhirqty    ,0) }}</td>
            </tr>
            <tr>
                <td align="left">Rp :</td>
                <td align="right">{{ number_format($data[$i]->sawalrph   ,0)}} </td>
                <td align="right">{{ number_format($data[$i]->baikrph    ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->rusakrph   ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->supplierrph,0)}}</td>
                <td align="right">{{ number_format($data[$i]->hilangrph  ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->lbaikrph   ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->lrusakrph  ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->adjrph      ,0) }}</td>
                <td align="right">{{ number_format($data[$i]->akhirrph    ,0) }}</td>
            </tr>
            @php
                $count_prdcd++;
                    $total_prdcd++;

                $st_sawalrph    += $data[$i]->sawalrph;
                $st_baikrph     += $data[$i]->baikrph;
                $st_rusakrph    += $data[$i]->rusakrph;
                $st_supplierrph += $data[$i]->supplierrph;
                $st_hilangrph   += $data[$i]->hilangrph;
                $st_lbaikrph    += $data[$i]->lbaikrph;
                $st_lrusakrph   += $data[$i]->lrusakrph;
                $st_adjrph      += $data[$i]->adjrph;
                $st_akhirrph    += $data[$i]->akhirrph;

                $total_sawalrph    += $data[$i]->sawalrph;
                $total_baikrph     += $data[$i]->baikrph;
                $total_rusakrph    += $data[$i]->rusakrph;
                $total_supplierrph += $data[$i]->supplierrph;
                $total_hilangrph   += $data[$i]->hilangrph;
                $total_lbaikrph    += $data[$i]->lbaikrph;
                $total_lrusakrph   += $data[$i]->lrusakrph;
                $total_adjrph      += $data[$i]->adjrph;
                $total_akhirrph    += $data[$i]->akhirrph;

                $tempdep = $data[$i]->lrt_kodedepartemen;
            @endphp
            @if( isset($data[$i+1]->lrt_kodedepartemen) && $tempdep != $data[$i+1]->lrt_kodedepartemen || !(isset($data[$i+1]->lrt_kodedepartemen)) )
                <tr>
                    <td class="right">SUBTOTAL</td>
                    <td class="right">{{ $count_prdcd }}</td>
                    <td class="left">ITEM</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td align="left">Rp :</td>
                    <td align="right">{{ number_format($st_sawalrph   ,0)}} </td>
                    <td align="right">{{ number_format($st_baikrph    ,0)}}</td>
                    <td align="right">{{ number_format($st_rusakrph   ,0)}}</td>
                    <td align="right">{{ number_format($st_supplierrph,0)}}</td>
                    <td align="right">{{ number_format($st_hilangrph  ,0) }}</td>
                    <td align="right">{{ number_format($st_lbaikrph   ,0)}}</td>
                    <td align="right">{{ number_format($st_lrusakrph  ,0)}}</td>
                    <td align="right">{{ number_format($st_adjrph      ,0) }}</td>
                    <td align="right">{{ number_format($st_akhirrph    ,0) }}</td>
                </tr>
                @php
                    $st_sawalqty =0;
                    $st_sawalrph   =0;
                    $st_baikrph     =0;
                    $st_rusakrph    =0;
                    $st_supplierrph =0;
                    $st_hilangrph   =0;
                    $st_lbaikrph    =0;
                    $st_lrusakrph   =0;
                    $st_adjrph      =0;
                    $st_akhirrph   =0;
                @endphp
            @endif
        @endfor
        <tr>
            <td class="right">TOTAL</td>
            <td class="right">{{ $total_prdcd }}</td>
            <td class="left"><strong>ITEM</strong></td>
        </tr>
        <tr>
            <td class="left" colspan="1"><strong>Rp :</strong></td>
            <td align="right">{{ number_format($total_sawalrph         ,0)}}</td>
            <td align="right">{{ number_format($total_baikrph         ,0)}}</td>
            <td align="right">{{ number_format($total_rusakrph        ,0)}}</td>
            <td align="right">{{ number_format($total_supplierrph,0) }}</td>
            <td align="right">{{ number_format($total_hilangrph      ,0)}}</td>
            <td align="right">{{ number_format($total_lbaikrph       ,0)}}</td>
            <td align="right">{{ number_format($total_lrusakrph  ,0) }}</td>
            <td align="right">{{ number_format($total_adjrph     ,0) }}</td>
            <td align="right">{{ number_format($total_akhirrph   ,0) }}</td>
        </tr>
        </tbody>
    </table>

@endsection

