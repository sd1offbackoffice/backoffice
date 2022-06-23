@extends('navbar')
@section('title','Signature')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card border-dark">
                <div class="card-body cardForm">
                    <div class="row justify-content-center">
                        <button class="btn btn-primary row-sm-12 d-block" onclick="showOtorisasi()">Update Signature</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <fieldset class="card border-dark">
                <legend class="w-auto ml-5">Signatures</legend>
                <div class="card-body cardForm">
                    <div class="container" id="img-data" style="text-align:center">
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<div class="modal fade" id="m_signature" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sign Here : </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="containertable" style="text-align:center">
                        <table class="table-borderless">
                            <tbody>
                                <tr>
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <label for="nama_personil4">LJM</label>
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group mb">
                                                <input autocomplete="off" type="text" id="nama_personil4" class="form-control">
                                                <button id="showUserBtn" class="btn btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showUser(3)" placeholder="Mohon isi nama pejabat">&#x1F50E;</button>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <br>
                                </tr>
                                <tr>
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <label for="nama_personil2">KEPALA GUDANG</label>
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group mb">
                                                <input autocomplete="off" type="text" id="nama_personil2" class="form-control">
                                                <button id="showUserBtn" class="btn btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showUser(1)" placeholder="Mohon isi nama pejabat">&#x1F50E;</button>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <tr>
                                    <br>
                                </tr>
                                <tr>
                                    <div class="row align-items-center">
                                        <div class="col-3">
                                            <label for="nama_personil3">ADMINISTRASI</label>
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group mb">
                                                <input autocomplete="off" type="text" id="nama_personil3" class="form-control">
                                                <button id="showUserBtn" class="btn btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showUser(2)" placeholder="Mohon isi nama pejabat">&#x1F50E;</button>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="space"></div>
                    <div class="row">
                        <div class="col">
                            <div class="containername" style="text-align:center">
                                <p><b>LJM</b></p>
                            </div>
                            <span class="space"></span>
                            <div class="containersig" style="text-align:center">
                                <div id="sig4"></div>
                            </div>
                            <span class="space"></span>
                            <div class="containername" style="text-align:center">
                                <p style="float: left"><b>KEPALA GUDANG</b></p>
                                <p style="float: right"><b>ADMINISTRASI</b></p>
                            </div>
                            <span class="space"></span>
                            <div class="containersig" style="text-align:center">
                                <div id="sig2"></div>
                                <span class="space"></span>
                                <div id="sig3"></div>
                            </div>
                            <span class="space"></span>
                            <div class="form-group row mb-0" style="margin-left: 25%">
                                <button id="clear3" class="btn btn-danger btn-lg mr-3">Clear LJM</button>
                                <button id="clear" class="btn btn-danger btn-lg mr-3">Clear Kepala Gudang</button>
                                <button id="clear2" class="btn btn-danger btn-lg mr-3">Clear Administrasi</button>
                            </div>
                            <div class="container" style="margin-left: 35%; margin-top: 10%; max-width: 30%">
                                <button id="save" class="btn btn-success btn-lg btn-block">Simpan</button>
                            </div>
                            <textarea id="signature64_2" name="signed" style="display: none; height: 100%"></textarea>
                            <textarea id="signature64_3" name="signed" style="display: none; height: 100%"></textarea>
                            <textarea id="signature64_4" name="signed" style="display: none; height: 100%"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <label for="">Save -> Enter</label>
                <label for="">/</label>
                <label for="">Clear -> Space</label>
            </div>
        </div>
    </div>
</div>

<!-- Personil Modal -->
<div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="modalHelpTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <table class="table table-borderless" id="tableModalHelp">
                                <thead class="theadDataTables">
                                    <tr>
                                        <th id="modalThName1"></th>
                                        <th id="modalThName2"></th>
                                        <th id="modalThName3"></th>
                                        <th id="modalThName4"></th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyModalHelp"></tbody>
                            </table>
                            <p class="text-hide" id="idModal"></p>
                            <p class="text-hide" id="idRow"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Personil Modal -->

<!-- Access Modal -->
<div class="modal fade" id="lotorisasiModal" tabindex="-1" role="dialog" aria-labelledby="lotorisasiModalTitle" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <legend class="w-auto ml-5">Otorisasi Ubah Tanda Tangan</legend>
                <div class="form-group">
                    <label for="otoUser">User</label>
                    <input type="text" class="form-control" id="otoUser" aria-describedby="emailHelp" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="otoPass">Password</label>
                    <input type="password" class="form-control" id="otoPass">
                </div>
                <div style="text-align: center;">
                    <button type="button" onclick="otorisasi()" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Access Modal -->

