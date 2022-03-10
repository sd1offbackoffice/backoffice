@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    DAFTAR RETUR PEMBELIAN
@endsection

@section('title')
    DAFTAR RETUR PEMBELIAN
@endsection

@section('header_right')
    Rincian Produk Per Supplier
@endsection

@section('subtitle')
    Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection
@section('paper_height')
    595pt
@endsection

@section('paper_width')
    1200pt
@endsection
@section('content')
    @php
        $tempsup = '';

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
        $st_sup_avg = 0;

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
        $sum_avg_bkp=0;
        $sum_avg_btkp=0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="2">---BPB---</th>
            <th rowspan="2" class="left" style="vertical-align: middle;">PLU</th>
            <th rowspan="2" class="left" style="vertical-align: middle;">NAMA BARANG</th>
            <th rowspan="2" class="left" style="vertical-align: middle;">KEMASAN</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">HARGA BELI</th>
            <th colspan="2" style="vertical-align: middle;">-KUANTUM-</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">GROSS</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">POTONGAN</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">PPN</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">PPN-BM</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">BOTOL</th>
            <th rowspan="2" class="right padding-right" style="vertical-align: middle;">TOTAL NILAI</th>
            <th rowspan="2" class="left" style="vertical-align: middle;">KETERANGAN</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">LCOST</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">ACOST</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">TOT.Nl AVERAGE</th>
        </tr>
        <tr>
            <th class="left">NOMOR</th>
            <th class="left">TANGGAL</th>
            <th class="right">CTN</th>
            <th class="right">PCS</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
                @if($tempsup != $data[$i]->mstd_kodesupplier)
                    <tr>
                        <td class="left" colspan="17"><b>SUPPLIER    : {{$data[$i]->mstd_kodesupplier}} - {{$data[$i]->sup_namasupplier}} </b></td>
                    </tr>
                @endif
            <tr>
                <td class="left">{{ $data[$i]->msth_nodoc }}</td>
                <td class="left">{{ date('d/m/Y',strtotime(substr($data[$i]->msth_tgldoc,0,10)))  }}</td>
                <td class="left">{{ $data[$i]->plu }}</td>
                <td class="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td class="left">{{ $data[$i]->kemasan }}</td>
                <td class="right">{{ number_format($data[$i]->mstd_hrgsatuan,2) }}</td>
                <td class="right">{{ $data[$i]->ctn }}</td>
                <td class="right">{{ $data[$i]->pcs }}</td>
                <td class="right">{{ number_format($data[$i]->gross,2) }}</td>
                <td class="right">{{ number_format($data[$i]->potongan,2) }}</td>
                <td class="right">{{ number_format($data[$i]->ppn,2) }}</td>
                <td class="right">{{ number_format($data[$i]->bm,2) }}</td>
                <td class="right">{{ number_format($data[$i]->btl,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->total,2) }}</td>
                <td class="left">{{ $data[$i]->mstd_keterangan }}</td>
                <td class="right">{{ number_format($data[$i]->lcost,2) }}</td>
                <td class="right">{{ number_format($data[$i]->acost,2) }}</td>
                <td class="right">{{ number_format($data[$i]->avgcost,2) }}</td>
            </tr>
            @php
                $st_sup_gross += $data[$i]->gross;
                $st_sup_potongan += $data[$i]->potongan;
                $st_sup_ppn += $data[$i]->ppn;
                $st_sup_bm += $data[$i]->bm;
                $st_sup_btl += $data[$i]->btl;
                $st_sup_tn += $data[$i]->total;
                $st_sup_avg += $data[$i]->avgcost;

                $sum_gross_bkp += $data[$i]->gross;
                $sum_potongan_bkp += $data[$i]->potongan;
                $sum_ppn_bkp += $data[$i]->ppn;
                $sum_bm_bkp += $data[$i]->bm;
                $sum_btl_bkp += $data[$i]->btl;
                $sum_total_bkp += $data[$i]->total;
                $sum_avg_bkp += $data[$i]->avgcost;

                $sum_gross_btkp += $data[$i]->gross;
                $sum_potongan_btkp += $data[$i]->potongan;
                $sum_ppn_btkp += $data[$i]->ppn;
                $sum_bm_btkp += $data[$i]->bm;
                $sum_btl_btkp += $data[$i]->btl;
                $sum_total_btkp += $data[$i]->total;
                $sum_avg_btkp += $data[$i]->avgcost;

                $tempsup = $data[$i]->mstd_kodesupplier;
            @endphp
            @if((isset($data[$i+1]->mstd_kodesupplier) && $tempsup != $data[$i+1]->mstd_kodesupplier) || !(isset($data[$i+1]->mstd_kodesupplier)) )
                <tr style="border-bottom: 1px solid black;">
                    <th class="left">SUB TOTAL SUPPLIER</th>
                    <th class="left" colspan="7">{{ $data[$i]->mstd_kodesupplier }} - {{ $data[$i]->sup_namasupplier }}</th>
                    <th class="right">{{ number_format( $st_sup_gross,2) }}</th>
                    <th class="right">{{ number_format($st_sup_potongan,2) }}</th>
                    <th class="right">{{ number_format($st_sup_ppn,2) }}</th>
                    <th class="right">{{ number_format($st_sup_bm ,2) }}</th>
                    <th class="right">{{ number_format($st_sup_btl,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_sup_tn,2) }}</th>
                    <th class="right" colspan="3"></th>
                    <th class="right">{{ number_format($st_sup_avg,2) }}</th>
                </tr>
                @php
                    $st_sup_gross = 0;
                    $st_sup_potongan = 0;
                    $st_sup_ppn = 0;
                    $st_sup_bm = 0;
                    $st_sup_btl = 0;
                    $st_sup_tn = 0;
                    $st_sup_avg = 0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot>
        <tr>
            <th class="left" colspan="8"><strong>TOTAL BKP</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_bkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_total_bkp ,2) }}</th>
            <th colspan="3"></th>
            <th class="right">{{ number_format($sum_avg_bkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="8"><strong>TOTAL BTKP</strong></th>
            <th class="right">{{ number_format($sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_btkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_total_btkp ,2) }}</th>
            <th colspan="3"></th>
            <th class="right">{{ number_format($sum_avg_btkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="8"><strong>TOTAL SELURUHNYA</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_bkp+$sum_bm_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_bkp+$sum_btl_btkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</th>
            <th colspan="3"></th>
            <th class="right">{{ number_format($sum_avg_bkp+$sum_avg_btkp ,2) }}</th>
        </tr>
        </tfoot>
    </table>
    @endsection
