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
                $total++;
            @endphp

        @endfor
        <tfoot>
        <tr>
            <th class="left"> TOTAL</th>
            <th class="left">: {{ number_format($total, 0, '.', ',') }} ANGGOTA</th>
        </tr>
        </tfoot>
    </table>
@endsection
