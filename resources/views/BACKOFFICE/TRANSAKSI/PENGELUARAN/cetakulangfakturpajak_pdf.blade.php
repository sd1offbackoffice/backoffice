@extends('BACKOFFICE.TRANSAKSI.PENGELUARAN.cetakulangfakturpajak-template')
@section('table_font_size','7 px')

@section('page_title')
    CETAK ULANG FAKTUR PAJAK
@endsection

@section('title')
    {{-- ** CETAK ULANG FAKTUR PAJAK ** --}}
@endsection

@section('subtitle')
    {{-- NPB: {{$npb1}} s/d {{$npb2}} --}}
@endsection

@section('content')
    @foreach ($data as $d)

        @php
            $datetime = new DateTime();
            $timezone = new DateTimeZone('Asia/Jakarta');
            $datetime->setTimezone($timezone);
            $temp_docno2 ='';
        @endphp

    @php
        $cf_fakturpjk = '';
       $cf_nofak = '';
       $f_1 = '';
       $flag = '';
       $faktur = '';
       $cf_skp_sup = '';
               $total = 0;
               $no=1;
               $nQty2 = floor($d->mstd_qty / $d->mstd_frac);
               $nQtyK = fmod($d->mstd_qty, $d->mstd_frac);

               if ($d->mstd_unit == "KG") {
                   $nQty = ((($nQty2) * $d->mstd_frac) + ($nQtyK)) / $d->mstd_frac;
               } else {
                   $nQty = (($nQty2) * $d->mstd_frac) + $nQtyK;
               }

               $nGross = $d->mstd_gross - $d->mstd_discrph;
               $nPrice = ($nGross / ($nQty2 * $d->mstd_frac + $nQtyK));


     $cf_fakturpjk = $d->mstd_istype . '.' . $d->mstd_invno;
    $cf_nofak = $d->prs_kodemto . '.' . substr($d->msth_tgldoc, 8, 2) . '.0' . $d->mstd_docno2 . $d->msth_flagdoc == 'T' ? '*' : '';
    if ($d->sup_tglsk) {
        $cf_skp_sup = $d->sup_nosk . ' Tanggal PKP : ' . date('d-M-y', strtotime(substr($d->sup_tglsk, 0, 10)));
    } else {
        $cf_skp_sup = $d->sup_nosk;
    }
    $f_1 = $d->sup_namanpwp ? $d->sup_namanpwp : $d->sup_namasupplier . " " . $d->sup_singkatansupplier;
    $flag = $d->msth_flagdoc==1?'*':'';
    $faktur = $d->prs_kodemto.'.' . substr($d->msth_tgldoc,9,2) . '.0'.$d->mstd_docno2.$flag;
    @endphp

    @if($temp_docno2!=$d->mstd_docno2)


{{--        <div style="display: flex; justify-content: end; margin-right: 80%">--}}
{{--        <p>{{$d->mstd_istype.'.'.$d->mstd_invno}}</p>--}}
{{--        </div>--}}
<table>
<thead>
<h3 style="text-align:center;">NOTA RETUR</h3>

<div style="display;  flex; justify-content: end; ">
    <p style="margin-left: 70%">Nomor: {{ $d->mstd_docno2 }}</p>
</div>


<div style="text-align: center; flex; justify-content: end; ">
<p>Atas Faktur Pajak Nomor: {{$d->mstd_istype.'.'.$d->mstd_invno}} &nbsp; Tanggal: {{date('d-m-Y', strtotime(substr($d->mstd_date3, 0, 10)))}}</p>
</div>


</thead>
</table>

<table class="table1">
    <h3>PEMBELI</h3>
    <div>

        <p>Nama : {{ $d->prs_namaperusahaan }}</p>
        <p>Alamat : {{ $d->const_addr }}</p>
        <p>N.P.W.P : {{ $d->prs_npwp }}</p>
    </div>
    <br>

    <h3>KEPADA PENJUAL</h3>
    <div>
        <p>Nama : {{ $f_1 }} <br></p>
        <p>Alamat: {{ $d->addr_sup }}<br></p>
        <p >N.P.W.P : {{ $d->sup_npwp }}<br></p>
        <p>No. Pengukuhan PKP : {{ $cf_skp_sup }}</p>
    </div>

    <br>

        @endif
</table>
    <br>

    <table class="table">
        <thead>
            <td>No. Urut</td>
            <td>Nama Produk</td>
            <td>Kuantum</td>
            <td>Harga Satuan Menurut Faktur Pajak (Rp.)</td>
            <td>Harga BKP yang dikembalikan (Rp.)</td>
        </thead>
        <tbody>
        <tr>
            <td>{{ $no }}</td>
            <td>{{ $d->prd_deskripsipanjang }}</td>
            <td>{{ number_format($nQty, 0) }}</td>
            <td>{{ number_format($nPrice, 0) }}</td>
            <td>{{ number_format($nGross, 0) }}</td>
        </tr>
        @php
            $no++;

        @endphp
        </tbody>
    </table>
<br>

<table class="table" style="margin-top: 100px">

    <tbody>
    <td align="left">Jumlah Harga BKP yang dikembalikan</td>
    <td> {{ number_format($nGross, 0) }}</td>
    </tbody>

    <tbody>
    <td align="left">Pajak Pertambahan Nilai yang diminta kembali</td>
    <td>{{ number_format(floor($nGross * 0.1), 0) }}</td>
    </tbody>

    <tbody>
    <td align="left">Pajak Penjualan Atas Barang Mewah yang diminta kembali</td>
    <td>{{ number_format(floor($nGross * 0), 0) }}</td>
    </tbody>


</table>







{{--           <tr>{{ number_format($nGross, 0) }}</tr>--}}
{{--            <tr>{{ number_format(floor($nGross * 0.1), 0) }}</tr>--}}



{{--       <div class="row" style="margin-right:80%">Pajak Pertambahan Nilai yang diminta kembali</div>--}}
{{--            <tr>{{ number_format(floor($nGross * 0.1), 0) }}</tr>--}}
<br>
<br>


    <div style="text-align:right; justify-content: end;">
        <div class="row">
            <p>{{ $d->prs_namawilayah }}, {{ date("d M Y") }}</p>
        </div>
            <br>
            <br>
            <br>
        <div style=" justify-content: end; margin-right: 5%">
            <p>{{ $ttd }}</p>
            <p>{{ $role1 }}</p>
        </div>
    </div>

<div style="text-align:left; display: flex; justify-content: start;">
    <div class="row">
        <p>NRB : {{ $d->msth_nodoc }}</p>
    </div>
</div>


<div style="text-align:left; justify-content: end;" >

        <p>Lembar ke-1: Untuk Pengusaha Kena Pajak yang Menerbitkan Faktur Pajak.</p>
        <p>Lembar ke-1: Untuk Pembeli.</p>

</div>


    <div class="pagebreak"></div>

    @endforeach
@endsection
