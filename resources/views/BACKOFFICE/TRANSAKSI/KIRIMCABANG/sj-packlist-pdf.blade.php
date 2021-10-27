@extends('pdf-template')

@section('paper_size','595pt 442pt')

@section('table_font_size','7 px')

@section('page_title')
    Surat Jalan Packlist
@endsection

@section('title')
    SURAT JALAN PACKLIST
@endsection

@section('content')
@if($data)
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
        <td colspan="5"></td>
        <td colspan="2" style="text-align: left"><strong>TOTAL</strong></td>
        <td style="text-align: right">{{ number_format($total,2) }}</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td colspan="2" style="text-align: left"><strong>PPN</strong></td>
        <td style="text-align: right">{{ number_format($ppn,2) }}</td>
        <td></td>
    </tr>
    <tr>
        <td colspan="5"></td>
        <td colspan="2" style="text-align: left"><strong>TOTAL SELURUHNYA</strong></td>
        <td style="text-align: right">{{ number_format($total + $ppn,2) }}</td>
        <td></td>
    </tr>
    </tfoot>
    </table>
    {{--<br>--}}
    {{--<table style="width: 100%; font-weight: bold" class="table-ttd page-break-avoid">--}}
    {{--<tr>--}}
    {{--<td>DIBUAT</td>--}}
    {{--<td>DIPERIKSA</td>--}}
    {{--<td>MENYETUJUI</td>--}}
    {{--<td>PELAKSANA</td>--}}
    {{--<td>PENERIMA</td>--}}
    {{--</tr>--}}
    {{--<tr class="blank-row">--}}
    {{--<td colspan="5">.</td>--}}
    {{--</tr>--}}
    {{--<tr>--}}
    {{--<td>ADMINISTRASI</td>--}}
    {{--<td>KEPALA GUDANG</td>--}}
    {{--<td>STORE MANAGER</td>--}}
    {{--<td>STOCK CLERK / PETUGAS GUDANG</td>--}}
    {{--<td>CABANG PENERIMA</td>--}}
    {{--</tr>--}}
    {{--</table>--}}
    <div class="page-break"></div>
    @endif
    @php
        $temp = $d->msth_nodoc;
        $i = 0;
        $total = 0;
        $ppn = 0;
    @endphp
    <table class="table-borderless table-header">
        <tr style="text-align: left">
            <td>
                Nomor<br>
                Nomor Reff
            </td>
            <td>
                : {{ $d->msth_nodoc }}<br>
                :
            </td>
            <td>
                Tanggal<br>
                Tanggal Reff
            </td>
            <td>
                : {{ $d->msth_tgldoc }}<br>
                :
            </td>
            <td>
                Untuk Cabang<br>
                Gudang
            </td>
            <td>
                : {{ $d->cabang }}<br>
                : {{ $d->gudang }}
            </td>
        </tr>
    </table>
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2" width="1%">NO</th>
            <th class="tengah" rowspan="2" width="6%">PLU</th>
            <th class="tengah" rowspan="2" width="40%">NAMA BARANG</th>
            <th class="tengah" rowspan="2" width="5%">KEMASAN</th>
            <th colspan="2" width="10%">KWANTUM</th>
            <th class="tengah" rowspan="2" width="8%">HARGA SATUAN</th>
            <th class="tengah" rowspan="2" width="8%">TOTAL NILAI</th>
            <th class="tengah" rowspan="2" width="20%">KETERANGAN</th>
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
            <td>{{ $d->mstd_qty / $d->mstd_frac }}</td>
            <td>{{ $d->mstd_qty % $d->mstd_frac }}</td>
            <td style="text-align: right">{{ number_format($d->mstd_hrgsatuan,2) }}</td>
            <td style="text-align: right">{{ number_format($d->mstd_gross,2) }}</td>
            <td>{{ $d->mstd_keterangan }}</td>
        </tr>
        @php
            $total += $d->mstd_gross;
            $ppn += $d->mstd_ppnrph;
        @endphp
        @endforeach
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td colspan="5"></td>
            <td colspan="2" style="text-align: left"><strong>TOTAL</strong></td>
            <td style="text-align: right">{{ number_format($total,2) }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td colspan="2" style="text-align: left"><strong>PPN</strong></td>
            <td style="text-align: right">{{ number_format($ppn,2) }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td colspan="2" style="text-align: left"><strong>TOTAL SELURUHNYA</strong></td>
            <td style="text-align: right">{{ number_format($total + $ppn,2) }}</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
    <br>
    <table style="width: 100%; font-weight: bold" class="table-ttd page-break-avoid">
        <tr>
            <td>DIBUAT</td>
            <td>DIPERIKSA</td>
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
    @else
        <h3 class="center">Data tidak ditemukan!</h3>
    @endif
@endsection
