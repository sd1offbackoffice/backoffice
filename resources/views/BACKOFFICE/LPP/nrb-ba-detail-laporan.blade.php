@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    {{ $title }}
@endsection

@section('title')
    {{ $title }}
@endsection

@section('subtitle')
    TANGGAL : {{strtoupper(DateTime::createFromFormat('d/m/Y', $tgl1)->format('d-M-Y')) }} s/d {{strtoupper(DateTime::createFromFormat('d/m/Y', $tgl1)->format('d-M-Y'))}}
@endsection
@section('content')
    @php
        $tempnrb = '';

        $st_nilai      = 0;

        $total_nilai      = 0;
        $no = 1;
    @endphp
    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th rowspan="2" align="left">No.</th>
            <th colspan="2" align="center">----NRB Proforma----</th>
            <th rowspan="2" align="left">TOKO IDM</th>
            <th colspan="2" align="center">----Dok Retur----</th>
            <th colspan="2" align="center">----Barang Dagangan----</th>
            <th rowspan="2" align="right">Nilai<br>Avg Cost</th>
        </tr>
        <tr style="text-align: center;">
            <th align="left">No.</th>
            <th align="left">Tgl</th>
            <th align="left">No.</th>
            <th align="left">Tgl</th>
            <th align="left">PLU</th>
            <th align="left">Nama</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempnrb!=$data[$i]->bth_nonrb)
                <tr>
                    <td align="left">{{ $no }}</td>
                    <td align="left">{{ $data[$i]->bth_nonrb }}</td>
                    <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->bth_tglnrb,0,10)))  }}</td>
                    <td align="left">{{ $data[$i]->tko_kodeomi}}</td>
                    <td align="left">{{ $data[$i]->bth_nodoc    }}</td>
                    <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->bth_tgldoc,0,10)))   }}</td>
                    <td align="left">{{ $data[$i]->btd_prdcd    }}</td>
                    <td align="left">{{ $data[$i]->prd_deskripsipanjang}}</td>
                    <td align="right">{{ number_format($data[$i]->nilai    ,2)}}</td>
                </tr>
                @php
                    $tempnrb = $data[$i]->bth_nonrb;
                    $no++;
                @endphp
            @else
                <tr>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="left"></td>
                    <td align="left">{{ $data[$i]->btd_prdcd    }}</td>
                    <td align="left">{{ $data[$i]->prd_deskripsipanjang}}</td>
                    <td align="right">{{ number_format($data[$i]->nilai    ,2)}}</td>
                </tr>
            @endif
            @php
                $st_nilai      += $data[$i]->nilai   ;
                $total_nilai   += $data[$i]->nilai   ;

                $tempnrb = $data[$i]->bth_nonrb;
            @endphp

            @if((isset($data[$i+1]->bth_nonrb) && $tempnrb != $data[$i+1]->bth_nonrb) || !(isset($data[$i+1]->bth_nonrb)) )
                <tr>
                    <th colspan="8" align="right">SUB TOTAL NILAI BA</th>
                    <th align="right">{{ number_format($st_nilai     ,2) }}</th>
                </tr>
                @php
                        $st_nilai  = 0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot style="border-top:solid 1px ">
        <tr>
            <th align="right" colspan="8"><strong>TOTAL NILAI BA</strong></th>
            <th align="right">{{ number_format($total_nilai     ,2) }}</th>
        </tr>
        </tfoot>
    </table>

@endsection
