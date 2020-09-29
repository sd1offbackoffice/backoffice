@extends('navbar')
@section('content')

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <fieldset class="card border-dark">
                    <legend  class="w-auto ml-5">IGR_BO_PRINT</legend>
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
                                        <input type="date" id="i_tgl1" class="form-control col-sm-2 mx-sm-1 field field1" field="1" name="fform">
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <input type="date" id="i_tgl2" class="form-control col-sm-2 mx-sm-1 field field2" field="2" name="fform">
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">No Dokumen</label>
                                        <input type="text" id="i_doc1" class="form-control col-sm-2 mx-sm-1 field field3" field="3" name="fform">
                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getDocument('i_doc1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <input type="text" id="i_doc2" class="form-control col-sm-2 mx-sm-1 field field4" field="4" name="fform">
                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getDocument('i_doc2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Divisi</label>
                                        <input type="text" id="i_div1" class="form-control col-sm-1 mx-sm-1 field field5" field="5">
                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getDivisi('i_div1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <input type="text" id="i_div2" class="form-control col-sm-1 mx-sm-1 field field6" field="6">
                                        <button class="btn ml-2" type="button" data-toggle="modal"onclick="getDivisi('i_div2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Departement</label>
                                        <input type="text" id="i_dept1" class="form-control col-sm-1 mx-sm-1 field field7" field="7">
                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getDepartemen('i_dept1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <input type="text" id="i_dept2" class="form-control col-sm-1 mx-sm-1 field field8" field="8">
                                        <button class="btn ml-2" type="button" data-toggle="modal"onclick="getDepartemen('i_dept2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <label class="col-sm-4 col-form-label text-md-right">Kategori</label>
                                        <input type="text" id="i_kat1" class="form-control col-sm-1 mx-sm-1 field field9" field="9">
                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getKategori('i_kat1')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                        <p class="mt-3 ml-2 mr-2 text-secondary">s/d</p>
                                        <input type="text" id="i_kat2" class="form-control col-sm-1 mx-sm-1 field field10" field="10">
                                        <button class="btn ml-2" type="button" data-toggle="modal" onclick="getKategori('i_kat2')"> <img src="{{asset('image/icon/help.png')}}" width="20px"> </button>
                                    </div>
                                    <button type="button" id="btnAktifkanHrg" class="btn btn-danger pl-4 pr-4 mr-3 float-right field field12" onclick="clearField()" field="12">Batal</button>
                                    <button type="button" id="btnAktifkanHrg" class="btn btn-primary pl-4 pr-4 mr-3 float-right field field11" onclick="prosesCetak()" field="11">Cetak PB</button>
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

    <style>
        input{
            text-transform: uppercase;
        }
    </style>

    <script>
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
            $('#modalHelp').modal('hide');
        }

        function getDocument(field) {
            let tgl1   = $('#i_tgl1').val();
            let tgl2   = $('#i_tgl2').val();

            // console.log(tgl1);

            if(tgl1.length === 0 || tgl2.length === 0){
                swal('Error', 'Input Tanggal', 'error');
                return false;
            } else {
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bocetakpb/getdocument',
                    type: 'post',
                    data: {
                        tgl1: tgl1,
                        tgl2: tgl2
                    },
                    success: function (result) {
                        console.log(result)
                        $('#modalThName2').show();
                        $('#modalThName3').hide();
                        $('#modalThName1').text('KODE');
                        $('#modalThName2').text('TANGGAL');
                        $('#idModal').text('DC');
                        $('#idField').text(field);
                        $('#searchModal').val('');

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseRow('"+ field +"','"+ result[i].pbh_nopb+"') class='modalRow'><td>"+ result[i].pbh_nopb +"</td><td>"+ formatDate(result[i].pbh_tglpb) +"</td></tr>")
                        }

                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        function getDivisi(field) {
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/bocetakpb/getdivisi',
                type: 'post',
                data: {},
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

        function getDepartemen(field) {
            let div1   = $('#i_div1').val();
            let div2   = $('#i_div2').val();

            if(div1.length === 0 || div2.length === 0){
                swal('Error', 'Input Divisi', 'error');
                return false;
            } else {
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bocetakpb/getdepartement',
                    type: 'post',
                    data: {
                        div1: div1,
                        div2: div2
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
        }

        function getKategori(field) {
            let dept1   = $('#i_dept1').val();
            let dept2   = $('#i_dept2').val();

            if(dept1.length === 0 || dept2.length === 0){
                swal('Error', 'Input Departemen', 'error');
                return false;
            } else {
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/bocetakpb/getkategori',
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
