@extends('html-template')

@section('table_font_size','7 px')
@section('paper_height')
    595pt
@endsection

@section('paper_width')
    842pt
@endsection
@section('page_title')
    KERJA KERJA PKM
@endsection

@section('title')
    KERJA KERJA PKM
@endsection

@section('subtitle')
    {{$ket_jenispkm}}
@endsection

@section('header_left')
    Ranking by : PLU<br><br>
    {{$ket_monitoring}}
@endsection

@section('content')

        @php
            $tempPeriode='';
        @endphp
        @for($i=0;$i<sizeof($data);$i++)
            @if($tempPeriode!=$data[$i]->cp_periode)
                <table class="table">
                    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                    <tr style="border-bottom: 1px solid black;">
                        <th colspan="23" class="center">Periode: {{$data[$i]->cp_periode}}</th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="tengah right">NO.</th>
                        <th rowspan="2" class="tengah right padding-right">PLU</th>
                        <th rowspan="2" class="tengah left">DESKRIPSI</th>
                        <th rowspan="2" class="tengah left">KEMASAN</th>
                        <th rowspan="2" class="tengah left">TAG</th>
                        <th rowspan="2" class="tengah right">MIN<br>DISPLAY</th>
                        <th colspan="3" class="tengah center">--------SALES--------</th>
                        <th rowspan="2" class="tengah right">AVG SALES<br>PER DAY</th>
                        <th rowspan="2" class="tengah right">LTIME</th>
                        <th rowspan="2" class="tengah right">KOEF.</th>
                        <th rowspan="2" class="tengah right">HS</th>
                        <th rowspan="2" class="tengah right">PKM</th>
                        <th rowspan="2" class="tengah right">MPKM</th>
                        <th rowspan="2" class="tengah right">PKMT</th>
                        <th rowspan="2" class="tengah right">N+</th>
                        <th rowspan="2" class="tengah right">PKM<br>EXIST</th>
                        <th rowspan="2" class="tengah right">DSI</th>
                        <th rowspan="2" class="tengah right">MINOR</th>
                        <th rowspan="2" class="tengah right">TOP</th>
                        <th rowspan="2" class="tengah right">ITEM<br>OMI</th>
                        <th rowspan="2" class="tengah right">%SL</th>
                    </tr>
                    <tr>
                        <th class="right">{{$data[$i]->cp_per3}}</th>
                        <th class="right">{{$data[$i]->cp_per2}}</th>
                        <th class="right">{{$data[$i]->cp_per1}}</th>
                    </tr>
                    </thead>
                    <tbody>
                @php
                    $tempPeriode = $data[$i]->cp_periode;
                @endphp
            @endif
            <tr>
                <td class="right">{{ $i+1 }}</td>
                <td class="right padding-right">{{ $data[$i]->ftkplu }}
                <td class="left">{{ $data[$i]->prd_deskripsipanjang }}
                <td class="left">{{ $data[$i]->prd_satuan }}
                <td class="left">{{ $data[$i]->prd_kodetag }}
                <td class="right">{{ $data[$i]->ftmind }}
                <td class="right">{{ $data[$i]->ftnl03 }}
                <td class="right">{{ $data[$i]->ftnl02 }}
                <td class="right">{{ $data[$i]->ftnl01 }}
                <td class="right">{{ $data[$i]->ftavgs }}
                <td class="right">{{ $data[$i]->ftltim }}
                <td class="right">{{ $data[$i]->koef }}
                <td class="right">{{ $data[$i]->hs }}
                <td class="right">{{ $data[$i]->ftpkmm }}
                <td class="right">{{ $data[$i]->ftmpkm }}
                <td class="right">{{ $data[$i]->ftpkmt }}
                <td class="right">{{ $data[$i]->nplus }}
                <td class="right">{{ $data[$i]->pkmexist }}
                <td class="right">{{ $data[$i]->dsi }}
                <td class="right">{{ $data[$i]->mord }}
                <td class="right">{{ $data[$i]->top }}
                <td class="right">{{ $data[$i]->omi }}
                <td class="right">{{ $data[$i]->sl }}
            </tr>
                @if(!isset($data[$i+1]->cp_periode) || ( isset($data[$i+1]->cp_periode) && $tempPeriode != $data[$i+1]->cp_periode ))
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
                <br>
                @endif
        @endfor

@endsection
