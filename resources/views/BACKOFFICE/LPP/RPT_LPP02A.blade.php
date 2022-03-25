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

    @php
        $tempdiv = '';
        $tempkat = '';

         $st_qty_soic    =0;
         $st_qty_so      =0;
         $st_qty_total   =0;
         $st_rph_soic    =0;
         $st_rph_so      =0;
         $st_rph_total   =0;
         $total_qty_soic =0;
         $total_qty_so   =0;
         $total_qty_total=0;
         $total_rph_soic =0;
         $total_rph_so   =0;
         $total_rph_total=0;
    @endphp
@section('content')
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th rowspan="2" class="left tengah" width="1%">No.</th>
            <th rowspan="2" class="left tengah">PLU</th>
            <th rowspan="2" class="left tengah" width="5%">DESKRIPSI - KEMASAN</th>
            <th colspan="5" style="text-align: center">- - - - - - - - - - - - - - - - - - - - - - - - ADJUSTMENT - - - - - - - - - - - - - - - - - - - - - - - - </th>
        </tr>
        <tr style="text-align: center;">
            <th class="left">TANGGAL</th>
            <th class="right">NILAI SO IC</th>
            <th class="right">TANGGAL</th>
            <th class="right">NILAI SONAS</th>
            <th class="right">NILAI TOTAL</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempkat != $data[$i]->prd_kodedepartement.$data[$i]->prd_kodekategoribarang)
                <tr>
                    <th class="left" colspan="3">
                        DEPARTEMEN - {{$data[$i]->prd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}
                    </th>
                    <th class="left" colspan="5">
                        KATEGORI {{$data[$i]->prd_kodekategoribarang}} - {{$data[$i]->kat_namakategori}}
                    </th>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $i+1 }}</td>
                <td align="left">{{ $data[$i]->rso_prdcd }}</td>
                <td align="left">{{ $data[$i]->prd_deskripsipanjang}}</td>
                <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->tgl_soic,0,10)))}}</td>
                <td align="right">{{ number_format($data[$i]->qty_soic      ,0)}}</td>
                <td align="right">{{ isset($data[$i]->tgl_so)?date('d/m/Y',strtotime(substr($data[$i]->tgl_so,0,10))):'-'}}</td>
                <td align="right">{{ number_format($data[$i]->qty_so     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->qty_total     ,0)}}</td>
            </tr>
            <tr>
                <td align="left"></td>
                <td align="left"></td>
                <td align="left"></td>
                <td align="left"></td>
                <td align="right">{{ number_format($data[$i]->rph_soic      ,0)}}</td>
                <td align="left"></td>
                <td align="right">{{ number_format($data[$i]->rph_so     ,0)}}</td>
                <td align="right">{{ number_format($data[$i]->rph_total     ,0)}}</td>
            </tr>
            @php
        $st_qty_soic    += $data[$i]->qty_soic    ;
        $st_qty_so      += $data[$i]->qty_so      ;
        $st_qty_total   += $data[$i]->qty_total   ;

        $st_rph_soic    += $data[$i]->rph_soic    ;
        $st_rph_so      += $data[$i]->rph_so      ;
        $st_rph_total   += $data[$i]->rph_total   ;

        $total_qty_soic    += $data[$i]->qty_soic    ;
        $total_qty_so      += $data[$i]->qty_so      ;
        $total_qty_total   += $data[$i]->qty_total   ;

        $total_rph_soic    += $data[$i]->rph_soic    ;
        $total_rph_so      += $data[$i]->rph_so      ;
        $total_rph_total   += $data[$i]->rph_total   ;

                $tempkat = $data[$i]->prd_kodedepartement.$data[$i]->prd_kodekategoribarang;
            @endphp
            @if( isset($data[$i+1]->prd_kodekategoribarang) && $tempkat != $data[$i+1]->prd_kodedepartement.$data[$i+1]->prd_kodekategoribarang || !(isset($data[$i+1]->prd_kodekategoribarang)) )
                <tr style="border-top: 1px solid black;">
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="right">SUB TOTAL :</td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_qty_soic        ,0)}}</td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_qty_so         ,0)}}</td>
                    <td align="right">{{ number_format($st_qty_total      ,0)}}</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_rph_soic        ,0)}}</td>
                    <td class="left"></td>
                    <td align="right">{{ number_format($st_rph_so         ,0)}}</td>
                    <td align="right">{{ number_format($st_rph_total      ,0)}}</td>
                </tr>
                @php
                   $st_qty_soic  =0;
                   $st_qty_so    =0;
                   $st_qty_total =0;
                   $st_rph_soic  =0;
                   $st_rph_so    =0;
                   $st_rph_total =0;
                @endphp
            @endif

        @endfor
        <tr>
            <td class="left"></td>
            <td class="left"></td>
            <td class="right">T O T A L :</td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_qty_soic        ,0)}}</td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_qty_so         ,0)}}</td>
            <td align="right">{{ number_format($total_qty_total      ,0)}}</td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="left"></td>
            <td class="left"></td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_rph_soic        ,0)}}</td>
            <td class="left"></td>
            <td align="right">{{ number_format($total_rph_so         ,0)}}</td>
            <td align="right">{{ number_format($total_rph_total      ,0)}}</td>
        </tr>
        </tbody>
    </table>
@endsection

