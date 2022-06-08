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
            <div style="border: 1px solid pink">

                <h3 style="text-align:center;">NOTA RETUR </h3>
                <p style="margin-left: 70% ">Nomor: {{ $d->mstd_docno2 }}</p>
                <p style="text-align: center; flex; justify-content: end; ">Atas Faktur Pajak Nomor: {{$d->mstd_istype.'.'.$d->mstd_invno}} &nbsp; Tanggal: {{date('d-m-Y', strtotime(substr($d->mstd_date3, 0, 10)))}}</p>
            </div>

            <div style="border:  1px solid pink">
                <table class="table">

                    <h3>PEMBELI</h3>
                    <tr >
                        <p >Nama : {{ $d->prs_namaperusahaan }}</p>
                        <p>Alamat : {{ $d->const_addr }}</p>
                        <p style="border-bottom: 1px solid pink">N.P.W.P : {{ $d->prs_npwp }}</p>
                    </tr>

                </table>

                <table class="table" >
                    <h3>KEPADA PENJUAL</h3>
                    <tr style=" border-bottom:  1px solid pink">
                        <p>Nama : {{ $f_1 }} <br></p>
                        <p>Alamat: {{ $d->addr_sup }}<br></p>
                        <p >N.P.W.P : {{ $d->sup_npwp }}<br></p>
                        <p>No. Pengukuhan PKP : {{ $cf_skp_sup }}</p>
                    </tr>

                </table>

            </>
        @endif
        <br>

        <table class="table table-bordered">
            <thead>
            <tr style="border-bottom:  1px solid pink;">
                <th scope="col" >No. Urut</th>
                <th scope="col">Nama Produk</th>
                <th scope="col">Kuantum</th>
                <th scope="col">Harga Satuan Menurut Faktur Pajak (Rp.)</th>
                <th scope="col">Harga BKP yang dikembalikan (Rp.)</th>
            </tr>
            </thead>
            <tbody>
            <tr style=" border-bottom:  1px solid pink">
                <th scope="row" >{{ $no }}</th>
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

        <table class="table" style="margin-top: 100px; border-left:  1px solid pink; border-right:  1px solid pink;">

            <tr style="border-top:  1px solid pink; border-bottom:  1px solid pink">
                <td align="left" >Jumlah Harga BKP yang dikembalikan</td>
                <td> {{ number_format($nGross, 0) }}</td>
            </tr>

            <tr style="border-bottom:  1px solid pink">
                <td align="left">Pajak Pertambahan Nilai yang diminta kembali</td>
                <td>{{ number_format(floor($nGross * 0.1), 0) }}</td>
            </tr>

            <tr style="border-bottom:  1px solid pink">
                <td align="left">Pajak Penjualan Atas Barang Mewah yang diminta kembali</td>
                <td>{{ number_format(floor($nGross * 0), 0) }}</td>
            </tr>

        </table>
        {{--           <tr>{{ number_format($nGross, 0) }}</tr>--}}
        {{--            <tr>{{ number_format(floor($nGross * 0.1), 0) }}</tr>--}}

        {{--       <div class="row" style="margin-right:80%">Pajak Pertambahan Nilai yang diminta kembali</div>--}}
        {{--            <tr>{{ number_format(floor($nGross * 0.1), 0) }}</tr>--}}


        <div class="row" style="text-align:right; border: 1px solid pink;" >
            <p >{{ $d->prs_namawilayah }}, {{ date("d M Y") }}</p>

            <br>
            <br>
            <br>

            <p style="margin-right:8%;"><u>{{ $ttd }}</u></p>
            <p style="margin-right:9%;">{{ $role1 }}</p>

            <div class="row" style="text-align:left;">
                <p>NRB : {{ $d->msth_nodoc }}</p>
            </div>
        </div>





        <div style="text-align:left;  border: 1px solid pink; justify-content: end;" >

            <p>Lembar ke-1: Untuk Pengusaha Kena Pajak yang Menerbitkan Faktur Pajak.</p>
            <p>Lembar ke-2: Untuk Pembeli.</p>

        </div>

        <style>

            table.table-bordered{
                border: 1px solid pink;
            }

            table1.table-bordered{
                border: 1px solid pink;
            }



            /*tr:nth-child(even) {background-color: pink;*/

            /*th{*/

            /*    background-color: #fff;*/

            /*    color:#000;*/

            /*    border: 1px  1px solid #FFC0CB;*/

            /*}*/

            /*td{*/

            /*    background-color: #fff;*/

            /*    color:#000;*/

            /*    border: 1px  1px solid #FFC0CB;*/

            /*}*/

            /*tr{*/

            /*    background-color: #fff;*/

            /*    color:#000;*/

            /*    border-bottom: 1px  1px solid #FFC0CB;*/

            /*}*/


            /*p{*/

            /*    background-color: #fff;*/

            /*    color:#000;*/

            /*    border-bottom: 1px  1px solid #FFC0CB;*/

            /*}*/

        </style>

        <div class="pagebreak"></div>

    @endforeach
@endsection
