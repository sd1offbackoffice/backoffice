@extends('html-template')

@section('table_font_size','7 px')
@section('paper_width','655pt')

@section('page_title')
    SERVICE LEVEL PO TERHADAP BPB / DIV / DEPT / KATB
@endsection

@section('title')
    ** SERVICE LEVEL PO TERHADAP BPB / DIV / DEPT / KATB **
@endsection

@section('subtitle')
    Tanggal {{ $tgl1 }} s/d {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah left padding-right" rowspan="2">NO</th>
            <th class="tengah center" rowspan="2">KAT</th>
            <th class="tengah left" rowspan="2">KODE<br>BARANG</th>
            <th class="tengah left" rowspan="2">NAMA<br>BARANG</th>
            <th class="tengah center" rowspan="2">TAG</th>
            <th class="" colspan="2">PO</th>
            <th class="" colspan="2">BPB</th>
            <th class="" colspan="2">PO OUTSTANDING</th>
            <th class="tengah center padding-right" rowspan="2">%<br>KUANTUM</th>
            <th class="tengah center" rowspan="2">%<br>NILAI</th>
        </tr>
        <tr>
            <th class="right padding-right">KUANTUM</th>
            <th class="right padding-right">NILAI</th>
            <th class="right padding-right">KUANTUM</th>
            <th class="right padding-right">NILAI</th>
            <th class="right padding-right">KUANTUM</th>
            <th class="right padding-right">NILAI</th>
        </tr>
        </thead>
        <tbody>
        @php
            $i=1;

            $tempKat = null;
            $tempDep = null;
            $tempDiv = null;

            $totKatPOQTY = 0;
            $totKatPONilai = 0;
            $totKatBPBQTY = 0;
            $totKatBPBNilai = 0;
            $totKatPOOUTQTY = 0;
            $totKatPOOUTNilai = 0;
            $totKatKuantum = 0;
            $totKatNilai = 0;

            $totDepPOQTY = 0;
            $totDepPONilai = 0;
            $totDepBPBQTY = 0;
            $totDepBPBNilai = 0;
            $totDepPOOUTQTY = 0;
            $totDepPOOUTNilai = 0;
            $totDepKuantum = 0;
            $totDepNilai = 0;

            $totDivPOQTY = 0;
            $totDivPONilai = 0;
            $totDivBPBQTY = 0;
            $totDivBPBNilai = 0;
            $totDivPOOUTQTY = 0;
            $totDivPOOUTNilai = 0;
            $totDivKuantum = 0;
            $totDivNilai = 0;

            $totPOQTY = 0;
            $totPONilai = 0;
            $totBPBQTY = 0;
            $totBPBNilai = 0;
            $totPOOUTQTY = 0;
            $totPOOUTNilai = 0;
            $totKuantum = 0;
            $totNilai = 0;
        @endphp
        @foreach($data as $d)
            @if($tempDiv != $d->tpod_kodedivisi)
                @if($tempDiv != null)
                    <tr class="bold">
                        <td class="left" colspan="5">Total Per Kategori :</td>
                        <td class="right padding-right">{{ number_format($totKatPOQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatPONilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatBPBQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatBPBNilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatPOOUTQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatPOOUTNilai,0) }}</td>
                        @php
                            if($totKatPOQTY != 0 && $totKatBPBQTY != 0)
                                $totKatKuantum = ($totKatBPBQTY / ($totKatPOQTY - $totKatPOOUTQTY)) * 100;
                            else $totKatKuantum = 0;

                            if($totKatPONilai != 0 && $totKatBPBNilai != 0)
                                $totKatNilai = ($totKatBPBNilai / ($totKatPONilai - $totKatPOOUTNilai)) * 100;
                            else $totKatNilai = 0;
                        @endphp
                        <td class="right padding-right">{{ number_format($totKatKuantum,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatNilai,0) }}</td>
                    </tr>
                    <tr class="bold">
                        <td class="left" colspan="5">Total Per Departement :</td>
                        <td class="right padding-right">{{ number_format($totDepPOQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepPONilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepBPBQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepBPBNilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepPOOUTQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepPOOUTNilai,0) }}</td>
                        @php
                            if($totDepPOQTY != 0 && $totDepBPBQTY != 0)
                                $totDepKuantum = ($totDepBPBQTY / ($totDepPOQTY - $totDepPOOUTQTY)) * 100;
                            else $totDepKuantum = 0;

                            if($totDepPONilai != 0 && $totDepBPBNilai != 0)
                                $totDepNilai = ($totDepBPBNilai / ($totDepPONilai - $totDepPOOUTNilai)) * 100;
                            else $totDepNilai = 0;
                        @endphp
                        <td class="right padding-right">{{ number_format($totDepKuantum,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepNilai,0) }}</td>
                    </tr>
                    <tr class="bold">
                        <td class="left" colspan="5">Total Per Divisi :</td>
                        <td class="right padding-right">{{ number_format($totDivPOQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDivPONilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDivBPBQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDivBPBNilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDivPOOUTQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDivPOOUTNilai,0) }}</td>
                        @php
                            if($totDivPOQTY != 0 && $totDivBPBQTY != 0)
                                $totDivKuantum = ($totDivBPBQTY / ($totDivPOQTY - $totDivPOOUTQTY)) * 100;
                            else $totDivKuantum = 0;

                            if($totDivPONilai != 0 && $totDivBPBNilai != 0)
                                $totDivNilai = ($totDivBPBNilai / ($totDivPONilai - $totDivPOOUTNilai)) * 100;
                            else $totDivNilai = 0;
                        @endphp
                        <td class="right padding-right">{{ number_format($totDivKuantum,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDivNilai,0) }}</td>
                    </tr>
                @endif
                <tr class="bold">
                    <td class="left" colspan="13">DIVISI : {{ $d->tpod_kodedivisi }} - {{ $d->div_namadivisi }}</td>
                </tr>
                @php
                    $tempDiv = $d->tpod_kodedivisi;

                    $totDivPOQTY = 0;
                    $totDivPONilai = 0;
                    $totDivBPBQTY = 0;
                    $totDivBPBNilai = 0;
                    $totDivPOOUTQTY = 0;
                    $totDivPOOUTNilai = 0;
                    $totDivKuantum = 0;
                    $totDivNilai = 0;

                    $tempDep = '';

                    $totDepPOQTY = 0;
                    $totDepPONilai = 0;
                    $totDepBPBQTY = 0;
                    $totDepBPBNilai = 0;
                    $totDepPOOUTQTY = 0;
                    $totDepPOOUTNilai = 0;
                    $totDepKuantum = 0;
                    $totDepNilai = 0;

                    $tempKat = '';

                    $totKatPOQTY = 0;
                    $totKatPONilai = 0;
                    $totKatBPBQTY = 0;
                    $totKatBPBNilai = 0;
                    $totKatPOOUTQTY = 0;
                    $totKatPOOUTNilai = 0;
                    $totKatKuantum = 0;
                    $totKatNilai = 0;
                @endphp
            @endif
            @if($tempDep != $d->tpod_kodedepartemen)
                @if($tempDep != null)
                    <tr class="bold">
                        <td class="left" colspan="5">Total Per Kategori :</td>
                        <td class="right padding-right">{{ number_format($totKatPOQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatPONilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatBPBQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatBPBNilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatPOOUTQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatPOOUTNilai,0) }}</td>
                        @php
                            if($totKatPOQTY != 0 && $totKatBPBQTY != 0)
                                $totKatKuantum = ($totKatBPBQTY / ($totKatPOQTY - $totKatPOOUTQTY)) * 100;
                            else $totKatKuantum = 0;

                            if($totKatPONilai != 0 && $totKatBPBNilai != 0)
                                $totKatNilai = ($totKatBPBNilai / ($totKatPONilai - $totKatPOOUTNilai)) * 100;
                            else $totKatNilai = 0;
                        @endphp
                        <td class="right padding-right">{{ number_format($totKatKuantum,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatNilai,0) }}</td>
                    </tr>
                    <tr class="bold">
                        <td class="left" colspan="5">Total Per Departement :</td>
                        <td class="right padding-right">{{ number_format($totDepPOQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepPONilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepBPBQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepBPBNilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepPOOUTQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepPOOUTNilai,0) }}</td>
                        @php
                            if($totDepPOQTY != 0 && $totDepBPBQTY != 0)
                                $totDepKuantum = ($totDepBPBQTY / ($totDepPOQTY - $totDepPOOUTQTY)) * 100;
                            else $totDepKuantum = 0;

                            if($totDepPONilai != 0 && $totDepBPBNilai != 0)
                                $totDepNilai = ($totDepBPBNilai / ($totDepPONilai - $totDepPOOUTNilai)) * 100;
                            else $totDepNilai = 0;
                        @endphp
                        <td class="right padding-right">{{ number_format($totDepKuantum,0) }}</td>
                        <td class="right padding-right">{{ number_format($totDepNilai,0) }}</td>
                    </tr>
                @endif
                <tr class="bold">
                    <td class="left" colspan="13">DEPARTEMEN : {{ $d->tpod_kodedepartemen }} - {{ $d->dep_namadepartement }}</td>
                </tr>
                @php
                    $tempDep = $d->tpod_kodedepartemen;

                    $totDepPOQTY = 0;
                    $totDepPONilai = 0;
                    $totDepBPBQTY = 0;
                    $totDepBPBNilai = 0;
                    $totDepPOOUTQTY = 0;
                    $totDepPOOUTNilai = 0;
                    $totDepKuantum = 0;
                    $totDepNilai = 0;

                    $tempKat = '';

                    $totKatPOQTY = 0;
                    $totKatPONilai = 0;
                    $totKatBPBQTY = 0;
                    $totKatBPBNilai = 0;
                    $totKatPOOUTQTY = 0;
                    $totKatPOOUTNilai = 0;
                    $totKatKuantum = 0;
                    $totKatNilai = 0;
                @endphp
            @endif
            @if($tempKat != $d->tpod_kategoribarang)
                @if($tempKat != null)
                    <tr class="bold">
                        <td class="left" colspan="5">Total Per Kategori :</td>
                        <td class="right padding-right">{{ number_format($totKatPOQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatPONilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatBPBQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatBPBNilai,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatPOOUTQTY,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatPOOUTNilai,0) }}</td>
                        @php
                            if($totKatPOQTY != 0 && $totKatBPBQTY != 0)
                                $totKatKuantum = ($totKatBPBQTY / ($totKatPOQTY - $totKatPOOUTQTY)) * 100;
                            else $totKatKuantum = 0;

                            if($totKatPONilai != 0 && $totKatBPBNilai != 0)
                                $totKatNilai = ($totKatBPBNilai / ($totKatPONilai - $totKatPOOUTNilai)) * 100;
                            else $totKatNilai = 0;
                        @endphp
                        <td class="right padding-right">{{ number_format($totKatKuantum,0) }}</td>
                        <td class="right padding-right">{{ number_format($totKatNilai,0) }}</td>
                    </tr>
                @endif
                <tr class="bold">
                    <td class="left" colspan="13">KATEGORI : {{ $d->tpod_kategoribarang }} - {{ $d->kat_namakategori }}</td>
                </tr>
                @php
                    $tempKat = $d->tpod_kategoribarang;

                    $totKatPOQTY = 0;
                    $totKatPONilai = 0;
                    $totKatBPBQTY = 0;
                    $totKatBPBNilai = 0;
                    $totKatPOOUTQTY = 0;
                    $totKatPOOUTNilai = 0;
                    $totKatKuantum = 0;
                    $totKatNilai = 0;
                @endphp
            @endif
            <tr>
                <td class="left">{{ $i++ }}</td>
                <td class="center">{{ $d->tpod_kategoribarang }}</td>
                <td class="center">{{ $d->tpod_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td class="center">{{ $d->prd_kodetag }}</td>
                <td class="right padding-right">{{ number_format($d->qtypo,0) }}</td>
                <td class="right padding-right">{{ number_format($d->nilaia,0) }}</td>
                <td class="right padding-right">{{ number_format($d->kuanb,0) }}</td>
                <td class="right padding-right">{{ number_format($d->nilaib,0) }}</td>
                <td class="right padding-right">{{ number_format($d->qty_po_outs,0) }}</td>
                <td class="right padding-right">{{ number_format($d->rph_po_outs,0) }}</td>

                @php
                    if($d->qtypo != 0 && $d->kuanb != 0)
                        $prskuan = ($d->kuanb / ($d->qtypo - $d->qty_po_outs)) * 100;
                    else $prskuan = 0;

                    if($d->nilaia != 0 && $d->nilaib != 0)
                        $prsnilai = ($d->nilaib / ($d->nilaia - $d->rph_po_outs)) * 100;
                    else $prsnilai = 0;
                @endphp

                <td class="right padding-right">{{ number_format($prskuan, 0) }}</td>
                <td class="right padding-right">{{ number_format($prsnilai, 0) }}</td>
            </tr>

            @php
                $totKatPOQTY += $d->qtypo;
                $totKatPONilai += $d->nilaia;
                $totKatBPBQTY += $d->kuanb;
                $totKatBPBNilai += $d->nilaib;
                $totKatPOOUTQTY += $d->qty_po_outs;
                $totKatPOOUTNilai += $d->rph_po_outs;

                $totDepPOQTY += $d->qtypo;
                $totDepPONilai += $d->nilaia;
                $totDepBPBQTY += $d->kuanb;
                $totDepBPBNilai += $d->nilaib;
                $totDepPOOUTQTY += $d->qty_po_outs;
                $totDepPOOUTNilai += $d->rph_po_outs;

                $totDivPOQTY += $d->qtypo;
                $totDivPONilai += $d->nilaia;
                $totDivBPBQTY += $d->kuanb;
                $totDivBPBNilai += $d->nilaib;
                $totDivPOOUTQTY += $d->qty_po_outs;
                $totDivPOOUTNilai += $d->rph_po_outs;

                $totPOQTY += $d->qtypo;
                $totPONilai += $d->nilaia;
                $totBPBQTY += $d->kuanb;
                $totBPBNilai += $d->nilaib;
                $totPOOUTQTY += $d->qty_po_outs;
                $totPOOUTNilai += $d->rph_po_outs;

                if($totKatPOQTY != 0 && $totKatBPBQTY != 0)
                    $totKatKuantum = ($totKatBPBQTY / ($totKatPOQTY - $totKatPOOUTQTY)) * 100;
                else $totKatKuantum = 0;

                if($totKatPONilai != 0 && $totKatBPBNilai != 0)
                    $totKatNilai = ($totKatBPBNilai / ($totKatPONilai - $totKatPOOUTNilai)) * 100;
                else $totKatNilai = 0;

                if($totDepPOQTY != 0 && $totDepBPBQTY != 0)
                    $totDepKuantum = ($totDepBPBQTY / ($totDepPOQTY - $totDepPOOUTQTY)) * 100;
                else $totDepKuantum = 0;

                if($totDepPONilai != 0 && $totDepBPBNilai != 0)
                    $totDepNilai = ($totDepBPBNilai / ($totDepPONilai - $totDepPOOUTNilai)) * 100;
                else $totDepNilai = 0;

                if($totDivPOQTY != 0 && $totDivBPBQTY != 0)
                    $totDivKuantum = ($totDivBPBQTY / ($totDivPOQTY - $totDivPOOUTQTY)) * 100;
                else $totDivKuantum = 0;

                if($totDivPONilai != 0 && $totDivBPBNilai != 0)
                    $totDivNilai = ($totDivBPBNilai / ($totDivPONilai - $totDivPOOUTNilai)) * 100;
                else $totDivNilai = 0;
            @endphp
        @endforeach
            <tr class="bold">
                <td class="left" colspan="5">Total Per Kategori :</td>
                <td class="right padding-right">{{ number_format($totKatPOQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totKatPONilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totKatBPBQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totKatBPBNilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totKatPOOUTQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totKatPOOUTNilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totKatKuantum,0) }}</td>
                <td class="right padding-right">{{ number_format($totKatNilai,0) }}</td>
            </tr>
            <tr class="bold">
                <td class="left" colspan="5">Total Per Departement :</td>
                <td class="right padding-right">{{ number_format($totDepPOQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totDepPONilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totDepBPBQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totDepBPBNilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totDepPOOUTQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totDepPOOUTNilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totDepKuantum,0) }}</td>
                <td class="right padding-right">{{ number_format($totDepNilai,0) }}</td>
            </tr>
            <tr class="bold">
                <td class="left" colspan="5">Total Per Divisi :</td>
                <td class="right padding-right">{{ number_format($totDivPOQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totDivPONilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totDivBPBQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totDivBPBNilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totDivPOOUTQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totDivPOOUTNilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totDivKuantum,0) }}</td>
                <td class="right padding-right">{{ number_format($totDivNilai,0) }}</td>
            </tr>
            <tr class="bold" style="border-top: 1px solid black">
                <td class="left" colspan="5">Grand Total :</td>
                <td class="right padding-right">{{ number_format($totPOQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totPONilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totBPBQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totBPBNilai,0) }}</td>
                <td class="right padding-right">{{ number_format($totPOOUTQTY,0) }}</td>
                <td class="right padding-right">{{ number_format($totPOOUTNilai,0) }}</td>
                @php
                    if($totPOQTY != 0 && $totBPBQTY != 0)
                        $totKuantum = ($totBPBQTY / ($totPOQTY - $totPOOUTQTY)) * 100;
                    else $totKuantum = 0;

                    if($totPONilai != 0 && $totBPBNilai != 0)
                        $totNilai = ($totBPBNilai / ($totPONilai - $totPOOUTNilai)) * 100;
                    else $totNilai = 0;
                @endphp
                <td class="right padding-right">{{ number_format($totKuantum,0) }}</td>
                <td class="right padding-right">{{ number_format($totNilai,0) }}</td>
            </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
