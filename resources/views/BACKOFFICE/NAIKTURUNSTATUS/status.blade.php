@extends('navbar')
@section('title','PENERIMAAN | INPUT')
@section('content')

<div class="container-fluid">
    <div class="card border-dark">
        <div class="card-body cardForm">
            <fieldset class="card border-dark">
                <legend class="w-auto ml-5">Naik Status</legend>
                <div class="p-4">
                    <table class="table table-borderless" id="tableModalHelpNaik">
                        <thead class="theadDataTablesNaik">
                            <tr class="thColor">
                                <th id="modalThName1"></th>
                                <th id="modalThName2"></th>
                                <th id="modalThName3"></th>
                                <th id="modalThName4"></th>
                                <th id="modalThName5"></th>
                                <th id="modalThName6"></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyModalHelp"></tbody>
                    </table>
                </div>
                <div class="p-4">
                    <!-- <button class="btn btn-primary" id="emailBtnNaik" onclick="sendEmailNaik()" disabled>Kirim Email</button> -->
                </div>
            </fieldset>
        </div>
        <hr>
        <div class="card-body cardForm">
            <fieldset class="card border-dark">
                <legend class="w-auto ml-5">Turun Status</legend>
                <div class="p-4">
                    <table class="table table-borderless" id="tableModalHelpTurun">
                        <thead class="theadDataTablesTurun">
                            <tr class="thColor">
                                <th id="modalThName7"></th>
                                <th id="modalThName8"></th>
                                <th id="modalThName9"></th>
                                <th id="modalThName10"></th>
                                <th id="modalThName11"></th>
                            </tr>
                        </thead>
                        <tbody id="tbodyModalHelp"></tbody>
                    </table>
                </div>
                <div class="p-4">
                    <button class="btn btn-primary" id="emailBtnTurun" onclick="sendEmail()" disabled>Kirim Email</button>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<input id="pluListTurun" type="hidden"></input>
