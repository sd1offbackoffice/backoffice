<html>
<head>
    <title>LAPORAN-PERBEDAAN KODE TAG IGR-IDM</title>
    <script src={{asset('/js/jquery.js')}}></script>
    <script src={{asset('/js/sweetalert.js')}}></script>
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }} rel="stylesheet">
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
        margin-top: 150px;
        margin-bottom: 10px;
        font-size: 9px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        font-weight: 400;
        line-height: 1.8;
        /*font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";*/
    }

    /** Define the header rules **/
    header {
        position: absolute;
        top: 1cm;
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
<script>
    $(document).ready(function() {
        swal('', "Tekan CTRL+P untuk print/cetak data!", 'info');
    });

</script>

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
    <div style="margin-top: 35px; line-height: 0.1 !important;">
        <h2 style="text-align: center">LAPORAN PERBEDAAN KODE TAG IGR-IDM</h2>
        <h4 style="text-align: center">PER TANGGAL {{$today}} {{$time}}</h4>
    </div>
</header>


    <table class="table table-bordered table-responsive" style="border-collapse: collapse">
        <thead style="border-top: 3px solid black;border-bottom: 3px solid black;">
            <tr style="text-align: center; vertical-align: center">
                <th style="width: 10%; border-right: 1px solid black; border-bottom: 1px solid black">PLU IDM</th>
                <th style="width: 10%; border-right: 1px solid black; border-bottom: 1px solid black">PLU IGR</th>
                <th style="width: 50%;border-right: 1px solid black; border-bottom: 1px solid black; text-align: left">DESKRIPSI</th>
                <th style="width: 10%;border-right: 1px solid black; border-bottom: 1px solid black">SATUAN</th>
                <th style="width: 10%;border-right: 1px solid black; border-bottom: 1px solid black">TAG IDM</th>
                <th style="width: 10%;border-right: 1px solid black; border-bottom: 1px solid black">TAG IGR</th>
                <th style="width: 10%;border-bottom: 1px solid black;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody style="border-bottom: 3px solid black; text-align: center; vertical-align: center">
        <?php
            $temp = "";
        ?>
            @for($i=0;$i<sizeof($datas);$i++)
                <tr>
                @if($temp != $datas[$i]->idm_pluidm)
                    <td>{{$datas[$i]->idm_pluidm}}</td>
                    <?php
                        $temp = $datas[$i]->idm_pluidm;
                    ?>
                @else
                    <td> </td>
                @endif
                    <td>{{$datas[$i]->prd_prdcd}}</td>
                    <td style="text-align: left">{{$datas[$i]->prd_deskripsipendek}}</td>
                    <td>{{$datas[$i]->prd_satuan}}</td>
                    <td>{{$datas[$i]->idm_tag}}</td>
                    <td>{{$datas[$i]->prd_kodetag}}</td>
                    <td>{{$datas[$i]->ket}}</td>
                </tr>
            @endfor
        </tbody>
    </table>
    <hr>
    <p style="float: right">** AKHIR LAPORAN **</p>

</body>

</html>
