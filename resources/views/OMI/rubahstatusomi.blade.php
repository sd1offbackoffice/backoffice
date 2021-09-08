@extends('navbar')
@section('title','Laporan Promosi Redeem via Unique Code')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
{{--                    <legend class="w-auto ml-5 text-center">LAPORAN PROMOSI REDEEM UNIQUE CODE</legend>--}}
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Tanggal</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="daterangepicker">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Member PTKP</label>
                            <div class="col-sm-2 buttonInside" style="margin-left: -15px; margin-right: 30px">
                                <input type="text" class="form-control" id="kodePTKP">
                                <button type="button" class="btn btn-lov p-0" onclick="togglePTKP()">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <input class="col-sm-6 text-left form-control" type="text" id="namaPTKP" readonly>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Member PKP</label>
                            <div class="col-sm-2 buttonInside" style="margin-left: -15px; margin-right: 30px">
                                <input type="text" class="form-control" id="kodePKP">
                                <button type="button" class="btn btn-lov p-0" onclick="togglePKP()">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <input class="col-sm-6 text-left form-control" type="text" id="namaPKP" readonly>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Proses BKL</label>
                            <input class="col-sm-2 text-center form-control" type="text" id="prosesBKL" onkeypress="return isYT(event)" maxlength="1">
                            <label class="col-sm-2 col-form-label text-left">[Y/T]</label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Nama</label>
                            <input class="col-sm-4 text-left form-control" type="text" id="nama">
                            <label class="col-sm-3 col-form-label text-left">[Untuk Cetak FP]</label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Jabatan</label>
                            <input class="col-sm-4 text-left form-control" type="text" id="jabatan1">
                            <label class="col-sm-3 col-form-label text-left">[Untuk Cetak FP]</label>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">&nbsp;</label>
                            <input class="col-sm-4 text-left form-control" type="text" id="jabatan2">
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">No. Invoice 1</label>
                            <input class="col-sm-3 text-left form-control" type="text" id="invoice1" readonly>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">No. Invoice 2</label>
                            <input class="col-sm-3 text-left form-control" type="text" id="invoice2" readonly>
                        </div>
                        <div class="row">
                            <label class="col-sm-2 col-form-label text-right">Tanggal</label>
                            <input class="col-sm-4 text-center form-control" type="text" id="datepicker">
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary col-sm-3" type="button" id="proses" onclick="proses()">PROSES NPKP -> PKP</button>
                        </div>
                        <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal Member PTKP--}}
    <div class="modal fade" id="m_ptkp" tabindex="-1" role="dialog" aria-labelledby="m_ptkp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Member PTKP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tablePTKP">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Member</th>
                                        <th>Kode Member</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyPTKP"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    {{--Modal Member PKP--}}
    <div class="modal fade" id="m_pkp" tabindex="-1" role="dialog" aria-labelledby="m_pkp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Member PKP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tablePKP">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Member</th>
                                        <th>Kode Member</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyPKP"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <script>
        let tablePTKP;
        let tablePKP;
        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });
        $('#datepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleDatePicker: true
        });

        $(document).ready(function () {
            newFormInstance();

            getModalPTKP('');
            getModalPKP('');
        });

        function newFormInstance(){
            $.ajax({
                url: '{{ url()->current() }}/newforminstance',
                type: 'GET',
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response == 1){
                        swal({
                            title:'Alert',
                            text: 'Nomor FP Kosong !!',
                            icon:'warning',
                            timer: 2000,
                            buttons: {
                                confirm: false,
                            },
                        }).then(() => {
                            location.replace("/BackOffice/public/");
                        });
                    }else if(response == 2){
                        swal({
                            title:'Alert',
                            text: 'Nomor FP Tidak Cukup, Cadangan Nomor FP Harus 2 Nomor !!',
                            icon:'warning',
                            timer: 2000,
                            buttons: {
                                confirm: false,
                            },
                        }).then(() => {
                            location.replace("/BackOffice/public/");
                        });
                    }else{
                        $('#invoice1').val(response[0].nofp1);
                        $('#invoice2').val(response[0].nofp2);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }

        function getModalPTKP(value){
            tablePTKP =  $('#tablePTKP').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modalptkp' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'cus_namamember', name: 'cus_namamember'},
                    {data: 'cus_kodemember', name: 'cus_kodemember'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowPTKP');
                },
                columnDefs : [
                ],
                "order": []
            });

            $('#tablePTKP_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tablePTKP.destroy();
                    getModalPTKP(val);
                }
            })
        }
        function getModalPKP(value){
            tablePKP =  $('#tablePKP').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/modalpkp' }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'cus_namamember', name: 'cus_namamember'},
                    {data: 'cus_kodemember', name: 'cus_kodemember'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                    $(row).addClass('modalRowPKP');
                },
                columnDefs : [
                ],
                "order": []
            });

            $('#tablePKP_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tablePKP.destroy();
                    getModalPKP(val);
                }
            })
        }

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalRowPTKP', function () {
            let currentButton = $(this);
            let nama = currentButton.children().first().text();
            let kode = currentButton.children().first().next().text();

            $('#kodePTKP').val(kode);
            $('#namaPTKP').val(nama);
            $('#m_ptkp').modal('toggle');
        });

        //    Function untuk onclick pada data modal
        $(document).on('click', '.modalRowPKP', function () {
            let currentButton = $(this);
            let nama = currentButton.children().first().text();
            let kode = currentButton.children().first().next().text();

            $('#kodePKP').val(kode);
            $('#namaPKP').val(nama);
            $('#m_pkp').modal('toggle');
        });

        //FUNGSI MEMBER PTKP
        function togglePTKP(){
            $('#m_ptkp').modal('toggle');
        }

        $('#kodePTKP').on('change', function (e) {
            if($('#kodePTKP').val() == ''){
                $('#namaPTKP').val('');
            }else{
                choosePTKP();
            }
        });
        $('#kodePTKP').on('keypress', function (e) {
            if(e.which == 13){
                if($('#kodePTKP').val() == ''){
                    swal({
                        title:'Alert',
                        text: 'Member PTKP Tidak Boleh Kosong !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    }).then(() => {
                        $('#namaPTKP').val('');
                    });
                }else{
                    choosePTKP();
                }
            }
        });

        function choosePTKP(){
            $.ajax({
                url: '{{ url()->current() }}/chooseptkp',
                type: 'GET',
                data: {
                    kodeptkp: $('#kodePTKP').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response == '1'){
                        swal({
                            title:'Alert',
                            text: 'Kode Member Tidak Terdaftar !!',
                            icon:'warning',
                            timer: 2000,
                            buttons: {
                                confirm: false,
                            },
                        }).then(() => {
                            $('#kodePTKP').val('');
                            $('#namaPTKP').val('');
                        });
                    }else if(response == '2'){
                        swal({
                            title:'Alert',
                            text: 'Member PTKP Sudah Terdaftar Sebagai PKP !!',
                            icon:'warning',
                            timer: 2000,
                            buttons: {
                                confirm: false,
                            },
                        }).then(() => {
                            $('#kodePTKP').val('');
                            $('#namaPTKP').val('');
                        });
                    }else{
                        $('#namaPTKP').val(response);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }

        //END OF FUNGSI MEMBER PTKP

        //FUNGSI MEMBER PKP
        function togglePKP(){
            $('#m_pkp').modal('toggle');
        }

        $('#kodePKP').on('change', function (e) {
            if($('#kodePKP').val() == ''){
                $('#namaPKP').val('');
            }else if(($('#kodePKP').val() == $('#kodePTKP').val()) && $('#kodePTKP').val() != '' && $('#kodePKP').val() != ''){
                swal({
                    title:'Alert',
                    text: 'Member PTKP DAN PKP Tidak Boleh Sama !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#kodePKP').val('');
                    $('#namaPKP').val('');
                });
                return false;
            }else{
                choosePKP();
            }
        });
        $('#kodePKP').on('keypress', function (e) {
            if(e.which == 13){
                if($('#kodePTKP').val() == ''){
                    swal({
                        title:'Alert',
                        text: 'Member PTKP Tidak Boleh Kosong !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    }).then(() => {
                        $('#namaPKP').val('');
                    });
                }else if(($('#kodePKP').val() == $('#kodePTKP').val()) && $('#kodePTKP').val() != '' && $('#kodePKP').val() != ''){
                    swal({
                        title:'Alert',
                        text: 'Member PTKP DAN PKP Tidak Boleh Sama !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    }).then(() => {
                        $('#kodePKP').val('');
                        $('#namaPKP').val('');
                    });
                    return false;
                }else{
                    choosePKP();
                }
            }
        });

        function choosePKP(){
            $.ajax({
                url: '{{ url()->current() }}/choosepkp',
                type: 'GET',
                data: {
                    kodepkp: $('#kodePKP').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response == '1'){
                        swal({
                            title:'Alert',
                            text: 'Kode Member Tidak Terdaftar !!',
                            icon:'warning',
                            timer: 2000,
                            buttons: {
                                confirm: false,
                            },
                        }).then(() => {
                            $('#kodePKP').val('');
                            $('#namaPKP').val('');
                        });
                    }else if(response == '2'){
                        swal({
                            title:'Alert',
                            text: 'Member ini PTKP, Belum Terdaftar Sebagai PKP !!',
                            icon:'warning',
                            timer: 2000,
                            buttons: {
                                confirm: false,
                            },
                        }).then(() => {
                            $('#kodePKP').val('');
                            $('#namaPKP').val('');
                        });
                    }else{
                        $('#namaPKP').val(response);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }
        //END OF FUNGSI MEMBER PKP

        function isYT(evt){ //membatasi input untuk hanya boleh Y dan T, serta mendeteksi bila menekan tombol enter
            $('#prosesBKL').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 121) // y kecil
                return 89; // Y besar

            if (charCode == 116) // t kecil
                return 84; //t besar

            if (charCode == 89 || charCode == 84)
                return true
            if (charCode == 13){
                if($('#prosesBKL').val() == '') {
                    swal({
                        title:'Alert',
                        text: 'Pilihan Proses BKL adalah Y atau T !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    })
                    return false
                }
            }
            return false;
        }

        $('#nama').on('keypress', function (e) {
            if(e.which == 13){
                if($('#nama').val() == ''){
                    swal({
                        title:'Alert',
                        text: 'Nama Penanda Tangan Tidak Boleh Kosong !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    });
                }
            }
        });
        $('#jabatan1').on('keypress', function (e) {
            if(e.which == 13){
                if($('#jabatan1').val() == ''){
                    swal({
                        title:'Alert',
                        text: 'Jabatan Penanda Tangan Tidak Boleh Kosong !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    });
                }
            }
        });
        $('#jabatan2').on('keypress', function (e) {
            if(e.which == 13){
                if($('#jabatan1').val() == '' && $('#jabatan2').val() == ''){
                    swal({
                        title:'Alert',
                        text: 'Jabatan Penanda Tangan Tidak Boleh Kosong !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    });
                }
            }
        });

        function proses(){
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal({
                    title:'Alert',
                    text: 'Inputan Tanggal Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#daterangepicker').focus();
                });
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');

            if($('#kodePTKP').val() == ''){
                swal({
                    title:'Alert',
                    text: 'Member PTKP Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#kodePTKP').focus();
                });
                return false;
            }
            if($('#kodePKP').val() == ''){
                swal({
                    title:'Alert',
                    text: 'Member PKP Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#kodePTKP').focus();
                });
                return false;
            }

            if($('#kodePTKP').val() == $('#kodePKP').val()){
                swal({
                    title:'Alert',
                    text: 'Member PTKP DAN PKP Tidak Boleh Sama !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#kodePKP').focus();
                });
                return false;
            }
            //note, tidak perlu check input ptkp dan pkp, karena sudah cek waktu input

            if($('#prosesBKL').val() != 'Y' && $('#prosesBKL').val() != 'T'){
                swal({
                    title:'Alert',
                    text: 'Pilihan Proses BKL adalah Y atau T !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#prosesBKL').focus();
                });
                return false;
            }
            if($('#nama').val() == ''){
                swal({
                    title:'Alert',
                    text: 'Nama Penanda Tangan Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#nama').focus();
                });
                return false;
            }
            if($('#jabatan1').val() == ''){
                swal({
                    title:'Alert',
                    text: 'Nama Penanda Tangan Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#jabatan1').focus();
                });
                return false;
            }
            if($('#jabatan2').val() == ''){
                if($('#jabatan1').val() == ''){
                    swal({
                        title:'Alert',
                        text: 'Nama Penanda Tangan Tidak Boleh Kosong !!',
                        icon:'warning',
                        timer: 2000,
                        buttons: {
                            confirm: false,
                        },
                    }).then(() => {
                        $('#jabatan1').focus();
                    });
                    return false;
                }
            }
            date = $('#datepicker').val();
            if(date == null || date == ""){
                swal({
                    title:'Alert',
                    text: 'Tanggal FP Tidak Boleh Kosong !!',
                    icon:'warning',
                    timer: 2000,
                    buttons: {
                        confirm: false,
                    },
                }).then(() => {
                    $('#datepicker').focus();
                });
                return false;
            }
            let dateFP = date.substr(0,10);
            dateFP = dateFP.split('/').join('-');

            swal({
                title: 'Yakin Proses Member NPKP Menjadi PKP ?',
                icon: 'warning',
                buttons: {
                    yes: "Yes",
                    no: "No"
                },
            }).then(function(click){
                if(click == 'yes'){
                    //proses data
                    $.ajax({
                        url: '{{ url()->current() }}/prosesdata',
                        type: 'GET',
                        data: {
                            ptkp: $('#kodePTKP').val(),
                            pkp: $('#kodePKP').val(),
                            bkl: $('#prosesBKL').val(),
                            tglSales1:dateA,
                            tglSales2:dateB,
                            tglfp:dateFP
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            if(response.error != ''){
                                swal({
                                    title:'ALERT',
                                    text: response.error,
                                    icon:'error'
                                }).then(function(){
                                    location.replace("/BackOffice/public/");
                                })
                            }
                            if(response.cetak == 'yes'){
                                let invno1 = parseInt(response.invno1);
                                if(parseInt(response.invno1) == 0){
                                    invno1 = -1;
                                }
                                let invno2 = parseInt(response.invno1);
                                if(parseInt(response.invno2) == 0){
                                    invno2 = -1;
                                }
                                window.open(`{{ url()->current() }}/cetak?invno1=${invno1}&invno2=${invno2}&admfee=${response.admfee}&jmlstruk=${response.jmlstruk}&tglfp=${dateFP}&nama=${$('#nama').val()}&jabatan1=${$('#jabatan1').val()}&jabatan2=${$('#jabatan2').val()}`, '_blank');
                            }
                            swal({
                                title:'INFORMATION',
                                text: 'Perubahan Member PTKP '+$('#kodePTKP').val()+' Menjadi Member PKP '+$('#kodePKP').val()+' Sudah Selesai Dilakukan !!',
                                icon:'info'
                            }).then(function(){
                                //location.replace("/BackOffice/public/");
                            })
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                            return false;
                        }
                    });
                    //clear form
                }else if(click == 'no'){
                    location.replace("/BackOffice/public/");
                }
            });

            //exit form(no_validate) note, napain clear form kalau setelah yes no exit form? hahahaha
            //location.replace("/BackOffice/public/");
        }
    </script>
@endsection
