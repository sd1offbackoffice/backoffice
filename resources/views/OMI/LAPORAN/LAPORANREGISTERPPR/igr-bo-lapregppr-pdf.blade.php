@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN REGISTER PPR OMI
@endsection

@section('title')
    LAPORAN REGISTER PPR OMI
@endsection

@section('subtitle')
    {{ 'Tgl : '. substr($tgl1,0,10) .' - '. substr($tgl2,0,10) }}<br>
    {{ 'No. Dokumen : '. $nodoc1 .' - '. $nodoc2 }}<br>
@endsection

@section('content')

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="10%" class="left padding-right">TGL</th>
            <th width="5%" class="left">NO. NRB</th>
            <th width="10%" class="left padding-right">NO. DOK</th>
            <th width="10%" class="left padding-right">NO. NOTA RETUR</th>
            <th width="5%" class="right padding-right">ITEM</th>
            <th width="10%" class="left padding-right">MEMBER</th>
            <th width="5%" class="right padding-right">NILAI</th>
            <th width="5%" class="right padding-right">PPN</th>
            <th width="5%" class="right padding-right">PPN DIBEBASKAN</th>
            <th width="5%" class="right padding-right">PPN DTP</th>

            <th width="10%" class="left padding-right">NPWP</th>
            <th width="10%" class="left">NO. REFERENSI</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_nilai = 0;
            $total_ppn = 0;
            $tgl_temp = '';
        @endphp
        @if(sizeof($data)!=0)
            @foreach($data as $d)
                @if($tgl_temp != $d->tgldok)
                <tr>
                    <td class="left padding-right">{{ date('d/m/Y',strtotime(substr($d->tgldok,0,10))) }}</td>
                    <td class="left">{{ $d->rom_kodetoko.'-'.$d->rom_noreferensi }}</td>
                    <td class="left padding-right">{{ $d->rom_nodokumen}}</td>
                    <td class="left padding-right">{{ $d->cp_nonota }}</td>
                    <td class="right padding-right">{{ $d->item }}</td>
                    <td class="left padding-right">{{ $d->rom_member }}-{{ $d->cus_namamember }}</td>
                    <td class="right padding-right">{{ number_format($d->harga,0) }}</td>
                    {{-- <td class="right padding-right">{{ number_format($d->ppn,0) }}</td> --}}
                    @if($d->prd_flagbkp1 == 'Y' )
                        @if($d->prd_flagbkp2 == 'Y')
                            <td class="right padding-right">{{ number_format($d->ppn,2) }}</td>
                            <td class="right padding-right">{{ number_format(0,2) }}</td>
                            <td class="right padding-right">{{ number_format(0,2) }}</td>
                        @elseif($d->prd_flagbkp2 == 'P')
                            <td class="right padding-right">{{ number_format(0,2) }}</td>
                            <td class="right padding-right">{{ number_format($d->ppn,2) }}</td>
                            <td class="right padding-right">{{ number_format(0,2) }}</td>
                        @elseif($d->prd_flagbkp2 == 'G' || $d->prd_flagbkp2 == 'W')
                            <td class="right padding-right">{{ number_format(0,2) }}</td>
                            <td class="right padding-right" >{{ number_format(0,2) }}</td>
                            <td class="right padding-right">{{ number_format($d->ppn,2) }}</td>
                        @else
                            <td class="right padding-right">{{ number_format($d->ppn,2) }}</td>
                            <td class="right padding-right">{{ number_format(0,2) }}</td>
                            <td class="right padding-right">{{ number_format(0,2) }}</td>
                        @endif
                    @else
                        <td class="right padding-right">{{ number_format($d->ppn,2) }}</td>
                        <td class="right padding-right">{{ number_format(0,2) }}</td>
                        <td class="right padding-right">{{ number_format(0,2) }}</td>
                    @endif

                    <td class="left padding-right">{{ $d->cus_npwp }}</td>
                    <td class="left">{{ $d->cp_reffp }}</td>
                </tr>
                @else
                    <tr>
                        <td class="left padding-right"></td>
                        <td class="left">{{ $d->rom_kodetoko.'-'.$d->rom_noreferensi }}</td>
                        <td class="left padding-right">{{ $d->rom_nodokumen}}</td>
                        <td class="left padding-right">{{ $d->cp_nonota }}</td>
                        <td class="right padding-right">{{ $d->item }}</td>
                        <td class="left padding-right">{{ $d->rom_member }}-{{ $d->cus_namamember }}</td>
                        <td class="right padding-right">{{ number_format($d->harga,0) }}</td>
                        {{-- <td class="right padding-right">{{ number_format($d->ppn,0) }}</td> --}}

                        @if($d->prd_flagbkp1 == 'Y' )
                            @if($d->prd_flagbkp2 == 'Y')
                                <td class="right padding-right">{{ number_format($d->ppn,2) }}</td>
                                <td class="right padding-right">{{ number_format(0,2) }}</td>
                                <td class="right padding-right">{{ number_format(0,2) }}</td>
                            @elseif($d->prd_flagbkp2 == 'P')
                                <td class="right padding-right">{{ number_format(0,2) }}</td>
                                <td class="right padding-right">{{ number_format($d->ppn,2) }}</td>
                                <td class="right padding-right">{{ number_format(0,2) }}</td>
                            @elseif($d->prd_flagbkp2 == 'G' || $d->prd_flagbkp2 == 'W')
                                <td class="right padding-right">{{ number_format(0,2) }}</td>
                                <td class="right padding-right">{{ number_format(0,2) }}</td>
                                <td class="right padding-right" >{{ number_format($d->ppn,2) }}</td>
                            @else
                                <td class="right padding-right">{{ number_format($d->ppn,2) }}</td>
                                <td class="right padding-right">{{ number_format(0,2) }}</td>
                                <td class="right padding-right">{{ number_format(0,2) }}</td>
                            @endif
                        @else
                            <td class="right padding-right">{{ number_format($d->ppn,2) }}</td>
                            <td class="right padding-right">{{ number_format(0,2) }}</td>
                            <td class="right padding-right">{{ number_format(0,2) }}</td>
                        @endif

                        <td class="left padding-right">{{ $d->cus_npwp }}</td>
                        <td class="left">{{ $d->cp_reffp }}</td>
                    </tr>
                @endif
                @php
                    $tgl_temp = $d->tgldok;
                    $total_nilai += $d->harga;
                    $total_ppn += $d->ppn;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="12">TIDAK ADA DATA</td>
            </tr>
        @endif
        <tr>
            <td colspan="6" align="right">TOTAL</td>
            <td class="right padding-right">{{ number_format($total_nilai,0) }}</td>
            <td class="right padding-right">{{ number_format($total_ppn,0) }}</td>
            <td colspan="2"></td>
        </tr>
        </tbody>
    </table>
@endsection
