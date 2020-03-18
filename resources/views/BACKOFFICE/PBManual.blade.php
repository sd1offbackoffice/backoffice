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
                                            <button type="button" id="btnAktifkanHrg"
                                                    class="btn btn-danger btn-sm float-left "
                                                    onclick="aktifkanHarga()">Hapus Dokumen
                                            </button>
                                        </div>
                                        <input type="text" id="model"
                                               class="form-control form-control-sm col-sm-3" disabled>
                                        <label class="col-sm-2 col-form-label text-sm-right" style="font-size: 12px">HG
                                            JUAL</label>
                                        <input type="text" id="harga-jual"
                                               class="form-control form-control-sm col-sm-2">
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-md-right"
                                               style="font-size: 12px">TGL. PB</label>
                                        <input type="text" id="tgl-pb"
                                               class="form-control form-control-sm col-sm-2">
                                        <label class="col-sm-7 col-form-label text-md-right"
                                               style="font-size: 12px">PKM</label>
                                        <input type="text" id="pkm" class="form-control form-control-sm col-sm-2">
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-md-right" style="font-size: 12px">FLAG</label>
                                        <select class="form-control form-control-sm col-sm-2" id="flag">
                                            <option value="1">PB BIASA</option>
                                            <option value="2">PB KHUSUS</option>
                                            <option value="3">PB OMI</option>
                                            <option value=""></option>
                                        </select>
                                        <div class="col-sm-2 form-check form-check-inline p-0 pl-2 m-0">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                   id="radio-reguler" value="option1">
                                            <label class="form-check-label" for="radio-reguler">REGULER</label>
                                            <input class="form-check-input ml-2" type="radio" name="inlineRadioOptions"
                                                   id="radio-gms" value="option2">
                                            <label class="form-check-label" for="radio-gms">GMS</label>
                                        </div>
                                        <label class="col-sm-5 col-form-label text-sm-right" style="font-size: 12px">STOCK</label>
                                        <input type="text" id="stock" class="form-control form-control-sm col-sm-2">
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-md-right" style="font-size: 12px">KETERANGAN</label>
                                        <input type="text" id="keterangan"
                                               class="form-control form-control-sm col-sm-4">
                                        <label class="col-sm-5 col-form-label text-sm-right" style="font-size: 12px">MINOR</label>
                                        <input type="text" id="minor" class="form-control form-control-sm col-sm-2">
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
                                    <th width="7%" class="text-center small">PRDCD</th>
                                    <th width="6%" class="text-center small">SATUAN</th>
                                    <th width="3%" class="text-center small">CTN</th>
                                    <th width="3%" class="text-center small">PCs</th>
                                    <th width="1%" class="text-center small">OMI</th>
                                    <th width="1%" class="text-center small">IDM</th>
                                    <th width="1%" class="text-center small">DISC GO</th>
                                    <th width="10%" class="text-center small">HRG.SATUAN</th>
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
                                        <input disabled class="form-control form-control-sm text-right" value="3">
                                    </td>
                                    <td class="p-0">
                                        <input disabled class="form-control form-control-sm text-right" value="0">
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
                                        <input type="text" id="deksripsi"
                                               class="form-control form-control-sm col-sm-5">
                                        <div class="col-sm-1"></div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-1 col-form-label text-md-right"
                                               style="font-size: 12px">SUPPLIER</label>
                                        <input type="text" id="kode-supplier"
                                               class="form-control form-control-sm col-sm-1">
                                        <input type="text" id="nama-supplier"
                                               class="form-control form-control-sm col-sm-4">
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-4 row">
                                            <input type="text" id="plu-search"
                                                   class="form-control form-control-sm col-sm-6">
                                            <button type="button" id="btn-search"
                                                    class="btn btn-sm btn-success"
                                                    onclick=""> SEARCH
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

    <style>
        .row_lov:hover {
            cursor: pointer;
            background-color: grey;
            color: white;
        }
    </style>

    <script>
        $(document).ready(function () {
            $('#tgl-pb').datepicker({"dateFormat": "dd/mm/yy"});
            $('#no-pb').val('222003077');
            // $('#no-pb').val('');
            var e = $.Event("keypress");
            e.keyCode = 13;
            $('#no-pb').trigger(e);
        });

        $('#no-pb').keypress(function (e) {
            if (e.keyCode == 13) {
                var pb = $(this).val();
                get_data_pb(pb);
            }
        });

        function clear_field() {
            $('#tgl-pb').val("");
            $('#keterangan').val("");
            $('#harga-jual').val("");
            $('#pkm').val("");
            $('#stock').val("");
            $('#minor').val("");

            $('.btn-delete').prop("disabled", false);
            $('.input-plu').prop("disabled", false);
            $('#tgl-pb').prop("disabled", false);
            $('#flag').prop("disabled", false);
            $('#keterangan').prop("disabled", false);
            $('#harga-jual').prop("disabled", false);
            $('#pkm').prop("disabled", false);
            $('#stock').prop("disabled", false);
            $('#minor').prop("disabled", false);
            $('#radio-gms').prop("disabled", false);
            $('#radio-reguler').prop("disabled", false);
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
                        $('#no-pb').val(response['pb'].pbh_nopb);
                        $('#tgl-pb').val(formatDate(response['pb'].pbh_tglpb));
                        $('#model').val(response['MODEL']);
                        if (response['MODEL'] == 'KOREKSI') {
                            swal({
                                title: "KOREKSI",
                                icon: 'error'
                            }).then((createData) => {

                            });
                        }
                        else if (response['MODEL'] == 'PB SUDAH DICETAK / TRANSFER') {
                            $('.btn-delete').prop("disabled", "disabled");
                            $('.input-plu').prop("disabled", "disabled");
                            $('#tgl-pb').prop("disabled", "disabled");
                            $('#flag').prop("disabled", "disabled");
                            $('#keterangan').prop("disabled", "disabled");
                            $('#harga-jual').prop("disabled", "disabled");
                            $('#pkm').prop("disabled", "disabled");
                            $('#stock').prop("disabled", "disabled");
                            $('#minor').prop("disabled", "disabled");
                            $('#radio-gms').prop("disabled", "disabled");
                            $('#radio-reguler').prop("disabled", "disabled");
                        }
                        for (i = 0; i < response['pbd'].length; i++) {
                            $('#table-detail').append(
                                '<tr class="baris baris-'+i+'">\n' +
                                '    <td class="p-0">\n' +
                                '        <button class="btn btn-sm btn-danger btn-delete" onclick="hapusData(\''+response['pbd'][i].pbd_nopb+'\',\''+response['pbd'][i].pbd_prdcd+'\',\'baris-'+i+'\')">X</button>\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input class="form-control form-control-sm text-small input-plu"\n' +
                                '               value="'+response['pbd'][i].pbd_prdcd+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm" value="'+response['pbd'][i].satuan+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right" value="'+response['pbd'][i].qtyctn+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right" value="'+response['pbd'][i].qtypcs+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm" value="'+response['pbd'][i].f_omi+'"\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm" value="'+response['pbd'][i].f_idm+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm" value="'+nvl(response['pbd'][i].pbd_fdxrev,'')+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right"\n' +
                                '               value="'+convertToRupiah2(response['pbd'][i].pbd_hrgsatuan)+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right" value="'+response['pbd'][i].pbd_rphdisc1+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right" value="'+convertToRupiah(response['pbd'][i].pbd_persendisc1)+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right" value="'+convertToRupiah2(response['pbd'][i].pbd_rphdisc2)+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right" value="'+convertToRupiah(response['pbd'][i].pbd_persendisc2)+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right" value="'+response['pbd'][i].pbd_bonuspo1+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm" value="'+nvl(response['pbd'][i].pbd_bonuspo2,'')+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right"\n' +
                                '               value="'+convertToRupiah2(response['pbd'][i].pbd_gross)+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right"\n' +
                                '               value="'+convertToRupiah2(response['pbd'][i].pbd_ppn)+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right" value="'+convertToRupiah2(response['pbd'][i].pbd_ppnbm)+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right" value="'+convertToRupiah2(response['pbd'][i].pbd_ppnbotol)+'">\n' +
                                '    </td>\n' +
                                '    <td class="p-0">\n' +
                                '        <input disabled class="form-control form-control-sm text-right"\n' +
                                '               value="'+convertToRupiah2(response['pbd'][i].total)+'">\n' +
                                '    </td>\n' +
                                '</tr>'
                            );
                        }
                        $('#keterangan').val(response['pb'].pbh_keteranganpb);

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

        function hapusData(nopb,plu,baris) {
            $('.'+baris).remove();
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
    </script>
@endsection
