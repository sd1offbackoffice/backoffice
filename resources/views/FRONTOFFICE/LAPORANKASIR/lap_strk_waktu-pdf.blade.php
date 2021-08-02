<html>
<head>
    <title>LAPORAN-REGISTER STRUK KASIR</title>
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
        /*margin-top: 120px;*/
        margin-bottom: 10px;
        font-size: 11px;
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
        margin-bottom: 20px;
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
    <div style="line-height: 0.1px !important;">
        <p>{{$datas[0]->prs_namaperusahaan}}</p>
        <p>{{$datas[0]->prs_namacabang}}</p>
    </div>
    <div style="float: right; margin-top: -35px">
        <span>{{$today}}&nbsp;&nbsp;&nbsp;&nbsp;{{$time}}</span>
    </div>
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">REGISTER STRUK KASIR</h2>
        <h2 style="text-align: center">{{$periode}}</h2>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black; text-align: center">
            <tr style="text-align: left; vertical-align: center">
                <th style="width: 15%; border-right: 1px solid black; border-bottom: 1px solid black;">Tanggal</th>
                <th style="width: 3%; border-right: 1px solid black; border-bottom: 1px solid black;">No.</th>
                <th style="width: 15%; border-right: 1px solid black; border-bottom: 1px solid black;">Waktu</th>
                <th style="text-align: center; width: 7%; border-right: 1px solid black; border-bottom: 1px solid black;">Station</th>
                <th style="width: 55%; border-right: 1px solid black; border-bottom: 1px solid black;">Kasir</th>
                <th style="text-align: center; width: 10%; border-right: 1px solid black; border-bottom: 1px solid black;">Struk</th>
                <th style="text-align: right; width: 25%; border-bottom: 1px solid black;">Nilai</th>
            </tr>
        </thead>
        <?php
        $theDate = '';
        $cashier = '';
        ?>
        <tbody style="border-bottom: 3px solid black; text-align: left">
        @for($i=0;$i<sizeof($datas);$i++)
            <?php
            $createDate = new DateTime($datas[$i]->jh_transactiondate);
            $strip = $createDate->format('d-m-Y');
            ?>
            <tr>
                @if($theDate != $strip)
                    <?php
                    $theDate = $strip
                    ?>
                        <td style="text-align: center">{{$strip}}</td>
                @else
                    <td style="text-align: center">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                @endif
                <td>{{$i+1}}</td>
                <td>{{$datas[$i]->waktu}}</td>
                <td style="text-align: center">{{$datas[$i]->jh_cashierstation}}</td>
                <td>{{$datas[$i]->jh_cashier}}</td>
                <td style="text-align: center">{{$datas[$i]->jh_transactionno}}</td>
                <td style="text-align: right">{{rupiah($datas[$i]->jh_transactionamt)}}</td>
            </tr>

        @endfor
        </tbody>
    </table>
    <hr>

</body>
</html>

