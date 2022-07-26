@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    EDIT LIST PENGELUARAN BARANG
@endsection

@section('title')
    EDIT LIST PENGELUARAN BARANG
@endsection
@section('subtitle')

@endsection
{{-- @section('header_left')
    <table>
        <tr>
            <td class="left">NOMOR TRN</td>
            <td class="left">: {{ $data['data1'][0]->trbo_nodoc }}</td>
        </tr>
        <tr>
            <td class="left">TANGGAL</td>
            <td class="left">: {{ date('d/m/Y',strtotime(substr($data['data1'][0]->trbo_tgldoc,0,10))) }}</td>
        </tr>
        <tr>
            <td class="left">SUPPLIER</td>
            <td class="left" colspan="4">: {{ $data['data1'][0]->trbo_kodesupplier }} {{ $data['data1'][0]->sup_namasupplier }}</td>
        </tr>
        @php
            $i=0;
        @endphp
        @foreach($data['data2'] as $d)
            @if($i == 0)
                <tr>
                    <td class="left">FAKTUR PAJAK</td>
                    <td class="left">: No. {{ $d->trbo_istype }} </td>
                    <td class="left" width="50px">{{ $d->trbo_invno }}</td>
                    <td class="right">
                        Tanggal {{ date('d/m/Y',strtotime(substr($d->trbo_tglinv,0,10))) }}</td>
                </tr>
            @else
                <tr>
                    <td class="left"></td>
                    <td class="left">: No. {{ $d->trbo_istype }} </td>
                    <td class="left" width="50px">{{ $d->trbo_invno }}</td>
                    <td class="right">
                        Tanggal {{ date('d/m/Y',strtotime(substr($d->trbo_tglinv,0,10))) }}</td>
                </tr>
            @endif
            @php
                $i++;
            @endphp
        @endforeach
        <tr>
            <td class="left">{{ $data['data1'][0]->status }} </td>
        </tr>
    </table>
@endsection --}}
<table>
    <tr>
        <td class="left">NOMOR TRN</td>
        <td class="left">: {{ $data['data1'][0]->trbo_nodoc }}</td>
    </tr>
    <tr>
        <td class="left">TANGGAL</td>
        <td class="left">: {{ date('d/m/Y',strtotime(substr($data['data1'][0]->trbo_tgldoc,0,10))) }}</td>
    </tr>
    <tr>
        <td class="left">SUPPLIER</td>
        <td class="left" colspan="4">: {{ $data['data1'][0]->trbo_kodesupplier }} {{ $data['data1'][0]->sup_namasupplier }}</td>
    </tr>
    @php
        $i=0;
    @endphp
    @foreach($data['data2'] as $d)
        @if($i == 0)
            <tr>
                <td class="left">FAKTUR PAJAK</td>
                <td class="left">: No. {{ $d->trbo_istype }} </td>
                <td class="left" width="50px">{{ $d->trbo_invno }}</td>
                <td class="right">
                    Tanggal {{ date('d/m/Y',strtotime(substr($d->trbo_tglinv,0,10))) }}</td>
            </tr>
        @else
            <tr>
                <td class="left"></td>
                <td class="left">: No. {{ $d->trbo_istype }} </td>
                <td class="left" width="50px">{{ $d->trbo_invno }}</td>
                <td class="right">
                    Tanggal {{ date('d/m/Y',strtotime(substr($d->trbo_tglinv,0,10))) }}</td>
            </tr>
        @endif
        @php
            $i++;
        @endphp
    @endforeach
    <tr>
        <td class="left">{{ $data['data1'][0]->status }} </td>
    </tr>
