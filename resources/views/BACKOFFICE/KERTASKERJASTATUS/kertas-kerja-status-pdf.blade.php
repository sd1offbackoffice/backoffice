@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height','792pt')
@section('paper_width','1071pt')

@section('page_title')
    KERTAS KERJA STATUS
@endsection

@section('title')
    ** KERTAS KERJA STATUS **
@endsection

@section('subtitle')
    Periode : {{ $periode }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">RAK</th>
            <th class="tengah" rowspan="2">SR</th>
            <th class="tengah" rowspan="2">TR</th>
            <th class="tengah" rowspan="2">SH</th>
            <th class="tengah" rowspan="2">NU</th>
            <th class="tengah" rowspan="2">DIV</th>
            <th class="tengah" rowspan="2">DEP</th>
            <th class="tengah" rowspan="2">KAT</th>
            <th class="tengah" rowspan="2">PLU</th>
            <th class="tengah" rowspan="2">DESKRIPSI</th>
            <th class="tengah" rowspan="2">TAG</th>
            <th class="tengah" rowspan="2">ITM_PRT</th>
            <th class="tengah" rowspan="2">FRAC</th>
            <th class="tengah" colspan="3">---- AVG SALES IN PCS ----</th>
            <th class="tengah right" rowspan="2">MINOR</th>
            <th class="tengah right" rowspan="2">MINDIS</th>
            <th class="tengah right" rowspan="2">LT</th>
            <th class="tengah right" rowspan="2">%SL</th>
            <th class="tengah right" rowspan="2">KOEF</th>
            <th class="tengah right" rowspan="2">PKM</th>
            <th class="tengah right" rowspan="2">MPKM</th>
            <th class="tengah right" rowspan="2">M+</th>
            <th class="tengah right" rowspan="2">PKMT</th>
            <th class="tengah right" rowspan="2">PKMT+<br>50%MINOR</th>
            <th class="tengah right" rowspan="2">MAX_DIS</th>
            <th class="tengah right" rowspan="2">MAX_PLT</th>
            <th class="tengah right" rowspan="2">ROW_SB</th>
            <th class="tengah right" rowspan="2">ROW_SK</th>
            <th class="tengah right" rowspan="2">%SK</th>
            <th class="tengah right" rowspan="2">QTY_SK</th>
            <th class="tengah" rowspan="2">STS_RMS</th>
            <th class="tengah" rowspan="2">EXIS_STS</th>
            <th class="tengah" rowspan="2">ADJ_STS</th>
            <th class="tengah" rowspan="2">OMI/IDM</th>
            <th class="tengah right" rowspan="2">MAX_PLANO<br>OMI</th>
            <th class="tengah right" rowspan="2">MINPCT<br>OMI(%)</th>
            <th class="tengah right" colspan="3">DIMENSI</th>
            <th class="tengah right" rowspan="2">VOL<br>(CM3)</th>
            <th class="tengah right" rowspan="2">MAX_PLANO<br>TOKO</th>
            <th class="tengah right" rowspan="2">MINPCS<br>TOKO(%)</th>
        </tr>
        <tr>
            <th class="right">IGR</th>
            <th class="right">IDM/OMI</th>
            <th class="right">TTL AVG</th>
            <th class="right">P</th>
            <th class="right">L</th>
            <th class="right">T</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $d)
            @php
                $pkmt50minor = $d->pkmt ? intval($d->pkmt) + round($d->minor * 50 / 100) : 0;
                $qtysk = round($d->maxpallet * ($rowsk/$rowsb*50) / 100);
            @endphp
            <tr>
                <td>{{ $d->rak }}</td>
                <td>{{ $d->sr }}</td>
                <td>{{ $d->tr }}</td>
                <td>{{ $d->sh }}</td>
                <td>{{ $d->nu }}</td>
                <td>{{ $d->div }}</td>
                <td>{{ $d->dep }}</td>
                <td>{{ $d->kat }}</td>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->deskripsi }}</td>
                <td>{{ $d->tag }}</td>
                <td>{{ $d->cp_prt }}</td>
                <td class="right">{{ number_format($d->frac) }}</td>
                <td class="right">{{ $d->igr == 0 ? 0 : number_format(round($d->igr / $d->hariigr)) }}</td>
                <td class="right">{{ $d->omi == 0 ? 0 : number_format(round($d->omi / $d->hariomi)) }}</td>
                <td class="right">{{ ($d->igr == 0 ? 0 : number_format(round($d->igr / $d->hariigr)) + ($d->omi == 0 ? 0 : round($d->omi / $d->hariomi))) }}</td>
                <td class="right">{{ number_format($d->minor) }}</td>
                <td class="right">{{ number_format($d->mindisplay) }}</td>
                <td class="right">{{ number_format($d->lt) }}</td>
                <td class="right">{{ number_format($d->sl) }}</td>
                <td class="right">{{ number_format(round($d->koef)) }}</td>
                <td class="right">{{ number_format($d->pkm) }}</td>
                <td class="right">{{ number_format($d->mpkm) }}</td>
                <td class="right">{{ number_format($d->mplus) }}</td>
                <td class="right">{{ number_format($d->pkmt) }}</td>
                <td class="right">{{ number_format($pkmt50minor) }}</td>
                <td class="right">{{ number_format($d->maxdisplay) }}</td>
                <td class="right">{{ number_format($d->maxpallet) }}</td>
                <td class="right">{{ number_format($rowsb) }}</td>
                <td class="right">{{ number_format($rowsk) }}</td>
                <td class="right">{{ number_format(round($rowsk/$rowsb*50)) }}</td>
                <td class="right">{{ number_format($qtysk) }}</td>
                <td>
                    @if($pkmt50minor > $qtysk)
                        S
                    @elseif($pkmt50minor > $d->maxdisplay && $pkmt50minor < $qtysk)
                        SK
                    @elseif($pkmt50minor <= $d->maxdisplay)
                        NS
                    @endif
                </td>
                <td>{{ $d->pln_sts }}</td>
                <td>{{ $d->adj_sts }}</td>
                <td>{{ $d->j_omi_idm }}</td>
                <td class="right">{{ number_format($d->maxplano_omi) }}</td>
                <td class="right">{{ number_format($d->minpct_omi) }}</td>
                <td class="right">{{ number_format($d->p) }}</td>
                <td class="right">{{ number_format($d->l) }}</td>
                <td class="right">{{ number_format($d->t) }}</td>
                <td class="right">{{ number_format($d->volume) }}</td>
                <td class="right">{{ number_format($d->maxplano_toko) }}</td>
                <td class="right">{{ number_format($d->minpct_toko) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
