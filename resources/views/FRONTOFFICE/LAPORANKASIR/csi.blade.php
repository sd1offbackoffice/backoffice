@extends('navbar')
@section('title','Laporan Cash Back / Supplier / Item')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card border-dark">
                    <legend class="w-auto ml-5">Laporan Cash Back / Supplier / Item</legend>
                    <div class="card-body shadow-lg cardForm">
                            <br>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Tanggal</label>
                                <input class="col-sm-3 text-center form-control" type="text" id="daterangepicker">
                                <label class="col-sm-2 text-left">DD / MM / YYYY</label>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Supplier</label>
                                <div class="col-sm-3 buttonInside">
                                    <input type="text" class="form-control" id="nmr1" onchange="chooseNmr(this)">
                                    <button id="1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                            data-target="#supplierModal" onclick="getId(this)">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <span>S/D</span>
                                <div class="col-sm-3 buttonInside">
                                    <input type="text" class="form-control" id="nmr2" onchange="chooseNmr(this)">
                                    <button id="2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                            data-target="#supplierModal" onclick="getId(this)">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Member</label>
                                <input class="col-sm-1 form-control" type="text" id="member" onkeypress="return isY(event)" maxlength="1">
                                <label class="col-sm-4 text-left font-weight-bold">[R]eguler &nbsp;&nbsp;&nbsp;[K]husus</label>
                            </div>
                            <br>
                            <div class="d-flex justify-content-around">
                                <label class="font-weight-normal">Kosong : <span class="font-weight-bold">S e m u a</span></label>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-success col-sm-3" type="button" onclick="print()">C E T A K</button>
                            </div>

                            <br>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    {{--Modal--}}
    <div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalTemplate">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Supplier</th>
                                        <th>Nama Supplier</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalHelp"></tbody>
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
    <script src={{asset('/js/sweetalert2.js')}}></script>
    <script>
        let id;
        function getId(val){
            id = val.id;
        }

        $(document).ready(function () {
            getModalData('');
        });

        function getModalData(value){
            let tableModal = $('#tableModalTemplate').DataTable({
                "ajax": {
                    'url' : '{{ url('frontoffice/laporankasir/csi/getmodal') }}',
                    "data" : {
                        'value' : value
                    },
                },
                "columns": [
                    {data: 'sup_kodesupplier', name: 'sup_kodesupplier'},
                    {data: 'sup_namasupplier', name: 'sup_namasupplier'},
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
                "order": []
            });

            $('#tableModalTemplate_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getModalData(val);
                }
            })
        }

        $(document).on('click', '.modalRow', function () {
            var currentButton = $(this);
            let kodesupplier = currentButton.children().first().text();
            let namasupplier = currentButton.children().first().next().text();

            $('#nmr'+id).val(kodesupplier);
            $('#supplierModal').modal('hide');
        });

        function isY(evt){
            $('#member').keyup(function(){
                $(this).val($(this).val().toUpperCase());
            });
            let charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode == 114) // r kecil
                return 82; // r besar

            if (charCode == 107) // k kecil
                return 75; //k besar

            if (charCode == 82 || charCode == 75)
                return true;
            return false;
        }

        $('#daterangepicker').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            }
        });

        function chooseNmr(val){
            let place = val.id;
            let value = val.value;
            $('#modal-loader').modal('show');
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/frontoffice/laporankasir/csi/getnmr',
                type: 'post',
                data: {
                    val:value
                },
                success: function (result) {
                    $('#modal-loader').modal('hide');
                    if(result.sup_kodesupplier){
                        //do nothing
                    }else{
                        swal.fire('Input Salah!','','warning');
                        $('#'+place).val('');
                    }
                }, error: function () {
                    $('#modal-loader').modal('hide');
                    alert('error');
                }
            })
        }

        function print() {
            let date = $('#daterangepicker').val();
            if(date == null || date == ""){
                swal.fire('Input masih kosong','','warning');
                return false;
            }
            let dateA = date.substr(0,10);
            let dateB = date.substr(13,10);
            dateA = dateA.split('/').join('-');
            dateB = dateB.split('/').join('-');
            let sup1 = $('#nmr1').val();
            let sup2 = $('#nmr2').val();
            if(sup1 == '' && sup2 != '' || sup1 != '' && sup2 == ''){
                swal.fire('Kode Supplier Harus Terisi Semua Atau Tidak Terisi Sama Sekali ','','warning');
                return false;
            }else if(sup1 > sup2){
                swal.fire('Kode Supplier 1 Harus Lebih Kecil dari Kode Supplier 2','','warning');
                return false;
            }
            if(sup1 == ''){
                sup1 = "nodata";
            }
            if(sup2 == ''){
                sup2 = "nodata";
            }
            swal.fire({
                title: 'Cetak ?',
                showDenyButton: true,
                confirmButtonText: `Cash Back per Supplier`,
                denyButtonText: `Refund Cash Back per Supplier`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    if($('#member').val() == 'R'){
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/laporankasir/csi/checkdatar',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'S',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('/BackOffice/public/frontoffice/laporankasir/csi/printdocr/'+dateA+'/'+dateB+'/S/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }else if($('#member').val() == 'K'){
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/laporankasir/csi/checkdatak',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'S',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('/BackOffice/public/frontoffice/laporankasir/csi/printdock/'+dateA+'/'+dateB+'/S/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }else{
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/laporankasir/csi/checkdata',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'S',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('/BackOffice/public/frontoffice/laporankasir/csi/printdoc/'+dateA+'/'+dateB+'/S/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }
                } else if (result.isDenied) {
                    if($('#member').val() == 'R'){
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/laporankasir/csi/checkdatar',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'R',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('/BackOffice/public/frontoffice/laporankasir/csi/printdocr/'+dateA+'/'+dateB+'/R/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }else if($('#member').val() == 'K'){
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/laporankasir/csi/checkdatak',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'R',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('/BackOffice/public/frontoffice/laporankasir/csi/printdock/'+dateA+'/'+dateB+'/R/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }else{
                        ajaxSetup();
                        $.ajax({
                            url: '/BackOffice/public/frontoffice/laporankasir/csi/checkdata',
                            type: 'post',
                            data: {
                                dateA:dateA,
                                dateB:dateB,
                                p_tipe:'R',
                                sup1:sup1,
                                sup2:sup2
                            },
                            beforeSend: function () {
                                $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                            },
                            success: function (w) {
                                if(w.kode == '1'){
                                    window.open('/BackOffice/public/frontoffice/laporankasir/csi/printdoc/'+dateA+'/'+dateB+'/R/'+sup1+'/'+sup2,'_blank');
                                }
                                else if (w.kode == '0'){
                                    swal.fire('', "tidak ada data", 'warning');
                                }
                                $('#modal-loader').modal('hide');
                            }, error: function (e) {
                                console.log(e);
                                alert('error');
                            }
                        })
                    }
                }
            })
        }
    </script>
@endsection
