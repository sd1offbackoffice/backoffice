@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN REKAP PEROLEHAN REWARD POIN
@endsection

@section('title')
    LAPORAN REKAP PEROLEHAN REWARD POIN
@endsection

@section('subtitle')
    {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0,10)}}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right" width="5%">NO.</th>
            <th class="left">ID</th>
            <th class="left">MEMBER MERAH</th>
            <th class="left">POIN REWARD</th>
            <th class="right">POIN VALID</th>
            <th class="right">POIN INVALID</th>
        </tr>
        </thead>
        <tbody>
        @php
            //$total = 0;
            $total_valid=0;
            $total_invalid=0;
            $temptgl = '';
            $temp='';
            $tempNama = '';
            $number = 0;
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<count($data);$i++)


                @if($tempNama != $data[$i]->kodemember )
                    @php
                        $number++
                    @endphp
                    <tr>
                        <td class="right padding-right">{{ $number }}</td>
                        <td class="left">{{ $data[$i]->kodemember }}</td>
                        <td class="left">{{ $data[$i]->namamember }}</td>
                        <td class="left"> {{ $data[$i]->js }}</td>
                        <td class="right">{{ number_format($data[$i]->tot_valid, 0,".",",") }}</td>
                        <td class="right">{{ isset($data[$i]->tot_notvalid) ?  number_format($data[$i]->tot_notvalid, 0,".",",") : 0}}</td>
                    </tr>
                @else
                    <tr>
                        <td class="right padding-right"></td>
                        <td class="left"></td>
                        <td class="left"></td>
                        <td class="left"> {{ $data[$i]->js }}</td>
                        <td class="right">{{ number_format($data[$i]->tot_valid, 0,".",",") }}</td>
                        <td class="right">{{ isset($data[$i]->tot_notvalid) ?  number_format($data[$i]->tot_notvalid, 0,".",",") : 0}}</td>
                    </tr>
                @endif
                @php
                    $total_valid+=$data[$i]->tot_valid;
                    $total_invalid+=$data[$i]->tot_notvalid;
                    $tempNama = $data[$i]->kodemember;
                @endphp
            @endfor
            <tr>
                <th style="border-right: 1px solid black;" colspan="2">Poin INTERN: {{ isset($t_pi)?number_format($t_pi, 0,".",","):0 }}</th>
                <th style="border-right: 1px solid black;" colspan="2">Poin EXTERN: {{ isset($t_pe)?number_format($t_pe, 0,".",","):0 }}</th>
                <th colspan="2" rowspan="2" >Total: {{  number_format($total, 0,".",",")}}</th>
            </tr>
            <tr>
                <th style="border-right: 1px solid black;" colspan="2">Poin Valid: {{ isset($total_valid)?number_format($total_valid, 0,".",","):0 }}</th>
                <th style="border-right: 1px solid black;" colspan="2">Poin Invalid: {{ isset($total_invalid)?number_format($total_invalid, 0,".",","):0 }}</th>
            </tr>
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot>

        </tfoot>
    </table>
@endsection
