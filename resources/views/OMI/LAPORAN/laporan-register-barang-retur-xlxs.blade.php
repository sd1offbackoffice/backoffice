

@php
    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,'.',',');
        return $hasil_rupiah;
    }
@endphp

<table style="border-collapse: collapse" class="table">
    <thead style="font-weight: bold; vertical-align: center; text-align: left; border-top: 2px solid black; border-bottom: 2px solid black">
        <tr>
            <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;width: 50px">TANGGAL</td>
            <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;width: 30px">NO. NRB</td>
            <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;width: 50px">TGL. NRB</td>
            <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;width: 40px">NO. DOKUMEN</td>
            <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;width: 20px">ITEM</td>
            <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;width: 30px">TOKO</td>
            <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;width: 250px">MEMBER</td>
            <td style="font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;text-align: right; width: 100px">NILAI</td>
        </tr>
    </thead>
    <tbody>
    <?php
        $bkp = 0;
        $btkp = 0;
        $temp = '';
    ?>
    @for($i=0;$i<sizeof($data);$i++)
        <?php
            $createDate = new DateTime($data[$i]->tgldok);
            $strip = $createDate->format('d-m-Y');
            $createDate = new DateTime($data[$i]->rom_tglreferensi);
            $strip2 = $createDate->format('d-m-Y');
            $bkp = $bkp + $data[$i]->ttl_bkp;
            $btkp = $btkp + $data[$i]->ttl_btkp;
        ?>
        <tr>
            @if($temp != $strip)
                <td style="text-align: left">{{$strip}}</td>
                <?php
                $temp = $strip;
                ?>
            @else
                <td></td>
            @endif

            <td style="text-align: left">{{$data[$i]->rom_noreferensi}}</td>
            <td style="text-align: left">{{$strip2}}</td>
            <td style="text-align: left">{{$data[$i]->rom_nodokumen}}</td>
            <td style="text-align: left">{{$data[$i]->item}}</td>
            <td style="text-align: left">{{$data[$i]->rom_kodetoko}}</td>
            <td style="text-align: left">{{$data[$i]->member}}</td>
            <td style="text-align: right">{{rupiah($data[$i]->total)}}</td>
        </tr>
    @endfor
    <tr>
        <td colspan="7" style="font-weight: bold;text-align: right; border-top: 1px solid black">TOTAL BKP</td>
        <td style="font-weight: bold;border-top: 1px solid black; text-align: right;">{{rupiah($bkp)}}</td>
    </tr>
    <tr>
        <td colspan="7" style="font-weight: bold;text-align: right;">TOTAL BTKP</td>
        <td style="font-weight: bold;text-align: right;">{{rupiah($btkp)}}</td>
    </tr>
    <tr>
        <td colspan="7" style="font-weight: bold;text-align: right; font-weight: bold; border-bottom: 1px solid black">TOTAL</td>
        <td style="font-weight: bold;border-bottom: 1px solid black; text-align: right;">{{rupiah($bkp + $btkp)}}</td>
    </tr>
    </tbody>
</table>

