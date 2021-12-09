@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    EDIT LIST PENGELUARAN BARANG
@endsection

@section('title')
    EDIT LIST PENGELUARAN BARANG
@endsection
@section('header_left')
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
            <td class="left">: {{ $data['data1'][0]->trbo_kodesupplier }} {{ $data['data1'][0]->sup_namasupplier }}</td>
        </tr>
        @php
            $i=0;
        @endphp
        @foreach($data['data2'] as $d)
            @if($i == 0)
                <tr>
                    <td class="left">FAKTUR PAJAK</td>
                    <td class="left">: {{ $d->trbo_istype }} {{ $d->trbo_invno }}
                        Tanggal {{ date('d/m/Y',strtotime(substr($d->trbo_tglinv,0,10))) }}</td>
                </tr>
            @else
                <tr>
                    <td class="left"></td>
                    <td class="left">: {{ $d->trbo_istype }} {{ $d->trbo_invno }}
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

@endsection
@section('content')
    @for($j=0; $j<$i; $j++ )
        <br>
    @endfor
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right" rowspan="2">NO</th>
            <th class="left" rowspan="2">PLU</th>
            <th class="left" rowspan="2">NAMA BARANG</th>
            <th class="left" colspan="2">KEMASAN</th>
            <th class="right" rowspan="2">HARGA<br>SATUAN</th>
            <th class="right" colspan="2">KWANTUM</th>
            <th class="right" rowspan="2">GROSS</th>
            <th class="right" rowspan="2">POTONGAN</th>
            <th class="right" rowspan="2">PPN</th>
            <th class="right padding-right" rowspan="2">TOTAL NILAI</th>
            <th class="left" rowspan="2">NO. REF <br> BPB</th>
            <th class="left" rowspan="2">KET</th>
        </tr>
        <tr>
            <th>BESAR</th>
            <th>KECIL</th>
        </tr>
        </thead>
        <tbody>
        @php
            $gross = 0;
            $potongan = 0;
            $ppn = 0;
            $total = 0;
            $i=1;
        @endphp

        @if(sizeof($data['data1'])!=0)
            @foreach($data['data1'] as $d)
                <tr>
                    <td class="right padding-right">{{ $i }}</td>
                    <td class="left">{{ $d->trbo_prdcd }}</td>
                    <td class="left">{{ $d->prd_deskripsipendek}}</td>
                    <td class="left">{{ $d->btb_unit }}</td>
                    <td class="right">{{ $d->btb_frac }}</td>
                    <td class="right">{{ number_format(round($d->trbo_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right">{{ $d->ctn }}</td>
                    <td class="right">{{ $d->pcs }}</td>
                    <td class="right">{{ number_format(round($d->trbo_gross), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($d->trbo_discrph), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($d->trbo_ppnrph), 0, '.', ',') }}</td>
                    <td class="right padding-right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
                    <td class="left">{{ $d->trbo_noreff }}</td>
                    <td class="left">{{ $d->trbo_keterangan }}</td>
                </tr>
                @php
                    $i++;
                    $total += $d->total;
                    $gross += $d->trbo_gross;
                    $potongan += $d->trbo_discrph;
                    $ppn += $d->trbo_ppnrph;
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
            <th colspan="6"></th>
            <th colspan="2" style="font-weight: bold">TOTAL SELURUHNYA</th>
            <th class="right">{{ number_format(round($gross), 0, '.', ',') }}</th>
            <th class="right">{{ number_format(round($potongan), 0, '.', ',') }}</th>
            <th class="right">{{ number_format(round($ppn), 0, '.', ',') }}</th>
            <th class="right padding-right">{{ number_format(round($total), 0, '.', ',') }}</th>
            <th class="left"></th>
            <th class="left"></th>
        </tr>
        </tfoot>
    </table>
@endsection
