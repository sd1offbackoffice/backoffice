@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    NOTA PENGELUARAN BARANG <br>{{ strtoupper($data['data1'][0]->judul) }}
@endsection

@section('title')
    NOTA PENGELUARAN BARANG <br>{{ strtoupper($data['data1'][0]->judul) }}
@endsection

@section('subtitle')

@endsection
@section('footer')

@endsection
@section('header_left')
    NPWP:{{ $perusahaan->prs_npwp }}

@endsection
@section('content')
    <style>
        .table-header thead tr td, .table-header tbody tr td {
            padding: 0;
            margin: 0;
        }
    </style>
    @php
        $nodoc='';
        $j=0;
        $showfooter = false;
    @endphp
    @for($i=0;$i<sizeof($data['data1']);$i++)
        @if($nodoc != $data['data1'][$i]->msth_nodoc)
            @php
                $nodoc = $data['data1'][$i]->msth_nodoc;
            @endphp
            <table class="table table-sm table-header">
                <thead>
                <tr>
                    <td class="left" colspan="4"></td>
                    <td class="left" width="10%"></td>
                    <td class="left">SUPPLIER :</td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->msth_kodesupplier }}
                        - {{ $data['data1'][$i]->namas }}</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="left" colspan="4"></td>
                    <td class="left"></td>
                    <td class="left">NPWP :</td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->sup_npwp }}</td>
                </tr>
                <tr>
                    <td class="left" colspan="4"></td>
                    <td class="left"></td>
                    <td class="left">ALAMAT :</td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->sup_alamatsupplier1 }}</td>
                </tr>
                <tr>
                    <td class="left" colspan="4"></td>
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->sup_alamatsupplier2 }}</td>
                </tr>
                <tr>
                    <td class="left"><b> {{ $data['data1'][$i]->status }} </b></td>
                    <td class="left" colspan="3"></td>
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->sup_kotasupplier3 }}</td>
                </tr>
                <tr>
                    <td class="left">NOMOR :</td>
                    <td class="left">{{ $data['data1'][$i]->msth_nodoc }}</td>
                    <td class="left">TGL NPB :</td>
                    <td class="left">{{strtoupper(date('d-M-y', strtotime($data['data1'][$i]->msth_tgldoc)))}}</td>
                    <td class="left"></td>
                    <td class="left">TELP :</td>
                    <td class="left">{{ $data['data1'][$i]->sup_telpsupplier }}</td>
                    <td class="right">CP :</td>
                    <td class="left">{{ $data['data1'][$i]->sup_contactperson }}</td>
                </tr>
                @php
                    $no=0;
                @endphp
                @while($j<sizeof($data['data2']) )
                    <tr>
                        <td class="left">@if($no == 0) FAKTUR PAJAK : @endif</td>
                        <td class="left">{{$data['data2'][$j]->nofp }}</td>
                        <td class="left">@if($no == 0) TGL FP : @endif</td>
                        <td class="left">{{strtoupper(date('d-M-y', strtotime($data['data2'][$j]->mstd_date3)))}}</td>
                        @php
                            $j++;
                            $no++;
                        @endphp
                        @if($j+1<sizeof($data['data2']) )
                            @if($data['data2'][$j+1]->nodoc == $nodoc)

                                <td class="left"></td>
                                <td class="left">@if($no == 1) FAKTUR PAJAK : @endif</td>
                                <td class="left">{{$data['data2'][$j]->nofp }}</td>
                                <td class="right">@if($no == 1) TGL FP : @endif</td>
                                <td class="left">{{strtoupper(date('d-M-y', strtotime($data['data2'][$j]->mstd_date3)))}}</td>
                                @php
                                    $j++;
                                @endphp
                            @endif
                        @endif

                    </tr>
                    @if($j<sizeof($data['data2']) )
                        @if($data['data2'][$j]->nodoc != $nodoc)
                            @break
                        @endif
                    @endif

                @endwhile
                </tbody>
            </table>
            <table class="table">
                <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <tr>
                    <th class="tengah right padding-right" rowspan="2">NO</th>
                    <th class="tengah left" rowspan="2">PLU</th>
                    <th class="tengah left" rowspan="2">NAMA BARANG</th>
                    <th class="tengah left" rowspan="2">KEMASAN</th>
                    <th class="tengah right" colspan="2">KWANTUM</th>
                    <th class="tengah right" rowspan="2">HARGA<br>SATUAN</th>
                    <th class="tengah right" rowspan="2">TOTAL NILAI</th>
                    <th class="tengah right padding-right" rowspan="2">NO. REF <br> BTB</th>
                    <th class="tengah left" rowspan="2">KETERANGAN</th>
                </tr>
                <tr>
                    <th class="right">BESAR</th>
                    <th class="right">KECIL</th>
                </tr>
                </thead>
                <br><br>
                <tbody>
                @php
                    $gross = 0;
                    $potongan = 0;
                    $ppn = 0;
                    $total = 0;
                    $number=1;
                @endphp
                @endif
                <tr>
                    <td class="right padding-right">{{ $number }}</td>
                    <td class="left">{{ $data['data1'][$i]->mstd_prdcd }}</td>
                    <td class="left">{{ $data['data1'][$i]->prd_deskripsipanjang}}</td>
                    <td class="left">{{ $data['data1'][$i]->mstd_unit }}
                        /{{ $data['data1'][$i]->mstd_frac }}</td>
                    <td class="right">{{ $data['data1'][$i]->ctn }}</td>
                    <td class="right">{{ $data['data1'][$i]->pcs }}</td>
                    <td class="right">{{ number_format(round($data['data1'][$i]->mstd_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($data['data1'][$i]->mstd_gross), 0, '.', ',') }}</td>
                    <td class="right padding-right">{{ $data['data1'][$i]->mstd_noref3 }}</td>
                    <td class="left">{{ $data['data1'][$i]->mstd_keterangan }}</td>
                </tr>
                @php
                    $number++;
                    $total += $data['data1'][$i]->total;
                    $gross += $data['data1'][$i]->mstd_gross;
                    $potongan += $data['data1'][$i]->mstd_discrph;
                    $ppn += $data['data1'][$i]->mstd_ppnrph;
                @endphp
                @if($i+1 < sizeof($data['data1']) )
                    @if($nodoc != $data['data1'][$i+1]->msth_nodoc )
                        </tbody>
                    @php
                        $showfooter = true;
                    @endphp
{{--                        </table>--}}
                    @endif
                @else
                    </tbody>
                    @php
                        $showfooter = true;
                    @endphp
{{--                    </table>--}}
                @endif
                @if($showfooter)
                    <tfoot>
                    <tr>
                        <td colspan="6"></td>
                        <td style="font-weight: bold">TOTAL HARGA BELI</td>
                        <td class="right">{{ number_format(round($gross), 0, '.', ',') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td style="font-weight: bold">TOTAL POTONGAN</td>
                        <td class="right">{{ number_format(round($potongan), 0, '.', ',') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td style="font-weight: bold;border-bottom: solid 1px black">TOTAL PPN</td>
                        <td style="border-bottom: solid 1px black" class="right">{{ number_format(round($ppn), 0, '.', ',') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="6"></td>
                        <td style="font-weight: bold">TOTAL SELURUHNYA</td>
                        <td class="right">{{ number_format(round($total), 0, '.', ',') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <table class="table" border="1">
                                <thead>
                                </thead>
                                <tbody>
                                <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
                                    <td class="left" colspan="3">
                                        &nbsp; DIBUAT
                                        <div>
                                            <img style="max-width: 200px; max-height: 100px" src="../storage/signature/clerk.png"
                                                 alt="">
                                        </div>
                                    </td>
                                    <td class="left" colspan="3">
                                        &nbsp; MENYETUJUI :
                                        <div>
                                            <img style="max-width: 200px; max-height: 100px" src="../storage/signature/srclerk.png"
                                                 alt="">
                                        </div>
                                    </td>                                    
                                    @for ($j = 0; $j < sizeof($data['arrSuppSig']); $j++)
                                    @if ($data['data1'][$i]->msth_kodesupplier == $data['arrSuppSig'][$j]['sup_kodesupplier'])
                                        <td colspan="4">
                                            <div>
                                                <img style="max-width: 200px; max-height: 100px"
                                                    src="../storage/signature_expedition/{{ $data['arrSuppSig'][$j]['signatureId'] . '.png' }}" alt="">
                                            </div>
                                        </td>
                                    @endif  
                                    @endfor                                    
                                </tr>
                                <tr>
                                    <td class="left" colspan="3">
                                        &nbsp; ADMINISTRASI
                                        <p>{{ file_get_contents('../storage/names/clerk.txt') }}</p>
                                    </td>
                                    <td class="left" colspan="3">
                                        &nbsp; KEPALA GUDANG
                                        <p>{{ file_get_contents('../storage/names/srclerk.txt') }}</p>
                                    </td>
                                    @for ($j = 0; $j < sizeof($data['arrSuppSig']); $j++)
                                    @if ($data['data1'][$i]->msth_kodesupplier == $data['arrSuppSig'][$j]['sup_kodesupplier'])
                                        <td class="left" colspan="4">
                                            &nbsp; SUPPLIER
                                            <p>{{ strtoupper($data['arrSuppSig'][$j]['signedBy']) }}</p>
                                        </td>
                                    @endif  
                                    @endfor                                    
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tfoot>
                    </table>
            <div class="pagebreak"></div>
            @php
                $showfooter = false;
            @endphp
                @endif
    @endfor

@endsection
