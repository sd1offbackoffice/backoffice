<table class="table">
    <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
    <tr>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">NO</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">MEMBER</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">TOKO</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">TANGGAL</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">NO. NRB</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">NO. DOKUMEN</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">ITEM</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">NILAI</th>
        <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">PPN</th>
    </tr>
    </thead>
    <tbody>
    @php
        $no = 1;
        $total_harga = 0;
        $total_ppn = 0;
        $sub_harga = 0;
        $sub_ppn = 0;
        $member_temp = '';
    @endphp
    @for($i=0;$i<sizeof($data);$i++)
        @if($member_temp != $data[$i]->member)
            <tr>
                <td align="right">{{ $no }}</td>
                <td align="left">{{ $data[$i]->member }}</td>
                <td align="left">{{ $data[$i]->tko_kodeomi }}</td>
                <td align="left">{{ substr($data[$i]->trpt_salesinvoicedate,0,10)}}</td>
                <td align="left">{{ $data[$i]->trpt_invoicetaxno }}</td>
                <td align="left">{{ $data[$i]->trpt_salesinvoiceno }}</td>
                <td align="right">{{ $data[$i]->cf_item }}</td>
                <td align="right">{{ number_format($data[$i]->trpt_netsales,0) }}</td>
                <td align="right">{{ number_format($data[$i]->trpt_ppntaxvalue,0) }}</td>
            </tr>
            @php
                $no++;
            @endphp
        @else
            <tr>
                <td align="left"></td>
                <td align="left"></td>
                <td align="left">{{ $data[$i]->tko_kodeomi }}</td>
                <td align="left">{{ date('d/m/Y',strtotime(substr($data[$i]->trpt_salesinvoicedate,0,10))) }}</td>
                <td align="left">{{ $data[$i]->trpt_invoicetaxno }}</td>
                <td align="left">{{ $data[$i]->trpt_salesinvoiceno }}</td>
                <td align="right">{{ $data[$i]->cf_item }}</td>
                <td align="right">{{ number_format($data[$i]->trpt_netsales,0) }}</td>
                <td align="right">{{ number_format($data[$i]->trpt_ppntaxvalue,0) }}</td>
            </tr>
        @endif
        @php
            $no++;
            $sub_harga += $data[$i]->trpt_netsales;
            $sub_ppn += $data[$i]->trpt_ppntaxvalue;
            $member_temp = $data[$i]->member;
            $total_harga += $data[$i]->trpt_netsales;
            $total_ppn += $data[$i]->trpt_ppntaxvalue;
        @endphp
        @if( isset($data[$i+1]->member) && $member_temp != $data[$i+1]->member || !(isset($data[$i+1]->member)) )
            <tr>
                <td style="font-weight: bold;border-top: 1px solid black;" colspan="7" align="right"><b> SUB TOTAL :</b></td>
                <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format($sub_harga,0) }}</td>
                <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format($sub_ppn,0) }}</td>
            </tr>
            @php
                $sub_harga =0;
                $sub_ppn =0;
            @endphp
        @endif

    @endfor

    </tbody>
    <tfoot style="border-bottom: none">
    <tr>
        <td style="font-weight: bold;border-top: 1px solid black;" colspan="7" align="right"><b>TOTAL</b></td>
        <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format($total_harga,0) }}</td>
        <td style="font-weight: bold;border-top: 1px solid black;" align="right">{{ number_format($total_ppn,0) }}</td>
    </tr>
    </tfoot>
</table>

