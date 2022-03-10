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
    @php
        $tempdiv = '';
        $tempdep = '';

        $st_div_qty_soic  = 0;
        $st_div_qty_so    = 0;
        $st_div_qty_total = 0;
        $st_dep_qty_soic  = 0;
        $st_dep_qty_so    = 0;
        $st_dep_qty_total = 0;
        $total_qty_soic   = 0;
        $total_qty_so     = 0;
        $total_qty_total  = 0;
        $st_div_rph_soic  = 0;
        $st_div_rph_so    = 0;
        $st_div_rph_total = 0;
        $st_dep_rph_soic  = 0;
        $st_dep_rph_so    = 0;
        $st_dep_rph_total = 0;
        $total_rph_soic   = 0;
        $total_rph_so     = 0;
        $total_rph_total = 0;

        $no=1;
    @endphp
@section('content')

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th class="left tengah" width="2%" rowspan="2">No.</th>
            <th style="text-align: center">----------------KATEGORI----------------</th>
            <th colspan="3">--------------------------------ADJUSTMENT--------------------------------</th>
        </tr>
        <tr style="text-align: center;">
            <th class="left" width="10%">KODE - NAMA</th>
            <th class="right">SO IC</th>
            <th class="right">SONAS</th>
            <th class="right">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->prd_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI :</b></td>
                    <td class="left"><b>{{$data[$i]->prd_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->prd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN :</b></td>
                    <td class="left"><b>{{$data[$i]->prd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $no }}</td>
                <td align="left">{{ $data[$i]->prd_kodekategoribarang }}-{{ $data[$i]->kat_namakategori}}</td>
                <td align="right">{{ number_format($data[$i]->qty_soic      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->qty_so     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->qty_total     ,0)}}</td>
            </tr>
            <tr>
                <td align="left"></td>
                <td align="left"></td>
                <td align="right">{{ number_format($data[$i]->rph_soic      ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->rph_so     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->rph_total     ,0)}}</td>
            </tr>
            @php
                $st_div_qty_soic    += $data[$i]->qty_soic    ;
                $st_div_qty_so      += $data[$i]->qty_so      ;
                $st_div_qty_total   += $data[$i]->qty_total   ;

                $st_dep_qty_soic    += $data[$i]->qty_soic    ;
                $st_dep_qty_so      += $data[$i]->qty_so      ;
                $st_dep_qty_total   += $data[$i]->qty_total   ;

                $total_qty_soic    += $data[$i]->qty_soic    ;
                $total_qty_so      += $data[$i]->qty_so      ;
                $total_qty_total   += $data[$i]->qty_total   ;

                $st_div_rph_soic    += $data[$i]->rph_soic    ;
                $st_div_rph_so      += $data[$i]->rph_so      ;
                $st_div_rph_total   += $data[$i]->rph_total   ;

                $st_dep_rph_soic    += $data[$i]->rph_soic    ;
                $st_dep_rph_so      += $data[$i]->rph_so      ;
                $st_dep_rph_total   += $data[$i]->rph_total   ;

                $total_rph_soic    += $data[$i]->rph_soic    ;
                $total_rph_so      += $data[$i]->rph_so      ;
                $total_rph_total   += $data[$i]->rph_total   ;

                $tempdiv = $data[$i]->prd_kodedivisi;
                $tempdep = $data[$i]->prd_kodedepartement;
                $no++;
            @endphp
            @if( isset($data[$i+1]->prd_kodedepartement) && $tempdep != $data[$i+1]->prd_kodedepartement || !(isset($data[$i+1]->prd_kodedepartement)) )
                <tr>
                    <td class="left" colspan="2">SUB TOTAL DEPARTEMEN</td>
                    <td align="right">{{ number_format($st_dep_qty_soic        ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_qty_so         ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_qty_total      ,0)}}</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td class="left"  colspan="2"></td>
                    <td align="right">{{ number_format($st_dep_rph_soic        ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_rph_so         ,0)}}</td>
                    <td align="right">{{ number_format($st_dep_rph_total      ,0)}}</td>
                </tr>
                @php
                   $st_dep_qty_soic  =0;
                   $st_dep_qty_so    =0;
                   $st_dep_qty_total =0;
                   $no=1;
                @endphp
            @endif
            @if((isset($data[$i+1]->prd_kodedivisi) && $tempdiv != $data[$i+1]->prd_kodedivisi) || !(isset($data[$i+1]->prd_kodedivisi)) )
                <tr>
                    <td class="left">SUB TOTAL DIVISI</td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_div_qty_soic            ,0)}}</td>
                    <td align="right">{{ number_format($st_div_qty_so             ,0)}}</td>
                    <td align="right">{{ number_format($st_div_qty_total          ,0)}}</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td class="left"></td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_div_rph_soic            ,0)}}</td>
                    <td align="right">{{ number_format($st_div_rph_so             ,0)}}</td>
                    <td align="right">{{ number_format($st_div_rph_total          ,0)}}</td>
                </tr>
                @php
                    $st_div_qty_soic = 0;
                    $st_div_qty_so   = 0;
                    $st_div_qty_total= 0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot style="border-top: 1px solid black;">
        <tr>
            <td class="left" colspan="1"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_qty_soic  ,0)}}</td>
            <td align="right">{{ number_format($total_qty_so   ,0)}}</td>
            <td align="right">{{ number_format($total_qty_total,0)}}</td>
        </tr>
        <tr>
            <td class="left" colspan="1"></td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_rph_soic  ,0)}}</td>
            <td align="right">{{ number_format($total_rph_so   ,0)}}</td>
            <td align="right">{{ number_format($total_rph_total,0)}}</td>
        </tr>
        </tfoot>
    </table>
@endsection

