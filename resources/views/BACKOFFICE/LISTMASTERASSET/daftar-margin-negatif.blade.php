{{--ASSET LIST MASTER--}}
{{-- DAFTAR MARGIN NEGATIF --}}

<div>
    <fieldset class="card border-dark">
{{--        <legend class="w-auto ml-5">Daftar Margin Negatif</legend>--}}
        <br>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu3Div1Input" class="form-control" type="text">
                <button id="menu3BtnDiv1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal">
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu3Div1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Divisi</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu3Div2Input" class="form-control" type="text">
                <button id="menu3BtnDiv2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#divModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu3Div2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu3Dep1Input" class="form-control" type="text">
                <button id="menu3BtnDep1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#depModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu3Dep1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Dept</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu3Dep2Input" class="form-control" type="text">
                <button id="menu3BtnDep2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#depModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu3Dep2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Mulai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu3Kat1Input" class="form-control" type="text">
                <button id="menu3BtnKat1" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#katModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu3Kat1Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Sampai Kat</label>
            <div class="col-sm-3 buttonInside">
                <input id="menu3Kat2Input" class="form-control" type="text">
                <button id="menu3BtnKat2" type="button" class="btn btn-lov p-0" data-toggle="modal"
                        data-target="#katModal" hidden>
                    <img src="{{ (asset('image/icon/help.png')) }}" width="30px">
                </button>
            </div>
            <div class="col-sm-4">
                <input id="menu3Kat2Desk" class="form-control" type="text" disabled>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Urut (SORT) Atas</label>
            <div class="col-sm-6">
                <select class="form-control" id="menu3SortBy">
                    <option value="1">1. DIV+DEPT+KATEGORI+KODE</option>
                    <option value="2">2. DIV+DEPT+KATEGORI+NAMA</option>
                    <option value="3">3. NAMA</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 text-right col-form-label">Tag</label>
            <div class="col-sm-1">
                <input id="menu3Tag1" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menu3Tag2" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menu3Tag3" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menu3Tag4" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menu3Tag5" class="form-control" type="text">
            </div>
            <div class="col-sm-1">
                <input id="menu3Tag6" class="form-control" type="text">
            </div>
        </div>
        <br>
    </fieldset>
</div>

