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
    $st_doc_ppn_bebas = 0;
    $st_doc_ppn_dtp = 0;
    $st_doc_tn = 0;

    $st_sup_gross = 0;
    $st_sup_potongan = 0;
    $st_sup_disc = 0;
    $st_sup_ppn = 0;
    $st_sup_gross = 0;
    $st_sup_ppn_bebas = 0;
    $st_sup_ppn_dtp = 0;
    $st_sup_tn = 0;

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
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr >
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" colspan="2" align="">BPB</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="left">PLU</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="left">NAMA BARANG</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="left">KEMASAN</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right ">HARGA BELI</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" colspan="2" align="">-KUANTUM-</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">BONUS</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">GROSS</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">POTONGAN</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">PPN</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">PPN DIBEBASKAN</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">PPN DTP</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right ">TOTAL NILAI</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="left">KETERANGAN</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">LCOST</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2" align="right">ACOST</th>
        </tr>
        <tr>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">NOMOR</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">TANGGAL</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">CTN</th>
            <th style="font-weight:bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">PCS</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempsup != $data[$i]->msth_kodesupplier)
                <tr>
                    <td style="font-weight:bold;" align="left" colspan="21"><b>SUPPLIER : {{$data[$i]->msth_kodesupplier}}
                            - {{$data[$i]->sup_namasupplier}} </b></td>
                </tr>
            @endif
            @if($tempdoc != $data[$i]->msth_nodoc)
                <tr>
                    <td style="font-weight:bold;" align="left" colspan="21"><b>NOMOR BPB : {{$data[$i]->msth_nodoc}} </b></td>
                </tr>
                <tr>
                    <td style="font-weight:bold;" align="left" colspan="21"><b>Tanggal : {{date("d/m/Y", strtotime($data[$i]->msth_tgldoc))}} </b></td>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $data[$i]->msth_nodoc }}</td>
                <td align="left">{{ date("d/m/Y", strtotime($data[$i]->msth_tgldoc)) }}</td>
                <td align="left">{{ $data[$i]->plu }}</td>
                <td align="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td align="left">{{ $data[$i]->kemasan }}</td>
                <td align="right ">{{ number_format($data[$i]->mstd_hrgsatuan, 2, '.', ',') }}</td>
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
                <td align="right ">{{ number_format($data[$i]->total,2) }}</td>
                <td align="left">{{ $data[$i]->mstd_keterangan }}</td>
                <td align="right">{{ number_format($data[$i]->lcost,2) }}</td>
                <td align="right">{{ number_format($data[$i]->acost,2) }}</td>
            </tr>
            @php
                $st_sup_gross += $data[$i]->gross;
                $st_sup_potongan += $data[$i]->potongan;
                $st_sup_ppn += $ppn;
                $st_sup_ppn_bebas += $ppn_bebas;
                $st_sup_ppn_dtp += $ppn_dtp;
                $st_sup_tn += $data[$i]->total;

                $st_doc_gross += $data[$i]->gross;
                $st_doc_potongan += $data[$i]->potongan;
                $st_doc_ppn += $ppn;
                $st_doc_ppn_bebas += $ppn_bebas;
                $st_doc_ppn_dtp += $ppn_dtp;
                $st_doc_tn += $data[$i]->total;

                $sum_gross_bkp += $data[$i]->sum_gross_bkp;
                $sum_potongan_bkp += $data[$i]->sum_potongan_bkp;
                $sum_ppn_bkp += $data[$i]->sum_ppn_bkp;
                $sum_ppn_bebas_bkp += $ppn_bebas;
                $sum_ppn_dtp_bkp += $ppn_dtp;
                $sum_total_bkp += $data[$i]->sum_total_bkp;

                $sum_gross_btkp += $data[$i]->sum_gross_btkp;
                $sum_potongan_btkp += $data[$i]->sum_potongan_btkp;
                $sum_ppn_btkp += $data[$i]->sum_ppn_btkp;
                // $sum_ppn_bebas_btkp += $data[$i]->sum_bm_btkp;
                // $sum_ppn_dtp_btkp += $data[$i]->sum_btl_btkp;
                $sum_total_btkp += $data[$i]->sum_total_btkp;

                $tempsup = $data[$i]->msth_kodesupplier;
                $tempdoc = $data[$i]->msth_nodoc;
            @endphp
            @if((isset($data[$i+1]->msth_nodoc) && $tempdoc != $data[$i+1]->msth_nodoc) || !(isset($data[$i+1]->msth_nodoc)) )
                <tr style="border-bottom: 1px solid black;">
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="left">SUB TOTAL BPB</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="left" colspan="8">{{ $data[$i]->msth_nodoc }} </td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_doc_gross,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_doc_potongan,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_doc_ppn,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_doc_ppn_bebas ,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_doc_ppn_dtp,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right ">{{ number_format($st_doc_tn,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right" colspan="3"></td>
                </tr>
                @php
                    $st_doc_gross = 0;
                    $st_doc_potongan = 0;
                    $st_doc_ppn = 0;
                    $st_doc_ppn_bebas = 0;
                    $st_doc_ppn_dtp = 0;
                    $st_doc_tn = 0;
                @endphp
            @endif
            @if((isset($data[$i+1]->msth_kodesupplier) && $tempsup != $data[$i+1]->msth_kodesupplier) || !(isset($data[$i+1]->msth_kodesupplier)) )
                <tr style="border-bottom: 1px solid black;">
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="left">SUB TOTAL SUPPLIER</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="left" colspan="8">{{ $data[$i]->msth_kodesupplier }} - {{ $data[$i]->sup_namasupplier }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_gross,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_potongan,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_ppn,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_ppn_bebas ,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right">{{ number_format($st_sup_ppn_dtp,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right ">{{ number_format($st_sup_tn,2) }}</td>
                    <td style="font-weight:bold;border-bottom: 1px solid black;" align="right" colspan="3"></td>
                </tr>
                @php
                    $st_sup_gross = 0;
                    $st_sup_potongan = 0;
                    $st_sup_ppn = 0;
                    $st_sup_ppn_bebas = 0;
                    $st_sup_ppn_dtp = 0;
                    $st_sup_tn = 0;
                @endphp
            @endif
        @endfor
        <tr>
            <th style="font-weight:bold;" align="left" colspan="9"><strong>TOTAL BKP</strong></th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_gross_bkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_potongan_bkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bebas_bkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_ppn_dtp_bkp ,2) }}</th>
            <th style="font-weight:bold;" align="right ">{{ number_format($sum_total_bkp ,2) }}</th>
            <th style="font-weight:bold;" colspan="3"></th>
        </tr>
        <tr>
            <th style="font-weight:bold;" align="left" colspan="9"><strong>TOTAL BTKP</strong></th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_gross_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_potongan_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_ppn_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bebas_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_ppn_dtp_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right ">{{ number_format($sum_total_btkp ,2) }}</th>
            <th style="font-weight:bold;" colspan="3"></th>
        </tr>
        <tr>
            <th style="font-weight:bold;" align="left" colspan="9"><strong>TOTAL SELURUHNYA</strong></th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_gross_bkp+$sum_gross_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_potongan_bkp+$sum_potongan_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bkp+$sum_ppn_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_ppn_bebas_bkp+$sum_ppn_bebas_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right">{{ number_format($sum_ppn_dtp_bkp+$sum_ppn_dtp_btkp ,2) }}</th>
            <th style="font-weight:bold;" align="right ">{{ number_format($sum_total_bkp+$sum_total_btkp ,2) }}</th>
            <th style="font-weight:bold;" colspan="3"></th>
        </tr>
        </tbody>
    </table>