</table>
<br>
@section('content')
    {{-- @for($j=0; $j<$i; $j++ )
        <br>
    @endfor --}}
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right" rowspan="2">NO</th>
            <th class="left" rowspan="2">PLU</th>
            <th class="left" rowspan="2">NAMA BARANG</th>
            <th class="left" rowspan="2">KEMASAN</th>
            <th class="right" rowspan="2">HARGA SATUAN</th>
            <th class="center" colspan="2">KWANTUM</th>
            <th class="right" rowspan="2">GROSS</th>
            <th class="right" rowspan="2">POTONGAN</th>
            <th class="right" rowspan="2">PPN</th>
            <th class="right" rowspan="2">PPN BEBAS</th>
            <th class="right" rowspan="2">PPN <br>DITANGGUNG PEMERINTAH</th>
            <th class="right padding-right" rowspan="2">TOTAL NILAI</th>
            <th class="left" rowspan="2">NO. REF <br> BPB</th>
            <th class="left" rowspan="2">KET</th>
        </tr>
        <tr>
            <th class="right">BESAR</th>
            <th class="right">KECIL</th>
        </tr>
        </thead>
        <tbody>
        @php
            $gross = 0;
            $potongan = 0;
            $ppn = 0;
            $total_bebas = 0;
            $total_dtp = 0;
            $total = 0;
            $i=1;
        @endphp

        @if(sizeof($data['data1'])!=0)
            @foreach($data['data1'] as $d)
                <tr>
                    <td class="right padding-right">{{ $i }}</td>
                    <td class="left">{{ $d->trbo_prdcd }}</td>
                    <td class="left">{{ $d->prd_deskripsipendek}}</td>
                    <td class="left">{{ $d->btb_unit }}/{{ $d->btb_frac }}</td>
                    <td class="right">{{ number_format(round($d->trbo_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right">{{ $d->ctn }}</td>
                    <td class="right">{{ $d->pcs }}</td>
                    <td class="right">{{ number_format(round($d->trbo_gross), 2, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($d->trbo_discrph), 2, '.', ',') }}</td>

                    @php
                        $ppn_rph = 0;
                        $ppn_bebas = 0;
                        $ppn_dtp = 0;

                        switch ($d->prd_flagbkp1) {
                            case 'Y':
                                switch ($d->prd_flagbkp2) {
                                    case 'Y':
                                        $ppn_rph = $d->trbo_ppnrph;
                                        break;
                                    case 'P':
                                        $ppn_bebas = $d->trbo_ppnrph;
                                        break;
                                    case 'W' || 'G':
                                        $ppn_dtp = $d->trbo_ppnrph;
                                        break;                                    
                                }
                                break;                            
                        }
                    @endphp

                    <td class="right">{{ number_format(round($ppn_rph), 2, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($ppn_bebas), 2, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($ppn_dtp), 2, '.', ',') }}</td>

                    <td class="right padding-right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
                    <td class="left">{{ $d->trbo_noreff }}</td>
                    <td class="left">{{ $d->trbo_keterangan }}</td>
                </tr>
                @php
                    $i++;
                    $total += $d->total;
                    $gross += $d->trbo_gross;
                    $potongan += $d->trbo_discrph;
                    $ppn += $ppn_rph;
                    $total_bebas += $ppn_bebas;
                    $total_dtp += $ppn_dtp;
                @endphp
            @endforeach
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif


        </tbody>
        <tfoot>
        <tr>
            <th colspan="5"></th>
            <th colspan="2" style="font-weight: bold">TOTAL SELURUHNYA</th>
            <th class="right">{{ number_format(round($gross), 2, '.', ',') }}</th>
            <th class="right">{{ number_format(round($potongan), 2, '.', ',') }}</th>
            <th class="right">{{ number_format(round($ppn), 2, '.', ',') }}</th>
            <th class="right">{{ number_format(round($total_bebas), 2, '.', ',') }}</th>
            <th class="right">{{ number_format(round($total_dtp), 2, '.', ',') }}</th>
            <th class="right padding-right">{{ number_format(round($total), 2, '.', ',') }}</th>
            <th class="left"></th>
            <th class="left"></th>
        </tr>
        </tfoot>
    </table>
@endsection
