@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    {{ $data[0]->judul }}
@endsection

@section('title')
    {{ $data[0]->judul }}
@endsection

@section('subtitle')
    Tanggal : {{ $date1 }} s/d {{ $date2 }}
@endsection

@section('header_right')
    By Supplier
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah">NO.</th>
            <th rowspan="2" class="tengah">KODE<br>BARANG</th>
            <th rowspan="2" class="tengah left">NAMA BARANG</th>
            <th rowspan="2" class="tengah">TAG</th>
            <th colspan="2">PO</th>
            <th colspan="2">BPB</th>
            <th rowspan="2" class="tengah left">%<br>KUANTUM</th>
            <th rowspan="2" class="tengah left">%<br>NILAI</th>
        </tr>
        <tr>
            <th>KUANTUM</th>
            <th>NILAI</th>
            <th>KUANTUM</th>
            <th>NILAI</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempSup = null;
            $i = 1;
            $poKuan = 0;
            $poNilai = 0;
            $bpbKuan = 0;
            $bpbNilai = 0;

            $totPoKuan = 0;
            $totPoNilai = 0;
            $totBpbKuan = 0;
            $totBpbNilai = 0;

            $qtypoouts = 0;
            $rphpoouts = 0;

            $totQty = 0;
            $totRph = 0;
        @endphp
        @foreach($data as $d)
            @if($tempSup != $d->tpoh_kodesupplier)
                @if($tempSup != null)
                    <tr>
                        <td></td>
                        <td colspan="3" class="left">Total Per Supplier : </td>
                        <td class="right">{{ number_format($poKuan) }}</td>
                        <td class="right">{{ number_format($poNilai) }}</td>
                        <td class="right">{{ number_format($bpbKuan) }}</td>
                        <td class="right">{{ number_format($bpbNilai) }}</td>
                        <td class="right">
                            @if($bpbKuan != 0 && $poKuan != 0)
                                {{ number_format(($bpbKuan / ($poKuan - $qtypoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="right">
                            @if($bpbNilai != 0 && $poNilai != 0)
                                {{ number_format(($bpbNilai / ($poNilai - $rphpoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                @endif
                @php
                    $tempSup = $d->tpoh_kodesupplier;
                    $i = 1;

                    $totPoKuan += $poKuan;
                    $totPoNilai += $poNilai;
                    $totBpbKuan += $bpbKuan;
                    $totBpbNilai += $bpbNilai;

                    $poKuan = 0;
                    $poNilai = 0;
                    $bpbKuan = 0;
                    $bpbNilai = 0;

                    $qtypoouts = 0;
                    $rphpoouts = 0;
                @endphp
                <tr>
                    <td colspan="10" class="left">SUPPLIER : {{ $d->tpoh_kodesupplier }} - {{ $d->sup_namasupplier }}</td>
                </tr>
            @endif
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $d->tpod_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td>{{ $d->prd_kodetag }}</td>
                <td class="right">{{ number_format($d->qtypo) }}</td>
                <td class="right">{{ number_format($d->nilaia) }}</td>
                <td class="right">{{ number_format($d->kuanb) }}</td>
                <td class="right">{{ number_format($d->nilaib) }}</td>
                <td class="right">
                    @if($d->qtypo != 0 && $d->kuanb != 0)
                        {{ number_format(($d->kuanb / ($d->qtypo - $d->qty_po_outs)) * 100) }}
                    @else
                        0
                    @endif
                </td>
                <td class="right">
                    @if($d->nilaib != 0 && $d->nilaia != 0)
                        {{ number_format(($d->nilaib / ($d->nilaia - $d->rph_po_outs)) * 100) }}
                    @else
                        0
                    @endif
                </td>
            </tr>
            @php
                $poKuan += $d->qtypo;
                $poNilai += $d->nilaia;
                $bpbKuan += $d->kuanb;
                $bpbNilai += $d->nilaib;

                $qtypoouts += $d->qty_po_outs;
                $rphpoouts += $d->rph_po_outs;

                $totQty += $d->qty_po_outs;
                $totRph += $d->rph_po_outs;
            @endphp
        @endforeach
        @php
            $totPoKuan += $poKuan;
            $totPoNilai += $poNilai;
            $totBpbKuan += $bpbKuan;
            $totBpbNilai += $bpbNilai;
        @endphp
            <tr>
                <td></td>
                <td colspan="3" class="left">Total Per Supplier : </td>
                <td class="right">{{ number_format($poKuan) }}</td>
                <td class="right">{{ number_format($poNilai) }}</td>
                <td class="right">{{ number_format($bpbKuan) }}</td>
                <td class="right">{{ number_format($bpbNilai) }}</td>
                <td class="right">
                    @if($d->qtypo != 0 && $d->kuanb != 0)
                        {{ number_format(($d->kuanb / ($d->qtypo - $d->qty_po_outs)) * 100) }}
                    @else
                        0
                    @endif
                </td>
                <td class="right">
                    @if($d->nilaib != 0 && $d->nilaia != 0)
                        {{ number_format(($d->nilaib / ($d->nilaia - $d->rph_po_outs)) * 100) }}
                    @else
                        0
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="4" class="left">Grand Total : </td>
                <td class="right">{{ number_format($totPoKuan) }}</td>
                <td class="right">{{ number_format($totPoNilai) }}</td>
                <td class="right">{{ number_format($totBpbKuan) }}</td>
                <td class="right">{{ number_format($totBpbNilai) }}</td>
                <td class="right">
                    @if($totPoKuan != 0 && $totBpbKuan != 0)
                        {{ number_format(($totBpbKuan / ($totPoKuan - $totQty)) * 100) }}
                    @else
                        0
                    @endif
                </td>
                <td class="right">
                    @if($totBpbNilai != 0 && $totPoNilai != 0)
                        {{ number_format(($totBpbNilai / ($totPoNilai - $totRph)) * 100) }}
                    @else
                        0
                    @endif
                </td>
            </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
