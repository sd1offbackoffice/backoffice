@extends('navbar')
@section('title','Signature')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card border-dark">
                <div class="card-body cardForm">
                    <div class="row justify-content-center">
                        <button class="btn btn-primary row-sm-12 d-block" onclick="showModal()">Update Signature</button>
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
                                            <label for="nama_personil2">Logistic Adm.Sr.Clerk</label>
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
                                            <label for="nama_personil3">Logistic Adm.Clerk</label>
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
                                <p style="float: left"><b>Logistic Adm.Sr.Clerk</b></p>
                                <p style="float: right"><b>Logistic Adm.Clerk</b></p>
                            </div>
                            <br>
                            <div class="containersig" style="text-align:center">
                                <div id="sig2"></div>
                                <span class="space"></span>
                                <div id="sig3"></div>
                            </div>
                            <div class="containerbtn" style="text-align:center">
                                <button id="clear" class="btn btn-danger btn-lg" style="float: left;">Clear Sr.Clerk</button>
                                <button id="clear2" class="btn btn-danger btn-lg" style="float: right;">Clear Clerk</button>
                            </div>
                            <div class="conatiner" style="margin-left: 35%; margin-top: 10%; max-width: 30%">
                                <button id="save" class="btn btn-success btn-lg btn-block">Simpan</button>
                            </div>
                            <textarea id="signature64_2" name="signed" style="display: none; height: 100%"></textarea>
                            <textarea id="signature64_3" name="signed" style="display: none; height: 100%"></textarea>
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
    #sig3 canvas {
        width: 100%;
        height: auto;
    }

    .modalRowNames1,
    .modalRowNames2 {
        cursor: pointer;
    }

    .modalRowNames1:hover,
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
    $(document).ready(function() {
        getAllData();
    })
    $(document).keypress(function(e) {
        if (e.keyCode == 32) {
            $('#clear').click();
            $('#clear2').click();
        } else if (e.keyCode == 13) {
            $('#save').click();
        }
    });
    var sig2 = $('#sig2').signature({
        syncField: '#signature64_2',
        syncFormat: 'PNG'
    });
    var sig3 = $('#sig3').signature({
        syncField: '#signature64_3',
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
                var signsrclerk = $('#nama_personil2').val();
                var signclerk = $('#nama_personil3').val();
                ajaxSetup();
                $.ajax({
                    type: "POST",
                    url: '{{ url()->current() }}/save',
                    data: {
                        sign2: dataURL2,
                        signed2: $('#signature64_2').val(),
                        sign3: dataURL3,
                        signed3: $('#signature64_3').val(),
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
                                // $('#clear').click();
                                // $('#modal-loader').modal('hide');
                                // $('#m_signature').modal('hide');
                                // getAllData();
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

    function showModal() {
        $('#m_signature').modal({
            backdrop: 'static',
            keyboard: false
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

    function getAllData() {
        $.ajax({
            type: "GET",
            url: '{{ url()->current() }}/getName',
            beforeSend: function() {
                $('#modal-loader').modal('show');
            },
            success: function(response) {
                var clerkname = response.name[0];
                var srclerkname = response.name[1];
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
                    <div class="containersig" style="text-align:center">
                        <img class="col-sm-3" src="../../../../storage/signature/` + response.data[1] + '?' + Math.random() + `">
                    <span class="space"></span>
                        <img class="col-sm-3" src="../../../../storage/signature/` + response.data[0] + '?' + Math.random() + `">
                    </div>
                    <div class="containername" style="text-align:center">
                    <span class="space"></span>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><p style="float: left; margin-left: 20%;"><b>` + srclerkname + `</b></p></td>
                                <td><p style="float: right; margin-right: 20%;"><b>` + clerkname + `</b></p></td>
                            </tr>
                            <tr>
                                <td><p style="float: left; margin-left: 20%;"><b>Logistik.Sr.Adm.Clerk</b></p></td>
                                <td><p style="float: right; margin-right: 20%;"><b>Logistik.Adm.Clerk</b></p></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
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