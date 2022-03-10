@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Service Level PO vs BTB Rekap
@endsection

@section('title')
    Laporan Service Level PO vs BTB Rekap
@endsection

@section('subtitle')
    TANGGAL : {{ $tgl1 }} s/d {{ $tgl2 }}<br>
    {{$subjudul_mtrsup}}
@endsection
@section('header_left')
    {{$subjudul_sort}}
@endsection

{{--@section('paper_height')--}}
{{--    595pt--}}
{{--@endsection--}}

{{--@section('paper_width')--}}
{{--    842pt--}}
{{--@endsection--}}

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right tengah padding-right" style="border-left: 1px solid black">No.</th>
            <th colspan="12" class="left tengah" style="border-right: 1px solid black">Kode Supplier - Nama Supplier</th>
        </tr>
        <tr>
            <th colspan="3" class="tengah" style="border-right: 1px solid black;border-left: 1px solid black">PO</th>
            <th colspan="4" class="tengah" style="border-right: 1px solid black">BPB</th>
            <th colspan="3" class="tengah" style="border-right: 1px solid black">PO Outstanding</th>
            <th colspan="3" class="tengah" style="border-right: 1px solid black">% Service Level</th>
        </tr>
        <tr>
            <th class="right tengah" style="border-left: 1px solid black">Item</th>
            <th class="right tengah">Kuantum</th>
            <th class="right tengah padding-right" style="border-right: 1px solid black">Nilai</th>
            <th class="right tengah">Item AK</th>
            <th class="right tengah">Item NA</th>
            <th class="right tengah">Kuantum</th>
            <th class="right tengah padding-right" style="border-right: 1px solid black">Nilai</th>
            <th class="right tengah">Item</th>
            <th class="right tengah">Kuantum</th>
            <th class="right tengah padding-right" style="border-right: 1px solid black">Nilai</th>
            <th class="right tengah">Item</th>
            <th class="right tengah">Kuantum</th>
            <th class="right tengah padding-right" style="border-right: 1px solid black">Nilai</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempSupplier='';
            $no=0;

            $sub_itempo = 0;
            $sub_qtypo = 0;
            $sub_nilaipo = 0;
            $sub_itembpbak = 0;
            $sub_itembpbna = 0;
            $sub_qtybpb = 0;
            $sub_nilaibpb = 0;
            $sub_itemout = 0;
            $sub_qtyout = 0;
            $sub_nilaiout = 0;
            $sub_slitem = 0;
            $sub_slqty = 0;
            $sub_slnilai = 0;
        @endphp

        @for($i=0; $i<sizeof($data) ;$i++)
            @if($tempSupplier != $data[$i]->sup_namasupplier )
                @php
                    $no++;
                @endphp
                <tr>
                    <td class="right padding-right"><b>{{ $no }}</b></td>
                    <td class="left" colspan="12" class="left"><b> {{ $data[$i]->tpoh_kodesupplier }} - {{ $data[$i]->sup_namasupplier }}</b></td>
                </tr>
            @endif
            <tr>
                <td class="right">{{ number_format($data[$i]->itempo,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->qtypo,0,".",",") }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->nilaipo,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->itembpbak,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->itembpbna,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->qtybpb,0,".",",") }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->nilaibpb,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->itemout,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->qtyout,0,".",",") }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->nilaiout,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->slitem,2,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->slqty,2,".",",") }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->slnilai,2,".",",") }}</td>
            </tr>
            @php
                $tempSupplier = $data[$i]->sup_namasupplier;
                $sub_itempo += $data[$i]->itempo;
                $sub_qtypo += $data[$i]->qtypo;
                $sub_nilaipo += $data[$i]->nilaipo;
                $sub_itembpbak += $data[$i]->itembpbak;
                $sub_itembpbna += $data[$i]->itembpbna;
                $sub_qtybpb += $data[$i]->qtybpb;
                $sub_nilaibpb += $data[$i]->nilaibpb;
                $sub_itemout += $data[$i]->itemout;
                $sub_qtyout += $data[$i]->qtyout;
                $sub_nilaiout += $data[$i]->nilaiout;
                $sub_slitem = ($sub_itembpbak + $sub_itembpbna) / $sub_itempo * 100;
                $sub_slnilai = $sub_nilaibpb / $sub_nilaipo * 100;
                $sub_slqty = $sub_qtybpb / $sub_qtypo * 100;
            @endphp

        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left">TOTAL : </td>
        </tr>
        <tr>
            <td class="left">{{ number_format($sub_itempo,0,".",",") }}</td>
            <td class="left">{{ number_format($sub_qtypo,0,".",",") }}</td>
            <td class="left">{{ number_format($sub_nilaipo,2,".",",") }}</td>
            <td class="left">{{ number_format($sub_itembpbak,0,".",",") }}</td>
            <td class="right">{{ number_format($sub_itembpbna,0,".",",") }}</td>
            <td class="right">{{ number_format($sub_qtybpb,0,".",",") }}</td>
            <td class="right">{{ number_format($sub_nilaibpb,2,".",",") }}</td>
            <td class="right">{{ number_format($sub_itemout,0,".",",") }}</td>
            <td class="right">{{ number_format($sub_qtyout,0,".",",") }}</td>
            <td class="right">{{ number_format($sub_nilaiout,2,".",",") }}</td>
            <td class="right">{{ number_format($sub_slitem,2,".",",") }}</td>
            <td class="right">{{ number_format($sub_slqty,2,".",",") }}</td>
            <td class="right">{{ number_format($sub_slnilai,2,".",",") }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
