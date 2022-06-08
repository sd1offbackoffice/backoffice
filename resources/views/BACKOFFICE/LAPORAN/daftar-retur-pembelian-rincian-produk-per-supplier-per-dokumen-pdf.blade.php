@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    DAFTAR RETUR PEMBELIAN
@endsection

@section('title')
    DAFTAR RETUR PEMBELIAN
@endsection

@section('header_right')
    Rincian Produk Per Supplier Per Dokumen
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
        $st_doc_tn = 0;
        $st_doc_avg = 0;
        $st_doc_ppn_bebas = 0;
        $st_doc_ppn_dtp = 0;

        $st_sup_gross = 0;
        $st_sup_potongan = 0;
        $st_sup_disc = 0;
        $st_sup_ppn = 0;
        $st_sup_gross = 0;                
        $st_sup_tn = 0;
        $st_sup_avg = 0;
        $st_sup_ppn_bebas = 0;
        $st_sup_ppn_dtp = 0;

        $sum_gross_bkp=0;
        $sum_gross_btkp=0;
        $sum_potongan_bkp=0;
        $sum_potongan_btkp=0;
        $sum_ppn_bkp=0;
        $sum_ppn_btkp=0;                                
        $sum_total_bkp=0;
        $sum_total_btkp=0;
        $sum_avg_bkp=0;
        $sum_avg_btkp=0;
        $sum_ppn_bebas_bkp = 0;
        $sum_ppn_bebas_btkp = 0;
        $sum_ppn_dtp_bkp = 0;
        $sum_ppn_dtp_btkp = 0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr >
            <th colspan="2">---BPB---</th>
            <th rowspan="2" class="left" style="vertical-align: middle;">PLU</th>
            <th rowspan="2" class="left" style="vertical-align: middle;">NAMA BARANG</th>
            <th rowspan="2" class="left" style="vertical-align: middle;">KEMASAN</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">HARGA BELI</th>
            <th colspan="2" class="right" style="vertical-align: middle;">-KUANTUM-</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">GROSS</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">POTONGAN</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">PPN</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">PPN DIBEBASKAN</th>
            <th rowspan="2" class="right" style="vertical-align: middle;">PPN DTP</th>                        
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
            @php                
            @endphp

                @if($tempsup != $data[$i]->mstd_kodesupplier)
                    <tr>
                        <td class="left" colspan="21"><b>SUPPLIER    : {{$data[$i]->mstd_kodesupplier}} - {{$data[$i]->sup_namasupplier}} </b></td>
                    </tr>
                @endif
                @if($tempdoc != $data[$i]->msth_nodoc)
                    <tr>
                        <td class="left" colspan="21"><b>NOMOR BPB    : {{$data[$i]->msth_nodoc}} </b></td>
                    </tr>
                    <tr>
                        <td class="left" colspan="21"><b>Tanggal    : {{date('d/m/Y',strtotime(substr($data[$i]->msth_tgldoc,0,10))) }} </b></td>
                    </tr>
                @endif
            <tr>
                <td class="left">{{ $data[$i]->msth_nodoc }}</td>
                <td class="left">{{ date('d/m/Y',strtotime(substr($data[$i]->msth_tgldoc,0,10))) }}</td>
                <td class="left">{{ $data[$i]->plu }}</td>
                <td class="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td class="left">{{ $data[$i]->kemasan }}</td>
                <td class="right">{{ number_format($data[$i]->mstd_hrgsatuan,2) }}</td>
                <td class="right">{{ $data[$i]->ctn }}</td>
                <td class="right">{{ $data[$i]->pcs }}</td>
                <td class="right">{{ number_format($data[$i]->gross,2) }}</td>
                <td class="right">{{ number_format($data[$i]->potongan,2) }}</td>
                {{-- <td class="right">{{ number_format($data[$i]->ppn,2) }}</td> --}}
                <td class="right">                    
                    @php
                        if ($data[$i]->prd_flagbkp1 == 'Y' && $data[$i]->prd_flagbkp2 == 'Y') {
                            $ppn_rph = $data[$i]->ppn;
                        } else {
                            $ppn_rph = 0;
                        }                        
                    @endphp
                    {{ number_format($ppn_rph,2) }}
                </td>
                <td class="right">                    
                    @php
                        if ($data[$i]->prd_flagbkp1 == 'Y' && $data[$i]->prd_flagbkp2 == 'P') {
                            $ppn_bebas = $data[$i]->ppn;
                        } else {
                            $ppn_bebas = 0;
                        }                        
                    @endphp
                    {{ number_format($ppn_bebas,2) }}
                </td>
                <td class="right">                    
                    @php
                        if ($data[$i]->prd_flagbkp1 == 'Y' && ($data[$i]->prd_flagbkp2 == 'W' || $data[$i]->prd_flagbkp2 == 'G')) {
                            $ppn_dtp = $data[$i]->ppn;
                        } else {
                            $ppn_dtp = 0;
                        }                        
                    @endphp
                    {{ number_format($ppn_dtp,2) }}
                </td>                                
                <td class="right padding-right">{{ number_format($data[$i]->total,2) }}</td>
                <td class="left">{{ $data[$i]->mstd_keterangan }}</td>
                <td class="right">{{ number_format($data[$i]->lcost,2) }}</td>
                <td class="right">{{ number_format($data[$i]->acost,2) }}</td>
                <td class="right">{{ number_format($data[$i]->avgcost,2) }}</td>
            </tr>
            @php
                        $st_sup_gross += $data[$i]->gross;
                        $st_sup_potongan += $data[$i]->potongan;
                        $st_sup_ppn += $ppn_rph;                                                
                        $st_sup_tn += $data[$i]->total;
                        $st_sup_avg += $data[$i]->avgcost;
                        $st_sup_ppn_bebas += $ppn_bebas;
                        $st_sup_ppn_dtp += $ppn_dtp;

                        $st_doc_gross += $data[$i]->gross;
                        $st_doc_potongan += $data[$i]->potongan;
                        $st_doc_ppn += $ppn_rph;                                                
                        $st_doc_tn += $data[$i]->total;
                        $st_doc_avg += $data[$i]->avgcost;
                        $st_doc_ppn_bebas += $ppn_bebas;
                        $st_doc_ppn_dtp += $ppn_dtp;

                        $sum_gross_bkp += $data[$i]->gross;
                        $sum_potongan_bkp += $data[$i]->potongan;
                        $sum_ppn_bkp += $ppn_rph;                                                
                        $sum_total_bkp += $data[$i]->total;
                        $sum_avg_bkp += $data[$i]->avgcost;
                        $sum_ppn_bebas_bkp += $ppn_bebas;
                        $sum_ppn_dtp_bkp += $ppn_dtp;

                        $sum_gross_btkp += $data[$i]->gross;
                        $sum_potongan_btkp += $data[$i]->potongan;
                        $sum_ppn_btkp += $ppn_rph;                                                
                        $sum_total_btkp += $data[$i]->total;
                        $sum_avg_btkp += $data[$i]->avgcost;
                        $sum_ppn_bebas_btkp += $ppn_bebas;
                        $sum_ppn_dtp_btkp += $ppn_dtp;

                        $tempsup = $data[$i]->mstd_kodesupplier;
                        $tempdoc = $data[$i]->msth_nodoc;
            @endphp
            @if((isset($data[$i+1]->msth_nodoc) && $tempdoc != $data[$i+1]->msth_nodoc) || !(isset($data[$i+1]->msth_nodoc)) )
                <tr style="border-bottom: 1px solid black;">
                    <th class="left">SUB TOTAL BPB</th>
                    <th class="left" colspan="7">{{ $data[$i]->msth_nodoc }} </th>
                    <th class="right">{{ number_format($st_doc_gross,2) }}</th>
                    <th class="right">{{ number_format($st_doc_potongan,2) }}</th>
                    <th class="right">{{ number_format($st_doc_ppn,2) }}</th>
                    <th class="right">{{ number_format($st_doc_ppn_bebas,2) }}</th>
                    <th class="right">{{ number_format($st_doc_ppn_dtp,2) }}</th>                                        
                    <th class="right padding-right">{{ number_format($st_doc_tn,2) }}</th>
                    <th class="right" colspan="3"></th>
                    <th class="right">{{ number_format($st_doc_avg,2) }}</th>
                </tr>
                @php
                    $st_doc_gross = 0;
                    $st_doc_potongan = 0;
                    $st_doc_ppn = 0;                                        
                    $st_doc_tn = 0;
                    $st_doc_ppn_bebas = 0;
                    $st_doc_ppn_dtp = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->mstd_kodesupplier) && $tempsup != $data[$i+1]->mstd_kodesupplier) || !(isset($data[$i+1]->mstd_kodesupplier)) )
                <tr style="border-bottom: 1px solid black;">
                    <th class="left">SUB TOTAL SUPPLIER</th>
                    <th class="left" colspan="7">{{ $data[$i]->mstd_kodesupplier }} - {{ $data[$i]->sup_namasupplier }}</th>
                    <th class="right">{{ number_format($st_sup_gross,2) }}</th>
                    <th class="right">{{ number_format($st_sup_potongan,2) }}</th>
                    <th class="right">{{ number_format($st_sup_ppn,2) }}</th>
                    <th class="right">{{ number_format($st_sup_ppn_bebas,2) }}</th>
                    <th class="right">{{ number_format($st_sup_ppn_dtp,2) }}</th>                                        
                    <th class="right padding-right">{{ number_format($st_sup_tn,2) }}</th>
                    <th class="right" colspan="3"></th>
                    <th class="right">{{ number_format($st_sup_avg,2) }}</th>
                </tr>
                @php
                    $st_sup_gross = 0;
                    $st_sup_potongan = 0;
                    $st_sup_ppn = 0;                                        
                    $st_sup_tn = 0;
                    $st_sup_ppn_bebas = 0;
                    $st_sup_dtp_bebas = 0;
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
            <th class="right">{{ number_format($sum_ppn_bebas_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_dtp_bkp ,2) }}</th>                        
            <th class="right padding-right">{{ number_format($sum_total_bkp ,2) }}</th>
            <th colspan="3"></th>
            <th class="right">{{ number_format($sum_avg_bkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="8"><strong>TOTAL BTKP</strong></th>
            <th class="right">{{ number_format($sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bebas_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_dtp_btkp ,2) }}</th>                        
            <th class="right padding-right">{{ number_format($sum_total_btkp ,2) }}</th>
            <th colspan="3"></th>
            <th class="right">{{ number_format($sum_avg_btkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="8"><strong>TOTAL SELURUHNYA</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_bebas_bkp+$sum_ppn_bebas_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_dtp_bkp+$sum_ppn_dtp_btkp ,2) }}</th>                        
            <th class="right padding-right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</th>
            <th colspan="3"></th>
            <th class="right">{{ number_format($sum_avg_bkp+$sum_avg_btkp ,2) }}</th>
        </tr>
        </tfoot>
    </table>
    @endsection
