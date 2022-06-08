@extends('BACKOFFICE.TRANSAKSI.PENGELUARAN.cetakulangfakturpajak-template')

@section('table_font_size','7 px')

@section('page_title')
    CETAK ULANG FAKTUR PAJAK
@endsection

@section('title')
    {{-- ** CETAK ULANG FAKTUR PAJAK ** --}}
@endsection

@section('subtitle')
    {{-- NPB: {{$npb1}} s/d {{$npb2}} --}}
@endsection

@section('content')
    <style>

        table.table-bordered {
            border: 1px solid pink;
        }

        .border-pink {
            border: 1px 1px 1px 1px solid pink;
        }

        .border-bottom-pink {
            border-bottom: 1px solid pink;
        }

        .border-top-pink {
            border-top: 1px solid pink;
        }

        .border-left-pink {
            border-left: 1px solid pink;
        }

        .border-right-pink {
            border-right: 1px solid pink;
        }

    </style>
    @php
        $temp_noref3 ="";
        $no =1;
    @endphp
    @for ($i=0;$i<sizeof($data);$i++)
        @php
            $datetime = new DateTime();
            $timezone = new DateTimeZone('Asia/Jakarta');
            $datetime->setTimezone($timezone);
            $maxno = 15;
            $index = 1;
            $cf_fakturpjk = '';
            $cf_nofak = '';
            $f_1 = '';
            $flag = '';
            $faktur = '';
            $cf_skp_sup = '';

            $nQty2 = floor($data[$i]->mstd_qty / $data[$i]->mstd_frac);
            $nQtyK = fmod($data[$i]->mstd_qty, $data[$i]->mstd_frac);

            if ($data[$i]->mstd_unit == "KG") {
                $nQty = ((($nQty2) * $data[$i]->mstd_frac) + ($nQtyK)) / $data[$i]->mstd_frac;
            } else {
                $nQty = (($nQty2) * $data[$i]->mstd_frac) + $nQtyK;
            }    

            $nGross = $data[$i]->mstd_gross - $data[$i]->mstd_discrph;
            $nPrice = ($nGross / ($nQty2 * $data[$i]->mstd_frac + $nQtyK));


            $cf_fakturpjk = $data[$i]->mstd_istype . '.' . $data[$i]->mstd_invno;
            $cf_nofak = $data[$i]->prs_kodemto . '.' . substr($data[$i]->msth_tgldoc, 8, 2) . '.0' . $data[$i]->mstd_docno2 . $data[$i]->msth_flagdoc == 'T' ? '*' : '';
            if ($data[$i]->sup_tglsk) {
                $cf_skp_sup = $data[$i]->sup_nosk . ' Tanggal PKP : ' . date('d-M-y', strtotime(substr($data[$i]->sup_tglsk, 0, 10)));
            } else {
                $cf_skp_sup = $data[$i]->sup_nosk;
            }
            $f_1 = $data[$i]->sup_namanpwp ? $data[$i]->sup_namanpwp : $data[$i]->sup_namasupplier . " " . $data[$i]->sup_singkatansupplier;
            $flag = $data[$i]->msth_flagdoc==1?'*':'';
            $faktur = $data[$i]->prs_kodemto.'.' . substr($data[$i]->msth_tgldoc,9,2) . '.0'.$data[$i]->mstd_docno2.$flag;
        @endphp

        @if($temp_noref3 != trim($data[$i]->mstd_noref3))
            @php

                $temp_noref3 = trim($data[$i]->mstd_noref3);
                $index = 1;
                $no=1;
                $totalGross = 0;
                $totalPPN = 0;

            @endphp
            <table class="table">

                <tr>
                    <th class="border-top-pink border-right-pink border-left-pink" style="text-align:center;font-size:10px" colspan="7"><b>NOTA
                            RETUR</b></th>
                </tr>
                <tr>
                    <th colspan="5" class="border-left-pink"></th>
                    <th style="text-align:center;" colspan="1">
                        Nomor: {{ $data[$i]->mstd_docno2 }}</th>
                    <th colspan="1" class="border-right-pink"></th>
                </tr>
                <tr>
                    <th class="border-bottom-pink border-right-pink border-left-pink" style="text-align:center" colspan="7">Atas Faktur Pajak
                        Nomor: {{$data[$i]->mstd_istype.'.'.$data[$i]->mstd_invno}} &nbsp;
                        Tanggal: {{date('d-m-Y', strtotime(substr($data[$i]->mstd_date3, 0, 10)))}}</th>
                </tr>
                <tr>
                    <th align="left" class="border-left-pink border-right-pink" colspan="7" style="font-size:8px"><b>&nbsp; PEMBELI</b></th>
                </tr>
                <tr>
                    <td align="left" class="border-left-pink" colspan="2">&nbsp; Nama</td>
                    <td align="left" class="border-right-pink" colspan="5"><b>&nbsp; : {{ $data[$i]->prs_namaperusahaan }}</b></td>
                </tr>
                <tr>
                    <td align="left" class="border-left-pink" colspan="2">&nbsp; Alamat</td>
                    <td align="left" class="border-right-pink" colspan="5">&nbsp; : {{ $data[$i]->const_addr }}</td>
                </tr>
                <tr style="border-bottom: 1px solid pink">
                    <td align="left" class="border-left-pink" style="border-bottom: 1px solid pink" colspan="2">&nbsp; N.P.W.P</td>
                    <td align="left" class="border-right-pink" colspan="5" style="border-bottom: 1px solid pink">&nbsp;
                        : {{ $data[$i]->prs_npwp }}</td>
                </tr>
                <tr>
                    <th align="left" class="border-left-pink border-right-pink" colspan="7" style="font-size:8px"><b>&nbsp; KEPADA PENJUAL</b></th>
                </tr>
                <tr>
                    <td align="left" class="border-left-pink" colspan="2">&nbsp; Nama</td>
                    <td align="left" class="border-right-pink" colspan="5">&nbsp; : {{ $f_1 }}</td>
                </tr>
                <tr>
                    <td align="left" class="border-left-pink" colspan="2">&nbsp; Alamat</td>
                    <td align="left" class="border-right-pink" colspan="5">&nbsp; : {{ $data[$i]->addr_sup }}</td>
                </tr>
                <tr>
                    <td align="left" class="border-left-pink" colspan="2">&nbsp; N.P.W.P</td>
                    <td align="left" class="border-right-pink" colspan="5">&nbsp; : {{ $data[$i]->sup_npwp }}</td>
                </tr>
                <tr>
                    <td align="left" class="border-left-pink" colspan="2" style="border-bottom: 1px solid pink">&nbsp; No. Pengukuhan PKP</td>
                    <td align="left" class="border-right-pink" colspan="5" style="border-bottom: 1px solid pink">&nbsp;: {{ $cf_skp_sup }}</td>
                </tr>
                <tr style="border-bottom: 1px solid pink; border-top: 1px solid pink;">
                    <th colspan="1" class="border-right-pink border-left-pink" scope="col">No.<br>Urut</th>
                    <th colspan="3" class="border-right-pink" scope="col">Macam dan Jenis<br>Barang Kena Pajak</th>
                    <th class="border-right-pink" scope="col">Kuantum</th>
                    <th class="border-right-pink" scope="col">Harga Satuan Menurut<br>Faktur Pajak<br>(Rp.)</th>
                    <th class="border-right-pink" scope="col">Harga BKP<br>yang dikembalikan<br>(Rp.)</th>
                </tr>
        @endif

                <tr>
                    <th class="border-pink" scope="row">{{ $no }}.</th>
                    <td class="border-pink" colspan="3">{{ $data[$i]->prd_deskripsipanjang }}</td>
                    <td class="border-pink"
                        style="text-align:right; padding-right:10px;">{{ number_format($nQty, 0) }}</td>
                    <td class="border-pink"
                        style="text-align:right; padding-right:10px;">{{ number_format($nPrice, 0) }}</td>
                    <td class="border-pink"
                        style="text-align:right; padding-right:10px;">{{ number_format($nGross, 0) }}</td>
                </tr>
                @php
                    $totalGross+=$nGross;
                    $totalPPN+=$data[$i]->mstd_ppnrph;
                    $no++;
                @endphp
        @if(!isset($data[$i+1]->mstd_noref3) || ($temp_noref3 != $data[$i+1]->mstd_noref3 && isset($data[$i+1])) )
                @if($no<=$maxno)
                    @for($no ;$no<=$maxno;$no++)
                        <tr>
                            <th class="border-pink" scope="row">{{ $no }}.</th>
                            <td class="border-pink" colspan="3"></td>
                            <td class="border-pink" style="text-align:right; padding-right:10px;"></td>
                            <td class="border-pink" style="text-align:right; padding-right:10px;"></td>
                            <td class="border-pink" style="text-align:right; padding-right:10px;"></td>
                        </tr>
                    @endfor
                @endif

                <tr>
                    <td colspan="6" class="border-pink" align="left">&nbsp; Jumlah Harga BKP yang dikembalikan</td>
                    <td class="border-pink" align="right"
                        style="padding-right:10px;"> {{ number_format($totalGross, 0) }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="border-pink" align="left">&nbsp; Pajak Pertambahan Nilai yang diminta kembali
                    </td>
                    <td class="border-pink" align="right"
                        style="padding-right:10px;">{{ number_format(floor($totalPPN), 0) }}</td>
                </tr>

                <tr>
                    <td colspan="6" class="border-pink" align="left">&nbsp; Pajak Penjualan Atas Barang Mewah yang diminta
                        kembali
                    </td>
                    <td class="border-pink" align="right"
                        style="padding-right:10px;">{{ number_format(floor($nGross * 0), 0) }}</td>
                </tr>
                <tr>
                    <td colspan="7" class="border-left-pink border-right-pink">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="6" class="border-left-pink"></td>
                    <td colspan="1" align="left" class="border-right-pink">
                        {{ $data[$i]->prs_namawilayah }}, {{ date("d-m-Y") }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="border-left-pink"></td>
                    <td align="center" class="border-right-pink">
                        <img style="margin-right:2%;" width="60px" src="../storage/signature/ljm.png" alt="">
                    </td>
                </tr>
                <tr >
                    <td colspan="6" class="border-left-pink"></td>
                    <td align="left" class="border-right-pink">
                        {{ file_get_contents('../storage/names/ljm.txt') }}
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="6" class="border-left-pink">
                        &nbsp; NRB : {{ $data[$i]->msth_nodoc }}
                    </td>
                    <td class="border-top-pink border-right-pink" align="left">
                        Logistik Mgr
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="7" class="m-0 p-0 border-top-pink border-left-pink border-right-pink">
                        &nbsp; Lembar ke-1: Untuk Pengusaha Kena Pajak yang Menerbitkan Faktur Pajak.
                    </td>
                </tr>
                <tr>
                    <td align="left" colspan="7" class="m-0 p-0 border-left-pink border-bottom-pink border-right-pink">
                        &nbsp; Lembar ke-2: Untuk Pembeli.
                    </td>
                </tr>

        </table>
            @if($i != sizeof($data)-1)
                <div class="pagebreak"></div>
            @endif
        @endif

    @endfor

@endsection
