@extends('html-template')

@section('table_font_size','8 px')

@section('page_title')
    LAPORAN REGISTER BARANG RETUR
@endsection

@section('title')
    ** LAPORAN REGISTER BARANG RETUR  **
@endsection

@section('subtitle')
    {{--    Periode :--}}
    {{--    {{ date("d/m/Y") }}--}}
    TANGGAL : {{$date1}} s/d {{$date2}}<br>
    NO. DOKUMEN : {{$nodoc1}} s/d {{$nodoc2}}
@endsection

@php
    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')
<table style="border-collapse: collapse" class="table">
    <thead style="font-weight: bold; vertical-align: center; text-align: left; border-top: 2px solid black; border-bottom: 2px solid black">
        <tr>
            <td style="width: 50px">TANGGAL</td>
            <td style="width: 30px">NO. NRB</td>
            <td style="width: 50px">TGL. NRB</td>
            <td style="width: 40px">NO. DOKUMEN</td>
            <td style="width: 20px">ITEM</td>
            <td style="width: 30px">TOKO</td>
            <td style="width: 250px">MEMBER</td>
            <td style="text-align: right; width: 100px">NILAI</td>
        </tr>
    </thead>
    <tbody>
    <?php
        $bkp = 0;
        $btkp = 0;
        $temp = '';
    ?>
    @for($i=0;$i<sizeof($data);$i++)
        <?php
            $createDate = new DateTime($data[$i]->tgldok);
            $strip = $createDate->format('d-m-Y');
            $createDate = new DateTime($data[$i]->rom_tglreferensi);
            $strip2 = $createDate->format('d-m-Y');
            $bkp = $bkp + $data[$i]->ttl_bkp;
            $btkp = $btkp + $data[$i]->ttl_btkp;
        ?>
        <tr>
            @if($temp != $strip)
                <td style="text-align: left">{{$strip}}</td>
                <?php
                $temp = $strip;
                ?>
            @else
                <td></td>
            @endif

            <td style="text-align: left">{{$data[$i]->rom_noreferensi}}</td>
            <td style="text-align: left">{{$strip2}}</td>
            <td style="text-align: left">{{$data[$i]->rom_nodokumen}}</td>
            <td style="text-align: left">{{$data[$i]->item}}</td>
            <td style="text-align: left">{{$data[$i]->rom_kodetoko}}</td>
            <td style="text-align: left">{{$data[$i]->member}}</td>
            <td style="text-align: right">{{rupiah($data[$i]->total)}}</td>
        </tr>
    @endfor
    <tr>
        <td colspan="7" style="text-align: right; border-top: 1px solid black">TOTAL BKP</td>
        <td style="border-top: 1px solid black; text-align: right;">{{rupiah($bkp)}}</td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: right;">TOTAL BTKP</td>
        <td style="text-align: right;">{{rupiah($btkp)}}</td>
    </tr>
    <tr>
        <td colspan="7" style="text-align: right; font-weight: bold; border-bottom: 1px solid black">TOTAL</td>
        <td style="border-bottom: 1px solid black; text-align: right;">{{rupiah($bkp + $btkp)}}</td>
    </tr>
    </tbody>
</table>

@endsection
