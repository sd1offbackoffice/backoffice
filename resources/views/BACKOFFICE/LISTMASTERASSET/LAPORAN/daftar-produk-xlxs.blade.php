@php
    function zeroDigit($angka){
        $digit = number_format($angka,0,'.',',');
        return $digit;
    }
    function oneDigit($angka){
        $digit = number_format($angka,1,'.',',');
        return $digit;
    }
    $divisi         = '';
    $departement    = '';
    $kategori       = '';

    $produkHolder   = '';
    $divProduk      = 0;
    $divSatuan      = 0;

    $depProduk      = 0;
    $depSatuan      = 0;

    $katProduk      = 0;
    $katSatuan      = 0;

    $produk         = 0;
    $satuan         = 0;
@endphp
    <table class="table">
        <thead>
            <tr>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">KODE</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">NAMA BARANG</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="left">SATUAN</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">MIN<br>JUAL</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">HPP AKHIR</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">HPP RATA2</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">HRG JUAL</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">MARGIN</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">TGL AKTIF</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">TAG</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">RCV</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">SUPPLIER</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">TOP</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">MINOR</td>
                <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;" align="right">PKM</td>
            </tr>
        </thead>
        <tbody>
        @for($i=0;$i<sizeof($data);$i++)
            @if($data[$i]->prd_kodedivisi != $divisi || $data[$i]->prd_kodedepartement != $departement || $data[$i]->prd_kodekategoribarang != $kategori)
                @if($katSatuan!=0)
                    <tr style="font-weight: bold; text-align: left">
                        <td colspan="" style="font-weight: bold;border-bottom: 1px solid black;">TOTAL KATEGORI :</td>
                        <td colspan="14" style="font-weight: bold;border-bottom: 1px solid black;">{{$katProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$katSatuan}} SATUAN</td>
                    </tr>
                    @php
                        $katProduk = 0;
                        $katSatuan = 0;
                    @endphp
                @endif
                @if($depSatuan!=0 && $data[$i]->prd_kodedepartement != $departement)
                    <tr style="font-weight: bold; text-align: left">
                        <td style="font-weight: bold;border-bottom: 1px solid black;">TOTAL DEPARTEMENT :</td>
                        <td colspan="14" style="font-weight: bold;border-bottom: 1px solid black;">{{$depProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$depSatuan}} SATUAN</td>
                    </tr>
                    @php
                        $depProduk = 0;
                        $depSatuan = 0;
                    @endphp
                @endif
                @if($divSatuan!=0 && $data[$i]->prd_kodedivisi != $divisi)
                    <tr style="font-weight: bold; text-align: left">
                        <td style="font-weight: bold;border-bottom: 1px solid black;">TOTAL DIVISI :</td>
                        <td colspan="14" style="font-weight: bold;border-bottom: 1px solid black;">{{$divProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$divSatuan}} SATUAN</td>
                    </tr>
                    @php
                        $divProduk = 0;
                        $divSatuan = 0;
                    @endphp
                @endif
                @php
                    $divisi = $data[$i]->prd_kodedivisi;
                    $departement = $data[$i]->prd_kodedepartement;
                    $kategori = $data[$i]->prd_kodekategoribarang;
                @endphp
                <tr style="text-align: left; font-weight: bold">
                    <td style="font-weight: bold;" >DIVISI : {{$data[$i]->divisi}}</td>
                    <td style="font-weight: bold;" >DEPARTEMENT : {{$data[$i]->dept}}</td>
                    <td style="font-weight: bold;" colspan="5">KATEGORI : {{$data[$i]->kategori}}</td>
                </tr>
            @endif
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
                    $divProduk++;
                    $depProduk++;
                    $katProduk++;
                    $produk++;
                    $produkHolder = $data[$i]->prd;
                }elseif(substr($data[$i]->prd,0,6) != substr($produkHolder,0,6)){
                    $divProduk++;
                    $depProduk++;
                    $katProduk++;
                    $produk++;
                    $produkHolder = $data[$i]->prd;
                }
                $divSatuan++;
                $depSatuan++;
                $katSatuan++;
                $satuan++;
            @endphp
        @endfor
        <tr>
            <td style="font-weight: bold; text-align: left;border-bottom: 1px solid black;" >TOTAL KATEGORI : </td>
            <td style="font-weight: bold; text-align: left;border-bottom: 1px solid black;" colspan="14">{{$katProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$katSatuan}} SATUAN</td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: left;border-bottom: 1px solid black;" >TOTAL DEPARTEMENT :</td>
            <td style="font-weight: bold; text-align: left;border-bottom: 1px solid black;" colspan="14">{{$depProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$depSatuan}} SATUAN</td>
        </tr>
        <tr>
            <td style="font-weight: bold; text-align: left;border-bottom: 1px solid black;" >TOTAL DIVISI :</td>
            <td style="font-weight: bold; text-align: left;border-bottom: 1px solid black;" colspan="14">{{$divProduk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$divSatuan}} SATUAN</td>
        </tr>
        <tr style="font-weight: bold; text-align: left">
            <td style="font-weight: bold; text-align: left;border-bottom: 1px solid black;" >TOTAL SELURUHNYA :</td>
            <td style="font-weight: bold; text-align: left;border-bottom: 1px solid black;" colspan="14">{{$produk}} PRODUK &nbsp;&nbsp;&nbsp;&nbsp;{{$satuan}} SATUAN</td>
        </tr>
        </tbody>
    </table>
