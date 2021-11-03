@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-REGISTER STRUK KASIR
@endsection

@section('title')
    REGISTER STRUK KASIR
@endsection

@section('subtitle')
    {{$periode}}
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
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black; text-align: center">
            <tr style="text-align: left; vertical-align: center">
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 3%;">No.</th>
                <th style="width: 15%;">Waktu</th>
                <th style="width: 7%;">Station</th>
                <th style="width: 55%;">Kasir</th>
                <th style="width: 10%;">Struk</th>
                <th style="text-align: right; width: 25%;">Nilai</th>
            </tr>
        </thead>
        <?php
        $theDate = '';
        $cashier = '';
        ?>
        <tbody style="border-bottom: 2px solid black; text-align: left">
        @for($i=0;$i<sizeof($data);$i++)
            <?php
            $createDate = new DateTime($data[$i]->jh_transactiondate);
            $strip = $createDate->format('d-m-Y');
            ?>
            <tr>
                @if($theDate != $strip)
                    <?php
                    $theDate = $strip
                    ?>
                        <td>{{$strip}}</td>
                @else
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td>{{$i+1}}</td>
                <td>{{$data[$i]->waktu}}</td>
                <td>{{$data[$i]->jh_cashierstation}}</td>
                <td>{{$data[$i]->jh_cashier}}</td>
                <td>{{$data[$i]->jh_transactionno}}</td>
                <td style="text-align: right">{{rupiah($data[$i]->jh_transactionamt)}}</td>
            </tr>

        @endfor
        </tbody>
    </table>
@endsection

