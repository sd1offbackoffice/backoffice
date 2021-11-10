{{--ASSET LIST MASTER--}}
{{-- DAFTAR PERUBAHAN HARGA JUAL --}}

<div>
    <fieldset class="card border-dark">
        {{--        <legend class="w-auto ml-5">Daftar Perubahan Harga Jual</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tanggal</label>
            <div class="col-sm-6 buttonInside">
                <input id="menu2daterangepicker" class="form-control" type="text">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Div1Input" class="form-control" type="text">
                <button id="menu2BtnDiv1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Div1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Div2Input" class="form-control" type="text">
                <button id="menu2BtnDiv2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Div2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Dep1Input" class="form-control" type="text">
                <button id="menu2BtnDep1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#depModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Dep1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Dep2Input" class="form-control" type="text">
                <button id="menu2BtnDep2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#depModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Dep2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Kat1Input" class="form-control" type="text">
                <button id="menu2BtnKat1" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#katModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Kat1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu2Kat2Input" class="form-control" type="text">
                <button id="menu2BtnKat2" type="button" class="btn btn-lov p-0" data-toggle="modal" hidden
                        data-target="#katModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu2Kat2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Urut (SORT) Atas</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu2SortBy" onchange="menu2SortBy()">
                    <option value="1">1. DIV+DEPT+KATEGORI+KODE</option>
                    <option value="2">2. DIV+DEPT+KATEGORI+NAMA</option>
                    <option value="3">3. NAMA</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tag</label>
            <div class="col-sm-2">
                <input id="menu2Tag1" class="form-control" type="text">
            </div>
            <label class="col-sm-2 text-center col-form-label">s/d</label>
            <div class="col-sm-2">
                <input id="menu2Tag2" class="form-control" type="text">
            </div>
        </div>
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Discontinue</label>
            <div class="col-sm-1">
                <input id="menu2Check" class="form-control" type="checkbox">
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    $('#menu2daterangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY',
        }
    });

    //Fungsi isi berurutan
    $('#menu2Div2Input').on('focus',function(){
        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
    });
    $('#menu2Dep1Input').on('focus',function(){
        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
        else if($('#menu2Div2Input').val() == ''){
            $('#menu2Div2Input').focus();
        }
    });
    $('#menu2Dep2Input').on('focus',function(){
        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
        else if($('#menu2Div2Input').val() == ''){
            $('#menu2Div2Input').focus();
        }
        else if($('#menu2Dep1Input').val() == ''){
            $('#menu2Dep1Input').focus();
        }
    });
    $('#menu2Kat1Input').on('focus',function(){
        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
        else if($('#menu2Div2Input').val() == ''){
            $('#menu2Div2Input').focus();
        }
        else if($('#menu2Dep1Input').val() == ''){
            $('#menu2Dep1Input').focus();
        }
        else if($('#menu2Dep2Input').val() == ''){
            $('#menu2Dep2Input').focus();
        }
    });
    $('#menu2Kat2Input').on('focus',function(){
        if($('#menu2Div1Input').val() == ''){
            $('#menu2Div1Input').focus();
        }
        else if($('#menu2Div2Input').val() == ''){
            $('#menu2Div2Input').focus();
        }
        else if($('#menu2Dep1Input').val() == ''){
            $('#menu2Dep1Input').focus();
        }
        else if($('#menu2Dep2Input').val() == ''){
            $('#menu2Dep2Input').focus();
        }
        else if($('#menu2Kat1Input').val() == ''){
            $('#menu2Kat1Input').focus();
        }
    });

    $('#menu2Div1Input').on('change',function(){
        if($('#menu2Div1Input').val() == ''){
            $('#menu2BtnDiv2').prop("hidden",true);
            $('#menu2Div2Input').val('').change();
            $('#menu2Dep1Input').val('').change();
            $('#menu2Dep2Input').val('').change();
            $('#menu2Kat1Input').val('').change();
            $('#menu2Kat2Input').val('').change();

            $('#menu2Div1Desk').val('');
            $('#menu2Div2Desk').val('');
            $('#menu2Dep1Desk').val('');
            $('#menu2Dep2Desk').val('');
            $('#menu2Kat1Desk').val('');
            $('#menu2Kat2Desk').val('');

            $('#minDep').val('').change();
        }else{
            let index = checkDivExist($('#menu2Div1Input').val());
            if(index){
                $('#menu2Div1Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));
                $('#minDep').val($('#menu2Div1Input').val()).change();
                $('#menu2BtnDiv2').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                $('#minDep').val('').change();
                $('#menu2Div1Input').val('').change().focus();
            }
        }
    });
    $('#menu2Div2Input').on('change',function(){
        if($('#menu2Div2Input').val() == ''){
            $('#menu2BtnDep1').prop("hidden",true);
            $('#menu2Dep1Input').val('').change();
            $('#menu2Dep2Input').val('').change();
            $('#menu2Kat1Input').val('').change();
            $('#menu2Kat2Input').val('').change();

            $('#menu2Div2Desk').val('');
            $('#menu2Dep1Desk').val('');
            $('#menu2Dep2Desk').val('');
            $('#menu2Kat1Desk').val('');
            $('#menu2Kat2Desk').val('');

            $('#maxDep').val('').change();
        }else{
            let index = checkDivExist($('#menu2Div2Input').val());
            if(index){
                $('#menu2Div2Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));
                $('#maxDep').val($('#menu2Div2Input').val()).change();
                $('#menu2BtnDep1').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                $('#maxDep').val('').change();
                $('#menu2Div2Input').val('').change();
            }
        }
    });
    $('#menu2Dep1Input').on('change',function(){
        if($('#menu2Dep1Input').val() == ''){
            $('#menu2BtnDep2').prop("hidden",true);
            $('#menu2Dep2Input').val('').change();
            $('#menu2Kat1Input').val('').change();
            $('#menu2Kat2Input').val('').change();

            $('#menu2Dep1Desk').val('');
            $('#menu2Dep2Desk').val('');
            $('#menu2Kat1Desk').val('');
            $('#menu2Kat2Desk').val('');

            $('#minKat').val('').change();
        }else{
            let index = checkDepExist($('#menu2Dep1Input').val());
            if(index){
                $('#menu2Dep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));
                $('#minKat').val($('#menu2Dep1Input').val()).change();
                $('#menu2BtnDep2').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
                $('#minKat').val('').change();
                $('#menu2Dep1Input').val('').change();
            }
        }
    });
    $('#menu2Dep2Input').on('change',function(){
        if($('#menu2Dep2Input').val() == ''){
            $('#menu2BtnKat1').prop("hidden",true);
            $('#menu2Kat1Input').val('').change();
            $('#menu2Kat2Input').val('').change();

            $('#menu2Dep2Desk').val('');
            $('#menu2Kat1Desk').val('');
            $('#menu2Kat2Desk').val('');

            $('#maxKat').val('').change();
        }else{
            let index = checkDepExist($('#menu2Dep2Input').val());
            if(index){
                $('#menu2Dep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));
                $('#maxKat').val($('#menu2Dep2Input').val()).change();
                $('#menu2BtnKat1').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');
                $('#maxKat').val('').change();
                $('#menu2Dep2Input').val('').change();
            }
        }
    });
    $('#menu2Kat1Input').on('change',function(){
        if($('#menu2Kat1Input').val() == ''){
            $('#menu2BtnKat2').prop("hidden",true);
            $('#menu2Kat2Input').val('').change();

            $('#menu2Kat1Desk').val('');
            $('#menu2Kat2Desk').val('');
        }else{
            let index = checkKatExist($('#menu2Kat1Input').val());
            if(index){
                $('#menu2Kat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
                // $('#minKat').val($('#menu2Kat1Input').val()).change();
                $('#menu2BtnKat2').prop("hidden",false);
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menu2Kat1Input').val('').change();
            }
        }
    });
    $('#menu2Kat2Input').on('change',function(){
        if($('#menu2Kat2Input').val() == ''){
            $('#menu2Kat2Desk').val('');
        }else{
            //code here
            let index = checkKatExist($('#menu2Kat2Input').val());
            if(index){
                $('#menu2Kat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menu2Kat2Input').val('').change();
            }
        }
    });

    function Menu2Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        // let namadivisi = val.children().first().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Div1":
                $('#menu2Div1Input').val(kode).change();
                // $('#menu2Div1Desk').val(namadivisi);
                $('#minDep').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu2Div1Input').focus();
                }, 10);

                break;
            case "Div2":
                $('#menu2Div2Input').val(kode).change();
                // $('#menu2Div2Desk').val(namadivisi);
                $('#maxDep').val(kode).change();
                setTimeout(function() {
                    $('#menu2Div2Input').focus();
                }, 10);
                break;
            case "Dep1":
                $('#menu2Dep1Input').val(kode).change();
                // $('#menu2Div2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menu2Dep1Input').focus();
                }, 10);
                break;
            case "Dep2":
                $('#menu2Dep2Input').val(kode).change();
                // $('#menu2Div2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menu2Dep2Input').focus();
                }, 10);
                break;
            case "Kat1":
                $('#menu2Kat1Input').val(kode).change();
                setTimeout(function() {
                    $('#menu2Kat1Input').focus();
                }, 10);
                break;
            case "Kat2":
                $('#menu2Kat2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu2Kat2Input').focus();
                }, 10);
                break;
        }
    }
</script>
