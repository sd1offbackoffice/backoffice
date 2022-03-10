@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    DAFTAR RETUR PEMBELIAN
@endsection

@section('title')
    DAFTAR RETUR PEMBELIAN
@endsection

@section('header_right')
    Rincian Dokumen Per Supplier
@endsection

@section('subtitle')
    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')

    @php
        $tempsup = '';
        $tempdoc = '';

        $totaldiv = 0;
        $totaldep = 0;
        $totalkat = 0;
        $total = 0;
        $skipdep = false;

        $st_sup_gross = 0;
        $st_sup_potongan = 0;
        $st_sup_disc = 0;
        $st_sup_ppn = 0;
        $st_sup_gross = 0;
        $st_sup_bm = 0;
        $st_sup_btl = 0;
        $st_sup_tn = 0;
        $st_sup_dpp =0;
        $st_sup_avg =0;

        $sum_gross_bkp=0;
        $sum_gross_btkp=0;
        $sum_potongan_bkp=0;
        $sum_potongan_btkp=0;
        $sum_ppn_bkp=0;
        $sum_ppn_btkp=0;
        $sum_dpp_bkp=0;
        $sum_dpp_btkp=0;
        $sum_bm_bkp=0;
        $sum_bm_btkp=0;
        $sum_btl_bkp=0;
        $sum_btl_btkp=0;
        $sum_total_bkp=0;
        $sum_total_btkp=0;
        $sum_avg_bkp=0;
        $sum_avg_btkp=0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="left" colspan="2">--------------- NPB ---------------</th>
            <th class="left" colspan="2">------------ NOTA RETUR ------------</th>
            <th class="right padding-right" rowspan="2" style="vertical-align: middle;">GROSS</th>
            <th class="right padding-right" rowspan="2" style="vertical-align: middle;">POTONGAN</th>
            <th class="right padding-right" rowspan="2" style="vertical-align: middle;">PPN-BM</th>
            <th class="right padding-right" rowspan="2" style="vertical-align: middle;">BOTOL</th>
            <th class="right padding-right" rowspan="2" style="vertical-align: middle;">DPP</th>
            <th class="right padding-right" rowspan="2" style="vertical-align: middle;">PPN</th>
            <th class="right padding-right" rowspan="2" style="vertical-align: middle;">TOTAL <br>NILAI</th>
            <th class="right padding-right" rowspan="2" style="vertical-align: middle;">TOT. NILAI <br>AVERAGE</th>
        </tr>
        <tr>
            <th class="left">NOMOR</th>
            <th class="left">TANGGAL</th>
            <th class="left">NOMOR</th>
            <th class="left">TANGGAL</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
                @if($tempsup != $data[$i]->supplier)
                    <tr>
                        <td class="left" colspan="12"><b>SUPPLIER    : {{$data[$i]->supplier}} </b></td>
                    </tr>
                @endif
            <tr>
                <td class="left">{{ $data[$i]->msth_nodoc }}</td>
                <td class="left">{{ date('d/m/Y',strtotime(substr($data[$i]->msth_tgldoc,0,10))) }}</td>
                <td class="left">{{ $data[$i]->noretur }}</td>
                <td class="left">{{ isset($data[$i]->tglretur)?date('d/m/Y',strtotime(substr($data[$i]->tglretur,0,10))):'' }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->gross,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->potongan,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->bm,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->btl,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->dpp,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->ppn,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->total,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->avgcost,2) }}</td>
            </tr>
            @php
                $st_sup_gross += $data[$i]->gross;
                $st_sup_potongan += $data[$i]->potongan;
                $st_sup_ppn += $data[$i]->ppn;
                $st_sup_dpp += $data[$i]->dpp;
                $st_sup_bm += $data[$i]->bm;
                $st_sup_btl += $data[$i]->btl;
                $st_sup_tn += $data[$i]->total;
                $st_sup_avg += $data[$i]->avgcost;

                $sum_gross_bkp += $data[$i]->gross;
                $sum_potongan_bkp += $data[$i]->potongan;
                $sum_ppn_bkp += $data[$i]->ppn;
                $sum_dpp_btkp += $data[$i]->dpp;
                $sum_bm_bkp += $data[$i]->bm;
                $sum_btl_bkp += $data[$i]->btl;
                $sum_total_bkp += $data[$i]->total;
                $sum_avg_bkp += $data[$i]->avgcost;

                $sum_gross_btkp += $data[$i]->gross;
                $sum_potongan_btkp += $data[$i]->potongan;
                $sum_ppn_btkp += $data[$i]->ppn;
                $sum_dpp_btkp += $data[$i]->dpp;
                $sum_bm_btkp += $data[$i]->bm;
                $sum_btl_btkp += $data[$i]->btl;
                $sum_total_btkp += $data[$i]->total;
                $sum_avg_btkp += $data[$i]->avgcost;

                $tempsup = $data[$i]->supplier;
            @endphp
            @if((isset($data[$i+1]->supplier) && $tempsup != $data[$i+1]->supplier) || !(isset($data[$i+1]->supplier)) )
                <tr style="border-bottom: 1px solid black;">
                    <th class="left">SUB TOTAL SUPPLIER</th>
                    <th class="left" colspan="3">{{ $data[$i]->supplier }} </th>
                    <th class="right padding-right">{{ number_format($st_sup_gross,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_sup_potongan,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_sup_bm ,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_sup_btl,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_sup_dpp,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_sup_ppn,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_sup_tn,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_sup_avg,2) }}</th>
                </tr>
                @php
                    $st_sup_gross = 0;
                    $st_sup_potongan = 0;
                    $st_sup_ppn = 0;
                    $st_sup_bm = 0;
                    $st_sup_btl = 0;
                    $st_sup_tn = 0;
                    $st_sup_dpp = 0;
                    $st_sup_avg = 0;
                @endphp
            @endif
        @endfor
        </tbody>
        <tr>
            <th class="left" colspan="4"><strong>TOTAL BKP</strong></th>
            <th class="right  padding-right">{{ number_format($sum_gross_bkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_potongan_bkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_bm_bkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_btl_bkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_dpp_bkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_ppn_bkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_total_bkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_avg_bkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="4"><strong>TOTAL BTKP</strong></th>
            <th class="right  padding-right">{{ number_format($sum_gross_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_potongan_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_bm_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_btl_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_dpp_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_ppn_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_total_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_avg_btkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="4"><strong>TOTAL SELURUHNYA</strong></th>
            <th class="right  padding-right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_bm_bkp+$sum_bm_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_btl_bkp+$sum_btl_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_dpp_bkp+$sum_dpp_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</th>
            <th class="right  padding-right">{{ number_format($sum_avg_bkp+$sum_avg_btkp ,2) }}</th>
        </tr>
    </table>
@endsection
