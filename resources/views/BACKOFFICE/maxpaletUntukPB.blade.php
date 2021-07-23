@extends('navbar')
@section('title','PB | ITEM MAXPALET PB')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <form class="form">
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-2 col-form-label text-md-right">Kode Plu</label>
                                        <input type="text" id="i_kodePlu" class="form-control col-sm-2 mx-sm-1">
                                        <label class="col-sm-1 col-form-label text-md-right"></label>
                                        <label class="col-sm-3 mx-sm-5  col-form-label text-md-right">Max Palet(In CTN)</label>
                                        <input type="text" id="i_maxPalet" class="form-control col-sm-2 mx-sm-n3" disabled>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-2 col-form-label text-md-right"></label>
                                        <input type="text" id="i_deskripsiPanjang" class="form-control col-sm-7 mx-sm-1" disabled>
                                        <input type="text" id="i_frac" class="form-control col-sm-2 mx-sm-1" disabled>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <button type="button" id="save" class="btn btn-primary mt-3 mb-3 col-sm-2 offset-sm-7" onclick="saveData()">Save</button>
                                        <button type="button" id="delete" class="btn btn-danger mt-3 mb-3 col-sm-2  ml-3" onclick="deleteData()">Delete</button>
                                    </div>
                                </form>
                            </div>

                            <div class="col-sm-11">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table table-bordered table-hover" id="tableBOMaxpalet">
                                            <thead class="theadDataTables">
                                            <tr class="text-center">
                                                <th>PLU</th>
                                                <th>Deskripsi</th>
                                                <th>Max Palet(In CTN)</th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            ajaxSetup();
            $('#tableBOMaxpalet').dataTable({
                "ajax": {
                    url:'/BackOffice/public/bomaxpalet/loaddata',
                    type:'Post',
                },

                "lengthChange": false,
                "ordering" : false,
                scrollY : 460,
                "columns": [
                    { "data" : "pmp_prdcd", "width": "15%" },
                    { "data" : "prd_deskripsipanjang", "width": "70%" },
                    { "data" : "mpt_maxqty", "width": "15%" }
                ]
            });
            focusToKodeplu()
        });

        function focusToKodeplu(){
            $('#i_kodePlu').focus();
        }

        function loadData() {
            location.reload();
            // ajaxSetup();
            // $.ajax({
            //     url:'/BackOffice/public/bomaxpalet/loaddata',
            //     type:'Post',
            //     data: {},
            //     success: function (result) {
            //         // $('#tableBOMaxpalet').DataTable().clear();
            //         //
            //         // for(i = 1; i< result.length; i++){
            //         //     $('#tableBOMaxpalet').DataTable().row.add(
            //         //         [result[i].pmp_prdcd, result[i].prd_deskripsipanjang, result[i].mpt_maxqty]).draw();
            //         // }
            //     }, error: function (err) {
            //         console.log(err);
            //         clearField();
            //     }
            // })
        }

        function saveData() {
            let kodePlu = $('#i_kodePlu').val();

            ajaxSetup();
            $.ajax({
                url:'/BackOffice/public/bomaxpalet/savedata',
                type:'Post',
                data: {
                    kodePlu:kodePlu
                },
                success: function (result) {
                    if (result.kode === '0'){
                        swal('', result.return, 'warning');
                        clearField();
                    } else {
                        loadData();
                        swal('Success', result.return, 'success');
                        clearField();
                    }
                }, error: function (err) {
                    clearField();
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function deleteData() {
            let kodePlu = $('#i_kodePlu').val();

            swal({
                title: "Hapus PLU?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirm) => {
                if (confirm) {
                    ajaxSetup();
                    $.ajax({
                        url:'/BackOffice/public/bomaxpalet/deletedata',
                        type:'Post',
                        data: {
                            kodePlu:kodePlu
                        },
                        success: function (result) {
                            if (result.kode === '0'){
                                swalWithTime('', result.return, 'warning', 2000);
                                clearField();
                            } else {
                                loadData();
                                swalWithTime('Success', result.return, 'success',2000);
                                clearField();
                            }
                            focusToKodeplu()
                        }, error: function (err) {
                            console.log(err.responseJSON.message.substr(0,100));
                            alertError(err.statusText, err.responseJSON.message);
                            clearField();
                        }
                    })
                } else {
                    clearField();
                }
            });
        }

        $(document).on('keypress', '#save', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                saveData();
            }
        });

        $(document).on('keypress', '#delete', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                deleteData();
            }
        });

        function clearField() {
            $('#i_kodePlu').val('');
            $('#i_maxPalet').val('');
            $('#i_deskripsiPanjang').val('');
            $('#i_frac').val('');
        }

        $(document).on('keypress', '#i_kodePlu', function (e) {
            let kodePlu = $('#i_kodePlu').val();

            if (kodePlu){
                if(e.which === 13) {
                    e.preventDefault();

                    ajaxSetup();
                    $.ajax({
                        url:'/BackOffice/public/bomaxpalet/getmaxpalet',
                        type:'Post',
                        data: {
                            kodePlu:kodePlu
                        },
                        success: function (result) {
                            if (result.kode === '0'){
                                swalWithTime('',result.return, 'warning', 2000)
                                clearField();
                                focusToKodeplu()
                            } else {
                                let data = result.return[0];
                                $('#i_kodePlu').val(data.prd_prdcd);
                                $('#i_maxPalet').val(data.maxpalet);
                                $('#i_deskripsiPanjang').val(data.prd_deskripsipanjang);
                                $('#i_frac').val(data.prd_unit +'/' + data.prd_frac);

                                $('#save').focus();
                            }
                        }, error: function (err) {
                            clearField();
                            console.log(err.responseJSON.message.substr(0,100));
                            alertError(err.statusText, err.responseJSON.message);
                        }
                    })
                }
            }
        });


    </script>

@endsection
