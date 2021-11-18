@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    Daftar Harga Jual Barang per Tanggal {{ date("d/m/Y") }}
@endsection

@section('title')
    ** DAFTAR HARGA JUAL BARANG **
@endsection

@section('subtitle')
    Per Tanggal : {{ date("d/m/Y") }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th rowspan="2" width="3%" class="tengah center">No</th>
            <th rowspan="2" width="6%" class="tengah center">PLU</th>
            <th rowspan="2" width="34%" class="tengah">DESKRIPSI</th>
            <th rowspan="2" width="6%" class="tengah center">TAG</th>
            <th rowspan="2" width="6%" class="tengah">SATUAN</th>
            <th colspan="2" width="12%" class="right">HARGA CARTON</th>
            <th colspan="3" width="15%" class="center">HARGA MJT</th>
            <th rowspan="2" width="6%" class="tengah">HARGA SATUAN</th>
            <th rowspan="2" width="6%" class="tengah">STOK</th>
            <th rowspan="2" width="6%" class="tengah">KETERANGAN</th>
        </tr>
        <tr>
            <th width="6%" class="right">Rp CTN</th>
            <th width="6%" class="right">Rp PCS</th>
            <th width="6%" class="right">Rp MBT</th>
            <th width="3%" class="right">MINJ</th>
            <th width="6%" class="right">Rp PCS</th>
        </tr>
        </thead>
        <tbody>
        @php $no = 1; @endphp
        @foreach($data as $d)
            <tr>
                <td width="6%" class="center">{{ $no++ }}</td>
                <td width="6%" class="center">{{ $d->mpl_prdcd }}</td>
                <td width="34%" class="left">{{ $d->prd_desc }}</td>
                <td width="3%" class="center">{{ $d->prd_kodetag }}</td>
                <td width="6%" class="left">{{ $d->satuan }}</td>
                <td width="6%" class="right">{{ number_format($d->hrg_a, 0, '.', ',') }}</td>
                <td width="6%" class="right">{{ number_format($d->hrg_e, 0, '.', ',') }}</td>
                <td width="6%" class="right">{{ number_format($d->hrg_d, 0, '.', ',') }}</td>
                <td width="3%" class="right">{{ number_format($d->hrg_b, 0, '.', ',') }}</td>
                <td width="6%" class="right">{{ number_format($d->hrg_c, 0, '.', ',') }}</td>
                <td width="6%" class="right">{{ number_format($d->hrg_1, 0, '.', ',') }}</td>
                <td width="6%" class="right">{{ number_format($d->st_saldoakhir, 0, '.', ',') }}</td>
                <td width="6%" class="left">{{ $d->ket }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="13" class="right">** Akhir dari laporan **</td>
        </tr>
        </tfoot>
    </table>
@endsection
