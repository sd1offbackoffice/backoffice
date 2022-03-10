@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Daftar Penerimaan Antar Cabang Ringkasan Divisi / Departement / Kategori
@endsection

@section('title')
    ** Daftar Penerimaan Antar Cabang **
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
            $tempdiv = null;
            $tempdep = null;

            $depgross = 0;
            $deppot = 0;
            $depppn = 0;
            $depbm = 0;
            $depbtl = 0;
            $deptotal = 0;

            $divgross = 0;
            $divpot = 0;
            $divppn = 0;
            $divbm = 0;
            $divbtl = 0;
            $divtotal = 0;

            $gross_bkp = 0;
            $gross_btkp = 0;
            $pot_bkp = 0;
            $pot_btkp = 0;
            $ppn_bkp = 0;
            $ppn_btkp = 0;
            $bm_bkp = 0;
            $bm_btkp = 0;
            $btl_bkp = 0;
            $btl_btkp = 0;
            $total_bkp = 0;
            $total_btkp = 0;
        @endphp
        @foreach($data as $d)
            @if($d->mstd_kodedivisi != $tempdiv)
                @if($tempdiv != null)
                    <tr class="bold">
                        <td colspan="2" class="left">SUB TOTAL DEPARTEMENT : {{ $tempdep }}</td>
                        <td class="right">{{ number_format($depgross,2) }}</td>
                        <td class="right">{{ number_format($deppot,2) }}</td>
                        <td class="right">{{ number_format($depppn,2) }}</td>
                        <td class="right">{{ number_format($depbm,2) }}</td>
                        <td class="right">{{ number_format($depbtl,2) }}</td>
                        <td class="right">{{ number_format($deptotal,2) }}</td>
                    </tr>
                    <tr class="bold">
                        <td colspan="2" class="left">SUB TOTAL DIVISI : {{ $tempdiv }}</td>
                        <td class="right">{{ number_format($divgross,2) }}</td>
                        <td class="right">{{ number_format($divpot,2) }}</td>
                        <td class="right">{{ number_format($divppn,2) }}</td>
                        <td class="right">{{ number_format($divbm,2) }}</td>
                        <td class="right">{{ number_format($divbtl,2) }}</td>
                        <td class="right">{{ number_format($divtotal,2) }}</td>
                    </tr>
                @endif
                <tr class="bold">
                    <td colspan="9" class="left">DIVISI : {{ $d->mstd_kodedivisi }} - {{ $d->div_namadivisi }}</td>
                </tr>
                <tr class="bold">
                    <td colspan="9" class="left">DEPARTEMENT : {{ $d->mstd_kodedepartement }} - {{ $d->dep_namadepartement }}</td>
                </tr>
                @php
                    $tempdiv = $d->mstd_kodedivisi;
                    $tempdep = $d->mstd_kodedepartement;
                    $depgross = 0;
                    $deppot = 0;
                    $depppn = 0;
                    $depbm = 0;
                    $depbtl = 0;
                    $deptotal = 0;
                    $divgross = 0;
                    $divpotongan = 0;
                    $divppn = 0;
                    $divbm = 0;
                    $divbtl = 0;
                    $divtotal = 0;
                @endphp
            @elseif($d->mstd_kodedepartement != $tempdep)
                @if($tempdep != null)
                    <tr class="bold">
                        <td colspan="2" class="left">SUB TOTAL DEPARTEMENT : {{ $tempdep }}</td>
                        <td class="right">{{ number_format($depgross,2) }}</td>
                        <td class="right">{{ number_format($deppot,2) }}</td>
                        <td class="right">{{ number_format($depppn,2) }}</td>
                        <td class="right">{{ number_format($depbm,2) }}</td>
                        <td class="right">{{ number_format($depbtl,2) }}</td>
                        <td class="right">{{ number_format($deptotal,2) }}</td>
                    </tr>
                @endif
                <tr class="bold">
                    <td colspan="9" class="left">DEPARTEMENT : {{ $d->mstd_kodedepartement }} - {{ $d->dep_namadepartement }}</td>
                </tr>
                @php
                    $tempdep = $d->mstd_kodedepartement;
                    $depgross = 0;
                    $deppotongan = 0;
                    $depppn = 0;
                    $depbm = 0;
                    $depbtl = 0;
                    $deptotal = 0;
                @endphp
            @endif
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
                $depgross += $d->gross;
                $deppot += $d->pot;
                $depppn += $d->ppn;
                $depbm += $d->bm;
                $depbtl += $d->btl;
                $deptotal += $d->total;
                $divgross  += $d->gross;
                $divpot  += $d->pot;
                $divppn  += $d->ppn;
                $divbm  += $d->bm;
                $divbtl  += $d->btl;
                $divtotal  += $d->total;

                $gross_bkp += $d->sgross_bkp;
                $gross_btkp += $d->sgross_btkp;
                $pot_bkp += $d->spot_bkp;
                $pot_btkp += $d->spot_btkp;
                $ppn_bkp += $d->sppn_bkp;
                $ppn_btkp += $d->sppn_btkp;
                $bm_bkp += $d->sbm_bkp;
                $bm_btkp += $d->sbm_btkp;
                $btl_bkp += $d->sbtl_bkp;
                $btl_btkp += $d->sbtl_btkp;
                $total_bkp += $d->stotal_bkp;
                $total_btkp += $d->stotal_btkp;
            @endphp
        @endforeach
        <tr class="bold">
            <td colspan="2" class="left">SUB TOTAL DEPARTEMENT : {{ $tempdep }}</td>
            <td class="right">{{ number_format($depgross,2) }}</td>
            <td class="right">{{ number_format($deppot,2) }}</td>
            <td class="right">{{ number_format($depppn,2) }}</td>
            <td class="right">{{ number_format($depbm,2) }}</td>
            <td class="right">{{ number_format($depbtl,2) }}</td>
            <td class="right">{{ number_format($deptotal,2) }}</td>
        </tr>
        <tr class="bold">
            <td colspan="2" class="left">SUB TOTAL DIVISI : {{ $tempdiv }}</td>
            <td class="right">{{ number_format($divgross,2) }}</td>
            <td class="right">{{ number_format($divpot,2) }}</td>
            <td class="right">{{ number_format($divppn,2) }}</td>
            <td class="right">{{ number_format($divbm,2) }}</td>
            <td class="right">{{ number_format($divbtl,2) }}</td>
            <td class="right">{{ number_format($divtotal,2) }}</td>
        </tr>
        </tbody>
        <tfoot style="text-align: center">
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BKP</strong></td>
            <td class="right"><strong>{{ number_format($gross_bkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($pot_bkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppn_bkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bm_bkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btl_bkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($total_bkp,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL BTKP</strong></td>
            <td class="right"><strong>{{ number_format($gross_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($pot_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppn_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bm_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btl_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($total_btkp,2) }}</strong></td>
            <td></td>
        </tr>
        <tr>
            <td class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="right"><strong>{{ number_format($gross_bkp + $gross_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($pot_bkp + $pot_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($ppn_bkp + $ppn_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($bm_bkp + $bm_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($btl_bkp + $btl_btkp,2) }}</strong></td>
            <td class="right"><strong>{{ number_format($total_bkp + $total_btkp,2) }}</strong></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
@endsection
