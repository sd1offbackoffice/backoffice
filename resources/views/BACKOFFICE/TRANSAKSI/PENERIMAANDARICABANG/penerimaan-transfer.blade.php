@extends('navbar')

@section('title','PENERIMAAN CABANG | PENERIMAAN / TRANSFER')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <fieldset class="card border-secondary">
                    <legend  class="w-auto ml-3">Penerimaan / Transfer Antar Cabang</legend>
                    <div class="row m-2">
                        <div class="col-sm-6">
                            <fieldset class="card border-secondary">
                                <div class="card-body">
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden" style="position: sticky;height:455px">
                                        <table id="table_tsj" class="table table-sm table-bordered mb-3 text-center">
                                            <thead class="thColor">
                                            <tr>
                                                <th></th>
                                                <th>DOCNO</th>
                                                <th>TANGGAL</th>
                                                <th>JUMLAH</th>
                                                <th><i class="fas fa-info"></i> </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row form-group mt-3 mb-0">
                                        <div class="custom-control custom-checkbox col-sm-2 ml-3">
                                            <input type="checkbox" class="custom-control-input" id="cb_checkall_tsj" onchange="checkAllTsj(event)">
                                            <label for="cb_checkall_tsj" class="custom-control-label">Check All</label>
                                        </div>
                                        <div class="col-sm-7"></div>
                                        <button class="col btn btn-primary" onclick="proses_alfdoc()">PROSES TLKSJ</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset class="card border-secondary">
                                <div class="row m-2">
                                    <label for="tanggal" class="col-sm-2 text-right col-form-label">DIREKTORI FILE</label>
                                    <div class="col-sm-6 pr-0">
                                        <input id="filename" maxlength="10" type="text" class="form-control" value="..." disabled>
                                    </div>
                                    <button class="btn btn-secondary" onclick="$('#zip').click()">...</button>
                                    <input class="d-none" type="file" accept=".zip" id="zip"/>
                                    <button class="ml-3 col-sm-2 btn btn-primary">ISI TO</button>
                                </div>
                            </fieldset>
                            <fieldset class="card border-secondary">
                                <div class="card-body">
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar m-1 scroll-y hidden" style="position: sticky">
                                        <table id="table_to" class="table table-sm table-bordered mb-3 text-center">
                                            <thead class="thColor">
                                            <tr>
                                                <th></th>
                                                <th>DOCNO</th>
                                                <th>TANGGAL</th>
                                                <th>JUMLAH</th>
                                                <th><i class="fas fa-info"></i> </th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row form-group mt-3 mb-0">
                                        <div class="custom-control custom-checkbox col-sm-2 ml-3">
                                            <input type="checkbox" class="custom-control-input" id="cb_checkall_to" onchange="checkAllTo(event)">
                                            <label for="cb_checkall_to" class="custom-control-label">Check All</label>
                                        </div>
                                        <div class="col-sm-7"></div>
                                        <button class="col btn btn-primary" onclick="proses_to()">PROSES TO</button>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <br>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col lov">
                                <table class="table table-sm mb-0 text-center" id="table_detail">
                                    <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>PLU</th>
                                        <th>DESKRIPSI</th>
                                        <th>QTY</th>
                                        <th>QTYK</th>
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
        label {
            color: #232443;
            font-weight: bold;
        }
        .cardForm {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button,
        input[type=date]::-webkit-inner-spin-button,
        input[type=date]::-webkit-outer-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        .row_lov:hover{
            cursor: pointer;
            background-color: #acacac;
            color: white;
        }

        .my-custom-scrollbar {
            position: relative;
            height: 400px;
            overflow-y: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

    </style>

    <script>
        var listNomorTsj = [];
        var selectedTsj = [];
        var dataTsj = [];
        var listNomorTo = [];
        var selectedTo = [];
        var dataTo = [];
        var tableDetail;

        $(document).ready(function(){
            $('.tanggal').datepicker({
                "dateFormat" : "dd/mm/yy",
            });

            tableDetail = $('#table_detail').DataTable();
            getDataTsj();
            getDataTo();
        });

        function getDataTsj(){
            $.ajax({
                url: '{{ url()->current() }}/get-data-tsj',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('#table_tsj tbody tr').remove();
                    listNomorTsj = [];
                    dataTsj = response;
                    for(i=0;i<response.length;i++){
                        listNomorTsj.push(response[i].no);

                        tr = `<tr><td>` +
                            `<div class="custom-control custom-checkbox text-center">` +
                            `<input type="checkbox" class="custom-control-input cb-no-tsj" id="cb_tsj_${i}" onchange="selectDaftarTsj(event)">` +
                            `<label for="cb_tsj_${i}" class="custom-control-label"></label>` +
                            `</div></td>` +
                            `<td>${response[i].no}</td>` +
                            `<td>${response[i].tgl}</td>` +
                            `<td>${response[i].jum}</td>` +
                            `<td><button class="btn btn-sm btn-primary" onclick="detailItemTsj(${response[i].no})"><i class="fas fa-info"></i></button></td>` +
                            `</td></tr>`;

                        $('#table_tsj tbody').append(tr);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            });
        }

        function selectDaftarTsj(e){
            nomor = listNomorTsj[$(e.target).attr('id').substr(-1)];
            if($(e.target).is(':checked')){
                selectedTsj.push(nomor);
                if(selectedTsj.length == listNomorTsj.length)
                    $('#cb_checkall_tsj').prop('checked',true);
            }
            else{
                $('#cb_checkall_tsj').prop('checked',false);
                selectedTsj = $.grep(selectedTsj, function(value) {
                    return value != nomor;
                });
            }
        }

        function detailItemTsj(nodoc){
            $.ajax({
                url: '{{ url()->current() }}/get-detail-tsj',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    no: nodoc
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    tableDetail.destroy();
                    $('#table_detail tbody tr').remove();
                    for(i=0;i<response.length;i++){
                        html = `<tr>` +
                                `<td>${i+1}</td>` +
                                `<td>${response[i].tsj_prdcd}</td>` +
                                `<td>${response[i].prd_deskripsipanjang}</td>` +
                                `<td>${response[i].tsj_qty}</td>` +
                                `<td>${response[i].tsj_qtyk}</td>` +
                                `</tr>` ;

                        $('#table_detail tbody').append(html);
                    }
                    tableDetail = $('#table_detail').DataTable();
                    $('#m_detail').modal('show');
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            });
        }

        function checkAllTsj(e){
            if($(e.target).is(':checked')){
                $('.cb-no-tsj').prop('checked',true);
                selectedTsj = listNomorTsj;
            }
            else{
                $('.cb-no-tsj').prop('checked',false);
                selectedTsj = [];
            }
        }

        function proses_alfdoc(){
            if(selectedTsj.length == 0){
                swal({
                    title: 'Tidak ada data yang dipilih!',
                    icon: 'error'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin transfer data?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/proses-alfdoc',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                docs: selectedTsj,
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                getData();

                                if(response.status == 'success'){
                                    i = 0;
                                    selectedTsj = [];
                                    showAlert(response.alert,i);
                                }
                                else{
                                    swal({
                                        title: 'Terjadi kesalahan!',
                                        text: 'Mohon coba kembali!',
                                        icon: 'error',
                                    })
                                }
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: error.responseJSON.message,
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            }
        }

        function showAlert(alert, idx){
            swal({
                title: alert[idx],
                icon: 'success'
            }).then(() => {
                if(idx < alert.length-1)
                    showAlert(alert,++idx);
            });
        }

        $('#zip').on('change',function(e){
            var filename = e.target.files[0].name;

            var file = $(this)[0].files[0];
            var upload = new Upload(file);

            swal({
                title: 'Proses file ' + filename + ' ?',
                icon: 'warning',
                buttons: true,
                dangerMode: true
            }).then(function(ok){
                if(ok){
                    $('#filename').val(filename);
                    upload.doImport();
                }
                else{
                    $('#filename').val('...');
                    $('#zip').val('');
                }
            })
        });

        var Upload = function (file) {
            this.file = file;
        };

        Upload.prototype.getType = function() {
            return this.file.type;
        };

        Upload.prototype.getSize = function() {
            return this.file.size;
        };

        Upload.prototype.getName = function() {
            return this.file.name;
        };

        Upload.prototype.doImport = function () {
            var that = this;
            var formData = new FormData();
            var filename = this.getName();

            // add assoc key values, this will be posts values
            formData.append("file", this.file, this.getName());
            formData.append("upload_file", true);

            $.ajax({
                type: "POST",
                url: "{{ url()->current().'/upload-to' }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: true,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000,
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    if(response.status == 'success'){
                        swal({
                            title: 'File ' + filename + ' berhasil diproses!',
                            icon: response.status
                        });

                        getDataTo();
                    }
                    // $('#modal-loader').modal('hide');
                },
                error: function (error) {
                    // handle error
                    $('#modal-loader').modal('hide');
                    swal({
                        title: 'Terjadi Kesalahan!',
                        text: 'Mohon pastikan file zip berasal dari program Transfer SJ - IAS!',
                        icon: 'error'
                    }).then(function(){
                        // location.reload();
                    });
                    $('#filename').val('...');
                }
            });
        };

        function getDataTo(){
            $.ajax({
                url: '{{ url()->current() }}/get-data-to',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    $('#table_to tbody tr').remove();
                    listNomor = [];
                    result = response;
                    for(i=0;i<result.length;i++){
                        listNomorTo.push(result[i].docno);

                        tr = `<tr><td>` +
                            `<div class="custom-control custom-checkbox text-center">` +
                            `<input type="checkbox" class="custom-control-input cb-no-to" id="cb_to_${i}" onchange="selectDaftarTo(event)">` +
                            `<label for="cb_to_${i}" class="custom-control-label"></label>` +
                            `</div></td>` +
                            `<td>${result[i].docno}</td>` +
                            `<td>${result[i].tgl}</td>` +
                            `<td>${result[i].jml}</td>` +
                            `<td><button class="btn btn-sm btn-primary" onclick="detailItemTo(${result[i].docno})"><i class="fas fa-info"></i></button></td>` +
                            `</td></tr>`;

                        $('#table_to tbody').append(tr);
                    }
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            });
        }

        function selectDaftarTo(e){
            nomor = listNomorTo[$(e.target).attr('id').substr(-1)];
            if($(e.target).is(':checked')){
                selectedTo.push(nomor);
                if(selectedTo.length == listNomorTo.length)
                    $('#cb_checkall_to').prop('checked',true);
            }
            else{
                $('#cb_checkall_to').prop('checked',false);
                selectedTo = $.grep(selectedTo, function(value) {
                    return value != nomor;
                });
            }
        }

        function detailItemTo(nodoc){
            $.ajax({
                url: '{{ url()->current() }}/get-detail-to',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    no: nodoc
                },
                beforeSend: function () {
                    $('#modal-loader').modal('show');
                },
                success: function (response) {
                    $('#modal-loader').modal('hide');

                    tableDetail.destroy();
                    $('#table_detail tbody tr').remove();
                    for(i=0;i<response.length;i++){
                        html = `<tr>` +
                                `<td>${i+1}</td>` +
                                `<td>${response[i].prdcd}</td>` +
                                `<td>${response[i].desc2}</td>` +
                                `<td>${response[i].qty}</td>` +
                                `<td>${response[i].qtyk}</td>` +
                                `</tr>` ;

                        $('#table_detail tbody').append(html);
                    }
                    tableDetail = $('#table_detail').DataTable();
                    $('#m_detail').modal('show');
                },
                error: function (error) {
                    $('#modal-loader').modal('hide');
                }
            });
        }

        function checkAllTo(e){
            if($(e.target).is(':checked')){
                $('.cb-no-to').prop('checked',true);
                selectedTo = listNomorTo;
            }
            else{
                $('.cb-no-to').prop('checked',false);
                selectedTo = [];
            }
        }

        function proses_to(){
            if(selectedTo.length == 0){
                swal({
                    title: 'Tidak ada data yang dipilih!',
                    icon: 'error'
                });
            }
            else{
                swal({
                    title: 'Yakin ingin proses data?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true
                }).then((ok) => {
                    if(ok){
                        $.ajax({
                            url: '{{ url()->current() }}/proses-to',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            data: {
                                no: selectedTo,
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal('show');
                            },
                            success: function (response) {
                                $('#modal-loader').modal('hide');

                                swal({
                                    title: response.alert,
                                    icon: response.status,
                                });

                                if(response.status == 'success'){
                                    selectedTo = [];
                                }

                                getDataTo();
                            },
                            error: function (error) {
                                $('#modal-loader').modal('hide');
                                swal({
                                    title: 'Terjadi kesalahan!',
                                    text: error.responseJSON.message,
                                    icon: 'error',
                                });
                            }
                        });
                    }
                });
            }
        }

    </script>

@endsection
