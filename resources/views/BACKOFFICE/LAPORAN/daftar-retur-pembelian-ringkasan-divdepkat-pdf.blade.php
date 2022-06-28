@extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    DAFTAR RETUR PEMBELIAN
@endsection

@section('title')
    DAFTAR RETUR PEMBELIAN
@endsection
@section('header_right')
    Ringkasan Divisi / Departement / Kategori
@endsection
@section('subtitle')
Tanggal : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
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
        $st_div_tn = 0;
        $st_div_avg = 0;
        $st_div_ppn_bebas = 0;
        $st_div_ppn_dtp = 0;

        $st_dep_gross = 0;
        $st_dep_pot = 0;
        $st_dep_disc = 0;
        $st_dep_ppn = 0;
        $st_dep_tn = 0;
        $st_dep_avg = 0;
        $st_dep_ppn_bebas = 0;
        $st_dep_ppn_dtp = 0;

        $st_kat_gross = 0;
        $st_kat_potongan = 0;
        $st_kat_disc = 0;
        $st_kat_ppn = 0;
        $st_kat_tn = 0;
        $st_kat_avg = 0;
        $st_kat_ppn_bebas = 0;
        $st_kat_ppn_dtp = 0;

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
        <tr>
            <th class="left">KODE</th>
            <th class="left">NAMA KATEGORI</th>
            <th class="right">GROSS</th>
            <th class="right">POTONGAN</th>
            <th class="right padding-right">PPN</th>
            <th class="right padding-right">PPN<br>DIBEBASKAN</th>
            <th class="right">PPN DTP</th>
            <th class="right">TOTAL NILAI</th>
            <th class="right">TOTAL<br>NILAI AVG</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            {{-- @php
            $data[$i]->nlcost = (($data[$i]->gross - $data[$i]->pot + $data[$i]->bm + $data[$i]->btl) * $data[$i]->frac / ($data[$i]->ctn * $data[$i]->frac + $data[$i]->pcs + $data[$i]->bonus));
            @endphp --}}
            @if($tempdiv != $data[$i]->mstd_kodedivisi)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left"><b>{{$data[$i]->mstd_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->mstd_kodedepartement)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left"><b>{{$data[$i]->mstd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif            
            @php
            // switch ($data[$i]->prd_flagbkp1) {
            //     case 'Y':
            //         switch ($data[$i]->prd_flagbkp2) {
            //             case 'Y':
            //                 $data[$i]->ppn = $data[$i]->ppn;
            //                 break;
            //             case 'P':
            //                 $data[$i]->bebas = $data[$i]->bebas;
            //                 break;
            //             case 'W' || case 'G':
            //                 $data[$i]->dtp = $data[$i]->dtp;
            //                 break;
                        
            //             default:
            //                 # code...
            //                 break;
            //         }
            //         break;
                
            //     default:
            //         # code...
            //         break;
            // }               
                $st_dep_gross += $data[$i]->gross;
                $st_dep_pot += $data[$i]->pot;
                $st_dep_ppn += $data[$i]->ppn;
                $st_dep_tn += $data[$i]->total;
                $st_dep_avg += $data[$i]->avg;
                $st_dep_ppn_bebas += $data[$i]->bebas;
                $st_dep_ppn_dtp += $data[$i]->dtp;

                $st_div_gross += $data[$i]->gross;
                $st_div_potongan += $data[$i]->pot;
                $st_div_ppn += $data[$i]->ppn;
                $st_div_tn += $data[$i]->total;
                $st_div_avg += $data[$i]->avg;
                $st_div_ppn_bebas += $data[$i]->bebas;
                $st_div_ppn_dtp += $data[$i]->dtp;

                $st_kat_gross += $data[$i]->gross;
                $st_kat_potongan += $data[$i]->pot;
                $st_kat_ppn += $data[$i]->ppn;
                $st_kat_tn += $data[$i]->total;
                $st_kat_avg += $data[$i]->avg;
                $st_kat_ppn_bebas += $data[$i]->bebas;
                $st_kat_ppn_dtp += $data[$i]->dtp;

                $sum_gross_bkp += $data[$i]->bkpgross;
                $sum_potongan_bkp += $data[$i]->bkppot;
                $sum_ppn_bkp += $data[$i]->bkpppn;
                $sum_total_bkp += $data[$i]->bkptotal;
                $sum_avg_bkp += $data[$i]->bkpavg;
                $sum_ppn_bebas_bkp += $data[$i]->bebas;
                $sum_ppn_dtp_bkp += $data[$i]->dtp;

                $sum_gross_btkp += $data[$i]->btkpgross;
                $sum_potongan_btkp += $data[$i]->btkppot;
                $sum_ppn_btkp += $data[$i]->btkpppn;
                $sum_total_btkp += $data[$i]->btkptotal;
                $sum_avg_btkp += $data[$i]->btkpavg;
                $sum_ppn_bebas_btkp += $data[$i]->bebas;
                $sum_ppn_dtp_btkp += $data[$i]->dtp;

                $tempdiv = $data[$i]->mstd_kodedivisi;
                $tempdep = $data[$i]->mstd_kodedepartement;
                $tempkat = $data[$i]->mstd_kodekategoribrg;
            @endphp
            @if((isset($data[$i+1]->mstd_kodekategoribrg) && $tempkat != $data[$i+1]->mstd_kodekategoribrg) || !(isset($data[$i+1]->mstd_kodekategoribrg)) )
                <tr>                    
                    <td class="left">{{$data[$i]->mstd_kodekategoribrg}}</td>
                    <td class="left">{{$data[$i]->kat_namakategori}}</td>
                    <td class="right">{{ number_format($st_kat_gross,2) }}</td>
                    <td class="right">{{ number_format($st_kat_potongan,2) }}</td>
                    <td class="right padding-right">{{ number_format($st_kat_ppn,2) }}</td>
                    <td class="right padding-right">{{ number_format($st_kat_ppn_bebas,2) }}</td>
                    <td class="right">{{ number_format($st_kat_ppn_dtp,2) }}</td>
                    <td class="right">{{ number_format($st_kat_tn,2) }}</td>
                    <td class="right">{{ number_format($st_kat_avg,2) }}</td>
                </tr>
                @php
                    $skipdiv = false;
                    $st_kat_gross = 0;
                    $st_kat_potongan = 0;
                    $st_kat_ppn = 0;
                    $st_kat_tn = 0;
                    $st_kat_avg = 0;
                    $st_kat_ppn_bebas = 0;
                    $st_kat_ppn_dtp = 0;
                @endphp
            @endif
            @if( isset($data[$i+1]->mstd_kodedepartement) && $tempdep != $data[$i+1]->mstd_kodedepartement || !(isset($data[$i+1]->mstd_kodedepartement)) )
                <tr style="border-bottom: 1px solid black;font-style: bold">
                    <th class="left">SUB TOTAL DEPT</th>
                    <th class="left">{{ $data[$i]->mstd_kodedepartement }}</th>
                    <th class="right">{{ number_format( $st_dep_gross,2) }}</th>
                    <th class="right">{{ number_format($st_dep_pot,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_dep_ppn,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_dep_ppn_bebas,2) }}</th>
                    <th class="right">{{ number_format($st_dep_ppn_dtp,2) }}</th>
                    <th class="right">{{ number_format($st_dep_tn,2) }}</th>
                    <th class="right">{{ number_format($st_dep_avg,2) }}</th>
                </tr>
                @php
                    $st_dep_gross = 0;
                    $st_dep_pot = 0;
                    $st_dep_ppn = 0;
                    $st_dep_tn = 0;
                    $st_dep_avg = 0;
                    $st_dep_ppn_bebas = 0;
                    $st_dep_ppn_dtp = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->mstd_kodedivisi) && $tempdiv != $data[$i+1]->mstd_kodedivisi) || !(isset($data[$i+1]->mstd_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;font-style: bold">
                    <th class="left">SUB TOTAL DIVISI</th>
                    <th class="left">{{ $data[$i]->mstd_kodedivisi }} - {{ $data[$i]->div_namadivisi }}</th>
                    <th class="right">{{ number_format($st_div_gross,2) }}</th>
                    <th class="right">{{ number_format($st_div_potongan,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_div_ppn,2) }}</th>
                    <th class="right padding-right">{{ number_format($st_div_ppn_bebas,2) }}</th>
                    <th class="right">{{ number_format($st_div_ppn_dtp,2) }}</th>
                    <th class="right">{{ number_format($st_div_tn,2) }}</th>
                    <th class="right">{{ number_format($st_div_avg,2) }}</th>
                </tr>
                @php
                    $skipdiv = false;
                    $st_div_gross = 0;
                    $st_div_potongan = 0;
                    $st_div_ppn = 0;
                    $st_div_tn = 0;
                    $st_div_avg = 0;
                    $st_div_ppn_bebas = 0;
                    $st_div_ppn_dtp = 0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tfoot>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL BKP</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_ppn_bkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_ppn_bebas_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_dtp_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_total_bkp ,2) }}</th>
            <th class="right">{{ number_format($sum_avg_bkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL BTKP</strong></th>
            <th class="right">{{ number_format($sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_btkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_ppn_btkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_ppn_bebas_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_dtp_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_total_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_avg_btkp ,2) }}</th>
        </tr>
        <tr>
            <th class="left" colspan="2"><strong>TOTAL SELURUHNYA</strong></th>
            <th class="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</th>
            <th class="right padding-right">{{ number_format($sum_ppn_bebas_bkp+$sum_ppn_bebas_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_ppn_dtp_bkp+$sum_ppn_dtp_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</th>
            <th class="right">{{ number_format($sum_avg_bkp+$sum_avg_btkp ,2) }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
