@extends('virtual-stock-cmo-pdf-template')

@section('table_font_size','7 px')

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

@section('content')
    <!-- Rekap -->
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
           <th rowspan="2" style="width:15px;border-right: 1px solid black">No.</th>
           <th colspan="1" style="width:20px;border-top: 1px solid black; border-right: 1px solid black;">plu IDM</th>
           <th colspan="1" style="width:20px;border-top: 1px solid black; border-right: 1px solid black;">plu IGR</th>
           <th rowspan="2" style="width:20px; border-right: 1px solid black; border-left: 1px solid black">saldo awal</th>
           <th colspan="4" style="width:150px; border-right: 1px solid black">PENERIMAAN</th>
           <th colspan="3" style="width:150px; border-right: 1px solid black">PENGELUARAN</th>
           <th rowspan="2" style="width:25px;border: 1px solid black;">Saldo Akhir</th>
        </tr>
        <tr style="text-align: center; vertical-align: center">
            <th colspan="2" style="width: 30px; border-right: 1px solid black; border-top: 1px solid black;">Deskripsi</th>
            <th style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">BPB</th>
            <th style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">BPBR</th>
            <th style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">MPP (+)</th>
            <th style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">ADJ (+)</th>
            <th style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">DSPB</th>
            <th style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">MPP (-)</th>
            <th style="border-top: 1px solid black; border-right: 1px solid black; width: 25px; text-align: center">ADJ (-)</th>
        </tr>
        </thead>
        <tbody>

        @for($i=0; $i<sizeof($data) ;$i++)
                <tr>
                    <td rowspan="2" style="text-align: center;">{{$i+1}}</td>
                    <td colspan="1" style="text-align: left;">{{ $data[$i]->prc_pluidm }}</td>
                    <td colspan="1" style="text-align: left;">{{ $data[$i]->pluigr }}</td>
                    <td colspan="1" style="text-align: left;">{{ $data[$i]->sta_saldoawal }}</td>
                    <td colspan="1">{{ $data[$i]->bpb_qty }}</td>
                    <td colspan="1">{{ $data[$i]->idm_qty }}</td>
                    <td colspan="1">{{ $data[$i]->mpp_qty }}</td>
                    <td colspan="1">{{ $data[$i]->intp_qty }}</td>
                    <td colspan="1">{{ $data[$i]->dspb_qty }}</td>
                    <td colspan="1">{{ $data[$i]->mpn_qty }}</td>
                    <td colspan="1">{{ $data[$i]->intn_qty }}</td>
                    <td colspan="1">{{ $data[$i]->sta_saldoakhir }}</td>
                </tr>
            <tr>
                <td colspan="3" style="text-align: left;" >{{ $data[$i]->prd_deskripsipanjang }}</td>
            </tr>

        @endfor
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <!-- Detail -->
    @elseif($tipevcmo == 'r2')
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
               {{-- <td style="border: 1px solid black">{{ $div1 }} s/d {{ $div2 }}</td>
               <td style="border: 1px solid black">{{ $dept1 }} s/d {{ $dept2 }}</td>
               <td style="border: 1px solid black">{{ $kat1 }} s/d {{ $kat2 }}</td>
               <td style="border: 1px solid black"> {{ $kodesupplier }}</td>
               <td style="border: 1px solid black">{{ $namasupplier }}</td>
               <td style="border: 1px solid black">{{ $periode1 }} s/d {{ $periode2 }}</td> --}}
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
           <th rowspan="3" style="width:50px;border-right: 1px solid black;text-align: center;
vertical-align: middle;">No.</th>
           <th colspan="1" style="width:20px;border-top: 1px solid black; border-right: 1px solid black; text-align: center">plu IDM</th>
           <th colspan="1" style="width:20px;border-top: 1px solid black; border-right: 1px solid black;text-align: center">plu IGR</th>
           <th rowspan="3" style="width: 20px; border-right: 1px solid black; border-left: 1px solid black;text-align: center;
vertical-align: middle;">saldo awal</th>
           <th colspan="16" style="width:150px; border-right: 1px solid black">PENERIMAAN</th>
           <th colspan="10" style="width:150px; border-right: 1px solid black">PENGELUARAN</th>
           <th rowspan="3" style="width:25px;border: 1px solid black;">Saldo Akhir</th>
        </tr>
        <tr style="text-align: center; vertical-align: center">
            <th colspan="2" rowspan="2" style="width: 30px; border-right: 1px solid black; border-top: 1px solid black;text-align: center;
vertical-align: middle;">Deskripsi</th>
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

        @for($i=0; $i<sizeof($data) ;$i++)
                <tr style="text-align: right; vertical-align: right">
                    <td rowspan="2">{{$i+1}}</td>

                    <td colspan="1">{{ $data[$i]->prc_pluidm }}</td>
                    <td colspan="1">{{ $data[$i]->pluigr }}</td>

                    <td colspan="1">{{ $data[$i]->awal }}</td>
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
            <tr style="text-align: center; vertical-align: center">
                <td colspan="3" >{{ $data[$i]->prd_deskripsipanjang }}</td>
            </tr>

        @endfor
        </tbody>
        <tfoot>
        </tfoot>
    </table>

    @endif
@endsection
