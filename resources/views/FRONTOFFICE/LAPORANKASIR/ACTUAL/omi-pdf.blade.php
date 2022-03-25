@extends('pdf-template')

@section('paper_width','842pt')
@section('paper_height','638pt')

@section('table_font_size','10 px')

@section('page_title')
    Rekap Penjualan OMI - {{ $tanggal }}
@endsection

@section('title')
    ** REKAP PENJUALAN OMI **
@endsection

@section('subtitle')
    Tanggal : {{ $tanggal }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right">No</th>
            <th class="left">Member</th>
            <th class="left">Nama</th>
            <th class="right">Penj. Kotor</th>
            <th class="right">PPN</th>
            <th class="right">Penj. Bersih</th>
            <th class="right">HPP</th>
            <th class="right">Dist. Fee</th>
        </tr>
        </thead>
        <tbody>
        @php
            $kotor = 0;
            $ppn = 0;
            $bersih = 0;
            $hpp = 0;
            $fee = 0;
            $no = 0;
        @endphp
        @if(!$data)
            <tr>
                <td colspan="7">Data tidak ditemukan</td>
            </tr>
        @endif
        @foreach($data as $d)
            @php
                $kotor += $d->grsomi;
                $ppn += $d->ppnomi;
                $bersih += $d->grsomi - $d->ppnomi;
                $hpp += $d->dppomi;
                $fee += $d->dfee;
                $no++;
            @endphp
            <tr>
                <td class="right padding-right">{{ $no }}</td>
                <td class="left">{{ $d->trjd_cus_kodemember }}</td>
                <td class="left">{{ $d->tko_namaomi }}</td>
                <td class="right">{{ number_format($d->grsomi, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->ppnomi, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->grsomi - $d->ppnomi, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->dppomi, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->dfee, 0, '.', ',') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3" class="left">TOTAL :</td>
            <td class="right">{{ number_format($kotor, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($ppn, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($bersih, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($hpp, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($fee, 0, '.', ',') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
