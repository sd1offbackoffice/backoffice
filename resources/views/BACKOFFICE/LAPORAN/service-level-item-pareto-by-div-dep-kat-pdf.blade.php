@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    SERVICE LEVEL ITEM PARETO
@endsection

@section('title')
    ** SERVICE LEVEL ITEM PARETO **
@endsection

@section('subtitle')
    Tanggal : {{ $date1 }} s/d {{ $date2 }}
@endsection

@section('header_left')
    Kode Monitoring : {{ $p_kdmon }} - {{ $p_nmon }}
@endsection

@section('header_right')
    By Div Dep Kat
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
            $div= null;
            $dep = null;
            $kat = null;

            $divPOkuan = 0;
            $divPOnilai = 0;
            $depPOkuan = 0;
            $depPOnilai = 0;
            $katPOkuan = 0;
            $katPOnilai = 0;

            $divBPBkuan = 0;
            $divBPBnilai = 0;
            $depBPBkuan = 0;
            $depBPBnilai = 0;
            $katBPBkuan = 0;
            $katBPBnilai = 0;

            $divPRSkuan = 0;
            $divPRSnilai = 0;
            $depPRSkuan = 0;
            $depPRSnilai = 0;
            $katPRSkuan = 0;
            $katPRSnilai = 0;

            $i = 1;

            $totPOkuan = 0;
            $totPOnilai = 0;
            $totBPBkuan = 0;
            $totBPBnilai = 0;

            $qtypoouts = 0;
            $rphpoouts = 0;

            $totQty = 0;
            $totRph = 0;
        @endphp
        @foreach($data as $d)
            @if($div != $d->tpod_kodedivisi)
                @if($div != null)
                    <tr>
                        <td colspan="4" class="left"style="padding-left: 20px">Total Per Kategori :</td>
                        <td class="right">{{ number_format($katPOkuan) }}</td>
                        <td class="right">{{ number_format($katPOnilai) }}</td>
                        <td class="right">{{ number_format($katBPBkuan) }}</td>
                        <td class="right">{{ number_format($katBPBnilai) }}</td>
                        <td class="right">
                            @if($katPOkuan != 0 && $katBPBkuan != 0)
                                {{ number_format(($katBPBkuan / ($katPOkuan - $qtypoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="right">
                            @if($katPOnilai != 0 && $katBPBnilai != 0)
                                {{ number_format(($katBPBnilai / ($katPOnilai - $rphpoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="left" style="padding-left: 10px">Total Per Departemen :</td>
                        <td class="right">{{ number_format($depPOkuan) }}</td>
                        <td class="right">{{ number_format($depPOnilai) }}</td>
                        <td class="right">{{ number_format($depBPBkuan) }}</td>
                        <td class="right">{{ number_format($depBPBnilai) }}</td>
                        <td class="right">
                            @if($depPOkuan != 0 && $depBPBkuan != 0)
                                {{ number_format(($depBPBkuan / ($depPOkuan - $qtypoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="right">
                            @if($depPOnilai != 0 && $depBPBnilai != 0)
                                {{ number_format(($depBPBnilai / ($depPOnilai - $rphpoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                    <tr style="border-bottom: 1px solid black">
                        <td colspan="4" class="left">Total Per Divisi :</td>
                        <td class="right">{{ number_format($divPOkuan) }}</td>
                        <td class="right">{{ number_format($divPOnilai) }}</td>
                        <td class="right">{{ number_format($divBPBkuan) }}</td>
                        <td class="right">{{ number_format($divBPBnilai) }}</td>
                        <td class="right">
                            @if($divPOkuan != 0 && $divBPBkuan != 0)
                                {{ number_format(($divBPBkuan / ($divPOkuan - $qtypoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="right">
                            @if($divPOnilai != 0 && $divBPBnilai != 0)
                                {{ number_format(($divBPBnilai / ($divPOnilai - $rphpoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                @endif
                @php
                    $div = $d->tpod_kodedivisi;
                    $kat = $d->tpod_kodedepartemen;
                    $dep = $d->tpod_kategoribarang;

                    $divPOkuan = 0;
                    $divPOnilai = 0;
                    $depPOkuan = 0;
                    $depPOnilai = 0;
                    $katPOkuan = 0;
                    $katPOnilai = 0;

                    $divBPBkuan = 0;
                    $divBPBnilai = 0;
                    $depBPBkuan = 0;
                    $depBPBnilai = 0;
                    $katBPBkuan = 0;
                    $katBPBnilai = 0;

                    $divQty = 0;
                    $divRph = 0;
                    $depQty = 0;
                    $depRph = 0;
                    $katQty = 0;
                    $katRph = 0;
                @endphp
                <tr>
                    <td colspan="10" class="left">DIVISI : {{ $d->tpod_kodedivisi }} - {{ $d->div_namadivisi }}</td>
                </tr>
                <tr>
                    <td colspan="10" class="left" style="padding-left: 10px">DEPARTEMEN : {{ $d->tpod_kodedepartemen }} - {{ $d->dep_namadepartement }}</td>
                </tr>
                <tr>
                    <td colspan="10" class="left" style="padding-left: 20px">KATEGORI : {{ $d->tpod_kategoribarang }} - {{ $d->kat_namakategori }}</td>
                </tr>
            @elseif($dep != $d->tpod_kodedepartemen)
                @if($dep != null)
                    <tr>
                        <td colspan="4" class="left"style="padding-left: 20px">Total Per Kategori :</td>
                        <td class="right">{{ number_format($katPOkuan) }}</td>
                        <td class="right">{{ number_format($katPOnilai) }}</td>
                        <td class="right">{{ number_format($katBPBkuan) }}</td>
                        <td class="right">{{ number_format($katBPBnilai) }}</td>
                        <td class="right">
                            @if($katPOkuan != 0 && $katBPBkuan != 0)
                                {{ number_format(($katBPBkuan / ($katPOkuan - $qtypoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="right">
                            @if($katPOnilai != 0 && $katBPBnilai != 0)
                                {{ number_format(($katBPBnilai / ($katPOnilai - $rphpoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="left" style="padding-left: 10px">Total Per Departemen :</td>
                        <td class="right">{{ number_format($depPOkuan) }}</td>
                        <td class="right">{{ number_format($depPOnilai) }}</td>
                        <td class="right">{{ number_format($depBPBkuan) }}</td>
                        <td class="right">{{ number_format($depBPBnilai) }}</td>
                        <td class="right">
                            @if($depPOkuan != 0 && $depBPBkuan != 0)
                                {{ number_format(($depBPBkuan / ($depPOkuan - $qtypoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="right">
                            @if($depPOnilai != 0 && $depBPBnilai != 0)
                                {{ number_format(($depBPBnilai / ($depPOnilai - $rphpoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                @endif
                @php
                    $kat = $d->tpod_kodedepartemen;
                    $dep = $d->tpod_kategoribarang;

                    $depPOkuan = 0;
                    $depPOnilai = 0;
                    $katPOkuan = 0;
                    $katPOnilai = 0;

                    $depBPBkuan = 0;
                    $depBPBnilai = 0;
                    $katBPBkuan = 0;
                    $katBPBnilai = 0;

                    $depQty = 0;
                    $depRph = 0;
                    $katQty = 0;
                    $katRph = 0;
                @endphp
                <tr>
                    <td colspan="10" class="left" style="padding-left: 10px">DEPARTEMEN : {{ $d->tpod_kodedepartemen }} - {{ $d->dep_namadepartement }}</td>
                </tr>
                <tr>
                    <td colspan="10" class="left" style="padding-left: 20px">KATEGORI : {{ $d->tpod_kategoribarang }} - {{ $d->kat_namakategori }}</td>
                </tr>
            @elseif($kat != $d->tpod_kategoribarang)
                @if($kat != null)
                    <tr>
                        <td colspan="4" class="left"style="padding-left: 20px">Total Per Kategori :</td>
                        <td class="right">{{ number_format($katPOkuan) }}</td>
                        <td class="right">{{ number_format($katPOnilai) }}</td>
                        <td class="right">{{ number_format($katBPBkuan) }}</td>
                        <td class="right">{{ number_format($katBPBnilai) }}</td>
                        <td class="right">
                            @if($katPOkuan != 0 && $katBPBkuan != 0)
                                {{ number_format(($katBPBkuan / ($katPOkuan - $qtypoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                        <td class="right">
                            @if($katPOnilai != 0 && $katBPBnilai != 0)
                                {{ number_format(($katBPBnilai / ($katPOnilai - $rphpoouts)) * 100) }}
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                @endif
                @php
                    $kat = $d->tpod_kodedepartemen;

                    $katPOkuan = 0;
                    $katPOnilai = 0;

                    $katBPBkuan = 0;
                    $katBPBnilai = 0;

                    $katQty = 0;
                    $katRph = 0;
                @endphp
                <tr>
                    <td colspan="10" class="left" style="padding-left: 20px">KATEGORI : {{ $d->tpod_kategoribarang }} - {{ $d->kat_namakategori }}</td>
                </tr>
            @endif
            <tr>
                <td class="left">{{ $i++ }}</td>
                <td class="center">{{ $d->tpod_prdcd }}</td>
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
                $divPOkuan += $d->qtypo;
                $divPOnilai += $d->nilaia;
                $depPOkuan += $d->qtypo;
                $depPOnilai += $d->nilaia;
                $katPOkuan += $d->qtypo;
                $katPOnilai += $d->nilaia;

                $divBPBkuan += $d->kuanb;
                $divBPBnilai += $d->nilaib;
                $depBPBkuan += $d->kuanb;
                $depBPBnilai += $d->nilaib;
                $katBPBkuan += $d->kuanb;
                $katBPBnilai += $d->nilaib;

                $divPRSkuan = 0;
                $divPRSnilai = 0;
                $depPRSkuan = 0;
                $depPRSnilai = 0;
                $katPRSkuan = 0;
                $katPRSnilai = 0;

                $totPOkuan += $d->qtypo;
                $totPOnilai += $d->nilaia;
                $totBPBkuan += $d->kuanb;
                $totBPBnilai += $d->nilaib;

                $divQty += $d->qty_po_outs;
                $divRph += $d->rph_po_outs;
                $depQty += $d->qty_po_outs;
                $depRph += $d->rph_po_outs;
                $katQty += $d->qty_po_outs;
                $katRph += $d->rph_po_outs;

                $totQty += $d->qty_po_outs;
                $totRph += $d->rph_po_outs;
            @endphp
        @endforeach
            <tr>
                <td colspan="4" class="left"style="padding-left: 20px">Total Per Kategori :</td>
                <td class="right">{{ number_format($katPOkuan) }}</td>
                <td class="right">{{ number_format($katPOnilai) }}</td>
                <td class="right">{{ number_format($katBPBkuan) }}</td>
                <td class="right">{{ number_format($katBPBnilai) }}</td>
                <td class="right">
                    @if($katPOkuan != 0 && $katBPBkuan != 0)
                        {{ number_format(($katBPBkuan / ($katPOkuan - $qtypoouts)) * 100) }}
                    @else
                        0
                    @endif
                </td>
                <td class="right">
                    @if($katPOnilai != 0 && $katBPBnilai != 0)
                        {{ number_format(($katBPBnilai / ($katPOnilai - $rphpoouts)) * 100) }}
                    @else
                        0
                    @endif
                </td>
            </tr>
            <tr>
                <td colspan="4" class="left" style="padding-left: 10px">Total Per Departemen :</td>
                <td class="right">{{ number_format($depPOkuan) }}</td>
                <td class="right">{{ number_format($depPOnilai) }}</td>
                <td class="right">{{ number_format($depBPBkuan) }}</td>
                <td class="right">{{ number_format($depBPBnilai) }}</td>
                <td class="right">
                    @if($depPOkuan != 0 && $depBPBkuan != 0)
                        {{ number_format(($depBPBkuan / ($depPOkuan - $qtypoouts)) * 100) }}
                    @else
                        0
                    @endif
                </td>
                <td class="right">
                    @if($depPOnilai != 0 && $depBPBnilai != 0)
                        {{ number_format(($depBPBnilai / ($depPOnilai - $rphpoouts)) * 100) }}
                    @else
                        0
                    @endif
                </td>
            </tr>
            <tr style="border-bottom: 1px solid black">
                <td colspan="4" class="left">Total Per Divisi :</td>
                <td class="right">{{ number_format($divPOkuan) }}</td>
                <td class="right">{{ number_format($divPOnilai) }}</td>
                <td class="right">{{ number_format($divBPBkuan) }}</td>
                <td class="right">{{ number_format($divBPBnilai) }}</td>
                <td class="right">
                    @if($divPOkuan != 0 && $divBPBkuan != 0)
                        {{ number_format(($divBPBkuan / ($divPOkuan - $qtypoouts)) * 100) }}
                    @else
                        0
                    @endif
                </td>
                <td class="right">
                    @if($divPOnilai != 0 && $divBPBnilai != 0)
                        {{ number_format(($divBPBnilai / ($divPOnilai - $rphpoouts)) * 100) }}
                    @else
                        0
                    @endif
                </td>
            </tr>
            <tr style="border-top: 1px solid black">
                <td colspan="4" class="left">Grand Total :</td>
                <td class="right">{{ number_format($totPOkuan) }}</td>
                <td class="right">{{ number_format($totPOnilai) }}</td>
                <td class="right">{{ number_format($totBPBkuan) }}</td>
                <td class="right">{{ number_format($totBPBnilai) }}</td>
                <td class="right">
                    @if($totPOkuan != 0 && $totBPBkuan != 0)
                        {{ number_format(($totBPBkuan / ($totPOkuan - $totQty)) * 100) }}
                    @else
                        0
                    @endif
                </td>
                <td class="right">
                    @if($totPOnilai != 0 && $totBPBnilai != 0)
                        {{ number_format(($totBPBnilai / ($totPOnilai - $totRph)) * 100) }}
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
