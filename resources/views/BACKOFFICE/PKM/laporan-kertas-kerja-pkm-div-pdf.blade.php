@extends('html-template')

@section('table_font_size','7 px')
@section('paper_height')
    595pt
@endsection

@section('paper_width')
    842pt
@endsection
@section('page_title')
    KERTAS KERJA PKM
@endsection

@section('title')
    KERTAS KERJA PKM
@endsection

@section('subtitle')
    {{$ket_jenispkm}}
@endsection

@section('header_left')
    Ranking by : DIVISI<br><br>
    {{$ket_monitoring}}
@endsection

@section('content')

        @php
            $tempPeriode='';
            $tempDiv='';
            $tempDep='';
            $tempDat='';
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
            @if($tempDiv!=$data[$i]->ftkdiv || $tempDep!=$data[$i]->ftdept || $tempKat!=$data[$i]->ftkatb)
                <tr>
                    <th colspan="3" class="left">DIV : {{$data[$i]->ftkdiv}} - {{$data[$i]->div_namadivisi}}</th>
                    <th colspan="5" class="left">DEP : {{$data[$i]->ftdept}} - {{$data[$i]->dep_namadepartement}}</th>
                    <th colspan="5" class="left">KAT : {{$data[$i]->ftkatb}} - {{$data[$i]->kat_namakategori}}</th>
                </tr>
                @php
                    $tempDiv = $data[$i]->ftkdiv;
                    $tempDep = $data[$i]->ftdept;
                    $tempKat = $data[$i]->ftkatb;
                @endphp
            @endif
            <tr>
                <td class="right">{{ $i+1 }}</td>
                <td class="right padding-right">{{ $data[$i]->ftkplu }}</td>
                <td class="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td class="left">{{ $data[$i]->prd_satuan }}</td>
                <td class="left">{{ $data[$i]->prd_kodetag }}</td>
                <td class="right">{{ number_format($data[$i]->ftmind, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->ftnl03, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->ftnl02, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->ftnl01, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->ftavgs, 1, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->ftltim, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->koef, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->hs, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->ftpkmm, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->ftmpkm, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->ftpkmt, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->nplus, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->pkmexist, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->dsi, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->mord, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->top, 0, '.', ',') }}</td>
                <td class="right">{{ $data[$i]->omi }}</td>
                <td class="right">{{ number_format($data[$i]->sl, 0, '.', ',') }}</td>
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
