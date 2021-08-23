@extends('navbar')
@section('title','PENGGUNAAN POINT REWARD PER TANGGAL')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="ml-3"> Rekapitulasi Mutasi Point Reward</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row justify-content-center form-group">
                            <label class="col-sm-3 col-form-label text-sm-right">Periode Mutasi :</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control tanggal" id="bulan"
                                       value="" placeholder="BULAN">
                            </div>
                            <label class="col-sm-1 col-form-label text-sm-right">-</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control tanggal" id="tahun"
                                       value="" placeholder="TAHUN">
                            </div>
                            <label class="col-sm-2 col-form-label text-sm-right">[MM-YYYY]</label>
                        </div>
                        <div class="row float-right">
                            <div class="col-sm-12">
                                <button class="btn btn-primary" onclick="urutkan()">URUTKAN</button>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#m_lovmember">CARI
                                </button>
                                <button class="btn btn-primary" onclick="cetak()">PRINT</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalByKodeMember" tabindex="-1" role="dialog" aria-labelledby="modalByKodeMember"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="tableFixedHeader">
                                    <table class="table table-sm">
                                        <thead>
                                        <tr>
                                            <th rowspan="2">ID. Member</th>
                                            <th rowspan="2">Member Merah</th>
                                            <th rowspan="2">Posisi Awal</th>
                                            <th colspan="2">Perolehan Reward</th>
                                            <th colspan="2">Pemakaian Reward</th>
                                            <th rowspan="2">Ganti ID Mbr Baru</th>
                                            <th rowspan="2">Posisi Akhir</th>
                                        </tr>
                                        <tr>
                                            <th>Hdh. Struk</th>
                                            <th>ID. Mbr Lama</th>
                                            <th>Pembayaran</th>
                                            <th>Prd Redeem</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tableByKodeMemberBody"></tbody>
                                        <tfoot id="tableByKodeMemberFoot"></tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row float-right">
                            <div class="col-sm-12">
                                <button class="btn btn-primary" onclick="urutkan()">CARI</button>
                                <button class="btn btn-primary" onclick="cetak()">PRINT</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="m_lovmember" tabindex="-1" role="dialog" aria-labelledby="m_lovmember"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">LOV Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalLovMember">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Member</th>
                                        <th>Nama Member</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
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
        idrak = 1;
        $(document).ready(function () {
            $("#bulan").datepicker({
                dateFormat: 'mm',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,

                onClose: function (dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $("#bulan").val($.datepicker.formatDate('mm', new Date(year, month, 1)));
                    $("#tahun").val($.datepicker.formatDate('yy', new Date(year, month, 1)));
                }
            });
            $("#tahun").datepicker({
                dateFormat: 'yy',
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,

                onClose: function (dateText, inst) {
                    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                    $("#bulan").val($.datepicker.formatDate('mm', new Date(year, month, 1)));
                    $("#tahun").val($.datepicker.formatDate('yy', new Date(year, month, 1)));
                }
            });
            $("#bulan,#tahun").focus(function () {
                $(".ui-datepicker-calendar").hide();
                $("#ui-datepicker-div").position({
                    my: "center top",
                    at: "center bottom",
                    of: $(this)
                });
            });
            $("#bulan,#tahun").datepicker('setDate', new Date());

            getModalLovMember('');
        });

        function getModalLovMember(value) {
            let tableModal = $('#tableModalLovMember').DataTable({
                "ajax": {
                    'url': '{{ url()->current() }}/lovmember',
                    "data": {
                        'value': value
                    }
                },
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow modalRowMember');
                },
                "order": [],
                columnDefs: []
            });

            $('#tableModalLovMember_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalLovMember(val);
                }
            })
        }

        $(document).on('click', '.modalRowMember', function () {
            var currentButton = $(this);
            let val = currentButton.children().first().text();
            $('.row-' + row).children().first().find('input').val(val);

            $('#m_lovmember').modal('hide');
        });

        function urutkan() {
            bln = $('#bulan').val();
            thn = $('#tahun').val();
            member = $('#member').val();
            // swal({
            //     title: 'Urutkan record berdasarkan ?',
            //     icon: 'info',
            //     buttons: {
            //         kode: {
            //             text: 'Kode',
            //             value: 'kode'
            //         },
            //         nama: {
            //             text: 'Nama',
            //             value: 'nama'
            //         }
            //     },
            //     dangerMode: true
            // }).then((sort) => {
            //     if (sort) {
            $.ajax({
                url: '{{ url()->current().'/urutkan' }}',
                type: 'get',
                data: {
                    // sort: sort,
                    bln: bln,
                    thn: thn,
                    member: member,
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    $('#periode').val(result.periode);
                    $('#jumlah-member').val(result.jumlahMember);
                    for (i = 0; i < result.data.length; i++) {
                        $('#tableByKodeMemberBody').append(`
                                        <tr>
                                            <td>` + result.data[i].kdmbr + `</td>
                                            <td>` + result.data[i].cus_namamember + `</td>
                                            <td>` + result.data[i].saldo_awal_bulan + `</td>
                                            <td>` + result.data[i].perolehanpoint + `</td>
                                            <td>` + result.data[i].trf_kodelama + `</td>
                                            <td>` + result.data[i].penukaranpoint + `</td>
                                            <td>` + result.data[i].redeempoint + `</td>
                                            <td>` + result.data[i].trf_kodebaru + `</td>
                                            <td>` + result.data[i].saldo_akhir_bulan + `</td>
                                        </tr>
                                `);
                    }
                    $('#tableByKodeMemberFoot').empty().append(`
                                     <tr>
                                        <th colspan="2">Total Point Reward : </th>
                                        <th>` + cekNull(result.dataTotal.tot_saldoawal, 0) + `</th>
                                        <th>` + cekNull(result.dataTotal.tot_perolehankasir, 0) + `</th>
                                        <th>` + cekNull(result.dataTotal.tot_transferkodelama, 0) + `</th>
                                        <th>` + cekNull(result.dataTotal.tot_pembayaranpoin, 0) + `</th>
                                        <th>` + cekNull(result.dataTotal.tot_redeempoin, 0) + `</th>
                                        <th>` + cekNull(result.dataTotal.tot_transferkodebaru, 0) + `</th>
                                        <th>` + cekNull(result.dataTotal.tot_saldoakhir, 0) + `</th>
                                    </tr>
                                    <tr>
                                        <th>` + result.jumlahMember + `</th>
                                        <th>Member</th>
                                    </tr>
                                `);


                    $('#modalByKodeMember').modal('show');
                    $('#modal-loader').modal('hide');
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
            //     }
            // });
        }

        function cetak() {
            swal({
                title: 'Urutkan record berdasarkan ?',
                icon: 'info',
                buttons: {
                    kode: {
                        text: 'Kode',
                        value: 'kode'
                    },
                    nama: {
                        text: 'Nama',
                        value: 'nama'
                    }
                },
                dangerMode: true
            }).then((sort) => {
                if (sort) {
                    bln = $('#bulan').val();
                    thn = $('#tahun').val();
                    window.open(`{{ url()->current() }}/cetak?sort=${sort}&bln=${bln}&thn=${thn}`, '_blank');
                }
            });
        }
    </script>
@endsection
