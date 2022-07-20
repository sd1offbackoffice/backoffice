{{--NOTE :
Perubahan kulakukan untuk menyamakan dengan hasil laporan sesuai dengan yang kulihat, ku tidak tahu kenapa kenapa harus ada kondisi ini, tapi hasil laporannya begitu, ya begimana lagi
1. data perdivisi hanya menampilkan data dimana "omisbu == 'I'", kalau ingin menampilkan semua hapus semua kondisi dimana "omisbu == 'I'", harusnya ada 3
2. {{$data[$i]->namasbu}} : {{$data[$i]->omidiv}} {{$namaomi}} tidak ditampilkan
3. di program baru diminta ditampilin semua, lol
--}}

@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN PERHITUNGAN PPN OUT SALES
@endsection

@section('title')
    LAPORAN PERHITUNGAN PPN OUT SALES
@endsection

@section('subtitle')
    {{$keterangan}}<br>{{$periode}}
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
    $tempDiv='';
    $tempDep=count($data) > 0 ? $data[0]->cdept : null;
    $sub_gross=0;
    $sub_potongan=0;
    $sub_dpp=0;
    $sub_ppn=0;
    $sub_ppn_dtp=0;
    $sub_ppn_bebas=0;
    $tot_gross=0;
    $tot_potongan=0;
    $tot_dpp=0;
    $tot_ppn=0;
    $tot_ppn_dtp=0;
    $tot_ppn_bebas=0;
    $tot_all_gross=0;
    $tot_all_potongan=0;
    $tot_all_dpp=0;
    $tot_all_ppn=0;
    $tot_all_ppn_dtp=0;
    $tot_all_ppn_bebas=0;

@endphp

