@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN REKAPITULASI REGISTER PPR IDM
@endsection

@section('title')
    LAPORAN REKAPITULASI REGISTER PPR IDM
@endsection

@section('subtitle')
    @if($member1!='')
        {{ 'Member : '. $member1 .' - '. $member2 }}<br>
    @endif
    {{ 'Tgl : '. substr($tgl1,0,10) .' - '. substr($tgl2,0,10) }}<br>
    @if($nodoc1!='')
        {{ 'No. Dokumen : '. $nodoc1 .' - '. $nodoc2 }}<br>
    @endif
@endsection

@section('content')

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right">NO</th>
            <th class="left">MEMBER</th>
            <th class="left">TOKO</th>
            <th class="left">TANGGAL</th>
            <th class="left">NO. NRB</th>
            <th class="left">NO. DOKUMEN</th>
            <th class="right">ITEM</th>
            <th class="right">NILAI</th>
            <th class="right">PPN</th>
        </tr>
        </thead>
        <tbody>
        @php
            $no = 1;
            $total_harga = 0;
            $total_ppn = 0;
            $sub_harga = 0;
            $sub_ppn = 0;
            $member_temp = '';
        @endphp
        @if(sizeof($data)!=0)
            @for($i=0;$i<sizeof($data);$i++)
                @if($member_temp != $data[$i]->member)
                    <tr>
                        <td class="right padding-right">{{ $no }}</td>
                        <td class="left">{{ $data[$i]->member }}</td>
                        <td class="left">{{ $data[$i]->tko_kodeomi }}</td>
                        <td class="left">{{ substr($data[$i]->trpt_salesinvoicedate,0,10)}}</td>
                        <td class="left">{{ $data[$i]->trpt_invoicetaxno }}</td>
                        <td class="left">{{ $data[$i]->trpt_salesinvoiceno }}</td>
                        <td class="right">{{ $data[$i]->cf_item }}</td>
                        <td class="right">{{ number_format($data[$i]->trpt_netsales,0) }}</td>
                        <td class="right">{{ number_format($data[$i]->trpt_ppntaxvalue,0) }}</td>
                    </tr>
                    @php
                        $no++;
                    @endphp
                @else
                    <tr>
                        <td class="left"></td>
                        <td class="left"></td>
                        <td class="left">{{ $data[$i]->tko_kodeomi }}</td>
                        <td class="left">{{ date('d/m/Y',strtotime(substr($data[$i]->trpt_salesinvoicedate,0,10))) }}</td>
                        <td class="left">{{ $data[$i]->trpt_invoicetaxno }}</td>
                        <td class="left">{{ $data[$i]->trpt_salesinvoiceno }}</td>
                        <td class="right">{{ $data[$i]->cf_item }}</td>
                        <td class="right">{{ number_format($data[$i]->trpt_netsales,0) }}</td>
                        <td class="right">{{ number_format($data[$i]->trpt_ppntaxvalue,0) }}</td>
                    </tr>
                @endif
                @php
                    $no++;
                    $sub_harga += $data[$i]->trpt_netsales;
                    $sub_ppn += $data[$i]->trpt_ppntaxvalue;
                    $member_temp = $data[$i]->member;
                    $total_harga += $data[$i]->trpt_netsales;
                    $total_ppn += $data[$i]->trpt_ppntaxvalue;
                @endphp
                @if( isset($data[$i+1]->member) && $member_temp != $data[$i+1]->member || !(isset($data[$i+1]->member)) )
                    <tr>
                        <td colspan="7" class="right"><b> SUB TOTAL :</b></td>
                        <td class="right">{{ number_format($sub_harga,0) }}</td>
                        <td class="right">{{ number_format($sub_ppn,0) }}</td>
                    </tr>
                    @php
                        $sub_harga =0;
                        $sub_ppn =0;
                    @endphp
                @endif

            @endfor
        @else
            <tr>
                <td colspan="8">TIDAK ADA DATA</td>
            </tr>
        @endif
        </tbody>
        <tfoot style="border-bottom: none">
        <tr>
            <td colspan="7" class="right"><b>TOTAL</b></td>
            <td class="right">{{ number_format($total_harga,0) }}</td>
            <td class="right">{{ number_format($total_ppn,0) }}</td>
        </tr>
        </tfoot>
    </table>
@endsection

