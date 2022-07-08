<table class="table">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">TGL</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">NO.
            NRB
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">NO.
            DOK
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;"
            align="right">NO. NOTA RETUR
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">ITEM</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">MEMBER
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">NILAI
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">PPN</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">PPN
            DIBEBASKAN
        </th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">PPN
            DTP
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
        @if($tgl_temp != $d->trpt_salesinvoicedate)
            <tr>
                <td align="left">{{ date('d/m/Y',strtotime(substr($d->trpt_salesinvoicedate,0,10))) }}</td>
                <td align="right">{{ $d->trpt_invoicetaxno }}</td>
                <td align="right">{{ $d->trpt_salesinvoiceno}}</td>
                <td align="left">{{ $d->tko_kodeomi }}</td>
                <td align="right">{{ $d->cf_item }}</td>
                <td align="left">{{ $d->member }}</td>
                <td align="right">{{ number_format($d->trpt_netsales,0) }}</td>
                <td align="right">{{ number_format($d->trpt_ppntaxvalue,0) }}</td>
                <td align="right">{{ number_format(0,2) }}</td>
                <td align="right">{{ number_format(0,2) }}</td>
            </tr>
        @else
            <tr>
                <td align="left"></td>
                <td align="right">{{ $d->trpt_invoicetaxno }}</td>
                <td align="right">{{ $d->trpt_salesinvoiceno}}</td>
                <td align="left">{{ $d->tko_kodeomi }}</td>
                <td align="right">{{ $d->cf_item }}</td>
                <td align="left">{{ $d->member }}</td>
                <td align="right">{{ number_format($d->trpt_netsales,0) }}</td>
                <td align="right">{{ number_format($d->trpt_ppntaxvalue,0) }}</td>
                <td align="right">{{ number_format(0,2) }}</td>
                <td align="right">{{ number_format(0,2) }}</td>
            </tr>
        @endif
        @php
            $tgl_temp = $d->trpt_salesinvoicedate;
            $total_nilai += $d->trpt_netsales;
            $total_ppn += $d->trpt_ppntaxvalue;
        @endphp
    @endforeach
    </tbody>
    <tfoot style="border-bottom: none">
    <tr>
        <th style="font-weight: bold" colspan="6" align="right">TOTAL</th>
        <th style="font-weight: bold" align="right">{{ number_format($total_nilai,0) }}</th>
        <th style="font-weight: bold" align="center">{{ number_format($total_ppn,0) }}</th>
    </tr>
    </tfoot>
</table>
