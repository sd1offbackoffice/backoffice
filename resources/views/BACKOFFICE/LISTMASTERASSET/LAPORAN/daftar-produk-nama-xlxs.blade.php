@php
    function zeroDigit($angka){
        $digit = number_format($angka,0,'.',',');
        return $digit;
    }
    function oneDigit($angka){
        $digit = number_format($angka,1,'.',',');
        return $digit;
    }
    $produkHolder   = '';
    $produk         = 0;
    $satuan         = 0;
@endphp
    <table class="table">
        <thead>
            <tr>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">KODE</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">NAMA BARANG</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;">SATUAN</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">MIN<br>JUAL</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">HPP AKHIR</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">HPP RATA2</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">HRG JUAL</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">MARGIN</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">TGL AKTIF</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">TAG</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">RCV</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">SUPPLIER</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">TOP</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">MINOR</th>
                <th style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">PKM</th>
            </tr>
        </thead>
        <tbody>
        @for($i=0;$i<sizeof($data);$i++)
            <tr>
                <td style="text-align: left">{{$data[$i]->prd}}</td>
                <td style="text-align: left">{{$data[$i]->desc2}}</td>
                <td>{{$data[$i]->satuan}}</td>
                <td>{{$data[$i]->minjl}}</td>
                @if($p_hpp == '1')
                    <td style="text-align: right">{{oneDigit($data[$i]->prd_lastcost)}}</td>
                    <td style="text-align: right">{{oneDigit($data[$i]->prd_avgcost)}}</td>
                @else
                    <td style="text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td style="text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td style="text-align: right">{{oneDigit($data[$i]->prd_hrgjual)}}</td>
                @if($cf_nmargin[$i] != -100)
                    <td style="text-align: right">{{$cf_nmargin[$i]}}%</td>
                @else
                    <td style="text-align: right">%</td>
                @endif
                <?php
                $date = new DateTime($data[$i]->prd_tglaktif);
                $strip = $date->format('d-m-Y');
                ?>
                <td>{{$strip}}</td>
                <td>{{$data[$i]->prd_kodetag}}</td>
                @if($data[$i]->st_prdcd != null)
                    <td>Y</td>
                @else
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif

                <td>{{$data[$i]->supplier}}</td>
                @if($data[$i]->hgb_top == '0')
                    <td style="text-align: right">{{zeroDigit($data[$i]->sup_top)}}</td>
                @else
                    <td style="text-align: right">{{zeroDigit($data[$i]->hgb_top)}}</td>
                @endif

                <td style="text-align: right">{{zeroDigit($data[$i]->prd_minorder)}}</td>
                @if($data[$i]->pkm_prdcd != null)
                    <td>Y</td>
                @else
                    <td>&nbsp;</td>
                @endif
            </tr>
            @php
                if($produkHolder == ''){
                    $produk++;
                    $produkHolder = $data[$i]->prd;
                }elseif(substr($data[$i]->prd,0,6) != substr($produkHolder,0,6)){
                    $produk++;
                    $produkHolder = $data[$i]->prd;
                }
                 $satuan++;
            @endphp
        @endfor
        <tr>
            <td style="font-weight: bold;border-top: 1px solid black;text-align: right">TOTAL SELURUHNYA :</td>
            <td style="font-weight: bold;border-top: 1px solid black;text-align: left" colspan="14" >{{$produk}} PRODUK {{$satuan}} SATUAN</td>
        </tr>
        </tbody>
    </table>
