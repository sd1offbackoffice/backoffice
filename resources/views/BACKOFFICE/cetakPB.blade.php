@extends('navbar')
@section('title','PB | CETAK PB ')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card border-dark">
                    <div class="card-body cardForm">
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <form class="form" name="form" id="testtable">
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
                                        <label class="col-sm-4 col-form-label text-md-right">Tanggal</label>
                                        <input type="date" id="i_tgl1" class="form-control col-sm-2 mx-sm-3 field field1" field="1" name="fform">
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <input type="date" id="i_tgl2" class="form-control col-sm-2 mx-sm-3 field field2" field="2" name="fform">
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">No Dokumen</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="i_doc1" class="form-control field field3" field="3">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getDocument('i_doc1')">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="i_doc2" class="form-control field field4" field="4">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getDocument('i_doc2')">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>


{{--                                        <input type="text" id="i_doc1" class="form-control col-sm-2 mx-sm-1 field field3" field="3" name="fform">--}}
{{--                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getDocument('i_doc1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
{{--                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>--}}
{{--                                        <input type="text" id="i_doc2" class="form-control col-sm-2 mx-sm-1 field field4" field="4" name="fform">--}}
{{--                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getDocument('i_doc2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Divisi</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="i_div1" class="form-control field field5" field="5">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getDivisi('i_div1')">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="i_div2" class="form-control field field6" field="6">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getDivisi('i_div2')">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>

{{--                                        <input type="text" id="i_div1" class="form-control col-sm-1 mx-sm-1 field field5" field="5">--}}
{{--                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getDivisi('i_div1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
{{--                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>--}}
{{--                                        <input type="text" id="i_div2" class="form-control col-sm-1 mx-sm-1 field field6" field="6">--}}
{{--                                        <button class="btn ml-2" type="button" data-toggle="modal"onclick="getDivisi('i_div2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Departement</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="i_dept1" class="form-control field field7" field="7">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getDepartemen('i_dept1')">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="i_dept2" class="form-control field field8" field="8">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getDepartemen('i_dept2')">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>

{{--                                        <input type="text" id="i_dept1" class="form-control col-sm-1 mx-sm-1 field field7" field="7">--}}
{{--                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getDepartemen('i_dept1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
{{--                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>--}}
{{--                                        <input type="text" id="i_dept2" class="form-control col-sm-1 mx-sm-1 field field8" field="8">--}}
{{--                                        <button class="btn ml-2" type="button" data-toggle="modal"onclick="getDepartemen('i_dept2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Kategori</label>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="i_kat1" class="form-control field field9" field="9">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getKategori('i_kat1')">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <div class="col-sm-2 buttonInside">
                                            <input type="text" id="i_kat2" class="form-control field field10" field="10">
                                            <button class="btn btn-lov p-0" type="button" data-toggle="modal" onclick="getKategori('i_kat2')">
                                                <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                            </button>
                                        </div>

{{--                                        <input type="text" id="i_kat1" class="form-control col-sm-1 mx-sm-1 field field9" field="9">--}}
{{--                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getKategori('i_kat1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
{{--                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>--}}
{{--                                        <input type="text" id="i_kat2" class="form-control col-sm-1 mx-sm-1 field field10" field="10">--}}
{{--                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getKategori('i_kat2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>--}}
                                    </div>
                                    <button type="button" id="btnAktifkanHrg" class="btn btn-primary offset-sm-7 col-sm-2 field field11" onclick="prosesCetak()" field="11">Cetak PB</button>
                                    <button type="button" id="btnAktifkanHrg" class="btn btn-danger col-sm-2 field field12" onclick="clearField()" field="12">Batal</button>
                                    {{--                                    <button type="button" id="btnAktifkanHrg" class="btn btn-danger pl-4 pr-4 mr-3 float-right field field12" onclick="clearField()" field="12">Batal</button>--}}
{{--                                    <button type="button" id="btnAktifkanHrg" class="btn btn-primary pl-4 pr-4 mr-3 float-right field field11" onclick="prosesCetak()" field="11">Cetak PB</button>--}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <p class="text-hide" id="idField"></p>

    <h1>222105023</h1>

    <!-- Modal -->
    <div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="m_kodecabangHelp" aria-hidden="true">
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
                                <div class="tableFixedHeader">
                                    <table class="table table-sm" id="tableModal">
                                        <thead>
                                        <tr>
                                            <th id="modalThName1"></th>
                                            <th id="modalThName2"></th>
                                            <th id="modalThName3"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp"></tbody>
                                    </table>
                                    <p class="text-hide" id="idModal"></p>
                                    <p class="text-hide" id="idField"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Document -->
    <div class="modal fade" id="modalHelpDocument" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="tableModalHelpDocument">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Tanggal</th>
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

    <!-- Modal Divisi -->
    <div class="modal fade" id="modalHelpDivisi" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Master Divisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-sm" id="tableModalHelpDivisi">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>KODE</th>
                                        <th>DIVISI</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($divisi as $data)
                                            <tr class="row_lov row_lov_divisi">
                                                <td>{{$data->div_kodedivisi}}</td>
                                                <td>{{$data->div_namadivisi}}</td>
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

    <!-- Modal Departemen -->
    <div class="modal fade" id="modalHelpDepartemen" tabindex="-1" role="dialog"  aria-hidden="true">
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
                                <table class="table table-sm" id="tableModalHelpDepartemen">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>KODE</th>
                                        <th>DEPARTEMEN</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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

    <!-- Modal Kategori -->
    <div class="modal fade" id="modalHelpKategori" tabindex="-1" role="dialog"  aria-hidden="true">
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
                                <table class="table table-sm" id="tableModalHelpKategori">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>DEPARTEMEN</th>
                                        <th>KODE</th>
                                        <th>KATEGORI</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
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


    <style>
        input{
            text-transform: uppercase;
        }
    </style>

    <script>
        let tableModalDocument   =  $('#tableModalHelpDocument').DataTable();
        let tableModalDepartemen =  $('#tableModalHelpDepartemen').DataTable();
        let tableModalKategori   =  $('#tableModalHelpKategori').DataTable();

        $(document).ready(function (){
            $('#tableModalHelpDivisi').DataTable();
        })

        $(document).on('keypress', '.field', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                var field   = $(this).attr('field');
                var target  = 'field'+(parseInt(field)+1);
                $('.'+target).focus();
            }
        });

        function chooseRow(field,data) {
            $('#'+ field+'').val(data);
            $('#modalHelpDocument').modal('hide');
            $('#modalHelpDivisi').modal('hide');
            $('#modalHelpDepartemen').modal('hide');
            $('#modalHelpKategori').modal('hide');
        }

        function getDocument(field) {
            let tgl1   = $('#i_tgl1').val();
            let tgl2   = $('#i_tgl2').val();

            if(tgl1.length === 0 || tgl2.length === 0){
                swal('Error', 'Input Tanggal', 'error');
                return false;
            } else {
                tableModalDocument.destroy();

                tableModalDocument = $('#tableModalHelpDocument').DataTable({
                    "ajax": {
                        'url' : '{{ url('bocetakpb/getdocument') }}',
                        "data" : {
                            'tgl1': tgl1,
                            'tgl2': tgl2
                        },
                    },
                    "columns": [
                        {data: 'pbh_nopb', name: 'pbh_nopb'},
                        {data: 'pbh_tglpb', name: 'pbh_tglpb'},
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).addClass('row_lov row_lov_document');
                    },
                    columnDefs : [
                        { targets : [1],
                            render : function (data, type, row) {
                                return formatDate(data)
                            }
                        }
                    ],
                    "order": []
                });

                $('#idField').text(field);
                $('#modalHelpDocument').modal('show')
            }
        }

        $(document).on('click', '.row_lov_document', function () {
            var currentButton = $(this);
            let document = currentButton.children().first().text();
            let field = $('#idField').text();

            chooseRow(field,document);
        });

        function getDivisi(field) {
            $('#idField').text(field);
            $('#modalHelpDivisi').modal('show');
        }

        $(document).on('click', '.row_lov_divisi', function () {
            var currentButton = $(this);
            let divisi = currentButton.children().first().text();
            let field = $('#idField').text();

            chooseRow(field,divisi);
        });

        function getDepartemen(field) {
            let div1   = $('#i_div1').val();
            let div2   = $('#i_div2').val();

            if(div1.length === 0 || div2.length === 0){
                swal('Error', 'Input Divisi', 'error');
                return false;
            } else {
                tableModalDepartemen.destroy();

                tableModalDepartemen = $('#tableModalHelpDepartemen').DataTable({
                    "ajax": {
                        'url' : '{{ url('bocetakpb/getdepartement') }}',
                        "data" : {
                            'div1': div1,
                            'div2': div2
                        },
                    },
                    "columns": [
                        {data: 'dep_kodedepartement', name: 'dep_kodedepartement'},
                        {data: 'dep_namadepartement', name: 'dep_namadepartement'},
                    ],
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "createdRow": function (row, data, dataIndex) {
                        $(row).addClass('row_lov row_lov_departemen');
                    },
                    // columnDefs : [
                    //     { targets : [1],
                    //         render : function (data, type, row) {
                    //             return formatDate(data)
                    //         }
                    //     }
                    // ],
                    "order": []
                });

                $('#idField').text(field);
                $('#modalHelpDepartemen').modal('show')
            }
        }

        $(document).on('click', '.row_lov_departemen', function () {
            var currentButton = $(this);
            let departemen = currentButton.children().first().text();
            let field = $('#idField').text();

            chooseRow(field,departemen);
        });

        function getKategori(field) {
            let dept1   = $('#i_dept1').val();
            let dept2   = $('#i_dept2').val();

            if(dept1.length === 0 || dept2.length === 0){
                swal('Error', 'Input Departemen', 'error');
                return false;
            } else {
                tableModalKategori.destroy();

                tableModalKategori = $('#tableModalHelpKategori').DataTable({
                    "ajax": {
                        'url' : '{{ url('bocetakpb/getkategori') }}',
                        "data" : {
                            'dept1': dept1,
                            'dept2': dept2
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
                    // columnDefs : [
                    //     { targets : [1],
                    //         render : function (data, type, row) {
                    //             return formatDate(data)
                    //         }
                    //     }
                    // ],
                    "order": []
                });

                $('#idField').text(field);
                $('#modalHelpKategori').modal('show')

            }
        }

        $(document).on('click', '.row_lov_kategori', function () {
            var currentButton = $(this);
            let kategori = currentButton.children().first().next().text();
            let field = $('#idField').text();

            // alert(kategori)
            chooseRow(field,kategori);
        });

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let idModal = $('#idModal').text();
                let idField = $('#idField').text();
                let input   = $('#searchModal').val();

                if (idModal === 'DC'){
                    searchDocument(input.toUpperCase(),idField);
                } else if(idModal === 'DV'){
                    searchDivisi(input.toUpperCase(),idField);
                } else if(idModal === 'D'){
                    searchDepartemen(input.toUpperCase(),idField);
                } else if(idModal === 'K'){
                    searchKategori(input.toUpperCase(),idField);
                }
            }
        });

        function searchDocument(input, field) {
            $.ajax({
                url: '/BackOffice/public/bocetakpb/searchdocument',
                type: 'post',
                data: {
                    search  : input,
                    tgl1    : $('#i_tgl1').val(),
                    tgl2    : $('#i_tgl2').val()
                },
                success: function (result) {
                    console.log(result)
                    $('#modalThName2').show();
                    $('#modalThName3').hide();
                    $('#modalThName1').text('KODE');
                    $('#modalThName2').text('KETERANGAN');
                    $('#idModal').text('DC');
                    $('#idField').text(field);
                    $('#searchModal').val('');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].pbh_nopb+"') class='modalRow'><td>"+ result[i].pbh_nopb +"</td><td>"+ result[i].pbh_keteranganpb +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function searchDivisi(input, field) {
            $.ajax({
                url: '/BackOffice/public/bocetakpb/searchdivisi',
                type: 'post',
                data: {
                    search : input
                },
                success: function (result) {
                    $('#modalThName3').hide();
                    $('#modalThName2').show();
                    $('#modalThName1').text('KODE');
                    $('#modalThName2').text('DIVISI');
                    $('#idModal').text('DV');
                    $('#idField').text(field);
                    $('#searchModal').val('');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].div_kodedivisi+"') class='modalRow'><td>"+ result[i].div_kodedivisi +"</td><td>"+ result[i].div_namadivisi +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function searchDepartemen(input, field) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bocetakpb/searchdepartement',
                type: 'post',
                data: {
                    div1: $('#i_div1').val(),
                    div2: $('#i_div2').val(),
                    search: input
                },
                success: function (result) {
                    $('#modalThName2').show();
                    $('#modalThName3').hide();
                    $('#modalThName2').show();
                    $('#modalThName1').text('KODE');
                    $('#modalThName2').text('DEPARTEMEN');
                    $('#idModal').text('D');
                    $('#idField').text(field);
                    $('#searchModal').val('');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].dep_kodedepartement+"') class='modalRow'><td>"+ result[i].dep_kodedepartement +"</td><td>"+ result[i].dep_namadepartement +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function searchKategori(input, field) {
            let dept1   = $('#i_dept1').val();
            let dept2   = $('#i_dept2').val();

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bocetakpb/searchkategori',
                type: 'post',
                data: {
                    dept1: dept1,
                    dept2: dept2,
                    search: input
                },
                success: function (result) {
                    $('#modalThName2').show();
                    $('#modalThName3').show();
                    $('#modalThName1').text('DEPT');
                    $('#modalThName2').text('KODE');
                    $('#modalThName3').text('KATEGORI');
                    $('#idModal').text('K');
                    $('#searchModal').val('');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].kat_kodekategori+"') class='modalRow'><td>"+ result[i].kat_kodedepartement +"</td><td>"+ result[i].kat_kodekategori +"</td><td>"+ result[i].kat_namakategori +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function prosesCetak() {
            let tgl1 = $('#i_tgl1').val();
            let tgl2 = $('#i_tgl2').val();
            let doc1 = $('#i_doc1').val();
            let doc2 = $('#i_doc2').val();
            let div1 = $('#i_div1').val();
            let div2 = $('#i_div2').val();
            let dept1 = $('#i_dept1').val();
            let dept2 = $('#i_dept2').val();
            let kat1 = $('#i_kat1').val();
            let kat2 = $('#i_kat2').val();

            let tipe = $('.jenisPB');
            let tipePB = '';

            for (let i = 0; i < tipe.length; i++) {
                if (tipe[i].checked) {
                    tipePB = tipe[i].value;
                    break;
                }
            }

            if (!tgl1 || !tgl2) {
                swal("Tanggal Harus Terisi !!", '', 'warning')
            } else if ( (doc1 && !doc2) || (!doc1 && doc2) ) {
                swal("No Dokumen Harus Terisi Semua !!", '', 'warning')
            } else if ((!div1 && div2) || (div1 && !div2)) {
                swal("Kode Divisi Harus Terisi Semua!!", '', 'warning')
            } else if ((!dept1 && dept2) || (dept1 && !dept2)) {
                swal("Kode Departement Harus Terisi Semua!!", '', 'warning')
            } else if ((!kat1 && kat2) || (kat1 && !kat2)) {
                swal("Kode Kategori Harus Terisi Semua!!", '', 'warning')
            } else {
                window.open('/BackOffice/public/bocetakpb/cetakreport/'+tgl1 +'/'+tgl2+'/'+doc1+'/'+doc2+'/'+div1+'/'+div2+'/'+dept1+'/'+dept2+'/'+kat1+'/'+kat2+'/'+tipePB+'/')
                clearField()
            }
        }

        function clearField() {
            $('#i_tgl1').val('');
            $('#i_tgl2').val('');
            $('#i_doc1').val('');
            $('#i_doc2').val('');
            $('#i_div1').val('');
            $('#i_div2').val('');
            $('#i_dept1').val('');
            $('#i_dept2').val('');
            $('#i_kat1').val('');
            $('#i_kat2').val('');
        }


    </script>

@endsection
