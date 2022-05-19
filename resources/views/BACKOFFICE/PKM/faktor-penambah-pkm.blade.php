@extends('navbar')
@section('title','Faktor Penambah PKM')
@section('content')
    <div class="container-fluid">
        <div class="row no-gutters justify-content-center">
            <div class="col-md-11">
                <button class="btn btn-primary" id="nBtn">N+</button>
                <button class="btn btn-primary" id="mBtn">M+</button>

                <fieldset class="card border-dark n-form">
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table table table-sm table-bordered text-center" id="tblN">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="main_check_n" onclick="selectAllN()"></th>
                                        <th>NO PERJANJIAN</th>
                                        <th>PLU</th>
                                        <th>KD DISPLAY</th>
                                        <th>TGL AWAL</th>
                                        <th>TGL AKHIR</th>
                                        <th>QTY</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <h4 class="text-center">FILTER</h4>
                                <div class="form-group">
                                    <label for="tglAwal">TGL AWAL</label>
                                    <input type="text" class="form-control daterange-periode-2" name="tglAwal"
                                           id="tglAwal" aria-describedby="tglAwal">
                                </div>
                                <div class="form-group">
                                    <label for="tglAkhir">TGL AKHIR</label>
                                    <input type="text" class="form-control daterange-periode-2" name="tglAkhir"
                                           id="tglAkhir" aria-describedby="tglAkhir">
                                </div>
                                {{-- <hr style="background-color: grey"> --}}
                                <hr style="background-color: grey">
                                <div class="form-group">
                                    <label for="filterKdDisplay">FILTER KD DISPLAY</label>
                                    <input type="text" class="form-control" name="filterKdDisplay" id="filterKdDisplay"
                                           aria-describedby="filterKdDisplay">
                                </div>
                                <hr style="background-color: grey">
                                {{-- <div class="form-group">
                                    <label for="searchPLU">CARI PLU</label>
                                    <input type="text" class="form-control" name="searchPLU" id="searchPLU"
                                           aria-describedby="searchPLU">
                                </div> --}}
                                <hr style="background-color: grey">
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-primary text-center" id="updateQtyPkmg"
                                            onclick="updateQtyPKMG()" type="button">UPDATE QTY & PKMG
                                    </button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <small class="form-text text-muted"><span style="color: red;">*</span>check qty yang
                                        akan diupdate</small>
                                </div>

                            </div>
                        </div>
                        <hr style="background-color: grey">

                        <div class="form-group no-gutters row">
                            <label for="plu" class="col-sm-1 col-form-label">PLU</label>
                            <div class="col-sm-10 row">
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="nd_prdcd" disabled>
                                </div>
                                <label> - </label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" id="nd_deskripsi" disabled>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div class="form-group no-gutters row">
                            <label for="nd_mpkm" class="col-sm-1 col-form-label">MPKM</label>
                            <div class="col-lg-10 row">
                                <div class="col-sm-2">
                                    <input class="form-control" type="text" name="nd_mpkm" id="nd_mpkm" disabled>
                                </div>
                                <label for="nd_mplus" class="col-sm-1 col-form-label">M+</label>
                                <div class="col-sm-1">
                                    <input class="form-control" type="text" name="nd_mplus" id="nd_mplus" disabled>
                                </div>
                                <label for="nd_pkmt" class="col-sm-1 col-form-label">PKMT</label>
                                <div class="col-sm-1">
                                    <input class="form-control" type="text" name="nd_pkmt" id="nd_pkmt" disabled>
                                </div>
                                <label for="nd_nilaigondola" class="col-sm-2 col-form-label">QTY GONDOLA</label>
                                <div class="col-sm-1">
                                    <input class="form-control" type="text" name="nd_nilaigondola" id="nd_nilaigondola"
                                           disabled>
                                </div>
                                <label for="nd_pkmg" class="col-sm-1 col-form-label">PKMG</label>
                                <div class="col-sm-2">
                                    <input class="form-control" type="text" name="nd_pkmg" id="nd_pkmg" disabled>
                                </div>
                            </div>
                        </div>
                        <hr style="background-color: grey">
                        <div class="row">
                            <div class="col-sm-10">
                                <h6>TAMBAH</h6>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>NO PERJANJIAN</th>
                                        <th>PLU</th>
                                        <th>KD DISPLAY</th>
                                        <th>TGL AWAL</th>
                                        <th>TGL AKHIR</th>
                                        <th>QTY</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" id="na_noperjanjian"></td>
                                        <td><input type="text" class="form-control" id="na_prdcd"
                                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">
                                        </td>
                                        <td><input type="text" class="form-control" id="na_kodedisplay"
                                                   onkeyup="this.value = this.value.toUpperCase();" maxlength="2"></td>
                                        <td><input type="text" class="form-control daterange-periode" id="na_tglawal">
                                        </td>
                                        <td><input type="text" class="form-control daterange-periode" id="na_tglakhir">
                                        </td>
                                        <td><input type="text" class="form-control" id="na_qty"
                                                   onkeypress="return (event.charCode >= 48 && event.charCode <= 57)">
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-2 d-flex align-items-center justify-content-center">
                                <button type="button" class="btn btn-primary w-75 mt-4" onclick="insertPerjanjian()">
                                    ADD
                                </button>
                            </div>
                        </div>
                        <hr style="background-color: grey">
                        <div class="row">
                            <div class="col-sm-2 justify-content-center">
                                <h6>UPLOAD</h6>
                                <div class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-primary" onclick="uploadNplus()">UPLOAD
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <p>File CSV harus ada di server database /u01/lhost/trf_mplus/DATA/</p>
                                <p>Filename NPLUS_GO.CSV separator |</p>
                                <p>List PLU yang tidak terproses ada di S:/TRF/ (jika ada)</p>
                            </div>
                            <div class="col-sm-2 d-flex align-items-center justify-content-center">
                                <div>
                                    <button type="button" class="btn btn-primary" onclick="refreshTableN()">REFRESH
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <fieldset class="card border-dark m-form">
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table table-sm table-bordered text-center" id="tblM">
                                    <thead>
                                    <tr>
                                        <th><input type="checkbox" id="main_check" onclick="selectAll()"></th>
                                        <th>PLU</th>
                                        <th>M+</th>
                                        <th>M+ I</th>
                                        <th>M+ O</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>

                                    </tr>
                                    <!-- row data -->
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-6 mt-4">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>PLU</label>
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" id="md_prdcd" disabled>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="md_deskripsi" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group no-gutters">
                                            <label class="col-sm-2">MPKM</label>
                                            <label style="margin-left:5px;">PKMT</label>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="md_mpkm" disabled>
                                                </div>

                                                <div class="col-sm-2">
                                                    <input type="text" class="form-control" id="md_pkmt" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row no-gutters d-flex justify-content-end">
                                            <label class="col-sm-2">CARI PLU</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" id="mf_prdcd">
                                            </div>
                                        </div> --}}
                                        <hr class="hl">
                                        <div class="form-group row no-gutters d-flex justify-content-center">
                                            <div class="col-sm-6">
                                                <button class="btn btn-primary btn-lg" onclick="updateQty()">UPDATE
                                                </button>
                                                <label>*check qty yang akan diupdate</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hl">
                        <label>TAMBAH</label>
                        <div class="row d-flex justify-content-center">
                            <div class="form-group">
                                <label class="col-lg-3">PLU</label>
                                <label class="col-lg-3">M+ I</label>
                                <label>M+ O</label>
                                <br>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="ma_prdcd" maxlength="7">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="ma_mplus_i">
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="text" class="form-control" id="ma_mplus_o">
                                    </div>
                                    <div class="col-lg-3">
                                        <button class="btn btn-primary btn-md" onclick="insertPLU()"> ADD</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hl">
                        <label>UPLOAD</label>
                        <div class="row">
                            <div class="col-lg-3">

                            </div>
                            <div class="col-lg-1 justify-content-end">
                                <button class="btn btn-primary btn-md" id="btn-import" onclick="uploadMplus()">UPLOAD
                                </button>
                            </div>
                            <div class="col-lg-5">
                                <p>File CSV harus ada di server database /u01/lhost/trf_mplus/DATA/ <br>
                                    Filename MPLUS_GO.CSV separator | <br>
                                    List PLU yang tidak terproses ada di S:/TRF/ (jika ada)
                                </p>
                            </div>
                            <div class="col-lg-1">
                                <div class="vl-2"></div>
                            </div>
                            <div class="col-lg-2 mt-4">
                                <button class="btn btn-primary btn-md" onclick="refreshTable()">REFRESH</button>
                            </div>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
    </div>

    <style>
        .vl {
            border-left: 1px solid gray;
            height: 400px;
        }

        .vl-2 {
            border-left: 1px solid gray;
            height: 100px;
        }

        #tblM, #tblB {
            overflow-x: disabled;
            overflow-y: scroll;
        }

        .hl {
            border: 1px solid black;
        }
    </style>

    <script>
        var temp = 0;
        var arrDataTableM = [];
        var arrDataTableN = [];
        $(document).ready(function () {
            swal('Program hanya bisa dipakai sampai 3 bulan setelah reorder !', '', 'warning');
            getDataTableN();
            $('.m-form').hide();

            $('#nBtn').click(function (e) {
                $('.m-form').hide();
                getDataTableN();
                $('.n-form').show();
            });
            $('#mBtn').click(function (e) {
                $('.n-form').hide();
                getDataTableM();
                $('.m-form').show();
            });

        });

        function convertRupiah(value) {
            let numString = value.toString()
            let splitVal = numString.split('.')
            let mainVal = splitVal[0]

            let sisa = mainVal.length % 3
            let rupiah = mainVal.substr(0, sisa)
            let ribuan = mainVal.substr(sisa).match(/\d{3}/g)

            if (ribuan) {
                separator = sisa ? ',' : '';
                rupiah += separator + ribuan.join(',');
            }

            if (splitVal.length > 1) {
                let koma = splitVal[1]
                let fixedKoma = koma.substr(0, 2)

                let fixedRupiah = rupiah + '.' + fixedKoma
                return fixedRupiah
            } else {
                return rupiah
            }
        }

        // ------------------------------ MENU N ------------------------------------------------


        $('.daterange-periode').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('.daterange-periode').on('apply.daterangepicker', function (ev, picker) {
            $('#na_tglawal').val(picker.startDate.format('DD/MM/YYYY'));
            $('#na_tglakhir').val(picker.endDate.format('DD/MM/YYYY'));
        });

        $('.daterange-periode').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        $('.daterange-periode-2').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('.daterange-periode-2').on('apply.daterangepicker', function (ev, picker) {
            $('#tglAwal').val(picker.startDate.format('DD/MM/YYYY'));
            $('#tglAkhir').val(picker.endDate.format('DD/MM/YYYY'));
        });

        $('.daterange-periode-2').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

        $('#tglAkhir').keypress(function (e) {
            if (e.keyCode == 13) {
                filterTanggalNPlus();
            }
        });

        $('#filterKdDisplay').keypress(function (e) {
            if (e.keyCode == 13) {
                filterKodeDisplayNPlus();
            }
        });

        function filterKodeDisplayNPlus() {
            arrDataTableN = [];

            if ($.fn.DataTable.isDataTable('#tblN')) {
                $('#tblN').DataTable().destroy();
                $("#tblN tbody tr").remove();
            }

            $('#tblN').DataTable({
                "ajax": {
                    url: '{{ route('filter-kode-nplus')  }}',
                    data: {
                        nf_kodedisplay: $('#filterKdDisplay').val()
                    },
                },
                "columns": [
                    {
                        data: null, render: function (data, type, full, meta) {
                            return `<input type="checkbox" class="form-control-sm cb_n" id="cb_n_${meta.row}">`;
                        }
                    },
                    {data: 'gdl_noperjanjiansewa'},
                    {data: 'gdl_prdcd'},
                    {data: 'gdl_kodedisplay'},
                    {data: 'gdl_tglawal'},
                    {data: 'gdl_tglakhir'},
                    {
                        data: 'gdl_qty', render: function (data, type, full, meta) {
                            return `<input type="text" class="form-control-sm text-center gdl_qty" value="${data}" id="gdl_qty_${meta.row}" onchange="checkList(${meta.row})">`;
                        }
                    },
                ],
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    // row -> <tr>
                    // data -> isi semua data dalam array
                    // dataIndex -> lopping nilai index setiap data
                    $(row).addClass('row-data-table-n').css({'cursor': 'pointer'});
                    // $(row).find('td:eq(1)').addClass('kode_plu');

                    arrDataTableN.push(data);
                },
                "order": [],
                "scrollY": "400px",
                "scrollX": false,
                "scrollCollapse": true,
                "initComplete": function () {
                    $(document).on('click', '.row-data-table-n', function (e) {

                        $('.row-data-table-n').removeAttr('style').css({'cursor': 'pointer'});
                        $(this).css({"background-color": "#acacac", "color": "white"});

                        showDetailN($(this).index());
                        currentIndex = $(this).index();
                    });

                    $('.row-data-table-n:eq(0)').css({"background-color": "#acacac", "color": "white"});
                    showDetailN(0);
                }
            });
        }

        function filterTanggalNPlus() {
            arrDataTableN = [];

            if ($.fn.DataTable.isDataTable('#tblN')) {
                $('#tblN').DataTable().destroy();
                $("#tblN tbody tr").remove();
            }

            $('#tblN').DataTable({
                "ajax": {
                    url: '{{ route('filter-tanggal-nplus')  }}',
                    data: {
                        nf_tglawal: $('#tglAwal').val(),
                        nf_tglakhir: $('#tglAkhir').val()
                    },
                },
                "columns": [
                    {
                        data: null, render: function (data, type, full, meta) {
                            return `<input type="checkbox" class="form-control-sm cb_n" id="cb_n_${meta.row}">`;
                        }
                    },
                    {data: 'gdl_noperjanjiansewa'},
                    {data: 'gdl_prdcd'},
                    {data: 'gdl_kodedisplay'},
                    {data: 'gdl_tglawal'},
                    {data: 'gdl_tglakhir'},
                    {
                        data: 'gdl_qty', render: function (data, type, full, meta) {
                            return `<input type="text" class="form-control-sm text-center gdl_qty" value="${data}" id="gdl_qty_${meta.row}" onchange="checkList(${meta.row})">`;
                        }
                    },
                ],
                "paging": false,
                "lengthChange": true,
                "searching": false,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    // row -> <tr>
                    // data -> isi semua data dalam array
                    // dataIndex -> lopping nilai index setiap data
                    $(row).addClass('row-data-table-n').css({'cursor': 'pointer'});
                    // $(row).find('td:eq(1)').addClass('kode_plu');

                    arrDataTableN.push(data);
                },
                "order": [],
                "scrollY": "400px",
                "scrollX": false,
                "scrollCollapse": true,
                "initComplete": function () {
                    $(document).on('click', '.row-data-table-n', function (e) {

                        $('.row-data-table-n').removeAttr('style').css({'cursor': 'pointer'});
                        $(this).css({"background-color": "#acacac", "color": "white"});

                        showDetailN($(this).index());
                        currentIndex = $(this).index();
                    });

                    $('.row-data-table-n:eq(0)').css({"background-color": "#acacac", "color": "white"});
                    showDetailN(0);
                }
            });
        }

        function getDataTableN() {
            arrDataTableN = [];

            if ($.fn.DataTable.isDataTable('#tblN')) {
                $('#tblN').DataTable().destroy();
                $("#tblN tbody tr").remove();
            }

            $('#tblN').DataTable({
                "ajax": '{{ route('get-data-table-n')  }}',
                "columns": [
                    {
                        data: null, render: function (data, type, full, meta) {
                            return `<input type="checkbox" class="form-control-sm cb_n" id="cb_n_${meta.row}">`;
                        }
                    },
                    {data: 'gdl_noperjanjiansewa'},
                    {data: 'gdl_prdcd'},
                    {data: 'gdl_kodedisplay'},
                    {data: 'gdl_tglawal'},
                    {data: 'gdl_tglakhir'},
                    {
                        data: 'gdl_qty', render: function (data, type, full, meta) {
                            return `<input type="text" class="form-control-sm text-center gdl_qty" value="${convertRupiah(data)}" id="gdl_qty_${meta.row}" onchange="checkListN(${meta.row})">`;
                        }
                    },
                ],
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    // row -> <tr>
                    // data -> isi semua data dalam array
                    // dataIndex -> lopping nilai index setiap data
                    $(row).addClass('row-data-table-n').css({'cursor': 'pointer'});
                    $(row).find('td:eq(1)').addClass('no_perjanjian');
                    $(row).find('td:eq(2)').addClass('kode_plu_n');
                    $(row).find('td:eq(3)').addClass('kode_display');
                    $(row).find('td:eq(4)').addClass('tgl_awal');
                    $(row).find('td:eq(5)').addClass('tgl_akhir');

                    arrDataTableN.push(data);
                },
                "order": [],
                "scrollY": "400px",
                "scrollX": false,
                "scrollCollapse": true,
                "initComplete": function () {
                    $(document).on('click', '.row-data-table-n', function (e) {

                        $('.row-data-table-n').removeAttr('style').css({'cursor': 'pointer'});
                        $(this).css({"background-color": "#acacac", "color": "white"});

                        showDetailN($(this).index());
                        currentIndex = $(this).index();
                    });

                    $('.row-data-table-n:eq(0)').css({"background-color": "#acacac", "color": "white"});
                    showDetailN(0);
                }
            });
        }

        function showDetailN(index) {
            dataN = arrDataTableN[index];

            ajaxSetup();
            $.ajax({
                url: '{{ route('get-data-detail-n')  }}',
                type: 'get',
                data: {
                    n_prdcd: dataN.gdl_prdcd
                },
                success: function (response) {
                    $('#nd_prdcd').val(response.nd_prdcd);
                    $('#nd_deskripsi').val(response.nd_deskripsi);
                    $('#nd_nilaigondola').val(convertRupiah(response.nd_nilaigondola));
                    $('#nd_pkmg').val(convertRupiah(response.nd_pkmg));
                    $('#nd_pkmt').val(convertRupiah(response.nd_pkmt));
                    $('#nd_mpkm').val(convertRupiah(response.nd_mpkm));
                    $('#nd_mplus').val(convertRupiah(response.nd_mplus));
                }
            });
        }

        function checkListN(value) {
            if (arrDataTableN[value].gdl_qty != $('#gdl_qty_' + value).val()) {
                $('#cb_n_' + value).prop('checked', true);
            } else {
                $('#cb_n_' + value).prop('checked', false);
            }
        }

        $('#searchPLU').keypress(function (e) {
            if (e.keyCode == 13) {

                var status = false;

                $('.row-data-table-n').each(function () {
                    if ($(this).find('td:eq(2)').html() == $('#searchPLU').val()) {
                        status = true;
                        $(this).click();
                    }
                });
                if (!status) {
                    swal('PLU tidak ditemukan !', '', 'warning');
                    $('.row-data-table-n:eq(0)').click();
                }
            }
        });

        $('#na_prdcd').keypress(function (e) {
            if (e.keyCode == 13) {
                plu = $(this).val();
                if (plu.length < 7) {
                    plu = convertPlu($(this).val());
                }
                $(this).val(plu);
                $('#na_prdcd').val(plu);
            }
        });

        $('#na_noperjanjian').focus(function () {
            plu = $('#na_prdcd').val();
            if (plu.length < 7 && plu.length != 0) {

                plu = convertPlu($('#na_prdcd').val());
            } else if (plu.length == 0) {
                plu = '';
            }
            $('#na_prdcd').val(plu);
        });

        $('#na_kodedisplay').focus(function () {
            plu = $('#na_prdcd').val();
            if (plu.length < 7 && plu.length != 0) {

                plu = convertPlu($('#na_prdcd').val());
            } else if (plu.length == 0) {
                plu = '';
            }
            $('#na_prdcd').val(plu);
        });

        $('#na_tglawal').focus(function () {
            plu = $('#na_prdcd').val();
            if (plu.length < 7 && plu.length != 0) {

                plu = convertPlu($('#na_prdcd').val());
            } else if (plu.length == 0) {
                plu = '';
            }
            $('#na_prdcd').val(plu);
        });

        $('#na_tglakhir').focus(function () {
            plu = $('#na_prdcd').val();
            if (plu.length < 7 && plu.length != 0) {

                plu = convertPlu($('#na_prdcd').val());
            } else if (plu.length == 0) {
                plu = '';
            }
            $('#na_prdcd').val(plu);
        });

        $('#na_qty').focus(function () {
            plu = $('#na_prdcd').val();
            if (plu.length < 7 && plu.length != 0) {

                plu = convertPlu($('#na_prdcd').val());
            } else if (plu.length == 0) {
                plu = '';
            }
            $('#na_prdcd').val(plu);
        });

        function updateQtyPKMG(value) {
            let arrDataUpdateNplus = [];

            $('.row-data-table-n').each(function (row, data, dataIndex) {
                if ($(this).find('.cb_n').is(':checked', true)) {
                    let nplus = new Object;
                    nplus['no_perjanjian'] = $(this).find('.no_perjanjian').html();
                    nplus['plu_n'] = $(this).find('.kode_plu_n').html();
                    nplus['kode_display'] = $(this).find('.kode_display').html();
                    nplus['gdl_qty'] = parseInt($(this).find('.gdl_qty').val().replace(',',''));
                    nplus['tgl_awal'] = $(this).find('.tgl_awal').html();
                    nplus['tgl_akhir'] = $(this).find('.tgl_akhir').html();

                    arrDataUpdateNplus.push(nplus);
                }
            });

            ajaxSetup();
            $.ajax({
                url: '{{ route('update-nplus')  }}',
                type: 'post',
                data: {
                    update_nplus: arrDataUpdateNplus
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: response.title,
                        text: response.message,
                        icon: 'success'
                    }).then(function (ok) {
                        getDataTableN();
                    });
                },
                error: function (error) {
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error'
                    });
                }
            });

        }

        function insertPerjanjian() {
            if ($('#na_noperjanjian').val() == '' || $('#na_prdcd').val() == '' || $('#na_kodedisplay').val() == '' || $('#na_tglawal').val() == '' || $('#na_tglakhir').val() == '' || $('#na_qty').val() == '') {
                swal('Inputan harus diisi semua !!', '', 'warning');
            } else {
                swal({
                    title: 'Apakah anda yakin ingin menambahkan Perjanjian ini ? ',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function (ok) {
                    if (ok) {
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current().'/insert-perjanjian' }}',
                            type: 'post',
                            data: {
                                na_noperjanjian: $('#na_noperjanjian').val(),
                                na_prdcd: $('#na_prdcd').val(),
                                na_kodedisplay: $('#na_kodedisplay').val(),
                                na_tglawal: $('#na_tglawal').val(),
                                na_tglakhir: $('#na_tglakhir').val(),
                                na_qty: $('#na_qty').val()
                            },
                            success: function (response) {
                                swal({
                                    title: response.title,
                                    text: response.message,
                                    icon: 'success'
                                }).then(function (ok) {
                                    $('#na_noperjanjian').val(''),
                                        $('#na_prdcd').val(''),
                                        $('#na_kodedisplay').val('')
                                    $('#na_tglawal').val('')
                                    $('#na_tglakhir').val('')
                                    $('#na_qty').val('')
                                });
                            }, error: function (error) {
                                swal({
                                    title: error.responseJSON.title,
                                    text: error.responseJSON.message,
                                    icon: 'error'
                                });
                            }
                        })// ajax
                    }// if ok
                })
            }
        }

        function refreshTableN() {
            $('#tblN').animate({
                scrollTop: $(".row-data-table-n:eq(0)").offset().top
            }, 2000);
            $('.row-data-table-n:eq(0)').click();
            $('.cb_n').prop('checked', false);
            $('#main_check_n').prop('checked', false);
            $('#tglAwal').val('');
            $('#tglAkhir').val('');
            $('#filterKdDisplay').val('');
            $('#searchPLU').val('');
            $('#na_noperjanjian').val('');
            $('#na_prdcd').val(''),
            $('#na_kodedisplay').val(''),
            $('#na_tglawal').val(''),
            $('#na_tglakhir').val(''),
            $('#na_qty').val('')

        }

        function selectAllN() {
            $('.cb_n').prop('checked', $('#main_check_n').is(':checked'));
        }


        function uploadNplus() {
            ajaxSetup();
            $.ajax({
                url: '{{ route('upload-nplus')  }}',
                type: 'POST',
                success: function (response) {
                    swal({
                        title: response.title,
                        text: response.message,
                        icon: 'success'
                    }).then(function (ok) {
                        window.open('{{ url()->current() }}/download-txt?filename=' + response.filename);
                    });

                },
                error: function (error) {
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error'
                    })
                }
            });
        }

        // ------------------------------ MENU M ------------------------------------------------
        function checkList(value) {
            if (arrDataTableM[value].pkmp_mplusi != $('#mi_' + value).val() || arrDataTableM[value].pkmp_mpluso != $('#mo_' + value).val()) {
                $('#cb_' + value).prop('checked', true);
                total = parseInt($('#mi_' + value).val()) + parseInt($('#mo_' + value).val());
                // arrDataTableM[value].pkmp_mplus = total;
                $('#cb_' + value).parent().parent().find('td:eq(2)').html(total);
            } else {
                $('#cb_' + value).prop('checked', false);
            }
        }

        function getDataTableM() {
            arrDataTableM = [];

            if ($.fn.DataTable.isDataTable('#tblM')) {
                $('#tblM').DataTable().destroy();
                $("#tblM tbody tr").remove();
            }

            $('#tblM').DataTable({
                "ajax": '{{ route('get-data-table-m')  }}',
                "columns": [
                    {
                        data: null, render: function (data, type, full, meta) {
                            return `<input type="checkbox" class="form-control-sm cb" id="cb_${meta.row}">`;
                        }
                    },
                    {data: 'pkmp_prdcd'},
                    // {data: 'pkmp_mplus'},
                    // {
                    //     data: 'pkmp_mplus', render: function (data, type, full, meta) {
                    //         return `<input type="text" class="form-control-sm text-center" value="${convertRupiah(data)}" id="mplus_${meta.row}" onchange="checkList(${meta.row})">`;
                    //     }
                    // },
                    {
                        data: 'pkmp_mplus', render: function (data, type, full, meta) {
                            return `${convertRupiah(data)}`;
                        }
                    },
                    {
                        data: 'pkmp_mplusi', render: function (data, type, full, meta) {
                            return `<input type="text" class="form-control-sm text-center m_i" value="${convertRupiah(data)}" id="mi_${meta.row}" onchange="checkList(${meta.row})">`;
                        }
                    },
                    {
                        data: 'pkmp_mpluso', render: function (data, type, full, meta) {
                            return `<input type="text" class="form-control-sm text-center m_o" value="${convertRupiah(data)}" id="mo_${meta.row}" onchange="checkList(${meta.row})">`;
                        }
                    },
                ],
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    // row -> <tr>
                    // data -> isi semua data dalam array
                    // dataIndex -> lopping nilai index setiap data
                    $(row).addClass('row-data-table-m').css({'cursor': 'pointer'});
                    $(row).find('td:eq(1)').addClass('kode_plu');

                    arrDataTableM.push(data);
                },
                "order": [],
                "scrollY": "400px",
                "scrollX": false,
                "scrollCollapse": true,
                "initComplete": function () {
                    $(document).on('click', '.row-data-table-m', function (e) {

                        $('.row-data-table-m').removeAttr('style').css({'cursor': 'pointer'});
                        $(this).css({"background-color": "#acacac", "color": "white"});

                        showDetail($(this).index());
                        currentIndex = $(this).index();
                    });

                    $('.row-data-table-m:eq(0)').css({"background-color": "#acacac", "color": "white"});
                    showDetail(0);
                }
            });
        }

        function calculateMPLUS(value)
        {
            console.log(value);
            total = $(this).find('#m_i'+value).val() + $(this).find('#m_o'+value).val();
            // console.log(total);
        }



        function updateQty(value) {
            let arrDataUpdateMplus = [];

            $('.row-data-table-m').each(function (row, data, dataIndex) {
                if ($(this).find('.cb').is(':checked', true)) {
                    let mplus = new Object;
                    mplus['plu'] = $(this).find('.kode_plu').html();
                    mplus['m_i'] = parseInt($(this).find('.m_i').val().replace(',',''));
                    mplus['m_o'] = parseInt($(this).find('.m_o').val().replace(',',''));

                    arrDataUpdateMplus.push(mplus);
                }
            });

            ajaxSetup();
            $.ajax({
                url: '{{ route('update-mplus')  }}',
                type: 'post',
                data: {
                    update_mplus: arrDataUpdateMplus
                },
                success: function (response) {
                    swal({
                        title: response.title,
                        text: response.message,
                        icon: 'success'
                    }).then(function (ok) {
                        getDataTableM();
                    });
                },
                error: function (error) {
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error'
                    });
                }
            });
        }

        function showDetail(index) {
            data = arrDataTableM[index];

            ajaxSetup();
            $.ajax({
                url: '{{ route('get-data-detail')  }}',
                type: 'get',
                data: {
                    pkmp_prdcd: data.pkmp_prdcd
                },
                success: function (response) {
                    $('#md_prdcd').val(response[0].prd_prdcd);
                    $('#md_deskripsi').val(response[0].prd_deskripsipanjang);
                    $('#md_mpkm').val(convertRupiah(response[0].pkm_mpkm));
                    $('#md_pkmt').val(convertRupiah(response[0].pkm_pkmt));
                    // $('#ppn').val(convertRupiah(tot_ppn));
                    // echo number_format(pkmt,2,',','.');

                }
            });
        }

        $('#mf_prdcd').keypress(function (e) {
            if (e.keyCode == 13) {

                var status = false;

                $('.row-data-table-m').each(function () {
                    if ($(this).find('td:eq(1)').html() == $('#mf_prdcd').val()) {
                        status = true;
                        $(this).click().focus();
                    }
                });
                if (!status) {
                    swal('PLU tidak ditemukan !', '', 'warning');
                    $('.row-data-table-m:eq(0)').click();
                }
            }
        });


        $('#ma_prdcd').keypress(function (e) {
            if (e.keyCode == 13) {
                plu = $(this).val();
                if (plu.length < 7) {
                    plu = convertPlu($(this).val());
                }
                $(this).val(plu);
                $('#ma_prdcd').val(plu);
            }
        });

        $('#ma_mplus_i').focus(function () {
            plu = $('#ma_prdcd').val();
            if (plu.length < 7 && plu.length != 0) {

                plu = convertPlu($('#ma_prdcd').val());
            } else if (plu.length == 0) {
                plu = '';
            }
            $('#ma_prdcd').val(plu);
        });

        $('#ma_mplus_o').focus(function () {
            plu = $('#ma_prdcd').val();
            if (plu.length < 7 && plu.length != 0) {
                plu = convertPlu($('#ma_prdcd').val());
            } else if (plu.length == 0) {
                plu = '';
            }
            $('#ma_prdcd').val(plu);
        });

        function insertPLU() {
            if ($('#ma_prdcd').val() == '' || $('#ma_mplus_i').val() == '' || $('#ma_mplus_o').val() == '') {
                swal('Inputan harus diisi semua !!', '', 'warning');
            } else if ($('#ma_prdcd').val().length < 7) {
                swal('PLU harus terdiri dari 7 angka', '', 'warning');
            } else if (($('#ma_mplus_i').val() + $('#ma_mplus_o').val()) == 0) {
                swal('Qty harus > 0', '', 'warning');
            } else {
                swal({
                    title: 'Apakah anda yakin ingin menambahkan PLU ini ? ',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function (ok) {
                    if (ok) {
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current().'/insert-plu' }}',
                            type: 'post',
                            data: {
                                ma_prdcd: $('#ma_prdcd').val(),
                                ma_mplus_i: $('#ma_mplus_i').val(),
                                ma_mplus_o: $('#ma_mplus_o').val()
                            },
                            success: function (response) {
                                swal({
                                    title: response.title,
                                    text: response.message,
                                    icon: 'success'
                                }).then(function (ok) {
                                    $('#ma_prdcd').val('');
                                    $('#ma_mplus_i').val('');
                                    $('#ma_mplus_o').val('');
                                });
                            }, error: function (error) {
                                swal({
                                    title: error.responseJSON.title,
                                    text: error.responseJSON.message,
                                    icon: 'error'
                                });
                            }
                        })// ajax
                    }// if ok
                })
            }
        }

        function refreshTable() {
            $('#tblM').animate({
                scrollTop: $(".row-data-table-m:eq(0)").offset().top
            }, 2000);
            $('.row-data-table-m:eq(0)').click();
            $('.cb').prop('checked', false);
            $('#main_check').prop('checked', false);
        }

        function selectAll() {
            $('.cb').prop('checked', $('#main_check').is(':checked'));
        }

        function uploadMplus() {
            ajaxSetup();
            $.ajax({
                url: '{{ route('upload-mplus')  }}',
                type: 'POST',
                success: function (response) {
                    swal({
                        title: response.title,
                        text: response.message,
                        icon: 'success'
                    });
                },
                error: function (error) {
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error'
                    })
                }
            });
        }

    </script>
@endsection
