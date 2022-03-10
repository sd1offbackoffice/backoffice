@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    RINCIAN PENGGUNAAN REWARD POIN
@endsection

@section('title')
    RINCIAN PENGGUNAAN REWARD POIN
@endsection

@section('subtitle')
    {{substr($tgl1,0,10)}} s/d {{substr($tgl2,0,10)}}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th colspan="4"></th>
            <th colspan="2" align="center" style="padding-left: 100px">---- Pembayaran ----</th>
            <th></th>
        </tr>
        <tr>
            <th align="right" class="padding-right" width="1%">No.</th>
            <th align="left" width="5%">ID</th>
            <th align="left">Member Merah</th>
            <th align="left">Struk</th>
            <th align="right">Trn.Normal</th>
            <th align="right">Trn.Redeem</th>
            <th align="right">Total Penggunaan</th>
        </tr>
        </thead>
        <tbody>
        @php
            $sub_tkr = 0;
            $sub_rdm= 0;
            $sub_tot_tkr = 0;
            $total_tkr = 0;
            $total_rdm= 0;
            $total_tot_tkr = 0;
            $temptgl = '';
            $number =1;
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<count($data);$i++)
                @if($temptgl != substr($data[$i]->tgl,0,10))
                <tr style="font-weight: bold">
                    <td align="left">Tanggal : {{ substr($data[$i]->tgl,0,10) }}</td>
                    <td colspan="6"></td>
                </tr>
                @endif
                <tr>
                    <td align="right" class="padding-right">{{ $number }}</td>
                    <td align="left">{{ $data[$i]->kodemember }}</td>
                    <td align="left">{{ $data[$i]->namamember }}</td>
                    <td align="left">{{ $data[$i]->trn }}</td>
                    <td align="right">{{ number_format($data[$i]->tkr, 0,".",",")}}</td>
                    <td align="right">{{ number_format($data[$i]->rdm, 0,".",",")}}</td>
                    <td align="right"> {{ number_format($data[$i]->tot_tkr, 0,".",",")}}</td>
                </tr>

                @php
                    $sub_tkr += $data[$i]->tkr;
                    $sub_rdm += $data[$i]->rdm;
                    $sub_tot_tkr += $data[$i]->tot_tkr;
                    $total_tkr += $data[$i]->tkr;
                    $total_rdm += $data[$i]->rdm;
                    $total_tot_tkr += $data[$i]->tot_tkr;
                    $temptgl = substr($data[$i]->tgl,0,10);
                    $number++;
                @endphp
                @if( isset($data[$i+1]->tgl) && $temptgl != substr($data[$i+1]->tgl,0,10) || !(isset($data[$i+1]->tgl)) )
                    <tr style="font-weight: bold">
                        <td colspan="3"></td>
                        <td align="right">Subtotal Per Tgl</td>
                        <td align="right">{{ number_format($sub_tkr, 0,".",",")  }}</td>
                        <td align="right">{{ number_format($sub_rdm, 0,".",",")  }}</td>
                        <td align="right">{{ number_format($sub_tot_tkr, 0,".",",")  }}</td>
                    </tr>
                    @php
                        $sub_tkr  =  0;
                        $sub_rdm  =  0;
                        $sub_tot_tkr =  0;
                    @endphp
                @endif
            @endfor
            <tr style="font-weight: bold;text-align: center">
                <td colspan="3"></td>
                <td align="right">Total</td>
                <td align="right">{{ number_format($total_tkr, 0,".",",")  }}</td>
                <td align="right">{{ number_format($total_rdm, 0,".",",")  }}</td>
                <td align="right">{{ number_format($total_tot_tkr, 0,".",",")  }}</td>
            </tr>
        @else
            <tr>
                <td colspan="6">TIDAK ADA DATA</td>
            </tr>
        @endif

        </tbody>
        <tfoot>

        </tfoot>
    </table>
@endsection
