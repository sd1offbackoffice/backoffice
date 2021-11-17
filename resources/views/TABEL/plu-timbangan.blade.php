@extends('navbar')
@section('title','TABEL | PLU TIMBANGAN')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card">
                    <div class="card-body pt-0">
                        <br>
                        <fieldset class="card border-dark">
                            <legend  class="w-auto ml-3">PLU TIMBANGAN</legend>
                            <div class="card-body shadow-lg cardForm">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">PLU</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input onclick="cursorMover(this)" type="text" class="form-control" id="pluPrime">
                                        <button onclick="cursorMover(this)" id="pluPrimary" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                data-target="#pluModal">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">DESKRIPSI</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="descPrime" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">SATUAN</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="satuanPrime" disabled>
                                    </div>
                                    <label class="col-sm-1 col-form-label text-right">TAG</label>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="tag" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label text-right">HRGJUAL</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="hrgJual" disabled>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="card border-dark">
                            <legend  class="w-auto ml-3">KODE TIMBANGAN</legend>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="col-sm-12 col-form-label text-center">KODE</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="kode">
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <label class="col-sm-12 col-form-label text-center">DEKSRIPSI KODE</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="descKode">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row d-flex justify-content-center">
                                    <div class="col-sm-2 text-center">
                                        <button id="save" type="button" class="btn btn-primary btn-block">Simpan</button>
                                    </div>
                                    <div class="col-sm-2 text-center">
                                        <button id="hapus" type="button" class="btn btn-danger btn-block">Hapus</button>
                                    </div>
                                </div>
                                <br>
                        </fieldset>
                        <br>
                        <fieldset class="card border-dark">
                            <legend  class="w-auto ml-3">CETAK</legend>
                            <div class="card-body shadow-lg cardForm">
                                <div class="row">
                                    <label class="col-sm-3 col-form-label text-right">URUT BERDASARKAN</label>
                                    <div class="col-sm-7 col-form-label">
                                        <input type="radio" name="optSort" value="plu" checked>
                                        <label>PLU</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="optSort" value="kodetimbangan">
                                        <label>KODE TIMBANGAN</label><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <label id="changeLabel" class="col-sm-3 col-form-label text-right">PLU</label>
                                    <div class="col-sm-3 buttonInside">
                                        <input onclick="cursorMover(this)" type="text" class="form-control" id="val1">
                                        <button onclick="cursorMover(this)" id="changeButton1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                data-target="#pluModal">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <span class="col-sm-1 text-center col-form-label">S / D</span>
                                    <div class="col-sm-3 buttonInside">
                                        <input onclick="cursorMover(this)" type="text" class="form-control" id="val2">
                                        <button onclick="cursorMover(this)" id="changeButton2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                                data-target="#pluModal">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12 d-flex justify-content-center">
                                        <button id="cetakButton" type="button" class="col-sm-2 btn btn-success btn-block">CETAK</button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <br>
                        <fieldset class="card border-dark">
                            <legend  class="w-auto ml-3">TRANSFER</legend>
                            <div class="card-body shadow-lg cardForm">
                                <div class="row">
                                    <label class="col-sm-4 col-form-label text-right">TANGGAL</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control text-center" id="daterangepicker">
                                    </div>
                                    <label class="col-sm-2 col-form-label text-left">DD / MM / YYYY</label>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12 d-flex justify-content-center">
                                        <button id="transfer" type="button" class="col-sm-2 btn btn-primary btn-block">TRANSFER</button>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </fieldset>
                        <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal--}}
    <div class="modal fade" id="pluModal" tabindex="-1" role="dialog" aria-labelledby="pluModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal PLU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="pluTable">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>PRDCD</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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

    {{--Modal Kode--}}
    <div class="modal fade" id="kodeModal" tabindex="-1" role="dialog" aria-labelledby="kodeModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal PLU</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="kodeTable">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi</th>
                                        <th>Kode</th>
                                        <th>Fraction</th>
                                        <th>Harga Jual</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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
    <script src={{asset('/js/sweetalert2.js')}}></script>
    <script>
        let modalPlu;
        let modalKode;
        let cursor;

        let ip = '';
        let usr = '';
        let pwd = '';
        let jenis_tmb = '';

        $("#daterangepicker").daterangepicker( {
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        function cursorMover(w){
            switch (w.id){
                case 'pluPrimary' :
                    cursor = 'pluPrime';
                    break;
                case 'pluPrime' :
                    cursor = 'pluPrime';
                    break;
                case 'changeButton1' :
                    cursor = 'val1';
                    break;
                case 'val1' :
                    cursor = 'val1';
                    break;
                case 'changeButton2' :
                    cursor = 'val2';
                    break;
                case 'val2' :
                    cursor = 'val2';
                    break;
            }
        }

        $(document).ready(function () {
            pluModal('');
            kodeModal('');

            startUp();
        });


        function startUp(){
            $.ajax({
                url: '{{ url()->current() }}/start',
                type: 'GET',
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if (!$.trim(response)){
                        //alert("What follows is blank: " + response);
                        if(ip == ''){
                            swal.fire({
                                title: "IP SERVER GROSIR KOSONG!",
                                text: "Isi Data IP Server Grosir Terlebih Dahulu !!",
                                icon: 'error',
                            }).then(() => {
                                location.replace("{{ url()->to('/') }}");
                                // location.replace("/BackOffice/public");
                            });
                        }
                    }
                    else{
                        ip = response.prs_ipserver;
                        usr = response.prs_userserver;
                        pwd = response.prs_pwdserver;
                        jenis_tmb = response.jenistmb;
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal.fire({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#pluPrime').select();
                    });
                }
            });
        }

        //Fungsi mengisi modal plu
        function pluModal(value) {
            modalPlu = $('#pluTable').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/plu-modal',
                    "data": {
                        'value': value
                    },
                },
                "columns": [
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'satuan', name: 'satuan', 'visible': false}, //baris ini ga ada juga tidak apa
                    {data: 'prd_kodetag', name: 'prd_kodetag', 'visible': false}, //baris ini ga ada juga tidak apa
                    {data: 'prd_hrgjual', name: 'prd_hrgjual', 'visible': false}, //baris ini ga ada juga tidak apa
                    {data: 'num', name: 'num', 'visible': false}, //baris ini ga ada juga tidak apa
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
                    $(row).addClass('pluRow');
                },
                "order": []
            });
            $('#pluTable_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    modalPlu.destroy();
                    pluModal(val);
                }
            })
        }
            //Fungsi Mengisi Modal Kode
            function kodeModal(value){
                modalKode =  $('#kodeTable').DataTable({
                    "ajax": {
                        'url' : '{{ url()->current() }}/kode-modal',
                        "data" : {
                            'value' : value
                        },
                    },
                    "columns": [
                        {data: 'tmb_deskripsi1', name: 'tmb_deskripsi1'},
                        {data: 'tmb_kode', name: 'tmb_kode'},
                        {data: 'prd_frac', name: 'prd_frac'},
                        {data: 'prd_hrgjual', name: 'prd_hrgjual'},
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
                        $(row).addClass('kodeRow');
                    },
                    "order": []
                });

            $('#kodeTable_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    modalKode.destroy();
                    kodeModal(val);
                }
            })
        }

        //    Function untuk onclick pada data modal plu
        $(document).on('click', '.pluRow', function () {
            var currentButton = $(this);
            let deskripsi = currentButton.children().first().text();
            let plu = currentButton.children().first().next().text();
            let satuan = modalPlu.row( this ).data()['satuan'];
            let tag = modalPlu.row( this ).data()['prd_kodetag'];
            let hrgJual = modalPlu.row( this ).data()['prd_hrgjual'];

            switch (cursor) {
                case 'pluPrime' :
                    $('#pluPrime').val(plu);
                    $('#descPrime').val(deskripsi);
                    $('#satuanPrime').val(satuan);
                    $('#tag').val(tag);
                    $('#hrgJual').val(hrgJual);
                    break;
                case 'val1' :
                    $('#val1').val(plu);
                    break;
                case 'val2' :
                    $('#val2').val(plu);
                    break;
            }
            $('#pluModal').modal('hide');
        });

        //    Function untuk onclick pada data modal
        $(document).on('click', '.kodeRow', function () {
            var currentButton = $(this);
            let kode = currentButton.children().first().next().text();
            let str = "" + kode;
            let pad = "0000";
            let ans = pad.substring(0, pad.length - str.length) + str;

            switch (cursor) {
                case 'val1' :
                    $('#val1').val(ans);
                    break;
                case 'val2' :
                    $('#val2').val(ans);
                    break;
            }
            $('#kodeModal').modal('hide');
        });

        $('#pluPrime').on('keypress',function(event){
            if(event.which == 13){
                let val = $('#pluPrime').val();
                if(val.substr(val.length - 1) != '1'){
                    val = val.substr(0,6)+'1';
                }
                getPLUDetail(val);
            }
        });

        $('#val1').on('keypress',function(event){
            if(event.which == 13){
                if($('input[name="optSort"]:checked').val() == "plu"){
                    getPLUDetail($('#val1').val());
                }
                if($('input[name="optSort"]:checked').val() == "kodetimbangan"){
                    getKode($('#val1').val());
                }
            }
        });
        $('#val2').on('keypress',function(event){
            if(event.which == 13){
                if($('input[name="optSort"]:checked').val() == "plu"){
                    getPLUDetail($('#val2').val());
                }
                if($('input[name="optSort"]:checked').val() == "kodetimbangan"){
                    getKode($('#val2').val());
                }
            }
        });

        function getPLUDetail(plu){
            $.ajax({
                url: '{{ url()->current() }}/get-plu',
                type: 'GET',
                data: {
                    plu: plu
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response.prd_prdcd == null){
                        swal.fire('Plu tidak dikenali','','warning');
                        switch (cursor) {
                            case 'pluPrime' :
                                $('#pluPrime').val('');
                                $('#descPrime').val('');
                                $('#satuanPrime').val('');
                                $('#tag').val('');
                                $('#hrgJual').val('');
                                break;
                            case 'val1' :
                                $('#val1').val('');
                                break;
                            case 'val2' :
                                $('#val2').val('');
                                break;
                        }
                    }else{
                        switch (cursor) {
                            case 'pluPrime' :
                                $('#pluPrime').val(response.prd_prdcd);
                                $('#descPrime').val(response.prd_deskripsipanjang);
                                $('#satuanPrime').val(response.satuan);
                                $('#tag').val(response.prd_kodetag);
                                $('#hrgJual').val(response.prd_hrgjual);
                                break;
                            case 'val1' :
                                $('#val1').val(response.prd_prdcd);
                                break;
                            case 'val2' :
                                $('#val2').val(response.prd_prdcd);
                                break;
                        }
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal.fire({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#pluPrime').select();
                    });
                }
            });
        }

        function getKode(kode){
            $.ajax({
                url: '{{ url()->current() }}/get-kode',
                type: 'GET',
                data: {
                    kode: kode
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    if(response.tmb_kode == null){
                        swal.fire('Kode tidak dikenali','','warning');
                        switch (cursor) {
                            case 'val1' :
                                $('#val1').val('');
                                break;
                            case 'val2' :
                                $('#val2').val('');
                                break;
                        }
                    }else{
                        let str = "" + kode;
                        let pad = "0000";
                        let ans = pad.substring(0, pad.length - str.length) + str;
                        switch (cursor) {
                            case 'val1' :
                                $('#val1').val(ans);
                                break;
                            case 'val2' :
                                $('#val2').val(ans);
                                break;
                        }
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal.fire({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    }).then(() => {
                        $('#pluPrime').select();
                    });
                }
            });
        }

        $('#save').on('click', function () {
            if($('#pluPrime').val() == '' || $('#pluPrime').val() == null){
                swal.fire('Plu kosong','','warning');
                $('#pluPrime').select();
            }else if($('#kode').val() == '' || $('#kode').val() == null){
                swal.fire('kode kosong','','warning');
                $('#kode').select();
            } else if($('#descKode').val() == '' || $('#descKode').val() == null){
                swal.fire('deskripsi kosong','','warning');
                $('#descKode').select();
            } else{
                $.ajax({
                    url: '{{ url()->current() }}/save',
                    type: 'GET',
                    data: {
                        kode: $('#kode').val(),
                        desk: $('#descKode').val(),
                        plu: $('#pluPrime').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if(response == 0){
                            swal.fire('Telah terjadi error!','','warning');
                        }else if(response == 1){
                            swal.fire('Kode Timbangan Sudah dipakai.','','warning');
                        }else if(response == 2){
                            swal.fire('Penyimpanan Berhasil','','success');
                        }else if(response == 3){
                            swal.fire('Perubahan Data Berhasil','','success');
                        }else{
                            swal.fire('Telah terjadi error!','','warning');
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal.fire({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {
                            $('#kode').select();
                        });
                    }
                });
            }
        });


        $('#hapus').on('click', function () {
            let lnew1 = false;
            let lnew2 = false;
            let cancel = true;

            $.ajax({ // mapping drive S dahulu
                url: '{{ url()->current() }}/check-share-directory',
                type: 'GET',
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    // if(response){
                    //     swal.fire({
                    //         title: 'PATH tidak ditemukan',
                    //         text:"path //(ip address)/share tidak ditemukan",
                    //     })
                    // }else{
                    // }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal.fire({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                }
            });

            if(jenis_tmb != 3){
                $.ajax({
                    url: '{{ url()->current() }}/check-directory',
                    type: 'GET',
                    data: {
                        path: "/LREMOTE/HAPUS.txt"
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if(response){
                            swal.fire({
                                title: 'DISPLAY PLU TIMBANGAN',
                                text:"Apakah File Hapus Plu Timbangan Mau Dihapus? / Data Di File HAPUS.TXT Ingin Digabung?",
                                showDenyButton: true,
                                confirmButtonText: `Gabung`,
                                denyButtonText: `Hapus`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    lnew1 = false;
                                } else if (result.isDenied) {
                                    lnew1 = true;
                                } else{
                                    cancel = false;
                                }
                            })
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal.fire({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                    }
                });
            }else{
                $.ajax({
                    url: '{{ url()->current() }}/check-directory',
                    type: 'GET',
                    data: {
                        path: "/LREMOTE/ISHIDA/HAPUS.txt"
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if(response){
                            swal.fire({
                                title: 'DISPLAY PLU TIMBANGAN',
                                text:"Apakah File Hapus Plu Timbangan Mau Dihapus? / Data Di File HAPUS.TXT Ingin Digabung?",
                                showDenyButton: true,
                                confirmButtonText: `Gabung`,
                                denyButtonText: `Hapus`,
                            }).then((result) => {
                                alert(result.isCancel);
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    lnew2 = false;
                                } else if (result.isDenied) {
                                    lnew2 = true;
                                }else{
                                    cancel = false;
                                }
                            })
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal.fire({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                    }
                });
            }
            if(cancel){
                $.ajax({
                    url: '{{ url()->current() }}/hapus',
                    type: 'GET',
                    data: {
                        kode: $('#kode').val(),
                        //desk: $('#descKode').val(),
                        plu: $('#pluPrime').val(),
                        jenis_tmb: jenis_tmb,
                        lnew1:lnew1,
                        lnew2:lnew2
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        swal.fire({
                            title: "PLU TIMBANGAN",
                            text: "PENGHAPUSAN BERHASIL DILAKUKAN",
                            icon: "success",
                        })
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal.fire({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        }).then(() => {
                            $('#kode').select();
                        });
                    }
                });
            }
        });

        $('#cetakButton').on('click', function () {
            //let p_ord;
            let p_pil;
            let val1 = $('#val1').val();
            let val2 = $('#val2').val();
            if($('input[name="optSort"]:checked').val() == "plu"){
                //p_ord = "ORDER BY TMB_PRDCD";
                p_pil = 1;
            }
            else if($('input[name="optSort"]:checked').val() == "kodetimbangan"){
                //p_ord = "ORDER BY TMB_KODE";
                p_pil = 2;
            }
            $.ajax({ // mapping drive S dahulu
                url: '{{ url()->current() }}/print',
                type: 'GET',
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    window.open(this.url,'_blank');
                    $('#modal-loader').modal('hide');
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal.fire({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                }
            });
        });

        $('#transfer').on('click', function () {
            let dir1 = "/LREMOTE/UPDATE.txt";
            let dir2 = "/LREMOTE/ISHIDA/UPDATE.txt";
            let dir3 = "/LREMOTE/BIZERBA/UPDATE.txt";

            let choice1 = false;
            let choice2 = false;
            let choice3 = false;
            let choice4 = false;

            let cancel = true;

            $.ajax({ // mapping drive S dahulu
                url: '{{ url()->current() }}/check-share-directory',
                type: 'GET',
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    // if(response){
                    //     swal.fire({
                    //         title: 'PATH tidak ditemukan',
                    //         text:"path //(ip address)/share tidak ditemukan",
                    //     })
                    // }else{
                    // }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal.fire({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                }
            });
            if(jenis_tmb != 3){
                $.ajax({
                    url: '{{ url()->current() }}/check-directory',
                    type: 'GET',
                    data: {
                        path: dir1
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if(response){
                            swal.fire({
                                title: 'DISPLAY PLU TIMBANGAN',
                                text:"Apakah File Transfer Ke Timbangan / (UPDATE.TXT) Mau Di Hapus ??",
                                showDenyButton: true,
                                confirmButtonText: `YA`,
                                denyButtonText: `TIDAK`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    choice1 = true;
                                } else if (result.isDenied) {
                                    choice1 = false;
                                } else{
                                    cancel = false;
                                }
                            })
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal.fire({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                    }
                });
            }else{
                $.ajax({
                    url: '{{ url()->current() }}/check-directory',
                    type: 'GET',
                    data: {
                        path: dir2
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if(response){
                            swal.fire({
                                title: 'DISPLAY PLU TIMBANGAN',
                                text:"Apakah File Transfer Ke Timbangan / (UPDATE.TXT) Mau Di Hapus ??",
                                showDenyButton: true,
                                confirmButtonText: `YA`,
                                denyButtonText: `TIDAK`,
                            }).then((result) => {
                                /* Read more about isConfirmed, isDenied below */
                                if (result.isConfirmed) {
                                    choice2 = true;

                                    $.ajax({
                                        url: '{{ url()->current() }}/check-directory',
                                        type: 'GET',
                                        data: {
                                            path: dir3
                                        },
                                        beforeSend: function () {
                                            $('#modal-loader').modal('show');
                                        },
                                        success: function (response2) {
                                            $('#modal-loader').modal('hide');
                                            if(response2){
                                                swal.fire({
                                                    title: 'DISPLAY PLU TIMBANGAN',
                                                    text:"Apakah File Transfer Ke Timbangan / (UPDATE.TXT) Mau Di Hapus ??",
                                                    showDenyButton: true,
                                                    confirmButtonText: `YA`,
                                                    denyButtonText: `TIDAK`,
                                                }).then((result2) => {
                                                    /* Read more about isConfirmed, isDenied below */
                                                    if (result2.isConfirmed) {
                                                        choice3 = true;
                                                    } else if (result2.isDenied) {
                                                        choice3 = false;
                                                    } else{
                                                        cancel = false;
                                                    }
                                                })
                                            }
                                        },
                                        error: function (error) {
                                            $('#modal-loader').modal('hide');
                                            swal.fire({
                                                title: error.responseJSON.title,
                                                text: error.responseJSON.message,
                                                icon: 'error',
                                            });
                                        }
                                    });

                                } else if (result.isDenied) {
                                    choice2 = false;
                                } else{
                                    cancel = false;
                                }
                            })
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal.fire({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                    }
                });
                if(choice2){
                    $.ajax({
                        url: '{{ url()->current() }}/check-directory',
                        type: 'GET',
                        data: {
                            path: dir3
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            if(response){
                                swal.fire({
                                    title: 'DISPLAY PLU TIMBANGAN',
                                    text:"Apakah File Transfer Ke Timbangan / (UPDATE.TXT) Mau Di Hapus ??",
                                    showDenyButton: true,
                                    confirmButtonText: `YA`,
                                    denyButtonText: `TIDAK`,
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        choice4 = true;
                                    } else if (result.isDenied) {
                                        choice4 = false;
                                    } else{
                                        cancel = false;
                                    }
                                })
                            }
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal.fire({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                        }
                    });
                }
                if(cancel){
                    let date = $('#daterangepicker').val();
                    let dateA = date.substr(0,10);
                    let dateB = date.substr(13,10);
                    dateA = dateA.split('/');
                    dateB = dateB.split('/');
                    let date1 = dateA[2]+'-'+dateA[1]+'-'+dateA[0];
                    let date2 = dateB[2]+'-'+dateB[1]+'-'+dateB[0];
                    $.ajax({
                        url: '{{ url()->current() }}/transfer',
                        type: 'GET',
                        data: {
                            date1: date1,
                            date2: date2,
                            jenis_tmb: jenis_tmb,
                            alert_button1_1:choice1,
                            alert_button1_2:choice2,
                            alert_button1_3:choice3,
                            alert_button1_4:choice4,
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            swal.fire({
                                title: "PLU TIMBANGAN",
                                text: "TRANSFER BERHASIL DILAKUKAN",
                                icon: "success",
                            })
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal.fire({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            }).then(() => {
                                $('#kode').select();
                            });
                        }
                    });
                }
            }
        });

        //Fungsi radio button
        $('input[type=radio][name=optSort]').change(function() {
            if (this.value == 'plu') {
                document.getElementById("changeLabel").innerHTML = "PLU";
                //mengganti data table menjadi tabel plu
                $('#changeButton1').attr('data-toggle', 'modal')
                    .attr('data-target', '#pluModal');
                $('#changeButton2').attr('data-toggle', 'modal')
                    .attr('data-target', '#pluModal');
            }
            else if (this.value == 'kodetimbangan') {
                document.getElementById("changeLabel").innerHTML = "KODE TIMBANGAN";
                //mengganti data table menjadi tabel kode
                $('#changeButton1').attr('data-toggle', 'modal')
                    .attr('data-target', '#kodeModal');
                $('#changeButton2').attr('data-toggle', 'modal')
                    .attr('data-target', '#kodeModal');
            }
        });
    </script>
@endsection
