<html>
<head>
    <title>FORM USULAN HARGA JUAL KHUSUS ( NAIK / TURUN )</title>
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
        margin-top: 100px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
    }
    table{
        border: 1px;
    }
    .page-break {
        page-break-after: always;
    }
    .page-numbers:after { content: counter(page); }
</style>


<body>
<!-- Define header and footer blocks before your content -->
<?php
$i = 1;
$datetime = new DateTime();
$timezone = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($timezone);
?>
<header>
    <div style="margin-top: -20px; line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
        <p>{{$datas[0]->prs_namawilayah}}</p>
    </div>
    <div style="position: absolute;top: -7px; left: 576px; line-height: 0.1px !important;">
        <p>TGL : {{$today}}  PRG : LAP211<br>JAM : {{$time}}</p>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN MONITORING ITEM OMI YANG TIDAK  TERSUPPLY</h2>
        <h4 style="text-align: center">Tgl Proses PB OMI di IGR : {{$date1}} s/d {{$date2}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <td rowspan="2" style="border-right: 1px solid black">No</td>
                <td colspan="3"style="border-bottom: 1px solid black; border-right: 1px solid black">ITEM</td>
                <td rowspan="2" style="border-right: 1px solid black">Tag</td>
                <td colspan="3" style="border-bottom: 1px solid black; border-right: 1px solid black">REALISASI SUPPLY</td>
                <td rowspan="2" style="border-right: 1px solid black">Posisi<br>Stock</td>
                <td colspan="8" style="border-bottom: 1px solid black">Monitoring PB IGR / BPB</td>
            </tr>
        <tr style="text-align: center; vertical-align: center">
            <td style="border-right: 1px solid black">PLU IGR</td>
            <td colspan="2" style="border-right: 1px solid black">DESKRIPSI</td>
            <td style="border-right: 1px solid black">PB OMI</td>
            <td style="border-right: 1px solid black">Actual</td>
            <td style="border-right: 1px solid black">Selisih</td>
            <td style="border-right: 1px solid black">Tgl PB</td>
            <td style="border-right: 1px solid black">Qty PB</td>
            <td style="border-right: 1px solid black">BPB</td>
            <td style="border-right: 1px solid black">Tgl PO</td>
            <td style="border-right: 1px solid black">PKM</td>
            <td style="border-right: 1px solid black">M +</td>
            <td style="border-right: 1px solid black">FLAG</td>
            <td>KD</td>
        </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black">
        <?php
            $counter = 1;
            $divisi = '';
        ?>
        @for($i=0;$i<sizeof($datas);$i++)
            <?php
            $createDate = new DateTime($datas[$i]->tglpb);
            $strip = $createDate->format('d-m-Y');
            $createDate = new DateTime($datas[$i]->tglpo);
            $strip2 = $createDate->format('d-m-Y');
            ?>
            @if($divisi != $datas[$i]->divisi)
                <?php
                    $divisi = $datas[$i]->divisi;
                    $counter = 1;
                ?>
                <tr>
                    <td colspan="17" style="border-bottom: 1px solid black">{{$divisi}}</td>
                </tr>
            @endif
            <tr style="text-align: right">
                <td style="width: 5px; text-align: right">{{$counter}}</td>
                <td style="width: 20px; text-align: right">{{$datas[$i]->pluigr}}</td>
                <td style="width: 100px; text-align: left">{{$datas[$i]->deskripsi}}</td>
                <td style="width: 50px; text-align: center">{{$datas[$i]->satuan}}</td>
                <td style="width: 5px">{{$datas[$i]->tag}}</td>
                <td style="width: 10px">{{$datas[$i]->pbomi}}</td>
                <td style="width: 10px">{{$datas[$i]->actual}}</td>
                <td style="width: 10px">{{$datas[$i]->selisih}}</td>
                <td style="width: 35px">{{$datas[$i]->stock}}</td>
                <td style="width: 50px">{{$strip}}</td>
                <td style="width: 50px">{{$datas[$i]->qtypb}}</td>
                <td style="width: 10px">{{$datas[$i]->bpb}}</td>
                <td style="width: 50px">{{$strip2}}</td>
                <td style="width: 50px">{{$datas[$i]->pkmt}}</td>
                <td style="width: 10px">{{$datas[$i]->mplus}}</td>
                <td style="width: 10px">{{$datas[$i]->flag}}</td>
                <td style="width: 10px">{{$datas[$i]->kd}}</td>
            </tr>
            <?php
                $counter++;
            ?>
        @endfor
        </tbody>
    </table>
    <hr>
    <table style="font-size: 12px; margin-top: 20px">
        <tbody>

        </tbody>
    </table>
<br>
</body>

</html>
