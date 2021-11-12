@extends('navbar')
@section('title','Tabel Pembayaran Voucher ( Supplier )')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5 text-left">Tabel Pembayaran Voucher ( Supplier )</legend>
                    <div class="card-body shadow-lg cardForm">
                        <br>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Supplier</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="inputSupp">
                                <button id="btnSupp" type="button" class="btn btn-lov p-0" onclick="ToggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <input type="text" class="col-sm-4 form-control" id="deskSupp" disabled>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Singkatan Supplier</label>
                            <div class="col-sm-2 buttonInside">
                                <input type="text" class="form-control" id="inputSingkatan">
                                <button id="btnSingkatan" type="button" class="btn btn-lov p-0" onclick="ToggleData(this)">
                                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                </button>
                            </div>
                            <label class="col-sm-6 col-form-label text-left">( Harus Sama Dengan Tabel Voucher Supplier )</label>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label text-right">Tanggal</label>
                            <div class="col-sm-5">
                                <input class="text-center form-control" type="text" id="daterangepicker">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button class="btn btn-primary col-sm-2" type="button" onclick="Save()">SAVE</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button class="btn btn-danger col-sm-2" type="button" onclick="Hapus()">DELETE</button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-12">
                <fieldset class="card border-dark">
                    <div class="card-body shadow-lg cardForm">
                        <div class="p-0 tableFixedHeader" style="height: 400px;">
                            <table class="table table-sm table-striped table-bordered"
                                   id="tableMain">
                                <thead>
                                <tr class="table-sm text-center">
                                    <th width="3%" class="text-center small">&nbsp;&nbsp;</th>
                                    <th width="17%" class="text-center small">PLU</th>
                                    <th width="50%" class="text-center small">Deskripsi</th>
                                    <th width="20%" class="text-center small">Max Voucher</th>
                                    <th width="10%" class="text-center small">Pilihan</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyMain" style="height: 400px;">
                                @for($i = 0 ; $i< 10 ; $i++)
                                    <tr class="baris">
                                        <td class="text-center">
                                            <button onclick="deleteRow(this)" class="btn btn-block btn-sm btn-danger btn-delete-row-header" class="icon fas fa-times">X</button>
                                        </td>
                                        <td>
                                            <input class="form-control plu" value=""
                                                   type="text" disabled>
                                        </td>
                                        <td>
                                            <input class="form-control deskripsi text-right" value=""
                                                   type="text" disabled>
                                        </td>
                                        <td>
                                            <input class="form-control voucher text-right" value="" onkeypress="return isNumberKey(event)"
                                                   type="text">
                                        </td>
                                        <td>
                                            <input class="form-control pilihan text-right" value="" onchange="CheckBoxTabel()"
                                                   type="checkbox">
                                        </td>
                                    </tr>
                                @endfor
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <input id="checkAll" value="" style=""
                                       type="checkbox">
                                <label class="col-form-label text-left">SELECT ALL</label>
                            </div>
                            <div class="col-sm-8 d-flex justify-content-end">
                                <button class="btn btn-primary col-sm-2 add-btn" type="button" onclick="addRow()">ADD ROW</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal SUPPLIER--}}
    <div class="modal fade" id="m_supp" tabindex="-1" role="dialog" aria-labelledby="m_supp" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableSupp">
                                    <thead class="theadSupp">
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>Kode Supplier</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodySupp"></tbody>
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

    {{--Modal SINGKATAN--}}
    <div class="modal fade" id="m_singkatan" tabindex="-1" role="dialog" aria-labelledby="m_singkatan" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Voucher Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableSingkatan">
                                    <thead class="theadSingkatan">
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>Nilai Voucher</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodySingkatan"></tbody>
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
        let tableSupp;
        let tableSingkatan;
        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        $(document).ready(function () {
            getModalSupp();
            getModalSingkatan();
        });

        function getModalSupp(){
            tableSupp =  $('#tableSupp').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-supplier',
                },
                "columns": [
                    {data: 'sup_namasupplier', name: 'sup_namasupplier'},
                    {data: 'hgb_kodesupplier', name: 'hgb_kodesupplier'},
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
                    $(row).addClass('modalSupp');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        $(document).on('click', '.modalSupp', function () {
            let currentButton = $(this);
            let kode = currentButton.children().first().next().text();

            $('#inputSupp').val(kode).change();
            $('#m_supp').modal('toggle');
        });

        function getModalSingkatan(){
            tableSingkatan =  $('#tableSingkatan').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/get-singkatan',
                },
                "columns": [
                    {data: 'vcs_namasupplier', name: 'vcs_namasupplier'},
                    {data: 'vcs_nilaivoucher', name: 'vcs_nilaivoucher'},
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
                    $(row).addClass('modalSingkatan');
                },
                columnDefs : [
                ],
                "order": []
            });
        }

        $(document).on('click', '.modalSingkatan', function () {
            let currentButton = $(this);
            let voucher = currentButton.children().first().text();

            $('#inputSingkatan').val(voucher).change();
            $('#m_singkatan').modal('toggle');
        });

        function ToggleData(val){
            if(val.id == "btnSupp"){
                $('#m_supp').modal('toggle');
                CheckSupp();
            }else if(val.id == "btnSingkatan"){
                $('#m_singkatan').modal('toggle');
            }
        }

        function CheckSupp(val){
            for(i=0;i<tableSupp.data().length;i++){
                if(tableSupp.row(i).data()['hgb_kodesupplier'] == val){
                    return i+1;
                }
            }
            return 0;
        }

        function CheckSingkatan(val){
            for(i=0;i<tableSingkatan.data().length;i++){
                if(tableSingkatan.row(i).data()['vcs_namasupplier'] == val){
                    return i+1;
                }
            }
            return 0;
        }

        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        function CheckVoucher(){
            if($('#inputSupp').val() != '' && $('#inputSingkatan').val() != ''){
                $.ajax({
                    url: '{{ url()->current() }}/check-voucher',
                    type: 'GET',
                    data: {
                        supp:$('#inputSupp').val(),
                        sing:$('#inputSingkatan').val()
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        if(response.tglAwal != ''){
                            $('#daterangepicker').data('daterangepicker').setStartDate(response.tglAwal);
                            $('#daterangepicker').data('daterangepicker').setEndDate(response.tglAkhir);
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                        return false;
                    }
                });
            }
        }

        function CheckDBTable(){
            if($('#inputSupp').val() != '' && $('#inputSingkatan').val() != ''){
                let date = $('#daterangepicker').val();
                if(date == null || date == ""){
                    swal('Periode tidak boleh kosong','','warning');
                    return false;
                }
                let dateA = date.substr(0,10);
                let dateB = date.substr(13,10);
                dateA = dateA.split('/').join('-');
                dateB = dateB.split('/').join('-');
                $.ajax({
                    url: '{{ url()->current() }}/check-db-table',
                    type: 'GET',
                    data: {
                        supp:$('#inputSupp').val(),
                        sing:$('#inputSingkatan').val(),
                        date1:dateA,
                        date2:dateB,
                    },
                    beforeSend: function () {
                        $('#modal-loader').modal('show');
                    },
                    success: function (response) {
                        $('#modal-loader').modal('hide');
                        $('.baris').remove();
                        for(i=0;i<response.length;i++){
                            addRow();
                            $('.plu')[i].value = response[i].byr_prdcd;
                            $('.deskripsi')[i].value = response[i].prd_deskripsipanjang;
                            $('.voucher')[i].value = response[i].byr_qtymaxvoucher;
                        }
                    },
                    error: function (error) {
                        $('#modal-loader').modal('hide');
                        swal({
                            title: error.responseJSON.title,
                            text: error.responseJSON.message,
                            icon: 'error',
                        });
                        return false;
                    }
                });
            }
        }

        //fungsi checkbox
        function CheckBoxTabel(){
            if($('.pilihan:checked').length == $('.pilihan').length){
                if($('#checkAll').prop("checked") == false){
                    $('#checkAll').prop("checked",true);
                }
            }else{
                if($('#checkAll').prop("checked") == true){
                    $('#checkAll').prop("checked",false);
                }
            }
        }

        function addRow() {
            $('#tableMain').append(tempTable());
            CheckBoxTabel();
        }

        function deleteRow(e) {
            // setInterval($(e).parents("tr").remove(),10000);
            $(e).parents("tr").remove();
            CheckBoxTabel();
        }

        function tempTable() {
            var temptbl =  `<tr class="baris">
                                        <td class="text-center">
                                            <button onclick="deleteRow(this)" class="btn btn-block btn-sm btn-danger btn-delete-row-header" class="icon fas fa-times">X</button>
                                        </td>
                                        <td>
                                            <input class="form-control plu" value=""
                                                   type="text" disabled>
                                        </td>
                                        <td>
                                            <input class="form-control deskripsi text-right" value=""
                                                   type="text" disabled>
                                        </td>
                                        <td>
                                            <input class="form-control voucher text-right" value="" onkeypress="return isNumberKey(event)"
                                                   type="text">
                                        </td>
                                        <td>
                                            <input class="form-control pilihan text-right" value="" onchange="CheckBoxTabel()"
                                                   type="checkbox">
                                        </td>
                                    </tr>`

            return temptbl;
        }

        function Save(){
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal('Periode tidak boleh kosong','','warning');
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            let datas   = [{'plu' : '', 'status' : ''}];
            let status = '';
            let values = $('input:checkbox:checked.pilihan').map(function () {
                return this.parentNode.parentNode.rowIndex-1;
            }).get();
            for(i=0;i<$('.baris').length;i++){
                if($('.plu')[i].value != ''){
                    status = 0;
                    for(j=0;j<values.length;j++){
                        if(values[j] == i){
                            status = 2;
                            break;
                        }
                    }
                    datas.push({'plu':$('.plu')[i].value, 'voucher': $('.voucher')[i].value,'status' : status})
                }
            }
            //Saving
            $.ajax({
                url: '{{ url()->current() }}/save',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    date1:dateA,
                    date2:dateB,
                    datas:datas,
                    supp:$('#inputSupp').val(),
                    sing:$('#inputSingkatan').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (response) {
                    swal({
                        title: response.title,
                        icon: 'success'
                    }).then(() => {
                        ClearForm();
                    })
                },
                complete: function () {
                    $('#modal-loader').modal('hide');
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                    swal({
                        title: error.responseJSON.title,
                        text: error.responseJSON.message,
                        icon: 'error',
                    });
                    return false;
                }
            });
        }

        function Hapus(){
            swal({
                title: 'Data Voucher Akan Didelete ?',
                icon: 'warning',
                dangerMode: true,
                buttons: true,
            }).then(function (confirm) {
                console.log(confirm);
                if (confirm) {
                    $.ajax({
                        url: '{{ url()->current() }}/hapus',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            supp:$('#inputSupp').val(),
                            sing:$('#inputSingkatan').val(),
                        },
                        beforeSend: function () {
                            $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                        },
                        success: function (response) {
                            swal({
                                title: response.title,
                                icon: 'success'
                            }).then(() => {
                                ClearForm();
                            })
                        },
                        complete: function () {
                            $('#modal-loader').modal('hide');
                        },
                        error: function (error) {
                            $('#modal-loader').modal('hide');
                            swal({
                                title: error.responseJSON.title,
                                text: error.responseJSON.message,
                                icon: 'error',
                            });
                            return false;
                        }
                    });
                }
            });

        }

        function ClearForm(){
            $(' input').val('');
            $('#daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            $('#daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));

            $('.baris').remove();
            for(i=0;i<10;i++){
                addRow();
            }
        }

        $('#inputSupp').on('change', function() {
            if($('#inputSupp').val() != ''){
                let index = CheckSupp($('#inputSupp').val());
                if(index){
                    index = index - 1;
                    $('#deskSupp').val(tableSupp.row(index).data()['sup_namasupplier']);
                    CheckVoucher();
                }else{
                    swal({
                        // title: "",
                        text: "Data Supplier "+$('#inputSupp').val()+" Tidak Ada !!",
                        icon: 'warning',
                    }).then(() => {
                        $('#inputSupp').val('').focus();
                    });
                }
            }
        });

        $('#inputSingkatan').on('change', function() {
            if($('#inputSingkatan').val() != ''){
                if(($('#inputSingkatan').val()).substr(0,3) === 'IGR'){
                    swal({
                        // title: "",
                        text: "Voucher Supplier Salah !!",
                        icon: 'warning',
                    }).then(() => {
                        $('#inputSingkatan').val('').focus();
                    });
                }else{
                    let index = CheckSingkatan($('#inputSingkatan').val());
                    if(index){
                        index = index - 1;
                        // $('#deskSupp').val(tableSupp.row(index).data()['sup_namasupplier']);
                        CheckVoucher();
                    }else{
                        swal({
                            // title: "",
                            text: "Voucher Supplier Tidak Terdaftar !!",
                            icon: 'warning',
                        }).then(() => {
                            $('#inputSingkatan').val('').focus();
                        });
                    }
                }
            }
        });
        $('#daterangepicker').on('change', function() {
            CheckDBTable();
        });

        $('#checkAll').on('change', function() {
            if($('#checkAll').prop("checked") == false){
                if($('.pilihan:checked').length == $('.pilihan').length){
                    $('.pilihan').prop("checked",false);
                }
            }else{
                if($('.pilihan:checked').length != $('.pilihan').length){
                    $('.pilihan').prop("checked",true);
                }
            }
        });
    </script>
@endsection
