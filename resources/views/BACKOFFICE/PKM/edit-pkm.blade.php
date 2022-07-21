@extends('navbar')

@section('title','MENU PKM TOKO | EDIT PKM')

@section('content')
{{--    sdasd--}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <ul class="nav nav-tabs custom-color" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="btnTabUsulan" data-toggle="tab" href="#tabUsulan" onclick="refreshTableApproval()">{{ strtoupper(__('Usulan')) }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btnTabApproval" data-toggle="tab" href="#tabApproval" onclick="refreshTableApproval()">{{ strtoupper(__('Approval')) }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="btnTabPKM" data-toggle="tab" href="#tabPKM">{{ strtoupper(__('PKM Produk Baru')) }}</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tabUsulan" class="container-fluid tab-pane active pl-0 pr-0 fix-height">
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">{{ __('No. Usulan') }}</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" class="form-control" id="u_noUsulan" autocomplete="off">
                                        <button id="btn_lov_trn" type="button" class="btn btn-primary btn-lov p-0" data-toggle="modal" data-target="#m_lov_usulan" disabled>
                                            <i class="fas fa-spinner fa-spin"></i>
                                        </button>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text-center" id="u_status" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-1 pr-0 text-right col-form-label">{{ __('Tgl Usulan') }}</label>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control" id="u_tglUsulan" disabled>
                                    </div>

                                    <div class="col"></div>
                                    <button class="col-sm-1 btn btn-danger mr-1 d-none" id="u_btnBatal">@lang('BATAL')</button>
                                    <button class="col-sm-1 btn btn-primary mr-1" id="u_btnCetak" onclick="printUsulan()">{{ strtoupper(__('Cetak')) }}</button>
                                </div>
                            </div>
                            <fieldset class="card border-secondary ml-2 mr-2 mt-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <table id="table_daftar" class="table table-sm table-bordered mb-3 text-center">
                                                <thead class="thColor">
                                                <tr>
                                                    <th width="3%" class="align-middle" rowspan="2"><i class="fas fa-trash"></i> </th>
                                                    <th width="10%" class="align-middle" rowspan="2">@lang('PLU')</th>
                                                    <th width="" class="align-middle" colspan="4">@lang('AWAL')</th>
                                                    <th width="" class="align-middle" colspan="2">@lang('DATA EDIT PKM')</th>
                                                    <th width="" class="align-middle" colspan="4">@lang('HASIL EDIT PKM')</th>
                                                </tr>
                                                <tr>
                                                    <th width="">@lang('PKM')</th>
                                                    <th width="">@lang('PKM Adj')</th>
                                                    <th width="">@lang('MPlus')</th>
                                                    <th width="">@lang('PKMT Awal')</th>
                                                    <th width="">@lang('PKM')</th>
                                                    <th width="">@lang('MPlus')</th>
                                                    <th width="">@lang('PKM')</th>
                                                    <th width="">@lang('MPlus')</th>
                                                    <th width="">@lang('PKMT')</th>
                                                    <th width="">@lang('Ket')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for($i=0;$i<0;$i++)
                                                    <tr>
                                                        <td><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
                                                        <td><div class="" style="position: relative">
                                                                <input maxlength="7" type="text" class="form-control prdcd" >
                                                                <button type="button" class="btn btn-lov-plu" data-toggle="modal" data-target="#m_lov_plu">
                                                                    <img src="{{ asset('image/icon/help.png') }}" width="30px">
                                                                </button>
                                                            </div></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                    </tr>
                                                @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-sm-2">
                                            <a href="{{ url()->current() }}/download-format-usulan">
                                                <button id="u_btnDownloadFormat" class="form-group col btn btn-primary mr-1 btn-usulan">@lang('Download Format File')</button>
                                            </a>
                                            <button id="u_btnSelectFile" class="form-group col btn btn-secondary mr-1 btn-usulan" onclick="chooseFile()">@lang('Select File to Upload')</button>
                                            <input type="file" class="d-none" id="u_fileUsulan">
                                            <label class="col pl-0 text-left col-form-label btn-usulan">{{ __('Nama File') }}</label>
                                            <div class="col p-0 form-group">
                                                <input type="text" class="form-control" id="u_namaFile" disabled>
                                            </div>
                                            <button id="u_btnUpload" class="form-group col btn btn-primary mr-1 btn-usulan" onclick="uploadFileUsulan()">{{ strtoupper(__('Upload')) }}</button>
                                            <hr>
                                            <button id="u_btnSimpan" class="form-group col btn btn-success mr-1 btn-usulan" onclick="saveUsulan()">{{ strtoupper(__('Simpan')) }}</button>
                                            <button id="u_btnKirim" class="form-group col btn btn-secondary mr-1 btn-usulan" onclick="sendUsulan()">{{ strtoupper(__('Kirim')) }}</button>
                                            <button id="u_btnTambah" class="form-group col btn btn-primary mr-1 mt-5 btn-usulan" onclick="tambahItem()">{{ strtoupper(__('Tambah Item')) }}</button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="u_bln1" disabled>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="u_bln2" disabled>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control" id="u_bln3" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">@lang('Deskripsi')</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="u_deskripsi" disabled>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-right" id="u_qty1" disabled>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-right" id="u_qty2" disabled>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" class="form-control text-right" id="u_qty3" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tabApproval" class="container-fluid tab-pane pl-0 pr-0 fix-height">
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-sm-1"></div>
                                    <input type="file" class="d-none" id="a_fileApproval">
                                    <button class="col-sm-3 btn btn-primary mr-1" id="a_btnSelect" onclick="chooseApprovalFile()">@lang('Select File to Upload')...</button>
                                </div>
                                <div class="row">
                                    <label class="col-sm-1 text-right col-form-label">@lang('Directory File')</label>
                                    <input type="text" class="col-sm-4 form-control" id="a_directoryFile" disabled>
                                    <div class="col-sm-1"></div>
                                    <button class="col-sm-1 btn btn-primary mr-1" id="a_btnTransfer" onclick="uploadFileApproval()">{{ strtoupper(__('Transfer')) }}</button>
                                </div>
                            </div>
                            <fieldset class="card border-secondary ml-2 mr-2 mt-0">
                                <div class="card-body">
                                    <div class="row form-group">
                                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">@lang('No. Usulan')</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="a_noUsulan" autocomplete="off" disabled>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="a_tglUsulan" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <table id="a_tableApproval" class="table table-sm table-bordered mb-3 text-center">
                                                <thead class="thColor">
                                                <tr>
                                                    <th width="8%" class="align-middle" rowspan="2">@lang('PLU')</th>
                                                    <th width="" class="align-middle" colspan="4">@lang('AWAL')</th>
                                                    <th width="" class="align-middle" colspan="3">@lang('FILE EDIT PKM')</th>
                                                    <th width="" class="align-middle" colspan="3">{{ strtoupper(__('Hasil')) }}</th>
                                                </tr>
                                                <tr>
                                                    <th width="">@lang('PKM')</th>
                                                    <th width="">@lang('PKM Adj').</th>
                                                    <th width="">@lang('MPlus')</th>
                                                    <th width="">@lang('PKMT Awal')</th>
                                                    <th width="">@lang('PKM')</th>
                                                    <th width="">@lang('MPlus')</th>
                                                    <th width="">@lang('Ket')</th>
                                                    <th width="">@lang('PKM')</th>
                                                    <th width="">@lang('MPlus')</th>
                                                    <th width="">@lang('PKMT')</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @for($i=0;$i<0;$i++)
                                                    <tr>
                                                        <td><button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></td>
                                                        <td><div class="" style="position: relative">
                                                                <input maxlength="7" type="text" class="form-control prdcd" >
                                                                <button type="button" class="btn btn-lov-plu" data-toggle="modal" data-target="#m_lov_plu">
                                                                    <img src="{{ asset('image/icon/help.png') }}" width="30px">
                                                                </button>
                                                            </div></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                        <td><input type="text" class="form-control"></td>
                                                    </tr>
                                                @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">@lang('Deskripsi')</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="a_deskripsi" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tabPKM" class="container-fluid tab-pane pl-0 pr-0 fix-height">
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col-sm-1"></div>
                                    <input type="file" class="d-none" id="p_filePKM">
                                    <button class="col-sm-3 btn btn-primary mr-1" id="p_btnSelect" onclick="choosePKMFile()">@lang('Select File to Upload')...</button>
                                </div>
                                <div class="row">
                                    <label class="col-sm-1 text-right col-form-label">@lang('Directory File')</label>
                                    <input type="text" class="col-sm-4 form-control" id="p_directoryFile" disabled>
                                    <div class="col-sm-1"></div>
                                    <button class="col-sm-1 btn btn-primary mr-1" id="p_btnTransfer" onclick="uploadFilePKMBaru()">{{ strtoupper(__('Transfer')) }}</button>
                                    <div class="col"></div>
                                    <div class="col-sm-2">
                                        <div class="buttonInside">
                                            <input type="text" class="form-control" id="p_findNoUsulan">
                                            <button style="right:0" id="btn_lov_trn" type="button" class="btn btn-primary btn-lov p-0 mr-1" data-toggle="modal" data-target="#m_lov_pkm_baru">
                                                <i class="fas fa-question"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button class="col-sm-1 btn btn-primary mr-1" id="p_btnFind" onclick="getDataPKMBaru(null)">{{ strtoupper(__('Find')) }}</button>
                                </div>
                            </div>
                            <fieldset class="card border-secondary ml-2 mr-2 mt-0">
                                <div class="card-body">
                                    <div class="row form-group">
                                        <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">@lang('No Dok')</label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control" id="p_noUsulan" autocomplete="off" disabled>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="p_tglUsulan" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <table id="p_tablePKM" class="table table-sm table-bordered mb-3 text-center">
                                                <thead class="thColor">
                                                <tr>
                                                    <th>@lang('PLU')</th>
                                                    <th>@lang('MPKM')</th>
                                                    <th>@lang('PKM')</th>
                                                    <th>@lang('M PLUS I')</th>
                                                    <th>@lang('M PLUS O')</th>
                                                    <th>@lang('PKMT')</th>
                                                    <th>@lang('CREATE BY')</th>
                                                    <th>{{ strtoupper(__('Keterangan')) }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="card-body">
                                <div class="row">
                                    <label class="col-sm-1 pl-0 pr-0 text-right col-form-label">@lang('Deskripsi')</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="p_deskripsi" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_lov_usulan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_usulan">
                                    <thead>
                                    <tr>
                                        <th>@lang('Dokumen')</th>
                                        <th>@lang('Tanggal')</th>
                                        <th>@lang('Keterangan')</th>
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

    <div class="modal fade" id="m_lov_pkm_baru" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_pkm_baru">
                                    <thead>
                                    <tr>
                                        <th>@lang('Dokumen')</th>
                                        <th>@lang('Tanggal')</th>
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

    <div class="modal fade" id="m_lov_plu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0" id="table_lov_plu">
                                    <thead>
                                    <tr>
                                        <th>@lang('PLU')</th>
                                        <th>{{ strtoupper(__('Deskripsi')) }}</th>
                                        <th>{{ strtoupper(__('Satuan')) }}</th>
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

    <style>
        body {
            background-color: #edece9;
            /*background-color: #ECF2F4  !important;*/
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .modal tbody tr:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .btn-lov-cabang{
            position:absolute;
            bottom: 10px;
            right: 3vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-cabang:focus,
        .btn-lov-cabang:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .btn-lov-plu{
            position:absolute;
            bottom: 10px;
            right: 2vh;
            border:none;
            height:30px;
            width:30px;
            border-radius:100%;
            outline:none;
            text-align:center;
            font-weight:bold;
        }

        .btn-lov-plu:focus,
        .btn-lov-plu:active{
            box-shadow:none !important;
            outline:0px !important;
        }

        .modal thead tr th{
            vertical-align: middle;
        }
    </style>

    <script>
        var notrn;
        var lovtrn;
        var lovcabang;
        var lovplu;
        var data = [];
        var prdcd;
        var tipe;
        var rowIndex = 0;
        var currentRow = 0;
        var tabel;
        var tgltrn;
        var datalks = [];
        var parameterPPN = {{ Session::get('ppn') }};
        var arrCabang = [];
        var date1,date2,date3,m1,m2,m3;
        var isChanged = false;
        var fileUsulan, fileApproval, filePKM;
        var dataApproval = [];
        var lovPKMBaru = [];
        var dataPKMBaru = [];
        // var testing = '1,000';

        $(document).ready(function(){
            tgltrn = $('#tgltrn').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            tabel = $('#table_daftar').DataTable({
                "scrollY": "40vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });

            date1 = new Date(new Date().setMonth(new Date().getMonth() - 1, 1));
            date2 = new Date(new Date().setMonth(new Date().getMonth() - 2, 1));
            date3 = new Date(new Date().setMonth(new Date().getMonth() - 3, 1));

            m1 = ('00' + (1 + new Date(date1).getMonth())).substr(-2);
            m2 = ('00' + (1 + new Date(date2).getMonth())).substr(-2);
            m3 = ('00' + (1 + new Date(date3).getMonth())).substr(-2);

            arrMonths = [
                'JAN',
                'FEB',
                'MAR',
                'APR',
                'MAY',
                'JUN',
                'JUL',
                'AUG',
                'SEP',
                'OCT',
                'NOV',
                'DEC'
            ];

            getLovUsulan();
            getLovPKMBaru();
            getLovPlu();
        });

        function getLovUsulan(){
            lovtrn = $('#table_lov_usulan').DataTable({
                "ajax": '{{ url()->current() }}/get-data-lov-usulan',
                "columns": [
                    {data: 'dok'},
                    {data: 'tgl'},
                    {data: 'stat'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-usulan').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete": function(){
                    $('#btn_lov_trn').empty().append('<i class="fas fa-question"></i>').prop('disabled', false);

                    $(document).on('click', '.row-lov-usulan', function (e) {
                        nousulan = $(this).find('td:eq(0)').html();

                        $('#u_noUsulan').val(nousulan);
                        $('#u_tglUsulan').val($(this).find('td:eq(1)').html());

                        $('#m_lov_usulan').modal('hide');

                        getDataUsulan(nousulan);
                    });
                }
            });
        }

        function getLovPKMBaru(){
            lovtrn = $('#table_lov_pkm_baru').DataTable({
                "ajax": '{{ url()->current() }}/get-data-lov-pkm-baru',
                "columns": [
                    {data: 'no'},
                    {data: 'tgl'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-pkm-baru').css({'cursor': 'pointer'});
                    lovPKMBaru.push(data.no);
                },
                "order" : [],
                "initComplete": function(){
                    $(document).on('click', '.row-lov-pkm-baru', function (e) {
                        $('#p_findNoUsulan').val($(this).find('td:eq(0)').html());

                        $('#m_lov_pkm_baru').modal('hide');
                    });
                }
            });
        }

        function getLovPlu(){
            lovplu = $('#table_lov_plu').DataTable({
                "ajax": '{{ url('/bo/transaksi/kirimcabang/input/get-data-lov-plu') }}',
                "columns": [
                    {data: 'prd_prdcd', name: 'prd_prdcd'},
                    {data: 'prd_deskripsipanjang', name: 'prd_deskripsipanjang'},
                    {data: 'satuan', name: 'satuan'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-lov-plu').css({'cursor': 'pointer'});
                },
                "order" : [],
                "initComplete" : function(){
                    $(document).on('click', '.row-lov-plu', function (e) {
                        prdcd = $(this).find('td:eq(0)').html();

                        $('#m_lov_plu').modal('hide');

                        $('.row-'+currentRow+' .prdcd').val(prdcd);

                        getDataPlu(prdcd);
                    });
                }
            });
        }

        function getPLU(event,index){
            if(event.which == 13){
                currentRow = index;

                getDataPlu(convertPlu($('.row-'+currentRow).find('.prdcd').val()));
            }
        }

        function getDataPlu(prdcd){
            $.ajax({
                type: "GET",
                url: "{{ url()->current() }}/get-data-plu",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {prdcd: prdcd},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if(response.length == 0){
                        swal({
                            title: `{{ __('PLU tidak ditemukan') }}!`,
                            icon: 'error'
                        }).then(function(){
                            $('.row-'+currentRow).find('.prdcd').select();
                        });
                    }
                    else{
                        data[`row-${currentRow}`] = response;

                        row = $('.row-'+currentRow);

                        row.find('.prdcd').val(prdcd);
                        row.find('.mpkmawal').val(convertToRupiah2(response.pkm_mpkm));
                        if(response.pkm_adjust_by != null)
                            row.find('.pkmadjustawal').val(convertToRupiah2(response.pkm_pkm));
                        row.find('.mplusawal').val(convertToRupiah2(response.pkm_qtymplus));
                        row.find('.pkmtawal').val(convertToRupiah2(response.pkm_pkmt));
                        row.find('.pkmusulan').select();
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: `{{ __('Terjadi kesalahan') }}!`,
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {

                    });
                }
            });
        }

        function generateTableRow(data){
            if(data == null){
                data = {};
                data.upkm_prdcd = '';
                data.upkm_mpkm_awal = '';
                data.upkm_pkmadjust_awal = '';
                data.upkm_mplus_awal = '';
                data.upkm_pkmt_awal = '';
                data.upkm_pkm_usulan = '';
                data.upkm_mplus_usulan = '';
                data.upkm_pkm_edit = '';
                data.upkm_mplus_edit = '';
                data.upkm_pkmt_edit = '';
                data.upkm_keterangan = '';
            }
            console.log(data,'ini data generateTableRow');
            row = `<tr class="row-data row-${rowIndex}" onmouseover="pointerIn(${rowIndex})">
                        <td><button class="btn btn-sm btn-danger" onclick="hapusItem(${rowIndex})"><i class="fas fa-trash"></i></button></td>
                        <td>
                            <div class="buttonInside">
                                <input maxlength="7" type="text" class="form-control prdcd" value="${data.upkm_prdcd}" onkeypress="getPLU(event,${rowIndex})">
                                <button style="right:0" id="btn_lov_trn" type="button" class="btn btn-primary btn-lov p-0 mr-1" data-toggle="modal" data-target="#m_lov_plu" onclick="currentRow = ${rowIndex}">
                                    <i class="fas fa-question"></i>
                                </button>
                            </div>
                        </td>
                        <td><input type="text" class="text-right form-control mpkmawal" value="${nvl(data.upkm_mpkm_awal, '')}" disabled></td>
                        <td><input type="text" class="text-right form-control pkmadjustawal" value="${nvl(data.upkm_pkmadjust_awal, '')}" disabled></td>
                        <td><input type="text" class="text-right form-control mplusawal" value="${nvl(data.upkm_mplus_awal, '')}" disabled></td>
                        <td><input type="text" class="text-right form-control pkmtawal" value="${nvl(data.upkm_pkmt_awal, '')}" disabled></td>
                        <td><input type="text" class="text-right form-control pkmusulan" value="${nvl(convertToRupiah2(data.upkm_pkm_usulan, ''))}" onkeypress="checkPKMUsulan(event,${rowIndex})"></td>
                        <td><input type="text" class="text-right form-control mplususulan" value="${nvl(convertToRupiah2(data.upkm_mplus_usulan, ''))}" onkeypress="convertRibuan(event,${rowIndex})"></td>
                        <td><input type="text" class="text-right form-control pkmedit" value="${nvl(data.upkm_pkm_edit, '')}" disabled></td>
                        <td><input type="text" class="text-right form-control mplusedit" value="${nvl(data.upkm_mplus_edit, '')}" disabled></td>
                        <td><input type="text" class="text-right form-control pkmtedit" value="${nvl(data.upkm_pkmt_edit, '')}" disabled></td>
                        <td><input type="text" class="text-left form-control keterangan" value="${nvl(data.upkm_keterangan, '')}" disabled></td>

                    </tr>`;
            return row;
        }

        function getDataUsulan(nousulan){
            $.ajax({
                type: "GET",
                url: "{{ url()->current() }}/get-data-usulan",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {nousulan: nousulan},
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('#u_tglUsulan').val(formatDateCustom(response[0].upkm_tglusulan, 'dd/mm/yy'));

                    if($.fn.DataTable.isDataTable('#table_daftar')){
                        $('#table_daftar').DataTable().destroy();
                        $("#table_daftar tbody [role='row']").remove();
                    }

                    rowIndex = 0;
                    data = [];

                    for(i=0;i<response.length;i++) {
                        data['row-'+i] = response[i];

                        $('#table_daftar tbody').append(generateTableRow(response[i]));

                        rowIndex++;
                    }

                    tabel = $('#table_daftar').DataTable({
                        "scrollY": "40vh",
                        "paging" : false,
                        "sort": false,
                        "bInfo": false,
                        "searching": false
                    });

                    if(response[0].upkm_status == 'A'){
                        $('#u_status').val('* USULAN SUDAH DISETUJUI *');
                        $('.btn-usulan').prop('disabled',true);
                    }
                    else if(response[0].upkm_status == 'K'){
                        $('#u_status').val('* USULAN SUDAH DIKIRIM *');
                        $('.btn-usulan').prop('disabled',true);
                    }
                    else{
                        $('#u_status').val('* EDIT *');
                        $('.btn-usulan').prop('disabled',false);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    // handle error
                    swal({
                        title: error.responseJSON.exception,
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {

                    });
                }
            });
        }

        function pointerIn(index) {
            if($('.row-'+index).find('.prdcd').val() != ''){
                $('#u_deskripsi').val(data['row-'+index].prd_deskripsipanjang);
                $('#u_qty1').val(convertToRupiah2(data['row-'+index]['psl_qty_igr_'+m1]));
                $('#u_qty2').val(convertToRupiah2(data['row-'+index]['psl_qty_igr_'+m2]));
                $('#u_qty3').val(convertToRupiah2(data['row-'+index]['psl_qty_igr_'+m3]));

                $('#u_bln1').val(arrMonths[date1.getMonth()] + ' ' + date1.getFullYear())
                $('#u_bln2').val(arrMonths[date2.getMonth()] + ' ' + date2.getFullYear())
                $('#u_bln3').val(arrMonths[date3.getMonth()] + ' ' + date3.getFullYear())
            }
            $('#table_daftar tbody tr').removeAttr('style');
            $('.row-'+index).css({"background-color": "#acacac","color": "white"});
        }

        function tambahItem(){
            if($.fn.DataTable.isDataTable('#table_daftar')){
                $('#table_daftar').DataTable().destroy();
            }

            rowIndex++;
            $('#table_daftar tbody').append(generateTableRow(null));

            tabel = $('#table_daftar').DataTable({
                "scrollY": "40vh",
                "paging" : false,
                "sort": false,
                "bInfo": false,
                "searching": false
            });

            // rowIndex++;
            // console.log(rowIndex,'ini rowIndex');
            //
            // $('#table_daftar tbody tr').hover(pointerIn, pointerOut);
        }

        function hapusItem(i){
            status = $('#u_status').val();
            // if(status === '* TAMBAH *' || status === '* EDIT *'){
            //     $(`.row-${i}`).remove();
            // }
            if(status === '* TAMBAH *' || status === '* EDIT *'){
                $('#table_daftar').DataTable().destroy();
                $('#table_daftar tbody .row-'+i).remove();
                $('#table_daftar').DataTable({
                    "scrollY": "40vh",
                    "paging" : false,
                    "sort": false,
                    "bInfo": false,
                    "searching": false
                });
            }
        }

        $('#u_noUsulan').on('keypress',function(e){
            if(e.which == 13){
                checkUsulan();
            }
        });

        function checkUsulan(){
            $.ajax({
                type: "GET",
                url: "{{ url()->current() }}/check-usulan",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    nousulan: $('#u_noUsulan').val()
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if(response.status === 'success'){
                        if($('#u_noUsulan').val() == ''){
                            getNewNoUsulan();
                        }
                        else getDataUsulan($('#u_noUsulan').val());
                    }
                    else{
                        swal({
                            title: response.message,
                            icon: 'error'
                        }).then(() => {
                            $('#u_noUsulan').select();
                            $('#u_tglUsulan').val('');
                        });
                    }
                },
                error: function (error) {
                    swal({
                        title: `{{ __('Terjadi kesalahan') }}!`,
                        text: error.responseJSON.message,
                        icon: 'error'
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }

        function refreshTableApproval()
        {
            $('#a_directoryFile').val('');
            $('#a_noUsulan').val('');
            $('#a_tglUsulan').val('');
            $('#a_deskripsi').val('');

            if($.fn.DataTable.isDataTable('#a_tableApproval')){
                $('#a_tableApproval').DataTable().destroy();
                $("#a_tableApproval tbody tr").remove();
            }

            tabel = $('#a_tableApproval').DataTable({
                // "scrollY": "40vh",
                // "paging" : false,
                // "sort": false,
                // "bInfo": false,
                // "searching": false,
                // "responsive": true,
                // "lengthChange": true,
                // "autoWidth": false

                "scrollY": "40vh",
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": true,
                "responsive": true
            });
        }

        function getNewNoUsulan(){
            swal({
                title: `{{ __('Ingin membuat nomor usulan baru') }}?`,
                icon: 'warning',
                buttons: true
            }).then((ok) => {
                if(ok){
                    $.ajax({
                        type: "GET",
                        url: "{{ url()->current() }}/get-new-no-usulan",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');

                            if($.fn.DataTable.isDataTable('#table_daftar')){
                                $('#table_daftar').DataTable().destroy();
                                $("#table_daftar tbody tr").remove();
                            }

                            rowIndex = 0;
                            data = [];

                            $('#table_daftar tbody').append(generateTableRow(null));

                            tabel = $('#table_daftar').DataTable({
                                "scrollY": "40vh",
                                "paging" : false,
                                "sort": false,
                                "bInfo": false,
                                "searching": false
                            });

                            $('.btn-usulan').prop('disabled',false);
                            $('#u_noUsulan').val(response.nousulan);
                            $('#u_tglUsulan').val(response.tglusulan);
                            $('#u_status').val('* TAMBAH *').css({'text-align': 'center'});

                            isChanged = true;
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            // handle error
                            swal({
                                title: `{{ __('Terjadi kesalahan') }}!`,
                                text: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }

        function convertRibuan(e, row,rowIndex)
        {
            if(e.which == 13){
                $('.mplususulan').each(function(){
                    ribuan2 = parseInt($(this).val().replaceAll(',',''));

                      if(ribuan2.toString().length > 3)
                        {
                            ribuan2 = convertToRupiah2(ribuan2);
                        }
                        $(this).val(ribuan2);
                });
                tambahItem();

                $('.row-'+row + 1).find('.prdcd').focus();
            }
        }

        function checkPKMUsulan(e,index){
            if(e == null){
                if(e.which == 13){
                    $('.pkmusulan').each(function(){
                        ribuan = parseInt($(this).val().replaceAll(',',''));

                        if(ribuan.toString().length > 3)
                        {
                            ribuan = convertToRupiah2(ribuan);
                        }
                        $(this).val(ribuan);
                    });
                    $('.row-'+index).find('.mplususulan').focus();

                }

                isChanged = true;

                temp = data['row-'+index];
                minpkm = parseInt(temp.pkm_mindisplay) + parseInt(temp.pkm_minorder);
                row = $('.row-'+index);

                if(row.find('.pkmusulan').val() < minpkm && row.find('.pkmusulan').val() != ''){
                    swal({
                        title: 'Nilai PKM < MINDIS + MINOR ('+minpkm+')',
                        icon: 'warning'
                    }).then(() => {
                        row.find('.pkmusulan').select();
                    });
                }
                else{
                    row.find('.mplususulan').select();
                }
            }
            else if(e.which == 13){
                $('.pkmusulan').each(function(){
                    ribuan = parseInt($(this).val().replaceAll(',',''));

                    if(ribuan.toString().length > 3)
                    {
                        ribuan = convertToRupiah2(ribuan);
                    }
                    $(this).val(ribuan);
                });

                $('.row-'+index).find('.mplususulan').focus();

                isChanged = true;

                temp = data['row-'+index];

                minpkm = parseInt(temp.pkm_mindisplay) + parseInt(temp.pkm_minorder);

                row = $('.row-'+index);

                if(row.find('.pkmusulan').val() < minpkm  && row.find('.pkmusulan').val() != ''){
                    swal({
                        title: 'Nilai PKM < MINDIS + MINOR ('+minpkm+')',
                        icon: 'warning'
                    }).then(() => {
                        row.find('.pkmusulan').select();
                    });
                }
                else{
                    row.find('.mplususulan').select();
                }
            }
        }

        function sendUsulan(){
            if(isChanged){
                swal({
                    title: 'Harap tekan tombol SIMPAN terlebih dahulu!',
                    icon: 'warning'
                }).then(() => {
                    $('#u_btnSimpan').focus();
                });
            }
            else{
                swal({
                    title: 'Yakin ingin mengirimkan usulan?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            type: "GET",
                            url: "{{ url()->current() }}/send-usulan",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                nousulan : $('#u_noUsulan').val(),
                                tglusulan : $('#u_tglUsulan').val()
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    $('#u_status').val('* USULAN SUDAH DIKIRIM *');
                                    $('#u_namaFile').val('');
                                    $('.btn-usulan').prop('disabled',true);
                                });
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                // handle error
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: error.responseJSON.message,
                                    icon: 'error'
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            }
        }

        function saveUsulan(){
            swal({
                title: `{{ __('Yakin ingin menyimpan usulan') }}!`,
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then((ok) => {
                if(ok){
                    arrData = [];

                    $('.row-data').each(function(){
                        if(convertPlu($(this).find('.prdcd').val()) != '0000000'){
                            temp = {
                                prdcd: $(this).find('.prdcd').val(),
                                mpkmawal: parseInt($(this).find('.mpkmawal').val().replaceAll(',','')),
                                pkmadjustawal: $(this).find('.pkmadjustawal').val() ? parseInt($(this).find('.pkmadjustawal').val().replaceAll(',','')) : '',
                                mplusawal: parseInt($(this).find('.mplusawal').val().replaceAll(',','')),
                                pkmtawal: parseInt($(this).find('.pkmtawal').val().replaceAll(',','')),
                                pkmusulan: parseInt($(this).find('.pkmusulan').val().replaceAll(',','')),
                                mplususulan: parseInt($(this).find('.mplususulan').val().replaceAll(',','')),
                                pkmedit: $(this).find('.pkmedit').val(),
                                mplusedit: $(this).find('.mplusedit').val(),
                            };

                            arrData.push(temp);
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: "{{ url()->current() }}/save-usulan",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            nousulan : $('#u_noUsulan').val(),
                            tglusulan : $('#u_tglUsulan').val(),
                            arrData : arrData
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal('show');
                        },
                        success: function (response) {
                            $('#modal-loader').modal('hide');
                            isChanged = false;
                            swal({
                                title: response.message,
                                icon: 'success'
                            }).then(() => {
                                getDataUsulan($('#u_noUsulan').val());
                            });
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            // handle error
                            swal({
                                title: `{{ __('Terjadi kesalahan') }}!`,
                                text: error.responseJSON.message,
                                icon: 'error'
                            }).then(() => {

                            });
                        }
                    });
                }
            });
        }

        var Upload = function (file) {
            this.file = file;
        };
        Upload.prototype.getType = function () {
            return this.file.type;
        };
        Upload.prototype.getSize = function () {
            return this.file.size;
        };
        Upload.prototype.getName = function () {
            return this.file.name;
        };

        function chooseFile() {
            if($('#u_tglUsulan').val() == ''){
                swal({
                    title: `{{ __('Silahkan pilih usulan terlebih dahulu') }}!`,
                    icon: 'error'
                }).then(() => {
                    $('#u_noUsulan').select();
                });
            }
            else $('#u_fileUsulan').click();
        }

        $('#u_fileUsulan').on('change', function (e) {
            if ($('#u_fileUsulan').val()) {
                var filename = e.target.files[0].name;
                var directory = $(this).val();

                var file = $(this)[0].files[0];

                $('#u_namaFile').val(filename);

                fileUsulan = new Upload(file);
            }
        });

        function uploadFileUsulan() {
            if($('#u_namaFile').val() == ''){
                swal({
                    title: `{{ __('Silahkan pilih file terlebih dahulu') }}!`,
                    icon: 'warning'
                }).then(() => {
                    $('#u_btnSelectFile').focus();
                });
            }
            else{
                swal({
                    title: 'Upload file ' + fileUsulan.getName() + ' ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function (result) {
                    if (result) {
                        var formData = new FormData();

                        // add assoc key values, this will be posts values
                        formData.append("fileUsulan", fileUsulan.file, fileUsulan.getName());
                        formData.append('noUsulan', $('#u_noUsulan').val());
                        formData.append('tglUsulan', $('#u_tglUsulan').val());

                        $.ajax({
                            type: "POST",
                            url: "{{ url()->current() }}/upload-file-usulan",
                            timeout: 0,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            async: true,
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                if($.fn.DataTable.isDataTable('#table_daftar')){
                                    $('#table_daftar').DataTable().destroy();
                                    $('#table_daftar tbody tr').remove();
                                }

                                for(i=0;i<response.data_usulan.length;i++)
                                {
                                    $('#table_daftar tbody').append(generateTableRow(response.data_usulan[i]));

                                }
                                tabel = $('#table_daftar').DataTable({
                                    "scrollY": "40vh",
                                    "paging" : false,
                                    "sort": false,
                                    "bInfo": false,
                                    "searching": false
                                });
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    // getDataUsulan($('#u_noUsulan').val());

                                    // console.log($('#table_daftar table tbody').append(generateTableRow(response.data_usulan[$i]));


                                });
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error',
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                    $('#u_fileUsulan').val('');
                                    $('#u_namaFile').val('');
                                });
                            }
                        });
                    }
                });
            }
        }

        function printUsulan(){
            if($('#u_noUsulan').val() == ''){
                swal({
                    title: `{{ __('Silahkan pilih usulan terlebih dahulu') }}!`,
                    icon: 'error'
                }).then(() => {
                    $('#u_noUsulan').select();
                });
            }
            else{
                $.ajax({
                    type: "GET",
                    url: "{{ url()->current() }}/check-print-usulan",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        nousulan : $('#u_noUsulan').val(),
                    },
                    beforeSend: function () {

                    },
                    success: function (response) {
                        window.open(`{{ url()->current() }}/print-usulan?nousulan=`+$('#u_noUsulan').val());
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        // handle error
                        swal({
                            title: error.responseJSON.message,
                            icon: 'error'
                        }).then(() => {

                        });
                    }
                });
            }
        }

        function chooseApprovalFile(){
            $('#a_fileApproval').click();
        }

        $('#a_fileApproval').on('change', function (e) {
            if ($('#a_fileApproval').val()) {
                var filename = e.target.files[0].name;
                var directory = $(this).val();

                var file = $(this)[0].files[0];

                $('#a_directoryFile').val(filename);

                fileApproval = new Upload(file);
            }
        });

        function uploadFileApproval() {
            if($('#a_directoryFile').val() == ''){
                swal({
                    title: `{{ __('Silahkan pilih file terlebih dahulu') }}!`,
                    icon: 'warning'
                }).then(() => {
                    $('#a_btnSelect').focus();
                });
            }
            else{
                swal({
                    title: 'Upload file ' + fileApproval.getName() + ' ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function (result) {
                    if (result) {
                        var formData = new FormData();

                        formData.append("fileApproval", fileApproval.file, fileApproval.getName());

                        $.ajax({
                            type: "POST",
                            url: "{{ url()->current() }}/upload-file-approval",
                            timeout: 0,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            async: true,
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    window.open(`{{ url()->current() }}/print-usulan?nousulan=`+response.nousulan+`&tglusulan=`+response.tglusulan);
                                    getDataApproval();

                                    // window.open(`{{ url()->current() }}/printPDF?prdcd=${$('#prdcd').val()}&upkm_mpkm_awal=${$('#upkm_mpkm_awal').val()}&upkm_pkmadjust_awal=${$('#upkm_pkmadjust_awal').val()}&upkm_mplus_awal=${$('#upkm_mplus_awal').val()}&upkm_pkmt_awal=${$('#upkm_pkmt_awal').val()}&upkm_pkm_edit=${$('#upkm_pkm_edit').val()}&upkm_mplus_edit=${$('#upkm_mplus_edit').val()}&upkm_keterangan=${$('#upkm_keterangan').val()}&pkm_mpkm=${$('#pkm_mpkm').val()}&pkm_qtymplus=${$('#pkm_qtymplus').val()}&pkm_pkmt=${$('#pkm_pkmt').val()}`, '_blank');
                                });
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error',
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                    $('#a_fileApproval').val('');
                                    $('#a_directoryFile').val('');
                                });
                            }
                        });
                    }
                });
            }
        }

        function getDataApproval(){
            if($.fn.DataTable.isDataTable('#a_tableApproval')){
                $('#a_tableApproval').DataTable().destroy();
                $("#a_tableApproval tbody tr").remove();
            }

            dataApproval = [];

            $('#a_tableApproval').DataTable({
                "ajax": '{{ url()->current() }}/get-data-approval',
                "columns": [
                    {data: 'prdcd'},
                    {data: 'upkm_mpkm_awal'},
                    {data: 'upkm_pkmadjust_awal'},
                    {data: 'upkm_mplus_awal'},
                    {data: 'upkm_pkmt_awal'},
                    {data: 'upkm_pkm_edit'},
                    {data: 'upkm_mplus_edit'},
                    {data: 'upkm_keterangan'},
                    {data: 'pkm_mpkm'},
                    {data: 'pkm_qtymplus'},
                    {data: 'pkm_pkmt'},
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('row-approval');
                    $(row).find('td').addClass('text-right');
                    $(row).find('td:eq(0)').addClass('text-center');

                    $('#a_noUsulan').val(data.no_usulan);
                    $('#a_tglUsulan').val(data.tgl_usulan);

                    dataApproval[data.prdcd] = data;
                },
                "order" : [],
                "initComplete" : function(){
                    $('.row-approval').on('mouseenter',function(){
                        $('.row-approval').removeAttr('style');
                        $(this).css({"background-color": "#acacac","color": "white"});
                        $('#a_deskripsi').val(decodeHtml(dataApproval[$(this).find('td:eq(0)').html()].prd_deskripsipanjang));
                    });
                }
            });
        }



        function getDataPKMBaru(nousulan){
            if(nousulan == null && $.inArray($('#p_findNoUsulan').val(), lovPKMBaru) == -1){
                $('#m_lov_pkm_baru').modal('show');
            }
            else{
                if($.fn.DataTable.isDataTable('#p_tablePKM')){
                    $('#p_tablePKM').DataTable().destroy();
                    $("#p_tablePKM tbody tr").remove();
                }

                dataPKMBaru = [];

                $('#p_tablePKM').DataTable({
                    "ajax": {
                        url: '{{ url()->current() }}/get-data-pkm-baru',
                        data: {
                            nousulan : nousulan == null ? $('#p_findNoUsulan').val() : nousulan
                        }
                    },
                    "columns": [
                        {data: 'pkmn_prdcd'},
                        {data: 'pkmn_mpkm'},
                        {data: 'pkmn_pkm'},
                        {data: 'pkmn_mplus_i'},
                        {data: 'pkmn_mplus_o'},
                        {data: 'pkmn_pkmt'},
                        {data: 'pkmn_create_by'},
                        {data: 'pkmn_keterangan'},
                    ],
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "scrollY" : "340px",
                    "createdRow": function (row, data, dataIndex) {
                        console.log(data);
                        $(row).addClass('row-approval');
                        $(row).find('td:eq(0)').addClass('text-center');
                        $(row).find('td:eq(1)').addClass('text-right').html(convertToRupiah2(data.pkmn_mpkm));
                        $(row).find('td:eq(2)').addClass('text-right').html(convertToRupiah2(data.pkmn_pkm));
                        $(row).find('td:eq(3)').addClass('text-right').html(convertToRupiah2(data.pkmn_mplus_i));
                        $(row).find('td:eq(4)').addClass('text-right').html(convertToRupiah2(data.pkmn_mplus_o));
                        $(row).find('td:eq(5)').addClass('text-right').html(convertToRupiah2(data.pkmn_pkmt));
                        $(row).find('td:eq(6)').addClass('text-center');
                        $(row).find('td:eq(7)').addClass('text-left');

                        $('#p_noUsulan').val(data.pkmn_nousulan);
                        $('#p_tglUsulan').val(formatDate(data.pkmn_tglusulan));

                        dataPKMBaru[data.pkmn_prdcd] = data;
                    },
                    "order" : [],
                    "initComplete" : function(){
                        // $('.pkmn_mpkm').html(convertToRupiah2(data.pkmn_mpkm));
                        // $('.pkmn_pkm').html(convertToRupiah2(data.pkmn_pkm));
                        // $('.pkmn_mplus_i').html(convertToRupiah2(data.pkmn_mplus_i));
                        // $('.pkmn_mplus_o').html(convertToRupiah2(data.pkmn_mplus_o));
                        // $('.pkmn_pkmt').html(convertToRupiah2(data.pkmn_pkmt));

                        $('.row-approval').on('mouseenter',function(){
                            $('.row-approval').removeAttr('style');
                            $(this).css({"background-color": "#acacac","color": "white"});
                            $('#p_deskripsi').val(dataPKMBaru[$(this).find('td:eq(0)').html()].prd_deskripsipanjang);
                        });

                        $('.row-approval').on('mouseleave',function(){
                            $('.row-approval').removeAttr('style');
                            $('#a_deskripsi').val('');
                        });
                    }
                });
            }
        }

        function choosePKMFile(){
            $('#p_filePKM').click();
        }

        $('#p_filePKM').on('change', function (e) {
            if ($('#p_filePKM').val()) {
                var filename = e.target.files[0].name;
                var directory = $(this).val();

                var file = $(this)[0].files[0];

                $('#p_directoryFile').val(filename);

                filePKM = new Upload(file);
            }
        });

        function uploadFilePKMBaru() {
            if($('#p_directoryFile').val() == ''){
                swal({
                    title: `{{ __('Silahkan pilih file terlebih dahulu') }}!`,
                    icon: 'warning'
                }).then(() => {
                    $('#p_btnSelect').focus();
                });
            }
            else{
                swal({
                    title: 'Upload file ' + filePKM.getName() + ' ?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then(function (result) {
                    if (result) {
                        var formData = new FormData();

                        formData.append("filePKMBaru", filePKM.file, filePKM.getName());

                        $.ajax({
                            type: "POST",
                            url: "{{ url()->current() }}/upload-file-pkm-baru",
                            timeout: 0,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            async: true,
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');
                                console.log(response,'ini response PKM produk baru');
                                swal({
                                    title: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    getDataPKMBaru(response.nousulan);
                                });
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: error.responseJSON.message,
                                    icon: 'error',
                                }).then(() => {
                                    $('#modal-loader').modal('hide');
                                    $('#a_fileApproval').val('');
                                    $('#a_directoryFile').val('');
                                });
                            }
                        });
                    }
                });
            }
        }
    </script>

@endsection
