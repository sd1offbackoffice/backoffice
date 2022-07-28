
    <table class="table">
        <thead>
        <tr>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">TANGGAL</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">NO. BPB<th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">COST LAMA</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">COST BARU</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">SISA STOK</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">L.COST LAMA</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">L.COST BARU</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">TGL UPDATE</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">JAM UPDATE</th>
            <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">USER</th>
        </tr>
        </thead>
        <tbody>
        @php $plu = null; @endphp
        @foreach($data as $d)
            @if($plu != $d->hcs_prdcd)
                @php $plu = $d->hcs_prdcd; @endphp
                <tr>
                    <td colspan="10" align="left" style="font-weight: bold;">{{ $d->hcs_prdcd }} {{ $d->prd_deskripsipanjang }}</td>
                </tr>
            @endif
            <tr>
                <td >{{ $d->hcs_tglbpb }}</td>
                <td align="left ">{{ $d->hcs_nodocbpb }}<th>
                <td align="right">{{ number_format($d->hcs_avglama, 2) }}</td>
                <td align="right">{{ number_format($d->hcs_avgbaru, 2) }}</td>
                <td align="right">{{ number_format($d->hcs_lastqty, 2) }}</td>
                <td align="right">{{ number_format($d->hcs_lastcostlama, 2) }}</td>
                <td align="right">{{ number_format($d->hcs_lastcostbaru, 2) }}</td>
                <td >{{ $d->tgl_upd }}</td>
                <td >{{ $d->jam_upd }}</td>
                <td >{{ $d->usr }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>
