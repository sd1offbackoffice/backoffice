@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height','850pt')
@section('paper_width','1600pt')

@section('page_title')
    Daftar Pembelian Rincian Divisi / Departemen / Kategori
@endsection

@section('title')
    Daftar Pembelian Rincian Produk Per Divisi / Departemen / Kategori
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
        $st_div_potongan = 0;
        $st_div_disc = 0;
        $st_div_ppn = 0;
        $st_div_gross = 0;
        $st_div_bm = 0;
        $st_div_btl = 0;
        $st_div_tn = 0;

        $st_dep_gross = 0;
        $st_dep_potongan = 0;
        $st_dep_disc = 0;
        $st_dep_ppn = 0;
        $st_dep_bm = 0;
        $st_dep_btl = 0;
        $st_dep_tn = 0;

        $st_kat_gross = 0;
        $st_kat_potongan = 0;
        $st_kat_disc = 0;
        $st_kat_ppn = 0;
        $st_kat_bm = 0;
        $st_kat_btl = 0;
        $st_kat_tn = 0;

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
        {{--style="border-top: 1px solid black;border-bottom: 1px solid black;"--}}
        <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <th colspan="2" class="tengah padding-right">---BPB---</th>
            <th rowspan="2" class="tengah right padding-right">PLU</th>
            <th rowspan="2" class="tengah left">NAMA BARANG</th>
            <th rowspan="2" class="tengah left">KEMASAN</th>
            <th rowspan="2" class="tengah right padding-right">HARGA BELI</th>
            <th colspan="2" class="tengah ">-KUANTUM-</th>
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
            <th class="left">NOMOR</th>
            <th class="left">TANGGAL</th>
            <th class="right">CTN</th>
            <th class="right">PCS</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->mstd_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="17"><b>{{$data[$i]->mstd_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->mstd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="17"><b>{{$data[$i]->mstd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif
            @if($tempkat != $data[$i]->mstd_kodekategoribrg)
                <tr>
                    <td class="left"><b>KATEGORI</b></td>
                    <td class="left" colspan="17"><b>{{$data[$i]->mstd_kodekategoribrg}}
                            - {{$data[$i]->kat_namakategori}}</b></td>
                </tr>
            @endif
            <tr>
                <td class="left">{{ $data[$i]->no_doc }}</td>
                <td class="left">{{ date("d/m/Y", strtotime($data[$i]->tgl_doc)) }}</td>
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
                $st_dep_gross += $data[$i]->gross;
                $st_dep_potongan += $data[$i]->potongan;
                $st_dep_ppn += $data[$i]->ppn;
                $st_dep_bm += $data[$i]->bm;
                $st_dep_btl += $data[$i]->btl;
                $st_dep_tn += $data[$i]->total;

                $st_div_gross += $data[$i]->gross;
                $st_div_potongan += $data[$i]->potongan;
                $st_div_ppn += $data[$i]->ppn;
                $st_div_bm += $data[$i]->bm;
                $st_div_btl += $data[$i]->btl;
                $st_div_tn += $data[$i]->total;

                $st_kat_gross += $data[$i]->gross;
                $st_kat_potongan += $data[$i]->potongan;
                $st_kat_ppn += $data[$i]->ppn;
                $st_kat_bm += $data[$i]->bm;
                $st_kat_btl += $data[$i]->btl;
                $st_kat_tn += $data[$i]->total;

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

                $tempdiv = $data[$i]->mstd_kodedivisi;
                $tempdep = $data[$i]->mstd_kodedepartement;
                $tempkat = $data[$i]->mstd_kodekategoribrg;
            @endphp
            @if((isset($data[$i+1]->mstd_kodekategoribrg) && $tempkat != $data[$i+1]->mstd_kodekategoribrg) || !(isset($data[$i+1]->mstd_kodekategoribrg)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL KATEGORI</td>
                    <td class="left" colspan="8">{{ $data[$i]->mstd_kodekategoribrg }} - {{ $data[$i]->kat_namakategori }}</td>
                    <td class="right">{{ number_format($st_kat_gross,2) }}</td>
                    <td class="right">{{ number_format($st_kat_potongan,2) }}</td>
                    <td class="right">{{ number_format($st_kat_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_kat_bm ,2) }}</td>
                    <td class="right">{{ number_format($st_kat_btl,2) }}</td>
                    <td class="right padding-right">{{ number_format($st_kat_tn,2) }}</td>
                    <td class="right" colspan="3"></td>
                </tr>
                @php
                    $skipdiv = false;
                    $st_kat_gross = 0;
                    $st_kat_potongan = 0;
                    $st_kat_ppn = 0;
                    $st_kat_bm = 0;
                    $st_kat_btl = 0;
                    $st_kat_tn = 0;
                @endphp
            @endif
            @if( isset($data[$i+1]->mstd_kodedepartement) && $tempdep != $data[$i+1]->mstd_kodedepartement || !(isset($data[$i+1]->mstd_kodedepartement)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DEPT</td>
                    <td class="left" colspan="8">{{ $data[$i]->mstd_kodedepartement }} - {{$data[$i]->dep_namadepartement}}</td>
                    <td class="right">{{ number_format( $st_dep_gross,2) }}</td>
                    <td class="right">{{ number_format($st_dep_potongan,2) }}</td>
                    <td class="right">{{ number_format($st_dep_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_dep_bm ,2) }}</td>
                    <td class="right">{{ number_format($st_dep_btl,2) }}</td>
                    <td class="right padding-right">{{ number_format($st_dep_tn,2) }}</td>
                    <td class="right" colspan="3"></td>
                </tr>
                @php
                    $st_dep_gross = 0;
                    $st_dep_potongan = 0;
                    $st_dep_ppn = 0;
                    $st_dep_bm = 0;
                    $st_dep_btl = 0;
                    $st_dep_tn = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->mstd_kodedivisi) && $tempdiv != $data[$i+1]->mstd_kodedivisi) || !(isset($data[$i+1]->mstd_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left">SUB TOTAL DIVISI</td>
                    <td class="left" colspan="8">{{ $data[$i]->mstd_kodedivisi }} - {{ $data[$i]->div_namadivisi }}</td>
                    <td class="right">{{ number_format( $st_div_gross,2) }}</td>
                    <td class="right">{{ number_format($st_div_potongan,2) }}</td>
                    <td class="right">{{ number_format($st_div_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_div_bm ,2) }}</td>
                    <td class="right">{{ number_format($st_div_btl,2) }}</td>
                    <td class="right padding-right">{{ number_format($st_div_tn,2) }}</td>
                    <td class="right" colspan="3"></td>
                </tr>
                @php
                    $skipdiv = false;
                    $st_div_gross = 0;
                    $st_div_potongan = 0;
                    $st_div_ppn = 0;
                    $st_div_bm = 0;
                    $st_div_btl = 0;
                    $st_div_tn = 0;
                @endphp
            @endif

        @endfor
        </tbody>
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
    </table>
@endsection
