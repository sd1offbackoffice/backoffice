@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    Daftar Aktivitas Pengiriman Supplier
@endsection

@section('title')
    Daftar Aktivitas Pengiriman Supplier
@endsection

@section('subtitle')
    Periode : {{ DateTime::createFromFormat('!m', explode('-',$periode)[0])->format('F').' '.explode('-',$periode)[1] }}
@endsection

@section('paper_height')
    595pt
@endsection

@section('paper_width')
    1200pt
@endsection

@section('content')
    <table class="table">
        <thead style="border-top: 1px solid black;border-bottom: 1px solid black;">
        <tr>
            <th class="right padding-right tengah">No.</th>
            <th class="left tengah">Kode</th>
            <th class="left tengah">Nama Supplier</th>
            <th class="left tengah">Tgl</th>
            <th class="tengah">1</th>
            <th class="tengah">2</th>
            <th class="tengah">3</th>
            <th class="tengah">4</th>
            <th class="tengah">5</th>
            <th class="tengah">6</th>
            <th class="tengah">7</th>
            <th class="tengah">8</th>
            <th class="tengah">9</th>
            <th class="tengah">10</th>
            <th class="tengah">11</th>
            <th class="tengah">12</th>
            <th class="tengah">13</th>
            <th class="tengah">14</th>
            <th class="tengah">15</th>
            <th class="tengah">16</th>
            <th class="tengah">17</th>
            <th class="tengah">18</th>
            <th class="tengah">19</th>
            <th class="tengah">20</th>
            <th class="tengah">21</th>
            <th class="tengah">22</th>
            <th class="tengah">23</th>
            <th class="tengah">24</th>
            <th class="tengah">25</th>
            <th class="tengah">26</th>
            <th class="tengah">27</th>
            <th class="tengah">28</th>
            <th class="tengah">29</th>
            <th class="tengah">30</th>
            <th class="tengah">31</th>
            <th colspan="7" class="tengah">Total</th>
            <th rowspan="2" class="tengah">L. Time</th>
            <th colspan="7" class="tengah">Jadwal Seharusnya</th>
            <th rowspan="2" class="tengah">%<br>jadwal</th>
        </tr>
        <tr>
            <th colspan="3"></th>
            <th class="padding-right">Hri</th>
            <th class="tengah padding-right">{{$chari[1]}}</th>
            <th class="tengah padding-right">{{$chari[2]}}</th>
            <th class="tengah padding-right">{{$chari[3]}}</th>
            <th class="tengah padding-right">{{$chari[4]}}</th>
            <th class="tengah padding-right">{{$chari[5]}}</th>
            <th class="tengah padding-right">{{$chari[6]}}</th>
            <th class="tengah padding-right">{{$chari[7]}}</th>
            <th class="tengah padding-right">{{$chari[8]}}</th>
            <th class="tengah padding-right">{{$chari[9]}}</th>
            <th class="tengah padding-right">{{$chari[10]}}</th>
            <th class="tengah padding-right">{{$chari[11]}}</th>
            <th class="tengah padding-right">{{$chari[12]}}</th>
            <th class="tengah padding-right">{{$chari[13]}}</th>
            <th class="tengah padding-right">{{$chari[14]}}</th>
            <th class="tengah padding-right">{{$chari[15]}}</th>
            <th class="tengah padding-right">{{$chari[16]}}</th>
            <th class="tengah padding-right">{{$chari[17]}}</th>
            <th class="tengah padding-right">{{$chari[18]}}</th>
            <th class="tengah padding-right">{{$chari[19]}}</th>
            <th class="tengah padding-right">{{$chari[20]}}</th>
            <th class="tengah padding-right">{{$chari[21]}}</th>
            <th class="tengah padding-right">{{$chari[22]}}</th>
            <th class="tengah padding-right">{{$chari[23]}}</th>
            <th class="tengah padding-right">{{$chari[24]}}</th>
            <th class="tengah padding-right">{{$chari[25]}}</th>
            <th class="tengah padding-right">{{$chari[26]}}</th>
            <th class="tengah padding-right">{{$chari[27]}}</th>
            <th class="tengah padding-right">{{$chari[28]}}</th>
            <th class="tengah padding-right">{{$chari[29]}}</th>
            <th class="tengah padding-right">{{$chari[30]}}</th>
            <th class="tengah padding-right">{{$chari[31]}}</th>
            <th class="right">Snn</th>
            <th class="right">Sls</th>
            <th class="right">Rbu</th>
            <th class="right">Kms</th>
            <th class="right">Jmt</th>
            <th class="right">Sbt</th>
            <th class="right">Mng</th>
            <th class="right">Snn</th>
            <th class="right">Sls</th>
            <th class="right">Rbu</th>
            <th class="right">Kms</th>
            <th class="right">Jmt</th>
            <th class="right">Sbt</th>
            <th class="right">Mng</th>
        </tr>
        </thead>
        <tbody>
        @php
            $tempSupplier='';
            $cp_hrk1 = '';
            $cp_hrk2 = '';
            $cp_hrk3 = '';
            $cp_hrk4 = '';
            $cp_hrk5 = '';
            $cp_hrk6 = '';
            $cp_hrk7 = '';

            $sum_tgl01=0;
            $sum_tgl02=0;
            $sum_tgl03=0;
            $sum_tgl04=0;
            $sum_tgl05=0;
            $sum_tgl06=0;
            $sum_tgl07=0;
            $sum_tgl08=0;
            $sum_tgl09=0;
            $sum_tgl10=0;
            $sum_tgl11=0;
            $sum_tgl12=0;
            $sum_tgl13=0;
            $sum_tgl14=0;
            $sum_tgl15=0;
            $sum_tgl16=0;
            $sum_tgl17=0;
            $sum_tgl18=0;
            $sum_tgl19=0;
            $sum_tgl20=0;
            $sum_tgl21=0;
            $sum_tgl22=0;
            $sum_tgl23=0;
            $sum_tgl24=0;
            $sum_tgl25=0;
            $sum_tgl26=0;
            $sum_tgl27=0;
            $sum_tgl28=0;
            $sum_tgl29=0;
            $sum_tgl30=0;
            $sum_tgl31=0;


            $sum_snn=0;
            $sum_sls=0;
            $sum_rbu=0;
            $sum_kms=0;
            $sum_jmt=0;
            $sum_sbt=0;
            $sum_mng=0;
            $sum_jwpb=0;


            $sum_cp_hrk1=0;
            $sum_cp_hrk2=0;
            $sum_cp_hrk3=0;
            $sum_cp_hrk4=0;
            $sum_cp_hrk5=0;
            $sum_cp_hrk6=0;
            $sum_cp_hrk7=0;
            $sum_cf_jadwal=0;
        @endphp

        @for($i=0; $i<sizeof($data) ;$i++)
            @php
                if(substr($data[$i]->sup_harikunjungan,1,1) == 'Y'){
                    $cp_hrk1 = 'Y';
                }else{
                    $cp_hrk1 = '';
                }
                if(substr($data[$i]->sup_harikunjungan,2,1) == 'Y'){
                    $cp_hrk2 = 'Y';
                }else{
                    $cp_hrk2 = '';
                }
                if(substr($data[$i]->sup_harikunjungan,3,1) == 'Y'){
                    $cp_hrk3 = 'Y';
                }else{
                    $cp_hrk3 = '';
                }
                if(substr($data[$i]->sup_harikunjungan,4,1) == 'Y'){
                    $cp_hrk4 = 'Y';
                }else{
                    $cp_hrk4 = '';
                }
                if(substr($data[$i]->sup_harikunjungan,5,1) == 'Y'){
                    $cp_hrk5 = 'Y';
                }else{
                    $cp_hrk5 = '';
                }
                if(substr($data[$i]->sup_harikunjungan,6,1) == 'Y'){
                    $cp_hrk6 = 'Y';
                }else{
                    $cp_hrk6 = '';
                }
                if(substr($data[$i]->sup_harikunjungan,7,1) == 'Y'){
                    $cp_hrk7 = 'Y';
                }else{
                    $cp_hrk7 = '';
                }

                $nok = 0;
                $njml = 0;
                if(substr($data[$i]->sup_harikunjungan,0,1) == 'Y' && $data[$i]->mng <> 0){
                    $nok = $nok + $data[$i]->mng;
                }
                if(substr($data[$i]->sup_harikunjungan,1,1) == 'Y' && $data[$i]->snn <> 0){
                    $nok = $nok + $data[$i]->snn;
                }
                if(substr($data[$i]->sup_harikunjungan,2,1) == 'Y' && $data[$i]->sls <> 0){
                    $nok = $nok + $data[$i]->sls;
                }
                if(substr($data[$i]->sup_harikunjungan,3,1) == 'Y' && $data[$i]->rbu <> 0){
                    $nok = $nok + $data[$i]->rbu;
                }
                if(substr($data[$i]->sup_harikunjungan,4,1) == 'Y' && $data[$i]->kms <> 0){
                    $nok = $nok + $data[$i]->kms;
                }
                if(substr($data[$i]->sup_harikunjungan,5,1) == 'Y' && $data[$i]->jmt <> 0){
                    $nok = $nok + $data[$i]->jmt;
                }
                if(substr($data[$i]->sup_harikunjungan,6,1) == 'Y' && $data[$i]->sbt <> 0){
                    $nok = $nok + $data[$i]->sbt;
                }
                $njml = $data[$i]->mng +$data[$i]->snn +$data[$i]->sls +$data[$i]->rbu +$data[$i]->kms +$data[$i]->jmt + $data[$i]->sbt;
                 $cf_jadwal = round(($nok/$njml)*100);
               // $cf_jadwal = $nok.'-'.$njml;

               $sum_tgl01 += $data[$i]->tgl01;
                $sum_tgl02 += $data[$i]->tgl02;
                $sum_tgl03 += $data[$i]->tgl03;
                $sum_tgl04 += $data[$i]->tgl04;
                $sum_tgl05 += $data[$i]->tgl05;
                $sum_tgl06 += $data[$i]->tgl06;
                $sum_tgl07 += $data[$i]->tgl07;
                $sum_tgl08 += $data[$i]->tgl08;
                $sum_tgl09 += $data[$i]->tgl09;
                $sum_tgl10 += $data[$i]->tgl10;
                $sum_tgl11 += $data[$i]->tgl11;
                $sum_tgl12 += $data[$i]->tgl12;
                $sum_tgl13 += $data[$i]->tgl13;
                $sum_tgl14 += $data[$i]->tgl14;
                $sum_tgl15 += $data[$i]->tgl15;
                $sum_tgl16 += $data[$i]->tgl16;
                $sum_tgl17 += $data[$i]->tgl17;
                $sum_tgl18 += $data[$i]->tgl18;
                $sum_tgl19 += $data[$i]->tgl19;
                $sum_tgl20 += $data[$i]->tgl20;
                $sum_tgl21 += $data[$i]->tgl21;
                $sum_tgl22 += $data[$i]->tgl22;
                $sum_tgl23 += $data[$i]->tgl23;
                $sum_tgl24 += $data[$i]->tgl24;
                $sum_tgl25 += $data[$i]->tgl25;
                $sum_tgl26 += $data[$i]->tgl26;
                $sum_tgl27 += $data[$i]->tgl27;
                $sum_tgl28 += $data[$i]->tgl28;
                $sum_tgl29 += $data[$i]->tgl29;
                $sum_tgl30 += $data[$i]->tgl30;
                $sum_tgl31 += $data[$i]->tgl31;

                $data[$i]->tgl01= $data[$i]->tgl01==1?'X':'';
                $data[$i]->tgl02= $data[$i]->tgl02==1?'X':'';
                $data[$i]->tgl03= $data[$i]->tgl03==1?'X':'';
                $data[$i]->tgl04= $data[$i]->tgl04==1?'X':'';
                $data[$i]->tgl05= $data[$i]->tgl05==1?'X':'';
                $data[$i]->tgl06= $data[$i]->tgl06==1?'X':'';
                $data[$i]->tgl07= $data[$i]->tgl07==1?'X':'';
                $data[$i]->tgl08= $data[$i]->tgl08==1?'X':'';
                $data[$i]->tgl09= $data[$i]->tgl09==1?'X':'';
                $data[$i]->tgl10= $data[$i]->tgl10==1?'X':'';
                $data[$i]->tgl11= $data[$i]->tgl11==1?'X':'';
                $data[$i]->tgl12= $data[$i]->tgl12==1?'X':'';
                $data[$i]->tgl13= $data[$i]->tgl13==1?'X':'';
                $data[$i]->tgl14= $data[$i]->tgl14==1?'X':'';
                $data[$i]->tgl15= $data[$i]->tgl15==1?'X':'';
                $data[$i]->tgl16= $data[$i]->tgl16==1?'X':'';
                $data[$i]->tgl17= $data[$i]->tgl17==1?'X':'';
                $data[$i]->tgl18= $data[$i]->tgl18==1?'X':'';
                $data[$i]->tgl19= $data[$i]->tgl19==1?'X':'';
                $data[$i]->tgl20= $data[$i]->tgl20==1?'X':'';
                $data[$i]->tgl21= $data[$i]->tgl21==1?'X':'';
                $data[$i]->tgl22= $data[$i]->tgl22==1?'X':'';
                $data[$i]->tgl23= $data[$i]->tgl23==1?'X':'';
                $data[$i]->tgl24= $data[$i]->tgl24==1?'X':'';
                $data[$i]->tgl25= $data[$i]->tgl25==1?'X':'';
                $data[$i]->tgl26= $data[$i]->tgl26==1?'X':'';
                $data[$i]->tgl27= $data[$i]->tgl27==1?'X':'';
                $data[$i]->tgl28= $data[$i]->tgl28==1?'X':'';
                $data[$i]->tgl29= $data[$i]->tgl29==1?'X':'';
                $data[$i]->tgl30= $data[$i]->tgl30==1?'X':'';
                $data[$i]->tgl31= $data[$i]->tgl31==1?'X':'';



                $sum_snn += $data[$i]->snn;
                $sum_sls += $data[$i]->sls;
                $sum_rbu += $data[$i]->rbu;
                $sum_kms += $data[$i]->kms;
                $sum_jmt += $data[$i]->jmt;
                $sum_sbt += $data[$i]->sbt;
                $sum_mng += $data[$i]->mng;

            @endphp
            <tr>
                <td class="left">{{ $i+1 }}</td>
                <td class="left">{{ $data[$i]->sup_kodesupplier }}</td>
                <td class="left">{{ $data[$i]->namasup }}</td>
                <td class="left"></td>
                <td class="center">{{ $data[$i]->tgl01 }}</td>
                <td class="center">{{ $data[$i]->tgl02 }}</td>
                <td class="center">{{ $data[$i]->tgl03 }}</td>
                <td class="center">{{ $data[$i]->tgl04 }}</td>
                <td class="center">{{ $data[$i]->tgl05 }}</td>
                <td class="center">{{ $data[$i]->tgl06 }}</td>
                <td class="center">{{ $data[$i]->tgl07 }}</td>
                <td class="center">{{ $data[$i]->tgl08 }}</td>
                <td class="center">{{ $data[$i]->tgl09 }}</td>
                <td class="center">{{ $data[$i]->tgl10 }}</td>
                <td class="center">{{ $data[$i]->tgl11 }}</td>
                <td class="center">{{ $data[$i]->tgl12 }}</td>
                <td class="center">{{ $data[$i]->tgl13 }}</td>
                <td class="center">{{ $data[$i]->tgl14 }}</td>
                <td class="center">{{ $data[$i]->tgl15 }}</td>
                <td class="center">{{ $data[$i]->tgl16 }}</td>
                <td class="center">{{ $data[$i]->tgl17 }}</td>
                <td class="center">{{ $data[$i]->tgl18 }}</td>
                <td class="center">{{ $data[$i]->tgl19 }}</td>
                <td class="center">{{ $data[$i]->tgl20 }}</td>
                <td class="center">{{ $data[$i]->tgl21 }}</td>
                <td class="center">{{ $data[$i]->tgl22 }}</td>
                <td class="center">{{ $data[$i]->tgl23 }}</td>
                <td class="center">{{ $data[$i]->tgl24 }}</td>
                <td class="center">{{ $data[$i]->tgl25 }}</td>
                <td class="center">{{ $data[$i]->tgl26 }}</td>
                <td class="center">{{ $data[$i]->tgl27 }}</td>
                <td class="center">{{ $data[$i]->tgl28 }}</td>
                <td class="center">{{ $data[$i]->tgl29 }}</td>
                <td class="center">{{ $data[$i]->tgl30 }}</td>
                <td class="center">{{ $data[$i]->tgl31 }}</td>
                <td class="right">{{ number_format($data[$i]->snn,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->sls,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->rbu,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->kms,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->jmt,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->sbt,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->mng,0,".",",") }}</td>
                <td class="right">{{ number_format($data[$i]->jwpb,0,".",",") }}</td>
                <td class="right">{{ $cp_hrk1 }}</td>
                <td class="right">{{ $cp_hrk2 }}</td>
                <td class="right">{{ $cp_hrk3 }}</td>
                <td class="right">{{ $cp_hrk4 }}</td>
                <td class="right">{{ $cp_hrk5 }}</td>
                <td class="right">{{ $cp_hrk6 }}</td>
                <td class="right">{{ $cp_hrk7 }}</td>
                <td class="right">{{ $cf_jadwal }}</td>
            </tr>
            @php
                $tempSupplier = $data[$i]->sup_kodesupplier;
            @endphp

        @endfor
        <tr style="border-top: solid 1px black">
            <th class="left" colspan="4">GRAND TOTAL</th>
            <th class="center">{{ $sum_tgl01 }}</th>
            <th class="center">{{ $sum_tgl02 }}</th>
            <th class="center">{{ $sum_tgl03 }}</th>
            <th class="center">{{ $sum_tgl04 }}</th>
            <th class="center">{{ $sum_tgl05 }}</th>
            <th class="center">{{ $sum_tgl06 }}</th>
            <th class="center">{{ $sum_tgl07 }}</th>
            <th class="center">{{ $sum_tgl08 }}</th>
            <th class="center">{{ $sum_tgl09 }}</th>
            <th class="center">{{ $sum_tgl10 }}</th>
            <th class="center">{{ $sum_tgl11 }}</th>
            <th class="center">{{ $sum_tgl12 }}</th>
            <th class="center">{{ $sum_tgl13 }}</th>
            <th class="center">{{ $sum_tgl14 }}</th>
            <th class="center">{{ $sum_tgl15 }}</th>
            <th class="center">{{ $sum_tgl16 }}</th>
            <th class="center">{{ $sum_tgl17 }}</th>
            <th class="center">{{ $sum_tgl18 }}</th>
            <th class="center">{{ $sum_tgl19 }}</th>
            <th class="center">{{ $sum_tgl20 }}</th>
            <th class="center">{{ $sum_tgl21 }}</th>
            <th class="center">{{ $sum_tgl22 }}</th>
            <th class="center">{{ $sum_tgl23 }}</th>
            <th class="center">{{ $sum_tgl24 }}</th>
            <th class="center">{{ $sum_tgl25 }}</th>
            <th class="center">{{ $sum_tgl26 }}</th>
            <th class="center">{{ $sum_tgl27 }}</th>
            <th class="center">{{ $sum_tgl28 }}</th>
            <th class="center">{{ $sum_tgl29 }}</th>
            <th class="center">{{ $sum_tgl30 }}</th>
            <th class="center">{{ $sum_tgl31 }}</th>
            <th class="right">{{ number_format($sum_snn,0,".",",") }}</th>
            <th class="right">{{ number_format($sum_sls,0,".",",") }}</th>
            <th class="right">{{ number_format($sum_rbu,0,".",",") }}</th>
            <th class="right">{{ number_format($sum_kms,0,".",",") }}</th>
            <th class="right">{{ number_format($sum_jmt,0,".",",") }}</th>
            <th class="right">{{ number_format($sum_sbt,0,".",",") }}</th>
            <th class="right">{{ number_format($sum_mng,0,".",",") }}</th>
            <th class="right" colspan="9"></th>
        </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
@endsection
