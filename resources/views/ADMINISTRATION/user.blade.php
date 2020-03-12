@extends('navbar')
@section('content')


    <div class="container-fluid">
        <div class="row center">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10">
                <fieldset class="card border-secondary">
                    <legend class="w-auto ml-5">Administation User / Computer</legend>
                    <ul class="nav nav-tabs ml-2" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="btn-master-user" data-toggle="tab">Master User</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="btn-master-computer" data-toggle="tab">Master Computer</button>
                        </li>
                    </ul>

                    <div class="card-body shadow-lg cardForm" id="tab-master-user">
                        <div class="row pb-1">
                            <div class="col-sm-12 text-right">
                                <button class="btn btn-success btn" id="btn-add-user" data-toggle="modal"
                                        data-target="#m_adduser">Add User
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 p-0">
                                {{--<legend class="w-auto ml-3 h5 ">Master User</legend>--}}
                                <div class="card-body p-0 tableFixedHeader">
                                    <table class="table table-striped table-bordered"
                                           id="table-master-user">
                                        <thead class="thead-dark">
                                        <tr class="thNormal text-center">
                                            <th width="7.5%" class="text-center small">ID</th>
                                            <th width="20%" class="text-center small">User Name</th>
                                            <th width="10%" class="text-center small">Password</th>
                                            <th width="7.5%" class="text-center small">Level</th>
                                            <th width="10%" class="text-center small">Station</th>
                                            <th width="22.5%" class="text-center small">Jabatan</th>
                                            <th width="22.5%" class="text-center small">Email</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $jabatan = ['','Senior Manager','Store Manager','Store Operation Jr.Mgr / Mgr'];
                                        @endphp
                                        @foreach($user as $data)

                                            <tr class="baris">
                                                <td>
                                                    <input class="form-control" type="text" value="{{$data->userid}}"
                                                           disabled>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" value="{{$data->username}}">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="password"
                                                           value="{{$data->userpassword}}">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text"
                                                           value="{{$data->userlevel}}">
                                                </td>
                                                <td>
                                                    <input class="form-control" type="text" value="{{$data->station}}">
                                                </td>
                                                <td>
                                                    <select class="form-control">
                                                        @php if(is_null($data->jabatan)){ $data->jabatan =0;} @endphp

                                                        @for($i=0;$i<4;$i++)
                                                            @if($data->jabatan==$i)
                                                                <option value="{{$data->jabatan}}"
                                                                        selected>{{$jabatan[$data->jabatan]}}</option>
                                                            @else
                                                                <option value="{{$i}}">{{$jabatan[$i]}}</option>
                                                            @endif

                                                        @endfor
                                                    </select>
                                                </td>
                                                <td>
                                                    <input class="form-control" type="email"
                                                           value="{{$data->email}}">
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <label for="ket_save"></label>
                        </div>
                        <div class="row mt-2">
                            <label class="pt-2 col-sm-2 text-right">USER ID </label>
                            <input type="text" style="text-transform: uppercase;" class="form-control col-sm-2"
                                   id="user-id">
                            <div class="col-sm-2">
                                <button class="btn btn-primary" id="btn-search-user">SEARCH</button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-primary float-right" id="btn-user-access" data-toggle="modal"
                                        data-target="#m_useraccess">USER ACCESS
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow-lg cardForm" id="tab-master-computer">
                        <div class="row">
                            <div class="col-sm-12 p-0">
                                <div class="card-body p-1 my-custom-scrollbar table-wrapper-scroll-y">
                                    <table class="table table-sm table-striped table-bordered display compact"
                                           id="table-master-user">
                                        <thead class="thead-dark">
                                        <tr class="thNormal text-center">
                                            <th width="40%" class="text-center small">IP</th>
                                            <th width="30%" class="text-center small">STATION</th>
                                            <th width="30%" class="text-center small">COMPUTER NAME</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input class="form-control" type="text" value="192.168.153.41">
                                            </td>
                                            <td>
                                                <input class="form-control text-center" type="text" value="12">
                                            </td>
                                            <td>
                                                <input class="form-control" type="text" value="KASIR-123">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <label for="ket_save"></label>
                        </div>
                        <div class="row mt-2">
                            <label class="pr-2 align-middle">USER ID </label>
                            <input type="text" class="form-control col-sm-2 pr-2" id="computer-id">
                            <div class="col-sm-2">
                                <button class="btn btn-primary" id="btn-search-computer">SEARCH</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>



    {{--ADD USER--}}
    <div class="modal fade" id="m_adduser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Form Add User</h4>
                </div>
                <div class="modal-body">
                    <div class="container justify-content-center">
                        <div class="row">
                            <label class="col-form-label col-sm-2 text-right">ID</label>
                            <input class="form-control col-sm-2" id="add-id" type="text" value="" maxlength="3"
                                   style="text-transform: uppercase;" required>
                            <label id="validate-id-user" class="col-form-label col-sm-4 text-danger"></label>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-sm-2 text-right">Username</label>
                            <input class="form-control col-sm-5" id="add-username" type="text"
                                   style="text-transform: uppercase;" value="">
                            <label id="validate-username" class="col-form-label col-sm-4 text-danger"></label>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-sm-2 text-right">Password</label>
                            <input class="form-control col-sm-5" id="add-password" type="password" maxlength="8"
                                   value="">
                            <label id="validate-password" class="col-form-label col-sm-4 text-danger"></label>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-sm-2 text-right">Level</label>
                            <select class="form-control col-sm-2" id="add-level">
                                <option value=""></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <label id="validate-level" class="col-form-label col-sm-4 text-danger"></label>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-sm-2 text-right">Station</label>
                            <input class="form-control col-sm-2" id="add-station" type="text" maxlength="3" value="">
                        </div>
                        <div class="row">
                            <label class="col-form-label col-sm-2 text-right">Jabatan</label>
                            <select class="form-control col-sm-7" id="add-jabatan">
                                <option value=""></option>
                                <option value="1">Senior Manager</option>
                                <option value="2">Store Manager</option>
                                <option value="3">Store Operation Jr.Mgr / Mgr</option>
                            </select>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-sm-2 text-right">Email</label>
                            <input class="form-control col-sm-7" id="add-email" type="email" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-save-user">SAVE</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--USER ACCESS--}}
    <div class="modal fade" id="m_useraccess" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>User Access</h5>
                </div>
                <div class="modal-body">
                    <div class="container justify-content-center">
                        <fieldset class="card border-secondary" style="max-width: 40%">
                            <legend class="w-auto ml-3 h5">User Information</legend>
                            <div class="card-body pt-1 pb-1">
                                <div class="row">
                                    <input type="text" class="col-sm-3 form-control" id="acc_userid" value="">
                                    <input type="text" class="col-sm-9 form-control" disabled id="acc_username">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary" style="max-width: 40%">
                            <legend class="w-auto ml-3 h5">Access Group</legend>
                            <div class="card-body pt-1 pb-1">
                                <div class="row">
                                    <select class="form-control">
                                        <option value="1">Rekap</option>
                                        <option value="1">IDM</option>
                                        <option value="1">SO IC</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-1">
                            <legend class="w-auto ml-3 h5"></legend>
                            <div class="card-body pt-1 pb-1">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <div class="card-body p-0 tableFixedHeader">
                                            <table class="table table-striped table-bordered"
                                                   id="table-master-user">
                                                <thead class="thead-dark">
                                                <tr class="thNormal text-center">
                                                    <th width="25%" class="text-center">ID</th>
                                                    <th width="35%" class="text-center">User Name</th>
                                                    <th width="10%" class="text-center">BACA</th>
                                                    <th width="10%" class="text-center">TAMBAH</th>
                                                    <th width="10%" class="text-center">KOREKSI</th>
                                                    <th width="10%" class="text-center">HAPUS</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="baris">
                                                    <td class="p-0">
                                                        <input class="form-control" type="text" value="" disabled>
                                                    </td>
                                                    <td class="p-0">
                                                        <input class="form-control" type="text" value="" disabled>
                                                    </td>`
                                                    <td class="p-0">
                                                        <div class="custom-control custom-checkbox text-center">
                                                            <input type="checkbox" class="custom-control-input" id="a">
                                                            <label for="a" class="custom-control-label lbl-cb"></label>
                                                        </div>
                                                    </td>
                                                    <td class="p-0">
                                                        <div class="custom-control custom-checkbox text-center">
                                                            <input type="checkbox" class="custom-control-input" id="b">
                                                            <label for="b" class="custom-control-label lbl-cb"></label>
                                                        </div>
                                                    </td>
                                                    <td class="p-0">
                                                        <div class="custom-control custom-checkbox text-center">
                                                            <input type="checkbox" class="custom-control-input" id="c">
                                                            <label for="c" class="custom-control-label lbl-cb"></label>
                                                        </div>
                                                    </td>
                                                    <td class="p-0">
                                                        <div class="custom-control custom-checkbox text-center">
                                                            <input type="checkbox" class="custom-control-input" id="d">
                                                            <label for="d" class="custom-control-label lbl-cb"></label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-save-user">SAVE</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{--LOADER--}}
    <div class="modal fade" id="modal-loader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true" style="vertical-align: middle;">
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

    <style>


        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .active {
            background-color: white !important;
            color: black !important;

        }

        .nav .nav-item .nav-link {
            background-color: gray;
            color: white;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        .table {
            margin-bottom: 0px !important;
        }


    </style>

    <script>
        // /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/
        $(document).ready(function () {
            $('#tab-master-user').show();
            $('#tab-master-computer').hide();
            $('#m_useraccess').modal();
        });
        valid_password = false;
        $('#btn-master-user').on('click', function () {
            $('#tab-master-user').show();
            $('#tab-master-computer').hide();
        });
        $('#btn-master-computer').on('click', function () {
            $('#tab-master-user').hide();
            $('#tab-master-computer').show();
        });
        $('#btn-master-computer').on('click', function () {
            $('#tab-master-user').hide();
            $('#tab-master-computer').show();
        });
        $('#btn-search-user').on('click', function () {
            searchUser();
        });
        $('#user-id').keypress(function (e) {
            if (e.keyCode == 13) {
                user = $('#user-id').val().toUpperCase();
                searchUser(user);
            }
        });

        function searchUser(value) {
            $.ajax({
                url: '/BackOffice/public/api/admuser/searchUser',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", value: value},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    $('.baris').remove();
                    jabatan = ['', 'Senior Manager', 'Store Manager', 'Store Operation Jr.Mgr / Mgr'];
                    appendText = '';
                    for (i = 0; i < response['user'].length; i++) {
                        if (response['user'][i].jabatan == null) {
                            response['user'][i].jabatan = 0;
                        }
                        appendText = '<tr class="baris">' +
                            '   <td>' +
                            '      <input class="form-control" type="text" value="' + response['user'][i].userid + '" disabled>\n' +
                            '   </td>\n' +
                            '   <td>' +
                            '      <input class="form-control" type="text" value="' + response['user'][i].username + '">\n' +
                            '   </td>\n' +
                            '   <td>\n' +
                            '      <input class="form-control" type="password" value="' + response['user'][i].userpassword + '">\n' +
                            '   </td>\n' +
                            '   <td>\n' +
                            '      <input class="form-control" type="text" value="' + response['user'][i].userlevel + '">\n' +
                            '   </td>\n' +
                            '   <td>\n' +
                            '      <input class="form-control" type="text" value="' + nvl(response['user'][i].station, '') + '">\n' +
                            '   </td>\n' +
                            '   <td>\n' +
                            '      <select class="form-control">\n';
                        for (j = 0; j < 4; j++) {
                            if (response['user'][i].jabatan == j) {
                                appendText += '<option value="' + response['user'][i].jabatan + '" selected>' + jabatan[response['user'][i].jabatan] + '</option>\n';
                            }
                            else {
                                appendText += '<option value="' + response['user'][i].jabatan + '">' + jabatan[j] + '</option>\n';
                            }
                        }
                        appendText += ' </select>\n' +
                            '   </td>\n' +
                            '   <td>\n' +
                            '      <input class="form-control" type="email" value="' + nvl(response['user'][i].email, '') + '">\n' +
                            '   </td>' +
                            '</tr>';
                        $('#table-master-user').append(appendText);
                    }
                }
                , complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });
        }

        $('#btn-save-user').on('click', function () {
            id = $('#add-id').val().toUpperCase();
            username = $('#add-username').val().toUpperCase();
            password = $('#add-password').val();
            level = $('#add-level').val();
            station = $('#add-station').val();
            jabatan = $('#add-jabatan').val();
            email = $('#add-email').val();

            status = 1;
            if (id == '') {
                $('#validate-id-user').text("Harus diisi!");
                status = 0;
            }
            else {
                $('#validate-id-user').text("");
            }

            if (username == '') {
                $('#validate-username').text("Harus diisi!");
                status = 0;
            }
            else {
                $('#validate-username').text("");
            }

            if (password == '') {
                $('#validate-password').text("Harus diisi!");
                status = 0;
            } else {
                validatePassword();
            }

            if (level == '') {
                $('#validate-level').text("Harus diisi!");
                status = 0;
            }
            else {
                $('#validate-level').text("");
            }

            if (valid_password == true && status == 1) {
                $.ajax({
                    url: '/BackOffice/public/api/admuser/saveUser',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                        username: username,
                        password: password,
                        level: level,
                        station: station,
                        jabatan: jabatan,
                        email: email
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (response) {
                        swal({
                            title: response['message'],
                            icon: response['status']
                        }).then((createData) => {
                            $('#add-id').val("");
                            $('#add-username').val("");
                            $('#add-password').val("");
                            $('#add-level').val("");
                            $('#add-station').val("");
                            $('#add-jabatan').val("");
                            $('#add-email').val("");
                            searchUser("");
                        });

                    }
                    , complete: function () {
                        $('#modal-loader').modal('hide');
                        $('#m_adduser').modal('hide');
                    }
                });
            }
        });

        $('#add-password').on('keyup', function () {
            validatePassword();
        });

        function validatePassword() {
            valid_password = false;
            str = $('#add-password').val();
            if (str.length < 4) {
                $('#validate-password').text("Min 6 Karakter");
                valid_password = false;
            } else if (str.length > 8) {
                $('#validate-password').text("Max 8 Karakter");
                valid_password = false;
            } else if (str.search(/\d/) == -1) {
                $('#validate-password').text("Min 1 Angka");
                valid_password = false;
            } else if (str.search(/[a-z]/) == -1) {
                $('#validate-password').text("Min 1 Huruf Kecil");
                valid_password = false;
            } else if (str.search(/[A-Z]/) == -1) {
                $('#validate-password').text("Min 1 Huruf Besar");
                valid_password = false;
            } else if (str.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+]/) != -1) {
                $('#validate-password').text("Symbol Tidak Diterima");
                valid_password = false;
            }
            else if (str.search(/[@$-/:-?{-~!"^_`\[\]]/) == -1) {
                $('#validate-password').text("Min 1 Symbol");
                valid_password = false;
            } else {
                $('#validate-password').text("");
                valid_password = true;
            }
        }
    </script>

@endsection
