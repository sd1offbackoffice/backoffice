@extends('pdf-template')
{{-- @extends('html-template') --}}

@section('table_font_size','7 px')

@section('page_title')
    SURAT JALAN 
@endsection

@section('title')
    SURAT JALAN 
@endsection
@section('subtitle')

@endsection

@section('content')
    @php
        $temp_nodoc='';
    @endphp
    @for($i = 0;$i<sizeof($data['data1']);$i++)
        @if($temp_nodoc != $data['data1'][$i]->msth_nodoc)
            @php
                $temp_nodoc = $data['data1'][$i]->msth_nodoc;
            @endphp
            <table class="table">
                <thead>
                <tr>
                    <th class="left" colspan="2" style="vertical-align: bottom">{{ $data['data1'][$i]->prs_namaperusahaan }}</th>
                    {{-- <th class="left" colspan="11" style="font-size: 14px;text-align: center"> SURAT JALAN </th> --}}
                    <th class="left" colspan="11" style="font-size: 14px;text-align: center"></th>
                    <td class="left" colspan="3" style="vertical-align: bottom"> Kepada : </td>
                </tr>
                <tr>
                    <td class="left" colspan="2">{{ $data['data1'][$i]->prs_namacabang }}</td>
                    <td class="left" colspan="11" style="text-align: center"> {{$data['data1'][0]->judul}} </td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->namas }}</td>
                </tr>
                <tr>
                    <td class="left" colspan="13"></td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->sup_alamatsupplier1 }}</td>
                </tr>
                <tr>
                    <td class="left" colspan="13">Referensi NRB :</td>
                    <td class="left" colspan="3">{{ $data['data1'][$i]->sup_alamatsupplier2 }} - {{ $data['data1'][$i]->sup_kotasupplier3 }}</td>
                </tr>
                <tr>
                    <td class="left" colspan="13">No. {{ $data['data1'][$i]->mstd_noref3 }} {{date('d-m-Y', strtotime(substr($data['data1'][$i]->msth_tgldoc, 0, 10)))}} </td>
                    <td class="left" colspan="3">Telepon: {{ $data['data1'][$i]->sup_telpsupplier }}</td>
                </tr>
                <tr>
                    <td class="left" colspan="16">&nbsp;</td>
                </tr>
                <tr>
                    <th style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black" class="tengah left" rowspan="2">NO.</th>
                    <th style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black" class="tengah left" rowspan="2" colspan="11">NAMA BARANG</th>
                    <th style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black" class="tengah left" rowspan="2">SATUAN</th>
                    <th style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black" class="tengah center" colspan="2">KUANTITAS</th>
                    <th style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black" class="tengah left pl-2" rowspan="2">&nbsp;KETERANGAN</th>
                </tr>
                <tr>
                    <th style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black" class="right">BESAR</th>
                    <th style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;border-bottom: 1px solid black" class="right">KECIL</th>
                </tr>
                </thead>
                @php
                    $gross = 0;
                    $potongan = 0;
                    $ppn = 0;
                    $total = 0;
                    $no=1;
                @endphp
                <tbody>

        @endif
                <tr>
                    <td></td>
                    <td class="left" colspan="11">{{ $data['data1'][$i]->prd_deskripsipanjang}}</td>
                    <td colspan="4"></td>
                </tr>
                <tr>
                    <td style="border-bottom: 0.5px solid gray;" class="center" >{{ $no }}.</td>
                    <td style="border-bottom: 0.5px solid gray;" class="left" colspan="11">{{ $data['data1'][$i]->mstd_prdcd}}</td>
                    <td style="border-bottom: 0.5px solid gray;" class="left" >{{ $data['data1'][$i]->mstd_unit }}/{{ $data['data1'][$i]->mstd_frac }}</td>
                    <td style="border-bottom: 0.5px solid gray;" class="right">{{ $data['data1'][$i]->ctn }}</td>
                    <td style="border-bottom: 0.5px solid gray;" class="right">{{ $data['data1'][$i]->pcs }}</td>
                    <td style="border-bottom: 0.5px solid gray;" class="left pl-2">&nbsp;{{ $data['data1'][$i]->mstd_keterangan }}</td>
                </tr>
                <tr>
                    <td colspan="16">&nbsp;</td>
                </tr>
                @php
                    $no++;
                    $total += $data['data1'][$i]->total;
                    $gross += $data['data1'][$i]->mstd_gross;
                    $potongan += $data['data1'][$i]->mstd_discrph;
                    $ppn += $data['data1'][$i]->mstd_ppnrph;
                @endphp

        @if(!isset($data['data1'][$i+1]) || (isset($data['data1'][$i+1]) && $temp_nodoc != $data['data1'][$i+1]->msth_nodoc))
                </tbody>
                <tfoot style="border-top: 1px solid black;">
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
                    <td colspan="6"></td>
                    <td colspan="6">Diserahkan,</td>
                    <td colspan="2">Disetujui,</td>
                    <td colspan="2">Diterima,</td>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td colspan="6">
                        <div>
                            <img style="max-width: 100px; max-height: 50px" src="../storage/signature/clerk.png"
                                alt="">
                        </div>
                        <p>{{ file_get_contents('../storage/names/clerk.txt') }}</p>
                    </td>
                    <td colspan="2">
                        <div>
                            <img style="max-width: 100px; max-height: 50px" src="../storage/signature/srclerk.png"
                                alt="">
                        </div>
                        <p>{{ file_get_contents('../storage/names/srclerk.txt') }}</p>
                    </td>
                    <td colspan="2">                        
                        @for ($j = 0; $j < sizeof($data['arrSuppSig']); $j++)
                            @if ($data['data1'][$i]->msth_kodesupplier == $data['arrSuppSig'][$j]['sup_kodesupplier'])                            
                                <div>
                                    <img style="max-width: 100px; max-height: 50px"
                                        src="../storage/signature_expedition/{{ $data['arrSuppSig'][$j]['signatureId'] . '.png' }}" alt="">
                                </div>
                                <p>{{ strtoupper($data['arrSuppSig'][$j]['signedBy']) }}</p>                           
                            @endif  
                        @endfor                                              
                    </td>
                </tr>               
                <tr>
                    <td colspan="6"></td>
                    <td style="border-top: 1px solid black;" colspan="6">Adm. Gudang</td>
                    <td style="border-top: 1px solid black;" colspan="2">Kepala Gudang</td>
                    <td style="border-top: 1px solid black;" colspan="2">Expedisi / Supplier</td>
                </tr>
                @endif
                
                </tfoot>
            </table>
            @if ($i != sizeof($data['data1'])-1)
                <div class="page-break"></div>
            @endif
        @endif
    @endfor
@endsection
