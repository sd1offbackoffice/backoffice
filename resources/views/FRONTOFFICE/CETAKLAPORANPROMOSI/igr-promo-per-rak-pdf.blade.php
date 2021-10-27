@extends('html-template')

@section('table_font_size','7 px')

@section('page_title')
    LAPORAN PROMOSI PER RAK REGULER
@endsection

@section('title')
    LAPORAN PROMOSI PER RAK REGULER
@endsection

@section('content')

        @php
            $total = 0;
            $no=1;
            $temprak = '';
            $tempsubrak = '';
            $tempshelving = '';
            $tempcborgf = '';
            $temppromosi = '';
        @endphp

        @if(sizeof($data)!=0)
            @for($i=0;$i<sizeof($data);$i++)
                @if($temprak != $data[$i]->rak)
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="left" style="font-size: 10px">Rak : {{ $data[$i]->rak }}</th>
                            </tr>
                            <tr>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" class="left" width="10px">NO.</th>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" class="left">PLU</th>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" class="left">DESKRIPSI</th>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" class="left">TGL AWAL</th>
                                <th style="border-top: 1px solid black;border-bottom: 1px solid black;" class="left">TGL AKHIR</th>
                            </tr>
                            </thead>
                        @php
                            $temprak=$data[$i]->rak;
                        @endphp
                @endif
                @if($tempsubrak != $data[$i]->subrak)
                </tbody>
                    <tr>
                        <td colspan="5" class="left"><b>Sub Rak : </b> {{$data[$i]->subrak}} </td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>Shelving : </b>{{$data[$i]->shelving}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>Promosi : </b>{{$data[$i]->cborgf}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>{{$data[$i]->promosi}} - {{$data[$i]->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $tempsubrak=$data[$i]->subrak;
                        $tempshelving = $data[$i]->shelving;
                        $tempcborgf = $data[$i]->cborgf;
                        $temppromosi = $data[$i]->promosi;
                    @endphp
                @endif
                @if($tempshelving != $data[$i]->shelving)
                    <tr>
                        <td colspan="5" class="left"><b>Shelving : </b>{{$data[$i]->shelving}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>Promosi : </b>{{$data[$i]->cborgf}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>{{$data[$i]->promosi}} - {{$data[$i]->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $tempshelving = $data[$i]->shelving;
                        $tempcborgf = $data[$i]->cborgf;
                        $temppromosi = $data[$i]->promosi;
                    @endphp
                @endif
                @if($tempcborgf != $data[$i]->cborgf)
                    <tr>
                        <td colspan="5" class="left"><b>Promosi : </b>{{$data[$i]->cborgf}}</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="left"><b>{{$data[$i]->promosi}} - {{$data[$i]->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $tempcborgf = $data[$i]->cborgf;
                        $temppromosi = $data[$i]->promosi;
                    @endphp
                @endif
                @if($temppromosi != $data[$i]->promosi)
                    <tr>
                        <td colspan="5" class="left"><b>{{$data[$i]->promosi}} - {{$data[$i]->memberberlaku}} </b></td>
                    </tr>
                    @php
                        $temppromosi = $data[$i]->promosi;
                    @endphp
                @endif
                <tr>
                    <td class="left">{{ $no }}</td>
                    <td class="left">{{ $data[$i]->plu }}</td>
                    <td class="left">{{ $data[$i]->descpen}}</td>
                    <td class="left">{{ date('d/m/Y',strtotime(substr($data[$i]->cbh_tglawal,0,10))) }}</td>
                    <td class="left">{{ date('d/m/Y',strtotime(substr($data[$i]->cbh_tglakhir,0,10))) }}</td>
                </tr>
                @if( (isset($data[$i+1]->rak) && $temprak != $data[$i+1]->rak) || !isset($data[$i+1]->rak) )
                        </tbody>
                        </table>
                @endif
                @php
                    $no++;
                @endphp
            @endfor
        @else
            <p class="center"> TIDAK ADA DATA </p>
        @endif
@endsection
