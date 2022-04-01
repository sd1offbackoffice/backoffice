@extends('navbar')
@section('title','PB | PB OTOMATIS')
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
                                    <label class="col-sm-4 col-form-label text-md-right">Jenis PB</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input field jenisPB" type="radio" name="jenisPB" id="reguler" value="R" checked>
                                        <label class="form-check-label" for="reguler">REGULER</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input field jenisPB" type="radio" name="jenisPB" id="gms" value="G">
                                        <label class="form-check-label" for="gms">GMS</label>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label text-md-right">Supplier</label>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" id="i_supp1" class="form-control field field1" field="1">
                                        <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="showModalSupplier('i_supp1')">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" id="i_supp2" class="form-control field field2" field="2">
                                        <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="showModalSupplier('i_supp2')">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label text-md-right">Monitoring Supplier</label>
                                    <select class="form-control col-sm-4 ml-3 field field3" id="i_mtrSup1">
                                        <option value="" disabled selected>...</option>
                                        @foreach($mtrsup as $data)
                                        <option value="{{$data->msu_kodemonitoring}}">{{$data->msu_kodemonitoring}} - {{$data->msu_namamonitoring}}</option>
                                        @endforeach
                                    </select>
{{--                                    <input type="text" id="i_mtrSup1" class="form-control col-sm-1 mx-sm-1 field field3" field="3">--}}
{{--                                    <button class="btn ml-2" type="button" data-toggle="modal" onclick="getMtrSup('i_mtrSup1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
{{--                                    <input type="text" id="i_mtrSup2" class="form-control col-sm-4 ml-3" disabled>--}}
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label text-md-right">Kode Departement</label>

                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" id="i_dept1" class="form-control field field4" field="4">
                                        <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="showModalDepartemen('i_dept1')">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>

                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" id="i_dept2" class="form-control field field5" field="5">
                                        <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="showModalDepartemen('i_dept2')">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label text-md-right">Kode Kategori</label>

                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" id="i_kat1" class="form-control field field6" field="6">
                                        <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getDataModalKategori('i_kat1')">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                    <div class="col-sm-2 buttonInside">
                                        <input type="text" id="i_kat2" class="form-control field field7" field="7">
                                        <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getDataModalKategori('i_kat2')">
                                            <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                        </button>
                                    </div>
                                </div>
                                <button type="button" id="btnAktifkanHrg" class="btn btn-primary pl-4 pr-4 float-right field field8" onclick="proses()" field="8">PROSES</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="http://172.20.28.17/BackOffice/public/file_procedure/sp_create_pb_auto_by_sup_web.txt" target="blank">Procedure</a>

<p class="text-hide" id="idField"></p>

{{-- Modal Supplier --}}
<div class="modal fade" id="modalSupplierHelp" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Master Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm" id="tableModalSupplier">
                                <thead class="theadDataTables">
                                <tr>
                                    <th>KODE SUPPLIER</th>
                                    <th>NAMA SUPPLIER</th>
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

{{-- Modal Departemen --}}
<div class="modal fade" id="modalDepartemenHelp" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Master Departemen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm" id="tableModalDepartemen">
                                <thead class="theadDataTables">
                                <tr>
                                    <th>KODE DEPARTEMEN</th>
                                    <th>NAMA DEPARTEMEN</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyModalHelp">
                                    @foreach($departemen as $data)
                                        <tr class="row_lov row_lov_departemen">
                                            <td>{{$data->dep_kodedepartement}}</td>
                                            <td>{{$data->dep_namadepartement}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
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

{{-- Modal Kategori --}}
<div class="modal fade" id="modalKategoriHelp" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Master Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm" id="tableModalKategori">
                                <thead class="theadDataTables">
                                <tr>
                                    <th>DEPT</th>
                                    <th>KODE</th>
                                    <th>KATEGORI</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyModalHelp">
                                </tbody>
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
        let allData;
        let tableModalKategori = $('#tableModalKategori').DataTable();

        $(document).ready(function () {
           getDataModalSupplier('');
            $('#tableModalDepartemen').DataTable();
        });

        function getDataModalSupplier(value){
            let tableModal =  $('#tableModalSupplier').DataTable({
                "ajax": {
                    'url' : '{{url()->current() }}/getdatamodalsupplier',
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
                    $(row).addClass('row_lov row_lov_supplier');
                },
                "order": []
            });

            $('#tableModalSupplier_filter input').off().on('keypress', function (e){
                if (e.which == 13) {
                    let val = $(this).val().toUpperCase();

                    tableModal.destroy();
                    getDataModalSupplier(val);
                }
            })
        }

        function getDataModalKategori(field){
            let dept1   = $('#i_dept1').val();
            let dept2   = $('#i_dept2').val();

            if(dept1.length == 0 || dept2.length == 0){
                swal('Error', 'Input Departemen', 'error');
                return false;
            } else {
                tableModalKategori.destroy();

                tableModalKategori = $('#tableModalKategori').DataTable({
                    "ajax": {
                        'url' : '{{url()->current() }}/getkategori',
                        "data" : {
                            'dept1' : dept1,
                            'dept2' : dept2,
                        },
                    },
                    "columns": [
                        {data: 'kat_kodedepartement', name: 'kat_kodedepartement'},
                        {data: 'kat_kodekategori', name: 'kat_kodekategori'},
                        {data: 'kat_namakategori', name: 'kat_namakategori'},
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).addClass('row_lov row_lov_kategori');
                    },
                    "order": []
                });

                $('#idField').text(field);
                $('#modalKategoriHelp').modal('show')

                // ajaxSetup();
                // $.ajax({
                //     url: '/BackOffice/public/bopbotomatis/getkategori',
                //     type: 'post',
                //     data: {
                //         dept1: dept1,
                //         dept2: dept2
                //     },
                //     success: function (result) {
                //         $('#modalThName2').show();
                //         $('#modalThName3').show();
                //         $('#modalThName1').text('DEPT');
                //         $('#modalThName2').text('KODE');
                //         $('#modalThName3').text('KATEGORI');
                //         $('#idModal').text('K');
                //         $('#idField').text(field);
                //         $('#searchModal').val('');
                //
                //         $('.modalRow').remove();
                //         for (i = 0; i< result.length; i++){
                //             $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].kat_kodekategori+"') class='modalRow'><td>"+ result[i].kat_kodedepartement +"</td><td>"+ result[i].kat_kodekategori +"</td><td>"+ result[i].kat_namakategori +"</td></tr>")
                //         }
                //
                //         $('#modalHelp').modal('show');
                //     }, error: function () {
                //         alert('error');
                //     }
                // })
            }
        }

        $(document).on('click', '.row_lov_supplier', function () {
            var currentButton = $(this);
            let supplier = currentButton.children().first().text();
            let field = $('#idField').text();

            chooseRow(field,supplier);
        });

        $(document).on('click', '.row_lov_departemen', function () {
            var currentButton = $(this);
            let departemen = currentButton.children().first().text();

            chooseRow($('#idField').text(),departemen);
        });

        $(document).on('click', '.row_lov_kategori', function () {
            var currentButton = $(this);
            let kategori = currentButton.children().first().next().text();

            chooseRow($('#idField').text(),kategori);
        });

        $(document).on('keypress', '.field', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                var field   = $(this).attr('field');
                var target  = 'field'+(parseInt(field)+1);
                $('.'+target).focus();
            }
        });

        function showModalSupplier(field) {
            $('#idField').text(field);
            $('#modalSupplierHelp').modal('show');
        }

        function showModalDepartemen(field) {
            $('#idField').text(field);
            $('#modalDepartemenHelp').modal('show')
        }

        function proses() {
            let tipe    = $('.jenisPB');
            let tipePB  = '';

            for (let i = 0; i < tipe.length; i++) {
                if (tipe[i].checked) {
                    tipePB = tipe[i].value;
                    break;
                }
            }

            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/prosesdata',
                type: 'post',
                data: {
                    tipePB  : tipePB,
                    sup1    :  $('#i_supp1').val(),
                    sup2    :  $('#i_supp2').val(),
                    mtrSup  : $('#i_mtrSup1').val(),
                    dept1   :  $('#i_dept1').val(),
                    dept2   :  $('#i_dept2').val(),
                    kat1    :  $('#i_kat1').val(),
                    kat2    :  $('#i_kat2').val(),
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    console.log(result);
                    $('#modal-loader').modal('hide');
                    if(result.kode === 1){
                        swal('Success', result.msg, 'success');
                    } else if (result.kode === 2){
                        swal('Success', result.msg, 'success');
                        let param1 = result.param[0];
                        let param2 = result.param[1];
                        let param3 = result.param[2];
                        let param4 = result.param[3];
                        let param5 = result.param[4];

                        window.open(`{{ url()->current() }}/cetakreport?kodeigr=${param1}&date1=${param2}&date2=${param3}&sup1=${param4}&sup2=${param5}`)
                        {{--window.open('{{ url()->current() }}/cetakreport/'+param1 +'/'+param2 +'/'+param3 +'/'+param4 +'/'+param5 +'/')--}}
                    } else {
                        swal('Failed', result.msg, 'error');
                    }
                    clearField()
                }, error: function (err) {
                    $('#modal-loader').modal('hide');
                    console.log(err.responseJSON.message.substr(0,100));
                    alertError(err.statusText, err.responseJSON.message);
                }
            })
        }

        function chooseRow(field,data) {
            $('#'+ field+'').val(data);
            $('#modalSupplierHelp').modal('hide');
            $('#modalDepartemenHelp').modal('hide');
            $('#modalKategoriHelp').modal('hide');
        }



        function clearField() {
            $('#i_supp1').val('');
            $('#i_supp2').val('');
            $('#i_mtrSup1').val('');
            $('#i_mtrSup2').val('');
            $('#i_dept1').val('');
            $('#i_dept2').val('');
            $('#i_kat1').val('');
            $('#i_kat2').val('');
        }
    </script>
@endsection
