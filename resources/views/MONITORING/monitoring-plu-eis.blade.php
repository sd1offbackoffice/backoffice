@extends('navbar')
@section('title','Monitoring Plu Igr')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12 col-md-5 mb-3">
                <div class="card">
                    <div class="card-header" style="background-color: #1E87C2">
                        <h5 class="text-white">List Monitoring <i class="fa fa-list" aria-hidden="true"></i></h5>
                    </div>
                    <div class="card-body shadow-sm">
{{--                        <button class="btn btn-outline-success float-right" type="button" onclick="reloadQv('CUSTOMREPORT2020')">Reload Custom Report 2020</button>--}}
{{--                        <button class="btn btn-outline-success float-right mr-3" type="button" onclick="reloadQv('CUSTOMREPORT2021')">Reload Custom Report 2021</button>--}}
{{--                        <button class="btn btn-outline-success float-right mr-3" type="button" onclick="reloadQv('IGRSTOCK')">Reload Igr Stock</button>--}}

{{--                        <button class="btn btn-success" type="button" onclick="openModal()">Create New Monitoring +</button>--}}

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <button class="btn btn-success" type="button" onclick="openModal()">Create New Monitoring +</button>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <table id="tableListMonitoringPlu" class="table table-striped table-bordered table-sm" style="width:100%">
                            <thead>
                            <tr>
                                <th>KODE</th>
                                <th>KETERANGAN</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-7">
                <div class="card">
                    <div class="card-header" style="background-color: #1E87C2">
                        <h5 class="text-white">Detail Product Monitoring <i class="fa fa-outdent" aria-hidden="true"></i></h5>
                    </div>
                    <div class="card-body shadow-sm">
                        <table id="tableDetailMonitoringPlu" class="table table-striped table-bordered table-sm" style="width:100%;">
                            <thead>
                            <tr>
                                <th>PRDCD</th>
                                <th>DESC</th>
                                <th>UNIT</th>
                                <th>FRAC</th>
                                <th>PTAG</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CREATE NEW MONITORING PLU-->
    <div class="modal fade" id="createNewMonitoring" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="modalTitleMtrPlu">Create New Monitoring</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-row ">
                            <div class="col-sm-5">
                                <label>Nama Monitoring</label>
                                <input type="text" class="form-control" placeholder="..." id="i_mtrName">
                                <div class="invalid-feedback" id="feedback_mtrName"></div>
                            </div>
                            <div class="col-sm-3">
                                <label>kode PLU</label>
                                <input type="text" class="form-control" placeholder="0000000" id="i_prdcd">
                                <div class="invalid-feedback" id="feedback_prdcd"> </div>
                            </div>
                            <div class="col-sm-3 mt-5">
                                <p class="text-secondary">*Masukan Kode PLU lalu tekan enter</p>
                            </div>
                        </div>
                    </form>

                    <!--Part of Upload Excel-->
                    <div id="importExcelPart">
                        <hr>
                        <form enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-row ">
                                <div class="col-sm-9">
                                    <input type="file" name="file" id="file" class="excelPlu"/>
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-success" onclick="prosesExcel()">Proses</button>
                                </div>
                            </div>
                            <div class="form-row ">
                                <div class="col-sm-1">
                                    <label for="">Template :</label>
                                </div>
                                <div class="col-sm-9 text-left">
                                    <a href="{{storage_path()}}/template_excel_monitoring_plu_eis.xlsx">template_excel_monitoring_plu_eis.xlsx</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <table class="table table-sm mt-2">
                        <thead>
                        <tr>
                            <th>Kode PLU</th>
                            <th>Deskripsi</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="tbodyModal"></tbody>
                    </table>

                    <div id="modal_info">
                        <small class="mr-auto text-secondary">*Data belum di simpan</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="showImportExcel()" >Import Excel</button>
                    <button type="button" class="btn btn-danger" onclick="clearModal()" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="mtrSaveBtn" onclick="saveMonitoring()">Save</button>
                    <button type="button" class="btn btn-primary" id="mtrUpdateBtn" onclick="updateMonitoring()">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        let tableListMonitoringPlu = $('#tableListMonitoringPlu').DataTable();
        let tableDetailMonitoringPlu = $('#tableDetailMonitoringPlu').DataTable();
        let flagKodeMtr = 0;
        let tempPlu = [];

        $(document).ready(function () {
            viewListMonitoring()
            $('#importExcelPart').hide();
        })

        function viewListMonitoring(){
            tableListMonitoringPlu.destroy();
            tableListMonitoringPlu = $('#tableListMonitoringPlu').DataTable({
                "ajax": {
                    'url' : "{{ url()->current() }}/view-mtr",
                },
                "columns": [
                    {data: 'mtr_kodemtr', width : '15%'},
                    {data: 'mtr_namamtr', width : '55%'},
                    {data: 'mtr_kodemtr', width : '30%'}
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
                },
                columnDefs : [
                    { targets : [2],
                        render : function (data, type, row) {
                            return `<div class='text-center'>
                                <button  class='btn pt-0 pb-1 pl-2 pr-2' id='viewListDetail' onclick="viewListDetail('${data}')" style='background-color: #57C4DB'><i class="fa fa-search-plus" aria-hidden="true"></i></button>
                                <button class='btn btn-warning pt-0 pb-1 pl-2 pr-2' id='editListMonitoring' onclick="editMonitoring('${data}')"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                <button class='btn pt-0 pb-1 pl-2 pr-2' style='background-color: #DA564E' onclick="deleteMonitoring('${data}')"><i class="fa fa-trash" aria-hidden="true"></i></button></div>`
                        }
                    },
                ],
                "order": []});
        }


        window.viewListDetail = (kodeMtr) => {
            tableDetailMonitoringPlu.destroy();
            tableDetailMonitoringPlu = $('#tableDetailMonitoringPlu').DataTable({
                "ajax": {
                    'url' : '{{ url()->current() }}/view-detail',
                    data : {kodeMtr}
                },
                "columns": [
                    {data: 'mtr_kodeplu', width : '15%'},
                    {data: 'mtr_deskripsi', width : '55%'},
                    {data: 'mtr_unit', width : '10%'},
                    {data: 'mtr_frac', width : '10%'},
                    {data: 'mtr_ptag', width : '10%'}
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    // "zeroRecords": "Choose Monitoring"
                },
                "createdRow": function (row, data, dataIndex) {
                    $(row).addClass('modalRow');
                },
            })
        }

        window.openModal = () => {
            if (tempPlu.length > 0) {
                $('#modal_info').show()
            } else {
                $('#modal_info').hide()
            }

            $('#modalTitleMtrPlu').text("Create New Monitoring")
            $('#importExcelPart').hide();
            $('#createNewMonitoring').modal('show');
            $('#mtrSaveBtn').show();
            $('#mtrUpdateBtn').hide();
        }

        $('#i_prdcd').on('keypress', function (e) {
            if (e.which === 13) {
                let plu = $(this).val();
                let max = plu.length;

                $('#i_prdcd').removeClass('is-invalid')
                $('#feedback_prdcd').children().remove();

                // Validasi plu
                if (max > 7){
                    $('#i_prdcd').addClass('is-invalid')
                    $('#feedback_prdcd').append(`<p>Max 7 karakter</p>`)
                    return false;
                } else if (plu.substr(-1,1) != 0){
                    $('#i_prdcd').addClass('is-invalid')
                    $('#feedback_prdcd').append(`<p>Karakter terakhir harus 0</p>`)
                    return false;
                }

                for (let i =0; i<(7-max); i++){
                    plu = '0'+plu;
                }

                ajaxSetup();
                $.ajax({
                    url: '{{ url()->current() }}/search-plu',
                    type: 'POST',
                    data : {plu},
                    success: function (result) {
                        console.log(result)
                        if (result == 0){
                            $('#i_prdcd').addClass('is-invalid')
                            $('#feedback_prdcd').append(`<p>Kode PLU tidak ditemukan</p>`)
                            return false;
                        } else {
                            console.log("data ada")
                            for (let i =0; i< tempPlu.length; i++){
                                if (tempPlu[i]['mtr_kodeplu'] == plu){
                                    $('#i_prdcd').addClass('is-invalid')
                                    $('#feedback_prdcd').append(`<p>Kode PLU sudah ada</p>`)
                                    return false;
                                }
                            }

                            tempPlu.push(result);
                            $('#i_prdcd').val('')
                            console.log(tempPlu)
                            displayTableTempPlu()

                        }
                    }, error: function (err) {
                        console.log(err);
                        errorHandlingforAjax(err)
                    }
                })
            }
        })

        window.displayTableTempPlu = ()=> {
            $('#tbodyModal').children().remove()
            for (let i =0; i< tempPlu.length; i++){
                $('#tbodyModal').append(`<tr>
                                    <td>${tempPlu[i].mtr_kodeplu}</td>
                                    <td>${tempPlu[i].mtr_deskripsi}</td>
                                    <td><button class="btn btn-outline-danger" onclick="deleteListNewPlu(${i})">Delete</button></td>
                                </tr>`)
            }

            if (tempPlu.length > 0) {
                $('#modal_info').show()
            } else {
                $('#modal_info').hide()
            }
        }

        window.deleteListNewPlu = (index)=> {
            tempPlu.splice(index,1);
            displayTableTempPlu()
        }

        window.showImportExcel = ()=> {
            $('#importExcelPart').show();
        }

        window.prosesExcel = () => {
            let formData = new FormData();
            let fileInput = document.getElementById('file');
            let files   = fileInput.files;
            formData.append('file', files[0]);

            ajaxSetup()
            $.ajax({
                url: '{{ url()->current() }}/prosesexcelplu',
                type: 'POST',
                processData:false,
                contentType:false,
                cache:false,
                dataType: "json",
                data:formData,
                success: function (result) {
                    if (result.kode == 1){
                        let data = result.data;
                        for (let i =0; i< data.length; i++){
                            tempPlu.push(data[i]);
                        }
                        displayTableTempPlu()
                    } else {
                        swal(result.message, '', 'warning');
                    }
                }, error: function (error) {
                    errorHandlingforAjax(error)
                }
            })
        }

        window.saveMonitoring = () => {
            let mtrName = $('#i_mtrName').val()

            $('#i_prdcd').removeClass('is-invalid')
            $('#feedback_prdcd').children().remove();
            $('#i_mtrName').removeClass('is-invalid')
            $('#feedback_mtrName').children().remove();

            //Validasi
            if (mtrName.length == 0){
                $('#i_mtrName').addClass('is-invalid')
                $('#feedback_mtrName').append(`<p>Nama Monitoring tidak boleh kosong</p>`)
                return false;
            }  else if (tempPlu.length < 1){
                $('#i_prdcd').addClass('is-invalid')
                $('#feedback_prdcd').append(`<p>Data PLU tidak boleh kosong</p>`)
                return false;
            } else if (mtrName.length > 29){
                $('#i_mtrName').addClass('is-invalid')
                $('#feedback_mtrName').append(`<p>Nama Monitoring tidak boleh lebih dari 30 karakter</p>`)
                return false;
            }

            swal({
                title: "Simpan Data?",
                text: "Data Monitoring tetap bisa diedit setelah di simpan",
                icon: "info",
                buttons: true,
                dangerMode: true,
            }).then((save) => {
                if (save) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/save',
                        type: 'POST',
                        data : {mtrName : mtrName, tempPlu: tempPlu},
                        success: function (result) {
                            console.log(result)
                            if (result.kode == 1){
                                swal({
                                    icon: 'success',
                                    title: 'Data Monitoring telah di simpan',
                                    text: 'Kode Monitoring anda : ' + result.data,
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                $('#createNewMonitoring').modal('hide');
                                tempPlu = [];
                                $('#i_mtrName').val('');
                                $('#i_prdcd').val('');
                                viewListMonitoring();
                                clearModal();
                            } else {
                                swal(result.message, '', 'warning');
                            }
                        }, error: function (err) {
                            console.log(err);
                            errorHandlingforAjax(err)
                        }
                    })
                } else {
                    console.log('Data tidak disimpan');
                }
            });
        }

        window.deleteMonitoring = (kodeMtr) => {
            swal({
                title: "Delete Monitoring?",
                text: "Anda yakin ingin menghapus monitoring ini?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/delete',
                        type: 'POST',
                        data : {kodeMtr},
                        success: function (result) {
                            console.log(result)
                            if (result.kode == 1){
                                swal({
                                    icon: 'success',
                                    title: 'Data Monitoring telah di hapus',
                                    text: '',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                viewListMonitoring()
                            } else {
                                swal(result.message, '', 'warning');
                            }
                        }, error: function (err) {
                            console.log(err);
                            errorHandlingforAjax(err)
                        }
                    })
                } else {
                    console.log('Data tidak dihapus');
                }
            });
        }

        window.editMonitoring = (kodeMtr) => {
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/edit',
                type: 'POST',
                data : {kodeMtr},
                success: function (result) {
                    console.log(result)
                    if (result.kode == 1){
                        // Modal Setting
                        $('#modalTitleMtrPlu').text("Update Monitoring")
                        $('#importExcelPart').hide();
                        $('#mtrSaveBtn').hide();
                        $('#mtrUpdateBtn').show();
                        $("#createNewMonitoring").modal({
                            backdrop: "static",
                            keyboard: false
                        });

                        //Set Data
                        flagKodeMtr = kodeMtr
                        $('#i_mtrName').val(result.data[0])
                        tempPlu = result.data[1]
                        displayTableTempPlu()
                    } else {
                        swal(result.message, '', 'warning');
                    }
                }, error: function (err) {
                    console.log(err);
                    errorHandlingforAjax(err)
                }
            })
        }

        window.updateMonitoring = () => {
            let mtrName = $('#i_mtrName').val();

            $('#i_prdcd').removeClass('is-invalid')
            $('#feedback_prdcd').children().remove();
            $('#i_mtrName').removeClass('is-invalid')
            $('#feedback_mtrName').children().remove();

            //Validasi
            if (mtrName.length == 0){
                $('#i_mtrName').addClass('is-invalid')
                $('#feedback_mtrName').append(`<p>Nama Monitoring tidak boleh kosong</p>`)
                return false;
            }  else if (tempPlu.length < 1){
                $('#i_prdcd').addClass('is-invalid')
                $('#feedback_prdcd').append(`<p>Data PLU tidak boleh kosong</p>`)
                return false;
            } else if (mtrName.length > 29){
                $('#i_mtrName').addClass('is-invalid')
                $('#feedback_mtrName').append(`<p>Nama Monitoring tidak boleh lebih dari 30 karakter</p>`)
                return false;
            }

            swal({
                title: "Update Data?",
                text: "Data Monitoring tetap bisa diedit setelah di simpan",
                icon: "info",
                buttons: true,
                dangerMode: true,
            }).then((save) => {
                if (save) {
                    ajaxSetup();
                    $.ajax({
                        url: '{{ url()->current() }}/update',
                        type: 'POST',
                        data : {tempPlu, mtrName , kodeMtr:flagKodeMtr},
                        success: function (result) {
                            console.log(result)
                            if (result.kode == 1){
                                swal({
                                    icon: 'success',
                                    title: 'Data Monitoring berhasil di update',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                $('#createNewMonitoring').modal('hide');
                                tempPlu = [];
                                $('#i_mtrName').val('');
                                $('#i_prdcd').val('');
                                viewListMonitoring();
                                viewListDetail(flagKodeMtr);
                                clearModal();
                            } else {
                                swal(result.message, '', 'warning');
                            }
                        }, error: function (err) {
                            console.log(err);
                            errorHandlingforAjax(err)
                        }
                    })
                } else {
                    console.log('Data tidak disimpan');
                }
            });

        }

        clearModal =  () => {
            $('#i_mtrName').val('');
            $('#i_prdcd').val('');
            tempPlu = [];
            displayTableTempPlu();
        }
    </script>
@endsection


