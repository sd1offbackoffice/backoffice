@extends('html-template')

@section('table_font_size','7 px')

@section('paper_height','595pt')
@section('paper_width','842pt')

@section('page_title')
    LAPORAN TRANSAKSI BARANG COUNTER BON
@endsection

@section('title')
    LAPORAN TRANSAKSI BARANG COUNTER BON
@endsection

@section('subtitle')
    Tanggal {{ $tgl1 }} s/d {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right">Id</th>
            <th class="left">Nama Kasir</th>
            <th class="right padding-right">Tanggal</th>
            <th class="left">Tipe</th>
            <th class="left">PLU</th>
            <th class="left">Divisi</th>
            <th class="left">Nama Counter / Barang</th>
            <th class="right">Trans</th>
            <th class="right">Qty</th>
            <th class="right">Hrg Jual</th>
            <th class="right">Discount</th>
            <th class="right">Jumlah</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempId='';
            $tempTanggal='';
            $tempKet='';
            $subTotalNotaSales=0;
            $subTotalNotaRefund=0;
            $subTotalKasirSales=0;
            $subTotalKasirRefund=0;
            $subTotalPerTanggalSales=0;
            $subTotalPerTanggalRefund=0;
            $totalNotaSales=0;
            $totalNotaRefund=0;
            $totalKasirSales=0;
            $totalKasirRefund=0;
            $totalPerTanggalSales=0;
            $totalPerTanggalRefund=0;
        @endphp

        @for($i=0;$i<sizeof($data);$i++)
            @php
                $ket = '';
                if ($data[$i]->tipe1 == 'S') {
                    $ket = 'SALES';

                    $subTotalNotaSales += ($data[$i]->qty*$data[$i]->hrgjual);
                    $totalNotaSales += ($data[$i]->qty*$data[$i]->hrgjual);

                    $subTotalKasirSales += ($data[$i]->qty*$data[$i]->hrgjual);
                    $totalKasirSales += ($data[$i]->qty*$data[$i]->hrgjual);

                    $subTotalPerTanggalSales += ($data[$i]->qty*$data[$i]->hrgjual);
                    $totalPerTanggalSales += ($data[$i]->qty*$data[$i]->hrgjual);
                }
                else{
                    $ket = 'REFUND';
                    $subTotalNotaRefund += ($data[$i]->qty*$data[$i]->hrgjual);
                    $totalNotaRefund += ($data[$i]->qty*$data[$i]->hrgjual);

                    $subTotalKasirRefund += ($data[$i]->qty*$data[$i]->hrgjual);
                    $totalKasirRefund += ($data[$i]->qty*$data[$i]->hrgjual);

                    $subTotalPerTanggalRefund += ($data[$i]->qty*$data[$i]->hrgjual);
                    $totalPerTanggalRefund += ($data[$i]->qty*$data[$i]->hrgjual);
                }

            @endphp

            <tr>
                @if($tempId != $data[$i]->kasir)
                    @php
                        $tempId = $data[$i]->kasir;
                    @endphp
                    <td class="right padding-right">{{$data[$i]->kasir}}</td>
                    <td class="left">{{$data[$i]->username}}</td>
                @else
                    <td colspan="2"></td>
                @endif
                @if($tempTanggal != $data[$i]->tglt)
                    @php
                        $tempTanggal = $data[$i]->tglt;
                    @endphp
                    <td class="right padding-right">{{date('d-m-y',strtotime(str_replace('/','-',$data[$i]->tglt)))}}</td>
                @else
                    <td colspan="1"></td>
                @endif
                @if($tempKet != $data[$i]->kasir.$ket.$data[$i]->prdcd)
                    @php
                        $tempKet = $data[$i]->kasir.$ket.$data[$i]->prdcd;
                    @endphp
                    <td class="left">{{$ket}}</td>
                    <td class="left">{{$data[$i]->prdcd}}</td>
                    <td class="left">{{$data[$i]->div}}</td>
                    <td class="left">{{$data[$i]->prd_deskripsipendek}}</td>
                @else
                    <td colspan="4"></td>
                @endif
                <td class="right">{{$data[$i]->notrn}}</td>
                <td class="right">{{number_format($data[$i]->qty, 0, '.', ',') }}</td>
                <td class="right">{{number_format($data[$i]->hrgjual, 0, '.', ',')}}</td>
                <td class="right">{{$data[$i]->disc}}</td>
                <td class="right">{{number_format($data[$i]->nilai, 0, '.', ',')}}</td>
            </tr>

            @if(!isset($data[$i+1]) || ($tempKet != $data[$i+1]->kasir.$ket.$data[$i+1]->prdcd && isset($data[$i+1])) )
                <tr>
                    <th colspan="11" class="right">Total Nota :</th>
                    <th class="right"> {{number_format($subTotalNotaSales-$subTotalNotaRefund, 0, '.', ',')}} </th>
                </tr>
                @php
                    $subTotalNotaSales = 0;
                    $subTotalNotaRefund = 0;
                @endphp
            @endif

            @if(!isset($data[$i+1]) || ($tempId != $data[$i+1]->kasir && isset($data[$i+1])) )
                <tr>
                    <th colspan="11" class="right">Total Kasir :</th>
                    <th class="right"> {{number_format($subTotalKasirSales-$subTotalKasirRefund, 0, '.', ',')}} </th>
                </tr>
                @php
                    $subTotalKasirSales = 0;
                    $subTotalKasirRefund = 0;
                @endphp
            @endif


            @if(!isset($data[$i+1]) || ($tempTanggal != $data[$i+1]->tglt && isset($data[$i+1])) )
                <tr>
                    <th colspan="11" class="right">Total / Tanggal :</th>
                    <th class="right"> {{number_format($subTotalPerTanggalSales-$subTotalPerTanggalRefund, 0, '.', ',')}} </th>
                </tr>
                @php
                    $subTotalPerTanggalSales = 0;
                    $subTotalPerTanggalRefund = 0;
                @endphp
            @endif
        @endfor
                <tr style="border-top: 1px solid black">
                    <th colspan="10" class="left">Total Sales Counter Umum</th>
                    <th class="right">{{ number_format($totalKasirSales) }}</th>
                    <th class="right">{{ number_format($totalPerTanggalSales) }}</th>
                </tr>
                <tr >
                    <th colspan="10" class="left">Total Refund Counter Umum</th>
                    <th class="right">{{ number_format($totalKasirRefund) }}</th>
                    <th class="right">{{ number_format($totalPerTanggalRefund) }}</th>
                </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
