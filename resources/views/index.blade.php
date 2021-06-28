@extends('navbar')
@section('title','IAS')

@section('content')
    <link href={{asset('flappy/css/reset.css')}} rel="stylesheet">
    <link href={{asset('flappy/css/main.css')}} rel="stylesheet">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <h5 class="mb-4">PROCEDURE YANG DIPAKAI DALAM MENU MIGRASI IAS</h5>
                        <p><a href="{{url('file_procedure/sp_aktifkan_harga_allitem.txt')}}" target="_blank">MASTER - AKTIFKAN ALL HARGA JUAL->
                                PROCEDURE SP_AKTIFKAN_HARGA_ALLITEM</a></p>
                        <p><a href="{{url('file_procedure/sp_aktifkan_harga_peritem.txt')}}" target="_blank">MASTER - AKTIFKAN HARGA JUAL ->
                                PROCEDURE SP_AKTIFKAN_HARGA_PERITEM</a></p>
                        <p><a href="{{url('file_procedure/sp_trf_cmo_cabang_web.txt')}}" target="_blank">MASTER - CABANG ->
                                PROCEDURE SP_TRF_CMO_CABANG_WEB</a></p>
                        <p><a href="{{url('file_procedure/sp_download_customer_mktho_web.txt')}}" target="_blank">MASTER - MEMBER ->
                                PROCEDURE SP_DOWNLOAD_CUSTOMER_MKTHO_WEB</a></p>
                    </div>
                </div>
            </div>
        </div>

        {{--        <fieldset class="card border-dark">--}}
        {{--            <legend class="w-auto ml-5" >SESSION</legend>--}}
        {{--            <div class="card-body cardForm ">--}}
        {{--                <div class="row">--}}
        {{--                    <div class="col-sm-12">--}}
        {{--                        <form class="form">--}}
        {{--                            <div class="form-group row mb-0 justify-content-center">--}}
        {{--                                <marquee behavior="Alternate" scrolldelay="20">--}}
        {{--                                @php--}}
        {{--                                    echo ' kdigr = '.$_SESSION['kdigr'].'<br>';--}}
        {{--                                    echo ' usid  = '.$_SESSION['usid'].'<br>';--}}
        {{--                                    echo ' un    = '.$_SESSION['un'].'<br>';--}}
        {{--                                    echo ' eml   = '.$_SESSION['eml'].'<br>';--}}
        {{--                                    echo ' rptname = '.$_SESSION['rptname'].'<br>';--}}
        {{--                                    echo ' ip = '.$_SESSION['ip'].'<br>';--}}
        {{--                                    echo ' id = '.$_SESSION['id'].'<br>';--}}
        {{--                                    echo ' ppn = '.$_SESSION['ppn'].'<br>';--}}
        {{--                                @endphp--}}
        {{--                                </marquee>--}}
        {{--                            </div>--}}
        {{--                        </form>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </fieldset>--}}
    </div>


    <br>
    <br>
    <br>
    <div class="container-fluid">
        <div id="gamecontainer">
            <div id="gamescreen">
                <div id="sky" class="animated">
                    <div id="flyarea">
                        <div id="ceiling" class="animated"></div>
                        <!-- This is the flying and pipe area container -->
                        <div id="player" class="bird animated"></div>
                        <div id="bigscore"></div>
                        <div id="splash"></div>
                        <div id="scoreboard">
                            <div id="medal"></div>
                            <div id="currentscore"></div>
                            <div id="highscore"></div>
                            <div id="replay"><img src="assets/replay.png" alt="replay"></div>
                        </div>

                        <!-- Pipes go here! -->
                    </div>
                </div>
                <div id="land" class="animated">
                    <div id="debug"></div>
                </div>
            </div>
        </div>
    </div>



    <script>

    </script>
    <script src={{asset('flappy/js/jquery.min.js')}}></script>
{{--    <script src={{asset('flappy/js/jquery.transit.min.js')}}></script>--}}
{{--    <script src={{asset('flappy/js/buzz.min.js')}}></script>--}}
{{--    <script src={{asset('flappy/js/main.js')}}></script>--}}
@endsection
