<html>
<head>
    <title>LAPORAN-BARANG TITIPAN (PER CUSTOMER)</title>
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
        margin-top: 80px;
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
    </div>
    <div style="margin-top: -500px; float: right; line-height: 0.1px !important;">
        <p>{{$datas[0]->info}}</p>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">{{$datas[0]->head}}</h2>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th style="border-right: 1px solid black; border-bottom: 1px solid black">No.</th>
                <th colspan="6" style="border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Item Barang</th>
                <th colspan="2" style="border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">Unit</th>
                <th style="border-right: 1px solid black;border-bottom: 1px solid black">Titipan</th>
                <th style="border-right: 1px solid black;border-bottom: 1px solid black">SJ</th>
                <th style="border-bottom: 1px solid black">Sisa</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: center; vertical-align: center">
        <?php
            $temp = '';
            $numbering = 1;
        ?>
            @for($i=0;$i<sizeof($datas);$i++)
                @if($temp != $datas[$i]->trjd_prdcd)
                    <?php
                        $hold = $datas[$i]->trjd_prdcd;
                        $sumTitip = 0;
                        $j=$i;
                    ?>
                    @while($hold == $datas[$j]->trjd_prdcd)
                        <?php
                        $sumTitip = $sumTitip + $datas[$j]->struk;
                        $j++;
                        if($j == sizeof($datas)){
                            break;
                        }
                        ?>
                    @endwhile
                    <?php
                        $sisaAll = $sumTitip - $sjasAll[$i];
                    ?>
                    <tr>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$numbering}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$datas[$i]->trjd_prdcd}}</td>
                        <td colspan="6" style="text-align: left; border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$datas[$i]->prd_deskripsipendek}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$datas[$i]->unit}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$sumTitip}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$sjasAll[$i]}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$sisaAll}}</td>
                    </tr>
                    <?php
                        $temp = $datas[$i]->trjd_prdcd;
                        $numbering++;
                    ?>
                @endif
                <tr>
                    <td style="width: 10px;"> </td>
                    <td style="width: 60px;"> </td>
                    <td style="width: 0px;"> </td>
                    <td style="width: 0px;"> </td>
                    <td style="width: 50px; text-align: left">{{$datas[$i]->trjd_cus_kodemember}}</td>
                    <td style="width: 200px; text-align: left">{{$datas[$i]->cus_namamember}}</td>
                    <td style="width: 100px">{{$datas[$i]->sjh_tglstruk}}</td>
                    <td style="width: 80px">{{$datas[$i]->sjh_nostruk}}</td>
                    <td style="width: 80px; text-align: right">{{$sisa[$i]}}</td>
                    <td style="width: 40px;"> </td>
                    <td style="width: 30px;"> </td>
                    <td style="width: 35px;"> </td>
                </tr>

            @endfor
        </tbody>
    </table>
    <hr>
    <p style="float: right; line-height: 0.1px !important;">-- akhir data -</p>

</body>

</html>
