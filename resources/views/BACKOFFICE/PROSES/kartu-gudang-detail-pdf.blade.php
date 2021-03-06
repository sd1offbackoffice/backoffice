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
            <th colspan="2" width="10%" rowspan="2" class="bawah">USR. STT</th>
            <th colspan="1" width="10%" rowspan="2" class="bawah">DOKUMEN</th>
            <th colspan="2" width="10%" rowspan="2" class="bawah right">PEMBELIAN</th>
            <th colspan="2" width="10%" rowspan="1" class="right">PENERIMAAN</th>
            <th colspan="2" width="10%" rowspan="2" class="bawah right">LAIN-LAIN</th>
            <th colspan="2" width="10%" rowspan="2" class="bawah right">PENJUALAN</th>
            <th colspan="2" width="10%" rowspan="2" class="bawah right">PENGELUARAN<br>LAIN-LAIN</th>
            <th colspan="2" width="10%" rowspan="2" class="bawah right">INTRANSIT</th>
            <th colspan="2" width="10%" rowspan="2" class="bawah right">PENYESUAIAN</th>
            <th colspan="2" width="10%" rowspan="2" class="bawah right">SALDO AKHIR</th>
        </tr>
        <tr>
            <th width="5%" class="right">RETUR</th>
            <th width="5%" class="right">PENJ</th>
        </tr>
        </thead>
        <tbody>
        @php
            $plu = null;
            $p_status = 1;

            $tot_cp_inq1 = 0;
            $tot_cp_inq2 = 0;
            $tot_cp_inq3 = 0;
            $tot_cp_inq4 = 0;
            $tot_cp_inf1 = 0;
            $tot_cp_inf2 = 0;
            $tot_cp_inf3 = 0;
            $tot_cp_inf4 = 0;
            $tot_cp_outq1 = 0;
            $tot_cp_outq3 = 0;
            $tot_cp_outf1 = 0;
            $tot_cp_outf3 = 0;
            $tot_cp_intrq = 0;
            $tot_cp_intrf = 0;

            $cp_sakhrq = 0;
            $cp_sakhrf = 0;

            $frac = 0;
        @endphp
        @foreach($data as $d)
            @if($plu != $d->ktg_prdcd)
                @php $p_status = 1; @endphp
                @if($plu != null)
                    <tr class="bold top-bottom">
                        <td class="left" colspan="3">TOTAL</td>
                        <td class="right">{{ $tot_cp_inq1 + ($tot_cp_inf1 > 0 ? floor($tot_cp_inf1 / $frac) : ceil($tot_cp_inf1 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_inf1 % $frac }}</td>
                        <td class="right">{{ $tot_cp_inq2 + ($tot_cp_inf2 > 0 ? floor($tot_cp_inf2 / $frac) : ceil($tot_cp_inf2 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_inf2 % $frac }}</td>
                        <td class="right">{{ $tot_cp_inq3 + ($tot_cp_inf3 > 0 ? floor($tot_cp_inf3 / $frac) : ceil($tot_cp_inf3 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_inf3 % $frac }} </td>
                        <td class="right">{{ $tot_cp_outq1 + ($tot_cp_outf1 > 0 ? floor($tot_cp_outf1 / $frac) : ceil($tot_cp_outf1 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_outf1 % $frac }}</td>
                        <td class="right">{{ $tot_cp_outq3 + ($tot_cp_outf3 > 0 ? floor($tot_cp_outf3 / $frac) : ceil($tot_cp_outf3 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_outf3 % $frac }}</td>
                        <td class="right">{{ $tot_cp_intrq + ($tot_cp_intrf > 0 ? floor($tot_cp_intrf / $frac) : ceil($tot_cp_intrf / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_intrf % $frac }}</td>
                        <td class="right">{{ $tot_cp_inq4 + ($tot_cp_inf4 > 0 ? floor($tot_cp_inf4 / $frac) : ceil($tot_cp_inf4 / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_inf4 % $frac }}</td>
                        <td class="right">{{ $tot_cp_sakhirq + ($tot_cp_sakhirf > 0 ? floor($tot_cp_sakhirf / $frac) : ceil($tot_cp_sakhirf / $frac)) }}</td>
                        <td class="right">{{ $tot_cp_sakhirf % $frac }}</td>
                    </tr>

                    @php
                        $tot_cp_inq1 = 0;
                        $tot_cp_inq2 = 0;
                        $tot_cp_inq3 = 0;
                        $tot_cp_inq4 = 0;
                        $tot_cp_inf1 = 0;
                        $tot_cp_inf2 = 0;
                        $tot_cp_inf3 = 0;
                        $tot_cp_inf4 = 0;
                        $tot_cp_outq1 = 0;
                        $tot_cp_outq3 = 0;
                        $tot_cp_outf1 = 0;
                        $tot_cp_outf3 = 0;
                        $tot_cp_intrq = 0;
                        $tot_cp_intrf = 0;
                    @endphp
                @endif
                <tr>
                    <td width="" class="left" colspan="19">
                        <strong>BARANG {{ $d->ktg_prdcd }} - {{ $d->prd_deskripsipanjang }} - {{ $d->kemasan }}</strong>
                    </td>
                </tr>
                <tr class="bold">
                    <td width="90%" class="left" colspan="17">SALDO</td>
                    <td width="5%" class="right">{{ $d->saq1 }}</td>
                    <td width="5%" class="right">{{ $d->saf1 }}</td>
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
                $cp_sakhrq = $p_sawal > 0 ? floor($p_sawal / $d->frac) : ceil($p_sawal / $d->frac);
                $cp_sakhrf = $p_sawal - ($cp_sakhrq * $d->frac);

                if($cp_sakhrf < 0){
                    $cp_sakhrq -= 1;
                    $cp_sakhrf = $d->frac + $cp_sakhrf;
                }

                $p_sakhirq = $p_sawal > 0 ? floor($p_sawal / $d->frac) : ceil($p_sawal / $d->frac);
                $p_sakhirf = $p_sawal - ($cp_sakhrq * $d->frac);

                $cp_inq1 = $d->inq1 > 0 ? floor($d->inq1 / $d->frac) : ceil($d->inq1 / $d->frac);
                $cp_inq2 = $d->inq2 > 0 ? floor($d->inq2 / $d->frac) : ceil($d->inq2 / $d->frac);
                $cp_inq3 = $d->inq3 > 0 ? floor($d->inq3 / $d->frac) : ceil($d->inq3 / $d->frac);
                $cp_inq4 = $d->inq4 > 0 ? floor($d->inq4 / $d->frac) : ceil($d->inq4 / $d->frac);
                $cp_inf1 = $d->inq1 - ($cp_inq1 * $d->frac);
                $cp_inf2 = $d->inq2 - ($cp_inq2 * $d->frac);
                $cp_inf3 = $d->inq3 - ($cp_inq3 * $d->frac);
                $cp_inf4 = $d->inq4 - ($cp_inq4 * $d->frac);
                $cp_outq1 = $d->outq1 > 0 ? floor($d->outq1 / $d->frac) : ceil($d->outq1 / $d->frac);
                $cp_outq3 = $d->outq3 > 0 ? floor($d->outq3 / $d->frac) : ceil($d->outq3 / $d->frac);
                $cp_outf1 = $d->outq1 - ($cp_outq1 * $d->frac);
                $cp_outf3 = $d->outq3 - ($cp_outq3 * $d->frac);
                $cp_intrq = floor($d->qintr / $d->frac);
                $cp_intrf = $d->qintr % $d->frac;

                $tot_cp_inq1 += $cp_inq1;
                $tot_cp_inq2 += $cp_inq2;
                $tot_cp_inq3 += $cp_inq3;
                $tot_cp_inq4 += $cp_inq4;
                $tot_cp_inf1 += $cp_inf1;
                $tot_cp_inf2 += $cp_inf2;
                $tot_cp_inf3 += $cp_inf3;
                $tot_cp_inf4 += $cp_inf4;
                $tot_cp_outq1 += $cp_outq1;
                $tot_cp_outq3 += $cp_outq3;
                $tot_cp_outf1 += $cp_outf1;
                $tot_cp_outf3 += $cp_outf3;
                $tot_cp_intrq += $cp_intrq;
                $tot_cp_intrf += $cp_intrf;
                $tot_cp_sakhirq = $p_sakhirq;
                $tot_cp_sakhirf = $p_sakhirf;
            @endphp
            <tr>
                <td width="100%" colspan="19" class="left"><strong>TGL : {{ $d->tgl }}</strong></td>
            </tr>
            <tr>
                <td class="right" colspan="2">{{ $d->ktg_kasir }} .{{ $d->ktg_station }}</td>
                <td class="left padding-left">{{ $d->ktg_nodokumen }}</td>
                <td class="right">{{ $cp_inq1 }}</td>
                <td class="right">{{ $cp_inf1 }}</td>
                <td class="right">{{ $cp_inq2 }}</td>
                <td class="right">{{ $cp_inf2 }}</td>
                <td class="right padding-left">{{ $cp_inq3 }}</td>
                <td class="right padding-left">{{ $cp_inf3 }}</td>
                <td class="right padding-left   ">{{ $cp_outq1 }}</td>
                <td class="right">{{ $cp_outf1 }}</td>
                <td class="right">{{ $cp_outq3 }}</td>
                <td class="right">{{ $cp_outf3 }}</td>
                <td class="right">{{ $cp_intrq }}</td>
                <td class="right">{{ $cp_intrf }}</td>
                <td class="right">{{ $cp_inq4 }}</td>
                <td class="right">{{ $cp_inf4 }}</td>
                <td class="right">{{ $cp_sakhrq }}</td>
                <td class="right">{{ $cp_sakhrf }}</td>
            </tr>
        @endforeach
            <tr class="bold top-bottom">
                <td class="left" colspan="3">TOTAL</td>
                <td class="right">{{ $tot_cp_inq1 + ($tot_cp_inf1 > 0 ? floor($tot_cp_inf1 / $frac) : ceil($tot_cp_inf1 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_inf1 % $frac }}</td>
                <td class="right">{{ $tot_cp_inq2 + ($tot_cp_inf2 > 0 ? floor($tot_cp_inf2 / $frac) : ceil($tot_cp_inf2 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_inf2 % $frac }}</td>
                <td class="right">{{ $tot_cp_inq3 + ($tot_cp_inf3 > 0 ? floor($tot_cp_inf3 / $frac) : ceil($tot_cp_inf3 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_inf3 % $frac }} </td>
                <td class="right">{{ $tot_cp_outq1 + ($tot_cp_outf1 > 0 ? floor($tot_cp_outf1 / $frac) : ceil($tot_cp_outf1 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_outf1 % $frac }}</td>
                <td class="right">{{ $tot_cp_outq3 + ($tot_cp_outf3 > 0 ? floor($tot_cp_outf3 / $frac) : ceil($tot_cp_outf3 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_outf3 % $frac }}</td>
                <td class="right">{{ $tot_cp_intrq + ($tot_cp_intrf > 0 ? floor($tot_cp_intrf / $frac) : ceil($tot_cp_intrf / $frac)) }}</td>
                <td class="right">{{ $tot_cp_intrf % $frac }}</td>
                <td class="right">{{ $tot_cp_inq4 + ($tot_cp_inf4 > 0 ? floor($tot_cp_inf4 / $frac) : ceil($tot_cp_inf4 / $frac)) }}</td>
                <td class="right">{{ $tot_cp_inf4 % $frac }}</td>
                <td class="right">{{ $tot_cp_sakhirq + ($tot_cp_sakhirf > 0 ? floor($tot_cp_sakhirf / $frac) : ceil($tot_cp_sakhirf / $frac)) }}</td>
                <td class="right">{{ $tot_cp_sakhirf % $frac }}</td>
            </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
