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
    $tempdep ='';

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
            <th class="center tengah">------PENERIMAAN------</th>
            <th class="center tengah">------PENGELUARAN------</th>
            <th colspan="8" class="center tengah"></th>
        </tr>
        <tr>
            <th colspan="4" class="center tengah">SALDO AWAL</th>
            <th class="center tengah">------PEMBELIAN------</th>
            <th class="center tengah">TRANSFER IN</th>
            <th class="center tengah">RETUR PENJUALAN</th>
            <th class="center tengah">REPACK IN (REPACK)</th>
            <th class="center tengah">LAIN-LAIN</th>
            <th class="center tengah">PENJUALAN</th>
            <th class="center tengah">TRANSFER OUT</th>
            <th class="center tengah">REPACK OUT (PREPACK)</th>
            <th class="center tengah">HILANG</th>
            <th class="center tengah">LAIN-LAIN</th>
            <th class="center tengah">SO</th>
            <th class="center tengah">INTRANSIT</th>
            <th class="center tengah">PENYESUAIAN</th>
            <th class="center tengah">KOREKSI</th>
            <th class="center tengah">SALDO AKHIR</th>
            <th class="center tengah">GDANG-X SRV. SUP</th>
            <th class="center tengah">SERV TOKO</th>
            <th class="center tengah">SALDO TOKO</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: right">
        @for($i=0;$i<sizeof($data);$i++)
            @if($tempdep != $data[$i]->lpp_kodedepartemen)
                <tr>
                    <td class="left">DEPARTEMEN :</td>
                    <td class="left">{{$data[$i]->lpp_kodedepartemen}}</td>
                    <td colspan="5" class="left">{{$data[$i]->dep_namadepartement}}</td>
                    <td class="left">KATEGORI :</td>
                    <td class="left">{{$data[$i]->lpp_kategoribrg}}</td>
                    <td colspan="10" class="left">{{$data[$i]->kat_namakategori}}</td>
                </tr>
                @php
                    $tempdep = $data[$i]->lpp_kodedepartemen;
                    $sub_item =0;

                @endphp
            @endif
            <tr>
                <td class="left">{{$data[$i]->lpp_prdcd}}</td>
                <td class="left">{{$data[$i]->prd_deskripsipanjang}}</td>
                <td class="left">{{$data[$i]->kemasan}}</td>
            </tr>
            <tr>
                <td class="left">UNIT :</td>
                <td class="left">{{rupiah($data[$i]->sawalqty)}}</td>
                <td class="left">{{rupiah($data[$i]->beliqty)}}</td>
                <td class="left">{{rupiah($data[$i]->bonusqty)}}</td>
                <td class="left">{{rupiah($data[$i]->trmcbqty)}}</td>
                <td class="left">{{rupiah($data[$i]->retursalesqty)}}</td>
                <td class="left">{{rupiah($data[$i]->repackqty)}}</td>
                <td class="left">{{rupiah($data[$i]->laininqty)}}</td>
                <td class="left">{{rupiah($data[$i]->salesqty)}}</td>
                <td class="left">{{rupiah($data[$i]->kirimqty)}}</td>
                <td class="left">{{rupiah($data[$i]->prepackqty)}}</td>
                <td class="left">{{rupiah($data[$i]->hilangqty)}}</td>
                <td class="left">{{rupiah($data[$i]->lainoutqty)}}</td>
                <td class="left">{{rupiah($data[$i]->sel_so)}}</td>
                <td class="left">{{rupiah($data[$i]->intrstqty)}}</td>
                <td class="left">{{rupiah($data[$i]->adjqty)}}</td>
                <td class="left">0</td>
                <td class="left">{{rupiah($data[$i]->akhirqty)}}</td>
                <td class="left">{{rupiah($data[$i]->servqsup)}}</td>
                <td class="left">{{rupiah($data[$i]->servqtok)}}</td>
                <td class="left">{{rupiah($data[$i]->saldotoko)}}</td>
            </tr>
            <tr>
                <td class="left">RPH :</td>
                <td class="left">{{rupiah($data[$i]->sawalrph)}}</td>
                <td class="left">{{rupiah($data[$i]->belirph)}}</td>
                <td class="left">{{rupiah($data[$i]->bonusrph)}}</td>
                <td class="left">{{rupiah($data[$i]->trmcbrph)}}</td>
                <td class="left">{{rupiah($data[$i]->retursalesrph)}}</td>
                <td class="left">{{rupiah($data[$i]->repackrph)}}</td>
                <td class="left">{{rupiah($data[$i]->laininrph)}}</td>
                <td class="left">{{rupiah($data[$i]->salesrph)}}</td>
                <td class="left">{{rupiah($data[$i]->kirimrph)}}</td>
                <td class="left">{{rupiah($data[$i]->prepackrph)}}</td>
                <td class="left">{{rupiah($data[$i]->hilangrph)}}</td>
                <td class="left">{{rupiah($data[$i]->lainoutrph)}}</td>
                <td class="left">{{rupiah($data[$i]->rph_sel_so)}}</td>
                <td class="left">{{rupiah($data[$i]->intrstrph)}}</td>
                <td class="left">{{rupiah($data[$i]->adjrph)}}</td>
                <td class="left">{{rupiah($data[$i]->sadj)}}</td>
                <td class="left">{{rupiah($data[$i]->akhirrph)}}</td>
            </tr>
            @php
                $sub_item ++;
                $sub_sawalqty = $data[$i]->sawalqty;
                $sub_akhirqty = $data[$i]->akhirqty;

                $sub_sawalrph = $data[$i]->sawalrph;
                $sub_belirph = $data[$i]->belirph;
                $sub_bonusrph = $data[$i]->bonusrph;
                $sub_trmcbrph = $data[$i]->trmcbrph;
                $sub_returrph = $data[$i]->retursalesrph;
                $sub_repackrph = $data[$i]->repackrph;
                $sub_laininrph = $data[$i]->laininrph;
                $sub_salesrph = $data[$i]->salesrph;
                $sub_kirimrph = $data[$i]->kirimrph;
                $sub_prepackrph = $data[$i]->prepackrph;
                $sub_hilangrph = $data[$i]->hilangrph;
                $sub_lainoutrph = $data[$i]->lainoutrph;
                $sub_selso_rph = $data[$i]->rph_sel_so;
                $sub_intrstrph = $data[$i]->intrstrph;
                $sub_adjrph = $data[$i]->adjrph;
                $sub_sadj = $data[$i]->sadj;
                $sub_akhirrph = $data[$i]->akhirrph;

                $total_item++;
                $total_sawalqty = $data[$i]->sawalqty;
                $total_akhirqty = $data[$i]->akhirqty;

                $total_sawalrph = $data[$i]->sawalrph;
                $total_belirph = $data[$i]->belirph;
                $total_bonusrph = $data[$i]->bonusrph;
                $total_trmcbrph = $data[$i]->trmcbrph;
                $total_returrph = $data[$i]->retursalesrph;
                $total_repackrph = $data[$i]->repackrph;
                $total_laininrph = $data[$i]->laininrph;
                $total_salesrph = $data[$i]->salesrph;
                $total_kirimrph = $data[$i]->kirimrph;
                $total_prepackrph = $data[$i]->prepackrph;
                $total_hilangrph = $data[$i]->hilangrph;
                $total_lainoutrph = $data[$i]->lainoutrph;
                $total_selso_rph = $data[$i]->rph_sel_so;
                $total_intrstrph = $data[$i]->intrstrph;
                $total_adjrph = $data[$i]->adjrph;
                $total_sadj = $data[$i]->sadj;
                $total_akhirrph = $data[$i]->akhirrph;
            @endphp
            @if( !isset($data[$i+1]->lpp_kodedepartemen) || (isset($data[$i+1]->lpp_kodedepartemen) && $tempdep != $data[$i+1]->lpp_kodedepartemen) )
            <tr>
                <td class="left">{{$sub_item}}</td>
                <td class="left">ITEM</td>
            </tr>
            <tr>
                <td class="left">UNIT</td>
                <td class="left">{{rupiah($sub_sawalqty)}}</td>
                <td colspan="16" class="left"></td>
                <td class="left">{{rupiah($sub_akhirqty)}}</td>
            </tr>
            <tr>
                <td class="left">RPH</td>
                <td class="left">{{rupiah($sub_sawalrph)}}</td>
                <td class="left">{{rupiah($sub_belirph)}}</td>
                <td class="left">{{rupiah($sub_bonusrph)}}</td>
                <td class="left">{{rupiah($sub_trmcbrph)}}</td>
                <td class="left">{{rupiah($sub_returrph)}}</td>
                <td class="left">{{rupiah($sub_repackrph)}}</td>
                <td class="left">{{rupiah($sub_laininrph)}}</td>
                <td class="left">{{rupiah($sub_salesrph)}}</td>
                <td class="left">{{rupiah($sub_kirimrph)}}</td>
                <td class="left">{{rupiah($sub_prepackrph)}}</td>
                <td class="left">{{rupiah($sub_hilangrph)}}</td>
                <td class="left">{{rupiah($sub_lainoutrph)}}</td>
                <td class="left">{{rupiah($sub_selso_rph)}}</td>
                <td class="left">{{rupiah($sub_intrstrph)}}</td>
                <td class="left">{{rupiah($sub_adjrph)}}</td>
                <td class="left">{{rupiah($sub_sadj)}}</td>
                <td class="left">{{rupiah($sub_akhirrph)}}</td>
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
        <tr>
            <td class="left">TOTAL :</td>
            <td class="left">{{rupiah($total_item)}}</td>
            <td class="left">ITEM</td>
        </tr>
        <tr>
            <td class="left">UNIT</td>
            <td class="left">{{rupiah($total_sawalqty)}}</td>
            <td colspan="16" class="left"></td>
            <td class="left">{{rupiah($total_akhirqty)}}</td>
        </tr>
        <tr>
            <td class="left">RPH</td>
            <td class="left">{{rupiah($total_sawalrph)}}</td>
            <td class="left">{{rupiah($total_belirph)}}</td>
            <td class="left">{{rupiah($total_bonusrph)}}</td>
            <td class="left">{{rupiah($total_trmcbrph)}}</td>
            <td class="left">{{rupiah($total_returrph)}}</td>
            <td class="left">{{rupiah($total_repackrph)}}</td>
            <td class="left">{{rupiah($total_laininrph)}}</td>
            <td class="left">{{rupiah($total_salesrph)}}</td>
            <td class="left">{{rupiah($total_kirimrph)}}</td>
            <td class="left">{{rupiah($total_prepackrph)}}</td>
            <td class="left">{{rupiah($total_hilangrph)}}</td>
            <td class="left">{{rupiah($total_lainoutrph)}}</td>
            <td class="left">{{rupiah($total_selso_rph)}}</td>
            <td class="left">{{rupiah($total_intrstrph)}}</td>
            <td class="left">{{rupiah($total_adjrph)}}</td>
            <td class="left">{{rupiah($total_sadj)}}</td>
            <td class="left">{{rupiah($total_akhirrph)}}</td>
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
