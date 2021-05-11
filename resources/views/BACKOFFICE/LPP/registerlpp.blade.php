@extends('navbar')
@section('title','Cetak Register LPP')
@section('content')
    <div class="container-fluid mt-0">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <fieldset class="card border-dark">
                    <div class="card-body cardForm ">
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-sm-right">PILIHAN LPP</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="tipe">
                                                <option value="1">1. LPP BAIK RINGKASAN DIVISI
                                                </option>
                                                <option value="2">2. LPP BAIK RINCIAN PRODUK / DIVISI
                                                </option>
                                                <option value="3">3. LPP BAIK RINCIAN PRODUK TANPA RINCIAN GUDANG X
                                                </option>
                                                <option value="4">4. LPP BAIK RINCIAN YANG TERDAPAT PENYESUAIAN
                                                </option>
                                                <option value="5">5. LPP BAIK RINCIAN YANG TERDAPAT KOREKSI
                                                </option>
                                                <option value="6">6. LPP BAIK REKONSILIASI SALDO AWAL DAN SALDO AKHIR
                                                </option>
                                                <option value="7">7. LPP BAIK MONITORING PRODUK / DIVISI
                                                </option>
                                                <option value="8">8. LPP RETUR RINGKASAN DIVISI
                                                </option>
                                                <option value="9">9. LPP RETUR RINCIAN PRODUK / DIVISI
                                                </option>
                                                <option value="10">10. LPP RUSAK RINGKASAN DIVISI
                                                </option>
                                                <option value="11">11. LPP RUSAK RINCIAN PRODUK / DIVISI
                                                </option>
                                                <option value="12">12. LPP GABUNGAN RINGKASAN DIVISI
                                                </option>
                                                <option value="13">13. LPP PER SUPPLIER BARANG BAIK
                                                </option>
                                                <option value="14">14. LPP PER SUPPLIER BARANG RETUR
                                                </option>
                                                <option value="15">15. LPP PER SUPPLIER BARANG RUSAK
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-sm-right">TANGGAL</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control daterange-periode" id="periode1">
                                        </div>
                                        <label class="col-sm-1 col-form-label text-sm-center">s/d</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control daterange-periode" id="periode2">
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="prdcd" class="col-sm-2 text-right col-form-label">PLU</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="prdcd1" disabled>
                                            <button id="btn-prdcd1" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label for="prdcd" class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="prdcd2" disabled>
                                            <button id="btn-prdcd2" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label for="prdcd" class="col-sm-2 text-right col-form-label">DEPARTEMENT</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="dep1" disabled>
                                            <button id="btn-dep1" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label for="prdcd" class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="dep2" disabled>
                                            <button id="btn-dep2" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2 text-right col-form-label">KATEGORI</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="kat1" disabled>
                                            <button id="btn-kat1" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="kat2" disabled>
                                            <button id="btn-kat2" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2 text-right col-form-label">MONITORING</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="mtr1" disabled>
                                            <button id="btn-mtr1" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="mtr2" disabled>
                                            <button id="btn-mtr2" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2 text-right col-form-label">KODE SUPPLIER</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="sup1" disabled>
                                            <button id="btn-sup1" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                        <label class="col-sm-1 text-center col-form-label">s/d</label>
                                        <div class="col-sm-3 buttonInside">
                                            <input type="text" class="form-control" id="sup2" disabled>
                                            <button id="btn-sup2" type="button" class="btn btn-primary btn-lov p-0">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <label class="col-sm-2 text-right col-form-label">TYPE</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="tipe">
                                                <option value="3">3. SEMUA
                                                </option>
                                                <option value="1">1. MINUS
                                                </option>
                                                <option value="2">2. TIDAK
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label text-sm-right">BANYAK ITEM</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="banyakitem" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-1 mt-5 justify-content-center">
                                        <button type="button" class="btn btn-primary col-sm-5"
                                                id="btn-cetak">CETAK
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--MODAL plu1--}}
    <div class="modal fade" id="m_lov" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>
                        Nomor NPB
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>PLU</td>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>

    <style>
        .row-lov1:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .row-lov2:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov-plu {
            position: absolute;
            /*right: 4px;*/
            /*top: 1px;*/
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;

        }

        .input-group-text {
            background-color: white;
        }
    </style>


    <script>
        object_plu = '#plu1';
        $(document).ready(function () {
            var d = new Date();

            var month = d.getMonth() + 1;
            var day = d.getDate();

            var output1 = '0' + (day - day + 1) + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            var output2 = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + d.getFullYear();
            $('#periode1').val(output1);
            $('#periode2').val(output2);
        });

        $('.daterange-periode').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('.daterange-periode').on('apply.daterangepicker', function (ev, picker) {
            $('#periode1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#periode2').val(picker.endDate.format('DD/MM/YYYY'));
        });

        $('.daterange-periode').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
        $('#btn-prdcd1').on('click', function () {
            object_plu = '#plu1';
            console.log(object_plu);
        });
        $('#btn-prdcd2').on('click', function () {
            object_plu = '#plu2';
            console.log(object_plu);
        });
        $('#btn-proses').on('click', function () {
            periode1 = $('#periode1').val();
            periode2 = $('#periode2').val();
            if (periode1 == "" || periode2 == "") {
                swal('Mohon isi periode dengan benar !!', '', 'warning');
            } else {
                ajaxSetup();
                $.ajax({
                    url: "{{ url('/bo/lpp/proses-lpp/proses') }}",
                    type: 'post',
                    data: {
                        periode1: periode1,
                        periode2: periode2
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if (response.status == 'success') {
                            $('#modal-loader').modal('show');
                            console.log(response);
                            swal(response.status, response.message, response.status);
                        } else {
                            alertError(response.status, response.message, response.status)
                        }
                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    </script>


@endsection
