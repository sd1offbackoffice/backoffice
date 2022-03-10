@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    KARTU GUDANG
@endsection

@section('title')
    ** KARTU GUDANG **
@endsection

@section('subtitle')
    TANGGAL : {{ $periode1 }} s/d {{ $periode2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="2" width="" rowspan="2">DOK. MUTASI</th>
            <th class="right" colspan="2" width="" rowspan="2">PEMBELIAN</th>
            <th class="right" colspan="2" width="" rowspan="1">PENERIMAAN</th>
            <th class="right" colspan="2" width="" rowspan="2">LAIN-LAIN</th>
            <th class="right" colspan="2" width="" rowspan="2">PENJUALAN</th>
            <th class="right" colspan="2" width="" rowspan="2">PENGELUARAN<br>LAIN-LAIN</th>
            <th class="right" colspan="2" width="" rowspan="2">INTRANSIT</th>
            <th class="right" colspan="2" width="" rowspan="2">PENYESUAIAN</th>
            <th class="right" colspan="2" width="" rowspan="2">SALDO AKHIR</th>
        </tr>
        <tr>
            <th class="right">RETUR</th>
            <th class="right">PENJ</th>
        </tr>
        </thead>
        <tbody>
        @php
            $plu = null;
            $p_status = 1;

            $tot_cp_tinq1 = 0;
            $tot_cp_tinq2 = 0;
            $tot_cp_tinq3 = 0;
            $tot_cp_tinq4 = 0;
            $tot_cp_tinf1 = 0;
            $tot_cp_tinf2 = 0;
            $tot_cp_tinf3 = 0;
            $tot_cp_tinf4 = 0;
            $tot_cp_toutq1 = 0;
            $tot_cp_toutq3 = 0;
            $tot_cp_toutf1 = 0;
            $tot_cp_toutf3 = 0;
            $tot_cp_intrq = 0;
            $tot_cp_intrf = 0;
            $tot_cp_gntrq = 0;
            $tot_cp_gntrf = 0;
            $tot_cp_sakhirq = 0;
            $tot_cp_sakhirf = 0;

            $frac = 0;
        @endphp
        @foreach($data as $d)
            @if($plu != $d->ktg_prdcd)
                @php $p_status = 1;@endphp
                @if($plu != null)
                    <tr class="bold top-bottom">
                        <td class="left" colspan="2">TOTAL</td>
                        <td class="right">{{ $tot_cp_tinq1 + ($tot_cp_tinf1 > 0 ? floor($tot_cp_tinf1 / $frac) : ceil($tot_cp_tinf1 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_tinf1 % $frac }}</td>
                        <td class="right">{{ $tot_cp_tinq2 + ($tot_cp_tinf2 > 0 ? floor($tot_cp_tinf2 / $frac) : ceil($tot_cp_tinf2 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_tinf2 % $frac }}</td>
                        <td class="right">{{ $tot_cp_tinq3 + ($tot_cp_tinf3 > 0 ? floor($tot_cp_tinf3 / $frac) : ceil($tot_cp_tinf3 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_tinf3 % $frac }} </td>
                        <td class="right">{{ $tot_cp_toutq1 + ($tot_cp_toutf1 > 0 ? floor($tot_cp_toutf1 / $frac) : ceil($tot_cp_toutf1 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_toutf1 % $frac }}</td>
                        <td class="right">{{ $tot_cp_toutq3 + ($tot_cp_toutf3 > 0 ? floor($tot_cp_toutf3 / $frac) : ceil($tot_cp_toutf3 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_toutf3 % $frac }}</td>
                        <td class="right">{{ $tot_cp_intrq + ($tot_cp_intrf > 0 ? floor($tot_cp_intrf / $frac) : ceil($tot_cp_intrf / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_intrf % $frac }}</td>
                        <td class="right">{{ $tot_cp_tinq4 + ($tot_cp_tinf4 > 0 ? floor($tot_cp_tinf4 / $frac) : ceil($tot_cp_tinf4 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_tinf4 % $frac }}</td>
                        <td class="right">{{ $tot_cp_sakhirq + ($tot_cp_sakhirf > 0 ? floor($tot_cp_sakhirf / $frac) : ceil($tot_cp_sakhirf / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_sakhirf % $frac }}</td>
                    </tr>

                    @php
                        $tot_cp_tinq1 = 0;
                        $tot_cp_tinq2 = 0;
                        $tot_cp_tinq3 = 0;
                        $tot_cp_tinq4 = 0;
                        $tot_cp_tinf1 = 0;
                        $tot_cp_tinf2 = 0;
                        $tot_cp_tinf3 = 0;
                        $tot_cp_tinf4 = 0;
                        $tot_cp_toutq1 = 0;
                        $tot_cp_toutq3 = 0;
                        $tot_cp_toutf1 = 0;
                        $tot_cp_toutf3 = 0;
                        $tot_cp_intrq = 0;
                        $tot_cp_intrf = 0;
                        $tot_cp_gntrq = 0;
                        $tot_cp_gntrf = 0;
                        $tot_cp_sakhirq = 0;
                        $tot_cp_sakhirf = 0;
                    @endphp
                @endif
                <tr>
                    <td width="" class="left" colspan="15">
                        <strong>BARANG {{ $d->ktg_prdcd }} - {{ $d->prd_deskripsipanjang }}</strong>
                    </td>
                </tr>
                <tr class="bold">
                    <td class="left" colspan="16">SALDO</td>
                    <td class="right">{{ $d->saq1 }}</td>
                    <td class="right">{{ $d->saf1 }}</td>
                </tr>
                @php
                    $plu = $d->ktg_prdcd;
                    $frac = $d->frac;
                @endphp
            @endif

            @php
                if($p_status == 1){
                    $p_sawal = $d->ktg_qtyawal;
                    $p_status = 0;
                }

                $cp_tsaq1 = $p_sawal + $d->saqty;
                $p_sawal = $cp_tsaq1;
                $cp_sakhirq = $p_sawal > 0 ? floor($p_sawal / $d->frac) : ceil($p_sawal / $d->frac);
                $cp_sakhirf = $p_sawal % $d->frac;
                $p_sakhirq = $p_sawal > 0 ? floor($p_sawal / $d->frac) : ceil($p_sawal / $d->frac);
                $p_sakhirf = $p_sawal % $d->frac;

                $cp_tinq1 = $d->asaqty > 0 ? floor($d->asaqty / $d->frac) : ceil($d->asaqty / $d->frac);
                $cp_tinq2 = $d->csaqty > 0 ? floor($d->csaqty / $d->frac) : ceil($d->csaqty / $d->frac);
                $cp_tinq3 = $d->bsaqty > 0 ? floor($d->bsaqty / $d->frac) : ceil($d->bsaqty / $d->frac);
                $cp_tinq4 = $d->isaqty > 0 ? floor($d->isaqty / $d->frac) : ceil($d->isaqty / $d->frac);
                $cp_tinf1 = $d->asaqty % $d->frac;
                $cp_tinf2 = $d->csaqty % $d->frac;
                $cp_tinf3 = $d->bsaqty % $d->frac;
                $cp_tinf4 = $d->isaqty % $d->frac;
                $cp_toutq1 = $d->dsaqty > 0 ? floor($d->dsaqty / $d->frac) : ceil($d->dsaqty / $d->frac);
                $cp_toutq3 = $d->fsaqty > 0 ? floor($d->fsaqty / $d->frac) : ceil($d->fsaqty / $d->frac);
                $cp_toutf1 = $d->dsaqty % $d->frac;
                $cp_toutf3 = $d->fsaqty % $d->frac;
                $cp_intrq = $d->qintr > 0 ? floor($d->qintr / $d->frac) : ceil($d->qintr / $d->frac);
                $cp_intrf = $d->qintr % $d->frac;
                $cp_gntrq = $d->gintr > 0 ? floor($d->gintr / $d->frac) : ceil($d->gintr / $d->frac);
                $cp_gntrf = $d->gintr % $d->frac;

                $tot_cp_tinq1 += $cp_tinq1;
                $tot_cp_tinq2 += $cp_tinq2;
                $tot_cp_tinq3 += $cp_tinq3;
                $tot_cp_tinq4 += $cp_tinq4;
                $tot_cp_tinf1 += $cp_tinf1;
                $tot_cp_tinf2 += $cp_tinf2;
                $tot_cp_tinf3 += $cp_tinf3;
                $tot_cp_tinf4 += $cp_tinf4;
                $tot_cp_toutq1 += $cp_toutq1;
                $tot_cp_toutq3 += $cp_toutq3;
                $tot_cp_toutf1 += $cp_toutf1;
                $tot_cp_toutf3 += $cp_toutf3;
                $tot_cp_intrq += $cp_intrq;
                $tot_cp_intrf += $cp_intrf;
                $tot_cp_gntrq += $cp_gntrq;
                $tot_cp_gntrf += $cp_gntrf;
                $tot_cp_sakhirq = $cp_sakhirq;
                $tot_cp_sakhirf = $cp_sakhirf;
            @endphp
            <tr>
                <td colspan="18" class="left"><strong>{{ $d->tgl }}</strong></td>
            </tr>
            <tr>
                <td class="right">{{ $d->item }}.</td>
                <td>DOKUMEN</td>
                <td class="right">{{ $cp_tinq1 }}</td>
                <td class="right">{{ $cp_tinf1 }}</td>
                <td class="right">{{ $cp_tinq2 }}</td>
                <td class="right">{{ $cp_tinf2 }}</td>
                <td class="right">{{ $cp_tinq3 }}</td>
                <td class="right">{{ $cp_tinf3 }}</td>
                <td class="right padding-left">{{ $cp_toutq1 }}</td>
                <td class="right">{{ $cp_toutf1 }}</td>
                <td class="right padding-left">{{ $cp_toutq3 }}</td>
                <td class="right">{{ $cp_toutf3 }}</td>
                <td class="right">{{ $cp_intrq }}</td>
                <td class="right">{{ $cp_intrf }}</td>
                <td class="right">{{ $cp_tinq4 }}</td>
                <td class="right">{{ $cp_tinf4 }}</td>
                <td class="right">{{ $cp_sakhirq }}</td>
                <td class="right">{{ $cp_sakhirf }}</td>
            </tr>
        @endforeach
            <tr class="bold top-bottom">
                <td class="left" colspan="2">TOTAL</td>
                <td class="right">{{ $tot_cp_tinq1 + ($tot_cp_tinf1 > 0 ? floor($tot_cp_tinf1 / $frac) : ceil($tot_cp_tinf1 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_tinf1 % $frac }}</td>
                <td class="right">{{ $tot_cp_tinq2 + ($tot_cp_tinf2 > 0 ? floor($tot_cp_tinf2 / $frac) : ceil($tot_cp_tinf2 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_tinf2 % $frac }}</td>
                <td class="right">{{ $tot_cp_tinq3 + ($tot_cp_tinf3 > 0 ? floor($tot_cp_tinf3 / $frac) : ceil($tot_cp_tinf3 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_tinf3 % $frac }} </td>
                <td class="right">{{ $tot_cp_toutq1 + ($tot_cp_toutf1 > 0 ? floor($tot_cp_toutf1 / $frac) : ceil($tot_cp_toutf1 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_toutf1 % $frac }}</td>
                <td class="right">{{ $tot_cp_toutq3 + ($tot_cp_toutf3 > 0 ? floor($tot_cp_toutf3 / $frac) : ceil($tot_cp_toutf3 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_toutf3 % $frac }}</td>
                <td class="right">{{ $tot_cp_intrq + ($tot_cp_intrf > 0 ? floor($tot_cp_intrf / $frac) : ceil($tot_cp_intrf / $frac)) }}</td>
                <td class="right">{{ $tot_cp_intrf % $frac }}</td>
                <td class="right">{{ $tot_cp_tinq4 + ($tot_cp_tinf4 > 0 ? floor($tot_cp_tinf4 / $frac) : ceil($tot_cp_tinf4 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_tinf4 % $frac }}</td>
                <td class="right">{{ $tot_cp_sakhirq + ($tot_cp_sakhirf > 0 ? floor($tot_cp_sakhirf / $frac) : ceil($tot_cp_sakhirf / $frac)) }}</td>
                <td class="right">{{ $tot_cp_sakhirf % $frac }}</td>
            </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
