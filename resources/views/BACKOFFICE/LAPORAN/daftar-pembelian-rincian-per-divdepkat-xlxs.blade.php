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
    $st_div_ppn_bebas = 0;
    $st_div_ppn_dtp = 0;
    $st_div_tn = 0;
    

    $st_dep_gross = 0;
    $st_dep_potongan = 0;
    $st_dep_disc = 0;
    $st_dep_ppn = 0;
    $st_dep_ppn_bebas = 0;
    $st_dep_ppn_dtp = 0;
    $st_dep_tn = 0;

    $st_kat_gross = 0;
    $st_kat_potongan = 0;
    $st_kat_disc = 0;
    $st_kat_ppn = 0;
    $st_kat_ppn_bebas = 0;
    $st_kat_ppn_dtp = 0;
    $st_kat_tn = 0;

    $sum_gross_bkp=0;
    $sum_gross_btkp=0;
    $sum_potongan_bkp=0;
    $sum_potongan_btkp=0;
    $sum_ppn_bkp=0;
    $sum_ppn_btkp=0;
    $sum_ppn_bebas_bkp=0;
    $sum_ppn_bebas_btkp=0;
    $sum_ppn_dtp_bkp=0;
    $sum_ppn_dtp_btkp=0;
    $sum_total_bkp=0;
    $sum_total_btkp=0;
