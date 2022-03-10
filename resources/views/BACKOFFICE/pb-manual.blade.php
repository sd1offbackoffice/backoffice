@extends('navbar')
@section('title','LAPORAN | LAPORAN MONITORING FAKTUR PAJAK SJ/NRB')
@section('content')


    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row form-group">
                            <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">NOMOR PB</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control text-left" id="nopb">
                                <button id="btn_lov_nopb" type="button" class="btn btn-primary btn-lov p-0"
                                        data-toggle="modal"
                                        data-target="#m_nopb">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-danger" id="btnHapusDokumen" onclick="hapusDokumen()" disabled>
                                    Hapus Dokumen
                                </button>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="model" readonly>
                            </div>
                            <label for="" class="col-sm-2 col-form-label text-right">Hg Jual</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="hgjual" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">TGL. PB</label>

                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="tglpb">
                            </div>

                            <label for="" class="offset-4 col-sm-2 col-form-label text-right">PKM</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="pkm" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">FLAG</label>
                            <div class="col-sm-2">
                                <select class="form-control" id="flag">
                                    <option value=" ">PB BIASA</option>
                                    <option value="1">PB KHUSUS</option>
                                    <option value="2">PB OMI</option>
                                </select>
                            </div>

                            <label class="radio-inline col-sm-1 mt-1 mr-0 pr-0">
                                <input class="radio tipe" type="radio" name="tipe" value="S" checked> REGULER
                            </label>
                            <label class="radio-inline col-sm-1 mt-1 ml-0 pl-0">
                                <input class="radio tipe" type="radio" name="tipe" value="N"> GMS
                            </label>
                            <label for="" class="offset-2 col-sm-2 col-form-label text-right">STOCK</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="stock" disabled>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">KETERANGAN</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control text-left" id="keterangan">
                            </div>

                            <label for="" class="offset-2 col-sm-2 col-form-label text-right">Minor</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="minor" disabled>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"> .:: DETAIL ::.</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="row form-group justify-content-center">
                            <div class="tableFixedHeader" style="border-bottom: 1px solid black">
                                <table class="table table-striped table-bordered" id="table-detail"
                                       style="table-layout:fixed;width: 100%;  ">
                                    <thead>
                                    <tr>
                                        <th colspan="10"></th>
                                        <th colspan="2" class="text-center">DISC I</th>
                                        <th colspan="2" class="text-center">DISC II</th>
                                        <th colspan="7"></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th>PRDCD</th>
                                        <th></th>
                                        <th>SATUAN</th>
                                        <th>CTN</th>
                                        <th>PCs</th>
                                        <th>OMI</th>
                                        <th>IDM</th>
                                        <th>Disc GO</th>
                                        <th>HRG. SATUAN</th>
                                        <th>RUPIAH</th>
                                        <th>%</th>
                                        <th>RUPIAH</th>
                                        <th>%</th>
                                        <th>BNS 1</th>
                                        <th>BNS 2</th>
                                        <th>NILAI</th>
                                        <th>PPN</th>
                                        <th>PPNBM</th>
                                        <th>BOTOL</th>
                                        <th>TOTAL</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody-detail">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">DESKRIPSI</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control text-left" id="deskripsi" disabled>
                            </div>

                            <div class="col-sm-2 offset-1">
                                <input type="text" class="form-control text-left" id="cari">
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary" onclick="cari()">CARI</button>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label for="" class="col-sm-2 col-form-label text-right pl-0 pr-0">SUPPLIER</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control text-left" id="kode-supplier" disabled>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" class="form-control text-left" id="supplier" disabled>
                            </div>
                            <div class=" offset-1 col-sm-3">
                                <button type="button" id="btn-save"
                                        class="btn btn-primary btn-block"
                                        onclick="saveData()" disabled> SAVE
                                </button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_nopb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_nopb">
                                    <thead class="thColor">
                                    <tr>
                                        <th>NO PB</th>
                                        <th>TGL PB</th>
                                        <th>DOC</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_pluHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_lov_plu">
                                    <thead class="thColor">
                                    <tr>
                                        <th>PLU</th>
                                        <th>DESKRIPSI</th>
                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    </tbody>
                                    <tfoot></tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let rowIterator = 0;
        let readonly = '';
        let disabled = '';
        let detail = [];

        let plurow;
        $(document).ready(function () {
            getLovNoPB('');
            getLovPLU('');
        })
        $('.tanggal').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('#tglpb').datepicker({
            "dateFormat": "dd/mm/yy",
        });
        $('.tanggal').on('apply.daterangepicker', function (ev, picker) {
            $('#tanggal-1').val(picker.startDate.format('DD/MM/YYYY'));
            $('#tanggal-2').val(picker.endDate.format('DD/MM/YYYY'));
        });
        $('.tanggal').on('cancel.daterangepicker', function (ev, picker) {
            $('#tanggal-1').val('');
            $('#tanggal-2').val('');
        });

        function getLovNoPB(val) {
            $('#btn_lov_npbp').empty().append('<i class="fas fa-spinner fa-spin"></i>').prop('disabled', true);
            if ($.fn.DataTable.isDataTable('#table_lov_nopb')) {
                $('#table_lov_nopb').DataTable().destroy();
                $("#table_lov_nopb tbody [role='row']").remove();
            }

            lovnopb = $('#table_lov_nopb').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/lov_nopb' }}',
                    data: {
                        value: val
                    }
                },
                "columns": [
                    {data: 'pbh_nopb', name: 'pbh_nopb'},
                    {data: 'pbh_tglpb', name: 'pbh_tglpb'},
                    {data: 'pbh_flagdoc', name: 'pbh_flagdoc'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-nopb').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $('#btn_lov_nopb').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-nopb', function (e) {
                        nopb = $(this).find(':eq(0)').html();
                        $('#nopb').val(nopb);

                        $('#m_nopb').modal('hide');
                        getDataPB(nopb);
                    });
                },
                "columnDefs": [
                    {
                        targets: [1],
                        render: function (data, type, row) {
                            return formatDate(data)
                        }
                    }
                ],
            });

            $('#table_lov_nopb_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    lovnopb.destroy();
                    getLovNoPB(val);
                }
            })
        }

        function getLovPLU(val) {
            if ($.fn.DataTable.isDataTable('#table_lov_plu')) {
                $('#table_lov_plu').DataTable().destroy();
                $("#table_lov_plu tbody [role='row']").remove();
            }

            lovplu = $('#table_lov_plu').DataTable({
                "ajax": {
                    type: 'GET',
                    url: '{{ url()->current().'/lov_search_plu' }}',
                    data: {
                        value: val
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
                    // $(row).find(':eq(0)').addClass('text-left');
                    $(row).addClass('row-plu').css({'cursor': 'pointer'});
                },
                "order": [],
                "initComplete": function () {
                    $(document).on('click', '.row-plu', function (e) {
                        $('#plu-' + plurow).val($(this).find(':eq(0)').html());
                        $('#m_pluHelp').modal('hide');
                    });
                }
            });

            $('#table_lov_plu_filter input').off().on('keypress', function (e) {
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    lovplu.destroy();
                    getLovPLU(val);
                }
            })
        }

        $('#nopb').on('keypress', function (e) {
            if (e.which == 13) {
                getDataPB($('#nopb').val());
            }
        })

        function getDataPB(val) {
            $.ajax({
                url: '{{ url()->current() }}/get-data-pb',
                type: 'get',
                data: {value: val},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    if(response.status == 'error'){
                        swal({
                            title: response.message,
                            icon: response.status
                        }).then((createData) => {
                        });
                    }
                    else{

                    $('#nopb').val(response['pb'].pbh_nopb);
                    $('#tglpb').val(formatDate(response['pb'].pbh_tglpb));
                    $('#model').val(response['MODEL']);
                    $('#keterangan').val(response['pb'].pbh_keteranganpb);
                    $("input[name=tipe][value='" + response['pb'].pbh_tipepb + "']").prop("checked", true);
                    $('#flag option[value=' + nvl(response['pb'].pbh_jenispb, 0) + ']').attr('selected', 'selected');
                    rowIterator = response['pbd'].length;
                    $('#table-detail').css("table-layout", "auto");

                    if (response['MODEL'] == 'TAMBAH') {
                        $('#tglpb').prop('disabled', false);
                        $('#flag').prop('disabled', false);
                        $('#keterangan').prop('disabled', false);
                        $('.tipe').prop('disabled', false);
                        $('#btnHapusDokumen').prop('disabled', true);
                        $('#btn-save').prop('disabled', false);

                        readonly = '';
                        disabled = '';
                    } else if (response['MODEL'] == 'KOREKSI') {
                        $('#tglpb').prop('disabled', false);
                        $('#flag').prop('disabled', false);
                        $('#keterangan').prop('disabled', false);
                        $('.tipe').prop('disabled', false);
                        $('#btnHapusDokumen').prop('disabled', false);
                        $('#btn-save').prop('disabled', false);

                        readonly = '';
                        disabled = '';
                    } else {
                        $('#tglpb').prop('disabled', true);
                        $('#flag').prop('disabled', true);
                        $('#keterangan').prop('disabled', true);
                        $('.tipe').prop('disabled', true);
                        readonly = 'readonly';
                        disabled = 'disabled';
                        $('#btnHapusDokumen').prop('disabled', true);
                        $('#btn-save').prop('disabled', true);
                    }

                    $('#tbody-detail').empty();
                    for (i = 0; i < response['pbd'].length; i++) {
                        $('#tbody-detail').append(
                            "<tr id='row-" + i + "' class='baris " + response["pbd"][i].pbd_prdcd + "' onclick='setDataPLU(\"" + i + "\",\"" + response["pbd"][i].pbd_prdcd + "\",\"" + response["pbd"][i].prd_deskripsipanjang.replace(/\'/g, ' ') + "\",\"" + response["pbd"][i].pbd_kodesupplier + "\",\"" + response["pbd"][i].sup_namasupplier + "\",\"" + response["pbd"][i].prd_hrgjual + "\",\"" + nvl(response["pbd"][i].pbd_pkmt, 0) + "\",\"" + nvl(response["pbd"][i].st_saldoakhir, 0) + "\",\"" + response["pbd"][i].minor + "\")'>\n" +
                            "    <td class='p-0'>\n" +
                            "        <button class='btn btn-sm btn-danger btn-delete' onclick='hapusBaris(\"" + i + "\")' " + disabled + ">X</button>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "<input type='text' class='form-control form-control-sm text-small input-plu' maxlength='7' value='" + nvl(response['pbd'][i].pbd_prdcd, '') + "' id='plu-" + rowIterator + "' onkeypress='cek_plu(" + i + ", this.value, event)' " + readonly + ">" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "<button type='button' class='btn btn-sm btn-lov-plu p-0' data-toggle='modal' data-target='#m_pluHelp' onclick='pluhelp(" + i + ")' " + disabled + "><img src='{{asset('image/icon/help.png')}}' width='25px' ></button>" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm input-satuan' value='" + response["pbd"][i].satuan + "' >\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input class='form-control form-control-sm text-right input-ctn' value='" + response["pbd"][i].qtyctn + "' onkeypress='cek_ctn(\"" + i + "\", this.value, event)' " + readonly + ">\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input class='form-control form-control-sm text-right input-pcs' value='" + response["pbd"][i].qtypcs + "' onkeypress='cek_pcs(\"" + i + "\", this.value, event)' " + readonly + ">\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm' value='" + response["pbd"][i].f_omi + "'\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm' value='" + response["pbd"][i].f_idm + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm' value='" + nvl(response["pbd"][i].pbd_fdxrev, '') + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right input-harga-satuan'\n" +
                            "               value='" + convertToRupiah2(response["pbd"][i].pbd_hrgsatuan) + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right' value='" + response["pbd"][i].pbd_rphdisc1 + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right persendisc1' value='" + convertToRupiah(response["pbd"][i].pbd_persendisc1) + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right' value='" + convertToRupiah2(response["pbd"][i].pbd_rphdisc2) + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right persendisc2' value='" + convertToRupiah(response["pbd"][i].pbd_persendisc2) + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right bonus1' value='" + response["pbd"][i].pbd_bonuspo1 + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right bonus2' value='" + nvl(response["pbd"][i].pbd_bonuspo2, '') + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right gross'\n" +
                            "               value='" + convertToRupiah(response["pbd"][i].pbd_gross) + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right ppn'\n" +
                            "               value='" + convertToRupiah(response["pbd"][i].pbd_ppn) + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right ppnbm' value='" + convertToRupiah(response["pbd"][i].pbd_ppnbm) + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right ppnbotol' value='" + convertToRupiah(response["pbd"][i].pbd_ppnbotol) + "'>\n" +
                            "    </td>\n" +
                            "    <td class='p-0'>\n" +
                            "        <input disabled class='form-control form-control-sm text-right total'\n" +
                            "               value='" + convertToRupiah2(response["pbd"][i].total) + "'>\n" +
                            "    </td>\n" +
                            "</tr>"
                        );
                    }

                    if (response['MODEL'] == 'TAMBAH' || response['MODEL'] == 'KOREKSI') {
                        tambah_row();
                    }
                    }

                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });
        }

        function setDataPLU(row, plu, deskripsi, kdsupplier, nmsupplier, hargajual, pkm, stock, minor) {
            $('#deskripsi').val(deskripsi);
            $('#kode-supplier').val(kdsupplier);
            $('#supplier').val(nmsupplier);
            $('#hgjual').val(convertToRupiah2(hargajual));
            $('#pkm').val(convertToRupiah2(pkm));
            $('#stock').val(convertToRupiah2(stock));
            $('#minor').val(convertToRupiah2(minor));

            // $(".baris").children('td').each(function () {
            //     $(this).find("input").removeAttr('style');
            //     $(this).find("select").removeAttr('style');
            //     if ($('#model').val() == 'TAMBAH' || $('#model').val() == 'KOREKSI') {
            //         // $(this).find(".btn-lov-plu").hide();
            //         // $(this).find(".inside").removeClass('buttonInside');
            //     }
            //
            // });
            // $("#row-" + row).children('td').each(function () {
            // $(this).find("input").css("background-color", "lightblue");
            // $(this).find("select").css("background-color", "lightblue");
            // $(this).find("input").css("color", "white");
            // if ($('#model').val() == 'TAMBAH' || $('#model').val() == 'KOREKSI') {
            // $(this).find("select").css("color", "white");
            // $(this).find(".btn-lov-plu").show();
            // $(this).find(".inside").addClass('buttonInside');
            // }
            // });
        };
        function hapusBaris(row) {
            $('#row-' + row).remove();
            if ($('#tbody-detail').find('tr').length == 0) {
                tambah_row();
            }
        }
        function tambah_row() {
            $('#tbody-detail').append(
                '<tr id="row-' + rowIterator + '" class="baris" onclick="setDataPLU(\'' + rowIterator + '\',\'\',\'\',\'\',\'\',\'\',\'\',\'\',\'\')">\n' +
                '    <td class="p-0">\n' +
                '        <button class="btn btn-sm btn-danger btn-delete" onclick="hapusBaris(\'' + rowIterator + '\')">X</button>\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '           <input type="text" class="form-control form-control-sm text-small input-plu" maxlength="7" id="plu-' + rowIterator + '" onkeypress="cek_plu(\'' + rowIterator + '\', this.value, event)">' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '           <button type="button" class="btn btn-sm btn-lov-plu p-0" data-toggle="modal" data-target="#m_pluHelp" onclick="pluhelp(\'' + rowIterator + '\')"><img src="{{asset('image/icon/help.png')}}" width="25px"></button>' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm input-satuan" value="">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input class="form-control form-control-sm text-right input-ctn" value="0" onkeypress="cek_ctn(' + rowIterator + ', this.value, event)">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input class="form-control form-control-sm text-right input-pcs" value="0" onkeypress="cek_pcs(' + rowIterator + ', this.value, event)">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm" value="">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm" value="">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm" value="">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right input-harga-satuan"\n' +
                '               value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right persendisc1" value="0.00">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right persendisc2" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right bonus1" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right bonus2" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right gross" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right ppn"\n' +
                '               value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right ppnbm" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right ppnbotol" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm text-right total"\n' +
                '               value="0">\n' +
                '    </td>\n' +
                '</tr>'
            );
            $('#deskripsi').val("");
            $('#kode-supplier').val("");
            $('#nama-supplier').val("");
            $('#harga-jual').val("");
            $('#pkm').val("");
            $('#stock').val("");
            $('#minor').val("");
            rowIterator++;
            console.log("rowit+:" +rowIterator);
        }

        function pluhelp(row) {
            plurow = row;
        }

        function cari() {
            val = $('#cari').val();
            $("#tbody-detail").children('tr').each(function () {
                if ($($(this)[0].cells[1]).children('input').val() == val) {
                    $($(this)[0].cells[1]).children('input').focus().click();
                }
            });
        }

        function cek_plu(row, value, e) {
            var div = $('#row-' + row);
            value = convertPlu(value);
            value = value.substring(0, 6)+'0';
            if (e.which == '13') {
                div.find('.input-plu').val(value);
                if (!$.isNumeric(value)) {
                    swal({
                        title: "PLU harus angka!",
                        icon: "error"
                    }).then((createData) => {
                        div.find('.input-plu').val("");
                        div.find('.input-plu').focus();
                    });
                } else {
                    pluCount = 0;
                    $("#tbody-detail").children('tr').each(function () {
                        if ($($(this)[0].cells[1]).children('input').val() == value) {
                            pluCount++;
                        }
                    });
                   console.log("plu:"+pluCount);
                    if (pluCount < 2) {
                        tgl = $('#tglpb').val();
                        nopb = $('#nopb').val();
                        flag = $('#flag').val();
                        ajaxSetup();
                        $.ajax({
                            url: '{{ url()->current() }}/cek_plu',
                            type: 'POST',
                            data: {plu: value, tglpb: tgl, nopb: nopb, flag: flag},
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (response) {
                                if (response['message'] != "") {
                                    swal({
                                        title: response['message'],
                                        icon: response['status']
                                    }).then((createData) => {
                                        rowIterator--;
                                        div.remove();
                                        tambah_row();
                                        // div.find('.input-plu').val("");
                                        // div.find('.input-plu').focus();
                                    });
                                } else {
                                    div.remove();
                                    $('#tbody-detail').append(
                                        "<tr id='row-" + row + "' class='baris " + response["plu"].pbd_prdcd + "' onclick='setDataPLU(\"" + row + "\",\"" + response["plu"].pbd_prdcd + "\",\"" + response["plu"].prd_deskripsipanjang.replace(/\'/g, ' ') + "\",\"" + response["plu"].pbd_kodesupplier + "\",\"" + response["plu"].sup_namasupplier + "\",\"" + response["plu"].prd_hrgjual + "\",\"" + nvl(response["plu"].pbd_pkmt, 0) + "\",\"" + nvl(response["plu"].st_saldoakhir, 0) + "\",\"" + response["plu"].minor + "\")'>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <button class='btn btn-sm btn-danger btn-delete' onclick='hapusBaris(\"" + row + "\")'>X</button>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        '<input type="text" class="form-control form-control-sm text-small input-plu" maxlength="7" value="' + nvl(response["plu"].pbd_prdcd, '') + '" id="plu-' + row + '" onkeypress="cek_plu(\'' + row + '\', this.value, event)">' +
                                        "    </td>\n" +
                                        "<td class='p-0'>\n" +
                                        '<button type="button" class="btn btn-sm btn-lov-plu p-0" data-toggle="modal" data-target="#m_pluHelp" onclick="pluhelp(\'' + row + '\')"><img src="{{asset('image/icon/help.png')}}" width="25px"></button>' +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm input-satuan' value='" + response["plu"].satuan + "' >\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input class='form-control form-control-sm text-right input-ctn' value='0' onkeypress='cek_ctn(\"" + row + "\", this.value, event)'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input class='form-control form-control-sm text-right input-pcs' value='0' onkeypress='cek_pcs(\"" + row + "\", this.value, event)'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm' value='" + response["plu"].f_omi + "'\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm' value='" + response["plu"].f_idm + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm' value='" + nvl(response["plu"].pbd_fdxrev, '') + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right input-harga-satuan'\n" +
                                        "               value='" + convertToRupiah2(response["plu"].pbd_hrgsatuan) + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right' value='" + response["plu"].pbd_rphdisc1 + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right persendisc1' value='" + convertToRupiah(response["plu"].pbd_persendisc1) + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right' value='" + convertToRupiah2(response["plu"].pbd_rphdisc2) + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right persendisc2' value='" + convertToRupiah(response["plu"].pbd_persendisc2) + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right bonus1' value=''>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm bonus2' value=''>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right gross'\n" +
                                        "               value=''>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right ppn'\n" +
                                        "               value='" + convertToRupiah(response["plu"].pbd_ppn) + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right ppnbm' value='" + convertToRupiah(response["plu"].pbd_ppnbm) + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right ppnbotol' value='" + convertToRupiah(response["plu"].pbd_ppnbotol) + "'>\n" +
                                        "    </td>\n" +
                                        "    <td class='p-0'>\n" +
                                        "        <input disabled class='form-control form-control-sm text-right total'\n" +
                                        "               value='" + convertToRupiah2(response["plu"].total) + "'>\n" +
                                        "    </td>\n" +
                                        "</tr>"
                                    );
                                    detail[row] = response["plu"];
                                    console.log("row: "+row);
                                    $('#row-' + row).find('.input-ctn').click().focus().select();
                                }
                            },
                            complete: function () {
                                $('#modal-loader').modal('hide');
                            }
                        });
                    }
                    else {
                        swal({
                            title: "PLU sudah ada !",
                            icon: 'error'
                        }).then((createData) => {
                            $('#row-' + row).find('.input-plu').val('');
                            $('#row-' + row).find('.input-plu').focus();
                        });
                    }
                }
            }
        }

        function cek_ctn(row, value, e) {
            if (e.which == '13') {
                var div = $('#row-' + row);
                hitung(row);
                div.find('.input-pcs').click().focus().select();
            }
        }

        function cek_pcs(row, value, e) {
            var div = $('#row-' + row);
            if (e.which == '13') {
                var target = e.srcElement || e.target;
                var next = div[0].nextElementSibling;

                qtypb = parseInt(div.find('.input-ctn').val() * detail[row].prd_frac) + parseInt(value);


                if ((div.find('.input-ctn').val() * detail[row].prd_frac) + value < detail[row].minor) {
                    swal({
                        title: "QTYB + QTYK < MINOR !",
                        icon: "error"
                    }).then((createData) => {
                        div.find('.input-ctn').focus();
                    });
                } else if ((div.find('.input-ctn').val() * detail[row].prd_frac) + value <= 0) {
                    swal({
                        title: "QTYB + QTYK <= 0",
                        icon: "error"
                    }).then((createData) => {
                        div.find('.input-ctn').focus();
                    });
                } else {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/cek_bonus',
                        type: 'POST',
                        data: {

                            plu: detail[row].pbd_prdcd,
                            kdsup: detail[row].pbd_kodesupplier,
                            tgl: $('#tglpb').val(),
                            frac: detail[row].prd_frac,
                            qtypb: qtypb
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            if (response['prd'].v_oke == 'TRUE') {
                                div.find('.ppn').val(convertToRupiah(response['prd'].ppn));
                                div.find('.ppnbm').val(convertToRupiah(response['prd'].ppnbm));
                                div.find('.ppnbotol').val(convertToRupiah(response['prd'].ppnbtl));
                                hitung(row);
                                if (next == null) {
                                    $('#row-'+row).find('.input-plu,.btn-lov-plu').prop('disabled',true);
                                    tambah_row();
                                    $('#row-'+parseInt(row+1)).find('.input-plu').click().focus();
                                }
                            } else {
                                swal({
                                    title: response['message'],
                                    icon: response['status']
                                }).then((createData) => {
                                });
                            }
                        },
                        complete: function () {
                            $('#modal-loader').modal('hide');
                        }
                    });
                }
            }
        }

        function hitung(row) {
            var div = $('#row-' + row);
            div.find('.input-pcs').focus();
            frac = detail[row].prd_frac;
            hargasatuan = detail[row].pbd_hrgsatuan;
            qtyctn = div.find('.input-ctn').val();
            qtypcs = div.find('.input-pcs').val();
            persendisc1 = detail[row].pbd_persendisc1;
            persendisc2 = detail[row].pbd_persendisc2;
            hargabeli = (qtyctn * hargasatuan) + (qtypcs * (hargasatuan / frac));
            gross = hargabeli - (hargabeli * persendisc1 / 100);
            hargabeli = gross;
            gross = hargabeli - (hargabeli * persendisc2 / 100);
            ppn = gross * 10 / 100;
            ppnbm = nvl(detail[row].pbd_ppnbm, 0) * nvl(detail[row].pbd_qtypb, 0);
            ppnbotol = nvl(detail[row].pbd_ppnbotol, 0) * nvl(detail[row].pbd_qtypb, 0);
            total = gross + ppn + ppnbm + ppnbotol;

            detail[row].pbd_gross = gross;
            detail[row].pbd_ppn = ppn;
            detail[row].pbd_ppnbm = ppnbm;
            detail[row].pbd_ppnbotol = ppnbotol;
            detail[row].total = total;

            div.find('.gross').val(convertToRupiah(gross));
            div.find('.ppn').val(convertToRupiah(ppn));
            div.find('.ppnbm').val(convertToRupiah(ppnbm));
            div.find('.ppnbotol').val(convertToRupiah(ppnbotol));
            div.find('.total').val(convertToRupiah(total));
        }

        function saveData() {
            swal({
                title: 'Yakin ingin menyimpan data?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(ok){
                if(ok) {
                    nopb = $("#nopb").val();
                    tglpb = $("#tglpb").val();
                    flag = $("#flag").val();
                    tipe = $("input[name='tipe']:checked").val();
                    keterangan = $("#keterangan").val();
                    simpan = true;
                    data = {};
                    data.prdcd = [];
                    data.kodedivisi = [];
                    data.kodedivisipo = [];
                    data.kodedepartement = [];
                    data.kodekategoribrg = [];
                    data.kodesupplier = [];
                    data.nourut = [];
                    data.qtypb = [];
                    data.hargasatuan = [];
                    data.persendisc1 = [];
                    data.rphdisc1 = [];
                    data.flagdisc1 = [];
                    data.persendisc2 = [];
                    data.rphdisc2 = [];
                    data.flagdisc2 = [];
                    data.bonuspo1 = [];
                    data.bonuspo2 = [];
                    data.gross = [];
                    data.rphttldisc = [];
                    data.ppn = [];
                    data.ppnbm = [];
                    data.ppnbotol = [];
                    data.top = [];
                    data.pkmt = [];
                    data.saldoakhir = [];
                    data.fdxrev = [];

                    data.gantiaku = [];

                    i = 0;
                    $("#tbody-detail").find('tr').each(function () {
                        temp = [];
                        rid = $(this)[0].id;
                        splitted_id = rid.split('-');
                        id = splitted_id[1];

                        $(this).find("td").each(function () {
                            temp.push($(this).find("input").val());
                        });
                        if (temp[1] != '') {
                            if ((temp[3] * detail[id].prd_frac) + temp[4] < detail[id].minor) {
                                swal({
                                    title: "QTYB + QTYK < MINOR !",
                                    icon: "error"
                                }).then((createData) => {
                                    $(rid).find('.input-ctn').focus();
                                });
                            } else if ((temp[3] * detail[id].prd_frac) + temp[4] <= 0) {
                                simpan = false;
                                swal({
                                    title: "QTYB + QTYK <= 0",
                                    icon: "error"
                                }).then((createData) => {
                                    $(rid).find('.input-ctn').focus();
                                });
                            } else {
                                data.prdcd[i] = temp[1];
                                data.kodedivisi[i] = detail[id].pbd_kodedivisi;
                                data.kodedivisipo[i] = detail[id].prd_kodedivisipo;
                                data.kodedepartement[i] = detail[id].prd_kodedepartement;
                                data.kodekategoribrg[i] = detail[id].prd_kodekategoribarang;
                                data.kodesupplier[i] = detail[id].pbd_kodesupplier;
                                data.nourut[i] = i + 1;
                                data.qtypb[i] = parseInt(temp[3] * detail[id].prd_frac) + parseInt(temp[4]);
                                data.hargasatuan[i] = detail[id].pbd_hrgsatuan;
                                data.persendisc1[i] = detail[id].pbd_persendisc1;
                                data.rphdisc1[i] = detail[id].pbd_rphdisc1;
                                data.flagdisc1[i] = detail[id].pbd_flagdisc1;
                                data.persendisc2[i] = detail[id].pbd_persendisc2;
                                data.rphdisc2[i] = detail[id].pbd_rphdisc2;
                                data.flagdisc2[i] = detail[id].pbd_flagdisc2;
                                data.bonuspo1[i] = temp[13];
                                data.bonuspo2[i] = temp[14];
                                data.gross[i] = unconvertToRupiah(temp[15]);
                                data.ppn[i] = unconvertToRupiah(temp[16]);
                                data.ppnbm[i] = unconvertToRupiah(temp[17]);
                                data.ppnbotol[i] = unconvertToRupiah(temp[18]);
                                data.top[i] = detail[id].pbd_top;
                                data.pkmt[i] = detail[id].pbd_pkmt;
                                data.saldoakhir[i] = detail[id].st_saldoakhir;
                                data.fdxrev[i] = detail[id].pbd_fdxrev;
                            }
                        }

                        console.log(id + "==============================================================================");
                        i++;
                    });
                    console.log(data);

                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/save_data',
                        type: 'POST',
                        data: {
                            nopb: nopb,
                            tglpb: tglpb,
                            flag: flag,
                            tipe: tipe,
                            keterangan: keterangan,
                            data: data
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            console.log(response);
                            $('#nopb').val('');
                            $('#flag option[value="0"]').attr('selected', 'selected');
                            $("input[name=tipe][value='R']").prop("checked", true);
                            $('.baris').remove();
                            clear_field();
                            swal({
                                title: response['message'],
                                icon: response['status']
                            }).then((createData) => {
                                location.reload();
                            });
                        },
                        complete: function () {
                            $('#modal-loader').modal('hide');
                        }
                    });
                }
            });
        }
    </script>

@endsection
