@extends('html-template')

@section('table_font_size','7 px')
@section('paper_height','850pt')
@section('paper_width','1100pt')
@section('page_title')
    Daftar Pembelian Rincian Produk Per Supplier Per Dokumen
@endsection

@section('title')
    Daftar Pembelian Rincian Produk Per Supplier Per Dokumen
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

    $st_doc_gross = 0;
    $st_doc_potongan = 0;
    $st_doc_disc = 0;
    $st_doc_ppn = 0;
    $st_doc_gross = 0;
    $st_doc_bm = 0;
    $st_doc_btl = 0;
    $st_doc_tn = 0;

    $st_sup_gross = 0;
    $st_sup_potongan = 0;
    $st_sup_disc = 0;
    $st_sup_ppn = 0;
    $st_sup_gross = 0;
    $st_sup_bm = 0;
    $st_sup_btl = 0;
    $st_sup_tn = 0;

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
        <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <th colspan="2" class="tengah">---BPB---</th>
            <th rowspan="2" class="tengah left">PLU</th>
            <th rowspan="2" class="tengah left">NAMA BARANG</th>
            <th rowspan="2" class="tengah left">KEMASAN</th>
            <th rowspan="2" class="tengah right padding-right">HARGA BELI</th>
            <th colspan="2" class="tengah">-KUANTUM-</th>
            <th rowspan="2" class="tengah right">BONUS</th>
            <th rowspan="2" class="tengah right">GROSS</th>
            <th rowspan="2" class="tengah right">POTONGAN</th>
            <th rowspan="2" class="tengah right">PPN</th>
            <th rowspan="2" class="tengah right">PPN-BM</th>
            <th rowspan="2" class="tengah right">BOTOL</th>
            <th rowspan="2" class="tengah right padding-right">TOTAL NILAI</th>
            <th rowspan="2" class="tengah left">KETERANGAN</th>
            <th rowspan="2" class="tengah right">LCOST</th>
            <th rowspan="2" class="tengah right">ACOST</th>
        </tr>
        <tr>
            <th class="tengah left">NOMOR</th>
            <th class="tengah left">TANGGAL</th>
            <th class="tengah right">CTN</th>
            <th class="tengah right">PCS</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempsup != $data[$i]->msth_kodesupplier)
                <tr>
                    <td class="left" colspan="21"><b>SUPPLIER : {{$data[$i]->msth_kodesupplier}}
                            - {{$data[$i]->sup_namasupplier}} </b></td>
                </tr>
            @endif
            @if($tempdoc != $data[$i]->msth_nodoc)
                <tr>
                    <td class="left" colspan="21"><b>NOMOR BPB : {{$data[$i]->msth_nodoc}} </b></td>
                </tr>
                <tr>
                    <td class="left" colspan="21"><b>Tanggal : {{date("d/m/Y", strtotime($data[$i]->msth_tgldoc))}} </b></td>
                </tr>
            @endif
            <tr>
                <td class="left">{{ $data[$i]->msth_nodoc }}</td>
                <td class="left">{{ date("d/m/Y", strtotime($data[$i]->msth_tgldoc)) }}</td>
                <td class="left">{{ $data[$i]->plu }}</td>
                <td class="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td class="left">{{ $data[$i]->kemasan }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->mstd_hrgsatuan, 2, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->ctn, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->pcs, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->bonus, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($data[$i]->gross,2) }}</td>
                <td class="right">{{ number_format($data[$i]->potongan,2) }}</td>
                <td class="right">{{ number_format($data[$i]->ppn,2) }}</td>
                <td class="right">{{ number_format($data[$i]->bm,2) }}</td>
                <td class="right">{{ number_format($data[$i]->btl,2) }}</td>
                <td class="right padding-right">{{ number_format($data[$i]->total,2) }}</td>
                <td class="left">{{ $data[$i]->mstd_keterangan }}</td>
                <td class="right">{{ number_format($data[$i]->lcost,2) }}</td>
                <td class="right">{{ number_format($data[$i]->acost,2) }}</td>
            </tr>
            @php
                $st_sup_gross += $data[$i]->gross;
                $st_sup_potongan += $data[$i]->potongan;
                $st_sup_ppn += $data[$i]->ppn;
                $st_sup_bm += $data[$i]->bm;
                $st_sup_btl += $data[$i]->btl;
                $st_sup_tn += $data[$i]->total;

                $st_doc_gross += $data[$i]->gross;
                $st_doc_potongan += $data[$i]->potongan;
                $st_doc_ppn += $data[$i]->ppn;
                $st_doc_bm += $data[$i]->bm;
                $st_doc_btl += $data[$i]->btl;
                $st_doc_tn += $data[$i]->total;

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

                $tempsup = $data[$i]->msth_kodesupplier;
                $tempdoc = $data[$i]->msth_nodoc;
            @endphp
            @if((isset($data[$i+1]->msth_nodoc) && $tempdoc != $data[$i+1]->msth_nodoc) || !(isset($data[$i+1]->msth_nodoc)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL BPB</td>
                    <td class="left" colspan="8">{{ $data[$i]->msth_nodoc }} </td>
                    <td class="right">{{ number_format($st_doc_gross,2) }}</td>
                    <td class="right">{{ number_format($st_doc_potongan,2) }}</td>
                    <td class="right">{{ number_format($st_doc_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_doc_bm ,2) }}</td>
                    <td class="right">{{ number_format($st_doc_btl,2) }}</td>
                    <td class="right padding-right">{{ number_format($st_doc_tn,2) }}</td>
                    <td class="right" colspan="3"></td>
                </tr>
                @php
                    $st_doc_gross = 0;
                    $st_doc_potongan = 0;
                    $st_doc_ppn = 0;
                    $st_doc_bm = 0;
                    $st_doc_btl = 0;
                    $st_doc_tn = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->msth_kodesupplier) && $tempsup != $data[$i+1]->msth_kodesupplier) || !(isset($data[$i+1]->msth_kodesupplier)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL SUPPLIER</td>
                    <td class="left" colspan="8">{{ $data[$i]->msth_kodesupplier }}
                        - {{ $data[$i]->sup_namasupplier }}</td>
                    <td class="right">{{ number_format($st_sup_gross,2) }}</td>
                    <td class="right">{{ number_format($st_sup_potongan,2) }}</td>
                    <td class="right">{{ number_format($st_sup_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_sup_bm ,2) }}</td>
                    <td class="right">{{ number_format($st_sup_btl,2) }}</td>
                    <td class="right padding-right">{{ number_format($st_sup_tn,2) }}</td>
                    <td class="right" colspan="3"></td>
                </tr>
                @php
                    $st_sup_gross = 0;
                    $st_sup_potongan = 0;
                    $st_sup_ppn = 0;
                    $st_sup_bm = 0;
                    $st_sup_btl = 0;
                    $st_sup_tn = 0;
                @endphp
            @endif
        @endfor
        <tr>
            <th class="left" colspan="9"><strong>TOTAL BKP</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_bkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_total_bkp ,2) }}</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th class="left" colspan="9"><strong>TOTAL BTKP</strong></th>
            <th class="right">{{ number_format($sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_btkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_total_btkp ,2) }}</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th class="left" colspan="9"><strong>TOTAL SELURUHNYA</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_bm_bkp+$sum_bm_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_btl_bkp+$sum_btl_btkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</th>
            <th colspan="3"></th>
        </tr>
        </tbody>
    </table>
@endsection
