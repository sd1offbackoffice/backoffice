@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    SURAT JALAN <br>{{ strtoupper($data['data1'][0]->judul) }}
@endsection

@section('title')
    SURAT JALAN <br>{{ strtoupper($data['data1'][0]->judul) }}
@endsection


@section('header_left')
    <table>
        <tr>
            <td class="left">NPWP</td>
            <td class="left">: {{ $perusahaan->prs_npwp }}</td>
        </tr>
        <tr>
            <td class="left"><b> {{ $data['data1'][0]->status }} </b></td>
        </tr>
        <tr>
            <td class="left">NOMOR</td>
            <td class="left">: {{ $data['data1'][0]->msth_nodoc }}</td>
            <td class="left">TGL NPB</td>
            <td class="left">: {{ substr($data['data1'][0]->msth_tgldoc,0,10) }}</td>
        </tr>
        @php
            $i=0;
        @endphp
        @foreach($data['data2'] as $d)
            @if($i == 0)
                <tr>
                    <td class="left">FAKTUR PAJAK</td>
                    <td class="left">: {{$d->nofp }}</td>
                    <td class="left">TGL FP</td>
                    <td class="left">: {{ substr($d->mstd_date3,0,10) }}</td>
                </tr>
            @else
                <tr>
                    <td class="left"></td>
                    <td class="left">: {{$d->nofp }}</td>
                    <td class="left"></td>
                    <td class="left">: {{ substr($d->mstd_date3,0,10) }}</td>
                </tr>
            @endif
            @php
                $i++;
            @endphp
        @endforeach

    </table>
@endsection
@section('header_right')
    <table>
        <tr>
            <td class="left">SUPPLIER</td>
            <td class="left">: {{ $data['data1'][0]->msth_kodesupplier }}</td>
        </tr>
        <tr>
            <td class="left">NPWP</td>
            <td class="left">: {{ $data['data1'][0]->sup_npwp }}</td>
        </tr>
        <tr>
            <td class="left">ALAMAT</td>
            <td class="left">: {{ $data['data1'][0]->sup_alamatsupplier1 }}</td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="left">: {{ $data['data1'][0]->sup_alamatsupplier2 }}</td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="left">: {{ $data['data1'][0]->sup_kotasupplier3 }}</td>
        </tr>
        <tr>
            <td class="left">TELP</td>
            <td class="left">: {{ $data['data1'][0]->sup_telpsupplier }}</td>
        </tr>
        <tr>
            <td class="left">CP</td>
            <td class="left">: {{ $data['data1'][0]->sup_contactperson }}</td>
        </tr>
    </table>
    @if($i < 5)
        @php
            $i =5;
        @endphp
    @endif
@endsection


@section('content')
    @for($j=0; $j<$i; $j++ )
        <br>
    @endfor
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th class="tengah right padding-right" rowspan="2">NO</th>            
                <th class="tengah left" rowspan="2">NAMA BARANG</th>
                <th class="tengah left" rowspan="2">SATUAN</th>
                <th class="tengah right" colspan="2">KUANTITAS</th>            
                <th class="tengah left" rowspan="2">KETERANGAN</th>
            </tr>
            <tr>
                <th class="right">BESAR</th>
                <th class="right">KECIL</th>
            </tr>
            </thead>
            <tbody>
            @php
                $gross = 0;
                $potongan = 0;
                $ppn = 0;
                $total = 0;
                $i=1;
            @endphp

            @if(isset($data['data1']))
                @foreach($data['data1'] as $d)
                    <tr>
                        <td class="right padding-right" >{{ $i }}</td>                    
                        <td class="left" >{{ $d->prd_deskripsipanjang}}</td>
                        <td class="left" >{{ $d->mstd_unit }}/{{ $d->mstd_frac }}</td>
                        <td class="right">{{ $d->ctn }}</td>
                        <td class="right">{{ $d->pcs }}</td>                    
                        <td class="left">{{ $d->mstd_keterangan }}</td>
                    </tr>
                    @php
                        $i++;
                        $total += $d->total;
                        $gross += $d->mstd_gross;
                        $potongan += $d->mstd_discrph;
                        $ppn += $d->mstd_ppnrph;
                    @endphp
                @endforeach
            @else
                <tr>
                    <td colspan="10">TIDAK ADA DATA</td>
                </tr>
            @endif
        </tbody>

        <tfoot>            
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
                                    <img style="max-width: 200px; max-height: 100px" src="../storage/signature/clerk.png" alt="">                                
                                </div>                        
                            </td>
                            <td class="left" colspan="3">
                                &nbsp; MENYETUJUI :
                                <div>
                                    <img style="max-width: 200px; max-height: 100px" src="../storage/signature/srclerk.png" alt="">                                
                                </div>
                            </td>
                            <td colspan="4">
                                <div>
                                    <img style="max-width: 150px; max-height: 100px" src="../storage/signature_expedition/{{ $data['signatureId'] . '.png' }}" alt="">                                
                                </div>
                            </td>
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
                            <td class="left" colspan="4">
                                &nbsp; SUPPLIER
                                <p>{{ $data['signedBy'] }}</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
@endsection