<input id="pluListNaik" type="hidden"></input>
<script>
    let currurl = '{{ url()->current() }}';
    let tableModalHelpNaik = $('#tableModalHelpNaik').DataTable();
    let tableModalHelpTurun = $('#tableModalHelpTurun').DataTable();
    let modalThName1 = $('#modalThName1');
    let modalThName2 = $('#modalThName2');
    let modalThName3 = $('#modalThName3');
    let modalThName4 = $('#modalThName4');
    let modalThName5 = $('#modalThName5');
    let modalThName6 = $('#modalThName6');
    let modalThName7 = $('#modalThName7');
    let modalThName8 = $('#modalThName8');
    let modalThName9 = $('#modalThName9');
    let modalThName10 = $('#modalThName10');
    let modalThName11 = $('#modalThName11');
    $(document).ready(function() {
        showNaik();
        showTurun();
    });

    function sendEmail() {
        $.ajax({
            url: currurl + '/sendEmailTurun',
            type: 'POST',
            data: {
                list: $('#pluListTurun').val()
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
            },
            success: function(response) {
                $('#modal-loader').modal('hide');
                if (response.kode == 1) {
                    swal({
                        title: 'Email Gagal Terkirim',
                        text: response.p_keterangan,
                        icon: 'danger'
                    })
                } else if (response.kode == 0) {
                    swal({
                        title: 'Email Terkirim',
                        text: response.p_keterangan,
                        icon: 'info'
                    })
                }
            },
            error: function(error) {
                $('#modal-loader').modal('hide');
                swal({
                    title: 'Terjadi kesalahan!',
                    text: error.responseJSON.message,
                    icon: 'error',
                });
            }
        });

        $.ajax({
            url: currurl + '/sendEmailNaik',
            type: 'POST',
            data: {
                list: $('#pluListNaik').val()
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('#modal-loader').modal('show');
            },
            success: function(response) {
                $('#modal-loader').modal('hide');
                if (response.kode == 1) {
                    swal({
                        title: 'Email Gagal Terkirim',
                        text: response.p_keterangan,
                        icon: 'danger'
                    })
                } else if (response.kode == 0) {
                    swal({
                        title: 'Email Terkirim',
                        text: response.p_keterangan,
                        icon: 'info'
                    })
                }
            },
            error: function(error) {
                $('#modal-loader').modal('hide');
                swal({
                    title: 'Terjadi kesalahan!',
                    text: error.responseJSON.message,
                    icon: 'error',
                });
            }
        });
    }

    function showNaik() {
        try {
            modalThName1.text('PKMT');
            modalThName2.text('SALDO AKHIR');
            modalThName3.text('PRDCD');
            modalThName4.text('DESKRIPSI');
            modalThName5.text('LOKASI');
            modalThName6.text('STATUS');
            modalThName1.show();
            modalThName2.show();
            modalThName3.show();
            modalThName4.show();
            modalThName5.show();
            modalThName6.show();
        } catch (e) {
            console.log(e)
            swal({
                icon: 'info',
                title: 'Data Kosong',
                text: 'Data Tidak Ditemukan!',
                timer: 2000
            });
        }
        tableModalHelpNaik.clear().destroy();

        tableModalHelpNaik = $('#tableModalHelpNaik').DataTable({
            ajax: currurl + '/showNaik',
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            columns: [{
                    data: 'pkm_pkmt',
                    name: 'PKMT'
                },
                {
                    data: 'st_saldoakhir',
                    name: 'SALDO AKHIR'
                },
                {
                    data: 'st_prdcd',
                    render: function(data, type, row, meta) {
                        $('#pluListNaik').val(
                            function() {
                                return this.value + ',' + data;
                            });
                        return data;
                    }
                },
                {
                    data: 'prd_deskripsipanjang',
                    name: 'DESKRIPSI'
                },
                {
                    data: 'rak',
                    name: 'LOKASI'
                },
                {
                    data: "status_barang",
                    render: function(data, type, row, meta) {
                        let arr = data.split(',');
                        let a = arr[0];
                        let b = arr[1];
                        if (parseInt(a) / parseInt(b) * 100 > 50) {
                            return 'STORAGE BESAR';
                        } else if (parseInt(a) / parseInt(b) * 100 > 25 && parseInt(a) / parseInt(b) * 100 < 50) {
                            return 'STORAGE KECIL';
                        } else if (parseInt(a) / parseInt(b) * 100 > 0 && parseInt(a) / parseInt(b) * 100 < 25) {
                            return 'STORAGE CAMPUR KECIL';
                        } else {
                            return '-';
                        }
                    }
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('rowNaik');
            },
            "order": []
        });
        // $('#emailBtnNaik').prop('disabled', false);
    }

    function showTurun() {
        try {
            modalThName7.text('PKMT');
            modalThName8.text('SALDO AKHIR');
            modalThName9.text('PRDCD');
            modalThName10.text('DESKRIPSI');
            modalThName11.text('LOKASI');
            modalThName7.show();
            modalThName8.show();
            modalThName9.show();
            modalThName10.show();
            modalThName11.show();
        } catch (e) {
            console.log(e)
            swal({
                icon: 'info',
                title: 'Data Kosong',
                text: 'Data Tidak Ditemukan!',
                timer: 2000
            });
        }
        tableModalHelpTurun.clear().destroy();

        tableModalHelpTurun = $('#tableModalHelpTurun').DataTable({
            ajax: currurl + '/showTurun',
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            responsive: true,
            columns: [{
                    data: 'pkm_pkmt',
                    name: 'PKMT'
                },
                {
                    data: 'st_saldoakhir',
                    name: 'SALDO AKHIR'
                },
                {
                    data: 'st_prdcd',
                    render: function(data, type, row, meta) {
                        $('#pluListTurun').val(
                            function() {
                                return this.value + ',' + data;
                            });
                        return data;
                    }
                },
                {
                    data: 'prd_deskripsipanjang',
                    name: 'DESKRIPSI'
                },
                {
                    data: 'rak',
                    name: 'LOKASI'
                },
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('rowNaik');
            },
            "order": []
        });
        $('#emailBtnTurun').prop('disabled', false);
    }
</script>
@endsection