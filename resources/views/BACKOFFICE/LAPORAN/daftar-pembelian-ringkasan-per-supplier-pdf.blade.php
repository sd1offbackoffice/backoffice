@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Daftar Pembelian Ringkasan Per Supplier
@endsection

@section('title')
    Daftar Pembelian Ringkasan Per Supplier
@endsection

@section('subtitle')
    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection
    @php
        $tempdiv = '';
        $tempdep = '';
        $tempkat = '';
        $totaldiv = 0;
        $totaldep = 0;
        $totalkat = 0;
        $total = 0;
        $skipdep = false;

        $st_div_gross = 0;
        $st_div_pot = 0;
        $st_div_disc = 0;
        $st_div_ppn = 0;
        $st_div_gross = 0;
        $st_div_bm = 0;
        $st_div_btl = 0;
        $st_div_tn = 0;

        $st_dep_gross = 0;
        $st_dep_pot = 0;
        $st_dep_disc = 0;
        $st_dep_ppn = 0;
        $st_dep_bm = 0;
        $st_dep_btl = 0;
        $st_dep_tn = 0;

        $sum_gross_bkp=0;
        $sum_gross_btkp=0;
        $sum_potongan_bkp=0;
        $sum_potongan_btkp=0;
        $sum_ppn_bkp=0;
        $sum_ppn_btkp=0;
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
        <tr>
            <th class="left" width="10%">KODE</th>
            <th class="left" width="20%">NAMA SUPPLIER</th>
            <th class="right" width="10%">GROSS</th>
            <th class="right" width="10%">POTONGAN</th>
            <th class="right" width="10%">PPN</th>
            <th class="right" width="10%">BM</th>
            <th class="right" width="10%">BTL</th>
            <th class="right" width="10%">TOTAL NILAI</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td class="left">{{ $data[$i]->mstd_kodesupplier }}</td>
                <td class="left">{{ $data[$i]->sup_namasupplier }}</td>
                <td class="right">{{ number_format($data[$i]->gross,2) }}</td>
                <td class="right">{{ number_format($data[$i]->pot,2) }}</td>
                <td class="right">{{ number_format($data[$i]->ppn,2) }}</td>
                <td class="right">{{ number_format($data[$i]->bm,2) }}</td>
                <td class="right">{{ number_format($data[$i]->btl,2) }}</td>
                <td class="right">{{ number_format($data[$i]->total,2) }}</td>
            </tr>
            @php
                $sum_gross_bkp += $data[$i]->sum_gross_bkp;
                $sum_potongan_bkp += $data[$i]->sum_potongan_bkp;
                $sum_ppn_bkp += $data[$i]->sum_ppn_bkp;
                $sum_bm_bkp += $data[$i]->sum_bm_bkp;
                $sum_btl_bkp += $data[$i]->sum_btl_bkp;
                $sum_total_bkp += $data[$i]->sum_total_bkp;

                $sum_gross_btkp += $data[$i]->sum_gross_btkp;
                $sum_potongan_btkp += $data[$i]->sum_potongan_btkp;
                $sum_ppn_btkp += $data[$i]->sum_ppn_btkp;
                $sum_bm_btkp += $data[$i]->sum_bm_btkp;
                $sum_btl_btkp += $data[$i]->sum_btl_btkp;
                $sum_total_btkp += $data[$i]->sum_total_btkp;

            @endphp
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL BKP</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_total_bkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL BTKP</strong></th>
            <th class="right">{{ number_format($sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_total_btkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_bkp+$sum_bm_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_bkp+$sum_btl_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
