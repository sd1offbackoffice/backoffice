@extends('navbar')
@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <fieldset class="card border-dark">
                <legend  class="w-auto ml-5">PB Otomatis</legend>
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
                                    <input type="text" id="i_supp1" class="form-control col-sm-1 mx-sm-1 field field1" field="1">
                                    <button class="btn ml-2" type="button" data-toggle="modal" onclick="getSupplier('i_supp1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    <input type="text" id="i_supp2" class="form-control col-sm-1 mx-sm-1 field field2" field="2">
                                    <button class="btn ml-2" type="button" data-toggle="modal" onclick="getSupplier('i_supp2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label text-md-right">Monitoring Supplier</label>
                                    <input type="text" id="i_mtrSup1" class="form-control col-sm-1 mx-sm-1 field field3" field="3">
                                    <button class="btn ml-2" type="button" data-toggle="modal" onclick="getMtrSup('i_mtrSup1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    <input type="text" id="i_mtrSup2" class="form-control col-sm-4 mx-sm-1" disabled>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label text-md-right">Kode Departement</label>
                                    <input type="text" id="i_dept1" class="form-control col-sm-1 mx-sm-1 field field4" field="4">
                                    <button class="btn ml-2" type="button" data-toggle="modal" onclick="getDepartemen('i_dept1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    <input type="text" id="i_dept2" class="form-control col-sm-1 mx-sm-1 field field5" field="5">
                                    <button class="btn ml-2" type="button" data-toggle="modal"onclick="getDepartemen('i_dept2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                </div>
                                <div class="form-group row mb-0">
                                    <label class="col-sm-4 col-form-label text-md-right">Kode Kategori</label>
                                    <input type="text" id="i_kat1" class="form-control col-sm-1 mx-sm-1 field field6" field="6">
                                    <button class="btn ml-2" type="button" data-toggle="modal" onclick="getKategori('i_kat1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    <input type="text" id="i_kat2" class="form-control col-sm-1 mx-sm-1 field field7" field="7">
                                    <button class="btn ml-2" type="button" data-toggle="modal" onclick="getKategori('i_kat2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                </div>
                                <button type="button" id="btnAktifkanHrg" class="btn btn-primary pl-4 pr-4 float-right field field8" onclick="proses()" field="8">PROSES</button>
                            </form>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalHelp" tabindex="-1" role="dialog" aria-labelledby="m_kodecabangHelp" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="form-row col-sm">
                    <input id="searchModal" class="form-control search_lov" type="text" placeholder="Inputkan Nama / Kode " aria-label="Search">
                </div>
            </div>
            <div class="modal-body ">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="tableFixedHeader">
                                <table class="table table-sm">
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


    <script>
        let allData;

        $(document).ready(function () {
           getDataModal();
        });

        function getDataModal() {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bopbotomatis/getdatamodal',
                type: 'post',
                data: {},
                success: function (result) {
                    allData = result;
                }, error: function () {
                    alert('error');
                }
            })
        }

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let idModal = $('#idModal').text();
                let idField = $('#idField').text();
                let input   = $('#searchModal').val();

                console.log(idField);

                if (idModal === 'S'){
                    searchSupplier(input,idField);
                } else if(idModal === 'MS'){
                    searchMtrSupplier(input,idField);
                } else if(idModal === 'D'){
                    searchDepartemen(input,idField);
                } else if(idModal === 'K'){
                    searchKategori(input,idField);
                }
            }
        });

        $(document).on('keypress', '.field', function (e) {
            if(e.which == 13) {
                e.preventDefault();
                var field   = $(this).attr('field');
                var target  = 'field'+(parseInt(field)+1);
                $('.'+target).focus();
            }
        });

        function getSupplier(field) {
            let result = allData.supplier;
            $('#modalThName1').text('SUPPLIER');
            $('#modalThName2').hide();
            $('#modalThName3').hide();
            $('#idModal').text('S');
            $('#idField').text(field);
            $('#searchModal').val('');

            $('.modalRow').remove();
            for (i = 0; i< result.length; i++){
                $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].sup_kodesupplier+"') class='modalRow'><td>"+ result[i].sup_namasupplier +"</td></tr>")
            }

            $('#modalHelp').modal('show');
        }

        function searchSupplier(input, field) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bopbotomatis/getsupplier',
                type: 'post',
                data: {
                    search:input
                },
                success: function (result) {
                    $('#modalThName1').text('SUPPLIER');
                    $('#modalThName2').hide();
                    $('#modalThName3').hide();

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].sup_kodesupplier+"') class='modalRow'><td>"+ result[i].sup_namasupplier +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function getMtrSup(field) {
            let result = allData.mtrsup;

            $('#modalThName3').hide();
            $('#modalThName2').show();
            $('#modalThName1').text('KODE');
            $('#modalThName2').text('NAMA');
            $('#idModal').text('MS');
            $('#idField').text(field);
            $('#searchModal').val('');

            $('.modalRow').remove();
            for (i = 0; i< result.length; i++){
                $('#tbodyModalHelp').append("<tr onclick=chooseMtrSupp('"+ result[i].msu_kodemonitoring +"','"+ result[i].msu_namamonitoring+"') class='modalRow'><td>"+ result[i].msu_kodemonitoring +"</td><td>"+ result[i].msu_namamonitoring +"</td></tr>")
            }

            $('#modalHelp').modal('show');
        }

        function searchMtrSupplier(input, field) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bopbotomatis/getmtrsup',
                type: 'post',
                data: {
                    search: input
                },
                success: function (result) {
                    $('#modalThName3').hide();
                    $('#modalThName2').show();
                    $('#modalThName1').text('KODE');
                    $('#modalThName2').text('NAMA');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseMtrSupp('"+ result[i].msu_kodemonitoring +"','"+ result[i].msu_namamonitoring+"') class='modalRow'><td>"+ result[i].msu_kodemonitoring +"</td><td>"+ result[i].msu_namamonitoring +"</td></tr>")
                    }

                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function getDepartemen(field) {
            let result = allData.departemen;

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
        }

        function searchDepartemen(input, field) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bopbotomatis/getdepartemen',
                type: 'post',
                data: {
                    search:input
                },
                success: function (result) {
                    $('#modalThName3').hide();
                    $('#modalThName2').show();
                    $('#modalThName1').text('KODE');
                    $('#modalThName2').text('DEPARTEMEN');

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

        function getKategori(field) {
            let dept1   = $('#i_dept1').val();
            let dept2   = $('#i_dept2').val();

            if(dept1.length == 0 || dept2.length == 0){
                swal('Error', 'Input Departemen', 'error');
                return false;
            } else {
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bopbotomatis/getkategori',
                    type: 'post',
                    data: {
                        dept1: dept1,
                        dept2: dept2
                    },
                    success: function (result) {
                        $('#modalThName2').show();
                        $('#modalThName3').show();
                        $('#modalThName1').text('DEPT');
                        $('#modalThName2').text('KODE');
                        $('#modalThName3').text('KATEGORI');
                        $('#idModal').text('K');
                        $('#idField').text(field);
                        $('#searchModal').val('');

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].kat_kodekategori+"') class='modalRow'><td>"+ result[i].kat_kodedepartement +"</td><td>"+ result[i].kat_kodekategori +"</td><td>"+ result[i].kat_namakategori +"</td></tr>")
                        }

                        console.log(result)

                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        function searchKategori(input, field) {
            let dept1   = $('#i_dept1').val();
            let dept2   = $('#i_dept2').val();

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bopbotomatis/searchkategori',
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
                url: '/BackOffice/public/bopbotomatis/prosesdata',
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

                        window.open('/BackOffice/public/bopbotomatis/cetakreport/'+param1 +'/'+param2 +'/'+param3 +'/'+param4 +'/'+param5 +'/')
                    } else {
                        swal('Failed', result.msg, 'error');
                    }
                    clearField()
                }, error: function () {
                    swal('Error', '','error');
                }
            })
        }

        function chooseRow(field,data) {
            $('#'+ field+'').val(data);
            $('#modalHelp').modal('hide');
        }

        function chooseMtrSupp(kode,name) {
            $('#i_mtrSup1').val(kode);
            $('#i_mtrSup2').val(name);
            $('#modalHelp').modal('hide');
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
