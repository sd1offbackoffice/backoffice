@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN EDIT PKM TOKO IGR
@endsection

@section('title')
    ** LAPORAN EDIT PKM TOKO IGR **
@endsection

@section('content')
{{--    dasda--}}
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" class="tengah"  style="border: 1px solid black">NO.</th>
            <th rowspan="2" class="tengah"  style="border: 1px solid black">Tgl<br>Update</th>
            <th rowspan="2" class="tengah"  style="border: 1px solid black">PLU</th>
            <th rowspan="2" class="tengah left"  style="border: 1px solid black">Deskripsi</th>
            <th rowspan="2" class="tengah"  style="border: 1px solid black">Frac</th>
            <th rowspan="2" class="tengah"  style="border: 1px solid black">Tag</th>
            <th rowspan="2" class="tengah right"  style="border: 1px solid black">Min<br>Or</th>
            <th rowspan="2" class="tengah"  style="border: 1px solid black">Min<br>Disp</th>
            <th colspan="3" class="tengah"  style="border: 1px solid black">SALES (qty)</th>
            <th rowspan="2" class="tengah" style="border: 1px solid black">LT</th>
            <th rowspan="2" class="tengah" style="border: 1px solid black">SL<br>Supp</th>
            <th rowspan="2" class="tengah" style="border: 1px solid black">n</th>
            <th colspan="4" class="tengah" style="border: 1px solid black">Sebelum</th>
            <th colspan="3" class="tengah" style="border: 1px solid black">Sesudah</th>
        </tr>
        <tr>
            <th class="center" style="border: 1px solid black">{{ $periode1 }}</th>
            <th class="center" style="border: 1px solid black">{{ $periode2 }}</th>
            <th class="center" style="border: 1px solid black">{{ $periode3 }}</th>
            <th class="right" style="border: 1px solid black">PKM</th>
            <th class="right" style="border: 1px solid black">PKM Adj</th>
            <th class="right" style="border: 1px solid black">M Plus</th>
            <th class="right" style="border: 1px solid black">PKMT</th>
            <th class="right" style="border: 1px solid black">PKM</th>
            <th class="right" style="border: 1px solid black">M Plus</th>
            <th class="right" style="border: 1px solid black">PKMT</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 1; @endphp
        @foreach($data as $d)
            <tr>
                <td  style="border: 1px solid black">{{ $i++ }}</td>
                {{-- <td  style="border: 1px solid black">{{ date('d-m-y', strtotime($tglusulan)) }}</td> --}}
                <td  style="border: 1px solid black">{{ date('d-m-y', strtotime($d->upkm_tglproses)) }}</td>
                {{-- <td>{{ $d->upkm_tglproses }}</td> --}}
                <td  style="border: 1px solid black">{{ $d->upkm_prdcd }}</td>
                <td class="left"  style="border: 1px solid black">{{ $d->prd_deskripsipendek }}</td>
                <td  style="border: 1px solid black">{{ $d->prd_frac }}</td>
                <td  style="border: 1px solid black">{{ $d->prd_kodetag }}</td>
                <td class="right"  style="border: 1px solid black">{{ $d->pkm_minorder }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->pkm_mindisplay }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->pkm_qty1 }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->pkm_qty2 }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->pkm_qty3 }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->pkm_leadtime }}</td>
                <td class="right" style="border: 1px solid black">{{ round($d->slv_servicelevel_qty) }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->pkm_koefisien }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->upkm_mpkm_awal }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->upkm_pkmadjust_awal }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->upkm_mplus_awal }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->upkm_pkmt_awal }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->pkm_mpkm }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->pkm_qtymplus }}</td>
                <td class="right" style="border: 1px solid black">{{ $d->pkm_pkmt }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
