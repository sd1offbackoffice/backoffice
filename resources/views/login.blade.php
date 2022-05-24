{{--CSS LOGIN--}}
<link rel="icon" type="image/png" href="{{ asset('login_assets/images/icons/favicon.ico')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css"
      href="{{ asset('login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css"
      href="{{ asset('login_assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/animate/animate.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/util.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/main.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/stylee.css') }}" >
<link rel="stylesheet" href="{{ asset('/css/jquery-ui.css') }}">
<link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>
<link rel="stylesheet" href="{{ asset('/css/fontawesome-all.css') }}">

<script src={{asset('/js/jquery.js')}}></script>
<script src={{asset('/js/moment.min.js')}}></script>
<script src={{asset('/js/bootstrap.bundle.js')}}></script>
<script src={{asset('/js/script.js')}}></script>
<script src={{asset('/js/sweetalert.js')}}></script>

<title>{{$prs}}</title>
<div class="limiter">
    <div class="container-fluid mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-body border-dark shadow-sm">
                        <h4 class="text-dark">Rekomendasi 'Setting' Layar Untuk Menghasilkan Interface yang maximal</h4>
                        <p>* Untuk ukuran layar 1920px * 1080px dapat menggunakan browser di ukuran 80%</p>
                        <p>* Untuk ukuran layar 1360px * 768x dapat menggunakan browser di ukuran 67%</p>
                        <br>
                        <p>* Pada bagian "Scale and Layout' di 'Display Settings' dapat memilih ukuran 100% atau
                            125% </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2 mb-0">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-body border-dark shadow-sm">
                        <h4 class="text-dark">Note Buat Developer</h4>
                        <p class="text-danger">* sekarang kalo mau edit" menu bagian administration,
                            login di prod dulu ya biar ga ketiban lg datanya, thank you @Leo @Denni @Jefri @Ryan @Michele</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-login100">
        <div class="wrap-login100 p-l-85 p-r-85 p-t-40 p-b-40">
            {{--<form class="login100-form validate-form flex-sb flex-w">--}}
            <span class="login100-form-title p-b-32 text-center">
						Login BACKOFFICE
            </span>
            @if($allcabang)
                <span class="txt1 p-b-11">Cabang</span>
                <div class="wrap-input100 validate-input ">
                    <select class="input100" id="cabang" data-validate="user" style="text-transform: uppercase;"
                            required>
                        @foreach($cabang as $c)
                            <option value="{{ $c->kode }}" {{ $c->kodeigr == '22' ? 'selected' : '' }}>{{ $c->kodeigr }} - {{ strtoupper($c->namacabang) }}</option>
                        @endforeach
                    </select>
                    <span class="focus-input100"></span>
                </div>
                <br>
            @endif
            <span class="txt1 p-b-11">Koneksi</span>
            <div class="wrap-input100 validate-input ">
                <select class="input100" id="koneksi" data-validate="user" style="text-transform: uppercase;" required>
                    <option value="igr">PRODUCTION</option>
                    <option value="sim" selected>SIMULASI</option>
                </select>
                <span class="focus-input100"></span>
            </div>
            <br>
            <span class="txt1 p-b-11">
						Username
					</span>
            <div class="wrap-input100 validate-input ">
                <input class="input100" type="text" id="username" data-validate="user"
                       style="text-transform: uppercase;" required>
                <span class="focus-input100"></span>
            </div>
            <label id="lbl-validate-username" class="text-danger text-right"></label>
            <br>
            <span class="txt1 p-b-11">
						Password
					</span>
            <div class="wrap-input100 validate-input">
                <input class="input100" type="password" id="password" required>
                <span class="focus-input100"></span>
            </div>
            <label id="lbl-validate-password" class="text-danger text-right"></label>

            <div class="container-login100-form-btn justify-content-center pt-5">
                <button class="login100-form-btn" id="btn-login">
                    Login
                </button>
            </div>


            <div class="container justify-content-center pt-5">
                <label class="col-form-label" id="lbl-timer">
                    <b>Tanggal : </b><span id="lbl-tanggal"></span>
                    <br>
                    <b>Jam : </b><span id="lbl-jam"></span>
                </label>
            </div>
            <div class="container-login100-form-btn justify-content-center pt-5">
                <button class="login100-form-btn" id="btn-insert">
                    Insert IP ( jika IP belum terdaftar )
                </button>
            </div>
            {{--</form>--}}

        </div>
    </div>
    <div class="modal" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="vertical-align: middle;" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // $('#username').val('vbu');
        // $('#password').val('123');
        // $('#btn-login').click();

        var interval = setInterval(function () {
            var momentNow = moment();
            $('#lbl-tanggal').html(momentNow.format('DD-MM-YYYY'));
            $('#lbl-jam').html(momentNow.format('HH:mm:ss'));
        }, 100);

        $('#username').focus();

        @isset($msg)
        console.log('{{$msg}}');
        if ('{{ $msg }}' != '') {
            swal({
                title: '{{ $msg }}',
                icon: 'warning'
            }).then(() => {
                location.replace('{{ url('/') }}');
            });
        }
        @endisset

        isChrome = /chrom(e|ium)/.test(navigator.userAgent.toLowerCase());

        if(!isChrome){
            swal({
                title: 'Disarankan menggunakan Chrome untuk mengakses web ini!',
                icon: 'warning'
            });
        }

        $('body').scrollTop($('body').width());
    });

    $('#username').keypress(function (e) {
        if (e.which == 13) {
            $('#password').select();
        }
    });

    $('#password').keypress(function (e) {
        if (e.which == 13) {
            $('#btn-login').click();
        }
    });

    function clear() {
        $('#username').val('');
        $('#password').val('');
        $('#username').focus();
    }

    $('#btn-login').on('click', function () {
        username = $('#username').val().toUpperCase();
        password = $('#password').val();
        cabang = $('#cabang').val();
        koneksi = $('#koneksi').val();

        if (username == '') {
            $('#lbl-validate-password').text('');
            $('#lbl-validate-username').text('Username Belum Diisi!');
            $('#username').select();
        } else if (password == '') {
            $('#lbl-validate-username').text('');
            $('#lbl-validate-password').text('Password Belum Diisi!');
            $('#password').select();
        } else {
            $('#lbl-validate-password').text('');
            $('#lbl-validate-username').text('');
            ajaxSetup();

            $.ajax({
                url: '{{ url()->current() }}',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    username: username,
                    password: password,
                    cabang: cabang,
                    koneksi: koneksi
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    console.log(response);
                    if (response['message']) {
                        swal({
                            title: response['status'],
                            text: response['message'],
                            icon: response['status']
                        }).then((value) => {
                            $('#modal-loader').modal('hide');
                            if (value) {
                            }
                        });
                    } else if (response['userstatus'] == 'ADM') {
                        swal({
                            text: 'Login sebagai Admin sukses!',
                            icon: 'info'
                        }).then((value) => {
                            $('#modal-loader').modal('hide');
                            if (value) {
                                clear();
                                window.location.replace("{{url("/")}}");
                            }
                        });
                    } else if (response['userstatus'] != 'ADM') {
                        swal({
                            text: 'Login Sukses!',
                            icon: 'info'
                        }).then((value) => {
                            $('#modal-loader').modal('hide');
                            if (value) {
                                clear();
                                window.location.replace("{{url("/")}}");
                            }
                        });
                    }
                }

            });
        }
    });

    $('#btn-insert').on('click', function () {
        $.ajax({
            url: '{{ url()->current() }}/insertip',
            type: 'POST',
            data: {"_token": "{{ csrf_token() }}"},
            beforeSend: function () {
                $('#modal-loader').modal('show');
            },
            success: function (response) {
                $('#modal-loader').modal('hide');
                swal({
                    text: response['message'],
                    icon: response['status'],
                }).then((value) => {
                    console.log(value)
                    $('#modal-loader').modal('hide');
                    if (value) {
                        $('#modal-loader').modal('hide');
                    }
                });
            },
            error: function (response) {
                $('#modal-loader').modal('hide');
                errorHandlingforAjax(response);
            }
        });

    });

</script>

