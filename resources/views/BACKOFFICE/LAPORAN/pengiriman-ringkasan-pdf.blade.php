@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Daftar Pengiriman Antar Cabang Ringkasan Divisi / Departement / Kategori
@endsection

@section('title')
    ** Daftar Pengiriman Antar Cabang **
@endsection

@section('subtitle')
    Ringkasan Divisi / Departement / Kategori
@endsection

@section('header_left')
    <p>Tanggal : {{ $tgl1 }} s/d {{ $tgl2 }}</p>
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" width="8%">KODE</th>
            <th class="left" width="27%">NAMA KATEGORI</th>
            <th class="right" width="10%">GROSS</th>
            <th class="right" width="10%">POTONGAN</th>
            <th class="right" width="10%">PPN</th>
            <th class="right" width="10%">PPN BM</th>
            <th class="right" width="10%">BOTOL</th>
            <th class="right" width="15%">TOTAL NILAI</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempdiv = '';
            $tempdep = '';
            $tempkat = '';
            $totaldiv = 0;
            $totaldep = 0;
            $totalgross = 0;
            $totalpot = 0;
            $totalppn = 0;
            $totalbm = 0;
            $totalbtl = 0;
            $total = 0;
            $totalnilai = 0;
            $divgross = 0;
            $divpot = 0;
            $divppn = 0;
            $divbm = 0;
            $divbtl = 0;
            $skipdep = false;
            $bgross = 0;
            $bpot = 0;
            $bppn = 0;
            $bbm = 0;
            $bbtl = 0;
            $tgross = 0;
            $tpot = 0;
            $tppn = 0;
            $tbm = 0;
            $tbtl = 0;
            $btotal = 0;
            $totalnilaidep = 0;
        @endphp
        @for($i=0;$i<count($data);$i++)
            @php
                $d = $data[$i];
                $total += $d->total;
                $skipdep = false;
                $skipkat = false;
                $bgross += $d->bgross;
                $bpot += $d->bpot;
                $bppn += $d->bppn;
                $bbm += $d->bbm;
                $bbtl += $d->bbtl;
                $btotal += $bgross + $bpot + $bppn + $bbm + $bbtl;
                $tgross += $d->gross;
                $tpot += $d->pot;
                $tppn += $d->ppn;
                $tbm += $d->bm;
                $tbtl += $d->btl;
            @endphp
            @if($tempdiv != $d->mstd_kodedivisi)
                @if($tempdiv != '')
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalgross,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalpot,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalppn,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalbm,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalbtl,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalnilaidep,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php
                        $totaldep = 0;
                        $skipdep = true;
                    @endphp
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
                        <td class="right"><strong>{{ number_format($divgross,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($divpot,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($divppn,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($divbm,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($divbtl,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php
                        $totaldiv = 0;
                        $divgross = 0;
                        $divpot = 0;
                        $divppn = 0;
                        $divbm = 0;
                        $divbtl = 0;
                        $totaldep = 0;
                        $totalgross = 0;
                        $totalpot = 0;
                        $totalppn = 0;
                        $totalbm = 0;
                        $totalbtl = 0;
                        $totalnilaidep = 0;
                    @endphp
                @endif
                @php $tempdiv = $d->mstd_kodedivisi @endphp
                <tr>
                    <td class="left" colspan="8"><strong>DIVISI : {{ $d->mstd_kodedivisi }} - {{ $d->div_namadivisi }}</strong></td>
                </tr>
            @endif
            @php $totaldiv += $d->total @endphp
            @if($tempdep != $d->mstd_kodedepartement)
                @if($tempdep != '' && !$skipdep)
                    <tr>
                        <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalgross,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalpot,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalppn,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalbm,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalbtl,2) }}</strong></td>
                        <td class="right"><strong>{{ number_format($totalnilaidep,2) }}</strong></td>
                        <td></td>
                    </tr>
                    @php
                        $totaldep = 0;
                        $totalgross = 0;
                        $totalpot = 0;
                        $totalppn = 0;
                        $totalbm = 0;
                        $totalbtl = 0;
                        $totalnilaidep = 0;
                    @endphp
                @endif
                @php $tempdep = $d->mstd_kodedepartement @endphp
                <tr>
                    <td class="left" colspan="8"><strong>DEPARTEMENT : {{ $d->mstd_kodedepartement }} - {{ $d->dep_namadepartement }}</strong></td>
                </tr>
            @endif
            @php $totaldep += $d->total @endphp

            <tr>
                <td class="left">{{ $d->mstd_kodekategoribrg }}</td>
                <td class="left">{{ $d->kat_namakategori }}</td>
                <td class="right">{{ number_format($d->gross,2) }}</td>
                <td class="right">{{ number_format($d->pot,2) }}</td>
                <td class="right">{{ number_format($d->ppn,2) }}</td>
                <td class="right">{{ number_format($d->bm,2) }}</td>
                <td class="right">{{ number_format($d->btl,2) }}</td>
                <td class="right">{{ number_format($d->total,2) }}</td>
            </tr>
            @php
                $totalgross += $d->gross;
                $totalpot += $d->pot;
                $totalppn += $d->ppn;
                $totalbm += $d->bm;
                $totalbtl += $d->btl;
                $totalnilaidep = $totalnilai + $totalgross + $totalpot + $totalppn + $totalbm + $totalbtl;
                $divgross += $totalgross;
                $divpot += $totalpot;
                $divppn += $totalppn;
                $divbm += $totalbm;
                $divbtl += $totalbtl;
            @endphp
        @endfor
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DEPARTEMENT : {{ $tempdep }}</strong></td>
            <td class="right"><strong>{{ number_format($totalgross,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalpot,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalppn,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalbm,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalbtl,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totalnilaidep,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>SUBTOTAL DIVISI : {{ $tempdiv }}</strong></td>
            <td class="right"><strong>{{ number_format($divgross,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($divpot,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($divppn,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($divbm,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($divbtl,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($totaldiv,2) }}</strong></td>
            <td></td>
        </tr>
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BKP</strong></td>
            <td class="right"><strong>{{ number_format($tgross,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($tpot,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($tppn,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($tbm,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($tbtl,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($total,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BTKP</strong></td>
            <td class="right"><strong>{{ number_format($bgross,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bpot,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bppn,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bbm,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bbtl,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btotal,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="right"><strong>{{ number_format($tgross + $bgross,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($tpot + $bpot,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($tppn + $bppn,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($tbm + $bbm,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($tbtl + $bbtl,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($total + $btotal,2) }}</strong></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
@endsection
