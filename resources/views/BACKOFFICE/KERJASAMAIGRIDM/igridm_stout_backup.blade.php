@extends('navbar')
@section('title','Laporan Stock Out')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <fieldset class="card">
                    <legend class="w-auto ml-5">LAPORAN STOCK OUT</legend>
                    <div class="card-body shadow-lg cardForm">
                        <form>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <label class="radio-inline">
                                        <input type="radio" name="optradio" value="r1" checked> Stock Out berdasarkan KPH Mean
                                    </label>
                                    &nbsp;&nbsp;&nbsp;
                                    <label class="radio-inline">
                                        <input type="radio" name="optradio" value="r2"> Stock Out berdasarkan KPH Mean dan PO
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Kode Divisi</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="bigGuy form-control" id="div1" maxlength="1">
                                    <button onclick="GetDiv('')" id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <label class="col-sm-1 text-center">s/d</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="bigGuy form-control" id="div2" maxlength="1">
                                    <button onclick="GetDiv2('')" id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Kode Departement</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="bigGuy form-control" id="dept1" maxlength="2">
                                    <button onclick="GetDept('')" id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <label class="col-sm-1 text-center">s/d</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="bigGuy form-control" id="dept2" maxlength="2">
                                    <button onclick="GetDept2('')" id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-4 text-right font-weight-normal">Kode Kategori</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="bigGuy form-control" id="kat1" maxlength="2">
                                    <button onclick="GetKat('')" id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                                <label class="col-sm-1 text-center">s/d</label>
                                <div class="col-sm-2 buttonInside">
                                    <input type="text" class="bigGuy form-control" id="kat2" maxlength="2">
                                    <button onclick="GetKat2('')" id="btn-no-doc" type="button" class="btn btn-lov p-0">
                                        <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                                    </button>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex bd-highlight mb-3">
                                <div class="mr-auto p-2 bd-highlight font-weight-bold">** Kosong Semua = ALL</div>
                                <button class="p-2 bd-highlight btn btn-success col-sm-4" type="button" onclick="print()">CETAK</button>
                            </div>
{{--                            <div class="d-flex justify-content-end">--}}
{{--                                <button class="p-2 bd-highlight btn btn-success col-sm-4" type="button" onclick="print()">CETAK</button>--}}
{{--                            </div>--}}
                        </form>
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
                        <input id="searchModal" class="form-control search_lov" type="text" placeholder="..." aria-label="Search">
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
                                            <th id="modalThName4"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbodyModalHelp"></tbody>
                                    </table>
                                    <p class="text-hide" id="searchKey"></p>
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

        $('.bigGuy').keyup(function(){
            this.value = this.value.toUpperCase();
        });

        $('#searchModal').keypress(function (e) {
            if (e.which === 13) {
                let searchKey = $('#searchKey').val();
                let val = $('#searchModal').val().toUpperCase();
                if(searchKey === 'div1'){
                    GetDiv(val);
                }else if(searchKey === 'div2'){
                    GetDiv2(val);
                }else if(searchKey === 'dept1'){
                    GetDept(val);
                }else if(searchKey === 'dept2'){
                    GetDept2(val);
                }else if(searchKey === 'kat1'){
                    GetKat(val);
                }else if(searchKey === 'kat2'){
                    GetKat2(val);
                }
            }
        });

        function GetDiv(val) {
            $('#searchModal').val('');
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/kerjasamaigridm/stout/getdiv',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('#modalThName1').text('KODE DIVISI');
                    $('#modalThName2').text('NAMA DIVISI');
                    $('#modalThName3').text('SINGKATAN DIVISI');
                    $('#modalThName4').text('');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseDiv('"+ result[i].div_kodedivisi+"') class='modalRow'><td>"+ result[i].div_kodedivisi +"</td> <td>"+ result[i].div_namadivisi +"</td> <td>"+ result[i].div_singkatannamadivisi +"</td><td> </td></tr>")
                    }
                    $('#searchKey').val("div1");
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function chooseDiv(div){
            $('#div1').val(div);
            $('#modalHelp').modal('hide');
        }

        function GetDiv2(val) {
            $('#searchModal').val('');
            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/kerjasamaigridm/stout/getdiv',
                type: 'post',
                data: {
                    val:val
                },
                success: function (result) {
                    $('#modalThName1').text('KODE DIVISI');
                    $('#modalThName2').text('NAMA DIVISI');
                    $('#modalThName3').text('SINGKATAN DIVISI');
                    $('#modalThName4').text('');

                    $('.modalRow').remove();
                    for (i = 0; i< result.length; i++){
                        $('#tbodyModalHelp').append("<tr onclick=chooseDiv2('"+ result[i].div_kodedivisi+"') class='modalRow'><td>"+ result[i].div_kodedivisi +"</td> <td>"+ result[i].div_namadivisi +"</td> <td>"+ result[i].div_singkatannamadivisi +"</td><td> </td></tr>")
                    }
                    $('#searchKey').val("div2");
                    $('#modalHelp').modal('show');
                }, error: function () {
                    alert('error');
                }
            })
        }

        function chooseDiv2(div){
            $('#div2').val(div);
            $('#modalHelp').modal('hide');
        }

        function GetDept(val) {
            if($('#div1').val() == '' || $('#div2').val() == ''){
                swal('', "Kode div 1 dan div 2 harus di isi untuk mencari departemen !!", 'warning');
            }else{
                let div1 = $('#div1').val();
                let div2 = $('#div2').val();
                $('#searchModal').val('');
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/kerjasamaigridm/stout/getdept',
                    type: 'post',
                    data: {
                        val:val,
                        div1:div1,
                        div2:div2
                    },
                    success: function (result) {
                        $('#modalThName1').text('KODE DEPARTEMEN');
                        $('#modalThName2').text('NAMA DEPARTEMEN');
                        $('#modalThName3').text('KODE DIVISI');
                        $('#modalThName4').text('SINGKATAN DEPARTEMEN');

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseDept('"+ result[i].dep_kodedepartement+"') class='modalRow'><td>"+ result[i].dep_kodedepartement +"</td> <td>"+ result[i].dep_namadepartement +"</td> <td>"+ result[i].dep_kodedivisi +"</td><td>"+ result[i].dep_singkatandepartement +"</td></tr>")
                        }
                        $('#searchKey').val("dept1");
                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        function chooseDept(dept){
            $('#dept1').val(dept);
            $('#modalHelp').modal('hide');
        }

        function GetDept2(val) {
            if($('#div1').val() == '' || $('#div2').val() == ''){
                swal('', "Kode div 1 dan div 2 harus di isi untuk mencari departemen !!", 'warning');
            }else{
                let div1 = $('#div1').val();
                let div2 = $('#div2').val();
                $('#searchModal').val('');
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/kerjasamaigridm/stout/getdept',
                    type: 'post',
                    data: {
                        val:val,
                        div1:div1,
                        div2:div2
                    },
                    success: function (result) {
                        $('#modalThName1').text('KODE DEPARTEMEN');
                        $('#modalThName2').text('NAMA DEPARTEMEN');
                        $('#modalThName3').text('KODE DIVISI');
                        $('#modalThName4').text('SINGKATAN DEPARTEMEN');

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseDept2('"+ result[i].dep_kodedepartement+"') class='modalRow'><td>"+ result[i].dep_kodedepartement +"</td> <td>"+ result[i].dep_namadepartement +"</td> <td>"+ result[i].dep_kodedivisi +"</td><td>"+ result[i].dep_singkatandepartement +"</td></tr>")
                        }
                        $('#searchKey').val("dept2");
                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        function chooseDept2(dept){
            $('#dept2').val(dept);
            $('#modalHelp').modal('hide');
        }

        function GetKat(val) {
            if($('#dept1').val() == '' || $('#dept2').val() == ''){
                swal('', "Kode dept 1 dan dept 2 harus di isi untuk mencari departemen !!", 'warning');
            }else{
                let dept1 =  $('#dept1').val();
                let dept2 =  $('#dept2').val();
                $('#searchModal').val('');
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/kerjasamaigridm/stout/getkat',
                    type: 'post',
                    data: {
                        val:val,
                        dept1:dept1,
                        dept2:dept2
                    },
                    success: function (result) {
                        $('#modalThName1').text('KODE KATEGORI');
                        $('#modalThName2').text('NAMA KATEGORI');
                        $('#modalThName3').text('KODE DEPARTEMEN');
                        $('#modalThName4').text('SINGKATAN KATEGORI');

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseKat('"+ result[i].kat_kodekategori+"') class='modalRow'><td>"+ result[i].kat_kodekategori +"</td> <td>"+ result[i].kat_namakategori +"</td> <td>"+ result[i].kat_kodedepartement +"</td> <td>"+ result[i].kat_singkatan +"</td></tr>")
                        }
                        $('#searchKey').val("kat1");
                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        function chooseKat(kat){
            $('#kat1').val(kat);
            $('#modalHelp').modal('hide');
        }

        function GetKat2(val) {
            if($('#dept1').val() == '' || $('#dept2').val() == ''){
                swal('', "Kode dept 1 dan dept 2 harus di isi untuk mencari departemen !!", 'warning');
            }else{
                let dept1 =  $('#dept1').val();
                let dept2 =  $('#dept2').val();
                $('#searchModal').val('');
                ajaxSetup();
                $.ajax({
                    url: '/BackOffice/public/kerjasamaigridm/stout/getkat',
                    type: 'post',
                    data: {
                        val:val,
                        dept1:dept1,
                        dept2:dept2
                    },
                    success: function (result) {
                        $('#modalThName1').text('KODE KATEGORI');
                        $('#modalThName2').text('NAMA KATEGORI');
                        $('#modalThName3').text('KODE DEPARTEMEN');
                        $('#modalThName4').text('SINGKATAN KATEGORI');

                        $('.modalRow').remove();
                        for (i = 0; i< result.length; i++){
                            $('#tbodyModalHelp').append("<tr onclick=chooseKat2('"+ result[i].kat_kodekategori+"') class='modalRow'><td>"+ result[i].kat_kodekategori +"</td> <td>"+ result[i].kat_namakategori +"</td> <td>"+ result[i].kat_kodedepartement +"</td> <td>"+ result[i].kat_singkatan +"</td></tr>")
                        }
                        $('#searchKey').val("kat2");
                        $('#modalHelp').modal('show');
                    }, error: function () {
                        alert('error');
                    }
                })
            }
        }

        function chooseKat2(kat){
            $('#kat2').val(kat);
            $('#modalHelp').modal('hide');
        }

        function print() {
            let rad = $("input[type='radio'][name='optradio']:checked").val();
            let div1 = $('#div1').val();
            let div2 = $('#div2').val();
            let dept1 = $('#dept1').val();
            let dept2 = $('#dept2').val();
            let kat1 = $('#kat1').val();
            let kat2 = $('#kat2').val();
            if(div1 == ''){
                div1 = '0';
            }
            if(div2 == ''){
                div2 = '9';
            }
            if(dept1 == ''){
                dept1 = '00'
            }else if(parseInt(dept1)>=0 && parseInt(dept1)<10){
                dept1 = '0'+dept1;
            }
            if(dept2 == ''){
                dept2 = '99';
            }else if(parseInt(dept2)>=0 && parseInt(dept2)<10){
                dept2 = '0'+dept2;
            }
            if(kat1 == ''){
                kat1 = '00';
            }else if(parseInt(kat1)>=0 && parseInt(kat1)<10){
                kat1 = '0'+kat1;
            }
            if(kat2 == ''){
                kat2 = '99';
            }else if(parseInt(kat2)>=0 && parseInt(kat2)<10){
                kat2 = '0'+kat2;
            }

            ajaxSetup();
            $.ajax({
                url: '/BackOffice/public/kerjasamaigridm/stout/checkdata',
                type: 'post',
                data: {
                    choice:rad,
                    div1:div1,
                    div2:div2,
                    dept1:dept1,
                    dept2:dept2,
                    kat1:kat1,
                    kat2:kat2
                },
                beforeSend: function () {
                    $('#modal-loader').modal({backdrop: 'static', keyboard: false});
                },
                success: function (result) {
                    if(result.kode == '0'){
                        window.open('/BackOffice/public/kerjasamaigridm/stout/printdoc/'+rad+'/'+div1+'-'+div2+'/'+dept1+'-'+dept2+'/'+kat1+'-'+kat2,'_blank');
                    }else if(result.kode == '1'){
                        swal('', "tidak ada data", 'warning');
                    }else if(result.kode == '2'){
                        swal('', "Kode Tag tidak terdaftar", 'warning');
                    }

                    $('#modal-loader').modal('hide');
                }, error: function (e) {
                    console.log(e);
                    alert('error');
                }
            })
        }
    </script>
@endsection
