@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    MONITORING SALES & STOK SUPER FAST MOVING PRODUCT
@endsection

@section('title')
    MONITORING SALES & STOK SUPER FAST MOVING PRODUCT<br>
    AVG SALES 3 BULAN : {{$namabulan}}
@endsection

@section('subtitle')
    <br>Margin : {{ $periode }}<br>
    Kode Monitoring : {{ $kodemonitoring }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah center">NO.</th>
            <th class="tengah center">PLU</th>
            <th class="tengah center">DESKRIPSI</th>
            <th class="tengah center">KEMASAN</th>
            <th class="tengah center">AVG SALES</th>
            <th class="tengah center">AVG SALES QTY</th>
            <th class="tengah center">SALES QTY</th>
            <th class="tengah center">MARGIN</th>
            <th class="tengah center">%</th>
            <th class="tengah center">SALDO AKHIR</th>
            <th class="tengah center">PKMT</th>
            <th class="tengah center">PO OUTS</th>
            <th class="tengah center">PB OUTS</th>
            <th class="tengah center">JADWAL PB</th>
        </tr>
        </thead>
        <tbody>
        @php
            $no=1;
            $div_count=1;
            $dep_count=1;
            $kat_count=1;

            $tempdiv = '';
            $tempdep = '';
            $tempkat = '';

            $st_div_avgsales =0;
            $st_div_avgqty =0;
            $st_div_sales_ =0;
            $st_div_margin =0;
            $st_div_margin2 =0;
            $st_div_saldo =0;
            $st_div_ftpkmt =0;
            $st_div_po =0;
            $st_div_pb =0;

            $st_dep_avgsales =0;
            $st_dep_avgqty =0;
            $st_dep_sales_ =0;
            $st_dep_margin =0;
            $st_dep_margin2 =0;
            $st_dep_saldo =0;
            $st_dep_ftpkmt =0;
            $st_dep_po =0;
            $st_dep_pb =0;

            $st_kat_avgsales =0;
            $st_kat_avgqty =0;
            $st_kat_sales_ =0;
            $st_kat_margin =0;
            $st_kat_margin2 =0;
            $st_kat_saldo =0;
            $st_kat_ftpkmt =0;
            $st_kat_po =0;
            $st_kat_pb =0;

            $total_avgsales=0;
            $total_avgqty=0;
            $total_sales_=0;
            $total_margin=0;
            $total_margin2=0;
            $total_saldo=0;
            $total_ftpkmt=0;
            $total_po=0;
            $total_pb=0;
        @endphp
        @for($i = 0; $i < sizeof($data); $i++)
            @if($tempdiv != $data[$i]->div)
                <tr>
                    <td class="left"><b>DIVISI</b></td>
                    <td class="left" colspan="14"><b>{{$data[$i]->div}} - {{$data[$i]->div_namadivisi}}</b>
                    </td>
                </tr>
            @endif
            @if($tempdep != $data[$i]->dept)
                <tr>
                    <td class="left"><b>DEPARTEMEN</b></td>
                    <td class="left" colspan="14"><b>{{$data[$i]->dept}}
                            - {{$data[$i]->dep_namadepartement}}</b></td>
                </tr>
            @endif
            @if($tempkat != $data[$i]->katb)
                <tr>
                    <td class="left"><b>KATEGORI</b></td>
                    <td class="left" colspan="14"><b>{{$data[$i]->katb}}
                            - {{$data[$i]->kat_namakategori}}</b></td>
                </tr>
            @endif
            <tr>
                <td class="center">{{ $no }}</td>
                <td class="center">{{ $data[$i]->prdcd }}</td>
                <td class="center">{{ $data[$i]->prd_deskripsipendek }}</td>
                <td class="center">{{ $data[$i]->kemasan }}</td>
                <td class="center">{{ number_format($data[$i]->avgsales,0,'.',',') }}</td>
                <td class="center">{{ number_format($data[$i]->avgqty,0,'.',',') }}</td>
                <td class="center">{{ number_format($data[$i]->sales_,0,'.',',') }}</td>
                <td class="center">{{ number_format($data[$i]->margin,0,'.',',') }}</td>
                <td class="center">{{ number_format($data[$i]->margin2,0,'.',',') }}</td>
                <td class="center">{{ number_format($data[$i]->saldo,0,'.',',') }}</td>
                <td class="center">{{ number_format($data[$i]->ftpkmt,0,'.',',') }}</td>
                <td class="center">{{ number_format($data[$i]->po,0,'.',',') }}</td>
                <td class="center">{{ number_format($data[$i]->pb,0,'.',',') }}</td>
                <td class="center">{{ $data[$i]->cp_tglpb }}</td>
            </tr>
            @php
                $total_avgsales += $data[$i]->avgsales;
                $total_avgqty += $data[$i]->avgqty;
                $total_sales_ += $data[$i]->sales_;
                $total_margin += $data[$i]->margin;
                $total_margin2 += $data[$i]->margin2;
                $total_saldo += $data[$i]->saldo;
                $total_ftpkmt += $data[$i]->ftpkmt;
                $total_po += $data[$i]->po;
                $total_pb += $data[$i]->pb;
                $no++;
                $div_count++;
                $dep_count++;
                $kat_count++;

                $tempdiv = $data[$i]->div;
                $tempdep = $data[$i]->dept;
                $tempkat = $data[$i]->katb;
            @endphp
            @if((isset($data[$i+1]->katb) && $tempkat != $data[$i+1]->katb) || !(isset($data[$i+1]->katb)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left" colspan="3">TOTAL PER KATEGORI</td>
                    <td class="center">{{$kat_count-1}} item</td>
                    <td class="center">{{$st_kat_avgsales}}</td>
                    <td class="center">{{$st_kat_avgqty}}</td>
                    <td class="center">{{$st_kat_sales_}}</td>
                    <td class="center">{{$st_kat_margin}}</td>
                    <td class="center">{{$st_kat_margin2}}</td>
                    <td class="center">{{$st_kat_saldo}}</td>
                    <td class="center">{{$st_kat_ftpkmt}}</td>
                    <td class="center">{{$st_kat_po}}</td>
                    <td class="center">{{$st_kat_pb}}</td>
                </tr>
                @php
                    $st_kat_avgsales += $data[$i]->avgsales;
                    $st_kat_avgqty += $data[$i]->avgqty;
                    $st_kat_sales_ += $data[$i]->sales_;
                    $st_kat_margin += $data[$i]->margin;
                    $st_kat_margin2 += $data[$i]->margin2;
                    $st_kat_saldo += $data[$i]->saldo;
                    $st_kat_ftpkmt += $data[$i]->ftpkmt;
                    $st_kat_po += $data[$i]->po;
                    $st_kat_pb += $data[$i]->pb;
                @endphp
            @endif
            @if( isset($data[$i+1]->dept) && $tempdep != $data[$i+1]->dept || !(isset($data[$i+1]->dept)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left" colspan="3">TOTAL PER DEPARTEMENT</td>
                    <td class="center">{{$dep_count-1}} item</td>
                    <td class="center">{{$st_dep_avgsales}}</td>
                    <td class="center">{{$st_dep_avgqty}}</td>
                    <td class="center">{{$st_dep_sales_}}</td>
                    <td class="center">{{$st_dep_margin}}</td>
                    <td class="center">{{$st_dep_margin2}}</td>
                    <td class="center">{{$st_dep_saldo}}</td>
                    <td class="center">{{$st_dep_ftpkmt}}</td>
                    <td class="center">{{$st_dep_po}}</td>
                    <td class="center">{{$st_dep_pb}}</td>
                </tr>
                @php
                    $st_dep_avgsales += $data[$i]->avgsales;
                   $st_dep_avgqty += $data[$i]->avgqty;
                   $st_dep_sales_ += $data[$i]->sales_;
                   $st_dep_margin += $data[$i]->margin;
                   $st_dep_margin2 += $data[$i]->margin2;
                   $st_dep_saldo += $data[$i]->saldo;
                   $st_dep_ftpkmt += $data[$i]->ftpkmt;
                   $st_dep_po += $data[$i]->po;
                   $st_dep_pb += $data[$i]->pb;
                @endphp
            @endif
            @if((isset($data[$i+1]->div) && $tempdiv != $data[$i+1]->div) || !(isset($data[$i+1]->div)) )
                <tr style="border-bottom: 1px solid black;">
                    <td class="left" colspan="3">TOTAL PER DIVISI</td>
                    <td class="center">{{$div_count-1}} item</td>
                    <td class="center">{{$st_div_avgsales}}</td>
                    <td class="center">{{$st_div_avgqty}}</td>
                    <td class="center">{{$st_div_sales_}}</td>
                    <td class="center">{{$st_div_margin}}</td>
                    <td class="center">{{$st_div_margin2}}</td>
                    <td class="center">{{$st_div_saldo}}</td>
                    <td class="center">{{$st_div_ftpkmt}}</td>
                    <td class="center">{{$st_div_po}}</td>
                    <td class="center">{{$st_div_pb}}</td>
                </tr>
                @php
                   $st_div_avgsales += $data[$i]->avgsales;
                   $st_div_avgqty += $data[$i]->avgqty;
                   $st_div_sales_ += $data[$i]->sales_;
                   $st_div_margin += $data[$i]->margin;
                   $st_div_margin2 += $data[$i]->margin2;
                   $st_div_saldo += $data[$i]->saldo;
                   $st_div_ftpkmt += $data[$i]->ftpkmt;
                   $st_div_po += $data[$i]->po;
                   $st_div_pb += $data[$i]->pb;
                @endphp
            @endif
        @endfor
        </tbody>
        <tfoot>
        <tr>
            <th class="center" colspan="3"><b>TOTAL SELURUH</b></th>
            <th class="center">{{$no-1}} item</th>
            <th class="center">{{ number_format($total_avgsales,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_avgqty,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_sales_,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_margin,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_margin2,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_saldo,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_ftpkmt,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_po,0,'.',',') }}</th>
            <th class="center">{{ number_format($total_pb,0,'.',',') }}</th>
        </tr>
        </tfoot>
    </table>
@endsection
