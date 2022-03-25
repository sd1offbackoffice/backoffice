@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    {{ $title }}
@endsection

@section('title')
    {{ $title }}
@endsection

@section('subtitle')
    TANGGAL : {{date('d/M/Y',strtotime(str_replace('/','-',$tgl1)))}} s/d {{date('d/M/Y',strtotime(str_replace('/','-',$tgl2)))}}
@endsection
@section('header_right')
    RINCIAN PER DIVISI (UNIT/RUPIAH)
@endsection
    @php
        $tempdiv = '';
        $tempdep = '';
        $tempkat = '';

        $st_begbal_div=0;
        $st_akhir_div =0;
        $st_begbal_dep=0;
        $st_akhir_dep =0;
        $st_begbal_kat=0;
        $st_akhir_kat =0;

        $total_begbal =0;
        $total_akhir = 0;
    @endphp
@section('content')

    <table class="table table-bordered table-responsive">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr style="text-align: center;">
            <th>PLU</th>
            <th colspan="3">DESKRIPSI</th>
            <th>DIV</th>
            <th>DEPT</th>
            <th>KATB</th>
            <th class="right">SALDO AWAL</th>
            <th class="right">SALDO AKHIR</th>
        </tr>
        </thead>
        <tbody>
        @for($i=0;$i<count($data);$i++)
            @if($tempdiv != $data[$i]->div)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left"><b>{{$data[$i]->div_namadivisi}}</b></td>
                </tr>

            @endif
            @if($tempdep != $data[$i]->div.$data[$i]->dept)

                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left"><b>{{$data[$i]->dep_namadepartement}}</b></td>
                </tr>

            @endif
            @if($tempkat != $data[$i]->div.$data[$i]->dept.$data[$i]->katb)
                <tr>
                    <td class="left"><b>KATEGORI BARANG :</b></td>
                    <td class="left"><b>{{$data[$i]->kat_namakategori}}</b></td>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $data[$i]->prdcd }}</td>
                <td colspan="3" align="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td align="center">{{ $data[$i]->div }}</td>
                <td align="center">{{ $data[$i]->dept }}</td>
                <td align="center">{{ $data[$i]->katb }}</td>
                <td align="right">{{ number_format($data[$i]->begbal_rp,0) }}</td>
                <td align="right">{{ number_format($data[$i]->akhir_rp,0) }}</td>
            </tr>
            @php
                $st_begbal_div     += $data[$i]->begbal_rp;
                $st_akhir_div      += (int)$data[$i]->akhir_rp;

                $st_begbal_dep     += (int)$data[$i]->begbal_rp;
                $st_akhir_dep      += (int)$data[$i]->akhir_rp;

                $st_begbal_kat     += (int)$data[$i]->begbal_rp;
                $st_akhir_kat      += (int)$data[$i]->akhir_rp;

                $tempdiv = $data[$i]->div;
                $tempdep = $data[$i]->div.$data[$i]->dept;
                $tempkat = $data[$i]->div.$data[$i]->dept.$data[$i]->katb;

                $total_begbal += (int)$data[$i]->begbal_rp;
                $total_akhir += (int)$data[$i]->akhir_rp;
            @endphp
            @if( (isset($data[$i+1]->katb) && $tempkat != $data[$i+1]->div.$data[$i+1]->dept.$data[$i+1]->katb) || !(isset($data[$i+1]->katb)) )
                <tr style="border-top: 1px solid black">
                    <td class="left" >TOTAL KATEGORI</td>
                    <td class="left" colspan="6">{{ $data[$i]->katb }}</td>
                    <td class="right">{{ number_format($st_begbal_kat,0) }}</td>
                    <td class="right">{{ number_format($st_akhir_kat,0) }}</td>
                </tr>
                @php
                    $st_begbal_kat     =0;
                    $st_akhir_kat      =0;
                @endphp
            @endif
            @if( (isset($data[$i+1]->dept) && $tempdep != $data[$i+1]->div.$data[$i+1]->dept) || !(isset($data[$i+1]->dept)) )
                <tr style="border-top: 1px solid black">
                    <td class="left" >TOTAL DEPARTEMENT</td>
                    <td class="left" colspan="6">{{ $data[$i]->dept }}</td>
                    <td class="right">{{ number_format($st_begbal_dep,0) }}</td>
                    <td class="right">{{ number_format($st_akhir_dep,0) }}</td>
                </tr>
                @php
                    $st_begbal_dep     =0;
                    $st_akhir_dep      =0;
                @endphp
            @endif
            @if( (isset($data[$i+1]->div) && $tempdiv != $data[$i+1]->div) || !(isset($data[$i+1]->div)) )
                <tr style="border-top: 1px solid black">
                    <td class="left" >TOTAL DIVISI</td>
                    <td class="left" colspan="6">{{ $data[$i]->div }}</td>
                    <td class="right">{{ number_format($st_begbal_div,0) }}</td>
                    <td class="right">{{ number_format($st_akhir_div,0) }}</td>
                </tr>
                @php
                    $st_begbal_div     =0;
                    $st_akhir_div      =0;
                @endphp
            @endif

        @endfor
        <tr style="border-top: 1px solid black">
            <td class="left" colspan="7" ><strong>TOTAL SEMUA</strong></td>
            <td class="right">{{ number_format($total_begbal,0) }}</td>
            <td class="right">{{ number_format($total_akhir,0) }}</td>
        </tr>

        </tbody>

    </table>

@endsection

