{{--NOTE :
Perubahan kulakukan untuk menyamakan dengan hasil laporan sesuai dengan yang kulihat, ku tidak tahu kenapa kenapa harus ada kondisi ini, tapi hasil laporannya begitu, ya begimana lagi
1. data perdivisi hanya menampilkan data dimana "omisbu == 'I'", kalau ingin menampilkan semua hapus semua kondisi dimana "omisbu == 'I'", harusnya ada 3
2. {{$data[$i]->namasbu}} : {{$data[$i]->omidiv}} {{$namaomi}} tidak ditampilkan
3. di program baru diminta ditampilin semua, lol
--}}

@extends('html-template')

@section('table_font_size','7 px')

@section('paper_width','1200pt')
@section('paper_height','842pt')
@section('page_title')
    {{ isset($data[0])?$data[0]->judul:'' }}
@endsection

@section('title')
    {{ isset($data[0])?$data[0]->judul:'' }}
@endsection

@section('subtitle')
    TANGGAL : {{$txt_tgl1}} s/d {{$txt_tgl2}}
@endsection

@php
    //rupiah formatter (no Rp or .00)
    function rupiah($angka){
    //    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
    function percent($angka){
        $hasil_rupiah = number_format($angka,2,'.',',');
        return $hasil_rupiah;
    }
    $temp ='';

$sub_item =0;
$sub_sawalqty =0;
$sub_akhirqty =0;
$sub_sawalrph =0;
$sub_belirph =0;
$sub_bonusrph =0;
$sub_trmcbrph =0;
$sub_returrph =0;
$sub_repackrph =0;
$sub_laininrph =0;
$sub_salesrph =0;
$sub_kirimrph =0;
$sub_prepackrph =0;
$sub_hilangrph =0;
$sub_lainoutrph =0;
$sub_selso_rph =0;
$sub_intrstrph =0;
$sub_adjrph =0;
$sub_sadj =0;
$sub_akhirrph =0;
$total_item =0;
$total_sawalqty =0;
$total_akhirqty =0;
$total_sawalrph =0;
$total_belirph =0;
$total_bonusrph =0;
$total_trmcbrph =0;
$total_returrph =0;
$total_repackrph =0;
$total_laininrph =0;
$total_salesrph =0;
$total_kirimrph =0;
$total_prepackrph =0;
$total_hilangrph =0;
$total_lainoutrph =0;
$total_selso_rph =0;
$total_intrstrph =0;
$total_adjrph =0;
$total_sadj =0;
$total_akhirrph =0;
@endphp

@section('content')
    <table class="table table-bordered table-responsive" style="border-collapse: collapse;" >
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;" >
        <tr>
            <th colspan="4" class="center tengah"></th>
            <th colspan="5" class="center tengah">------------------------------------------PENERIMAAN------------------------------------</th>
            <th colspan="5" class="center tengah">------------------------------------------PENGELUARAN------------------------------------</th>
            <th colspan="8" class="center tengah"></th>
        </tr>
        <tr>
            <th colspan="2" class="center tengah">SALDO AWAL</th>
            <th colspan="2" class="center tengah">------PEMBELIAN------</th>
            <th class="center tengah">TRANSFER IN</th>
            <th class="center tengah">RETUR<br>PENJUALAN</th>
            <th class="center tengah">REPACK IN<br>(REPACK)</th>
            <th class="center tengah">LAIN-LAIN</th>
            <th class="center tengah">PENJUALAN</th>
            <th class="center tengah">TRANSFER<br>OUT</th>
            <th class="center tengah">REPACK OUT<br>(PREPACK)</th>
            <th class="center tengah">HILANG</th>
            <th class="center tengah">LAIN-LAIN</th>
            <th class="center tengah">SO</th>
            <th class="center tengah">INTRANSIT</th>
            <th class="center tengah">PENYESUAIAN</th>
            <th class="center tengah">KOREKSI</th>
            <th class="center tengah">SALDO<br>AKHIR</th>
            <th class="center tengah">GDANG-X<br>SRV. SUP</th>
            <th class="center tengah">SERV<br>TOKO</th>
            <th class="center tengah">SALDO<br>TOKO</th>
        </tr>
        <tr>
            <th colspan="2"></th>
            <th>MURNI</th>
            <th>BONUS</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: right">
        @for($i=0;$i<sizeof($data);$i++)
            @if($temp != $data[$i]->lpp_kodedepartemen.$data[$i]->lpp_kategoribrg)
                <tr>
                    <th class="left">DEPARTEMEN :</th>
                    <th colspan="2" class="left">{{$data[$i]->lpp_kodedepartemen}} - {{$data[$i]->dep_namadepartement}}</th>
                    <th colspan="2"></th>
                    <th class="left">KATEGORI :</th>
                    <th colspan="4" class="left">{{$data[$i]->lpp_kategoribrg}} - {{$data[$i]->kat_namakategori}}</th>
                </tr>
                @php
                    $temp = $data[$i]->lpp_kodedepartemen.$data[$i]->lpp_kategoribrg;
                    $sub_item =0;

                @endphp
            @endif
            <tr>
                <td class="left">{{$data[$i]->lpp_prdcd}}</td>
                <td colspan="4" class="left">{{$data[$i]->prd_deskripsipanjang}}</td>
                <td class="left">{{$data[$i]->kemasan}}</td>
            </tr>
            <tr>
                <td class="left">UNIT :</td>
                <td class="right">{{rupiah($data[$i]->sawalqty)}}</td>
                <td class="right">{{rupiah($data[$i]->beliqty)}}</td>
                <td class="right">{{rupiah($data[$i]->bonusqty)}}</td>
                <td class="right">{{rupiah($data[$i]->trmcbqty)}}</td>
                <td class="right">{{rupiah($data[$i]->retursalesqty)}}</td>
                <td class="right">{{rupiah($data[$i]->repackqty)}}</td>
                <td class="right">{{rupiah($data[$i]->laininqty)}}</td>
                <td class="right">{{rupiah($data[$i]->salesqty)}}</td>
                <td class="right">{{rupiah($data[$i]->kirimqty)}}</td>
                <td class="right">{{rupiah($data[$i]->prepackqty)}}</td>
                <td class="right">{{rupiah($data[$i]->hilangqty)}}</td>
                <td class="right">{{rupiah($data[$i]->lainoutqty)}}</td>
                <td class="right">{{rupiah($data[$i]->sel_so)}}</td>
                <td class="right">{{rupiah($data[$i]->intrstqty)}}</td>
                <td class="right">{{rupiah($data[$i]->adjqty)}}</td>
                <td class="right">0</td>
                <td class="right">{{rupiah($data[$i]->akhirqty)}}</td>
                <td class="right">{{rupiah($data[$i]->servqsup)}}</td>
                <td class="right">{{rupiah($data[$i]->servqtok)}}</td>
                <td class="right">{{rupiah($data[$i]->saldotoko)}}</td>
            </tr>
            <tr>
                <td class="left">RPH :</td>
                <td class="right">{{rupiah($data[$i]->sawalrph)}}</td>
                <td class="right">{{rupiah($data[$i]->belirph)}}</td>
                <td class="right">{{rupiah($data[$i]->bonusrph)}}</td>
                <td class="right">{{rupiah($data[$i]->trmcbrph)}}</td>
                <td class="right">{{rupiah($data[$i]->retursalesrph)}}</td>
                <td class="right">{{rupiah($data[$i]->repackrph)}}</td>
                <td class="right">{{rupiah($data[$i]->laininrph)}}</td>
                <td class="right">{{rupiah($data[$i]->salesrph)}}</td>
                <td class="right">{{rupiah($data[$i]->kirimrph)}}</td>
                <td class="right">{{rupiah($data[$i]->prepackrph)}}</td>
                <td class="right">{{rupiah($data[$i]->hilangrph)}}</td>
                <td class="right">{{rupiah($data[$i]->lainoutrph)}}</td>
                <td class="right">{{rupiah($data[$i]->rph_sel_so)}}</td>
                <td class="right">{{rupiah($data[$i]->intrstrph)}}</td>
                <td class="right">{{rupiah($data[$i]->adjrph)}}</td>
                <td class="right">{{rupiah($data[$i]->sadj)}}</td>
                <td class="right">{{rupiah($data[$i]->akhirrph)}}</td>
            </tr>
            @php
                $sub_item ++;
                $sub_sawalqty += $data[$i]->sawalqty;
                $sub_akhirqty += $data[$i]->akhirqty;

                $sub_sawalrph += $data[$i]->sawalrph;
                $sub_belirph += $data[$i]->belirph;
                $sub_bonusrph += $data[$i]->bonusrph;
                $sub_trmcbrph += $data[$i]->trmcbrph;
                $sub_returrph += $data[$i]->retursalesrph;
                $sub_repackrph += $data[$i]->repackrph;
                $sub_laininrph += $data[$i]->laininrph;
                $sub_salesrph += $data[$i]->salesrph;
                $sub_kirimrph += $data[$i]->kirimrph;
                $sub_prepackrph += $data[$i]->prepackrph;
                $sub_hilangrph += $data[$i]->hilangrph;
                $sub_lainoutrph += $data[$i]->lainoutrph;
                $sub_selso_rph += $data[$i]->rph_sel_so;
                $sub_intrstrph += $data[$i]->intrstrph;
                $sub_adjrph += $data[$i]->adjrph;
                $sub_sadj += $data[$i]->sadj;
                $sub_akhirrph += $data[$i]->akhirrph;

                $total_item++;
                $total_sawalqty += $data[$i]->sawalqty;
                $total_akhirqty += $data[$i]->akhirqty;

                $total_sawalrph += $data[$i]->sawalrph;
                $total_belirph += $data[$i]->belirph;
                $total_bonusrph += $data[$i]->bonusrph;
                $total_trmcbrph += $data[$i]->trmcbrph;
                $total_returrph += $data[$i]->retursalesrph;
                $total_repackrph += $data[$i]->repackrph;
                $total_laininrph += $data[$i]->laininrph;
                $total_salesrph += $data[$i]->salesrph;
                $total_kirimrph += $data[$i]->kirimrph;
                $total_prepackrph += $data[$i]->prepackrph;
                $total_hilangrph += $data[$i]->hilangrph;
                $total_lainoutrph += $data[$i]->lainoutrph;
                $total_selso_rph += $data[$i]->rph_sel_so;
                $total_intrstrph += $data[$i]->intrstrph;
                $total_adjrph += $data[$i]->adjrph;
                $total_sadj += $data[$i]->sadj;
                $total_akhirrph += $data[$i]->akhirrph;
            @endphp
            @if( !isset($data[$i+1]->lpp_kodedepartemen) || (isset($data[$i+1]->lpp_kodedepartemen) && $temp != $data[$i+1]->lpp_kodedepartemen.$data[$i+1]->lpp_kategoribrg) )
            <tr style="border-top: 1px solid black">
                <th class="left">{{$sub_item}} </th>
                <th class="left">ITEM</th>
            </tr>
            <tr>
                <th class="left">UNIT</th>
                <th class="right">{{rupiah($sub_sawalqty)}}</th>
                <th colspan="16" class="left"></th>
                <th class="right">{{rupiah($sub_akhirqty)}}</th>
            </tr>
            <tr >
                <th class="left">RPH</th>
                <th class="right">{{rupiah($sub_sawalrph)}}</th>
                <th class="right">{{rupiah($sub_belirph)}}</th>
                <th class="right">{{rupiah($sub_bonusrph)}}</th>
                <th class="right">{{rupiah($sub_trmcbrph)}}</th>
                <th class="right">{{rupiah($sub_returrph)}}</th>
                <th class="right">{{rupiah($sub_repackrph)}}</th>
                <th class="right">{{rupiah($sub_laininrph)}}</th>
                <th class="right">{{rupiah($sub_salesrph)}}</th>
                <th class="right">{{rupiah($sub_kirimrph)}}</th>
                <th class="right">{{rupiah($sub_prepackrph)}}</th>
                <th class="right">{{rupiah($sub_hilangrph)}}</th>
                <th class="right">{{rupiah($sub_lainoutrph)}}</th>
                <th class="right">{{rupiah($sub_selso_rph)}}</th>
                <th class="right">{{rupiah($sub_intrstrph)}}</th>
                <th class="right">{{rupiah($sub_adjrph)}}</th>
                <th class="right">{{rupiah($sub_sadj)}}</th>
                <th class="right">{{rupiah($sub_akhirrph)}}</th>
            </tr>
            @php
                $sub_sawalqty = 0;
                $sub_akhirqty = 0;
                $sub_sawalrph = 0;
                $sub_belirph = 0;
                $sub_bonusrph = 0;
                $sub_trmcbrph = 0;
                $sub_returrph = 0;
                $sub_repackrph = 0;
                $sub_laininrph = 0;
                $sub_salesrph = 0;
                $sub_kirimrph = 0;
                $sub_prepackrph = 0;
                $sub_hilangrph = 0;
                $sub_lainoutrph = 0;
                $sub_selso_rph = 0;
                $sub_intrstrph = 0;
                $sub_adjrph = 0;
                $sub_sadj = 0;
                $sub_akhirrph = 0;
            @endphp
            @endif
        @endfor
        <tr style="border-top: 1px solid black">
            <th class="left">TOTAL :</th>
            <th class="right">{{rupiah($total_item)}} ITEM</th>
        </tr>
        <tr>
            <th class="left">UNIT</th>
            <th class="right">{{rupiah($total_sawalqty)}}</th>
            <th colspan="16" class="left"></th>
            <th class="right">{{rupiah($total_akhirqty)}}</th>
        </tr>
        <tr>
            <th class="left">RPH</th>
            <th class="right">{{rupiah($total_sawalrph)}}</th>
            <th class="right">{{rupiah($total_belirph)}}</th>
            <th class="right">{{rupiah($total_bonusrph)}}</th>
            <th class="right">{{rupiah($total_trmcbrph)}}</th>
            <th class="right">{{rupiah($total_returrph)}}</th>
            <th class="right">{{rupiah($total_repackrph)}}</th>
            <th class="right">{{rupiah($total_laininrph)}}</th>
            <th class="right">{{rupiah($total_salesrph)}}</th>
            <th class="right">{{rupiah($total_kirimrph)}}</th>
            <th class="right">{{rupiah($total_prepackrph)}}</th>
            <th class="right">{{rupiah($total_hilangrph)}}</th>
            <th class="right">{{rupiah($total_lainoutrph)}}</th>
            <th class="right">{{rupiah($total_selso_rph)}}</th>
            <th class="right">{{rupiah($total_intrstrph)}}</th>
            <th class="right">{{rupiah($total_adjrph)}}</th>
            <th class="right">{{rupiah($total_sadj)}}</th>
            <th class="right">{{rupiah($total_akhirrph)}}</th>
        </tr>
        </tbody>
    </table>
<table>
    <tr>
        <td>Catatan :</td>
        <td>- Saldo akhir terdiri dari : SALDO GUDANG 'X' + BARANG SERVICE + SALDO TOKO</td>
    </tr>
    <tr>
        <td></td>
        <td>- BARANG SERVICE (Service Toko & Supplier) hanya untuk barang Elektronik.</td>
    </tr>
</table>
@endsection
