@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Service Level PO vs BTB Detail
@endsection

@section('title')
    Laporan Service Level PO vs BTB Detail
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

            $tot_itempo = 0 ;
            $tot_qtypo = 0 ;
            $tot_nilaipo = 0 ;
            $tot_itembpbak = 0 ;
            $tot_itembpbna = 0 ;
            $tot_qtybpb = 0 ;
            $tot_nilaibpb = 0 ;
            $tot_itemout = 0 ;
            $tot_qtyout = 0 ;
            $tot_nilaiout = 0 ;
            $tot_slitem = 0 ;
            $tot_slqty = 0 ;
            $tot_slnilai = 0 ;
        @endphp

        @for($i=0; $i<sizeof($data) ;$i++)
            @if($tempSupplier != $data[$i]->tpoh_kodesupplier )
                @php
                    $no=0;
                @endphp
                <tr>
                    <td class="left" colspan="12" class="left"><b> {{ $data[$i]->tpoh_kodesupplier }} - {{ $data[$i]->namasup }}</b></td>
                </tr>
            @endif
            @php
                $no++;
            @endphp
            <tr>
                <td class="right padding-right"><b>{{ $no }}</b></td>
                <td class="left" colspan="12" class="left"><b> {{ date('d/m/Y',strtotime(substr($data[$i]->tpoh_tglpo,0,10))) }} - {{ $data[$i]->tpoh_nopo }}</b></td>
            </tr>
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
                $tempSupplier = $data[$i]->tpoh_kodesupplier;
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
                $sub_slitem = ($sub_itempo - $sub_itemout)==0?0:(($sub_itembpbak + $sub_itembpbna) / ($sub_itempo - $sub_itemout)) * 100;
                $sub_slqty = ($sub_qtypo - $sub_qtyout)==0?0:($sub_qtybpb / ($sub_qtypo - $sub_qtyout)) * 100;
                $sub_slnilai = ($sub_nilaipo - $sub_nilaiout)==0?0:($sub_nilaibpb / ($sub_nilaipo - $sub_nilaiout)) * 100;


                $tot_itempo += $data[$i]->itempo;
                $tot_qtypo += $data[$i]->qtypo;
                $tot_nilaipo += $data[$i]->nilaipo;
                $tot_itembpbak += $data[$i]->itembpbak;
                $tot_itembpbna += $data[$i]->itembpbna;
                $tot_qtybpb += $data[$i]->qtybpb;
                $tot_nilaibpb += $data[$i]->nilaibpb;
                $tot_itemout += $data[$i]->itemout;
                $tot_qtyout += $data[$i]->qtyout;
                $tot_nilaiout += $data[$i]->nilaiout;
                $tot_slitem = ($tot_itempo - $tot_itemout)==0?0:(($tot_itembpbak + $tot_itembpbna) / ($tot_itempo - $tot_itemout)) * 100;
                $tot_slqty = ($tot_qtypo - $tot_qtyout)==0?0:($tot_qtybpb / ($tot_qtypo - $tot_qtyout)) * 100;
                $tot_slnilai = ($tot_nilaipo - $tot_nilaiout)==0?0:($tot_nilaibpb / ($tot_nilaipo - $tot_nilaiout)) * 100;
            @endphp

            @if(!isset($data[$i+1]->tpoh_kodesupplier ) || ($data[$i+1]->tpoh_kodesupplier!=$tempSupplier && isset($data[$i+1]->tpoh_kodesupplier )) )
                <tr style="border-top: 1px solid black;">
                    <td class="left">Sub Total : </td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td class="right">{{ number_format($sub_itempo,0,".",",") }}</td>
                    <td class="right">{{ number_format($sub_qtypo,0,".",",") }}</td>
                    <td class="right padding-right">{{ number_format($sub_nilaipo,2,".",",") }}</td>
                    <td class="right">{{ number_format($sub_itembpbak,0,".",",") }}</td>
                    <td class="right">{{ number_format($sub_itembpbna,0,".",",") }}</td>
                    <td class="right">{{ number_format($sub_qtybpb,0,".",",") }}</td>
                    <td class="right padding-right">{{ number_format($sub_nilaibpb,2,".",",") }}</td>
                    <td class="right">{{ number_format($sub_itemout,0,".",",") }}</td>
                    <td class="right">{{ number_format($sub_qtyout,0,".",",") }}</td>
                    <td class="right padding-right">{{ number_format($sub_nilaiout,2,".",",") }}</td>
                    <td class="right">{{ number_format($sub_slitem,2,".",",") }}</td>
                    <td class="right">{{ number_format($sub_slqty,2,".",",") }}</td>
                    <td class="right padding-right">{{ number_format($sub_slnilai,2,".",",") }}</td>
                </tr>
                @php
                    $sub_itempo =0;
                    $sub_qtypo =0;
                    $sub_nilaipo =0;
                    $sub_itembpbak =0;
                    $sub_itembpbna =0;
                    $sub_qtybpb =0;
                    $sub_nilaibpb =0;
                    $sub_itemout =0;
                    $sub_qtyout =0;
                    $sub_nilaiout =0;
                    $sub_slitem = 0;
                    $sub_slqty = 0;
                    $sub_slnilai = 0;
                @endphp
            @endif
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left">TOTAL : </td>
        </tr>
        <tr>
            <td class="right">{{ number_format($tot_itempo,0,".",",") }}</td>
            <td class="right">{{ number_format($tot_qtypo,0,".",",") }}</td>
            <td class="right padding-right">{{ number_format($tot_nilaipo,2,".",",") }}</td>
            <td class="right">{{ number_format($tot_itembpbak,0,".",",") }}</td>
            <td class="right">{{ number_format($tot_itembpbna,0,".",",") }}</td>
            <td class="right">{{ number_format($tot_qtybpb,0,".",",") }}</td>
            <td class="right padding-right">{{ number_format($tot_nilaibpb,2,".",",") }}</td>
            <td class="right">{{ number_format($tot_itemout,0,".",",") }}</td>
            <td class="right">{{ number_format($tot_qtyout,0,".",",") }}</td>
            <td class="right padding-right">{{ number_format($tot_nilaiout,2,".",",") }}</td>
            <td class="right">{{ number_format($tot_slitem,2,".",",") }}</td>
            <td class="right">{{ number_format($tot_slqty,2,".",",") }}</td>
            <td class="right padding-right">{{ number_format($tot_slnilai,2,".",",") }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
