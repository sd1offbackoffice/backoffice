{{-- @extends('virtual-stock-cmo-pdf-template') --}}
@extends('html-template')

@section('table_font_size','7px')

@section('page_title')
    @if($tipevcmo == 'r1')
    STOCK VIRTUAL COMMIT ORDER - REKAP
    @elseif($tipevcmo == 'r2')
    STOCK VIRTUAL COMMIT ORDER - DETAIL
    @endif
@endsection

@section('title')
    @if($tipevcmo == 'r1')
    STOCK VIRTUAL COMMIT ORDER - REKAP
    @elseif($tipevcmo == 'r2')
    STOCK VIRTUAL COMMIT ORDER - DETAIL
    @endif
@endsection

@if($tipevcmo == 'r1')
    @section('paper_height','595pt')
@section('paper_width','842pt')
@else
    @section('paper_height','595pt')
@section('paper_width','1200pt')
    @endif

@section('subtitle')

@endsection

@section('content')
    @if($tipevcmo == 'r1')
        <table class="table table-bordered table-responsive">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;">
                <tr style="text-align: center; vertical-align: center">
                    <th style="border: 1px solid black">Divisi</th>
                    <th style="border: 1px solid black">Departement</th>
                    <th style="border-right: 1px solid black">Kategori</th>
                    <th style="border: 1px solid black">Kode Supplier</th>
                    <th style="border: 1px solid black"> Nama Supplier</th>
                    <th style="border-right: 1px solid black">Tanggal</th>
                </tr>
            </thead>
            <tbody style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;">
                <tr style="text-align: center; vertical-align: center">
                    @if($div1 == NULL && $div2 == NULL)
                        <td style="border: 1px solid black">ALL</td>
                    @else
                        <td style="border: 1px solid black">{{ $div1 }} s/d {{ $div2 }}</td>
                    @endif
                    @if($dept1 == NULL && $dept2 == NULL)
                        <td style="border: 1px solid black">ALL</td>
                    @else
                        <td style="border: 1px solid black">{{ $dept1 }} s/d {{ $dept2 }}</td>
                    @endif
                    @if($kat1 == NULL && $kat2 == NULL)
                        <td style="border: 1px solid black">ALL</td>
                    @else
                        <td style="border: 1px solid black">{{ $kat1 }} s/d {{ $kat2 }}</td>
                    @endif
                    @if($kodesupplier == NULL)
                        <td style="border: 1px solid black"> ALL</td>
                    @else
                        <td style="border: 1px solid black"> {{ $kodesupplier }}</td>
                    @endif
                    @if($namasupplier == NULL)
                        <td style="border: 1px solid black"> ALL</td>
                    @else
                        <td style="border: 1px solid black"> {{ $namasupplier }}</td>
                    @endif
                    <td style="border: 1px solid black">{{ $periode1 }} s/d {{ $periode2 }}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table table-bordered table-responsive" style="border-collapse: collapse">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th rowspan="2" style="width:15px;border: 1px solid black">No.</th>
                <th colspan="1" style="width:20px;border: 1px solid black;">plu IDM</th>
                <th colspan="1" style="width:20px;border: 1px solid black;">plu IGR</th>
                <th rowspan="2" style="width:20px;border: 1px solid black;">saldo awal</th>
                <th colspan="4" style="width:100px; border: 1px solid black">PENERIMAAN</th>
                <th colspan="3" style="width:150px; border: 1px solid black">PENGELUARAN</th>
                <th rowspan="2" style="width:25px;border: 1px solid black;">Saldo Akhir</th>
            </tr>
            <tr style="text-align: center; vertical-align: center">
                <th colspan="2" style="width: 40px; border-right: 1px solid black; border-top: 1px solid black;">Deskripsi</th>
                <th style="border:1px solid black; width: 25px; text-align: center">BPB</th>
                <th style="border:1px solid black; width: 25px; text-align: center">BPBR</th>
                <th style="border:1px solid black; width: 25px; text-align: center">MPP (+)</th>
                <th style="border:1px solid black; width: 25px; text-align: center">ADJ (+)</th>
                <th style="border:1px solid black; width: 50px; text-align: center">DSPB</th>
                <th style="border:1px solid black; width: 50px; text-align: center">MPP (-)</th>
                <th style="border:1px solid black; width: 50px; text-align: center">ADJ (-)</th>
            </tr>
            </thead>
            <tbody>
                {{-- @for($i=0; $i<100 ;$i++) --}}
                @for($i=0; $i<sizeof($data) ;$i++)
                    <tr>
                        <td style="text-align: center;">{{$i+1}}</td>
                        <td style="text-align: left;">{{ $data[$i]->prc_pluidm }}</td>
                        <td style="text-align: left;">{{ $data[$i]->pluigr }}</td>
                        <td style="text-align: left;">{{ $data[$i]->sta_saldoawal }}</td>
                        <td>{{ $data[$i]->bpb_qty }}</td>
                        <td>{{ $data[$i]->idm_qty }}</td>
                        <td>{{ $data[$i]->mpp_qty }}</td>
                        <td>{{ $data[$i]->intp_qty }}</td>
                        <td>{{ $data[$i]->dspb_qty }}</td>
                        <td>{{ $data[$i]->mpn_qty }}</td>
                        <td>{{ $data[$i]->intn_qty }}</td>
                        <td>{{ $data[$i]->sta_saldoakhir }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align: center;">{{ $data[$i]->prd_deskripsipanjang }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        {{-- <th colspan="9"></th> --}}
                    </tr>


                @endfor
            </tbody>
        </table>
    @elseif($tipevcmo == 'r2')

        <table class="table table-bordered table-responsive" style="justify-content: center">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;">
                <tr style="text-align: center; vertical-align: center">
                    <th style="border: 1px solid black">Divisi</th>
                    <th style="border: 1px solid black">Departement</th>
                    <th style="border-right: 1px solid black">Kategori</th>
                    <th style="border: 1px solid black">Kode Supplier</th>
                    <th style="border: 1px solid black"> Nama Supplier</th>
                    <th style="border-right: 1px solid black">Tanggal</th>
                </tr>
            </thead>
            <tbody style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;">
                <tr style="text-align: center; vertical-align: center">
                    @if($div1 == NULL && $div2 == NULL)
                        <td style="border: 1px solid black">ALL</td>
                    @else
                        <td style="border: 1px solid black">{{ $div1 }} s/d {{ $div2 }}</td>
                    @endif
                    @if($dept1 == NULL && $dept2 == NULL)
                        <td style="border: 1px solid black">ALL</td>
                    @else
                        <td style="border: 1px solid black">{{ $dept1 }} s/d {{ $dept2 }}</td>
                    @endif
                    @if($kat1 == NULL && $kat2 == NULL)
                        <td style="border: 1px solid black">ALL</td>
                    @else
                        <td style="border: 1px solid black">{{ $kat1 }} s/d {{ $kat2 }}</td>
                    @endif
                    @if($kodesupplier == NULL)
                        <td style="border: 1px solid black"> ALL</td>
                    @else
                        <td style="border: 1px solid black"> {{ $kodesupplier }}</td>
                    @endif
                    @if($namasupplier == NULL)
                        <td style="border: 1px solid black"> ALL</td>
                    @else
                        <td style="border: 1px solid black"> {{ $namasupplier }}</td>
                    @endif
                    <td style="border: 1px solid black">{{ $periode1 }} s/d {{ $periode2 }}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table table-bordered table-responsive" style="border-collapse: collapse">
            <thead style="border-top: 1px solid black;border-bottom: 1px solid black;border-left: 1px solid black;">
            <tr>
            <th rowspan="3"  style="width:50px;border: 1px solid black;text-align: center;vertical-align: middle;">No.</th>
            <th colspan="1"  style="width:20px;border: 1px solid black; text-align: center">plu IDM</th>
            <th colspan="1"  style="width:20px;border: 1px solid black;text-align: center">plu IGR</th>
            <th rowspan="3"  style="width: 20px;border: 1px solid black;text-align: center;vertical-align: middle;">saldo awal</th>
            <th colspan="16" style="width:150px;border: 1px solid black">PENERIMAAN</th>
            <th colspan="10" style="width:150px;border: 1px solid black">PENGELUARAN</th>
            <th rowspan="3"  style="width:25px;border: 1px solid black;">Saldo Akhir</th>
            </tr>
            <tr style="text-align: center; vertical-align: center">
                <th colspan="2" rowspan="2" style="width: 30px; border-right: 1px solid black; border-top: 1px solid black;text-align: center;vertical-align: middle;">Deskripsi</th>
                <th colspan="5" style="width:30px;border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">Supplier</th>
                <th colspan="5" style="width:30px;border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">Toko IDM</th>
                <th colspan="3" style="width:30px;border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">MPP (+)</th>
                <th colspan="3" style="width:30px;border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">ADJ (+)</th>
                <th colspan="4" style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">TOKO IDM</th>
                <th colspan="3" style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">MPP (-)</th>
                <th colspan="3" style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">ADJ (-)</th>
            </tr>
            <tr style="text-align: center; vertical-align: center">
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Kode - Nama</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">No. PO</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Tgl BPB</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">No. BPB</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Qty</th>

                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Kode - Nama</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Tgl BPBR</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">No. BPBR</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">No NRB</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Qty</th>

                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Tgl MPP</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">No MPP</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Qty</th>

                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Tgl ADJ</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">No BA</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Qty</th>

                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Kode - Nama</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Tgl DSPB</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">No DSPB</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Qty</th>

                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Tgl MPP</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">No MPP</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Qty</th>

                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Tgl ADJ</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">No BA</th>
                <th colspan="1" style="width: 25px; border-right: 1px solid black; border-top: 1px solid black;">Qty</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $number = 0;
                ?>
                @for($i=0; $i<sizeof($data) ;$i++)
                {{-- @for($i=0; $i<100 ;$i++) --}}

                    <?php
                        $temp_pluidm = '';
                        $temp_pluigr = '';
                        $temp_deskripsi = '';
                    ?>

                    <tr style="text-align: right; vertical-align: right">
                        @if($temp_deskripsi != $data[$i]->prd_deskripsipanjang)
                            <td rowspan="2">{{$number+1}}</td>
                            <td colspan="1" style="text-align: center;">{{ $data[$i]->prc_pluidm }}</td>
                            <td colspan="1" style="text-align: center;">{{ $data[$i]->pluigr }}</td>
                        {{-- Kalo deskripsi panjang selanjutnya tidak sama dengan yang di temp maka print,
                        setelah print maka ganti isi dari variable temp dengan index selanjutnya --}}
                        <?php
                            $number++;
                            $temp_pluidm = $data[$i]->prc_pluidm;
                            $temp_deskripsi = $data[$i]->pluigr;
                        ?>
                        @endif

                        @if($data[$i]->awal != 0)
                            <td colspan="1">{{ $data[$i]->awal }}</td>
                        @else
                            <td colspan="1">-</td>
                        @endif

                        <!-- Supplier -->
                        <td colspan="1">{{ $data[$i]->sup_namasupplier }}</td>
                        <td colspan="1">{{ $data[$i]->bpb_nopo }}</td>
                        <td colspan="1">{{ $data[$i]->bpb_tanggal }}</td>
                        <td colspan="1">{{ $data[$i]->bpb_no }}</td>
                        <td colspan="1">{{ $data[$i]->bpb_qty }}</td>
                        <!-- Toko IDM -->
                        <td colspan="1">{{ $data[$i]->namaidm }}</td>
                        <td colspan="1">{{ $data[$i]->idm_tanggal }}</td>
                        <td colspan="1">{{ $data[$i]->idm_no }}</td>
                        <td colspan="1">{{ $data[$i]->idm_nrb }}</td>
                        <td colspan="1">{{ $data[$i]->idm_qty }}</td>
                        <!-- MPP(+) -->
                        <td colspan="1">{{ $data[$i]->mpp_tanggal }}</td>
                        <td colspan="1">{{ $data[$i]->mpp_no }}</td>
                        <td colspan="1">{{ $data[$i]->mpp_qty }}</td>
                        <!-- ADJ (+) -->
                        <td colspan="1">{{ $data[$i]->intp_tanggal }}</td>
                        <td colspan="1">{{ $data[$i]->intp_no }}</td>
                        <td colspan="1">{{ $data[$i]->intp_qty }}</td>
                        <!-- Toko IDM -->
                        <td colspan="1">{{ $data[$i]->namadspb }}</td>
                        <td colspan="1">{{ $data[$i]->dspb_tanggal }}</td>
                        <td colspan="1">{{ $data[$i]->dspb_no }}</td>
                        <td colspan="1">{{ $data[$i]->dspb_qty }}</td>
                        <!-- MPP (-) -->
                        <td colspan="1">{{ $data[$i]->mpn_tanggal }}</td>
                        <td colspan="1">{{ $data[$i]->mpn_no }}</td>
                        <td colspan="1">{{ $data[$i]->mpn_qty }}</td>
                        <!-- ADJ (-) -->
                        <td colspan="1">{{ $data[$i]->intn_tanggal }}</td>
                        <td colspan="1">{{ $data[$i]->intn_no }}</td>
                        <td colspan="1">{{ $data[$i]->intn_qty }}</td>
                        <!-- Saldo Akhir -->
                        <td colspan="1">{{ $data[$i]->akhir }}</td>
                    </tr>

                    @if($temp_deskripsi != $data[$i]->prd_deskripsipanjang)
                        <tr style="text-align: center">
                            <td colspan="2">{{ $data[$i]->prd_deskripsipanjang }}</td>
                        </tr>
                        <?php
                            $temp_deskripsi = $data[$i]->prd_deskripsipanjang;
                        ?>
                    @endif

                    @php
                        $temp_saldo_awal_penerimaan = $data[$i]->awal;
                        $temp_qty_supplier_penerimaan = $data[$i]->bpb_qty;
                        $temp_qty_toko_idm_penerimaan = $data[$i]->idm_qty;
                        $temp_mpp_plus_penerimaan = $data[$i]->mpp_qty;
                        $temp_adj_plus_penerimaan = $data[$i]->intp_qty;
                        $temp_qty_toko_idm_pengeluaran = $data[$i]->dspb_qty;
                        $temp_mpp_minus_pengeluaran = $data[$i]->mpn_qty;
                        $temp_adj_minus_pengeluaran = $data[$i]->intn_qty;
                        $temp_saldo_akhir_pengeluaran = $data[$i]->akhir;
                    @endphp

                    <tr>
                        <th colspan="31" style="text-align: right"><hr></th>
                    </tr>
                    <tr>
                        <th colspan="3" style="text-align: right">TOTAL</th>
                        {{-- <th colspan="5" style="text-align: right">{{ $temp_saldo_awal_penerimaan }}</th>
                        <th colspan="5" style="text-align: right">{{ $temp_qty_supplier_penerimaan }}</th>
                        <th colspan="3" style="text-align: right">{{ $temp_qty_toko_idm_penerimaan }}</th>
                        <th colspan="3" style="text-align: right">{{ $temp_mpp_plus_penerimaan }}</th>
                        <th colspan="4" style="text-align: right">{{ $temp_adj_plus_penerimaan }}</th>
                        <th colspan="3" style="text-align: right">{{ $temp_qty_toko_idm_pengeluaran }}</th>
                        <th colspan="3" style="text-align: right">{{ $temp_mpp_minus_pengeluaran }}</th>
                        <th colspan="1" style="text-align: center">{{ $temp_adj_minus_pengeluaran }}</th>
                        <th colspan="1" style="text-align: center">{{ $temp_saldo_akhir_pengeluaran }}</th> --}}

                        <td colspan="1" style="text-align: right">{{ $temp_saldo_awal_penerimaan }}</td>
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1" style="text-align: right">{{ $temp_qty_supplier_penerimaan }}</td>
                        <!-- Toko IDM -->
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1" style="text-align: right">{{ $temp_qty_toko_idm_penerimaan }}</td>
                        <!-- MPP(+) -->
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1" style="text-align: right">{{ $temp_mpp_plus_penerimaan }}</td>
                        <!-- ADJ (+) -->
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1" style="text-align: right">{{ $temp_adj_plus_penerimaan }}</td>
                        <!-- Toko IDM -->
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1" style="text-align: right">{{ $temp_qty_toko_idm_pengeluaran }}</td>
                        <!-- MPP (-) -->
                        <td colspan="1"></td>
                        <td colspan="1" ></td>
                        <td colspan="1" style="text-align: right">{{ $temp_mpp_minus_pengeluaran }}</td>
                        <!-- ADJ (-) -->
                        <td colspan="1"></td>
                        <td colspan="1"></td>
                        <td colspan="1" style="text-align: right">{{ $temp_adj_minus_pengeluaran }}</td>
                        <!-- Saldo Akhir -->
                        <td colspan="1" style="text-align: right">{{ $temp_saldo_akhir_pengeluaran }}</td>
                    </tr>

                    <tr>
                        <th colspan="31" style="text-align:center"><hr></th>
                    </tr>
                @endfor
            </tbody>
        </table>
    @endif
@endsection
