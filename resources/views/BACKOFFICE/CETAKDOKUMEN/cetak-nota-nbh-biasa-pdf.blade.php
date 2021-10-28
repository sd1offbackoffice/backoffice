@extends('pdf-template')

@if($jnskertas == 'K')
    @section('paper_size', '595pt 442pt')
@endif

@section('table_font_size','7 px')

@section('page_title')
    {{ strtoupper($data1[0]->judul) }}
@endsection

@section('title')
    NOTA PENGELUARAN BARANG
@endsection

@section('subtitle')
    {{ strtoupper($data1[0]->judul) }}
@endsection

@section('header_left')
    <p>
        <b>{{ $data1[0]->status }}</b>
    </p>
@endsection

@section('content')
    <table>
        <tbody>
            <tr>
                <td>NOMOR : {{ $data1[0]->msth_nodoc }}</td>
                <td>TANGGAL : {{ substr($data1[0]->msth_tgldoc,0,10) }}</td>
            </tr>
            <tr>
                <td>NO. REF : {{ $data1[0]->msth_nopo }}</td>
                <td>TGL. REF : {{ substr($data1[0]->msth_tglpo,0,10) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">PLU</th>
            <th rowspan="2">NAMA BARANG</th>
            <th colspan="2">KEMASAN</th>
            <th colspan="2">KWANTUM</th>
            <th rowspan="2">HARGA<br>SATUAN</th>
            <th rowspan="2">TOTAL</th>
            <th rowspan="2">KETERANGAN</th>
        </tr>
        <tr>
            <th>UNIT</th>
            <th>FRAC</th>
            <th>CTN</th>
            <th>PCs</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total = 0;
            $i=1;
        @endphp

        @if(sizeof($data1)!=0)
            @foreach($data1 as $d)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $d->mstd_prdcd }}</td>
                    <td>{{ $d->prd_deskripsipanjang}}</td>
                    <td>{{ $d->mstd_unit }}</td>
                    <td class="right">{{ $d->mstd_frac }}</td>
                    <td class="right">{{ $d->ctn }}</td>
                    <td class="right">{{ $d->pcs }}</td>
                    <td class="right">{{ number_format(round($d->mstd_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($d->total), 0, '.', ',') }}</td>
                    <td>{{ $d->mstd_keterangan }}</td>
                </tr>
                @php
                    $i++;
                    $total += $d->total;
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
            <td colspan="7"></td>
            <td style="font-weight: bold">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format(round($total), 0, '.', ',') }}</td>
            <td></td>
        </tr>
        <tr>
            <td colspan="10">
                <table class="table" border="1">
                    <thead>
                    </thead>
                    <tbody>
                    <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
                        <td class="left" colspan="3">&nbsp; DIBUAT <br><br><br></td>
                        <td class="left" colspan="3">&nbsp; DIPERIKSA :</td>
                        <td class="left" colspan="4">&nbsp; MENYETUJUI :</td>
                        <td class="left" colspan="4">&nbsp; PELAKSANA :</td>
                    </tr>
                    <tr>
                        <td class="left" colspan="3">&nbsp; ADMINISTRASI</td>
                        <td class="left" colspan="3">&nbsp; KEPALA GUDANG</td>
                        <td class="left" colspan="4">&nbsp; STORE MANAGER</td>
                        <td class="left" colspan="4">&nbsp; STOCK CLERK / PETUGAS GUDANG</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tfoot>
    </table>
@endsection
