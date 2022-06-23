 @extends('html-template')

@section('table_font_size','9 px')

@section('page_title')
    LAPORAN TRANSAKSI PENUKARAN BARANG
@endsection

@section('title')
    LAPORAN TRANSAKSI PENUKARAN BARANG
@endsection

@section('subtitle')
Periode : {{ $tgl1 }} - {{ $tgl2 }}
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
            <tr>
                <th class="tengah" style="width: 5%" rowspan="3">No.</th>
                <th class="tengah" colspan="3" rowspan="1">Barang Yang Ditukar</th>
                <th class="tengah" colspan="3" rowspan="1">Barang Pengganti</th>
                <th class="tengah" rowspan="3" style="width: 20%">No. Struk<br>Penukaran<br>Barang</th>
                <th class="tengah" rowspan="3" style="width: 5%">User ID<br>(Otorisasi)</th>
                <th class="tengah" rowspan="3">Alasan Penukaran</th>
            </tr>
            <tr>
                <th class="tengah center" style="width: 5%">PLU</th>
                <th class="tengah center" style="width: 15%">Deskripsi</th>
                <th class="tengah center" style="width: 5%">Qty.</th>
                <th class="tengah center" style="width: 5%">PLU</th>
                <th class="tengah center" style="width: 15%">Deskripsi</th>
                <th class="tengah center" style="width: 5%">Qty.</th>
            </tr>
        </thead>

        <tbody>
            @php
                $index = 1;                
                $temp_no_sp_ditukar = '';
                $temp_no_sp_pengganti = '';
                $temp_no_spbd = '';
                $temp_userid = '';
                $temp_alasan_penukaran = '';
            @endphp           
            @foreach ($data as $d)
                @php
                    $plu_ditukar = $d->rom_prdcd;
                    $deskripsi_ditukar = $d->prd_deskripsipendek;
                    $qty_ditukar =  $d->rom_qty;                    
                    
                    if (isset($d->rom_nodokumen) && $d->rom_nodokumen != '') {
                        $no_sp_ditukar = 'SP' . date("Ymd", strtotime($d->rom_tgldokumen)) . $d->rom_kodekasir . $d->rom_station . $d->rom_nodokumen;                        
                    } else {
                        $no_sp_ditukar = '';                        
                    }

                    $plu_pengganti = $d->trjd_prdcd;
                    $deksripsi_pengganti = $d->trjd_prd_deskripsipendek;
                    $qty_pengganti = $d->trjd_quantity;

                    if (isset($d->trjd_transactionno) && $d->trjd_transactionno != '') {
                        $no_sp_pengganti = 'SP' . date("Ymd", strtotime($d->trjd_transactiondate)) . $d->trjd_create_by . $d->trjd_cashierstation . $d->trjd_transactionno;                        
                    } else {
                        $no_sp_pengganti = '';                        
                    }
                    
                    if (isset($d->jh_transactionno) && $d->jh_transactionno != '') {
                        $no_spbd = 'SPBD/' . substr($d->cab_singkatancabang, -3) . '/' . date("Ymd", strtotime($d->jh_transactiondate)) . $d->jh_cashierid . $d->jh_cashierstation . $d->jh_transactionno;
                    } else {
                        $no_spbd = '';
                    }

                    
                    $userid = $d->jh_create_by;
                    $alasan_penukaran = $d->vcrt_keterangan;                    
                @endphp
                @if ($temp_no_sp_ditukar != $no_sp_ditukar || $temp_no_sp_pengganti != $no_sp_pengganti)
                    @php
                        $temp_no_sp_ditukar = $no_sp_ditukar;
                        $temp_no_sp_pengganti = $no_sp_pengganti;
                        $i = 0;
                    @endphp
                    <tr>
                        <td>{{ $index }}</td>
                        <td class="left" colspan="3">
                            @if (isset($d->rom_nodokumen) && $d->rom_nodokumen != '')
                            <strong>
                                {{ $no_sp_ditukar }} - {{ date("d-m-Y", strtotime($d->rom_tgldokumen)) }}
                            </strong>
                            @endif
                        </td>
                        <td class="left" colspan="3">
                            @if (isset($d->trjd_transactionno) && $d->trjd_transactionno != '')
                            <strong>
                                {{ $no_sp_pengganti }} - {{ date("d-m-Y", strtotime($d->trjd_transactiondate)) }}
                            </strong>
                            @endif                            
                        </td>
                    </tr>
                    @php
                        $index++;
                    @endphp
                @endif
                @php                    
                    $i++;
                @endphp
                <tr>
                    <td></td>                    

                    <td>{{ $plu_ditukar }}</td>
                    <td style="width: 5%;">{{ $deskripsi_ditukar }}</td>
                    <td>{{ $qty_ditukar }}</td>

                    <td>{{ $plu_pengganti }}</td>
                    <td style="width: 5%;">{{ $deksripsi_pengganti }}</td>
                    <td>{{ $qty_pengganti }}</td>                   
                    <td>{{ $no_spbd }}</td>
                    <td>{{ $userid }}</td>
                    <td>{{ $alasan_penukaran }}</td>                    
                </tr>                
            @endforeach
        </tbody>
    </table>
@endsection
