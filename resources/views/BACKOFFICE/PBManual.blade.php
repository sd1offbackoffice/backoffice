@extends('navbar')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5"></legend>
                    <div class="card-body cardForm ">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mb-0 ">
                                        <label class="col-sm-1 col-form-label text-sm-right" style="font-size: 12px">NOMOR
                                            PB</label>
                                        <input type="text" id="no-pb"
                                               class="form-control form-control-sm col-sm-2">
                                        <div class="col-sm-2">
                                            <button class="btn float-left pl-0 btn-sm" type="button"
                                                    data-target="#m_pbHelp" data-toggle="modal"
                                                    onclick=""><img
                                                        src="{{asset('image/icon/help.png')}}" height="20px"
                                                        width="20px">
                                            </button>
                                            <button type="button" id="btn-hapus-dokumen"
                                                    class="btn btn-danger btn-sm float-left ">Hapus Dokumen
                                            </button>
                                        </div>
                                        <input type="text" id="model"
                                               class="form-control form-control-sm col-sm-3" disabled>
                                        <label class="col-sm-2 col-form-label text-sm-right" style="font-size: 12px">HG
                                            JUAL</label>
                                        <input type="text" id="harga-jual"
                                               class="form-control form-control-sm col-sm-2 text-right" disabled>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-md-right"
                                               style="font-size: 12px">TGL. PB</label>
                                        <input type="text" id="tgl-pb"
                                               class="form-control form-control-sm col-sm-2">
                                        <label class="col-sm-7 col-form-label text-md-right"
                                               style="font-size: 12px">PKM</label>
                                        <input type="text" id="pkm"
                                               class="form-control form-control-sm col-sm-2 text-right" disabled>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-md-right" style="font-size: 12px">FLAG</label>
                                        <select class="form-control form-control-sm col-sm-2" id="flag">
                                            <option value="0">PB BIASA</option>
                                            <option value="1">PB KHUSUS</option>
                                            <option value="2">PB OMI</option>
                                        </select>
                                        <div class="col-sm-2 form-check form-check-inline p-0 pl-2 m-0">
                                            <input class="form-check-input" type="radio" name="typePB"
                                                   id="radio-reguler"
                                                   value="R" checked>
                                            <label class="form-check-label" for="radio-reguler">REGULER</label>
                                            <input class="form-check-input ml-2" type="radio" name="typePB"
                                                   id="radio-gms"
                                                   value="G">
                                            <label class="form-check-label" for="radio-gms">GMS</label>
                                        </div>
                                        <label class="col-sm-5 col-form-label text-sm-right" style="font-size: 12px">STOCK</label>
                                        <input type="text" id="stock"
                                               class="form-control form-control-sm col-sm-2 text-right" disabled>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-md-right" style="font-size: 12px">KETERANGAN</label>
                                        <input type="text" id="keterangan"
                                               class="form-control form-control-sm col-sm-4">
                                        <input type="text" id="tgltrf" style="display: none;"
                                               class="form-control form-control-sm col-sm-4">
                                        <label class="col-sm-5 col-form-label text-sm-right" style="font-size: 12px">MINOR</label>
                                        <input type="text" id="minor"
                                               class="form-control form-control-sm col-sm-2 text-right" disabled>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Detail</legend>
                    <div class="card-body cardForm">
                        <div class="card-body p-0 tableFixedHeader">
                            <table class="table table-striped table-bordered"
                                   id="table-detail">
                                <thead class="thead-dark">
                                <tr class="table-sm text-center">
                                    <th class="text-center small" colspan="9"></th>
                                    <th class="text-center small" colspan="2">DISC. I</th>
                                    <th class="text-center small" colspan="2">DISC. II</th>
                                    <th class="text-center small" colspan="7"></th>
                                </tr>
                                <tr class="table-sm text-center">
                                    <th class="text-center small"></th>
                                    <th width="10%" class="text-center small">PRDCD</th>
                                    <th width="6%" class="text-center small">SATUAN</th>
                                    <th width="5%" class="text-center small">CTN</th>
                                    <th width="3%" class="text-center small">PCs</th>
                                    <th width="1%" class="text-center small">OMI</th>
                                    <th width="1%" class="text-center small">IDM</th>
                                    <th width="1%" class="text-center small">DISC GO</th>
                                    <th width="8%" class="text-center small">HRG.SATUAN</th>
                                    <th width="8%" class="text-center small">RUPIAH</th>
                                    <th width="4%" class="text-center small">%</th>
                                    <th width="8%" class="text-center small">RUPIAH</th>
                                    <th width="4%" class="text-center small">%</th>
                                    <th width="4%" class="text-center small">BNS 1</th>
                                    <th width="4%" class="text-center small">BNS 2</th>
                                    <th width="10%" class="text-center small">NILAI</th>
                                    <th width="8%" class="text-center small">PPN</th>
                                    <th width="3%" class="text-center small">PPNBM</th>
                                    <th width="3%" class="text-center small">BOTOL</th>
                                    <th width="10%" class="text-center small">TOTAL</th>
                                </tr>
                                </thead>
                                <tr class="baris">
                                    <td class="p-0">
                                        <button class="btn btn-sm btn-danger btn-delete">X</button>
                                    </td>
                                    <td class="p-0">
                                        <input class="form-control form-control-sm text-small input-plu"
                                               value="1233243">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm" value="CTN/48">
                                    </td>
                                    <td class="p-0">
                                        <input class="form-control form-control-sm text-right" value="3">
                                    </td>
                                    <td class="p-0">
                                        <input class="form-control form-control-sm text-right input-pcs" value="0">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm" value="Y">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm" value="N">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm" value="N">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right"
                                               value="1,020,000.00">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right" value="0.00">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right" value="0.00">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right" value="0.00">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right" value="0">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right" value="0">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm" value="">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right"
                                               value="2,160,000.00">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right"
                                               value="216,000.00">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right" value="0.00">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right" value="0.00">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right"
                                               value="2,376,000.00">
                                    </td>
                                </tr>
                                <tbody id="body-table-detail">
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-md-right"
                                               style="font-size: 12px">DESKRIPSI</label>
                                        <input type="text" id="deskripsi"
                                               class="form-control form-control-sm col-sm-5" disabled>
                                        <div class="col-sm-1"></div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-md-right"
                                               style="font-size: 12px">SUPPLIER</label>
                                        <input type="text" id="kode-supplier"
                                               class="form-control form-control-sm col-sm-1" disabled>
                                        <input type="text" id="nama-supplier"
                                               class="form-control form-control-sm col-sm-4" disabled>
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-4 row">
                                            <input type="text" id="plu-search"
                                                   class="form-control form-control-sm col-sm-6">
                                            <button type="button" id="btn-search"
                                                    class="btn btn-sm btn-success"
                                                    href='1481700' onclick=""> SEARCH
                                            </button>
                                        </div>
                                        <div class="col-sm-1">
                                            <button type="button" id="btn-save"
                                                    class="btn btn-sm btn-primary float-right"
                                                    onclick=""> SAVE
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_pbHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov" class="form-control search_lov" type="text" placeholder="Inputkan No PB"
                               aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table" id="table_lov">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td>No .PB</td>
                                        <td>Tgl. PB</td>
                                        <td>DOC</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--->select('PBH_TGLPB','PBH_TIPEPB','PBH_JENISPB','PBH_FLAGDOC','PBH_KETERANGANPB','PBH_TGLTRANSFER')--}}

                                    @foreach($pb as $p)
                                        <tr onclick="get_data_pb('{{ $p->pbh_nopb }}')" class="row_lov">
                                            <td>{{ $p->pbh_nopb }}</td>
                                            <td>{{ date('d-M-y',strtotime($p->pbh_tglpb)) }}</td>
                                            <td>{{ $p->pbh_flagdoc }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    {{--MODAL PLU--}}
    <div class="modal fade" id="m_pluHelp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="form-row col-sm">
                        <input id="search_lov_plu" class="form-control search_lov_plu" type="text"
                               placeholder="Inputkan Deskripsi / PLU Produk" aria-label="Search">
                        <div class="invalid-feedback">
                            Inputkan minimal 3 karakter
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov_plu">
                                <table class="table" id="table_lov_plu">
                                    <thead>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td>PLU</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($produk as $p)
                                        <tr onclick="lov_plu_select('{{ $p->prd_prdcd }}')" class="row_lov_plu">
                                            <td>{{ $p->prd_deskripsipanjang }}</td>
                                            <td>{{ $p->prd_prdcd }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .row_lov:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .row_lov_plu:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }

        .buttonInside {
            position: relative;
        }

        .btn-lov-plu {
            position: absolute;
            right: 4px;
            top: 1px;
            border: none;
            height: 30px;
            width: 30px;
            border-radius: 100%;
            outline: none;
            text-align: center;
            font-weight: bold;

        }
    </style>

    <script>
        $(document).ready(function () {
            $('#tgl-pb').datepicker({"dateFormat": "dd/mm/yy"});
            // $('#no-pb').val('222003174');
            // // $('#no-pb').val('');
            // var e = $.Event("keypress");
            // e.keyCode = 13;
            // $('#no-pb').trigger(e);
            // $("input[name='radioOptions']:checked").val();
        });
        rowIterator = -1;
        onrow = 0;
        detail = '';
        $('#no-pb').keypress(function (e) {
            if (e.keyCode == 13) {
                var pb = $(this).val();
                get_data_pb(pb);
            }
        });

        function clear_field() {
            rowIterator = -1;
            onrow = 0;
            detail = '';

            $('#tgl-pb').val("");
            $('#keterangan').val("");
            $('#harga-jual').val("");
            $('#pkm').val("");
            $('#stock').val("");
            $('#minor').val("");
            $('#model').val("");

            $('#btn-hapus-dokumen').prop("disabled", false);
            $('.btn-delete').show();
            $('.input-plu').prop("disabled", false);
            $('.input-ctn').prop("disabled", false);
            $('.input-pcs').prop("disabled", false);
            $('#tgl-pb').prop("disabled", false);
            $('#flag').prop("disabled", false);
            $('#flag option[value="0"]').attr('selected', 'selected');

            $('#keterangan').prop("disabled", false);
            $("input[name=typePB]").prop("disabled", false);
        }

        function get_data_pb(value) {
            clear_field();
            $('.baris').remove();
            if (value == '') {
                swal({
                    title: "BUAT SURAT JALAN BARU?",
                    icon: 'info',
                    buttons: true
                }).then((createData) => {
                    if (createData) {
                        $.ajax({
                            url: '/BackOffice/public/api/bopbmanual/getDataPB',
                            type: 'POST',
                            data: {"_token": "{{ csrf_token() }}", value: value},
                            beforeSend: function () {
                                $('#m_pbHelp').modal('hide');
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (response) {
                                console.log(response);
                                $('#no-pb').val(response['pb'].pbh_nopb);
                                $('#tgl-pb').val(formatDate(response['pb'].pbh_tglpb));
                                $('#model').val(response['MODEL']);
                                tambah_row();
                            },
                            complete: function () {
                                if ($('#m_pbHelp').is(':visible')) {
                                    $('#search_lov').val('');
                                    $('#table_lov .row_lov').remove();
                                    $('#table_lov').append(trlov);
                                }
                                $('#modal-loader').modal('hide');
                            }
                        });
                    }
                });
            }
            else {
                $.ajax({
                    url: '/BackOffice/public/api/bopbmanual/getDataPB',
                    type: 'POST',
                    data: {"_token": "{{ csrf_token() }}", value: value},
                    beforeSend: function () {
                        $('#m_pbHelp').modal('hide');
                        $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                    },
                    success: function (response) {
                        console.log(response);
                        if (response['status'] != "") {
                            swal({
                                title: response['message'],
                                icon: response['status']
                            }).then((createData) => {
                            });
                        }
                        else {
                            $('#no-pb').val(response['pb'].pbh_nopb);
                            $('#tgl-pb').val(formatDate(response['pb'].pbh_tglpb));
                            $('#model').val(response['MODEL']);
                            $("input[name=typePB][value='" + response['pb'].pbh_tipepb + "']").prop("checked", true);
                            $('#flag option[value=' + nvl(response['pb'].pbh_jenispb, 0) + ']').attr('selected', 'selected');
                            $('#keterangan').val(response['pb'].pbh_keteranganpb);
                            $('#tgltrf').val(response['pb'].pbh_tgltransfer);

                            detail = response['pbd'];
                            for (i = 0; i < response['pbd'].length; i++) {
                                rowIterator++;
                                $('#table-detail').append(
                                    "<tr id='row-" + rowIterator + "' class='baris' onclick='setDataPLU(\"" + rowIterator + "\",\"" + response["pbd"][i].pbd_prdcd + "\",\"" + response["pbd"][i].prd_deskripsipanjang.replace('\'', '^') + "\",\"" + response["pbd"][i].pbd_kodesupplier + "\",\"" + response["pbd"][i].sup_namasupplier + "\",\"" + response["pbd"][i].prd_hrgjual + "\",\"" + nvl(response["pbd"][i].pbd_pkmt,0) + "\",\"" + nvl(response["pbd"][i].st_saldoakhir,0) + "\",\"" + response["pbd"][i].minor + "\")'>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <button class='btn btn-sm btn-danger btn-delete' onclick='hapusBaris(\"" + rowIterator + "\")'>X</button>\n" +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    '<div class="inside">' +
                                    '<input type="text" class="form-control form-control-sm text-small input-plu" maxlength="7" value="' + nvl(response["pbd"][i].pbd_prdcd, '') + '" onkeypress="cek_plu(\'' + rowIterator + '\', this.value, event)">' +
                                    '<button type="button" style="display: none" class="btn btn-sm btn-lov-plu p-0" data-toggle="modal" data-target="#m_pluHelp" onclick="pluhelp(\'' + rowIterator + '\')"><img src="{{asset('image/icon/help.png')}}" width="25px"></button>' +
                                    '</div>' +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <input disabled class='form-control form-control-sm input-satuan' value='" + response["pbd"][i].satuan + "' >\n" +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <input class='form-control form-control-sm text-right input-ctn' value='" + response["pbd"][i].qtyctn + "' onkeypress='cek_ctn(\"" + rowIterator + "\", this.value, event)'>\n" +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <input class='form-control form-control-sm text-right input-pcs' value='" + response["pbd"][i].qtypcs + "' onkeypress='cek_pcs(\"" + rowIterator + "\", this.value, event)'>\n" +
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
                                    "        <input disabled class='form-control form-control-sm text-right' value='" + response["pbd"][i].pbd_bonuspo1 + "'>\n" +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <input disabled class='form-control form-control-sm' value='" + nvl(response["pbd"][i].pbd_bonuspo2, '') + "'>\n" +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <input disabled class='form-control form-control-sm text-right gross'\n" +
                                    "               value='" + convertToRupiah2(response["pbd"][i].pbd_gross) + "'>\n" +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <input disabled class='form-control form-control-sm text-right ppn'\n" +
                                    "               value='" + convertToRupiah2(response["pbd"][i].pbd_ppn) + "'>\n" +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <input disabled class='form-control form-control-sm text-right ppnbm' value='" + convertToRupiah2(response["pbd"][i].pbd_ppnbm) + "'>\n" +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <input disabled class='form-control form-control-sm text-right ppnbotol' value='" + convertToRupiah2(response["pbd"][i].pbd_ppnbotol) + "'>\n" +
                                    "    </td>\n" +
                                    "    <td class='p-0'>\n" +
                                    "        <input disabled class='form-control form-control-sm text-right total'\n" +
                                    "               value='" + convertToRupiah2(response["pbd"][i].total) + "'>\n" +
                                    "    </td>\n" +
                                    "</tr>"
                                );
                            }
                            if (response['MODEL'] == 'KOREKSI') {
                                swal({
                                    title: "KOREKSI",
                                    icon: 'error'
                                }).then((createData) => {

                                });
                            }
                            else if (response['MODEL'] == 'PB SUDAH DICETAK / TRANSFER') {
                                $('.btn-delete').hide();
                                $('#btn-hapus-dokumen').prop("disabled", "disabled");
                                $('.input-plu').prop("disabled", "disabled");
                                $('.input-ctn').prop("disabled", "disabled");
                                $('.input-pcs').prop("disabled", "disabled");
                            }
                            $('#tgl-pb').prop("disabled", "disabled");
                            $('#flag').prop("disabled", "disabled");
                            $('#keterangan').prop("disabled", "disabled");
                            $("input[name=typePB]").prop("disabled", "disabled");

                            height = $('#table-detail tr:last').innerHeight();
                            $('#table-detail tr:last .input-plu').focus();
                            $('.tableFixedHeader').animate({scrollTop: height * response['pbd'].length}, 100);
                        }
                    },
                    complete: function () {
                        if ($('#m_pbHelp').is(':visible')) {
                            $('#search_lov').val('');
                            $('#table_lov .row_lov').remove();
                            $('#table_lov').append(trlov);
                        }
                        $('#modal-loader').modal('hide');
                    }
                });
            }
        }

        function hapusBaris(nopb, plu, baris) {
            $('#' + plu).remove();
        }

        var trlov = $('#table_lov tbody').html();

        $('#search_lov').keypress(function (e) {
            if (e.which == 13) {
                if (this.value.length == 0) {
                    $('#table_lov .row_lov').remove();
                    $('#table_lov').append(trlov);
                    $('.invalid-feedback').hide();
                }
                else if (this.value.length >= 3) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '/BackOffice/public/api/bopbmanual/lov_search',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            $('#table_lov .row_lov').remove();
                            html = "";
                            for (i = 0; i < response.length; i++) {
                                html = '<tr onclick=get_data_pb("' + response[i].pbh_nopb + '") class="row_lov">\n' +
                                    '     <td>' + response[i].pbh_nopb + '</td>\n' +
                                    '     <td>' + formatDate(response[i].pbh_tglpb) + '</td>\n' +
                                    '     <td>' + nvl(response[i].pbh_flagdoc, '') + '</td>\n' +
                                    ' </tr>';
                                trlov += html;
                                $('#table_lov').append(html);
                            }
                        },
                        complete: function () {
                            $('#modal-loader').modal('hide');
                        }
                    });
                }
                else {
                    $('.invalid-feedback').show();
                }
            }
        });

        function searchPLU() {
            plu = $('#plu-search').val();
            index = $('#table-detail #' + plu).index();
            height = $('#table-detail #' + plu + ' td').innerHeight();
            if ($('#' + plu + ' .input-plu').val() == null) {
                swal({
                    title: "PLU tidak ditemukan!",
                    icon: 'error'
                }).then((createData) => {
                });
            }
            else {
                $('#table-detail #' + plu).click();
                $('#' + plu + ' .input-plu').focus();
            }
            $('.tableFixedHeader').animate({scrollTop: height * index}, 100);

        }

        $('#btn-search').on('click', function () {
            searchPLU();
        });
        $('#plu-search').keypress(function (e) {
            if (e.keyCode == 13) {
                searchPLU();
            }
        });

        function setDataPLU(row, plu, deskripsi, kdsupplier, nmsupplier, hargajual, pkm, stock, minor) {
            $('#deskripsi').val(deskripsi);
            $('#kode-supplier').val(kdsupplier);
            $('#nama-supplier').val(nmsupplier);
            $('#harga-jual').val(convertToRupiah2(hargajual));
            $('#pkm').val(convertToRupiah2(pkm));
            $('#stock').val(convertToRupiah2(stock));
            $('#minor').val(convertToRupiah2(minor));

            $(".baris").children('td').each(function () {
                $(this).find("input").removeAttr('style');
                $(this).find("select").removeAttr('style');
                $(this).find(".btn-lov-plu").hide();
                $(this).find(".inside").removeClass('buttonInside');
            });
            $("#row-" + row).children('td').each(function () {
                $(this).find("input").css("background-color", "grey");
                $(this).find("select").css("background-color", "grey");
                $(this).find("input").css("color", "white");
                $(this).find("select").css("color", "white");
                $(this).find(".btn-lov-plu").show();
                $(this).find(".inside").addClass('buttonInside');
            });
        };
        $('#btn-hapus-dokumen').on('click', function () {
            value = $('#no-pb').val();
            $.ajax({
                url: '/BackOffice/public/api/bopbmanual/hapusDokumen',
                type: 'POST',
                data: {"_token": "{{ csrf_token() }}", value: value},
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    swal({
                        title: response['message'],
                        icon: response['status']
                    }).then((createData) => {
                        $('#no-pb').val('');
                        $('.baris').remove();
                        clear_field();
                    });
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                }
            });
        });

        // LOV
        var trlov_plu = $('#table_lov_plu tbody').html();

        $('#search_lov_plu').keypress(function (e) {
            if (e.which == 13) {
                if (this.value.length == 0) {
                    $('#table_lov_plu .row_lov_plu').remove();
                    $('#table_lov_plu').append(trlov_plu);
                    $('.invalid-feedback').hide();
                }
                else if (this.value.length >= 3) {
                    $('.invalid-feedback').hide();
                    $.ajax({
                        url: '/BackOffice/public/api/bopbmanual/lov_search_plu',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", value: this.value.toUpperCase()},
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            $('#table_lov_plu .row_lov_plu').remove();
                            html = "";
                            console.log(response.length);
                            for (i = 0; i < response.length; i++) {
                                html = '<tr class="row_lov_plu" onclick=lov_plu_select("' + response[i].prd_prdcd + '")><td>' + response[i].prd_deskripsipanjang + '</td><td>' + response[i].prd_prdcd + '</td></tr>';
                                trlov_plu += html;
                                $('#table_lov_plu').append(html);
                            }
                        },
                        complete: function () {
                            $('#modal-loader').modal('hide');
                        }
                    });
                }
                else {
                    $('.invalid-feedback').show();
                }
            }
        });

        function lov_plu_select(plu) {
            console.log(plu);
            $("#row-" + onrow).children('td').each(function () {
                $(this).find('.input-plu').val(plu);
            });

            if ($('#m_pluHelp').is(':visible')) {
                $('#search_lov_plu').val('');
                $('#table_lov_plu .row_lov_plu').remove();
                $('#table_lov_plu').append(trlov_plu);
                $('#m_pluHelp').modal('hide');
            }
        }

        function tambah_row() {
            rowIterator++;
            $('#table-detail').append(
                '<tr id="row-' + rowIterator + '" class="baris" onclick="setDataPLU(\'' + rowIterator + '\',\'\',\'\',\'\',\'\',\'\',\'\',\'\',\'\')">\n' +
                '    <td class="p-0">\n' +
                '        <button class="btn btn-sm btn-danger btn-delete" onclick="hapusBaris(\'' + rowIterator + '\')">X</button>\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '       <div class="inside">' +
                '           <input type="text" class="form-control form-control-sm text-small input-plu" maxlength="7" onkeypress="cek_plu(\'' + rowIterator + '\', this.value, event)">' +
                '           <button type="button" style="display: none" class="btn btn-sm btn-lov-plu p-0" data-toggle="modal" data-target="#m_pluHelp" onclick="pluhelp(\'' + rowIterator + '\')"><img src="{{asset('image/icon/help.png')}}" width="25px"></button>' +
                '       </div>' +
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
                '        <input disabled class="form-control form-control-sm text-right" value="0">\n' +
                '    </td>\n' +
                '    <td class="p-0">\n' +
                '        <input disabled class="form-control form-control-sm" value="0">\n' +
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

            $(".baris").children('td').each(function () {
                $(this).find("input").removeAttr('style');
                $(this).find("select").removeAttr('style');
                $(this).find(".btn-lov-plu").hide();
                $(this).find(".inside").removeClass('buttonInside');
            });
            $("#row-" + rowIterator).children('td').each(function () {
                $(this).find("input").css("background-color", "grey");
                $(this).find("select").css("background-color", "grey");
                $(this).find("input").css("color", "white");
                $(this).find("select").css("color", "white");
                $(this).find(".btn-lov-plu").show();
                $(this).find(".inside").addClass('buttonInside');
                $(this).find('.input-plu').focus();
            });

        }

        function pluhelp(row) {
            onrow = row;
        }

        function cek_plu(row, value, e) {
            var div = $('#row-' + row);
            if (e.which == '13') {
                if (!$.isNumeric(value)) {
                    swal({
                        title: "PLU harus angka!",
                        icon: "error"
                    }).then((createData) => {
                        div.find('.input-plu').val("");
                        div.find('.input-plu').focus();
                    });
                }
                else{
                    value = convertPlu(value);
                    tgl = $('#tgl-pb').val();
                    div.find('.input-plu').val(value);
                    flag = $('#flag').val();
                    $.ajax({
                        url: '/BackOffice/public/api/bopbmanual/cek_plu',
                        type: 'POST',
                        data: {"_token": "{{ csrf_token() }}", plu: value,tglpb: tgl,flag:flag},
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            div.remove();
                            console.log(response['plu']);
                            $('#table-detail').append(
                                "<tr id='row-" + rowIterator + "' class='baris' onclick='setDataPLU(\"" + rowIterator + "\",\"" + response["plu"].pbd_prdcd + "\",\"" + response["plu"].prd_deskripsipanjang.replace('\'', '^') + "\",\"" + response["plu"].pbd_kodesupplier + "\",\"" + response["plu"].sup_namasupplier + "\",\"" + response["plu"].prd_hrgjual + "\",\"" + nvl(response["plu"].pbd_pkmt,0) + "\",\"" + nvl(response["plu"].st_saldoakhir,0) + "\",\"" + response["plu"].minor + "\")'>\n" +
                                "    <td class='p-0'>\n" +
                                "        <button class='btn btn-sm btn-danger btn-delete' onclick='hapusBaris(\"" + rowIterator + "\")'>X</button>\n" +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                '<div class="inside">' +
                                '<input type="text" class="form-control form-control-sm text-small input-plu" maxlength="7" value="' + nvl(response["plu"].pbd_prdcd,'') + '" onkeypress="cek_plu(\'' + rowIterator + '\', this.value, event)">' +
                                '<button type="button" style="display: none" class="btn btn-sm btn-lov-plu p-0" data-toggle="modal" data-target="#m_pluHelp" onclick="pluhelp(\'' + rowIterator + '\')"><img src="{{asset('image/icon/help.png')}}" width="25px"></button>' +
                                '</div>' +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                "        <input disabled class='form-control form-control-sm input-satuan' value='" + response["plu"].satuan + "' >\n" +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                "        <input class='form-control form-control-sm text-right input-ctn' value='" + response["plu"].qtyctn + "' onkeypress='cek_ctn(\"" + rowIterator + "\", this.value, event)'>\n" +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                "        <input class='form-control form-control-sm text-right input-pcs' value='" + response["plu"].qtypcs + "' onkeypress='cek_pcs(\"" + rowIterator + "\", this.value, event)'>\n" +
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
                                "        <input disabled class='form-control form-control-sm text-right' value='" + response["plu"].pbd_bonuspo1 + "'>\n" +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                "        <input disabled class='form-control form-control-sm' value='" + nvl(response["plu"].pbd_bonuspo2, '') + "'>\n" +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                "        <input disabled class='form-control form-control-sm text-right gross'\n" +
                                "               value='" + convertToRupiah2(response["plu"].pbd_gross) + "'>\n" +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                "        <input disabled class='form-control form-control-sm text-right ppn'\n" +
                                "               value='" + convertToRupiah2(response["plu"].pbd_ppn) + "'>\n" +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                "        <input disabled class='form-control form-control-sm text-right ppnbm' value='" + convertToRupiah2(response["plu"].pbd_ppnbm) + "'>\n" +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                "        <input disabled class='form-control form-control-sm text-right ppnbotol' value='" + convertToRupiah2(response["plu"].pbd_ppnbotol) + "'>\n" +
                                "    </td>\n" +
                                "    <td class='p-0'>\n" +
                                "        <input disabled class='form-control form-control-sm text-right total'\n" +
                                "               value='" + convertToRupiah2(response["plu"].total) + "'>\n" +
                                "    </td>\n" +
                                "</tr>"
                            );
                        },
                        complete: function () {
                            $('#modal-loader').modal('hide');
                            div.find('.input-ctn').focus();
                        }
                    });
                }
            }
        }

        function cek_ctn(row, value, e) {
            var div = $('#row-' + row);
            if (e.which == '13') {
                div.find('.input-pcs').focus();
                frac = detail[row].prd_frac;
                hargasatuan = detail[row].pbd_hrgsatuan;
                qtyctn = value;
                qtypcs = div.find('.input-pcs').val();
                persendisc1 = detail[row].pbd_persendisc1;
                persendisc2 = detail[row].pbd_persendisc2;
                hargabeli = (qtyctn * hargasatuan) + (qtypcs * (hargasatuan / frac));
                console.log(hargabeli);
                gross = hargabeli - (hargabeli * persendisc1 / 100);
                hargabeli = gross;
                // gross = hargabeli - (hargabeli * persendisc2 / 100);
                ppn = gross * 10 / 100;
                ppnbm = detail[row].pbd_ppnbm * detail[row].pbd_qtypb;
                ppnbotol = detail[row].pbd_ppnbotol * detail[row].pbd_qtypb;
                total = gross + ppn + ppnbm + ppnbotol;

                detail[row].pbd_gross = gross;
                detail[row].pbd_ppn = ppn;
                detail[row].pbd_ppnbm = ppnbm;
                detail[row].pbd_ppnbotol = ppnbotol;
                detail[row].total = total;

                div.find('.gross').val(convertToRupiah2(gross));
                div.find('.ppn').val(convertToRupiah2(ppn));
                div.find('.ppnbm').val(convertToRupiah2(ppnbm));
                div.find('.ppnbotol').val(convertToRupiah2(ppnbotol));
                div.find('.total').val(convertToRupiah2(total));
                console.log(gross);
                // 354600
            }
            //     HrgBeli := (:qtyctn*:pbd_hrgsatuan)+(:qtypcs*(:pbd_hrgsatuan/:frac));
            // :pbd_gross:=HrgBeli-(HrgBeli*:pbd_persendisc1/100);
            //     HrgBeli:=:pbd_gross;
            // :pbd_gross:=HrgBeli-(HrgBeli*:pbd_persendisc2/100);
            // :PBD_PPN     := (:PBD_GROSS*:parameter.PPN)/100;
            // :PBD_PPNBM   := :PBD_PPNBM * :PBD_QTYPB;
            // :PBD_PPNBOTOL:= :PBD_PPNBOTOL * :PBD_QTYPB;
            // :TOTAL 			 := :pbd_gross + :PBD_PPN + :PBD_PPNBM + :PBD_PPNBOTOL;
        }

        function cek_pcs(row, value, e) {
            var div = $('#row-' + row);
            if (e.which == '13') {
                var target = e.srcElement || e.target;
                var next = div[0].nextElementSibling;

                if ((div.find('.input-ctn').val() == 0 || div.find('.input-ctn').val() == "") && (value == 0 || value == "")) {
                    swal({
                        title: "Salah satu CTN / PCs harus diisi!",
                        icon: "error"
                    }).then((createData) => {
                        div.find('.input-ctn').focus();
                    });
                }
                else if (next == null) {
                    tambah_row();
                } else {
                    $(next).find('.input-plu').focus();
                }
            }
        }


    </script>
@endsection
