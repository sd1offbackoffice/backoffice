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
                                        <tbody id="body-table-master-user">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <label for="ket_save"></label>
                        </div>
                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <button class="btn btn-primary float-right" id="btn-update-user">SAVE
                                </button>
                            </div>
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
                                        data-target="#m_useraccess" disabled
                                        tooltip="Klik Salah satu user untuk mengaktifkan tombol!">USER ACCESS
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body shadow-lg cardForm" id="tab-master-computer">
                        <div class="row pb-1">
                            <div class="col-sm-12 text-right">
                                <button class="btn btn-success btn" id="btn-add-ip" data-toggle="modal"
                                        data-target="#m_addip">Add IP
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 p-0">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm table-striped table-bordered display compact"
                                           id="table-master-computer">
                                        <thead class="thead-dark">
                                        <tr class="thNormal text-center">
                                            <th width="40%" class="text-center small">IP</th>
                                            <th width="30%" class="text-center small">STATION</th>
                                            <th width="30%" class="text-center small">COMPUTER NAME</th>
                                        </tr>
                                        </thead>
                                        <tbody id="body-table-ip">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <label for="ket_save"></label>
                        </div>
                        <div class="row mt-2">
                            <label class="pr-2 align-middle">IP </label>
                            <input type="text" class="form-control col-sm-3 pr-2" id="ip">
                            <div class="col-sm-2">
                                <button class="btn btn-primary" id="btn-search-ip">SEARCH</button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-primary float-right" id="btn-update-ip">SAVE</button>
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
    {{--ADD IP--}}
    <div class="modal fade" id="m_addip" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Form Add IP</h4>
                </div>
                <div class="modal-body">
                    <div class="container justify-content-center">
                        <div class="row">
                            <label class="col-form-label col-sm-3 text-right">IP</label>
                            <input class="form-control col-sm-1" id="add-ip-1" type="text" maxlength="3">
                            <label class="col-form-label"> . </label>
                            <input class="form-control col-sm-1" id="add-ip-2" type="text" value="" maxlength="3">
                            <label class="col-form-label"> . </label>
                            <input class="form-control col-sm-1" id="add-ip-3" type="text" value="" maxlength="3">
                            <label class="col-form-label"> . </label>
                            <input class="form-control col-sm-1" id="add-ip-4" type="text" value="" maxlength="3">
                            <label id="validate-ip" class="col-form-label col-sm-4 text-danger"></label>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-sm-3 text-right">Station</label>
                            <input class="form-control col-sm-4" id="add-station-ip" type="text"
                                   style="text-transform: uppercase;" value="" maxlength="2">
                            <label id="validate-station" class="col-form-label col-sm-4 text-danger"></label>
                        </div>
                        <div class="row">
                            <label class="col-form-label col-sm-3 text-right">Computer Name</label>
                            <input class="form-control col-sm-4" id="add-computername" type="text"
                                   style="text-transform: uppercase;" value="" maxlength="25">
                            <label id="validate-computername" class="col-form-label col-sm-4 text-danger"></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-save-ip">SAVE</button>
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
                                    <select class="form-control" id="acc-group">

                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="card border-secondary mt-1">
                            <legend class="w-auto ml-3 h5"></legend>
                            <div class="card-body pt-1 pb-1">
                                <div class="row">
                                    <div class="col-sm-12 p-0">
                                        <div class="card-body p-0">
                                            <div class="tableFixedHeader">
                                                <table class="table table-striped table-bordered"
                                                       id="table-user-access">
                                                    <thead class="thead-dark">
                                                    <tr class="thNormal text-center">
                                                        <th width="25%" class="text-center">ACCESS CODE</th>
                                                        <th width="35%" class="text-center">ACCESS NAME</th>
                                                        <th width="10%" class="text-center">BACA</th>
                                                        <th width="10%" class="text-center">TAMBAH</th>
                                                        <th width="10%" class="text-center">KOREKSI</th>
                                                        <th width="10%" class="text-center">HAPUS</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="body-table-user-access">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btn-check-all">CHECK ALL</button>
                    <button type="button" class="btn btn-info" id="btn-uncheck-all">UNCHECK ALL</button>
                    <button type="button" class="btn btn-primary" id="btn-save-access">SAVE</button>
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
        $(document).ready(function () {

        });
        $('#ip').on('keyup', function () {
            if (jQuery.inArray($('#ip').val(), ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '.']) !== -1) {
                console.log('ok');
            }
        });

        oldDataUser = '';
        user = $('#user-id').val().toUpperCase();
        searchUser(user);

        oldDataComputer = '';
        ip = $('#ip').val();
        searchIp(ip);

        $('#tab-master-user').show();
        $('#tab-master-computer').hide();
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
            user = $('#user-id').val().toUpperCase();
            searchUser(user);
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
                    if (response['message'] != '') {
                        swal({
                            title: response['message'],
                            icon: response['status']
                        }).then((createData) => {

                        });
                    }
                    $('.baris').remove();
                    arr = [];
                    oldDataUser = response['user'];
                    $('#btn-user-access').prop('disabled', true);
                    jabatan = ['', 'Senior Manager', 'Store Manager', 'Store Operation Jr.Mgr / Mgr'];
                    appendText = '';

                    for (i = 0; i < response['user'].length; i++) {
                        if (response['user'][i].jabatan == null) {
                            response['user'][i].jabatan = 0;
                        }
                        appendText = '<tr class="baris baris-' + i + '" onclick="getDataAkses(\'baris-' + i + '\')">' +
                            '   <td class="p-0">' +
                            '      <input class="form-control" type="text" value="' + response['user'][i].userid + '" disabled>\n' +
                            '   </td>\n' +
                            '   <td class="p-0">' +
                            '      <input class="form-control" type="text" value="' + nvl(response['user'][i].username, '') + '">\n' +
                            '   </td>\n' +
                            '   <td class="p-0">\n' +
                            '      <input class="form-control" type="password"  maxlength="8" value="' + response['user'][i].userpassword + '">\n' +
                            '   </td>\n' +
                            '   <td class="p-0">\n' +
                            '      <input class="form-control" type="text" maxlength="1" value="' + nvl(response['user'][i].userlevel, '') + '">\n' +
                            '   </td>\n' +
                            '   <td class="p-0">\n' +
                            '      <input class="form-control" type="text" maxlength="3" value="' + nvl(response['user'][i].station, '') + '">\n' +
                            '   </td>\n' +
                            '   <td class="p-0">\n' +
                            '      <select class="form-control">\n';
                        for (j = 0; j < 4; j++) {
                            if (response['user'][i].jabatan == j) {
                                appendText += '<option value="' + j + '" selected>' + jabatan[response['user'][i].jabatan] + '</option>\n';
                            }
                            else {
                                appendText += '<option value="' + j + '">' + jabatan[j] + '</option>\n';
                            }
                        }
                        appendText += ' </select>\n' +
                            '   </td>\n' +
                            '   <td class="p-0">\n' +
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

        //select id kirim data ke user access
        arr = [];

        function getDataAkses(value) {
            arr = [];
            $(".baris").children('td').each(function () {
                $(this).find("input").removeAttr('style');
                $(this).find("select").removeAttr('style');
            });
            $("." + value).children('td').each(function () {
                $(this).find("input").css("background-color", "grey");
                $(this).find("select").css("background-color", "grey");
                $(this).find("input").css("color", "white");
                $(this).find("select").css("color", "white");
                arr.push($(this).find("input").val());
            });
            $('#btn-user-access').removeAttr('disabled');
        }

        function getDataUserAkses() {
            aksesgroupselected = $("#acc-group").val();
            $.ajax({
                url: '/BackOffice/public/api/admuser/userAccess',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    value: arr[0],
                    accessgroup: aksesgroupselected
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    oldDataAccess = response['access'];
                    $('.baris-acc').remove();

                    $('#m_useraccess').modal();
                    $('#acc_userid').val(arr[0]);
                    $('#acc_username').val(arr[1]);

                    $("#acc-group").children('option').each(function () {
                        $(this).remove();
                    });
                    $('#acc-group').append(
                        '<option value="" selected>All</option>'
                    );
                    for (i = 0; i < response['accessgroup'].length; i++) {
                        if (response['accessgroup'][i].accessgroup == aksesgroupselected) {
                            appendText = '<option selected value="' + response['accessgroup'][i].accessgroup + '">' + response['accessgroup'][i].accessgroup + '</option>';
                        }
                        else {
                            appendText = '<option value="' + response['accessgroup'][i].accessgroup + '">' + response['accessgroup'][i].accessgroup + '</option>';
                        }
                        $('#acc-group').append(
                            appendText
                        );
                    }
                    for (i = 0; i < response['access'].length; i++) {
                        check_baca = '';
                        check_tambah = '';
                        check_koreksi = '';
                        check_hapus = '';
                        if (response['access'][i].baca == 1) {
                            check_baca = 'checked';
                        }
                        if (response['access'][i].tambah == 1) {
                            check_tambah = 'checked';
                        }
                        if (response['access'][i].koreksi == 1) {
                            check_koreksi = 'checked';
                        }
                        if (response['access'][i].hapus == 1) {
                            check_hapus = 'checked';
                        }


                        $('#table-user-access').append(
                            '<tr class="baris-acc">\n' +
                            '    <td class="p-0">\n' +
                            '        <input class="form-control" type="text" value="' + response['access'][i].accesscode + '" disabled>\n' +
                            '    </td>\n' +
                            '    <td class="p-0">\n' +
                            '        <input class="form-control" type="text" value="' + response['access'][i].accessname + '" disabled>\n' +
                            '    </td>\n' +
                            '    <td class="p-0">\n' +
                            '        <div class="custom-control custom-checkbox text-center">\n' +
                            '            <input type="checkbox" class="custom-control-input" id="b' + response['access'][i].accesscode + '" ' + check_baca + '>\n' +
                            '            <label for="b' + response['access'][i].accesscode + '" class="custom-control-label lbl-cb"></label>\n' +
                            '        </div>\n' +
                            '    </td>\n' +
                            '    <td class="p-0">\n' +
                            '        <div class="custom-control custom-checkbox text-center">\n' +
                            '            <input type="checkbox" class="custom-control-input" id="t' + response['access'][i].accesscode + '" ' + check_tambah + '>\n' +
                            '            <label for="t' + response['access'][i].accesscode + '" class="custom-control-label lbl-cb"></label>\n' +
                            '        </div>\n' +
                            '    </td>\n' +
                            '    <td class="p-0">\n' +
                            '        <div class="custom-control custom-checkbox text-center">\n' +
                            '            <input type="checkbox" class="custom-control-input" id="k' + response['access'][i].accesscode + '" ' + check_koreksi + '>\n' +
                            '            <label for="k' + response['access'][i].accesscode + '" class="custom-control-label lbl-cb"></label>\n' +
                            '        </div>\n' +
                            '    </td>\n' +
                            '    <td class="p-0">\n' +
                            '        <div class="custom-control custom-checkbox text-center">\n' +
                            '            <input type="checkbox" class="custom-control-input" id="h' + response['access'][i].accesscode + '" ' + check_hapus + '>\n' +
                            '            <label for="h' + response['access'][i].accesscode + '" class="custom-control-label lbl-cb"></label>\n' +
                            '        </div>\n' +
                            '    </td>\n' +
                            '</tr>'
                        )
                    }
                }
                , complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });
        };

        $('#btn-user-access').on('click', function () {
            getDataUserAkses();
        });
        $('#acc-group').on('change', function () {
            getDataUserAkses();
        });
        $('#btn-check-all').on('click', function () {
            $("#body-table-user-access").find('input[type="checkbox"]').prop("checked", true);

        });
        $('#btn-uncheck-all').on('click', function () {
            $("#body-table-user-access").find('input[type="checkbox"]').prop("checked", false);

        });
        $('#btn-update-user').on('click', function () {
            i = 0;
            dataUser = {};
            dataUser.userid = [];
            dataUser.username = [];
            dataUser.password = [];
            dataUser.userlevel = [];
            dataUser.station = [];
            dataUser.jabatan = [];
            dataUser.email = [];
            data = [];
            $("#body-table-master-user").find("tr").each(function () {
                j = 0;
                vsimpan = 0;
                $(this).find("td").find(".form-control").each(function () {
                    // console.log($(this).val());
                    data[j] = $(this).val();
                    j++;
                });

                if (nvl(oldDataUser[i].username, '') != data[1] || nvl(oldDataUser[i].userpassword, '') != data[2] || nvl(oldDataUser[i].userlevel, '') != data[3] || nvl(oldDataUser[i].station, '') != data[4] || nvl(oldDataUser[i].jabatan, 0) != data[5] || nvl(oldDataUser[i].email, '') != data[6]) {
                    vsimpan = 1;
                    // console.log(nvl(oldDataUser[i].username, '') + '-' + data[1]);
                    // console.log(nvl(oldDataUser[i].userpassword, '') + '-' + data[2]);
                    // console.log(nvl(oldDataUser[i].userlevel, '') + '-' + data[3]);
                    // console.log(nvl(oldDataUser[i].station, '') + '-' + data[4]);
                    // console.log(nvl(oldDataUser[i].jabatan, 0) + '-' + data[5]);
                    // console.log(nvl(oldDataUser[i].email, '') + '-' + data[6]);
                }
                if (vsimpan == 1) {
                    dataUser.userid.push(data[0]);
                    dataUser.username.push(data[1]);
                    dataUser.password.push(data[2]);
                    dataUser.userlevel.push(data[3]);
                    dataUser.station.push(data[4]);
                    dataUser.jabatan.push(data[5]);
                    dataUser.email.push(data[6]);
                }
                i++;

            });
            swal({
                title: "Simpan Perubahan?",
                text: dataUser.userid.length + " Data Berubah.",
                icon: "info",
                buttons: true,
                dangerMode: true,
            }).then((createData) => {
                if (createData) {
                    $.ajax({
                        url: '/BackOffice/public/api/admuser/updateUser',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            value: dataUser,
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            swal({
                                title: response['message'],
                                icon: response['status']
                            }).then((createData) => {

                            });
                        }
                        , complete: function () {
                            $('#modal-loader').modal('hide');
                            $('#m_adduser').modal('hide');
                        }
                    });
                } else {
                    swal('Data Tidak Disimpan', '', 'warning');
                }
            });
            // console.log(dataUser);
        });

        $('#btn-save-access').on('click', function () {
            // value = $("#body-table-user-access").find('tr').find('td');
            dataAccess = {};
            dataAccess.accesscode = [];
            dataAccess.baca = [];
            dataAccess.tambah = [];
            dataAccess.koreksi = [];
            dataAccess.hapus = [];
            data = [];
            i = 0;
            $("#body-table-user-access").find('tr.baris-acc').each(function () {
                vbaca = 0;
                vtambah = 0;
                vkoreksi = 0;
                vhapus = 0;
                j = 0;
                vsimpan = 0;

                $(this).find('td').find('input').each(function () {
                    if ($(this)[0].type == 'text') {
                        data[j] = $(this).val();
                    }
                    else if ($(this)[0].type == 'checkbox') {
                        data[j] = $(this)[0].checked;
                    }
                    j++;

                });

                if (data[2] == true) {
                    data[2] = 1;
                }
                else {
                    data[2] = 0;
                }
                if (data[3] == true) {
                    data[3] = 1;
                }
                else {
                    data[3] = 0;
                }
                if (data[4] == true) {
                    data[4] = 1;
                }
                else {
                    data[4] = 0;
                }
                if (data[5] == true) {
                    data[5] = 1;
                }
                else {
                    data[5] = 0;
                }

                if (oldDataAccess[i].baca != data[2] || oldDataAccess[i].tambah != data[3] || oldDataAccess[i].koreksi != data[4] || oldDataAccess[i].hapus != data[5]) {
                    vsimpan = 1;
                }
                if (vsimpan == 1) {
                    dataAccess.accesscode.push(data[0]);
                    dataAccess.baca.push(data[2]);
                    dataAccess.tambah.push(data[3]);
                    dataAccess.koreksi.push(data[4]);
                    dataAccess.hapus.push(data[5]);
                }
                i++;
            });
            console.log(dataAccess);

            swal({
                title: "Simpan Perubahan?",
                icon: "info",
                buttons: true,
                dangerMode: true,
            }).then((createData) => {
                if (createData) {
                    $.ajax({
                        url: '/BackOffice/public/api/admuser/saveAccess',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            value: dataAccess,
                            userid: arr[0]
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            swal({
                                title: response['message'],
                                icon: response['status']
                            }).then((createData) => {

                            });
                        }
                        , complete: function () {
                            $('#modal-loader').modal('hide');
                            $('#m_adduser').modal('hide');
                        }
                    });
                } else {
                    swal('Data Tidak Disimpan', '', 'warning');
                }
            });
        });

        $('#ip').keypress(function (e) {
            if (e.keyCode == 13) {
                ip = $('#ip').val();
                searchIp(ip);
            }
        });
        $('#add-ip-1').on('keyup', function () {
            if($(this).val().length > 0 &&  $.isNumeric( $(this).val() ) == false){
                $('#validate-ip').text('IP harus Angka!');
                $(this).val("");
            }
            else {
                $('#validate-ip').text('');
            }
            if ($(this).val().length == 3) {
                $('#add-ip-2').focus();
            }
        });
        $('#add-ip-2').on('keyup', function () {
            if($(this).val().length > 0 &&  $.isNumeric( $(this).val() ) == false){
                $('#validate-ip').text('IP harus Angka!');
                $(this).val("");
            }
            else {
                $('#validate-ip').text('');
            }
            if ($(this).val().length == 3) {
                $('#add-ip-3').focus();
            }
        });
        $('#add-ip-3').on('keyup', function () {
            if($(this).val().length > 0 &&  $.isNumeric( $(this).val() ) == false){
                $('#validate-ip').text('IP harus Angka!');
                $(this).val("");
            }
            else {
                $('#validate-ip').text('');
            }
            if ($(this).val().length == 3) {
                $('#add-ip-4').focus();
            }
        });
        $('#add-ip-4').on('keyup', function () {
            if($(this).val().length > 0 && $.isNumeric( $(this).val() ) == false){
                $('#validate-ip').text('IP harus Angka!');
                $(this).val("");
            }
            else {
                $('#validate-ip').text('');
            }
            if ($(this).val().length == 3) {
                $('#add-station-ip').focus();
            }
        });
        $('#btn-search-ip').keypress(function (e) {
            ip = $('#ip').val();
            searchIp(ip);
        });

        function searchIp(value) {
            $.ajax({
                url: '/BackOffice/public/api/admuser/searchIp',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", value: value},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    if (response['message'] != '') {
                        swal({
                            title: response['message'],
                            icon: response['status']
                        }).then((createData) => {

                        });
                    }
                    $('.baris-computer').remove();
                    oldDataIp = response['ip'];
                    for (i = 0; i < response['ip'].length; i++) {
                        $('#table-master-computer').append('' +
                            '<tr class="baris-computer">\n' +
                            '    <td>\n' +
                            '        <input class="form-control" disabled type="text" value="' + response['ip'][i].ip + '">\n' +
                            '    </td>\n' +
                            '    <td>\n' +
                            '        <input class="form-control text-center" type="text" maxlength="2" value="' + nvl(response['ip'][i].station,'') + '">\n' +
                            '    </td>\n' +
                            '    <td>\n' +
                            '        <input class="form-control" type="text" value="' + nvl(response['ip'][i].computername,'') + '">\n' +
                            '    </td>\n' +
                            '</tr>');
                    }
                }
                , complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });

            $('#btn-save-ip').on('click', function (e) {
                valid = true;
                ip1 = $('#add-ip-1').val();
                ip2 = $('#add-ip-2').val();
                ip3 = $('#add-ip-3').val();
                ip4 = $('#add-ip-4').val();

                ip = ip1 + '.' + ip2 + '.' + ip3 + '.' + ip4;
                station = $('#add-station-ip').val();
                computername = $('#add-computername').val();

                if(  $.isNumeric( ip1 ) == false){
                    $('#validate-ip').text('IP harus Angka!');
                    $('#add-ip-1').focus();
                    valid = false;
                }
                else if(  $.isNumeric( ip2 ) == false){
                    $('#validate-ip').text('IP harus Angka!');
                    $('#add-ip-2').focus();
                    valid = false;
                }
                else if(  $.isNumeric( ip3 ) == false){
                    $('#validate-ip').text('IP harus Angka!');
                    $('#add-ip-3').focus();
                    valid = false;
                }
                else if(  $.isNumeric( ip4 ) == false){
                    $('#validate-ip').text('IP harus Angka!');
                    $('#add-ip-4').focus();
                    valid = false;
                }
                else if(station=''){
                    $('#validate-station').text('Station tidak boleh kosong!');
                    $('#add-station-ip').focus();
                    valid = false;
                }

                if (valid) {
                    $.ajax({
                        url: '/BackOffice/public/api/admuser/saveIp',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            ip: ip,
                            station: station,
                            computername: computername
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            if (response['status'] == 'error') {
                                swal({
                                    title: response['message'],
                                    icon: response['status']
                                }).then((createData) => {

                                });
                            }
                            else {
                                swal({
                                    title: response['message'],
                                    icon: response['status']
                                }).then((createData) => {
                                    $('#add-ip-1').val("");
                                    $('#add-ip-2').val("");
                                    $('#add-ip-3').val("");
                                    $('#add-ip-4').val("");
                                    $('#add-station-ip').val("");
                                    $('#add-computername').val("");
                                    $('#m_addip').modal('hide');
                                    searchIp("");

                                });
                            }

                        }
                        , complete: function () {
                            $('#modal-loader').modal('hide');
                        }
                    });
                }
            });

            $('#btn-update-ip').on('click', function () {
                i = 0;
                dataIp = {};
                dataIp.ip = [];
                dataIp.station = [];
                dataIp.computername = [];
                data = [];
                $("#body-table-ip").find("tr").each(function () {

                    j = 0;
                    vsimpan = 0;
                    $(this).find("td").find("input").each(function () {
                        data[j] = $(this).val();
                        j++;
                    });

                    if (nvl(oldDataIp[i].station, '') != data[1] || nvl(oldDataIp[i].computername, '') != data[2]) {
                        vsimpan = 1;
                        // console.log(data[0]);
                        // console.log(nvl(oldDataIp[i].station, '') + '-' + data[1]);
                        // console.log(nvl(oldDataIp[i].computername, '') + '-' + data[2]);
                        // console.log('========================================================');
                    }
                    if (vsimpan == 1) {
                        dataIp.ip.push(data[0]);
                        dataIp.station.push(data[1]);
                        dataIp.computername.push(data[2]);
                    }
                    i++;

                });
                swal({
                    title: "Simpan Perubahan?",
                    text: dataIp.ip.length + " Data Berubah.",
                    icon: "info",
                    buttons: true,
                    dangerMode: true,
                }).then((createData) => {
                    if (createData) {
                        $.ajax({
                            url: '/BackOffice/public/api/admuser/updateIp',
                            type: 'POST',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                value: dataIp,
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (response) {
                                swal({
                                    title: response['message'],
                                    icon: response['status']
                                }).then((createData) => {
                                    ip = $('#ip').val();
                                    searchIp(ip);
                                });
                            }
                            , complete: function () {
                                $('#modal-loader').modal('hide');
                            }
                        });
                    } else {
                        swal('Data Tidak Disimpan', '', 'warning');
                    }
                });
                console.log(dataIp);
            });
        }
    </script>

@endsection
