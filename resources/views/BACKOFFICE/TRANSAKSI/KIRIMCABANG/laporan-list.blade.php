@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Edit List Surat Jalan
@endsection

@section('title')
    ** Edit List Surat Jalan **
@endsection

@section('subtitle')

@endsection

@section('content')
@php
    $temp = '';
    $i = 0;
    $total = 0;
@endphp
@foreach($data as $d)
@if($temp != $d->trbo_nodoc)
@if($temp != '')
</tbody>
    <tfoot style="text-align: center">
    <tr>
        <td colspan="6"></td>
        <td style="text-align: left"><strong>TOTAL SELURUHNYA</strong></td>
        <td style="text-align: right">{{ number_format($total,2) }}</td>
        <td></td>
    </tr>
    </tfoot>
    </table>
    <div class="page-break"></div>
    @endif
    @php
        $temp = $d->trbo_nodoc;
        $i = 0;
        $total = 0;
    @endphp
    <table class="table">
        <thead style="border-bottom: 1px solid black;">
        <tr>
            <td class="left">
                Nomor Trn<br>
                Tanggal<br>
                Nomor Referensi
            </td>
            <td class="left">
                : {{ $d->trbo_nodoc }}<br>
                : @if($d->trbo_tgldoc != '')
                    {{ date('d/m/Y', strtotime($d->trbo_tgldoc)) }}
                @endif <br>
                : {{ $d->trbo_noreff }}
            </td>
            <td class="left">
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                Untuk Cabang<br>
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                Gudang<br>
                <span style="color:white">.</span>
            </td>
            <td class="left">
                : {{ $d->trbo_loc }} {{ $d->cab_namacabang }}<br>
                : {{ $d->trbo_gdg }} {{ $d->gdg_namagudang }}<br>
                <span style="color:white">.</span>
            </td>
            <td colspan="4"></td>
            <td class="right" style="font-size: 18px">@if($reprint == '1') RE-PRINT @endif</td>
        </tr>
        <tr style="border-top: 1px solid black;">
            <th class="tengah" rowspan="2">NO</th>
            <th class="tengah" rowspan="2">PLU</th>
            <th class="tengah" rowspan="2">NAMA BARANG</th>
            <th class="tengah" rowspan="2">KEMASAN</th>
            <th colspan="2">KWANTUM</th>
            <th class="tengah" rowspan="2">HARGA SATUAN</th>
            <th class="tengah" rowspan="2">TOTAL</th>
            <th class="tengah" rowspan="2">KETERANGAN</th>
        </tr>
        <tr>
            <th>BESAR</th>
            <th>KECIL</th>
        </tr>
        </thead>
        <tbody>
        @endif
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $d->trbo_prdcd }}</td>
            <td class="left">{{ $d->prd_deskripsipanjang }}</td>
            <td>{{ $d->prd_unit }}/{{ $d->prd_frac }}</td>
            <td>{{ $d->ctn }}</td>
            <td>{{ $d->pcs }}</td>
            <td>{{ number_format($d->trbo_hrgsatuan,2) }}</td>
            <td style="text-align: right">{{ number_format($d->total,2) }}</td>
            <td>{{ $d->trbo_keterangan }}</td>
        </tr>
        @php $total += $d->total;@endphp
        @endforeach
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td colspan="6"></td>
            <td style="text-align: left"><strong>TOTAL SELURUHNYA</strong></td>
            <td style="text-align: right">{{ number_format($total,2) }}</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
@endsection
