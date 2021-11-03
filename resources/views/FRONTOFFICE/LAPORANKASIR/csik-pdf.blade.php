@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-CASH BACK / SUPPLIER / ITEM
@endsection

@section('title')
    {{$judul}}
@endsection

@section('subtitle')
    Tanggal: {{$date1}} s/d {{$date2}}
@endsection
@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
@endphp
@section('content')


<table class="table table-bordered table-responsive" style="border-collapse: collapse">
    <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
    <tr style="text-align: left; vertical-align: middle">
        <th style="width: 40px;">No.</th>
        <th style="width: 80px;">Plu</th>
        <th style="width: 378px;">Deskripsi</th>
        <th style="width: 100px;">Tanggal</th>
        <th style="width: 50px; text-align: right">Qty</th>
        <th style="width: 80px; text-align: right">Nilai</th>
    </tr>
    </thead>
    <tbody style="border-bottom: 2px solid black; text-align: left; vertical-align: middle">
    <?php
    $supplier = '';
    $qtysup = 0;
    $nilaisup = 0;
    $plu = '';
    $qtyplu = 0;
    $nilaiplu = 0;
    $totalqty = 0;
    $totalnilai = 0;
    $numbering = 0;
    $qty = 0;
    ?>
    @for($i=0;$i<sizeof($data);$i++)
        @if(($data[$i]->qty)<0)
            <?php
            $qty = ($data[$i]->qty)*(-1);
            ?>
        @else
            <?php
            $qty = $data[$i]->qty;
            ?>
        @endif
        @if($supplier != $data[$i]->sup_kodesupplier)
            @if($qtysup != 0)
                @if($qtysup<0)
                    <?php
                    $qtysup = $qtysup *(-1);
                    ?>
                @endif
                <tr style="font-weight: bold">
                    <td> </td>
                    <td> Total Per Supplier : </td>
                    <td> </td>
                    <td> </td>
                    <td style="text-align: right">{{$qtysup}}</td>
                    <td style="text-align: right">{{rupiah($nilaisup)}}</td>
                </tr>
            @endif
            <tr>
                <td>Supplier</td>
                <td>{{$data[$i]->sup_kodesupplier}}</td>
                <td>{{$data[$i]->sup_namasupplier}}</td>
                <td> </td>
                <td> </td>
                <td> </td>
            </tr>
            <?php
            $supplier = $data[$i]->sup_kodesupplier;
            $totalqty = $totalqty + $qtysup;
            $totalnilai = $totalnilai + $nilaisup;
            $qtysup = 0;
            $nilaisup = 0;
            ?>
        @endif
        <?php
        $date = new DateTime($data[$i]->tanggal);
        $strip = $date->format('d-m-Y');
        ?>
        @if($plu != $data[$i]->plu)
            @if($qtyplu != 0)
                @if($qtyplu<0)
                    <?php
                    $qtyplu = $qtyplu *(-1);
                    ?>
                @endif
                <tr style="font-weight: bold">
                    <td> </td>
                    <td> Total Per Plu : </td>
                    <td> </td>
                    <td> </td>
                    <td style="text-align: right">{{$qtyplu}}</td>
                    <td style="text-align: right">{{rupiah($nilaiplu)}}</td>
                </tr>
            @endif
            <?php
            $plu = $data[$i]->plu;
            $qtysup = $qtysup + $qtyplu;
            $nilaisup = $nilaisup + $nilaiplu;
            $qtyplu = 0;
            $nilaiplu = 0;
            $numbering++;
            ?>
            <tr>
                <td>{{$numbering}}</td>
                <td>{{$data[$i]->plu}}</td>
                <td>{{$data[$i]->prd_deskripsipanjang}}</td>
                <td>{{$strip}}</td>
                <td style="text-align: right">{{$qty}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->nilai)}}</td>
            </tr>
        @else
            <tr>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>{{$strip}}</td>
                <td style="text-align: right">{{$qty}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->nilai)}}</td>
            </tr>
        @endif
        <?php
        $qtyplu = $qtyplu + ($data[$i]->qty);
        $nilaiplu = $nilaiplu + ($data[$i]->nilai);
        ?>
    @endfor
    <?php
    $qtysup = $qtysup + $qtyplu;
    $nilaisup = $nilaisup + $nilaiplu;
    $totalqty = $totalqty + $qtysup;
    $totalnilai = $totalnilai + $nilaisup;
    ?>
    @if($qtyplu<0)
        <?php
        $qtyplu = $qtyplu *(-1);
        ?>
    @endif
    <tr style="font-weight: bold">
        <td> </td>
        <td> Total Per Plu : </td>
        <td> </td>
        <td> </td>
        <td style="text-align: right">{{$qtyplu}}</td>
        <td style="text-align: right">{{rupiah($nilaiplu)}}</td>
    </tr>
    @if($qtysup<0)
        <?php
        $qtysup = $qtysup *(-1);
        ?>
    @endif
    <tr style="font-weight: bold">
        <td> </td>
        <td> Total Per Supplier : </td>
        <td> </td>
        <td> </td>
        <td style="text-align: right">{{$qtysup}}</td>
        <td style="text-align: right">{{rupiah($nilaisup)}}</td>
    </tr>
    @if($totalqty<0)
        <?php
        $totalqty = $totalqty *(-1);
        ?>
    @endif
    <tr style="font-weight: bold">
        <td> </td>
        <td> ** Total Akhir : </td>
        <td> </td>
        <td> </td>
        <td style="text-align: right">{{$totalqty}}</td>
        <td style="text-align: right">{{rupiah($totalnilai)}}</td>
    </tr>
    </tbody>
</table>
@endsection
