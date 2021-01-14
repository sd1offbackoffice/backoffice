@extends('navbar')
@section('title','TRANSAKSI | REPACKING')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card">
                    <legend class="w-auto ml-5">.:: [Header] ::.</legend>
                    <div class="card-body shadow-lg cardForm">
                        <div class="col-sm-12">
                            <div class="form-group row mb-0">
                                <label class="col-sm-1 col-form-label" for="nomorTrn">NOMOR TRN</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="form-control" id="nomorTrn">
                                    <button id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <label class="col-sm-1 col-form-label text-right" for="tanggalTrn">TANGGAL TRN</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id="tanggalTrn" placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="keterangan" class="col-sm-1 col-form-label">KETERANGAN</label>
                                <div class="col-sm-5">
                                    <input class="form-control" id="keterangan" type="text">
                                </div>

                                <button class="btn btn-danger col-sm-2 btn-block" type="button">
                                    HAPUS DOKUMEN
                                </button>
                            </div>
                            <div class="form-group row mb-0">
                                <label for="perubahanPlu" class="col-sm-1 col-form-label">PERUBAHAN PLU</label>
                                <div class="col-sm-2">
                                    <input class="form-control" id="keterangan" type="text">
                                </div>
                                <span style="margin-top: 8px" style="word-spacing: 2px">&nbsp;&nbsp;[&nbsp;/&nbsp;Y&nbsp;]&nbsp;&nbsp;</span>
                                <div class="col-sm-6" style="margin-top: 10px">
                                    <label class="radio-inline">
                                        <input type="radio" name="optradio" checked>Re-packing
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="optradio">Pre-packing
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <div class="col-sm-2 text-center">
                                <button type="button" class="btn btn-success btn-block" style="width: 200px; margin-top: -120px; height: 60px">PRINT</button>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <input readonly type="text" id="jenisKertas" value="Kecil">
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" onclick="dropdownBiasa()">Biasa</a>
                                    <a class="dropdown-item" onclick="dropdownKecil()">Kecil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <fieldset class="card">
                        <legend class="w-auto ml-5">.:: [DETAIL] ::.</legend>
                        <div class="card-body shadow-lg cardForm">

                            <div class="p-0 tableFixedHeader" style="height: 250px;">
                                <table class="table table-sm table-striped table-bordered"
                                       id="table-header">
                                    <thead>
                                    <tr class="table-sm text-center">
                                        <th width="3%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="3%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="10%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="20%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="10%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="3%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="8%" colspan="2" class="text-center small">STOCK</th>
                                        <th width="8%" colspan="2" class="text-center small">KUANTUM</th>
                                        <th width="12%" class="text-center small">HRG.SATUAN</th>
                                        <th width="13%" style="background-color: white; border: none" class="text-center small"></th>
                                        <th width="10%" style="background-color: white; border: none" class="text-center small"></th>
                                    </tr>
                                    <tr class="table-sm text-center">
                                        <th width="3%" class="text-center small"></th>
                                        <th width="3%" class="text-center small">P/R</th>
                                        <th width="10%" class="text-center small">PLU</th>
                                        <th width="20%" class="text-center small">DESKRIPSI</th>
                                        <th width="10%" class="text-center small">SATUAN</th>
                                        <th width="3%" class="text-center small">TAG</th>
                                        <th width="4%" class="text-center small">CTN</th>
                                        <th width="4%" class="text-center small">PCS</th>
                                        <th width="4%" class="text-center small">CTN</th>
                                        <th width="4%" class="text-center small">PCS</th>
                                        <th width="12%" class="text-center small">(IN CTN)</th>
                                        <th width="13%" class="text-center small">GROSS</th>
                                        <th width="10%" class="text-center small">PPN</th>
                                    </tr>
                                    </thead>
                                    <tbody id="body-table-header" style="height: 250px;">
                                    @for($i = 0 ; $i< 10 ; $i++)
                                        <tr>
                                            <td>
                                                <button class="btn btn-block btn-sm btn-danger btn-delete-row-header"><i
                                                            class="icon fas fa-times"></i></button>
                                            </td>
                                            <td>
                                                <input maxlength="1" class="form-control deskripsi-header-1"
                                                       type="text">
                                            </td>
                                            <td class="buttonInside" style="width: 150px;">
                                                <input type="text" class="form-control plu" value="">
                                                <button id="btn-no-doc" type="button" class="btn btn-lov ml-3">
                                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                                </button>
                                            </td>
                                            <td>
                                                <input disabled class="form-control satuan-header-1"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control bkp-header-1"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control stock-header-1"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control stock-header-1"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control stock-header-1"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input class="form-control ctn-header ctn-header-1"
                                                       rowheader=1
                                                       type="text">
                                            </td>
                                            <td>
                                                <input class="form-control pcs-header pcs-header-1"
                                                       rowheader=1
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control stock-header-1"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control stock-header-1"
                                                       type="text">
                                            </td>
                                            <td>
                                                <input disabled class="form-control stock-header-1"
                                                       type="text">
                                            </td>
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                            <input style="margin-left: 200px" class="col-sm-6" readonly type="text" id="deskripsi">
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <fieldset class="card">
                        <div class="card-body shadow-lg cardForm">

                            <div class="d-flex justify-content-end">
                                <label for="preItem" class="font-weight-normal" style="margin-right: 10px;">PRE-PACKING ITEM</label>
                                <input readonly id="preItem" type="text" style="margin-right: 30px">

                                <label for="preGross" class="font-weight-normal" style="margin-right: 10px;">PRE-PACKING GROSS</label>
                                <input readonly id="preGross" type="text" style="margin-right: 30px">

                                <label for="ppnAlt" class="font-weight-normal" style="margin-right: 10px;">PPN</label>
                                <input readonly id="ppnAlt" type="text">
                            </div>

                            <div class="d-flex justify-content-end">
                                <label for="preItem" class="font-weight-normal" style="margin-right: 10px;">RE-PACKING ITEM</label>
                                <input readonly id="reItem" type="text" style="margin-right: 39px">

                                <label for="preGross" class="font-weight-normal" style="margin-right: 10px;">RE-PACKING GROSS</label>
                                <input readonly id="reGross" type="text" style="margin-right: 16px">

                                <label for="ppnAlt" class="font-weight-normal" style="margin-right: 10px;">TOTAL</label>
                                <input readonly id="total" type="text">
                            </div>

                            <div class="d-flex justify-content-end">
                                <label for="totItem" class="font-weight-normal" style="margin-right: 10px;">TOTAL ITEM</label>
                                <input readonly id="totItem" type="text" style="margin-right: 84px">

                                <label for="totGross" class="font-weight-normal" style="margin-right: 10px;">TOTAL GROSS</label>
                                <input readonly id="totGross" type="text" style="margin-right: 258px">

                            </div>
                            <div class="d-flex justify-content-start">
                                <span style="font-weight: bold">Ctrl+S : Simpan Data</span>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>

    </div>
    <style>
        #jenisKertas:hover{
            cursor: pointer;
        }
        .dropdown-item:hover{
            cursor: pointer;
        }
    </style>
    <script>
        $('#tanggalTrn').datepicker({
            format: 'dd/mm/yyyy'
        });
        function dropdownBiasa(){
            $('#jenisKertas').val('Biasa');
        }
        function dropdownKecil() {
            $('#jenisKertas').val('Kecil');
        }

        $('#nomorTrn').keypress(function (e) {
            if (e.which === 13) {
                let val = this.value;

                // Get New SRT Nmr
                if(val === ''){
                    swal({
                        title: 'Buat Nomor Transaksi Baru?',
                        icon: 'info',
                        // dangerMode: true,
                        buttons: true,
                    }).then(function (confirm) {
                        if (confirm){
                            ajaxSetup();
                            $.ajax({
                                url: '/BackOffice/public/transaksi/repacking/getNewNmrTrn',
                                type: 'post',
                                data: {},
                                beforeSend: function () {
                                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                                },
                                success: function (result) {
                                    $('#nomorTrn').val(result);
                                    $('#tanggalTrn').val(formatDate('now'));
                                    $('#modal-loader').modal('hide')
                                }, error: function () {
                                    alert('error');
                                    $('#modal-loader').modal('hide');
                                }
                            })
                            // $('.baris').remove();
                            // for (i = 0; i< 8; i++) {
                            //     $('#tbody').append(tempTable(i));
                            // }
                        } else {
                            $('#nomorTrn').val('');
                        }
                    })
                } else {
                    //chooseSrt(val);
                }
            }
        })
    </script>
@endsection