@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
Surat Jalan
@endsection

@section('title')
** Surat Jalan **
@endsection

@section('subtitle')

@endsection

@section('content')
@php
$temp = '';
$i = 0;
$total = 0;
$ppn = 0;
@endphp
@foreach($data as $d)
@if($temp != $d->msth_nodoc)
@if($temp != '')
</tbody>
<tfoot style="text-align: center">
    <tr>
        <td colspan="6"></td>
        <td style="text-align: left"><strong>TOTAL SELURUHNYA</strong></td>
        <td style="text-align: right">{{ number_format($total,2) }}</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="6"></td>
        <td style="text-align: left"><strong>PPN</strong></td>
        <td style="text-align: right">{{ number_format($ppn,2) }}</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="6"></td>
        <td style="text-align: left"><strong>TOTAL SELURUHNYA</strong></td>
        <td style="text-align: right">{{ number_format($total + $ppn,2) }}</td>
        <td></td>
    </tr>
</tfoot>
</table>
<br>
<table style="width: 100%; font-weight: bold" class="table-ttd">
    <tr>
        <td>DIBUAT</td>
        <td>DIPERISKA</td>
        <td>MENYETUJUI</td>
        <td>PELAKSANA</td>
        <td>PENERIMA</td>
    </tr>
    <tr class="blank-row">
        <td colspan="5">.</td>
    </tr>
    <tr>
        <td>ADMINISTRASI</td>
        <td>KEPALA GUDANG</td>
        <td>STORE MANAGER</td>
        <td>STOCK CLERK / PETUGAS GUDANG</td>
        <td>CABANG PENERIMA</td>
    </tr>
</table>
<div class="page-break"></div>
@endif
@php
$temp = $d->msth_nodoc;
$i = 0;
$total = 0;
$ppn = 0;
@endphp

<table class="table">
    <thead style="border-bottom: 1px solid black;">
        <tr>
            <td class="left">
                Nomor Surat Jalan<br>
                Nomor Referensi
            </td>
            <td class="left">
                : {{ $d->msth_nodoc }}<br>
                : {{ $d->msth_noref3 }}
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
                Tanggal Surat Jalan : @if($d->msth_tgldoc != '')
                {{ date('d/m/Y', strtotime($d->msth_tgldoc)) }}
                @endif
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;
                Tanggal Referensi : @if($d->msth_tgref3 != '')
                {{ date('d/m/Y', strtotime($d->msth_tgref3)) }}
                @endif
            </td>
            <td class="left">
                Untuk Cabang<br>
                Gudang
            </td>
            <td class="left" colspan="2">
                : {{ $d->msth_loc2 }} {{ $d->cab_namacabang }}<br>
                : {{ $d->gdg_namagudang }}
            </td>
            <td></td>
            <td colspan="2" class="right" style="font-size: 18px">@if($reprint == '1') RE-PRINT @endif</td>
        </tr>
        <tr style="border-top: 1px solid black;">
            <th class="tengah" rowspan="2">No</th>
            <th class="tengah" rowspan="2">PLU</th>
            <th class="tengah" rowspan="2">NAMA BARANG</th>
            <th class="tengah" rowspan="2">KEMASAN</th>
            <th colspan="2">KWANTUM</th>
            <th class="tengah">HARGA SATUAN</th>
            <th class="tengah" rowspan="2">TOTAL NILAI</th>
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
            <td>{{ $d->mstd_prdcd }}</td>
            <td class="left">{{ $d->prd_deskripsipanjang }}</td>
            <td>{{ $d->kemasan }}</td>
            <td>{{ number_format($d->mstd_qty / $d->mstd_frac,0) }}</td>
            <td>{{ $d->mstd_qty % $d->mstd_frac }}</td>
            <td>{{ number_format($d->mstd_hrgsatuan,2) }}</td>
            <td style="text-align: right">{{ number_format($d->mstd_gross,2) }}</td>
            <td>{{ $d->mstd_keterangan }}</td>
        </tr>
        @php $total += $d->mstd_gross; $ppn += $d->mstd_ppnrph;@endphp
        @endforeach
    </tbody>
    <tfoot style="text-align: center">
        <tr>
            <td colspan="6"></td>
            <td style="text-align: left"><strong>TOTAL</strong></td>
            <td style="text-align: right">{{ number_format($total,2) }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td style="text-align: left"><strong>PPN</strong></td>
            <td style="text-align: right">{{ number_format($ppn,2) }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td style="text-align: left"><strong>TOTAL SELURUHNYA</strong></td>
            <td style="text-align: right">{{ number_format($total + $ppn,2) }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>
<table style="width: 100%;font-weight: bold;" class="table-ttd">
    <tr>
        <td>DIBUAT</td>
        <td>DIPERISKA</td>
        <td>MENYETUJUI</td>
        <td>PELAKSANA</td>
        <td>PENERIMA</td>
    </tr>
    <tr class="blank-row">
        <td colspan="5">.</td>
    </tr>
    <tr>
        <td>ADMINISTRASI</td>
        <td>KEPALA GUDANG</td>
        <td>STORE MANAGER</td>
        <td>STOCK CLERK / PETUGAS GUDANG</td>
        <td>CABANG PENERIMA</td>
    </tr>
</table>

<script>
    window.onload = function() {
        window.history.replaceState(null, null, '?');
    }
</script>
@endsection