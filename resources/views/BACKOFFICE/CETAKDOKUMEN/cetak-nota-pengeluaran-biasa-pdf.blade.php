@extends('html-template')

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

@section('custom_style')
    header {
        height: 6cm;
    }
@endsection

@section('content')
    <div style="float:left; margin-top: 0px; line-height: 8px !important;">
        <p>
            NOMOR : {{ $data1[0]->msth_nodoc }}<br>
            TGL NPB : {{ substr($data1[0]->msth_tgldoc,0,10) }}<br>
            FAKTUR PAJAK : {{ $data2[0]->nofp }}<br>
            TGL FP : {{ substr($data2[0]->mstd_date3,0,10) }}
        </p>
    </div>
    <div style="float:right; margin-top: 0px; line-height: 8px !important;">
        <p>
            NOMOR : {{ $data1[0]->msth_nodoc }}<br>
            TGL NPB : {{ substr($data1[0]->msth_tgldoc,0,10) }}<br>
            FAKTUR PAJAK : {{ $data2[0]->nofp }}<br>
            TGL FP : {{ substr($data2[0]->mstd_date3,0,10) }}
        </p>
    </div>

    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">PLU</th>
            <th rowspan="2">NAMA BARANG</th>
            <th rowspan="2">KEMASAN</th>
            <th colspan="2">KWANTUM</th>
            <th rowspan="2">HARGA<br>SATUAN</th>
            <th rowspan="2">TOTAL NILAI</th>
            <th rowspan="2">NO. REF <br> BTB</th>
            <th rowspan="2">KETERANGAN</th>
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

        @if(isset($data1))
            @foreach($data1 as $d)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $d->mstd_prdcd }}</td>
                    <td>{{ $d->prd_deskripsipanjang}}</td>
                    <td>{{ $d->mstd_unit }}</td>
                    <td class="right">{{ $d->ctn }}</td>
                    <td class="right">{{ $d->pcs }}</td>
                    <td class="right">{{ number_format(round($d->mstd_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($d->mstd_gross), 0, '.', ',') }}</td>
                    <td class="right">{{ $d->mstd_noref3 }}</td>
                    <td>{{ $d->mstd_keterangan }}</td>
                </tr>
                @php
                    $i++;
                    $total += $d->total;
                    $gross += $d->mstd_gross;
                    $potongan += $d->mstd_discrph;
                    $ppn += $d->mstd_ppnrph;
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
            <td colspan="6"></td>
            <td style="font-weight: bold">TOTAL HARGA BELI</td>
            <td class="right">{{ number_format(round($gross), 0, '.', ',') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td style="font-weight: bold">TOTAL POTONGAN</td>
            <td class="right">{{ number_format(round($potongan), 0, '.', ',') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td style="font-weight: bold">TOTAL PPN</td>
            <td class="right">{{ number_format(round($ppn), 0, '.', ',') }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td style="font-weight: bold">TOTAL SELURUHNYA</td>
            <td class="right">{{ number_format(round($total), 0, '.', ',') }}</td>
            <td></td>
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
                        <td class="left" colspan="3">&nbsp; MENYETUJUI :</td>
                        <td colspan="4"></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="3">&nbsp; ADMINISTRASI</td>
                        <td class="left" colspan="3">&nbsp; KEPALA GUDANG</td>
                        <td class="left" colspan="4">&nbsp; SUPPLIER</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tfoot>
    </table>
@endsection
