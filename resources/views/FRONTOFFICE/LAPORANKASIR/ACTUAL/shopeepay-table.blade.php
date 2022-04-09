<style>
    .bold th{
        font-width: bold;
    }
</style>

<table class="table">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
        <th>{{ $perusahaan->prs_namaperusahaan }}</th>
        <th></th>
        <th></th>
        <th>Laporan Transaksi dengan ShopeePay</th>
        <th></th>
        <th></th>
        <th>Tgl. Cetak : {{ date("d/m/Y") }}</th>
    </tr>
    <tr class="bold">
        <th>{{ $perusahaan->prs_namacabang }}</th>
        <th></th>
        <th></th>
        <th>Tanggal : {{ $tanggal }}</th>
        <th></th>
        <th></th>
        <th><strong>Jam Cetak : {{ date('H:i:s') }}</strong></th>
    </tr>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><i>User ID</i> : {{ Session::get('usid') }}</th>
    </tr>
    <tr>
        <th rowspan="2" class="tengah right padding-right" width="5%">No</th>
        <th rowspan="2" class="tengah left" width="29%">Kassa</th>
        <th colspan="2" class="tengah right" width="22%">Penerimaan</th>
        <th colspan="2" class="tengah right" width="22%">Pengeluaran</th>
        <th rowspan="2" class="tengah right" width="22%">Penjualan</th>
    </tr>
    <tr>
        <th class="right">Nilai</th>
        <th class="right">Fee</th>
        <th class="right">Nilai</th>
        <th class="right">Fee</th>
    </tr>
    </thead>
    <tbody>
    @php
        $nilaiIn = 0;
        $feeIn = 0;
        $nilaiOut = 0;
        $feeOut = 0;
        $buy = 0;
        $no = 0;
    @endphp
    @foreach($data as $d)
        @php
            $no++;
            $nilaiIn += $d->nilai_in;
            $feeIn += $d->fee_in;
            $nilaiOut += $d->nilai_out;
            $feeOut += $d->fee_out;
            $buy += $d->nilai_buy;
        @endphp
        <tr>
            <td class="right padding-right">{{ $no }}</td>
            <td class="left">{{ $d->kassa }}</td>
            <td class="right">{{ number_format($d->nilai_in, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($d->fee_in, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($d->nilai_out, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($d->fee_out, 0, '.', ',') }}</td>
            <td class="right">{{ number_format($d->nilai_buy, 0, '.', ',') }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td class="left" colspan="2">TOTAL : </td>
        <td class="right">{{ number_format($nilaiIn, 0, '.', ',') }}</td>
        <td class="right">{{ number_format($feeIn, 0, '.', ',') }}</td>
        <td class="right">{{ number_format($nilaiOut, 0, '.', ',') }}</td>
        <td class="right">{{ number_format($feeOut, 0, '.', ',') }}</td>
        <td class="right">{{ number_format($buy, 0, '.', ',') }}</td>
    </tr>
    </tfoot>
</table>
