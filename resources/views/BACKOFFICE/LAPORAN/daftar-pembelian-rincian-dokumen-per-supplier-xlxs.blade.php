

    @php
        $tempsup = '';
        $tempdoc = $data[0]->msth_nodoc;

        $totaldiv = 0;
        $totaldep = 0;
        $totalkat = 0;
        // $total = 0;
        $skipdep = false;

        $ppn_bebas = 0;
        $ppn_dtp = 0;
        $ppn = 0;
        $dpp = 0;
        $gross = 0;
        $potongan = 0;
        $total = 0;

        $st_doc_ppn = 0;
        $st_doc_ppn_bebas = 0;
        $st_doc_ppn_dtp = 0;

        $st_sup_gross = 0;
        $st_sup_potongan = 0;
        $st_sup_disc = 0;
        $st_sup_ppn = 0;
        $st_sup_gross = 0;
        $st_sup_ppn_bebas = 0;
        $st_sup_ppn_dtp = 0;
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
        $sum_ppn_bebas_bkp=0;
        $sum_ppn_bebas_btkp=0;
        $sum_ppn_dtp_bkp=0;
        $sum_ppn_dtp_btkp=0;
        $sum_total_bkp=0;
        $sum_total_btkp=0;
    @endphp
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        {{--style="border-top: 1px solid black;border-bottom: 1px solid black;"--}}
        <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" colspan="2" align="center"> BPB </th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right" >TOP</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="left" >J.TEMPO</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" colspan="2" align="center" >PO</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" colspan="2" align="center" > FAKTUR </th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right" >GROSS</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right" >POTONGAN</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right" >PPN DIBEBASKAN</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right" >PPN DTP</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right" >DPP</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right" >PPN</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right" >TOTAL NILAI</th>
        </tr>
        <tr>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;">NOMOR</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;">TANGGAL</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;">NOMOR</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;">TANGGAL</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;">NOMOR</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;">TANGGAL</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempsup != $data[$i]->supplier)
                <tr>
                    <td style="font-weight:bold" align="left" colspan="15"><b>SUPPLIER    : {{$data[$i]->supplier}} </b></td>
                </tr>
            @endif
            @php
                $gross += $data[$i]->gross;
                $potongan += $data[$i]->potongan;
                $dpp += $data[$i]->dpp;
                $total += $data[$i]->total;
                if($data[$i]->prd_flagbkp1 == 'Y'){
                    if($data[$i]->prd_flagbkp2 == 'P'){
                        $ppn_bebas = $data[$i]->ppn;
                        $ppn_dtp = 0;
                        $ppn = 0;
                    }
                    else if ($data[$i]->prd_flagbkp2 == 'W' || $data[$i]->prd_flagbkp2 == 'G'){
                        $ppn_dtp = $data[$i]->ppn;
                        $ppn_bebas = 0;
                        $ppn =0;
                    }
                    else{
                        $ppn = $data[$i]->ppn;
                        $ppn_bebas = 0;
                        $ppn_dtp = 0;
                    }
                }
                else{
                    $ppn = $data[$i]->ppn;
                    $ppn_bebas = 0;
                    $ppn_dtp = 0;
                }

                $st_doc_ppn = 0;
                $st_doc_ppn_bebas = 0;
                $st_doc_ppn_dtp = 0;

                $st_sup_gross += $data[$i]->gross;
                $st_sup_potongan += $data[$i]->potongan;
                $st_sup_ppn += $ppn;
                $st_sup_dpp += $data[$i]->dpp;
                $st_sup_ppn_bebas += $ppn_bebas;
                $st_sup_ppn_dtp += $ppn_dtp;
                $st_sup_tn += $data[$i]->total;

                $sum_gross_bkp += $data[$i]->sum_gross_bkp;
                $sum_potongan_bkp += $data[$i]->sum_potongan_bkp;
                $sum_ppn_bkp += $ppn;
                $sum_dpp_btkp += $data[$i]->sum_dpp_bkp;
                $sum_ppn_bebas_bkp += $ppn_bebas;
                $sum_ppn_dtp_bkp += $ppn_dtp;
                $sum_total_bkp += $data[$i]->sum_total_bkp;

                $sum_gross_btkp += $data[$i]->sum_gross_btkp;
                $sum_potongan_btkp += $data[$i]->sum_potongan_btkp;
                $sum_ppn_btkp += $data[$i]->sum_ppn_btkp;
                $sum_dpp_btkp += $data[$i]->sum_dpp_btkp;
                $sum_ppn_bebas_btkp += $data[$i]->sum_bm_btkp;
                $sum_ppn_dtp_btkp += $data[$i]->sum_btl_btkp;
                $sum_total_btkp += $data[$i]->sum_total_btkp;

                $tempsup = $data[$i]->supplier;

            @endphp
            @if( (isset($data[$i+1]) && $tempdoc != $data[$i+1]->msth_nodoc) || !isset($data[$i+1]) )
                <tr>
                    {{-- <td class="left">{{ $data[$i]->mstd_kodekategoribrg }}</td>
                    <td class="left">{{ $data[$i]->kat_namakategori }}</td>
                    <td class="right">{{ number_format($gross,2) }}</td>
                    <td class="right">{{ number_format($pot,2) }}</td>
                    <td class="right">{{ number_format($disc4,2) }}</td>
                    <td class="right">{{ number_format($st_kat_ppn,2) }}</td>
                    <td class="right">{{ number_format($st_kat_ppn_bebas,2) }}</td>
                    <td class="right">{{ number_format($st_kat_ppn_dtp,2) }}</td>
                    <td class="right">{{ number_format($total,2) }}</td> --}}

                    <td align="left">{{ $data[$i]->msth_nodoc }}</td>
                    <td align="left">{{date("d/m/Y", strtotime($data[$i]->msth_tgldoc))}}</td>
                    <td align="right">{{ number_format($data[$i]->top,2) }}</td>
                    <td align="right">{{ date("d/m/Y", strtotime($data[$i]->jth_tempo)) }}</td>
                    <td align="right">{{ $data[$i]->msth_kodesupplier }}</td>
                    <td align="right">{{ date("d/m/Y", strtotime($data[$i]->msth_tglpo)) }}</td>
                    <td align="right">{{ $data[$i]->msth_nofaktur}}</td>
                    <td align="right">{{ date("d/m/Y", strtotime($data[$i]->msth_tglfaktur)) }}</td>
                    <td align="right">{{ number_format($gross,2) }}</td>
                    <td align="right">{{ number_format($potongan,2) }}</td>
                    <td align="right">{{ number_format($ppn_bebas,2) }}</td>
                    <td align="right">{{ number_format($ppn_dtp,2) }}</td>
                    <td align="right">{{ number_format($dpp,2) }}</td>
                    <td align="right">{{ number_format($ppn,2) }}</td>
                    <td align="right">{{ number_format($total,2) }}</td>
                </tr>

                @php
                    $tempdoc = isset($data[$i+1])  ? $data[$i+1]->msth_nodoc : 0;

                    $gross = 0;
                    $potongan =   0;
                    $total = 0;
                    $ppn = 0;
                    $dpp = 0;
                    $ppn_bebas = 0;
                    $ppn_dtp = 0;
                    $st_doc_ppn = 0;
                    $st_doc_ppn_bebas = 0;
                    $st_doc_ppn_dtp = 0;
                @endphp
            @endif

            @if((isset($data[$i+1]->supplier) && $tempsup != $data[$i+1]->supplier) || !(isset($data[$i+1]->supplier)) )
                <tr >
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="left">SUB TOTAL SUPPLIER</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="left" colspan="7">{{ $data[$i]->supplier }} </td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_gross,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_potongan,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_ppn_bebas ,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_ppn_dtp,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_dpp,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_ppn,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_tn,2) }}</td>
                </tr>
                @php
                    $st_sup_gross = 0;
                    $st_sup_potongan = 0;
                    $st_sup_ppn = 0;
                    $st_sup_ppn_bebas = 0;
                    $st_sup_ppn_dtp = 0;
                    $st_sup_tn = 0;
                    $st_sup_dpp = 0;
                @endphp
            @endif
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <td style="font-weight:bold;" align="left" colspan="8"><strong>TOTAL BKP</strong></td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_gross_bkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_potongan_bkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bebas_bkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_ppn_dtp_bkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_dpp_bkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_total_bkp ,2) }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold;" align="left" colspan="8"><strong>TOTAL BTKP</strong></td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_gross_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_potongan_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bebas_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_ppn_dtp_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_dpp_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_ppn_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_total_btkp ,2) }}</td>
        </tr>
        <tr>
            <td style="font-weight:bold;" align="left" colspan="8"><strong>TOTAL SELURUHNYA</strong></td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bebas_bkp+$sum_ppn_bebas_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_ppn_dtp_bkp+$sum_ppn_dtp_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_dpp_bkp+$sum_dpp_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</td>
            <td style="font-weight:bold;" align="right">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</td>
        </tr>
        </tfoot>
    </table>
