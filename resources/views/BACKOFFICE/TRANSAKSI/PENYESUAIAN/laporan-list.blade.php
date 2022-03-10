@extends('pdf-template')

@section('paper_size',$ukuran == 'besar' ? '595pt 842pt': '595pt 442pt')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Penyesuaian
@endsection

@section('title')
    ** EDIT LIST PENYESUAIAN PERSEDIAAN **
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
        <td colspan="5"></td>
        <td colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
        <td>{{ number_format($total,1) }}</td>
        <td></td>
    </tr>
    </tfoot>
    </table>
    <div class="page-break"></div>
    @endif
    @php
        $temp = $d->trbo_nodoc;
        $i = 0;
    @endphp
    <table class="table-borderless table-header">
        <tr style="text-align: left">
            <td>
                Nomor Penyesuaian<br>
                Nomor Refferensi<br>
                Keterangan
            </td>
            <td>
                : {{ $d->trbo_nodoc }}<br>
                : <br>
                : {{ $d->keterangan_h }}
            </td>
            <td>
                Tanggal<br>
                Tanggal<br>
                <span style="color:white">.</span>
            </td>
            <td>
                : @if($d->trbo_tgldoc != '')
                    {{ date('d/m/Y', strtotime($d->trbo_tgldoc)) }}
                @endif
                <br>
                : @if($d->trbo_tglreff != '')
                    {{ date('d/m/Y', strtotime($d->trbo_tglreff)) }}
                @endif
                <br>
                <span style="color:white">.</span>
            </td>
        </tr>
    </table>

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2" width="3%">No</th>
            <th class="tengah" rowspan="2" width="7%">PLU</th>
            <th class="tengah" rowspan="2" width="40%">NAMA BARANG</th>
            <th class="tengah" rowspan="2" width="7%">KEMASAN</th>
            <th colspan="2" width="10%">KWANTUM</th>
            <th class="tengah" width="10%">HARGA</th>
            <th class="tengah" rowspan="2" width="10%">TOTAL</th>
            <th class="tengah" rowspan="2" width="13%">KETERANGAN</th>
        </tr>
        <tr>
            <th>BESAR</th>
            <th>KECIL</th>
            <th>IN CTN</th>
        </tr>
        </thead>
        <tbody>
        @endif
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $d->plu }}</td>
            <td class="left">{{ $d->prd_deskripsipanjang }}</td>
            <td>{{ $d->kemasan }}</td>
            <td>{{ number_format($d->trbo_qty < 0 ? ceil($d->trbo_qty / $d->prd_frac) : floor($d->trbo_qty / $d->prd_frac),0) }}</td>
            <td>{{ $d->trbo_qty % $d->prd_frac }}</td>
            <td>{{ number_format($d->trbo_hrgsatuan,2) }}</td>
            <td>{{ number_format($d->trbo_gross,1) }}</td>
            <td>{{ $d->trbo_keterangan }}</td>
        </tr>
        @php $total += $d->trbo_gross; @endphp
        @endforeach
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td colspan="5"></td>
            <td colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td>{{ number_format($total,1) }}</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
@endsection
