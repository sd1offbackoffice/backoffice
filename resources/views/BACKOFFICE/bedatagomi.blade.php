@extends('navbar')
@section('title','BEDA TAG OMI')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <fieldset class="card border-dark">
                    
                    
                    <div id="menu" class="subMenu card-body shadow-lg cardForm">
                        
                        <fieldset class="card border-dark">
                           <legend class="w-auto ml-5">Laporan Perbedaan Tag IGR dan OMI</legend>
                            <br>
                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Per Tanggal</label>
                                <div class="col-sm-2 buttonInside">  
                                    <input disabled id="menu1daterangepicker" class="form-control" type="text">
                                </div>   
                            </div>

                            <br>

                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Kode Tag IGR</label>
                                <div class="col-sm-2 buttonInside">
                                    <input id="kodetagigr" class="form-control" type="text" onchange="validateTag()">
                                </div>   
                            </div>
                            
                            <br>
                            
                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Mulai Divisi</label>
                                <div class="col-sm-2 buttonInside">
                                    <input id="menu1Div1Input" class="form-control" type="text">
                                    <button id="menu1BtnDiv1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                            data-target="#divModal">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                    <input id="menu1Div1Desk" class="form-control" type="text" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Sampai Divisi</label>
                                <div class="col-sm-2 buttonInside">
                                    <input id="menu1Div2Input" class="form-control" type="text">
                                    <button id="menu1BtnDiv2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                            data-target="#divModal" hidden>
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                    <input id="menu1Div2Desk" class="form-control" type="text" disabled>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Mulai Dept</label>
                                <div class="col-sm-2 buttonInside">
                                    <input id="menu1Dep1Input" class="form-control" type="text">
                                    <button id="menu1BtnDep1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                            data-target="#depModal" hidden>
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                    <input id="menu1Dep1Desk" class="form-control" type="text" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Sampai Dept</label>
                                <div class="col-sm-2 buttonInside">
                                    <input id="menu1Dep2Input" class="form-control" type="text">
                                    <button id="menu1BtnDep2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                            data-target="#depModal" hidden>
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                    <input id="menu1Dep2Desk" class="form-control" type="text" disabled>
                                </div>
                            </div>

                            <br>

                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Mulai Kat</label>
                                <div class="col-sm-2 buttonInside">
                                    <input id="menu1Kat1Input" class="form-control" type="text">
                                    <button id="menu1BtnKat1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                            data-target="#katModal" hidden>
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                    <input id="menu1Kat1Desk" class="form-control" type="text" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 text-right col-form-label">Sampai Kat</label>
                                <div class="col-sm-2 buttonInside">
                                    <input id="menu1Kat2Input" class="form-control" type="text">
                                    <button id="menu1BtnKat2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                                            data-target="#katModal" hidden>
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <div class="col-sm-4">
                                    <input id="menu1Kat2Desk" class="form-control" type="text" disabled>
                                </div>
                            </div>
                            <br>
                        </fieldset>
                        
                    </div>
                    
                    <br>
                    <div class="d-flex justify-content-end">
                        <button id="Cetak" class="btn btn-success col-sm-3" type="button" onclick="cetak()">CETAK LAPORAN</button>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    {{--Modal DIV--}}
    <div class="modal fade" id="divModal" tabindex="-1" role="dialog" aria-labelledby="divModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Divisi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDiv">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Divisi</th>
                                        <th>Kode Divisi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalDiv"></tbody>
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

    {{--Modal Departemen--}}
    <div class="modal fade" id="depModal" tabindex="-1" role="dialog" aria-labelledby="depModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Departemen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="minDep" name="minDep">
                    <input type="text" id="maxDep" name="maxDep">
                </div>
                <div hidden>
                    <input type="text" id="filtererDep" name="filtererDep">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalDep">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Departemen</th>
                                        <th>Kode Departemen</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalDep"></tbody>
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

    {{--Modal Kategori--}}
    <div class="modal fade" id="katModal" tabindex="-1" role="dialog" aria-labelledby="katModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="limitKat" name="limitKat">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalKat">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Kategori</th>
                                        <th>Kode Kategori</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalKat"></tbody>
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

    {{--Modal Supplier--}}
    <div class="modal fade" id="supModal" tabindex="-1" role="dialog" aria-labelledby="supModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="minSup" name="minSup">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalSup">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Supplier</th>
                                        <th>Kode Supplier</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalSup"></tbody>
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

    {{--Modal Member--}}
    <div class="modal fade" id="memModal" tabindex="-1" role="dialog" aria-labelledby="memModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="minMem" name="minMem">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalMem">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Member</th>
                                        <th>Kode Member</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalMem"></tbody>
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

    {{--Modal Member With Date--}}
    <div class="modal fade" id="memDateModal" tabindex="-1" role="dialog" aria-labelledby="memDateModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalMemDate">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Member</th>
                                        <th>Kode Member</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalMemDate"></tbody>
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

    {{--Modal Outlet--}}
    <div class="modal fade" id="outletModal" tabindex="-1" role="dialog" aria-labelledby="outletModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalOutlet">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Outlet</th>
                                        <th>Kode Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalOutlet"></tbody>
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

    {{--Modal Sub-Outlet--}}
    <div class="modal fade" id="subOutletModal" tabindex="-1" role="dialog" aria-labelledby="subOutletModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Sub-Outlet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="outletFilterer" name="outletFilterer">
                    <input type="text" id="minSubOutlet" name="minSubOutlet">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalSubOutlet">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Nama Sub-Outlet</th>
                                        <th>Kode Sub-Outlet</th>
                                        <th>Kode Outlet</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalSubOutlet"></tbody>
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

    {{--Modal PLU--}}
    <div class="modal fade" id="pluModal" tabindex="-1" role="dialog" aria-labelledby="pluModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalPlu">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi Barang</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalPlu"></tbody>
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

    {{--Modal PLU CUSTOM--}}
    <div class="modal fade" id="pluCustomModal" tabindex="-1" role="dialog" aria-labelledby="pluCustomModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalPluCustom">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Deskripsi Barang</th>
                                        <th>PLU</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalPluCustom"></tbody>
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

    {{--Modal Rak--}}
    <div class="modal fade" id="rakModal" tabindex="-1" role="dialog" aria-labelledby="rakModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Rak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{--UNTUK FILTER DATA--}}
                <div hidden>
                    <input type="text" id="rakColumn" name="rakColumn">
                    <input type="text" id="theRak" name="theRak">
                    <input type="text" id="theSubRak" name="theSubRak">
                    <input type="text" id="theTipeRak" name="theTipeRak">
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <table class="table table-striped table-bordered" id="tableModalRak">
                                    <thead class="theadDataTables">
                                    <tr>
                                        <th>Kode Rak</th>
                                        <th>Kode Sub Rak</th>
                                        <th>Tipe Rak</th>
                                        <th>Shelving</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyModalRak"></tbody>
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
        let cursor = '';
        let tableDivisi;
        let tableDepartemen;
        let tableKategori;
        let tableSupplier;

        $('#kodetagigr').on('change',function(){
            $kodetagigr = $('#kodetagigr').val();
            validateTag();
            console.log('ada validate');

        });

        $('#menu1daterangepicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD/MM/YYYY',
            }
        });

        //Fungsi isi berurutan
        $('#menu1Div2Input').on('focus',function(){
            if($('#menu1Div1Input').val() == ''){
                $('#menu1Div1Input').focus();
            }
        });
        $('#menu1Dep1Input, #menu1BtnDep1').on('focus',function(){

            //limit departemen dalam divisi
            $('#minDep').val($('#menu1Div1Input').val());
            $('#maxDep').val($('#menu1Div1Input').val()).change();

            if($('#menu1Div1Input').val() == ''){
                $('#menu1Div1Input').focus();
            }
            else if($('#menu1Div2Input').val() == ''){
                $('#menu1Div2Input').focus();
            }
        });
        $('#menu1Dep2Input, #menu1BtnDep2').on('focus',function(){

            //limit departemen dalam divisi
            $('#minDep').val($('#menu1Div2Input').val());
            $('#maxDep').val($('#menu1Div2Input').val()).change();
            if($('#menu1Div1Input').val() == ''){
                $('#menu1Div1Input').focus();
            }
            else if($('#menu1Div2Input').val() == ''){
                $('#menu1Div2Input').focus();
            }
            else if($('#menu1Dep1Input').val() == ''){
                $('#menu1Dep1Input').focus();
            }
        });
        $('#menu1Kat1Input, #menu1BtnKat1').on('focus',function(){
            $('#limitKat').val($('#menu1Dep1Input').val()).change();

            if($('#menu1Div1Input').val() == ''){
                $('#menu1Div1Input').focus();
            }
            else if($('#menu1Div2Input').val() == ''){
                $('#menu1Div2Input').focus();
            }
            else if($('#menu1Dep1Input').val() == ''){
                $('#menu1Dep1Input').focus();
            }
            else if($('#menu1Dep2Input').val() == ''){
                $('#menu1Dep2Input').focus();
            }
        });
        $('#menu1Kat2Input, #menu1BtnKat2').on('focus',function(){
            $('#limitKat').val($('#menu1Dep2Input').val()).change();

            if($('#menu1Div1Input').val() == ''){
                $('#menu1Div1Input').focus();
            }
            else if($('#menu1Div2Input').val() == ''){
                $('#menu1Div2Input').focus();
            }
            else if($('#menu1Dep1Input').val() == ''){
                $('#menu1Dep1Input').focus();
            }
            else if($('#menu1Dep2Input').val() == ''){
                $('#menu1Dep2Input').focus();
            }
            else if($('#menu1Kat1Input').val() == ''){
                $('#menu1Kat1Input').focus();
            }
        });

        $('#menu1Div1Input').on('change',function(){
            $('#menu1Div2Input').val('').change();
            $('#menu1Dep1Input').val('').change();
            $('#menu1Dep2Input').val('').change();
            $('#menu1Kat1Input').val('').change();
            $('#menu1Kat2Input').val('').change();

            $('#menu1Div1Desk').val('');
            $('#menu1Div2Desk').val('');
            $('#menu1Dep1Desk').val('');
            $('#menu1Dep2Desk').val('');
            $('#menu1Kat1Desk').val('');
            $('#menu1Kat2Desk').val('');
            if($('#menu1Div1Input').val() == ''){
                $('#menu1BtnDiv2').prop("hidden",true);


                $('#minDep').val('').change();
            }else{
                let index = checkDivExist($('#menu1Div1Input').val());
                if(index){
                    $('#menu1Div1Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));
                    $('#menu1BtnDiv2').prop("hidden",false);
                }else{
                    swal('', "Kode Divisi tidak terdaftar", 'warning');
                    $('#minDep').val('').change();
                    $('#menu1Div1Input').val('').change().focus();
                }
            }
        });
        $('#menu1Div2Input').on('change',function(){
            $('#menu1Dep1Input').val('').change();
            $('#menu1Dep2Input').val('').change();
            $('#menu1Kat1Input').val('').change();
            $('#menu1Kat2Input').val('').change();

            $('#menu1Div2Desk').val('');
            $('#menu1Dep1Desk').val('');
            $('#menu1Dep2Desk').val('');
            $('#menu1Kat1Desk').val('');
            $('#menu1Kat2Desk').val('');
            if($('#menu1Div2Input').val() == ''){
                $('#menu1BtnDep1').prop("hidden",true);


                $('#maxDep').val('').change();
            }else{
                let index = checkDivExist($('#menu1Div2Input').val());
                if(index){
                    $('#menu1Div2Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));
                    // $('#maxDep').val($('#menu1Div2Input').val()).change();
                    $('#menu1BtnDep1').prop("hidden",false);
                }else{
                    swal('', "Kode Divisi tidak terdaftar", 'warning');
                    $('#maxDep').val('').change();
                    $('#menu1Div2Input').val('').change();
                }
            }
        });
        $('#menu1Dep1Input').on('change',function(){
            $('#menu1Dep2Input').val('').change();
            $('#menu1Kat1Input').val('').change();
            $('#menu1Kat2Input').val('').change();

            $('#menu1Dep1Desk').val('');
            $('#menu1Dep2Desk').val('');
            $('#menu1Kat1Desk').val('');
            $('#menu1Kat2Desk').val('');
            if($('#menu1Dep1Input').val() == ''){
                $('#menu1BtnDep2').prop("hidden",true);

                $('#limitKat').val('').change();
            }else{
                let index = checkDepExist($('#menu1Dep1Input').val());
                if(index){
                    $('#menu1Dep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                    $('#menu1BtnDep2').prop("hidden",false);
                }else{
                    swal('', "Kode Departement tidak terdaftar", 'warning');
                    $('#limitKat').val('').change();
                    $('#menu1Dep1Input').val('').change();
                }
            }
        });
        $('#menu1Dep2Input').on('change',function(){
            $('#menu1Kat1Input').val('').change();
            $('#menu1Kat2Input').val('').change();

            $('#menu1Dep2Desk').val('');
            $('#menu1Kat1Desk').val('');
            $('#menu1Kat2Desk').val('');
            if($('#menu1Dep2Input').val() == ''){
                $('#menu1BtnKat1').prop("hidden",true);


                $('#limitKat').val('').change();
            }else{
                let index = checkDepExist($('#menu1Dep2Input').val());
                if(index){
                    $('#menu1Dep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                    $('#menu1BtnKat1').prop("hidden",false);
                }else{
                    swal('', "Kode Departement tidak terdaftar", 'warning');
                    $('#limitKat').val('').change();
                    $('#menu1Dep2Input').val('').change();
                }
            }
        });
        $('#menu1Kat1Input').on('change',function(){
            $('#menu1Kat2Input').val('').change();

            $('#menu1Kat1Desk').val('');
            $('#menu1Kat2Desk').val('');
            if($('#menu1Kat1Input').val() == ''){
                $('#menu1BtnKat2').prop("hidden",true);

            }else{
                let index = checkKatExist($('#menu1Kat1Input').val());
                if(index){
                    $('#menu1Kat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));

                    $('#menu1BtnKat2').prop("hidden",false);
                }else{
                    swal('', "Kode Kategori tidak terdaftar", 'warning');

                    $('#menu1Kat1Input').val('').change();
                }
            }
        });
        $('#menu1Kat2Input').on('change',function(){
            $('#menu1Kat2Desk').val('');
            if($('#menu1Kat2Input').val() == ''){
                //code here
            }else{
                //code here
                let index = checkKatExist($('#menu1Kat2Input').val());
                if(index){
                    $('#menu1Kat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
                }else{
                    swal('', "Kode Kategori tidak terdaftar", 'warning');

                    $('#menu1Kat2Input').val('').change();
                }
            }
        });

        //Tag berurutan
        $('#menu1Tag2').on('focus',function(){
            if($('#menu1Tag1').val() == ''){
                $('#menu1Tag1').focus();
            }
        });
        $('#menu1Tag3').on('focus',function(){
            if($('#menu1Tag1').val() == ''){
                $('#menu1Tag1').focus();
            }else if($('#menu1Tag2').val() == ''){
                $('#menu1Tag2').focus();
            }
        });
        $('#menu1Tag4').on('focus',function(){
            if($('#menu1Tag1').val() == ''){
                $('#menu1Tag1').focus();
            }else if($('#menu1Tag2').val() == ''){
                $('#menu1Tag2').focus();
            }else if($('#menu1Tag3').val() == ''){
                $('#menu1Tag3').focus();
            }
        });
        $('#menu1Tag5').on('focus',function(){
            if($('#menu1Tag1').val() == ''){
                $('#menu1Tag1').focus();
            }else if($('#menu1Tag2').val() == ''){
                $('#menu1Tag2').focus();
            }else if($('#menu1Tag3').val() == ''){
                $('#menu1Tag3').focus();
            }else if($('#menu1Tag4').val() == ''){
                $('#menu1Tag4').focus();
            }
        });
        $('#menu1Tag1').on('change',function(){
            $('#menu1Tag2').val('');
            $('#menu1Tag3').val('');
            $('#menu1Tag4').val('');
            $('#menu1Tag5').val('');
        });
        $('#menu1Tag2').on('change',function(){
            $('#menu1Tag3').val('');
            $('#menu1Tag4').val('');
            $('#menu1Tag5').val('');
        });
        $('#menu1Tag3').on('change',function(){
            $('#menu1Tag4').val('');
            $('#menu1Tag5').val('');
        });
        $('#menu1Tag4').on('change',function(){
            $('#menu1Tag5').val('');
        });

        function menu1Choose(val){
            //val dan curson didapat dari "list-master.blade.php"
            let kode = val.children().first().next().text();
            // let namadivisi = val.children().first().text();
            let index = cursor.substr(8,4);
            switch (index){
                case "Div1":
                    $('#menu1Div1Input').val(kode).change();
                    // $('#menu1Div1Desk').val(namadivisi);
                    $('#minDep').val(kode).change();
                    setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                        $('#menu1Div1Input').focus();
                    }, 10);

                    break;
                case "Div2":
                    $('#menu1Div2Input').val(kode).change();
                    // $('#menu1Div2Desk').val(namadivisi);
                    $('#maxDep').val(kode).change();
                    setTimeout(function() {
                        $('#menu1Div2Input').focus();
                    }, 10);
                    break;
                case "Dep1":
                    $('#menu1Dep1Input').val(kode).change();
                    // $('#menu1Div2Desk').val(namadivisi);
                    setTimeout(function() {
                        $('#menu1Dep1Input').focus();
                    }, 10);
                    break;
                case "Dep2":
                    $('#menu1Dep2Input').val(kode).change();
                    // $('#menu1Div2Desk').val(namadivisi);
                    setTimeout(function() {
                        $('#menu1Dep2Input').focus();
                    }, 10);
                    break;
                case "Kat1":
                    $('#menu1Kat1Input').val(kode).change();
                    setTimeout(function() {
                        $('#menu1Kat1Input').focus();
                    }, 10);
                    break;
                case "Kat2":
                    $('#menu1Kat2Input').val(kode).change();
                    setTimeout(function() {
                        $('#menu1Kat2Input').focus();
                    }, 10);
                    console.log(`kat2: ${kode}`);
                    break;
            }
        }

        function menu1Clear(){
            $('#menu1Div1Input').val('').change();
            $('#menu1Div1Desk').val('');
            $('#menu1Div2Desk').val('');
            $('#menu1Dep1Desk').val('');
            $('#menu1Dep2Desk').val('');
            $('#menu1Kat1Desk').val('');
            $('#menu1Kat2Desk').val('');
            $('#menu1Tag1').val('').change();
            $('#menu1SortBy').val(1);
            $('#menu1CheckProduk').prop("checked",false);
            $('#menu1CheckCHP').prop("checked",false);
            $('#menu1daterangepicker').data('daterangepicker').setStartDate(moment().format('DD/MM/YYYY'));
            // $('#menu1daterangepicker').data('daterangepicker').setEndDate(moment().format('DD/MM/YYYY'));
        }

        function menu1Cetak(){
            //Date
            let date = $('#menu1daterangepicker').val();
            // if(date == null || date == ""){
            //     swal('Periode tidak boleh kosong','','warning');
            //     return false;
            // }
            let dateA = date.substr(0,10);
            dateA = dateA.split('/').join('-');

            //DIV & DEP & KAT
            let temp = '';
            let div1 = $('#menu1Div1Input').val();
            let div2 = $('#menu1Div2Input').val();
            let dep1 = $('#menu1Dep1Input').val();
            let dep2 = $('#menu1Dep2Input').val();
            let kat1 = $('#menu1Kat1Input').val();
            let kat2 = $('#menu1Kat2Input').val();
            //periksa agar input tidak aneh" meski input sudah dibatasin, jaga" kalau input nya pakai f12
            if(div1 != ''){
                if(checkDivExist(div1) == false){
                    swal('', "Kode Divisi tidak terdaftar", 'warning');
                    return false;
                }
            }
            if(div2 != ''){
                if(checkDivExist(div2) == false){
                    swal('', "Kode Divisi tidak terdaftar", 'warning');
                    return false;
                }
            }
            if(dep1 != ''){
                //limit departemen berdasarkan divisi, tak perlu trigger fungsi change, karena bukan untuk tampilan
                $('#minDep').val(div1);
                $('#maxDep').val(div1);
                if(checkDepExist(dep1) == false){
                    swal('', "Kode Departemen tidak terdaftar", 'warning');
                    return false;
                }
            }
            if(dep2 != ''){
                //limit departemen berdasarkan divisi, tak perlu trigger fungsi change, karena bukan untuk tampilan
                $('#minDep').val(div2);
                $('#maxDep').val(div2);
                if(checkDepExist(dep2) == false){
                    swal('', "Kode Departemen tidak terdaftar", 'warning');
                    return false;
                }
            }
            if(kat1 != ''){
                //limit kategori berdasarkan departemen, tak perlu trigger fungsi change, karena bukan untuk tampilan

                $('#limitKat').val(dep1);
                if(checkKatExist(kat1) == false){
                    swal('', "Kode Kategori tidak terdaftar", 'warning');
                    return false;
                }
            }
            if(kat2 != ''){
                //limit kategori berdasarkan departemen, tak perlu trigger fungsi change, karena bukan untuk tampilan

                $('#limitKat').val(dep2);
                if(checkKatExist(kat2) == false){
                    swal('', "Kode Kategori tidak terdaftar", 'warning');
                    return false;
                }
            }

            // if(div1 != '' && div2 != ''){ // karena dep dan kat tak mungkin isi tanpa isi div, maka hanya perlu 1 kondisi ini,
            //     if(parseInt(div1) > parseInt(div2)){ // karena nilai dep1 dan ka1 berdasarkan div1, maka ganti cek div1 saja, sama dengan dep2 dan kat2
            //         temp = div1;
            //         div1 = div2;
            //         div2 = temp;
            //         temp = dep1;
            //         dep1 = dep2;
            //         dep2 = temp;
            //         temp = kat1;
            //         kat1 = kat2;
            //         kat2 = temp;
            //     }
            // }

            // TAG
            let tag1 = $('#menu1Tag1').val();
            let tag2 = $('#menu1Tag2').val();
            let tag3 = $('#menu1Tag3').val();
            let tag4 = $('#menu1Tag4').val();
            let tag5 = $('#menu1Tag5').val();
            let ptag = '';
            if(tag1 != '' || tag2 != '' || tag3 != '' || tag4 != '' || tag5 != ''){
                if(tag1 != ''){
                    ptag = "'"+tag1+"'";
                }else{
                    ptag = "'b'";
                }
                if(tag2 != ''){
                    ptag = ptag+",'"+tag2+"'";
                }else{
                    ptag = ptag+",'b'";
                }
                if(tag3 != ''){
                    ptag = ptag+",'"+tag3+"'";
                }else{
                    ptag = ptag+",'b'";
                }
                if(tag4 != ''){
                    ptag = ptag+",'"+tag4+"'";
                }else{
                    ptag = ptag+",'b'";
                }
                if(tag5 != ''){
                    ptag = ptag+",'"+tag5+"'";
                }else{
                    ptag = ptag+",'b'";
                }
            }

            //sortby
            let sort = $('#menu1SortBy').val();

            //PRINT
            window.open(`{{ url()->current() }}/print-beda-tag?div1=${div1}&div2=${div2}&dep1=${dep1}&dep2=${dep2}&kat1=${kat1}&kat2=${kat2}&ptag=${ptag}&date=${dateA}&produkbaru=${produkbaru}&chp=${chp}&sort=${sort}`, '_blank');
        }

        $(document).ready(function () {
            getModalDivisi();
            getModalDepartemen();
            getModalKategori();
        });

        function jenisLaporanChange(){
            $('.subMenu').prop("hidden",true)
            clearAll();
            switch ($('#jenisLaporan').val()){
                case '1':
                    $('#menu1').prop("hidden",false)
                    break;
            }
        }


        function clearAll(){
            menu1Clear();
        }

        function cetak(){
            menu1Cetak();            
        }

        // IMPORTANT!!! ### BUTUH CURSOR UNTUK MENDETEKSI TOMBOL MANA YANG MEMANGGIL! ###
        //Menggerakkan cursor
        $(":button").click(function(){
            cursor = this.id;
        });

        /* Custom filtering function which will search data in column four between two values */
        //Custom Filtering untuk dept
        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex, rowData, counter ) {

                if ( settings.nTable.id === 'tableModalDiv' ) {
                    return true; //no filtering on modal div
                }

                if ( settings.nTable.id === 'tableModalDep' ) {
                    let min = parseInt( $('#minDep').val(), 10 );
                    let max = parseInt( $('#maxDep').val(), 10 );
                    let filter = parseInt( $('#filtererDep').val(), 10 );
                    let val = parseFloat( data[2] ) || 0; // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_div
                    let val2 = parseFloat( data[1] ) || 0;
                    //filter on table modalDept
                    if ( ( isNaN( min ) && isNaN( max ) ) ||
                        ( isNaN( min ) && val <= max ) ||
                        ( min <= val   && isNaN( max ) ) ||
                        ( min <= val   && val <= max ) )
                    {
                        return true;
                    }
                }
                if ( settings.nTable.id === 'tableModalKat' ) {
                    let limit = $('#limitKat').val();
                    let val = data[2]; // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_dep
                    if(limit == '' || limit == val){
                        return true;
                    }
                }
                if ( settings.nTable.id === 'tableModalSup' ) {
                    let min = $('#minSup').val();
                    let val = data[1];
                    if(min === ''){
                        return true;
                    }else if(min <= val){
                        return true;
                    }

                }
                if ( settings.nTable.id === 'tableModalMem' ) {
                    return true; //no filtering on modal Mem
                }
                if ( settings.nTable.id === 'tableModalMemDate' ) {
                    return true; //no filtering on modal Mem
                }
                if ( settings.nTable.id === 'tableModalOutlet' ) {
                    return true; //no filtering on modal Sup
                }
                if ( settings.nTable.id === 'tableModalSubOutlet' ) {
                    let outlet = parseInt( $('#outletFilterer').val(), 10 );
                    let min = $('#minSubOutlet').val();
                    let val2 = parseInt( ( data[2] ), 10 ); // use data for the val column, [2] maksudnya kolom ke 2, yaitu kode_div
                    let val1 = data[1];
                    //filter on table modalDept
                    if ( ( isNaN( outlet ) ) || ( val2 === outlet ) )
                    {
                        if(min === '' || min <= val1){
                            return true;
                        }
                    }
                }
                if ( settings.nTable.id === 'tableModalPlu' ) {
                    return true; //no filtering on modal Plu
                }
                if ( settings.nTable.id === 'tableModalPluCustom' ) {
                    return true; //no filtering on modal Plu
                }
                if ( settings.nTable.id === 'tableModalRak' ) {
                    let rak = data[0];
                    let subrak = data[1];
                    let tiperak = data[2];
                    let shelving = data[3];

                    let theRak = $('#theRak').val();
                    let theSubRak = $('#theSubRak').val();
                    let theTipeRak = $('#theTipeRak').val();

                    if($('#rakColumn').val() == 'rak'){
                        if (dataIndex === 0)
                        {
                            listRak = [];
                        }
                        if ($.inArray(rak,listRak) === -1)
                        {
                            listRak.push(rak);
                            return true;
                        }
                    }else if($('#rakColumn').val() === 'subrak'){
                        if (dataIndex === 0)
                        {
                            listSubRak = [];
                        }
                        if ($.inArray(subrak,listSubRak) === -1 && theRak === rak)
                        {
                            listSubRak.push(subrak);
                            return true;
                        }
                    }else if($('#rakColumn').val() === 'tiperak'){
                        if (dataIndex === 0)
                        {
                            listTipeRak = [];
                        }
                        if ($.inArray(tiperak,listTipeRak) === -1 && theRak === rak && theSubRak === subrak)
                        {
                            listTipeRak.push(tiperak);
                            return true;
                        }
                    }else if($('#rakColumn').val() === 'shelving'){
                        if (dataIndex === 0)
                        {
                            listShelving = [];
                        }
                        if ($.inArray(shelving,listShelving) === -1 && theRak === rak && theSubRak === subrak && theTipeRak === tiperak)
                        {
                            listShelving.push(shelving);
                            return true;
                        }
                    }else{
                        return true;
                    }
                }
                return false;
            }
        );
        $('#minDep, #maxDep').change( function() {
            tableDepartemen.draw();
        } );
        $('#limitKat').change( function() {
            tableKategori.draw();
        } );

        function validateTag(){
            let tag = $('#kodetagigr').val();
            ajaxSetup();
            $.ajax({
                url: '{{ url()->current() }}/validateTag',
                type: 'post',
                data: {tag : tag},
                success: function (result){
                    
                    if (result.errflag == 1 ){

                        $('#kodetagigr').value = "";

                        swal({
                            title: result.status,
                            text: result.message,
                            icon: result.status,
                        })

                    }


                    // window.location.reload();

                }, error: function () {
                    alert('error validating kode tag');
                    //$('#modal-loader').modal('hide')
                }
            })
        }

        //MODAL-MODAL
        //MODAL DIVISI
        function getModalDivisi(){
            tableDivisi =  $('#tableModalDiv').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-divisi' }}',
                },
                "columns": [
                    {data: 'div_namadivisi', name: 'div_namadivisi'},
                    {data: 'div_kodedivisi', name: 'div_kodedivisi'},
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
                    $(row).addClass('modalDivisi');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        //MODAL DEPARTEMEN
        function getModalDepartemen(){
            tableDepartemen =  $('#tableModalDep').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-departemen' }}',
                },
                "columns": [
                    {data: 'dep_namadepartement', name: 'dep_namadepartement'},
                    {data: 'dep_kodedepartement', name: 'dep_kodedepartement'},
                    {data: 'dep_kodedivisi', name: 'dep_kodedivisi', visible: false},
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
                    $(row).addClass('modalDepartemen');
                },
                columnDefs : [
                ],
                "order": []
            });
        }
        //MODAL KATEGORI
        function getModalKategori(){
            tableKategori =  $('#tableModalKat').DataTable({
                "ajax": {
                    'url' : '{{ url()->current().'/get-lov-kategori' }}',
                },
                "columns": [
                    {data: 'kat_namakategori', name: 'kat_namakategori'},
                    {data: 'kat_kodekategori', name: 'kat_kodekategori'},
                    {data: 'kat_kodedepartement', name: 'kat_kodedepartement', visible: false},
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
                    $(row).addClass('modalKategori');
                },
                columnDefs : [
                ],
                "order": []
            });
        }


        //ONCLICK MODAL
        //ONCLICK DIVISI
        $(document).on('click', '.modalDivisi', function () {
            $('#divModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                menu1Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu2"){
                menu2Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu3"){
                menu3Choose(currentButton);
            }else if(cursor.substr(0,5) === "menuA"){
                menuAChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuE"){
                menuEChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuF"){
                menuFChoose(currentButton);
            }
        });
        //ONCLICK DEPARTEMEN
        $(document).on('click', '.modalDepartemen', function () {
            $('#depModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                menu1Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu2"){
                menu2Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu3"){
                menu3Choose(currentButton);
            }else if(cursor.substr(0,5) === "menuA"){
                menuAChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuC"){
                menuCChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuE"){
                menuEChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuF"){
                menuFChoose(currentButton);
            }
        });
        //ONCLICK KATEGORI
        $(document).on('click', '.modalKategori', function () {
            $('#katModal').modal('toggle');
            let currentButton = $(this);

            if(cursor.substr(0,5) === "menu1"){
                menu1Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu2"){
                menu2Choose(currentButton);
            }else if(cursor.substr(0,5) === "menu3"){
                menu3Choose(currentButton);
            }else if(cursor.substr(0,5) === "menuA"){
                menuAChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuC"){
                menuCChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuE"){
                menuEChoose(currentButton);
            }else if(cursor.substr(0,5) === "menuF"){
                menuFChoose(currentButton);
            }
        });


        //Untuk periksa apakah div ada
        function checkDivExist(val){
            for(i=0;i<tableDivisi.data().length;i++){
                if(tableDivisi.row(i).data()['div_kodedivisi'] == val){
                    return i+1;
                }
            }
            return 0;
        }

        //Untuk periksa apakah dep ada
        function checkDepExist(val){
            let min = 0;
            let max = tableDepartemen.data().length;

            if($('#minDep').val() != ''){
                min = parseInt( $('#minDep').val(), 10 );
            }
            if($('#maxDep').val() != ''){
                max = parseInt( $('#maxDep').val(), 10 );
            }
            for(i=0;i<tableDepartemen.data().length;i++){
                if(tableDepartemen.row(i).data()['dep_kodedivisi'] >= min && tableDepartemen.row(i).data()['dep_kodedivisi'] <= max){
                    if(tableDepartemen.row(i).data()['dep_kodedepartement'] == val){
                        return i+1;
                    }
                }
            }
            return 0;
        }

        //Untuk periksa apakah kat ada
        function checkKatExist(val){
            let limit = '';

            if($('#limitKat').val() != ''){
                limit = $('#limitKat').val();
            }

            for(i=0;i<tableKategori.data().length;i++){
                if(tableKategori.row(i).data()['kat_kodedepartement'] == limit || limit == ''){
                    if(tableKategori.row(i).data()['kat_kodekategori'] == val){
                        return i+1;
                    }
                }
            }
            return 0;
        }
     
    </script>
@endsection
