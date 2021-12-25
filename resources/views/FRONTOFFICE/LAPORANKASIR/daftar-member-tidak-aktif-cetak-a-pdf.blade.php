@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    DAFTAR ANGGOTA / MEMBER YANG TIDAK AKTIF
@endsection

@section('title')
    DAFTAR ANGGOTA / MEMBER YANG TIDAK AKTIF
@endsection

@section('header_left')
    Tanggal : {{date('d/m/Y',strtotime(substr(\Carbon\Carbon::now(),0,10)))}}
    <br>
    <br>
    Urut : {{$urut}}
@endsection


@section('content')
    <?php
        $tempoutlet = '';
        $temparea = '';
        $st_outlet = 0;
        $st_area = 0;
        $total = 0;
    ?>
    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
        <tr>
            <th class="tengah right padding-right">KODE</th>
            <th class="tengah left">NO. KARTU</th>
            <th class="tengah left">NAMA MEMBER</th>
            <th class="tengah left">ALAMAT</th>
            <th class="tengah right padding-right">PKP</th>
            <th class="tengah left">NPWP</th>
            <th class="tengah right padding-right">KREDIT LIMIT</th>
            <th class="tengah left">TERM</th>
            <th class="tengah left">TGL HABIS</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 2px solid black;">
        @for($i = 0 ; $i < sizeof($data); $i++)
            @if($tempoutlet != $data[$i]->cus_kodeoutlet)
                <tr>
                    <td class="left"><b>*** OUTLET </b></td>
                    <td class="left"><b>: {{$data[$i]->cus_kodeoutlet}} - {{$data[$i]->out_namaoutlet}}</b></td>
                </tr>
                @php
                    $tempoutlet=$data[$i]->cus_kodeoutlet;
                @endphp
            @endif
            @if($temparea != $data[$i]->cus_kodearea )
                <tr>
                    <td class="left"><b>* AREA</b></td>
                    <td class="left"><b>: {{$data[$i]->cus_kodearea}}</b></td>
                </tr>
                @php
                    $temparea=$data[$i]->cus_kodearea;
                @endphp
            @endif
            <tr>
                <td class="right padding-right">{{ $data[$i]->cus_kodemember }}</td>
                <td class="left">{{ $data[$i]->cus_nomorkartu }}</td>
                <td class="left">{{ $data[$i]->cus_namamember }}</td>
                <td class="left">{{ $data[$i]->cus_alamatmember1 }}</td>
                <td class="right padding-right">{{ $data[$i]->cus_flagpkp }}</td>
                <td class="left">{{ $data[$i]->cus_npwp }}</td>
                <td class="right padding-right">{{ $data[$i]->cus_creditlimit }}</td>
                <td class="left">{{ $data[$i]->cus_top }}</td>
                <td class="left">{{ date('d/m/Y',strtotime(substr($data[$i]->cus_tgl_registrasi,0,10))) }}</td>
            </tr>
            <tr>
                <td colspan="3" class="left"></td>
                <td class="left">{{ $data[$i]->cus_alamatmember2 }}</td>
                <td class="left">{{ $data[$i]->cus_tlpmember }}</td>
            </tr>
            @php
                $st_outlet++;
                $st_area++;
                $total++;
            @endphp
            @if(isset($data[$i+1]) && ($temparea != $data[$i+1]->cus_kodearea) || !(isset($data[$i+1])) )
                <tr>
                    <th class="left">* SUB TOTAL AREA {{ $data[$i]->cus_kodearea }}</th>
                    <th class="left">: {{ number_format($st_area, 0, '.', ',') }} ANGGOTA</th>
                </tr>
                @php
                    $st_area = 0;
                @endphp
            @endif
            @if( isset($data[$i+1]) && ($tempoutlet != $data[$i+1]->cus_kodeoutlet) || !(isset($data[$i+1])) )
                <tr>
                    <th class="left">*** SUB TOTAL OUTLET {{ $data[$i]->cus_kodeoutlet }}</th>
                    <th class="left">: {{ number_format($st_outlet, 0, '.', ',') }} ANGGOTA</th>
                </tr>
                @php
                    $st_outlet = 0;
                @endphp
            @endif
        @endfor
        <tfoot>
        <tr>
            <th class="left"> TOTAL</th>
            <th class="left">: {{ number_format($total, 0, '.', ',') }} ANGGOTA</th>
        </tr>
        </tfoot>
    </table>
@endsection
