@extends('navbar')
@section('title','IAS')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <img src="{{asset('image/Indogrosir_logo.jpg')}}" width="75%">

        </div>
        <div class="row justify-content-center">
            <p>
                <i>“Pekerjaan akan terasa mudah, APABILA tidak dikerjakan atau dikerjakan orang lain. :)” - <b>Alan N. A. N.</b></i>
                <br>
                <marquee behavior="Alternate"  direction="right" scrollamount="100">
                    Biar mangat HEHE
                </marquee>
            </p>
        </div>

        <div class="row justify-content-center">
            <h3>Halo, <b> <label id="username">{{$_SESSION['un']}}</label></b></h3>
            <br>
        </div>
        <div class="row justify-content-center">
            <h5>Selamat datang di {{strtoupper($_SESSION['rptname'])}}</h5>
            <br>
        </div>
        <div class="row justify-content-center"><br></div>
        <div class="row justify-content-center"><br></div>

        <fieldset class="card border-dark">
            <legend class="w-auto ml-5" >SESSION</legend>
            <div class="card-body cardForm ">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form">
                            <div class="form-group row mb-0 justify-content-center">
                                <marquee behavior="Alternate" scrolldelay="20">
                                @php
                                    echo ' kdigr = '.$_SESSION['kdigr'].'<br>';
                                    echo ' usid  = '.$_SESSION['usid'].'<br>';
                                    echo ' un    = '.$_SESSION['un'].'<br>';
                                    echo ' eml   = '.$_SESSION['eml'].'<br>';
                                    echo ' rptname = '.$_SESSION['rptname'].'<br>';
                                    echo ' ip = '.$_SESSION['ip'].'<br>';
                                    echo ' id = '.$_SESSION['id'].'<br>';
                                    echo ' ppn = '.$_SESSION['ppn'].'<br>';
                                @endphp
                                </marquee>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </fieldset>




        <br>
        <div style="font-family: Arial, Helvetica, sans-serif">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati, temporibus, vitae. Ad alias aliquam, blanditiis delectus dicta distinctio doloremque dolores eius, fugiat inventore laboriosam minima, mollitia nemo quis vitae voluptatem.</p>
        </div>

        <br>
        <div style="font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Obcaecati, temporibus, vitae. Ad alias aliquam, blanditiis delectus dicta distinctio doloremque dolores eius, fugiat inventore laboriosam minima, mollitia nemo quis vitae voluptatem.</p>
        </div>

        <script>
            $(document).ready(function () {
                username = $('#username').html();
                username = username.split('');
                console.log(username);
            });


            usr = '';
            i=0;
            var interval = setInterval(function () {

                if(i==username.length){
                    usr ='';
                    i=0;
                }
                usr=usr+username[i];
                $('#username').text(usr);
                i++;
            }, 500);
        </script>
@endsection
