@extends('pdf-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN-BARANG TITIPAN (PER ITEM)
@endsection

@section('title')
    {{$data[0]->head}}
@endsection

@section('subtitle')

@endsection

@section('content')


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
            @for($i=0;$i<sizeof($data);$i++)
                @if($temp != $data[$i]->trjd_prdcd)
                    <?php
                        $hold = $data[$i]->trjd_prdcd;
                        $sumTitip = 0;
                        $j=$i;
                    ?>
                    @while($hold == $data[$j]->trjd_prdcd)
                        <?php
                        $sumTitip = $sumTitip + $data[$j]->struk;
                        $j++;
                        if($j == sizeof($data)){
                            break;
                        }
                        ?>
                    @endwhile
                    <?php
                        $sisaAll = $sumTitip - $sjasAll[$i];
                    ?>
                    <tr>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$numbering}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$data[$i]->trjd_prdcd}}</td>
                        <td colspan="6" style="text-align: left; border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$data[$i]->prd_deskripsipendek}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$data[$i]->unit}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$sumTitip}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$sjasAll[$i]}}</td>
                        <td style="border-top: 2px solid black; border-bottom: 2px solid black; background-color: lightgray">{{$sisaAll}}</td>
                    </tr>
                    <?php
                        $temp = $data[$i]->trjd_prdcd;
                        $numbering++;
                    ?>
                @endif
                <tr>
                    <td style="width: 10px;"> </td>
                    <td style="width: 60px;"> </td>
                    <td style="width: 0px;"> </td>
                    <td style="width: 0px;"> </td>
                    <td style="width: 50px; text-align: left">{{$data[$i]->trjd_cus_kodemember}}</td>
                    <td style="width: 200px; text-align: left">{{$data[$i]->cus_namamember}}</td>
                    <td style="width: 100px">{{$data[$i]->sjh_tglstruk}}</td>
                    <td style="width: 80px">{{$data[$i]->sjh_nostruk}}</td>
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

@endsection
@section('footer','')
