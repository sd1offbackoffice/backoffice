<html>
<head>
    <title>LAPORAN-SERVICE LEVEL SALES THD PB</title>
</head>
<style>
    /**
        Set the margins of the page to 0, so the footer and the header
        can be of the full height and width !
     **/
    @page {
        margin: 25px 25px;
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 10px;
        margin-bottom: 0px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        /*position: fixed;*/
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
        margin-bottom: 30px;
    }
    table{
        border: 1px;
    }
    .page-break {
        page-break-after: always;
    }
    .page-numbers:after { content: counter(page); }
</style>
<script src={{asset('/js/jquery.js')}}></script>
<script src={{asset('/js/sweetalert.js')}}></script>
<script>
    $(document).ready(function() {
        swal('Information', 'Tekan Ctrl+P untuk print!', 'info');
    });
</script>
<body>
<!-- Define header and footer blocks before your content -->
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
//rupiah formatter (no Rp or .00)
function rupiah($angka){
    //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    $hasil_rupiah = number_format($angka,0,'.',',');
    return $hasil_rupiah;
}
?>

<header>
    <div style="font-size: 12px ;line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="float: right; margin-top: -38px">
        <span>TGL : {{$today}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRG : LAP223 <br>JAM : {{$time}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">** LAPORAN SERVICE LEVEL SALES THD PB ** </h2>
        <h4 style="text-align: center">Periode : {{$date1}} s/d {{$date2}}</h4>
    </div>
</header>

{{--Karena laporan program lama error, tidak bisa meniru dengan persis, saya tidak tahu kalau sekarang laporan nya sudah bisa atau belum (27-09-2021)--}}
<span style="font-weight: bold">Kode Cabang : {{$datas[0]->pbo_kodeomi}} - {{$datas[0]->tko_namaomi}} / Member : {{$datas[0]->pbo_kodemember}} - {{$datas[0]->cus_namamember}}</span>

<table style="border-collapse: collapse">
    <thead style="font-weight: bold; text-align: center; vertical-align: center; border-top: 2px solid black; border-bottom: 2px solid black">
        <tr>
            <td rowspan="2">NO</td>
            <td rowspan="2">PLU</td>
            <td rowspan="2" style="text-align: left">DESKRIPSI</td>
            <td rowspan="2">TAG</td>
            <td colspan="3">----- Q U A N T I T Y -----</td>
            <td colspan="3">---------- R U P I A H ----------</td>
        </tr>
        <tr>
            <td>PO</td>
            <td>REALISASI</td>
            <td>%</td>
            <td>PO</td>
            <td>REALISASI</td>
            <td>%</td>
        </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $counterDep = 1;
        $counterDiv = 1;

        $divisi = '';
        $departemen = '';
        $kategori = '';

        $divisiHolder = $datas[0]->pbo_kodedivisi;
        $departemenHolder = $datas[0]->pbo_kodedepartemen;
        $kategoriHolder = $datas[0]->pbo_kodekategoribrg;
    ?>
    @for($i=0;$i<sizeof($datas);$i++)
        @if($divisi != $datas[$i]->pbo_kodedivisi)
            <tr>
                <td style="font-weight: bold">Divisi</td>
                <td>{{$datas[$i]->pbo_kodedivisi}}</td>
                <td colspan="8"> - {{$datas[$i]->div_namadivisi}}</td>
            </tr>
            <?php
            $divisi = $datas[$i]->kodedivisi;
            ?>
        @endif
        @if($departemen != $datas[$i]->pbo_kodedepartemen)
            <tr>
                <td style="font-weight: bold">Departemen</td>
                <td>{{$datas[$i]->pbo_kodedepartemen}}</td>
                <td colspan="8"> - {{$datas[$i]->dep_namadepartemen}}</td>
            </tr>
            <?php
            $departemen = $datas[$i]->pbo_kodedepartemen;
            ?>
        @endif
        @if($kategori != $datas[$i]->pbo_kodekategoribrg)
            <tr>
                <td style="font-weight: bold">Kategori</td>
                <td>{{$datas[$i]->pbo_kodekategoribrg}}</td>
                <td colspan="8"> - {{$datas[$i]->kat_namakategori}}</td>
            </tr>
            <?php
            $kategori = $datas[$i]->pbo_kodekategoribrg;
            ?>
        @endif
        <tr>
            <td>{{$counter}}</td>
            <td>{{$datas[$i]->pbo_pluigr}}</td>
            <td>{{$datas[$i]->prd_deskripsipanjang}}</td>
            <td>{{$datas[$i]->prd_kodetag}}</td>
            <td>{{$datas[$i]->qtyo}}</td>
            <td>{{$datas[$i]->qtyr}}</td>
            <td>{{$prsq[$i]}}</td>
            <td>{{$datas[$i]->nilaio}}</td>
            <td>{{$datas[$i]->nilair}}</td>
            <td>{{$prsr[$i]}}</td>
        </tr>
        @if(($i+1) < sizeof($datas))
            @if($kategoriHolder != $datas[$i+1]->pbo_kodekategoribrg)
                <tr>
                    <td colspan="3">Total Per Kategori {{$datas[$i]->pbo_kodekategoribrg}}</td>
                    <td>{{$counter}} Item</td>
                    <?php
                    $kategoriHolder = $datas[$i+1]->pbo_kodekategoribrg;
                    $katqqtyo = 0;
                    $katqqtyr = 0;
                    for($j=($i-($counter-1));$j<$i+1;$j++){
                        $katqqtyo = $katqqtyo + $datas[$j]->qtyo;
                        $katqqtyr = $katqqtyr + $datas[$j]->qtyr;
                        if($katqqtyo != 0 && $katqqtyr != 0){
                            $persen = round(($katqqtyr / $katqqtyo) * 100,2);
                        }else{
                            $persen = 0;
                        }
                    }
                    ?>
                    <td>{{$katqqtyo}}</td>
                    <td>{{$katqqtyr}}</td>
                    <td>{{$persen}}</td>
                    <?php
                    $katnilo = 0;
                    $katnilr = 0;
                    for($j=($i-($counter-1));$j<$i+1;$j++){
                        $katnilo = $katnilo + $datas[$j]->nilaio;
                        $katnilr = $katnilr + $datas[$j]->nilair;
                        if($katqqtyo != 0 && $katqqtyr != 0){
                            $persen = round(($katnilr / $katnilo) * 100,2);
                        }else{
                            $persen = 0;
                        }
                    }
                    $counter = 0;
                    ?>
                    <td>{{$katnilo}}</td>
                    <td>{{$katnilr}}</td>
                    <td>{{$persen}}</td>
                </tr>
            @endif

            @if($departemenHolder != $datas[$i+1]->pbo_kodedepartemen)
                <tr>
                    <td colspan="3">Total Per Departemen {{$datas[$i]->pbo_kodedepartemen}}</td>
                    <td>{{$counterDep}} Item</td>
                    <?php
                    $departemenHolder = $datas[$i+1]->pbo_kodedepartemen;
                    $katqqtyo = 0;
                    $katqqtyr = 0;
                    for($j=($i-($counterDep-1));$j<$i+1;$j++){
                        $katqqtyo = $katqqtyo + $datas[$j]->qtyo;
                        $katqqtyr = $katqqtyr + $datas[$j]->qtyr;
                        if($katqqtyo != 0 && $katqqtyr != 0){
                            $persen = round(($katqqtyr / $katqqtyo) * 100,2);
                        }else{
                            $persen = 0;
                        }
                    }
                    ?>
                    <td>{{$katqqtyo}}</td>
                    <td>{{$katqqtyr}}</td>
                    <td>{{$persen}}</td>
                    <?php
                    $katnilo = 0;
                    $katnilr = 0;
                    for($j=($i-($counterDep-1));$j<$i+1;$j++){
                        $katnilo = $katnilo + $datas[$j]->nilaio;
                        $katnilr = $katnilr + $datas[$j]->nilair;
                        if($katqqtyo != 0 && $katqqtyr != 0){
                            $persen = round(($katnilr / $katnilo) * 100,2);
                        }else{
                            $persen = 0;
                        }
                    }
                    $counterDep = 0;
                    ?>
                    <td>{{$katnilo}}</td>
                    <td>{{$katnilr}}</td>
                    <td>{{$persen}}</td>
                </tr>
            @endif

            @if($divisiHolder != $datas[$i+1]->pbo_kodedivisi)
                <tr>
                    <td colspan="3">Total Per Divisi {{$datas[$i]->pbo_kodedivisi}}</td>
                    <td>{{$counterDiv}} Item</td>
                    <?php
                    $divisiHolder = $datas[$i+1]->pbo_kodedivisi;
                    $katqqtyo = 0;
                    $katqqtyr = 0;
                    for($j=($i-($counterDiv-1));$j<$i+1;$j++){
                        $katqqtyo = $katqqtyo + $datas[$j]->qtyo;
                        $katqqtyr = $katqqtyr + $datas[$j]->qtyr;
                        if($katqqtyo != 0 && $katqqtyr != 0){
                            $persen = round(($katqqtyr / $katqqtyo) * 100,2);
                        }else{
                            $persen = 0;
                        }
                    }
                    ?>
                    <td>{{$katqqtyo}}</td>
                    <td>{{$katqqtyr}}</td>
                    <td>{{$persen}}</td>
                    <?php
                    $katnilo = 0;
                    $katnilr = 0;
                    for($j=($i-($counterDiv-1));$j<$i+1;$j++){
                        $katnilo = $katnilo + $datas[$j]->nilaio;
                        $katnilr = $katnilr + $datas[$j]->nilair;
                        if($katqqtyo != 0 && $katqqtyr != 0){
                            $persen = round(($katnilr / $katnilo) * 100,2);
                        }else{
                            $persen = 0;
                        }
                    }
                    $counterDiv = 0;
                    ?>
                    <td>{{$katnilo}}</td>
                    <td>{{$katnilr}}</td>
                    <td>{{$persen}}</td>
                </tr>
            @endif
        @endif
        <?php
            $counter++;
            $counterDep++;
            $counterDiv++;
        ?>
    @endfor

        <tr>
            <td colspan="3">Total Per Kategori {{$datas[sizeof($datas)-1]->pbo_kodekategoribrg}}</td>
            <td>{{$counter}} Item</td>
            <?php
            $katqqtyo = 0;
            $katqqtyr = 0;
            for($j=((sizeof($datas)-1)-($counter-1));$j<sizeof($datas);$j++){
                $katqqtyo = $katqqtyo + $datas[$j]->qtyo;
                $katqqtyr = $katqqtyr + $datas[$j]->qtyr;
                if($katqqtyo != 0 && $katqqtyr != 0){
                    $persen = round(($katqqtyr / $katqqtyo) * 100,2);
                }else{
                    $persen = 0;
                }
            }
            ?>
            <td>{{$katqqtyo}}</td>
            <td>{{$katqqtyr}}</td>
            <td>{{$persen}}</td>
            <?php
            $katnilo = 0;
            $katnilr = 0;
            for($j=((sizeof($datas)-1)-($counter-1));$j<sizeof($datas);$j++){
                $katnilo = $katnilo + $datas[$j]->nilaio;
                $katnilr = $katnilr + $datas[$j]->nilair;
                if($katqqtyo != 0 && $katqqtyr != 0){
                    $persen = round(($katnilr / $katnilo) * 100,2);
                }else{
                    $persen = 0;
                }
            }
            $counter = 0;
            ?>
            <td>{{$katnilo}}</td>
            <td>{{$katnilr}}</td>
            <td>{{$persen}}</td>
        </tr>


        <tr>
            <td colspan="3">Total Per Departemen {{$datas[sizeof($datas)-1]->pbo_kodedepartemen}}</td>
            <td>{{$counterDep}} Item</td>
            <?php
            $katqqtyo = 0;
            $katqqtyr = 0;
            for($j=((sizeof($datas)-1)-($counterDep-1));$j<sizeof($datas);$j++){
                $katqqtyo = $katqqtyo + $datas[$j]->qtyo;
                $katqqtyr = $katqqtyr + $datas[$j]->qtyr;
                if($katqqtyo != 0 && $katqqtyr != 0){
                    $persen = round(($katqqtyr / $katqqtyo) * 100,2);
                }else{
                    $persen = 0;
                }
            }
            ?>
            <td>{{$katqqtyo}}</td>
            <td>{{$katqqtyr}}</td>
            <td>{{$persen}}</td>
            <?php
            $katnilo = 0;
            $katnilr = 0;
            for($j=((sizeof($datas)-1)-($counterDep-1));$j<sizeof($datas);$j++){
                $katnilo = $katnilo + $datas[$j]->nilaio;
                $katnilr = $katnilr + $datas[$j]->nilair;
                if($katqqtyo != 0 && $katqqtyr != 0){
                    $persen = round(($katnilr / $katnilo) * 100,2);
                }else{
                    $persen = 0;
                }
            }
            $counterDep = 0;
            ?>
            <td>{{$katnilo}}</td>
            <td>{{$katnilr}}</td>
            <td>{{$persen}}</td>
        </tr>

        <tr>
            <td colspan="3">Total Per Divisi {{$datas[sizeof($datas)-1]->pbo_kodedivisi}}</td>
            <td>{{$counterDiv}} Item</td>
            <?php
            $katqqtyo = 0;
            $katqqtyr = 0;
            for($j=((sizeof($datas)-1)-($counterDiv-1));$j<sizeof($datas);$j++){
                $katqqtyo = $katqqtyo + $datas[$j]->qtyo;
                $katqqtyr = $katqqtyr + $datas[$j]->qtyr;
                if($katqqtyo != 0 && $katqqtyr != 0){
                    $persen = round(($katqqtyr / $katqqtyo) * 100,2);
                }else{
                    $persen = 0;
                }
            }
            ?>
            <td>{{$katqqtyo}}</td>
            <td>{{$katqqtyr}}</td>
            <td>{{$persen}}</td>
            <?php
            $katnilo = 0;
            $katnilr = 0;
            for($j=((sizeof($datas)-1)-($counterDiv-1));$j<sizeof($datas);$j++){
                $katnilo = $katnilo + $datas[$j]->nilaio;
                $katnilr = $katnilr + $datas[$j]->nilair;
                if($katqqtyo != 0 && $katqqtyr != 0){
                    $persen = round(($katnilr / $katnilo) * 100,2);
                }else{
                    $persen = 0;
                }
            }
            $counterDiv = 0;
            ?>
            <td>{{$katnilo}}</td>
            <td>{{$katnilr}}</td>
            <td>{{$persen}}</td>
        </tr>

        <tr>
            <td colspan="4">Total Seluruh</td>
            <?php
            $katqqtyo = 0;
            $katqqtyr = 0;
            for($j=0;$j<sizeof($datas);$j++){
                $katqqtyo = $katqqtyo + $datas[$j]->qtyo;
                $katqqtyr = $katqqtyr + $datas[$j]->qtyr;
                if($katqqtyo != 0 && $katqqtyr != 0){
                    $persen = round(($katqqtyr / $katqqtyo) * 100,2);
                }else{
                    $persen = 0;
                }
            }
            ?>
            <td>{{$katqqtyo}}</td>
            <td>{{$katqqtyr}}</td>
            <td>{{$persen}}</td>
            <?php
            $katnilo = 0;
            $katnilr = 0;
            for($j=0;$j<sizeof($datas);$j++){
                $katnilo = $katnilo + $datas[$j]->nilaio;
                $katnilr = $katnilr + $datas[$j]->nilair;
                if($katqqtyo != 0 && $katqqtyr != 0){
                    $persen = round(($katnilr / $katnilo) * 100,2);
                }else{
                    $persen = 0;
                }
            }
            ?>
            <td>{{$katnilo}}</td>
            <td>{{$katnilr}}</td>
            <td>{{$persen}}</td>
        </tr>

    </tbody>
    <hr>
    <span style="float: right;">** Akhir Laporan **</span>
</table>
</body>
</html>

