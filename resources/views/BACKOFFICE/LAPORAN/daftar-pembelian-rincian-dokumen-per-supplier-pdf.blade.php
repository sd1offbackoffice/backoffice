@extends('html-template')

@section('table_font_size','7 px')
@section('paper_height','850pt')
@section('paper_width','1100pt')
@section('page_title')
    Daftar Pembelian Rincian Dokumen Per Supplier
@endsection

@section('title')
    Daftar Pembelian Rincian Dokumen Per Supplier
@endsection

@section('subtitle')
    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

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
    @endphp
@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        {{--style="border-top: 1px solid black;border-bottom: 1px solid black;"--}}
        <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <th colspan="2" class="tengah ">------- BPB -------</th>
            <th rowspan="2" class="tengah right" >TOP</th>
            <th rowspan="2" class="tengah left" >J.TEMPO</th>
            <th colspan="2" class="tengah " >------- PO -------</th>
            <th colspan="2" class="tengah " >------ FAKTUR ------</th>
            <th rowspan="2" class="tengah right" >-GROSS-</th>
            <th rowspan="2" class="tengah right" >POTONGAN</th>
            <th rowspan="2" class="tengah right" >PPN-BM</th>
            <th rowspan="2" class="tengah right" >BOTOL</th>
            <th rowspan="2" class="tengah right" >DPP</th>
            <th rowspan="2" class="tengah right" >PPN</th>
            <th rowspan="2" class="tengah right" >TOTAL NILAI</th>
        </tr>
        <tr>
            <th>NOMOR</th>
            <th>TANGGAL</th>
            <th>NOMOR</th>
            <th>TANGGAL</th>
            <th>NOMOR</th>
            <th>TANGGAL</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
                @if($tempsup != $data[$i]->supplier)
                    <tr>
                        <td class="left" colspan="21"><b>SUPPLIER    : {{$data[$i]->supplier}} </b></td>
                    </tr>
                @endif
            <tr>
                <td class="left">{{ $data[$i]->msth_nodoc }}</td>
                <td class="left">{{date("d/m/Y", strtotime($data[$i]->msth_tgldoc))}}</td>
                <td class="right">{{ number_format($data[$i]->top,2) }}</td>
                <td class="right">{{ date("d/m/Y", strtotime($data[$i]->jth_tempo)) }}</td>
                <td class="right">{{ $data[$i]->msth_kodesupplier }}</td>
                <td class="right">{{ date("d/m/Y", strtotime($data[$i]->msth_tglpo)) }}</td>
                <td class="right">{{ $data[$i]->msth_nofaktur}}</td>
                <td class="right">{{ date("d/m/Y", strtotime($data[$i]->msth_tglfaktur)) }}</td>
                <td class="right">{{ number_format($data[$i]->gross,2) }}</td>
                <td class="right">{{ number_format($data[$i]->potongan,2) }}</td>
                <td class="right">{{ number_format($data[$i]->bm,2) }}</td>
                <td class="right">{{ number_format($data[$i]->btl,2) }}</td>
                <td class="right">{{ number_format($data[$i]->dpp,2) }}</td>
                <td class="right">{{ number_format($data[$i]->ppn,2) }}</td>
                <td class="right">{{ number_format($data[$i]->total,2) }}</td>
            </tr>
            @php
                $st_sup_gross += $data[$i]->gross;
                $st_sup_potongan += $data[$i]->potongan;
                $st_sup_ppn += $data[$i]->ppn;
                $st_sup_dpp += $data[$i]->dpp;
                $st_sup_bm += $data[$i]->bm;
                $st_sup_btl += $data[$i]->btl;
                $st_sup_tn += $data[$i]->total;

                $sum_gross_bkp += $data[$i]->sum_gross_bkp;
                $sum_potongan_bkp += $data[$i]->sum_potongan_bkp;
                $sum_ppn_bkp += $data[$i]->sum_ppn_bkp;
                $sum_dpp_btkp += $data[$i]->sum_dpp_bkp;
                $sum_bm_bkp += $data[$i]->sum_bm_bkp;
                $sum_btl_bkp += $data[$i]->sum_btl_bkp;
                $sum_total_bkp += $data[$i]->sum_total_bkp;

                $sum_gross_btkp += $data[$i]->sum_gross_btkp;
                $sum_potongan_btkp += $data[$i]->sum_potongan_btkp;
                $sum_ppn_btkp += $data[$i]->sum_ppn_btkp;
                $sum_dpp_btkp += $data[$i]->sum_dpp_btkp;
                $sum_bm_btkp += $data[$i]->sum_bm_btkp;
                $sum_btl_btkp += $data[$i]->sum_btl_btkp;
                $sum_total_btkp += $data[$i]->sum_total_btkp;

                $tempsup = $data[$i]->supplier;
            @endphp
            @if((isset($data[$i+1]->supplier) && $tempsup != $data[$i+1]->supplier) || !(isset($data[$i+1]->supplier)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL SUPPLIER</td>
                    <td class="left" colspan="7">{{ $data[$i]->supplier }} </td>
                    <td class="right">{{ number_format($st_sup_gross,2) }}</td>
                    <td class="right">{{ number_format($st_sup_potongan,2) }}</td>
                    <td class="right">{{ number_format($st_sup_bm ,2) }}</td>
                    <td class="right">{{ number_format($st_sup_btl,2) }}</td>
                    <td class="right">{{ number_format($st_sup_dpp,2) }}</td>
                    <td class="right">{{ number_format($st_sup_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_sup_tn,2) }}</td>
                </tr>
                @php
                    $st_sup_gross = 0;
                    $st_sup_potongan = 0;
                    $st_sup_ppn = 0;
                    $st_sup_bm = 0;
                    $st_sup_btl = 0;
                    $st_sup_tn = 0;
                    $st_sup_dpp = 0;
                @endphp
            @endif
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td class="left" colspan="8"><strong>TOTAL BKP</strong></td>
            <td class="right">{{ number_format($sum_gross_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_potongan_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_bm_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_btl_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_dpp_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_ppn_bkp ,2) }}</td>
            <td class="right">{{ number_format($sum_total_bkp ,2) }}</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td class="left" colspan="8"><strong>TOTAL BTKP</strong></td>
            <td class="right">{{ number_format($sum_gross_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_potongan_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_bm_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_btl_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_dpp_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_ppn_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_total_btkp ,2) }}</td>
            <td colspan="3"></td>
        </tr>
        <tr>
            <td class="left" colspan="8"><strong>TOTAL SELURUHNYA</strong></td>
            <td class="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_bm_bkp+$sum_bm_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_btl_bkp+$sum_btl_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_dpp_bkp+$sum_dpp_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</td>
            <td class="right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</td>
            <td colspan="3"></td>
        </tr>
        </tfoot>
    </table>
    @endsection
