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
        $total_dpp     = 0;
        $total_3persen = 0;
        $total_ppn     = 0;
        $total_nilai   = 0;
    @endphp
@section('content')

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th rowspan="2" align="left">No.</th>
            <th colspan="2" align="center">----NRB Proforma----</th>
            <th rowspan="2" align="left">TOKO IDM</th>
            <th colspan="2" align="center">----Dok Retur----</th>
            <th rowspan="2" align="right">DPP</th>
            <th rowspan="2" align="right">3%</th>
            <th rowspan="2" align="right">PPN</th>
            <th rowspan="2" align="right">Nilai</th>
        </tr>
        <tr style="text-align: center;">
            <th align="left">No.</th>
            <th align="left">Tgl</th>
            <th align="left">No.</th>
            <th align="left">Tgl</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            <tr>
                <td align="left">{{ $data[$i]->nomor }}</td>
                <td align="left">{{ $data[$i]->bth_nonrb }}</td>
                <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->bth_tglnrb,0,10)))  }}</td>
                <td align="left">{{ $data[$i]->tko_kodeomi}}</td>
                <td align="left">{{ $data[$i]->bth_nodoc    }}</td>
                <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->bth_tgldoc,0,10)))   }}</td>
                <td align="right">{{ number_format($data[$i]->dpp      ,2)   }}</td>
                <td align="right">{{ number_format($data[$i]->tigapersen,2)  }}</td>
                <td align="right">{{ number_format($data[$i]->btd_ppn  ,2)   }}</td>
                <td align="right">{{ number_format($data[$i]->nilai    ,2)}}</td>
            </tr>
            @php
                $total_nilai      += $data[$i]->nilai   ;
                $total_dpp        += $data[$i]->dpp;
                $total_3persen    += $data[$i]->tigapersen;
                $total_ppn        += $data[$i]->btd_ppn;
                $total_nilai      += $data[$i]->nilai;

                $tempnrb = $data[$i]->bth_nonrb;
            @endphp


        @endfor
        </tbody>
        <tfoot style="border-top:solid 1px ">
        <tr>
            <td align="right" colspan="6"><strong>TOTAL NILAI BA</strong></td>
            <td align="right">{{ number_format($total_dpp    ,2) }}</td>
            <td align="right">{{ number_format($total_3persen,2) }}</td>
            <td align="right">{{ number_format($total_ppn    ,2) }}</td>
            <td align="right">{{ number_format($total_nilai  ,2) }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
