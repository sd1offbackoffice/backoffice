@extends('navbar')

@section('content')

    <h1>Halaman utama


    </h1>
    @php
        echo ' kdigr = '.$_SESSION['kdigr'].'<br>';
        echo ' usid = '.$_SESSION['usid'].'<br>';
        echo ' un = '.$_SESSION['un'].'<br>';
        echo ' pwd = '.$_SESSION['pwd'].'<br>';
        echo ' eml = '.$_SESSION['eml'].'<br>';
        echo ' rptname = '.$_SESSION['rptname'].'<br>';
        echo ' ip = '.$_SESSION['ip'].'<br>';
        echo ' ppn = '.$_SESSION['ppn'].'<br>';

    @endphp
@endsection
