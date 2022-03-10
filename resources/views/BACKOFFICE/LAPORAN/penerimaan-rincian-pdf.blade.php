@extends('html-template')

@section('paper_height','792pt')
@section('paper_width','1071pt')

@section('table_font_size','7 px')

@section('page_title')
    Daftar Penerimaan Antar Cabang Rincian Produk Per Divisi / Departement / Kategori
@endsection

@section('title')
    ** Daftar Penerimaan Antar Cabang **
@endsection

@section('subtitle')
    Rincian Produk Per Divisi / Departement / Kategori
@endsection

@section('header_left')
    <p>Tanggal : {{ $tgl1 }} s/d {{ $tgl2 }}</p>
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th width="10%" class="center" colspan="2">---------- BPB ----------</th>
            <th width="5%" class="tengah" rowspan="2">PLU</th>
            <th width="20%" class="tengah left" rowspan="2">NAMA BARANG</th>
            <th width="5%" class="tengah" rowspan="2">KEMASAN</th>
            <th width="5%" class="tengah" rowspan="2">HARGA BELI</th>
            <th width="5%" colspan="2">KUANTUM</th>
            <th width="5%" class="tengah" rowspan="2">GROSS</th>
            <th width="5%" class="tengah" rowspan="2">PPN</th>
            <th width="5%" class="tengah" rowspan="2">PPN-BM</th>
            <th width="5%" class="tengah" rowspan="2">BOTOL</th>
            <th width="10%" class="tengah padding-right" rowspan="2">TOTAL NILAI</th>
            <th width="5%" class="tengah" rowspan="2">KETERANGAN</th>
            <th width="5%" class="tengah" rowspan="2">LCOST</th>
            <th width="5%" class="tengah" rowspan="2">ACOST</th>
        </tr>
        <tr>
            <th class="center">NOMOR</th>
            <th class="center">TANGGAL</th>
            <th class="center">CTN</th>
            <th class="center">PCS</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempdiv = '';
            $tempdep = '';
            $tempkat = '';
            $grosskat = 0;
            $potkat = 0;
            $ppnkat = 0;
            $bmkat = 0;
            $btlkat = 0;
            $totalkat = 0;
            $grossdep = 0;
            $potdep = 0;
            $ppndep = 0;
            $bmdep = 0;
            $btldep = 0;
            $totaldep = 0;
            $grossdiv = 0;
            $potdiv = 0;
            $ppndiv = 0;
            $bmdiv = 0;
            $btldiv = 0;
            $totaldiv = 0;
            $total = 0;
            $skipdep = false;
            $skipkat = false;
            $grossbkp = 0;
            $potbkp = 0;
            $ppnbkp = 0;
            $bmbkp = 0;
            $btlbkp = 0;
            $totalbkp = 0;
            $grossbtkp = 0;
            $potbtkp = 0;
            $ppnbtkp = 0;
            $bmbtkp = 0;
            $btlbtkp = 0;
            $totalbtkp = 0;
        @endphp
        @for($i=0;$i<count($data);$i++)
            @php
                $d = $data[$i];
                $total += $d->total;
                $skipdep = false;
                $skipkat = false;
                $grossbkp += $d->grossbkp;
                $potbkp += $d->potbkp;
                $ppnbkp += $d->ppnbkp;
                $bmbkp += $d->bmbkp;
                $btlbkp += $d->btlbkp;
                $totalbkp += $d->totalbkp;
                $grossbtkp += $d->grossbtkp;
                $potbtkp += $d->potbtkp;
                $ppnbtkp += $d->ppnbtkp;
                $bmbtkp += $d->bmbtkp;
                $btlbtkp += $d->btlbtkp;
                $totalbtkp += $d->totalbtkp;
            @endphp
            @if($tempdiv != $d->mstd_kodedivisi)
                @if($tempdiv != '')
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grosskat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppnkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btlkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
                    </tr>
                    @php
                        $grosskat = 0;
                        $potkat = 0;
                        $ppnkat = 0;
                        $bmkat = 0;
                        $btlkat = 0;
                        $totalkat = 0;
                        $skipkat = true;
                    @endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grossdep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppndep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmdep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btldep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php
                        $grossdep = 0;
                        $potdep = 0;
                        $ppndep = 0;
                        $bmdep = 0;
                        $btldep = 0;
                        $totaldep = 0;
                        $skipdep = true;
                    @endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grossdiv,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppndiv,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmdiv,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btldiv,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php
                        $grossdiv = 0;
                        $potdiv = 0;
                        $ppndiv = 0;
                        $bmdiv = 0;
                        $btldiv = 0;
                        $totaldiv = 0;
                    @endphp
                @endif
                @php $tempdiv = $d->mstd_kodedivisi @endphp
                <tr>
                    <td class="left"><strong>DIVISI</strong></td>
                    <td><strong>: {{ $d->mstd_kodedivisi }}</strong></td>
                    <td class="left" colspan="14"><strong> - {{ $d->div_namadivisi }}</strong></td>
                </tr>
            @endif
            @php
                $grossdiv += $d->gross;
                $ppndiv += $d->ppn;
                $bmdiv += $d->bm;
                $btldiv += $d->btl;
                $totaldiv += $d->total;
            @endphp
            @if($tempdep != $d->mstd_kodedepartement)
                @if($tempdep != '' && !$skipdep)
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grosskat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppnkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btlkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
                    </tr>
                    @php
                        $grosskat = 0;
                        $potkat = 0;
                        $ppnkat = 0;
                        $bmkat = 0;
                        $btlkat = 0;
                        $totalkat = 0;
                        $skipkat = true;
                    @endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grossdep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppndep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmdep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btldep,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php
                        $totaldep = 0;
                        $grossdep = 0;
                        $potdep = 0;
                        $ppndep = 0;
                        $bmdep = 0;
                        $btldep = 0;
                    @endphp
                @endif
                @php $tempdep = $d->mstd_kodedepartement @endphp
                <tr>
                    <td class="left"><strong>DEPARTEMENT</strong></td>
                    <td><strong>: {{ $d->mstd_kodedepartement }}</strong></td>
                    <td class="left" colspan="14"><strong> - {{ $d->dep_namadepartement }}</strong></td>
                </tr>
            @endif
            @php
                $grossdep += $d->gross;
                $ppndep += $d->ppn;
                $bmdep += $d->bm;
                $btldep += $d->btl;
                $totaldep += $d->total;
            @endphp
            @if($tempkat != $d->mstd_kodekategoribrg)
                @if($tempkat != '' && !$skipkat)
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
                        <td colspan="6"></td>
                        <td class="right"><strong>{{ number_format($grosskat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($ppnkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($bmkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($btlkat,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php $totalkat = 0; @endphp
                @endif
                @php $tempkat = $d->mstd_kodekategoribrg @endphp
                <tr>
                    <td class="left"><strong>KATEGORI</strong></td>
                    <td><strong>: {{ $d->mstd_kodekategoribrg }}</strong></td>
                    <td class="left" colspan="14"><strong> - {{ $d->kat_namakategori}}</strong></td>
                </tr>
            @endif
            @php
                $grosskat += $d->gross;
                $ppnkat += $d->ppn;
                $bmkat += $d->bm;
                $btlkat += $d->btl;
                $totalkat += $d->total;
            @endphp
            <tr>
                <td>{{ $d->mstd_nodoc }}</td>
                <td>{{ $d->mstd_tgldoc }}</td>
                <td>{{ $d->mstd_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipanjang }}</td>
                <td>{{ $d->unit }}</td>
                <td class="right">{{ number_format($d->hg_beli,2) }}</td>
                <td>{{ $d->ctn }}</td>
                <td>{{ $d->pcs }}</td>
                <td class="right">{{ number_format($d->gross,2) }}</td>
                <td class="right">{{ number_format($d->ppn,2) }}</td>
                <td class="right">{{ number_format($d->bm,2) }}</td>
                <td class="right">{{ number_format($d->btl,2) }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
                <td>{{ $d->mstd_keterangan }}</td>
{{--                //RETURN(((:Gross - :pot + :Bm + :Btl) * :Frac / (:ctn * :Frac + :pcs + :bonus)));--}}
{{--                //((($d->gross - $d->pot + $d->bm + $d->btl) * $d->frac / ($d->ctn * $d->frac + $d->pcs + $d->bonus)))--}}
                <td class="right">{{ number_format(((($d->gross - $d->pot + $d->bm + $d->btl) * $d->frac / ($d->ctn * $d->frac + $d->pcs + $d->bonus))),2) }}</td>
{{--                <td class="right">{{ number_format($d->lcost,2) }}</td>--}}
                <td class="right">{{ number_format($d->acost,2) }}</td>
            </tr>
        @endfor
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL KATEGORI : {{ $tempkat }}</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grosskat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potkat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppnkat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmkat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btlkat,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalkat,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossdep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potdep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppndep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmdep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btldep,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totaldep,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossdiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potdiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppndiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmdiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btldiv,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
            <td colspan="8"></td>
        </tr>
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BKP</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppnbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btlbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalbkp,2) }}</strong></td>
            <th colspan="3"></th>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BTKP</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppnbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btlbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalbtkp,2) }}</strong></td>
            <th colspan="3"></th>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td colspan="6"></td>
            <td class="right"><strong>{{ number_format($grossbkp + $grossbtkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($potbtkp + $potbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppnbtkp + $ppnbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bmbtkp + $bmbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btlbtkp + $btlbkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalbtkp + $totalbkp,2) }}</strong></td>
            <th colspan="3"></th>
            <td></td>
        </tr>
        </tfoot>
    </table>
@endsection
