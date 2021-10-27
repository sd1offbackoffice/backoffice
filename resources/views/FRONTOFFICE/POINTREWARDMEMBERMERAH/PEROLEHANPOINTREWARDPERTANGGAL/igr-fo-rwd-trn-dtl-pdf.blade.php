@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN RINCIAN PEROLEHAN REWARD POIN
@endsection

@section('title')
    LAPORAN RINCIAN PEROLEHAN REWARD POIN
@endsection

@section('subtitle')
    {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0,10)}}
@endsection

@section('content')
<table class="table">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
        <th class="right padding-right" width="1%">No.</th>
        <th class="left" width="8%">ID - MEMBER MERAH</th>
        <th class="right">STRUK</th>
        <th class="right">VALID</th>
        <th class="right padding-right">INVALID</th>
        <th class="left">JENIS</th>
        <th class="left">KETERANGAN</th>
    </tr>
    </thead>
    <tbody>
    @php
        $subtotalpertanggal = 0;
        $total_valid=0;
        $total_invalid=0;
        $temptgl = '';
        $temp='';
        $tempNama='';
        $number=0;
    @endphp

    @if(sizeof($data)!=0)
        @for($i=0;$i<count($data);$i++)
            @if($temp != substr($data[$i]->tgl,0,10))
                @php
                    $time = strtotime(substr($data[$i]->tgl,0,10));
                    $newformat = date('d/m/Y',$time);
                @endphp
                <tr>
                    <th align="left">Tanggal : {{ $newformat }}</th>
                    <td colspan="6"></td>
                </tr>
            @endif
            @if($tempNama != $data[$i]->kodemember )
                @php
                    $number++
                @endphp
                <tr>
                    <td class="right padding-right">{{ $number }}</td>
                    <td class="left">{{ $data[$i]->kodemember }}</td>
                    <td class="right">{{ $data[$i]->trn }}</td>
                    <td class="right">{{ number_format($data[$i]->valid, 0,".",",") }}</td>
                    <td class="right padding-right">{{ number_format($data[$i]->notvalid, 0,".",",") }}</td>
                    <td class="left">{{ $data[$i]->js}}</td>
                    <td class="left">{{ $data[$i]->ket }}</td>
                </tr>
            @else
                <tr>
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="right">{{ $data[$i]->trn }}</td>
                    <td class="right">{{ number_format($data[$i]->valid, 0,".",",") }}</td>
                    <td class="right padding-right">{{ number_format($data[$i]->notvalid, 0,".",",") }}</td>
                    <td class="left">{{ $data[$i]->js}}</td>
                    <td class="left">{{ $data[$i]->ket }}</td>
                </tr>
            @endif

            @php
                $subtotalpertanggal=$subtotalpertanggal+$data[$i]->valid;
                 $total_valid=$total_valid+$data[$i]->valid;
                 $total_invalid=$total_invalid+$data[$i]->notvalid;
                 $temp = substr($data[$i]->tgl,0,10);
                 $tempNama = $data[$i]->kodemember;

            @endphp
            @if( isset($data[$i+1]->tgl) && $temp != substr($data[$i+1]->tgl,0,10) || !(isset($data[$i+1]->tgl)) )
                <tr>
                    <th colspan="3" class="right">Subtotal per Tgl :</th>
                    <th class="right">{{ number_format($subtotalpertanggal, 0,".",",")  }}</th>
                </tr>
                @php
                    $subtotalpertanggal = 0;
                @endphp
            @endif
        @endfor
    @else
        <tr>
            <td colspan="10">TIDAK ADA DATA</td>
        </tr>
    @endif
    <tr>
        <th style="border-right: 1px solid black;border-top: 1px solid black" colspan="2">Poin INTERN: {{ isset($t_pi)?number_format($t_pi, 0,".",","):0 }}</th>
        <th style="border-right: 1px solid black;border-top: 1px solid black" colspan="3">Poin EXTERN: {{ isset($t_pe)?number_format($t_pe, 0,".",","):0 }}</th>
        <th style="border-top: 1px solid black;border-bottom: 1px solid black" colspan="2" rowspan="3" >Total: {{  number_format($total, 0,".",",")}}</th>
    </tr>
    <tr>
        <th style="border-right: 1px solid black;border-bottom: 1px solid black" colspan="2">Poin Valid: {{ isset($total_valid)?number_format($total_valid, 0,".",","):0 }}</th>
        <th style="border-right: 1px solid black;border-bottom: 1px solid black" colspan="3">Poin Invalid: {{ isset($total_invalid)?number_format($total_invalid, 0,".",","):0 }}</th>
    </tr>

    </tbody>
    <tfoot>

    </tfoot>
</table>
@endsection
