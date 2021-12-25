@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Laporan Rekap Member Status Kartu Aktif
@endsection

@section('title')
    Laporan Rekap Member Status Kartu Aktif
@endsection

@section('subtitle')
    Sampai dengan tanggal : {{$periode}}
@endsection

@section('content')
    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
        <tr>
            <th rowspan="3" style="font-size:15px" class="tengah left">STORE</th>
            <th colspan="8" style="font-size:13px" class="tengah">SUB OUTLET</th>
            <th style="font-size:13px" class="tengah">TOTAL</th>
        </tr>
        <tr>
            <th class="tengah right">WHS</th>
            <th class="tengah right">RT_RMB</th>
            <th class="tengah right">RT_RMH</th>
            <th class="tengah right">RT_PSR</th>
            <th class="tengah right">APOTIK</th>
            <th class="tengah right">SUPERMARKET</th>
            <th class="tengah right">MINIMARKET</th>
            <th class="tengah right">OMI</th>
        </tr>
        <tr>
            <th class="tengah right">HOREKA</th>
            <th class="tengah right">KANTOR</th>
            <th class="tengah right">KOPERASI</th>
            <th class="tengah right">RS</th>
            <th class="tengah right">EXPORTIR</th>
            <th class="tengah right">PRIBADI</th>
            <th class="tengah right">KARYAWAN</th>
        </tr>
        </thead>
        <?php
        $total_whs = 0;
        $total_rt_rmb = 0;
        $total_rt_rmh = 0;
        $total_rt_psr = 0;
        $total_apotik = 0;
        $total_supermarket = 0;
        $total_minimarket = 0;
        $total_omi = 0;
        $total_horeka = 0;
        $total_kantor = 0;
        $total_koperasi = 0;
        $total_rs = 0;
        $total_exportir = 0;
        $total_pribadi = 0;
        $total_karyawan = 0;
        $total_total = 0;
        ?>
        <tbody style="border-bottom: 2px solid black;">
        @foreach($data as $d)
            <tr>
                <td class="left">{{ $d->cab_namacabang }}</td>
                <td class="right">{{ number_format($d->whs, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->rt_rmb, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->rt_rmh, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->rt_psr, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->apotik, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->sprmkt, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->mnimrkt, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->omi, 0, '.', ',') }}</td>
                <td class="right"></td>
            </tr>
            <tr>
                <td class="left"></td>
                <td class="right">{{ number_format($d->horeka, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->kantor, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->koperasi, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->rs, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->exportir, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->pribadi, 0, '.', ',') }}</td>
                <td class="right">{{ number_format($d->karyawan, 0, '.', ',') }}</td>
                <td class="right"></td>
                <td class="right">{{ number_format($d->total, 0, '.', ',') }}</td>
            </tr>
            @php
                 $total_whs += $d->whs;
                 $total_rt_rmb += $d->rt_rmb;
                 $total_rt_rmh += $d->rt_rmh;
                 $total_rt_psr += $d->rt_psr;
                 $total_apotik += $d->apotik;
                 $total_supermarket += $d->sprmkt;
                 $total_minimarket += $d->mnimrkt;
                 $total_omi += $d->omi;
                 $total_horeka += $d->horeka;
                 $total_kantor += $d->kantor;
                 $total_koperasi += $d->koperasi;
                 $total_rs += $d->rs;
                 $total_exportir += $d->exportir;
                 $total_pribadi += $d->pribadi;
                 $total_karyawan += $d->karyawan;
                 $total_total += $d->total;
            @endphp
        @endforeach
        <tfoot>
        <tr>
            <td class="left"></td>
            <td class="right">{{ number_format($total_whs, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_rt_rmb, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_rt_rmh, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_rt_psr, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_apotik, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_supermarket, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_minimarket, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_omi, 0, '.', ',') }}</td>
            <td class="right"></td>
        </tr>
        <tr>
            <td class="left"></td>
            <td class="right">{{ number_format($total_horeka, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_kantor, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_koperasi, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_rs, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_exportir, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_pribadi, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($total_karyawan, 0, '.', ',') }}</td>
            <td class="right"></td>
            <td class="right">{{ number_format($total_total, 0, '.', ',') }}</td>
        </tr>
        </tfoot>
    </table>
@endsection
