@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN EDIT PKM TOKO IGR
@endsection

@section('title')
    ** LAPORAN EDIT PKM TOKO IGR **
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah">NO.</th>
            <th rowspan="2" class="tengah">Tgl<br>Update</th>
            <th rowspan="2" class="tengah">PLU</th>
            <th rowspan="2" class="tengah left">Deskripsi</th>
            <th rowspan="2" class="tengah right">Frac</th>
            <th rowspan="2" class="tengah">Tag</th>
            <th rowspan="2" class="tengah right">Min<br>Or</th>
            <th rowspan="2" class="tengah right">Min<br>Disp</th>
            <th colspan="3" class="tengah">SALES (qty)</th>
            <th rowspan="2" class="tengah right">LT</th>
            <th rowspan="2" class="tengah right">SL<br>Supp</th>
            <th rowspan="2" class="tengah right">n</th>
            <th colspan="4" class="tengah">Sebelum</th>
            <th colspan="3" class="tengah">Sesudah</th>
        </tr>
        <tr>
            <th class="right">{{ $periode1 }}</th>
            <th class="right">{{ $periode2 }}</th>
            <th class="right">{{ $periode3 }}</th>
            <th class="right">PKM</th>
            <th class="right">PKM Adj</th>
            <th class="right">M Plus</th>
            <th class="right">PKMT</th>
            <th class="right">PKM</th>
            <th class="right">M Plus</th>
            <th class="right">PKMT</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 1; @endphp
        @foreach($data as $d)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $d->upkm_tglproses }}</td>
                <td>{{ $d->upkm_prdcd }}</td>
                <td class="left">{{ $d->prd_deskripsipendek }}</td>
                <td>{{ $d->prd_frac }}</td>
                <td>{{ $d->prd_kodetag }}</td>
                <td class="right">{{ $d->pkm_minorder }}</td>
                <td class="right">{{ $d->pkm_mindisplay }}</td>
                <td class="right">{{ $d->pkm_qty1 }}</td>
                <td class="right">{{ $d->pkm_qty2 }}</td>
                <td class="right">{{ $d->pkm_qty3 }}</td>
                <td class="right">{{ $d->pkm_leadtime }}</td>
                <td class="right">{{ round($d->slv_servicelevel_qty) }}</td>
                <td class="right">{{ $d->pkm_koefisien }}</td>
                <td class="right">{{ $d->upkm_mpkm_awal }}</td>
                <td class="right">{{ $d->upkm_pkmadjust_awal }}</td>
                <td class="right">{{ $d->upkm_mplus_awal }}</td>
                <td class="right">{{ $d->upkm_pkmt_awal }}</td>
                <td class="right">{{ $d->pkm_mpkm }}</td>
                <td class="right">{{ $d->pkm_qtymplus }}</td>
                <td class="right">{{ $d->pkm_pkmt }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
