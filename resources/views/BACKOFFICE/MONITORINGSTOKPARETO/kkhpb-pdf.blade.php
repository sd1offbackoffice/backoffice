@extends('html-template')

@section('paper_width','842pt')
@section('paper_height','595pt')

@section('table_font_size','7 px')

@section('page_title')
    Kertas Kerja Harian PB Manual
@endsection

@section('title')
    ** KERTAS KERJA HARIAN PB MANUAL **
@endsection

@section('header_left')
    <p>Tabel Monitoring : {{ $monitoring->kode }} - {{ $monitoring->nama }}</p>
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="tengah" rowspan="2">PLU</th>
            <th class="tengah" rowspan="2">DESKRIPSI</th>
            <th class="tengah" colspan="2">SATUAN</th>
            <th class="tengah" colspan="3">SALES 3 BULAN</th>
            <th class="tengah" rowspan="2">JML HARI<br>SALES</th>
            <th class="tengah" colspan="2">AVG SALES</th>
            <th class="tengah" colspan="2">SALDO</th>
            <th class="tengah" colspan="2">OUTSTAND PO</th>
            <th class="tengah" rowspan="2">LT</th>
            <th class="tengah" colspan="3">MINOR</th>
            <th class="tengah" rowspan="2">PKMT</th>
            <th class="tengah" colspan="2">MAX PALLET</th>
            <th class="tengah" rowspan="2">QTY PB<br>AJUAN</th>
        </tr>
        <tr>
            <th>JUAL</th>
            <th>BELI</th>
            <th>BLN-1</th>
            <th>BLN-2</th>
            <th>BLN-3</th>
            <th>BULAN</th>
            <th>HARI</th>
            <th>AWAL</th>
            <th>SAAT INI</th>
            <th>JML PO</th>
            <th>QTY</th>
            <th>QTY</th>
            <th>RUPIAH</th>
            <th>KLPTN</th>
            <th>IN CTN</th>
            <th>IN PCS</th>
        </tr>
        </thead>
        <tbody>
        @php $temp = ''; @endphp
        @foreach($data as $d)
            @if($temp != $d->kdsup)
                @php $temp = $d->kdsup; @endphp
                <tr>
                    <td colspan="22" class="left"><strong>Kode Supplier : {{ $d->kdsup }} - {{ $d->nmsup }}</strong></td>
                </tr>
            @endif
            <tr>
                <td>{{ $d->plu }}</td>
                <td class="left">{{ $d->deskripsi }}</td>
                <td>{{ $d->satuan_jual }}</td>
                <td>{{ $d->satuan_beli }}</td>
                <td class="right">{{ number_format(intval($d->qty3)) }}</td>
                <td class="right">{{ number_format(intval($d->qty2)) }}</td>
                <td class="right">{{ number_format(intval($d->qty1)) }}</td>
                <td class="right">{{ number_format(intval($d->cp_hari)) }}</td>
                <td class="right">{{ number_format(intval($d->cp_avgbulan)) }}</td>
                <td class="right">{{ number_format(intval($d->cp_avghari)) }}</td>
                <td class="right">{{ number_format(intval($d->saldoawal)) }}</td>
                <td class="right">{{ number_format(intval($d->saldoakhir)) }}</td>
                <td class="right">{{ number_format(intval($d->outpo)) }}</td>
                <td class="right">{{ number_format(intval($d->outqty)) }}</td>
                <td class="right">{{ number_format(intval($d->lt)) }}</td>
                <td class="right">{{ number_format(intval($d->minqty)) }}</td>
                <td class="right">{{ number_format(intval($d->minrph)) }}</td>
                <td class="right">{{ $d->minklptn }}</td>
                <td class="right">{{ number_format(intval($d->pkmt)) }}</td>
                <td class="right">{{ number_format(intval($d->max_ctn)) }}</td>
                <td class="right">{{ number_format(intval($d->max_pcs)) }}</td>
                <td class="right">{{ number_format(intval($d->cp_qtypb)) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