<style>
    .space {
        padding: 3rem;
    }

    .kbw-signature {
        width: 400px;
        height: 350px;
    }

    .containertable {
        margin-left: 25%;
    }

    .containername {
        margin-bottom: 1rem;
        margin-left: 20%;
        margin-right: 20%;
    }

    .containerbtn {
        margin-top: 1rem;
        margin-left: 20%;
        margin-right: 20%;
    }

    #sig canvas,
    #sig2 canvas,
    #sig3 canvas,
    #sig4 canvas {
        width: 100%;
        height: auto;
    }

    .modalRowNames1,
    .modalRowNames2,
    .modalRowNames3 {
        cursor: pointer;
    }

    .modalRowNames1:hover,
    .modalRowNames2:hover,
    .modalRowNames2:hover {
        background-color: #e9ecef;
    }
</style>
<script>
    let modalHelpTitle = $('#modalHelpTitle')
    let modalThName1 = $('#modalThName1');
    let modalThName2 = $('#modalThName2');
    let modalThName3 = $('#modalThName3');
    let modalThName4 = $('#modalThName4');
    let modalHelp = $('#modalHelp');
    let tableModalHelp = $('#tableModalHelp').DataTable();
    let nama_personil2 = $('#nama_personil2');
    let nama_personil3 = $('#nama_personil3');
    let nama_personil4 = $('#nama_personil4');
    let otoUser = $('#otoUser');
    let otoPass = $('#otoPass');
    let lotorisasiModal = $('#lotorisasiModal');

    $(document).ready(function() {
        getAllData();
    });
    var sig2 = $('#sig2').signature({
        syncField: '#signature64_2',
        syncFormat: 'PNG'
    });
    var sig3 = $('#sig3').signature({
        syncField: '#signature64_3',
        syncFormat: 'PNG'
    });
    var sig4 = $('#sig4').signature({
        syncField: '#signature64_4',
        syncFormat: 'PNG'
    });
    $('#save').click(function(e) {
        swal({
            title: 'Peringatan',
            text: 'Dengan menekan tombol simpan anda akan menggantikan data tanda tangan yang lama, apakah anda yakin?',
            icon: 'warning',
            buttons: true,
        }).then((confirm) => {
            if (confirm) {
                var dataURL2 = $('#sig2').signature('toDataURL', 'image/jpeg', 0.8);
                var dataURL3 = $('#sig3').signature('toDataURL', 'image/jpeg', 0.8);
                var dataURL4 = $('#sig4').signature('toDataURL', 'image/jpeg', 0.8);
                var signsrclerk = $('#nama_personil2').val();
                var signclerk = $('#nama_personil3').val();
                var signljm = $('#nama_personil4').val();
                ajaxSetup();
                $.ajax({
                    type: "POST",
                    url: '{{ url()->current() }}/save',
                    data: {
                        sign2: dataURL2,
                        signed2: $('#signature64_2').val(),
                        sign3: dataURL3,
                        signed3: $('#signature64_3').val(),
                        sign4: dataURL4,
                        signed4: $('#signature64_4').val(),
                        signljm: signljm,
                        signsrclerk: signsrclerk,
                        signclerk: signclerk
                    },
                    beforeSend: function() {
                        $('#modal-loader').modal('show');
                    },
                    success: function(response) {
                        console.log(response)
                        if (response.status == 'error') {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: 'Terjadi Kesalahan',
                                icon: 'error',
                            });
                        } else {
                            swal({
                                title: response.message,
                                icon: 'success'
                            }).then(function(ok) {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.message,
                            icon: 'error',
                        }).then(() => {
                            $('#modal-loader').modal('hide');
                        });
                    },
                })
            } else {
                $('#modal-loader').modal('hide');
                console.log('Cancelled')
            }
        });
    });
    $('#clear').click(function(e) {
        e.preventDefault();
        sig2.signature('clear');
        $("#signature64_2").val('');
    });

    $('#clear2').click(function(e) {
        e.preventDefault();
        sig3.signature('clear');
        $("#signature64_3").val('');
    });

    $('#clear3').click(function(e) {
        e.preventDefault();
        sig4.signature('clear');
        $("#signature64_4").val('');
    });

    function showModal() {
        $('#m_signature').modal({
            backdrop: 'static',
            keyboard: false
        });
    }

    function showOtorisasi() {
        $('#lotorisasiModal').modal({
            keyboard: false
        });
    }

    function otorisasi() {
        ajaxSetup();
        $.ajax({
            url: '{{ url()->current() }}/otorisasi',
            type: 'get',
            data: {
                otoUser: otoUser.val(),
                otoPass: otoPass.val(),
            },
            success: function(result) {
                if (result.kode == 0) {
                    lotorisasiModal.modal('hide')
                    swal({
                        icon: 'success',
                        title: 'Otorisasi Sukses',
                        text: result.msg,
                        timer: 2000
                    });
                    showModal();
                } else {
                    lotorisasiModal.modal('hide')
                    swal({
                        icon: 'warning',
                        title: 'Otorisasi Gagal',
                        text: result.msg,
                        timer: 2000
                    });
                }
            },
            error: function(error) {
                lotorisasiModal.modal('hide')
                swal({
                    icon: 'warning',
                    title: 'Otorisasi Gagal',
                    text: error,
                    timer: 2000
                });
                console.log(error)
            }
        });
    }

    function showUser(n) {
        try {
            modalHelp.modal('show');
            modalHelpTitle.text("Daftar Nama");
            modalThName1.text('Id');
            modalThName2.text('Level');
            modalThName3.text('Nama');
            modalThName3.show();
            modalThName4.hide();
        } catch (e) {
            swal({
                icon: 'info',
                title: 'Data Sama',
                text: 'Data Tidak Ditemukan!',
                timer: 2000
            });
        }

        tableModalHelp.clear().destroy();
        tableModalHelp = $('#tableModalHelp').DataTable({
            ajax: '{{ url()->current() }}/users',
            responsive: true,
            paging: true,
            ordering: true,
            paging: true,
            autoWidth: false,
            columns: [{
                    data: 'userid',
                    name: 'Id'
                },
                {
                    data: 'userlevel',
                    name: 'Level'
                },
                {
                    data: 'username',
                    name: 'Nama'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('modalRowNames' + n);
            },
            "order": []
        });
    }

    $(document).on('click', '.modalRowNames1', function() {
        let currentButton = $(this);
        let userid = currentButton.children().first().text();
        let userlevel = currentButton.children().first().next().text();
        let username = currentButton.children().first().next().next().text();
        nama_personil2.val(username);
        modalHelp.modal('hide');
    });

    $(document).on('click', '.modalRowNames2', function() {
        let currentButton = $(this);
        let userid = currentButton.children().first().text();
        let userlevel = currentButton.children().first().next().text();
        let username = currentButton.children().first().next().next().text();
        nama_personil3.val(username);
        modalHelp.modal('hide');
    });

    $(document).on('click', '.modalRowNames3', function() {
        let currentButton = $(this);
        let userid = currentButton.children().first().text();
        let userlevel = currentButton.children().first().next().text();
        let username = currentButton.children().first().next().next().text();
        nama_personil4.val(username);
        modalHelp.modal('hide');
    });

    function getAllData() {
        $.ajax({
            type: "GET",
            url: '{{ url()->current() }}/getName',
            beforeSend: function() {
                $('#modal-loader').modal('show');
            },
            success: function(response) {
                var clerkname = response.name[0];
                var srclerkname = response.name[2];
                var ljmname = response.name[1];
                $.ajax({
                    type: "GET",
                    url: '{{ url()->current() }}/get',
                    beforeSend: function() {
                        $('#modal-loader').modal('show');
                    },
                    success: function(response) {
                        console.log(response);
                        $('#modal-loader').modal('hide');
                        $('#img-data').empty();
                        $('#img-data').append(`
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td><img style="text-align: center;" src="../../../../storage/signature/` + response.data[1] + '?' + Math.random() + `"></td>
                                </tr>
                                <tr>
                                    <td><p><b>` + ljmname + `</b></p></td>
                                </tr>
                                <tr>
                                    <td><p><b>LJM</b></p></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td><img  src="../../../../storage/signature/` + response.data[2] + '?' + Math.random() + `"></td>
                                    <td><img src="../../../../storage/signature/` + response.data[0] + '?' + Math.random() + `"></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td><p margin-left: 20%;"><b>` + srclerkname + `</b></p></td>
                                    <td><p margin-right: 20%;"><b>` + clerkname + `</b></p></td>
                                </tr>
                                <tr>
                                    <td><p margin-left: 20%;"><b>KEPALA GUDANG</b></p></td>
                                    <td><p margin-right: 20%;"><b>ADMINISTRASI</b></p></td>
                                </tr>
                            </tbody>
                        </table>
                    `);
                    },
                    error: function(error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.message,
                            icon: 'error',
                        }).then(() => {
                            $('#modal-loader').modal('hide');
                        });
                    },
                })
            },
            error: function(error) {
                $('#modal-loader').modal('hide');
                swal({
                    title: error.message,
                    icon: 'error',
                }).then(() => {
                    $('#modal-loader').modal('hide');
                });
            },
        })
    }
</script>

@endsection