@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN HISTORY HARGA
@endsection

@section('title')
    ** LAPORAN HISTORY HARGA **
@endsection

@section('subtitle')
    Kode PLU : {{ $plu1 }} s/d {{ $plu2 }} Dari Tgl. {{ $tgl1 }} s/d {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="">TANGGAL</th>
            <th class="left">NO. BPB<th>
            <th class="right">COST LAMA</th>
            <th class="right">COST BARU</th>
            <th class="right">SISA STOK</th>
            <th class="right">L.COST LAMA</th>
            <th class="right">L.COST BARU</th>
            <th class="">TGL UPDATE</th>
            <th class="">JAM UPDATE</th>
            <th class="">USER</th>
        </tr>
        </thead>
        <tbody>
        @php $plu = null; @endphp
        @foreach($data as $d)
            @if($plu != $d->hcs_prdcd)
                @php $plu = $d->hcs_prdcd; @endphp
                <tr>
                    <td colspan="10" class="left"><strong>{{ $d->hcs_prdcd }} {{ $d->prd_deskripsipanjang }}</strong></td>
                </tr>
            @endif
            <tr>
                <td class="">{{ $d->hcs_tglbpb }}</td>
                <td class="left ">{{ $d->hcs_nodocbpb }}<th>
                <td class="right">{{ number_format($d->hcs_avglama, 2) }}</td>
                <td class="right">{{ number_format($d->hcs_avgbaru, 2) }}</td>
                <td class="right">{{ number_format($d->hcs_lastqty, 2) }}</td>
                <td class="right">{{ number_format($d->hcs_lastcostlama, 2) }}</td>
                <td class="right">{{ number_format($d->hcs_lastcostbaru, 2) }}</td>
                <td class="">{{ $d->tgl_upd }}</td>
                <td class="">{{ $d->jam_upd }}</td>
                <td class="">{{ $d->usr }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