@endphp

    <table class="table">
        <thead>
        {{--style="border-top: 1px solid black;border-bottom: 1px solid black;"--}}
        <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" colspan="2" align="center">BPB</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="left">PLU</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="left">NAMA BARANG</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="left">KEMASAN</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">HARGA BELI</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" colspan="2" align="center">KUANTUM</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">BONUS</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">GROSS</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">POTONGAN</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">PPN</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">PPN DIBEBASKAN</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">PPN DTP</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">TOTAL NILAI</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">KETERANGAN</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">LCOST</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" align="right">ACOST</th>
        </tr>
        <tr>
            <th style="font-weight: bold;border-bottom: 1px solid black;" align="left">NOMOR</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;" align="left">TANGGAL</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;" align="right">CTN</th>
            <th style="font-weight: bold;border-bottom: 1px solid black;" align="right">PCS</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->mstd_kodedivisi)
                <tr>
                    <td align="left"><b>DIVISI</b></td>
                    <td align="left" colspan="17"><b>{{$data[$i]->mstd_kodedivisi}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->mstd_kodedepartement)
                <tr>
                    <td align="left"><b>DEPARTEMEN</b></td>
                    <td align="left" colspan="17"><b>{{$data[$i]->mstd_kodedepartement}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif
            @if($tempkat != $data[$i]->mstd_kodekategoribrg)
                <tr>
                    <td align="left"><b>KATEGORI</b></td>
                    <td align="left" colspan="17"><b>{{$data[$i]->mstd_kodekategoribrg}}
                            - {{$data[$i]->kat_namakategori}}</b></td>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $data[$i]->no_doc }}</td>
                <td align="left">{{ date("d/m/Y", strtotime($data[$i]->tgl_doc)) }}</td>
                <td align="left">{{ $data[$i]->plu }}</td>
                <td align="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td align="left">{{ $data[$i]->kemasan }}</td>
                <td align="right">{{ number_format($data[$i]->mstd_hrgsatuan, 2, '.', ',') }}</td>
                <td align="right">{{ number_format($data[$i]->ctn, 0, '.', ',') }}</td>
                <td align="right">{{ number_format($data[$i]->pcs, 0, '.', ',') }}</td>
                <td align="right">{{ number_format($data[$i]->bonus, 0, '.', ',') }}</td>
                <td align="right">{{ number_format($data[$i]->gross,2) }}</td>
                <td align="right">{{ number_format($data[$i]->potongan,2) }}</td>
                @if($data[$i]->prd_flagbkp1 == 'Y' )
                    @if($data[$i]->prd_flagbkp2 == 'Y')
                        @php
                            $ppn_bebas = 0;
                            $ppn_dtp = 0;
                            $ppn = $data[$i]->ppn;
                        @endphp
                        <td align="right">{{ number_format($ppn,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                    @elseif($data[$i]->prd_flagbkp2 == 'P')
                        @php
                            $ppn_bebas = $data[$i]->ppn;
                            $ppn_dtp = 0;
                            $ppn = 0;
                        @endphp
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format($ppn_bebas,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                    @elseif($data[$i]->prd_flagbkp2 == 'G' || $data[$i]->prd_flagbkp2 == 'W')
                        @php
                            $ppn_dtp = $data[$i]->ppn;
                            $ppn_bebas = 0;
                            $ppn = 0;
                        @endphp
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format($ppn_dtp,2) }}</td>
                    @else
                        @php
                            $ppn_bebas = 0;
                            $ppn_dtp = 0;
                            $ppn = $data[$i]->ppn;
                        @endphp
                        <td align="right">{{ number_format($ppn,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                    @endif
                @else
                    @php
                        $ppn_bebas = 0;
                        $ppn_dtp = 0;
                        $ppn = $data[$i]->ppn;
                    @endphp    
                    <td align="right">{{ number_format($ppn,2) }}</td>   
                    <td align="right">{{ number_format(0,2) }}</td>
                    <td align="right">{{ number_format(0,2) }}</td>
                @endif
                <td align="right">{{ number_format($data[$i]->total,2) }}</td>
                <td align="left">{{ $data[$i]->mstd_keterangan }}</td>
                <td align="right">{{ number_format($data[$i]->lcost,2) }}</td>
                <td align="right">{{ number_format($data[$i]->acost,2) }}</td>
            </tr>
            @php
                $st_dep_gross += $data[$i]->gross;
                $st_dep_potongan += $data[$i]->potongan;
                $st_dep_ppn += $ppn;
                $st_dep_ppn_bebas += $ppn_bebas;
                $st_dep_ppn_dtp += $ppn_dtp;
                $st_dep_tn += $data[$i]->total;

                $st_div_gross += $data[$i]->gross;
                $st_div_potongan += $data[$i]->potongan;
                $st_div_ppn += $ppn;
                $st_div_ppn_bebas += $ppn_bebas;
                $st_div_ppn_dtp +=  $ppn_dtp;
                $st_div_tn += $data[$i]->total;

                $st_kat_gross += $data[$i]->gross;
                $st_kat_potongan += $data[$i]->potongan;
                $st_kat_ppn += $ppn;
                $st_kat_ppn_bebas += $ppn_bebas;
                $st_kat_ppn_dtp +=  $ppn_dtp;
                $st_kat_tn += $data[$i]->total;

                $sum_gross_bkp += $data[$i]->sum_gross_bkp;
                $sum_potongan_bkp += $data[$i]->sum_potongan_bkp;
                $sum_ppn_bkp += $data[$i]->sum_ppn_bkp;
                $sum_ppn_bebas_bkp += $ppn_bebas;
                $sum_ppn_dtp_bkp +=  $ppn_dtp;
                $sum_total_bkp += $data[$i]->sum_total_bkp;

                $sum_gross_btkp += $data[$i]->sum_gross_btkp;
                $sum_potongan_btkp += $data[$i]->sum_potongan_btkp;
                $sum_ppn_btkp += $data[$i]->sum_ppn_btkp;
                    // $sum_ppn_bebas_btkp += $data[$i]->sum_ppn_btkp;
                    // $sum_ppn_dtp_btkp +=  $data[$i]->sum_ppn_btkp;
                $sum_total_btkp += $data[$i]->sum_total_btkp;

                $tempdiv = $data[$i]->mstd_kodedivisi;
                $tempdep = $data[$i]->mstd_kodedepartement;
                $tempkat = $data[$i]->mstd_kodekategoribrg;
            @endphp
            @if((isset($data[$i+1]->mstd_kodekategoribrg) && $tempkat != $data[$i+1]->mstd_kodekategoribrg) || !(isset($data[$i+1]->mstd_kodekategoribrg)) )
                <tr style="border-bottom: 1px solid black;">
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="left">SUB TOTAL KATEGORI</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="left" colspan="8">{{ $data[$i]->mstd_kodekategoribrg }} - {{ $data[$i]->kat_namakategori }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_kat_gross,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_kat_potongan,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_kat_ppn,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_kat_ppn_bebas ,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_kat_ppn_dtp,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_kat_tn,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right" colspan="3"></td>
                </tr>
                @php
                    $skipdiv = false;
                    $st_kat_gross = 0;
                    $st_kat_potongan = 0;
                    $st_kat_ppn = 0;
                    $st_kat_ppn_bebas = 0;
                    $st_kat_ppn_dtp = 0;
                    $st_kat_tn = 0;
                @endphp
            @endif
            @if( isset($data[$i+1]->mstd_kodedepartement) && $tempdep != $data[$i+1]->mstd_kodedepartement || !(isset($data[$i+1]->mstd_kodedepartement)) )
                <tr style="border-bottom: 1px solid black;">
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="left">SUB TOTAL DEPT</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="left" colspan="8">{{ $data[$i]->mstd_kodedepartement }} - {{$data[$i]->dep_namadepartement}}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format( $st_dep_gross,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_dep_potongan,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_dep_ppn,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_dep_ppn_bebas ,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_dep_ppn_dtp,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_dep_tn,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right" colspan="3"></td>
                </tr>
                @php
                    $st_dep_gross = 0;
                    $st_dep_potongan = 0;
                    $st_dep_ppn = 0;
                    $st_dep_ppn_bebas = 0;
                    $st_dep_ppn_dtp = 0;
                    $st_dep_tn = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->mstd_kodedivisi) && $tempdiv != $data[$i+1]->mstd_kodedivisi) || !(isset($data[$i+1]->mstd_kodedivisi)) )
                <tr style="border-bottom: 1px solid black;">
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="left">SUB TOTAL DIVISI</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="left" colspan="8">{{ $data[$i]->mstd_kodedivisi }} - {{ $data[$i]->div_namadivisi }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format( $st_div_gross,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_div_potongan,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_div_ppn,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_div_ppn_bebas ,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_div_ppn_dtp,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_div_tn,2) }}</td>
                    <td style="font-weight: bold;border-bottom: 1px solid black;" align="right" colspan="3"></td>
                </tr>
                @php
                    $skipdiv = false;
                    $st_div_gross = 0;
                    $st_div_potongan = 0;
                    $st_div_ppn = 0;
                    $st_div_ppn_bebas = 0;
                    $st_div_ppn_dtp = 0;
                    $st_div_tn = 0;
                @endphp
            @endif

        @endfor
        </tbody>
        <tr>
            <th align="left" colspan="9"><strong>TOTAL BKP</strong></th>
            <th align="right">{{ number_format($sum_gross_bkp ,2) }}</th>
            <th align="right">{{ number_format($sum_potongan_bkp ,2) }}</th>
            <th align="right">{{ number_format($sum_ppn_bkp ,2) }}</th>
            <th align="right">{{ number_format($sum_ppn_bebas_bkp ,2) }}</th>
            <th align="right">{{ number_format($sum_ppn_dtp_bkp ,2) }}</th>
            <th align="right">{{ number_format($sum_total_bkp ,2) }}</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th align="left" colspan="9"><strong>TOTAL BTKP</strong></th>
            <th align="right">{{ number_format($sum_gross_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_potongan_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_ppn_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_ppn_bebas_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_ppn_dtp_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_total_btkp ,2) }}</th>
            <th colspan="3"></th>
        </tr>
        <tr>
            <th align="left" colspan="9"><strong>TOTAL SELURUHNYA</strong></th>
            <th align="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_ppn_bebas_bkp+$sum_ppn_bebas_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_ppn_dtp_bkp+$sum_ppn_dtp_btkp ,2) }}</th>
            <th align="right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</th>
            <th colspan="3"></th>
        </tr>
    </table>
