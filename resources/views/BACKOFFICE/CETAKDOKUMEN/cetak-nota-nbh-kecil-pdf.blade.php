@extends('BACKOFFICE.CETAKDOKUMEN.cetak-dokumen-template')
{{-- @extends('pdf-template') --}}

@section('table_font_size','7 px')

@section('paper_height','642pt')

@section('page_title')
    {{ strtoupper($data['data1'][0]->judul) }}
@endsection

@section('title')
    {{ strtoupper($data['data1'][0]->judul) }}
@endsection
@section('header_left')
    NPWP : {{ $perusahaan->prs_npwp }}
@endsection
@section('content')
    @php
        $temp_doc ='';
    @endphp
    @for($i=0;$i< sizeof($data['data1']); $i++)


        @if($temp_doc!=$data['data1'][$i]->msth_nodoc)
            @php
                $temp_doc = $data['data1'][$i]->msth_nodoc;
                $total = 0;
            @endphp
            <table class="table">
                <thead>
                <tr>
                    <td class="left">NOMOR</td>
                    <td class="left">: {{$data['data1'][$i]->msth_nodoc}}</td>
                    <td class="left">TANGGAL : {{ date('d/m/Y',strtotime(substr($data['data1'][$i]->msth_tgldoc,0,10))) }}</td>
                </tr>
                <tr>
                    <td class="left">NO. REF</td>
                    <td class="left">: {{$data['data1'][$i]->msth_nopo}}</td>
                    <td class="left">TGL. REF : {{ isset($data['data1'][$i]->msth_tglpo)?date('d/m/Y',strtotime(substr($data['data1'][$i]->msth_tglpo,0,10))):'-' }}</td>
                </tr>
                <tr>
                    <td class="left">KETERANGAN</td>
                    <td class="left">: {{$data['data1'][$i]->ket}}</td>
                    <td colspan="7"></td>
                    <td class="right">{{$data['data1'][$i]->status}}</td>
                </tr>
                <tr>
                    <td class="left"></td>
                </tr>
                <tr>
                    <th class="tengah right padding-right" style="border-top: 1px solid black;border-bottom: 1px solid black;"
                        rowspan="2">
                        NO
                    </th>
                    <th class="tengah left" style="border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2">
                        PLU
                    </th>
                    <th class="tengah left" style="border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2">NAMA BARANG</th>
                    <th style="border-top: 1px solid black;" colspan="2">KEMASAN</th>
                    <th style="border-top: 1px solid black;" colspan="2">KWANTUM</th>
                    <th class="tengah right" style="border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2">HARGA<br>SATUAN
                    </th>
                    <th class="tengah right padding-right" style="border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2">TOTAL</th>
                    <th class="tengah left" style="border-top: 1px solid black;border-bottom: 1px solid black;" rowspan="2">KETERANGAN</th>
                </tr>
                <tr>
                    <th class="left" style="border-bottom: 1px solid black;">UNIT</th>
                    <th class="right" style="border-bottom: 1px solid black;">FRAC</th>
                    <th class="tengah right" style="border-bottom: 1px solid black;">CTN</th>
                    <th class="tengah right" style="border-bottom: 1px solid black;">PCs</th>
                </tr>
                </thead>
                <tbody>
                @endif
                <tr>
                    <td class="right padding-right">{{ $i+1 }}</td>
                    <td class="left">{{ $data['data1'][$i]->mstd_prdcd }}</td>
                    <td class="left">{{ $data['data1'][$i]->prd_deskripsipanjang}}</td>
                    <td class="left">{{ $data['data1'][$i]->mstd_unit }}</td>
                    <td class="right">{{ $data['data1'][$i]->mstd_frac }}</td>
                    <td class="right">{{ $data['data1'][$i]->ctn }}</td>
                    <td class="right">{{ $data['data1'][$i]->pcs }}</td>
                    <td class="right">{{ number_format(round($data['data1'][$i]->mstd_hrgsatuan), 0, '.', ',') }}</td>
                    <td class="right padding-right">{{ number_format(round($data['data1'][$i]->total), 0, '.', ',') }}</td>
                    <td class="left">{{ $data['data1'][$i]->mstd_keterangan }}</td>
                </tr>
                @php
                    $total += $data['data1'][$i]->total;
                @endphp
                @if( !isset($data['data1'][$i+1]) || (isset($data['data1'][$i+1]->msth_nodoc) && $temp_doc!=$data['data1'][$i+1]->msth_nodoc) )
                </tbody>
                <tfoot>
                <tr>
                    <th class="right" colspan="8" style="font-weight: bold">TOTAL SELURUHNYA</th>
                    <th class="right padding-right">{{ number_format(round($total), 0, '.', ',') }}</th>
                    <th></th>
                </tr>
                {{-- <tr>
                    <td colspan="10">
                        <table class="table" border="1">
                            <tbody>
                            <tr style="border-top: 1px solid black;border-bottom: 1px solid black;">
                                <td class="left" colspan="3">&nbsp; DIBUAT <br><br><br></td>
                                <td class="left" colspan="3">&nbsp; DIPERIKSA :</td>
                                <td class="left" colspan="4">&nbsp; MENYETUJUI :</td>
                                <td class="left" colspan="4">&nbsp; PELAKSANA :</td>
                            </tr>
                            <tr>
                                <td class="left" colspan="3">&nbsp; ADMINISTRASI</td>
                                <td class="left" colspan="3">&nbsp; KEPALA GUDANG</td>
                                <td class="left" colspan="4">&nbsp; STORE MANAGER</td>
                                <td class="left" colspan="4">&nbsp; STOCK CLERK / PETUGAS GUDANG</td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr> --}}
                </tfoot>
            </table>
            <br><br>

        @endif
    @endfor
@endsection
