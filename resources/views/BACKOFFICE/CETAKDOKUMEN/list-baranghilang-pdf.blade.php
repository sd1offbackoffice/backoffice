@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    {{ strtoupper($data['data1'][0]->judul) }}
@endsection

@section('title')
    {{ strtoupper($data['data1'][0]->judul) }}
@endsection

@section('header_left')
    <table>
        <tr>
            <td class="left">NOMOR TRN</td>
            <td class="left">:</td>
            <td class="left">{{ $data['data1'][0]->trbo_nodoc }}</td>
        </tr>
        <tr>
            <td class="left">TANGGAL</td>
            <td class="left">:</td>
            <td class="left">{{ substr($data['data1'][0]->trbo_tgldoc,0,10) }}</td>
        </tr>
        <tr>
            <td class="left">NO. REF</td>
            <td class="left">:</td>
            <td class="left">{{ substr($data['data1'][0]->trbo_tgldoc,0,10) }}</td>
        </tr>
        <tr>
            <td class="left">KET :</td>
            <td class="left">:</td>
            <td class="left"> {{ $data['data1'][0]->ket }}</td>
        </tr>
    </table>

@endsection
@section('header_right')
    {{$data['data1'][0]->status}}
@endsection

@section('content')
    <br>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" rowspan="2">NO</th>
            <th class="left" rowspan="2">PLU</th>
            <th class="left" rowspan="2">NAMA BARANG</th>
            <th class="tengah left"  rowspan="2">KEMASAN</th>
            <th colspan="2">KWANTUM</th>
            <th class="right" rowspan="2">HARGA SATUAN</th>
            <th class="right padding-right" rowspan="2">TOTAL</th>
            <th class="left" rowspan="2">KETERANGAN</th>
        </tr>
        <tr>
            <th class="right">CTN</th>
            <th class="right">PCS</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $i=1;
        @endphp

        @if(sizeof($data['data1'])!=0)
            @foreach($data['data1'] as $d)
                <tr>
                    <td class="left">{{ $i }}</td>
                    <td class="left">{{ $d->trbo_prdcd }}</td>
                    <td class="left">{{ $d->prd_deskripsipanjang}}</td>
                    <td class="left">{{ $d->trbo_unit }} / {{ $d->trbo_frac }}</td>
                    <td class="right">{{ $d->ctn }}</td>
                    <td class="right">{{ $d->pcs }}</td>
                    <td class="right">{{ number_format(round($d->trbo_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right padding-right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
                    <td class="left">{{ $d->trbo_keterangan }}</td>
                </tr>
                @php
                    $i++;
                    $total += $d->total;
                @endphp
            @endforeach
            <tr style="border-top: 1px solid black">
                <th colspan="6"></th>
                <th class="right">TOTAL SELURUHNYA</th>
                <th class="right padding-right">{{ number_format(round($total), 0, '.', ',') }}</th>
                <th class="right"></th>
            </tr>
        @else
            <tr>
                <td colspan="10">TIDAK ADA DATA</td>
            </tr>
        @endif


        </tbody>

    </table>
@endsection
