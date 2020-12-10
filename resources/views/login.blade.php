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
<link href="{{ asset('css/stylee.css') }}" rel="stylesheet">

<script src={{asset('/js/jquery.js')}}></script>
<script src={{asset('/js/moment.min.js')}}></script>
<script src={{asset('/js/bootstrap.bundle.js')}}></script>
<script src={{asset('/js/script.js')}}></script>
<script src={{asset('/js/sweetalert.js')}}></script>

<div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" style="vertical-align: middle;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="loader" id="loader"></div>
                        <div class="col-sm-12 text-center">
                            <label for="">LOADING...</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<title>{{$prs->prs_namacabang}}</title>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
            {{--<form class="login100-form validate-form flex-sb flex-w">--}}
            <span class="login100-form-title p-b-32 text-center">
						Login BACKOFFICE

					</span>

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

        if (username == '') {
            $('#lbl-validate-password').text('');
            $('#lbl-validate-username').text('Username Belum Diisi!');
            $('#username').select();
        }
        else if (password == '') {
            $('#lbl-validate-username').text('');
            $('#lbl-validate-password').text('Password Belum Diisi!');
            $('#password').select();
        }
        else {
            $('#lbl-validate-password').text('');
            $('#lbl-validate-username').text('');

            $.ajax({
                url: '/BackOffice/public/api/login',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", username: username, password: password},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    if (response['message']) {
                        swal({
                            title:  response['status'],
                            text: response['message'],
                            icon:  response['status']
                        }).then(function () {
                            clear();
                        });
                    }
                    else if (response['userstatus'] == 'ADM') {
                        swal({
                            text: 'Login sebagai Admin',
                            icon: 'info'
                        }).then((createData) => {
                            clear();
                            window.location.replace("{{url("/")}}");
                        });
                    }
                    else if (response['userstatus'] != 'ADM') {
                        swal({
                            text: 'Login sebagai User',
                            icon: 'info'
                        }).then((createData) => {
                            clear();
                            window.location.replace("{{url("/")}}");

                        });
                    }
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });
        }
    });

    $('#btn-insert').on('click', function () {

            $.ajax({
                url: '/BackOffice/public/api/insertip',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}"},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                        swal({
                            text: response['message'],
                            icon: response['status']
                        }).then((createData) => {
                        });
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });

    });

    var name = "DENNI AFREDO SURYONO HARTANU";
    var nik = "2015133629";
    var phoneNumber = "089653485351";
    var nama_atasan = "ANDY JAYA";
    var nik_atasan = "2007004011";
    var phoneNumber_atasan = "087878300086";
    var dataJawaban1 = "TIDAK";
    var dataJawaban1a = "";
    var dataJawaban2 = "TIDAK";
    var dataJawaban3 = "TIDAK";
    var dataJawaban4 = "TIDAK";
    var dataJawaban5a = "TIDAK";
    var dataJawaban5b = "TIDAK";
    var dataJawaban5c = "TIDAK";
    var dataJawaban5d = "TIDAK";
    var dataJawaban5e = "TIDAK";
    var dataJawaban5f = "TIDAK";
    var dataJawaban5g = "TIDAK";
    var dataJawaban5h = "TIDAK";
    var dataJawaban5i = "TIDAK";
    var dataJawaban5j = "TIDAK";
    var dataJawaban5k = "TIDAK";
    var dataJawaban5l = "TIDAK";
    var dataJawaban5m = "TIDAK";
    var dataJawaban5n = "TIDAK";
    var dataJawaban5o = "TIDAK";
    var dataJawaban6 = "TIDAK";
    var dataJawaban7a = null;
    var dataJawaban7b = null;
    var dataJawaban8 = null;
    var dataJawaban8a = null;

    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: 'https://hrindomaret.com/api/covidform/insert',
        data: {
            nama: name,
            nik: nik,
            nohp: phoneNumber,
            namaatasan: nama_atasan,
            nikatasan: nik_atasan,
            nohpatasan: phoneNumber_atasan,
            param1: dataJawaban1,
            ketparam1: dataJawaban1a,
            param2: dataJawaban2,
            param3: dataJawaban3,
            param4: dataJawaban4,
            param51: dataJawaban5a,
            param52: dataJawaban5b,
            param53: dataJawaban5c,
            param54: dataJawaban5d,
            param55: dataJawaban5e,
            param56: dataJawaban5f,
            param57: dataJawaban5g,
            param58: dataJawaban5h,
            param59: dataJawaban5i,
            param510: dataJawaban5j,
            param511: dataJawaban5k,
            param512: dataJawaban5l,
            param513: dataJawaban5m,
            param514: dataJawaban5n,
            param515: dataJawaban5o,
            param6: dataJawaban6,
            param71: dataJawaban7a,
            param72: dataJawaban7b,
            param8: dataJawaban8,
            ketparam8: dataJawaban8a
        },
        beforeSend: function () {
            console.log('assestment hehe');
        },
        success: function (response) {
            console.log(response);
        },
        error: function (response) {
            console.log(response);
        }
    });
</script>

