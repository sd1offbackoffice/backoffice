@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    {{ $title }}
@endsection

@section('title')
    {{ $title }}
@endsection

@section('subtitle')
    TANGGAL : {{$tgl1}} s/d {{$tgl2}}
@endsection
@section('header_right')
    RINCIAN PER DIVISI (UNIT/RUPIAH)
@endsection
    @php
        $tempdiv = '';
        $tempdep = '';
        $tempkat = '';

        $st_begbal_div='';
        $st_akhir_div ='';
        $st_begbal_dep='';
        $st_akhir_dep ='';
        $st_begbal_kat='';
        $st_akhir_kat ='';

        $total_begbal = '';
        $total_akhir = '';
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
            @if($tempdep != $data[$i]->lpp_kodedepartemen)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left"><b>{{$data[$i]->div_namadivisi}}</b></td>
                </tr>
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left"><b>{{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
                <tr>
                    <td class="left"><b>KATEGORI BARANG :</b></td>
                    <td class="left"><b>{{$data[$i]->kat_namakategori}}</b></td>
                </tr>
            @endif
            <tr>
                <td align="left">{{ $data[$i]->prdcd }}</td>
                <td colspan="3" align="left">{{ $data[$i]->prd_deskripsipanjang }}</td>
                <td align="left">{{ $data[$i]->div }}</td>
                <td align="left">{{ $data[$i]->dept }}</td>
                <td align="left">{{ $data[$i]->kat }}</td>
                <td align="right">{{ $data[$i]->begbal_rp }}</td>
                <td align="right">{{ $data[$i]->akhir_rp }}</td>
            </tr>
            @php
                $st_begbal_div     += $data[$i]->begbal_rp;
                $st_akhir_div      += $data[$i]->akhir_rp;

                $st_begbal_dep     += $data[$i]->begbal_rp;
                $st_akhir_dep      += $data[$i]->akhir_rp;

                $st_begbal_kat     += $data[$i]->begbal_rp;
                $st_akhir_kat      += $data[$i]->akhir_rp;

                $tempdiv = $data[$i]->div_kodedivisi;
                $tempdep = $data[$i]->dep_kodedep;
                $tempkat = $data[$i]->kat_kodekat;

            @endphp
            @if( isset($data[$i+1]->kat_kodekat) && $tempkat != $data[$i+1]->kat_kodekat || !(isset($data[$i+1]->kat_kodekat)) )
                <tr>
                    <td class="right">TOTAL KATEGORI</td>
                    <td class="left">{{ $data[$i]->kat_kodekat }}</td>
                    <td class="right">{{ $st_begbal_kat }}</td>
                    <td class="right">{{ $st_akhir_kat }}</td>
                </tr>
                @php
                    $st_begbal_kat     =0;
                    $st_akhir_kat      =0;
                @endphp
            @endif
            @if( isset($data[$i+1]->dept_kodedept) && $tempdept != $data[$i+1]->dept_kodedept || !(isset($data[$i+1]->dept_kodedept)) )
                <tr>
                    <td class="right">TOTAL DEPARTEMENT</td>
                    <td class="left">{{ $data[$i]->dept_kodedept }}</td>
                    <td class="right">{{ $st_begbal_dept }}</td>
                    <td class="right">{{ $st_akhir_dept }}</td>
                </tr>
                @php
                    $st_begbal_dept     =0;
                    $st_akhir_dept      =0;
                @endphp
            @endif
            @if( isset($data[$i+1]->div_kodediv) && $tempdiv != $data[$i+1]->div_kodediv || !(isset($data[$i+1]->div_kodediv)) )
                <tr>
                    <td class="right">TOTAL DIVISI</td>
                    <td class="left">{{ $data[$i]->div_kodediv }}</td>
                    <td class="right">{{ $st_begbal_div }}</td>
                    <td class="right">{{ $st_akhir_div }}</td>
                </tr>
                @php
                    $st_begbal_div     =0;
                    $st_akhir_div      =0;
                @endphp
            @endif

        @endfor
        <tr>
            <td class="right" colspan="5"><strong>TOTAL SEMUA</strong></td>
            <td class="right">{{ $total_begbal }}</td>
            <td class="right">{{ $total_akhir }}</td>
        </tr>

        </tbody>

    </table>

@section('content')