@section('content')
    <table class="table table-bordered table-responsive" style="border-collapse: collapse;">
        <thead style="border-top: 2px solid black;border-bottom: 2px solid black;">
        <tr>
            <th rowspan="2" colspan="2" class="left tengah">DEPARTEMEN</th>
            <th rowspan="2" class="right tengah">PENJUALAN KOTOR</th>
            <th rowspan="2" class="right tengah">POTONGAN</th>
            <th colspan="2" class="center tengah">-------PENYERAHAN-------</th>
            <th rowspan="2" class="right tengah">BEBAS PPN</th>
            <th rowspan="2" class="right tengah">PPN DTP</th>

        </tr>
        <tr>
            <th class="right">DPP</th>
            <th class="right">PPN</th>
        </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: right">
        @for($i=0;$i<sizeof($data);$i++)
            @php
                $sub_gross+=$data[$i]->ngross;
                $sub_potongan+=$data[$i]->ncsb;
                $sub_dpp+=$data[$i]->nnet;

                if($data[$i]->prd_flagbkp1 == 'Y' ){
                    if($data[$i]->prd_flagbkp2 == 'Y'){
                        $sub_ppn+=$data[$i]->ntax;
                        $tot_ppn+=$data[$i]->ntax;
                        $tot_all_ppn+=$data[$i]->ntax;
                    }else if($data[$i]->prd_flagbkp2 == 'P'){
                        $sub_ppn_bebas+=$data[$i]->ntax;
                        $tot_ppn_bebas+=$data[$i]->ntax;
                        $tot_all_ppn_bebas+=$data[$i]->ntax;
                    }elseif($data[$i]->prd_flagbkp2 == 'G' || $data[$i]->prd_flagbkp2 == 'W'){
                        $sub_ppn_dtp+=$data[$i]->ntax;
                        $tot_ppn_dtp+=$data[$i]->ntax;
                        $tot_all_ppn_dtp+=$data[$i]->ntax;
                    }else{
                        $sub_ppn+=$data[$i]->ntax;
                        $tot_ppn+=$data[$i]->ntax;
                        $tot_all_ppn+=$data[$i]->ntax;
                    }
                }else{
                    $sub_ppn+=$data[$i]->ntax;
                    $tot_ppn+=$data[$i]->ntax;
                    $tot_all_ppn+=$data[$i]->ntax;
                }

                $tot_gross+=$data[$i]->ngross;
                $tot_potongan+=$data[$i]->ncsb;
                $tot_dpp+=$data[$i]->nnet;


                $tot_all_gross+=$data[$i]->ngross;
                $tot_all_potongan+=$data[$i]->ncsb;
                $tot_all_dpp+=$data[$i]->nnet;

            @endphp
            @if($tempDiv != $data[$i]->div_namadivisi)
                <tr>
                    <td colspan="6" style="width: 20px; text-align: left"><b
                            style="font-size: larger">{{$data[$i]->div_namadivisi}}</b> division
                    </td>
                </tr>
                @php
                    $tempDiv=$data[$i]->div_namadivisi;
                @endphp
            @endif
            @if(!isset($data[$i+1]->cdept) || ($tempDep != $data[$i+1]->cdept && isset($data[$i]->cdept)) )
                <tr>
                    <td class="left">{{$data[$i]->cdept}}</td>
                    <td class="left">{{$data[$i]->dep_namadepartement}}</td>
                    <td class="right">{{rupiah($sub_gross)}}</td>
                    <td class="right">{{rupiah($sub_potongan)}}</td>
                    <td class="right">{{rupiah($sub_dpp)}}</td>
                    <td class="right">{{rupiah($sub_ppn)}}</td>
                    <td class="right">{{rupiah($sub_ppn_bebas)}}</td>
                    <td class="right">{{rupiah($sub_ppn_dtp)}}</td>
                </tr>
                @php
                    $tempDep=isset($data[$i+1]->cdept)?$data[$i+1]->cdept:'';

                    $sub_gross=0;
                    $sub_potongan=0;
                    $sub_dpp=0;
                    $sub_ppn=0;
                    $sub_ppn_bebas=0;
                    $sub_ppn_dtp=0;
                @endphp
            @endif

            @if(!isset($data[$i+1]->div_namadivisi) || ($tempDiv != $data[$i+1]->div_namadivisi && isset($data[$i]->div_namadivisi)) )
                <tr style="border-bottom:1px solid black">
                    <th colspan="2" class="center"><b>TOTAL PER DIVISI :</b></th>
                    <th class="right">{{rupiah($tot_gross)}}</th>
                    <th class="right">{{rupiah($tot_potongan)}}</th>
                    <th class="right">{{rupiah($tot_dpp)}}</th>
                    <th class="right">{{rupiah($tot_ppn)}}</th>
                    <th class="right">{{rupiah($tot_ppn_bebas)}}</th>
                    <th class="right">{{rupiah($tot_ppn_dtp)}}</th>
                </tr>
                @php
                    $tot_gross = 0;
                    $tot_potongan = 0;
                    $tot_dpp = 0;
                    $tot_ppn = 0;
                    $tot_ppn_bebas=0;
                    $tot_ppn_dtp=0;
                @endphp
            @endif
        @endfor
        <tr>
            <td colspan="2" class="right"><b>TOTAL COUNTER :</b></td>
            <td class="right">{{rupiah($cp_ncgross)}}</td>
            <td class="right">{{rupiah($cp_nccsb)}}</td>
            <td class="right">{{rupiah($cp_ncnet)}}</td>
            <td class="right">{{rupiah($cp_nctax)}}</td>
            <td class="right">{{rupiah($cp_nc_bebasppn)}}</td>
            <td class="right">{{rupiah($cp_nc_ppndtp)}}</td>
        </tr>
        <tr>
            <td colspan="2" class="right"><b>TOTAL BARANG KENA PAJAK :</b></td>
            <td class="right">{{rupiah($cp_npgross)}}</td>
            <td class="right">{{rupiah($cp_npcsb)}}</td>
            <td class="right">{{rupiah($cp_npnet)}}</td>
            <td class="right">{{rupiah($cp_nptax)}}</td>
            <td class="right">{{rupiah($cp_np_bebasppn)}}</td>
            <td class="right">{{rupiah($cp_np_ppndtp)}}</td>
        </tr>
        <tr>
            <td colspan="2" class="right"><b>TOTAL BARANG TIDAK KENA PAJAK :</b></td>
            <td class="right">{{rupiah($cp_nxgross)}}</td>
            <td class="right">{{rupiah($cp_nxcsb)}}</td>
            <td class="right">{{rupiah($cp_nxnet)}}</td>
            <td class="right">{{rupiah($cp_nxtax)}}</td>
            <td class="right">{{rupiah($cp_nx_bebasppn)}}</td>
            <td class="right">{{rupiah($cp_nx_ppndtp)}}</td>
        </tr>
        <tr>
            <td colspan="2" class="right"><b>TOTAL BARANG KENA CUKAI :</b></td>
            <td class="right">{{rupiah($cp_nkgross)}}</td>
            <td class="right">{{rupiah($cp_nkcsb)}}</td>
            <td class="right">{{rupiah($cp_nknet)}}</td>
            <td class="right">{{rupiah($cp_nktax)}}</td>
            <td class="right">{{rupiah($cp_nk_bebasppn)}}</td>
            <td class="right">{{rupiah($cp_nk_ppndtp)}}</td>
        </tr>
        <tr>
            <td colspan="2" class="right"><b>TOTAL BARANG BEBAS PPN :</b></td>
            <td class="right">{{rupiah($cp_nbgross)}}</td>
            <td class="right">{{rupiah($cp_nbcsb)}}</td>
            <td class="right">{{rupiah($cp_nbnet)}}</td>
            <td class="right">{{rupiah($cp_nbtax)}}</td>
            <td class="right">{{rupiah($cp_nb_bebasppn)}}</td>
            <td class="right">{{rupiah($cp_nb_ppndtp)}}</td>
        </tr>
        <tr>
            <td colspan="2" class="right"><b>TOTAL BARANG EXPORT :</b></td>
            <td class="right">{{rupiah($cp_negross)}}</td>
            <td class="right">{{rupiah($cp_necsb)}}</td>
            <td class="right">{{rupiah($cp_nenet)}}</td>
            <td class="right">{{rupiah($cp_netax)}}</td>
            <td class="right">{{rupiah($cp_ne_bebasppn)}}</td>
            <td class="right">{{rupiah($cp_ne_ppndtp)}}</td>
        </tr>
        <tr>
            <td colspan="2" class="right"><b>TOTAL BARANG PPN DIBAYAR PEMERINTAH</b></td>
            <td class="right">{{rupiah($cp_nggross)}}</td>
            <td class="right">{{rupiah($cp_ngcsb)}}</td>
            <td class="right">{{rupiah($cp_ngnet)}}</td>
            <td class="right">{{rupiah($cp_ngtax)}}</td>
            <td class="right">{{rupiah($cp_ng_bebasppn)}}</td>
            <td class="right">{{rupiah($cp_ng_ppndtp)}}</td>
        </tr>
        {{-- <tr>
            <td colspan="2" class="right"><b>TOTAL BRG PPN DIBYR PMERINTH (TEPUNG) :</b></td>
            <td class="right">{{rupiah($cp_nrgross)}}</td>
            <td class="right">{{rupiah($cp_nrcsb)}}</td>
            <td class="right">{{rupiah($cp_nrnet)}}</td>
            <td class="right">{{rupiah($cp_nrtax)}}</td>
        </tr> --}}
        <tr>
            <td colspan="2" class="right"><b>TOTAL DEPARTEMEN 43 :</b></td>
            <td class="right">{{rupiah($cp_nfgross)}}</td>
            <td class="right">{{rupiah($cp_nfcsb)}}</td>
            <td class="right">{{rupiah($cp_nfnet)}}</td>
            <td class="right">{{rupiah($cp_nftax)}}</td>
            <td class="right">{{rupiah($cp_nf_bebasppn)}}</td>
            <td class="right">{{rupiah($cp_nf_ppndtp)}}</td>
        </tr>
        <tr>
            <td colspan="2" class="right"><b>GRAND TOTAL (TANPA DEPT 40) :</b></td>
            <td class="right">{{rupiah($tot_all_gross-$cp_ndgross)}}</td>
            <td class="right">{{rupiah($tot_all_potongan-$cp_ndcsb)}}</td>
            <td class="right">{{rupiah($tot_all_dpp-$cp_ndnet)}}</td>
            <td class="right">{{rupiah($tot_all_ppn-$cp_ndtax)}}</td>
            <td class="right">{{rupiah($tot_all_ppn_bebas-$cp_nd_bebasppn)}}</td>
            <td class="right">{{rupiah($tot_all_ppn_dtp-$cp_nd_ppndtp)}}</td>

            </tr>
        <tr>
            <td colspan="2" class="right"><b>GRAND TOTAL (+ DEPT 40) :</b></td>
            <td class="right">{{rupiah($tot_all_gross)}}</td>
            <td class="right">{{rupiah($tot_all_potongan)}}</td>
            <td class="right">{{rupiah($tot_all_dpp)}}</td>
            <td class="right">{{rupiah($tot_all_ppn)}}</td>
            <td class="right">{{rupiah($tot_all_ppn_bebas)}}</td>
            <td class="right">{{rupiah($tot_all_ppn_dtp)}}</td>
        </tr>
        </tbody>
    </table>

@endsection