<script>
    $('#menu3daterangepicker').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {
            format: 'DD/MM/YYYY',
        }
    });

    //Fungsi isi berurutan
    $('#menu3Div2Input').on('focus',function(){
        if($('#menu3Div1Input').val() == ''){
            $('#menu3Div1Input').focus();
        }
    });
    $('#menu3Dep1Input, #menu3BtnDep1').on('focus',function(){
        $('#minDep').val($('#menu3Div1Input').val());
        $('#maxDep').val($('#menu3Div1Input').val()).change();

        if($('#menu3Div1Input').val() == ''){
            $('#menu3Div1Input').focus();
        }
        else if($('#menu3Div2Input').val() == ''){
            $('#menu3Div2Input').focus();
        }
    });
    $('#menu3Dep2Input, #menu3BtnDep2').on('focus',function(){
        $('#minDep').val($('#menu3Div2Input').val());
        $('#maxDep').val($('#menu3Div2Input').val()).change();

        if($('#menu3Div1Input').val() == ''){
            $('#menu3Div1Input').focus();
        }
        else if($('#menu3Div2Input').val() == ''){
            $('#menu3Div2Input').focus();
        }
        else if($('#menu3Dep1Input').val() == ''){
            $('#menu3Dep1Input').focus();
        }
    });
    $('#menu3Kat1Input, #menu3BtnKat1').on('focus',function(){
        $('#minKat').val($('#menu3Dep1Input').val());
        $('#maxKat').val($('#menu3Dep1Input').val()).change();

        if($('#menu3Div1Input').val() == ''){
            $('#menu3Div1Input').focus();
        }
        else if($('#menu3Div2Input').val() == ''){
            $('#menu3Div2Input').focus();
        }
        else if($('#menu3Dep1Input').val() == ''){
            $('#menu3Dep1Input').focus();
        }
        else if($('#menu3Dep2Input').val() == ''){
            $('#menu3Dep2Input').focus();
        }
    });
    $('#menu3Kat2Input, #menu3BtnKat2').on('focus',function(){
        $('#minKat').val($('#menu3Dep2Input').val());
        $('#maxKat').val($('#menu3Dep2Input').val()).change();

        if($('#menu3Div1Input').val() == ''){
            $('#menu3Div1Input').focus();
        }
        else if($('#menu3Div2Input').val() == ''){
            $('#menu3Div2Input').focus();
        }
        else if($('#menu3Dep1Input').val() == ''){
            $('#menu3Dep1Input').focus();
        }
        else if($('#menu3Dep2Input').val() == ''){
            $('#menu3Dep2Input').focus();
        }
        else if($('#menu3Kat1Input').val() == ''){
            $('#menu3Kat1Input').focus();
        }
    });

    $('#menu3Div1Input').on('change',function(){
        $('#menu3Div2Input').val('').change();
        $('#menu3Dep1Input').val('').change();
        $('#menu3Dep2Input').val('').change();
        $('#menu3Kat1Input').val('').change();
        $('#menu3Kat2Input').val('').change();

        $('#menu3Div1Desk').val('');
        $('#menu3Div2Desk').val('');
        $('#menu3Dep1Desk').val('');
        $('#menu3Dep2Desk').val('');
        $('#menu3Kat1Desk').val('');
        $('#menu3Kat2Desk').val('');
        if($('#menu3Div1Input').val() == ''){
            $('#menu3BtnDiv2').prop("hidden",true);


            $('#minDep').val('').change();
        }else{
            let index = checkDivExist($('#menu3Div1Input').val());
            if(index){
                $('#menu3Div1Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menu3BtnDiv2').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');
                //$('#minDep').val('').change();
                $('#menu3Div1Input').val('').change().focus();
            }
        }
    });
    $('#menu3Div2Input').on('change',function(){
        $('#menu3Dep1Input').val('').change();
        $('#menu3Dep2Input').val('').change();
        $('#menu3Kat1Input').val('').change();
        $('#menu3Kat2Input').val('').change();

        $('#menu3Div2Desk').val('');
        $('#menu3Dep1Desk').val('');
        $('#menu3Dep2Desk').val('');
        $('#menu3Kat1Desk').val('');
        $('#menu3Kat2Desk').val('');
        if($('#menu3Div2Input').val() == ''){
            $('#menu3BtnDep1').prop("hidden",true);


            $('#maxDep').val('').change();
        }else{
            let index = checkDivExist($('#menu3Div2Input').val());
            if(index){
                $('#menu3Div2Desk').val(tableDivisi.row(index-1).data()['div_namadivisi'].replace(/&amp;/g, '&'));

                $('#menu3BtnDep1').prop("hidden",false);
            }else{
                swal('', "Kode Divisi tidak terdaftar", 'warning');

                $('#menu3Div2Input').val('').change();
            }
        }
    });
    $('#menu3Dep1Input').on('change',function(){
        $('#menu3Dep2Input').val('').change();
        $('#menu3Kat1Input').val('').change();
        $('#menu3Kat2Input').val('').change();

        $('#menu3Dep1Desk').val('');
        $('#menu3Dep2Desk').val('');
        $('#menu3Kat1Desk').val('');
        $('#menu3Kat2Desk').val('');
        if($('#menu3Dep1Input').val() == ''){
            $('#menu3BtnDep2').prop("hidden",true);


            $('#minKat').val('').change();
        }else{
            let index = checkDepExist($('#menu3Dep1Input').val());
            if(index){
                $('#menu3Dep1Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menu3BtnDep2').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');

                $('#menu3Dep1Input').val('').change();
            }
        }
    });
    $('#menu3Dep2Input').on('change',function(){
        $('#menu3Kat1Input').val('').change();
        $('#menu3Kat2Input').val('').change();

        $('#menu3Dep2Desk').val('');
        $('#menu3Kat1Desk').val('');
        $('#menu3Kat2Desk').val('');
        if($('#menu3Dep2Input').val() == ''){
            $('#menu3BtnKat1').prop("hidden",true);


            $('#maxKat').val('').change();
        }else{
            let index = checkDepExist($('#menu3Dep2Input').val());
            if(index){
                $('#menu3Dep2Desk').val(tableDepartemen.row(index-1).data()['dep_namadepartement'].replace(/&amp;/g, '&'));

                $('#menu3BtnKat1').prop("hidden",false);
            }else{
                swal('', "Kode Departement tidak terdaftar", 'warning');

                $('#menu3Dep2Input').val('').change();
            }
        }
    });
    $('#menu3Kat1Input').on('change',function(){
        $('#menu3Kat2Input').val('').change();

        $('#menu3Kat1Desk').val('');
        $('#menu3Kat2Desk').val('');
        if($('#menu3Kat1Input').val() == ''){
            $('#menu3BtnKat2').prop("hidden",true);

        }else{
            let index = checkKatExist($('#menu3Kat1Input').val());
            if(index){
                $('#menu3Kat1Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
                // $('#minKat').val($('#menu3Kat1Input').val()).change();
                $('#menu3BtnKat2').prop("hidden",false);
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menu3Kat1Input').val('').change();
            }
        }
    });
    $('#menu3Kat2Input').on('change',function(){
        $('#menu3Kat2Desk').val('');
        if($('#menu3Kat2Input').val() == ''){
            //code here
        }else{
            //code here
            let index = checkKatExist($('#menu3Kat2Input').val());
            if(index){
                $('#menu3Kat2Desk').val(tableKategori.row(index-1).data()['kat_namakategori'].replace(/&amp;/g, '&'));
            }else{
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                // $('#minKat').val('').change();
                $('#menu3Kat2Input').val('').change();
            }
        }
    });

    //Tag berurutan
    $('#menu3Tag2').on('focus',function(){
        if($('#menu3Tag1').val() == ''){
            $('#menu3Tag1').focus();
        }
    });
    $('#menu3Tag3').on('focus',function(){
        if($('#menu3Tag1').val() == ''){
            $('#menu3Tag1').focus();
        }else if($('#menu3Tag2').val() == ''){
            $('#menu3Tag2').focus();
        }
    });
    $('#menu3Tag4').on('focus',function(){
        if($('#menu3Tag1').val() == ''){
            $('#menu3Tag1').focus();
        }else if($('#menu3Tag2').val() == ''){
            $('#menu3Tag2').focus();
        }else if($('#menu3Tag3').val() == ''){
            $('#menu3Tag3').focus();
        }
    });
    $('#menu3Tag5').on('focus',function(){
        if($('#menu3Tag1').val() == ''){
            $('#menu3Tag1').focus();
        }else if($('#menu3Tag2').val() == ''){
            $('#menu3Tag2').focus();
        }else if($('#menu3Tag3').val() == ''){
            $('#menu3Tag3').focus();
        }else if($('#menu3Tag4').val() == ''){
            $('#menu3Tag4').focus();
        }
    });
    $('#menu3Tag6').on('focus',function(){
        if($('#menu3Tag1').val() == ''){
            $('#menu3Tag1').focus();
        }else if($('#menu3Tag2').val() == ''){
            $('#menu3Tag2').focus();
        }else if($('#menu3Tag3').val() == ''){
            $('#menu3Tag3').focus();
        }else if($('#menu3Tag4').val() == ''){
            $('#menu3Tag4').focus();
        }else if($('#menu3Tag5').val() == ''){
            $('#menu3Tag5').focus();
        }
    });
    $('#menu3Tag1').on('change',function(){
        $('#menu3Tag2').val('');
        $('#menu3Tag3').val('');
        $('#menu3Tag4').val('');
        $('#menu3Tag5').val('');
        $('#menu3Tag6').val('');
    });
    $('#menu3Tag2').on('change',function(){
        $('#menu3Tag3').val('');
        $('#menu3Tag4').val('');
        $('#menu3Tag5').val('');
        $('#menu3Tag6').val('');
    });
    $('#menu3Tag3').on('change',function(){
        $('#menu3Tag4').val('');
        $('#menu3Tag5').val('');
        $('#menu3Tag6').val('');
    });
    $('#menu3Tag4').on('change',function(){
        $('#menu3Tag5').val('');
        $('#menu3Tag6').val('');
    });
    $('#menu3Tag5').on('change',function(){
        $('#menu3Tag6').val('');
    });

    function menu3Choose(val){
        //val dan curson didapat dari "list-master.blade.php"
        let kode = val.children().first().next().text();
        // let namadivisi = val.children().first().text();
        let index = cursor.substr(8,4);
        switch (index){
            case "Div1":
                $('#menu3Div1Input').val(kode).change();
                // $('#menu3Div1Desk').val(namadivisi);
                $('#minDep').val(kode).change();
                setTimeout(function() { //tidak tau kenapa harus selama 10milisecond baru bisa pindah focus
                    $('#menu3Div1Input').focus();
                }, 10);

                break;
            case "Div2":
                $('#menu3Div2Input').val(kode).change();
                // $('#menu3Div2Desk').val(namadivisi);
                $('#maxDep').val(kode).change();
                setTimeout(function() {
                    $('#menu3Div2Input').focus();
                }, 10);
                break;
            case "Dep1":
                $('#menu3Dep1Input').val(kode).change();
                // $('#menu3Div2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menu3Dep1Input').focus();
                }, 10);
                break;
            case "Dep2":
                $('#menu3Dep2Input').val(kode).change();
                // $('#menu3Div2Desk').val(namadivisi);
                setTimeout(function() {
                    $('#menu3Dep2Input').focus();
                }, 10);
                break;
            case "Kat1":
                $('#menu3Kat1Input').val(kode).change();
                setTimeout(function() {
                    $('#menu3Kat1Input').focus();
                }, 10);
                break;
            case "Kat2":
                $('#menu3Kat2Input').val(kode).change();
                setTimeout(function() {
                    $('#menu3Kat2Input').focus();
                }, 10);
                break;
        }
    }
    function menu3Clear(){
        $('#menu3Div1Input').val('').change();
        $('#menu3Div1Desk').val('');
        $('#menu3Div2Desk').val('');
        $('#menu3Dep1Desk').val('');
        $('#menu3Dep2Desk').val('');
        $('#menu3Kat1Desk').val('');
        $('#menu3Kat2Desk').val('');
        $('#menu3Tag1').val('').change();
        $('#menu3SortBy').val(1);
    }
    function menu3Cetak(){
        //DIV & DEP & KAT
        let temp = '';
        let div1 = $('#menu3Div1Input').val();
        let div2 = $('#menu3Div2Input').val();
        let dep1 = $('#menu3Dep1Input').val();
        let dep2 = $('#menu3Dep2Input').val();
        let kat1 = $('#menu3Kat1Input').val();
        let kat2 = $('#menu3Kat2Input').val();
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
            $('#minKat').val(dep1);
            $('#maxKat').val(dep1);
            if(checkKatExist(kat1) == false){
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                return false;
            }
        }
        if(kat2 != ''){
            //limit kategori berdasarkan departemen, tak perlu trigger fungsi change, karena bukan untuk tampilan
            $('#minKat').val(dep2);
            $('#maxKat').val(dep2);
            if(checkKatExist(kat2) == false){
                swal('', "Kode Kategori tidak terdaftar", 'warning');
                return false;
            }
        }
        if(div1 != '' || div2 != ''){ // karena dep dan kat tak mungkin isi tanpa isi div, maka hanya perlu 1 kondisi ini,
            if(parseInt(div1) > parseInt(div2)){ // karena nilai dep1 dan ka1 berdasarkan div1, maka ganti cek div1 saja, sama dengan dep2 dan kat2
                temp = div1;
                div1 = div2;
                div2 = temp;
                temp = dep1;
                dep1 = dep2;
                dep2 = temp;
                temp = kat1;
                kat1 = kat2;
                kat2 = temp;
            }
        }

        // TAG
        let tag1 = $('#menu3Tag1').val();
        let tag2 = $('#menu3Tag2').val();
        let tag3 = $('#menu3Tag3').val();
        let tag4 = $('#menu3Tag4').val();
        let tag5 = $('#menu3Tag5').val();
        let tag6 = $('#menu3Tag6').val();
        let ptag = '';
        if(tag1 != '' && tag2 != '' && tag3 != '' && tag4 != '' && tag5 != ''){
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
            if(tag6 != ''){
                ptag = ptag+",'"+tag6+"'";
            }else{
                ptag = ptag+",'b'";
            }
        }

        //sortby
        let sort = $('#menu3SortBy').val();

        //PRINT
        window.open(`{{ url()->current() }}/print-daftar-margin-negatif?div1=${div1}&div2=${div2}&dep1=${dep1}&dep2=${dep2}&kat1=${kat1}&kat2=${kat2}&ptag=${ptag}&sort=${sort}`, '_blank');
    }
</script>
