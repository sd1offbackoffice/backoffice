@extends('pdf-template')
{{-- @extends('html-template') --}}

@section('table_font_size','7 px')

@section('page_title')
    SURAT JALAN <br>{{ strtoupper($data['data1'][0]->judul) }}
@endsection

@section('title')
    SURAT JALAN <br>{{ strtoupper($data['data1'][0]->judul) }}
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
                    {{-- <td class="left" colspan="4"></td>
                    <td class="left" width="10%"></td>
                    <td class="left">SUPPLIER :</td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->msth_kodesupplier }}
                        - {{ $data['data1'][$i]->namas }}
                    </td> --}}
                    <td class="left" colspan="4"><strong>{{ $data['data1'][$i]->prs_namaperusahaan }}</strong></td>
                    <td class="left" width="10%"></td>
                    <td class="left">KEPADA :</td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->msth_kodesupplier }}
                        - {{ $data['data1'][$i]->namas }}
                    </td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    {{-- <td class="left" colspan="4"></td>
                    <td class="left"></td>
                    <td class="left">NPWP :</td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->sup_npwp }}</td> --}}
                    <td class="left" colspan="4">{{ $data['data1'][$i]->prs_namacabang }}</td>
                    <td class="left"></td>
                    <td class="left"></td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->namas }}</td>
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
                    <td class="left">REFERENSI NRB :</td>
                    <td class="left" colspan="4">No. {{ $data['data1'][$i]->mstd_noref3 }} {{date('d-m-Y', strtotime(substr($data['data1'][$i]->msth_tgldoc, 0, 10)))}}</td>
                    {{-- <td class="left">TGL NPB :</td>
                    <td class="left">{{strtoupper(date('d-M-y', strtotime($data['data1'][$i]->msth_tgldoc)))}}</td> --}}
                    {{-- <td class="left"></td>
                    <td class="left"></td> --}}
                    <td class="left">TELP :</td>
                    <td class="left">{{ $data['data1'][$i]->sup_telpsupplier }}</td>
                    <td class="right">CP :</td>
                    <td class="left">{{ $data['data1'][$i]->sup_contactperson }}</td>
                </tr>
                @php
                    $no=0;
                @endphp
                {{-- @while($j<sizeof($data['data2']) )
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

                @endwhile --}}
                </tbody>
            </table>
            <table class="table">
                <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
                <tr>
                    <th class="tengah center padding-right" rowspan="2">NO</th>
                    <th class="tengah center" rowspan="2">PLU</th>
                    <th class="tengah center" rowspan="2">NAMA BARANG</th>
                    <th class="tengah center" rowspan="2">SATUAN</th>
                    <th class="tengah center" colspan="2">KUANTITAS</th>
                    {{-- <th class="tengah right" rowspan="2">HARGA<br>SATUAN</th>
                    <th class="tengah right" rowspan="2">TOTAL NILAI</th> --}}
                    {{-- <th class="tengah right padding-right" rowspan="2">NO. REF <br> BTB</th> --}}
                    <th class="tengah center" rowspan="2">KETERANGAN</th>
                </tr>
                <tr>
                    <th class="center">BESAR</th>
                    <th class="center">KECIL</th>
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
                    <td class="center padding-right">{{ $number }}</td>
                    <td class="center">{{ $data['data1'][$i]->mstd_prdcd }}</td>
                    <td class="center">{{ $data['data1'][$i]->prd_deskripsipanjang}}</td>
                    <td class="center">{{ $data['data1'][$i]->mstd_unit }}
                        /{{ $data['data1'][$i]->mstd_frac }}</td>
                    <td class="center">{{ $data['data1'][$i]->ctn }}</td>
                    <td class="center">{{ $data['data1'][$i]->pcs }}</td>
                    {{-- <td class="right">{{ number_format(round($data['data1'][$i]->mstd_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right">{{ number_format(round($data['data1'][$i]->mstd_gross), 0, '.', ',') }}</td>
                    <td class="right padding-right">{{ $data['data1'][$i]->mstd_noref3 }}</td> --}}
                    <td class="center">{{ $data['data1'][$i]->mstd_keterangan }}</td>
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
                        <th style="text-align: left" colspan="16">Dikirim oleh:</th>
                    </tr>
                    <tr>
                        <td colspan="16">{{$data['data1'][$i]->prs_namacabang}}</td>
                    </tr>
                    <tr>
                        <td colspan="16">{{$data['data1'][$i]->prs_alamat1}} {{$data['data1'][$i]->prs_alamat3}}</td>
                    </tr>
                    <tr>
                        <td colspan="16">Telepon : {{$data['data1'][$i]->prs_telepon}}</td>
                    </tr>

                    @if ($data['reprint'] == '0')
                        <tr>
                            <td colspan="10">
                                <table class="table" border="1">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
                                        <td class="left" colspan="3">
                                            &nbsp; DISERAHKAN : 
                                            <div>
                                                <img style="max-width: 200px; max-height: 100px" src="../storage/signature/clerk.png"
                                                    alt="">
                                            </div>
                                        </td>
                                        <td class="left" colspan="3">
                                            &nbsp; DISETUJUI :
                                            <div>
                                                <img style="max-width: 200px; max-height: 100px" src="../storage/signature/srclerk.png"
                                                    alt="">
                                            </div>
                                        </td>                                    
                                        @for ($j = 0; $j < sizeof($data['arrSuppSig']); $j++)
                                        @if ($data['data1'][$i]->msth_kodesupplier == $data['arrSuppSig'][$j]['sup_kodesupplier'])
                                            <td colspan="4">
                                                &nbsp; DITERIMA :  
                                                <div>
                                                    <img style="max-width: 200px; max-height: 100px"
                                                        src="../storage/signature_expedition/{{ $data['arrSuppSig'][$j]['signatureId'] . '.png' }}" alt="">
                                                </div>
                                            </td>
                                        @endif  
                                        @endfor                                    
                                    </tr>
                                    <tr>
                                        <td class="center" colspan="3">
                                            &nbsp; ADMINISTRASI
                                            <p>{{ file_get_contents('../storage/names/clerk.txt') }}</p>
                                        </td>
                                        <td class="center" colspan="3">
                                            &nbsp; KEPALA GUDANG
                                            <p>{{ file_get_contents('../storage/names/srclerk.txt') }}</p>
                                        </td>
                                        @for ($j = 0; $j < sizeof($data['arrSuppSig']); $j++)
                                        @if ($data['data1'][$i]->msth_kodesupplier == $data['arrSuppSig'][$j]['sup_kodesupplier'])
                                            <td class="center" colspan="4">
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
                    @endif
                    
                    </tfoot>
                    </table>
                @if ($i != sizeof($data['data1'])-1)
                    <div class="page-break"></div>
                @endif
            @php
                $showfooter = false;
            @endphp
                @endif
    @endfor

@endsection
