<table class="table">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="10%"
            align="left">TGL
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="5%"
            align="left">NO. NRB
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="10%"
            align="left">NO. DOK
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="10%"
            align="left">NO. NOTA RETUR
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="5%"
            align="right">ITEM
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="10%"
            align="left">MEMBER
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="5%"
            align="right">NILAI
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="5%"
            align="right">PPN
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="5%"
            align="right">PPN DIBEBASKAN
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="5%"
            align="right">PPN DTP
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="10%"
            align="left">NPWP
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" width="10%"
            align="left">NO. REFERENSI
        </th>
    </tr>
    </thead>
    <tbody>
    @php
        $total_nilai = 0;
        $total_ppn = 0;
        $tgl_temp = '';
    @endphp
    @foreach($data as $d)
        @if($tgl_temp != $d->tgldok)
            <tr>
                <td align="left">{{ date('d/m/Y',strtotime(substr($d->tgldok,0,10))) }}</td>
                <td align="left">{{ $d->rom_kodetoko.'-'.$d->rom_noreferensi }}</td>
                <td align="left">{{ $d->rom_nodokumen}}</td>
                <td align="left">{{ $d->cp_nonota }}</td>
                <td align="right">{{ $d->item }}</td>
                <td align="left">{{ $d->rom_member }}-{{ $d->cus_namamember }}</td>
                <td align="right">{{ number_format($d->harga,0) }}</td>
                {{-- <td align="right">{{ number_format($d->ppn,0) }}</td> --}}
                @if($d->prd_flagbkp1 == 'Y' )
                    @if($d->prd_flagbkp2 == 'Y')
                        <td align="right">{{ number_format($d->ppn,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                    @elseif($d->prd_flagbkp2 == 'P')
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format($d->ppn,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                    @elseif($d->prd_flagbkp2 == 'G' || $d->prd_flagbkp2 == 'W')
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format($d->ppn,2) }}</td>
                    @else
                        <td align="right">{{ number_format($d->ppn,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                    @endif
                @else
                    <td align="right">{{ number_format($d->ppn,2) }}</td>
                    <td align="right">{{ number_format(0,2) }}</td>
                    <td align="right">{{ number_format(0,2) }}</td>
                @endif

                <td align="left">{{ $d->cus_npwp }}</td>
                <td align="left">{{ $d->cp_reffp }}</td>
            </tr>
        @else
            <tr>
                <td align="left"></td>
                <td align="left">{{ $d->rom_kodetoko.'-'.$d->rom_noreferensi }}</td>
                <td align="left">{{ $d->rom_nodokumen}}</td>
                <td align="left">{{ $d->cp_nonota }}</td>
                <td align="right">{{ $d->item }}</td>
                <td align="left">{{ $d->rom_member }}-{{ $d->cus_namamember }}</td>
                <td align="right">{{ number_format($d->harga,0) }}</td>
                {{-- <td align="right">{{ number_format($d->ppn,0) }}</td> --}}

                @if($d->prd_flagbkp1 == 'Y' )
                    @if($d->prd_flagbkp2 == 'Y')
                        <td align="right">{{ number_format($d->ppn,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                    @elseif($d->prd_flagbkp2 == 'P')
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format($d->ppn,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                    @elseif($d->prd_flagbkp2 == 'G' || $d->prd_flagbkp2 == 'W')
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format($d->ppn,2) }}</td>
                    @else
                        <td align="right">{{ number_format($d->ppn,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                        <td align="right">{{ number_format(0,2) }}</td>
                    @endif
                @else
                    <td align="right">{{ number_format($d->ppn,2) }}</td>
                    <td align="right">{{ number_format(0,2) }}</td>
                    <td align="right">{{ number_format(0,2) }}</td>
                @endif

                <td align="left">{{ $d->cus_npwp }}</td>
                <td align="left">{{ $d->cp_reffp }}</td>
            </tr>
        @endif
        @php
            $tgl_temp = $d->tgldok;
            $total_nilai += $d->harga;
            $total_ppn += $d->ppn;
        @endphp
    @endforeach

    <tr>
        <td style="font-weight:bold" colspan="6" align="right">TOTAL</td>
        <td style="font-weight:bold" align="right">{{ number_format($total_nilai,0) }}</td>
        <td style="font-weight:bold" align="right">{{ number_format($total_ppn,0) }}</td>
        <td style="font-weight:bold" colspan="2"></td>
    </tr>
    </tbody>
</table>
